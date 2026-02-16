<?php 
namespace app\controllers;

use app\models\Type;
use app\repository\RepType;

class ControllerType {
    private RepType $typeRepo;

    public function __construct() {
        $this->typeRepo = new RepType();
    }

    public function addType(Type $type) {
        return $this->typeRepo->addType($type);
    }

    public function removeType($idType) {
        $type = new Type();
        $type->setIdType($idType);
        return $this->typeRepo->removeType($type);
    }

    public function getTypeById($id) {
        return $this->typeRepo->getTypeById($id);
    }

    public function getAllTypes() {
        return $this->typeRepo->getAllTypes();
    }

    public function updateType(Type $type) {
        return $this->typeRepo->updateType($type);
    }
}
?>