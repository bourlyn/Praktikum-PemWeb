<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lapor Pak! - Buat Laporan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Judul -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Judul Keluhan</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" name="title" type="text" placeholder="Contoh: AC Mati di Lab 1" value="{{ old('title') }}" required>
                            @error('title') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">Kategori Divisi</label>
                            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category_id" name="category_id" required>
                                <option value="">Pilih Divisi</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id') == $category->id || request('category_id') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">Lokasi</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="location" name="location" type="text" placeholder="Contoh: Gedung A, Lantai 2" value="{{ old('location') }}" required>
                            @error('location') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                         <!-- Diskripsi -->
                         <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Deskripsi Detail</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="4" placeholder="Jelaskan keluhan anda..." required>{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Foto Bukti -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Bukti Foto (Max 2MB, JPG/PNG)</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="image" type="file" accept="image/png, image/jpeg" required>
                            @error('image') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between">
                             <a href="{{ route('tickets.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-bold">
                                Batalkan
                            </a>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Kirim Laporan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
