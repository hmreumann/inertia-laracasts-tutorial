<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Home');
});

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy']);

Route::middleware(['auth'])->group(function () {
    Route::get('/users', function () {
        return Inertia::render('Users/Index', [
            'users' => User::query()
                ->select('id', 'name', 'email')
                ->when(request('search'), fn ($builder, $search) => $builder->where('name', 'like', '%' . $search . '%'))
                ->paginate(15)
                ->withQUeryString(),
            'filters' => Request::only('search'),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class),
            ]
        ]);
    })->name('users-index');

    Route::get('users/create', function () {
        return Inertia::render('Users/Create');
    })->can('create', User::class);

    Route::post('users', function () {
        $validated = Request::validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        User::create($validated);

        return redirect('/users');
    });

    Route::get('user/{user}/edit', function (User $user) {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    });

    Route::put('user/{user}', function (User $user) {
        $validated = Request::validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $user->update($validated);

        return redirect()->route('users-index');
    });

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });
});
