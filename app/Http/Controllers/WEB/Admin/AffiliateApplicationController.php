<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateApplication;
use App\Models\AffiliateClientSubmission;
use App\Models\AffiliateMarketer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AffiliateApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $affiliateApplications = AffiliateApplication::latest()->get();

        return view('admin.affiliate_application.index', compact('affiliateApplications'));
    }

    public function show($id)
    {
        $affiliateApplication = AffiliateApplication::findOrFail($id);
        $affiliateMarketer = AffiliateMarketer::where('affiliate_application_id', $affiliateApplication->id)
            ->orWhere('email', $affiliateApplication->email)
            ->first();

        if ($affiliateApplication->status === 'new') {
            $affiliateApplication->status = 'reviewed';
            $affiliateApplication->save();
        }

        return view('admin.affiliate_application.show', compact('affiliateApplication', 'affiliateMarketer'));
    }

    public function destroy($id)
    {
        AffiliateApplication::findOrFail($id)->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $affiliateApplication = AffiliateApplication::findOrFail($id);

        AffiliateMarketer::updateOrCreate(
            ['email' => $affiliateApplication->email],
            [
                'affiliate_application_id' => $affiliateApplication->id,
                'name' => $affiliateApplication->name,
                'phone' => $affiliateApplication->phone,
                'company_name' => $affiliateApplication->company_name,
                'website' => $affiliateApplication->website,
                'password' => Hash::make($request->password),
                'status' => true,
            ]
        );

        $affiliateApplication->status = 'approved';
        $affiliateApplication->approved_at = now();
        $affiliateApplication->save();

        $notification = ['messege' => 'Affiliate application approved successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function clients()
    {
        $clientSubmissions = AffiliateClientSubmission::with('affiliateMarketer')->latest()->get();

        return view('admin.affiliate_client.index', compact('clientSubmissions'));
    }

    public function showClient($id)
    {
        $clientSubmission = AffiliateClientSubmission::with('affiliateMarketer')->findOrFail($id);

        return view('admin.affiliate_client.show', compact('clientSubmission'));
    }

    public function destroyClient($id)
    {
        AffiliateClientSubmission::findOrFail($id)->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
}
