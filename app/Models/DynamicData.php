<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicData extends Model
{
    use HasFactory;

    protected $fillable = [
        'uploaded_file_id',
        'column_name',
        'data_type',
        'cell_value',
    ];
}
