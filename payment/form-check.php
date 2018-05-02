<?php
session_start();
/**
 * Form posting handler
 */
require '../../../../wp-load.php';

/**
* Add transaction info to database 
*/

if ( isset($_GET['func']) && $_GET['func'] == 'addrow') {

	global $wpdb, $user_id;

	$plan_price = $_POST['plan_price_p'];
	$fa_user_current_funds = get_the_author_meta('account_funds', $user_ID);

	if($fa_user_current_funds > $plan_price) {
		$p_status = "error";
	} else {













		session_start();
		/**
		 * Form posting handler
		 */
		$pagePath = explode('/wp-content/', dirname(__FILE__));
	    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));

		/**
		* Add transaction info to database 
		*/

		global $wpdb;

		$wpdb->query('CREATE TABLE IF NOT EXISTS `td_payments` (
		        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		        `token` TEXT NOT NULL,
		        `email` TEXT NOT NULL,
		        `package_id` TEXT NOT NULL,
		        `package_name` TEXT NOT NULL,
		        `price` TEXT NOT NULL,
		        `currency` TEXT NOT NULL,
		        `payment_type` TEXT NOT NULL,
		        `status` TEXT NOT NULL,
		        `custom_id` TEXT NOT NULL,
	        	`transaction_id` TEXT NOT NULL,
	        	`sumary` TEXT NOT NULL,
		        `created` INT( 4 ) UNSIGNED NOT NULL
		) ENGINE = MYISAM ;');

		$planTOKEN = "";
		$planCustomID = uniqid();

		$package_price = get_post_meta($planID, 'package_price', true);

		global $redux_demo;

		if(empty($package_price) or $package_price == 0) {
			$package_price = __( 'Free', 'themesdojo' );
			$currency_symbol = "";
		} else {
			$currency_symbol = $redux_demo['currency-symbol'];
		}

		$planPACKAGE = get_the_title( $planID );

		$planPRICE = $package_price;
		$planCURRENCY = $currency_symbol;
		$planTYPE = "Funds";
		$planSTATUS = "success";

		$price_plan_information = array(
			'token' => 'adasdasd',
			'email' => $planEMAIL,
			'package_id' => $planID,
			'package_name' => $planPACKAGE,
			'price' => $planPRICE,
			'currency' => $planCURRENCY,
			'payment_type' => $planTYPE,
			'transaction_id' => '',
			'status' => $planSTATUS,
			'created' => time(),
			'custom_id' => ''
		); 

		$insert_format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
		        
		$wpdb->insert('td_payments', $price_plan_information, $insert_format);

		//=========================================
		// add package info to user ===============
		//=========================================
		$user = get_user_by( 'email', $planEMAIL );
		$user_id = $user->ID;

		update_user_meta( $user_id, "user_featured_listings_used_".$planCustomID, "0" );
		update_user_meta( $user_id, "user_regular_listings_used_".$planCustomID, "0" );

		//=========================================
		// Send email to admin ====================
		//=========================================

		global $redux_demo;
		$admin_email = $redux_demo['contact-email'];
		$admin_email_title = $redux_demo['payment-admin-title'];
		$admin_email_message = $redux_demo['payment-admin-message'];

		if(empty($admin_email)) {
			$admin_email = "test@mail.com";
		}

		if(empty($admin_email_title)) {
			$admin_email_title = "New payment!";
		}

		if(empty($admin_email_message)) {
			$admin_email_message = "Master, you have a new payment: ";
		}

		$blog_title = get_bloginfo('name');

		$emailTo = $admin_email;
	    $subject = $admin_email_title; 
	    $body = $admin_email_message. "\r\n\r\n" .$planNAME. "\r\n" .$planEMAIL. "\r\n\r\n" .$planPACKAGE. "\r\n" .$planPRICE." ".$planCURRENCY. "\r\n via " .$planTYPE ;
	    $headers = 'From website' . "\r\n" . 'Reply-To: ' . $email;
	                      
	    wp_mail($emailTo, $subject, $body, $headers);

	    //=========================================

	    //=========================================
		// Send email to subscriber ===============
		//=========================================

		global $redux_demo;
		$admin_email = $redux_demo['contact-email'];
		$user_email_title = $redux_demo['payment-user-title'];
		$user_email_message = $redux_demo['payment-user-message'];

		if(empty($admin_email)) {
			$admin_email = "test@mail.com";
		}

		if(empty($user_email_title)) {
			$user_email_title = "Payment notification!";
		}

		if(empty($user_email_message)) {
			$user_email_message = "Congratulations. Your payment went through!";
		}

		$blog_title = get_bloginfo('name');

		$from  = $admin_email;
		$headers = 'From: '.$from . "\r\n";
	    $subject = $user_email_title; 
	    $body = $user_email_message. "\r\n\r\n" .$planNAME. "\r\n" .$planEMAIL. "\r\n" .$planPACKAGE. "\r\n" .$planPRICE."".$planCURRENCY. "\r\n" .$planTYPE;
	                      
	    wp_mail($planEMAIL, $subject, $body, $headers);













		$new_fa_user_current_funds = $fa_user_current_funds - $plan_price;

		update_user_meta( $user_ID, 'account_funds', $new_fa_user_current_funds );
?>

<?php
		$p_status = "success";

	}

}

/**
* End function
*/

if ($p_status == "success") {
	header('Location: '.home_url(). '/success/');
} else {
	header('Location: '.home_url(). '/error/');
}

