<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'certificate_id',
        'resident_name',
        'name',
        'certificate_type',
        'type',
        'purpose',
        'status',
    ];

    /**
     * Get the user that owns the certificate request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}