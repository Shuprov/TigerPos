<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Report.php");

class Summary_product extends Report
{
	public function getDataColumns()
	{
		return array(array('item_name' => $this->lang->line('reports_item_name')),
					array('quantity' => $this->lang->line('reports_quantity')),
					array('location_name' => $this->lang->line('reports_stock_location')),
					array('cost_price' => $this->lang->line('reports_cost_price'), 'sorter' => 'number_sorter'),
					array('unit_price' => $this->lang->line('reports_unit_price'), 'sorter' => 'number_sorter'),
					array('subtotal' => $this->lang->line('reports_sub_total_value'), 'sorter' => 'number_sorter'));
	}

	public function getData(array $inputs)
	{
		$this->db->select('items.item_number, SUM(item_quantities.quantity) AS Total_quty,items.name,  items.reorder_level, stock_locations.location_name, items.cost_price, items.unit_price, SUM(items.cost_price * item_quantities.quantity) AS sub_total_value');
		$this->db->from('items AS items');
		$this->db->join('item_quantities AS item_quantities', 'items.item_id = item_quantities.item_id');
		$this->db->join('stock_locations AS stock_locations', 'item_quantities.location_id = stock_locations.location_id');
		$this->db->where('items.deleted', 0);
		$this->db->where('items.stock_type', 0);
		$this->db->where('stock_locations.deleted', 0);
        

        $this->db->group_by('items.name');
		
       
 	    return $this->db->get()->result_array();
	}

	/**
	 * calculates the total value of the given inventory summary by summing all sub_total_values (see Inventory_summary::getData())
	 *
	 * @param array $inputs expects the reports-data-array which Inventory_summary::getData() returns
	 * @return array
	 */
	public function getSummaryData(array $inputs)
	{
		$return = array('total_inventory_value' => 0, 'total_quantity' => 0, 'total_retail' => 0);

		foreach($inputs as $input)
		{
			$return['total_inventory_value'] += $input['sub_total_value'];
			$return['total_quantity'] += $input['quantity'];
			$return['total_retail'] += $input['unit_price'] * $input['quantity'];
		}

		return $return;
	}

	/**
	 * returns the array for the dropdown-element item-count in the form for the inventory summary-report
	 *
	 * @return array
	 */
	public function getItemCountDropdownArray()
	{
		return array('all' => $this->lang->line('reports_all'),
					'zero_and_less' => $this->lang->line('reports_zero_and_less'),
					'more_than_zero' => $this->lang->line('reports_more_than_zero'));
	}
}
?>
