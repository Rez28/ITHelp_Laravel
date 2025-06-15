<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestHelp;
use App\Models\IpMapping;
use App\Models\Admin;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $status = $request->query('status');
        $q = $request->query('q');
        $from = $request->query('from');
        $to = $request->query('to');

        $requests = RequestHelp::with('mapping')
            ->when($status, fn($q2) => $q2->where('status', $status))
            ->when($q, function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('issue_type', 'like', "%$q%")
                        ->orWhere('note', 'like', "%$q%")
                        ->orWhereHas('mapping', fn($m) => $m->where('label', 'like', "%$q%"))
                        ->orWhere('ip_address', 'like', "%$q%");
                });
            })
            ->when($from, fn($query, $from) => $query->whereDate('created_at', '>=', $from))
            ->when($to, fn($query, $to) => $query->whereDate('created_at', '<=', $to))
            ->where('status', '!=', 'Selesai')
            ->latest()
            ->paginate(10);

        $countMenunggu = RequestHelp::where('status', 'Menunggu')->count();
        $countProses = RequestHelp::where('status', 'Proses')->count();
        $countSelesai = RequestHelp::where('status', 'Selesai')->count();

        return view('admin.dashboard', compact(
            'requests',
            'countMenunggu',
            'countProses',
            'countSelesai'
        ));
    }

    public function history(Request $request)
    {
        $requests = RequestHelp::with('mapping')
            ->where('status', 'Selesai')
            ->latest()
            ->get();
        return view('admin.history', compact('requests'));
    }

    // IP Mapping CRUD
    public function ipMapping(Request $request)
    {
        $editId = $request->query('edit');
        $mappings = IpMapping::all()->map(function ($m) {
            $m->online = $this->isOnline($m->ip_address);
            return $m;
        });
        return view('admin.ip-mapping', compact('mappings', 'editId'));
    }

    public function storeIpMapping(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ipv4|unique:ip_mappings',
            'label' => 'required|string|max:255',
        ]);
        IpMapping::create($request->only('ip_address', 'label'));
        return back()->with('success', 'Mapping ditambahkan.');
    }

    public function editIpMapping($id)
    {
        // Redirect ke halaman utama dengan query edit
        return redirect()->route('admin.ip-mapping', ['edit' => $id]);
    }

    public function updateIpMapping(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
        ]);
        $mapping = IpMapping::findOrFail($id);
        $mapping->update([
            'label' => $request->label,
        ]);
        return redirect()->route('admin.ip-mapping')->with('success', 'Label berhasil diupdate.');
    }

    public function destroyIpMapping($id)
    {
        $mapping = IpMapping::findOrFail($id);
        $mapping->delete();
        return redirect()->route('admin.ip-mapping')->with('success', 'Mapping berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'resolution_note' => 'nullable|string',
        ]);

        $req = RequestHelp::findOrFail($id);
        $req->update([
            'status' => $request->status,
            'resolution_note' => $request->resolution_note,
        ]);

        return back()->with('success', 'Status permintaan berhasil diperbarui.');
    }

    public function export()
    {
        $filename = 'permintaan_bantuan.csv';
        $requests = RequestHelp::with('mapping')->latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Waktu', 'IP Address', 'Komputer', 'Masalah', 'Catatan', 'Status', 'Catatan Penyelesaian'];

        $callback = function () use ($requests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($requests as $req) {
                fputcsv($file, [
                    $req->created_at,
                    $req->ip_address,
                    $req->mapping->label ?? '-',
                    $req->issue_type,
                    $req->note,
                    $req->status,
                    $req->resolution_note,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function isOnline($ip)
    {
        // Windows: -n 1 (1x ping), -w 1000 (timeout 1 detik)
        $output = [];
        $result = null;
        exec("ping -n 1 -w 1000 $ip", $output, $result);
        return $result === 0;
    }
}
