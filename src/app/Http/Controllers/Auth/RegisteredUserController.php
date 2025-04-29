<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // フォームから送られたデータをバリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birth_year' => ['nullable', 'integer', 'between:1900,' . now()->year],
            'birth_month' => ['nullable', 'integer', 'between:1,12'],
            'birth_day' => ['nullable', 'integer', 'between:1,31'],
            'gender' => ['nullable', 'in:male,female,other'],
        ]);

        // 年・月・日から、生年月日（birth_date）組み立て
        $birthDate = null;
        if ($request->filled(['birth_year', 'birth_month', 'birth_day'])) {
            $birthDate = \Carbon\Carbon::createFromDate(
                $request->birth_year,
                $request->birth_month,
                $request->birth_day
            );
        }

        // 新しいユーザーをデータベースに作成する
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender ?? null,
            'birth_date' => $birthDate,
            'age' => $birthDate ? $birthDate->age : null,
        ]);

        // ここに処理追加で、認証メール送ったり、ログ記録、通知送付、などできる　後にやろうかな
        event(new Registered($user));

        // ログイン状態にする
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
