<?php
namespace Home\Controller;
use Think\Controller;
class VocationtypeController extends CommonController {

	public function add_vocationtype(){
		$vocationtype 		= D('Vocationtype');
		$userid 			= $_SESSION['userid'];
		if($userid < 1000 ){
			if(IS_POST){
				$data = array(
					'zhvocationtype' => I('post.zhvocationtype'),
					'vocationtype'   => I('post.vocationtype'),
					'info' 			 => I('post.info'),	
					);
				$id =$vocationtype->data($data)->add();
				
				if($id !== false){
					$this->redirect('Vocationtype/list_vocationtype',array('tip'=>'TYPE_ADD_SUCCESS'));
				}else{
					$this->redirect('Vocationtype/list_vocationtype',array('tip'=>'TYPE_ADD_FALSE'));
				}
			}else{
				$this->display();
			}
		}else{
			$this->display('Layout:show_404');
		}
	}

	public function show_vocationtype(){
		$vocationtype 		= D('Vocationtype');
		$vocationtypelist	= $vocationtype->select();
		echo json_encode($vocationtypelist);
	}


	public function list_vocationtype(){
		$userid 			= $_SESSION['userid'];
		if($userid < 1000 ){
			$vocationtype 		= D('Vocationtype');
			$vocationtypelist	= $vocationtype->select();
			$this->assign('appTypeList',$vocationtypelist);
			$this->display();
		}else{
			$this->display('Layout:show_404');
		}
	}

	public function update_vocationtype(){
		$vocationtype 		= D('Vocationtype');
		$typeId 			= I('get.typeid');
		$userid 			= $_SESSION['userid'];
		if($userid < 1000 ){
			if(IS_POST){
				$data 			= array(
					'zhvocationtype' => I('post.zhvocationtype'),
					'vocationtype'   => I('post.vocationtype'),
					'info' 			 => I('post.info'),	
					);
				if($vocationtype->where(array('id'=>$typeId))->save($data) !== false){
					$this->redirect('Vocationtype/list_vocationtype',array('tip'=>'TYPE_UPDATE_SUCCESS'));
				}else{
					$this->redirect('Vocationtype/list_vocationtype',array('tip'=>'TYPE_UPDATE_FALSE'));
				}
			}else{
				$appTypeInfo	= $vocationtype->where(array('id'=>$typeId))->select()[0];
				$this->assign('appTypeInfo',$appTypeInfo);
				$this->display();
			}
		}else{
			$this->display('Layout:show_404');
		}
	}

	public function del_vocationtype(){
		$vocationtype 		= D('Vocationtype');
		$userid 			= $_SESSION['userid'];
		$typeId 			= I('get.typeid');
		if($_SESSION['power'] == 'all'){
			$result =  $vocationtype->where(array('id'=>$typeId))->delete();
			if($result !== false){
				echo "true";
			}else{
				echo "false";
			}
		}
	}

}