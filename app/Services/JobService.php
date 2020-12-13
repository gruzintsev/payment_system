<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class JobService
 * @package App\Services
 */
class JobService
{
    /**
     * @return LengthAwarePaginator
     */
    public function get()
    {
        return Job::query()->paginate(config('pagination.jobs'));
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Job::find($id);
    }
}
