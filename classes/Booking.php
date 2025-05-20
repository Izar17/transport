<?php
require_once('../config.php');
Class Booking extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}

	function get_seq_no() {

		$query = "SELECT MAX(reserve_num) as max_reserve FROM booking";
		$result = $this->conn->query($query);

		// Array to store the data
		$data = 0;

		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			if (!empty($row['max_reserve'])) {
				$data = $row['max_reserve'];
			}
		}

		echo $data;
	}

	function get_reference_table() {
		// SQL query to fetch specific fields (e.g., 'id' and 'product_name')
		$query = "SELECT type, code, title, description, amount, price_guest_1, price_guest_2, price_guest_3, price_guest_4, price_guest_5, price_guest_6, price_guest_7, price_guest_8, 
		price_guest_1_terminal, price_guest_1_environment,
		price_guest_2_terminal, price_guest_2_environment,
		price_guest_3_terminal, price_guest_3_environment,
		price_guest_4_terminal, price_guest_4_environment,
		price_guest_5_terminal, price_guest_5_environment,
		price_guest_6_terminal, price_guest_6_environment,
		price_guest_7_terminal, price_guest_7_environment,
		price_guest_8_terminal, price_guest_8_environment
		FROM reference_table";
		$result = $this->conn->query($query);

		// Array to store the data
		$data = [];

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;  // Store each row in the array
			}
		}

		echo json_encode($data);

		// Close the connection
		// $conn->close();
	}

	function save_booking() {
		extract($_POST);
		$data = '';
		
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}  

		// $data .= (!empty($data) ? "," : "");
		// $data .= " `created_date`=NOW()";

		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO booking set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','Booking Transfer successfully saved.');
				
				return 1;
			}else{
				return 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE booking set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','Booking Transfer successfully updated.');
				return 1;
			}else{
				return 2;
			}
		}
	}

	public function paid_booking(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `booking` set status = 2, updated_by = '$user' where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Booking has been successfully marked as paid!");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	
	public function cancel_booking(){
		extract($_POST);
		// $updated_by = $_settings->userdata('lastname');
		$del = $this->conn->query("UPDATE `booking` set delete_flag = 1, status = 3, status_remarks = '$reason', updated_by = '$user' where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Booking successfully cancelled!");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_driver(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `booking` set `driver_name` = '{$driver_name}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Driver has been successfully assigned.";
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = " Driver assign has failed to update.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

}

$Booking = new Booking();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'get_seq_no':
		echo $Booking->get_seq_no();
	break;
	case 'get_reference_table':
		echo $Booking->get_reference_table();
	break;
	case 'save_booking':
		echo $Booking->save_booking();
	break;
	case 'paid_booking':
		echo $Booking->paid_booking();
	break;
	case 'cancel_booking':
		echo $Booking->cancel_booking();
	break;
	case 'update_driver':
		echo $Booking->update_driver();
	default:
		// echo $sysset->index();
		break;
}