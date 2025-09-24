<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class cpimage extends CI_Controller
{
	protected $data;
    function __construct() {
		parent::__construct();
		// Load the captcha helper
		//$this->load->helper('captcha');
    }
    
    public function index(){
		$this->load->library('captcha');
	$this->data['captcha'] = $this->captcha->main();
	$this->session->set_userdata('captcha_info', $this->data['captcha']);
	echo '<img src="'.$this->data['captcha']['image_src'].'" alt="CAPTCHA security code" />';
    }
	
	
}