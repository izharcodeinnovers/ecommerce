<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionRule extends Model
{
    protected $fillable = [
        'name',
        'rule_type',
        'conditions_json',
    ];

    protected function casts(): array
    {
        return [
            'conditions_json' => 'array',
        ];
    }
}
