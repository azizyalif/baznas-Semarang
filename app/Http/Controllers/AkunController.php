<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AkunController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $data = User::all();
        return view('pages.settings.account', compact('data'));
    }
    public function destroy($id)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $akun = User::find($id);
        if ($akun) {
            $akun->delete();
            return redirect()->route('account')->with('success', 'Akun berhasil dihapus.');
        } else {
            return redirect()->route('account')->with('error', 'Akun tidak ditemukan.');
        }
    }
    public function admin($id)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $akun = User::find($id);
        if ($akun) {
            $akun->role = 'admin';
            $akun->save();
            return redirect()->route('account')->with('success', 'Akun berhasil diubah menjadi Admin.');
        } else {
            return redirect()->route('account')->with('error', 'Akun tidak ditemukan.');
        }
    }
    public function super_admin($id)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $akun = User::find($id);
        if ($akun) {
            $akun->role = 'super_admin';
            $akun->save();
            return redirect()->route('account')->with('success', 'Akun berhasil diubah menjadi Super Admin.');
        } else {
            return redirect()->route('account')->with('error', 'Akun tidak ditemukan.');
        }
    }
    public function operator($id)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $akun = User::find($id);
        if ($akun) {
            $akun->role = 'operator';
            $akun->save();
            return redirect()->route('account')->with('success', 'Akun berhasil diubah menjadi Operator.');
        } else {
            return redirect()->route('account')->with('error', 'Akun tidak ditemukan.');
        }
    }
}
