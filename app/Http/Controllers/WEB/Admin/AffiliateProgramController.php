<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgramRule;
use App\Models\AffiliateServicePrice;
use Illuminate\Http\Request;

class AffiliateProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function rules()
    {
        $rule = AffiliateProgramRule::first();

        return view('admin.affiliate_program.rules', compact('rule'));
    }

    public function updateRules(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        AffiliateProgramRule::updateOrCreate(
            ['id' => optional(AffiliateProgramRule::first())->id],
            [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->has('status'),
            ]
        );

        $notification = ['messege' => trans('admin_validation.Update Successfully'), 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function prices()
    {
        $prices = AffiliateServicePrice::orderByRaw('CASE WHEN serial IS NULL THEN 1 ELSE 0 END, serial ASC, id ASC')->get();

        return view('admin.affiliate_program.prices', compact('prices'));
    }

    public function storePrice(Request $request)
    {
        $request->validate([
            'service_name' => 'required|max:255',
            'basic_price' => 'nullable|numeric|min:0',
            'intermediate_price' => 'nullable|numeric|min:0',
            'complex_price' => 'nullable|numeric|min:0',
            'serial' => 'nullable|integer|min:0',
        ]);

        AffiliateServicePrice::create([
            'service_name' => $request->service_name,
            'basic_price' => $request->basic_price,
            'intermediate_price' => $request->intermediate_price,
            'complex_price' => $request->complex_price,
            'note' => $request->note,
            'serial' => $request->serial,
            'status' => $request->has('status'),
        ]);

        $notification = ['messege' => trans('admin_validation.Create Successfully'), 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function updatePrice(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|max:255',
            'basic_price' => 'nullable|numeric|min:0',
            'intermediate_price' => 'nullable|numeric|min:0',
            'complex_price' => 'nullable|numeric|min:0',
            'serial' => 'nullable|integer|min:0',
        ]);

        $price = AffiliateServicePrice::findOrFail($id);
        $price->update([
            'service_name' => $request->service_name,
            'basic_price' => $request->basic_price,
            'intermediate_price' => $request->intermediate_price,
            'complex_price' => $request->complex_price,
            'note' => $request->note,
            'serial' => $request->serial,
            'status' => $request->has('status'),
        ]);

        $notification = ['messege' => trans('admin_validation.Update Successfully'), 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function destroyPrice($id)
    {
        AffiliateServicePrice::findOrFail($id)->delete();

        $notification = ['messege' => trans('admin_validation.Delete Successfully'), 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
}
