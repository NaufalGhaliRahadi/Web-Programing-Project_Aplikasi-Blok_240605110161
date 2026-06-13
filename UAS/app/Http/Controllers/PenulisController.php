<?php

namespace App\Http\Controllers;

use App\Models\Penulis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenulisController extends Controller
{
    public function index()
    {
        $penulis = Penulis::orderBy('nama_depan')->get();
        return view('penulis.index', compact('penulis'));
    }

    public function create()
    {
        return view('penulis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'user_name' => 'required|string|max:50|unique:penulis,user_name',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoName = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('foto', $fotoName, 'public');
        }

        Penulis::create([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password),
            'foto' => $fotoName
        ]);

        return redirect()->route('penulis.index')->with('sukses', 'Penulis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penulis = Penulis::findOrFail($id);
        return view('penulis.edit', compact('penulis'));
    }

    public function update(Request $request, $id)
    {
        $penulis = Penulis::findOrFail($id);
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'user_name' => 'required|string|max:50|unique:penulis,user_name,' . $id,
            'password' => 'nullable|string|min:8',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only('nama_depan', 'nama_belakang', 'user_name');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('foto')) {
            if ($penulis->foto != 'default.png') {
                Storage::disk('public')->delete('foto/' . $penulis->foto);
            }
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('foto', $fotoName, 'public');
            $data['foto'] = $fotoName;
        }
        $penulis->update($data);
        return redirect()->route('penulis.index')->with('sukses', 'Penulis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penulis = Penulis::findOrFail($id);
        try {
            if ($penulis->foto != 'default.png') {
                Storage::disk('public')->delete('foto/' . $penulis->foto);
            }
            $penulis->delete();
            return redirect()->route('penulis.index')->with('sukses', 'Penulis dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('penulis.index')->with('gagal', 'Penulis tidak bisa dihapus karena masih memiliki artikel.');
        }
    }
}