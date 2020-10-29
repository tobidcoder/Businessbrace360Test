<?php namespace Tests\Repositories;

use App\Models\JobApplicant;
use App\Repositories\JobApplicantRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JobApplicantRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobApplicantRepository
     */
    protected $jobApplicantRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->jobApplicantRepo = \App::make(JobApplicantRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->make()->toArray();

        $createdJobApplicant = $this->jobApplicantRepo->create($jobApplicant);

        $createdJobApplicant = $createdJobApplicant->toArray();
        $this->assertArrayHasKey('id', $createdJobApplicant);
        $this->assertNotNull($createdJobApplicant['id'], 'Created JobApplicant must have id specified');
        $this->assertNotNull(JobApplicant::find($createdJobApplicant['id']), 'JobApplicant with given id must be in DB');
        $this->assertModelData($jobApplicant, $createdJobApplicant);
    }

    /**
     * @test read
     */
    public function test_read_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->create();

        $dbJobApplicant = $this->jobApplicantRepo->find($jobApplicant->id);

        $dbJobApplicant = $dbJobApplicant->toArray();
        $this->assertModelData($jobApplicant->toArray(), $dbJobApplicant);
    }

    /**
     * @test update
     */
    public function test_update_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->create();
        $fakeJobApplicant = factory(JobApplicant::class)->make()->toArray();

        $updatedJobApplicant = $this->jobApplicantRepo->update($fakeJobApplicant, $jobApplicant->id);

        $this->assertModelData($fakeJobApplicant, $updatedJobApplicant->toArray());
        $dbJobApplicant = $this->jobApplicantRepo->find($jobApplicant->id);
        $this->assertModelData($fakeJobApplicant, $dbJobApplicant->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->create();

        $resp = $this->jobApplicantRepo->delete($jobApplicant->id);

        $this->assertTrue($resp);
        $this->assertNull(JobApplicant::find($jobApplicant->id), 'JobApplicant should not exist in DB');
    }
}
