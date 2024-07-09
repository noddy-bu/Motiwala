<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'backend/trumbowyg/upload',
        'forgot-password/verify-forgot-otp',
        'forgot-password/reset-password',
        'payment-cancel',
        'payment-success',
        'payment-success-installment',
        'payment-cancel-installment',
        '/webhook_pum_success',
        '/webhook_pum_fail'
    ];
}
