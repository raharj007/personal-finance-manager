<?php

namespace Tests\Unit\Services\Transactions;

use App\Repositories\Transactions\TransactionsRepositoryInterface;
use App\Services\Core\ResultService;
use App\Services\Transactions\DeleteService;
use Tests\TestCase;

class DeleteTransactionServiceTest extends TestCase
{
    public function testDeleteTransactionSuccess()
    {
        $expected = ResultService::success();
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $images = \Mockery::mock(\App\Services\Images\DeleteService::class);
        $images->shouldReceive('destroy')->once()->andReturn($expected);
        $service = new DeleteService($repository, $images);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteTransactionSuccessWithDeleteImageReturnNotFound()
    {
        $expected = ResultService::success();
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $images = \Mockery::mock(\App\Services\Images\DeleteService::class);
        $images->shouldReceive('destroy')->once()->andReturn(ResultService::error(ResultService::DATA_NOT_FOUND_MSG));
        $service = new DeleteService($repository, $images);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteTransactionFailed()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(0);
        $images = \Mockery::mock(\App\Services\Images\DeleteService::class);
        $images->shouldReceive('destroy')->once()->andReturn(ResultService::success());
        $service = new DeleteService($repository, $images);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteTransactionImageFailed()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $images = \Mockery::mock(\App\Services\Images\DeleteService::class);
        $images->shouldReceive('destroy')->once()->andReturn($expected);
        $service = new DeleteService($repository, $images);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteTransactionThrowException()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andThrow(new \Exception());
        $images = \Mockery::mock(\App\Services\Images\DeleteService::class);
        $images->shouldReceive('destroy')->once()->andReturn(ResultService::success());
        $service = new DeleteService($repository, $images);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
