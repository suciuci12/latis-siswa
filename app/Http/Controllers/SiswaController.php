<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Lembaga;
use Illuminate\Support\Facades\Storage;  
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $lembagas = Lembaga::all();

        $query = Siswa::with('lembaga');

        if ($request->lembaga_id) {
            $query->where('lembaga_id', $request->lembaga_id);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%$search%")
                  ->orWhere('nama', 'like', "%$search%");
            });
        }

        $siswas = $query->get();

        return view('siswa.index', compact('siswas', 'lembagas'));
    }

    public function create()
    {
        $lembagas = Lembaga::all();
        return view('siswa.create', compact('lembagas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'        => 'required|numeric|unique:siswas,nis',
            'nama'       => 'required',
            'email'      => 'required|email',
            'lembaga_id' => 'required|exists:lembagas,id',
            'foto'       => 'nullable|image|mimes:jpg,png|max:100', 
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('foto-siswa', 'public');
        }

        Siswa::create([
            'nis'        => $request->nis,
            'nama'       => $request->nama,
            'email'      => $request->email,
            'lembaga_id' => $request->lembaga_id,
            'foto'       => $pathFoto,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        $lembagas = Lembaga::all();
        return view('siswa.edit', compact('siswa', 'lembagas'));
    }


    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'        => 'required|numeric|unique:siswas,nis,' . $siswa->id,
            'nama'       => 'required',
            'email'      => 'required|email',
            'lembaga_id' => 'required|exists:lembagas,id',
            'foto'       => 'nullable|image|mimes:jpg,png|max:100',
        ]);

        $pathFoto = $siswa->foto;

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $pathFoto = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa->update([
            'nis'        => $request->nis,
            'nama'       => $request->nama,
            'email'      => $request->email,
            'lembaga_id' => $request->lembaga_id,
            'foto'       => $pathFoto,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa diupdate');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa dihapus');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new SiswaExport($request->lembaga_id, $request->search),
            'siswa.xlsx'
        );
    }
}
