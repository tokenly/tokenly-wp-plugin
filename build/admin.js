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
    console.log('click');
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

/***/ "./resources/js/common.js":
/*!********************************!*\
  !*** ./resources/js/common.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "init": function() { return /* binding */ init; }
/* harmony export */ });
/* harmony import */ var _app_Components_ButtonLoginComponent_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../../../app/Components/ButtonLoginComponent.js */ "./app/Components/ButtonLoginComponent.js");


class Common {
  init() {
    (0,_app_Components_ButtonLoginComponent_js__WEBPACK_IMPORTED_MODULE_0__.init)();
  }

}

function init() {
  const common = new Common();
  common.init();
}

/***/ }),

/***/ "./resources/js/pages/admin/connection.js":
/*!************************************************!*\
  !*** ./resources/js/pages/admin/connection.js ***!
  \************************************************/
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

class TokenpassConnectionPageComponent extends Component {
  constructor() {
    super(...arguments);
    this.connect = this.connect.bind(this);
    this.state = {
      isAPILoaded: false,
      isAPISaving: false,
      status: false
    };
  }

  componentDidMount() {
    wp.api.loadPromise.then(() => {
      if (false === this.state.isAPILoaded) {
        this.getStatus().then(result => {
          this.setState({
            isAPILoaded: true
          });
        });
      }
    });
  }

  getStatus() {
    return new Promise((resolve, reject) => {
      const params = {
        method: 'GET',
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
          'X-WP-Nonce': wpApiSettings.nonce
        }
      };
      const url = '/wp-json/tokenly/v1/authorize';
      fetch(url, params).then(response => response.json()).then(data => {
        console.log(data);
        this.setState({ ...((data === null || data === void 0 ? void 0 : data.status) && {
            status: data.status
          })
        });
        resolve(data);
      }).catch(err => reject(err));
    });
  }

  getStatusText() {
    if (this.state.status === true) {
      return 'Connected';
    } else {
      return 'Not connected';
    }
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

        const redirectUrl = (_data$url = data.url) !== null && _data$url !== void 0 ? _data$url : null;

        if (redirectUrl) {
          window.location = redirectUrl;
        }
      }).catch(err => reject(err));
    });
  }

  disconnect() {
    return new Promise((resolve, reject) => {
      const params = {
        method: 'DELETE',
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
          'X-WP-Nonce': wpApiSettings.nonce
        }
      };
      const url = '/wp-json/tokenly/v1/authorize';
      fetch(url, params).then(response => response.json()).then(data => {
        window.location.reload(false);
      }).catch(err => reject(err));
    });
  }

  render() {
    if (!this.state.isAPILoaded) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null));
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", null, "Connection"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Panel, {
      header: "Connection Status"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, "Connection status: "), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("strong", null, this.getStatusText())))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      isPrimary: true,
      isLarge: true,
      disabled: this.state.status,
      onClick: () => {
        this.connect();
      }
    }, __('Connect to Tokenpass'))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      isPrimary: true,
      isLarge: true,
      disabled: !this.state.status,
      onClick: () => {
        this.disconnect();
      }
    }, __('Disconnect from Tokenpass'))))));
  }

}

function init() {
  const postBody = document.querySelector('#tokenpass-connection-page-content');

  if (postBody) {
    const appContainer = document.createElement('div');
    postBody.appendChild(appContainer);
    render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TokenpassConnectionPageComponent, null), appContainer);
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

  if (postBody) {
    const appContainer = document.createElement('div');
    postBody.appendChild(appContainer);
    render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TokenpassSettingsPageComponent, null), appContainer);
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
/* harmony export */   "init": function() { return /* binding */ init; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

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
  render,
  useEffect,
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

class TokenpassWhitelistPageComponent extends Component {
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

  componentDidMount() {
    wp.api.loadPromise.then(() => {
      if (false === this.state.isAPILoaded) {
        this.getWhitelist().then(result => {
          this.setState({
            isAPILoaded: true
          });
        });
      }
    });
  }

  getWhitelist() {
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

        console.log(data);
        this.setState({ ...{
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

function init() {
  const postBody = document.querySelector('#tokenpass-whitelist-page-content');

  if (postBody) {
    const appContainer = document.createElement('div');
    postBody.appendChild(appContainer);
    render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TokenpassWhitelistPageComponent, null), appContainer);
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
/* harmony import */ var _resources_scss_admin_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../../../resources/scss/admin.scss */ "./resources/scss/admin.scss");
/* harmony import */ var _resources_js_common_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../../../resources/js/common.js */ "./resources/js/common.js");
/* harmony import */ var _resources_js_pages_admin_settings_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/settings.js */ "./resources/js/pages/admin/settings.js");
/* harmony import */ var _resources_js_pages_admin_connection_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/connection.js */ "./resources/js/pages/admin/connection.js");
/* harmony import */ var _resources_js_pages_admin_whitelist_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../../../../../../../resources/js/pages/admin/whitelist.js */ "./resources/js/pages/admin/whitelist.js");






class Admin {
  init() {
    (0,_resources_js_common_js__WEBPACK_IMPORTED_MODULE_1__.init)();
    (0,_resources_js_pages_admin_settings_js__WEBPACK_IMPORTED_MODULE_2__.init)();
    (0,_resources_js_pages_admin_connection_js__WEBPACK_IMPORTED_MODULE_3__.init)();
    (0,_resources_js_pages_admin_whitelist_js__WEBPACK_IMPORTED_MODULE_4__.init)();
    this.registerRedirects();
  }

  registerRedirects() {
    document.addEventListener('DOMContentLoaded', () => {
      if (window.adminRedirects) {
        window.adminRedirects.forEach(redirect => {
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
  const admin = new Admin();
  admin.init();
})();
}();
/******/ })()
;
//# sourceMappingURL=admin.js.map