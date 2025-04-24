<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
.control-label {
    font-size: 0.8em; /* Adjust font size to make it smaller */
}
.transfercharges {
    width: 50px;
    border: none; /* Remove all borders */
    border-bottom: 1px solid #000; /* Add a bottom border */
    outline: none; /* Remove focus outline */
}

.required {
    color: red; /* Asterisk color */
    font-weight: bold; /* Optional: Make it bold */
    margin-left: 3px; /* Optional: Add spacing */
}

#charges {
	font-size: 0.8em;
	margin-bottom: 20px;
}


</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Booking Transfer</h3>
	</div>
	<div class="card-body">
    <form id="vregister-frm" action="" method="post">
        <input type="hidden" name="id">
        <div class="row">
            <!-- First Panel (10 columns) -->
            <div class="col-md-10">
                <div class="row">
					<!-- First Row -->
                    <div class="form-group col-md-3">
                        <label for="lastname" class="control-label">Last Name: <span class="required">*</span></label>
                        <input type="text" id="lastname" autofocus name="lastname" class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="firstname" class="control-label">First Name: <span class="required">*</span></label>
                        <input type="text" id="firstname" name="firstname" class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="contact" class="control-label">Contact #: <span class="required">*</span></label>
                        <input type="number" id="contact" name="contact" class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="email" class="control-label">Email Address: <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control form-control-sm form-control-border" required>
                    </div>
					<!-- 2nd row -->
					<div class="form-group col-md-3">
						<label for="transferType" class="control-label">Transfer Type: <span class="required">*</span></label>
						<select type="text" id="transferType" name="transferType" class="form-control form-control-sm form-control-border select2" required>
							<option selected>Arrival</option>
							<option>Departure</option>
							<option>Roundtrip</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="modeOfTransfer" class="control-label">Mode of Transfer: <span class="required">*</span></label>
						<select type="text" id="modeOfTransfer" name="modeOfTransfer" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="paymentType" class="control-label">Payment Type: <span class="required">*</span></label>
						<select type="text" id="paymentType" name="paymentType" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
						</select>
					</div>
					
					<div class="form-group col-md-3">
						<label for="origin" class="control-label">Origin/Pick up Location: <span class="required">*</span></label>
						<select type="text" id="origin" name="origin" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
						</select>
					</div>
					<!-- Departure row -->
					<div class="form-group col-md-3">
						<label for="departure" class="control-label clsDeparture">Departure: <span class="required">*</span></label>
						<select type="text" id="origin" name="origin" class="form-control form-control-sm form-control-border select2 clsDeparture" required>
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="estpickup" class="control-label clsDeparture">Estimated Pick-up Time:</label>
						<!-- <input type="text" id="estpickup" name="estpickup" class="form-control form-control-sm form-control-border clsDeparture" disabled> -->
						<input type="time" id="estpickup" autofocus name="estpickup" class="form-control form-control-sm form-control-border clsDeparture" disabled>
					</div>
					<div class="form-group col-md-3"></div>
					<div class="form-group col-md-3"></div>
					<!-- Arrival Details -->
					<div class="form-group col-md-12 col-sm-3 clsArrival">
						<h6>Arrival Details</h6>
					</div>
					<!-- 3rd row -->
					<div class="form-group col-md-3 clsArrival">
						<label for="airport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="airport" name="airport" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
							<option>CATICLAN AIRPORT (MPH)</option>
							<option>KALIBO AIRPORT (KLO)</option>
							<option>N/A</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="flightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<select type="text" id="flightNumber" name="flightNumber" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="hotelResort" class="control-label">Hotel/Resort: <span class="required">*</span></label>
						<select type="text" id="hotelResort" name="hotelResort" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
							<option>FAIRWAYS & BLUEWATER RESORT</option>
							<option>OTHER HOTEL</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="eta" class="control-label">ETA: <span class="required">*</span></label>
						<input type="time" id="eta" autofocus name="eta" lang="en-GB" class="form-control form-control-sm form-control-border" required>
					</div>
					<!-- Departure Details -->
					<div class="form-group col-md-12 col-sm-3 clsDeparture">
						<h6>Departure Details</h6>
					</div>
					<!-- 3rd row -->
					<div class="form-group col-md-3 clsDeparture">
						<label for="airport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="airport" name="airport" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
							<option>CATICLAN AIRPORT (MPH)</option>
							<option>KALIBO AIRPORT (KLO)</option>
							<option>N/A</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="flightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<select type="text" id="flightNumber" name="flightNumber" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="hotelResort" class="control-label">Hotel/Resort: <span class="required">*</span></label>
						<select type="text" id="hotelResort" name="hotelResort" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
							<option>FAIRWAYS & BLUEWATER RESORT</option>
							<option>OTHER HOTEL</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="etd" class="control-label">ETD: <span class="required">*</span></label>
						<input type="time" id="etd" autofocus name="etd" lang="en-GB" class="form-control form-control-sm form-control-border" required>
					</div>
					<!-- Fifth Row -->
                    <div class="form-group col-md-6">
                        <label for="otherNames" class="control-label">Other Names:</label>
                        <textarea id="otherNames" autofocus name="otherNames" class="form-control form-control-sm form-control-border" style="height:100px;"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="remarks" class="control-label clsDeparture">Remarks:</label>
                        <textarea id="remarks" autofocus name="remarks" class="form-control form-control-sm form-control-border clsDeparture" style="height:100px;"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Second Panel (2 columns) -->
            <div class="col-md-2" style="border: 1px solid #000; border-radius:10px; padding: 10px;">
                <label for="transfercharges" class="control-label">TRANSFER CHARGES</label>
				<hr>
                <div id="charges">
                    <input type="number" class="transfercharges"/> Adult (Local) 0.00 <br>
                    <input type="number" class="transfercharges"/> Adult (Local) 0.00 <br>
                    <input type="number" class="transfercharges"/> Adult (Local) 0.00 <br>
                    <input type="number" class="transfercharges"/> Adult (Local) 0.00 <br>
                    <input type="number" class="transfercharges"/> Adult (Local) 0.00
                </div>
            </div>
        </div>
        
    </form>
</div>
</div>
<script>
	$(document).ready(function() {
		$('.clsDeparture').hide();

		$('.delete_data').click(function(){
			_conf("Are you sure to delete this vendor permanently?","delete_vendor",[$(this).attr('data-id')])
		})

		$('.table').dataTable();

		$('#transferType').on('change', function() {
			if ($('#transferType').val().toUpperCase() === "ARRIVAL")
			{
				$('.clsArrival').show();
				$('.clsDeparture').hide();
			}
			else if ($('#transferType').val().toUpperCase() === "DEPARTURE")
			{
				$('.clsArrival').hide();
				$('.clsDeparture').show();
			}
			else if ($('#transferType').val().toUpperCase() === "ROUNDTRIP")
			{
				$('.clsArrival').show();
				$('.clsDeparture').show();
			}
        });

		$('#etd').on('change', function() {
			let etdTime = $(this).val();

			if (etdTime) {
				let [hours, minutes] = etdTime.split(':').map(Number);

				minutes += 30;
				if (minutes >= 60) {
					hours += 1;
					minutes -= 60;
				}

				// Ensure two-digit format
				let newHours = String(hours).padStart(2, '0');
				let newMinutes = String(minutes).padStart(2, '0');

				$('#estpickup').val(`${newHours}:${newMinutes}`);
			}
		});



	})
	function delete_vendor($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Booking.php?f=save_booking",
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