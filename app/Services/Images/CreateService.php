<?php


namespace App\Services\Images;


use App\Models\Transactions;
use App\Repositories\Images\ImagesRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class CreateService
{
    protected $repository;
    public function __construct(ImagesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    private function path(string $user_id, string $transaction_id = null): string
    {
        return 'public/img/' . $user_id . '/' . ($transaction_id ?? 'avatar');
    }

    private function fileName($file, string $id): string
    {
        return $id . '.' . $file->getClientOriginalExtension();
    }

    private function store($file, string $id, string $user_id, string $transaction_id = null): string
    {
        return $file->storeAs($this->path($user_id, $transaction_id), $this->fileName($file, $id));
    }

    private function parent($flag): string
    {
        return $flag == null ? User::class : Transactions::class;
    }

    private function values(string $id, string $path, string $parent_id, string $parent_type): array
    {
        return [
            'id' => $id,
            'url' => Storage::url($path),
            'parent_id' => $parent_id,
            'parent_type' => $parent_type,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * @throws \Exception
     */
    public function uploads($files, string $user_id, string $transaction_id = null): bool
    {
        $temp = [];
        try {
            if (gettype($files) == 'array') {
                $values = [];
                foreach ($files as $file) {
                    $id = Uuid::uuid4()->getHex();
                    $stored = $this->store($file, $id, $user_id, $transaction_id);
                    $temp[] = $stored;
                    $values[] = $this->values(
                        $id,
                        $stored,
                        ($transaction_id ?? $user_id),
                        $this->parent($transaction_id)
                    );
                }
                $this->repository->insert($values);
            } else {
                $id = Uuid::uuid4()->getHex();
                $stored = $this->store($files, $id, $user_id, $transaction_id);
                $temp[] = $stored;
                $this->repository->create($this->values(
                    $id,
                    $stored,
                    ($transaction_id ?? $user_id),
                    $this->parent($transaction_id)
                ));
            }
        } catch (\Exception $exception) {
            if (!empty($temp)) {
                foreach ($temp as $file) {
                    Storage::delete($file);
                }
            }
            Log::error($exception->getMessage());
            throw new \Exception($exception);
        }
        return true;
    }
}
