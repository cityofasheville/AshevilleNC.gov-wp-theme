function initGoogleTranslateElement() {
	new google.translate.TranslateElement(
		{
			pageLanguage: 'en',
			layout: google.translate.TranslateElement.InlineLayout.SIMPLE
		},
		'google-translate'
	);
}
