<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        abort_if(
            ! config('services.google.client_id') || ! config('services.google.client_secret'),
            500,
            'Google OAuth is not configured. Set GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in your .env file.'
        );

        $query = http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => config('services.google.redirect'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'offline',
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?'.$query);
    }

    public function callback(Request $request): RedirectResponse
    {
        abort_if(
            ! config('services.google.client_id') || ! config('services.google.client_secret'),
            500,
            'Google OAuth is not configured. Set GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in your .env file.'
        );

        if ($request->missing('code')) {
            return redirect()->route('login')->withErrors(['google' => 'Google login failed or was cancelled.']);
        }

        try {
            $tokenResponse = Http::asForm()
                ->withOptions(['verify' => false])
                ->retry(2, 100, function (Throwable $exception) {
                    return true;
                })
                ->post('https://oauth2.googleapis.com/token', [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'code' => $request->input('code'),
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => config('services.google.redirect'),
                ]);
        } catch (Throwable $exception) {
            return redirect()->route('login')->withErrors([
                'google' => 'Unable to connect to Google. Check your internet connection or firewall settings.',
            ]);
        }

        if ($tokenResponse->failed()) {
            return redirect()->route('login')->withErrors([
                'google' => 'Unable to fetch Google access token. Please verify your Google credentials.',
            ]);
        }

        $tokenData = $tokenResponse->json();
        $accessToken = $tokenData['access_token'] ?? null;

        if (! $accessToken) {
            return redirect()->route('login')->withErrors([
                'google' => 'Google did not return an access token.',
            ]);
        }

        try {
            $userResponse = Http::withOptions(['verify' => false])
                ->withToken($accessToken)
                ->retry(2, 100, function (Throwable $exception) {
                    return true;
                })
                ->get('https://openidconnect.googleapis.com/v1/userinfo');
        } catch (Throwable $exception) {
            return redirect()->route('login')->withErrors([
                'google' => 'Unable to connect to Google user info. Check your network or firewall.',
            ]);
        }

        if ($userResponse->failed()) {
            return redirect()->route('login')->withErrors([
                'google' => 'Unable to fetch Google user info.',
            ]);
        }

        $googleUser = $userResponse->json();
        $email = $googleUser['email'] ?? null;
        $googleId = $googleUser['sub'] ?? null;

        abort_if(
            ! $googleId || ! $email,
            500,
            'Google did not return the required user information.'
        );

        $user = User::firstWhere('google_id', $googleId);

        if (! $user) {
            $user = User::firstWhere('email', $email);
        }

        if (! $user) {
            $user = User::create([
                'name' => $googleUser['name'] ?? $email,
                'email' => $email,
                'google_id' => $googleId,
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt(Str::random(24)),
            ]);

            event(new Registered($user));
        } elseif (! $user->google_id) {
            $user->forceFill(['google_id' => $googleId])->save();
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
