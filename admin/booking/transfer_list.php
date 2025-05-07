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
		<label for="paymentStatFilter">Payment Status: </label>
			<select id="paymentStatFilter">
				<option value="">All</option>
				<option value="Unpaid">Unpaid</option>
				<option value="FOC">FOC</option>
				<option value="Paid">Paid</option>
				<option value="Cancelled">Cancelled</option>
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
		<style>
			.rounded-pill{
				height:24px;
				font-size: 14px;
			}
		</style>
	
			<table id="myTable" class="table table-bordered table-striped display" style="font-size: 14px;">
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
									$row['qty_guest_7'],
									$row['qty_guest_8']
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
							<td><?php echo $row['payment_type'] .'<br> Remarks: ' . $row['payment_remarks'] .'<br>Amount: <b>P' . number_format($row['total_price'], 2) . '</b>'?><br>
							
								<?php 
									switch($row['status']){
										case 0:
											echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Unpaid</span>';
											break;
										case 1:
											echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">FOC</span>';
											break;
										case 2:
											echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">Paid</span>';
											break;
										case 3:
											echo '<span class="badge badge-secondary bg-gradient-secondary px-3 rounded-pill">Cancelled</span>';
											break;
										case 4:
											echo '<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Delivered</span>';
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
								height: 25px;
								padding: 5px 10px; /* Adjust padding to control spacing */
								font-size: 14px; /* Make text smaller */
								display: flex;
								align-items: center;
								justify-content: center;
							}
							</style>

							<?php if($row['status'] == 0) {?>
							<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon small-button" data-toggle="dropdown">
								Action &nbsp;
								<span class="sr-only">Toggle Dropdown</span>
							</button>
								<input type="hidden" value="<?php echo $_settings->userdata('lastname') .', '. $_settings->userdata('firstname');?>" id="user"/>
								
								<div class="dropdown-menu" role="menu">
                                	<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                                    <span class="fa fa-eye text-dark"></span> View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="?page=booking&id=<?php echo $row['id'] ?>">
										<span class="fa fa-edit text-primary"></span> Edit
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item paid_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-money-bill text-success"></span> Paid
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item print_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-print text-secondary"></span> Print Manifest
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item cancel_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-trash text-danger"></span> Cancel
									</a>
								</div>
							<?php } else if($row['status'] == 2){ ?>
								<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon small-button" data-toggle="dropdown">
								Action &nbsp;
								<span class="sr-only">Toggle Dropdown</span>
							</button>
								<input type="hidden" value="<?php echo $_settings->userdata('lastname') .', '. $_settings->userdata('firstname');?>" id="user"/>
								<div class="dropdown-menu" role="menu">
                                	<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                                    <span class="fa fa-eye text-dark"></span> View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="?page=booking&id=<?php echo $row['id'] ?>">
										<span class="fa fa-edit text-primary"></span> Edit
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item print_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-print text-secondary"></span> Print Manifest
									</a>
								</div>
							<?php
								echo 'Updated by: <br>' .$row['updated_by'];
							 } else { ?>
								<div class="dropdown-menu" role="menu">
                                	<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                                    <span class="fa fa-eye text-dark"></span> View</a>
									<div class="dropdown-divider"></div>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item print_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
										<span class="fa fa-print text-secondary"></span> Print Manifest
									</a>
								</div>
							 <?php
								echo '<span >Cancelled</span>';
								echo '<br> reason: <br>' .$row['status_remarks'];
								echo '<br> Cancel by: <br>' .$row['updated_by'];
							 } ?>
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

	
		$('.view_data').click(function(){
			var bookingId = $(this).attr('data-id');
			var mode = "view"; // Define the mode for viewing
			uni_modal('Transfer Details', "booking/print_booking.php?id=" + bookingId + "&mode=" + mode, 'large');
		});

		$('.print_data').click(function(){
			var bookingId = $(this).attr('data-id');
			var mode = "print"; // Define the mode for printing
			window.open("booking/print_booking.php?id=" + bookingId + "&mode=" + mode, '_blank');
		});

    // Function to set default dates
    function setDefaultDates() {
		let today = new Date().toISOString().split('T')[0];

		// Calculate the date **one month** from today
		let oneMonthLater = new Date();
		oneMonthLater.setMonth(oneMonthLater.getMonth() + 1);
		oneMonthLater = oneMonthLater.toISOString().split('T')[0];

		// Apply default values to the input fields
		$('#startDate').val(today);
		$('#endDate').val(oneMonthLater);
    }

    // Function to apply date-based filtering
    function applyDateFilter() {
        $('#myTable').DataTable().draw();
    }

    // Apply default dates on page load
    setDefaultDates();

		
		
    // Initialize DataTable		
		var table = $('#myTable').DataTable({
                dom: 'Bfrtip',
				paging: true,
                buttons: [
					{
						extend: 'print',
						customize: function(win) {
							$(win.document.body).css('font-size', '12pt')
												.find('table')
												.addClass('table table-bordered');
						},
						exportOptions: {
							columns: ':not(:last-child)'
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

			$('#paymentStatFilter').on('change', function () {
				table.column(9).search(this.value).draw(); // Adjusted for "TRANSFER TYPE" column
			});

            $('#startDate, #endDate').on('change', function () {
                table.draw();
            });

		$.fn.dataTable.ext.search.push(function (settings, data) {
			var transferType = $('#transferFilter').val();
			var paymentStatType = $('#paymentStatFilter').val();
			var startDate = $('#startDate').val();
			var endDate = $('#endDate').val();
			var transferInfo = data[4] || '';
			var paymentStatInfo = data[9] || '';

			// Extract first matching date (YYYY-MM-DD format) using regex
			var dateMatch = transferInfo.match(/\d{4}-\d{2}-\d{2}/); 
			var extractedDate = dateMatch ? new Date(dateMatch[0]) : null;

			var start = startDate ? new Date(startDate) : null;
			var end = endDate ? new Date(endDate) : null;

			// Filter by transfer type using "like" match
			if (transferType && !transferInfo.includes(transferType)) { 
				return false;
			}

			// Filter by Payment Status using "like" match
			if (paymentStatType && !paymentStatInfo.includes(paymentStatType)) { 
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

		let user = document.getElementById('user').value;

		$('.paid_data').click(function(){
			_conf("Are you sure you want to mark this booking as paid?","paid_booking",[$(this).attr('data-id'), `"${user}"`])
		})
			
		
		$('.cancel_data').click(function(){    
			let cancelReason = prompt("Please enter the reason for cancellation:");
			if (cancelReason !== null && cancelReason.trim() !== "") {
				_conf(`Are you sure you want to cancel this booking?`, "cancel_booking", [$(this).attr('data-id'), `"${cancelReason}"`, `"${user}"`]);
			} 

		})
		
		
		// Apply filtering automatically on page load
		applyDateFilter();

		// Trigger filtering when input changes
		$('#startDate, #endDate').on('change', function () {
			applyDateFilter();
		});
	})

	function paid_booking($id,$user){
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Booking.php?f=paid_booking",
			method: "POST",
			data: { id: $id, user: $user },
			dataType: "json", // Expect JSON response
			error: function(err) {
				console.log("Error: ", err.responseText); // Log responseText to inspect the server output
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp === 'object' && resp.status === 'success') {
					location.reload();
				} else {
					alert_toast("Invalid response format.", 'error');
					console.log("Response: ", resp); // Log response to see what's wrong
					end_loader();
				}
			}
		});
	}
	
	function cancel_booking($id,$reason,$user){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Booking.php?f=cancel_booking",
			method:"POST",
			data:{id: $id, reason: $reason, user: $user},
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