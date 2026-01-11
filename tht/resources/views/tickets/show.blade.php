<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lapor Pak! - Detail Laporan') }}: #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Kiri: Detail Tiket -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                             <h3 class="text-2xl font-bold mb-2">{{ $ticket->title }}</h3>
                             <div class="flex items-center gap-2 mb-4 text-sm text-gray-500">
                                <span>{{ $ticket->created_at->format('d M Y H:i') }}</span>
                                <span>&bull;</span>
                                <span>{{ $ticket->category->name }}</span>
                                <span>&bull;</span>
                                <span>{{ $ticket->user->name }}</span>
                             </div>

                             <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h4 class="font-semibold mb-1">Lokasi:</h4>
                                <p class="text-gray-700">{{ $ticket->location }}</p>
                             </div>

                             <div class="mb-4">
                                <h4 class="font-semibold mb-2">Deskripsi:</h4>
                                <p class="whitespace-pre-wrap">{{ $ticket->description }}</p>
                             </div>

                             @if($ticket->image_path)
                             <div class="mb-4">
                                <h4 class="font-semibold mb-2">Bukti Foto:</h4>
                                <img src="{{ asset('storage/' . $ticket->image_path) }}" alt="Bukti Laporan" class="w-full max-w-lg rounded shadow">
                             </div>
                             @endif
                        </div>
                    </div>

                    <!-- Komentar -->
                     <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4">Diskusi / Komentar</h3>
                            
                            <!-- List Komentar -->
                            <div class="space-y-4 mb-6">
                                @forelse($ticket->comments as $comment)
                                    <div class="border-b pb-4">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold {{ $comment->user->is_admin ? 'text-red-600' : 'text-blue-600' }}">
                                                {{ $comment->user->name }} {{ $comment->user->is_admin ? '(Admin)' : '' }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700">{{ $comment->message }}</p>
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">Belum ada diskusi.</p>
                                @endforelse
                            </div>

                            <!-- Form Komentar -->
                            <form action="{{ route('comments.store', $ticket) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="message" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tulis komentar..." required></textarea>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-1 px-4 rounded text-sm">
                                        Kirim Balasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Status & Sidebar -->
                <div class="md:col-span-1">
                     <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="font-bold mb-4 text-gray-700">Status Laporan</h4>
                            
                            <div class="mb-6">
                                @php
                                    $badgeColor = match($ticket->status) {
                                        'pending' => 'bg-red-100 text-red-800 border-red-200',
                                        'in_progress' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'resolved' => 'bg-green-100 text-green-800 border-green-200',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <div class="flex justify-center">
                                    <span class="{{ $badgeColor }} text-lg font-medium px-4 py-2 rounded-full border">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </div>
                            </div>

                            @if(Auth::user()->is_admin)
                            <hr class="my-4 border-gray-200">
                            <h4 class="font-bold mb-2 text-sm text-gray-700">Update Status (Admin)</h4>
                            <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <select name="status" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded text-sm">
                                    Update Status
                                </button>
                            </form>
                            @endif

                            <div class="mt-6 text-center">
                                <a href="{{ route('tickets.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">Kembali ke Daftar</a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
