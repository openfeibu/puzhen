<?php

return [

    // 默认输出类型
    'default_return_type' => 'html',

    // 默认全局过滤方法 用逗号分隔多个
    'default_filter' => 'trim,htmlspecialchars',

    // 模板设置
    'template' => [
        // layout布局
        'layout_on' => true,
        'layout_name' => 'layouts/layout',
        // 模板引擎类型 支持 php think 支持扩展
        'type' => 'think',
        // 模板路径
        'view_path' => '',
        // 模板后缀
        'view_suffix' => 'php',
        // 模板文件名分隔符
        'view_depr' => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin' => '{{',
        // 模板引擎普通标签结束标记
        'tpl_end' => '}}',
        // 标签库标签开始标记
        'taglib_begin' => '{{',
        // 标签库标签结束标记
        'taglib_end' => '}}',
    ],

    // 默认跳转页面对应的模板文件
    'dispatch_error_tmpl' => 'layouts/error',

    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle' => '\\app\\common\\exception\\pc\\ExceptionHandler',

    // 异常页面的模板文件
   // 'exception_tmpl'         => APP_PATH.'pc/view/layouts/error.php',

    'show_error_msg'         => true,
];
