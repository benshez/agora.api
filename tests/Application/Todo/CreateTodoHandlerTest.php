<?php

namespace AgoraApi\Application\Todo;

use PHPUnit\Framework\TestCase;
use AgoraApi\Domain\Todo;
use AgoraApi\Infrastructure\MemoryTodoRepository;

class CreateTodoHandlerTest extends TestCase
{
    private $todoRepository;

    protected function setUp()
    {
        $this->todoRepository = new MemoryTodoRepository;
        $this->createTodoHandler = new CreateTodoHandler($this->todoRepository);
        $this->latestTodoHandler = new LatestTodoHandler($this->todoRepository);
    }

    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldCreateTodo()
    {
        $command = new CreateTodoCommand([
            "uid" => $this->todoRepository->nextIdentity(),
            "title" => "Not sure?",
            "order" => 27,
        ]);
        $this->createTodoHandler->handle($command);
        $todo = $this->latestTodoHandler->handle();

        $this->assertInstanceOf(Todo::class, $todo);
    }
}
