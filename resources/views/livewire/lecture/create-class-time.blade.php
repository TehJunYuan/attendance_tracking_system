
<div>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3 style="color: black;"><strong>Class Time Information</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h5 style="float: left;"><strong>All Class Time</strong></h5>
                        <button type="button" class="btn btn-sm btn-primary" style="float: right;"  data-bs-toggle="modal" data-bs-target="#addClassTimeModal">Add New Class</button>
                    </div>

                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}</div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="search" class="form-control w-25" placeholder="search" wire:model="searchTerm" style="float: right;" />
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course</th>
                                    <th>Classroom</th>
                                    <th>Hours</th>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($classtimes->count() > 0)
                                    @foreach ($classtimes as $classtime)
                                        <tr>
                                            <td> {{ $classtime->id }} </td>
                                            <td> {{ $classtime->course['name'] }} </td>
                                            <td> {{ $classtime->classroom['name'] }} </td>
                                            <td> {{ $classtime->course['hour'] }} </td>
                                            <td> {{ $classtime->day }} </td>
                                            <td> {{ $classtime->start }} </td>
                                            <td> {{ $classtime->end }} </td>
                                            <td style="text-align: center;">
                                                <a href="{{ route('attendance',['id'=>$classtime->id]) }}">
                                                    <button class="btn btn-sm btn-primary">Attendance</button>
                                                </a>
                                                <button class="btn btn-sm btn-secondary" wire:click="editClassTimes({{ $classtime->id }})">Edit</button>
                                                <button class="btn btn-sm btn-danger" wire:click="deleteConfirmation({{ $classtime->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" style="text-align: center;"><small>No Class Found</small></td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addClassTimeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addClassTimeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addClassTimeModalLabel">Add New Class Time</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storeClassTimeData">
                        
                        <div class="row mb-3">
                            <label for="course_id" class="col-md-4 col-form-label text-md-end">{{ __('Course') }}</label>
    
                            <div class="col-md-6">
                                <select class="form-select" wire:model="course_id" id="course_id" name="course_id" aria-label="Floating label select example" required>
                                    <option>Please Select the Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="classroom_id" class="col-md-4 col-form-label text-md-end">{{ __('Classroom') }}</label>
    
                            <div class="col-md-6">
                                <select class="form-select" wire:model="classroom_id" id="classroom_id" name="classroom_id" aria-label="Floating label select example" required>
                                    <option>Please Select the Classroom</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                                @error('classroom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="day" class="col-md-4 col-form-label text-md-end">{{ __('Day') }}</label>
    
                            <div class="col-md-6">
                                <input wire:model="day"  id="day" name="day" type="date" class="day form-control shadow-none rounded-0"  value="{{ old('day') }}" required autocomplete="day" autofocus placeholder="Day ...">
                                @error('day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start" class="col-md-4 col-form-label text-md-end">{{ __('Start Time') }}</label>
    
                            <div class="col-md-6">
                                <input wire:model="start"  id="start"  name="start"  type="time" class="start form-control shadow-none rounded-0"  value="{{ old('start') }}" required autocomplete="start" autofocus>
                                @error('start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end" class="col-md-4 col-form-label text-md-end">{{ __('End Time') }}</label>
    
                            <div class="col-md-6">
                                <input wire:model="end"  id="end" name="end"  type="time" class="end form-control shadow-none rounded-0" value="{{ old('end') }}" required autocomplete="end" autofocus>
                                @error('end')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Add Class Time</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editClassTimeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editClassTimeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width:90%">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editClassTimeModalLabel">Edit Class</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputs"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="editClassTimeData">

                        <div class="row mb-3">
                            <label for="course_id" class="col-md-4 col-form-label text-md-end">{{ __('Course') }}</label>
    
                            <div class="col-md-6">
                                <select class="form-select" wire:model="course_id" id="course_id" name="course_id" aria-label="Floating label select example" required>
                                    <option>Please Select the Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="classroom_id" class="col-md-4 col-form-label text-md-end">{{ __('Classroom') }}</label>
    
                            <div class="col-md-6">
                                <select class="form-select" wire:model="classroom_id" id="classroom_id" name="classroom_id" aria-label="Floating label select example" required>
                                    <option>Please Select the Classroom</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                                @error('classroom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="day" class="col-md-4 col-form-label text-md-end">{{ __('Day') }}</label>
    
                            <div class="col-md-6">
                                <input wire:model="day"  id="day" name="day" type="date" class="day form-control shadow-none rounded-0"  value="{{ old('day') }}" required autocomplete="day" autofocus placeholder="Day ...">
                                @error('day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start" class="col-md-4 col-form-label text-md-end">{{ __('Start Time') }}</label>
    
                            <div class="col-md-6">
                                <input wire:model="start"  id="start"  name="start"  type="time" class="start form-control shadow-none rounded-0"  value="{{ old('start') }}" required autocomplete="start" autofocus>
                                @error('start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end" class="col-md-4 col-form-label text-md-end">{{ __('End Time') }}</label>
    
                            <div class="col-md-6">
                                <input wire:model="end"  id="end" name="end"  type="time" class="end form-control shadow-none rounded-0" value="{{ old('end') }}" required autocomplete="end" autofocus>
                                @error('end')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Update Class Time</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteClassTimeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="deleteClassTimeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteClassTimeModalLabel">Delete Class</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you usre? You want to delete this class data!</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" wire:click="deleteClassTimeData()">Yes! Delete</button>
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewClassTimeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Class Time Information</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" wire:click="closeViewClassTimeModal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>

                            <tr>
                                <th>Course: </th>
                                <td>{{ $view_classtime_course }}</td>
                            </tr>

                            <tr>
                                <th>Classroom: </th>
                                <td>{{ $view_classtime_classroom }}</td>
                            </tr>

                            <tr>
                                <th>Hours: </th>
                                <td>{{ $view_classtime_hour }}</td>
                            </tr>

                            <tr>
                                <th>Day: </th>
                                <td>{{ $view_classtime_day }}</td>
                            </tr>

                            <tr>
                                <th>Start Time: </th>
                                <td>{{ $view_classtime_start }}</td>
                            </tr>

                            <tr>
                                <th>End Time: </th>
                                <td>{{ $view_classtime_end }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


@push('scripts')
    <script>
        window.addEventListener('close-modal', event=>{
            $('#addClassTimeModal').modal('hide');
            $('#editClassTimeModal').modal('hide');
            $('#deleteClassTimeModal').modal('hide');
            $('#viewClassTimeModal').modal('hide');
        });

        window.addEventListener('show-edit-classtime-modal', event=>{
            $('#editClassTimeModal').modal('show');
        });

        window.addEventListener('show-delete-classtime-modal', event=>{
            $('#deleteClassTimeModal').modal('show');
        });

        window.addEventListener('show-view-classtime-modal', event =>{
            $('#viewClassTimeModal').modal('show');
        });
    </script>
@endpush