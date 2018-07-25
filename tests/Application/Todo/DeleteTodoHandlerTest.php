<?php

namespace AgoraApi\Application\Todo;

use PHPUnit\Framework\TestCase;
use AgoraApi\Domain\Todo;
use AgoraApi\Infrastructure\MemoryTodoRepository;

class DeleteTodoHandlerTest extends TestCase
{
    private $todoRepository;
    private $deleteTodoHandler;

    protected function setUp()
    {
        $this->todoRepository = new MemoryTodoRepository;
        $this->createTodoHandler = new CreateTodoHandler($this->todoRepository);
        $this->deleteTodoHandler = new DeleteTodoHandler($this->todoRepository);
        $this->latestTodoHandler = new LatestTodoHandler($this->todoRepository);
    }

    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldDeleteTodo()
    {
        $uid = $this->todoRepository->nextIdentity();

        $command = new CreateTodoCommand([
            "uid" => $uid,
            "title" => "Not sure?",
            "order" => 27,
        ]);
        $this->createTodoHandler->handle($command);
        $todo = $this->latestTodoHandler->handle();

        $command = new DeleteTodoCommand([
            "uid" => $uid
        ]);

        $this->assertTrue($this->todoRepository->contains($todo));
        $this->deleteTodoHandler->handle($command);
        $this->assertFalse($this->todoRepository->contains($todo));
    }
}
