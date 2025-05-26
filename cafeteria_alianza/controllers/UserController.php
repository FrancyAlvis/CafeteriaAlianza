<?php
require_once __DIR__ . '/../models/User.php';

class UserController 
{
    private $userModel;
 
    public function __construct() 
    {
        $this->userModel = new User();
    }
    
    public function index() //show users lists 
    {
     
        $users = $this->userModel->getAll(); //get all users from database
        session_start(); //verify authenticator user

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    
        include __DIR__ . '/../views/users/index.php';
    }
  
    public function create()
      {
    
        session_start(); //verify authenticator user

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }   

         include __DIR__ . '/../views/users/create.php';
    }

    public function edit($id)
    {
        
         session_start(); //verify authenticator user

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            die("Usuario no encontrado");
        }

        include __DIR__ . '/../views/users/edit.php';
    }


    public function store($name, $email, $pass, $role)
    {
        $errors = [];

        if (empty($name)) {
            $errors[] = "El nombre es obligatorio.";
        }

        if (empty($email)) {
            $errors[] = "El correo electrónico es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El formato del correo no es válido.";
        }

        if (empty($pass)) {
            $errors[] = "El password es obligatorio.";
        }

        if (empty($role)) {
            $errors[] = "El rol es obligatorio.";
        }   

        if (count($errors) > 0) {   // if wrong is bigger than 0 there is a mistake
            $oldData = ['name' => $name, 'email' => $email, 'role' => $role];
            include __DIR__ . '/../views/users/create.php';
        } else {
            // hash
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            $userModel = new User(); // crea instancia
            $userModel->create($name, $email, $hashedPass, $role);

            header("Location: index.php?controller=user&action=index&success=1");
            exit;
        }
    }

    public function update($id, $name, $email, $role)
    {
        $errors = [];

        if (empty($name)) $errors[] = "El nombre es obligatorio.";
        if (empty($email)) $errors[] = "El correo es obligatorio.";
        if (empty($role)) $errors[] = "El rol es obligatorio.";
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Correo inválido.";

        if ($errors) {
            $user = ['id' => $id, 'name' => $name, 'email' => $email];
            include __DIR__ . '/../views/users/edit.php';
        } else {
            $userModel = new User();
            $userModel->update($id, $name, $email, $role);
            header("Location: index.php?controller=user&action=index&updated=1");
            exit;
        }
    }

    public function delete($id)
    {
        $userModel = new User();
        $userModel->delete($id);
        header("Location: index.php?controller=user&action=index&deleted=1");
        exit;
    }
}



