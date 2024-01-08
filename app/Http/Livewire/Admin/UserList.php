<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;
use Hash;

class UserList extends Component
{
    public $searchTerm;

    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->searchTerm.'%')->orWhere('email', 'like', '%'.$this->searchTerm.'%')->get();

        return view('livewire.admin.user-list', ['users'=>$users])->layout('livewire.layouts.base');
    }
}
