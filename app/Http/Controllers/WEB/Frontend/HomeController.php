<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ChildCategory;
use App\Models\FlashSaleProduct;
use App\Models\FooterLink;
use App\Models\AboutUs;
use App\Models\BannerImage;
use App\Models\TermsAndCondition;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\ContactPage;
use App\Models\Blog;
use App\Models\Order;
use App\Models\Footer;
use App\Models\CustomPage;
use App\Models\ContactMessage;
use App\Models\AffiliateApplication;
use App\Models\AffiliateProgramRule;
use App\Models\AffiliateServicePrice;
use App\Models\TeamMember;
use App\Models\Career;
// use App\Models\AboutUs;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\FooterSocialLink;
use Image;
use File;
use Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendmail;
use App\Mail\ReciveMail;
class HomeController extends Controller
{
    private function countryCodePhoneRule($required = false)
    {
        $rules = [$required ? 'required' : 'nullable', 'max:255'];
        $rules[] = 'regex:/^[0-9\s().-]{6,20}$/';

        return implode('|', $rules);
    }

    private function countryCodeRule($required = false)
    {
        $rules = [$required ? 'required' : 'nullable'];
        $rules[] = 'regex:/^\+[0-9]{1,4}$/';

        return implode('|', $rules);
    }

    private function countryCodePhoneMessage()
    {
        return 'Please enter the phone number without country code. Example: 5714782431';
    }

    private function countryCodeMessage()
    {
        return 'Please enter a valid country code. Example: +1';
    }

    private function combinePhoneWithCountryCode(Request $request, $phoneField = 'phone', $countryCodeField = 'phone_country_code')
    {
        $phone = trim((string) $request->input($phoneField));
        $countryCode = trim((string) $request->input($countryCodeField));

        if ($phone === '') {
            return null;
        }

        return trim($countryCode . ' ' . $phone);
    }

    public function index()
    {
        $slider = Slider::select(['id', 'title_one', 'title_two', 'image'])
            ->where('status', 1)
            ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, id ASC')
            ->first();
        // dd($slider);
		 $sliders = Slider::where('status', 1)
             ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, id ASC')
             ->get();

        $feateuredCategories = featuredCategories();
        // dd($feateuredCategories);
        $products = Product::with(['category', 'subCategory', 'childCategory'])
            ->where('status', 1)
            ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, name ASC')
            ->take(12)
            ->get();
        $marqueeServices = Product::where('status', 1)
            ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, name ASC')
            ->take(10)
            ->get();
        $flash_sale_products = flashSaleProduct::with('product')->where('status', 1)->latest()->get();

        $firstColumns  = FooterLink::where('column', 1)->get();

        $secondColumns = FooterLink::where('column', 2)->get();
        $thirdColumns  = FooterLink::where('column', 3)->get();
        $title         = Footer::first();
      	$social_links = FooterSocialLink::all();
        $about = AboutUs::first();
        $faqs = Faq::where('status', 1)->orderBy('id', 'asc')->get();
        $projects = SubCategory::where('status', 1)->orderBy('serial', 'ASC')->get();
        $teamMembers = TeamMember::orderBy('id', 'asc')->get();
        $teamFallbackImage = optional(BannerImage::select('image')->find(15))->image;
        $testimonials = Testimonial::where('status', 1)->get();
      	// dd($products);

        return view('frontend.home.index', compact(
                'slider', 'feateuredCategories', 'products',
                'marqueeServices',
                'firstColumns',
                'secondColumns',
                'thirdColumns',
                'title',
          		'social_links',
          		'sliders',
          		'flash_sale_products',
                'about',
                'faqs',
                'projects',
                'teamMembers',
                'teamFallbackImage',
                'testimonials'));
    }

    public function about_us_page(){
    	$about_us = AboutUs::first();
        $services = Product::where('status', 1)
            ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, name ASC')
            ->take(10)
            ->get();
        $teamMembers = TeamMember::orderBy('id', 'asc')->get();
        $teamFallbackImage = optional(BannerImage::select('image')->find(15))->image;
        $testimonials = Testimonial::where('status', 1)->get();
      	return view('frontend.pages.about_us', compact('about_us', 'services', 'teamMembers', 'teamFallbackImage', 'testimonials'));
    }

    public function careers()
    {
        $about_us = AboutUs::first();
        $careers = Career::where('status', 1)
            ->orderBy('serial', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.pages.careers', compact('about_us', 'careers'));
    }

    public function career_details($slug)
    {
        $career = Career::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.pages.career_single', compact('career'));
    }

    public function affiliate()
    {
        return view('frontend.pages.affiliate');
    }

    public function affiliate_submit(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone_country_code' => 'nullable|required_with:phone|regex:/^\+[0-9]{1,4}$/',
            'phone' => 'nullable|required_with:phone_country_code|max:255|regex:/^[0-9\s().-]{6,20}$/',
            'company_name' => 'nullable|max:255',
            'website' => 'nullable|url|max:255',
            'audience' => 'required|max:255',
            'promotion_plan' => 'required',
            'message' => 'nullable',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'website.url' => 'Please enter a valid website or social profile URL',
            'audience.required' => 'Audience is required',
            'promotion_plan.required' => 'Promotion plan is required',
            'phone.regex' => $this->countryCodePhoneMessage(),
            'phone_country_code.regex' => $this->countryCodeMessage(),
            'phone_country_code.required_with' => 'Country code is required when phone is provided',
            'phone.required_with' => 'Phone number is required when country code is provided',
        ];

        $this->validate($request, $rules, $customMessages);

        $affiliateData = $request->only([
            'name',
            'email',
            'company_name',
            'website',
            'audience',
            'promotion_plan',
            'message',
        ]);
        $affiliateData['phone'] = $this->combinePhoneWithCountryCode($request);

        AffiliateApplication::create($affiliateData);

        Alert::toast('Message', 'Affiliate application submitted successfully');
        $notification = ['messege' => 'Affiliate application submitted successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function affiliate_rules()
    {
        $rule = AffiliateProgramRule::where('status', 1)->first();
        $prices = AffiliateServicePrice::where('status', 1)
            ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, id ASC')
            ->get();

        return view('frontend.pages.affiliate_rules', compact('rule', 'prices'));
    }

    public function team()
    {
        $teamMembers = TeamMember::orderBy('id', 'asc')->get();
        $teamFallbackImage = optional(BannerImage::select('image')->find(15))->image;
        $testimonials = Testimonial::where('status', 1)->get();

        return view('frontend.pages.team', compact('teamMembers', 'teamFallbackImage', 'testimonials'));
    }

    public function team_member($slug)
    {
        $member = TeamMember::where('slug', $slug)->firstOrFail();
        $teamFallbackImage = optional(BannerImage::select('image')->find(15))->image;

        return view('frontend.pages.team_single', compact('member', 'teamFallbackImage'));
    }
  	public function privacy_policy(){
    	$tarms = TermsAndCondition::first();
      	return view('frontend.pages.terms_and_condition', compact('tarms'));
    }

  	public function faq(){
    	$faqs = Faq::get();
      	return view('frontend.pages.faqs', compact('faqs'));
    }
  	public function terms_condition(){
    	$tarms = TermsAndCondition::first();
      	return view('frontend.pages.terms_condition', compact('tarms'));
    }

  	public function contact_us(){
    	$contact = contactPage::first();
      	return view('frontend.pages.contact', compact('contact'));
      	//dd($contact);
    }

  	public function blog(){
    	$blog = Blog::latest()->get();
      	//dd($blog);
      	return view('frontend.pages.blog', compact('blog'));
      	//dd($contact);
    }

  	public function blog_details($slug){
    	$blog = Blog::where('slug', $slug)->first();
      	//dd($blog);
      	return view('frontend.pages.blog_details', compact('blog'));
    }


    public function subCategoriesByCategory(Request $request)
    {
        if($request->type == 'subcategory')
        {
            $id = Category::whereSlug($request->slug)->first()->id;
            $categories = SubCategory::where(['category_id' => $id])->orderBy('serial', 'ASC')->where('status',1)->latest()->get();
            if($categories->count() <= 0)
            {
                return redirect()->route('front.shop', ['slug'=> $request->slug ] );
            }

            return view('frontend.category.sub-category', compact('categories'));
        }
        else if($request->type == 'childcategory')
        {
            $id = SubCategory::whereSlug($request->slug)->first()->id;
            $categories = ChildCategory::where(['sub_category_id' => $id])->orderBy('serial', 'ASC')->orderBy('id', 'DESC')->get();
            if($categories->count() <= 0)
            {
                return redirect()->route('front.shop', ['slug'=> $request->slug ] );
            }

            return view('frontend.category.child-category', compact('categories'));
        }

    }



    public function shop(Request $request, $slug)
    {
        $service = Product::where('slug', $slug)
            ->where('status', 1)
            ->first();
        $serviceCategoryId = $service ? $service->category_id : null;

        if (!$service) {
            $cat = Category::where('slug', $slug)->first();
            if (!$cat) {
                abort(404);
            }

            $serviceCategoryId = $cat->id;
            $service = Product::where('category_id', $cat->id)
                ->where('status', 1)
                ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, name ASC')
                ->first();
        }

        if (!$service) {
            abort(404);
        }

        $relatedServices = collect();
        if ($serviceCategoryId) {
            $relatedServices = Product::where('category_id', $serviceCategoryId)
                ->where('status', 1)
                ->where('id', '!=', $service->id)
                ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, name ASC')
                ->take(6)
                ->get();
        }

        // dd($service);

        return view('frontend.shop.index', compact('service', 'relatedServices'));
    }

    public function our_project(){

        $projects = SubCategory::where('status', 1)->get();
        return view('frontend.shop.projects', compact('projects'));
    }

    public function project($slug)
    {
        $project = SubCategory::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.shop.project', compact('project'));
    }

    public function single_service($slug){
        if (!$slug) {
            abort(404);
        }

        return redirect()->route('front.shop', $slug, 301);
    }

    public function mostSellingProducts()
    {
        $products = Product::with(['category', 'subCategory', 'childCategory'])
                            ->leftJoin('order_products as op','products.id','=','op.product_id')
                            ->selectRaw('products.*, COALESCE(sum(op.qty),0) total')
                            ->groupBy('products.id')
                            ->orderBy('total','desc')
                            ->take(50)
                            ->get();

        return view('frontend.shop.most-selling', compact('products'));
    }

    public function flashSellProducts()
    {
        $flashSell = FlashSaleProduct::with('product')->latest()->get();

        return view('frontend.shop.flash-sell', compact('flashSell'));
    }

    public function repair_page(Request $request, $slug){
        $service = Product::where('slug', $slug)->first();
        // $category = Category()
        // dd($service);

        return view('frontend.repair.index', compact('service'));
    }
    public function all_service(){
        $all_service = Product::with('category')
            ->where('status', 1)
            ->orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, name ASC')
            ->get();
        return view('frontend.repair.all_service', compact('all_service'));
    }

    public function repair_submit(Request $request){
        // dd($request->all());
        $rules = [
            'service_name' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone_country_code' => $this->countryCodeRule(true),
            'phone' => $this->countryCodePhoneRule(true),
            'address' => 'required',
            'short_notes' => 'required',
            'appoinment_date' => '',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),

            'email.required' => trans('admin_validation.Slug is required'),
            'phone.regex' => $this->countryCodePhoneMessage(),
            'phone_country_code.regex' => $this->countryCodeMessage(),


        ];
        $this->validate($request, $rules,$customMessages);

        $order = new Order();
        if ($request->hasFile('image')) {
            $extention = $request->file('image')->getClientOriginalExtension();
            $order_image = 'service_order'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $order_image_path = 'uploads/custom-images/'.$order_image;

            // Save the image
            Image::make($request->file('image'))->save(public_path($order_image_path));

            // Assign the image path to the 'image' property of the $order instance
            $order->image = $order_image_path;
        }

        $order->service_name = $request->service_name;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $this->combinePhoneWithCountryCode($request);
        $order->address = $request->address;
        $order->short_notes = $request->short_notes;
        $order->appoinment_date = $request->appoinment_date;
        $order->appoinment_time = $request->appoinment_time;
        $order->save();
        $mailData = [
            'name' => $request->name,
            'phone' => $this->combinePhoneWithCountryCode($request),
            'service_name' => $request->service_name,
            'short_notes' => $request->short_notes,
        ];

        Mail::to($request->input('email'))
            ->send(new sendmail($mailData));

        // Send email to receiver
        Mail::to('roynirjon18@gmail.com') // Receiver's email address
            ->send(new ReciveMail($mailData));
        Alert::toast('Message', 'Successfully sent message');
        $notification = trans('admin_validation.Created Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('front.order-thanks-page')->with($notification);

    }
    public function contact(){
        $contacts = ContactPage::first();
        return view('frontend.contact.index', compact('contacts'));
    }

    public function customPages($slug){
        $customPage=CustomPage::where('slug', $slug)->first();

        // dd($customPage);
        return view('frontend.pages', compact('customPage'));
    }

    public function message(Request $request){
        // dd($request->all());
        $rules = [

            'name' => 'required',
            'email' => '',
            'phone_country_code' => $this->countryCodeRule(true),
            'phone' => $this->countryCodePhoneRule(true),
            'address' => '',
            'subject' => '',
            'message' => '',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),

            'email.required' => trans('admin_validation.Slug is required'),
            'phone.regex' => $this->countryCodePhoneMessage(),
            'phone_country_code.regex' => $this->countryCodeMessage(),


        ];
        $this->validate($request, $rules,$customMessages);

        $order = new ContactMessage();



        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $this->combinePhoneWithCountryCode($request);
        $order->address = $request->address;
        $order->subject = $request->subject;
        $order->message = $request->message;
        $order->save();

        Alert::toast('Message', 'Successfully sent message');
        $notification = trans('admin_validation.Created Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function industry($slug){
        $industry = ChildCategory::where('slug', $slug)->first();
        return view('frontend.shop.industry', compact('industry'));
    }

    public function industry_all(){
        $industries = ChildCategory::all();
        return view('frontend.shop.all-industry', compact('industries'));
    }

}
