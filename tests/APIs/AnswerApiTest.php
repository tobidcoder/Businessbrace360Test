<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Answer;

class AnswerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_answer()
    {
        $answer = factory(Answer::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/answers', $answer
        );

        $this->assertApiResponse($answer);
    }

    /**
     * @test
     */
    public function test_read_answer()
    {
        $answer = factory(Answer::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/answers/'.$answer->id
        );

        $this->assertApiResponse($answer->toArray());
    }

    /**
     * @test
     */
    public function test_update_answer()
    {
        $answer = factory(Answer::class)->create();
        $editedAnswer = factory(Answer::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/answers/'.$answer->id,
            $editedAnswer
        );

        $this->assertApiResponse($editedAnswer);
    }

    /**
     * @test
     */
    public function test_delete_answer()
    {
        $answer = factory(Answer::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/answers/'.$answer->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/answers/'.$answer->id
        );

        $this->response->assertStatus(404);
    }
}
