<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClientSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliatePortalController extends Controller
{
    public function loginPage()
    {
        if (Auth::guard('affiliate')->check()) {
            return redirect()->route('front.affiliate.dashboard');
        }

        return view('frontend.affiliate.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => true,
        ];

        if (Auth::guard('affiliate')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('front.affiliate.dashboard');
        }

        $notification = ['messege' => 'Invalid affiliate login information', 'alert-type' => 'error'];

        return redirect()->back()->withInput($request->only('email'))->with($notification);
    }

    public function dashboard()
    {
        if (!Auth::guard('affiliate')->check()) {
            return redirect()->route('front.affiliate.login');
        }

        $affiliate = Auth::guard('affiliate')->user();
        $clientSubmissions = $affiliate->clientSubmissions()->latest()->get();

        return view('frontend.affiliate.dashboard', compact('affiliate', 'clientSubmissions'));
    }

    public function storeClient(Request $request)
    {
        if (!Auth::guard('affiliate')->check()) {
            return redirect()->route('front.affiliate.login');
        }

        $request->validate([
            'client_name' => 'required|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'nullable|max:255',
            'company_name' => 'nullable|max:255',
            'service_interest' => 'nullable|max:255',
            'budget' => 'nullable|max:255',
            'message' => 'nullable',
        ]);

        AffiliateClientSubmission::create([
            'affiliate_marketer_id' => Auth::guard('affiliate')->id(),
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'company_name' => $request->company_name,
            'service_interest' => $request->service_interest,
            'budget' => $request->budget,
            'message' => $request->message,
        ]);

        $notification = ['messege' => 'Client details submitted successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function logout(Request $request)
    {
        Auth::guard('affiliate')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('front.affiliate.login');
    }
}
