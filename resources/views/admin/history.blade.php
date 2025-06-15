{{-- filepath: c:\laragon\www\itHelp\resources\views\admin\history.blade.php --}}
@extends('layouts.admin')
@section('content')
    <div class="max-w-6xl mx-auto bg-gray-900 text-white p-8 rounded-xl shadow-lg mt-8">
        <h1 class="text-2xl mb-6 font-bold tracking-tight text-blue-400">History Permintaan Selesai</h1>

        <div class="flex flex-wrap gap-2 mb-6">
            <form method="GET" action="/admin/history" class="flex gap-2">
                <input type="text" name="q" placeholder="Cari komputer/IP/masalah..." value="{{ request('q') }}"
                    class="bg-gray-800 text-white p-2 rounded border border-gray-700 w-64 focus:ring-2 focus:ring-blue-500">
                <button
                    class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded text-white font-semibold transition">Cari</button>
            </form>
            <form method="GET" action="/admin/history" class="flex gap-2">
                <input type="date" name="from" value="{{ request('from') }}"
                    class="bg-gray-800 text-white p-2 rounded border border-gray-700 focus:ring-2 focus:ring-blue-500">
                <input type="date" name="to" value="{{ request('to') }}"
                    class="bg-gray-800 text-white p-2 rounded border border-gray-700 focus:ring-2 focus:ring-blue-500">
                <button
                    class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded text-white font-semibold transition">Filter</button>
            </form>
            <a href="{{ route('admin.export') }}"
                class="bg-green-700 hover:bg-green-800 px-4 py-2 rounded text-white font-semibold transition">Export
                Excel</a>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm bg-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-700 text-left">
                    <tr>
                        <th class="p-3 font-semibold border-b border-gray-600">Waktu</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Komputer</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Masalah</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Status</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Catatan Penyelesaian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $req)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/70 transition">
                            <td class="p-3">{{ $req->created_at->format('d-m-Y H:i') }}</td>
                            <td class="p-3">{{ $req->mapping->label ?? $req->ip_address }}</td>
                            <td class="p-3">
                                <strong>{{ $req->issue_type }}</strong><br>
                                <small>{{ $req->note }}</small>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-600/80">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="p-3">{{ $req->resolution_note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-6 text-gray-400">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
