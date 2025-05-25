<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'company_code',
        'status',
        'is_deleted',
        'created_by',
        'created_date',
        'last_update_by',
        'last_update_date',
    ];

    public $timestamps = false;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}