<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM booking where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
input[type="text"], 
input[type="email"], 
input[type="time"], 
input[type="number"], 
input[type="date"], 
textarea.form-control,
select.form-control {
    height: 20px; /* Adjust as needed */
    padding: 0px; /* Reduce padding */
    font-size: 12px; /* Make text smaller */
	width:75%;
	border: 1px solid;
}
.form-group {
    margin-bottom: 0px; /* Reduces space between form fields */
    padding: 3px;
}

.control-label {
    font-size: 0.8em; /* Adjust font size to make it smaller */
}
.transfercharges {
    width: 10px;
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

.airport-list {
    display: none;
    position: absolute;
    border: 1px solid #ccc;
    background-color: #fff;
    width: 250px;
    z-index: 999; /* Ensure it appears above other elements */
}
.airport-list div {
	padding: 8px;
	cursor: pointer;
}
.airport-list div:hover {
	background-color: #f0f0f0;
}


</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Booking Transfer</h3>
	</div>
	<div class="card-body">
	<div id="msg"></div>
    <form id="frmBooking" action="" method="post">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<input type="hidden" name="updated_by" value="<?php echo $_settings->userdata('lastname') .', '. $_settings->userdata('firstname'); ?>"/>
        <div class="row">
            <!-- First Panel (10 columns) --> 
            <div class="col-md-10">
                <div class="row">
					<!-- First Row -->
					<div class="form-group col-md-5 d-flex align-items-center">
						<label for="reserveNum" class="me-3 mb-0" style="min-width: 180px;font-size: 0.8rem;">Reservation Number:</label>
						<input type="text" id="reserveNum" name="reserve_num"  value="<?php echo isset($meta['reserve_num']) ? $meta['reserve_num']: '' ?>" class="form-control form-control-sm form-control-border" style="width:125px;" readonly>
					</div>
					<div class="form-group col-md-5"></div>
					<!-- <div class="form-group col-md-4"></div> -->
                    <div class="form-group col-md-3">
                        <label for="lastname" class="control-label">Last Name: <span class="required">*</span></label>
                        <input type="text" id="lastname" autofocus name="last_name" class="form-control form-control-sm form-control-border"  value="<?php echo isset($meta['last_name']) ? $meta['last_name']: '' ?>" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="firstname" class="control-label">First Name: <span class="required">*</span></label>
                        <input type="text" id="firstname" name="first_name" value="<?php echo isset($meta['first_name']) ? $meta['first_name']: '' ?>" class="form-control form-control-sm form-control-border" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="contact" class="control-label">Contact #: <span class="required">*</span></label>
                        <input type="number" id="contact" name="contact_no" value="<?php echo isset($meta['contact_no']) ? $meta['contact_no']: '' ?>" class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="email" class="control-label">Email Address: <span class="required">*</span></label>
                        <input type="email" id="email" name="email_address" value="<?php echo isset($meta['email_address']) ? $meta['email_address']: '' ?>" class="form-control form-control-sm form-control-border" oninput="this.value = this.value.toLowerCase()" required>
                    </div>
					<!-- 2nd row -->
					<div class="form-group col-md-3">
						<label for="transferType" class="control-label">Transfer Type: <span class="required">*</span></label>
						<select type="text" id="transferType" name="transfer_type" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected>Select Transfer Type</option>
							<option value="1" <?php echo isset($meta['transfer_type']) && $meta['transfer_type'] == 1 ? 'selected' : '' ?>>ARRIVAL</option>
							<option value="2"<?php echo isset($meta['transfer_type']) && $meta['transfer_type'] == 2 ? 'selected' : '' ?>>DEPARTURE</option>
							<option value="3"<?php echo isset($meta['transfer_type']) && $meta['transfer_type'] == 3 ? 'selected' : '' ?>>ROUNDTRIP</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="modeOfTransfer" class="control-label">Mode of Transfer: <span class="required">*</span></label>
						<select type="text" id="modeOfTransfer" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected><?php echo isset($meta['transfer_mode']) ? $meta['transfer_mode']: 'Select Mode of Transfer' ?></option>
						</select>
						<input type="hidden" id="hdModeOfTransfer" name="transfer_mode" value="<?php echo isset($meta['transfer_mode']) ? $meta['transfer_mode']: '' ?>">
						<input type="hidden" id="modeOfTransferPrice" name="transfer_mode_price" value="<?php echo isset($meta['transfer_mode_price']) ? $meta['transfer_mode_price']: '' ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="paymentType" class="control-label">Payment Type: <span class="required">*</span></label>
						<select type="text" id="paymentType" name="payment_type" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected><?php echo isset($meta['payment_type']) ? $meta['payment_type']: 'Select Payment Type' ?></option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="paymentRemarks" class="control-label">Payment Remarks: <span class="required">*</span></label>
						<textarea id="paymentRemarks" name="payment_remarks" class="form-control form-control-sm form-control-border w-100"><?php 
							echo isset($meta['payment_remarks']) ? str_replace(["\r", "\n", "\t"], '', trim($meta['payment_remarks'])) : 'Input Payment Remarks'; 
						?></textarea>
					</div>
					
					<!-- Arrival Details -->
					<div class="form-group col-md-12 col-sm-3 clsArrival"><br>
						<h6>Arrival Details</h6>
					</div>
					<div class="form-group col-md-6 clsArrival">
						<label for="arrOriginDropOff" class="control-label">Origing Pick-up and Drop-off Locations: <span class="required">*</span></label>
						<select type="text" id="arrOriginDropOff" class="form-control form-control-sm form-control-border select2 clsArrival w-75">
							<option value="" hidden selected></option>
						</select>
						<input type="hidden" id="hdArrOriginDropOff" name="arr_origin_drop_off">
						<input type="hidden" id="arrOriginDropOffPrice" name="arr_origin_drop_off_price">
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="arrDate" name="arr_date" class="form-control form-control-sm form-control-border w-50">
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="eta" class="control-label">ETA: <span class="required">*</span></label>
						<input type="time" id="eta" autofocus name="arr_eta" lang="en-GB" class="form-control form-control-sm form-control-border w-50">
					</div>

					<div class="form-group col-md-3 clsArrival">
						<label for="arrAirport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="arrAirport" name="arr_airport" class="form-control form-control-sm form-control-border select2">
							<option value="" hidden selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrFlightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<input type="text" id="arrFlightNumber" autofocus name="arr_flight_no" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm form-control-border airport-input">
						<div class="airport-list">
							<div onclick="selectAirport('PAL (PR)', 'PR', event)">PAL (PR)</div>
							<div onclick="selectAirport('CEBU PACIFIC (5J)', '5J', event)">CEBU PACIFIC (5J)</div>
							<div onclick="selectAirport('AIRASIA (Z2)', 'Z2', event)">AIRASIA (Z2)</div>
							<div onclick="selectAirport('ROYAL AIR (RW)', 'RW', event)">ROYAL AIR (RW)</div>
							<div onclick="selectAirport('TWAY AIR (TW)', 'TW', event)">TWAY AIR (TW)</div>
						</div>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrHotelResort" class="control-label">Hotel/Resort: <span class="required">*</span></label>
						<select type="text" id="arrHotelResort" name="arr_hotel" class="form-control form-control-sm form-control-border select2">
							<option value="" hidden selected></option>
						</select>
					</div>
					<!-- Departure Details -->
					<div class="form-group col-md-12 col-sm-3 clsDeparture"><br>
						<h6>Departure Details</h6>
					</div>
					<div class="form-group col-md-6 clsDeparture">
						<label for="depOriginDropOff" class="control-label">Origing Pick-up and Drop-off Locations: <span class="required">*</span></label>
						<select type="text" id="depOriginDropOff" class="form-control form-control-sm form-control-border select2 w-75">
							<option value="" hidden selected></option>
						</select>
						<input type="hidden" id="hdDepOriginDropOff" name="dep_origin_drop_off">
						<input type="hidden" id="depOriginDropOffPrice" name="dep_origin_drop_off_price">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="depDate" name="dep_date" class="form-control form-control-sm form-control-border w-50">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="etd" class="control-label">ETD: <span class="required">*</span></label>
						<input type="time" id="etd" autofocus name="dep_etd" lang="en-GB" class="form-control form-control-sm form-control-border w-50">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depAirport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="depAirport" name="dep_airport" class="form-control form-control-sm form-control-border select2">
							<option value="" hidden selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depFlightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<input type="text" id="depFlightNumber" autofocus name="dep_flight_no" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm form-control-border airport-input">
						<div class="airport-list">
							<div onclick="selectAirport('PAL (PR)', 'PR', event)">PAL (PR)</div>
							<div onclick="selectAirport('CEBU PACIFIC (5J)', '5J', event)">CEBU PACIFIC (5J)</div>
							<div onclick="selectAirport('AIRASIA (Z2)', 'Z2', event)">AIRASIA (Z2)</div>
							<div onclick="selectAirport('ROYAL AIR (RW)', 'RW', event)">ROYAL AIR (RW)</div>
							<div onclick="selectAirport('TWAY AIR (TW)', 'TW', event)">TWAY AIR (TW)</div>
						</div>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depHotelResort" class="control-label">Hotel/Resort: <span class="required">*</span></label>
						<select type="text" id="depHotelResort" name="dep_hotel" class="form-control form-control-sm form-control-border select2">
							<option value="" hidden selected></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="estpickup" class="control-label">Estimated Pick-up Time:</label>
						<input type="time" id="estpickup" autofocus class="form-control form-control-sm form-control-border w-50" readonly>
					</div>
					<!-- Fifth Row -->
                    <div class="form-group col-md-6 clsRemarks">
                        <label for="otherNames" class="control-label">Other Names:</label>
                        <textarea id="otherNames" autofocus name="other_names" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm form-control-border" style="height:100px;"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="remarks" class="control-label clsDeparture">Remarks:</label>
                        <textarea id="remarks" autofocus name="remarks" class="form-control form-control-sm form-control-border clsDeparture" style="height:100px;"></textarea>
                    </div>
					
                </div>
            </div>
            
            <!-- Second Panel (2 columns) -->
            <div class="col-md-2 d-flex flex-column" style="border: 1px solid #000; border-radius:10px; padding: 10px; height:500px;">
                <label for="transfercharges" class="control-label">TRANSFER CHARGES</label>
                <div id="charges" class="flex-grow-1">
				<table style="width:100%;font-size:12px;padding:0px;font-weight:bold;">
					<tr>
						<td rowspan="2" width="40%"><input type="number" id="qtyGuest1" name="qty_guest_1" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Adult (Local)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest1">0.00</label>
							<input type="hidden" id="priceGuest1" name="price_guest_1"/>
						</td>
					</tr>
					<!-- Repeat for other guest types -->
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest2" name="qty_guest_2" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Adult (Foreigner)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest2">0.00</label>
							<input type="hidden" id="priceGuest2" name="price_guest_2"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest3" name="qty_guest_3" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Senior/PWD</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest3">0.00</label>
							<input type="hidden" id="priceGuest3" name="price_guest_3"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest4" name="qty_guest_4" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Kid (Local)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest4">0.00</label>
							<input type="hidden" id="priceGuest4" name="price_guest_4"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest5" name="qty_guest_5" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Kid (Foreigner)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest5">0.00</label>
							<input type="hidden" id="priceGuest5" name="price_guest_5"/>
						</td>
					</tr>
				</table><br>
                    <label><input type="checkbox" id="chkTerminalFee" value="yes"> &nbsp; Terminal</label> <label id="lblTerminalFee"> 0.00</label> <input type="hidden" id="terminalFee" name="terminal_fee"/><br>
                    <label><input type="checkbox" id="chkEnvFee" value="yes"> &nbsp; Environmental</label> <label id="lblEnvFee"> 0.00</label> <input type="hidden" id="envFee" name="environment_fee"/>
				
				</div>
					<label>Total</label> <label id="lblTotalPrice"> 0.00</label> <input type="hidden" id="totalPrice" name="total_price"/>
				<button type="submit" class="btn btn-flat btn-primary mt-2 w-100">Submit Booking</button>
            </div>
			
        </div>
        
    </form>
</div>
</div>
<script>
	//1
	$(document).ready(function() {
		$('.clsArrival').hide();
		$('.clsDeparture').hide();
		$('.clsRemarks').hide();

		generateReservationID();

		populateDropdowns(1);
		
		$('#transferType').on('change', function() {
			
			//Reset dropdowns
			$('#modeOfTransfer').empty();
			$('#paymentType').empty();
			$('#arrAirport').empty();
			$('#arrHotelResort').empty();

			//Adding default value
			$('#modeOfTransfer').append('<option value="" disabled selected></option>');
			$('#paymentType').append('<option value="" disabled selected></option>');

			if ($('#transferType').val().toUpperCase() === '1')
			{
				$('.clsArrival').show();
				$('.clsDeparture').hide();
				$('.clsRemarks').show();
				populateDropdowns(1);
			}
			else if ($('#transferType').val().toUpperCase() === '2')
			{
				$('.clsArrival').hide();
				$('.clsDeparture').show();
				$('.clsRemarks').show();
				populateDropdowns(2);
			}
			else if ($('#transferType').val().toUpperCase() === '3')
			{
				$('.clsArrival').show();
				$('.clsDeparture').show();
				$('.clsRemarks').show();
				populateDropdowns(3);
			}
			else
			{
				$('.clsArrival').hide();
				$('.clsDeparture').hide();
				$('.clsRemarks').hide();
			}
        });

		$('#modeOfTransfer').on('change', function() {
			$('#hdModeOfTransfer').val($('#modeOfTransfer option:selected').text());
			$('#modeOfTransferPrice').val($(this).val());
		});

		$('#arrOriginDropOff').on('change', function() {
			$('#hdArrOriginDropOff').val($('#arrOriginDropOff option:selected').text());
			$('#arrOriginDropOffPrice').val($(this).val());
		});

		$('#depOriginDropOff').on('change', function() {
			$('#hdDepOriginDropOff').val($('#depOriginDropOff option:selected').text());
			$('#depOriginDropOffPrice').val($(this).val());
		});

		$('#qtyGuest1').on('change', function() {
			computePrice(`#lblGuest1`,`#priceGuest1`,$(this).val());
		});

		$('#qtyGuest2').on('change', function() {
			computePrice(`#lblGuest2`,`#priceGuest2`,$(this).val());
		});

		$('#qtyGuest3').on('change', function() {
			computePrice(`#lblGuest3`,`#priceGuest3`,$(this).val());
		});

		$('#qtyGuest4').on('change', function() {
			computePrice(`#lblGuest4`,`#priceGuest4`,$(this).val());
		});

		$('#qtyGuest5').on('change', function() {
			computePrice(`#lblGuest5`,`#priceGuest5`,$(this).val());
		});

		$('#chkTerminalFee').change(function() {
			computeTotal();
		});

		$('#chkEnvFee').change(function() {
			computeTotal();
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

			start_loader()

			const formData = new FormData(this);
			
			for (let [key, value] of formData.entries()) {
				console.log(key, value); // See what’s actually being sent
			}
			
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
					if(response == "success"){
						$('#msg').html('<div class="alert alert-success">Booking Transfer successfully added</div>')
						$("html, body").animate({ scrollTop: 0 }, "fast");
						location.reload();
					}else{
						$('#msg').html('<div class="alert alert-danger">Error encountered</div>')
						$("html, body").animate({ scrollTop: 0 }, "fast");
					}
					end_loader() 
				}
			});
			/* $('#msg').html('<div class="alert alert-success">Booking successfully added</div>')
			$("html, body").animate({ scrollTop: 0 }, "fast");
			end_loader(); */
		});
	});
	

	function generateReservationID() {
		$.ajax({
			url: _base_url_+"classes/Booking.php?f=get_seq_no",
			type: 'GET',
			success: function(response) {
				let generatedID = 0;

				let data = parseInt(response);
				console.log(data);
				if (data === 0)
				{
					const now = new Date();
					const year = now.getFullYear();
					const month = String(now.getMonth() + 1).padStart(2, '0');
					const day = String(now.getDate()).padStart(2, '0');

					console.log(`${year}${month}${day}000001`);
					generatedID = `${year}${month}${day}000001`
				}
				else
				{
					data += 1;
					generatedID = data.toString();
				}

				console.log("generatedID >",generatedID);
				// return generatedID;
				$('#reserveNum').val(generatedID);
			}
		});
	};

	function computePrice(targetField, hiddenField, quantity) {
		const transType = $('#transferType').val().toUpperCase();
		const arrOriginDropOffPrice = parseInt($('#arrOriginDropOffPrice').val()) || 0;
		const depOriginDropOffPrice = parseInt($('#depOriginDropOffPrice').val()) || 0;
		let originPrice = 0;

		if (transType === "ARRIVAL") originPrice = arrOriginDropOffPrice;
		else if (transType === "DEPARTURE") originPrice = depOriginDropOffPrice;
		else if (transType === "ROUNDTRIP") originPrice = arrOriginDropOffPrice + depOriginDropOffPrice;

		const modeOfTransferPrice = parseInt($('#modeOfTransferPrice').val()) || 0;

		const total = (originPrice + modeOfTransferPrice) * parseInt(quantity);
		
		$(targetField).text(`P${total.toFixed(2)}`);
		$(hiddenField).val(`${total.toFixed(2)}`);

		computeTotal();
	};

	function computeTotal() {
		const guest1 = parseFloat($("#priceGuest1").val()) || 0;
		const guest2 = parseFloat($("#priceGuest2").val()) || 0;
		const guest3 = parseFloat($("#priceGuest3").val()) || 0;
		const guest4 = parseFloat($("#priceGuest4").val()) || 0;
		const guest5 = parseFloat($("#priceGuest5").val()) || 0;

		const totalGuestPrice = parseFloat(guest1) + parseFloat(guest2) + parseFloat(guest3) + parseFloat(guest4) + parseFloat(guest5);
		// const totalGuestPrice = guest1 + guest2 + guest3 + guest4 + guest5;

		console.log("totalGuestPrice>>",totalGuestPrice);
		let terminalFee = 0;
		let envFee = 0;
		if ($('#chkTerminalFee').is(':checked')) terminalFee = $("#terminalFee").val();
		if ($('#chkEnvFee').is(':checked')) envFee = $("#envFee").val();
		console.log("terminalFee>>",terminalFee);
		console.log("envFee>>",envFee);
		const total = parseInt(totalGuestPrice) + parseInt(terminalFee) + parseInt(envFee);
		
		$("#lblTotalPrice").text(`P${parseFloat(total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`);
		$("#totalPrice").val(`${parseFloat(total).toFixed(2)}`);
	};

	function populateDropdowns(transferType){
		$.ajax({
			url: _base_url_+"classes/Booking.php?f=get_reference_table",
			type: 'GET',
			success: function(response) {
				// console.log(response);
				let data = JSON.parse(response);

				let arrPaymentModes = [];
				let arrPaymentTypes = [];
				let arrOriginDropOffs = [];
				let arrAirports = [];
				let arrHotelResorts = [];
				let depOriginDropOffs = [];
				// let depAirports = [];
				// let depHotelResorts = [];

				$.each(data, function(index, item) {
					if (parseInt(item.type) === 1)
					{
						/* if (item.code == 'MOT') arrPaymentModes.push({title: item.title, description: item.description});
						else if (item.code == 'PT') arrPaymentTypes.push({title: item.title, description: item.description}); */
						
						if (item.code == 'ODL') arrOriginDropOffs.push({amount: item.amount, description: item.description});
						/* else if (item.code == 'AP') arrAirports.push({title: item.title, description: item.description});
						else if (item.code == 'HR') arrHotelResorts.push({title: item.title, description: item.description}); */
					}

					if (parseInt(item.type) === 2)
					{
						/* if (item.code == 'MOT') arrPaymentModes.push({title: item.title, description: item.description});
						else if (item.code == 'PT') arrPaymentTypes.push({title: item.title, description: item.description}); */
						
						if (item.code == 'ODL') depOriginDropOffs.push({amount: item.amount, description: item.description});
						/* else if (item.code == 'AP') depAirports.push({title: item.title, description: item.description});
						else if (item.code == 'HR') depHotelResorts.push({title: item.title, description: item.description}); */
					}

					if (parseInt(item.type) === 3)
					{
						if (item.code == 'MOT') arrPaymentModes.push({amount: item.amount, description: item.description});
						else if (item.code == 'PT') arrPaymentTypes.push({title: item.title, description: item.description});
						else if (item.code == 'AP') arrAirports.push({title: item.title, description: item.description});
						else if (item.code == 'HR') arrHotelResorts.push({title: item.title, description: item.description});
					}

					if (item.code == 'TC')
					{
						if (item.title == 'TERMINAL')
						{
							const amount = parseFloat(item.amount);
							$("#lblTerminalFee").text(`P${amount.toFixed(2)}`);
							$("#terminalFee").val(`${amount.toFixed(2)}`);
						}
						if (item.title == 'ENVIRONMENT')
						{
							const amount = parseFloat(item.amount);
							$("#lblEnvFee").text(`P${amount.toFixed(2)}`);
							$("#envFee").val(`${amount.toFixed(2)}`);
						}

					}

				});



				//Populating dropdowns
				$.each(arrPaymentModes, function(index, item) {
					$('#modeOfTransfer').append('<option value="' + item.amount + '">' + item.description + '</option>');
				});

				$.each(arrPaymentTypes, function(index, item) {
					$('#paymentType').append('<option value="' + item.title + '">' + item.description + '</option>');
				});

				if (transferType === 1 || transferType === 3) {

					$('#arrOriginDropOff').empty();
					
					$('#arrOriginDropOff').append('<option value="" disabled selected></option>');
					$('#arrAirport').append('<option value="" disabled selected></option>');
					$('#arrHotelResort').append('<option value="" disabled selected></option>');

					$.each(arrOriginDropOffs, function(index, item) {
						$('#arrOriginDropOff').append('<option value="' + item.amount + '">' + item.description + '</option>');
					});

					$.each(arrAirports, function(index, item) {
						$('#arrAirport').append('<option value="' + item.title + '">' + item.description + '</option>');
					});

					$.each(arrHotelResorts, function(index, item) {
						$('#arrHotelResort').append('<option value="' + item.title + '">' + item.description + '</option>');
					});

				}
				
				if (transferType === 2 || transferType === 3) {

					$('#depOriginDropOff').empty();
					$('#depAirport').empty();
					$('#depHotelResort').empty();
					$('#depOriginDropOff').append('<option value="" disabled selected></option>');
					$('#depAirport').append('<option value="" disabled selected></option>');
					$('#depHotelResort').append('<option value="" disabled selected></option>');

					$.each(depOriginDropOffs, function(index, item) {
						$('#depOriginDropOff').append('<option value="' + item.amount + '">' + item.description + '</option>');
					});

					$.each(arrAirports, function(index, item) {
						$('#depAirport').append('<option value="' + item.title + '">' + item.description + '</option>');
					});

					$.each(arrHotelResorts, function(index, item) {
						$('#depHotelResort').append('<option value="' + item.title + '">' + item.description + '</option>');
					});
				}

			},
			error: function() {
				alert("Error loading data.");
			}
		});
	}


	document.querySelectorAll(".airport-input").forEach(inputField => {
    inputField.addEventListener("click", function() {
        const dropdown = this.nextElementSibling; // Get the matching dropdown
        dropdown.style.display = "block";
    });

    document.addEventListener("click", function(event) {
        document.querySelectorAll(".airport-list").forEach(dropdown => {
            if (!dropdown.previousElementSibling.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });
    });
});

function selectAirport(fullName, code, event) {
    const dropdown = event.target.closest(".airport-list");
    const inputField = dropdown.previousElementSibling; // Get the corresponding input field
    inputField.value = code; // Set only the airport code in the input field
    inputField.focus(); // Focus on the input field so the user can continue typing
    dropdown.style.display = "none"; // Hide the dropdown
}
</script>