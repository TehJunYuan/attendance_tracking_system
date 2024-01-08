<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Classroom;
use phpDocumentor\Reflection\Types\This;

class CreateClassroom extends Component
{
    public $name;
    public $viewname;
    public $data;
    public $classroom_delete_id;
    public $classroom_edit_id;

    public $view_classroom_name, $view_classroom_id;

    public $searchTerm;
    
    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
        ]);
    }


    public function storeClassroomData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required',
        ]);

        //Add classroom Data
        $classroom = new Classroom();
        $classroom->name = $this->name;

        $classroom->save();

        session()->flash('message', 'New classroom has been added successfully');

        $this->name = '';

        //For hide modal after add classroom success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->classroom_edit_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editClassrooms($id)
    {
        $classroom = Classroom::where('id', $id)->first();

        $this->classroom_edit_id = $classroom->id;
        $this->name = $classroom->name;
        $this->dispatchBrowserEvent('show-edit-classroom-modal');
    }
    
    public function editClassroomData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required',
        ]);

        $classroom = Classroom::where('id', $this->classroom_edit_id)->first();
        $classroom->name = $this->name;

        $classroom->save();

        session()->flash('message', 'Classroom has been updated successfully');

        $this->resetInputs();
        //For hide modal after add classroom success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->classroom_delete_id = $id; //classroom id

        $this->dispatchBrowserEvent('show-delete-classroom-modal');
    }

    public function deleteClassroomData()
    {
        $classroom = Classroom::where('id', $this->classroom_delete_id)->first();
        $classroom->delete();

        session()->flash('message', 'Classroom has been deleted successfully');

        $this->dispatchBrowserEvent('close-modal');

        $this->classroom_delete_id = '';
    }

    public function cancel()
    {
        $this->classroom_delete_id = '';
    }

    public function viewClassroomDetails($id)
    {
        $classroom = Classroom::where('id', $id)->first();

        $this->view_classroom_id = $classroom->id;
        $this->view_classroom_name = $classroom->name;

        $this->dispatchBrowserEvent('show-view-classroom-modal');
    }

    public function closeViewClassroomModal()
    {
        $this->view_classroom_id = '';
        $this->view_classroom_name = '';
        
        $this->dispatchBrowserEvent('close-modal');
    }

    public function render()
    {
        //Get all classrooms
        $this->viewname = Classroom::where('name', 'like', '%'.$this->searchTerm.'%')->get();

        return view('livewire.admin.create-classroom')->layout('livewire.layouts.base');
    }
}
