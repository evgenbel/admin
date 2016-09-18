<?php namespace SleepingOwl\Admin\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use SleepingOwl\Admin\Admin;
use Request;

class Authenticate
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if (Sentinel::guest()) return redirect(route('admin.login'));
        if(Sentinel::inRole('admin')) return $next($request);
        return Redirect::back();
        /*
		if (AdminAuth::guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			} else
			{
				return redirect()->guest(route('admin.login'));
			}
		}

		return $next($request);*/
	}

}
