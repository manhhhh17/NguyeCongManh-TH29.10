<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Order extends Model {
 protected $fillable=['user_id','order_code','recipient_name','phone','shipping_address','subtotal','discount_amount','shipping_fee','total_amount','payment_method','payment_status','status','note'];
 protected function casts(): array { return ['subtotal'=>'decimal:2','discount_amount'=>'decimal:2','shipping_fee'=>'decimal:2','total_amount'=>'decimal:2']; }
 public function user(): BelongsTo { return $this->belongsTo(User::class); }
 public function items(): HasMany { return $this->hasMany(OrderItem::class); }
 public function reviews(): HasMany { return $this->hasMany(Review::class); }
}
