<?php
namespace App\Services\User;
interface IUserService
{
    // Define user-specific service methods here
    public function create(array $attributes);
    public function update($id, array $attributes);
}
