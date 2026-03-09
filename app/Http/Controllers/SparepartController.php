<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use Illuminate\Support\Facades\File;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $query = Sparepart::query();

        // Filter berdasarkan Merk Kendaraan (Honda, Yamaha, dll)
        if ($request->filled('merk')) {
            $query->where('merk', $request->merk);
        }

        // Filter berdasarkan Kategori Part (Shockbreaker, Blok Mesin, dll)
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Pencarian Nama/Kode Barang
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        $semuaBarang = $query->get();
        return view('index', compact('semuaBarang'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'foto'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'merk'        => 'required',
            'kategori'    => 'required',
        ]);

        // Proteksi jika file tidak ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $namaFoto);
        } else {
            return back()->withErrors(['foto' => 'Gagal mengunggah foto. Pastikan form memiliki enctype="multipart/form-data"']);
        }

        Sparepart::create([
            'kode_barang' => 'HM-' . rand(100, 999),
            'nama_barang' => $request->nama_barang,
            'stok'        => $request->stok,
            'harga'       => $request->harga,
            'foto'        => $namaFoto,
            'merk'        => $request->merk,
            'kategori'    => $request->kategori,
        ]);

        return redirect()->route('sparepart.index')->with('success', 'Barang berhasil ditambah!');
    }

    public function edit($id)
    {
        $item = Sparepart::findOrFail($id);
        return view('edit', compact('item')); 
    }

    public function update(Request $request, $id)
    {
        $item = Sparepart::findOrFail($id);
        
        $request->validate([
            'nama_barang' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'nama_barang' => $request->nama_barang,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'merk'        => $request->merk,
            'kategori'    => $request->kategori,
        ];

        // Jika user mengunggah foto baru saat edit
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($item->foto && File::exists(public_path('images/' . $item->foto))) {
                File::delete(public_path('images/' . $item->foto));
            }

            $file = $request->file('foto');
            $namaFoto = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $item->update($data);

        return redirect()->route('sparepart.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id) 
    {
        $item = Sparepart::findOrFail($id);
        
        // Hapus file fisik foto dari folder images agar tidak membebani storage
        if ($item->foto && File::exists(public_path('images/' . $item->foto))) {
            File::delete(public_path('images/' . $item->foto));
        }

        $item->delete();
        return back()->with('success', 'Item berhasil dihapus');
    }

    public function cetakLabel($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('cetak_label', compact('sparepart'));
    }

    public function resellerIndex()
    {
        $barangs = Sparepart::all(); 
        return view('reseller_dashboard', compact('barangs'));
    }
}