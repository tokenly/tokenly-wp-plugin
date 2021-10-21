import '/resources/scss/admin.scss';
import {init as initCommon} from '/resources/js/common.js';
import {init as initTokenpassSettingsPage} from '/resources/js/pages/admin/settings.js';
import {init as initTokenpassConnectionPage} from '/resources/js/pages/admin/connection.js';
import {init as initTokenpassWhitelistPage} from '/resources/js/pages/admin/whitelist.js';

class Admin {
	init() {
		initCommon();
		initTokenpassSettingsPage();
		initTokenpassConnectionPage();
		initTokenpassWhitelistPage();
		this.registerRedirects();
	}

	registerRedirects() {
		document.addEventListener('DOMContentLoaded', () => {
			if ( window.adminRedirects ) {
				window.adminRedirects.forEach((redirect) => {
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

(function() {
	const admin = new Admin();
	admin.init();
})();
