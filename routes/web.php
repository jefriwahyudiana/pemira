<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\MenuVoteController;
    use App\Http\Controllers\PaslonController;
    use App\Http\Controllers\VoteController;
    use App\Http\Controllers\HasilHimaController;
    use App\Livewire\PresmaLiveChart; 

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Cache cleared!';
});

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/', function () {
        return 'Laravel Ok';
    })->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/menuvote/{prodi}', [MenuVoteController::class, 'show'])->name('menuvote');
    Route::get('/vote/{jenis_pemilihan}', [PaslonController::class, 'index'])->name('vote.show');
    Route::get('/hasilvote', PresmaLiveChart::class);
    Route::post('/vote/{npm}', [VoteController::class, 'addVote'])->name('vote.add');
    Route::get('/hasil_hima', [HasilHimaController::class, 'index'])->name('hasil_hima');