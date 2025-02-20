@extends('layouts.app_profile')

@section('content')
    <div class="container">
        <h1>Chỉnh sửa yêu cầu tạo nhóm</h1>
        <form action="{{ route('groups.update-request', $request->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Tên nhóm</label>
                <input type="text" name="name" class="form-control" value="{{ $request->group->name }}" required>
            </div>
            <div class="mb-3">
                <label>Loại nhóm</label>
                <select name="type_id" class="form-select" required>
                    @foreach ($groupTypes as $type)
                        <option value="{{ $type->id }}" {{ $request->group->type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Gửi lại yêu cầu</button>
        </form>
    </div>
@endsection
