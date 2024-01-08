@extends('layouts.app')


@section('title')
    Input Exame
@endsection


@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-lg">
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <div class="input-group mb-3">
                                <input type="hidden" class="id" name="id" id="id" value="{{ $id }}">
                                <input id="course_name" disabled type="text"
                                    class="course_name form-control shadow-none rounded-0" name="course_name"
                                    value="{{ $course->name }}" required autocomplete="course_name" placeholder="exam name">
                            </div>
                            <div class="input-group mb-3">
                                <input id="StudentId" disabled type="text" class="form-control shadow-none rounded-0"
                                    name="StudentId" value="{{ old('StudentId') }}" required
                                    autocomplete="StudentId" placeholder="Student ID scan">
                            </div>
                        </div>
                        <div class="form-group mb-2 p-0">
                            <video id="preview" class="form-control p-0"></video>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            Student Attendace List
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 table-responsive" id="Timetable">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="row">No</th>
                                        <th scope="row">Student Name</th>
                                        <th scope="row">Student ID</th>
                                        <th scope="row">Course Name</th>
                                        <th scope="row">Day</th>
                                        <th scope="row">Present</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getTimetables as $timetable)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td> {{ $timetable->user['name'] }} </td>
                                            <td> {{ $timetable->user['student_id'] }} </td>
                                            <td> {{ $timetable->classtime['course']->name }}</td>
                                            <td> {{ $timetable->classtime['day'] }}</td>
                                            <td>
                                                @if ($timetable->isPresent == 0)
                                                    <span class="badge bg-danger">Absent</span>
                                                @else
                                                    <span class="badge bg-success">Present</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        var scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            scanPeriod: 5,
            mirror: false
        });

        scanner.addListener('scan', function(content) {
            // alert(content);
            document.getElementById('StudentId').value = content;
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let StudentID = content;
                // console.log(StudentNumber);
                var data = {
                    'id': $('.id').val(),
                    'StudentID': StudentID,
                    'course_name': $('.course_name').val(),
                };
                $.ajax({
                    type: "POST",
                    url: `/lecture/timetable/updateAtt`,
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        $("#Timetable").load(location.href + " #Timetable");
                        toastr.success(response.success);
                    }
                });
            });
            //window.location.href=content;
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
                $('[name="options"]').on('change', function() {
                    if ($(this).val() == 1) {
                        if (cameras[0] != "") {
                            scanner.start(cameras[0]);
                        } else {
                            alert('No Front camera found!');
                        }
                    } else if ($(this).val() == 2) {
                        if (cameras[1] != "") {
                            scanner.start(cameras[1]);
                        } else {
                            alert('No Back camera found!');
                        }
                    }
                });
            } else {
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
            alert(e);
        });
    </script>
@endsection
