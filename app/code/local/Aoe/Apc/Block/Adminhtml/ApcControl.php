<?php

class Aoe_Apc_Block_Adminhtml_ApcControl extends Mage_Adminhtml_Block_Template {

	/**
	 * Return cache information
	 *
	 * @return string
	 */
	protected function getCacheInformation() {
		$cacheBackend = Mage::app()->getCacheInstance()->getFrontend()->getBackend();
		$cacheBackendClass = get_class($cacheBackend);
		if ($cacheBackendClass == 'Zend_Cache_Backend_TwoLevels') {
			$config = Mage::app()->getConfig()->getNode('global/cache');
			$fastBackend = (string)$config->backend;
			$slowBackend = (string)$config->slow_backend;
			return "Backend: $cacheBackendClass (Fast: $fastBackend, Slow: $slowBackend)\n";
		} else {
			return 'Backend: ' . $cacheBackendClass . "\n";
		}
	}

}