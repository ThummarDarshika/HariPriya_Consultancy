<?php

namespace App\Models;

use Database\Factories\SiteAssetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAsset extends Model
{
    /** @use HasFactory<SiteAssetFactory> */
    use HasFactory;

    protected $fillable = ['key', 'page', 'label', 'kind', 'value'];
}
