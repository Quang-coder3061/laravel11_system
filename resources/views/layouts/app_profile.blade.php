<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 11 System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Trang thông tin chi tiết: {{ Auth::user()->name }}</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.create') }}">Thêm thông tin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.show') }}">Thông tin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('groups.create-request') }}">Tạo nhóm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('groups.requests') }}">Danh sách yêu cầu tạo nhóm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('groups.create-child') }}">Tạo nhóm con</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('groups.create-sub-child') }}">Tạo nhóm con cấp thấp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=" route('groups.join')">Yêu cầu ra nhập nhóm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('groups.manage-join-requests') }}">Quản lý yêu cầu</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-success" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
