<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard()
    {
        $mobil = Kendaraan::with('mobil')->where('jenis','mobil')->get();
        $motor = Kendaraan::with('motor')->where('jenis','motor')->get();

        $allmobil = count($mobil);

        $allmobilsold = count($mobil->where('status','terjual'));
        $allmobilready = count($mobil->where('status','terjual'));

        $allmotor = count($motor);
        $allmotorsold = count($motor->where('status','terjual'));
        $allmotorready = count($motor->where('status','terjual'));

        $data = [
            'Jumlah Semua mobil' => $allmobil,
            'Jumlah Semua Mobil Terjual' => $allmobilsold,
            'Jumlah Mobil Ready' => $allmobilready,

            'Jumlah Semua Motor' => $allmotor,
            'Jumlah Semua Motor Terjual' => $allmotorsold,
            'Jumlah Semua Motor Ready' => $allmotorready,

            'Jumlah Semua Kendaraan' => $allmobil + $allmotor,
            'Jumlah Kendaraan Terjual' => $allmobilsold + $allmotorsold,
            'Jumlah Kendaraan Ready' => $allmobilready + $allmotorready,
        ];
        $response = [
            'message' => 'Stok',
            'data' => $data
        ];
        // dd($data);

        return response()->json($response, Response::HTTP_OK);
    }

    public function indexMotor()
    {
        $data = Kendaraan::with('mobil')->where('jenis','motor')->get();


        return response()->json(['data' => $data]);
    }
    public function indexMobil()
    {
        $data = Kendaraan::with('mobil')->where('jenis','mobil')->get();

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
            'status' => $request->status,
            'jenis' => $request->jenis,
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
            'status' => $request->status,
            'jenis' => $request->jenis,
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
        $kendaraan->status = $request->input('status');

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
        $kendaraan->status = $request->input('status');

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
