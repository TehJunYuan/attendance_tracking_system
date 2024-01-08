
<div>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3 style="color: black;"><strong>Course Information</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h5 style="float: left;"><strong>All Course</strong></h5>
                        <button type="button" class="btn btn-sm btn-primary" style="float: right;"  data-bs-toggle="modal" data-bs-target="#addCourseModal">Add New Course</button>
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
                                    <th>Name</th>
                                    <th>Hour</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($courses->count() > 0)
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td> {{ $course->id }} </td>
                                            <td> {{ $course->name }} </td>
                                            <td> {{ $course->hour }} </td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-sm btn-primary" wire:click="viewCourseDetails({{ $course->id }})">View</button>
                                                <button class="btn btn-sm btn-secondary" wire:click="editCourses({{ $course->id }})">Edit</button>
                                                <button class="btn btn-sm btn-danger" wire:click="deleteConfirmation({{ $course->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center;"><small>No Course Found</small></td>
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
    <div wire:ignore.self class="modal fade" id="addCourseModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addCourseModalLabel">Add New Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputs"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storeCourseData">
                        <div class="form-group row">
                            <label for="name" class="col-3">Name</label>
                            <div class="col-9">
                                <input type="text" id="name" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hour" class="col-3">Hours</label>
                            <div class="col-9">
                                <input type="number" id="hour" class="form-control" wire:model="hour">
                                @error('hour')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <br>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Add Course</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editCourseModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCourseModalLabel">Edit Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputs"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="editCourseData">

                        <div class="form-group row">
                            <label for="name" class="col-3">Name</label>
                            <div class="col-9">
                                <input type="text" id="name" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hour" class="col-3">Hours</label>
                            <div class="col-9">
                                <input type="number" id="hour" class="form-control" wire:model="hour">
                                @error('hour')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Update Course</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteCourseModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteCourseModalLabel">Delete Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you usre? You want to delete this course data!</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" wire:click="deleteCourseData()">Yes! Delete</button>
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewCourseModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Course Information</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" wire:click="closeViewCourseModal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID: </th>
                                <td>{{ $view_course_id }}</td>
                            </tr>

                            <tr>
                                <th>Name: </th>
                                <td>{{ $view_course_name }}</td>
                            </tr>

                            <tr>
                                <th>Hour: </th>
                                <td>{{ $view_course_hour }}</td>
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
            $('#addCourseModal').modal('hide');
            $('#editCourseModal').modal('hide');
            $('#deleteCourseModal').modal('hide');
            $('#viewCourseModal').modal('hide');
        });

        window.addEventListener('show-edit-course-modal', event=>{
            $('#editCourseModal').modal('show');
        });

        window.addEventListener('show-delete-course-modal', event=>{
            $('#deleteCourseModal').modal('show');
        });

        window.addEventListener('show-view-course-modal', event =>{
            $('#viewCourseModal').modal('show');
        });
    </script>
@endpush