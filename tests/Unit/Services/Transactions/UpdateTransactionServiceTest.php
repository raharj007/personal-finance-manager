<?php

namespace Tests\Unit\Services\Transactions;

use App\Repositories\Transactions\TransactionsRepositoryInterface;
use App\Services\Core\ResultService;
use App\Services\Images\CreateService;
use App\Services\Transactions\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateTransactionServiceTest extends TestCase
{
    public function testUpdateAccountSuccess()
    {
        $reqData = [
            'user_id' => 'test_user_id',
            'title' => 'test',
            'description' => 'test_description'
        ];

        $expected = ResultService::success();

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive([
            'all' => $reqData,
            'file' => UploadedFile::fake()
        ])->once();
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('update')->once()->andReturn(1);
        $images = \Mockery::mock(CreateService::class);
        $images->shouldReceive('uploads')->once()->andReturnTrue();
        $service = new UpdateService($repository, $images);
        $result = $service->update($request, 'test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testUpdateAccountReturnNotFound()
    {
        $reqData = [
            'user_id' => 'test_user_id',
            'title' => 'test',
            'description' => 'test_description'
        ];

        $expected = ResultService::error(ResultService::DATA_NOT_FOUND_MSG);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive([
            'all' => $reqData,
            'file' => UploadedFile::fake()
        ])->once();
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('update')->once()->andReturn(0);
        $images = \Mockery::mock(CreateService::class);
        $images->shouldReceive('uploads')->once()->andReturnTrue();
        $service = new UpdateService($repository, $images);
        $result = $service->update($request, 'test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testUpdateAccountThrowExceptionAndReturnError()
    {
        $reqData = [
            'user_id' => 'test_user_id',
            'title' => 'test',
            'description' => 'test_description'
        ];

        $expected = ResultService::error();

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive([
            'all' => $reqData,
            'file' => []
        ])->once();
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $repository->shouldReceive('update')->once()->andThrow(new \Exception());
        $images = \Mockery::mock(CreateService::class);
        $service = new UpdateService($repository, $images);
        $result = $service->update($request, 'test_id');
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testUpdateAccountValidationFailed()
    {
        $reqData = [
            'user_id' => 'test_user_id',
            'title' => '2FyUWPBwkrMkDkLUliG3o40sKGF0NrTZRDijYRt0JAhMupwupDYkmb6nNDoZAB8JX9iedJdSd3EilaHcoQQGSUTFS62YM81fQj0dMTgZQIdZms94Rk79XvMUN0MrNM9Hbqx7zGeR7BWXPaNNPMOxzbR6MQCu6QwNQ36a3xf068qximLadzR67zrXMkH0VZoOxt8oyI8qdNnYq8GV0zq9MdCAYXy4zEq3X0oRjRRAVNYhNCQZYGGaYSHJTsz0nDaI',
        ];

        $message = 'The title may not be greater than 255 characters.';
        $expected = ResultService::error($message);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        $repository = \Mockery::mock(TransactionsRepositoryInterface::class);
        $images = \Mockery::mock(CreateService::class);
        $service = new UpdateService($repository, $images);
        $result = $service->update($request, 1);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
