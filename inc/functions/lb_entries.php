<?php 
//entries	
function show_entries($table='',$limit='')

		{
			global $db_my;
			global $c;
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$table=$table; 
			$table = "entries_".$table;
			$table = $db_my->escape_string($table);
			$limit = $db_my->escape_string($limit);
			$query="SELECT id,content,autor from ". $db_my->prefix ."$table WHERE removed = '0' ORDER by ID DESC LIMIT $limit";

			//
			$result=$db_my->query($query, $hide_errors=1, $write_query=0);

			//
			if (find_mobile_browser(false)==true){
				$inline=false;
			}
			else{
				$inline=null;
			}
				
			while ($row = $db_my->fetch_assoc($result))
			{
			$rows[] = $row ;
			}
		
			foreach($rows as $row){
			echo "<div class='content'>";
			echo $row['content']."<p style='text-align:right;'> von: ".$row['autor'];
			global $user;
			if ($user->verify(1)===true)
			{
			echo "<br>
			<div><div style='float:left;'>
			<form action='".$c->a('entry_edit').$c->get('id',$row['id']).$c->get('inline',$inline)."' method='post'>
			<input type='hidden' name='table' value='".$table."'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<input type='image' src='".FW_CLIENT_ROOT."images/icons/entry_edit.png' style='wdith:32px;height:32px;' alt='edit_entry'>
			</form>
			
			
			</div><div style='float:right;'>

			<form action='".$c->a('entry_remove').$c->get('table',$table).$c->get('id',$row['id'])."' method='post'>
			<input type='hidden' name='table' value='".$table."'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<input type='image' src='".FW_CLIENT_ROOT."images/icons/entry_remove.png' style='wdith:32px;height:32px;' alt='remove_entry'>
			</form></div>&nbsp;</div>
			";
			}
			echo "</p></div>";
				
			}
		}
//Entries end
?>