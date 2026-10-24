<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $usaha = config('seblak.usaha');

        $categories = Category::with([
            'menus' => fn ($query) => $query->where('is_available', true),
        ])->get()->filter(fn ($category) => $category->menus->isNotEmpty());

        $testimonials = Testimonial::latest()->take(6)->get();

        return view('home', compact('usaha', 'categories', 'testimonials'));
    }
}