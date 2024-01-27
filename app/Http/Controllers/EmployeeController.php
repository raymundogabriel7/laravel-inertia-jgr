<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepository;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
    
    /**
     * Class constructor
     * 
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepository, CompanyRepositoryInterface $companyRepository) 
    {
        $this->employeeRepository = $employeeRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = $this->employeeRepository->findBy([], true, false, ['company']);

        return Inertia::render('Employee/List', [
            'create_url' => route('employee.create'),
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Employee/Create', [
            'list_url' => route('employee.index'),
            'companies' => $this->companyRepository->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $newEmployee = $this->employeeRepository->save($request->request->all());

        if(!$newEmployee) {
            return to_route('employee.create')
                ->with('message', 'Failed to save.')
                ->with('success', false);
        }


        return to_route('employee.index')
                ->with('message', 'Succesfully saved.')
                ->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return Inertia::render('Employee/Edit', [
            'list_url' => route('employee.index'),
            'employee' => $employee->toArray(),
            'companies' => $this->companyRepository->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        if($employee = $this->employeeRepository->update($employee, $request->request->all())) {
            return to_route('employee.edit', ['employee' => $employee->id])
                ->with('message', 'Succesfully saved.')
                ->with('success', true);
        }
        
        return to_route('employee.edit', ['employee' => $employee->id])
            ->with('message', 'Failed to save.')
            ->with('success', false);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if($this->employeeRepository->delete($employee)) {
            return to_route('employee.index')
                ->with('message', 'Succesfully deleted.')
                ->with('success', true);
        }

        return to_route('employee.index')
                ->with('message', 'Failed to delete')
                ->with('success', false);
    }
}
