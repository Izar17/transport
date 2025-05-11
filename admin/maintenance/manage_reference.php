
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM reference_table where id ='{$_GET['id']}'");
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
<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage_reference">	
                <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
                <div class="row">
                    <!-- Left Panel -->
                    <div class="col-md-6">
                        <!-- <h4>Left Panel</h4> -->
                        <div class="form-group">
                            <label for="code">Select Dropdown</label>
                            <select name="code" id="code" class="custom-select" required onchange="toggleFields()">
                                <option></option>
                                <option value="MOT" <?php echo isset($meta['code']) && $meta['code'] == 'MOT' ? 'selected' : '' ?>>MODE OF TRANSFER</option>
                                <option value="PT" <?php echo isset($meta['code']) && $meta['code'] == 'PT' ? 'selected' : '' ?>>PAYMENT TYPE</option>
                                <option value="ODL" <?php echo isset($meta['code']) && $meta['code'] == 'ODL' ? 'selected' : '' ?>>ORIGIN PICK-UP AND DROP OFF LOCATION</option>
                                <option value="AP" <?php echo isset($meta['code']) && $meta['code'] == 'AP' ? 'selected' : '' ?>>AIRPORT</option>
                                <option value="HR" <?php echo isset($meta['code']) && $meta['code'] == 'HR' ? 'selected' : '' ?>>HOTEL/RESORT</option>
                                <option value="TC" <?php echo isset($meta['code']) && $meta['code'] == 'TC' ? 'selected' : '' ?>>TRANSFER CHARGE</option>
                            </select>	
                        </div>
                        <div id="motTypeContainer" class="form-group" style="display: none;">
                            <label for="mot_type">Mode of Transfer Type</label>
                            <select name="mot_type" id="mot_type" class="custom-select" onchange="showGuest(this.value)">
                                <option></option>
                                <option value="1" <?php echo isset($meta['mot_type']) && $meta['mot_type'] == 1 ? 'selected' : '' ?>>SHARED</option>
                                <option value="2" <?php echo isset($meta['mot_type']) && $meta['mot_type'] == 2 ? 'selected' : '' ?>>PRIVATE</option>
                                <option value="3" <?php echo isset($meta['mot_type']) && $meta['mot_type'] == 3 ? 'selected' : '' ?>>CHARTERED</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Transfer Type</label>
                            <select name="type" id="type" class="custom-select" required>
                                <option></option>
                                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>ARRIVAL</option>
                                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>DEPARTURE</option>
                                <option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected' : '' ?>>N/A</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo isset($meta['title']) ? $meta['title']: '' ?>" required autocomplete="off" oninput="this.value = this.value.toUpperCase()">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" value="<?php echo isset($meta['description']) ? $meta['description']: '' ?>" required autocomplete="off">
                        </div>
                        <div id="amountContainer" class="form-group" style="display: none;">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" value="<?php echo isset($meta['amount']) ? $meta['amount']: '' ?>" required autocomplete="off">
                        </div>
                    </div>

                    <!-- Right Panel -->
                    <div id="rightPanel" class="col-md-6" style="display: none;">
                        <!-- <h4>Right Panel</h4> -->
                        <?php 
                        $fields = [
                            'price_guest_1' => 'Adult (Local)',
                            'price_guest_2' => 'Adult (Foreign)',
                            'price_guest_3' => 'Senior/PWD',
                            'price_guest_4' => 'Child Local (6-12 yo)',
                            'price_guest_5' => 'Child Foreign (6-12 yo)',
                            'price_guest_6' => 'Child (3-5 yo)',
                            'price_guest_7' => 'Child 2 yo and below / FOC Employee',
                            'price_guest_8' => 'Resident (No Terminal and Environment Fee)'
                        ];
                        foreach($fields as $key => $label): ?>
                        <div class="form-group">
                            <label for="<?php echo $key; ?>"><?php echo $label; ?></label>
                            <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" class="form-control" value="<?php echo isset($meta[$key]) ? $meta[$key]: '' ?>" required autocomplete="off">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-md-12">
            <div class="row">
                <button class="btn btn-sm btn-primary mr-2" form="manage_reference">Save</button>
                <a class="btn btn-sm btn-secondary" href="./?page=maintenance">Cancel</a>
            </div>
        </div>
    </div>
</div>

<script>
$('#manage_reference').submit(function(e){
        e.preventDefault();
        start_loader();
        $.ajax({
            url: _base_url_ + 'classes/Maintenance.php?f=save',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success:function(resp){
                if(resp == 1){
                    location.href = './?page=maintenance';
                } else {
                    $('#msg').html('<div class="alert alert-danger">Reference already exists</div>');
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                }
                end_loader();
            }
        });
    });


window.onload = function() {
    toggleFields();
    let motTypeDropdown = document.getElementById('mot_type');
    if (motTypeDropdown) {
        showGuest(motTypeDropdown.value);
    }
}; 
function toggleFields() {
    let dropdown = document.getElementById('code').value;
    let motTypeContainer = document.getElementById('motTypeContainer');
    let rightPanel = document.getElementById('rightPanel');
    let amountContainer = document.getElementById('amountContainer');
    let amountField = document.getElementById('amount');


    
    if (dropdown) {
        showGuest(dropdown.value);
    }
    // Get all guest price fields
    let guestFields = [
        'price_guest_1', 'price_guest_2', 'price_guest_3',
        'price_guest_4', 'price_guest_5', 'price_guest_6', 'price_guest_7', 'price_guest_8'
    ];

    if (dropdown === "MOT") {
        motTypeContainer.style.display = "block";
        amountContainer.style.display = "none";
        amountField.removeAttribute("required");
    } else if (dropdown === "TC") {
        amountContainer.style.display = "block";
        motTypeContainer.style.display = "none";
        rightPanel.style.display = "none";
        amountField.setAttribute("required", "required");

        // Remove required attribute from guest fields
        guestFields.forEach(field => {
            document.getElementById(field).removeAttribute("required");
        });

    } else {
        motTypeContainer.style.display = "none";
        rightPanel.style.display = "none";
        amountContainer.style.display = "none";
        amountField.removeAttribute("required");

        // Remove required attribute from guest fields
        guestFields.forEach(field => {
            document.getElementById(field).removeAttribute("required");
        });
    }
}
function showGuest(id){
    let rightPanel = document.getElementById('rightPanel');
    let amountContainer = document.getElementById('amountContainer');
    let amountField = document.getElementById('amount');

    // Get all guest price fields
    let guestFields = [
        'price_guest_1', 'price_guest_2', 'price_guest_3',
        'price_guest_4', 'price_guest_5', 'price_guest_6', 'price_guest_7', 'price_guest_8'
    ];

    if(id == 1 || id == 3){
        rightPanel.style.display = "block";
        amountContainer.style.display = "block";
    }else{

        rightPanel.style.display = "none";
        amountContainer.style.display = "block";
        amountField.setAttribute("required", "required");
        // Remove required attribute from guest fields
        guestFields.forEach(field => {
            document.getElementById(field).removeAttribute("required");
        });
    }
}
</script>