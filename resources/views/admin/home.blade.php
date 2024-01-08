@extends('layouts.app')
@section('content')

<div class="container">
    <h1 class="mt-4">User</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Student</h5>
                    <p class="card-text">{{ $data['countStudent'] }}</p>
                    <a href="{{ route('admin.userList') }}" class="btn btn-primary">Click to view</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Admin</h5>
                    <p class="card-text">{{ $data['countAdmin'] }}</p>
                    <a href="{{ route('admin.userList') }}" class="btn btn-primary">Click to view</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Lecture</h5>
                    <p class="card-text">{{ $data['countLecture'] }}</p>
                    <a href="{{ route('admin.userList') }}" class="btn btn-primary">Click to view</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1 class="mt-4">Courses</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Courses</h5>
                    <p class="card-text">{{ $data['countCourse'] }}</p>
                    <a href="{{ route('admin.course') }}" class="btn btn-primary">Click to view</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h1 class="mt-4">Classrooms</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Classrooms</h5>
                    <p class="card-text">{{ $data['countClassroom'] }}</p>
                    <a href="{{ route('admin.classroom') }}" class="btn btn-primary">Click to view</a>
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