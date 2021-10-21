/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./app/Components/ButtonLoginComponent.js":
/*!************************************************!*\
  !*** ./app/Components/ButtonLoginComponent.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "init": function() { return /* binding */ init; }
/* harmony export */ });
class ButtonLoginComponent {
  constructor(buttonElement) {
    this.buttonElement = buttonElement;
    this.buttonElement.addEventListener('click', this.connect.bind(this));
  }

  connect() {
    return new Promise((resolve, reject) => {
      const params = {
        method: 'POST',
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
          'X-WP-Nonce': wpApiSettings.nonce
        }
      };
      const url = '/wp-json/tokenly/v1/authorize';
      fetch(url, params).then(response => response.json()).then(data => {
        var _data$url;

        console.log(data);
        const redirectUrl = (_data$url = data.url) !== null && _data$url !== void 0 ? _data$url : null;

        if (redirectUrl) {
          window.location = redirectUrl;
        }

        resolve(data);
      }).catch(err => {
        console.log(err);
        reject(err);
      });
    });
  }

}

function init() {
  const buttonElements = document.querySelectorAll('button.tokenpass-login');
  console.log(buttonElements);
  buttonElements.forEach(buttonElement => {
    buttonElement = new ButtonLoginComponent(buttonElement);
  });
}

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ App; }
/* harmony export */ });
/* harmony import */ var _app_Components_ButtonLoginComponent_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../../../app/Components/ButtonLoginComponent.js */ "./app/Components/ButtonLoginComponent.js");

class App {
  constructor() {}

}

/***/ }),

/***/ "./resources/js/pages/admin/connection.js":
/*!************************************************!*\
  !*** ./resources/js/pages/admin/connection.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ ConnectionPage; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _resources_js_pages_admin_page_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/page.js */ "./resources/js/pages/admin/page.js");



const {
  __
} = wp.i18n;
const {
  Button,
  Placeholder,
  Spinner,
  Panel,
  PanelBody,
  PanelRow
} = wp.components;
class ConnectionPage extends _resources_js_pages_admin_page_js__WEBPACK_IMPORTED_MODULE_2__["default"] {
  constructor(authService) {
    super(...arguments);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "authService", void 0);

    this.authService = authService;
    this.state = {
      isAPILoaded: false,
      isAPISaving: false,
      status: false
    };
  }

  getProps() {
    return new Promise((resolve, reject) => {
      this.authService.getStatus().then(data => {
        resolve({ ...((data === null || data === void 0 ? void 0 : data.status) && {
            status: data.status
          })
        });
      }).catch(error => {
        reject(error);
      });
    });
  }

  getStatusText() {
    if (this.state.status === true) {
      return 'Connected';
    } else {
      return 'Not connected';
    }
  }

  render() {
    if (!this.state.isAPILoaded) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Placeholder, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Spinner, null));
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("h2", null, "Connection"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Panel, {
      header: "Connection Status"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", null, "Connection status: "), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("strong", null, this.getStatusText())))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Button, {
      isPrimary: true,
      isLarge: true,
      disabled: this.state.status,
      onClick: () => {
        this.authService.connect();
      }
    }, __('Connect to Tokenpass'))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Button, {
      isPrimary: true,
      isLarge: true,
      disabled: !this.state.status,
      onClick: () => {
        this.authService.disconnect();
      }
    }, __('Disconnect from Tokenpass'))))));
  }

}

/***/ }),

/***/ "./resources/js/pages/admin/page.js":
/*!******************************************!*\
  !*** ./resources/js/pages/admin/page.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Page; }
/* harmony export */ });
const Component = wp.element.Component;
class Page extends Component {
  constructor(props) {
    super();
    this.state = {
      isAPILoaded: false,
      isAPISaving: false,
      props: props.props
    };
  }

  componentDidMount() {
    wp.api.loadPromise.then(() => {
      if (false === this.state.isAPILoaded) {
        this.getProps().then(data => {
          let newState = Object.assign({}, this.state);
          newState = Object.assign(newState, { ...data,
            isAPILoaded: true
          });
          this.setState(newState);
        });
      }
    });
  }

  getProps() {
    return new Promise((resolve, reject) => {
      resolve({});
    });
  }

  render() {//
  }

}

/***/ }),

/***/ "./resources/js/pages/admin/settings.js":
/*!**********************************************!*\
  !*** ./resources/js/pages/admin/settings.js ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ SettingsPage; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _resources_js_pages_admin_page_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/page.js */ "./resources/js/pages/admin/page.js");


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
  Component,
  Fragment
} = wp.element;
class SettingsPage extends _resources_js_pages_admin_page_js__WEBPACK_IMPORTED_MODULE_1__["default"] {
  constructor(props) {
    super(props);
    this.updateSettings = this.updateSettings.bind(this);
    this.state = Object.assign({
      clientId: null,
      clientSecret: null
    }, this.state);
  }

  getProps() {
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
    var _this$state$clientId, _this$state$clientSec;

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
        settings: { ...{
            'client_id': (_this$state$clientId = this.state.clientId) !== null && _this$state$clientId !== void 0 ? _this$state$clientId : ''
          },
          ...{
            'client_secret': (_this$state$clientSec = this.state.clientSecret) !== null && _this$state$clientSec !== void 0 ? _this$state$clientSec : ''
          }
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
      href: this.state.props.app_homepage_url,
      target: "_blank"
    }, this.state.props.app_homepage_url), " "), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("br", null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("b", null, "CLIENT AUTHORIZATION REDIRECT URL: "), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: this.state.props.client_auth_url,
      target: "_blank"
    }, this.state.props.client_auth_url), " "))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, {
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

/***/ }),

/***/ "./resources/js/pages/admin/whitelist.js":
/*!***********************************************!*\
  !*** ./resources/js/pages/admin/whitelist.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ WhitelistPage; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _resources_js_pages_admin_page_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/page.js */ "./resources/js/pages/admin/page.js");


const {
  __
} = wp.i18n;
const {
  Button,
  Placeholder,
  Spinner,
  Panel,
  PanelBody,
  PanelRow,
  ToggleControl,
  Flex,
  TextControl,
  Dashicon
} = wp.components;
const Spacer = wp.components.__experimentalSpacer;
const {
  Component,
  Fragment
} = wp.element;

class Whitelist extends Component {
  constructor(props) {
    super(...arguments);
    this.onUpdate = props.onUpdate;
    this.state = {
      whitelist: []
    };
    this.state.whitelist = Object.assign([], props.whitelist);
  }

  onAdd() {
    let newState = Object.assign({}, this.state);
    newState.whitelist[newState.whitelist.length] = {
      address: '',
      index: ''
    };
    this.setState(newState);
    this.dispatchUpdate();
  }

  onRemove(index) {
    let newState = Object.assign({}, this.state);
    delete newState.whitelist[index];
    this.setState(newState);
    this.dispatchUpdate();
  }

  dispatchUpdate() {
    this.onUpdate(this.state.whitelist);
  }

  render() {
    const listItems = this.state.whitelist.map((listItem, i) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Flex, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
      label: "Contract Address",
      value: listItem.address,
      onChange: value => {
        let newState = Object.assign({}, this.state);
        newState.whitelist[i].address = value;
        this.setState({ ...newState
        });
        this.dispatchUpdate();
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
      label: "Token Index",
      value: listItem.index,
      onChange: value => {
        let newState = Object.assign({}, this.state);
        newState.whitelist[i].index = value;
        this.setState({ ...newState
        });
        this.dispatchUpdate();
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      variant: "secondary",
      onClick: () => {
        this.onRemove(i);
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Dashicon, {
      icon: "no"
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spacer, {
      margin: 4
    })));
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", null, listItems), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      isPrimary: true,
      isLarge: true,
      onClick: () => {
        this.onAdd();
      }
    }, __('Add Token')));
  }

}

class WhitelistPage extends _resources_js_pages_admin_page_js__WEBPACK_IMPORTED_MODULE_1__["default"] {
  constructor() {
    super(...arguments);
    this.getWhitelist = this.getWhitelist.bind(this);
    this.updateWhitelist = this.updateWhitelist.bind(this);
    this.onWhitelistChange = this.onWhitelistChange.bind(this);
    this.state = {
      isAPILoaded: false,
      isAPISaving: false,
      useWhitelist: true,
      whitelist: [{
        address: '',
        index: ''
      }]
    };
  }

  getProps() {
    return new Promise((resolve, reject) => {
      const params = {
        method: 'GET',
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
          'X-WP-Nonce': wpApiSettings.nonce
        }
      };
      const url = '/wp-json/tokenly/v1/whitelist';
      fetch(url, params).then(response => response.json()).then(data => {
        var _data$use_whitelist;

        resolve({ ...{
            useWhitelist: (_data$use_whitelist = data.use_whitelist) !== null && _data$use_whitelist !== void 0 ? _data$use_whitelist : false
          },
          ...((data === null || data === void 0 ? void 0 : data.whitelist) && {
            whitelist: data.whitelist
          })
        });
        resolve(data);
      }).catch(err => reject(err));
    });
  }

  updateWhitelist() {
    console.log(this.state);
    this.setState({
      isAPISaving: true
    });
    let body = JSON.stringify({
      settings: { ...(this.state.useWhitelist && {
          'use_whitelist': this.state.useWhitelist
        }),
        ...(this.state.whitelist && {
          'whitelist': this.state.whitelist
        })
      }
    });
    const params = {
      method: 'PUT',
      headers: {
        'Content-type': 'application/json; charset=UTF-8',
        'X-WP-Nonce': wpApiSettings.nonce
      },
      body: body
    };
    const url = '/wp-json/tokenly/v1/whitelist';
    fetch(url, params).then(response => response.json()).then(data => {
      this.setState({
        isAPISaving: false
      });
    }).catch(err => console.log(err));
  }

  onWhitelistChange(newWhitelist) {
    let newState = Object.assign({}, this.state);
    newState.whitelist = Object.assign([], newWhitelist);
    newState.whitelist = newState.whitelist.filter(function (el) {
      return el != null;
    });
    this.setState({ ...newState
    });
    console.log(this.state);
  }

  render() {
    if (!this.state.isAPILoaded) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null));
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", null, "Token Whitelist"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Panel, {
      header: "Token Whitelist Settings"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Whitelist allows to control which token assets to display on the Inventory screen.")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
      label: "Use whitelist",
      help: this.state.useWhitelist ? 'Whitelist enabled.' : 'Whitelist disabled.',
      checked: this.state.useWhitelist,
      onChange: value => {
        this.setState({
          useWhitelist: value
        });
      }
    })))), this.state.useWhitelist === true && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Panel, {
      header: "Token Whitelist Editor"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Whitelist, {
      onUpdate: this.onWhitelistChange,
      whitelist: this.state.whitelist
    })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Panel, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, {
      className: "save-button-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      isPrimary: true,
      isLarge: true,
      disabled: this.state.isAPISaving,
      onClick: () => {
        this.updateWhitelist();
      }
    }, __('Save settings')), this.state.isAPISaving === true && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null)))));
  }

}

/***/ }),

/***/ "./resources/scss/admin.scss":
/*!***********************************!*\
  !*** ./resources/scss/admin.scss ***!
  \***********************************/
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

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _defineProperty; }
/* harmony export */ });
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

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
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _resources_scss_admin_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../../../resources/scss/admin.scss */ "./resources/scss/admin.scss");
/* harmony import */ var _resources_js_app_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../../../resources/js/app.js */ "./resources/js/app.js");
/* harmony import */ var _resources_js_pages_admin_settings_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/settings.js */ "./resources/js/pages/admin/settings.js");
/* harmony import */ var _resources_js_pages_admin_connection_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/connection.js */ "./resources/js/pages/admin/connection.js");
/* harmony import */ var _resources_js_pages_admin_whitelist_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/whitelist.js */ "./resources/js/pages/admin/whitelist.js");






const render = wp.element.render;

class AdminApp extends _resources_js_app_js__WEBPACK_IMPORTED_MODULE_2__["default"] {
  constructor() {
    super();
    this.pageElement = document.querySelector('.tokenpass-admin-page');

    if (this.pageElement) {
      this.view = this.pageElement.dataset.view;
      this.props = JSON.parse(this.pageElement.dataset.props);
      const views = this.getViews();
      const ViewComponent = views[this.view];
      this.render(ViewComponent);
    }
  }

  getViews() {
    return {
      settings: _resources_js_pages_admin_settings_js__WEBPACK_IMPORTED_MODULE_3__["default"],
      connection: _resources_js_pages_admin_connection_js__WEBPACK_IMPORTED_MODULE_4__["default"],
      whitelist: _resources_js_pages_admin_whitelist_js__WEBPACK_IMPORTED_MODULE_5__["default"]
    };
  }

  render(ViewComponent) {
    if (!this.pageElement) {
      return;
    }

    const pageContainer = document.createElement('div');
    this.pageElement.appendChild(pageContainer);
    render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ViewComponent, {
      props: this.props
    }), pageContainer);
  }

  registerRedirects() {
    document.addEventListener('DOMContentLoaded', () => {
      var _window;

      if ((_window = window) !== null && _window !== void 0 && _window.tokenpassRedirects) {
        window.tokenpassRedirects.forEach(redirect => {
          const element = document.querySelector(`[href='${redirect.from}']`);

          if (element) {
            element.href = redirect.to;
            element.target = '_blank';
          }
        });
      }
    });
  }

}

(function () {
  const admin = new AdminApp();
})();
}();
/******/ })()
;
//# sourceMappingURL=admin.js.map