<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    // ========== ADMIN CRUD ==========

    public function indexAdmin()
    {
        $informasis = Informasi::latest()->get();
        return view('admin.informasi.index', compact('informasis'));
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'isi_informasi' => 'required|string',
        'foto' => 'nullable|image|max:2048',
    ]);

    $path = $request->file('foto') 
        ? $request->file('foto')->store('informasi', 'public') 
        : null;

    Informasi::create([
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'isi_informasi' => $request->isi_informasi,
        'foto' => $path,
    ]);

    return redirect()->route('admin.informasi.index')
                     ->with('success', 'Informasi berhasil ditambahkan.');
}


    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('admin.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($informasi->foto) {
                Storage::disk('public')->delete($informasi->foto);
            }
            $path = $request->file('foto')->store('informasi', 'public');
            $informasi->foto = $path;
        }

        $informasi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'isi_informasi' => $request->isi_informasi,
            'foto' => $informasi->foto,
            
        ]);

        return redirect()->route('admin.informasi.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        if ($informasi->foto) {
            Storage::disk('public')->delete($informasi->foto);
        }
        $informasi->delete();

        return back()->with('success', 'Informasi berhasil dihapus.');
    }

    // ========== GUEST POV ==========

    public function indexGuest()
    {
        $informasis = Informasi::latest()->get();
        return view('guest.informasi.index', compact('informasis'));
    }

    // ========== USER POV ==========

    public function indexUser()
    {
        $informasis = Informasi::latest()->get();
        return view('user.informasi.index', compact('informasis'));
    }
    public function show($id)
{
    $informasi = Informasi::findOrFail($id);
    return view('user.informasi.show', compact('informasi'));
}
    public function showguest($id)
{
    $informasi = Informasi::findOrFail($id);
    return view('guest.informasi.show', compact('informasi'));
}
}
