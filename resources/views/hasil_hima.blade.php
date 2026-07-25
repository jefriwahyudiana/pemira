@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8" style="margin-bottom: 20px;">
    <h2 class="text-3xl font-bold py-6 text-center"><span class="text-blue-900">HASIL </span><span class="text-orange-500">HIMA</span></h2>
    
    @foreach ($himas as $hima => $paslons)
    <div class="mb-16"> <!-- Adjusted margin-bottom for spacing -->
        <h3 class="text-2xl font-semibold mb-4 mt-6 text-center">{{ strtoupper($hima) }}</h3>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">No Urut</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nama Ketua</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nama Wakil</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Total Vote</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($paslons as $key => $paslon)
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-4 text-center">{{ $paslon->paslon_ke }}</td>
                        <td class="py-3 px-4 text-center">{{ $paslon->nm_ketua }}</td>
                        <td class="py-3 px-4 text-center">{{ $paslon->nm_wakil }}</td>
                        <td class="py-3 px-4 text-center">{{ $paslon->total_vote }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection
