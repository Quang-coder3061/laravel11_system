<form action="{{ route('groups.assign-to-subgroup', $request) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Chọn nhóm con</label>
        <select name="sub_group_id" class="form-select" required>
            @foreach ($subGroups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Gán vào nhóm</button>
</form>
