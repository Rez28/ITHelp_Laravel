<?php

namespace App\Http\Controllers;

use App\Models\RequestHelp;
use Illuminate\Http\Request;
use App\Models\IpMapping;
use App\Events\RequestHelpCreated;

class RequestHelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function form(Request $request)
    {
        $ip = request()->ip();
        $mapping = IpMapping::where('ip_address', $ip)->first();

        return view('form', [
            'ip' => $ip,
            'label' => $mapping ? $mapping->label : null,
            'issues' => [
                'Komputer Tidak Menyala',
                'Tidak Bisa Login',
                'Jaringan Tidak Terhubung',
                'Monitor Rusak',
                'Keyboard/Mouse Tidak Berfungsi',
            ],
        ]);
    }
    public function submit(Request $request)
    {
        $request->validate([
            'issue_type' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $ip = $request->ip();
        $mapping = IpMapping::where('ip_address', $ip)->first();

        if (!$mapping) {
            return redirect()->back()->with('error', 'Alamat IP belum terdaftar. Hubungi admin.');
        }

        // Cek rate-limit 3 menit
        $lastRequest = RequestHelp::where('ip_mapping_id', $mapping->id)
            ->orderByDesc('created_at')
            ->first();

        if ($lastRequest && $lastRequest->created_at->diffInMinutes(now()) < 3) {
            return redirect()->back()->with('error', 'Tunggu 3 menit sebelum mengirim permintaan lagi.');
        }

        $requestHelp = RequestHelp::create([
            'ip_mapping_id' => $mapping->id,
            'ip_address' => $request->ip(),
            'issue_type' => $request->issue_type,
            'note' => $request->note,
        ]);

        event(new RequestHelpCreated($requestHelp));


        return redirect()->back()->with('success', 'Permintaan bantuan telah dikirim.');
    }

    public function riwayat(Request $request)
    {
        $ip = $request->ip();
        $mapping = \App\Models\IpMapping::where('ip_address', $ip)->first();
        $label = $mapping ? $mapping->label : null;

        $riwayat = \App\Models\RequestHelp::with('mapping')
            ->where('ip_address', $ip)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('riwayat', compact('riwayat', 'ip', 'label'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestHelp $requestHelp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestHelp $requestHelp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestHelp $requestHelp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestHelp $requestHelp)
    {
        //
    }
}
