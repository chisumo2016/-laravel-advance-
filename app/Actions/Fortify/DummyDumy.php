<?php

namespace App\Actions\Fortify;

class DummyDumy
{
    public function __invoke(\Request $request, $next)
    {
        dump("");
       // $next($request);
    }
}
