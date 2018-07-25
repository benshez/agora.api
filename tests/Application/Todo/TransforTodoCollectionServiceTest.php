<?php

namespace AgoraApi\Application\Todo;

use PHPUnit\Framework\TestCase;
use AgoraApi\Domain\Todo;
use AgoraApi\Infrastructure\MemoryTodoRepository;

class TransformTodoCollectionServiceTest extends TestCase
{
    private $todoRepository;
    private $createTodoHandler;
    private $readTodoCollectionHandler;
    private $transformTodoCollectionService;

    protected function setUp()
    {
        $this->todoRepository = new MemoryTodoRepository;
        $this->createTodoHandler = new CreateTodoHandler($this->todoRepository);
        $this->readTodoCollectionHandler = new ReadTodoCollectionHandler($this->todoRepository);
        $this->transformTodoCollectionService = new TransformTodoCollectionService($this->todoRepository);
    }

    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldTransformTodo()
    {
        $command = new CreateTodoCommand([
            "uid" => $this->todoRepository->nextIdentity(),
            "title" => "Not sure?",
            "order" => 27,
        ]);
        $this->createTodoHandler->handle($command);

        $command = new CreateTodoCommand([
            "uid" => $this->todoRepository->nextIdentity(),
            "title" => "Brawndo!",
            "order" => 66,
        ]);
        $this->createTodoHandler->handle($command);

        $collection = $this->readTodoCollectionHandler->handle();
        $transformed =$this->transformTodoCollectionService->execute($collection);

        $this->assertCount(2, $transformed["data"]);
        $this->assertArrayHasKey("uid", $transformed["data"][0]);
        $this->assertArrayHasKey("order", $transformed["data"][0]);
        $this->assertArrayHasKey("title", $transformed["data"][0]);
        $this->assertArrayHasKey("completed", $transformed["data"][0]);
        $this->assertArrayHasKey("links", $transformed["data"][0]);
    }
}
