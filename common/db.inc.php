<?php
/*include(ROOT_DIR . "common/lib/adodb.inc.php");


function connectDB()
{
    global $conn;
    $conn = &ADONewConnection(DB_TYPE);
    //$this->db->SetFetchMode(ADODB_FETCH_NUM);
    $conn->Connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    boxLogin::boxController();
    return $conn;
}*/


class dbConn
{

    protected static $db;

    public function __construct()
    {

        try {
            self::$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . "", DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        $conn = self::getConnection();
        $conn->exec('SET character_set_database=UTF8');
        $conn->exec('SET character_set_client=UTF8');
        $conn->exec('SET character_set_connection=UTF8');
        $conn->exec('SET character_set_results=UTF8');
        $conn->exec('SET character_set_server=UTF8');
        $conn->exec('SET names UTF8');

    }

    public static function getConnection()
    {

        if (!self::$db) {
            new dbConn();
        }

        return self::$db;
    }
    public static function getConnection2()
    {

        return dbConn2::getConnection();
    }

}
class dbConn2
{

    protected static $db;

    public function __construct()
    {

        try {
            self::$db = new PDO("mysql:host=" . DB_HOST2 . ";dbname=" . DB_DATABASE2 . "", DB_USER2, DB_PASSWORD2);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        $conn = self::getConnection();
        $conn->exec('SET character_set_database=UTF8');
        $conn->exec('SET character_set_client=UTF8');
        $conn->exec('SET character_set_connection=UTF8');
        $conn->exec('SET character_set_results=UTF8');
        $conn->exec('SET character_set_server=UTF8');
        $conn->exec('SET names UTF8');

    }

    public static function getConnection()
    {

        if (!self::$db) {
            new dbConn2();
        }
        return self::$db;
    }

}


class boxLogin
{

    public static function boxController()
    {

        global $conn, $conn2;
        $server = constant("SERVER");
        if (!strlen($server) or $server == 'cloud') {
            $conn2 = $conn;
            return;
        } else {
            $conn2 = connectDB2::getConnection();
        }

        if ($_GET['action'] == 'loginByBox') {
            $_SESSION["sessionAdminID"] = $_GET['id'];
            header("Location: " . RELA_DIR . "admin/");
            die();

        } else if ($_SERVER['SCRIPT_NAME'] == '/admin/login.php') {
            header("Location: " . RELA_DIR_BOX);
            die();

        } else if ($_SERVER['SCRIPT_NAME'] == '/admin/logout.php') {
            header("Location: " . RELA_DIR_BOX . 'login/logout');
            die();
        }

    }

}


class connectDB2
{
    protected static $db;

    public function __construct()
    {
        try {
            self::$db = &ADONewConnection(DB_TYPE);
            //$this->db->SetFetchMode(ADODB_FETCH_NUM);
            return self::$db->Connect(DB_HOST2, DB_USER2, DB_PASSWORD2, DB_DATABASE2);

        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

    }

    public static function getConnection()
    {
        if (!self::$db) {
            new connectDB2();
        }
        return self::$db;
    }


}