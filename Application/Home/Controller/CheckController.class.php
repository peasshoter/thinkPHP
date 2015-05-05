<?php
namespace Home\Controller;
use Think\Controller;

class CheckController extends Controller {

	public function listNotIssued(){
		
		//获取专利案列表
		$case_list	=	$this->listAllPatent2();
		$case_count	=	count($case_list);
		
		$this->assign('case_list',$case_list);
		$this->assign('case_count',$case_count);

		$this->display();
	
    }
	
	public function listNoFee(){
		
		
		//获取专利案列表
		$case_tmp_list	=	$this->listAllPatent();
		
		for($j=0;$j<count($case_tmp_list);$j++){
			
			//提取 case_id 和 our_ref
			$case_id[$j]=$case_tmp_list[$j]['case_id'];
			$our_ref[$j]=$case_tmp_list[$j]['our_ref'];
			
			/*
			//获取“授权后”对应的ID
			$map_case_phase['case_phase_name']	=	array('like','%授权后%');
			$case_phase_list	=	M('CasePhase')->where($map_case_phase)->find();
			$case_phase_id	=	$case_phase_list['case_phase_id'];
			*/
			
			//构造 mapping
			$map_case_fee['case_id']	=	$case_id[$j];
			
			//获取费用列表
			$case_fee_list	=	M('CaseFee')->where($map_case_fee)->find();
			
			if(!is_array($case_fee_list)){
				$case_list[$j]	=	$case_tmp_list[$j];
			}			
			
			
		}
		
		$case_count	=	count($case_list);
		
		$this->assign('case_list',$case_list);
		$this->assign('case_count',$case_count);
		$this->display();
	
    }
	
	//返回本数据视图的所有专利数据
	public function listAllPatent() {
		$case_type_list	=	D('CaseType')->listPatentCaseTypeId();
		$map['case_type_id']  = array('in',$case_type_list);
		$map['expired_date']	=	array('LT',1);
		
		$order['our_ref']	=	'asc';
		$list	=	D('CaseView')->where($map)->order($order)->select();

		return $list;
	}
	
	//返回本数据视图的所有专利数据
	public function listAllPatent2() {
		$case_type_list	=	D('CaseType')->listPatentCaseTypeId();
		$map['case_type_id']  = array('in',$case_type_list);
		$map['issue_date']	=	array('LT',1);
		
		$order['our_ref']	=	'asc';
		$list	=	D('CaseView')->where($map)->order($order)->select();

		return $list;
	}
	
}