<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    // Method index untuk menampilkan semua produk (sesuai soal)
    public function index()
    {
        $produk = Produk::orderBy('id_produk', 'desc')->get();
        return view('produk.index', compact('produk'));
    }

    // Method create untuk menampilkan form (sesuai soal)
    public function create()
    {
        return view('produk.create_produk');
    }

    // Method store untuk menyimpan data (sesuai soal)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:100',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error', 'Terdapat kesalahan dalam input data.');
        }

        Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Method edit untuk menampilkan form edit (sesuai soal)
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit_produk', compact('produk'));
    }

    // Method update untuk update data (sesuai soal)
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:100',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error', 'Terdapat kesalahan dalam input data.');
        }

        $produk = Produk::findOrFail($id);
        $produk->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui!');
    }

    // Method destroy untuk hapus data (sesuai soal)
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus.');
    }

    // Method untuk frontend
    public function homeProduk()
    {
        $produk = Produk::orderBy('id_produk', 'desc')->get();
        return view('front.produk', compact('produk'));
    }

    public function detail($nama)
    {
        return 'Ini halaman detail produk bernama '.$nama;
    }

    public function search(Request $request)
    {
        $nama = $request->input('nama');
        $harga_min = $request->input('min');
        $harga_max = $request->input('max');

        $query = Produk::query();

        if (!empty($nama)) {
            $query->where('nama', 'like', '%' . $nama . '%');
        }

        if (!empty($harga_min)) {
            $query->where('harga', '>=', $harga_min);
        }

        if (!empty($harga_max)) {
            $query->where('harga', '<=', $harga_max);
        }

        $produk = $query->get();

        return view('front.produk', compact('produk', 'nama', 'harga_min', 'harga_max'));
    }
}