<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\EloquentBaseRepository;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EloquentEmployeeRepository extends EloquentBaseRepository implements EmployeeRepositoryInterface {
    
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
    }
}