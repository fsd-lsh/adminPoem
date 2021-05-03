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

        //API
        sys_api([

            //角色列表数据加载
            'lists' => function() {

                //获取角色数据
                $roles_lists = m('sys_roles')
                    ->where([
                        'status' => 1,
                    ])
                    ->order('id desc')
                    ->select();
                if(empty($roles_lists) || !is_array($roles_lists)) {
                    ajax(0, '角色数据加载失败');
                }

                //配置
                $config = [
                    'status' => [
                        0 => '删除',
                        1 => '正常',
                    ],
                ];

                //数据格式化
                $data = [];
                foreach ($roles_lists as $key => $item) {

                    $data[] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'status' => $item['status'],
                        'status_mean' => $config['status'][$item['status']],
                        'ctime' => date('Y-m-d H:i:s', $item['ctime']),
                        'utime' => date('Y-m-d H:i:s', $item['utime']),
                    ];
                }

                //响应
                echo json_encode([
                    'code' => 0,
                    'msg' => '',
                    'count' => count($data),
                    'data' => $data
                ]);
                exit;
            }
        ]);

        //渲染视图
        v();
    }
}
