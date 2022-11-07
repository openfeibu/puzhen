<?php

namespace app\common\exception;

use think\Log;
use think\exception\Handle;
use think\exception\DbException;
use Exception;
use think\Request;

/**
 * 重写Handle的render方法，实现自定义异常消息
 * Class ExceptionHandler
 * @package app\common\library\exception
 */
class ExceptionHandler extends Handle
{
    private $code;
    private $message;

    /**
     * 输出异常信息
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(Exception $e)
    {
        switch ($e) {
            case $e instanceof RequestTooFrequentException:
                $this->code = $e->code;
                $this->message = lang('request_too_frequent',['seconds' => $e->message]);
                break;
            case $e instanceof BaseException:
                //必须放到最后
                $this->code = $e->code;
                $this->message = $e->message;
                break;
            default:
                if (config('app_debug')) {
                    return parent::render($e);
                }
                $this->code = 0;
                $this->message = $e->getMessage() ?: lang('server_error');
                $this->recordErrorLog($e);
                break;
        }

        if( Request::instance()->isAjax())
        {
            return json(['msg' => $this->message, 'code' => $this->code]);
        }


    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // 不使用内置的方式记录异常日志
    }

    /**
     * 将异常写入日志
     * @param Exception $e
     */
    private function recordErrorLog(Exception $e)
    {
        $data = [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $this->getMessage($e),
            'code' => $this->getCode($e),
            'TraceAsString' => $e->getTraceAsString()
        ];
        // 如果是mysql报错, 则记录Error SQL
        if ($e instanceof DbException) {
            $data['TraceAsString'] = "[Error SQL]: " . $e->getData()['Database Status']['Error SQL'];
        }
        // 日志标题
        $log = "[{$data['code']}]{$data['message']} [{$data['file']}:{$data['line']}]";
        // 错误trace
        $log .= "\r\n{$data['TraceAsString']}";
        Log::record($log, 'error');
    }
}
