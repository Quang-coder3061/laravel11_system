@extends('layouts.app_profile')

@section('content')
    <div class="container">
        <h1>Danh sách yêu cầu của bạn</h1>

        @if ($requests && !$requests->isEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên nhóm</th>
                        <th>Loại nhóm</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>                    
                    @foreach ($requests as $request)
                        <tr>
                            <td>{{ $request->group->id }}</td>
                            <td>{{ $request->group->name }}</td>
                            <td>{{ $request->group->type->name }}</td>
                            <td>
                                @if ($request->status === 'rejected')
                                    <span class="text-danger">Bị từ chối</span>
                                    <div class="mt-2">
                                        <a href="{{ route('groups.edit-request', $request->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <form action="{{ route('groups.delete-request', $request->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </div>
                                @else
                                    {{ $request->status }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Không có yêu cầu nào.</p>
        @endif

    </div>
@endsection
