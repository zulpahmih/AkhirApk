<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpWord\TemplateProcessor;

use Illuminate\Support\Facades\Log;

use App\Models\Guru;
use App\Models\WaliKelas;
use App\Models\tata_tertib;
use App\Models\DataPointPelanggaran;
use App\Models\KelasJurusan;
use App\Models\RolesModel;
use App\Models\User;
use App\Models\siswa;
use App\Models\OrangTua;
use App\Models\PelanggaranSiswa;
use App\Models\DokumenSurat;
use App\Models\SuratKeluar;

class AdminController extends Controller
{ 
    // DASHBOARD

    public function show_dashboard()
    {
        return view ('Admin.AdminDashboard');
    }

    // GET SISWA INPUT PELANGGARAN

    public function getSiswaByKelasJurusan($kelasJurusanId)
    {
        $siswa = Siswa::where('kelas_jurusan_id', $kelasJurusanId)->get(['id', 'nama']);
        return response()->json($siswa);
    }

    public function getDetailSiswa($id)
    {
        $siswa = Siswa::find($id, ['nis']);
        if ($siswa) {
            return response()->json(['nis' => $siswa->nis]);
        }
        return response()->json(['nis' => ''], 404);
    }

    public function getJenisPelanggaranByTataTertib($id)
    {
        $jenisPelanggaran = DataPointPelanggaran::where('tata_tertib_id', $id)->get();
        return response()->json($jenisPelanggaran);
    }

    public function getPointPelanggaran($id)
    {
        $pelanggaran = DataPointPelanggaran::find($id);

        if (!$pelanggaran) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'point_pelanggaran' => $pelanggaran->point_pelanggaran
        ]);
    }

    // DATA PELANGGARAN SISWA
    public function show_kelola_data_pelanggaran_siswa()
    {
        $pelanggaran_siswa = PelanggaranSiswa::with([
        'siswa.kelasJurusan.kelas',
        'siswa.kelasJurusan.jurusan',
        'tataTertib',
        'dataPointPelanggaran'
        ])->latest()->get();

        // Ambil semua data kelas jurusan
        $kelas_jurusan_list = KelasJurusan::with(['kelas', 'jurusan'])->get();
        $siswa_list = siswa::with(['kelasJurusan.kelas', 'kelasJurusan.jurusan'])->get();
        $tata_tertibs = tata_tertib::all(); // ambil semua data tata tertib
        $data_point_list = DataPointPelanggaran::all(); // ambil semua data point pelanggaran

        return view('Admin.KelolaDataPelanggaranSiswa', compact('pelanggaran_siswa','kelas_jurusan_list', 'siswa_list','tata_tertibs', 'data_point_list'));
    }

    public function getPelanggaranSiswaById($id){
        
        $data = PelanggaranSiswa::with([
        'siswa.kelasJurusan.kelas',
        'siswa.kelasJurusan.jurusan',
        'tataTertib',
        'dataPointPelanggaran'
        ])->findOrFail($id);

        $kelas = $data->siswa->KelasJurusan->kelas;
        $jurusan = $data->siswa->KelasJurusan->jurusan;
            
       
        return response()->json([
            'data' => $data,
            'kelas' => $kelas,
            'jurusan' => $jurusan
        ]);
    }
    
    public function store_data_pelanggaran_siswa(Request $request)
    {
        $request->validate([
            'kelas_jurusan_id'       => 'required',
            'siswa_id'               => 'required',
            'tata_tertib_id'         => 'required',
            'data_point_pelanggaran_id' => 'required',
            'tanggal_pelanggaran'    => 'required|date',
            'foto'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file foto jika diunggah
        $fotoName = null;
        if ($request->hasFile('foto')) {
            $uploadedFile = $request->file('foto');
            $fotoName = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('bukti_pelanggaran', $fotoName, 'public');
        }

        // Simpan ke database hanya nama filenya
        PelanggaranSiswa::create([
            'kelas_jurusan_id'           => $request->kelas_jurusan_id,
            'siswas_id'                  => $request->siswa_id,
            'tata_tertib_id'             => $request->tata_tertib_id,
            'data_point_pelanggarans_id' => $request->data_point_pelanggaran_id,
            'tanggal_pelanggaran'        => $request->tanggal_pelanggaran,
            'foto'                       => $fotoName, // hanya nama file
        ]);

        return redirect()->back()->with('success', 'Data pelanggaran siswa berhasil disimpan.');
    }

    public function edit_data_point_pelanggaran_siswa($id)
    {
        try {
            $pelanggaran = PelanggaranSiswa::with(['siswa', 'kelasJurusan', 'tataTertib', 'dataPointPelanggaran'])->findOrFail($id);
            return response()->json($pelanggaran);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pelanggaran siswa tidak ditemukan.',
                'error' => $th->getMessage()
            ], 404);
        }
    }

    public function updatePelanggaranSiswa(Request $request, $id)
    {
        $request->validate([
            'tata_tertib_id' => 'required|exists:tata_tertibs,id',
            'data_point_pelanggaran_id' => 'required|exists:data_point_pelanggarans,id',
            'tanggal_pelanggaran' => 'required|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {
            $pelanggaran = PelanggaranSiswa::findOrFail($id);

            $pelanggaran->tata_tertib_id = $request->tata_tertib_id;
            $pelanggaran->data_point_pelanggarans_id = $request->data_point_pelanggaran_id;
            $pelanggaran->tanggal_pelanggaran = $request->tanggal_pelanggaran;

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($pelanggaran->foto && Storage::disk('public')->exists('bukti_pelanggaran/' . $pelanggaran->foto)) {
                    Storage::disk('public')->delete('bukti_pelanggaran/' . $pelanggaran->foto);
                }

                // Simpan foto baru
                $uploadedFile = $request->file('foto');
                $filename = time() . '_' . $uploadedFile->getClientOriginalName(); // Buat nama unik (opsional)
                $uploadedFile->storeAs('bukti_pelanggaran', $filename, 'public');

                // Simpan hanya nama file ke database
                $pelanggaran->foto = $filename;
            }


            $pelanggaran->save();

            return redirect()->back()->with('success', 'Data pelanggaran siswa berhasil diperbarui.');

        } catch (\Throwable $th) {
            log::error('Error updating pelanggaran siswa: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $th->getMessage());
        }
    }

    public function destroyPelanggaranSiswa($id)
    {
        $pelanggaran = PelanggaranSiswa::findOrFail($id);

        // Hapus foto jika ada
        if ($pelanggaran->foto && Storage::disk('public')->exists('bukti_pelanggaran/' . $pelanggaran->foto)) {
            Storage::disk('public')->delete('bukti_pelanggaran/' . $pelanggaran->foto);
        }

        // Hapus data
        $pelanggaran->delete();

        return redirect()->back()->with('success', 'Data pelanggaran siswa berhasil dihapus.');
    }



    // LIHAT PELANGGARAN SISWA
    public function show_lihat_data_pelanggaran(Request $request)
    {

        $pelanggarans = PelanggaranSiswa::with([
        'siswa.kelasJurusan.kelas',
        'siswa.kelasJurusan.jurusan',
        'dataPointPelanggaran',
        ])->get();

        $rekapPelanggaran = $pelanggarans
            ->groupBy('siswas_id')
            ->map(function ($items) {
                $siswa = $items->first()->siswa;
                $kelasJurusan = $siswa->kelasJurusan;
                $kelasNama = $kelasJurusan->kelas->kelas ?? '-';
                $jurusanNama = $kelasJurusan->jurusan->nama_jurusan ?? '-';

                return [
                    'nis' => $siswa->nis,
                    'nama_siswa' => $siswa->nama,
                    'kelas_jurusan' => $kelasNama . ' - ' . $jurusanNama,
                    'total_point' => $items->sum(fn($item) => $item->dataPointPelanggaran->point_pelanggaran ?? 0),
                ];
                })
                ->sortByDesc('total_point')
                ->values();

        // Ambil keyword pencarian
        $search = $request->input('search');
        if ($search) {
            $rekapPelanggaran = $rekapPelanggaran
                ->filter(fn($row) => 
                    str_contains(strtolower($row['nis']), strtolower($search)) ||
                    str_contains(strtolower($row['nama_siswa']), strtolower($search)) ||
                    str_contains(strtolower($row['kelas_jurusan']), strtolower($search)) ||
                    str_contains((string)$row['total_point'], $search)
                )
                ->values(); // reset index setelah filter
        }


        return view('Admin.LihatDataPelanggaran', compact('rekapPelanggaran','search'));
    }
    

    
    // KELOLA DATA AKUN PELANGGARAN
    public function show_kelola_data_akun()
    {

       $users = User::with(['role', 'guru', 'siswa','orangTua'])
        ->join('roles', 'users.roles_id', '=', 'roles.id')
        ->orderByRaw("FIELD(roles.nama_role, 'kepsek', 'guru_bk', 'guru_wakel', 'siswa','ortu')")
        ->get();

        return view('Admin.KelolaDataAkun', compact('users'));
    }


    // DATA SURAT
    public function getSiswaByKelasJurusanPoint($kelasJurusanId)
    {

        $siswaList = Siswa::with(['pelanggaransiswa.dataPointPelanggaran'])
        ->where('kelas_jurusan_id', $kelasJurusanId)
        ->get()
        ->filter(function ($siswa) {
            $total = $siswa->pelanggaransiswa->sum(function ($pel) {
                return optional($pel->dataPointPelanggaran)->point_pelanggaran ?? 0;
            });
            return $total >= 50;
        })
        ->map(function ($siswa) {
            $total = $siswa->pelanggaransiswa->sum(function ($pel) {
                return optional($pel->dataPointPelanggaran)->point_pelanggaran ?? 0;
            });

            return [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'total_poin' => $total
            ];
        })
        ->values();

    return response()->json($siswaList);
    }

    public function preview_admin($id)
    {
        $surat = DokumenSurat::with([
            'suratKeluar.siswa.pelanggaransiswa.dataPointPelanggaran',
            'suratKeluar.siswa.kelasJurusan.kelas',
            'suratKeluar.siswa.kelasJurusan.jurusan'
        ])->findOrFail($id);

        $siswa = $surat->suratKeluar->siswa;
        $totalPoin = $siswa->pelanggaransiswa->sum(fn($p) => $p->dataPointPelanggaran->point_pelanggaran ?? 0);

        $html = '
            <p><strong>Kode Surat:</strong> ' . $surat->kode_surat . '</p>
            <p><strong>Nama Siswa:</strong> ' . $siswa->nama . '</p>
            <p><strong>Kelas - Jurusan:</strong> ' . $siswa->kelasJurusan->kelas->kelas . ' - ' . $siswa->kelasJurusan->jurusan->nama_jurusan . '</p>
            <p><strong>Total Poin:</strong> ' . $totalPoin . '</p>
            <p><strong>Jenis Surat:</strong> ' . $surat->jenis_surat . '</p>
            <p><strong>Keterangan:</strong> ' . $surat->keterangan . '</p>
            <p><strong>Tanggal:</strong> ' . \Carbon\Carbon::parse($surat->tanggal_pembuatan)->translatedFormat('d F Y') . '</p>
            
        ';

        return response()->json(['html' => $html]);
    }

    
    public function show_kelola_surat()
    {
        $kelasJurusanList = KelasJurusan::with(['kelas', 'jurusan'])->get();
        $suratList = SuratKeluar::with(['siswa', 'dokumenSurat'])->latest()->get();
        return view('Admin.KelolaSurat', compact('kelasJurusanList', 'suratList'));
    }

    public function cekSuratAcc(Request $request)
    {
        $siswaId = $request->siswa_id;

        $siswa = Siswa::with(['pelanggaransiswa.dataPointPelanggaran'])->find($siswaId);
        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan.'], 404);
        }

        $totalPoin = $siswa->pelanggaransiswa->sum(fn($p) => $p->dataPointPelanggaran->point_pelanggaran ?? 0);

        $jenisSuratValid = match (true) {
            $totalPoin >= 100 => 'Surat Keluar',
            $totalPoin >= 75 => 'Surat Peringatan 2',
            $totalPoin >= 50 => 'Surat Peringatan 1',
            default => null,
        };

        $sudahAda = SuratKeluar::where('siswa_id', $siswaId)
            ->whereHas('dokumenSurat', function ($q) use ($jenisSuratValid) {
                $q->where('jenis_surat', $jenisSuratValid)->where('status', 1);
            })->exists();

        return response()->json([
            'status' => 'ok',
            'jenis_surat' => $jenisSuratValid,
            'sudah_ada' => $sudahAda,
        ]);
    }


    public function store_surat(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kode_surat' => 'required|string',
            'jenis_surat' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $siswa = Siswa::with([
            'kelasJurusan.kelas',
            'kelasJurusan.jurusan',
            'pelanggaransiswa.dataPointPelanggaran'
        ])->findOrFail($request->siswa_id);

        $totalPoin = $siswa->pelanggaransiswa->sum(fn($p) => $p->dataPointPelanggaran->point_pelanggaran ?? 0);

        $jenisSuratValid = match (true) {
            $totalPoin >= 100 => 'Surat Keluar',
            $totalPoin >= 75 => 'Surat Peringatan 2',
            $totalPoin >= 50 => 'Surat Peringatan 1',
            default => null,
        };

        $bulan = date('m', strtotime($request->tanggal));
        $tahun = date('y', strtotime($request->tanggal)); 

        $kodeBulanTahun = $bulan . '/' . $tahun;

         $kode_jenis = match (true) {
            $totalPoin >= 100 => 'SK',
            $totalPoin >= 75 => 'SP2',
            $totalPoin >= 50 => 'SP1',
            default => null,
        };

        $kode = $request->kode_surat."/".$kode_jenis."/STEKMAL/".$kodeBulanTahun;

        if ($request->jenis_surat !== $jenisSuratValid) {
            return back()->withErrors(['jenis_surat' => 'Jenis surat tidak sesuai dengan total poin siswa.']);
        }

        $dokumenSurat = DokumenSurat::create([
            'kode_surat' => $kode,
            'jenis_surat' => $jenisSuratValid,
            'tanggal_pembuatan' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'status' => 0,
        ]);

        $pelanggaranTerkait = $siswa->pelanggaransiswa->last();
        if (!$pelanggaranTerkait) {
            return back()->withErrors(['pelanggaran' => 'Siswa belum memiliki data pelanggaran.']);
        }

        SuratKeluar::create([
            'siswa_id' => $siswa->id,
            'pelanggaran_siswa_id' => $pelanggaranTerkait->id,
            'dokumen_surat_id' => $dokumenSurat->id,
        ]);

        

        return back()->with('success', 'Surat berhasil dibuat.');
    }

    public function hapus_surat($id)
    {
        $surat = SuratKeluar::with('dokumenSurat')->findOrFail($id);

        $path = $surat->dokumenSurat->link_file; // dari database
        $relativePath = str_replace('storage/', '', $path); // jadi: file/namafile.docx

        // Hapus file Word jika sudah ada di storage
        if ($surat->dokumenSurat && $surat->dokumenSurat->link_file) {
            // Ambil hanya nama file-nya dari path
            Storage::disk('public')->delete($relativePath);
            
        }
        
        //Hapus relasi
        if ($surat->dokumenSurat) {
            $surat->dokumenSurat->delete();
        }
        $surat->delete();

        return back()->with('success', 'Surat berhasil dihapus.');
    }




    

    //DATA SISWA
    public function show_kelola_data_siswa()
    {

         $siswa = Siswa::with('kelasJurusan.kelas', 'kelasJurusan.jurusan', 'orangtua')->get();
         $kelasJurusanList = KelasJurusan::with(['kelas', 'jurusan'])->get();
      

        return view('Admin.KelolaDataSiswa', compact ('kelasJurusanList','siswa' ));
    }
    
    public function store_siswa(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // foto opsional, maksimal 2MB
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'nullable|string',
            'alamat' => 'required|string',
            'kelas_jurusan_id' => 'required|exists:kelas_jurusans,id',
        ]);

        // Buat user baru otomatis
        $user = User::create([
            'username' => $request->nis,
            'password' => Hash::make('123'),
            'roles_id' => 3,
        ]);

        // Proses upload foto jika ada
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = $file->store('foto_siswa', 'public'); 
            // ini akan menyimpan di storage/app/public/foto_siswa
            $namaFoto = basename($namaFoto); // ambil nama file saja
            
        }

        // Simpan data siswa
        Siswa::create([
            'foto' => $namaFoto,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'user_id' => $user->id,
            'kelas_jurusan_id' => $request->kelas_jurusan_id,
            'orang_tuas_id' => null, // pastikan ini ada di form
        ]);

        return redirect()->back()->with('success', 'Data siswa dan akun berhasil ditambahkan.');
    }


    public function edit_siswa($id)
    {
        try {
            $siswa = Siswa::with(['kelasJurusan.kelas', 'kelasJurusan.jurusan'])->findOrFail($id);
            return response()->json($siswa);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan.',
                'error' => $th->getMessage()
            ], 404);
        }
    }

    public function update_siswa(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nis' => 'required|unique:siswas,nis,' . $id,
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'kelas_jurusan_id' => 'required|exists:kelas_jurusans,id',
        ]);

        try {
            $siswa = Siswa::findOrFail($id);
            $nisLama = $siswa->nis;

            if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($siswa->foto && Storage::disk('public')->exists('foto_siswa/' . $siswa->foto)) {
                Storage::disk('public')->delete('foto_siswa/' . $siswa->foto);
            }

            // Upload foto baru
            $foto = $request->file('foto');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/foto_siswa', $namaFile);
            $siswa->foto = $namaFile;
            $siswa->save(); // simpan perubahan ke database
            
            }

            $siswa->nis = $request->nis;
            $siswa->nama = $request->nama;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->kelas_jurusan_id = $request->kelas_jurusan_id;
            $siswa->no_hp = $request->no_hp;
            $siswa->alamat = $request->alamat;
            $siswa->save();

            $user = User::where('username', $nisLama)->first();
            if ($user) {
                $user->update(['username' => $request->nis]);
            }

            return redirect()->route('show_kelola_data_siswa')->with([
                'message' => 'Data siswa berhasil diupdate',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $th) {
            log::error('Error updating siswa: ' . $th->getMessage());
            return redirect()->route('show_kelola_data_siswa')->with([
                'message' => 'Gagal mengupdate data siswa',
                'alert-type' => 'error',
            ]);
        }
    }

    public function destroy_siswa($id)
    {
        $siswa = Siswa::with(['suratKeluar.dokumenSurat', 'user'])->findOrFail($id);

        // Hapus surat terkait
        foreach ($siswa->suratKeluar as $surat) {
            // Hapus file jika ada
            if ($surat->dokumenSurat) {
                Storage::delete('public/hasil_surat/' . $surat->dokumenSurat->file_name);
                $surat->dokumenSurat()->delete();
            }
            $surat->delete();
        }

        // Hapus foto siswa jika ada
        if ($siswa->foto && Storage::exists('public/foto_siswa/' . $siswa->foto)) {
            Storage::delete('public/foto_siswa/' . $siswa->foto);
        }

        // Hapus akun user yang terkait
        if ($siswa->user) {
            $siswa->user()->delete();
        }

        // Hapus siswa
        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa dan surat terkait berhasil dihapus.');
    }



    //DATA GURU

    public function show_kelola_data_guru()
    {
        $gurus = Guru::with(['waliKelas.kelasJurusan.kelas', 'waliKelas.kelasJurusan.jurusan'])->get();
        $kelasJurusanList = KelasJurusan::with('kelas', 'jurusan')->get();
        $role = RolesModel::all(); // ambil role guru

        return view('Admin.KelolaDataGuru', compact('gurus' , 'kelasJurusanList', 'role'));
    }

    public function store_guru(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // foto opsional, max 2MB
            'nip' => 'required|unique:gurus,nip',
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jabatan' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'required|string',
            // 'kelas_jurusan_id' => 'required|exists:kelas_jurusans,id',
        ]);

        
            // Buat user baru otomatis
        $user = User::create([
            'username' => $request->nip,
            'password' => Hash::make('123'),
            'roles_id' => $request->role, // asumsi role guru
        ]);
        

        // Proses upload foto jika ada
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = $file->store('foto_guru', 'public'); // simpan di storage/app/public/foto_guru
            $namaFoto = basename($namaFoto); // ambil nama file saja
        }
        

        // Simpan data guru
        $guru = Guru::create([
            'foto' => $namaFoto,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'user_id' =>  $user->id,
            // 'kelas_jurusan_id' => $request->kelas_jurusan_id,
        ]);

        if ($request->kelas_jurusan_id != '') {
                 WaliKelas::create([
                        'guru_id' => $guru->id, 
                        'kelas_jurusan_id' => $request->kelas_jurusan_id,
                    ]);
                }

        return redirect()->back()->with('success', 'Data guru dan akun berhasil ditambahkan.');
    }


    public function edit_guru($id)
    {
        try {
            $guru = Guru::with(['waliKelas.kelasJurusan.kelas', 'waliKelas.kelasJurusan.jurusan','user'])->findOrFail($id);
            return response()->json($guru);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.',
                'error' => $th->getMessage()
            ], 404);
        }
        
    }

    public function update_guru(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nip' => 'required|unique:gurus,nip,' . $id,
            'nama' => 'required |string',
            'tanggal_lahir' => 'required|date',
            'jabatan' => 'nullable |string',
            'no_hp' => 'nullable|string',
            'alamat' => 'required',
            // 'kelas_jurusan_id' => 'required|exists:kelas_jurusans,id',
        ]);

        try {
            $guru = Guru::findOrFail($id);
            $nipLama = $guru->nip;

            // Proses upload dan ganti foto jika ada
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($guru->foto && Storage::disk('public')->exists('foto_guru/' . $guru->foto)) {
                    Storage::disk('public')->delete('foto_guru/' . $guru->foto);
                }

                // Simpan foto baru
                $foto = $request->file('foto');
                $namaFile = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('public/foto_guru', $namaFile);
                $guru->foto = $namaFile;
            }

            // Simpan data guru
            $guru->nip = $request->nip;
            $guru->nama = $request->nama;
            $guru->tanggal_lahir = $request->tanggal_lahir;
            $guru->jabatan = $request->jabatan;
            $guru->no_hp = $request->no_hp;
            $guru->alamat = $request->alamat;
            $guru->save();

            // Update username user jika perlu
            $user = User::where('username', $nipLama)->first();
            if ($user) {
                $user->update(['username' => $request->nip]);
                $user->roles_id = $request->role; // update role jika diperlukan
                $user->save();
            }

            
            $wali = WaliKelas::where('guru_id', $guru->id)->first();

            if ($request->kelas_jurusan_id != '') {
                if ($wali) {
                $wali->update([
                        'kelas_jurusan_id' => $request->kelas_jurusan_id,
                    ]);
                 }else{
                    WaliKelas::create([
                        'guru_id' => $guru->id, 
                        'kelas_jurusan_id' => $request->kelas_jurusan_id,
                    ]);
                 }
            }else{
                $wali ->delete(); // Hapus wali kelas jika tidak ada kelas jurusan yang dipilih
            }
            
            return redirect()->route('show_kelola_data_guru')->with([
                'message' => 'Data guru berhasil diupdate',
                'alert-type' => 'success',
            ]);

        } catch (\Throwable $th) {
            Log::error('Error updating guru: ' . $th->getMessage());
            return redirect()->route('show_kelola_data_guru')->with([
                'message' => 'Gagal mengupdate data guru',
                'alert-type' => 'error',
            ]);
        }
    }


    public function destroy_guru($id)
    {
        $guru = Guru::findOrFail($id);

        // Hapus file foto jika ada
        if ($guru->foto && Storage::exists('public/foto_guru/' . $guru->foto)) {
            Storage::delete('public/foto_guru/' . $guru->foto);
        }

        // Hapus wali kelas jika ada
        if ($guru->waliKelas) {
            $guru->waliKelas()->delete();
        }

        // Hapus akun user yang terkait
        if ($guru->user) {
            $guru->user()->delete();
        }

        // Hapus guru
        $guru->delete();

        return redirect()->back()->with('success', 'Data guru berhasil dihapus.');
    }



    // DATA TATA TERTIB

    public function index_tata_tertib()
    { 
        $tata = tata_tertib::all(); // ambil semua data
        $data = DataPointPelanggaran::all(); // ambil semua data pelanggaran
        return view('Admin.KelolaTataTertib', compact('tata','data'));
    }
    

    public function store_tata(Request $request)
    {
        $validate = $request->validate([
            'nama_tata_tertib' => 'required',
        ]);

        // Simpan data ke model TataTertib
        $tata = new tata_tertib();
        $tata->nama_tata_tertib = $request->get('nama_tata_tertib');

        $tata->save();

        // Notifikasi berhasil
        $notification = array(
            'message' => 'Data tata tertib berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('index_tata_tertib')->with('success', 'Data tata tertib berhasil ditambahkan.');

    }

    public function edit_tata($id){
                try {
                    $data = tata_tertib::find($id);
                    return response()->json($data);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data tata tertib tidak ditemukan.',
                        'error' => $th->getMessage()
                    ], 404);
                }
    }

    public function update_tata(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_tata_tertib' => 'required',
        ]);


        try {
            // Update data ke model TataTertib
        $tata = tata_tertib::find($id);
        $tata->nama_tata_tertib = $request->get('nama_tata_tertib');

        $tata->save();

        // Notifikasi berhasil
        $notification = array(
            'message' => 'Data tata tertib berhasil diupdate',
            'alert-type' => 'success'
        );

            return redirect()->route('show_kelola_tata_tertib')->with($notification);

        } catch (\Throwable $th) {
            Log::error('Error updating tata tertib: ' . $th->getMessage());
            $notification = array(
            'message' => 'Data tata tertib tidak berhasil diupdate',
            'alert-type' => 'error'
        );
            return redirect()->route('index_tata_tertib')->with('success', 'Data tata tertib  berhasil diupdate.');
        }

    }

    public function tata_destroy($id)
    {
        try {
            $tata = tata_tertib::find($id);
            $tata->delete();

            // Notifikasi berhasil
            $notification = array(
                'message' => 'Data tata tertib berhasil dihapus',
                'alert-type' => 'success'
            );

            return redirect()->route('show_kelola_tata_tertib')->with($notification);
        } catch (\Throwable $th) {
            Log::error('Error deleting tata tertib: ' . $th->getMessage());
            // Notifikasi gagal
            $notification = array(
                'message' => 'Data tata tertib berhasil dihapus',
                'alert-type' => 'error'
            );

            return redirect()->route('index_tata_tertib')->with('success', 'Data tata tertib berhasil dihapus.');
        }
    }

    //DATA POINT PELANGGARAN

    public function index_data_point_pelanggaran()
    {
        
        $tata_tertibs = tata_tertib::with('pelanggarans')->get();
        $pelanggarans = DataPointPelanggaran::with('tataTertib')->orderBy('tata_tertib_id', 'asc')->get();
       
        return view('Admin.KelolaDataPointPelanggaran', compact('tata_tertibs', 'pelanggarans'));

    }

    public function data_point_pelanggaran_store(Request $request)
    {
        $request->validate([
        'tata_tertib_id' => 'required|exists:tata_tertibs,id',
        'nama_pelanggaran' => 'required|string|max:255',
        'point_pelanggaran' => 'required|integer|min:0',
    ]);

        DataPointPelanggaran::create([
        'tata_tertib_id' => $request->tata_tertib_id,
        'nama_pelanggaran' => $request->nama_pelanggaran,
        'point_pelanggaran' => $request->point_pelanggaran,
    ]);

        return redirect()->route('index_data_point_pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan');
    }

    public function data_point_pelanggaran_destroy($id)
    {
        $pelanggaran = DataPointPelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('index_data_point_pelanggaran')->with('message', 'Data pelanggaran berhasil dihapus');
    }

    public function edit_data_point_pelanggaran($id)  // harus sama dengan route
    {
        try {
            $data = DataPointPelanggaran::findOrFail($id);
            return response()->json($data);
        } catch (\Throwable $th) {
            Log::error('Error fetching data point pelanggaran: ' . $th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Data pelanggaran tidak ditemukan.',
                'error' => $th->getMessage()
            ], 404);
        }
    }

    public function update_data_point_pelanggaran(Request $request, $id)
    {
        $request->validate([
            'tata_tertib_id' => 'required|exists:tata_tertibs,id',
            'nama_pelanggaran' => 'required|string|max:255',
            'point_pelanggaran' => 'required|integer|min:0',
        ]);

        try {
            $pelanggaran = DataPointPelanggaran::find($id);
            $pelanggaran->tata_tertib_id = $request->tata_tertib_id;
            $pelanggaran->nama_pelanggaran = $request->nama_pelanggaran;
            $pelanggaran->point_pelanggaran = $request->point_pelanggaran;

            $pelanggaran->save();

            return redirect()->route('index_data_point_pelanggaran')->with('success', 'Data pelanggaran berhasil diupdate');
        } catch (\Throwable $th) {
            Log::error('Error updating data point pelanggaran: ' . $th->getMessage());
            return redirect()->route('index_data_point_pelanggaran')->with('error', 'Data pelanggaran tidak berhasil diupdate');
        }
    }


    //DATA ORANG TUA 
    public function show_kelola_data_orangtua(){

        $orangtua = OrangTua::with('siswa','user')->get();
        return view('Admin.LihatDataOrangTua', compact('orangtua'));

    }
    
    //DAFTAR ORANG TUA
    public function cari_nis($nis)  // fungsi untuk mencari nis siswa
    {
        $siswa = siswa::where('nis', $nis)->first();
        return response()->json($siswa);
    }


    public function daftar_orangtua(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required |string',
            'pekerjaan' => 'required |string',
            'no_hp' => 'required |string',
            'alamat' => 'required |string',

        ]);

        //buat validasi akun = nis siswa, jika nis sudah terdaftar, maka tidak bisa mendaftar akun orang tua
        // 1 nis = 1 akun orang tua
        $siswa = Siswa::where('nis', $request->nis)->first();
        if ($siswa -> status == 1) {
            return redirect()->back()->with('error', 'NIS sudah terregister');
        }

        $user = User::create([
            
            'username' => $request->username, 
            'password' => Hash::make($request->password), // password default
            'roles_id' => 4, // asumsikan role untuk orang tua adalah 4
        ]);

        $ortu = new OrangTua();
        $ortu->nama = $request->get('nama');
        $ortu->pekerjaan = $request->get('pekerjaan');
        $ortu->no_hp = $request->get('no_hp');
        $ortu->alamat = $request->get('alamat');
        $ortu->user_id = $user->id; // simpan id user yang baru dibuat
        $ortu->save();

        

        // Update siswa dengan relasi ke orang tua, pengecekan nis sudah dilakukan sebelumnya
        
        $siswa = Siswa::where('nis', $request->nis)->first();
        if ($siswa) {
            $siswa->orang_tuas_id = $ortu->id;
            $siswa->status = 1; // misalnya 1 artinya terhubung
            $siswa->save();
        }

        // Notifikasi berhasil
        $notification = array(
            'message' => 'Akun orang tua berhasil didaftarkan',
            'alert-type' => 'success'
        );

        return redirect()->route('show_login')->with($notification);
    }


}






