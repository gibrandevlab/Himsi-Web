<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Proker;

class DivisionController extends Controller
{
    public function show($division)
    {

        $divisiData = [
            'rsdm' => [
                'divisi' => 'rsdm',
                'title' => 'Hai, selamat datang di halaman Departemen Divisi Riset dan Sumber Daya Manusia HIMSI',
                'count_proyekkerja' => '15',
                'count_anggota' => Member::whereIn('occupation', ['ketua koordinator rsdm', 'anggota rsdm'])->count(),
                'tentang' => 'Divisi RSDM bertanggung jawab atas pengelolaan sumber daya manusia di DPC. Tugas divisi ini meliputi perekrutan anggota baru, evaluasi keanggotaan, dan pengelolaan kegiatan internal pengurus DPC. Divisi ini memastikan bahwa proses rekrutmen anggota baru berjalan dengan lancar, mengelola kaderisasi anggota, serta melakukan evaluasi keanggotaan untuk meningkatkan kualitas sumber daya manusia.',
                'members' => Member::select('name', 'image', 'periode', 'occupation')->whereIn('occupation', ['Ketua Koordinator Rsdm', 'anggota rsdm'])->get(),
                'prokerItems' => Proker::whereRaw('LOWER(divisi) = ?', ['rsdm'])
                         ->select('id', 'divisi', 'fotokegiatan', 'title', 'content', 'created_at')
                         ->get(),
            ],
            'pendidikan' => [
                'divisi' => 'pendidikan',
                'title' => 'Hai, selamat datang di halaman Departemen Pendidikan HIMSI',
                'count_proyekkerja' => '15',
                'count_anggota' => Member::whereIn('occupation', ['ketua koordinator pendidikan', 'anggota pendidikan'])->count(),
                'tentang' => 'Divisi Pendidikan mengelola dan mengembangkan kompetensi SDM HIMSI UBSI serta mendukung mahasiswa melalui program pendidikan, bimbingan, dan kegiatan yang meningkatkan daya saing serta keterampilan praktis.',
                'members' => Member::select('name', 'image', 'periode', 'occupation')->whereIn('occupation', ['Ketua Koordinator Pendidikan', 'anggota pendidikan'])->get(),
                'prokerItems' => Proker::whereRaw('LOWER(divisi) = ?', ['pendidikan'])
                         ->select('id', 'divisi', 'fotokegiatan', 'title', 'content', 'created_at')
                         ->get(),
            ],
            'litbang' => [
                'divisi' => 'litbang',
                'title' => 'Hai, selamat datang di halaman Departemen Penelitian dan Pengembangan HIMSI',
                'count_proyekkerja' => '15',
                'count_anggota' => Member::whereIn('occupation', ['ketua koordinator litbang', 'anggota litbang'])->count(),
                'tentang' => 'Divisi Litbang bertanggung jawab melaksanakan fungsi penelitian dan pengembangan serta kegiatan yang bersifat umum dengan mengedepankan Sistem Informasi. Divisi ini fokus pada pengembangan dan penerapan teknologi informasi untuk mendukung berbagai inisiatif dan program HIMSI UBSI, memastikan inovasi dan kemajuan berkelanjutan dalam berbagai aspek organisasi.',
                'members' => Member::select('name', 'image', 'periode', 'occupation')->whereIn('occupation', ['ketua koordinator litbang', 'anggota litbang'])->get(),
                'prokerItems' => Proker::whereRaw('LOWER(divisi) = ?', ['litbang'])
                         ->select('id', 'divisi', 'fotokegiatan', 'title', 'content', 'created_at')
                         ->get(),
            ],
            'kominfo' => [
                'divisi' => 'kominfo',
                'title' => 'Hai, selamat datang di halaman Departemen Komunikasi dan Informasi HIMSI',
                'count_proyekkerja' => '15',
                'count_anggota' => Member::whereIn('occupation', ['ketua koordinator kominfo', 'anggota kominfo'])->count(),
                'tentang' => 'Divisi Kominfo bertanggung jawab menghubungkan internal dan eksternal HIMSI serta mengelola sosial media HIMSI UBSI. Misinya adalah memimpin pencitraan dan penyebaran informasi serta membangun hubungan antar instansi di dalam dan luar kampus.',
                'members' => Member::select('name', 'image', 'periode', 'occupation')->whereIn('occupation', ['Ketua Koordinator Kominfo', 'anggota kominfo'])->get(),
                'prokerItems' => Proker::whereRaw('LOWER(divisi) = ?', ['kominfo'])
                         ->select('id', 'divisi', 'fotokegiatan', 'title', 'content', 'created_at')
                         ->get(),
            ],
        ];


        foreach ($divisiData as &$divisi) {
            foreach ($divisi['prokerItems'] as &$prokerItem) {
                // Memisahkan string gambar menjadi array
                $prokerItem['fotokegiatan'] = explode(',', $prokerItem['fotokegiatan']);
                // Mengencode array menjadi JSON string
                $prokerItem['fotokegiatan'] = json_encode($prokerItem['fotokegiatan']);
            }
        }

        if (array_key_exists($division, $divisiData)) {
            $data = $divisiData[$division];
        } else {
            abort(404);
        }

        return view('pages.landing_page.division', [
            'title' => $data['title'],
            'divisi' => $data['divisi'],
            'count_proyekkerja' => $data['count_proyekkerja'],
            'count_anggota' => $data['count_anggota'],
            'tentang' => $data['tentang'],
            'members' => $data['members'],
            'prokerItems' => $data['prokerItems'],
        ]);
    }
}
