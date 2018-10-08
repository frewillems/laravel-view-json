<?php

namespace FreWillems\ViewJson;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class ViewJsonMiddleware
{
	private $debugBar;

	public function __construct()
	{
		// Play nice with Barry's Debug Bar
		if ($this->hasDebugBar()) {
			$this->debugBar = App::make('Barryvdh\Debugbar\LaravelDebugbar');
			$this->debugBar->disable();
		}
	}

	public function handle(Request $request, Closure $next, $guard = null)
	{
		if (config('app.debug') && $request->exists('view') && $request->get('view') === 'json') {
			return $this->viewJson($request, $next);
		}

        if ($this->hasDebugBar()) {
            $this->debugBar->enable();
        }

		return $next($request);
	}

	private function viewJson(Request $request, Closure $next)
	{
		$response = $next($request);

		if (!$this->shouldConvertToJson($response)) {
			// Enable Debug Bar again since we won't output any json
			if ($this->hasDebugBar()) {
				$this->debugBar->enable();
			}

			return $next($request);
		}

		$original = $response->getOriginalContent();
		$shared = $original->getFactory()->getShared();

		return response()->json(array_merge($original->getData(), $shared));
	}

	private function shouldConvertToJson(Response $response)
	{
		if ($response instanceof JsonResponse) {
			return false;
		}

		if ($response->isServerError() || $response->isNotFound()) {
			return false;
		}

		if ($response->isSuccessful() && !method_exists($response->getOriginalContent(), 'getData')) {
			return false;
		}

		return true;
	}

	private function hasDebugBar()
    {
        return class_exists('Barryvdh\Debugbar\LaravelDebugbar');
    }
}
