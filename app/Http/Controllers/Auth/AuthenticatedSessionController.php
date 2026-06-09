<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $tabId = $this->tabId($request);

        if ($tabId) {
            $request->session()->put("tab_auth.{$tabId}", Auth::id());

            $redirect = redirect()->intended(route('dashboard', absolute: false));

            return redirect()->to($this->urlWithTab($redirect->getTargetUrl(), $tabId));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $tabId = $this->tabId($request);

        if ($tabId) {
            $request->session()->forget("tab_auth.{$tabId}");
            Auth::guard('web')->logout();
            $request->session()->regenerateToken();

            return redirect()->route('login', ['_tab' => $tabId]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function tabId(Request $request): ?string
    {
        $tabId = $request->input('_tab') ?? $request->query('_tab');

        if (! is_string($tabId) || ! preg_match('/^[A-Za-z0-9_-]{8,80}$/', $tabId)) {
            return null;
        }

        return $tabId;
    }

    private function urlWithTab(string $url, string $tabId): string
    {
        $separator = str_contains($url, '?') ? '&' : '?';

        return $url . $separator . '_tab=' . rawurlencode($tabId);
    }
}
