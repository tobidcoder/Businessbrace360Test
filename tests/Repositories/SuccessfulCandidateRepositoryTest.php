<?php namespace Tests\Repositories;

use App\Models\SuccessfulCandidate;
use App\Repositories\SuccessfulCandidateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SuccessfulCandidateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SuccessfulCandidateRepository
     */
    protected $successfulCandidateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->successfulCandidateRepo = \App::make(SuccessfulCandidateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->make()->toArray();

        $createdSuccessfulCandidate = $this->successfulCandidateRepo->create($successfulCandidate);

        $createdSuccessfulCandidate = $createdSuccessfulCandidate->toArray();
        $this->assertArrayHasKey('id', $createdSuccessfulCandidate);
        $this->assertNotNull($createdSuccessfulCandidate['id'], 'Created SuccessfulCandidate must have id specified');
        $this->assertNotNull(SuccessfulCandidate::find($createdSuccessfulCandidate['id']), 'SuccessfulCandidate with given id must be in DB');
        $this->assertModelData($successfulCandidate, $createdSuccessfulCandidate);
    }

    /**
     * @test read
     */
    public function test_read_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->create();

        $dbSuccessfulCandidate = $this->successfulCandidateRepo->find($successfulCandidate->id);

        $dbSuccessfulCandidate = $dbSuccessfulCandidate->toArray();
        $this->assertModelData($successfulCandidate->toArray(), $dbSuccessfulCandidate);
    }

    /**
     * @test update
     */
    public function test_update_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->create();
        $fakeSuccessfulCandidate = factory(SuccessfulCandidate::class)->make()->toArray();

        $updatedSuccessfulCandidate = $this->successfulCandidateRepo->update($fakeSuccessfulCandidate, $successfulCandidate->id);

        $this->assertModelData($fakeSuccessfulCandidate, $updatedSuccessfulCandidate->toArray());
        $dbSuccessfulCandidate = $this->successfulCandidateRepo->find($successfulCandidate->id);
        $this->assertModelData($fakeSuccessfulCandidate, $dbSuccessfulCandidate->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->create();

        $resp = $this->successfulCandidateRepo->delete($successfulCandidate->id);

        $this->assertTrue($resp);
        $this->assertNull(SuccessfulCandidate::find($successfulCandidate->id), 'SuccessfulCandidate should not exist in DB');
    }
}
