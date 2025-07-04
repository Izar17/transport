<?php
require_once('./../../config.php');

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM `booking` WHERE id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $data = $qry->fetch_assoc();
        
        // Calculate total pax dynamically from qty_guest_1 to qty_guest_8
        $total_pax = $data['qty_guest_1'] + $data['qty_guest_2'] + $data['qty_guest_3'] + $data['qty_guest_4'] + 
                     $data['qty_guest_5'] + $data['qty_guest_6'] + $data['qty_guest_7'] + $data['qty_guest_8'];
    } else {
        echo "<center>No Booking Found.</center>";
        exit;
    }
}
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'view';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - VS Makan Transport, Inc.</title>
    
	<style>
		#uni_modal .modal-footer{
			display:none
		}
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 10px; }
        .container { width: 96%; max-width: 800px; border: 2px solid #000; padding: 10px; }
        .header { text-align: center; font-size: 20px; font-weight: bold; }
        .section { padding: 10px; border-bottom: 1px solid #ddd; display: flex; flex-wrap: wrap; }
        .section h3 { width: 100%; font-size: 20px; font-weight: bold; margin-bottom: 5px; text-align: left; }
        .data-item { width: 20%; text-align: left; }
        .label { font-weight: bold; display: block; }
        .footer { text-align: center; margin-top: 20px; font-style: italic; }
    </style>
</head>
<body onload="window.print(); window.onafterprint = function(){ window.close(); }">
<!-- <body> -->
    <div class="container">
        <div style="text-align: center; margin-bottom: 10px;">
            <img src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo" class="img-thumbnail rounded-circle" id="logo-img" style="height: 150px; width: 150px; object-fit: contain;">
        </div>
        <div class="header">VS Makan Transport, Inc.</div>
        <p style="text-align: center;">Thank you for choosing VS Makan Transport, Inc.</p>

        <!-- Booking Information -->
        <div class="section">
            <h3>Booking Details</h3>
            <div class="data-item"><span class="label">Reference No:</span> <?php echo $data['reserve_num']; ?></div>
            <div class="data-item"><span class="label">Transfer Type:</span>
			<?php 
				switch($data['transfer_type']){
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
						echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
						break;
				}
			?>
			</div>
            <div class="data-item"><span class="label">Processed By:</span> <?php echo $data['created_by']; ?></div>
            <div class="data-item"><span class="label">Created Date:</span> <?php echo date("Y-m-d H:i:s", strtotime($data['created_date'])); ?></div>
            <div class="data-item"><span class="label">Driver:</span> <?php echo $data['driver_name']; ?></div>
        </div>

        <!-- Guest Information -->
        <div class="section">
            <h3>Guest Details</h3>
            <div class="data-item"><span class="label">Lead Guest:</span> <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></div>
            <div class="data-item"><span class="label">Contact No:</span> <?php echo $data['contact_no']; ?></div>
            <div class="data-item"><span class="label">Email:</span> <?php echo $data['email_address']; ?></div>
            <div class="data-item"><span class="label">Other Names:</span> <?php echo $data['other_names']; ?></div>
            <div class="data-item"><span class="label">Total Pax: <?php echo $total_pax; ?></span> 
            <?php echo $data['qty_guest_1'] > 0? 'Adult(Local): ' . $data['qty_guest_1'] .'<br>' :'' ?>
            <?php echo $data['qty_guest_2'] > 0? 'Adult(Foreign): ' . $data['qty_guest_2'] .'<br>' :'' ?>
            <?php echo $data['qty_guest_3'] > 0? 'Senior/PWD: ' . $data['qty_guest_3'] .'<br>' :'' ?>
            <?php echo $data['qty_guest_4'] > 0? 'Child Local(6-12 yo): ' . $data['qty_guest_4'] .'<br>' :'' ?>
            <?php echo $data['qty_guest_5'] > 0? 'Child Foreign(6-12 yo): ' . $data['qty_guest_5'] .'<br>' :'' ?>
            <?php echo $data['qty_guest_6'] > 0? 'Child (3-5 yo): ' . $data['qty_guest_6'] .'<br>':'' ?>
            <?php echo $data['qty_guest_7'] > 0? '2 yo and below/FOC: ' . $data['qty_guest_7'] .'<br>' :'' ?>
            <?php echo $data['qty_guest_8'] > 0? 'Resident: ' . $data['qty_guest_8'] :'' ?>
                
                
            </div>
        </div>

        <!-- Transfer Details -->
        <div class="section">
            
            <h3>Transfer Information</h3>
            <span class="label">Mode of Transfer: </span><?php echo $data['transfer_mode']; ?>
            <div class="data-item" style="width:100%"><span class="label"><h4>ARRIVAL DETAILS</h4></span></div>
            <div class="data-item" style="width: 40%;"><span class="label">Origin Pick-up & Drop-off Location:</span> <?php echo $data['arr_origin_drop_off']; ?></div>
            <div class="data-item"><span class="label">Airport:</span> <?php echo $data['arr_airport']; ?></div>
            <div class="data-item"><span class="label">Flight No:</span> <?php echo $data['arr_flight_no']; ?></div>
            <div class="data-item"><span class="label">Arrival Date / ETA:</span> <?php echo $data['arr_date']; ?> <?php echo $data['arr_eta']; ?></div>
		
            <div class="data-item" style="width:100%"><span class="label"><h4>DEPARTURE DETAILS</h4></span></div>
            <div class="data-item" style="width: 40%;"><span class="label">Origin Pick-up & Drop-off Location:</span> <?php echo $data['dep_origin_drop_off']; ?></div>
            <div class="data-item"><span class="label">Airport:</span> <?php echo $data['dep_airport']; ?></div>
            <div class="data-item"><span class="label">Flight No:</span> <?php echo $data['dep_flight_no']; ?></div>
            <div class="data-item"><span class="label">
                Arrival Date / ETA:</span> <?php echo $data['dep_date']; ?> <?php echo $data['dep_etd']; ?><br>
                <b>Estimated Pick-up Time:</b> <?php echo $data['est_pickup']; ?>
            </div>
        </div>

        <!-- Pricing Breakdown -->
        <div class="section">
            <h3>Payment Details</h3>
            <div class="data-item"><span class="label">Status:</span> 
			<?php 
				switch($data['status']){
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
					case 5:
						echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Cancelled</span>';
						break;
					default:
						echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
						break;
				}
			?>
			</div>
            <div class="data-item"><span class="label">Total Amount:</span> ₱<?php echo number_format($data['total_price'], 2); ?></div>
            <div class="data-item"><span class="label">Payment Type:</span> <?php echo $data['payment_type']; ?></div>
            <div class="data-item"><span class="label">Payment Remarks:</span> <?php echo $data['payment_remarks']; ?></div>
        </div>

        <div class="footer">We look forward to serving you!</div>
    </div>
	<div class="clear-fix mb-3"></div>
	<?php if ($mode == "view") { ?>
		<div class="text-center">
			<button class="btn btn-default bg-gradient-dark text-light btn-sm btn-flat" type="button" data-dismiss="modal">
				<i class="fa fa-times"></i> Close
			</button>
		</div>
	<?php } ?>

</body>
</html>