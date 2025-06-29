<?php

namespace App\Controllers;
use App\Models\HomeModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function lib_staf(): string
    {
        return view('lib_staf');
    }

   


    public function Rules_for_Users(): string
{
    $model = new \App\Models\HomeModel(); // adjust if your model class is named differently
    $data['policy'] = $model->get_library_policy(); // fetch policy details

    return view('Rules_for_Users', $data); // pass to view
}



public function loginLogs()
{
    $home = new \App\Models\HomeModel();
    $data['logs'] = $home->getAllLoginLogs();

    return view('login_logs', $data);
}


    public function return(): string
    {
        return view('books/return_books');
    }


public function Dash(): string
{
    $user_id = session()->get('user_id');
    $model = new \App\Models\HomeModel();

    $data['recentReturns']  = $model->get_last_5_returned_books_with_optional_charges($user_id);
    $data['unpaidCharges']  = $model->get_unpaid_charges_by_user($user_id);
    $data['balanceSummary'] = $model->get_balance_summary_by_user($user_id); // ✅ Add this line

    return view('Dashboard.php', $data);
}


// In PaymentController.php
public function makepayment()
{
    $request = $this->request->getJSON(true); // Get JSON body

    if (!$request || !isset($request['charges']) || !isset($request['payment_method'])) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
    }

    $charges = $request['charges']; // array of { charge_id, amount, title, status }
    $paymentMethod = $request['payment_method'];
    $userId = session()->get('user_id'); // Assumes user_id is stored in session
    $paymentDate = date('Y-m-d H:i:s');

    $paymentModel = new \App\Models\HomeModel();

    $success = true;
    foreach ($charges as $charge) {
        $data = [
            'user_id' => $userId,
            'charge_id' => $charge['charge_id'],
            'price' => $charge['amount'],
            'payment_method' => $paymentMethod,
            'payment_date' => $paymentDate,
            'status'=>'paid'
        ];

        if (!$paymentModel->store("payment",$data)) {
            $success = false;
        }
    }

    if ($success) {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Payment recorded.']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save some records.']);
    }
}


public function payment_report()
{
    $model = new HomeModel();
    $data['payments'] = $model->get_all_payments();

    return view('payments.php', $data); 
}


    
    public function dhash(): string
    {
        return view('User_dhash');
    }
 
    
    public function verfications(): string
    {
        return view('verfications');
    }


    public function rules(): string
    {
        $model = new HomeModel();
        $policy = $model->getLibraryPolicy();
    
        return view('rules', ['policy' => $policy]);
    }
    

public function user_log(): string
{
    return view('user_log');
}

public function profile(): string
{
    return view('view_profile');
}

    public function body(): string
{
    $model = new \App\Models\HomeModel();

    $data = [
        'last_users'     => $model->getLastRegisteredUsers(),

        'total_books'   => $model->countBooks(),
        'total_users'   => $model->countLibraryUsers(),
        'total_authors' => $model->countAuthors(),
    ];

    return view('body', $data);
}

    public function Authors(): string
    {
        return view('books/Authors');
    }
    public function books(): string
    {
        $model = new HomeModel();
    
        $data['authors'] = $model->get_authors();
    
        return view('books/books.php', $data);
    }
    


    public function lib(): string
    {
        return view('lib_user');
    }



    
    public function cancel_charge(): string
    {
        return view('cancel_charge');
    }


    public function delete_damage_charge()
{
    $request = $this->request;
    $charge_id = $request->getPost('charge_id');

    if (!$charge_id) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Missing charge ID.'
        ]);
    }

    $model = new \App\Models\HomeModel();
    $deleted = $model->deleteChargeById($charge_id);

    if ($deleted) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Damage charge deleted successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to delete damage charge.'
        ]);
    }
}




    public function fetch_damage_charges()
{
    $model = new \App\Models\HomeModel();
    $charges = $model->getDamageCharges();

    $data = [];
    $i = 1;

    foreach ($charges as $row) {
        $photoTag = $row->photo 
            ? "<a href='" . base_url('public/uploads/damage_photos/' . $row->photo) . "' target='_blank'>
                    <img src='" . base_url('public/uploads/damage_photos/' . $row->photo) . "' width='40' height='40'>
               </a>"
            : 'No Photo';

        $data[] = [
            $i++,
            esc($row->title),
            esc($row->Name),
            esc($row->username) . " <small class='text-muted'>(" . esc($row->card_tag) . ")</small>",
            esc($row->charge_type),
            '$' . number_format($row->price, 2),
            esc($row->desriptions),
            date('d M Y', strtotime($row->charge_date)),
            $photoTag,
            '<button class="btn btn-danger btn-sm btn-cancel" data-id="' . $row->charge_id . '"><i class="fas fa-times-circle"></i> Cancel</button>'
        ];
    }

    return $this->response->setJSON(['data' => $data]);
}


    
    public function viewDamage(): string
    {
        return view('Books/damageBook');
    }

public function saveBorrow()
{
    $request = $this->request->getPost();
    $lib_user_id = $request['lib_user_id'] ?? null;
    $book_id     = $request['book_id'] ?? null;
    $borrow_date = $request['borrow_date'] ?? null;
    $return_date = $request['return_date'] ?? null;

    if (!$lib_user_id || !$book_id || !$borrow_date || !$return_date) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Missing required fields.'
        ]);
    }

    $user = session()->get('user_id');
    $username = session()->get('username');
    $email = session()->get('email');

    $borrowModel = new \App\Models\HomeModel();

    // 🔒 Check if this book was borrowed and not returned
   $check_unn_returned = $borrowModel->get_unreturned_book($user, $book_id);

if (!empty($check_unn_returned)) {
    $bookName = htmlspecialchars($check_unn_returned[0]['title']);
    return $this->response->setJSON([
        'success' => false,
        'message' => "You have already borrowed \"$bookName\" and haven't returned it yet. Please return it before borrowing again."
    ]);
}


    // 🔢 Check if user reached limit
    $borrowCount = $borrowModel->check_borrowed_rules($user);
    $max = $borrowModel->Max_book_allowed();
if ($borrowCount && $borrowCount['borrowed_count'] >= $max){
        return $this->response->setJSON([
            'success' => false,
            'message' => "You have reached the borrowing limit of {$max} books. Please return a book first."
        ]);
    }

    $bookDetails = $borrowModel->get_book_details($book_id);

    // 📦 Store borrow
    $data = [
        'lib_user_id' => $user,
        'book_id'     => $book_id,
        'borrow_date' => $borrow_date,
        'return_date' => $return_date,
    ];

    if ($borrowModel->store("borrow", $data)) {
        $borrowModel->decrement_book_quantity($book_id);

        // 📧 Send Email
        $emailService = \Config\Services::email();
        $emailService->setFrom('mohamedyuusuf851@gmail.com', 'Miftaax Library');
        $emailService->setTo($email);
        $emailService->setSubject('📚 Book Borrowed Successfully - Miftaax Library');

        $bookTitle = $bookDetails['title'] ?? 'Unknown Book';
        $author = $bookDetails['Name'] ?? 'Unknown Author';

        $emailService->setMessage("
        <html>
        <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
            <div style='max-width:600px;margin:auto;background:white;padding:30px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.05);'>
                <h2 style='color:#0056b3;text-align:center;'>📚 Book Borrowed Successfully</h2>
                <p>Dear <strong>$username</strong>,</p>
                <p>You have successfully borrowed the following book:</p>
                <ul>
                    <li><strong>Book Title:</strong> $bookTitle</li>
                    <li><strong>Author:</strong> $author</li>
                    <li><strong>Borrowed On:</strong> $borrow_date</li>
                    <li><strong>Return By:</strong> $return_date</li>
                </ul>
                <p><strong>📌 Please Note:</strong></p>
                <ul>
                    <li>Return the book by the due date to avoid late fees.</li>
                    <li>If the book is lost or damaged, a fee will be applied according to library policy.</li>
                </ul>
                <hr>
                <p><strong>📍 Library Address:</strong> Taleh, Mogadishu, Somalia</p>
                <p><strong>📞 Contact:</strong> 061 7937851</p>
                <p><strong>🌐 Support:</strong> <a href='https://miftah.support.so'>miftah.support.so</a></p>
                <hr>
                <p style='text-align:center;color:#888;'>Thank you for using Miftaax Library</p>
            </div>
        </body>
        </html>");

        $emailService->setMailType('html');
        $emailService->send();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Book borrowed successfully. A confirmation email has been sent.'
        ]);
    }

    return $this->response->setJSON([
        'success' => false,
        'message' => 'Failed to borrow the book. Please try again.'
    ]);
}

public function evaluate()
{
    $request = $this->request;

    $book_id     = $request->getPost('book_id');
    $borrow_id   = $request->getPost('borrow_id');
    $user_id     = $request->getPost('eval_card_tag'); 

    $damage_type = $request->getPost('damage_type');
    $charge      = $request->getPost('charge');
    $photo       = $request->getFile('photo');

    if (!$book_id || !$borrow_id || !$damage_type || !$charge || !$user_id) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'All fields are required.'
        ]);
    }

    if ($charge < 1) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Charge must be at least $1.'
        ]);
    }

    $model = new HomeModel();
    $book = $model->get_book_details($book_id);

    if (!$book) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Book not found.'
        ]);
    }

    // Upload photo if provided
    $photoName = null;
    if ($photo && $photo->isValid() && !$photo->hasMoved()) {
        $photoName = $photo->getRandomName();
        $photo->move('public/uploads/damage_photos/', $photoName);
    }

    // Save to charge table
    $chargeSaved = $model->store('charge', [
        'boorow_id'    => $borrow_id,
        'book_id'      => $book_id,
        'user_id'      => $user_id,
        'charge_type'  => 'Damage',
        'price'        => $charge,
        'desriptions'  => 'Damage Type: ' . $damage_type,
        'charge_date'  => date('Y-m-d H:i:s'),
        'photo'        => $photoName
    ]);

    if ($chargeSaved) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Damage charge evaluated successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to save charge.'
        ]);
    }
}


    


    public function save()
    {
            $data = [
                'id'           => $this->request->getPost('id'),

                'max_books'           => $this->request->getPost('max_books'),
                'penalty_per_day'     => $this->request->getPost('penalty_per_day'),
                'suspend_after_days'  => $this->request->getPost('suspend_after_days'),
                'minor_damage_fee'    => $this->request->getPost('minor_damage_fee'),
                'major_damage_fee'    => $this->request->getPost('major_damage_fee'),
                'lost_book_fee'       => $this->request->getPost('lost_book_fee'),
                'delete_account_after_days'   => $this->request->getPost('delete_after_days'),
                'borrowing_note'         => $this->request->getPost('borrow_note'),
                'late_note'           => $this->request->getPost('late_note'),
                'damage_note'         => $this->request->getPost('damage_note'),
                'max_days_allowed'         => $this->request->getPost('max_books_per_day'),
                'min_books_reserved'         => $this->request->getPost('min_books_reserved')

            ];

            $model = new HomeModel();
            $model->update_rules( $data); 
            

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Library policy saved successfully.'
            ]);
        

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request type.'
        ]);
    }
    


    public function save_staff()
    {
        $model = new HomeModel();
        $response = ['success' => false];
    
        $id = $this->request->getPost('staff_id');
        $actionType = $this->request->getPost('action_type');
        $user = session()->get('user_id'); // who registered
    
        // Delete
        if ($actionType === 'delete' && $id) {
            $deleted = $model->delete_staff($id);
            return $this->response->setJSON([
                'success' => $deleted,
                'message' => $deleted ? 'Staff deleted successfully.' : 'Failed to delete staff.'
            ]);
        }
    
        // Status toggle
        if ($actionType === 'toggle_status' && $id) {
            $status = $this->request->getPost('status');
            $updated = $model->update_Staff_Status($id, $status);
            return $this->response->setJSON([
                'success' => $updated,
                'message' => $updated ? "Staff status changed to $status." : 'Failed to update status.'
            ]);
        }
    
        // Input values
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $gender = $this->request->getPost('gender');
        $role = $this->request->getPost('role');
        $password = $this->request->getPost('password');
        $address = $this->request->getPost('address');
    
        // Image upload
        $image = $this->request->getFile('image');
        $imageName = '';
    
        if (!empty($id)) {
            $existing = $model->get_staff_image($id);
            $imageName = $existing ? $existing['image'] : '';
    
            if ($image && $image->isValid() && !$image->hasMoved()) {
                $imageName = $image->getRandomName();
                $image->move(ROOTPATH . 'public/uploads/staff/', $imageName);
            }
        } else {
            if ($image && $image->isValid() && !$image->hasMoved()) {
                $imageName = $image->getRandomName();
                $image->move(ROOTPATH . 'public/uploads/staff/', $imageName);
            }
        }
    
        $data = [
            'username'    => $username,
            'email'       => $email,
            'phone'       => $phone,
            'gender'      => $gender,
            'role'        => $role,
            'password'    => $password,
            'address'     => $address,
            'image'       => $imageName,
            'status'      => 'Active',
            'reg_date'    => date('Y-m-d'),
        ];
    
        if (!empty($id)) {
            $data['staff_id'] = $id;
            $updated = $model->update_staff($data);   // ✅ correct

            $response['success'] = $updated;
            $response['message'] = $updated ? 'Staff updated successfully.' : 'Failed to update staff.';
        } else {
            $inserted = $model->store("tbl_staff", $data);
            $response['success'] = $inserted;
            $response['message'] = $inserted ? 'Staff added successfully.' : 'Failed to insert staff.';
        }
    
        return $this->response->setJSON($response);
    }
    

  public function get_damaged_books_pending_charge()
    {
        $model = new HomeModel();
        $damagedBooks = $model->get_damaged_books_pending_charge();

        $result = ['data' => []];
        $i = 1;

        foreach ($damagedBooks as $book) {
            $photo = $book['photo']
                ? $book['photo']
                : null;

            $result['data'][] = [
                'index'    => $i++,
                'photo'    => $photo,
                'title'    => htmlspecialchars($book['title']),
                'author'   => htmlspecialchars($book['author']),
                'username' => htmlspecialchars($book['username']),
                'card_tag' => $book['card_tag'],
                'price'    => $book['price'],
                'status'   => $book['status'],
                'book_id'  => $book['book_id'],
                'borrow_id' => $book['borrow_id'],
                'actions'  => '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-primary btn-eval-damage"
                                data-book_id="' . $book['book_id'] . '"
                                data-borrow_id="' . $book['borrow_id'] . '"
                                data-title="' . htmlspecialchars($book['title']) . '"
                                data-card_tag="' . $book['card_tag'] . '"
                                data-username="' . $book['username'] . '"
                                data-photo="' . $photo . '"
                                data-price="' . $book['price'] . '">
                                <i class="fas fa-check me-1"></i> Evaluate
                            </a>
                        </div>
                    </div>'
            ];
        }

        return $this->response->setJSON($result);
    }






    public function fetch_staff()
    {
        $model = new HomeModel();
        $staffList = $model->get_libaray_staff();
    
        $result = ['data' => []];
        $i = 1;
    
        foreach ($staffList as $staff) {
            $photo = $staff['image']
                ? '<img src="' . base_url('public/uploads/staff/' . $staff['image']) . '" width="40" height="40" class="rounded-circle">'
                : '<span class="text-muted">No Image</span>';
    
            $statusToggle = $staff['status'] === 'Active'
                ? '<a class="dropdown-item text-warning btn-status-toggle" data-staff_id="' . $staff['staff_id'] . '" data-status="Inactive">
                        <i class="fas fa-ban me-1"></i> Deactivate
                   </a>'
                : '<a class="dropdown-item text-success btn-status-toggle" data-staff_id="' . $staff['staff_id'] . '" data-status="Active">
                        <i class="fas fa-check-circle me-1"></i> Activate
                   </a>';
    
            $actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary btn-edit-staff"
                            data-staff_id="' . $staff['staff_id'] . '"
                            data-username="' . htmlspecialchars($staff['username']) . '"
                            data-password="' . htmlspecialchars($staff['password']) . '"
                            data-gender="' . $staff['gender'] . '"
                            data-phone="' . $staff['phone'] . '"
                            data-email="' . $staff['email'] . '"
                            data-address="' . $staff['address'] . '"
                            data-role="' . $staff['role'] . '"
                            data-image="' . $staff['image'] . '"
                            data-status="' . $staff['status'] . '"
                            data-bs-toggle="modal" data-bs-target="#staffModal">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a class="dropdown-item text-danger btn-delete-staff"
                            data-staff_id="' . $staff['staff_id'] . '"
                            data-username="' . htmlspecialchars($staff['username']) . '">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>'
                        . $statusToggle .
                    '</div>
                </div>';
    
            $result['data'][] = [
                $i++,
                $staff['username'],
                $staff['email'],
                $staff['phone'],
                ucfirst($staff['gender']),
                $staff['role'],
                $photo,
                $staff['status'],
                $actions
            ];
        }
    
        return $this->response->setJSON($result);
    }
    

    public function author_form()
{
    $model = new HomeModel();
    $response = ['success' => false];
    $id = $this->request->getVar('author_id');
    $actionType = $this->request->getVar('action_type');

    // DELETE
    if ($actionType === 'delete' && $id) {
        $data = [
            'author_id'    => $id,
            'name'         => $this->request->getVar('name'),
            'descriptions' => $this->request->getVar('descriptions'),
        ];        
        if ($model->delete_batch()) {
            $response['success'] = true;
            $response['data'] = $data;
            $response['message'] = 'Author deleted successfully.';
        } else {
            $response['data'] = $data;
            $response['message'] = 'Failed to delete author.';
        }
        return $this->response->setJSON($response);
    }

    // COMMON DATA
    $data = [
        'author_id'    => $id,
        'name'         => $this->request->getVar('name'),
        'descriptions' => $this->request->getVar('descriptions'),
    ];

    // UPDATE
    if (!empty($id)) {
        if ($model->update_auth($data)) {
            $response['success'] = true;
            $response['data'] = $data;
            $response['message'] = 'Author updated successfully.';
        } else {
            $response['data'] = $data;
            $response['message'] = 'Failed to update author.';
        }
    }
    // INSERT
    else {
        unset($data['author_id']); // remove ID for insert
        if ($model->store('authors', $data)) {
            $response['success'] = true;
            $response['data'] = $data;
            $response['message'] = 'Author added successfully.';
        } else {
            $response['data'] = $data;
            $response['message'] = 'Failed to insert author.';
        }
    }

    return $this->response->setJSON($response);
}




public function save_lib()
{
    $model = new HomeModel();
    $response = ['success' => false];

    $id = $this->request->getVar('user_id');
    $actionType = $this->request->getVar('action_type');
    $user = session()->get('staff_id');

    if ($actionType === 'toggle_status' && $id) {
        $status = $this->request->getVar('status');
        $update = $model->update_Status($id, $status);

        return $this->response->setJSON([
            'success' => $update ? true : false,
            'message' => $update ? "User status updated to $status." : 'Failed to update status.'
        ]);
    }

    if ($actionType === 'delete' && $id) {
        $del = $model->delete_lib_user($id);
        return $this->response->setJSON([
            'success' => $del ? true : false,
            'message' => $del ? 'User deleted successfully.' : 'Failed to delete user.'
        ]);
    }

    // Get inputs
    $email = $this->request->getVar('email');
    $card_tag = $this->request->getVar('card_tag');
    $username = $this->request->getVar('username');
    $dob = $this->request->getVar('dob');

    // Age validation
    $age = date_diff(date_create($dob), date_create('today'))->y;
    if ($age < 18) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'You cannot register. Minimum age is 18 years.'
        ]);
    }

    // Duplicate email check
    $emailCheck = $model->checkDuplicateEmail($email, $id);
    if ($emailCheck) {
        return $this->response->setJSON([
            'success' => false,
            'message' => "The email already belongs to another user."
        ]);
    }

    // Duplicate card_tag check
    $cardCheck = $model->checkDuplicateCardTag($card_tag, $id);
    if ($cardCheck) {
        return $this->response->setJSON([
            'success' => false,
            'message' => "This card is already assigned to " . $cardCheck['username'] . "."
        ]);
    }

    // Handle image
    $image = $this->request->getFile('image');
    $imageName = '';

    if (!empty($id)) {
        $existing = $model->existing($id);
        $imageName = $existing ? $existing['image'] : '';
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/library_users/', $imageName);
        }
    } else {
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/library_users/', $imageName);
        }
    }

    $data = [
        'username'      => $username,
        'email'         => $email,
        'phone_number'  => $this->request->getVar('phone_number'),
        'gender'        => $this->request->getVar('gender'),
        'occupation'    => $this->request->getVar('occupation'),
        'dob'           => $dob,
        'card_tag'      => $card_tag,
        'image'         => $imageName,
        'status'        => 'Active',
        'registered_by' => $user,
        'register_date' => date('Y-m-d')
    ];

    if (!empty($id)) {
        $data['lib_user_id'] = $id;
        if ($model->update_lib_user([$data])) {
            $response['success'] = true;
            $response['message'] = 'User updated successfully.';
        } else {
            $response['message'] = 'Failed to update user.';
        }
    } else {
        if ($model->store("tbl_library_users", $data)) {
            $emailService = \Config\Services::email();
$emailService->setFrom('mohamedyuusuf851@gmail.com', 'Miftaax Library');
$emailService->setTo($email);
$emailService->setSubject('📚 Welcome to Miftaax Library');

// HTML message with styling, icons, and support info
$emailService->setMessage("
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
</head>
<body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
  <div style='max-width:600px;margin:auto;background:white;padding:30px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.05);'>
    <h2 style='color:#0056b3;text-align:center;'>📚 Welcome to Miftaax Library</h2>
    <p>Dear <strong>$username</strong>,</p>

    <p>You have been successfully registered to <strong>Miftaax Library</strong>. You are now eligible to borrow books based on the library rules.</p>

    <p><strong>🔒 Note:</strong> Every time you borrow a book, a verification code will be sent to your Gmail. <br>
    Please <u>do not share</u> your Gmail or code with anyone.</p>

    <hr style='margin: 20px 0;'>

    <p><strong>📍 Address:</strong> Taleh, Mogadishu, Somalia</p>
    <p><strong>📞 Phone:</strong> <a href='tel:+252617937851'>061 7937851</a></p>
    <p><strong>🛠 Support:</strong> <a href='https://miftah.support.so'>miftah.support.so</a></p>

    <hr style='margin: 20px 0;'>
    <p style='text-align:center;color:#888;'>Thank you for joining us – Miftaax Library Team</p>
  </div>
</body>
</html>
");

$emailService->setMailType('html');
$emailService->send();

            $response['success'] = true;
            $response['message'] = 'User added successfully.';
        } else {
            $response['message'] = 'Failed to insert user.';
        }
    }

    return $this->response->setJSON($response);
}

public function save_book()
{
    $model = new HomeModel();
    $response = ['success' => false];

    $id = $this->request->getPost('book_id');
    $actionType = $this->request->getPost('action_type');
    $user = session()->get('staff_id');

    // DELETE
    if ($actionType === 'delete' && $id) {
        $deleted = $model->delete_book($id);
        return $this->response->setJSON([
            'success' => $deleted,
            'message' => $deleted ? 'Book deleted successfully.' : 'Failed to delete book.'
        ]);
    }

    // Inputs
    $title          = trim($this->request->getPost('title'));
    $author_id      = $this->request->getPost('author_id');
    $isbn           = trim($this->request->getPost('isbn'));
    $rfid_tag       = trim($this->request->getPost('rfid_tag'));
    $quantity       = $this->request->getPost('quantity');
    $published_year = trim($this->request->getPost('published_year'));
    $price          = trim($this->request->getPost('price'));

    // Required field checks
    if (empty($isbn) || empty($rfid_tag)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Every book must have an ISBN and RFID tag.'
        ]);
    }

    if (empty($price)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Please enter the book price.'
        ]);
    }

    // Year check
    if ((int)$published_year > (int)date('Y')) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Published year cannot be in the future.'
        ]);
    }

    // Only check duplicates when inserting
    if (empty($id)) {
        // RFID Tag check
        $rfidCheck = $model->checkDuplicateRFID($rfid_tag, null);
        if ($rfidCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "This RFID tag is already assigned to the book titled: " . $rfidCheck['title']
            ]);
        }

        // Duplicate Book Title + ISBN + Year check
        $dupBook = $model->checkDuplicateBook($title, $isbn, $published_year, null);
        if ($dupBook) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "The book titled \"$title\" with ISBN \"$isbn\" and year \"$published_year\" is already registered."
            ]);
        }

        // ISBN check
        $isbnCheck = $model->checkDuplicateISBN($isbn, null);
        if ($isbnCheck) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "The ISBN \"$isbn\" is already used by the book titled: " . $isbnCheck['title']
            ]);
        }
    }

    // Handle image
    $image = $this->request->getFile('photo');
    $photoName = '';

    if (!empty($id)) {
        $existing = $model->getBookImageById($id);
        $photoName = $existing ? $existing['photo'] : '';

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $photoName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/books/', $photoName);
        }
    } else {
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $photoName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/books/', $photoName);
        }
    }

    $data = [
        'title'          => $title,
        'author_id'      => $author_id,
        'isbn'           => $isbn,
        'rfid_tag'       => $rfid_tag,
        'quantity'       => $quantity,
        'published_year' => $published_year,
        'price'          => $price,
        'photo'          => $photoName,
        'added_by'       => $user,
        'added_date'     => date('Y-m-d')
    ];

    // Save
    if (!empty($id)) {
        $data['book_id'] = $id;
        $updated = $model->update_book([$data]);
        $response['success'] = true;
        $response['message'] = $updated ? 'Book updated successfully.' : 'Failed to update book.';
    } else {
        $inserted = $model->insert_book($data);
        $response['success'] = $inserted;
        $response['message'] = $inserted ? 'Book added successfully.' : 'Failed to insert book.';
    }

    return $this->response->setJSON($response);
}



public function sendVerificationCode()
{
    $session = session();
    $model = new HomeModel();

    $email = $session->get('email');

    if (!$email) {
        return $this->response->setJSON(['success' => false, 'message' => 'No email in session']);
    }

    // Get user by email
    $user = $model->get_users($email);

    if (empty($user)) {
        return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
    }

    $userData = $user[0];

    // ✅ Set specific session variables
    $session->set('lib_user_id', $userData['lib_user_id']);
    $session->set('username', $userData['username']);
    $session->set('email', $userData['email']);
    $session->set('card_tag', $userData['card_tag']);
    $session->set('image', $userData['image']);

    // Set verification code
    $code = rand(100000, 999999);
    $session->set('verification_code', $code);

    // Send email
    $emailService = \Config\Services::email();
    $emailService->setTo($email);
    $emailService->setSubject('Your Library Verification Code');
    $emailService->setMessage("
        <h3>Your Verification Code</h3>
        <p>Dear {$userData['username']},</p>
        <p>Your 6-digit verification code is: <strong style='font-size:18px;'>$code</strong></p>
        <p>Please enter this code to access your library dashboard.</p>
        <br><small>Miftaah College Library</small>
    ");

    if ($emailService->send()) {
        return $this->response->setJSON(['success' => true, 'redirect' => base_url('user/verifications')]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => $emailService->printDebugger(['headers'])
        ]);
    }
}





public function verifyCode()
{
    $inputCode = $this->request->getPost('code');
    $sessionCode = session()->get('verification_code');

    if ((string)$inputCode == (string)$sessionCode) {
        return $this->response->setJSON(['success' => true]);
    }

    return $this->response->setJSON(['success' => false, 'message' => 'Invalid verification code']);
}

public function showAvailableBooks()
{
    $bookModel = new HomeModel(); 
    $data['books'] = $bookModel->fetch_books_for_user();

    $policy = $bookModel->max_days_allowed();
    
    // Extract the actual number
    $data['max_days'] = !empty($policy) ? $policy['max_days_allowed'] : 7;

    return view('books/boorow_book', $data); // Also fixed typo: boorow -> borrow
}



public function checkCardId()
    {
        $card_id = $this->request->getPost('card_number');

        $model = new HomeModel();
        $user = $model->get_libaray_user_id($card_id);

        if ($user) {
            session()->set([
                'user_id'   => $card_id,
                'lib_user_id'   => 'lib_user_id',
                'username'  => $user['username'],
                'email'     => $user['email'],
                'image'     => $user['image'],
                'verified'  => false
            ]);
            return $this->response->setJSON(['success' => true, 'redirect' => base_url('user/verification')]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found. Please scan a valid card.']);
        }
    }


    public function showUnreturnedBooks()
{
    $session = session();
    $cardTag = $session->get('user_id');

    if (!$cardTag) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'User card tag not found in session.'
        ]);
    }

    $model = new \App\Models\HomeModel(); // Change to your actual model name if different

    $books = $model->get_unreturned_books_by_card($cardTag);

    if (!empty($books)) {
        return $this->response->setJSON([
            'status' => true,
            'data' => $books
        ]);
    } else {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'No unreturned books found.'
        ]);
    }
}



public function fetch_Authors()
{
    $author = new HomeModel();
    $result = ['data' => []];

    $data = $author->getAuthors();

    $i = 1;
    foreach ($data as $key => $value) {
        $set = [
            'id' => $value["author_id"],
            'rec_title' => $value["name"],
            'rec_tbl' => 'authors',
            'rec_id_col' => 'author_id',
        ];

        $buttons = '
        <div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">

                    <a type="button" id="btn_det"
                        data-author_id="' . $set["id"] . '"
                        data-name="' . htmlspecialchars($value["name"]) . '"
                        data-description="' . htmlspecialchars($value["descriptions"]) . '"
                        data-bs-toggle="modal" data-bs-target="#addAuthorModal"
                        class="dropdown-item">
                        <i class="fas fa-info-circle text-info mx-1"></i> Details
                    </a>

                    <a type="button" id="btn_edit"
                        data-author_id="' . $set["id"] . '"
                        data-name="' . htmlspecialchars($value["name"]) . '"
                        data-description="' . htmlspecialchars($value["descriptions"]) . '"
                        data-bs-toggle="modal" data-bs-target="#addAuthorModal"
                        class="dropdown-item">
                        <i class="fas fa-pencil-alt text-warning mx-1"></i> Edit
                    </a>

                    <a type="button" id="btn_delete"
                        data-author_id="' . $set["id"] . '"
                        data-name="' . htmlspecialchars($value["name"]) . '"
                        data-description="' . htmlspecialchars($value["descriptions"]) . '"
                        class="dropdown-item text-danger">
                        <i class="fas fa-trash-alt mx-1"></i> Delete
                    </a>

                </div>
            </div>
        </div>
        ';

        $result['data'][$key] = [
            $i,
            htmlspecialchars($value["name"]),
            htmlspecialchars($value["descriptions"]),
            $buttons
        ];
        $i++;
    }

    return $this->response->setJSON($result);
}

public function fetch_lib_users()
{
    $model = new HomeModel();
    $result = ['data' => []];
    $users = $model->getLibraryUsers(); // This method should return all required fields including lib_user_id

    $i = 1;
    foreach ($users as $user) {
        $imageTag = '<a href="' . base_url('public/uploads/library_users/' . $user['image']) . '" target="_blank">
                        <img src="' . base_url('public/uploads/library_users/' . $user['image']) . '" width="40" height="40" class="rounded-circle">
                     </a>';

        $statusToggle = $user['status'] === 'active'
            ? '<a class="dropdown-item text-warning btn-status-toggle" data-user_id="' . $user['lib_user_id'] . '" data-status="Inactive">
                    <i class="fas fa-ban me-1"></i> Deactivate
               </a>'
            : '<a class="dropdown-item text-success btn-status-toggle" data-user_id="' . $user['lib_user_id'] . '" data-status="Active">
                    <i class="fas fa-check-circle me-1"></i> Activate
               </a>';

        $buttons = '
            <div class="dropdown">
                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-primary" id="btn_edit"
                        data-user_id="' . $user['lib_user_id'] . '"
                        data-username="' . htmlspecialchars($user['username']) . '"
                        data-email="' . htmlspecialchars($user['email']) . '"
                        data-phone_number="' . htmlspecialchars($user['phone_number']) . '"
                        data-gender="' . $user['gender'] . '"
                        data-occupation="' . htmlspecialchars($user['occupation']) . '"
                        data-dob="' . $user['dob'] . '"
                        data-card_tag="' . $user['card_tag'] . '"
                        data-image="' . $user['image'] . '"
                        data-bs-toggle="modal" data-bs-target="#userModal">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a class="dropdown-item text-danger" id="btn_delete"
                        data-user_id="' . $user['lib_user_id'] . '"
                        data-username="' . htmlspecialchars($user['username']) . '">
                        <i class="fas fa-trash-alt me-1"></i> Delete
                    </a>'
                    . $statusToggle .
                '</div>
            </div>';

        $result['data'][] = [
            $i++,
            $user['username'],
            $user['email'],
            $user['phone_number'],
            $user['gender'],
            $user['card_tag'],
            $imageTag,
            $user['status'],
            $buttons
        ];
    }

    return $this->response->setJSON($result);
}
public function fetch_books()
{
    $model = new HomeModel();
    $books = $model->fetch_books(); // Your existing function
    $result = ['data' => []];
    $i = 1;

    foreach ($books as $book) {
        $photoTag = $book['photo']
    ? '<a href="' . base_url('public/uploads/books/' . $book['photo']) . '" target="_blank">
         <img src="' . base_url('public/uploads/books/' . $book['photo']) . '" width="40" height="40" class="rounded-circle">
       </a>'
    : '';


        $actions = '
            <div class="dropdown">
                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-primary btn-edit-book"
                        data-book_id="' . $book['book_id'] . '"
                        data-title="' . htmlspecialchars($book['title']) . '"
                        data-author_id="' . $book['author_id'] . '"
                        data-isbn="' . $book['isbn'] . '"
                        data-rfid_tag="' . $book['rfid_tag'] . '"
                        data-quantity="' . $book['quantity'] . '"
                        data-published_year="' . $book['published_year'] . '"
                        data-photo="' . $book['photo'] . '"
                         data-price="' . $book['price'] . '"

                    >
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a class="dropdown-item text-danger btn-delete-book"
                        data-book_id="' . $book['book_id'] . '"
                        data-title="' . htmlspecialchars($book['title']) . '"
                    >
                        <i class="fas fa-trash me-1"></i> Delete
                    </a>
                </div>
            </div>
        ';

        $result['data'][] = [
            $i++,
            $book['title'],
            $book['Name'],
            $book['isbn'],
            $book['rfid_tag'],
            $book['quantity'],
            $book['published_year'],
            $book['price'],

            $photoTag,
            $book['added_date'],
            $actions
        ];
    }

    return $this->response->setJSON($result);
}


public function fetch_borrow_booka()
{
    $user = session()->get('user_id');
    $model = new \App\Models\HomeModel();
    $books = $model->get_borrow_books($user);

    if (!empty($books)) {
        return $this->response->setJSON([
            'status' => true,
            'data' => $books
        ]);
    } else {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'No data found'
        ]);
    }
}



public function returnbooks()
{
    $session = session();
    $user = $session->get('user_id');

    $model = new \App\Models\HomeModel();
    $request = $this->request->getPost();

    if (!isset($request['book_id'], $request['boorow_id'], $request['returned_date'], $request['status'])) {
        return $this->response->setJSON(['status' => false, 'message' => 'Missing required fields']);
    }

    $book_id = $request['book_id'];
    $boorow_id = $request['boorow_id'];
    $returned_date = $request['returned_date'];
    $status = strtolower(trim($request['status']));

    $book = $model->get_book_details($book_id);
    $return_record = $model->get_return_date($book_id, $user);
    $penalty_row = $model->get_penalty_per_day();
    $book_price = $model->book_price($book_id);

    $penalty_per_day = $penalty_row['penalty_per_day'] ?? 0;
    $due_date = $return_record['return_date'] ?? date('Y-m-d');

    $data = [
        'book_id'      => $book_id,
        'boorow_id'    => $boorow_id,
        'retuned_date' => $returned_date,
        'status'       => ucfirst($status)
    ];

    $inserted = $model->store('returend_books', $data);

    if ($inserted) {
        $model->increment_book_quantity($book_id);

        $delay_days = max(0, floor((strtotime($returned_date) - strtotime($due_date)) / 86400));
        $charges = [];
        $total_charge = 0;

        // Late return charge
        if ($delay_days > 0) {
            $late_fee = $delay_days * $penalty_per_day;
            $charges[] = [
                'charge_type' => 'Late Return',
                'price'       => $late_fee,
                'desriptions' => "Book '{$book['title']}' was returned {$delay_days} days late. Charged \${$late_fee} as late return fee according to library policy."
            ];
            $total_charge += $late_fee;
        }

        // Lost book charge
        if ($status === 'lost') {
            $lost_fee = $book_price['price'];
            $charges[] = [
                'charge_type' => 'Lost Book',
                'price'       => $lost_fee,
                'desriptions' => "Book '{$book['title']}' was reported as lost. Charged full price of \${$lost_fee}."
            ];
            $total_charge += $lost_fee;
        }

        // Damaged book: only charge if late
        if ($status === 'damaged' && $delay_days > 0) {
            // Already added late fee above; we just send the right message
        }

        // Save charges
        foreach ($charges as $c) {
            $model->store('charge', [
                'boorow_id'   => $boorow_id,
                'book_id'     => $book_id,
                'user_id'     => $user,
                'charge_type' => $c['charge_type'],
                'price'       => $c['price'],
                'desriptions' => $c['desriptions']
            ]);
        }

        // Email Setup
        $emailService = \Config\Services::email();
        $emailService->setFrom('mohamedyuusuf851@gmail.com', 'Miftaax Library');
        $emailService->setTo($session->get('email'));
        $emailService->setSubject('📚 Book Return Confirmation');

        $title = $book['title'];
        $username = $session->get('username');
        $statusMessage = "";

        // Detailed status message logic
        if ($status === 'returned') {
            if ($delay_days > 0) {
                $late_fee = $delay_days * $penalty_per_day;
                $statusMessage = "
                    Dear <strong>{$username}</strong>,<br><br>
                    You have returned the book titled <strong>{$title}</strong>, but not on the expected date. 
                    As per the library policy, a late fee has been applied.<br>
                    <strong>Overdue:</strong> {$delay_days} days<br>
                    <strong>Late Fee:</strong> \${$late_fee}<br><br>
                    Please check your profile for full payment details.";
            } else {
                $statusMessage = "
                    Dear <strong>{$username}</strong>,<br><br>
                    You have successfully returned the book titled <strong>{$title}</strong> on time. 
                    Thank you for following the library rules!";
            }
        } elseif ($status === 'lost') {
            if ($delay_days > 0) {
                $statusMessage = "
                    Dear <strong>{$username}</strong>,<br><br>
                    You reported the book titled <strong>{$title}</strong> as lost, and it was also overdue by <strong>{$delay_days} days</strong>.<br>
                    In accordance with the library policy, you have been charged for both the book value and the late return fee.<br><br>
                    Please check your profile for full details of the charges.";
            } else {
                $statusMessage = "
                    Dear <strong>{$username}</strong>,<br><br>
                    You reported the book titled <strong>{$title}</strong> as lost. 
                    As per our library policy, the book's full price has been charged to your account.<br><br>
                    Thank you for your cooperation.";
            }
        } elseif ($status === 'damaged') {
            if ($delay_days > 0) {
                $late_fee = $delay_days * $penalty_per_day;
                $statusMessage = "
                    Dear <strong>{$username}</strong>,<br><br>
                    You returned the book titled <strong>{$title}</strong> late by <strong>{$delay_days} days</strong>. 
                    A late fee of \${$late_fee} has been applied.<br>
                    Additionally, the book was marked as <strong>damaged</strong>. 
                    The condition will be reviewed by the library administrator, and further action may be taken.";
            } else {
                $statusMessage = "
                    Dear <strong>{$username}</strong>,<br><br>
                    You returned the book titled <strong>{$title}</strong> on time, but it was marked as <strong>damaged</strong>.<br>
                    The book’s condition will be reviewed by the library administrator, and you will be notified if any charges are applied.";
            }
        } else {
            $statusMessage = "
                Dear <strong>{$username}</strong>,<br><br>
                The book return has been recorded with status: <strong>{$status}</strong>.";
        }

        $emailService->setMessage("
            <html><body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
            <div style='max-width:600px; margin:auto; background:white; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);'>
                <h2 style='color:#0056b3;'>📦 Book Return Update</h2>
                <p>{$statusMessage}</p>
                <hr>
                <p><strong>Returned Date:</strong> {$returned_date}</p>
                <p><strong>Due Date:</strong> {$due_date}</p>
                " . ($total_charge > 0 ? "<p><strong>Total Charges:</strong> <span style='color:red;'>\${$total_charge}</span></p>" : "") . "
                <p style='font-size: 0.9em; color: #888;'>Thank you for using Miftaax Library.</p>
            </div></body></html>
        ");
        $emailService->setMailType('html');
        $emailService->send();
    }

    return $this->response->setJSON(['status' => (bool) $inserted]);
}










}
