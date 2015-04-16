<?php
/**
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

class HybridConfig {
	public static function getProviders() {
		return
			array(
				"base_url" => "http://".$_SERVER['SERVER_NAME']."/hybrid/hybridauth/",

				"providers" => array (
					"Facebook" => array (
						"enabled" => true,
						"keys"    => array ( "id" => "828289110577673", "secret" => "4ab259b3c09c1cf29dd21b0b85b4884d" ),
						"scope"   => "email, user_about_me, user_birthday, user_hometown", // optional
						"display" => "popup" // optional
					),
					"Twitter" => array (
						"enabled" => true,
						"keys"    => array ( "key" => "y0qtWuBA5wh2ZLFeLR7jiWJmv", "secret" => "MDmW9ajskHyO5n6leCkHbgoRGhLYcvQypV2tRE3cNrrqqftneY" )
					),
					"Vkontakte" => array (
						"enabled" => true,
						"keys"    => array ( "id" => "4865481", "secret" => "APWBeE2WYQjNd1NMP4Ip" )
					),
					"Google" => array (
						"enabled" => true,
						"keys"    => array ( "id" => "594421014880", "secret" => "jY_i94IWplxitXdkRW8QRq2E" ),
						"scope"           => "https://www.googleapis.com/auth/userinfo.profile ".
                               "https://www.googleapis.com/auth/userinfo.email"
						"access_type"     => "offline",
						"approval_prompt" => "force",
						"hd"              => "wikiwalker.ru"
					)
				),

				// If you want to enable logging, set 'debug_mode' to true.
				// You can also set it to
				// - "error" To log only error messages. Useful in production
				// - "info" To log info and error messages (ignore debug messages)
				"debug_mode" => false,

				// Path to file writable by the web server. Required if 'debug_mode' is not false
				"debug_file" => "",
			);
	}
}