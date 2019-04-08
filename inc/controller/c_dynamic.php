<?php
class controller implements c_base
	{
	public $c_url=FW_CLIENT_ROOT."c/";
	/*
	null deactivates controller php
	controller.php activates it
	*/
	function c_url(){
		if (FW_C===true){
		return $this->c_url;
		}
		else{
			return false;
		}
	}
	static function cur(){
		$cur=array();
		if (isset($_GET['a'])){
			$cur['a']=$_GET['a'];
		}
		else{
			$filename=$_SERVER['SCRIPT_NAME'];  
			$path = pathinfo($filename);
			$cur['a']=$path["filename"];
		}
		if (isset($_GET['p'])){
			$cur['p']=$_GET['p'];
		}
		else{
			$cur['p']=null;
		}
		return $cur;
	}
	function ref($a,$p){
		if($this->c_url()){
			$link=$this->c_url()."?a=$a&p=$p";
			return $link;
		}
		else{
			return $a.".php?a=".$a."&p=".$p;
		}
		
	}
	function a($a){
		if($this->c_url()){
			return $this->c_url()."?a=".$a;
		}
		else{
			return $a.".php?a=".$a;
		}
	}
	function p($p){
		$a=$this->cur()['a'];
		if($this->c_url()){
			return $this->c_url()."?a=".$a."&p=".$p;
		}
		else{
			return $a.".php?a=".$a."&p=".$p;
		}	
	}
	function get($name,$value,$root=false){
		if($root){
			if($this->cur()['p']===null){
				return $this->a($this->cur()['a'])."&".$name."=".$value;
			}
			else{
				return $this->a($this->cur()['a']).$this->p($this->cur()['p'])."&".$name."=".$value;
			}
		}
		else{
			return "&".$name."=".$value;
		}
	}
	function href_a($a){
		return "href=\"".$this->a($a)."\"";
	}
	function href_p($p){
		$a=$this->cur()['a'];
		return "href=\"".$this->p($p)."\"";
	}
}
?>