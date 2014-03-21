<?php

/**
* 
*/
class Config{

	public static function get($path=null){

		if($path){
			$config=$GLOBALS['config'];
			$path=explode('/', $path);


			foreach ($path as $key => $value) {
				if(isset($config[$value])){
					$config= $config[$value]; 
				}
				
			}

			return $config;
		}

	}
	
	
}









?>
