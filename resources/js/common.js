import {init as initButtonLoginComponent} from '/app/Components/ButtonLoginComponent.js';

class Common {
	init() {
		initButtonLoginComponent();
	}
}

export function init() {
	const common = new Common();
	common.init();
}
