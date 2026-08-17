<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\ResetPasswordEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Support\Casts\PhoneCast;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'oldid',
        'phone',
        'avatar',
        'birthdate',
        'bonus',
        'ball',
        'cashback',
        'user_id',
        'user_role_id',
        'user_connection_id',
        'manager_reserve',
        'senior',
        'senior_id',
        'inn',
        'passport',
        'passport_issued_at',
        'passport_issued_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
      //  'phone' => PhoneCast::class,
    ];

    protected function thumbnailDir(): string
    {
          return 'images';
    }


    public function parent():BelongsTo
    {
        return $this->belongsTo(UserRole::class,  'user_role_id');
    }


    public function connection():BelongsTo
    {
        return $this->belongsTo(UserConnection::class,  'user_connection_id');
    }



    public function manager():BelongsTo
    {
        return $this->belongsTo(self::class,  'user_id');
    }



    public function users():HasMany
    {
        return $this->hasMany(self::class,  'user_id');
    }


    public function fixed_manager():BelongsTo
    {
        return $this->belongsTo(self::class,  'senior_id');
    }







    /**
     * Замена стандартного сброса пароля
     */

    public function sendPasswordResetNotification($token)
    {

        settype($data, "array");
        $data['email'] = $this->getEmailForPasswordReset();
        $data['token'] = $token;

        /**
         * Событие отправка сообщения о сбросе пароля
         */

        ResetPasswordEvent::dispatch($data);
    }
}
