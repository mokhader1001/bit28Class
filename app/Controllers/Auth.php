<?php

namespace App\Controllers;
use App\Models\UserModel ;
use CodeIgniter\Controller;


class Auth extends Controller
{
    public function index()
    {
        return view('login');
    }

 public function login()
{
    $email = $this->request->getVar('email');
    $password = $this->request->getVar('password');

    $model = new UserModel();
    $user = $model->where('email', $email)->first();

    if ($user) {
        if ($password == $user['password']) {
            session()->set([
                'staff_id'  => $user['staff_id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'phone'     => $user['phone'],
                'gender'    => $user['gender'],
                'role'      => $user['role'],
                'image'     => $user['image'],
                'reg_date'  => $user['reg_date'],
                'status'    => $user['status'],
                'logged_in' => true
            ]);

            // ✅ Use HomeModel's store() to log login
     $agent = $this->request->getUserAgent();
$platform = $agent->getPlatform();
$deviceType = $agent->getMobile() ?: 'Desktop';

$home = new \App\Models\HomeModel();
$home->store('login_logs', [
    'staff_id'     => $user['staff_id'],
    'ip_address'   => $this->request->getIPAddress(),
    'user_agent'   => $agent->getAgentString(),
    'device_type'  => $deviceType,
    'platform'     => $platform,
    'login_time'   => date('Y-m-d H:i:s')
]);

            return $this->response->setJSON(['success' => true, 'message' => 'Login successful']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Incorrect password']);
        }
    }

    return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
}

public function logout()
{
    session()->destroy(); // Clear all session data
    return redirect()->to(base_url(''));
}

}
