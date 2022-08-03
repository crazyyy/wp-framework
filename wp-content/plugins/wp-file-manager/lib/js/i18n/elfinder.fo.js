/**
 * Faroese translation
 * @author Marius Hammer <marius@vrg.fo>
 * @version 2022-03-01
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
	elFinder.prototype.i18.fo = {
		translator : 'Marius Hammer &lt;marius@vrg.fo&gt;',
		language   : 'Faroese',
		direction  : 'ltr',
		dateFormat : 'd.m.Y H:i', // will show like: 01.03.2022 11:44
		fancyDateFormat : '$1 H:i', // will show like: Í dag 11:44
		nonameDateFormat : 'ymd-His', // noname upload will show like: 220301-114438
		messages   : {
			'getShareText' : 'Deildu',
			'Editor ': 'Kóðaritill',
			/********************************** errors **********************************/
			'error'                : 'Villa íkomin',
			'errUnknown'           : 'Ókend villa.',
			'errUnknownCmd'        : 'Ókend boð.',
			'errJqui'              : 'Ógildig jQuery UI konfiguratión. Vælbærar, sum kunnu hálast runt og kunnu sleppast skulu takast við.',
			'errNode'              : 'elFinder krevur DOM Element stovna.',
			'errURL'               : 'Ugyldig elFinder konfiguration! URL stilling er ikki ásett.',
			'errAccess'            : 'Atgongd nokta.',
			'errConnect'           : 'Far ikki samband við backend.',
			'errAbort'             : 'Sambandi avbrotið.',
			'errTimeout'           : 'Sambandi broti av.',
			'errNotFound'          : 'Backend ikki funnið.',
			'errResponse'          : 'Ógildugt backend svar.',
			'errConf'              : 'Ógildugt backend konfiguratión.',
			'errJSON'              : 'PHP JSON modulið er ikki innstallera.',
			'errNoVolumes'         : 'Lesiligar mappur er ikki atkomulig.',
			'errCmdParams'         : 'Ógildigar stillingar fyri kommando "$1".',
			'errDataNotJSON'       : 'Dáta er ikki JSON.',
			'errDataEmpty'         : 'Dáta er tømt.',
			'errCmdReq'            : 'Backend krevur eitt kommando navn.',
			'errOpen'              : 'Kundi ikki opna "$1".',
			'errNotFolder'         : 'Luturin er ikki ein mappa.',
			'errNotFile'           : 'Luturin er ikki ein fíla.',
			'errRead'              : 'Kundi ikki lesa til "$1".',
			'errWrite'             : 'Kundi ikki skriva til "$1".',
			'errPerm'              : 'Atgongd nokta.',
			'errLocked'            : '"$1" er løst og kann ikki umdoybast, flytast ella strikast.',
			'errExists'            : 'Tað finst longu ein fíla við navn "$1".',
			'errInvName'           : 'Ógildugt fíla navn.',
			'errInvDirname'        : 'Ógilt nafn möppu.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Mappa ikki funnin.',
			'errFileNotFound'      : 'Fíla ikki funnin.',
			'errTrgFolderNotFound' : 'Mappan "$1" bleiv ikke funnin.',
			'errPopup'             : 'Kagin forðaði í at opna eitt popup-vindeyga. Fyri at opna fíluna, aktivera popup-vindeygu í tínum kaga stillingum.',
			'errMkdir'             : '\'Kundi ikki stovna mappu "$1".',
			'errMkfile'            : 'Kundi ikki stovna mappu "$1".',
			'errRename'            : 'Kundi ikki umdoyba "$1".',
			'errCopyFrom'          : 'Kopiering av fílum frá mappuni "$1" er ikke loyvt.',
			'errCopyTo'            : 'Kopiering av fílum til mappuna "$1" er ikke loyvt.',
			'errMkOutLink'         : 'Ikki ført fyri at stovna leinkju til uttanfyri \'volume\' rót.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Innlegginar feilur.',  // old name - errUploadCommon
			'errUploadFile'        : 'Kundi ikki leggja "$1" inn.', // old name - errUpload
			'errUploadNoFiles'     : 'Ongar fílar funnir at leggja inn.',
			'errUploadTotalSize'   : 'Dátain er størri enn mest loyvda støddin.', // old name - errMaxSize
			'errUploadFileSize'    : 'Fíla er størri enn mest loyvda støddin.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Fílu slag ikki góðkent.',
			'errUploadTransfer'    : '"$1" innleggingar feilur.',
			'errUploadTemp'        : 'Ikki ført fyri at gera fyribils fílu fyri innlegging.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Lutur "$1" finst longu á hesum stað og can ikki skiftast út av lutið av øðrum slag.', // new
			'errReplace'           : 'Ikki ført fyri at erstattae "$1".',
			'errSave'              : 'Kundi ikki goyma "$1".',
			'errCopy'              : 'Kundi ikki kopiera "$1".',
			'errMove'              : 'Kundi ikki flyta "$1".',
			'errCopyInItself'      : 'Kundi ikki kopiera "$1" inn í seg sjálva.',
			'errRm'                : 'Kundi ikki strika "$1".',
			'errTrash'             : 'Ekki hægt að fara í ruslið.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Ikki ført fyri at strika keldu fíla(r).',
			'errExtract'           : 'Kundi ikki útpakka fílar frá "$1".',
			'errArchive'           : 'Kundi ikki stovna arkiv.',
			'errArcType'           : 'Arkiv slagið er ikki stuðla.',
			'errNoArchive'         : 'Fílan er ikki eitt arkiv ella er ikki eitt stuðla arkiva slag.',
			'errCmdNoSupport'      : 'Backend stuðlar ikki hesi boð.',
			'errReplByChild'       : 'appan "$1" kann ikki erstattast av einari vøru, hon inniheldur.',
			'errArcSymlinks'       : 'Av trygdarávum grundum, noktaði skipanin at pakka út arkivir ið innihalda symlinks ella fílur við nøvn ið ikki eru loyvd.', // edited 24.06.2012
			'errArcMaxSize'        : 'Arkiv fílar fylla meir enn mest loyvda støddin.',
			'errResize'            : 'Kundi ikki broyta støddina á "$1".',
			'errResizeDegree'      : 'Ógildugt roterings stig.',  // added 7.3.2013
			'errResizeRotate'      : 'Ikki ført fyri at rotera mynd.',  // added 7.3.2013
			'errResizeSize'        : 'Ógildug myndastødd.',  // added 7.3.2013
			'errResizeNoChange'    : 'Mynda stødd ikki broytt.',  // added 7.3.2013
			'errUsupportType'      : 'Ikki stuðla fíla slag.',
			'errNotUTF8Content'    : 'Fílan "$1" er ikki í UTF-8 og kann ikki vera rættað.',  // added 9.11.2011
			'errNetMount'          : 'Kundi ikki "mounta" "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'Ikki stuðla protokol.',     // added 17.04.2012
			'errNetMountFailed'    : 'Mount miseydnaðist.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Host kravt.', // added 18.04.2012
			'errSessionExpires'    : 'Tín seta er útgingin vegna óvirkniy.',
			'errCreatingTempDir'   : 'Ikki ført fyri at stovna fyribils fíluskrá: "$1"',
			'errFtpDownloadFile'   : 'Ikki ført fyri at taka fílu niður frá FTP: "$1"',
			'errFtpUploadFile'     : 'Ikki ført fyri at leggja fílu til FTP: "$1"',
			'errFtpMkdir'          : 'Ikki ført fyri at stovna fjar-fílaskrá á FTP: "$1"',
			'errArchiveExec'       : 'Villa íkomin undir arkiveran af fílar: "$1"',
			'errExtractExec'       : 'Villa íkomin undir útpakking af fílum: "$1"',
			'errNetUnMount'        : 'Unable to unmount', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Kann ikki broytast til UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Royn Google Chrome, um tú ynskir at leggja mappu innn.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Tími rann út þegar leitað var að "$1". Leitarniðurstaða er að hluta.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Endurheimild er krafist.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Hámarksfjöldi vara sem hægt er að velja er $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Ekki er hægt að endurheimta úr ruslinu. Ekki er hægt að bera kennsl á endurheimtunarstaðinn.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Ritstjóri fannst ekki fyrir þessa skráartegund.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Villa kom upp á þjóninum.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Ekki tókst að tæma möppuna "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Það eru $1 villur í viðbót.', // from v2.1.44 added 9.12.2018
			'errMaxMkdirs'         : 'Þú getur búið til allt að $1 möppur í einu.', // from v2.1.58 added 20.6.2021

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Stovna arkiv',
			'cmdback'      : 'Aftur\'',
			'cmdcopy'      : 'Kopier',
			'cmdcut'       : 'Klipp',
			'cmddownload'  : 'Tak niður',
			'cmdduplicate' : 'Tvífalda',
			'cmdedit'      : 'Rætta fílu',
			'cmdextract'   : 'Pakka út fílar úr arkiv',
			'cmdforward'   : 'Fram',
			'cmdgetfile'   : 'Vel fílar',
			'cmdhelp'      : 'Um hesa software',
			'cmdhome'      : 'Heim',
			'cmdinfo'      : 'Fá upplýsingar',
			'cmdmkdir'     : 'Nýggja mappu',
			'cmdmkdirin'   : 'Inn í nýja möppu', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Nýggja fílu',
			'cmdopen'      : 'Opna',
			'cmdpaste'     : 'Set inn',
			'cmdquicklook' : 'Forsýning',
			'cmdreload'    : 'Les inn umaftur',
			'cmdrename'    : 'Umdoyp',
			'cmdrm'        : 'Strika',
			'cmdtrash'     : 'Í ruslið', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Endurheimta', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Finn fílar',
			'cmdup'        : 'Eitt stig upp',
			'cmdupload'    : 'Legg fílar inn',
			'cmdview'      : 'Síggj',
			'cmdresize'    : 'Tillaga stødd & Roter',
			'cmdsort'      : 'Raða',
			'cmdnetmount'  : 'Settu hljóðstyrk netkerfisins', // added 18.04.2012
			'cmdnetunmount': 'Aftengja', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Til støð', // added 28.12.2014
			'cmdchmod'     : 'Broytir stíl', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Opnaðu möppu', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Endurstilla dálkbreidd', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Fullur skjár', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Færa', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Tæmdu möppuna', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Afturkalla', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'Gera aftur', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'Kjörstillingar', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Velja allt', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Veldu ekkert', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Snúa vali við', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Opna í nýjum glugga', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Fela (Preference)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Lat aftur',
			'btnSave'   : 'Goym',
			'btnRm'     : 'Strika',
			'btnApply'  : 'Brúka',
			'btnCancel' : 'Angra',
			'btnNo'     : 'Nei',
			'btnYes'    : 'Ja',
			'btnMount'  : 'Mount',  // added 18.04.2012
			'btnApprove': 'Farðu í $1 og samþykktu', // from v2.1 added 26.04.2012
			'btnUnmount': 'Aftengja', // from v2.1 added 30.04.2012
			'btnConv'   : 'Konverter', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Her',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Hljóðstyrkur',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Øll',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME Slag', // from v2.1 added 22.5.2015
			'btnFileName':'Fílunavn',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Goym & Lat aftur', // from v2.1 added 12.6.2015
			'btnBackup' : 'Öryggisafrit', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Endurnefna',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Endurnefna (Allt)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Fyrri ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Næst ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Vista sem', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Opna mappu',
			'ntffile'     : '\'Opna fílu',
			'ntfreload'   : 'Les innaftur mappu innihald',
			'ntfmkdir'    : 'Stovnar mappu',
			'ntfmkfile'   : 'Stovnar fílur',
			'ntfrm'       : 'Strikar fílur',
			'ntfcopy'     : 'Kopierar fílur',
			'ntfmove'     : 'Flytur fílar',
			'ntfprepare'  : 'Ger klárt at kopiera fílar',
			'ntfrename'   : 'Umdoyp fílar',
			'ntfupload'   : 'Leggur inn fílar',
			'ntfdownload' : 'Tekur fílar niður',
			'ntfsave'     : 'Goymir fílar',
			'ntfarchive'  : 'Stovnar arkiv',
			'ntfextract'  : 'Útpakkar fílar frá arkiv',
			'ntfsearch'   : 'Leitar eftir fílum',
			'ntfresize'   : 'Broytir stødd á fílur',
			'ntfsmth'     : '\'Ger okkurt >_<',
			'ntfloadimg'  : 'Lesur mynd inn',
			'ntfnetmount' : 'Mounting network volume', // added 18.04.2012
			'ntfnetunmount': 'Unmounting network volume', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Tekur mynda vídd', // added 20.05.2013
			'ntfreaddir'  : 'Lesur mappu upplýsingar', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Far URL af leinkju', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Broyti fílu stíl', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Kannar fílunavnið á fílu', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Að búa til skrá til að sækja', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Að sækja upplýsingar um slóð', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Er að vinna úr skránni sem hlaðið var upp', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Er að henda í ruslið', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Að gera endurheimt úr ruslinu', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Athugar áfangamöppu', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Afturkallar fyrri aðgerð', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Endurgerir fyrra afturkallað', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Athugun á innihaldi', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'Ruslið', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'ókent',
			'Today'       : 'Í dag',
			'Yesterday'   : 'Í gjár',
			'msJan'       : 'Jan',
			'msFeb'       : 'Feb',
			'msMar'       : 'Mar',
			'msApr'       : 'Apr',
			'msMay'       : 'Mai',
			'msJun'       : 'Jun',
			'msJul'       : 'Jul',
			'msAug'       : 'Aug',
			'msSep'       : 'Sep',
			'msOct'       : 'Okt',
			'msNov'       : 'Nov',
			'msDec'       : 'Des',
			'January'     : 'Januar',
			'February'    : 'Februar',
			'March'       : 'Mars',
			'April'       : 'Apríl',
			'May'         : 'Mai',
			'June'        : 'Juni',
			'July'        : 'Juli',
			'August'      : 'August',
			'September'   : 'September',
			'October'     : 'Oktober',
			'November'    : 'November',
			'December'    : 'Desember',
			'Sunday'      : 'Sunnudag',
			'Monday'      : 'Mánadag',
			'Tuesday'     : 'Týsdag',
			'Wednesday'   : 'Mikudag',
			'Thursday'    : 'Hósdag',
			'Friday'      : 'Fríggjadag',
			'Saturday'    : 'Leygardag',
			'Sun'         : 'Sun',
			'Mon'         : 'Mán',
			'Tue'         : 'Týs',
			'Wed'         : 'Mik',
			'Thu'         : 'Hós',
			'Fri'         : 'Frí',
			'Sat'         : 'Ley',

			/******************************** sort variants ********************************/
			'sortname'          : 'eftir navn',
			'sortkind'          : 'eftir slag',
			'sortsize'          : 'eftir stødd',
			'sortdate'          : 'eftir dato',
			'sortFoldersFirst'  : 'mappur fyrst',
			'sortperm'          : 'með leyfi', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'eftir ham',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'eftir eiganda',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'eftir hópi',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Einnig Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NýggjaFílu.txt', // added 10.11.2015
			'untitled folder'   : 'NýggjaMappu',   // added 10.11.2015
			'Archive'           : 'NýtArkiv',  // from v2.1 added 10.11.2015
			'untitled file'     : 'Nýskrá.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: Skrá',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Váttan kravd',
			'confirmRm'       : 'Ert tú vísur í at tú ynskir at strika fílarnar?<br/>Hetta kann ikki angrast!',
			'confirmRepl'     : 'Erstatta gomlu fílu við nýggja?',
			'confirmRest'     : 'Skipta út núverandi hlut með hlutnum í ruslinu?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Brúka á øll', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Ekki var hægt að greina stafakóðun þessarar skráar. Það þarf að breyta tímabundið í UTF-8 til að breyta.<br/>Vinsamlegast veldu táknkóðun þessarar skráar.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Er blivi rættað.<br/>Missir sínar broytingar um tú ikki goymir.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Ertu viss um að þú viljir færa hluti í ruslafötuna?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Ertu viss um að þú viljir færa hluti í "$1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Brúka til øll',
			'name'            : 'Navn',
			'size'            : 'Stødd',
			'perms'           : 'Rættindi',
			'modify'          : 'Rættað',
			'kind'            : 'Slag',
			'read'            : 'síggja',
			'write'           : 'broyta',
			'noaccess'        : 'onga atgongd',
			'and'             : 'og',
			'unknown'         : 'ókent',
			'selectall'       : 'Vel allar fílur',
			'selectfiles'     : 'Vel fílu(r)',
			'selectffile'     : 'Vel fyrstu fílu',
			'selectlfile'     : 'Vel síðstu fílu',
			'viewlist'        : 'Lista vísing',
			'viewicons'       : 'Ikon vísing',
			'viewSmall'       : 'Lítil tákn', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Miðlungs tákn', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Stór tákn', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Extra stór tákn', // from v2.1.39 added 22.5.2018
			'places'          : 'Støð',
			'calc'            : 'Rokna',
			'path'            : 'Stiga',
			'aliasfor'        : 'Hjánavn fyri',
			'locked'          : 'Læst',
			'dim'             : 'Vídd',
			'files'           : 'Fílur',
			'folders'         : 'Mappur',
			'items'           : 'Myndir',
			'yes'             : 'ja',
			'no'              : 'nei',
			'link'            : 'Leinkja',
			'searcresult'     : 'Leiti úrslit',
			'selected'        : 'valdar myndir',
			'about'           : 'Um',
			'shortcuts'       : 'Snarvegir',
			'help'            : 'Hjálp',
			'webfm'           : 'Web fílu umsitan',
			'ver'             : 'Útgáva',
			'protocolver'     : 'protokol versión',
			'homepage'        : 'Verkætlan heim',
			'docs'            : 'Skjalfesting',
			'github'          : 'Mynda okkum á Github',
			'twitter'         : 'Fylg okkum á twitter',
			'facebook'        : 'Fylg okkum á facebook',
			'team'            : 'Lið',
			'chiefdev'        : 'forritaleiðari',
			'developer'       : 'forritari',
			'contributor'     : 'stuðulsveitari',
			'maintainer'      : 'viðlíkahaldari',
			'translator'      : 'umsetari',
			'icons'           : 'Ikonir',
			'dontforget'      : 'og ekki gleyma að taka handklæðið þitt',
			'shortcutsof'     : 'Snarvegir sligi frá',
			'dropFiles'       : 'Slepp fílur her',
			'or'              : 'ella',
			'selectForUpload' : 'Vel fílur at leggja inn',
			'moveFiles'       : 'Flyt fílur',
			'copyFiles'       : 'Kopier fílur',
			'restoreFiles'    : 'Endurheimta hluti', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Flyt frá støð',
			'aspectRatio'     : 'Skermformat',
			'scale'           : 'Skalera',
			'width'           : 'Longd',
			'height'          : 'Hædd',
			'resize'          : 'Tilliga stødd',
			'crop'            : 'Sker til',
			'rotate'          : 'Rotera',
			'rotate-cw'       : 'Rotera 90 gradir við urið',
			'rotate-ccw'      : 'otera 90 gradir móti urið',
			'degree'          : '°',
			'netMountDialogTitle' : 'Settu hljóðstyrk netkerfisins', // added 18.04.2012
			'protocol'            : 'Protokol', // added 18.04.2012
			'host'                : 'Host', // added 18.04.2012
			'port'                : 'Port', // added 18.04.2012
			'user'                : 'Brúkari', // added 18.04.2012
			'pass'                : 'Loyniorð', // added 18.04.2012
			'confirmUnmount'      : 'Ertu að taka $1 af?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Hála ella set innn fílar frá kaga', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Hála ella set inn fílar frá URls her', // from v2.1 added 07.04.2014
			'encoding'        : 'Encoding', // from v2.1 added 19.12.2014
			'locale'          : 'Tungumál',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'skotmark: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Leita við input MIME Type', // from v2.1 added 22.5.2015
			'owner'           : 'Eigari', // from v2.1 added 20.6.2015
			'group'           : 'Bólkur', // from v2.1 added 20.6.2015
			'other'           : 'Annað', // from v2.1 added 20.6.2015
			'execute'         : 'Útfør', // from v2.1 added 20.6.2015
			'perm'            : 'Rættindi', // from v2.1 added 20.6.2015
			'mode'            : 'Mode', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mappan er tóm', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Mappan er tóm\\Slepptu til að bæta við hlutum', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Mappan er tóm\\Langsmellið til að bæta við hlutum', // from v2.1.6 added 30.12.2015
			'quality'         : 'Gæði', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Sjálfvirk samstilling',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Fara upp',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Fáðu slóð tengil', // from v2.1.7 added 9.2.2016
			'selectedItems'   : 'Valdir hlutir ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'Auðkenni möppu', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Leyfa aðgang án nettengingar', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'Til að sannvotta aftur', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Hleður núna...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Opnaðu margar skrár', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Þú ert að reyna að opna $1 skrárnar. Ertu viss um að þú viljir opna í vafra?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Leitarniðurstöður eru tómar í leitarmarkmiði.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Það er verið að breyta skrá.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Þú hefur valið $1 atriði.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'Þú ert með $1 atriði á klippiborðinu.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Stigvaxandi leit er aðeins frá núverandi skjá.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'Settu aftur inn', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 lokið', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Samhengisvalmynd', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Blaðsnúningur', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Rætur bindi', // from v2.1.16 added 16.9.2016
			'reset'           : 'Endurstilla', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Bakgrunns litur', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Litaplokkari', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px Grid', // from v2.1.16 added 4.10.2016
			'enabled'         : 'Virkt', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Öryrkjar', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Leitarniðurstöður eru tómar í núverandi yfirliti.\\AÝttu á [Enter] til að stækka leitarmarkmiðið.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Fyrsta stafur leitarniðurstöður eru tómar í núverandi skjá.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Texti merki', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '$1 mín eftir', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Opnaðu aftur með valinni kóðun', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Vistaðu með völdum kóðun', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Veldu möppu', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Fyrsta stafs leit', // from v2.1.23 added 24.3.2017
			'presets'         : 'Forstillingar', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Það er of mikið af hlutum svo það má ekki fara í ruslið.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Tæmdu möppuna "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'Það eru engin atriði í möppunni "$1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'Preference', // from v2.1.26 added 28.6.2017
			'language'        : 'Tungumál', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Uppstilltu stillingarnar sem vistaðar eru í þessum vafra', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Stillingar tækjastikunnar', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $1 stafir eftir.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $1 línur eftir.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Summa', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Gróf skráarstærð', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Einbeittu þér að þætti gluggans með músinni',  // from v2.1.30 added 2.11.2017
			'select'          : 'Veljið', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Aðgerð þegar skrá er valin', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Opna með ritlinum sem notaður var síðast', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Snúa vali við', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Ertu viss um að þú viljir endurnefna $1 valin atriði eins og $2?<br/>Ekki er hægt að afturkalla þetta!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Endurnefna runu', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Númer', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Bæta við forskeyti', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Bæta við viðskeyti', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Breyta eftirnafn', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Dálkastillingar (listayfirlit)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Allar breytingar birtast strax í skjalasafninu.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Allar breytingar munu ekki endurspeglast fyrr en aftengdu þetta hljóðstyrk.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'Eftirfarandi bindi(r) sem sett voru á þetta bindi voru einnig afsett. Ertu viss um að taka það af?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Upplýsingar um val', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Reiknirit til að sýna skráarhash', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Upplýsingaatriði (upplýsingaborð fyrir val)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Ýttu aftur til að hætta.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Tækjastikan', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Vinnurými', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Dialog', // from v2.1.38 added 4.4.2018
			'all'             : 'Allt', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Táknstærð (táknskjár)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Opnaðu hámarks ritstjóragluggann', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Vegna þess að umbreyting með API er ekki í boði eins og er, vinsamlegast umbreyttu á vefsíðunni.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Eftir umbreytingu verður þú að vera hlaðið upp með vefslóð hlutarins eða niðurhalðri skrá til að vista breyttu skrána.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Umbreyttu á síðunni $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Samþættingar', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'Þessi elFinder hefur eftirfarandi ytri þjónustu samþætta. Vinsamlegast athugaðu notkunarskilmála, persónuverndarstefnu osfrv. áður en þú notar það.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Sýndu falin atriði', // from v2.1.41 added 24.7.2018
			'hideHidden'      : 'Fela falin atriði', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Sýna/fela falin atriði', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Skráargerðir til að virkja með "Ný skrá"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Tegund textaskráarinnar', // from v2.1.41 added 7.8.2018
			'add'             : 'Bæta við', // from v2.1.41 added 7.8.2018
			'theme'           : 'Þema', // from v2.1.43 added 19.10.2018
			'default'         : 'Sjálfgefna', // from v2.1.43 added 19.10.2018
			'description'     : 'Lýsing', // from v2.1.43 added 19.10.2018
			'website'         : 'Vefsíða', // from v2.1.43 added 19.10.2018
			'author'          : 'Höfundur', // from v2.1.43 added 19.10.2018
			'email'           : 'Tölvupóstur', // from v2.1.43 added 19.10.2018
			'license'         : 'Leyfi', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Ekki er hægt að vista þetta atriði. Til að forðast að tapa breytingunum þarftu að flytja út á tölvuna þína.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Tvísmelltu á skrána til að velja hana.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Notaðu fullskjástillingu', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Ókent',
			'kindRoot'        : 'Hljóðstyrksrót', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Mappa',
			'kindSelects'     : 'Valmöguleikar', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Hjánavn',
			'kindAliasBroken' : 'Óvirki hjánavn',
			// applications
			'kindApp'         : 'Applikatión',
			'kindPostscript'  : 'Postscript skjal',
			'kindMsOffice'    : 'Microsoft Office skjal',
			'kindMsWord'      : 'Microsoft Word skjal',
			'kindMsExcel'     : 'Microsoft Excel skjal',
			'kindMsPP'        : 'Microsoft Powerpoint framløga',
			'kindOO'          : 'Open Office skjal',
			'kindAppFlash'    : 'Flash applikatión',
			'kindPDF'         : 'Færanlegt skjalasnið (PDF)',
			'kindTorrent'     : 'Bittorrent fíla',
			'kind7z'          : '7z arkiv',
			'kindTAR'         : 'TAR arkiv',
			'kindGZIP'        : 'GZIP arkiv',
			'kindBZIP'        : 'BZIP arkiv',
			'kindXZ'          : 'XZ arkiv',
			'kindZIP'         : 'ZIP arkiv',
			'kindRAR'         : 'RAR arkiv',
			'kindJAR'         : 'Java JAR ffílaile',
			'kindTTF'         : 'True Type leturgerð',
			'kindOTF'         : 'Opnaðu leturgerð',
			'kindRPM'         : 'RPM pakki',
			// texts
			'kindText'        : 'Text skjal',
			'kindTextPlain'   : 'Reinur tekstur',
			'kindPHP'         : 'PHP kelda',
			'kindCSS'         : 'Cascading style sheet (CSS)',
			'kindHTML'        : 'HTML skjal',
			'kindJS'          : 'Javascript kelda',
			'kindRTF'         : 'Rich Text Format (RTF)',
			'kindC'           : 'C kelda',
			'kindCHeader'     : 'C header kelda',
			'kindCPP'         : 'C++ kelda',
			'kindCPPHeader'   : 'C++ header kelda',
			'kindShell'       : 'Unix skel handrit',
			'kindPython'      : 'Python kelda',
			'kindJava'        : 'Java kelda',
			'kindRuby'        : 'Ruby kelda',
			'kindPerl'        : 'Perl handrit',
			'kindSQL'         : 'SQL kelda',
			'kindXML'         : 'XML skjal',
			'kindAWK'         : 'AWK kelda',
			'kindCSV'         : 'Comma separated values (CSV)',
			'kindDOCBOOK'     : 'Docbook XML skjal',
			'kindMarkdown'    : 'Markdown texti', // added 20.7.2015
			// images
			'kindImage'       : 'Mynd',
			'kindBMP'         : 'BMP mynd',
			'kindJPEG'        : 'JPEG mynd',
			'kindGIF'         : 'GIF mynd',
			'kindPNG'         : 'PNG mynd',
			'kindTIFF'        : 'TIFF mynd',
			'kindTGA'         : 'TGA mynd',
			'kindPSD'         : 'Adobe Photoshop mynd',
			'kindXBITMAP'     : 'X bitmap mynd',
			'kindPXM'         : 'Pixelmator mynd',
			// media
			'kindAudio'       : 'Hljóðmiðlar',
			'kindAudioMPEG'   : 'MPEG ljóðfíla',
			'kindAudioMPEG4'  : 'MPEG-4 ljóðfíla',
			'kindAudioMIDI'   : 'MIDI ljóðfíla',
			'kindAudioOGG'    : 'Ogg Vorbis ljóðfíla',
			'kindAudioWAV'    : 'WAV ljóðfíla',
			'AudioPlaylist'   : 'MP3 playlisti',
			'kindVideo'       : 'Myndbandsmiðlar',
			'kindVideoDV'     : 'DV filmur',
			'kindVideoMPEG'   : 'MPEG filmur',
			'kindVideoMPEG4'  : 'MPEG-4 filmur',
			'kindVideoAVI'    : 'AVI filmur',
			'kindVideoMOV'    : 'Quick Time filmur',
			'kindVideoWM'     : 'Windows Media filmur',
			'kindVideoFlash'  : 'Flash filmur',
			'kindVideoMKV'    : 'Matroska filmur',
			'kindVideoOGG'    : 'Ogg filmur'
		}
	};
}));