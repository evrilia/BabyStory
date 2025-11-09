@extends('layouts.admin')

@section('page_title', 'Change Password')

@section('content')
    <div class="flex justify-center items-center min-h-[80vh] bg-gray-50">
        <div class="bg-[#E2F2FB] rounded-2xl p-10 w-full max-w-lg shadow-md text-center">
            {{-- Logo --}}
            <div class="mb-8 text-center p-6">
                <img src="{{ asset('images/LogoBaby.png') }}" class="w-40 mb-6 mx-auto" alt="Baby Story">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Change Password</h2>
                <p class="text-sm text-gray-600">Ubah Kata Sandi Akun</p>
            </div>



            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alert error --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                    <ul class="text-sm">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('admin.change-password.update') }}" class="space-y-4">
                @csrf
                <div class="flex justify-between items-center">
                    <label for="current_password" class="text-gray-500 w-40 text-left">Password Lama</label>
                    <input type="password" id="current_password" name="current_password"
                        class="bg-white text-gray-500 rounded-md px-3 py-2 w-60 focus:ring-2 focus:ring-blue-200 outline-none border-0"
                        placeholder="Masukkan password baru" required>
                </div>

                <div class="flex justify-between items-center">
                    <label for="new_password" class="text-gray-500 w-40 text-left">Password Baru</label>
                    <input type="password" id="new_password" name="new_password"
                        class="bg-white text-gray-500 rounded-md px-3 py-2 w-60 focus:ring-2 focus:ring-blue-200 outline-none border-0"
                        placeholder="Masukkan password baru" required>
                </div>

                <div class="flex justify-between items-center">
                    <label for="new_password_confirmation" class="text-gray-500 w-40 text-left">Konfirmasi Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        class="bg-white text-gray-500 rounded-md px-3 py-2 w-60 focus:ring-2 focus:ring-blue-200 outline-none border-0"
                        placeholder="Masukkan password baru" required>
                </div>


                <div class="pt-6">
                    <button type="submit"
                        class="bg-pink-400 hover:bg-pink-500 text-white font-medium py-2 px-6 rounded-full transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
