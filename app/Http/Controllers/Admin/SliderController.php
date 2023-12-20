<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Slider::get();
        return view('slider.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slider.create');
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
            return response()->json([
                'message' => 'null'
            ]);
        }

        $gambar = $request->file('gambar');
        $extensi = $gambar->extension();
        $nama_gambar = time() . rand(1, 9) . '.' . $extensi;
        $gambar->move(public_path('uploads'), $nama_gambar);  

        $input = [
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'gambar' => $nama_gambar,
        ];
        
        Slider::create($input);
        
        return redirect()->route('slider.index')->with('success', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Slider::findOrFail($id);
        return view('slider.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Slider::findOrFail($id);

        if ($request->hasFile('gambar')) {
            File::delete('uploads/' . $data->gambar);
            $gambar = $request->file('gambar');
            $extensi = $gambar->extension();
            $nama_gambar = time() . rand(1, 9) . '.' . $extensi;
            $gambar->move(public_path('uploads'), $nama_gambar);

            $input = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
                'gambar' => $nama_gambar,
            ];
        }else{
            $input = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
            ];
        }

        $data->update($input);
        
        return redirect()->route('slider.index')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Slider::findOrFail($id);
        File::delete('uploads/' . $data->gambar);
        $data->delete();
        return redirect('slider')->with('success', 'berhasil hapus data');
    }
}
