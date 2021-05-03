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
     * @throws \Exception
     */
    public function __construct() {
        parent::__construct(1, 'admin');
    }

    /**
     * Func: index
     * User: Force
     * Date: 2021/4/4
     * Time: 20:30
     * Desc: 菜单设置
     */
    public function index() {

        //API
        sys_api([

            //菜单列表数据加载
            'lists' => function() {

                //获取菜单数据
                $menu_lists = m('sys_menu')
                    ->order('sort asc')
                    ->select();
                if(empty($menu_lists) || !is_array($menu_lists)) {
                    ajax(0, '菜单数据加载失败');
                }

                //配置
                $config = [
                    'status' => [
                        0 => '暂停',
                        1 => '启用',
                    ],
                ];

                //数据格式化
                $data = [];
                foreach ($menu_lists as $key => $item) {

                    $data[] = [
                        'id' => $item['id'],
                        'pid' => $item['pid'],
                        'title' => $item['title'],
                        'icon' => $item['icon'],
                        'href' => $item['href'],
                        'target' => $item['target'],
                        'sort' => $item['sort'],
                        'status' => $item['status'],
                        'status_mean' => $config['status'][$item['status']],
                        'remark' => $item['remark'],
                        'ctime' => date('Y-m-d H:i:s', $item['ctime']),
                        'utime' => date('Y-m-d H:i:s', $item['utime']),
                        'dtime' => date('Y-m-d H:i:s', $item['dtime']),
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
            },

            //启用、停用
            'hot' => function() {

                $id = intval(i('id'));
                $option = i('option');

                if(empty($id)) { ajax(0, 'ID不能为空'); }
                if(empty($option)) { ajax(0, '启用或停用？'); }

                switch ($option) {
                    case 'start': { $status = 1; $info = '启用'; break; }
                    case 'stop': { $status = 0; $info = '停用'; break; }
                }

                $result = m('sys_menu')
                    ->where([
                        'id' => $id
                    ])
                    ->update([
                        'status' => $status
                    ]);

                if($result) {
                    ajax(1, $info.'成功');
                }else {
                    ajax(0, $info.'失败');
                }
            },

            //删除菜单
            'del' => function() {

                $id = intval(i('id'));
                if(empty($id)) { ajax(0, 'ID不能为空'); }

                $result = m('sys_menu')
                    ->where([
                        'id' => $id
                    ])
                    ->delete();

                if($result) {
                    ajax(1, '删除成功');
                }else {
                    ajax(0, '删除失败');
                }
            },

            //保存菜单
            'save' => function() {

                $id = intval(i('id'));
                $data = [];
                if(i('title')) {
                    $data['title'] = i('title');
                }
                if(is_numeric(intval(i('pid')))) {
                    $data['pid'] = intval(i('pid'));
                }
                if(i('icon')) {
                    $data['icon'] = i('icon');
                }
                if(i('href')) {
                    $data['href'] = i('href');
                }
                if(i('target')) {
                    $data['target'] = i('target');
                }
                if(is_numeric(intval(i('sort')))) {
                    $data['sort'] = intval(i('sort'));
                }

                if(empty($id)) { ajax(0, 'ID不能为空'); }
                if(empty($data['title'])) { ajax(0, 'title不能为空'); }
                if(!is_numeric($data['pid'])) { ajax(0, 'pid不是一个数值'); }
                if(empty($data['href'])) { ajax(0, 'href不能为空'); }
                if(empty($data['target'])) { ajax(0, 'target不能为空'); }
                if(!is_numeric($data['sort'])) { ajax(0, 'sort不是一个数值'); }
                if(empty($data)) { ajax(0, '请检查表单是否填写完整'); }

                $result = m('sys_menu')
                    ->where([
                        'id' => $id,
                    ])
                    ->update($data);

                if($result) {
                    ajax(1, '修改菜单成功');
                }else {
                    ajax(0, '修改菜单失败');
                }
            },

            //添加菜单
            'add' => function() {

                $data = [];
                if(i('title')) {
                    $data['title'] = i('title');
                }
                if(is_numeric(intval(i('pid')))) {
                    $data['pid'] = intval(i('pid'));
                }
                if(i('icon')) {
                    $data['icon'] = i('icon');
                }
                if(i('href')) {
                    $data['href'] = i('href');
                }
                if(i('target')) {
                    $data['target'] = i('target');
                }
                if(is_numeric(intval(i('sort')))) {
                    $data['sort'] = intval(i('sort'));
                }

                if(empty($data['title'])) { ajax(0, 'title不能为空'); }
                if(!is_numeric($data['pid'])) { ajax(0, 'pid不是一个数值'); }
                if(empty($data['href'])) { ajax(0, 'href不能为空'); }
                if(empty($data['target'])) { ajax(0, 'target不能为空'); }
                if(!is_numeric($data['sort'])) { ajax(0, 'sort不是一个数值'); }
                if(empty($data)) { ajax(0, '请检查表单是否填写完整'); }

                $result = m('sys_menu')
                    ->insert($data);

                if($result) {
                    ajax(1, '添加菜单成功');
                }else {
                    ajax(0, '添加菜单失败');
                }
            },
        ]);

        //渲染视图
        v();
    }

    /**
     * Func: system_init
     * User: Force
     * Date: 2021/4/4
     * Time: 19:05
     * Desc: 获取菜单初始化数据
     */
    public function system_init() {

        $systemInit = [
            'homeInfo' => [
                'title' => '首页',
                'href'  => '/admin/dash/main',
            ],
            'logoInfo' => [
                'title' => 'poemAdmin',
                'image' => '/static/layuimini/images/logo.png',
            ],
            'menuInfo' => $this->get_menu_list(),
        ];

        echo json_encode($systemInit);
        exit;
    }

    /**
     * Func: get_menu_list
     * User: Force
     * Date: 2021/4/4
     * Time: 19:05
     * Desc: 获取菜单列表
     */
    private function get_menu_list() {

        $menuList = m('sys_menu')
            ->field('id,pid,title,icon,href,target')
            ->where([
                'status' => 1
            ])
            ->order('sort', 'desc')
            ->select();
        $menuList = $this->build_menu_child(0, $menuList);
        return $menuList;
    }

    /**
     * Func: buildMenuChild
     * User: Force
     * Date: 2021/4/4
     * Time: 19:05
     * Desc: 递归获取子菜单
     */
    private function build_menu_child($pid, $menuList) {

        $treeList = [];

        foreach ($menuList as $v) {

            if ($pid == $v['pid']) {

                $node = $v;
                $child = $this->build_menu_child($v['id'], $menuList);

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
