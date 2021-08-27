/**
 * ئ‍ۇيغۇرچە translation
 * @author تەرجىمە قىلغۇچى:  ئۆتكۈر بىز شىركىتى info@otkur.biz
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
	elFinder.prototype.i18.ug_CN = {
		translator : 'تەرجىمە قىلغۇچى:  ئۆتكۈر بىز شىركىتى info@otkur.biz',
		language   : 'ئ‍ۇيغۇرچە',
		direction  : 'rtl',
		dateFormat : 'Y-m-d H:i', // will show like: 2020-09-02 16:40
		fancyDateFormat : '$1 H:i', // will show like: بۈگۈن 16:40
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200902-164004
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'خاتالىق',
			'errUnknown'           : 'كۈتۈلمىگەن خاتالىقكەن.',
			'errUnknownCmd'        : 'كۈتۈلمىگەن بۇيرۇقكەن.',
			'errJqui'              : 'jQuery UI تەڭشىكى توغرا بولمىغان. چوقۇم Selectable، draggable، droppabl قاتارلىق بۆلەكلەر بولۇشى كېرەك.',
			'errNode'              : 'elFinder DOM ئېلىمىنتلىرىنى قۇرالىشى كېرەك.',
			'errURL'               : 'elFinder تەڭشىكى توغرا بولمىغان! URL تەڭشىكى يېزىلمىغان.',
			'errAccess'            : 'زىيارەت قىلىش چەكلەنگەن.',
			'errConnect'           : 'ئارقا سۇپىغا ئۇلاش مەغلۇپ بولدى..',
			'errAbort'             : 'ئارقا سۇپىغا توختىتىلدى.',
			'errTimeout'           : 'ئارقا سۇپىغا بەلگىلەنگەن ۋاقىتتا ئۇلىيالمىدى.',
			'errNotFound'          : 'ئارقا سۇپا تېپىلمىدى.',
			'errResponse'          : 'ئارقا سۇپىدىن توغرا بولمىغان ئىنكاس قايتتى.',
			'errConf'              : 'ئارقا سۇپا تەڭشىكى توغرا ئەمەس.',
			'errJSON'              : 'PHP JSON بۆلىكى قاچىلانمىغان.',
			'errNoVolumes'         : 'ئوقۇشقا بولىدىغان ھۈججەت خالتىسى يوق.',
			'errCmdParams'         : 'پارامېتىر خاتا، بۇيرۇق: "$1".',
			'errDataNotJSON'       : 'ئارقا سۇپا قايتۇرغان سانلىق مەلۇمات توغرا بولغان JSON ئەمەسكەن.',
			'errDataEmpty'         : 'ئارقا سۇپا قايتۇرغان سانلىق مەلۇمات قۇرۇقكەن.',
			'errCmdReq'            : 'ئارقا سۇپىدىكى بۇيرۇقنىڭ ئ‍سىمى تەمىنلىنىشى كېرەك.',
			'errOpen'              : '"$1"نى ئاچالمىدى.',
			'errNotFolder'         : 'ئوبىكىت مۇندەرىجە ئەمەسكەن.',
			'errNotFile'           : 'ئوبىكىت ھۈججەت ئەمەسكەن.',
			'errRead'              : '"$1"نى ئوقۇيالمىدى.',
			'errWrite'             : '"$1"نى يازالمىدى.',
			'errPerm'              : 'ھوقۇق يوق.',
			'errLocked'            : '"$1" تاقالغان,ئۆزگەرتەلمەيسىز.',
			'errExists'            : '"$1" ناملىق ھۈججەت باركەن.',
			'errInvName'           : 'توغرا بولمىغان ھۈججەت قىسقۇچ ئىسمى.',
			'errInvDirname'        : 'ھۆججەت قىسقۇچنىڭ ئىسمى ئىناۋەتسىز.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'ھۈججەت قىسقۇچنى تاپالمىدى.',
			'errFileNotFound'      : 'ھۈججەتنى تاپالمىدى.',
			'errTrgFolderNotFound' : '"$1" ناملىق ھۈججەت قىسقۇچنى تاپالمىدى.',
			'errPopup'             : 'سەكرەپ چىققان يېڭى بەتنى تور كۆرگۈچ كۆرسەتمىدى، ئۈستىدىكى ئەسكەرتىشتىن تور كۆرگۈچنى كۆرسىتىشكە تەڭشەڭ.',
			'errMkdir'             : '"$1" ناملىق ھۈججەت قىسقۇچنى قۇرالمىدى.',
			'errMkfile'            : '"$1" ناملىق ھۈججەتنى قۇرالمىدى.',
			'errRename'            : '"$1" ناملىق ھۈججەتنىڭ ئىسمىنى يېڭىلاش مەغلۇپ بولدى.',
			'errCopyFrom'          : ' "$1" ناملىق ئورۇندىن ھۈججەت كۆچۈرۈش چەكلەنگەن.',
			'errCopyTo'            : '"$1" ناملىق ئورۇنغا ھۈججەت كۆچۈرۈش چەكلەنگەن.',
			'errMkOutLink'         : 'ئاۋاز يىلتىزىنىڭ سىرتىغا ئۇلىنىش قۇرالمىدى.', // from v2.1 added 03.10.2015
			'errUpload'            : 'يۈكلەشتە خاتالىق كۆرۈلدى.',  // old name - errUploadCommon
			'errUploadFile'        : '"$1" ناملىق ھۈججەتنى يۈكلەشتە خاتالىق كۆرۈلدى.', // old name - errUpload
			'errUploadNoFiles'     : 'يۈكلىمەكچى بولغان ھۈججەت تېپىلمىدى.',
			'errUploadTotalSize'   : 'سانلىق مەلۇمات چوڭلىقى چەكلىمىدىن ئېشىپ كەتكەن..', // old name - errMaxSize
			'errUploadFileSize'    : 'ھۈججەت چوڭلىقى چەكلىمىدىن ئېشىپ كەتكەن..', //  old name - errFileMaxSize
			'errUploadMime'        : 'چەكلەنگەن ھۈججەت شەكلى.',
			'errUploadTransfer'    : '"$1" ناملىق ھۈججەتنى يوللاشتا خاتالىق كۆرۈلدى.',
			'errUploadTemp'        : 'يوللاش ئۈچۈن ۋاقىتلىق ھۆججەت ھاسىل قىلالمىدى.', // from v2.1 added 26.09.2015
			'errNotReplace'        : '"$1" ناملىق ھۈججەت باركەن، ئالماشتۇرۇشقا بولمايدۇ.', // new
			'errReplace'           : '"$1" ناملىق ھۈججەتنى ئالماشتۇرۇش مەغلۇپ بولدى.',
			'errSave'              : '"$1" ناملىق ھۈججەتنى ساقلاش مەغلۇپ بولدى.',
			'errCopy'              : '"$1" ناملىق ھۈججەتنى كۆچۈرۈش مەغلۇپ بولدى.',
			'errMove'              : '"$1" ناملىق ھۈججەتنى يۆتكەش مەغلۇپ بولدى.',
			'errCopyInItself'      : '"$1" ناملىق ھۈججەتنى ئەسلى ئورنىغا يۆتكەش مەغلۇپ بولدى.',
			'errRm'                : '"$1" ناملىق ھۈججەتنى ئۆچۈرۈش مەغلۇپ بولدى.',
			'errTrash'             : 'ئەخلەت ساندۇقىغا كىرەلمىدى.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'ئەسلى ھۈججەتنى ئۆچۈرۈش مەغلۇپ بولدى.',
			'errExtract'           : ' "$1" ناملىق مەلۇماتتىن ھۈججەت ئايرىش مەغلۇپ بولدى..',
			'errArchive'           : 'پىرىسلانغان ھۈججەت ھاسىللاش مەغلۇپ بولدى.',
			'errArcType'           : 'بۇ خىل پىرىسلانغان ھۈججەت شەكلىنى سىستېما بىر تەرەپ قىلالمىدى.',
			'errNoArchive'         : 'ھۈججەت پىرىسلانغان ھۈججەت ئەمەس، ياكى توغرا پىرىسلانمىغان.',
			'errCmdNoSupport'      : 'بۇ خىل بۇيرۇقنى بىر تەرەپ قىلالمىدى.',
			'errReplByChild'       : '“$1” ناملىق ھۈججەت قىسقۇچنى ئالماشۇتۇرۇشقا بولمايدۇ.',
			'errArcSymlinks'       : 'بىخەتەرلىك ئۈچۈن بۇ مەشغۇلات ئەمەلدىن قالدۇرۇلدى..', // edited 24.06.2012
			'errArcMaxSize'        : 'پىرىسلانغان ھۈججەتنىڭ چوڭلىقى چەكلىمىدىن ئېشىپ كەنكەن.',
			'errResize'            : ' "$1" چوڭلۇقنى تەڭشەشكە بولمىدى.',
			'errResizeDegree'      : 'توغرا بولمىغان پىقىرىتىش گىرادۇسى',  // added 7.3.2013
			'errResizeRotate'      : 'رەسىمنى پىقىرىتىشقا بولمىدى.',  // added 7.3.2013
			'errResizeSize'        : 'توغرا بولمىغان رەسىم چوڭلىقى.',  // added 7.3.2013
			'errResizeNoChange'    : 'رەسىم چوڭلىقى ئۆزگەرمىگەن.',  // added 7.3.2013
			'errUsupportType'      : 'قوللىمايدىغان ھۈججەت شەكلى.',
			'errNotUTF8Content'    : '"$1" ناملىق ھۈججەتنىڭ كودى  UTF-8ئەمەسكەن،  تەھرىرلىگىلى بولمايدۇ.',  // added 9.11.2011
			'errNetMount'          : ' "$1" نى يۈكلەشتە خاتلىق يۈز بەردى..', // added 17.04.2012
			'errNetMountNoDriver'  : 'بۇ خىل پروتوكول قوللانمىدى..',     // added 17.04.2012
			'errNetMountFailed'    : 'يۈكلەش مەغلۇپ بولدى.',         // added 17.04.2012
			'errNetMountHostReq'   : 'مۇلازىمىتىرنى كۆرسىتىپ بېرىڭ.', // added 18.04.2012
			'errSessionExpires'    : 'سىزنىڭ ھەرىكەتسىزلىكىڭىز سەۋەبىدىن ۋاقتىڭىز توشتى.',
			'errCreatingTempDir'   : 'ۋاقىتلىق مۇندەرىجە قۇرالمىدى: "$ 1"',
			'errFtpDownloadFile'   : 'FTP دىن ھۆججەت چۈشۈرگىلى بولمىدى: "$ 1"',
			'errFtpUploadFile'     : 'ھۆججەتنى FTP غا يۈكلىيەلمىدى: "$ 1"',
			'errFtpMkdir'          : 'FTP دا يىراقتىن مۇندەرىجە قۇرالمىدى: "$ 1"',
			'errArchiveExec'       : 'ھۆججەتلەرنى ئارخىپلاشتۇرغاندا خاتالىق: "$ 1"',
			'errExtractExec'       : 'ھۆججەتلەرنى چىقىرىش جەريانىدا خاتالىق: "$ 1"',
			'errNetUnMount'        : 'ئۆچۈرگىلى بولمايدۇ.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'UTF-8 غا ئايلاندۇرغىلى بولمايدۇ', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'ئەگەر بۇ ھۆججەت قىسقۇچنى يۈكلىمەكچى بولسىڭىز ، زامانىۋى توركۆرگۈنى سىناپ بېقىڭ.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : '«$ 1» نى ئىزدەۋاتقاندا ۋاقتى ئۆتتى. ئىزدەش نەتىجىسى قىسمەن.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'قايتا ھوقۇق بېرىش تەلەپ قىلىنىدۇ.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'تاللىغىلى بولىدىغان تۈرلەرنىڭ ئەڭ كۆپ سانى 1 دوللار.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'ئەخلەت ساندۇقىدىن ئەسلىگە كەلتۈرەلمىدى. ئەسلىگە كەلتۈرۈش مەنزىلىنى ئېنىقلىيالمىدى.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'تەھرىرلىگۈچ بۇ ھۆججەت تىپىغا تېپىلمىدى.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'مۇلازىمېتىر تەرەپتە خاتالىق كۆرۈلدى.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : '«$ 1» ھۆججەت قىسقۇچىنى بوشاتقىلى بولمايدۇ.', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'يەنە 1 دوللار خاتالىق بار.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'پىرىسلاش',
			'cmdback'      : 'قايتىش',
			'cmdcopy'      : 'كۆچۈرۈش',
			'cmdcut'       : 'كېسىش',
			'cmddownload'  : 'چۈشۈرۈش',
			'cmdduplicate' : 'نۇسخىلاش',
			'cmdedit'      : 'تەھرىرلەش',
			'cmdextract'   : 'پىرىستىن ھۈججەت چىقىرىش',
			'cmdforward'   : 'ئ‍الدىغا مېڭىش',
			'cmdgetfile'   : 'تاللاش',
			'cmdhelp'      : 'ئەپ ھەققىدە',
			'cmdhome'      : 'باش بەت',
			'cmdinfo'      : 'ئۇچۇرلىرى',
			'cmdmkdir'     : 'يېڭى ھۈججەت قىسقۇچ',
			'cmdmkdirin'   : 'يېڭى ھۆججەت قىسقۇچقا', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'يېڭى ھۈججەت',
			'cmdopen'      : 'ئېچىش',
			'cmdpaste'     : 'چاپلاش',
			'cmdquicklook' : 'كۆرۈش',
			'cmdreload'    : 'يېڭىلاش',
			'cmdrename'    : 'نام يېڭىلاش',
			'cmdrm'        : 'ئۆچۈرۈش',
			'cmdtrash'     : 'ئەخلەت ساندۇقىغا', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'ئەسلىگە كەلتۈرۈش', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'ھۈججەت ئىزدەش',
			'cmdup'        : 'ئالدىنقى مۇندەرىجىگە بېرىش',
			'cmdupload'    : 'يۈكلەش',
			'cmdview'      : 'كۆرۈش',
			'cmdresize'    : 'چوڭلىقىنى تەڭشەش',
			'cmdsort'      : 'تەرتىپ',
			'cmdnetmount'  : 'توردىن قوشۇش', // added 18.04.2012
			'cmdnetunmount': 'Unmount', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'جايلارغا', // added 28.12.2014
			'cmdchmod'     : 'ھالەتنى ئۆزگەرتىش', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'ھۆججەت قىسقۇچنى ئېچىڭ', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'ستون كەڭلىكىنى ئەسلىگە كەلتۈرۈڭ', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'تولۇق ئېكران', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'يۆتكەڭ', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'قىسقۇچنى بوش قويۇڭ', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'ئەمەلدىن قالدۇرۇش', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'Redo', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'مايىللىق', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'ھەممىنى تاللاڭ', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'ھېچقايسىسىنى تاللىماڭ', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'تەتۈر تاللاش', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'يېڭى كۆزنەكتە ئېچىڭ', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'يوشۇرۇش (مايىللىق)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'تاقاش',
			'btnSave'   : 'ساقلاش',
			'btnRm'     : 'ئۆچۈرۈش',
			'btnApply'  : 'ئىشلىتىش',
			'btnCancel' : 'بېكارلاش',
			'btnNo'     : 'ياق',
			'btnYes'    : 'ھەئە',
			'btnMount'  : 'يۈكلەش',  // added 18.04.2012
			'btnApprove': 'Goto $ 1 & تەستىق', // from v2.1 added 26.04.2012
			'btnUnmount': 'Unmount', // from v2.1 added 30.04.2012
			'btnConv'   : 'ئايلاندۇرۇش', // from v2.1 added 08.04.2014
			'btnCwd'    : 'بۇ يەردە',      // from v2.1 added 22.5.2015
			'btnVolume' : 'ھەجىم',    // from v2.1 added 22.5.2015
			'btnAll'    : 'ھەممىسى',       // from v2.1 added 22.5.2015
			'btnMime'   : 'MIME تىپى', // from v2.1 added 22.5.2015
			'btnFileName':'ھۆججەت ئىسمى',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'ساقلاش ۋە تاقاش', // from v2.1 added 12.6.2015
			'btnBackup' : 'زاپاسلاش', // fromv2.1 added 28.11.2015
			'btnRename'    : 'ئىسىمنى ئۆزگەرتىش',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'ئىسمى (ھەممىسى)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'ئالدىنقى ($ 1 / $ 2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'كېيىنكى ($ 1 / $ 2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Save As', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'قىسقۇچنى ئېچىش',
			'ntffile'     : 'ھۈججەتنى ئېچىش',
			'ntfreload'   : 'يېڭىلاش',
			'ntfmkdir'    : 'قىسقۇچ قۇرۇش',
			'ntfmkfile'   : 'ھۈججەت قۇرۇش',
			'ntfrm'       : 'ئۆچۈرۈش',
			'ntfcopy'     : 'كۆچۈرۈش',
			'ntfmove'     : 'يۆتكەش',
			'ntfprepare'  : 'كۆچۈرۈش تەييارلىقى',
			'ntfrename'   : 'نام يېڭىلاش',
			'ntfupload'   : 'يۈكلەش',
			'ntfdownload' : 'چۈشۈرۈش',
			'ntfsave'     : 'ساقلاش',
			'ntfarchive'  : 'پىرىسلاش',
			'ntfextract'  : 'پىرىستىن يېشىش',
			'ntfsearch'   : 'ئىزدەش',
			'ntfresize'   : 'چوڭلىقى ئۆزگەرتىلىۋاتىدۇ',
			'ntfsmth'     : 'ئالدىراش >_<',
			'ntfloadimg'  : 'رەسىم ئېچىلىۋاتىدۇ',
			'ntfnetmount' : 'تور ھۈججىتى يۈكلىنىۋاتىدۇ', // added 18.04.2012
			'ntfnetunmount': 'تور مىقدارىنى ئۆچۈرۈۋېتىش', // from v2.1 added 30.04.2012
			'ntfdim'      : 'رەسىم ئۆلچىمىگە ئېرىشىش', // added 20.05.2013
			'ntfreaddir'  : 'قىسقۇچ ئۇچۇرلىرىنى ئوقۇش', // from v2.1 added 01.07.2013
			'ntfurl'      : 'ئۇلىنىش ئادرېسىغا ئېرىشىش', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'ھۆججەت ھالىتىنى ئۆزگەرتىش', // from v2.1 added 20.6.2015
			'ntfpreupload': 'يۈكلەش ھۆججەت نامىنى دەلىللەش', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'چۈشۈرۈش ئۈچۈن ھۆججەت قۇرۇش', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'يول ئۇچۇرىغا ئېرىشىش', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'يۈكلەنگەن ھۆججەتنى بىر تەرەپ قىلىش', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'ئەخلەت ساندۇقىغا تاشلاش', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'ئەخلەت ساندۇقىدىن ئەسلىگە كەلتۈرۈش', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'نىشان ھۆججەت قىسقۇچىنى تەكشۈرۈش', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'ئالدىنقى مەشغۇلاتنى ئەمەلدىن قالدۇرۇش', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'ئىلگىرىكى ئەمەلدىن قالدۇرۇلدى', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'مەزمۇننى تەكشۈرۈش', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'ئەخلەت ساندۇقى', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'ئېنىق ئەمەس',
			'Today'       : 'بۈگۈن',
			'Yesterday'   : 'تۆنۈگۈن',
			'msJan'       : '1-ئاي',
			'msFeb'       : '2-ئاي',
			'msMar'       : '3-ئاي',
			'msApr'       : '4-ئاي',
			'msMay'       : '5-ئاي',
			'msJun'       : '6-ئاي',
			'msJul'       : '7-ئاي',
			'msAug'       : '8-ئاي',
			'msSep'       : '9-ئ‍اي',
			'msOct'       : '10-ئاي',
			'msNov'       : '11-ئاي',
			'msDec'       : '12-ئاي',
			'January'     : '1-ئاي',
			'February'    : '2-ئاي',
			'March'       : '3-ئاي',
			'April'       : '4-ئاي',
			'May'         : '5-ئاي',
			'June'        : '6-ئاي',
			'July'        : '7-ئاي',
			'August'      : '8-ئاي',
			'September'   : '9-ئاي',
			'October'     : '10-ئاي',
			'November'    : '11-ئاي',
			'December'    : '12-ئاي',
			'Sunday'      : 'يەكشەنبە',
			'Monday'      : 'دۈشەنبە',
			'Tuesday'     : 'سەيشەنبە',
			'Wednesday'   : 'چارشەنبە',
			'Thursday'    : 'پەيشەنبە',
			'Friday'      : 'جۈمە',
			'Saturday'    : 'شەنبە',
			'Sun'         : 'يە',
			'Mon'         : 'دۈ',
			'Tue'         : 'سە',
			'Wed'         : 'چا',
			'Thu'         : 'پە',
			'Fri'         : 'جۈ',
			'Sat'         : 'شە',

			/******************************** sort variants ********************************/
			'sortname'          : 'نامى ',
			'sortkind'          : 'شەكلى ',
			'sortsize'          : 'چوڭلىقى',
			'sortdate'          : 'ۋاقتى',
			'sortFoldersFirst'  : 'قىسقۇچلار باشتا',
			'sortperm'          : 'رۇخسەت بىلەن', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'by mode',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'ئىگىسى تەرىپىدىن',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'گۇرۇپپا بويىچە',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'NewFolder',   // added 10.11.2015
			'Archive'           : 'NewArchive',  // from v2.1 added 10.11.2015
			'untitled file'     : 'NewFile.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$ 1: ھۆججەت',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'مۇقىملاشتۇرۇڭ',
			'confirmRm'       : 'راستىنلا ئۆچۈرەمسىز?<br/>كەينىگە قايتۇرغىلى بولمايدۇ!',
			'confirmRepl'     : 'ھازىرقى ھۈججەت بىلەن كونىسىنى ئالماشتۇرامسىز?',
			'confirmRest'     : 'مەۋجۇت نەرسىنى ئەخلەت ساندۇقىغا ئالماشتۇرۇڭ؟', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'UTF-8 دا ئەمەس <br/> UTF-8 غا ئايلاندۇرامسىز؟ <br/> مەزمۇن ئۆزگەرتىلگەندىن كېيىن تېجەش ئارقىلىق UTF-8 غا ئايلىنىدۇ.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'بۇ ھۆججەتنىڭ ھەرپ-بەلگە كودلىرىنى بايقىغىلى بولمايدۇ. ئۇنى تەھرىرلەش ئۈچۈن ۋاقىتلىق UTF-8 غا ئايلاندۇرۇش كېرەك. <br/> بۇ ھۆججەتنىڭ ھەرپ كودلاشتۇرۇشنى تاللاڭ.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'ئۇ ئۆزگەرتىلدى. <br/> ئۆزگەرتىشلەرنى ساقلىمىسىڭىز خىزمەتتىن ئايرىلىدۇ.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'نەرسىلەرنى ئەخلەت ساندۇقىغا يۆتكىمەكچىمۇ؟', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'تۈرلەرنى «$ 1» غا يۆتكىمەكچىمۇ؟', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'ھەممىسىگە ئىشلىتىش',
			'name'            : 'نامى',
			'size'            : 'چوڭلىقى',
			'perms'           : 'ھوقۇق',
			'modify'          : 'ئۆزگەرگەن ۋاقتى',
			'kind'            : 'تۈرى',
			'read'            : 'ئوقۇش',
			'write'           : 'يېزىش',
			'noaccess'        : 'ھوقۇق يوق',
			'and'             : 'ھەم',
			'unknown'         : 'ئېنىق ئەمەس',
			'selectall'       : 'ھەممىنى تاللاش',
			'selectfiles'     : 'تاللاش',
			'selectffile'     : 'بىرىنچىسىنى تاللاش',
			'selectlfile'     : 'ئەڭ ئاخىرقىسىنى تاللاش',
			'viewlist'        : 'جەدۋەللىك كۆرىنىشى',
			'viewicons'       : 'رەسىملىك كۆرىنىشى',
			'viewSmall'       : 'كىچىك سىنبەلگىلەر', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'ئوتتۇرا سىنبەلگىلەر', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'چوڭ سىنبەلگىلەر', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'قوشۇمچە چوڭ سىنبەلگىلەر', // from v2.1.39 added 22.5.2018
			'places'          : 'ئورنى',
			'calc'            : 'ھېسابلاش',
			'path'            : 'ئورنى',
			'aliasfor'        : 'باشقا نامى',
			'locked'          : 'تاقالغان',
			'dim'             : 'چوڭلىقى',
			'files'           : 'ھۈججەت',
			'folders'         : 'قىسقۇچ',
			'items'           : 'تۈرلەر',
			'yes'             : 'ھەئە',
			'no'              : 'ياق',
			'link'            : 'ئۇلىنىش',
			'searcresult'     : 'ئىزدەش نەتىجىسى',
			'selected'        : 'تاللانغان تۈرلەر',
			'about'           : 'چۈشەنچە',
			'shortcuts'       : 'تېز كونۇپكىلار',
			'help'            : 'ياردەم',
			'webfm'           : 'تور ھۈججەتلىرىنى باشقۇرۇش',
			'ver'             : 'نەشرى',
			'protocolver'     : 'پروتوكول نەشرى',
			'homepage'        : 'تۈر باش بېتى',
			'docs'            : 'ھۈججەت',
			'github'          : 'Fork us on Github',
			'twitter'         : 'Follow us on twitter',
			'facebook'        : 'Join us on facebook',
			'team'            : 'گۇرۇپپا',
			'chiefdev'        : 'باش پىروگراممىر',
			'developer'       : 'پىروگراممىر',
			'contributor'     : 'تۆھپىكار',
			'maintainer'      : 'ئاسرىغۇچى',
			'translator'      : 'تەرجىمان',
			'icons'           : 'سىنبەلگە',
			'dontforget'      : 'تەرىڭىزنى سۈرتىدىغان قولياغلىقىڭىزنى ئۇنۇتماڭ جۇمۇ',
			'shortcutsof'     : 'تېز كونۇپكىلار چەكلەنگەن',
			'dropFiles'       : 'ھۈججەتنى موشۇ يەرگە تاشلاڭ',
			'or'              : 'ياكى',
			'selectForUpload' : 'يۈكلىمەكچى بولغان ھۈججەتنى تاللاڭ',
			'moveFiles'       : 'يۆتكەش',
			'copyFiles'       : 'كۆچۈرۈش',
			'restoreFiles'    : 'تۈرلەرنى ئەسلىگە كەلتۈرۈش', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'ھۈججەتلەرنى ئۆچۈرۈش',
			'aspectRatio'     : 'نىسبىتىنى ساقلاش',
			'scale'           : 'نىسبىتى',
			'width'           : 'ئۇزۇنلىقى',
			'height'          : 'ئىگىزلىكى',
			'resize'          : 'چوڭلىقىنى تەڭشەش',
			'crop'            : 'كېسىش',
			'rotate'          : 'پىقىرىتىش',
			'rotate-cw'       : 'سائەت ئىستىرىلكىسى بويىچە 90 گىرادۇس پىقىرىتىش',
			'rotate-ccw'      : 'سائەت ئىستىرىلكىسىنى تەتۈر يۆنىلىشى بويىچە 90گىرادۇس پىقىرىتىش',
			'degree'          : 'گىرادۇس',
			'netMountDialogTitle' : 'تور ئاۋازى', // added 18.04.2012
			'protocol'            : 'پىروتوكڭل', // added 18.04.2012
			'host'                : 'مۇلازىمىتىر', // added 18.04.2012
			'port'                : 'پورت', // added 18.04.2012
			'user'                : 'ئەزا', // added 18.04.2012
			'pass'                : 'ئىم', // added 18.04.2012
			'confirmUnmount'      : 'سىز $ 1 نى ھېسابلىمايسىز؟',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'توركۆرگۈدىن ھۆججەتلەرنى تاشلاش ياكى چاپلاش', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'ھۆججەتلەرنى ، URL ياكى رەسىملەرنى چاپلاش (چاپلاش تاختىسى) بۇ يەرگە تاشلاڭ', // from v2.1 added 07.04.2014
			'encoding'        : 'كودلاش', // from v2.1 added 19.12.2014
			'locale'          : 'Locale',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'نىشان: $ 1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'كىرگۈزۈش MIME تىپى ئارقىلىق ئىزدەش', // from v2.1 added 22.5.2015
			'owner'           : 'ئىگىسى', // from v2.1 added 20.6.2015
			'group'           : 'گۇرۇپپا', // from v2.1 added 20.6.2015
			'other'           : 'باشقىلىرى', // from v2.1 added 20.6.2015
			'execute'         : 'ئىجرا قىلىڭ', // from v2.1 added 20.6.2015
			'perm'            : 'ئىجازەت', // from v2.1 added 20.6.2015
			'mode'            : 'Mode', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'ھۆججەت قىسقۇچ قۇرۇق', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'ھۆججەت قىسقۇچ قۇرۇق \\ تۈر قوشۇش ئۈچۈن تاشلاش', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'ھۆججەت قىسقۇچ قۇرۇق \\ تۈر قوشۇش ئۈچۈن ئۇزۇن چېكىش', // from v2.1.6 added 30.12.2015
			'quality'         : 'سۈپەت', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'ئاپتوماتىك ماسقەدەملەش',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'يۆتكەڭ',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'URL ئۇلىنىشىغا ئېرىشىڭ', // from v2.1.7 added 9.2.2016
			'share'           : 'ھەمبەھر',
			'selectedItems'   : 'تاللانغان تۈرلەر ($ 1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'ھۆججەت قىسقۇچ كىملىكى', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'تورسىز زىيارەتكە يول قويۇڭ', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'قايتا دەلىللەش', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'ھازىر يۈكلەۋاتىدۇ ...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'كۆپ ھۆججەتلەرنى ئېچىڭ', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'سىز $ 1 ھۆججىتىنى ئاچماقچى بولۇۋاتىسىز. توركۆرگۈدە ئاچماقچىمۇ؟', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'ئىزدەش نەتىجىسى ئىزدەش نىشانىدا قۇرۇق.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'ئۇ ھۆججەتنى تەھرىرلەۋاتىدۇ.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'سىز $ 1 تۈرنى تاللىدىڭىز.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'چاپلاش تاختىسىدا 1 دوللار بار.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'كۆپەيتىلگەن ئىزدەش پەقەت ھازىرقى كۆز قاراشتىن كەلگەن.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'قايتا ئورنىتىڭ', // from v2.1.15 added 3.8.2016
			'complete'        : '$ 1 تامام', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'مەزمۇن تىزىملىكى', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'بەت ئايلانمىسى', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'توم يىلتىزى', // from v2.1.16 added 16.9.2016
			'reset'           : 'ئەسلىگە قايتۇرۇش', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'تەگلىك رەڭگى', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'رەڭ تاللىغۇچ', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px Grid', // from v2.1.16 added 4.10.2016
			'enabled'         : 'قوزغىتىلدى', // from v2.1.16 added 4.10.2016
			'disabled'        : 'چەكلەنگەن', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'ئىزدەش نەتىجىسى نۆۋەتتىكى كۆرۈنۈشتە قۇرۇق. \\ APress [Enter] ئىزدەش نىشانىنى كېڭەيتىش.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'نۆۋەتتىكى كۆرۈنۈشتە بىرىنچى ھەرىپ ئىزدەش نەتىجىسى قۇرۇق.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'تېكىست بەلگىسى', // from v2.1.17 added 13.10.2016
			'minsLeft'        : '1 مىنۇت قالدى', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'تاللانغان كودلاش ئارقىلىق قايتا ئېچىڭ', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'تاللانغان كودلاش ئارقىلىق ساقلاڭ', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'ھۆججەت قىسقۇچنى تاللاڭ', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'بىرىنچى خەت ئىزدەش', // from v2.1.23 added 24.3.2017
			'presets'         : 'ئالدىن بەلگىلەيدۇ', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'ئۇ بەك كۆپ نەرسە بولغاچقا ئەخلەت ساندۇقىغا كىرەلمەيدۇ.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : '«$ 1» ھۆججەت قىسقۇچىنى بوش قويۇڭ.', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : '«$ 1» ھۆججەت قىسقۇچىدا ھېچقانداق نەرسە يوق.', // from v2.1.25 added 22.6.2017
			'preference'      : 'مايىللىق', // from v2.1.26 added 28.6.2017
			'language'        : 'تىل', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'بۇ توركۆرگۈدە ساقلانغان تەڭشەكلەرنى قوزغىتىڭ', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'قورالبالدىقى تەڭشىكى', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... 1 دوللار قالدى.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $ 1 قۇر قالدى.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Sum', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'ھۆججەت چوڭلۇقى', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'چاشقىنەك ئارقىلىق دىئالوگ ئېلېمېنتىغا دىققەت قىلىڭ',  // from v2.1.30 added 2.11.2017
			'select'          : 'تاللاڭ', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'ھۆججەت تاللىغاندا ھەرىكەت', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'ئالدىنقى قېتىم ئىشلىتىلگەن تەھرىرلىگۈچ بىلەن ئېچىڭ', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'تەتۈر تاللاش', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : '$ 1 غا ئوخشاش $ 1 تاللانغان تۈرنىڭ ئىسمىنى ئۆزگەرتمەكچىمۇ؟ <br/> بۇنى ئەمەلدىن قالدۇرغىلى بولمايدۇ؟', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'گۇرۇپپا نامىنى ئۆزگەرتىش', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ سان', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'ئالدى قوشۇلغۇچى قوشۇڭ', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'قوشۇمچى قوشۇڭ', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'كېڭەيتىلمىنى ئۆزگەرتىش', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'ستون تەڭشىكى (تىزىملىك كۆرۈنۈشى)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'بارلىق ئۆزگەرتىشلەر ئارخىپقا دەرھال ئەكىس ئەتتۈرىدۇ.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'بۇ ئاۋازنى تەڭشىمىگۈچە ھەر قانداق ئۆزگىرىش ئەكس ئەتمەيدۇ.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'بۇ ھەجىمگە ئورنىتىلغان تۆۋەندىكى ئاۋاز (لار) مۇ ساناقسىز. ئۇنى ئۆچۈرەمسىز؟', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'تاللاش ئۇچۇرى', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'ھۆججەتنى hash كۆرسىتىش ئۈچۈن ئالگورىزىم', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'ئۇچۇر تۈرلىرى (تاللاش ئۇچۇر تاختىسى)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'چېكىنىش ئۈچۈن يەنە بىر قېتىم بېسىڭ.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'قورالبالدىقى', // from v2.1.38 added 4.4.2018
			'workspace'       : 'خىزمەت بوشلۇقى', // from v2.1.38 added 4.4.2018
			'dialog'          : 'دىئالوگ', // from v2.1.38 added 4.4.2018
			'all'             : 'ھەممىسى', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'سىنبەلگە چوڭلۇقى (سىنبەلگە كۆرۈنۈشى)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'چوڭايتىلغان تەھرىرلىگۈچ كۆزنىكىنى ئېچىڭ', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'API ئارقىلىق ئۆزگەرتىش ھازىرچە بولمىغاچقا ، توربېكەتكە ئايلاندۇرۇڭ.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'ئۆزگەرتىلگەندىن كېيىن ، چوقۇم URL ئادرېسى ياكى چۈشۈرۈلگەن ھۆججەت بىلەن يۈكلەنگەن ھۆججەتنى ساقلاش ئۈچۈن يۈكلىشىڭىز كېرەك.', //from v2.1.40 added 8.7.2018
			'convertOn'       : '$ 1 تور بېتىگە ئايلاندۇرۇڭ', // from v2.1.40 added 10.7.2018
			'integrations'    : 'بىرىكتۈرۈش', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'بۇ elFinder نىڭ تۆۋەندىكى تاشقى مۇلازىمەتلىرى بىرلەشتۈرۈلگەن. ئىشلىتىش شەرتلىرى ، مەخپىيەتلىك تۈزۈمى قاتارلىقلارنى ئىشلىتىشتىن بۇرۇن تەكشۈرۈپ بېقىڭ.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'يوشۇرۇن تۈرلەرنى كۆرسەت', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'كود تەھرىرلىگۈچى',
			'hideHidden'      : 'يوشۇرۇن نەرسىلەرنى يوشۇرۇش', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'يوشۇرۇن تۈرلەرنى كۆرسىتىش / يوشۇرۇش', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : '«يېڭى ھۆججەت» ئارقىلىق قوزغىتىدىغان ھۆججەت تىپلىرى', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'تېكىست ھۆججىتىنىڭ تىپى', // from v2.1.41 added 7.8.2018
			'add'             : 'قوش', // from v2.1.41 added 7.8.2018
			'theme'           : 'باشتېما', // from v2.1.43 added 19.10.2018
			'default'         : 'سۈكۈتتىكى', // from v2.1.43 added 19.10.2018
			'description'     : 'چۈشەندۈرۈش', // from v2.1.43 added 19.10.2018
			'website'         : 'تور بېكەت', // from v2.1.43 added 19.10.2018
			'author'          : 'ئاپتور', // from v2.1.43 added 19.10.2018
			'email'           : 'ئېلخەت', // from v2.1.43 added 19.10.2018
			'license'         : 'ئىجازەتنامە', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'بۇ تۈرنى ساقلىغىلى بولمايدۇ. كومپيۇتېرىڭىزغا ئېكسپورت قىلىشىڭىز كېرەك.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'ئۇنى تاللاش ئۈچۈن ھۆججەتنى قوش چېكىڭ.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'پۈتۈن ئېكران ھالىتىنى ئىشلىتىڭ', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'ئېنىق ئەمەس',
			'kindRoot'        : 'توم يىلتىزى', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'ھۈججەت قىسقۇچ',
			'kindSelects'     : 'تاللاش', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'باشقا نامى',
			'kindAliasBroken' : 'باشقا نامى خاتا',
			// applications
			'kindApp'         : 'كود ھۈججىتى',
			'kindPostscript'  : 'Postscript ھۈججىتى',
			'kindMsOffice'    : 'Microsoft Office ھۈججىتى',
			'kindMsWord'      : 'Microsoft Word ھۈججىتى',
			'kindMsExcel'     : 'Microsoft Excel ھۈججىتى',
			'kindMsPP'        : 'Microsoft Powerpoint ھۈججىتى',
			'kindOO'          : 'Open Office ھۈججىتى',
			'kindAppFlash'    : 'Flash ھۈججىتى',
			'kindPDF'         : 'ئېلىپ يۈرۈشكە ئەپلىك ھۆججەت فورماتى (PDF)',
			'kindTorrent'     : 'Bittorrent ھۈججىتى',
			'kind7z'          : '7z ھۈججىتى',
			'kindTAR'         : 'TAR ھۈججىتى',
			'kindGZIP'        : 'GZIP ھۈججىتى',
			'kindBZIP'        : 'BZIP ھۈججىتى',
			'kindXZ'          : 'XZ ھۈججىتى',
			'kindZIP'         : 'ZIP ھۈججىتى',
			'kindRAR'         : 'RAR ھۈججىتى',
			'kindJAR'         : 'Java JAR ھۈججىتى',
			'kindTTF'         : 'True Type فونت',
			'kindOTF'         : 'Open Type فونت',
			'kindRPM'         : 'RPM',
			// texts
			'kindText'        : 'تېكىست',
			'kindTextPlain'   : 'تېكىست',
			'kindPHP'         : 'PHP ھۈججىتى',
			'kindCSS'         : 'CSS ھۈججىتى',
			'kindHTML'        : 'HTML ھۈججىتى',
			'kindJS'          : 'Javascript ھۈججىتى',
			'kindRTF'         : 'RTF ھۈججىتى',
			'kindC'           : 'C ھۈججىتى',
			'kindCHeader'     : 'C باش ھۈججىتى',
			'kindCPP'         : 'C++ ھۈججىتى',
			'kindCPPHeader'   : 'C++ باش ھۈججىتى',
			'kindShell'       : 'Unix سىكىرىپت ھۈججىتى',
			'kindPython'      : 'Python ھۈججىتى',
			'kindJava'        : 'Java ھۈججىتى',
			'kindRuby'        : 'Ruby ھۈججىتى',
			'kindPerl'        : 'Perl ھۈججىتى',
			'kindSQL'         : 'SQL ھۈججىتى',
			'kindXML'         : 'XML ھۈججىتى',
			'kindAWK'         : 'AWK ھۈججىتى',
			'kindCSV'         : 'CSV ھۈججىتى',
			'kindDOCBOOK'     : 'Docbook XML ھۈججىتى',
			'kindMarkdown'    : 'بەلگە تېكىست', // added 20.7.2015
			// images
			'kindImage'       : 'رەسىم',
			'kindBMP'         : 'BMP رەسىم',
			'kindJPEG'        : 'JPEG رەسىم',
			'kindGIF'         : 'GIF رەسىم',
			'kindPNG'         : 'PNG رەسىم',
			'kindTIFF'        : 'TIFF رەسىم',
			'kindTGA'         : 'TGA رەسىم',
			'kindPSD'         : 'Adobe Photoshop رەسىم',
			'kindXBITMAP'     : 'X bitmap رەسىم',
			'kindPXM'         : 'Pixelmator رەسىم',
			// media
			'kindAudio'       : 'ئاۋاز',
			'kindAudioMPEG'   : 'MPEG ئاۋاز',
			'kindAudioMPEG4'  : 'MPEG-4 ئاۋاز',
			'kindAudioMIDI'   : 'MIDI ئاۋاز',
			'kindAudioOGG'    : 'Ogg Vorbis ئاۋاز',
			'kindAudioWAV'    : 'WAV ئاۋاز',
			'AudioPlaylist'   : 'MP3 قويۇش تىزىملىكى',
			'kindVideo'       : 'سىن',
			'kindVideoDV'     : 'DV سىن',
			'kindVideoMPEG'   : 'MPEG سىن',
			'kindVideoMPEG4'  : 'MPEG-4 سىن',
			'kindVideoAVI'    : 'AVI سىن',
			'kindVideoMOV'    : 'Quick Time سىن',
			'kindVideoWM'     : 'Windows Media سىن',
			'kindVideoFlash'  : 'Flash سىن',
			'kindVideoMKV'    : 'Matroska سىن',
			'kindVideoOGG'    : 'Ogg سىن'
		}
	};
}));