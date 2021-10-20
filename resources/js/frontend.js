import '/resources/scss/frontend.scss';

import {init as initCommon} from '/resources/js/common.js';

class Frontend {
	init() {
		initCommon();
	}
}

(function() {
	const frontend = new Frontend();
	frontend.init();	
})();
