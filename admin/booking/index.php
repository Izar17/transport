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
        <input type="hidden" name="id">
        <div class="row">
            <!-- First Panel (10 columns) -->
            <div class="col-md-10">
                <div class="row">
					<!-- First Row -->
					<div class="form-group col-md-5 d-flex align-items-center">
						<label for="reserveNum" class="me-3 mb-0" style="min-width: 180px;font-size: 0.8rem;">Reservation Number:</label>
						<input type="text" id="reserveNum" name="reserve_num" class="form-control form-control-sm form-control-border" readonly>
					</div>
					<div class="form-group col-md-5"></div>
					<!-- <div class="form-group col-md-4"></div> -->
                    <div class="form-group col-md-3">
                        <label for="lastname" class="control-label">Last Name: <span class="required">*</span></label>
                        <input type="text" id="lastname" autofocus name="last_name" class="form-control form-control-sm form-control-border" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="firstname" class="control-label">First Name: <span class="required">*</span></label>
                        <input type="text" id="firstname" name="first_name" class="form-control form-control-sm form-control-border" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="contact" class="control-label">Contact #: <span class="required">*</span></label>
                        <input type="number" id="contact" name="contact_no" class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="email" class="control-label">Email Address: <span class="required">*</span></label>
                        <input type="email" id="email" name="email_address" class="form-control form-control-sm form-control-border" oninput="this.value = this.value.toLowerCase()" required>
                    </div>
					<!-- 2nd row -->
					<div class="form-group col-md-3">
						<label for="transferType" class="control-label">Transfer Type: <span class="required">*</span></label>
						<select type="text" id="transferType" name="transfer_type" class="form-control form-control-sm form-control-border select2" required>
							<option selected>Arrival</option>
							<option>Departure</option>
							<option>Roundtrip</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="modeOfTransfer" class="control-label">Mode of Transfer: <span class="required">*</span></label>
						<select type="text" id="modeOfTransfer" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled selected></option>
						</select>
						<input type="hidden" id="hdModeOfTransfer" name="transfer_mode">
						<input type="hidden" id="modeOfTransferPrice" name="transfer_mode_price">
					</div>
					<div class="form-group col-md-3">
						<label for="paymentType" class="control-label">Payment Type: <span class="required">*</span></label>
						<select type="text" id="paymentType" name="payment_type" class="form-control form-control-sm form-control-border select2">
							<option value="" disabled selected></option>
						</select>
					</div>
					
					
					<div class="form-group col-md-3"></div>
					<div class="form-group col-md-3"></div>
					<!-- Arrival Details -->
					<div class="form-group col-md-12 col-sm-3 clsArrival">
						<h6>Arrival Details</h6>
					</div>
					<div class="form-group col-md-6 clsArrival">
						<label for="arrOriginDropOff" class="control-label">Origin and Drop-Off Locations: <span class="required">*</span></label>
						<select type="text" id="arrOriginDropOff" class="form-control form-control-sm form-control-border select2 clsArrival">
							<option value="" hidden selected></option>
						</select>
						<input type="hidden" id="hdArrOriginDropOff" name="arr_origin_drop_off">
						<input type="hidden" id="arrOriginDropOffPrice" name="arr_origin_drop_off_price">
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="arrDate" name="arr_date" class="form-control form-control-sm form-control-border">
					</div>
					<div class="form-group col-md-3"></div>

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
					<div class="form-group col-md-3 clsArrival">
						<label for="eta" class="control-label">ETA: <span class="required">*</span></label>
						<input type="time" id="eta" autofocus name="arr_eta" lang="en-GB" class="form-control form-control-sm form-control-border">
					</div>
					<!-- Departure Details -->
					<div class="form-group col-md-12 col-sm-3 clsDeparture">
						<h6>Departure Details</h6>
					</div>
					<div class="form-group col-md-6 clsDeparture">
						<label for="depOriginDropOff" class="control-label">Origin and Drop-Off Locations: <span class="required">*</span></label>
						<select type="text" id="depOriginDropOff" class="form-control form-control-sm form-control-border select2">
							<option value="" hidden selected></option>
						</select>
						<input type="hidden" id="hdDepOriginDropOff" name="dep_origin_drop_off">
						<input type="hidden" id="depOriginDropOffPrice" name="dep_origin_drop_off_price">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="depDate" name="dep_date" class="form-control form-control-sm form-control-border">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="estpickup" class="control-label">Estimated Pick-up Time:</label>
						<input type="time" id="estpickup" autofocus class="form-control form-control-sm form-control-border" readonly>
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
						<label for="etd" class="control-label">ETD: <span class="required">*</span></label>
						<input type="time" id="etd" autofocus name="dep_etd" lang="en-GB" class="form-control form-control-sm form-control-border">
					</div>
					<!-- Fifth Row -->
                    <div class="form-group col-md-6">
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
            <div class="col-md-2 d-flex flex-column" style="border: 1px solid #000; border-radius:10px; padding: 10px; height:400px;">
                <label for="transfercharges" class="control-label">TRANSFER CHARGES</label>
				<hr>
                <div id="charges" class="flex-grow-1">
                    <input type="number" id="qtyadult" name="qty_guest_1" class="transfercharges"/> Adult (Local) <input type="hidden" id="priceAdultLocal" name="price_guest_1" class="transfercharges" value="0.00" readonly/><br>
					<input type="number" id="qtyadult" name="qty_guest_2" class="transfercharges"/> Adult (Foreigner) <input type="hidden" id="priceAdultLocal" name="price_guest_2" class="transfercharges" value="0.00" readonly/><br>
                    <input type="number" id="qtyadult" name="qty_guest_3" class="transfercharges"/> Senior/PWD <input type="hidden" id="priceAdultLocal" name="price_guest_3" class="transfercharges" value="0.00" readonly/><br>
                    <input type="number" id="qtyadult" name="qty_guest_4" class="transfercharges"/> Kid (Local) <input type="hidden" id="priceAdultLocal" name="price_guest_4" class="transfercharges" value="0.00" readonly/><br>
                    <input type="number" id="qtyadult" name="qty__guest_5" class="transfercharges"/> Kid (Foreigner) <input type="hidden" id="priceAdultLocal" name="price_guest_5" class="transfercharges" value="0.00" readonly/><br>
										
				</div>
				<button type="submit" class="btn btn-flat btn-primary mt-2 w-100">Submit Booking</button>
            </div>
			
        </div>
        
    </form>
</div>
</div>
<script>
	//1
	$(document).ready(function() {
		$('.clsDeparture').hide();

		$('#reserveNum').val(generateReservationID());

		populateDropdowns(1);
		
		$('#transferType').on('change', function() {
			if ($('#transferType').val().toUpperCase() === "ARRIVAL")
			{
				$('.clsArrival').show();
				$('.clsDeparture').hide();
				populateDropdowns(1);
			}
			else if ($('#transferType').val().toUpperCase() === "DEPARTURE")
			{
				$('.clsArrival').hide();
				$('.clsDeparture').show();
				populateDropdowns(2);
			}
			else if ($('#transferType').val().toUpperCase() === "ROUNDTRIP")
			{
				$('.clsArrival').show();
				$('.clsDeparture').show();
				populateDropdowns(3);
			}
        });

		$('#modeOfTransfer').on('change', function() {
			$('#hdModeOfTransfer').val($('#modeOfTransfer option:selected').text());
			$('#arrOriginDropOffPrice').val($(this).val());
		});

		$('#arrOriginDropOff').on('change', function() {
			$('#hdArrOriginDropOff').val($('#arrOriginDropOff option:selected').text());
			$('#arrOriginDropOffPrice').val($(this).val());
		});

		$('#depOriginDropOff').on('change', function() {
			$('#hdDepOriginDropOff').val($('#depOriginDropOff option:selected').text());
			$('#depOriginDropOffPrice').val($(this).val());
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

	function generateReservationID() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        return `${year}${month}${day}${hours}${minutes}${seconds}`;
    }

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


				});

				//Reset dropdowns
				$('#modeOfTransfer').empty();
				$('#paymentType').empty();
				$('#arrAirport').empty();
				$('#arrHotelResort').empty();

				//Adding default value
				$('#modeOfTransfer').append('<option value="" disabled selected></option>');
				$('#paymentType').append('<option value="" disabled selected></option>');

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
    dropdown.style.display = "none"; // Hide the dropdown
}
</script>