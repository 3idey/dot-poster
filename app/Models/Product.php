<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'slug',
        'stock',
        'status',
        'image',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            // Generate a unique slug on create
            $base = Str::slug($product->name) ?: Str::random(8);
            $slug = $base;
            $i = 1;
            while (static::where('slug', $slug)->exists()) {
                $slug = $base.'-'.$i;
                $i++;
            }
            $product->slug = $slug;
        });

        static::updating(function ($product) {
            // Only adjust slug if the name changed
            if ($product->isDirty('name')) {
                $base = Str::slug($product->name) ?: Str::random(8);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $base.'-'.$i;
                    $i++;
                }
                $product->slug = $slug;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Inventory management methods
    public function isLowStock($threshold = 5)
    {
        return $this->stock <= $threshold;
    }

    public function isOutOfStock()
    {
        return $this->stock <= 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        } elseif ($this->isLowStock()) {
            return 'low_stock';
        }

        return 'in_stock';
    }
}
