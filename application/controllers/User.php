<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function signup() {
        $this->load->view('navbar', ['title' => 'Sign Up']);
        $this->load->view('signup');
        //$this->load->view('footer');
    }

    public function register() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('navbar', ['title' => 'Sign Up']);
            $this->load->view('signup');
            $this->load->view('footer');
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
            );

            if ($this->User_model->register($data)) {
                redirect('user/login');
            } else {
                $this->load->view('navbar', ['title' => 'Sign Up']);
                $this->load->view('signup', ['error' => 'There was a problem creating your account. Please try again.']);
                $this->load->view('footer');
            }
        }
    }


    public function login() {
        $redirect_url = $this->input->get('redirect', TRUE);
        $data['redirect_url'] = $redirect_url;
        $this->load->view('navbar', ['title' => 'Log In']);
        $this->load->view('login', $data);
        //$this->load->view('footer');
    }

    public function userLogin() {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('loginMessage', 'Invalid login credentials');
            redirect('login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->User_model->login($email, $password);

            if ($user) {
                $this->session->set_userdata('user_id', $user->id);
                //redirect('questions');
                $redirect_url = $this->input->post('redirect_url');
                redirect($redirect_url ? $redirect_url : 'questions');
            } else {
                $this->session->set_flashdata('loginMessage', 'Invalid login credentials');
                redirect('login');
            }
        }
    }

    public function logout() {
        /*$this->session->unset_userdata('user_id');
        redirect('login');*/

        // Destroy the session
        $this->session->sess_destroy();
        
        // Redirect to the login page or home page
        redirect('user/login');
    }

    public function profile() {
        $this->load->view('navbar', ['title' => 'Profile']);

        $this->load->view('profile');
        //$this->load->view('footer');
    }

    public function showDetail(){
        $user_id = $this->session->userdata('user_id');
        
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
        
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_id($user_id);

        echo json_encode(['status' => 'success', 'details' => ['user' => $user]]);
    }

    
    
}
