@extends('layouts.app_profile')

@section('content')
    <div class="container">
        <h1>Tạo yêu cầu nhóm mới</h1>
        <form action="{{ route('groups.join', $group) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Lời nhắn (tùy chọn)</label>
                <textarea name="message" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
        </form>
    </div>
@endsection
