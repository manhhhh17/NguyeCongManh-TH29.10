<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;use App\Models\User;use App\Models\Category;use App\Models\Product;use Illuminate\Support\Facades\Hash;use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
 public function run():void{
 User::updateOrCreate(['email'=>'admin@manhfashion.vn'],['name'=>'Quản trị Mạnh Fashion','password'=>Hash::make('ManhFashion@123'),'role'=>'admin','phone'=>'0988123456','address'=>'Hà Nội']);
 $cats=[['Áo thun','ao-thun'],['Quần jeans','quan-jeans'],['Giày thể thao','giay-the-thao'],['Phụ kiện','phu-kien']];
 foreach($cats as [$n,$s])Category::firstOrCreate(['slug'=>$s],['name'=>$n]);
 $rows=[
 ['Áo thun Essential Oversize','ao-thun-essential','Áo thun cotton mềm, form rộng trẻ trung.','299000','https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=85','ao-thun'],
 ['Áo sơ mi Urban','ao-so-mi-urban','Áo sơ mi tối giản cho đi học và đi chơi.','359000','https://images.unsplash.com/photo-1596755094514-f87e34085b2c?auto=format&fit=crop&w=900&q=85','ao-thun'],
 ['Quần jeans Classic Blue','quan-jeans-blue','Quần jeans denim dễ phối đồ.','499000','https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=900&q=85','quan-jeans'],
 ['Sneaker Street Runner','sneaker-street-runner','Giày thể thao năng động cho outfit hằng ngày.','699000','https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=85','giay-the-thao'],
 ['Túi Mini Everyday','tui-mini-everyday','Túi mini gọn nhẹ đi chơi.','259000','https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=900&q=85','phu-kien'],
 ['Áo khoác Daily Zip','ao-khoac-daily','Áo khoác nhẹ phong cách streetwear.','549000','https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=900&q=85','ao-thun'],
 ['Quần Cargo Active','quan-cargo-active','Quần cargo phong cách năng động.','459000','https://images.unsplash.com/photo-1517438476312-10d79c077509?auto=format&fit=crop&w=900&q=85','quan-jeans'],
 ['Sneaker White Pop','sneaker-white-pop','Sneaker trắng tối giản dễ phối.','629000','https://images.unsplash.com/photo-1495555961986-6d4c1ecb7be3?auto=format&fit=crop&w=900&q=85','giay-the-thao']
 ];
 foreach($rows as [$name,$slug,$desc,$price,$image,$catSlug]){
  $cat=Category::where('slug',$catSlug)->firstOrFail();$p=Product::firstOrCreate(['slug'=>$slug],['category_id'=>$cat->id,'name'=>$name,'description'=>$desc,'price'=>$price,'image'=>$image,'is_active'=>true]);
  foreach(['S','M','L','XL'] as $size)foreach(['Đen','Trắng'] as $color)$p->variants()->firstOrCreate(['size'=>$size,'color'=>$color],['stock'=>20,'sku'=>strtoupper(Str::random(4)).'-'.$p->id.'-'.$size.'-'.$color]);
 }
 }
}
