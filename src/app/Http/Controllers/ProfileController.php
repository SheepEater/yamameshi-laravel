<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
    
        // バリデーション済みデータ　からbirth_year, birth_month, birth_dayを除外
        $data = $request->safe()->except(['birth_year', 'birth_month', 'birth_day']);
    
        // 生年月日のプルダウン
        $year = $request->input('birth_year');
        $month = $request->input('birth_month');
        $day = $request->input('birth_day');
    
        if ($year && $month && $day) {
            $birthDate = \Carbon\Carbon::createFromDate($year, $month, $day);
            $data['birth_date'] = $birthDate;
            $data['age'] = $birthDate->age;
        }
    
        // アイコンアップロード処理
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $data['icon_path'] = $path;
    
            // （任意）古いアイコン削除
            // if ($user->icon_path) {
            //     Storage::disk('public')->delete($user->icon_path);
            // }
        }
    
        // メール変更されたら認証リセット
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $user->email_verified_at = null;
        }
    
        // データ更新
        $user->fill($data)->save();
    
        // セッション情報更新
        Auth::login($user);
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
