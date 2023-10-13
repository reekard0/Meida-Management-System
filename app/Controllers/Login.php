<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
      $session = session();
      if(!empty($session->get('errors'))) {
          $errors = $session->get('errors');
      }
      return view('login/login'); //Returns Login page from Views folder
    }
    public function logout()
    {
      $session = session();
      $session->destroy();
      return redirect()->route('Index');
    }
    public function login() {
      $session = session();
      $db = new \App\Models\ServerModel();
      $db->initalize();
      $errors = array();
      if (isset($_POST['login_user'])) {
          $username = $_POST['username'];
          $password = $_POST['password'];
          if (empty($username)) {
              array_push($errors, "Username is required");
          }
          if (empty($password)) {
              array_push($errors, "Password is required");
          }
          if(empty($errors)) {
            $data = array('username' => $username, 'password' => $password);
            $errors = $db->login($data, $errors);
            $session->set('errors', $errors);
            if($errors) {
              return redirect('Login', $errors);
            }
            else {
              return redirect('Index');
            };
          }
          else {
            $session->set('errors', $errors);
            return redirect('Login', $session);
          }
        }
    }
}
