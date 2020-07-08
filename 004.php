<?php 
/**
 * 
 */
class Shop
{
	protected $data_item;
	function __construct()
	{
		$this->data_item = new ArrayObject();
	}

	protected function update_item($value)
	{
		if ($value != '') 
		{
			$this->data_item->append($value);
		}
	}

	protected function get_data()
	{
		return $this->data_item;
	}

	protected function del_item($index)
	{
		$this->data_item->offsetUnset($index);
		// array_splice($this->data_item, $index, 1);
		// $this->data_item = array_combine(range(1, count($this->data_item)), array_values($this->data_item));
		// array_splice($this->data_item, $index, -$index);
		// $arrayobj->offsetSet(null, 'last');
	}

	protected function update_index()
	{
		for ($i=0; $i < count($this->data_item) ; $i++) 
		{ 
			if (!$this->data_item->offsetExists($i)) 
			{
				$this->data_item->offsetSet($i, $this->data_item[$i]);
			}
		}
	}
}

/**
 * 
 */
class Cart extends Shop
{
	protected $item;
	public $total_item;
	public $total_quantity;
	public $total_price;
	public $disc;
	function __construct()
	{
		parent::__construct();
		$this->item = parent::get_data();
		$this->total_item = 0;
		$this->total_quantity = 0;
		$this->total_price = 0;
		$this->disc = 0;
	}

	function addItem($data)
	{
		$data = json_decode($data);
		if (isset($data->quantity)) 
		{
			parent::update_item($data);
		}
		else
		{
			$data->quantity = 1;
			parent::update_item($data);
		}
	}



	function removeItem($data)
	{
		$data = json_decode($data);
		$index = 0;
		for ($i=0; $i < count($this->item) ; $i++) 
		{ 
			if ($this->item[$i]->item_id == $data->item_id) 
			{
				$index = $i;
			}
		}
		parent::del_item($index);
		// parent::update_index();
	}

	function showAll()
	{
		print_r($this->item);
	}

	function addDiscount($val)
	{
		$this->disc = $val;
	}

	function totalItems()
	{
		$this->total_item = count($this->item);
	}

	function totalQuantity()
	{
		for ($i=0; $i < count($this->item) ; $i++) 
		{ 
			if ($this->data_item->offsetExists($i)) 
			{
				$this->total_quantity += $this->item[$i]->quantity;
			}
			else
			{
				if ($this->data_item->offsetExists($i+1)) {
					$this->total_quantity += $this->item[$i+1]->quantity;
				}
			}
		}
		echo $this->total_quantity;
	}


}

$cart = new Cart();
$cart->addItem('{"item_id":1,"price":30000,"quantity":3}');
$cart->addItem('{"item_id":2,"price":1000}');
$cart->addItem('{"item_id":3,"price":5000, "quantity":2}');	
$cart->removeItem('{"item_id": 2}');
$cart->addItem('{ "item_id": 4, "price": 400, "quantity": 6 }');

// $cart->totalItems();
$cart->totalQuantity();
$cart->showAll();
 ?>