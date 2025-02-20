@extends('layouts.app_profile')

@section('content')
<div class="container">
    <h1>Tạo nhóm con bậc nhỏ hơn</h1>
    <form action="{{ route('groups.store-sub-child') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tên nhóm con</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nhóm cha</label>
            <select name="parent_id" class="form-select" required>
                @foreach ($parentGroups as $group)
                    @include('groups.partials.group-option', ['group' => $group, 'depth' => 0])
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
    </form>
</div>
@endsection
