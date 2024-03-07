<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penerbit;

class BukuController extends Controller
{
    public $book;
    public function __construct()
    {
        $this->book = new buku();
    }
    public function index(Request $request)
    {
        $cari = $request->get('search');

        $penerbit = Penerbit::all();
        $buku = Buku::all();
        $book = Buku::where('nama_buku', 'LIKE', "%$cari%")->simplePaginate(5);

        $no = $book->firstItem() - 1;
        return view('buku.index', compact('book','buku','penerbit', 'no'));
    }

    public function create()
    {
        $penerbit = Penerbit::all();
        $buku = Buku::all();
        return view('buku.create', compact('buku','penerbit'));
    }

    public function store(Request $request)
    {
        $rules = [
            'kode' => 'required|unique:buku',
            'nama_buku' => 'required|min:3|max:50',
            'harga' => 'required|min:3|max:50',
            'penerbit' => 'required',
            'stok' => 'required|min:1|max:50',
            'kategori' => 'required|min:3|max:50'
        ];
        // bikin pesan error
        $messages = [
            'kode.required' => ':attribute harus diisi.',
            'kode.unique' => ':attribute sudah digunakan.',
            'nama_buku.required' => ':attribute harus diisi.',
            'nama_buku.min' => ':attribute harus memiliki minimal :min karakter.',
            'nama_buku.max' => ':attribute tidak boleh melebihi :max karakter.',
            'harga.required' => 'Deskripsi harus diisi.',
            'penerbit.required' => 'Penerbit harus diisi.',
            'stok.required' => 'ISBN harus diisi.',
            'kategori.required' => 'Kategori harus dipilih.'
        ];
        // eksekusii
        $this->validate($request, $rules, $messages);

        $this->book->nama_buku = $request->nama_buku;
        $this->book->kode = $request->kode;
        $this->book->kategori = $request->kategori;
        $this->book->harga = $request->harga;
        $this->book->stok = $request->stok;
        $this->book->penerbit_id = $request->penerbit;

        $this->book->save();
        // Alert::success('Succespul!...', ' Data Berhasil Disimpan');
        return redirect()->route('buku.index');

    }

    public function edit($id)
    {
        $book = Buku::findOrFail($id);

        $penerbit = Penerbit::all();
        $buku = Buku::all();
        return view('buku.edit', compact('buku','book','penerbit'));
    }

    public function update(Request $request, $id)
    {
        $book = Buku::findOrFail($id);

        $rules = [
            'kode' => 'required',
            'nama_buku' => 'required|min:3|max:50',
            'harga' => 'required|min:3|max:50',
            'penerbit' => 'required',
            'stok' => 'required|min:1|max:50',
            'kategori' => 'required|min:3|max:50'
        ];
        // bikin pesan error
        $messages = [
            'kode.required' => ':attribute harus diisi.',
            'kode.unique' => ':attribute sudah digunakan.',
            'nama_buku.required' => ':attribute harus diisi.',
            'nama_buku.min' => ':attribute harus memiliki minimal :min karakter.',
            'nama_buku.max' => ':attribute tidak boleh melebihi :max karakter.',
            'harga.required' => 'Deskripsi harus diisi.',
            'penerbit.required' => 'Penerbit harus diisi.',
            'stok.required' => 'ISBN harus diisi.',
            'kategori.required' => 'Kategori harus dipilih.'
        ];
        // eksekusii
        $this->validate($request, $rules, $messages);

        $book->nama_buku = $request->nama_buku;
        $book->kode = $request->kode;
        $book->kategori = $request->kategori;
        $book->harga = $request->harga;
        $book->stok = $request->stok;
        $book->penerbit_id = $request->penerbit;

        $book->save();
        // Alert::success('Succespul!...', ' Data Berhasil Disimpan');
        return redirect()->route('buku.index');

    }

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        $book->delete();


       // Alert::success('Berhasil!', 'Data berhasil dihapus');

        return redirect()->route('buku.index');
    }

}