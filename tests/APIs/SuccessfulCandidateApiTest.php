<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SuccessfulCandidate;

class SuccessfulCandidateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/successful_candidates', $successfulCandidate
        );

        $this->assertApiResponse($successfulCandidate);
    }

    /**
     * @test
     */
    public function test_read_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/successful_candidates/'.$successfulCandidate->id
        );

        $this->assertApiResponse($successfulCandidate->toArray());
    }

    /**
     * @test
     */
    public function test_update_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->create();
        $editedSuccessfulCandidate = factory(SuccessfulCandidate::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/successful_candidates/'.$successfulCandidate->id,
            $editedSuccessfulCandidate
        );

        $this->assertApiResponse($editedSuccessfulCandidate);
    }

    /**
     * @test
     */
    public function test_delete_successful_candidate()
    {
        $successfulCandidate = factory(SuccessfulCandidate::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/successful_candidates/'.$successfulCandidate->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/successful_candidates/'.$successfulCandidate->id
        );

        $this->response->assertStatus(404);
    }
}
