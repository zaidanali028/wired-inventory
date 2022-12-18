<?php

namespace App\Http\Livewire\Admin\Sections;

use Livewire\Component;
use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Sections as SectionsModel;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;


class AddNewSection extends Component
{
    // events triggered from js
    protected $listeners=['confirm_section_del_all'=>'confirmSectionDelAll','confirm_section_delete'=>'confirmSectionDelete'];
    use  WithPagination;
    protected $paginationTheme='bootstrap';
    // allow livewire pagination
    public $admin_details;
    public $inputs=[];

    public $section_details;
    public $addNewSection=false;
    public $section_id;
    public $btn_text;
    public $delete_sec_id;






    public function newSection(){
        $this->addNewSection=true;
        $this->inputs= [];
        $this->dispatchBrowserEvent('show-add-section-modal');
               // triggering the show-add-section-modal to show  modal
    $this->btn_text=$this->addNewSection==true?'Save':'Save Changes';


    }

    public function deleteAllSections(){
        $this->dispatchBrowserEvent('show_section_del_confirm');
        // invoking this to show confirm with js in customjs

     }

     public function confirmSectionDelAll (){
        // deleting all sub categories
        SectionsModel::query()->delete();
        redirect()->back();
        $this->dispatchBrowserEvent('delete_comfirmation',["success_msg"=>'Cleared All Sections Successfully']);


     }
    public function editSection($section_id){
        $this->section_id=$section_id;
    $this->btn_text=$this->addNewSection==true?'Save':'Save Changes';

        $this->addNewSection=false;
        $this->dispatchBrowserEvent('show-add-section-modal');
               // triggering the show-add-section-modal to show  modal

        // $this->section_details = SectionsModel::where('id', $section_id)->first()->toArray();
        $this->inputs= SectionsModel::where('id', $section_id)->first()->toArray();

    }

    public function updateSection(){
        $validated_data=Validator::make($this->inputs,[
            'name'=>'required',
            'status'=>'required'


        ])->validate();
        SectionsModel::where('id', $this->section_id)->update($validated_data);
        $this->dispatchBrowserEvent('hide-add-section-modal',["success_msg"=>' Section Updated Successfully']);



    }
    public function submitAddNewSection(){
        // dd($this->inputs);
        $validated_data=Validator::make($this->inputs,[
            'name'=>'required',
            'status'=>'required'


        ])->validate();

        SectionsModel::create($validated_data);
        redirect()->back();
        $this->dispatchBrowserEvent('hide-add-section-modal',["success_msg"=>'New Section Added Successfully']);


    }

    public function onCancel(){
        $this->dispatchBrowserEvent('hide-add-section-modal',['is_cancel'=>true]);
    }

    public function deleteSectionConfirm($delete_sec_id){
        $this->delete_sec_id=$delete_sec_id;
        $this->dispatchBrowserEvent('show_section_del_confirm');

    }

    public function confirmSectionDelete(){
        $section_to_delete=SectionsModel::findOrFail($this->delete_sec_id);
        $section_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation',['success_msg'=>'Section Deleted SuccessFully!']);



    }
    public function changeSectionStatus($section_id,$current_status){

        $new_status=$current_status==1?0:1;
        $section_details = SectionsModel::query();
        $section_details = $section_details->where('id', $section_id)->update(['status' =>$new_status]);
        redirect()->back();
        $this->dispatchBrowserEvent('section_status_update',["success_msg"=>'Section Status Updated Successfully']);


    }
    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        $sections=SectionsModel::latest()->paginate(15);
        // dd($sections->links());










        return view('livewire.admin.sections.add-new-section',[
            'sections_'=>$sections
        ]);
    }
}
