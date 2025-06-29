<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\siswa;
use App\Models\WaliKelas;
use App\Models\DataPointPelanggaran;
use App\Models\tata_tertib;
use App\Models\PelanggaranSiswa;


class GuruController extends Controller
{
 
public function show_kelola_data_pelanggaran_kelas()
{
    $guru = Guru::where('user_id', Auth::id())->first();
    $wali = WaliKelas::where('guru_id', $guru->id)->firstOrFail();
    $idKelasJurusan = $wali->kelas_jurusan_id;

    // Ambil hanya siswa & pelanggaran dari kelas yang diwalikan
    $siswas = Siswa::where('kelas_jurusan_id', $wali->kelas_jurusan_id)->get();
    $pelanggarans = PelanggaranSiswa::with(['siswa', 'dataPointPelanggaran'])
        ->whereHas('siswa', function ($query) use ($idKelasJurusan) {
            $query->where('kelas_jurusan_id', $idKelasJurusan);
        })
        ->latest()
        ->get();

    $tataTertib = tata_tertib::all();
    $dataPoints = DataPointPelanggaran::all();

    return view('Guru.KelolaDataPelanggaranKelas', compact(
        'siswas',
        'pelanggarans',
        'tataTertib',
        'dataPoints'
    ));
}



    //funtion untuk proses input data pelanggaran kelas
    
    public function store_data_pelanggaran_kelas(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'siswas_id' => 'required|exists:siswas,id',
            'tata_tertib_id' => 'required|exists:tata_tertibs,id',
            'data_point_pelanggarans_id' => 'required|exists:data_point_pelanggarans,id',
            'tanggal_pelanggaran' => 'required|date',
        ]);

        $guru = Guru::where('user_id', Auth::id())->first();
        $wali = WaliKelas::where('guru_id', $guru->id)->first();

        // Validasi agar siswa benar-benar dari kelas yang diwalikan
        $siswa = Siswa::findOrFail($request->siswas_id);
        if ($siswa->kelas_jurusan_id != $wali->kelas_jurusan_id) {
            abort(403, 'Siswa bukan dari kelas Anda.');
        }

       $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('pelanggaran_foto', 'public');
    }

    PelanggaranSiswa::create([
        'siswas_id' => $request->siswas_id,
        'kelas_jurusan_id' => $wali->kelas_jurusan_id,
        'tata_tertib_id' => $request->tata_tertib_id,
        'data_point_pelanggarans_id' => $request->data_point_pelanggarans_id,
        'tanggal_pelanggaran' => $request->tanggal_pelanggaran,
        'foto' => $fotoPath,
    ]);


        return redirect()->route('show_kelola_data_pelanggaran_kelas')->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    public function getNis($id)
{
    $siswa = Siswa::find($id);
    return response()->json(['nis' => $siswa->nis]);
}

public function getPelanggaran($id)
{
    // Ambil semua pelanggaran dari tata tertib tertentu
    $pelanggaran = DataPointPelanggaran::where('tata_tertib_id', $id)->get();
    return response()->json($pelanggaran);
}

public function getPoint($id)
{
    $data = DataPointPelanggaran::find($id);
    return response()->json(['point_pelanggaran' => $data->point_pelanggaran]);
}
}
