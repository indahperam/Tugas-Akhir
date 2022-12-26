<?php

namespace App\Http\Middleware;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        $user = auth()->user();
        $perusahaan = $user ? ($user->perusahaan = $user->perusahaan()) : null;
        $perusahaan = $perusahaan ? ($user->perusahaan ? $user->perusahaan : null) : null;
        if ($perusahaan) {
            $perusahaan->logo = url($perusahaan->logo);
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'user_aktif' => [
                'id' => $user ? $user->id : 0,
                'nama' => $user ? $user->name : '',
                'email' => $user ? $user->email : '',
                'foto' => $user ? url($user->foto) : '',
                'perusahaan' => $user ? $perusahaan : '',
                'logo' => asset('asset/logo.png'),
                'theme' => $user ? $user->theme : 'night',
                'satu_perusahaan' => Perusahaan::count() < 1
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
