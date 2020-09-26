<?php
namespace App\User\Repository;

use App\User;


interface AuthRepositoryInterface
{
    public function store( $model);
}