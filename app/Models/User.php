<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Resident;

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
        'role',
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
    ];

    /**
     * Automatically sync newly registered resident accounts to the residents table.
     */
    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role === 'resident') {
                Resident::firstOrCreate(
                    ['name' => $user->name],
                    [
                        'resident_id' => '#RES-' . rand(1000, 9999),
                        'address'     => 'Barangay Proper',
                        'contact'     => 'N/A',
                        'status'      => 'Active',
                    ]
                );
            }
        });
    }
}