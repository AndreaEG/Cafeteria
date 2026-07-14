<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'barcode', 'internal_sku',
        'cost_price', 'sale_price', 'stock', 'min_stock',
        'always_available', 'image_path',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            // RN-01: SKU interno automático si no tiene código de barras
            if (empty($product->barcode) && empty($product->internal_sku)) {
                $last = self::withTrashed()->max('id') + 1;
                $product->internal_sku = 'INT-' . str_pad($last, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}