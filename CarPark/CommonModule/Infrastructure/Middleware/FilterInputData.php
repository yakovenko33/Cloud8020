<?php

namespace CarPark\CommonModule\Infrastructure\Middleware;


use Illuminate\Http\Request;
use Closure;

class FilterInputData
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = [];
        foreach ($request->all() as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }
        $request->merge($data);

        return $next($request);
    }
}
