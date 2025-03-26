<?php

namespace App\Repositories;

use App\Models\Badge;
use App\Models\User;
use App\Interfaces\BadgeRepositoryInterface;

class BadgeRepository implements BadgeRepositoryInterface
{
    public function create(array $data)
    {
        return Badge::create($data);
    }

    public function update($id, array $data)
    {
        $badge = Badge::findOrFail($id);
        $badge->update($data);
        return $badge;
    }

    public function delete($id)
    {
        return Badge::destroy($id);
    }

    public function getUserBadges($userId)
    {
        return User::findOrFail($userId)->badges;
    }
 
}