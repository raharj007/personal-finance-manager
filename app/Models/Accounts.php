<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accounts extends Model
{
    use SoftDeletes;

    protected $table = 'accounts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];

    public function account_group()
    {
        return $this->belongsTo(AccountGroup::class, 'account_group_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'account_id', 'id');
    }
}
