<?php
/**
 *  $Id$: GalleryService.php, Sep 30, 2006 11:52:11 AM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 *
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/

if (!defined('WEB_INF')) {
    @define('WEB_INF', dirname(__FILE__) . '/..');
}
require_once WEB_INF . '/base.include.php';
require_once WEB_INF . '/pdo/model.php';
require_once WEB_INF . '/beans/PublicationState.php';
require_once WEB_INF . '/beans/GalleryAlbum.php';
require_once WEB_INF . '/beans/GalleryImage.php';

require_once ('tachometry/util/BeanUtil.php');
require_once ('tachometry/util/CopyBeanOption.php');

// Use the Gallery2 Bridge as the integration point
require_once (SERVER_BASE_DIR .'/gallery2/embed.php');
require_once (SERVER_BASE_DIR .'/gallery2/lib/smarty_plugins/modifier.markup.php');


/**
 * A service class to serve both as data access facilitator and
 * API contract.  Note the convention that all public getters shall
 * return a bean or array of beans.   The private "fetch" methods
 * will return a PDO object or array of PDO objects.  Clients of
 * the service should only call methods that will return bean objects
 * unless there is valid reason to use the PDO directly.
 */
class GalleryService
{
	public $init;
	public $bbcodeParser;

	//TODO: Refactor these out to preferences
	const IMAGE_SMALL_MARKER = '_sm';
	const IMAGE_MEDIUM_MARKER = '_md';
	const IMAGE_LARGE_MARKER = '_lg';

	// MULTIMEDIA FILES
	const FIRSTFRAME_IMAGE_MARKER = '_mff'; // what string should be used to determine the firstframe image
	const MULTIMEDIA_SMALL = '_msm'; // what string should be used to identify a small multimedia file
	const MULTIMEDIA_LARGE = '_mlg'; // what string should be used to determine a large multimedia file

	const DEFAULT_ALBUM_PATH = 'systemimages/default';
	const CAPTION_FIELD = 'summary'; // which object field should be used for the image caption
	const G2ALBUM_BASE_URL = '../g2data/albums'; // relative to joomla root, where is the g2data/albums folder?
	const PARENT_PROGRAM_ALBUM = "Program";
	const PARENT_COURSE_ALBUM = "Course";
	const PARENT_EXHIBITION_ALBUM = "Exhibition";
	const PARENT_VENUE_ALBUM = "Venue";
	const PARENT_ARTIST_ALBUM = "Artist";
	const CHILD_HIGHLIGHT_ALBUM = "Highlights";

	public function GalleryService()
	{
		global $logger;
		$logger->debug(get_class($this) . "::construct()");
		$this->initGalleryApi();
	}


	/**
	 * Returns an associative array of album ids and names
	 * for the given parent galleryType (e.g. Program, Venue, etc.).
	 * If no parant is given, the child albums to the root node will
	 * be returned.
	 *
	 * @param $string parent (galleryName -- the name of the parent album e.g. Media, Photos)
	 * @return array of GalleryAlbumObject
	 */
	public function getChildAlbums($parent)
	{
		global $logger, $mosConfig_absolute_path;
		$logger->debug(get_class($this) . "::getChildAlbums($parent)");

		$ret = $this->initGalleryApi();
		$parent = trim($parent);

		list($ret, $tree) = GalleryCoreApi::fetchAlbumTree();

		$result = array();
		$branch = null;

		// get the root album
		foreach($tree as $key => $value) {
			list($ret, $album) = GalleryCoreApi::loadEntitiesById($key);

			$aname = trim($album->pathComponent);
			if (!$branch && strtolower($aname) == strtolower($parent) ) {
				$branch = $value; // we have a matching parent, so store the child ids
				break;
			}
		}

		// we found the parent, so get the children
		if ($branch != null) {
			foreach($branch as $key => $value) {
				list($ret, $child) = GalleryCoreApi::loadEntitiesById($key);
				$result[] = $child;
			}
		}
		return $result;
	}


	/**
	 * Returns the thumbnail image for the given album id
	 * checks the first image in the given album
	 *   if the image is a IMAGE_SMALL_MARKER, use it
	 *   else continue through the list
	 *     if the first IMAGE_SMALL_MARKER is the same name as the album, use it
	 *     else store the value for use later
	 *   if end of list is reached with no matching album name, use the first IMAGE_SMALL_MARKER
	 *   if no images are in the album, use the default composite for the given scope
	 *
	 * @param int albumId the album id
	 * @param string size (small, medium, large) optional
	 * @param string scope (for the returning of a default image) optional
	 * @return CompositeImage with only the small DerivativeImage set
	 */
	public function getAlbumThumbnail($albumId, $size='small', $scope= null)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getAlbumThumnail($albumId, $size, $scope)");

  		$ret = $this->initGalleryApi();
  		list ($ret, $album) = GalleryCoreApi::loadEntitiesById($albumId);
		list ($ret, $images) = GalleryCoreApi::fetchChildDataItemIds($album);
		$isSize = 'is'. ucwords($size) .'Image';
		$setter = 'set'. ucwords($size);
		switch($size) {
			case 'large' : $marker = GalleryService::IMAGE_LARGE_MARKER; break;
			case 'medium' : $marker = GalleryService::IMAGE_MEDIUM_MARKER; break;
			case 'small' :
			default : $marker = GalleryService::IMAGE_SMALL_MARKER; break;
		}

		$thumbnail = new CompositeImage();
		$target = new DerivativeImage();

		if ($images > 0) {

			// get the first image
			list ($ret, $first_image) = GalleryCoreApi::loadEntitiesById($images[0]);

			// return if the first image is the target size
			if ($this->$isSize($first_image)) {
				$target = $this->setDerivativeValues($first_image, $target);
			} else {

				// if not, see if we can get the thumbnail by name
				$splitpath = $this->splitPathComponent($first_image->pathComponent);
  				$basename = $splitpath['basename'];
				$spath = $basename . $marker . $splitpath['extension'];

				list($ret, $sizeId) = GalleryCoreApi::fetchChildIdByPathComponent($albumId,$spath);
				if ($sizeId) {
					list($ret,$sizeImage) = GalleryCoreApi::loadEntitiesById($sizeId);
					$target = $this->setDerivativeValues($sizeImage, $target);
				}

				// not by name.  get the first small one
				else {
					foreach($images as $imgid) {
						list ($ret, $image) = GalleryCoreApi::loadEntitiesById($imgid);
						if ($this->$isSize($image)) {
							$target = $this->getDerivativeImage($image, $target);
						}
					}
				}
			}

			$thumbnail->setCompositeValues($target,$thumbnail);
			$thumbnail->$setter($target);
		}
		elseif ($scope) {
			$thumbnail = $this->getDefaultComposite($scope);
		}

		return $thumbnail;
	}

	/**
	 * Returns a list of category names/ids.  If a name is supplied,
	 * will return the list of category names/ids under that category.
	 * NOTE: Categories are synonomous with Albums in certain Gallery
	 * nomenclature.
	 *
	 * @param string the name of the parent category
	 * @return stdClass database row result
	 * @deprecated version - Dec 14, 2006
	 */
	public function getCategories($parent=null)
	{
		global $logger;
		$logger->notice("Calling a depricated method: ". get_class($this) . "::getCategories($parent) please use getChildAlbums()");
		return $this->getChildAlbums($parent);
	}



	/**
	 * Returns the associative array for the first thumbnail image in
	 * the given gallery. If no image is available will return
	 * an empty array.
	 *
	 * @param int The target album id
	 * @return bean ImageBean
	 */
	public function getSummaryImage($albumId)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getSummaryImage($albumId)");
  		return $this->getAlbumThumbnail($albumId);
	}

	/**
	 * Returns an array of Image beans for all images in
	 * the given gallery. If no image is available will return
	 * an empty array.
	 *
	 * @param int The target gallery id
	 * @return array Image bean array
	 */
	public function getImages($albumId)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getImages($albumId)");

  		$ret = $this->initGalleryApi();

  		list ($ret, $album) = GalleryCoreApi::loadEntitiesById($albumId);
		list ($ret, $images) = GalleryCoreApi::fetchChildDataItemIds($album);

		$result = array();
		if ($images > 0) {

			foreach($images as $imageId) {
				$ib = new ImageBean();
				list ($ret, $image) = GalleryCoreApi::loadEntitiesById($imageId);

				if (!strstr($image->getPathComponent(), GalleryService::SUMMARY_IMAGE_MARKER) && strstr($image->getMimeType(),'image')) {

					$captionGetter = "get". ucfirst(GalleryService::CAPTION_FIELD);
					$ib->setCaption($image->$captionGetter());
					$ib->setTitle($image->getTitle());
					$ib->setDescription($image->getDescription());
					$ib->setUrl($this->getElementUrl($imageId));
					$result[] = $ib;
				}
			}
		}
		return $result;

	}

	/**
	 * Returns a complete packaged album for the given
	 * gallery id
	 * @param Int albumId
	 * @return GalleryAlbum
	 */
	function getPackagedAlbum($albumId)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getPackagedAlbum($albumId)");

		$album = new GalleryAlbum();
		$this->initGalleryApi();

		list ($ret, $parent) = GalleryCoreApi::loadEntitiesById($albumId);
		if ($parent && $parent->canContainChildren) {
		    list ($ret, $children) = GalleryCoreApi::fetchChildDataItemIds($parent);

		    $images = array();
		    if ($children) {
			$found = array(); // holds the ids of already packaged images so we don't repeat it
			foreach ($children as $imageId) {
				if(!in_array($imageId, $found)) {
					$image = $this->getCompositeImage($imageId);
					if ($image) {
						$found[] = ($image->getSmall()) ? $image->getSmall()->getId() : null;
						$found[] = ($image->getMedium()) ? $image->getMedium()->getId() : null;
						$found[] = ($image->getLarge()) ? $image->getLarge()->getId() : null;
					}
					$images[] = $image;
				}
			}
		    }

		    $album = $this->setAlbumValues($parent, $album);
		    $album->setImages($images);
		}
		return $album;
	}

	/**
	 * Returns the GalleryAlbum for title information with
	 * one Composite representing the highlighted image
	 * @param imageId
	 * @return GalleryAlbum
	 */
	function getPackagedImage($imageId)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getPackagedImage($imageId)");
		$album = $this->getParentAlbum($imageId);
		$image = $this->getCompositeImage($imageId);
		$album->setImages(array($image));
		return $album;
	}

	/**
	 * Returns the GalleryAlbum object for the
	 * given imageid
	 * @int imageId
	 * @return GalleryAlbum
	 */
	function getParentAlbum($imageId)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getParentAlbum($imageId)");

  		$album = new GalleryAlbum();
  		$ret = $this->initGalleryApi();
		list($ret,$image) = GalleryCoreApi::loadEntitiesById($imageId);

		if ($image) {
			list($ret,$parent) = GalleryCoreApi::loadEntitiesById($image->parentId);
		}

		if ($parent) {
			$album = $this->setAlbumValues($parent, $album);
		}
		return $album;
	}

	/**
	* Returns the Highlights GalleryAlbum object for the given
	* parent album id
	* @param int album id of the parent album
	* @return GalleryAlbum of the child hightlights album (empty GalleryAlbum if exception)
	*/
	function getHighlightsAlbum($albumId) 
	{
		global $logger;
		$logger->debug(get_class($this) ."::getHighlightsAlbum($albumId)");
		$hlAlbum = new galleryAlbum();

		list ($ret, $parent) = GalleryCoreApi::loadEntitiesById($albumId);
                list ($ret, $childIds) = GalleryCoreApi::fetchChildAlbumItemIds($parent);
		if ($childIds) {
			list ($ret, $child) = GalleryCoreApi::loadEntitiesById($childIds[0]);

			$hlAlbum = $this->getPackagedAlbum($child->getId());
		}
		return $hlAlbum;
	}
	

	/**
	 * Returns the CompositeImage for a given image id.
	 * will determine the naming convention for the given
	 * file, then get the other versions
	 *
	 * @param imageId
	 * @return CompositeImage
	 */
	function getCompositeImage($imageId)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getCompositeImage($imageId)");

  		$ci = new CompositeImage();
  		$ret = $this->initGalleryApi();
  		list ($ret, $baseimage) = GalleryCoreApi::loadEntitiesById($imageId);

  		// get the other images
  		if ($baseimage) {
	  		$splitpath = $this->splitPathComponent($baseimage->pathComponent);
	  		$basename = $splitpath['basename'];
	  		$ci->setBasename($basename);
	  		$spath = $basename . GalleryService::IMAGE_SMALL_MARKER . $splitpath['extension'];
	  		$mpath = $basename . GalleryService::IMAGE_MEDIUM_MARKER . $splitpath['extension'];
	  		$lpath = $basename . GalleryService::IMAGE_LARGE_MARKER . $splitpath['extension'];

	 		list($ret, $smallId) = GalleryCoreApi::fetchChildIdByPathComponent($baseimage->parentId,$spath);
	 		list($ret, $mediumId) = GalleryCoreApi::fetchChildIdByPathComponent($baseimage->parentId,$mpath);
	 		list($ret, $largeId) = GalleryCoreApi::fetchChildIdByPathComponent($baseimage->parentId,$lpath);

	 		list ($ret, $small) = GalleryCoreApi::loadEntitiesById($smallId);
	 		list ($ret, $medium) = GalleryCoreApi::loadEntitiesById($mediumId);
	 		list ($ret, $large) = GalleryCoreApi::loadEntitiesById($largeId);

	 		$ci->setSmall($this->setDerivativeValues($small));
	 		$ci->setMedium($this->setDerivativeValues($medium));
	 		$ci->setLarge($this->setDerivativeValues($large));

	 		// check to see which image has the title, etc. (assume large, medium, then small)
	 		if ($large) {
	 			$useImage = $large;
	 		} elseif ($medium) {
	 			$useImage = $medium;
	 		} else {
	 			$useImage = $small;
	 		}

	 		$ci = $this->setCompositeValues($useImage, $ci);
  		}
 		return $ci;
	}


	/**
	 * Returns the deault composite image for the given
	 * default type
	 * @param string default type (Exhibition, Program, Genre, etc.)
	 * @return CompositeImage
	 */
	function getDefaultComposite($type)
	{
		global $logger;
  		$logger->debug(get_class($this) . "::getDefaultComposite($type)");

		$ci = new CompositeImage();
		$folders = preg_split("/\//", GalleryService::DEFAULT_ALBUM_PATH);
		$parent = $this->getChildAlbums($folders[0]);

		$albumid = null;
		foreach($parent as $child) {
			if (strtolower($child->title) ==  strtolower($folders[1])) {
				$albumid = $child->id;
				break;
			}
		}
		if ($albumid) {
			$pathname = strtolower($type) .'_default_lg.jpg';
			list($ret, $current) = GalleryCoreApi::fetchChildIdByPathComponent($albumid,$pathname);
			$ci = $this->getCompositeImage($current);
		}
		return $ci;
	}


	/**
	 * creates a DerivativeImage object and sets the appropriate values from the
	 * incoming gallery2 image object
	 * @param GalleryImage source
	 * @param DerivativeImage target (optional)
	 * @return DerivativeImage
	 */
	function setDerivativeValues($source, $target=null)
	{
		$di = ($target) ? $target : new DerivativeImage();
		if ($source) {
			$di->setId($source->id);
			$di->setUrl($this->getElementUrl($source->id));
			$di->setWidth($source->width);
			$di->setHeight($source->height);
			$di->setSize($source->size);
		}
		return $di;
	}

	/**
	 * Copies the appropriate values from the GalleryImage to
	 * the given CompositeImage
	 * @param GalleryImage source
	 * @param CompositeImage target (optional)
	 * @return CompositeImage
	 */
	function setCompositeValues($source, $target=null)
	{
		$ci = ($target) ? $target : new CompositeImage();
		$bb = $this->getBBCodeParser();
		if ($source) {
			$ci->setTitle($bb->parse($source->title));
			$ci->setParent($source->parentId);
			$ci->setSummary($bb->parse($source->summary));
			$ci->setKeywords($source->keywords);
			$ci->setDescription($bb->parse($source->description));
			$ci->setMimeType($source->mimeType);
		}
		return $ci;
	}

	/**
	 * Copies the appropriate values from the Gallery 2 Album
	 * to the GalleryAlbum
	 * @param GalleryAlbumObject source
	 * @param GalleryAlbum target (optional)
	 * @return GalleryAlbum (without images)
	 */
	function setAlbumValues($source, $target=null)
	{
		$ga = ($target) ? $target : new GalleryAlbum();

		if ($source) {
			$ga->setId($source->id);
			$ga->setTitle($source->title);
			$ga->setParent($source->parentId);
			$ga->setUrl($this->getElementUrl($source->id));
		}
		return $ga;
	}

	/**
	 * Returns the fully populated image (w/ derivitive thumbnail / home)
	 * for the given id
	 * @param int id
	 * @return GalleryImage bean
	 */
	function getImageById($id)
	{
		return $this->getCompositeImage($id);
	}


	/**
	 * returns the file name with all size markers removed
	 * @string string pathComponent
	 * @return array('basename','marker','extension')
	 */
	function splitPathComponent($pathComponent)
	{
		$splitpath = array();
		$extension = preg_split("/\./", $pathComponent);
		$splitpath['extension'] = ".".$extension[1];

		$underscores = preg_split("/_/", $extension[0]);
		$last = count($underscores) - 1;
		$mark = "_". $underscores[$last];
		$splitpath['marker'] = '';
		if ($mark == GalleryService::IMAGE_SMALL_MARKER || $mark == GalleryService::IMAGE_MEDIUM_MARKER || $mark == GalleryService::IMAGE_LARGE_MARKER ) {
			$splitpath['marker'] = "_".array_pop($underscores);
		}
		$splitpath['basename'] = implode("_", $underscores);
		return $splitpath;
	}

	/**
	 * Creates a new gallery/album under the given
	 * parent album.  The name/title and description
	 * will be keyed off of the given event object.
	 *
	 * @param string $parentAlbum
	 * @param Event or Person $bean
	 * @param string $name a title to specify (optional -- will use getTitle if not specified)
	 * @return int id of the created/found album or null if not created
	 */
	public function createAlbum($parent, $bean, $name=null)
	{
		global $mosConfig_absolute_path, $gallery;

		global $logger;
  		$logger->debug(get_class($this) . "::createAlbum($parent, $bean, $name)");

		$parentId = null;
		if ($name) {
			$pathname = strtolower(preg_replace("/ /",'_',$name));
			$title = $name;
		} else {
			$pathname = strtolower(preg_replace("/ /",'_',$bean->getTitle()));
			$title = $bean->getTitle();
		}
		$summary = '';
		$description = '';
		$keywords = '';
		$albumId = null;

		// get the parent album id
		$ret = $this->initGalleryApi();
		list($ret, $tree) = GalleryCoreApi::fetchAlbumTree();
		$name = constant("GalleryService::PARENT_". strtoupper($parent) ."_ALBUM");
		$logger->debug("Looking for Parent Album Name:". $name);

		foreach($tree as $key => $value) {
			list($ret, $album) = GalleryCoreApi::loadEntitiesById($key);
			if (strtolower($album->getPathComponent()) == strtolower($name) ) {
				$parentId = $key; // we have a matching parent
				break;
			}
		}
		$logger->debug("Found Parent Album ID:". $parentId);

		// see if there is already an album by path
		list($ret, $current) = GalleryCoreApi::fetchChildIdByPathComponent($parentId,$pathname);
		if ($current) {
			$albumId = $current;
		} else {
			// create the new album
  			list($ret,$created) = GalleryCoreApi::createAlbum($parentId,$pathname,$title,$summary,$description,$keywords);
			$albumId = ($created) ? $created->getId() : '';

			// now create the child highlight album
			if ($albumId) {
				list($ret,$hlCreated) = GalleryCoreApi::createAlbum($albumId,strtolower(CHILD_HIGHLIGHT_ALBUM),CHILD_HIGHTLIGHT_ALBUM,$summary,$description,$keywords);
				$highlightId = ($hlCreated) ? $hlCreated->getId() : "";
			}
		}
		$logger->debug("Created album with id: ". $albumId ." and highlights id: ". $highlightId);

		/* Complete our transaction */
	    if ($gallery->isStorageInitialized()) {
			$storage =& $gallery->getStorage();
			$ret = $storage->commitTransaction();
	    }

  		return $albumId;
	}



	/**
	 * Returns the fully-qualified URL for the given image resource
	 *
	 * @param int $elementId
	 * @return string
	 */
	function getElementUrl($elementId)
	{
		global $mosConfig_live_site;

		$path = $mosConfig_live_site . GalleryService::G2ALBUM_BASE_URL;
		$parents = GalleryCoreApi::fetchParentSequence($elementId);

 		if (isset($parents[1])) {
	  		foreach ($parents[1] as $nodeId) {
	  			$node = GalleryCoreApi::loadEntitiesById($nodeId);
	  			$comp = $node[1]->getPathComponent();

	  			if ($comp != '') {
	  				$path .= "/". $comp;
	  			}
	  		}
 		}
  		$self = GalleryCoreApi::loadEntitiesById($elementId);
  		$path .= "/". $self[1]->getPathComponent();

  		return $path;
	}



	/**
	 * Determine if the given element is a small image
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isSmallImage($image) {
		return (strstr($image->pathComponent, GalleryService::IMAGE_SMALL_MARKER) && strstr($image->mimeType,'image'));
	}

	/**
	 * Determine if the given element is a medium image
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isMediumImage($image) {
		return (strstr($image->pathComponent, GalleryService::IMAGE_MEDIUM_MARKER) && strstr($image->mimeType,'image'));
	}

	/**
	 * Determine if the given element is a large image
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isLargeImage($image) {
		return (strstr($image->pathComponent, GalleryService::IMAGE_LARGE_MARKER) && strstr($image->mimeType,'image'));
	}







	/**
	 * Determine if the given element is a thumbnail image
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isThumbnail($image) {
		return (strstr($image->pathComponent, GalleryService::THUMBNAIL_IMAGE_MARKER) && strstr($image->mimeType,'image'));
	}

	/**
	 * Determine if the given element is a homepage image
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isHome($image) {
		return (strstr($image->pathComponent, GalleryService::HOMEPAGE_IMAGE_MARKER) && strstr($image->mimeType,'image'));
	}

	/**
	 * Determine if the given element is a download image
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isDownload($image) {
		return (strstr($image->pathComponent, GalleryService::DOWNLOAD_IMAGE_MARKER) && strstr($image->mimeType,'image'));
	}

    /**
	 * Determine if the given element is a download image
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isFirstframe($image) {
		return (strstr($image->pathComponent, GalleryService::FIRSTFRAME_IMAGE_MARKER) && strstr($image->mimeType,'image'));
	}

	/**
	 * Determine if the given element is a multimedia file
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isMultimedia($image) {
		return (strstr($image->mimeType,'flv'));
	}

	/**
	 * Determine if the given element is a large file
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isLarge($image) {
		return (strstr($image->pathComponent, GalleryService::MULTIMEDIA_LARGE));
	}

	/**
	 * Determine if the given element is a large file
	 * @param GalleryItem
	 * @return boolean
	 **/
	function isSmall($image) {
		return (strstr($image->pathComponent, GalleryService::MULTIMEDIA_SMALL));
	}

	/**
	 * Returns the formatted date for the given element and usedate value
	 *
	 * @param GalleryItem
	 * @param string usedate (e.g. created, modified)
	 * @return String formatted date (e.g. May 7, 2007)
	 */
	public function formatDate($element, $usedate, $format=null) {

		$format = $format ? $format : "F j, Y";

		$date = null;
		if ($element) {
			$date = ($usedate == 'created') ? $element->creationTimestamp : $element->modificationTimestamp;
		}
		return ($date) ? date($format, $date) : '';
	}

	/**
	 * Builds the generic initialization of the Gallery2 integration
	 * @return status object
	 */
	private function initGalleryApi()
	{
		global $logger;
  		//$logger->debug(get_class($this) . "::initGalleryApi()");

		$emAppUserId = 'embed';
        $ret = GalleryEmbed::init(array( 'activeUserId' => $emAppUserId,
			                                 'fullInit' => true
			                               ));

		  	if ($ret) {
		  	  print "An error occurred when initing<br>";
		     	  print $ret->getAsHtml();
		          exit;
			}
			$this->init = true;

	}

	/**
	 * Gets the BBCODE Parser
	 */
	function getBBCodeParser()
	{
		if (!$this->bbcodeParser) {
			$this->bbcodeParser = new GalleryBbcodeMarkupParser();
		}
		return $this->bbcodeParser;
	}


 }
?>
