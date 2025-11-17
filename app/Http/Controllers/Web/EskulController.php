<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Eskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EskulController extends Controller
{


    public function indexGuest()
{
    $eskuls = Eskul::all(); // ambil semua data eskul
    return view('guest.eskul.index', compact('eskuls'));
}

    // Tampilkan daftar eskul untuk user
    public function indexUser()
    {
        $eskuls = Eskul::latest()->get();
        return view('user.eskul.index', compact('eskuls'));
    }

    // Tampilkan daftar eskul untuk admin
    public function indexAdmin()
    {
        $eskuls = Eskul::latest()->get();
        return view('admin.eskul.index', compact('eskuls'));
    }

    // Form tambah eskul
    public function create()
    {
        return view('admin.eskul.create');
    }

    // Simpan eskul baru
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'pembina' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['nama', 'pembina', 'deskripsi']);

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('eskul', 'public');
    }

    Eskul::create($data);

    return redirect()->route('admin.eskul.index')->with('success', 'Data eskul berhasil ditambahkan!');
}


    // Form edit eskul
    public function edit(Eskul $eskul)
    {
        return view('admin.eskul.edit', compact('eskul'));
    }

    // Update eskul
    public function update(Request $request, Eskul $eskul)
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'pembina' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['nama', 'pembina', 'deskripsi']);

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('eskul', 'public');
    }

    $eskul->update($data);

    return redirect()->route('admin.eskul.index')->with('success', 'Data eskul berhasil diperbarui!');
}

    // Hapus eskul
    public function destroy(Eskul $eskul)
    {
        if ($eskul->foto) {
            Storage::disk('public')->delete($eskul->foto);
        }

        $eskul->delete();

        return redirect()->route('admin.eskul.index')->with('success', 'Eskul berhasil dihapus');
    }

    public function show($id)
{
    $eskul = Eskul::findOrFail($id);
    return view('user.eskul.show', compact('eskul'));
}

   public function showguest($id)
{
    $eskul = Eskul::findOrFail($id);
    return view('guest.eskul.show', compact('eskul'));
}
}
