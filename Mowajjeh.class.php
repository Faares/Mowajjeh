<?php

Class Mowajjeh {

	protected $Routers;

	protected $vars;

	protected $varsKeys;

	protected $method;

	protected $notFound;

	function __construct(){

	}

	public function get($patt,$vars = false,$processor){
		$this->addRoute("GET",$patt,$vars,$processor);
	}

	public function post($patt,$vars = false,$processor){
		$this->addRoute("POST",$patt,$vars,$processor);
	}

	public function put($patt,$vars = false,$processor){
		$this->addRoute("PUT",$patt,$vars,$processor);
	}

	public function del($patt,$vars = false,$processor){
		$this->addRoute("DELETE",$patt,$vars,$processor);
	}

	protected function addRoute($method,$patt,$vars,$processor){
		$this->Routers[strtoupper($method)][] = ['patt'=>$patt,'proc'=>$processor,'vars'=>$vars];
	}

	public function setNotFound($callback){
		$this->notFound = $callback;
	}

	public function run($callback = null){
		$this->method = $this->getMethod();

		$count = 0;

		if(isset($this->Routers[$this->method])){
			$count = $this->match($this->Routers[$this->method]);
		}else{
			return false;
		}

		if($count === 0){
			if($this->notFound && is_callable($this->notFound)){
				call_user_func($this->notFound);
			}else{
				header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
				#kill!
				die;
			}
		}else{
			if($callback && is_callable($callback)){
				$callback();
			}
			return true;
		}
		return false;
	}

	protected function match($routers){

		$num = count($routers);

		$uri = rtrim($_SERVER['REQUEST_URI'],"/");

		foreach ($routers as $route) {

			$patt = $route['patt'];

			$proc = $route['proc'];

			$vars = $route['vars'];

			$patt = $this->procPatt($patt,$vars);

			# now match!
			if(preg_match('#^' . $patt . '$#', $uri)){
				# get vars
				$this->getVarsValues();

				if(is_callable($proc)){

					if($vars != false)
						#get Call back with vars!
						call_user_func_array($proc,array_values($this->vars));
					else
						#no vars ? ok , get function only!
						call_user_func($proc);

				}else{
					if($vars != false)
						extract($this->vars);
					
					# get File!
					include $proc;
				}
				break;
			}
			$this->varsKey = [];

			$num--;
		}
		
		return $num;
	}


	protected function procPatt($patt,$vars){
		$count = 0;
		foreach (explode("/",$patt) as $elm) {
			# check if have [:xx] in patt
			if(preg_match_all("/^:[a-z_]*$/",$elm,$out)){

				# cut [:]
				$key = substr($out[0][0],1);

				# here replace [:xx] with his value 
				$patt = str_replace($out[0][0],$vars[$key],$patt);

				# [xx=>count] // mean [xx] var is in [count] element of URI
				# why do this ?
				# for get vars value see getVarsValues() function
				$this->varsKey[$key] = $count; 
			}
			$count++;
		}
		return $patt;
	}


	protected function getVarsValues(){
		$Req = explode("/",rtrim($_SERVER['REQUEST_URI'],"/"));
		foreach ($this->varsKey as $key => $val) {
			$this->vars[$key] = $Req[$val];
		}
		return $this->vars;
	}

	protected function getMethod(){
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

}