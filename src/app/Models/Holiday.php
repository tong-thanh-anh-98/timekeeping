<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'holidays';
    protected $fillable = [
        'title',
        'start',
        'end',
        'color',
    ];

    // Private function để lấy danh sách ngày lễ
    private static function getHolidays()
    {
        return self::all();
    }

    // Public function để gọi private function
    public static function fetchHolidays()
    {
        return self::getHolidays();
    }
}
