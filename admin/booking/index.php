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

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>

<style>
input[type="text"], 
input[type="email"], 
input[type="time"], 
input[type="number"], 
input[type="date"], 
textarea.form-control,
select.form-control {
    height: 25px; /* Adjust as needed */
    padding: 0px; /* Reduce padding */
    font-size: 14px; /* Make text smaller */
	width:90%;
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
.optional {
    color: grey; /* Asterisk color */
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
    <form id="frmBooking" action="" method="post"  autocomplete="off">
	<input type="hidden" name="id" id="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
        <div class="row">
            <!-- First Panel (10 columns) --> 
            <div class="col-md-10">
                <div class="row">
					<!-- First Row -->
					<div class="form-group col-md-12 d-flex align-items-center">
						<label for="reserveNum" class="me-3 mb-0" style="min-width: 180px;font-size: 17px;color:blue;">Reservation Number:</label>
						<input type="text" id="reserveNum" name="reserve_num"  autocomplete="off" value="<?php echo isset($meta['reserve_num']) ? $meta['reserve_num']: '' ?>" class="form-control form-control-sm form-control-border" style="font-size:16px;color:blue; border:none;background-color:#fff;" readonly>
					</div>
					<div class="form-group col-md-8 d-flex align-items-center">
						<b>Processed by:</b> &nbsp;
						<input type="text" name="created_by" value="<?php echo $_settings->userdata('lastname') .', '. $_settings->userdata('firstname'); ?>" class="form-control form-control-sm form-control-border" style="width:140px;border:none;background-color:#fff;" readonly/>
					<hr>
					</div>
					<div class="form-group col-md-3"></div>
					<!-- <div class="form-group col-md-4"></div> -->
                    <div class="form-group col-md-3">
                        <label for="lastname" class="control-label">Last Name: <span class="required">*</span></label>
                        <input type="text" id="lastname" autofocus autocomplete="off" name="last_name" autocomplete="off" class="form-control form-control-sm form-control-border"  value="<?php echo isset($meta['last_name']) ? $meta['last_name']: '' ?>" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="firstname" class="control-label">First Name: <span class="required">*</span></label>
                        <input type="text" id="firstname" name="first_name" autocomplete="off" value="<?php echo isset($meta['first_name']) ? $meta['first_name']: '' ?>" class="form-control form-control-sm form-control-border" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="contact" class="control-label">Contact #: <span class="required">*</span></label>
                        <input type="number" id="contact" name="contact_no" autocomplete="off" value="<?php echo isset($meta['contact_no']) ? $meta['contact_no']: '' ?>" class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="email" class="control-label">Email Address: <span class="optional">(Optional)</span></label>
                        <input type="email" id="email" name="email_address" autocomplete="off" value="<?php echo isset($meta['email_address']) ? $meta['email_address']: '' ?>" class="form-control form-control-sm form-control-border" oninput="this.value = this.value.toLowerCase()">
                    </div>
					<!-- 2nd row -->
					<div class="form-group col-md-3">
						<label for="transferType" class="control-label">Transfer Type: <span class="required">*</span></label>
						<select type="text" id="transferType" name="transfer_type" autocomplete="off" class="form-control form-control-sm form-control-border select2" required>
							<option selected>Select Transfer Type</option>
							<option value="1" <?php echo isset($meta['transfer_type']) && $meta['transfer_type'] == 1 ? 'selected' : '' ?>>ARRIVAL</option>
							<option value="2"<?php echo isset($meta['transfer_type']) && $meta['transfer_type'] == 2 ? 'selected' : '' ?>>DEPARTURE</option>
							<option value="3"<?php echo isset($meta['transfer_type']) && $meta['transfer_type'] == 3 ? 'selected' : '' ?>>ROUNDTRIP</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="modeOfTransfer" class="control-label">Mode of Transfer: <span class="required">*</span></label>
						<select type="text" id="modeOfTransfer" class="form-control form-control-sm form-control-border select2" autocomplete="off" required>
							<option selected><?php echo isset($meta['transfer_mode']) ? $meta['transfer_mode']: 'Select Mode of Transfer' ?></option>
						</select>
						<input type="hidden" id="hdModeOfTransfer" name="transfer_mode" value="<?php echo isset($meta['transfer_mode']) ? $meta['transfer_mode']: '' ?>">
						<input type="hidden" id="modeOfTransferPrice" name="transfer_mode_price" value="<?php echo isset($meta['transfer_mode_price']) ? $meta['transfer_mode_price']: '' ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="paymentType" class="control-label">Payment Type: <span class="required">*</span></label>
						<select type="text" id="paymentType" name="payment_type" autocomplete="off" class="form-control form-control-sm form-control-border select2">
							<option selected><?php echo isset($meta['payment_type']) ? $meta['payment_type']: 'Select Payment Type' ?></option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="paymentRemarks" class="control-label">Payment Remarks: <span class="required">*</span></label>
						<textarea id="paymentRemarks" oninput="this.value = this.value.toUpperCase()" name="payment_remarks" autocomplete="off" class="form-control form-control-sm form-control-border w-100" placeholder = "Input Payment Remarks"><?php 
							echo isset($meta['payment_remarks']) ? str_replace(["\r", "\n", "\t"], '', trim($meta['payment_remarks'])) : ''; 
						?></textarea>
						<input type="hidden" id="paymentStatus" name="status" value="<?php echo isset($meta['status']) ? $meta['status']: '' ?>"/>
					</div>
					
					<!-- Arrival Details -->
					<div class="form-group col-md-12 col-sm-3 clsArrival"><br>
						<h6>Arrival Details</h6>
					</div>
					<div class="form-group col-md-6 clsArrival">
						<label for="arrOriginDropOff" class="control-label">Origing Pick-up and Drop-off Locations: <span class="required">*</span></label><br/>
						
						<select type="text" id="arrOriginDropOff" autocomplete="off" class="form-control form-control-sm form-control-border select2 clsArrival" style="width:90%">
							<option  hidden selected><?php echo isset($meta['arr_origin_drop_off']) ? $meta['arr_origin_drop_off']: 'Select Origin Pick-up & Drop-off Location' ?></option>
						</select>
						<input type="hidden" id="hdArrOriginDropOff" name="arr_origin_drop_off" value="<?php echo isset($meta['arr_origin_drop_off']) ? $meta['arr_origin_drop_off']: '' ?>">
						<input type="hidden" id="arrOriginDropOffPrice" name="arr_origin_drop_off_price">
					</div>


					<div class="form-group col-md-3 clsArrival">
						<label for="arrDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="arrDate" name="arr_date" autocomplete="off" value="<?php echo isset($meta['arr_date']) ? $meta['arr_date']: '' ?>" class="form-control form-control-sm form-control-border w-50">
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="eta" class="control-label">ETA: <span class="required">*</span></label>
						<input type="time" id="eta" autofocus name="arr_eta"  value="<?php echo isset($meta['arr_eta']) ? $meta['arr_eta']: '06:00' ?>" lang="en-GB" autocomplete="off" class="form-control form-control-sm form-control-border w-50">
					</div>

					<div class="form-group col-md-3 clsArrival">
						<label for="arrAirport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="arrAirport" name="arr_airport" autocomplete="off" class="form-control form-control-sm form-control-border select2">
							<option selected value="Select Airport" disabled> </option>
						</select>
					</div>
					<div class="form-group col-md-3 clsArrival">
						<label for="arrFlightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<input type="text" id="arrFlightNumber" autofocus name="arr_flight_no" autocomplete="off" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($meta['arr_flight_no']) ? $meta['arr_flight_no']: '' ?>" class="form-control form-control-sm form-control-border airport-input">
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
						<select type="text" id="arrHotelResort" name="arr_hotel" autocomplete="off" class="form-control form-control-sm form-control-border select2">
							<option selected value="Select Hotel/Resort" disabled> </option>
						</select>
					</div>
					<!-- Departure Details -->
					<div class="form-group col-md-12 col-sm-3 clsDeparture"><br>
						<h6>Departure Details</h6>
					</div>
					<div class="form-group col-md-6 clsDeparture">
						<label for="depOriginDropOff" class="control-label">Origing Pick-up and Drop-off Locations: <span class="required">*</span></label><br/>
						<select type="text" id="depOriginDropOff" autocomplete="off" class="form-control form-control-sm form-control-border select2" style="width:90%">
							<option  hidden selected><?php echo isset($meta['dep_origin_drop_off']) ? $meta['dep_origin_drop_off']: 'Select Origin Pick-up & Drop-off Location' ?></option>
						</select>
						<input type="hidden" id="hdDepOriginDropOff" name="dep_origin_drop_off" value="<?php echo isset($meta['dep_origin_drop_off']) ? $meta['dep_origin_drop_off']: '' ?>">
						<input type="hidden" id="depOriginDropOffPrice" name="dep_origin_drop_off_price">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depDate" class="control-label">Date: <span class="required">*</span></label>
						<input type="date" id="depDate" name="dep_date" autocomplete="off" value="<?php echo isset($meta['dep_date']) ? $meta['dep_date']: '' ?>" class="form-control form-control-sm form-control-border w-50">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="etd" class="control-label">ETD: <span class="required">*</span></label>
						<input type="time" id="etd" autofocus name="dep_etd" value="<?php echo isset($meta['dep_etd']) ? $meta['dep_etd']: '06:00' ?>" autocomplete="off" class="form-control form-control-sm form-control-border w-50">
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depAirport" class="control-label">Airport: <span class="required">*</span></label>
						<select type="text" id="depAirport" name="dep_airport" autocomplete="off" class="form-control form-control-sm form-control-border select2">
							<option selected><?php echo isset($meta['dep_airport']) ? $meta['dep_airport']: 'Select Airport' ?></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="depFlightNumber" class="control-label">Flight No.: <span class="required">*</span></label>
						<input type="text" id="depFlightNumber" autofocus name="dep_flight_no" autocomplete="off" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($meta['dep_flight_no']) ? $meta['dep_flight_no']: '' ?>" class="form-control form-control-sm form-control-border airport-input">
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
						<select type="text" id="depHotelResort" name="dep_hotel" autocomplete="off" class="form-control form-control-sm form-control-border select2">
							<option selected><?php echo isset($meta['dep_hotel']) ? $meta['dep_hotel']: 'Select Hotel/Resort' ?></option>
						</select>
					</div>
					<div class="form-group col-md-3 clsDeparture">
						<label for="estpickup" class="control-label">Estimated Pick-up Time:</label>
						<input type="time" id="estpickup" name="est_pickup" autofocus autocomplete="off" value="<?php echo isset($meta['est_pickup']) ? $meta['est_pickup']: '' ?>" class="form-control form-control-sm form-control-border w-50">
					</div>
					<!-- Fifth Row -->
                    <div class="form-group col-md-6">
                        <label for="otherNames" class="control-label">Other Names:</label>
                        <textarea id="otherNames" name="other_names" autocomplete="off"
							oninput="this.value = this.value.toUpperCase()" 
							class="form-control form-control-sm form-control-border" 
							style="height:100px;"><?php echo isset($meta['other_names']) ? trim($meta['other_names']) : ''; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="remarks" class="control-label">Remarks:</label> <span class="optional">(Optional)</span>
                        <textarea id="remarks" autocomplete="off" oninput="this.value = this.value.toUpperCase()" name="remarks" 
						autocomplete="off" class="form-control form-control-sm form-control-border" 
						style="height:100px;"><?php echo isset($meta['remarks']) ? trim($meta['remarks']) : ''; ?></textarea>
                    </div>
					
                </div>
            </div>
            
            <!-- Second Panel (2 columns) -->
            <div class="col-md-2 d-flex flex-column" style="border: 1px solid #000; border-radius:10px; padding: 10px; margin-top: -55px;background-color:#D4FEFD;">
                <label for="transfercharges" class="control-label" style="text-align:center;font-size:18px;"><u>&nbsp;&nbsp;&nbsp; TRANSFER CHARGES &nbsp;&nbsp;&nbsp;</u></label>
                <div id="charges" class="flex-grow-1">
				<table style="width:100%;font-size:14px;padding:0px;font-weight:bold;">
					<tr>
						<td rowspan="2" width="25%"><input type="number" id="qtyGuest1" name="qty_guest_1" value="<?php echo isset($meta['qty_guest_1']) ? $meta['qty_guest_1']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Adult (Local)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest1"><?php echo isset($meta['price_guest_1']) ? 'P'.number_format((float)$meta['price_guest_1'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest1" name="price_guest_1" value="<?php echo isset($meta['price_guest_1']) ? $meta['price_guest_1']: '' ?>"/>
						</td>
					</tr>
					<!-- Repeat for other guest types -->
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest2" name="qty_guest_2" value="<?php echo isset($meta['qty_guest_2']) ? $meta['qty_guest_2']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Adult (Foreign)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest2"><?php echo isset($meta['price_guest_2']) ? 'P'.number_format((float)$meta['price_guest_2'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest2" name="price_guest_2" value="<?php echo isset($meta['price_guest_2']) ? $meta['price_guest_2']: '' ?>"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest3" name="qty_guest_3" value="<?php echo isset($meta['qty_guest_3']) ? $meta['qty_guest_3']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Senior/PWD</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest3"><?php echo isset($meta['price_guest_3']) ? 'P'.number_format((float)$meta['price_guest_3'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest3" name="price_guest_3" value="<?php echo isset($meta['price_guest_3']) ? $meta['price_guest_3']: '' ?>"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest4" name="qty_guest_4" value="<?php echo isset($meta['qty_guest_4']) ? $meta['qty_guest_4']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Child Local (6-12 yo)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest4"><?php echo isset($meta['price_guest_4']) ? 'P'.number_format((float)$meta['price_guest_4'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest4" name="price_guest_4" value="<?php echo isset($meta['price_guest_4']) ? $meta['price_guest_4']: '' ?>"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest5" name="qty_guest_5" value="<?php echo isset($meta['qty_guest_5']) ? $meta['qty_guest_5']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Child Foreign (6-12 yo)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest5"><?php echo isset($meta['price_guest_5']) ? 'P'.number_format((float)$meta['price_guest_5'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest5" name="price_guest_5" value="<?php echo isset($meta['price_guest_5']) ? $meta['price_guest_5']: '' ?>"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest6" name="qty_guest_6" value="<?php echo isset($meta['qty_guest_6']) ? $meta['qty_guest_6']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Child (3-5 yo)</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest6"><?php echo isset($meta['price_guest_6']) ? 'P'.number_format((float)$meta['price_guest_6'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest6" name="price_guest_6" value="<?php echo isset($meta['price_guest_6']) ? $meta['price_guest_6']: '' ?>"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest7" name="qty_guest_7" value="<?php echo isset($meta['qty_guest_7']) ? $meta['qty_guest_7']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>2 yo and below /<br> <span style="color:red">FOC Employee</span></td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;">
							<label id="lblGuest7"><?php echo isset($meta['price_guest_7']) ? 'P'.number_format((float)$meta['price_guest_7'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest7" name="price_guest_7" value="<?php echo isset($meta['price_guest_7']) ? $meta['price_guest_7']: '' ?>"/>
						</td>
					</tr>
					<tr>
						<td rowspan="2"><input type="number" id="qtyGuest8" name="qty_guest_8" value="<?php echo isset($meta['qty_guest_8']) ? $meta['qty_guest_8']: '' ?>" class="transfercharges"/></td>
					</tr>
					<tr>
						<td>Resident (<span style="color:grey">No Terminal & Environment Fee</span>)</td>
					</tr>
					<tr>
						<td></td>


						<td style="text-align:right;">
							<label id="lblGuest8"><?php echo isset($meta['price_guest_8']) ? 'P'.number_format((float)$meta['price_guest_8'], 2, '.', ','): '0.00' ?></label>
							<input type="hidden" id="priceGuest8" name="price_guest_8" value="<?php echo isset($meta['price_guest_8']) ? $meta['price_guest_8']: '' ?>"/>
						</td>
					</tr>
				</table><hr>
					<label id="priceTitle">Price</label> <label id="lblPrice">P0.00</label><br>
					<input type="hidden" id="chargePrice" name="price"/>
					<input type="hidden" id="chargePriceHolder"/>
					<input type="hidden" id="envFee" name="environment_fee"/>
					<input type="hidden" id="envFeeHolder"/>
                    <label><input type="checkbox" id="chkTerminalFee" value="yes"> &nbsp; with Shopping:&nbsp</label><label id="lblTerminalFee"> 0.00</label>
					<input type="hidden" id="terminalFee" name="terminal_fee" value="<?php echo isset($meta['terminal_fee']) ? $meta['terminal_fee']: '' ?>" /><br>
					<input type="hidden" id="terminalFeeHolder"/>
                    <label><input type="checkbox" id="chkEnvFee" value="yes"> &nbsp; Others:&nbsp</label> <label id="lblEnvFee"> 0.00</label>
					<input type="hidden" id="envFee" name="environment_fee" value="<?php echo isset($meta['environment_fee']) ? $meta['environment_fee']: '' ?>"/>
					<input type="hidden" id="envFeeHolder"/>
					<hr>
					<h5 style="color:red;">
						<label>Total:</label> <label id="lblTotalPrice"> 0.00</label> <input type="hidden" id="totalPrice" name="total_price"/>
					</h5>
				<button type="submit" class="btn btn-flat btn-primary mt-2 w-100" style="border-radius:10px;">Submit Booking</button>
				</div>
            </div>
			
        </div>
        
    </form>
</div>
</div>
<script>
	//1
	$(document).ready(function() {
		let globalMOT = [];

		$('.clsArrival').hide();
		$('.clsDeparture').hide();
		$('.clsRemarks').hide();

		$('#arrOriginDropOff').select2();
		$('#depOriginDropOff').select2();

		let meta = <?php echo isset($meta) ? json_encode($meta) : 'null'; ?>;

		var id = document.getElementById('id').value;

		generateReservationID();

		if(!id) populateDropdowns(1);

		window.onload = function() {
			
			if(id){
				$('#transferType').trigger('change');
				$('#modeOfTransfer').trigger('change');
				$('#qtyGuest1').trigger('change');
				$('#qtyGuest2').trigger('change');
				$('#qtyGuest3').trigger('change');
				$('#qtyGuest4').trigger('change');
				$('#qtyGuest5').trigger('change');
				$('#qtyGuest6').trigger('change');
				$('#qtyGuest7').trigger('change');
				$('#qtyGuest8').trigger('change');
			}
		};

		// if (meta.terminal_fee > 0) $('#chkTerminalFee').prop('checked', true);
		// if (meta.environment_fee > 0) $('#chkEnvFee').prop('checked', true);

		$('#transferType').on('change', function() {
			if(!id){
				reset();
				//Adding default value
				$('#modeOfTransfer').append('<option selected></option>');
				$('#paymentType').append('<option  disabled selected></option>');
			}

			if ($('#transferType').val() == '1')
			{
				$('.clsArrival').show();
				$('.clsDeparture').hide();
				$('.clsRemarks').show();
				populateDropdowns(1);
			}
			else if ($('#transferType').val() == '2')
			{
				$('.clsArrival').hide();
				$('.clsDeparture').show();
				$('.clsRemarks').show();
				populateDropdowns(2);
			}
			else if ($('#transferType').val() == '3')
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
		
			console.log("length => ",$('#arrOriginDropOff').length);
        });

		if (id) {
			const displayText = meta.arr_origin_drop_off;

			$('#arrAirport').val(meta.arr_airport);
			
			$('#arrHotelResort').val(meta.arr_hotel);
			
			console.log(meta.arr_origin_drop_off);

			// $('#arrOriginDropOff').text(displayText);
			// $("#arrOriginDropOff").select2("val", $("#select option:contains(displayText)").val()).trigger('change');
		}

		$('#modeOfTransfer').on('change', function()
		{
			$('#hdModeOfTransfer').val($('#modeOfTransfer option:selected').text());
			$('#modeOfTransferPrice').val($(this).val());

			const str = $('#modeOfTransfer option:selected').text();
			// alert("MOD");

			if (str.includes("PRIVATE"))
			{
				let chargePrice = id ?  meta.transfer_mode_price : $(this).val();

				if($('#transferType').val() !== 3) chargePrice = chargePrice/2;

				$('#priceTitle').text(`Private Price/Head: `);
				$('#lblPrice').text(`P${chargePrice}`);
				$('#chargePriceHolder').val(chargePrice);
			}
			else if (str.includes("CHARTERED"))
			{
				$('#priceTitle').text(`Chartered Price: `);
				$('#lblPrice').text(`P${$(this).val()}`);
				$('#chargePriceHolder').val($(this).val());
			}
			else if (str.includes("SHARED"))
			{
				$('#priceTitle').text(`Price: `);
				$('#lblPrice').text(`P0.00`);
				$('#chargePriceHolder').val("0");
			}

			computeTotal();
		});
		
		$('#paymentType').on('change', function() {
			const str = $('#paymentType option:selected').text();
			if (str.includes("FREE")) $('#paymentStatus').val('1');
			else $('#paymentStatus').val('0');
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
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest1`,`#priceGuest1`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});

		$('#qtyGuest2').on('change', function() {
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest2`,`#priceGuest2`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});

		$('#qtyGuest3').on('change', function() {
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest3`,`#priceGuest3`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});

		$('#qtyGuest4').on('change', function() {
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest4`,`#priceGuest4`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});

		$('#qtyGuest5').on('change', function() {
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest5`,`#priceGuest5`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});

		$('#qtyGuest6').on('change', function() {
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest6`,`#priceGuest6`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});

		$('#qtyGuest7').on('change', function() {
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest7`,`#priceGuest7`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});

		$('#qtyGuest8').on('change', function() {
			const str = $('#modeOfTransfer option:selected').text();
			if (str.includes("SHARED")) computePrice(`#lblGuest8`,`#priceGuest8`,$(this).val());
			else if (str.includes("PRIVATE")) computeTotal(); 
		});
		

		$('#chkTerminalFee').change(function() {
			if ($(this).is(':checked')) {
				$("#terminalFee").val($("#terminalFeeHolder").val());
			} else {
				$("#terminalFee").val("0");
			}
			computeTotal();
		});

		$('#chkEnvFee').change(function() {
			if ($(this).is(':checked')) {
				$("#envFee").val($("#envFeeHolder").val());
			} else {
				$("#envFee").val("0");
			}
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

		//Save booking
		$('#frmBooking').on('submit', function(e) {
			e.preventDefault();

			start_loader()

			const formData = new FormData(this);
			
			for (let [key, value] of formData.entries()) {
				console.log(key, value);
			}

			let save = true;

			//ARRIVAL VALIDATIONS
			if ( $('#transferType').val() === "1" || $('#transferType').val() === "3")
			{
				if ($('#arrOriginDropOff').val() === '' || $('#arrOriginDropOff').val() === null) save = false;
				if ($('#arrDate').val() === '' || $('#arrDate').val() === null) save = false;
				if ($('#eta').val() === '' || $('#eta').val() === null) save = false;
				if ($('#arrAirport').val() === '' || $('#arrAirport').val() === null) save = false;
				if ($('#arrFlightNumber').val() === '' || $('#arrFlightNumber').val() === null) save = false;
				if ($('#arrHotelResort').val() === '' || $('#arrHotelResort').val() === null) save = false;
				
			}
			
			//DEPARTURE VALIDATIONS
			if ( $('#transferType').val() === "2" || $('#transferType').val() === "3")
			{
				if ($('#depOriginDropOff').val() === '' || $('#depOriginDropOff').val() === null) save = false;
				if ($('#depDate').val() === '' || $('#depDate').val() === null) save = false;
				if ($('#etd').val() === '' || $('#etd').val() === null) save = false;
				if ($('#depAirport').val() === '' || $('#depAirport').val() === null) save = false;
				if ($('#depFlightNumber').val() === '' || $('#depFlightNumber').val() === null) save = false;
				if ($('#depHotelResort').val() === '' || $('#depHotelResort').val() === null) save = false;
				if ($('#estpickup').val() === '' || $('#estpickup').val() === null) save = false;
			}

			if ($('#otherNames').val() === '' || $('#otherNames').val() === null) save = false;

			let hasQty = false;

			for(let x = 1; x<8; x++)
			{
				if ($('#qtyGuest' + x).val() !== '' && $('#qtyGuest' + x).val() > 0) hasQty = true;
			}

			if (save === false || hasQty === false)
			{
				$('#msg').html('<div class="alert alert-danger">Please complete all the required fields</div>')
				$("html, body").animate({ scrollTop: 0 }, "fast");
				return;
			}

			$.ajax({
				url: _base_url_+"classes/Booking.php?f=save_booking",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				success: function(resp) {
					if(resp == 1){
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
		});
	});
	
	function reset() {
		// Reset dropdowns
		$('#modeOfTransfer, #paymentType, #arrAirport, #arrHotelResort, #depAirport, #depHotelResort').empty();

		// Reset number input fields
		$('#qtyGuest1, #qtyGuest2, #qtyGuest3, #qtyGuest4, #qtyGuest5, #qtyGuest6, #qtyGuest7, #qtyGuest8').val('');
		$('#priceGuest1, #priceGuest2, #priceGuest3, #priceGuest4, #priceGuest5, #priceGuest6, #priceGuest7, #priceGuest8, #totalPrice').val('0');

		// Reset labels
		$('#lblGuest1, #lblGuest2, #lblGuest3, #lblGuest4, #lblGuest5, #lblGuest6, #lblGuest7, #lblGuest8').text('0.00');
		$('#lblPrice, #lblTotalPrice').text('P0.00');
	}

	function generateReservationID() {
		$.ajax({
			url: _base_url_+"classes/Booking.php?f=get_seq_no",
			type: 'GET',
			success: function(response) {
				let generatedID = 0;

				let data = parseInt(response);
				// console.log(data);
				if (data === 0)
				{
					const now = new Date();
					const year = now.getFullYear();
					const lastTwoDigits = year.toString().slice(-2);
					const month = String(now.getMonth() + 1).padStart(2, '0');
					const day = String(now.getDate()).padStart(2, '0');
					const hours = String(now.getHours()).padStart(2, '0');
					const minutes = String(now.getMinutes()).padStart(2, '0');
					const seconds = String(now.getSeconds()).padStart(2, '0');

					generatedID = `${lastTwoDigits}${month}${day}${hours}${minutes}${seconds}0001`
				}
				else
				{
					data += 1;
					generatedID = data.toString();
				}
				
				var idss = document.getElementById('id').value;
				if(idss==0)$('#reserveNum').val(generatedID);
			}
		});
	};

	function computePrice(targetField, hiddenField, quantity)
	{
		/* const transType = $('#transferType').val().toUpperCase();
		const arrOriginDropOffPrice = parseInt($('#arrOriginDropOffPrice').val()) || 0;
		const depOriginDropOffPrice = parseInt($('#depOriginDropOffPrice').val()) || 0;
		let originPrice = 0;

		if (transType === "ARRIVAL") originPrice = arrOriginDropOffPrice;
		else if (transType === "DEPARTURE") originPrice = depOriginDropOffPrice;
		else if (transType === "ROUNDTRIP") originPrice = arrOriginDropOffPrice + depOriginDropOffPrice;
 */
		const modeOfTransferPrice = parseInt($('#modeOfTransferPrice').val()) || 0;

		const modeOfTransfers = globalMOT;

		let selectedMode = modeOfTransfers.find(t => t.title === $('#modeOfTransfer option:selected').text());

		let guestPrice = 0;
		
		//lblGuest1
		switch (targetField){
			case "#lblGuest1":
				guestPrice = selectedMode.guestPrice1;
				break;
			case "#lblGuest2":
				guestPrice = selectedMode.guestPrice2;
				break;
			case "#lblGuest3":
				guestPrice = selectedMode.guestPrice3;
				break;
			case "#lblGuest4":
				guestPrice = selectedMode.guestPrice4;
				break;
			case "#lblGuest5":
				guestPrice = selectedMode.guestPrice5;
				break;
			case "#lblGuest6":
				guestPrice = selectedMode.guestPrice6;
				break;
			case "#lblGuest7":
				guestPrice = selectedMode.guestPrice7;
				break;
			case "#lblGuest8":
				guestPrice = selectedMode.guestPrice8;
				break;
			default:
				guestPrice = 0;
		}

		const total = guestPrice * parseInt(quantity);
		
		$(targetField).text(`P${total.toFixed(2)}`);
		$(hiddenField).val(`${total.toFixed(2)}`);

		computeTotal();
	};

	function computeTotal()
	{

		let totalQty = 0;
		let privatePrice = 0;
		let price = 0;
		const str = $('#modeOfTransfer option:selected').text();

		if (str.includes("SHARED"))
		{
			const guest1 = parseFloat($("#priceGuest1").val()) || 0;
			const guest2 = parseFloat($("#priceGuest2").val()) || 0;
			const guest3 = parseFloat($("#priceGuest3").val()) || 0;
			const guest4 = parseFloat($("#priceGuest4").val()) || 0;
			const guest5 = parseFloat($("#priceGuest5").val()) || 0;
			const guest6 = parseFloat($("#priceGuest6").val()) || 0;
			const guest7 = parseFloat($("#priceGuest7").val()) || 0;
			const guest8 = parseFloat($("#priceGuest8").val()) || 0;

			const totalGuestPrice = parseFloat(guest1) + parseFloat(guest2) + parseFloat(guest3) + parseFloat(guest4) + parseFloat(guest5) + parseFloat(guest6) + parseFloat(guest7) + parseFloat(guest8);
			// const totalGuestPrice = guest1 + guest2 + guest3 + guest4 + guest5;
			// console.log("totalGuestPrice>>",totalGuestPrice);

			$('#priceTitle').text(`Price: `);
			$('#lblPrice').text(`P${totalGuestPrice}`);
			// $('#chargePrice').val(`${totalGuestPrice}`);
			price = totalGuestPrice;
		}
		else if (str.includes("PRIVATE"))
		{
			const guest1 = parseInt($("#qtyGuest1").val()) || 0;
			const guest2 = parseInt($("#qtyGuest2").val()) || 0;
			const guest3 = parseInt($("#qtyGuest3").val()) || 0;
			const guest4 = parseInt($("#qtyGuest4").val()) || 0;
			const guest5 = parseInt($("#qtyGuest5").val()) || 0;
			const guest6 = parseInt($("#qtyGuest6").val()) || 0;
			const guest8 = parseInt($("#qtyGuest8").val()) || 0;

			totalQty = guest1 + guest2 + guest3 + guest4 + guest5 + guest6 + guest8;

			// if (totalQty < 1) alert("NOPE");
			// console.log("totalQty>>",totalQty);
			const transferType = $('#transferType').val();
			let chargePrice = parseFloat($('#chargePriceHolder').val());

			if (transferType != 3) chargePrice = chargePrice/2;
			// console.log("chargePrice>>", chargePrice);
			// console.log("totalQty>>", totalQty);
			privatePrice = chargePrice * totalQty;
			price = privatePrice;
			// console.log("price>>", price);
		}
		else if (str.includes("CHARTERED")) price = $('#chargePriceHolder').val();

		let terminalFee = $("#terminalFee").val() || 0;
		let envFee = $("#envFee").val() || 0;
		// console.log("terminalFee>>",terminalFee);
		// console.log("envFee>>",envFee);
		
		// console.log("price>>",price);

		const total = parseFloat(price) + parseFloat(terminalFee) + parseFloat(envFee);

		// console.log("price>>",total);

		$('#chargePrice').val(price);
		$("#lblTotalPrice").text(`P${parseFloat(total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`);
		$("#totalPrice").val(`${parseFloat(total).toFixed(2)}`);
	};

	function populateDropdowns(transferType)
	{
		$.ajax({
			url: _base_url_+"classes/Booking.php?f=get_reference_table",
			type: 'GET',
			success: function(response) {
				
				let data = JSON.parse(response);

				let arrPaymentModes = [];
				let arrPaymentTypes = [];
				let arrOriginDropOffs = [];
				let arrAirports = [];
				let arrHotelResorts = [];
				let depOriginDropOffs = [];

				$.each(data, function(index, item) {

					if (item.code == 'MOT') arrPaymentModes.push({title: item.title, description: item.description, amount: item.amount, guestPrice1: item.price_guest_1, guestPrice2: item.price_guest_2, guestPrice3: item.price_guest_3, guestPrice4: item.price_guest_4, guestPrice5: item.price_guest_5, guestPrice6: item.price_guest_6, guestPrice7: item.price_guest_7, guestPrice8: item.price_guest_8});

					if (transferType === 1) arrPaymentModes = arrPaymentModes.filter(mode => !mode.title.includes("DEPARTURE") && !mode.title.includes("ROUNDTRIP"));
					else if (transferType === 2) arrPaymentModes = arrPaymentModes.filter(mode => !mode.title.includes("ARRIVAL") && !mode.title.includes("ROUNDTRIP"));
					else if (transferType === 3) arrPaymentModes = arrPaymentModes.filter(mode => !mode.title.includes("ARRIVAL") && !mode.title.includes("DEPARTURE"));

					if (parseInt(item.type) === 1)
					{
						if (item.code == 'ODL') arrOriginDropOffs.push({amount: item.amount, description: item.description});
					}
					else if (parseInt(item.type) === 2)
					{
						if (item.code == 'ODL') depOriginDropOffs.push({amount: item.amount, description: item.description});
					}
					else if (parseInt(item.type) === 3)
					{
						if (item.code == 'PT') arrPaymentTypes.push({title: item.title, description: item.description});
						else if (item.code == 'AP') arrAirports.push({title: item.title, description: item.description});
						else if (item.code == 'HR') arrHotelResorts.push({title: item.title, description: item.description});
					}

					if (item.code == 'TC')
					{
						if (item.title == 'TERMINAL')
						{
							const amount = parseFloat(item.amount);
							$("#lblTerminalFee").text(`P${amount.toFixed(2)}`);
							$("#terminalFeeHolder").val(`${amount.toFixed(2)}`);
						}
						if (item.title == 'ENVIRONMENT')
						{
							const amount = parseFloat(item.amount);
							$("#lblEnvFee").text(`P${amount.toFixed(2)}`);
							$("#envFeeHolder").val(`${amount.toFixed(2)}`);
						}

					}

				});

				globalMOT = arrPaymentModes;
				
				//Populating dropdowns
				$.each(arrPaymentModes, function(index, item) {
					$('#modeOfTransfer').append('<option value="' + item.amount + '">' + item.title + '</option>');
				});

				$.each(arrPaymentTypes, function(index, item) {
					$('#paymentType').append('<option value="' + item.title + '">' + item.description + '</option>');
				});

				console.log("transferType >",transferType);
				if (transferType === 1 || transferType === 3) {

					if (!id)
					{
						$('#arrOriginDropOff').empty();
						
						$('#arrOriginDropOff').append('<option  disabled selected></option>');
						$('#arrAirport').append('<option value="" disabled selected></option>');
						$('#arrHotelResort').append('<option value="" disabled selected></option>');
					}

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

					if (!id)
					{
						$('#depOriginDropOff').empty();
						$('#depAirport').empty();
						$('#depHotelResort').empty();
						$('#depOriginDropOff').append('<option  disabled selected></option>');
						$('#depAirport').append('<option value="" disabled selected></option>');
						$('#depHotelResort').append('<option value="" disabled selected></option>');
					}

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