/**
 * עברית translation
 * @author Yaron Shahrabani <sh.yaron@gmail.com>
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
	elFinder.prototype.i18.he = {
		translator : 'Yaron Shahrabani &lt;sh.yaron@gmail.com&gt;',
		language   : 'עברית',
		direction  : 'rtl',
		dateFormat : 'd.m.Y H:i', // will show like: 02.09.2020 11:14
		fancyDateFormat : '$1 H:i', // will show like: היום 11:14
		nonameDateFormat : 'ymd-His', // noname upload will show like: 200902-111458
		messages   : {

			/********************************** errors **********************************/
			'error'                : 'שגיאה',
			'errUnknown'           : 'שגיאה בלתי מוכרת.',
			'errUnknownCmd'        : 'פקודה בלתי מוכרת.',
			'errJqui'              : 'תצורת ה־jQuery UI שגויה. יש לכלול רכיבים הניתנים לבחירה, גרירה והשלכה.',
			'errNode'              : 'elFinder דורש יצירה של רכיב DOM.',
			'errURL'               : 'התצורה של elFinder שגויה! אפשרות הכתובת (URL) לא הוגדרה.',
			'errAccess'            : 'הגישה נדחית.',
			'errConnect'           : 'לא ניתן להתחבר למנגנון.',
			'errAbort'             : 'החיבור בוטל.',
			'errTimeout'           : 'זמן החיבור פג.',
			'errNotFound'          : 'לא נמצא מנגנון.',
			'errResponse'          : 'תגובת המנגנון שגויה.',
			'errConf'              : 'תצורת המנגנון שגויה.',
			'errJSON'              : 'המודול PHP JSON לא מותקן.',
			'errNoVolumes'         : 'אין כוננים זמינים לקריאה.',
			'errCmdParams'         : 'פרמטרים שגויים לפקודה „$1“.',
			'errDataNotJSON'       : 'הנתונים אינם JSON.',
			'errDataEmpty'         : 'הנתונים ריקים.',
			'errCmdReq'            : 'בקשה למנגנון דורשת שם פקודה.',
			'errOpen'              : 'לא ניתן לפתוח את „$1“.',
			'errNotFolder'         : 'הפריט אינו תיקייה.',
			'errNotFile'           : 'הפריט אינו קובץ.',
			'errRead'              : 'לא ניתן לקרוא את „$1“.',
			'errWrite'             : 'לא ניתן לכתוב אל „$1“.',
			'errPerm'              : 'ההרשאה נדחתה.',
			'errLocked'            : '„$1“ נעול ואין אפשרות לשנות את שמו, להעבירו או להסירו.',
			'errExists'            : 'קובץ בשם „$1“ כבר קיים.',
			'errInvName'           : 'שם הקובץ שגוי.',
			'errInvDirname'        : 'שם תיקיה לא חוקי.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'התיקייה לא נמצאה.',
			'errFileNotFound'      : 'הקובץ לא נמצא.',
			'errTrgFolderNotFound' : 'תיקיית היעד „$1“ לא נמצאה.',
			'errPopup'             : 'הדפדפן מנע פתיחת חלון קובץ. כדי לפתוח קובץ יש לאפשר זאת בהגדרות הדפדפן.',
			'errMkdir'             : 'לא ניתן ליצור את התיקייה „$1“.',
			'errMkfile'            : 'לא ניתן ליצור את הקובץ „$1“.',
			'errRename'            : 'לא ניתן לשנות את השם של „$1“.',
			'errCopyFrom'          : 'העתקת קבצים מהכונן „$1“ אינה מאופשרת.',
			'errCopyTo'            : 'העתקת קבצים אל הכונן „$1“ אינה מאופשרת.',
			'errMkOutLink'         : 'לא ניתן ליצור קישור מחוץ לשורש עוצמת הקול.', // from v2.1 added 03.10.2015
			'errUpload'            : 'שגיאת העלאה.',  // old name - errUploadCommon
			'errUploadFile'        : 'לא ניתן להעלות את „$1“.', // old name - errUpload
			'errUploadNoFiles'     : 'לא נמצאו קבצים להעלאה.',
			'errUploadTotalSize'   : 'הנתונים חורגים מהגודל המרבי המותר.', // old name - errMaxSize
			'errUploadFileSize'    : 'הקובץ חורג מהגודל המרבי המותר.', //  old name - errFileMaxSize
			'errUploadMime'        : 'סוג הקובץ אינו מורשה.',
			'errUploadTransfer'    : 'שגיאת העברה „$1“.',
			'errUploadTemp'        : 'לא ניתן ליצור קובץ זמני להעלאה.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'הפריט „$1“ כבר קיים במיקום זה ואי אפשר להחליפו בפריט מסוג אחר.', // new
			'errReplace'           : 'לא ניתן להחליף את „$1“.',
			'errSave'              : 'לא ניתן לשמור את „$1“.',
			'errCopy'              : 'לא ניתן להעתיק את „$1“.',
			'errMove'              : 'לא ניתן להעביר את „$1“.',
			'errCopyInItself'      : 'לא ניתן להעתיק את „$1“ לתוך עצמו.',
			'errRm'                : 'לא ניתן להסיר את „$1“.',
			'errTrash'             : 'לא ניתן לפח.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'לא ניתן להסיר את קובצי המקור.',
			'errExtract'           : 'לא ניתן לחלץ קבצים מהארכיון „$1“.',
			'errArchive'           : 'לא ניתן ליצור ארכיון.',
			'errArcType'           : 'סוג הארכיון אינו נתמך.',
			'errNoArchive'         : 'הקובץ אינו ארכיון או שסוג הקובץ שלו אינו נתמך.',
			'errCmdNoSupport'      : 'המנגנון אינו תומך בפקודה זו.',
			'errReplByChild'       : 'לא ניתן להחליף את התיקייה „$1“ בפריט מתוכה.',
			'errArcSymlinks'       : 'מטעמי אבטחה לא ניתן לחלץ ארכיונים שמכילים קישורים סימבוליים או קבצים עם שמות בלתי מורשים.', // edited 24.06.2012
			'errArcMaxSize'        : 'הארכיון חורג מהגודל המרבי המותר.',
			'errResize'            : 'לא ניתן לשנות את הגודל של „$1“.',
			'errResizeDegree'      : 'מעלות ההיפוך שגויות.',  // added 7.3.2013
			'errResizeRotate'      : 'לא ניתן להפוך את התמונה.',  // added 7.3.2013
			'errResizeSize'        : 'גודל התמונה שגוי.',  // added 7.3.2013
			'errResizeNoChange'    : 'גודל התמונה לא השתנה.',  // added 7.3.2013
			'errUsupportType'      : 'סוג הקובץ אינו נתמך.',
			'errNotUTF8Content'    : 'הקובץ „$1“ הוא לא בתסדיר UTF-8 ולא ניתן לערוך אותו.',  // added 9.11.2011
			'errNetMount'          : 'לא ניתן לעגן את „$1“.', // added 17.04.2012
			'errNetMountNoDriver'  : 'פרוטוקול בלתי נתמך.',     // added 17.04.2012
			'errNetMountFailed'    : 'העיגון נכשל.',         // added 17.04.2012
			'errNetMountHostReq'   : 'נדרש מארח.', // added 18.04.2012
			'errSessionExpires'    : 'ההפעלה שלך פגה עקב חוסר פעילות.',
			'errCreatingTempDir'   : 'לא ניתן ליצור תיקייה זמנית: „$1“',
			'errFtpDownloadFile'   : 'לא ניתן להוריד קובץ מ־ FTP: „$1“',
			'errFtpUploadFile'     : 'לא ניתן להעלות קובץ ל־FTP: „$1“',
			'errFtpMkdir'          : 'לא ניתן ליצור תיקייה מרוחקת ב־FTP: „$1“',
			'errArchiveExec'       : 'שמירת הקבצים בארכיון נכשלה: „$1“',
			'errExtractExec'       : 'חילוץ קבצים נכשל: „$1“',
			'errNetUnMount'        : 'Unable to unmount.', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'לא להמרה ל UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'נסה את הדפדפן המודרני, אם תרצה להעלות את התיקיה.', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'תם הזמן הקצוב לחיפוש "$1". תוצאת החיפוש היא חלקית.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'נדרש אישור מחדש.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'המספר המרבי של פריטים הניתנים לבחירה הוא $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'לא ניתן לשחזר מהאשפה. לא ניתן לזהות את לשחזר יעד.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'העורך לא נמצא לסוג הקובץ הזה.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'אירעה שגיאה בצד השרת.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'אין אפשרות לרוקן תיקייה "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'יש $1 שגיאות נוספות.', // from v2.1.44 added 9.12.2018

			/******************************* commands names ********************************/
			'cmdarchive'   : 'יצירת ארכיון',
			'cmdback'      : 'חזרה',
			'cmdcopy'      : 'העתקה',
			'cmdcut'       : 'גזירה',
			'cmddownload'  : 'הורדה',
			'cmdduplicate' : 'שכפול',
			'cmdedit'      : 'עריכת קובץ',
			'cmdextract'   : 'חילוץ קבצים מארכיון',
			'cmdforward'   : 'העברה',
			'cmdgetfile'   : 'בחירת קבצים',
			'cmdhelp'      : 'פרטים על התכנית הזו',
			'cmdhome'      : 'בית',
			'cmdinfo'      : 'קבלת מידע',
			'cmdmkdir'     : 'תיקייה חדשה',
			'cmdmkdirin'   : ' תוֹך תיקיה חדשה', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'קובץ חדש',
			'cmdopen'      : 'פתיחה',
			'cmdpaste'     : 'הדבקה',
			'cmdquicklook' : 'תצוגה מקדימה',
			'cmdreload'    : 'רענון',
			'cmdrename'    : 'שינוי שם',
			'cmdrm'        : 'מחיקה',
			'cmdtrash'     : 'בתוך האשפה', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'לשחזר', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'חיפוש קבצים',
			'cmdup'        : 'מעבר לתיקיית ההורה',
			'cmdupload'    : 'העלאת קבצים',
			'cmdview'      : 'תצוגה',
			'cmdresize'    : 'שינוי גודל והיפוך',
			'cmdsort'      : 'מיון',
			'cmdnetmount'  : 'עיגון כונן רשת', // added 18.04.2012
			'cmdnetunmount': 'Unmount', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'למקומות', // added 28.12.2014
			'cmdchmod'     : 'שנה מצב', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'פתח תיקיה', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'רוחב עמודת איפוס', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'מסך מלא', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'לָנוּעַ', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'רוקן את התיקיה', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'לשחזר', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'לַעֲשׂוֹת שׁוּב', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'העדפות', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'בחר הכל', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'בחר אף אחד', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'בחירה הפוך', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'פתח בחלון חדש', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'הסתר (העדפה)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'סגירה',
			'btnSave'   : 'שמירה',
			'btnRm'     : 'הסרה',
			'btnApply'  : 'החלה',
			'btnCancel' : 'ביטול',
			'btnNo'     : 'לא',
			'btnYes'    : 'כן',
			'btnMount'  : 'עיגון',  // added 18.04.2012
			'btnApprove': 'עבור ל- $1 ואשר', // from v2.1 added 26.04.2012
			'btnUnmount': 'Unmount', // from v2.1 added 30.04.2012
			'btnConv'   : 'להמיר', // from v2.1 added 08.04.2014
			'btnCwd'    : 'פה',      // from v2.1 added 22.5.2015
			'btnVolume' : 'כרך',    // from v2.1 added 22.5.2015
			'btnAll'    : 'את כל',       // from v2.1 added 22.5.2015
			'btnMime'   : 'סוג MIME', // from v2.1 added 22.5.2015
			'btnFileName':'שם קובץ',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'שמור וסגור', // from v2.1 added 12.6.2015
			'btnBackup' : 'גיבוי', // fromv2.1 added 28.11.2015
			'btnRename'    : 'שינוי שם',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'שנה שם (הכל)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'הקודם ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'הבא ($1/$2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'שמור בשם', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'פתיחת תיקייה',
			'ntffile'     : 'פתיחת קובץ',
			'ntfreload'   : 'רענון תוכן התיקייה',
			'ntfmkdir'    : 'תיקייה נוצרת',
			'ntfmkfile'   : 'קבצים נוצרים',
			'ntfrm'       : 'קבצים נמחקים',
			'ntfcopy'     : 'קבצים מועתקים',
			'ntfmove'     : 'קבצים מועברים',
			'ntfprepare'  : 'העתקת קבצים בהכנה',
			'ntfrename'   : 'שמות קבצים משתנים',
			'ntfupload'   : 'קבצים נשלחים',
			'ntfdownload' : 'קבצים מתקבלים',
			'ntfsave'     : 'שמירת קבצים',
			'ntfarchive'  : 'ארכיון נוצר',
			'ntfextract'  : 'מחולצים קבצים מארכיון',
			'ntfsearch'   : 'קבצים בחיפוש',
			'ntfresize'   : 'גודל קבצים משתנה',
			'ntfsmth'     : 'מתבצעת פעולה',
			'ntfloadimg'  : 'נטענת תמונה',
			'ntfnetmount' : 'כונן רשת מעוגן', // added 18.04.2012
			'ntfnetunmount': 'Unmounting network volume', // from v2.1 added 30.04.2012
			'ntfdim'      : 'ממדי תמונה מתקבלים', // added 20.05.2013
			'ntfreaddir'  : 'קריאת מידע על תיקיות', // from v2.1 added 01.07.2013
			'ntfurl'      : 'קבל URL של קישור', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'שינוי מצב קובץ', // from v2.1 added 20.6.2015
			'ntfpreupload': 'אמת את שם קובץ ההעלאה', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'יצירת קובץ להורדה', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'קבלת מידע על נתיב', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'עיבוד הקובץ שהועלה', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'עושה לזרוק לפח', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Doing restore from the trash', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'בודק תיקיית יעד', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'ביטול הפעולה הקודמת', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Redoing previous undone', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'בדיקת תכולה', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'פְּסוֹלֶת', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'לא ידוע',
			'Today'       : 'היום',
			'Yesterday'   : 'מחר',
			'msJan'       : 'ינו׳',
			'msFeb'       : 'פבר׳',
			'msMar'       : 'מרץ',
			'msApr'       : 'אפר׳',
			'msMay'       : 'מאי',
			'msJun'       : 'יונ׳',
			'msJul'       : 'יול׳',
			'msAug'       : 'אוג׳',
			'msSep'       : 'ספט׳',
			'msOct'       : 'אוק׳',
			'msNov'       : 'נוב׳',
			'msDec'       : 'דצמ׳',
			'January'     : 'ינואר',
			'February'    : 'פברואר',
			'March'       : 'מרץ',
			'April'       : 'אפריל',
			'May'         : 'מאי',
			'June'        : 'יוני',
			'July'        : 'יולי',
			'August'      : 'אוגוסט',
			'September'   : 'ספטמבר',
			'October'     : 'אוקטובר',
			'November'    : 'נובמבר',
			'December'    : 'דצמבר',
			'Sunday'      : 'יום ראשון',
			'Monday'      : 'יום שני',
			'Tuesday'     : 'יום שלישי',
			'Wednesday'   : 'יום רביעי',
			'Thursday'    : 'יום חמישי',
			'Friday'      : 'יום שישי',
			'Saturday'    : 'שבת',
			'Sun'         : 'א׳',
			'Mon'         : 'ב׳',
			'Tue'         : 'ג׳',
			'Wed'         : 'ד׳',
			'Thu'         : 'ה',
			'Fri'         : 'ו׳',
			'Sat'         : 'ש׳',

			/******************************** sort variants ********************************/
			'sortname'          : 'לפי שם',
			'sortkind'          : 'לפי סוג',
			'sortsize'          : 'לפי גודל',
			'sortdate'          : 'לפי תאריך',
			'sortFoldersFirst'  : 'תיקיות תחילה',
			'sortperm'          : 'ידי רשות', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'על ידי מצב',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'על ידי הבעלים',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'לפי קבוצה',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'גם Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'NewFile.txt', // added 10.11.2015
			'untitled folder'   : 'תיקייה חדשה',   // added 10.11.2015
			'Archive'           : 'ניו ארכיון',  // from v2.1 added 10.11.2015
			'untitled file'     : 'NewFile.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$1: קובץ',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'נדרש אישור',
			'confirmRm'       : 'להסיר את הקבצים?<br/>פעולה זו בלתי הפיכה!',
			'confirmRepl'     : 'להחליף קובץ ישן בקובץ חדש?',
			'confirmRest'     : 'להחליף את הפריט הקיים בפריט באשפה?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'לא ב- UTF-8 <br/> המרה ל- UTF-8? <br/> התוכן הופך ל- UTF-8 על ידי שמירה לאחר ההמרה.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'לא ניתן היה לזהות קידוד תווים של קובץ זה. עליו להמיר באופן זמני ל UTF-8 לעריכה. <br/> אנא בחר קידוד תווים של קובץ זה.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'היא שונתה. <br/> עבודה לאבד אם לא ישמור שינויים.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'האם אתה בטוח שברצונך להעביר פריטים לפח האשפה?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'האם אתה בטוח שברצונך להעביר פריטים ל "$1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'להחיל על הכול',
			'name'            : 'שם',
			'size'            : 'גודל',
			'perms'           : 'הרשאות',
			'modify'          : 'שינוי',
			'kind'            : 'סוג',
			'read'            : 'קריאה',
			'write'           : 'כתיבה',
			'noaccess'        : 'אין גישה',
			'and'             : 'וגם',
			'unknown'         : 'לא ידוע',
			'selectall'       : 'בחירת כל הקבצים',
			'selectfiles'     : 'בחירת קובץ אחד ומעלה',
			'selectffile'     : 'בחירת הקובץ הראשון',
			'selectlfile'     : 'בחירת הקובץ האחרון',
			'viewlist'        : 'תצוגת רשימה',
			'viewicons'       : 'תצוגת סמלים',
			'viewSmall'       : 'אייקונים קטנים', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'סמלים קטנים', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'אייקונים גדולים', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'אייקונים גדולים במיוחד', // from v2.1.39 added 22.5.2018
			'places'          : 'מיקומים',
			'calc'            : 'חישוב',
			'path'            : 'נתיב',
			'aliasfor'        : 'כינוי עבור',
			'locked'          : 'נעול',
			'dim'             : 'ממדים',
			'files'           : 'קבצים',
			'folders'         : 'תיקיות',
			'items'           : 'פריטים',
			'yes'             : 'כן',
			'no'              : 'לא',
			'link'            : 'קישור',
			'searcresult'     : 'תוצאות חיפוש',
			'selected'        : 'קבצים נבחרים',
			'about'           : 'על אודות',
			'shortcuts'       : 'קיצורי דרך',
			'help'            : 'עזרה',
			'webfm'           : 'מנהל קבצים בדפדפן',
			'ver'             : 'גרסה',
			'protocolver'     : 'גרסת פרוטוקול',
			'homepage'        : 'דף הבית של המיזם',
			'docs'            : 'תיעוד',
			'github'          : 'פילוג עותק ב־Github',
			'twitter'         : 'לעקוב אחרינו בטוויטר',
			'facebook'        : 'להצטרף אלינו בפייסבוק',
			'team'            : 'צוות',
			'chiefdev'        : 'מפתח ראשי',
			'developer'       : 'מתכנת',
			'contributor'     : 'תורם',
			'maintainer'      : 'מתחזק',
			'translator'      : 'מתרגם',
			'icons'           : 'סמלים',
			'dontforget'      : 'לא לשכוח לקחת את המגבת שלך',
			'shortcutsof'     : 'קיצורי הדרך מנוטרלים',
			'dropFiles'       : 'ניתן להשליך את הקבצים לכאן',
			'or'              : 'או',
			'selectForUpload' : 'לבחור קבצים להעלאה',
			'moveFiles'       : 'העברת קבצים',
			'copyFiles'       : 'העתקת קבצים',
			'restoreFiles'    : 'שחזר פריטים', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'הסרה ממיקומים',
			'aspectRatio'     : 'יחס תצוגה',
			'scale'           : 'מתיחה',
			'width'           : 'רוחב',
			'height'          : 'גובה',
			'resize'          : 'שינוי הגודל',
			'crop'            : 'חיתוך',
			'rotate'          : 'היפוך',
			'rotate-cw'       : 'היפוך ב־90 מעלות נגד השעון',
			'rotate-ccw'      : 'היפוך ב־90 מעלות עם השעון CCW',
			'degree'          : '°',
			'netMountDialogTitle' : 'עיגון כונן רשת', // added 18.04.2012
			'protocol'            : 'פרוטוקול', // added 18.04.2012
			'host'                : 'מארח', // added 18.04.2012
			'port'                : 'פתחה', // added 18.04.2012
			'user'                : 'משתמש', // added 18.04.2012
			'pass'                : 'ססמה', // added 18.04.2012
			'confirmUnmount'      : 'Are you unmount $1?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'זרוק או הדבק קבצים מהדפדפן', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'שחרר קבצים, הדבק כתובות URL או תמונות (לוח) כאן', // from v2.1 added 07.04.2014
			'encoding'        : 'הַצפָּנָה', // from v2.1 added 19.12.2014
			'locale'          : 'אזור',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'יעד: 1 $',                // from v2.1 added 22.5.2015
			'searchMime'      : 'חפש לפי קלט סוג MIME', // from v2.1 added 22.5.2015
			'owner'           : 'בעלים', // from v2.1 added 20.6.2015
			'group'           : 'קְבוּצָה', // from v2.1 added 20.6.2015
			'other'           : 'אַחֵר', // from v2.1 added 20.6.2015
			'execute'         : 'לבצע', // from v2.1 added 20.6.2015
			'perm'            : 'רְשׁוּת', // from v2.1 added 20.6.2015
			'mode'            : 'דֶרֶך', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'התיקייה ריקה', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'התיקיה ריקה \\ טיפה להוספת פריטים', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'התיקיה ריקה \\ לחיצה ארוכה כדי להוסיף פריטים', // from v2.1.6 added 30.12.2015
			'quality'         : 'איכות', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'סנכרון אוטומטי',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'הזז למעלה',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'קבל קישור URL', // from v2.1.7 added 9.2.2016
			'share'           : 'מְנָיָה',
			'selectedItems'   : 'פריטים נבחרים ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'מזהה תיקיה', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'אפשר גישה לא מקוונת', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'לאמת מחדש', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'בטעינה...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'פתח קבצים מרובים', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'אתה מנסה לפתוח את קבצי $1. האם אתה בטוח שברצונך לפתוח בדפדפן?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'תוצאות החיפוש ריקות ביעד החיפוש.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'זה עריכת קובץ.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'בחרת פריטים של $1.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'יש לך פריטים של $1 בלוח.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'חיפוש הדרגתי הוא רק מהתצוגה הנוכחית.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'לְהַחזִיר לְמַעֲמדוֹ', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 הושלם', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'תפריט הקשר', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'הפיכת עמוד', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'שורשי נפח', // from v2.1.16 added 16.9.2016
			'reset'           : 'איפוס', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'צבע רקע', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'בורר צבע', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : '8px Grid', // from v2.1.16 added 4.10.2016
			'enabled'         : 'לְאַפשֵׁר', // from v2.1.16 added 4.10.2016
			'disabled'        : 'מושבת', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'תוצאות החיפוש ריקות בתצוגה הנוכחית. \\A לחץ על [Enter] כדי להרחיב את יעד החיפוש.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'תוצאות חיפוש האות הראשונה ריקות בתצוגה הנוכחית.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'תווית טקסט', // from v2.1.17 added 13.10.2016
			'minsLeft'        : 'נותרו $1 דקות', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'פתח מחדש עם קידוד שנבחר', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'שמור עם הקידוד שנבחר', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'בחר תיקייה', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'חיפוש אותיות ראשונות', // from v2.1.23 added 24.3.2017
			'presets'         : 'הגדרות קבועות מראש', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'זה יותר מדי פריטים ולכן זה לא יכול להיות לפח.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'רוקן את התיקיה "$1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'אין פריטים בתיקייה "$1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'הַעֲדָפָה', // from v2.1.26 added 28.6.2017
			'language'        : 'שפה', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'אתחל את ההגדרות השמורות בדפדפן זה', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'הגדרות סרגל הכלים', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... נותרו $1 תווים.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... נותרו $1 שורות.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'סְכוּם', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'גודל קובץ מחוספס', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Focus on the element of dialog with mouseover',  // from v2.1.30 added 2.11.2017
			'select'          : 'בחר', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'פעולה בעת בחירת קובץ', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'פתח עם העורך ששימש בפעם האחרונה', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'בחירה הפוך', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'האם אתה בטוח שברצונך לשנות את שם הפריטים שנבחרו $1 כמו $2? <br/> לא ניתן לבטל זאת!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'שינוי שם אצווה', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ מספר', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'הוסף קידומת', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'סיומת הוספה', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'שנה סיומת', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'הגדרות עמודות (תצוגת רשימה)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'כל שינויים ישקפו באופן מיידי את הארכיון.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Any changes will not reflect until un-mount this volume.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : 'The following volume(s) mounted on this volume also unmounted. Are you sure to unmount it?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'מידע על בחירה', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'אלגוריתמים להראות חשיש הקובץ', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'פריטי מידע (לוח מבחר מידע)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'לחץ שוב כדי לצאת.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'סרגל כלים', // from v2.1.38 added 4.4.2018
			'workspace'       : 'שטח עבודה', // from v2.1.38 added 4.4.2018
			'dialog'          : 'תיבת דיאלוג', // from v2.1.38 added 4.4.2018
			'all'             : 'כֹּל', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'גודל אייקון (תצוגת סמלים)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'פתח את חלון העורך המקסימלי', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'בגלל המרה על ידי API אינה זמינה כרגע, אנא להמיר באתר.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'לאחר ההמרה, עליך להעלות עם כתובת ה- URL של הפריט או קובץ שהורד כדי לשמור את הקובץ שהומר.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'המרה באתר של $1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'אינטגרציות', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'ל- elFinder משולבים השירותים החיצוניים הבאים. אנא בדוק את תנאי השימוש, מדיניות הפרטיות וכו \'לפני השימוש בו.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'הצג פריטים מוסתרים', // from v2.1.41 added 24.7.2018
			'Code Editor'     : 'עורך קוד',
			'hideHidden'      : 'הסתר פריטים מוסתרים', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'הצג/הסתר פריטים מוסתרים', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'File types to enable with "New file"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'סוג של קובץ הטקסט', // from v2.1.41 added 7.8.2018
			'add'             : 'הוסף', // from v2.1.41 added 7.8.2018
			'theme'           : 'ערכת נושא', // from v2.1.43 added 19.10.2018
			'default'         : 'בְּרִירַת מֶחדָל', // from v2.1.43 added 19.10.2018
			'description'     : 'תיאור', // from v2.1.43 added 19.10.2018
			'website'         : 'אתר אינטרנט', // from v2.1.43 added 19.10.2018
			'author'          : 'מְחַבֵּר', // from v2.1.43 added 19.10.2018
			'email'           : 'אימייל', // from v2.1.43 added 19.10.2018
			'license'         : 'רישיון', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'לא ניתן לשמור פריט זה. כדי להימנע מאיבוד העריכות עליך לייצא למחשב האישי שלך.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'לחץ פעמיים על הקובץ כדי לבחור אותו.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'השתמש במצב מסך מלא', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'בלתי ידוע',
			'kindRoot'        : 'שורש נפח', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'תיקייה',
			'kindSelects'     : 'Selections', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'כינוי',
			'kindAliasBroken' : 'כינוי שבור',
			// applications
			'kindApp'         : 'יישום',
			'kindPostscript'  : 'מסמך Postscript',
			'kindMsOffice'    : 'מסמך Microsoft Office',
			'kindMsWord'      : 'מסמך Microsoft Word',
			'kindMsExcel'     : 'מסמך Microsoft Excel',
			'kindMsPP'        : 'מצגת Microsoft Powerpoint',
			'kindOO'          : 'מסמך Open Office',
			'kindAppFlash'    : 'יישום Flash',
			'kindPDF'         : 'Portable Document Format (PDF)',
			'kindTorrent'     : 'קובץ Bittorrent',
			'kind7z'          : 'ארכיון 7z',
			'kindTAR'         : 'ארכיון TAR',
			'kindGZIP'        : 'ארכיון GZIP',
			'kindBZIP'        : 'ארכיון BZIP',
			'kindXZ'          : 'ארכיון XZ',
			'kindZIP'         : 'ארכיון ZIP',
			'kindRAR'         : 'ארכיון RAR',
			'kindJAR'         : 'קובץ JAR של Java',
			'kindTTF'         : 'גופן True Type',
			'kindOTF'         : 'גופן Open Type',
			'kindRPM'         : 'חבילת RPM',
			// texts
			'kindText'        : 'מסמך טקסט',
			'kindTextPlain'   : 'טקסט פשוט',
			'kindPHP'         : 'מקור PHP',
			'kindCSS'         : 'גיליון סגנון מדורג',
			'kindHTML'        : 'מסמך HTML',
			'kindJS'          : 'מקור Javascript',
			'kindRTF'         : 'תבנית טקסט עשיר',
			'kindC'           : 'מקור C',
			'kindCHeader'     : 'מקור כותרת C',
			'kindCPP'         : 'מקור C++',
			'kindCPPHeader'   : 'מקור כותרת C++',
			'kindShell'       : 'תסריט מעטפת יוניקס',
			'kindPython'      : 'מקור Python',
			'kindJava'        : 'מקור Java',
			'kindRuby'        : 'מקור Ruby',
			'kindPerl'        : 'תסריט Perl',
			'kindSQL'         : 'מקור SQL',
			'kindXML'         : 'מקור XML',
			'kindAWK'         : 'מקור AWK',
			'kindCSV'         : 'ערכים מופרדים בפסיקים',
			'kindDOCBOOK'     : 'מסמךDocbook XML',
			'kindMarkdown'    : 'טקסט Markdown', // added 20.7.2015
			// images
			'kindImage'       : 'תמונה',
			'kindBMP'         : 'תמונת BMP',
			'kindJPEG'        : 'תמונת JPEG',
			'kindGIF'         : 'תמונת GIF',
			'kindPNG'         : 'תמונת PNG',
			'kindTIFF'        : 'תמונת TIFF',
			'kindTGA'         : 'תמונת TGA',
			'kindPSD'         : 'תמונת Adobe Photoshop',
			'kindXBITMAP'     : 'תמונת מפת סיביות X',
			'kindPXM'         : 'תמונת Pixelmator',
			// media
			'kindAudio'       : 'מדיה מסוג שמע',
			'kindAudioMPEG'   : 'שמע MPEG',
			'kindAudioMPEG4'  : 'שמע MPEG-4',
			'kindAudioMIDI'   : 'שמע MIDI',
			'kindAudioOGG'    : 'שמע Ogg Vorbis',
			'kindAudioWAV'    : 'שמע WAV',
			'AudioPlaylist'   : 'רשימת נגינה MP3',
			'kindVideo'       : 'מדיה מסוג וידאו',
			'kindVideoDV'     : 'סרטון DV',
			'kindVideoMPEG'   : 'סרטון MPEG',
			'kindVideoMPEG4'  : 'סרטון MPEG-4',
			'kindVideoAVI'    : 'סרטון AVI',
			'kindVideoMOV'    : 'סרטון Quick Time',
			'kindVideoWM'     : 'סרטון Windows Media',
			'kindVideoFlash'  : 'סרטון Flash',
			'kindVideoMKV'    : 'סרטון Matroska',
			'kindVideoOGG'    : 'סרטון Ogg'
		}
	};
}));