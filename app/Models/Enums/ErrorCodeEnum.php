<?php

namespace App\Models\Enums;

enum ErrorCodeEnum: int
{
    use EnumToArray;
    case UserUndefined = 400;
    case InvalidToken = 401;
    case BannedPermanent = 402;
    case RateLimitingLogin = 403;
    case NotFound = 404;
    case TokenExpired = 405;
    case RefreshTokenExpired = 406;
    case NoSuccessSection = 407;
    case NoSuccess = 408;
    case WrongPassword = 409;
    case RateLimitingAuthSms = 410;
}
