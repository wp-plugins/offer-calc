<?php

if(isset($_POST['form_id'])) {
	$form_id = $_POST['form_id'];
	$form_name = $_POST['form_name'];
	$offer_number = $_POST['offer_number'];
	
	if(empty($form_id)) {
		wp_die('ID cannot be empty');
	}
	
	global $wpdb;

	// Insert when adding a new record
	if(isset($_POST['form_action']) && $_POST['form_action'] == 'add') {
		$wpdb->query("INSERT INTO offercalc_offers(name, slug, number_fields) VALUES('$form_name', '$form_id', $offer_number);");
		
		for($i = 1; $i <= $offer_number; $i++) {
			$offer_name_str = $form_id. '_offername_'. $i;
			$offer_name = $_POST[$offer_name_str];
			$offer_price_str = $form_id. '_offerprice_'. $i;
			$offer_price = $_POST[$offer_price_str];
			
			$wpdb->query("INSERT INTO offercalc_fields(name, price, offer_slug) VALUES('$offer_name', $offer_price, '$form_id');");
		}
	}
	
	// And, of course, update on old record ;)
	else if(isset($_POST['form_action']) && $_POST['form_action'] == 'edit') {
		if(!isset($_POST['offer_id'])) {
			wp_die('No offer ID aquired. ');
		}
		
		$offer_id = $_POST['offer_id'];
		
		$wpdb->query("UPDATE offercalc_offers SET name='$form_name', slug='$form_id', offer_number=$offer_number WHERE id=$offer_id;");
		
		$wpdb->query("DELETE FROM offercalc_fields WHERE offer_slug='$form_id'");
		
		for($i = 1; $i <= $offer_number; $i++) {
			$offer_name_str = $form_id. '_offername_'. $i;
			$offer_name = $_POST[$offer_name_str];
			$offer_price_str = $form_id. '_offerprice_'. $i;
			$offer_price = $_POST[$offer_price_str];
			
			$wpdb->query("INSERT INTO offercalc_fields(name, price, offer_slug) VALUES('$offer_name', $offer_price, '$form_id');");
		}
	}
	
	echo "<div>Form data saved successfully.</div>"; 
}

	// delete record.
	// TODO: check for permissions 
	if(isset($_GET['form_action']) && $_GET['form_action'] == 'delete') {
		if(!isset($_GET['offer_id'])) {
			wp_die('No offer ID aquired. ');
		}
		
		global $wpdb;
		
		$offer_id = $_GET['offer_id'];
		
		$offer_data = $wpdb->get_row('SELECT * FROM offercalc_offers WHERE id = '. $offer_id);
	
		if($wpdb->num_rows == 0) {
			echo "Wrong ID supplied. "; 
			wp_die();
		}
		
		$form_id = $offer_data->slug;
		
		$wpdb->query("DELETE FROM offercalc_offers WHERE id=$offer_id;");
		$wpdb->query("DELETE FROM offercalc_fields WHERE offer_slug='$form_id';");
		$wpdb->flush();
	}


?>


<div id="forms">
	<p>List of forms: </p>
	<table style="border: 1px solid black">
		<tr>
			<th>Form name</th>
			<th>Form slug/ID </th>
			<th>Delete</th>
		</tr>
	<?php

		// TODO: expand and allow edit/delete
		global $wpdb;
		
		$offers = $wpdb->get_results('SELECT * FROM offercalc_offers;');
		foreach($offers as $offer):
	?>
	<tr>
		<td><?php echo $offer->name; ?></td>
		<td><a href="admin.php?page=add-offer&action_type=edit&offer_id=<?php echo $offer->id?>"><?php echo $offer->slug; ?></a></td>
		<td><a href="admin.php?page=offer-calc&form_action=delete&offer_id=<?php echo $offer->id?>" onclick="confirm('Are you sure you want to delete form <?php echo $offer->id; ?>?')">Delete</a></td>
	</tr>
	<?php endforeach;?>
	</table>
</div>