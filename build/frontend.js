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

/***/ "./resources/scss/frontend.scss":
/*!**************************************!*\
  !*** ./resources/scss/frontend.scss ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/*!**********************************!*\
  !*** ./resources/js/frontend.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _resources_scss_frontend_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../../../resources/scss/frontend.scss */ "./resources/scss/frontend.scss");
/* harmony import */ var _resources_js_common_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../../../resources/js/common.js */ "./resources/js/common.js");



class Frontend {
  init() {
    (0,_resources_js_common_js__WEBPACK_IMPORTED_MODULE_1__.init)();
  }

}

(function () {
  const frontend = new Frontend();
  frontend.init();
})();
}();
/******/ })()
;
//# sourceMappingURL=frontend.js.map