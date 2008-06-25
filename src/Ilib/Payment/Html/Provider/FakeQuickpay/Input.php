<?php
/**
 * To control Fake Quickpay <www.quickpay.dk> input page for online payments
 * 
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_Quickpay
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */

class Ilib_Payment_Html_Provider_FakeQuickpay_Input extends Ilib_Payment_Html_Input
{
    
    
    /**
     * Constructor
     * 
     * @param string $merchant merchant number
     * @param string $verification_key verification key
     * @param string $session_id session id
     */
    public function __construct($merchant, $verification_key, $session_id)
    {
        parent::__construct($merchant, $verification_key, $session_id);
    }
    
    /**
     * Returns a path to a input template matching the provider.
     * 
     * @return string template path
     */
    public function getInputTemplatePath() 
    {
        /**
         * Notice that we at using the Quickpay template. This is on purpose
         * so that testing and production uses same template.
         */
        return 'Ilib/Payment/Html/Provider/Quickpay/templates/payment-input-tpl.php';
    }
    
    /**
     * Returns the url to set in front of local urls, to make it secured
     * 
     * @return string secure tunnel url
     */
    public function getSecureTunnelUrl()
    {
        return 'https://secure.quickpay.dk/proxy.php/';
    }
}


?>
