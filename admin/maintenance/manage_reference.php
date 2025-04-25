
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
				<div class="form-group col-6">
					<label for="type">Transfer Type</label>
					<select name="type" id="type" class="custom-select" required>
						<option></option>
						<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Arrival</option>
						<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Departure</option>
						<option value="3" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>N/A</option>
					</select>
				</div>
				<div class="form-group col-6">
					<label for="code">Code</label>
					<select name="code" id="code" class="custom-select" required>
						<option></option>
						<option value="MOT" <?php echo isset($meta['code']) && $meta['code'] == 1 ? 'selected' : '' ?>>Mode of Transfer</option>
						<option value="PT" <?php echo isset($meta['code']) && $meta['code'] == 2 ? 'selected' : '' ?>>Payment Type</option>
						<option value="OPL" <?php echo isset($meta['code']) && $meta['code'] == 3 ? 'selected' : '' ?>>Origin/Pick-up Location</option>
						<option value="DO" <?php echo isset($meta['code']) && $meta['code'] == 4 ? 'selected' : '' ?>>Drop Off</option>
						<option value="AP" <?php echo isset($meta['code']) && $meta['code'] == 5 ? 'selected' : '' ?>>Airport</option>
						<option value="HR" <?php echo isset($meta['code']) && $meta['code'] == 6 ? 'selected' : '' ?>>Hotel/Resort</option>
					</select>	
				</div>
				<div class="form-group col-6">
					<label for="title">Title</label>
					<input type="text" name="title" id="title" class="form-control" value="<?php echo isset($meta['title']) ? $meta['title']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group col-6">
					<label for="description">Description</label>
					<input type="text" name="description" id="description" class="form-control" value="<?php echo isset($meta['description']) ? $meta['description']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group col-6">
					<label for="amount">Amount</label>
					<input type="text" name="amount" id="amount" class="form-control" value="<?php echo isset($meta['amount']) ? $meta['amount']: '' ?>" required  autocomplete="off">
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
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_reference').submit(function(e){
		e.preventDefault();
var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Maintenance.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.href = './?page=maintenance';
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})

</script>