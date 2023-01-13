<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Ruang;
class RuanganController extends Controller
{
    public function index()
    {
        $data = Ruang::all();

        return view('admin.ruangan.index', compact('data'));
    }

    public function destroy($id)
    {
        $jadwal = Ruang::findorfail($id);
        $jadwal->forceDelete();
        return redirect()->back()->with('success', 'Data Ruangan berhasil dihapus secara permanent');
    }
    public function getEdit(Request $request)
    {
        $ruang = Ruang::where('id', $request->id)->get();
        foreach ($ruang as $val) {
            $newForm[] = array(
                'id' => $val->id,
                'nama_ruangan' => $val->nama_ruang,
            );
        }
        return response()->json($newForm);
    }

    public function store(Request $request)
    {
        if ($request->id != '') {
            $this->validate($request, [
                'nama_ruang' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'nama_ruang' => 'required',
            ]);
        }
        $kelas = Ruang::where('id', $request->id)->get();
        // echo "<pre>"; 
        // print_r($request->id);
        // echo "</pre>"; 
        if (!empty($kelas)) {
            Ruang::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'nama_ruang' => $request->nama_ruang
                ]
            );
            return redirect()->back()->with('success', 'Data Ruangan berhasil diperbarui!');
        }else {
            Ruang::where('id', $request->id)->update(
                [
                    'nama_ruang' => $request->nama_ruang
                ]
            );
            return redirect()->back()->with('success', 'Data Ruangan berhasil diperbarui!');
        }
    }
}
