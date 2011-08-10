<?php

/**
 * Helper
 *
 * @author Fabrizio Branca
 */
class Aoe_Apc_Helper_Data extends Mage_Core_Helper_Abstract {

	protected $smaInfo;

	/**
	 * Retrieves APC's Shared Memory Allocation information
	 *
	 * @return array
	 */
	protected function getSmaInfo() {
		if (is_null($this->smaInfo)) {
			$this->smaInfo = apc_sma_info();
		}
		return $this->smaInfo;
	}

	/**
	 * Get memory size
	 *
	 * @return int (bytes)
	 */
	public function getMemorySize() {
		$mem = $this->getSmaInfo();
		return $mem['num_seg']*$mem['seg_size'];
	}

	/**
	 * Get available memory size
	 *
	 * @return int (bytes)
	 */
	public function getAvailableMemorySize() {
		$mem = $this->getSmaInfo();
		return $mem['avail_mem'];
	}

	/**
	 * Get used memory size
	 *
	 * @return int (bytes)
	 */
	public function getUsedMemorySize() {
		return $this->getMemorySize() - $this->getAvailableMemorySize();
	}

	/**
	 * Format bytes
	 *
	 * @param int $bytes
	 * @return string
	 */
	public function formatBytes($bytes) {
		return number_format($bytes / (1024*1024), 2) . ' MB';
	}

}
