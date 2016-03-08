<?php
class Model_Main extends Model{
	function __construct(){
		$this->ConnectDB();
	}
	
	function getCategories(){
		$list = [];
		$result = $this->query("SELECT * FROM categories ORDER BY id DESC");
		while ($row = $result->fetch_assoc()) {
            array_push($list, $row);
        }
        $result->free();
        return $list;
	}
	function CheckUserInDB($d){
		$q = "SELECT id FROM users WHERE login='$d[login]' AND pwd='$d[pwd]'";
		$res = $this->query($q);
		$res->data_seek(0);
		$user_id = $res->fetch_row()[0];
		if(sizeof($user_id) > 0){
			$_SESSION["user_id"] = $user_id;
			return 0;
		}
	}
	function getGameModes(){
		$game_modes = array();
		$result = $this->query("SELECT * FROM game_modes");
		if($result)
			while($out = $result->fetch_assoc()) {
				array_push($game_modes, $out);
			}
		return $game_modes;
	}
}