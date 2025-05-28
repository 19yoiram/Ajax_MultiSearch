<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
     use HasFactory;
    public function category() { return $this->belongsTo(Category::class); }
    public function brand() { return $this->belongsTo(Brand::class); }
    public function attributes() { return $this->hasMany(ProductAttribute::class); }

    public function scopeFilter($query, $filters) {
    if (!empty($filters['q'])) {
        $q = $filters['q'];
        $query->where(function ($q2) use ($q) {
            $q2->where('title', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%")
                ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%$q%"))
                ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%$q%"));
        });
    }

    if (!empty($filters['categories'])) {
        $query->whereIn('category_id', $filters['categories']);
    }

    if (!empty($filters['brands'])) {
        $query->whereIn('brand_id', $filters['brands']);
    }

    if (!empty($filters['min_price'])) {
        $query->where('price', '>=', $filters['min_price']);
    }

    if (!empty($filters['max_price'])) {
        $query->where('price', '<=', $filters['max_price']);
    }

    if (!empty($filters['rating'])) {
        $query->where('rating', '>=', $filters['rating']);
    }

   if (!empty($filters['attributes']) && is_array($filters['attributes'])) {
    foreach ($filters['attributes'] as $key => $values) {
        $query->whereHas('attributes', function ($q) use ($key, $values) {
            $q->where('key', $key)->whereIn('value', $values);
        });
    }
}


    if (!empty($filters['sort_by'])) {
        match($filters['sort_by']) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'latest' => $query->orderBy('created_at', 'desc'),
        };
    }

    return $query;
}

}
