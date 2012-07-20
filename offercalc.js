	jQuery(".offer_selector").change(function() {
			// extract the ID as number
			// as well as the widget ID
			last_subscore_idx = this.id.lastIndexOf('_');
			pre_last_subscore_idx = this.id.lastIndexOf('_', last_subscore_idx-1);
			
			var id = this.id.substring(last_subscore_idx + 1);
			var widget_id = this.id.substring(pre_last_subscore_idx + 1, last_subscore_idx);
			
			// sum the row price
			var offer_price = jQuery("#offer_price_" + widget_id + "_" + id).text();
			var offer_count = jQuery("#offer_count_" + widget_id + "_" + id).val();
			
			var row_sum = parseFloat(offer_price) * parseFloat(offer_count);
	
			jQuery("#offer_sum_" + widget_id + "_" + id).val(row_sum);
	
			// count total sum
			var total_sum = 0;
			jQuery("#widget_offercalc_table_" + widget_id + " .offer_sum").each(function() {
				total_sum += parseFloat(jQuery(this).val());
			}); 
	
			// and persist
			var sum_div_to_change = "#total_offercalc_sum_" + widget_id; 
			jQuery(sum_div_to_change).html('Total: ' + total_sum);
		});
