<?php

namespace admin\controller;

use \service\component;

/**
 * Class dash
 * @package admin\controller
 */
class dash extends component\login {

    /**
     * dash constructor.
     */
    public function __construct() {
        parent::__construct(1, 'admin');
    }

    /**
     * Func: index
     * User: Force
     * Date: 11/28/20
     * Time: 9:40 PM
     * Desc: 后台界面主体框架
     */
    public function index() {
        v();
    }

    /**
     * Func: main
     * User: Force
     * Date: 2021/4/7
     * Time: 20:53
     * Desc: 后台默认面板
     */
    public function main() {
        v();
    }
}
