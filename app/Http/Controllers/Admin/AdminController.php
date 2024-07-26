<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $data = User::where('role', 'admin')->get();

        return view('admin.index',compact('data'));
    }
    public function create(){
        return view('admin.create');
    }

    public function store(Request $request){
        $request['password']= bcrypt($request->password);
        $request['role']= "admin";
        User::create($request->all());

        return redirect()->route('admin.index')->with('success', 'berhasil tambah data');
    }

    public function edit($id){
        $data = User::findOrFail($id);
        return view('admin.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $data = User::findOrFail($id);

        $data->update($request->all());
        return redirect()->route('admin.index')->with('success', 'berhasil update data');
    }


    public function destroy(string $id)
    {
        $data = User::where('role', 'admin')->findOrFail($id);
        $data->delete();
        return redirect()->route('admin.index')->with('success', 'berhasil hapus data');
    }

}
