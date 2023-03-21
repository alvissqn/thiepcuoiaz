<?php
/*
 * Nhúng tài nguyên CSS,JS...
 */
namespace App\Helpers;

class Assets{
	protected static $items=[], $callback=[], $count=0;

	/*
	 * Thêm link script, đoạn mã
	 */
	public static function showOnFooter($item, $multi=""){
		if(empty($multi)){
			array_push(self::$items, $item);
		}else{
			self::$items=array_merge(self::$items, func_get_args());
		}
	}

	/*
 	 * Thêm function
 	 */
	public static function callback($closure, $params=[]){
		array_push(self::$callback, ["closure"=>$closure, "params"=>$params]);
	}

	/*
	 * Hiện
	 */
	public static function show($item = null){
		$items=is_null($item) ? self::$items : func_get_args();
		$out="";
		foreach(array_unique($items) as $link){
			$ext=strlen($link)>200 ? null : pathinfo($link, PATHINFO_EXTENSION);
			if($ext=="js"){
				$out.='<script src="'.$link.'"></script>';
			}else if($ext=="css"){
				$out.='<link href="'.$link.'" rel="stylesheet" />';
			}else{
				$out.=$link;
			}
		}

		// Gọi các Closure ở cuối trang
		if( is_null($item) ){
			for($i=0; $i<count(self::$callback); $i++){
				$call=self::$callback[$i];
				$out.=call_user_func_array($call["closure"], $call["params"]);
			}
		}
		return $out;
	}

	/*
	 * Tối ưu css
	 */
	public static function cssMinifier($content, $comment = "/* Contact my via FB: https://fb.com/kiem.dev */\n"){
		$content = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $content);
		while( stristr($content, '  '))   $content = str_replace('  ', '', $content);
		$content=preg_replace('/\/\*(.+?)\*\//', "", $content);
		return $comment."".$content;
	}
}