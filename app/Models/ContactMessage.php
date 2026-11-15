<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $table = 'contact_messages';

    public $timestamps = false; // <-- Add this line to disable automatic timestamps

    protected $fillable = [
        'email',
        'subject',
        'message',
    ];
}