<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ExceptionTransaction
{
    public static function walletDoesNotBelongToLoggedUser()
    {
        return BuildException::new()
            ->setMessage(trans('exception.wallet_does_not_belong_to_logged_user'))
            ->setHttpCode(Response::HTTP_UNAUTHORIZED);
    }

    public static function valueGreaterThanAvailableValueInWallet()
    {
        return BuildException::new()
            ->setMessage(trans('exception.value_greater_than_available_value_in_wallet'))
            ->setHttpCode(Response::HTTP_UNAUTHORIZED);
    }
}