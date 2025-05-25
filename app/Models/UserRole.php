<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'roles'; // pastikan nama tabel sesuai migration dan seeder


    protected $fillable = [
        'name',
        'company_code',
        'status',
        'is_deleted',
        'created_by',
        'created_date',
        'last_update_by',
        'last_update_date',
    ];

    protected function casts(): array
    {
        return [
            'CreatedDate' => 'datetime',
            'LastUpdateDate' => 'datetime',
        ];
    }

    /**
     * Relasi satu ke banyak: satu role bisa dimiliki banyak user.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}