<?php

/**
* 
* by hsur ( http://blog.cles.jp/np_cles )
*/

function pbl_ipcache_write(){
	$key = sprintf("BL%u", ip2long(serverVar('REMOTE_ADDR')));

	// XCache
	xcache_set($key, 1, NP_BLACKLIST_CACHE_LIFE);
}

function pbl_ipcache_read(){
	$key = sprintf("BL%u", ip2long(serverVar('REMOTE_ADDR')));
	// XCache
	if( xcache_isset($key) ){
		return true;	
	}
	return false;
}

function pbl_ipcache_gc(){
}
