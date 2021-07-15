/**
 * Language of translation in Danish translation
 * @author Mark Topper (webman.io)
 * @version 2020-08-31
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
	elFinder.prototype.i18.da = {
		translator : 'Mark Topper (webman.io)',
		language   : 'Language of translation in Danish',
		direction  : 'ltr',
		dateFormat : 'd.m.Y H:i', // will show like: 31.08.2020 16:10
		fancyDateFormat : '$1 H:i', // will show like: I dag 16:10
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200831-161035
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'Fejl',
			'errUnknown'           : 'Ukendt fejl.',
			'errUnknownCmd'        : 'Ukendt kommando.',
			'errJqui'              : 'Ugyldig jQuery UI konfiguration. Valgbare, som kan trækkes rundt og droppable komponenter skal medtages.',
			'errNode'              : 'elFinder kræver DOM Element oprettet.',
			'errURL'               : 'Ugyldig elFinder konfiguration! URL option er ikke sat.',
			'errAccess'            : 'Adgang nægtet.',
			'errConnect'           : 'Kan ikke få kontatkt med backend.',
			'errAbort'             : 'Forbindelse afbrudt.',
			'errTimeout'           : 'Forbindelse timeout.',
			'errNotFound'          : 'Backend ikke fundet.',
			'errResponse'          : 'Ugyldigt backend svar.',
			'errConf'              : 'Ugyldig backend konfiguration.',
			'errJSON'              : 'PHP JSON module ikke installeret.',
			'errNoVolumes'         : 'Læsbare volumener ikke tilgængelig.',
			'errCmdParams'         : 'Ugyldige parametre for kommando "$1".',
			'errDataNotJSON'       : 'Data er ikke JSON.',
			'errDataEmpty'         : 'Data er tomt.',
			'errCmdReq'            : 'Backend request kræver kommando navn.',
			'errOpen'              : 'Kunne ikke åbne "$1".',
			'errNotFolder'         : 'Objektet er ikke en mappe.',
			'errNotFile'           : 'Objektet er ikke en fil.',
			'errRead'              : 'Kunne ikke læse "$1".',
			'errWrite'             : 'Kunne ikke skrive til "$1".',
			'errPerm'              : 'Adgang nægtet.',
			'errLocked'            : '"$1" er låst og kan ikke blive omdøbt, flyttet eller slettet.',
			'errExists'            : 'Der findes allerede en fil ved navn "$1".',
			'errInvName'           : 'Ugyldigt fil navn.',
			'errInvDirname'        : 'Ugyldigt mappenavn.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Mappe ikke fundet.',
			'errFileNotFound'      : 'Fil ikke fundet.',
			'errTrgFolderNotFound' : 'Mappen "$1" blev ikke fundet.',
			'errPopup'             : 'Browseren forhindrede åbne popup-vindue. For at åbne filen aktivere popup-vinduer i browserindstillinger.',
			'errMkdir'             : 'Kunne ikke oprette mappen "$1".',
			'errMkfile'            : 'Kunne ikke oprette filen "$1".',
			'errRename'            : 'Kunne ikke omdøbe "$1".',
			'errCopyFrom'          : 'Kopiering af filer fra volumen "$1" er ikke tilladt.',
			'errCopyTo'            : 'Kopiering af filer til volumen "$1" er ikke tilladt.',
			'errMkOutLink'         : 'Kan ikke oprette et link til uden for lydstyrkeroten.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Upload fejl.',  // old name - errUploadCommon
			'errUploadFile'        : 'Kunne ikke uploade "$1".', // old name - errUpload
			'errUploadNoFiles'     : 'Ingen filer fundet til upload.',
			'errUploadTotalSize'   : 'Dataen overskrider den maksimalt tilladte størrelse.', // old name - errMaxSize
			'errUploadFileSize'    : 'Fil overskrider den maksimalt tilladte størrelse.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Fil type ikke godkendt.',
			'errUploadTransfer'    : '"$1" overførsels fejl.',
			'errUploadTemp'        : 'Kan ikke oprette midlertidig fil til upload.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Objekt "$1" findes allerede på denne placering og kan ikke erstattes af objekt med en anden type.', // new
			'errReplace'           : 'Kunne ikke erstatte "$1".',
			'errSave'              : 'Kunne ikke gemme "$1".',
			'errCopy'              : 'Kunne ikke kopier "$1".',
			'errMove'              : 'Kunne ikke flytte "$1".',
			'errCopyInItself'      : 'Kunne ikke kopier "$1" ind i sig selv.',
			'errRm'                : 'Kunne ikke slette "$1".',
			'errTrash'             : 'Kunne ikke komme i papirkurven.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Kan ikke fjerne kildefil (er).',
			'errExtract'           : 'Kunne ikke udpakke filer fra "$1".',
			'errArchive'           : 'Kunne ikke oprette arkiv.',
			'errArcType'           : 'Arkiv typen er ikke understøttet.',
			'errNoArchive'         : 'Filen er ikke et arkiv eller har ikke-understøttet arkiv type.',
			'errCmdNoSupport'      : 'Backend understøtter ikke denne kommando.',
			'errReplByChild'       : 'Mappen "$1" kan ikke erstattes af en vare, den indeholder.',
			'errArcSymlinks'       : 'Af sikkerhedsmæssige årsager nægtede at udpakke arkiver der indeholder symlinks eller filer med ikke tilladte navne.', // edited 24.06.2012
			'errArcMaxSize'        : 'Arkivfiler overskrider den maksimalt tilladte størrelse.',
			'errResize'            : 'Kunne ikke ændre størrelsen på "$1".',
			'errResizeDegree'      : 'Ugyldig rotere grad.',  // added 7.3.2013
			'errResizeRotate'      : 'Kunne ikke rotere billedet.',  // added 7.3.2013
			'errResizeSize'        : 'Ugyldig billedstørrelse.',  // added 7.3.2013
			'errResizeNoChange'    : 'Billedstørrelse ikke ændret.',  // added 7.3.2013
			'errUsupportType'      : 'Ikke-understøttet fil type.',
			'errNotUTF8Content'    : 'Filen "$1" er ikke i UTF-8 og kan ikke blive redigeret.',  // added 9.11.2011
			'errNetMount'          : 'Kunne ikke mounte "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'Ikke-understøttet protocol.',     // added 17.04.2012
			'errNetMountFailed'    : 'Mount mislykkedes.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Host krævet.', // added 18.04.2012
			'errSessionExpires'    : 'Din session er udløbet på grund af inaktivitet.',
			'errCreatingTempDir'   : 'Kunne ikke oprette midlertidig mappe: "$1"',
			'errFtpDownloadFile'   : 'Kunne ikke downloade filen fra FTP: "$1"',
			'errFtpUploadFile'     : 'Kunne ikke uploade filen til FTP: "$1"',
			'errFtpMkdir'          : 'Kan ikke oprette fjernkatalog på FTP: "$1"',
			'errArchiveExec'       : 'Fejl ved arkivering filer: "$1"',
			'errExtractExec'       : 'Fejl under udpakning af filer: "$1"',
			'errNetUnMount'        : 'Kan ikke afmontere.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Ikke konverteres til UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Prøv den moderne browser, hvis du vil uploade mappen.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Tidsafbrydelsen blev søgt efter "$ 1". Søgeresultatet er delvis.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Genautorisation er påkrævet.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Det maksimale antal valgbare elementer er $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Kan ikke gendannes fra papirkurven. Kan ikke identificere gendannelsesdestinationen.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Editor blev ikke fundet til denne filtype.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Der opstod en fejl på serversiden.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Kan ikke tømme mappen "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Der er $1 flere fejl.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Lav arkiv',
			'cmdback'      : 'Tilbage',
			'cmdcopy'      : 'Kopier',
			'cmdcut'       : 'Klip',
			'cmddownload'  : 'downloade',
			'cmdduplicate' : 'Dupliker',
			'cmdedit'      : 'Rediger Fil',
			'cmdextract'   : 'Udpak filer fra arkiv',
			'cmdforward'   : 'Frem',
			'cmdgetfile'   : 'Vælg filer',
			'cmdhelp'      : 'Om dette produkt',
			'cmdhome'      : 'Hjem',
			'cmdinfo'      : 'Information',
			'cmdmkdir'     : 'Ny mappe',
			'cmdmkdirin'   : 'I ny mappe', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Ny fil',
			'cmdopen'      : 'Åben',
			'cmdpaste'     : 'Indsæt',
			'cmdquicklook' : 'Vis',
			'cmdreload'    : 'Genindlæs',
			'cmdrename'    : 'Omdøb',
			'cmdrm'        : 'Slet',
			'cmdtrash'     : 'ind i papirkurven', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Gendan', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Find filer',
			'cmdup'        : 'Gå til forældre mappe',
			'cmdupload'    : 'Upload filer',
			'cmdview'      : 'Vis',
			'cmdresize'    : 'Ændre størrelse',
			'cmdsort'      : 'Sorter',
			'cmdnetmount'  : 'Monter netværksvolumen', // added 18.04.2012
			'cmdnetunmount': 'Afmontér', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Til steder', // added 28.12.2014
			'cmdchmod'     : 'Skift tilstand', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Åbn en mappe', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Nulstil kolonnebredde', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Fuld skærm', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Bevæge sig', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Tøm mappen', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Fortryd', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'Redo', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'fortrinsret', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Vælg alle', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Vælg ingen', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Inverter markering', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Åbn i nyt vindue', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Skjul (præference)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Luk',
			'btnSave'   : 'Gem',
			'btnRm'     : 'Slet',
			'btnApply'  : 'Anvend',
			'btnCancel' : 'Annuler',
			'btnNo'     : 'Nej',
			'btnYes'    : 'Ja',
			'btnMount'  : 'Montere',  // added 18.04.2012
			'btnApprove': 'Gå $1 og godkend', // from v2.1 added 26.04.2012
			'btnUnmount': 'Afmontér', // from v2.1 added 30.04.2012
			'btnConv'   : 'Konvertere', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Her',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Volumen',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Alle',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME Type', // from v2.1 added 22.5.2015
			'btnFileName':'Filnavn',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Gem og luk', // from v2.1 added 12.6.2015
			'btnBackup' : 'sikkerhedskopi', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Omdøb',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Omdøb (Alle)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'forrige ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Næste ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Gem som', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Åben mappe',
			'ntffile'     : 'Åben fil',
			'ntfreload'   : 'Reload mappe indhold',
			'ntfmkdir'    : 'Opretter mappe',
			'ntfmkfile'   : 'Opretter filer',
			'ntfrm'       : 'Sletter filer',
			'ntfcopy'     : 'Kopier filer',
			'ntfmove'     : 'Flytter filer',
			'ntfprepare'  : 'Forbereder kopering af filer',
			'ntfrename'   : 'Omdøb filer',
			'ntfupload'   : 'Uploader filer',
			'ntfdownload' : 'Downloader filer',
			'ntfsave'     : 'Gemmer filer',
			'ntfarchive'  : 'Opretter arkiv',
			'ntfextract'  : 'Udpakker filer fra arkiv',
			'ntfsearch'   : 'Søger filer',
			'ntfresize'   : 'Ændring af størrelse på billeder',
			'ntfsmth'     : 'Gør noget >_<',
			'ntfloadimg'  : 'Loader billede',
			'ntfnetmount' : 'Montere netværks volume', // added 18.04.2012
			'ntfnetunmount': 'Afmontering af netværksvolumen', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Erhverver billeddimension', // added 20.05.2013
			'ntfreaddir'  : 'Læser mappeoplysninger', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Få URL til link', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Ændring af filtilstand', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Bekræftelse af upload filnavn', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Oprettelse af en fil til download', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Getting path infomation', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Behandling af den uploadede fil', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'At smide i papirkurven', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Gør gendannelse fra papirkurven', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Kontrol destinationsmappe', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Fortrydning af forrige handling', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Redoing previous undone', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'checke af indhold', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'Affald', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'Ukendt',
			'Today'       : 'I dag',
			'Yesterday'   : 'I går',
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
			'January'     : 'Januar',
			'February'    : 'Februar',
			'March'       : 'Marts',
			'April'       : 'April',
			'May'         : 'Maj',
			'June'        : 'Juni',
			'July'        : 'Juli',
			'August'      : 'August',
			'September'   : 'September',
			'October'     : 'Oktober',
			'November'    : 'November',
			'December'    : 'December',
			'Sunday'      : 'Søndag',
			'Monday'      : 'Mandag',
			'Tuesday'     : 'Tirsdag',
			'Wednesday'   : 'Onsdag',
			'Thursday'    : 'Torsdag',
			'Friday'      : 'Fredag',
			'Saturday'    : 'Lørdag',
			'Sun'         : 'Søn',
			'Mon'         : 'Man',
			'Tue'         : 'Tir',
			'Wed'         : 'Ons',
			'Thu'         : 'Tor',
			'Fri'         : 'Fre',
			'Sat'         : 'Lør',

			/******************************** sort variants ********************************/
			'sortname'          : 'efter navn',
			'sortkind'          : 'efter type',
			'sortsize'          : 'efter størrelse',
			'sortdate'          : 'efter dato',
			'sortFoldersFirst'  : 'Mapper først',
			'sortperm'          : 'med tilladelse', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'by mode',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'af ejeren',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'efter gruppe',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Også Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'Ny mappe',   // added 10.11.2015
			'Archive'           : 'Nyt arkiv',  // from v2.1 added 10.11.2015
			'untitled file'     : 'NewFile.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: Fil',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Bekræftelse påkrævet',
			'confirmRm'       : 'Er du sikker på du vil slette valgte filer?<br/>Dette kan ikke blive fortrudt!',
			'confirmRepl'     : 'Erstat gammel fil med ny fil?',
			'confirmRest'     : 'Erstatter det eksisterende emne med det i papirkurven?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Ikke i UTF-8 <br/> Konverter til UTF-8? <br/> Indholdet bliver UTF-8 ved at gemme efter konvertering.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Tegnkodning af denne fil kunne ikke detekteres. Det er nødvendigt midlertidigt at konvertere til UTF-8 til redigering. <br/> Vælg tegnkodning af denne fil.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Det er blevet ændret. <br/> Mister arbejde, hvis du ikke gemmer ændringer.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Er du sikker på, at du vil flytte genstande til papirkurven?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Er du sikker på, at du vil flytte varer til "$1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Anvend ved alle',
			'name'            : 'Navn',
			'size'            : 'Størrelse',
			'perms'           : 'Rettigheder',
			'modify'          : 'Ændret',
			'kind'            : 'Type',
			'read'            : 'Læse',
			'write'           : 'Skrive',
			'noaccess'        : 'ingen adgang',
			'and'             : 'og',
			'unknown'         : 'ukendt',
			'selectall'       : 'Vælg alle filer',
			'selectfiles'     : 'Vælg fil(er)',
			'selectffile'     : 'Vælg første fil',
			'selectlfile'     : 'Vælg sidste fil',
			'viewlist'        : 'Liste visning',
			'viewicons'       : 'Ikon visning',
			'viewSmall'       : 'Små ikoner', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Medium ikoner', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Store ikoner', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Ekstra store ikoner', // from v2.1.39 added 22.5.2018
			'places'          : 'Plaseringer',
			'calc'            : 'Udregn',
			'path'            : 'Sti',
			'aliasfor'        : 'Alias for',
			'locked'          : 'Låst',
			'dim'             : 'Størrelser',
			'files'           : 'Filer',
			'folders'         : 'Mapper',
			'items'           : 'Varer',
			'yes'             : 'ja',
			'no'              : 'nej',
			'link'            : 'Link',
			'searcresult'     : 'Søge resultater',
			'selected'        : 'valgte varer',
			'about'           : 'Om',
			'shortcuts'       : 'Genveje',
			'help'            : 'Hjælp',
			'webfm'           : 'Internet fil manager',
			'ver'             : 'Version',
			'protocolver'     : 'protocol version',
			'homepage'        : 'Projeckt side',
			'docs'            : 'Dokumentation',
			'github'          : 'Fork os på Github',
			'twitter'         : 'Følg os på twitter',
			'facebook'        : 'Følg os på facebook',
			'team'            : 'Hold',
			'chiefdev'        : 'hovede udvikler',
			'developer'       : 'udvikler',
			'contributor'     : 'bidragyder',
			'maintainer'      : 'vedligeholder',
			'translator'      : 'oversætter',
			'icons'           : 'Ikoner',
			'dontforget'      : 'og glemt ikke at tag dit håndklæde',
			'shortcutsof'     : 'Gemveje deaktiveret',
			'dropFiles'       : 'Drop filer hertil',
			'or'              : 'eller',
			'selectForUpload' : 'Vælg filer at uploade',
			'moveFiles'       : 'Flyt filer',
			'copyFiles'       : 'Kopier filer',
			'restoreFiles'    : 'Gendan genstande', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Slet fra placering',
			'aspectRatio'     : 'Skærmformat',
			'scale'           : 'Skala',
			'width'           : 'Bredte',
			'height'          : 'Højde',
			'resize'          : 'Ændre størrelse',
			'crop'            : 'Beskær',
			'rotate'          : 'Roter',
			'rotate-cw'       : 'Roter 90 grader med uret',
			'rotate-ccw'      : 'Roter 90 grader imod uret',
			'degree'          : 'Grader',
			'netMountDialogTitle' : 'Monter netwærks volume', // added 18.04.2012
			'protocol'            : 'Protokol', // added 18.04.2012
			'host'                : 'Vært', // added 18.04.2012
			'port'                : 'Port', // added 18.04.2012
			'user'                : 'Bruger', // added 18.04.2012
			'pass'                : 'Kodeord', // added 18.04.2012
			'confirmUnmount'      : 'Er du afmontere $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Slip eller indsæt filer fra browseren', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Slip filer, indsæt webadresser eller billeder (udklipsholder) her', // from v2.1 added 07.04.2014
			'encoding'        : 'Indkodning', // from v2.1 added 19.12.2014
			'locale'          : 'Locale',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Target: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Søg efter input MIME Type', // from v2.1 added 22.5.2015
			'owner'           : 'Ejer', // from v2.1 added 20.6.2015
			'group'           : 'Gruppe', // from v2.1 added 20.6.2015
			'other'           : 'Anden', // from v2.1 added 20.6.2015
			'execute'         : 'eksekvere', // from v2.1 added 20.6.2015
			'perm'            : 'Tilladelse', // from v2.1 added 20.6.2015
			'mode'            : 'Mode', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mappen er tom', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Mappen er tom \\ A Drop for at tilføje emner', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Mappen er tom \\ A Langt tryk for at tilføje emner', // from v2.1.6 added 30.12.2015
			'quality'         : 'Kvalitet', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Automatisk synkronisering',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Flyt op',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Få URL-link', // from v2.1.7 added 9.2.2016
			'share'           : 'Del',
			'selectedItems'   : 'Valgte varer ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'Mappe-ID', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Tillad offline adgang', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'At re autentificering', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Nu indlæses...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Åbn flere filer', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Du prøver at åbne $ 1-filerne. Er du sikker på, at du vil åbne i browseren?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Søgeresultater er tom på jagt efter mål.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Det redigerer en fil.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Du har valgt $1 poster.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'Du har $1 artikler i udklipsholderen.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'inkremental søgning er kun fra den aktuelle visning.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'Gendanne', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 komplet', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Kontekstmenu', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Sidevending', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Volumen rødder', // from v2.1.16 added 16.9.2016
			'reset'           : 'Nulstille', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Baggrundsfarve', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Farvevælger', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px Grid', // from v2.1.16 added 4.10.2016
			'enabled'         : 'sætte i stand til', // from v2.1.16 added 4.10.2016
			'disabled'        : 'deaktiveret', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Søgeresultaterne er tomme i den aktuelle visning. \\ ATryk på [Enter] for at udvide søgemålet.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Første bogstavs søgeresultater er tomme i den aktuelle visning.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Tekstetiket', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '$1 minutter tilbage', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Genåbne med valgte kodning', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Gem med den valgte kodning', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Vælg mappe', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Første bogstavsøgning', // from v2.1.23 added 24.3.2017
			'presets'         : 'Forudindstillinger', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Det er for mange genstande, så det ikke kan komme i skrald.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Tøm mappen "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'Der er ingen varer i en mappe "$1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'Præference', // from v2.1.26 added 28.6.2017
			'language'        : 'Sprog', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Initialiser de indstillinger, der er gemt i denne browser', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Værktøjslinjens indstillinger', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $1 tegn tilbage.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $1 resterende linjer.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Sum', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Grov filstørrelse', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Fokus på det element af dialogboksen med mouseover',  // from v2.1.30 added 2.11.2017
			'select'          : 'Vælge', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Handling, når du vælger fil', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Åbn med den redaktør, der blev brugt sidst', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Inverter markering', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Er du sikker på, at du vil omdøbe $1 valgte emner som $2? <br/> Dette kan ikke fortrydes!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Batch omdøb', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Nummer', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Tilføj præfiks', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Tilføj suffiks', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Skift udvidelse', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Kolonneindstillinger (Listevisning)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Alle ændringer vil afspejle straks til arkivet.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Any changes will not reflect until un-mount this volume.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'Følgende volumen(s) monteret på denne volumen også skubbes ud. Er du sikker på at afmontere den?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'udvælgelse Info', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Algoritmer for at vise filen hash', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Infoelementer (panelet til valg af info)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Tryk igen for at afslutte.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'værktøjslinien', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Arbejde splads', // from v2.1.38 added 4.4.2018
			'dialog'          : 'dialogboks', // from v2.1.38 added 4.4.2018
			'all'             : 'Alle', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Ikon Størrelse (Ikoner se)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Åbn det maksimerede editorvindue', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Fordi konvertering af API er i øjeblikket ikke tilgængelig, skal du konvertere på hjemmesiden.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Efter konvertering skal du uploade med artikelens URL eller en downloadet fil for at gemme den konverterede fil.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Konverter på webstedet for $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'integrationer', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'Denne elFinder har følgende eksterne tjenester integreret. Kontroller brugsbetingelserne, privatlivspolitikken osv., Før du bruger det.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Vis skjulte elementer', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'Kode Editor',
			'hideHidden'      : 'Skjul skjulte elementer', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Vis/Skjul skjulte elementer', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Filtyper, der skal aktiveres med "Ny fil"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Type af tekstfilen', // from v2.1.41 added 7.8.2018
			'add'             : 'Tilføje', // from v2.1.41 added 7.8.2018
			'theme'           : 'Tema', // from v2.1.43 added 19.10.2018
			'default'         : 'Misligholde', // from v2.1.43 added 19.10.2018
			'description'     : 'Beskrivelse', // from v2.1.43 added 19.10.2018
			'website'         : 'Websted', // from v2.1.43 added 19.10.2018
			'author'          : 'Forfatter', // from v2.1.43 added 19.10.2018
			'email'           : 'Email', // from v2.1.43 added 19.10.2018
			'license'         : 'Licens', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Denne vare kan ikke gemmes. For at undgå at miste redigeringerne skal du eksportere til din pc.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Dobbeltklik på filen for at vælge den.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Brug fuldskærmstilstand', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Ukendt',
			'kindRoot'        : 'Volumen Root', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Mappe',
			'kindSelects'     : 'udvælgelse', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Alias',
			'kindAliasBroken' : 'Ødelagt alias',
			// applications
			'kindApp'         : 'Applikation',
			'kindPostscript'  : 'Postscript dokument',
			'kindMsOffice'    : 'Microsoft Office dokument',
			'kindMsWord'      : 'Microsoft Word dokument',
			'kindMsExcel'     : 'Microsoft Excel dokument',
			'kindMsPP'        : 'Microsoft Powerpoint præsentation',
			'kindOO'          : 'Open Office dokument',
			'kindAppFlash'    : 'Flash applikation',
			'kindPDF'         : 'Flytbart Dokument Format (PDF)',
			'kindTorrent'     : 'Bittorrent fil',
			'kind7z'          : '7z arkiv',
			'kindTAR'         : 'TAR arkiv',
			'kindGZIP'        : 'GZIP arkiv',
			'kindBZIP'        : 'BZIP arkiv',
			'kindXZ'          : 'XZ arkiv',
			'kindZIP'         : 'ZIP arkiv',
			'kindRAR'         : 'RAR arkiv',
			'kindJAR'         : 'Java JAR fil',
			'kindTTF'         : 'True Type skrift',
			'kindOTF'         : 'Open Type skrift',
			'kindRPM'         : 'RPM pakke',
			// texts
			'kindText'        : 'Tekst dokument',
			'kindTextPlain'   : 'Ren tekst',
			'kindPHP'         : 'PHP kode',
			'kindCSS'         : 'Kaskaderende stilark',
			'kindHTML'        : 'HTML-dokument',
			'kindJS'          : 'Javascript kode',
			'kindRTF'         : 'Rich Tekst Format',
			'kindC'           : 'C kode',
			'kindCHeader'     : 'C header kode',
			'kindCPP'         : 'C++ kode',
			'kindCPPHeader'   : 'C++ header kode',
			'kindShell'       : 'Unix shell script',
			'kindPython'      : 'Python kode',
			'kindJava'        : 'Java kode',
			'kindRuby'        : 'Ruby kode',
			'kindPerl'        : 'Perl script',
			'kindSQL'         : 'SQL kode',
			'kindXML'         : 'XML dokument',
			'kindAWK'         : 'AWK kode',
			'kindCSV'         : 'Komma seperaret værdier',
			'kindDOCBOOK'     : 'Docbook XML dokument',
			'kindMarkdown'    : 'Markdown-tekst', // added 20.7.2015
			// images
			'kindImage'       : 'Billede',
			'kindBMP'         : 'BMP billede',
			'kindJPEG'        : 'JPEG billede',
			'kindGIF'         : 'GIF billede',
			'kindPNG'         : 'PNG billede',
			'kindTIFF'        : 'TIFF billede',
			'kindTGA'         : 'TGA billede',
			'kindPSD'         : 'Adobe Photoshop billede',
			'kindXBITMAP'     : 'X bitmap billede',
			'kindPXM'         : 'Pixelmator billede',
			// media
			'kindAudio'       : 'Lyd medie',
			'kindAudioMPEG'   : 'MPEG lyd',
			'kindAudioMPEG4'  : 'MPEG-4 lyd',
			'kindAudioMIDI'   : 'MIDI lyd',
			'kindAudioOGG'    : 'Ogg Vorbis lyd',
			'kindAudioWAV'    : 'WAV lyd',
			'AudioPlaylist'   : 'MP3 spilleliste',
			'kindVideo'       : 'Video medie',
			'kindVideoDV'     : 'DV video',
			'kindVideoMPEG'   : 'MPEG video',
			'kindVideoMPEG4'  : 'MPEG-4 video',
			'kindVideoAVI'    : 'AVI video',
			'kindVideoMOV'    : 'Hurtig tids video',
			'kindVideoWM'     : 'Windows Medie video',
			'kindVideoFlash'  : 'Flash video',
			'kindVideoMKV'    : 'Matroska video',
			'kindVideoOGG'    : 'Ogg video'
		}
	};
}));