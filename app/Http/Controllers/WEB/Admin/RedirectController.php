<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RedirectController extends Controller
{
    private const HTTP_CODES = [301, 302, 307, 410, 451];

    public function index()
    {
        $redirects = Redirect::orderByDesc('created_at')->get();

        return view('admin.redirect', [
            'redirects' => $redirects,
            'matchTypes' => $this->matchTypeOptions(),
            'httpCodes' => self::HTTP_CODES,
        ]);
    }

    public function create()
    {
        return view('admin.create_redirect', [
            'matchTypes' => $this->matchTypeOptions(),
            'httpCodes' => self::HTTP_CODES,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'source_urls' => ['required', 'array', 'min:1'],
            'source_urls.*' => ['required', 'string', 'max:2048'],
            'match_types' => ['required', 'array'],
            'match_types.*' => ['required', Rule::in(array_keys($this->matchTypeOptions()))],
            'destination_url' => ['required', 'string', 'max:2048'],
            'http_code' => ['required', Rule::in(self::HTTP_CODES)],
            'status' => ['required', 'boolean'],
            'ignore_case' => ['nullable', 'boolean'],
        ];

        $customMessages = [
            'source_urls.required' => trans('admin_validation.Source url is required'),
            'source_urls.*.required' => trans('admin_validation.Source url is required'),
            'destination_url.required' => trans('admin_validation.Destination url is required'),
        ];

        $validated = $request->validate($rules, $customMessages);

        $caseSensitive = !$request->boolean('ignore_case');
        $destination = $this->prepareDestinationUrl($validated['destination_url']);
        $httpCode = (int) $validated['http_code'];
        $isActive = $request->boolean('status');

        $created = 0;
        $updated = 0;

        foreach ($validated['source_urls'] as $index => $sourceUrl) {
            $matchType = Arr::get($validated['match_types'], $index, 'exact');
            $normalizedSource = $this->normalizeSourceUrl($sourceUrl, $caseSensitive);

            $redirect = $this->findExistingRedirect($normalizedSource, $matchType, $caseSensitive);

            if ($redirect) {
                $redirect->update([
                    'destination_url' => $destination,
                    'http_code' => $httpCode,
                    'is_active' => $isActive,
                ]);
                $updated++;
            } else {
                Redirect::create([
                    'source_url' => $normalizedSource,
                    'match_type' => $matchType,
                    'is_case_sensitive' => $caseSensitive,
                    'destination_url' => $destination,
                    'http_code' => $httpCode,
                    'is_active' => $isActive,
                ]);
                $created++;
            }
        }

        $messageKey = $created && !$updated
            ? 'Created Successfully'
            : ($updated && !$created ? 'Update Successfully' : 'Saved Successfully');

        $notification = trans('admin_validation.' . $messageKey);
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.redirect.index')->with($notification);
    }

    public function edit(Redirect $redirect)
    {
        return view('admin.edit_redirect', [
            'redirect' => $redirect,
            'matchTypes' => $this->matchTypeOptions(),
            'httpCodes' => self::HTTP_CODES,
        ]);
    }

    public function update(Request $request, Redirect $redirect)
    {
        $rules = [
            'source_url' => ['required', 'string', 'max:2048'],
            'match_type' => ['required', Rule::in(array_keys($this->matchTypeOptions()))],
            'destination_url' => ['required', 'string', 'max:2048'],
            'http_code' => ['required', Rule::in(self::HTTP_CODES)],
            'status' => ['required', 'boolean'],
            'ignore_case' => ['nullable', 'boolean'],
        ];

        $customMessages = [
            'source_url.required' => trans('admin_validation.Source url is required'),
            'destination_url.required' => trans('admin_validation.Destination url is required'),
        ];

        $validated = $request->validate($rules, $customMessages);

        $caseSensitive = !$request->boolean('ignore_case');

        $normalizedSource = $this->normalizeSourceUrl($validated['source_url'], $caseSensitive);

        $duplicateQuery = Redirect::where('id', '!=', $redirect->id)
            ->where('match_type', $validated['match_type'])
            ->where('is_case_sensitive', $caseSensitive);

        if ($caseSensitive) {
            $duplicateQuery->whereRaw('BINARY source_url = ?', [$normalizedSource]);
        } else {
            $duplicateQuery->where('source_url', $normalizedSource);
        }

        $duplicate = $duplicateQuery->exists();

        if ($duplicate) {
            return back()->withErrors([
                'source_url' => trans('admin_validation.Source url already exists'),
            ])->withInput();
        }

        $redirect->fill([
            'source_url' => $normalizedSource,
            'match_type' => $validated['match_type'],
            'is_case_sensitive' => $caseSensitive,
            'destination_url' => $this->prepareDestinationUrl($validated['destination_url']),
            'http_code' => (int) $validated['http_code'],
            'is_active' => $request->boolean('status'),
        ]);

        $redirect->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.redirect.index')->with($notification);
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function changeStatus(Redirect $redirect)
    {
        $redirect->is_active = ! $redirect->is_active;
        $redirect->save();

        $message = $redirect->is_active
            ? trans('admin_validation.Active Successfully')
            : trans('admin_validation.Inactive Successfully');

        return response()->json($message);
    }

    private function matchTypeOptions(): array
    {
        return [
            'exact' => trans('admin.Exact Match'),
            'prefix' => trans('admin.Starts With'),
        ];
    }

    private function normalizeSourceUrl(string $value, bool $caseSensitive): string
    {
        $value = trim($value);

        $parsed = parse_url($value);

        if ($parsed === false) {
            $value = $value === '' ? '/' : $value;
        } else {
            $path = Arr::get($parsed, 'path', '/');
            $path = '/' . ltrim($path, '/');
            $path = $path === '/' ? $path : rtrim($path, '/');

            $query = Arr::get($parsed, 'query');
            $value = $query ? "{$path}?{$query}" : $path;
        }

        if (! Str::startsWith($value, '/')) {
            $value = '/' . ltrim($value, '/');
        }

        return $caseSensitive ? $value : Str::lower($value);
    }

    private function prepareDestinationUrl(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return '/';
        }

        if (Str::startsWith($value, ['http://', 'https://', '//'])) {
            return $value;
        }

        return '/' . ltrim($value, '/');
    }

    private function findExistingRedirect(string $source, string $matchType, bool $caseSensitive): ?Redirect
    {
        $query = Redirect::where('match_type', $matchType)
            ->where('is_case_sensitive', $caseSensitive);

        if ($caseSensitive) {
            $query->whereRaw('BINARY source_url = ?', [$source]);
        } else {
            $query->where('source_url', $source);
        }

        return $query->first();
    }
}
