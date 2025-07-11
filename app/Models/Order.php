<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'address', // alamat penyewa
        'total_price',
        'order_date',
        'start_date',
        'end_date',
        'status', // hanya status huruf kecil
        'CompanyCode',
        'IsDeleted',
        'CreatedBy',
        'CreatedDate',
        'LastUpdateBy',
        'LastUpdateDate',
    ];

    public $timestamps = false;

    // Mapping status string ke label
    public function getStatusLabelAttribute()
    {
        // Jika status null/kosong, anggap pending
        if (empty($this->status)) {
            return 'Pending';
        }
        switch ($this->status) {
            case 'pending':
                return 'Pending';
            case 'for rent':
                return 'For Rent';
            case 'selesai':
                return 'Selesai';
            case 'batal':
                return 'Batal';
            default:
                return 'Pending';
        }
    }

    public function getStatusBadgeAttribute()
    {
        // Jika status null/kosong, anggap warning
        if (empty($this->status)) {
            return 'warning';
        }
        switch ($this->status) {
            case 'pending':
                return 'warning';
            case 'for rent':
                return 'info';
            case 'selesai':
                return 'success';
            case 'batal':
                return 'danger';
            default:
                return 'warning';
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}