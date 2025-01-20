<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Language {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale');
        if (isset($locale)) {
            if($locale == 'ar_SA') {
                setDirection('rtl');
            } else {
                setDirection('ltr');
            }
            App::setLocale(Session::get('locale'));


        }
        return $next($request);
    }

}