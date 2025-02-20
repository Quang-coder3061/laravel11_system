@php
    // Thêm prefix để hiển thị cấp độ
    $prefix = str_repeat('- - ', $depth) . '↳ ';
@endphp

<option value="{{ $group->id }}">{{ $prefix }}{{ $group->name }}</option>

@foreach ($group->allChildren as $child)
    @include('groups.partials.group-option', ['group' => $child, 'depth' => $depth + 1])
@endforeach
