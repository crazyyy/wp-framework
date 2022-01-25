/**
 * العربية translation
 * @author Tawfek Daghistani <tawfekov@gmail.com>
 * @author Atef Ben Ali <atef.bettaib@gmail.com>
 * @version 2020-08-27
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
	elFinder.prototype.i18.ar = {
		translator : 'Tawfek Daghistani &lt;tawfekov@gmail.com&gt;, Atef Ben Ali &lt;atef.bettaib@gmail.com&gt;',
		language   : 'العربية',
		direction  : 'rtl',
		dateFormat : 'M d, Y h:i A', // will show like: آب 27, 2020 03:59 PM
		fancyDateFormat : '$1 h:i A', // will show like: اليوم 03:59 PM
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200827-155913
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'خطأ',
			'errUnknown'           : 'خطأ غير معروف .',
			'errUnknownCmd'        : 'أمر غير معروف .',
			'errJqui'              : 'إعدادات jQuery UI غير كاملة الرجاء التأكد من وجود كل من selectable, draggable and droppable',
			'errNode'              : '. موجود DOM إلى عنصر  elFinder تحتاج  ',
			'errURL'               : 'إعدادات خاطئة , عليك وضع الرابط ضمن الإعدادات',
			'errAccess'            : 'وصول مرفوض .',
			'errConnect'           : 'غير قادر على الاتصال بالخادم الخلفي  (backend)',
			'errAbort'             : 'تم فصل الإتصال',
			'errTimeout'           : 'مهلة الإتصال قد انتهت.',
			'errNotFound'          : 'الخادوم الخلفي غير موجود .',
			'errResponse'          : 'رد غير مقبول من الخادوم الخلفي',
			'errConf'              : 'خطأ في الإعدادات الخاصة بالخادوم الخلفي ',
			'errJSON'              : 'الميزة PHP JSON module غير موجودة ',
			'errNoVolumes'         : 'لا يمكن القراءة من الوسائط الموجودة ',
			'errCmdParams'         : 'البيانات المرسلة للأمر غير مقبولة "$1".',
			'errDataNotJSON'       : 'المعلومات المرسلة ليست من نوع JSON ',
			'errDataEmpty'         : 'لا يوجد معلومات مرسلة',
			'errCmdReq'            : 'الخادوم الخلفي يطلب وجود اسم الأمر ',
			'errOpen'              : 'غير قادر على فتح  "$1".',
			'errNotFolder'         : 'العنصر المختار ليس مجلد',
			'errNotFile'           : 'العنصر المختار ليس ملف',
			'errRead'              : 'غير قادر على القراءة "$1".',
			'errWrite'             : 'غير قادر على الكتابة "$1".',
			'errPerm'              : 'وصول مرفوض ',
			'errLocked'            : ' محمي ولا يمكن التعديل أو النقل أو إعادة التسمية"$1"',
			'errExists'            : ' موجود مسبقاً "$1"',
			'errInvName'           : 'الاسم مرفوض',
			'errInvDirname'        : 'اسم مجلد غير صالح',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'المجلد غير موجود',
			'errFileNotFound'      : 'الملف غير موجود',
			'errTrgFolderNotFound' : 'الملف الهدف  "$1" غير موجود ',
			'errPopup'             : 'يمنع المتصفح من إنشاء نافذة منبثقة، الرجاء تعديل الخيارات الخاصة من إعدادات المتصفح',
			'errMkdir'             : ' غير قادر على إنشاء مجلد جديد "$1".',
			'errMkfile'            : ' غير قادر على إنشاء ملف جديد"$1".',
			'errRename'            : 'غير قادر على إعادة تسمية الـ  "$1".',
			'errCopyFrom'          : 'نسخ الملفات من الوسط المحدد "$1" غير مسموح.',
			'errCopyTo'            : 'نسخ الملفات إلى الوسط المحدد "$1" غير مسموح .',
			'errMkOutLink'         : 'لا يمكن إنشاء رابط خارج مساحة الملف الجذر.', // from v2.1 added 03.10.2015
			'errUpload'            : 'خطأ أثناء عملية الرفع.',  // old name - errUploadCommon
			'errUploadFile'        : 'غير قادر على رفع "$1".', // old name - errUpload
			'errUploadNoFiles'     : 'لم يتم رفع أي ملف .',
			'errUploadTotalSize'   : 'حجم البيانات أكبر من الحجم المسموح به.', // old name - errMaxSize
			'errUploadFileSize'    : 'حجم الملف أكبر من الحجم المسموح به.', //  old name - errFileMaxSize
			'errUploadMime'        : ' نوع ملف غير مسموح به.',
			'errUploadTransfer'    : '"$1" خطأ أثناء عملية النقل.',
			'errUploadTemp'        : 'لا يمكن إنشاء ملف وقتي للرفع.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'الكائن "$1" موجود في هذا المكان ولا يمكن استبداله بكائن من نوع آخر.', // new
			'errReplace'           : 'لا يمكن استبدال "$1".',
			'errSave'              : 'غير قادر على الحفظ في "$1".',
			'errCopy'              : 'غير قادر على النسخ إلى "$1".',
			'errMove'              : 'غير قادر على النقل إلى "$1".',
			'errCopyInItself'      : 'غير قادر على نسخ الملف "$1" ضمن الملف نفسه.',
			'errRm'                : 'غير قادر على الحذف "$1".',
			'errTrash'             : 'لا يمكن النقل إلى سلة المهملات', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'لا يمكن فسخ الملف(ـات) المصدري(ـة).',
			'errExtract'           : 'غير قادر على استخراج الملفات من "$1".',
			'errArchive'           : 'غير قادر على إنشاء ملف مضغوط.',
			'errArcType'           : 'نوع الملف المضغوط غير مدعومة.',
			'errNoArchive'         : 'هذا الملف ليس ملف مضغوط أو ذو صيغة غير مدعومة.',
			'errCmdNoSupport'      : 'الخادوم الخلفي لا يدعم هذا الأمر ',
			'errReplByChild'       : 'لا يمكن استبدال الملف "$1" بعنصر محتوِ فيه.',
			'errArcSymlinks'       : 'For security reason denied to unpack archives contains symlinks.', // edited 24.06.2012
			'errArcMaxSize'        : 'الملفات المضغوطة تجاوزت السعة المسموح بها.',
			'errResize'            : 'تعذر تغيير حجم "$1".',
			'errResizeDegree'      : 'درجة تدوير غير صالحة.',  // added 7.3.2013
			'errResizeRotate'      : 'تعذر تدوير الصورة.',  // added 7.3.2013
			'errResizeSize'        : 'حجم الصورة غير صالح.',  // added 7.3.2013
			'errResizeNoChange'    : 'لم يتغير حجم الصورة.',  // added 7.3.2013
			'errUsupportType'      : 'نوع ملف غير مدعوم.',
			'errNotUTF8Content'    : 'الملف "$1" ليس بتنسيق UTF-8 ولا يمكن تحريره.',  // added 9.11.2011
			'errNetMount'          : 'تعذر تحميل "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'بروتوكول غير مدعوم.',     // added 17.04.2012
			'errNetMountFailed'    : 'فشل جبل.',         // added 17.04.2012
			'errNetMountHostReq'   : 'المضيف مطلوب.', // added 18.04.2012
			'errSessionExpires'    : 'انتهت جلستك بسبب عدم النشاط.',
			'errCreatingTempDir'   : 'تعذر إنشاء دليل مؤقت: "$1"',
			'errFtpDownloadFile'   : 'تعذر تنزيل الملف من FTP: "$1"',
			'errFtpUploadFile'     : 'تعذر تحميل الملف إلى FTP: "$1"',
			'errFtpMkdir'          : 'تعذر إنشاء دليل بعيد على FTP: "$1"',
			'errArchiveExec'       : 'خطأ أثناء أرشفة الملفات: "$1"',
			'errExtractExec'       : 'خطأ أثناء استخراج الملفات: "$1"',
			'errNetUnMount'        : 'Unable to unmount.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'غير قابل للتحويل إلى UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'جرب المتصفح الحديث ، إذا كنت ترغب في تحميل المجلد.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'انتهت المهلة أثناء البحث عن "$1". نتيجة البحث جزئية.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'مطلوب إعادة التفويض.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'الحد الأقصى لعدد العناصر القابلة للتحديد هو $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'غير قادر على الاستعادة من سلة المهملات. لا يمكن تحديد وجهة الاستعادة.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'لم يتم العثور على المحرر لهذا النوع من الملفات.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'حدث خطأ من جانب الخادم.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'تعذر إفراغ المجلد "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'يوجد $1 أخطاء أخرى.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'أنشئ مجلد مضغوط',
			'cmdback'      : 'الخلف',
			'cmdcopy'      : 'نسخ',
			'cmdcut'       : 'قص',
			'cmddownload'  : 'تحميل',
			'cmdduplicate' : 'تكرار',
			'cmdedit'      : 'تعديل الملف',
			'cmdextract'   : 'استخراج الملفات',
			'cmdforward'   : 'الأمام',
			'cmdgetfile'   : 'اختيار الملفات',
			'cmdhelp'      : 'عن هذا المشروع',
			'cmdhome'      : 'المجلد الرئيس',
			'cmdinfo'      : 'معلومات ',
			'cmdmkdir'     : 'مجلد جديد',
			'cmdmkdirin'   : 'داخل ملف جديد', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'ملف جديد',
			'cmdopen'      : 'فتح',
			'cmdpaste'     : 'لصق',
			'cmdquicklook' : 'معاينة',
			'cmdreload'    : 'إعادة تحميل',
			'cmdrename'    : 'إعادة تسمية',
			'cmdrm'        : 'حذف',
			'cmdtrash'     : 'داخل سلة المهملات', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'أعاد ملكا إلى العرش', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'بحث عن ملفات',
			'cmdup'        : 'تغيير المسار إلى مستوى أعلى',
			'cmdupload'    : 'رفع ملفات',
			'cmdview'      : 'عرض',
			'cmdresize'    : 'تغيير الحجم والتدوير',
			'cmdsort'      : 'فرز',
			'cmdnetmount'  : 'Mount network volume', // added 18.04.2012
			'cmdnetunmount': 'قم بإلغاء التثبيت', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'إلى أماكن', // added 28.12.2014
			'cmdchmod'     : 'Change mode', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'فتح ملف', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'إعادة تعيين عرض العمود', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'ملء الشاشة', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'تحرك', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'تفريغ الملف', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'تراجع', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'إعاجة', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'التفضيلات', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'اختر الكل', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'لا تختر شيء', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'اختيار المقلوب', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'افتح في نافذة جديدة', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'إخفاء (تفضيل)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'إغلاق',
			'btnSave'   : 'حفظ',
			'btnRm'     : 'إزالة',
			'btnApply'  : 'تطبيق',
			'btnCancel' : 'إلغاء',
			'btnNo'     : 'لا',
			'btnYes'    : 'نعم',
			'btnMount'  : 'جبل',  // added 18.04.2012
			'btnApprove': 'انتقل إلى $1 والموافقة عليه', // from v2.1 added 26.04.2012
			'btnUnmount': 'قم بإلغاء التثبيت', // from v2.1 added 30.04.2012
			'btnConv'   : 'تحويل', // from v2.1 added 08.04.2014
			'btnCwd'    : 'هنا',      // from v2.1 added 22.5.2015
			'btnVolume' : 'الحجم جهارة الصوت',    // from v2.1 added 22.5.2015
			'btnAll'    : 'الكل',       // from v2.1 added 22.5.2015
			'btnMime'   : 'نوع التمثيل الصامت', // from v2.1 added 22.5.2015
			'btnFileName':'اسم الملف',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'حفظ وإغلاق', // from v2.1 added 12.6.2015
			'btnBackup' : 'النسخ احتياطي', // fromv2.1 added 28.11.2015
			'btnRename'    : 'إعادة تسمية',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'إعادة تسمية (الجميع)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'السابق ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'التالي ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'حفظ إلى', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'فتح مجلد',
			'ntffile'     : 'فتح ملف',
			'ntfreload'   : 'إعادة عرض محتويات المجلد ',
			'ntfmkdir'    : 'ينشئ المجلدات',
			'ntfmkfile'   : 'ينشئ الملفات',
			'ntfrm'       : 'حذف الملفات',
			'ntfcopy'     : 'نسخ الملفات',
			'ntfmove'     : 'نقل الملفات',
			'ntfprepare'  : 'تحضير لنسخ الملفات',
			'ntfrename'   : 'إعادة تسمية الملفات',
			'ntfupload'   : 'رفع الملفات',
			'ntfdownload' : 'تحميل الملفات',
			'ntfsave'     : 'حفظ الملفات',
			'ntfarchive'  : 'ينشئ ملف مضغوط',
			'ntfextract'  : 'استخراج ملفات من الملف المضغوط ',
			'ntfsearch'   : 'يبحث عن ملفات',
			'ntfresize'   : 'تغيير حجم الصور',
			'ntfsmth'     : 'يفعل شيئا',
			'ntfloadimg'  : 'تحميل الصورة',
			'ntfnetmount' : 'Mounting network volume', // added 18.04.2012
			'ntfnetunmount': 'Unmounting network volume', // from v2.1 added 30.04.2012
			'ntfdim'      : 'الحصول على أبعاد الصورة', // added 20.05.2013
			'ntfreaddir'  : 'قراءة معلومات الملف', // from v2.1 added 01.07.2013
			'ntfurl'      : 'الحصول على URL الارتباط', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'تغيير وضع الملف', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Verifying upload file name', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'إنشاء ملف للتحميل', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Getting path infomation', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'معالجة الملف المرفوع', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'القيام رمي في سلة المهملات', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'القيام بالاستعادة من سلة المهملات', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'التحقق من مجلد الوجهة', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'التراجع عن العملية السابقة', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'إعادة التراجع السابق', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'فحص المحتويات', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'مهملات', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'غير معلوم',
			'Today'       : 'اليوم',
			'Yesterday'   : 'البارحة',
			'msJan'       : 'كانون الثاني',
			'msFeb'       : 'شباط',
			'msMar'       : 'آذار',
			'msApr'       : 'نيسان',
			'msMay'       : 'أيار',
			'msJun'       : 'حزيران',
			'msJul'       : 'تموز',
			'msAug'       : 'آب',
			'msSep'       : 'أيلول',
			'msOct'       : 'تشرين الأول',
			'msNov'       : 'تشرين الثاني',
			'msDec'       : 'كانون الأول ',
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
			'Sunday'      : 'الأحد',
			'Monday'      : 'الاثنين',
			'Tuesday'     : 'الثلاثاء',
			'Wednesday'   : 'الإربعاء',
			'Thursday'    : 'الخميس',
			'Friday'      : 'الجمعة',
			'Saturday'    : 'السبت',
			'Sun'         : 'الأحد',
			'Mon'         : 'الاثنين',
			'Tue'         : 'الثلاثاء',
			'Wed'         : 'الإربعاء',
			'Thu'         : 'الخميس',
			'Fri'         : 'الجمعة',
			'Sat'         : 'السبت',

			/******************************** sort variants ********************************/
			'sortname'          : 'بالاسم',
			'sortkind'          : 'بالنوع',
			'sortsize'          : 'بالحجم',
			'sortdate'          : 'بالتاريخ',
			'sortFoldersFirst'  : 'الملفات أولا',
			'sortperm'          : 'بالصلاحيات', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'by mode',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'من قبل المالك',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'بالمجموعة',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'أيضا Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'ملف_جديد.txt', // added 10.11.2015
			'untitled folder'   : 'مجلد_جديد',   // added 10.11.2015
			'Archive'           : 'ملف_مضغوط',  // from v2.1 added 10.11.2015
			'untitled file'     : 'الملف الجديد. $1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: ملف',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'يرجى التأكيد',
			'confirmRm'       : 'هل أنت متأكد من أنك تريد الحذف؟ لا يمكن التراجع عن هذه العملية ',
			'confirmRepl'     : 'استبدال الملف القديم بملف جديد؟',
			'confirmRest'     : 'استبدال العنصر بالعنصر من سلة المهملات؟', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'ليس في UTF-8 <br/> هل تريد التحويل إلى UTF-8؟ <br/> تصبح المحتويات UTF-8 بالحفظ بعد التحويل.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'تعذر الكشف عن ترميز الأحرف لهذا الملف. يجب أن يتم التحويل مؤقتًا إلى UTF-8 للتحرير. <br/> الرجاء تحديد ترميز الأحرف لهذا الملف.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'تم تعديله. <br/> فقدان العمل إذا لم تقم بحفظ التغييرات.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'هل أنت متأكد أنك تريد نقل العناصر إلى سلة المهملات؟', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'هل أنت متأكد أنك تريد نقل العناصر إلى "$1"؟', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'تطبيق على الكل',
			'name'            : 'الاسم',
			'size'            : 'الحجم',
			'perms'           : 'الصلاحيات',
			'modify'          : 'آخر تعديل',
			'kind'            : 'نوع الملف',
			'read'            : 'قراءة',
			'write'           : 'كتابة',
			'noaccess'        : 'وصول ممنوع',
			'and'             : 'و',
			'unknown'         : 'غير معروف',
			'selectall'       : 'تحديد كل الملفات',
			'selectfiles'     : 'تحديد ملفات',
			'selectffile'     : 'تحديد الملف الأول',
			'selectlfile'     : 'تحديد الملف الأخير',
			'viewlist'        : 'عرض قائمة',
			'viewicons'       : 'عرض أيْقونات',
			'viewSmall'       : 'أيقونات صغيرة', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'الرموز المتوسطة', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'أيقونات كبيرة', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'أيقونات كبيرة جدًا', // from v2.1.39 added 22.5.2018
			'places'          : 'المواقع',
			'calc'            : 'حساب',
			'path'            : 'مسار',
			'aliasfor'        : 'الاسم المستعار لـ',
			'locked'          : 'مقفول',
			'dim'             : 'الأبعاد',
			'files'           : 'ملفات',
			'folders'         : 'مجلدات',
			'items'           : 'عناصر',
			'yes'             : 'نعم',
			'no'              : 'لا',
			'link'            : 'رابط',
			'searcresult'     : 'نتائج البحث',
			'selected'        : 'العناصر المحددة',
			'about'           : 'عن البرنامج',
			'shortcuts'       : 'الاختصارات',
			'help'            : 'مساعدة',
			'webfm'           : 'مدير ملفات الويب',
			'ver'             : 'رقم الإصدار',
			'protocolver'     : 'إصدار البرتوكول',
			'homepage'        : 'الصفحة الرئيسة',
			'docs'            : 'التوثيق',
			'github'          : 'شاركنا بتطوير المشروع على Github',
			'twitter'         : 'تابعنا على تويتر',
			'facebook'        : 'انضم إلينا على الفيس بوك',
			'team'            : 'الفريق',
			'chiefdev'        : 'رئيس المبرمجين',
			'developer'       : 'مبرمج',
			'contributor'     : 'مساعم',
			'maintainer'      : 'مشارك',
			'translator'      : 'مترجم',
			'icons'           : 'أيقونات',
			'dontforget'      : 'ولا تنس أن تأخذ المنشفة',
			'shortcutsof'     : 'الاختصارات غير مفعلة',
			'dropFiles'       : 'لصق الملفات هنا',
			'or'              : 'أو',
			'selectForUpload' : 'اختر الملفات التي تريد رفعها',
			'moveFiles'       : 'قص الملفات',
			'copyFiles'       : 'نسخ الملفات',
			'restoreFiles'    : 'استعادة العناصر', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'إزالة من الأماكن',
			'aspectRatio'     : 'نسبة أبعاد',
			'scale'           : 'مقياس',
			'width'           : 'عرض',
			'height'          : 'طول',
			'resize'          : 'تغيير الحجم',
			'crop'            : 'محصول',
			'rotate'          : 'استدارة',
			'rotate-cw'       : 'تدوير 90 درجة في اتجاه عقارب الساعة',
			'rotate-ccw'      : 'استدارة 90 درجة CCW',
			'degree'          : '°',
			'netMountDialogTitle' : 'Mount network volume', // added 18.04.2012
			'protocol'            : 'بروتوكول', // added 18.04.2012
			'host'                : 'مضيف', // added 18.04.2012
			'port'                : 'المنفذ', // added 18.04.2012
			'user'                : 'مستخدم', // added 18.04.2012
			'pass'                : 'كلمة العبور', // added 18.04.2012
			'confirmUnmount'      : 'Are you unmount $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'قم بإسقاط أو لصق الملفات من المتصفح', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'قم بإسقاط الملفات أو لصق عناوين URL أو الصور (الحافظة) هنا', // from v2.1 added 07.04.2014
			'encoding'        : 'ترميز', // from v2.1 added 19.12.2014
			'locale'          : 'لغة',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'الهدف: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'البحث عن طريق إدخال نوع MIME', // from v2.1 added 22.5.2015
			'owner'           : 'صاحب', // from v2.1 added 20.6.2015
			'group'           : 'Group', // from v2.1 added 20.6.2015
			'other'           : 'أخرى', // from v2.1 added 20.6.2015
			'execute'         : 'نفذ - اعدم', // from v2.1 added 20.6.2015
			'perm'            : 'الإذن', // from v2.1 added 20.6.2015
			'mode'            : 'دور الخياطة', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'مجلد فارغ', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'المجلد فارغ \\ A إسقاط لإضافة عناصر', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'المجلد فارغ \\ A ضغطة طويلة لإضافة عناصر', // from v2.1.6 added 30.12.2015
			'quality'         : 'جودة', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'مزامنة آلية',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'تحرك لأعلى',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'احصل على رابط URL', // from v2.1.7 added 9.2.2016
			'share'           : 'يتقاسم',
			'selectedItems'   : 'العناصر المحددة ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'معرف المجلد', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'السماح بالوصول دون اتصال', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'لإعادة المصادقة', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'جار التحميل ...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'افتح ملفات متعددة', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'أنت تحاول فتح ملفات $1. هل أنت متأكد أنك تريد فتح المتصفح؟', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'نتائج البحث فارغة في هدف البحث.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'يقوم بتحرير ملف.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'لقد حددت $1 عنصرًا.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'البريد الإلكترونيلديك عنصر $1 في الحافظة.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'البحث المتزايد هو فقط من العرض الحالي.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'العودة إلى الأصل', // from v2.1.15 added 3.8.2016
			'complete'        : 'اكتمل $1', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'قائمة السياق', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'الصفحة تحول', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'جذور الحجم', // from v2.1.16 added 16.9.2016
			'reset'           : 'إعادة تعيين', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'لون الخلفية', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'منتقي الألوان', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px Grid', // from v2.1.16 added 4.10.2016
			'enabled'         : 'تمكين', // from v2.1.16 added 4.10.2016
			'disabled'        : 'معاق', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'نتائج البحث فارغة في العرض الحالي. \\ اضغط [Enter] لتوسيع هدف البحث.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'أول نتائج البحث إلكتروني فارغة في طريقة العرض الحالية.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'تسمية نصية', // from v2.1.17 added 13.10.2016
			'minsLeft'        : 'دقائق متبقية $1', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Reopen with selected encoding', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Save with the selected encoding', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'حدد المجلد', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'البحث عن الحرف الأول', // from v2.1.23 added 24.3.2017
			'presets'         : 'الإعدادات المسبقة', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'إنها عناصر كثيرة جدًا لذا لا يمكن وضعها في سلة المهملات.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'إفراغ المجلد "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'لا توجد عناصر في المجلد "$1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'الأفضلية', // from v2.1.26 added 28.6.2017
			'language'        : 'إعدادات اللغة', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Initialize the settings saved in this browser', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'إعداد شريط الأدوات', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... يتبقى $1 حرف.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... بقي $1 سطر.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'مجموع', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'حجم ملف تقريبي', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Focus on the element of dialog with mouseover',  // from v2.1.30 added 2.11.2017
			'select'          : 'اختار', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'العمل عند تحديد الملف', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'افتح باستخدام المحرر المستخدم آخر مرة', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'اختيار المقلوب', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'هل أنت متأكد من أنك تريد إعادة تسمية العناصر المحددة $1 مثل $2؟ <br/> لا يمكن التراجع عن هذا!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'إعادة تسمية دفعة', // from v2.1.31 added 8.12.2017
			'plusNumber'      : 'رقم +', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'أضف البادئة', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'أضف لاحقة', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'تغيير التمديد', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'إعدادات الأعمدة (عرض القائمة)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'ستنعكس جميع التغييرات على الفور على الأرشيف.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Any changes will not reflect until un-mount this volume.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'المجلد (المجلدات) التالية التي تم تركيبها على هذا المجلد غير مثبتة أيضًا. هل أنت متأكد من إلغاء تحميله؟', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'معلومات التحديد', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'خوارزميات لإظهار تجزئة الملف', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'عناصر المعلومات (لوحة معلومات التحديد)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'اضغط مرة أخرى للخروج.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'شريط الأدوات', // from v2.1.38 added 4.4.2018
			'workspace'       : 'مساحة العمل', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Dialog', // from v2.1.38 added 4.4.2018
			'all'             : 'الكل', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'حجم الرمز (عرض الرموز)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'افتح نافذة المحرر المكبرة', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'نظرًا لعدم توفر التحويل بواسطة API حاليًا ، يرجى التحويل على موقع الويب.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'بعد التحويل ، يجب تحميل عنوان URL الخاص بالعنصر أو الملف الذي تم تنزيله لحفظ الملف المحول.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'تحويل على موقع $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'التكامل', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'يحتوي موقع elFinder على الخدمات الخارجية التالية المتكاملة. يرجى التحقق من شروط الاستخدام وسياسة الخصوصية وما إلى ذلك قبل استخدامها.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'إظهار العناصر المخفية', // from v2.1.41 added 24.7.2018
			'Code Editor'     :'محرر الكود',
			'hideHidden'      : 'إخفاء العناصر المخفية', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'إظهار/إخفاء العناصر المخفية', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'أنواع الملفات المطلوب تمكينها باستخدام "ملف جديد"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'نوع الملف النصي', // from v2.1.41 added 7.8.2018
			'add'             : 'أضف', // from v2.1.41 added 7.8.2018
			'theme'           : 'موضوع', // from v2.1.43 added 19.10.2018
			'default'         : 'الإفتراضي', // from v2.1.43 added 19.10.2018
			'description'     : 'وصف', // from v2.1.43 added 19.10.2018
			'website'         : 'موقع الكتروني', // from v2.1.43 added 19.10.2018
			'author'          : 'مؤلف', // from v2.1.43 added 19.10.2018
			'email'           : 'البريد الإلكتروني', // from v2.1.43 added 19.10.2018
			'license'         : 'رخصة', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'لا يمكن حفظ هذا العنصر. لتجنب فقدان التعديلات التي تحتاجها للتصدير إلى جهاز الكمبيوتر الخاص بك.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'انقر نقرًا مزدوجًا فوق الملف لتحديده.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'استخدم وضع ملء الشاشة', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'غير معروف',
			'kindRoot'        : 'Volume Root', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'مجلد',
			'kindSelects'     : 'التحديدات', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'اختصار',
			'kindAliasBroken' : 'اختصار غير صالح',
			// applications
			'kindApp'         : 'برنامج',
			'kindPostscript'  : 'Postscript ملف',
			'kindMsOffice'    : 'Microsoft Office ملف',
			'kindMsWord'      : 'Microsoft Word ملف',
			'kindMsExcel'     : 'Microsoft Excel ملف',
			'kindMsPP'        : 'Microsoft Powerpoint عرض تقديمي ',
			'kindOO'          : 'Open Office ملف',
			'kindAppFlash'    : 'تطبيق فلاش',
			'kindPDF'         : 'ملف (PDF)',
			'kindTorrent'     : 'Bittorrent ملف',
			'kind7z'          : '7z ملف',
			'kindTAR'         : 'TAR ملف',
			'kindGZIP'        : 'GZIP ملف',
			'kindBZIP'        : 'BZIP ملف',
			'kindXZ'          : 'XZ ملف',
			'kindZIP'         : 'ZIP ملف',
			'kindRAR'         : 'RAR ملف',
			'kindJAR'         : 'Java JAR ملف',
			'kindTTF'         : 'True Type خط ',
			'kindOTF'         : 'Open Type خط ',
			'kindRPM'         : 'RPM ملف تنصيب',
			// texts
			'kindText'        : 'Text ملف',
			'kindTextPlain'   : 'مستند نصي',
			'kindPHP'         : 'PHP ملف نصي برمجي لـ',
			'kindCSS'         : 'ورقة الأنماط المتتالية',
			'kindHTML'        : 'HTML ملف',
			'kindJS'          : 'Javascript ملف نصي برمجي لـ',
			'kindRTF'         : 'تنسيق نص منسق',
			'kindC'           : 'C ملف نصي برمجي لـ',
			'kindCHeader'     : 'C header ملف نصي برمجي لـ',
			'kindCPP'         : 'C++ ملف نصي برمجي لـ',
			'kindCPPHeader'   : 'C++ header ملف نصي برمجي لـ',
			'kindShell'       : 'Unix shell script',
			'kindPython'      : 'Python ملف نصي برمجي لـ',
			'kindJava'        : 'Java ملف نصي برمجي لـ',
			'kindRuby'        : 'Ruby ملف نصي برمجي لـ',
			'kindPerl'        : 'Perl script',
			'kindSQL'         : 'SQL ملف نصي برمجي لـ',
			'kindXML'         : 'XML ملف',
			'kindAWK'         : 'AWK ملف نصي برمجي لـ',
			'kindCSV'         : 'ملف CSV',
			'kindDOCBOOK'     : 'Docbook XML ملف',
			'kindMarkdown'    : 'Markdown text', // added 20.7.2015
			// images
			'kindImage'       : 'صورة',
			'kindBMP'         : 'BMP صورة',
			'kindJPEG'        : 'JPEG صورة',
			'kindGIF'         : 'GIF صورة',
			'kindPNG'         : 'PNG صورة',
			'kindTIFF'        : 'TIFF صورة',
			'kindTGA'         : 'TGA صورة',
			'kindPSD'         : 'Adobe Photoshop صورة',
			'kindXBITMAP'     : 'X bitmap صورة',
			'kindPXM'         : 'Pixelmator صورة',
			// media
			'kindAudio'       : 'ملف صوتي',
			'kindAudioMPEG'   : 'MPEG ملف صوتي',
			'kindAudioMPEG4'  : 'MPEG-4 ملف صوتي',
			'kindAudioMIDI'   : 'MIDI ملف صوتي',
			'kindAudioOGG'    : 'Ogg Vorbis ملف صوتي',
			'kindAudioWAV'    : 'WAV ملف صوتي',
			'AudioPlaylist'   : 'MP3 قائمة تشغيل',
			'kindVideo'       : 'ملف فيديو',
			'kindVideoDV'     : 'DV ملف فيديو',
			'kindVideoMPEG'   : 'MPEG ملف فيديو',
			'kindVideoMPEG4'  : 'MPEG-4 ملف فيديو',
			'kindVideoAVI'    : 'AVI ملف فيديو',
			'kindVideoMOV'    : 'Quick Time ملف فيديو',
			'kindVideoWM'     : 'Windows Media ملف فيديو',
			'kindVideoFlash'  : 'Flash ملف فيديو',
			'kindVideoMKV'    : 'Matroska ملف فيديو',
			'kindVideoOGG'    : 'Ogg ملف فيديو'
		}
	};
}));