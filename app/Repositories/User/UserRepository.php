<?php
namespace App\Repositories\User;

use app\Repositories\BaseRepository;
use App\Models\User;
use App\Repositories\User\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function getModel()
    {
        return User::class;
    }

    public function findByEmail($email)
    {
        $user = $this->model->where('email', $email)->first();
        if (!$user) {
            throw new \Exception("User not found.",code:404);
        }
        return $user;
    }
}
