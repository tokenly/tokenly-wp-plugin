import '/resources/scss/admin.scss';
import {init as initTokenpassSettingsPage} from '/resources/js/pages/admin/settings.js';

class Admin {
	init() {
		initTokenpassSettingsPage();
		this.registerRedirects();
	}

	registerRedirects() {
		document.addEventListener('DOMContentLoaded', () => {
			if ( adminRedirects) {
				adminRedirects.forEach((redirect) => {
					const element = document.querySelector(`[href='${redirect.from}']`);
					if (element) {
						element.href = redirect.to;
						element.target = '_blank';
					}
				});
			}
		})

	}
}

const admin = new Admin();
admin.init();