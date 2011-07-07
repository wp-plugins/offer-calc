<?php

if(isset($_POST['form_id'])) {
	$form_id = $_POST['form_id'];
	$form_name = $_POST['form_name'];
	$offer_number = $_POST['offer_number'];
	
	if(empty($form_id)) {
		wp_die('ID cannot be empty');
	}
	
	global $wpdb;

	$wpdb->query("INSERT INTO offercalc_offers(name, slug, number_fields) VALUES('$form_name', '$form_id', $offer_number);");
	
	for($i = 1; $i <= $offer_number; $i++) {
		$offer_name_str = $form_id. '_offername_'. $i;
		$offer_name = $_POST[$offer_name_str];
		$offer_price_str = $form_id. '_offerprice_'. $i;
		$offer_price = $_POST[$offer_price_str];
		
		$wpdb->query("INSERT INTO offercalc_fields(name, price, offer_slug) VALUES('$offer_name', $offer_price, '$form_id');");
	}
	
	echo "<div>Form data saved successfully.</div>"; 
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
		<td><?php echo $offer->slug; ?></td>
		<td><!--  <a href="admin.php?page=delete_offer&id=<?php // echo $offer->id; ?>"><?php // echo $offer->slug; ?></a> --></td>
	</tr>
	<?php endforeach;?>
	</table>
</div>