<?php
class CategoryModel extends Db
{
    public function getCategoryList()
    {
        // Bước 2: Tạo câu query
        $sql = parent::$connection->prepare('SELECT * FROM categories');
        return parent::select($sql);
    }
}
