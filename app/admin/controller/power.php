<?php

namespace admin\controller;

use service\component;

/**
 * Class power
 * @package admin\controller
 */
class power extends component\login {

    /**
     * power constructor.
     * @throws \Exception
     */
    public function __construct() {
        parent::__construct(1, 'admin');
    }

    /**
     * Func: index
     * User: Force
     * Date: 2021/4/7
     * Time: 20:42
     * Desc: 权限设置
     */
    public function index() {
        v();
    }
}
