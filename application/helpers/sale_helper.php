<?php

/* adapted from table_helper/get_items_manage_table */
function get_sales_items_manage_table($items,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';

	$headers = array(
    '&nbsp;',
	$CI->lang->line('items_item_number'),
	$CI->lang->line('items_name'),
	$CI->lang->line('items_category'),
	$CI->lang->line('items_cost_price'),
	$CI->lang->line('items_unit_price'),
	$CI->lang->line('items_quantity')
	);

	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$rowsHtml = get_sales_items_manage_table_data_rows($items,$controller);
    if (empty($rowsHtml)) {
        return null;
    }
	$table.=$rowsHtml;
	$table.='</tbody></table>';

	$controller_name=strtolower(get_class($CI));
	$actionPath = $controller_name.'/add';
	$form =
		"<form action='$actionPath' method='post' >" .
            $table .
		'</form>';
	return $form;
}

/*
Gets the html data rows for the items.
*/
function get_sales_items_manage_table_data_rows($items,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';

	foreach($items->result() as $item)
	{
		$table_data_rows.=get_sales_item_data_row($item,$controller);
	}

	return $table_data_rows;
}

function get_sales_item_data_row($item,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));

	$table_data_row='<tr>';
    // add submit button to add the item of this row
    $table_data_row.="<td width='8%'><button type='submit' name='item' value='".$item->item_id."' class='submit_button' style='margin:1px; vertical-align:middle;'/>" . $CI->lang->line('sales_add_item') . "</td>";
	$table_data_row.='<td width="15%">'.$item->item_number.'</td>';
	$table_data_row.='<td width="28%">'.$item->name.'</td>';
	$table_data_row.='<td width="14%">'.$item->category.'</td>';
	$table_data_row.='<td width="14%">'.to_currency($item->cost_price).'</td>';
	$table_data_row.='<td width="14%">'.to_currency($item->unit_price).'</td>';
    $table_data_row.='<td width="7%">'.$item->quantity.'</td>';

	$table_data_row.='</tr>';
	return $table_data_row;
}

?>
