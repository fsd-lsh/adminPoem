<?php

namespace admin\controller;

use service\component;

/**
 * Class menu
 * @package admin\controller
 */
class menu extends component\login {

    /**
     * menu constructor.
     */
    public function __construct() {
        parent::__construct(1, 'admin');
    }

    /**
     * Func: getSystemInit
     * User: Force
     * Date: 2021/4/4
     * Time: 19:05
     * Desc: 获取初始化数据
     */
    public function getSystemInit() {

        $systemInit = [
            'homeInfo' => [
                'title' => '首页',
                'href'  => 'page/welcome-1.html?t=1',
            ],
            'logoInfo' => [
                'title' => 'poemAdmin',
                'image' => '/static/layuimini/images/logo.png',
            ],
            'menuInfo' => $this->getMenuList(),
        ];

        echo json_encode($systemInit);
        exit;
    }

    /**
     * Func: getMenuList
     * User: Force
     * Date: 2021/4/4
     * Time: 19:05
     * Desc: 获取菜单列表
     */
    private function getMenuList() {

        $menuList = m('sys_menu')
            ->field('id,pid,title,icon,href,target')
            ->where([
                'status' => 1
            ])
            ->order('sort', 'desc')
            ->select();
        $menuList = $this->buildMenuChild(0, $menuList);
        return $menuList;
    }

    /**
     * Func: buildMenuChild
     * User: Force
     * Date: 2021/4/4
     * Time: 19:05
     * Desc: 递归获取子菜单
     */
    private function buildMenuChild($pid, $menuList) {

        $treeList = [];

        foreach ($menuList as $v) {

            if ($pid == $v['pid']) {

                $node = $v;
                $child = $this->buildMenuChild($v['id'], $menuList);

                if (!empty($child)) {
                    $node['child'] = $child;
                }

                // todo 后续此处加上用户的权限判断
                $treeList[] = $node;
            }
        }
        return $treeList;
    }
}
