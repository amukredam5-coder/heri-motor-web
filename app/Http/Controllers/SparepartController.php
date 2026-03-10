<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use Illuminate\Support\Facades\File;

class SparepartController extends Controller
{
    // --- FUNGSI UNTUK DASHBOARD WEB ---

    public function index(Request $request)
    {
        $query = Sparepart::query();

        if ($request->filled('merk')) {
            $query->where('merk', $request->merk);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

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

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $namaFoto);
        } else {
            return back()->withErrors(['foto' => 'Gagal mengunggah foto.']);
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

        if ($request->hasFile('foto')) {
            if ($item->foto && File::exists(public_path('images/' . $item->foto))) {
                File::delete(public_path('images/' . $item->foto));
            }

            $file = $request->file('foto');
            $namaFoto = time() . "_" . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $item->update($data);
        return redirect()->route('sparepart.index')->with('success', 'Data diperbarui!');
    }

    public function destroy($id) 
    {
        $item = Sparepart::findOrFail($id);
        if ($item->foto && File::exists(public_path('images/' . $item->foto))) {
            File::delete(public_path('images/' . $item->foto));
        }
        $item->delete();
        return back()->with('success', 'Item berhasil dihapus');
    }

    // --- FUNGSI KHUSUS API FLUTTER (DITAMBAHKAN) ---

    /**
     * Mengambil semua data untuk Flutter (GET)
     */
    public function getApiData()
    {
        // Mengambil data langsung dari Aiven Cloud
        return response()->json(Sparepart::all(), 200);
    }

    /**
     * Menambah data baru dari Flutter (POST)
     */
    public function storeApiData(Request $request)
    {
        try {
            $data = Sparepart::create([
                'kode_barang' => 'HM-' . rand(100, 999),
                'nama_barang' => $request->nama_barang,
                'stok'        => $request->stok,
                'harga'       => $request->harga,
                'merk'        => $request->merk,
                'kategori'    => $request->kategori,
                'foto'        => 'default.jpg', // Default sementara untuk API
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data masuk ke database Aiven!',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
