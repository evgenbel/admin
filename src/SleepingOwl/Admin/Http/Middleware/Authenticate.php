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
        if (Sentinel::guest()) return redirect('login');
        if(Sentinel::inRole('admin')) return $next($request);

        $arrSlugs=str_getcsv($request->path(), '/');
        $method=Request::method();
        $user = Sentinel::check();
        if($method == 'DELETE')
        {
            $permit = $arrSlugs[0] . '.' . $arrSlugs[1] . '.delete';
            if ($user->hasAccess([$permit])) return $next($request);
            if ($user->hasAccess(['admin']))
            {
                $content = trans('admin::lang.permission.wrong-delete');
                return Response::make(Admin::view($content, trans('admin::lang.permission.deny')), 403);
            }
            return Redirect::back();
        }
        $permit=$arrSlugs[0];
        if(isset($arrSlugs[1])) $permit = $permit . '.' . $arrSlugs[1];
        if(isset($arrSlugs[2]) && ($arrSlugs[2] == "create")) $permit = $permit . '.' . $arrSlugs[2];
        if(isset($arrSlugs[3])) $permit = $permit . '.' . $arrSlugs[3];
        if ($user->hasAccess([$permit])) return $next($request);
        if ($user->hasAccess(['admin']))
        {
            $content = trans('admin::lang.permission.wrong');
            return Response::make(Admin::view($content, trans('admin::lang.permission.deny')), 403);

        }
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
