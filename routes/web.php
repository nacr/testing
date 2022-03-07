<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    $user = \App\Models\User::with('skills')->find(1);

    $pivotIds = new \Illuminate\Support\Collection();

    $user->skills->each(function ($skill) use ($pivotIds, $user) {
        $pivotIds->push($skill->pivot->id);
    });

    $recommendations = \App\Models\Recommendation::whereIn('skill_user_id', $pivotIds)->get();

    $user->skills->each(function ($skill) use ($user, $recommendations) {
        $toAdd = [];
        $recommendations->each(function ($recommendation) use ($user, $skill, &$toAdd) {

            if($recommendation->skill_user_id === $skill->pivot->id) {
                $toAdd[] = $recommendation;
            }
        });

        $skill['recommendations'] = $toAdd;
    });



    return view('welcome', compact('user'));
});
