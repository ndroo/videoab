<?php

switch (strtolower(getenv("ENVIRONMENT"))) {
	case 'production':
		break;

	case 'qa':
		break;

	case 'development':
	default:
		define("APP_URL","http://local.vab.com");
		define("DB_HOST","localhost");
		define("DB_READ_HOST","localhost");
		define("DB_USER","root");
		define("DB_PASS","root");
		define("DB_NAME","vab");
		break;
}
