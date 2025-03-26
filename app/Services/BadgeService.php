<?php

namespace App\Services;

use App\Interfaces\BadgeRepositoryInterface;
use App\Models\User;
use App\Models\Badge;

class BadgeService
{
    protected $badgeRepository;

    public function __construct(BadgeRepositoryInterface $badgeRepository)
    {
        $this->badgeRepository = $badgeRepository;
    }

    public function getUserBadges($userId)
    {
        return $this->badgeRepository->getUserBadges($userId);
    }

    public function create(array $data)
    {
        return $this->badgeRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->badgeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->badgeRepository->delete($id);
    }

    public function awardBadges($userId)
    {
        $user = User::findOrFail($userId);
        $badges = Badge::all();

        foreach ($badges as $badge) {
            if (!$user->badges->contains($badge->id) && $this->meetsCondition($user, $badge)) {
                $user->badges()->attach($badge->id, ['awarded_at' => now()]);
            }
        }
    }

    private function meetsCondition($user, $badge)
    {
        switch ($badge->condition_type) {
            case 'course_completion':
                return $user->courses()->where('progress_status', 'completed')->count() >= 2;
            case 'mentor_courses':
                return $user->hasRole('mentor') && $user->createdCourses()->count() >= 2;
            case 'students_enrolled':
                return $user->hasRole('mentor') && $user->createdCourses()->withCount('students')->get()->sum('students_count') >= 2;
            default:
                return false;
        }
    }
}