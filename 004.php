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
			// array_push($this->data_item, $value);
			// print_r($this->data_item);
		}
	}

	protected function get_data()
	{
		return $this->data_item;
	}

	protected function del_item($index)
	{
		$this->data_item->offsetUnset($index);
		// array_values($this->data_item);
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

	public function check_out()
	{
		$data = json_encode($this->data_item, JSON_PRETTY_PRINT);
		file_put_contents("data_checkout_transaksi_".date("d_F_Y").".json", $data);
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
	public $print;
	function __construct()
	{
		parent::__construct();
		$this->item = $this->data_item;
		$this->total_item = 0;
		$this->total_quantity = 0;
		$this->total_price = 0;
		$this->disc = 0;
		$this->print = "";
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
		// print_r($this->item);
		$this->print .=  "Tanggal Transaksi : ".date("d F Y H:i:s");
		$this->print .=  "\n";
		$this->print .= "========================= ITEMS PEMBELIAN =========================";
		$this->print .= "\n";
		$this->print .=  "Item Id 		Qty 		Price 			Sub Total";
		$this->print .=  "\n";
		$cur_index = 0;
		$urut = 1;
		for ($i=0; $i < count($this->item) ; $i++) 
		{ 
			$cur_index += $i;
			if ($this->data_item->offsetExists($cur_index)) 
			{
				$cur_index = $i;
				// $this->total_quantity += $this->item[$cur_index]->quantity;
				$this->print .=  $this->item[$cur_index]->item_id."			".$this->item[$cur_index]->quantity."		".$this->item[$cur_index]->price."			".$this->item[$cur_index]->quantity * $this->item[$cur_index]->price;
				$this->print .=  "\n";
			}
			else
			{
				$cur_index = $i+1;
				if ($cur_index == $i+1) 
				{
					if ($this->data_item->offsetExists($cur_index)) {
						// $this->total_quantity += $this->item[$cur_index]->quantity;
						$this->print .=  $this->item[$cur_index]->item_id."			".$this->item[$cur_index]->quantity."		".$this->item[$cur_index]->price."			".$this->item[$cur_index]->quantity * $this->item[$cur_index]->price;
						$this->print .=  "\n";
					}
					
				}
				else
					{
						if ($this->data_item->offsetExists($i+1)) {
							// $this->total_quantity += $this->item[$i+1]->quantity;
							$this->print .=  $this->item[$i+1]->item_id."			".$this->item[$i+1]->quantity."		".$this->item[$i+1]->price."			".$this->item[$i+1]->quantity * $this->item[$i+1]->price;
							$this->print .=  "\n";
						}
					}
			}
		}
		$this->print .=  "\n";
		$this->print .=  "							Total 	: Rp.".$this->total_price;
		$this->print .=  "\n";
		$this->print .=  "							Disc 	: ".$this->disc."%";
		$this->print .=  "\n";
		$this->print .=  "								: -Rp.".($this->total_price * $this->disc)/100;
		$this->print .=  "\n";
		$this->print .=  "						Grand Total 	: Rp.".($this->total_price * $this->disc)/100;

		echo $this->print;

	}

	function addDiscount($val)
	{
		$this->disc = $val;
	}

	function totalItems()
	{
		$this->total_item = count($this->item);
		echo "Total Items Pembelanjaan ".$this->total_item;
		echo "\n";
	}

	function totalQuantity()
	{
		$cur_index = 0;
		for ($i=0; $i < count($this->item) ; $i++) 
		{ 
			$cur_index += $i;
			if ($this->data_item->offsetExists($cur_index)) 
			{
				$cur_index = $i;
				$this->total_quantity += $this->item[$cur_index]->quantity;
			}
			else
			{
				$cur_index = $i+1;
				if ($cur_index == $i+1) 
				{
					if ($this->data_item->offsetExists($cur_index)) {
						$this->total_quantity += $this->item[$cur_index]->quantity;
					}
					
				}
				else
					{
						if ($this->data_item->offsetExists($i+1)) {
							$this->total_quantity += $this->item[$i+1]->quantity;
						}
					}
			}
		}
		echo "Total Quantity ".$this->total_quantity;
		echo "\n";
	}

	function totalPrice()
	{
		$cur_index = 0;
		for ($i=0; $i < count($this->data_item) ; $i++) 
		{ 
			$cur_index += $i;
			if ($this->data_item->offsetExists($cur_index)) 
			{
				$cur_index = $i;
				$this->total_price += $this->item[$cur_index]->quantity * $this->item[$cur_index]->price ;
			}
			else
			{
				$cur_index = $i+1;
				if ($cur_index == $i+1) 
				{
					if ($this->data_item->offsetExists($cur_index)) {
						$this->total_price += $this->item[$cur_index]->quantity * $this->item[$cur_index]->price;
					}
				
				}
				else
				{
					if ($this->data_item->offsetExists($i+1)) {
						$this->total_price += $this->item[$i+1]->quantity * $this->item[$i+1]->price;
					}
				}
			}
		}

		echo "Total Pembelanjaan Rp.".($this->total_price * $this->disc)/100;
		echo "\n";
	}

	function checkOut()
	{
		parent::check_out();
		file_put_contents("data_checkout_transaksi_".date("d_F_Y").".txt", $this->print);
	}


}

$cart = new Cart();
$cart->addItem('{"item_id":1,"price":30000,"quantity":3}');
$cart->addItem('{"item_id":2,"price":1000}');
$cart->addItem('{"item_id":3,"price":5000, "quantity":2}');	
$cart->removeItem('{"item_id": 2}');
$cart->addItem('{ "item_id": 4, "price": 400, "quantity": 6 }');
$cart->addDiscount(50);
$cart->totalItems();
$cart->totalQuantity();
$cart->totalPrice();
$cart->showAll();
$cart->checkOut();
 ?>