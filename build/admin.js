/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./app/Admin/Tokenpass/TokenpassSettingsPage.js":
/*!******************************************************!*\
  !*** ./app/Admin/Tokenpass/TokenpassSettingsPage.js ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "init": function() { return /* binding */ init; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const {
  __
} = wp.i18n;
const {
  Button,
  TextControl,
  Placeholder,
  Spinner,
  Panel,
  PanelBody,
  PanelRow
} = wp.components;
const {
  render,
  Component,
  Fragment
} = wp.element;

class TokenpassSettingsPageComponent extends Component {
  constructor() {
    super(...arguments);
    this.updateSettings = this.updateSettings.bind(this);
    this.state = {
      isAPILoaded: false,
      isAPISaving: false,
      clientId: null,
      clientSecret: null
    };
  }

  componentDidMount() {
    wp.api.loadPromise.then(() => {
      if (false === this.state.isAPILoaded) {
        this.getSettings().then(result => {
          this.setState({
            isAPILoaded: true
          });
        });
      }
    });
  }

  getSettings() {
    return new Promise((resolve, reject) => {
      const params = {
        method: 'GET',
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
          'X-WP-Nonce': wpApiSettings.nonce
        }
      };
      const url = '/wp-json/tokenly/v1/settings';
      fetch(url, params).then(response => response.json()).then(data => {
        console.log(data);
        this.setState({ ...((data === null || data === void 0 ? void 0 : data.client_id) && {
            clientId: data.client_id
          }),
          ...((data === null || data === void 0 ? void 0 : data.client_secret) && {
            clientSecret: data.client_secret
          })
        });
        resolve(data);
      }).catch(err => reject(err));
    });
  }

  updateSettings() {
    this.setState({
      isAPISaving: true
    });
    const params = {
      method: 'PUT',
      headers: {
        'Content-type': 'application/json; charset=UTF-8',
        'X-WP-Nonce': wpApiSettings.nonce
      },
      body: JSON.stringify({
        settings: { ...(this.state.clientId && {
            'client_id': this.state.clientId
          }),
          ...(this.state.clientSecret && {
            'client_secret': this.state.clientSecret
          })
        }
      })
    };
    const url = '/wp-json/tokenly/v1/settings';
    fetch(url, params).then(response => response.json()).then(data => {
      this.setState({
        isAPISaving: false
      });
    }).catch(err => console.log(err));
  }

  render() {
    if (!this.state.isAPILoaded) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null));
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", null, "Tokenpass Settings"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Panel, {
      header: "How to Setup"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
      class: "tk_steps"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, "1. Create App on ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: "https://tokenpass.tokenly.com/auth/apps",
      target: "_blank"
    }, "Tokenpass Developers")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, "2. Use below details to create App"))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "tk_app_details"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", null, "Register Client Application"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("b", null, "CLIENT NAME: "), " Random Input "), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("br", null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("b", null, "APP HOMEPAGE URL: "), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: appHomepageUrl,
      target: "_blank"
    }, appHomepageUrl), " "), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("br", null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("b", null, "CLIENT AUTHORIZATION REDIRECT URL: "), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: clientAuthUrl,
      target: "_blank"
    }, clientAuthUrl), " "))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, {
      className: "api-input-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
      label: "Client ID",
      value: this.state.clientId,
      onChange: value => {
        this.setState({
          clientId: value
        });
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
      label: "Client Secret",
      value: this.state.clientSecret,
      onChange: value => {
        this.setState({
          clientSecret: value
        });
      }
    })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Panel, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, {
      className: "save-button-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      isPrimary: true,
      isLarge: true,
      disabled: this.state.isAPISaving,
      onClick: () => {
        this.updateSettings();
      }
    }, __('Save settings')), this.state.isAPISaving === true && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null)))));
  }

}

function init() {
  const postBody = document.querySelector('#tokenpass-settings-page-content');
  const appContainer = document.createElement('div');
  postBody.appendChild(appContainer);
  render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TokenpassSettingsPageComponent, null), appContainer);
}

/***/ }),

/***/ "./assets/scss/admin.scss":
/*!********************************!*\
  !*** ./assets/scss/admin.scss ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!****************************!*\
  !*** ./assets/js/admin.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _assets_scss_admin_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../../../assets/scss/admin.scss */ "./assets/scss/admin.scss");
/* harmony import */ var _app_Admin_Tokenpass_TokenpassSettingsPage__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../../../app/Admin/Tokenpass/TokenpassSettingsPage */ "./app/Admin/Tokenpass/TokenpassSettingsPage.js");



class Admin {
  init() {
    (0,_app_Admin_Tokenpass_TokenpassSettingsPage__WEBPACK_IMPORTED_MODULE_1__.init)();
  }

}

const admin = new Admin();
admin.init();
}();
/******/ })()
;
//# sourceMappingURL=admin.js.map