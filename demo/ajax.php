<?php

sleep(1); // to show off the loader

switch( $_REQUEST['cmd'] ) {
	
	case 'succeed':
		exit( json_encode( array(
			'status' => 'success',
			'feedback' => '<p><strong>Success!</strong> The request succeeded and this feedback was automatically injected into the feedback container. Good stuff.</p>',
			'data' => array(
				'someData' => 'someValue',
				'moreData' => 'anotherValue',
				'evenMoreData' => 'evenMoreValues'
			)
		)));;
	
	case 'fail':
	default:
		exit( json_encode( array(
			'status' => 'error',
			'feedback' => '<p><strong>Error!</strong> You told the request to fail. That’s cool, because now you can see how errors work.</p>',
			'invalid' => array('name', 'email', 'number', 'cmd')
		)));;
		
}