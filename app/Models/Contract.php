<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Contract extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'contract_number',
        'title',
        'city_departure',
        'city_arrival',
        'user_id',
        'date_departure',
        'date_arrival',
        'days_count',
        'hotel_id',
        'hotel_custom',
        'tour_price',
        'framework_url',
        'public_token',
        'is_signed',
        'contract_room_id',
        'contract_food_id',
        'people',
        'transfer',
        'excursion_program',
        'russian_speaking_guide',
        'visa_support',
        'medical_support',
        'passport',
        'passport_issued_at',
        'passport_issued_by',
        'inn',
    ];

    protected $casts = [
        'date_departure' => 'date',
        'date_arrival'   => 'date',
        'is_signed'      => 'boolean',
        'people'         => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (!$model->contract_number) {
                $model->contract_number = DB::transaction(function () {
                    $prefix = now()->format('Y/m');

                    $last = static::where('contract_number', 'like', $prefix . '/%')
                        ->lockForUpdate()
                        ->max('contract_number');

                    $next = $last ? ((int) Str::afterLast($last, '/') + 1) : 1;

                    return $prefix . '/' . str_pad($next, 2, '0', STR_PAD_LEFT);
                });
            }

            if (!$model->public_token) {
                $model->public_token = Str::random(64);
            }
        });
    }

    public function getPublicUrlAttribute(): string
    {
        return route('contract.public', $this->public_token);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(ContractRoom::class, 'contract_room_id');
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(ContractFood::class, 'contract_food_id');
    }
}
