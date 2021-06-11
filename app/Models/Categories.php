<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['type', 'name'];

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'category_id', 'id');
    }
}
