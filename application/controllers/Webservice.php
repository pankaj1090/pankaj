<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller
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
        $this -> load -> model('Url_model');
        $this -> load -> model('Merchant_model');
        $this -> load -> helper('string_helper');

    }

     public function signup_api()
     {
         $fullname=$this->input->post('fullname');
         $mobile_no=$this->input->post('mobile_no');
         $children_name=$this->input->post('children_name');
         $address=$this->input->post('address');
         $standard =$this->input->post('standard');
         $password=$this->input->post('password');

         $check_user=$this->Merchant_model->check_merchant($mobile_no);
        //check email already exists or not 
         if(!$check_user)
         {

         $data['fullname']=$fullname;
         $data['mobile_no']=$mobile_no;
         $data['children_name']=$children_name;
         $data['address']=$address;
         $data['standard ']=$standard;
         $data['password']=md5($password);

         if(  $this->Merchant_model->merchant_insert($data))
         {
            $raw_data=array('status'=>"true",
                         'message'=>"Register Successfull",
                         "data" =>   $data
                        );
         }
         else
         {
             $raw_data=array('status'=>"false",
                             'message'=>"data not inserted",
                             "data" => ""
                            );
         }
     }
     else
     {
        $raw_data=array('status'=>"false",
                         'message'=>"Mobile No. Already Exist",
                         "data" => ""
                        );
     }

         echo json_encode($raw_data);

     }
     public function login_api()
     {
         $mobile_no=$this->input->post('mobile_no');
         $password=$this->input->post('password');
         $role=$this->input->post('role');

         if($role=='parent')
         {
            $result= $this->Merchant_model->login_parents($mobile_no,$password);
         if($result)
         {
            $result[0]->password="*********";
            $result[0]->role="parent";

             $raw_data=array('status'=>"true",
                                     'message'=>"Login Successfull",
                                     "data" => $result[0]
                                        );
         }
          else{
             $raw_data=array('status'=>"false",
                                     'message'=>"Login Failed",
                                     "data" =>  ""
                                        );
          }

          echo json_encode($raw_data);
         }
         elseif($role=='admin')
         {
            $result= $this->Merchant_model->login_admin($mobile_no,$password);
         if($result)
         {
            $result[0]->password="*********";
            $result[0]->role="admin";

             $raw_data=array('status'=>"true",
                                     'message'=>"Login Successfull",
                                     "data" => $result[0]
                                        );
         }
          else{
             $raw_data=array('status'=>"false",
                                     'message'=>"Login Failed",
                                     "data" =>  ""
                                        );
          }

          echo json_encode($raw_data);
         }
         elseif($role=='driver')
         {
            $result= $this->Merchant_model->login_driver($mobile_no,$password);
         if($result)
         {
            $result[0]->password="*********";
            $result[0]->role="driver";

             $raw_data=array('status'=>"true",
                                     'message'=>"Login Successfull",
                                     "data" => $result[0]
                                        );
         }
          else{
             $raw_data=array('status'=>"false",
                                     'message'=>"Login Failed",
                                     "data" =>  ""
                                        );
          }

          echo json_encode($raw_data);
         }

     }
     public function get_bus()
     {
         $id=$this->input->post('id');
         $result= $this->Merchant_model->get_bus($id);
         if($result)
         {
       
             $raw_data=array('status'=>"true",
                                     'message'=>"Get Bus",
                                     "data" => $result[0]
                                        );
         }
          else{
             $raw_data=array('status'=>"false",
                                     'message'=>"Invalid Bus id",
                                     "data" =>  ""
                                        );
          }

          echo json_encode($raw_data);

     }
     public function get_driver()
     {
         $id=$this->input->post('id');
         $result= $this->Merchant_model->get_driver($id);
         if($result)
         {
            //$result[0]->password="*********";
            $result[0]->image= base_url($result[0]->image);

             $raw_data=array('status'=>"true",
                                     'message'=>"Get Bus",
                                     "data" => $result[0]
                                        );
         }
          else{
             $raw_data=array('status'=>"false",
                                     'message'=>"Invalid id",
                                     "data" =>  ""
                                        );
          }

          echo json_encode($raw_data);

     }
     public function get_parent()
     {
         $id=$this->input->post('id');
         $result= $this->Merchant_model->get_parent($id);
         if($result)
         {
            //$result[0]->password="*********";
           // $result[0]->image= base_url($result[0]->image);

             $raw_data=array('status'=>"true",
                                     'message'=>"Get Parent",
                                     "data" => $result[0]
                                        );
         }
          else{
             $raw_data=array('status'=>"false",
                                     'message'=>"Invalid id",
                                     "data" =>  ""
                                        );
          }

          echo json_encode($raw_data);

     }
    public function login_out()
    {
    $this->session->sess_destroy();         
    redirect('/doctor/Login', 'refresh');
    }
     public function add_bus()
    {
        $bus_no=$this->input->post('bus_no');
        $data['bus_no']= $bus_no;
        $this->Merchant_model->add_bus($data);
        redirect('/Merchant/add_bus', 'refresh');
    }
     public function deletebus($id)
    {
        $this->Merchant_model->deletebus($id);
        redirect('/Merchant/add_bus', 'refresh');
    }
     public function deletedriver($id)
    {
        $this->Merchant_model->deletedriver($id);
        redirect('/Merchant/all_driver', 'refresh');
    }
     public function deleteparents($id)
    {
        $this->Merchant_model->deleteparent($id);
        redirect('/Merchant/parent', 'refresh');
    }
     public function editdriver($id)
    {

       $data['get_driver']= $this->Merchant_model->get_driver_by_id($id);
        
        $data['page']='driver';
        $data['sub_page']='view_doctors';
        $this -> load -> view('common/head.php');
        $this->load->view('common/sidebar.php', $data);
        $this->load->view('edit_driver.php', $data);
        $this -> load -> view('common/footer.php');
    }
    public function update_driver()
    {
        $id=$this->input->post('id');
        $name=$this->input->post('name');
        $bus_no=$this->input->post('bus_no');
        $mobile_no=$this->input->post('mobile_no');
        $password=$this->input->post('password');
        $route=$this->input->post('route');
        $address=$this->input->post('address');
        $image=$this->input->post('image');

        $this->load->library('upload');
    

         $config['upload_path']   = './assets/images/'; 
         $config['allowed_types'] = 'gif|jpg|jpeg|png';
         $config['max_size']      = 10000; 
         $config['file_name']     = time().$name;
         $this->upload->initialize($config);
         $updateduserimage="";
         if ( $this->upload->do_upload('image'))
         {
           
            $updateduserimage='assets/images/'.$this->upload->data('file_name'); 
         }
         else  
          {
//            echo $this->upload->display_errors();
          }
          if($updateduserimage)
          {
            $data['id']= $id;
            $data['bus_no']= $bus_no;
            $data['name']= $name;
            $data['mobile_no']= $mobile_no;
            $data['password']= md5($password);
            $data['route']= $route;
            $data['address']= $address;
            $data['image']= $updateduserimage;
          }
          else
          {
            $data['id']= $id;
            $data['bus_no']= $bus_no;
            $data['name']= $name;
            $data['mobile_no']= $mobile_no;
            $data['password']= md5($password);
            $data['route']= $route;
            $data['address']= $address;
          }

            $this->Merchant_model->edit_driver($data, $id);
            redirect('/Merchant/all_driver', 'refresh');
    }
    public function update_bus_location()
    {

        $bus_no=$this->input->post('bus_no');
        $latitude=$this->input->post('latitude');
        $longitude=$this->input->post('longitude');
   
        
            $data['bus_no']= $bus_no;
            $data['longitude']= $longitude;
            $data['latitude']= $latitude;

            $data=$this->Merchant_model->update_bus_location($data, $bus_no);
            //redirect('/Merchant/all_driver', 'refresh');
            $arr = array('status' => 'ture', 'message' => "Update location sucessfully"); 
         header('Content-Type: application/json');      
         echo json_encode($arr);
    }
     public function add_driver()
  
    {
        $name=$this->input->post('name');
        $bus_no=$this->input->post('bus_no');
        $mobile_no=$this->input->post('mobile_no');
        $password=$this->input->post('password');
        $route=$this->input->post('route');
        $address=$this->input->post('address');
        $image=$this->input->post('image');

        $this->load->library('upload');
    

         $config['upload_path']   = './assets/images/'; 
         $config['allowed_types'] = 'gif|jpg|jpeg|png';
         $config['max_size']      = 10000; 
         $config['file_name']     = time().$name;
         $this->upload->initialize($config);
         $updateduserimage="";
         if ( $this->upload->do_upload('image'))
         {
           
            $updateduserimage='assets/images/'.$this->upload->data('file_name'); 
         }
         else  
          {
//            echo $this->upload->display_errors();
          }

        $data['bus_no']= $bus_no;
        $data['name']= $name;
        $data['mobile_no']= $mobile_no;
        $data['password']= md5($password);
        $data['route']= $route;
        $data['address']= $address;
        $data['image']= $updateduserimage;
        //print_r($data);

        $this->Merchant_model->add_driver($data);
        redirect('/Merchant/all_driver', 'refresh');
    }
}