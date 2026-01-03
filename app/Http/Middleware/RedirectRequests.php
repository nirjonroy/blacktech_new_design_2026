<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RedirectRequests
{
    public function handle(Request $request, Closure $next)
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $segments = $this->extractSegments($request);

        if ($this->shouldBypass($segments['path'])) {
            return $next($request);
        }

        $redirect = $this->matchRedirect($segments);

        if (! $redirect) {
            return $next($request);
        }

        $destination = trim($redirect->destination_url);

        if ($destination === '') {
            return $next($request);
        }

        $absoluteDestination = $this->absoluteDestination($destination, $request);

        if ($this->isSameRequest($absoluteDestination, $request)) {
            return $next($request);
        }

        $status = $redirect->http_code ?: 301;

        if (Str::startsWith($destination, ['http://', 'https://', '//'])) {
            return redirect()->away($absoluteDestination, $status);
        }

        return redirect()->to($destination, $status);
    }

    private function matchRedirect(array $segments): ?Redirect
    {
        $redirects = $this->activeRedirects();

        foreach ($redirects->where('match_type', 'exact') as $redirect) {
            if ($this->isExactMatch($redirect, $segments)) {
                return $redirect;
            }
        }

        $prefixRedirects = $redirects->where('match_type', 'prefix')
            ->sortByDesc(fn (Redirect $redirect) => Str::length($redirect->source_url));

        foreach ($prefixRedirects as $redirect) {
            if ($this->isPrefixMatch($redirect, $segments)) {
                return $redirect;
            }
        }

        return null;
    }

    private function activeRedirects(): Collection
    {
        return Cache::rememberForever(Redirect::CACHE_KEY, function () {
            return Redirect::where('is_active', true)->get();
        });
    }

    private function isExactMatch(Redirect $redirect, array $segments): bool
    {
        $source = $redirect->source_url;

        if ($redirect->is_case_sensitive) {
            return $source === $segments['full'] || $source === $segments['path'];
        }

        $source = Str::lower($source);
        return $source === $segments['full_lower'] || $source === $segments['path_lower'];
    }

    private function isPrefixMatch(Redirect $redirect, array $segments): bool
    {
        $source = $redirect->source_url;
        $path = $segments['path'];
        $pathLower = $segments['path_lower'];

        if ($redirect->is_case_sensitive) {
            return $source !== '/' && Str::startsWith($path, $source);
        }

        if ($source === '/') {
            return false;
        }

        return Str::startsWith($pathLower, Str::lower($source));
    }

    private function extractSegments(Request $request): array
    {
        $path = $this->normalizePath($request->path());
        $query = $request->getQueryString();
        $full = $query ? "{$path}?{$query}" : $path;

        return [
            'path' => $path,
            'path_lower' => Str::lower($path),
            'full' => $full,
            'full_lower' => Str::lower($full),
        ];
    }

    private function normalizePath(string $path): string
    {
        $path = '/' . ltrim($path, '/');

        return $path === '/' ? $path : rtrim($path, '/');
    }

    private function shouldBypass(string $path): bool
    {
        $segments = [
            '/admin',
            '/seller',
            '/vendor',
        ];

        foreach ($segments as $segment) {
            if (Str::startsWith(Str::lower($path), $segment)) {
                return true;
            }
        }

        return false;
    }

    private function absoluteDestination(string $destination, Request $request): string
    {
        if (Str::startsWith($destination, '//')) {
            return $request->getScheme() . ':' . $destination;
        }

        if (Str::startsWith($destination, ['http://', 'https://'])) {
            return $destination;
        }

        return url($destination);
    }

    private function isSameRequest(string $destination, Request $request): bool
    {
        $parsed = parse_url($destination);

        if ($parsed === false) {
            return false;
        }

        $destinationHost = $parsed['host'] ?? $request->getHost();
        $destinationPath = $this->normalizePath($parsed['path'] ?? '/');
        $destinationQuery = $parsed['query'] ?? null;

        $currentHost = $request->getHost();
        $currentPath = $this->normalizePath($request->path());
        $currentQuery = $request->getQueryString();

        if (strcasecmp($destinationHost, $currentHost) !== 0) {
            return false;
        }

        return $destinationPath === $currentPath && $destinationQuery === $currentQuery;
    }
}

