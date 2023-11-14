<?php
require_once(__DIR__.'/../model/CategoryModel.php');

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

    public function getCategoryActive() {
        $categories = $this -> categoryModel -> getCategoryActive();
        return $categories;
    }
}

?>