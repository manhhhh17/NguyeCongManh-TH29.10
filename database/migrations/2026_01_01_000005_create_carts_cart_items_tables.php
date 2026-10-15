<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration {public function up():void{
Schema::create('carts',function(Blueprint $t){$t->id();$t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();$t->timestamps();});
Schema::create('cart_items',function(Blueprint $t){$t->id();$t->foreignId('cart_id')->constrained()->cascadeOnDelete();$t->foreignId('variant_id')->constrained('product_variants')->cascadeOnDelete();$t->unsignedInteger('quantity');$t->timestamps();$t->unique(['cart_id','variant_id']);});
}public function down():void{Schema::dropIfExists('cart_items');Schema::dropIfExists('carts');}};
