<select name="ward" id="ward" class="form-control">
	<option value="">Select a ward</option>
	<?php
	if (!empty($wards)) {
		foreach ($wards as $ward) {
	?>
		<option value="<?php echo($ward['ward_no'])?>"><?php echo($ward['ward_no'])?></option>
	<?php		
		}
	}
	?>
</select>