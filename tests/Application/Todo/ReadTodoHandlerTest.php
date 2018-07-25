<?php

namespace AgoraApi\Application\Todo;

use PHPUnit\Framework\TestCase;
use AgoraApi\Domain\Todo;
use AgoraApi\Infrastructure\MemoryTodoRepository;

class ReadTodoHandlerTest extends TestCase
{
    private $todoRepository;

    protected function setUp()
    {
        $this->todoRepository = new MemoryTodoRepository;
        $this->createTodoHandler = new CreateTodoHandler($this->todoRepository);
        $this->readTodoHandler = new ReadTodoHandler($this->todoRepository);
    }

    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldReadTodo()
    {
        $uid = $this->todoRepository->nextIdentity();
        $command = new CreateTodoCommand([
            "uid" => $uid,
            "title" => "Not sure?",
            "order" => 27,
        ]);
        $this->createTodoHandler->handle($command);

        $query = new ReadTodoQuery([
            "uid" => $uid,
        ]);
        $todo = $this->readTodoHandler->handle($query);

        $this->assertEquals("Not sure?", $todo->title());
    }
}
