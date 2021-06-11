<?php

namespace Tests\Unit\Services\AccountGroup;

use App\Repositories\AccountGroup\AccountGroupRepositoryInterface;
use App\Services\AccountGroup\CreateService;
use App\Services\Core\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateAccountGroupServiceTest extends TestCase
{
    public function testCreateAccountGroupSuccess()
    {
        $reqData = [
            'name' => 'test',
        ];

        $data = (object)[
            'id' => 1,
            'name' => 'test',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $expected = ResultService::success($data);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(AccountGroupRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andReturn($data);
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testCreateAccountGroupFailed()
    {
        $reqData = [
            'name' => 'test',
        ];

        $expected = ResultService::error();

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(AccountGroupRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andThrow(new \Exception());
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertEquals($expected, $result);
    }

    public function testValidationFailed()
    {
        $message = 'The name field is required.';
        $expected = ResultService::error($message);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn([]);
        $repository = \Mockery::mock(AccountGroupRepositoryInterface::class);
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
