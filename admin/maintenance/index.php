<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>

	.dataTables_wrapper .top {
    display: flex;
    justify-content: space-between; /* Ensures spacing */
    align-items: center;
    margin-bottom: 10px; /* Adjust spacing */
}

</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Maintenance</h3>
		<div class="card-tools">
		<label for="codeFilter">Code:</label>
			<select id="codeFilter">
				<option></option>
				<option value="MODE OF TRANSFER">MODE OF TRANSFER</option>
				<option value="PAYMENT TYPE">PAYMENT TYPE</option>
				<option value="ORIGIN PICK-UP & DROP OFF">ORIGIN PICK-UP & DROP OFF</option>
				<option value="AIRPORT">AIRPORT</option>
				<option value="HOTEL/RESORT">HOTEL/RESORT</option>
				<option value="RANSFER CHARGE">TRANSFER CHARGE</option>
			</select>
			<a href="?page=maintenance/manage_reference" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-bordered table-striped" style="font-size: 12px;">
				<colgroup>
					<col width="3%">
					<col width="10%">
					<col width="20%">
					<col width="30%">
					<col width="30%">
					<col width="7%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Transfer Type</th>
						<th>Code</th>
						<th>Title</th>
						<th>Description</th>
						<th>Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						$qry = $conn->query("SELECT * from reference_table");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td>
								<?php 
										switch($row['type']){
											case 1:
												echo 'ARRIVAL';
												break;
											case 2:
												echo 'DEPARTURE';
												break;
											case 3:
												echo 'ROUNDTRIP';
												break;
											default:
												break;
												echo '';
												break;
										}
									?>
							</td>
							<td ><p class="m-0 truncate-1">
								<?php 
									switch($row['code']){
										case 'MOT':
											echo 'MODE OF TRANSFER';
											break;
										case 'PT':
											echo 'PAYMENT TYPE';
											break;
										case 'ODL':
											echo 'ORIGIN PICK-UP & DROP OFF';
											break;
										case 'AP':
											echo 'AIRPORT';
											break;
										case 'HR':
											echo 'HOTEL/RESORT';
											break;
										case 'TC':
											echo 'TRANSFER CHARGE';
											break;
										default:
											break;
											echo '';
											break;
									}
								?>
							</p></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['title'] ?></p></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['description'] ?></p></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['amount'] ?></p></td>
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
								<!-- <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
									<span class="fa fa-trash text-danger"></span> Delete
								</a> -->
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
		
		
    // Initialize DataTable		
	var table = $('.table').DataTable({
		dom: '<"top"lBf>rt<"bottom"ip>',
		paging: true,
		info: true,
		lengthChange: true, // Ensures dropdown is enabled
		lengthMenu: [ [25, 50, 100, -1], [25, 50, 100, "All"] ],
		pageLength: 25
	});

		
		$('#codeFilter').on('change', function () {
			table.column(2).search(this.value).draw(); 
		});
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