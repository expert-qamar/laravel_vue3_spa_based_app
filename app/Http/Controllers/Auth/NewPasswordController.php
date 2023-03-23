<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordSetRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\PasswordHistory;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

class NewPasswordController extends Controller
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(Request $request): Factory|View|Application
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(PasswordSetRequest $request): JsonResponse|RedirectResponse
    {
        Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $this->resetPassword($user, $request->password);
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                //store password in password History start
                $get_all_history = PasswordHistory::where('user_id', $user->id)->count();
                if (($get_all_history) < 3) {
                    PasswordHistoryCreate($user->id, $request->password);
                } elseif (($get_all_history) >= 3) {
                    $is_deleted = PasswordHistory::where('user_id', $user->id)->first()->delete();
                    if ($is_deleted) {
                        PasswordHistoryCreate($user->id, $request->password);
                    }
                }

                //store password in password History end
                event(new PasswordReset($user));
                Auth::login($user);
            }
        );
        $Columns = [
            'id',
            'name',
            'email',
            'unique_identification',
            'health_board_id',
            'is_active',
            'is_question_disable',
            'is_clinc_scr_up',
            'created_by',
            'updated_by'
        ];
        if (!empty($request->user()?->id)) {
            return response()->json(['success'=>true, 'data'=> new UserResource($request->user())]);
        }

        throw ValidationException::withMessages([
            'password' => ['Your link has expired.'],
        ]);
    }

    protected function resetPassword($user, $password)
    {
        $passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
        foreach ($passwordHistories as $passwordHistory) {
            if (Hash::check($password, $passwordHistory->password)) {
                throw ValidationException::withMessages([
                    'password' => ['Your new password can not be same as any of your recent passwords. Please choose a new password'],
                ]);
            }
        }
    }

    public function update(PasswordSetRequest $request): JsonResponse|RedirectResponse
    {
        if (! Hash::check($request->current_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The old password did not matched with current password'],
            ]);
        }

        $user = Auth::user();
        $passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
        foreach ($passwordHistories as $passwordHistory) {
            if (Hash::check($request->get('password'), $passwordHistory->password)) {
                throw ValidationException::withMessages([
                    'password' => ['Your new password can not be same as any of your recent passwords. Please choose a new password'],
                ]);
            }
        }
        $request->user()->update([
            'password' => Hash::make($request->password),
            'is_pass_up' => 0,
            'password_changed_at' => Carbon::now()->toDateTimeString(),
        ]);
        $user_id = Auth::user()->id;
        $get_all_history = PasswordHistory::where('user_id', $user_id)->count();
        if (($get_all_history) < 3) {
            PasswordHistoryCreate($user_id, $request->password);
        } elseif (($get_all_history) >= 3) {
            $is_deleted = PasswordHistory::where('user_id', $user_id)->first()->delete();
            if ($is_deleted) {
                PasswordHistoryCreate($user_id, $request->password);
            }
        }
        return response()->success(true);
    }
}
