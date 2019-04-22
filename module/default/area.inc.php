<?php
//Titel
$area = new area;
$table=$_GET['p'];
$area->init($table);
function file_title($case="title"){
		switch ($case){
			case "title": return area_title('Bereich', true);
			break;
			
			case "head": return area_title('Bereich', false);
			break;
			
			default:return area_title($default='Bereich');
		}
	}
		
//Content
//Spezialteil
	function content_top()
	{
		echo"
		";
	}
//Hauptteil	

	function content_main()
	{
		global $area;
		global $user;
		global $c;
		
		echo "<div class='mobile'>";
		if (find_mobile_browser(false)==true){
			show_area_menu_mobile($table);
		}
		echo "</div>";

	
		echo "<div class='content'>";
		$area->show();
		if ($user->verify(1)===true){
			if (find_mobile_browser(false)==true){
				$edit_target=$c->a('area_edit').$c->get('inline',0);
			}
			else{
				$edit_target=$c->a('area_edit');
			}
			if ($area->cur['modifiable']==1){
				echo "<div><div style='float:left;'>
			<form action='$edit_target".$c->get('table',$area->cur['table']).$c->get('id',$area->cur['id']).$c->get('r',$area->cur['name'])."' method='post'>
			<input type='hidden' name='table' value='".$area->cur['table']."'>
			<input type='hidden' name='id' value='".$area->cur['id']."'>
			<input type='hidden' name='name' value='".$area->cur['name']."'>
			<input type='image' src='".FW_CLIENT_ROOT."images/icons/area_edit.png' style='width:32px;height:32px;' alt='edit_area'>
			</form>
			</div>
			<div style='float:right;'>
			<form action='".$c->a('area_manager').$c->get('t', $area->cur['table'])."' method='post'>
			<input type='hidden' name='table' value='".$area->cur['table']."'>
			<input type='image' src='".FW_CLIENT_ROOT."images/icons/area_manager.png' style='width:32px;height:32px;' alt='manager_area'>
			</form>
			</div>
			</div>";
			}
		}
		echo"</div>";	
	}

	

//Content_left

	function content_left()
	{ 
	global $area;
	global $user;
	global $c;
	echo "
		<div  class=\"content_left\"'>
		";
		if (isset($_GET['p'])){
			$table=$_GET['p'];
			$area_menu = $area->menu();
			$first = true;
			if ($area_menu){
				foreach($area_menu as $entry){
					if (isset ($_GET['r']) and $_GET['r']===$entry[1]){
						echo "<a href='{$entry[0]}' class='button_theme' style='width:100%;margin:0 0 1px 0;'>".$entry[1]."</a><br>";
					}
					elseif (!isset ($_GET['r']) and $first){
						echo "<a href='".$entry[0]."' class='button_theme' style='width:100%;margin:0 0 1px 0;'>".$entry[1]."</a><br>";
						$first = false;
					}
					else{
						echo "<a href='".$entry[0]."' class='button' style='width:100%'>".$entry[1]."</a><br>";
					}
					
				}
			}
			else{
					echo "Keine Einträge";
			}
			if($user->verify(1)){
				echo "<a href={$c->a("area_manager")}{$c->get("t",$table)} class='button' style='width:100%'>Bereich verwalten</a>";
			}
		}
		else{
			echo "Bereich nicht gefunden";
			exit;
		}		
		echo "</div>";
	}
//Content_right
	function content_right()
	{
		echo "
		
		";
	}
//
function onDate_Event()
		{	
	
		}	
	
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>