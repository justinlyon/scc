<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: updates.php 1430 2010-05-24 17:01:07Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperUpdates {

  private static $_endPoint = 'http://versions.siliana.com';

  private static $_product = 'sh404sef.xml';

  // store whether doing a forced update. Reason to store it
  // is to keep _doCheck() method w/o any parameters
  // as this would otherwise prevent caching from operating
  // normally
  private static $_forced = false;

  /**
   * Obtain update information, as stored in cache
   * by checkForUpdates
   *
   */
  public function getUpdatesInfos( $forced = false) {

    // store whether doing a forced check for updates
    self::$_forced = $forced;

    // get cache object
    $cache = & JFactory::getCache( 'sh404sef_updates');
    $cache->setLifetime( 86400); // cache result for 24 hours
    $cache->setCaching(1); // force caching on

    // empty cache if we are going to look for updates
    if($forced) {
      // clean our cache
      $cache->clean( 'sh404sef_updates');
    }

    $response = $cache->call( array( 'Sh404sefHelperUpdates', '_doCheck'));

    // find out whether we should update
    $response = Sh404sefHelperUpdates::_updateRequired( $response);

    // return response, either dummy or from cache
    return $response;

  }

  public function _doCheck() {

    // if not set to auto check and not forced to do so
    // when user click on "check updates" button
    // we don't actually try to get updates info
    $sefConfig = & shRouter::shGetConfig();

    // prepare a default response object
    $response = new stdClass();
    $response->status = true;
    $response->statusMessage = JText16::_('COM_SH404SEF_CLICK_TO_CHECK_UPDATES');
    $response->current = 0;
    $response->note = '';
    $response->changelogLink = '';
    $response->minVersionToUpgrade = 0;
    $response->maxVersionToUpgrade = 0;
    $response->shouldUpdate = false;
    $response->excludes = array();

    // check if allowed to auto check, w/o user clicking on button
    if (!$sefConfig->autoCheckNewVersion && !self::$_forced) {
      return $response;
    }

    // get an http client
    require_once JPATH_COMPONENT . DS . 'lib' . DS . 'Zend' . DS . 'Http' . DS . 'Client.php';
    $hClient = new Zend_Http_Client;

    // set params
    $hClient->setUri( self::$_endPoint . '/' . self::$_product);
    $hClient->setConfig( array (
    'maxredirects' => 0,
    'timeout' => 10));

    // request file content
    $adapters = array( 'Zend_Http_Client_Adapter_Curl', 'Zend_Http_Client_Adapter_Socket');
    $rawResponse = null;

    foreach( $adapters as $adapter) {
      try {
        $hClient->setAdapter( $adapter);
        $rawResponse = $hClient->request();
        break;
      } catch (Exception $e) {  // need that to be Exception, so as to catche Zend_Exceptions.. as well
        // we failed, let's try another method
      }
    }

    // return if error
    if (!is_object( $rawResponse) || $rawResponse->isError()) {
      $response->status = false;
      $msg = method_exists( $rawResponse, 'getStatus') ? $rawResponse->getStatus() : 'unknown code';
      $response->statusMessage = JText16::sprintf('COM_SH404SEF_COULD_NOT_CHECK_FOR_NEW_VERSION', $msg);
      return $response;
    }

    // check the file
    $type = $rawResponse->getHeader('Content-type');
    if( strtolower( $type) != 'text/xml' && strtolower( $type) != 'application/xml') {
      $response->status = false;
      $response->statusMessage = JText16::sprintf('COM_SH404SEF_COULD_NOT_CHECK_FOR_NEW_VERSION', $rawResponse->getStatus());
      return $response;

    }
    // should be OK then
    $response->status = true;

    // get an xml object and parse the response
    $xml = & JFactory::getXMLparser( 'Simple');
    $xml->loadString( $rawResponse->getBody());

    // into our response object
    $response->current = $xml->document->current[0]->data();
    $response->note = $xml->document->note[0]->data();
    $response->changelogLink = $xml->document->changelogLink[0]->data();
    $response->downloadLink = $xml->document->downloadLink[0]->data();
    $response->minVersionToUpgrade = $xml->document->minVersionToUpgrade[0]->data();
    $response->maxVersionToUpgrade = $xml->document->maxVersionToUpgrade[0]->data();
    $rawExcludes = $xml->document->exclude;
    $response->excludes = array();
    if (!empty( $rawExcludes)) {
      foreach( $rawExcludes as $exclude) {
        $response->excludes[] = $exclude->data();
      }
    }

    // find if user should update
    $response = Sh404sefHelperUpdates::_updateRequired( $response);

    // check if this is a valid information file
    return $response;
  }

  /**
   * Use response object from request to update info server
   * to find if an update is required
   *
   * @param object $response
   */
  private function _updateRequired( $response) {

    // get configuration
    $sefConfig = & shRouter::shGetConfig();

    // compare versions
    $thisVersion = $sefConfig->version == '@ant_version_number@' ? '1.5.10' : $sefConfig->version;
    $response->shouldUpdate = version_compare( $thisVersion, $response->current) == -1;
    $response->shouldUpdate = $response->shouldUpdate && version_compare( $thisVersion, $response->minVersionToUpgrade) == 1;
    $response->shouldUpdate = $response->shouldUpdate && (empty($response->maxVersionToUpgrade) || version_compare( $thisVersion, $response->maxVersionToUpgrade) == -1);
    if ($response->shouldUpdate) {
      // check specific versions exclusion list
      $response->shouldUpdate = $response->shouldUpdate && !in_array( $thisVersion, $response->excludes);
    }

    // build status message based on result of should update calculation
    $response->statusMessage = $response->shouldUpdate ? JText16::sprintf('COM_SH404SEF_NEW_VERSION_AVAILABLE') : (JText16::sprintf('COM_SH404SEF_YOU_ARE_UP_TO_DATE'));

    // return whatever we found
    return $response;

  }
}