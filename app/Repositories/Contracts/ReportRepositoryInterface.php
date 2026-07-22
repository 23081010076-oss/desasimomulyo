<?php

namespace App\Repositories\Contracts;

use App\Models\Report;

interface ReportRepositoryInterface
{
    public function create(array $data): Report;
}
