<?php
namespace Home\Controller;
use Think\Controller;

class FeePhaseController extends Controller {
    
	//默认跳转到listPage，分页显示
	public function index(){
        header("Location: listPage");
    }
	
	//分页显示，其中，$p为当前分页数，$limit为每页显示的记录数
	public function listPage(){
		$p	= I("p",1,"int");
		$limit	= 10;
		$fee_phase_list = D('FeePhase')->listPage($p,$limit);
		$this->assign('fee_phase_list',$fee_phase_list['list']);
		$this->assign('fee_phase_page',$fee_phase_list['page']);

		$this->display();
	}
	
	//新增
	public function add(){
		$data	=	array();
		$data['fee_phase_name']	=	trim(I('post.fee_phase_name'));
		
		if(!$data['fee_phase_name']){
			$this->error('未填写费用名称');
		} 

		$result = M('FeePhase')->add($data);
		
		if(false !== $result){
			$this->success('新增成功', 'listPage');
		}else{
			$this->error('增加失败', 'listPage');
		}
	}
		
	public function update(){
		if(IS_POST){
			$fee_phase_id	=	trim(I('post.fee_phase_id'));
			
			$data=array();
			$data['fee_phase_name']	=	trim(I('post.fee_phase_name'));

			$result = D('FeePhase')->update($fee_phase_id,$data);
			if(false !== $result){
				$this->success('修改成功', 'listPage');
			}else{
				$this->error('修改失败', 'listPage');
			}
		} else{
			$fee_phase_id = I('get.id',0,'int');

			if(!$fee_phase_id){
				$this->error('未指明要编辑的客户');
			}

			$fee_phase_list = M('FeePhase')->getByFeePhaseId($fee_phase_id);
			
			$this->assign('fee_phase_list',$fee_phase_list);

			$this->display();
		}
	}
}