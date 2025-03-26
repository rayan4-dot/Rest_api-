<?php

namespace App\Interfaces;

interface BadgeRepositoryInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getUserBadges($userId);

}