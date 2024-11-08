<?php

namespace App\Filament\Auth;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

class PanelLogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('landing-page.index');
    }
}
