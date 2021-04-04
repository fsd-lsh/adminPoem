<?php

if(!function_exists('sys_api')) {

    /**
     * Func: sys_api
     * User: Force
     * Date: 2021/4/4
     * Time: 15:33
     * Desc: 系统API辅助
     */
    function sys_api($table = NULL) {

        //API模式运行
        if(i('api')) {

            //检测API表
            if(empty($table) && !is_array($table)) {
                ajax(0, 'The API cannot be recognized.');
            }

            //遍历识别运行
            foreach ($table as $key => $func) {
                if($key == i('api')) {
                    $func();
                }
            }

            exit;
        }
    }
}

