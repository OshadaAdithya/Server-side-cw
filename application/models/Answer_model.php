<?php
class Answer_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function create_answer($data) {
        //return $this->db->insert('answers', $data);
        // Check if answer already exists to prevent duplicates
        $this->db->where('body', $data['body']);
        $this->db->where('question_id', $data['question_id']);
        $this->db->where('user_id', $data['user_id']);
        $query = $this->db->get('answers');

        if ($query->num_rows() == 0) {
            // Insert answer if it doesn't already exist
            return $this->db->insert('answers', $data);
        } else {
            return false; // Duplicate answer
        }
    }

    public function get_answers($question_id) {
        $this->db->where('question_id', $question_id);
        return $this->db->get('answers')->result_array();
    }

    

    // public function vote($answer_id, $user_id, $vote_type) {
    //     // Insert a new vote record
    //     $this->db->insert('answer_votes', [
    //         'answer_id' => $answer_id,
    //         'user_id' => $user_id,
    //         'vote_type' => $vote_type
    //     ]);

    //     // Update the counts in the answers table
    //     if ($vote_type == 'upvote') {
    //         $this->db->set('upvotes', 'upvotes+1', FALSE);
    //     } else {
    //         $this->db->set('downvotes', 'downvotes+1', FALSE);
    //     }
    //     $this->db->where('id', $answer_id);
    //     return $this->db->update('answers');
    // }

    // public function delete_answer($answer_id) {
    //     $this->db->where('id', $answer_id);
    //     return $this->db->delete('answers');
    // }

    public function delete_answers_by_question($question_id) {
        $this->db->where('question_id', $question_id);
        return $this->db->delete('answers');
    }
    
}
?>
