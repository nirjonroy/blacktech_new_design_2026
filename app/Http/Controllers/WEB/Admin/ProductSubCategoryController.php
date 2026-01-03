<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PopularCategory;
use App\Models\ThreeColumnCategory;
use App\Models\MegaMenuSubCategory;
use File;
use Illuminate\Http\UploadedFile;

class ProductSubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!auth()->user()->can('subCategory.index')){
            abort(403, 'Unauthorized action.');
        }

        $subCategories=SubCategory::with('category','childCategories','products')->get();

        return view('admin.product_sub_category',compact('subCategories'));
    }


    public function create()
    {
        if(!auth()->user()->can('subCategory.create')){
            abort(403, 'Unauthorized action.');
        }

        $categories=Category::all();
        return view('admin.create_product_sub_category',compact('categories'));
    }


    public function store(Request $request)
    {
        $rules = [
            'name'=>'required',
            'slug'=>'required|unique:sub_categories',
            'category'=>'',
            'status'=>'required',
            'image'=> 'required'
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),

        ];
        $this->validate($request, $rules,$customMessages);

        $subCategory = new SubCategory();

        if($request->hasFile('image')){
            $subCategory->image = $this->saveUpload($request->file('image'), 'uploads/custom-images');
        }

        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->link = $request->link;
        $subCategory->description = $request->description;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->serial = $request->serial;
        $subCategory->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-sub-category.index')->with($notification);
    }

    public function show($id){
        $subCategory = SubCategory::find($id);
        return response()->json(['subCategory' => $subCategory],200);
    }

    public function edit($id)
    {
        if(!auth()->user()->can('subCategory.edit')){
            abort(403, 'Unauthorized action.');
        }

        $subCategory = SubCategory::find($id);
        $categories=Category::all();
        return view('admin.edit_product_sub_category',compact('subCategory','categories'));
    }


    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::find($id);
        $rules = [
            'name'=>'required',
            'slug'=>'required|unique:sub_categories,slug,'.$subCategory->id,

            'status'=>'required'
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),

        ];
        $this->validate($request, $rules,$customMessages);
        if($request->hasFile('image')){
            $subCategory->image = $this->saveUpload($request->file('image'), 'uploads/custom-images', $subCategory->image ?? null);
        }
        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->link = $request->link;
        $subCategory->description = $request->description;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->serial = $request->serial;
        $subCategory->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-sub-category.index')->with($notification);
    }


    public function destroy($id)
    {
        if(!auth()->user()->can('subCategory.delete')){
            abort(403, 'Unauthorized action.');
        }

        $subCategory = SubCategory::find($id);
        $subCategory->delete();
        MegaMenuSubCategory::where('sub_category_id',$id)->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-sub-category.index')->with($notification);
    }

    public function changeStatus($id){
        $subCategory = SubCategory::find($id);
        if($subCategory->status==1){
            $subCategory->status=0;
            $subCategory->save();
            $message = trans('admin_validation.InActive Successfully');
        }else{
            $subCategory->status=1;
            $subCategory->save();
            $message = trans('admin_validation.Active Successfully');
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
