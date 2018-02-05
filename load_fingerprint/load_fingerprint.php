<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Admin\Extensions\Chronoforms\Actions\LoadFingerprint;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
Class LoadFingerprint extends \GCore\Admin\Extensions\Chronoforms\Action{
	static $title = 'Load Fingerprint';
	static $group = array('anti_spam' => 'Anti Spam');

	function execute(&$form, $action_id){
		$config =  $form->actions_config[$action_id];
		$config = new \GCore\Libs\Parameter($config);
		$doc = \GCore\Libs\Document::getInstance();

		if (!isset($_COOKIE['formUserHash'])) {
			$doc->addJsFile(\GCore\C::ext_url('chronoforms', 'admin').'actions/load_fingerprint/js/fingerprint2.min.js');
			$doc->addJsFile(\GCore\C::ext_url('chronoforms', 'admin').'actions/load_fingerprint/js/jquery.cookie.js');
			$doc->addJsCode('
			jQuery(document).ready(function($){

				var fp_options = {
					excludeWebGL: true,
					excludeSessionStorage: true,
					excludeFlashFonts: true,
					excludeJsFonts: true
				};

				var cookie_options = {
					expires: 1
				};

				new Fingerprint2(fp_options).get(function(hash){
					return $.cookie("formUserHash", hash, cookie_options);
				});
				
			});');
		}

	}

	public static function config(){
		echo \GCore\Helpers\Html::formStart('action_config load_fingerprint_action_config', 'load_fingerprint_action_config__XNX_');
		echo \GCore\Helpers\Html::formEnd();
	}
}