<?php
// reference the Dompdf namespace
require '../vendor/autoload.php';
use Dompdf\Dompdf;

class pdf extends Dompdf{
    public function __construct(){
        parent::__construct();
    }
}