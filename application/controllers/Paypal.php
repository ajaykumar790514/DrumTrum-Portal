<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends CI_Controller {
	
    // public function isLoggedIn()
    // {
    //     if($this->session->userdata('logged_in'))
    //     {
    //         $is_logged_in = $this->session->userdata('logged_in');
    //     }
    //     else
    //     {
    //         $is_logged_in = get_cookie("logged_in");
    //     }
    //     if(!isset($is_logged_in) || $is_logged_in!==TRUE)
    //     {
    //         redirect('logout');
    //         exit;
    //     }
    // } 

    public function index()
    {
        $this->load->view('paypal');
    }
    
    public function createPaypalOrder()
    {
        // initialize CURL
        //$total=$_POST['total'];
        //$currency=$_POST['currency'];
        $token=$this->generateToken();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v2/checkout/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token 
                    ]);
  
        $data=array(
        'intent'=>'CAPTURE',
        'purchase_units'=>array('0'=>array('amount'=>array('currency_code'=>'USD','value'=>'100.00')))  
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        
        $response = curl_exec($ch);

        curl_close($ch);
        
        echo $response;
    }
    
    public function capturePaypalOrder()
    {
        $token=$this->generateToken();
        $orderId=$_POST['orderID'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v2/checkout/orders/'.$orderId.'/capture');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '. $token,
        ]);

        $response = curl_exec($ch);

        curl_close($ch);
        
        echo $response;
    }
    
    public function generateToken()
    {
        // initialize CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        // write your own client ID and client secret in following format:
        // {client_id}:{client_secret}
        curl_setopt($ch, CURLOPT_USERPWD, 'AeEf3b7teyrOz_QNr-UtLXLMYy20X6Z9yd0rCx6LZbGNHRH9foQJvdCP56J77vkbOPP-ne38H6hWB5_C:EDHfjUocYr_-wTyOvEQRiV_br1MttYJUGCWdf01TgBhBFY4M49fXjDRvcs5VJC_BlTPyPNxMyrTuTKDz');

        // set headers
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // call the CURL request
        $result = curl_exec($ch);

        // check if there is any error in generating token
        if (curl_errno($ch))
        {
            echo json_encode([
                "status" => "error",
                "message" => curl_error($ch)
            ]);
            exit();
        }
        curl_close($ch);

        // the response will be a JSON string, so you need to decode it
        $result = json_decode($result);

        // get the access token
        $access_token = $result->access_token;
        return $access_token;
 
    }
    
	
}