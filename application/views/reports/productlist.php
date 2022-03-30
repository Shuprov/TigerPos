<?php $this->load->view("partial/header"); 
  $this->load->database(); 
?>

<form name="" action="" method="post">
<input type="text" name="uu" value=""/>
<input type="submit"/>
</form>

<?php 
echo $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
$this->db->select('username');
$this->db->from('ospos_employees');
$this->db->where('person_id',1);
echo $query=$this->db->get();

$this->load->view("partial/footer"); ?>

