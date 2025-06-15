@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-900 text-white px-4">
        <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg p-8 mt-10">
            <h2 class="text-2xl font-bold mb-6 text-center text-blue-400">Login Admin</h2>

            @if ($errors->any())
                <div class="mb-4 text-red-400 bg-red-900/30 p-3 rounded text-center font-semibold shadow">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="Email"
                        class="bg-gray-700 text-white p-3 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600"
                        required autofocus>
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password"
                        class="bg-gray-700 text-white p-3 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600"
                        required>
                </div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded w-full font-semibold transition duration-200 shadow">
                    Login
                </button>
            </form>
        </div>
    </div>
@endsection
