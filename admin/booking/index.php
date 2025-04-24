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
    <form id="frmBooking" action="" method="post">
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
							<option>Departure</option>
							<option>Roundtrip</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="paymentType" class="control-label">Payment Type: <span class="required">*</span></label>
						<select type="text" id="paymentType" name="paymentType" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
							<option>Departure</option>
							<option>Roundtrip</option>
						</select>
					</div>
					
					
					<div class="form-group col-md-3"></div>
					<div class="form-group col-md-3"></div>
					<!-- Arrival Details -->
					<div class="form-group col-md-12 col-sm-3 clsArrival">
						<h6>Arrival Details</h6>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrOrigin" class="control-label">Origin/Pick up Location: <span class="required">*</span></label>
						<select type="text" id="arrOrigin" name="arrOrigin" class="form-control form-control-sm form-control-border select2 clsArrival">
							<option value="" disabled selected></option>
							<option>Departure</option>
							<option>Roundtrip</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrDropOff" class="control-label">Drop Off: <span class="required">*</span></label>
						<select type="text" id="arrDropOff" name="arrDropOff" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="arrDate" name="arrDate" class="form-control form-control-sm form-control-border">
					</div>
					<div class="form-group col-md-3"></div>

					<div class="form-group col-md-3 clsArrival">
						<label for="arrAirport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="arrAirport" name="arrAirport" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
							<option>CATICLAN AIRPORT (MPH)</option>
							<option>KALIBO AIRPORT (KLO)</option>
							<option>N/A</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrFlightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<select type="text" id="arrFlightNumber" name="arrFlightNumber" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrHotelResort" class="control-label">Hotel/Resort: <span class="required">*</span></label>
						<select type="text" id="arrHotelResort" name="arrHotelResort" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
							<option>FAIRWAYS & BLUEWATER RESORT</option>
							<option>OTHER HOTEL</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="eta" class="control-label">ETA: <span class="required">*</span></label>
						<input type="time" id="eta" autofocus name="eta" lang="en-GB" class="form-control form-control-sm form-control-border">
					</div>
					<!-- Departure Details -->
					<div class="form-group col-md-12 col-sm-3 clsDeparture">
						<h6>Departure Details</h6>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depOrigin" class="control-label">Origin/Pick up Location: <span class="required">*</span></label>
						<select type="text" id="depOrigin" name="depOrigin" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
							<option>Departure</option>
							<option>Roundtrip</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depDropOff" class="control-label">Drop Off: <span class="required">*</span></label>
						<select type="text" id="depDropOff" name="depDropOff" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="depDate" name="depDate" class="form-control form-control-sm form-control-border">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="estpickup" class="control-label">Estimated Pick-up Time:</label>
						<input type="time" id="estpickup" autofocus name="estpickup" class="form-control form-control-sm form-control-border" disabled>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depAirport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="depAirport" name="depAirport" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
							<option>CATICLAN AIRPORT (MPH)</option>
							<option>KALIBO AIRPORT (KLO)</option>
							<option>N/A</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depFlightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<select type="text" id="depFlightNumber" name="depFlightNumber" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depHotelResort" class="control-label">Hotel/Resort: <span class="required">*</span></label>
						<select type="text" id="depHotelResort" name="depHotelResort" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
							<option>FAIRWAYS & BLUEWATER RESORT</option>
							<option>OTHER HOTEL</option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="etd" class="control-label">ETD: <span class="required">*</span></label>
						<input type="time" id="etd" autofocus name="etd" lang="en-GB" class="form-control form-control-sm form-control-border">
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
					<div class="form-group col-md-3"></div>
					<div class="form-group col-md-3"></div>
					<div class="form-group col-md-3"></div>
					<div class="form-group col-md-3">
						<button type="submit" class="btn btn-flat btn-primary w-100">Submit Booking</button>
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

				hours -= 3;
				if (hours < 0) {
					hours += 24;
				}

				let newHours = String(hours).padStart(2, '0');
				let newMinutes = String(minutes).padStart(2, '0');

				$('#estpickup').val(`${newHours}:${newMinutes}`);
			}
		});


		$('#frmBooking').on('submit', function(e) {
			e.preventDefault(); // prevent default form submit

			var formData = new FormData(this);

			$.ajax({
				url: _base_url_+"classes/Booking.php?f=save_booking",
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				error:err=>{
					console.log(err)
					alert_toast("An error occured.",err);
					end_loader();
				},
				success: function(response) {
					console.log('Server response:', response);
				}
			});
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