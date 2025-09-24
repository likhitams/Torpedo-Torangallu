<?php

class main_model extends CI_Model{

	public function __construct(){
		parent::__construct();		
	}
	public function manRes($query,$db="default")
	{
		$db_con = $this->load->database($db, TRUE);
		$query  = $db_con->query($query);
		return $query->result();
	}

	public function manRow($query,$db="default")
	{
		$db_con = $this->load->database($db, TRUE);
		$query  = $db_con->query($query);
		return $query->row();
	}

	public function insertInto($table,$in_data,$db="default")
	{
		$db_con = $this->load->database($db, TRUE);
		$in_data = preg_replace("/\s+/", " ", $in_data);
		$query  = $db_con->insert($table,$in_data);
		return $db_con->insert_id();
	}	
	
	public function multiInsert($table,$in_data,$db="default")
	{
		if($in_data)
		{
			foreach($in_data as $ind=>$arr)
			{
				$in_data[$ind] = preg_replace("/\s+/", " ", $arr);				
			}
		}
		$db_con = $this->load->database($db, TRUE);
		$query  = $db_con->insert_batch($table,$in_data);
		return $db_con->insert_id();
	}

	public function updateWhere($table,$up_data,$where,$db="default")
	{
		$up_data = preg_replace("/\s+/", " ", $up_data);
		$db_con = $this->load->database($db, TRUE);
		$db_con->where($where);
		$db_con->update($table,$up_data);
		return $db_con->affected_rows();
	}

	public function rowByPaginate($query,$order_by,$order_by_arr,$db="default")
	{
        if(isset($_POST["order"]))
        {
			if($_POST['order']['0']['column']!="0")
			{
				$col_index = $_POST['order']['0']['column'];
				if(isset($order_by_arr[$col_index]))
				{
					$order_by = " order by ".$order_by_arr[$col_index]." ".$_POST['order']['0']['dir'];
				}
			}
			if($_POST['order']['0']['column']==0)
			{
				//$order_by = " order by ".$order_by_arr[$_POST['order']['0']['column']]." desc";
			}
        }
		
		$limit = "0,10";
		$limit = "";
        if($_POST["length"] != -1)
        {
            $limit = " limit {$_POST['length']}";
            if($_POST['start'] > 0){
                $limit = " limit {$_POST['start']}, {$_POST['length']}";
            }
        }
        $query = $this->db->query($query.$order_by.$limit);
		
        return $query->result();
	}	


	public function rows_by_paginations_new($query,$order_by,$order_by_arr,$db="default")
	{
        $db_con = $this->load->database($db, TRUE);
        if(isset($_POST["order"]))
        {
			if($_POST['order']['0']['column']!="0")
			{
				$col_index = $_POST['order']['0']['column'];
				if(isset($order_by_arr[$col_index]))
				{
					$order_by = " order by ".$order_by_arr[$col_index]." ".$_POST['order']['0']['dir'];
				}
			}
			if($_POST['order']['0']['column']==0)
			{
				//$order_by = " order by ".$order_by_arr[$_POST['order']['0']['column']]." desc";
			}
        }
		
		$limit = "0,10";
		$limit = "";
        if($_POST["length"] != -1)
        {
            $limit = " limit {$_POST['length']}";
            if($_POST['start'] > 0){
                $limit = " limit {$_POST['start']}, {$_POST['length']}";
            }
        }
        //$query = $this->db->query($query.$order_by.$limit);
		//return $query->result();
        $query  = $db_con->query($query.$order_by.$limit);
        return $query->result();
	}	
	
	public function runQuery($query,$db="default")
	{
		$db_con = $this->load->database($db, TRUE);
		$query  = $db_con->query($query);
		return $db_con->affected_rows();
	}

	
	public function deleteWhere($table,$where,$db="default")
	{
		$db_con = $this->load->database($db, TRUE);
		$db_con->where($where);
		$db_con->delete($table);
		return $db_con->affected_rows();
	}
	
	public function copy_paste_row($from_table,$to_table,$where,$skip_update=0,$db="default")
	{
		$db_con = $this->load->database($db, TRUE);
		$db_con->select('*');
		$db_con->where($where);
		$query = $db_con->get($from_table);
		if($query !== false) {
			$rdata = $query->row();
			$query = $db_con->insert($to_table,$rdata);
			$res = $db_con->affected_rows();
			if($res && $skip_update==0)
			{
				$db_con->where($where);
				$db_con->update($from_table,array("is_live"=>1));
			}
			return $res;
		}else {
		   return -1;
		}
	}
	
	public function getRow($table,$where,$columns="*",$db='default')
	{
		$db_con = $this->load->database($db, TRUE);
		$db_con->select($columns);
		$db_con->where($where);
		$query  = $db_con->get($table);
		return $query->row();
	}	

	public function getRes($table,$where,$columns="*",$order_by=array(),$limit=0,$db='default')
	{
		$db_con = $this->load->database($db, TRUE);
		$db_con->select($columns);
		$db_con->where($where);
		if($order_by)
		{
			$db_con->order_by($order_by[0],$order_by[1]);
		}
		if($limit)
		{
			$db_con->limit($limit);
		}
		$query  = $db_con->get($table);
		return $query->result();
	}

	public function update_status($type,$id,$status)
	{
		$type_arr['video']['table']    = "videos";
		$type_arr['video']['id_col']   = "pk_videos";
		$type_arr['video']['status_col'] = "status";
		
		$type_arr['voucher']['table']      = "vouchers";
		$type_arr['voucher']['id_col']     = "pk_vouchers";
		$type_arr['voucher']['status_col'] = "status";
		
		$type_arr['ad_banner']['table']  = "ad_banners";
		$type_arr['ad_banner']['id_col'] = "pk_ad_banners";
		$type_arr['ad_banner']['status_col'] = "status";	

		if(isset($type_arr[$type]))
		{
			$table  = $type_arr[$type]['table'];
			$s_col  = $type_arr[$type]['status_col'];
			$i_col  = $type_arr[$type]['id_col'];
			
			$upData = $where = array();
			
			$upData[$s_col] = $status;
			$where[$i_col]  = $id;
			
			return $this->update_where($table,$upData,$where);			
		}else{
			return -1;
		}
	}	

	public function update_elearning_status($type,$id,$status)
	{
		$type_arr['video']['table']    = "elearning_videos";
		$type_arr['video']['id_col']   = "pk_videos";
		$type_arr['video']['status_col'] = "status";
		
		

		if(isset($type_arr[$type]))
		{
			$table  = $type_arr[$type]['table'];
			$s_col  = $type_arr[$type]['status_col'];
			$i_col  = $type_arr[$type]['id_col'];
			
			$upData = $where = array();
			
			$upData[$s_col] = $status;
			$where[$i_col]  = $id;
			
			return $this->update_where($table,$upData,$where);			
		}else{
			return -1;
		}
	}	
	
	public function rowByJoin($table,$where,$columns="*",$join_arr=array(),$db='default')
	{
		$db_con = $this->load->database($db, TRUE);
		$db_con->select($columns);
		$db_con->from($table);
		$db_con->where($where);
		if($join_arr)
		{
			foreach($join_arr as $ar)
			{
				$db_con->join($ar['table'], $ar['on']);
			}		
		}		
		$query  = $db_con->get();
		return $query->row();
	}	

	public function resByJoin($table,$where,$columns="*",$join_arr=array(),$order_by=array(),$limit=0,$db='default')
	{
		$db_con = $this->load->database($db, TRUE);
		$db_con->select($columns);
		$db_con->from($table);
		
		if($join_arr)
		{
			foreach($join_arr as $ar)
			{
				$db_con->join($ar['table'], $ar['on'],$ar['type']);
			}		
		}
		$db_con->where($where);
		if($order_by)
		{
			$db_con->order_by($order_by[0],$order_by[1]);
		}
		if($limit)
		{
			$db_con->limit($limit);
		}
		$query  = $db_con->get();
		return $query->result();
	}	
}
