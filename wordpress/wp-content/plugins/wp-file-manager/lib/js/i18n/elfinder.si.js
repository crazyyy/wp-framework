/**
 * Sinhala translation
 * @author CodeLyokoXtEAM <XcodeLyokoTEAM@gmail.com>
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
	elFinder.prototype.i18.si = {
		translator : 'CodeLyokoXtEAM &lt;XcodeLyokoTEAM@gmail.com&gt;',
		language   : 'Sinhala',
		direction  : 'ltr',
		dateFormat : 'Y.m.d h:i A', // will show like: 2020.08.31 05:03 PM
		fancyDateFormat : '$1 h:i A', // will show like: අද 05:03 PM
		nonameDateFormat : 'Ymd-His', // noname upload will show like: 20200831-170343
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'දෝෂයකි.',
			'errUnknown'           : 'නොදන්නා දෝෂයකි.',
			'errUnknownCmd'        : 'නොදන්නා විධානයකි.',
			'errJqui'              : 'වලංගු නොවන jQuery UI සැකැස්මකි. තේරිය හැකි, ඇදගෙන යාම සහ ඇද දැමිය හැකි කොටස් ඇතුළත් කළ යුතුය.',
			'errNode'              : 'ElFinder විසින් DOM Element නිර්මාණය කිරීමට අවශ්‍යව අැත.',
			'errURL'               : 'වලංගු නොවන elFinder සැකැස්මකි! URL විකල්පය සැකසා නැත.',
			'errAccess'            : 'භාවිතය අත්හිටුවා ඇත.',
			'errConnect'           : 'පසුබිම(Backend) වෙත සම්බන්ධ වීමට නොහැකිය.',
			'errAbort'             : 'සම්බන්ධතාවය වසාදමා ඇත.',
			'errTimeout'           : 'සම්බන්ධතා කල් ඉකුත්වී ඇත.',
			'errNotFound'          : 'පසුබිම(Backend) සොයාගත නොහැකි විය.',
			'errResponse'          : 'වලංගු නොවන පසුබිම(Backend) ප්‍රතිචාරය.',
			'errConf'              : 'වලංගු නොවන Backend සැකැස්මකි.',
			'errJSON'              : 'PHP JSON මොඩියුලය ස්ථාපනය කර නැත.',
			'errNoVolumes'         : 'කියවිය හැකි එ්කක(volumes) නොමැත.',
			'errCmdParams'         : '"$1" නම් විධානය වලංගු නොවන පරාමිතියකි.',
			'errDataNotJSON'       : 'JSON දත්ත නොවේ.',
			'errDataEmpty'         : 'හිස් දත්තයකි.',
			'errCmdReq'            : 'Backend සඳහා ඉල්ලන ලද විධානයේ නම අවශ්‍ය වේ.',
			'errOpen'              : '"$1" විවෘත කළ නොහැක.',
			'errNotFolder'         : 'අායිත්තම(object) ෆොල්ඩරයක් නොවේ.',
			'errNotFile'           : 'අායිත්තම(object) ගොනුවක් නොවේ.',
			'errRead'              : '"$1" කියවීමට නොහැක.',
			'errWrite'             : '"$1" තුල ලිවීමට නොහැකිය.',
			'errPerm'              : 'අවසරය නොමැත.',
			'errLocked'            : '"$1" අගුළු දමා ඇති අතර එය නැවත නම් කිරීම, සම්පූර්ණයෙන් විස්ථාපනය කිරීම හෝ ඉවත් කිරීම කළ නොහැක.',
			'errExists'            : '"$1" නම් ගොනුව දැනටමත් පවතී.',
			'errInvName'           : 'ගොනු නම වලංගු නොවේ.',
			'errInvDirname'        : 'ෆෝල්ඩර් නම වලංගු නොවේ.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'ෆෝල්ඩරය හමු නොවිණි.',
			'errFileNotFound'      : 'ගොනුව හමු නොවිණි.',
			'errTrgFolderNotFound' : 'ඉලක්කගත ෆෝල්ඩරය "$1" හමු නොවිනි.',
			'errPopup'             : 'බ්‍රවුසරය උත්පතන කවුළුව විවෘත කිරීම වළක්වයි. ගොනු විවෘත කිරීම සඳහා බ්‍රවුසරයේ විකල්ප තුළ එය සක්රිය කරන්න.',
			'errMkdir'             : '"$1" ෆෝල්ඩරය සෑදීමට නොහැකිය.',
			'errMkfile'            : '"$1" ගොනුව සෑදිය නොහැක.',
			'errRename'            : '"$1" නැවත නම් කිරීමට නොහැකි විය.',
			'errCopyFrom'          : '"$1" volume යෙන් ගොනු පිටපත් කිරීම තහනම්ය.',
			'errCopyTo'            : '"$1" volume යට ගොනු පිටපත් කිරීම තහනම්ය.',
			'errMkOutLink'         : 'volume root යෙන් පිටතට සබැඳිය(link) නිර්මාණය කිරීමට නොහැකි විය.', // from v2.1 added 03.10.2015
			'errUpload'            : 'උඩුගත(upload) කිරීමේ දෝෂයකි.',  // old name - errUploadCommon
			'errUploadFile'        : '"$1" උඩුගත(upload) කිරීමට නොහැකි විය.', // old name - errUpload
			'errUploadNoFiles'     : 'උඩුගත(upload) කිරීම සඳහා ගොනු කිසිවක් සොයාගත නොහැකි විය.',
			'errUploadTotalSize'   : 'දත්ත අවසර දී අැති උපරිම ප්‍රමාණය ඉක්මවා ඇත.', // old name - errMaxSize
			'errUploadFileSize'    : 'ගොනු අවසර දී අැති උපරිම ප්‍රමාණය ඉක්මවා ඇත.', //  old name - errFileMaxSize
			'errUploadMime'        : 'ගොනු වර්ගයට අවසර නැත.',
			'errUploadTransfer'    : '"$1" ව මාරු කිරීමේ දෝෂයකි.',
			'errUploadTemp'        : 'upload කිරීම සඳහා තාවකාලික ගොනුව සෑදිය නොහැක.', // from v2.1 added 26.09.2015
			'errNotReplace'        : '"$1" අායිත්තම(object) දැනටමත් මෙම ස්ථානයේ පවතී, වෙනත් වර්ගයකිනි ප්‍රතිස්ථාපනය කළ නොහැක.', // new
			'errReplace'           : '"$1" ප්‍රතිස්ථාපනය කළ නොහැක.',
			'errSave'              : '"$1" සුරැකීමට නොහැක.',
			'errCopy'              : '"$1" පිටපත් කිරීමට නොහැක.',
			'errMove'              : '"$1" සම්පූර්ණයෙන් විස්ථාපනය කිරීමට නොහැක.',
			'errCopyInItself'      : '"$1" තුලට පිටපත් කිරීමට නොහැක.',
			'errRm'                : '"$1" ඉවත් කිරීමට නොහැකි විය.',
			'errTrash'             : 'කුණු-කූඩය තුලට දැමීමට නොහැක.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'මූලාශ්‍රය ගොනු(ව) ඉවත් කළ නොහැක.',
			'errExtract'           : '"$1" වෙතින් ගොනු දිග හැරීමට නොහැක.',
			'errArchive'           : 'සංරක්ෂිතය සෑදීමට නොහැකි විය.',
			'errArcType'           : 'නොගැලපෙන සංරක්ෂණ වර්ගයකි.',
			'errNoArchive'         : 'ගොනුව නොගැලපෙන සංරක්ෂණ වර්ගයක් හෝ සංරක්ෂිතයක් නොවේ.',
			'errCmdNoSupport'      : 'පසුබිම(Backend) මෙම විධානය නොදනී.',
			'errReplByChild'       : '"$1" ෆෝල්ඩරය එහිම අඩංගු අයිතමයක් මගින් ප්‍රතිස්ථාපනය කළ නොහැක.',
			'errArcSymlinks'       : 'ආරක්ෂිත හේතුව නිසා අනුමත නොකෙරෙන සබැඳි සම්බන්දතා හෝ ලිපිගොනු නම් අඩංගු බැවින් සංරක්ෂිතය දිග හැරීම කිරීමට ඉඩ නොදෙන.', // edited 24.06.2012
			'errArcMaxSize'        : 'සංරක්ෂිතය ලිපිගොනු උපරිම ප්‍රමාණය ඉක්මවා ඇත.',
			'errResize'            : 'ප්‍රතිප්‍රමාණය කිරීමට නොහැකි විය.',
			'errResizeDegree'      : 'වලංගු නොවන භ්‍රමණ කෝණයකි.',  // added 7.3.2013
			'errResizeRotate'      : 'රූපය භ්‍රමණය කිරීමට නොහැකි විය.',  // added 7.3.2013
			'errResizeSize'        : 'රූපයේ ප්‍රමාණය වලංගු නොවේ.',  // added 7.3.2013
			'errResizeNoChange'    : 'රූපයේ ප්‍රමාණය වෙනස් නොවුණි.',  // added 7.3.2013
			'errUsupportType'      : 'නොගැලපෙන ගොනු වර්ගයකි.',
			'errNotUTF8Content'    : '"$1" ගොනුව UTF-8 හි නොමැති අතර සංස්කරණය කළ නොහැක.',  // added 9.11.2011
			'errNetMount'          : '"$1" සවි(mount) කිරීමට නොහැක.', // added 17.04.2012
			'errNetMountNoDriver'  : 'ප්‍රොටොකෝලය(protocol) නොගැලපේ.',     // added 17.04.2012
			'errNetMountFailed'    : 'සවි කිරීම(mount කිරීම) අසාර්ථක විය.',         // added 17.04.2012
			'errNetMountHostReq'   : 'ධාරකය(Host) අවශ්‍ය වේ.', // added 18.04.2012
			'errSessionExpires'    : 'ඔබේ අක්‍රියතාව හේතුවෙන් සැසිය(session) කල් ඉකුත් වී ඇත.',
			'errCreatingTempDir'   : 'තාවකාලික ඩිරෙක්ටරයක්(directory) ​​සෑදිය නොහැක: "$1"',
			'errFtpDownloadFile'   : 'FTP වලින් ගොනුව බාගත(download) කිරීමට නොහැකි විය: "$1"',
			'errFtpUploadFile'     : 'ගොනුව FTP වෙත උඩුගත(upload) කිරීමට නොහැකි විය: "$1"',
			'errFtpMkdir'          : 'FTP මත දුරස්ථ නාමාවලියක්(remote directory) නිර්මාණය කිරීමට නොහැකි විය: "$1"',
			'errArchiveExec'       : 'ගොනු සංරක්ෂණය(archiving) කිරීමේදී දෝෂයක් ඇතිවිය: "$1"',
			'errExtractExec'       : 'ගොනු දිගහැරීමේදී(extracting) දෝෂයක් ඇතිවිය: "$1"',
			'errNetUnMount'        : 'විසන්ධි කිරීමට(unmount) නොහැක.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'UTF-8 වෙත පරිවර්තනය කළ නොහැක.', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'ඔබ ෆෝල්ඩරය උඩුගත(upload) කිරීමට කැමති නම් නවීන බ්‍රවුසරයකින් උත්සාහ කරන්න.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : '"$1" සෙවීම කල් ඉකුත්වී ඇත. සෙවුම් ප්‍රතිඵල අර්ධ වශයෙන් දිස්වේ.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'නැවත බලය(Re-authorization) ලබා දීම අවශ්‍ය වේ.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'තෝරා ගත හැකි උපරිම අයිතම සංඛ්‍යාව $1 ක් වේ.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'කුණු කූඩයෙන් නැවත ලබා ගත නොහැක. යළි පිහිටුවීමේ ගමනාන්තය(restore destination) හඳුනාගත නොහැක.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'මෙම ගොනු වර්ගයේ සංස්කාරකය හමු නොවිණි.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'සේවාදායකයේ පැත්තෙන්(server side) දෝශයක් ඇතිවිය.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : '"$1" ෆෝල්ඩරය හිස් කිරීමට නොහැක.', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'තවත් $ 1 දෝෂ තිබේ.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'සංරක්ෂිතය(archive) නිර්මාණය කරන්න',
			'cmdback'      : 'ආපසු',
			'cmdcopy'      : 'පිටපත් කරන්න',
			'cmdcut'       : 'මුළුමනින්ම පිටපත් කරන්න(Cut)',
			'cmddownload'  : 'බාගත කරන්න(Download)',
			'cmdduplicate' : 'අනුපිටපත් කරන්න(Duplicate)',
			'cmdedit'      : 'ගොනුව සංස්කරණය කරන්න',
			'cmdextract'   : 'සංරක්ෂිතයේ ගොනු දිගහරින්න(Extract)',
			'cmdforward'   : 'ඉදිරියට',
			'cmdgetfile'   : 'ගොනු තෝරන්න',
			'cmdhelp'      : 'මෙම මෘදුකාංගය පිළිබඳව',
			'cmdhome'      : 'නිවහන(Home)',
			'cmdinfo'      : 'තොරතුරු ලබාගන්න',
			'cmdmkdir'     : 'අළුත් ෆෝල්ඩරයක්',
			'cmdmkdirin'   : 'අළුත් ෆෝල්ඩරයක් තුළට', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'නව ගොනුවක්',
			'cmdopen'      : 'විවෘත කරන්න',
			'cmdpaste'     : 'දමන්න(Paste)',
			'cmdquicklook' : 'පූර්ව දර්ශනයක්(Preview)',
			'cmdreload'    : 'නැවත අළුත් කරන්න(Reload)',
			'cmdrename'    : 'නම වෙනස් කරන්න',
			'cmdrm'        : 'මකන්න',
			'cmdtrash'     : 'කුණු කූඩයට දමන්න', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'යළි පිහිටුවන්න(Restore)', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'ගොනු සොයන්න',
			'cmdup'        : 'ප්‍ර්‍රධාන නාමාවලිය(parent directory) වෙත යන්න',
			'cmdupload'    : 'ගොනු උඩුගත(Upload) කරන්න',
			'cmdview'      : 'දර්ශනය(View)',
			'cmdresize'    : 'ප්‍රථිප්‍රමාණය සහ භ්‍රමණය',
			'cmdsort'      : 'වර්ගීකරණය කරන්න',
			'cmdnetmount'  : 'ජාල එ්කකයක් සවි කරන්න(Mount network volume)', // added 18.04.2012
			'cmdnetunmount': 'ගලවන්න(Unmount)', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'පහසු ස්ථානයට(To Places)', // added 28.12.2014
			'cmdchmod'     : 'ක්‍රමය වෙනස් කරන්න', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'ෆෝල්ඩරය විවෘත කරන්න', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'නැවත තීරු පළල පිහිටුවන්න', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'පුළුල් තිරය', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'මාරු කරන්න(Move)', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'ෆෝල්ඩරය හිස් කරන්න', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'නිෂ්ප්‍රභ කරන්න', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'නැවත කරන්න', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'අභිමතයන් (Preferences)', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'සියල්ල තෝරන්න', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'කිසිවක් තෝරන්න එපා', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'විරුද්ධ අාකාරයට තෝරන්න', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'නව කවුළුවකින් විවෘත කරන්න', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'සඟවන්න (මනාපය)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'වසන්න',
			'btnSave'   : 'සුරකින්න',
			'btnRm'     : 'ඉවත් කරන්න',
			'btnApply'  : 'යොදන්න(Apply)',
			'btnCancel' : 'අවලංගු කරන්න',
			'btnNo'     : 'නැත',
			'btnYes'    : 'ඔව්',
			'btnMount'  : 'සවිකිරීම(Mount)',  // added 18.04.2012
			'btnApprove': 'කරුණාකර $1 අනුමත කරන්න', // from v2.1 added 26.04.2012
			'btnUnmount': 'ගලවන්න(Unmount)', // from v2.1 added 30.04.2012
			'btnConv'   : 'පරිවර්තනය කරන්න', // from v2.1 added 08.04.2014
			'btnCwd'    : 'මෙතන',      // from v2.1 added 22.5.2015
			'btnVolume' : 'එ්කකය(Volume)',    // from v2.1 added 22.5.2015
			'btnAll'    : 'සියල්ල',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME වර්ගය', // from v2.1 added 22.5.2015
			'btnFileName':'ගොනුවේ නම',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'සුරකින්න සහ වසන්න', // from v2.1 added 12.6.2015
			'btnBackup' : 'උපස්ථ(Backup) කරන්න', // fromv2.1 added 28.11.2015
			'btnRename'    : 'නම වෙනස් කරන්න',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'නම වෙනස් කරන්න(සියල්ල)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'පෙර ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'ඊළඟ ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'වෙනත් නමකින් සුරකිමින්(Save As)', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'ෆෝල්ඩරය විවෘත කරමින්',
			'ntffile'     : 'ගොනුව විවෘත කරමින්',
			'ntfreload'   : 'ෆෝල්ඩර් අන්තර්ගතය නැවත අළුත් කරමින්(Reloading)',
			'ntfmkdir'    : 'ෆෝල්ඩරයක් නිර්මාණය කරමින්',
			'ntfmkfile'   : 'ගොනුව නිර්මාණය කරමින්',
			'ntfrm'       : 'අයිතමයන් මකමින්',
			'ntfcopy'     : 'අයිතමයන් පිටපත් කරමින්',
			'ntfmove'     : 'අයිතමයන් සම්පූර්ණයෙන් විස්ථාපනය කරමින්',
			'ntfprepare'  : 'පවතින අයිතම පිරික්සමින්',
			'ntfrename'   : 'ගොනු නැවත නම් කරමින්',
			'ntfupload'   : 'ගොනු උඩුගත(uploading) කරමින්',
			'ntfdownload' : 'ගොනු බාගත(downloading) කරමින්',
			'ntfsave'     : 'ගොනු සුරකිමින්',
			'ntfarchive'  : 'සංරක්ෂණය(archive) සාදමින්',
			'ntfextract'  : 'සංරක්ෂණයෙන්(archive) ගොනු දිගහරිමින්(Extracting)',
			'ntfsearch'   : 'ගොනු සොයමින්',
			'ntfresize'   : 'රූප ප්‍රමාණය වෙනස් කරමින්',
			'ntfsmth'     : 'දෙයක් කරමින්',
			'ntfloadimg'  : 'පින්තූරය පූරණය කරමින්(Loading)',
			'ntfnetmount' : 'ජාල එ්කකයක් සවිකරමින්(Mounting network volume)', // added 18.04.2012
			'ntfnetunmount': 'ජාල එ්කකයක් ගලවමින්(Unmounting network volume)', // from v2.1 added 30.04.2012
			'ntfdim'      : 'පිංතූරයේ මානය(dimension) ලබාගනිමින්', // added 20.05.2013
			'ntfreaddir'  : 'ෆෝල්ඩරයේ තොරතුරු කියවමින්', // from v2.1 added 01.07.2013
			'ntfurl'      : 'සබැඳියේ URL ලබා ගැනීම', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'ගොනු ආකරය වෙනස් කරමින්', // from v2.1 added 20.6.2015
			'ntfpreupload': 'උඩුගත(upload) කරන ලද ගොනු නාමය සත්‍යාපනය කරමින්(Verifying)', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'බාගත කරගැනීම(download) සඳහා ගොනුවක් නිර්මාණය කරමින්', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'මාර්ග(path) තොරතුරු ලබා ගනිමින්', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'උඩුගත කරන ලද(uploaded) ගොනුව සකසමින්', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'කුණු කූඩයට දමමින්', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'කුණු කූඩයට දැමීම යළි පිහිටුවමින්(Doing restore)', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'ගමනාන්ත(destination) ෆෝල්ඩරය පරීක්ෂා කරමින්', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'පෙර මෙහෙයුම(operation) ඉවත් කරමින්', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'පෙර ආපසු හැරවීම යළි සැකසමින්', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'අන්තර්ගතය පරීක්ෂා කිරීම', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'කුණු කූඩය', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'නොදනී',
			'Today'       : 'අද',
			'Yesterday'   : 'ඊයේ',
			'msJan'       : 'ජනවා.',
			'msFeb'       : 'පෙබ.',
			'msMar'       : 'මාර්.',
			'msApr'       : 'අප්‍රේ.',
			'msMay'       : 'මැයි',
			'msJun'       : 'ජූනි',
			'msJul'       : 'ජුලි',
			'msAug'       : 'අගෝ.',
			'msSep'       : 'සැප්.',
			'msOct'       : 'ඔක්තෝ.',
			'msNov'       : 'නොවැ.',
			'msDec'       : 'දෙසැ.',
			'January'     : 'ජනවාරි',
			'February'    : 'පෙබරවාරි',
			'March'       : 'මාර්තු',
			'April'       : 'අප්‍රේල්',
			'May'         : 'මැයි',
			'June'        : 'ජූනි',
			'July'        : 'ජුලි',
			'August'      : 'අගෝස්තු',
			'September'   : 'සැප්තැම්බර්',
			'October'     : 'ඔක්තෝම්බර්',
			'November'    : 'නොවැම්බර්',
			'December'    : 'දෙසැම්බර්',
			'Sunday'      : 'ඉරිදා',
			'Monday'      : 'සඳුදා',
			'Tuesday'     : 'අඟහරුවාදා',
			'Wednesday'   : 'බදාදා',
			'Thursday'    : 'බ්‍රහස්පතින්දා',
			'Friday'      : 'සිකුරාදා',
			'Saturday'    : 'සෙනසුරාදා',
			'Sun'         : 'ඉරිදා',
			'Mon'         : 'සඳු.',
			'Tue'         : 'අඟහ.',
			'Wed'         : 'බදාදා',
			'Thu'         : 'බ්‍රහස්.',
			'Fri'         : 'සිකු.',
			'Sat'         : 'සෙන.',

			/******************************** sort variants ********************************/
			'sortname'          : 'නම අනුව',
			'sortkind'          : 'වර්ගය අනුව',
			'sortsize'          : 'ප්‍රමාණය අනුව',
			'sortdate'          : 'දිනය අනුව',
			'sortFoldersFirst'  : 'ෆෝල්ඩර වලට පළමු තැන',
			'sortperm'          : 'අවසරය අනුව', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'අාකාරය අනුව',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'හිමිකරු අනුව',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'කණ්ඩායම අනුව',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'එලෙසටම රුක්සටහනත්(Treeview)',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'නව ෆෝල්ඩරයක්',   // added 10.11.2015
			'Archive'           : 'නිව්ආර්කයිව්',  // from v2.1 added 10.11.2015
			'untitled file'     : 'නිව් ෆයිල් $ 1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$ 1: ගොනුව',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'තහවුරු කිරීම අවශ්‍යයි',
			'confirmRm'       : 'අයිතමයන් සදහටම ඉවත් කිරීමට අවශ්‍ය බව ඔබට විශ්වාසද?<br/>මෙය අාපසු හැරවිය නොහැකිය!',
			'confirmRepl'     : 'පැරණි අයිතමය නව එකක මගින් ප්‍රතිස්ථාපනය කරන්නද?',
			'confirmRest'     : 'දැනට පවතින අයිතමය කුණු කූඩය තුළ පවතින අයිතමය මගින් ප්‍රතිස්ථාපනය කරන්නද?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'UTF-8 හි නොවේ<br/> UTF-8 වෙත පරිවර්තනය කරන්න ද?<br/>සුරැකීමෙන් පසු අන්තර්ගතය UTF-8 බවට පරිවර්තනය වේ.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'මෙම ගොනුවෙහි කේතන කේත(Character encoding) හඳුනාගත නොහැකි විය. සංස්කරණ කිරීමට එය තාවකාලිකව UTF-8 වෙත පරිවර්තනය කිරීම අවශ්‍ය වේ.<br/>කරුණාකර මෙම ගොනුවෙහි අක්ෂර කේතන කේත(character encoding) තෝරන්න.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'මෙය වෙනස් කර ඇත.<br/>ඔබට වෙනස්කම් සුරැකීමට නොහැකි නම් සිදු කරනු ලැබූ වෙනස්කම් අහිමි වේ.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'කුණු කූඩය තුලට අයිතමය යැවීමට ඔබට අවශ්‍ය ද?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'ඔබට "$ 1" වෙත අයිතම ගෙනයාමට අවශ්‍ය බව ඔබට විශ්වාසද?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'සියල්ලටම යොදන්න',
			'name'            : 'නම',
			'size'            : 'ප්‍රමාණය',
			'perms'           : 'අවසරය',
			'modify'          : 'නවීකරණය කෙරුණ ලද්දේ',
			'kind'            : 'ජාතිය',
			'read'            : 'කියවන්න',
			'write'           : 'ලියන්න',
			'noaccess'        : 'ප්‍රවේශයක් නොමැත',
			'and'             : 'සහ',
			'unknown'         : 'නොහඳුනයි',
			'selectall'       : 'සියලු ගොනු තෝරන්න',
			'selectfiles'     : 'ගොනු(ව) තෝරන්න',
			'selectffile'     : 'පළමු ගොනුව තෝරන්න',
			'selectlfile'     : 'අවසාන ගොනුව තෝරන්න',
			'viewlist'        : 'ලැයිස්තු අාකාරය',
			'viewicons'       : 'අයිකන අාකාරය',
			'viewSmall'       : 'කුඩා අයිකන', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'මධ්‍යම අයිකන', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'විශාල අයිකන', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'අමතර විශාල අයිකන', // from v2.1.39 added 22.5.2018
			'places'          : 'ස්ථාන',
			'calc'            : 'ගණනය කරන්න',
			'path'            : 'මාර්ගය',
			'aliasfor'        : 'අන්වර්ථය',
			'locked'          : 'අගුළු දමා ඇත',
			'dim'             : 'මාන(Dimensions)',
			'files'           : 'ගොනු',
			'folders'         : 'ෆෝල්ඩර',
			'items'           : 'අයිතම(Items)',
			'yes'             : 'ඔව්',
			'no'              : 'නැත',
			'link'            : 'සබැඳිය(Link)',
			'searcresult'     : 'සෙවුම් ප්‍රතිඵල',
			'selected'        : 'තෝරාගත් අයිතම',
			'about'           : 'මේ ගැන',
			'shortcuts'       : 'කෙටිමං',
			'help'            : 'උදව්',
			'webfm'           : 'වෙබ් ගොනු කළමනාකරු',
			'ver'             : 'අනුවාදය(version)',
			'protocolver'     : 'ප්‍රොටොකෝලය අනුවාදය(protocol version)',
			'homepage'        : 'ව්‍යාපෘතිය නිවහන',
			'docs'            : 'ලේඛනගත කිරීම',
			'github'          : 'Github හරහා සංවාදයේ යෙදෙන්න',
			'twitter'         : 'Twitter හරහා අපව සම්බන්ධ වන්න',
			'facebook'        : 'Facebook හරහා අප සමඟ එකතු වන්න',
			'team'            : 'කණ්ඩායම',
			'chiefdev'        : 'ප්‍රධාන සංස්කරු(chief developer)',
			'developer'       : 'සංස්කරු(developer)',
			'contributor'     : 'දායකයා(contributor)',
			'maintainer'      : 'නඩත්තු කරන්නා(maintainer)',
			'translator'      : 'පරිවර්තකයා',
			'icons'           : 'අයිකන',
			'dontforget'      : 'ඔබේ තුවාය ගැනීමට අමතක නොකරන්න',
			'shortcutsof'     : 'කෙටිමං අක්‍රීය කර ඇත',
			'dropFiles'       : 'ගොනු මෙතැනට ඇද දමන්න',
			'or'              : 'හෝ',
			'selectForUpload' : 'ගොනු තෝරන්න',
			'moveFiles'       : 'අායිත්තම සම්පූර්ණයෙන් විස්ථාපනය',
			'copyFiles'       : 'අයිතමයන් පිටපත් කරන්න',
			'restoreFiles'    : 'අයිතම ප්‍රතිස්ථාපනය කරන්න', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'ස්ථාන වලින් ඉවත් කරන්න',
			'aspectRatio'     : 'දර්ශන අනුපාතය(Aspect ratio)',
			'scale'           : 'පරිමාණය',
			'width'           : 'පළල',
			'height'          : 'උස',
			'resize'          : 'ප්‍රතිප්‍රමානණය',
			'crop'            : 'බෝග',
			'rotate'          : 'කැරකැවීම',
			'rotate-cw'       : 'අංශක 90කින් කරකවන්න CW',
			'rotate-ccw'      : 'අංශක 90කින් කරකවන්න CCW',
			'degree'          : '°',
			'netMountDialogTitle' : 'ජාල පරිමාව සවි කරන්න', // added 18.04.2012
			'protocol'            : 'ප්රොටෝකෝලය', // added 18.04.2012
			'host'                : 'සත්කාරක', // added 18.04.2012
			'port'                : 'වරාය', // added 18.04.2012
			'user'                : 'පරිශීලක', // added 18.04.2012
			'pass'                : 'මුරපදය', // added 18.04.2012
			'confirmUnmount'      : 'ඔබ ඩොලර් 1 ක් ඉවත් කරන්නේද?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'බ්‍රව්සරයෙන් ගොනු අතහරින්න හෝ අලවන්න', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'ලිපිගොනු අතහරින්න, URL හෝ පින්තූර අලවන්න (ක්ලිප්බෝඩ්) මෙහි', // from v2.1 added 07.04.2014
			'encoding'        : 'කේතීකරණය(Encoding)', // from v2.1 added 19.12.2014
			'locale'          : 'පෙදෙසි',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'ඉලක්කය: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'ආදානය අනුව සොයන්න MIME වර්ගය', // from v2.1 added 22.5.2015
			'owner'           : 'හිමිකරු', // from v2.1 added 20.6.2015
			'group'           : 'සමූහය', // from v2.1 added 20.6.2015
			'other'           : 'වෙනත්', // from v2.1 added 20.6.2015
			'execute'         : 'ක්‍රයාත්මක කරන්න', // from v2.1 added 20.6.2015
			'perm'            : 'අවසරය', // from v2.1 added 20.6.2015
			'mode'            : 'මාදිලිය', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'ෆෝල්ඩරය හිස්', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'ෆාේල්ඩරය හිස්\\A අායිත්තම අතහැරීමෙන් අැතුලු කරන්න', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'ෆාේල්ඩරය හිස්\\A දිර්ඝ එබීමෙන් අායිත්තම අැතුලු කරන්න', // from v2.1.6 added 30.12.2015
			'quality'         : 'ගුණාත්මකභාවය', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'ස්වයංක්‍රීය සමමුහුර්තකරණය',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'ඉහළට යන්න',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'URL සබැඳිය ලබා ගන්න', // from v2.1.7 added 9.2.2016
			'share'           : 'බෙදාගන්න',
			'selectedItems'   : 'තෝරාගත් අයිතම ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'ෆෝල්ඩර හැඳුනුම්පත', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'නොබැඳි ප්‍රවේශයට ඉඩ දෙන්න', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'නැවත සත්‍යාපනය කිරීමට', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'දැන් පටවනවා ...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'බහු ගොනු විවෘත කරන්න', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'ඔබ $1 ගොනු විවෘත කිරීමට උත්සාහ කරයි. බ්‍රව්සරයෙන් ඔබට විවෘත කිරීමට අවශ්‍ය බව ඔබට විශ්වාසද?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'සෙවුම් ඉලක්කයේ ගවේෂණ ප්‍රතිඵල නොමැත.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'එය ගොනුව සංස්කරණය කිරීමකි.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'ඔබ අයිතම $1 ප්‍රමාණයක් තෝරාගෙන ඇත.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'ඔබට ක්ලිප් පුවරුවේ අයිතම 1 ක් ඇත.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'වැඩිවන සෙවීම වත්මන් දෘෂ්ටියෙන් පමණි.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'යථා තත්ත්වයට පත් කරන්න', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 සම්පූර්ණයි', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'සන්දර්භය මෙනුව', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'පිටු හැරීම', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'පරිමාවේ මුල්', // from v2.1.16 added 16.9.2016
			'reset'           : 'යළි පිහිටුවන්න(Reset)', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'පසුබිම් වර්ණය', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'වර්ණ අච්චාරු', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : 'පික්සල් 8ක දැල', // from v2.1.16 added 4.10.2016
			'enabled'         : 'සක්‍රීයයි', // from v2.1.16 added 4.10.2016
			'disabled'        : 'අක්‍රීයයි', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'වර්තමාන දර්ශනය තුළ සෙවුම් ප්‍රතිපල හිස්ව ඇත. \\A සෙවුම් ඉලක්කය පුළුල් කිරීම සඳහා [Enter] යතුර ඔබන්න.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'වර්තමාන දර්ශනයේ පළමු අකුර සෙවුම් ප්‍රතිපල හිස්ව පවතී.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'ලේබල්වල නම්', // from v2.1.17 added 13.10.2016
			'minsLeft'        : 'විනාඩි $1 ක් ගතවේ', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'තෝරාගත් කේතන ක්‍රම සමඟ නැවත විවෘත කරන්න', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'තෝරාගත් කේතන ක්‍රමය සමඟ සුරකින්න', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'ෆෝල්ඩරය තෝරන්න', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'පළමු අකුරෙන් සෙවීම', // from v2.1.23 added 24.3.2017
			'presets'         : 'පෙරසිටුවීම්', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'එය බොහෝ අයිතම බැවින් එය කුණු කූඩයට දැමිය නොහැක.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : '"$ 1" ෆෝල්ඩරය හිස් කරන්න.', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : '"$ 1" ෆෝල්ඩරයේ අයිතම නොමැත.', // from v2.1.25 added 22.6.2017
			'preference'      : 'මනාපය', // from v2.1.26 added 28.6.2017
			'language'        : 'Language setting', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'මෙම බ්‍රව්සරයේ සුරකින ලද සැකසුම් ආරම්භ කරන්න', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Toolbar setting', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $1 ක් අකුරු ඉතිරිව පවතී',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... lines පේළි 1 ක් ඉතිරිව ඇත.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'එකතුව', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'රළු ගොනු ප්‍රමාණය', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'මූසිකය සමඟ සංවාදයේ අංගය කෙරෙහි අවධානය යොමු කරන්න',  // from v2.1.30 added 2.11.2017
			'select'          : 'තෝරන්න', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'ගොනුවක් තේරූ විට සිදුකල යුතු දේ', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'අවසන් වරට භාවිතා කළ සංස්කාරකය සමඟ විවෘත කරන්න', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'ප්‍රතිවිරුද්ධ අාකාරයට තෝරන්න', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Selected 2 වැනි තෝරාගත් අයිතම $ 1 ලෙස නම් කිරීමට ඔබට විශ්වාසද? <br/> මෙය අවලංගු කළ නොහැක!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'කණ්ඩායම නැවත නම් කිරීම', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ අංකය', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'උපසර්ගය එක් කරන්න', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'උපසර්ගය එක් කරන්න', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'දිගුව වෙනස් කරන්න', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'තීරු සැකසුම් (ලැයිස්තු දර්ශනය)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'සියලුම වෙනස්කම් වහාම සංරක්ෂිතයට පිළිබිඹු වේ.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'මෙම පරිමාව සවිකරන තෙක් කිසිදු වෙනස්කමක් පිළිබිඹු නොවේ.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'මෙම පරිමාව මත සවි කර ඇති පහත දැක්වෙන පරිමාව (ය) ද ගණන් කර නැත. ඔබට එය ඉවත් කිරීමට විශ්වාසද?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'තෝරාගැනීම්වල තොරතුරු', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'ගොනු හැෂ් පෙන්වීමට ඇල්ගොරිතම', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'තොරතුරු අයිතම (තෝරා ගැනීමේ තොරතුරු පැනලය)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'පිටවීමට නැවත ඔබන්න.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'මෙවලම් තීරුව', // from v2.1.38 added 4.4.2018
			'workspace'       : 'වැඩ අවකාශය', // from v2.1.38 added 4.4.2018
			'dialog'          : 'ඩයලොග්', // from v2.1.38 added 4.4.2018
			'all'             : 'සියලුම', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'අයිකන ප්‍රමාණය (අයිකන දර්ශනය)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'උපරිම සංස්කාරක කවුළුව විවෘත කරන්න', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'API මගින් පරිවර්තනය කිරීම දැනට නොමැති බැවින් කරුණාකර වෙබ් අඩවියට හරවන්න.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'පරිවර්තනය කිරීමෙන් පසු, පරිවර්තනය කළ ගොනුව සුරැකීමට ඔබ අයිතම URL හෝ බාගත කළ ගොනුවක් සමඟ උඩුගත කළ යුතුය.', //from v2.1.40 added 8.7.2018
			'convertOn'       : '$ 1 අඩවියේ පරිවර්තනය කරන්න', // from v2.1.40 added 10.7.2018
			'integrations'    : 'අනුකලනයන්', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'මෙම elFinder පහත දැක්වෙන බාහිර සේවාවන් ඒකාබද්ධ කර ඇත. කරුණාකර එය භාවිතා කිරීමට පෙර භාවිත නියමයන්, රහස්‍යතා ප්‍රතිපත්තිය ආදිය පරීක්ෂා කරන්න.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'සැඟවුණු අයිතම පෙන්වන්න', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'කේත සංස්කාරකය',
			'hideHidden'      : 'සැඟවුණු අයිතම සඟවන්න', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'සැඟවුණු අයිතම පෙන්වන්න / සඟවන්න', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : '"නව ගොනුව" සමඟ සක්‍රීය කිරීමට ගොනු වර්ග', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'පෙළ ගොනුවේ වර්ගය', // from v2.1.41 added 7.8.2018
			'add'             : 'එකතු කරන්න', // from v2.1.41 added 7.8.2018
			'theme'           : 'තේමාව', // from v2.1.43 added 19.10.2018
			'default'         : 'පෙරනිමිය', // from v2.1.43 added 19.10.2018
			'description'     : 'විස්තර', // from v2.1.43 added 19.10.2018
			'website'         : 'වෙබ් අඩවිය', // from v2.1.43 added 19.10.2018
			'author'          : 'කර්තෘ', // from v2.1.43 added 19.10.2018
			'email'           : 'විද්යුත් තැපෑල', // from v2.1.43 added 19.10.2018
			'license'         : 'බලපත්රය', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'මෙම අයිතමය සුරැකිය නොහැක. සංස්කරණ නැතිවීම වළක්වා ගැනීම සඳහා ඔබේ පරිගණකයට අපනයනය කළ යුතුය.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'ගොනුව තේරීමට එය මත දෙවරක් ක්ලික් කරන්න.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'පූර්ණ තිර ප්‍රකාරය භාවිතා කරන්න', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'නොදන්නා',
			'kindRoot'        : 'වෙළුම් මූලය', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'ෆෝල්ඩරය',
			'kindSelects'     : 'තේරීම්', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'අන්වර්ථය',
			'kindAliasBroken' : 'කැඩුණු අන්වර්ථය',
			// applications
			'kindApp'         : 'අයදුම්පත',
			'kindPostscript'  : 'Postscript ලේඛනය',
			'kindMsOffice'    : 'Microsoft Office ලේඛනය',
			'kindMsWord'      : 'Microsoft Word ලේඛනය',
			'kindMsExcel'     : 'Microsoft Excel ලේඛනය',
			'kindMsPP'        : 'මයික්‍රොසොෆ්ට් පවර්පොයින්ට් ඉදිරිපත් කිරීම',
			'kindOO'          : 'Open Office ලේඛනය',
			'kindAppFlash'    : 'ෆ්ලෑෂ් යෙදුම',
			'kindPDF'         : 'අතේ ගෙන යා හැකි ලේඛන ආකෘතිය (PDF)',
			'kindTorrent'     : 'බිටෝරන්ට් ගොනුව',
			'kind7z'          : '7z සංරක්ෂිතය',
			'kindTAR'         : 'TAR සංරක්ෂිතය',
			'kindGZIP'        : 'GZIP සංරක්ෂිතය',
			'kindBZIP'        : 'BZIP සංරක්ෂිතය',
			'kindXZ'          : 'XZ සංරක්ෂිතය',
			'kindZIP'         : 'ZIP සංරක්ෂිතය',
			'kindRAR'         : 'RAR සංරක්ෂිතය',
			'kindJAR'         : 'ජාවා JAR ගොනුව',
			'kindTTF'         : 'සත්‍ය වර්ගයේ අකුරු',
			'kindOTF'         : 'අකුරු විවෘත කරන්න',
			'kindRPM'         : 'RPM පැකේජය',
			// texts
			'kindText'        : 'Text ලේඛනය',
			'kindTextPlain'   : 'සරල පෙළ',
			'kindPHP'         : 'PHP මූලාශ්‍රය',
			'kindCSS'         : 'කැස්කැඩින් ස්ටයිල් ෂීට්',
			'kindHTML'        : 'HTML ලේඛනය',
			'kindJS'          : 'Javascript මූලාශ්‍රය',
			'kindRTF'         : 'පොහොසත් පෙළ ආකෘතිය',
			'kindC'           : 'C මූලාශ්‍රය',
			'kindCHeader'     : 'C header මූලාශ්‍රය',
			'kindCPP'         : 'C++ මූලාශ්‍රය',
			'kindCPPHeader'   : 'C++ header මූලාශ්‍රය',
			'kindShell'       : 'Unix shell රචනයකි',
			'kindPython'      : 'Python මූලාශ්‍රය',
			'kindJava'        : 'Java මූලාශ්‍රය',
			'kindRuby'        : 'Ruby මූලාශ්‍රය',
			'kindPerl'        : 'Perl රචනයකි',
			'kindSQL'         : 'SQL මූලාශ්‍රය',
			'kindXML'         : 'XML ලේඛනය',
			'kindAWK'         : 'AWK මූලාශ්‍රය',
			'kindCSV'         : 'කොමාවන් වෙන් කළ අගයන්',
			'kindDOCBOOK'     : 'Docbook XML ලේඛනය',
			'kindMarkdown'    : 'සලකුණු කිරීමේ පෙළ', // added 20.7.2015
			// images
			'kindImage'       : 'පින්තූරය',
			'kindBMP'         : 'BMP පින්තූරය',
			'kindJPEG'        : 'JPEG පින්තූරය',
			'kindGIF'         : 'GIF පින්තූරය',
			'kindPNG'         : 'PNG පින්තූරය',
			'kindTIFF'        : 'TIFF පින්තූරය',
			'kindTGA'         : 'TGA පින්තූරය',
			'kindPSD'         : 'Adobe Photoshop පින්තූරය',
			'kindXBITMAP'     : 'X bitmap පින්තූරය',
			'kindPXM'         : 'Pixelmator පින්තූරය',
			// media
			'kindAudio'       : 'ශබ්ධ මාධ්‍ය',
			'kindAudioMPEG'   : 'MPEG ශබ්ධපටය',
			'kindAudioMPEG4'  : 'MPEG-4 ශබ්ධපටය',
			'kindAudioMIDI'   : 'MIDI ශබ්ධපටය',
			'kindAudioOGG'    : 'Ogg Vorbis ශබ්ධපටය',
			'kindAudioWAV'    : 'WAV ශබ්ධපටය',
			'AudioPlaylist'   : 'MP3 ධාවන ලැයිස්තුව',
			'kindVideo'       : 'Video මාධ්‍ය',
			'kindVideoDV'     : 'DV චිත්‍රපටය',
			'kindVideoMPEG'   : 'MPEG චිත්‍රපටය',
			'kindVideoMPEG4'  : 'MPEG-4 චිත්‍රපටය',
			'kindVideoAVI'    : 'AVI චිත්‍රපටය',
			'kindVideoMOV'    : 'Quick Time චිත්‍රපටය',
			'kindVideoWM'     : 'Windows Media චිත්‍රපටය',
			'kindVideoFlash'  : 'Flash චිත්‍රපටය',
			'kindVideoMKV'    : 'Matroska චිත්‍රපටය',
			'kindVideoOGG'    : 'Ogg චිත්‍රපටය'
		}
	};
}));