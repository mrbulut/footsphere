<?php

class userController
{
    public function index()
    {
        echo 'settingsController/index';
    }

    public function login()
    {
        $isSubmit = isset($_POST['submit']) ? $_POST['submit'] : false;

        if ($isSubmit == 1) {
            if ($_POST['username'] == 'volkan' && $_POST['password'] == '123456') {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $_POST['username'];
                header('location:myprofile');
            }
        } else {
            echo 'formdan veri gelmedi';
        }
    }

    public function myprofile()
    {

    }

    public function signout()
    {
        unset($_SESSION['login']);
        session_destroy();
        header('location:/php-de-basit-mvc');
    }
}