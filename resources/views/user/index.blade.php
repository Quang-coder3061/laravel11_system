@extends('layouts.app_user')

@section('content')
<div class="container">
    <h1>User Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>
    <a href="/user/manager" class="btn btn-primary">Manage Your Data</a>
</div>
@endsection
