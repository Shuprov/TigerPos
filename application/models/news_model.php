<?php

class news_model extends CI_Model {
public function __construct()	{
  $this->load->database(); 
}

public function get_news($id) {
  if($id != FALSE) {
    $query = $this->db->get_where('ospos_employees', array('person_id' => $id));
    return $query->row_array();
  }
  else {
    return FALSE;
  }
}


}

?>