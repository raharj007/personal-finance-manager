<?php

namespace Tests\Unit\Services\Images;

use App\Repositories\Images\ImagesRepositoryInterface;
use App\Services\Core\ResultService;
use App\Services\Images\DeleteService;
use Tests\TestCase;

class DeleteImageServiceTest extends TestCase
{
    public function testDeleteImagesByIDSuccess()
    {
        $params = (object)[
            'type' => DeleteService::DELETE_BY_ID,
            'id' => 'test_id',
        ];
        $expected = ResultService::success();
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $service = new DeleteService($repository);
        $result = $service->destroy($params);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteImagesByParentIDSuccess()
    {
        $params = (object)[
            'type' => DeleteService::DELETE_BY_PARENT,
            'id' => 'test_id',
        ];
        $expected = ResultService::success();
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $service = new DeleteService($repository);
        $result = $service->destroy($params);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteImagesFailed()
    {
        $params = (object)[
            'type' => DeleteService::DELETE_BY_ID,
            'id' => 'test_id',
        ];
        $expected = ResultService::error();
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(0);
        $service = new DeleteService($repository);
        $result = $service->destroy($params);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteImagesThrowException()
    {
        $params = (object)[
            'type' => DeleteService::DELETE_BY_ID,
            'id' => 'test_id',
        ];
        $expected = ResultService::error();
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andThrow(new \Exception());
        $service = new DeleteService($repository);
        $result = $service->destroy($params);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
