<?php 

// declare what to be done - add, edit or delete. Set default values (or fill with existing ones)
$form_action = 'add'; 
$form_id = 'myform';
$form_name = '';
$number_fields = '0';

// edit call
if(isset($_GET['offer_id']) && isset($_GET['action_type']) && $_GET['action_type'] == 'edit') {
	$form_action = 'edit';
	$offer_id = $_GET['offer_id'];
	global $wpdb;
	
	$offer_data = $wpdb->get_row('SELECT * FROM offercalc_offers WHERE id = '. $offer_id);
	
	if($wpdb->num_rows == 0) {
		echo "Wrong ID supplied. "; 
		wp_die();
	}
	
	$form_id = $offer_data->slug;
	$form_name = $offer_data->name;
	$number_fields = $offer_data->number_fields;

	$offer_fields = $wpdb->get_results("SELECT * FROM offercalc_fields WHERE offer_slug = '$form_id'");
}

//delete call
// TODO: delete

?>


<div>
	<h1>Offer Calc</h1>

<form action="admin.php?page=offer-calc" method="post">
	<p>Form ID: <input id="form_id" type="text" name="form_id" value="<?php echo $form_id; ?>" /></p>
	<p>Form name: <input id="form_name" type="text" name="form_name" value="<?php echo $form_name; ?>" /></p>

	<p>Select the number of services you will provide: </p>
	<p>
		<select id="offer_number" name="offer_number">
			<?php for($i = 0; $i < 40; $i++):?>
				<option value="<?php echo $i?>" <?php if($number_fields == $i) { echo "selected";}?>><?php echo $i; ?></option>
			<?php endfor;?>
		</select>
	</p>
	
	<table id="offer_table">
	<?php if($form_action == 'edit'):?>
		
		<?php
		$i = 1;
		foreach($offer_fields as $field): ?>
			<tr>
				<td><input type='text' value='<?php echo $field->name; ?>' name='<?php echo $form_id; ?>_offername_<?php echo $i; ?>' /></td>
				<td><input type='text' value='<?php echo $field->price; ?>' name='<?php echo $form_id; ?>_offerprice_<?php echo $i; ?>' /></td>
			</tr>
			
		<?php 
		$i++;
		endforeach; ?>
	<?php endif; ?>
	</table>

	<?php if($form_action == 'edit'):?>
		<input type="hidden" name="offer_id" value="<?php echo $offer_id; ?>" />
	<?php endif; ?>
	<input type="hidden" name="form_action" value="<?php echo $form_action; ?>" />
	<input type="submit" value="Submit form" />	
</form>
	
	<!-- adds the appropriate number of rows -->
	<script type="text/javascript">
		jQuery('#offer_number').change(function() {
			var offer_num = jQuery('#offer_number').val();
			var form_id = jQuery('#form_id').val();

			if(form_id == '') {
				alert('Form ID could not be empty.');
				return;
			}

			var html;

			// get all the rows and set them in the table
			for(var i = 1; i <= offer_num; i++) {
				html += "<tr>";
				html += "<td><input type='text' value='service name " + i + "' name='" + form_id + "_offername_" + i + "' /></td>";
				html += "<td><input type='text' value='0.0' name='" + form_id + "_offerprice_" + i + "' /></td>";
				html += "</tr>";	
			}

			jQuery('#offer_table').html(html);
		});
	</script>
</div>