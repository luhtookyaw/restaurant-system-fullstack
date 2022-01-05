<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

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
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'updated' => $request->session()->get('updated'),
                'deleted' => $request->session()->get('deleted'),
                'orders' => $request->session()->get('orders'),
                'approved' => $request->session()->get('approved'),
                'cancel' => $request->session()->get('cancel'),
                'ready' => $request->session()->get('ready'),
                'served' => $request->session()->get('served')
            ]
        ]);
    }
}
