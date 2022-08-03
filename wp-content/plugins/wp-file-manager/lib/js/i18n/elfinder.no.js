/**
 * Norwegian Bokmål translation
 * @author Stian Jacobsen <stian@promonorge.no>
 * @version 2022-03-02
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
	elFinder.prototype.i18.no = {
		translator : 'Stian Jacobsen &lt;stian@promonorge.no&gt;',
		language   : 'Norwegian Bokmål',
		direction  : 'ltr',
		dateFormat : 'M d, Y h:i A', // will show like: mars 02, 2022 04:32 PM
		fancyDateFormat : '$1 h:i A', // will show like: I dag 04:32 PM
		nonameDateFormat : 'ymd-His', // noname upload will show like: 220302-163250
		messages   : {
			'getShareText' : 'Dele',
			'Editor ': 'Koderedigerer',

			/********************************** errors **********************************/
			'error'                : 'Feil',
			'errUnknown'           : 'Ukjent feil.',
			'errUnknownCmd'        : 'Ukjent kommando.',
			'errJqui'              : 'Ugyldig jQuery UI konfigurasjon. Selectable, draggable og droppable komponentene må være inkludert.',
			'errNode'              : 'elFinder påkrever at DOM Elementer kan opprettes.',
			'errURL'               : 'Ugyldig elFinder konfigurasjon! URL-valget er ikke satt.',
			'errAccess'            : 'Ingen adgang.',
			'errConnect'           : 'Kunne ikke koble til.',
			'errAbort'             : 'Tilkoblingen avbrutt.',
			'errTimeout'           : 'Tilkoblingen tidsavbrudd.',
			'errNotFound'          : 'Backend ble ikke funnet',
			'errResponse'          : 'Ugyldig backend respons.',
			'errConf'              : 'Ugyldig backend konfigurasjon.',
			'errJSON'              : 'PHP JSON modul er ikke installert.',
			'errNoVolumes'         : 'Lesbar volum er ikke tilgjennelig.',
			'errCmdParams'         : 'Ugyldig parameter for kommando "$1".',
			'errDataNotJSON'       : 'Innhold er ikke JSON.',
			'errDataEmpty'         : 'Innholdet er tomt.',
			'errCmdReq'            : 'Backend spørringen påkrever kommando.',
			'errOpen'              : 'Kunne ikke åpne "$1".',
			'errNotFolder'         : 'Objektet er ikke en mappe.',
			'errNotFile'           : 'Objektet er ikke en fil.',
			'errRead'              : 'Kunne ikke lese "$1".',
			'errWrite'             : 'Kunne ikke skrive til "$1".',
			'errPerm'              : 'Du har ikke rettigheter.',
			'errLocked'            : '"$1" er låst og kan ikke flyttes, slettes eller endres',
			'errExists'            : 'Filen "$1" finnes allerede.',
			'errInvName'           : 'Ugyldig filnavn.',
			'errInvDirname'        : 'Ugyldig mappenavn.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Mappen finnes ikke.',
			'errFileNotFound'      : 'Filen finnes ikke.',
			'errTrgFolderNotFound' : 'Målmappen "$1" ble ikke funnet.',
			'errPopup'             : 'Nettleseren din blokkerte et pop-up vindu. For å åpne filen må du aktivere pop-up i din nettlesers innstillinger.',
			'errMkdir'             : 'Kunne ikke opprette mappen "$1".',
			'errMkfile'            : 'Kunne ikke opprette filen "$1".',
			'errRename'            : 'Kunne ikke gi nytt navn til "$1".',
			'errCopyFrom'          : 'Kopiere filer fra "$1" er ikke tillatt.',
			'errCopyTo'            : 'Kopiere filer til "$1" er ikke tillatt.',
			'errMkOutLink'         : 'Kan ikke opprette en kobling til utenfor volumroten.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Feil under opplasting.',  // old name - errUploadCommon
			'errUploadFile'        : 'Kunne ikke laste opp "$1".', // old name - errUpload
			'errUploadNoFiles'     : 'Ingen filer funnet til opplasting.',
			'errUploadTotalSize'   : 'Innholdet overgår maksimum tillatt størrelse.', // old name - errMaxSize
			'errUploadFileSize'    : 'Filen vergår maksimum tillatt størrelse.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Filtypen ikke tillatt.',
			'errUploadTransfer'    : '"$1" overførings feil.',
			'errUploadTemp'        : 'Kan ikke lage en midlertidig fil for opplasting.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Objektet "$1" eksisterer allerede på denne plasseringen og kan ikke erstattes av objektet med en annen type.', // new
			'errReplace'           : 'Kan ikke erstatte "$1".',
			'errSave'              : 'Kunne ikke lagre "$1".',
			'errCopy'              : 'Kunne ikke kopiere "$1".',
			'errMove'              : 'Kunne ikke flytte "$1".',
			'errCopyInItself'      : 'Kunne ikke kopiere "$1" til seg selv.',
			'errRm'                : 'Kunne ikke slette "$1".',
			'errTrash'             : 'Kan ikke legges i papirkurven.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Kan ikke fjerne kildefil(er).',
			'errExtract'           : 'Kunne ikke pakke ut filer fra "$1".',
			'errArchive'           : 'Kunne ikke opprette arkiv.',
			'errArcType'           : 'akriv-typen er ikke støttet.',
			'errNoArchive'         : 'Filen er ikke et arkiv eller et arkiv som ikke er støttet.',
			'errCmdNoSupport'      : 'Backend støtter ikke denne kommandoen.',
			'errReplByChild'       : 'The folder “$1” can’t be replaced by an item it contains.',
			'errArcSymlinks'       : 'Av sikkerhetsgrunner nektet å pakke ut inneholder arkiver symbolkoblinger eller filer med ikke tillatte navn.', // edited 24.06.2012
			'errArcMaxSize'        : 'Arkivfiler overskrider maksimal tillatt størrelse.',
			'errResize'            : 'Kan ikke endre størrelsen på "$1".',
			'errResizeDegree'      : 'Ugyldig rotasjonsgrad.',  // added 7.3.2013
			'errResizeRotate'      : 'Kan ikke rotere bildet.',  // added 7.3.2013
			'errResizeSize'        : 'Ugyldig bildestørrelse.',  // added 7.3.2013
			'errResizeNoChange'    : 'Bildestørrelsen er ikke endret.',  // added 7.3.2013
			'errUsupportType'      : 'Ustøttet filtype.',
			'errNotUTF8Content'    : 'Filen "$1" er ikke i UTF-8 og kan ikke redigeres.',  // added 9.11.2011
			'errNetMount'          : 'Kan ikke montere "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'Ustøttet protokoll.',     // added 17.04.2012
			'errNetMountFailed'    : 'Montering mislyktes.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Vert kreves.', // added 18.04.2012
			'errSessionExpires'    : 'Økten din har utløpt på grunn av inaktivitet.',
			'errCreatingTempDir'   : 'Kan ikke opprette midlertidig katalog: "$1"',
			'errFtpDownloadFile'   : 'Kan ikke laste ned fil fra FTP: "$1"',
			'errFtpUploadFile'     : 'Kan ikke laste opp filen til FTP: "$1"',
			'errFtpMkdir'          : 'Kan ikke opprette ekstern katalog på FTP: "$1"',
			'errArchiveExec'       : 'Feil under arkivering av filer: "$1"',
			'errExtractExec'       : 'Feil under utpakking av filer: "$1"',
			'errNetUnMount'        : 'Kan ikke demontere.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Kan ikke konverteres til UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Prøv den moderne nettleseren, hvis du vil laste opp mappen.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Tidsavbrudd under søking av «$1». Søkeresultatet er delvis.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Det kreves ny autorisasjon.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Maks antall valgbare varer er $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Kan ikke gjenopprette fra papirkurven. Kan ikke identifisere gjenopprettingsdestinasjonen.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Finner ikke redigeringsprogrammet for denne filtypen.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Det oppstod en feil på serversiden.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Kan ikke tømme mappen "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Det er $1 flere feil.', // from v2.1.44 added 9.12.2018
			'errMaxMkdirs'         : 'Du kan opprette opptil $1 mapper om gangen.', // from v2.1.58 added 20.6.2021

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Opprett arkiv',
			'cmdback'      : 'Tilbake',
			'cmdcopy'      : 'Kopier',
			'cmdcut'       : 'Klipp ut',
			'cmddownload'  : 'Last ned',
			'cmdduplicate' : 'Dupliser',
			'cmdedit'      : 'Rediger fil',
			'cmdextract'   : 'Pakk ut filer fra arkiv',
			'cmdforward'   : 'Frem',
			'cmdgetfile'   : 'Velg filer',
			'cmdhelp'      : 'Om',
			'cmdhome'      : 'Hjem',
			'cmdinfo'      : 'Vis info',
			'cmdmkdir'     : 'Ny mappe',
			'cmdmkdirin'   : 'Inn i ny mappe', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Ny fil',
			'cmdopen'      : 'Åpne',
			'cmdpaste'     : 'Lim inn',
			'cmdquicklook' : 'Forhåndsvis',
			'cmdreload'    : 'Last inn på nytt',
			'cmdrename'    : 'Gi nytt navn',
			'cmdrm'        : 'Slett',
			'cmdtrash'     : 'Til søppel', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Restaurere', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Find filer',
			'cmdup'        : 'Opp et nivå',
			'cmdupload'    : 'Last opp filer',
			'cmdview'      : 'Vis',
			'cmdresize'    : 'Endre størrelse og roter',
			'cmdsort'      : 'Sortere',
			'cmdnetmount'  : 'Monter nettverksvolum', // added 18.04.2012
			'cmdnetunmount': 'Demonter', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Til steder', // added 28.12.2014
			'cmdchmod'     : 'Endre modus', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Åpne en mappe', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Tilbakestill kolonnebredden', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Full skjerm', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Bevege seg', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Tøm mappen', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Angre', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'Gjøre om', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'Preferanser', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Velg alle', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Velg ingen', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Inverter utvalg', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Åpne i nytt vindu', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Skjul (preferanse)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Lukk',
			'btnSave'   : 'Lagre',
			'btnRm'     : 'Slett',
			'btnApply'  : 'Søke om',
			'btnCancel' : 'Avbryt',
			'btnNo'     : 'Nei',
			'btnYes'    : 'Ja',
			'btnMount'  : 'Monter',  // added 18.04.2012
			'btnApprove': 'Gå til $1 og godkjenn', // from v2.1 added 26.04.2012
			'btnUnmount': 'Demonter', // from v2.1 added 30.04.2012
			'btnConv'   : 'Konvertere', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Her',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Volum',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Alle',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME-type', // from v2.1 added 22.5.2015
			'btnFileName':'Filnavn',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Lagre og lukk', // from v2.1 added 12.6.2015
			'btnBackup' : 'Sikkerhetskopiering', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Gi nytt navn',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Gi nytt navn (alle)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Forrige ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Neste ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Lagre som', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Åpne mappe',
			'ntffile'     : 'Åpne fil',
			'ntfreload'   : 'Last inn mappen på nytt',
			'ntfmkdir'    : 'Oppretter mappe',
			'ntfmkfile'   : 'Oppretter filer',
			'ntfrm'       : 'Sletter filer',
			'ntfcopy'     : 'Kopierer filer',
			'ntfmove'     : 'Flytter filer',
			'ntfprepare'  : 'Gjør klar til kopiering av filer',
			'ntfrename'   : 'Gir nytt navn til filer',
			'ntfupload'   : 'Laster opp filer',
			'ntfdownload' : 'Laster ned filer',
			'ntfsave'     : 'Lagrer filer',
			'ntfarchive'  : 'Oppretter arkiv',
			'ntfextract'  : 'Pakker ut filer fra arkiv',
			'ntfsearch'   : 'Søker i filer',
			'ntfresize'   : 'Endre størrelse på bilder',
			'ntfsmth'     : 'Gjør noe... >_<',
			'ntfloadimg'  : 'Laster inn bilde',
			'ntfnetmount' : 'Montering av nettverksvolum', // added 18.04.2012
			'ntfnetunmount': 'Demonterer nettverksvolum', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Få bildedimensjon', // added 20.05.2013
			'ntfreaddir'  : 'Leser mappeinformasjon', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Henter URL til lenke', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Endre filmodus', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Bekrefter navnet på opplastingsfilen', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Opprette en fil for nedlasting', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Henter baneinformasjon', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Behandler den opplastede filen', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Kaster i søpla', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Gjenoppretter fra søpla', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Sjekker målmappen', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Angre tidligere operasjon', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Gjør om forrige angret', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Kontrollerer innholdet', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'Søppel', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'Ukjent',
			'Today'       : 'I dag',
			'Yesterday'   : 'I går',
			'msJan'       : 'Jan',
			'msFeb'       : 'Feb',
			'msMar'       : 'mars',
			'msApr'       : 'apr',
			'msMay'       : 'Mai',
			'msJun'       : 'Jun',
			'msJul'       : 'jul',
			'msAug'       : 'august',
			'msSep'       : 'sep',
			'msOct'       : 'Okt',
			'msNov'       : 'nov',
			'msDec'       : 'Des',
			'January'     : 'januar',
			'February'    : 'februar',
			'March'       : 'mars',
			'April'       : 'april',
			'May'         : 'Kan',
			'June'        : 'juni',
			'July'        : 'juli',
			'August'      : 'august',
			'September'   : 'september',
			'October'     : 'oktober',
			'November'    : 'november',
			'December'    : 'desember',
			'Sunday'      : 'søndag',
			'Monday'      : 'mandag',
			'Tuesday'     : 'tirsdag',
			'Wednesday'   : 'onsdag',
			'Thursday'    : 'Torsdag',
			'Friday'      : 'fredag',
			'Saturday'    : 'lørdag',
			'Sun'         : 'Sol',
			'Mon'         : 'man',
			'Tue'         : 'tirs',
			'Wed'         : 'ons',
			'Thu'         : 'tor',
			'Fri'         : 'fre',
			'Sat'         : 'Lør',

			/******************************** sort variants ********************************/
			'sortname'          : 'ved navn',
			'sortkind'          : 'etter slag',
			'sortsize'          : 'etter størrelse',
			'sortdate'          : 'etter dato',
			'sortFoldersFirst'  : 'Mapper først',
			'sortperm'          : 'med tillatelse', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'etter modus',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'av eier',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'etter gruppe',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Også Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'Ny mappe',   // added 10.11.2015
			'Archive'           : 'Nytt arkiv',  // from v2.1 added 10.11.2015
			'untitled file'     : 'Ny fil.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: Fil',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Bekreftelse nødvendig',
			'confirmRm'       : 'Er du sikker på at du ønsker å slette filene?',
			'confirmRepl'     : 'Erstatt fil?',
			'confirmRest'     : 'Vil du erstatte eksisterende element med elementet i papirkurven?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Ikke i UTF-8<br/>Konverter til UTF-8?<br/>Innhold blir UTF-8 ved å lagre etter konvertering.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Tegnkoding av denne filen kunne ikke oppdages. Den må midlertidig konvertere til UTF-8 for redigering.<br/>Velg tegnkoding for denne filen.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Den har blitt endret.<br/>Mister arbeid hvis du ikke lagrer endringer.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Er du sikker på at du vil flytte elementer til søppelbøtta?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Er du sikker på at du vil flytte elementer til "$1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Gjelder for alle',
			'name'            : 'Navn',
			'size'            : 'Størrelse',
			'perms'           : 'Rettigheter',
			'modify'          : 'Endret',
			'kind'            : 'Type',
			'read'            : 'les',
			'write'           : 'skriv',
			'noaccess'        : 'ingen adgang',
			'and'             : 'og',
			'unknown'         : 'ukjent',
			'selectall'       : 'Velg alle filene',
			'selectfiles'     : 'Velg fil(er)',
			'selectffile'     : 'Velg første fil',
			'selectlfile'     : 'Velg siste fil',
			'viewlist'        : 'Listevisning',
			'viewicons'       : 'Ikoner',
			'viewSmall'       : 'Små ikoner', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Middels ikoner', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Store ikoner', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Ekstra store ikoner', // from v2.1.39 added 22.5.2018
			'places'          : 'Områder',
			'calc'            : 'Beregn',
			'path'            : 'Bane',
			'aliasfor'        : 'Alias for',
			'locked'          : 'Låst',
			'dim'             : 'Størrelser',
			'files'           : 'Filer',
			'folders'         : 'Mapper',
			'items'           : 'objekter',
			'yes'             : 'ja',
			'no'              : 'nei',
			'link'            : 'Link',
			'searcresult'     : 'Søkeresultater',
			'selected'        : 'valgte filer',
			'about'           : 'Om',
			'shortcuts'       : 'Snarveier',
			'help'            : 'Hjelp',
			'webfm'           : 'Web-filbehandler',
			'ver'             : 'Versjon',
			'protocolver'     : 'protokol versjon',
			'homepage'        : 'Prosjekt hjem',
			'docs'            : 'dokumentasjon',
			'github'          : 'Fork us on Github',
			'twitter'         : 'Follow us on twitter',
			'facebook'        : 'Join us on facebook',
			'team'            : 'Team',
			'chiefdev'        : 'sjefutvikler',
			'developer'       : 'utvikler',
			'contributor'     : 'bidragsyter',
			'maintainer'      : 'vedlikeholder',
			'translator'      : 'oversetter',
			'icons'           : 'Ikoner',
			'dontforget'      : 'and don\'t forget to bring a towel',
			'shortcutsof'     : 'Snarveier avslått',
			'dropFiles'       : 'Slipp filer her',
			'or'              : 'eller',
			'selectForUpload' : 'Velg filer til opplasting',
			'moveFiles'       : 'Flytt filer',
			'copyFiles'       : 'Kopier filer',
			'restoreFiles'    : 'Gjenopprett elementer', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Fjern fra steder',
			'aspectRatio'     : 'Størrelsesforholdet',
			'scale'           : 'Skala',
			'width'           : 'Bredde',
			'height'          : 'Høyde',
			'resize'          : 'Endre størrelse',
			'crop'            : 'Avling',
			'rotate'          : 'Rotere',
			'rotate-cw'       : 'Roter 90 grader CW',
			'rotate-ccw'      : 'Roter 90 grader moturs',
			'degree'          : '°',
			'netMountDialogTitle' : 'Monter nettverksvolum', // added 18.04.2012
			'protocol'            : 'Protokoll', // added 18.04.2012
			'host'                : 'Vert', // added 18.04.2012
			'port'                : 'Havn', // added 18.04.2012
			'user'                : 'Bruker', // added 18.04.2012
			'pass'                : 'Passord', // added 18.04.2012
			'confirmUnmount'      : 'Avmonterer du $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Slipp eller lim inn filer fra nettleseren', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Slipp filer, lim inn URL-er eller bilder (utklippstavle) her', // from v2.1 added 07.04.2014
			'encoding'        : 'Koding', // from v2.1 added 19.12.2014
			'locale'          : 'Språk',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Mål: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Søk etter inndata MIME-type', // from v2.1 added 22.5.2015
			'owner'           : 'Eieren', // from v2.1 added 20.6.2015
			'group'           : 'Gruppe', // from v2.1 added 20.6.2015
			'other'           : 'Annen', // from v2.1 added 20.6.2015
			'execute'         : 'Henrette', // from v2.1 added 20.6.2015
			'perm'            : 'Tillatelse', // from v2.1 added 20.6.2015
			'mode'            : 'Modus', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Mappen er tom', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Mappen er tom\\A Slipp for å legge til elementer', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Mappen er tom\\Et langt trykk for å legge til elementer', // from v2.1.6 added 30.12.2015
			'quality'         : 'Kvalitet', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Automatisk synkronisering',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Flytte opp',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Få URL-lenke', // from v2.1.7 added 9.2.2016
			'selectedItems'   : 'Valgte varer ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'Mappe-ID', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Tillat tilgang uten nett', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'For å autentisere på nytt', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Laster...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Åpne flere filer', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Du prøver å åpne $1-filene. Er du sikker på at du vil åpne i nettleseren?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Søkeresultatene er tomme i søkemålet.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Det er å redigere en fil.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Du har valgt $1 varer.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'Du har $1 elementer på utklippstavlen.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Inkrementelt søk er bare fra gjeldende visning.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'Gjenopprett', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 fullført', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Kontekstmenyen', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Sidevending', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Volum røtter', // from v2.1.16 added 16.9.2016
			'reset'           : 'Nullstille', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Bakgrunnsfarge', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Fargevelger', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px rutenett', // from v2.1.16 added 4.10.2016
			'enabled'         : 'Aktivert', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Funksjonshemmet', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Søkeresultatene er tomme i gjeldende visning.\\ATrykk på [Enter] for å utvide søkemålet.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Søkeresultater for første bokstav er tomme i gjeldende visning.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Tekstetikett', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '$1 min igjen', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Åpne på nytt med valgt koding', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Lagre med valgt koding', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Velg mappe', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Første bokstavsøk', // from v2.1.23 added 24.3.2017
			'presets'         : 'Forhåndsinnstillinger', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Det er for mange gjenstander, så det kan ikke gå i søppel.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Tøm mappen "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'Det er ingen elementer i mappen "$1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'Preferanse', // from v2.1.26 added 28.6.2017
			'language'        : 'Språk', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Initialiser innstillingene som er lagret i denne nettleseren', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Verktøylinjeinnstillinger', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $1 tegn igjen.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $1 linjer igjen.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Sum', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Grov filstørrelse', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Fokuser på elementet av dialog med museover',  // from v2.1.30 added 2.11.2017
			'select'          : 'Plukke ut', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Handling når du velger fil', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Åpne med redigeringsprogrammet som ble brukt sist', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Inverter utvalg', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Er du sikker på at du vil gi nytt navn til $1 valgte elementer som $2?<br/>Dette kan ikke angres!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Gi nytt navn til batch', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Nummer', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Legg til prefiks', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Legg til suffiks', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Endre utvidelse', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Kolonneinnstillinger (listevisning)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Alle endringer vil umiddelbart gjenspeiles i arkivet.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Eventuelle endringer gjenspeiles ikke før demontering av dette volumet.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'Følgende volum(er) montert på dette volumet er også avmontert. Er du sikker på å demontere den?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Utvalg info', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Algoritmer for å vise filhash', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Infoelementer (utvalgsinfopanel)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Trykk igjen for å avslutte.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Verktøylinje', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Arbeidsplass', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Dialog', // from v2.1.38 added 4.4.2018
			'all'             : 'Alle', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Ikonstørrelse (ikonvisning)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Åpne vinduet for maksimert redigering', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Fordi konvertering via API for øyeblikket ikke er tilgjengelig, vennligst konverter på nettstedet.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Fordi konvertering via API for øyeblikket ikke er tilgjengelig, vennligst konverter på nettstedet.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Konverter på nettstedet til $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Integrasjoner', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'Denne elFinder har følgende eksterne tjenester integrert. Vennligst sjekk vilkårene for bruk, personvernerklæringen osv. før du bruker den.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Vis skjulte elementer', // from v2.1.41 added 24.7.2018
			'hideHidden'      : 'Skjul skjulte elementer', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Vis/skjul skjulte elementer', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Filtyper for å aktivere med "Ny fil"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Type tekstfil', // from v2.1.41 added 7.8.2018
			'add'             : 'Legge til', // from v2.1.41 added 7.8.2018
			'theme'           : 'Tema', // from v2.1.43 added 19.10.2018
			'default'         : 'Misligholde', // from v2.1.43 added 19.10.2018
			'description'     : 'Beskrivelse', // from v2.1.43 added 19.10.2018
			'website'         : 'Nettsted', // from v2.1.43 added 19.10.2018
			'author'          : 'Forfatter', // from v2.1.43 added 19.10.2018
			'email'           : 'E-post', // from v2.1.43 added 19.10.2018
			'license'         : 'Tillatelse', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Dette elementet kan ikke lagres. For å unngå å miste redigeringene må du eksportere til PC-en.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Dobbeltklikk på filen for å velge den.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Bruk fullskjermmodus', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Ukjent',
			'kindRoot'        : 'Volumrot', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Mappe',
			'kindSelects'     : 'Utvalg', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Snarvei',
			'kindAliasBroken' : 'Ugyldig snarvei',
			// applications
			'kindApp'         : 'Programfil',
			'kindPostscript'  : 'Postscript dokument',
			'kindMsOffice'    : 'Microsoft Office dokument',
			'kindMsWord'      : 'Microsoft Word dokument',
			'kindMsExcel'     : 'Microsoft Excel dokument',
			'kindMsPP'        : 'Microsoft Powerpoint-presentasjon',
			'kindOO'          : 'Open Office dokument',
			'kindAppFlash'    : 'Flash',
			'kindPDF'         : 'Portabelt dokument (PDF)',
			'kindTorrent'     : 'Bittorrent-fil',
			'kind7z'          : '7z arkiv',
			'kindTAR'         : 'TAR arkiv',
			'kindGZIP'        : 'GZIP arkiv',
			'kindBZIP'        : 'BZIP arkiv',
			'kindXZ'          : 'XZ arkiv',
			'kindZIP'         : 'ZIP arkiv',
			'kindRAR'         : 'RAR ar',
			'kindJAR'         : 'Java JAR-fil',
			'kindTTF'         : 'True Type-skrift',
			'kindOTF'         : 'Åpne Type font',
			'kindRPM'         : 'RPM-pakke',
			// texts
			'kindText'        : 'Tekst dokument',
			'kindTextPlain'   : 'Ren tekst',
			'kindPHP'         : 'PHP kilde',
			'kindCSS'         : 'Cascading stilark',
			'kindHTML'        : 'HTML dokument',
			'kindJS'          : 'Javascript',
			'kindRTF'         : 'Rikt Tekst Format',
			'kindC'           : 'C kilde',
			'kindCHeader'     : 'C header kilde',
			'kindCPP'         : 'C++ kilde',
			'kindCPPHeader'   : 'C++ header kilde',
			'kindShell'       : 'Unix-skallskript',
			'kindPython'      : 'Python kilde',
			'kindJava'        : 'Java kilde',
			'kindRuby'        : 'Ruby kilde',
			'kindPerl'        : 'Perl-manus',
			'kindSQL'         : 'SQL skilde',
			'kindXML'         : 'XML dokument',
			'kindAWK'         : 'AWK kilde',
			'kindCSV'         : 'Kommaseparerte verdier',
			'kindDOCBOOK'     : 'Docbook XML dokument',
			'kindMarkdown'    : 'Markdown-tekst', // added 20.7.2015
			// images
			'kindImage'       : 'Bilde',
			'kindBMP'         : 'BMP bilde',
			'kindJPEG'        : 'JPEG bilde',
			'kindGIF'         : 'GIF bilde',
			'kindPNG'         : 'PNG bilde',
			'kindTIFF'        : 'TIFF bilde',
			'kindTGA'         : 'TGA bilde',
			'kindPSD'         : 'Adobe Photoshop bilde',
			'kindXBITMAP'     : 'X bitmap bilde',
			'kindPXM'         : 'Pixelmator bilde',
			// media
			'kindAudio'       : 'Lydmedier',
			'kindAudioMPEG'   : 'MPEG-lyd',
			'kindAudioMPEG4'  : 'MPEG-4 lyd',
			'kindAudioMIDI'   : 'MIDI-lyd',
			'kindAudioOGG'    : 'Ogg Vorbis lyd',
			'kindAudioWAV'    : 'WAV-lyd',
			'AudioPlaylist'   : 'MP3 spilleliste',
			'kindVideo'       : 'Videomedier',
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

