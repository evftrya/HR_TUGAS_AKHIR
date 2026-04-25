<?php

namespace App\Http\Controllers;

use App\Models\Coe;
use Illuminate\Http\Request;

class CoeController extends Controller
{
    public function index()
    {
        $coes = Coe::orderBy('nama_coe')->paginate(20);
        return view('kelola_data.coe.list', compact('coes'));
    }

    public function new()
    {
        return view('kelola_data.coe.input');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_coe' => 'required|string|max:255',
        ]);

        Coe::create($data);

        return redirect()->route('manage.coe.index')->with('success', 'COE berhasil dibuat');
    }

    public function show($id)
    {
        $coe = Coe::findOrFail($id);
        return view('coe.show', compact('coe'));
    }

    public function edit($id)
    {
        $coe = Coe::findOrFail($id);
        return view('coe.edit', compact('coe'));
    }

    public function update(Request $request, $id)
    {
        $coe = Coe::findOrFail($id);
        $data = $request->validate([
            'nama_coe' => 'required|string|max:255',
        ]);

        $coe->update($data);

        return redirect()->route('manage.coe.index')->with('success', 'COE berhasil diperbarui');
    }

    public function destroy($id)
    {
        $coe = Coe::findOrFail($id);
        $coe->delete();
        return redirect()->route('manage.coe.index')->with('success', 'COE berhasil dihapus');
    }
}
