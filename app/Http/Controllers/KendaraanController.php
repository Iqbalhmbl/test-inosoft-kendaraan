<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMotor()
    {
        $data = Kendaraan::join('motors','motors.kendaraan_id','kendaraans.id')
            ->select('kendaraans.*','motors.mesin','motors.tipe_suspensi','motors.transmisi')->get();

        return response()->json(['data' => $data]);
    }
    public function indexMobil()
    {
        $data = Kendaraan::with('mobil')->get();

        return response()->json(['data' => $data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMobil(Request $request)
    {
        $kendaraan = Kendaraan::create([
            'tahun_keluaran' => $request->tahun_keluaran,
            'warna' => $request->warna,
            'harga' => $request->harga,
        ]);

        // Membuat mobil baru dan mengaitkannya dengan kendaraan
        $mobil = new Mobil([
            'mesin' => $request->mesin,
            'kapasitas_penumpang' => $request->kapasitas_penumpang,
            'tipe' => $request->tipe,
        ]);

        $kendaraan->mobil()->save($mobil);

        return response()->json(['status' => $kendaraan]);
    }

    public function storeMotor(Request $request)
    {
        $kendaraan = Kendaraan::create([
            'tahun_keluaran' => $request->tahun_keluaran,
            'warna' => $request->warna,
            'harga' => $request->harga,
        ]);
//
        $motor = Motor::create([
            'kendaraan_id' => $kendaraan['id'],
            'mesin' => $request->mesin,
            'tipe_suspensi' => $request->tipe_suspensi,
            'tipe_transmisi' => $request->tipe_transmisi,
        ]);
        $kendaraan->mobil()->save($motor);

        return response()->json(['status' => $kendaraan, $motor]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function showMobil($id)
    {
        $kendaraan = Kendaraan::with('mobil')->find($id);

        return response()->json(['data' => $kendaraan]);
    }

    public function showMotor($id)
    {
        $kendaraan = Kendaraan::with('motor')->find($id);

        return response()->json(['data' => $kendaraan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kendaraan $kendaraan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function updateMobil(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        $mobil = Mobil::where('kendaraan_id',$id)->first();

        if (!$kendaraan) {
            return response()->json(['message' => 'Data kendaraan tidak ditemukan'], 404);
        }

        $kendaraan->tahun_keluaran = $request->input('tahun_keluaran');
        $kendaraan->warna = $request->input('warna');
        $kendaraan->harga = $request->input('harga');

        $mobil->mesin = $request->input('mesin');
        $mobil->kapasitas_penumpang = $request->input('kapasitas_penumpang');
        $mobil->tipe = $request->input('tipe');

        $mobil->save();
        $kendaraan->save();

        return response()->json(['message' => 'Data kendaraan berhasil diperbarui'], 200);
    }

    public function updateMotor(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        $motor = Motor::where('kendaraan_id',$id)->first();

        if (!$kendaraan) {
            return response()->json(['message' => 'Data kendaraan tidak ditemukan'], 404);
        }
        $kendaraan->tahun_keluaran = $request->input('tahun_keluaran');
        $kendaraan->warna = $request->input('warna');
        $kendaraan->harga = $request->input('harga');

        $motor->mesin = $request->input('mesin');
        $motor->tipe_suspensi = $request->input('tipe_suspensi');
        $motor->tipe_transmisi = $request->input('tipe_transmisi');

        $motor->save();
        $kendaraan->save();

        return response()->json(['message' => 'Data kendaraan berhasil diperbarui'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kendaraan $kendaraan)
    {
        //
    }
}
