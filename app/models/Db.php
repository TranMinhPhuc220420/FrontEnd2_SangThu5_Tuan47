<?php
class Db
{
    public static $connection = NULL;
    public function __construct()
    {
        // Bước 1: Tạo connection
        if(!self::$connection)
        {
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            self::$connection->set_charset('utf8mb4');
        }
        return self::$connection;
    }

    public function select($sql)
    {
        // Bước 3: Thực thi câu query và xử lý kết quả trả về
        $items = array();
        $sql->execute();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
    }
}
