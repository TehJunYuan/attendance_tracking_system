
<div>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3 style="color: black;"><strong>Classroom Information</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h5 style="float: left;"><strong>All Classroom</strong></h5>
                        <button type="button" class="btn btn-sm btn-primary" style="float: right;"  data-bs-toggle="modal" data-bs-target="#addClassroomModal">Add New Classroom</button>
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
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($viewname->count() > 0)
                                    @foreach ($viewname as $classroom)
                                        <tr>
                                            <td> {{ $classroom->id }} </td>
                                            <td> {{ $classroom->name }} </td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-sm btn-primary" wire:click="viewClassroomDetails({{ $classroom->id }})" data-bs-toggle="modal">View</button>
                                                <button class="btn btn-sm btn-secondary" wire:click="editClassrooms({{ $classroom->id }})" data-bs-toggle="modal">Edit</button>
                                                <button class="btn btn-sm btn-danger" wire:click="deleteConfirmation({{ $classroom->id }})" data-bs-toggle="modal">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center;"><small>No Classroom Found</small></td>
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
    <div wire:ignore.self class="modal fade" id="addClassroomModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addClassroomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addClassroomModalLabel">Add New Classroom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storeClassroomData">
                        <div class="form-group row">
                            <label for="name" class="col-3">Name</label>
                            <div class="col-9">
                                <input type="text" id="name" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <br>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Add Classroom</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editClassroomModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editClassroomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editClassroomModalLabel">Edit Classroom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInputs"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="editClassroomData">

                        <div class="form-group row mb-3">
                            <label for="name" class="col-3">Name</label>
                            <div class="col-9">
                                <input type="text" id="name" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Update Classroom</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteClassroomModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="deleteClassroomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteClassroomModalLabel">Delete Classroom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you usre? You want to delete this classroom data!</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" wire:click="deleteClassroomData()">Yes! Delete</button>
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewClassroomModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Classroom Information</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" wire:click="closeViewClassroomModal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID: </th>
                                <td>{{ $view_classroom_id }}</td>
                            </tr>

                            <tr>
                                <th>Name: </th>
                                <td>{{ $view_classroom_name }}</td>
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
            $('#addClassroomModal').modal('hide');
            $('#editClassroomModal').modal('hide');
            $('#deleteClassroomModal').modal('hide');
            $('#viewClassroomModal').modal('hide');
        });

        window.addEventListener('show-edit-classroom-modal', event=>{
            $('#editClassroomModal').modal('show');
        });

        window.addEventListener('show-delete-classroom-modal', event=>{
            $('#deleteClassroomModal').modal('show');
        });

        window.addEventListener('show-view-classroom-modal', event =>{
            $('#viewClassroomModal').modal('show');
        });
    </script>
@endpush