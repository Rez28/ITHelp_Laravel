{{-- filepath: resources\views\admin\ip-mapping.blade.php --}}
@extends('layouts.admin')
@section('content')
    <div class="max-w-2xl mx-auto bg-gray-900 text-white p-6 rounded-2xl mt-8 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <h1 class="text-xl font-bold text-blue-400 flex items-center gap-2">
                <span>🖥️</span> IP Mapping
            </h1>
            <form method="GET" action="{{ url()->current() }}">
                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 p-2 rounded flex items-center justify-center shadow" title="Refresh">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                        <path
                            d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                    </svg>
                </button>
            </form>
        </div>
        @if (session('success'))
            <div class="mb-4 text-green-400 bg-green-900/20 p-2 rounded text-center font-semibold shadow">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="/admin/ip-mapping" class="mb-6 flex flex-col sm:flex-row gap-2">
            @csrf
            <input name="ip_address"
                class="bg-gray-700 text-white p-2 rounded flex-1 border border-gray-600 focus:ring-2 focus:ring-blue-500 text-sm"
                placeholder="192.168.1.xx" required>
            <input name="label"
                class="bg-gray-700 text-white p-2 rounded flex-1 border border-gray-600 focus:ring-2 focus:ring-blue-500 text-sm"
                placeholder="Lab A - PC 01" required>
            <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded font-semibold text-sm shadow">Tambah</button>
        </form>
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm bg-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="p-2 text-left font-semibold">IP Address</th>
                        <th class="p-2 text-left font-semibold">Label</th>
                        <th class="p-2 text-center font-semibold">Status</th>
                        <th class="p-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mappings as $m)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/30 transition">
                            <td class="p-2">{{ $m->ip_address }}</td>
                            <td class="p-2">
                                @if (isset($editId) && $editId == $m->id)
                                    <form method="POST" action="{{ route('admin.ip-mapping.update', $m->id) }}"
                                        class="flex gap-2 items-center">
                                        @csrf
                                        @method('PUT')
                                        <input name="label" value="{{ $m->label }}"
                                            class="bg-gray-700 text-white p-1 rounded w-28 border border-gray-600 focus:ring-2 focus:ring-blue-500 text-xs"
                                            required>
                                        <button
                                            class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-semibold shadow">✔</button>
                                    </form>
                                @else
                                    {{ $m->label }}
                                @endif
                            </td>
                            <td class="p-2 text-center">
                                @if ($m->online)
                                    <span
                                        class="inline-block bg-green-700/80 text-green-100 px-2 py-0.5 rounded-full text-xs font-semibold">Online</span>
                                @else
                                    <span
                                        class="inline-block bg-red-700/80 text-red-100 px-2 py-0.5 rounded-full text-xs font-semibold">Offline</span>
                                @endif
                            </td>
                            <td class="p-2 text-center">
                                <div class="flex gap-1 justify-center">
                                    @if (isset($editId) && $editId == $m->id)
                                        <a href="{{ route('admin.ip-mapping') }}"
                                            class="text-gray-400 text-xs underline px-2 py-1">Batal</a>
                                    @else
                                        <a href="{{ route('admin.ip-mapping.edit', $m->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 px-2 py-1 rounded text-xs text-gray-900 font-semibold shadow">✎</a>
                                        <form method="POST" action="{{ route('admin.ip-mapping.destroy', $m->id) }}"
                                            onsubmit="return confirm('Hapus mapping ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-semibold shadow">🗑</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-6 text-gray-400">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
