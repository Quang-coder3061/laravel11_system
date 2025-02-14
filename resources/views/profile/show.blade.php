@extends('layouts.app_profile')

@section('content')
<div class="container">
    <h1>Thông tin cá nhân</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Loại thông tin:</strong> {{ $profile->type_information }}</p>
            <p><strong>Số CCCD:</strong> {{ $profile->citizen_id }}</p>
            <p><strong>Ngày sinh:</strong> {{ $profile->date_of_birth }}</p>
            <p><strong>Giới tính:</strong> {{ ucfirst($profile->gender) }}</p>
            <p><strong>Số điện thoại:</strong> {{ $profile->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $profile->address }}</p>
        </div>
    </div>
</div>
@endsection
