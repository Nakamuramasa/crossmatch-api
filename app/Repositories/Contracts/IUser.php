<?php

namespace App\Repositories\Contracts;

interface IUser
{
    public function findByEmail($email);
    public function matchingUsers(array $matchingId);
}
