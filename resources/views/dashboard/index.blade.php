<!-- resources/views/dashboard/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-3xl font-bold">Traffic Monitoring System</h2>
        <a href="{{ route('cameras.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            + Tambah CCTV
        </a>
    </div>

    <!-- Grid CCTV Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($cameras as $camera)
        <a href="{{ route('dashboard.show', $camera) }}" class="block">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                <!-- Thumbnail -->
                <div class="relative bg-gray-900 h-48 flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3 flex items-center bg-green-500 text-white text-xs px-3 py-1 rounded-full">
                        <span class="h-2 w-2 bg-white rounded-full mr-2 animate-pulse"></span>
                        ACTIVE
                    </div>
                    
                    <!-- Lanes Badge -->
                    <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-semibold">
                        {{ $camera->lanes }} {{ $camera->lanes > 1 ? 'LANES' : 'LANE' }}
                    </div>
                </div>

                <!-- Info -->
                <div class="p-5">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $camera->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $camera->location ?? 'Unknown Location' }}
                    </p>

                    <!-- Latest Count -->
                    @if($camera->latestAnalytic)
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 text-sm font-medium">Total Kendaraan</span>
                            <span class="text-3xl font-bold text-blue-600">{{ $camera->latestAnalytic->total }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $camera->latestAnalytic->timestamp->diffForHumans() }}
                        </p>
                    </div>
                    @else
                    <div class="bg-gray-100 rounded-lg p-4 text-center">
                        <p class="text-gray-500 text-sm">Belum ada data</p>
                    </div>
                    @endif

                    <!-- View Detail Button -->
                    <div class="mt-4 text-center">
                        <span class="text-blue-600 text-sm font-semibold">
                            Lihat Detail & Live Video →
                        </span>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada CCTV</h3>
            <p class="mt-2 text-sm text-gray-500">Mulai dengan menambahkan CCTV pertama Anda</p>
            <div class="mt-6">
                <a href="{{ route('cameras.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    + Tambah CCTV
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection