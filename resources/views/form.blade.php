@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-900 text-white">
        <div class="w-full max-w-md">
            <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
                <h1 class="text-3xl font-bold mb-8 text-center flex items-center justify-center gap-3 text-blue-400">
                    Permintaan Bantuan
                </h1>

                @if (session('error'))
                    <div class="mb-4 text-red-400 bg-red-900/30 p-3 rounded text-center font-semibold shadow">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 text-green-400 bg-green-900/30 p-3 rounded text-center font-semibold shadow">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-red-400 bg-red-900/30 p-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/submit" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm mb-1 font-semibold">Komputer</label>
                        <div
                            class="bg-gray-700 rounded px-3 py-2 text-sm text-gray-300 flex justify-between items-center border border-gray-600">
                            <span>
                                {{ $label ?? 'Tidak dikenal' }}
                                @if (!$label)
                                    <span class="text-xs text-red-400">(Hubungi admin untuk mapping IP)</span>
                                @endif
                            </span>
                            <span class="text-gray-400 ml-2 text-xs">(IP: {{ $ip }})</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm mb-1 font-semibold">Jenis Masalah <span
                                class="text-red-400">*</span></label>
                        <select name="issue_type" required
                            class="w-full px-3 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600 transition">
                            <option value="">-- Pilih Masalah --</option>
                            @foreach ($issues as $issue)
                                <option value="{{ $issue }}" {{ old('issue_type') == $issue ? 'selected' : '' }}>
                                    {{ $issue }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm mb-1 font-semibold">Catatan <span
                                class="text-gray-400">(Opsional)</span></label>
                        <textarea name="note" rows="3" placeholder="Jelaskan jika perlu..."
                            class="w-full px-3 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600 transition">{{ old('note') }}</textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 px-8 py-2 rounded-lg font-semibold text-lg transition duration-200 shadow flex items-center gap-2 justify-center mx-auto">
                            Panggil Asisten
                        </button>
                    </div>
                </form>
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('user.riwayat') }}"
                    class="text-blue-400 underline hover:text-blue-300 transition font-semibold text-sm">
                    Lihat Riwayat Permintaan
                </a>
            </div>
        </div>
    </div>
@endsection
