@extends('layouts.app_profile')

@section('content')
    <div class="container">
        <h1>Thêm thông tin cá nhân</h1>
        <form action="{{ route('profile.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Số CCCD</label>
                <input type="text" name="citizen_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày sinh</label>
                <input type="date" name="date_of_birth" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <select name="gender" class="form-select" required>
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="tel" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ thường trú</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </form>
    </div>
@endsection
