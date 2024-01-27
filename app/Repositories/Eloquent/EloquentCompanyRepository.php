<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\EloquentBaseRepository;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class EloquentCompanyRepository extends EloquentBaseRepository implements CompanyRepositoryInterface {
    
    public function __construct(Company $company)
    {
        parent::__construct($company);
    }
}