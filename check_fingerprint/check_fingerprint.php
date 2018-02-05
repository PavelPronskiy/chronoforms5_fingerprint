<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Admin\Extensions\Chronoforms\Actions\CheckFingerprint;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
Class CheckFingerprint extends \GCore\Admin\Extensions\Chronoforms\Action{
	static $title = 'Check Fingerprint';
	//static $setup = array('simple' => array('title' => 'Captcha'));
	static $group = array('anti_spam' => 'Anti Spam');
	var $events = array('success' => 0, 'fail' => 0);
	var $defaults = array(
		'error' => "Fingerprint check failed.",
	);

	function execute(&$form, $action_id){
		$config =  $form->actions_config[$action_id];
		$config = new \GCore\Libs\Parameter($config);
		$bit = 32; // hash size md5

		if (isset($_COOKIE['formUserHash']) && strlen($_COOKIE['formUserHash']) == $bit)
		{
			$this->events['success'] = 1;
			$form->debug[$action_id][self::$title][] = "Fingerprint check passed.";
			return true;
		}
		else
		{
			$this->events['fail'] = 1;
			$form->errors['chrono_fingerprint'] = $config->get('error', "Fingerprint check failed.");
			$form->debug[$action_id][self::$title][] = "Invalid fingerprint";
			return false;
		}
	}

	public static function config(){
		echo \GCore\Helpers\Html::formStart('action_config check_fingerprint_action_config', 'check_fingerprint_action_config__XNX_');
		echo \GCore\Helpers\Html::formEnd();
	}
}