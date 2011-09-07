<?php

/**
 * APC cleaner
 * Will be executed by an event in Aoe_AsyncCache module:
 * Varien_Cache_Core->clean()
 *
 * @author Fabrizio Branca <fabrizio.branca@aoemedia.de>
 */
class Aoe_Apc_Model_Cleaner {

	/**
	 * Clean cache
	 *
	 * @param Varien_Event $event
	 * @return bool
	 */
	public function clean($event) {
		if (get_class($event) == 'Varien_Event_Observer') {
			$event = $event->getEvent();
		}
		if (get_class($event) != 'Varien_Event') {
			throw new Exception('Wrong class');
		}
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
