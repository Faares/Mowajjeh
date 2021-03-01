# Mowajjeh
simple PHP router
# Usage

```php
<?php

include "Mowajjeh.class.php";
$mow = new Mowajjeh();

$mow->get("/",null,function(){
	echo "index page";
});

$mow->get("/about",null,function(){
	echo "about page";
});

# callback
$mow->get("/hello/:user",['user'=>"[a-z]*"],function($user){
	echo "Hello I'm {$user}";
});

# include File , all vars will pass to the file.
$mow->get("/hello/:user",['user'=>"[a-z]*"],__DIR__."example.php");

# post
$mow->post("/api/get_data/:type",['type'=>"[a-z]*"],function($type){
	return $type;
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
```
