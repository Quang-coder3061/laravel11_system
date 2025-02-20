@foreach ($requests as $request)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $request->user->name }} muốn tham gia {{ $request->group->name }}</h5>
            <p>{{ $request->message }}</p>

            @if ($request->status === 'pending')
                <a href="{{ route('groups.approve-join-request', $request) }}" class="btn btn-success">Phê duyệt</a>
                <a href="{{ route('groups.reject-join-request', $request) }}" class="btn btn-danger">Từ chối</a>
            @elseif ($request->status === 'rejected')
                <span class="text-danger">Đã bị từ chối</span>
                <a href="#" class="btn btn-warning">Sửa yêu cầu</a>
                <form action="{{ route('groups.delete-request', $request) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            @endif
        </div>
    </div>
@endforeach
