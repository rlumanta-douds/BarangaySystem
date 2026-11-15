<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificate_requests';

    protected $fillable = [
        'certificate_id',
        'resident_name',
        'certificate_type',
        'purpose',
        'status',
    ];
}