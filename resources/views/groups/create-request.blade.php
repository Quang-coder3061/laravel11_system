@extends('layouts.app_profile')

@section('content')
    <div class="container">
        <h1>Tạo yêu cầu nhóm mới</h1>
        <form action="{{ route('groups.store-request') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Tên nhóm</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Loại nhóm</label>
                <select name="type_id" class="form-select" required>
                    @foreach ($groupTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
        </form>
    </div>
@endsection
