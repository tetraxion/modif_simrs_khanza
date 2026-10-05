<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasiens = Pasien::latest()->paginate(20);
        return view('admin.pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'nullable|string|max:16|unique:pasiens',
            'no_bpjs' => 'nullable|string|max:50|unique:pasiens',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|string|max:5',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'no_telepon' => 'nullable|string|max:20',
            'agama' => 'nullable|string',
            'status_perkawinan' => 'nullable|string',
            'pekerjaan' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:100',
            'nama_keluarga' => 'nullable|string|max:255',
            'hubungan_keluarga' => 'nullable|string|max:100',
            'no_telepon_keluarga' => 'nullable|string|max:20',
        ]);

        // Generate Nomor Rekam Medis
        $lastPasien = Pasien::latest('id')->first();
        $nextNumber = $lastPasien ? (int)substr($lastPasien->no_rm, 2) + 1 : 1;
        $validated['no_rm'] = 'RM' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        Pasien::create($validated);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        return view('admin.pasien.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nik' => 'nullable|string|max:16|unique:pasiens,nik,' . $pasien->id,
            'no_bpjs' => 'nullable|string|max:50|unique:pasiens,no_bpjs,' . $pasien->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|string|max:5',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'no_telepon' => 'nullable|string|max:20',
            'agama' => 'nullable|string',
            'status_perkawinan' => 'nullable|string',
            'pekerjaan' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:100',
            'nama_keluarga' => 'nullable|string|max:255',
            'hubungan_keluarga' => 'nullable|string|max:100',
            'no_telepon_keluarga' => 'nullable|string|max:20',
        ]);

        $pasien->update($validated);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
