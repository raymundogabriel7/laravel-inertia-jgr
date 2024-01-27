<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
    
    /**
     * Class constructor
     * 
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(CompanyRepositoryInterface $companyRepository) 
    {
        $this->companyRepository = $companyRepository;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = $this->companyRepository->findBy([], true);

        return Inertia::render('Company/List', [
            'create_url' => route('company.create'),
            'companies' => $companies,
            'company_logo_url' => asset('storage')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Company/Create', [
            'list_url' => route('company.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $newCompany = $this->companyRepository->save($request->request->all());

        if(!$newCompany) {
            return to_route('company.create')
                ->with('message', 'Failed to save.')
                ->with('success', false);
        }

        if ($request->hasFile('logo')) {
            $image_path = $request->file('logo')->store('company_logo/'.$newCompany->id, 'public');
            $request->merge(['logo' => $image_path]);
            $this->companyRepository->update($newCompany, ['logo' => $image_path]);
        }

        return to_route('company.index')
                ->with('message', 'Succesfully saved.')
                ->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return Inertia::render('Company/Edit', [
            'list_url' => route('company.index'),
            'company' => $company->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
     
        if ($request->hasFile('logo')) {
            $image_path = $request->file('logo')->store('company_logo/'.$company->id, 'public');
            $request->merge(['logo' => $image_path]);
        }

        if($company = $this->companyRepository->update($company, $request->request->all())) {
            return to_route('company.edit', ['company' => $company->id])
                ->with('message', 'Succesfully saved.')
                ->with('success', true);
        }
        
        return to_route('company.edit', ['company' => $company->id])
            ->with('message', 'Failed to save.')
            ->with('success', false);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if($this->companyRepository->delete($company)) {
            return to_route('company.index')
                ->with('message', 'Succesfully deleted.')
                ->with('success', true);
        }

        return to_route('company.index')
                ->with('message', 'Failed to delete')
                ->with('success', false);
    }
}
