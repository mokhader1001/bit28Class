<?php

namespace App\Controllers;
use App\Models\UserModel ;
use CodeIgniter\Controller;


class quizcontroller extends Controller
{
    public function class()
    {
        return view('classes/class.php');
    }

        public function body(): string
{           return view('body');
}

public function view_quiz($quiz_id)
{
    $model = new \App\Models\QuizModel();

    // Fetch quiz questions with choices
    $quizData = $model->getQuizQuestionsWithChoices($quiz_id);
       // $quizzes = $model->fetchQuizWithCreator($staffId);
           $staffId = session()->get('staff_id');
    $quizzes = $model->getQuizMetaById($quiz_id);
    
 


    if (empty($quizData)) {
        return redirect()->to('/quizzes')->with('error', 'Quiz not found or has no questions.');
    }

    // Fetch associated classes
    $classes = $model->getClassesByQuiz($quiz_id);

    // Fetch quiz creator information
    $creatorInfo = $model->getQuizCreatorInfo($quiz_id);

    return view('quiz/Exam', [
        'quizData'    => $quizData,
        'classes'     => $classes,
        'creatorInfo' => $creatorInfo,
        'quizes'     => $quizzes,
    ]);
}
public function submit_quiz_answers()
{
    $request = service('request');
    $quiz_id     = $request->getPost('quiz_id');
    $student_id  = $request->getPost('student_id');
    $start_time  = $request->getPost('start_time');
    $end_time    = $request->getPost('end_time');
    $answers     = $request->getPost('answers'); // answers[question_id] => user_choice (choice_id)

    $model = new \App\Models\QuizModel();

    // Fetch correct answers (returns [question_id => [choice_id, ...]])
    $correctAnswers = $model->getCorrectAnswersByQuiz($quiz_id);
    $quizData       = $model->getQuizQuestionsWithChoices($quiz_id);

    $score = 0;
    $totalMarks = 0;
    $feedback = [];

    $db = \Config\Database::connect();
    $db->transStart();

    foreach ($quizData as $question) {
        $qid         = $question->quiz_question_id;
        $totalMarks += $question->marks;
        $submitted   = $answers[$qid] ?? null;

        if ($submitted !== null) {
            // $submitted is the choice_id
            $correctChoices = $correctAnswers[$qid] ?? [];
            $isCorrect = in_array($submitted, $correctChoices);

            if ($isCorrect) {
                $score += $question->marks;
            }

            // Store student's answer in quiz_answers table
            $model->store('quiz_answers', [
                'quiz_question_id' => $qid,
                'std_id'           => $student_id,
                'choice_id'        => $submitted,
                'is_correct'       => $isCorrect ? 1 : 0
            ]);

            $feedback[] = [
                'question_id'     => $qid,
                'question'        => $question->question_text,
                'submitted'       => $submitted,
                'correct'         => $isCorrect,
                'correct_answer'  => implode(', ', $correctChoices),
                'marks'           => $question->marks,
                'earned'          => $isCorrect ? $question->marks : 0,
            ];
        }
    }

    // Save to quiz_attempts table using store()
    $model->store('quiz_attempts', [
        'quiz_id'      => $quiz_id,
        'std_id'       => $student_id,
        'started_at'   => $start_time,
        'submitted_at' => $end_time,
        'total_score'  => $score
    ]);

    $db->transComplete();

    // Return JSON
    return $this->response->setJSON([
        'status'     => 'success',
        'message'    => 'Quiz marked and saved successfully.',
        'score'      => $score,
        'out_of'     => $totalMarks,
        'details'    => $feedback
    ]);
}


public function check_or_create_student()
{
    $request   = service('request');
    $name      = trim($request->getPost('name'));
    $phone     = trim($request->getPost('phone'));
    $class_id  = trim($request->getPost('class_id'));

    if (!$name || !$phone || !$class_id) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Name, phone, and class ID are required.'
        ]);
    }

    $db = \Config\Database::connect();

    // Check if student exists
    $query = $db->query("
        SELECT * FROM students 
        WHERE name = ? AND phone = ? AND class_id = ?
        LIMIT 1
    ", [$name, $phone, $class_id]);

    $existing = $query->getRow();

    if ($existing) {
        return $this->response->setJSON([
            'status'  => 'exists',
            'message' => 'Student already exists.',
            'student' => $existing
        ]);
    }

    // Create new student
    $data = [
        'name'     => $name,
        'phone'    => $phone,
        'class_id' => $class_id
    ];

    $db->table('students')->insert($data);
    $newId = $db->insertID();

    return $this->response->setJSON([
        'status'  => 'created',
        'message' => 'Student created successfully.',
        'student' => array_merge($data, ['std_id' => $newId])
    ]);
}



public function view_all_quizzes()
{
    $model = new \App\Models\QuizModel();
    $quizzes = $model->getAllQuizzes(); // You will define this in the model

    return view('quiz/view_all', ['quizzes' => $quizzes]);
}


public function quizes(): string
{
    $model = new \App\Models\QuizModel();
    $staffId = session()->get('staff_id');

    // Fetch quizzes created by this teacher
    $data['quizzes'] = $model->getQuizzesBySession($staffId);

    return view('quiz/quiz', $data);
}

   public function quiz_summary()
{
    $model = new \App\Models\QuizModel();
    $teacherId = session()->get('staff_id');

    // Fetch quizzes and classes assigned to this teacher
    $data['quizzes'] = $model->getQuizzesByTeacher($teacherId);
    $data['classes'] = $model->getClassesByTeacher($teacherId);

    return view('quiz/quiz_summary', $data);
}
   public function quiz_class()
{
    $model = new \App\Models\QuizModel();
    $teacherId = session()->get('staff_id');

    // Fetch quizzes and classes assigned to this teacher
    $data['quizzes'] = $model->getQuizzesByTeacher($teacherId);
    $data['classes'] = $model->getClassesByTeacher($teacherId);

    return view('quiz/quiz_class', $data);
}
    public function save_class()
{
    $model = new \App\Models\QuizModel();
    $table = 'classes';
    $request = $this->request;

    $className = trim($request->getPost('class_name'));
    $teacher = session()->get('staff_id');

    // Check if class name exists (ignore current id for update)
    $existingClass = $model->db->table($table)
        ->where('class_name', $className);

    $id = $request->getPost('class_id');
    if ($id) {
        // Exclude the current record when updating
        $existingClass->where('class_id !=', $id);
    }

    $exists = $existingClass->countAllResults(false) > 0;

    if ($exists) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Class name already registered'
        ]);
    }

    $data = [
        'class_name' => $className,
        'teacher_id' => $teacher
    ];

    if ($id) {
        $success = $model->updateData($table, ['class_id' => $id], $data);
    } else {
        $success = $model->store($table, $data);
    }

    return $this->response->setJSON([
        'status' => $success ? 'success' : 'error',
        'message' => $success ? 'Class saved successfully' : 'Failed to save class'
    ]);
}

public function fetch_quiz_class()
{
    $model = new \App\Models\QuizModel();
    $teacherId = session()->get('staff_id');

    $data = $model->fetchQuizClassByTeacher($teacherId);

    foreach ($data as &$row) {
        $row['actions'] = '
            <button class="btn btn-warning btn-sm editBtn"
                data-id="' . $row['id'] . '"
                data-quiz="' . $row['quiz_id'] . '"
                data-class="' . $row['class_id'] . '">
                <i class="fas fa-edit"></i>
            </button>
        
        ';
    }

    return $this->response->setJSON(['data' => $data]);
}
public function save_quiz_class()
{
    $model = new \App\Models\QuizModel();
    $request = $this->request;
    $teacherId = session()->get('staff_id');

    // DELETE operation
    if ($request->getPost('_method') === 'DELETE') {
        $id = $request->getPost('id');
        $success = $model->deleteData('quiz_class', ['id' => $id]);
        return $this->response->setJSON(['status' => $success ? 'success' : 'error']);
    }

    // Validation rules
    $validationRules = [
        'quiz_id'   => 'required|is_natural_no_zero',
        'class_id'  => 'required|is_natural_no_zero',
    ];

    if (!$this->validate($validationRules)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => implode(', ', $this->validator->getErrors())
        ]);
    }

    // Clean data
    $data = [
        'quiz_id'    => $request->getPost('quiz_id'),
        'class_id'   => $request->getPost('class_id'),
        'teacher_id' => $teacherId, // fixed space typo here
    ];

    $id = $request->getPost('quiz_class_id');

    if ($id) {
        // Update
        $success = $model->updateData('quiz_class', ['id' => $id], $data);
    } else {
        // Insert
        $success = $model->store('quiz_class', $data);
    }

    return $this->response->setJSON([
        'status'  => $success ? 'success' : 'error',
        'message' => $success ? 'Quiz class saved successfully!' : 'Failed to save.'
    ]);
}


public function fetch_quiz()
{
    $model = new \App\Models\QuizModel();
    $staffId = session()->get('staff_id');
    $quizzes = $model->fetchQuizWithCreator($staffId);

    $data = [];

    foreach ($quizzes as $quiz) {
        $quiz['actions'] = '
            <button class="btn btn-warning btn-sm editBtn"
                data-id="' . $quiz['quiz_id'] . '"
                data-name="' . htmlspecialchars($quiz['name']) . '"
                data-marks="' . $quiz['total_marks'] . '"
                data-time="' . $quiz['time_limit'] . '"
                data-description="' . htmlspecialchars($quiz['description']) . '"
                data-status="' . $quiz['status'] . '">
                <i class="fas fa-edit"></i>
            </button>
         
        ';

        $data[] = $quiz;
        DD($data);
    }

    return $this->response->setJSON(['data' => $data]);
}

public function delete_class()
{
    $model = new \App\Models\QuizModel();
    $table = 'classes';
    $request = $this->request;

    $id = $request->getPost('class_id');
    if (!$id) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Class ID missing']);
    }

    $success = $model->deleteData($table, ['class_id' => $id]);

    return $this->response->setJSON(['status' => $success ? 'success' : 'error']);
}


public function fetch_clases()
{
    $model = new \App\Models\QuizModel();
    $classes = $model->fetchClassesWithTeachers();

    $data = [];

    foreach ($classes as $row) {
        $data[] = [
            'class_id'     => $row['class_id'],
            'class_name'   => $row['class_name'],
            'teacher_name' => $row['teacher_name'],
            'teacher_id'   => $row['teacher_id'], // Needed for JS to prefill edit

            // Add the HTML action buttons
            'actions' => '
                <button class="btn btn-warning btn-sm editBtn"
                    data-id="' . $row['class_id'] . '"
                    data-name="' . htmlspecialchars($row['class_name']) . '"
                    data-teacher="' . $row['teacher_id'] . '">
                    Edit
                </button>
                <button class="btn btn-danger btn-sm deleteBtn"
                    data-id="' . $row['class_id'] . '">
                    Delete
                </button>
            '
        ];
    }

    return $this->response->setJSON(['data' => $data]);
}

public function save_quiz()
{
    $model = new \App\Models\QuizModel();
    $request = $this->request;
    $staffId = session()->get('staff_id');

    if ($request->getPost('_method') === 'DELETE') {
        $id = $request->getPost('quiz_id');
        $success = $model->deleteData($id,"tbl_quiz");
        return $this->response->setJSON(['status' => $success ? 'success' : 'error']);
    }

    $data = [
        'name'         => $request->getPost('name'),
        'total_marks'  => $request->getPost('total_marks'),
        'time_limit'   => $request->getPost('time_limit'),
        'description'  => $request->getPost('description'),
        'status'       => 'Active',
        'created_by'   => $staffId,
        'created_at'   => date('Y-m-d H:i:s')
    ];

    $id = $request->getPost('quiz_id');

    if ($id) {
        $success = $model->updateData('tbl_quiz', ['quiz_id' => $id], $data);

    } else {
        $success = $model->store('tbl_quiz', $data);
    }

    return $this->response->setJSON([
        'status' => $success ? 'success' : 'error',
        'message' => $success ? 'Quiz saved successfully!' : 'Failed to save quiz.'
    ]);
}

public function save_questions()
{
    $request = $this->request;
    $questions = $request->getPost('questions');

    if (!$questions || !is_array($questions)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No questions were submitted.'
        ]);
    }

    $model = new \App\Models\QuizModel();
    $db = \Config\Database::connect();
    $quiz_id = $request->getPost('quiz_id');

    $db->transStart();

    foreach ($questions as $index => $q) {
        $qNum = $index + 1;

        // Basic validation
        if (empty($q['q_type']) || empty($q['question_text']) || empty($q['marks'])) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Missing required fields in Question #{$qNum}."
            ]);
        }

        // Check if correct answer is selected
        if (!isset($q['correct_answer']) || $q['correct_answer'] === '') {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Please select the correct answer for Question #{$qNum}."
            ]);
        }

        // Prepare and insert question
        $questionData = [
            'quiz_id' => $quiz_id,
            'question_text' => $q['question_text'],
            'marks' => $q['marks'],
            'q_type' => $q['q_type'],
        ];

        $questionId = $model->store('quiz_questions', $questionData);

        if (!$questionId) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Failed to save Question #{$qNum}."
            ]);
        }

        // Save choices based on question type
        if ($q['q_type'] === 'true_false') {
            // Manually save "True" and "False" choices
            foreach (['True', 'False'] as $val) {
                $choiceData = [
                    'quiz_question_id' => $questionId,
                    'choice_text' => $val,
                    'is_correct' => ($val === $q['correct_answer']) ? 1 : 0
                ];
                $model->store('choices', $choiceData);
            }

        } elseif ($q['q_type'] === 'multiple' && isset($q['choices']) && is_array($q['choices'])) {
            foreach ($q['choices'] as $choiceIndex => $choiceText) {
                $choiceData = [
                    'quiz_question_id' => $questionId,
                    'choice_text' => $choiceText,
                    'is_correct' => ($choiceIndex == $q['correct_answer']) ? 1 : 0
                ];
                $choiceId = $model->store('choices', $choiceData);
                if (!$choiceId) {
                    $db->transRollback();
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => "Failed to save choices for Question #{$qNum}."
                    ]);
                }
            }
        } else {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Invalid or missing choices for Question #{$qNum}."
            ]);
        }
    }

    $db->transComplete();

    if ($db->transStatus() === false) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to save questions. Please try again.'
        ]);
    }

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'All questions saved successfully!'
    ]);
}


}