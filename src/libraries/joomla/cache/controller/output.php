<?php
/**
 * @version		$Id: output.php 18013 2010-07-03 03:42:31Z infograf768 $
 * @package		Joomla.Framework
 * @subpackage	Cache
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Joomla Cache output type object
 *
 * @package		Joomla.Framework
 * @subpackage	Cache
 * @since		1.6
 */
class JCacheControllerOutput extends JCacheController
{
	/**
	 * @since	1.6
	 */
	private $_id;

	/**
	 * @since	1.6
	 */
	private $_group;

	/**
	 * @since	1.6
	 */
	private $_locktest = null;

	/**
	 * Start the cache
	 *
	 * @param	string	The cache data id
	 * @param	string	The cache data group
	 * @return	boolean	True if the cache is hit (false else)
	 * @since	1.6
	 */
	public function start($id, $group=null)
	{
		// If we have data in cache use that...
		$data = $this->cache->get($id, $group);

		$this->_locktest = new stdClass;
		$this->_locktest->locked = null;
		$this->_locktest->locklooped = null;

		if ($data === false) {
			$this->_locktest = $this->cache->lock($id, $group);
			if ($this->_locktest->locked == true && $this->_locktest->locklooped == true) {
				$data = $this->cache->get($id, $group);
			}
		}

		if ($data !== false) {
			$data = unserialize(trim($data));
			echo $data;
			if ($this->_locktest->locked == true) {
				$this->cache->unlock($id, $group);
			}
			return true;
		} else {
			// Nothing in cache... lets start the output buffer and start collecting data for next time.
			if ($this->_locktest->locked == false) {
				$this->_locktest = $this->cache->lock($id, $group);
			}
			ob_start();
			ob_implicit_flush(false);

			// Set id and group placeholders
			$this->_id		= $id;
			$this->_group	= $group;

			return false;
		}
	}

	/**
	 * Stop the cache buffer and store the cached data
	 *
	 * @return	boolean	True if cache stored
	 * @since	1.6
	 */
	public function end()
	{
		// Get data from output buffer and echo it
		$data = ob_get_contents();
		ob_end_clean();
		echo $data;

		// Get id and group and reset them placeholders
		$id		= $this->_id;
		$group	= $this->_group;
		$this->_id		= null;
		$this->_group	= null;

		// Get the storage handler and store the cached data
		$ret = $this->cache->store(serialize($data), $id, $group);

		if ($this->_locktest->locked == true) {
			$this->cache->unlock($id, $group);
		}

		return $ret;
	}
}
