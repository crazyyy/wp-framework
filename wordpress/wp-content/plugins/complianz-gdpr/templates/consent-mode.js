window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}

gtag('consent', 'default', {
	'ad_storage': 'denied',
	'analytics_storage': '{default_statistics_consent}'
});

gtag( 'js', new Date());
gtag( 'config', '{UA_code}' );
{googleads_id}
gtag( 'set', 'ads_data_redaction', {ads_data_redaction});

document.addEventListener("cmplzEnableScripts", function (e) {
	var consentedCategory = e.detail;
	if ( consentedCategory === 'statistics' ) {
		gtag('consent', 'update', {
			'analytics_storage': 'granted'
		});
	}
	if ( consentedCategory === 'marketing' ) {
		gtag('consent', 'update', {
			'ad_storage': 'granted',
		});
	}
});

document.addEventListener("cmplzRevoke", function (e) {
	gtag('consent', 'update', {
		'analytics_storage': 'denied',
		'ad_storage': 'denied',
	});
});
