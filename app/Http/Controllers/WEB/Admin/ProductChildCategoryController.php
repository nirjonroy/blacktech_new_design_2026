<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildCategory;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\PopularCategory;
use App\Models\ThreeColumnCategory;
use File;
use Str;
use Illuminate\Http\UploadedFile;

class ProductChildCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!auth()->user()->can('childCategory.index')){
            abort(403, 'Unauthorized action.');
        }
        $childCategories=ChildCategory::with('subCategory','category','products')->get();

        return view('admin.product_child_category',compact('childCategories'));
    }


    public function create()
    {
        if(!auth()->user()->can('childCategory.create')){
            abort(403, 'Unauthorized action.');
        }
        $categories=Category::all();
        $SubCategories=SubCategory::all();
        return view('admin.create_product_child_category',compact('categories','SubCategories'));
    }

    public function getSubcategoryByCategory($id){
        $subCategories=SubCategory::where('category_id',$id)->get();
        $response="<option value=''>".trans('admin_validation.Select sub category')."</option>";
        foreach($subCategories as $subCategory){
            $response .= "<option value=".$subCategory->id.">".$subCategory->name."</option>";
        }
        return response()->json(['subCategories'=>$response]);
    }

    public function getChildcategoryBySubCategory($id){
        $childCategories=ChildCategory::where('sub_category_id',$id)->get();
        $response='<option value="">'.trans('admin_validation.Select Child Category').'</option>';
        foreach($childCategories as $childCategory){
            $response .= "<option value=".$childCategory->id.">".$childCategory->name."</option>";
        }
        return response()->json(['childCategories'=>$response]);
    }



    public function store(Request $request)
    {
        $rules = [
            'name'=>'required',
            'category'=>'',
            'sub_category'=>'',
            'slug'=>'required|unique:child_categories',
            'status'=>'required',
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
            'name.required' => trans('admin_validation.Name is required'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),

        ];
        $this->validate($request, $rules,$customMessages);

        $childCategory = new ChildCategory();

        if($request->hasFile('image')){
            $childCategory->image = $this->saveUpload($request->file('image'), 'uploads/custom-images');
        }

        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->name = $request->name;
        $childCategory->slug = $request->slug;
        $childCategory->description_1 = $request->description_1;
        $childCategory->description_2 = $request->description_2;
        $childCategory->status = $request->status;
        $childCategory->serial = $request->serial;
        $defaultDescription = $request->meta_description ?: $request->description_1 ?: $request->description_2 ?: $request->name;
        $childCategory->meta_title = $request->meta_title ?: $request->name;
        $childCategory->meta_description = $request->meta_description ?: Str::limit(strip_tags($defaultDescription), 180);
        $childCategory->author = $request->author;
        $childCategory->publisher = $request->publisher;
        $childCategory->copyright = $request->copyright;
        $childCategory->site_name = $request->site_name;
        $childCategory->keywords = $request->keywords;

        if ($request->hasFile('meta_image')) {
            $childCategory->meta_image = $this->storeMetaImage($request->file('meta_image'));
        }

        $childCategory->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-child-category.index')->with($notification);
    }


    public function show($id){
        $childCategory = ChildCategory::find($id);
        return response()->json(['childCategory' => $childCategory],200);
    }

    public function edit($id)
    {
        if(!auth()->user()->can('childCategory.edit')){
            abort(403, 'Unauthorized action.');
        }

        $childCategory = ChildCategory::find($id);
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id',$childCategory->category_id)->get();
        return view('admin.edit_product_child_category',compact('childCategory','categories','subCategories'));
    }


    public function update(Request $request, $id)
    {

        $childCategory = ChildCategory::find($id);
        $rules = [
            'name' => 'required',
            'category' => '',
            'sub_category' => '',
            'slug' => 'required|unique:child_categories,slug,'.$childCategory->id,
            'status' => 'required',
            'image'=> '',
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
            'name.required' => trans('admin_validation.Name is required'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),

        ];
        $this->validate($request, $rules,$customMessages);

        if($request->hasFile('image')){
            $childCategory->image = $this->saveUpload($request->file('image'), 'uploads/custom-images', $childCategory->image ?? null);
        }

        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->name = $request->name;
        $childCategory->slug = $request->slug;
        $childCategory->serial = $request->serial;
        $childCategory->description_1 = $request->description_1;
        $childCategory->description_2 = $request->description_2;
        $childCategory->status = $request->status;
        $defaultDescription = $request->meta_description ?: $request->description_1 ?: $request->description_2 ?: $request->name;
        $childCategory->meta_title = $request->meta_title ?: $request->name;
        $childCategory->meta_description = $request->meta_description ?: Str::limit(strip_tags($defaultDescription), 180);
        $childCategory->author = $request->author;
        $childCategory->publisher = $request->publisher;
        $childCategory->copyright = $request->copyright;
        $childCategory->site_name = $request->site_name;
        $childCategory->keywords = $request->keywords;

        if ($request->boolean('remove_meta_image')) {
            if ($childCategory->meta_image && File::exists(public_path($childCategory->meta_image))) {
                @unlink(public_path($childCategory->meta_image));
            }
            $childCategory->meta_image = null;
        }

        if ($request->hasFile('meta_image')) {
            $childCategory->meta_image = $this->storeMetaImage($request->file('meta_image'), $childCategory->meta_image ?? null);
        }

        $childCategory->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-child-category.index')->with($notification);
    }


    public function destroy($id)
    {
        if(!auth()->user()->can('childCategory.delete')){
            abort(403, 'Unauthorized action.');
        }
        $childCategory = ChildCategory::find($id);
        $childCategory->delete();
        if ($childCategory->meta_image && File::exists(public_path($childCategory->meta_image))) {
            @unlink(public_path($childCategory->meta_image));
        }
        $notification = trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-child-category.index')->with($notification);
    }

    public function changeStatus($id){
        $childCategory = ChildCategory::find($id);
        if($childCategory->status==1){
            $childCategory->status=0;
            $childCategory->save();
            $message = trans('admin_validation.InActive Successfully');
        }else{
            $childCategory->status=1;
            $childCategory->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
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
