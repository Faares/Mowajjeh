<?php
/**
* NOTE : THIS FILE JUST A EXAMPLE!
*/


include "Mowajjeh.class.php";

$mow = new Mowajjeh();

#callback
$mow->get("/test",function(){
	echo 'test';
});

# file!
												# full path!
$mow->post("/get_data/:num",['type'=>"[0-9]*"],__DIR__."/data.php");

# RUN , want callback after end ? ok , just write your code!
$mow->run(function(){
	print "END OF APP!";
});