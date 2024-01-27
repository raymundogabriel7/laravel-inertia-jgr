<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_page_is_displayed(): void
    {
        $response = $this
            ->get('/company');

        $response->assertFound();
    }

    public function test_new_companies_can_create(): void
    {
        $response = $this->post('/company/store', [
            'name' => 'Test Company',
            'email' => 'company@example.com',
            'logo' => null
        ]);

        $response->assertFound();
    }

    public function test_new_companies_can_update(): void
    {
        $response = $this->patch('/company/1', [
            'name' => 'Test Company',
            'email' => 'company@example.com',
            'logo' => null
        ]);

        $response->assertFound();
    }
}
