<?php

namespace service\component;

/**
 * Class login
 * 登录服务套件（前后台通用）
 */
class login {

    private $user_info = NULL;
    private $user_type = NULL;
    private $is_api = NULL;

    /**
     * login constructor.
     * @throws \Exception
     */
    public function __construct($check_login = 0, $user_type = 'user') {

        //装载
        $this->user_type = $user_type;
        $this->user_info = session($this->user_type.'_info');

        //响应识别
        $this->is_api = i('api') ? true : false;

        //登录检测
        if($check_login) {

            switch ($this->user_type) {
                case 'user': { $url = '/'; break; }
                case 'admin': { $url = '/admin'; break; }
            }

            if(!$this->check_login()) {

                if($this->is_api) {
                    ajax(0, '您未登录', $url);
                }else {
                    err_jump( '您未登录', $url, '', 3);
                }
            }
        }
    }

    /**
     * Func: check_login
     * User: Force
     * Date: 2020/9/3
     * Time: 20:37
     * Desc: 检查登录状态
     */
    public function check_login() {

        return (!empty($this->user_info) && is_array($this->user_info)) ? true : false;
    }

    /**
     * Func: sign_in
     * User: Force
     * Date: 2021/4/4
     * Time: 18:49
     * Desc: 登录
     */
    public function sign_in() {

        //检查请求
        if(empty(i('username'))) {
            if($this->is_api) {
                ajax(0, '请输入账号');
            }else {
                err_jump( '请输入账号', '', '', 3);
            }
        }
        if(empty(i('password'))) {
            if($this->is_api) {
                ajax(0, '请输入密码');
            }else {
                err_jump( '请输入密码', '', '', 3);
            }
        }

        //获取账号信息
        switch ($this->user_type) {
            case 'user': { $table = 'user'; break; }
            case 'admin': { $table = 'sys_admin'; break; }
        }
        $user_info = m($table)
            ->where([
                'name' => i('username'),
                'status' => 1
            ])
            ->find();
        if(empty($user_info)) {
            if($this->is_api) {
                ajax(0, '账号不存在');
            }else {
                err_jump( '账号不存在', '', '', 3);
            }
        }

        //检查密码
        if(!password_verify(i('password'), $user_info['password'])) {
            if($this->is_api) {
                ajax(0, '密码错误');
            }else {
                err_jump( '密码错误', '', '', 3);
            }
        }

        //写入登录信息
        session($this->user_type.'_info', $user_info);

        //登录跳转至后台
        switch ($this->user_type) {
            case 'user': { $url = '/'; break; }
            case 'admin': { $url = '/admin/dash'; break; }
        }
        if($this->is_api) {
            ajax(1, '登录成功', $url);
        }else {
            ok_jump( '密码错误', $url, '', 3);
        }
    }

    /**
     * Func: sign_up
     * User: Force
     * Date: 2020/10/5
     * Time: 17:23
     * Desc: 普通注册
     */
    public function sign_up() {

    }

    /**
     * Func: sign_out
     * User: Force
     * Date: 2020/9/3
     * Time: 20:34
     * Desc: 注销
     */
    public function sign_out() {

        switch ($this->user_type) {
            case 'user': { $url = '/'; break; }
            case 'admin': { $url = '/admin'; break; }
        }
        session($this->user_type.'_info', NULL);
        ajax(1, '注销成功', $url);
    }

    /**
     * login __deconstruct
     */
    public function __deconstruct() {}
}
