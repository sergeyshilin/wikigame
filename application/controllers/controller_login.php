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

        if ($action_param == "exit") {
            session_destroy();
            header("Location: /");
        }
        if ($loggedIn) {
            header("Location: /");
        }

        if ($action_param == "provider") {
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
                $code = $this->model->create_new_hybridauth_user(
                    $user_profile->email,
                    $user_profile->firstName,
                    $user_profile->lastName,
                    $provider_name,
                    $user_profile->identifier
                );
                if (!$code) {
                    header("Location: /login/fail");
                }
                $user_exist = $this->model->get_user_by_provider_and_id($provider_name, $user_profile->identifier);
            }
            // set the user as connected and redirect him
            $_SESSION["user_connected"] = true;
            $_SESSION["user_adapter"] = $provider_name;
            $_SESSION["user_id"] = $user_exist->id;
            header("Location: /");
        }
    }
}