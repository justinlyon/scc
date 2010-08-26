<?php
/**
 *  $Id$: LocalActionDispatcher.php, Jul 3, 2006 4:58:07 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 *    http://www.tachometry.com
 *
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

if (!defined('WEB_INF')) {
   @define('WEB_INF', dirname(__FILE__));
}

require_once WEB_INF . '/base.include.php';

require_once('tachometry/web/BaseDispatcher.php');

class LocalDispatcher extends BaseDispatcher
{
   private $configuration;

   /**
    * Delegates to parent constructor
    */
   function __construct() {
      parent::__construct();
   }

   // Override
   public function getPage($scope)
   {
      global $logger;

      if( $scope == NULL ) {
         $scope = DEFAULT_SCOPE_KEY;
      }
      $cfg = $this->getConfiguration();
      $className = $this->getPrefix() . $cfg[$scope] . 'Page';
      $fileName = WEB_INF . "/pages/$className.php";
      $logger->debug("page scope=$scope class=$className file=$fileName");

      require_once($fileName);
      return new $className;
   }

   // Override
   public function getAction($scope)
   {
      global $logger;
      if( $scope == NULL ) {
         $scope = DEFAULT_SCOPE_KEY;
      }
      $cfg = $this->getConfiguration();
      $className = $this->getPrefix() . $cfg[$scope] . 'Action';
      $fileName = WEB_INF . "/actions/$className.php";
      $logger->debug("\n");
      $logger->debug("action scope=$scope class=$className file=$fileName");

      require_once $fileName;
      return new $className;
   }

   function getConfiguration()
   {
      if (is_null($this->configuration)) {
         $this->initConfiguration();
      }
      return $this->configuration;
   }

   function setConfiguration($cfg)
   {
      $this->configuration = $cfg;
   }

   function getDefaultScopeKey()
   {
      return $this->defaultScopeKey;
   }

   function getPrefix()
   {

   }

   /**
    * Maps scope names to implementation target class prefixes.
    * For each "TargetPrefix", there should be at least two classes:
    *    WEB-INF/actions/[optional/path/to/]TargetPrefixAction(.php)
    *    WEB-INF/pages/[optional/path/to/]TargetPrefixPage(.php)
    *
    * The Action class validates input, calls backend services, etc. and
    * creates an object that is passed to the Page via its "render" method.
    *
    * The Page class renders the result using templates or other view
    * technologies. The given object may include validation errors, etc.
    *
    * If an optional "task" is specified, it is expected to be the name of
    * a method that is implemented in both the Action and Page classes.
    * This method is invoked in lieu of the corresponding "execute" or
    * "render" method. If no such method exists, an error is thrown.
    *
    */
   protected function initConfiguration()
   {
      $cfg = array(
         'exbt'=>'Exhibition',
         'prgm'=>'Program',
         'vnue'=>'Venue',
         'crse'=>'Course',
         'cldr'=>'Calendar',
         'sers'=>'Series',
         'annc'=>'Announcement',
         'gnre'=>'Genre',
         'audc'=>'Audience',
         'home'=>'HomePage',
         'pers'=>'Artist',
      );
      $this->setConfiguration($cfg);
   }
}
?>
