<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use File;
use Illuminate\Http\Request;
use Image;
use Str;

class CareerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $careers = Career::orderBy('serial', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.career', compact('careers'));
    }

    public function create()
    {
        return view('admin.create_career');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'employment_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'experience' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'apply_url' => 'nullable|string|max:255',
            'serial' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'image' => 'required|image',
        ];
        $customMessages = [
            'title.required' => 'Title is required',
            'image.required' => 'Image is required',
            'status.required' => 'Status is required',
        ];
        $this->validate($request, $rules, $customMessages);

        $imageName = null;
        if ($request->image) {
            $uploadPath = public_path('uploads/careers');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }

            $extension = $request->image->getClientOriginalExtension();
            $imageName = Str::slug($request->title) . date('-Ymdhis') . '.' . $extension;
            $imageName = 'uploads/careers/' . $imageName;

            Image::make($request->image)
                ->save(public_path('/' . $imageName));
        }

        $career = new Career();
        $career->title = $request->title;
        $career->employment_type = $request->employment_type;
        $career->location = $request->location;
        $career->short_description = $request->short_description;
        $career->experience = $request->experience;
        $career->salary = $request->salary;
        $career->deadline = $request->deadline;
        $career->image = $imageName;
        $career->apply_url = $request->apply_url;
        $career->serial = $request->serial ?? 0;
        $career->status = $request->status;
        $career->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.career.index')->with($notification);
    }

    public function edit($id)
    {
        $career = Career::findOrFail($id);
        return view('admin.edit_career', compact('career'));
    }

    public function update(Request $request, $id)
    {
        $career = Career::findOrFail($id);
        $rules = [
            'title' => 'required',
            'employment_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'experience' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'apply_url' => 'nullable|string|max:255',
            'serial' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image',
        ];
        $customMessages = [
            'title.required' => 'Title is required',
            'status.required' => 'Status is required',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->image) {
            $uploadPath = public_path('uploads/careers');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }

            $existingImage = $career->image;
            $extension = $request->image->getClientOriginalExtension();
            $imageName = Str::slug($request->title) . date('-Ymdhis') . '.' . $extension;
            $imageName = 'uploads/careers/' . $imageName;

            Image::make($request->image)
                ->save(public_path('/' . $imageName));

            $career->image = $imageName;
            if ($existingImage && File::exists(public_path('/' . $existingImage))) {
                unlink(public_path('/' . $existingImage));
            }
        }

        $career->title = $request->title;
        $career->employment_type = $request->employment_type;
        $career->location = $request->location;
        $career->short_description = $request->short_description;
        $career->experience = $request->experience;
        $career->salary = $request->salary;
        $career->deadline = $request->deadline;
        $career->apply_url = $request->apply_url;
        $career->serial = $request->serial ?? 0;
        $career->status = $request->status;
        $career->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.career.index')->with($notification);
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);
        $existingImage = $career->image;
        $career->delete();

        if ($existingImage && File::exists(public_path('/' . $existingImage))) {
            unlink(public_path('/' . $existingImage));
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.career.index')->with($notification);
    }

    public function changeStatus($id)
    {
        $item = Career::findOrFail($id);
        if ($item->status == 1) {
            $item->status = 0;
            $item->save();
            $message = trans('admin_validation.Inactive Successfully');
        } else {
            $item->status = 1;
            $item->save();
            $message = trans('admin_validation.Active Successfully');
        }

        return response()->json($message);
    }
}
