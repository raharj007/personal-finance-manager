<?php

namespace Tests\Unit\Services\Categories;

use App\Repositories\Categories\CategoriesRepositoryInterface;
use App\Services\Categories\DeleteService;
use App\Services\Core\ResultService;
use Tests\TestCase;

class DeleteCategoryServiceTest extends TestCase
{
    public function testDeleteCategorySuccess()
    {
        $expected = ResultService::success();
        $repository = \Mockery::mock(CategoriesRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $service = new DeleteService($repository);
        $result = $service->destroy(1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteCategoryFailed()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(CategoriesRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(0);
        $service = new DeleteService($repository);
        $result = $service->destroy(1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteCategoryThrowException()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(CategoriesRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andThrow(new \Exception());
        $service = new DeleteService($repository);
        $result = $service->destroy(1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
