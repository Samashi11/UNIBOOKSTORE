<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penerbit;

class DashController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->get('search');

        $penerbit = Penerbit::all();
        $buku = Buku::all();
        $book = Buku::where('nama_buku', 'LIKE', "%$cari%")->simplePaginate(5);
        // bikin angkanya sesuai
        $no = $book->firstItem() - 1;
        return view('dashboard', compact('penerbit','buku','book', 'no'));

    }

    public function pengadaan()
    {
        $buku = Buku::orderBy("stok", "ASC")->take(1)->get();
        $penerbit = Penerbit::all();

        $no = 1;
        return view('pengadaan', compact('penerbit', 'buku', 'no'));
    }
}