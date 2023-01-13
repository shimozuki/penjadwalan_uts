<?php

namespace App\Http\Controllers;

use App\Jadwal;
use App\Mapel;
use App\Paket;
use App\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapel = Mapel::OrderBy('kelompok', 'asc')->OrderBy('nama_mapel', 'asc')->get();
        $paket = Paket::all();
        // echo "<pre>";
        // print_r($mapel);
        // echo "</pre>";
        return view('admin.mapel.index', compact('mapel', 'paket'));
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_mapel' => 'required',
            'paket_id' => 'required',
            'kelompok' => 'required',
            'code_mk' => 'required',
        ]);
        $cek = Mapel::where('code_mk', $request->code_mk)->first();
        if (!empty($cek)) {
            return redirect()->back()->with('info', 'Data Matakuliah Sudah Ada');
        } else {
            Mapel::updateOrCreate(
                [
                    'id' => $request->mapel_id
                ],
                [
                    'nama_mapel' => $request->nama_mapel,
                    'paket_id' => $request->paket_id,
                    'kelompok' => $request->kelompok,
                    'code_mk'   => $request->code_mk,
                    'semester' => $request->semester,
                ]
            );

            return redirect()->back()->with('success', 'Data mapel berhasil diperbarui!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $mapel = Mapel::findorfail($id);
        $paket = Paket::all();
        return view('admin.mapel.edit', compact('mapel', 'paket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapel = Mapel::findorfail($id);
        $countJadwal = Jadwal::where('mapel_id', $mapel->id)->count();
        if ($countJadwal >= 1) {
            $jadwal = Jadwal::where('mapel_id', $mapel->id)->delete();
        } else {
        }
        $countGuru = Guru::where('mapel_id', $mapel->id)->count();
        if ($countGuru >= 1) {
            $guru = Guru::where('mapel_id', $mapel->id)->delete();
        } else {
        }
        $mapel->delete();
        return redirect()->back()->with('warning', 'Data mapel berhasil dihapus! (Silahkan cek trash data mapel)');
    }

    public function trash()
    {
        $mapel = Mapel::onlyTrashed()->get();
        return view('admin.mapel.trash', compact('mapel'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $mapel = Mapel::withTrashed()->findorfail($id);
        $countJadwal = Jadwal::withTrashed()->where('mapel_id', $mapel->id)->count();
        if ($countJadwal >= 1) {
            $jadwal = Jadwal::withTrashed()->where('mapel_id', $mapel->id)->restore();
        } else {
        }
        $countGuru = Guru::withTrashed()->where('mapel_id', $mapel->id)->count();
        if ($countGuru >= 1) {
            $guru = Guru::withTrashed()->where('mapel_id', $mapel->id)->restore();
        } else {
        }
        $mapel->restore();
        return redirect()->back()->with('info', 'Data mapel berhasil direstore! (Silahkan cek data mapel)');
    }

    public function kill($id)
    {
        $mapel = Mapel::withTrashed()->findorfail($id);
        $countJadwal = Jadwal::withTrashed()->where('mapel_id', $mapel->id)->count();
        if ($countJadwal >= 1) {
            $jadwal = Jadwal::withTrashed()->where('mapel_id', $mapel->id)->forceDelete();
        } else {
        }
        $countGuru = Guru::withTrashed()->where('mapel_id', $mapel->id)->count();
        if ($countGuru >= 1) {
            $guru = Guru::withTrashed()->where('mapel_id', $mapel->id)->forceDelete();
        } else {
        }
        $mapel->forceDelete();
        return redirect()->back()->with('success', 'Data mapel berhasil dihapus secara permanent');
    }

    public function getMapelJson(Request $request)
    {
        $jadwal = Jadwal::OrderBy('mapel_id', 'asc')->where('kelas_id', $request->kelas_id)->get();
        $jadwal = $jadwal->groupBy('mapel_id');

        foreach ($jadwal as $val => $data) {
            $newForm[] = array(
                'mapel' => $data[0]->pelajaran($val)->nama_mapel,
                'guru' => $data[0]->pengajar($data[0]->guru_id)->id
            );
        }

        return response()->json($newForm);
    }
    public function pilih(Request $request)
    {

        $id_mapel = $request->id;
        $dosen = $request->id_dosen;
        if ($id_mapel != 0) {
            DB::beginTransaction();
            try {
                Mapel::where('id', $id_mapel)->update([
                    'id_dosen' => $dosen,
                ]);
                Guru::where('id', $dosen)->update([
                    'mapel' => $id_mapel
                ]);
                DB::commit();
                return redirect()->back()->with('success', 'Data MataKuliah berhasil dipilih');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('danger', $e);
            }
        }
    }
}
