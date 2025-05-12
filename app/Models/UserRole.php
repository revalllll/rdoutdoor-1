<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'user_roles'; // pastikan nama tabel sesuai

    protected $fillable = [
        'role_name',
        'CompanyCode',
        'Status',
        'IsDeleted',
        'CreatedBy',
        'CreatedDate',
        'LastUpdateBy',
        'LastUpdateDate',
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