<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{Schema::table('users',function(Blueprint $t){if(!Schema::hasColumn('users','role'))$t->string('role',20)->default('customer');if(!Schema::hasColumn('users','phone'))$t->string('phone',20)->nullable();if(!Schema::hasColumn('users','address'))$t->string('address',255)->nullable();});}
 public function down():void{Schema::table('users',function(Blueprint $t){$t->dropColumn(['role','phone','address']);});}
};
