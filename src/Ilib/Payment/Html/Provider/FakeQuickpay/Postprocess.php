<?php
/**
 * Fake class for testing postprocess Quickpay <www.quickpay.dk> online payments with html template
 *
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_FakeQuickpay
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */
require_once 'Ilib/Payment/Html/Provider/Quickpay/Postprocess.php';

class Ilib_Payment_Html_Provider_FakeQuickpay_Postprocess extends Ilib_Payment_Html_Provider_Quickpay_Postprocess
{
    /**
     * Contructor
     *
     * @param string $merchant merchant number
     * @param string $language the language used in the payment
     *
     * @return void
     */
    public function __construct($merchant, $verification_key, $session_id)
    {
        parent::__construct($merchant, $verification_key, $session_id);
    }
}

