<?php

namespace App\Http\Controllers;
use App\Models\Karyawan;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\DinasLuarKota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class AbsensiController extends Controller
{
    // Metode index tetap sama
    public function index()
{
    $absensis = Absensi::with('karyawan')->orderBy('tanggal', 'desc')->get();
    return view('absensi.index', compact('absensis'));

    

    
// Ambil parameter bulan dan tahun dari query string
$bulan = $request->query('bulan');
$tahun = $request->query('tahun');

// Query izin dengan filter bulan dan tahun jika ada
$absensi = Absensi::where('id_karyawan', $userId)
    ->when($bulan, function ($query) use ($bulan) {
        $query->whereMonth('tanggal', $bulan);
    })
    ->when($tahun, function ($query) use ($tahun) {
        $query->whereYear('tanggal', $tahun);
    })
    ->get();

    

    return response()->json($absensi);



    
}

public function destroy($id)
{
    $absensi = Absensi::findOrFail($id);
    $absensi->delete();

    return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil dihapus.');
}

public function formMasuk()
{
    $karyawans = Karyawan::all();
    return view('absensi.create_masuk', compact('karyawans'));
}




public function absenMasuk(Request $request)
{
    $validatedData = $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id',
        'tanggal' => 'required|date',
        'jam_masuk' => 'required|date_format:H:i',
        'foto_masuk' => 'required|string',
        'latitude_masuk' => 'nullable|regex:/^-?\d{1,3}\.\d+$/',
        'longitude_masuk' => 'nullable|regex:/^-?\d{1,3}\.\d+$/',
        'lokasi_masuk' => 'nullable|string',
    ]);

    $tanggal = Carbon::parse($validatedData['tanggal'])->format('Y-m-d');

    // Cek apakah sudah ada absensi, izin, atau dinas
    /*
    $idKaryawan = $validatedData['id_karyawan'];

    $existingAbsensi = Absensi::where('id_karyawan', $idKaryawan)
        ->whereDate('tanggal', $tanggal)
        ->exists();

    $existingIzin = Izin::where('id_karyawan', $idKaryawan)
        ->where(function ($query) use ($tanggal) {
            $query->whereBetween(DB::raw('DATE(tgl_mulai)'), [$tanggal, $tanggal])
                  ->orWhereBetween(DB::raw('DATE(tgl_selesai)'), [$tanggal, $tanggal])
                  ->orWhere(function ($query) use ($tanggal) {
                      $query->whereDate('tgl_mulai', '<=', $tanggal)
                            ->whereDate('tgl_selesai', '>=', $tanggal);
                  });
        })
        ->exists();

    $existingDinasLuarKota = DinasLuarKota::where('id_karyawan', $idKaryawan)
        ->where(function ($query) use ($tanggal) {
            $query->whereBetween(DB::raw('DATE(tgl_berangkat)'), [$tanggal, $tanggal])
                  ->orWhereBetween(DB::raw('DATE(tgl_kembali)'), [$tanggal, $tanggal])
                  ->orWhere(function ($query) use ($tanggal) {
                      $query->whereDate('tgl_berangkat', '<=', $tanggal)
                            ->whereDate('tgl_kembali', '>=', $tanggal);
                  });
        })
        ->exists();

    if ($existingAbsensi || $existingIzin || $existingDinasLuarKota) {
        return redirect()->route('absensi.formMasuk')->withErrors([
            'message' => 'Karyawan sudah memiliki absensi, izin, atau dinas luar kota pada tanggal ini.',
        ]);
    }
*/
    // Cek status kehadiran
    $jamMasukBatas = '08:00:00';
    $validatedData['status'] = $validatedData['jam_masuk'] > $jamMasukBatas ? 'terlambat' : 'tepat_waktu';

    // Tambahkan lokasi jika ada
    if (!empty($validatedData['latitude_masuk']) && !empty($validatedData['longitude_masuk'])) {
        $alamat = $this->getAlamatDariKoordinat($validatedData['latitude_masuk'], $validatedData['longitude_masuk']);
        $validatedData['lokasi_masuk'] = $alamat;
    }

    // Simpan absensi
    Absensi::create($validatedData);

    return redirect()->route('absensi.index')->with('success', 'Absensi masuk berhasil disimpan.');
}


public function formKeluar()
{
    $karyawans = Karyawan::all();
    return view('absensi.create_keluar', compact('karyawans'));
}


public function absenKeluar(Request $request)
{
    $validatedData = $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id', // ✅ Tambahkan ID karyawan, karena admin yang input
        'tanggal' => 'required|date',
        'jam_keluar' => 'required|date_format:H:i', // Jika kamu pakai <input type="time">
        'foto_keluar' => 'required|string',
        'latitude_keluar' => 'nullable|regex:/^-?\d{1,3}\.\d+$/',
        'longitude_keluar' => 'nullable|regex:/^-?\d{1,3}\.\d+$/',
        'lokasi_keluar' => 'nullable|string',
    ]);

    $idKaryawan = $validatedData['id_karyawan'];
    $tanggal = Carbon::parse($validatedData['tanggal'])->format('Y-m-d');

    // ✅ Cek apakah sudah ada absensi untuk tanggal dan karyawan ini
    $absensi = Absensi::where('id_karyawan', $idKaryawan)
                      ->whereDate('tanggal', $tanggal)
                      ->first();

    if (!$absensi) {
        return redirect()->back()->withErrors(['message' => 'Karyawan belum melakukan absensi masuk pada tanggal ini.']);
    }

    if ($absensi->jam_keluar) {
        return redirect()->back()->withErrors(['message' => 'Karyawan sudah melakukan absensi keluar pada tanggal ini.']);
    }

    // ✅ Tambahkan lokasi otomatis jika koordinat tersedia
    if (!empty($validatedData['latitude_keluar']) && !empty($validatedData['longitude_keluar'])) {
        $alamat = $this->getAlamatDariKoordinat($validatedData['latitude_keluar'], $validatedData['longitude_keluar']);
        $validatedData['lokasi_keluar'] = $alamat;
    }

    // ✅ Update absensi keluar
    $absensi->update([
        'jam_keluar' => $validatedData['jam_keluar'],
        'foto_keluar' => $validatedData['foto_keluar'],
        'latitude_keluar' => $validatedData['latitude_keluar'],
        'longitude_keluar' => $validatedData['longitude_keluar'],
        'lokasi_keluar' => $validatedData['lokasi_keluar'],
    ]);

    return redirect()->route('absensi.index')->with('success', 'Absensi keluar berhasil disimpan.');
}


    

// Menampilkan form edit absensi
public function edit($id)
{
    $absensi = Absensi::findOrFail($id);
    $karyawans = Karyawan::all();

    return view('absensi.edit', compact('absensi', 'karyawans'));
}

// Menyimpan hasil edit absensi
public function update(Request $request, $id)
{
    $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id',
        'tanggal' => 'required|date',
        'jam_masuk' => 'nullable|date_format:H:i:s',
        'jam_keluar' => 'nullable|date_format:H:i:s',
        'status' => 'nullable|string|max:50',
    ]);

    $absensi = Absensi::findOrFail($id);
    $absensi->update($request->only([
        'id_karyawan', 'tanggal', 'jam_masuk', 'jam_keluar', 'status'
    ]));

    return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil diperbarui.');
}


public function getOfficeLocation() 
{
    $latitude = -7.636870688302552;
    $longitude = 111.54264772255189;

    $url = "https://nominatim.openstreetmap.org/reverse?lat={$latitude}&lon={$longitude}&format=json";

    $options = [
        "http" => [
            "header" => "User-Agent: hrm_mobile (liaaa.ty127@gmail.com)"
        ]
    ];
    $context = stream_context_create($options);

    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        return response()->json(['error' => 'Failed to retrieve location'], 500);
    }

    $locationData = json_decode($response, true);

    $address = $locationData['display_name'] ?? 'Unknown location';

    return response()->json([
        'latitude' => $latitude,
        'longitude' => $longitude,
        'address' => $address,
    ]);
}


    // Metode reverse geocoding menggunakan API eksternal untuk mendapatkan alamat dari koordinat
    protected function getAlamatDariKoordinat($latitude, $longitude)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY'); // Menggunakan key yang benar dari .env


        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}");

        if ($response->successful() && isset($response['results'][0]['formatted_address'])) {
            return $response['results'][0]['formatted_address'];
        }

        return null;
    }

    
}




