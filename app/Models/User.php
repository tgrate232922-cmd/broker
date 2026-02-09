<?php

namespace App\Models;

use App\Models\Settings;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $settings = Settings::where('id', 1)->first();

        if ($settings && $settings->enable_verification === 'true') {
            $this->notify(new VerifyEmail);
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'l_name',
        'email',
        'phone',
        'country',
        'password',
        'ref_by',
        'status',
        'taxtype',
        'taxamount',
        'currency',
        'notify',
        'username',
        'email_verified_at',
        'account_bal',
        'roi',
        'bonus',
        'ref_bonus',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * Jetstream's HasProfilePhoto trait provides `profile_photo_url`,
     * so keep it appended.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * IMPORTANT FIX:
     * Jetstream generates `profile_photo_url` via this method.
     * Your public files are served from `/account/storage/...` (not `/storage/...`),
     * so we override the URL generator to match your symlink.
     */
    public function getProfilePhotoUrlAttribute()
{
    return $this->profile_photo_path
        ? asset('storage/' . $this->profile_photo_path)
        : asset('images/default-avatar.png');
}


    public function dp()
    {
        return $this->hasMany(Deposit::class, 'user');
    }

    public function wd()
    {
        return $this->hasMany(Withdrawal::class, 'user');
    }

    public function tuser()
    {
        return $this->belongsTo(Admin::class, 'assign_to');
    }

    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan');
    }

    public function plans()
    {
        return $this->hasMany(User_plans::class, 'user', 'id');
    }

    public function uplans()
    {
        return $this->hasMany(Investment::class, 'user', 'id');
    }

    public static function search($search): \Illuminate\Database\Eloquent\Builder
    {
        return empty($search)
            ? static::query()
            : static::query()
                ->where('id', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
    }
}