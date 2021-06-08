<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Images extends Model
{
    use SoftDeletes;

    protected $table = 'images';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];

    public function parent()
    {
        return $this->morphTo();
    }
}
