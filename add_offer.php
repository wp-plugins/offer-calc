<?php 

// declare what to be done - add, edit or delete. Set default values (or fill with existing ones)
$offer_action = 'add'; 
$offer_slug = 'myform';
$offer_name = '';
$number_fields = '0';

// edit call
if(isset($_GET['item_id']) && isset($_GET['action_type']) && $_GET['action_type'] == 'edit') {
	$offer_action = 'edit';
	$item_id = $_GET['item_id'];
	global $wpdb;
	
	$offer_data = $wpdb->get_row('SELECT * FROM offercalc_offers WHERE id = '. $item_id);
	
	if($wpdb->num_rows == 0) {
		echo "Wrong ID supplied. "; 
		wp_die();
	}
	
	$offer_slug = $offer_data->slug;
	$offer_name = $offer_data->name;
	$number_fields = $offer_data->number_fields;

	$offer_fields = $wpdb->get_results("SELECT * FROM offercalc_fields WHERE offer_slug = '$offer_slug'");
}

//delete call
// TODO: delete

?>


<div>
	<h1>Offer Calc</h1>

<h5>The slug is the unique ID of the form to be used in the sidebar or shortcode in a post. The name is the title of the form.</h5>

<form action="admin.php?page=offer-calc" method="post">
	<p>Form Slug: <input id="offer_slug" type="text" name="offer_slug" value="<?php echo $offer_slug; ?>" /></p>
	<p>Form name: <input id="offer_name" type="text" name="offer_name" value="<?php echo $offer_name; ?>" /></p>

	<p>Select the number of services you will provide: </p>
	<p>
		<select id="offer_number" name="offer_number">
			<?php for($i = 0; $i < 40; $i++):?>
				<option value="<?php echo $i?>" <?php if($number_fields == $i) { echo "selected";}?>><?php echo $i; ?></option>
			<?php endfor;?>
		</select>
	</p>
	
	<table id="offer_table">
	<?php if($offer_action == 'edit'):?>
		
		<?php
		$i = 1;
		foreach($offer_fields as $field): ?>
			<tr>
				<td><input type='text' value='<?php echo $field->name; ?>' name='<?php echo $offer_slug; ?>_offername_<?php echo $i; ?>' /></td>
				<td><input type='text' value='<?php echo $field->price; ?>' name='<?php echo $offer_slug; ?>_offerprice_<?php echo $i; ?>' /></td>
			</tr>
			
		<?php 
		$i++;
		endforeach; ?>
	<?php endif; ?>
	</table>

	<?php if($offer_action == 'edit'):?>
		<input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
	<?php endif; ?>
	<input type="hidden" name="offer_action" value="<?php echo $offer_action; ?>" />
	<input type="submit" value="Submit form" />	
</form>
	
	<!-- adds the appropriate number of rows -->
	<script type="text/javascript">
		jQuery('#offer_number').change(function() {
			var offer_num = jQuery('#offer_number').val();
			var offer_slug = jQuery('#offer_slug').val();

			if(offer_slug == '') {
				alert('Form slug could not be empty.');
				return;
			}

			var html;

			// get all the rows and set them in the table
			for(var i = 1; i <= offer_num; i++) {
				html += "<tr>";
				html += "<td><input type='text' value='service name " + i + "' name='" + offer_slug + "_offername_" + i + "' /></td>";
				html += "<td><input type='text' value='0.0' name='" + offer_slug + "_offerprice_" + i + "' /></td>";
				html += "</tr>";	
			}

			jQuery('#offer_table').html(html);
		});
	</script>
</div>