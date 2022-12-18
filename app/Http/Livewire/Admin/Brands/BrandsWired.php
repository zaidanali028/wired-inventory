<?php

namespace App\Http\Livewire\Admin\Brands;


use Livewire\Component;
use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Brands as BrandsModel;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class BrandsWired extends Component
{


    protected $listeners=['confirm_brand_del_all'=>'confirmbrandDelAll','confirm_brand_delete'=>'confirmbrandDelete'];
    use  WithPagination;
    protected $paginationTheme='bootstrap';
    // allow livewire pagination
    public $admin_details;
    public $inputs=[];

    public $brand_details;
    public $addNewbrand=false;
    public $brand_id;
    public $btn_text;
    public $delete_sec_id;






    public function newbrand(){
        $this->addNewbrand=true;
        $this->inputs= [];
        $this->dispatchBrowserEvent('show-add-brand-modal');
               // triggering the show-add-brand-modal to show  modal
    $this->btn_text=$this->addNewbrand==true?'Save':'Save Changes';


    }

    public function deleteAllbrands(){
        $this->dispatchBrowserEvent('show_brand_del_confirm');
        // invoking this to show confirm with js in customjs

     }

     public function confirmbrandDelAll (){
        // deleting all sub categories
        BrandsModel::query()->delete();
        redirect()->back();
        $this->dispatchBrowserEvent('delete_comfirmation',["success_msg"=>'Cleared All brands Successfully']);


     }
    public function editBrand($brand_id){
        $this->brand_id=$brand_id;
    $this->btn_text=$this->addNewbrand==true?'Save':'Save Changes';

        $this->addNewbrand=false;
        $this->dispatchBrowserEvent('show-add-brand-modal');
               // triggering the show-add-brand-modal to show  modal

        // $this->brand_details = BrandsModel::where('id', $brand_id)->first()->toArray();
        $this->inputs= BrandsModel::where('id', $brand_id)->first()->toArray();

    }
   
    public function updatebrand(){
        $validated_data=Validator::make($this->inputs,[
            'name'=>'required',
            'status'=>'required'


        ])->validate();
        BrandsModel::where('id', $this->brand_id)->update($validated_data);
        $this->dispatchBrowserEvent('hide-add-brand-modal',["success_msg"=>' brand Updated Successfully']);



    }
    public function submitAddNewbrand(){
        // dd($this->inputs);
        $validated_data=Validator::make($this->inputs,[
            'name'=>'required',
            'status'=>'required'


        ])->validate();

        BrandsModel::create($validated_data);
        redirect()->back();
        $this->dispatchBrowserEvent('hide-add-brand-modal',["success_msg"=>'New brand Added Successfully']);


    }

    public function deletebrandConfirm($delete_sec_id){
        $this->delete_sec_id=$delete_sec_id;
        $this->dispatchBrowserEvent('show_brand_del_confirm');

    }

    public function confirmbrandDelete(){
        $brand_to_delete=BrandsModel::findOrFail($this->delete_sec_id);
        $brand_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation',['success_msg'=>'brand Deleted SuccessFully!']);



    }
    public function changebrandStatus($brand_id,$current_status){

        $new_status=$current_status==1?0:1;
        $brand_details = BrandsModel::query();
        $brand_details = $brand_details->where('id', $brand_id)->update(['status' =>$new_status]);
        redirect()->back();
        $this->dispatchBrowserEvent('brand_status_update',["success_msg"=>'brand Status Updated Successfully']);


    }

    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        $brands=BrandsModel::latest()->paginate(15);


        return view('livewire.admin.brands.brands-wired')->with(compact('brands'));
    }
}
