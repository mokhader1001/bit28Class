<?php

namespace App\Controllers;
use App\Models\HomeModel;
use App\Models\QuizModel;


class BIT28Controller extends BaseController
{
    public function index(): string
    {
        return view('BIT28-A/Grad_list');
    }

        public function Students_confirmations(): string
    {
        return view('BIT28-A/Students_List');
    }
    public function update_status()
{
    $id = $this->request->getPost('student_id');
    $status = $this->request->getPost('status');

    $model = new \App\Models\QuizModel();

    $db = \Config\Database::connect();
    $db->table('students')
       ->where('student_id', $id)
       ->update(['status' => $status]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Status updated successfully!'
    ]);
}
public function fetch_students()
{
    $model = new \App\Models\QuizModel();
    $students = $model->get_students();

    $data = [];
    $i = 1;

    foreach ($students as $row) {
        // Prepare photo with zoom
        $photo = '<img src="' . base_url('uploads/' . $row['image_filename']) . '" 
                      class="rounded-circle zoom-photo" 
                      width="50" height="50" 
                      style="cursor:pointer;"
                      data-src="' . base_url('uploads/' . $row['image_filename']) . '">';

        // Prepare status badge
        $statusLabel = '';
        if ($row['status'] == 'accepted') {
            $statusLabel = '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Accepted</span>';
        } elseif ($row['status'] == 'declined') {
            $statusLabel = '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Declined</span>';
        } else {
            $statusLabel = '<span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i> Pending</span>';
        }

        // Build 3-dot dropdown actions
        $actions = '
            <div class="dropdown">
                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">';
        
        if ($row['status'] == 'Pending') {
            $actions .= '
                <li><a class="dropdown-item btn-accept" href="#" data-id="' . $row['student_id'] . '">
                    <i class="fas fa-user-check text-success me-2"></i> Accept
                </a></li>
                <li><a class="dropdown-item btn-decline" href="#" data-id="' . $row['student_id'] . '">
                    <i class="fas fa-user-times text-danger me-2"></i> Decline
                </a></li>';
        } elseif ($row['status'] == 'accepted') {
            $actions .= '
                <li><a class="dropdown-item btn-decline" href="#" data-id="' . $row['student_id'] . '">
                    <i class="fas fa-user-times text-danger me-2"></i> Decline
                </a></li>';
        } elseif ($row['status'] == 'declined') {
            $actions .= '
                <li><a class="dropdown-item btn-accept" href="#" data-id="' . $row['student_id'] . '">
                    <i class="fas fa-user-check text-success me-2"></i> Accept
                </a></li>';
        }

        $actions .= '
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item btn-delete" href="#" data-id="' . $row['student_id'] . '">
                        <i class="fas fa-trash-alt text-danger me-2"></i> Delete
                    </a></li>
                </ul>
            </div>';

        $data[] = [
            $i++,
            htmlspecialchars($row['name']),
            htmlspecialchars($row['message']),
            $photo,
            $statusLabel,
            $actions
        ];
    }

    return $this->response->setJSON(['data' => $data]);
}
public function show_accepted_students()
{
    $model = new \App\Models\QuizModel();
    $data['students'] = $model->get_accepted_students();

    return view('BIT28-A/bit28_accepted_cards', $data);
}


public function delete_student()
{
    $id = $this->request->getPost('student_id');
    $model = new \App\Models\QuizModel();

    // Get student record
    $db = \Config\Database::connect();
    $student = $db->table('students')->where('student_id', $id)->get()->getRow();

    if (!$student) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Student not found.'
        ]);
    }

    // Delete the file
    if (!empty($student->image_filename)) {
        $filePath = FCPATH . 'uploads/' . $student->image_filename;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Delete from DB
    $db->table('students')->where('student_id', $id)->delete();

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Student deleted successfully.'
    ]);
}


public function Bit28_a_save()
    {
       // helper(['form', 'filesystem']);

        $request = service('request');
        $name = $request->getPost('name');
        $message = $request->getPost('message');
        $file = $request->getFile('image');

        $model = new QuizModel();

        // Check if name already exists
        $db = \Config\Database::connect();
        $builder = $db->table('students');
        $builder->where('name', $name);
        $exists = $builder->get()->getRow();

        if ($exists) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This name is already registered!'
            ]);
        }

        // Validate file
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid image file.'
            ]);
        }

        // Prepare folder
        $uploadPath = FCPATH . 'uploads/BIT28-A/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Generate random file name
        $newFileName = $file->getRandomName();
        $file->move($uploadPath, $newFileName);

        // Prepare data for DB
        $data = [
            'name'            => $name,
            'message'         => $message,
            'image_filename'  => 'BIT28-A/' . $newFileName,
            'Status'  => 'Pending',

            //'telephone'       => '' // Add telephone if added later
        ];

        $model->store('students', $data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Registration saved successfully!'
        ]);
    }
}