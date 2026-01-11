<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                         <h3 class="font-semibold text-lg">Daftar Laporan</h3>
                         <a href="{{ route('tickets.create') }}" class="text-sm bg-gray-800 text-white py-2 px-4 rounded hover:bg-gray-700 transition">
                            + Buat Laporan
                        </a>
                    </div>
                   
                   <!-- Table -->
                   <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Judul</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Lokasi</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeColor = match($ticket->status) {
                                                'pending' => 'bg-red-100 text-red-800',
                                                'in_progress' => 'bg-yellow-100 text-yellow-800',
                                                'resolved' => 'bg-green-100 text-green-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span class="{{ $badgeColor }} text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                                        {{ $ticket->title }}
                                    </th>
                                    <td class="px-6 py-4">{{ $ticket->category->name }}</td>
                                    <td class="px-6 py-4">{{ $ticket->location }}</td>
                                    <td class="px-6 py-4">{{ $ticket->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="font-medium text-blue-600 hover:underline">Lihat</a>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white border-b">
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada laporan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
