<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::user_log');

// Public routes (no login required)
$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('Exams/(:num)', 'quizcontroller::view_quiz/$1');
$routes->post('submit_quiz_answers', 'quizcontroller::submit_quiz_answers');
$routes->get('BIT28-A/GraduationReg', 'BIT28Controller::index');
$routes->post('Bit28_a_save', 'BIT28Controller::Bit28_a_save');
$routes->post('Bit28/update_status', 'BIT28Controller::update_status');
$routes->get('Bit28/fetch_students', 'BIT28Controller::fetch_students');
$routes->get('Bit28/Students_confirmations', 'BIT28Controller::Students_confirmations');

$routes->post('Bit28/delete_student', 'BIT28Controller::delete_student');
$routes->get('Bit28/accepted_students', 'BIT28Controller::show_accepted_students');








// Protected routes (require login)
$routes->group('', ['filter' => 'authguard'], function ($routes) {
    $routes->get('Authors', 'Home::Authors');
    $routes->post('authors/save', 'Home::author_form');
    $routes->get('authors/fetch_Authors', 'Home::fetch_Authors');
    $routes->get('logout', 'Auth::logout');
    $routes->get('lib', 'Home::lib');
    $routes->post('libraryusers/save', 'Home::save_lib'); // Insert/Update/Delete user

    $routes->get('authors/fetch_library_users', 'Home::fetch_lib_users');

    $routes->get('books', 'Home::books');
    $routes->post('books/save', 'Home::save_book'); 
    $routes->get('books/fetch_books', 'Home::fetch_books');

    $routes->get('staff/users', 'Home::lib_staf');
    $routes->get('staff/fetch_staff', 'Home::fetch_staff');

    $routes->post('staff/save_staff', 'Home::save_staff'); 

    $routes->get('libaray/rules', 'Home::rules');

    $routes->get('user/view_profile', 'Home::profile');

    $routes->get('finance/charges', 'Home::viewDamage');

    $routes->get('get_damaged_books_pending_charge', 'Home::get_damaged_books_pending_charge');


    $routes->post('charges/evaluate', 'Home::evaluate');


    $routes->get('Admin/loginLogs', 'Home::loginLogs');

    $routes->get('cancel_cahrge', 'Home::cancel_charge');

    $routes->get('charges/fetch_damage_charges', 'Home::fetch_damage_charges');
    $routes->post('charges/delete_damage_charge', 'Home::delete_damage_charge');

    $routes->get('Finance/Payments', 'Home::payment_report');
    $routes->get('Quiz-Manager/Quiz', 'quizcontroller::quizes');
    $routes->get('Quiz-Manager/Class', 'quizcontroller::class');

    $routes->post('save_class', 'quizcontroller::save_class');

    $routes->get('fetch_clases', 'quizcontroller::fetch_clases');
    $routes->post('delete_class', 'quizcontroller::delete_class');
    $routes->get('Quiz/Register', 'quizcontroller::quiz_summary');
    $routes->get('Quiz/List', 'quizcontroller::fetch_quiz');
    $routes->post('save_quiz', 'quizcontroller::save_quiz');

    $routes->get('Assign/quiz_class', 'quizcontroller::quiz_class');
    $routes->post('save_quiz_class', 'quizcontroller::save_quiz_class');
    $routes->get('fetch_quiz_class', 'quizcontroller::fetch_quiz_class');
    $routes->get('body', 'quizcontroller::body');
    $routes->post('save_questions', 'quizcontroller::save_questions');






















    













});
$routes->get('user/verfications', 'Home::verfications');

$routes->post('checkCardId', 'Home::checkCardId');

$routes->post('sendVerificationCode', 'Home::sendVerificationCode'); 


$routes->get('dhash', 'Home::dhash');

$routes->post('verifyCode', 'Home::verifyCode');

$routes->get('borrow', 'Home::showAvailableBooks');

$routes->post('borrow/save', 'Home::saveBorrow');

$routes->post('library-policy/save', 'Home::save');


$routes->get('fetch_borrow_book', 'Home::fetch_borrow_booka');

$routes->get('return', 'Home::return');


$routes->post('returnbooks', 'Home::returnbooks');

$routes->get('Dash', 'Home::Dash');
$routes->get('Rules_for_Users', 'Home::Rules_for_Users');

$routes->get('showUnreturnedBooks', 'Home::showUnreturnedBooks');
$routes->post('makepayment', 'Home::makepayment');







