<?php
require_once __DIR__ . '/../models/ChartModel.php';

class ChartController
{
    private $chartModel;

    public function __construct()
    {
        $this->chartModel = new ChartModel();
    }

    public function getCharts()
    {
        return $this->chartModel->getCharts();
    }
}
