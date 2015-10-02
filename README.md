# Mowajjeh
simple PHP router
# الاستخدام
```php
<?php

	include "Mowajjeh.class.php"
	$mow = new Mowajjeh();
	
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
```
