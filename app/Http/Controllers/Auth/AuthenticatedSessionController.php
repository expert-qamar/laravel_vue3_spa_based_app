<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Notifications\TwoFactorCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\{ Request ,RedirectResponse, JsonResponse };
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Redirector;

class AuthenticatedSessionController extends Controller
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): UserResource|RedirectResponse
    {
        if ($request->wantsJson()) {
            $selectColumn = ['id', 'name', 'email'];
            $user_get = $this->userRepository->findById($request->user()->id, $selectColumn);

            return new UserResource($user_get);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function create(): Factory|View|Application
    {
        return view('auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        if ($request->wantsJson()) {
            return response()->json(['success'=>true,'data'=> new UserResource($request->user())]);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request): Redirector|Application|RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
