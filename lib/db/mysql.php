<?php 
class database {
    var $querynum   = 0;
    var $querylist  = array();
    var $querytimes = array();
    var $link       = '';
    var $db         = '';
    var $duration   = 0;
    var $timer      = 0;
    function connect($dbhost='localhost', $dbuser, $dbpw, $dbname, $pconnect=0, $force_db=false) {
        $die = false;
        if($pconnect) {
            $this->link = @mysql_pconnect($dbhost, $dbuser, $dbpw) or ($die = true);
        } else {
            $this->link = @mysql_connect($dbhost, $dbuser, $dbpw) or ($die = true);
        }
        if($die){
            $num = mysql_errno();
            $msg = mysql_error();    
            echo '<h3>Erreur de connexion à la base de données!!!</h3>';
            echo 'Une connexion à la base de données n\'a pas pu être établie<br />';
            echo 'Erreur retournée de la connexion :<br />';
            echo '<i><b>Erreur '.$num.': </b>'.$msg.'</i>';
            exit();
        }
        unset($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpw']);
        if(!$this->select_db($dbname, $force_db)){
            return false;
        }else{
            return true;
        }
    }
    function select_db($database, $force){
        if($force){
            if(!mysql_select_db($database, $this->link)){
                echo 'Impossible de trouver la base de données "'.$database.'".';
                return false;
                exit();
            }
        }else{
            if(!mysql_select_db($database, $this->link)){
                global $tablepre;
                echo mysql_error();
                echo '<br />';
                if($this->find_database($tablepre)){
                    echo "Using $this->db. Please reconfigure config.php ASAP, having to search for a database costs a lot of time and heavily slows down your board!";
                    return true;
                }else{
                    echo 'Could not find any database containing the needed tables. Please reconfigure the config.php';
                    return false;
                    exit();
                }
            }else{
                $this->db = $database;
                return true;
            }
        }
    }
    function find_database($tablepre){
        $dbs = mysql_list_dbs($this->link);
        while($db = mysql_fetch_array($dbs)){
            $q = $this->query("SHOW TABLES FROM `$db[Database]`");
            if(!($this->num_rows($q) > 0)){
                continue;
            }
            
            if(strpos(mysql_result($q, 0), $tablepre.'settings') !== false){
                $this->select_db($db['Database']);
                $this->db = $db['Database'];
                break;
                return true;
            }else{
                continue;
            }
        }
    }
    
    function error() {
        return mysql_error();
    }
    function free_result($query) {
        return mysql_free_result($query);
    }
    function fetch_array($query, $type=SQL_ASSOC) {
        $array = mysql_fetch_array($query);
        return $array;
    }
    function field_name($query, $field) {
        return mysql_field_name($query, $field);
    }
    function query($sql) {
        $this->start_timer();
        
        $query = mysql_query($sql, $this->link) or die(mysql_error());
        
        $this->querynum++;
        $this->querylist[] = $sql;
        $this->querytimes[] = $this->stop_timer();
        
        return $query;
    }
    function unbuffered_query($sql) {
        $this->start_timer();
        
        $query = mysql_unbuffered_query($sql, $this->link) or die(mysql_error());
        
        $this->querynum++;
        $this->querylist[] = $sql;
        $this->querytimes[] = $this->stop_timer();
        
        return $query;
    }
    function fetch_tables($dbname){
        $q = $this->query("SHOW TABLES FROM $dbname");
        while($table = $this->fetch_array($q, SQL_NUM)){
            $array[] = $table[0];
        }
        return $array;
    }
    function result($query, $row, $field=NULL) {
        $query = mysql_result($query, $row, $field);
        return $query;
    }
    function num_rows($query) {
        $query = mysql_num_rows($query);
        return $query;
    }
    function num_fields($query) {
        return mysql_num_fields($query);
    }
    function insert_id() {
        $id = mysql_insert_id($this->link);
        return $id;
    }
    function fetch_row($query) {
        $query = mysql_fetch_row($query);
        return $query;
    }
    function time($time=NULL){
        if($time === NULL){
            $time = time();
        }
        return "LPAD('".$time."', '15', '0')";
    }
    function start_timer() {
        $mtime = explode(" ", microtime());
        $this->timer = $mtime[1] + $mtime[0];
        
        return true;
    }
    function stop_timer() {
        $mtime = explode(" ", microtime());
        $endtime = $mtime[1] + $mtime[0];
        
        $taken = ($endtime - $this->timer);
        $this->duration += $taken;
        $this->timer = 0;
        return $taken;
    }
}
define('SQL_NUM', MYSQL_NUM);
define('SQL_BOTH', MYSQL_BOTH);
define('SQL_ASSOC', MYSQL_ASSOC);
?>