<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration {public function up():void{Schema::create('product_variants',function(Blueprint $t){$t->id();$t->foreignId('product_id')->constrained()->cascadeOnDelete();$t->string('size',10);$t->string('color',50);$t->unsignedInteger('stock')->default(0);$t->string('sku',80)->unique();$t->timestamps();$t->unique(['product_id','size','color']);});}public function down():void{Schema::dropIfExists('product_variants');}};
