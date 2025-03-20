<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'price', 'quantity', 'image', 
        'is_best_seller', 'is_new_arrival', 'is_hot_sale', 
        'slug', 'status', 'category_id', 'sub_category_id'
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relationship with SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    // Boot method to handle slug creation and default status
    protected static function booted()
    {
        static::creating(function ($product) {
            if (!$product->slug) {
                $slug = Str::slug($product->title);
                $count = Product::where('slug', 'LIKE', "$slug%")->count();
                $product->slug = $count ? "{$slug}-{$count}" : $slug;
            }

            if (is_null($product->status)) {
                $product->status = 0;
            }
        });
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
