<?php
include_once("mysql_config.php");
class Model extends mysqli{
	public function get_data(){

	}
	public function ConnectDB(){
		parent::__construct(SQLADDR, SQLUSER, SQLPWD, SQLDB);
		$this->query("SET NAMES utf8");
	}
    public function escape($string) {
        return $this->escape_string($string);
        // return $string;
    }

    public function run($query) {
        $this->query($query);
        return true;
    }

    public function delete($query) {
        return $this->query($query);
        // if ($result === TRUE)
        //     return true;
        // return false;
    }

    public function insert($query) {
        $this->query($query);
        $result = $this->query("SELECT LAST_INSERT_ID() AS LID");
        if ($result->num_rows > 0) {
            $item = $result->fetch_array(MYSQLI_ASSOC);
            return $item['LID'] != 0 ? $item['LID'] : NULL;
        }
        return NULL;
    }

    public function update($query) {
        $$this->query($query);
        if ($this->affected_rows > 0)
            return true;
        return false;
    }

    public function getFirst($query) {
        if ($result = $this->query($query)) {
            if ($result->num_rows > 0) {
                return $result->fetch_array(MYSQLI_ASSOC);
            }
        }
        return NULL;
    }

    public function getAssoc($query) {
        $list = [];
        if ($result = $this->query($query)) {
            while ($row = $result->fetch_assoc()) {
                array_push($list, $row);
            }
            $result->free();
        }
        return $list;
    }
    public function exec($query){
        $result = $this->query($query);

        if (!$result) {
            echo mysqli_error($this);
            die("Stopped at Model->exec()");
        }

        return $result->fetch_object();
    }
    public function toArray($query){
        $result = $this->query($query);

        if(!$result){
            echo mysqli_error($this);
            die("Stopped at Model-> query()");
        }
        return $result->fetch_array();
    }

    function GetRating($user_id){
        return $this->getAssoc("SELECT SUM(ext_info) as sum FROM stats WHERE user_id=$user_id")[0]["sum"];
//        return $this->toArray("SELECT SUM(categories.rating) AS sum from categories INNER JOIN ways
//         ON categories.id = ways.cat_id INNER JOIN stats
//          ON stats.way_id = ways.id WHERE stats.user_id = '$userid'");
    }
    function GetRank($userid){
        $rating = $this->GetRating($userid);
        return (int)sqrt($rating/100);
    }
    function SetLike($code = 0, $way_id, $is_hitler){
        $check = $this->getAssoc("SELECT id FROM likes WHERE way_id=$way_id AND user_id=$_SESSION[user_id]
        AND is_hitler=$is_hitler")[0];
        echo $check;
        echo $way_id;
        if($check > 0){
            echo "OK";
            $this->query("UPDATE likes SET like_value='{$code}'  WHERE way_id=$way_id AND user_id=$_SESSION[user_id]
            AND is_hitler=$is_hitler");
            return mysqli_error($this);
        }
        else {
            echo "OK";
            $this->query("INSERT INTO likes VALUES('', $way_id, $is_hitler, $_SESSION[user_id], $code, NOW())");
        }
    }

    function GetLike($way_id, $is_hitler){
        $result = $this->getAssoc("SELECT like_value from likes where way_id=$way_id AND user_id=$_SESSION[user_id]
        AND is_hitler=$is_hitler")[0]["like_value"];
        return ($result == "") ? 0 : $result;
    }
//    function UpdateRating($user_id, $num){
//        $this->query("UPDATE users SET rating = rating+'{$num}' WHERE id = $user_id");
//    }
}