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
// German Translation by M. Stenzel - mastergizmo@arcor.de, Matrikular - coicvc@web.de
//
// Additions by Yannick Gaultier (c) 2006-2010

/**
 * Translation Updates
 *
 * 2008.02.23 mic [ http://www.joomx.com ]
 * 2010.05.28 Jürgen Hörmann <info@juergenhoermann.de>
 */
 
// Dont allow direct linking
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

define('COM_SH404SEF_404PAGE',              '404 Seite');
define('COM_SH404SEF_ADD',                'Hinzufügen');
define('COM_SH404SEF_ADDFILE',              'Standard Indexdatei');
define('COM_SH404SEF_ASC',                ' (aufsteigend) ');
define('COM_SH404SEF_BACK',               'Zurück zur sh404SEF Konfigurationsübersicht');
define('COM_SH404SEF_BADURL',             'Die alte Nicht-SEF Url muss mit index.php beginnen');
define('COM_SH404SEF_CHK_PERMS',            'Bitte die Dateiberechtigungen überprüfen und sicherstellen, dass auf die Datei zugegriffen werden kann.');
define('COM_SH404SEF_CONFIG',             'Konfiguration');
define('COM_SH404SEF_CONFIG_DESC',            'Alle sh404SEF-Einstellungen konfigurieren');
define('COM_SH404SEF_CONFIG_UPDATED',         'Änderungen erfolgreich gespeichert');
define('COM_SH404SEF_CONFIRM_ERASE_CACHE',        'Soll der URL-Cache geleert werden? Das ist nach Konfigurationsänderungen dringend empfohlen. Um den Cache wieder aufzubauen, die Webseite nochmals aufrufen, oder besser eine Sitemap verwenden');
define('COM_SH404SEF_COPYRIGHT',            'Copyright');
define('COM_SH404SEF_DATEADD',              'Datum hinzugefügt');
define('COM_SH404SEF_DEBUG_DATA_DUMP',          'DEBUG DATA DUMP COMPLETE: Laden der Seite abgebrochen');
define('COM_SH404SEF_DEF_404_MSG',                      '<h1>Schlechtes Karma : Wir konnten diese Seite nicht finden!</h1>
<p>Sie haben die Seite <strong>{%sh404SEF_404_URL%}</strong> aufgerufen. Obwohl unsere Server unter Einsatz aller Kräfte nach der Seite gesucht haben, konnten wir sie nicht finden. Was ist passiert?</p>
<ul>
<li>Der Link &uuml;ber den Sie hierher gelangt sind hat einen Schreibfehler.</li>
<li>Möglicherweise haben wir diese Seite gelöscht oder umbenannt.</li>
<li>Oder, was eher unwahrscheinlich ist, Sie haben den URL von Hand eingegeben und sich dabei vertippt?</li>
</ul>
<h4>{sh404sefSimilarUrlsCommentStart}Es ist noch nicht alles verloren &mdash; m&ouml;glicherweise interessiert Sie eine der folgenden Seiten:{sh404sefSimilarUrlsCommentEnd}</h4>
<p>{sh404sefSimilarUrls}</p>
<p> </p>');
define('COM_SH404SEF_DEF_404_PAGE',           'Standard 404 Seite');
define('COM_SH404SEF_DESC',               ' (absteigend) ');
define('COM_SH404SEF_DISABLED',             'Hinweis: Die SEF Unterstützung in diesem CMS ist momentan deaktiviert. Um SEF zu benutzen, muss in der <a href="' . $GLOBALS['shConfigLiveSite'] .'/administrator/index.php?option=com_config">Systemsteuerung</a> unter dem TAB SEO die SEF-Urls aktiviert werden' );
define('COM_SH404SEF_EDIT',               'Bearbeiten');
define('COM_SH404SEF_EMPTYURL',             'Es muss eine URL für die Umleitung angeben werden');
define('COM_SH404SEF_ENABLED',              'Aktiviert');
define('COM_SH404SEF_ERROR_IMPORT',           'Fehler während des Imports:');
define('COM_SH404SEF_EXPORT',             'Exportieren');
define('COM_SH404SEF_EXPORT_FAILED',          'EXPORT FEHLGESCHLAGEN!!!');
define('COM_SH404SEF_FATAL_ERROR_HEADERS',        'SCHWERER FEHLER: Header wurde bereits gesendet');
define('COM_SH404SEF_FRIENDTRIM_CHAR',          'Zeichen am Anfang oder Ende entfernen');
define('COM_SH404SEF_HELP',               'sh404SEF<br/>Hilfe');
define('COM_SH404SEF_HELPDESC',             'Hilfe für sh404SEF benötigt?');
define('COM_SH404SEF_HELPVIA',              '<strong>In den folgenden Foren ist Hilfe zu finden:</strong>');
define('COM_SH404SEF_HIDE_CAT',             'Kategorie verbergen');
define('COM_SH404SEF_HITS',               'Zugriffe');
define('COM_SH404SEF_IMPORT',             'Importieren');
define('COM_SH404SEF_IMPORT_EXPORT',          'URL Import / Export');
define('COM_SH404SEF_IMPORT_OK',            'Individuelle URLs wurden erfolgreich importiert');
define('COM_SH404SEF_INFO',               'sh404SEF<br/>Dokumentation');
define('COM_SH404SEF_INFODESC',             's404SEF Projekt Zusammenfassung und Dokumentation');
define('COM_SH404SEF_INSTALLED_VERS',         'Versionnummer');
define('COM_SH404SEF_INVALID_SQL',            'FALSCHE DATEN IN SQL-Datei:');
define('COM_SH404SEF_INVALID_URL',            'FALSCHE URL: dieser Link benötigt eine valide Itemid, aber es wurde keine gefunden.<br/>Lösung: Einen Menüeintrag für diesen Artikel erstellen, er braucht jedoch nicht veröffentlicht werden, es genügt dass der Eintrag existiert.');
define('COM_SH404SEF_LICENSE',              'Lizenz');
define('COM_SH404SEF_LOWER',              'Nur Kleinbuchstaben');
define('COM_SH404SEF_MAMBERS',              'Mambers Forum');
define('COM_SH404SEF_NEWURL',             'Neue Url');
define('COM_SH404SEF_NO_UNLINK',            'Kann die Datei aus dem Medienverzeichnis nicht entfernen');
define('COM_SH404SEF_NOACCESS',             'Kein Zugriff möglich');
define('COM_SH404SEF_NOCACHE',              'Kein Cache möglich');
define('COM_SH404SEF_NOLEADSLASH',            'Hier sollte kein vorangehender "SLASH" an der neuen SEF URL sein');
define('COM_SH404SEF_NOREAD',             'SCHWERER FEHLER: Datei kann nicht gelesen werden' );
define('COM_SH404SEF_NORECORDS',            'Keine Einträge gefunden.');
define('COM_SH404SEF_OFFICIAL',             'Offizielles Projektforum');
define('COM_SH404SEF_OK',               ' OK ');
define('COM_SH404SEF_OLDURL',             'Alte SEF URL');
define('COM_SH404SEF_PAGEREP_CHAR',           'Trennzeichen');
define('COM_SH404SEF_PAGETEXT',             'Seitentext');
define('COM_SH404SEF_PROCEED',              ' Vorgang Starten ');
define('COM_SH404SEF_PURGE404',             '404 Logs<br />löschen');
define('COM_SH404SEF_PURGE404DESC',           'Löscht vorhandene 404 Logdateien');
define('COM_SH404SEF_PURGECUSTOM',            'Eigene Umleitungen<br/>löschen');
define('COM_SH404SEF_PURGECUSTOMDESC',          'Löscht vorhandene, eigene Umleitungen');
define('COM_SH404SEF_PURGEURL',             'SEF Urls<br/>löschen');
define('COM_SH404SEF_PURGEURLDESC',           'Löscht alle vorhanden SEF Urls');
define('COM_SH404SEF_REALURL',              'Wirkliche Url');
define('COM_SH404SEF_RECORD',             ' Eintrag');
define('COM_SH404SEF_RECORDS',              ' Einträge');
define('COM_SH404SEF_REPLACE_CHAR',           'Zu ersetzendes Zeichen');
define('COM_SH404SEF_SAVEAS',             'als Eigene Umleitung speichern');
define('COM_SH404SEF_SEFURL',             'SEF Url');
define('COM_SH404SEF_SELECT_DELETE',          'Es wurde nicht zum Löschen ausgewählt');
define('COM_SH404SEF_SELECT_FILE',            'Es muss vorher eine Datei ausgewählt werden');
define('COM_SH404SEF_ACTIVATE_IJOOMLA_MAG',     'iJoomla Magazin im Inhalt aktivieren');
define('COM_SH404SEF_ADV_INSERT_ISO',       'ISO Code wählen');
define('COM_SH404SEF_ADV_MANAGE_URL',       'URL Verarbeitung');
define('COM_SH404SEF_ADV_TRANSLATE_URL',      'Übersetze URL');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID',     'Itemid an SEF URL anhängen');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX',  'Menü ID');
define('COM_SH404SEF_ALWAYS_INSERT_MENU_TITLE',   'Menü Überschrift immer einfügen');
define('COM_SH404SEF_CACHE_TITLE',          'Cache Verwaltung');
define('COM_SH404SEF_CAT_TABLE_SUFFIX',       'Tabellenvorzeichen');
define('COM_SH404SEF_CB_INSERT_NAME',       'Community Builder Namen einfügen');
define('COM_SH404SEF_CB_INSERT_USER_ID',      'Benutzer ID voranstellen');
define('COM_SH404SEF_CB_INSERT_USER_NAME',      'Benutzernamen einfügen');
define('COM_SH404SEF_CB_NAME',            'Standardname der CB Komponente');
define('COM_SH404SEF_CB_TITLE',           'Community Builder Konfiguration');
define('COM_SH404SEF_CB_USE_USER_PSEUDO',     'Pseudonym angeben');
define('COM_SH404SEF_CONF_TAB_ADVANCED',        'Erweitert');
define('COM_SH404SEF_CONF_TAB_BY_COMPONENT',      'Komponenten');
define('COM_SH404SEF_CONF_TAB_MAIN',          'Allgemein');
define('COM_SH404SEF_CONF_TAB_PLUGINS',       'Plugins');
define('COM_SH404SEF_DEFAULT_MENU_ITEM_NAME',   'Standard Menüüberschrift');
define('COM_SH404SEF_DO_NOT_INSERT_LANGUAGE_CODE',  'Keinen Code einfügen');
define('COM_SH404SEF_DO_NOT_OVERRIDE_SEF_EXT',    'sef_ext nicht überschreiben');
define('COM_SH404SEF_DO_NOT_TRANSLATE_URL',     'Nicht übersetzen');
define('COM_SH404SEF_ENCODE_URL',         'URL chiffrieren');
define('COM_SH404SEF_FB_INSERT_CATEGORY_ID',      'Kategorie ID angeben');
define('COM_SH404SEF_FB_INSERT_CATEGORY_NAME',    'Kategorienname einfügen');
define('COM_SH404SEF_FB_INSERT_MESSAGE_ID',     'Nachrichten ID einfügen');
define('COM_SH404SEF_FB_INSERT_MESSAGE_SUBJECT',    'Nachrichtenbetreff einfügen');
define('COM_SH404SEF_FB_INSERT_NAME',       'Kunenaname einfügen');
define('COM_SH404SEF_FB_NAME',            'Standard Kunenaname');
define('COM_SH404SEF_FB_TITLE',           'Kunena Konfiguration ');
define('COM_SH404SEF_FILTER',           'Filter');
define('COM_SH404SEF_FORCE_NON_SEF_HTTPS',      'Kein SEF wenn HTTPS');
define('COM_SH404SEF_GUESS_HOMEPAGE_ITEMID',      'Homepage ID verwenden');
define('COM_SH404SEF_IJOOMLA_MAG_NAME',       'Standard iJoomla Magazinname');
define('COM_SH404SEF_IJOOMLA_MAG_TITLE',        'iJoomla Magazin Konfiguration');
define('COM_SH404SEF_INSERT_GLOBAL_ITEMID_IF_NONE', 'Einfügen der Menü-Itemid');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Artikel ID in URL einfügen');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ISSUE_ID',  'Ausgabe ID in URL einfügen');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Magazin ID in URL einfügen');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_NAME',    'Magazin Name in URL einfügen');
define('COM_SH404SEF_INSERT_LANGUAGE_CODE',     'Sprachencode in URL einfügen');
define('COM_SH404SEF_INSERT_NUMERICAL_ID',      'Numerische ID in URL einfügen');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_ALL_CAT',  'Alle Kategorien');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST', 'Gilt für welche Kagetorie');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE',    'Einmalige ID');
define('COM_SH404SEF_INSERT_PRODUCT_ID',        'Produkt ID verwenden');
define('COM_SH404SEF_INSERT_TITLE_IF_NO_ITEMID',    'Menütitel bei fehlender Itemid');
define('COM_SH404SEF_ITEMID_TITLE',         'Itemid Verwaltung');
define('COM_SH404SEF_LETTERMAN_DEFAULT_ITEMID',   'Standard Itemid für Letterman');
define('COM_SH404SEF_LETTERMAN_TITLE',        'Letterman Konfiguration ');
define('COM_SH404SEF_LIVE_SECURE_SITE',       'SSL gesicherte URL');
define('COM_SH404SEF_LOG_404_ERRORS',       '404 Fehlermeldungen aufzeichnen');
define('COM_SH404SEF_MAX_URL_IN_CACHE',       'Cache Größe');
define('COM_SH404SEF_OVERRIDE_SEF_EXT',       'sef_ext Datei überschreiben');
define('COM_SH404SEF_REDIR_404',            '404');
define('COM_SH404SEF_REDIR_CUSTOM',         'Individuell');
define('COM_SH404SEF_REDIR_SEF',            'SEF');
define('COM_SH404SEF_REDIR_TOTAL',          'Total');
define('COM_SH404SEF_REDIRECT_JOOMLA_SEF_TO_SEF', '301 Redirect von CMS SEF nach sh404SEF');
define('COM_SH404SEF_REDIRECT_NON_SEF_TO_SEF',    '301 Redirect von Nicht-SEF zu SEF');
define('COM_SH404SEF_REPLACEMENTS',         'Liste der zu ersetzenden Zeichen');
define('COM_SH404SEF_SHOP_NAME',            'Standard Shopname');
define('COM_SH404SEF_TRANSLATE_URL',          'URL Übersetzen');
define('COM_SH404SEF_TRANSLATION_TITLE',        'Übersetzungsverwaltung');
define('COM_SH404SEF_USE_URL_CACHE',          'URL Cache aktivieren');
define('COM_SH404SEF_VM_ADDITIONAL_TEXT',     'Zusätzlicher Text');
define('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES',    'Keine');
define('COM_SH404SEF_VM_INSERT_CATEGORIES',     'Kategorien einfügen');
define('COM_SH404SEF_VM_INSERT_CATEGORY_ID',      'Kategorie ID in URL einfügen');
define('COM_SH404SEF_VM_INSERT_FLYPAGE',        'Flypagenamen einfügen');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_ID',    'Hersteller ID einfügen');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_NAME',  'Hersteller Namen einfügen');
define('COM_SH404SEF_VM_INSERT_SHOP_NAME',      'Shop Namen in URL einfügen');
define('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES',   'Unterkategorien');
define('COM_SH404SEF_VM_SHOW_LAST_CATEGORY',      'Nur letzte Kategorie anzeigen');
define('COM_SH404SEF_VM_TITLE',           'Virtuemart Konfiguration');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU',     'Art. Nr. als Namen verwenden');
define('COM_SH404SEF_SHOW_CAT',             'Kategorie anzeigen');
define('COM_SH404SEF_SHOW_SECT',            'Bereich anzeigen');
define('COM_SH404SEF_SHOW0',              'Zeige SEF Urls');
define('COM_SH404SEF_SHOW1',              'Zeige 404 Logs');
define('COM_SH404SEF_SHOW2',              'Zeige Eigene Umleitungen');
define('COM_SH404SEF_SKIP',               'Überspringen');
define('COM_SH404SEF_SORTBY',             'Sortieren nach:');
define('COM_SH404SEF_STRANGE',              'Etwas seltsames ist passiert. Das sollte nicht vorkommen<br />');
define('COM_SH404SEF_STRIP_CHAR',           'Auszublendende Zeichen');
define('COM_SH404SEF_SUCCESSPURGE',           'Einträge erfolgreich gelöscht');
define('COM_SH404SEF_SUFFIX',             'Dateiendung');
define('COM_SH404SEF_SUPPORT',              'Support<br/>Homepage');
define('COM_SH404SEF_SUPPORT_404SEF',         'sh404 unterstützen');
define('COM_SH404SEF_SUPPORTDESC',            'Zur 404SEF Homepage (neues Fenster) verbinden');
define('COM_SH404SEF_TITLE_ADV',            'Erweiterte Konfiguration');
define('COM_SH404SEF_TITLE_BASIC',            'Standard Konfiguration');
define('COM_SH404SEF_TITLE_CONFIG',           '404 SEF Konfiguration');
define('COM_SH404SEF_TITLE_MANAGER',          'SEF URL Verwaltung');
define('COM_SH404SEF_TITLE_PURGE',            '404 SEF Databank löschen');
define('COM_SH404SEF_TITLE_SUPPORT',          'sh404SEF Hilfe');
define('COM_SH404SEF_TT_404PAGE',           'Statische Inhaltsseite welche beim Fehler: <strong>404 Seite nicht gefunden</strong> angezeigt wird<br />');
define('COM_SH404SEF_TT_ADDFILE',           'Dateiname der an eine leere URL angehängt wird wenn keine Datei existiert.<br />Nützlich wenn Bots die Seiten nach einer bestimmten Datei durchsuchen und beim Nichtfinden eine 404 Fehlermeldung zurückgeben würden.');
define('COM_SH404SEF_TT_ADV',             '<strong>Standard Bearbeitung</strong><br />Die Seite wird normal abgearbeitet.<br/>Falls eine erweiterte Extension vorhanden ist, wird diese benutzt.<br /><strong>Keine Zwischenspeicherung</strong><br/>Es erfolgt keine Zwischenspeicherung in der Datenbank. Das Standard CMS SEF System wird benutzt.<br/><strong>Überspringen</strong><br/>Keine SEF Urls für diese Komponente<br/>');
define('COM_SH404SEF_TT_ADV4',              'Erweiterte Optionen für ');
define('COM_SH404SEF_TT_ENABLED',           'Ist diese Optoin auf Nein gesetzt, wird die Standard CMS SEF Funktion benutzt.');
define('COM_SH404SEF_TT_FRIENDTRIM_CHAR',       'Zeichen welche am Anfang oder Ende einer URL entfernt werden sollen, sind hier durch ein | getrennt anzugeben. Warning: if you change this from its default value, make sure to not leave it empty. At least use a space. Due to a small bug in Joomla, this cannot be left empty.');
define('COM_SH404SEF_TT_LOWER',             'Konvertiert alle Zeichen in der URL zu Kleinbuchstaben.');
define('COM_SH404SEF_TT_NEWURL',            'Diese URL muss mit index.php beginnen');
define('COM_SH404SEF_TT_OLDURL',            'Nur Relative Umleitung vom CMS Rootverzeichnis <i>ohne</i> vorangehenden SLASH');
define('COM_SH404SEF_TT_PAGEREP_CHAR',          'Trennzeichen Vorgabe welche die Seitenzahlen vom Rest der URL trennt.');
define('COM_SH404SEF_TT_PAGETEXT',            'Text welcher bei mehrseitigen Dokumenten an die URL angehängt wird.<br />Die Seitennummer wird duch %s dargestellt.');
define('COM_SH404SEF_TT_REPLACE_CHAR',          'Vorgabe um unbekannte Zeichen und Symbole in der URL zu ersetzen.');
define('COM_SH404SEF_TT_ACTIVATE_IJOOMLA_MAG',    'Wenn <strong>Ja</strong> wird der ed Parameter, insofern dieser der com_content Komponente übergeben wird, als iJoomla Magazin Edition ID interpretiert.');
define('COM_SH404SEF_TT_ADV_INSERT_ISO',        'Für jede installierte Komponente und wenn JoomFish aktiviert ist, soll der ISO-Code in die SEF-Url eingefügt werden. Zum Beispiel: www.meineseite.com/<strong>de</strong>/links.html. de steht für Deutsch - dieser Code wird nicht in der Standard-URL angezeigt.');
define('COM_SH404SEF_TT_ADV_MANAGE_URL',        'Für jede installierte Komponente:<br /><b>verwende Standard</b><br/>verarbeite normal, ist eine SEF-Advanced-Extension vorhanden, verwende diese<br/><b>Kein Cache</b><br/>Keine Speicherung in der Datenbank und verwende bisherigen SEF-Url-Aufbau<br/><b>Nein</b><br/>Keine SEFE-URLs für diese Komponente<br/>');
define('COM_SH404SEF_TT_ADV_OVERRIDE_SEF',      'Einige Komponenten haben eigene sef_ext Dateien zur Verwendung durch sh404Sef oder Joomla oder OpenSef. Ist dieser Parameter auf AN (überschreiben der sef_ext), wird diese Erweiterung nicht verwendet, stattdessen das sh404SEF eigene Plugin. Andernfalls wird die Komponenten-SEF-Erweiterung verwendet.');
define('COM_SH404SEF_TT_ADV_TRANSLATE_URL',     'Soll für jede installierte Komponnete die URL übersetzt werden? (Keine Auswirkung wenn nur eine Sprache verwendet wird)');
define('COM_SH404SEF_TT_ALWAYS_INSERT_ITEMID',    'Diese Option aktivieren, wenn die Nicht SEF Itemid (oder die aktuelle ID des Menüpunktes wenn keine Itemid in dem nicht SEF URL gesetzt wurde) dem SEF URL vorangestellt werden soll. Dieses sollte anstelle des -Immer Menütitel einfügen- Paramters verwendet werden falls mehrere gleichnamige Menüpunkte existieren!');
define('COM_SH404SEF_TT_ALWAYS_INSERT_MENU_TITLE',  'Wenn aktiv, wird der Titel des Menüpunktes welcher zu der Itemid in der Nicht SEF URL gehört (oder der aktuelle Menüpunkt Titel wenn keine Itemid gesetzt ist), in die SEF URL eingefügt.');
define('COM_SH404SEF_TT_CB_INSERT_NAME',        'Wenn <strong>Ja</strong> wird jedem SEF Link der Community Builder Komponente dessen Community Builder Menü-Element Titel vorangestellt.');
define('COM_SH404SEF_TT_CB_INSERT_USER_ID',     'Sollten Benutzer mit gleichem Namen existieren, kann hiermit eingestellt werden, dass dem Namen die dazugehörige ID vorangestellt wird.');
define('COM_SH404SEF_TT_CB_INSERT_USER_NAME',   'Diese Option kann bei großer Benutzeranzahl zu hoher Last der Datenbank führen.<br />Sie bewirkt, dass der Name in den SEF URL aufgenommen wird. Ist diese Option deaktiviert, wird das reguläre ID Format benutzt.<br /><strong>Beispiel:</strong><br />..../send-user-email.html?user=245');
define('COM_SH404SEF_TT_CB_NAME',         'Wurde die vorherige Option aktiviert, kann hier der Text angegeben werden, welcher den Standardnamen in der SEF URL überschreibt. Eine spätere Änderung und Übersetzung sind nicht möglich.');
define('COM_SH404SEF_TT_CB_USE_USER_PSEUDO',      'Wenn auf <strong>Ja</strong> gesetzt, wird der Benutzerpseudoname in die SEF-URL inkludiert, ansonsten der wirkliche Benutzername');
define('COM_SH404SEF_TT_DEFAULT_MENU_ITEM_NAME',    'Wurde die vorherige Option auf <strong>Ja</strong> gesetzt, kann  hier den Text der in den SEF URL eingefügt wird, überschreiben.<br />Hinweis: Dieser Text kann nicht geändert werden und wird nicht übersetzt.');
define('COM_SH404SEF_TT_ENCODE_URL',          'Wenn aktiviert, die URL wird verschlüsselt um Kompatibel mit Sprachen welche Sonderzeichen haben, zu sein. Die URL kann z.B. dann so aussehen: mysite.com/%34%56%E8%67%12.....');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_ID',   'Wenn <strong>Ja</strong>, wird die Kategorie-ID zum Namen hinzugefügt (nützlich wenn es 2 Kategorien mit gleichem Namen gibt)');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME', 'Wenn aktiviert, wird der Kategorienamen zu allen SEF-Links hinzugefügt');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID',    'Wenn auf <strong>Ja</strong>, wird jede Nachrichten-ID zum Betreff hinzugefügt (Nützlich wenn es 2 Nachrichten mit selben Betreff gibt)');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_SUBJECT', 'Wenn auf <strong>Ja</strong>, wird jeder Nachrichtenbetreff in eine SEF-URL konvertiert');
define('COM_SH404SEF_TT_FB_INSERT_NAME',        'Wenn aktiviert, wird der Kunenatitle zu allen Kunenaurls vorangestellt');
define('COM_SH404SEF_TT_FB_NAME',         'Wenn aktiviert, wird der Kunenaname allen Kunenaurls vorangestellt');
define('COM_SH404SEF_TT_FORCE_NON_SEF_HTTPS',   'Wenn aktiviert, werden im SSL-Modus (https) alle SEF-URLs wieder normal dargestellt (nützlich auf gesharten SSL-Servern bei Problemen)');
define('COM_SH404SEF_TT_GUESS_HOMEPAGE_ITEMID',   'Wenn aktiviert, werden auf der Startseite ItemIDs der Inhalte durch einen sh404-Vorschlag ersetzt. Nützlich dann, wenn Inhalte auf verschiedenen Seiten angesehen werden können');
define('COM_SH404SEF_TT_IJOOMLA_MAG_NAME',      'Wurde der vorherige Parameter aktiviert, enthät die SEF-URL den hier vergebenen Namen. Es ist nicht möglich diesen Eintrag nachträglich zu ändern, es erfolgt keine Übersetzung.');
define('COM_SH404SEF_TT_INSERT_GLOBAL_ITEMID_IF_NONE',  'Wenn in einer URL keine Itemid vorhanden ist bevor sie in eine SEF-Url umgewandelt wird, erhält diese die aktuelle Menü Itemid.<br />Dies stellt sicher, dass der Link, sollte er geklickt werden, auf der Seite bleibt.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Aktivieren dieser Option führt dazu, dass die Artikel-ID dem Artikel-Titel in der URL vorangestellt wird.<br /><strong>Beispiel:</strong> beispiel.de/Joomla-magazine/<strong>56</strong>-Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ISSUE_ID', 'Wenn <strong>Ja</strong> wird die Interne Ausgabe-ID dem Ausgabenamen in der URL vorangestellt.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Wenn <strong>Ja</strong> wird die Interne Magazin ID dem Magazinnamen in der URL vorangestellt<br /><strong>Beispiel:</strong><br />beispiel.de/<strong>4</strong>-Joomla-magazine/Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_NAME', 'Bei <strong>Ja</strong> wird immer der Name des Magazins, basierend auf dem Menütiteleintrag der SEF-URL vorangestellt.');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE',    'Wenn <strong>Ja</strong>, wird der ISO-Code der Seitensprache in die SEF-URL eingefügt, ausgenommen die Sprache ist die Standardseitensprache');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID',   'Die Option aktivieren um so eine bessere Schnittstelle zu Diensten wie z.B. wie Google News bereitzustellen. In diese Fall wird eine numerische ID an die URL angehängt.<br />Ein Beispiel wäre:<br />2007041100000<br />wobei: <strong>20070411</strong> das Erstellungsdatum und: <strong>00000</strong><br />eine interne, eindeutige ID des Inhaltselements darstellt.<br />Da dieser Wert später nicht mehr geändert werden kann, sollte das Erstellungsdatum erst dann gesetzt werden, wenn der Beitrag bereit für die Veröffentlichung ist.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST', 'Ausgehend von den hier angewählten Kategorien wird die numerische ID in die SEF-URL des jeweiligen Inhaltelements eingefügt.<br />Durch halten der Strg-Taste ist eine Mehrfachauswahl möglich.');
define('COM_SH404SEF_TT_INSERT_PRODUCT_ID',     'Wenn <strong>Ja</strong> wird die CMS interne Produkt ID (Nicht SKU), vor dem Namen des Shops eingefügt.<br /><strong>Beispiel:</strong><br />beispiel.de/3-my-very-nice-product.html.<br />Dies ist nützlich wenn gleichnamige Artikel vertrieben und die Kategorienamen nicht anzeigt werden sollen');
define('COM_SH404SEF_TT_INSERT_TITLE_IF_NO_ITEMID', 'Wenn in einer URL keine Itemid gesetzt wurde bevor sie in eine SEF Url umgewandelt wird, und diese Option aktiviert ist, wird der Titel des Menüeintrags in die SEF-Url eingebunden.<br />Wurde die Option:<br />Einfügen der Menü-Itemid<br />aktiviert, sollte auch diese Funktion auf <strong>Ja</strong> gesetzt werden.<br />Damit wird verhindert, dass Beispielsweise -2, -3,- ... an die URL angehängt werden wenn diese von verschiedenen Seiten angezeigt wird.');
define('COM_SH404SEF_TT_LETTERMAN_DEFAULT_ITEMID',  'Seiten-ItemID in Letterman links (unsubscribe, confirmation messages, ...) hinzufügen' );
define('COM_SH404SEF_TT_LIVE_SECURE_SITE',      'Werden keine SSL gesicherte Seiten benutzt, dann hier die volle Basis-URL der eigenen Webseite eintragen.<br />Wird keiner hier eingetragen, so wird: http<srong>s</strong>://beispielseite.de benutzt.<br />Die Angabe muss ohne abschließende Slashes erfolgen.<br /><strong>Beispiel:</strong><br />https://www.beispielseite.de oder https://beispielseite.de/WasAuchImma');
define('COM_SH404SEF_TT_LOG_404_ERRORS',        'Durch das Aktivieren dieser Option werden 404 Fehler in der Datenbank gespeichert. Dies kann später dabei helfen eventuelle Fehler in den Links zu finden. Die Funktion verbraucht zusätzlichen Speicher. Sollten die Links also fehlerfrei sein, kann diese Option deaktiviert werden.');
define('COM_SH404SEF_TT_MAX_URL_IN_CACHE',      'Wurde der URL-Cache (Zwischenspeicher) aktiviert, kann an dieser Stelle ein Maximalwert festgelegt werden. Überschreitet die Anzahl der URLs diesen Wert wird zwar fortgesetzt, allerdings werden diese nicht zwischengespeichert, was die Ladezeit der Seiten erhöht.<br />Jede gespeicherte URL benötigt ca. 200 bytes - 100 davon für die SEF-URL und 100 für Nicht-SEF-URLs.<br />Beispiel: 5000 URLs verbrauchen ca. 1 Mb Speicher.');
define('COM_SH404SEF_TT_REDIRECT_JOOMLA_SEF_TO_SEF', 'Wenn auf <strong>Ja</strong> gesetzt, werden die CMS-Standard-SEF-URLs anstatt mit einem 301-Redirect mit dem sh404SEF-Redirect ersetzt. Wenn dieser nicht vorhanden ist, wird er automatisch erzeugt. Warning: this feature will work in most cases, but may give bad redirects for some Joomla SEF URL. Leave off if possible.');
define('COM_SH404SEF_TT_REDIRECT_NON_SEF_TO_SEF', 'Wenn aktiv, werden Nicht-SEF-URLs die bereits in der Datenbank gespeichert sind, zur SEF-URL weitergleitet.');
define('COM_SH404SEF_TT_REPLACEMENTS',        'Anhand dieser Ausschluss-Tabelle lassen sich unerlaubte Zeichen oder Nicht-Lateinische Zeichensätze durch hier definierte Zeichenfolgen ersetzten.<br />Das einzuhaltende Format lautet:<br />AlterWERT TRENNZEICHEN NeuerWERT.<br />In der Praxis werden altes und neues Zeichen durch ein | getrennt und jede weitere Ausschluss-Regel durch ein Komma definiert.<br />Es können auf diese Weise viele verschiedene Regeln erstellt werden. Ebenso das Ersetzen von Mehrfach-Zeichen wie im folgenden Beispiel ist möglich: ö|oe');
define('COM_SH404SEF_TT_SHOP_NAME',         'Es kann ein alternativer Shopnamen angeben werden welcher dann den in der Konfiguration hinterlegten Text überschreibt. Dieser Text kann weder nachträglich geändert noch übersetzt werden.');
define('COM_SH404SEF_TT_TRANSLATE_URL',       'Wird eine mehrsprachige Webseite eingesetzt und ist diese Option aktiviert, werden SEF URL Elemente anhand der eingestellten Sprache der Besucher und den Joom!Fish-Vorgaben übersetzt.<br />Ist diese Option deaktiviert oder wird nur eine Sprache verwendet, wird die im CMS eingetragene Standardsprache verwendet');
define('COM_SH404SEF_TT_USE_URL_CACHE',       'Bei Aktivierung dieser Option werden SEF-URLs in einen Zwischenspeicher gelegt der die Ladezeiten der Seite erheblich verkürzt. Dieser Vorgang verbraucht allerdings mehr Speicher!');
define('COM_SH404SEF_TT_VM_ADDITIONAL_TEXT',      'Wenn <strong>Ja</strong> wird der URL der Kategorie zusätzlicher Text angehängt.<br /><strong>Beispiel:</strong><br />.../category-A/View-all-products.html statt ..../category-A/');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORIES',    'Bei <strong>Keine</strong> werden keine Kategorienamen der URL hinzugefügt.<br /><strong>Beispiel:</strong><br />beispiel.de/joomla-cms.html<br />Wird die Option <strong>Nur die Letzte anzeigen</strong> gewählt, enthält die URL den Kategorienamen des jeweiligen Produktes.<br /><strong>Beispiel:</strong><br />beispiel.de/joomla/joomla-cms.html<br /><strong>Unterkategorien</strong> bedeutet, dass der Name der Kategorie des Artikels inkl. aller Unterkategorien dem Link hinzugefügt wird.<br /><strong>Beispiel:</strong><br />beispiel.de/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORY_ID',   'Hier kann entschieden werden, ob zu jeder URL einer Kategorie dessen ID vorangestellt wird.<br /><strong>Beispiel:</strong><br />beispiel.de/1-software/4-cms/1-joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_FLYPAGE',     'Wenn aktiviert, wird jedem Flypagenamen bei Produktdetails der Name vorangestellt. Kann deaktiviert sein wenn nur eine Flypage verwendet wird');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_ID', 'Wenn <strong>Ja</strong> wird dem Herstellernamen die dazugehörige ID vorangestellt.<br /><strong>Beispiel:</strong><br />beispiel.de/6-manufacturer-name/3-my-very-nice-product.html');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_NAME', 'Wenn <strong>Ja</strong> wird der Herstellername, sofern er existiert, der SEF URL hinzugefügt.<br /><strong>Beispiel:</strong><br />beispiel.de/manufacturer-name/product-name.html');
define('COM_SH404SEF_TT_VM_INSERT_SHOP_NAME',   'Wenn <strong>Ja</strong> wird der Shopname basierend auf dem Titel des Menüeintrags der SEF URL vorangestellt.');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU',      'Wenn <strong>Ja</strong> wird die vergebene Artikelnr. anstatt des Namens verwendet.');
define('COM_SH404SEF_TT_SHOW_CAT',            'Bei <strong>Ja</strong> werden die Kategorienamen in die URL aufgenommen');
define('COM_SH404SEF_TT_SHOW_SECT',           'Bei <strong>Ja</strong> werden die Bereichsnamen in die URL aufgenommen');
define('COM_SH404SEF_TT_STRIP_CHAR',          'Zeichen und Symbole die der URL entnommen werden sollen. Durch | getrennt anzugeben.');
define('COM_SH404SEF_TT_SUFFIX',            'Erweiterung für Dateien. Zum Deaktivieren dieses Feld leer lassen. Ein häufiger Eintrag wäre z.B. .html');
define('COM_SH404SEF_TT_USE_ALIAS',           'Soll anstatt des Original- der Titel-Alias verwendet werden');
define('COM_SH404SEF_UNWRITEABLE',            ' <strong style="color:red">Nicht beschreibbar</strong>');
define('COM_SH404SEF_UPLOAD_OK',            'Datei erfolgreich hochgeladen');
define('COM_SH404SEF_URL',                'Url');
define('COM_SH404SEF_URLEXIST',             'Diese URL existiert bereits in der Datenbank!');
define('COM_SH404SEF_USE_ALIAS',            'Benutze Titelalias');
define('COM_SH404SEF_USE_DEFAULT',            'Standard Routine');
define('COM_SH404SEF_USING_DEFAULT',          ' <strong style="color:red">Benutze Standardwerte</strong>');
define('COM_SH404SEF_VIEW404',              '404 Logs<br />ansehen / bearbeiten');
define('COM_SH404SEF_VIEW404DESC',            'Ansehen/Bearbeiten der 404 Logs');
define('COM_SH404SEF_VIEWCUSTOM',           'Eigene Umleitungen<br />(Redirects)<br />ansehen / bearbeiten');
define('COM_SH404SEF_VIEWCUSTOMDESC',         'Ansehen/Bearbeiten eigene Umleitungen (Redirects)');
define('COM_SH404SEF_VIEWMODE',             'Ansichtsmodus:');
define('COM_SH404SEF_VIEWURL',              'SEF-URLs<br />ansehen / bearbeiten');
define('COM_SH404SEF_VIEWURLDESC',            'Ansehen/Bearbeiten der SEF-URLs');
define('COM_SH404SEF_WARNDELETE',           'Achtung!!!<br/>Forfahren löscht: ');
define('COM_SH404SEF_WRITE_ERROR',            'FEHLER: Konfiguration nicht beschreibbar');
define('COM_SH404SEF_WRITE_FAILED',           'FEHLER: Datei kann nicht ins Mediaverzeichnis hochgeladen werden');
define('COM_SH404SEF_WRITEABLE',            ' <strong style="color:green">beschreibbar</strong>');

// V 1.2.4.s
define('COM_SH404SEF_DOCMAN_TITLE',         'Docman Konfiguration');
define('COM_SH404SEF_DOCMAN_INSERT_NAME',     'Docmanname einfügen');
define('COM_SH404SEF_TT_DOCMAN_INSERT_NAME',      'Wenn auf <strong>Ja</strong> wird der Elementtitel der Docmanhauptseite der DocMan-SEEF-URL vorangestellt');
define('COM_SH404SEF_DOCMAN_NAME',          'Vorgabe Docmanname');
define('COM_SH404SEF_TT_DOCMAN_NAME',       'Wenn voriger Parameter auf Ja, hier den Text für die SEF-URL angeben. HINWEIS: dieser Text wird nicht übersetzt');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_ID',     'Dokument-ID einfügen');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID',    'Wenn <strong>Ja</strong>, wir die Dokument-ID dem Dokumentnamen vorangestellt (nützlich wenn der gleiche Namen mehrmals verwendet wird');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME',   'Füge Dokumentname ein');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME',    'Wenn <strong>Ja</strong>, wird allen SEF-URLs der Dokumentname bei Aktionen  vorangestellt');
// myblog
define('COM_SH404SEF_MYBLOG_TITLE',         'MyBlog Konfiguration');
define('COM_SH404SEF_MYBLOG_INSERT_NAME',     'MyBlog Name einfügen');
define('COM_SH404SEF_TT_MYBLOG_INSERT_NAME',      'Wenn <strong>Ja</strong>, wird der Elementtitel der MyBlog-Hauptseite allen MyBlog-SEF-URLs vorangestellt');
define('COM_SH404SEF_MYBLOG_NAME',          'Vorgabe Myblog Name');
define('COM_SH404SEF_TT_MYBLOG_NAME',       'Wenn voriger Parameter auf Ja, hier den Text für die SEF-URLs angeben. Hinweis: dieser Text wird nicht übersetzt');
define('COM_SH404SEF_MYBLOG_INSERT_POST_ID',      'Post ID einfügen');
define('COM_SH404SEF_TT_MYBLOG_INSERT_POST_ID',   'Wenn <strong>Ja</strong>, wird die interne Post-ID dem Titel vorangestellt (sinnvoll bei identischen Titeln)');
define('COM_SH404SEF_MYBLOG_INSERT_TAG_ID',     'Tag ID einfügen');
define('COM_SH404SEF_TT_MYBLOG_INSERT_TAG_ID',    'Wenn <strong>Ja</strong>, wird die intere Tag-ID dem Tag-Namen vorangestellt');
define('COM_SH404SEF_MYBLOG_INSERT_BLOGGER_ID',   'Blogger ID einfügen');
define('COM_SH404SEF_TT_MYBLOG_INSERT_BLOGGER_ID',  'Wenn <strong>Ja</strong>, wir die interne Blogger-ID dem Bloggernamen vorangestellt');
define('COM_SH404SEF_RW_MODE_NORMAL',       'Mit .htaccess (mod_rewrite)');
define('COM_SH404SEF_RW_MODE_INDEXPHP',       'Ohne .htaccess (index.php)');
define('COM_SH404SEF_RW_MODE_INDEXPHP2',        'Ohne .htaccess (index.php?)');
define('COM_SH404SEF_SELECT_REWRITE_MODE',      'Rewrite Modus');
define('COM_SH404SEF_TT_SELECT_REWRITE_MODE',   'Einen Rewritemodus für sh404SEF angeben.<br /><strong>mit .htaccess (mod_rewrite)</strong><br />Standard: es muss eine richtig konfiguroierte .htacces Datei geben<br /><strong>ohne .htaccess (index.php)</strong><br /><strong>EXPERIMENTAL: </strong>Es muss keine .htaccess Datei vorhanden sein. Dieser Modus verwendet die PathInfo Funktion des Apache Servers. URLs haben ein /index.php/ bit zu Beginn. Funktioniert NICHT mit MS IIS Servern!<br /><strong>ohne .htaccess (index.php?)</strong><br /><strong>EXPERIMENTAL :</strong>Es muss keine .htaccess Datei vorhanden sein. Dieser Modues ist identisch wie voriger, ausgenommen dass /index.php?/ anstatt /index.php/ verwendet wird. Funktioniert NICHT mit MS IIS Servern!<br />');
define('COM_SH404SEF_RECORD_DUPLICATES',        'Doppelte URL aufzeichnen');
define('COM_SH404SEF_TT_RECORD_DUPLICATES',     'Wenn <strong>Ja</strong>, sh404SEF speichert alle doppelten Nicht-Sef-URLs. Damit kann später entschieden werden welche verwendet werden soll (siehe SEF-URL Liste)');
define('COM_SH404SEF_META_TITLE',           'Titeltag');
define('COM_SH404SEF_TT_META_TITLE',          'Hier den Text angeben welcher für die aktuelle URL im Tag <br /><strong>META Title</strong> im Seitenheader aufscheinen soll');
define('COM_SH404SEF_META_DESC',            'Beschreibungstag');
define('COM_SH404SEF_TT_META_DESC',           'Hier den Text angeben welcher für die aktuelle URL im <br /><strong>META Description</strong> Tag im Seitenheader aufscheinen soll');
define('COM_SH404SEF_META_KEYWORDS',          'Schlüsselwörter Tag');
define('COM_SH404SEF_TT_META_KEYWORDS',         'Hier den Text angeben welcher für die aktuelle URL im <br /><strong>META keywords</strong> Tag im Seitenheader aufscheinen soll. Jedes Wort oder jede Wortgruppe mit Komma trennen');
define('COM_SH404SEF_META_ROBOTS',            'Robots Tag');
define('COM_SH404SEF_TT_META_ROBOTS',         'Hier den Text angeben welcher für die aktuelle URL im <br /><strong>META Robots</strong> Tag im Seitenheader aufscheinen soll. Dieser Tag sagt den Suchmaschinen was sie zu tun haben.<hr />Übliche Parameter:<br /><strong>INDEX,FOLLOW</strong>: indiziere aktuelle Seite und folge den Links<br /><strong>INDEX,NO FOLLOW</strong>: indiziere aktuelle Seite, aber folge keinen Links<br /><strong>NO INDEX, NO FOLLOW</strong>: keine Indexierung und Folgen der Links<br />');
define('COM_SH404SEF_META_LANG',            'Sprachen Tag');
define('COM_SH404SEF_TT_META_LANG',           'Hier den Sprachencode angeben welcher im <br /><strong>META http-equiv= Content-Language</strong> Tag eingetragen werden soll');
define('COM_SH404SEF_CONF_TAB_META',          'Meta/SEO');
define('COM_SH404SEF_CONF_META_DOC',          'sh404SEF beinhaltet Plugins um für einige Komponenten die META Tags <strong>automatisch</strong> zu erstellen. Tragen Sie META Tags daher nur dort ein, wo die generierten META Tags Ihren Bedürfnissen nicht entsprechen!<br>');
define('COM_SH404SEF_REMOVE_JOOMLA_GENERATOR',    'Entferne CMS eigenen Generator.Tag');
define('COM_SH404SEF_TT_REMOVE_JOOMLA_GENERATOR', 'Wenn <strong>Ja</strong> wird der &quot;Generator = CMS-Name&quot; Meta Tag entfernt wenn');
define('COM_SH404SEF_PUT_H1_TAG',         'h1 Tags einfügen');
define('COM_SH404SEF_TT_PUT_H1_TAG',          'Wenn <strong>Ja</strong> werden reguläre Inhaltstitel mit h1-Tags ersetzt. Diese Titel werden normalerweise vom CSS mit einer CSS-Klasse generiert welche mit  <strong>contentheading</strong> beginnt');
define('COM_SH404SEF_META_MANAGEMENT_ACTIVATED',    'Aktiviere Meta Verwaltung');
define('COM_SH404SEF_TT_META_MANAGEMENT_ACTIVATED', 'Wenn <strong>Ja</strong>, Titel, Beschreibung, Schlüsselwörter, Robots und Sprachen META Tags werden von sh404SEF verwaltet. Ansonsten bleiben die Originalwerte - erzeigt vom CMS und den Komponenten - unberührt');
define('COM_SH404SEF_TITLE_META_MANAGEMENT',      'Metatag Verwaltung');
define('COM_SH404SEF_META_EDIT',            'Modifiziere Tags');
define('COM_SH404SEF_META_ADD',             'Tags hinzufügen');
define('COM_SH404SEF_META_TAGS',            'META Tags');
define('COM_SH404SEF_META_TAGS_DESC',         'Meta Tags erstellen/bearbeiten');
define('COM_SH404SEF_PURGE_META_DESC',          'Meta Tags löschen');
define('COM_SH404SEF_PURGE_META',           'Lösche META');
define('COM_SH404SEF_IMPORT_EXPORT_META',       'Import/Export META');
define('COM_SH404SEF_NEW_META',             'Neuer META');
define('COM_SH404SEF_NEWURL_META',            'Nicht SEF-URL');
define('COM_SH404SEF_TT_NEWURL_META',         'Hier die SEF-URL angeben für welche META-Tags gesetzt werden soll. HINWEIS: muss mit <strong>index.php</strong> beginnen!');
define('COM_SH404SEF_BAD_META',             'Bitte Daten überprüfen: einige Angaben sind nicht gültig');
define('COM_SH404SEF_META_TITLE_PURGE',         'Lösche Meta Tags');
define('COM_SH404SEF_META_SUCCESS_PURGE',       'Meta Tags gelöscht');
define('COM_SH404SEF_IMPORT_META',            'Import Meta Tags');
define('COM_SH404SEF_EXPORT_META',            'Export Meta Tags');
define('COM_SH404SEF_IMPORT_META_OK',         'Meta Tags erfolgreich importiert');
define('COM_SH404SEF_SELECT_ONE_URL',         'Bitte nur eine (!) URL wählen');
define('COM_SH404SEF_MANAGE_DUPLICATES',        'URL-Verwaltung für: ');
define('COM_SH404SEF_MANAGE_DUPLICATES_RANK',     'Rank');
define('COM_SH404SEF_MANAGE_DUPLICATES_BUTTON',     'Doppelte URL');
define('COM_SH404SEF_MANAGE_MAKE_MAIN_URL',       'Haupt URL');
define('COM_SH404SEF_BAD_DUPLICATES_DATA',        'FEHLER: ungültige URL-Daten');
define('COM_SH404SEF_BAD_DUPLICATES_NOTHING_TO_DO',   'Diese URL ist bereits die Haupt-URL');
define('COM_SH404SEF_MAKE_MAIN_URL_OK',         'Vorgang erfolgreich abgeschlossen');
define('COM_SH404SEF_MAKE_MAIN_URL_ERROR',        'FEHLER: Vorgang fehlgeschlagen!');
define('COM_SH404SEF_CONTENT_TITLE',          'Inhaltskonfiguration');
define('COM_SH404SEF_INSERT_CONTENT_TABLE_NAME',    'Inhaltstabellenname einfügen');
define('COM_SH404SEF_TT_INSERT_CONTENT_TABLE_NAME', 'Wenn <strong>Ja</strong> wird der Elementitel der Kategorie oder des Bereichs der SEF-URL vorangestellt');
define('COM_SH404SEF_CONTENT_TABLE_NAME',     'Vorgabe verlinkter Tabellenname');
define('COM_SH404SEF_TT_CONTENT_TABLE_NAME',      'Wenn ja, kann der automatisch eingefügte Text in der SEF-URL überschrieben werden. HINWEIS: dieser Text wird nicht übersetzt!');
define('COM_SH404SEF_REDIRECT_WWW',         '301 redirect www/non-www');
define('COM_SH404SEF_TT_REDIRECT_WWW',        'Wenn <strong>Ja</strong> wird sh404SEF einen 301-Redirect auf Seiten <strong>ohne</strong> www durchführen. Damit werden doppelte Seiten vermieden welche einerseits durch fehlerhafte Apacheserverkonfiguration, andererseits durch manche CMS-Editoren verursacht werden und bei manchen Suchmaschinen zu eine Rückstufung des Rankings (z.B. Google) führen kann');
define('COM_SH404SEF_INSERT_PRODUCT_NAME',      'Produktname einfügen');
define('COM_SH404SEF_TT_INSERT_PRODUCT_NAME',   'Fügt den Produktnamen in die URL ein');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU_124S',    'Produktcode einfügen');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU_124S', 'Fügt den Produktcode (SKU in Virtuemart genannt) in die URL ein');

// V 1.2.4.t
define('COM_SH404SEF_DOCMAN_INSERT_CAT_ID',     'Kategorie ID einfügen');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID',    'Wenn <strong>Ja</strong> wir die KategorieID der URl vorangestellt (zur Unterscheidung wenn z.B. 2 Kategorien den selben Namen haben)');
define('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES',   'Kategorienamen einfügen');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES',  'Wenn <strong>None/Kein</strong> wird der Kategoriename nicht eingefügt:<br />z.B. mysite.com/joomla-cms.html<br />Wenn <strong>Nur Letzter</strong> der Kategoriename wir din die URL eingefügt: <br /> mysite.com/joomla/joomla-cms.html<br />Wenn <strong>Alle versteckten Kategorien</strong> werden die Namen aller Kategorien hinzugefügt: <br /> mysite.com/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_FORCED_HOMEPAGE',        'Homepage URL');
define('COM_SH404SEF_TT_FORCED_HOMEPAGE',     'Hier kann die Startseite forciert werden. Nützlich wenn eine Landingpage (normalerweise eine index.html Seite) definiert wurde. In der Form angeben: www.meineseite.com/index.php (kein abschliessender Slash / !). Damit wird dann die CMS-Startseite angezeigt wenn auch den Homelink geklickt wird');
define('COM_SH404SEF_INSERT_CONTENT_BLOG_NAME',   'Blog Anzeigename einfügen');
define('COM_SH404SEF_TT_INSERT_CONTENT_BLOG_NAME',  'Wenn <strong>Ja</strong> wird der Titel des Blogs einer Kategorie oder eines Bereichs der URL vorangestellt');
define('COM_SH404SEF_CONTENT_BLOG_NAME',        'Standard Blog Anzeigename');
define('COM_SH404SEF_TT_CONTENT_BLOG_NAME',     'Ist voriger Parameter aktiviert, kann hier der Text für die SEF-URL angegeben werden. Hinweis: der Text wird nicht übersetzt');
// mosets tree
define('COM_SH404SEF_MTREE_TITLE',          'Mosets Tree Konfiguration');
define('COM_SH404SEF_MTREE_INSERT_NAME',        'MTree Name einfügen');
define('COM_SH404SEF_TT_MTREE_INSERT_NAME',     'Wenn <strong>Ja</strong>  wird der Menütitel der Mosets Komponente vorangestellt');
define('COM_SH404SEF_MTREE_NAME',         'Standard MTree Name');
define('COM_SH404SEF_MTREE_INSERT_LISTING_ID',    'Listen ID einfügen');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_ID', 'Wenn <strong>Ja</strong> wird der SEF-URL die Listen-ID vorangestellt (Nützlich wenn es 2 gleiche Listennamen gibt');
define('COM_SH404SEF_MTREE_PREPEND_LISTING_ID',   'ID zum Namen einfügen');
define('COM_SH404SEF_TT_MTREE_PREPEND_LISTING_ID',  'Wenn <strong>Ja</strong> und voriger Parameter ebenfalls auf Ja, wird die ID <strong>vorangestellt</strong>, ansonsten <strong>angehängt</strong>');
define('COM_SH404SEF_MTREE_INSERT_LISTING_NAME',    'Listename einfügen');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_NAME', 'Wenn <strong>Ja</strong> wird der Listenname der URLs welche eine Aktion auslösen, hinzugefügt');
// iJoomla portal
define('COM_SH404SEF_IJOOMLA_NEWSP_TITLE',      'News Portal Konfiguration');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_NAME',    'News Portal Name einfügen');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_NAME', 'wenn <strong>Ja</strong> wird der Menüelementtitel zur SEF-URL vorangestellt');
define('COM_SH404SEF_IJOOMLA_NEWSP_NAME',     'Standard News Portal Name');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_CAT_ID',  'Kategorie ID einfügen');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_CAT_ID', 'Wenn <strong>Ja</strong> wird die Kategorie-ID der URl vorangestellt (nützlich wenn es 2 gleiche Namen gibt)');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_SECTION_ID',  'Bereichs ID einfügen');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'Wenn <strong>Ja</strong> wird die Bereichs-ID der URl vorangestellt (falls es 2 gleiche Bereichsnamen gibt)');
// remository
define('COM_SH404SEF_REMO_TITLE',         'Remository Konfiguration');
define('COM_SH404SEF_REMO_INSERT_NAME',       'Remository Name einfügen');
define('COM_SH404SEF_TT_REMO_INSERT_NAME',      'Wenn <strong>Ja</strong> wird der Menütitel der SEF-URL vorangestellt');
define('COM_SH404SEF_REMO_NAME',            'Vorgabe Remository Name');
// CB
define('COM_SH404SEF_CB_SHORT_USER_URL',        'Kurzurl zum Benutzerprofil');
define('COM_SH404SEF_TT_CB_SHORT_USER_URL',     'Wenn <strong>Ja</strong> können Benutzer mit einer Kurzurl ihre Profile aufrufen (ähnlich www.mysite.com/benutzername). Vor Aktivierung dieser Option bitte überpürfen auf allfällige Konflikte mit bereits bestehenden URLs');

define('COM_SH404SEF_NEW_HOME_META',          'Homepage Meta');
define('COM_SH404SEF_CONF_ERASE_HOME_META',       'Soll die vorhandenen Homepage Titel und Metatags gelsöcht werden?');
define('COM_SH404SEF_UPGRADE_TITLE',          'Upgrade Konfiguration');
define('COM_SH404SEF_UPGRADE_KEEP_URL',       'Automatische URLs sichern');
define('COM_SH404SEF_TT_UPGRADE_KEEP_URL',      'Wenn <strong>Ja</strong> werden von sh404SEF automatisch erstellte SEF-URLs gespeichert und beim Löschen der Komponente nicht gelöscht. Somit brauchen bei einer Neuisnatllierung diese URLs nicht emhr neu erstellt werden');
define('COM_SH404SEF_UPGRADE_KEEP_CUSTOM',      'Individuelle URLs sichern');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CUSTOM',   'WEnn <strong>Ja</strong> werden selber erstellte URLs nicht gelöscht und können bei einer Komponentenneuinstallierung weiterverwendet werden');
define('COM_SH404SEF_UPGRADE_KEEP_META',        'Titel und Meta sichern');
define('COM_SH404SEF_TT_UPGRADE_KEEP_META',     'Wenn <strong>Ja</strong> werden eigene Titel- und Meta.TAGS gespeichert und können bei einer Komponentenneuinstallierung weiter verwendet werden');
define('COM_SH404SEF_UPGRADE_KEEP_MODULES',     'Modulparameter sichern');
define('COM_SH404SEF_TT_UPGRADE_KEEP_MODULES',    'Wenn <strong>Ja</strong> werden aktuelle Modulparameter gesichert und können bei einer Komponentenneuinstallierung weiterverwendet werden');
define('COM_SH404SEF_IMPORT_OPEN_SEF',          'Import aus OpenSEF');
define('COM_SH404SEF_IMPORT_ALL',           'Importiere Alles');
define('COM_SH404SEF_EXPORT_ALL',           'Exportiere Alles');
define('COM_SH404SEF_IMPORT_EXPORT_CUSTOM',       'Import/Export eigene Umleitungen');
define('COM_SH404SEF_DUPLICATE_NOT_ALLOWED',      'Diese URL existiert bereits - Duplikate wind nicht erlaubt');
define('COM_SH404SEF_INSERT_CONTENT_MULTIPAGES_TITLE',  'Mehrseitenartikel Smart Titel aktivieren');
define('COM_SH404SEF_TT_INSERT_CONTENT_MULTIPAGES_TITLE', 'Wenn Ja verwendet sh404SEF bei Artikel über mehrere Seiten (solche mit einer Inhaltstabelle) den Seitentitel im mospagebrak Modul: {mospagebreak title=Next_Page_Title &amp; heading=Previous_Page_Title}, anstatt der Seitennummer<br />Als Beispiel:  www.mysite.com/user-documentation/<strong>Page-2</strong>.html wird ersetzt durch  www.mysite.com/user-documentation/<strong>Getting-started-with-sh404SEF</strong>.html.');

// v x
define('COM_SH404SEF_UPGRADE_KEEP_CONFIG',      'Konfiguration sichern');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CONFIG',   'Wenn <strong>Ja</strong> wird die aktuelle Konfiguration gesichert. So kann bei einer Neuinstallierung sofort darauf zurück gegriffen werden');
define('COM_SH404SEF_CONF_TAB_SECURITY',        'Sicherheit');
define('COM_SH404SEF_SECURITY_TITLE',       'Sicherheitskonfiguration');
define('COM_SH404SEF_HONEYPOT_TITLE',       'Projekt "Honey Pot" Konfiguration');
define('COM_SH404SEF_CONF_HONEYPOT_DOC',        'Project "Honey Pot" ist eine Initiative um Webseiten vor Spamrobots zu schützen. Es stellt eine Datenbank zur Verfügung um die Besucher-IP auf bekannte Spamrobots zu überprüfen. Zugriff auf diese Datenbank erfordert einen kostenlosen Zugriffscode welcher unter der <a href="http://www.projecthoneypot.org/httpbl_configure.php" target="_blank">Projektseite</a> beantragt werden kann<br />(Es muss vor dem Zugriffscode ein kostenloser Account erstellt werden). Falls möglich ist jede Hilfe dafür willkommen, indem "Fallen" auf den Webseiten erstellt werden - damit werden Spamrobots in Zukunft leichter identifiziert');
define('COM_SH404SEF_ACTIVATE_SECURITY',        'Aktiviere Sicherheitsfunktionen');
define('COM_SH404SEF_TT_ACTIVATE_SECURITY',     'Wenn <strong>Ja</strong> aktiviert sh404SEF einige Checks an den angefragten URLs dieser Seite um Attacken abzuwehren');
define('COM_SH404SEF_LOG_ATTACKS',          'Attacken mitloggen');
define('COM_SH404SEF_TT_LOG_ATTACKS',       'Wenn aktiviert, werden identifizierte Attacken in einer Textdatei gespeichert, inklusive IP-Adresse und Seitenanforderung.<br />Pro Monat wird so eine Datei erstellt welche im Verzeichnis <root>/administrator/com_sef/logs gespeichert wird. Sie kann per FTP downgeloaded werden (oder z.B. JoomlaExplorer) um sie später anzusehen. Diese Datei kann dann in einer Tabellensoftware (z.B. MS Excel) angesehen werden');             
define('COM_SH404SEF_CHECK_HONEY_POT',        'Verwende Honey Pot');
define('COM_SH404SEF_TT_CHECK_HONEY_POT',     'Wenn aktiviert wird die Besucher-IP in der HoneyPot-Datenbank gecheckt (unter Verwendung dessen HTTP:BL Service). Obwohl Gratis, muss dort ein Zugang erstellt werden!');
define('COM_SH404SEF_HONEYPOT_KEY',         'Honey Pot Zugriffskey');
define('COM_SH404SEF_TT_HONEYPOT_KEY',        'Wenn die Honey Pot Option aktiviert ist, muss hier der Zugriffskey (12 Zeichen) angegeben werden');               
define('COM_SH404SEF_HONEYPOT_ENTRANCE_TEXT',   'Alternativtext');
define('COM_SH404SEF_TT_HONEYPOT_ENTRANCE_TEXT',    'Ist eine Besucher-IP als Spamrobot erkannt, wird der weitere Zugang gespeerrt (Fehlerseite 403).<br />Sollte der Besucher aber kein Spamrobot sein, wird ihm dieser Text hier angezeigt inklusive Link für weiteren Seitenzugriff. Maschinen verstehen diesen Text nicht und fangen mit dem Link nichts an<br />Der Text kann nach Belieben angepasst werden' );              
define('COM_SH404SEF_SMELLYPOT_TEXT',       'Robot Fallentext');
define('COM_SH404SEF_TT_SMELLYPOT_TEXT',        'Wurde ein Spamrobot durch den Honey Pot erkannt und der weitere Seitenzugang gesperrt, wird ein Link auf dieser Seite angezeigt welcher im Honey Pot Projekt zur Nachverfolgung gespeichert wird. Menschen können der Nachricht und dem Link folgen falls dennoch ein Fehler passierte');
define('COM_SH404SEF_ONLY_NUM_VARS',          'Numerische Werte');
define('COM_SH404SEF_TT_ONLY_NUM_VARS',       'Werte in dieser Liste werden gegen Zahlenn ausgetauscht: nur Zahlen von 0 - 9 möglich!<br />Jeweils ein Wert pro Zeile');
define('COM_SH404SEF_ONLY_ALPHA_NUM_VARS',      'Alphanumerische Werte');
define('COM_SH404SEF_TT_ONLY_ALPHA_NUM_VARS',   'Werte in dieser Liste werden gegen Alpanumerische getauscht: Zeichen von 0 - 9 und Kleinbuchstaben von a - z. Jeweils ein Wert pro Zeile');
define('COM_SH404SEF_NO_PROTOCOL_VARS',       'Prüfe Hyperlinks in Werten');
define('COM_SH404SEF_TT_NO_PROTOCOL_VARS',      'Werte in dieser Liste werden auf enthaltene Links geprüft: http://, https://, ftp:// ');
define('COM_SH404SEF_IP_WHITE_LIST',          'IP White List');
define('COM_SH404SEF_TT_IP_WHITE_LIST',       'Jede Anfrage einer IP-ADresse aus dieser Liste wird <strong>Akzeptiert</strong> nachdem sie alle vorherigen Checks (siehe oben) passiert hat.<br />Jeweils eine IP-Adresse pro Zeile<br />Wildcards können verwendet werden, z.B.: : 192.168.0.* es werden alle Adressen des Bereichs 192.168.0.1 bis 192.168.0.255 akzepiert.');
define('COM_SH404SEF_IP_BLACK_LIST',          'IP Black List');
define('COM_SH404SEF_TT_IP_BLACK_LIST',       'Jede Anfrage einer IP-ADresse aus dieser Liste wird <strong>Blockiert</strong> nachdem sie eventuell alle vorherigen Checks (siehe oben) passiert hat.<br />Jeweils eine IP-Adresse pro Zeile<br />Wildcards können verwendet werden, z.B.: : 192.168.0.* es werden alle Adressen des Bereichs 192.168.0.1 bis 192.168.0.255 blockiert.');
define('COM_SH404SEF_UAGENT_WHITE_LIST',        'UserAgent White List');
define('COM_SH404SEF_TT_UAGENT_WHITE_LIST',     'Jede Anfrage mit einem UserAgent aus dieser Liste wird <strong>akzeptiert</strong>, nachdem sie alle vorigen Tests bestanden hat.<br />Jeweils 1 UserAgent pro Zeile');
define('COM_SH404SEF_UAGENT_BLACK_LIST',        'UserAgent Black List');
define('COM_SH404SEF_TT_UAGENT_BLACK_LIST',     'Jede Anfrage mit einem UserAgent aus dieser Liste wird <strong>blockiert</strong>, nachdem sie alle vorigen Tests bestanden hat.<br />Jeweils 1 UserAgent pro Zeile');
define('COM_SH404SEF_MONTHS_TO_KEEP_LOGS',      'Monate zur Logspeicherung');
define('COM_SH404SEF_TT_MONTHS_TO_KEEP_LOGS',   'Wenn die Logspeicherung von Attacken aktiviert ist, kann hier die Anzahl der Monate dieser Speicherung angegeben werden. Z.B. wird hier 1 angegeben, bedeutet dies dass das aktuelle PLUS dem VORmonat zur Verfügung steht. Vorige Monate werden gelöscht');

// anti flood
define( 'COM_SH404SEF_ANTIFLOOD_TITLE',       'Anti-Flood' );
define('COM_SH404SEF_ACTIVATE_ANTIFLOOD',     'Anti-Flood aktivieren');
define('COM_SH404SEF_TT_ACTIVATE_ANTIFLOOD',      'Wenn aktiviert wird sh404SEF alle IP-Adressen auf zu häufige Seitenfragen prüfen. Tritt der Fall zu häufiger Seitenaufrufe ein, kann es sein, dass diese Webseite damit überladen wird und nicht aufzurufen ist!');
define('COM_SH404SEF_ANTIFLOOD_ONLY_ON_POST',   'Nur bei POST-Daten (Forms)');
define('COM_SH404SEF_TT_ANTIFLOOD_ONLY_ON_POST',    'Wenn aktiviert, wird nur überprüft wenn die Daten aus einem Formular kommen. Das passiert normalerweise durch Spamrobots');
define('COM_SH404SEF_ANTIFLOOD_PERIOD',       'Anti-Flood Kontrolle');
define('COM_SH404SEF_TT_ANTIFLOOD_PERIOD',      'Zeit (in Sekunden) in welcher Anfragen derselben IP.Adresse überprüft werden');
define('COM_SH404SEF_ANTIFLOOD_COUNT',        'Max. Anzahl Anfragen');
define('COM_SH404SEF_TT_ANTIFLOOD_COUNT',     'Maximale Anzahl von Seitenabfragen/-aufrufen derselben IP.Adresse nachdem der Aufruf geblockt wird.<br />Z.B. eine Anfragenanzahl von 4 innerhalb von 10 Sekunden ruft eine 403er-Seite (Verboten) auf. Weitere Anfragen derselben IP.Adresse werden geblockt, andere nicht');
// tab language
define('COM_SH404SEF_CONF_TAB_LANGUAGES',     'Sprachen');
define('COM_SH404SEF_DEFAULT',            'Vorgabe');
define('COM_SH404SEF_YES',              'Ja');
define('COM_SH404SEF_NO',             'Nein');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_PER_LANG', 'Wenn aktiviert, wird er Sprachencode für <strong>diese Sprache</strong> in die URL einegfügt.<br />Wenn <strong>Nein</strong> wird der Sprachencode <strong>nie</strong> eingefügt.<br />Wenn auf <strong>Vorgabe</strong> wird der Sprachencode für alle anderen als die Standardseitensprache eingefügt');
define('COM_SH404SEF_TT_TRANSLATE_URL_PER_LANG',    'Wenn Ja und die Webseite ist mehrsprachig, wird die URL <strong>in diese Sprache lt. JoomFish</strong> übersetzt.<br />Wenn Nein, URLs werden nei übersetzt.<br />Bei Vorgabe wird ebenfalls übersetzt, wird nur 1 Sprache verwendet, hat diese Einstellung keine Effekt');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_GEN',  'Wenn Ja wird der Sprachencode von sh404SEf in die URL eingefügt (es kann auch eine individuelle Einstellung vorgenommen werden, siehe weiter unten)');
define('COM_SH404SEF_TT_TRANSLATE_URL_GEN',     'Wenn Ja und die Webseite ist mehrsprachig, wird die URL in die Sprache des Besuchers übersetzt (lt. JoomFish).<br />Ansonsten beleibt die URL wie sie ist (es kann auch eine individuelle Einstellung vorgenommen werden, siehe weiter unten)');
define('COM_SH404SEF_ADV_COMP_DEFAULT_STRING',    'Vorgabe Name');
define('COM_SH404SEF_TT_ADV_COMP_DEFAULT_STRING', 'Wird hier ein Text angegeben, wird er in <strong>alle</strong> URLs dieser Komponente am Beginn eingefügt.<hr />Normalerweise nicht anzuwenden, ausgenommen wenn ältere SEF-URls anderer SEF-Komponenten verwendet werden (bei Import derselben)');
define('COM_SH404SEF_TT_NAME_BY_COMP',        '. <br />YHier kann ein Name angegeben werden welche anstatt des Menünamens verwendet wird. Dazu bitte den TAB <strong>Komponenten</strong> aufrufen (dieser Text wird nicht übersetzt!)');
// admin display
define('COM_SH404SEF_STANDARD_ADMIN',         'Hier klicken für einfache Anzeige');
define('COM_SH404SEF_ADVANCED_ADMIN',         'Hier klicken für erweiterte Anzeige (alle Parameter)');
define('COM_SH404SEF_MULTIPLE_H1_TO_H2',        'h1 in h2 Ändern');
define('COM_SH404SEF_TT_MULTIPLE_H1_TO_H2',     'Wenn aktiviert und es sind mehrere h1.Tags auf der Seite, werden diese in h2.Tags umgewandelt.<br />Ist nur 1 h1.Tag auf der Seite, sollte dieser WErt nicht geändert werden');
define('COM_SH404SEF_INSERT_NOFOLLOW_PDF_PRINT',    'Nofollow Tag bei Druck- &amp; PDF-Links');
define('COM_SH404SEF_TT_INSERT_NOFOLLOW_PDF_PRINT', 'Wenn aktiviert, wird allen Druck- und PDF-Links das Attribut &quot;rel=nofellow&quot; hinzugefügt<br />Damit wird doppelter Inhalt bei Suchmaschinen vermeiden');
define('COM_SH404SEF_INSERT_READMORE_PAGE_TITLE', 'Titel Weiterlesen ... Links');
define('COM_SH404SEF_TT_INSERT_READMORE_PAGE_TITLE', 'Wenn aktiviert und ein &quot;Weiterlesen ... Link&quot; angezeigt wird, wird ein Titel.Tag hinzugefügt (verbessert die Linkgewichtung in Suchmaschinen<hr />HINWEIS:<br />vorher OHNE Testen!');
define('COM_SH404SEF_VM_USE_ITEMS_PER_PAGE',      'Verwende Zahlen bei Dropdown-Listen');
define('COM_SH404SEF_TT_VM_USE_ITEMS_PER_PAGE',     'Wenn aktiv, werden DropDown-Listen mit Zahlen versehen mit denen Benutzer diese Listen per Zahl aufrufen können.<br />Werden keine DropDown-Listen verwendet oder sind diese URLs bereits von Suchmaschinen indeziert, sollte diese Einstellung nicht angewendet werden');
define('COM_SH404SEF_CHECK_POST_DATA',        'Prüfe Formdaten (POST)');
define('COM_SH404SEF_TT_CHECK_POST_DATA',     'Wenn aktiv werden alle daten aus Forumlaren auf Eisnchleusen von ungültigem code bzw. Variablen überprüft.<br />Sollten in Formularen aus z.B. Foren Codeteile mitgesendet werden, können diese Beiträge blockiert werden, dann sollte dieser Parameter nicht aktiviert werden!');

// admin panel
define('COM_SH404SEF_SEC_STATS_TITLE',        'Sicherheitsstatistik');
define('COM_SH404SEF_SEC_STATS_UPDATE',       'Click here to update blocked attacks counters');
define('COM_SH404SEF_TOTAL_ATTACKS',          'Blocked attacks count');
define('COM_SH404SEF_TOTAL_CONFIG_VARS',        'Variable "mosConfig" in URL');
define('COM_SH404SEF_TOTAL_BASE64',         'Base64 injection');
define('COM_SH404SEF_TOTAL_SCRIPTS',          'Script injection');
define('COM_SH404SEF_TOTAL_STANDARD_VARS',      'Illegale Standard Vars');
define('COM_SH404SEF_TOTAL_IMG_TXT_CMD',        'Remote File Inclusion');
define('COM_SH404SEF_TOTAL_IP_DENIED',        'IP.Adressen geblockt');
define('COM_SH404SEF_TOTAL_USER_AGENT_DENIED',    'User Agents geblockt');
define('COM_SH404SEF_TOTAL_FLOODING',       'Zuviele Anfragen (Flooding)');
define('COM_SH404SEF_TOTAL_PHP',            'Rückweisungen lt. Honey Pot');
define('COM_SH404SEF_TOTAL_PER_HOUR',       ' / Std.');
define('COM_SH404SEF_SEC_DEACTIVATED',        'Sek. Functionen nicht in Verwendung');
define('COM_SH404SEF_TOTAL_PHP_USER_CLICKED',   'PHP durch Benutzer');

// smf forum
define('COM_SH404SEF_COM_SMF_TITLE',          'SMF Bridge');
define('COM_SH404SEF_INSERT_SMF_NAME',        'Forumsname einfügen');
define('COM_SH404SEF_TT_INSERT_SMF_NAME',     'Wenn aktiviert wird der Forumstitel in die URL voran gestellt');
define('COM_SH404SEF_SMF_ITEMS_PER_PAGE',     'Anzahl pro Seite');
define('COM_SH404SEF_TT_SMF_ITEMS_PER_PAGE',      'Anzahl der Forumsartikel auf einer Seite');
define('COM_SH404SEF_INSERT_SMF_BOARD_ID',      'Forums.ID einfügen');
define('COM_SH404SEF_TT_INSERT_SMF_BOARD_ID',     COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME );
define('COM_SH404SEF_INSERT_SMF_TOPIC_ID',      'Topic.ID einfügen');
define('COM_SH404SEF_TT_INSERT_SMF_TOPIC_ID',   COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID);
define('COM_SH404SEF_INSERT_SMF_USER_NAME',     'Benutzername einfügen');
define('COM_SH404SEF_TT_INSERT_SMF_USER_NAME',    'Wenn aktiviert, wird anstatt der Benutzer.ID dessen Name in die URLs eingesetzt.<br />HINWEIS: diese Funktion benötigt viel Speicherplatz da für jede URL eine Einmalige in der Datenbank generiert wird');
define('COM_SH404SEF_INSERT_SMF_USER_ID',     'Benutzer.ID einfügen');
define('COM_SH404SEF_TT_INSERT_SMF_USER_ID',      'Wenn aktiviert, wird zusätzlich zum Benutzernamen dessen ID hinzugefügt');
define('COM_SH404SEF_PREPEND_TO_PAGE_TITLE',      'Vor Seitentitel einfügen');
define('COM_SH404SEF_TT_PREPEND_TO_PAGE_TITLE',   'Text welcher <strong>vor jedem Seitentitel</strong> hinzu gefügt wird');
define('COM_SH404SEF_APPEND_TO_PAGE_TITLE',     'Nach Seitentitel einfügen');
define('COM_SH404SEF_TT_APPEND_TO_PAGE_TITLE',    'Text welcher <strong>nach jedem Seitentitel</strong> hinzu gefügt wird');
define('COM_SH404SEF_DEBUG_TO_LOG_FILE',        'Schreibe Fehlerinfo');
define('COM_SH404SEF_TT_DEBUG_TO_LOG_FILE',     'Wenn Ja wird sh404SEF alle Aktionen mitschreiben um bei Fehlern Hilfe geben zu können<br /><strong style=&quot;color:red&quot;>diese Datei kann sehr groß werden, zudem wird der Seitenaufbau dadurch langsamer!</strong><br />Daher nur anschalten wenn benötigt wird! Aus Sicherheitsgründen wird - wenn aktiviert - diese Funktion automatisch nach 1 Stunde abgeschaltet.<br />Die Datei wird im Verzeichnis  /administrator/components/com_sef/logs/ gespeichert');

define('COM_SH404SEF_ALIAS_LIST',           'Alias Liste');
define('COM_SH404SEF_TT_ALIAS_LIST',          'Hier eine Liste aller Alias für diese URL angeben<br />Pro Zeile eine URL<hr />Beispiel:<br />old-url.html<br/>oder<br/>my-other-old-url.php?var=12&amp;test=15<hr />sh404SEF macht dann einen 301 redirect zur aktuellen URL wenn eine dieser URLs verlangt wird');
define('COM_SH404SEF_HOME_ALIAS',           'HomePage Alias');
define('COM_SH404SEF_TT_HOME_PAGE_ALIAS_LIST',      'Hier eine Liste (pro Zeile Einen) angeben für die aktuelle Homepage<hr />Beispiel:<br />old-url.html<br/>oder<br/>my-other-old-url.php?var=12&amp;test=15<hr />sh404SEF macht dann einen 301 redirect zur Startseite wenn eine dieser URLs verlangt wird');

define('COM_SH404SEF_USE_DEFAULT_ITEMIDS',      'Itemid einfügen wenn Keine');
define('COM_SH404SEF_TT_USE_DEFAULT_ITEMIDS',   'Wenn aktiviert und eine Nicht-SEF-URL keine Itemid hat, versucht sh404SEF eine Standard-Itemid zu verwenden (pro Komponente - siehe TAB Komponenten)');
define('COM_SH404SEF_ADV_COMP_DEFAULT_ITEMID',    'Vorgabe Itemid');
define('COM_SH404SEF_TT_ADV_COMP_DEFAULT_ITEMID', 'Ist die Einstellung <b>' . COM_SH404SEF_USE_DEFAULT_ITEMIDS . '</b> aktiviert (Tab Erweitert), kann hier eine Standard-Itemid angegben werden.<br />Sie wird imemr dann angewendet, wennd as CMS oder eine Komponente eine URL ohne Itemid erzeugt');

define('COM_SH404SEF_INSERT_OUTBOUND_LINKS_IMAGE',  'Externurl Symbol');
define('COM_SH404SEF_TT_INSERT_OUTBOUND_LINKS_IMAGE', 'Wenn aktiviert, wird bei jedem Link welche diese Webseiten verlässt ein Symbol angezeigt (zur leichteren Identifikation dieser Links)');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_BLACK', 'Schwarzes Symbol');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_WHITE', 'Weißes Symbol');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE',     'Externlinks Farbensymbol');
define('COM_SH404SEF_TT_OUTBOUND_LINKS_IMAGE',    'Beide Bilder verwenden einen transparenten Hintergrund<br />Je nach aktuellem Webseitenhintergrund das Passende wählen<hr />Die Bilder sind im Ordner /administrator/components/com_sef/images/ unter external-white.png und external-black.png gespeichert und sind  15x16 pixels Groß');

// V 1.3.3
define('COM_SH404SEF_DEFAULT_PARAMS_TITLE',       'Experten');
define('COM_SH404SEF_DEFAULT_PARAMS_WARNING',       'Warnung: Ändern Sie diese Einstellungen nur wenn Sie genau wissen was Sie tun! Im Fall eines Fehlers können Schäden am system entstehen die nur schwer zu beheben sind!');

// V 1.0.12
define('COM_SH404SEF_USE_CAT_ALIAS', 'Kategorie-Alias verwenden');
define('COM_SH404SEF_TT_USE_CAT_ALIAS', 'Auf <strong>Ja</strong> eingestellt, wird sh404sef für die Erstellung der URL anstatt dem Kategorienamen den Kategorie-Alias verwenden.');
define('COM_SH404SEF_USE_SEC_ALIAS', 'Bereich-Alias verwenden');
define('COM_SH404SEF_TT_USE_SEC_ALIAS', 'Auf <strong>Ja</strong>eingestellt, wird sh404sef für die Erstellung der URL anstatt dem Bereich-Namen den Bereich-Alias verwenden.');
define('COM_SH404SEF_USE_MENU_ALIAS', 'Menü-Alias verwenden');
define('COM_SH404SEF_TT_USE_MENU_ALIAS', 'Auf <strong>Ja</strong>eingestellt, wird sh404sef für die Erstellung der URL anstatt dem Titel, den Alias eines Menüeintrags verwenden.');
define('COM_SH404SEF_ENABLE_TABLE_LESS', 'tabellenfreie Seitenausgabe');
define('COM_SH404SEF_TT_ENABLE_TABLE_LESS', 'Auf <strong>Ja</strong>eingestellt, wird sh404sef Joomla zwingen den Inhalt mit DIV Tags zu strukturieren und nicht mit verschachtelten Tabellen. Dies geschieht unabhängig von dem template das Sie verwenden. Damit das funktioniert dürfen Sie das <strong>Beez</strong>Template nicht entfernen. Das Beez Template wird automatisch mit Joomla installiert.<br /><strong>WARNUNG</strong>: Sie werden Ihr Stylesheet an dieses neue Ausgabeformat anpassen müssen.');

// V 1.0.13
define( 'COM_SH404SEF_JC_MODULE_CACHING_DISABLED', 'Für das Joomfish Sprachauswahl Modul wurde das Caching deaktiviert!');

// V 1.5.3
define('COM_SH404SEF_ALWAYS_APPEND_ITEMS_PER_PAGE', 'Anzahl der Elemente pro Seite immer hinzufügen');
define('COM_SH404SEF_TT_ALWAYS_APPEND_ITEMS_PER_PAGE', 'Auf <strong>Ja</strong> eingestellt, wird sh404sef die Anzahl der Elemente (z.B. Beiträge), die auf einer Seite angezeigt werden in die URL mehrseitiger Bereiche einbauen. Ein Beispiel: .../Seite-2.html wird zu .../Seite2-10.html wenn die aktuellen Einstellungen 10 Elemente pro Seite erlauben. Diese Einstellung wird benötigt, wenn man den Benutzern der Seite erlaubt die Anzahl an Elementen pro Seite über ein Drop-Down Menü festzulegen.');
define('COM_SH404SEF_REDIRECT_CORRECT_CASE_URL', '301 Weiterleitung zu URL mit korrekter Groß-Kleinschreibung.');
define('COM_SH404SEF_TT_REDIRECT_CORRECT_CASE_URL', 'Auf <strong>Ja</strong> eingestellt, wird sh404sef eine 301 Weiterleitung auf eine URL aus der Datenbank durchführen, wenn die Groß-Kleinschreibung der aufgerufenen URL nicht mit der Schreibweise der URL in der Datenbank Übereinstimmt. Ein Beispiel:  example.com/My-page.html wird auf example.com/my-page.html ungeleitet, wenn letztere in der Datenbank gespeichert ist.');

// V 1.5.5
define('COM_SH404SEF_JOOMLA_LIVE_SITE', 'Joomla live_site');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE', 'Sie sollten hier die Basis-URL Ihrer Webseite sehen. Beispielsweise <br />http://www.example.com<br/>or<br/> http://example.com<br />(ohne abschließenden Schrägstrich)<br />Das ist eigentlich keine sh404sef Einstellung sondern eine Einstellung von <b>Joomla</b> selbst. Diese Einstellung wird in Joomlas Konfigurationsdatei, configuration.php, gespeichert.<br />Joomla sollte normalerweise das Wurzelverzeichnis der Webseite automatisch ermitteln. Sollte die hier angezeigte URL nicht korrekt sein sollten Sie die Einstellung von Hand korrigieren. Dazu ändern Sie den Konfigurationseintrag für $live_site in der configuration.php.<br/>Probleme die mit einem falschen Wert in verbindung stehen können sind: : Vorlagen oder Bilder werden nicht korrekt angezeigt. Schaltflächen funktionieren nicht, oder alle Stile wie Farben und Schriftarten fehlen.');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE_MISSING', 'WARNUNG: $live_site fehlt in der Joomla configuration.php, oder der Wert beginnt nicht mit "http://" oder "https://"!');
define('COM_SH404SEF_JCL_INSERT_EVENT_ID', 'Event Id einfügen');
define('COM_SH404SEF_TT_JCL_INSERT_EVENT_ID', 'Auf <strong>Ja</strong> eingestellt, wird in URLs die interne Event Id dem Titel des Events vorangestellt, um die URL eindeutig zu machen.');
define('COM_SH404SEF_JCL_INSERT_CATEGORY_ID', 'Kategorie Id einfügen');
define('COM_SH404SEF_TT_JCL_INSERT_CATEGORY_ID', 'Auf <strong>Ja</strong> eingestellt, wird in URLs die interne Kategorie Id dem Titel der Kategorie vorangestellt, um die URL eindeutig zu machen.');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_ID', 'Kalender Id einfügen');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_ID', 'Auf <strong>Ja</strong> eingestellt, wird in URLs die interne Kalender Id dem Titel des Kalenders vorangestellt, um die URL eindeutig zu machen.');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_NAME', 'Kalender Namen einfügen');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_NAME', 'Auf <strong>Ja</strong> eingestellt, wird allen URLs die auf einen spezifischen Kalender verweisen der Name des Kalenders hinzugefügt. Ist in der URL keine Kalender Id enthalten, wird der Titel des Menüeintrags verwendet, der auf den Kalender verweist');
define('COM_SH404SEF_JCL_INSERT_DATE', 'Datum hinzufügen');
define('COM_SH404SEF_TT_JCL_INSERT_DATE', 'Auf <strong>Ja</strong> eingestellt, wird das Publikationsdatum der Zielseite in die URL eingefügt.');
define('COM_SH404SEF_JCL_INSERT_DATE_IN_EVENT_VIEW', 'Event Datum hinzufügen');
define('COM_SH404SEF_TT_JCL_INSERT_DATE_IN_EVENT_VIEW', 'Auf <strong>Ja</strong> eingestellt, wird der URL zu der Detailseite eines Events das Datum des Events vorangestellt.');
define('COM_SH404SEF_JCL_TITLE', 'JCal Pro Konfiguration');
define('COM_SH404SEF_PAGE_TITLE_TITLE', 'Seiten-Titel Konfiguration');
define('COM_SH404SEF_CONTENT_TITLE_TITLE', 'Joomla Beitragsseiten Titel Konfiguration');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_SECTION', 'Bereich hinzufügen');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_SECTION', 'Auf <strong>Ja</strong> eingestellt, wird dem Seiten Titel des Beitrags der Bereichsname hinzugefügt');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_CAT', 'Kategorie hinzufügen');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_CAT', 'Auf <strong>Ja</strong> eingestellt, wird dem Seiten Titel des Beitrags der Kategoriename hinzugefügt');
define('COM_SH404SEF_CONTENT_TITLE_USE_ALIAS', 'Alias für Beitrags-Titel verwenden');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_ALIAS', 'Auf <strong>Ja</strong> eingestellt, wird im Seitentitel der Alias des Beitrags anstelle des Beitragstitel verwendet.');
define('COM_SH404SEF_CONTENT_TITLE_USE_CAT_ALIAS', 'Alias der Kategorie verwenden');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_CAT_ALIAS', 'Auf <strong>Ja</strong> eingestellt, wird im Seitentitel der Alias der Kategorie anstelle des Kategorietitel verwendet.');
define('COM_SH404SEF_CONTENT_TITLE_USE_SEC_ALIAS', 'Alias des Bereich verwenden');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_SEC_ALIAS', 'Auf <strong>Ja</strong> eingestellt, wird im Seitentitel der Alias des Bereich anstelle des Bereichtitel verwendet.');
define('COM_SH404SEF_PAGE_TITLE_SEPARATOR', 'Trenner für Seitentitel');
define('COM_SH404SEF_TT_PAGE_TITLE_SEPARATOR', 'Tragen Sie hier ein Zeichen oder eine Zeichenkette ein, um die verschiedenen Teile des Seitentitel zu trennen. Als Standard wird " | " ohne die Anführungszeichen verwendet.');

// V 1.5.7
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_TITLE', 'Duplikate');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_NOT', 'Nur Haupt-URL anzeigen');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS', 'Haupt-URL und Duplikate anzeigen');
define('COM_SH404SEF_INSERT_ARTICLE_ID_TITLE', 'Beitrags-Id in URL einfügen');
define('COM_SH404SEF_TT_INSERT_ARTICLE_ID_TITLE', 'Auf <strong>Ja</strong> eingestellt, in der URL dem Beitragstitel die Beitrags-Id vorangestellt. Das stellt sicher, dass alle Beiträge ufgerufen werden können, selbst wenn sie identische Titel besitzen. So kann auch vermiden weden, daß die URL zu zwei verschiedenen Beiträgen durch Normalisierung der URL (Entfernung von Sonderzeichen, Umlauten, etc.) identisch werden. Diese Funktion bringt keine Verbesserung der SEO, eher das Gegenteil. Sie sollten daher darauf achten, dass Sie keine Beiträge mit gleichlautendem Titel innerhalb einer Kategorie oder eines Bereichs haben. Diese Funktion ist primär für Seiten gedacht, bei denen Sie keine Kontrolle über die Beitragstitel besitzen und so sicherstellen können, daß auch Beiträge mit idemtischem Titel erreichbar sind.');

// V 1.5.8

define('COM_SH404SEF_JS_TITLE', 'JomSocial Konfiguration ');
define('COM_SH404SEF_JS_INSERT_NAME', 'Jomsocial Name einfügen');
define('COM_SH404SEF_TT_JS_INSERT_NAME', 'Auf <strong>Ja</strong> eingestellt, wird der Titel des Menüeintrags zur JomSocial Hauptseite allen URLs zu Seiten der Komponente vorangestellt.');
define('COM_SH404SEF_JS_INSERT_USER_NAME', 'Nicknamen einfügen');
define('COM_SH404SEF_TT_JS_INSERT_USER_NAME', 'Auf <strong>Ja</strong> eingestellt, wird der Nickname in die URL eingefügt. <strong>WARNUNG</strong>: Wenn Sie viele registrierte Benutzer haben kann diese Funktion die Datenbank erheblich belasten und ihre Seite langsamer machen.');
define('COM_SH404SEF_JS_INSERT_USER_FULL_NAME', 'Vollen Namen einfügen.');
define('COM_SH404SEF_TT_JS_INSERT_USER_FULL_NAME', 'Auf <strong>Ja</strong> eingestellt, wird der volle Name des Benutzers in die URL eingefügt. <strong>WARNUNG</strong>: Wenn Sie viele registrierte Benutzer haben kann diese Funktion die Datenbank erheblich belasten und ihre Seite langsamer machen.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY', 'Kategorie der Gruppe einfügen');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY', 'Auf <strong>Ja</strong> eingestellt, wird die Kategorie der Gruppe des Benutzers in der SEF URL dem Gruppennamen vorangestellt.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY_ID', 'Kategorie Id der Gruppe einfügen');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY_ID', 'Auf <strong>Ja</strong> eingestellt, wird in SEF URLs die Id der Kategorie einer Benutzergruppe dem Kategorienamen vorangestellt. <strong>Diese Einstellung wird nur aktiv wenn die vorhergehende Einstellung ebenfalls aktiviert wird.</strong>. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Kategorienamen von Gruppen entstehen können.');
define('COM_SH404SEF_JS_INSERT_GROUP_ID', 'Gruppen Id einfügen');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id der Benutzergruppe dem Gruppennamen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Gruppennamen entstehen können.');
define('COM_SH404SEF_JS_INSERT_GROUP_BULLETIN_ID', 'Id der Gruppen-Pinnwand einfügen ');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_BULLETIN_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id der Gruppen-Pinnwand ihrem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Namen Pinnwände entstehen können.');
define('COM_SH404SEF_JS_INSERT_DISCUSSION_ID', 'Id der Gruppen-Diskussion einfügen');
define('COM_SH404SEF_TT_JS_INSERT_DISCUSSION_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id der Gruppen-Diskussion ihrem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Namen der Gruppen-Diskussionen entstehen können.');
define('COM_SH404SEF_JS_INSERT_MESSAGE_ID', 'Id der Nachricht einfügen');
define('COM_SH404SEF_TT_JS_INSERT_MESSAGE_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id der Nachricht ihrem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Namen der Nachrichten entstehen können.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM', 'Namen des Albums einfügen');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM', 'Auf <strong>Ja</strong> eingestellt, wird in SEF URLs zu Bildern und Bildersammlungen der Name des Albums, zu dem sie gehören, eingefügt.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM_ID', 'Id des Albums einfügen');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id des Albums seinem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Albumnamen entstehen können');
define('COM_SH404SEF_JS_INSERT_PHOTO_ID', 'Id des Fotos einfügen');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id des Fotos seinem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Namen der Fotos entstehen können.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT', 'Namen der Video-Kategorie einfügen');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT', 'Auf <strong>Ja</strong> eingestellt, wird der Name der Kategorie zu der das Video gehört in die SEF URL von Videos und Sammlungen eingefügt.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT_ID', 'Id der Video-Kategorie einfügen');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id der Video-Kategorie ihrem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Namen von Video-Kategorien entstehen können');
define('COM_SH404SEF_JS_INSERT_VIDEO_ID', 'Id von Videos einfügen');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id des Videos seinem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Namen von Videos entstehen können.');
define('COM_SH404SEF_FB_INSERT_USERNAME', 'Benutzername einfügen');
define('COM_SH404SEF_TT_FB_INSERT_USERNAME', 'Auf <strong>Ja</strong> eingestellt, wird der Benutzername in SEF URLs des Benutzerprofils und in URLs zu Beiträgen des Benutzers eingefügt.');
define('COM_SH404SEF_FB_INSERT_USER_ID', 'Id des Benutzer einfügen');
define('COM_SH404SEF_TT_FB_INSERT_USER_ID', 'Auf <strong>Ja</strong> eingestellt, wird die Id des Benutzers seinem Namen vorangestellt. Diese Einstellung dient zur Vermeidung identischer URLs die durch die Normalisierung ähnlicher Benutzernamen entstehen können.');
define('COM_SH404SEF_PAGE_NOT_FOUND_ITEMID', 'Itemid der 404 Fehlerseite.');
define('COM_SH404SEF_TT_PAGE_NOT_FOUND_ITEMID', 'Wird hier die ItemId eines Menüeintrags eingetragen ermittelt sh404sef anhand dieses Wertes welches Template und welche Module für die 404 fehlerseite geladen werden sollen. Sie finden die ItemId in der Liste der Menüeinträge in der äuserst rechten Spalte.');

//define('', '');
