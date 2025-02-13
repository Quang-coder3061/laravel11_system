@extends('layouts.app_manager')

@section('content')
    <div class="container">
        <h1>User Manager</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <a href="/user/manager" class="btn btn-primary">Manage Your Data</a>
    </div>
@endsection
