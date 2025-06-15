@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-gray-900 text-white p-6 rounded-xl shadow-lg mt-8">
        <h1 class="text-xl font-bold mb-4 text-blue-400">Riwayat Permintaan Bantuan</h1>
        <div class="mb-4 text-sm text-gray-400">IP Anda: {{ $ip }}</div>
        <div class="mb-4 text-sm text-gray-400">Komputer: {{ $label ?? 'Tidak dikenal' }}</div>
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm bg-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-700 text-left">
                    <tr>
                        <th class="p-3 font-semibold border-b border-gray-600">Waktu</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Masalah</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Catatan</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Status</th>
                        <th class="p-3 font-semibold border-b border-gray-600">Catatan Penyelesaian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/70 transition">
                            <td class="p-3">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td class="p-3">{{ $item->issue_type }}</td>
                            <td class="p-3">{{ $item->note }}</td>
                            <td class="p-3">
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold
                                @if ($item->status == 'Menunggu') bg-red-700/80
                                @elseif ($item->status == 'Proses') bg-yellow-600/80 text-gray-900
                                @elseif ($item->status == 'Selesai') bg-green-600/80 @endif">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="p-3">{{ $item->resolution_note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-6 text-gray-400">Belum ada permintaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $riwayat->links() }}
        </div>
        <div class="mt-6 text-center">
            <a href="{{ url('/') }}"
                class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white font-semibold transition">← Kembali ke
                Form</a>
        </div>
    </div>
@endsection
