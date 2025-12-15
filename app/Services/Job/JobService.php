<?php
namespace App\Services\Job;
use App\Services\BaseService;
use App\Repositories\Job\IJobRepository;

class JobService extends BaseService implements IJobService
{
    protected $jobRepository;

    public function __construct(IJobRepository $jobRepository)
    {
        parent::__construct($jobRepository);
        $this->jobRepository = $jobRepository;
    }
}

