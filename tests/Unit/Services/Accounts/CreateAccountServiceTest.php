<?php

namespace Tests\Unit\Services\Accounts;

use App\Repositories\Accounts\AccountsRepositoryInterface;
use App\Services\Accounts\CreateService;
use App\Services\Core\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateAccountServiceTest extends TestCase
{
    public function testCreateAccountSuccess()
    {
        $reqData = [
            'account_group_id' => 1,
            'user_id' => '7f9c04160e504aba8ba4eac9e9275e1f',
            'name' => 'test',
        ];

        $data = (object)[
            'id' => '82be072a53f541a38cb08e87285695b0',
            'account_group_id' => 1,
            'user_id' => '7f9c04160e504aba8ba4eac9e9275e1f',
            'name' => 'test',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $expected = ResultService::success($data);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andReturn($data);
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testCreateAccountFailed()
    {
        $reqData = [
            'account_group_id' => 1,
            'user_id' => '7f9c04160e504aba8ba4eac9e9275e1f',
            'name' => 'test',
        ];

        $expected = ResultService::error();

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andThrow(new \Exception());
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertEquals($expected, $result);
    }

    public function testValidationFailed()
    {
        $message = 'The account group id field is required.';
        $expected = ResultService::error($message);
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn(['name' => 'test']);
        $repository = \Mockery::mock(AccountsRepositoryInterface::class);
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
