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
        $this->penerbit = new Penerbit();
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
            'nama' => 'required|min:3|max:50',
            'kota' => 'required|min:3|max:50',
            'alamat' => 'required',
            'telepon' => 'required|min:1|max:50',
        ];
        // bikin pesan error
        $messages = [
            'kode.required' => ':attribute harus diisi.',
            'kode.unique' => ':attribute sudah digunakan.',
            'nama.required' => ':attribute harus diisi.',
            'nama.min' => ':attribute harus memiliki minimal :min karakter.',
            'nama.max' => ':attribute tidak boleh melebihi :max karakter.',
            'kota.required' => ':attribute harus diisi.',
            'alamat.required' => ':attribute harus diisi.',
            'telepon.required' => ':attribute harus diisi.'
        ];
        // eksekusii
        $this->validate($request, $rules, $messages);

        $this->penerbit->nama = $request->nama;
        $this->penerbit->kode = $request->kode;
        $this->penerbit->alamat = $request->alamat;
        $this->penerbit->telepon = $request->telepon;
        $this->penerbit->kota = $request->kota;

        $this->penerbit->save();
        // Alert::success('Succespul!...', ' Data Berhasil Disimpan');
        return redirect()->route('penerbit.index');

    }

    public function edit($id)
    {
        $penerbits = Penerbit::findOrFail($id);

        $penerbit = Penerbit::all();
        $buku = Buku::all();
        return view('penerbit.edit', compact('buku','penerbits','penerbit'));
    }

    public function update(Request $request, $id)
    {
        $penerbit = Penerbit::findOrFail($id);

        $rules = [
            'kode' => 'required|unique:buku',
            'nama' => 'required|min:3|max:50',
            'kota' => 'required|min:3|max:50',
            'alamat' => 'required',
            'telepon' => 'required|min:1|max:50',
        ];
        // bikin pesan error
        $messages = [
            'kode.required' => ':attribute harus diisi.',
            'kode.unique' => ':attribute sudah digunakan.',
            'nama.required' => ':attribute harus diisi.',
            'nama.min' => ':attribute harus memiliki minimal :min karakter.',
            'nama.max' => ':attribute tidak boleh melebihi :max karakter.',
            'kota.required' => ':attribute harus diisi.',
            'alamat.required' => ':attribute harus diisi.',
            'telepon.required' => ':attribute harus diisi.'
        ];
        // eksekusii
        $this->validate($request, $rules, $messages);

        $penerbit->nama = $request->nama;
        $penerbit->kode = $request->kode;
        $penerbit->alamat = $request->alamat;
        $penerbit->telepon = $request->telepon;
        $penerbit->kota = $request->kota;

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