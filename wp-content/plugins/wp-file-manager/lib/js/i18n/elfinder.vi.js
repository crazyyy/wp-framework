/**
 * Ngôn ngữ Việt Nam translation
 * @author Chung Thủy f <chungthuyf@gmail.com>
 * @author Son Nguyen <son.nguyen@catalyst.net.nz>
 * @author Nguyễn Trần Chung <admin@chungnguyen.xyz>
 * @version 2022-03-04
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
	elFinder.prototype.i18.vi = {
		translator : 'Chung Thủy f &lt;chungthuyf@gmail.com&gt;, Son Nguyen &lt;son.nguyen@catalyst.net.nz&gt;, Nguyễn Trần Chung &lt;admin@chungnguyen.xyz&gt;',
		language   : 'Ngôn ngữ Việt Nam',
		direction  : 'ltr',
		dateFormat : 'd.m.Y H:i', // will show like: 04.03.2022 11:11
		fancyDateFormat : '$1 H:i', // will show like: Hôm nay 11:11
		nonameDateFormat : 'ymd-His', // noname upload will show like: 220304-111107
		messages   : {
			'getShareText' : 'Đăng lại',
			'Editor ': 'Trình chỉnh sửa mã',

			/********************************** errors **********************************/
			'error'                : 'Lỗi',
			'errUnknown'           : 'Lỗi không xác định được.',
			'errUnknownCmd'        : 'Lỗi không rõ lệnh.',
			'errJqui'              : 'Cấu hình jQueryUI không hợp lệ. Các thành phần lựa chọn, kéo và thả phải được bao gồm.',
			'errNode'              : 'elFinder đòi hỏi phần tử DOM phải được tạo ra.',
			'errURL'               : 'Cấu hình elFinder không hợp lệ! URL không được thiết lập tùy chọn.',
			'errAccess'            : 'Truy cập bị từ chối.',
			'errConnect'           : 'Không thể kết nối với backend.',
			'errAbort'             : 'Kết nối bị hủy bỏ.',
			'errTimeout'           : 'Thời gian chờ kết nối đã hết.',
			'errNotFound'          : 'Backend không tìm thấy.',
			'errResponse'          : 'Phản hồi backend không hợp lệ.',
			'errConf'              : 'Cấu hình backend không hợp lệ.',
			'errJSON'              : 'Mô-đun PHP JSON không được cài đặt.',
			'errNoVolumes'         : 'Tập có thể đọc không có sẵn.',
			'errCmdParams'         : 'Thông số không hợp lệ cho lệnh "$1".',
			'errDataNotJSON'       : 'Dữ liệu không phải là JSON.',
			'errDataEmpty'         : 'Dữ liệu trống.',
			'errCmdReq'            : 'Backend đòi hỏi tên lệnh.',
			'errOpen'              : 'Không thể mở "$1".',
			'errNotFolder'         : 'Đối tượng không phải là một thư mục.',
			'errNotFile'           : 'Đối tượng không phải là một tập tin.',
			'errRead'              : 'Không thể đọc "$1".',
			'errWrite'             : 'Không thể ghi vào "$1".',
			'errPerm'              : 'Quyền bị từ chối.',
			'errLocked'            : '"$1" đã bị khóa và không thể đổi tên, di chuyển hoặc loại bỏ.',
			'errExists'            : 'Tập tin có tên "$1" đã tồn tại.',
			'errInvName'           : 'Tên tập tin không hợp lệ.',
			'errInvDirname'        : 'Tên thư mục không hợp lệ.',  // from v2.1.24 added 12.4.2017
			'errFolderNotFound'    : 'Thư mục không tìm thấy.',
			'errFileNotFound'      : 'Tập tin không tìm thấy.',
			'errTrgFolderNotFound' : 'Thư mục đích "$1" không được tìm thấy.',
			'errPopup'             : 'Trình duyệt ngăn chặn mở cửa sổ popup.',
			'errMkdir'             : 'Không thể tạo thư mục "$1".',
			'errMkfile'            : 'Không thể tạo tập tin "$1".',
			'errRename'            : 'Không thể đổi tên "$1".',
			'errCopyFrom'          : 'Sao chép tập tin từ tập "$1" không được phép.',
			'errCopyTo'            : 'Sao chép tập tin tới tập "$1" không được phép.',
			'errMkOutLink'         : 'Không thể tạo liên kết ra bên ngoài volume root.', // from v2.1 added 03.10.2015
			'errUpload'            : 'Tải lên báo lỗi.',  // old name - errUploadCommon
			'errUploadFile'        : 'Không thể tải lên "$1".', // old name - errUpload
			'errUploadNoFiles'     : 'Không thấy tập tin nào để tải lên.',
			'errUploadTotalSize'   : 'Dữ liệu vượt quá kích thước tối đa cho phép.', // old name - errMaxSize
			'errUploadFileSize'    : 'Tập tin vượt quá kích thước tối đa cho phép.', //  old name - errFileMaxSize
			'errUploadMime'        : 'Kiểu tập tin không được phép.',
			'errUploadTransfer'    : 'Lỗi khi truyền "$1".',
			'errUploadTemp'        : 'Không thể tạo thư mục tạm để tải lên.', // from v2.1 added 26.09.2015
			'errNotReplace'        : 'Đối tượng "$1" đã tồn tại ở vị trí này và không thể thay thế bằng đối tượng với loại khác.', // new
			'errReplace'           : 'Không thể thay thế "$1".',
			'errSave'              : 'Không thể lưu "$1".',
			'errCopy'              : 'Không thể sao chép "$1".',
			'errMove'              : 'Không thể chuyển "$1".',
			'errCopyInItself'      : 'Không thể sao chép "$1" vào chính nó.',
			'errRm'                : 'Không thể xóa "$1".',
			'errTrash'             : 'Không thể cho vào thùng rác.', // from v2.1.24 added 30.4.2017
			'errRmSrc'             : 'Không thể xóa tệp nguồn.',
			'errExtract'           : 'Không thể giải nén các tập tin từ"$1".',
			'errArchive'           : 'Không thể tạo ra lưu trữ.',
			'errArcType'           : 'Loại lưu trữ không được hỗ trợ.',
			'errNoArchive'         : 'Tập tin không phải là lưu trữ hoặc có kiểu lưu trữ không được hỗ trợ.',
			'errCmdNoSupport'      : 'Backend không hỗ trợ lệnh này.',
			'errReplByChild'       : 'Thư mục "$1" không thể được thay thế bằng một mục con mà nó chứa.',
			'errArcSymlinks'       : 'Vì lý do bảo mật, từ chối giải nén tập tin lưu trữ có chứa liên kết mềm.', // edited 24.06.2012
			'errArcMaxSize'        : 'Tập tin lưu trữ vượt quá kích thước tối đa cho phép.',
			'errResize'            : 'Không thể thay đổi kích thước "$1".',
			'errResizeDegree'      : 'Độ xoay không hợp lệ.',  // added 7.3.2013
			'errResizeRotate'      : 'Không thể xoay hình ảnh.',  // added 7.3.2013
			'errResizeSize'        : 'Kích thước hình ảnh không hợp lệ.',  // added 7.3.2013
			'errResizeNoChange'    : 'Kích thước hình ảnh không thay đổi.',  // added 7.3.2013
			'errUsupportType'      : 'Loại tập tin không được hỗ trợ.',
			'errNotUTF8Content'    : 'Tệp "$1" không phải bộ ký tự UTF-8 nên không thể chỉnh sửa.',  // added 9.11.2011
			'errNetMount'          : 'Không thể gắn kết "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : 'Giao thức không được hỗ trợ.',     // added 17.04.2012
			'errNetMountFailed'    : 'Gắn (kết nối) thất bại.',         // added 17.04.2012
			'errNetMountHostReq'   : 'Yêu cầu máy chủ.', // added 18.04.2012
			'errSessionExpires'    : 'Phiên của bạn đã hết hạn do không hoạt động.',
			'errCreatingTempDir'   : 'Không thể tạo thư mục tạm thời: "$1"',
			'errFtpDownloadFile'   : 'Không thể tải xuống tệp từ FTP: "$1"',
			'errFtpUploadFile'     : 'Không thể tải tệp lên FTP: "$1"',
			'errFtpMkdir'          : 'Không thể tạo thư mục từ xa trên FTP: "$1"',
			'errArchiveExec'       : 'Lỗi trong khi lưu trữ tệp: "$1"',
			'errExtractExec'       : 'Lỗi trong khi giải nén tập tin: "$1"',
			'errNetUnMount'        : 'Không thể gỡ gắn (liên kết).', // from v2.1 added 30.04.2012
			'errConvUTF8'          : 'Không thể chuyển đổi thành UTF-8', // from v2.1 added 08.04.2014
			'errFolderUpload'      : 'Hãy thử trình duyệt mới hơn (vì trình duyệt hiện tại có vẻ cũ nên không hỗ trợ  tải lên thư mục).', // from v2.1 added 26.6.2015
			'errSearchTimeout'     : 'Đã hết thời gian trong khi tìm kiếm "$1". Kết quả tìm kiếm là một phần.', // from v2.1 added 12.1.2016
			'errReauthRequire'     : 'Cần ủy quyền lại.', // from v2.1.10 added 24.3.2016
			'errMaxTargets'        : 'Số lượng tối đa của các mục có thể chọn là $1.', // from v2.1.17 added 17.10.2016
			'errRestore'           : 'Không thể khôi phục từ thùng rác. Không thể xác định đích khôi phục.', // from v2.1.24 added 3.5.2017
			'errEditorNotFound'    : 'Không tìm thấy trình chỉnh sửa cho loại tệp này.', // from v2.1.25 added 23.5.2017
			'errServerError'       : 'Lỗi xảy ra ở phía máy chủ.', // from v2.1.25 added 16.6.2017
			'errEmpty'             : 'Không thể làm rỗng thư mục "$1".', // from v2.1.25 added 22.6.2017
			'moreErrors'           : 'Có thêm $1 lỗi.', // from v2.1.44 added 9.12.2018
			'errMaxMkdirs'         : 'Bạn có thể tạo tối đa $ 1 thư mục cùng một lúc.', // from v2.1.58 added 20.6.2021

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Tạo tập tin nén',
			'cmdback'      : 'Trở lại',
			'cmdcopy'      : 'Sao chép',
			'cmdcut'       : 'Cắt',
			'cmddownload'  : 'Tải về',
			'cmdduplicate' : 'Bản sao',
			'cmdedit'      : 'Sửa tập tin',
			'cmdextract'   : 'Giải nén tập tin',
			'cmdforward'   : 'Trước',
			'cmdgetfile'   : 'Chọn tập tin',
			'cmdhelp'      : 'Giới thiệu phần mềm',
			'cmdhome'      : 'Home',
			'cmdinfo'      : 'Thông tin',
			'cmdmkdir'     : 'Thư mục',
			'cmdmkdirin'   : 'Vào thư mục mới', // from v2.1.7 added 19.2.2016
			'cmdmkfile'    : 'Tạo tập tin Text',
			'cmdopen'      : 'Mở',
			'cmdpaste'     : 'Dán',
			'cmdquicklook' : 'Xem trước',
			'cmdreload'    : 'Nạp lại',
			'cmdrename'    : 'Đổi tên',
			'cmdrm'        : 'Xóa',
			'cmdtrash'     : 'Vào thùng rác', //from v2.1.24 added 29.4.2017
			'cmdrestore'   : 'Khôi phục', //from v2.1.24 added 3.5.2017
			'cmdsearch'    : 'Tìm tập tin',
			'cmdup'        : 'Đi tới thư mục mẹ',
			'cmdupload'    : 'Tải tập tin lên',
			'cmdview'      : 'Xem',
			'cmdresize'    : 'Thay đổi kích thước và xoay',
			'cmdsort'      : 'Sắp xếp',
			'cmdnetmount'  : 'Gắn kết khối lượng mạng', // added 18.04.2012
			'cmdnetunmount': 'Gỡ mount', // from v2.1 added 30.04.2012
			'cmdplaces'    : 'Đến địa điểm', // added 28.12.2014
			'cmdchmod'     : 'Thay đổi chế độ', // from v2.1 added 20.6.2015
			'cmdopendir'   : 'Mở một thư mục', // from v2.1 added 13.1.2016
			'cmdcolwidth'  : 'Đặt lại chiều rộng cột', // from v2.1.13 added 12.06.2016
			'cmdfullscreen': 'Toàn màn hình', // from v2.1.15 added 03.08.2016
			'cmdmove'      : 'Di chuyển', // from v2.1.15 added 21.08.2016
			'cmdempty'     : 'Làm rỗng thư mục', // from v2.1.25 added 22.06.2017
			'cmdundo'      : 'Hủy bỏ (hoàn tác)', // from v2.1.27 added 31.07.2017
			'cmdredo'      : 'Làm lại', // from v2.1.27 added 31.07.2017
			'cmdpreference': 'Sở thích', // from v2.1.27 added 03.08.2017
			'cmdselectall' : 'Chọn tất cả', // from v2.1.28 added 15.08.2017
			'cmdselectnone': 'Không chọn gì', // from v2.1.28 added 15.08.2017
			'cmdselectinvert': 'Chọn ngược lại', // from v2.1.28 added 15.08.2017
			'cmdopennew'   : 'Mở trong cửa sổ mới', // from v2.1.38 added 3.4.2018
			'cmdhide'      : 'Ẩn (Preference)', // from v2.1.41 added 24.7.2018

			/*********************************** buttons ***********************************/
			'btnClose'  : 'Đóng',
			'btnSave'   : 'Lưu',
			'btnRm'     : 'Gỡ bỏ',
			'btnApply'  : 'Áp dụng',
			'btnCancel' : 'Hủy bỏ',
			'btnNo'     : 'Không',
			'btnYes'    : 'Đồng ý',
			'btnMount'  : 'Gắn kết',  // added 18.04.2012
			'btnApprove': 'Đạt được $ 1 và phê duyệt', // from v2.1 added 26.04.2012
			'btnUnmount': 'Tháo gỡ', // from v2.1 added 30.04.2012
			'btnConv'   : 'Chuyển thành', // from v2.1 added 08.04.2014
			'btnCwd'    : 'Đây',      // from v2.1 added 22.5.2015
			'btnVolume' : 'Âm lượng',    // from v2.1 added 22.5.2015
			'btnAll'    : 'Tất cả',       // from v2.1 added 22.5.2015
			'btnMime'   : 'Loại MIME', // from v2.1 added 22.5.2015
			'btnFileName':'Tên tệp',  // from v2.1 added 22.5.2015
			'btnSaveClose': 'Lưu & Đóng', // from v2.1 added 12.6.2015
			'btnBackup' : 'Sao lưu', // fromv2.1 added 28.11.2015
			'btnRename'    : 'Đổi tên',      // from v2.1.24 added 6.4.2017
			'btnRenameAll' : 'Đổi tên (Tất cả)', // from v2.1.24 added 6.4.2017
			'btnPrevious' : 'Trước đó ($ 1 / $ 2)', // from v2.1.24 added 11.5.2017
			'btnNext'     : 'Tiếp theo ($ 1 / $ 2)', // from v2.1.24 added 11.5.2017
			'btnSaveAs'   : 'Lưu thành', // from v2.1.25 added 24.5.2017

			/******************************** notifications ********************************/
			'ntfopen'     : 'Mở thư mục',
			'ntffile'     : 'Mở tập tin',
			'ntfreload'   : 'Nạp lại nội dung thư mục',
			'ntfmkdir'    : 'Tạo thư mục',
			'ntfmkfile'   : 'Tạo tập tin',
			'ntfrm'       : 'Xóa tập tin',
			'ntfcopy'     : 'Sao chép tập tin',
			'ntfmove'     : 'Di chuyển tập tin',
			'ntfprepare'  : 'Chuẩn bị để sao chép các tập tin',
			'ntfrename'   : 'Đổi tên tập tin',
			'ntfupload'   : 'Tải tập tin lên',
			'ntfdownload' : 'Tải tập tin',
			'ntfsave'     : 'Lưu tập tin',
			'ntfarchive'  : 'Tạo tập tin nén',
			'ntfextract'  : 'Giải nén tập tin',
			'ntfsearch'   : 'Tìm kiếm tập tin',
			'ntfresize'   : 'Thay đổi kích thước hình ảnh',
			'ntfsmth'     : 'Doing something >_<',
			'ntfloadimg'  : 'Đang tải hình ảnh',
			'ntfnetmount' : 'Gắn kết khối lượng mạng', // added 18.04.2012
			'ntfnetunmount': 'Ngắt kết nối âm lượng mạng', // from v2.1 added 30.04.2012
			'ntfdim'      : 'Nhận kích thước hình ảnh', // added 20.05.2013
			'ntfreaddir'  : 'Đọc thông tin thư mục', // from v2.1 added 01.07.2013
			'ntfurl'      : 'Lấy URL của liên kết', // from v2.1 added 11.03.2014
			'ntfchmod'    : 'Thay đổi chế độ tệp', // from v2.1 added 20.6.2015
			'ntfpreupload': 'Xác minh tên tệp tải lên', // from v2.1 added 31.11.2015
			'ntfzipdl'    : 'Tạo một tệp để tải xuống', // from v2.1.7 added 23.1.2016
			'ntfparents'  : 'Nhận thông tin đường dẫn', // from v2.1.17 added 2.11.2016
			'ntfchunkmerge': 'Xử lý tệp đã tải lên', // from v2.1.17 added 2.11.2016
			'ntftrash'    : 'Ném vào thùng rác', // from v2.1.24 added 2.5.2017
			'ntfrestore'  : 'Đang khôi phục từ thùng rác', // from v2.1.24 added 3.5.2017
			'ntfchkdir'   : 'Kiểm tra thư mục đích', // from v2.1.24 added 3.5.2017
			'ntfundo'     : 'Hoàn tác hoạt động trước đó', // from v2.1.27 added 31.07.2017
			'ntfredo'     : 'Làm lại hoàn tác trước đó', // from v2.1.27 added 31.07.2017
			'ntfchkcontent' : 'Kiểm tra nội dung', // from v2.1.41 added 3.8.2018

			/*********************************** volumes *********************************/
			'volume_Trash' : 'Rác', //from v2.1.24 added 29.4.2017

			/************************************ dates **********************************/
			'dateUnknown' : 'Chưa biết',
			'Today'       : 'Hôm nay',
			'Yesterday'   : 'Hôm qua',
			'msJan'       : 'Tháng 1',
			'msFeb'       : 'Tháng 2',
			'msMar'       : 'Tháng 3',
			'msApr'       : 'Tháng 4',
			'msMay'       : 'Tháng 5',
			'msJun'       : 'Tháng 6',
			'msJul'       : 'Tháng 7',
			'msAug'       : 'Tháng 8',
			'msSep'       : 'Tháng 9',
			'msOct'       : 'Tháng 10',
			'msNov'       : 'Tháng 11',
			'msDec'       : 'Tháng 12',
			'January'     : 'Tháng 1',
			'February'    : 'Tháng 2',
			'March'       : 'Tháng 3',
			'April'       : 'Tháng 4',
			'May'         : 'Tháng 5',
			'June'        : 'Tháng 6',
			'July'        : 'Tháng 7',
			'August'      : 'Tháng 8',
			'September'   : 'Tháng 9',
			'October'     : 'Tháng 10',
			'November'    : 'Tháng 11',
			'December'    : 'Tháng 12',
			'Sunday'      : 'Chủ nhật',
			'Monday'      : 'Thứ 2',
			'Tuesday'     : 'Thứ 3',
			'Wednesday'   : 'Thứ 4',
			'Thursday'    : 'Thứ 5',
			'Friday'      : 'Thứ 6',
			'Saturday'    : 'Thứ 7',
			'Sun'         : 'Chủ nhật',
			'Mon'         : 'Thứ 2',
			'Tue'         : 'Thứ 3',
			'Wed'         : 'Thứ 4',
			'Thu'         : 'Thứ 5',
			'Fri'         : 'Thứ 6',
			'Sat'         : 'Thứ 7',

			/******************************** sort variants ********************************/
			'sortname'          : 'theo tên',
			'sortkind'          : 'theo loại',
			'sortsize'          : 'theo kích cỡ',
			'sortdate'          : 'theo ngày',
			'sortFoldersFirst'  : 'Thư mục đầu tiên',
			'sortperm'          : 'theo quyền hạn', // from v2.1.13 added 13.06.2016
			'sortmode'          : 'theo chế độ',       // from v2.1.13 added 13.06.2016
			'sortowner'         : 'theo người tạo',      // from v2.1.13 added 13.06.2016
			'sortgroup'         : 'theo nhóm',      // from v2.1.13 added 13.06.2016
			'sortAlsoTreeview'  : 'Ngoài ra Treeview',  // from v2.1.15 added 01.08.2016

			/********************************** new items **********************************/
			'untitled file.txt' : 'Tập tin mới.txt', // added 10.11.2015
			'untitled folder'   : 'Thư mục mới',   // added 10.11.2015
			'Archive'           : 'NewArchive',  // from v2.1 added 10.11.2015
			'untitled file'     : 'Tập tin mới.$1',  // from v2.1.41 added 6.8.2018
			'extentionfile'     : '$ 1: Tệp',    // from v2.1.41 added 6.8.2018
			'extentiontype'     : '$1: $2',      // from v2.1.43 added 17.10.2018

			/********************************** messages **********************************/
			'confirmReq'      : 'Yêu cầu xác nhận',
			'confirmRm'       : 'Bạn có chắc chắn muốn xóa vĩnh viễn các mục?<br/>  Điều này không thể được hoàn tác!',
			'confirmRepl'     : 'Thay tập tin cũ bằng tập tin mới? (Nếu nó chứa các thư mục, nó sẽ được hợp nhất. Để sao lưu và thay thế, chọn Sao lưu.)',
			'confirmRest'     : 'Thay thế mục hiện có bằng một mục trong thùng rác?', // fromv2.1.24 added 5.5.2017
			'confirmConvUTF8' : 'Không có trong UTF-8 <br/> Chuyển đổi thành UTF-8? <br/> Nội dung trở thành UTF-8 bằng cách lưu sau khi chuyển đổi.', // from v2.1 added 08.04.2014
			'confirmNonUTF8'  : 'Không thể phát hiện mã hóa ký tự của tệp này. Nó cần tạm thời chuyển đổi thành UTF-8 để chỉnh sửa. <br/> Vui lòng chọn mã hóa ký tự của tệp này.', // from v2.1.19 added 28.11.2016
			'confirmNotSave'  : 'Nó đã được sửa đổi. <br/> Sẽ mất công nếu bạn không lưu các thay đổi.', // from v2.1 added 15.7.2015
			'confirmTrash'    : 'Bạn có chắc chắn muốn chuyển các mục vào thùng rác?', //from v2.1.24 added 29.4.2017
			'confirmMove'     : 'Bạn có chắc chắn muốn chuyển các mục vào "$1"?', //from v2.1.50 added 27.7.2019
			'apllyAll'        : 'Áp dụng cho tất cả',
			'name'            : 'Tên',
			'size'            : 'Kích cỡ',
			'perms'           : 'Quyền',
			'modify'          : 'Sửa đổi',
			'kind'            : 'Loại',
			'read'            : 'đọc',
			'write'           : 'viết',
			'noaccess'        : 'không truy cập',
			'and'             : 'và',
			'unknown'         : 'không xác định',
			'selectall'       : 'Chọn tất cả các mục',
			'selectfiles'     : 'Chọn các mục',
			'selectffile'     : 'Chọn mục đầu tiên',
			'selectlfile'     : 'Chọn mục cuối cùng',
			'viewlist'        : 'Hiển thị danh sách',
			'viewicons'       : 'Hiển thị biểu tượng',
			'viewSmall'       : 'Biểu tượng nhỏ', // from v2.1.39 added 22.5.2018
			'viewMedium'      : 'Biểu tượng vừa', // from v2.1.39 added 22.5.2018
			'viewLarge'       : 'Biểu tượng lớn', // from v2.1.39 added 22.5.2018
			'viewExtraLarge'  : 'Biểu tượng cực lớn', // from v2.1.39 added 22.5.2018
			'places'          : 'Nơi',
			'calc'            : 'Tính toán',
			'path'            : 'Đường dẫn',
			'aliasfor'        : 'Bí danh cho',
			'locked'          : 'Đã khóa',
			'dim'             : 'Kích thước',
			'files'           : 'Tệp',
			'folders'         : 'Thư mục',
			'items'           : 'vật phẩm',
			'yes'             : 'Vâng',
			'no'              : 'không',
			'link'            : 'Liên kết',
			'searcresult'     : 'Kết quả tìm kiếm',
			'selected'        : 'mục đã chọn',
			'about'           : 'Về',
			'shortcuts'       : 'Lối tắt',
			'help'            : 'Giúp đỡ',
			'webfm'           : 'Trình quản lý tệp web',
			'ver'             : 'Phiên bản',
			'protocolver'     : 'phiên bản protocol',
			'homepage'        : 'Trang chủ dự án',
			'docs'            : 'Tài liệu',
			'github'          : 'Theo dõi chúng tôi trên GitHub',
			'twitter'         : 'Theo dõi chúng tôi trên Twitter',
			'facebook'        : 'Theo dõi chúng tôi trên Facebook',
			'team'            : 'Đội ngũ',
			'chiefdev'        : 'Trùm sò',
			'developer'       : 'người phát triển',
			'contributor'     : 'người đóng góp',
			'maintainer'      : 'người bảo trì',
			'translator'      : 'người dịch',
			'icons'           : 'Biểu tượng',
			'dontforget'      : 'và đừng quên lấy khăn tắm của bạn',
			'shortcutsof'     : 'Các phím tắt bị tắt',
			'dropFiles'       : 'Thả tệp vào đây',
			'or'              : 'hoặc',
			'selectForUpload' : 'Chọn tệp',
			'moveFiles'       : 'Di chuyển các mục',
			'copyFiles'       : 'Sao chép các mục',
			'restoreFiles'    : 'Khôi mục các mục', // from v2.1.24 added 5.5.2017
			'rmFromPlaces'    : 'Xóa khỏi địa điểm',
			'aspectRatio'     : 'Tỉ lệ khung hình',
			'scale'           : 'Tỉ lệ',
			'width'           : 'Rộng',
			'height'          : 'Cao',
			'resize'          : 'Thay đổi kích cỡ',
			'crop'            : 'Cắt',
			'rotate'          : 'Xoay',
			'rotate-cw'       : 'Xoay 90 độ CW',
			'rotate-ccw'      : 'Xoay 90 độ CCW',
			'degree'          : '°',
			'netMountDialogTitle' : 'Gắn kết khối lượng mạng', // added 18.04.2012
			'protocol'            : 'Giao thức', // added 18.04.2012
			'host'                : 'Chủ nhà', // added 18.04.2012
			'port'                : 'Hải cảng', // added 18.04.2012
			'user'                : 'Người sử dụng', // added 18.04.2012
			'pass'                : 'Mật khẩu', // added 18.04.2012
			'confirmUnmount'      : 'Bạn có ngắt kết nối $ 1 không?',  // from v2.1 added 30.04.2012
			'dropFilesBrowser': 'Thả hoặc dán tệp từ trình duyệt', // from v2.1 added 30.05.2012
			'dropPasteFiles'  : 'Thả tệp, dán URL hoặc hình ảnh (khay nhớ tạm) vào đây', // from v2.1 added 07.04.2014
			'encoding'        : 'Mã hóa', // from v2.1 added 19.12.2014
			'locale'          : 'Địa phương',   // from v2.1 added 19.12.2014
			'searchTarget'    : 'Mục tiêu: $1',                // from v2.1 added 22.5.2015
			'searchMime'      : 'Tìm kiếm theo kiểu tệp (MIME)', // from v2.1 added 22.5.2015
			'owner'           : 'Chủ sở hữu', // from v2.1 added 20.6.2015
			'group'           : 'Nhóm', // from v2.1 added 20.6.2015
			'other'           : 'Khác', // from v2.1 added 20.6.2015
			'execute'         : 'Thực thi', // from v2.1 added 20.6.2015
			'perm'            : 'Quyền', // from v2.1 added 20.6.2015
			'mode'            : 'Chế độ', // from v2.1 added 20.6.2015
			'emptyFolder'     : 'Thư mục trống', // from v2.1.6 added 30.12.2015
			'emptyFolderDrop' : 'Thư mục trống\\A Kéo thả vào đây để thêm các mục', // from v2.1.6 added 30.12.2015
			'emptyFolderLTap' : 'Thư mục trống\\A Nhấn giữ để thêm các mục', // from v2.1.6 added 30.12.2015
			'quality'         : 'Chất lượng', // from v2.1.6 added 5.1.2016
			'autoSync'        : 'Tự động động bộ',  // from v2.1.6 added 10.1.2016
			'moveUp'          : 'Di chuyển lên',  // from v2.1.6 added 18.1.2016
			'getLink'         : 'Lấy liên kết URL', // from v2.1.7 added 9.2.2016
			'selectedItems'   : 'Các mục đã chọn ($1)', // from v2.1.7 added 2.19.2016
			'folderId'        : 'ID thư mục', // from v2.1.10 added 3.25.2016
			'offlineAccess'   : 'Cho phép truy cập ngoại tuyến', // from v2.1.10 added 3.25.2016
			'reAuth'          : 'Xác thực lại', // from v2.1.10 added 3.25.2016
			'nowLoading'      : 'Đang tải...', // from v2.1.12 added 4.26.2016
			'openMulti'       : 'Mở nhiều tập tin', // from v2.1.12 added 5.14.2016
			'openMultiConfirm': 'Bạn đang cố mở các tệp $ 1. Bạn có chắc chắn muốn mở trong trình duyệt không?', // from v2.1.12 added 5.14.2016
			'emptySearch'     : 'Kết quả tìm kiếm trống trong mục tiêu tìm kiếm.', // from v2.1.12 added 5.16.2016
			'editingFile'     : 'Nó là một tập tin đang chỉnh sửa.', // from v2.1.13 added 6.3.2016
			'hasSelected'     : 'Bạn đã chọn $ 1 mục.', // from v2.1.13 added 6.3.2016
			'hasClipboard'    : 'Bạn có $ 1 mục trong khay nhớ tạm.', // from v2.1.13 added 6.3.2016
			'incSearchOnly'   : 'Tìm kiếm gia tăng chỉ từ hiển thị hiện tại.', // from v2.1.13 added 6.30.2016
			'reinstate'       : 'Phục hồi', // from v2.1.15 added 3.8.2016
			'complete'        : '$1 hoàn thành', // from v2.1.15 added 21.8.2016
			'contextmenu'     : 'Trình đơn ngữ cảnh', // from v2.1.15 added 9.9.2016
			'pageTurning'     : 'Chuyển trang', // from v2.1.15 added 10.9.2016
			'volumeRoots'     : 'Khối lượng rễ', // from v2.1.16 added 16.9.2016
			'reset'           : 'Đặt lại', // from v2.1.16 added 1.10.2016
			'bgcolor'         : 'Màu nền', // from v2.1.16 added 1.10.2016
			'colorPicker'     : 'Chọn màu', // from v2.1.16 added 1.10.2016
			'8pxgrid'         : 'Lưới 8px', // from v2.1.16 added 4.10.2016
			'enabled'         : 'Đã bật', // from v2.1.16 added 4.10.2016
			'disabled'        : 'Đã tắt', // from v2.1.16 added 4.10.2016
			'emptyIncSearch'  : 'Kết quả tìm kiếm trống trong chế độ xem hiện tại. \\ APress [Enter] để mở rộng mục tiêu tìm kiếm.', // from v2.1.16 added 5.10.2016
			'emptyLetSearch'  : 'Kết quả tìm kiếm thư đầu tiên là trống trong chế độ xem hiện tại.', // from v2.1.23 added 24.3.2017
			'textLabel'       : 'Nhãn văn bản', // from v2.1.17 added 13.10.2016
			'minsLeft'        : 'Còn $ 1 phút', // from v2.1.17 added 13.11.2016
			'openAsEncoding'  : 'Mở lại với mã hóa đã chọn', // from v2.1.19 added 2.12.2016
			'saveAsEncoding'  : 'Lưu với mã hóa đã chọn', // from v2.1.19 added 2.12.2016
			'selectFolder'    : 'Chọn thư mục', // from v2.1.20 added 13.12.2016
			'firstLetterSearch': 'Tìm kiếm chữ cái đầu tiên', // from v2.1.23 added 24.3.2017
			'presets'         : 'Đặt trước', // from v2.1.25 added 26.5.2017
			'tooManyToTrash'  : 'Có quá nhiều mục vì vậy không thể cho vào thùng rác.', // from v2.1.25 added 9.6.2017
			'TextArea'        : 'TextArea', // from v2.1.25 added 14.6.2017
			'folderToEmpty'   : 'Làm trống thư mục "$ 1".', // from v2.1.25 added 22.6.2017
			'filderIsEmpty'   : 'Không có mục nào trong thư mục "$ 1".', // from v2.1.25 added 22.6.2017
			'preference'      : 'Sự ưa thích', // from v2.1.26 added 28.6.2017
			'language'        : 'Ngôn ngữ', // from v2.1.26 added 28.6.2017
			'clearBrowserData': 'Khởi tạo các cài đặt được lưu trong trình duyệt này', // from v2.1.26 added 28.6.2017
			'toolbarPref'     : 'Cài đặt thanh công cụ', // from v2.1.27 added 2.8.2017
			'charsLeft'       : '... $ 1 ký tự còn lại.',  // from v2.1.29 added 30.8.2017
			'linesLeft'       : '... $ 1 dòng còn lại.',  // from v2.1.52 added 16.1.2020
			'sum'             : 'Tổng', // from v2.1.29 added 28.9.2017
			'roughFileSize'   : 'Kích thước tệp thô', // from v2.1.30 added 2.11.2017
			'autoFocusDialog' : 'Tập trung vào thành phần của hộp thoại bằng cách di chuột qua',  // from v2.1.30 added 2.11.2017
			'select'          : 'Lựa chọn', // from v2.1.30 added 23.11.2017
			'selectAction'    : 'Hành động khi chọn tệp', // from v2.1.30 added 23.11.2017
			'useStoredEditor' : 'Mở bằng trình chỉnh sửa được sử dụng lần trước', // from v2.1.30 added 23.11.2017
			'selectinvert'    : 'Lựa chọn đối nghịch', // from v2.1.30 added 25.11.2017
			'renameMultiple'  : 'Bạn có chắc chắn muốn đổi tên $ 1 các mục đã chọn như $ 2 không? <br/> Không thể hoàn tác thao tác này!', // from v2.1.31 added 4.12.2017
			'batchRename'     : 'Đổi tên hàng loạt', // from v2.1.31 added 8.12.2017
			'plusNumber'      : '+ Số', // from v2.1.31 added 8.12.2017
			'asPrefix'        : 'Thêm tiền tố', // from v2.1.31 added 8.12.2017
			'asSuffix'        : 'Thêm hậu tố', // from v2.1.31 added 8.12.2017
			'changeExtention' : 'Thay đổi phần mở rộng', // from v2.1.31 added 8.12.2017
			'columnPref'      : 'Cài đặt cột (Chế độ xem danh sách)', // from v2.1.32 added 6.2.2018
			'reflectOnImmediate' : 'Tất cả các thay đổi sẽ phản ánh ngay lập tức vào kho lưu trữ.', // from v2.1.33 added 2.3.2018
			'reflectOnUnmount'   : 'Mọi thay đổi sẽ không phản ánh cho đến khi hủy gắn ổ đĩa này.', // from v2.1.33 added 2.3.2018
			'unmountChildren' : '(Các) tập sau được gắn trên tập này cũng đã được ngắt kết nối. Bạn có chắc chắn để ngắt kết nối nó không?', // from v2.1.33 added 5.3.2018
			'selectionInfo'   : 'Thông tin lựa chọn', // from v2.1.33 added 7.3.2018
			'hashChecker'     : 'Các thuật toán để hiển thị hàm băm của tệp', // from v2.1.33 added 10.3.2018
			'infoItems'       : 'Mục thông tin (Bảng thông tin lựa chọn)', // from v2.1.38 added 28.3.2018
			'pressAgainToExit': 'Nhấn một lần nữa để thoát.', // from v2.1.38 added 1.4.2018
			'toolbar'         : 'Thanh công cụ', // from v2.1.38 added 4.4.2018
			'workspace'       : 'Không gian làm việc', // from v2.1.38 added 4.4.2018
			'dialog'          : 'Hộp thoại', // from v2.1.38 added 4.4.2018
			'all'             : 'Tất cả', // from v2.1.38 added 4.4.2018
			'iconSize'        : 'Kích thước biểu tượng (Chế độ xem biểu tượng)', // from v2.1.39 added 7.5.2018
			'editorMaximized' : 'Mở cửa sổ trình chỉnh sửa tối đa', // from v2.1.40 added 30.6.2018
			'editorConvNoApi' : 'Bởi vì chuyển đổi bằng API hiện không khả dụng, vui lòng chuyển đổi trên trang web.', //from v2.1.40 added 8.7.2018
			'editorConvNeedUpload' : 'Sau khi chuyển đổi, bạn phải tải lên với URL mục hoặc tệp đã tải xuống để lưu tệp đã chuyển đổi.', //from v2.1.40 added 8.7.2018
			'convertOn'       : 'Chuyển đổi trên trang web của $ 1', // from v2.1.40 added 10.7.2018
			'integrations'    : 'Tích hợp', // from v2.1.40 added 11.7.2018
			'integrationWith' : 'ElFinder này được tích hợp các dịch vụ bên ngoài sau. Vui lòng kiểm tra các điều khoản sử dụng, chính sách bảo mật, v.v. trước khi sử dụng.', // from v2.1.40 added 11.7.2018
			'showHidden'      : 'Hiển thị các mục ẩn', // from v2.1.41 added 24.7.2018
			'hideHidden'      : 'Ẩn các mục ẩn', // from v2.1.41 added 24.7.2018
			'toggleHidden'    : 'Hiển thị / Ẩn các mục ẩn', // from v2.1.41 added 24.7.2018
			'makefileTypes'   : 'Loại tệp để bật với "Tệp mới"', // from v2.1.41 added 7.8.2018
			'typeOfTextfile'  : 'Loại tệp văn bản', // from v2.1.41 added 7.8.2018
			'add'             : 'Thêm vào', // from v2.1.41 added 7.8.2018
			'theme'           : 'Chủ đề', // from v2.1.43 added 19.10.2018
			'default'         : 'Mặc định', // from v2.1.43 added 19.10.2018
			'description'     : 'Sự miêu tả', // from v2.1.43 added 19.10.2018
			'website'         : 'Trang mạng', // from v2.1.43 added 19.10.2018
			'author'          : 'Tác giả', // from v2.1.43 added 19.10.2018
			'email'           : 'E-mail', // from v2.1.43 added 19.10.2018
			'license'         : 'Giấy phép', // from v2.1.43 added 19.10.2018
			'exportToSave'    : 'Không thể lưu mục này. Để tránh mất các chỉnh sửa, bạn cần xuất sang PC của mình.', // from v2.1.44 added 1.12.2018
			'dblclickToSelect': 'Nhấp đúp vào tệp để chọn nó.', // from v2.1.47 added 22.1.2019
			'useFullscreen'   : 'Sử dụng chế độ toàn màn hình', // from v2.1.47 added 19.2.2019

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'không xác định',
			'kindRoot'        : 'Khối lượng gốc', // from v2.1.16 added 16.10.2016
			'kindFolder'      : 'Thư mục',
			'kindSelects'     : 'Lựa chọn', // from v2.1.29 added 29.8.2017
			'kindAlias'       : 'Bí danh',
			'kindAliasBroken' : 'Bí danh bị hỏng',
			// applications
			'kindApp'         : 'Ứng dụng',
			'kindPostscript'  : 'Tài liệu tái bút',
			'kindMsOffice'    : 'Tài liệu Microsoft Office',
			'kindMsWord'      : 'Tài liệu Microsoft Word',
			'kindMsExcel'     : 'Tài liệu Microsoft Excel',
			'kindMsPP'        : 'Bản trình bày Microsoft Powerpoint',
			'kindOO'          : 'Mở tài liệu Office',
			'kindAppFlash'    : 'Ứng dụng flash',
			'kindPDF'         : 'Định dạng tài liệu di động (PDF)',
			'kindTorrent'     : 'Tệp bittorrent',
			'kind7z'          : 'Kho lưu trữ 7z',
			'kindTAR'         : 'TAR lưu trữ',
			'kindGZIP'        : 'Kho lưu trữ GZIP',
			'kindBZIP'        : 'Kho lưu trữ BZIP',
			'kindXZ'          : 'Kho lưu trữ XZ',
			'kindZIP'         : 'Kho lưu trữ ZIP',
			'kindRAR'         : 'Kho lưu trữ RAR',
			'kindJAR'         : 'Tệp Java JAR',
			'kindTTF'         : 'Phông chữ True Type',
			'kindOTF'         : 'Mở loại phông chữ',
			'kindRPM'         : 'Gói RPM',
			// texts
			'kindText'        : 'Tai liệu kiểm tra',
			'kindTextPlain'   : 'Văn bản thô',
			'kindPHP'         : 'Nguồn PHP',
			'kindCSS'         : 'Bảng kiểu xếp tầng',
			'kindHTML'        : 'Tài liệu HTML',
			'kindJS'          : 'Nguồn Javascript',
			'kindRTF'         : 'Định dạng văn bản phong phú',
			'kindC'           : 'Nguồn C',
			'kindCHeader'     : 'Nguồn tiêu đề C',
			'kindCPP'         : 'Nguồn C ++',
			'kindCPPHeader'   : 'Nguồn tiêu đề C ++',
			'kindShell'       : 'Tập lệnh shell Unix',
			'kindPython'      : 'Nguồn Python',
			'kindJava'        : 'Nguồn Java',
			'kindRuby'        : 'Nguồn Ruby',
			'kindPerl'        : 'Tập lệnh Perl',
			'kindSQL'         : 'Nguồn SQL',
			'kindXML'         : 'Tài liệu XML',
			'kindAWK'         : 'Nguồn AWK',
			'kindCSV'         : 'Các giá trị được phân tách bằng dấu phẩy',
			'kindDOCBOOK'     : 'Tài liệu XML của Docbook',
			'kindMarkdown'    : 'Văn bản đánh dấu', // added 20.7.2015
			// images
			'kindImage'       : 'Hình ảnh',
			'kindBMP'         : 'Hình ảnh BMP',
			'kindJPEG'        : 'Hình ảnh JPEG',
			'kindGIF'         : 'Ảnh GIF',
			'kindPNG'         : 'Hình ảnh PNG',
			'kindTIFF'        : 'Hình ảnh TIFF',
			'kindTGA'         : 'Hình ảnh TGA',
			'kindPSD'         : 'Hình ảnh Adobe Photoshop',
			'kindXBITMAP'     : 'Hình ảnh bitmap X',
			'kindPXM'         : 'Hình ảnh Pixelmator',
			// media
			'kindAudio'       : 'Phương tiện âm thanh',
			'kindAudioMPEG'   : 'Âm thanh MPEG',
			'kindAudioMPEG4'  : 'Âm thanh MPEG-4',
			'kindAudioMIDI'   : 'Âm thanh MIDI',
			'kindAudioOGG'    : 'Âm thanh Ogg Vorbis',
			'kindAudioWAV'    : 'Âm thanh WAV',
			'AudioPlaylist'   : 'Danh sách nhạc MP3',
			'kindVideo'       : 'Phương tiện video',
			'kindVideoDV'     : 'Phim DV',
			'kindVideoMPEG'   : 'Phim MPEG',
			'kindVideoMPEG4'  : 'Phim MPEG-4',
			'kindVideoAVI'    : 'Phim AVI',
			'kindVideoMOV'    : 'Phim thời gian nhanh',
			'kindVideoWM'     : 'Phim Windows Media',
			'kindVideoFlash'  : 'Phim flash',
			'kindVideoMKV'    : 'Phim matroska',
			'kindVideoOGG'    : 'Phim ogg'
		}
	};
}));

