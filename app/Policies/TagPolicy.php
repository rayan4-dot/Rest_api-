<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Tag;

class TagPolicy
{
    public function viewAny(User $user)
    {
        return true; // Tout le monde peut voir les tags
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('manage-tags'); // Seul l'admin peut créer des tags
    }

    public function update(User $user, Tag $tag)
    {
        return $user->hasPermissionTo('manage-tags'); // Seul l'admin peut mettre à jour les tags
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->hasPermissionTo('manage-tags'); // Seul l'admin peut supprimer les tags
    }
}