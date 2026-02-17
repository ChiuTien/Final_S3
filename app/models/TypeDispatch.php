<?php
namespace app\models;

class TypeDispatch {
    private $idTypeDispatch;
    private $valTypeDispatch;

    public function __construct() {}

    public function setIdTypeDispatch($id) { $this->idTypeDispatch = $id; }
    public function getIdTypeDispatch() { return $this->idTypeDispatch; }

    public function setValTypeDispatch($val) { $this->valTypeDispatch = $val; }
    public function getValTypeDispatch() { return $this->valTypeDispatch; }
}
?>
