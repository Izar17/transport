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
	function save_booking(){
		extract($_POST);
		$data = "";
		$sql = "INSERT INTO `booking` set {$data} ";
		$result = "";

		$save = $this->conn->query($sql);
		if($save){
			$result = "success"
		}
	
		return json_encode("success");
	}
	function delete_shop_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `shop_type_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Shop Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

}

$Booking = new Booking();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_booking':
		echo $Booking->save_booking();
	break;
	case 'delete_shop_type':
		echo $Booking->delete_shop_type();
	break;
	default:
		// echo $sysset->index();
		break;
}