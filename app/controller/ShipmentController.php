<?php
require_once(__DIR__.'/../model/ShipmentModel.php');


class ShipmentController {

    private $shipmentModel;

    public function __construct() {
        $this->shipmentModel = new ShipmentInformationModel();
    }

    public function getShipmentInformationById($idLastBuyUser) {
        return $this->shipmentModel->getShipmentInformationById($idLastBuyUser);
    }
}
?>