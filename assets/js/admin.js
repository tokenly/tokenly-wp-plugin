import '/assets/scss/admin.scss';
import {init as initTokenpassSettingsPage} from '/app/Admin/Tokenpass/TokenpassSettingsPage';

class Admin {
	init() {
		initTokenpassSettingsPage();
	}
}

const admin = new Admin();
admin.init();
