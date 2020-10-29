<?php namespace Tests\Repositories;

use App\Models\Answer;
use App\Repositories\AnswerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AnswerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnswerRepository
     */
    protected $answerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->answerRepo = \App::make(AnswerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_answer()
    {
        $answer = factory(Answer::class)->make()->toArray();

        $createdAnswer = $this->answerRepo->create($answer);

        $createdAnswer = $createdAnswer->toArray();
        $this->assertArrayHasKey('id', $createdAnswer);
        $this->assertNotNull($createdAnswer['id'], 'Created Answer must have id specified');
        $this->assertNotNull(Answer::find($createdAnswer['id']), 'Answer with given id must be in DB');
        $this->assertModelData($answer, $createdAnswer);
    }

    /**
     * @test read
     */
    public function test_read_answer()
    {
        $answer = factory(Answer::class)->create();

        $dbAnswer = $this->answerRepo->find($answer->id);

        $dbAnswer = $dbAnswer->toArray();
        $this->assertModelData($answer->toArray(), $dbAnswer);
    }

    /**
     * @test update
     */
    public function test_update_answer()
    {
        $answer = factory(Answer::class)->create();
        $fakeAnswer = factory(Answer::class)->make()->toArray();

        $updatedAnswer = $this->answerRepo->update($fakeAnswer, $answer->id);

        $this->assertModelData($fakeAnswer, $updatedAnswer->toArray());
        $dbAnswer = $this->answerRepo->find($answer->id);
        $this->assertModelData($fakeAnswer, $dbAnswer->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_answer()
    {
        $answer = factory(Answer::class)->create();

        $resp = $this->answerRepo->delete($answer->id);

        $this->assertTrue($resp);
        $this->assertNull(Answer::find($answer->id), 'Answer should not exist in DB');
    }
}
