<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $product = Product::orderBy('created_at', 'DESC')->get();
        $category = Category::all();
        $sub = Subcategory::all();
        return view('home', compact('product', 'sliders', 'category', 'sub'));
    }

    public function productCategories($id)
    {
        $sub = Subcategory::all();
        $category = Category::all();
        
        $categories = Category::find($id);
        $subcategory = Subcategory::where('category_id', $categories->id)->get();
        $product = Product::whereIn('subcategory_id', $subcategory->pluck('id'))->get();
        return view('customer.product-categories', compact('product', 'category', 'sub','subcategory','categories'));
    }
    
    public function productSubcategories($id)
    {
        $product = Product::where('subcategory_id', $id)->paginate(12);
        $sub = Subcategory::all();
        $category = Category::all();
        // Dapatkan subkategori berdasarkan ID
        $subcategory = Subcategory::find($id);
        
        if ($subcategory) {
            // Jika subcategory ditemukan, tampilkan halaman yang sesuai
            return view('customer.product-subcategories', ['subcategory' => $subcategory],compact('category','product','sub'));
        } else {
            // Jika subkategori tidak ditemukan, lakukan sesuatu, misalnya tampilkan halaman kesalahan 404.
            abort(404);
        }
    }
    
    public function productDetail($id){
        $sub = Subcategory::all();
        $category = Category::all();
        $productdetail = Product::findOrFail($id);
        
        return view('customer.product-detail',compact('sub','category','productdetail'));
    }

    public function search(Request $request){
        $keyword = $request->keyword;
        $product = Product::where('nama', 'LIKE', '%'.$keyword.'%')->get();
        $category = Category::all();
        $sub = Subcategory::all();
        return view('customer.search',compact('product','category','sub'));
    }
}
