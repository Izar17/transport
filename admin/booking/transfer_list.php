<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Transfer List</h3>
		<div class="card-tools">
		<label for="transferFilter">Transfer Type:</label>
			<select id="transferFilter">
				<option value="">All</option>
				<option value="ARRIVAL">ARRIVAL</option>
				<option value="DEPARTURE">DEPARTURE</option>
				<option value="ROUNDTRIP">ROUNDTRIP</option>
			</select>

			<label for="startDate">Start Date:</label>
			<input type="date" id="startDate">
			
			<label for="endDate">End Date:</label>
			<input type="date" id="endDate" style="margin-right:20px;"> 
			<a href="?page=booking" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">

	
			<table id="myTable" class="table table-bordered table-striped display" style="font-size: 10px;">
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
						<th>REF.</th>
						<th>LEAD PAX</th>
						<th>PAX#</th>
						<th>TRANSFER DETAILS</th>
						<th>MODE OF TRANSFER</th>
						<th>OTHER NAMES | REMARKS</th>
						<th>BOOKING INFO</th>
						<th>DATE POSTED</th>
						<th>PAYMENT TYPE</th>
						<th width="3%">ACTION</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						$qry = $conn->query("SELECT * from booking order by id desc");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['reserve_num'] ?></td>
							<td><?php echo $row['last_name'] .','. $row['first_name'] .'<br>'.$row['contact_no'].'<br>'.$row['email_address']; ?></td>
							<td><?php echo array_sum([
									$row['qty_guest_1'],
									$row['qty_guest_2'],
									$row['qty_guest_3'],
									$row['qty_guest_4'],
									$row['qty_guest_5'],
									$row['qty_guest_6'],
									$row['qty_guest_7']
								]); ?>
							</td>
							<td style="width:250px;">
							<?php 
									switch($row['transfer_type']){
										case 1:      
											echo "<b>ARRIVAL";
											echo '<br>'. $row['arr_date'] .' '. $row['arr_eta'] .'</b><br>';
											echo $row['arr_origin_drop_off'] .'<br>';
											echo $row['arr_airport'] . '<br>' . $row['arr_flight_no'].'<br>';
											echo $row['arr_hotel'];
											break;
										case 2:
											echo "<b>DEPARTURE <br>";
											echo '<b>Estimated Pick-up Time: '.$row['est_pickup'].'</b>';
											echo '<br>'. $row['dep_date'] .' '. $row['dep_etd'] .'</b><br>';
											echo $row['dep_origin_drop_off'] .'<br>';
											echo $row['dep_airport'] . '<br>' . $row['dep_flight_no'].'<br>';
											echo $row['dep_hotel'];
											break;
										case 3:
											echo "<b>ROUNDTRIP";
											echo '<br>(ARR) '. $row['arr_date'] .' '. $row['arr_eta'] .'</b><br>';
											echo $row['arr_origin_drop_off'] .'<br>';
											echo $row['arr_airport'] . '<br>' . $row['arr_flight_no'].'<br>';
											echo $row['arr_hotel'] .'<br>';

											
											echo '<br><b>(DEP) Estimated Pick-up Time: '.$row['est_pickup'].
												'<br>'. $row['dep_date'] .' '. $row['dep_etd'] .'</b><br>';
											echo $row['dep_origin_drop_off'] .'<br>';
											echo $row['dep_airport'] . '<br>' . $row['dep_flight_no'].'<br>';
											echo $row['dep_hotel'];
											break;
										default:
											break;
											echo '';
											break;
									}
								?></td>
							<td><?php echo $row['transfer_mode'] ?></td>
							<td><?php echo $row['other_names'] . '<br><br>' . $row['remarks'];?></td>
							<td>BOOKED BY: <br><?php echo $row['created_by'] ?></td>
							<td><?php echo $row['created_date'] ?></td>
							<td><?php echo $row['payment_type'] .'<br> Remarks: ' . $row['payment_remarks']?><br>
								<?php 
									switch($row['status']){
										case 0:
											echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Unpaid</span>';
											break;
										case 1:
											echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">Confirmed</span>';
											break;
										case 2:
											echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">Packed</span>';
											break;
										case 3:
											echo '<span class="badge badge-warning bg-gradient-warning px-3 rounded-pill">Out for Delivery</span>';
											break;
										case 4:
											echo '<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Delivered</span>';
											break;
										case 5:
											echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Cancelled</span>';
											break;
										default:
											echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
											break;
									}
								?>
							</td>
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
								<a class="dropdown-item" href="?page=booking&id=<?php echo $row['id'] ?>">
									<span class="fa fa-edit text-primary"></span> Edit
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
									<span class="fa fa-trash text-danger"></span> Cancel
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
		
		var table = $('#myTable').DataTable({
                dom: 'Bfrtip',
				paging: true,
                buttons: [
					{
						extend: 'print',
						exportOptions: {
							columns: ':not(:last-child)' // Exclude the last column
						}
					},
					{
						extend: 'csv',
						exportOptions: {
							columns: ':not(:last-child)'
						}
					},
					{
						extend: 'excel',
						exportOptions: {
							columns: ':not(:last-child)'
						}
					},
					{
						extend: 'pdf',
						orientation: 'landscape',
						pageSize: 'legal',
						exportOptions: {
							columns: ':not(:last-child)' // Exclude last column
						},
						customize: function (doc) {
							// Loop through each row and convert "<br>" tags to actual new lines ("\n")
							doc.content[1].table.body.forEach(function (row) {
								row.forEach(function (cell, i) {
									if (typeof cell === 'string') {
										row[i] = { 
											text: cell.replace(/<br\s*\/?>/g, '\n'), // Convert HTML <br> to new lines
											alignment: 'left', 
											fontSize: 10, 
											margin: [0, 2, 0, 2] 
										};
									}
								});
							});
						}


					},
					{
						extend: 'copy',
						exportOptions: {
							columns: ':not(:last-child)'
						}
					}
				]
            });

            $('#transferFilter').on('change', function () {
                table.column(4).search(this.value).draw(); // Adjusted for "TRANSFER TYPE" column
            });

            $('#startDate, #endDate').on('change', function () {
                table.draw();
            });
		$.fn.dataTable.ext.search.push(function (settings, data) {
			var transferType = $('#transferFilter').val();
			var startDate = $('#startDate').val();
			var endDate = $('#endDate').val();
			var transferInfo = data[4] || ''; // Column containing multiple values

			// Extract first matching date (YYYY-MM-DD format) using regex
			var dateMatch = transferInfo.match(/\d{4}-\d{2}-\d{2}/); 
			var extractedDate = dateMatch ? new Date(dateMatch[0]) : null;

			var start = startDate ? new Date(startDate) : null;
			var end = endDate ? new Date(endDate) : null;

			// Filter by transfer type using "like" match
			if (transferType && !transferInfo.includes(transferType)) { 
				return false;
			}

			// Filter by extracted date
			if (extractedDate) {
				if ((start && extractedDate < start) || (end && extractedDate > end)) {
					return false;
				}
			}

			return true;
		});
	})
	function delete_reference($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/booking.php?f=delete",
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