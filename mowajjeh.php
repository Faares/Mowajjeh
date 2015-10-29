<?php
/**
* NOTE : THIS FILE JUST A EXAMPLE!
*/


include "Mowajjeh.class.php";

$mow = new Mowajjeh();

#callback
$mow->get("/plaplapla/:pla",['pla'=>'value'],function($pla){
	echo "Hello I'm {$pla}";
});

$mow->general('/books',function() use($mow){

	// URI WILL BE : http://example.com/books/
	$mow->get('/',null,function(){
		echo "I'm index page of book section .";
	});

	// URI WILL BE : http://example.com/books/add
	$mow->get('/add',null,function(){
		echo "I'm add new books page .";
	});

});

# file!
												# full path!
$mow->post("/get_data/:num",['type'=>"[0-9]*"],__DIR__."/data.php");

# RUN , want callback after end ? ok , just write your code!
$mow->run(function(){
	print "END OF APP!";
});