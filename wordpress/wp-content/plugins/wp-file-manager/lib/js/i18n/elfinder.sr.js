/**
 * Srpski translation
 * @author Momčilo m0k1 Mićanović <moki.forum@gmail.com>
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
	elFinder.prototype.i18.sr = {
		translator : 'Momčilo m0k1 Mićanović &lt;moki.forum@gmail.com&gt;',
		language   : 'Srpski',
		direction  : 'ltr',
		dateFormat : 'd.m.Y H:i', // will show like: 02.09.2020 18:10
		fancyDateFormat : '$1 H:i', // will show like: Danas 18:10
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200902-181047
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'Greška',
			'errUnknown'           : 'Nepoznata greška.',
			'errUnknownCmd'        : 'Nepoznata komanda.',
			'errJqui'              : 'Neispravna konfiguracija jQuery UI. Komponente koje mogu da se odabiru, povlače, izbacuju moraju biti uključene.',
			'errNode'              : 'elFinder zahteva DOM Element da bude kreiran.',
			'errURL'               : 'Neispravna elFinder konfiguracija! URL opcija nije postavljena.',
			'errAccess'            : 'Pristup odbijen.',
			'errConnect'           : 'Nije moguće povezivanje s skriptom.',
			'errAbort'             : 'Veza prekinuta.',
			'errTimeout'           : 'Veza odbačena.',
			'errNotFound'          : 'Skripta nije pronađena.',
			'errResponse'          : 'Neispravan odgovor skripte.',
			'errConf'              : 'Neispravna konfiguracija skripte.',
			'errJSON'              : 'PHP JSON modul nije instaliran.',
			'errNoVolumes'         : 'Vidljivi volumeni nisu dostupni.',
			'errCmdParams'         : 'Nevažeći parametri za komandu "$1".',
			'errDataNotJSON'       : 'Podaci nisu JSON.',
			'errDataEmpty'         : 'Podaci nisu prazni.',
			'errCmdReq'            : 'Skripta zahteva komandu.',
			'errOpen'              : 'Nemoguće otvoriti "$1".',
			'errNotFolder'         : 'Objekat nije folder.',
			'errNotFile'           : 'Objekat nije datoteka.',
			'errRead'              : 'Nemoguće pročitati "$1".',
			'errWrite'             : 'Nemoguće pisati u "$1".',
			'errPerm'              : 'Dozvola je odbijena.',
			'errLocked'            : '"$1" je zaključan i nemože biti preimenovan, premešten ili obrisan.',
			'errExists'            : 'Datoteka zvana "$1" već postoji.',
			'errInvName'           : 'Neispravno ime datoteke.',
			'errInvDirname'        : 'Nevažeće ime mape.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Folder nije pronađen.',
			'errFileNotFound'      : 'Datoteka nije pronađena.',
			'errTrgFolderNotFound' : 'Izabrani folder "$1" nije pronađen.',
			'errPopup'             : 'Pretraživač sprečava otvaranje iskačućih prozora. Da otvorite datoteku uključite iskačuće prozore u opcijama pretraživača.',
			'errMkdir'             : 'Nemoguće kreirati folder "$1".',
			'errMkfile'            : 'Nemoguće kreirati datoteku "$1".',
			'errRename'            : 'Nemoguće preimenovati datoteku "$1".',
			'errCopyFrom'          : 'Kopiranje datoteki sa "$1" nije dozvoljeno.',
			'errCopyTo'            : 'Kopiranje datoteki na "$1" nije dozvoljeno.',
			'errMkOutLink'         : 'Nije moguće stvoriti vezu za izvan volumena korijena.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Greska pri slanju.',  // old name - errUploadCommon
			'errUploadFile'        : 'Nemoguće poslati "$1".', // old name - errUpload
			'errUploadNoFiles'     : 'Nisu pronađene datoteke za slanje.',
			'errUploadTotalSize'   : 'Podaci premašuju najveću dopuštenu veličinu.', // old name - errMaxSize
			'errUploadFileSize'    : 'Datoteka premašuje najveću dopuštenu veličinu.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Vrsta datoteke nije dopuštena.',
			'errUploadTransfer'    : '"$1" greška prilikom slanja.',
			'errUploadTemp'        : 'Nije moguće napraviti privremenu datoteku za prijenos.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Objekt "$1" već postoji na ovom mjestu i ne može se zamijeniti objektom s drugom vrstom.', // new
			'errReplace'           : 'Nije moguće zamijeniti "$1".',
			'errSave'              : 'Nemožeš sačuvati "$1".',
			'errCopy'              : 'Nemožeš kopirati "$1".',
			'errMove'              : 'Nemožeš premestiti "$1".',
			'errCopyInItself'      : 'Nemožeš kopirati "$1" na istu lokaciju.',
			'errRm'                : 'Nemožeš obrisati "$1".',
			'errTrash'             : 'nije u mogućnosti smeće.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Uklanjanje izvornih datoteka nije moguće.',
			'errExtract'           : 'Nemoguće izvaditi datoteke iz "$1".',
			'errArchive'           : 'Nemoguće kreirati arhivu.',
			'errArcType'           : 'Nepodržani tip arhive.',
			'errNoArchive'         : 'Datoteka nije arhiva ili je nepodržani tip arhive.',
			'errCmdNoSupport'      : 'Skripta nepodržava ovu komandu.',
			'errReplByChild'       : 'Folder “$1” ne može biti zamenut stavkom koju sadrži.',
			'errArcSymlinks'       : 'Zbog bezbednosnih razloga ne možete raspakovati arhive koje sadrže simboličke veze ili datoteke sa nedozvoljenim imenima.', // edited 24.06.2012
			'errArcMaxSize'        : 'Arhiva je dostigla maksimalnu veličinu.',
			'errResize'            : 'Nemoguće promeniti veličinu "$1".',
			'errResizeDegree'      : 'Nevažeći stupanj okretanja.',  // added 7.3.2013
			'errResizeRotate'      : 'Nije moguće rotirati sliku.',  // added 7.3.2013
			'errResizeSize'        : 'Nevažeća veličina slike.',  // added 7.3.2013
			'errResizeNoChange'    : 'Veličina slike nije promijenjena.',  // added 7.3.2013
			'errUsupportType'      : 'nepodržan tip datoteke.',
			'errNotUTF8Content'    : 'Datoteka "$1" nije u UTF-8  formati i ne može biti izmenjena.',  // added 9.11.2011
			'errNetMount'          : 'Nije moguće montirati "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'Nepodržani protokol.',     // added 17.04.2012
			'errNetMountFailed'    : 'Montiranje neuspelo.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Host je potreban.', // added 18.04.2012
			'errSessionExpires'    : 'Vaša je sesija istekla zbog neaktivnosti.',
			'errCreatingTempDir'   : 'Nije moguće stvoriti privremeni direktorij: "$1"',
			'errFtpDownloadFile'   : 'Nije moguće preuzeti datoteku s FTP-a: "$1"',
			'errFtpUploadFile'     : 'Nije moguće prenijeti datoteku na FTP: "$1"',
			'errFtpMkdir'          : 'Nije moguće stvoriti daljinski imenika na FTP: "$1"',
			'errArchiveExec'       : 'Pogreška prilikom arhiviranja datoteka: "$1"',
			'errExtractExec'       : 'Pogreška prilikom izdvajanja datoteka: "$1"',
			'errNetUnMount'        : 'Unable to unmount.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Nije kabriolet u UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Isprobajte moderni preglednik, ako želite prenijeti mapu.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Isteklo je vrijeme dok je traženje "$ 1". Rezultati pretraživanja su djelomični.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Potrebno je ponovno odobrenje.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Maksimalan broj predmeta koji se mogu odabrati je $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Nije moguće vratiti iz okvira za smeće. Nije moguće identificirati odredište za vraćanje.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Uređivač nije pronađen za ovu vrstu datoteke.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Došlo je do pogreške na strani poslužitelja.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Nije moguće isprazniti mapu "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Postoji još $1 pogrešaka.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Kreiraj arhivu',
			'cmdback'      : 'Nazad',
			'cmdcopy'      : 'Kopiraj',
			'cmdcut'       : 'Iseci',
			'cmddownload'  : 'Preuzmi',
			'cmdduplicate' : 'Dupliraj',
			'cmdedit'      : 'Izmeni datoteku',
			'cmdextract'   : 'Raspakuj arhivu',
			'cmdforward'   : 'Napred',
			'cmdgetfile'   : 'Izaberi datoteke',
			'cmdhelp'      : 'O ovom softveru',
			'cmdhome'      : 'Početna',
			'cmdinfo'      : 'Proveri informacije',
			'cmdmkdir'     : 'Novi folder',
			'cmdmkdirin'   : 'Unutar nove mape', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Nova datoteka',
			'cmdopen'      : 'Otvori',
			'cmdpaste'     : 'Zalepi',
			'cmdquicklook' : 'Pregledaj',
			'cmdreload'    : 'Povno učitaj',
			'cmdrename'    : 'Preimenuj',
			'cmdrm'        : 'Obriši',
			'cmdtrash'     : 'U smeće', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Vratiti', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Pronađi datoteke',
			'cmdup'        : 'Idi na nadređeni folder',
			'cmdupload'    : 'Pošalji datoteke',
			'cmdview'      : 'Pogledaj',
			'cmdresize'    : 'Promeni veličinu slike',
			'cmdsort'      : 'Sortiraj',
			'cmdnetmount'  : 'Montirajte mrežni volumen', // added 18.04.2012
			'cmdnetunmount': 'Unmount', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Na Mjesta', // added 28.12.2014
			'cmdchmod'     : 'Promijenite način rada', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Otvorite mapu', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Širina Reset stupac', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Puni zaslon', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Potez', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Ispraznite mapu', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Poništi', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'ponovo uraditi', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'preferencija', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Odaberi sve', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Odaberi nijedan', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Obrni odabir', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Otvori u novom prozoru', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Sakrij (preferencija)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Zatvori',
			'btnSave'   : 'Sačuvaj',
			'btnRm'     : 'Obriši',
			'btnApply'  : 'Potvrdi',
			'btnCancel' : 'Prekini',
			'btnNo'     : 'Ne',
			'btnYes'    : 'Da',
			'btnMount'  : 'Mount',  // added 18.04.2012
			'btnApprove': 'Idite na $1 i odobrite', // from v2.1 added 26.04.2012
			'btnUnmount': 'Unmount', // from v2.1 added 30.04.2012
			'btnConv'   : 'Pretvoriti', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Ovdje',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Volumen',    // from v2.1 added 22.5.2015
			'btnAll'    : 'svi',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME tip', // from v2.1 added 22.5.2015
			'btnFileName':'Naziv datoteke',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Spremi i zatvori', // from v2.1 added 12.6.2015
			'btnBackup' : 'Sigurnosna kopija', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Preimenovati',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Preimenuj (sve)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Prethodno ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Sljedeće ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Spremi kao', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Otvaranje foldera',
			'ntffile'     : 'Otvaranje datoteke',
			'ntfreload'   : 'Ponovo učitavanje sadržaja foldera',
			'ntfmkdir'    : 'Kreiranje foldera',
			'ntfmkfile'   : 'Kreiranje datoteke',
			'ntfrm'       : 'Brisanje datoteke',
			'ntfcopy'     : 'Kopiranje datoteke',
			'ntfmove'     : 'Premeštanje datoteke',
			'ntfprepare'  : 'Priprema za kopiranje dateoteke',
			'ntfrename'   : 'Primenovanje datoteke',
			'ntfupload'   : 'Slanje datoteke',
			'ntfdownload' : 'Preuzimanje datoteke',
			'ntfsave'     : 'Čuvanje datoteke',
			'ntfarchive'  : 'Kreiranje arhive',
			'ntfextract'  : 'Izdvajanje datoteka iz arhive',
			'ntfsearch'   : 'Pretraga datoteka',
			'ntfresize'   : 'Promjena veličine slika',
			'ntfsmth'     : 'Radim nešto >_<',
			'ntfloadimg'  : 'Učitavanje slike',
			'ntfnetmount' : 'Montiranje mrežnog volumena', // added 18.04.2012
			'ntfnetunmount': 'Unmounting network volume', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Stjecanje dimenzije slike', // added 20.05.2013
			'ntfreaddir'  : 'Čitanje podataka iz mape', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Dobivanje URL veze', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Promjena načina rada datoteke', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Provjera upload naziv datoteke', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Izrada datoteke za preuzimanje', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Dobivanje informacija o putu', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Obrada prenesene datoteke', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Radite Bacati u smeće', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'vraćanju iz smeća', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Provjera odredišne mape', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Poništavanje prethodne operacije', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Redoing previous undone', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Provjera sadržaja', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'šund', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'nepoznat',
			'Today'       : 'Danas',
			'Yesterday'   : 'Sutra',
			'msJan'       : 'Jan',
			'msFeb'       : 'Feb',
			'msMar'       : 'Mar',
			'msApr'       : 'Apr',
			'msMay'       : 'Maj',
			'msJun'       : 'Jun',
			'msJul'       : 'Jul',
			'msAug'       : 'Avg',
			'msSep'       : 'Sep',
			'msOct'       : 'Okt',
			'msNov'       : 'Nov',
			'msDec'       : 'Dec',
			'January'     : 'Januar',
			'February'    : 'Februar',
			'March'       : 'Mart',
			'April'       : 'April',
			'May'         : 'Maj',
			'June'        : 'Jun',
			'July'        : 'Jul',
			'August'      : 'Avgust',
			'September'   : 'Septembar',
			'October'     : 'Oktobar',
			'November'    : 'Novembar',
			'December'    : 'Decembar',
			'Sunday'      : 'Nedelja',
			'Monday'      : 'Ponedeljak',
			'Tuesday'     : 'Utorak',
			'Wednesday'   : 'Sreda',
			'Thursday'    : 'Četvrtak',
			'Friday'      : 'Petak',
			'Saturday'    : 'Subota',
			'Sun'         : 'Ned',
			'Mon'         : 'Pon',
			'Tue'         : 'Uto',
			'Wed'         : 'Sre',
			'Thu'         : 'Čet',
			'Fri'         : 'Pet',
			'Sat'         : 'Sub',

			/******************************** sort variants ********************************/
			'sortname'          : 'po imenu',
			'sortkind'          : 'po vrsti',
			'sortsize'          : 'po veličini',
			'sortdate'          : 'po datumu',
			'sortFoldersFirst'  : 'Prvo folderi',
			'sortperm'          : 'dopuštenjem', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'by mode',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'od strane vlasnika',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'po skupinama',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Također Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'Nova fascikla',   // added 10.11.2015
			'Archive'           : 'Nova arhiva',  // from v2.1 added 10.11.2015
			'untitled file'     : 'NewFile.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: Datoteka',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Potrebna potvrda',
			'confirmRm'       : 'Da li ste sigurni da želite da obrišete datoteke?<br/>Ovo se ne može poništiti!',
			'confirmRepl'     : 'Zameniti stare datoteke sa novima?',
			'confirmRest'     : 'Zamijenite postojeće stavke sa stavke u smeće?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Niste u UTF-8 <br/> Želite li pretvoriti u UTF-8? <br/> Sadržaj postaje UTF-8 spremanjem nakon pretvorbe.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Nije moguće otkriti kodiranje znakova ove datoteke. Treba ga privremeno pretvoriti u UTF-8 radi uređivanja. <br/> Odaberite kodiranje znakova ove datoteke.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Izmijenjen je. <br/> Gubitak posla ako ne spremite promjene.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Jeste li sigurni da želite premjestiti stavke u kantu za smeće?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Jeste li sigurni da želite premjestiti stavke na "$ 1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Potvrdi za sve',
			'name'            : 'Ime',
			'size'            : 'Veličina',
			'perms'           : 'Dozvole',
			'modify'          : 'Izmenjeno',
			'kind'            : 'Vrsta',
			'read'            : 'čitanje',
			'write'           : 'pisanje',
			'noaccess'        : 'bez pristupa',
			'and'             : 'i',
			'unknown'         : 'nepoznato',
			'selectall'       : 'Izaberi sve datoteke',
			'selectfiles'     : 'Izaberi datoteku(e)',
			'selectffile'     : 'Izaberi prvu datoteku',
			'selectlfile'     : 'Izaberi poslednju datoteku',
			'viewlist'        : 'Popisni prikaz',
			'viewicons'       : 'Pregled ikona',
			'viewSmall'       : 'Male ikone', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Srednje ikone', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Velike ikone', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Dodatni velike ikone', // from v2.1.39 added 22.5.2018
			'places'          : 'Mesta',
			'calc'            : 'Izračunaj',
			'path'            : 'Putanja',
			'aliasfor'        : 'Nadimak za',
			'locked'          : 'Zaključano',
			'dim'             : 'Dimenzije',
			'files'           : 'Datoteke',
			'folders'         : 'Folderi',
			'items'           : 'Stavke',
			'yes'             : 'da',
			'no'              : 'ne',
			'link'            : 'Veza',
			'searcresult'     : 'Rezultati pretrage',
			'selected'        : 'odabrane stavke',
			'about'           : 'O softveru',
			'shortcuts'       : 'Prečice',
			'help'            : 'Pomoć',
			'webfm'           : 'Web menađer datoteka',
			'ver'             : 'Verzija',
			'protocolver'     : 'verzija protokla',
			'homepage'        : 'Adresa projekta',
			'docs'            : 'Dokumentacija',
			'github'          : 'Forkuj nas na Github',
			'twitter'         : 'Prati nas na twitter',
			'facebook'        : 'Pridruži nam se na facebook',
			'team'            : 'Tim',
			'chiefdev'        : 'glavni programer',
			'developer'       : 'programer',
			'contributor'     : 'pomoćnik',
			'maintainer'      : 'održavatelj',
			'translator'      : 'prevodilac',
			'icons'           : 'Ikone',
			'dontforget'      : 'i ne zaboravite da ponesete peškir',
			'shortcutsof'     : 'Prečice isključene',
			'dropFiles'       : 'Prevucite datoteke ovde',
			'or'              : 'ili',
			'selectForUpload' : 'Odaberite datoteke za slanje',
			'moveFiles'       : 'Premesti datoteke',
			'copyFiles'       : 'Kopiraj datoteke',
			'restoreFiles'    : 'Vratite predmete', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Ukloni iz mesta',
			'aspectRatio'     : 'Omer širine i visine',
			'scale'           : 'Razmera',
			'width'           : 'Širina',
			'height'          : 'Visina',
			'resize'          : 'Promeni veličinu',
			'crop'            : 'Iseci',
			'rotate'          : 'Rotiraj',
			'rotate-cw'       : 'Rotiraj 90 stepeni CW',
			'rotate-ccw'      : 'Rotiraj 90 stepeni CCW',
			'degree'          : 'Stepeni',
			'netMountDialogTitle' : 'Montiraj mrežni volumen', // added 18.04.2012
			'protocol'            : 'Protokol', // added 18.04.2012
			'host'                : 'Domaćin', // added 18.04.2012
			'port'                : 'Luka', // added 18.04.2012
			'user'                : 'Korisničko Ime', // added 18.04.2012
			'pass'                : 'Lozinka', // added 18.04.2012
			'confirmUnmount'      : 'Are you unmount $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Ispustite ili zalijepite datoteke iz preglednika', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Ovdje ispustite datoteke, zalijepite URL-ove ili slike (međuspremnik)', // from v2.1 added 07.04.2014
			'encoding'        : 'Encoding', // from v2.1 added 19.12.2014
			'locale'          : 'Lokalno',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Cilj: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Pretraga po ulaznim MIME tip', // from v2.1 added 22.5.2015
			'owner'           : 'Vlasnik', // from v2.1 added 20.6.2015
			'group'           : 'Skupina', // from v2.1 added 20.6.2015
			'other'           : 'drugi', // from v2.1 added 20.6.2015
			'execute'         : 'Izvršiti', // from v2.1 added 20.6.2015
			'perm'            : 'Dopuštenje', // from v2.1 added 20.6.2015
			'mode'            : 'način', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mapa je prazna', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Mapa je prazna \\ A ispustite da biste dodali stavke', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Mapa je prazna \\ Dug dodir za dodavanje stavki', // from v2.1.6 added 30.12.2015
			'quality'         : 'Kvaliteta', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Automatska sinkronizacija',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Pomakni se gore',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Nabavite URL vezu', // from v2.1.7 added 9.2.2016
			'share'           : 'Dijeliti',
			'selectedItems'   : 'Odabrane stavke ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'fascikla ID', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Dopusti izvanmrežni pristup', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'Za ponovnu provjeru autentičnosti', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Sada se učitava ...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Otvorite više datoteka', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Pokušavate otvoriti datoteke od $1. Jeste li sigurni da želite otvoriti u pregledniku?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Rezultati pretraživanja prazni su u cilju pretraživanja.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Uređuje datoteku.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Odabrali ste $1 predmeta.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'U međuspremniku imate stavke od $1.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Inkrementalno pretraživanje vrši se samo iz trenutnog prikaza.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'ponovo postaviti', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 je završena', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Kontekstni izbornik', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'okretanje stranica', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Korijeni volumena', // from v2.1.16 added 16.9.2016
			'reset'           : 'Resetirati', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Boja pozadine', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Birač boja', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px rešetka', // from v2.1.16 added 4.10.2016
			'enabled'         : 'Omogućeno', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Onemogućeno', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Rezultati pretraživanja prazni su u trenutnom prikazu. \\ A Pritisnite [Enter] da biste proširili cilj pretraživanja.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Prvo slovo rezultati pretraživanja je prazna u trenutnom prikazu.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Oznaka teksta', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '$1 Preostalo minuta:', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Ponovo otvorite s odabranim kodiranjem', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Spremi s odabranim kodiranjem', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Odaberite mapu', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Pretraživanje prvog slova', // from v2.1.23 added 24.3.2017
			'presets'         : 'Presets', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'To je previše predmeta pa se ne može u smeće.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Ispraznite mapu "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'U mapi "$1" nema stavki.', // from v2.1.25 added 22.6.2017
			'preference'      : 'preferencija', // from v2.1.26 added 28.6.2017
			'language'        : 'Jezik', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Inicijalizirajte postavke spremljene u ovom pregledniku', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Postavke alatne trake', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $1 znakova lijevo.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $1 linije lijevo.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'suma', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Gruba veličina datoteke', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Usredotočite se na element dijaloškog okvira s pomicanjem miša',  // from v2.1.30 added 2.11.2017
			'select'          : 'Odaberi', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Akcija prilikom odabira datoteke', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Otvorite pomoću uređivača korištenog prošli put', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Obrni odabir', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Jeste li sigurni da želite preimenovati $1 odabrane stavke poput $2? <br/> To se ne može poništiti!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Batch rename', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Broj', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Dodaj prefiks', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Dodaj sufiks', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Promjena proširenja', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Postavke stupaca (prikaz popisa)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Sve promjene odmah će se odraziti na arhivu.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Sve promjene neće se odraziti dok ne deinstalirate ovaj volumen.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'Sljedeći volumen (i) montirani na ovaj volumen također su demontirani. Jeste li sigurni da ga morate demontirati?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Informacije o odabiru', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Algoritmi za prikaz heša datoteke', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Info Stavke (Izbor Info ploča)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Pritisnite ponovno za izlaz.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Alatna traka', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Radni prostor', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Dijaloški okvir', // from v2.1.38 added 4.4.2018
			'all'             : 'svi', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Veličina ikone (prikaz ikona)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Otvorite maksimizirani prozor uređivača', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Budući da pretvorbu API trenutno nije dostupan, molimo pretvoriti na web stranici.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Nakon pretvorbe, morate biti upload s URL-točke ili preuzete datoteke za spremanje pretvoriti datoteku.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Pretvorite na web mjesto od $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Integracije', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'Ovaj elFinder ima integrirane sljedeće vanjske usluge. Molimo provjerite uvjete korištenja, pravila o privatnosti itd. Prije nego što ih upotrijebite.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Prikaži skrivene stavke', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'Uređivač koda',
			'hideHidden'      : 'Sakrij skrivene stavke', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Prikaži / sakrij skrivene stavke', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Vrste datoteka koje treba omogućiti pomoću "Nova datoteka"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Vrsta tekstualne datoteke', // from v2.1.41 added 7.8.2018
			'add'             : 'Dodati', // from v2.1.41 added 7.8.2018
			'theme'           : 'Tema', // from v2.1.43 added 19.10.2018
			'default'         : 'Zadano', // from v2.1.43 added 19.10.2018
			'description'     : 'Opis', // from v2.1.43 added 19.10.2018
			'website'         : 'Web stranica', // from v2.1.43 added 19.10.2018
			'author'          : 'Autor', // from v2.1.43 added 19.10.2018
			'email'           : 'Email', // from v2.1.43 added 19.10.2018
			'license'         : 'Licenca', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Ovu stavku nije moguće spremiti. Da biste izbjegli gubitak uređivanja, morate izvesti na računalo.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Dvaput kliknite datoteku da biste je odabrali.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Upotrijebite način cijelog zaslona', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Nepoznat',
			'kindRoot'        : 'Korijen volumena', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'fascikla',
			'kindSelects'     : 'Odabir', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Nadimak',
			'kindAliasBroken' : 'Neispravan nadimak',
			// applications
			'kindApp'         : 'Aplikacija',
			'kindPostscript'  : 'Postscript dokument',
			'kindMsOffice'    : 'Microsoft Office dokument',
			'kindMsWord'      : 'Microsoft Word dokument',
			'kindMsExcel'     : 'Microsoft Excel dokument',
			'kindMsPP'        : 'Microsoft Powerpoint prezentacija',
			'kindOO'          : 'Open Office dokument',
			'kindAppFlash'    : 'Flash aplikacija',
			'kindPDF'         : 'Prijenosni format dokumenta (PDF)',
			'kindTorrent'     : 'Bittorrent datoteka',
			'kind7z'          : '7z arhiva',
			'kindTAR'         : 'TAR arhiva',
			'kindGZIP'        : 'GZIP arhiva',
			'kindBZIP'        : 'BZIP arhiva',
			'kindXZ'          : 'XZ arhiva',
			'kindZIP'         : 'ZIP arhiva',
			'kindRAR'         : 'RAR arhiva',
			'kindJAR'         : 'Java JAR datoteka',
			'kindTTF'         : 'True Type font',
			'kindOTF'         : 'Open Type font',
			'kindRPM'         : 'RPM paket',
			// texts
			'kindText'        : 'Teokstualni dokument',
			'kindTextPlain'   : 'Čist tekst',
			'kindPHP'         : 'PHP kod',
			'kindCSS'         : 'CSS kod',
			'kindHTML'        : 'HTML dokument',
			'kindJS'          : 'Javascript kod',
			'kindRTF'         : 'Format obogaćenog teksta',
			'kindC'           : 'C kod',
			'kindCHeader'     : 'C header kod',
			'kindCPP'         : 'C++ kod',
			'kindCPPHeader'   : 'C++ header kod',
			'kindShell'       : 'Unix shell skripta',
			'kindPython'      : 'Python kod',
			'kindJava'        : 'Java kod',
			'kindRuby'        : 'Ruby kod',
			'kindPerl'        : 'Perl skripta',
			'kindSQL'         : 'SQL kod',
			'kindXML'         : 'XML dokument',
			'kindAWK'         : 'AWK kod',
			'kindCSV'         : 'Vrijednosti odvojene zarezom',
			'kindDOCBOOK'     : 'Docbook XML dokument',
			'kindMarkdown'    : 'Markdown text', // added 20.7.2015
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
			'kindAudio'       : 'Zvuk',
			'kindAudioMPEG'   : 'MPEG zvuk',
			'kindAudioMPEG4'  : 'MPEG-4 zvuk',
			'kindAudioMIDI'   : 'MIDI zvuk',
			'kindAudioOGG'    : 'Ogg Vorbis zvuk',
			'kindAudioWAV'    : 'WAV zvuk',
			'AudioPlaylist'   : 'MP3 lista',
			'kindVideo'       : 'Video',
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