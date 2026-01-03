<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\ProductGallery;
use App\Models\Brand;
use App\Models\ProductSpecificationKey;
use App\Models\ProductSpecification;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use App\Models\OrderProductVariant;
use App\Models\ProductReport;
use App\Models\ProductReview;
use App\Models\Wishlist;
use App\Models\Setting;
use App\Models\FlashSaleProduct;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartVariant;
use App\Models\CompareProduct;
use App\Models\FacebookPixel;
use App\Models\GoogleAnalytic;
use File;
use Str;
use DB;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        $q = $request->q;

        $query = Product::with('category', 'brand');

        if (!empty($q)) {
            $query->where(function ($row) use ($q) {
                $row->where('name', 'like', '%' . $q . '%');

            });
        }

        $products = $query->latest()
            ->paginate(30);

        $orderProducts = OrderProduct::all();
        $categories = Category::all();
        $setting = Setting::first();
        $frontend_url = $setting->frontend_url;
        $frontend_view = $frontend_url.'single-product?slug=';

        return view('admin.product',compact('products','orderProducts','setting','frontend_view','categories'));
    }

    public function sellerProduct(){
        $products = Product::with('category','seller','brand')->where('vendor_id','!=',0)->where('status',1)->get();
        $orderProducts = OrderProduct::all();
        $setting = Setting::first();
        $frontend_url = $setting->frontend_url;
        $frontend_view = $frontend_url.'single-product?slug=';
        return view('admin.product',compact('products','orderProducts','setting','frontend_view'));
    }

    public function sellerPendingProduct(){
        $products = Product::with('category','seller','brand')->where('vendor_id','!=',0)->where('approve_by_admin',0)->get();
        $orderProducts = OrderProduct::all();
        $setting = Setting::first();

        return view('admin.pending_product',compact('products','orderProducts','setting'));

    }

    public function stockoutProduct(){
        $products = Product::with('category','seller','brand')->where('vendor_id',0)->where('qty',0)->get();
        $orderProducts = OrderProduct::all();
        $setting = Setting::first();

        $frontend_url = $setting->frontend_url;
        $frontend_view = $frontend_url.'single-product?slug=';

        return view('admin.stockout_product',compact('products','orderProducts','setting','frontend_view'));

    }



    public function create()
    {
        if(!auth()->user()->can('product.create')){
            abort(403, 'Unauthorized action.');
        }
        $categories = Category::all();
        $brands = Brand::all();
        $specificationKeys = ProductSpecificationKey::all();

        return view('admin.create_product',compact('categories','brands','specificationKeys'));
    }

    public function store(Request $request)
    {
        $rules = [
            'short_name' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:products',
            'thumb_image' => 'required',
            'category' => 'required',
            'short_description' => '',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'site_name' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
        ];
        $customMessages = [
            'short_name.required' => trans('admin_validation.Short name is required'),
            'short_name.unique' => trans('admin_validation.Short name is required'),
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name is required'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'category.required' => trans('admin_validation.Category is required'),

        ];
        $this->validate($request, $rules,$customMessages);

        $product = new Product();
        if($request->hasFile('thumb_image')){
            $product->thumb_image = $this->saveUpload($request->file('thumb_image'), 'uploads/custom-images');
        }



        $product->short_name = $request->short_name;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category ? $request->sub_category : 0;
        $product->child_category_id = $request->child_category ? $request->child_category : 0;
        $product->brand_id = $request->brand ? $request->brand : 0;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->qty = $request->quantity ? $request->quantity : 0;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->status = $request->status;
        $product->weight = $request->weight;
        $product->measure = $request->measure;
        $product->tags = $request->tags;
        $product->is_undefine = 1;
        $product->is_specification = $request->is_specification ? 1 : 0;
        $product->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $defaultDescriptionSource = $request->seo_description ?: $request->short_description ?: $request->long_description ?: $request->name;
        $product->seo_description = $request->seo_description ? $request->seo_description : Str::limit(strip_tags($defaultDescriptionSource), 180);
        $product->meta_title = $request->meta_title ?: $product->seo_title;
        $product->meta_description = $request->meta_description ?: $product->seo_description;
        $product->author = $request->author;
        $product->publisher = $request->publisher;
        $product->copyright = $request->copyright;
        $product->site_name = $request->site_name;
        $product->keywords = $request->keywords;
        $product->is_top = $request->top_product ? 1 : 0;
        $product->new_product = $request->new_arrival ? 1 : 0;
        $product->is_best = $request->best_product ? 1 : 0;
        $product->is_featured = $request->is_featured ? 1 : 0;
        $product->approve_by_admin = 1;

        if ($request->hasFile('meta_image')) {
            $product->meta_image = $this->storeMetaImage($request->file('meta_image'));
        }

        $product->save();


        if ($request->hasFile('images')) {
            $imageData = [];
            foreach ($request->file('images') as $image) {
                $path = $this->saveUpload($image, 'uploads/custom-images');
                $imageData[] = ['image' => $path, 'product_id' => $product->id];
            }

            if (!empty($imageData)) {
                $product->gallery()->createMany($imageData);
            }
        }

        if($request->is_specification){
            $exist_specifications=[];
            if($request->keys){
                foreach($request->keys as $index => $key){
                    if($key){
                        if($request->specifications[$index]){
                            if(!in_array($key, $exist_specifications)){
                                $productSpecification= new ProductSpecification();
                                $productSpecification->product_id = $product->id;
                                $productSpecification->product_specification_key_id = $key;
                                $productSpecification->specification = $request->specifications[$index];
                                $productSpecification->save();
                            }
                            $exist_specifications[] = $key;
                        }
                    }
                }
            }
        }
        $notification = trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product.index')->with($notification);
    }

    public function show($id)
    {
        $product = Product::with('category','brand','gallery','specifications','reviews','variants','variantItems')->find($id);
        if($product->vendor_id == 0){
            $notification = 'Something went wrong';
            return response()->json(['error'=>$notification],403);
        }

        return response()->json(['product' => $product], 200);
    }


    public function edit($id)
    {
        if(!auth()->user()->can('product.edit')){
            abort(403, 'Unauthorized action.');
        }
        $product = Product::with('category','brand','gallery','variants','variantItems')->find($id);
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id',$product->category_id)->get();
        $childCategories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();
        $brands = Brand::all();
        $specificationKeys = ProductSpecificationKey::all();
        $productSpecifications = ProductSpecification::where('product_id',$product->id)->get();

        return view('admin.edit_product',compact('categories','brands','specificationKeys','product','subCategories','childCategories','productSpecifications'));

    }



    public function update(Request $request, $id)
    {

        $product = Product::find($id);
        $rules = [
            'short_name' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id,
            'category' => 'required',
            'short_description' => '',
            'long_description' => '',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'site_name' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
        ];
        $customMessages = [
            'short_name.required' => trans('admin_validation.Short name is required'),
            'short_name.unique' => trans('admin_validation.Short name is required'),
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name is required'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'category.required' => trans('admin_validation.Category is required'),
            'thumb_image.required' => trans('admin_validation.thumbnail is required'),
            'banner_image.required' => trans('admin_validation.Banner is required'),
            'short_description.required' => trans('admin_validation.Short description is required'),
            'long_description.required' => trans('admin_validation.Long description is required'),
            'brand.required' => trans('admin_validation.Brand is required'),
            'price.required' => trans('admin_validation.Price is required'),
            'quantity.required' => trans('admin_validation.Quantity is required'),
            'status.required' => trans('admin_validation.Status is required'),
            'weight.required' => trans('admin_validation.Weight is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        if($request->hasFile('thumb_image')){
            $product->thumb_image = $this->saveUpload($request->file('thumb_image'), 'uploads/custom-images', $product->thumb_image ?? null);
        }


        $product->short_name = $request->short_name;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category ? $request->sub_category : 0;
        $product->child_category_id = $request->child_category ? $request->child_category : 0;
        $product->brand_id = $request->brand ? $request->brand : 0;
        $product->sold_qty = 0;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->tags = $request->tags;
        $product->status = $request->status;
        $product->weight = $request->weight;
        $product->measure = $request->measure;
        $product->is_specification = $request->is_specification ? 1 : 0;
        $product->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $defaultDescriptionSource = $request->seo_description ?: $request->short_description ?: $request->long_description ?: $request->name;
        $product->seo_description = $request->seo_description ? $request->seo_description : Str::limit(strip_tags($defaultDescriptionSource), 180);
        $product->meta_title = $request->meta_title ?: $product->seo_title;
        $product->meta_description = $request->meta_description ?: $product->seo_description;
        $product->author = $request->author;
        $product->publisher = $request->publisher;
        $product->copyright = $request->copyright;
        $product->site_name = $request->site_name;
        $product->keywords = $request->keywords;
        $product->is_top = $request->top_product ? 1 : 0;
        $product->new_product = $request->new_arrival ? 1 : 0;
        $product->is_best = $request->best_product ? 1 : 0;
        $product->is_featured = $request->is_featured ? 1 : 0;

        if ($request->boolean('remove_meta_image')) {
            if ($product->meta_image && File::exists(public_path($product->meta_image))) {
                @unlink(public_path($product->meta_image));
            }
            $product->meta_image = null;
        }

        if ($request->hasFile('meta_image')) {
            $product->meta_image = $this->storeMetaImage($request->file('meta_image'), $product->meta_image ?? null);
        }

        if($product->vendor_id != 0){
            $product->approve_by_admin = $request->approve_by_admin;
        }
        $product->save();


        if ($request->hasFile('images')) {
            $imageData = [];
            foreach ($request->file('images') as $image) {
                $path = $this->saveUpload($image, 'uploads/custom-images');
                $imageData[] = ['image' => $path, 'product_id' => $product->id];
            }

            if (!empty($imageData)) {
                $product->gallery()->createMany($imageData);
            }
        }


        $exist_specifications=[];
        if($request->keys){
            foreach($request->keys as $index => $key){
                if($key){
                    if($request->specifications[$index]){
                        if(!in_array($key, $exist_specifications)){
                            $existSroductSpecification = ProductSpecification::where(['product_id' => $product->id,'product_specification_key_id' => $key])->first();
                            if($existSroductSpecification){
                                $existSroductSpecification->specification = $request->specifications[$index];
                                $existSroductSpecification->save();
                            }else{
                                $productSpecification = new ProductSpecification();
                                $productSpecification->product_id = $product->id;
                                $productSpecification->product_specification_key_id = $key;
                                $productSpecification->specification = $request->specifications[$index];
                                $productSpecification->save();
                            }
                        }
                        $exist_specifications[] = $key;
                    }
                }
            }
        }
        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product.index')->with($notification);
    }

    public function destroy($id)
    {
        if(!auth()->user()->can('product.delete')){
            abort(403, 'Unauthorized action.');
        }

        $product = Product::find($id);
        $gallery = $product->gallery;
        $old_thumbnail = $product->thumb_image;
        $metaImage = $product->meta_image;
        $product->delete();
        if($old_thumbnail){
            if(File::exists(public_path().'/'.$old_thumbnail))unlink(public_path().'/'.$old_thumbnail);
        }
        if ($metaImage && File::exists(public_path($metaImage))) {
            @unlink(public_path($metaImage));
        }
        foreach($gallery as $image){
            $old_image = $image->image;
            $image->delete();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }
        ProductVariant::where('product_id',$id)->delete();
        ProductVariantItem::where('product_id',$id)->delete();
        FlashSaleProduct::where('product_id',$id)->delete();
        ProductReport::where('product_id',$id)->delete();
        ProductReview::where('product_id',$id)->delete();
        ProductSpecification::where('product_id',$id)->delete();
        Wishlist::where('product_id',$id)->delete();
        $cartProducts = ShoppingCart::where('product_id',$id)->get();
        foreach($cartProducts as $cartProduct){
            ShoppingCartVariant::where('shopping_cart_id', $cartProduct->id)->delete();
            $cartProduct->delete();
        }
        CompareProduct::where('product_id',$id)->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product.index')->with($notification);
    }

    public function changeStatus($id){
        $product = Product::find($id);
        if($product->status == 1){
            $product->status = 0;
            $product->save();
            $message = trans('admin_validation.InActive Successfully');
        }else{
            $product->status = 1;
            $product->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }

    public function productApproved($id){
        $product = Product::find($id);
        if($product->approve_by_admin == 1){
            $product->approve_by_admin = 0;
            $product->save();
            $message = trans('admin_validation.Reject Successfully');
        }else{
            $product->approve_by_admin = 1;
            $product->save();
            $message = trans('admin_validation.Approved Successfully');
        }
        return response()->json($message);
    }



    public function removedProductExistSpecification($id){
        $productSpecification = ProductSpecification::find($id);
        $productSpecification->delete();
        $message = trans('admin_validation.Removed Successfully');
        return response()->json($message);
    }


public function fshippingdestroy(Request $request) {
    if(!auth()->user()->can('freeshipping.delete')){
            abort(403, 'Unauthorized action.');
        }
        $product = Product::find($request->product_id);
        $data=[
             'is_free_shipping'=> null
        ];
        $product->update($data);
        return response()->json(['status'=>true ,'msg'=>'Free Shipping Is Deleted !!']);
    }


    public function free_shipping()
    {
      if(!auth()->user()->can('freeshipping.index')){
            abort(403, 'Unauthorized action.');
        }

        $items=Product::whereNotNull('is_free_shipping')->paginate(30);
        return view('admin.free_shipping.index', compact('items'));
    }

    public function create_free_shipping() {
        return view('admin.free_shipping.create_free_shipping');
    }

    public function store_free_shipping(Request $request) {


        if (isset($request->product_id)) {

            foreach ($request->product_id as $key => $product_id) {
                $product=Product::find($product_id);
                $data=[
                        'is_free_shipping'=>1
                ];
                $product->update($data);
            }
        }

        $notification = trans('admin_validation.Free Shipping Added Successfully !!');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.free_shipping')->with($notification);
    }


    public function productEntry2(Request $request){

        $product = Product::select("*")
                    ->where('id',$request->get('product_id'))
                    ->get();

        if ($product) {
            $html='';
            foreach ($product as $key => $item) {
               $html.='<tr>
                        <td>'.$item->name.'</td>
                        <td>'.$item->category->name.'</td>
                        <td class="sell_price">'.$item->price.'</td>

                        <td>
                            <input type="hidden" name="product_id[]" value="'.$item->id.'">
                        </td>

                        <td>
                            <a class="remove action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>';
            }
            return response()->json(['data'=>$html]);

        }else{
            return response()->json(['data'=>'']);
        }
    }


    public function getDiscountProduct(Request $request){

        $data = Product::select("name as value", "id")
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();

        return response()->json($data);

    }

    public function updateFacebookPixel(Request $request){

        $rules = [
            'allow_facebook_pixel' => '',
            'app_id' => $request->allow_facebook_pixel ?  '' : '',
        ];
        $customMessages = [
            // 'app_id.required' => trans('admin_validation.App id is required'),
        ];
        $this->validate($request, $rules,$customMessages);




        $facebookPixel = FacebookPixel::first();
        $facebookPixel->app_id = $request->app_id;
        $facebookPixel->status = $request->allow_facebook_pixel ? 1 : 0;
        $facebookPixel->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateGoogleAnalytic(Request $request){
        $rules = [
            'allow' => '',
            'analytic_id' => $request->allow == 1 ?  '' : ''
        ];
        $customMessages = [
            // 'allow.required' => trans('admin_validation.Allow is required'),
            // 'analytic_id.required' => trans('admin_validation.Analytic id is required'),
        ];

        $this->validate($request, $rules,$customMessages);
        $googleAnalytic = GoogleAnalytic::first();
        $googleAnalytic->status = $request->allow;
        $googleAnalytic->analytic_id = $request->analytic_id;
        $googleAnalytic->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function deleteAllProduct(){

        DB::beginTransaction();
        try {
            $products=DB::table('products')->select('id')->whereIn('id', request('product_ids'))->get();

            foreach ($products as $key => $value) {
                $product=Product::find($value->id);
                $id=$value->id;

                $gallery = $product->gallery;
                $old_thumbnail = $product->thumb_image;
                $product->delete();
                if($old_thumbnail){
                    if(File::exists(public_path().'/'.$old_thumbnail))unlink(public_path().'/'.$old_thumbnail);
                }
                foreach($gallery as $image){
                    $old_image = $image->image;
                    $image->delete();
                    if($old_image){
                        if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
                    }
                }
                ProductVariant::where('product_id',$id)->delete();
                ProductVariantItem::where('product_id',$id)->delete();
                FlashSaleProduct::where('product_id',$id)->delete();
                ProductReport::where('product_id',$id)->delete();
                ProductReview::where('product_id',$id)->delete();
                ProductSpecification::where('product_id',$id)->delete();
                Wishlist::where('product_id',$id)->delete();
                $cartProducts = ShoppingCart::where('product_id',$id)->get();
                foreach($cartProducts as $cartProduct){
                    ShoppingCartVariant::where('shopping_cart_id', $cartProduct->id)->delete();
                    $cartProduct->delete();
                }
                CompareProduct::where('product_id',$id)->delete();

                // if($item->orderProducts()->count()){
                //     $item->orderProducts()->delete();
                // }
                // $item->delete();
            }
            DB::commit();
            return response()->json(['status'=>true ,'msg'=>'Product Is Deleted!!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>false ,'msg'=>$e->getMessage()]);
        }
    }

    public function recomended_product(Request $request, $id){
        Product::where('id', $id)->update(['is_recomended'=> 1]);

         $notification = trans('Recomended Added');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product.index')->with($notification);

    }

    public function not_recomended_product(Request $request, $id){
        Product::where('id', $id)->update(['is_recomended'=> 0]);

         $notification = trans('Recomended Removed');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product.index')->with($notification);

    }

    public function cat_wise_product(Request $request) {
        $cat_id = $request->category_id;
        $cat_product = Product::with('category','seller', 'brand')->where('category_id', $request->category_id)->where(['vendor_id' => 0])->orderBy('id', 'desc')->get();
        $setting = Setting::first();
        $orderProducts = OrderProduct::all();
        $frontend_url = $setting->frontend_url;
        $frontend_view = $frontend_url.'single-product?slug=';
        $categories = Category::all();

        // $html_view = view('admin.query_product', compact('cat_product','setting','orderProducts'))->render();

        return view('admin.cat_product',compact('cat_product','orderProducts','setting','frontend_view','categories','cat_id'));
    }

    private function storeMetaImage($file, ?string $existing = null): string
    {
        return $this->saveUpload($file, 'uploads/seo', $existing);
    }

    private function saveUpload(UploadedFile $file, string $folder, ?string $existing = null): string
    {
        $relativeFolder = trim($folder, '/');
        $destination = public_path($relativeFolder);

        if (! File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $original = $file->getClientOriginalName() ?: $file->hashName();
        $nameOnly = pathinfo($original, PATHINFO_FILENAME) ?: 'file';
        $extension = pathinfo($original, PATHINFO_EXTENSION);

        $fileName = $extension ? "{$nameOnly}.{$extension}" : $nameOnly;
        $counter = 1;
        while (File::exists($destination . DIRECTORY_SEPARATOR . $fileName)) {
            $candidate = "{$nameOnly}-{$counter}";
            $fileName = $extension ? "{$candidate}.{$extension}" : $candidate;
            $counter++;
        }

        $file->move($destination, $fileName);

        if ($existing && File::exists(public_path($existing))) {
            File::delete(public_path($existing));
        }

        return $relativeFolder . '/' . $fileName;
    }


}
