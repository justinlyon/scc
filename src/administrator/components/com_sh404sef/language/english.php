<?php

//
// Copyright (C) 2004 W.H.Welch
// All rights reserved.
//
// This source file is part of the 404SEF Component, a Mambo 4.5.1
// custom Component By W.H.Welch - http://sef404.sourceforge.net/
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// Please note that the GPL states that any headers in files and
// Copyright notices as well as credits in headers, source files
// and output (screens, prints, etc.) can not be removed.
// You can extend them with your own credits, though...
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Additions by Yannick Gaultier (c) 2006-2010
// Dont allow direct linking

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

define('COM_SH404SEF_404PAGE','404 Page');
define('COM_SH404SEF_ADD','Add');
define('COM_SH404SEF_ADDFILE','Default index file.');
define('COM_SH404SEF_ASC',' (asc) ');
define('COM_SH404SEF_BACK','Back to sh404SEF Control Panel');
define('COM_SH404SEF_BADURL','The Non-SEF Url must begin with index.php');
define('COM_SH404SEF_CHK_PERMS','Please check your file permissions and ensure that that this file can be read.');
define('COM_SH404SEF_CONFIG','sh404SEF<br/>Configuration');
define('COM_SH404SEF_CONFIG_DESC','Configure main sh404SEF functionalities. After changing settings on this page, you will most likely need to purge the SEF urls database, so that new urls are recreated in accordance with the new parameters you now use. This is done from the URL manager.');
define('COM_SH404SEF_CONFIG_UPDATED','Configuration updated');
define('COM_SH404SEF_CONFIRM_ERASE_CACHE', 'Do you want to clear the URL cache ? This is highly recommended after changing configuration. To generate again the cache, you should browse again your homepage, or better : generate a sitemap for your site.');
define('COM_SH404SEF_COPYRIGHT','Copyright');
define('COM_SH404SEF_DATEADD','Date Added');
define('COM_SH404SEF_DEBUG_DATA_DUMP','DEBUG DATA DUMP COMPLETE: Page Load Terminated');
define('COM_SH404SEF_DEF_404_MSG','<h1>Bad karma: we can\'t find that page!</h1>
<p>You asked for <strong>{%sh404SEF_404_URL%}</strong>, but despite our computers looking very hard, we could not find it. What happened ?</p>
<ul>
<li>the link you clicked to arrive here has a typo in it</li>
<li>or somehow we removed that page, or gave it another name</li>
<li>or, quite unlikely for sure, maybe you typed it yourself and there was a little mistake ?</li>
</ul>
<h4>{sh404sefSimilarUrlsCommentStart}It\'s not the end of everything though : you may be interested in the following pages on our site:{sh404sefSimilarUrlsCommentEnd}</h4>
<p>{sh404sefSimilarUrls}</p>
<p> </p>');
define('COM_SH404SEF_DEF_404_PAGE','Default 404 Page');
define('COM_SH404SEF_DESC',' (desc) ');
define('COM_SH404SEF_DISABLED',"<p class='error'>NOTE: SEF support in Joomla is currently disabled. To use SEF, please enable it from the <a href='".$GLOBALS['shConfigLiveSite']."/administrator/index.php?option=com_config'>Global Configuration</a> SEO page.</p>");
define('COM_SH404SEF_EDIT','Edit');
define('COM_SH404SEF_EMPTYURL','You must provide a URL for the redirection.');
define('COM_SH404SEF_ENABLED','Enabled');
define('COM_SH404SEF_ERROR_IMPORT','Error while importing:');
define('COM_SH404SEF_EXPORT','Backup Custom URLS');
define('COM_SH404SEF_EXPORT_FAILED','EXPORT FAILED!!!');
define('COM_SH404SEF_FATAL_ERROR_HEADERS','FATAL ERROR: HEADER ALREADY SENT');
define('COM_SH404SEF_FRIENDTRIM_CHAR','Trim friendly characters');
define('COM_SH404SEF_HELP','sh404SEF<br/>Support');
define('COM_SH404SEF_HELPDESC','Need help with sh404SEF?');
define('COM_SH404SEF_HELPVIA','<b>Help is availible via the following forums:</b>');
define('COM_SH404SEF_HIDE_CAT','Hide Category');
define('COM_SH404SEF_HITS','Hits');
define('COM_SH404SEF_IMPORT','Import Custom URLS');
define('COM_SH404SEF_IMPORT_EXPORT','Import/Export URLS');
define('COM_SH404SEF_IMPORT_OK','Custom URLS were successfully imported!');
define('COM_SH404SEF_INFO','sh404SEF Documentation');
define('COM_SH404SEF_INFODESC','View sh404SEF Project Summary and Documentation');
define('COM_SH404SEF_INSTALLED_VERS','Installed version:');
define('COM_SH404SEF_INVALID_SQL','INVALID DATA IN SQL FILE :');
define('COM_SH404SEF_INVALID_URL','INVALID URL: this link requires a valid Itemid, but one was not found.<br/>SOLUTION: Create a menuitem for this item. You do not have to publish it, just create it.');
define('COM_SH404SEF_LICENSE','License');
define('COM_SH404SEF_LOWER','All lowercase');
define('COM_SH404SEF_MAMBERS','Mambers Forum');
define('COM_SH404SEF_NEWURL','non-SEF Url');
define('COM_SH404SEF_NO_UNLINK','Unable to remove uploaded file from media directory');
define('COM_SH404SEF_NOACCESS','Unable to access');
define('COM_SH404SEF_NOCACHE','nocache');
define('COM_SH404SEF_NOLEADSLASH','The should be NO LEADING SLASH on the New SEF URL');
define('COM_SH404SEF_NOREAD','FATAL ERROR: Unable to read file ');
define('COM_SH404SEF_NORECORDS','No records found.');
define('COM_SH404SEF_OFFICIAL','Official Project Forum');
define('COM_SH404SEF_OK',' OK ');
define('COM_SH404SEF_OLDURL','New SEF URL');
define('COM_SH404SEF_PAGEREP_CHAR','Page spacer character');
define('COM_SH404SEF_PAGETEXT','Page text');
define('COM_SH404SEF_PROCEED',' Proceed ');
define('COM_SH404SEF_PURGE404','Purge<br/>404 Logs');
define('COM_SH404SEF_PURGE404DESC','Purge 404 Logs');
define('COM_SH404SEF_PURGECUSTOM','Purge<br/>Custom Redirects');
define('COM_SH404SEF_PURGECUSTOMDESC','Purge Custom Redirects');
define('COM_SH404SEF_PURGEURL','Purge<br/>SEF Urls');
define('COM_SH404SEF_PURGEURLDESC','Purge SEF Urls');
define('COM_SH404SEF_REALURL','Real Url');
define('COM_SH404SEF_RECORD',' record');
define('COM_SH404SEF_RECORDS',' records');
define('COM_SH404SEF_REPLACE_CHAR','Replacement character');
define('COM_SH404SEF_SAVEAS','Save as Custom Redirect');
define('COM_SH404SEF_SEFURL','SEF Url');
define('COM_SH404SEF_SELECT_DELETE','Select an item to delete');
define('COM_SH404SEF_SELECT_FILE','Please select a file first');
define('COM_SH404SEF_ACTIVATE_IJOOMLA_MAG', 'Activate iJoomla magazine in content');
define('COM_SH404SEF_ADV_INSERT_ISO', 'Insert ISO code');
define('COM_SH404SEF_ADV_MANAGE_URL', 'URL procssing');
define('COM_SH404SEF_ADV_TRANSLATE_URL', 'Translate URL');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID', 'Always append Itemid to SEF URL');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX', 'menu id');
define('COM_SH404SEF_ALWAYS_INSERT_MENU_TITLE', 'Always insert menu title');
define('COM_SH404SEF_CACHE_TITLE', 'Cache management');
define('COM_SH404SEF_CAT_TABLE_SUFFIX', 'Table');
define('COM_SH404SEF_CB_INSERT_NAME', 'Insert Community Builder name');
define('COM_SH404SEF_CB_INSERT_USER_ID', 'Insert user ID');
define('COM_SH404SEF_CB_INSERT_USER_NAME', 'Insert user name');
define('COM_SH404SEF_CB_NAME', 'Default CB name');
define('COM_SH404SEF_CB_TITLE', 'Community Builder configuration ');
define('COM_SH404SEF_CB_USE_USER_PSEUDO', 'Insert user pseudo');
define('COM_SH404SEF_CONF_TAB_ADVANCED', 'Advanced');
define('COM_SH404SEF_CONF_TAB_BY_COMPONENT', 'By component');
define('COM_SH404SEF_CONF_TAB_MAIN', 'Main');
define('COM_SH404SEF_CONF_TAB_PLUGINS', 'Plugins');
define('COM_SH404SEF_DEFAULT_MENU_ITEM_NAME', 'Default menu title');
define('COM_SH404SEF_DO_NOT_INSERT_LANGUAGE_CODE','Do not insert code');
define('COM_SH404SEF_DO_NOT_OVERRIDE_SEF_EXT', 'Use component or core plugin');
define('COM_SH404SEF_OVERRIDE_SEF_EXT', 'Use sh404sef plugin if available');
define('COM_SH404SEF_DO_NOT_TRANSLATE_URL','Do not translate');
define('COM_SH404SEF_ENCODE_URL', 'Encode URL');
define('COM_SH404SEF_FB_INSERT_CATEGORY_ID', 'Insert category ID');
define('COM_SH404SEF_FB_INSERT_CATEGORY_NAME', 'Insert category name');
define('COM_SH404SEF_FB_INSERT_MESSAGE_ID', 'Insert post ID');
define('COM_SH404SEF_FB_INSERT_MESSAGE_SUBJECT', 'Insert post subject');
define('COM_SH404SEF_FB_INSERT_NAME', 'Insert Kunena name');
define('COM_SH404SEF_FB_NAME', 'Default Kunena Name');
define('COM_SH404SEF_FB_TITLE', 'Kunena Configuration ');
define('COM_SH404SEF_FILTER', 'Filter');
define('COM_SH404SEF_FORCE_NON_SEF_HTTPS', 'Force non sef if HTTPS');
define('COM_SH404SEF_GUESS_HOMEPAGE_ITEMID', 'Guess Itemid on homepage');
define('COM_SH404SEF_IJOOMLA_MAG_NAME', 'Default magazine name');
define('COM_SH404SEF_IJOOMLA_MAG_TITLE', 'iJoomla Magazine configuration');
define('COM_SH404SEF_INSERT_GLOBAL_ITEMID_IF_NONE', 'Insert menu Itemid if none');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Insert article id in URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ISSUE_ID', 'Insert issue id in URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Insert magazine id in URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_NAME', 'Insert magazine name in URL');
define('COM_SH404SEF_INSERT_LANGUAGE_CODE', 'Insert language code in URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID', 'Insert numerical id in URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_ALL_CAT', 'All categories');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST', 'Apply to which categories');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE', 'Unique ID');
define('COM_SH404SEF_INSERT_PRODUCT_ID', 'Insert product ID in URL');
define('COM_SH404SEF_INSERT_TITLE_IF_NO_ITEMID', 'Insert menu title if no Itemid');
define('COM_SH404SEF_ITEMID_TITLE', 'Itemid management');
define('COM_SH404SEF_LETTERMAN_DEFAULT_ITEMID', 'Default Itemid for Letterman page');
define('COM_SH404SEF_LETTERMAN_TITLE', 'Letterman configuration ');
define('COM_SH404SEF_LIVE_SECURE_SITE', 'SSL secure URL');
define('COM_SH404SEF_LOG_404_ERRORS', 'Log 404 errors');
define('COM_SH404SEF_MAX_URL_IN_CACHE', 'Cache size');
define('COM_SH404SEF_REDIR_404', '404');
define('COM_SH404SEF_REDIR_CUSTOM', 'Custom');
define('COM_SH404SEF_REDIR_SEF', 'SEF');
define('COM_SH404SEF_REDIR_TOTAL', 'Total');
define('COM_SH404SEF_REDIRECT_JOOMLA_SEF_TO_SEF', '301 redirect from JOOMLA SEF to sh404SEF');
define('COM_SH404SEF_REDIRECT_NON_SEF_TO_SEF', '301 redirect from non-sef to sef URL');
define('COM_SH404SEF_REPLACEMENTS', 'Character replacements list');
define('COM_SH404SEF_SHOP_NAME', 'Default shop name');
define('COM_SH404SEF_TRANSLATE_URL', 'Translate URL');
define('COM_SH404SEF_TRANSLATION_TITLE', 'Translation management');
define('COM_SH404SEF_USE_URL_CACHE', 'Activate URL cache');
define('COM_SH404SEF_VM_ADDITIONAL_TEXT', 'Additionnal text');
define('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES', 'None');
define('COM_SH404SEF_VM_INSERT_CATEGORIES', 'Insert categories');
define('COM_SH404SEF_VM_INSERT_CATEGORY_ID', 'Insert category ID in URL');
define('COM_SH404SEF_VM_INSERT_FLYPAGE', 'Insert flypage name');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_ID', 'Insert manufacturer ID');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_NAME', 'Insert manufacturer name in URL');
define('COM_SH404SEF_VM_INSERT_SHOP_NAME', 'Insert shop name in URL');
define('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES', 'All nested categories');
define('COM_SH404SEF_VM_SHOW_LAST_CATEGORY', 'Only last one');
define('COM_SH404SEF_VM_TITLE', 'Virtuemart configuration');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU', 'Use product SKU for name');
define('COM_SH404SEF_SHOW_CAT', 'Show Category');
define('COM_SH404SEF_SHOW_SECT','Show Section');
define('COM_SH404SEF_SHOW0','Show SEF Urls');
define('COM_SH404SEF_SHOW1','Show 404 Log');
define('COM_SH404SEF_SHOW2','Show Custom Redirects');
define('COM_SH404SEF_SKIP','skip');
define('COM_SH404SEF_SORTBY','Sort by:');
define('COM_SH404SEF_STRANGE','Something strange has occured. This should not happen<br />');
define('COM_SH404SEF_STRIP_CHAR','Strip characters');
define('COM_SH404SEF_SUCCESSPURGE','Successfully purged records');
define('COM_SH404SEF_SUFFIX','File suffix');
define('COM_SH404SEF_SUPPORT','Support<br/>WebSite');
define('COM_SH404SEF_SUPPORT_404SEF','Support us');
define('COM_SH404SEF_SUPPORTDESC','Connect to the sh404SEF website (new window)');
define('COM_SH404SEF_TITLE_ADV','Advanced Component Configuration');
define('COM_SH404SEF_TITLE_BASIC','Basic Configuration');
define('COM_SH404SEF_TITLE_CONFIG','sh404SEF Configuration');
define('COM_SH404SEF_TITLE_MANAGER','sh404SEF URL Manager');
define('COM_SH404SEF_TITLE_PURGE','sh404SEF Purge Database');
define('COM_SH404SEF_TITLE_SUPPORT','sh404SEF Support');
define('COM_SH404SEF_TT_404PAGE','Select the article that will be displayed as an error page in case of \'Page not found\' error.<br />You can use any \'Uncategorized\' article. The default one, provided by sh404sef, can be edited on next tab. You can also find it amongst Joomla!\'s regular Uncategorized articles, under the name __404__. It can equally be modified from Joomla!\'s article list. <br/>Beware that in any case the selected article must be <strong>published</strong>!');
define('COM_SH404SEF_TT_ADDFILE','File name to place after a blank url / when no file exists.  Useful for bots that crawl your site looking for a specific file in that place but returns a 404 because there is none there.');
define('COM_SH404SEF_TT_ADV','<b>use default handler</b><br/>process normally, if an SEF Advanced extension is present it will be used instead. <br/><b>nocache</b><br/>do not store in DB and create old style SEF URLs<br/><b>skip</b><br/>do not make SEF urls for this component<br/>');
define('COM_SH404SEF_TT_ADV4','Advanced Options for ');
define('COM_SH404SEF_TT_ENABLED','If set to No the default SEF for Joomla will be used');
define('COM_SH404SEF_TT_FRIENDTRIM_CHAR','Characters to trim from around the URL, separate with |. Warning: if you change this from its default value, make sure to not leave it empty. At least use a space. Due to a small bug in Joomla, this cannot be left empty.');
define('COM_SH404SEF_TT_LOWER','Convert all characters to lowercase characters in the URL','All lowercase');
define('COM_SH404SEF_TT_NEWURL','This URL must begin with index.php');
define('COM_SH404SEF_TT_OLDURL','Only relative redirection from the Joomla root <i>without</i> a the leading slash');
define('COM_SH404SEF_TT_PAGEREP_CHAR','Character to use to space page numbers away from the rest of the URL');
define('COM_SH404SEF_TT_PAGETEXT','Text to append to url for multiple pages. Use %s to insert page number, by default it will be at end. If a suffix is defined, it will be added to the end of this string.');
define('COM_SH404SEF_TT_REPLACE_CHAR','Character to use to replace unknown characters in URL');
define('COM_SH404SEF_TT_ACTIVATE_IJOOMLA_MAG', 'If set to <strong>Yes</strong>, the ed parameter if passed to the com_content component will be interpreted as the iJoomla magazine edition id.');
define('COM_SH404SEF_TT_ADV_INSERT_ISO', 'For each component installed, and if your site is multi-lingual, choose to insert or not the target language ISO code in the SEF URL. For instance : www.monsite.com/<b>fr</b>/introduction.html. fr stands for french. This code will not be inserted in default language URL.');
define('COM_SH404SEF_TT_ADV_MANAGE_URL', 'For each component installed:<br /><b>use default handler</b><br/>process normally, if an SEF Advanced extension is present it will be used instead. <br/><b>nocache</b><br/>do not store in DB and create old style SEF URLs<br/><b>skip</b><br/>do not make SEF urls for this component<br/>');
define('COM_SH404SEF_TT_ADV_OVERRIDE_SEF', 'Some components come with their own sef_ext files intended for use with Joomla SEF, OpenSEF or SEF Advanced. If this parameter is on (Override sef_ext), this extension file will not be used, and sh404SEF own plugin will be used instead (assuming there is one for that particular component). If not, then the component&rsquo;s own sef_ext file will be used.');
define('COM_SH404SEF_TT_ADV_TRANSLATE_URL', 'For each component installed, select if URL should be translated. No effect if site has only one language.');
define('COM_SH404SEF_TT_ALWAYS_INSERT_ITEMID', 'If set to yes, the non-sef Itemid (or the current menu item Itemid if none is set in the non-sef URL) will be appended to the SEF URL. This should be used instead of Always insert menu title parameter, if you have several menu items with the same title (as if one in main menu and one in top menu for instance)');
define('COM_SH404SEF_TT_ALWAYS_INSERT_MENU_TITLE', 'If set to yes, the menu item title corresponding to the Itemid set up in the non-sef URL, or the current menu item title if no Itemid is set, will be inserted in the SEF URL.');
define('COM_SH404SEF_TT_CB_INSERT_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to Community Builder main page will be prepended to all CB SEF URL');
define('COM_SH404SEF_TT_CB_INSERT_USER_ID', 'If set to <strong>Yes</strong>, user ID will be prepended to its name <strong>whe previous option is also set to Yes</strong>, just in case two users have the same name.');
define('COM_SH404SEF_TT_CB_INSERT_USER_NAME', 'If set to <strong>Yes</strong>, user name will be inserted into SEF URLs. <strong>WARNING</strong>: this can lead to substantial increase in database size, and can slow down site, if you have many registered users. If set to No, the user id will be used instead, using regular format : ..../send-user-email.html?user=245');
define('COM_SH404SEF_TT_CB_NAME', 'When the previous parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance.');
define('COM_SH404SEF_TT_CB_USE_USER_PSEUDO', 'If set to <strong>Yes</strong>, the user pseudo will be inserted in SEF URL, if you have activated this option above, instead of its actual name.');
define('COM_SH404SEF_TT_DEFAULT_MENU_ITEM_NAME', 'When the above parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance');
define('COM_SH404SEF_TT_ENCODE_URL', 'If set to Yes, URL will be encoded so as to be compatible with languages having non-latin characters. Encoded URL will look like : mysite.com/%34%56%E8%67%12.....');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_ID', 'If set to <strong>Yes</strong>, category ID will be prepended to its name <strong>whe previous option is also set to Yes</strong>, just in case two categories have the same name.');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME', 'If set to Yes, the  category name will be inserted into all SEF links to a post or a category');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID', 'If set to <strong>Yes</strong>, each post ID will be prepended to its subject <strong>whe previous option is also set to Yes</strong>, just in case two posts have the same subject.');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_SUBJECT', 'If set to <strong>Yes</strong>, each post subject will be inserted in the SEF url leading to this post ');
define('COM_SH404SEF_TT_FB_INSERT_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to Kunena main page will be prepended to all Kunena SEF URL');
define('COM_SH404SEF_TT_FB_NAME', 'If set to <strong>yes<strong>, Kunena name (as defined by Kunena menu item title) will allways be prepended to SEF URL.');
define('COM_SH404SEF_TT_FORCE_NON_SEF_HTTPS', 'If set to Yes, URL will be forced to non sef after switching to SSL mode(HTTPS). This allows operation with some shared SSL servers causing problems otherwise.');
define('COM_SH404SEF_TT_GUESS_HOMEPAGE_ITEMID', 'If set to yes, and on homepage only, Itemid of com_content URLs will be removed and replaced by the one sh404SEF guestimates. This is useful when some content elements can be viewed on the frontpage (in blog view for instance), and also on other pages on the site.');
define('COM_SH404SEF_TT_IJOOMLA_MAG_NAME', 'When the previous parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance');
define('COM_SH404SEF_TT_INSERT_GLOBAL_ITEMID_IF_NONE', 'If no Itemid is set in the non-sef URL before it is turned into an SEF one, and you set this option to true, the curent menu item Itemid will be added to it. This will ensure that, if clicked, the link will stay on the same page (ie: same modules displayed)');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'If set to <strong>Yes</strong>, article ID will be prepended to each article title inserted in an URL, as in : <br /> mysite.com/Joomla-magazine/<strong>56</strong>-Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ISSUE_ID', 'If set to <strong>Yes</strong>, the issue unique internal id will be prepended to each issue name, to make sure it is unique.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'If set to <strong>Yes</strong>, magazine ID will be prepended to each magazine name inserted in an URL, as in : <br /> mysite.com/<strong>4</strong>-Joomla-magazine/Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_NAME', 'If set to <strong>yes<strong>, magazine name (as defined by magazine menu item title) will allways be prepended to SEF URL');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE', 'If set to <strong>Yes</strong>, the ISO code of the page language will be inserted in the SEF URL, except if language is default site language.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID', 'If set to <strong>Yes</strong>, a numerical id will be added to the URL, in order to facilitate inclusion in services such as Google news. The id will follow this format : 2007041100000, where 20070411 is date of creation and 00000 is internal unique id of the content element. You should finally set the date of creation when your content is ready for publishing. Please be aware that you should not change it afterwards.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST', 'Numerical id will be inserted in sef URLs of content elements found in onl y those categories listed here. You can select multiple categories by pressing and holding the CTRL key before clicking on a category name.');
define('COM_SH404SEF_TT_INSERT_PRODUCT_ID', 'If set to Yes, product ID will be prepended to product name in the SEF URL<br />For instance : mysite.com/3-my-very-nice-product.html.<br />This is useful if you do not insert all categories names in URL, as several products may have same name, in various categories. Please note that this is not the product SKU, but rather the internal product id, which is always unique.');
define('COM_SH404SEF_TT_INSERT_TITLE_IF_NO_ITEMID', 'If no Itemid is set in the non-sef URL before it is turned into an SEF one, and you set this option to true, the current menu item title will be inserted in the SEF URL. This should be set to true if above parameter is also set to true, as this will prevent -2, -3, -... to be appended to the SEF URL if an article is viewed from different locations');
define('COM_SH404SEF_TT_LETTERMAN_DEFAULT_ITEMID', 'Enter Itemid of page to be inserted in Letterman links (unsubscribe, confirmation messages, ...');
define('COM_SH404SEF_TT_LIVE_SECURE_SITE', 'Set this to the <strong>full base URL of your site when in SSL mode</strong>.<br />Required only if you use https access. If not set, will default to httpS://normalSiteURL.<br />Please enter full url, without any trailing slash. Example : <strong>https://www.mysite.com</strong> or <strong>https://sharedsslserveur.com/myaccount</strong>.');
define('COM_SH404SEF_TT_LOG_404_ERRORS', 'If set to <strong>Yes</strong>, 404 errors will be logged to database. This may help you find errors within your site links. It may also use up uneeded database space, so you can probably disable i when your site has been well tested.');
define('COM_SH404SEF_TT_MAX_URL_IN_CACHE', 'When URL cache is activated, this parameter sets its maximum size. Enter the maximum number of URL that can be stored in the cache (additional URL will be processed, but not stored in cache, so loading time will be higher). Roughly speaking, each URL is worth around 200 bytes (100 for the SEF URL and 100 for the non-sef URL). So, for instance,  5000 URLs will use about 1 Mb of memory.');
define('COM_SH404SEF_TT_REDIRECT_JOOMLA_SEF_TO_SEF', 'If set to <strong>Yes</strong>, sh404sef will try to redirect JOOMLA standard SEF url to their sh404SEF equivalent, if any in the database. If it does not exists, it will be created on the fly, unless there is some POST data, in which case nothing happens. Warning: this feature will work in most cases, but may give bad redirects for some Joomla SEF URL. Leave off if possible.');
define('COM_SH404SEF_TT_REDIRECT_NON_SEF_TO_SEF', 'If set to <strong>Yes</strong>, non-sef URL already existing in the DB will be redirected to their SEF counterpart, using a 301 - Moved permanently redirection. If the SEF URL does not exist, it will be created, except if there are some POST data passed in the page request.');
define('COM_SH404SEF_TT_REPLACEMENTS', 'Characters non accepted in URL, such as non-latin or accented, can be replaced as per this replacement table. <br />Format is xxx | yyy for each replacement rule. xxx is the character to be replaced, whereas yyy is the new character. <br />There can be many of this rules, separated by commas (,). Between the old character and the new one, use a | character. <br />Note also that xxx or yyy can be multiple characters, such as in Å’|oe ');
define('COM_SH404SEF_TT_SHOP_NAME', 'When the above parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance');
define('COM_SH404SEF_TT_TRANSLATE_URL', 'If activated, and site is multi-lingual, SEF URL elements will be translated to the visitor language, as decided by Joomfish. If de-activated, URL will always be in default language of site. Not used if site is not multi-lingual.');
define('COM_SH404SEF_TT_USE_URL_CACHE', 'If activated, SEF URL will be written to an in-memory cache, which will improve page load time significantly. This will however use up memory!');
define('COM_SH404SEF_TT_VM_ADDITIONAL_TEXT', 'If set to <strong>Yes</strong>, an additional text will be appended to browse categories URL. For instance : ..../category-A/View-all-products.html VS ..../category-A/ .');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORIES', 'If set to <strong>None</strong>, no category name will be inserted in a URL leading to a product display, as in : <br /> mysite.com/joomla-cms.html<br />If set to <strong>Only last one</strong>, the name of the category to which the product belongs will be inserted in the SEF URL, as in : <br /> mysite.com/joomla/joomla-cms.html<br />If set to <strong>All nested categories</strong>, the names of all categories to which the product belongs will be added, as in : <br /> mysite.com/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORY_ID', 'If set to Yes, category ID will be prepended to each category name inserted in an URL leading to a product, as in : <br /> mysite.com/1-software/4-cms/1-joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_FLYPAGE', 'If set to Yes, the flypage name will be inserted in the URL leading to a product details. Can be deactivated if you use only one flypage.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_ID', 'If set to Yes, manufacturer ID will be prepended to manufacturer name in the SEF URL<br />For instance : mysite.com/6-manufacturer-name/3-my-very-nice-product.html.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_NAME', 'If set to Yes, manufacturer name, if any, will be inserted in SEF URL leading to a product.<br />For instance : mysite.com/manufacturer-name/product-name.html');
define('COM_SH404SEF_TT_VM_INSERT_SHOP_NAME', 'If set to <strong>yes<strong>, shop name (as defined by shop menu item title) will allways be prepended to SEF URL');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU', 'If set to Yes, product SKU, the product code you enter for each product, will be used instead of the product full name.');
define('COM_SH404SEF_TT_SHOW_CAT','Set to yes to include the category name in url');
define('COM_SH404SEF_TT_SHOW_SECT','Set to yes to include the section name in url');
define('COM_SH404SEF_TT_STRIP_CHAR','Characters to strip from the URL, separate with |');
define('COM_SH404SEF_TT_SUFFIX','Extension to use for \'files\'. Leave blank to disable. A common entry here is \'html\'.');
define('COM_SH404SEF_TT_USE_ALIAS','Set to yes to use the title_alias instead of title in the URL');
define('COM_SH404SEF_UNWRITEABLE',' <b><font color="red">Unwriteable</font></b>');
define('COM_SH404SEF_UPLOAD_OK','File was successfully uploaded');
define('COM_SH404SEF_URL','Url');
define('COM_SH404SEF_URLEXIST','This URL already exists in the database!');
define('COM_SH404SEF_USE_ALIAS','Use Title Alias');
define('COM_SH404SEF_USE_DEFAULT','(use default handler)');
define('COM_SH404SEF_USING_DEFAULT',' <b><font color="red">Using Default Values</font></b>');
define('COM_SH404SEF_VIEW404','View/Edit<br/>404 Logs');
define('COM_SH404SEF_VIEW404DESC','This page will show you a list of requests made to your web site by users that ended up being for a non-existing page. You\'ll be able to purge those records - after carefully cheching whether they result from simple typos or possibly fom broken links on your sites');
define('COM_SH404SEF_VIEWCUSTOM','View/Edit<br/>Custom Redirects');
define('COM_SH404SEF_VIEWCUSTOMDESC','View/Edit Custom Redirects');
define('COM_SH404SEF_VIEWMODE','ViewMode:');
define('COM_SH404SEF_VIEWURL','URL manager');
define('COM_SH404SEF_VIEWURLDESC','This page will show you a list of all your SEF urls, with all details about them. That\'s where you want to go to either customize or delete some SEF urls. From there, you\'ll also be able to set page titles and meta tags, create aliases, manage non-sef url duplication, and purge some or all urls in the database');
define('COM_SH404SEF_WARNDELETE','WARNING!!!  You are about to delete ');
define('COM_SH404SEF_WRITE_ERROR','Error writing config');
define('COM_SH404SEF_WRITE_FAILED','Unable to write uploaded file to tmp directory');
define('COM_SH404SEF_WRITEABLE',' <b><font color="green">Writeable</font></b>');

// V 1.2.4.s
define('COM_SH404SEF_DOCMAN_TITLE', 'Docman configuration');
define('COM_SH404SEF_DOCMAN_INSERT_NAME', 'Insert Docman name');
define('COM_SH404SEF_TT_DOCMAN_INSERT_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to Docman main page will be prepended to all Docman SEF URL');
define('COM_SH404SEF_DOCMAN_NAME', 'Default Docman name');
define('COM_SH404SEF_TT_DOCMAN_NAME', 'When the previous parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_ID', 'Insert document ID');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID', 'If set to <strong>Yes</strong>, document ID will be prepended to a document name, which is needed in case some documents have identical names.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME', 'Insert document name');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME', 'If set to <strong>Yes</strong>, a document name will be inserted in all SEF URL leading to an action on this document');
define('COM_SH404SEF_MYBLOG_TITLE', 'MyBlog Configuration');
define('COM_SH404SEF_MYBLOG_INSERT_NAME', 'Insert MyBlog name');
define('COM_SH404SEF_TT_MYBLOG_INSERT_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to MyBlog main page will be prepended to all MyBlog SEF URL');
define('COM_SH404SEF_MYBLOG_NAME', 'Default Myblog name');
define('COM_SH404SEF_TT_MYBLOG_NAME', 'When the previous parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance.');
define('COM_SH404SEF_MYBLOG_INSERT_POST_ID', 'Insert post ID');
define('COM_SH404SEF_TT_MYBLOG_INSERT_POST_ID', 'If set to <strong>Yes</strong>, internal post ID will be prepended to the post title, which is needed in case several posts have identical titles.');
define('COM_SH404SEF_MYBLOG_INSERT_TAG_ID', 'Insert tag id');
define('COM_SH404SEF_TT_MYBLOG_INSERT_TAG_ID', 'If set to <strong>Yes</strong>, internal tag ID will be prepended to the tag name, which is needed in case several tags are identical, or in case of interference with other a category name.');
define('COM_SH404SEF_MYBLOG_INSERT_BLOGGER_ID', 'Insert blogger id');
define('COM_SH404SEF_TT_MYBLOG_INSERT_BLOGGER_ID', 'If set to <strong>Yes</strong>, internal blogger ID will be prepended to the blogger name, which is needed in case several bloggers have the same name.');
define('COM_SH404SEF_RW_MODE_NORMAL', 'with .htaccess (mod_rewrite)');
define('COM_SH404SEF_RW_MODE_INDEXPHP', 'without .htaccess (index.php)');
define('COM_SH404SEF_RW_MODE_INDEXPHP2', 'without .htaccess (index.php?)');
define('COM_SH404SEF_SELECT_REWRITE_MODE', 'Rewriting mode');
define('COM_SH404SEF_TT_SELECT_REWRITE_MODE', 'Select a rewriting mode for sh404SEF.<br /><strong>with .htaccess (mod_rewrite)</strong><br />Default mode : you must have a .htacces file, properly configured to match your server configuration<br /><strong>without .htaccess (index.php)</strong><br />You don&rsquo;t need a .htaccess file. This mode uses the PathInfo function of Apache servers. URLs will have an added /index.php/ bit at the beginning. It is not impossible that IIS servers also accept these URLS<br /><strong>without .htaccess (index.php?)</strong><br /><strong>Reduced benefit :</strong>You don&rsquo;t need a .htaccess file. This mode is identical to the previous one, except for the fact that /index.php?/ is used instead of /index.php/. Again, IIS servers may accept these URLs<br />');
define('COM_SH404SEF_RECORD_DUPLICATES', 'Record duplicated URL');
define('COM_SH404SEF_TT_RECORD_DUPLICATES', 'If set to <strong>Yes</strong>, sh404SEF will record in the DB all non sef URL that yield the same SEF url. This will aloow you to choose which one you prefer, using the Manage Duplicates function on the SEF URL display list.');
define('COM_SH404SEF_META_TITLE', 'Page title');
define('COM_SH404SEF_TT_META_TITLE', 'Enter the text to be inserted in the <strong>META Title</strong> tag for currently selected URL.');
define('COM_SH404SEF_META_DESC', 'Description tag');
define('COM_SH404SEF_TT_META_DESC', 'Enter the text to be inserted in the <strong>META Description</strong> tag for currently selected URL.');
define('COM_SH404SEF_META_KEYWORDS', 'Keywords tag');
define('COM_SH404SEF_TT_META_KEYWORDS', 'Enter the text to be inserted in the <strong>META keywords</strong> tag for currently selected URL. Every words or group of words must be comma separated.');
define('COM_SH404SEF_META_ROBOTS', 'Robots tag');
define('COM_SH404SEF_TT_META_ROBOTS', 'Enter the text to be inserted in the <strong>META Robots</strong> tag for currently selected URL. This tag tells search engines whether they must follow links on the current page, and what to do with the content of this current page. Common values :<br /><strong>INDEX,FOLLOW</strong> : index current page content, and follow all links found on the page<br /><strong>INDEX,NO FOLLOW</strong> : index current page content, but do not follow links found within the page<br /><strong>NO INDEX, NO FOLLOW</strong> : do not index the current page content, and do not follow links found within the page<br />');
define('COM_SH404SEF_META_LANG', 'Language tag');
define('COM_SH404SEF_TT_META_LANG', 'Enter the text to be inserted in the <strong>META http-equiv= Content-Language </strong> tag for currently selected URL. ');
define('COM_SH404SEF_CONF_TAB_META', 'Meta/SEO');
define('COM_SH404SEF_CONF_META_DOC', 'sh404SEF has several plugins to <strong>automatically</strong> create page title and description tags for some components. More plugins can be created by third-parties developers, when automatic meta tags creation is possible. If no plugin is supplied for a given extensions, it is usually better to either manually customize tags, or leave them empty.<br>');
define('COM_SH404SEF_REMOVE_JOOMLA_GENERATOR', 'Remove Joomla Generator tag');
define('COM_SH404SEF_TT_REMOVE_JOOMLA_GENERATOR', 'If set to <strong>Yes</strong>, the Generator = Joomla meta tag will be removed from all pages.');
define('COM_SH404SEF_PUT_H1_TAG', 'Insert h1 tags');
define('COM_SH404SEF_TT_PUT_H1_TAG', 'If set to <strong>Yes</strong>, regular content titles will be placed within h1 tags. These titles are normally placed by Joomla in a CSS class which name begins with <strong>contentheading</strong>.');
define('COM_SH404SEF_META_MANAGEMENT_ACTIVATED', 'Activate SEO management');
define('COM_SH404SEF_TT_META_MANAGEMENT_ACTIVATED', 'If set to <strong>Yes</strong>, Title, Description, Keywords, Robots and Language META tags will be managed by sh404SEF. Otherwise, original values produced by Joomla and/or other components will be left untouched. ');
define('COM_SH404SEF_TITLE_META_MANAGEMENT', 'SEO management');
define('COM_SH404SEF_META_EDIT', 'Modify tags');
define('COM_SH404SEF_META_ADD', 'Add tags');
define('COM_SH404SEF_META_TAGS', 'Title and metas manager');
define('COM_SH404SEF_META_TAGS_DESC', 'Create/modify Meta tags');
define('COM_SH404SEF_PURGE_META_DESC', 'Purge meta tags');
define('COM_SH404SEF_PURGE_META', 'Delete META');
define('COM_SH404SEF_IMPORT_EXPORT_META', 'Import/ export META');
define('COM_SH404SEF_NEW_META', 'New META');
define('COM_SH404SEF_NEWURL_META', 'Non SEF url');
define('COM_SH404SEF_TT_NEWURL_META', 'Enter the non SEF URL for which you whish to set Meta tags. WARNING: it must starts with by <strong>index.php</strong>!');
define('COM_SH404SEF_BAD_META', 'Please check your data: some input is not valid.');
define('COM_SH404SEF_META_TITLE_PURGE', 'Erase Meta tags');
define('COM_SH404SEF_META_SUCCESS_PURGE', 'Meta tags erased');
define('COM_SH404SEF_IMPORT_META', 'Import Meta tags');
define('COM_SH404SEF_EXPORT_META', 'Export Meta tags');
define('COM_SH404SEF_IMPORT_META_OK', 'Meta tags successfully imported');
define('COM_SH404SEF_SELECT_ONE_URL', 'Please select one (and only one) URL.');
define('COM_SH404SEF_MANAGE_DUPLICATES', 'URL management for : ');
define('COM_SH404SEF_MANAGE_DUPLICATES_RANK', 'Rank');
define('COM_SH404SEF_MANAGE_DUPLICATES_BUTTON', 'Duplicate URL');
define('COM_SH404SEF_MANAGE_MAKE_MAIN_URL', 'Main URL');
define('COM_SH404SEF_BAD_DUPLICATES_DATA', 'Error : invalid URL data');
define('COM_SH404SEF_BAD_DUPLICATES_NOTHING_TO_DO', 'This URL is already the main URL');
define('COM_SH404SEF_MAKE_MAIN_URL_OK', 'Operation successfully completed');
define('COM_SH404SEF_MAKE_MAIN_URL_ERROR', 'An error occured, operation failure');
define('COM_SH404SEF_CONTENT_TITLE', 'Content configuration');
define('COM_SH404SEF_INSERT_CONTENT_TABLE_NAME', 'Insert content table name');
define('COM_SH404SEF_TT_INSERT_CONTENT_TABLE_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to a table of articles (category or section) will be prepended to its SEF URL. This allow segragating table display from blog displays.');
define('COM_SH404SEF_CONTENT_TABLE_NAME', 'Default table views name');
define('COM_SH404SEF_TT_CONTENT_TABLE_NAME', 'When the previous parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance.');
define('COM_SH404SEF_REDIRECT_WWW', '301 redirect www/non-www');
define('COM_SH404SEF_TT_REDIRECT_WWW', 'If set to Yes, sh404SEF will do a 301 redirection if the site is accessed without www if site URL starts with www, or if site is accessed with a leading www while its main URL does not have www. Will prevent duplicate content penalties, and some issues depending on your Apache server config, as well as problems with Joomla (WYSYWIG editors)');
define('COM_SH404SEF_INSERT_PRODUCT_NAME', 'Insert product name');
define('COM_SH404SEF_TT_INSERT_PRODUCT_NAME', 'If set to Yes, product name will be inserted in URL');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU_124S', 'Insert product code');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU_124S', 'If set to Yes, product code (called SKU in Virtuemart) will be inserted in URL.');

// V 1.2.4.t
define('COM_SH404SEF_DOCMAN_INSERT_CAT_ID', 'Insert category id');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID', 'If set to <strong>Yes</strong>, category ID will be prepended to its name <strong>when previous option is also set to Yes</strong>, just in case two categories have the same name.');
define('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES', 'Insert category name');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES', 'If set to <strong>None</strong>, no category name will be inserted in URL, as in : <br /> mysite.com/joomla-cms.html<br />If set to <strong>Only last one</strong>, the category name will be inserted in the SEF URL, as in : <br /> mysite.com/joomla/joomla-cms.html<br />If set to <strong>All nested categories</strong>, the names of all categories will be added, as in : <br /> mysite.com/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_FORCED_HOMEPAGE', 'Home page URL');
define('COM_SH404SEF_TT_FORCED_HOMEPAGE', 'You can enter here a forced home page URL. Useful if you have setup a &rsquo;splash page&rsquo; usually a index.html file, which is displayed when you browse www.mysite.com. If so, type the following URL: www.mysite.com/index.php (no trailing /), so that the Joomla site is displayed when the Home link of main menu or pathway is clicked');
define('COM_SH404SEF_INSERT_CONTENT_BLOG_NAME', 'Insert blog view name');
define('COM_SH404SEF_TT_INSERT_CONTENT_BLOG_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to a blog of articles (category or section) will be prepended to its SEF URL. This allow segregating table displays from blog displays.');
define('COM_SH404SEF_CONTENT_BLOG_NAME', 'Default blog views name');
define('COM_SH404SEF_TT_CONTENT_BLOG_NAME', 'When the previous parameter is set to Yes, you can override the text inserted in the SEF URL here. Note that this text will be invariant, and will not be translated for instance.');
define('COM_SH404SEF_MTREE_TITLE', 'Mosets TreeConfiguration');
define('COM_SH404SEF_MTREE_INSERT_NAME', 'Insert MTree name');
define('COM_SH404SEF_TT_MTREE_INSERT_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to Mosets Tree will be prepended to its SEF URL.');
define('COM_SH404SEF_MTREE_NAME', 'Default MTree name');
define('COM_SH404SEF_MTREE_INSERT_LISTING_ID', 'Insert listing ID');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_ID', 'If set to <strong>Yes</strong>, a listing ID will be prepended to its name, just in case two listings have the same name.');
define('COM_SH404SEF_MTREE_PREPEND_LISTING_ID', 'Prepend ID to name');
define('COM_SH404SEF_TT_MTREE_PREPEND_LISTING_ID', 'If set to <strong>Yes</strong>, when previous option is also set to Yes, the ID will be <strong>prepended</strong> to the listing name. If set to No, it will be <strong>appended</strong>.');
define('COM_SH404SEF_MTREE_INSERT_LISTING_NAME', 'Insert listing name');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_NAME', 'If set to <strong>Yes</strong>, a listing name will be inserted in all URL leading to an action on this listing.');

define('COM_SH404SEF_IJOOMLA_NEWSP_TITLE', 'News Portal configuration');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_NAME', 'Insert News Portal name');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to iJoomla News Portal will be prepended to its SEF URL.');
define('COM_SH404SEF_IJOOMLA_NEWSP_NAME', 'Default News Portal name');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_CAT_ID', 'Insert category ID');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_CAT_ID', 'If set to <strong>Yes</strong>, a category ID will be prepended to its name, just in case two listings have the same name.');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'Insert section ID');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'If set to <strong>Yes</strong>, a category ID will be prepended to its name, just in case two listings have the same name.');
define('COM_SH404SEF_REMO_TITLE', 'Remository configuration');
define('COM_SH404SEF_REMO_INSERT_NAME', 'Insert Remository name');
define('COM_SH404SEF_TT_REMO_INSERT_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to Remository will be prepended to its SEF URL.');
define('COM_SH404SEF_REMO_NAME', 'Default Remository name');
define('COM_SH404SEF_CB_SHORT_USER_URL', 'Short URL to user profile');
define('COM_SH404SEF_TT_CB_SHORT_USER_URL', 'If set to <strong>Yes</strong>, a user will be able to access his/her profile through a short URL, similar to www.mysite.com/username. Before activating this option, make sure this will not generate any conflict with existing URL in the site.');
define('COM_SH404SEF_NEW_HOME_META', 'Home page Meta');
define('COM_SH404SEF_CONF_ERASE_HOME_META', 'Do you really want to delete home page title and meta tags ?');
define('COM_SH404SEF_UPGRADE_TITLE', 'Upgrade configuration');
define('COM_SH404SEF_UPGRADE_KEEP_URL', 'Preserve automatic URL');
define('COM_SH404SEF_TT_UPGRADE_KEEP_URL', 'If set to <strong>Yes</strong>, SEF URL automatically generated by sh40SEF will be stored and preserved when you unistall the component. This way, you will find them back when you install a new version, with no additional action required.');
define('COM_SH404SEF_UPGRADE_KEEP_CUSTOM', 'Preserve custom URL');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CUSTOM', 'If set to <strong>Yes</strong>, custom SEF URL you may have entered will be stored and preserved when you unistall the component. This way, you will find them back when you install a new version, with no additional action required.');
define('COM_SH404SEF_UPGRADE_KEEP_META', 'Preserve Title and meta');
define('COM_SH404SEF_TT_UPGRADE_KEEP_META', 'If set to <strong>Yes</strong>, custom Title and Meta tags you may have entered will be stored and preserved when you unistall the component. This way, you will find them back when you install a new version, with no additional action required.');
define('COM_SH404SEF_UPGRADE_KEEP_MODULES', 'Preserve modules parameters');
define('COM_SH404SEF_TT_UPGRADE_KEEP_MODULES', 'If set to <strong>Yes</strong>, current publication parameters like position, order, titles, etc of shJoomfish and shCustomtags modules will be stored and preserved when you unistall the component. This way, you will find them back when you install a new version, with no additional action required.');
define('COM_SH404SEF_IMPORT_OPEN_SEF','Import redirections from OpenSEF');
define('COM_SH404SEF_IMPORT_ALL','Import redirections');
define('COM_SH404SEF_EXPORT_ALL','Export redirections');
define('COM_SH404SEF_IMPORT_EXPORT_CUSTOM','Import/Export custom redirections');
define('COM_SH404SEF_DUPLICATE_NOT_ALLOWED', 'This URL already exists, while you have not allowed duplicate URL');
define('COM_SH404SEF_INSERT_CONTENT_MULTIPAGES_TITLE', 'Activate multipage article smart titles');
define('COM_SH404SEF_TT_INSERT_CONTENT_MULTIPAGES_TITLE', 'If set to Yes, for multi-pages article (those with a Table of content), sh404SEF will use the page titles inserted using the mospagebreak command : {mospagebreak title=Next_Page_Title & heading=Previous_Page_Title}, instead of the page number<br />For instance, a SEF URL similar to www.mysite.com/user-documentation/<strong>Page-2</strong>.html will now be replaced by www.mysite.com/user-documentation/<strong>Getting-started-with-sh404SEF</strong>.html.');

// v x
define('COM_SH404SEF_UPGRADE_KEEP_CONFIG', 'Preserve configuration');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CONFIG', 'If set to Yes, all configuration parameters will be stored and preserved when you unistall the component. This way, you will find them back when you install a new version, with no additional action required.');
define('COM_SH404SEF_CONF_TAB_SECURITY', 'Security');
define('COM_SH404SEF_SECURITY_TITLE', 'Security configuration');
define('COM_SH404SEF_HONEYPOT_TITLE', 'Project Honey Pot configuration');
define('COM_SH404SEF_CONF_HONEYPOT_DOC', 'Project Honey Pot is an initiative aiming at protecting web sites from spam robots. It provides a database to check a visitor IP address against known robots. Using this database requires an access key (free) you will have to obtain <a href="http://www.projecthoneypot.org/httpbl_configure.php">from the project web site</a><br />(You must create an account before requesting your access key - this is free as well). If you can, consider helping the project by setting up `traps` in your webspace, to help identify spam robots.');
define('COM_SH404SEF_ACTIVATE_SECURITY', 'Activate security functions');
define('COM_SH404SEF_TT_ACTIVATE_SECURITY', 'If set to Yes, sh404SEF will do some basic checks on the URLs requested to your web site, in order to protect it agains common attacks.');
define('COM_SH404SEF_LOG_ATTACKS', 'Log attacks');
define('COM_SH404SEF_TT_LOG_ATTACKS', 'If set to Yes, attacks identified will be logged to a text file, including IP address of attacker and page request made.<br />There is one log file per month. They are located in the <site root>/administrator/com_sh404sef/logs directory. You can download them using FTP, or use a Joomla utility such as Joomla Explorer to view them. They are TAB separated text file, so your spreadsheet software should open then up easily, probably the easiest way to view them.');	            
define('COM_SH404SEF_CHECK_HONEY_POT', 'Use Project Honey Pot');
define('COM_SH404SEF_TT_CHECK_HONEY_POT', 'If set to Yes, your visitors IP address will be checked against Project Hoeny Pot database, using their HTTP:BL service. It is free, but requires getting an access key from their web site.');
define('COM_SH404SEF_HONEYPOT_KEY', 'Project Honey Pot access key');
define('COM_SH404SEF_TT_HONEYPOT_KEY', 'If the Use Project Honey Pot option is activated, you must obtain an access key from P.H.P. Type the received access key here. It is a 12 characters string.');	             
define('COM_SH404SEF_HONEYPOT_ENTRANCE_TEXT', 'Alternative entry text');
define('COM_SH404SEF_TT_HONEYPOT_ENTRANCE_TEXT', 'If a visitor IP address has been tagged as suspicious by Project Honey Pot, access will be denied (403 result code). <br />However, in case of false detection, the text typed here will be shown to the visitor, with a link he/she must click to actually access the site. Only a human can read and understand such text, and the robot cannot access the link. <br />You can adjust this text to your liking.' );	             
define('COM_SH404SEF_SMELLYPOT_TEXT', 'Robot trap text');
define('COM_SH404SEF_TT_SMELLYPOT_TEXT', 'When a spam robot has been identified through Project Honey Pot, and access has been denied, a link is added at the bottom of the deny screen, in order to have Project Honey Pot record the robot action. A message is also added to prevent real people to click on that link, in case they were wrongly flagged. ');
define('COM_SH404SEF_ONLY_NUM_VARS', 'Numeric parameters');
define('COM_SH404SEF_TT_ONLY_NUM_VARS', 'Parameter names put in this list will be checked for being only numeric : digits 0 to 9 only. Enter one parameter per line.');
define('COM_SH404SEF_ONLY_ALPHA_NUM_VARS', 'Alpha-numeric parameters');
define('COM_SH404SEF_TT_ONLY_ALPHA_NUM_VARS', 'Parameter names put in this list will be checked for being only alpha-numeric : digits from 0 to 9, and letters a through z. Enter one parameter per line');
define('COM_SH404SEF_NO_PROTOCOL_VARS', 'Check hyperlinks in parameters');
define('COM_SH404SEF_TT_NO_PROTOCOL_VARS', 'Parameter names put in this list will be checked for not having hyperlinks in them, starting with http://, https://, ftp:// ');
define('COM_SH404SEF_IP_WHITE_LIST', 'IP white list');
define('COM_SH404SEF_TT_IP_WHITE_LIST', 'Any page request coming from an IP address on this list will be <stong>accepted</strong>, assuming the URL passes the above mentioned checks. Enter one IP per line.<br />You can use * as a wildcard, as in : 192.168.0.*. This will comprise IP from 192.168.0.0 through 192.168.0.255.');
define('COM_SH404SEF_IP_BLACK_LIST', 'IP black list');
define('COM_SH404SEF_TT_IP_BLACK_LIST', 'Any page request coming from an IP address on this list will be <strong>denied</strong>, assuming the URL passes the above mentioned checks. Enter one IP per line.<br />You can use * as a wildcard, as in : 192.168.0.*. This will comprise IP from 192.168.0.1 through 192.168.0.255.');
define('COM_SH404SEF_UAGENT_WHITE_LIST', 'UserAgent white list');
define('COM_SH404SEF_TT_UAGENT_WHITE_LIST', 'Any request made with a UserAgent string on this list will be <stong>accepted</strong>, assuming the URL passes the above mentioned checks. Enter one UserAgent string per line.');
define('COM_SH404SEF_UAGENT_BLACK_LIST', 'UserAgent black list');
define('COM_SH404SEF_TT_UAGENT_BLACK_LIST', 'Any request made with a UserAgent string on this list will be <strong>denied</strong>, assuming the URL passes the above mentioned checks. Enter one UserAgent string per line.');
define('COM_SH404SEF_MONTHS_TO_KEEP_LOGS', 'Months to keep security logs');
define('COM_SH404SEF_TT_MONTHS_TO_KEEP_LOGS', 'If logging of attacks is activated, you can set here the number of months to keep these log files. For instance, setting this to 1 means that the current month PLUS the month before will be kept available. Previous months log files will be deleted.');
define('COM_SH404SEF_ANTIFLOOD_TITLE', 'Anti-flood configuration');
define('COM_SH404SEF_ACTIVATE_ANTIFLOOD', 'Activate anti-flood');
define('COM_SH404SEF_TT_ACTIVATE_ANTIFLOOD', 'If set to Yes, sh404SEF will check that any given IP address will not make too many page request to your site. By making many requests, close to each other, a pirate can make your site unusable by simply overloading it.');
define('COM_SH404SEF_ANTIFLOOD_ONLY_ON_POST', 'Only if POST data (forms)');
define('COM_SH404SEF_TT_ANTIFLOOD_ONLY_ON_POST', 'If set to Yes, this control will only happen if there are some POST data in the page request. This is usually the case in form pages, so you may limit anti-flood control to forms only to help protect your site agains comment spamming robots.');
define('COM_SH404SEF_ANTIFLOOD_PERIOD', 'Anti-flood control');
define('COM_SH404SEF_TT_ANTIFLOOD_PERIOD', 'Time (in seconds) over which the number of requests from the same IP address will controled');
define('COM_SH404SEF_ANTIFLOOD_COUNT', 'Max number of requests');
define('COM_SH404SEF_TT_ANTIFLOOD_COUNT', 'Number of request that will trigger blocking pages for the offending IP address. For instance, entering Period = 10 and Number of requests = 4 will block access (return of a 403 code, and almost blank page) as soon as 4 requests will have been received from a given IP address in less than 10 seconds. Of course, access will be blocked only for this IP address, not for your other visitors.');
define('COM_SH404SEF_CONF_TAB_LANGUAGES', 'Languages');
define('COM_SH404SEF_DEFAULT', 'Default');
define('COM_SH404SEF_YES', 'Yes');
define('COM_SH404SEF_NO', 'No');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_PER_LANG', 'If set to Yes, language code will be inserted in URL for <strong>this language</strong>. If set to No, language code will never be inserted. If set to Default, language code will be inserted for all languages but default language of the site.');
define('COM_SH404SEF_TT_TRANSLATE_URL_PER_LANG', 'If set to Yes, and your site is multi-lingual, your URL will be translated for URL <strong>in this language</strong>, as per Joomfish settings. If set to No, URL will never be translated. If set to Default, they will also be translated. Has no effect on mono-lingual sites.');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_GEN', 'If set to Yes, a language code will be inserted in URL built by sh404SEF. You can also have a per language setting (see below).');
define('COM_SH404SEF_TT_TRANSLATE_URL_GEN', 'If set to Yes, an,d your site is multi-lingual, URL will be translated into your visitor language, as per Joomfish settings. Otherwise, URL will stay in the site default language. You can also have a per language setting (see below)');
define('COM_SH404SEF_ADV_COMP_DEFAULT_STRING', 'Default name');
define('COM_SH404SEF_TT_ADV_COMP_DEFAULT_STRING', 'If you enter here a text string, it will be inserted at the beginning of all URL for that component. Not used normally, only here for backward compatibility with old URL from other SEF components.');
define('COM_SH404SEF_TT_NAME_BY_COMP', '. <br />You can type in a name that will be used instead of the menu element name. To do this, please go to the <strong>By component</strong> tab. Note that this text will be invariant, and will not be translated for instance.');
define('COM_SH404SEF_STANDARD_ADMIN', 'Click here to switch to standard display (with only main parameters)');
define('COM_SH404SEF_ADVANCED_ADMIN', 'Click here to switch to extended display (with all available parameters)');
define('COM_SH404SEF_MULTIPLE_H1_TO_H2', 'Change multiple h1 in h2');
define('COM_SH404SEF_TT_MULTIPLE_H1_TO_H2', 'If set to Yes, and there are several instances of h1 tags on a page, they wil lbe turned into h2 tags.<br />If there is only one h1 tag on a page, it will left untouched.');
define('COM_SH404SEF_INSERT_NOFOLLOW_PDF_PRINT', 'Insert nofollow tag on Print and PDF links');
define('COM_SH404SEF_TT_INSERT_NOFOLLOW_PDF_PRINT', 'If set to Yes, rel=nofollow attributes will be added to all PDF and Print links created by Joomla. This reduce duplicate content seen by search engines.');
define('COM_SH404SEF_INSERT_READMORE_PAGE_TITLE', 'Insert title in Read more ... links');
define('COM_SH404SEF_TT_INSERT_READMORE_PAGE_TITLE', 'If set to Yes, and a Read more link is displayed on a page, the corresponding content title will be inserted in the link, to improve the link weight in search engines');

define('COM_SH404SEF_VM_USE_ITEMS_PER_PAGE', 'Using Items per page drop-down list');
define('COM_SH404SEF_TT_VM_USE_ITEMS_PER_PAGE', 'If set to Yes, URLs will be adjusted to allow for using drop-down lists to let user select the number of items per page. If you don&rsquo;t use such drop-down lists, AND your URLs are already indexed by search engines, you can set it to NO to keep your existing URL. ');
define('COM_SH404SEF_CHECK_POST_DATA', 'Check also forms data (POST)');
define('COM_SH404SEF_TT_CHECK_POST_DATA', 'If set to Yes, data coming from input forms will be checked against passing config variables or similar threats. This may cause unneeded blockages if you have, for instance, a forum where users may discuss such things as Joomla programming or similar. They may then want to discuss the exact text strings we are looking for as a potential attack. You should then disable this feature if you experience unappropriate forbidden access');
define('COM_SH404SEF_SEC_STATS_TITLE', 'Security stats');
define('COM_SH404SEF_SEC_STATS_UPDATE', 'Click here to update blocked attacks counters');
define('COM_SH404SEF_TOTAL_ATTACKS', 'Blocked attacks count');
define('COM_SH404SEF_TOTAL_CONFIG_VARS', 'mosConfig var in URL');
define('COM_SH404SEF_TOTAL_BASE64', 'Base64 injection');
define('COM_SH404SEF_TOTAL_SCRIPTS', 'Script injection');
define('COM_SH404SEF_TOTAL_STANDARD_VARS', 'Illegal standard vars');
define('COM_SH404SEF_TOTAL_IMG_TXT_CMD', 'remote file inclusion');
define('COM_SH404SEF_TOTAL_IP_DENIED', 'IP address denied');
define('COM_SH404SEF_TOTAL_USER_AGENT_DENIED', 'User agent denied');
define('COM_SH404SEF_TOTAL_FLOODING', 'Too many requests (flooding)');
define('COM_SH404SEF_TOTAL_PHP', 'Rejected by Project Honey Pot');
define('COM_SH404SEF_TOTAL_PER_HOUR', ' /h');
define('COM_SH404SEF_SEC_DEACTIVATED', 'Sec. functions not in use');
define('COM_SH404SEF_TOTAL_PHP_USER_CLICKED', 'PHP, but user clicked');
define('COM_SH404SEF_COM_SMF_TITLE', 'SMF bridge');
define('COM_SH404SEF_INSERT_SMF_NAME', 'Insert forum name');
define('COM_SH404SEF_TT_INSERT_SMF_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to the forum main page will be prepended to all forum SEF URL');
define('COM_SH404SEF_SMF_ITEMS_PER_PAGE', 'Items per page');
define('COM_SH404SEF_TT_SMF_ITEMS_PER_PAGE', 'Number of items displayed on a single page of forum');
define('COM_SH404SEF_INSERT_SMF_BOARD_ID', 'Insert forum id');
define('COM_SH404SEF_TT_INSERT_SMF_BOARD_ID', COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME);
define('COM_SH404SEF_INSERT_SMF_TOPIC_ID', 'Insert topic id');
define('COM_SH404SEF_TT_INSERT_SMF_TOPIC_ID', COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID);
define('COM_SH404SEF_INSERT_SMF_USER_NAME', 'Insert user name');
define('COM_SH404SEF_TT_INSERT_SMF_USER_NAME', 'If set to <strong>Yes</strong>, a user name will be inserted in each URL instead of if its id. This uses space in the DB, as a unique URl is created for each user and each function (view profile, pm, etc)');
define('COM_SH404SEF_INSERT_SMF_USER_ID', 'Insert user id');
define('COM_SH404SEF_TT_INSERT_SMF_USER_ID', 'If set to <strong>Yes</strong>, a user name will always be prepended with its internal id, making sure it is unique');
define('COM_SH404SEF_PREPEND_TO_PAGE_TITLE', 'Insert before page title');
define('COM_SH404SEF_TT_PREPEND_TO_PAGE_TITLE', 'Any text entered her will be prepended to all page title tags.');
define('COM_SH404SEF_APPEND_TO_PAGE_TITLE', 'Append to page title');
define('COM_SH404SEF_TT_APPEND_TO_PAGE_TITLE', 'Any text entered here will be appended to all page title tags.');
define('COM_SH404SEF_DEBUG_TO_LOG_FILE', 'Log debug info to file');
define('COM_SH404SEF_TT_DEBUG_TO_LOG_FILE', 'If set to Yes, sh404SEF will log to a text file many internal information. This data will help us troubleshoot problems you may be facing using sh404SEF. <br/>Warning: this file can quickly become fairly big. Also, this function will certainly slow down your site. Be sure to turn it on only when required. For this reason, it will de-activate automaticaly one hour after being started. Just turn it off then on again to activate it again. The log file is located in /administrator/components/com_sh404sef/logs/ ');

define('COM_SH404SEF_ALIAS_LIST', 'Alias list');
define('COM_SH404SEF_TT_ALIAS_LIST', 'Enter here a list of alias for this URL. Put only one alias per line, like :<br/>old-url.html<br/>or<br/>my-other-old-url.php?var=12&test=15<br>sh404SEF will do a 301 redirect to the current SEF URL if any one of those aliases is requested.');
define('COM_SH404SEF_HOME_ALIAS', 'Home page alias');
define('COM_SH404SEF_TT_HOME_PAGE_ALIAS_LIST', 'Enter here a list of alias for your home page. Put only one alias per line, like :<br/>old-url.html<br/>or<br/>my-other-old-url.php?var=12&test=15<br>sh404SEF will do a 301 redirect to your home page if any one of those aliases is requested');

define('COM_SH404SEF_INSERT_OUTBOUND_LINKS_IMAGE', 'Insert outbound links symbol');
define('COM_SH404SEF_TT_INSERT_OUTBOUND_LINKS_IMAGE', 'If set to Yes, a visual symbol will be inserted next to every link targeting another website, to allow easier identification of these links.');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_BLACK', 'Use black symbol');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_WHITE', 'Use white symbol');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE', 'Outbound links color symbol');
define('COM_SH404SEF_TT_OUTBOUND_LINKS_IMAGE', 'Both images have a transparent background. Select the black one if your site has a white background. Select the white one if your site has a dark background. These images are  /administrator/components/com_sef/images/external-white.png and external-black.png. They are 15x16 pixels in size.');

// V 1.3.3
define('COM_SH404SEF_DEFAULT_PARAMS_TITLE', 'Very adv.');
define('COM_SH404SEF_DEFAULT_PARAMS_WARNING', 'WARNING: change these values only if you know what you are doing! In case of wrongdoing, you could make damages you will have trouble repairing.');

// V 1.0.12
define('COM_SH404SEF_USE_CAT_ALIAS', 'Use category alias');
define('COM_SH404SEF_TT_USE_CAT_ALIAS', 'If set to <strong>Yes</strong>, sh404sef will use a category alias instead of its actual name every time that name is required to build a url');
define('COM_SH404SEF_USE_SEC_ALIAS', 'Use section alias');
define('COM_SH404SEF_TT_USE_SEC_ALIAS', 'If set to <strong>Yes</strong>, sh404sef will use a section alias instead of its actual name every time that name is required to build a url');
define('COM_SH404SEF_USE_MENU_ALIAS', 'Use menu alias');
define('COM_SH404SEF_TT_USE_MENU_ALIAS', 'If set to <strong>Yes</strong>, sh404sef will use a menu item alias instead of its actual title every time that title is required to build a url');
define('COM_SH404SEF_ENABLE_TABLE_LESS', 'Use table-less output');
define('COM_SH404SEF_TT_ENABLE_TABLE_LESS', 'If set to <strong>Yes</strong>, sh404sef will make Joomla use only div tags (no table tags) when outputing content, regardless of the template you are using. You should not have removed the Beez template for this to work. Beez template is installed by default with Joomla.<br /><strong>WARNING</strong> : you will have to adjust your template stylesheet to match this new html output format.');

// V 1.0.13
define( 'COM_SH404SEF_JC_MODULE_CACHING_DISABLED', 'Caching for Joomfish language selection module has been disabled!');

// V 1.5.3
define('COM_SH404SEF_ALWAYS_APPEND_ITEMS_PER_PAGE', 'Always append #items per page');
define('COM_SH404SEF_TT_ALWAYS_APPEND_ITEMS_PER_PAGE', 'If set to <strong>Yes</strong>, sh404sef will always append the number of items per page to paginated urls. For instance, .../Page-2.html will become .../Page2-10.html, if the current settings cause 10 items to be displayed per page. This is required for instance if you activated drop-down lists to let your user select number of items per page.');

define('COM_SH404SEF_REDIRECT_CORRECT_CASE_URL', '301 redirect url to correct case');
define('COM_SH404SEF_TT_REDIRECT_CORRECT_CASE_URL', 'If set to <strong>Yes</strong>, sh404sef will perform a 301 redirect from a SEF url if it does not have the same case as an url found in the database. For instance, example.com/My-page.html will be redirected to example.com/my-page.html, if the latter is stored in the database. Conversely, example.com/my-page.html will be redirected to example.com/My-page.html if the later is the url used on your site, and therefore stored in the database.');

// V 1.5.5
define('COM_SH404SEF_JOOMLA_LIVE_SITE', 'Joomla live_site');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE', 'You should see here the root url of your web site. For instance:<br />http://www.example.com<br/>or<br/> http://example.com<br />(no trailing slash)<br />This is not a sh404sef setting, but rather a <b>Joomla</b> setting. It is stored in Joomla\'s own configuration.php file.<br />Joomla will normally auto-detect your web site root address. However, if the address displayed here is not correct, you should set it yourself manually. This is done by modifying the content of Joomla configuration.php (usually using FTP).<br/>Symptoms linked to a bad value are : template or images do not display, buttons does not operate, all styles (colors, fonts, etc) are missing, etc...');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE_MISSING', 'WARNING: $live_site missing from Joomla configuration.php file, or does not start with "http://" or "https://" !');
define('COM_SH404SEF_JCL_INSERT_EVENT_ID', 'Insert event Id');
define('COM_SH404SEF_TT_JCL_INSERT_EVENT_ID', 'If set to Yes, event internal id will be prepended to the event title in the urls, to make them unique');
define('COM_SH404SEF_JCL_INSERT_CATEGORY_ID', 'Insert category id');
define('COM_SH404SEF_TT_JCL_INSERT_CATEGORY_ID', 'If set to Yes, when a category is used in a url, it will be prepended with the internal category id, to make it unique.');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_ID', 'Insert calendar id');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_ID', 'If set to Yes, when a calendar name is used in a url, it will be prepended with this calendar internal id, to make it unique');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_NAME', 'Insert Calendar name');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_NAME', 'If set to Yes, all urls where a specific calendar is set will have that calendar name included in the url. If no calendar id is specified in the url, the menu item title will be included instead');
define('COM_SH404SEF_JCL_INSERT_DATE', 'Insert date');
define('COM_SH404SEF_TT_JCL_INSERT_DATE', 'If set to yes, the date of the target page will be inserted into each url');
define('COM_SH404SEF_JCL_INSERT_DATE_IN_EVENT_VIEW', 'Insert date in event link');
define('COM_SH404SEF_TT_JCL_INSERT_DATE_IN_EVENT_VIEW', 'If set to Yes, each event date will be prepended to urls to the event details page');
define('COM_SH404SEF_JCL_TITLE', 'JCal Pro configuration');
define('COM_SH404SEF_PAGE_TITLE_TITLE', 'Page title configuration');
define('COM_SH404SEF_CONTENT_TITLE_TITLE', 'Joomla content page title configuration');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_SECTION', 'Insert section');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_SECTION', 'If set to Yes, an article section will be inserted in the page title of that article');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_CAT', 'Insert category');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_CAT', 'If set to Yes, an article category will be inserted in the page title of that article');
define('COM_SH404SEF_CONTENT_TITLE_USE_ALIAS', 'Use article title alias');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_ALIAS', 'If set to Yes, the article alias will be used in the page title instead of the actual article title');
define('COM_SH404SEF_CONTENT_TITLE_USE_CAT_ALIAS', 'Use category alias');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_CAT_ALIAS', 'If set to Yes, a category alias will be used in the page title instead of the actual category title');
define('COM_SH404SEF_CONTENT_TITLE_USE_SEC_ALIAS', 'Use section alias');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_SEC_ALIAS', 'If set to Yes, a section alias will be used the page title instead of the actual section title');
define('COM_SH404SEF_PAGE_TITLE_SEPARATOR', 'Page title separator');
define('COM_SH404SEF_TT_PAGE_TITLE_SEPARATOR', 'Enter here a character or a string to separate the various parts of the page title, if there is more than one. Defaults to the | character, surrounded by a single space');

// V 1.5.7
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_TITLE', 'Duplicates');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_NOT', 'Show only main url');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS', 'Show main and duplicate urls');
define('COM_SH404SEF_INSERT_ARTICLE_ID_TITLE', 'Insert article id in URL');
define('COM_SH404SEF_TT_INSERT_ARTICLE_ID_TITLE', 'If set to <strong>Yes</strong>, an article internal id will be appended to the title of that article in URLs, in order to be sure each article can be accessed individually, even if 2 articles have the exact same titles, or titles that yields the same URL (after being cleaned up for invalid characters and such). This id will bring no SEO value, and you should rather make sure you do not have articles with the same title in the same section and category.<br />In case you do not control article entries, this setting may help you make sure articles can be accessed, at the cost of good search engine optimization.');

// V 1.5.8

define('COM_SH404SEF_JS_TITLE', 'JomSocial configuration ');
define('COM_SH404SEF_JS_INSERT_NAME', 'Insert Jomsocial name');
define('COM_SH404SEF_TT_JS_INSERT_NAME', 'If set to <strong>Yes</strong>, the menu element title leading to JomSocial main page will be prepended to all JomSocial SEF URL');
define('COM_SH404SEF_JS_INSERT_USER_NAME', 'Insert user short name');
define('COM_SH404SEF_TT_JS_INSERT_USER_NAME', 'If set to <strong>Yes</strong>, user name will be inserted into SEF URLs. <strong>WARNING</strong>: this can lead to substantial increase in database size, and can slow down site, if you have many registered users.');
define('COM_SH404SEF_JS_INSERT_USER_FULL_NAME', 'Insert user full name');
define('COM_SH404SEF_TT_JS_INSERT_USER_FULL_NAME', 'If set to <strong>Yes</strong>, user full name will be inserted into SEF URLs. <strong>WARNING</strong>: this can lead to substantial increase in database size, and can slow down site, if you have many registered users.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY', 'Insert group category');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY', 'If set to <strong>Yes</strong>, a users group\'s category will be inserted into SEF URLs where the group name is used.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY_ID', 'Insert group category ID');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY_ID', 'If set to <strong>Yes</strong>, a users group category ID will be prepended to the category name <strong>when previous option is also set to Yes</strong>, just in case two categories have the same name.');
define('COM_SH404SEF_JS_INSERT_GROUP_ID', 'Insert group ID');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_ID', 'If set to <strong>Yes</strong>, a users group ID will be prepended to the group name, just in case two groups have the same name.');
define('COM_SH404SEF_JS_INSERT_GROUP_BULLETIN_ID', 'Insert group bulletin ID');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_BULLETIN_ID', 'If set to <strong>Yes</strong>, a users group bulletin ID will be prepended to the bulletin name, just in case two bulletins have the same name.');
define('COM_SH404SEF_JS_INSERT_DISCUSSION_ID', 'Insert group discussion ID');
define('COM_SH404SEF_TT_JS_INSERT_DISCUSSION_ID', 'If set to <strong>Yes</strong>, a users group discussion ID will be prepended to the discussion name, just in case two discussions have the same name.');
define('COM_SH404SEF_JS_INSERT_MESSAGE_ID', 'Insert message ID');
define('COM_SH404SEF_TT_JS_INSERT_MESSAGE_ID', 'If set to <strong>Yes</strong>, a message ID will be prepended to the message name, just in case two messages have the same subject.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM', 'Insert photo album name');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM', 'If set to <strong>Yes</strong>, the name of the album it belongs to will be inserted into SEF URLs of a photo or set of photos.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM_ID', 'Insert photo album ID');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM_ID', 'If set to <strong>Yes</strong>, an album ID will be prepended to the album name, just in case two albums have the same subject.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ID', 'Insert photo ID');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ID', 'If set to <strong>Yes</strong>, a photo ID will be prepended to the photo name, just in case two photos have the same subject.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT', 'Insert video category name');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT', 'If set to <strong>Yes</strong>, the name of the category it belongs to will be inserted into SEF URLs of a video or set of videos.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT_ID', 'Insert video category ID');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT_ID', 'If set to <strong>Yes</strong>, a video category ID will be prepended to the category name, just in case two categories have the same subject.');
define('COM_SH404SEF_JS_INSERT_VIDEO_ID', 'Insert video ID');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_ID', 'If set to <strong>Yes</strong>, a video ID will be prepended to the video name, just in case two videos have the same subject.');

define('COM_SH404SEF_FB_INSERT_USERNAME', 'Insert user name');
define('COM_SH404SEF_TT_FB_INSERT_USERNAME', 'If set to <strong>Yes</strong>, the username will be inserted into SEF URLs for her posts or profile.');
define('COM_SH404SEF_FB_INSERT_USER_ID', 'Insert user ID');
define('COM_SH404SEF_TT_FB_INSERT_USER_ID', 'If set to <strong>Yes</strong>, a user ID will be prepended to her name, if the preceding setting is set to yes, just in case two users have the same username.');
define('COM_SH404SEF_PAGE_NOT_FOUND_ITEMID', 'Itemid to use for 404 page');
define('COM_SH404SEF_TT_PAGE_NOT_FOUND_ITEMID', 'The value entered here, if non zero, will be used to display the 404 page. Joomla will use the Itemid to decide which template and modules to display. Itemid represents a menu item, so you can look up Itemids in your menus list.');
//define('', '');
