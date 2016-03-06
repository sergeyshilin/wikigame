<?php
class Model_login extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }

    /*
    * get the user data from database by email and password
    **/
    function get_user_by_email_and_password($email, $password)
    {
        return $this->exec("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
    }

    /*
    * get the user data from database by email and password
    **/
    function get_user_by_email($email)
    {
        return $this->exec("SELECT * FROM users WHERE email = '$email'");
    }

    /*
    * get the user data from database by provider name and provider user id
    **/
    function get_user_by_provider_and_id($provider_name, $provider_user_id)
    {
        return $this->exec("SELECT * FROM users WHERE hybridauth_provider_name = '$provider_name' AND hybridauth_provider_uid = '$provider_user_id'");
    }

    /**
     * insert simple user with his email and password
     */
    function create_new_simple_user($email, $password)
    {
        $password = md5($password);
        $this->query(
            "INSERT INTO users
		(
			email,
			password,
			created_at
		)
		VALUES
		(
			'$email',
			'$password',
			NOW()
		)"
        );
    }

    /*
    * insert hybridauth user
    **/
    function create_new_hybridauth_user($email, $first_name, $last_name, $provider_name, $provider_user_id)
    {
        // let generate a random password for the user
        $password = md5(str_shuffle("0123456789abcdefghijklmnoABCDEFGHIJ"));

        $this->query(
            "INSERT INTO users
		(
			email,
			password,
			first_name,
			last_name,
			hybridauth_provider_name,
			hybridauth_provider_uid,
			created_at
		)
		VALUES
		(
			'$email',
			'$password',
			'$first_name',
			'$last_name',
			'$provider_name',
			'$provider_user_id',
			NOW()
		)"
        );
    }
}
