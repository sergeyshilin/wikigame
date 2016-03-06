<?php
class Controller_login extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_login();
        $this->view = new View();
    }

    function action_index($action_param = null, $action_data = null)
    {
        $loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true;

        if($action_param == "register" && $_REQUEST && !$loggedIn) {
                $error = false;
                $error_msg = "";
                if (!empty($_REQUEST["email"]) &&
                    !empty($_REQUEST["password"]) &&
                    !empty($_REQUEST["password_confirmation"] &&
                    !empty($_REQUEST["nick"]))
                ) {
                    $user_exist = $this->model->get_user_by_email($_REQUEST["email"]);
                    if ($user_exist) {
                        $error = !$error;
                        $error_msg = "Пользователь с таким e-mail уже существует";
                    } else if (!preg_match('/.+@.+\..+/i', $_REQUEST["email"])){
                        $error = !$error;
                        $error_msg = "Кажется, этот e-mail не корректный";
                    }
                    else if ($_REQUEST["password"] != $_REQUEST["password_confirmation"]) {
                        $error = !$error;
                        $error_msg = "Пароли не совпадают";
                    } else if(!$this->model->checkForUniqueNick($_REQUEST["nick"])){
                        $error = !$error_msg;
                        $error_msg = "Такой никнейм уже занят";
                    }
                    else {
                        $this->model->create_new_simple_user(
                            $_REQUEST["email"],
                            $_REQUEST["password"],
                            $_REQUEST["nick"]
                        );
                        $user_id = $this->model->
                        get_user_by_email_and_password($_REQUEST["email"], md5($_REQUEST["password"]));
                        $_SESSION["user_connected"] = true;
                        $_SESSION["user_id"] = $user_id->id;
                        header("Location: /");
                    }
                }
            $this->view->generate("register_form_view.php", "template_view.php", $error, $error_msg);
            exit();
        }
        else if($loggedIn) {
            header("Location: /");
        }
        if($action_param == "exit") { session_destroy(); header("Location: /"); }
        if ($loggedIn) {
            header("Location: /");
        }
        $error = false;
        $error_msg = "";
        if (isset($_REQUEST["email"]) && isset($_REQUEST["password"])) {
            $check_email = preg_match('/.+@.+\..+/i', $_REQUEST["email"]);
            $user_exist = $this->model->get_user_by_email_and_password($_REQUEST["email"], md5($_REQUEST["password"]));
            if ($user_exist && $check_email) {
                $_SESSION["user_connected"] = true;
                header("Location: /");
            } else {
                $error = !$error;
                $error_msg = "Неверно указаны e-mail или пароль";
            }
        } elseif ($action_param == "provider") {
            $provider_name = $action_data;
            try {
                require_once("application/vendor/hybridauth/config.php");
                require_once("application/vendor/hybridauth/Hybrid/Auth.php");
                $config = HybridConfig::getProviders();
                $hybridauth = new Hybrid_Auth($config);
                $adapter = $hybridauth->authenticate($provider_name);
                $user_profile = $adapter->getUserProfile();
            } catch (Exception $e) {
                echo $e;
                echo $provider_name;
                exit();
                // header("Location: http://www.example.com/login-error.php");
            }
            // check if the current user already have authenticated using this provider before
            $user_exist = $this->model->get_user_by_provider_and_id($provider_name, $user_profile->identifier);
            // if the used didn't authenticate using the selected provider before
            // we create a new entry on database.users for him
            if (!$user_exist) {
                $this->model->create_new_hybridauth_user(
                    $user_profile->email,
                    $user_profile->firstName,
                    $user_profile->lastName,
                    $provider_name,
                    $user_profile->identifier
                );
                $user_exist = $this->model->get_user_by_provider_and_id($provider_name, $user_profile->identifier);
            }
            // set the user as connected and redirect him
            $_SESSION["user_connected"] = true;
            $_SESSION["user_adapter"] = $provider_name;
            $_SESSION["user_id"] = $user_exist->id;
            header("Location: /");
        }
            //generating form with login
            $this->view->generate("login_form_view.php", "dummy.php", $error, $error_msg);
    }
}