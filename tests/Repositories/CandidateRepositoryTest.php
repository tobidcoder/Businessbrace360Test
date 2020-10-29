<?php namespace Tests\Repositories;

use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CandidateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CandidateRepository
     */
    protected $candidateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->candidateRepo = \App::make(CandidateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_candidate()
    {
        $candidate = factory(Candidate::class)->make()->toArray();

        $createdCandidate = $this->candidateRepo->create($candidate);

        $createdCandidate = $createdCandidate->toArray();
        $this->assertArrayHasKey('id', $createdCandidate);
        $this->assertNotNull($createdCandidate['id'], 'Created Candidate must have id specified');
        $this->assertNotNull(Candidate::find($createdCandidate['id']), 'Candidate with given id must be in DB');
        $this->assertModelData($candidate, $createdCandidate);
    }

    /**
     * @test read
     */
    public function test_read_candidate()
    {
        $candidate = factory(Candidate::class)->create();

        $dbCandidate = $this->candidateRepo->find($candidate->id);

        $dbCandidate = $dbCandidate->toArray();
        $this->assertModelData($candidate->toArray(), $dbCandidate);
    }

    /**
     * @test update
     */
    public function test_update_candidate()
    {
        $candidate = factory(Candidate::class)->create();
        $fakeCandidate = factory(Candidate::class)->make()->toArray();

        $updatedCandidate = $this->candidateRepo->update($fakeCandidate, $candidate->id);

        $this->assertModelData($fakeCandidate, $updatedCandidate->toArray());
        $dbCandidate = $this->candidateRepo->find($candidate->id);
        $this->assertModelData($fakeCandidate, $dbCandidate->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_candidate()
    {
        $candidate = factory(Candidate::class)->create();

        $resp = $this->candidateRepo->delete($candidate->id);

        $this->assertTrue($resp);
        $this->assertNull(Candidate::find($candidate->id), 'Candidate should not exist in DB');
    }
}
