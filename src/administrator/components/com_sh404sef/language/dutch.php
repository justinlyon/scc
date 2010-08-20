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
// Dutch translation for http://www.joomlacommunity.eu/ by Marieke van der Tuin, taal@joomlacommunity.eu
//
// Additions by Yannick Gaultier (c) 2006-2010
// Dont allow direct linking
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

define('COM_SH404SEF_404PAGE','404 Pagina');
define('COM_SH404SEF_ADD','Toevoegen');
define('COM_SH404SEF_ADDFILE','Standaard index bestand');
define('COM_SH404SEF_ASC',' (Oplopend) ');
define('COM_SH404SEF_BACK','Terug naar het controlepaneel van sh404SEF');
define('COM_SH404SEF_BADURL','De oude niet-SEF URL moet beginnen met index.php');
define('COM_SH404SEF_CHK_PERMS','U dient uw bestandsrechten na te kijken om er zeker van te zijn dat dit bestand gelezen kan worden.');
define('COM_SH404SEF_CONFIG','sh404SEF<br/>Instellingen');
define('COM_SH404SEF_CONFIG_DESC','Stel alle mogelijkheden van sh404SEF in');
define('COM_SH404SEF_CONFIG_UPDATED','Instellingen bijgewerkt');
define('COM_SH404SEF_CONFIRM_ERASE_CACHE', 'Wilt u de inhoud van de URL cache wissen? Dit is erg aanbevolen nadat u uw instellingen heeft gewijzigd. Bezoek opnieuw uw website om de cache weer te cree&euml;n. Het is overigens beter om een sitemap voor uw website te maken.');
define('COM_SH404SEF_COPYRIGHT','Copyright');
define('COM_SH404SEF_DATEADD','Datum toegevoegd');
define('COM_SH404SEF_DEBUG_DATA_DUMP','Fouten verwijdering uit de data dump voltooid: Laden van de pagina be&euml;indigd');
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
define('COM_SH404SEF_DEF_404_PAGE','Standaard 404 Pagina');
define('COM_SH404SEF_DESC',' (Aflopend) ');
define('COM_SH404SEF_DISABLED',"<p class='error'>LET OP: SEF ondersteuning in Joomla is op dit moment uitgeschakeld. Schakel SEF in via uw<a href='".$GLOBALS['shConfigLiveSite']."/administrator/index.php?option=com_config'> Algemene instellingen</a> SEO pagina.</p>");
define('COM_SH404SEF_EDIT','Bewerk');
define('COM_SH404SEF_EMPTYURL','U moet een URL opgeven voor doorverwijzing');
define('COM_SH404SEF_ENABLED','Activeer');
define('COM_SH404SEF_ERROR_IMPORT','Foutmelding tijdens het importeren:');
define('COM_SH404SEF_EXPORT','Backup links');
define('COM_SH404SEF_EXPORT_FAILED','EXPORTEREN MISLUKT!!!');
define('COM_SH404SEF_FATAL_ERROR_HEADERS','FATALE FOUTMELDING: DE HEADER IS REEDS VERZONDEN');
define('COM_SH404SEF_FRIENDTRIM_CHAR','Verwijder karakters');
define('COM_SH404SEF_HELP','sh404SEF<br/>Omdersteuning');
define('COM_SH404SEF_HELPDESC','Hulp nodig met sh404SEF?');
define('COM_SH404SEF_HELPVIA','<b>U kunt hulp krijgen via de volgende fora: </b>');
define('COM_SH404SEF_HIDE_CAT','Verberg categorie');
define('COM_SH404SEF_HITS','Hits');
define('COM_SH404SEF_IMPORT','Importeer aangepaste URL\'s');
define('COM_SH404SEF_IMPORT_EXPORT','Importeer/Exporteer URL\'s');
define('COM_SH404SEF_IMPORT_OK','Aangepaste URL\'s zijn succesvol ge&iuml;mporteerd!');
define('COM_SH404SEF_INFO','sh404SEF<br/>Documentatie');
define('COM_SH404SEF_INFODESC','Bekijk de samenvatting en de documentatie van het sh404SEF Project');
define('COM_SH404SEF_INSTALLED_VERS','Ge&iuml;nstalleerde versie:');
define('COM_SH404SEF_INVALID_SQL','ONGELDIGE DATA IN SQL BESTAND:');
define('COM_SH404SEF_INVALID_URL','ONGELDIGE URL: deze link dient een geldige Itemid te bevatten, maar er is er geen gevonden voor deze link.<br/>OPLOSSING: Maak een menu item aan voor dit onderdeel. U hoeft het niet te publiceren, het aanmaken ervan is voldoende.');
define('COM_SH404SEF_LICENSE','Licentie');
define('COM_SH404SEF_LOWER','Geen hoofdletters gebruiken');
define('COM_SH404SEF_MAMBERS','Mambers Forum');
define('COM_SH404SEF_NEWURL','Oude geen-SEF URL');
define('COM_SH404SEF_NO_UNLINK','Niet in staat om het ge&uuml;ploade bestand vanuit de media-map te verplaatsen');
define('COM_SH404SEF_NOACCESS','Niet in staat om toegang te krijgen');
define('COM_SH404SEF_NOCACHE','Geen caching');
define('COM_SH404SEF_NOLEADSLASH','Er dient geen slash teken voor de nieuwe SEF URL te staan.');
define('COM_SH404SEF_NOREAD','FATALE FOUTMELDING: Niet in staat om dit bestand te lezen: ');
define('COM_SH404SEF_NORECORDS','Geen records gevonden.');
define('COM_SH404SEF_OFFICIAL','Officieel Project Forum');
define('COM_SH404SEF_OK',' Oke ');
define('COM_SH404SEF_OLDURL','Niewe SEF URL');
define('COM_SH404SEF_PAGEREP_CHAR','Karakter tussen verschillende pagina\'s');
define('COM_SH404SEF_PAGETEXT','Pagina tekst');
define('COM_SH404SEF_PROCEED',' Voortgang ');
define('COM_SH404SEF_PURGE404','Verwijder<br/>404 Logs');
define('COM_SH404SEF_PURGE404DESC','Verwijder 404 Logs');
define('COM_SH404SEF_PURGECUSTOM','Verwijder<br/>Aangepaste doorverwijzingen');
define('COM_SH404SEF_PURGECUSTOMDESC','Verwijder Aangepaste doorverwijzingen');
define('COM_SH404SEF_PURGEURL','Verwijder<br/>SEF URL\'s');
define('COM_SH404SEF_PURGEURLDESC','Verwijder SEF URL\'s');
define('COM_SH404SEF_REALURL','Echte URL');
define('COM_SH404SEF_RECORD',' record');
define('COM_SH404SEF_RECORDS',' records');
define('COM_SH404SEF_REPLACE_CHAR','Vervangend karakter');
define('COM_SH404SEF_SAVEAS','Sla op als aangepaste doorverwijzing');
define('COM_SH404SEF_SEFURL','SEF URL');
define('COM_SH404SEF_SELECT_DELETE','Selecteer een artikel om te verwijderen');
define('COM_SH404SEF_SELECT_FILE','U dient eerst een bestand te selecteren');
define('COM_SH404SEF_ACTIVATE_IJOOMLA_MAG', 'Activeer iJoomla magazine in de inhoud');
define('COM_SH404SEF_ADV_INSERT_ISO', 'Voeg ISO code toe');
define('COM_SH404SEF_ADV_MANAGE_URL', 'Voortgang URL');
define('COM_SH404SEF_ADV_TRANSLATE_URL', 'Vertaal URL');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID', 'Voeg altijd een Itemid toe aan de SEF URL');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX', 'menu id');
define('COM_SH404SEF_ALWAYS_INSERT_MENU_TITLE', 'Voeg altijd de menu titel toe');
define('COM_SH404SEF_CACHE_TITLE', 'Cache beheer');
define('COM_SH404SEF_CAT_TABLE_SUFFIX', 'Tabel');
define('COM_SH404SEF_CB_INSERT_NAME', 'Voeg Community Builder naam toe');
define('COM_SH404SEF_CB_INSERT_USER_ID', 'Voeg gebruikers ID toe');
define('COM_SH404SEF_CB_INSERT_USER_NAME', 'Voeg gebruikersnaam toe');
define('COM_SH404SEF_CB_NAME', 'Standaard CB naam');
define('COM_SH404SEF_CB_TITLE', 'Community Builder instellingen ');
define('COM_SH404SEF_CB_USE_USER_PSEUDO', 'Vul gebruikers alias toe');
define('COM_SH404SEF_CONF_TAB_ADVANCED', 'Geavanceerd');
define('COM_SH404SEF_CONF_TAB_BY_COMPONENT', 'Component');
define('COM_SH404SEF_CONF_TAB_MAIN', 'Hoofd');
define('COM_SH404SEF_CONF_TAB_PLUGINS', 'Plugins');
define('COM_SH404SEF_DEFAULT_MENU_ITEM_NAME', 'Standaard menu titel');
define('COM_SH404SEF_DO_NOT_INSERT_LANGUAGE_CODE','Voeg geen codes toe');
define('COM_SH404SEF_DO_NOT_OVERRIDE_SEF_EXT', 'Overschrijf sef_ext niet');
define('COM_SH404SEF_DO_NOT_TRANSLATE_URL','Niet vertalen');
define('COM_SH404SEF_ENCODE_URL', 'Encodeer URL');
define('COM_SH404SEF_FB_INSERT_CATEGORY_ID', 'Voeg categorie ID toe');
define('COM_SH404SEF_FB_INSERT_CATEGORY_NAME', 'Voeg categorienaam toe');
define('COM_SH404SEF_FB_INSERT_MESSAGE_ID', 'Voeg bericht ID toe');
define('COM_SH404SEF_FB_INSERT_MESSAGE_SUBJECT', 'Voeg berichtonderwerp toe');
define('COM_SH404SEF_FB_INSERT_NAME', 'Voeg de naam van Kunena toe');
define('COM_SH404SEF_FB_NAME', 'Standaard Kunena naam');
define('COM_SH404SEF_FB_TITLE', 'Kunena instellingen ');
define('COM_SH404SEF_FILTER', 'Filter');
define('COM_SH404SEF_FORCE_NON_SEF_HTTPS', 'Gebruik geen SEF voor HTTPS');
define('COM_SH404SEF_GUESS_HOMEPAGE_ITEMID', 'Raad Itemid van uw homepagina');
define('COM_SH404SEF_IJOOMLA_MAG_NAME', 'Standaard magazine naam');
define('COM_SH404SEF_IJOOMLA_MAG_TITLE', 'iJoomla Magazine instellingen');
define('COM_SH404SEF_INSERT_GLOBAL_ITEMID_IF_NONE', 'Voeg menu Itemid toe als er geen beschikbaar is voor de specieke inhoud');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Voeg artikel ID toe aan URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ISSUE_ID', 'Voeg kwestie id toe aan URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Voeg magazine id toe aan URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_NAME', 'Voeg magazine naam toe aan URL');
define('COM_SH404SEF_INSERT_LANGUAGE_CODE', 'Voeg taalcodes toe aan URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID', 'Voeg numeriek id toe aan URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_ALL_CAT', 'Alle categorie&euml;n');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST', 'Pas toe bij de volgende categorie&euml;n');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE', 'Uniek ID');
define('COM_SH404SEF_INSERT_PRODUCT_ID', 'Voeg product ID toe aan URL');
define('COM_SH404SEF_INSERT_PRODUCT_NAME', 'Voeg productnaam toe aan URL'); 
define('COM_SH404SEF_INSERT_TITLE_IF_NO_ITEMID', 'Voeg menu titel toe als er geen Itemid is');
define('COM_SH404SEF_ITEMID_TITLE', 'Itemid beheer');
define('COM_SH404SEF_LETTERMAN_DEFAULT_ITEMID', 'Standaard Itemid voor Letterman pagina');
define('COM_SH404SEF_LETTERMAN_TITLE', 'Letterman instellingen ');
define('COM_SH404SEF_LIVE_SECURE_SITE', 'SSL veilige URL');
define('COM_SH404SEF_LOG_404_ERRORS', 'Log 404 foutmeldingen');
define('COM_SH404SEF_MAX_URL_IN_CACHE', 'Cache grootte');
define('COM_SH404SEF_OVERRIDE_SEF_EXT', 'Overschrijf sef_ext bestand');
define('COM_SH404SEF_REDIR_404', '404');
define('COM_SH404SEF_REDIR_CUSTOM', 'Aangepast');
define('COM_SH404SEF_REDIR_SEF', 'SEF');
define('COM_SH404SEF_REDIR_TOTAL', 'Totaal');
define('COM_SH404SEF_REDIRECT_JOOMLA_SEF_TO_SEF', '301 doorverwijzen van JOOMLA SEF naar sh404SEF');
define('COM_SH404SEF_REDIRECT_NON_SEF_TO_SEF', '301 doorverwijzen van geen-SEF naar SEF URL');
define('COM_SH404SEF_REPLACEMENTS', 'Vervangingslijst van karakters');
define('COM_SH404SEF_SHOP_NAME', 'Standaard winkelnaam');
define('COM_SH404SEF_TRANSLATE_URL', 'Vertaal URL');
define('COM_SH404SEF_TRANSLATION_TITLE', 'Vertaalbeheer');
define('COM_SH404SEF_USE_URL_CACHE', 'Activeer URL cache');
define('COM_SH404SEF_VM_ADDITIONAL_TEXT', 'Toegevoegde tekst');
define('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES', 'Geen');
define('COM_SH404SEF_VM_INSERT_CATEGORIES', 'Voeg categorie&euml;n toe');
define('COM_SH404SEF_VM_INSERT_CATEGORY_ID', 'Voeg categorie ID toe aan URL');
define('COM_SH404SEF_VM_INSERT_FLYPAGE', 'Vul de flypage naam in');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_ID', 'Voeg bedrijfs ID toe');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_NAME', 'Voeg bedrijfsnaam toe aan URL');
define('COM_SH404SEF_VM_INSERT_SHOP_NAME', 'Voeg de winkelnaam toe aan URL');
define('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES', 'Alle geneste categorie&euml;n');
define('COM_SH404SEF_VM_SHOW_LAST_CATEGORY', 'Alleen laatste');
define('COM_SH404SEF_VM_TITLE', 'Virtuemart instellingen');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU', 'Gebruik product SKU als naam');
define('COM_SH404SEF_SHOW_CAT', 'Toon Categorie');
define('COM_SH404SEF_SHOW_SECT','Toon Sectie');
define('COM_SH404SEF_SHOW0','Toon SEF URL\'s');
define('COM_SH404SEF_SHOW1','Toon 404 Log');
define('COM_SH404SEF_SHOW2','Toon aangepaste doorverwijzingen');
define('COM_SH404SEF_SKIP','Sla over');
define('COM_SH404SEF_SORTBY','Sorteer op:');
define('COM_SH404SEF_STRANGE','Er is iets vreemds gebeurd. Dit had niet mogen gebeuren<br />');
define('COM_SH404SEF_STRIP_CHAR','Verwijder karakters');
define('COM_SH404SEF_SUCCESSPURGE','Records succesvol verwijderd');
define('COM_SH404SEF_SUFFIX','Bestand suffix');
define('COM_SH404SEF_SUPPORT','Ondersteunings<br/>Website');
define('COM_SH404SEF_SUPPORT_404SEF','Help ons');
define('COM_SH404SEF_SUPPORTDESC','Ga naar de sh404SEF website (nieuw venster)');
define('COM_SH404SEF_TITLE_ADV','Geavanceerde component instellingen');
define('COM_SH404SEF_TITLE_BASIC','Basis instellingen');
define('COM_SH404SEF_TITLE_CONFIG','sh404SEF Instellingen');
define('COM_SH404SEF_TITLE_MANAGER','sh404SEF URL beheer');
define('COM_SH404SEF_TITLE_PURGE','sh404SEF Verwijder Database');
define('COM_SH404SEF_TITLE_SUPPORT','sh404SEF Ondersteuning');
define('COM_SH404SEF_TT_404PAGE','Statische content pagina gebruiken als 404 Niet Gevonden foutmelding');
define('COM_SH404SEF_TT_ADDFILE','Bestandsnamen plaatsen achter een lege URL / als er geen bestand bestaat. Handig voor bots die uw site doorzoeken voor specifieke bestanden, maar vastlopen door een 404 pagina.');
define('COM_SH404SEF_TT_ADV','<b>gebruik standaard</b><br/>zoals normaal, als een geavanceerde SEF extensie aanwezig is wordt deze in plaats van dit gebruikt.<br/><b>geen caching</b><br/>Sla het niet in uw database op en maak oude SEF URL\'s. <br/><b>sla over</b><br/>Maak geen SEF URL\'s voor dit component<br/>');
define('COM_SH404SEF_TT_ADV4','Geavanceerde opties voor ');
define('COM_SH404SEF_TT_ENABLED','Als u dit instelt op nee zal de standaard SEF voor Joomla! worden gebruikt');
define('COM_SH404SEF_TT_FRIENDTRIM_CHAR','Karakters die verwijderd dienen te worden uit de URL, gescheiden door |. Warning: if you change this from its default value, make sure to not leave it empty. At least use a space. Due to a small bug in Joomla, this cannot be left empty.');
define('COM_SH404SEF_TT_LOWER','Wijzig alle karakters naar kleine letters in de URL','Alles met kleine letters');
define('COM_SH404SEF_TT_NEWURL','Deze URL dient te beginnen met index.php');
define('COM_SH404SEF_TT_OLDURL','Alleen relatieve doorverwijzingen vanaf de Joomla! hoofdmap <i>zonder</i> het voorste slash teken');
define('COM_SH404SEF_TT_PAGEREP_CHAR','Te gebruiken karakter om pagina nummers van de rest te scheiden in de URL');
define('COM_SH404SEF_TT_PAGETEXT','Tekst toegevoegd aan een URL voor meerdere pagina\'s. Gebruik $s om een paginanummer toe te voegen, als u het standaard laat zal deze op het eind worden weergegeven. Als er een suffix is gedefinieerd zal deze worden toegevoegd aan het einde van deze string.');
define('COM_SH404SEF_TT_REPLACE_CHAR','Karakter om onbekende karakters mee te vervangen in de URL');
define('COM_SH404SEF_TT_ACTIVATE_IJOOMLA_MAG', 'Als deze is ingesteld op <strong>ja</strong>, dan wordt de id uit com_content component ge&iuml;nterpreteerd als een iJoomla magazine editie id.');
define('COM_SH404SEF_TT_ADV_INSERT_ISO', 'Voor elk ge&iuml;nstalleerd component, en wanneer uw site meertalig is, kies om de ISO taalcode toe te voegen aan de SEF URL. Bijvoorbeeld : www.monsite.com/<b>fr</b>/introduction.html. fr staat voor Frans. Deze code wordt niet toegevoegd aan de URL\'s in de standaardtaal.');
define('COM_SH404SEF_TT_ADV_MANAGE_URL', 'Voor elk ge&iuml;nstalleerd component:<br /><b> gebruik standaard</b><br/> zoals normaal, als een geavanceerde SEF extensie aanwezig is zal hij deze vervangen.<br/><b>nocache</b><br/>Sla niet op in de database en maak in plaats daarvan SEF URL\'s in de oude stijl. <br/><b>sla over</b><br/>Maak geen SEF URL\'s voor dit component<br/>');
define('COM_SH404SEF_TT_ADV_OVERRIDE_SEF', 'Een aantal componenten hebben hun eigen sef_ext bestanden gemaakt voor Joomla SEF, OpenSEF of geavanceerde SEF. Als deze parameter aan is gezet, zal dit extensie bestand niet gebruikt worden, en de sh404SEF plugin wel  (ervanuit gaande dat er een is voor dat component). Zo niet, zal het sef_ext bestand van de extensie worden gebruikt.');
define('COM_SH404SEF_TT_ADV_TRANSLATE_URL', 'Voor elk ge&iuml;nstalleerd component, selecteer of de URL vertaald moet worden. Dit heeft geen effect als uw site maar een taal bevat.');
define('COM_SH404SEF_TT_ALWAYS_INSERT_ITEMID', 'Als u deze instelt op Ja, zal de geen-SEF Itemid (of de Itemid van het menu item als er niets als geen-SEF URL staat) toegevoegd worden aan de SEF URL. Dit dient u te gebruiken in plaats van de menutitel parameter, als u verschillende menu items heeft met dezelfde titel (bijvoorbeeld een uit het hoofdmenu en een uit het topmenu)');
define('COM_SH404SEF_TT_ALWAYS_INSERT_MENU_TITLE', 'Als u deze instelt op Ja, zal de titel van het menu item worden toegevoegd aan de SEF URL.');
define('COM_SH404SEF_TT_CB_INSERT_NAME', 'Als u deze instelt op Ja, zal de titel van het menu element die leidt tot de hoofdpagina van Community Builder worden toegevoegd aan alle CB SEF URL\'s.');
define('COM_SH404SEF_TT_CB_INSERT_USER_ID', 'Als u deze instelt op Ja, zal de gebruikers ID worden toegevoegd aan de naam, alleen waneer de vorige optie op Ja staat ingestelt. U dient dit te gebruiken wanneer twee gebruikers dezelfde naam hebben.');
define('COM_SH404SEF_TT_CB_INSERT_USER_NAME', 'Als u deze instelt op Ja, zal de gebruikersnaam worden toegevoegd aan de SEF URL\'s. <strong>LET OP</strong>: dit kan leiden tot een enorme vergroting van de database en uw site vertragen, als u veel geregistreerde gebruikers heeft. Als u deze instelt op Nee, zal de gebruikers ID worden gebruikt, in normaal formaat : ..../send-user-email.html?user=245');
define('COM_SH404SEF_TT_CB_NAME', 'Als u de vorige parameter heeft ingestelt op Ja, kunt u deze tekst uit de SEF URL hier overschrijven. Deze tekst is niet variabel, en zal bijvoorbeeld niet vertaald worden.');
define('COM_SH404SEF_TT_CB_USE_USER_PSEUDO', 'Als u deze instelt op Ja, zal de gebruikers alias worden toegevoegd aan de SEF URL, als u de bovenstaande optie heeft geactiveerd, in plaats van de echte naam.');
define('COM_SH404SEF_TT_DEFAULT_MENU_ITEM_NAME', 'Als u de bovenstaande parameter op Ja instelt, kunt u deze tekst uit de SEF URL hier overschrijven. Deze tekst is niet variabel, en zal bijvoorbeeld niet vertaald worden.');
define('COM_SH404SEF_TT_ENCODE_URL', 'Als u deze instelt op Ja, zal de URL gecodeerd worden zodat deze compatibel is met talen die niet-latijnse karakters bevatten. Een gecodeerde URL ziet er als volg uit : mijnsite.nl/%34%56%E8%67%12.....');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_ID', 'Als u deze instelt op Ja, zal de categorie ID worden toegevoegd aan de naam, als de vorige optie op Ja staat ingesteld. U dient dit te gebruiken als twee categorie&euml;n dezelfde naam hebben.');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME', 'Als u deze instelt op Ja, zal de categorienaam worden toegevoegd aan alle SEF links van berichten en categorie&euml;n.');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID', 'Als u deze instelt op Ja, zal elke bericht ID worden toegevoegd aan het onderwerp, als u de vorige optie ook op Ja heeft ingestelt. U dient dit te gebruiken als twee berichten hetzelfde onderwerp hebben.');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_SUBJECT', 'Als u deze instelt op Ja, zal elk berichtenonderwerp worden toegevoegd aan de SEF URL voorafgaand aan dit bericht.');
define('COM_SH404SEF_TT_FB_INSERT_NAME', 'Als u deze instelt op Ja, zal de titel van het menu element dat leidt tot de hoofdpagina van Kunena worden toegevoegd aan alle Kunena SEF URL\'s.');
define('COM_SH404SEF_TT_FB_NAME', 'Als u deze instelt op Ja, zal de naam van Kunena (gedefinieerd als de titel van het menu item) altijd worden toegevoegd aan de SEF URL.');
define('COM_SH404SEF_TT_FORCE_NON_SEF_HTTPS', 'Als u deze instelt op Ja, zal de URL een geen-SEF URL worden wanneer u naar de SSL modus (HTTPS) gaat. Dit zou anders problemen kunnen veroorzaken met sommige SSL servers.');
define('COM_SH404SEF_TT_GUESS_HOMEPAGE_ITEMID', 'Als u deze instelt op Ja, en alleen op de hoofdpagina, zullen alle Itemid en com_content URL\'s vervangen worden door gissingen van sh404SEF. Dit is handig wanneer inhoud elementen op de voorpagina worden weergegeven, maar ook op andere pagina\'s te bezichtigen zijn.');
define('COM_SH404SEF_TT_IJOOMLA_MAG_NAME', 'Als u de vorige parameter op Ja heeft ingestelt, kunt u deze tekst uit de SEF URL hier overschrijven. Deze zal niet variabel zijn, en bijvoorbeeld niet vertaald worden.');
define('COM_SH404SEF_TT_INSERT_GLOBAL_ITEMID_IF_NONE', 'Als er geen Itemid aan de geen-SEF URL wordt toegevoegd voordat deze in een SEF URL veranderd, en u stelt deze optie in op Ja, zal het menu itemid worden toegevoegd. Dit zorgt ervoor dat u naar de juiste pagina wordt doorverwezen.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Als u deze instelt op Ja, zal de artikel ID worden toegevoegd aan elke artikeltitel in een URL, zoals in : <br /> mijnsite.nl/Joomla-magazine/<strong>56</strong>-Goede-artikel-titel.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ISSUE_ID', 'Als u deze instelt op Ja, zal een unieke interne id worden toegevoegd aan elk probleem, om er zeker van te zijn dat deze uniek is.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Als u deze instelt op Ja, zal de magazine ID worden toegevoegd aan elke magazine naam in een URL, zoals in : <br /> mijnsite.nl/<strong>4</strong>-Joomla-magazine/Goede-artikel-titel.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_NAME', 'Als u deze instelt op Ja, zal de naam van het magazine (gedefineerd als menu item titel) altijd worden toegevoegd aan de SEF URL');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE', 'Als u deze instelt op Ja, zal de ISO code van de pagina taal worden toegevoegd aan de SEF URL, tenzij de taal gelijk is aan de standaard site taal.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID', 'Als u deze instelt op Ja, zal een numerieke id worden toegevoegd aan de URL, om diensten aan te bieden zoals Google nieuws. De id zal er zo uit zien : 2007041100000, waarbij 20070411 de datum van cre&euml;en voorstelt, en 00000 het unieke interne id van deze inhoud. U dient tenslotte de datum van aanmaken in te stellen, waneer deze gereed is voor publicatie. Deze dient u niet later te veranderen.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST', 'Numerieke id zal worden toegevoegd aan SEF URL\'s van de categorie inhoud. U kunt meerdere categorie&euml;n selecteren door het ingedrukt houden van de CTRL toets.' );
define('COM_SH404SEF_TT_INSERT_PRODUCT_ID', 'Als u deze instelt op Ja, zal de product ID worden toegevoegd aan de productnaam in de SEF URL<br />Bijvoorbeeld : mijnsite.nl/3-mijn-mooiste-product.html.<br />Dit is handig als u de categorienamen niet toevoegd aan de URL. Verschillende producten kunnen dezelfde naam dragen in verschillende categorie&euml;n. Let u alstublieft op het feit dat dit niet de product SKU is, maar een unieke interne product id. ');
define('COM_SH404SEF_TT_INSERT_TITLE_IF_NO_ITEMID', 'Als u geen Itemid heeft ingesteld in de niet-SEF URL voordat het een SEF URL wordt, en u stelt deze optie in op Ja, zal de titel van het menu item toegevoegd worden aan de SEF URL. Dit dient u in te stellen wanneer u bovenstaande parameter ook op Ja is ingesteld, zodat u geen -2, -3, -... zal krijgen als u hetzelfde artikel vanaf verschillende locaties bekijkt.');
define('COM_SH404SEF_TT_LETTERMAN_DEFAULT_ITEMID', 'Voeg de Itemid van de toe te voegen pagina toe aan Letterman links');
define('COM_SH404SEF_TT_LIVE_SECURE_SITE', 'Stel deze in op de <strong>volledige basis URL van uw site in SSL modus</strong><br />Alleen noodzakelijk als u https toegang heeft. als u deze niet instelt, zal deze standaard httpS://normaleSiteURL. zijn<br />Vult u alstublieft een volledige URL in, zonder een slash aan het einde. Bijvoorbeeld : <strong>https://www.mijnsite.nl</strong> of <strong>https://gedeeldesslserver.com/mijnaccount</strong>.');
define('COM_SH404SEF_TT_LOG_404_ERRORS', 'Als u deze instelt op Ja, zullen 404 foutmeldingen bewaard worden in uw database. Dit kan u helpen met het vinden van foutmeldingen in uw site links. Dit kan veel database ruimte gebruiken, dus u kunt het beter op Nee instellen als uw site goed getest is.');
define('COM_SH404SEF_TT_MAX_URL_IN_CACHE', 'Als URL caching geactiveerd is, zal deze parameter de maximale grootte bepalen. Voer het maximale aantal URL\'s in die kunnen worden opgeslagen. Iedere URL is ongeveer 200 byte. 5000 URL\'s gebruiken dus ongeveer 1Mb aan ruimte.');
define('COM_SH404SEF_TT_REDIRECT_JOOMLA_SEF_TO_SEF', 'Als u deze instelt op Ja, zal de Joomla! standaard SEF URL 301 doorverwezen worden naar hun gelijke van sh404SEF, als die in de database beschikbaar zijn. Als deze niet bestaan, zal deze gemaakt worden wanneer nodig, tenzij er POST data is, dan gebeurt er niets. Warning: this feature will work in most cases, but may give bad redirects for some Joomla SEF URL. Leave off if possible.');
define('COM_SH404SEF_TT_REDIRECT_NON_SEF_TO_SEF', 'Als u deze instelt op Ja, zullen geen-SEF URL\'s die al in de database aanwezig zijn worden doorverwezen naar sh404SEF, gebruikmakend van een 301 - permanent verplaatst doorverwijzing. Als de SEF URL niet bestaat, zal het aangemaakt worden, behalve als er POST data wordt gevraagd op de pagina.');
define('COM_SH404SEF_TT_REPLACEMENTS', 'Karakters die niet zijn toegestaan in de URL, zoals niet-Latijn of accenten, kunnen vervangen worden volgens deze vervangings tabel.<br />Formaat is xxx | yyy voor elke vervangings regel. xxx is het karakter dat vervangen moet worden en yyy is het nieuwe karakter. <br />Er kunnen vele van deze regels worden gemaakt, elk gescheiden door een komma (,). Tussen het oude en het nieuwe karakter dient u een | teken te plaatsen. <br />Let op dat xxx en yyy ook kunnen staan voor meerdere karakters, zoals in Å’|oe ');
define('COM_SH404SEF_TT_SHOP_NAME', 'Wanneer u de bovenstaande parameter op Ja heeft ingesteld, kunt u de in te voegen tekst overschrijven. Deze tekst is niet variabel en zal bijvoorbeeld niet vertaald worden.');
define('COM_SH404SEF_TT_TRANSLATE_URL', 'Indien geactiveerd, en de site is meertalig, zullen SEF URL elementen vertaald worden naar de taal van de bezoeker, via Joomfish bepaald. Als deze gedeactiveerd is, zal de URL altijd in de standaard taal van de site zijn. Deze optie wordt niet gebruikt bij sites die niet meertalig zijn.');
define('COM_SH404SEF_TT_USE_URL_CACHE', 'Indien geactiveerd, zal de SEF URL opgeslagen worden in een innerlijke cache, wat de pagina laadtijd aanzienlijk verminderd. Dit gebruikt wel geheugen!');
define('COM_SH404SEF_TT_VM_ADDITIONAL_TEXT', 'Als u deze instelt op Ja, zal er een tekst toegevoegd worden om te zoeken in verschillende categorie&euml;n. Bijvoorbeeld : ..../categorie-A/Bekijk-alle-producten.html VS ..../categorie-A/ .');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORIES', 'Als u deze instelt op Geen, zal geen enkele categorienaam worden toegevoegd aan de URL die leidt tot de product weergave, zoals in : <br /> mijnsite.nl/joomla-cms.html<br />Als u deze instelt op Alleen laatste, zal de naam van de categorie in welke het product thuishoort toegevoegd worden in de SEF URL, zoals in : <br /> mijnsite.nl/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORY_ID', 'Als u deze instelt op Ja, zal de categorie ID worden toegevoegd aan de URL die tot het product leidt, zoals in : <br /> mijnsite.nl/1-software/4-cms/1-joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_FLYPAGE', 'Als u deze instelt op Ja, zal de flypage naam toegevoegd worden aan de URL die tot de product details leidt. Deze kan voor de rest gedeactiveerd worden als u alleen een flypage gebruikt.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_ID', 'Als u deze instelt op Ja, zal de bedrijfs ID worden toegevoegd aan het bedrijf in de SEF URL<br />Bijvoorbeeld : mijnsite.nl/6-fabrikant/3-mijn-mooiste-product.html.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_NAME', 'Als u deze instelt op Ja, zal het bedrijf, als deze er is, worden toegevoegd aan de SEF URL die leidt tot een product<br />Bijvoorbeeld : mijnsite.nl/fabrikant/product-naam.html');
define('COM_SH404SEF_TT_VM_INSERT_SHOP_NAME', 'Als u deze instelt op Ja, zal de naam van de winkel altijd worden toegevoegd aan de SEF URL.');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU', 'Als u deze instelt op Ja, zal de product SKU, de product code die u voor elke product toevoegd, gebruikt worden in plaats van de volledige naam.');
define('COM_SH404SEF_TT_SHOW_CAT','Stel in op Ja om de categorienaam toe te voegen aan de URL');
define('COM_SH404SEF_TT_SHOW_SECT','Stel in op Ja om de sectienaam toe te voegen aan de URL');
define('COM_SH404SEF_TT_STRIP_CHAR','Karakters die uit de URL worden verwijderd, gescheiden door |');
define('COM_SH404SEF_TT_SUFFIX','Extensies gebruikt voor \'bestanden\'. Laat leeg om uit te schakelen. Een algemene invulling is \'html\'.');
define('COM_SH404SEF_TT_USE_ALIAS','Stel in op Ja om de titel_alias in plaats van de titel in de URL');
define('COM_SH404SEF_UNWRITEABLE',' <b><font color="red">Onschrijfbaar</font></b>');
define('COM_SH404SEF_UPLOAD_OK','Bestand is succesvol ge&uuml;pload');
define('COM_SH404SEF_URL','URL');
define('COM_SH404SEF_URLEXIST','Deze URL bestaat reeds in de database!');
define('COM_SH404SEF_USE_ALIAS','Gebruik titel alias');
define('COM_SH404SEF_USE_DEFAULT','(Gebruik standaard)');
define('COM_SH404SEF_USING_DEFAULT',' <b><font color="red">Gebruik standaard waarden</font></b>');
define('COM_SH404SEF_VIEW404','Bekijk/Bewerk<br/>404 Logs');
define('COM_SH404SEF_VIEW404DESC','Bekijk/Bewerk 404 Logs');
define('COM_SH404SEF_VIEWCUSTOM','Bekijk/Bewerk<br/>Aangepaste doorverwijzingen');
define('COM_SH404SEF_VIEWCUSTOMDESC','Bekijk/Bewerk Aangepaste doorverwijzingen');
define('COM_SH404SEF_VIEWMODE','WeergaveModus:');
define('COM_SH404SEF_VIEWURL','Bekijk/Bewerk<br/>SEF Url\'s');
define('COM_SH404SEF_VIEWURLDESC','Bekijk/Bewerk SEF Url\'s');
define('COM_SH404SEF_WARNDELETE','LET OP!!!  U staat op het punt om te verwijderen ');
define('COM_SH404SEF_WRITE_ERROR','Foutmelding schrijfbaarheid van instellingen');
define('COM_SH404SEF_WRITE_FAILED','Niet in staat om het ge&uuml;ploade bestand naar de media map te plaatsen');
define('COM_SH404SEF_WRITEABLE',' <b><font color="green">Schrijfbaar</font></b>');

// V 1.2.4.s
define('COM_SH404SEF_DOCMAN_TITLE', 'Docman instellingen');
define('COM_SH404SEF_DOCMAN_INSERT_NAME', 'Voeg Docman naam toe');
define('COM_SH404SEF_TT_DOCMAN_INSERT_NAME', 'Als u deze instelt op <strong>Ja</strong>, zal de menu element titel die naar de Docman hoofdpagina leidt worden toegevoegd aan alle Docman SEF URL\'s');
define('COM_SH404SEF_DOCMAN_NAME', 'Standaard Docman naam');
define('COM_SH404SEF_TT_DOCMAN_NAME', 'Wanneer de vorige parameter is ingesteld op Ja, kunt u de tekst die wordt toegevoegd aan de SEF URL hier wijzigen. Let op dat deze tekst hetzelfde blijft en bijvoorbeeld ook niet wordt vertaald.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_ID', 'Voeg document ID toe');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID', 'Als u deze instelt op <strong>Ja</strong>, zal de document ID worden toegevoegd aan de URL, wat nodig is in het geval dat documenten dezelfde namen hebben.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME', 'Vul document naam in');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME', 'Als u deze instelt op <strong>Ja</strong>, zal deze naam worden toegevoegd aan alle Docman SEF URL\'s');
define('COM_SH404SEF_MYBLOG_TITLE', 'MyBlog instellingen');
define('COM_SH404SEF_MYBLOG_INSERT_NAME', 'Voeg MyBlog naam toe');
define('COM_SH404SEF_TT_MYBLOG_INSERT_NAME', 'Als u deze instelt op <strong>Ja</strong>, zal de menu element titel welke leidt naar de hoofdpagina van MyBlog, worden toegevoegd aan alle MyBlog SEF URL\'s');
define('COM_SH404SEF_MYBLOG_NAME', 'Standaard Myblog naam');
define('COM_SH404SEF_TT_MYBLOG_NAME', 'Wanneer de vorige parameter is ingesteld op Ja, kunt u de tekst die wordt toegevoegd aan de SEF URL hier wijzigen. Let op dat deze tekst hetzelfde blijft en bijvoorbeeld ook niet wordt vertaald.');
define('COM_SH404SEF_MYBLOG_INSERT_POST_ID', 'Voeg bericht ID toe');
define('COM_SH404SEF_TT_MYBLOG_INSERT_POST_ID', 'Als u deze instelt op <strong>Ja</strong>, zal het bericht ID worden toegevoegd aan de URL, wat nodig is in het geval dat berichten dezelfde namen hebben.');
define('COM_SH404SEF_MYBLOG_INSERT_TAG_ID', 'Voeg tag id toe');
define('COM_SH404SEF_TT_MYBLOG_INSERT_TAG_ID', 'Als u deze instelt op <strong>Ja</strong>, zal de interne tag ID worden toegevoegd aan de tag naam, wat nodig is voor het geval dat er verwarring kan ontstaan met een andere categorienaam.');
define('COM_SH404SEF_MYBLOG_INSERT_BLOGGER_ID', 'Voeg blogger ID toe');
define('COM_SH404SEF_TT_MYBLOG_INSERT_BLOGGER_ID', 'Als u deze instelt op <strong>Ja</strong>, zal de interne blogger ID worden toegevoegd aan de bloggernaam, wat nodig is voor het geval dat verschillende bloggers dezelfde naam hebben.');
define('COM_SH404SEF_RW_MODE_NORMAL', 'met .htaccess (mod_rewrite)');
define('COM_SH404SEF_RW_MODE_INDEXPHP', 'zonder .htaccess (index.php)');
define('COM_SH404SEF_RW_MODE_INDEXPHP2', 'met .htaccess (index.php?)');
define('COM_SH404SEF_SELECT_REWRITE_MODE', 'Herschrijf modus');
define('COM_SH404SEF_TT_SELECT_REWRITE_MODE', 'Selecteer een herschrijf modus voor sh404SEF.<br /><strong>met .htaccess (mod_rewrite)</strong><br />Standaard modus : U dient een .htaccess bestand te hebben, welke goed is ingesteld en past bij de instellingen van de server.<br /><strong>zonder .htaccess (index.php)</strong><br /><strong>EXPERIMENTEEL :</strong>U heeft geen .htaccess bestand nodig. Deze modus gebruikt de PahtInfo functie van Apache servers. Url\'s zullen beginnen met /index.php/. Het is niet onmogelijk dat IIS servers deze URL\'s accepteren.<br /><strong>zonder .htaccess (index.php?)</strong><strong>EXPERIMENTEEL :</strong>Deze modus is gelijk aan de vorige modus, behalve dat hier /index.php?/ wordt gebruikt in plaats van /index.ph/.<br />');
define('COM_SH404SEF_RECORD_DUPLICATES', 'Record gekopieerde URL');
define('COM_SH404SEF_TT_RECORD_DUPLICATES', 'Als deze is ingesteld op<strong>Ja</strong>, zal sh404SEF alle niet SEF URL\'s onthouden die dezelfde SEF URL hebben. Dit betekent dat u kunt kiezen naar welke uw voorkeur uitgaat, gebruikmakend van het Kopieer Beheer.');
define('COM_SH404SEF_META_TITLE', 'Titel tag');
define('COM_SH404SEF_TT_META_TITLE', 'Vul de tekst in die toegevoegd dient te worden aan de <strong>META Titel</strong> tag voor de geselecteerde URL.');
define('COM_SH404SEF_META_DESC', 'Beschrijvings tag');
define('COM_SH404SEF_TT_META_DESC', 'Vul de tekst in die toegevoegd dient te worden aan de <strong>META Beschrijving</strong> tag voor de gelecteerde URL.');
define('COM_SH404SEF_META_KEYWORDS', 'Sleutelwoorden tag');
define('COM_SH404SEF_TT_META_KEYWORDS', 'Vul de tekst in die toegevoegd dient te worden aan de <strong>META Sleutelwoorden</strong> tag voor de geselecteerde URL. Alle woorden of groepen van woorden dienen gescheiden te worden met een komma.');
define('COM_SH404SEF_META_ROBOTS', 'Robots tag');
define('COM_SH404SEF_TT_META_ROBOTS', 'Vul de tekst in die toegevoegd dient te worden aan de <strong>META Robots</strong> tag voor de geselecteerde URL. Deze tag vertelt de zoekmachines of deze links dienen te volgen op deze pagina, en wat te doen met de inhoud van deze pagina. Algemene waardes :<br /><strong>INDEX,FOLLOW</strong> : index is de actuele pagina inhoud, en volgt alle links die deze vindt op de pagina<br /><strong>INDEX,NO FOLLOW</strong> : de inhoud van de actuele pagina mag worden ge&iuml;ndexeerd, maar robots mogen de links op deze pagina niet volgen.<br /><strong>NO INDEX, NO FOLLOW</strong> : de actuele pagina mag niet ge&iuml;ndexeerd worden, en de links op deze pagina mogen ook niet gevolgd worden.<br />');
define('COM_SH404SEF_META_LANG', 'Taal tag');
define('COM_SH404SEF_TT_META_LANG', 'Vul de tekst in die wordt toegevoegd aan de <strong>META http-equiv= Inhoud-Taal </strong> tag voor de geselecteerde URL. ');
define('COM_SH404SEF_CONF_TAB_META', 'META/SEO');
define('COM_SH404SEF_CONF_META_DOC', 'Voor sh404SEF zijn verschillende plugins beschikbaar die <strong>automatisch</strong> META tags maken voor sommige componenten. Probeer deze niet handmatig te maken, tenzij u de automatisch gemaakte tags niet vindt passen !!<br />');
define('COM_SH404SEF_REMOVE_JOOMLA_GENERATOR', 'Verwijder Joomla Generator tag');
define('COM_SH404SEF_TT_REMOVE_JOOMLA_GENERATOR', 'Als u deze instelt op <strong>Ja</strong>, zal de generator = Joomla META tag verwijderd worden.');
define('COM_SH404SEF_PUT_H1_TAG', 'Voeg h1 tags toe');
define('COM_SH404SEF_TT_PUT_H1_TAG', 'Als u deze instelt op <strong>Ja</strong>, worden normale titels van de inhoud geplaatst tussen h1 tags. Deze titels worden normaal gesproken door Joomla geplaatst in de CSS class <strong>contentheading</strong>.');
define('COM_SH404SEF_META_MANAGEMENT_ACTIVATED', 'Activeer META beheer');
define('COM_SH404SEF_TT_META_MANAGEMENT_ACTIVATED', 'Als u deze instelt op <strong>Ja</strong>, kunnen titel, omschrijving, sleutelwoorden, robots en taal META tags beheerd worden door sh404SEF. Anders zullen de originele waardes door Joomla en/of andere componenten geproduceerd onaangetast blijven.  ');
define('COM_SH404SEF_TITLE_META_MANAGEMENT', 'META tags beheer');
define('COM_SH404SEF_META_EDIT', 'Bewerk tags');
define('COM_SH404SEF_META_ADD', 'Voeg tags toe');
define('COM_SH404SEF_META_TAGS', 'META tags');
define('COM_SH404SEF_META_TAGS_DESC', 'Maak/bewerk META tags');
define('COM_SH404SEF_PURGE_META_DESC', 'Verwijder META tags');
define('COM_SH404SEF_PURGE_META', 'Verwijder META');
define('COM_SH404SEF_IMPORT_EXPORT_META', 'Importeer/exporteer META');
define('COM_SH404SEF_NEW_META', 'Nieuwe META tag');
define('COM_SH404SEF_NEWURL_META', 'Geen-SEF URL');
define('COM_SH404SEF_TT_NEWURL_META', 'Vul de geen-SEF URL in voor welke u META tags wilt instellen. LET OP: Deze moet beginnen met <strong>index.php</strong>!');
define('COM_SH404SEF_BAD_META', 'Kijk alsublieft uw data na: sommige input is niet geldig.');
define('COM_SH404SEF_META_TITLE_PURGE', 'Wis META tags');
define('COM_SH404SEF_META_SUCCESS_PURGE', 'META tags verwijderd');
define('COM_SH404SEF_IMPORT_META', 'Importeer META tags');
define('COM_SH404SEF_EXPORT_META', 'Exporteer META tags');
define('COM_SH404SEF_IMPORT_META_OK', 'META tags zijn succesvol ge&iuml;mporteerd');
define('COM_SH404SEF_SELECT_ONE_URL', 'U dient een URL (niet meer dan 1) te selecteren.');
define('COM_SH404SEF_MANAGE_DUPLICATES', 'URL beheer voor : ');
define('COM_SH404SEF_MANAGE_DUPLICATES_RANK', 'Waardering');
define('COM_SH404SEF_MANAGE_DUPLICATES_BUTTON', 'Kopieer URL');
define('COM_SH404SEF_MANAGE_MAKE_MAIN_URL', 'Hoofd URL');
define('COM_SH404SEF_BAD_DUPLICATES_DATA', 'Foutmelding : ongeldige URL data');
define('COM_SH404SEF_BAD_DUPLICATES_NOTHING_TO_DO', 'Deze URL is hetzelfde als de hoofd URL');
define('COM_SH404SEF_MAKE_MAIN_URL_OK', 'Handeling succesvol uitgevoerd');
define('COM_SH404SEF_MAKE_MAIN_URL_ERROR', 'Er is een fout opgetreden, de handeling mislukte');
define('COM_SH404SEF_CONTENT_TITLE', 'Inhoud instellingen');
define('COM_SH404SEF_INSERT_CONTENT_TABLE_NAME', 'Vul inhoud tabel naam in');
define('COM_SH404SEF_TT_INSERT_CONTENT_TABLE_NAME', 'Als u deze optie instelt op <strong>Ja</strong>, zal de menu element titel voorafgaand aan een tabel met artikelen (categorie of sectie) worden toegevoegd aan de SEF URL. Dit staat tabel weergave van blog weergaven toe.');
define('COM_SH404SEF_CONTENT_TABLE_NAME', 'Standaard tabelnaam weergave');
define('COM_SH404SEF_TT_CONTENT_TABLE_NAME', 'Als de vorige parameter is ingesteld op \'Ja\', kunt u de ingevoegde tekst overschrijven met deze tekst. Let op dat deze tekst niet variabel is en bijvoorbeeld niet vertaald zal worden.');
define('COM_SH404SEF_REDIRECT_WWW', '301 doorverwijzing www/geen-www');
define('COM_SH404SEF_TT_REDIRECT_WWW', 'Als u deze instelt op Ja, zal sh404SEF een doorverwijzing uitvoeren met een 301 foutmelding. Als de site toegankelijk is onder www, zal het doorverwezen worden als er geen www wordt ingevuld, en omgekeert. Dit zal problemen met uw Apache server configuratie en Joomla WYSIWYG editors voorkomen.');
define('COM_SH404SEF_TT_INSERT_PRODUCT_NAME', 'Als u deze instelt op Ja, zal de productnaam worden toegevoegd aan de URL');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU_124S', 'Voeg productcode toe');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU_124S', 'Als u deze instelt op Ja, zal de product code (SKU genoemd in Virtuemart) worden toegevoegd aan de SEF URL.');

// V 1.2.4.t
define('COM_SH404SEF_DOCMAN_INSERT_CAT_ID', 'Voeg categorie id toe');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID', 'Als u deze instelt op <strong>Ja</strong>, zal de categorie id worden toegevoegd aan de SEF URL, handig voor wanneer 2 verschillende categorie&euml;n dezelfde naam hebben.');
define('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES', 'Voeg categorienaam toe');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES', 'Als u deze instelt op <strong>Geen</strong>, zal er geen categorienaam worden toegevoegd aan de URL, zoals bij : <br /> mijnsite.nl/joomla-cms.html<br />Als u deze instelt op <strong>Alleen laatste</strong>, zal de categorienaam worden toegevoegd aan de SEF URL, zoals in : <br /> mijnsite.nl/joomla/joomla-cms.html<br />Als u deze instelt op <strong>Alle geneste categorie&euml;n</strong>, zullen de namen van alle categorie&euml;n worden toegevoegd, zoals in : <br /> mijnsite.nl/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_FORCED_HOMEPAGE', 'Homepagina URL');
define('COM_SH404SEF_TT_FORCED_HOMEPAGE', 'U kunt hier een gedwongen homepagina URL invullen. Dit is handig wanneer u een flash pagina, vaak een index.html bestand, wilt weergeven wanneer u naar www.mijnsite.nl gaat. Als u dit wilt, typ de volgende URL hier: www.mijnsite.nl/index.php (zonder slash /), zoadat de Joomla site wordt weergegeven wanneer u klikt op home in het hoofdmenu.');
define('COM_SH404SEF_INSERT_CONTENT_BLOG_NAME', 'Voeg blognaam toe');
define('COM_SH404SEF_TT_INSERT_CONTENT_BLOG_NAME', 'Als u deze instelt op Ja, zal de menu element titel dat leidt naar een blog met artikelen (categorie of sectie) worden toegevoegd aan de SEF URL. Dit staat afgezonderde tabel weergaven van blog weergaven toe.');
define('COM_SH404SEF_CONTENT_BLOG_NAME', 'Standaard blogweergave naam');
define('COM_SH404SEF_TT_CONTENT_BLOG_NAME', 'Wanneer de vorige parameter staat ingestelt op Ja, kunt u deze toegevoegde tekst uit de SEF URL hier overschrijven. Deze tekst is niet variabel en zal bijvoorbeeld niet vertaald worden.');
define('COM_SH404SEF_MTREE_TITLE', 'Mosets Tree Instellingen');
define('COM_SH404SEF_MTREE_INSERT_NAME', 'Voeg MTree naam toe');
define('COM_SH404SEF_TT_MTREE_INSERT_NAME', 'Als u deze instelt op Ja, zal de menu element titel dat leidt naar de Mosets Tree worden toegevoegd aan de SEF URL.');
define('COM_SH404SEF_MTREE_NAME', 'Standaard MTree naam');
define('COM_SH404SEF_MTREE_INSERT_LISTING_ID', 'Voeg lijst ID toe');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_ID', 'Als u deze instelt op Ja, zal een lijst ID worden toegevoegd aan de naam, voor het geval dat twee lijsten dezelfde naam hebben.');
define('COM_SH404SEF_MTREE_PREPEND_LISTING_ID', 'Voeg ID toe aan naam');
define('COM_SH404SEF_TT_MTREE_PREPEND_LISTING_ID', 'Als u deze instelt op Ja, wanneer u de vorige optie ook op Ja heeft ingestelt, zal de ID worden toegevoegd aan het begin, aan de lijstnaam. Als u deze instelt op Nee, zal deze worden toegevoegd aan het einde van de SEF URL.');
define('COM_SH404SEF_MTREE_INSERT_LISTING_NAME', 'Voeg lijstnaam toe');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_NAME', 'Als u deze instelt op Ja, zal de lijstnaam worden toegevoegd aan de URL die leidt tot een actie van deze lijst');

define('COM_SH404SEF_IJOOMLA_NEWSP_TITLE', 'Nieuws Portaal Instellingen');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_NAME', 'Voeg Nieuws Portaal naam toe');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_NAME', 'Als u deze instelt op Ja, zal de menu element titel dat leidt naar iJoomla Nieuws Portaal worden toegevoegd aan de SEF URL.');
define('COM_SH404SEF_IJOOMLA_NEWSP_NAME', 'Standaard Nieuws Portaal naam');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_CAT_ID', 'Voeg categorie ID toe');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_CAT_ID', 'Als u deze instelt op Ja, zal de categorie ID worden toegevoegd aan de naam, voor het geval dat deze dezelfde naam hebben.');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'Voeg sectie ID toe');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'Als u deze instelt op Ja, zal de sectie ID worden toegevoegd aan de naam, voor het geval dat deze dezelfde naam hebben.');
define('COM_SH404SEF_REMO_TITLE', 'Remository instellingen');
define('COM_SH404SEF_REMO_INSERT_NAME', 'Voeg Remository naam toe');
define('COM_SH404SEF_TT_REMO_INSERT_NAME', 'Als u deze instelt op Ja, zal de menu element titel die leidt tot Remository worden toegevoegd aan de SEF URL.');
define('COM_SH404SEF_REMO_NAME', 'Standaard Remository naam');
define('COM_SH404SEF_CB_SHORT_USER_URL', 'Verkorte URL naar gebruikersprofiel');
define('COM_SH404SEF_TT_CB_SHORT_USER_URL', 'Als u deze instelt op Ja, zal een gebruiker de mogelijkheid krijgen om zijn/haar profiel te benaderen met een verkorte URL, gelijk aan www.mijnsite.nl/gebruikersnaam. Zorg ervoor dat dit geen conflicten oplevert met bestaande URLs, voordat u deze optie activeert.');
define('COM_SH404SEF_NEW_HOME_META', 'Homepagina META');
define('COM_SH404SEF_CONF_ERASE_HOME_META', 'Weet u zeker dat u de homepage titel en META tags wilt verwijderen?');
define('COM_SH404SEF_UPGRADE_TITLE', 'Upgrade instellingen');
define('COM_SH404SEF_UPGRADE_KEEP_URL', 'Behoud automatische URL');
define('COM_SH404SEF_TT_UPGRADE_KEEP_URL', 'Als u deze instelt op Ja, zal de SEF URL die automatisch door sh404SEF wordt gemaakt worden opgeslagen en behouden wanneer u dit component de&iuml;nstalleert. Zo kan sh404SEF deze weer terugvinden wanneer u een nieuwere versie installeert.');
define('COM_SH404SEF_UPGRADE_KEEP_CUSTOM', 'Behoud aangepaste URLs');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CUSTOM', 'Als u deze instelt op Ja, zal de aangepaste SEF URL die u heeft ingevoerd worden bewaard en behouden wanneer u dit component de&iuml;nstalleert. Zo kan sh404SEF deze weer terugvinden wanneer u een nieuwere versie installeert.');
define('COM_SH404SEF_UPGRADE_KEEP_META', 'Behoud Titel en META');
define('COM_SH404SEF_TT_UPGRADE_KEEP_META', 'Als u deze instelt op Ja, zal de aangepaste titel en META tags worden bewaard en behouden wanneer u dit component de&iuml;nstalleert. Zo kan sh404SEF deze weer terugvinden wanneer u een nieuwere versie installeert.');
define('COM_SH404SEF_UPGRADE_KEEP_MODULES', 'Behoud module parameters');
define('COM_SH404SEF_TT_UPGRADE_KEEP_MODULES', 'Als u deze instelt op <strong>Ja</strong>, worden parameters zoals positie, volgorde, titels, etc opgeslagen en behouden worden wanneer u dit component de&iuml;nstalleert. Zo kan sh404SEF deze weer terugvinden wanneer u een nieuwere versie installeert.');
define('COM_SH404SEF_IMPORT_OPEN_SEF','Importeer doorverwijzingen van Open SEF');
define('COM_SH404SEF_IMPORT_ALL','Importeer doorverwijzingen');
define('COM_SH404SEF_EXPORT_ALL','Exporteer doorverwijzingen');
define('COM_SH404SEF_IMPORT_EXPORT_CUSTOM','Importeer/Exporteer aangepaste doorverwijzingen');
define('COM_SH404SEF_DUPLICATE_NOT_ALLOWED', 'Deze URL bestaat reeds, terwijl u deze niet gekopieerd heeft');
define('COM_SH404SEF_INSERT_CONTENT_MULTIPAGES_TITLE', 'Activeer slimme titels voor artikelen met meerdere pagina\'s');
define('COM_SH404SEF_TT_INSERT_CONTENT_MULTIPAGES_TITLE', 'Als u deze instelt op Ja, zullen de artikelen met meerdere pagina\'s een andere URL krijgen. Sh404SEF zal de pagina titels toevoegen. Deze kunt u invoeren met behulp van het mospagebreak commando : {mospagebreak title=Titel_Volgende_Pagina & heading=Titel_Vorige_Pagina}, in plaats van het pagina nummer. Bijvoorbeeld, een SEF URL gelijk aan www.mijnsite.nl/gebruikers-documentatie/<strong>Pagina-2</strong>.html zal worden vervangen door www.mijnsite.nl/gebruikers-documentatie/<strong>Begin-met-sh404SEF</strong>.html.');

// v x
define('COM_SH404SEF_UPGRADE_KEEP_CONFIG', 'Bewaar instellingen');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CONFIG', 'Als u deze instelt op Ja, zullen alle parameters van de instellingen worden opgeslagen en bewaard wanneer u het component de&iuml;nstalleerd. Zo kunt u ze terug vinden wanneer u een nieuwe versie installeert, zonder verdere actie.');
define('COM_SH404SEF_CONF_TAB_SECURITY', 'Veiligheid');
define('COM_SH404SEF_SECURITY_TITLE', 'Veiligheids instellingen');
define('COM_SH404SEF_HONEYPOT_TITLE', 'Project Honey Pot instellingen');
define('COM_SH404SEF_CONF_HONEYPOT_DOC', 'Project Honey Pot is een initiatief bedoelt om websites te beschermen tegen spam robots. Het maakt een database aan om de IP\'s van bezoekers na te kijken, tegen bekende robots. Voor het gebruik van deze database heeft u een (gratis) toegangssleutel nodig. U kunt deze krijgen <a href="http://www.projecthoneypot.org/httpbl_configure.php">van de project website</a><br />(U dient eerst een account aan te maken voordat u uw toegangssleutel kunt aanvragen - dit is ook gratis). Als u dit kunt, denk er eens over na om het project te helpen door `valkuilen` op uw webruimte te zetten, om zo te helpen met het identificeren van spam robots.');
define('COM_SH404SEF_ACTIVATE_SECURITY', 'Activeer veiligheids functies');
define('COM_SH404SEF_TT_ACTIVATE_SECURITY', 'Als u deze instelt op Ja, zal sh404SEF een aantal basis checks uitvoeren bij de URL\'s van uw website, om het tegen vaak voorkomende aanvallen te beschermen.');
define('COM_SH404SEF_LOG_ATTACKS', 'Log aanvallen');
define('COM_SH404SEF_TT_LOG_ATTACKS', 'Als u deze instelt op Ja, zullen ge&iuml;dentificeerde aanvallen worden gelogd in een tekst bestand, inclusief het IP adres van de aanvaller en het gemaakte paginaverzoek.<br />Er is 1 log bestand per maand. Deze zijn te vinden in de <site root>/administrator/com_sh404sef/logs map. U kunt deze downloaden via FTP, of een Joomla extensie gebruiken zoals Joomla Explorer om ze te bekijken. Het zijn TAB gescheiden tekst bestanden, dus uw spreadsheet software zal ze gemakkelijk kunnen openen, aangezien dit de handigste manier is om ze te bekijken.');	            
define('COM_SH404SEF_CHECK_HONEY_POT', 'Gebruik Project Honey Pot');
define('COM_SH404SEF_TT_CHECK_HONEY_POT', 'Als u deze instelt op Ja, worden de IP\'s van uw bezoekers nagekeken met de Project Honey Pot database, gebruikmakend van hun HTTP:BL service. Dit is gratis, maar u dient wel een toegangssleutel te verkrijgen van hun website.');
define('COM_SH404SEF_HONEYPOT_KEY', 'Project Honey Pot toegangssleutel');
define('COM_SH404SEF_TT_HONEYPOT_KEY', 'Als de optie Gebruik Project Honey Pot is geactiveerd, dient u een toegangssleutel te verkrijgen van P.H.P. Typ de ontvangen toegangssleutel hier. Het bevat 12 karakters.');	             
define('COM_SH404SEF_HONEYPOT_ENTRANCE_TEXT', 'Alternatieve post tekst');
define('COM_SH404SEF_TT_HONEYPOT_ENTRANCE_TEXT', 'Als een IP adres van een bezoeker door Project Honey Pot als verdacht wordt bevonden, zal de toegang worden geweigerd (403 code). <br />Als het een foute detectie is, zal de tekst die u hier invoert worden weergegeven aan de bezoeker, met een link waarop hij/zij dient te klikken om toegang te krijgen tot de site. Alleen een mens kan dit soort tekst lezen en begrijpen, en robots kunnen geen toegang krijgen tot deze link.<br />U kunt deze tekst naar eigen wensen aanpassen.' );	             
define('COM_SH404SEF_SMELLYPOT_TEXT', 'Robot valkuilen tekst');
define('COM_SH404SEF_TT_SMELLYPOT_TEXT', 'Als een spam robot ge&iuml;dentificeerd is door Project Honey Pot, en de toegang is geweigerd, zal een link worden toegevoegd onderaan het weigerings scherm, zodat Project Honey Pot kan bijhouden wat de robot doet. Er is ook een bericht toegevoegd om te voorkomen dat normale mensen op deze link klikken, in het geval dat zij verkeerd ge&iuml;dentificeerd waren.');
define('COM_SH404SEF_ONLY_NUM_VARS', 'Numerieke parameters');
define('COM_SH404SEF_TT_ONLY_NUM_VARS', 'Parameter namen die u in deze lijst zet zullen worden nagekeken zodat ze echt alleen numeriek zijn :  alleen getallen van 0 tot 9. Voeg 1 parameter toe per regel.');
define('COM_SH404SEF_ONLY_ALPHA_NUM_VARS', 'Alfa-numerieke parameters');
define('COM_SH404SEF_TT_ONLY_ALPHA_NUM_VARS', 'Parameter namen in deze lijst zullen worden nagekeken of deze alfa-numeriek zijn : getallen van 0 tot 9 en letters van a tot z. Voeg 1 parameter toe per regel.');
define('COM_SH404SEF_NO_PROTOCOL_VARS', 'Kijk hyperlinks na in parameters');
define('COM_SH404SEF_TT_NO_PROTOCOL_VARS', 'Parameter namen die u in deze lijst zet zullen worden nagekeken voor hyperlinks in de links, beginnend met http://, https://, ftp:// ');
define('COM_SH404SEF_IP_WHITE_LIST', 'IP witte lijst');
define('COM_SH404SEF_TT_IP_WHITE_LIST', 'Elke pagina die wordt bezocht door een IP adres uit deze lijst zal <stong>ge&auml;ccepteerd</strong> worden, er van uit gaand dat de URL de bovenstaande checks doorstaat. Voeg 1 IP adres toe per regel.<br />U kunt * gebruiken als asterix, zoals in : 192.168.0.*. Dit zorgt ervoor dat alle IP adressen van 192.168.0.0 tot 192.168.0.255 ge&auml;ccepteerd worden.');
define('COM_SH404SEF_IP_BLACK_LIST', 'IP zwarte lijst');
define('COM_SH404SEF_TT_IP_BLACK_LIST', 'Elke pagina die wordt bezocht door een IP adres van deze lijst zal de toegang worden <strong>geweigerd</strong>, er van uit gaand dat de URL de bovenstaande checks doorstaat. Voeg 1 IP adres toe per regel.<br />U kunt * gebruiken als asterix, zoals in : 192.168.0.*. Dit zorgt ervoor dat alle IP adressen van 192.168.0.0 tot 192.168.0.255 geweigerd worden.');
define('COM_SH404SEF_UAGENT_WHITE_LIST', 'UserAgent witte lijst');
define('COM_SH404SEF_TT_UAGENT_WHITE_LIST', 'Elk verzoek gemaakt met een UserAgent string uit deze lijst zal worden <stong>ge&auml;ccepteerd</strong>, er van uit gaand dat de URL de bovenstaande checks doorstaat. Voeg 1 UserAgent String toe per regel.');
define('COM_SH404SEF_UAGENT_BLACK_LIST', 'UserAgent zwarte lijst');
define('COM_SH404SEF_TT_UAGENT_BLACK_LIST', 'Elk verzoek gemaakt met een UserAgent string uit deze lijst zal worden <stong>geweigerdd</strong>, er van uit gaand dat de URL de bovenstaande checks doorstaat. Voeg 1 UserAgent String toe per regel.');
define('COM_SH404SEF_MONTHS_TO_KEEP_LOGS', 'Aantal maanden bewaren van veiligheidslog');
define('COM_SH404SEF_TT_MONTHS_TO_KEEP_LOGS', 'Als u het loggen van aanvallen heeft ge&auml;ctiveerd, kunt u hier instellen hoeveel maanden deze log bestanden bewaard blijven. Bijvoorbeeld, als u 1 invoert betekent dat, dat de actuele maand en de maand ervoor bewaard zal blijven. Eerdere log bestanden worden verwijderd.');
define('COM_SH404SEF_ANTIFLOOD_TITLE', 'Anti-flood instellingen');
define('COM_SH404SEF_ACTIVATE_ANTIFLOOD', 'Activeer anti-flood');
define('COM_SH404SEF_TT_ACTIVATE_ANTIFLOOD', 'Als u deze ingestelt op Ja, zal sh404SEF nakijken dat elk IP adres niet te veel pagina verzoeken voor uw site doet. Door teveel verzoeken, vlak na elkaar, kan een piraat uw site onbruikbaar maken door deze te overbelasten.');
define('COM_SH404SEF_ANTIFLOOD_ONLY_ON_POST', 'Check alleen als het data bevat (formulieren)');
define('COM_SH404SEF_TT_ANTIFLOOD_ONLY_ON_POST', 'Als u deze instelt op Ja, zal deze controle alleen worden uitgevoerd als er om data wordt gevraagd bij het pagina verzoek. Dit is vaak het geval bij formulieren, dus kunt u de anti-flood controle alleen instellen op formulieren pagina\'s om uw site te beschermen tegen vaak voorkomende spam robots.');
define('COM_SH404SEF_ANTIFLOOD_PERIOD', 'Anti-flood controle');
define('COM_SH404SEF_TT_ANTIFLOOD_PERIOD', 'Tijd (in seconden) waarover het aantal verzoeken van hetzelfde IP adres worden gecontroleerd.');
define('COM_SH404SEF_ANTIFLOOD_COUNT', 'Max aantal verzoeken');
define('COM_SH404SEF_TT_ANTIFLOOD_COUNT', 'Aantal verzoeken dat voor geblokkeerde pagina\'s voor het aanvallende IP adres zorgt. Bijvoorbeeld, als u 10 invult als tijdsperiode, en 4 als max aantal verzoeken, zal de pagina worden geblokkeert als er meer dan 4 verzoeken in 10 seconden van dat IP adres binnenkomen. Deze blokkering geldt natuurlijk alleen voor dit IP adres, en niet voor andere bezoekers.');
define('COM_SH404SEF_CONF_TAB_LANGUAGES', 'Talen');
define('COM_SH404SEF_DEFAULT', 'Standaard');
define('COM_SH404SEF_YES', 'Ja');
define('COM_SH404SEF_NO', 'Nee');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_PER_LANG', 'Als u deze instelt op Ja, zal de taalcode worden toegevoegd aan de URL voor <strong>deze taal</strong>. Als u deze instelt op Nee, zal de taalcode nooit worden toegevoegd. Als u deze instelt op Standaard, zal de taalcode worden toegevoegd voor alle talen, behalve voor de standaard taal van uw site.');
define('COM_SH404SEF_TT_TRANSLATE_URL_PER_LANG', 'Als u deze instelt op Ja, en uw site is meertalig, zal uw URL <strong>in deze taal</strong> zijn volgens de Joomfish instellingen. Als u deze instelt op Nee, zal de URL nooit vertaald worden. Als u deze instelt op Standaard, zullen ze ook vertaald worden. Dit heeft geen effect op sites met maar 1 taal.');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_GEN', 'Als u deze instelt op Ja, zal een taalcode worden toegevoegd aan de URL gemaakt door sh404SEF. U kunt het ook per taal instellen (zie hieronder).');
define('COM_SH404SEF_TT_TRANSLATE_URL_GEN', 'Als u deze instelt op Ja, en uw site is meertalig, zal de URL worden vertaald in de taal van uw bezoekers, volgens de Joomfish instelling. Anders zal de URL in de standaard taal blijven. U kunt het ook per taal instellen (zie hieronder).');
define('COM_SH404SEF_ADV_COMP_DEFAULT_STRING', 'Standaard naam');
define('COM_SH404SEF_TT_ADV_COMP_DEFAULT_STRING', 'Als u hier een tekst string invult, zal deze worden toegevoegd aan het begin van alle URL\'s van dat component. Normaal gesproken niet gebruikt, alleen hier met terugwaartse kracht voor oude URL\'s van andere SEF componenten.');
define('COM_SH404SEF_TT_NAME_BY_COMP', '. <br />U kunt hier een naam invoeren dat zal worden gebruikt in plaats van de menu element naam. Om dit te doen, dient u te gaan naar de <strong>Componenten</strong> tab. Let op dat deze tekst niet variabel zal zijn en bijvoorbeeld niet vertaald zal worden.');
define('COM_SH404SEF_STANDARD_ADMIN', 'Klik hier om naar de standaard weergave te gaan (met alleen hoofd parameters)');
define('COM_SH404SEF_ADVANCED_ADMIN', 'Klik hier om naar de geavanceerde weergave te gaan (met alle beschikbare parameters)');
define('COM_SH404SEF_MULTIPLE_H1_TO_H2', 'Verander meerdere h1 in h2');
define('COM_SH404SEF_TT_MULTIPLE_H1_TO_H2', 'Als u deze instelt op Ja, en er zijn verscheidene h1 tags op een pagina, zullen deze gewijzigd worden in h2 tags. <br />Als er maar 1 h1 tag op een pagina te vinden is, zal deze onaangetast blijven.');
define('COM_SH404SEF_INSERT_NOFOLLOW_PDF_PRINT', 'Voeg nofollow tag toe aan Print en PDF links');
define('COM_SH404SEF_TT_INSERT_NOFOLLOW_PDF_PRINT', 'Als u deze instelt op Ja, zullen rel=nofollow onderdelen worden toegevoegd aan alle PDF en Print links gemaakt door Joomla. Dit zal het aantal duplicaten van inhoud verkleinen in zoekmachines.');
define('COM_SH404SEF_INSERT_READMORE_PAGE_TITLE', 'Voeg titel toe aan Lees meer... links');
define('COM_SH404SEF_TT_INSERT_READMORE_PAGE_TITLE', 'Als u deze instelt op Ja en een Lees meer.. link wordt weergegeven op de pagina, zal de titel van de inhoud worden toegevoegd aan de link, voor verbetering in zoekmachines.');
define('COM_SH404SEF_VM_USE_ITEMS_PER_PAGE', 'Gebruik drop-down lijst voor artikelen per pagina');
define('COM_SH404SEF_TT_VM_USE_ITEMS_PER_PAGE', 'Als u deze instelt op <strong>Ja</strong>, zullen URL\'s worden aangepast om drop-down lijsten toe te staan. Hiermee kunnen gebruikers het aantal artikelen per pagina selecteren. Als u geen drop-down lijsten gebruikt, EN uw URL\'s zijn reeds ge&iuml;ndexeerd door zoekmachines, kunt u deze instellen op NEE om de bestaande URL\'s te behouden. ');
define('COM_SH404SEF_CHECK_POST_DATA', 'Controleer ook de data van formulieren (verstuur)');
define('COM_SH404SEF_TT_CHECK_POST_DATA', 'Als u deze instelt op <strong>Ja</strong>, zal de data afkomstig van invulvelden worden gecontroleerd op config variabelen of soortgelijken. Dit kan voor onnodige verstoppingen zorgen, als u bijvoorbeeld een forum heeft waar de programmering van Joomla! wordt gediscussieerd. Wanneer zij exact dezelfde strings willen bespreken, zal sh404SEF denken dat het een mogelijke aanval is. In dat geval, als u last heeft van verboden toegang foutmeldingen, kunt u deze mogelijkheid beter uitschakelen.');
define('COM_SH404SEF_SEC_STATS_TITLE', 'Veiligheid statistieken');
define('COM_SH404SEF_SEC_STATS_UPDATE', 'Click here to update blocked attacks counters');
define('COM_SH404SEF_TOTAL_ATTACKS', 'Aantal aanvallen');
define('COM_SH404SEF_TOTAL_CONFIG_VARS', 'mosConfig var in URL');
define('COM_SH404SEF_TOTAL_BASE64', 'Base64 injectie');
define('COM_SH404SEF_TOTAL_SCRIPTS', 'Script injectie');
define('COM_SH404SEF_TOTAL_STANDARD_VARS', 'Illegale standaard vars');
define('COM_SH404SEF_TOTAL_IMG_TXT_CMD', 'remote file inbegrepen');
define('COM_SH404SEF_TOTAL_IP_DENIED', 'IP adres geweigerd');
define('COM_SH404SEF_TOTAL_USER_AGENT_DENIED', 'UserAgent geweigerd');
define('COM_SH404SEF_TOTAL_FLOODING', 'Te veel verzoeken (flooding)');
define('COM_SH404SEF_TOTAL_PHP', 'Afgewezen door Project Honey Pot');
define('COM_SH404SEF_TOTAL_PER_HOUR', ' /uur');
define('COM_SH404SEF_SEC_DEACTIVATED', 'Tweede functies niet in gebruik');
define('COM_SH404SEF_TOTAL_PHP_USER_CLICKED', 'PHP, maar de gebruiker klikte');
define('COM_SH404SEF_COM_SMF_TITLE', 'SMF bridge');
define('COM_SH404SEF_INSERT_SMF_NAME', 'Voeg forumnaam toe');
define('COM_SH404SEF_TT_INSERT_SMF_NAME', 'Als u deze instelt op <strong>Ja</strong>, zal de menu element titel welke leidt tot de hoofdpagina van het forum worden toegevoegd aan alle forum SEF URL\'s.');
define('COM_SH404SEF_SMF_ITEMS_PER_PAGE', 'Berichten per pagina');
define('COM_SH404SEF_TT_SMF_ITEMS_PER_PAGE', 'Aantal berichten weergegeven op een forumpagina');
define('COM_SH404SEF_INSERT_SMF_BOARD_ID', 'Voeg forum id toe');
define('COM_SH404SEF_TT_INSERT_SMF_BOARD_ID', COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME);
define('COM_SH404SEF_INSERT_SMF_TOPIC_ID', 'Voeg topic id toe');
define('COM_SH404SEF_TT_INSERT_SMF_TOPIC_ID', COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID);
define('COM_SH404SEF_INSERT_SMF_USER_NAME', 'Voeg gebruikersnaam toe');
define('COM_SH404SEF_TT_INSERT_SMF_USER_NAME', 'Als u deze instelt op <strong>Ja</strong>, zal de gebruikersnaam worden toegevoegd aan elke URL in plaats van zijn id. Dit verbruikt ruimte in de database, omdat een unieke URL wordt gemaakt voor elke gebruiker en elke functie (bekijk profiel, pm, enz).');
define('COM_SH404SEF_INSERT_SMF_USER_ID', 'Voeg gebruikers id toe');
define('COM_SH404SEF_TT_INSERT_SMF_USER_ID', 'Als u deze instelt op <strong>Ja</strong>, zal een gebruikersnaam altijd worden voorafgegaan met zijn id, om er zeker van te zijn dat deze uniek is.');
define('COM_SH404SEF_PREPEND_TO_PAGE_TITLE', 'Voeg toe voor de paginatitel'); 
define('COM_SH404SEF_TT_PREPEND_TO_PAGE_TITLE', 'De tekst die u hier invoert wordt voor alle paginatitel tags geplaatst.'); 
define('COM_SH404SEF_APPEND_TO_PAGE_TITLE', 'Voeg toe na de paginatitel'); 
define('COM_SH404SEF_TT_APPEND_TO_PAGE_TITLE', 'De tekst die u hier invoert wordt na alle paginatitel tags geplaatst.');
define('COM_SH404SEF_DEBUG_TO_LOG_FILE', 'Log debug info naar bestand');
define('COM_SH404SEF_TT_DEBUG_TO_LOG_FILE', 'Als u deze instelt op Ja, zal sh404SEF een tekstbestand bijhouden met vele interne informatie. Deze gegevens zullen ons helpen om de problemen die u wellicht tegenkomt tijdens het gebruiken van sh404SEF op te lossen. <br/>Waarschuwing: dit bestand kan snel behoorlijk groot worden. Deze functie zal ook uw site vertragen. Wees er dus zeker van dat u deze optie alleen aanzet wanneer dit noodzakelijk is. Om deze reden zal de functie automatisch gedeactiveerd worden een uur nadat deze is gestart. Zet de optie uit, en vervolgens weer aan, om deze opnieuw te activeren. Het log bestand is te vinden in  /administrator/components/com_sh404sef/logs/ ');

define('COM_SH404SEF_ALIAS_LIST', 'Alias lijst');
define('COM_SH404SEF_TT_ALIAS_LIST', 'Vul hier een lijst van aliassen in voor deze URL. Plaats 1 alias per regel, bijvoorbeeld: <br/>oude-url.html<br/>of<br/>mijn-andere-oude-url.php?var=12&test=15<br>sh404SEF zal zorgen voor een 301 verwijzing naar de actuele SEF URL indien 1 van deze aliassen wordt opgevraagd.');
define('COM_SH404SEF_HOME_ALIAS', 'Hoofdpagina alias');
define('COM_SH404SEF_TT_HOME_PAGE_ALIAS_LIST', 'Vul hier een lijst van aliassen in voor uw hoofdpagina. Plaats 1 alias per regel, bijvoorbeeld:<br/>oude-url.html<br/>of<br/>mijn-andere-oude-url.php?var=12&test=15<br>sh404SEF zal zorgen voor een 301 verwijzing naar uw hoofdpagina indien 1 van deze aliassen wordt opgevraagd.');

define('COM_SH404SEF_INSERT_OUTBOUND_LINKS_IMAGE', 'Voeg een symbool toe bij uitgaande links');
define('COM_SH404SEF_TT_INSERT_OUTBOUND_LINKS_IMAGE', 'Als u deze instelt op Ja, zal er een symbool worden geplaatst naast elke link welke verwijst naar een andere website, om identificatie van deze links te vergemakkelijken.');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_BLACK', 'Gebruik zwart symbool');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_WHITE', 'Gebruik wit symbool');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE', 'Symboolkleur voor uitgaande links');
define('COM_SH404SEF_TT_OUTBOUND_LINKS_IMAGE', 'Beide afbeeldingen hebben een transparante achtergrond. Selecteer de zwarte als uw site een lichte achtergrond heeft. Selecteer de witte als uw site een donkere achtergrond heeft. Deze afbeeldingen zijn  /administrator/components/com_sef/images/external-white.png en external-black.png. Deze zijn beiden 15x16 pixels groot.');
// V 1.3.3
define('COM_SH404SEF_DEFAULT_PARAMS_TITLE', 'Zeer geavanceerd');
define('COM_SH404SEF_DEFAULT_PARAMS_WARNING', 'WAARSCHUWING: Verander deze waarden alleen indien u weet wat u doet! Als u hier iets verkeerd invult, kunt u lastig herstelbare problemen cree&euml;n.');

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
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE', 'You should see here the root url of your web site. For instance:<br />http://www.example.com<br/>or<br/> http://example.com<br />(no trailing slash)<br />This is not a sh404sef setting, but rather a <b>Joomla</b> setting. It is stored in Joomla\'s own configuration.php file.<br />Joomla will normally auto-detect your web site root address. However, if the address displayed here is not correct, you should set it yourself manually. This is done by modifying the content of Joomla configuration.php (usually using FTP).<br/>Symptoms linked to a bad value are : template or images do not display, buttons does not operate, all styles (colors, fonts, etc) are missing');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE_MISSING', 'WARNING: $live_site missing from Joomla configuration.php file, or does not start with "http://" or "https://" !');
define('COM_SH404SEF_JCL_INSERT_EVENT_ID', 'Insert event Id');
define('COM_SH404SEF_TT_JCL_INSERT_EVENT_ID', 'If set to Yes, event internal id will be prepended to the event title in the urls, to make them unique');
define('COM_SH404SEF_JCL_INSERT_CATEGORY_ID', 'Insert category id');
define('COM_SH404SEF_TT_JCL_INSERT_CATEGORY_ID', 'If set to Yes, each event category id will be inserted in all urls to this event, in addition to the category name.');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_ID', 'Insert calendar id');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_ID', 'If set to Yes, the id of the calendar to which an event belongs will be prepended to the calendar name in all urls');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_NAME', 'Insert Calendar name');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_NAME', 'If set to Yes, the name of the calendar to which an event belongs will be prepended to the calendar name in all urls');
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
define('COM_SH404SEF_TT_FB_INSERT_USER_ID', 'If set to <strong>Yes</strong>, a user ID will be prepended  to her name, if the preceding setting is set to yes, just in case two users have the same username.');
define('COM_SH404SEF_PAGE_NOT_FOUND_ITEMID', 'Itemid to use for 404 page');
define('COM_SH404SEF_TT_PAGE_NOT_FOUND_ITEMID', 'The value entered here, if non zero, will be used to display the 404 page. Joomla will use the Itemid to decide which template and modules to display. Itemid represents a menu item, so you can look up Itemids in your menus list.');

//define('', '');
