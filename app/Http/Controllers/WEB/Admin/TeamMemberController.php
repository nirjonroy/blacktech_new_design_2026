<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use File;
use Illuminate\Http\Request;
use Image;
use Str;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teamMembers = TeamMember::orderBy('id', 'desc')->get();
        return view('admin.team_member', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.create_team_member');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'nullable|string|max:255',
            'designation' => 'required',
            'image' => 'required|image',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'designation.required' => trans('admin_validation.Designation is required'),
            'image.required' => trans('admin_validation.Image is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $slugInput = $request->input('slug');
        $slugBase = $slugInput ?: $request->name;
        $slug = Str::slug($slugBase);
        if ($slug === '') {
            $slug = 'team-member';
        }
        if (!empty($slugInput)) {
            $slugExists = TeamMember::where('slug', $slug)->exists();
            if ($slugExists) {
                return back()
                    ->withErrors(['slug' => trans('admin_validation.Slug already exist')])
                    ->withInput();
            }
        } else {
            $slug = $this->generateUniqueSlug($slug);
        }

        $imageName = null;
        if ($request->image) {
            $uploadPath = public_path('uploads/team-members');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }

            $extension = $request->image->getClientOriginalExtension();
            $imageName = Str::slug($request->name) . date('-Ymdhis') . '.' . $extension;
            $imageName = 'uploads/team-members/' . $imageName;

            Image::make($request->image)
                ->save(public_path('/' . $imageName));
        }

        $teamMember = new TeamMember();
        $teamMember->name = $request->name;
        $teamMember->slug = $slug;
        $teamMember->designation = $request->designation;
        $teamMember->image = $imageName;
        $teamMember->facebook = $request->facebook;
        $teamMember->instagram = $request->instagram;
        $teamMember->whatsapp = $request->whatsapp;
        $teamMember->website = $request->website;
        $teamMember->linkedin = $request->linkedin;
        $teamMember->biography = $request->biography;
        $teamMember->save();

        $notification = trans('admin_validation.Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.team-member.index')->with($notification);
    }

    public function edit($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        return view('admin.edit_team_member', compact('teamMember'));
    }

    public function update(Request $request, $id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $rules = [
            'name' => 'required',
            'slug' => 'nullable|string|max:255',
            'designation' => 'required',
            'image' => 'nullable|image',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'designation.required' => trans('admin_validation.Designation is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $slugInput = $request->input('slug');
        $slugBase = $slugInput ?: $request->name;
        $slug = Str::slug($slugBase);
        if ($slug === '') {
            $slug = 'team-member';
        }
        if (!empty($slugInput)) {
            $slugExists = TeamMember::where('slug', $slug)
                ->where('id', '!=', $teamMember->id)
                ->exists();
            if ($slugExists) {
                return back()
                    ->withErrors(['slug' => trans('admin_validation.Slug already exist')])
                    ->withInput();
            }
        } else {
            $slug = $this->generateUniqueSlug($slug, $teamMember->id);
        }

        if ($request->image) {
            $uploadPath = public_path('uploads/team-members');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }

            $existingImage = $teamMember->image;
            $extension = $request->image->getClientOriginalExtension();
            $imageName = Str::slug($request->name) . date('-Ymdhis') . '.' . $extension;
            $imageName = 'uploads/team-members/' . $imageName;

            Image::make($request->image)
                ->save(public_path('/' . $imageName));

            $teamMember->image = $imageName;
            if ($existingImage && File::exists(public_path('/' . $existingImage))) {
                unlink(public_path('/' . $existingImage));
            }
        }

        $teamMember->name = $request->name;
        $teamMember->slug = $slug;
        $teamMember->designation = $request->designation;
        $teamMember->facebook = $request->facebook;
        $teamMember->instagram = $request->instagram;
        $teamMember->whatsapp = $request->whatsapp;
        $teamMember->website = $request->website;
        $teamMember->linkedin = $request->linkedin;
        $teamMember->biography = $request->biography;
        $teamMember->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.team-member.index')->with($notification);
    }

    public function destroy($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $existingImage = $teamMember->image;
        $teamMember->delete();

        if ($existingImage && File::exists(public_path('/' . $existingImage))) {
            unlink(public_path('/' . $existingImage));
        }

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.team-member.index')->with($notification);
    }

    private function generateUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $baseSlug = $slug;
        $suffix = 1;

        while (TeamMember::where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                return $query->where('id', '!=', $ignoreId);
            })
            ->exists()) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }
}
