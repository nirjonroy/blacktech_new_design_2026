<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PopularCategory;
use App\Models\FeaturedCategory;
use App\Models\MegaMenuSubCategory;
use App\Models\MegaMenuCategory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use File;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!auth()->user()->can('category.index')){
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::with('subCategories','products')->get();


        return view('admin.product_category',compact('categories'));

    }


    public function create()
    {
         if(!auth()->user()->can('category.create')){
            abort(403, 'Unauthorized action.');
        }
        return view('admin.create_product_category');
    }


    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:categories',
            'slug'=>'required|unique:categories',
            'status'=>'required',
            'priority'=>'',
            'short_description'=>'',
            'icon'=>'',
            'image'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),

        ];
        $this->validate($request, $rules,$customMessages);

        $category = new Category();
        if($request->hasFile('image')){
            $category->image = $this->saveUpload($request->file('image'), 'uploads/custom-images');
        }
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->icon = $request->icon;
        $category->priority = $request->priority;
        $category->short_description = $request->short_description;
        $category->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-category.index')->with($notification);
    }


    public function show($id){
        $category = Category::find($id);
        return response()->json(['category' => $category],200);
    }

    public function edit($id)
    {
        if(!auth()->user()->can('category.edit')){
            abort(403, 'Unauthorized action.');
        }
        $category = Category::find($id);
        return view('admin.edit_product_category',compact('category'));
    }


    public function update(Request $request,$id)
    {
        $category = Category::find($id);
        $rules = [
            'name'=>'required|unique:categories,name,'.$category->id,
            'slug'=>'required|unique:categories,name,'.$category->id,
            'status'=>'required',
            'priority'=>'',
            'icon'=>'',
            'short_description'=>'',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),

        ];
        $this->validate($request, $rules,$customMessages);

        if($request->hasFile('image')){
            $category->image = $this->saveUpload($request->file('image'), 'uploads/custom-images', $category->image ?? null);
        }


        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->priority = $request->priority;
        $category->short_description = $request->short_description;
        $category->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-category.index')->with($notification);
    }

    public function destroy($id)
    {
        if(!auth()->user()->can('category.destroy')){
            abort(403, 'Unauthorized action.');
        }
        $category = Category::find($id);
        $category->delete();
        $megaMenuCategory = MegaMenuCategory::where('category_id',$id)->first();
        if($megaMenuCategory){
            $cat_id = $megaMenuCategory->id;
            $megaMenuCategory->delete();
            MegaMenuSubCategory::where('mega_menu_category_id',$cat_id)->delete();
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-category.index')->with($notification);
    }

    public function changeStatus($id){
        $category = Category::find($id);
        if($category->status==1){
            $category->status=0;
            $category->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $category->status=1;
            $category->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
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
