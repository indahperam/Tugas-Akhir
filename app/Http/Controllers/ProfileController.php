<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', new MatchOldPassword],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function theme(Request $request)
    {
        $user = auth()->user()->id;
        $user = User::find($user);
        $user->update([
            'theme' => ($request->theme ? 'winter' : 'night')
        ]);
    }
    public function foto(Request $request)
    {
        $perusahaan = auth()->user();
        $foto = $request->foto;
        $nama_foto = strtotime(date('ymdHis')) . '.' . $foto->extension();
        $foto->move(public_path('img'), $nama_foto);
        if ($perusahaan->foto != 'asset/profil.png') {
            if (file_exists(public_path($perusahaan->foto))) {
                File::delete(public_path($perusahaan->foto));
            };
        }
        $perusahaan->foto = 'img/' . $nama_foto;
        $perusahaan->update();
    }
}
