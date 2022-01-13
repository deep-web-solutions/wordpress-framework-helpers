<?php

use DeepWebSolutions\Framework\Helpers\Users;

defined( 'ABSPATH' ) || exit;

switch ( $_GET['action'] ) {
	case 'logout_user':
		Users::logout( $_GET['user_id'] ? intval( $_GET['user_id'] ) : null );
		break;
	case 'get_roles':
		echo wp_json_encode( Users::get_roles( $_GET['user_id'] ? intval( $_GET['user_id'] ) : null ) );
		break;
	case 'has_roles':
		echo wp_json_encode( Users::has_roles( $_GET['roles'] ?? array(), $_GET['user_id'] ? intval( $_GET['user_id'] ) : null, $_GET['logic'] ?? 'and' ) );
		break;
	case 'has_capabilities':
		echo wp_json_encode( Users::has_capabilities( $_GET['capabilities'] ?? array(), $_GET['args'] ?? array(), isset( $_GET['user_id'] ) ? intval( $_GET['user_id'] ) : null, $_GET['logic'] ?? 'and' ) );
		break;
}
