<?php

/**
 * 鐢ㄦ埛鎺у埗琛�
 * 鏃堕棿锛�015.8.24
 * author:涓�彧灏肩帥
 * www.lenggirl.com
 路*/
namespace Admin\Controller;

use Think\Controller;

class QingmuController extends CommomController {
	public function listcomment() {
		$shopname = M ( 'qingmu.comment', 'c_' )->field ( 'shop_name' )->distinct ( true )->select ();
		$this->assign ( 'shopname', $shopname );
		$this->display ();
	}
	function listdictionary() {
		$type = M ( 'qingmu.dictionary', 'c_' )->field ( 'type' )->distinct ( true )->select ();
		$this->assign ( 'type', $type );
		$this->display ();
	}
	public function listcomments() {
		$shop_name = I ( 'shop_name', '' );
		$url = I ( 'url', '' );
		// $a=array(1=>1);
		if ($shop_name != '') {
			$a ['shop_name'] = $shop_name;
		}
		if ($url != '') {
			$a ['item_url'] = $url;
		}
		$total = M ( 'qingmu.comment', 'c_' )->where ( $a )->count ();
		$pageSize = I ( 'rows', '5' );
		$page = I ( 'page', '5' );
		$pageStart = ($page - 1) * $pageSize;
		$rows = M ( 'qingmu.comment', 'c_' )->where ( $a )->limit ( $pageStart . ',' . $pageSize )->order ( 'createtime desc' )->select ();
		$data ['total'] = $total;
		$data ['rows'] = $rows;
		$this->ajaxReturn ( $data );
	}
	public function listdictionarys() {
		$type = I ( 'type', '' );
		$nullscore = I ( 'nullscore', 1 );
		// $a=array(1=>1);
		if ($type != '') {
			$a ['type'] = $type;
		}
		if ($nullscore == 0) {
			$a ['score'] = array (
					'EXP',
					'IS NULL' 
			);
		} else {
			$a ['score'] = array (
					'EXP',
					'IS NOT NULL' 
			);
		}
		$total = M ( 'qingmu.dictionary', 'c_' )->where ( $a )->count ();
		$pageSize = I ( 'rows', '5' );
		$page = I ( 'page', '5' );
		$pageStart = ($page - 1) * $pageSize;
		$rows = M ( 'qingmu.dictionary', 'c_' )->where ( $a )->limit ( $pageStart . ',' . $pageSize )->order ( 'createtime desc' )->select ();
		$data ['total'] = $total;
		$data ['rows'] = $rows;
		$this->ajaxReturn ( $data );
	}
	function render() {
		$shopname = M ( 'qingmu.comment', 'c_' )->field ( 'shop_name' )->distinct ( true )->select ();
		$this->assign ( 'shopname', $shopname );
		$this->display ();
	}
	function listrender() {
		$url = I ( 'url', '' );
		if ($url != '') {
			$a ['item_url'] = $url;
		}
		$total = M ( 'qingmu.result', 'c_' )->where ( $a )->count ();
		$pageSize = I ( 'rows', '' );
		$page = I ( 'page', '' );
		$pageStart = ($page - 1) * $pageSize;
		$rows = M ( 'qingmu.result', 'c_' )->where ( $a )->limit ( $pageStart . ',' . $pageSize )->order ( 'updatetime desc' )->select ();
		foreach ( $rows as &$row ) {
			$row ['d1'] = round ( $row ['d1'], 2 );
			$row ['d2'] = round ( $row ['d2'], 2 );
			$row ['d3'] = round ( $row ['d3'], 2 );
			$row ['d4'] = round ( $row ['d4'], 2 );
			$row ['d5'] = round ( $row ['d5'], 2 );
			$row ['d6'] = round ( $row ['d6'], 2 );
			$row ['d7'] = round ( $row ['d7'], 2 );
		}
		$data ['total'] = $total;
		$data ['rows'] = $rows;
		$this->ajaxReturn ( $data );
	}
	function updatescore() {
		$id = I ( 'id', '' );
		$score = I ( 'score', '' );
		$username = $_SESSION ['username'];
		$data ['score'] = $score;
		$data ['people'] = $username;
		$data ['createtime'] = date ( "Y-m-d H:i:s", strtotime ( 'now' ) );
		$isok = M ( 'qingmu.dictionary', 'c_' )->where ( array (
				'id' => $id 
		) )->save ( $data );
		if ($isok) {
			$this->ajaxReturn ( '修改成功' );
		} else {
			$this->ajaxReturn ( '修改失败' );
		}
	}
	function render1() {
		$id = I ( 'row', '' );
		if ($id == '') {
			$this->error ( "不存在id" );
		} else {
			$data = M ( 'qingmu.result', 'c_' )->where ( array (
					'item_url' => $id 
			) )->find ();
			// $datas=M('qingmu.commentsb','c_')->where(array('item_url'=>$id))->select();
			$this->assign ( 'data', $data );
			// $this->assign('datas',$datas);
			$this->display ();
		}
	}
	function render2() {
		$id1 = I ( 'row1', '' );
		$id2 = I ( 'row2', '' );
		if ($id1 == '' or $id2 == '') {
			$this->error ( "不存在Id" );
		} else {
			$data1 = M ( 'qingmu.result', 'c_' )->where ( array (
					'item_url' => $id1 
			) )->find ();
			$data2 = M ( 'qingmu.result', 'c_' )->where ( array (
					'item_url' => $id2 
			) )->find ();
			if ($data1 == false or $data1 == false) {
				$this->error ( "找不到信息" );
			}
			$this->assign ( 'data1', $data1 );
			$this->assign ( 'data2', $data2 );
			// $this->assign('datas',$datas);
			$this->display ();
		}
	}
	function listsb() {
		$url = I ( 'url', '' );
		if ($url != '') {
			$a ['item_url'] = $url;
		} else {
			return;
		}
		$total = M ( 'qingmu.commentsb', 'c_' )->where ( $a )->count ();
		$pageSize = I ( 'rows', '' );
		$page = I ( 'page', '' );
		$pageStart = ($page - 1) * $pageSize;
		$rows = M ( 'qingmu.commentsb', 'c_' )->where ( $a )->limit ( $pageStart . ',' . $pageSize )->order ( 'createtime desc' )->select ();
		foreach ( $rows as &$row ) {
			$commentid = $row ['comment_id'];
			$c = M ( 'qingmu.comment', 'c_' )->where ( array (
					'id' => $commentid 
			) )->find ();
			$row ['comment_id'] = $c ['content'];
		}
		$data ['total'] = $total;
		$data ['rows'] = $rows;
		$this->ajaxReturn ( $data );
	}
	function time() {
		if (parent::isroot ()) {
		} else {
			redirect ( __ROOT__ . '/Public/error.html' );
			return;
		}
		/*
		 * $data=M('shopdata','stat',C('qingmu'))->group('refshopid')->select();
		 * foreach($data as &$row){
		 * $shopid=$row['refshopid'];
		 * $shop=M('shop','ref',C('qingmu'))->where(array('id'=>$shopid))->find();
		 * if($shop){
		 * $row['refshopname']=$shop['sname'];
		 * }
		 * }
		 * $this->assign('data',$data);
		 */
		
		$shop = M ( 'shop', 'ref', C('qingmu') )->order ( 'sname' )->where ( array (
				'isShow' => 1 
		) )->select ();
		//var_dump(C('qingmu'));
		//var_dump($shop);
		$this->assign ( 'data', $shop );
		$this->display (); // M('User','other_','mysql://biuser:qingmutecoa@192.168.0.20/qingmu#utf8');
	}
	
	//不合理要求
	function seedetail(){
		$refshopid=I('refshopid','');
		$day=I('day','');
		$id=I('id','');
		$dayarray=explode('-', $day);
		$year=$dayarray[0];
		$month=$dayarray[1];
		$bt=$day.'-01';
		switch ($month) {
			case '01' :
			case '03' :
			case '05' :
			case '07' :
			case '08' :
			case '10' :
			case '12' :
				$et=$day.'-31';
				break;
			case '04' :
			case '06' :
			case '09' :
			case '11' :
				$et=$day.'-30';
				break;
			case '02' :
				if (( $year % 100 == 0 and $year % 400 == 0) or ($year % 100 != 0 and $year % 4 == 0)) {
					$et=$day.'-29';
				} else {
					$et=$day.'-28';
				}	
		}
		$this->assign('refshopid',$refshopid);
		$this->assign('bt',$bt);
		$this->assign('et',$et);
		$this->assign('id',$id);
		$this->assign('yearmonth',$day);
		$this->display ();
	}
	function listtime() {
		if (parent::isroot ()) {
		} else {
			redirect ( __ROOT__ . '/Public/error.html' );
			return;
		}
		// SELECT * FROM qingmu.statshopdata where refShopid=10 and STR_TO_DATE(statDay,'%Y-%m-%d') between '2014-01-12' and '2015-06-30'
		$refshopid = I ( 'refshopid', '' );
		if ($refshopid != '') {
			$datas ['refshopid'] = $refshopid;
		}
		$bt = I ( 'bt', '' );
		$et = I ( 'et', '' );
		if ($bt != '' and $et != '') {
			$ok = 1;
		} else {
			$ok = 0;
		}
		if ($ok == 1 and $refshopid != '') {
			$db = M ( 'shopdata', 'stat', C('qingmu') );
			$sql = "refshopid=" . $refshopid . " and STR_TO_DATE(statDay,'%Y-%m-%d') between '" . $bt . "' and '" . $et . "'";
			$total = $db->where ( $sql )->count ();
		} else {
			$total = M ( 'shopdata', 'stat', C('qingmu') )->where ( "refshopid=" . $refshopid )->count ();
		}
		$pageSize = I ( 'rows', 30 );
		$page = I ( 'page', 1 );
		$pageStart = ($page - 1) * $pageSize;
		if ($ok == 1 and $refshopid != '') {
			$db = M ( 'shopdata', 'stat', C('qingmu') );
			$sql = "refshopid=" . $refshopid . " and STR_TO_DATE(statDay,'%Y-%m-%d') between '" . $bt . "' and '" . $et . "'";
			$rows = $db->where ( $sql )->limit ( $pageStart . ',' . $pageSize )->order ( "STR_TO_DATE(statDay,'%Y-%m-%d')" )->select ();
		} else {
			$rows = M ( 'shopdata', 'stat', C('qingmu') )->where ( "refshopid=" . $refshopid )->order ( "STR_TO_DATE(statDay,'%Y-%m-%d')" )->limit ( $pageStart . ',' . $pageSize )->select ();
		}
		foreach ( $rows as &$row ) {
			$shopid = $row ['refshopid'];
			$shop = M ( 'shop', 'ref', C('qingmu') )->where ( array (
					'id' => $shopid 
			) )->find ();
			if ($shop) {
				$row ['refshopid'] = $shop ['sname'];
			}
			// 鐩爣寮�
			//
			$time = $row ['statday'];
			$timez = explode ( '-', $time );
			$time1 = $timez [0] . '-' . $timez [1];
			$mubiao = M ( 'sellplan', 'stat', C('qingmu') )->where ( "refshopid=" . $shopid . " and pmonth='" . $time1 . "'" )->find ();
			if ($mubiao) {
				$row ['plan'] = $mubiao ['plan'];
				switch ($timez [1]) {
					case '01' :
					case '03' :
					case '05' :
					case '07' :
					case '08' :
					case '10' :
					case '12' :
						$row ['dayplan'] = ( float ) $row ['plan'] / 31;
						break;
					case '04' :
					case '06' :
					case '09' :
					case '11' :
						$row ['dayplan'] = ( float ) $row ['plan'] / 30;
						break;
					case '02' :
						if ((( int ) $timez [0] % 100 == 0 and ( int ) $timez [0] % 400 == 0) or (( int ) $timez [0] % 100 != 0 and ( int ) $timez [0] % 4 == 0)) {
							$row ['dayplan'] = ( float ) $row ['plan'] / 29;
						} else {
							$row ['dayplan'] = ( float ) $row ['plan'] / 28;
						}
				}
				$row ['lzcgplan'] = $mubiao ['lzcgplan'];
				$row ['lzhdplan'] = $mubiao ['lzhdplan'];
				$row ['lzjhsplan'] = $mubiao ['lzjhsplan'];
			} else {
				$row ['plan'] = 0;
				$row ['dayplan'] = 0;
				$row ['lzcgplan'] = 0;
				$row ['lzhdplan'] = 0;
				$row ['lzjhsplan'] = 0;
			}
			$row ['sumday'] = $row ['sumcgmoney'] + $row ['sumhdmoney'] + $row ['sumjhsmoney'];
			$row ['summonth'] = $row ['sumcgmonthmoney'] + $row ['sumhdmonthmoney'] + $row ['sumjhsmonthmoney'];
			$row ['dayplanrate'] = $row ['sumday'] / $row ['dayplan'];
			$row ['monthplanrate'] = $row ['summonth'] / $row ['plan'];
			$row ['monthcgplanrate'] = $row ['sumcgmonthmoney'] / $row ['lzcgplan']; // 甯歌瀹屾垚鐜�
			$row ['monthhdplanrate'] = $row ['sumhdmonthmoney'] / $row ['lzhdplan'];
			$row ['monthjhsplanrate'] = $row ['sumjhsmonthmoney'] / $row ['lzjhsplan'];
		}
		$data ['total'] = $total;
		$data ['rows'] = $rows;
		$this->ajaxReturn ( $data );
	}
	
	function monthstime() {
		if (parent::isroot ()) {
		} else {
			redirect ( __ROOT__ . '/Public/error.html' );
			return;
		}
		/*
		 * $data=M('shopdata','stat',C('qingmu'))->group('refshopid')->select();
		 * foreach($data as &$row){
		 * $shopid=$row['refshopid'];
		 * $shop=M('shop','ref',C('qingmu'))->where(array('id'=>$shopid))->find();
		 * if($shop){
		 * $row['refshopname']=$shop['sname'];
		 * }
		 * }
		 * $this->assign('data',$data);
		 */
	
		$shop = M ( 'shop', 'ref', C('qingmu') )->order ( 'sname' )->where ( array (
				'isShow' => 1
		) )->select ();
		$this->assign ( 'data', $shop );
		$this->display (); // M('User','other_','mysql://biuser:qingmutecoa@192.168.0.20/qingmu#utf8');
	}
	

	function listmonthtime(){
		if (parent::isroot ()) {
		} else {
			redirect ( __ROOT__ . '/Public/error.html' );
			return;
		}
		
		$refshopid = I ( 'refshopid', '' );
		if ($refshopid != '') {
			$datas ['refshopid'] = $refshopid;
		}else{
			$this->ajaxReturn('No shopid');//无店铺ID
		}
		$bt = I ( 'bt', '' );
		$et = I ( 'et', '' );
		if ($bt != '' and $et != '') {
		} else {
			//日期不完整
			$this->ajaxReturn('date not complete');;
		}
		try
		{
		$data1=explode('-', $bt);
		$data2=explode('-', $et);
		$y1=(int)$data1[0];
		$m1=(int)$data1[1];
		$y2=(int)$data2[0];
		$m2=(int)$data2[1];
		}
		catch (Exception $e){
			//日期不正确
			$this->ajaxReturn('date change error'.$e->getTrace());
		}
		
		if(($m1<=0 or $m1>12) or ($m2<=0 or $m2>12)){
			//月数不对
			$this->ajaxReturn('month wrong');
		}
		if($y1>$y2){
			//年数不对
			$this->ajaxReturn('year wrong');
		}else if($y1==$y2){
			if($m1>=$m2){
				//年对、月不对
				$this->ajaxReturn('year right month wrong');
			}
		}else{
			
		}
		$daylength=array();
		/*从这里开始干活了*/
		if($y1==$y2){
		for($i=$y1;$i<=$y2;$i++){
			for($j=$m1;$j<=$m2;$j++){
				if($j<10){
				$daylength[]=$i.'-0'.$j;}else{
					$daylength[]=$i.'-'.$j;
				}
			}
		}}
		else{
			//2015-02**2016-08
			for($k=$m1;$k<=12;$k++){
				if($k<10){
					$daylength[]=$y1.'-0'.$k;
				}else{
				$daylength[]=$y1.'-'.$k;//20
				}
			}
			for($i=$y1+1;$i<$y2;$i++){
				for($j=1;$j<=12;$j++){
					if($j<10){
						$daylength[]=$i.'-0'.$j;
					}else{
					$daylength[]=$i.'-'.$j;
					}
				}
			}
			for($h=1;$h<=$m2;$h++){
				if($h<10){
					$daylength[]=$y2.'-0'.$h;
				}else{
				$daylength[]=$y2.'-'.$h;//20
				}
			}
		}
	/* 	$this->ajaxReturn($daylength);
		return; */
		$rows=array();
		foreach ($daylength as $day){
			$isexist=M('qingmu.timer', 'oa')->where(array('shopid'=>$refshopid,'yearmonth'=>$day))->find();
			$updateid=0;
			$pai=0;
			if($isexist){
				$paichustatus=$isexist['paichustatus'];
				if('0'===$paichustatus){
					$pai=2;//这个值好啊!!
				}
			//	var_dump('0'===$paichustatus);
				if($isexist['status']==1 and $pai!=2){
				//last year data
				$lastyear1=explode('-', $day);
				$lastyear2=$lastyear1[0]-1;
				$lastyear=$lastyear2.'-'.$lastyear1[1];
				//var_dump($lastyear);
				$qunian=M('qingmu.timer', 'oa')->where(array('shopid'=>$refshopid,'yearmonth'=>$lastyear))->find();
				//var_dump($qunian);
				if($qunian){
					$isexist['qcgmoney']=$qunian['cgmoney'];
					$isexist['qcgrate']=$qunian['cgrate'];
					$isexist['qsumrate']=$qunian['sumrate'];
				}else{
					$isexist['qcgmoney']='none';
					$isexist['qcgrate']='none';
					$isexist['qsumrate']='none';
				}
				$rows[]=$isexist;
				continue;
				}
				else{
					$updateid=$isexist['id'];
					$paichushijian=explode(',',$isexist['paichushijian']);
				}
			}
			if(1==1)
			{
				//开始插数据、处理数据
				//笨蛋，不要看这里
				/*CREATE TABLE `oatimer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopname` varchar(200) DEFAULT NULL COMMENT '店铺名',
  `shopid` int(11) DEFAULT NULL COMMENT '店铺id',
  `yearmonth` varchar(100) DEFAULT NULL COMMENT '月-年（2015-02）',
  `day` varchar(100) DEFAULT NULL COMMENT '天(如果数据还没有到达月尾，则为那天,一般值为29,30,31）',
  `cgrate` varchar(45) DEFAULT NULL COMMENT '常规完成率',
  `sumrate` varchar(45) DEFAULT NULL COMMENT '总体完成率',
  `cgmoney` varchar(45) DEFAULT NULL COMMENT '日成交额（常规平均,活动聚划算当天不算）',
  `createtime` datetime DEFAULT NULL COMMENT '查询时间',
  `updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `username` varchar(64) DEFAULT NULL COMMENT '最后一次查询人',
  `status` tinyint(4) DEFAULT NULL COMMENT '是否到达月尾（1表示已经到达月尾，0表示需要重新计算）',
  `calday` tinyint(4) DEFAULT NULL COMMENT '该月常规天数',
  `summonthmoney` decimal(19,2) DEFAULT NULL COMMENT '月累计销售额',
  `sumcgmonthmoney` decimal(19,2) DEFAULT NULL COMMENT '月常规销售额',
  `plan` decimal(19,2) DEFAULT NULL COMMENT '月总目标',
  `lzcgplan` decimal(19,2) DEFAULT NULL COMMENT '常规目标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='OA时间序列预测统计数据表';*/
				
				//SELECT * FROM qingmu.statshopdata where refShopId=91 and statDay like '2016-02-%' order by statDay desc;
				//SELECT sum(sumcgmoney)/count(*) FROM qingmu.statshopdata where refShopId=8 and statDay like '2016-03-%' and sumjhsMoney=0 and sumhdMoney=0 order by statDay desc;
				//这样算日常规很快
				$sql1="refshopid=".$refshopid." and statday like '".$day."-%' and sumjhsmoney=0 and sumhdmoney=0";
				if($pai!=2){
				
				}else{
				foreach ($paichushijian as $temp){
					$sql1=$sql1." and statday not like '".$day."-".$temp."'";
					//var_dump($sql1);
				}
				}/* $this->ajaxReturn($sql1);return; */
				$sql1rs= M('shopdata', 'stat', C('qingmu'))->where($sql1)->field("count(*) as calday, sum(sumcgmoney)/count(*) as cgmoney")->order("statday desc")->select();
				$sql1r=$sql1rs[0];
				//var_dump($sql1r);
				/**************保护对象*******************/
				//日成交额常规
				$cgmoney=$sql1r['cgmoney'];
				//该月常规天数
				$calday=$sql1r['calday'];
				/***************保护对象******************/
				$sql2="refshopid=".$refshopid." and statday like '".$day."-%'";
				$sql2rs= M('shopdata', 'stat', C('qingmu'))->where($sql2)->order("statday desc")->limit(1)->select();
				if($sql2rs==false){
					continue;
				}
				$sql2r=$sql2rs[0];
				//var_dump($sql2r);
				/**************保护对象*******************/
				//月累计销售额
				$summonthmoney=$sql2r['summonthmoney'];
				//月常规销售额
				$sumcgmonthmoney=$sql2r['sumcgmonthmoney'];
				//常规完成率
				$cgrate=0;
				//总体完成率
				$sumrate=0;
				//月总目标
				$plan=0;
				//常规目标
				$lzcgplan=0;
				//当月最后一天
				$lastday=$sql2r['statday'];
				//是否已经是最后一天
				$status=0;
				$shopname='';
				$shop = M ( 'shop', 'ref', C('qingmu') )->where ( array (
						'id' =>$refshopid))->find ();
				if ($shop) {
					//店铺名
					$shopname = $shop ['sname'];
				}
				$mubiao = M ( 'sellplan', 'stat', C('qingmu') )->where ( "refshopid=" . $refshopid . " and pmonth='" . $day . "'" )->find ();
				if ($mubiao) {
					//月总目标
					$plan= $mubiao ['plan'];
					$sumrate=$summonthmoney/$plan;
					//常规目标
					$lzcgplan= $mubiao ['lzcgplan'];
					$cgrate=$sumcgmonthmoney/$lzcgplan;
					//判断是否最后一天
					$temp=explode('-', $lastday);
					$tempy=$temp[0];//2015
					$tempm=$temp[1];//05
					$tempd=$temp[2];//06
					
					/*
					 * 这里傻逼放一个界定 是否最后一天的标记，排除BUG在此
					 * 
					 * 还是不放了！！
					 * */
		
					switch ($tempd){
						case '29':
							if($tempm=='02'){
							if(($tempy%100==0 and $tempy%400==0) or ($tempy%100!=0 and $tempy%4==0)){
								$status=1;
							}else{
								$status=0;
							}
							}
							break;
						case '28':
							if($tempm=='02'){
								if(($tempy%100==0 and $tempy%400==0) or ($tempy%100!=0 and $tempy%4==0)){
									$status=0;
								}else{
									$status=1;
								}
							}
								break;
						case '31':
							if($tempm=='01' or $tempm=='03' or $tempm=='05' or $tempm=='07' or $tempm=='08' or $tempm=='10' or $tempm=='12'){
								$status=1;
							}else{
								$status=0;
							}
							break;
						case '30':
							if($tempm=='04' or $tempm=='06' or $tempm=='09' or $tempm=='11'){
								$status=1;
							}else{
								$status=0;
							}
							break;
						default:
							$status=0;
					}
				}
				
				//插数据、look hear
				$data['day']=$lastday;
				$data['status']=$status;
				$data['shopname']=$shopname;
				$data['shopid']=$refshopid;
				$data['yearmonth']=$day;
				$data['cgrate']=$cgrate;
				$data['sumrate']=$sumrate;
				$data['cgmoney']=$cgmoney;
				$data['createtime']=date ( "Y-m-d H:i:s", strtotime ( 'now' ) );
				$username=$_SESSION['username'];
				$data['username']=$username;
				$data['status']=$status;
				$data['calday']=$calday;
				$data['summonthmoney']=$summonthmoney;
				$data['sumcgmonthmoney']=$sumcgmonthmoney;
				$data['plan']=$plan;
				$data['lzcgplan']=$lzcgplan;
				//var_dump($data);
				if($updateid!=0){
					$data['updatetime']=date ( "Y-m-d H:i:s", strtotime ( 'now' ) );
					if($pai==2 and $status==1){//没问题的
						$data['paichustatus']=1;
					}else if($pai==2 and $status==0){//傻逼的最后一天
						$data['paichustatus']=0;
					}else{
						$data['paichustatus']=null;//其他
					}
					$isexist1=M('qingmu.timer', 'oa')->where('id='.$updateid)->save($data);
					$isexist1=M('qingmu.timer', 'oa')->where('id='.$updateid)->find();
					$lastyear1=explode('-', $day);
					$lastyear2=$lastyear1[0]-1;
					$lastyear=$lastyear2.'-'.$lastyear1[1];
					$qunian=M('qingmu.timer', 'oa')->where(array('shopid'=>$refshopid,'yearmonth'=>$lastyear))->find();
					if($qunian){
						$isexist1['qcgmoney']=$qunian['cgmoney'];
						$isexist1['qcgrate']=$qunian['cgrate'];
						$isexist1['qsumrate']=$qunian['sumrate'];
					}else{
						$isexist1['qcgmoney']='none';
						$isexist1['qcgrate']='none';
						$isexist1['qsumrate']='none';
					}
					$rows[]=$isexist1;
				}else{
					$isexist1=M('qingmu.timer', 'oa')->add($data);
					$isexist2=M('qingmu.timer', 'oa')->where(array('yearmonth'=>$day,'shopname'=>$shopname))->find();
					$lastyear1=explode('-', $day);
					$lastyear2=$lastyear1[0]-1;
					$lastyear=$lastyear2.'-'.$lastyear1[1];
					$qunian=M('qingmu.timer', 'oa')->where(array('shopid'=>$refshopid,'yearmonth'=>$lastyear))->find();
					if($qunian){
						$isexist2['qcgmoney']=$qunian['cgmoney'];
						$isexist2['qcgrate']=$qunian['cgrate'];
						$isexist2['qsumrate']=$qunian['sumrate'];
					}else{
						$isexist2['qcgmoney']='none';
						$isexist2['qcgrate']='none';
						$isexist2['qsumrate']='none';
					}
					$rows[]=$isexist2;
				}
				
				/***************保护对象******************/
				
			}
// 			var_dump($day);
		}
// 		$temp=var_dump($daylength);
 		$datajinhan ['total'] = count($rows);
		$datajinhan ['rows'] = $rows;
		$this->ajaxReturn($datajinhan); 
		
	}
	
	
	public function exportExcel($expTitle,$expCellName,$expTableData){
		$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
		$fileName = $title.$expTitle.date('YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
		$cellNum = count($expCellName);
		$dataNum = count($expTableData);
		vendor("PHPExcel");
		$objPHPExcel = new \PHPExcel();
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		//合并
		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
		//标题
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
		//背景色
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB(\PHPExcel_Style_Color::COLOR_DARKRED);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
		for($i=0;$i<$cellNum;$i++){
			//宽度
			$objPHPExcel->getActiveSheet()->getStyle($cellName[$i].'2')->getFill()->getStartColor()->setARGB(\PHPExcel_Style_Color::COLOR_DARKRED);
			$objPHPExcel->getActiveSheet()->getColumnDimension($cellName[$i])->setWidth(15);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
		}
		// Miscellaneous glyphs, UTF-8
		for($i=0;$i<$dataNum;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet()->getStyle($cellName[$j].($i+3))->getFont()->setSize(11);
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
			}
		}
	
		header('pragma:public');
		header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
		header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
	
	
	function exportdata(){
		$refshopid=I('refshopid','');
		$day=I('day','');
		$dayarray=explode('-', $day);
		$year=$dayarray[0];
		$month=$dayarray[1];
		$bt=$day.'-01';
		switch ($month) {
			case '01' :
			case '03' :
			case '05' :
			case '07' :
			case '08' :
			case '10' :
			case '12' :
				$et=$day.'-31';
				break;
			case '04' :
			case '06' :
			case '09' :
			case '11' :
				$et=$day.'-30';
				break;
			case '02' :
				if (( $year % 100 == 0 and $year % 400 == 0) or ($year % 100 != 0 and $year % 4 == 0)) {
					$et=$day.'-29';
				} else {
					$et=$day.'-28';
				}
		}
		
		$db = M ( 'shopdata', 'stat', C('qingmu') );
		$sql = "refshopid=" . $refshopid . " and STR_TO_DATE(statDay,'%Y-%m-%d') between '" . $bt . "' and '" . $et . "'";
		$rows = $db->where ( $sql )->order ( "STR_TO_DATE(statDay,'%Y-%m-%d')" )->select ();
		foreach ( $rows as &$row ) {
			$shopid = $row ['refshopid'];
			$shop = M ( 'shop', 'ref', C('qingmu') )->where ( array (
					'id' => $shopid
			) )->find ();
			if ($shop) {
				//高级搞笑版
				$jinhan=$shop ['sname'];
				$row ['refshopid'] = $shop ['sname'];
			}
			// 鐩爣寮�
			//
			$time = $row ['statday'];
			$timez = explode ( '-', $time );
			$time1 = $timez [0] . '-' . $timez [1];
			$mubiao = M ( 'sellplan', 'stat', C('qingmu') )->where ( "refshopid=" . $shopid . " and pmonth='" . $time1 . "'" )->find ();
			if ($mubiao) {
				$row ['plan'] = $mubiao ['plan'];
				switch ($timez [1]) {
					case '01' :
					case '03' :
					case '05' :
					case '07' :
					case '08' :
					case '10' :
					case '12' :
						$row ['dayplan'] = ( float ) $row ['plan'] / 31;
						break;
					case '04' :
					case '06' :
					case '09' :
					case '11' :
						$row ['dayplan'] = ( float ) $row ['plan'] / 30;
						break;
					case '02' :
						if ((( int ) $timez [0] % 100 == 0 and ( int ) $timez [0] % 400 == 0) or (( int ) $timez [0] % 100 != 0 and ( int ) $timez [0] % 4 == 0)) {
							$row ['dayplan'] = ( float ) $row ['plan'] / 29;
						} else {
							$row ['dayplan'] = ( float ) $row ['plan'] / 28;
						}
				}
				$row ['lzcgplan'] = $mubiao ['lzcgplan'];
				$row ['lzhdplan'] = $mubiao ['lzhdplan'];
				$row ['lzjhsplan'] = $mubiao ['lzjhsplan'];
			} else {
				$row ['plan'] = 0;
				$row ['dayplan'] = 0;
				$row ['lzcgplan'] = 0;
				$row ['lzhdplan'] = 0;
				$row ['lzjhsplan'] = 0;
			}
			$row ['sumday'] = $row ['sumcgmoney'] + $row ['sumhdmoney'] + $row ['sumjhsmoney'];
			$row ['summonth'] = $row ['sumcgmonthmoney'] + $row ['sumhdmonthmoney'] + $row ['sumjhsmonthmoney'];
			$row ['dayplanrate'] = $row ['sumday'] / $row ['dayplan'];
			$row ['monthplanrate'] = $row ['summonth'] / $row ['plan'];
			$row ['monthcgplanrate'] = $row ['sumcgmonthmoney'] / $row ['lzcgplan']; // 甯歌瀹屾垚鐜�
			$row ['monthhdplanrate'] = $row ['sumhdmonthmoney'] / $row ['lzhdplan'];
			$row ['monthjhsplanrate'] = $row ['sumjhsmonthmoney'] / $row ['lzjhsplan'];
		}
		$xlsName  = $jinhan.$day."数据";
		$xlsCell  = array(
				//array('refshopid','店铺名'),
				array('statday','时间'),
				array('sumday','日累计（总体）'),
				array('dayplan','日目标（总体）'),
				array('dayplanrate','日完成率（总体）'),
				array('summonth','月累计（总体）'),
				array('plan','月目标（总体）'),
				array('monthplanrate','月完成率（总体）！！'),
				array('sumcgmonthmoney','月累计（常规）'),
				array('lzcgplan','月目标（常规）'),
				array('monthcgplanrate','月完成率(常规)！！'),
				array('sumhdmonthmoney','月累计（活动）'),
				array('lzhdplan','月目标（活动）'),
				array('monthhdplanrate','月完成率(活动)！！'),
				array('sumjhsmonthmoney','月累计（聚划算）'),
				array('lzjhsplan','月目标（聚划算）'),
				array('monthjhsplanrate','月完成率(聚划算)！！'),
				array('sumcgmoney','日成交额（常规）'),
				array('sumhdmoney','日成交额（活动）'),
				array('sumjhsmoney','日成交额（聚划算）')
		);
		foreach ($rows as $k => $v)
		{
			$rows[$k]['dayplanrate']=round($v['dayplanrate']*100,2). "%";
			$rows[$k]['monthplanrate']=round($v['monthplanrate']*100,2). "%";
			$rows[$k]['monthcgplanrate']=round($v['monthcgplanrate']*100,2). "%";
			$rows[$k]['monthhdplanrate']=round($v['monthhdplanrate']*100,2). "%";
			$rows[$k]['monthjhsplanrate']=round($v['monthjhsplanrate']*100,2). "%";
		}
		$this->exportExcel($xlsName,$xlsCell,$rows);
	}
	
	
	function pai(){
		//44,2013-04-01,2013-04-02
		$pai=I('pai','');
		$sb=explode(',', $pai);
		$id=$sb[0];
		$paichu='';
		for($i=1;$i<count($sb)-1;$i++){
			$day=explode('-', $sb[$i]);
			$paichu=$paichu.$day[2].',';
		}
		$lastday=explode('-', $sb[count($sb)-1]);
		$paichu=$paichu.$lastday[2];
		$data['paichushijian']=$paichu;
		$data['paichustatus']=0;
		$isexist=M('qingmu.timer', 'oa')->where(array('id'=>$id))->save($data);
		if($isexist){
			$this->ajaxReturn('排除设置成功,但还没有激活，请注意聚划算已默认排除，只需排除常规，谨慎操作');
		}else{
			$this->ajaxReturn('排除设置失败');
		}
	}
	
	function delete(){
		$id=I('id','');
		if(M('qingmu.timer', 'oa')->where(array('id'=>$id))->delete()){
		$this->ajaxReturn('删除成功');
		}
		else{
		$this->ajaxReturn('删除失败');
			}
		}
		
		function forecast(){
			$s=I('l','');
			$this->assign('name',$s);
			$this->display();
		}
		function forecasts(){
			$a=I('ab',0.5);
			$s=I('l','');
			//傻逼一个，要预测这个
			$rows=array();
			$sb=explode(',', $s);
			foreach ($sb as $id){
			$data=M('qingmu.timer', 'oa')->where(array('id'=>$id))->find();
			if($data){
				$rows[]=$data;
			}
			}
			if(count($rows)<=3){
				$this->ajaxReturn('num too less');
				return;
			}
			//数据量个数
			$size=count($rows);
			$rows[$size]=array();
			//一次指数初始值
			$yi[0]=($rows[0]['cgmoney']+$rows[1]['cgmoney']+$rows[2]['cgmoney'])/3;
			$rows[0]['yi']=$yi[0];
			//二次指数初始值
			$er[0]=($rows[0]['cgmoney']+$rows[1]['cgmoney']+$rows[2]['cgmoney'])/3;
			$rows[0]['er']=$er[0];
			//预测值
			$yu[0]='none';
			$yu[1]=$er[0];
			$rows[0]['yu']=$yu[0];
			$rows[1]['yu']=$yu[1];
			//误差
			$err[0]='none';
			$rows[0]['err']=$err[0];
			$err[1]=abs($yu[1]-$rows[1]['cgmoney']);
			$rows[1]['err']=$err[1];
			
			//一次指数开始
			for($i=1;$i<$size;$i++){
				$yi[$i]=$rows[$i]['cgmoney']*$a+$yi[$i-1]*(1-$a);
				$rows[$i]['yi']=$yi[$i];
			}
			//二次指数开始
			for($i=1;$i<$size;$i++){
				$er[$i]=$yi[$i]*$a+$er[$i-1]*(1-$a);
				$rows[$i]['er']=$er[$i];
			}
			//预测开始
			for($i=1;$i<$size;$i++){
				$yu[$i+1]=2*$yi[$i]-$er[$i]+($a/(1-$a))*($yi[$i]-$er[$i]);
				$err[$i+1]=abs($rows[$i+1]['cgmoney']-$yu[$i+1]);
				$rows[$i+1]['yu']=$yu[$i+1];
				if($i+1==$size){
					
				}else{	
				$rows[$i+1]['err']=$err[$i+1];}
			}
			$data1 ['total'] = count($rows);
			$rows[$size]['shopname']='预测值';
			for($i=0;$i<$size;$i++){
				$day=$rows[$i]['yearmonth'];
				$refshopid=$rows[$i]['shopid'];
				$lastyear1=explode('-', $day);
				$lastyear2=$lastyear1[0]-1;
				$lastyear=$lastyear2.'-'.$lastyear1[1];
				$qunian=M('qingmu.timer', 'oa')->where(array('shopid'=>$refshopid,'yearmonth'=>$lastyear))->find();
				if($qunian){
					$rows[$i]['qcgmoney']=$qunian['cgmoney'];
					$rows[$i]['qcgrate']=$qunian['cgrate'];
					$rows[$i]['qsumrate']=$qunian['sumrate'];
				}else{
					$rows[$i]['qcgmoney']='none';
					$rows[$i]['qcgrate']='none';
					$rows[$i]['qsumrate']='none';
				}
			}
			$data1 ['rows'] = $rows;
			$this->ajaxReturn($data1);
			//var_dump($sb);
		}
		function forecastss(){
			$a=I('ab',0.5);
			$s=I('l','');
			//傻逼一个，要预测这个
			$rows=array();
			$sb=explode(',', $s);
			foreach ($sb as $id){
				$data=M('qingmu.timer', 'oa')->where(array('id'=>$id))->find();
				if($data){
					$rows[]=$data;
				}
			}
			if(count($rows)<=3){
				$this->ajaxReturn('num too less');
				return;
			}
						//数据量个数
			$size=count($rows);
			$rows[$size]=array();
			//一次指数初始值
			$yi[0]=($rows[0]['cgmoney']+$rows[1]['cgmoney']+$rows[2]['cgmoney'])/3;
			$rows[0]['yi']=$yi[0];
			//二次指数初始值
			$er[0]=($rows[0]['cgmoney']+$rows[1]['cgmoney']+$rows[2]['cgmoney'])/3;
			$rows[0]['er']=$er[0];
			//预测值
			$yu[0]='none';
			$yu[1]=$er[0];
			$rows[0]['yu']=$yu[0];
			$rows[1]['yu']=$yu[1];
			//误差
			$err[0]='none';
			$rows[0]['err']=$err[0];
			$err[1]=abs($yu[1]-$rows[1]['cgmoney']);
			$rows[1]['err']=$err[1];
			//一次指数开始
			for($i=1;$i<$size;$i++){
				$yi[$i]=$rows[$i]['cgmoney']*$a+$yi[$i-1]*(1-$a);
				$rows[$i]['yi']=$yi[$i];
			}
			//二次指数开始
			for($i=1;$i<$size;$i++){
				$er[$i]=$yi[$i]*$a+$er[$i-1]*(1-$a);
				$rows[$i]['er']=$er[$i];
			}
			//预测开始
			for($i=1;$i<$size;$i++){
				$yu[$i+1]=2*$yi[$i]-$er[$i]+($a/(1-$a))*($yi[$i]-$er[$i]);
				$err[$i+1]=abs($rows[$i+1]['cgmoney']-$yu[$i+1]);
				$rows[$i+1]['yu']=$yu[$i+1];
				if($i+1==$size){
						
				}else{
					$rows[$i+1]['err']=$err[$i+1];}
			}
			$rows[$size]['shopname']='预测值';
			$rows[$size]['yearmonth']=$a;
			$xlsName  = $rows[1]['shopname'];
			$xlsCell  = array(
					//array('refshopid','店铺名'),
					array('yearmonth','日期'),
					array('shopname','店铺'),
					array('cgmoney','日成交额（常规）'),
					array('yu','预测值'),
					array('yi','一次指数平滑'),
					array('er','二次指数平滑'),
					array('err','绝对误差')
			);
		/* 	foreach ($rows as $k => $v)
			{
				$rows[$k]['dayplanrate']=round($v['dayplanrate']*100,2). "%";
				$rows[$k]['monthplanrate']=round($v['monthplanrate']*100,2). "%";
				$rows[$k]['monthcgplanrate']=round($v['monthcgplanrate']*100,2). "%";
				$rows[$k]['monthhdplanrate']=round($v['monthhdplanrate']*100,2). "%";
				$rows[$k]['monthjhsplanrate']=round($v['monthjhsplanrate']*100,2). "%";
			} */
			$this->exportExcel($xlsName,$xlsCell,$rows);
			
			//var_dump($sb);
		}
}