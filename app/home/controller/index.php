<?php
namespace home\controller;
class index{
    public function index(){
    	echo 'Welcome to use PhpPoem !';
    }
    public function viewtest(){
    	$info = 'Welcome to Use Phppoem !';

    	assign('varname', $info);// 传递数据到view
    	// 展示view  默认当前方法名视图
    	// app/模块/view/控制器/方法.html 即
    	// app/home/view/index/viewtest.html
    	v();
    }
}