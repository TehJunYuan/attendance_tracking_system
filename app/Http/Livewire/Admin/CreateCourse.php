<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use phpDocumentor\Reflection\Types\This;

class CreateCourse extends Component
{

    public $name, $hour, $course_delete_id, $course_edit_id;

    public $view_course_name, $view_course_id, $view_course_hour;

    public $searchTerm;


    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'hour' => 'required|numeric',
        ]);
    }


    public function storeCourseData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required',
            'hour' => 'required|numeric',
        ]);

        //Add course Data
        $course = new Course();
        $course->name = $this->name;
        $course->hour = $this->hour;

        $course->save();

        session()->flash('message', 'New course has been added successfully');

        $this->name = '';
        $this->hour = '';

        //For hide modal after add course success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->hour = '';
        $this->course_edit_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editCourses($id)
    {
        $course = Course::where('id', $id)->first();

        $this->course_edit_id = $course->id;
        $this->name = $course->name;
        $this->hour = $course->hour;
        $this->dispatchBrowserEvent('show-edit-course-modal');
    }
    
    public function editCourseData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required',
        ]);

        $course = Course::where('id', $this->course_edit_id)->first();
        $course->name = $this->name;
        $course->hour = $this->hour;


        $course->save();

        session()->flash('message', 'Course has been updated successfully');

        $this->resetInputs();
        //For hide modal after add course success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->course_delete_id = $id; //course id

        $this->dispatchBrowserEvent('show-delete-course-modal');
    }

    public function deleteCourseData()
    {
        $course = Course::where('id', $this->course_delete_id)->first();
        $course->delete();

        session()->flash('message', 'Course has been deleted successfully');

        $this->dispatchBrowserEvent('close-modal');

        $this->course_delete_id = '';
    }

    public function cancel()
    {
        $this->course_delete_id = '';
    }

    public function viewCourseDetails($id)
    {
        $course = Course::where('id', $id)->first();

        $this->view_course_id = $course->id;
        $this->view_course_name = $course->name;
        $this->view_course_hour = $course->hour;

        $this->dispatchBrowserEvent('show-view-course-modal');
    }

    public function closeViewCourseModal()
    {
        $this->view_course_id = '';
        $this->view_course_name = '';
        
        $this->dispatchBrowserEvent('close-modal');
    }


    public function render()
    {

        $courses = Course::where('name', 'like', '%'.$this->searchTerm.'%')->orWhere('hour', 'like', '%'.$this->searchTerm.'%')->get();

        return view('livewire.admin.create-course', ['courses'=>$courses])->layout('livewire.layouts.base');
    }
}
