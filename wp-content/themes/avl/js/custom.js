function initGoogleTranslateElement() {
	new google.translate.TranslateElement(
		{
			pageLanguage: 'en',
			layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			// layout: google.translate.TranslateElement.InlineLayout.DROPDOWNONLY
			// CONSIDER USING DROPDOWNONLY ATTRIBUTE AND STYLING THE MENU ACCORDINGLY
		},
		'google-translate'
	);
}
