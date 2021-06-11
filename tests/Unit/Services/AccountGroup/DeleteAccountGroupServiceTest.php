<?php

namespace Tests\Unit\Services\AccountGroup;

use App\Repositories\AccountGroup\AccountGroupRepositoryInterface;
use App\Services\AccountGroup\DeleteService;
use App\Services\Core\ResultService;
use Tests\TestCase;

class DeleteAccountGroupServiceTest extends TestCase
{
    public function testDeleteAccountGroupSuccess()
    {
        $expected = ResultService::success();
        $repository = \Mockery::mock(AccountGroupRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $service = new DeleteService($repository);
        $result = $service->destroy(1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteAccountGroupFailed()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(AccountGroupRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(0);
        $service = new DeleteService($repository);
        $result = $service->destroy(1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteAccountGroupThrowException()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(AccountGroupRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andThrow(new \Exception());
        $service = new DeleteService($repository);
        $result = $service->destroy(1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
