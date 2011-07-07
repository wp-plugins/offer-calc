
<div>
	<h1>Offer Calc</h1>

<form action="admin.php?page=offer-calc" method="post">
	<p>Form ID: <input id="form_id" type="text" name="form_id" value="myform" /></p>
	<p>Form name: <input id="form_name" type="text" name="form_name" value="" /></p>

	<p>Select the number of services you will provide: </p>
	<p>
		<select id="offer_number" name="offer_number">
			<?php for($i = 0; $i < 40; $i++):?>
				<option value="<?php echo $i?>"><?php echo $i; ?></option>
			<?php endfor;?>
		</select>
	</p>
	
	<table id="offer_table">
	</table>


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