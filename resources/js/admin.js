import '/resources/scss/admin.scss';
import {init as initTokenpassSettingsPage} from '/resources/js/pages/admin/settings.js';

class Admin {
	init() {
		initTokenpassSettingsPage();
	}
}

const admin = new Admin();
admin.init();
