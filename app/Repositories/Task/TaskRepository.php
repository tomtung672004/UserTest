<?php
namespace App\Repositories\Task;
use App\Repositories\BaseRepository;
use App\Models\Task;
use App\Repositories\task\ITaskRepository;
use App\Traits\ApiResponseTrait;
class TaskRepository extends BaseRepository implements ITaskRepository
{
    use ApiResponseTrait;
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
    // public function getModel()
    // {
    //     return Job::class;
    // }
}
