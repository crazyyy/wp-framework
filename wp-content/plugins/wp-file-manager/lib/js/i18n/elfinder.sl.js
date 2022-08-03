/**
 * Slovenščina translation
 * @author Damjan Rems <d_rems at yahoo.com>
 * @version 2022-03-03
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
	elFinder.prototype.i18.sl = {
		translator : 'Damjan Rems &lt;d_rems at yahoo.com&gt;',
		language   : 'Slovenščina',
		direction  : 'ltr',
		dateFormat : 'd.m.Y H:i', // will show like: 03.03.2022 12:34
		fancyDateFormat : '$1 H:i', // will show like: Danes 12:34
		nonameDateFormat : 'ymd-His', // noname upload will show like: 220303-123418
		messages   : {
			'getShareText' : 'Deliti',
			'Editor ': 'Urejevalnik kode',

			/********************************** errors **********************************/
			'error'                : 'Napaka',
			'errUnknown'           : 'Neznana napaka.',
			'errUnknownCmd'        : 'Neznan ukaz.',
			'errJqui'              : 'Napačna jQuery UI nastavitev. Selectable, draggable in droppable dodatki morajo biti vključeni.',
			'errNode'              : 'elFinder potrebuje "DOM Element".',
			'errURL'               : 'Napačna nastavitev elFinder-ja! Manjka URL nastavitev.',
			'errAccess'            : 'Dostop zavrnjen.',
			'errConnect'           : 'Ne morem se priključiti na "backend".',
			'errAbort'             : 'Povezava prekinjena (aborted).',
			'errTimeout'           : 'Povezava potekla (timeout).',
			'errNotFound'          : 'Nisem našel "backend-a".',
			'errResponse'          : 'Napačni "backend" odgovor.',
			'errConf'              : 'Napačna "backend" nastavitev.',
			'errJSON'              : 'JSON modul ni instaliran.',
			'errNoVolumes'         : 'Bralne količine niso na voljo.',
			'errCmdParams'         : 'Napačni parametri za ukaz "$1".',
			'errDataNotJSON'       : 'Podatki niso v JSON obliki.',
			'errDataEmpty'         : 'Ni podatkov oz. so prazni.',
			'errCmdReq'            : '"Backend" zahtevek potrebuje ime ukaza.',
			'errOpen'              : '"$1" ni možno odpreti.',
			'errNotFolder'         : 'Objekt ni mapa.',
			'errNotFile'           : 'Objekt ni datoteka.',
			'errRead'              : '"$1" ni možno brati.',
			'errWrite'             : 'Ne morem pisati v "$1".',
			'errPerm'              : 'Dostop zavrnjen.',
			'errLocked'            : '"$1" je zaklenjen(a) in je ni možno preimenovati, premakniti ali izbrisati.',
			'errExists'            : 'Datoteka z imenom "$1" že obstaja.',
			'errInvName'           : 'Napačno ime datoteke.',
			'errInvDirname'        : 'Neveljavno ime mape.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Mape nisem našel.',
			'errFileNotFound'      : 'Datoteke nisem našel.',
			'errTrgFolderNotFound' : 'Ciljna mapa "$1" ne obstaja.',
			'errPopup'             : 'Brskalnik je preprečil prikaz (popup) okna. Za vpogled datoteke omogočite nastavitev v vašem brskalniku.',
			'errMkdir'             : 'Ni možno dodati mape "$1".',
			'errMkfile'            : 'Ni možno dodati datoteke "$1".',
			'errRename'            : 'Ni možno preimenovati "$1".',
			'errCopyFrom'          : 'Kopiranje datotek iz "$1" ni dovoljeno.',
			'errCopyTo'            : 'Kopiranje datotek na "$1" ni dovoljeno.',
			'errMkOutLink'         : 'Povezave z izven korenskega nosilca ni mogoče ustvariti.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Napaka pri prenosu.',  // old name - errUploadCommon
			'errUploadFile'        : '"$1" ni možno naložiti (upload).', // old name - errUpload
			'errUploadNoFiles'     : 'Ni datotek za nalaganje (upload).',
			'errUploadTotalSize'   : 'Podatki presegajo največjo dovoljeno velikost.', // old name - errMaxSize
			'errUploadFileSize'    : 'Datoteka presega največjo dovoljeno velikost.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Datoteke s to končnico niso dovoljene.',
			'errUploadTransfer'    : '"$1" napaka pri prenosu.',
			'errUploadTemp'        : 'Ni mogoče ustvariti začasne datoteke za nalaganje.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Objekt "$1" že obstaja na tej lokaciji in ga ni mogoče nadomestiti s predmetom druge vrste.', // new
			'errReplace'           : '"$1" ni mogoče zamenjati.',
			'errSave'              : '"$1" ni možno shraniti.',
			'errCopy'              : '"$1" ni možno kopirati.',
			'errMove'              : '"$1" ni možno premakniti.',
			'errCopyInItself'      : '"$1" ni možno kopirati samo vase.',
			'errRm'                : '"$1" ni možno izbrisati.',
			'errTrash'             : 'Ni mogoče v smeti.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Izvornih datotek ni mogoče odstraniti.',
			'errExtract'           : 'Datotek iz "$1" ni možno odpakirati.',
			'errArchive'           : 'Napaka pri delanju arhiva.',
			'errArcType'           : 'Nepodprta vrsta arhiva.',
			'errNoArchive'         : 'Datoteka ni arhiv ali vrsta arhiva ni podprta.',
			'errCmdNoSupport'      : '"Backend" ne podpira tega ukaza.',
			'errReplByChild'       : 'Mape “$1” ni možno zamenjati z vsebino mape.',
			'errArcSymlinks'       : 'Zaradi varnostnih razlogov arhiva ki vsebuje "symlinks" ni možno odpakirati.', // edited 24.06.2012
			'errArcMaxSize'        : 'Datoteke v arhivu presegajo največjo dovoljeno velikost.',
			'errResize'            : '"$1" ni možno razširiti.',
			'errResizeDegree'      : 'Neveljavna stopnja vrtenja.',  // added 7.3.2013
			'errResizeRotate'      : 'Slike ni mogoče zasukati.',  // added 7.3.2013
			'errResizeSize'        : 'Neveljavna velikost slike.',  // added 7.3.2013
			'errResizeNoChange'    : 'Velikost slike ni spremenjena.',  // added 7.3.2013
			'errUsupportType'      : 'Nepodprta vrsta datoteke.',
			'errNotUTF8Content'    : 'Datoteka "$1" ni v UTF-8 in je ni mogoče urejati.',  // added 9.11.2011
			'errNetMount'          : '"$1" ni mogoče priklopiti.', // added 17.04.2012
			'errNetMountNoDriver'  : 'Nepodprt protokol.',     // added 17.04.2012
			'errNetMountFailed'    : 'Montaža ni uspela.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Potreben je gostitelj.', // added 18.04.2012
			'errSessionExpires'    : 'Vaša seja je potekla zaradi neaktivnosti.',
			'errCreatingTempDir'   : 'Ni mogoče ustvariti začasnega imenika: "$1"',
			'errFtpDownloadFile'   : 'Ni mogoče prenesti datoteke s FTP: "$1"',
			'errFtpUploadFile'     : 'Datoteke ni mogoče naložiti na FTP: "$1"',
			'errFtpMkdir'          : 'Ni mogoče ustvariti oddaljenega imenika na FTP: "$1"',
			'errArchiveExec'       : 'Napaka pri arhiviranju datotek: "$1"',
			'errExtractExec'       : 'Napaka pri ekstrakciji datotek: "$1"',
			'errNetUnMount'        : 'Ni mogoče odklopiti.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Ni mogoče pretvoriti v UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Preizkusite sodobni brskalnik, če želite naložiti mapo.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Časovna omejitev je potekla med iskanjem »$1«. Rezultat iskanja je delen.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Potrebno je ponovno pooblastilo.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Največje število izbirnih elementov je 1 dolar.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Ni mogoče obnoviti iz koša. Cilja obnovitve ni mogoče določiti.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Urejevalnika za to vrsto datoteke ni bilo mogoče najti.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Na strani strežnika je prišlo do napake.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Ni mogoče izprazniti mape "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Obstaja še 1 $ napak.', // from v2.1.44 added 9.12.2018
			'errMaxMkdirs'         : 'Naenkrat lahko ustvarite do $1 map.', // from v2.1.58 added 20.6.2021

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Naredi arhiv',
			'cmdback'      : 'Nazaj',
			'cmdcopy'      : 'Kopiraj',
			'cmdcut'       : 'Izreži',
			'cmddownload'  : 'Poberi (download)',
			'cmdduplicate' : 'Podvoji',
			'cmdedit'      : 'Uredi datoteko',
			'cmdextract'   : 'Odpakiraj datoteke iz arhiva',
			'cmdforward'   : 'Naprej',
			'cmdgetfile'   : 'Izberi datoteke',
			'cmdhelp'      : 'Več o',
			'cmdhome'      : 'Domov',
			'cmdinfo'      : 'Lastnosti',
			'cmdmkdir'     : 'Nova mapa',
			'cmdmkdirin'   : 'V novo mapo', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Nova datoteka',
			'cmdopen'      : 'Odpri',
			'cmdpaste'     : 'Prilepi',
			'cmdquicklook' : 'Hitri ogled',
			'cmdreload'    : 'Osveži',
			'cmdrename'    : 'Preimenuj',
			'cmdrm'        : 'Izbriši',
			'cmdtrash'     : 'V smeti', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Obnovi', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Poišči datoteke',
			'cmdup'        : 'Mapa nazaj',
			'cmdupload'    : 'Naloži (upload)',
			'cmdview'      : 'Ogled',
			'cmdresize'    : 'Povečaj (pomanjšaj) sliko',
			'cmdsort'      : 'Razvrsti',
			'cmdnetmount'  : 'Namestite omrežno glasnost', // added 18.04.2012
			'cmdnetunmount': 'Odklopi', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Na mesta', // added 28.12.2014
			'cmdchmod'     : 'Spremeni način', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Odprite mapo', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Ponastavi širino stolpca', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Celozaslonski način', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Premakni se', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Izpraznite mapo', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Razveljavi', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'Ponovi', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'Nastavitve', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Izberi vse', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Izberite nobenega', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Obrni izbor', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Odpri v novem oknu', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Skrij (nastavitev)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Zapri',
			'btnSave'   : 'Shrani',
			'btnRm'     : 'Izbriši',
			'btnApply'  : 'Uporabi',
			'btnCancel' : 'Prekliči',
			'btnNo'     : 'Ne',
			'btnYes'    : 'Da',
			'btnMount'  : 'Mount',  // added 18.04.2012
			'btnApprove': 'Pojdi na $1 in odobri', // from v2.1 added 26.04.2012
			'btnUnmount': 'Odklopi', // from v2.1 added 30.04.2012
			'btnConv'   : 'Pretvorba', // from v2.1 added 08.04.2014
			'btnCwd'    : 'tukaj',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Glasnost',    // from v2.1 added 22.5.2015
			'btnAll'    : 'vse',       // from v2.1 added 22.5.2015
			'btnMime'   : 'Vrsta MIME', // from v2.1 added 22.5.2015
			'btnFileName':'Ime datoteke',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Shrani in zapri', // from v2.1 added 12.6.2015
			'btnBackup' : 'Rezerva', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Preimenuj',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Preimenuj (vse)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Prejšnja (1 $/2 $)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Naslednji (1 $/2 $)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Shrani kot', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Odpri mapo',
			'ntffile'     : 'Odpri datoteko',
			'ntfreload'   : 'Osveži vsebino mape',
			'ntfmkdir'    : 'Ustvarjam mapo',
			'ntfmkfile'   : 'Ustvarjam datoteke',
			'ntfrm'       : 'Brišem datoteke',
			'ntfcopy'     : 'Kopiram datoteke',
			'ntfmove'     : 'Premikam datoteke',
			'ntfprepare'  : 'Pripravljam se na kopiranje datotek',
			'ntfrename'   : 'Preimenujem datoteke',
			'ntfupload'   : 'Nalagam (upload) datoteke',
			'ntfdownload' : 'Pobiram (download) datoteke',
			'ntfsave'     : 'Shranjujem datoteke',
			'ntfarchive'  : 'Ustvarjam arhiv',
			'ntfextract'  : 'Razpakiram datoteke iz arhiva',
			'ntfsearch'   : 'Iščem datoteke',
			'ntfresize'   : 'Spreminjanje velikosti slik',
			'ntfsmth'     : 'Počakaj delam >_<',
			'ntfloadimg'  : 'Nalagam sliko',
			'ntfnetmount' : 'Montaža omrežne glasnosti', // added 18.04.2012
			'ntfnetunmount': 'Odstranitev omrežnega nosilca', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Pridobivanje dimenzije slike', // added 20.05.2013
			'ntfreaddir'  : 'Branje informacij o mapi', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Pridobivanje URL-ja povezave', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Spreminjanje načina datoteke', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Preverjanje imena datoteke za nalaganje', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Ustvarjanje datoteke za prenos', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Pridobivanje informacij o poti', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Obdelava naložene datoteke', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Vrzi v smeti', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Obnovitev iz koša', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Preverjanje ciljne mape', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Razveljavitev prejšnje operacije', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Ponavljanje prejšnjega razveljavljenega', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Preverjanje vsebine', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'smeti', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'neznan',
			'Today'       : 'Danes',
			'Yesterday'   : 'Včeraj',
			'msJan'       : 'Jan',
			'msFeb'       : 'februarja',
			'msMar'       : 'mar',
			'msApr'       : 'apr',
			'msMay'       : 'Maj',
			'msJun'       : 'Jun',
			'msJul'       : 'jul',
			'msAug'       : 'Avg',
			'msSep'       : 'sep',
			'msOct'       : 'Okt',
			'msNov'       : 'nov',
			'msDec'       : 'dec',
			'January'     : 'Januar',
			'February'    : 'Februar',
			'March'       : 'Marec',
			'April'       : 'aprila',
			'May'         : 'Maj',
			'June'        : 'Junij',
			'July'        : 'Julij',
			'August'      : 'Avgust',
			'September'   : 'septembra',
			'October'     : 'Oktober',
			'November'    : 'novembra',
			'December'    : 'december',
			'Sunday'      : 'Nedelja',
			'Monday'      : 'Ponedeljek',
			'Tuesday'     : 'Torek',
			'Wednesday'   : 'Sreda',
			'Thursday'    : 'Četrtek',
			'Friday'      : 'Petek',
			'Saturday'    : 'Sobota',
			'Sun'         : 'Ned',
			'Mon'         : 'Pon',
			'Tue'         : 'Tor',
			'Wed'         : 'Sre',
			'Thu'         : 'Čet',
			'Fri'         : 'Pet',
			'Sat'         : 'Sob',

			/******************************** sort variants ********************************/
			'sortname'          : 'po imenu',
			'sortkind'          : 'po vrsti',
			'sortsize'          : 'po velikosti',
			'sortdate'          : 'po datumu',
			'sortFoldersFirst'  : 'Najprej mape',
			'sortperm'          : 'z dovoljenjem', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'po načinu',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 's strani lastnika',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'po skupini',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Tudi Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'Nova mapa',   // added 10.11.2015
			'Archive'           : 'NewArchive',  // from v2.1 added 10.11.2015
			'untitled file'     : 'Nova datoteka.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: datoteka',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '1 $: 2 $',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Zahtevana je potrditev',
			'confirmRm'       : 'Ste prepričani, da želite izbrisati datoteko?<br/>POZOR! Tega ukaza ni možno preklicati!',
			'confirmRepl'     : 'Zamenjam staro datoteko z novo?',
			'confirmRest'     : 'Ali želite obstoječi element zamenjati s predmetom v smetnjaku?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Ni v UTF-8<br/>Pretvoriti v UTF-8?<br/>Vsebina postane UTF-8 s shranjevanjem po pretvorbi.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Kodiranja znakov te datoteke ni bilo mogoče zaznati. Za urejanje ga je treba začasno pretvoriti v UTF-8.<br/>Prosimo, izberite kodiranje znakov te datoteke.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Spremenjeno je bilo.<br/>Če ne shranite sprememb, boste izgubili delo.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Ali ste prepričani, da želite premakniti predmete v koš za smeti?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Ali ste prepričani, da želite premakniti elemente v »$1«?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Uporabi pri vseh',
			'name'            : 'Ime',
			'size'            : 'Velikost',
			'perms'           : 'Dovoljenja',
			'modify'          : 'Spremenjeno',
			'kind'            : 'Vrsta',
			'read'            : 'beri',
			'write'           : 'piši',
			'noaccess'        : 'ni dostopa',
			'and'             : 'in',
			'unknown'         : 'neznan',
			'selectall'       : 'Izberi vse datoteke',
			'selectfiles'     : 'Izberi datotek(o)e',
			'selectffile'     : 'Izberi prvo datoteko',
			'selectlfile'     : 'Izberi zadnjo datoteko',
			'viewlist'        : 'Seznam',
			'viewicons'       : 'Ikone',
			'viewSmall'       : 'Majhne ikone', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Srednje ikone', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Velike ikone', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Izjemno velike ikone', // from v2.1.39 added 22.5.2018
			'places'          : 'Mesta (places)',
			'calc'            : 'Izračun',
			'path'            : 'Pot do',
			'aliasfor'        : 'Sopomenka (alias) za',
			'locked'          : 'Zaklenjeno',
			'dim'             : 'Dimenzije',
			'files'           : 'Datoteke',
			'folders'         : 'Mape',
			'items'           : 'Predmeti',
			'yes'             : 'da',
			'no'              : 'ne',
			'link'            : 'Povezava',
			'searcresult'     : 'Rezultati iskanja',
			'selected'        : 'izbrani predmeti',
			'about'           : 'Več o',
			'shortcuts'       : 'Bližnjice',
			'help'            : 'Pomoč',
			'webfm'           : 'Spletni upravitelj datotek',
			'ver'             : 'Verzija',
			'protocolver'     : 'verzija protokola',
			'homepage'        : 'Domača stran',
			'docs'            : 'Dokumentacija',
			'github'          : 'Fork us on Github',
			'twitter'         : 'Sledi na twitterju',
			'facebook'        : 'Pridruži se nam na facebook-u',
			'team'            : 'Tim',
			'chiefdev'        : 'Glavni razvijalec',
			'developer'       : 'razvijalec',
			'contributor'     : 'sodelavec',
			'maintainer'      : 'vzdrževalec',
			'translator'      : 'prevajalec',
			'icons'           : 'Ikone',
			'dontforget'      : 'In ne pozabi na brisačo',
			'shortcutsof'     : 'Bližnjica onemogočena',
			'dropFiles'       : 'Datoteke spusti tukaj',
			'or'              : 'ali',
			'selectForUpload' : 'Izberi datoteke za nalaganje',
			'moveFiles'       : 'Premakni datoteke',
			'copyFiles'       : 'Kopiraj datoteke',
			'restoreFiles'    : 'Obnovite predmete', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Izbriši iz mesta (places)',
			'aspectRatio'     : 'Razmerje slike',
			'scale'           : 'Razširi',
			'width'           : 'Širina',
			'height'          : 'Višina',
			'resize'          : 'Povečaj',
			'crop'            : 'Obreži',
			'rotate'          : 'Zavrti',
			'rotate-cw'       : 'Zavrti 90 st. v smeri ure',
			'rotate-ccw'      : 'Zavrti 90 st. v obratni smeri ure',
			'degree'          : 'Stopnja',
			'netMountDialogTitle' : 'Namestite omrežno glasnost', // added 18.04.2012
			'protocol'            : 'Protokol', // added 18.04.2012
			'host'                : 'Gostitelj', // added 18.04.2012
			'port'                : 'pristanišče', // added 18.04.2012
			'user'                : 'Uporabnik', // added 18.04.2012
			'pass'                : 'Geslo', // added 18.04.2012
			'confirmUnmount'      : 'Ali odklopite $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Spustite ali prilepite datoteke iz brskalnika', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Sem spustite datoteke, prilepite URL-je ali slike (odložišče).', // from v2.1 added 07.04.2014
			'encoding'        : 'Kodiranje', // from v2.1 added 19.12.2014
			'locale'          : 'Locale',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Cilj: 1 dolar',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Iskanje po vhodni vrsti MIME', // from v2.1 added 22.5.2015
			'owner'           : 'Lastnik', // from v2.1 added 20.6.2015
			'group'           : 'Skupina', // from v2.1 added 20.6.2015
			'other'           : 'Drugo', // from v2.1 added 20.6.2015
			'execute'         : 'Izvedite', // from v2.1 added 20.6.2015
			'perm'            : 'dovoljenje', // from v2.1 added 20.6.2015
			'mode'            : 'način', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mapa je prazna', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Mapa je prazna\\A Spustite, da dodate elemente', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Mapa je prazna\\A Dolg tapnite, da dodate elemente', // from v2.1.6 added 30.12.2015
			'quality'         : 'Kakovost', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Samodejna sinhronizacija',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Pomakni se navzgor',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Pridobite URL povezavo', // from v2.1.7 added 9.2.2016
			'selectedItems'   : 'Izbrani predmeti (1 $)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'ID mape', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Dovoli dostop brez povezave', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'Za ponovno avtentikacijo', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Zdaj se nalaga ...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Odprite več datotek', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Poskušate odpreti datoteke $1. Ali ste prepričani, da želite odpreti v brskalniku?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Rezultati iskanja so prazni v iskalnem cilju.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Ureja datoteko.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Izbrali ste $1 predmetov.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'V odložišče imate 1 $ elementov.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Inkrementalno iskanje je samo iz trenutnega pogleda.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'Obnovi', // from v2.1.15 added 3.8.2016
			'complete'        : '1 $ dokončan', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Kontekstni meni', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Obračanje strani', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Volumenske korenine', // from v2.1.16 added 16.9.2016
			'reset'           : 'Ponastaviti', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Barva ozadja', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Izbirnik barv', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : 'Mreža 8px', // from v2.1.16 added 4.10.2016
			'enabled'         : 'Omogočeno', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Onemogočeno', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Rezultati iskanja so prazni v trenutnem pogledu.\\APritisnite [Enter], da razširite cilj iskanja.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Search results is empty in current view.\\APress [Enter] to expand search target.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Besedilna oznaka', // from v2.1.17 added 13.10.2016
			'minsLeft'        : 'Še 1 min', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Ponovno odprite z izbranim kodiranjem', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Shrani z izbranim kodiranjem', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Izberite mapo', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Iskanje prve črke', // from v2.1.23 added 24.3.2017
			'presets'         : 'Prednastavitve', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Preveč je predmetov, tako da ne gre v smeti.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Izpraznite mapo "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'V mapi "$1" ni elementov.', // from v2.1.25 added 22.6.2017
			'preference'      : 'Prednost', // from v2.1.26 added 28.6.2017
			'language'        : 'Jezik', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Inicializirajte nastavitve, shranjene v tem brskalniku', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Nastavitve orodne vrstice', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... ostane 1 znak.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... še $1 vrstice.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'vsota', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Približna velikost datoteke', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Osredotočite se na element pogovornega okna s pomikom miške',  // from v2.1.30 added 2.11.2017
			'select'          : 'Izberite', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Dejanje ob izbiri datoteke', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Odprite z nazadnje uporabljenim urejevalnikom', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Obrni izbor', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Ali ste prepričani, da želite preimenovati izbrane elemente $1, kot je $2?<br/>Tega ni mogoče razveljaviti!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Paketno preimenovanje', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Številka', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Dodajte predpono', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Dodajte pripono', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Spremeni razširitev', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Nastavitve stolpcev (pogled seznama)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Vse spremembe se bodo takoj odrazile v arhivu.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Vse spremembe se ne bodo odrazile, dokler ne odklopite tega nosilca.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'Naslednji nosilci, nameščeni na ta nosilec, so se prav tako odklopili. Ali ste prepričani, da ga boste odklopili?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Informacije o izbiri', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Algoritmi za prikaz hash datoteke', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Informacijski elementi (informacijska plošča za izbor)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Ponovno pritisnite za izhod.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Orodna vrstica', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Delovni prostor', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Dialog', // from v2.1.38 added 4.4.2018
			'all'             : 'vse', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Velikost ikone (pogled ikon)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Odprite okno povečanega urejevalnika', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Ker pretvorba prek API-ja trenutno ni na voljo, prosimo pretvorite na spletnem mestu.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Po pretvorbi morate biti naloženi z URL-jem elementa ali preneseno datoteko, da shranite pretvorjeno datoteko.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Pretvarjanje na spletnem mestu $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Integracije', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'Ta elFinder ima vgrajene naslednje zunanje storitve. Pred uporabo preverite pogoje uporabe, politiko zasebnosti itd.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Pokaži skrite predmete', // from v2.1.41 added 24.7.2018
			'hideHidden'      : 'Skrij skrite predmete', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Pokaži/skrij skrite predmete', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Vrste datotek, ki jih želite omogočiti z "Nova datoteka"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Vrsta besedilne datoteke', // from v2.1.41 added 7.8.2018
			'add'             : 'Dodaj', // from v2.1.41 added 7.8.2018
			'theme'           : 'Tema', // from v2.1.43 added 19.10.2018
			'default'         : 'Privzeto', // from v2.1.43 added 19.10.2018
			'description'     : 'Opis', // from v2.1.43 added 19.10.2018
			'website'         : 'Spletna stran', // from v2.1.43 added 19.10.2018
			'author'          : 'Avtor', // from v2.1.43 added 19.10.2018
			'email'           : 'E-naslov', // from v2.1.43 added 19.10.2018
			'license'         : 'Licenca', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Tega predmeta ni mogoče shraniti. Da ne bi izgubili popravkov, jih morate izvoziti v računalnik.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Dvokliknite datoteko, da jo izberete.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Uporabite celozaslonski način', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Neznan',
			'kindRoot'        : 'Korenski nosilec', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Mapa',
			'kindSelects'     : 'Izbori', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Sopomenka (alias)',
			'kindAliasBroken' : 'Nedelujoča sopomenka (alias)',
			// applications
			'kindApp'         : 'Program',
			'kindPostscript'  : 'Postscript dokument',
			'kindMsOffice'    : 'Microsoft Office dokument',
			'kindMsWord'      : 'Microsoft Word dokument',
			'kindMsExcel'     : 'Microsoft Excel dokument',
			'kindMsPP'        : 'Microsoft Powerpoint predstavitev',
			'kindOO'          : 'Open Office dokument',
			'kindAppFlash'    : 'Flash program',
			'kindPDF'         : 'Prenosni format dokumenta (PDF)',
			'kindTorrent'     : 'Bittorrent datoteka',
			'kind7z'          : '7z arhiv',
			'kindTAR'         : 'TAR arhiv',
			'kindGZIP'        : 'GZIP arhiv',
			'kindBZIP'        : 'BZIP arhiv',
			'kindXZ'          : 'XZ arhiv',
			'kindZIP'         : 'ZIP arhiv',
			'kindRAR'         : 'RAR arhiv',
			'kindJAR'         : 'Java JAR datoteka',
			'kindTTF'         : 'Pisava True Type',
			'kindOTF'         : 'Odprite pisavo Type',
			'kindRPM'         : 'RPM paket',
			// texts
			'kindText'        : 'Tekst dokument',
			'kindTextPlain'   : 'Samo tekst',
			'kindPHP'         : 'PHP koda',
			'kindCSS'         : 'Cascading style sheet (CSS)',
			'kindHTML'        : 'HTML dokument',
			'kindJS'          : 'Javascript koda',
			'kindRTF'         : 'Rich Text Format (RTF)',
			'kindC'           : 'C koda',
			'kindCHeader'     : 'C header koda',
			'kindCPP'         : 'C++ koda',
			'kindCPPHeader'   : 'C++ header koda',
			'kindShell'       : 'Unix shell skripta',
			'kindPython'      : 'Python kdoa',
			'kindJava'        : 'Java koda',
			'kindRuby'        : 'Ruby koda',
			'kindPerl'        : 'Perl skripta',
			'kindSQL'         : 'SQL koda',
			'kindXML'         : 'XML dokument',
			'kindAWK'         : 'AWK koda',
			'kindCSV'         : 'Besedilo ločeno z vejico (CSV)',
			'kindDOCBOOK'     : 'Docbook XML dokument',
			'kindMarkdown'    : 'Besedilo za znižanje vrednosti', // added 20.7.2015
			// images
			'kindImage'       : 'Slika',
			'kindBMP'         : 'BMP slika',
			'kindJPEG'        : 'JPEG slika',
			'kindGIF'         : 'GIF slika',
			'kindPNG'         : 'PNG slika',
			'kindTIFF'        : 'TIFF slika',
			'kindTGA'         : 'TGA slika',
			'kindPSD'         : 'Adobe Photoshop slika',
			'kindXBITMAP'     : 'X bitmap slika',
			'kindPXM'         : 'Pixelmator slika',
			// media
			'kindAudio'       : 'Avdio medija',
			'kindAudioMPEG'   : 'MPEG zvok',
			'kindAudioMPEG4'  : 'MPEG-4 zvok',
			'kindAudioMIDI'   : 'MIDI zvok',
			'kindAudioOGG'    : 'Ogg Vorbis zvok',
			'kindAudioWAV'    : 'WAV zvok',
			'AudioPlaylist'   : 'MP3 seznam',
			'kindVideo'       : 'Video medija',
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

