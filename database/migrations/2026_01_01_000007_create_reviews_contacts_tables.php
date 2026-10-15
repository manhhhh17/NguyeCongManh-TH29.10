<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration {public function up():void{
Schema::create('reviews',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();$t->foreignId('order_id')->nullable()->constrained()->nullOnDelete();$t->string('review_type',20)->default('product');$t->unsignedTinyInteger('rating');$t->text('comment')->nullable();$t->timestamps();$t->index(['review_type','product_id']);});
Schema::create('contacts',function(Blueprint $t){$t->id();$t->string('name',100);$t->string('email',150);$t->string('phone',20)->nullable();$t->string('subject',150);$t->text('message');$t->string('status',20)->default('new');$t->timestamps();});
}public function down():void{Schema::dropIfExists('contacts');Schema::dropIfExists('reviews');}};
