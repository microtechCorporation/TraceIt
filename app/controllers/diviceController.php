<?php
session_start();

require_once __DIR__ . '/../models/diviceModel.php';

class DeviceController
{
    private $diviceModel;

    public function __construct()
    {
        $this->diviceModel = new DeviceModel();
    }

    public function loadUserDivicesController($userId)
    {
        return $this->diviceModel->loadUserDevices($userId);
    }
}
