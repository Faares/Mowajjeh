# Mowajjeh
simple PHP router.

# Installation

1. Include the class on your project.
2. Make sure to add these lines to your `.htaccess` :
	```htaccess
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php [L,QSA]
	```
3. Follow the usage section bellow!


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

# include file , all vars will pass to it.
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

# RUN , want callback after end ? ok , just write your code!
$mow->run(function(){
	print "END OF APP!";
});
```
