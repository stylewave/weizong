<?php
namespace Home\Controller;
use Think\Controller;
class CompanyController extends CommonController {

	public function add_company(){
		$companytype 		= D('Companytype');
		$userid 			= $_SESSION['userid'];
		if($userid < 1000 ){
			if(IS_POST){
				$data = array(
					'zhcompanytype' => I('post.zhcompany'),
					'companytype'   => I('post.company'),
					'info' 			 => I('post.info'),	
					);
				$id =$companytype->data($data)->add();
				
				if($id !== false){
					$this->redirect('Company/list_company',array('tip'=>'COMPANY_ADD_SUCCESS'));
				}else{
					$this->redirect('Company/list_company',array('tip'=>'COMPANY_ADD_FALSE'));
				}
			}else{
				$this->display();
			}
		}else{
			$this->display('Layout:show_404');
		}
	}

	public function show_company(){
		$companytype 		= D('Companytype');
		$companytypelist	= $companytype->select();
		echo json_encode($companytypelist);
	}


	public function list_company(){
		$userid 			= $_SESSION['userid'];
		if($userid < 1000 ){
			$companytype 		= D('Companytype');
			$page 	 			= ($page == null) ? 0 : I('get.page');
			$countnum			= 15;
			$star				= (I('get.p',1)-1)*$countnum;
			$count 				= $companytype->count();
			// 分页
			$p 					= new \Think\Page($count,$countnum);
			$p->lastSuffix		=false;
		    $p->setConfig('header','<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>'.$countnum.'</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		    $p->setConfig('prev','上一页');
		    $p->setConfig('last','末页');
		    $p->setConfig('first','首页');
		    $p->setConfig('next','下一页');
		    $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
			$page 				= $p->show();
			$companytypelist	= $companytype->limit($p->firstRow.','.$p->listRows)->select();
			$this->assign('pageshow',$page);
			$this->assign('star',$star);
			$this->assign('companyList',$companytypelist);
			$this->display();
		}else{
			$this->display('Layout:show_404');
		}
	}

	public function update_company(){
		$companytype 		= D('Companytype');
		$companyId 			= I('get.companyid');
		$userid 			= $_SESSION['userid'];
		if($userid < 1000 ){
			if(IS_POST){
				$data 			= array(
					'zhcompanytype' => I('post.zhcompany'),
					'companytype'   => I('post.company'),
					'info' 			 => I('post.info'),	
					);
				if($companytype->where(array('id'=>$companyId))->save($data) !== false){
					$this->redirect('Company/list_company',array('tip'=>'COMPANY_UPDATE_SUCCESS'));
				}else{
					$this->redirect('Company/list_company',array('tip'=>'COMPANY_UPDATE_FALSE'));
				}
			}else{
				$companyInfo	= $companytype->where(array('id'=>$companyId))->select()[0];
				$this->assign('companyInfo',$companyInfo);
				$this->display();
			}
		}else{
			$this->display('Layout:show_404');
		}
	}

	public function del_company(){
		$companytype 		= D('Companytype');
		$userid 			= $_SESSION['userid'];
		$companyId 			= I('get.companyid');
		if($_SESSION['power'] == 'all'){
			$result =  $companytype->where(array('id'=>$companyId))->delete();
			if($result !== false){
				echo "true";
			}else{
				echo "false";
			}
		}
	}

}