<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\DokumenSurat;
use App\Models\Siswa;
use App\Models\SuratKeluar;

class KepalaSekolahController extends Controller
{
    // Tampilkan daftar surat yang menunggu acc
    public function index()
    {
        $surats = DokumenSurat::with(['suratKeluar.siswa.kelasJurusan.kelas', 'suratKeluar.siswa.kelasJurusan.jurusan'])
                    ->where('status', 0)->latest()->get();

        return view('KepalaSekolah.index', compact('surats'));
    }

    // ACC surat dan buat file Word
    public function acc(Request $request, $id)
{
    $request->validate([
        'ttd_kepsek' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->id_surat != $id) {
        return back()->with('error', 'ID surat tidak valid.');
    }

    $surat = DokumenSurat::with([
        'suratKeluar.siswa.pelanggaransiswa.dataPointPelanggaran',
        'suratKeluar.siswa.kelasJurusan.kelas',
        'suratKeluar.siswa.kelasJurusan.jurusan'
    ])->findOrFail($id);

    // ✅ Upload + validasi dimensi + konversi ke PNG
    $path = null;
    if ($request->hasFile('ttd_kepsek')) {
        $file = $request->file('ttd_kepsek');

        // Validasi ukuran pixel minimal
        [$width, $height] = getimagesize($file->getPathname());
        if ($width < 640 || $height < 200) {
            return back()->with('error', 'Ukuran tanda tangan terlalu kecil. Minimal 640x200 piksel.');
        }

        // Konversi ke PNG
        $imageResource = null;
        $ext = strtolower($file->getClientOriginalExtension());

        if ($ext === 'jpg' || $ext === 'jpeg') {
            $imageResource = imagecreatefromjpeg($file->getPathname());
        } elseif ($ext === 'png') {
            $imageResource = imagecreatefrompng($file->getPathname());
        } else {
            return back()->with('error', 'Format gambar tidak didukung.');
        }

        $fileName = 'ttd_' . time() . '.png';
        $savePath = storage_path('app/public/ttd_kepsek/' . $fileName);
        imagepng($imageResource, $savePath);
        imagedestroy($imageResource);

        $path = 'ttd_kepsek/' . $fileName;
    }

    // ✅ Update status dan path ttd
    $surat->update([
        'status' => 1,
        'ttd_kepsek' => $path,
    ]);

    $siswa = $surat->suratKeluar->siswa;
    $totalPoin = $siswa->pelanggaransiswa->sum(fn($p) => $p->dataPointPelanggaran->point_pelanggaran ?? 0);

    // ✅ Ambil template surat
    $templatePath = storage_path('app/public/template/Surat.docx');

    if (!file_exists($templatePath)) {
        return back()->with('error', 'Template surat tidak ditemukan di: ' . $templatePath);
    }

    // ✅ Buat surat Word
    $phpWord = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
    $phpWord->setValues([
        'nama' => $siswa->nama,
        'kelas_jurusan' => $siswa->kelasJurusan->kelas->kelas . ' - ' . $siswa->kelasJurusan->jurusan->nama_jurusan,
        'total_poin' => $totalPoin,
        'jenis_surat' => $surat->jenis_surat,
        'keterangan' => $surat->keterangan,
        'tanggal' => \Carbon\Carbon::parse($surat->tanggal_pembuatan)->translatedFormat('d F Y'),
        'kode_surat' => $surat->kode_surat,
    ]);

    // ✅ Sisipkan gambar tanda tangan proporsional
    $phpWord->setImageValue('ttd_kepsek', [
        'path' => storage_path('app/public/' . $path),
        'width' => 300,
        'height' => 150,
        'ratio' => false,
        'wrappingStyle' => 'inline'
    ]);



    // ✅ Simpan file surat
    $fileName = 'Surat_' . str_replace(' ', '_', $siswa->nama) . '_' . time() . '.docx';
    Storage::makeDirectory('public/hasil_surat');
    $phpWord->saveAs(storage_path('app/public/hasil_surat/' . $fileName));

    $surat->update([
        'link_file' => 'storage/hasil_surat/' . $fileName
    ]);

    return back()->with('success', 'Surat berhasil di-ACC dan ditandatangani.');
}





    // Tolak surat
    public function tolak($id)
    {
        $surat = DokumenSurat::findOrFail($id);
        $surat->update(['status' => 2]); // Tolak
        return back()->with('error', 'Surat telah ditolak.');
    }

    public function preview($id)
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

    public function riwayatSurat()
    {
        $surats = DokumenSurat::with([
            'suratKeluar.siswa.kelasJurusan.kelas',
            'suratKeluar.siswa.kelasJurusan.jurusan'
        ])
        ->where('status', 1) // hanya yang sudah ACC
        ->latest()
        ->get();

        return view('KepalaSekolah.DaftarRiwayatSurat', compact('surats'));
    }




}
