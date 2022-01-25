/**
 * Croatian translation
 * @version 2020-08-26
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
	elFinder.prototype.i18.hr = {
		translator : '',
		language   : 'Croatian',
		direction  : 'ltr',
		dateFormat : 'd.m.Y. H:i', // will show like: 26.08.2020. 14:47
		fancyDateFormat : '$1 H:i', // will show like: Danas 14:47
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200826-144756
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'Greška',
			'errUnknown'           : 'Nepoznata greška.',
			'errUnknownCmd'        : 'Nepoznata naredba.',
			'errJqui'              : 'Kriva jQuery UI konfiguracija. Selectable, draggable, i droppable komponente moraju biti uključene.',
			'errNode'              : 'elFinder zahtjeva DOM element da bi bio stvoren.',
			'errURL'               : 'Krivo konfiguriran elFinder. Opcija URL nije postavljena.',
			'errAccess'            : 'Zabranjen pristup.',
			'errConnect'           : 'Nije moguće spajanje na server.',
			'errAbort'             : 'Prekinuta veza.',
			'errTimeout'           : 'Veza je istekla.',
			'errNotFound'          : 'Server nije pronađen.',
			'errResponse'          : 'Krivi odgovor servera.',
			'errConf'              : 'Krivo konfiguriran server',
			'errJSON'              : 'Nije instaliran PHP JSON modul.',
			'errNoVolumes'         : 'Disk nije dostupan.',
			'errCmdParams'         : 'Krivi parametri za naredbu "$1".',
			'errDataNotJSON'       : 'Podaci nisu tipa JSON.',
			'errDataEmpty'         : 'Nema podataka.',
			'errCmdReq'            : 'Backend request requires command name.',
			'errOpen'              : 'Ne mogu otvoriti "$1".',
			'errNotFolder'         : 'Objekt nije mapa.',
			'errNotFile'           : 'Objekt nije dokument.',
			'errRead'              : 'Ne mogu pročitati "$1".',
			'errWrite'             : 'Ne mogu pisati u "$1".',
			'errPerm'              : 'Pristup zabranjen',
			'errLocked'            : '"$1" je zaključan i ne može biti preimenovan, premješten ili obrisan.',
			'errExists'            : 'Dokument s imenom "$1" već postoji.',
			'errInvName'           : 'Krivo ime dokumenta',
			'errInvDirname'        : 'Invalid folder name.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Mapa nije pronađena',
			'errFileNotFound'      : 'Dokument nije pronađen',
			'errTrgFolderNotFound' : 'Mapa "$1" nije pronađena',
			'errPopup'             : 'Browser prevented opening popup window. To open file enable it in browser options.',
			'errMkdir'             : 'Ne mogu napraviti mapu "$1".',
			'errMkfile'            : 'Ne mogu napraviti dokument "$1".',
			'errRename'            : 'Ne mogu preimenovati "$1".',
			'errCopyFrom'          : 'Kopiranje s diska "$1" nije dozvoljeno.',
			'errCopyTo'            : 'Kopiranje na disk "$1" nije dozvoljeno.',
			'errMkOutLink'         : 'Unable to create a link to outside the volume root.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Greška pri prebacivanju dokumenta na server.',  // old name - errUploadCommon
			'errUploadFile'        : 'Ne mogu prebaciti "$1" na server', // old name - errUpload
			'errUploadNoFiles'     : 'Nema dokumenata za prebacivanje na server',
			'errUploadTotalSize'   : 'Dokumenti prelaze maksimalnu dopuštenu veličinu.', // old name - errMaxSize
			'errUploadFileSize'    : 'Dokument je prevelik.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Ovaj tip dokumenta nije dopušten.',
			'errUploadTransfer'    : '"$1" greška pri prebacivanju',
			'errUploadTemp'        : 'Ne mogu napraviti privremeni dokument za prijenos na server', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Object "$1" already exists at this location and can not be replaced by object with another type.', // new
			'errReplace'           : 'Ne mogu zamijeniti "$1".',
			'errSave'              : 'Ne mogu spremiti "$1".',
			'errCopy'              : 'Ne mogu kopirati "$1".',
			'errMove'              : 'Ne mogu premjestiti "$1".',
			'errCopyInItself'      : 'Ne mogu kopirati "$1" na isto mjesto.',
			'errRm'                : 'Ne mogu ukloniti "$1".',
			'errTrash'             : 'Nije moguće u smeće.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Ne mogu ukloniti izvorni kod.',
			'errExtract'           : 'Nije moguće izdvojiti datoteke iz "$1".',
			'errArchive'           : 'Nije moguće kreirati arhivu.',
			'errArcType'           : 'Nepodržani tip arhive.',
			'errNoArchive'         : 'Datoteka nije arhiva ili ima nepodržani tip arhiva.',
			'errCmdNoSupport'      : 'Backend ne podržava ovu naredbu.',
			'errReplByChild'       : 'Mapu "$1" ne može zamijeniti stavka koju sadrži.',
			'errArcSymlinks'       : 'Iz sigurnosnih razloga uskraćena raspakirati arhivu sadrži simboličke veze ili datoteke s nije dozvoljeno imenima.', // edited 24.06.2012
			'errArcMaxSize'        : 'Arhiv datoteka prelazi maksimalno dozvoljenu veličinu.',
			'errResize'            : 'U nemogućnosti da resize "$1".',
			'errResizeDegree'      : 'Nevažeći stepen rotacije.',  // added 7.3.2013
			'errResizeRotate'      : 'Nije moguće rotirati sliku.',  // added 7.3.2013
			'errResizeSize'        : 'Nevažeća veličina slike.',  // added 7.3.2013
			'errResizeNoChange'    : 'Veličina slike nije promenjena.',  // added 7.3.2013
			'errUsupportType'      : 'Nepodržani tip datoteke.',
			'errNotUTF8Content'    : 'Datoteka "$1" nije u UTF-8 i ne može se uređivati.',  // added 9.11.2011
			'errNetMount'          : 'Nije moguće montirati "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'Nepodržani protokol.',     // added 17.04.2012
			'errNetMountFailed'    : 'Mount nije uspio.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Domaćin je obavezan.', // added 18.04.2012
			'errSessionExpires'    : 'Vaša sesija je istekla zbog neaktivnosti.',
			'errCreatingTempDir'   : 'Privremeni direktorij nije moguće stvoriti: "$1"',
			'errFtpDownloadFile'   : 'Preuzimanje datoteke s FTP-a nije moguće: "$1"',
			'errFtpUploadFile'     : 'Nije moguće učitati datoteku na FTP: "$1"',
			'errFtpMkdir'          : 'Nije moguće kreirati udaljeni direktorij na FTP-u: "$1"',
			'errArchiveExec'       : 'Pogreška tokom arhiviranja datoteka: "$1"',
			'errExtractExec'       : 'Pogreška prilikom vađenja datoteka: "$1"',
			'errNetUnMount'        : 'Ne može se isključiti', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Nije pretvarač u UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Isprobajte Google Chrome, Ako želite učitati mapu.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Isteklo dok u potrazi "$1". Rezultat pretrage je djelomičan.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Ponovna autorizacija je potrebno.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Maksimalan broj stavki koje je moguće birati je $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Vraćanje iz smeća nije moguće. Ne može da identifikuje vratiti odredište.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Uređivač nije pronađen za ovu vrstu datoteke.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Došlo je do pogreške na strani servera.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Nije moguće isprazniti mapu "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Postoji još $1 grešaka.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Arhiviraj',
			'cmdback'      : 'Nazad',
			'cmdcopy'      : 'Kopiraj',
			'cmdcut'       : 'Izreži',
			'cmddownload'  : 'Preuzmi',
			'cmdduplicate' : 'Dupliciraj',
			'cmdedit'      : 'Uredi dokument',
			'cmdextract'   : 'Raspakiraj arhivu',
			'cmdforward'   : 'Naprijed',
			'cmdgetfile'   : 'Odaberi dokumente',
			'cmdhelp'      : 'O programu',
			'cmdhome'      : 'Početak',
			'cmdinfo'      : 'Informacije',
			'cmdmkdir'     : 'Nova mapa',
			'cmdmkdirin'   : 'U novu mapu', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Nova файл',
			'cmdopen'      : 'Otvori',
			'cmdpaste'     : 'Zalijepi',
			'cmdquicklook' : 'Pregled',
			'cmdreload'    : 'Ponovo učitaj',
			'cmdrename'    : 'Preimenuj',
			'cmdrm'        : 'Obriši',
			'cmdtrash'     : 'Into trash', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Restore', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Pronađi',
			'cmdup'        : 'Roditeljska mapa',
			'cmdupload'    : 'Prebaci dokumente na server',
			'cmdview'      : 'Pregledaj',
			'cmdresize'    : 'Promjeni veličinu i rotiraj',
			'cmdsort'      : 'Sortiraj',
			'cmdnetmount'  : 'Spoji se na mrežni disk', // added 18.04.2012
			'cmdnetunmount': 'Odspoji disk', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Do Mjesta', // added 28.12.2014
			'cmdchmod'     : 'Promenite režim', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Otvori mapu', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Reset širinu kolone', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Cijeli ekran', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'potez', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Ispraznite mapu', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Poništi', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'ponovo uraditi', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'preferencija', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Odaberite sve', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Ne odaberite nijednu', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Invert izbor', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Otvori u novom prozoru', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Sakriti (preferencija)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Zatvori',
			'btnSave'   : 'Spremi',
			'btnRm'     : 'Ukloni',
			'btnApply'  : 'Primjeni',
			'btnCancel' : 'Odustani',
			'btnNo'     : 'Ne',
			'btnYes'    : 'Da',
			'btnMount'  : 'Mount',  // added 18.04.2012
			'btnApprove': 'Goto $1 & approve', // from v2.1 added 26.04.2012
			'btnUnmount': 'Unmount', // from v2.1 added 30.04.2012
			'btnConv'   : 'Pretvoriti', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Evo',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Volumen',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Sve',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME Tip', // from v2.1 added 22.5.2015
			'btnFileName':'Ime dokumenta',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Spremi i zatvori', // from v2.1 added 12.6.2015
			'btnBackup' : 'Rezervna kopija', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Preimenuj',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Preimenuj(Sve)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Prethodna ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Sljedeći ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Spremi kao', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Otvori mapu',
			'ntffile'     : 'Otvori dokument',
			'ntfreload'   : 'Ponovo učitaj sadržaj mape',
			'ntfmkdir'    : 'Radim mapu',
			'ntfmkfile'   : 'Radim dokumente',
			'ntfrm'       : 'Brišem dokumente',
			'ntfcopy'     : 'Kopiram dokumente',
			'ntfmove'     : 'Mičem dokumente',
			'ntfprepare'  : 'Priprema za kopiranje dokumenata',
			'ntfrename'   : 'Preimenuj dokumente',
			'ntfupload'   : 'Pohranjujem dokumente na server',
			'ntfdownload' : 'Preuzimam dokumente',
			'ntfsave'     : 'Spremi dokumente',
			'ntfarchive'  : 'Radim arhivu',
			'ntfextract'  : 'Extracting files from archive',
			'ntfsearch'   : 'Tražim dokumente',
			'ntfresize'   : 'Promjena veličine slike',
			'ntfsmth'     : 'Učini nešto',
			'ntfloadimg'  : 'Učitavam sliku',
			'ntfnetmount' : 'Mounting network volume', // added 18.04.2012
			'ntfnetunmount': 'Unmounting network volume', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Stjecanje dimenzije slike', // added 20.05.2013
			'ntfreaddir'  : 'Čita informacije folder', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Dobivanje URL veze', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Promjena načina rada datoteke', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Provera upload ime datoteke', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Izrada datoteke za preuzimanje', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Dobivanje informacija o stazi', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Obradu dodate datoteke', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Doing throw in the trash', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Vraćanje iz smeća', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Provjera odredišne mape', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Poništavanje prethodna operacija', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'ponovo uraditi prethodnog poništenog', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Provjera sadržaja', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'Otpad', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'nepoznato',
			'Today'       : 'Danas',
			'Yesterday'   : 'Jučer',
			'msJan'       : 'Sij',
			'msFeb'       : 'Vel',
			'msMar'       : 'Ožu',
			'msApr'       : 'Tra',
			'msMay'       : 'Svi',
			'msJun'       : 'Lip',
			'msJul'       : 'Srp',
			'msAug'       : 'Kol',
			'msSep'       : 'Ruj',
			'msOct'       : 'Lis',
			'msNov'       : 'Stu',
			'msDec'       : 'Pro',
			'January'     : 'Siječanj',
			'February'    : 'Veljača',
			'March'       : 'Ožujak',
			'April'       : 'Travanj',
			'May'         : 'Svibanj',
			'June'        : 'Lipanj',
			'July'        : 'Srpanj',
			'August'      : 'Kolovoz',
			'September'   : 'Rujan',
			'October'     : 'Listopad',
			'November'    : 'Studeni',
			'December'    : 'Prosinac',
			'Sunday'      : 'Nedjelja',
			'Monday'      : 'Ponedjeljak',
			'Tuesday'     : 'Utorak',
			'Wednesday'   : 'Srijeda',
			'Thursday'    : 'Četvrtak',
			'Friday'      : 'Petak',
			'Saturday'    : 'Subota',
			'Sun'         : 'Ned',
			'Mon'         : 'Pon',
			'Tue'         : 'Uto',
			'Wed'         : 'Sri',
			'Thu'         : 'Čet',
			'Fri'         : 'Pet',
			'Sat'         : 'Sub',

			/******************************** sort variants ********************************/
			'sortname'          : 'po imenu',
			'sortkind'          : 'po tipu',
			'sortsize'          : 'po veličini',
			'sortdate'          : 'po datumu',
			'sortFoldersFirst'  : 'Prvo mape',
			'sortperm'          : 'uz dozvolu', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'by mode',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'by owner',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'by group',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Takođe Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NoviDokument.txt', // added 10.11.2015
			'untitled folder'   : 'NovaMapa',   // added 10.11.2015
			'Archive'           : 'NovaArhiva',  // from v2.1 added 10.11.2015
			'untitled file'     : 'NewFile.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: File',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Potvrda',
			'confirmRm'       : 'Jeste li sigurni?',
			'confirmRepl'     : 'Zamijeni stare dokumente novima?',
			'confirmRest'     : 'Zamijenite postojeću stavku stavkom u smeću?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Nisu u UTF-8 <br/> Pretvori u UTF-8? <br/> Sadržaj postaje UTF-8 spremanjem nakon konverzije.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Kodiranje ove datoteke ne može se prepoznati. Treba ga privremeno pretvoriti u UTF-8 radi uređivanja. <br/> Molimo odaberite šifriranje znakova ove datoteke.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Izmijenjeno je. <br/> Izgubivanje posla ako ne spremite promjene.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Jeste li sigurni da želite premjestiti predmete u kantu za smeće?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Jeste li sigurni da želite premjestiti stavke u "$1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Primjeni na sve ',
			'name'            : 'Ime',
			'size'            : 'Veličina',
			'perms'           : 'Dozvole',
			'modify'          : 'Modificiran',
			'kind'            : 'Tip',
			'read'            : 'čitanje',
			'write'           : 'pisanje',
			'noaccess'        : 'bez pristupa',
			'and'             : 'i',
			'unknown'         : 'nepoznato',
			'selectall'       : 'Odaberi sve',
			'selectfiles'     : 'Odaberi dokument(e)',
			'selectffile'     : 'Odaberi prvi dokument',
			'selectlfile'     : 'Odaberi zadnji dokument',
			'viewlist'        : 'Lista',
			'viewicons'       : 'Ikone',
			'viewSmall'       : 'Small icons', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Medium icons', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Large icons', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Extra large icons', // from v2.1.39 added 22.5.2018
			'places'          : 'Mjesta',
			'calc'            : 'Računaj',
			'path'            : 'Put',
			'aliasfor'        : 'Drugo ime za',
			'locked'          : 'Zaključano',
			'dim'             : 'Dimenzije',
			'files'           : 'Dokumenti',
			'folders'         : 'Mape',
			'items'           : 'Items',
			'yes'             : 'da',
			'no'              : 'ne',
			'link'            : 'poveznica',
			'searcresult'     : 'Rezultati pretrage',
			'selected'        : 'selected items',
			'about'           : 'Info',
			'shortcuts'       : 'Prečaci',
			'help'            : 'Pomoć',
			'webfm'           : 'Web file manager',
			'ver'             : 'Verzija',
			'protocolver'     : 'protocol version',
			'homepage'        : 'Project home',
			'docs'            : 'Dokumentacija',
			'github'          : 'Fork us on Github',
			'twitter'         : 'Follow us on twitter',
			'facebook'        : 'Join us on facebook',
			'team'            : 'Tim',
			'chiefdev'        : 'glavni developer',
			'developer'       : 'developer',
			'contributor'     : 'contributor',
			'maintainer'      : 'maintainer',
			'translator'      : 'translator',
			'icons'           : 'Ikone',
			'dontforget'      : 'and don\'t forget to take your towel',
			'shortcutsof'     : 'Prečaci isključeni',
			'dropFiles'       : 'Ovdje ispusti dokumente',
			'or'              : 'ili',
			'selectForUpload' : 'Odaberi dokumente koje prebacuješ na server',
			'moveFiles'       : 'Premjesti dokumente',
			'copyFiles'       : 'Kopiraj dokumente',
			'restoreFiles'    : 'Vrati stavke', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Uklonite sa mjesta',
			'aspectRatio'     : 'Aspect ratio',
			'scale'           : 'Skaliraj',
			'width'           : 'Širina',
			'height'          : 'Visina',
			'resize'          : 'Promenite veličinu',
			'crop'            : 'Rezati',
			'rotate'          : 'Rotirajte',
			'rotate-cw'       : 'Rotirajte 90 stepeni CW',
			'rotate-ccw'      : 'Rotirajte 90 stepeni CCW',
			'degree'          : '°',
			'netMountDialogTitle' : 'Mount network volume', // added 18.04.2012
			'protocol'            : 'Protokol', // added 18.04.2012
			'host'                : 'Domaćin', // added 18.04.2012
			'port'                : 'Port', // added 18.04.2012
			'user'                : 'User', // added 18.04.2012
			'pass'                : 'Password', // added 18.04.2012
			'confirmUnmount'      : 'Are you unmount $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Ispusti ili zalijepi datoteke iz pregledača', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Ovdje baci ili zalijepi datoteke i URL-ove', // from v2.1 added 07.04.2014
			'encoding'        : 'Encoding', // from v2.1 added 19.12.2014
			'locale'          : 'Locale',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Target: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Traži unosom MIME tipa', // from v2.1 added 22.5.2015
			'owner'           : 'Vlasnik', // from v2.1 added 20.6.2015
			'group'           : 'Grupa', // from v2.1 added 20.6.2015
			'other'           : 'Other', // from v2.1 added 20.6.2015
			'execute'         : 'Izvrši', // from v2.1 added 20.6.2015
			'perm'            : 'Dozvole', // from v2.1 added 20.6.2015
			'mode'            : 'Mode', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mapa je prazna', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Mapa je prazna\\A Dovuci dokumente koje želiš dodati', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Mapa je prazna\\A Pritisni dugo za dodavanje dokumenata', // from v2.1.6 added 30.12.2015
			'quality'         : 'Kvaliteta', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Auto sync',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Gore',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Get URL link', // from v2.1.7 added 9.2.2016
			'share'           : 'Podijeli',
			'selectedItems'   : 'Odabrani predmeti ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'Folder ID', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Omogući izvanmrežni pristup', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'To re-authenticate', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Now loading...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Open multiple files', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'You are trying to open the $1 files. Are you sure you want to open in browser?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Rezultati pretraživanja su prazni u cilju pretraživanja.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Uređuje datoteku.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Odabrali ste stavke $1.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'Imate $1 stavke u međuspremnik.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Postepena pretraga je samo iz trenutnog pogleda.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'Vratite se', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 kompletni', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Kontekstni meni', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Okretanje stranice', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Korijeni volumen', // from v2.1.16 added 16.9.2016
			'reset'           : 'Resetovati', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Boja pozadine', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Birač boja', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px Grid', // from v2.1.16 added 4.10.2016
			'enabled'         : 'Omogućeno', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Onemogućeno', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Rezultati pretraživanja su u trenutnom prikazu prazni. \\ Pritisnite [Enter] za proširenje cilja pretraživanja.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Rezultati pretraživanja prvog slova u trenutnom prikazu su prazni.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'tekst etiketa', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '$1 mins left', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Ponovo otvorite s odabranim kodiranjem', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Spremite s odabranim kodiranjem', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Odaberite fasciklu', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Pretraživanje prvog slova', // from v2.1.23 added 24.3.2017
			'presets'         : 'Presets', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Previše je predmeta pa ne može u smeće.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Ispraznite mapu "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'U mapi nema stavki "$1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'preferencija', // from v2.1.26 added 28.6.2017
			'language'        : 'Jezik', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Inicijalizirajte postavke sačuvane u ovom pretraživaču', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Podešavanja Alatne trake', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $1 znakova lijevo.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $1 linije lijevo.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Sum', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Gruba veličina datoteke', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Usredotočite se na element dijaloga prelaskom miša',  // from v2.1.30 added 2.11.2017
			'select'          : 'Odaberite', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Radnja kada odaberete datoteku', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Otvori s urednikom koji je posljednji put korišten', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Invert izbor', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Jeste li sigurni da želite preimenovati $1 odabrane stavke poput $2? <br/> Ovo se ne može poništiti!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Skupno preimenovanje', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Broj', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Dodajte prefiks', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Dodajte sufiks', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Promena proširenja', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Podešavanja stupaca (List view)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Sve promjene će se odmah odraziti na arhivu.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Sve promjene neće se odraziti dok ne uklonite ovaj volumen.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'Sljedeći volumen (i) montirani na ovom volumenu također su isključeni. Sigurno ga isključite?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Informacije o izboru', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Algoritmi da pokaže hash datoteku', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Info stavke (Info ploča o izboru)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Pritisnite ponovo za izlaz.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Alatna traka', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Radni prostor', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Dialog', // from v2.1.38 added 4.4.2018
			'all'             : 'Sve', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Veličina ikone (Ikone pogled)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Otvorite maksimalni prozor za uređivanje', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Budući da konverzija po API-ju trenutno nije dostupna, molimo vas da pretvorite na web mjestu.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'After conversion, you must be upload with the item URL or a downloaded file to save the converted file.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Convert on the site of $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Integrations', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'This elFinder has the following external services integrated. Please check the terms of use, privacy policy, etc. before using it.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Pokaži skrivene stavke', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'Uređivač koda',
			'hideHidden'      : 'Sakrij skrivene stavke', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Pokaži/Sakrij skrivene stavke', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Vrste datoteka koje možete omogućiti s "Nova datoteka"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Tip Tekst datoteke', // from v2.1.41 added 7.8.2018
			'add'             : 'Dodati', // from v2.1.41 added 7.8.2018
			'theme'           : 'Tema', // from v2.1.43 added 19.10.2018
			'default'         : 'Podrazumevano', // from v2.1.43 added 19.10.2018
			'description'     : 'Opis', // from v2.1.43 added 19.10.2018
			'website'         : 'Website', // from v2.1.43 added 19.10.2018
			'author'          : 'Author', // from v2.1.43 added 19.10.2018
			'email'           : 'Email', // from v2.1.43 added 19.10.2018
			'license'         : 'License', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Stavka se ne može spremiti. Da biste izbjegli promjene koje trebate izvesti na svoj PC.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Dvaput kliknite na datoteku da biste je odabrali.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Koristite način rada preko cijelog ekrana', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Nepoznato',
			'kindRoot'        : 'Volume Root', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Mapa',
			'kindSelects'     : 'selekcija', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Drugo ime',
			'kindAliasBroken' : 'Broken alias',
			// applications
			'kindApp'         : 'Aplikacija',
			'kindPostscript'  : 'Postscript document',
			'kindMsOffice'    : 'Microsoft Office dokument',
			'kindMsWord'      : 'Microsoft Word dokument',
			'kindMsExcel'     : 'Microsoft Excel dokument',
			'kindMsPP'        : 'Microsoft Powerpoint prezentacija',
			'kindOO'          : 'Open Office dokument',
			'kindAppFlash'    : 'Flash aplikacija',
			'kindPDF'         : 'Portable Document Format (PDF)',
			'kindTorrent'     : 'Bittorrent dokument',
			'kind7z'          : '7z arhiva',
			'kindTAR'         : 'TAR arhiva',
			'kindGZIP'        : 'GZIP arhiva',
			'kindBZIP'        : 'BZIP arhiva',
			'kindXZ'          : 'XZ arhiva',
			'kindZIP'         : 'ZIP arhiva',
			'kindRAR'         : 'RAR arhiva',
			'kindJAR'         : 'Java JAR dokument',
			'kindTTF'         : 'True Type font',
			'kindOTF'         : 'Open Type font',
			'kindRPM'         : 'RPM paket',
			// texts
			'kindText'        : 'Tekst arhiva',
			'kindTextPlain'   : 'Obični tekst',
			'kindPHP'         : 'PHP izvor',
			'kindCSS'         : 'Kaskadni list stilova',
			'kindHTML'        : 'HTML dokument',
			'kindJS'          : 'Javascript izvor',
			'kindRTF'         : 'Format obogaćenog teksta',
			'kindC'           : 'C izvor',
			'kindCHeader'     : 'C zaglavlje izvor',
			'kindCPP'         : 'C++ izvor',
			'kindCPPHeader'   : 'C++ zaglavlje izvor',
			'kindShell'       : 'Unix shell script',
			'kindPython'      : 'Python izvor',
			'kindJava'        : 'Java izvor',
			'kindRuby'        : 'Ruby izvor',
			'kindPerl'        : 'Perl skripta',
			'kindSQL'         : 'SQL izvor',
			'kindXML'         : 'XML dokument',
			'kindAWK'         : 'AWK izvor',
			'kindCSV'         : 'vrijednosti razdvojene zarezom',
			'kindDOCBOOK'     : 'Docbook XML dokument',
			'kindMarkdown'    : 'Markdown tekst', // added 20.7.2015
			// images
			'kindImage'       : 'slika',
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
			'kindAudio'       : 'Audio',
			'kindAudioMPEG'   : 'MPEG audio',
			'kindAudioMPEG4'  : 'MPEG-4 audio',
			'kindAudioMIDI'   : 'MIDI audio',
			'kindAudioOGG'    : 'Ogg Vorbis audio',
			'kindAudioWAV'    : 'WAV audio',
			'AudioPlaylist'   : 'MP3 lista',
			'kindVideo'       : 'Video ',
			'kindVideoDV'     : 'DV video',
			'kindVideoMPEG'   : 'MPEG video',
			'kindVideoMPEG4'  : 'MPEG-4 video',
			'kindVideoAVI'    : 'AVI video',
			'kindVideoMOV'    : 'Quick Time video',
			'kindVideoWM'     : 'Windows Media video',
			'kindVideoFlash'  : 'Flash video',
			'kindVideoMKV'    : 'Matroska video',
			'kindVideoOGG'    : 'Ogg video'
		}
	};
}));