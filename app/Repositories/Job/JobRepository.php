<?php
namespace App\Repositories\Job;
use App\Repositories\BaseRepository;
use App\Models\Job;
use App\Repositories\Job\IJobRepository;
use App\Traits\ApiResponseTrait;
class JobRepository extends BaseRepository implements IJobRepository
{
    use ApiResponseTrait;
    public function __construct(Job $model)
    {
        parent::__construct($model);
    }
    // public function getModel()
    // {
    //     return Job::class;
    // }
}
