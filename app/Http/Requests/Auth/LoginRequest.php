<?php

namespace App\Http\Requests\Auth;

use App\Models\Dosen;
use App\Models\Tpa;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_institusi' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $validated = $this->validated();
        Log::info('Login attempt', ['email' => $validated['email_institusi']]);

        // Try to find the user first
        $user = \App\Models\User::where('email_institusi', $validated['email_institusi'])->first();
        // dd($user);
        if (!$user) {
            // dd($validated,'ini');
            Log::error('User not found', ['email' => $validated['email_institusi']]);
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email_institusi' => trans('auth.failed'),
            ]);
        }
        Log::info('Found user', ['id' => $user->id]);
        // dd(Auth::attempt($validated, false),$validated);
        if (!Auth::attempt($validated, false)) {
            Log::error('Password verification failed', ['email' => $validated['email_institusi']]);
            // dd('mausk sini');
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email_institusi' => trans('auth.failed'),
            ]);
        }
        // dd('mausk sini 2');

        Log::info('Authentication successful', ['user_id' => $user->id]);

        // Set user role in session after successful authentication
        if ($user = Auth::user()) {
            $role = Tpa::where('users_id', $user->id)->exists() ? 'TPA' : 'Dosen';
            session(['account' => array_merge($user->toArray(), ['role' => [$role]])]);
            Log::info('Session data set', [
                'user_id' => $user->id,
                'role' => $role,
                'session_id' => session()->getId()
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email_institusi' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $email = $this->validated()['email_institusi'];
        return Str::transliterate(Str::lower($email) . '|' . request()->ip());
    }
}
