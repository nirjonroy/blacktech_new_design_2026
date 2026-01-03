<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\PopularPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use File;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs = Blog::with('category','comments')->get();
        $setting = Setting::first();
        $frontend_url = $setting->frontend_url;
        $frontend_view = $frontend_url.'blogs/blog?slug=';

        return view('admin.blog',compact('blogs','frontend_view'));
    }


    public function create()
    {
        $categories = BlogCategory::where('status',1)->get();
        return view('admin.create_blog',compact('categories'));
    }


    public function store(Request $request)
    {
        $rules = [
            'title'=>'required|unique:blogs',
            'slug'=>'required|unique:blogs',
            'image'=>'',
            'description'=>'',
            'category'=>'',
            'status'=>'required',
            'show_homepage'=>'',
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
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'image.required' => trans('admin_validation.Image is required'),
            'description.required' => trans('admin_validation.Description is required'),

        ];
        $this->validate($request, $rules,$customMessages);

        $admin = Auth::guard('admin')->user();
        $blog = new Blog();
        if($request->hasFile('image')){
            $blog->image = $this->saveUpload($request->file('image'), 'uploads/custom-images');
        }

        // $blog->admin_id = $admin->id;
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->description = $request->description;
        $blog->blog_category_id = $request->category;
        $blog->status = $request->status;
        $blog->show_homepage = $request->show_homepage;
        $blog->seo_title = $request->seo_title ? $request->seo_title : $request->title;
        $blog->seo_description = $request->seo_description ? $request->seo_description : Str::limit(strip_tags($request->description), 180);
        $blog->meta_title = $request->meta_title ?: $blog->seo_title;
        $blog->meta_description = $request->meta_description ?: $blog->seo_description;
        $blog->author = $request->author;
        $blog->publisher = $request->publisher;
        $blog->copyright = $request->copyright;
        $blog->site_name = $request->site_name;
        $blog->keywords = $request->keywords;

        if ($request->hasFile('meta_image')) {
            $blog->meta_image = $this->storeMetaImage($request->file('meta_image'), $blog->meta_image ?? null);
        }

        $blog->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function edit($id)
    {
        $categories = BlogCategory::where('status',1)->get();
        $blog = Blog::find($id);
        return view('admin.edit_blog',compact('categories','blog'));
    }


    public function show($id)
    {
        $blog = Blog::with('category','comments')->find($id);
        return response()->json(['blog' => $blog], 200);
    }


    public function update(Request $request,$id)
    {
        $blog = Blog::find($id);
        $rules = [
            'title'=>'required|unique:blogs,title,'.$blog->id,
            'slug'=>'required|unique:blogs,slug,'.$blog->id,
            'description'=>'required',
            'category'=>'',
            'status'=>'required',
            'show_homepage'=>'',
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
            'title.required' => trans('admin_validation.Title is required'),
            'title.unique' => trans('admin_validation.Title already exist'),
            'slug.required' => trans('admin_validation.Slug is required'),
            'slug.unique' => trans('admin_validation.Slug already exist'),
            'description.required' => trans('admin_validation.Description is required'),
            'category.required' => trans('admin_validation.Category is required'),
            'show_homepage.required' => trans('admin_validation.Show homepage is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        if($request->hasFile('image')){
            $blog->image = $this->saveUpload($request->file('image'), 'uploads/custom-images', $blog->image ?? null);
            $blog->save();
        }

        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->description = $request->description;
        $blog->blog_category_id = $request->category;
        $blog->status = $request->status;
        $blog->show_homepage = $request->show_homepage;
        $blog->seo_title = $request->seo_title ? $request->seo_title : $request->title;
        $blog->seo_description = $request->seo_description ? $request->seo_description : Str::limit(strip_tags($request->description), 180);
        $blog->meta_title = $request->meta_title ?: $blog->seo_title;
        $blog->meta_description = $request->meta_description ?: $blog->seo_description;
        $blog->author = $request->author;
        $blog->publisher = $request->publisher;
        $blog->copyright = $request->copyright;
        $blog->site_name = $request->site_name;
        $blog->keywords = $request->keywords;

        if ($request->boolean('remove_meta_image')) {
            if ($blog->meta_image && File::exists(public_path($blog->meta_image))) {
                @unlink(public_path($blog->meta_image));
            }
            $blog->meta_image = null;
        }

        if ($request->hasFile('meta_image')) {
            $blog->meta_image = $this->storeMetaImage($request->file('meta_image'), $blog->meta_image ?? null);
        }

        $blog->save();

        $notification= trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.blog.index')->with($notification);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $old_image = $blog->image;
        $metaImage = $blog->meta_image;
        $blog->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }
        if($metaImage && File::exists(public_path($metaImage))) {
            @unlink(public_path($metaImage));
        }

        BlogComment::where('blog_id',$id)->delete();
        PopularPost::where('blog_id',$id)->delete();

        $notification=  trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $blog = Blog::find($id);
        if($blog->status==1){
            $blog->status=0;
            $blog->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $blog->status=1;
            $blog->save();
            $message= trans('admin_validation.Active Successfully');
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
