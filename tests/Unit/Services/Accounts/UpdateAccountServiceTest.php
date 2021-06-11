<?php

namespace Tests\Unit\Services\Accounts;

use App\Repositories\Accounts\AccountsRepositoryInterface;
use App\Services\Accounts\UpdateService;
use App\Services\Core\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateAccountServiceTest extends TestCase
{
    public function testUpdateAccountSuccess()
    {
        $reqData = [
            'name' => 'test',
            'description' => 'test_description'
        ];

        $expected = ResultService::success();

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('update')->once()->andReturn(1);
        $service = new UpdateService($repository);
        $result = $service->update($request, 1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testUpdateAccountReturnNotFound()
    {
        $reqData = [
            'name' => 'test',
            'description' => 'test_description'
        ];

        $expected = ResultService::error(ResultService::DATA_NOT_FOUND_MSG);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('update')->once()->andReturn(0);
        $service = new UpdateService($repository);
        $result = $service->update($request, 1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testUpdateAccountThrowExceptionAndReturnError()
    {
        $reqData = [
            'name' => 'test',
            'description' => 'test_description'
        ];

        $expected = ResultService::error();

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('update')->once()->andThrow(new \Exception());
        $service = new UpdateService($repository);
        $result = $service->update($request, 1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testUpdateAccountValidationFailed()
    {
        $reqData = [
            'name' => '2FyUWPBwkrMkDkLUliG3o40sKGF0NrTZRDijYRt0JAhMupwupDYkmb6nNDoZAB8JX9iedJdSd3EilaHcoQQGSUTFS62YM81fQj0dMTgZQIdZms94Rk79XvMUN0MrNM9Hbqx7zGeR7BWXPaNNPMOxzbR6MQCu6QwNQ36a3xf068qximLadzR67zrXMkH0VZoOxt8oyI8qdNnYq8GV0zq9MdCAYXy4zEq3X0oRjRRAVNYhNCQZYGGaYSHJTsz0nDaI',
            'description' => 'test_description'
        ];

        $message = 'The name may not be greater than 255 characters.';
        $expected = ResultService::error($message);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $service = new UpdateService($repository);
        $result = $service->update($request, 1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
