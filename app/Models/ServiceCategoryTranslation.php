<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'service_category_id',
    'locale',
    'name',
    'slug',
    'excerpt',
    'description',
    'seo_title',
    'seo_description',
    'seo_keywords',
])]
class ServiceCategoryTranslation extends Model
{
    /**
     * @return BelongsTo<ServiceCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
