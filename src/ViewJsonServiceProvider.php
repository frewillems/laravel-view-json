<?php

namespace FreWillems\ViewJson;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ViewJsonServiceProvider extends ServiceProvider
{
	public function boot(Router $router)
	{
		$router->pushMiddlewareToGroup('web', ViewJsonMiddleware::class);
	}
}
