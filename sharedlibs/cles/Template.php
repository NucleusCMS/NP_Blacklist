<?php
// vim: tabstop=2:shiftwidth=2

/**
  * 
  * by hsur ( http://blog.cles.jp/np_cles )
*/

/*
  * Copyright (C) 2006 CLES. All rights reserved.
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License
  * along with this program; if not, write to the Free Software
  * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301 USA
  * 
  * In addition, as a special exception, cles( http://blog.cles.jp/np_cles ) gives
  * permission to link the code of this program with those files in the PEAR
  * library that are licensed under the PHP License (or with modified versions
  * of those files that use the same license as those files), and distribute
  * linked combinations including the two. You must obey the GNU General Public
  * License in all respects for all of the code used other than those files in
  * the PEAR library that are licensed under the PHP License. If you modify
  * this file, you may extend this exception to your version of the file,
  * but you are not obligated to do so. If you do not wish to do so, delete
  * this exception statement from your version.
*/

class cles_Template {
	var $defaultLang = 'japanese-utf8';
	var $defalutPattern = '#{{(.*?)(\|)?}}#i';
	var $lang;
	var $templateDir;

	function __construct($templateDir) {
		global $CONF;
		$this->templateDir = $templateDir;
		$this->lang = str_replace( array('/','\\'), '', getLanguageName());
	}

	function fetch($name, $dir = null, $suffix = 'html') {
		$path = $this->templateDir.'/'.( $dir ? strtolower($dir) . '/' : '' ).strtolower($name).'_'.$this->lang.( $suffix ? '.'.strtolower($suffix) : '' );
		if ( ! file_exists($path) ){
			$path = $this->templateDir.'/'.( $dir ? strtolower($dir) . '/' : '' ).strtolower($name).'_'.$this->defaultLang.( $suffix ? '.'.strtolower($suffix) : '' );
			if ( ! file_exists($path) )
				return '';
		}
		
		$fsize = filesize($path);
		if ($fsize <= 0) return '';
		
		return file_get_contents($path);
	}
	
	function fill($template, $values, $default = null) {
		if( $default )
			return preg_replace_callback($this->defalutPattern,
				function($m) use($values,$default) {
					if(!isset($values[$m[1]])) {
						return $default;
					}
					return $m[2] ? hsc($values[$m[1]]) : $values[$m[1]];
				}, $template);
		if( $default === null )
			return preg_replace_callback($this->defalutPattern,
				function($m) {
					return $m[2] ? hsc($values[$m[1]]) : $values[$m[1]];
				}, $template);
		return preg_replace_callback($this->defalutPattern,
			function($m) use($values) {
				return isset($values[$m[1]]) ? (isset($m[2])&&$m[2] ? hsc($values[$m[1]]) : $values[$m[1]]) : $m[1];
			}, $template);
	}
}
