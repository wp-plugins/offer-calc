<div class="offercalc_wrapper" id="offercalc_wrapper_<?php echo $widget_id; ?>">
	<table class="widget_offercalc_table" id="widget_offercalc_table_<?php echo $widget_id; ?>">
	<?php foreach($fields as $row): ?>
		<tr>
			<td><?php echo $row->name; ?></td>
			<td><span id="offer_price_<?php echo $widget_id; ?>_<?php echo $row->id; ?>"><?php echo $row->price; ?></span></td>
			<td>
				<select id="offer_count_<?php echo $widget_id; ?>_<?php echo $row->id; ?>" class="offer_selector">
					<?php for($i = 0; $i < 40; $i++):?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor;?>
				</select>
			</td>
			<td><input id="offer_sum_<?php echo $widget_id; ?>_<?php echo $row->id; ?>" type="text" class="offer_sum" disabled="disabled" value="0"></input></td>
		</tr>
	<?php endforeach;?>
	</table>
	
	<div class="total_offercalc_sum" id="total_offercalc_sum_<?php echo $widget_id;?>">Total: 0</div>
</div>