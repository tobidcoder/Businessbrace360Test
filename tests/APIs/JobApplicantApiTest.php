<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\JobApplicant;

class JobApplicantApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/job_applicants', $jobApplicant
        );

        $this->assertApiResponse($jobApplicant);
    }

    /**
     * @test
     */
    public function test_read_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/job_applicants/'.$jobApplicant->id
        );

        $this->assertApiResponse($jobApplicant->toArray());
    }

    /**
     * @test
     */
    public function test_update_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->create();
        $editedJobApplicant = factory(JobApplicant::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/job_applicants/'.$jobApplicant->id,
            $editedJobApplicant
        );

        $this->assertApiResponse($editedJobApplicant);
    }

    /**
     * @test
     */
    public function test_delete_job_applicant()
    {
        $jobApplicant = factory(JobApplicant::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/job_applicants/'.$jobApplicant->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/job_applicants/'.$jobApplicant->id
        );

        $this->response->assertStatus(404);
    }
}
