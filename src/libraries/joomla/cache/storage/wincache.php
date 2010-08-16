<?php
/**
 * @version		$Id: wincache.php 18212 2010-07-22 06:02:54Z eddieajau $
 * @package		Joomla.Framework
 * @subpackage	Cache
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * WINCACHE cache storage handler
 *
 * @package		Joomla.Framework
 * @subpackage	Cache
 * @since		1.6
 */
class JCacheStorageWincache extends JCacheStorage
{
	/**
	 * Constructor
	 *
	 * @param	array	$options optional parameters
	 */
	public function __construct( $options = array() )
	{
		parent::__construct($options);
	}

	/**
	 * Get cached data from WINCACHE by id and group
	 *
	 * @param	string	$id		The cache data id
	 * @param	string	$group		The cache data group
	 * @param	boolean	$checkTime	True to verify cache time expiration threshold
	 * @return	mixed	Boolean false on failure or a cached data string
	 * @since	1.6
	 */
	public function get($id, $group, $checkTime)
	{
		$cache_id = $this->_getCacheId($id, $group);
		$cache_content = wincache_ucache_get($cache_id);
		return $cache_content;
	}

	/**
	 * Get all cached data
	 *
	 * @return	array data
	 * @since	1.6
	 */
	public function getAll()
	{
		parent::getAll();

		$allinfo 	= wincache_ucache_info();
		$keys 		= $allinfo['cache_entries'];
		$secret 	= $this->_hash;
		$data 		= array();

		foreach ($keys as $key) {
			$name 		= $key['key_name'];
			$namearr	= explode('-',$name);
			if ($namearr !== false && $namearr[0]==$secret &&  $namearr[1]=='cache') {
				$group = $namearr[2];
				if (!isset($data[$group])) {
					$item = new JCacheStorageHelper($group);
				} else {
					$item = $data[$group];
				}
				if (isset($key['value_size'])) {
					$item->updateSize($key['value_size']/1024);
				}
				else {
					$item->updateSize(1);
				} // dummy, WINCACHE version is too low
				$data[$group] = $item;
			}
		}

		return $data;
	}

	/**
	 * Store the data to WINCACHE by id and group
	 *
	 * @param	string	$id	The cache data id
	 * @param	string	$group	The cache data group
	 * @param	string	$data	The data to store in cache
	 * @return	boolean	True on success, false otherwise
	 * @since	1.6
	 */
	public function store($id, $group, $data)
	{
		$cache_id = $this->_getCacheId($id, $group);
		return wincache_ucache_set($cache_id, $data, $this->_lifetime);
	}

	/**
	 * Remove a cached data entry by id and group
	 *
	 * @param	string	$id		The cache data id
	 * @param	string	$group	The cache data group
	 * @return	boolean	True on success, false otherwise
	 * @since	1.6
	 */
	public function remove($id, $group)
	{
		$cache_id = $this->_getCacheId($id, $group);
		return wincache_ucache_delete($cache_id);
	}

	/**
	 * Clean cache for a group given a mode.
	 *
	 * group mode		: cleans all cache in the group
	 * notgroup mode	: cleans all cache not in the group
	 *
	 * @param	string	$group	The cache data group
	 * @param	string	$mode	The mode for cleaning cache [group|notgroup]
	 * @return	boolean	True on success, false otherwise
	 * @since	1.6
	 */
	public function clean($group, $mode)
	{
		$allinfo 	= wincache_ucache_info();
		$keys 		= $allinfo['cache_entries'];
		$secret 	= $this->_hash;

		foreach ($keys as $key) {
			if (strpos($key['key_name'], $secret.'-cache-'.$group.'-') === 0 xor $mode != 'group') {
				wincache_ucache_delete ($key['key_name']);
			}
		}
		return true;
	}

	/**
	 * Force garbage collect expired cache data as items are removed only on get/add/delete/info etc
	 *
	 * @return	boolean	True on success, false otherwise.
	 * @since	1.6
	 */
	public function gc()
	{
		$lifetime	= $this->_lifetime;
		$allinfo 	= wincache_ucache_info();
		$keys 		= $allinfo['cache_entries'];
		$secret 	= $this->_hash;

		foreach ($keys as $key) {
			if (strpos($key['key_name'], $secret.'-cache-')) {
				wincache_ucache_get($cache_id);
			}
		}
	}

	/**
	 * Test to see if the cache storage is available.
	 *
	 * @return boolean  True on success, false otherwise.
	 */
	public static function test()
	{
		$test = extension_loaded('wincache') && function_exists('wincache_ucache_get') && !strcmp(ini_get('wincache.ucenabled'), '1');
		return $test;
	}
}