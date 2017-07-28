<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> load -> library('session');
        $this -> load -> helper('form');
        $this -> load -> helper('url');
        $this -> load -> database();
        $this -> load -> library('form_validation');
        $this -> load -> model('Login_model');
        $this -> load -> model('Merchant_model');
    }

    public function index()
    {
        if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['email'] == FALSE)
        {  
            redirect('Login');
        }
        else
        {
            $data['merchant']=$this->Merchant_model->get_all_merchant();

            $this -> load -> view('common/head.php');
            $this->load->view('common/sidebar.php');
            $this->load->view('dashboard.php');
            $this -> load -> view('common/footer.php');
        }
    }
    public function parent()
    {
        if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['email'] == FALSE)
        {  
            redirect('Login');
        }
        else
        {
            $data['merchant']=$this->Merchant_model->get_all_merchant();
            $data['page']='parents';
            $this -> load -> view('common/head.php');
            $this->load->view('common/sidebar.php', $data);
            $this->load->view('parents.php',$data);
            $this -> load -> view('common/footer.php');
        }
    }
    public function add_bus()
    {
        if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['email'] == FALSE)
        {  
            redirect('Login');
        }
        else
        {
           $data['merchant']=$this->Merchant_model->all_bus();

            $data['page']='add_bus';
            $this -> load -> view('common/head.php');
            $this->load->view('common/sidebar.php', $data);
            $this->load->view('add_bus.php', $data);
            $this -> load -> view('common/footer.php');
        }
    }
    public function all_driver()
    {
        if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['email'] == FALSE)
        {  
            redirect('Login');
        }
        else
        {
            $data['merchant']=$this->Merchant_model->all_driver();

            $data['page']='driver';
            $data['sub_page']='view_doctors';
            $this -> load -> view('common/head.php');
            $this->load->view('common/sidebar.php', $data);
            $this->load->view('all_drivers.php', $data);
            $this -> load -> view('common/footer.php');
        }
    }
    public function add_driver()
    {
        if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['email'] == FALSE)
        {  
            redirect('Login');
        }
        else
        {
           // $data['merchant']=$this->Merchant_model->get_all_merchant();

            $data['page']='driver';
            $data['sub_page']='add_driver';
            $this -> load -> view('common/head.php');
            $this->load->view('common/sidebar.php', $data);
            $this->load->view('add_driver.php');
            $this -> load -> view('common/footer.php');
        }
    }
    
}