<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Auth;

class SidebarWired extends Component
{
    public $admin_details;


    public function render()
    {
        $this->admin_details = Auth::guard('admin')->user()?AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray():[];

        return view('livewire.admin.sidebar-wired');
    }
}
