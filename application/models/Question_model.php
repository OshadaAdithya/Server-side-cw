<?php
class Question_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    public function create_question($data) {
        return $this->db->insert('questions', $data);
    }

    public function get_questions() {
        return $this->db->get('questions')->result_array();
    }

    public function get_question($question_id) {
        $this->db->where('id', $question_id);
        return $this->db->get('questions')->row_array();
    }

    public function get_questions_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('questions')->result_array();
    }

    public function delete_question($question_id) {
        $this->db->where('id', $question_id);
        return $this->db->delete('questions');
    }
    

    
}
