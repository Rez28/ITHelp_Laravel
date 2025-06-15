{{-- filepath: c:\laragon\www\itHelp\resources\views\admin\dashboard.blade.php --}}
@extends('layouts.admin')
@section('content')
    <div class="max-w-6xl mx-auto bg-gray-900 text-white p-8 rounded-xl shadow-lg mt-8">
        <h1 class="text-3xl mb-8 font-bold tracking-tight text-blue-400">Permintaan Bantuan</h1>

        @if (session('success'))
            <div class="bg-green-700/80 text-white px-4 py-3 mb-6 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-red-800/90 p-6 rounded-lg shadow text-center">
                <div class="text-lg font-semibold">Menunggu</div>
                <div class="text-3xl font-bold">{{ $countMenunggu }}</div>
            </div>
            <div class="bg-yellow-700/90 p-6 rounded-lg shadow text-center">
                <div class="text-lg font-semibold">Proses</div>
                <div class="text-3xl font-bold">{{ $countProses }}</div>
            </div>
            <div class="bg-green-800/90 p-6 rounded-lg shadow text-center">
                <div class="text-lg font-semibold">Selesai</div>
                <div class="text-3xl font-bold">{{ $countSelesai }}</div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <form method="GET" action="/admin">
                    <select name="status" onchange="this.form.submit()"
                        class="bg-gray-800 text-white p-2 rounded border border-gray-700 focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </form>
                <form method="GET" action="/admin" class="flex gap-2">
                    <input type="date" name="from" value="{{ request('from') }}"
                        class="bg-gray-800 text-white p-2 rounded border border-gray-700 focus:ring-2 focus:ring-blue-500">
                    <input type="date" name="to" value="{{ request('to') }}"
                        class="bg-gray-800 text-white p-2 rounded border border-gray-700 focus:ring-2 focus:ring-blue-500">
                    <button
                        class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded text-white font-semibold transition">Filter</button>
                </form>
                <form method="GET" action="/admin" class="flex gap-2">
                    <input type="text" name="q" placeholder="Cari komputer/IP/masalah..."
                        value="{{ request('q') }}"
                        class="bg-gray-800 text-white p-2 rounded border border-gray-700 w-64 focus:ring-2 focus:ring-blue-500">
                    <button
                        class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded text-white font-semibold transition">Cari</button>
                </form>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.history') }}"
                    class="underline text-blue-400 self-center hover:text-blue-300 transition">Lihat History</a>
                <a href="{{ route('admin.export') }}"
                    class="bg-green-700 hover:bg-green-800 px-4 py-2 rounded text-white font-semibold transition">Export
                    Excel</a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm bg-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-700 text-left">
                    <tr>
                        <th class="p-3 font-semibold border-b border-gray-600">Waktu</th>
                        <th class="p-3 font-semibold border-b border-gray-600">IP Address</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Komputer</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Masalah</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Catatan</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Status</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/70 transition">
                            <td class="p-3">{{ $request->created_at->format('d-m-Y H:i') }}</td>
                            <td class="p-3">{{ $request->ip_address }}</td>
                            <td class="p-3">{{ $request->mapping->label ?? '-' }}</td>
                            <td class="p-3">{{ $request->issue_type }}</td>
                            <td class="p-3">{{ $request->note }}</td>
                            <td class="p-3">
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold
                                @if ($request->status == 'Menunggu') bg-red-700/80
                                @elseif ($request->status == 'Proses') bg-yellow-600/80 text-gray-900
                                @elseif ($request->status == 'Selesai') bg-green-600/80 @endif">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td class="p-3">
                                <form method="POST" action="/admin/update/{{ $request->id }}"
                                    onsubmit="return confirm('Simpan perubahan status?')" class="flex flex-col gap-1">
                                    @csrf
                                    <select name="status"
                                        class="bg-gray-700 text-white rounded p-1 border border-gray-600">
                                        @foreach (['Menunggu', 'Proses', 'Selesai'] as $s)
                                            <option value="{{ $s }}"
                                                {{ $s == $request->status ? 'selected' : '' }}>
                                                {{ $s }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="resolution_note" placeholder="Catatan..."
                                        value="{{ $request->resolution_note }}"
                                        class="bg-gray-800 text-white p-1 rounded w-full border border-gray-600">
                                    <button
                                        class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-semibold transition">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-6 text-gray-400">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $requests->withQueryString()->links() }}
        </div>
    </div>
@endsection
