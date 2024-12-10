<div>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSettings">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h5 class="text-xl font-semibold mb-6">Update Profile</h5>

            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" wire:model="name" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" placeholder="Masukkan Nama">
                @error('name')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" wire:model="email" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror" placeholder="Masukkan Email">
                @error('email')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                <input type="password" id="password" wire:model="password" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror" placeholder="Masukkan Kata Sandi Baru">
                @error('password')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('password_confirmation') border-red-500 @enderror" placeholder="Konfirmasi Kata Sandi">
                @error('password_confirmation')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 bg-custom-600 hover:bg-blue-600 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Simpan Perubahan</button>
        </div>
    </form>
</div>
