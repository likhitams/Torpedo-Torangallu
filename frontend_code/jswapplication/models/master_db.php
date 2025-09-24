<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master_db extends CI_Model{
	
		public function create_unique_slug($string,$table,$field,$key=NULL,$value=NULL)
		{
			$t =& get_instance();
			$slug = url_title($string);
			$slug = strtolower($slug);
			$i = 0;
			$params = array ();
			$params[$field] = $slug;
		
			if($key)$params["$key !="] = $value;
		
			while ($t->db->where($params)->get($table)->num_rows())
			{
				if (!preg_match ('/-{1}[0-9]+$/', $slug ))
					$slug .= '-' . ++$i;
				else
					$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
				 
				$params [$field] = $slug;
			}
			return $slug;
		}
		
		function getnumberformat($num){
			return str_replace(".00", "", (string)number_format((float)$num, 2, '.', ','));
		}
		
	
	function countRec($fname,$tname,$where)
    {
        $sql = "SELECT * FROM $tname $where";

        $q=$this->db->query($sql);

        return $q->num_rows();
    }
    
    function runsql($fname,$tname,$where){
    	$sql = "SELECT * FROM $tname $where";
    	
    	$q=$this->db->query($sql);
	
			return $q->result();	
    }
	
	function insertRecord($table,$db=array())
    {

        $q=$this->db->insert($table, $db); 

        $total = $this->db->insert_id();

        if($total>0)

        return $total;

        else 

        return 0;

    }
    function insertRecordWithVerify($table,$db,$where)
    {
    	
    	$sql="SELECT * FROM $table WHERE insertdate='$where' and is_delete=0";
    	$q=$this->db->query($sql);
if( $q->num_rows()>0)
{   
	
echo "Data Already Entered today";
    	}
    else {
    	$q=$this->db->insert($table, $db);
    	
    	$total = $this->db->insert_id();
    	
    	if($total>0)
    		return 1;
    		else
    			return 0;
} 
 	
    }
   
    
    function updateRecord($table,$data,$where=array())
    {
    	//$this->db->where($col,$id);
    	$q=$this->db->update($table,$data,$where);
    	$total = $this->db->affected_rows();
    	if($total>0)
    		return 1;
    	else
    		return 0;
    }
	
	function getRecords($table,$db = array(),$select = "*",$ordercol = '',$group = '',$start='',$limit=''){
		$this->db->select($select);
		if(!empty($ordercol)){
			$this->db->order_by($ordercol);
		}
		if($limit != '' && $start !=''){
			$this->db->limit($limit,$start);
		}
		if($group != ''){
			$this->db->group_by($group);
		}
		$q=$this->db->get_where($table, $db);
		return $q->result();
	}
	
	
	
	function changeStatus($table,$db=array())
	{

		$sql="update $table set status=".$db['status']." WHERE id IN ('".$db['items']."')";

        $q=$this->db->query($sql); 

        $total = count(explode(",",$db['items'])); 

        $total = $this->db->affected_rows();

        header("Content-type: application/json");

        $json = "";

        $json .= "{";

        $json .= '"query": "'.$sql.'",';

        $json .= '"total": "'.$total.'"';

        $json .= "}";

        return $json;

	}
	
	function deleterecord($table,$db=array())
	{
		$this->db->delete($table, $db);
	
	}
	
	function truncatetable($table)
	{
		$this->db->truncate($table);
	}
	
	function deleterecordwithimag($table,$col,$id,$imgcol,$imgcol1,$status){
		/*$category = $this->getcontent2($table,$col,$id,'1');
		if(is_array($category)){
			foreach ($category as $c){
				if(!empty($imgcol)){
					unlink('../'.$c->$imgcol);
				}
				if(!empty($imgcol1)){
					unlink('../'.$c->$imgcol1);
				}
			}
		}*/
		$query = $this->db->query("delete from $table where $col ='".$id."' and status=$status");
	}
	
    function runQuery($sql){
    	//echo $sql;
    	$this->db->query($sql);
    }
    
	function runQuerySql($sql){
    	//echo $sql;
    	$q = $this->db->query($sql);
    	return $q->result();
    }
    

}

?>