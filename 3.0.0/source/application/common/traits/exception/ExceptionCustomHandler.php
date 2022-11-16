<?php
namespace app\common\traits\exception;

use app\common\exception\BaseException;
use app\common\exception\NotAuthException;
use app\common\exception\RequestTooFrequentException;

trait ExceptionCustomHandler
{
    protected $code;
    protected $message;
    protected $is_direct = 0;
    protected $direct_url = '';

    public function renderCommon($e)
    {

        switch ($e) {
            case $e instanceof \app\common\exception\ErrorException:
                $this->code = $e->code;
                $this->message = $e->message;
                $this->is_direct = 1;
                return true;
                break;
            case $e instanceof RequestTooFrequentException:
                $this->code = $e->code;
                $this->message = lang('request_too_frequent',['seconds' => $e->message]);
                return true;
                break;

        }
        return false;
    }

}