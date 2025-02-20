@extends('layouts.app_admin')

@section('content')
    <div class="container">
        <h1>Yêu cầu tạo nhóm chờ phê duyệt</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên nhóm</th>
                    <th>Người gửi</th>
                    <th>Loại nhóm</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->group->name }}</td>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->group->type->name }}</td>
                        <td>
                            @if ($request->is_resubmitted)
                                <span class="badge bg-warning">Yêu cầu gửi lại</span>
                            @else
                                <span class="badge bg-primary">Mới</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.approve-request', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Phê duyệt</button>
                            </form>
                            <form action="{{ route('admin.reject-request', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Từ chối</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
