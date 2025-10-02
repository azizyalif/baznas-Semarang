<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Arsip;
use App\Exports\ExportArsip;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'operator' && Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $data = Arsip::all();

        return view('arsips.index', compact('data'));
    }
    public function export_excel()
    {
        if (Auth::user()->role !== 'operator' && Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $arsips = new Arsip();
        $arsips = Arsip::all();
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new ExportArsip, "arsip_{$timestamp}.xlsx");
    }
    public function destroy(Arsip $arsip)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        try {
            DB::beginTransaction();

            $arsip = Arsip::all();

            Arsip::truncate();

            DB::commit();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengarsipkan data: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Data arsip berhasil dihapus.');
    }
    public function delete($id)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $arsip = Arsip::find($id);
        if ($arsip) {
            $arsip->delete();
            return redirect()->back()->with('success', 'Data arsip berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Data arsip tidak ditemukan.');
        }
    }
}
