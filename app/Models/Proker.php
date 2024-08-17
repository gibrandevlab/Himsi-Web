<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proker extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'proker';

    // The attributes that are mass assignable.
    protected $fillable = [
        'id',
        'divisi',
        'fotokegiatan',
        'title',
        'content',
        'created_at',
    ];

    // If you have timestamps in your table
    public $timestamps = true;
}
