<?php

namespace Tests\Unit\Services\Images;

use App\Repositories\Images\ImagesRepositoryInterface;
use App\Services\Images\CreateService;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CreateImageServiceTest extends TestCase
{
    public function testInsertImagesSuccess()
    {
        $trans_id = '82be072a53f541a38cb08e87285695b0';
        $user_id = '7f9c04160e504aba8ba4eac9e9275e1f';

        $request = \Mockery::mock(Request::class);
        $uuid = \Mockery::mock(Uuid::class);
        $uuid->shouldReceive('uuid4->getHex')->andReturn('test');
        $request->shouldReceive([
            'getClientOriginalExtension' => 'jpeg',
            'storeAs' => 'string_path_to_file',
        ]);
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('insert')->once()->andReturnTrue();
        $service = new CreateService($repository);
        $result = $service->uploads([$request], $user_id, $trans_id);
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    public function testCreateImageSuccess()
    {
        $user_id = '7f9c04160e504aba8ba4eac9e9275e1f';

        $data = (object)[
            'id' => 'test',
            'url' => 'url_to_file',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $request = \Mockery::mock(Request::class);
        $uuid = \Mockery::mock(Uuid::class);
        $uuid->shouldReceive('uuid4->getHex')->andReturn('test');
        $request->shouldReceive([
            'getClientOriginalExtension' => 'jpeg',
            'storeAs' => 'string_path_to_file',
        ]);
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andReturn($data);
        $service = new CreateService($repository);
        $result = $service->uploads($request, $user_id);
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    public function testInsertReturnException()
    {
        $trans_id = '82be072a53f541a38cb08e87285695b0';
        $user_id = '7f9c04160e504aba8ba4eac9e9275e1f';

        $request = \Mockery::mock(Request::class);
        $uuid = \Mockery::mock(Uuid::class);
        $uuid->shouldReceive('uuid4->getHex')->andReturn('test');
        $request->shouldReceive([
            'getClientOriginalExtension' => 'jpeg',
            'storeAs' => 'string_path_to_file',
        ]);
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('insert')->once()->andThrow(new \Exception());
        $service = new CreateService($repository);
        $this->expectException(\Exception::class);
        $service->uploads([$request], $user_id, $trans_id);
    }

    public function testCreateReturnException()
    {
        $user_id = '7f9c04160e504aba8ba4eac9e9275e1f';

        $request = \Mockery::mock(Request::class);
        $uuid = \Mockery::mock(Uuid::class);
        $uuid->shouldReceive('uuid4->getHex')->andReturn('test');
        $request->shouldReceive([
            'getClientOriginalExtension' => 'jpeg',
            'storeAs' => 'string_path_to_file',
        ]);
        $repository = \Mockery::mock(ImagesRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andThrow(new \Exception());
        $service = new CreateService($repository);
        $this->expectException(\Exception::class);
        $service->uploads($request, $user_id);
    }
}
