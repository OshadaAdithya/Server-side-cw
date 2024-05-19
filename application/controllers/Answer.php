<?php
class Answer extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Answer_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function postAnswer() {
        /*$data = json_decode($this->input->raw_input_stream, true);
        $data['user_id'] = $this->session->userdata('user_id');
        $this->Answer_model->create_answer($data);
        echo json_encode(['status' => 'success']);*/

         // Ensure the user is logged in
         if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        $data = json_decode($this->input->raw_input_stream, true);

        // Validate the input data
        if (empty($data['body']) || empty($data['question_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
            return;
        }

        $data['user_id'] = $this->session->userdata('user_id');
        
        // Use a try-catch block to handle any potential errors
        try {
            $this->Answer_model->create_answer($data);
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getAnswers($question_id) {
        $answers = $this->Answer_model->get_answers($question_id);
        echo json_encode(['answers' => $answers]);
    }


    // public function vote() {
    //     $data = json_decode($this->input->raw_input_stream, true);
    //     $answer_id = $data['answer_id'];
    //     $vote_type = $data['vote_type'];
    //     $user_id = $this->session->userdata('user_id');

    //     if (!$user_id) {
    //         echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    //         return;
    //     }

    //     $this->Answer_model->vote($answer_id, $user_id, $vote_type);
    //     echo json_encode(['status' => 'success']);
    // }
    // public function vote() {
    //     $data = json_decode($this->input->raw_input_stream, true);
    //     $answer_id = $data['answer_id'];
    //     $vote_type = $data['vote_type'];
    //     $user_id = $this->session->userdata('user_id');
    
    //     if (!$user_id) {
    //         echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    //         return;
    //     }
    
    //     log_message('debug', 'Received vote request: ' . json_encode($data));
    
    //     $result = $this->Answer_model->vote($answer_id, $user_id, $vote_type);
    
    //     if ($result) {
    //         echo json_encode(['status' => 'success']);
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Failed to process vote']);
    //     }
    // }

    public function deleteAnswer() {
        $data = json_decode($this->input->raw_input_stream, true);
        $answer_id = $data['answer_id'];
        $this->Answer_model->delete_answer($answer_id);
        echo json_encode(['status' => 'success']);
    }
}
?>
