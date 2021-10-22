import * as React from 'react';
import App from "./app";
import '/resources/scss/frontend.scss';

class FrontendApp extends App {
	constructor() {
		super();
	}
}	

(function() {
	const frontend = new FrontendApp();	
})();
