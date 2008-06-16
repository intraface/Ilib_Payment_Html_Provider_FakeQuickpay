<?php
/*
 * Created on Dec 7, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Ilib_Payment_Html_Provider_FakeQuickpay_PaymentProcess
{
    
    private $md5_secret;
    
    public function __construct($verification_key) 
    {
        $this->md5_secret = $verification_key;
    }
    
    /**
     * Process post data. 
     * 
     * @return string redirect location. 
     */
    public function process($input, &$session)
    {
        
        if(empty($session['payment_details'])) {
            throw new Exception('Sessions are not working properly. They need to do!');
            exit;
        }
        
        
        if(empty($input['cardnum']) || empty($input['cvd'])) {
            return $session['payment_details']['errorpage'];
            exit;
        }
        
        $time = date('ymdHis');
        $md5check = md5($session['payment_details']['amount'].$time.$session['payment_details']['ordernum'].'000'.'000'.'Approved'.'test@intraface.dk'.$session['payment_details']['merchant'].$session['payment_details']['currency'].'Visa'.'123'.$this->md5_secret);

        require_once 'HTTP/Request.php';
        $client = new HTTP_Request($session['payment_details']['resultpage']);
        $client->setMethod(HTTP_REQUEST_METHOD_POST);
        $client->AddPostData('amount', $session['payment_details']['amount']);
        $client->AddPostData('time', $time);
        $client->AddPostData('ordernum', $session['payment_details']['ordernum']);
        $client->AddPostData('pbsstat', '000');
        $client->AddPostData('qpstat', '000');
        $client->AddPostData('qpstatmsg', 'Approved');
        $client->AddPostData('merchantemail', 'test@intraface.dk');
        $client->AddPostData('merchant', $session['payment_details']['merchant']);
        $client->AddPostData('currency', $session['payment_details']['currency']);
        $client->AddPostData('cardtype', 'Visa');
        $client->AddPostData('transaction', '123');
        $client->AddPostData('md5checkV2', $md5check);
        
        foreach($session['payment_details'] AS $key => $value) {
            if(substr($key, 0, 7) == 'CUSTOM_') {
                $client->AddPostData($key, $value);
            } 
        }    
        $request = $client->sendRequest();
 
        if(PEAR::isError($request)) {
            throw new Exception('Error in post reguest: '.$request->getUserInfo());
        }
        
        $result = $client->getResponseBody();
        if($client->getResponseCode() != 200) { /* SUCCESS! */
            throw new Exception('Error in processing the order. We got this message: '. $result);
        } 
        
        return $session['payment_details']['okpage'];
    }
    
    
    public function getPage($input, &$session, $post_destination)
    {
        $required_fields = array('language', 'autocapture', 'ordernum', 'amount', 'currency', 'merchant', 'okpage', 'errorpage', 'resultpage', 'md5checkV2');
        
        foreach($required_fields AS $field) {
            if(!isset($input[$field])) {
                throw new Exceptin('The field '.$field.' need to be present!');
            }
        }            
        
        $session['payment_details'] = $input;
        
        if(!empty($input['ccipage'])) {
            
            $content = file_get_contents(urldecode($input['ccipage']));
            $content = str_replace('###ORDERNUM###', $input['ordernum'], $content);
            $content = str_replace('###CURRENCY###', $input['currency'], $content);
            $content = str_replace('###AMOUNT_FORMATTED###', number_format($input['amount']/100, 2, ',', '.'), $content);
            $content = str_replace('###CARDS###', '<p class="cards">Cards you can use</p><p class="cards"><img src="https://secure.quickpay.dk/gfx/cards/dankort.gif" alt="Dankort" /><img src="https://secure.quickpay.dk/gfx/cards/mastercard.gif" alt="Mastercard" /><img src="https://secure.quickpay.dk/gfx/cards/visa.gif" alt="Visa" /><img src="https://secure.quickpay.dk/gfx/cards/visa-electron.gif" alt="Visa Electron" /><img src="https://secure.quickpay.dk/gfx/cards/jcb.gif" alt="JCB" /></p>', $content);
            $content = str_replace('###TXT_CARDNUM###', 'Card number', $content);
            $content = str_replace('###TXT_EXPIR###', 'Date of expiration (mm/yy)', $content);
            $content = str_replace('###TXT_CVD###', 'Card verification data', $content);
            $content = str_replace('###TXT_PAYBUTTON###', 'Pay', $content);
            $content = str_replace('###MONTH_OPTIONS###', '<option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>', $content);
            $content = str_replace('###YEAR_OPTIONS###', 'option value="07">2007</option><option value="08">2008</option><option value="09">2009</option><option value="10">2010</option><option value="11">2011</option><option value="12">2012</option><option value="13">2013</option><option value="14">2014</option><option value="15">2015</option><option value="16">2016</option><option value="17">2017</option><option value="18">2018</option><option value="19">2019</option><option value="20">2020</option><option value="21">2021</option><option value="22">2022</option><option value="23">2023</option>', $content);
            $content = str_replace('https://secure.quickpay.dk/quickpay_pay.php', $post_destination, $content);
            
            return '<div style="color: red;">TEST SERVER!</div>'.$content; 
        }
        
        throw new Exception('At this moment this only works with CCI page!');
    
    }
}
