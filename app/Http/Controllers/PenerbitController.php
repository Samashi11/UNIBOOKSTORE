<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penerbit;

class PenerbitController extends Controller
{
    public $penerbit;
    public function __construct()
    {
        $this->penerbit = new buku();
    }
    public function index(Request $request)
    {
        $cari = $request->get('search');

        $penerbit = Penerbit::all();
        $buku = Buku::all();
        $penerbits = Penerbit::where('nama', 'LIKE', "%$cari%")->simplePaginate(5);

        $no = $penerbits->firstItem() - 1;
        return view('penerbit.index', compact('penerbits','buku','penerbit', 'no'));
    }

    public function create()
    {
        $penerbit = Penerbit::all();
        $buku = Buku::all();
        return view('penerbit.create', compact('buku','penerbit'));
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

        $this->penerbit->nama_buku = $request->nama_buku;
        $this->penerbit->kode = $request->kode;
        $this->penerbit->kategori = $request->kategori;
        $this->penerbit->harga = $request->harga;
        $this->penerbit->stok = $request->stok;
        $this->penerbit->penerbit_id = $request->penerbit;

        $this->penerbit->save();
        // Alert::success('Succespul!...', ' Data Berhasil Disimpan');
        return redirect()->route('penerbit.index');

    }

    public function edit($id)
    {
        $penerbit = Penerbit::findOrFail($id);

        $penerbit = Penerbit::all();
        $buku = Buku::all();
        return view('penerbit.edit', compact('buku','book','penerbit'));
    }

    public function update(Request $request, $id)
    {
        $penerbit = Penerbit::findOrFail($id);

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

        $penerbit->nama_buku = $request->nama_buku;
        $penerbit->kode = $request->kode;
        $penerbit->kategori = $request->kategori;
        $penerbit->harga = $request->harga;
        $penerbit->stok = $request->stok;
        $penerbit->penerbit_id = $request->penerbit;

        $penerbit->save();
        // Alert::success('Succespul!...', ' Data Berhasil Disimpan');
        return redirect()->route('penerbit.index');

    }

    public function destroy($id)
    {
        $penerbit = Penerbit::findOrFail($id);

        $penerbit->delete();


       // Alert::success('Berhasil!', 'Data berhasil dihapus');

        return redirect()->route('penerbit.index');
    }

}