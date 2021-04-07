<?php

namespace admin\controller;

use service\component;

/**
 * Class roles
 * @package admin\controller
 */
class roles extends component\login {

    /**
     * roles constructor.
     * @throws \Exception
     */
    public function __construct() {
        parent::__construct(1, 'admin');
    }

    /**
     * Func: index
     * User: Force
     * Date: 2021/4/7
     * Time: 20:47
     * Desc: 角色设置
     */
    public function index() {
        v();
    }
}
