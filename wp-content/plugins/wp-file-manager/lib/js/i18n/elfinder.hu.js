/**
 * magyar translation
 * @author Gáspár Lajos <info@glsys.eu>
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
	elFinder.prototype.i18.hu = {
		translator : 'Gáspár Lajos &lt;info@glsys.eu&gt;',
		language   : 'magyar',
		direction  : 'ltr',
		dateFormat : 'Y.F.d H:i:s', // will show like: 2020.September.02 13:15:11
		fancyDateFormat : '$1 H:i', // will show like: Ma 13:15
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200902-131511
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'Hiba',
			'errUnknown'           : 'Ismeretlen hiba.',
			'errUnknownCmd'        : 'Ismeretlen parancs.',
			'errJqui'              : 'Hibás jQuery UI konfiguráció. A "selectable", "draggable" és a "droppable" komponensek szükségesek.',
			'errNode'              : 'Az elFinder "DOM" elem létrehozását igényli.',
			'errURL'               : 'Hibás elFinder konfiguráció! "URL" paraméter nincs megadva.',
			'errAccess'            : 'Hozzáférés megtagadva.',
			'errConnect'           : 'Nem sikerült csatlakozni a kiszolgálóhoz.',
			'errAbort'             : 'Kapcsolat megszakítva.',
			'errTimeout'           : 'Kapcsolat időtúllépés.',
			'errNotFound'          : 'A backend nem elérhető.',
			'errResponse'          : 'Hibás backend válasz.',
			'errConf'              : 'Hibás backend konfiguráció.',
			'errJSON'              : 'PHP JSON modul nincs telepítve.',
			'errNoVolumes'         : 'Nem állnak rendelkezésre olvasható kötetek.',
			'errCmdParams'         : 'érvénytelen paraméterek a parancsban. ("$1")',
			'errDataNotJSON'       : 'A válasz nem JSON típusú adat.',
			'errDataEmpty'         : 'Nem érkezett adat.',
			'errCmdReq'            : 'A backend kérelem parancsnevet igényel.',
			'errOpen'              : '"$1" megnyitása nem sikerült.',
			'errNotFolder'         : 'Az objektum nem egy mappa.',
			'errNotFile'           : 'Az objektum nem egy fájl.',
			'errRead'              : '"$1" olvasása nem sikerült.',
			'errWrite'             : '"$1" írása nem sikerült.',
			'errPerm'              : 'Engedély megtagadva.',
			'errLocked'            : '"$1" zárolás alatt van, és nem lehet átnevezni, mozgatni vagy eltávolítani.',
			'errExists'            : '"$1" nevű fájl már létezik.',
			'errInvName'           : 'Érvénytelen fáljnév.',
			'errInvDirname'        : 'Érvénytelen mappa neve.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Mappa nem található.',
			'errFileNotFound'      : 'Fájl nem található.',
			'errTrgFolderNotFound' : 'Cél mappa nem található. ("$1")',
			'errPopup'             : 'A böngésző megakadályozta egy felugró ablak megnyitását. A fájl megnyitását tegye lehetővé a böngésző beállitásaiban.',
			'errMkdir'             : '"$1" mappa létrehozása sikertelen.',
			'errMkfile'            : '"$1" fájl létrehozása sikertelen.',
			'errRename'            : '"$1" átnevezése sikertelen.',
			'errCopyFrom'          : 'Fájlok másolása a kötetről nem megengedett. ("$1")',
			'errCopyTo'            : 'Fájlok másolása a kötetre nem megengedett. ("$1")',
			'errMkOutLink'         : 'Hivatkozás létrehozása a root köteten kívül nem megengedett.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Feltöltési hiba.',  // old name - errUploadCommon
			'errUploadFile'        : 'Nem sikerült a fájlt feltölteni. ($1)', // old name - errUpload
			'errUploadNoFiles'     : 'Nem található fájl feltöltéshez.',
			'errUploadTotalSize'   : 'Az adat meghaladja a maximálisan megengedett méretet.', // old name - errMaxSize
			'errUploadFileSize'    : 'A fájl meghaladja a maximálisan megengedett méretet.', //  old name - errFileMaxSize
			'errUploadMime'        : 'A fájltípus nem engedélyezett.',
			'errUploadTransfer'    : '"$1" transzfer hiba.',
			'errUploadTemp'        : 'Sikertelen az ideiglenes fájl léterhezozása feltöltéshez.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Az objektum "$1" már létezik ezen a helyen, és nem lehet cserélni másik típusra', // new
			'errReplace'           : '"$1" nem cserélhető.',
			'errSave'              : '"$1" mentése nem sikerült.',
			'errCopy'              : '"$1" másolása nem sikerült.',
			'errMove'              : '"$1" áthelyezése nem sikerült.',
			'errCopyInItself'      : '"$1" nem másolható saját magára.',
			'errRm'                : '"$1" törlése nem sikerült.',
			'errTrash'             : 'Nem lehet a kukába tenni.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Forrásfájl(ok) eltávolítása sikertelen.',
			'errExtract'           : 'Nem sikerült kibontani a fájlokat a (z) "$1" fájlból.',
			'errArchive'           : 'Nem lehet archívumot létrehozni.',
			'errArcType'           : 'Nem támogatott archívum típus.',
			'errNoArchive'         : 'A fájl nem archív vagy nem támogatott archívum típust.',
			'errCmdNoSupport'      : 'Backend nem támogatja ezt a parancsot.',
			'errReplByChild'       : 'The folder “$1” can’t be replaced by an item it contains.',
			'errArcSymlinks'       : 'Biztonsági okokból az archívumok kibontása megtagadva szimbolikus linkeket vagy fájlokat tartalmaz, amelyek nem engedélyezettek.', // edited 24.06.2012
			'errArcMaxSize'        : 'Az archív fájlok meghaladják a maximálisan megengedett méretet.',
			'errResize'            : 'Nem lehet átméretezni "$1".',
			'errResizeDegree'      : 'Invalid rotate degree.',  // added 7.3.2013
			'errResizeRotate'      : 'Nem lehet elforgatni a képet.',  // added 7.3.2013
			'errResizeSize'        : 'Érvénytelen képméret.',  // added 7.3.2013
			'errResizeNoChange'    : 'A kép mérete nem változott.',  // added 7.3.2013
			'errUsupportType'      : 'Nem támogatott fájl típus.',
			'errNotUTF8Content'    : 'A (z) "$1" fájl nem szerepel az UTF-8 fájlban, és nem szerkeszthető.',  // added 9.11.2011
			'errNetMount'          : 'Nem sikerült a "$1" felcsatolása.', // added 17.04.2012
			'errNetMountNoDriver'  : 'Nem támogatott protokoll.',     // added 17.04.2012
			'errNetMountFailed'    : 'A Mount nem sikerült.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Host szükséges.', // added 18.04.2012
			'errSessionExpires'    : 'A munkamenet lejárt az inaktivitás miatt.',
			'errCreatingTempDir'   : 'Nem sikerült létrehozni az ideiglenes könyvtárat: "$1"',
			'errFtpDownloadFile'   : 'Nem lehet letölteni a fájlt az FTP-ről: "$1"',
			'errFtpUploadFile'     : 'Nem lehet feltölteni a fájlt az FTP-re: "$1"',
			'errFtpMkdir'          : 'Nem lehet távoli könyvtárat létrehozni az FTP-n: "$1"',
			'errArchiveExec'       : 'Hiba a fájlok archiválásakor: "$1"',
			'errExtractExec'       : 'Hiba a fájlok kibontása közben: "$1"',
			'errNetUnMount'        : 'Unable to unmount', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Nem átalakítható UTF-8-ra', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Try Google Chrome, If you\'d like to upload the folder.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Időtúllépés történt a (z) "$1" keresés közben. A keresési eredmény részleges.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Újraengedélyezés szükséges.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Max száma kiválasztható elemek $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Nem sikerült visszaállítani a kukából. Nem sikerült azonosítani a visszaállítási rendeltetési helyet.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Szerkesztő nem találták ezt a fájltípust.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Hiba történt a szerver oldalon.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Nem lehet üríteni a (z) "$1" mappát.', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'További $1 hiba van.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Archívum létrehozása',
			'cmdback'      : 'Vissza',
			'cmdcopy'      : 'Másolás',
			'cmdcut'       : 'Kivágás',
			'cmddownload'  : 'Letöltés',
			'cmdduplicate' : 'Másolat készítés',
			'cmdedit'      : 'Szerkesztés',
			'cmdextract'   : 'Kibontás',
			'cmdforward'   : 'Előre',
			'cmdgetfile'   : 'Fájlok kijelölése',
			'cmdhelp'      : 'Erről a programról...',
			'cmdhome'      : 'Főkönyvtár',
			'cmdinfo'      : 'Tulajdonságok',
			'cmdmkdir'     : 'Új mappa',
			'cmdmkdirin'   : 'Into new folder', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Új fájl',
			'cmdopen'      : 'Megnyitás',
			'cmdpaste'     : 'Beillesztés',
			'cmdquicklook' : 'Előnézet',
			'cmdreload'    : 'Frissítés',
			'cmdrename'    : 'Átnevezés',
			'cmdrm'        : 'Törlés',
			'cmdtrash'     : 'Belül szemetet', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'visszaad', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Keresés',
			'cmdup'        : 'Ugrás a szülőmappába',
			'cmdupload'    : 'Feltöltés',
			'cmdview'      : 'Kilátás',
			'cmdresize'    : 'Átméretezés és forgatás',
			'cmdsort'      : 'Rendezés',
			'cmdnetmount'  : 'Csatlakoztassa a hálózati kötetet', // added 18.04.2012
			'cmdnetunmount': 'Unmount', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'A helyekhez', // added 28.12.2014
			'cmdchmod'     : 'Változás mód', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Nyisson meg egy mappát', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Az oszlop szélességének visszaállítása', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Teljes képernyő', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Mozog', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Ürítse ki a mappát', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Undo', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'újra kifest', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'preferenciák', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Mindet kiválaszt', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Válasszon semmit', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Kijelölés megfordítása', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Megnyitás új ablakban', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Elrejtés (preferencia)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Bezár',
			'btnSave'   : 'Ment',
			'btnRm'     : 'Töröl',
			'btnApply'  : 'Jelentkezés',
			'btnCancel' : 'Mégsem',
			'btnNo'     : 'Nem',
			'btnYes'    : 'Igen',
			'btnMount'  : 'Mount',  // added 18.04.2012
			'btnApprove': 'Lépjen a $1 oldalra és hagyja jóvá', // from v2.1 added 26.04.2012
			'btnUnmount': 'Unmount', // from v2.1 added 30.04.2012
			'btnConv'   : 'Megtérít', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Itt',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Hangerő',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Összes',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME típus', // from v2.1 added 22.5.2015
			'btnFileName':'Fájlnév',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Mentés és bezárás', // from v2.1 added 12.6.2015
			'btnBackup' : 'biztonsági mentés', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Átnevezés',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Átnevezés (összes)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Előző ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Következő ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Mentés másként', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Mappa megnyitás',
			'ntffile'     : 'Fájl megnyitás',
			'ntfreload'   : 'Töltse be újra a mappa tartalmát',
			'ntfmkdir'    : 'Mappa létrehozása',
			'ntfmkfile'   : 'Fájlok létrehozása',
			'ntfrm'       : 'Fájlok törélse',
			'ntfcopy'     : 'Fájlok másolása',
			'ntfmove'     : 'Fájlok áthelyezése',
			'ntfprepare'  : 'Prepare to copy files',
			'ntfrename'   : 'Fájlok átnevezése',
			'ntfupload'   : 'Fájlok feltöltése',
			'ntfdownload' : 'Fájlok letöltése',
			'ntfsave'     : 'Fájlok mentése',
			'ntfarchive'  : 'Archívum létrehozása',
			'ntfextract'  : 'Kibontás archívumból',
			'ntfsearch'   : 'Fájlok keresése',
			'ntfresize'   : 'Képek átméretezése',
			'ntfsmth'     : 'Doing something >_<',
			'ntfloadimg'  : 'Kép betöltése',
			'ntfnetmount' : 'Mounting network volume', // added 18.04.2012
			'ntfnetunmount': 'Unmounting network volume', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Képdimenzió megszerzése', // added 20.05.2013
			'ntfreaddir'  : 'Olvasás mappainformációkat', // from v2.1 added 01.07.2013
			'ntfurl'      : 'A link URL-jének lekérése', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Megváltoztatása fájlmód', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Ellenőrizze a feltöltési fájl nevét', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Fájl létrehozása letöltésre', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Útvonalinformációk megszerzése', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'A feltöltött fájl feldolgozása', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Visszaállítás végrehajtása a kukából', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'helyreállítás végrehajtása a kukából', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'A célmappa ellenőrzése', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Az előző művelet visszavonása', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Ismételje meg az előző visszavonást', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Ellenőrizze a tartalmat', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'Szemét', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'Ismeretlen',
			'Today'       : 'Ma',
			'Yesterday'   : 'Tegnap',
			'msJan'       : 'jan',
			'msFeb'       : 'febr',
			'msMar'       : 'márc',
			'msApr'       : 'ápr',
			'msMay'       : 'máj',
			'msJun'       : 'jún',
			'msJul'       : 'júl',
			'msAug'       : 'aug',
			'msSep'       : 'szept',
			'msOct'       : 'okt',
			'msNov'       : 'nov',
			'msDec'       : 'dec',
			'January'     : 'January',
			'February'    : 'February',
			'March'       : 'March',
			'April'       : 'April',
			'May'         : 'May',
			'June'        : 'June',
			'July'        : 'July',
			'August'      : 'August',
			'September'   : 'September',
			'October'     : 'October',
			'November'    : 'November',
			'December'    : 'December',
			'Sunday'      : 'Sunday',
			'Monday'      : 'Monday',
			'Tuesday'     : 'Tuesday',
			'Wednesday'   : 'Wednesday',
			'Thursday'    : 'Thursday',
			'Friday'      : 'Friday',
			'Saturday'    : 'Saturday',
			'Sun'         : 'Sun',
			'Mon'         : 'Mon',
			'Tue'         : 'Tue',
			'Wed'         : 'Wed',
			'Thu'         : 'Thu',
			'Fri'         : 'Fri',
			'Sat'         : 'Sat',

			/******************************** sort variants ********************************/
			'sortname'          : 'név szerint',
			'sortkind'          : 'típus szerint',
			'sortsize'          : 'méret szerint',
			'sortdate'          : 'dátum szerint',
			'sortFoldersFirst'  : 'Először a mappák',
			'sortperm'          : 'engedéllyel', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'üzemmódban',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'tulajdonos által',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'csoportonként',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'szintén Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'Új mappa',   // added 10.11.2015
			'Archive'           : 'Új Archívum',  // from v2.1 added 10.11.2015
			'untitled file'     : 'NewFile.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: fájl',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Megerősítés szükséges',
			'confirmRm'       : 'Valóban törölni akarja a kijelölt adatokat?<br/>Ez később nem fordítható vissza!',
			'confirmRepl'     : 'Cserélje a régi fájlt egy újra?',
			'confirmRest'     : 'Cserélje meglévő elemet az elem a kukában?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Nincs az UTF-8-ban <br/> Átalakítás UTF-8-ra? <br/> A tartalom átalakítás után mentéssel UTF-8 lesz.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'A fájl karakterkódolása nem található. A szerkesztés érdekében ideiglenesen UTF-8-ra kell konvertálnia. <br/> Kérjük, válassza ki a fájl karakterkódolását.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Módosították. <br/> Munkahelyi veszteség, ha nem menti a módosításokat.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Biztosan áthelyezi az elemeket a kukába?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Biztosan áthelyezi az elemeket a (z) "$1" mappába?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Alkalmazzon mindenkit',
			'name'            : 'Név',
			'size'            : 'Méret',
			'perms'           : 'Jogok',
			'modify'          : 'Módosítva',
			'kind'            : 'Típus',
			'read'            : 'olvasás',
			'write'           : 'írás',
			'noaccess'        : '-',
			'and'             : 'és',
			'unknown'         : 'ismeretlen',
			'selectall'       : 'Összes kijelölése',
			'selectfiles'     : 'Fájlok kijelölése',
			'selectffile'     : 'Első fájl kijelölése',
			'selectlfile'     : 'Utolsó fájl kijelölése',
			'viewlist'        : 'Lista nézet',
			'viewicons'       : 'Ikon nézet',
			'viewSmall'       : 'Kis ikonok', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Közepes ikonok', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Nagy ikonok', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Extra nagy ikonok', // from v2.1.39 added 22.5.2018
			'places'          : 'Helyek',
			'calc'            : 'Számítani',
			'path'            : 'Útvonal',
			'aliasfor'        : 'Cél',
			'locked'          : 'Zárolt',
			'dim'             : 'Méretek',
			'files'           : 'Fájlok',
			'folders'         : 'Mappák',
			'items'           : 'Elemek',
			'yes'             : 'igen',
			'no'              : 'nem',
			'link'            : 'Parancsikon',
			'searcresult'     : 'Keresés eredménye',
			'selected'        : 'kijelölt elemek',
			'about'           : 'Névjegy',
			'shortcuts'       : 'Gyorsbillenytyűk',
			'help'            : 'Súgó',
			'webfm'           : 'Web fájlkezelő',
			'ver'             : 'Verzió',
			'protocolver'     : 'protokol verzió',
			'homepage'        : 'Projekt honlap',
			'docs'            : 'Dokumentáció',
			'github'          : 'Hozz létre egy új verziót a Github-on',
			'twitter'         : 'Kövess minket a twitter-en',
			'facebook'        : 'Csatlakozz hozzánk a facebook-on',
			'team'            : 'Csapat',
			'chiefdev'        : 'vezető fejlesztő',
			'developer'       : 'fejlesztő',
			'contributor'     : 'külsős hozzájáruló',
			'maintainer'      : 'karbantartó',
			'translator'      : 'fordító',
			'icons'           : 'Ikonok',
			'dontforget'      : 'törölközőt ne felejts el hozni!',
			'shortcutsof'     : 'parancsikonok tiltva',
			'dropFiles'       : 'Fájlok dobása ide',
			'or'              : 'vagy',
			'selectForUpload' : 'fájlok böngészése',
			'moveFiles'       : 'Fájlok áthelyezése',
			'copyFiles'       : 'Fájlok másolása',
			'restoreFiles'    : 'elemek visszaállítása', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Távolítsa el a helyekről',
			'aspectRatio'     : 'Képarány',
			'scale'           : 'Skála',
			'width'           : 'Szélesség',
			'height'          : 'Magasság',
			'resize'          : 'Átméretezés',
			'crop'            : 'termés',
			'rotate'          : 'forgat',
			'rotate-cw'       : 'Forgassa 90 fokkal CW irányba',
			'rotate-ccw'      : 'Forgassa el 90 fokkal CCW',
			'degree'          : '°',
			'netMountDialogTitle' : 'Csatlakoztassa a hálózati kötetet', // added 18.04.2012
			'protocol'            : 'Protokoll', // added 18.04.2012
			'host'                : 'Házigazda', // added 18.04.2012
			'port'                : 'Kikötő', // added 18.04.2012
			'user'                : 'Felhasználó', // added 18.04.2012
			'pass'                : 'Jelszó', // added 18.04.2012
			'confirmUnmount'      : 'Are you unmount $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Húzza vagy illessze be a fájlokat a böngészőből', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Húzza vagy illessze ide a fájlokat és URL-eket', // from v2.1 added 07.04.2014
			'encoding'        : 'Kódolás', // from v2.1 added 19.12.2014
			'locale'          : 'helyszín',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Cél: $ 1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Keresés bevitel alapján MIME típus', // from v2.1 added 22.5.2015
			'owner'           : 'Tulajdonos', // from v2.1 added 20.6.2015
			'group'           : 'Csoport', // from v2.1 added 20.6.2015
			'other'           : 'Egyéb', // from v2.1 added 20.6.2015
			'execute'         : 'kivégez', // from v2.1 added 20.6.2015
			'perm'            : 'engedélyeket', // from v2.1 added 20.6.2015
			'mode'            : 'Mód', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mappa üres', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'A mappa üres \\ A Dobd el az elemeket', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'A mappa üres \\ Hosszú koppintás elemek hozzáadásához', // from v2.1.6 added 30.12.2015
			'quality'         : 'Minőség', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Autómatikus szinkronizálás',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Mozgás felfelé',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Get URL link', // from v2.1.7 added 9.2.2016
			'share'           : 'Részvény',
			'selectedItems'   : 'Kiválasztott elemek ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'Mappa azonosítója', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Offline hozzáférés engedélyezése', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'Újrahitelesítéshez', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Most betöltődik ...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Több fájl megnyitása', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Megpróbálja megnyitni a $ 1 fájlokat. Biztosan meg szeretné nyitni a böngészőben?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Search results is empty', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'You are editing a file.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Az Ön által kiválasztott $1 elem.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : '$1 elem van a vágólapon.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Az inkrementális keresés csak az aktuális nézetből származik.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'visszahelyez', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 teljes', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Kontextus menü', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Page turning', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Kötetgyökerek', // from v2.1.16 added 16.9.2016
			'reset'           : 'visszaad', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Háttérszín', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Színválasztó', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px Grid', // from v2.1.16 added 4.10.2016
			'enabled'         : 'képessé tesz', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Tiltva', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'A keresési eredmények az aktuális nézetben üresek. \\ A A keresési cél kibontásához nyomja meg az [Enter] gombot.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Az első betű találatokat üres a jelenlegi nézetben.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Szöveges címke', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '$1 perc van hátra', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Nyissa meg újra a kiválasztott kódolással', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Mentés a kiválasztott kódolással', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Mappa kiválasztása', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Első betű keresés', // from v2.1.23 added 24.3.2017
			'presets'         : 'Presets', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Túl sok elem, így nem kerülhet a kukába.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Ürítse ki a (z) "$1" mappát.', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'Nincsenek elemek a (z) "$1" mappában.', // from v2.1.25 added 22.6.2017
			'preference'      : 'Előny', // from v2.1.26 added 28.6.2017
			'language'        : 'Nyelv', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Inicializálja a böngészőbe mentett beállításokat', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Eszköztár beállításai', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $1 karakter maradt.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $1 sor maradt.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Összeg', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Durva fájlméret', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Fókuszban az elem a párbeszédablak egérráhelyezés',  // from v2.1.30 added 2.11.2017
			'select'          : 'választ', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Művelet a fájl kiválasztásakor', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Megnyitás a legutóbb használt szerkesztővel', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Kijelölés megfordítása', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Biztosan át akar nevezni $1 kijelölt elemet, például $2? <br/> Ezt nem lehet visszavonni!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Kötegelt átnevezés', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Szám', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Add előtag', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Utótag hozzáadása', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Bővítmény módosítása', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Oszlopok beállításait (Lista nézet)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Minden változás azonnal tükröződik az archívumban.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'A változtatások csak a kötet csatolásának visszavonásakor jelennek meg.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'The following volume(s) mounted on this volume also unmounted. Are you sure to unmount it?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Kiválasztási információk', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Algoritmusok, hogy bemutassák a fájl hash', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Információs elemek (Kijelölési információs panel)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'A kilépéshez nyomja meg újra.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Eszköztár', // from v2.1.38 added 4.4.2018
			'workspace'       : 'munkatér', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Párbeszédpanel', // from v2.1.38 added 4.4.2018
			'all'             : 'Összes', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Ikonméret (Ikonok nézet)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Nyissa meg a maximális szerkesztő ablak', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Mivel az API szerinti átalakítás jelenleg nem érhető el, kérjük, konvertáljon a webhelyen.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Az átalakítás után, akkor kell lennie feltölteni a tétel URL, vagy egy letöltött fájl menteni a konvertált fájlt.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Átalakítani az oldalon $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Integrációk', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'Ez elFinder a következő külső szolgáltatások integrált. Kérjük, mielőtt felhasználná, ellenőrizze a felhasználási feltételeket, az adatvédelmi irányelveket stb.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Rejtett elemek megjelenítése', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'Kódszerkesztő',
			'hideHidden'      : 'Rejtett elemek elrejtése', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Rejtett elemek megjelenítése / elrejtése', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Az "Új fájl" használatával engedélyezhető fájltípusok', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'A szövegfájl típusa', // from v2.1.41 added 7.8.2018
			'add'             : 'Hozzáadás', // from v2.1.41 added 7.8.2018
			'theme'           : 'téma', // from v2.1.43 added 19.10.2018
			'default'         : 'Alapértelmezett', // from v2.1.43 added 19.10.2018
			'description'     : 'Leírás', // from v2.1.43 added 19.10.2018
			'website'         : 'Weboldal', // from v2.1.43 added 19.10.2018
			'author'          : 'Szerző', // from v2.1.43 added 19.10.2018
			'email'           : 'Email', // from v2.1.43 added 19.10.2018
			'license'         : 'Engedély', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Ez az elem nem menthető. Ahhoz, hogy ne veszítse el a módosításokat meg kell export a számítógépre.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Kattintson duplán a fájlra a kiválasztásához.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Használja a teljes képernyős mód', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Ismeretlen',
			'kindRoot'        : 'Kötetgyökér', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Mappa',
			'kindSelects'     : 'kiválasztás', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Parancsikon',
			'kindAliasBroken' : 'Hibás parancsikon',
			// applications
			'kindApp'         : 'Alkalmazás',
			'kindPostscript'  : 'Postscript dokumentum',
			'kindMsOffice'    : 'Microsoft Office dokumentum',
			'kindMsWord'      : 'Microsoft Word dokumentum',
			'kindMsExcel'     : 'Microsoft Excel dokumentum',
			'kindMsPP'        : 'Microsoft Powerpoint bemutató',
			'kindOO'          : 'Open Office dokumentum',
			'kindAppFlash'    : 'Flash alkalmazás',
			'kindPDF'         : 'Hordozható dokumentum formátum (PDF)',
			'kindTorrent'     : 'Bittorrent fájl',
			'kind7z'          : '7z archívum',
			'kindTAR'         : 'TAR archívum',
			'kindGZIP'        : 'GZIP archívum',
			'kindBZIP'        : 'BZIP archívum',
			'kindXZ'          : 'XZ archívum',
			'kindZIP'         : 'ZIP archívum',
			'kindRAR'         : 'RAR archívum',
			'kindJAR'         : 'Java JAR fájl',
			'kindTTF'         : 'True Type font',
			'kindOTF'         : 'Open Type font',
			'kindRPM'         : 'RPM csomag',
			// texts
			'kindText'        : 'Szöveges dokumentum',
			'kindTextPlain'   : 'Egyszerű szöveg',
			'kindPHP'         : 'PHP forráskód',
			'kindCSS'         : 'Lépcsőzetes stíluslap',
			'kindHTML'        : 'HTML dokumentum',
			'kindJS'          : 'Javascript forráskód',
			'kindRTF'         : 'Rich Text formátum',
			'kindC'           : 'C forráskód',
			'kindCHeader'     : 'C header forráskód',
			'kindCPP'         : 'C++ forráskód',
			'kindCPPHeader'   : 'C++ header forráskód',
			'kindShell'       : 'Unix shell script',
			'kindPython'      : 'Python forráskód',
			'kindJava'        : 'Java forráskód',
			'kindRuby'        : 'Ruby forráskód',
			'kindPerl'        : 'Perl script',
			'kindSQL'         : 'SQL forráskód',
			'kindXML'         : 'XML dokumentum',
			'kindAWK'         : 'AWK forráskód',
			'kindCSV'         : 'Vesszővel elválasztott értékek',
			'kindDOCBOOK'     : 'Docbook XML dokumentum',
			'kindMarkdown'    : 'Markdown szöveg', // added 20.7.2015
			// images
			'kindImage'       : 'Kép',
			'kindBMP'         : 'BMP kép',
			'kindJPEG'        : 'JPEG kép',
			'kindGIF'         : 'GIF kép',
			'kindPNG'         : 'PNG kép',
			'kindTIFF'        : 'TIFF kép',
			'kindTGA'         : 'TGA kép',
			'kindPSD'         : 'Adobe Photoshop kép',
			'kindXBITMAP'     : 'X bitmap image',
			'kindPXM'         : 'Pixelmator image',
			// media
			'kindAudio'       : 'Hangfájl',
			'kindAudioMPEG'   : 'MPEG hangfájl',
			'kindAudioMPEG4'  : 'MPEG-4 hangfájl',
			'kindAudioMIDI'   : 'MIDI hangfájl',
			'kindAudioOGG'    : 'Ogg Vorbis hangfájl',
			'kindAudioWAV'    : 'WAV hangfájl',
			'AudioPlaylist'   : 'MP3 lejátszási lista',
			'kindVideo'       : 'Film',
			'kindVideoDV'     : 'DV film',
			'kindVideoMPEG'   : 'MPEG film',
			'kindVideoMPEG4'  : 'MPEG-4 film',
			'kindVideoAVI'    : 'AVI film',
			'kindVideoMOV'    : 'Quick Time film',
			'kindVideoWM'     : 'Windows Media film',
			'kindVideoFlash'  : 'Flash film',
			'kindVideoMKV'    : 'Matroska film',
			'kindVideoOGG'    : 'Ogg film'
		}
	};
}));