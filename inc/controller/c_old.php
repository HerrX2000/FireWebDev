<?php
class controller implements c_base
	{
	public $c_url=null;
	function c_url(){
		return $this->c_url;
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
		return $cur;
	}
	function ref($a,$p){
		$link=FW_CLIENT_ROOT.$this->c_url()."?p=$a&p=$p";
		return $link;
	}
	function a($a){
		return $a.".php?a=".$a;
	}
	function p($p){
		$a=$this->cur()['a'];
		return $a.".php?a=".$a."&p=".$p;
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