<?php
class Question extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Question_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    /*public function list() {
        /*$questions = $this->Question_model->get_questions();
        echo json_encode(['questions' => $questions]);
        $this->load->view('navbar', ['title' => 'Question']);
        $this->load->view('question');


    }*/

    public function index() {
        $this->load->view('navbar', ['title' => 'Questions']);
        $this->load->view('question');
        
    }

    public function create() {
        if (!$this->session->userdata('user_id')) {
            redirect('user/login');
        }
        $this->load->view('navbar', ['title' => 'Create Question']);
        $this->load->view('create_question');
        
    }

    public function getQuestions() {
        $questions = $this->Question_model->get_questions();
        echo json_encode(['questions' => $questions]);
    }

    public function postQuestion() {
        $data = json_decode($this->input->raw_input_stream, true);
        $data['user_id'] = $this->session->userdata('user_id');
        $this->Question_model->create_question($data);
        echo json_encode(['status' => 'success']);
    }

    public function view($question_id) {
        $question = $this->Question_model->get_question($question_id);
        if (!$question) {
            show_404();
        }
        $this->load->view('navbar', ['title' => 'Question Details']);
        $this->load->view('view_question', ['question_id' => $question_id]);
    }

    public function getQuestion($question_id) {
        $question = $this->Question_model->get_question($question_id);
        echo json_encode($question);
    }
    
    public function getUserQuestions() {
        $user_id = $this->session->userdata('user_id');
    
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
    
        $questions = $this->Question_model->get_questions_by_user($user_id);
    
        echo json_encode(['status' => 'success', 'questions' => $questions]);
    }

    public function delete($question_id) {
        // Load necessary models
        $this->load->model('Question_model');
        $this->load->model('Answer_model');
    
        // Delete answers associated with the question
        $this->Answer_model->delete_answers_by_question($question_id);
    
        // Delete the question
        $result = $this->Question_model->delete_question($question_id);
    
        // if ($result) {
        //     // Question deleted successfully
        //     echo '<script>alert("Question deleted successfully!");</script>';
        //     redirect('profile'); // Redirect to the profile page
        // } else {
        //     // Question deletion failed
        //     echo '<script>alert("Failed to delete question.");</script>';
        //     redirect('profile'); // Redirect to the profile page
        // }

        if ($result) {
            // Question deleted successfully
            $response = array('status' => 'success', 'message' => 'Question deleted successfully');
        } else {
            // Question deletion failed
            $response = array('status' => 'error', 'message' => 'Failed to delete question');
        }

        // Send JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    
}

?>