<?php

// if submitted data 
if(isset($_POST['offer_slug'])) {
	$offer_slug = $_POST['offer_slug'];
	$offer_name = $_POST['offer_name'];
	$offer_number = $_POST['offer_number'];
	
	if(empty($offer_slug)) {
		wp_die('ID cannot be empty');
	}
	
	global $wpdb;

	// Insert when adding a new record
	if(isset($_POST['offer_action']) && $_POST['offer_action'] == 'add') {
		$wpdb->query("INSERT INTO offercalc_offers(name, slug, number_fields) VALUES('$offer_name', '$offer_slug', $offer_number);");
		
		for($i = 1; $i <= $offer_number; $i++) {
			$offer_name_str = $offer_slug. '_offername_'. $i;
			$offer_name = $_POST[$offer_name_str];
			$offer_price_str = $offer_slug. '_offerprice_'. $i;
			$offer_price = $_POST[$offer_price_str];
			
			$wpdb->query("INSERT INTO offercalc_fields(name, price, offer_slug) VALUES('$offer_name', $offer_price, '$offer_slug');");
		}
	}
	
	// And, of course, update on old record ;)
	else if(isset($_POST['offer_action']) && $_POST['offer_action'] == 'edit') {
		if(!isset($_POST['item_id'])) {
			wp_die('No offer ID aquired. ');
		}
		
		// get the slug
		$item_id = $_POST['item_id'];
		
		// update major form data
		$wpdb->query("UPDATE offercalc_offers SET name='$offer_name', slug='$offer_slug', offer_number=$offer_number WHERE id=$item_id;");
		
		// delete old field data
		$wpdb->query("DELETE FROM offercalc_fields WHERE offer_slug='$offer_slug'");
		
		// populate them all along
		for($i = 1; $i <= $offer_number; $i++) {
			$offer_name_str = $offer_slug. '_offername_'. $i;
			$offer_name = $_POST[$offer_name_str];
			$offer_price_str = $offer_slug. '_offerprice_'. $i;
			$offer_price = $_POST[$offer_price_str];
			
			$wpdb->query("INSERT INTO offercalc_fields(name, price, offer_slug) VALUES('$offer_name', $offer_price, '$offer_slug');");
		}
	}
}
	
echo "<div>Form data saved successfully.</div>"; 

// delete record.
// TODO: check for permissions 
if(isset($_GET['offer_action']) && $_GET['offer_action'] == 'delete') {
	if(!isset($_GET['item_id'])) {
		wp_die('No offer ID aquired. ');
	}
	
	global $wpdb;
	
	$item_id = $_GET['item_id'];
	
	$offer_data = $wpdb->get_row('SELECT * FROM offercalc_offers WHERE id = '. $item_id);

	if($wpdb->num_rows == 0) {
		echo "Wrong ID supplied. "; 
		wp_die();
	}
	
	$offer_slug = $offer_data->slug;
	
	$wpdb->query("DELETE FROM offercalc_offers WHERE id=$item_id;");
	$wpdb->query("DELETE FROM offercalc_fields WHERE offer_slug='$offer_slug';");
	$wpdb->flush();
}
?>


<div id="forms">
	<p>List of forms: </p>
	<table style="border: 1px solid black">
		<tr>
			<th>Offer name</th>
			<th>Offer slug </th>
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
				<td><a href="admin.php?page=add-offer&action_type=edit&item_id=<?php echo $offer->id?>"><?php echo $offer->slug; ?></a></td>
				<td><a href="admin.php?page=offer-calc&offer_action=delete&item_id=<?php echo $offer->id?>" onclick="confirm('Are you sure you want to delete form <?php echo $offer->id; ?>?')">Delete</a></td>
			</tr>
		<?php endforeach;?>
	</table>
</div> 
	