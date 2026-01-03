<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\CustomPage;
use App\Models\Product;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect([
            [
                'loc' => route('front.home'),
                'lastmod' => $this->formatDate(now()),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('front.about-us'),
                'lastmod' => $this->formatDate(now()),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            
           
            [
                'loc' => route('front.contact'),
                'lastmod' => $this->formatDate(now()),
                'changefreq' => 'yearly',
                'priority' => '0.6',
            ],
            [
                'loc' => route('front.blog'),
                'lastmod' => $this->formatDate(now()),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('front.our-project'),
                'lastmod' => $this->formatDate(now()),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('front.all.service'),
                'lastmod' => $this->formatDate(now()),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('front.industry.all'),
                'lastmod' => $this->formatDate(now()),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
           
        ]);

        $serviceCategories = Category::query()
            ->where('status', 1)
            ->whereNotNull('slug')
            ->whereHas('products', function ($query) {
                $query->where('status', 1);
            })
            ->get(['id', 'slug', 'updated_at', 'created_at']);

        foreach ($serviceCategories as $category) {
            $urls->push([
                'loc' => route('front.shop', ['slug' => $category->slug]),
                'lastmod' => $this->formatDate($category->updated_at ?? $category->created_at ?? now()),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ]);
        }

        $industries = ChildCategory::query()
            ->where('status', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at', 'created_at']);

        foreach ($industries as $industry) {
            $urls->push([
                'loc' => route('front.industry', ['slug' => $industry->slug]),
                'lastmod' => $this->formatDate($industry->updated_at ?? $industry->created_at ?? now()),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ]);
        }

        $blogs = Blog::query()
            ->where('status', 1)
            ->whereNotNull('slug')
            ->get(['slug', 'updated_at', 'created_at']);

        foreach ($blogs as $blog) {
            $urls->push([
                'loc' => route('front.blog_details', ['slug' => $blog->slug]),
                'lastmod' => $this->formatDate($blog->updated_at ?? $blog->created_at),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ]);
        }

        $customPages = CustomPage::query()
            ->where('status', 1)
            ->whereNotNull('slug')
            ->get(['slug', 'updated_at', 'created_at']);

        foreach ($customPages as $page) {
            $urls->push([
                'loc' => route('front.customPages', ['slug' => $page->slug]),
                'lastmod' => $this->formatDate($page->updated_at ?? $page->created_at),
                'changefreq' => 'monthly',
                'priority' => '0.4',
            ]);
        }

        $brands = Brand::query()
            ->where('status', 1)
            ->whereNotNull('slug')
            ->get(['slug', 'updated_at', 'created_at']);

        foreach ($brands as $brand) {
            $urls->push([
                'loc' => route('front.product.brand-product', ['slug' => $brand->slug]),
                'lastmod' => $this->formatDate($brand->updated_at ?? $brand->created_at),
                'changefreq' => 'weekly',
                'priority' => '0.4',
            ]);
        }
        $urls = $urls->unique('loc')->values();

        return response()->view('sitemap', [
            'urls' => $urls,
        ])->header('Content-Type', 'application/xml');
    }

    private function formatDate($date): string
    {
        return Carbon::parse($date)->toAtomString();
    }
}


