<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Paslon;

class PresmaLiveChart extends Component
{
    public $totalVote;

    public function mount()
    {
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.presma-live-chart')
            ->extends('layouts.app')
            ->section('livechart');
    }

    #[On('ubahData')]
    public function changeData()
    {
        $this->loadData();
        $this->dispatch('berhasilUpdate', data: $this->totalVote);
    }

    private function loadData()
    {
        $totalPemilih = 3458; // Total pemilih terdaftar
        $totalVote = Paslon::where('jenis_pemilihan', 'presma')->get();
        $jumlahSuaraMasuk = $totalVote->sum('total_vote');
        $jumlahSuaraTidakVoting = $totalPemilih - $jumlahSuaraMasuk; // Menghitung suara tidak voting

        $data = [
            'data' => $totalVote->pluck('total_vote')->map(fn($vote) => (int) $vote)->toArray(),
            'total' => $jumlahSuaraMasuk,
            'tidak_voting' => $jumlahSuaraTidakVoting
        ];
        $this->totalVote = json_encode($data);
    }
}
