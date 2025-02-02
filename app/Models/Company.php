<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'name',
        'url',
        'status',
        'description',
        'colors',
        'keywords',
        'scraped_at',
    ];

    protected $casts = [
        'colors' => 'json',
        'keywords' => 'json',
    ];

    public function companyType(): BelongsToMany
    {
        return $this->belongsToMany(CompanyType::class, 'company_type');
    }
}
