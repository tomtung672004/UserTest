<?php
namespace App\Services\Task;
use App\Repositories\Task\ITaskRepository;
use App\Services\BaseService;

class TaskService extends BaseService implements ITaskService
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        parent::__construct($taskRepository);
        $this->taskRepository = $taskRepository;
    }
    public function submit($id)
    {
        // Implement the logic to submit a task by its ID
        

    }
}
