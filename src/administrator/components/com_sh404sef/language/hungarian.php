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

defined( '_JEXEC' ) or die( 'Restricted access');

define('COM_SH404SEF_404PAGE','404-es oldal');
define('COM_SH404SEF_ADD','Hozzáadás :');
define('COM_SH404SEF_ADDFILE','Alapértelmezett indexfájl.');
define('COM_SH404SEF_ASC',' (növ) ');
define('COM_SH404SEF_BACK','Vissza az sh404SEF vezérlőpulthoz');
define('COM_SH404SEF_BADURL','A régi nem keresőbarát URL-nek index.php-val kell kezdődnie');
define('COM_SH404SEF_CHK_PERMS','Kérjük, hogy ellenőrizd a fájlengedélyeket, és biztosítsd, hogy ez a fájl olvasható legyen.');
define('COM_SH404SEF_CONFIG', 'sh404SEF<br/>beállításai');
define('COM_SH404SEF_CONFIG_DESC','Az sh404SEF funkcióinak konfigurálása');
define('COM_SH404SEF_CONFIG_UPDATED','A beállítások módosítása kész');
define('COM_SH404SEF_CONFIRM_ERASE_CACHE', 'Do you want to clear the URL cache ? This is highly recommended after changing configuration. To generate again the cache, you should browse again your homepage, or better : generate a sitemap for your site.');
define('COM_SH404SEF_COPYRIGHT','Copyright');
define('COM_SH404SEF_DATEADD','Hozzáadva');
define('COM_SH404SEF_DEBUG_DATA_DUMP','A HIBAKERESÉSI ADATOK KIÍRATÁSA BEFEJEZŐDÖTT: Az oldalbetöltés leállt');
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
define('COM_SH404SEF_DEF_404_PAGE','Alapértelmezett 404 oldal');
define('COM_SH404SEF_DESC',' (csökk) ');
define('COM_SH404SEF_DISABLED',"<p class='error'>MEGJEGYZÉS: A Joomla keresőbarát támogatása jelenleg letiltott. Ha használni kívánod a keresőbarát webcímeket, akkor engedélyezd az <a href='".$GLOBALS['shConfigLiveSite']."/administrator/index.php?option=com_config'>Általános beállítások</a> SEO lapján.</p>");
define('COM_SH404SEF_EDIT','Szerkesztés :');
define('COM_SH404SEF_EMPTYURL','Kérjük, hogy add meg az átirányítás URL-jét.');
define('COM_SH404SEF_ENABLED','Engedélyezett');
define('COM_SH404SEF_ERROR_IMPORT','Az importálás közben hiba történt:');
define('COM_SH404SEF_EXPORT','Egyéni URL-ek biztonsági mentése');
define('COM_SH404SEF_EXPORT_FAILED','AZ EXPORTÁLÁS NEM SIKERÜLT!!!');
define('COM_SH404SEF_FATAL_ERROR_HEADERS','VÉGZETES HIBA: A FEJLÉC ELKÜLDÉSE MÁR MEGTÖRTÉNT');
define('COM_SH404SEF_FRIENDTRIM_CHAR','Barátságos karakterek levágása');
define('COM_SH404SEF_HELP', 'sh404SEF<br/>támogatás');
define('COM_SH404SEF_HELPDESC','Segítségre van szükséged az sh404SEF használatához?');
define('COM_SH404SEF_HELPVIA','<b>Segítséget az alábbi fórumokban kaphat:</b>');
define('COM_SH404SEF_HIDE_CAT','Kategória elrejtése');
define('COM_SH404SEF_HITS','Találatok');
define('COM_SH404SEF_IMPORT','Egyéni URL-ek importálása');
define('COM_SH404SEF_IMPORT_EXPORT','Egyéni URL-ek importálása/exportálása');
define('COM_SH404SEF_IMPORT_OK','Az egyéni URL-ek importálása sikerült!');
define('COM_SH404SEF_INFO', 'sh404SEF<br/>dokumentáció');
define('COM_SH404SEF_INFODESC','Az sh404SEF projekt összegzésének és dokumentációjának megtekintése');
define('COM_SH404SEF_INSTALLED_VERS','Telepített verzió:');
define('COM_SH404SEF_INVALID_SQL','ÉRVÉNYTELEN ADATOKAT TARTALMAZ AZ SQL FÁJL :');
define('COM_SH404SEF_INVALID_URL','ÉRVÉNYTELEN URL: ehhez a hivatkozáshoz érvényes elemazonosítóra van szükség, de nem található egy sem.<br/>MEGOLDÁS: Készítsd el ennek az elemnek a menüpontját. Nem kell közzétenned, csak létre kell hoznod.');
define('COM_SH404SEF_LICENSE','Licenc');
define('COM_SH404SEF_LOWER','Mind kisbetűs');
define('COM_SH404SEF_MAMBERS','Mambers fórum');
define('COM_SH404SEF_NEWURL','Új keresőbarát URL');
define('COM_SH404SEF_NO_UNLINK','Nem távolítható el a feltöltött fájl a media könyvtárból');
define('COM_SH404SEF_NOACCESS','Nem lehet hozzáférni a következő táblához: ');
define('COM_SH404SEF_NOCACHE','nincs tárazás');
define('COM_SH404SEF_NOLEADSLASH','NE KEZDŐDJÖN PERJELLEL az új keresőbarát URL');
define('COM_SH404SEF_NOREAD','VÉGZETES HIBA: Nem olvasható be a fájl ');
define('COM_SH404SEF_NORECORDS','Nem található egy rekord sem.');
define('COM_SH404SEF_OFFICIAL','Projekt hivatalos fóruma');
define('COM_SH404SEF_OK',' OK ');
define('COM_SH404SEF_OLDURL','Régi, nem keresőbarát URL');
define('COM_SH404SEF_PAGEREP_CHAR','Oldalelválasztó karakter');
define('COM_SH404SEF_PAGETEXT','Az oldal szövege');
define('COM_SH404SEF_PROCEED',' Folytatod ');
define('COM_SH404SEF_PURGE404','404 napló<br/>kiürítése');
define('COM_SH404SEF_PURGE404DESC','A 404 napló kiürítése');
define('COM_SH404SEF_PURGECUSTOM','Egyéni átirányítások<br/>kiürítése');
define('COM_SH404SEF_PURGECUSTOMDESC','Az egyéni átirányítások kiürítése');
define('COM_SH404SEF_PURGEURL','Keresőbarát URL-ek<br/>kiürítése');
define('COM_SH404SEF_PURGEURLDESC','A keresőbarát URL-ek kiürítése');
define('COM_SH404SEF_REALURL','Valódi URL');
define('COM_SH404SEF_RECORD',' rekord törlésére készülsz');
define('COM_SH404SEF_RECORDS',' rekord törlésére készülsz');
define('COM_SH404SEF_REPLACE_CHAR','Karakterhelyettesítés');
define('COM_SH404SEF_SAVEAS','Mentés egyéni átirányításként');
define('COM_SH404SEF_SEFURL','Keresőbarát URL');
define('COM_SH404SEF_SELECT_DELETE','Jelöld ki a törlendő elemet');
define('COM_SH404SEF_SELECT_FILE','Kérjük, hogy előbb válassza ki a fájlt');
define('COM_SH404SEF_ACTIVATE_IJOOMLA_MAG', 'Az iJoomla Magazine aktiválása a tartalomban');
define('COM_SH404SEF_ADV_INSERT_ISO', 'A nyelvkód beszúrása');
define('COM_SH404SEF_ADV_MANAGE_URL', 'URL feldolgozás');
define('COM_SH404SEF_ADV_TRANSLATE_URL', 'Az URL lefordítása');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID', 'Az elemazonosító hozzáfűzése a SEF URL-hez minden alkalommal');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX', 'menüazonosító');
define('COM_SH404SEF_ALWAYS_INSERT_MENU_TITLE', 'A menücím beszúrása minden alkalommal');
define('COM_SH404SEF_CACHE_TITLE', 'Gyorsítótár-kezelés');
define('COM_SH404SEF_CAT_TABLE_SUFFIX', 'Táblázat');
define('COM_SH404SEF_CB_INSERT_NAME', 'A Community Builder nevének beszúrása');
define('COM_SH404SEF_CB_INSERT_USER_ID', 'A felhasználó azonosítójának beszúrása');
define('COM_SH404SEF_CB_INSERT_USER_NAME', 'Felhasználónév beszúrása');
define('COM_SH404SEF_CB_NAME', 'Alapértelmezett CB név');
define('COM_SH404SEF_CB_TITLE', 'Community Builder beállításai ');
define('COM_SH404SEF_CB_USE_USER_PSEUDO', 'A felhasználónév beszúrása');
define('COM_SH404SEF_CONF_TAB_ADVANCED', 'Speciális');
define('COM_SH404SEF_CONF_TAB_BY_COMPONENT', 'Komponens');
define('COM_SH404SEF_CONF_TAB_MAIN', 'Fő');
define('COM_SH404SEF_CONF_TAB_PLUGINS', 'Beépülő modulok');
define('COM_SH404SEF_DEFAULT_MENU_ITEM_NAME', 'Alapértelmezett menücím');
define('COM_SH404SEF_DO_NOT_INSERT_LANGUAGE_CODE','Nincs kódbeszúrás');
define('COM_SH404SEF_DO_NOT_OVERRIDE_SEF_EXT', 'Nincs SEF kiterjesztés felülbírálás');
define('COM_SH404SEF_DO_NOT_TRANSLATE_URL','Nincs lefordítás');
define('COM_SH404SEF_ENCODE_URL', 'URL kódolása');
define('COM_SH404SEF_FB_INSERT_CATEGORY_ID', 'Kategória-azonosító beszúrása');
define('COM_SH404SEF_FB_INSERT_CATEGORY_NAME', 'Kategórianév beszúrása');
define('COM_SH404SEF_FB_INSERT_MESSAGE_ID', 'A hozzászólás azoosítójának beszúrása');
define('COM_SH404SEF_FB_INSERT_MESSAGE_SUBJECT', 'A hozzászólás tárgyának beszúrása');
define('COM_SH404SEF_FB_INSERT_NAME', 'A Kunena nevének beszúrása');
define('COM_SH404SEF_FB_NAME', 'A Kunena alapértelmezett neve');
define('COM_SH404SEF_FB_TITLE', 'Kunena beállításai ');
define('COM_SH404SEF_FILTER', 'Filtre');
define('COM_SH404SEF_FORCE_NON_SEF_HTTPS', 'HTTPS esetén a nem SEF használata');
define('COM_SH404SEF_GUESS_HOMEPAGE_ITEMID', 'Az elemazonosító kitalálása a címlapon');
define('COM_SH404SEF_IJOOMLA_MAG_NAME', 'Alapértelmezett magazin neve');
define('COM_SH404SEF_IJOOMLA_MAG_TITLE', 'iJoomla Magazine beállításai');
define('COM_SH404SEF_INSERT_GLOBAL_ITEMID_IF_NONE', 'A menü-elemazonosító beszúrása, ha nincs');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Cikkazonosító beszúrása az URL-be');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ISSUE_ID', 'A szám azonosítójának beszúrása az URL-be');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'A magazin azonosítójának beszúrása az URL-be');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_NAME', 'A magazin nevének beszúrása az URL-be');
define('COM_SH404SEF_INSERT_LANGUAGE_CODE', 'A nyelvkód beszúrása az URL-be');
define('COM_SH404SEF_INSERT_NUMERICAL_ID', 'Numerikus azonosító beszúrása az URL-be');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_ALL_CAT', 'Minden kategória');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST', 'Mely kategóriákra alkalmazandó');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE', 'Egyedi ID');
define('COM_SH404SEF_INSERT_PRODUCT_ID', 'A termékazonosító beszúrása az URL-be');
define('COM_SH404SEF_INSERT_TITLE_IF_NO_ITEMID', 'A menücím beszúrása, ha nincs elemazonosító');
define('COM_SH404SEF_ITEMID_TITLE', 'Elemazonosító-kezelés');
define('COM_SH404SEF_LETTERMAN_DEFAULT_ITEMID', 'A Letterman oldal alapértelmezett elemazonosítója');
define('COM_SH404SEF_LETTERMAN_TITLE', 'Letterman beállításai ');
define('COM_SH404SEF_LIVE_SECURE_SITE', 'SSL biztonságos URL');
define('COM_SH404SEF_LOG_404_ERRORS', '404-es hibák naplózása');
define('COM_SH404SEF_MAX_URL_IN_CACHE', 'A gyorsítótár mérete');
define('COM_SH404SEF_OVERRIDE_SEF_EXT', 'A saját SEF kiterjesztés hatálytalanítása');
define('COM_SH404SEF_REDIR_404', '404');
define('COM_SH404SEF_REDIR_CUSTOM', 'Egyéni');
define('COM_SH404SEF_REDIR_SEF', 'SEF');
define('COM_SH404SEF_REDIR_TOTAL', 'Összes');
define('COM_SH404SEF_REDIRECT_JOOMLA_SEF_TO_SEF', '301-es átirányítás a JOOMLA SEF-ről az sh404SEF-re');
define('COM_SH404SEF_REDIRECT_NON_SEF_TO_SEF', '301 átirányítás nem keresőbarát URL-ről keresőbarátra');
define('COM_SH404SEF_REPLACEMENTS', 'Karaktercserék listája');
define('COM_SH404SEF_SHOP_NAME', 'Alapértelmezett üzletnév');
define('COM_SH404SEF_TRANSLATE_URL', 'Az URL lefordítása');
define('COM_SH404SEF_TRANSLATION_TITLE', 'Fordítás kezelése');
define('COM_SH404SEF_USE_URL_CACHE', 'Az URL gyorsítótárazás aktiválása');
define('COM_SH404SEF_VM_ADDITIONAL_TEXT', 'Kiegészítő szöveg');
define('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES', 'Nincs');
define('COM_SH404SEF_VM_INSERT_CATEGORIES', 'Beszúrandó kategóriák');
define('COM_SH404SEF_VM_INSERT_CATEGORY_ID', 'A kategóriaazonosító beszúrása az URL-ben');
define('COM_SH404SEF_VM_INSERT_FLYPAGE', 'Terméklap nevének beszúrása');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_ID', 'Gyártó azonosítójának beszúrása');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_NAME', 'A gyártó nevének beszúrása az URL-be');
define('COM_SH404SEF_VM_INSERT_SHOP_NAME', 'Az üzlet nevének beszúrása az URL-be');
define('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES', 'Az összes beágyazott kategória');
define('COM_SH404SEF_VM_SHOW_LAST_CATEGORY', 'Csak az utolsó');
define('COM_SH404SEF_VM_TITLE', 'VirtueMart beállításai');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU', 'A termék cikkszámának használata névként');
define('COM_SH404SEF_SHOW_CAT','Kategória megjelenítése');
define('COM_SH404SEF_SHOW_SECT','Szekció belevétele');
define('COM_SH404SEF_SHOW0','Keresőbarát URL-ek');
define('COM_SH404SEF_SHOW1','404 napló');
define('COM_SH404SEF_SHOW2','Egyéni átirányítások');
define('COM_SH404SEF_SKIP','kihagyás');
define('COM_SH404SEF_SORTBY','Rendezési mód:');
define('COM_SH404SEF_STRANGE','Valami különös történt. Ennek nem szabadna előfordulnia<br />');
define('COM_SH404SEF_STRIP_CHAR','Eltávolítandó karakterek');
define('COM_SH404SEF_SUCCESSPURGE','A rekordok kiürítése sikerült');
define('COM_SH404SEF_SUFFIX','Fájl utótag');
define('COM_SH404SEF_SUPPORT','Támogató<br/>webhely');
define('COM_SH404SEF_SUPPORT_404SEF','Támogatás');
define('COM_SH404SEF_SUPPORTDESC','Kapcsolódás az sh404SEF webhelyéhez (új ablakban)');
define('COM_SH404SEF_TITLE_ADV','Speciális komponens beállítások');
define('COM_SH404SEF_TITLE_BASIC','Alapbeállítások');
define('COM_SH404SEF_TITLE_CONFIG','A sh404SEF konfigurációs fájl');
define('COM_SH404SEF_TITLE_MANAGER','sh404SEF URL-kezelő');
define('COM_SH404SEF_TITLE_PURGE','sh404SEF adatbázis kiürítése');
define('COM_SH404SEF_TITLE_SUPPORT','sh404SEF támogatás');
define('COM_SH404SEF_TT_404PAGE','Statikus tartalmi oldal használata a 404 Nem található hibák esetén');
define('COM_SH404SEF_TT_ADDFILE','Üres URL után teendő fájlnév / ha egy fájl sem létezik.  A weblapodat indexelő robotok esetén hasznos, melyek egy bizonyos fájlt keresnek azon a helyen, viszont 404-es hibát ad vissza, mert nincs ott.');
define('COM_SH404SEF_TT_ADV','<b>alapértelmezett kezelő használata</b><br/>a feldolgozás normál módon történik, ha létezik speciális keresőbarát kiegészítés, akkor az kerül helyette felhasználásra. <br/><b>nincs tárazás</b><br/>nem tárolja az adatbázisban, és régi stílusú keresőbarát URL-eket generál.<br/><b>kihagyás</b><br/>nem készít keresőbarát URL-eket ehhez a komponenshez<br/>');
define('COM_SH404SEF_TT_ADV4','Speciális beállítások: ');
define('COM_SH404SEF_TT_ENABLED','A Nem választása esetén a Joomla alapértelmezett keresőbarát funkcióját fogja használni a rendszer');
define('COM_SH404SEF_TT_FRIENDTRIM_CHAR','Az URL-ben lévő levágandó karakterek, | szimbólummal elválasztva. Warning: if you change this from its default value, make sure to not leave it empty. At least use a space. Due to a small bug in Joomla, this cannot be left empty.');
define('COM_SH404SEF_TT_LOWER','Az URL-ben lévő összes karaktert kisbetűssé alakítja', 'Mind kisbetűs');
define('COM_SH404SEF_TT_NEWURL','Csak relatív átirányítás a Joomla gyökérből, az elején / jel <i>nélkül</i>');
define('COM_SH404SEF_TT_OLDURL','Ennek az URL-nek index.php-val kell kezdődnie');
define('COM_SH404SEF_TT_PAGEREP_CHAR','Az oldalszámokat az URL többi részétől történő elválasztásra használandó karakter');
define('COM_SH404SEF_TT_PAGETEXT','Több oldal URL-jéhez hozzáfűzendő szöveg. A %s használatával szúrhatod be az oldalszámot, alapértelmezésként a végére kerül. Ha meghatározol egy előtagot, akkor hozzáfűzi ennek a karakterláncnak a végéhez.');
define('COM_SH404SEF_TT_REPLACE_CHAR','Az URL-ben előforduló ismeretlen karaktereket behelyettesítő karakter');
define('COM_SH404SEF_TT_ACTIVATE_IJOOMLA_MAG', 'Az <strong>Igen</strong> választása esetén a kiadás paramétere ha továbbításra kerül a com_content komponensnek, akkor az iJoomla magazin kiadás azonosítójaként kerül értelmezésre.');
define('COM_SH404SEF_TT_ADV_INSERT_ISO', 'Mindegyik telepített komponenshez, és ha a webhely többnyelvű, válaszd ki, hogy be kell-e szúrni a célnyelv ISO-kódját a keresőbarát URL-be. Például : www.weblapom.hu/<b>fr</b>/introduction.html. Az fr jelentésse francia. Ez a kód nem kerül beszúrásra az alapértelmezett nyelv URL-jébe.');
define('COM_SH404SEF_TT_ADV_MANAGE_URL', 'Mindegyik telepített komponens esetén:<br /><b>az alapértelmezett kezelő használata</b><br/>feldolgozás normál módon, ha van SEF Advanced kiterjesztés, akkor az kerül felhasználásra helyette. <br/><b>nincs gyorsítótárazás</b><br/>nincs tárolás az adatbázisban, és régi stílusú keresőbarát URL-ek létrehozása<br/><b>kihagyás</b><br/>nincs keresőbarát URL-készítés ehhez a komponenshez<br/>');
define('COM_SH404SEF_TT_ADV_OVERRIDE_SEF', 'Egyes komponensekhez adnak ki SEF kiterjesztésfájlt (sef_ext), ami használható az OpenSEF-hez vagy a SEF Advance-hoz. Az sh404SEF fel tudja őket használni. Ha ennek a paraméternek A saját SEF kiterjesztés hatálytalanítása a beállítása, akkor az then sh404SEF a saját kiterjesztését fogja felhasználni (ha van hozzá!), mint a komponenshez kiadottat. A Nincs SEF kiterjesztés felülbírálás választása esetén a komponenshez adott SEF kiterjesztés kerül felhasználásra.');
define('COM_SH404SEF_TT_ADV_TRANSLATE_URL', 'Válaszd ki mindegyik telepített komponens számára, hogy le kell-e fordítani az URL-t. Nem érvényes, ha a webhely egynyelvű.');
define('COM_SH404SEF_TT_ALWAYS_INSERT_ITEMID', 'Az Igen választása esetén a nem keresőbarát elemazonosító (vagy a jelenlegi menüpont elemazonosítója, ha egyik sincs megadva a nem keresőbarát URL-ben) hozzáfűzésre kerül a keresőbarát URL-hez. Ezt kell használni A menücím beszúrása minden alkalommal paraméter helyett, ha több azonos című menüpontod van (például ha van egy a főmenüben, egy pedig a felső menüben)');
define('COM_SH404SEF_TT_ALWAYS_INSERT_MENU_TITLE', 'Az igen választása esetén az elemazonosítónak megfelelő menüpont címe kerül beszúrásra a nem keresőbarát URL-be, vagy ha nincs megadva egy elemazonosító sem, a jelenlegi menüpont címe beszúrásra kerül a keresőbarát URL-be.');
define('COM_SH404SEF_TT_CB_INSERT_NAME', 'Az <strong>Igen</strong> választása esetén a Community Builder főoldalához vezető menüpont címe hozzáfűzésra kerül az összes CB keresőbarát URL-hez');
define('COM_SH404SEF_TT_CB_INSERT_USER_ID', 'Az <strong>Igen</strong> választása esetén a felhasználó azonosítója kerül hozzáfűzésra a nevéhez, <strong>ha az előző lehetőséget is Igenre állítottad</strong>, csak abban az esetben, ha két felhasználónak ugyanaz a neve.');
define('COM_SH404SEF_TT_CB_INSERT_USER_NAME', 'Az <strong>Igen</strong> választása esetén a felhasználónév beszúrásra kerül a keresőbarát URL-ekbe. <strong>FIGYELMEZTETÉS</strong>: ez az adatbázis méretének jelentős megnövekedéséhez vezethet, és lelassíthatja a webhelyet, ha sok a regisztrált felhasználó. A Nem választása esetén a felhasználó azonosítója kerül helyette felhasználásra a hagyományos formátumban : ..../email-kuldese-a-felhasznalonak.html?user=245');
define('COM_SH404SEF_TT_CB_NAME', 'Az előző paraméter Igenre állításakor itt bírálhatja felül a keresőbarát URL-be beszúrt szöveget. Ez a szöveg változatlan marad, nem kerül lefordításra például.');
define('COM_SH404SEF_TT_CB_USE_USER_PSEUDO', 'Az <strong>Igen</strong> választása esetén a felhasználónév kerül beszúrásra a keresőbarát URL-be a valódi név helyett, ha aktiváltad a fenti tulajdonságot.');
define('COM_SH404SEF_TT_DEFAULT_MENU_ITEM_NAME', 'A fenti paraméter Igenre állításával itt felülbírálhatod a keresőbarát URL-be beszúrt szöveget. Ez a szöveg változatlan lesz, és nem kerül például lefordításra.');
define('COM_SH404SEF_TT_ENCODE_URL', 'Az Igen választása esetén az URL kódolásra kerül, hogy kompatibilis legyen a nem latin karaktereket tartalmazó nyelvekkel. A kódolt URL ehhez hasonló lesz : weblapom.hu/%34%56%E8%67%12.....');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_ID', 'Az <strong>Igen</strong> választása esetén a kategória-azonosító hozzáfűzésre kerül a nevéhez, <strong>ha az előző lehetőségnél is az Igent választottad</strong>, csak ebben az esetben két kategóriának lesz ugyanaz a neve.');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME', 'Az Igen választása esetén a kategórianév beszúrásra kerül az összes hozzászólás vagy kategória keresőbarát hivatkozásába');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID', 'Az <strong>Igen</strong> választása esetén a hozzászólás azonosítószáma hozzáfűzésre kerül a tárgyhoz, <strong>ha az előző lehetőségnél is az Igent választottad</strong>, csak ebben az esetben két hozzászólásnak lesz ugyanaz a tárgya.');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_SUBJECT', 'Az <strong>Igen</strong> választása esetén minden egyes hozzászólás tárgya beszúrásra kerül a hozzászóláshoz vezető keresőbarát URL-be ');
define('COM_SH404SEF_TT_FB_INSERT_NAME', 'Az <strong>Igen</strong> választása esetén a Kunena főoldalához vezető menüpont címe hozzáfűzésre kerül a Kunena összes keresőbarát URL-jéhez');
define('COM_SH404SEF_TT_FB_NAME', 'Az <strong>Igen<strong> választása esetén a Kunena neve (a Kunena menüpontban meghatározottak szerint) mindig hozzáfűzésre kerül a keresőbarát URL-hez.');
define('COM_SH404SEF_TT_FORCE_NON_SEF_HTTPS', 'Az Igen választása esetén a nem keresőbarát URL kerül felhasználásra az SSL módba (HTTPS) történő váltáskor. Ez teszi lehetővé olyan megosztott SSL kiszolgálókkal a működést, melyek egyébként problémákat okoznának.');
define('COM_SH404SEF_TT_GUESS_HOMEPAGE_ITEMID', 'Az Igen választása esetén, és csak a címlapon, a com_content URL-ek elemazonosítója eltávolításra kerül, és lecserélésre kerül az sh404SEF által kitaláltra. Ez akkor hasznos, amikor némely tartalmi elem látható a címlapon (blog nézetben például), és a webhely többi oldalán is.');
define('COM_SH404SEF_TT_IJOOMLA_MAG_NAME', 'Ha az előző paraméternél az Igent választottad, akkor itt felülbírálhatod a keresőbarát URL-be beszúrt szöveget. Ez a szöveg változatlan marad, nem kerül lefordításra például');
define('COM_SH404SEF_TT_INSERT_GLOBAL_ITEMID_IF_NONE', 'Ha nincs megadva elemazonosító a nem keresőbarát URL-ben a keresőbaráttá alakítás előtt, te pedig ezt a lehetőséget igazra állítottad, akkor a jelenlegi menüpont elemazonosítója hozzáadásra kerül. Ez fogja biztosítani azt, hogy kattintáskor a hivatkozás ugyanazon az oldalon fog maradni (pl: ugyanazok a modulok láthatók)');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Az <strong>Igen</strong> választása esetén a cikk azonosítója hozzáfűzésre kerül az URL-be beszúrt mindegyik cikkcímhez, mint itt : <br /> enweblapom.hu/Joomla-magazine/<strong>56</strong>-Jo-cikk-cime.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ISSUE_ID', 'Az <strong>Igen</strong> választása esetén a szám egyedi belső azonosítója hozzáfűzésra kerül mindegyik szám nevéhez, hogy biztosítsa egyediségét.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Az <strong>Igen</strong> választása esetén a magazin azonosítója hozzáfűzésra kerül mindegyik magain nevéhez az URL-ben, mint ebben : <br /> enweblapom.hu/<strong>4</strong>-Joomla-magazine/Jo-cikk-cim.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_NAME', 'Az <strong>igen<strong> választása esetén a magazin neve (a magazin menüpontjának címében meghatározottak alapján) mindig hozzáfűzésre kerül a keresőbarát URL-hez');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE', 'Az <strong>Igen</strong> választása esetén az oldal nyelvének ISO-kódja beszúrásra kerül a keresőbarát URL-be, kivéve, ha a nyelv a webhely alapértelmezett nyelve.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID', 'Az <strong>Igen</strong> választása esetén egy numerikus azonosító kerül hozzáadásra az URL-hez, ami elősegíti az olyan szolgáltatásokba történő bevételt, mint a Google news. Az azonosító formátuma a következő : 2007041100000, ahol 20070411 a létrehozás dátuma, a 00000 pedig a tartalmi elem belső egyedi azonosítója. Végül is csak akkor kell megadnod a létrehozás dátumát, amikor a tartalmi elem közzétételre kész. Ügyelj arra, hogy utána már ne változtasd meg.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST', 'A numerikus azonosító csak az ebben a listában található tartalmi elemek URL-jeibe kerül beszúrásra. A CTRL billentyű leütésével és lenyomva tartásával választhatsz ki több kategóriát a kategórianévre kattintással.');
define('COM_SH404SEF_TT_INSERT_PRODUCT_ID', 'Az Igen választása esetén a termékazonosító hozzáfűzésre kerül a keresőbarát URL-ben a termék nevéhez<br />Például : enlapom.hu/3-az-en-nagyon-szep-termekem.html.<br />Ez akkor hasznos, ha nem akarod az összes kategórianevet beszúrni az URL-be, ugyanis különféle kategóriákban több terméknek ugyanaz lehet a neve. Ez nem a termék cikkszáma, hanem a belső termékazonosító, ami mindig egyedi.');
define('COM_SH404SEF_TT_INSERT_TITLE_IF_NO_ITEMID', 'Ha nincs megadva elemazonosító a nem keresőbarát URL-ben a keresőbaráttá alakítás előtt, te pedig ezt a lehetőséget igazra állítottad, akkor a jelenlegi menüpont címe beszúrásra kerül a keresőbarát URL-be. Akkor állítsd ezt igazra, ha a fenti paramétert is igazra állítottad, ugyanis ez megakadályozza a -2, -3, -... hozzáfűzését a keresőbarát URL-hez, ha valamelyik cikket több helyről nézik.');
define('COM_SH404SEF_TT_LETTERMAN_DEFAULT_ITEMID', 'Írd be a Letterman hivatkozásaiba beszúrandó elemazonosítót (lemondás, üzenetek megerősítése, ...');
define('COM_SH404SEF_TT_LIVE_SECURE_SITE', 'Állítsd ezt <strong>SSL módban a webhely teljes alap URL-jére</strong>.<br />Csak https hozzáférés használata esetén kell. Ha nem adod meg, akkor a httpS://normalwebhelyURL lesz az alapértelmezett<br />Kérjük, hogy a teljes URL-t írd be, záró perjel nélkül. Például : <strong>https://www.weblapom.hu</strong> vagy <strong>https://megosztottsslkiszolgalo.hu/fiokom</strong>.');
define('COM_SH404SEF_TT_LOG_404_ERRORS', 'Az <strong>Igen</strong> választása esetén a 404-es hibák az adatbázisba kerülnek naplózásra. Ez segíthet a webhelyének hivatkozásaiban lévő hibák megkeresésében. A szükségesnél több adatbázishelyre van hozzá szükség, ezért a webhely alapos letesztelése után talán le is tilthatja.');
define('COM_SH404SEF_TT_MAX_URL_IN_CACHE', 'Az URL gyorsítótárazás aktiválása esetén ez a paraméter állítja be a legnagyobb méretet. Írd be a gyorsítótárban tárolható URL-ek számát (további URL kerül feldolgozásra, de nem kerül be a gyorsítótárba, ezért a betöltés ideje hosszabb lesz). Általánosságban szólva, mindegyik URL körülbelül 200 bájtot tesz ki (100 a keresőbarát URL, és 100 a nem keresőbarát URL). Tehát, például  5000 URL kb. 1 MB memóriát fog felhasználni.');
define('COM_SH404SEF_TT_REDIRECT_JOOMLA_SEF_TO_SEF', 'Az <strong>Igen</strong> választása esetén a hagyományos JOOMLA SEF URL-ek az sh404SEF megfelelőikre kerülnek 301-es átirányításra, ha megtalálhatóak az adatbázisban. Ha nincs, akkor röptében létrehozásra kerülnek, ha nincs valamilyen POST adat, amikor is nem történik semmi. Warning: this feature will work in most cases, but may give bad redirects for some Joomla SEF URL. Leave off if possible.');
define('COM_SH404SEF_TT_REDIRECT_NON_SEF_TO_SEF', 'Az <strong>Igen</strong> választása esetén az adatbázisban már megtalálható nem keresőbarát URL egy 301 - Végleg áthelyezve átirányítással kerül átirányításra a keresőbarát változatra. Ha a keresőbarát URL nem létezik, akkor létrehozásra kerül, kivéve, ha van néhány továbbított POST adat az oldal kérésében.');
define('COM_SH404SEF_TT_REPLACEMENTS', 'Az URL-ben nem elfogadott karakterek, mint a nem-latin vagy ékezetes betűk, lecserélhetők e behelyettesítő táblázat alapján. <br />A behelyettesítési szabály formátuma xxx | yyy. Az xxx a lecserélendő karakter, az yyy pedig az új karakter. <br />Sok ilyen vesszővel (,) elválasztott szabály lehet. A régi és az új karakter között használd a | karaktert. <br />Az xxx vagy az yyy több karakter is lehet, mint például Ś|oe ');
define('COM_SH404SEF_TT_SHOP_NAME', 'A fenti paraméter Igenre állításával itt felülbírálhatod a keresőbarát URL-be beszúrt szöveget. Ez a szöveg változatlan lesz, és nem kerül lefordításra például.');
define('COM_SH404SEF_TT_TRANSLATE_URL', 'Ha aktiválod, és a webhely többnyelvű, akkor a keresőbarát URL elemei a Joomfish döntése alapján lefordításra kerülnek a látogató nyelvére. Ha nem aktiválod, akkor az URL mindig a webhely alapértelmezett nyelvén lesz. Nem kerül felhasználásra, ha a webhely nem többnyelvű.');
define('COM_SH404SEF_TT_USE_URL_CACHE', 'Aktiválás esetén a keresőbarát URL a memóriában lévő gyorsítótárba kerül beírásra, ami jelentősen meg fogja növelni az oldal betöltődésének idejét. Ez azonban fel fogja használni a memóriát!');
define('COM_SH404SEF_TT_VM_ADDITIONAL_TEXT', 'Az <strong>Igen</strong> választása esetén kiegészítő szöveg kerül hozzáfűzésre a tallózandó kategóriák URL-jeihez. Például : ..../kategoria-A/Az-osszes-termek-megtekintse.html VS ..../kategoria-A/ .');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORIES', 'A <strong>Nincs</strong> választása esetén egy kategória sem kerül beszúrásra a megtekintendő termékhez vezető URL-be, például : <br /> enlapom.hu/joomla-cms.html<br />A <strong>Csak az utolsó</strong> választása esetén annak a kategóriának a neve kerül beszúrásra a keresőbarát URL-be, amelyikbe a termék tartozik, például : <br /> enlapom.hu/joomla/joomla-cms.html<br /><strong>Az összes beágyazott kategória</strong> választása esetén az összes olyan kategóriának a neve hozzáadásra kerül, amelyikbe a termék tartozik, például : <br /> enlapom.hu/szoftver/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORY_ID', 'Az Igen választása esetén a kategóriaazonosító hozzáfűzésre kerül a termékhez vezető URL-ben a kategórianév elejéhez, mint itt : <br /> enlapom.hu/1-szoftver/4-cms/1-joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_FLYPAGE', 'Az Igen választása esetén a terméklap neve beszúrásra kerül a termékadatokhoz vezető URL-be. Letilthatod, ha csak egy terméklapot használsz.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_ID', 'Az Igen választása esetén a gyártó azonosítója hozzáfűzésre kerül a keresőbarát URL-ben a gyártó nevéhez az elején<br />Például : enlapom.hu/6-gyarto-neve/3-az-en-nagyon-szep-termekem.html.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_NAME', 'Az Igen választása esetén, ha meg van adva a gyártó neve, hozzáfűzésre kerül a termékre mutató keresőbarát URL-hez.<br />Például : enlapome.hu/gyarto-neve/termek-neve.html');
define('COM_SH404SEF_TT_VM_INSERT_SHOP_NAME', 'Az Igen választása esetén az üzlet neve (az üzlet menüpontjának címében meghatározottak alapján) mindig hozzáfűzésre kerül a keresőbarát URL elejéhez');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU', 'Az Igen választása esetén a cikkszám, az általad minden termékhez beírt termékkód kerül felhasználásra a termék teljes neve helyett.');
define('COM_SH404SEF_TT_SHOW_CAT','Az Igen választása esetén a kategórianév kizárásra kerül az URL-ből');
define('COM_SH404SEF_TT_SHOW_SECT','Az Igen választása esetén az URL tartalmazza a szekciónevet');
define('COM_SH404SEF_TT_STRIP_CHAR','Az URL-ből eltávolítandó karakterek, | szimbólummal elválasztva');
define('COM_SH404SEF_TT_SUFFIX','A \'fájlok\' esetén használandó kiterjesztés. Hagyd üresen, ha le akarod tiltani. Gyakori bejegyzés a \'html\'.');
define('COM_SH404SEF_TT_USE_ALIAS','A Cím aliasneve választása esetén a cím aliasneve kerül felhasználásra az URL-ben a cím helyett');
define('COM_SH404SEF_UNWRITEABLE',' <b><font color="red">írásvédett</font></b>');
define('COM_SH404SEF_UPLOAD_OK','A fájl feltöltése sikerült');
define('COM_SH404SEF_URL','URL');
define('COM_SH404SEF_URLEXIST','Már megtalálható ez az URL az adatbázisban!');
define('COM_SH404SEF_USE_ALIAS','Cím aliasnevének használata');
define('COM_SH404SEF_USE_DEFAULT','(alapértelmezett kezelő használata)');
define('COM_SH404SEF_USING_DEFAULT',' <b><font color="red">Alapértelmezett értékek használata</font></b>');
define('COM_SH404SEF_VIEW404','404 napló<br/>megtekintése/módosítása');
define('COM_SH404SEF_VIEW404DESC','A 404 napló megtekintése/módosítása');
define('COM_SH404SEF_VIEWCUSTOM','Egyéni átirányítások<br/>megtekintése/módosítása');
define('COM_SH404SEF_VIEWCUSTOMDESC','Az egyéni átirányítások megtekintése/módosítása');
define('COM_SH404SEF_VIEWMODE','NézetMód:');
define('COM_SH404SEF_VIEWURL','Keresőbarát URL-ek<br/>megtekintése/szerkesztése');
define('COM_SH404SEF_VIEWURLDESC','A keresőbarát URL-ek megtekintése/szerkesztése');
define('COM_SH404SEF_WARNDELETE','FIGYELEM!!!');
define('COM_SH404SEF_WRITE_ERROR','Hiba történt a konfigurációs fájl írásakor');
define('COM_SH404SEF_WRITE_FAILED','Nem írható a media könyvtárba feltöltött fájl');
define('COM_SH404SEF_WRITEABLE',' <b><font color="green">írható</font></b>');

// V 1.2.4.s
define('COM_SH404SEF_DOCMAN_TITLE', 'DOCMan beállításai');
define('COM_SH404SEF_DOCMAN_INSERT_NAME', 'A DOCMan nevének beszúrása');
define('COM_SH404SEF_TT_DOCMAN_INSERT_NAME', 'Az <strong>Igen</strong> választása esetén a DOCMan főoldalához vezető menüpont címe hozzáfűzésre kerül valamennyi DOCMan keresőbarát URL-hez');
define('COM_SH404SEF_DOCMAN_NAME', 'Alapértelmezett DOCMan név');
define('COM_SH404SEF_TT_DOCMAN_NAME', 'Ha az előző paraméternél az Igent választottad, akkor itt hatálytalaníthatod a keresőbarát URL-be beszúrt szöveget. Ez a szöveg állandó lesz, és nem kerül például lefordításra.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_ID', 'Dokumentum-azonosító beszúrása');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID', 'Az <strong>Igen</strong> választása esetén a dokumentum-azonosító hozzáfűzésre kerül a dokumentum nevéhez, amire az azonos nevű dokumentumok esetén van szükség.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME', 'A dokumentum nevének beszúrása');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME', 'Az <strong>Igen</strong> választása esetén a dokumentum neve minden olyan keresőbarát URL-be beszúrásra kerül, ami a dokumentumon végzendő művelethez vezet');
define('COM_SH404SEF_MYBLOG_TITLE', 'MyBlog beállításai');
define('COM_SH404SEF_MYBLOG_INSERT_NAME', 'A MyBlog nevének beszúrása');
define('COM_SH404SEF_TT_MYBLOG_INSERT_NAME', 'Az <strong>Igen</strong> választása esetén a MyBlog főldalához vezető menüpont címe hozzáfűzésre kerül az összes MyBlog keresőbarát URL-hez');
define('COM_SH404SEF_MYBLOG_NAME', 'Alapértelmezett Myblog név');
define('COM_SH404SEF_TT_MYBLOG_NAME', 'Ha az előző paraméternél az Igent választottad, akkor itt hatálytalaníthatod a keresőbarát URL-be beszúrt szöveget. Ez a szöveg állandó lesz, és nem kerül például lefordításra.');
define('COM_SH404SEF_MYBLOG_INSERT_POST_ID', 'A bejegyzés azonosítójának beszúrása');
define('COM_SH404SEF_TT_MYBLOG_INSERT_POST_ID', 'Az <strong>Igen</strong> választása esetén a belső hozzászólás-azoosító hozzáfűzésre kerül a hozzászólás címéhez, amire akkor van szükség, ha több bejegyzésnek azonos a címe.');
define('COM_SH404SEF_MYBLOG_INSERT_TAG_ID', 'A címkeazonosító beszúrűsa');
define('COM_SH404SEF_TT_MYBLOG_INSERT_TAG_ID', 'Az <strong>Igen</strong> választása esetén a belső címkeazonosító hozzáfűzésre kerül a címke nevéhez, amire több azonos címke esetén, vagy másik kategórianévvel történő ütközés van szükség.');
define('COM_SH404SEF_MYBLOG_INSERT_BLOGGER_ID', 'A blogger azonosítójának beszúrása');
define('COM_SH404SEF_TT_MYBLOG_INSERT_BLOGGER_ID', 'Az <strong>Igen</strong> választása esetén a belső bloggerazonosító hozzáfűzésre kerül a blogger nevéhez, amire több azonos nevű blogger esetén van szükség.');
define('COM_SH404SEF_RW_MODE_NORMAL', '.htaccess fájllal (mod_rewrite)');
define('COM_SH404SEF_RW_MODE_INDEXPHP', '.htaccess fájl nélkül (index.php)');
define('COM_SH404SEF_RW_MODE_INDEXPHP2', '.htaccess fájl nélkül (index.php?)');
define('COM_SH404SEF_SELECT_REWRITE_MODE', 'Átírási módszer');
define('COM_SH404SEF_TT_SELECT_REWRITE_MODE', 'Válaszd ki az sh404SEF átírási módszerét.<br /><strong>.htaccess fájllal (mod_rewrite)</strong><br />Alapértelmezett mód : kell lennie a kiszolgáló beállításaival megegyező, megfelelően konfigurált .htacces fájlnak<br /><strong>.htaccess (index.php) fájl nélkül</strong><br /><strong>KÍSÉRLETI :</strong>Nincs szükség .htaccess fájlra. Ez a módszer az Apacha kiszolgálók PathInfo funkcióját használja. Az URL-ek elején hozzáadásra kerül egy /index.php/ bit. Nem lehetetlen, hogy az IIS kiszolgálók is elfogadják ezeket az URL-eket<br /><strong>.htaccess fájl (index.php?) nélkül</strong><br /><strong>KÍSÉRLETI :</strong>Nincs szükség .htaccess fájlra. Ez a módszer az előzővel azonos, azzal a kivétellel, hogy az /index.php?/ kerül felhasználásra az /index.php/ helyett. Ismételten, az IIS kiszolgálók elfogadhatják ezeket az URL-eket<br />');
define('COM_SH404SEF_RECORD_DUPLICATES', 'Dupla URL-ek rögzítése');
define('COM_SH404SEF_TT_RECORD_DUPLICATES', 'Az <strong>Igen</strong> választása esetén az sh404SEF rögzíteni fog minden olyan nem keresőbarát URL-t az adatbázisban, melyek ugyanazt a keresőbarát URL-t eredményezik. Ez teszi lehetővé az előnyben részesített kiválasztását, a Dupla URL-ek kezelése funkcióval a keresőbarát URL megjeenítési listában.');
define('COM_SH404SEF_META_TITLE', 'Cím kódelem');
define('COM_SH404SEF_TT_META_TITLE', 'Írd be a kiválasztott URL <strong>META title</strong> kódelemébe beszúrandó szöveget.');
define('COM_SH404SEF_META_DESC', 'Leírás kódelem');
define('COM_SH404SEF_TT_META_DESC', 'Írd be a kiválasztott URL <strong>META description</strong> kódelemébe beszúrandó szöveget.');
define('COM_SH404SEF_META_KEYWORDS', 'Kulcsszavak kódelem');
define('COM_SH404SEF_TT_META_KEYWORDS', 'Írd be a kiválasztott URL <strong>META keywords</strong> kódelembe beszúrandó szöveget. A szavakat vagy szócsoportokat vesszővel válassza el.');
define('COM_SH404SEF_META_ROBOTS', 'Robots kódelem');
define('COM_SH404SEF_TT_META_ROBOTS', 'Írd be a kiválasztott URL <strong>META Robots</strong> kódelemébe beszúrandó szöveget. Ez a kódelem mondja meg a keresőrendszereknek, hogy kell-e követniük a hivatkozásokat az aktuális oldalon, és mi a teendő ennek az oldalnak a tartalmával. A szokásos értékek :<br /><strong>INDEX,FOLLOW</strong> : indexeli az aktuális oldal tartalmát, és követi az oldalon található összes hivatkozást<br /><strong>INDEX,NO FOLLOW</strong> : indexeli az aktuális oldal tartalmát, de nem követi az oldalon talált hivatkozásokat<br /><strong>NO INDEX, NO FOLLOW</strong> : nem indexeli a jelenlegi oldal tartalmát, és nem követi az oldalon talált hivatkozásokat<br />');
define('COM_SH404SEF_META_LANG', 'Nyelv kódelem');
define('COM_SH404SEF_TT_META_LANG', 'Írd be a kiválasztott URL <strong>META http-equiv= Content-Language </strong> kódelembe beszúrandó szöveget. ');
define('COM_SH404SEF_CONF_TAB_META', 'Meta/SEO');
define('COM_SH404SEF_CONF_META_DOC', 'Az sh404SEF-nek több beépülő modulja van némely komponens metaadatainak <strong>automatikus</strong> generálásához. Csak akkor készítsd el őket kézzel, ha az automatikusan készítettek nem felelnek meg neked!!<br>');
define('COM_SH404SEF_REMOVE_JOOMLA_GENERATOR', 'A Joomla Generator kódelem eltávolítása');
define('COM_SH404SEF_TT_REMOVE_JOOMLA_GENERATOR', 'Az <strong>Igen</strong> választása esetén a Generator = Joomla meta kódelem eltávolításra kerül mindazon oldalból');
define('COM_SH404SEF_PUT_H1_TAG', 'A h1 kódelemek beszúrása');
define('COM_SH404SEF_TT_PUT_H1_TAG', 'Az <strong>Igen</strong> választása esetén a tartalmi elemek hagyományos címeit a h1 kódelemekbe teszi. Normál esetben a Joomla a <strong>contentheading</strong> névvel kezdődő CSS-osztályba teszi őket.');
define('COM_SH404SEF_META_MANAGEMENT_ACTIVATED', 'A metaadatok kezelésének aktiválása');
define('COM_SH404SEF_TT_META_MANAGEMENT_ACTIVATED', 'Az <strong>Igen</strong> választása esetén a Title, Description, Keywords, Robots és a Language META kódelemet az sh404SEF fogja kezelni. Egyéb esetben a Joomla és/vagy más komponen által produkált eredeti értékek érintetlenek maradnak. ');
define('COM_SH404SEF_TITLE_META_MANAGEMENT', 'Metaadatok kezelése');
define('COM_SH404SEF_META_EDIT', 'A kódelemek módosítása');
define('COM_SH404SEF_META_ADD', 'Kódelemek hozzáadása');
define('COM_SH404SEF_META_TAGS', 'META kódelemek');
define('COM_SH404SEF_META_TAGS_DESC', 'Meta kódelemek létrehozása/módosítása');
define('COM_SH404SEF_PURGE_META_DESC', 'Meta kódelemek törlése');
define('COM_SH404SEF_PURGE_META', 'META törlése');
define('COM_SH404SEF_IMPORT_EXPORT_META', 'META importálása/exportálása');
define('COM_SH404SEF_NEW_META', 'Új META');
define('COM_SH404SEF_NEWURL_META', 'Nem keresőbarát URL');
define('COM_SH404SEF_TT_NEWURL_META', 'Írd be azt a nem keresőbarát URL-t, melynek meg akarod adni a metaadatait. FIGYELMEZTETÉS: az elején <strong>index.php</strong> legyen!');
define('COM_SH404SEF_BAD_META', 'Kérjük, ellenőrizd az adatokat: néhány bevitel nem érvényes.');
define('COM_SH404SEF_META_TITLE_PURGE', 'Metaadatok törlése');
define('COM_SH404SEF_META_SUCCESS_PURGE', 'Törölt metaadatok');
define('COM_SH404SEF_IMPORT_META', 'Metaadatok importálása');
define('COM_SH404SEF_EXPORT_META', 'Metaadatok exportálása');
define('COM_SH404SEF_IMPORT_META_OK', 'A metaadatok importálása sikerült');
define('COM_SH404SEF_SELECT_ONE_URL', 'Válassz ki egy (de csak egy) URL-t.');
define('COM_SH404SEF_MANAGE_DUPLICATES', 'URL-kezelés : ');
define('COM_SH404SEF_MANAGE_DUPLICATES_RANK', 'Rang');
define('COM_SH404SEF_MANAGE_DUPLICATES_BUTTON', 'Dupla URL');
define('COM_SH404SEF_MANAGE_MAKE_MAIN_URL', 'Fő URL');
define('COM_SH404SEF_BAD_DUPLICATES_DATA', 'Hiba : érvénytelen az URL adat');
define('COM_SH404SEF_BAD_DUPLICATES_NOTHING_TO_DO', 'Ez az URL már a fő URL');
define('COM_SH404SEF_MAKE_MAIN_URL_OK', 'A művelet sikeresen befejeződött');
define('COM_SH404SEF_MAKE_MAIN_URL_ERROR', 'Hiba történt, a művelet sikertelen');
define('COM_SH404SEF_CONTENT_TITLE', 'Tartalom beállításai');
define('COM_SH404SEF_INSERT_CONTENT_TABLE_NAME', 'A tartalomtáblázat nevének beszúrása');
define('COM_SH404SEF_TT_INSERT_CONTENT_TABLE_NAME', 'Az <strong>Igen</strong> választása esetén a cikkek táblázatához (szekció vagy kategória) vezető menüpont címe hozzáfűzésre kerül a keresőbarát URL-hez. Ez teszi lehetővé a táblázat megjelenítésének elkülönítését a blogszerű megjelenítéstől.');
define('COM_SH404SEF_CONTENT_TABLE_NAME', 'Táblázat alapértelmezett hivatkozásnevei');
define('COM_SH404SEF_TT_CONTENT_TABLE_NAME', 'Ha az előző paraméternél az Igent választotta, akkor itt hatálytalaníthatja a keresőbarát URL-be beszúrandó szöveget. Ez a szöveg állandó lesz, és nem kerül például lefordításra.');
define('COM_SH404SEF_REDIRECT_WWW', '301-es átirányítás www/nem-www');
define('COM_SH404SEF_TT_REDIRECT_WWW', 'Az Igen választása esetén az sh404SEF 301-es átirányítást hajt végre a webhely www nélküli elérése esetén, ha a webhely URL-je www-vel kezdődik, vagy a webhely elérése kezdő www-vel történik, holott a fő URL-ben nincs www. Ezzel megelőzheted a dupla tartalom miatt kapott büntetést, az Apache kiszolgáló beállításaitól függő néhány problémát, és néhány Joomla-problémát is (WYSYWIG szerkesztők)');
define('COM_SH404SEF_INSERT_PRODUCT_NAME', 'A terméknév beszúrása');
define('COM_SH404SEF_TT_INSERT_PRODUCT_NAME', 'Az Igen választása esetén a terméknév beszúrásra kerül az URL-be');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU_124S', 'A cikkszám beszúrása');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU_124S', 'Az Igen választása esetén a cikkszám (a Virtuemartban SKU) beszúrásra kerül az URL-be.');

// V 1.2.4.t
define('COM_SH404SEF_DOCMAN_INSERT_CAT_ID', 'Kategória-azonosító beszúrása');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID', 'Az <strong>Igen</strong> választása esetén a kategória-azonosító hozzáfűzésre kerül a nevének elejéhez, <strong>ha az előző tulajdonságot is Igenre állítottad</strong>, két azonos nevű kategória esetén.');
define('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES', 'Kategórianév beszúrása');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES', 'A <strong>Nincs</strong> választása esetén nem kerül a kategórianév beszúrásra az URL-be, mint : <br /> weblapom.hu/joomla-cms.html<br />A <strong>Csak az utolsó</strong> választása esetén a kategórianév beszúrásra kerül a keresőbarát URL-be, mint : <br /> weblapom.hu/joomla/joomla-cms.html<br /><strong>Az összes beágyazott kategória</strong> választása esetén valamennyi kategórianév hozzáadásra kerül, mint : <br /> weblapom.hu/szoftverek/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_FORCED_HOMEPAGE', 'Címlap URL-je');
define('COM_SH404SEF_TT_FORCED_HOMEPAGE', 'Ide írhatod be a kényszerített címlap URL-t. `Kezdőlap` használata esetén hasznos, általában egy index.html fájl, ami a www.weblapom.hu felkeresésekor látható. Ha így van, akkor írd be a következő URL-t: www.weblapom.hu/index.php (sorvégi / nélkül), vagyis a Joomla webhely a főmenü vagy az útvonal Címlap hivatkozására kattintáskor jelenik meg');
define('COM_SH404SEF_INSERT_CONTENT_BLOG_NAME', 'A blog nézet nevének beszúrása');
define('COM_SH404SEF_TT_INSERT_CONTENT_BLOG_NAME', 'Az <strong>Igen</strong> választása esetén a (szekció vagy kategória) cikkeinek blogjához vezető menüpont címe hozzáfűzésre kerül a keresőbarát URL elejéhez. Ez teszi lehetővé a táblázatos elrendezés megkülönböztetését a blog elrendezéstől.');
define('COM_SH404SEF_CONTENT_BLOG_NAME', 'A blog nézet alapértelmezett neve');
define('COM_SH404SEF_TT_CONTENT_BLOG_NAME', 'Az előző paraméter Igenre állítása esetén itt hatálytalaníthatod a keresőbarát URL-be beszúrt szöveget. Ez a szöveg változatlan marad, és nem kerül lefordításra például.');
define('COM_SH404SEF_MTREE_TITLE', 'Mosets Tree beállításai');
define('COM_SH404SEF_MTREE_INSERT_NAME', 'A Mosets Tree nevének beszúrása');
define('COM_SH404SEF_TT_MTREE_INSERT_NAME', 'Az <strong>Igen</strong> választása esetén a Mosets Treehez vezető menüpont címe hozzáfűzésre kerül a keresőbarát URL elejéhez.');
define('COM_SH404SEF_MTREE_NAME', 'A Mosets Tree alapértelmezett neve');
define('COM_SH404SEF_MTREE_INSERT_LISTING_ID', 'Tétel azonosítószámának beszúrása');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_ID', 'Az <strong>Igen</strong> választása esetén a tétel azonosítószáma hozzáfűzésre kerül a név elejéhez, de csak akkor, ha két tételnek ugyanaz a neve.');
define('COM_SH404SEF_MTREE_PREPEND_LISTING_ID', 'Az azonosító hozzáfűzése a név elejéhez');
define('COM_SH404SEF_TT_MTREE_PREPEND_LISTING_ID', 'Az <strong>Igen</strong> választása esetén, ha a fenti tulajdonságot is Igenre állította, akkor az azonosító <strong>hozzáfűzésre</strong> kerül a tétel nevének elejéhez. A Nem választása esetén a <strong>végére</strong> kerül hozzáfűzésre.');
define('COM_SH404SEF_MTREE_INSERT_LISTING_NAME', 'A tétel nevének beszúrása');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_NAME', 'Az <strong>Igen</strong> választása esetén a tétel neve beszúrásra kerül a tétellel kapcsolatos művelethez vezető összes URL-be.');

define('COM_SH404SEF_IJOOMLA_NEWSP_TITLE', 'iJoomla News Portal beállításai');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_NAME', 'Az iJoomla News Portal nevének beszúrása');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_NAME', 'Az <strong>Igen</strong> választása esetén az iJoomla News Portalhoz vezető menüpont címe hozzáfűzésre kerül a keresőbarát URL elejéhez.');
define('COM_SH404SEF_IJOOMLA_NEWSP_NAME', 'Az iJoomla News Portal alapértelmezett neve');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_CAT_ID', 'A kategória-azonosító beszúrása');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_CAT_ID', 'Az <strong>Igen</strong> választása esetén a kategória-azonosító hozzáfűzésre kerül név elejéhez, de csak akkor, ha ugyanaz két tételnek a neve.');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'A szekció-azonosító beszúrása');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'Az <strong>Igen</strong> választása esetén a szekcióazonosító hozzáfűzésre kerül név elejéhez, de csak akkor, ha ugyanaz két tételnek a neve.');
define('COM_SH404SEF_REMO_TITLE', 'Remository beállításai');
define('COM_SH404SEF_REMO_INSERT_NAME', 'A Remository nevének beszúrása');
define('COM_SH404SEF_TT_REMO_INSERT_NAME', 'Az <strong>Igen</strong> választása esetén a Remositoryhoz vezető menüpont címe hozzáfűzésre kerül a keresőbarát URL elejéhez.');
define('COM_SH404SEF_REMO_NAME', 'A Remository alapértelmezett neve');
define('COM_SH404SEF_CB_SHORT_USER_URL', 'A felhasználó profiljára mutató rövid URL');
define('COM_SH404SEF_TT_CB_SHORT_USER_URL', 'Az <strong>Igen</strong> választása esetén a felhasználó rövid URL-en keresztül tud hozzáférni a profiljához, mely hasonló a www.weblapom.hu/felhasznalonev URL-hez. E tulajdonság aktiválása előtt győződj meg róla, hogy ez nem okoz-e valamilyen ütközést a webhelyen lévő valamelyik URL-lel.');
define('COM_SH404SEF_NEW_HOME_META', 'Címlap metaadatai');
define('COM_SH404SEF_CONF_ERASE_HOME_META', 'Valóban törölni akarod a címlap címét és meta kódelemeit?');
define('COM_SH404SEF_UPGRADE_TITLE', 'Termékfrissítés beállításai');
define('COM_SH404SEF_UPGRADE_KEEP_URL', 'Automatikusan generált URL-ek megőrzése');
define('COM_SH404SEF_TT_UPGRADE_KEEP_URL', 'Az <strong>Igen</strong> válaztása esetén az sh404SEf által generált keresőbarát URL tárolásra és megőrzésre kerül a komponens eltávolításakor. Így új verzió telepítésekor további művelet végrehajtása nélkül visszakapod őket.');
define('COM_SH404SEF_UPGRADE_KEEP_CUSTOM', 'Egyéni URL-ek megőrzése');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CUSTOM', 'Az <strong>Igen</strong> választása esetén az általad létrehozott egyéni keresőbarát URL tárolásra és megőrzésre kerül a komponens eltávolításakor. Így új verzió telepítésekor további művelet végrehajtása nélkül visszakapod őket.');
define('COM_SH404SEF_UPGRADE_KEEP_META', 'Cím és metaadatok megőrzése');
define('COM_SH404SEF_TT_UPGRADE_KEEP_META', 'Az <strong>Igen</strong> választása esetén az általad beírt egyéni Cím és meta kódelemek tárolásra és megőrzésre kerülnek a komponens eltávolításakor. Így új verzió telepítésekor további művelet végrehajtása nélkül visszakapod őket.');
define('COM_SH404SEF_UPGRADE_KEEP_MODULES', 'Modulparaméterek megőrzése');
define('COM_SH404SEF_TT_UPGRADE_KEEP_MODULES', 'Az <strong>Igen</strong> választása esetén a Joomfish és az shCustomtags modul jelenlegi közzétételi paraméterei, mint pozíció, sorrend, címek, stb. tárolásra és megőrzésre kerülnek a komponens eltávolításakor. Így új verzió telepítésekor további művelet végrehajtása nélkül visszakapod őket.');
define('COM_SH404SEF_IMPORT_OPEN_SEF','Átirányítások importálása az OpenSEF-ből');
define('COM_SH404SEF_IMPORT_ALL','Átirányítások importálása');
define('COM_SH404SEF_EXPORT_ALL','Átirányítások exportálása');
define('COM_SH404SEF_IMPORT_EXPORT_CUSTOM','Egyéni átirányítások importálása/exportálása');
define('COM_SH404SEF_DUPLICATE_NOT_ALLOWED', 'Ez az URL már létezik, pedig nem is engedélyezted a dupla URL-eket');
define('COM_SH404SEF_INSERT_CONTENT_MULTIPAGES_TITLE', 'Többoldalas cikkek intelligens címeinek aktiválása');
define('COM_SH404SEF_TT_INSERT_CONTENT_MULTIPAGES_TITLE', 'Az Igen választásakor többoldalas cikk esetén (melyeknek tartalomjegyzékük van), az sh404SEF a mospagebreak paranccsal beszúrt oldalcímeket fogja használni : {mospagebreak title=Következő_oldal_címe & heading=Előző_oldal_címe}, az oldalszám helyett<br />Például, a www.weblapom.hu/felhasznaloi-dokumentacio/<strong>Page-2</strong>.html címhez hasonló keresőbarát URL most lecserélésre kerül a www.weblapom.hu/felhasznaloi-dokumentacio/<strong>Getting-started-with-sh404SEF</strong>.html URL-re.');

// v x
define('COM_SH404SEF_UPGRADE_KEEP_CONFIG', 'Beállítások megőrzése');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CONFIG', 'Az Igen választásakor az összes beállítási paraméter tárolásra és megőrzésre kerül a komponens eltávolításakor. Így új verzió telepítése esetén mindig megmaradnak, és nincs szükség további műveletre.');
define('COM_SH404SEF_CONF_TAB_SECURITY', 'Biztonság');
define('COM_SH404SEF_SECURITY_TITLE', 'Biztonsági beállítások');
define('COM_SH404SEF_HONEYPOT_TITLE', 'A Project Honey Pot konfigurálása');
define('COM_SH404SEF_CONF_HONEYPOT_DOC', 'A Project Honey Pot olyan kezdeményezés, mely a webhelyek spamrobotok elleni védekezésében nyújt segítséget. Van egy adatbázisa, melyben ellenőrzi, hogy a látogató IP címe nem ismert roboté-e. Ennek az adatbázisnak a használatához (ingyenes) hozzáférési kulcsra van szükség, melyet <a href="http://www.projecthoneypot.org/httpbl_configure.php">a projekt webhelyén</a> szerezhetsz be<br />(Létre kell hoznod a fiókodat a hozzáférési kulcs kérése előtt - ez is ingyenes). Esetleg vedd fontolóra, hogy a webhelyeden elhelyezett csapdákkal segíted a spamrobotok beazonosítását.');
define('COM_SH404SEF_ACTIVATE_SECURITY', 'A biztonsági funkciók aktiválása');
define('COM_SH404SEF_TT_ACTIVATE_SECURITY', 'Az Igen választásakor az sh404SEF néhány alapszintű ellenőrzést végez a webhelyeden kért URL-eken, hogy védelmet nyújtson a szokásos támadások ellen.');
define('COM_SH404SEF_LOG_ATTACKS', 'Támadások naplózása');
define('COM_SH404SEF_TT_LOG_ATTACKS', 'Az Igen választásakor a beazonosított támadások szövegfájlban kerülnek naplózásra, a támadó IP címével és a kért oldallal.<br />Havonta egy naplófájl készül. Az <site root>/administrator/com_sef/logs könyvtárban találhatók. FTP-vel le tudod őket tölteni, vagy egy Joomla segédeszközzel, mint a joomlaXplorer megtekintheted őket. Ezek tabulált szövegfájlok, tehát táblázatkezelő szoftverben könnyen meg tudod őket nyitni, valószínűleg így tudod a legkönnyebben megtekinteni.');	            
define('COM_SH404SEF_CHECK_HONEY_POT', 'A Project Honey Pot használata');
define('COM_SH404SEF_TT_CHECK_HONEY_POT', 'Az Igen választásakor a látogatók IP címe ellenőrzésre kerül a Project Hoeny Pot adatbázisban a HTTP:BL szolgáltatásuk felhasználásával. A szolgáltatás ingyenes, viszont hozzáférési kulcsra van szükség a webhelyen.');
define('COM_SH404SEF_HONEYPOT_KEY', 'Project Honey Pot hozzáférési kulcs');
define('COM_SH404SEF_TT_HONEYPOT_KEY', 'Ha kijelölted A Project Honey Pot használata beállítást, akkor be kell szerezned a P.H.P.-től a hozzáférési kulcsot. Ide írd be a kapott hozzáférési kulcsot. Ez egy 12 karakteres karakterlánc.');	             
define('COM_SH404SEF_HONEYPOT_ENTRANCE_TEXT', 'Vagylagos szöveg');
define('COM_SH404SEF_TT_HONEYPOT_ENTRANCE_TEXT', 'Ha a Project Honey Pot gyanúsnak jelöli egy látogató IP címét, akkor a hozzáférés meg lesz tagadva a számára (403 hibakód). <br />Hamis megállapítás esetén azonban az ide beírt szöveget fogja látni a látogató, valamint egy olyan hivatkozást, amivel tényleg elérheti a weboldalt. Csak az emberi lények tudják elolvasni ezt a szöveget, és csak a számukra érthető. <br />Ez tetszés szerinti szöveg lehet.' );	             
define('COM_SH404SEF_SMELLYPOT_TEXT', 'A robotcsapda szövege');
define('COM_SH404SEF_TT_SMELLYPOT_TEXT', 'Ha a Project Honey Pot beazonosít egy spamrobotot, és megtagadja számára a hozzáférést, akkor az elutasító képernyő alján egy hivatkozás kerül beszúrásra, hogy a Project Honey Pot rögzíthesse a robot ténykedését. Egy üzenet is beszúrásra kerül, hogy a valódi emberi lények ne kattintsanak arra a hivatkozásra, ha hibás a megjelölésük. ');
define('COM_SH404SEF_ONLY_NUM_VARS', 'Numerikus paraméterek');
define('COM_SH404SEF_TT_ONLY_NUM_VARS', 'Az ebben a listában lévő paraméternevek ellenőrzésre kerülnek, hogy valóban numerikusak-e : csak 0 és 9 közti számjegyek-e. Soronként egy paramétert írj be.');
define('COM_SH404SEF_ONLY_ALPHA_NUM_VARS', 'Alfanumerikus paraméterek');
define('COM_SH404SEF_TT_ONLY_ALPHA_NUM_VARS', 'Az ebben a listában lévő paraméternevek ellenőrzésre kerülnek, hogy valóban alfanumerikusak-e : 0 és 9 közti számjegyek, ill. a és z közti betűk. Soronként egy paramétert írj be.');
define('COM_SH404SEF_NO_PROTOCOL_VARS', 'Hiperhivatkozások ellenőrzése a paraméterekben');
define('COM_SH404SEF_TT_NO_PROTOCOL_VARS', 'Az ebben a listában lévő paraméternevek ellenőrzésre kerülnek, hogy nincs-e bennük http://, https://, ftp:// hiperhivatkozás');
define('COM_SH404SEF_IP_WHITE_LIST', 'IP fehérlista');
define('COM_SH404SEF_TT_IP_WHITE_LIST', 'Az ebben a listában lévő IP címekről érkező oldalkérések <stong>elfogadásra</strong> kerülnek, amennyiben az URL átmegy a fent említett ellenőrzéseken. Soronként egy IP címet írj be.<br />A * használható karakterhelyettesítőként, mint példáuul : 192.168.0.*. Ez a 192.168.0.0 és 192.168.0.255 közti IP-ket foglalja magába.');
define('COM_SH404SEF_IP_BLACK_LIST', 'IP feketelista');
define('COM_SH404SEF_TT_IP_BLACK_LIST', 'Az ebben a listában lévő IP címekről érkező oldalkérések <strong>elutasításra</strong> kerülnek, amennyiben az URL átmegy a fent említett ellenőrzéseken. Soronként egy IP címet írj be.<br />A * használható karakterhelyettesítőként, mint példáuul : 192.168.0.*. Ez a 192.168.0.0 és 192.168.0.255 közti IP-ket foglalja magába.');
define('COM_SH404SEF_UAGENT_WHITE_LIST', 'Felhasználói ügynök fehérlista');
define('COM_SH404SEF_TT_UAGENT_WHITE_LIST', 'Az ebben a listában lévő felhasználói ügynök karakterlánccal történt kérések <stong>elfogadásra</strong> kerülnek, amennyiben az URL átmegy a fent említett ellenőrzéseken. Soronként egy felhasználói ügynök karakterláncot írj be.');
define('COM_SH404SEF_UAGENT_BLACK_LIST', 'Felhasználói ügynök feketelista');
define('COM_SH404SEF_TT_UAGENT_BLACK_LIST', 'Az ebben a listában lévő felhasználói ügynök karakterlánccal történt kérések <strong>elutasításra</strong> kerülnek, amennyiben az URL átmegy a fent említett ellenőrzéseken. Soronként egy felhasználói ügynök karakterláncot írj be.');
define('COM_SH404SEF_MONTHS_TO_KEEP_LOGS', 'A biztonsági naplók megőrzésének időtartama (hónapok)');
define('COM_SH404SEF_TT_MONTHS_TO_KEEP_LOGS', 'Ha aktiválod a támadások naplózását, akkor itt adhatod meg, hogy hány hónapig kerüljenek megőrzésre ezek a naplófájlok. Ha például ez az érték 2, akkor ez azt jelenti, hogy a jelenlegi hónap, PLUSZ az előző havi naplófájlok kerülnek megőrzésre. A régebbi naplófájlok törlésre kerülnek.');
define('COM_SH404SEF_ANTIFLOOD_TITLE', 'Anti-flood beállításai');
define('COM_SH404SEF_ACTIVATE_ANTIFLOOD', 'Az anti-flood aktiválása');
define('COM_SH404SEF_TT_ACTIVATE_ANTIFLOOD', 'Az Igen választásakor az sh404SEF ellenőrzi, hogy egy adott IP címnek nincs-e túl sok oldalkérése a webhelyeden. Sok, közvetlenül egymás utáni kérés esetén egy kalóz egyszerűen a túlterheléssel használhatatlanná teheti a webhelyet.');
define('COM_SH404SEF_ANTIFLOOD_ONLY_ON_POST', 'Csak POST adatok (űrlapok) esetén');
define('COM_SH404SEF_TT_ANTIFLOOD_ONLY_ON_POST', 'Az Igen választásakor erre az ellenőrzésre csak akkor kerül sor, ha van néhány POST adat az oldalkérésben. Általában ez az eset áll fönn az űrlapoknál, vagyis az anti-flood ellenőrzést korlátozhatod csak az űrlapokra, ami megakadályozza a hozzászólásokat spammelő robotok ténykedését.');
define('COM_SH404SEF_ANTIFLOOD_PERIOD', 'Anti-flood ellenőrzés');
define('COM_SH404SEF_TT_ANTIFLOOD_PERIOD', 'Időtartam (másodpercben), melynek letelte után az ugyanarról az IP címről érkező kérések száma ellenőrzésre kerül');
define('COM_SH404SEF_ANTIFLOOD_COUNT', 'A kérések száma');
define('COM_SH404SEF_TT_ANTIFLOOD_COUNT', 'A kérések száma, mely az oldalak blokkolását váltja ki a sértő IP cím esetén. Az Időtartam = 10 és a Kérések száma = 4 például blokkolni fogja a hozzáférést (403-as kód, és majdnem üres oldal visszaadásával), amint 10 másodpercnél kevesebb idő alatt fogadja egy adott IP címről a 4 kérést. Természetesen csak erről az IP címről érkező hozzáférés kerül blokkolásra, a többi látogatóé nem.');
define('COM_SH404SEF_CONF_TAB_LANGUAGES', 'Nyelvek');
define('COM_SH404SEF_DEFAULT', 'Alapértelmezett');
define('COM_SH404SEF_YES', 'Igen');
define('COM_SH404SEF_NO', 'Nem');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_PER_LANG', 'Az Igen választásakor a nyelvi kód beszúrásra kerül <strong>ehhez a nyelvhez</strong> az URL-be. A Nem választásakor a nyelvi kód soha nem kerül beszúrásra. Az Alapértelmezett választásakor a webhely alapértelmezett nyelvét kivéve az összes nyelvhez beszúrásra kerül a nyelvi kód.');
define('COM_SH404SEF_TT_TRANSLATE_URL_PER_LANG', 'Az Igen választásakor, és ha többnyelvű a webhelyed, akkor az URL lefordításra kerül az <strong>ilyen nyelvű</strong> URL-hez, a Joom!Fish beállításaival összhangban. A Nem választásakor az URL sohasem kerül lefordításra. Az Alapértelmezett választásakor is lefordításra kerülnek. Az egynyelvű webhelyekre nincs hatással.');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_GEN', 'Az Igen választásakor nyelvi kód kerül beszúrásra az sh404SEF által létrehozott URL-be. Nyelvenkénti beállítása is lehet (lásd alább).');
define('COM_SH404SEF_TT_TRANSLATE_URL_GEN', 'Az Igen választásakor, és ha többnyelvű a webhelyed, akkor az URL lefordításra kerül a látogató nyelvére, a Joom!Fish beállításaival összhangban. Egyéb esetben az URL a webhely alapértelmezett nyelvén marad. Nyelvenkénti beállításod is lehet (lásd alább).');
define('COM_SH404SEF_ADV_COMP_DEFAULT_STRING', 'Alapértelmezett név');
define('COM_SH404SEF_TT_ADV_COMP_DEFAULT_STRING', 'Ha beírsz ide egy karakterláncot, akkor az kerül beszúrásra az adott komponens URL-jének elejére. Normál esetben nincs használatban, csak itt más keresőbarát komponensek régi URL-jeivel történő visszamenőleges kompatibilitás céljából.');
define('COM_SH404SEF_TT_NAME_BY_COMP', '. <br />Beírhatsz egy nevet, mely a menüpont neve helyett kerül felhasználásra. Ehhez válts át a <strong>Komponensek</strong> fülre. Ez a szöveg állandó lesz, és nem kerül például lefordításra.');
define('COM_SH404SEF_STANDARD_ADMIN', 'Click here to switch to standard display (with only main parameters)');
define('COM_SH404SEF_ADVANCED_ADMIN', 'Kattints ide a kibővített nézetre történő átváltáshoz (az összes létező paraméterrel)');
define('COM_SH404SEF_MULTIPLE_H1_TO_H2', 'Több h1 módosítása h2-re');
define('COM_SH404SEF_TT_MULTIPLE_H1_TO_H2', 'Az Igen választásakor, és ha a h1 kódelem többször fordul elő egy oldalon, akkor átalakításra kerülnek h2 kódelemmé.<br />Ha csak egy h1 kódelem van egy oldalon, akkor változatlanul marad.');
define('COM_SH404SEF_INSERT_NOFOLLOW_PDF_PRINT', 'A nofollow kódelem beszúrása a Nyomtatás és a PDF hivatkozásokba');
define('COM_SH404SEF_TT_INSERT_NOFOLLOW_PDF_PRINT', 'Az Igen választásakor a rel=nofollow attribútum hozzáadásra kerül a Joomla által létrehozott összes PDF és Nyomtatás hivatkozáshoz. Ez csökkenti a keresőmotorok által duplának vélt tartalmat.');
define('COM_SH404SEF_INSERT_READMORE_PAGE_TITLE', 'A cím beszúrésa a Bővebben ... hivatkozásokba');
define('COM_SH404SEF_TT_INSERT_READMORE_PAGE_TITLE', 'Az Igen választásakor, és ha látható a Bővebben hivatkozás egy oldalon, akkor beszúrásra kerül a megfelelő tartalmi elem címe, ami növeli a hivatkozás súlyát a keresőmotorokban');
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
define('COM_SH404SEF_TT_DEBUG_TO_LOG_FILE', 'If set to Yes, sh404SEF will log to a text file many internal information. This data will help us troubleshoot problems you may be facing using sh404SEF. <br/>Warning: this file can quickly become fairly big. Also, this function will certainly slow down your site. Be sure to turn it on only when required. For this reason, it will de-activate automaticaly one hour after being started. Just turn it off then on again to activate it again. The log file is located in /administrator/components/com_sef/logs/ ');

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
