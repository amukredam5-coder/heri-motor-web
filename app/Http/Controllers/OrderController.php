<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sparepart;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * SISI ADMIN: Menampilkan halaman Dashboard (Manajemen Transaksi).
     * Terhubung ke: Route::get('/admin/dashboard')
     */
    public function index()
    {
        // Menampilkan pesanan yang masuk (pending/selesai) untuk diproses Admin
        // Eager loading reseller dan items untuk efisiensi
        $orders = Order::with(['reseller', 'items.sparepart'])->latest()->get(); 
        
        // Pastikan nama file view ini adalah 'manajemen_transaksi.blade.php'
        return view('manajemen_transaksi', compact('orders'));
    }

    /**
     * SISI RESELLER: Menampilkan Katalog & Riwayat Pesanan.
     */
    public function dashboardReseller(Request $request)
    {
        $search = $request->input('search');

        $barangs = Sparepart::when($search, function ($query, $search) {
            return $query->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('kode_barang', 'like', "%{$search}%");
        })->get();

        $orders = Order::with('items.sparepart')
                       ->where('reseller_id', Auth::id())
                       ->latest()
                       ->get(); 
        
        return view('reseller_dashboard', compact('barangs', 'orders'));
    }

    /**
     * FUNGSI TAMBAH BARANG: Menambahkan barang ke session cart.
     */
    public function addToCart(Request $request, $id)
    {
        $barang = Sparepart::findOrFail($id);
        
        if ($barang->stok <= 0) {
            return back()->with('error', 'Stok barang ' . $barang->nama_barang . ' sedang habis!');
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $barang->stok) {
                return back()->with('error', 'Tidak bisa menambah lebih banyak, stok terbatas!');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $barang->nama_barang, 
                "quantity" => 1,
                "price" => $barang->harga,
                "photo" => $barang->foto
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Barang berhasil ditambah ke keranjang!');
    }

    public function viewCart()
    {
        return view('cart');
    }

    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $barang = Sparepart::find($request->id);

            if(!$barang || $request->quantity > $barang->stok) {
                return back()->with('error', 'Stok tidak mencukupi');
            }

            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Keranjang diperbarui!');
        }
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Barang dihapus dari keranjang');
    }

    /**
     * PROSES CHECKOUT: Simpan ke DB, Potong Stok, & Notifikasi.
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) return back()->with('error', 'Keranjang Anda kosong!');

        DB::beginTransaction();
        try {
            $total = 0;
            foreach($cart as $details) {
                $total += $details['price'] * $details['quantity'];
            }

            $order = Order::create([
                'order_id' => 'HM-' . strtoupper(bin2hex(random_bytes(3))),
                'reseller_id' => Auth::id(), 
                'total_bayar' => $total,
                'status_pesanan' => 'pending',
                'metode_pembayaran' => 'tunai_di_toko',
            ]);

            foreach($cart as $id => $details) {
                $barang = Sparepart::find($id);
                if($barang) {
                    if($barang->stok < $details['quantity']) {
                        throw new \Exception("Stok {$barang->nama_barang} tidak mencukupi.");
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'sparepart_id' => $id,
                        'jumlah' => $details['quantity'],
                        'harga_satuan' => $details['price']
                    ]);

                    $barang->decrement('stok', $details['quantity']);
                }
            }

            DB::commit();

            $admins = User::where('role', 'admin')->get();
            if($admins->count() > 0) {
                Notification::send($admins, new NewOrderNotification($order));
            }

            session()->forget('cart'); 
            return redirect()->route('reseller.dashboard')->with('success', 'Pesanan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * SISI ADMIN: Konfirmasi Pesanan Selesai.
     */
    public function konfirmasi($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status_pesanan' => 'selesai']);

        return back()->with('success', 'Pesanan ' . $order->order_id . ' telah selesai!');
    }

    public function cetakStruk($id)
    {
        $order = Order::with(['reseller', 'items.sparepart'])->findOrFail($id);
        return view('cetak_struk', compact('order'));
    }

    /**
     * SISI ADMIN: Laporan Pendapatan.
     * Terhubung ke: Route::get('/admin/laporan')
     */
    public function laporan()
    {
        // Menghitung statistik untuk ditampilkan di view laporan_pendapatan
        $totalPendapatan = Order::where('status_pesanan', 'selesai')->sum('total_bayar');
        $pendapatanHariIni = Order::where('status_pesanan', 'selesai')
                                   ->whereDate('created_at', today())
                                   ->sum('total_bayar');
        $transaksiSelesai = Order::where('status_pesanan', 'selesai')->count();
        $latestOrders = Order::where('status_pesanan', 'selesai')->latest()->take(10)->get();

        // Pastikan nama file view ini adalah 'laporan_pendapatan.blade.php'
        return view('laporan_pendapatan', compact('totalPendapatan', 'pendapatanHariIni', 'transaksiSelesai', 'latestOrders'));
    }

    /**
     * AJAX: Tandai Notifikasi sudah dibaca
     */
    public function markAsRead()
    {
        if(Auth::user()->unreadNotifications) {
            Auth::user()->unreadNotifications->markAsRead();
        }
        return response()->json(['status' => 'success']);
    }
}