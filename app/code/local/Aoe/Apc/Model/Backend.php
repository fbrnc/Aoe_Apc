<?php

class Aoe_Apc_Model_Backend extends Zend_Cache_Backend_Apc {

	/**
	 * Overwriting clean method to enable cache clearing from cli
	 *
	 * @see Zend_Cache_Backend_Apc::clean()
	 */
	public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array()) {
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
		return parent::clean($mode, $tags);
	}

}
