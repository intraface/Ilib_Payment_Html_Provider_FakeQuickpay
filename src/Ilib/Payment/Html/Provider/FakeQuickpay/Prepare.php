<?php
/**
 * Prepares Quickpay <www.quickpay.dk> online payments with html template
 * 
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_Quickpay
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */

require_once 'Ilib/Payment/Html/Provider/Quickpay/Prepare.php';

class Ilib_Payment_Html_Provider_FakeQuickpay_Prepare extends Ilib_Payment_Html_Provider_Quickpay_Prepare
{
    
    /**
     * Contructor
     * 
     * @param string $merchant merchant number
     */
    public function __construct($merchant, $verificaton_key, $session_id)
    {
        parent::__construct($merchant, $verificaton_key, $session_id);
        $this->post_destination = 'fake_quickpay_server.php';
    }
    
    /**
     * Returns the name of the provider. Needs to be overridden in extends.
     * 
     * @return string name of provider
     */
    public function getProviderName()
    {
        return 'FakeQuickpay (only testing)';
    }
}
?>
