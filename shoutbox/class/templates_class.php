<?php
class template 
{
	private $data = array();
	private $template;
	public $dir;

	public function __construct($dir)
	{
		if (is_dir($dir))
		{
			$this->dir = $dir;
			
		}
		else 
		{
			$this->dir = 'templates/standard/';
		}
			$this->addVar('DIR', $this->dir);
	}
	
	public function addVar($name, $value)
	{
		if (is_array($value))
		{
			$this->data[$name][] = $value;
		}
		else if (!empty($value)) 
		{
			$this->data[$name] = $value;
		}
	}
	
	private function getVars($match)
	{
		return $this->data[$match[1]];
	}
	
	private function includeVars()
	{
		$this->template = preg_replace_callback('/{([^}]+)}/', array($this, 'getVars'), $this->template);
	}
	
	public function Display($template)
	{
		$this->template = implode('', file($this->dir . $template));
		$this->includeVars();
		echo $this->template;
	}
}
?>