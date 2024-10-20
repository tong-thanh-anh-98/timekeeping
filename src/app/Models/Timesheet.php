<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timesheet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'date',
        'note',
    ];

    public static function getAllUserTimesheets($userId)
    {
        return self::where('user_id', $userId)->orderBy('date', 'asc')->get();
    }
}
