<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ApplyTabScopedAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $tabId = $this->tabId($request);

        if (! $tabId) {
            return $next($request);
        }

        URL::defaults(['_tab' => $tabId]);

        $sessionKey = "tab_auth.{$tabId}";
        $userId = $request->session()->get($sessionKey);

        if (! $userId) {
            Auth::guard('web')->logout();

            if (! $this->isGuestPath($request)) {
                return redirect()->route('login', ['_tab' => $tabId]);
            }

            return $next($request);
        }

        $user = User::where('id_user', $userId)->first();

        if (! $user) {
            $request->session()->forget($sessionKey);
            Auth::guard('web')->logout();

            if (! $this->isGuestPath($request)) {
                return redirect()->route('login', ['_tab' => $tabId]);
            }

            return $next($request);
        }

        Auth::guard('web')->setUser($user);

        return $this->withTabRedirect($next($request), $request, $tabId);
    }

    private function tabId(Request $request): ?string
    {
        $tabId = $request->input('_tab') ?? $request->query('_tab');

        if (! is_string($tabId) || ! preg_match('/^[A-Za-z0-9_-]{8,80}$/', $tabId)) {
            return null;
        }

        return $tabId;
    }

    private function withTabRedirect(Response $response, Request $request, string $tabId): Response
    {
        if (! $response->isRedirect()) {
            return $response;
        }

        $location = $response->headers->get('Location');

        if (! $location || preg_match('/[?&]_tab=/', $location)) {
            return $response;
        }

        if (str_starts_with($location, 'http')) {
            $host = parse_url($location, PHP_URL_HOST);

            if ($host !== $request->getHost()) {
                return $response;
            }
        }

        $hash = '';
        $base = $location;

        if (str_contains($location, '#')) {
            [$base, $hash] = explode('#', $location, 2);
            $hash = '#' . $hash;
        }

        $separator = str_contains($base, '?') ? '&' : '?';
        $response->headers->set('Location', $base . $separator . '_tab=' . rawurlencode($tabId) . $hash);

        return $response;
    }

    private function isGuestPath(Request $request): bool
    {
        return $request->is('/')
            || $request->is('login')
            || $request->is('register')
            || $request->is('forgot-password')
            || $request->is('reset-password*');
    }
}
