<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
public function store($table, $data)
{
    $this->db->table($table)->insert($data);
    return $this->db->insertID();
}
public function get_accepted_students()
{
    $sql = "SELECT student_id, name, message, image_filename
            FROM students
            WHERE status = 'Accepted'";

    return $this->db->query($sql)->getResultArray();
}



public function get_students()
{
    $sql = "SELECT student_id, name, message, image_filename, status
            FROM students";
    return $this->db->query($sql)->getResultArray();
}

public function getQuizQuestionsWithChoices($quiz_id)
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT 
                qq.quiz_question_id,
                qq.quiz_id,
                q.name,
                qq.question_text,
                qq.q_type,
                qq.marks,
                GROUP_CONCAT(c.choice_text ORDER BY c.choice_id SEPARATOR '|||') AS choices
            FROM quiz_questions qq
            JOIN tbl_quiz q ON q.quiz_id = qq.quiz_id
            LEFT JOIN choices c ON c.quiz_question_id = qq.quiz_question_id
            WHERE qq.quiz_id = ?
            GROUP BY qq.quiz_question_id
            ORDER BY qq.quiz_question_id
        ";

        return $db->query($sql, [$quiz_id])->getResult();
    }

    // ✅ Get correct answers for a quiz (used for marking)
    public function getCorrectAnswersByQuiz($quiz_id)
    {
        $sql = "
            SELECT 
                c.quiz_question_id,
                c.choice_text
            FROM choices c
            JOIN quiz_questions qq ON c.quiz_question_id = qq.quiz_question_id
            WHERE qq.quiz_id = ? AND c.is_correct = 1
        ";

        $query = $this->db->query($sql, [$quiz_id]);
        $results = $query->getResult();

        $correctAnswers = [];
        foreach ($results as $row) {
            $correctAnswers[$row->quiz_question_id][] = $row->choice_text;
        }

        return $correctAnswers;
    }

public function updateData($table, $where, $data)
{
    return $this->db->table($table)->update($data, $where);
}

public function deleteData($table, $where)
{
    return $this->db->table($table)->delete($where);
}



// public function getAllQuizzes()
// {
//     return $this->db->table('tbl_quiz')
//                     ->select('quiz_id, quiz_name, total_marks')
//                     ->get()
//                     ->getResultArray();
// }
public function view_quiz($quiz_id)
{
    $model = new \App\Models\QuizModel();
    $quizData = $model->getQuizWithQuestions($quiz_id);

    if (empty($quizData)) {
        return redirect()->to('/quizzes')->with('error', 'Quiz not found or has no questions.');
    }

    return view('quiz/view_quiz', ['quizData' => $quizData]);
}

// public function getQuizQuestionsWithChoices($quiz_id)
// {
//     $db = \Config\Database::connect();
//     $sql = "
//         SELECT 
//             qq.quiz_question_id,
//             qq.quiz_id,
//             q.name,
//             qq.question_text,
//             q.time_limit,

//             qq.q_type,
//             qq.marks,
//             GROUP_CONCAT(c.choice_text ORDER BY c.choice_id SEPARATOR '|||') AS choices
//         FROM quiz_questions qq
//         JOIN tbl_quiz q ON q.quiz_id = qq.quiz_id
//         LEFT JOIN choices c ON c.quiz_question_id = qq.quiz_question_id
//         WHERE qq.quiz_id = ?
//         GROUP BY qq.quiz_question_id
//         ORDER BY qq.quiz_question_id
//     ";

//     $query = $db->query($sql, [$quiz_id]);
//     return $query->getResult();
// }

public function getClassesByQuiz($quiz_id)
{
    $db = \Config\Database::connect();

    $sql = "
        SELECT classes.class_id, classes.class_name
        FROM classes
        JOIN quiz_class ON classes.class_id = quiz_class.class_id
        WHERE quiz_class.quiz_id = ?
    ";

    $query = $db->query($sql, [$quiz_id]);
    return $query->getResult(); // returns array of objects
}


public function getQuizCreatorInfo($quiz_id)
{
    $sql = "SELECT tbl_staff.username, tbl_staff.Instution_Name, tbl_staff.inst_image
            FROM tbl_staff, tbl_quiz
            WHERE tbl_staff.staff_id = tbl_quiz.created_by
              AND tbl_quiz.quiz_id = ?";
    return $this->db->query($sql, [$quiz_id])->getRow();
}

// ...existing code...
public function fetchClassesWithTeachers()
{
    $teacherId = session()->get('staff_id');  // Get teacher ID from session

    $sql = "SELECT classes.class_id, class_name, tbl_staff.username AS teacher_name, tbl_staff.staff_id AS teacher_id
            FROM classes, tbl_staff
            WHERE tbl_staff.staff_id = classes.teacher_id
            AND classes.teacher_id = ?";

    return $this->db->query($sql, [$teacherId])->getResultArray();
}
public function getQuizzesByTeacher($teacherId)
{
    $sql = "SELECT quiz_id, name FROM tbl_quiz WHERE created_by = ?";
    return $this->db->query($sql, [$teacherId])->getResultArray();
}
public function getClassesByTeacher($teacherId)
{
    $sql = "SELECT class_id, class_name FROM classes WHERE teacher_id = ?";
    return $this->db->query($sql, [$teacherId])->getResultArray();
}

public function fetchQuizWithCreator($staffId)
{
    $sql = "SELECT quiz_id, name, total_marks, time_limit, description, tbl_quiz.status, tbl_staff.username 
            FROM tbl_quiz, tbl_staff 
            WHERE tbl_staff.staff_id = tbl_quiz.created_by 
              AND tbl_quiz.created_by=?";

    return $this->db->query($sql, [$staffId])->getResultArray();
}
public function getQuizMetaById($quiz_id)
{
    $sql = "SELECT quiz_id, name, total_marks, time_limit, description, status 
            FROM tbl_quiz 
            WHERE quiz_id = ?";

    return $this->db->query($sql, [$quiz_id])->getRow(); // returns stdClass object
}

public function fetchQuizClassByTeacher($teacherId)
{
    $sql = "SELECT 
                quiz_class.id, 
                quiz_class.quiz_id, 
                quiz_class.class_id,
                tbl_quiz.name AS quiz_name, 
                classes.class_name
            FROM quiz_class
            JOIN tbl_quiz ON quiz_class.quiz_id = tbl_quiz.quiz_id
            JOIN classes ON quiz_class.class_id = classes.class_id
            WHERE tbl_quiz.created_by = ?";

    return $this->db->query($sql, [$teacherId])->getResultArray();
}

public function getQuizzesBySession($staffId)
{
    $sql = "SELECT quiz_id, name FROM tbl_quiz WHERE created_by = ?";
    return $this->db->query($sql, [$staffId])->getResultArray();
}



}