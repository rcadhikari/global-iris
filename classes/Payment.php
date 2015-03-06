<?php
/**
 * Created by PhpStorm.
 * User: Ram.Adhikari
 * Date: 06/03/2015
 * Time: 16:39
 */

class Payment {

    /**
     * Functionr return the relevant configuration variables for payment
     * @return stdClass
     */
    protected function getConfig()
    {
        $param          = new stdClass();
        $param->mode    = 'test'; // 'test' or 'live'

        // Live Mode setting
        if (isset($param->mode) && ($param->mode == 'live') ) {
            $param->api_url         = 'https://hpp.sandbox.globaliris.com/pay';
            $param->merchant_id     = ''; // add value here
            $param->secret_string   = ''; // add value here
        }
        else { // Test mode setting
            $param->api_url         = 'https://hpp.sandbox.globaliris.com/pay';
            $param->merchant_id     = ''; // add value here
            $param->secret_string   = 'secret';
        }
        $param->account         = 'internet';
        $param->currency        = 'GBP'; // eg. GBP, USD, CAD

        return $param;
    }

    /**
     * Function to build the Global IRIS Payment request form and auto submit.
     *
     * @param array $data You can pass any data array if necessary;
     */
    public function payViaHSBCPayment($data = array() )
    {
        // building the param variables; refer some configuration variable below from table.
        $param              = $this->getConfig();
        $param->order_id    = ''; // add value here

        /** The amount need to multiply by 100.
        if actual amount is £25.30, then 25.30*100 = 2530;
         */
        $param->amount      = '2530'; // equivalent to : 25.30;
        $param->timestamp   = date('Ymdhis'); // required format: YYYYMMDDHHMMSS

        // Please don't include 'http://' on the below URL as it will cause response page.
        $param->return_url  = '/registration/confirm.php'; // return page url
        $param->comment_1 = 'Item Description here';
        $param->comment_2 = 'Order number: '.$param->order_id .' <br/> Total amount: '.$param->currency.' '.number_format($param->amount, 2);

        // START of Built HASH String: (TIMESTAMP.MERCHANT_ID.ORDER_ID.AMOUNT.CURRENCY)
        $hash_tmp    = "$param->timestamp.$param->merchant_id.$param->item_number.$param->amount.$param->currency";
        $hash_tmp    = strtolower( sha1( $hash_tmp) );
        $param->sha1hash = sha1 ( $hash_tmp . '.' . $param->secret_hash_string ); // add the above hash string value with secret hash string;
        // END of Building HASH String

        $param->return_url = '/payment/confirm.php'; // Please do not include 'http://www.your_domain_name';

        echo '<body>
                <form method="POST" name="GlobalIrisPaymentForm" action="' . $param->api_url . '">
                    <input type=hidden name="MERCHANT_ID" value="' . $param->merchant_id . '">
                    <input type="hidden" name="ACCOUNT" value="' . $param->account . '">
                    <input type="hidden" name="MERCHANT_RESPONSE_URL" value="' . $param->return_url . '">
                    <input type="hidden" name="ORDER_ID" value= "' . $param->order_id . '">
                    <input type="hidden" name="CURRENCY" value= "' . $param->currency . '">
                    <input type="hidden" name="AMOUNT" value= "' . $param->amount . '">
                    <input type="hidden" name="COMMENT_1" value= "' . $param->comment_1 . '">
                    <input type="hidden" name="COMMENT_2" value= "' . $param->comment_2 . '">
                    <input type="hidden" name="TIMESTAMP" value= "' . $param->timestamp . '">
                    <input type="hidden" name="SHA1HASH" value= "' . $param->sha1hash . '">
                    <input type="hidden" value="Continue to Global IRIS Payment">
                </form>
                <script> document.GlobalIrisPaymentForm.submit(); </script>
            </body>';

        exit();
    }

    /**
     * This function needs to call on 'Response Page' which collect the payment response via $_POST variable form Global IRIS
     * Then, auto redirect you back to the provided MERCHANT_RESPONSE_URL     *
     */
    public function redirectToConfirmationAfterPayment()
    {
        $merchantid = $_POST['MERCHANT_ID'];
        $orderid    = $_POST['ORDER_ID'];
        $account    = $_POST['ACCOUNT'];
        $amount     = $_POST['AMOUNT'];
        $timestamp  = $_POST['TIMESTAMP'];
        $sha1hash   = $_POST['SHA1HASH'];
        $result     = $_POST['RESULT'];
        $message    = $_POST['MESSAGE'];
        $pasref     = $_POST['PASREF'];
        $authcode   = $_POST['AUTHCODE'];
        $comment_1   = $_POST['COMMENT_1'];
        $comment_2   = $_POST['COMMENT_2'];
        $response_url = 'http://' . $_SERVER['SERVER_NAME'] .'/'. $_POST['MERCHANT_RESPONSE_URL'];

        echo 'Please wait, we are verifying the payment...';

        echo '<form name="hsbcResponseForm" action="'.$response_url.'" method="POST">
                <input type="hidden" name="METHOD" value="hsbc">
                <input type="hidden" name="MERCHANT_ID" value="'.$merchantid.'">
                <input type="hidden" name="ORDER_ID" value="'.$orderid.'">
                <input type="hidden" name="ACCOUNT" value="'.$account.'">
                <input type="hidden" name="AMOUNT" value="'.$amount.'">
                <input type="hidden" name="TIMESTAMP" value="'.$timestamp.'">
                <input type="hidden" name="SHA1HASH" value="'.$sha1hash.'">
                <input type="hidden" name="RESULT" value="'.$result.'">
                <input type="hidden" name="MESSAGE" value="'.$message.'">
                <input type="hidden" name="PASREF" value="'.$pasref.'">
                <input type="hidden" name="AUTHCODE" value="'.$authcode.'">
                <input type="hidden" name="COMMENT_1" value= "' . $comment_1 . '">
                <input type="hidden" name="COMMENT_2" value= "' . $comment_2 . '">
             </form>
             <script> document.hsbcResponseForm.submit(); </script>
             ';
    }

    /**
     * This function verify the Payment status based on the response get via $_POST variable.
     * @return bool Return true or false based on the verification
     */
    public function verifyHSBCPayment()
    {
        if ( (isset($_POST['METHOD']) && ($_POST['METHOD'] == 'hsbc') )
            && ( isset($_POST['RESULT']) && ($_POST['RESULT'] == '00') )
        )
        {
            // building the param variables; refer some configuration variable below from table.
            $param              = $this->getConfig();
            $param->order_id    = ''; // add value here

            $post               = $_POST;
            $param->timestamp   = isset($post['TIMESTAMP']) ? $post['TIMESTAMP'] : '';
            $param->order_id    = isset($post['ORDER_ID']) ? $post['ORDER_ID'] : '';
            $param->result      = isset($post['RESULT']) ? $post['RESULT'] : '';// payment success status  : 00 for true;
            $param->message     = isset($post['MESSAGE']) ? $post['MESSAGE'] : '';
            $param->pasref      = isset($post['PASREF']) ? $post['PASREF'] : '';
            $param->authcode    = isset($post['AUTHCODE']) ? $post['AUTHCODE'] : '';
            $param->hash_response = isset($post['SHA1HASH']) ? $post['SHA1HASH'] : '';
            $param->amount      = isset($post['AMOUNT']) ? $post['AMOUNT'] : '';

            // Built HASH String: (TIMESTAMP.MERCHANT_ID.ORDER_ID.RESULT.PASREF.AUTHCODE)
            $tmp        = "$param->timestamp.$param->merchant_id.$param->order_id.$param->result.$param->message.$param->pasref.$param->authcode";
            $tmp        = sha1($tmp);
            $hash_new   = sha1( "$tmp.secret" ) ;

            if ($param->hash_response == $hash_new) {
                // Payment successful

                // ...write codes to update the database and redirection.
                return true;
            }
            else {
                // Payment Failure
                // .... write codes to display error

                return false;
            }
        } else {
            // Payment Failure
            // .... write codes to display error
            return false;
        }
    }

}