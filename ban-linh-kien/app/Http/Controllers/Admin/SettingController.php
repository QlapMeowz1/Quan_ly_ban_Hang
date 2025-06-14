<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $settings = Setting::all()->keyBy('setting_key');
        return view('admins.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['site_name', 'site_email', 'site_phone', 'site_address']);
        foreach ($data as $key => $value) {
            Setting::where('setting_key', $key)->update(['setting_value' => $value, 'updated_at' => now()]);
        }
        return redirect()->route('admin.settings.index')->with('success', 'Cập nhật thông tin website thành công!');
    }
} 