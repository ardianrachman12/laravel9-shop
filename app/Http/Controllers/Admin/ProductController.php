<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('subcategories')->get();
        return view('produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $subcategory = Subcategory::all();
        return view('produk.create', compact('subcategory','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('gambar')) {
            return back()->with('error', 'Gambar harus diisi');
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
        
        return redirect()->route('produk.index')->with('success', 'Berhasil tambah data');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $data = Product::with('subcategories')->findOrFail($id);
        $subcategory = Subcategory::all();
        return view('produk.edit', compact('data','subcategory','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Product::with('subcategories')->findOrFail($id);

        if ($request->hasFile('gambar')) {
            File::delete('uploads/' . $data->gambar);
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
        }else{
            $input = [
                'nama' => $request->input('nama'),
                'sku' => $request->input('sku'),
                'deskripsi' => $request->input('deskripsi'),
                'stok' => $request->input('stok'),
                'berat' => $request->input('berat'),
                'harga' => $request->input('harga'),
                'subcategory_id' => $request->input('subcategory_id'),
            ];
        }

        $data->update($input);
        
        return redirect()->route('produk.index')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        File::delete('uploads/' . $data->gambar);
        $data->delete();
        return redirect('produk')->with('success', 'berhasil hapus data');
    }

    public function selectCategory(Request $request){
        $id_category = $request->id_category;

        $subcategory = Subcategory::where('category_id',$id_category)->get();

        foreach($subcategory as $subcategory){
            echo "<option value='$subcategory->id'>$subcategory->nama</option>";
        }
    }

    public function uploadProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file_product' => 'required|file|mimes:xlsx,csv,txt' // Tambahkan tipe file yang diperbolehkan sesuai kebutuhan
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            Excel::import(new ProductImport, $request->file_product);
            return redirect()->back()->with('success', 'berhasil upload');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
