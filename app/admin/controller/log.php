<?php

namespace admin\controller;

use service\component;

/**
 * Class log
 * @package admin\controller
 */
class log extends component\login {

    /**
     * log constructor.
     * @throws \Exception
     */
    public function __construct() {
        parent::__construct(1, 'admin');
    }
}
