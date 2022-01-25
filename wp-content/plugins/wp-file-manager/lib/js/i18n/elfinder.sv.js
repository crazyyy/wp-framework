/**
 * Svenska translation
 * @author Gabriel Satzger <gabriel.satzger@sbg.se>
 * @version 2020-09-02
 */
(function(root, factory) {
	if (typeof define === 'function' && define.amd) {
		define(['elfinder'], factory);
	} else if (typeof exports !== 'undefined') {
		module.exports = factory(require('elfinder'));
	} else {
		factory(root.elFinder);
	}
}(this, function(elFinder) {
	elFinder.prototype.i18.sv = {
		translator : 'Gabriel Satzger &lt;gabriel.satzger@sbg.se&gt;',
		language   : 'Svenska',
		direction  : 'ltr',
		dateFormat : 'Y-m-d H:i', // will show like: 2020-09-02 15:58
		fancyDateFormat : '$1 H:i', // will show like: Idag 15:58
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200902-155848
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'Fel',
			'errUnknown'           : 'Okänt error.',
			'errUnknownCmd'        : 'Okänt kommando.',
			'errJqui'              : 'Felaktig jQuery UI konfiguration. Komponenterna selectable, draggable och droppable måste vara inkluderade.',
			'errNode'              : 'elFinder kräver att DOM Elementen skapats.',
			'errURL'               : 'Felaktig elFinder konfiguration! URL parametern är inte satt.',
			'errAccess'            : 'Åtkomst nekad.',
			'errConnect'           : 'Kan inte ansluta till backend.',
			'errAbort'             : 'Anslutningen avbröts.',
			'errTimeout'           : 'Anslutningen löpte ut.',
			'errNotFound'          : 'Backend hittades inte.',
			'errResponse'          : 'Ogiltig backend svar.',
			'errConf'              : 'Ogiltig backend konfiguration.',
			'errJSON'              : 'PHP JSON modul är inte installerad.',
			'errNoVolumes'         : 'Läsbara volymer är inte tillgängliga.',
			'errCmdParams'         : 'Ogiltiga parametrar för kommandot "$1".',
			'errDataNotJSON'       : 'Datan är inte JSON.',
			'errDataEmpty'         : 'Datan är tom.',
			'errCmdReq'            : 'Backend begäran kräver kommandonamn.',
			'errOpen'              : 'Kan inte öppna "$1".',
			'errNotFolder'         : 'Objektet är inte en mapp.',
			'errNotFile'           : 'Objektet är inte en fil.',
			'errRead'              : 'Kan inte läsa "$1".',
			'errWrite'             : 'Kan inte skriva till "$1".',
			'errPerm'              : 'Tillstånd nekat.',
			'errLocked'            : '"$1" är låst och kan inte döpas om, flyttas eller tas bort.',
			'errExists'            : 'Fil med namn "$1" finns redan.',
			'errInvName'           : 'Ogiltigt filnamn.',
			'errInvDirname'        : 'Ogiltigt mappnamn.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Mappen hittades inte.',
			'errFileNotFound'      : 'Filen hittades inte.',
			'errTrgFolderNotFound' : 'Målmappen "$1" hittades inte.',
			'errPopup'             : 'Webbläsaren hindrade popup-fönstret att öppnas. Ändra i webbläsarens inställningar för att kunna öppna filen.',
			'errMkdir'             : 'Kan inte skapa mappen "$1".',
			'errMkfile'            : 'Kan inte skapa filen "$1".',
			'errRename'            : 'Kan inte döpa om "$1".',
			'errCopyFrom'          : 'Kopiera filer från volym "$1" tillåts inte.',
			'errCopyTo'            : 'Kopiera filer till volym "$1" tillåts inte.',
			'errMkOutLink'         : 'Det går inte att skapa en länk utanför volymroten.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Error vid uppladdningen.',  // old name - errUploadCommon
			'errUploadFile'        : 'Kan inte ladda upp "$1".', // old name - errUpload
			'errUploadNoFiles'     : 'Inga filer hittades för uppladdning.',
			'errUploadTotalSize'   : 'Data överskrider den högsta tillåtna storleken.', // old name - errMaxSize
			'errUploadFileSize'    : 'Filen överskrider den högsta tillåtna storleken.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Otillåten filtyp.',
			'errUploadTransfer'    : '"$1" överföringsfel.',
			'errUploadTemp'        : 'Det går inte att skapa tillfällig fil för överföring.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Objekt "$ 1" finns redan på den här platsen och kan inte ersättas med objekt med en annan typ.', // new
			'errReplace'           : 'Det gick inte att ersätta "$ 1".',
			'errSave'              : 'Kan inte spara "$1".',
			'errCopy'              : 'Kan inte kopiera "$1".',
			'errMove'              : 'Kan inte flytta "$1".',
			'errCopyInItself'      : 'Kan inte flytta "$1" till sig själv.',
			'errRm'                : 'Kan inte ta bort "$1".',
			'errTrash'             : 'Det går inte att komma i papperskorgen.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Det går inte att ta bort källfilerna.',
			'errExtract'           : 'Kan inte packa upp filen från "$1".',
			'errArchive'           : 'Kan inte skapa arkiv.',
			'errArcType'           : 'Arkivtypen stöds inte.',
			'errNoArchive'         : 'Filen är inte av typen arkiv.',
			'errCmdNoSupport'      : 'Backend stöder inte detta kommando.',
			'errReplByChild'       : 'Mappen “$1” kan inte ersättas av ett objekt den innehåller.',
			'errArcSymlinks'       : 'Av säkerhetsskäl nekas arkivet att packas upp då det innehåller symboliska länkar eller filer med ej tillåtna namn.', // edited 24.06.2012
			'errArcMaxSize'        : 'Arkivfiler överskrider största tillåtna storlek.',
			'errResize'            : 'Kan inte ändra storlek "$1".',
			'errResizeDegree'      : 'Ogiltig rotationsgrad.',  // added 7.3.2013
			'errResizeRotate'      : 'Det går inte att rotera bilden.',  // added 7.3.2013
			'errResizeSize'        : 'Ogiltig bildstorlek.',  // added 7.3.2013
			'errResizeNoChange'    : 'Bildstorleken har inte ändrats.',  // added 7.3.2013
			'errUsupportType'      : 'Filtypen stöds inte.',
			'errNotUTF8Content'    : 'Filen "$1" är inte i UTF-8 och kan inte redigeras.',  // added 9.11.2011
			'errNetMount'          : 'Kan inte koppla "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'Protokollet stöds inte.',     // added 17.04.2012
			'errNetMountFailed'    : 'Kopplingen misslyckades.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Host krävs.', // added 18.04.2012
			'errSessionExpires'    : 'Din session har gått ut på grund av inaktivitet.',
			'errCreatingTempDir'   : 'Det gick inte att skapa tillfällig katalog: "$ 1"',
			'errFtpDownloadFile'   : 'Det gick inte att ladda ner filen från FTP: "$ 1"',
			'errFtpUploadFile'     : 'Det gick inte att ladda upp filen till FTP: "$ 1"',
			'errFtpMkdir'          : 'Det gick inte att skapa fjärrkatalog på FTP: "$ 1"',
			'errArchiveExec'       : 'Fel vid arkivering av filer: "$ 1"',
			'errExtractExec'       : 'Fel vid extrahering av filer: "$ 1"',
			'errNetUnMount'        : 'Det går inte att avmontera.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Ej konverterbar till UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Prova den moderna webbläsaren, om du vill ladda upp mappen.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Tidsavbrott när du sökte efter "$ 1". Sökresultatet är delvis.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Återbehörighet krävs.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Max antal valbara föremål är $ 1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Det gick inte att återställa från papperskorgen. Det går inte att identifiera återställningsdestinationen.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Redaktören hittades inte för den här filtypen.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Fel uppstod på serversidan.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Det gick inte att tömma mappen "$ 1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Det finns $ 1 fler fel.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Skapa arkiv',
			'cmdback'      : 'Tillbaka',
			'cmdcopy'      : 'Kopiera',
			'cmdcut'       : 'Klipp ut',
			'cmddownload'  : 'Ladda ned',
			'cmdduplicate' : 'Duplicera',
			'cmdedit'      : 'Redigera fil',
			'cmdextract'   : 'Extrahera filer från arkiv',
			'cmdforward'   : 'Framåt',
			'cmdgetfile'   : 'Välj filer',
			'cmdhelp'      : 'Om denna programvara',
			'cmdhome'      : 'Hem',
			'cmdinfo'      : 'Visa info',
			'cmdmkdir'     : 'Ny mapp',
			'cmdmkdirin'   : 'I ny mapp', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Ny fil',
			'cmdopen'      : 'Öppna',
			'cmdpaste'     : 'Klistra in',
			'cmdquicklook' : 'Förhandsgranska',
			'cmdreload'    : 'Ladda om',
			'cmdrename'    : 'Döp om',
			'cmdrm'        : 'Radera',
			'cmdtrash'     : 'I papperskorgen', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Återställ', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Hitta filer',
			'cmdup'        : 'Gå till överordnade katalog',
			'cmdupload'    : 'Ladda upp filer',
			'cmdview'      : 'Visa',
			'cmdresize'    : 'Ändra bildstorlek',
			'cmdsort'      : 'Sortera',
			'cmdnetmount'  : 'Montera nätverksvolymen', // added 18.04.2012
			'cmdnetunmount': 'Demontera', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Till platser', // added 28.12.2014
			'cmdchmod'     : 'Ändra läge', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Öppna en mapp', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Återställ kolumnbredd', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Fullskärm', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Flytta', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Töm mappen', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Ångra', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'Göra om', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'Inställningar', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Välj alla', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Välj ingen', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Invertera val', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Öppna i nytt fönster', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Göm (preferens)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Stäng',
			'btnSave'   : 'Spara',
			'btnRm'     : 'Ta bort',
			'btnApply'  : 'Verkställ',
			'btnCancel' : 'Ångra',
			'btnNo'     : 'Nej',
			'btnYes'    : 'Ja',
			'btnMount'  : 'Montera',  // added 18.04.2012
			'btnApprove': 'Går $ 1 och godkänner', // from v2.1 added 26.04.2012
			'btnUnmount': 'Demontera', // from v2.1 added 30.04.2012
			'btnConv'   : 'Konvertera', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Här',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Volym',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Allt',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME-typ', // from v2.1 added 22.5.2015
			'btnFileName':'Filnamn',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Spara och stäng', // from v2.1 added 12.6.2015
			'btnBackup' : 'Säkerhetskopiering', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Döp om',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Byt namn (alla)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Föregående ($ 1 / $ 2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Nästa ($ 1 / $ 2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Spara som', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Öppnar mapp',
			'ntffile'     : 'Öppnar fil',
			'ntfreload'   : 'Laddar om mappinnehållet',
			'ntfmkdir'    : 'Skapar katalog',
			'ntfmkfile'   : 'Skapar fil',
			'ntfrm'       : 'Tar bort filer',
			'ntfcopy'     : 'Kopierar filer',
			'ntfmove'     : 'Flyttar filer',
			'ntfprepare'  : 'Förbereder att flytta filer',
			'ntfrename'   : 'Döper om filer',
			'ntfupload'   : 'Laddar upp filer',
			'ntfdownload' : 'Laddar ner filer',
			'ntfsave'     : 'Sparar filer',
			'ntfarchive'  : 'Skapar arkiv',
			'ntfextract'  : 'Extraherar filer från arkiv',
			'ntfsearch'   : 'Söker filer',
			'ntfresize'   : 'Ändra storlek på bilder',
			'ntfsmth'     : 'Gör någonting >_<',
			'ntfloadimg'  : 'Laddar bild',
			'ntfnetmount' : 'kopplar nätverksvolym', // added 18.04.2012
			'ntfnetunmount': 'Avmonterar nätverksvolymen', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Hämtar bilddimension', // added 20.05.2013
			'ntfreaddir'  : 'Läser mappinformation', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Få URL för länk', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Ändrar filläge', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Verifierar uppladdningsfilnamn', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Skapa en fil för nedladdning', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Få väginformation', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Bearbetar den uppladdade filen', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Kasta i papperskorgen', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Återställer från papperskorgen', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Kontrollerar målmapp', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Ångra tidigare åtgärd', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Gör om tidigare ångrat', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Kontrollerar innehållet', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'Skräp', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'okänt',
			'Today'       : 'Idag',
			'Yesterday'   : 'Igår',
			'msJan'       : 'Jan',
			'msFeb'       : 'Feb',
			'msMar'       : 'Mar',
			'msApr'       : 'Apr',
			'msMay'       : 'Maj',
			'msJun'       : 'Jun',
			'msJul'       : 'Jul',
			'msAug'       : 'Aug',
			'msSep'       : 'Sep',
			'msOct'       : 'Okt',
			'msNov'       : 'Nov',
			'msDec'       : 'Dec',
			'January'     : 'Januari',
			'February'    : 'Februari',
			'March'       : 'Mars',
			'April'       : 'April',
			'May'         : 'Maj',
			'June'        : 'Juni',
			'July'        : 'Juli',
			'August'      : 'Augusti',
			'September'   : 'September',
			'October'     : 'Oktober',
			'November'    : 'November',
			'December'    : 'December',
			'Sunday'      : 'Söndag',
			'Monday'      : 'Måndag',
			'Tuesday'     : 'Tisdag',
			'Wednesday'   : 'Onsdag',
			'Thursday'    : 'Torsdag',
			'Friday'      : 'Fredag',
			'Saturday'    : 'Lördag',
			'Sun'         : 'Sön',
			'Mon'         : 'Mån',
			'Tue'         : 'Tis',
			'Wed'         : 'Ons',
			'Thu'         : 'Tor',
			'Fri'         : 'Fre',
			'Sat'         : 'Lör',

			/******************************** sort variants ********************************/
			'sortname'          : 'efter namn',
			'sortkind'          : 'efter sort',
			'sortsize'          : 'efter storlek',
			'sortdate'          : 'efter datum',
			'sortFoldersFirst'  : 'Mappar först',
			'sortperm'          : 'med tillstånd', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'efter läge',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'av ägare',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'efter grupp',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Även Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'Ny mapp',   // added 10.11.2015
			'Archive'           : 'NewArchive',  // from v2.1 added 10.11.2015
			'untitled file'     : 'Ny fil. $ 1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$ 1: Fil',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Bekräftelse krävs',
			'confirmRm'       : 'Är du säker på att du vill ta bort filer? <br/> Detta kan inte ångras!',
			'confirmRepl'     : 'Ersätt den gamla filen med en ny?',
			'confirmRest'     : 'Byt ut befintligt objekt med objektet i papperskorgen?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Inte i UTF-8 <br/> Konvertera till UTF-8? <br/> Innehållet blir UTF-8 genom att spara efter konvertering.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Teckenkodning av den här filen kunde inte detekteras. Det måste tillfälligt konverteras till UTF-8 för redigering. <br/> Välj teckenkodning för den här filen.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Det har ändrats. <br/> Att förlora arbete om du inte sparar ändringarna.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Är du säker på att du vill flytta objekt till papperskorgen?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Är du säker på att du vill flytta objekt till "$ 1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Använd för alla',
			'name'            : 'Namn',
			'size'            : 'Storlek',
			'perms'           : 'Rättigheter',
			'modify'          : 'Ändrad',
			'kind'            : 'Sort',
			'read'            : 'läs',
			'write'           : 'skriv',
			'noaccess'        : 'ingen åtkomst',
			'and'             : 'och',
			'unknown'         : 'okänd',
			'selectall'       : 'Välj alla filer',
			'selectfiles'     : 'Välj fil(er)',
			'selectffile'     : 'Välj första filen',
			'selectlfile'     : 'Välj sista filen',
			'viewlist'        : 'Listvy',
			'viewicons'       : 'Ikonvy',
			'viewSmall'       : 'Små ikoner', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Medium ikoner', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Stora ikoner', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Extra stora ikoner', // from v2.1.39 added 22.5.2018
			'places'          : 'Platser',
			'calc'            : 'Beräkna',
			'path'            : 'Sökväg',
			'aliasfor'        : 'Alias för',
			'locked'          : 'Låst',
			'dim'             : 'Dimensioner',
			'files'           : 'Filer',
			'folders'         : 'Mappar',
			'items'           : 'Objekt',
			'yes'             : 'ja',
			'no'              : 'nej',
			'link'            : 'Länk',
			'searcresult'     : 'Sökresultat',
			'selected'        : 'valda objekt',
			'about'           : 'Om',
			'shortcuts'       : 'Genväg',
			'help'            : 'Hjälp',
			'webfm'           : 'Webbfilhanterare',
			'ver'             : 'Version',
			'protocolver'     : 'protokolversion',
			'homepage'        : 'Projekt hemsida',
			'docs'            : 'Dokumentation',
			'github'          : 'Forka oss på Github',
			'twitter'         : 'Följ oss på twitter',
			'facebook'        : 'Följ oss på facebook',
			'team'            : 'Team',
			'chiefdev'        : 'senior utvecklare',
			'developer'       : 'utvecklare',
			'contributor'     : 'bidragsgivare',
			'maintainer'      : 'underhållare',
			'translator'      : 'översättare',
			'icons'           : 'Ikoner',
			'dontforget'      : 'och glöm inte att ta med din handduk',
			'shortcutsof'     : 'Genvägar avaktiverade',
			'dropFiles'       : 'Släpp filerna här',
			'or'              : 'eller',
			'selectForUpload' : 'Välj filer att ladda upp',
			'moveFiles'       : 'Flytta filer',
			'copyFiles'       : 'Kopiera filer',
			'restoreFiles'    : 'Återställ objekt', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Ta bort från platser',
			'aspectRatio'     : 'Aspekt ratio',
			'scale'           : 'Skala',
			'width'           : 'Bredd',
			'height'          : 'Höjd',
			'resize'          : 'Ändra storlek',
			'crop'            : 'Beskär',
			'rotate'          : 'Rotera',
			'rotate-cw'       : 'Rotera 90 grader medurs',
			'rotate-ccw'      : 'Rotera 90 grader moturs',
			'degree'          : 'Grader',
			'netMountDialogTitle' : 'Koppla nätverksvolym', // added 18.04.2012
			'protocol'            : 'Protokol', // added 18.04.2012
			'host'                : 'Värd', // added 18.04.2012
			'port'                : 'Hamn', // added 18.04.2012
			'user'                : 'användare', // added 18.04.2012
			'pass'                : 'Lösenord', // added 18.04.2012
			'confirmUnmount'      : 'Demonterar du $ 1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Släpp eller klistra in filer från webbläsaren', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Släpp filer, klistra in webbadresser eller bilder (urklipp) här', // from v2.1 added 07.04.2014
			'encoding'        : 'Kodning', // from v2.1 added 19.12.2014
			'locale'          : 'Lokal',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Mål: $ 1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Sök efter ingång MIME-typ', // from v2.1 added 22.5.2015
			'owner'           : 'Ägare', // from v2.1 added 20.6.2015
			'group'           : 'Grupp', // from v2.1 added 20.6.2015
			'other'           : 'Övrig', // from v2.1 added 20.6.2015
			'execute'         : 'Kör', // from v2.1 added 20.6.2015
			'perm'            : 'Tillstånd', // from v2.1 added 20.6.2015
			'mode'            : 'Läge', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mappen är tom', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Mappen är tom \\ A Släpp för att lägga till objekt', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Mappen är tom \\ Ett långt tryck för att lägga till objekt', // from v2.1.6 added 30.12.2015
			'quality'         : 'Kvalitet', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Automatisk synkronisering',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Flytta upp',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Hämta URL-länk', // from v2.1.7 added 9.2.2016
			'share'           : 'Dela med sig',
			'selectedItems'   : 'Valda objekt ($ 1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'Mapp-ID', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Tillåt offlineåtkomst', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'För att autentisera om', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Laddar...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Öppna flera filer', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Du försöker öppna $ 1-filerna. Är du säker på att du vill öppna i webbläsaren?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Sökresultaten är tomma i sökmålet.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Det redigerar en fil.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Du har valt $ 1 objekt.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'Du har $ 1 objekt i Urklipp.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Inkrementell sökning är endast från den aktuella vyn.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'Återställ', // from v2.1.15 added 3.8.2016
			'complete'        : '$ 1 komplett', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Innehållsmeny', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Sidvändning', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Volymrötter', // from v2.1.16 added 16.9.2016
			'reset'           : 'Återställa', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Bakgrundsfärg', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Färgväljare', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px rutnät', // from v2.1.16 added 4.10.2016
			'enabled'         : 'Aktiverad', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Inaktiverad', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Sökresultaten är tomma i aktuell vy. \\ ATryck på [Enter] för att utöka sökmålet.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Första bokstaven sökresultat är tomma i aktuell vy.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Textetikett', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '$ 1 minuter kvar', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Öppna igen med vald kodning', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Spara med vald kodning', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Välj mapp', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Första bokstavssökningen', // from v2.1.23 added 24.3.2017
			'presets'         : 'Förinställningar', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Det är för många saker så att det inte kan komma i papperskorgen.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Töm mappen "$ 1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'Det finns inga objekt i en mapp "$ 1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'Preferens', // from v2.1.26 added 28.6.2017
			'language'        : 'Språk', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Initiera inställningarna som sparats i den här webbläsaren', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Verktygsfältets inställningar', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $ 1 tecken kvar.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $ 1 rader kvar.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Belopp', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Grov filstorlek', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Fokusera på elementet i dialog med musövergång',  // from v2.1.30 added 2.11.2017
			'select'          : 'Välj', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Åtgärd när du väljer fil', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Öppna med redigeraren som användes förra gången', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Invertera val', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Är du säker på att du vill byta namn på $ 1 valda objekt som $ 2? <br/> Detta kan inte ångras!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Batchbyte', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Nummer', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Lägg till prefix', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Lägg till suffix', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Ändra tillägg', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Kolumninställningar (Listvy)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Alla ändringar återspeglas direkt i arkivet.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Eventuella ändringar återspeglas inte förrän avmonteringen av den här volymen.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'Följande volym (er) monterade på den här volymen avmonterades också. Är du säker på att avmontera den?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Urvalsinfo', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Algoritmer för att visa filhash', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Info-poster (urvalsinfopanelen)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Tryck igen för att avsluta.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Verktygsfält', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Arbetsutrymme', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Dialog', // from v2.1.38 added 4.4.2018
			'all'             : 'Allt', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Ikonstorlek (Ikonvy)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Öppna det maximerade redigeringsfönstret', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Eftersom konvertering via API för närvarande inte är tillgänglig, vänligen konvertera på webbplatsen.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Efter konvertering måste du ladda upp med artikelns URL eller en nedladdad fil för att spara den konverterade filen.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Konvertera på webbplatsen för $ 1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Integrationer', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'Denna elFinder har följande externa tjänster integrerade. Kontrollera användarvillkoren, sekretesspolicyn etc. innan du använder den.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Visa dolda objekt', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'Kodredigerare',
			'hideHidden'      : 'Dölj dolda föremål', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Visa / dölj dolda objekt', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Filtyper som ska aktiveras med "Ny fil"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Typ av textfilen', // from v2.1.41 added 7.8.2018
			'add'             : 'Lägg till', // from v2.1.41 added 7.8.2018
			'theme'           : 'Tema', // from v2.1.43 added 19.10.2018
			'default'         : 'Standard', // from v2.1.43 added 19.10.2018
			'description'     : 'Beskrivning', // from v2.1.43 added 19.10.2018
			'website'         : 'Hemsida', // from v2.1.43 added 19.10.2018
			'author'          : 'Författare', // from v2.1.43 added 19.10.2018
			'email'           : 'E-post', // from v2.1.43 added 19.10.2018
			'license'         : 'Licens', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Det här objektet kan inte sparas. För att undvika att förlora redigeringarna måste du exportera till din dator.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Dubbelklicka på filen för att välja den.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Använd helskärmsläge', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Okänd',
			'kindRoot'        : 'Volymrot', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Mapp',
			'kindSelects'     : 'Val', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Alias',
			'kindAliasBroken' : 'Trasigt alias',
			// applications
			'kindApp'         : 'Applikation',
			'kindPostscript'  : 'Postscript',
			'kindMsOffice'    : 'Microsoft Office',
			'kindMsWord'      : 'Microsoft Word',
			'kindMsExcel'     : 'Microsoft Excel',
			'kindMsPP'        : 'Microsoft Powerpoint',
			'kindOO'          : 'Open Office',
			'kindAppFlash'    : 'Flash',
			'kindPDF'         : 'Portabelt dokumentformat (PDF)',
			'kindTorrent'     : 'Bittorrent',
			'kind7z'          : '7z',
			'kindTAR'         : 'TAR',
			'kindGZIP'        : 'GZIP',
			'kindBZIP'        : 'BZIP',
			'kindXZ'          : 'XZ',
			'kindZIP'         : 'ZIP',
			'kindRAR'         : 'RAR',
			'kindJAR'         : 'Java JAR',
			'kindTTF'         : 'True Type',
			'kindOTF'         : 'Open Type',
			'kindRPM'         : 'RPM',
			// texts
			'kindText'        : 'Text',
			'kindTextPlain'   : 'Plain',
			'kindPHP'         : 'PHP',
			'kindCSS'         : 'Kaskad stilark',
			'kindHTML'        : 'HTML',
			'kindJS'          : 'Javascript',
			'kindRTF'         : 'Rich Text Format',
			'kindC'           : 'C',
			'kindCHeader'     : 'C header',
			'kindCPP'         : 'C++',
			'kindCPPHeader'   : 'C++ header',
			'kindShell'       : 'Unix skalskript',
			'kindPython'      : 'Python',
			'kindJava'        : 'Java',
			'kindRuby'        : 'Ruby',
			'kindPerl'        : 'Perl',
			'kindSQL'         : 'SQL',
			'kindXML'         : 'XML',
			'kindAWK'         : 'AWK',
			'kindCSV'         : 'CSV',
			'kindDOCBOOK'     : 'Docbook XML',
			'kindMarkdown'    : 'Markdown text', // added 20.7.2015
			// images
			'kindImage'       : 'Bild',
			'kindBMP'         : 'BMP',
			'kindJPEG'        : 'JPEG',
			'kindGIF'         : 'GIF',
			'kindPNG'         : 'PNG',
			'kindTIFF'        : 'TIFF',
			'kindTGA'         : 'TGA',
			'kindPSD'         : 'Adobe Photoshop',
			'kindXBITMAP'     : 'X bitmap',
			'kindPXM'         : 'Pixelmator',
			// media
			'kindAudio'       : 'Ljudmedia',
			'kindAudioMPEG'   : 'MPEG-ljud',
			'kindAudioMPEG4'  : 'MPEG-4 ljud',
			'kindAudioMIDI'   : 'MIDI-ljud',
			'kindAudioOGG'    : 'Ogg Vorbis ljud',
			'kindAudioWAV'    : 'WAV-ljud',
			'AudioPlaylist'   : 'MP3-spellista',
			'kindVideo'       : 'Videomedia',
			'kindVideoDV'     : 'DV-film',
			'kindVideoMPEG'   : 'MPEG-film',
			'kindVideoMPEG4'  : 'MPEG-4-film',
			'kindVideoAVI'    : 'AVI-film',
			'kindVideoMOV'    : 'Quick Time-film',
			'kindVideoWM'     : 'Windows Media-film',
			'kindVideoFlash'  : 'Flash-film',
			'kindVideoMKV'    : 'Matroska film',
			'kindVideoOGG'    : 'Ogg film'
		}
	};
}));