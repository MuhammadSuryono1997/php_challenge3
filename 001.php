<?php 
/**
 * 
 */
class Hash
{
	private $password;
	function __construct($string)
	{
		$this->password = $string;
	}

	function md5()
	{
		echo hash('md5', $this->password);
	}

	function sha1()
	{
		echo hash('sha1', $this->password);
	}

	function sha256()
	{
		echo hash('sha256', $this->password);
	}

	function sha512()
	{
		echo hash('sha512', $this->password);
	}
}

$result = new Hash('secret');
$result->md5();
echo "\n";
$result->sha1();
echo "\n";
$result->sha256();
echo "\n";
$result->sha512();
 ?>