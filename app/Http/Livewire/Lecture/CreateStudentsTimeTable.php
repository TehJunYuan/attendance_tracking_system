<?php

namespace App\Http\Livewire\Lecture;

use App\Models\User;
use Livewire\Component;
use App\Models\ClassTime;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class CreateStudentsTimeTable extends Component
{
    public $user_id, $classtime_id;

    public $timetable_delete_id, $timetable_edit_id;

    public $view_classtime_id, $view_user_id;

    public $searchTerm;

    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'user_id' => 'required',
            'classtime_id' => 'required',
            'lecture_id' => 'required',
        ]);
    }

    public function mount()
    {
        // Check if the user is authenticated before setting the lecture_id
        if (Auth::check()) {
            $this->lecture_id = Auth::user()->id;
        }
    }

    public function storeTimeTableData()
    {
        //on form submit validation
        $this->validate([
            'user_id' => 'required',
            'classtime_id' => 'required',
            'lecture_id' => 'required',
        ]);

        //Add timetable Data
        $timetable = new Timetable();
        $timetable->user_id = $this->user_id;
        $timetable->classtime_id = $this->classtime_id;
        $timetable->lecture_id = $this->lecture_id;

        $timetable->save();

        session()->flash('message', 'New time Table has been added successfully');

        //For hide modal after add timetable success
    }

    public function resetInputs()
    {
        $this->user_id = '';
        $this->classtime_id = '';
        $this->timetable_edit_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editTimetables($id)
    {
        $timetable = Timetable::where('id', $id)->first();

        $this->timetable_edit_id = $timetable->id;
        $this->user_id = $timetable->user_id;
        $this->classtime_id = $timetable->classtime_id;
        $this->dispatchBrowserEvent('show-edit-timetable-modal');
    }
    
    public function editTimetableData()
    {
        //on form submit validation
        $this->validate([
            'user_id' => 'required',
            'classtime_id' => 'required',
        ]);

        $timetable = Timetable::where('id', $this->timetable_edit_id)->first();
        $timetable->user_id = $this->user_id;
        $timetable->classtime_id = $this->classtime_id;
        $timetable->lecture_id = $this->lecture_id;

        $timetable->save();

        session()->flash('message', 'Student Class Time has been updated successfully');

        $this->resetInputs();
        //For hide modal after add timetable success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->timetable_delete_id = $id; //timetable id

        $this->dispatchBrowserEvent('show-delete-timetable-modal');
    }

    public function deleteTimetableData()
    {
        $timetable = Timetable::where('id', $this->timetable_delete_id)->first();
        $timetable->delete();

        session()->flash('message', 'Student Class Time has been deleted successfully');

        $this->dispatchBrowserEvent('close-modal');

        $this->timetable_delete_id = '';
    }

    public function cancel()
    {
        $this->timetable_delete_id = '';
    }

    public function render()
    {
        $classtimes = ClassTime::get();
        $students = User::where('role','=','0')->get();
        $timetables = Timetable::where('lecture_id',Auth::user()->id)->get();
        return view('livewire.lecture.create-students-time-table', ['timetables'=>$timetables,'classtimes'=>$classtimes, 'students'=>$students])->layout('livewire.layouts.base');
    }
}
