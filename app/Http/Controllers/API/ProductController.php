<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function addCategory(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:categories,nama',
            'deskripsi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors()
            ], 422);
        }

        Category::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $request->all()
        ], 201);
    }

    public function addSubcategory(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'nama' => 'required|unique:subcategories,nama',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors()
            ], 422);
        }

        Subcategory::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $request->all()
        ], 201);
    }

    //add product (admin)
    public function addProduct(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|unique:products,nama',
            'sku' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required|integer',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
            'subcategory_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors()
            ], 422);
        }

        $gambar = $request->file('gambar');
        $extensi = $gambar->extension();
        $nama_gambar = time() . rand(1, 9) . '.' . $extensi;
        $gambar->move(public_path('uploads'), $nama_gambar);

        $input = [
            'nama' => $request->input('nama'),
            'sku' => $request->input('sku'),
            'deskripsi' => $request->input('deskripsi'),
            'stok' => $request->input('stok'),
            'berat' => $request->input('berat'),
            'harga' => $request->input('harga'),
            'subcategory_id' => $request->input('subcategory_id'),
            'gambar' => $nama_gambar,
        ];

        Product::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $input
        ], 200);
    }
}
