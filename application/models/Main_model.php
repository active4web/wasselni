<?php

class Main_model extends CI_Model{

 public function insert($table, $data)

    {

        if (empty($table) || empty($data)) {

            return false;

        }else{

            if($this->db->insert($table, $data)){

                return $this->db->insert_id();

            }else{

                return false;

            }

            

        }

    }

public function update($table, $where =NULL, $data = NULL)

    {

        if(empty($where) || empty($data))

            return False;

        $this->db->where($where);

        return $this->db->update($table, $data);



    }

public function delete($table,$where = NULL)

    {

        if (empty($where))

            return FALSE;

        $this->db->where($where);

        return $this->db->delete($table);

    }


}





