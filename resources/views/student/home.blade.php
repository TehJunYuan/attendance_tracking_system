@extends('layouts.app')
@section('content')

<div class="container">
    <h1 class="mt-4">Dear Student, {{ Auth::user()->name }}</h1>
    <div class="card">
        <div class="card-header">
            <h2>Please show your QR code for Attendance</h2>
        </div>
        <div class="card-body">
            {!! QrCode::size(300)->generate(Auth::user()->student_id) !!}
        </div>
    </div>
</div>

<div class="container">
    <h1 class="mt-4">Your Attenadnce Record</h1>
    <div class="card">
        <div class="card-header">
            <h2>Check Your Attendance Here</h2>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Lecture Name</th>
                        <th scope="col">Class</th>
                        <th scope="col">Day</th>
                        <th scope="col">Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($getTimetable as $timetable)
                        <tr>
                            <th scope="row">{{ $count++ }}</th>
                            <td> {{ $timetable->lecture['name'] }} </td>
                            <td> {{ $timetable->classtime['course']->name }}</td>
                            <td> {{ $timetable->classtime['day'] }}</td>
                            <td>                                            
                                @if ( $timetable->isPresent == 0)
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
@endsection