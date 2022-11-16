<?php

namespace app\common\exception\pc;

use app\common\traits\exception\ExceptionCustomHandler;
use think\Config;
use think\Log;
use think\exception\Handle;
use think\exception\DbException;
use Exception;
use think\Request;
use app\common\exception\BaseException;
use app\common\exception\NotAuthException;
/**
 * 重写Handle的render方法，实现自定义异常消息
 * Class ExceptionHandler
 * @package app\common\library\exception
 */
class ExceptionHandler extends Handle
{
    use ExceptionCustomHandler;


    /**
     * 输出异常信息
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     *
     *  * 可能需要增加is_direct
     * 1、错误或成功直接返回界面并传入with 隐形参数，界面显示错误或成功信息。
     * 一般错误是原界面，成功是一个新界面且不用提示成功。成功一般不要用抛出界面的形式，直接redirect
     * 2、跳到一个共同界面提示错误，BaseException 或者 未知错误。
     *
     */
    public function render(Exception $e)
    {
        if(!$this->renderCommon($e))
        {
            switch ($e) {
                case $e instanceof NotAuthException:
                    $this->code = $e->code;
                    $this->message = $e->message;
                    $this->direct_url = 'passport/login';
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

        }

        if (!config('app_debug')) {
            Config::set('exception_tmpl',APP_PATH.'pc/view/layouts/error.php');
        }

        if(Request::instance()->isAjax() || strpos(Request::instance()->contentType(),'json'))
        {
            return json(['msg' => $this->message, 'code' => $this->code,'direct_url' => $this->direct_url]);
        }
        else{
            $direct_url = $this->direct_url ?: ($_SERVER['HTTP_REFERER'] ?? 'index');
            return redirect($direct_url,[], 302, ['msg' => $this->message, 'code' => $this->code]);
        }

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
