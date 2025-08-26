<?php

use App\Http\Controllers\api\UnitTest;
use Illuminate\Support\Facades\Route;

Route::post('/dailyBackup-chart', [UnitTest::class, 'chartDailyBackup']);

