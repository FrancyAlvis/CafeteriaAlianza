<?php
class HomeController
{

    public function index()
    {
     session_start(); //verify authenticator user

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
            }

            include __DIR__ . '/../views/home/index.php';

}

}
