<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'id',
        'nombre',
        'activo',
        'borrado',
    ];

    public $timestamps = false;

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'LIKE', '%' . $search . '%');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}
