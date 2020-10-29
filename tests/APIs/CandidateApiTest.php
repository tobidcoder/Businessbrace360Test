<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Candidate;

class CandidateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_candidate()
    {
        $candidate = factory(Candidate::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/candidates', $candidate
        );

        $this->assertApiResponse($candidate);
    }

    /**
     * @test
     */
    public function test_read_candidate()
    {
        $candidate = factory(Candidate::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/candidates/'.$candidate->id
        );

        $this->assertApiResponse($candidate->toArray());
    }

    /**
     * @test
     */
    public function test_update_candidate()
    {
        $candidate = factory(Candidate::class)->create();
        $editedCandidate = factory(Candidate::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/candidates/'.$candidate->id,
            $editedCandidate
        );

        $this->assertApiResponse($editedCandidate);
    }

    /**
     * @test
     */
    public function test_delete_candidate()
    {
        $candidate = factory(Candidate::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/candidates/'.$candidate->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/candidates/'.$candidate->id
        );

        $this->response->assertStatus(404);
    }
}
