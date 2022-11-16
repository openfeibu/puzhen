<?php

namespace app\common\exception;


/**
 * 用于请求太频繁
 */
class NotAuthException extends BaseException
{

    public $code = -1;
}
