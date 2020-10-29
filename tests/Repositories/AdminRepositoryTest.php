<?php namespace Tests\Repositories;

use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AdminRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AdminRepository
     */
    protected $adminRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->adminRepo = \App::make(AdminRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_admin()
    {
        $admin = factory(Admin::class)->make()->toArray();

        $createdAdmin = $this->adminRepo->create($admin);

        $createdAdmin = $createdAdmin->toArray();
        $this->assertArrayHasKey('id', $createdAdmin);
        $this->assertNotNull($createdAdmin['id'], 'Created Admin must have id specified');
        $this->assertNotNull(Admin::find($createdAdmin['id']), 'Admin with given id must be in DB');
        $this->assertModelData($admin, $createdAdmin);
    }

    /**
     * @test read
     */
    public function test_read_admin()
    {
        $admin = factory(Admin::class)->create();

        $dbAdmin = $this->adminRepo->find($admin->id);

        $dbAdmin = $dbAdmin->toArray();
        $this->assertModelData($admin->toArray(), $dbAdmin);
    }

    /**
     * @test update
     */
    public function test_update_admin()
    {
        $admin = factory(Admin::class)->create();
        $fakeAdmin = factory(Admin::class)->make()->toArray();

        $updatedAdmin = $this->adminRepo->update($fakeAdmin, $admin->id);

        $this->assertModelData($fakeAdmin, $updatedAdmin->toArray());
        $dbAdmin = $this->adminRepo->find($admin->id);
        $this->assertModelData($fakeAdmin, $dbAdmin->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_admin()
    {
        $admin = factory(Admin::class)->create();

        $resp = $this->adminRepo->delete($admin->id);

        $this->assertTrue($resp);
        $this->assertNull(Admin::find($admin->id), 'Admin should not exist in DB');
    }
}
