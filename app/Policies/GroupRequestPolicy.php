<?php

namespace App\Policies;

use App\Models\GroupRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GroupRequest $groupRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GroupRequest $request)
    {
        // Chỉ user tạo yêu cầu và yêu cầu bị từ chối mới được sửa
        return $user->id === $request->user_id && $request->status === 'rejected';
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GroupRequest $groupRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GroupRequest $groupRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GroupRequest $groupRequest): bool
    {
        return false;
    }
}
