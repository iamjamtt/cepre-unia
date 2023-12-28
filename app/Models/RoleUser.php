<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function roles(): BelongsTo
    {
        return $this->belongsTo(Roles::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
