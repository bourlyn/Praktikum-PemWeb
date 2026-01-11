<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diskusi Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Forum Diskusi Laporan</h3>
                    <p class="mb-6 text-gray-600">Pilih laporan untuk memulai atau melihat diskusi.</p>

                    <div class="grid grid-cols-1 gap-4">
                        @forelse ($tickets as $ticket)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $ticket->title }}</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $ticket->category->name }} • {{ $ticket->created_at->diffForHumans() }}
                                    </p>
                                    @if(Auth::user()->is_admin)
                                        <p class="text-xs text-gray-400">Oleh: {{ $ticket->user->name }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <a href="{{ route('tickets.show', $ticket) }}#comments" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition flex items-center">
                                Buka Chat
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-10">
                            <p class="text-gray-500">Belum ada diskusi tersedia.</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
