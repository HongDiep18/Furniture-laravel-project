<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductType;
use Kjmtrue\VietnamZone\Models\District;
use Kjmtrue\VietnamZone\Models\Province;
use Kjmtrue\VietnamZone\Models\Ward;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $images_banner = Image::where([
            ['type', '=', 'banner'],
            ['status', '=', true]
        ])->get();
            

        $products_type = ProductType::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

        $background = Image::where([
            ['type', '=', 'background',],
            ['status', '=', true]
        ])->first();

        $products_featured = Product::where([
            ['is_featured', '=', true],
            ['status', '=', true]
        ])
        ->orderBy('order', 'asc')
        ->get();

        $posts_inhome = Post::where([
            ['inhome', '=', true],
            ['status', '=', true]
        ])
        ->orderBy('order', 'asc')
        ->get();
        
        $partners = Partner::where('status', true)
        ->orderBy('order', 'asc')
        ->get();

        $images = Image::where([
            ['type', '=', 'image',],
            ['status', '=', true]
        ])->get();


        return view('client.pages.home',
        compact(
            'images_banner', 
            'products_type', 
            'background',
            'products_featured',
            'posts_inhome',
            'partners',
            'images'
        ));
    }

    public function getDistrict($provinceId) {
        $province = Province::findOrFail($provinceId);
        $districts = District::whereProvinceId($provinceId)->get();

        return response()->json([
            'districts' => $districts,
            'province' => $province
        ]);
    }

    public function getWard($districtId) {
        $wards = Ward::whereDistrictId($districtId)->get();

        return response()->json($wards);
    }

}
