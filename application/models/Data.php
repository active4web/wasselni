<?php







class Data extends CI_Model{















	public function login($username,$password){







	$this->db->where('password',$password);	







		$query=$this->db->get('client');	







		return $query->result();







		







	}


	
	public function get_sql($table,$where=array(),$order_field=null,$order_type=null)
	{
			if($where)
			$this->db->where($where);
			if($order_field)
			$this->db->order_by($order_field,$order_type);
			$query = $this->db->get($table);
			$query->result();
			return $this->db->last_query();
	}



	  public function fetch_news($limit, $start) {



        $this->db->limit($limit, $start);



        $query = $this->db->get("news");







        if ($query->num_rows() > 0) {



            foreach ($query->result() as $row) {



                $data[] = $row;



            }



            return $data;



        }



        return false;



   }







	////////////////////////////////////// Start Category




function get_price($table,$where)
{
	$this->db->where($where);
	$query = $this->db->get($table);
	return $query->result();
}

function get_table_data($table,$where=array(),$limit=null,$order_field=null,$order_type=null)







	{







		$this->db->where($where);	







		if($limit)







		$this->db->limit($limit);







		if($order_field)







		$this->db->order_by($order_field,$order_type);







		$query = $this->db->get($table);







		return $query->result();







	}



	function get_product()







	{











		$query = $this->db->get();







		return $query->result();







	}







								/*************************************************/







	function get_table_row($table,$where=array(),$filed=null)







	{







		$query = $this->db->get_where($table,$where);







		foreach($query->result() as $row){







		return $row->$filed;	







		}







	}







								/*************************************************/







	function record_count($table,$where=array()) {

		$this->db->where($where);

		$this->db->from($table);

		return $this->db->count_all_results();

    }







								/*************************************************/







function view_all_data($table, $where, $limit,$start,$order,$by) {

 $this->db->limit($limit, $start);

$this->db->where($where);

$this->db->order_by($order,$by);

$query = $this->db->get($table);

if ($query->num_rows() > 0) {

foreach ($query->result() as $row) { $data[] = $row; }

 return $data; }

 return false;

}







								/*************************************************/







	function edit_last_login($table,$id,$data)







	{







		$this->db->set($data);	







		$this->db->where('id',$id);







		$this->db->update($table);







		return true;







	}







								/*************************************************/







	function sum_cash_bank($id,$type)







	{







	$query = $this->db->select_sum('cash_money', 'Cash_money');







	$query = $this->db->where('type',$type);







	$query = $this->db->where('customer_id',$id);







	$query = $this->db->get('cash_type');







	$result = $query->result();







	return $result[0]->Cash_money;







	}







								/*************************************************/







	







								/*************************************************/







	function add_regiaster($data)







	{







		$table = "client";







		$this->db->set($data);







		$this->db->insert($table,$data);







		return true;	







	}







								/*************************************************/















































	function message($data)







	{







		$table = "client_message";







		$this->db->set($data);







		$this->db->insert($table,$data);







		return true;	







	}







	/*************************************************/























































	function get_client()







	{







	$this->db->select('id');







            $this->db->from('client');







            return $this->db->get()->result();







	}







function edit_table($table,$id,$data)
	{
		$this->db->set($data);	
		$this->db->where('id',$id);
		$this->db->update($table);
		return true;
	}



	function edit_table_id($table,$where=array(),$data)
	{
		$this->db->set($data);	
		$this->db->where($where);;
		$this->db->update($table);
		return true;
	}



function delete_table_row($table,$where=array())







	{







$query = $this->db->where($where);







$this -> db -> delete($table);







return "true";







	}	







public function insert_filed($table,$data){







$this->db->set($data);







$this->db->insert($table,$data);







return true;	







}







function hide_message($id)







	{







    $this->db->where("id",$id);



    



    $this->db->update("messages",array('r_view' => 0));







return true;







	}	



 function getNameClient($id)







 	{







    $this->db->query('fname','mail');



 	$this->db->from('client');



 	$this->db->join('messages',  $id.'= client.id');



 	$query = $this->db->get()->result();



 	return $query;







 	}	



	



	public function getjoin($select,$table,$jointable,$where)



	{



		$this->db->select($select);



		$this->db->from($table);



		foreach($jointable as $join => $on)



		{



			$this->db->join($join, $on);



		}



		foreach($where as $key => $value)



		{



			$this->db->where($key, $value);



		}



		$query = $this->db->get();



		return $query->result();



	}

}







?>