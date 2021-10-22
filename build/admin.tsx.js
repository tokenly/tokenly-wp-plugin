/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/scss/admin.scss":
/*!***********************************!*\
  !*** ./resources/scss/admin.scss ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/js/app.tsx":
/*!******************************!*\
  !*** ./resources/js/app.tsx ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// import ButtonLoginComponent from '/app/Components/ButtonLoginComponent.js';
var App = /** @class */ (function () {
    function App() {
    }
    return App;
}());
/* harmony default export */ __webpack_exports__["default"] = (App);


/***/ }),

/***/ "./resources/js/pages/admin/connection.tsx":
/*!*************************************************!*\
  !*** ./resources/js/pages/admin/connection.tsx ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
/* harmony import */ var _page__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./page */ "./resources/js/pages/admin/page.tsx");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_2__);
var __extends = (undefined && undefined.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __assign = (undefined && undefined.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};



var __ = wp.i18n.__;
var _a = wp.components, Button = _a.Button, Panel = _a.Panel, PanelBody = _a.PanelBody, PanelRow = _a.PanelRow;
var ConnectionPage = /** @class */ (function (_super) {
    __extends(ConnectionPage, _super);
    function ConnectionPage(props, authService) {
        var _this = _super.call(this, props) || this;
        _this.state = {
            status: false,
        };
        _this.authService = authService;
        return _this;
    }
    ConnectionPage.prototype.componentDidMount = function () {
        var _this = this;
        this.authService.getStatus().then(function (data) {
            _this.setState({
                status: data === null || data === void 0 ? void 0 : data.status,
            });
        });
    };
    ConnectionPage.prototype.getStatusText = function () {
        if (!this.state.status) {
            return;
        }
        if (this.state.status === true) {
            return 'Connected';
        }
        else {
            return 'Not connected';
        }
    };
    ConnectionPage.prototype.render = function () {
        var _this = this;
        return (Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(_page__WEBPACK_IMPORTED_MODULE_1__["default"], __assign({ title: 'Connection' }, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Panel, __assign({ header: "Connection Status" }, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelBody, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("div", { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("span", { children: "Connection status: " }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("span", { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("strong", { children: this.getStatusText() }, void 0) }, void 0)] }, void 0) }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Button, __assign({ isPrimary: true, isLarge: true, disabled: this.state.status, onClick: function () {
                                    _this.authService.connect();
                                } }, { children: __('Connect to Tokenpass') }), void 0) }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Button, __assign({ isPrimary: true, isLarge: true, disabled: !this.state.status, onClick: function () {
                                    _this.authService.disconnect();
                                } }, { children: __('Disconnect from Tokenpass') }), void 0) }, void 0)] }, void 0) }), void 0) }), void 0));
    };
    return ConnectionPage;
}(react__WEBPACK_IMPORTED_MODULE_2__.Component));
/* harmony default export */ __webpack_exports__["default"] = (ConnectionPage);


/***/ }),

/***/ "./resources/js/pages/admin/page.tsx":
/*!*******************************************!*\
  !*** ./resources/js/pages/admin/page.tsx ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
var __extends = (undefined && undefined.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();


var Fragment = wp.element.Fragment;
var Page = /** @class */ (function (_super) {
    __extends(Page, _super);
    function Page(props) {
        var _this = _super.call(this, props) || this;
        _this.state = {
        //
        };
        return _this;
    }
    Page.prototype.render = function () {
        return (Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Fragment, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("h2", { children: this.props.title }, void 0), this.props.children] }, void 0));
    };
    return Page;
}(react__WEBPACK_IMPORTED_MODULE_1__.Component));
/* harmony default export */ __webpack_exports__["default"] = (Page);


/***/ }),

/***/ "./resources/js/pages/admin/settings.tsx":
/*!***********************************************!*\
  !*** ./resources/js/pages/admin/settings.tsx ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
var __extends = (undefined && undefined.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __assign = (undefined && undefined.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};


var __ = wp.i18n.__;
var _a = wp.components, Button = _a.Button, TextControl = _a.TextControl, Placeholder = _a.Placeholder, Spinner = _a.Spinner, Panel = _a.Panel, PanelBody = _a.PanelBody, PanelRow = _a.PanelRow;
var SettingsPage = /** @class */ (function (_super) {
    __extends(SettingsPage, _super);
    function SettingsPage(props) {
        var _this = _super.call(this, props) || this;
        _this.updateSettings = _this.updateSettings.bind(_this);
        _this.state = Object.assign({
            clientId: null,
            clientSecret: null,
        }, _this.state);
        return _this;
    }
    SettingsPage.prototype.render = function () {
        var _this = this;
        return (Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Fragment, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("h2", { children: "Tokenpass Settings" }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Panel, __assign({ header: "How to Setup" }, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelBody, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("ul", __assign({ class: 'tk_steps' }, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("li", { children: ["1. Create App on ", Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("a", __assign({ href: "https://tokenpass.tokenly.com/auth/apps", target: "_blank" }, { children: "Tokenpass Developers" }), void 0)] }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("li", { children: "2. Use below details to create App" }, void 0)] }), void 0) }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("div", __assign({ class: 'tk_app_details' }, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("h3", { children: "Register Client Application" }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("span", { children: [" ", Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("b", { children: "CLIENT NAME: " }, void 0), " Random Input "] }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("br", {}, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("span", { children: [" ", Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("b", { children: "APP HOMEPAGE URL: " }, void 0), " ", Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("a", __assign({ href: this.state.props.app_homepage_url, target: "_blank" }, { children: this.state.props.app_homepage_url }), void 0), " "] }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("br", {}, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("span", { children: [" ", Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("b", { children: "CLIENT AUTHORIZATION REDIRECT URL: " }, void 0), " ", Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("a", __assign({ href: this.state.props.client_auth_url, target: "_blank" }, { children: this.state.props.client_auth_url }), void 0), " "] }, void 0)] }), void 0) }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, __assign({ className: "api-input-container" }, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(TextControl, { label: "Client ID", value: this.state.clientId, onChange: function (value) {
                                        _this.setState({ clientId: value });
                                    } }, void 0) }), void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(TextControl, { label: "Client Secret", value: this.state.clientSecret, onChange: function (value) {
                                        _this.setState({ clientSecret: value });
                                    } }, void 0) }, void 0)] }, void 0) }), void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Panel, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelBody, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, __assign({ className: "save-button-container" }, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Button, __assign({ isPrimary: true, isLarge: true, disabled: this.state.isAPISaving, onClick: function () {
                                        _this.updateSettings();
                                    } }, { children: __('Save settings') }), void 0), this.state.isAPISaving === true &&
                                    Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Spinner, {}, void 0)] }), void 0) }, void 0) }, void 0)] }, void 0));
    };
    return SettingsPage;
}(react__WEBPACK_IMPORTED_MODULE_1__.Component));
/* harmony default export */ __webpack_exports__["default"] = (SettingsPage);


/***/ }),

/***/ "./resources/js/pages/admin/whitelist.tsx":
/*!************************************************!*\
  !*** ./resources/js/pages/admin/whitelist.tsx ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
/* harmony import */ var _page__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./page */ "./resources/js/pages/admin/page.tsx");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_2__);
var __extends = (undefined && undefined.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __assign = (undefined && undefined.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};



var __ = wp.i18n.__;
var _a = wp.components, Button = _a.Button, Spinner = _a.Spinner, Panel = _a.Panel, PanelBody = _a.PanelBody, PanelRow = _a.PanelRow, ToggleControl = _a.ToggleControl, Flex = _a.Flex, TextControl = _a.TextControl, Dashicon = _a.Dashicon;
var Spacer = wp.components.__experimentalSpacer;
var Whitelist = /** @class */ (function (_super) {
    __extends(Whitelist, _super);
    function Whitelist(props) {
        var _this = _super.call(this, props) || this;
        _this.state = {
            whitelist: [],
        };
        _this.onUpdate = props.onUpdate;
        _this.state.whitelist = Object.assign([], props.whitelist);
        return _this;
    }
    Whitelist.prototype.onUpdate = function (whitelist) {
        //
    };
    Whitelist.prototype.onAdd = function () {
        var newState = Object.assign({}, this.state);
        newState.whitelist[newState.whitelist.length] = { address: '', index: '' };
        this.setState(newState);
        this.dispatchUpdate();
    };
    Whitelist.prototype.onRemove = function (index) {
        var newState = Object.assign({}, this.state);
        delete newState.whitelist[index];
        this.setState(newState);
        this.dispatchUpdate();
    };
    Whitelist.prototype.dispatchUpdate = function () {
        this.onUpdate(this.state.whitelist);
    };
    Whitelist.prototype.render = function () {
        var _this = this;
        var listItems = this.state.whitelist.map(function (listItem, i) {
            return Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("div", { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Flex, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(TextControl, { label: "Contract Address", value: listItem.address, onChange: function (value) {
                                    var newState = Object.assign({}, _this.state);
                                    newState.whitelist[i].address = value;
                                    _this.setState(__assign({}, newState));
                                    _this.dispatchUpdate();
                                } }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(TextControl, { label: "Token Index", value: listItem.index, onChange: function (value) {
                                    var newState = Object.assign({}, _this.state);
                                    newState.whitelist[i].index = value;
                                    _this.setState(__assign({}, newState));
                                    _this.dispatchUpdate();
                                } }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Button, __assign({ variant: "secondary", onClick: function () {
                                    _this.onRemove(i);
                                } }, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Dashicon, { icon: "no" }, void 0) }), void 0)] }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Spacer, { margin: 4 }, void 0)] }, void 0);
        });
        return Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("div", { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("ul", { children: listItems }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Button, __assign({ isPrimary: true, isLarge: true, onClick: function () {
                        _this.onAdd();
                    } }, { children: __('Add Token') }), void 0)] }, void 0);
    };
    return Whitelist;
}(react__WEBPACK_IMPORTED_MODULE_2__.Component));
var WhitelistPage = /** @class */ (function (_super) {
    __extends(WhitelistPage, _super);
    function WhitelistPage(props) {
        var _this = _super.call(this, props) || this;
        _this.state = {
            whitelistData: {
                use_whitelist: false,
                whitelist: [
                    {
                        address: '',
                        index: '',
                    },
                ],
            },
            saving: false,
        };
        _this.onWhitelistChange = _this.onWhitelistChange.bind(_this);
        return _this;
    }
    WhitelistPage.prototype.componentDidMount = function () {
        var _this = this;
        this.props.whitelistService.getWhitelist().then(function (whitelistData) {
            _this.setState({
                whitelistData: whitelistData,
            });
        });
    };
    WhitelistPage.prototype.onWhitelistChange = function (newWhitelist) {
        var newState = Object.assign({}, this.state);
        newState.whitelistData.whitelist = Object.assign([], newWhitelist);
        newState.whitelistData.whitelist = newState.whitelistData.whitelist.filter(function (whitelistItem) {
            return whitelistItem != null;
        });
        this.setState(__assign({}, newState));
    };
    WhitelistPage.prototype.setUseWhitelist = function (value) {
        var newState = Object.assign({}, this.state);
        newState.whitelistData.use_whitelist = value;
        this.setState(newState);
    };
    WhitelistPage.prototype.render = function () {
        var _this = this;
        return (Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(_page__WEBPACK_IMPORTED_MODULE_1__["default"], __assign({ title: 'Token Whitelist' }, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Panel, __assign({ header: "Token Whitelist Settings" }, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelBody, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())("p", { children: "Whitelist allows to control which token assets to display on the Inventory screen." }, void 0) }, void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(ToggleControl, { label: "Use whitelist", help: this.state.whitelistData.use_whitelist
                                        ? 'Whitelist enabled.'
                                        : 'Whitelist disabled.', checked: this.state.whitelistData.use_whitelist, onChange: function (value) {
                                        _this.setUseWhitelist(value);
                                    } }, void 0) }, void 0)] }, void 0) }), void 0), this.state.whitelistData.use_whitelist === true &&
                    Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Panel, __assign({ header: "Token Whitelist Editor" }, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelBody, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Whitelist, { onUpdate: this.onWhitelistChange, whitelist: this.state.whitelistData.whitelist }, void 0) }, void 0) }, void 0) }), void 0), Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Panel, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelBody, { children: Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(PanelRow, __assign({ className: "save-button-container" }, { children: [Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Button, __assign({ isPrimary: true, isLarge: true, disabled: this.state.saving, onClick: function () {
                                        _this.props.whitelistService.updateWhitelist(_this.state.whitelistData);
                                    } }, { children: __('Save settings') }), void 0), this.state.saving === true &&
                                    Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(Spinner, {}, void 0)] }), void 0) }, void 0) }, void 0)] }), void 0));
    };
    return WhitelistPage;
}(react__WEBPACK_IMPORTED_MODULE_2__.Component));
/* harmony default export */ __webpack_exports__["default"] = (WhitelistPage);


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

module.exports = window["React"];

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
/*!********************************!*\
  !*** ./resources/js/admin.tsx ***!
  \********************************/
__webpack_require__.r(__webpack_exports__);
Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
/* harmony import */ var _resources_scss_admin_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../../../resources/scss/admin.scss */ "./resources/scss/admin.scss");
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./app */ "./resources/js/app.tsx");
/* harmony import */ var _pages_admin_settings__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./pages/admin/settings */ "./resources/js/pages/admin/settings.tsx");
/* harmony import */ var _pages_admin_connection__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./pages/admin/connection */ "./resources/js/pages/admin/connection.tsx");
/* harmony import */ var _pages_admin_whitelist__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./pages/admin/whitelist */ "./resources/js/pages/admin/whitelist.tsx");
var __extends = (undefined && undefined.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();






var render = wp.element.render;
var AdminApp = /** @class */ (function (_super) {
    __extends(AdminApp, _super);
    function AdminApp() {
        var _this = _super.call(this) || this;
        _this.pageElement = document.querySelector('.tokenpass-admin-page');
        if (_this.pageElement) {
            _this.view = _this.pageElement.dataset.view;
            _this.props = JSON.parse(_this.pageElement.dataset.props);
            var views = _this.getViews();
            var ViewComponent = views[_this.view];
            _this.render(ViewComponent);
        }
        return _this;
    }
    AdminApp.prototype.getViews = function () {
        return {
            'settings': _pages_admin_settings__WEBPACK_IMPORTED_MODULE_3__["default"],
            'connection': _pages_admin_connection__WEBPACK_IMPORTED_MODULE_4__["default"],
            'whitelist': _pages_admin_whitelist__WEBPACK_IMPORTED_MODULE_5__["default"],
        };
    };
    AdminApp.prototype.render = function (ViewComponent) {
        if (!this.pageElement) {
            return;
        }
        var pageContainer = document.createElement('div');
        this.pageElement.appendChild(pageContainer);
        render(Object(function webpackMissingModule() { var e = new Error("Cannot find module 'react/jsx-runtime'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(ViewComponent, { props: this.props }, void 0), pageContainer);
    };
    AdminApp.prototype.registerRedirects = function () {
        document.addEventListener('DOMContentLoaded', function () {
            if (window['tokenpassRedirects']) {
                window['tokenpassRedirects'].forEach(function (redirect) {
                    var element = document.querySelector("[href='" + redirect.from + "']");
                    if (element) {
                        element.href = redirect.to;
                        element.target = '_blank';
                    }
                });
            }
        });
    };
    return AdminApp;
}(_app__WEBPACK_IMPORTED_MODULE_2__["default"]));
(function () {
    var admin = new AdminApp();
})();

}();
/******/ })()
;
//# sourceMappingURL=admin.tsx.js.map