<?php
require __DIR__.'/../model/CategoryModel.php';

class CategoryController {

    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        require '../app/views/admin/categories.php';
    }

    public function getCategory() {
        $categories = $this -> categoryModel -> getCategory();
        return $categories;
    }

}

?>