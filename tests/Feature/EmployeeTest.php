<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_page_is_displayed(): void
    {
        $response = $this
            ->get('/employee');

        $response->assertFound();
    }

    public function test_new_employees_can_create(): void
    {
        $response = $this->post('/employee', [
            'first_name' => 'Test',
            'last_name' => 'Employee',
            'email' => 'employee@example.com',
            'company_id' => 1
        ]);

        $response->assertFound();
    }

    public function test_new_employees_can_update(): void
    {
        $response = $this->patch('/employee/1', [
            'first_name' => 'Test',
            'last_name' => 'Employee',
            'email' => 'employee@example.com',
            'company_id' => 1
        ]);

        $response->assertFound();
    }
}
