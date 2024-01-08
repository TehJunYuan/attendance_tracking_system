
<div>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3 style="color: black;"><strong>Student Time Table Information</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h5 style="float: left;"><strong>All Time Table</strong></h5>
                        <button type="button" class="btn btn-sm btn-primary" style="float: right;"  data-bs-toggle="modal" data-bs-target="#addTimeTableModal">Add New Time Table</button>
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
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th>Classroom</th>
                                    <th>Hours</th>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End TIme</th>
                                    <th>Attendance</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($timetables->count() > 0)
                                    @foreach ($timetables as $timetable)
                                    <tr>
                                        <td> {{ $timetable->id }} </td>
                                        <td> {{ $timetable->user['name'] }} </td>
                                        <td> {{ $timetable->classtime['course']->name }}</td>
                                        <td> {{ $timetable->classtime['classroom']->name }}</td>
                                        <td> {{ $timetable->classtime['course']->hour }}</td>
                                        <td> {{ $timetable->classtime['day'] }}</td>
                                        <td> {{ $timetable->classtime['start'] }}</td>
                                        <td> {{ $timetable->classtime['end'] }}</td>
                                        <td>
                                            @if ( $timetable->isPresent == 0)
                                                <span class="badge bg-danger">Absent</span>
                                            @else
                                                <span class="badge bg-success">Present</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-secondary" wire:click="editTimetables({{ $timetable->id }})">Edit</button>
                                            <button class="btn btn-sm btn-danger" wire:click="deleteConfirmation({{ $timetable->id }})">Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" style="text-align: center;"><small>No timetable Found</small></td>
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
    <div wire:ignore.self class="modal fade" id="addTimeTableModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addTimeTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTimeTableModalLabel">Add New Time Table</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storeTimeTableData">
                        <div class="form-group row">
                            <label for="user_id" class="col-3">Students Name</label>
                            <div class="col-9 mb-3">
                                <select size="4" class="user_id form-control shadow-none rounded-0" wire:model="user_id" id="user_id" name="user_id" aria-label="Floating label select example" required>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="class_id" class="col-3">Class Time</label>
                            <div class="col-9 mb-3">
                                <select size="4" class="user_id form-control shadow-none rounded-0" wire:model="classtime_id" id="classtime_id" name="classtime_id" aria-label="Floating label select example" required>
                                    @foreach ($classtimes as $classtime)
                                        <option value="{{ $classtime->id }}">{{ $classtime->course['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('course')
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
                                <button type="submit" class="btn btn-sm btn-primary">Add Time Table</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editTimeTableModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editTimeTableModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTimeTableModalLabel">Edit Time Table</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputs"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="editTimetableData">

                        <div class="form-group row">
                            <label for="user_id" class="col-3">Students Name</label>
                            <div class="col-9 mb-3">
                                <select size="4" class="user_id form-control shadow-none rounded-0" wire:model="user_id" id="user_id" name="user_id" aria-label="Floating label select example" required>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="class_id" class="col-3">Class Time</label>
                            <div class="col-9 mb-3">
                                <select size="4" class="user_id form-control shadow-none rounded-0" wire:model="classtime_id" id="classtime_id" name="classtime_id" aria-label="Floating label select example" required>
                                    @foreach ($classtimes as $classtime)
                                        <option value="{{ $classtime->id }}">{{ $classtime->course['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Update classtime</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteTimeTableModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="deleteTimeTableModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteTimeTableModalLabel">Delete classtime</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you usre? You want to delete this classtime data!</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" wire:click="deleteTimetableData()">Yes! Delete</button>
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewTimeTableModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">classtime Information</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" wire:click="closeViewTimeTableModal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID: </th>x
                            </tr>

                            <tr>
                                <th>Name: </th>
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
            $('#addTimeTableModal').modal('hide');
            $('#editTimeTableModal').modal('hide');
            $('#deleteTimeTableModal').modal('hide');
            $('#viewTimeTableModal').modal('hide');
        });

        window.addEventListener('show-edit-timetable-modal', event=>{
            $('#editTimeTableModal').modal('show');
        });

        window.addEventListener('show-delete-timetable-modal', event=>{
            $('#deleteTimeTableModal').modal('show');
        });

        window.addEventListener('show-view-timetable-modal', event =>{
            $('#viewTimeTableModal').modal('show');
        });
    </script>
@endpush