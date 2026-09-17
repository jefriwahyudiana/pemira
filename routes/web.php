<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\MenuVoteController;
    use App\Http\Controllers\PaslonController;
    use App\Http\Controllers\VoteController;
    use App\Http\Controllers\HasilVoteController;

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/menuvote/{prodi}', [MenuVoteController::class, 'show'])->name('menuvote');
    Route::get('/vote/{jenis_pemilihan}', [PaslonController::class, 'index'])->name('vote.show');
    Route::get('/hasilvote', [HasilVoteController::class, 'index'])->name('hasilvote');
    Route::get('/hasilvote/data', [HasilVoteController::class, 'data'])->name('hasilvote.data');
    Route::post('/vote/{npm}', [VoteController::class, 'addVote'])->name('vote.add');