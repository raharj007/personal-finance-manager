<?php

namespace Tests\Unit\Services\Categories;


use App\Repositories\Categories\CategoriesRepositoryInterface;
use App\Services\Categories\CreateService;
use App\Services\Core\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateCategoryServiceTest extends TestCase
{
    public function testCreateCategorySuccess()
    {
        $reqData = [
            'type' => 'in',
            'name' => 'test',
        ];

        $data = (object)[
            'id' => 1,
            'type' => 'in',
            'name' => 'test',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $expected = ResultService::success($data);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(CategoriesRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andReturn($data);
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }

    public function testCreateCategoryFailed()
    {
        $reqData = [
            'type' => 'in',
            'name' => 'test',
        ];

        $expected = ResultService::error();

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn($reqData);
        Validator::shouldReceive('make')->once()->andReturn(\Mockery::mock(['fails' => false]));
        $repository = \Mockery::mock(CategoriesRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andThrow(new \Exception());
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertEquals($expected, $result);
    }

    public function testValidationFailed()
    {
        $message = 'The type field is required.';
        $expected = ResultService::error($message);

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('all')->once()->andReturn(['name' => 'test']);
        $repository = \Mockery::mock(CategoriesRepositoryInterface::class);
        $service = new CreateService($repository);
        $result = $service->create($request);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals($expected, $result);
    }
}
