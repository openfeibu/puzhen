<?php

namespace app\common\exception;


/**
* 用于请求太频繁
*/
class RequestTooFrequentException extends BaseException
{

    public $code = 0;
}
