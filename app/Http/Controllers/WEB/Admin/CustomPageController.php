<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Image;
use File;
use Illuminate\Support\Str;
class CustomPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!auth()->user()->can('customPage.index')){
            abort(403, 'Unauthorized action.');
        }
        $customPages = CustomPage::all();
        return view('admin.custom_page',compact('customPages'));
    }

    public function create()
    {
        if(!auth()->user()->can('customPage.create')){
            abort(403, 'Unauthorized action.');
        }
        return view('admin.create_custom_page');
    }


    public function store(Request $request)
    {
        $rules = [
            'description' => 'required',
            'page_name' => 'required|unique:custom_pages',
            'slug' => 'required|unique:custom_pages',
            'status' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'meta_robots' => 'nullable|string|max:255',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
        ];
        $customMessages = [
            'page_name.required' => trans('admin_validation.Page name is required'),
            'page_name.unique' => trans('admin_validation.Page name already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'description.required' => trans('admin_validation.Description is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $customPage = new CustomPage();
        $customPage->page_name = $request->page_name;
        $customPage->slug = $request->slug;
        $customPage->description = $request->description;
        $customPage->status = $request->status;
        $customPage->meta_title = $request->meta_title ?: $request->page_name;
        $customPage->meta_description = $request->meta_description ?: Str::limit(strip_tags($request->description), 180);
        $customPage->meta_keywords = $request->meta_keywords;
        $customPage->canonical_url = $request->canonical_url ?: route('front.customPages', $request->slug);
        $customPage->meta_robots = $request->meta_robots ?: 'index, follow';

        if ($request->hasFile('meta_image')) {
            $customPage->meta_image = $this->storeMetaImage($request->file('meta_image'));
        }

        $customPage->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function show($id)
    {
        $customPage = CustomPage::find($id);
        return response()->json(['customPage' => $customPage]);
    }

    public function edit($id)
    {
        if(!auth()->user()->can('customPage.edit')){
            abort(403, 'Unauthorized action.');
        }
        $customPage = CustomPage::find($id);
        return view('admin.edit_custom_page',compact('customPage'));
    }



    public function update(Request $request, $id)
    {
        $customPage = CustomPage::find($id);
        $rules = [
            'description' => 'required',
            'page_name' => 'required|unique:custom_pages,page_name,'.$customPage->id,
            'slug' => 'required|unique:custom_pages,page_name,'.$customPage->id,
            'status' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'meta_robots' => 'nullable|string|max:255',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'remove_meta_image' => 'nullable|boolean',
        ];
        $customMessages = [
            'page_name.required' => trans('admin_validation.Page name is required'),
            'page_name.unique' => trans('admin_validation.Page name already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'description.required' => trans('admin_validation.Description is required'),

        ];
        $this->validate($request, $rules,$customMessages);

        $customPage->page_name = $request->page_name;
        $customPage->slug = $request->slug;
        $customPage->description = $request->description;
        $customPage->status = $request->status;
        $customPage->meta_title = $request->meta_title ?: $request->page_name;
        $customPage->meta_description = $request->meta_description ?: Str::limit(strip_tags($request->description), 180);
        $customPage->meta_keywords = $request->meta_keywords;
        $customPage->canonical_url = $request->canonical_url ?: route('front.customPages', $customPage->slug);
        $customPage->meta_robots = $request->meta_robots ?: 'index, follow';

        if ($request->boolean('remove_meta_image') && $customPage->meta_image) {
            if (File::exists(public_path($customPage->meta_image))) {
                @unlink(public_path($customPage->meta_image));
            }
            $customPage->meta_image = null;
        }

        if ($request->hasFile('meta_image')) {
            $customPage->meta_image = $this->storeMetaImage($request->file('meta_image'), $customPage->meta_image);
        }

        $customPage->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.custom-page.index')->with($notification);
    }

    public function destroy($id)
    {
        if(!auth()->user()->can('customPage.delete')){
            abort(403, 'Unauthorized action.');
        }
        
        $customPage = CustomPage::find($id);
        $customPage->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function changeStatus($id){
        $customPage = CustomPage::find($id);
        if($customPage->status == 1){
            $customPage->status = 0;
            $customPage->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $customPage->status = 1;
            $customPage->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }

    private function storeMetaImage($file, $existing = null)
    {
        $extension = $file->getClientOriginalExtension();
        $imageName = 'custom-page-meta-' . time() . '-' . rand(1000, 9999) . '.' . $extension;
        $path = 'uploads/seo/' . $imageName;

        $directory = public_path('uploads/seo');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        Image::make($file)->save(public_path($path));

        if ($existing && File::exists(public_path($existing))) {
            @unlink(public_path($existing));
        }

        return $path;
    }
}
