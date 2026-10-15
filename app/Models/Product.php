<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Product extends Model {
 protected $fillable=['category_id','name','slug','description','price','image','is_active'];
 protected function casts(): array { return ['price'=>'decimal:2','is_active'=>'boolean']; }
 public function category(): BelongsTo { return $this->belongsTo(Category::class); }
 public function variants(): HasMany { return $this->hasMany(ProductVariant::class); }
 public function reviews(): HasMany { return $this->hasMany(Review::class); }
 public function orderItems(): HasMany { return $this->hasMany(OrderItem::class); }
}
