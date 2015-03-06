<?php
/**
 * Created by PhpStorm.
 * User: Ram.Adhikari
 * Date: 06/03/2015
 * Time: 16:38
 */

require_once 'classes/Payment.php';

$payment = new Payment();

// Build the necessary array variable including product price, order id and product name.
$data = array();
$payment->payViaHSBCPayment($data);