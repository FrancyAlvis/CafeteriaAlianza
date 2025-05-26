<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function showLogin() // function shows login
    {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function login()
    {
        session_start();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = '';

        if (!$email || !$password) {
            $error = 'Email y contraseña son requeridos.';
            //$_SESSION['login_error'] = 'Email y contraseña son requeridos.';
            include __DIR__ . '/../views/auth/login.php';
            return;
        }
        
        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) { //compare with database if there is a coincidence get session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php?controller=user&action=index");
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
            //$_SESSION['login_error'] = 'Credenciales incorrectas.';
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    public function getByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function logout()
    {
        session_start();
        session_unset();        //option clean variables sesión
        session_destroy();      //Delete session

        if (ini_get("session.use_cookies")) {   //opt delete session cookies
            setcookie(session_name(), time () - 50000, '/');
       }

        header("Location: index.php?controller=auth&action=showLogin");
    }
}
