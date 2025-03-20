<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Tag;

class TagPolicy
{
    public function viewAny(User $user)
    {
        return true; 
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('manage-tags'); 
    }

    public function update(User $user, Tag $tag)
    {
        return $user->hasPermissionTo('manage-tags'); 
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->hasPermissionTo('manage-tags'); 
    }
}