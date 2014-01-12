<?php

switch (strtolower(getenv("ENVIRONMENT"))) {
	case 'production':
		define("APP_URL","http://prod-web-294717146.us-west-2.elb.amazonaws.com");
		define("DB_HOST","prod-write.ccevs7xleqgb.us-west-2.rds.amazonaws.com");
		define("DB_READ_HOST","prod-write.ccevs7xleqgb.us-west-2.rds.amazonaws.com"); //as a means of scaling this system, a read replica should be used, but if you do not have one setup, using the write db host will work fine
		define("DB_USER","vab");
		define("DB_PASS","io87tr6f7tuv");
		define("DB_NAME","vab");
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
