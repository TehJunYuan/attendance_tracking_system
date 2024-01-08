<?php

namespace App\Http\Livewire\Lecture;

use App\Models\Course;
use Livewire\Component;
use App\Models\Classroom;
use App\Models\Classtime;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;

class CreateClassTime extends Component
{

    public $view_classtime_id, $view_classtime_course, $view_classtime_classroom ,$view_classtime_start ,$view_classtime_day , $view_classtime_end, $view_classtime_hour;

    public $course_id, $classroom_id, $day, $start, $end, $lecture_id;

    public $searchTerm;

        //Input fields on update validation
        public function updated($fields)
        {
            $this->validateOnly($fields, [
                'course_id' => 'required',
                'classroom_id' => 'required',
                'day' => 'required',
                'start' => 'required',
                'end' => 'required',
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
    
        public function storeClassTimeData()
        {
            //on form submit validation
            $this->validate([
                'course_id' => 'required',
                'classroom_id' => 'required',
                'day' => 'required',
                'start' => 'required',
                'end' => 'required',
                'lecture_id' => 'required',
            ]);

            //Add classtime Data
            $classtime = new Classtime();
            $classtime->course_id = $this->course_id;
            $classtime->classroom_id = $this->classroom_id;
            $classtime->day = $this->day;
            $classtime->start = $this->start;
            $classtime->end = $this->end;
            $classtime->lecture_id = $this->lecture_id;
            $classtime->save();
    
            session()->flash('message', 'New Classtime has been added successfully');
    
            $this->course_id = '';
            $this->classroom_id = '';
            $this->day = '';
            $this->start = '';
            $this->end = '';
    
            //For hide modal after add classtime success
            $this->dispatchBrowserEvent('close-modal');
        }
    
        public function resetInputs()
        {
            $this->course_id = '';
            $this->classroom_id = '';
            $this->day = '';
            $this->start = '';
            $this->end = '';
            $this->classtime_edit_id = '';
        }
    
        public function close()
        {
            $this->resetInputs();
        }
    
        public function editClassTimes($id)
        {
            $classtime = Classtime::where('id', $id)->first();
    
            $this->classtime_edit_id = $classtime->id;
            $this->course_id = $classtime->course_id;
            $this->classroom_id = $classtime->classroom_id;
            $this->day = $classtime->day;
            $this->start = $classtime->start;
            $this->end = $classtime->end;
            
            $this->dispatchBrowserEvent('show-edit-classtime-modal');
        }
        
        public function editClassTimeData()
        {
            //on form submit validation
            $this->validate([
                'course_id' => 'required',
                'classroom_id' => 'required',
                'day' => 'required',
                'start' => 'required',
                'end' => 'required',
            ]);
    
            $classtime = Classtime::where('id', $this->classtime_edit_id)->first();
            
            $classtime->course_id = $this->course_id;
            $classtime->classroom_id = $this->classroom_id;
            $classtime->day = $this->day;
            $classtime->start = $this->start;
            $classtime->end = $this->end;
            $classtime->lecture_id = $this->lecture_id;
    
            $classtime->save();
    
            session()->flash('message', 'ClassTime has been updated successfully');
    
            $this->resetInputs();
            //For hide modal after add classtime success
            $this->dispatchBrowserEvent('close-modal');
        }
    
        //Delete Confirmation
        public function deleteConfirmation($id)
        {
            $this->classtime_delete_id = $id; //classtime id
    
            $this->dispatchBrowserEvent('show-delete-classtime-modal');
        }
    
        public function deleteClassTimeData()
        {
            $classtime = Classtime::where('id', $this->classtime_delete_id)->first();
            $classtime->delete();
    
            session()->flash('message', 'ClassTime has been deleted successfully');
    
            $this->dispatchBrowserEvent('close-modal');
    
            $this->classtime_delete_id = '';
        }
    
        public function cancel()
        {
            $this->classtime_delete_id = '';
        }
    
        public function viewClassTimeDetails($id)
        {
            $classtime = Classtime::where('id', $id)->first();
    
            $this->view_classtime_id = $classtime->id;
            $this->view_classtime_course = $classtime->course['name'];
            $this->view_classtime_hour = $classtime->course['hour'];
            $this->view_classtime_classroom = $classtime->classroom['name'];
            $this->view_classtime_start = $classtime->start;
            $this->view_classtime_day = $classtime->day;
            $this->view_classtime_end = $classtime->end;
    
            $this->dispatchBrowserEvent('show-view-classtime-modal');
        }
    
        public function closeViewClassTimeModal()
        {
            $this->view_classtime_id = '';
            $this->view_classtime_course = '';
            $this->view_classtime_classroom = '';
            $this->view_classtime_start = '';
            $this->view_classtime_day = '';
            $this->view_classtime_end = '';
            
            $this->dispatchBrowserEvent('close-modal');
        }

    public function render()
    {
        $classrooms = Classroom::get();
        $courses = Course::get();

        $classtimes = Classtime::where(function ($query) {
            $query->where('start', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('day', 'like', '%' . $this->searchTerm . '%');
        })
        ->where('lecture_id', Auth::user()->id)
        ->get();
        return view('livewire.lecture.create-class-time', ['classtimes'=>$classtimes,'classrooms'=>$classrooms, 'courses'=>$courses])->layout('livewire.layouts.base');
    
    }
}
