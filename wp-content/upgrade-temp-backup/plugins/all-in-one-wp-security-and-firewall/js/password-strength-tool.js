(function($) {
	$.fn.extend({
		pwdstr: function(el) {
			return this.each(function() {
				$(this).keyup(function() {
					$(el).html(getTime($(this).val()));
				});
					
				function getTime(str) {
					var chars = 0;
					var rate = 2800000000;

					if ((/[a-z]/).test(str)) chars += 26;
					if ((/[A-Z]/).test(str)) chars += 26;
					if ((/[0-9]/).test(str)) chars += 10;
					if ((/[^a-zA-Z0-9]/).test(str)) chars += 32;

					var pos = Math.pow(chars,str.length);
					var s = pos/rate;
					var decimalYears = s/(3600*24*365);
					var years = Math.floor(decimalYears);

					var decimalMonths = (decimalYears-years)*12;
					var months = Math.floor(decimalMonths);

					var decimalDays = (decimalMonths-months)*30;
					var days = Math.floor(decimalDays);

					var decimalHours = (decimalDays-days)*24;
					var hours = Math.floor(decimalHours);

					var decimalMinutes = (decimalHours-hours)*60;
					var minutes = Math.floor(decimalMinutes);

					var decimalSeconds = (decimalMinutes-minutes)*60;
					var seconds = Math.floor(decimalSeconds);

					var time = [];

					if (years > 0) {
						time.push(years + " " + aios_pwtool_trans.years + ", ");
					}
					if (months > 0) {
						time.push(months + " " + aios_pwtool_trans.months + ", ");
					}
					if (days > 0) {
						time.push(days + " " + aios_pwtool_trans.days + ", ");
					}
					if (hours > 0) {
						time.push(hours + " " + aios_pwtool_trans.hours + ", ");
					}
					if (minutes > 0) {
						time.push(minutes + " " + aios_pwtool_trans.minutes + ", ");
					}
					if (seconds > 0) {
						time.push(seconds + " " + aios_pwtool_trans.seconds + ", ");
					}

					if (time.length <= 0)
							time = "" + aios_pwtool_trans.less_than_one_second + ", ";
					else if (time.length == 1)
							time = time[0];
					else time = time[0] + time[1];
					
					var field = $('#aiowps_password_test');
					if (s <= 1 || !field.val()) {
						//Time to crack < 1 sec
						complexity = 0;
					} else if (s > 1 && s <= 43200) {
						//1 sec < Time to crack < 12hrs
						complexity = 1;
					} else if (s > 43200 && s <= 86400) {
						//12 hrs < Time to crack < 1day
						complexity = 2;
					} else if (s > 86400 && s <= 604800) {
						//1 day < Time to crack < 1wk
						complexity = 3;
					} else if (s > 604800 && s <= 2678400) {
						//1wk < Time to crack < 1mth
						complexity = 4;
					} else if (s > 2678400 && s <= 15552000) {
						//1mth < Time to crack < 6mths
						complexity = 5;
					} else if (s > 31536000 && s <= 31536000) {
						//6mths < Time to crack < 1yrs
						complexity = 6;
					} else if (s > 31536000 && s <= 315360000) {
						//1yrs < Time to crack < 10yrs
						complexity = 7;
					} else if (s > 315360000 && s <= 3153600000) {
						//10yrs < Time to crack < 100yrs
						complexity = 8;
					} else if (s > 3153600000 && s <= 31536000000) {
						//100yrs < Time to crack < 1000yrs
						complexity = 9;
					} else if (s > 31536000000) {
						//1000yrs < Time to crack
						complexity = 10;
					}
					// Rotate the arrow
					var meterFill = $('#aios_meter_fill');
					if (str.length === 0) {
						meterFill.css('width', '0').css('background-color', 'transparent');
					} else if (complexity < 3) {
						meterFill.css('width', (complexity * 10) + '%').css('background-color', 'red');
					} else if (complexity < 6) {
						meterFill.css('width', (complexity * 10) + '%').css('background-color', 'orange');
					} else {
						meterFill.css('width', (complexity * 10) + '%').css('background-color', 'green');
					}
					
					return time.substring(0,time.length-2);
				}
			});
		}
	});
	$(document).ready(function() {
		$('#aiowps_password_test').pwdstr('#aiowps_password_crack_time_calculation');
	});
})(jQuery);

