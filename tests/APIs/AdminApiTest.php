<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin;

class AdminApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_admin()
    {
        $admin = factory(Admin::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admins', $admin
        );

        $this->assertApiResponse($admin);
    }

    /**
     * @test
     */
    public function test_read_admin()
    {
        $admin = factory(Admin::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/admins/'.$admin->id
        );

        $this->assertApiResponse($admin->toArray());
    }

    /**
     * @test
     */
    public function test_update_admin()
    {
        $admin = factory(Admin::class)->create();
        $editedAdmin = factory(Admin::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admins/'.$admin->id,
            $editedAdmin
        );

        $this->assertApiResponse($editedAdmin);
    }

    /**
     * @test
     */
    public function test_delete_admin()
    {
        $admin = factory(Admin::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admins/'.$admin->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admins/'.$admin->id
        );

        $this->response->assertStatus(404);
    }
}
