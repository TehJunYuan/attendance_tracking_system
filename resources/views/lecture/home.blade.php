@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1 class="mt-4">Student Time Table</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Student Time Table</h5>
                    <p class="card-text">{{ $data['countTimetable'] }}</p>
                    <a href="{{ route('lecture.timetable') }}" class="btn btn-primary">Click to view</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h1 class="mt-4">Class Time</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Class Time</h5>
                    <p class="card-text">{{ $data['countClasstime'] }}</p>
                    <a href="{{ route('lecture.classtime') }}" class="btn btn-primary">Click to view</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        margin-bottom: 20px;
    }

    .card-body {
        text-align: center;
    }
</style>
@endsection