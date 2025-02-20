<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupRequest;
use App\Models\GroupType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GroupController extends Controller
{

    public function index()
    {
        // Kiểm tra vai trò và chuyển hướng
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Lấy danh sách yêu cầu của người dùng hiện tại
        //$requests = $user->groupRequests() ?? collect()->with('group')->get();
        //$requests = $user->groupRequests() ?? collect();
        $requests = $user->groupRequests()->with('group')->get();
        return view('groups.requests', compact('requests'));
    }

    // Hiển thị form tạo yêu cầu nhóm
    public function createRequest()
    {
        $groupTypes = GroupType::all();
        return view('groups.create-request', compact('groupTypes'));
    }

    // Gửi yêu cầu tạo nhóm
    public function storeRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required|exists:tbl_group_types,id',
        ]);

        // Tạo nhóm nhưng chưa approved
        $group = Group::create([
            'name' => $request->name,
            'type_id' => $request->type_id,
            'created_by' => Auth::id(),
            'is_approved' => false,
        ]);

        // Tạo yêu cầu phê duyệt
        GroupRequest::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'type' => 'create_group',
            'status' => 'pending',
        ]);
        return redirect()->route('groups.requests')->with('success', 'Yêu cầu đã được gửi!');
    }

    // Danh sách yêu cầu chờ phê duyệt (cho admin)
    public function pendingRequests()
    {
        // Lấy tất cả yêu cầu "pending", bao gồm cả yêu cầu gửi lại
        $requests = GroupRequest::where('status', 'pending')
            ->with(['group', 'user'])
            ->get();
        return view('admin.pending-requests', compact('requests'));
    }

    // Phê duyệt yêu cầu tạo nhóm (admin)
    public function approveRequest($requestId)
    {
        $groupRequest = GroupRequest::findOrFail($requestId);
        //
        $groupRequest->update(['status' => 'approved']);
        //
        $groupRequest->group->update(['is_approved' => true]);
        return back()->with('success', 'Yêu cầu đã được phê duyệt!');
    }
    //Từ chối yêu cầu tạo nhóm
    public function rejectRequest($requestId)
    {
        $groupRequest = GroupRequest::findOrFail($requestId);
        $groupRequest->update(['status' => 'rejected']);
        return back()->with('error', 'Yêu cầu đã bị từ chối!');
    }
    //Nhóm con
    public function createChild()
    {
        // Kiểm tra vai trò và chuyển hướng
        $user = Auth::user();
        // Lấy danh sách nhóm lớn đã được phê duyệt của user
        //$parentGroups = Auth::user()->groups()->where('is_approved', true)->get();
        $parentGroups = $user->groups()->where('is_approved', true)->get();
        return view('groups.create-child', compact('parentGroups'));
    }

    public function storeChild(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'required|exists:tbl_groups,id',
        ]);

        // Kiểm tra và lấy type_id
        $groupType = GroupType::where('name', 'child')->first();

        if (!$groupType) {
            return back()->with('error', 'Loại nhóm "child" không tồn tại!');
        }

        Group::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'type_id' => $groupType->id, // Sử dụng $groupType->id thay vì first()->id
            //'type_id' => GroupType::where('name', 'child')->first()->id,
            'created_by' => Auth::id(),
            'is_approved' => false, // Tùy logic: Nhóm con có cần phê duyệt không?
        ]);

        return redirect()->route('groups.requests')->with('success', 'Yêu cầu tạo nhóm con đã được gửi!');
    }

    //Thêm Sửa Xóa
    // Hiển thị form chỉnh sửa yêu cầu bị từ chối
    public function editRequest($id)
    {
        //$request = GroupRequest::findOrFail($id);
        $request = GroupRequest::with('group')->findOrFail($id);
        //$groupTypes = GroupType::all();
        $groupTypes = GroupType::all();

        // Kiểm tra vai trò và chuyển hướng
        //$user = Auth::user();
        //$parentGroups = $user->groups()->where('is_approved', true)->get();
        //return view('groups.edit-request', compact('request', 'groupTypes', 'parentGroups'));
        // Kiểm tra quyền: Chỉ user tạo yêu cầu mới được sửa
        if ($request->user_id !== Auth::id()) {
            abort(403);
        }
        //$this->authorize('update', $request);
        return view('groups.edit-request', compact('request', 'groupTypes'));
    }

    // Xử lý cập nhật yêu cầu và gửi lại
    public function updateRequest(Request $request, $id)
    {
        $groupRequest = GroupRequest::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'name' => 'required',
            //'parent_id' => 'required',
            'type_id' => 'required',
        ]);

        // Cập nhật thông tin nhóm
        $groupRequest->group->update([
            'name' => $request->name,
            //'parent_id' => $request->parent_id,
            'type_id' => $request->type_id,
        ]);

        // Đánh dấu yêu cầu đã được gửi lại
        $groupRequest->update([
            'status' => 'pending',
            'is_resubmitted' => true,
        ]);

        return redirect()->route('groups.requests')->with('success', 'Yêu cầu đã được gửi lại!');
    }

    //Đảm bảo xóa `GroupRequest` trước khi xóa `Group`
    public function deleteRequest($id)
    {
        $groupRequest = GroupRequest::findOrFail($id);
        // Xóa GroupRequest trước
        $groupRequest->delete();
        // Sau đó xóa Group
        $groupRequest->group->delete();
        //$groupRequest->group->delete();
        //$groupRequest->delete();

        return redirect()->route('groups.requests')->with('success', 'Yêu cầu đã được xóa!');
    }
    //Tạo các nhóm con.
    public function createSubChild()
    {
        // Lấy tất cả các nhóm mà user có quyền tạo nhóm con (ví dụ: nhóm đã được phê duyệt)
        $parentGroups = Group::where('created_by', Auth::id())
            ->where('is_approved', true)
            ->with('allChildren') // Lấy cả các nhóm con
            ->get();
        return view('groups.create-sub-child', compact('parentGroups'));
    }

    public function storeSubChild(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|exists:tbl_groups,id',
        ]);

        // Kiểm tra và lấy type_id
        $groupType = GroupType::where('name', 'child')->first();

        if (!$groupType) {
            return back()->with('error', 'Loại nhóm "child" không tồn tại!');
        }

        Group::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'type_id' => $groupType->id, // Sử dụng $groupType->id thay vì first()->id
            //'type_id' => GroupType::where('name', 'sub-child')->first()->id, // Thêm loại "sub-child"
            'created_by' => Auth::id(),
            'is_approved' => false, // Hoặc true tùy logic
        ]);
        return redirect()->route('groups.requests')->with('success', 'Yêu cầu tạo nhóm con đã được gửi!');
    }

    // Gửi yêu cầu gia nhập
    public function sendJoinRequest(Request $request, Group $group)
    {
        GroupJoinRequest::create([
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'message' => $request->message,
        ]);
        return back()->with('success', 'Yêu cầu đã được gửi!');
        //return redirect()->route('groups.join-request')->back()->with('success', 'Yêu cầu đã được gửi!');
    }

    // Trang quản lý yêu cầu (cho User quản lý nhóm)
    public function manageJoinRequests()
    {
        $managedGroups = Auth::user()->managedGroups; // Quan hệ groups mà user quản lý
        $requests = GroupJoinRequest::whereIn('group_id', $managedGroups->pluck('id'))
            ->with(['user', 'group'])
            ->get();

        return view('groups.manage-join-requests', compact('requests'));
    }

    // Phê duyệt yêu cầu (hiển thị form chọn nhóm con)
    public function approveJoinRequest(GroupJoinRequest $request)
    {
        $subGroups = $request->group->children; // Các nhóm con của nhóm cha
        return view('groups.assign-subgroup', compact('request', 'subGroups'));
    }

    // Xử lý gán vào nhóm con
    public function assignToSubGroup(Request $request, GroupJoinRequest $joinRequest)
    {
        $joinRequest->update([
            'status' => 'approved',
            'assigned_group_id' => $request->sub_group_id,
        ]);

        // Thêm user vào nhóm con
        $joinRequest->assignedGroup->users()->attach($joinRequest->user_id);

        return redirect()->route('groups.manage-join-requests')->with('success', 'Đã gán vào nhóm con!');
    }

    // Từ chối yêu cầu
    public function rejectJoinRequest(GroupJoinRequest $request)
    {
        $request->update(['status' => 'rejected']);
        return back()->with('success', 'Yêu cầu đã bị từ chối!');
    }
}
