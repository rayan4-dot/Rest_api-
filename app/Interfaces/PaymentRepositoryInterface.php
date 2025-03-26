<?php

namespace App\Interfaces;

interface PaymentRepositoryInterface
{
    public function create(array $data);
    public function findById($id);
    public function getUserPayments($userId);
    public function getAll();
}