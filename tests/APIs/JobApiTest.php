<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Job;

class JobApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_job()
    {
        $job = factory(Job::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/jobs', $job
        );

        $this->assertApiResponse($job);
    }

    /**
     * @test
     */
    public function test_read_job()
    {
        $job = factory(Job::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/jobs/'.$job->id
        );

        $this->assertApiResponse($job->toArray());
    }

    /**
     * @test
     */
    public function test_update_job()
    {
        $job = factory(Job::class)->create();
        $editedJob = factory(Job::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/jobs/'.$job->id,
            $editedJob
        );

        $this->assertApiResponse($editedJob);
    }

    /**
     * @test
     */
    public function test_delete_job()
    {
        $job = factory(Job::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/jobs/'.$job->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/jobs/'.$job->id
        );

        $this->response->assertStatus(404);
    }
}
