@extends('layouts.app_admin')

@section('content')
    <div class="container">
        <h1>User Administrator</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <a href="/user/manager" class="btn btn-primary">Manage Your Data</a>
    </div>
@endsection
