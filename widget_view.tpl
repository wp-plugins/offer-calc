
<table class="widget_offer_table">
<?php foreach($fields as $row): ?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td><span id="offer_price_<?php echo $row->id; ?>"><?php echo $row->price; ?></span></td>
		<td>
			<select id="offer_count_<?php echo $row->id; ?>" class="offer_selector">
				<?php for($i = 0; $i < 40; $i++):?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor;?>
			</select>
		</td>
		<td><input id="offer_sum_<?php echo $row->id; ?>" type="text" class="offer_sum" disabled="disabled" value="0"></input></td>
	</tr>
<?php endforeach;?>
</table>

<div id="total_offercalc_sum">Total: 0</div>

<script type="text/javascript">
	jQuery(".offer_selector").change(function() {
		// extract the ID as number
		var id = this.id.substring(this.id.lastIndexOf('_') + 1);
		// sum the row price
		
		var offer_price = jQuery("#offer_price_" + id).text();
		var offer_count = jQuery("#offer_count_" + id).val();
		
		var row_sum = parseFloat(offer_price) * parseFloat(offer_count);

		jQuery("#offer_sum_" + id).val(row_sum);

		// count total sum
		var total_sum = 0;
		jQuery(".offer_sum").each(function() {
			total_sum += parseFloat(jQuery(this).val());
		}); 

		// and persist
		jQuery("#total_offercalc_sum").html('Total: ' + total_sum);
	});
</script>