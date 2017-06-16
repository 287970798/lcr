<?php
//控制器基类
class Action{
	protected $model;
	protected function __construct(&$model=null){
		$this->model = $model;
	}
}