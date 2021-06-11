<?php

namespace Tests\Unit\Services\Accounts;

use App\Repositories\Accounts\AccountsRepositoryInterface;
use App\Services\Accounts\DeleteService;
use App\Services\Core\ResultService;
use Tests\TestCase;

class DeleteAccountServiceTest extends TestCase
{
    public function testDeleteAccountSuccess()
    {
        $expected = ResultService::success();
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(1);
        $service = new DeleteService($repository);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteAccountFailed()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andReturn(0);
        $service = new DeleteService($repository);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testDeleteAccountThrowException()
    {
        $expected = ResultService::error();
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('delete')->once()->andThrow(new \Exception());
        $service = new DeleteService($repository);
        $result = $service->destroy('test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
