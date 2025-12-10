<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        return view('pages.admin.settings', compact('settings'));
    }

    /**
     * Menyimpan perubahan pengaturan.
     */
    public function update(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],  
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}