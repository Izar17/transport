<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Maintenance</h3>
		<div class="card-tools">
			<a href="?page=booking" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">

			<table class="table table-bordered table-striped" style="font-size: 12px;">
				<!-- <colgroup>
					<col width="3%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="7%">
				</colgroup> -->
				<thead>
					<tr>
						<th width="2%">#</th>
						<th>RESERVATION NO.</th>
						<th>NAME</th>
						<th>CONTACT NO.</th>
						<th>EMAIL</th>
						<th>TRANSFER TYPE</th>
						<th>MODE OF TRANSFER</th>
						<th>PICK-UP & DROP OFF</th>
						<th>DATE</th>
						<th>ETA</th>
						<th>AIRPORT & FLIGHT</th>
						<th>HOTEL/RESORT</th>
						<th>OTHER NAMES</th>
						<th>PAYMENT TYPE</th>
						<th width="3%">ACTION</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						$qry = $conn->query("SELECT * from booking");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['reserve_num'] ?></td>
							<td><?php echo $row['last_name'] .','. $row['first_name']; ?></td>
							<td><?php echo $row['contact_no'] ?></td>
							<td ><?php echo $row['email_address'] ?></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['transfer_type'] ?></p></td>
							<td ><?php echo $row['transfer_mode'] ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><?php echo $row['other_names'] ?></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['payment_type'] ?></p></td>
							<td>
							<style>
							.small-button {
								height: 18px;
								padding: 5px 10px; /* Adjust padding to control spacing */
								font-size: 10px; /* Make text smaller */
								display: flex;
								align-items: center;
								justify-content: center;
							}
							</style>

							<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon small-button" data-toggle="dropdown">
								Action &nbsp;
								<span class="sr-only">Toggle Dropdown</span>
							</button>

							<div class="dropdown-menu" role="menu">
								<a class="dropdown-item" href="?page=maintenance/manage_reference&id=<?php echo $row['id'] ?>">
									<span class="fa fa-edit text-primary"></span> Edit
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
									<span class="fa fa-trash text-danger"></span> Delete
								</a>
							</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this User permanently?","delete_reference",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_reference($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Maintenance.php?f=delete",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>