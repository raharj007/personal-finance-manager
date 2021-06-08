<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountGroup extends Model
{
    use SoftDeletes;

    protected $table = 'account_group';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function account()
    {
        return $this->hasMany(Accounts::class, 'account_group_id', 'id');
    }
}
