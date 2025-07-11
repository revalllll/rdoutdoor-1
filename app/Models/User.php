<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'company_code',
        'status',
        'is_deleted',
        'created_by',
        'created_date',
        'last_update_by',
        'last_update_date',
        'first_name',
        'last_name',
        'dob',
        'phone',
        'country',
        'city',
        'postal_code',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;

        
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }
}