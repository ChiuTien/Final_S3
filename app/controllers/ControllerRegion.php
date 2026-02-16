<?php
namespace app\controllers;

use app\models\Region;
use app\repository\RepRegion;

class ControllerRegion {
    private RepRegion $regionRepo;

    public function __construct(RepRegion $regionRepo) {
        $this->regionRepo = $regionRepo;
    }

    public function addRegion(Region $region): void {
        $this->regionRepo->addRegion($region);
    }

    public function removeRegion(Region $region): void {
        $this->regionRepo->removeRegion($region);
    }

    public function getRegionById($id) {
        return $this->regionRepo->getRegionById($id);
    }

    public function getAllRegions() {
        return $this->regionRepo->getAllRegions();
    }

    public function updateRegion(Region $region) {
        return $this->regionRepo->updateRegion($region);
    }
}
?>
