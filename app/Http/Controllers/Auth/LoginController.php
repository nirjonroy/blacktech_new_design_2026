<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\UserForgetPassword;
use App\Models\EmailTemplate;
use App\Models\GoogleRecaptcha;
use App\Models\Setting;
use App\Models\SocialLoginInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:api')->except('userLogout');
    }

    public function loginPage()
    {
        $setting = Setting::first();
        $recaptchaSetting = GoogleRecaptcha::first();

        return response()->json([
            'setting' => $setting,
            'recaptchaSetting' => $recaptchaSetting,
        ]);
    }

    public function storeLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $customMessages = [
            'email.required' => trans('admin_validation.Email is required'),
            'password.required' => trans('admin_validation.Password is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $notification = trans('admin_validation.Invalid Email');
            return response()->json(['notification' => $notification], 401);
        }

        if (isset($user->status) && (int) $user->status !== 1) {
            $notification = trans('admin_validation.Inactive account');
            return response()->json(['notification' => $notification], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            $notification = trans('admin_validation.Invalid Password');
            return response()->json(['notification' => $notification], 401);
        }

        $token = Auth::guard('api')->login($user);
        if (!$token) {
            $notification = trans('admin_validation.Invalid Password');
            return response()->json(['notification' => $notification], 401);
        }

        $notification = trans('admin_validation.Login Successfully');
        return $this->respondWithToken($token, $user, $notification);
    }

    public function redirectToGoogle()
    {
        $socialLogin = SocialLoginInformation::first();
        if (!$socialLogin || (int) $socialLogin->is_gmail !== 1) {
            return response()->json(['notification' => 'Google login is disabled'], 400);
        }

        $socialLogin->setGoogleLoginInfo();
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallBack()
    {
        $socialLogin = SocialLoginInformation::first();
        if ($socialLogin) {
            $socialLogin->setGoogleLoginInfo();
        }

        return $this->handleSocialCallback('google');
    }

    public function redirectToFacebook()
    {
        $socialLogin = SocialLoginInformation::first();
        if (!$socialLogin || (int) $socialLogin->is_facebook !== 1) {
            return response()->json(['notification' => 'Facebook login is disabled'], 400);
        }

        $socialLogin->setFacebookLoginInfo();
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function facebookCallBack()
    {
        $socialLogin = SocialLoginInformation::first();
        if ($socialLogin) {
            $socialLogin->setFacebookLoginInfo();
        }

        return $this->handleSocialCallback('facebook');
    }

    public function forgetPage()
    {
        $setting = Setting::first();
        $recaptchaSetting = GoogleRecaptcha::first();

        return response()->json([
            'setting' => $setting,
            'recaptchaSetting' => $recaptchaSetting,
        ]);
    }

    public function sendForgetPassword(Request $request)
    {
        $rules = [
            'email' => 'required',
        ];
        $customMessages = [
            'email.required' => trans('admin_validation.Email is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $notification = trans('admin_validation.email does not exist');
            return response()->json(['notification' => $notification], 400);
        }

        $user->forget_password_token = random_int(100000, 999999);
        $user->save();

        MailHelper::setMailConfig();
        $template = EmailTemplate::where('id', 1)->first();
        $subject = $template->subject ?? 'Password Reset';
        $message = $template->description ?? 'Use this code to reset your password.';
        $message = str_replace('{{name}}', $user->name ?? '', $message);

        Mail::to($user->email)->send(new UserForgetPassword($message, $subject, $user));

        $notification = trans('admin_validation.Forget password link send your email');
        return response()->json(['notification' => $notification], 200);
    }

    public function resetPasswordPage($token)
    {
        $user = User::where('forget_password_token', $token)->first();
        if (!$user) {
            return response()->json(['notification' => 'invalid token'], 400);
        }

        $setting = Setting::first();
        return response()->json(['user' => $user, 'token' => $token, 'setting' => $setting], 200);
    }

    public function storeResetPasswordPage(Request $request, $token)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required|confirmed|min:4',
        ];
        $customMessages = [
            'email.required' => trans('admin_validation.Email is required'),
            'password.required' => trans('admin_validation.Password is required'),
            'password.confirmed' => trans('admin_validation.Password deos not match'),
            'password.min' => trans('admin_validation.Password must be 4 characters'),
        ];
        $this->validate($request, $rules, $customMessages);

        $user = User::where([
            'forget_password_token' => $token,
            'email' => $request->email,
        ])->first();

        if (!$user) {
            $notification = trans('admin_validation.Email or token does not exist');
            return response()->json(['notification' => $notification], 400);
        }

        $user->password = Hash::make($request->password);
        $user->forget_password_token = null;
        $user->save();

        $notification = trans('admin_validation.Password Reset Successfully');
        return response()->json(['notification' => $notification], 200);
    }

    public function userLogout()
    {
        Auth::guard('api')->logout();
        $notification = trans('admin_validation.Logout Successfully');
        return response()->json(['notification' => $notification], 200);
    }

    protected function respondWithToken($token, User $user, $notification = null)
    {
        return response()->json([
            'notification' => $notification,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }

    protected function handleSocialCallback($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $ex) {
            return response()->json(['notification' => 'Social login failed'], 400);
        }

        $email = $providerUser->getEmail();
        if (!$email) {
            return response()->json(['notification' => 'Social login requires an email'], 400);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $providerUser->getName() ?: $providerUser->getNickname() ?: 'User';
            $user->email = $email;
            $user->password = Hash::make(Str::random(24));
            $user->status = 1;
            $user->email_verified = 1;
        }

        $user->provider = $provider;
        $user->provider_id = $providerUser->getId();
        $user->provider_avatar = $providerUser->getAvatar();
        $user->save();

        $token = Auth::guard('api')->login($user);
        $notification = trans('admin_validation.Login Successfully');
        return $this->respondWithToken($token, $user, $notification);
    }
}
