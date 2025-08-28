<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocalization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language') ?? $request->query('lang', config('organogram.available_locales'));

        $availableLocales = config('organogram.available_locales', [config('organogram.locale')]);

        if (in_array($locale, $availableLocales)) {

            app()->setLocale($locale);
        }

        return $next($request);
    }
}