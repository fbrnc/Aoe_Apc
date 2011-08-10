<?php

class Aoe_Apc_Model_Cleaner  {

	public function clean(Varien_Event $event) {
		$mode = $event->getMode();
		if ($mode == Zend_Cache::CLEANING_MODE_ALL && php_sapi_name() == 'cli') {
			// TODO: make store id configurable
			$url = Mage::getModel('core/url')->setStore(1)->getUrl('aoeapc/apc/clearUserCache', array('key' => Mage::helper('core')->encrypt('secret')));
			$content = file_get_contents($url);
			if ($content != 'SUCCESS') {
				Mage::log('[APC] Error while cleaning apc cache from cli', Zend_Log::ERR);
				return false;
			}
			return true;
		}
	}

}
