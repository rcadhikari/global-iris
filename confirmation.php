<?php
/**
 * Created by PhpStorm.
 * User: RC.Adhikari
 * Date: 06/03/2015
 * Time: 16:38
 */

require_once 'classes/Payment.php';

$payment = new Payment();

// Call the verification function after payment
if ($payment->verifyHSBCPayment()) {
    echo 'Payment Successful';
} else {
    echo 'Payment Failure';
};
