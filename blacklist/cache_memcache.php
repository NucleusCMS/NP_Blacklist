<?php

/**
* cache_memcache.php ($Revision: 1.1 $)
* 
* by hsur ( http://blog.cles.jp/np_cles )
*/

function pbl_ipcache_write(){
	global $memcache;
	$key = sprintf("BL%u", ip2long(serverVar('REMOTE_ADDR')));

	memcache_set($memcache, $key, 1, 0, NP_BLACKLIST_CACHE_LIFE);
}

function pbl_ipcache_read(){
	global $memcache;
	$key = sprintf("BL%u", ip2long(serverVar('REMOTE_ADDR')));

	if( memcache_get($memcache, $key) ){
		return true;	
	}
	return false;
}

function pbl_ipcache_gc(){
}
