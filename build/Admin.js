/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/dayjs/dayjs.min.js":
/*!*****************************************!*\
  !*** ./node_modules/dayjs/dayjs.min.js ***!
  \*****************************************/
/***/ (function(module) {

!function(t,e){ true?module.exports=e():0}(this,(function(){"use strict";var t=1e3,e=6e4,n=36e5,r="millisecond",i="second",s="minute",u="hour",a="day",o="week",f="month",h="quarter",c="year",d="date",$="Invalid Date",l=/^(\d{4})[-/]?(\d{1,2})?[-/]?(\d{0,2})[Tt\s]*(\d{1,2})?:?(\d{1,2})?:?(\d{1,2})?[.:]?(\d+)?$/,y=/\[([^\]]+)]|Y{1,4}|M{1,4}|D{1,2}|d{1,4}|H{1,2}|h{1,2}|a|A|m{1,2}|s{1,2}|Z{1,2}|SSS/g,M={name:"en",weekdays:"Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),months:"January_February_March_April_May_June_July_August_September_October_November_December".split("_")},m=function(t,e,n){var r=String(t);return!r||r.length>=e?t:""+Array(e+1-r.length).join(n)+t},g={s:m,z:function(t){var e=-t.utcOffset(),n=Math.abs(e),r=Math.floor(n/60),i=n%60;return(e<=0?"+":"-")+m(r,2,"0")+":"+m(i,2,"0")},m:function t(e,n){if(e.date()<n.date())return-t(n,e);var r=12*(n.year()-e.year())+(n.month()-e.month()),i=e.clone().add(r,f),s=n-i<0,u=e.clone().add(r+(s?-1:1),f);return+(-(r+(n-i)/(s?i-u:u-i))||0)},a:function(t){return t<0?Math.ceil(t)||0:Math.floor(t)},p:function(t){return{M:f,y:c,w:o,d:a,D:d,h:u,m:s,s:i,ms:r,Q:h}[t]||String(t||"").toLowerCase().replace(/s$/,"")},u:function(t){return void 0===t}},D="en",v={};v[D]=M;var p=function(t){return t instanceof _},S=function(t,e,n){var r;if(!t)return D;if("string"==typeof t)v[t]&&(r=t),e&&(v[t]=e,r=t);else{var i=t.name;v[i]=t,r=i}return!n&&r&&(D=r),r||!n&&D},w=function(t,e){if(p(t))return t.clone();var n="object"==typeof e?e:{};return n.date=t,n.args=arguments,new _(n)},O=g;O.l=S,O.i=p,O.w=function(t,e){return w(t,{locale:e.$L,utc:e.$u,x:e.$x,$offset:e.$offset})};var _=function(){function M(t){this.$L=S(t.locale,null,!0),this.parse(t)}var m=M.prototype;return m.parse=function(t){this.$d=function(t){var e=t.date,n=t.utc;if(null===e)return new Date(NaN);if(O.u(e))return new Date;if(e instanceof Date)return new Date(e);if("string"==typeof e&&!/Z$/i.test(e)){var r=e.match(l);if(r){var i=r[2]-1||0,s=(r[7]||"0").substring(0,3);return n?new Date(Date.UTC(r[1],i,r[3]||1,r[4]||0,r[5]||0,r[6]||0,s)):new Date(r[1],i,r[3]||1,r[4]||0,r[5]||0,r[6]||0,s)}}return new Date(e)}(t),this.$x=t.x||{},this.init()},m.init=function(){var t=this.$d;this.$y=t.getFullYear(),this.$M=t.getMonth(),this.$D=t.getDate(),this.$W=t.getDay(),this.$H=t.getHours(),this.$m=t.getMinutes(),this.$s=t.getSeconds(),this.$ms=t.getMilliseconds()},m.$utils=function(){return O},m.isValid=function(){return!(this.$d.toString()===$)},m.isSame=function(t,e){var n=w(t);return this.startOf(e)<=n&&n<=this.endOf(e)},m.isAfter=function(t,e){return w(t)<this.startOf(e)},m.isBefore=function(t,e){return this.endOf(e)<w(t)},m.$g=function(t,e,n){return O.u(t)?this[e]:this.set(n,t)},m.unix=function(){return Math.floor(this.valueOf()/1e3)},m.valueOf=function(){return this.$d.getTime()},m.startOf=function(t,e){var n=this,r=!!O.u(e)||e,h=O.p(t),$=function(t,e){var i=O.w(n.$u?Date.UTC(n.$y,e,t):new Date(n.$y,e,t),n);return r?i:i.endOf(a)},l=function(t,e){return O.w(n.toDate()[t].apply(n.toDate("s"),(r?[0,0,0,0]:[23,59,59,999]).slice(e)),n)},y=this.$W,M=this.$M,m=this.$D,g="set"+(this.$u?"UTC":"");switch(h){case c:return r?$(1,0):$(31,11);case f:return r?$(1,M):$(0,M+1);case o:var D=this.$locale().weekStart||0,v=(y<D?y+7:y)-D;return $(r?m-v:m+(6-v),M);case a:case d:return l(g+"Hours",0);case u:return l(g+"Minutes",1);case s:return l(g+"Seconds",2);case i:return l(g+"Milliseconds",3);default:return this.clone()}},m.endOf=function(t){return this.startOf(t,!1)},m.$set=function(t,e){var n,o=O.p(t),h="set"+(this.$u?"UTC":""),$=(n={},n[a]=h+"Date",n[d]=h+"Date",n[f]=h+"Month",n[c]=h+"FullYear",n[u]=h+"Hours",n[s]=h+"Minutes",n[i]=h+"Seconds",n[r]=h+"Milliseconds",n)[o],l=o===a?this.$D+(e-this.$W):e;if(o===f||o===c){var y=this.clone().set(d,1);y.$d[$](l),y.init(),this.$d=y.set(d,Math.min(this.$D,y.daysInMonth())).$d}else $&&this.$d[$](l);return this.init(),this},m.set=function(t,e){return this.clone().$set(t,e)},m.get=function(t){return this[O.p(t)]()},m.add=function(r,h){var d,$=this;r=Number(r);var l=O.p(h),y=function(t){var e=w($);return O.w(e.date(e.date()+Math.round(t*r)),$)};if(l===f)return this.set(f,this.$M+r);if(l===c)return this.set(c,this.$y+r);if(l===a)return y(1);if(l===o)return y(7);var M=(d={},d[s]=e,d[u]=n,d[i]=t,d)[l]||1,m=this.$d.getTime()+r*M;return O.w(m,this)},m.subtract=function(t,e){return this.add(-1*t,e)},m.format=function(t){var e=this,n=this.$locale();if(!this.isValid())return n.invalidDate||$;var r=t||"YYYY-MM-DDTHH:mm:ssZ",i=O.z(this),s=this.$H,u=this.$m,a=this.$M,o=n.weekdays,f=n.months,h=function(t,n,i,s){return t&&(t[n]||t(e,r))||i[n].substr(0,s)},c=function(t){return O.s(s%12||12,t,"0")},d=n.meridiem||function(t,e,n){var r=t<12?"AM":"PM";return n?r.toLowerCase():r},l={YY:String(this.$y).slice(-2),YYYY:this.$y,M:a+1,MM:O.s(a+1,2,"0"),MMM:h(n.monthsShort,a,f,3),MMMM:h(f,a),D:this.$D,DD:O.s(this.$D,2,"0"),d:String(this.$W),dd:h(n.weekdaysMin,this.$W,o,2),ddd:h(n.weekdaysShort,this.$W,o,3),dddd:o[this.$W],H:String(s),HH:O.s(s,2,"0"),h:c(1),hh:c(2),a:d(s,u,!0),A:d(s,u,!1),m:String(u),mm:O.s(u,2,"0"),s:String(this.$s),ss:O.s(this.$s,2,"0"),SSS:O.s(this.$ms,3,"0"),Z:i};return r.replace(y,(function(t,e){return e||l[t]||i.replace(":","")}))},m.utcOffset=function(){return 15*-Math.round(this.$d.getTimezoneOffset()/15)},m.diff=function(r,d,$){var l,y=O.p(d),M=w(r),m=(M.utcOffset()-this.utcOffset())*e,g=this-M,D=O.m(this,M);return D=(l={},l[c]=D/12,l[f]=D,l[h]=D/3,l[o]=(g-m)/6048e5,l[a]=(g-m)/864e5,l[u]=g/n,l[s]=g/e,l[i]=g/t,l)[y]||g,$?D:O.a(D)},m.daysInMonth=function(){return this.endOf(f).$D},m.$locale=function(){return v[this.$L]},m.locale=function(t,e){if(!t)return this.$L;var n=this.clone(),r=S(t,e,!0);return r&&(n.$L=r),n},m.clone=function(){return O.w(this.$d,this)},m.toDate=function(){return new Date(this.valueOf())},m.toJSON=function(){return this.isValid()?this.toISOString():null},m.toISOString=function(){return this.$d.toISOString()},m.toString=function(){return this.$d.toUTCString()},M}(),b=_.prototype;return w.prototype=b,[["$ms",r],["$s",i],["$m",s],["$H",u],["$W",a],["$M",f],["$y",c],["$D",d]].forEach((function(t){b[t[1]]=function(e){return this.$g(e,t[0],t[1])}})),w.extend=function(t,e){return t.$i||(t(e,_,w),t.$i=!0),w},w.locale=S,w.isDayjs=p,w.unix=function(t){return w(1e3*t)},w.en=v[D],w.Ls=v,w.p={},w}));

/***/ }),

/***/ "./node_modules/inversify-react/dist/index.js":
/*!****************************************************!*\
  !*** ./node_modules/inversify-react/dist/index.js ***!
  \****************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

!function(e,t){ true?module.exports=t(__webpack_require__(/*! react */ "react")):0}("undefined"!=typeof self?self:this,(function(e){return(()=>{"use strict";var t={131:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.useAllInjections=t.useOptionalInjection=t.useInjection=t.useContainer=void 0;var n=r(888),o=r(838);function i(e){var t,r,i=n.useContext(o.InversifyReactContext);if(!i)throw new Error("Cannot find Inversify container on React Context. `Provider` component is missing in component tree.");return e?(t=function(){return e(i)},(r=n.useRef()).current||(r.current={v:t()}),r.current.v):i}t.useContainer=i,t.useInjection=function(e){return i((function(t){return t.get(e)}))},t.useOptionalInjection=function(e,t){return void 0===t&&(t=function(){}),i((function(r){return r.isBound(e)?r.get(e):t(r)}))},t.useAllInjections=function(e){return i((function(t){return t.getAll(e)}))}},838:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.getInstanceAdministration=t.getClassAdministration=t.createProperty=t.ensureAcceptContext=t.AdministrationKey=t.InversifyReactContext=void 0;var n=r(888).createContext(void 0);t.InversifyReactContext=n,n.displayName="InversifyReactContext";var o="~$inversify-react";function i(e){var t=e[o];return t||(t={accepts:!1},Object.defineProperty(e,o,{enumerable:!1,writable:!1,value:t})),t}function a(e){var t=e[o];if(!t){var r=e.context;if(!r)throw new Error("Cannot use resolve services without any providers in component tree.");t={container:r,properties:{}},Object.defineProperty(e,o,{enumerable:!1,writable:!1,value:t})}return t}t.AdministrationKey=o,t.getClassAdministration=i,t.getInstanceAdministration=a,t.ensureAcceptContext=function(e){var t=i(e);if(!t.accepts){var r=e.contextType,o=e.displayName||e.name;if(r)throw new Error("inversify-react cannot configure React context.\nComponent `"+o+"` already has `contextType: "+(r.displayName||"<anonymous context>")+"` defined.\n@see inversify-react/test/resolve.tsx#limitations for more info and workarounds\n");Object.defineProperty(e,"contextType",{enumerable:!0,get:function(){return n},set:function(e){if(e!==n)throw new Error("Cannot change `contextType` of `"+o+"` component.\nLooks like you are using inversify-react decorators, which have already patched this component and use own context to deliver IoC container.\n@see inversify-react/test/resolve.tsx#limitations for more info and workarounds\n")}}),t.accepts=!0}},t.createProperty=function(e,t,r,n){Object.defineProperty(e,t,{enumerable:!0,get:function(){var e=a(this),o=e.properties[t];if(!o){var i,s=e.container;i=n.isOptional?s.isBound(r)?s.get(r):n.defaultValue:s.get(r),o=e.properties[t]=function(){return i}}return o()}});var o=Object.getOwnPropertyDescriptor(e,t);if(!o)throw new Error("Failed to define property");return o}},713:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.Provider=void 0;var n=r(888),o=r(888),i=r(838),a=function(e){var t=e.children,r=e.container,a=e.standalone,s=void 0!==a&&a,c=o.useState(r)[0];if("resolve"in r&&r!==c)throw new Error("Changing `container` prop (swapping container in runtime) is not supported.\nIf you're rendering Provider in some list, try adding `key={container.id}` to the Provider.\nMore info on React lists:\nhttps://reactjs.org/docs/lists-and-keys.html#keys\nhttps://reactjs.org/docs/reconciliation.html#recursing-on-children");var u=o.useState(s)[0];if(s!==u)throw new Error("Changing `standalone` prop is not supported.");var f=o.useContext(i.InversifyReactContext);return o.useState((function(){if(!u&&f){if(f===c)throw new Error("Provider has found a parent container (on surrounding React Context), yet somehow it's the same as container specified in props. It doesn't make sense.\nPerhaps you meant to configure Provider as `standalone={true}`?");if(c.parent)throw new Error("Ambiguous containers hierarchy.\nProvider has found a parent for specified `container`, but it already has a parent.\nLearn more at https://github.com/Kukkimonsuta/inversify-react/blob/v0.5.0/src/provider.tsx");c.parent=f}})),n.createElement(i.InversifyReactContext.Provider,{value:c},t)};t.Provider=a,t.default=a},905:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.resolve=void 0;var n=r(838);function o(e,t,r,o){return n.ensureAcceptContext(e.constructor),n.createProperty(e,t,r,o)}function i(e,t){if(!t)throw new Error("Decorator `resolve` failed to resolve property name");if(!Reflect||!Reflect.getMetadata)throw new Error("Decorator `resolve` without specifying service identifier requires `reflect-metadata`");var r=Reflect.getMetadata("design:type",e,t);if(!r)throw new Error("Failed to discover property type, is `emitDecoratorMetadata` enabled?");return r}var a=function(e,t,r){if(void 0!==t)return o(e,t,i(e,t),{});var n=e;if(!n)throw new Error("Invalid property type.");return function(e,t,r){return o(e,t,n,{})}};t.resolve=a,a.optional=function(){for(var e=[],t=0;t<arguments.length;t++)e[t]=arguments[t];if("string"==typeof e[1]&&3===e.length){var r=e[0],n=e[1],a=(e[2],i(r,n));return o(r,n,a,{isOptional:!0})}var s=e[0],c=e[1];return function(e,t,r){return o(e,t,s,{isOptional:!0,defaultValue:c})}},t.default=a},888:t=>{t.exports=e}},r={};function n(e){var o=r[e];if(void 0!==o)return o.exports;var i=r[e]={exports:{}};return t[e](i,i.exports,n),i.exports}var o={};return(()=>{var e=o;Object.defineProperty(e,"__esModule",{value:!0}),e.useOptionalInjection=e.useInjection=e.useContainer=e.useAllInjections=e.Provider=e.resolve=void 0;var t=n(905);Object.defineProperty(e,"resolve",{enumerable:!0,get:function(){return t.resolve}});var r=n(713);Object.defineProperty(e,"Provider",{enumerable:!0,get:function(){return r.Provider}});var i=n(131);Object.defineProperty(e,"useAllInjections",{enumerable:!0,get:function(){return i.useAllInjections}}),Object.defineProperty(e,"useContainer",{enumerable:!0,get:function(){return i.useContainer}}),Object.defineProperty(e,"useInjection",{enumerable:!0,get:function(){return i.useInjection}}),Object.defineProperty(e,"useOptionalInjection",{enumerable:!0,get:function(){return i.useOptionalInjection}})})(),o})()}));
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/decorator_utils.js":
/*!*****************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/decorator_utils.js ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "decorate": function() { return /* binding */ decorate; },
/* harmony export */   "tagParameter": function() { return /* binding */ tagParameter; },
/* harmony export */   "tagProperty": function() { return /* binding */ tagProperty; },
/* harmony export */   "createTaggedDecorator": function() { return /* binding */ createTaggedDecorator; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/js */ "./node_modules/inversify/es/utils/js.js");



function targetIsConstructorFunction(target) {
    return target.prototype !== undefined;
}
function _throwIfMethodParameter(parameterName) {
    if (parameterName !== undefined) {
        throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.INVALID_DECORATOR_OPERATION);
    }
}
function tagParameter(annotationTarget, parameterName, parameterIndex, metadata) {
    _throwIfMethodParameter(parameterName);
    _tagParameterOrProperty(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.TAGGED, annotationTarget, parameterIndex.toString(), metadata);
}
function tagProperty(annotationTarget, propertyName, metadata) {
    if (targetIsConstructorFunction(annotationTarget)) {
        throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.INVALID_DECORATOR_OPERATION);
    }
    _tagParameterOrProperty(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.TAGGED_PROP, annotationTarget.constructor, propertyName, metadata);
}
function _ensureNoMetadataKeyDuplicates(metadata) {
    var metadatas = [];
    if (Array.isArray(metadata)) {
        metadatas = metadata;
        var duplicate = (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.getFirstArrayDuplicate)(metadatas.map(function (md) { return md.key; }));
        if (duplicate !== undefined) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.DUPLICATED_METADATA + " " + duplicate.toString());
        }
    }
    else {
        metadatas = [metadata];
    }
    return metadatas;
}
function _tagParameterOrProperty(metadataKey, annotationTarget, key, metadata) {
    var metadatas = _ensureNoMetadataKeyDuplicates(metadata);
    var paramsOrPropertiesMetadata = {};
    if (Reflect.hasOwnMetadata(metadataKey, annotationTarget)) {
        paramsOrPropertiesMetadata = Reflect.getMetadata(metadataKey, annotationTarget);
    }
    var paramOrPropertyMetadata = paramsOrPropertiesMetadata[key];
    if (paramOrPropertyMetadata === undefined) {
        paramOrPropertyMetadata = [];
    }
    else {
        var _loop_1 = function (m) {
            if (metadatas.some(function (md) { return md.key === m.key; })) {
                throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.DUPLICATED_METADATA + " " + m.key.toString());
            }
        };
        for (var _i = 0, paramOrPropertyMetadata_1 = paramOrPropertyMetadata; _i < paramOrPropertyMetadata_1.length; _i++) {
            var m = paramOrPropertyMetadata_1[_i];
            _loop_1(m);
        }
    }
    paramOrPropertyMetadata.push.apply(paramOrPropertyMetadata, metadatas);
    paramsOrPropertiesMetadata[key] = paramOrPropertyMetadata;
    Reflect.defineMetadata(metadataKey, paramsOrPropertiesMetadata, annotationTarget);
}
function createTaggedDecorator(metadata) {
    return function (target, targetKey, indexOrPropertyDescriptor) {
        if (typeof indexOrPropertyDescriptor === "number") {
            tagParameter(target, targetKey, indexOrPropertyDescriptor, metadata);
        }
        else {
            tagProperty(target, targetKey, metadata);
        }
    };
}
function _decorate(decorators, target) {
    Reflect.decorate(decorators, target);
}
function _param(paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); };
}
function decorate(decorator, target, parameterIndexOrProperty) {
    if (typeof parameterIndexOrProperty === "number") {
        _decorate([_param(parameterIndexOrProperty, decorator)], target);
    }
    else if (typeof parameterIndexOrProperty === "string") {
        Reflect.decorate([decorator], target, parameterIndexOrProperty);
    }
    else {
        _decorate([decorator], target);
    }
}

//# sourceMappingURL=decorator_utils.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/inject.js":
/*!********************************************************!*\
  !*** ./node_modules/inversify/es/annotation/inject.js ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "inject": function() { return /* binding */ inject; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _inject_base__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./inject_base */ "./node_modules/inversify/es/annotation/inject_base.js");


var inject = (0,_inject_base__WEBPACK_IMPORTED_MODULE_0__.injectBase)(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.INJECT_TAG);

//# sourceMappingURL=inject.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/inject_base.js":
/*!*************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/inject_base.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "injectBase": function() { return /* binding */ injectBase; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _decorator_utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./decorator_utils */ "./node_modules/inversify/es/annotation/decorator_utils.js");



function injectBase(metadataKey) {
    return function (serviceIdentifier) {
        return function (target, targetKey, indexOrPropertyDescriptor) {
            if (serviceIdentifier === undefined) {
                var className = typeof target === "function" ? target.name : target.constructor.name;
                throw new Error((0,_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.UNDEFINED_INJECT_ANNOTATION)(className));
            }
            return (0,_decorator_utils__WEBPACK_IMPORTED_MODULE_1__.createTaggedDecorator)(new _planning_metadata__WEBPACK_IMPORTED_MODULE_2__.Metadata(metadataKey, serviceIdentifier))(target, targetKey, indexOrPropertyDescriptor);
        };
    };
}
//# sourceMappingURL=inject_base.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/injectable.js":
/*!************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/injectable.js ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "injectable": function() { return /* binding */ injectable; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");


function injectable() {
    return function (target) {
        if (Reflect.hasOwnMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.PARAM_TYPES, target)) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_1__.DUPLICATED_INJECTABLE_DECORATOR);
        }
        var types = Reflect.getMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.DESIGN_PARAM_TYPES, target) || [];
        Reflect.defineMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.PARAM_TYPES, types, target);
        return target;
    };
}

//# sourceMappingURL=injectable.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/lazy_service_identifier.js":
/*!*************************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/lazy_service_identifier.js ***!
  \*************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "LazyServiceIdentifer": function() { return /* binding */ LazyServiceIdentifer; }
/* harmony export */ });
var LazyServiceIdentifer = (function () {
    function LazyServiceIdentifer(cb) {
        this._cb = cb;
    }
    LazyServiceIdentifer.prototype.unwrap = function () {
        return this._cb();
    };
    return LazyServiceIdentifer;
}());

//# sourceMappingURL=lazy_service_identifier.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/multi_inject.js":
/*!**************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/multi_inject.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "multiInject": function() { return /* binding */ multiInject; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _inject_base__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./inject_base */ "./node_modules/inversify/es/annotation/inject_base.js");


var multiInject = (0,_inject_base__WEBPACK_IMPORTED_MODULE_0__.injectBase)(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.MULTI_INJECT_TAG);

//# sourceMappingURL=multi_inject.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/named.js":
/*!*******************************************************!*\
  !*** ./node_modules/inversify/es/annotation/named.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "named": function() { return /* binding */ named; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _decorator_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./decorator_utils */ "./node_modules/inversify/es/annotation/decorator_utils.js");



function named(name) {
    return (0,_decorator_utils__WEBPACK_IMPORTED_MODULE_0__.createTaggedDecorator)(new _planning_metadata__WEBPACK_IMPORTED_MODULE_1__.Metadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__.NAMED_TAG, name));
}

//# sourceMappingURL=named.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/optional.js":
/*!**********************************************************!*\
  !*** ./node_modules/inversify/es/annotation/optional.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "optional": function() { return /* binding */ optional; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _decorator_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./decorator_utils */ "./node_modules/inversify/es/annotation/decorator_utils.js");



function optional() {
    return (0,_decorator_utils__WEBPACK_IMPORTED_MODULE_0__.createTaggedDecorator)(new _planning_metadata__WEBPACK_IMPORTED_MODULE_1__.Metadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__.OPTIONAL_TAG, true));
}

//# sourceMappingURL=optional.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/post_construct.js":
/*!****************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/post_construct.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "postConstruct": function() { return /* binding */ postConstruct; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _property_event_decorator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./property_event_decorator */ "./node_modules/inversify/es/annotation/property_event_decorator.js");



var postConstruct = (0,_property_event_decorator__WEBPACK_IMPORTED_MODULE_0__.propertyEventDecorator)(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.POST_CONSTRUCT, _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__.MULTIPLE_POST_CONSTRUCT_METHODS);

//# sourceMappingURL=post_construct.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/pre_destroy.js":
/*!*************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/pre_destroy.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "preDestroy": function() { return /* binding */ preDestroy; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _property_event_decorator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./property_event_decorator */ "./node_modules/inversify/es/annotation/property_event_decorator.js");



var preDestroy = (0,_property_event_decorator__WEBPACK_IMPORTED_MODULE_0__.propertyEventDecorator)(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.PRE_DESTROY, _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__.MULTIPLE_PRE_DESTROY_METHODS);

//# sourceMappingURL=pre_destroy.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/property_event_decorator.js":
/*!**************************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/property_event_decorator.js ***!
  \**************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "propertyEventDecorator": function() { return /* binding */ propertyEventDecorator; }
/* harmony export */ });
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");

function propertyEventDecorator(eventKey, errorMessage) {
    return function () {
        return function (target, propertyKey) {
            var metadata = new _planning_metadata__WEBPACK_IMPORTED_MODULE_0__.Metadata(eventKey, propertyKey);
            if (Reflect.hasOwnMetadata(eventKey, target.constructor)) {
                throw new Error(errorMessage);
            }
            Reflect.defineMetadata(eventKey, metadata, target.constructor);
        };
    };
}

//# sourceMappingURL=property_event_decorator.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/tagged.js":
/*!********************************************************!*\
  !*** ./node_modules/inversify/es/annotation/tagged.js ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "tagged": function() { return /* binding */ tagged; }
/* harmony export */ });
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _decorator_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./decorator_utils */ "./node_modules/inversify/es/annotation/decorator_utils.js");


function tagged(metadataKey, metadataValue) {
    return (0,_decorator_utils__WEBPACK_IMPORTED_MODULE_0__.createTaggedDecorator)(new _planning_metadata__WEBPACK_IMPORTED_MODULE_1__.Metadata(metadataKey, metadataValue));
}

//# sourceMappingURL=tagged.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/target_name.js":
/*!*************************************************************!*\
  !*** ./node_modules/inversify/es/annotation/target_name.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "targetName": function() { return /* binding */ targetName; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _decorator_utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./decorator_utils */ "./node_modules/inversify/es/annotation/decorator_utils.js");



function targetName(name) {
    return function (target, targetKey, index) {
        var metadata = new _planning_metadata__WEBPACK_IMPORTED_MODULE_0__.Metadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.NAME_TAG, name);
        (0,_decorator_utils__WEBPACK_IMPORTED_MODULE_2__.tagParameter)(target, targetKey, index, metadata);
    };
}

//# sourceMappingURL=target_name.js.map

/***/ }),

/***/ "./node_modules/inversify/es/annotation/unmanaged.js":
/*!***********************************************************!*\
  !*** ./node_modules/inversify/es/annotation/unmanaged.js ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "unmanaged": function() { return /* binding */ unmanaged; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _decorator_utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./decorator_utils */ "./node_modules/inversify/es/annotation/decorator_utils.js");



function unmanaged() {
    return function (target, targetKey, index) {
        var metadata = new _planning_metadata__WEBPACK_IMPORTED_MODULE_0__.Metadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.UNMANAGED_TAG, true);
        (0,_decorator_utils__WEBPACK_IMPORTED_MODULE_2__.tagParameter)(target, targetKey, index, metadata);
    };
}

//# sourceMappingURL=unmanaged.js.map

/***/ }),

/***/ "./node_modules/inversify/es/bindings/binding.js":
/*!*******************************************************!*\
  !*** ./node_modules/inversify/es/bindings/binding.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Binding": function() { return /* binding */ Binding; }
/* harmony export */ });
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _utils_id__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/id */ "./node_modules/inversify/es/utils/id.js");


var Binding = (function () {
    function Binding(serviceIdentifier, scope) {
        this.id = (0,_utils_id__WEBPACK_IMPORTED_MODULE_0__.id)();
        this.activated = false;
        this.serviceIdentifier = serviceIdentifier;
        this.scope = scope;
        this.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.BindingTypeEnum.Invalid;
        this.constraint = function (request) { return true; };
        this.implementationType = null;
        this.cache = null;
        this.factory = null;
        this.provider = null;
        this.onActivation = null;
        this.onDeactivation = null;
        this.dynamicValue = null;
    }
    Binding.prototype.clone = function () {
        var clone = new Binding(this.serviceIdentifier, this.scope);
        clone.activated = (clone.scope === _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.BindingScopeEnum.Singleton) ? this.activated : false;
        clone.implementationType = this.implementationType;
        clone.dynamicValue = this.dynamicValue;
        clone.scope = this.scope;
        clone.type = this.type;
        clone.factory = this.factory;
        clone.provider = this.provider;
        clone.constraint = this.constraint;
        clone.onActivation = this.onActivation;
        clone.onDeactivation = this.onDeactivation;
        clone.cache = this.cache;
        return clone;
    };
    return Binding;
}());

//# sourceMappingURL=binding.js.map

/***/ }),

/***/ "./node_modules/inversify/es/bindings/binding_count.js":
/*!*************************************************************!*\
  !*** ./node_modules/inversify/es/bindings/binding_count.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingCount": function() { return /* binding */ BindingCount; }
/* harmony export */ });
var BindingCount = {
    MultipleBindingsAvailable: 2,
    NoBindingsAvailable: 0,
    OnlyOneBindingAvailable: 1
};

//# sourceMappingURL=binding_count.js.map

/***/ }),

/***/ "./node_modules/inversify/es/constants/error_msgs.js":
/*!***********************************************************!*\
  !*** ./node_modules/inversify/es/constants/error_msgs.js ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "DUPLICATED_INJECTABLE_DECORATOR": function() { return /* binding */ DUPLICATED_INJECTABLE_DECORATOR; },
/* harmony export */   "DUPLICATED_METADATA": function() { return /* binding */ DUPLICATED_METADATA; },
/* harmony export */   "NULL_ARGUMENT": function() { return /* binding */ NULL_ARGUMENT; },
/* harmony export */   "KEY_NOT_FOUND": function() { return /* binding */ KEY_NOT_FOUND; },
/* harmony export */   "AMBIGUOUS_MATCH": function() { return /* binding */ AMBIGUOUS_MATCH; },
/* harmony export */   "CANNOT_UNBIND": function() { return /* binding */ CANNOT_UNBIND; },
/* harmony export */   "NOT_REGISTERED": function() { return /* binding */ NOT_REGISTERED; },
/* harmony export */   "MISSING_INJECTABLE_ANNOTATION": function() { return /* binding */ MISSING_INJECTABLE_ANNOTATION; },
/* harmony export */   "MISSING_INJECT_ANNOTATION": function() { return /* binding */ MISSING_INJECT_ANNOTATION; },
/* harmony export */   "UNDEFINED_INJECT_ANNOTATION": function() { return /* binding */ UNDEFINED_INJECT_ANNOTATION; },
/* harmony export */   "CIRCULAR_DEPENDENCY": function() { return /* binding */ CIRCULAR_DEPENDENCY; },
/* harmony export */   "NOT_IMPLEMENTED": function() { return /* binding */ NOT_IMPLEMENTED; },
/* harmony export */   "INVALID_BINDING_TYPE": function() { return /* binding */ INVALID_BINDING_TYPE; },
/* harmony export */   "NO_MORE_SNAPSHOTS_AVAILABLE": function() { return /* binding */ NO_MORE_SNAPSHOTS_AVAILABLE; },
/* harmony export */   "INVALID_MIDDLEWARE_RETURN": function() { return /* binding */ INVALID_MIDDLEWARE_RETURN; },
/* harmony export */   "INVALID_FUNCTION_BINDING": function() { return /* binding */ INVALID_FUNCTION_BINDING; },
/* harmony export */   "LAZY_IN_SYNC": function() { return /* binding */ LAZY_IN_SYNC; },
/* harmony export */   "INVALID_TO_SELF_VALUE": function() { return /* binding */ INVALID_TO_SELF_VALUE; },
/* harmony export */   "INVALID_DECORATOR_OPERATION": function() { return /* binding */ INVALID_DECORATOR_OPERATION; },
/* harmony export */   "ARGUMENTS_LENGTH_MISMATCH": function() { return /* binding */ ARGUMENTS_LENGTH_MISMATCH; },
/* harmony export */   "CONTAINER_OPTIONS_MUST_BE_AN_OBJECT": function() { return /* binding */ CONTAINER_OPTIONS_MUST_BE_AN_OBJECT; },
/* harmony export */   "CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE": function() { return /* binding */ CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE; },
/* harmony export */   "CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE": function() { return /* binding */ CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE; },
/* harmony export */   "CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK": function() { return /* binding */ CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK; },
/* harmony export */   "MULTIPLE_PRE_DESTROY_METHODS": function() { return /* binding */ MULTIPLE_PRE_DESTROY_METHODS; },
/* harmony export */   "MULTIPLE_POST_CONSTRUCT_METHODS": function() { return /* binding */ MULTIPLE_POST_CONSTRUCT_METHODS; },
/* harmony export */   "ASYNC_UNBIND_REQUIRED": function() { return /* binding */ ASYNC_UNBIND_REQUIRED; },
/* harmony export */   "POST_CONSTRUCT_ERROR": function() { return /* binding */ POST_CONSTRUCT_ERROR; },
/* harmony export */   "PRE_DESTROY_ERROR": function() { return /* binding */ PRE_DESTROY_ERROR; },
/* harmony export */   "ON_DEACTIVATION_ERROR": function() { return /* binding */ ON_DEACTIVATION_ERROR; },
/* harmony export */   "CIRCULAR_DEPENDENCY_IN_FACTORY": function() { return /* binding */ CIRCULAR_DEPENDENCY_IN_FACTORY; },
/* harmony export */   "STACK_OVERFLOW": function() { return /* binding */ STACK_OVERFLOW; }
/* harmony export */ });
var DUPLICATED_INJECTABLE_DECORATOR = "Cannot apply @injectable decorator multiple times.";
var DUPLICATED_METADATA = "Metadata key was used more than once in a parameter:";
var NULL_ARGUMENT = "NULL argument";
var KEY_NOT_FOUND = "Key Not Found";
var AMBIGUOUS_MATCH = "Ambiguous match found for serviceIdentifier:";
var CANNOT_UNBIND = "Could not unbind serviceIdentifier:";
var NOT_REGISTERED = "No matching bindings found for serviceIdentifier:";
var MISSING_INJECTABLE_ANNOTATION = "Missing required @injectable annotation in:";
var MISSING_INJECT_ANNOTATION = "Missing required @inject or @multiInject annotation in:";
var UNDEFINED_INJECT_ANNOTATION = function (name) {
    return "@inject called with undefined this could mean that the class " + name + " has " +
        "a circular dependency problem. You can use a LazyServiceIdentifer to  " +
        "overcome this limitation.";
};
var CIRCULAR_DEPENDENCY = "Circular dependency found:";
var NOT_IMPLEMENTED = "Sorry, this feature is not fully implemented yet.";
var INVALID_BINDING_TYPE = "Invalid binding type:";
var NO_MORE_SNAPSHOTS_AVAILABLE = "No snapshot available to restore.";
var INVALID_MIDDLEWARE_RETURN = "Invalid return type in middleware. Middleware must return!";
var INVALID_FUNCTION_BINDING = "Value provided to function binding must be a function!";
var LAZY_IN_SYNC = function (key) { return "You are attempting to construct '" + key + "' in a synchronous way\n but it has asynchronous dependencies."; };
var INVALID_TO_SELF_VALUE = "The toSelf function can only be applied when a constructor is " +
    "used as service identifier";
var INVALID_DECORATOR_OPERATION = "The @inject @multiInject @tagged and @named decorators " +
    "must be applied to the parameters of a class constructor or a class property.";
var ARGUMENTS_LENGTH_MISMATCH = function () {
    var values = [];
    for (var _i = 0; _i < arguments.length; _i++) {
        values[_i] = arguments[_i];
    }
    return "The number of constructor arguments in the derived class " +
        (values[0] + " must be >= than the number of constructor arguments of its base class.");
};
var CONTAINER_OPTIONS_MUST_BE_AN_OBJECT = "Invalid Container constructor argument. Container options " +
    "must be an object.";
var CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE = "Invalid Container option. Default scope must " +
    "be a string ('singleton' or 'transient').";
var CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE = "Invalid Container option. Auto bind injectable must " +
    "be a boolean";
var CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK = "Invalid Container option. Skip base check must " +
    "be a boolean";
var MULTIPLE_PRE_DESTROY_METHODS = "Cannot apply @preDestroy decorator multiple times in the same class";
var MULTIPLE_POST_CONSTRUCT_METHODS = "Cannot apply @postConstruct decorator multiple times in the same class";
var ASYNC_UNBIND_REQUIRED = "Attempting to unbind dependency with asynchronous destruction (@preDestroy or onDeactivation)";
var POST_CONSTRUCT_ERROR = function (clazz, errorMessage) { return "@postConstruct error in class " + clazz + ": " + errorMessage; };
var PRE_DESTROY_ERROR = function (clazz, errorMessage) { return "@preDestroy error in class " + clazz + ": " + errorMessage; };
var ON_DEACTIVATION_ERROR = function (clazz, errorMessage) { return "onDeactivation() error in class " + clazz + ": " + errorMessage; };
var CIRCULAR_DEPENDENCY_IN_FACTORY = function (factoryType, serviceIdentifier) {
    return "It looks like there is a circular dependency in one of the '" + factoryType + "' bindings. Please investigate bindings with" +
        ("service identifier '" + serviceIdentifier + "'.");
};
var STACK_OVERFLOW = "Maximum call stack size exceeded";
//# sourceMappingURL=error_msgs.js.map

/***/ }),

/***/ "./node_modules/inversify/es/constants/literal_types.js":
/*!**************************************************************!*\
  !*** ./node_modules/inversify/es/constants/literal_types.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingScopeEnum": function() { return /* binding */ BindingScopeEnum; },
/* harmony export */   "BindingTypeEnum": function() { return /* binding */ BindingTypeEnum; },
/* harmony export */   "TargetTypeEnum": function() { return /* binding */ TargetTypeEnum; }
/* harmony export */ });
var BindingScopeEnum = {
    Request: "Request",
    Singleton: "Singleton",
    Transient: "Transient"
};
var BindingTypeEnum = {
    ConstantValue: "ConstantValue",
    Constructor: "Constructor",
    DynamicValue: "DynamicValue",
    Factory: "Factory",
    Function: "Function",
    Instance: "Instance",
    Invalid: "Invalid",
    Provider: "Provider"
};
var TargetTypeEnum = {
    ClassProperty: "ClassProperty",
    ConstructorArgument: "ConstructorArgument",
    Variable: "Variable"
};

//# sourceMappingURL=literal_types.js.map

/***/ }),

/***/ "./node_modules/inversify/es/constants/metadata_keys.js":
/*!**************************************************************!*\
  !*** ./node_modules/inversify/es/constants/metadata_keys.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "NAMED_TAG": function() { return /* binding */ NAMED_TAG; },
/* harmony export */   "NAME_TAG": function() { return /* binding */ NAME_TAG; },
/* harmony export */   "UNMANAGED_TAG": function() { return /* binding */ UNMANAGED_TAG; },
/* harmony export */   "OPTIONAL_TAG": function() { return /* binding */ OPTIONAL_TAG; },
/* harmony export */   "INJECT_TAG": function() { return /* binding */ INJECT_TAG; },
/* harmony export */   "MULTI_INJECT_TAG": function() { return /* binding */ MULTI_INJECT_TAG; },
/* harmony export */   "TAGGED": function() { return /* binding */ TAGGED; },
/* harmony export */   "TAGGED_PROP": function() { return /* binding */ TAGGED_PROP; },
/* harmony export */   "PARAM_TYPES": function() { return /* binding */ PARAM_TYPES; },
/* harmony export */   "DESIGN_PARAM_TYPES": function() { return /* binding */ DESIGN_PARAM_TYPES; },
/* harmony export */   "POST_CONSTRUCT": function() { return /* binding */ POST_CONSTRUCT; },
/* harmony export */   "PRE_DESTROY": function() { return /* binding */ PRE_DESTROY; },
/* harmony export */   "NON_CUSTOM_TAG_KEYS": function() { return /* binding */ NON_CUSTOM_TAG_KEYS; }
/* harmony export */ });
var NAMED_TAG = "named";
var NAME_TAG = "name";
var UNMANAGED_TAG = "unmanaged";
var OPTIONAL_TAG = "optional";
var INJECT_TAG = "inject";
var MULTI_INJECT_TAG = "multi_inject";
var TAGGED = "inversify:tagged";
var TAGGED_PROP = "inversify:tagged_props";
var PARAM_TYPES = "inversify:paramtypes";
var DESIGN_PARAM_TYPES = "design:paramtypes";
var POST_CONSTRUCT = "post_construct";
var PRE_DESTROY = "pre_destroy";
function getNonCustomTagKeys() {
    return [
        INJECT_TAG,
        MULTI_INJECT_TAG,
        NAME_TAG,
        UNMANAGED_TAG,
        NAMED_TAG,
        OPTIONAL_TAG,
    ];
}
var NON_CUSTOM_TAG_KEYS = getNonCustomTagKeys();
//# sourceMappingURL=metadata_keys.js.map

/***/ }),

/***/ "./node_modules/inversify/es/container/container.js":
/*!**********************************************************!*\
  !*** ./node_modules/inversify/es/container/container.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Container": function() { return /* binding */ Container; }
/* harmony export */ });
/* harmony import */ var _bindings_binding__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../bindings/binding */ "./node_modules/inversify/es/bindings/binding.js");
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _planning_metadata_reader__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../planning/metadata_reader */ "./node_modules/inversify/es/planning/metadata_reader.js");
/* harmony import */ var _planning_planner__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../planning/planner */ "./node_modules/inversify/es/planning/planner.js");
/* harmony import */ var _resolution_resolver__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ../resolution/resolver */ "./node_modules/inversify/es/resolution/resolver.js");
/* harmony import */ var _syntax_binding_to_syntax__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../syntax/binding_to_syntax */ "./node_modules/inversify/es/syntax/binding_to_syntax.js");
/* harmony import */ var _utils_async__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../utils/async */ "./node_modules/inversify/es/utils/async.js");
/* harmony import */ var _utils_id__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/id */ "./node_modules/inversify/es/utils/id.js");
/* harmony import */ var _utils_serialization__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ../utils/serialization */ "./node_modules/inversify/es/utils/serialization.js");
/* harmony import */ var _container_snapshot__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./container_snapshot */ "./node_modules/inversify/es/container/container_snapshot.js");
/* harmony import */ var _lookup__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./lookup */ "./node_modules/inversify/es/container/lookup.js");
/* harmony import */ var _module_activation_store__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./module_activation_store */ "./node_modules/inversify/es/container/module_activation_store.js");
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
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (undefined && undefined.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var __spreadArray = (undefined && undefined.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};














var Container = (function () {
    function Container(containerOptions) {
        var options = containerOptions || {};
        if (typeof options !== "object") {
            throw new Error("" + _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.CONTAINER_OPTIONS_MUST_BE_AN_OBJECT);
        }
        if (options.defaultScope === undefined) {
            options.defaultScope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.BindingScopeEnum.Transient;
        }
        else if (options.defaultScope !== _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.BindingScopeEnum.Singleton &&
            options.defaultScope !== _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.BindingScopeEnum.Transient &&
            options.defaultScope !== _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.BindingScopeEnum.Request) {
            throw new Error("" + _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE);
        }
        if (options.autoBindInjectable === undefined) {
            options.autoBindInjectable = false;
        }
        else if (typeof options.autoBindInjectable !== "boolean") {
            throw new Error("" + _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE);
        }
        if (options.skipBaseClassChecks === undefined) {
            options.skipBaseClassChecks = false;
        }
        else if (typeof options.skipBaseClassChecks !== "boolean") {
            throw new Error("" + _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK);
        }
        this.options = {
            autoBindInjectable: options.autoBindInjectable,
            defaultScope: options.defaultScope,
            skipBaseClassChecks: options.skipBaseClassChecks
        };
        this.id = (0,_utils_id__WEBPACK_IMPORTED_MODULE_2__.id)();
        this._bindingDictionary = new _lookup__WEBPACK_IMPORTED_MODULE_3__.Lookup();
        this._snapshots = [];
        this._middleware = null;
        this._activations = new _lookup__WEBPACK_IMPORTED_MODULE_3__.Lookup();
        this._deactivations = new _lookup__WEBPACK_IMPORTED_MODULE_3__.Lookup();
        this.parent = null;
        this._metadataReader = new _planning_metadata_reader__WEBPACK_IMPORTED_MODULE_4__.MetadataReader();
        this._moduleActivationStore = new _module_activation_store__WEBPACK_IMPORTED_MODULE_5__.ModuleActivationStore();
    }
    Container.merge = function (container1, container2) {
        var containers = [];
        for (var _i = 2; _i < arguments.length; _i++) {
            containers[_i - 2] = arguments[_i];
        }
        var container = new Container();
        var targetContainers = __spreadArray([container1, container2], containers, true).map(function (targetContainer) { return (0,_planning_planner__WEBPACK_IMPORTED_MODULE_6__.getBindingDictionary)(targetContainer); });
        var bindingDictionary = (0,_planning_planner__WEBPACK_IMPORTED_MODULE_6__.getBindingDictionary)(container);
        function copyDictionary(origin, destination) {
            origin.traverse(function (_key, value) {
                value.forEach(function (binding) {
                    destination.add(binding.serviceIdentifier, binding.clone());
                });
            });
        }
        targetContainers.forEach(function (targetBindingDictionary) {
            copyDictionary(targetBindingDictionary, bindingDictionary);
        });
        return container;
    };
    Container.prototype.load = function () {
        var modules = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            modules[_i] = arguments[_i];
        }
        var getHelpers = this._getContainerModuleHelpersFactory();
        for (var _a = 0, modules_1 = modules; _a < modules_1.length; _a++) {
            var currentModule = modules_1[_a];
            var containerModuleHelpers = getHelpers(currentModule.id);
            currentModule.registry(containerModuleHelpers.bindFunction, containerModuleHelpers.unbindFunction, containerModuleHelpers.isboundFunction, containerModuleHelpers.rebindFunction, containerModuleHelpers.unbindAsyncFunction, containerModuleHelpers.onActivationFunction, containerModuleHelpers.onDeactivationFunction);
        }
    };
    Container.prototype.loadAsync = function () {
        var modules = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            modules[_i] = arguments[_i];
        }
        return __awaiter(this, void 0, void 0, function () {
            var getHelpers, _a, modules_2, currentModule, containerModuleHelpers;
            return __generator(this, function (_b) {
                switch (_b.label) {
                    case 0:
                        getHelpers = this._getContainerModuleHelpersFactory();
                        _a = 0, modules_2 = modules;
                        _b.label = 1;
                    case 1:
                        if (!(_a < modules_2.length)) return [3, 4];
                        currentModule = modules_2[_a];
                        containerModuleHelpers = getHelpers(currentModule.id);
                        return [4, currentModule.registry(containerModuleHelpers.bindFunction, containerModuleHelpers.unbindFunction, containerModuleHelpers.isboundFunction, containerModuleHelpers.rebindFunction, containerModuleHelpers.unbindAsyncFunction, containerModuleHelpers.onActivationFunction, containerModuleHelpers.onDeactivationFunction)];
                    case 2:
                        _b.sent();
                        _b.label = 3;
                    case 3:
                        _a++;
                        return [3, 1];
                    case 4: return [2];
                }
            });
        });
    };
    Container.prototype.unload = function () {
        var _this = this;
        var modules = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            modules[_i] = arguments[_i];
        }
        modules.forEach(function (module) {
            var deactivations = _this._removeModuleBindings(module.id);
            _this._deactivateSingletons(deactivations);
            _this._removeModuleHandlers(module.id);
        });
    };
    Container.prototype.unloadAsync = function () {
        var modules = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            modules[_i] = arguments[_i];
        }
        return __awaiter(this, void 0, void 0, function () {
            var _a, modules_3, module_1, deactivations;
            return __generator(this, function (_b) {
                switch (_b.label) {
                    case 0:
                        _a = 0, modules_3 = modules;
                        _b.label = 1;
                    case 1:
                        if (!(_a < modules_3.length)) return [3, 4];
                        module_1 = modules_3[_a];
                        deactivations = this._removeModuleBindings(module_1.id);
                        return [4, this._deactivateSingletonsAsync(deactivations)];
                    case 2:
                        _b.sent();
                        this._removeModuleHandlers(module_1.id);
                        _b.label = 3;
                    case 3:
                        _a++;
                        return [3, 1];
                    case 4: return [2];
                }
            });
        });
    };
    Container.prototype.bind = function (serviceIdentifier) {
        var scope = this.options.defaultScope || _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.BindingScopeEnum.Transient;
        var binding = new _bindings_binding__WEBPACK_IMPORTED_MODULE_7__.Binding(serviceIdentifier, scope);
        this._bindingDictionary.add(serviceIdentifier, binding);
        return new _syntax_binding_to_syntax__WEBPACK_IMPORTED_MODULE_8__.BindingToSyntax(binding);
    };
    Container.prototype.rebind = function (serviceIdentifier) {
        this.unbind(serviceIdentifier);
        return this.bind(serviceIdentifier);
    };
    Container.prototype.rebindAsync = function (serviceIdentifier) {
        return __awaiter(this, void 0, void 0, function () {
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0: return [4, this.unbindAsync(serviceIdentifier)];
                    case 1:
                        _a.sent();
                        return [2, this.bind(serviceIdentifier)];
                }
            });
        });
    };
    Container.prototype.unbind = function (serviceIdentifier) {
        if (this._bindingDictionary.hasKey(serviceIdentifier)) {
            var bindings = this._bindingDictionary.get(serviceIdentifier);
            this._deactivateSingletons(bindings);
        }
        this._removeServiceFromDictionary(serviceIdentifier);
    };
    Container.prototype.unbindAsync = function (serviceIdentifier) {
        return __awaiter(this, void 0, void 0, function () {
            var bindings;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        if (!this._bindingDictionary.hasKey(serviceIdentifier)) return [3, 2];
                        bindings = this._bindingDictionary.get(serviceIdentifier);
                        return [4, this._deactivateSingletonsAsync(bindings)];
                    case 1:
                        _a.sent();
                        _a.label = 2;
                    case 2:
                        this._removeServiceFromDictionary(serviceIdentifier);
                        return [2];
                }
            });
        });
    };
    Container.prototype.unbindAll = function () {
        var _this = this;
        this._bindingDictionary.traverse(function (_key, value) {
            _this._deactivateSingletons(value);
        });
        this._bindingDictionary = new _lookup__WEBPACK_IMPORTED_MODULE_3__.Lookup();
    };
    Container.prototype.unbindAllAsync = function () {
        return __awaiter(this, void 0, void 0, function () {
            var promises;
            var _this = this;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        promises = [];
                        this._bindingDictionary.traverse(function (_key, value) {
                            promises.push(_this._deactivateSingletonsAsync(value));
                        });
                        return [4, Promise.all(promises)];
                    case 1:
                        _a.sent();
                        this._bindingDictionary = new _lookup__WEBPACK_IMPORTED_MODULE_3__.Lookup();
                        return [2];
                }
            });
        });
    };
    Container.prototype.onActivation = function (serviceIdentifier, onActivation) {
        this._activations.add(serviceIdentifier, onActivation);
    };
    Container.prototype.onDeactivation = function (serviceIdentifier, onDeactivation) {
        this._deactivations.add(serviceIdentifier, onDeactivation);
    };
    Container.prototype.isBound = function (serviceIdentifier) {
        var bound = this._bindingDictionary.hasKey(serviceIdentifier);
        if (!bound && this.parent) {
            bound = this.parent.isBound(serviceIdentifier);
        }
        return bound;
    };
    Container.prototype.isCurrentBound = function (serviceIdentifier) {
        return this._bindingDictionary.hasKey(serviceIdentifier);
    };
    Container.prototype.isBoundNamed = function (serviceIdentifier, named) {
        return this.isBoundTagged(serviceIdentifier, _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__.NAMED_TAG, named);
    };
    Container.prototype.isBoundTagged = function (serviceIdentifier, key, value) {
        var bound = false;
        if (this._bindingDictionary.hasKey(serviceIdentifier)) {
            var bindings = this._bindingDictionary.get(serviceIdentifier);
            var request_1 = (0,_planning_planner__WEBPACK_IMPORTED_MODULE_6__.createMockRequest)(this, serviceIdentifier, key, value);
            bound = bindings.some(function (b) { return b.constraint(request_1); });
        }
        if (!bound && this.parent) {
            bound = this.parent.isBoundTagged(serviceIdentifier, key, value);
        }
        return bound;
    };
    Container.prototype.snapshot = function () {
        this._snapshots.push(_container_snapshot__WEBPACK_IMPORTED_MODULE_10__.ContainerSnapshot.of(this._bindingDictionary.clone(), this._middleware, this._activations.clone(), this._deactivations.clone(), this._moduleActivationStore.clone()));
    };
    Container.prototype.restore = function () {
        var snapshot = this._snapshots.pop();
        if (snapshot === undefined) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.NO_MORE_SNAPSHOTS_AVAILABLE);
        }
        this._bindingDictionary = snapshot.bindings;
        this._activations = snapshot.activations;
        this._deactivations = snapshot.deactivations;
        this._middleware = snapshot.middleware;
        this._moduleActivationStore = snapshot.moduleActivationStore;
    };
    Container.prototype.createChild = function (containerOptions) {
        var child = new Container(containerOptions || this.options);
        child.parent = this;
        return child;
    };
    Container.prototype.applyMiddleware = function () {
        var middlewares = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            middlewares[_i] = arguments[_i];
        }
        var initial = (this._middleware) ? this._middleware : this._planAndResolve();
        this._middleware = middlewares.reduce(function (prev, curr) { return curr(prev); }, initial);
    };
    Container.prototype.applyCustomMetadataReader = function (metadataReader) {
        this._metadataReader = metadataReader;
    };
    Container.prototype.get = function (serviceIdentifier) {
        var getArgs = this._getNotAllArgs(serviceIdentifier, false);
        return this._getButThrowIfAsync(getArgs);
    };
    Container.prototype.getAsync = function (serviceIdentifier) {
        return __awaiter(this, void 0, void 0, function () {
            var getArgs;
            return __generator(this, function (_a) {
                getArgs = this._getNotAllArgs(serviceIdentifier, false);
                return [2, this._get(getArgs)];
            });
        });
    };
    Container.prototype.getTagged = function (serviceIdentifier, key, value) {
        var getArgs = this._getNotAllArgs(serviceIdentifier, false, key, value);
        return this._getButThrowIfAsync(getArgs);
    };
    Container.prototype.getTaggedAsync = function (serviceIdentifier, key, value) {
        return __awaiter(this, void 0, void 0, function () {
            var getArgs;
            return __generator(this, function (_a) {
                getArgs = this._getNotAllArgs(serviceIdentifier, false, key, value);
                return [2, this._get(getArgs)];
            });
        });
    };
    Container.prototype.getNamed = function (serviceIdentifier, named) {
        return this.getTagged(serviceIdentifier, _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__.NAMED_TAG, named);
    };
    Container.prototype.getNamedAsync = function (serviceIdentifier, named) {
        return this.getTaggedAsync(serviceIdentifier, _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__.NAMED_TAG, named);
    };
    Container.prototype.getAll = function (serviceIdentifier) {
        var getArgs = this._getAllArgs(serviceIdentifier);
        return this._getButThrowIfAsync(getArgs);
    };
    Container.prototype.getAllAsync = function (serviceIdentifier) {
        var getArgs = this._getAllArgs(serviceIdentifier);
        return this._getAll(getArgs);
    };
    Container.prototype.getAllTagged = function (serviceIdentifier, key, value) {
        var getArgs = this._getNotAllArgs(serviceIdentifier, true, key, value);
        return this._getButThrowIfAsync(getArgs);
    };
    Container.prototype.getAllTaggedAsync = function (serviceIdentifier, key, value) {
        var getArgs = this._getNotAllArgs(serviceIdentifier, true, key, value);
        return this._getAll(getArgs);
    };
    Container.prototype.getAllNamed = function (serviceIdentifier, named) {
        return this.getAllTagged(serviceIdentifier, _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__.NAMED_TAG, named);
    };
    Container.prototype.getAllNamedAsync = function (serviceIdentifier, named) {
        return this.getAllTaggedAsync(serviceIdentifier, _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__.NAMED_TAG, named);
    };
    Container.prototype.resolve = function (constructorFunction) {
        var isBound = this.isBound(constructorFunction);
        if (!isBound) {
            this.bind(constructorFunction).toSelf();
        }
        var resolved = this.get(constructorFunction);
        if (!isBound) {
            this.unbind(constructorFunction);
        }
        return resolved;
    };
    Container.prototype._preDestroy = function (constructor, instance) {
        if (Reflect.hasMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__.PRE_DESTROY, constructor)) {
            var data = Reflect.getMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_9__.PRE_DESTROY, constructor);
            return instance[data.value]();
        }
    };
    Container.prototype._removeModuleHandlers = function (moduleId) {
        var moduleActivationsHandlers = this._moduleActivationStore.remove(moduleId);
        this._activations.removeIntersection(moduleActivationsHandlers.onActivations);
        this._deactivations.removeIntersection(moduleActivationsHandlers.onDeactivations);
    };
    Container.prototype._removeModuleBindings = function (moduleId) {
        return this._bindingDictionary.removeByCondition(function (binding) { return binding.moduleId === moduleId; });
    };
    Container.prototype._deactivate = function (binding, instance) {
        var _this = this;
        var constructor = Object.getPrototypeOf(instance).constructor;
        try {
            if (this._deactivations.hasKey(binding.serviceIdentifier)) {
                var result = this._deactivateContainer(instance, this._deactivations.get(binding.serviceIdentifier).values());
                if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_11__.isPromise)(result)) {
                    return this._handleDeactivationError(result.then(function () { return _this._propagateContainerDeactivationThenBindingAndPreDestroyAsync(binding, instance, constructor); }), constructor);
                }
            }
            var propagateDeactivationResult = this._propagateContainerDeactivationThenBindingAndPreDestroy(binding, instance, constructor);
            if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_11__.isPromise)(propagateDeactivationResult)) {
                return this._handleDeactivationError(propagateDeactivationResult, constructor);
            }
        }
        catch (ex) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.ON_DEACTIVATION_ERROR(constructor.name, ex.message));
        }
    };
    Container.prototype._handleDeactivationError = function (asyncResult, constructor) {
        return __awaiter(this, void 0, void 0, function () {
            var ex_1;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        _a.trys.push([0, 2, , 3]);
                        return [4, asyncResult];
                    case 1:
                        _a.sent();
                        return [3, 3];
                    case 2:
                        ex_1 = _a.sent();
                        throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.ON_DEACTIVATION_ERROR(constructor.name, ex_1.message));
                    case 3: return [2];
                }
            });
        });
    };
    Container.prototype._deactivateContainer = function (instance, deactivationsIterator) {
        var _this = this;
        var deactivation = deactivationsIterator.next();
        while (deactivation.value) {
            var result = deactivation.value(instance);
            if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_11__.isPromise)(result)) {
                return result.then(function () {
                    return _this._deactivateContainerAsync(instance, deactivationsIterator);
                });
            }
            deactivation = deactivationsIterator.next();
        }
    };
    Container.prototype._deactivateContainerAsync = function (instance, deactivationsIterator) {
        return __awaiter(this, void 0, void 0, function () {
            var deactivation;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        deactivation = deactivationsIterator.next();
                        _a.label = 1;
                    case 1:
                        if (!deactivation.value) return [3, 3];
                        return [4, deactivation.value(instance)];
                    case 2:
                        _a.sent();
                        deactivation = deactivationsIterator.next();
                        return [3, 1];
                    case 3: return [2];
                }
            });
        });
    };
    Container.prototype._getContainerModuleHelpersFactory = function () {
        var _this = this;
        var setModuleId = function (bindingToSyntax, moduleId) {
            bindingToSyntax._binding.moduleId = moduleId;
        };
        var getBindFunction = function (moduleId) {
            return function (serviceIdentifier) {
                var bindingToSyntax = _this.bind(serviceIdentifier);
                setModuleId(bindingToSyntax, moduleId);
                return bindingToSyntax;
            };
        };
        var getUnbindFunction = function () {
            return function (serviceIdentifier) {
                return _this.unbind(serviceIdentifier);
            };
        };
        var getUnbindAsyncFunction = function () {
            return function (serviceIdentifier) {
                return _this.unbindAsync(serviceIdentifier);
            };
        };
        var getIsboundFunction = function () {
            return function (serviceIdentifier) {
                return _this.isBound(serviceIdentifier);
            };
        };
        var getRebindFunction = function (moduleId) {
            return function (serviceIdentifier) {
                var bindingToSyntax = _this.rebind(serviceIdentifier);
                setModuleId(bindingToSyntax, moduleId);
                return bindingToSyntax;
            };
        };
        var getOnActivationFunction = function (moduleId) {
            return function (serviceIdentifier, onActivation) {
                _this._moduleActivationStore.addActivation(moduleId, serviceIdentifier, onActivation);
                _this.onActivation(serviceIdentifier, onActivation);
            };
        };
        var getOnDeactivationFunction = function (moduleId) {
            return function (serviceIdentifier, onDeactivation) {
                _this._moduleActivationStore.addDeactivation(moduleId, serviceIdentifier, onDeactivation);
                _this.onDeactivation(serviceIdentifier, onDeactivation);
            };
        };
        return function (mId) { return ({
            bindFunction: getBindFunction(mId),
            isboundFunction: getIsboundFunction(),
            onActivationFunction: getOnActivationFunction(mId),
            onDeactivationFunction: getOnDeactivationFunction(mId),
            rebindFunction: getRebindFunction(mId),
            unbindFunction: getUnbindFunction(),
            unbindAsyncFunction: getUnbindAsyncFunction()
        }); };
    };
    Container.prototype._getAll = function (getArgs) {
        return Promise.all(this._get(getArgs));
    };
    Container.prototype._get = function (getArgs) {
        var planAndResolveArgs = __assign(__assign({}, getArgs), { contextInterceptor: function (context) { return context; }, targetType: _constants_literal_types__WEBPACK_IMPORTED_MODULE_1__.TargetTypeEnum.Variable });
        if (this._middleware) {
            var middlewareResult = this._middleware(planAndResolveArgs);
            if (middlewareResult === undefined || middlewareResult === null) {
                throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.INVALID_MIDDLEWARE_RETURN);
            }
            return middlewareResult;
        }
        return this._planAndResolve()(planAndResolveArgs);
    };
    Container.prototype._getButThrowIfAsync = function (getArgs) {
        var result = this._get(getArgs);
        if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_11__.isPromiseOrContainsPromise)(result)) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.LAZY_IN_SYNC(getArgs.serviceIdentifier));
        }
        return result;
    };
    Container.prototype._getAllArgs = function (serviceIdentifier) {
        var getAllArgs = {
            avoidConstraints: true,
            isMultiInject: true,
            serviceIdentifier: serviceIdentifier,
        };
        return getAllArgs;
    };
    Container.prototype._getNotAllArgs = function (serviceIdentifier, isMultiInject, key, value) {
        var getNotAllArgs = {
            avoidConstraints: false,
            isMultiInject: isMultiInject,
            serviceIdentifier: serviceIdentifier,
            key: key,
            value: value,
        };
        return getNotAllArgs;
    };
    Container.prototype._planAndResolve = function () {
        var _this = this;
        return function (args) {
            var context = (0,_planning_planner__WEBPACK_IMPORTED_MODULE_6__.plan)(_this._metadataReader, _this, args.isMultiInject, args.targetType, args.serviceIdentifier, args.key, args.value, args.avoidConstraints);
            context = args.contextInterceptor(context);
            var result = (0,_resolution_resolver__WEBPACK_IMPORTED_MODULE_12__.resolve)(context);
            return result;
        };
    };
    Container.prototype._deactivateIfSingleton = function (binding) {
        var _this = this;
        if (!binding.activated) {
            return;
        }
        if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_11__.isPromise)(binding.cache)) {
            return binding.cache.then(function (resolved) { return _this._deactivate(binding, resolved); });
        }
        return this._deactivate(binding, binding.cache);
    };
    Container.prototype._deactivateSingletons = function (bindings) {
        for (var _i = 0, bindings_1 = bindings; _i < bindings_1.length; _i++) {
            var binding = bindings_1[_i];
            var result = this._deactivateIfSingleton(binding);
            if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_11__.isPromise)(result)) {
                throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.ASYNC_UNBIND_REQUIRED);
            }
        }
    };
    Container.prototype._deactivateSingletonsAsync = function (bindings) {
        return __awaiter(this, void 0, void 0, function () {
            var _this = this;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0: return [4, Promise.all(bindings.map(function (b) { return _this._deactivateIfSingleton(b); }))];
                    case 1:
                        _a.sent();
                        return [2];
                }
            });
        });
    };
    Container.prototype._propagateContainerDeactivationThenBindingAndPreDestroy = function (binding, instance, constructor) {
        if (this.parent) {
            return this._deactivate.bind(this.parent)(binding, instance);
        }
        else {
            return this._bindingDeactivationAndPreDestroy(binding, instance, constructor);
        }
    };
    Container.prototype._propagateContainerDeactivationThenBindingAndPreDestroyAsync = function (binding, instance, constructor) {
        return __awaiter(this, void 0, void 0, function () {
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        if (!this.parent) return [3, 2];
                        return [4, this._deactivate.bind(this.parent)(binding, instance)];
                    case 1:
                        _a.sent();
                        return [3, 4];
                    case 2: return [4, this._bindingDeactivationAndPreDestroyAsync(binding, instance, constructor)];
                    case 3:
                        _a.sent();
                        _a.label = 4;
                    case 4: return [2];
                }
            });
        });
    };
    Container.prototype._removeServiceFromDictionary = function (serviceIdentifier) {
        try {
            this._bindingDictionary.remove(serviceIdentifier);
        }
        catch (e) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.CANNOT_UNBIND + " " + (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_13__.getServiceIdentifierAsString)(serviceIdentifier));
        }
    };
    Container.prototype._bindingDeactivationAndPreDestroy = function (binding, instance, constructor) {
        var _this = this;
        if (typeof binding.onDeactivation === "function") {
            var result = binding.onDeactivation(instance);
            if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_11__.isPromise)(result)) {
                return result.then(function () { return _this._preDestroy(constructor, instance); });
            }
        }
        return this._preDestroy(constructor, instance);
    };
    Container.prototype._bindingDeactivationAndPreDestroyAsync = function (binding, instance, constructor) {
        return __awaiter(this, void 0, void 0, function () {
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        if (!(typeof binding.onDeactivation === "function")) return [3, 2];
                        return [4, binding.onDeactivation(instance)];
                    case 1:
                        _a.sent();
                        _a.label = 2;
                    case 2: return [4, this._preDestroy(constructor, instance)];
                    case 3:
                        _a.sent();
                        return [2];
                }
            });
        });
    };
    return Container;
}());

//# sourceMappingURL=container.js.map

/***/ }),

/***/ "./node_modules/inversify/es/container/container_module.js":
/*!*****************************************************************!*\
  !*** ./node_modules/inversify/es/container/container_module.js ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ContainerModule": function() { return /* binding */ ContainerModule; },
/* harmony export */   "AsyncContainerModule": function() { return /* binding */ AsyncContainerModule; }
/* harmony export */ });
/* harmony import */ var _utils_id__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/id */ "./node_modules/inversify/es/utils/id.js");

var ContainerModule = (function () {
    function ContainerModule(registry) {
        this.id = (0,_utils_id__WEBPACK_IMPORTED_MODULE_0__.id)();
        this.registry = registry;
    }
    return ContainerModule;
}());

var AsyncContainerModule = (function () {
    function AsyncContainerModule(registry) {
        this.id = (0,_utils_id__WEBPACK_IMPORTED_MODULE_0__.id)();
        this.registry = registry;
    }
    return AsyncContainerModule;
}());

//# sourceMappingURL=container_module.js.map

/***/ }),

/***/ "./node_modules/inversify/es/container/container_snapshot.js":
/*!*******************************************************************!*\
  !*** ./node_modules/inversify/es/container/container_snapshot.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ContainerSnapshot": function() { return /* binding */ ContainerSnapshot; }
/* harmony export */ });
var ContainerSnapshot = (function () {
    function ContainerSnapshot() {
    }
    ContainerSnapshot.of = function (bindings, middleware, activations, deactivations, moduleActivationStore) {
        var snapshot = new ContainerSnapshot();
        snapshot.bindings = bindings;
        snapshot.middleware = middleware;
        snapshot.deactivations = deactivations;
        snapshot.activations = activations;
        snapshot.moduleActivationStore = moduleActivationStore;
        return snapshot;
    };
    return ContainerSnapshot;
}());

//# sourceMappingURL=container_snapshot.js.map

/***/ }),

/***/ "./node_modules/inversify/es/container/lookup.js":
/*!*******************************************************!*\
  !*** ./node_modules/inversify/es/container/lookup.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Lookup": function() { return /* binding */ Lookup; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _utils_clonable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/clonable */ "./node_modules/inversify/es/utils/clonable.js");


var Lookup = (function () {
    function Lookup() {
        this._map = new Map();
    }
    Lookup.prototype.getMap = function () {
        return this._map;
    };
    Lookup.prototype.add = function (serviceIdentifier, value) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.NULL_ARGUMENT);
        }
        if (value === null || value === undefined) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.NULL_ARGUMENT);
        }
        var entry = this._map.get(serviceIdentifier);
        if (entry !== undefined) {
            entry.push(value);
        }
        else {
            this._map.set(serviceIdentifier, [value]);
        }
    };
    Lookup.prototype.get = function (serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.NULL_ARGUMENT);
        }
        var entry = this._map.get(serviceIdentifier);
        if (entry !== undefined) {
            return entry;
        }
        else {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.KEY_NOT_FOUND);
        }
    };
    Lookup.prototype.remove = function (serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.NULL_ARGUMENT);
        }
        if (!this._map.delete(serviceIdentifier)) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.KEY_NOT_FOUND);
        }
    };
    Lookup.prototype.removeIntersection = function (lookup) {
        var _this = this;
        this.traverse(function (serviceIdentifier, value) {
            var lookupActivations = lookup.hasKey(serviceIdentifier) ? lookup.get(serviceIdentifier) : undefined;
            if (lookupActivations !== undefined) {
                var filteredValues = value.filter(function (lookupValue) {
                    return !lookupActivations.some(function (moduleActivation) { return lookupValue === moduleActivation; });
                });
                _this._setValue(serviceIdentifier, filteredValues);
            }
        });
    };
    Lookup.prototype.removeByCondition = function (condition) {
        var _this = this;
        var removals = [];
        this._map.forEach(function (entries, key) {
            var updatedEntries = [];
            for (var _i = 0, entries_1 = entries; _i < entries_1.length; _i++) {
                var entry = entries_1[_i];
                var remove = condition(entry);
                if (remove) {
                    removals.push(entry);
                }
                else {
                    updatedEntries.push(entry);
                }
            }
            _this._setValue(key, updatedEntries);
        });
        return removals;
    };
    Lookup.prototype.hasKey = function (serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.NULL_ARGUMENT);
        }
        return this._map.has(serviceIdentifier);
    };
    Lookup.prototype.clone = function () {
        var copy = new Lookup();
        this._map.forEach(function (value, key) {
            value.forEach(function (b) { return copy.add(key, (0,_utils_clonable__WEBPACK_IMPORTED_MODULE_1__.isClonable)(b) ? b.clone() : b); });
        });
        return copy;
    };
    Lookup.prototype.traverse = function (func) {
        this._map.forEach(function (value, key) {
            func(key, value);
        });
    };
    Lookup.prototype._setValue = function (serviceIdentifier, value) {
        if (value.length > 0) {
            this._map.set(serviceIdentifier, value);
        }
        else {
            this._map.delete(serviceIdentifier);
        }
    };
    return Lookup;
}());

//# sourceMappingURL=lookup.js.map

/***/ }),

/***/ "./node_modules/inversify/es/container/module_activation_store.js":
/*!************************************************************************!*\
  !*** ./node_modules/inversify/es/container/module_activation_store.js ***!
  \************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ModuleActivationStore": function() { return /* binding */ ModuleActivationStore; }
/* harmony export */ });
/* harmony import */ var _lookup__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lookup */ "./node_modules/inversify/es/container/lookup.js");

var ModuleActivationStore = (function () {
    function ModuleActivationStore() {
        this._map = new Map();
    }
    ModuleActivationStore.prototype.remove = function (moduleId) {
        if (this._map.has(moduleId)) {
            var handlers = this._map.get(moduleId);
            this._map.delete(moduleId);
            return handlers;
        }
        return this._getEmptyHandlersStore();
    };
    ModuleActivationStore.prototype.addDeactivation = function (moduleId, serviceIdentifier, onDeactivation) {
        this._getModuleActivationHandlers(moduleId)
            .onDeactivations.add(serviceIdentifier, onDeactivation);
    };
    ModuleActivationStore.prototype.addActivation = function (moduleId, serviceIdentifier, onActivation) {
        this._getModuleActivationHandlers(moduleId)
            .onActivations.add(serviceIdentifier, onActivation);
    };
    ModuleActivationStore.prototype.clone = function () {
        var clone = new ModuleActivationStore();
        this._map.forEach(function (handlersStore, moduleId) {
            clone._map.set(moduleId, {
                onActivations: handlersStore.onActivations.clone(),
                onDeactivations: handlersStore.onDeactivations.clone(),
            });
        });
        return clone;
    };
    ModuleActivationStore.prototype._getModuleActivationHandlers = function (moduleId) {
        var moduleActivationHandlers = this._map.get(moduleId);
        if (moduleActivationHandlers === undefined) {
            moduleActivationHandlers = this._getEmptyHandlersStore();
            this._map.set(moduleId, moduleActivationHandlers);
        }
        return moduleActivationHandlers;
    };
    ModuleActivationStore.prototype._getEmptyHandlersStore = function () {
        var handlersStore = {
            onActivations: new _lookup__WEBPACK_IMPORTED_MODULE_0__.Lookup(),
            onDeactivations: new _lookup__WEBPACK_IMPORTED_MODULE_0__.Lookup()
        };
        return handlersStore;
    };
    return ModuleActivationStore;
}());

//# sourceMappingURL=module_activation_store.js.map

/***/ }),

/***/ "./node_modules/inversify/es/interfaces/interfaces.js":
/*!************************************************************!*\
  !*** ./node_modules/inversify/es/interfaces/interfaces.js ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "interfaces": function() { return /* binding */ interfaces; }
/* harmony export */ });
var interfaces;
(function (interfaces) {
    ;
})(interfaces || (interfaces = {}));

//# sourceMappingURL=interfaces.js.map

/***/ }),

/***/ "./node_modules/inversify/es/inversify.js":
/*!************************************************!*\
  !*** ./node_modules/inversify/es/inversify.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "METADATA_KEY": function() { return /* binding */ METADATA_KEY; },
/* harmony export */   "Container": function() { return /* reexport safe */ _container_container__WEBPACK_IMPORTED_MODULE_1__.Container; },
/* harmony export */   "BindingScopeEnum": function() { return /* reexport safe */ _constants_literal_types__WEBPACK_IMPORTED_MODULE_2__.BindingScopeEnum; },
/* harmony export */   "BindingTypeEnum": function() { return /* reexport safe */ _constants_literal_types__WEBPACK_IMPORTED_MODULE_2__.BindingTypeEnum; },
/* harmony export */   "TargetTypeEnum": function() { return /* reexport safe */ _constants_literal_types__WEBPACK_IMPORTED_MODULE_2__.TargetTypeEnum; },
/* harmony export */   "AsyncContainerModule": function() { return /* reexport safe */ _container_container_module__WEBPACK_IMPORTED_MODULE_3__.AsyncContainerModule; },
/* harmony export */   "ContainerModule": function() { return /* reexport safe */ _container_container_module__WEBPACK_IMPORTED_MODULE_3__.ContainerModule; },
/* harmony export */   "createTaggedDecorator": function() { return /* reexport safe */ _annotation_decorator_utils__WEBPACK_IMPORTED_MODULE_4__.createTaggedDecorator; },
/* harmony export */   "injectable": function() { return /* reexport safe */ _annotation_injectable__WEBPACK_IMPORTED_MODULE_5__.injectable; },
/* harmony export */   "tagged": function() { return /* reexport safe */ _annotation_tagged__WEBPACK_IMPORTED_MODULE_6__.tagged; },
/* harmony export */   "named": function() { return /* reexport safe */ _annotation_named__WEBPACK_IMPORTED_MODULE_7__.named; },
/* harmony export */   "inject": function() { return /* reexport safe */ _annotation_inject__WEBPACK_IMPORTED_MODULE_8__.inject; },
/* harmony export */   "LazyServiceIdentifer": function() { return /* reexport safe */ _annotation_lazy_service_identifier__WEBPACK_IMPORTED_MODULE_9__.LazyServiceIdentifer; },
/* harmony export */   "optional": function() { return /* reexport safe */ _annotation_optional__WEBPACK_IMPORTED_MODULE_10__.optional; },
/* harmony export */   "unmanaged": function() { return /* reexport safe */ _annotation_unmanaged__WEBPACK_IMPORTED_MODULE_11__.unmanaged; },
/* harmony export */   "multiInject": function() { return /* reexport safe */ _annotation_multi_inject__WEBPACK_IMPORTED_MODULE_12__.multiInject; },
/* harmony export */   "targetName": function() { return /* reexport safe */ _annotation_target_name__WEBPACK_IMPORTED_MODULE_13__.targetName; },
/* harmony export */   "postConstruct": function() { return /* reexport safe */ _annotation_post_construct__WEBPACK_IMPORTED_MODULE_14__.postConstruct; },
/* harmony export */   "preDestroy": function() { return /* reexport safe */ _annotation_pre_destroy__WEBPACK_IMPORTED_MODULE_15__.preDestroy; },
/* harmony export */   "MetadataReader": function() { return /* reexport safe */ _planning_metadata_reader__WEBPACK_IMPORTED_MODULE_16__.MetadataReader; },
/* harmony export */   "id": function() { return /* reexport safe */ _utils_id__WEBPACK_IMPORTED_MODULE_17__.id; },
/* harmony export */   "interfaces": function() { return /* reexport safe */ _interfaces_interfaces__WEBPACK_IMPORTED_MODULE_18__.interfaces; },
/* harmony export */   "decorate": function() { return /* reexport safe */ _annotation_decorator_utils__WEBPACK_IMPORTED_MODULE_4__.decorate; },
/* harmony export */   "traverseAncerstors": function() { return /* reexport safe */ _syntax_constraint_helpers__WEBPACK_IMPORTED_MODULE_19__.traverseAncerstors; },
/* harmony export */   "taggedConstraint": function() { return /* reexport safe */ _syntax_constraint_helpers__WEBPACK_IMPORTED_MODULE_19__.taggedConstraint; },
/* harmony export */   "namedConstraint": function() { return /* reexport safe */ _syntax_constraint_helpers__WEBPACK_IMPORTED_MODULE_19__.namedConstraint; },
/* harmony export */   "typeConstraint": function() { return /* reexport safe */ _syntax_constraint_helpers__WEBPACK_IMPORTED_MODULE_19__.typeConstraint; },
/* harmony export */   "getServiceIdentifierAsString": function() { return /* reexport safe */ _utils_serialization__WEBPACK_IMPORTED_MODULE_20__.getServiceIdentifierAsString; },
/* harmony export */   "multiBindToService": function() { return /* reexport safe */ _utils_binding_utils__WEBPACK_IMPORTED_MODULE_21__.multiBindToService; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _container_container__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./container/container */ "./node_modules/inversify/es/container/container.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _container_container_module__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./container/container_module */ "./node_modules/inversify/es/container/container_module.js");
/* harmony import */ var _annotation_decorator_utils__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./annotation/decorator_utils */ "./node_modules/inversify/es/annotation/decorator_utils.js");
/* harmony import */ var _annotation_injectable__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./annotation/injectable */ "./node_modules/inversify/es/annotation/injectable.js");
/* harmony import */ var _annotation_tagged__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./annotation/tagged */ "./node_modules/inversify/es/annotation/tagged.js");
/* harmony import */ var _annotation_named__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./annotation/named */ "./node_modules/inversify/es/annotation/named.js");
/* harmony import */ var _annotation_inject__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./annotation/inject */ "./node_modules/inversify/es/annotation/inject.js");
/* harmony import */ var _annotation_lazy_service_identifier__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./annotation/lazy_service_identifier */ "./node_modules/inversify/es/annotation/lazy_service_identifier.js");
/* harmony import */ var _annotation_optional__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./annotation/optional */ "./node_modules/inversify/es/annotation/optional.js");
/* harmony import */ var _annotation_unmanaged__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./annotation/unmanaged */ "./node_modules/inversify/es/annotation/unmanaged.js");
/* harmony import */ var _annotation_multi_inject__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./annotation/multi_inject */ "./node_modules/inversify/es/annotation/multi_inject.js");
/* harmony import */ var _annotation_target_name__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./annotation/target_name */ "./node_modules/inversify/es/annotation/target_name.js");
/* harmony import */ var _annotation_post_construct__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./annotation/post_construct */ "./node_modules/inversify/es/annotation/post_construct.js");
/* harmony import */ var _annotation_pre_destroy__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ./annotation/pre_destroy */ "./node_modules/inversify/es/annotation/pre_destroy.js");
/* harmony import */ var _planning_metadata_reader__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! ./planning/metadata_reader */ "./node_modules/inversify/es/planning/metadata_reader.js");
/* harmony import */ var _utils_id__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! ./utils/id */ "./node_modules/inversify/es/utils/id.js");
/* harmony import */ var _interfaces_interfaces__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! ./interfaces/interfaces */ "./node_modules/inversify/es/interfaces/interfaces.js");
/* harmony import */ var _syntax_constraint_helpers__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(/*! ./syntax/constraint_helpers */ "./node_modules/inversify/es/syntax/constraint_helpers.js");
/* harmony import */ var _utils_serialization__WEBPACK_IMPORTED_MODULE_20__ = __webpack_require__(/*! ./utils/serialization */ "./node_modules/inversify/es/utils/serialization.js");
/* harmony import */ var _utils_binding_utils__WEBPACK_IMPORTED_MODULE_21__ = __webpack_require__(/*! ./utils/binding_utils */ "./node_modules/inversify/es/utils/binding_utils.js");

var METADATA_KEY = _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__;






















//# sourceMappingURL=inversify.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/context.js":
/*!*******************************************************!*\
  !*** ./node_modules/inversify/es/planning/context.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Context": function() { return /* binding */ Context; }
/* harmony export */ });
/* harmony import */ var _utils_id__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/id */ "./node_modules/inversify/es/utils/id.js");

var Context = (function () {
    function Context(container) {
        this.id = (0,_utils_id__WEBPACK_IMPORTED_MODULE_0__.id)();
        this.container = container;
    }
    Context.prototype.addPlan = function (plan) {
        this.plan = plan;
    };
    Context.prototype.setCurrentRequest = function (currentRequest) {
        this.currentRequest = currentRequest;
    };
    return Context;
}());

//# sourceMappingURL=context.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/metadata.js":
/*!********************************************************!*\
  !*** ./node_modules/inversify/es/planning/metadata.js ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Metadata": function() { return /* binding */ Metadata; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");

var Metadata = (function () {
    function Metadata(key, value) {
        this.key = key;
        this.value = value;
    }
    Metadata.prototype.toString = function () {
        if (this.key === _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.NAMED_TAG) {
            return "named: " + String(this.value).toString() + " ";
        }
        else {
            return "tagged: { key:" + this.key.toString() + ", value: " + String(this.value) + " }";
        }
    };
    return Metadata;
}());

//# sourceMappingURL=metadata.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/metadata_reader.js":
/*!***************************************************************!*\
  !*** ./node_modules/inversify/es/planning/metadata_reader.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "MetadataReader": function() { return /* binding */ MetadataReader; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");

var MetadataReader = (function () {
    function MetadataReader() {
    }
    MetadataReader.prototype.getConstructorMetadata = function (constructorFunc) {
        var compilerGeneratedMetadata = Reflect.getMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.PARAM_TYPES, constructorFunc);
        var userGeneratedMetadata = Reflect.getMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.TAGGED, constructorFunc);
        return {
            compilerGeneratedMetadata: compilerGeneratedMetadata,
            userGeneratedMetadata: userGeneratedMetadata || {}
        };
    };
    MetadataReader.prototype.getPropertiesMetadata = function (constructorFunc) {
        var userGeneratedMetadata = Reflect.getMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.TAGGED_PROP, constructorFunc) || [];
        return userGeneratedMetadata;
    };
    return MetadataReader;
}());

//# sourceMappingURL=metadata_reader.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/plan.js":
/*!****************************************************!*\
  !*** ./node_modules/inversify/es/planning/plan.js ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Plan": function() { return /* binding */ Plan; }
/* harmony export */ });
var Plan = (function () {
    function Plan(parentContext, rootRequest) {
        this.parentContext = parentContext;
        this.rootRequest = rootRequest;
    }
    return Plan;
}());

//# sourceMappingURL=plan.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/planner.js":
/*!*******************************************************!*\
  !*** ./node_modules/inversify/es/planning/planner.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "plan": function() { return /* binding */ plan; },
/* harmony export */   "createMockRequest": function() { return /* binding */ createMockRequest; },
/* harmony export */   "getBindingDictionary": function() { return /* binding */ getBindingDictionary; }
/* harmony export */ });
/* harmony import */ var _bindings_binding_count__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../bindings/binding_count */ "./node_modules/inversify/es/bindings/binding_count.js");
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _utils_exceptions__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../utils/exceptions */ "./node_modules/inversify/es/utils/exceptions.js");
/* harmony import */ var _utils_serialization__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./reflection_utils */ "./node_modules/inversify/es/utils/serialization.js");
/* harmony import */ var _context__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./context */ "./node_modules/inversify/es/planning/context.js");
/* harmony import */ var _metadata__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _plan__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./plan */ "./node_modules/inversify/es/planning/plan.js");
/* harmony import */ var _reflection_utils__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./reflection_utils */ "./node_modules/inversify/es/planning/reflection_utils.js");
/* harmony import */ var _request__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./request */ "./node_modules/inversify/es/planning/request.js");
/* harmony import */ var _target__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./target */ "./node_modules/inversify/es/planning/target.js");












function getBindingDictionary(cntnr) {
    return cntnr._bindingDictionary;
}
function _createTarget(isMultiInject, targetType, serviceIdentifier, name, key, value) {
    var metadataKey = isMultiInject ? _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.MULTI_INJECT_TAG : _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_0__.INJECT_TAG;
    var injectMetadata = new _metadata__WEBPACK_IMPORTED_MODULE_1__.Metadata(metadataKey, serviceIdentifier);
    var target = new _target__WEBPACK_IMPORTED_MODULE_2__.Target(targetType, name, serviceIdentifier, injectMetadata);
    if (key !== undefined) {
        var tagMetadata = new _metadata__WEBPACK_IMPORTED_MODULE_1__.Metadata(key, value);
        target.metadata.push(tagMetadata);
    }
    return target;
}
function _getActiveBindings(metadataReader, avoidConstraints, context, parentRequest, target) {
    var bindings = getBindings(context.container, target.serviceIdentifier);
    var activeBindings = [];
    if (bindings.length === _bindings_binding_count__WEBPACK_IMPORTED_MODULE_3__.BindingCount.NoBindingsAvailable &&
        context.container.options.autoBindInjectable &&
        typeof target.serviceIdentifier === "function" &&
        metadataReader.getConstructorMetadata(target.serviceIdentifier).compilerGeneratedMetadata) {
        context.container.bind(target.serviceIdentifier).toSelf();
        bindings = getBindings(context.container, target.serviceIdentifier);
    }
    if (!avoidConstraints) {
        activeBindings = bindings.filter(function (binding) {
            var request = new _request__WEBPACK_IMPORTED_MODULE_4__.Request(binding.serviceIdentifier, context, parentRequest, binding, target);
            return binding.constraint(request);
        });
    }
    else {
        activeBindings = bindings;
    }
    _validateActiveBindingCount(target.serviceIdentifier, activeBindings, target, context.container);
    return activeBindings;
}
function _validateActiveBindingCount(serviceIdentifier, bindings, target, container) {
    switch (bindings.length) {
        case _bindings_binding_count__WEBPACK_IMPORTED_MODULE_3__.BindingCount.NoBindingsAvailable:
            if (target.isOptional()) {
                return bindings;
            }
            else {
                var serviceIdentifierString = (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_5__.getServiceIdentifierAsString)(serviceIdentifier);
                var msg = _constants_error_msgs__WEBPACK_IMPORTED_MODULE_6__.NOT_REGISTERED;
                msg += (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_5__.listMetadataForTarget)(serviceIdentifierString, target);
                msg += (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_5__.listRegisteredBindingsForServiceIdentifier)(container, serviceIdentifierString, getBindings);
                throw new Error(msg);
            }
        case _bindings_binding_count__WEBPACK_IMPORTED_MODULE_3__.BindingCount.OnlyOneBindingAvailable:
            return bindings;
        case _bindings_binding_count__WEBPACK_IMPORTED_MODULE_3__.BindingCount.MultipleBindingsAvailable:
        default:
            if (!target.isArray()) {
                var serviceIdentifierString = (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_5__.getServiceIdentifierAsString)(serviceIdentifier);
                var msg = _constants_error_msgs__WEBPACK_IMPORTED_MODULE_6__.AMBIGUOUS_MATCH + " " + serviceIdentifierString;
                msg += (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_5__.listRegisteredBindingsForServiceIdentifier)(container, serviceIdentifierString, getBindings);
                throw new Error(msg);
            }
            else {
                return bindings;
            }
    }
}
function _createSubRequests(metadataReader, avoidConstraints, serviceIdentifier, context, parentRequest, target) {
    var activeBindings;
    var childRequest;
    if (parentRequest === null) {
        activeBindings = _getActiveBindings(metadataReader, avoidConstraints, context, null, target);
        childRequest = new _request__WEBPACK_IMPORTED_MODULE_4__.Request(serviceIdentifier, context, null, activeBindings, target);
        var thePlan = new _plan__WEBPACK_IMPORTED_MODULE_7__.Plan(context, childRequest);
        context.addPlan(thePlan);
    }
    else {
        activeBindings = _getActiveBindings(metadataReader, avoidConstraints, context, parentRequest, target);
        childRequest = parentRequest.addChildRequest(target.serviceIdentifier, activeBindings, target);
    }
    activeBindings.forEach(function (binding) {
        var subChildRequest = null;
        if (target.isArray()) {
            subChildRequest = childRequest.addChildRequest(binding.serviceIdentifier, binding, target);
        }
        else {
            if (binding.cache) {
                return;
            }
            subChildRequest = childRequest;
        }
        if (binding.type === _constants_literal_types__WEBPACK_IMPORTED_MODULE_8__.BindingTypeEnum.Instance && binding.implementationType !== null) {
            var dependencies = (0,_reflection_utils__WEBPACK_IMPORTED_MODULE_9__.getDependencies)(metadataReader, binding.implementationType);
            if (!context.container.options.skipBaseClassChecks) {
                var baseClassDependencyCount = (0,_reflection_utils__WEBPACK_IMPORTED_MODULE_9__.getBaseClassDependencyCount)(metadataReader, binding.implementationType);
                if (dependencies.length < baseClassDependencyCount) {
                    var error = _constants_error_msgs__WEBPACK_IMPORTED_MODULE_6__.ARGUMENTS_LENGTH_MISMATCH((0,_utils_serialization__WEBPACK_IMPORTED_MODULE_5__.getFunctionName)(binding.implementationType));
                    throw new Error(error);
                }
            }
            dependencies.forEach(function (dependency) {
                _createSubRequests(metadataReader, false, dependency.serviceIdentifier, context, subChildRequest, dependency);
            });
        }
    });
}
function getBindings(container, serviceIdentifier) {
    var bindings = [];
    var bindingDictionary = getBindingDictionary(container);
    if (bindingDictionary.hasKey(serviceIdentifier)) {
        bindings = bindingDictionary.get(serviceIdentifier);
    }
    else if (container.parent !== null) {
        bindings = getBindings(container.parent, serviceIdentifier);
    }
    return bindings;
}
function plan(metadataReader, container, isMultiInject, targetType, serviceIdentifier, key, value, avoidConstraints) {
    if (avoidConstraints === void 0) { avoidConstraints = false; }
    var context = new _context__WEBPACK_IMPORTED_MODULE_10__.Context(container);
    var target = _createTarget(isMultiInject, targetType, serviceIdentifier, "", key, value);
    try {
        _createSubRequests(metadataReader, avoidConstraints, serviceIdentifier, context, null, target);
        return context;
    }
    catch (error) {
        if ((0,_utils_exceptions__WEBPACK_IMPORTED_MODULE_11__.isStackOverflowExeption)(error)) {
            (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_5__.circularDependencyToException)(context.plan.rootRequest);
        }
        throw error;
    }
}
function createMockRequest(container, serviceIdentifier, key, value) {
    var target = new _target__WEBPACK_IMPORTED_MODULE_2__.Target(_constants_literal_types__WEBPACK_IMPORTED_MODULE_8__.TargetTypeEnum.Variable, "", serviceIdentifier, new _metadata__WEBPACK_IMPORTED_MODULE_1__.Metadata(key, value));
    var context = new _context__WEBPACK_IMPORTED_MODULE_10__.Context(container);
    var request = new _request__WEBPACK_IMPORTED_MODULE_4__.Request(serviceIdentifier, context, null, [], target);
    return request;
}

//# sourceMappingURL=planner.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/queryable_string.js":
/*!****************************************************************!*\
  !*** ./node_modules/inversify/es/planning/queryable_string.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "QueryableString": function() { return /* binding */ QueryableString; }
/* harmony export */ });
var QueryableString = (function () {
    function QueryableString(str) {
        this.str = str;
    }
    QueryableString.prototype.startsWith = function (searchString) {
        return this.str.indexOf(searchString) === 0;
    };
    QueryableString.prototype.endsWith = function (searchString) {
        var reverseString = "";
        var reverseSearchString = searchString.split("").reverse().join("");
        reverseString = this.str.split("").reverse().join("");
        return this.startsWith.call({ str: reverseString }, reverseSearchString);
    };
    QueryableString.prototype.contains = function (searchString) {
        return (this.str.indexOf(searchString) !== -1);
    };
    QueryableString.prototype.equals = function (compareString) {
        return this.str === compareString;
    };
    QueryableString.prototype.value = function () {
        return this.str;
    };
    return QueryableString;
}());

//# sourceMappingURL=queryable_string.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/reflection_utils.js":
/*!****************************************************************!*\
  !*** ./node_modules/inversify/es/planning/reflection_utils.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getDependencies": function() { return /* binding */ getDependencies; },
/* harmony export */   "getBaseClassDependencyCount": function() { return /* binding */ getBaseClassDependencyCount; },
/* harmony export */   "getFunctionName": function() { return /* reexport safe */ _utils_serialization__WEBPACK_IMPORTED_MODULE_0__.getFunctionName; }
/* harmony export */ });
/* harmony import */ var _annotation_lazy_service_identifier__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../annotation/lazy_service_identifier */ "./node_modules/inversify/es/annotation/lazy_service_identifier.js");
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _utils_serialization__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/serialization */ "./node_modules/inversify/es/utils/serialization.js");
/* harmony import */ var _target__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./target */ "./node_modules/inversify/es/planning/target.js");
var __spreadArray = (undefined && undefined.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};






function getDependencies(metadataReader, func) {
    var constructorName = (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_0__.getFunctionName)(func);
    return getTargets(metadataReader, constructorName, func, false);
}
function getTargets(metadataReader, constructorName, func, isBaseClass) {
    var metadata = metadataReader.getConstructorMetadata(func);
    var serviceIdentifiers = metadata.compilerGeneratedMetadata;
    if (serviceIdentifiers === undefined) {
        var msg = _constants_error_msgs__WEBPACK_IMPORTED_MODULE_1__.MISSING_INJECTABLE_ANNOTATION + " " + constructorName + ".";
        throw new Error(msg);
    }
    var constructorArgsMetadata = metadata.userGeneratedMetadata;
    var keys = Object.keys(constructorArgsMetadata);
    var hasUserDeclaredUnknownInjections = (func.length === 0 && keys.length > 0);
    var hasOptionalParameters = keys.length > func.length;
    var iterations = (hasUserDeclaredUnknownInjections || hasOptionalParameters) ? keys.length : func.length;
    var constructorTargets = getConstructorArgsAsTargets(isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata, iterations);
    var propertyTargets = getClassPropsAsTargets(metadataReader, func, constructorName);
    var targets = __spreadArray(__spreadArray([], constructorTargets, true), propertyTargets, true);
    return targets;
}
function getConstructorArgsAsTarget(index, isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata) {
    var targetMetadata = constructorArgsMetadata[index.toString()] || [];
    var metadata = formatTargetMetadata(targetMetadata);
    var isManaged = metadata.unmanaged !== true;
    var serviceIdentifier = serviceIdentifiers[index];
    var injectIdentifier = (metadata.inject || metadata.multiInject);
    serviceIdentifier = (injectIdentifier) ? (injectIdentifier) : serviceIdentifier;
    if (serviceIdentifier instanceof _annotation_lazy_service_identifier__WEBPACK_IMPORTED_MODULE_2__.LazyServiceIdentifer) {
        serviceIdentifier = serviceIdentifier.unwrap();
    }
    if (isManaged) {
        var isObject = serviceIdentifier === Object;
        var isFunction = serviceIdentifier === Function;
        var isUndefined = serviceIdentifier === undefined;
        var isUnknownType = (isObject || isFunction || isUndefined);
        if (!isBaseClass && isUnknownType) {
            var msg = _constants_error_msgs__WEBPACK_IMPORTED_MODULE_1__.MISSING_INJECT_ANNOTATION + " argument " + index + " in class " + constructorName + ".";
            throw new Error(msg);
        }
        var target = new _target__WEBPACK_IMPORTED_MODULE_3__.Target(_constants_literal_types__WEBPACK_IMPORTED_MODULE_4__.TargetTypeEnum.ConstructorArgument, metadata.targetName, serviceIdentifier);
        target.metadata = targetMetadata;
        return target;
    }
    return null;
}
function getConstructorArgsAsTargets(isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata, iterations) {
    var targets = [];
    for (var i = 0; i < iterations; i++) {
        var index = i;
        var target = getConstructorArgsAsTarget(index, isBaseClass, constructorName, serviceIdentifiers, constructorArgsMetadata);
        if (target !== null) {
            targets.push(target);
        }
    }
    return targets;
}
function _getServiceIdentifierForProperty(inject, multiInject, propertyName, className) {
    var serviceIdentifier = (inject || multiInject);
    if (serviceIdentifier === undefined) {
        var msg = _constants_error_msgs__WEBPACK_IMPORTED_MODULE_1__.MISSING_INJECTABLE_ANNOTATION + " for property " + String(propertyName) + " in class " + className + ".";
        throw new Error(msg);
    }
    return serviceIdentifier;
}
function getClassPropsAsTargets(metadataReader, constructorFunc, constructorName) {
    var classPropsMetadata = metadataReader.getPropertiesMetadata(constructorFunc);
    var targets = [];
    var symbolKeys = Object.getOwnPropertySymbols(classPropsMetadata);
    var stringKeys = Object.keys(classPropsMetadata);
    var keys = stringKeys.concat(symbolKeys);
    for (var _i = 0, keys_1 = keys; _i < keys_1.length; _i++) {
        var key = keys_1[_i];
        var targetMetadata = classPropsMetadata[key];
        var metadata = formatTargetMetadata(targetMetadata);
        var identifier = metadata.targetName || key;
        var serviceIdentifier = _getServiceIdentifierForProperty(metadata.inject, metadata.multiInject, key, constructorName);
        var target = new _target__WEBPACK_IMPORTED_MODULE_3__.Target(_constants_literal_types__WEBPACK_IMPORTED_MODULE_4__.TargetTypeEnum.ClassProperty, identifier, serviceIdentifier);
        target.metadata = targetMetadata;
        targets.push(target);
    }
    var baseConstructor = Object.getPrototypeOf(constructorFunc.prototype).constructor;
    if (baseConstructor !== Object) {
        var baseTargets = getClassPropsAsTargets(metadataReader, baseConstructor, constructorName);
        targets = __spreadArray(__spreadArray([], targets, true), baseTargets, true);
    }
    return targets;
}
function getBaseClassDependencyCount(metadataReader, func) {
    var baseConstructor = Object.getPrototypeOf(func.prototype).constructor;
    if (baseConstructor !== Object) {
        var baseConstructorName = (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_0__.getFunctionName)(baseConstructor);
        var targets = getTargets(metadataReader, baseConstructorName, baseConstructor, true);
        var metadata = targets.map(function (t) { return t.metadata.filter(function (m) { return m.key === _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_5__.UNMANAGED_TAG; }); });
        var unmanagedCount = [].concat.apply([], metadata).length;
        var dependencyCount = targets.length - unmanagedCount;
        if (dependencyCount > 0) {
            return dependencyCount;
        }
        else {
            return getBaseClassDependencyCount(metadataReader, baseConstructor);
        }
    }
    else {
        return 0;
    }
}
function formatTargetMetadata(targetMetadata) {
    var targetMetadataMap = {};
    targetMetadata.forEach(function (m) {
        targetMetadataMap[m.key.toString()] = m.value;
    });
    return {
        inject: targetMetadataMap[_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_5__.INJECT_TAG],
        multiInject: targetMetadataMap[_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_5__.MULTI_INJECT_TAG],
        targetName: targetMetadataMap[_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_5__.NAME_TAG],
        unmanaged: targetMetadataMap[_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_5__.UNMANAGED_TAG]
    };
}

//# sourceMappingURL=reflection_utils.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/request.js":
/*!*******************************************************!*\
  !*** ./node_modules/inversify/es/planning/request.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Request": function() { return /* binding */ Request; }
/* harmony export */ });
/* harmony import */ var _utils_id__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/id */ "./node_modules/inversify/es/utils/id.js");

var Request = (function () {
    function Request(serviceIdentifier, parentContext, parentRequest, bindings, target) {
        this.id = (0,_utils_id__WEBPACK_IMPORTED_MODULE_0__.id)();
        this.serviceIdentifier = serviceIdentifier;
        this.parentContext = parentContext;
        this.parentRequest = parentRequest;
        this.target = target;
        this.childRequests = [];
        this.bindings = (Array.isArray(bindings) ? bindings : [bindings]);
        this.requestScope = parentRequest === null
            ? new Map()
            : null;
    }
    Request.prototype.addChildRequest = function (serviceIdentifier, bindings, target) {
        var child = new Request(serviceIdentifier, this.parentContext, this, bindings, target);
        this.childRequests.push(child);
        return child;
    };
    return Request;
}());

//# sourceMappingURL=request.js.map

/***/ }),

/***/ "./node_modules/inversify/es/planning/target.js":
/*!******************************************************!*\
  !*** ./node_modules/inversify/es/planning/target.js ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Target": function() { return /* binding */ Target; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _utils_id__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/id */ "./node_modules/inversify/es/utils/id.js");
/* harmony import */ var _utils_serialization__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/serialization */ "./node_modules/inversify/es/utils/serialization.js");
/* harmony import */ var _metadata__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./metadata */ "./node_modules/inversify/es/planning/metadata.js");
/* harmony import */ var _queryable_string__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./queryable_string */ "./node_modules/inversify/es/planning/queryable_string.js");





var Target = (function () {
    function Target(type, identifier, serviceIdentifier, namedOrTagged) {
        this.id = (0,_utils_id__WEBPACK_IMPORTED_MODULE_0__.id)();
        this.type = type;
        this.serviceIdentifier = serviceIdentifier;
        var queryableName = typeof identifier === 'symbol' ? (0,_utils_serialization__WEBPACK_IMPORTED_MODULE_1__.getSymbolDescription)(identifier) : identifier;
        this.name = new _queryable_string__WEBPACK_IMPORTED_MODULE_2__.QueryableString(queryableName || "");
        this.identifier = identifier;
        this.metadata = new Array();
        var metadataItem = null;
        if (typeof namedOrTagged === 'string') {
            metadataItem = new _metadata__WEBPACK_IMPORTED_MODULE_3__.Metadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.NAMED_TAG, namedOrTagged);
        }
        else if (namedOrTagged instanceof _metadata__WEBPACK_IMPORTED_MODULE_3__.Metadata) {
            metadataItem = namedOrTagged;
        }
        if (metadataItem !== null) {
            this.metadata.push(metadataItem);
        }
    }
    Target.prototype.hasTag = function (key) {
        for (var _i = 0, _a = this.metadata; _i < _a.length; _i++) {
            var m = _a[_i];
            if (m.key === key) {
                return true;
            }
        }
        return false;
    };
    Target.prototype.isArray = function () {
        return this.hasTag(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.MULTI_INJECT_TAG);
    };
    Target.prototype.matchesArray = function (name) {
        return this.matchesTag(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.MULTI_INJECT_TAG)(name);
    };
    Target.prototype.isNamed = function () {
        return this.hasTag(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.NAMED_TAG);
    };
    Target.prototype.isTagged = function () {
        return this.metadata.some(function (metadata) { return _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.NON_CUSTOM_TAG_KEYS.every(function (key) { return metadata.key !== key; }); });
    };
    Target.prototype.isOptional = function () {
        return this.matchesTag(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.OPTIONAL_TAG)(true);
    };
    Target.prototype.getNamedTag = function () {
        if (this.isNamed()) {
            return this.metadata.filter(function (m) { return m.key === _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.NAMED_TAG; })[0];
        }
        return null;
    };
    Target.prototype.getCustomTags = function () {
        if (this.isTagged()) {
            return this.metadata.filter(function (metadata) { return _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.NON_CUSTOM_TAG_KEYS.every(function (key) { return metadata.key !== key; }); });
        }
        else {
            return null;
        }
    };
    Target.prototype.matchesNamedTag = function (name) {
        return this.matchesTag(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_4__.NAMED_TAG)(name);
    };
    Target.prototype.matchesTag = function (key) {
        var _this = this;
        return function (value) {
            for (var _i = 0, _a = _this.metadata; _i < _a.length; _i++) {
                var m = _a[_i];
                if (m.key === key && m.value === value) {
                    return true;
                }
            }
            return false;
        };
    };
    return Target;
}());

//# sourceMappingURL=target.js.map

/***/ }),

/***/ "./node_modules/inversify/es/resolution/instantiation.js":
/*!***************************************************************!*\
  !*** ./node_modules/inversify/es/resolution/instantiation.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "resolveInstance": function() { return /* binding */ resolveInstance; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _utils_async__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/async */ "./node_modules/inversify/es/utils/async.js");
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
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (undefined && undefined.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var __spreadArray = (undefined && undefined.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};




function _resolveRequests(childRequests, resolveRequest) {
    return childRequests.reduce(function (resolvedRequests, childRequest) {
        var injection = resolveRequest(childRequest);
        var targetType = childRequest.target.type;
        if (targetType === _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.TargetTypeEnum.ConstructorArgument) {
            resolvedRequests.constructorInjections.push(injection);
        }
        else {
            resolvedRequests.propertyRequests.push(childRequest);
            resolvedRequests.propertyInjections.push(injection);
        }
        if (!resolvedRequests.isAsync) {
            resolvedRequests.isAsync = (0,_utils_async__WEBPACK_IMPORTED_MODULE_1__.isPromiseOrContainsPromise)(injection);
        }
        return resolvedRequests;
    }, { constructorInjections: [], propertyInjections: [], propertyRequests: [], isAsync: false });
}
function _createInstance(constr, childRequests, resolveRequest) {
    var result;
    if (childRequests.length > 0) {
        var resolved = _resolveRequests(childRequests, resolveRequest);
        var createInstanceWithInjectionsArg = __assign(__assign({}, resolved), { constr: constr });
        if (resolved.isAsync) {
            result = createInstanceWithInjectionsAsync(createInstanceWithInjectionsArg);
        }
        else {
            result = createInstanceWithInjections(createInstanceWithInjectionsArg);
        }
    }
    else {
        result = new constr();
    }
    return result;
}
function createInstanceWithInjections(args) {
    var _a;
    var instance = new ((_a = args.constr).bind.apply(_a, __spreadArray([void 0], args.constructorInjections, false)))();
    args.propertyRequests.forEach(function (r, index) {
        var property = r.target.identifier;
        var injection = args.propertyInjections[index];
        instance[property] = injection;
    });
    return instance;
}
function createInstanceWithInjectionsAsync(args) {
    return __awaiter(this, void 0, void 0, function () {
        var constructorInjections, propertyInjections;
        return __generator(this, function (_a) {
            switch (_a.label) {
                case 0: return [4, possiblyWaitInjections(args.constructorInjections)];
                case 1:
                    constructorInjections = _a.sent();
                    return [4, possiblyWaitInjections(args.propertyInjections)];
                case 2:
                    propertyInjections = _a.sent();
                    return [2, createInstanceWithInjections(__assign(__assign({}, args), { constructorInjections: constructorInjections, propertyInjections: propertyInjections }))];
            }
        });
    });
}
function possiblyWaitInjections(possiblePromiseinjections) {
    return __awaiter(this, void 0, void 0, function () {
        var injections, _i, possiblePromiseinjections_1, injection;
        return __generator(this, function (_a) {
            injections = [];
            for (_i = 0, possiblePromiseinjections_1 = possiblePromiseinjections; _i < possiblePromiseinjections_1.length; _i++) {
                injection = possiblePromiseinjections_1[_i];
                if (Array.isArray(injection)) {
                    injections.push(Promise.all(injection));
                }
                else {
                    injections.push(injection);
                }
            }
            return [2, Promise.all(injections)];
        });
    });
}
function _getInstanceAfterPostConstruct(constr, result) {
    var postConstructResult = _postConstruct(constr, result);
    if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_1__.isPromise)(postConstructResult)) {
        return postConstructResult.then(function () { return result; });
    }
    else {
        return result;
    }
}
function _postConstruct(constr, instance) {
    var _a, _b;
    if (Reflect.hasMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__.POST_CONSTRUCT, constr)) {
        var data = Reflect.getMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__.POST_CONSTRUCT, constr);
        try {
            return (_b = (_a = instance)[data.value]) === null || _b === void 0 ? void 0 : _b.call(_a);
        }
        catch (e) {
            throw new Error((0,_constants_error_msgs__WEBPACK_IMPORTED_MODULE_3__.POST_CONSTRUCT_ERROR)(constr.name, e.message));
        }
    }
}
function _validateInstanceResolution(binding, constr) {
    if (binding.scope !== _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton) {
        _throwIfHandlingDeactivation(binding, constr);
    }
}
function _throwIfHandlingDeactivation(binding, constr) {
    var scopeErrorMessage = "Class cannot be instantiated in " + (binding.scope === _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Request ?
        "request" :
        "transient") + " scope.";
    if (typeof binding.onDeactivation === "function") {
        throw new Error((0,_constants_error_msgs__WEBPACK_IMPORTED_MODULE_3__.ON_DEACTIVATION_ERROR)(constr.name, scopeErrorMessage));
    }
    if (Reflect.hasMetadata(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_2__.PRE_DESTROY, constr)) {
        throw new Error((0,_constants_error_msgs__WEBPACK_IMPORTED_MODULE_3__.PRE_DESTROY_ERROR)(constr.name, scopeErrorMessage));
    }
}
function resolveInstance(binding, constr, childRequests, resolveRequest) {
    _validateInstanceResolution(binding, constr);
    var result = _createInstance(constr, childRequests, resolveRequest);
    if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_1__.isPromise)(result)) {
        return result.then(function (resolvedResult) { return _getInstanceAfterPostConstruct(constr, resolvedResult); });
    }
    else {
        return _getInstanceAfterPostConstruct(constr, result);
    }
}

//# sourceMappingURL=instantiation.js.map

/***/ }),

/***/ "./node_modules/inversify/es/resolution/resolver.js":
/*!**********************************************************!*\
  !*** ./node_modules/inversify/es/resolution/resolver.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "resolve": function() { return /* binding */ resolve; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _planning_planner__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../planning/planner */ "./node_modules/inversify/es/planning/planner.js");
/* harmony import */ var _scope_scope__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../scope/scope */ "./node_modules/inversify/es/scope/scope.js");
/* harmony import */ var _utils_async__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../utils/async */ "./node_modules/inversify/es/utils/async.js");
/* harmony import */ var _utils_binding_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/binding_utils */ "./node_modules/inversify/es/utils/binding_utils.js");
/* harmony import */ var _utils_exceptions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/exceptions */ "./node_modules/inversify/es/utils/exceptions.js");
/* harmony import */ var _instantiation__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./instantiation */ "./node_modules/inversify/es/resolution/instantiation.js");
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (undefined && undefined.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};








var _resolveRequest = function (requestScope) {
    return function (request) {
        request.parentContext.setCurrentRequest(request);
        var bindings = request.bindings;
        var childRequests = request.childRequests;
        var targetIsAnArray = request.target && request.target.isArray();
        var targetParentIsNotAnArray = !request.parentRequest ||
            !request.parentRequest.target ||
            !request.target ||
            !request.parentRequest.target.matchesArray(request.target.serviceIdentifier);
        if (targetIsAnArray && targetParentIsNotAnArray) {
            return childRequests.map(function (childRequest) {
                var _f = _resolveRequest(requestScope);
                return _f(childRequest);
            });
        }
        else {
            if (request.target.isOptional() && bindings.length === 0) {
                return undefined;
            }
            var binding = bindings[0];
            return _resolveBinding(requestScope, request, binding);
        }
    };
};
var _resolveFactoryFromBinding = function (binding, context) {
    var factoryDetails = (0,_utils_binding_utils__WEBPACK_IMPORTED_MODULE_0__.getFactoryDetails)(binding);
    return (0,_utils_exceptions__WEBPACK_IMPORTED_MODULE_1__.tryAndThrowErrorIfStackOverflow)(function () { return factoryDetails.factory.bind(binding)(context); }, function () { return new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__.CIRCULAR_DEPENDENCY_IN_FACTORY(factoryDetails.factoryType, context.currentRequest.serviceIdentifier.toString())); });
};
var _getResolvedFromBinding = function (requestScope, request, binding) {
    var result;
    var childRequests = request.childRequests;
    (0,_utils_binding_utils__WEBPACK_IMPORTED_MODULE_0__.ensureFullyBound)(binding);
    switch (binding.type) {
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_3__.BindingTypeEnum.ConstantValue:
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_3__.BindingTypeEnum.Function:
            result = binding.cache;
            break;
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_3__.BindingTypeEnum.Constructor:
            result = binding.implementationType;
            break;
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_3__.BindingTypeEnum.Instance:
            result = (0,_instantiation__WEBPACK_IMPORTED_MODULE_4__.resolveInstance)(binding, binding.implementationType, childRequests, _resolveRequest(requestScope));
            break;
        default:
            result = _resolveFactoryFromBinding(binding, request.parentContext);
    }
    return result;
};
var _resolveInScope = function (requestScope, binding, resolveFromBinding) {
    var result = (0,_scope_scope__WEBPACK_IMPORTED_MODULE_5__.tryGetFromScope)(requestScope, binding);
    if (result !== null) {
        return result;
    }
    result = resolveFromBinding();
    (0,_scope_scope__WEBPACK_IMPORTED_MODULE_5__.saveToScope)(requestScope, binding, result);
    return result;
};
var _resolveBinding = function (requestScope, request, binding) {
    return _resolveInScope(requestScope, binding, function () {
        var result = _getResolvedFromBinding(requestScope, request, binding);
        if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_6__.isPromise)(result)) {
            result = result.then(function (resolved) { return _onActivation(request, binding, resolved); });
        }
        else {
            result = _onActivation(request, binding, result);
        }
        return result;
    });
};
function _onActivation(request, binding, resolved) {
    var result = _bindingActivation(request.parentContext, binding, resolved);
    var containersIterator = _getContainersIterator(request.parentContext.container);
    var container;
    var containersIteratorResult = containersIterator.next();
    do {
        container = containersIteratorResult.value;
        var context_1 = request.parentContext;
        var serviceIdentifier = request.serviceIdentifier;
        var activationsIterator = _getContainerActivationsForService(container, serviceIdentifier);
        if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_6__.isPromise)(result)) {
            result = _activateContainerAsync(activationsIterator, context_1, result);
        }
        else {
            result = _activateContainer(activationsIterator, context_1, result);
        }
        containersIteratorResult = containersIterator.next();
    } while (containersIteratorResult.done !== true && !(0,_planning_planner__WEBPACK_IMPORTED_MODULE_7__.getBindingDictionary)(container).hasKey(request.serviceIdentifier));
    return result;
}
var _bindingActivation = function (context, binding, previousResult) {
    var result;
    if (typeof binding.onActivation === "function") {
        result = binding.onActivation(context, previousResult);
    }
    else {
        result = previousResult;
    }
    return result;
};
var _activateContainer = function (activationsIterator, context, result) {
    var activation = activationsIterator.next();
    while (!activation.done) {
        result = activation.value(context, result);
        if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_6__.isPromise)(result)) {
            return _activateContainerAsync(activationsIterator, context, result);
        }
        activation = activationsIterator.next();
    }
    return result;
};
var _activateContainerAsync = function (activationsIterator, context, resultPromise) { return __awaiter(void 0, void 0, void 0, function () {
    var result, activation;
    return __generator(this, function (_a) {
        switch (_a.label) {
            case 0: return [4, resultPromise];
            case 1:
                result = _a.sent();
                activation = activationsIterator.next();
                _a.label = 2;
            case 2:
                if (!!activation.done) return [3, 4];
                return [4, activation.value(context, result)];
            case 3:
                result = _a.sent();
                activation = activationsIterator.next();
                return [3, 2];
            case 4: return [2, result];
        }
    });
}); };
var _getContainerActivationsForService = function (container, serviceIdentifier) {
    var activations = container._activations;
    return activations.hasKey(serviceIdentifier) ? activations.get(serviceIdentifier).values() : [].values();
};
var _getContainersIterator = function (container) {
    var containersStack = [container];
    var parent = container.parent;
    while (parent !== null) {
        containersStack.push(parent);
        parent = parent.parent;
    }
    var getNextContainer = function () {
        var nextContainer = containersStack.pop();
        if (nextContainer !== undefined) {
            return { done: false, value: nextContainer };
        }
        else {
            return { done: true, value: undefined };
        }
    };
    var containersIterator = {
        next: getNextContainer,
    };
    return containersIterator;
};
function resolve(context) {
    var _f = _resolveRequest(context.plan.rootRequest.requestScope);
    return _f(context.plan.rootRequest);
}

//# sourceMappingURL=resolver.js.map

/***/ }),

/***/ "./node_modules/inversify/es/scope/scope.js":
/*!**************************************************!*\
  !*** ./node_modules/inversify/es/scope/scope.js ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "tryGetFromScope": function() { return /* binding */ tryGetFromScope; },
/* harmony export */   "saveToScope": function() { return /* binding */ saveToScope; }
/* harmony export */ });
/* harmony import */ var _inversify__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../inversify */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _utils_async__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/async */ "./node_modules/inversify/es/utils/async.js");
var __awaiter = (undefined && undefined.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (undefined && undefined.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};


var tryGetFromScope = function (requestScope, binding) {
    if ((binding.scope === _inversify__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton) && binding.activated) {
        return binding.cache;
    }
    if (binding.scope === _inversify__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Request &&
        requestScope.has(binding.id)) {
        return requestScope.get(binding.id);
    }
    return null;
};
var saveToScope = function (requestScope, binding, result) {
    if (binding.scope === _inversify__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton) {
        _saveToSingletonScope(binding, result);
    }
    if (binding.scope === _inversify__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Request) {
        _saveToRequestScope(requestScope, binding, result);
    }
};
var _saveToRequestScope = function (requestScope, binding, result) {
    if (!requestScope.has(binding.id)) {
        requestScope.set(binding.id, result);
    }
};
var _saveToSingletonScope = function (binding, result) {
    binding.cache = result;
    binding.activated = true;
    if ((0,_utils_async__WEBPACK_IMPORTED_MODULE_1__.isPromise)(result)) {
        void _saveAsyncResultToSingletonScope(binding, result);
    }
};
var _saveAsyncResultToSingletonScope = function (binding, asyncResult) { return __awaiter(void 0, void 0, void 0, function () {
    var result, ex_1;
    return __generator(this, function (_a) {
        switch (_a.label) {
            case 0:
                _a.trys.push([0, 2, , 3]);
                return [4, asyncResult];
            case 1:
                result = _a.sent();
                binding.cache = result;
                return [3, 3];
            case 2:
                ex_1 = _a.sent();
                binding.cache = null;
                binding.activated = false;
                throw ex_1;
            case 3: return [2];
        }
    });
}); };
//# sourceMappingURL=scope.js.map

/***/ }),

/***/ "./node_modules/inversify/es/syntax/binding_in_syntax.js":
/*!***************************************************************!*\
  !*** ./node_modules/inversify/es/syntax/binding_in_syntax.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingInSyntax": function() { return /* binding */ BindingInSyntax; }
/* harmony export */ });
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./binding_when_on_syntax */ "./node_modules/inversify/es/syntax/binding_when_on_syntax.js");


var BindingInSyntax = (function () {
    function BindingInSyntax(binding) {
        this._binding = binding;
    }
    BindingInSyntax.prototype.inRequestScope = function () {
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Request;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_1__.BindingWhenOnSyntax(this._binding);
    };
    BindingInSyntax.prototype.inSingletonScope = function () {
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_1__.BindingWhenOnSyntax(this._binding);
    };
    BindingInSyntax.prototype.inTransientScope = function () {
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Transient;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_1__.BindingWhenOnSyntax(this._binding);
    };
    return BindingInSyntax;
}());

//# sourceMappingURL=binding_in_syntax.js.map

/***/ }),

/***/ "./node_modules/inversify/es/syntax/binding_in_when_on_syntax.js":
/*!***********************************************************************!*\
  !*** ./node_modules/inversify/es/syntax/binding_in_when_on_syntax.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingInWhenOnSyntax": function() { return /* binding */ BindingInWhenOnSyntax; }
/* harmony export */ });
/* harmony import */ var _binding_in_syntax__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./binding_in_syntax */ "./node_modules/inversify/es/syntax/binding_in_syntax.js");
/* harmony import */ var _binding_on_syntax__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./binding_on_syntax */ "./node_modules/inversify/es/syntax/binding_on_syntax.js");
/* harmony import */ var _binding_when_syntax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./binding_when_syntax */ "./node_modules/inversify/es/syntax/binding_when_syntax.js");



var BindingInWhenOnSyntax = (function () {
    function BindingInWhenOnSyntax(binding) {
        this._binding = binding;
        this._bindingWhenSyntax = new _binding_when_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingWhenSyntax(this._binding);
        this._bindingOnSyntax = new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_1__.BindingOnSyntax(this._binding);
        this._bindingInSyntax = new _binding_in_syntax__WEBPACK_IMPORTED_MODULE_2__.BindingInSyntax(binding);
    }
    BindingInWhenOnSyntax.prototype.inRequestScope = function () {
        return this._bindingInSyntax.inRequestScope();
    };
    BindingInWhenOnSyntax.prototype.inSingletonScope = function () {
        return this._bindingInSyntax.inSingletonScope();
    };
    BindingInWhenOnSyntax.prototype.inTransientScope = function () {
        return this._bindingInSyntax.inTransientScope();
    };
    BindingInWhenOnSyntax.prototype.when = function (constraint) {
        return this._bindingWhenSyntax.when(constraint);
    };
    BindingInWhenOnSyntax.prototype.whenTargetNamed = function (name) {
        return this._bindingWhenSyntax.whenTargetNamed(name);
    };
    BindingInWhenOnSyntax.prototype.whenTargetIsDefault = function () {
        return this._bindingWhenSyntax.whenTargetIsDefault();
    };
    BindingInWhenOnSyntax.prototype.whenTargetTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenTargetTagged(tag, value);
    };
    BindingInWhenOnSyntax.prototype.whenInjectedInto = function (parent) {
        return this._bindingWhenSyntax.whenInjectedInto(parent);
    };
    BindingInWhenOnSyntax.prototype.whenParentNamed = function (name) {
        return this._bindingWhenSyntax.whenParentNamed(name);
    };
    BindingInWhenOnSyntax.prototype.whenParentTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenParentTagged(tag, value);
    };
    BindingInWhenOnSyntax.prototype.whenAnyAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenAnyAncestorIs(ancestor);
    };
    BindingInWhenOnSyntax.prototype.whenNoAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenNoAncestorIs(ancestor);
    };
    BindingInWhenOnSyntax.prototype.whenAnyAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenAnyAncestorNamed(name);
    };
    BindingInWhenOnSyntax.prototype.whenAnyAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenAnyAncestorTagged(tag, value);
    };
    BindingInWhenOnSyntax.prototype.whenNoAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenNoAncestorNamed(name);
    };
    BindingInWhenOnSyntax.prototype.whenNoAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenNoAncestorTagged(tag, value);
    };
    BindingInWhenOnSyntax.prototype.whenAnyAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenAnyAncestorMatches(constraint);
    };
    BindingInWhenOnSyntax.prototype.whenNoAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenNoAncestorMatches(constraint);
    };
    BindingInWhenOnSyntax.prototype.onActivation = function (handler) {
        return this._bindingOnSyntax.onActivation(handler);
    };
    BindingInWhenOnSyntax.prototype.onDeactivation = function (handler) {
        return this._bindingOnSyntax.onDeactivation(handler);
    };
    return BindingInWhenOnSyntax;
}());

//# sourceMappingURL=binding_in_when_on_syntax.js.map

/***/ }),

/***/ "./node_modules/inversify/es/syntax/binding_on_syntax.js":
/*!***************************************************************!*\
  !*** ./node_modules/inversify/es/syntax/binding_on_syntax.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingOnSyntax": function() { return /* binding */ BindingOnSyntax; }
/* harmony export */ });
/* harmony import */ var _binding_when_syntax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./binding_when_syntax */ "./node_modules/inversify/es/syntax/binding_when_syntax.js");

var BindingOnSyntax = (function () {
    function BindingOnSyntax(binding) {
        this._binding = binding;
    }
    BindingOnSyntax.prototype.onActivation = function (handler) {
        this._binding.onActivation = handler;
        return new _binding_when_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingWhenSyntax(this._binding);
    };
    BindingOnSyntax.prototype.onDeactivation = function (handler) {
        this._binding.onDeactivation = handler;
        return new _binding_when_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingWhenSyntax(this._binding);
    };
    return BindingOnSyntax;
}());

//# sourceMappingURL=binding_on_syntax.js.map

/***/ }),

/***/ "./node_modules/inversify/es/syntax/binding_to_syntax.js":
/*!***************************************************************!*\
  !*** ./node_modules/inversify/es/syntax/binding_to_syntax.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingToSyntax": function() { return /* binding */ BindingToSyntax; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _binding_in_when_on_syntax__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./binding_in_when_on_syntax */ "./node_modules/inversify/es/syntax/binding_in_when_on_syntax.js");
/* harmony import */ var _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./binding_when_on_syntax */ "./node_modules/inversify/es/syntax/binding_when_on_syntax.js");




var BindingToSyntax = (function () {
    function BindingToSyntax(binding) {
        this._binding = binding;
    }
    BindingToSyntax.prototype.to = function (constructor) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Instance;
        this._binding.implementationType = constructor;
        return new _binding_in_when_on_syntax__WEBPACK_IMPORTED_MODULE_1__.BindingInWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toSelf = function () {
        if (typeof this._binding.serviceIdentifier !== "function") {
            throw new Error("" + _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__.INVALID_TO_SELF_VALUE);
        }
        var self = this._binding.serviceIdentifier;
        return this.to(self);
    };
    BindingToSyntax.prototype.toConstantValue = function (value) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.ConstantValue;
        this._binding.cache = value;
        this._binding.dynamicValue = null;
        this._binding.implementationType = null;
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_3__.BindingWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toDynamicValue = function (func) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.DynamicValue;
        this._binding.cache = null;
        this._binding.dynamicValue = func;
        this._binding.implementationType = null;
        return new _binding_in_when_on_syntax__WEBPACK_IMPORTED_MODULE_1__.BindingInWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toConstructor = function (constructor) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Constructor;
        this._binding.implementationType = constructor;
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_3__.BindingWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toFactory = function (factory) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Factory;
        this._binding.factory = factory;
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_3__.BindingWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toFunction = function (func) {
        if (typeof func !== "function") {
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__.INVALID_FUNCTION_BINDING);
        }
        var bindingWhenOnSyntax = this.toConstantValue(func);
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Function;
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton;
        return bindingWhenOnSyntax;
    };
    BindingToSyntax.prototype.toAutoFactory = function (serviceIdentifier) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Factory;
        this._binding.factory = function (context) {
            var autofactory = function () { return context.container.get(serviceIdentifier); };
            return autofactory;
        };
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_3__.BindingWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toAutoNamedFactory = function (serviceIdentifier) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Factory;
        this._binding.factory = function (context) {
            return function (named) { return context.container.getNamed(serviceIdentifier, named); };
        };
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_3__.BindingWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toProvider = function (provider) {
        this._binding.type = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Provider;
        this._binding.provider = provider;
        this._binding.scope = _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingScopeEnum.Singleton;
        return new _binding_when_on_syntax__WEBPACK_IMPORTED_MODULE_3__.BindingWhenOnSyntax(this._binding);
    };
    BindingToSyntax.prototype.toService = function (service) {
        this.toDynamicValue(function (context) { return context.container.get(service); });
    };
    return BindingToSyntax;
}());

//# sourceMappingURL=binding_to_syntax.js.map

/***/ }),

/***/ "./node_modules/inversify/es/syntax/binding_when_on_syntax.js":
/*!********************************************************************!*\
  !*** ./node_modules/inversify/es/syntax/binding_when_on_syntax.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingWhenOnSyntax": function() { return /* binding */ BindingWhenOnSyntax; }
/* harmony export */ });
/* harmony import */ var _binding_on_syntax__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./binding_on_syntax */ "./node_modules/inversify/es/syntax/binding_on_syntax.js");
/* harmony import */ var _binding_when_syntax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./binding_when_syntax */ "./node_modules/inversify/es/syntax/binding_when_syntax.js");


var BindingWhenOnSyntax = (function () {
    function BindingWhenOnSyntax(binding) {
        this._binding = binding;
        this._bindingWhenSyntax = new _binding_when_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingWhenSyntax(this._binding);
        this._bindingOnSyntax = new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_1__.BindingOnSyntax(this._binding);
    }
    BindingWhenOnSyntax.prototype.when = function (constraint) {
        return this._bindingWhenSyntax.when(constraint);
    };
    BindingWhenOnSyntax.prototype.whenTargetNamed = function (name) {
        return this._bindingWhenSyntax.whenTargetNamed(name);
    };
    BindingWhenOnSyntax.prototype.whenTargetIsDefault = function () {
        return this._bindingWhenSyntax.whenTargetIsDefault();
    };
    BindingWhenOnSyntax.prototype.whenTargetTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenTargetTagged(tag, value);
    };
    BindingWhenOnSyntax.prototype.whenInjectedInto = function (parent) {
        return this._bindingWhenSyntax.whenInjectedInto(parent);
    };
    BindingWhenOnSyntax.prototype.whenParentNamed = function (name) {
        return this._bindingWhenSyntax.whenParentNamed(name);
    };
    BindingWhenOnSyntax.prototype.whenParentTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenParentTagged(tag, value);
    };
    BindingWhenOnSyntax.prototype.whenAnyAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenAnyAncestorIs(ancestor);
    };
    BindingWhenOnSyntax.prototype.whenNoAncestorIs = function (ancestor) {
        return this._bindingWhenSyntax.whenNoAncestorIs(ancestor);
    };
    BindingWhenOnSyntax.prototype.whenAnyAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenAnyAncestorNamed(name);
    };
    BindingWhenOnSyntax.prototype.whenAnyAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenAnyAncestorTagged(tag, value);
    };
    BindingWhenOnSyntax.prototype.whenNoAncestorNamed = function (name) {
        return this._bindingWhenSyntax.whenNoAncestorNamed(name);
    };
    BindingWhenOnSyntax.prototype.whenNoAncestorTagged = function (tag, value) {
        return this._bindingWhenSyntax.whenNoAncestorTagged(tag, value);
    };
    BindingWhenOnSyntax.prototype.whenAnyAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenAnyAncestorMatches(constraint);
    };
    BindingWhenOnSyntax.prototype.whenNoAncestorMatches = function (constraint) {
        return this._bindingWhenSyntax.whenNoAncestorMatches(constraint);
    };
    BindingWhenOnSyntax.prototype.onActivation = function (handler) {
        return this._bindingOnSyntax.onActivation(handler);
    };
    BindingWhenOnSyntax.prototype.onDeactivation = function (handler) {
        return this._bindingOnSyntax.onDeactivation(handler);
    };
    return BindingWhenOnSyntax;
}());

//# sourceMappingURL=binding_when_on_syntax.js.map

/***/ }),

/***/ "./node_modules/inversify/es/syntax/binding_when_syntax.js":
/*!*****************************************************************!*\
  !*** ./node_modules/inversify/es/syntax/binding_when_syntax.js ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BindingWhenSyntax": function() { return /* binding */ BindingWhenSyntax; }
/* harmony export */ });
/* harmony import */ var _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./binding_on_syntax */ "./node_modules/inversify/es/syntax/binding_on_syntax.js");
/* harmony import */ var _constraint_helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./constraint_helpers */ "./node_modules/inversify/es/syntax/constraint_helpers.js");


var BindingWhenSyntax = (function () {
    function BindingWhenSyntax(binding) {
        this._binding = binding;
    }
    BindingWhenSyntax.prototype.when = function (constraint) {
        this._binding.constraint = constraint;
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenTargetNamed = function (name) {
        this._binding.constraint = (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.namedConstraint)(name);
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenTargetIsDefault = function () {
        this._binding.constraint = function (request) {
            if (request === null) {
                return false;
            }
            var targetIsDefault = (request.target !== null) &&
                (!request.target.isNamed()) &&
                (!request.target.isTagged());
            return targetIsDefault;
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenTargetTagged = function (tag, value) {
        this._binding.constraint = (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.taggedConstraint)(tag)(value);
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenInjectedInto = function (parent) {
        this._binding.constraint = function (request) {
            return request !== null && (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.typeConstraint)(parent)(request.parentRequest);
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenParentNamed = function (name) {
        this._binding.constraint = function (request) {
            return request !== null && (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.namedConstraint)(name)(request.parentRequest);
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenParentTagged = function (tag, value) {
        this._binding.constraint = function (request) {
            return request !== null && (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.taggedConstraint)(tag)(value)(request.parentRequest);
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenAnyAncestorIs = function (ancestor) {
        this._binding.constraint = function (request) {
            return request !== null && (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.typeConstraint)(ancestor));
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenNoAncestorIs = function (ancestor) {
        this._binding.constraint = function (request) {
            return request !== null && !(0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.typeConstraint)(ancestor));
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenAnyAncestorNamed = function (name) {
        this._binding.constraint = function (request) {
            return request !== null && (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.namedConstraint)(name));
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenNoAncestorNamed = function (name) {
        this._binding.constraint = function (request) {
            return request !== null && !(0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.namedConstraint)(name));
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenAnyAncestorTagged = function (tag, value) {
        this._binding.constraint = function (request) {
            return request !== null && (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.taggedConstraint)(tag)(value));
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenNoAncestorTagged = function (tag, value) {
        this._binding.constraint = function (request) {
            return request !== null && !(0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.taggedConstraint)(tag)(value));
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenAnyAncestorMatches = function (constraint) {
        this._binding.constraint = function (request) {
            return request !== null && (0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, constraint);
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    BindingWhenSyntax.prototype.whenNoAncestorMatches = function (constraint) {
        this._binding.constraint = function (request) {
            return request !== null && !(0,_constraint_helpers__WEBPACK_IMPORTED_MODULE_1__.traverseAncerstors)(request, constraint);
        };
        return new _binding_on_syntax__WEBPACK_IMPORTED_MODULE_0__.BindingOnSyntax(this._binding);
    };
    return BindingWhenSyntax;
}());

//# sourceMappingURL=binding_when_syntax.js.map

/***/ }),

/***/ "./node_modules/inversify/es/syntax/constraint_helpers.js":
/*!****************************************************************!*\
  !*** ./node_modules/inversify/es/syntax/constraint_helpers.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "traverseAncerstors": function() { return /* binding */ traverseAncerstors; },
/* harmony export */   "taggedConstraint": function() { return /* binding */ taggedConstraint; },
/* harmony export */   "namedConstraint": function() { return /* binding */ namedConstraint; },
/* harmony export */   "typeConstraint": function() { return /* binding */ typeConstraint; }
/* harmony export */ });
/* harmony import */ var _constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../constants/metadata_keys */ "./node_modules/inversify/es/constants/metadata_keys.js");
/* harmony import */ var _planning_metadata__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../planning/metadata */ "./node_modules/inversify/es/planning/metadata.js");


var traverseAncerstors = function (request, constraint) {
    var parent = request.parentRequest;
    if (parent !== null) {
        return constraint(parent) ? true : traverseAncerstors(parent, constraint);
    }
    else {
        return false;
    }
};
var taggedConstraint = function (key) { return function (value) {
    var constraint = function (request) {
        return request !== null && request.target !== null && request.target.matchesTag(key)(value);
    };
    constraint.metaData = new _planning_metadata__WEBPACK_IMPORTED_MODULE_0__.Metadata(key, value);
    return constraint;
}; };
var namedConstraint = taggedConstraint(_constants_metadata_keys__WEBPACK_IMPORTED_MODULE_1__.NAMED_TAG);
var typeConstraint = function (type) { return function (request) {
    var binding = null;
    if (request !== null) {
        binding = request.bindings[0];
        if (typeof type === "string") {
            var serviceIdentifier = binding.serviceIdentifier;
            return serviceIdentifier === type;
        }
        else {
            var constructor = request.bindings[0].implementationType;
            return type === constructor;
        }
    }
    return false;
}; };

//# sourceMappingURL=constraint_helpers.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/async.js":
/*!**************************************************!*\
  !*** ./node_modules/inversify/es/utils/async.js ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isPromise": function() { return /* binding */ isPromise; },
/* harmony export */   "isPromiseOrContainsPromise": function() { return /* binding */ isPromiseOrContainsPromise; }
/* harmony export */ });
function isPromise(object) {
    var isObjectOrFunction = (typeof object === 'object' && object !== null) || typeof object === 'function';
    return isObjectOrFunction && typeof object.then === "function";
}
function isPromiseOrContainsPromise(object) {
    if (isPromise(object)) {
        return true;
    }
    return Array.isArray(object) && object.some(isPromise);
}

//# sourceMappingURL=async.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/binding_utils.js":
/*!**********************************************************!*\
  !*** ./node_modules/inversify/es/utils/binding_utils.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "multiBindToService": function() { return /* binding */ multiBindToService; },
/* harmony export */   "ensureFullyBound": function() { return /* binding */ ensureFullyBound; },
/* harmony export */   "getFactoryDetails": function() { return /* binding */ getFactoryDetails; }
/* harmony export */ });
/* harmony import */ var _inversify__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../inversify */ "./node_modules/inversify/es/utils/serialization.js");
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");
/* harmony import */ var _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/literal_types */ "./node_modules/inversify/es/constants/literal_types.js");
/* harmony import */ var _factory_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./factory_type */ "./node_modules/inversify/es/utils/factory_type.js");




var multiBindToService = function (container) {
    return function (service) {
        return function () {
            var types = [];
            for (var _i = 0; _i < arguments.length; _i++) {
                types[_i] = arguments[_i];
            }
            return types.forEach(function (t) { return container.bind(t).toService(service); });
        };
    };
};
var ensureFullyBound = function (binding) {
    var boundValue = null;
    switch (binding.type) {
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.ConstantValue:
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Function:
            boundValue = binding.cache;
            break;
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Constructor:
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Instance:
            boundValue = binding.implementationType;
            break;
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.DynamicValue:
            boundValue = binding.dynamicValue;
            break;
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Provider:
            boundValue = binding.provider;
            break;
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Factory:
            boundValue = binding.factory;
            break;
    }
    if (boundValue === null) {
        var serviceIdentifierAsString = (0,_inversify__WEBPACK_IMPORTED_MODULE_1__.getServiceIdentifierAsString)(binding.serviceIdentifier);
        throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_2__.INVALID_BINDING_TYPE + " " + serviceIdentifierAsString);
    }
};
var getFactoryDetails = function (binding) {
    switch (binding.type) {
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Factory:
            return { factory: binding.factory, factoryType: _factory_type__WEBPACK_IMPORTED_MODULE_3__.FactoryType.Factory };
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.Provider:
            return { factory: binding.provider, factoryType: _factory_type__WEBPACK_IMPORTED_MODULE_3__.FactoryType.Provider };
        case _constants_literal_types__WEBPACK_IMPORTED_MODULE_0__.BindingTypeEnum.DynamicValue:
            return { factory: binding.dynamicValue, factoryType: _factory_type__WEBPACK_IMPORTED_MODULE_3__.FactoryType.DynamicValue };
        default:
            throw new Error("Unexpected factory type " + binding.type);
    }
};
//# sourceMappingURL=binding_utils.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/clonable.js":
/*!*****************************************************!*\
  !*** ./node_modules/inversify/es/utils/clonable.js ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isClonable": function() { return /* binding */ isClonable; }
/* harmony export */ });
function isClonable(obj) {
    return (typeof obj === 'object')
        && (obj !== null)
        && ('clone' in obj)
        && typeof obj.clone === 'function';
}

//# sourceMappingURL=clonable.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/exceptions.js":
/*!*******************************************************!*\
  !*** ./node_modules/inversify/es/utils/exceptions.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isStackOverflowExeption": function() { return /* binding */ isStackOverflowExeption; },
/* harmony export */   "tryAndThrowErrorIfStackOverflow": function() { return /* binding */ tryAndThrowErrorIfStackOverflow; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");

function isStackOverflowExeption(error) {
    return (error instanceof RangeError ||
        error.message === _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.STACK_OVERFLOW);
}
var tryAndThrowErrorIfStackOverflow = function (fn, errorCallback) {
    try {
        return fn();
    }
    catch (error) {
        if (isStackOverflowExeption(error)) {
            error = errorCallback();
        }
        throw error;
    }
};
//# sourceMappingURL=exceptions.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/factory_type.js":
/*!*********************************************************!*\
  !*** ./node_modules/inversify/es/utils/factory_type.js ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "FactoryType": function() { return /* binding */ FactoryType; }
/* harmony export */ });
var FactoryType;
(function (FactoryType) {
    FactoryType["DynamicValue"] = "toDynamicValue";
    FactoryType["Factory"] = "toFactory";
    FactoryType["Provider"] = "toProvider";
})(FactoryType || (FactoryType = {}));
//# sourceMappingURL=factory_type.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/id.js":
/*!***********************************************!*\
  !*** ./node_modules/inversify/es/utils/id.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "id": function() { return /* binding */ id; }
/* harmony export */ });
var idCounter = 0;
function id() {
    return idCounter++;
}

//# sourceMappingURL=id.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/js.js":
/*!***********************************************!*\
  !*** ./node_modules/inversify/es/utils/js.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getFirstArrayDuplicate": function() { return /* binding */ getFirstArrayDuplicate; }
/* harmony export */ });
function getFirstArrayDuplicate(array) {
    var seenValues = new Set();
    for (var _i = 0, array_1 = array; _i < array_1.length; _i++) {
        var entry = array_1[_i];
        if (seenValues.has(entry)) {
            return entry;
        }
        else {
            seenValues.add(entry);
        }
    }
    return undefined;
}
//# sourceMappingURL=js.js.map

/***/ }),

/***/ "./node_modules/inversify/es/utils/serialization.js":
/*!**********************************************************!*\
  !*** ./node_modules/inversify/es/utils/serialization.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getFunctionName": function() { return /* binding */ getFunctionName; },
/* harmony export */   "getServiceIdentifierAsString": function() { return /* binding */ getServiceIdentifierAsString; },
/* harmony export */   "listRegisteredBindingsForServiceIdentifier": function() { return /* binding */ listRegisteredBindingsForServiceIdentifier; },
/* harmony export */   "listMetadataForTarget": function() { return /* binding */ listMetadataForTarget; },
/* harmony export */   "circularDependencyToException": function() { return /* binding */ circularDependencyToException; },
/* harmony export */   "getSymbolDescription": function() { return /* binding */ getSymbolDescription; }
/* harmony export */ });
/* harmony import */ var _constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants/error_msgs */ "./node_modules/inversify/es/constants/error_msgs.js");

function getServiceIdentifierAsString(serviceIdentifier) {
    if (typeof serviceIdentifier === "function") {
        var _serviceIdentifier = serviceIdentifier;
        return _serviceIdentifier.name;
    }
    else if (typeof serviceIdentifier === "symbol") {
        return serviceIdentifier.toString();
    }
    else {
        var _serviceIdentifier = serviceIdentifier;
        return _serviceIdentifier;
    }
}
function listRegisteredBindingsForServiceIdentifier(container, serviceIdentifier, getBindings) {
    var registeredBindingsList = "";
    var registeredBindings = getBindings(container, serviceIdentifier);
    if (registeredBindings.length !== 0) {
        registeredBindingsList = "\nRegistered bindings:";
        registeredBindings.forEach(function (binding) {
            var name = "Object";
            if (binding.implementationType !== null) {
                name = getFunctionName(binding.implementationType);
            }
            registeredBindingsList = registeredBindingsList + "\n " + name;
            if (binding.constraint.metaData) {
                registeredBindingsList = registeredBindingsList + " - " + binding.constraint.metaData;
            }
        });
    }
    return registeredBindingsList;
}
function alreadyDependencyChain(request, serviceIdentifier) {
    if (request.parentRequest === null) {
        return false;
    }
    else if (request.parentRequest.serviceIdentifier === serviceIdentifier) {
        return true;
    }
    else {
        return alreadyDependencyChain(request.parentRequest, serviceIdentifier);
    }
}
function dependencyChainToString(request) {
    function _createStringArr(req, result) {
        if (result === void 0) { result = []; }
        var serviceIdentifier = getServiceIdentifierAsString(req.serviceIdentifier);
        result.push(serviceIdentifier);
        if (req.parentRequest !== null) {
            return _createStringArr(req.parentRequest, result);
        }
        return result;
    }
    var stringArr = _createStringArr(request);
    return stringArr.reverse().join(" --> ");
}
function circularDependencyToException(request) {
    request.childRequests.forEach(function (childRequest) {
        if (alreadyDependencyChain(childRequest, childRequest.serviceIdentifier)) {
            var services = dependencyChainToString(childRequest);
            throw new Error(_constants_error_msgs__WEBPACK_IMPORTED_MODULE_0__.CIRCULAR_DEPENDENCY + " " + services);
        }
        else {
            circularDependencyToException(childRequest);
        }
    });
}
function listMetadataForTarget(serviceIdentifierString, target) {
    if (target.isTagged() || target.isNamed()) {
        var m_1 = "";
        var namedTag = target.getNamedTag();
        var otherTags = target.getCustomTags();
        if (namedTag !== null) {
            m_1 += namedTag.toString() + "\n";
        }
        if (otherTags !== null) {
            otherTags.forEach(function (tag) {
                m_1 += tag.toString() + "\n";
            });
        }
        return " " + serviceIdentifierString + "\n " + serviceIdentifierString + " - " + m_1;
    }
    else {
        return " " + serviceIdentifierString;
    }
}
function getFunctionName(func) {
    if (func.name) {
        return func.name;
    }
    else {
        var name_1 = func.toString();
        var match = name_1.match(/^function\s*([^\s(]+)/);
        return match ? match[1] : "Anonymous function: " + name_1;
    }
}
function getSymbolDescription(symbol) {
    return symbol.toString().slice(7, -1);
}

//# sourceMappingURL=serialization.js.map

/***/ }),

/***/ "./resources/scss/Admin.scss":
/*!***********************************!*\
  !*** ./resources/scss/Admin.scss ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/Main.scss":
/*!**********************************!*\
  !*** ./resources/scss/Main.scss ***!
  \**********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/reflect-metadata/Reflect.js":
/*!**************************************************!*\
  !*** ./node_modules/reflect-metadata/Reflect.js ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, __unused_webpack_exports, __webpack_require__) {

/*! *****************************************************************************
Copyright (C) Microsoft. All rights reserved.
Licensed under the Apache License, Version 2.0 (the "License"); you may not use
this file except in compliance with the License. You may obtain a copy of the
License at http://www.apache.org/licenses/LICENSE-2.0

THIS CODE IS PROVIDED ON AN *AS IS* BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
KIND, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED
WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR PURPOSE,
MERCHANTABLITY OR NON-INFRINGEMENT.

See the Apache Version 2.0 License for specific language governing permissions
and limitations under the License.
***************************************************************************** */
var Reflect;
(function (Reflect) {
    // Metadata Proposal
    // https://rbuckton.github.io/reflect-metadata/
    (function (factory) {
        var root = typeof __webpack_require__.g === "object" ? __webpack_require__.g :
            typeof self === "object" ? self :
                typeof this === "object" ? this :
                    Function("return this;")();
        var exporter = makeExporter(Reflect);
        if (typeof root.Reflect === "undefined") {
            root.Reflect = Reflect;
        }
        else {
            exporter = makeExporter(root.Reflect, exporter);
        }
        factory(exporter);
        function makeExporter(target, previous) {
            return function (key, value) {
                if (typeof target[key] !== "function") {
                    Object.defineProperty(target, key, { configurable: true, writable: true, value: value });
                }
                if (previous)
                    previous(key, value);
            };
        }
    })(function (exporter) {
        var hasOwn = Object.prototype.hasOwnProperty;
        // feature test for Symbol support
        var supportsSymbol = typeof Symbol === "function";
        var toPrimitiveSymbol = supportsSymbol && typeof Symbol.toPrimitive !== "undefined" ? Symbol.toPrimitive : "@@toPrimitive";
        var iteratorSymbol = supportsSymbol && typeof Symbol.iterator !== "undefined" ? Symbol.iterator : "@@iterator";
        var supportsCreate = typeof Object.create === "function"; // feature test for Object.create support
        var supportsProto = { __proto__: [] } instanceof Array; // feature test for __proto__ support
        var downLevel = !supportsCreate && !supportsProto;
        var HashMap = {
            // create an object in dictionary mode (a.k.a. "slow" mode in v8)
            create: supportsCreate
                ? function () { return MakeDictionary(Object.create(null)); }
                : supportsProto
                    ? function () { return MakeDictionary({ __proto__: null }); }
                    : function () { return MakeDictionary({}); },
            has: downLevel
                ? function (map, key) { return hasOwn.call(map, key); }
                : function (map, key) { return key in map; },
            get: downLevel
                ? function (map, key) { return hasOwn.call(map, key) ? map[key] : undefined; }
                : function (map, key) { return map[key]; },
        };
        // Load global or shim versions of Map, Set, and WeakMap
        var functionPrototype = Object.getPrototypeOf(Function);
        var usePolyfill = typeof process === "object" && process.env && process.env["REFLECT_METADATA_USE_MAP_POLYFILL"] === "true";
        var _Map = !usePolyfill && typeof Map === "function" && typeof Map.prototype.entries === "function" ? Map : CreateMapPolyfill();
        var _Set = !usePolyfill && typeof Set === "function" && typeof Set.prototype.entries === "function" ? Set : CreateSetPolyfill();
        var _WeakMap = !usePolyfill && typeof WeakMap === "function" ? WeakMap : CreateWeakMapPolyfill();
        // [[Metadata]] internal slot
        // https://rbuckton.github.io/reflect-metadata/#ordinary-object-internal-methods-and-internal-slots
        var Metadata = new _WeakMap();
        /**
         * Applies a set of decorators to a property of a target object.
         * @param decorators An array of decorators.
         * @param target The target object.
         * @param propertyKey (Optional) The property key to decorate.
         * @param attributes (Optional) The property descriptor for the target key.
         * @remarks Decorators are applied in reverse order.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     Example = Reflect.decorate(decoratorsArray, Example);
         *
         *     // property (on constructor)
         *     Reflect.decorate(decoratorsArray, Example, "staticProperty");
         *
         *     // property (on prototype)
         *     Reflect.decorate(decoratorsArray, Example.prototype, "property");
         *
         *     // method (on constructor)
         *     Object.defineProperty(Example, "staticMethod",
         *         Reflect.decorate(decoratorsArray, Example, "staticMethod",
         *             Object.getOwnPropertyDescriptor(Example, "staticMethod")));
         *
         *     // method (on prototype)
         *     Object.defineProperty(Example.prototype, "method",
         *         Reflect.decorate(decoratorsArray, Example.prototype, "method",
         *             Object.getOwnPropertyDescriptor(Example.prototype, "method")));
         *
         */
        function decorate(decorators, target, propertyKey, attributes) {
            if (!IsUndefined(propertyKey)) {
                if (!IsArray(decorators))
                    throw new TypeError();
                if (!IsObject(target))
                    throw new TypeError();
                if (!IsObject(attributes) && !IsUndefined(attributes) && !IsNull(attributes))
                    throw new TypeError();
                if (IsNull(attributes))
                    attributes = undefined;
                propertyKey = ToPropertyKey(propertyKey);
                return DecorateProperty(decorators, target, propertyKey, attributes);
            }
            else {
                if (!IsArray(decorators))
                    throw new TypeError();
                if (!IsConstructor(target))
                    throw new TypeError();
                return DecorateConstructor(decorators, target);
            }
        }
        exporter("decorate", decorate);
        // 4.1.2 Reflect.metadata(metadataKey, metadataValue)
        // https://rbuckton.github.io/reflect-metadata/#reflect.metadata
        /**
         * A default metadata decorator factory that can be used on a class, class member, or parameter.
         * @param metadataKey The key for the metadata entry.
         * @param metadataValue The value for the metadata entry.
         * @returns A decorator function.
         * @remarks
         * If `metadataKey` is already defined for the target and target key, the
         * metadataValue for that key will be overwritten.
         * @example
         *
         *     // constructor
         *     @Reflect.metadata(key, value)
         *     class Example {
         *     }
         *
         *     // property (on constructor, TypeScript only)
         *     class Example {
         *         @Reflect.metadata(key, value)
         *         static staticProperty;
         *     }
         *
         *     // property (on prototype, TypeScript only)
         *     class Example {
         *         @Reflect.metadata(key, value)
         *         property;
         *     }
         *
         *     // method (on constructor)
         *     class Example {
         *         @Reflect.metadata(key, value)
         *         static staticMethod() { }
         *     }
         *
         *     // method (on prototype)
         *     class Example {
         *         @Reflect.metadata(key, value)
         *         method() { }
         *     }
         *
         */
        function metadata(metadataKey, metadataValue) {
            function decorator(target, propertyKey) {
                if (!IsObject(target))
                    throw new TypeError();
                if (!IsUndefined(propertyKey) && !IsPropertyKey(propertyKey))
                    throw new TypeError();
                OrdinaryDefineOwnMetadata(metadataKey, metadataValue, target, propertyKey);
            }
            return decorator;
        }
        exporter("metadata", metadata);
        /**
         * Define a unique metadata entry on the target.
         * @param metadataKey A key used to store and retrieve metadata.
         * @param metadataValue A value that contains attached metadata.
         * @param target The target object on which to define metadata.
         * @param propertyKey (Optional) The property key for the target.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     Reflect.defineMetadata("custom:annotation", options, Example);
         *
         *     // property (on constructor)
         *     Reflect.defineMetadata("custom:annotation", options, Example, "staticProperty");
         *
         *     // property (on prototype)
         *     Reflect.defineMetadata("custom:annotation", options, Example.prototype, "property");
         *
         *     // method (on constructor)
         *     Reflect.defineMetadata("custom:annotation", options, Example, "staticMethod");
         *
         *     // method (on prototype)
         *     Reflect.defineMetadata("custom:annotation", options, Example.prototype, "method");
         *
         *     // decorator factory as metadata-producing annotation.
         *     function MyAnnotation(options): Decorator {
         *         return (target, key?) => Reflect.defineMetadata("custom:annotation", options, target, key);
         *     }
         *
         */
        function defineMetadata(metadataKey, metadataValue, target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryDefineOwnMetadata(metadataKey, metadataValue, target, propertyKey);
        }
        exporter("defineMetadata", defineMetadata);
        /**
         * Gets a value indicating whether the target object or its prototype chain has the provided metadata key defined.
         * @param metadataKey A key used to store and retrieve metadata.
         * @param target The target object on which the metadata is defined.
         * @param propertyKey (Optional) The property key for the target.
         * @returns `true` if the metadata key was defined on the target object or its prototype chain; otherwise, `false`.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     result = Reflect.hasMetadata("custom:annotation", Example);
         *
         *     // property (on constructor)
         *     result = Reflect.hasMetadata("custom:annotation", Example, "staticProperty");
         *
         *     // property (on prototype)
         *     result = Reflect.hasMetadata("custom:annotation", Example.prototype, "property");
         *
         *     // method (on constructor)
         *     result = Reflect.hasMetadata("custom:annotation", Example, "staticMethod");
         *
         *     // method (on prototype)
         *     result = Reflect.hasMetadata("custom:annotation", Example.prototype, "method");
         *
         */
        function hasMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryHasMetadata(metadataKey, target, propertyKey);
        }
        exporter("hasMetadata", hasMetadata);
        /**
         * Gets a value indicating whether the target object has the provided metadata key defined.
         * @param metadataKey A key used to store and retrieve metadata.
         * @param target The target object on which the metadata is defined.
         * @param propertyKey (Optional) The property key for the target.
         * @returns `true` if the metadata key was defined on the target object; otherwise, `false`.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     result = Reflect.hasOwnMetadata("custom:annotation", Example);
         *
         *     // property (on constructor)
         *     result = Reflect.hasOwnMetadata("custom:annotation", Example, "staticProperty");
         *
         *     // property (on prototype)
         *     result = Reflect.hasOwnMetadata("custom:annotation", Example.prototype, "property");
         *
         *     // method (on constructor)
         *     result = Reflect.hasOwnMetadata("custom:annotation", Example, "staticMethod");
         *
         *     // method (on prototype)
         *     result = Reflect.hasOwnMetadata("custom:annotation", Example.prototype, "method");
         *
         */
        function hasOwnMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryHasOwnMetadata(metadataKey, target, propertyKey);
        }
        exporter("hasOwnMetadata", hasOwnMetadata);
        /**
         * Gets the metadata value for the provided metadata key on the target object or its prototype chain.
         * @param metadataKey A key used to store and retrieve metadata.
         * @param target The target object on which the metadata is defined.
         * @param propertyKey (Optional) The property key for the target.
         * @returns The metadata value for the metadata key if found; otherwise, `undefined`.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     result = Reflect.getMetadata("custom:annotation", Example);
         *
         *     // property (on constructor)
         *     result = Reflect.getMetadata("custom:annotation", Example, "staticProperty");
         *
         *     // property (on prototype)
         *     result = Reflect.getMetadata("custom:annotation", Example.prototype, "property");
         *
         *     // method (on constructor)
         *     result = Reflect.getMetadata("custom:annotation", Example, "staticMethod");
         *
         *     // method (on prototype)
         *     result = Reflect.getMetadata("custom:annotation", Example.prototype, "method");
         *
         */
        function getMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryGetMetadata(metadataKey, target, propertyKey);
        }
        exporter("getMetadata", getMetadata);
        /**
         * Gets the metadata value for the provided metadata key on the target object.
         * @param metadataKey A key used to store and retrieve metadata.
         * @param target The target object on which the metadata is defined.
         * @param propertyKey (Optional) The property key for the target.
         * @returns The metadata value for the metadata key if found; otherwise, `undefined`.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     result = Reflect.getOwnMetadata("custom:annotation", Example);
         *
         *     // property (on constructor)
         *     result = Reflect.getOwnMetadata("custom:annotation", Example, "staticProperty");
         *
         *     // property (on prototype)
         *     result = Reflect.getOwnMetadata("custom:annotation", Example.prototype, "property");
         *
         *     // method (on constructor)
         *     result = Reflect.getOwnMetadata("custom:annotation", Example, "staticMethod");
         *
         *     // method (on prototype)
         *     result = Reflect.getOwnMetadata("custom:annotation", Example.prototype, "method");
         *
         */
        function getOwnMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryGetOwnMetadata(metadataKey, target, propertyKey);
        }
        exporter("getOwnMetadata", getOwnMetadata);
        /**
         * Gets the metadata keys defined on the target object or its prototype chain.
         * @param target The target object on which the metadata is defined.
         * @param propertyKey (Optional) The property key for the target.
         * @returns An array of unique metadata keys.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     result = Reflect.getMetadataKeys(Example);
         *
         *     // property (on constructor)
         *     result = Reflect.getMetadataKeys(Example, "staticProperty");
         *
         *     // property (on prototype)
         *     result = Reflect.getMetadataKeys(Example.prototype, "property");
         *
         *     // method (on constructor)
         *     result = Reflect.getMetadataKeys(Example, "staticMethod");
         *
         *     // method (on prototype)
         *     result = Reflect.getMetadataKeys(Example.prototype, "method");
         *
         */
        function getMetadataKeys(target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryMetadataKeys(target, propertyKey);
        }
        exporter("getMetadataKeys", getMetadataKeys);
        /**
         * Gets the unique metadata keys defined on the target object.
         * @param target The target object on which the metadata is defined.
         * @param propertyKey (Optional) The property key for the target.
         * @returns An array of unique metadata keys.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     result = Reflect.getOwnMetadataKeys(Example);
         *
         *     // property (on constructor)
         *     result = Reflect.getOwnMetadataKeys(Example, "staticProperty");
         *
         *     // property (on prototype)
         *     result = Reflect.getOwnMetadataKeys(Example.prototype, "property");
         *
         *     // method (on constructor)
         *     result = Reflect.getOwnMetadataKeys(Example, "staticMethod");
         *
         *     // method (on prototype)
         *     result = Reflect.getOwnMetadataKeys(Example.prototype, "method");
         *
         */
        function getOwnMetadataKeys(target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            return OrdinaryOwnMetadataKeys(target, propertyKey);
        }
        exporter("getOwnMetadataKeys", getOwnMetadataKeys);
        /**
         * Deletes the metadata entry from the target object with the provided key.
         * @param metadataKey A key used to store and retrieve metadata.
         * @param target The target object on which the metadata is defined.
         * @param propertyKey (Optional) The property key for the target.
         * @returns `true` if the metadata entry was found and deleted; otherwise, false.
         * @example
         *
         *     class Example {
         *         // property declarations are not part of ES6, though they are valid in TypeScript:
         *         // static staticProperty;
         *         // property;
         *
         *         constructor(p) { }
         *         static staticMethod(p) { }
         *         method(p) { }
         *     }
         *
         *     // constructor
         *     result = Reflect.deleteMetadata("custom:annotation", Example);
         *
         *     // property (on constructor)
         *     result = Reflect.deleteMetadata("custom:annotation", Example, "staticProperty");
         *
         *     // property (on prototype)
         *     result = Reflect.deleteMetadata("custom:annotation", Example.prototype, "property");
         *
         *     // method (on constructor)
         *     result = Reflect.deleteMetadata("custom:annotation", Example, "staticMethod");
         *
         *     // method (on prototype)
         *     result = Reflect.deleteMetadata("custom:annotation", Example.prototype, "method");
         *
         */
        function deleteMetadata(metadataKey, target, propertyKey) {
            if (!IsObject(target))
                throw new TypeError();
            if (!IsUndefined(propertyKey))
                propertyKey = ToPropertyKey(propertyKey);
            var metadataMap = GetOrCreateMetadataMap(target, propertyKey, /*Create*/ false);
            if (IsUndefined(metadataMap))
                return false;
            if (!metadataMap.delete(metadataKey))
                return false;
            if (metadataMap.size > 0)
                return true;
            var targetMetadata = Metadata.get(target);
            targetMetadata.delete(propertyKey);
            if (targetMetadata.size > 0)
                return true;
            Metadata.delete(target);
            return true;
        }
        exporter("deleteMetadata", deleteMetadata);
        function DecorateConstructor(decorators, target) {
            for (var i = decorators.length - 1; i >= 0; --i) {
                var decorator = decorators[i];
                var decorated = decorator(target);
                if (!IsUndefined(decorated) && !IsNull(decorated)) {
                    if (!IsConstructor(decorated))
                        throw new TypeError();
                    target = decorated;
                }
            }
            return target;
        }
        function DecorateProperty(decorators, target, propertyKey, descriptor) {
            for (var i = decorators.length - 1; i >= 0; --i) {
                var decorator = decorators[i];
                var decorated = decorator(target, propertyKey, descriptor);
                if (!IsUndefined(decorated) && !IsNull(decorated)) {
                    if (!IsObject(decorated))
                        throw new TypeError();
                    descriptor = decorated;
                }
            }
            return descriptor;
        }
        function GetOrCreateMetadataMap(O, P, Create) {
            var targetMetadata = Metadata.get(O);
            if (IsUndefined(targetMetadata)) {
                if (!Create)
                    return undefined;
                targetMetadata = new _Map();
                Metadata.set(O, targetMetadata);
            }
            var metadataMap = targetMetadata.get(P);
            if (IsUndefined(metadataMap)) {
                if (!Create)
                    return undefined;
                metadataMap = new _Map();
                targetMetadata.set(P, metadataMap);
            }
            return metadataMap;
        }
        // 3.1.1.1 OrdinaryHasMetadata(MetadataKey, O, P)
        // https://rbuckton.github.io/reflect-metadata/#ordinaryhasmetadata
        function OrdinaryHasMetadata(MetadataKey, O, P) {
            var hasOwn = OrdinaryHasOwnMetadata(MetadataKey, O, P);
            if (hasOwn)
                return true;
            var parent = OrdinaryGetPrototypeOf(O);
            if (!IsNull(parent))
                return OrdinaryHasMetadata(MetadataKey, parent, P);
            return false;
        }
        // 3.1.2.1 OrdinaryHasOwnMetadata(MetadataKey, O, P)
        // https://rbuckton.github.io/reflect-metadata/#ordinaryhasownmetadata
        function OrdinaryHasOwnMetadata(MetadataKey, O, P) {
            var metadataMap = GetOrCreateMetadataMap(O, P, /*Create*/ false);
            if (IsUndefined(metadataMap))
                return false;
            return ToBoolean(metadataMap.has(MetadataKey));
        }
        // 3.1.3.1 OrdinaryGetMetadata(MetadataKey, O, P)
        // https://rbuckton.github.io/reflect-metadata/#ordinarygetmetadata
        function OrdinaryGetMetadata(MetadataKey, O, P) {
            var hasOwn = OrdinaryHasOwnMetadata(MetadataKey, O, P);
            if (hasOwn)
                return OrdinaryGetOwnMetadata(MetadataKey, O, P);
            var parent = OrdinaryGetPrototypeOf(O);
            if (!IsNull(parent))
                return OrdinaryGetMetadata(MetadataKey, parent, P);
            return undefined;
        }
        // 3.1.4.1 OrdinaryGetOwnMetadata(MetadataKey, O, P)
        // https://rbuckton.github.io/reflect-metadata/#ordinarygetownmetadata
        function OrdinaryGetOwnMetadata(MetadataKey, O, P) {
            var metadataMap = GetOrCreateMetadataMap(O, P, /*Create*/ false);
            if (IsUndefined(metadataMap))
                return undefined;
            return metadataMap.get(MetadataKey);
        }
        // 3.1.5.1 OrdinaryDefineOwnMetadata(MetadataKey, MetadataValue, O, P)
        // https://rbuckton.github.io/reflect-metadata/#ordinarydefineownmetadata
        function OrdinaryDefineOwnMetadata(MetadataKey, MetadataValue, O, P) {
            var metadataMap = GetOrCreateMetadataMap(O, P, /*Create*/ true);
            metadataMap.set(MetadataKey, MetadataValue);
        }
        // 3.1.6.1 OrdinaryMetadataKeys(O, P)
        // https://rbuckton.github.io/reflect-metadata/#ordinarymetadatakeys
        function OrdinaryMetadataKeys(O, P) {
            var ownKeys = OrdinaryOwnMetadataKeys(O, P);
            var parent = OrdinaryGetPrototypeOf(O);
            if (parent === null)
                return ownKeys;
            var parentKeys = OrdinaryMetadataKeys(parent, P);
            if (parentKeys.length <= 0)
                return ownKeys;
            if (ownKeys.length <= 0)
                return parentKeys;
            var set = new _Set();
            var keys = [];
            for (var _i = 0, ownKeys_1 = ownKeys; _i < ownKeys_1.length; _i++) {
                var key = ownKeys_1[_i];
                var hasKey = set.has(key);
                if (!hasKey) {
                    set.add(key);
                    keys.push(key);
                }
            }
            for (var _a = 0, parentKeys_1 = parentKeys; _a < parentKeys_1.length; _a++) {
                var key = parentKeys_1[_a];
                var hasKey = set.has(key);
                if (!hasKey) {
                    set.add(key);
                    keys.push(key);
                }
            }
            return keys;
        }
        // 3.1.7.1 OrdinaryOwnMetadataKeys(O, P)
        // https://rbuckton.github.io/reflect-metadata/#ordinaryownmetadatakeys
        function OrdinaryOwnMetadataKeys(O, P) {
            var keys = [];
            var metadataMap = GetOrCreateMetadataMap(O, P, /*Create*/ false);
            if (IsUndefined(metadataMap))
                return keys;
            var keysObj = metadataMap.keys();
            var iterator = GetIterator(keysObj);
            var k = 0;
            while (true) {
                var next = IteratorStep(iterator);
                if (!next) {
                    keys.length = k;
                    return keys;
                }
                var nextValue = IteratorValue(next);
                try {
                    keys[k] = nextValue;
                }
                catch (e) {
                    try {
                        IteratorClose(iterator);
                    }
                    finally {
                        throw e;
                    }
                }
                k++;
            }
        }
        // 6 ECMAScript Data Typ0es and Values
        // https://tc39.github.io/ecma262/#sec-ecmascript-data-types-and-values
        function Type(x) {
            if (x === null)
                return 1 /* Null */;
            switch (typeof x) {
                case "undefined": return 0 /* Undefined */;
                case "boolean": return 2 /* Boolean */;
                case "string": return 3 /* String */;
                case "symbol": return 4 /* Symbol */;
                case "number": return 5 /* Number */;
                case "object": return x === null ? 1 /* Null */ : 6 /* Object */;
                default: return 6 /* Object */;
            }
        }
        // 6.1.1 The Undefined Type
        // https://tc39.github.io/ecma262/#sec-ecmascript-language-types-undefined-type
        function IsUndefined(x) {
            return x === undefined;
        }
        // 6.1.2 The Null Type
        // https://tc39.github.io/ecma262/#sec-ecmascript-language-types-null-type
        function IsNull(x) {
            return x === null;
        }
        // 6.1.5 The Symbol Type
        // https://tc39.github.io/ecma262/#sec-ecmascript-language-types-symbol-type
        function IsSymbol(x) {
            return typeof x === "symbol";
        }
        // 6.1.7 The Object Type
        // https://tc39.github.io/ecma262/#sec-object-type
        function IsObject(x) {
            return typeof x === "object" ? x !== null : typeof x === "function";
        }
        // 7.1 Type Conversion
        // https://tc39.github.io/ecma262/#sec-type-conversion
        // 7.1.1 ToPrimitive(input [, PreferredType])
        // https://tc39.github.io/ecma262/#sec-toprimitive
        function ToPrimitive(input, PreferredType) {
            switch (Type(input)) {
                case 0 /* Undefined */: return input;
                case 1 /* Null */: return input;
                case 2 /* Boolean */: return input;
                case 3 /* String */: return input;
                case 4 /* Symbol */: return input;
                case 5 /* Number */: return input;
            }
            var hint = PreferredType === 3 /* String */ ? "string" : PreferredType === 5 /* Number */ ? "number" : "default";
            var exoticToPrim = GetMethod(input, toPrimitiveSymbol);
            if (exoticToPrim !== undefined) {
                var result = exoticToPrim.call(input, hint);
                if (IsObject(result))
                    throw new TypeError();
                return result;
            }
            return OrdinaryToPrimitive(input, hint === "default" ? "number" : hint);
        }
        // 7.1.1.1 OrdinaryToPrimitive(O, hint)
        // https://tc39.github.io/ecma262/#sec-ordinarytoprimitive
        function OrdinaryToPrimitive(O, hint) {
            if (hint === "string") {
                var toString_1 = O.toString;
                if (IsCallable(toString_1)) {
                    var result = toString_1.call(O);
                    if (!IsObject(result))
                        return result;
                }
                var valueOf = O.valueOf;
                if (IsCallable(valueOf)) {
                    var result = valueOf.call(O);
                    if (!IsObject(result))
                        return result;
                }
            }
            else {
                var valueOf = O.valueOf;
                if (IsCallable(valueOf)) {
                    var result = valueOf.call(O);
                    if (!IsObject(result))
                        return result;
                }
                var toString_2 = O.toString;
                if (IsCallable(toString_2)) {
                    var result = toString_2.call(O);
                    if (!IsObject(result))
                        return result;
                }
            }
            throw new TypeError();
        }
        // 7.1.2 ToBoolean(argument)
        // https://tc39.github.io/ecma262/2016/#sec-toboolean
        function ToBoolean(argument) {
            return !!argument;
        }
        // 7.1.12 ToString(argument)
        // https://tc39.github.io/ecma262/#sec-tostring
        function ToString(argument) {
            return "" + argument;
        }
        // 7.1.14 ToPropertyKey(argument)
        // https://tc39.github.io/ecma262/#sec-topropertykey
        function ToPropertyKey(argument) {
            var key = ToPrimitive(argument, 3 /* String */);
            if (IsSymbol(key))
                return key;
            return ToString(key);
        }
        // 7.2 Testing and Comparison Operations
        // https://tc39.github.io/ecma262/#sec-testing-and-comparison-operations
        // 7.2.2 IsArray(argument)
        // https://tc39.github.io/ecma262/#sec-isarray
        function IsArray(argument) {
            return Array.isArray
                ? Array.isArray(argument)
                : argument instanceof Object
                    ? argument instanceof Array
                    : Object.prototype.toString.call(argument) === "[object Array]";
        }
        // 7.2.3 IsCallable(argument)
        // https://tc39.github.io/ecma262/#sec-iscallable
        function IsCallable(argument) {
            // NOTE: This is an approximation as we cannot check for [[Call]] internal method.
            return typeof argument === "function";
        }
        // 7.2.4 IsConstructor(argument)
        // https://tc39.github.io/ecma262/#sec-isconstructor
        function IsConstructor(argument) {
            // NOTE: This is an approximation as we cannot check for [[Construct]] internal method.
            return typeof argument === "function";
        }
        // 7.2.7 IsPropertyKey(argument)
        // https://tc39.github.io/ecma262/#sec-ispropertykey
        function IsPropertyKey(argument) {
            switch (Type(argument)) {
                case 3 /* String */: return true;
                case 4 /* Symbol */: return true;
                default: return false;
            }
        }
        // 7.3 Operations on Objects
        // https://tc39.github.io/ecma262/#sec-operations-on-objects
        // 7.3.9 GetMethod(V, P)
        // https://tc39.github.io/ecma262/#sec-getmethod
        function GetMethod(V, P) {
            var func = V[P];
            if (func === undefined || func === null)
                return undefined;
            if (!IsCallable(func))
                throw new TypeError();
            return func;
        }
        // 7.4 Operations on Iterator Objects
        // https://tc39.github.io/ecma262/#sec-operations-on-iterator-objects
        function GetIterator(obj) {
            var method = GetMethod(obj, iteratorSymbol);
            if (!IsCallable(method))
                throw new TypeError(); // from Call
            var iterator = method.call(obj);
            if (!IsObject(iterator))
                throw new TypeError();
            return iterator;
        }
        // 7.4.4 IteratorValue(iterResult)
        // https://tc39.github.io/ecma262/2016/#sec-iteratorvalue
        function IteratorValue(iterResult) {
            return iterResult.value;
        }
        // 7.4.5 IteratorStep(iterator)
        // https://tc39.github.io/ecma262/#sec-iteratorstep
        function IteratorStep(iterator) {
            var result = iterator.next();
            return result.done ? false : result;
        }
        // 7.4.6 IteratorClose(iterator, completion)
        // https://tc39.github.io/ecma262/#sec-iteratorclose
        function IteratorClose(iterator) {
            var f = iterator["return"];
            if (f)
                f.call(iterator);
        }
        // 9.1 Ordinary Object Internal Methods and Internal Slots
        // https://tc39.github.io/ecma262/#sec-ordinary-object-internal-methods-and-internal-slots
        // 9.1.1.1 OrdinaryGetPrototypeOf(O)
        // https://tc39.github.io/ecma262/#sec-ordinarygetprototypeof
        function OrdinaryGetPrototypeOf(O) {
            var proto = Object.getPrototypeOf(O);
            if (typeof O !== "function" || O === functionPrototype)
                return proto;
            // TypeScript doesn't set __proto__ in ES5, as it's non-standard.
            // Try to determine the superclass constructor. Compatible implementations
            // must either set __proto__ on a subclass constructor to the superclass constructor,
            // or ensure each class has a valid `constructor` property on its prototype that
            // points back to the constructor.
            // If this is not the same as Function.[[Prototype]], then this is definately inherited.
            // This is the case when in ES6 or when using __proto__ in a compatible browser.
            if (proto !== functionPrototype)
                return proto;
            // If the super prototype is Object.prototype, null, or undefined, then we cannot determine the heritage.
            var prototype = O.prototype;
            var prototypeProto = prototype && Object.getPrototypeOf(prototype);
            if (prototypeProto == null || prototypeProto === Object.prototype)
                return proto;
            // If the constructor was not a function, then we cannot determine the heritage.
            var constructor = prototypeProto.constructor;
            if (typeof constructor !== "function")
                return proto;
            // If we have some kind of self-reference, then we cannot determine the heritage.
            if (constructor === O)
                return proto;
            // we have a pretty good guess at the heritage.
            return constructor;
        }
        // naive Map shim
        function CreateMapPolyfill() {
            var cacheSentinel = {};
            var arraySentinel = [];
            var MapIterator = /** @class */ (function () {
                function MapIterator(keys, values, selector) {
                    this._index = 0;
                    this._keys = keys;
                    this._values = values;
                    this._selector = selector;
                }
                MapIterator.prototype["@@iterator"] = function () { return this; };
                MapIterator.prototype[iteratorSymbol] = function () { return this; };
                MapIterator.prototype.next = function () {
                    var index = this._index;
                    if (index >= 0 && index < this._keys.length) {
                        var result = this._selector(this._keys[index], this._values[index]);
                        if (index + 1 >= this._keys.length) {
                            this._index = -1;
                            this._keys = arraySentinel;
                            this._values = arraySentinel;
                        }
                        else {
                            this._index++;
                        }
                        return { value: result, done: false };
                    }
                    return { value: undefined, done: true };
                };
                MapIterator.prototype.throw = function (error) {
                    if (this._index >= 0) {
                        this._index = -1;
                        this._keys = arraySentinel;
                        this._values = arraySentinel;
                    }
                    throw error;
                };
                MapIterator.prototype.return = function (value) {
                    if (this._index >= 0) {
                        this._index = -1;
                        this._keys = arraySentinel;
                        this._values = arraySentinel;
                    }
                    return { value: value, done: true };
                };
                return MapIterator;
            }());
            return /** @class */ (function () {
                function Map() {
                    this._keys = [];
                    this._values = [];
                    this._cacheKey = cacheSentinel;
                    this._cacheIndex = -2;
                }
                Object.defineProperty(Map.prototype, "size", {
                    get: function () { return this._keys.length; },
                    enumerable: true,
                    configurable: true
                });
                Map.prototype.has = function (key) { return this._find(key, /*insert*/ false) >= 0; };
                Map.prototype.get = function (key) {
                    var index = this._find(key, /*insert*/ false);
                    return index >= 0 ? this._values[index] : undefined;
                };
                Map.prototype.set = function (key, value) {
                    var index = this._find(key, /*insert*/ true);
                    this._values[index] = value;
                    return this;
                };
                Map.prototype.delete = function (key) {
                    var index = this._find(key, /*insert*/ false);
                    if (index >= 0) {
                        var size = this._keys.length;
                        for (var i = index + 1; i < size; i++) {
                            this._keys[i - 1] = this._keys[i];
                            this._values[i - 1] = this._values[i];
                        }
                        this._keys.length--;
                        this._values.length--;
                        if (key === this._cacheKey) {
                            this._cacheKey = cacheSentinel;
                            this._cacheIndex = -2;
                        }
                        return true;
                    }
                    return false;
                };
                Map.prototype.clear = function () {
                    this._keys.length = 0;
                    this._values.length = 0;
                    this._cacheKey = cacheSentinel;
                    this._cacheIndex = -2;
                };
                Map.prototype.keys = function () { return new MapIterator(this._keys, this._values, getKey); };
                Map.prototype.values = function () { return new MapIterator(this._keys, this._values, getValue); };
                Map.prototype.entries = function () { return new MapIterator(this._keys, this._values, getEntry); };
                Map.prototype["@@iterator"] = function () { return this.entries(); };
                Map.prototype[iteratorSymbol] = function () { return this.entries(); };
                Map.prototype._find = function (key, insert) {
                    if (this._cacheKey !== key) {
                        this._cacheIndex = this._keys.indexOf(this._cacheKey = key);
                    }
                    if (this._cacheIndex < 0 && insert) {
                        this._cacheIndex = this._keys.length;
                        this._keys.push(key);
                        this._values.push(undefined);
                    }
                    return this._cacheIndex;
                };
                return Map;
            }());
            function getKey(key, _) {
                return key;
            }
            function getValue(_, value) {
                return value;
            }
            function getEntry(key, value) {
                return [key, value];
            }
        }
        // naive Set shim
        function CreateSetPolyfill() {
            return /** @class */ (function () {
                function Set() {
                    this._map = new _Map();
                }
                Object.defineProperty(Set.prototype, "size", {
                    get: function () { return this._map.size; },
                    enumerable: true,
                    configurable: true
                });
                Set.prototype.has = function (value) { return this._map.has(value); };
                Set.prototype.add = function (value) { return this._map.set(value, value), this; };
                Set.prototype.delete = function (value) { return this._map.delete(value); };
                Set.prototype.clear = function () { this._map.clear(); };
                Set.prototype.keys = function () { return this._map.keys(); };
                Set.prototype.values = function () { return this._map.values(); };
                Set.prototype.entries = function () { return this._map.entries(); };
                Set.prototype["@@iterator"] = function () { return this.keys(); };
                Set.prototype[iteratorSymbol] = function () { return this.keys(); };
                return Set;
            }());
        }
        // naive WeakMap shim
        function CreateWeakMapPolyfill() {
            var UUID_SIZE = 16;
            var keys = HashMap.create();
            var rootKey = CreateUniqueKey();
            return /** @class */ (function () {
                function WeakMap() {
                    this._key = CreateUniqueKey();
                }
                WeakMap.prototype.has = function (target) {
                    var table = GetOrCreateWeakMapTable(target, /*create*/ false);
                    return table !== undefined ? HashMap.has(table, this._key) : false;
                };
                WeakMap.prototype.get = function (target) {
                    var table = GetOrCreateWeakMapTable(target, /*create*/ false);
                    return table !== undefined ? HashMap.get(table, this._key) : undefined;
                };
                WeakMap.prototype.set = function (target, value) {
                    var table = GetOrCreateWeakMapTable(target, /*create*/ true);
                    table[this._key] = value;
                    return this;
                };
                WeakMap.prototype.delete = function (target) {
                    var table = GetOrCreateWeakMapTable(target, /*create*/ false);
                    return table !== undefined ? delete table[this._key] : false;
                };
                WeakMap.prototype.clear = function () {
                    // NOTE: not a real clear, just makes the previous data unreachable
                    this._key = CreateUniqueKey();
                };
                return WeakMap;
            }());
            function CreateUniqueKey() {
                var key;
                do
                    key = "@@WeakMap@@" + CreateUUID();
                while (HashMap.has(keys, key));
                keys[key] = true;
                return key;
            }
            function GetOrCreateWeakMapTable(target, create) {
                if (!hasOwn.call(target, rootKey)) {
                    if (!create)
                        return undefined;
                    Object.defineProperty(target, rootKey, { value: HashMap.create() });
                }
                return target[rootKey];
            }
            function FillRandomBytes(buffer, size) {
                for (var i = 0; i < size; ++i)
                    buffer[i] = Math.random() * 0xff | 0;
                return buffer;
            }
            function GenRandomBytes(size) {
                if (typeof Uint8Array === "function") {
                    if (typeof crypto !== "undefined")
                        return crypto.getRandomValues(new Uint8Array(size));
                    if (typeof msCrypto !== "undefined")
                        return msCrypto.getRandomValues(new Uint8Array(size));
                    return FillRandomBytes(new Uint8Array(size), size);
                }
                return FillRandomBytes(new Array(size), size);
            }
            function CreateUUID() {
                var data = GenRandomBytes(UUID_SIZE);
                // mark as random - RFC 4122 § 4.4
                data[6] = data[6] & 0x4f | 0x40;
                data[8] = data[8] & 0xbf | 0x80;
                var result = "";
                for (var offset = 0; offset < UUID_SIZE; ++offset) {
                    var byte = data[offset];
                    if (offset === 4 || offset === 6 || offset === 8)
                        result += "-";
                    if (byte < 16)
                        result += "0";
                    result += byte.toString(16).toLowerCase();
                }
                return result;
            }
        }
        // uses a heuristic used by v8 and chakra to force an object into dictionary mode.
        function MakeDictionary(obj) {
            obj.__ = undefined;
            delete obj.__;
            return obj;
        }
    });
})(Reflect || (Reflect = {}));


/***/ }),

/***/ "./resources/ts/Admin/Components/AssetSearchField.tsx":
/*!************************************************************!*\
  !*** ./resources/ts/Admin/Components/AssetSearchField.tsx ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.AssetSearchField = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class AssetSearchField extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            keywords: null,
            asset: null,
            assets: [],
        };
        this.onKeywordsChange = this.onKeywordsChange.bind(this);
        this.onAssetChange = this.onAssetChange.bind(this);
        this.getAssetsAvailable = this.getAssetsAvailable.bind(this);
        console.log(this.props.assets);
    }
    onKeywordsChange(keywords) {
        if (!keywords || keywords == '') {
            return;
        }
        let results = this.props.assets.filter((asset) => {
            return asset.toLowerCase().indexOf(keywords.toLowerCase()) >= 0;
        });
        if ((results === null || results === void 0 ? void 0 : results.length) > 0) {
            results = results.map((result) => {
                return {
                    label: result,
                    value: result,
                };
            });
            this.setState({
                assets: [results[0]],
            });
        }
        this.onAssetChange(keywords);
    }
    onAssetChange(assetName) {
        this.setState({
            asset: assetName,
            keywords: assetName,
        });
        this.props.onChange(assetName);
    }
    getAssetsAvailable() {
        var _a;
        if (((_a = this.props.assets) === null || _a === void 0 ? void 0 : _a.length) > 0) {
            return this.props.assets.join(', ');
        }
        else {
            return 'none';
        }
    }
    render() {
        return (React.createElement("div", { style: { marginBottom: '12px' } },
            React.createElement("div", { style: { height: '40px' } },
                React.createElement(components_1.ComboboxControl, { label: this.props.label, value: this.props.value, onChange: (value) => {
                        this.onAssetChange(value);
                    }, options: this.state.assets, onFilterValueChange: (keywords) => {
                        this.onKeywordsChange(keywords);
                    } }))));
    }
}
exports.AssetSearchField = AssetSearchField;


/***/ }),

/***/ "./resources/ts/Admin/Components/AttributeRepeater.tsx":
/*!*************************************************************!*\
  !*** ./resources/ts/Admin/Components/AttributeRepeater.tsx ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.AttributeRepeater = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class AttributeRepeater extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            attributes: [],
        };
        this.onUpdate = props.onUpdate;
        this.state.attributes = Object.assign([], props.attributes);
    }
    onUpdate(attributes) {
        //
    }
    onAdd() {
        let newState = Object.assign({}, this.state);
        newState.attributes[newState.attributes.length] = { key: '', value: '' };
        this.setState(newState);
        this.dispatchUpdate();
    }
    onRemove(index) {
        let newState = Object.assign({}, this.state);
        delete newState.attributes[index];
        this.setState(newState);
        this.dispatchUpdate();
    }
    dispatchUpdate() {
        this.onUpdate(this.state.attributes);
    }
    render() {
        const listItems = this.state.attributes.map((attribute, i) => {
            return (React.createElement(components_1.Flex, { justify: "flex-start", style: { alignItems: 'flex-end', margin: '8px 0' } },
                React.createElement(components_1.TextControl, { label: "Key", value: attribute.key, onChange: (value) => {
                        let newState = Object.assign({}, this.state);
                        newState.attributes[i].key = value;
                        this.setState(Object.assign({}, newState));
                        this.dispatchUpdate();
                    } }),
                React.createElement(components_1.TextControl, { label: "Value", value: attribute.value, onChange: (value) => {
                        let newState = Object.assign({}, this.state);
                        newState.attributes[i].value = value;
                        this.setState(Object.assign({}, newState));
                        this.dispatchUpdate();
                    } }),
                React.createElement(components_1.Button, { isTertiary: true, onClick: () => {
                        this.onRemove(i);
                    } },
                    React.createElement(components_1.Dashicon, { icon: "no" }))));
        });
        return (React.createElement("div", { style: { display: 'inline-block' } },
            React.createElement("label", null,
                this.props.label,
                React.createElement("div", { style: { opacity: 0.8 } }, this.props.help),
                React.createElement("ul", null, listItems)),
            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, onClick: () => {
                    this.onAdd();
                } }, "Add attribute")));
    }
}
exports.AttributeRepeater = AttributeRepeater;


/***/ }),

/***/ "./resources/ts/Admin/Components/BalanceCard.tsx":
/*!*******************************************************!*\
  !*** ./resources/ts/Admin/Components/BalanceCard.tsx ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.BalanceCard = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class BalanceCard extends react_1.Component {
    constructor(props) {
        super(props);
        this.getName = this.getName.bind(this);
    }
    getName() {
        var _a, _b;
        let name = this.props.balance.asset;
        if ((_b = (_a = this.props.balance) === null || _a === void 0 ? void 0 : _a.token_meta) === null || _b === void 0 ? void 0 : _b.name) {
            name = this.props.balance.token_meta.name;
        }
        return name;
    }
    render() {
        var _a, _b, _c, _d, _e, _f;
        return (React.createElement(components_1.Card, { size: "extraSmall", style: { width: '100%' } },
            React.createElement(components_1.CardHeader, null,
                React.createElement("strong", { title: (_b = (_a = this.props) === null || _a === void 0 ? void 0 : _a.balance) === null || _b === void 0 ? void 0 : _b.asset }, this.getName())),
            React.createElement(components_1.CardBody, { style: { width: '100%' } }, (_f = (_e = (_d = (_c = this.props) === null || _c === void 0 ? void 0 : _c.balance) === null || _d === void 0 ? void 0 : _d.quantity) === null || _e === void 0 ? void 0 : _e.value) !== null && _f !== void 0 ? _f : 0)));
    }
}
exports.BalanceCard = BalanceCard;


/***/ }),

/***/ "./resources/ts/Admin/Components/BalanceList.tsx":
/*!*******************************************************!*\
  !*** ./resources/ts/Admin/Components/BalanceList.tsx ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.BalanceList = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const BalanceCard_1 = __webpack_require__(/*! ./BalanceCard */ "./resources/ts/Admin/Components/BalanceCard.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class BalanceList extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        let listItems = Object.keys(this.props.balance).map((key) => this.props.balance[key]);
        listItems = listItems.map((balanceItem, i) => {
            return (React.createElement("div", { style: { width: '100%' } },
                React.createElement(BalanceCard_1.BalanceCard, { balance: balanceItem })));
        });
        return (React.createElement("div", { style: { width: '100%' } }, listItems.length > 0
            //@ts-ignore
            ? React.createElement(components_1.Flex, { direction: "column", style: { width: '100%' } }, listItems)
            : React.createElement("div", { style: { opacity: 0.5 } }, "There are no assets")));
    }
}
exports.BalanceList = BalanceList;


/***/ }),

/***/ "./resources/ts/Admin/Components/ConfirmModal.tsx":
/*!********************************************************!*\
  !*** ./resources/ts/Admin/Components/ConfirmModal.tsx ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.ConfirmModal = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class ConfirmModal extends react_1.Component {
    constructor(props) {
        super(props);
        this.onRequestClose = this.onRequestClose.bind(this);
    }
    onRequestClose() {
        this.props.onRequestClose();
    }
    onChoice(choice) {
        this.props.onChoice(choice);
    }
    render() {
        return (React.createElement(components_1.Modal, { title: this.props.title, onRequestClose: this.onRequestClose },
            React.createElement("div", null,
                this.props.subtitle,
                " "),
            React.createElement(components_1.Flex, { justify: "flex-start", style: { marginTop: '12px' } },
                React.createElement(components_1.Button, { isSecondary: true, onClick: () => {
                        this.onChoice('accept');
                    } }, "Accept"),
                React.createElement(components_1.Button, { isSecondary: true, onClick: () => {
                        this.onChoice('deny');
                    } }, "Deny"))));
    }
}
exports.ConfirmModal = ConfirmModal;


/***/ }),

/***/ "./resources/ts/Admin/Components/CreditGroupCard.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Components/CreditGroupCard.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditGroupCard = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupCard extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        return (React.createElement(components_1.Card, { size: "extraSmall", style: { width: '100%' } },
            React.createElement(components_1.CardHeader, null,
                React.createElement("div", null, this.props.creditGroup.name)),
            React.createElement(components_1.CardBody, { style: { width: '100%' } },
                React.createElement(components_1.Flex, { style: { width: '100%', alignItems: 'center' } },
                    React.createElement("div", { style: { flex: 1 } },
                        React.createElement("div", null,
                            React.createElement("span", null, "Active: "),
                            React.createElement("strong", null, this.props.creditGroup.active ? 'Yes' : 'No'))))),
            React.createElement(components_1.CardFooter, null,
                React.createElement(components_1.Flex, { justify: "flex-start" },
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-credit-transaction-index&credit_group=${this.props.creditGroup.uuid}` }, "View transactions"),
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-credit-group-show&credit_group=${this.props.creditGroup.uuid}` }, "View details"),
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-credit-group-edit&credit_group=${this.props.creditGroup.uuid}` }, "Manage group")))));
    }
}
exports.CreditGroupCard = CreditGroupCard;


/***/ }),

/***/ "./resources/ts/Admin/Components/CreditGroupEditForm.tsx":
/*!***************************************************************!*\
  !*** ./resources/ts/Admin/Components/CreditGroupEditForm.tsx ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditGroupEditForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupEditForm extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            creditGroup: {
                name: null,
                app_whitelist: null,
            },
        };
        this.onSave = this.onSave.bind(this);
        this.state.creditGroup = Object.assign(this.state.creditGroup, this.props.creditGroup);
    }
    onSave() {
        this.props.onSave(this.state.creditGroup);
    }
    onCancel() {
        this.props.onCancel();
    }
    render() {
        return React.createElement("div", null,
            React.createElement("form", null,
                React.createElement("div", { style: { maxWidth: "320px" } },
                    React.createElement(components_1.Flex
                    //@ts-ignore
                    , { 
                        //@ts-ignore
                        direction: "column" },
                        React.createElement(components_1.TextControl, { label: "Name", value: this.state.creditGroup.name, onChange: (value) => {
                                const state = Object.assign({}, this.state.creditGroup);
                                state.name = value;
                                this.setState({ creditGroup: state });
                            } }),
                        React.createElement(components_1.TextareaControl, { label: "App whitelist", help: "Comma-separated values.", value: this.state.creditGroup.app_whitelist, onChange: (value) => {
                                const state = Object.assign({}, this.state.creditGroup);
                                state.app_whitelist = value;
                                this.setState({ creditGroup: state });
                            } })),
                    React.createElement(components_1.Flex, { justify: "flex-start", style: { marginTop: '12px' } },
                        React.createElement(components_1.Button, { isPrimary: true, disabled: this.props.saving, onClick: () => {
                                this.onSave();
                            } }, "Save credit group"),
                        React.createElement(components_1.Button, { isTertiary: true, onClick: () => {
                                this.onCancel();
                            } }, "Cancel")))));
    }
}
exports.CreditGroupEditForm = CreditGroupEditForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/CreditGroupList.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Components/CreditGroupList.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditGroupList = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const CreditGroupCard_1 = __webpack_require__(/*! ./CreditGroupCard */ "./resources/ts/Admin/Components/CreditGroupCard.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupList extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        let listItems = Object.keys(this.props.creditGroups).map((key) => this.props.creditGroups[key]);
        listItems = listItems.map((creditGroup, i) => {
            return (React.createElement("div", { style: { width: '100%' } },
                React.createElement(CreditGroupCard_1.CreditGroupCard, { creditGroup: creditGroup })));
        });
        return (React.createElement("div", { style: { width: '100%' } }, listItems.length > 0
            //@ts-ignore
            ? React.createElement(components_1.Flex, { direction: "column", style: { width: '100%' } }, listItems)
            : React.createElement("div", { style: { opacity: 0.5 } }, "There are no registered credit groups")));
    }
}
exports.CreditGroupList = CreditGroupList;


/***/ }),

/***/ "./resources/ts/Admin/Components/CreditGroupStoreForm.tsx":
/*!****************************************************************!*\
  !*** ./resources/ts/Admin/Components/CreditGroupStoreForm.tsx ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditGroupStoreForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupStoreForm extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            name: null,
            appWhitelist: null,
        };
        this.onSubmit = this.onSubmit.bind(this);
    }
    onSubmit() {
        this.props.onSubmit({
            name: this.state.name,
            app_whitelist: this.state.appWhitelist,
        });
    }
    onCancel() {
        this.props.onCancel();
    }
    render() {
        return (React.createElement("form", { style: { width: '100%', maxWidth: "400px" } },
            React.createElement("div", null,
                React.createElement(components_1.Flex
                //@ts-ignore
                , { 
                    //@ts-ignore
                    direction: "column" },
                    React.createElement(components_1.TextControl, { label: "Name", value: this.state.name, onChange: (value) => {
                            this.setState({ name: value });
                        } }),
                    React.createElement(components_1.TextareaControl, { label: "App whitelist", value: this.state.appWhitelist, help: "Comma-separated list.", onChange: (value) => {
                            this.setState({ appWhitelist: value });
                        } })),
                React.createElement(components_1.Flex, { style: { marginTop: '12px' }, justify: "flex-start" },
                    React.createElement(components_1.Button, { isPrimary: true, disabled: this.state.name === null, onClick: () => {
                            this.onSubmit();
                        } }, "Register credit group"),
                    this.props.saving === true &&
                        React.createElement(components_1.Spinner, null),
                    React.createElement(components_1.Button, { isTertiary: true, disabled: this.props.saving, onClick: () => {
                            this.onCancel();
                        } }, "Cancel"),
                    this.props.saving === true &&
                        React.createElement(components_1.Spinner, null)))));
    }
}
exports.CreditGroupStoreForm = CreditGroupStoreForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/CreditTransactionCard.tsx":
/*!*****************************************************************!*\
  !*** ./resources/ts/Admin/Components/CreditTransactionCard.tsx ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditTransactionCard = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const dayjs = __webpack_require__(/*! dayjs */ "./node_modules/dayjs/dayjs.min.js");
const UserLink_1 = __webpack_require__(/*! ./UserLink */ "./resources/ts/Admin/Components/UserLink.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditTransactionCard extends react_1.Component {
    constructor(props) {
        super(props);
        console.log(this.props);
    }
    dateFormatted(date) {
        if (date) {
            return dayjs(date).format('MMMM D, YYYY h:mm A');
        }
        return;
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j;
        return (React.createElement(components_1.Card, { size: "extraSmall", style: { width: '100%' } },
            React.createElement(components_1.CardHeader, null,
                React.createElement("div", null,
                    "\u2116 ",
                    React.createElement("strong", null, this.props.creditTransaction.tx_uuid))),
            React.createElement(components_1.CardBody, { style: { width: '100%' } },
                React.createElement(components_1.Flex, { style: { width: '100%', alignItems: 'center' } },
                    React.createElement("div", { style: { flex: 1 } },
                        React.createElement(components_1.Flex, { justify: "flex-start" },
                            React.createElement("span", null, "User: "),
                            React.createElement(UserLink_1.UserLink, { id: (_b = (_a = this.props.creditTransaction) === null || _a === void 0 ? void 0 : _a.user) === null || _b === void 0 ? void 0 : _b.id, name: ((_d = (_c = this.props.creditTransaction) === null || _c === void 0 ? void 0 : _c.user) === null || _d === void 0 ? void 0 : _d.name) ? (_f = (_e = this.props.creditTransaction) === null || _e === void 0 ? void 0 : _e.user) === null || _f === void 0 ? void 0 : _f.name : (_g = this.props.creditTransaction) === null || _g === void 0 ? void 0 : _g.account, alt: this.props.creditTransaction.account })),
                        React.createElement("div", null,
                            React.createElement("span", null, "Amount: "),
                            React.createElement("strong", null, this.props.creditTransaction.amount)),
                        React.createElement("div", null,
                            React.createElement("span", null, "Created at: "),
                            React.createElement("strong", null, this.dateFormatted((_h = this.props.creditTransaction) === null || _h === void 0 ? void 0 : _h.created_at))),
                        React.createElement("div", null,
                            React.createElement("span", null, "Updated at: "),
                            React.createElement("strong", null, this.dateFormatted((_j = this.props.creditTransaction) === null || _j === void 0 ? void 0 : _j.updated_at))))))));
    }
}
exports.CreditTransactionCard = CreditTransactionCard;


/***/ }),

/***/ "./resources/ts/Admin/Components/CreditTransactionList.tsx":
/*!*****************************************************************!*\
  !*** ./resources/ts/Admin/Components/CreditTransactionList.tsx ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditTransactionList = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const CreditTransactionCard_1 = __webpack_require__(/*! ./CreditTransactionCard */ "./resources/ts/Admin/Components/CreditTransactionCard.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditTransactionList extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        let listItems = Object.keys(this.props.creditTransactions).map((key) => this.props.creditTransactions[key]);
        listItems = listItems.map((creditTransaction, i) => {
            return (React.createElement("div", { style: { width: '100%' } },
                React.createElement(CreditTransactionCard_1.CreditTransactionCard, { creditTransaction: creditTransaction })));
        });
        return (React.createElement("div", { style: { width: '100%' } }, listItems.length > 0
            //@ts-ignore
            ? React.createElement(components_1.Flex, { direction: "column", style: { width: '100%' } }, listItems)
            : React.createElement("div", { style: { opacity: 0.5 } }, "There are no registered transactions")));
    }
}
exports.CreditTransactionList = CreditTransactionList;


/***/ }),

/***/ "./resources/ts/Admin/Components/CreditTransactionStoreForm.tsx":
/*!**********************************************************************!*\
  !*** ./resources/ts/Admin/Components/CreditTransactionStoreForm.tsx ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditTransactionStoreForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const UserSearchField_1 = __webpack_require__(/*! ./UserSearchField */ "./resources/ts/Admin/Components/UserSearchField.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditTransactionStoreForm extends react_1.Component {
    constructor(props) {
        var _a, _b;
        super(props);
        this.state = {
            creditGroupOptions: [],
            transaction: {
                group_uuid: null,
                type: 'debit',
                account: null,
                amount: 0,
                ref: '',
                source: null,
            }
        };
        this.onSubmit = this.onSubmit.bind(this);
        this.getSourceLabel = this.getSourceLabel.bind(this);
        this.getCreditGroupOptions = this.getCreditGroupOptions.bind(this);
        this.state.creditGroupOptions = this.getCreditGroupOptions();
        if ((_a = this.state.creditGroupOptions[0]) !== null && _a !== void 0 ? _a : null) {
            this.state.transaction.group_uuid = (_b = this.state.creditGroupOptions[0]) === null || _b === void 0 ? void 0 : _b.value;
        }
    }
    onSubmit() {
        const transaction = Object.assign({}, this.state.transaction);
        console.log(transaction);
        this.props.onSubmit(transaction);
    }
    onCancel() {
        this.props.onCancel();
    }
    getCreditGroupOptions() {
        const options = [];
        this.props.creditGroups.forEach((creditGroup) => {
            options.push({
                label: creditGroup.name,
                value: creditGroup.uuid,
            });
        });
        return options;
    }
    getSourceLabel() {
        let label = '';
        switch (this.state.transaction.type) {
            case 'debit':
                label = 'Destination';
                break;
            case 'credit':
                label = 'Source';
                break;
        }
        return label;
    }
    render() {
        return (React.createElement("form", { style: { width: '100%', maxWidth: "400px" } },
            React.createElement("div", null,
                React.createElement(components_1.Flex
                //@ts-ignore
                , { 
                    //@ts-ignore
                    direction: "column" },
                    React.createElement("div", { style: { marginBottom: '12px' } },
                        React.createElement(components_1.SelectControl, { label: "Credit group", value: this.state.transaction.group_uuid, options: this.state.creditGroupOptions, onChange: (value) => {
                                let newState = Object.assign({}, this.state.transaction);
                                newState.group_uuid = value;
                                this.setState({ transaction: newState });
                            } })),
                    React.createElement("div", { style: { marginBottom: '12px' } },
                        React.createElement(components_1.SelectControl, { label: "Transaction type", value: this.state.transaction.type, options: [
                                { label: 'Debit', value: 'debit' },
                                { label: 'Credit', value: 'credit' },
                            ], onChange: (value) => {
                                let newState = Object.assign({}, this.state.transaction);
                                newState.type = value;
                                this.setState({ transaction: newState });
                            } })),
                    React.createElement("div", null,
                        React.createElement("label", null,
                            "Account",
                            React.createElement("div", { style: { opacity: 0.8, marginBottom: '12px' } }, "WordPress username."),
                            React.createElement(UserSearchField_1.UserSearchField, { onChange: (value) => {
                                    const state = Object.assign({}, this.state.transaction);
                                    state.account = value;
                                    this.setState({ transaction: state });
                                } }))),
                    React.createElement("div", null,
                        React.createElement("label", null,
                            this.getSourceLabel(),
                            React.createElement("div", { style: { opacity: 0.8, marginBottom: '12px' } }, "WordPress username. (optional)"),
                            React.createElement(UserSearchField_1.UserSearchField, { onChange: (value) => {
                                    const state = Object.assign({}, this.state.transaction);
                                    state.source = value;
                                    this.setState({ transaction: state });
                                } }))),
                    React.createElement(components_1.TextControl, { label: "Amount", 
                        // @ts-ignore
                        type: "number", value: this.state.transaction.amount, onChange: (value) => {
                            const state = Object.assign({}, this.state.transaction);
                            state.amount = value;
                            this.setState({ transaction: state });
                        } }),
                    React.createElement(components_1.TextControl, { label: "Ref", help: "Extra reference data", value: this.state.transaction.ref, onChange: (value) => {
                            const state = Object.assign({}, this.state.transaction);
                            state.ref = value;
                            this.setState({ transaction: state });
                        } })),
                React.createElement(components_1.Flex, { style: { marginTop: '12px' }, justify: "flex-start" },
                    React.createElement(components_1.Button, { isPrimary: true, onClick: () => {
                            this.onSubmit();
                        } }, "Make transaction"),
                    this.props.saving === true &&
                        React.createElement(components_1.Spinner, null),
                    React.createElement(components_1.Button, { isTertiary: true, disabled: this.props.saving, onClick: () => {
                            this.onCancel();
                        } }, "Cancel"),
                    this.props.saving === true &&
                        React.createElement(components_1.Spinner, null)))));
    }
}
exports.CreditTransactionStoreForm = CreditTransactionStoreForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/PromiseCard.tsx":
/*!*******************************************************!*\
  !*** ./resources/ts/Admin/Components/PromiseCard.tsx ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseCard = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const PromiseSourceInfo_1 = __webpack_require__(/*! ./PromiseSourceInfo */ "./resources/ts/Admin/Components/PromiseSourceInfo.tsx");
const PromiseParticipants_1 = __webpack_require__(/*! ./PromiseParticipants */ "./resources/ts/Admin/Components/PromiseParticipants.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseCard extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        var _a, _b, _c, _d;
        return (React.createElement(components_1.Card, { size: "extraSmall", style: { width: '100%' } },
            React.createElement(components_1.CardHeader, null,
                React.createElement(components_1.Flex, { align: "center", justify: "flex-start" },
                    React.createElement("span", null,
                        React.createElement("span", null, "\u2116 "),
                        React.createElement("strong", null,
                            React.createElement("a", { href: `/wp-admin/admin.php?page=tokenly-promise-show&promise=${this.props.promise.promise_id}` }, this.props.promise.promise_id))),
                    ((_b = (_a = this.props) === null || _a === void 0 ? void 0 : _a.promise) === null || _b === void 0 ? void 0 : _b.pseudo) == true &&
                        React.createElement("span", null,
                            React.createElement("span", { className: "tokenly-component-chip" }, "pseudo")))),
            React.createElement(components_1.CardBody, { style: { width: '100%' } },
                React.createElement(components_1.Flex, { style: { width: '100%', alignItems: 'center' } },
                    React.createElement("div", { style: { flex: 1 } },
                        React.createElement(PromiseSourceInfo_1.PromiseSourceInfo, { promise: this.props.promise, sources: this.props.sources }),
                        React.createElement(PromiseParticipants_1.PromiseParticipants, { promise: this.props.promise }),
                        React.createElement("div", null,
                            React.createElement("span", null, "Asset: "),
                            React.createElement("strong", null, this.props.promise.asset)),
                        React.createElement("div", null,
                            React.createElement("span", null, "Quantity: "),
                            React.createElement("strong", null, (_d = (_c = this.props.promise) === null || _c === void 0 ? void 0 : _c.quantity) === null || _d === void 0 ? void 0 : _d.value))))),
            React.createElement(components_1.CardFooter, null,
                React.createElement(components_1.Flex, { justify: "flex-start" },
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-promise-show&promise=${this.props.promise.promise_id}` }, "Details"),
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-promise-edit&promise=${this.props.promise.promise_id}` }, "Manage promise")))));
    }
}
exports.PromiseCard = PromiseCard;


/***/ }),

/***/ "./resources/ts/Admin/Components/PromiseDetailsModal.tsx":
/*!***************************************************************!*\
  !*** ./resources/ts/Admin/Components/PromiseDetailsModal.tsx ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseDetailsModal = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const dayjs = __webpack_require__(/*! dayjs */ "./node_modules/dayjs/dayjs.min.js");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseDetailsModal extends react_1.Component {
    constructor(props) {
        super(props);
        this.onRequestClose = this.onRequestClose.bind(this);
    }
    onRequestClose() {
        this.props.onRequestClose();
    }
    dateFormatted(date) {
        if (date) {
            return dayjs(date).format('MMMM D, YYYY h:mm A');
        }
        return;
    }
    render() {
        return (React.createElement(components_1.Modal, { title: `Promise № ${this.props.promise.promise_id}`, onRequestClose: this.onRequestClose },
            React.createElement("div", null,
                React.createElement("span", null, "Source: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.props.promise.source))),
            React.createElement("div", null,
                React.createElement("span", null, "Destination: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.props.promise.destination))),
            React.createElement("div", null,
                React.createElement("span", null, "Asset: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.props.promise.asset))),
            React.createElement("div", null,
                React.createElement("span", null, "Quantity: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.props.promise.quantity))),
            React.createElement("div", null,
                React.createElement("span", null, "Ref: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.props.promise.ref))),
            React.createElement("div", null,
                React.createElement("span", null, "Note: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.props.promise.note))),
            React.createElement("div", null,
                React.createElement("span", null, "Created at: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.dateFormatted(this.props.promise.created_at)))),
            React.createElement("div", null,
                React.createElement("span", null, "Updated at: "),
                React.createElement("span", null,
                    React.createElement("strong", null, this.dateFormatted(this.props.promise.updated_at))))));
    }
}
exports.PromiseDetailsModal = PromiseDetailsModal;


/***/ }),

/***/ "./resources/ts/Admin/Components/PromiseEditForm.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Components/PromiseEditForm.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseEditForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseEditForm extends react_1.Component {
    constructor(props) {
        var _a, _b;
        super(props);
        this.state = {
            promise: {},
        };
        this.onSave = this.onSave.bind(this);
        this.onDelete = this.onDelete.bind(this);
        this.onCancel = this.onCancel.bind(this);
        this.state.promise = {
            quantity: (_b = (_a = this.props.promise) === null || _a === void 0 ? void 0 : _a.quantity) === null || _b === void 0 ? void 0 : _b.value_sat,
            expiration: null,
            txid: null,
            fingerprint: null,
            ref: this.props.promise.ref,
            note: this.props.promise.note,
        };
    }
    onSave() {
        this.props.onSave(this.state.promise);
    }
    onDelete() {
        this.props.onDelete();
    }
    onCancel() {
        this.props.onCancel();
    }
    render() {
        return React.createElement("div", null,
            React.createElement("form", null,
                React.createElement("div", { style: { maxWidth: "320px" } },
                    React.createElement(components_1.Flex
                    //@ts-ignore
                    , { 
                        //@ts-ignore
                        direction: "column" },
                        React.createElement(components_1.TextControl, { label: "Quantity", 
                            // @ts-ignore
                            hint: "Amount, in satoshis", type: "number", value: this.state.promise.quantity, onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.quantity = value;
                                this.setState({ promise: state });
                            } }),
                        React.createElement(components_1.TextControl, { label: "TXID", 
                            // @ts-ignore
                            hint: "Transaction ID of the real bitcoin transaction in-flight", value: this.state.promise.txid, onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.txid = value;
                                this.setState({ promise: state });
                            } }),
                        React.createElement(components_1.TextControl, { label: "Fingerprint", 
                            // @ts-ignore
                            hint: "XChain transaction fingerprint of the real btc tx", value: this.state.promise.fingerprint, onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.fingerprint = value;
                                this.setState({ promise: state });
                            } }),
                        React.createElement(components_1.TextareaControl, { label: "Ref", 
                            // @ts-ignore
                            hint: "Extra reference data", value: this.state.promise.ref, onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.ref = value;
                                this.setState({ promise: state });
                            } }),
                        React.createElement(components_1.TextareaControl, { label: "Note", 
                            // @ts-ignore
                            hint: "Note to display to user", value: this.state.promise.note, onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.note = value;
                                this.setState({ promise: state });
                            } })),
                    React.createElement(components_1.Flex, { justify: "flex-start", style: { marginTop: '12px' } },
                        React.createElement(components_1.Button, { isPrimary: true, disabled: this.props.saving, onClick: () => {
                                this.onSave();
                            } }, "Save promise"),
                        React.createElement(components_1.Button, { isSecondary: true, disabled: this.props.deleting, onClick: () => {
                                this.onDelete();
                            } }, "Delete promise"),
                        React.createElement(components_1.Button, { isTertiary: true, disabled: this.props.deleting, onClick: () => {
                                this.onCancel();
                            } }, "Cancel")))));
    }
}
exports.PromiseEditForm = PromiseEditForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/PromiseList.tsx":
/*!*******************************************************!*\
  !*** ./resources/ts/Admin/Components/PromiseList.tsx ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseList = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const PromiseCard_1 = __webpack_require__(/*! ./PromiseCard */ "./resources/ts/Admin/Components/PromiseCard.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseList extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        let listItems = Object.keys(this.props.promises).map((key) => this.props.promises[key]);
        listItems = listItems.map((promiseItem, i) => {
            return (React.createElement("div", { style: { width: '100%' } },
                React.createElement(PromiseCard_1.PromiseCard, { promise: promiseItem, sources: this.props.sources })));
        });
        return (
        // @ts-ignore
        React.createElement(components_1.Flex, { style: { width: '100%' }, direction: "column" }, listItems));
    }
}
exports.PromiseList = PromiseList;


/***/ }),

/***/ "./resources/ts/Admin/Components/PromiseParticipants.tsx":
/*!***************************************************************!*\
  !*** ./resources/ts/Admin/Components/PromiseParticipants.tsx ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseParticipants = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const UserLink_1 = __webpack_require__(/*! ./UserLink */ "./resources/ts/Admin/Components/UserLink.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseParticipants extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t;
        return (React.createElement(components_1.Flex, { gap: 0, align: "center", justify: "flex-start" },
            React.createElement("span", null, "Participants: "),
            React.createElement(UserLink_1.UserLink, { id: (_c = (_b = (_a = this.props.promise) === null || _a === void 0 ? void 0 : _a.promise_meta) === null || _b === void 0 ? void 0 : _b.source_user) === null || _c === void 0 ? void 0 : _c.id, alt: (_e = (_d = this.props) === null || _d === void 0 ? void 0 : _d.promise) === null || _e === void 0 ? void 0 : _e.source_id, name: (_j = (_h = (_g = (_f = this.props) === null || _f === void 0 ? void 0 : _f.promise) === null || _g === void 0 ? void 0 : _g.promise_meta) === null || _h === void 0 ? void 0 : _h.source_user) === null || _j === void 0 ? void 0 : _j.name }),
            React.createElement(components_1.Dashicon, { style: { margin: '0 5px' }, icon: "arrow-right-alt" }),
            React.createElement(UserLink_1.UserLink, { id: (_m = (_l = (_k = this.props.promise) === null || _k === void 0 ? void 0 : _k.promise_meta) === null || _l === void 0 ? void 0 : _l.destination_user) === null || _m === void 0 ? void 0 : _m.id, alt: (_p = (_o = this.props) === null || _o === void 0 ? void 0 : _o.promise) === null || _p === void 0 ? void 0 : _p.destination, name: (_t = (_s = (_r = (_q = this.props) === null || _q === void 0 ? void 0 : _q.promise) === null || _r === void 0 ? void 0 : _r.promise_meta) === null || _s === void 0 ? void 0 : _s.destination_user) === null || _t === void 0 ? void 0 : _t.name })));
    }
}
exports.PromiseParticipants = PromiseParticipants;


/***/ }),

/***/ "./resources/ts/Admin/Components/PromiseSourceInfo.tsx":
/*!*************************************************************!*\
  !*** ./resources/ts/Admin/Components/PromiseSourceInfo.tsx ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseSourceInfo = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
class PromiseSourceInfo extends react_1.Component {
    constructor(props) {
        super(props);
        this.getPromiseSource = this.getPromiseSource.bind(this);
        this.sourceExists = this.sourceExists.bind(this);
    }
    getPromiseSource(promiseItem) {
        var _a, _b;
        let address = promiseItem.source_id;
        const source = (_a = this.props.sources[promiseItem.source_id]) !== null && _a !== void 0 ? _a : null;
        if (source) {
            address = (_b = source === null || source === void 0 ? void 0 : source.address) === null || _b === void 0 ? void 0 : _b.label;
        }
        return address;
    }
    sourceExists(promiseItem) {
        var _a;
        const source = (_a = this.props.sources[promiseItem.source_id]) !== null && _a !== void 0 ? _a : null;
        if (source) {
            return true;
        }
        else {
            return false;
        }
    }
    render() {
        return (React.createElement("div", null,
            React.createElement("span", null, "Source: "),
            this.sourceExists(this.props.promise)
                ? React.createElement("a", { href: `/wp-admin/admin.php?page=tokenly-source-show&source=${this.props.promise.source_id}` },
                    React.createElement("strong", null, this.getPromiseSource(this.props.promise)))
                : React.createElement("span", null,
                    React.createElement("strong", null, this.props.promise.source_id))));
    }
}
exports.PromiseSourceInfo = PromiseSourceInfo;


/***/ }),

/***/ "./resources/ts/Admin/Components/PromiseStoreForm.tsx":
/*!************************************************************!*\
  !*** ./resources/ts/Admin/Components/PromiseStoreForm.tsx ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseStoreForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const UserSearchField_1 = __webpack_require__(/*! ./UserSearchField */ "./resources/ts/Admin/Components/UserSearchField.tsx");
const AssetSearchField_1 = __webpack_require__(/*! ./AssetSearchField */ "./resources/ts/Admin/Components/AssetSearchField.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseStoreForm extends react_1.Component {
    constructor(props) {
        var _a;
        super(props);
        this.state = {
            promise: {
                source_id: null,
                destination: null,
                asset: null,
                pseudo: false,
                quantity: 0,
                ref: null,
                note: null,
            },
            source: null,
            sources: [],
        };
        this.onSubmit = this.onSubmit.bind(this);
        this.onCancel = this.onCancel.bind(this);
        this.onUserChange = this.onUserChange.bind(this);
        this.onSourceChange = this.onSourceChange.bind(this);
        this.getSourceOptions = this.getSourceOptions.bind(this);
        this.getAssetOptions = this.getAssetOptions.bind(this);
        this.getCurrentAsset = this.getCurrentAsset.bind(this);
        this.getMaxCount = this.getMaxCount.bind(this);
        this.isAssetValid = this.isAssetValid.bind(this);
        if (Object.keys(this.props.sources).length > 0) {
            const key = Object.keys(this.props.sources)[0];
            this.state.source = Object.assign({}, (_a = this.props.sources[key]) !== null && _a !== void 0 ? _a : null);
            this.state.promise.source_id = this.state.source.address_id;
        }
    }
    onSubmit() {
        this.props.onSubmit(this.state.promise);
    }
    onCancel() {
        this.props.onCancel(this.state.promise);
    }
    onSourceChange(value) {
        var _a;
        const state = Object.assign({}, this.state.promise);
        state.source_id = value;
        state.asset = null;
        state.quantity = 0;
        const source = Object.assign({}, (_a = this.props.sources[value]) !== null && _a !== void 0 ? _a : null);
        this.setState({
            promise: state,
            source: source !== null && source !== void 0 ? source : null,
        });
    }
    onUserChange(userId) {
        const promise = Object.assign({}, this.state.promise);
        promise.destination = userId;
        this.setState({ promise: promise });
    }
    getSourceOptions() {
        const options = [];
        Object.keys(this.props.sources).forEach((key) => {
            var _a, _b;
            const label = (_b = (_a = this.props.sources[key].address.label) !== null && _a !== void 0 ? _a : this.props.sources[key].address_id) !== null && _b !== void 0 ? _b : null;
            options.push({
                label: label,
                value: key,
            });
        });
        return options;
    }
    getAssetOptions() {
        var _a, _b;
        const options = [];
        if (!this.state.source) {
            return [];
        }
        const balance = (_b = (_a = this.state.source) === null || _a === void 0 ? void 0 : _a.address) === null || _b === void 0 ? void 0 : _b.balance;
        if (!balance) {
            return [];
        }
        Object.keys(balance).forEach((key) => {
            let asset = balance[key].asset;
            options.push(asset);
        });
        return options;
    }
    getCurrentAsset() {
        var _a;
        if (!((_a = this.state.promise) === null || _a === void 0 ? void 0 : _a.asset)) {
            return null;
        }
        const asset = this.state.promise.asset;
        if (asset == '') {
            return null;
        }
        let balance = this.state.source.address.balance;
        balance = Object.values(balance);
        balance = balance.filter((balance) => {
            return balance.asset === this.state.promise.asset;
        });
        if (balance.length == 0) {
            return null;
        }
        return balance[0];
    }
    getMaxCount() {
        const asset = this.getCurrentAsset();
        if (!asset) {
            return null;
        }
        const quantity = parseFloat(asset.quantity.value);
        return quantity;
    }
    isAssetValid() {
        var _a, _b;
        const asset = this.getCurrentAsset();
        if (asset || ((_b = (_a = this.state) === null || _a === void 0 ? void 0 : _a.promise) === null || _b === void 0 ? void 0 : _b.pseudo) == true) {
            return true;
        }
        return false;
    }
    render() {
        return (React.createElement("form", { style: { width: '100%', maxWidth: '320px' } },
            React.createElement(components_1.Flex
            //@ts-ignore
            , { 
                //@ts-ignore
                direction: "column", style: { width: '100%' } },
                React.createElement(components_1.SelectControl, { label: "Source", value: this.state.promise.source_id, options: this.getSourceOptions(), onChange: (value) => {
                        this.onSourceChange(value);
                    }, help: "Source address to use." }),
                React.createElement("div", null,
                    React.createElement("label", null,
                        "Destination",
                        React.createElement("div", { style: { opacity: 0.8, marginBottom: '12px' } }, "WordPress username. The user who will receive the asset."),
                        React.createElement(UserSearchField_1.UserSearchField, { onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.destination = value;
                                this.setState({ promise: state });
                            } }))),
                React.createElement("div", null,
                    React.createElement(components_1.CheckboxControl, { label: "Pseudo promise", help: "Pseudo promises allow arbitrary asset names", checked: this.state.promise.pseudo, onChange: (value) => {
                            const state = Object.assign({}, this.state.promise);
                            state.pseudo = value;
                            state.asset = null;
                            state.quantity = 0;
                            this.setState({ promise: state });
                        } })),
                React.createElement("div", null,
                    React.createElement("label", null,
                        "Asset",
                        React.createElement("div", { style: { opacity: 0.8, marginBottom: '12px' } },
                            React.createElement("div", null, "Name of the asset that will be promised."),
                            React.createElement("div", null, "Note: Only the whitelisted assets are searchable.")),
                        this.state.promise.pseudo == false
                            ? React.createElement(AssetSearchField_1.AssetSearchField, { assets: this.getAssetOptions(), value: this.state.promise.asset, onChange: (value) => {
                                    const state = Object.assign({}, this.state.promise);
                                    state.asset = value;
                                    this.setState({ promise: state });
                                } })
                            : React.createElement(components_1.TextControl, { value: this.state.promise.asset, onChange: (value) => {
                                    const state = Object.assign({}, this.state.promise);
                                    state.asset = value;
                                    this.setState({ promise: state });
                                } }))),
                this.isAssetValid() &&
                    React.createElement("div", null,
                        React.createElement("label", null,
                            "Quantity",
                            React.createElement(components_1.Flex, { justify: "flex-start", align: "center", style: { paddingTop: '12px' } },
                                React.createElement(components_1.TextControl, { type: "number", value: this.state.promise.quantity, min: 0, style: { maxWidth: '100px' }, onChange: (value) => {
                                        const state = Object.assign({}, this.state.promise);
                                        state.quantity = value;
                                        this.setState({ promise: state });
                                    } }),
                                this.state.promise.pseudo == false &&
                                    React.createElement("span", null,
                                        React.createElement("span", null, "of / "),
                                        React.createElement("span", { title: this.getMaxCount() },
                                            React.createElement("strong", null, parseFloat(this.getMaxCount().toFixed(4))))))),
                        React.createElement(components_1.TextControl, { label: "Ref", help: "Extra reference data", value: this.state.promise.ref, onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.ref = value;
                                this.setState({ promise: state });
                            } }),
                        React.createElement(components_1.TextareaControl, { label: "Note", help: "Note to display to user", value: this.state.promise.note, onChange: (value) => {
                                const state = Object.assign({}, this.state.promise);
                                state.note = value;
                                this.setState({ promise: state });
                            } }))),
            React.createElement(components_1.Flex, { justify: "flex-start" },
                React.createElement(components_1.Button, { isPrimary: true, disabled: this.props.saving, onClick: () => {
                        this.onSubmit();
                    }, style: { marginTop: '12px' } }, "Create promise"),
                this.props.saving === true &&
                    React.createElement(components_1.Spinner, null),
                React.createElement(components_1.Button, { isTertiary: true, disabled: this.props.saving, onClick: () => {
                        this.onCancel();
                    }, style: { marginTop: '12px' } }, "Cancel"))));
    }
}
exports.PromiseStoreForm = PromiseStoreForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/SavePanel.tsx":
/*!*****************************************************!*\
  !*** ./resources/ts/Admin/Components/SavePanel.tsx ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.SavePanel = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SavePanel extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        var _a;
        return (React.createElement(components_1.Flex
        //@ts-ignore
        , { 
            //@ts-ignore
            direction: "row", justify: "flex-start", style: { marginTop: '8px' } },
            React.createElement(components_1.Button, { isPrimary: true, isLarge: true, disabled: this.props.saving, onClick: () => {
                    this.props.onClick();
                } }, (_a = this.props.label) !== null && _a !== void 0 ? _a : 'Save settings'),
            this.props.saving === true &&
                React.createElement(components_1.Spinner, null)));
    }
}
exports.SavePanel = SavePanel;


/***/ }),

/***/ "./resources/ts/Admin/Components/Settings/IntegrationSettingsForm.tsx":
/*!****************************************************************************!*\
  !*** ./resources/ts/Admin/Components/Settings/IntegrationSettingsForm.tsx ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.IntegrationSettingsForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const StatusIndicator_1 = __webpack_require__(/*! ../../Components/StatusIndicator */ "./resources/ts/Admin/Components/StatusIndicator.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class IntegrationSettingsForm extends react_1.Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
    }
    onChange(newSettings) {
        this.props.onChange(newSettings);
    }
    render() {
        var _a, _b, _c;
        return (React.createElement(components_1.Flex
        //@ts-ignore
        , { 
            //@ts-ignore
            direction: "column", style: { flex: '1', maxWidth: '468px', marginTop: '12px' } },
            React.createElement(StatusIndicator_1.StatusIndicator, { status: (_a = this.props.status) !== null && _a !== void 0 ? _a : false }),
            React.createElement(components_1.TextControl, { label: "Client ID", value: (_b = this.props.settings.client_id) !== null && _b !== void 0 ? _b : '', onChange: (value) => {
                    let newSettings = Object.assign({}, this.props.settings);
                    newSettings.client_id = value;
                    this.onChange(newSettings);
                } }),
            React.createElement(components_1.TextControl, { label: "Client Secret", value: (_c = this.props.settings.client_secret) !== null && _c !== void 0 ? _c : '', onChange: (value) => {
                    let newSettings = Object.assign({}, this.props.settings);
                    newSettings.client_secret = value;
                    this.onChange(newSettings);
                } })));
    }
}
exports.IntegrationSettingsForm = IntegrationSettingsForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/Settings/IntegrationSettingsHelp.tsx":
/*!****************************************************************************!*\
  !*** ./resources/ts/Admin/Components/Settings/IntegrationSettingsHelp.tsx ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.IntegrationSettingsHelp = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
class IntegrationSettingsHelp extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        var _a, _b, _c, _d;
        return (React.createElement("div", null,
            React.createElement("ul", { className: "tk_steps" },
                React.createElement("li", null,
                    React.createElement("span", null, "1. Add a new application on "),
                    React.createElement("a", { href: "https://tokenpass.tokenly.com/auth/apps", target: "_blank" }, "Tokenpass Developers"),
                    "."),
                React.createElement("li", null, "2. Enter the received app credentials below."),
                React.createElement("li", null, "3. Connect your Tokenpass account on the Connection screen to unlock more features.")),
            React.createElement("div", { className: "tk_app_details" },
                React.createElement("h3", null, "Register Client Application"),
                React.createElement("span", null,
                    React.createElement("span", null,
                        React.createElement("b", null, "CLIENT NAME: ")),
                    React.createElement("span", null, "Random Input")),
                React.createElement("br", null),
                React.createElement("span", null,
                    React.createElement("span", null,
                        React.createElement("b", null, "APP HOMEPAGE URL: ")),
                    React.createElement("a", { href: (_a = this.props) === null || _a === void 0 ? void 0 : _a.appHomepageUrl, target: "_blank" }, (_b = this.props) === null || _b === void 0 ? void 0 : _b.appHomepageUrl)),
                React.createElement("br", null),
                React.createElement("span", null,
                    React.createElement("span", null,
                        React.createElement("b", null, "CLIENT AUTHORIZATION REDIRECT URL: ")),
                    React.createElement("a", { href: (_c = this.props) === null || _c === void 0 ? void 0 : _c.clientAuthUrl, target: "_blank" }, (_d = this.props) === null || _d === void 0 ? void 0 : _d.clientAuthUrl)))));
    }
}
exports.IntegrationSettingsHelp = IntegrationSettingsHelp;


/***/ }),

/***/ "./resources/ts/Admin/Components/Settings/OauthSettingsForm.tsx":
/*!**********************************************************************!*\
  !*** ./resources/ts/Admin/Components/Settings/OauthSettingsForm.tsx ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.OauthSettingsForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class OauthSettingsForm extends react_1.Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
    }
    onChange(newSettings) {
        this.props.onChange(newSettings);
    }
    render() {
        return (React.createElement(components_1.Flex
        //@ts-ignore
        , { 
            //@ts-ignore
            direction: "column" },
            React.createElement(components_1.TextControl, { label: "Redirect URL", value: this.props.settings.success_url, help: "Default redirect URL on success for the login shortcode and the main login form.", placeholder: "/tokenly/user/me/", onChange: (value) => {
                    const state = Object.assign({}, this.props.settings);
                    state.success_url = value;
                    this.onChange(state);
                } }),
            React.createElement(components_1.ToggleControl, { label: "Use Single sign-on (SSO)", help: "Allows the existing users to login using their Tokenpass account.", checked: this.props.settings.use_single_sign_on, onChange: (value) => {
                    const state = Object.assign({}, this.props.settings);
                    state.use_single_sign_on = value;
                    this.onChange(state);
                } }),
            React.createElement(components_1.ToggleControl, { label: "Allow accounts without email", help: "Allows connecting Tokenpass accounts which have no email accounts associated.", checked: this.props.settings.allow_no_email, onChange: (value) => {
                    const state = Object.assign({}, this.props.settings);
                    state.allow_no_email = value;
                    this.onChange(state);
                } }),
            React.createElement(components_1.ToggleControl, { label: "Allow accounts without a confirmed email", help: "Allow connecting Tokenpass accounts which have an unconfirmed email account associated.", checked: this.props.settings.allow_unconfirmed_email, onChange: (value) => {
                    const state = Object.assign({}, this.props.settings);
                    state.allow_unconfirmed_email = value;
                    this.onChange(state);
                } })));
    }
}
exports.OauthSettingsForm = OauthSettingsForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/Settings/TcaSettingsForm.tsx":
/*!********************************************************************!*\
  !*** ./resources/ts/Admin/Components/Settings/TcaSettingsForm.tsx ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.TcaSettingsForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class TcaSettingsForm extends react_1.Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
        this.isPostTypeChecked = this.isPostTypeChecked.bind(this);
        this.isTaxonomyChecked = this.isTaxonomyChecked.bind(this);
    }
    onChange(newSettings) {
        this.props.onChange(newSettings);
    }
    isPostTypeChecked(key) {
        var _a, _b;
        let checked = false;
        if (((_a = this.props.settings) === null || _a === void 0 ? void 0 : _a.post_types) && ((_b = this.props.settings) === null || _b === void 0 ? void 0 : _b.post_types[key])) {
            checked = this.props.settings.post_types[key];
        }
        return checked;
    }
    isTaxonomyChecked(key) {
        var _a, _b;
        let checked = false;
        if (((_a = this.props.settings) === null || _a === void 0 ? void 0 : _a.taxonomies) && ((_b = this.props.settings) === null || _b === void 0 ? void 0 : _b.taxonomies[key])) {
            checked = this.props.settings.taxonomies[key];
        }
        return checked;
    }
    render() {
        const postTypes = [];
        if (this.props.data.post_types) {
            Object.keys(this.props.data.post_types).map((key, index) => {
                const label = this.props.data.post_types[key];
                const item = (React.createElement(components_1.CheckboxControl, { label: label, checked: this.isPostTypeChecked(key), onChange: (value) => {
                        let settings = Object.assign({}, this.props.settings);
                        settings.post_types[key] = value;
                        this.onChange(settings);
                    } }));
                postTypes.push(item);
            });
        }
        const taxonomies = [];
        if (this.props.data.taxonomies) {
            Object.keys(this.props.data.taxonomies).map((key, index) => {
                const label = this.props.data.taxonomies[key];
                const item = (React.createElement(components_1.CheckboxControl, { label: label, checked: this.isTaxonomyChecked(key), onChange: (value) => {
                        let settings = Object.assign({}, this.props.settings);
                        settings.taxonomies[key] = value;
                        this.onChange(settings);
                    } }));
                taxonomies.push(item);
            });
        }
        return (React.createElement(components_1.Flex
        //@ts-ignore
        , { 
            //@ts-ignore
            direction: "column" },
            React.createElement("fieldset", null,
                React.createElement(components_1.Flex
                //@ts-ignore
                , { 
                    //@ts-ignore
                    direction: "column" },
                    React.createElement("legend", { style: { marginBottom: '8px' } },
                        React.createElement("strong", null, "Filtering options"),
                        React.createElement("div", null,
                            "Filtering the content can slow down page loading speed. ",
                            React.createElement("br", null),
                            "The following options allow fine-grained control over what gets filtered.")),
                    React.createElement(components_1.ToggleControl, { label: "Filter menu items", help: "Filters the menus made via Customizer. Note that the custom / external links will not be tested.", checked: this.props.settings.filter_menu_items, onChange: (value) => {
                            let settings = Object.assign({}, this.props.settings);
                            settings.filter_menu_items = value;
                            this.onChange(settings);
                        } }),
                    React.createElement(components_1.ToggleControl, { label: "Filter post results", help: "Filters the post listings which are not controlable by the menu editor, like recent post list.", checked: this.props.settings.filter_post_results, onChange: (value) => {
                            let settings = Object.assign({}, this.props.settings);
                            settings.filter_post_results = value;
                            this.onChange(settings);
                        } }))),
            React.createElement("hr", null),
            React.createElement("div", null,
                React.createElement("strong", null, "Post types"),
                React.createElement("div", null,
                    "The selected post types will be able to use the TCA functions. ",
                    React.createElement("br", null),
                    " The rule editor will be available at the post editing screen.")),
            React.createElement(components_1.Flex
            //@ts-ignore
            , { 
                //@ts-ignore
                direction: "column", style: { flex: '1', maxWidth: '468px', marginTop: '12px' } }, postTypes.length > 0 ? postTypes : React.createElement("div", { style: { opacity: 0.6 } }, "No post types found")),
            React.createElement("div", { style: { marginTop: '12px' } },
                React.createElement("strong", null, "Taxonomies"),
                React.createElement("div", null,
                    "The selected taxonomies will be able to use the TCA functions. ",
                    React.createElement("br", null),
                    " The rule editor will be available at the taxonomy term editing screen.")),
            React.createElement(components_1.Flex
            //@ts-ignore
            , { 
                //@ts-ignore
                direction: "column", style: { flex: '1', maxWidth: '468px', marginTop: '12px' } }, taxonomies.length > 0 ? taxonomies : React.createElement("div", { style: { opacity: 0.6 } }, "No taxonomies found"))));
    }
}
exports.TcaSettingsForm = TcaSettingsForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/SourceCard.tsx":
/*!******************************************************!*\
  !*** ./resources/ts/Admin/Components/SourceCard.tsx ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.SourceCard = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceCard extends react_1.Component {
    constructor(props) {
        super(props);
        this.getAssets = this.getAssets.bind(this);
    }
    getAssets() {
        var _a, _b, _c, _d;
        let assets = 'all';
        if ((_b = (_a = this.props.source) === null || _a === void 0 ? void 0 : _a.assets) === null || _b === void 0 ? void 0 : _b.length) {
            assets = (_d = (_c = this.props.source) === null || _c === void 0 ? void 0 : _c.assets) === null || _d === void 0 ? void 0 : _d.join(', ');
        }
        return assets;
    }
    render() {
        var _a;
        return (React.createElement(components_1.Card, { size: "extraSmall", style: { width: '100%' } },
            React.createElement(components_1.CardHeader, null,
                React.createElement("div", { title: this.props.source.address },
                    React.createElement("a", { href: `/wp-admin/admin.php?page=tokenly-source-show&source=${this.props.source.address_id}` }, (_a = this.props.source.address) === null || _a === void 0 ? void 0 : _a.label))),
            React.createElement(components_1.CardBody, { style: { width: '100%' } },
                React.createElement(components_1.Flex, { style: { width: '100%', alignItems: 'center' } },
                    React.createElement("div", { style: { flex: 1 } },
                        React.createElement("div", null,
                            React.createElement("span", null, "Assets (whitelisted): "),
                            React.createElement("strong", null, this.getAssets()))))),
            React.createElement(components_1.CardFooter, null,
                React.createElement(components_1.Flex, { justify: "flex-start" },
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-source-edit&source=${this.props.source.address_id}` }, "Manage source"),
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-source-show&source=${this.props.source.address_id}` }, "View details"),
                    React.createElement(components_1.Button, { isSecondary: true, isSmall: true, href: `/wp-admin/admin.php?page=tokenly-balances-show&address=${this.props.source.address_id}` }, "View balances")))));
    }
}
exports.SourceCard = SourceCard;


/***/ }),

/***/ "./resources/ts/Admin/Components/SourceEditForm.tsx":
/*!**********************************************************!*\
  !*** ./resources/ts/Admin/Components/SourceEditForm.tsx ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.SourceEditForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceEditForm extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            source: {
                address_id: null,
                assets: null,
            },
        };
        this.onSave = this.onSave.bind(this);
        this.onDelete = this.onDelete.bind(this);
        this.state.source = Object.assign(this.state.source, this.props.sourceData);
    }
    onSave() {
        this.props.onSave(this.state.source);
    }
    onDelete() {
        this.props.onDelete();
    }
    onCancel() {
        this.props.onCancel();
    }
    render() {
        return React.createElement("div", null,
            React.createElement("form", null,
                React.createElement("div", { style: { maxWidth: "320px" } },
                    React.createElement("div", null,
                        React.createElement(components_1.TextareaControl, { label: "Whitelisted assets", help: "Comma-separated values. Assets which are allowed for promises.", value: this.state.source.assets, onChange: (value) => {
                                const state = Object.assign({}, this.state.source);
                                state.assets = value;
                                this.setState({ source: state });
                            } })),
                    React.createElement(components_1.Flex, { justify: "flex-start", style: { marginTop: '12px' } },
                        React.createElement(components_1.Button, { isPrimary: true, disabled: this.props.saving, onClick: () => {
                                this.onSave();
                            } }, "Save source"),
                        React.createElement(components_1.Button, { isSecondary: true, disabled: this.props.deleting, onClick: () => {
                                this.onDelete();
                            } }, "Delete source"),
                        React.createElement(components_1.Button, { isTertiary: true, disabled: this.props.deleting, onClick: () => {
                                this.onCancel();
                            } }, "Cancel")))));
    }
}
exports.SourceEditForm = SourceEditForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/SourceList.tsx":
/*!******************************************************!*\
  !*** ./resources/ts/Admin/Components/SourceList.tsx ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.SourceList = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const SourceCard_1 = __webpack_require__(/*! ./SourceCard */ "./resources/ts/Admin/Components/SourceCard.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceList extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        let listItems = Object.keys(this.props.sourceList).map((key) => this.props.sourceList[key]);
        listItems = listItems.map((sourceItem, i) => {
            return (React.createElement("div", { style: { width: '100%' } },
                React.createElement(SourceCard_1.SourceCard, { source: sourceItem })));
        });
        return (React.createElement("div", { style: { width: '100%' } }, listItems.length > 0
            //@ts-ignore
            ? React.createElement(components_1.Flex, { direction: "column", style: { width: '100%' } }, listItems)
            : React.createElement("div", { style: { opacity: 0.5 } }, "There are no registered sources")));
    }
}
exports.SourceList = SourceList;


/***/ }),

/***/ "./resources/ts/Admin/Components/SourceStoreForm.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Components/SourceStoreForm.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.SourceStoreForm = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceStoreForm extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            address: null,
            assets: null,
            addressOptions: [],
        };
        this.onSubmit = this.onSubmit.bind(this);
        this.getCurrentAddressType = this.getCurrentAddressType.bind(this);
        this.getCurrentAddressAssets = this.getCurrentAddressAssets.bind(this);
        const options = this.props.addresses.map((address, index) => {
            return {
                label: address.label,
                value: index,
            };
        });
        this.state.addressOptions = options;
        if (this.state.addressOptions.length > 0) {
            this.state.address = this.state.addressOptions[0].value;
        }
    }
    onSubmit() {
        const selectedAddress = this.props.addresses[this.state.address];
        if (!selectedAddress) {
            return;
        }
        const source = {
            address: selectedAddress.address,
            type: selectedAddress.type,
            assets: this.state.assets,
        };
        this.props.onSubmit(source);
    }
    onCancel() {
        this.props.onCancel();
    }
    getCurrentAddressType() {
        var _a;
        if (this.state.address != null) {
            return (_a = this.props.addresses[this.state.address]) === null || _a === void 0 ? void 0 : _a.type;
        }
    }
    getCurrentAddressAssets() {
        if (this.state.address != null) {
            const balances = this.props.addresses[this.state.address].balances;
            const assets = balances.map((balance) => {
                return balance.name;
            });
            if ((assets === null || assets === void 0 ? void 0 : assets.length) == 0) {
                return 'none';
            }
            return assets.join(', ');
        }
    }
    getCurrentAddress() {
        var _a;
        if (this.state.address != null) {
            return (_a = this.props.addresses[this.state.address]) === null || _a === void 0 ? void 0 : _a.address;
        }
    }
    render() {
        return (React.createElement("form", { style: { width: '100%', maxWidth: "400px" } },
            React.createElement("div", null,
                React.createElement(components_1.SelectControl, { label: "Address", value: this.state.address, style: { width: '100%' }, options: this.state.addressOptions, help: " Blockchain wallet address", onChange: (value) => {
                        this.setState({ address: value });
                        this.props.onChange(this.props.addresses[value]);
                    } }),
                this.state.address != null &&
                    React.createElement("div", null,
                        React.createElement("div", { style: { margin: '10px 0' } },
                            React.createElement("div", null, "Address info:"),
                            React.createElement("div", null,
                                React.createElement("strong", null, "Type: "),
                                React.createElement("span", null, this.getCurrentAddressType())),
                            React.createElement("div", null,
                                React.createElement("strong", null, "Address: "),
                                React.createElement("span", null, this.getCurrentAddress())),
                            React.createElement("div", null,
                                React.createElement("strong", null, "Assets: "),
                                React.createElement("a", { href: `/wp-admin/admin.php?page=tokenly-balances-show&address=${this.getCurrentAddress()}` }, "View balances"))),
                        React.createElement(components_1.TextareaControl, { label: "Whitelisted assets", help: "Comma-separated values. Leaving empty will make all assets whitelisted. Only whitelisted assets can be promised.", value: this.state.assets, onChange: (value) => {
                                this.setState({ assets: value });
                            } })),
                React.createElement(components_1.Flex, { style: { marginTop: '12px' }, justify: "flex-start" },
                    React.createElement(components_1.Button, { isPrimary: true, disabled: this.state.address === null, onClick: () => {
                            this.onSubmit();
                        } }, "Register source"),
                    this.props.saving === true &&
                        React.createElement(components_1.Spinner, null),
                    React.createElement(components_1.Button, { isTertiary: true, disabled: this.props.saving, onClick: () => {
                            this.onCancel();
                        } }, "Cancel"),
                    this.props.saving === true &&
                        React.createElement(components_1.Spinner, null)))));
    }
}
exports.SourceStoreForm = SourceStoreForm;


/***/ }),

/***/ "./resources/ts/Admin/Components/StatusIndicator.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Components/StatusIndicator.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.StatusIndicator = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class StatusIndicator extends react_1.Component {
    constructor(props) {
        super(props);
    }
    render() {
        var _a, _b;
        return (React.createElement(components_1.Flex, { justify: "flex-start", align: "baseline", gap: 0, style: { marginBottom: '8px' } },
            React.createElement("span", null, "Status: "),
            React.createElement("span", { style: { marginLeft: '5px' } },
                React.createElement("strong", null, ((_a = this.props) === null || _a === void 0 ? void 0 : _a.status) ? 'Connected' : 'Not connected')),
            React.createElement("span", { className: "tokenpass status-indicator", style: {
                    marginLeft: '10px',
                    backgroundColor: ((_b = this.props) === null || _b === void 0 ? void 0 : _b.status) ? 'rgb(135 211 82)' : '#d84315',
                } })));
    }
}
exports.StatusIndicator = StatusIndicator;


/***/ }),

/***/ "./resources/ts/Admin/Components/TcaRuleEditor.tsx":
/*!*********************************************************!*\
  !*** ./resources/ts/Admin/Components/TcaRuleEditor.tsx ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class TcaRuleEditor extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            rules: [],
        };
        this.onUpdate = props.onUpdate;
        this.state.rules = Object.assign([], props.rules);
    }
    onUpdate(rules) {
        //
    }
    onAdd() {
        let newState = Object.assign({}, this.state);
        newState.rules[newState.rules.length] = { asset: null, quantity: 0, op: '=', stackOp: 'AND' };
        this.setState(newState);
        this.dispatchUpdate();
    }
    onRemove(rule) {
        let newState = Object.assign({}, this.state);
        let index = this.state.rules.indexOf(rule);
        if (index !== -1) {
            newState.rules.splice(index, 1);
        }
        this.setState(newState);
        this.dispatchUpdate();
    }
    dispatchUpdate() {
        this.onUpdate(this.state.rules);
    }
    render() {
        const listItems = this.state.rules.map((rule, i) => {
            return (React.createElement(components_1.Flex, { justify: "flex-start", align: "center" },
                React.createElement(components_1.TextControl, { value: rule.asset, placeholder: "Asset", onChange: (value) => {
                        let newState = Object.assign({}, this.state);
                        newState.rules[i].asset = value;
                        this.setState(Object.assign({}, newState));
                        this.dispatchUpdate();
                    } }),
                React.createElement(components_1.SelectControl, { placeholder: "Logic", value: rule.op, options: [
                        { label: '>=', value: '>=' },
                        { label: '>', value: '>' },
                        { label: '=', value: '=' },
                        { label: '==', value: '==' },
                        { label: '!=', value: '!=' },
                        { label: '!', value: '!' },
                        { label: '<', value: '<' },
                        { label: '<=', value: '<=' },
                    ], onChange: (value) => {
                        let newState = Object.assign({}, this.state);
                        newState.rules[i].op = value;
                        this.setState(Object.assign({}, newState));
                        this.dispatchUpdate();
                    } }),
                React.createElement(components_1.TextControl, { value: rule.quantity, placeholder: "Quantity", style: { maxWidth: '100px' }, type: "number", min: 0, onChange: (value) => {
                        let newState = Object.assign({}, this.state);
                        newState.rules[i].quantity = value;
                        this.setState(Object.assign({}, newState));
                        this.dispatchUpdate();
                    } }),
                i > 0 &&
                    React.createElement(components_1.SelectControl, { placeholder: "Grouping", value: rule.stackOp, options: [
                            { label: 'AND', value: 'AND' },
                            { label: 'OR', value: 'OR' },
                        ], onChange: (value) => {
                            let newState = Object.assign({}, this.state);
                            newState.rules[i].stackOp = value;
                            this.setState(Object.assign({}, newState));
                            this.dispatchUpdate();
                        } }),
                React.createElement(components_1.Button, { isTertiary: true, isSmall: true, style: { marginBottom: '8px' }, onClick: () => {
                        this.onRemove(rule);
                    } },
                    React.createElement(components_1.Dashicon, { icon: "no" }))));
        });
        return (React.createElement("div", { style: { display: 'inline-block', marginTop: '12px' } },
            React.createElement("label", null,
                React.createElement("strong", null, "TCA Rule Editor"),
                React.createElement("div", { style: { opacity: 0.8 } }, "The visitor's token inventory will be checked against these rules. If not passed - access to the content will be prevented."),
                React.createElement("ul", null, listItems)),
            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, onClick: () => {
                    this.onAdd();
                } }, "Add rule")));
    }
}
exports["default"] = TcaRuleEditor;


/***/ }),

/***/ "./resources/ts/Admin/Components/UserLink.tsx":
/*!****************************************************!*\
  !*** ./resources/ts/Admin/Components/UserLink.tsx ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.UserLink = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class UserLink extends react_1.Component {
    constructor(props) {
        super(props);
    }
    getUserUrl(id = null) {
        if (id) {
            return `/tokenly/user/${id}`;
        }
        else {
            return false;
        }
    }
    render() {
        return (React.createElement("div", null,
            React.createElement(components_1.Dashicon, { icon: "admin-users", style: { marginRight: '2px' } }),
            React.createElement("strong", { title: this.props.alt },
                React.createElement("a", { href: this.getUserUrl(this.props.id) },
                    React.createElement("span", null, this.props.name ? this.props.name : 'unknown')))));
    }
}
exports.UserLink = UserLink;


/***/ }),

/***/ "./resources/ts/Admin/Components/UserSearchField.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Components/UserSearchField.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.UserSearchField = void 0;
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const { __ } = wp.i18n;
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class UserSearchField extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            keywords: null,
            user: null,
            users: [],
        };
        this.onKeywordsChange = this.onKeywordsChange.bind(this);
        this.onUserChange = this.onUserChange.bind(this);
    }
    onKeywordsChange(keywords) {
        if (keywords == '') {
            return;
        }
        this.setState({ keywords: keywords });
        this.userRepository.index({
            suggestions: true,
            name: keywords,
        }).then((results) => {
            if (results.length <= 0) {
                return;
            }
            const options = results.map((user) => {
                return {
                    value: user.id,
                    label: user.name,
                };
            });
            this.setState({ users: [options[0]] });
        }).catch((error) => {
            console.log(error);
        });
    }
    onUserChange(id) {
        this.setState({ user: id });
        this.props.onChange(id);
    }
    render() {
        return React.createElement("div", { style: { height: '40px' } },
            React.createElement(components_1.ComboboxControl, { label: this.props.label, help: this.props.help, value: this.state.user, onChange: (value) => {
                    this.onUserChange(value);
                }, options: this.state.users, onFilterValueChange: (keywords) => {
                    this.onKeywordsChange(keywords);
                } }));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.UserRepositoryInterface),
    __metadata("design:type", Object)
], UserSearchField.prototype, "userRepository", void 0);
exports.UserSearchField = UserSearchField;


/***/ }),

/***/ "./resources/ts/Admin/Components/Whitelist.tsx":
/*!*****************************************************!*\
  !*** ./resources/ts/Admin/Components/Whitelist.tsx ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.Whitelist = void 0;
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class Whitelist extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            whitelist: [],
        };
        this.onUpdate = props.onUpdate;
        this.state.whitelist = Object.assign([], props.whitelist);
    }
    onUpdate(whitelist) {
        //
    }
    onAdd() {
        let newState = Object.assign({}, this.state);
        newState.whitelist[newState.whitelist.length] = { address: '', index: '' };
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
        const listItems = this.state.whitelist.map((listItem, i) => {
            return (React.createElement(components_1.Flex, { style: { alignItems: 'flex-end', margin: '8px 0' } },
                React.createElement(components_1.TextControl, { label: "Contract Address", value: listItem.address, onChange: (value) => {
                        let newState = Object.assign({}, this.state);
                        newState.whitelist[i].address = value;
                        this.setState(Object.assign({}, newState));
                        this.dispatchUpdate();
                    } }),
                React.createElement(components_1.TextControl, { label: "Token Index", value: listItem.index, onChange: (value) => {
                        let newState = Object.assign({}, this.state);
                        newState.whitelist[i].index = value;
                        this.setState(Object.assign({}, newState));
                        this.dispatchUpdate();
                    } }),
                React.createElement(components_1.Button, { isTertiary: true, onClick: () => {
                        this.onRemove(i);
                    } },
                    React.createElement(components_1.Dashicon, { icon: "no" }))));
        });
        return (React.createElement("div", null,
            React.createElement("ul", null, listItems),
            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, onClick: () => {
                    this.onAdd();
                } }, "Add Token")));
    }
}
exports.Whitelist = Whitelist;


/***/ }),

/***/ "./resources/ts/Admin/Pages/BalancesShowPage.tsx":
/*!*******************************************************!*\
  !*** ./resources/ts/Admin/Pages/BalancesShowPage.tsx ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const BalanceList_1 = __webpack_require__(/*! ../Components/BalanceList */ "./resources/ts/Admin/Components/BalanceList.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class BalancesShowPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
    }
    render() {
        var _a, _b, _c, _d, _e;
        return (React.createElement(Page_1.default, { title: 'Address balances' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-source-index' }, "To source list")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement("div", { style: { width: '100%' } },
                            React.createElement("div", { style: { marginBottom: '12px' } },
                                React.createElement("span", null, "Address: "),
                                React.createElement("strong", null, (_b = (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.address) === null || _b === void 0 ? void 0 : _b.address)),
                            React.createElement(BalanceList_1.BalanceList, { balance: (_e = (_d = (_c = this.props.pageData) === null || _c === void 0 ? void 0 : _c.address) === null || _d === void 0 ? void 0 : _d.balance) !== null && _e !== void 0 ? _e : [] })))))));
    }
}
exports["default"] = BalancesShowPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/ConnectionPage.tsx":
/*!*****************************************************!*\
  !*** ./resources/ts/Admin/Pages/ConnectionPage.tsx ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const StatusIndicator_1 = __webpack_require__(/*! ../Components/StatusIndicator */ "./resources/ts/Admin/Components/StatusIndicator.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class ConnectionPage extends react_1.Component {
    constructor(props) {
        super(props);
    }
    getStatusText() {
        var _a;
        let status = 'Not connected';
        if (((_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.status) === true) {
            status = 'Connected';
        }
        return status;
    }
    render() {
        var _a, _b, _c, _d, _e;
        return (React.createElement(Page_1.default, { title: 'Connection' },
            React.createElement(components_1.Panel, { header: "Connection Status" },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement("div", null,
                            React.createElement(StatusIndicator_1.StatusIndicator, { status: (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.status }),
                            this.props.pageData.status == true &&
                                React.createElement("div", null,
                                    React.createElement("span", null, "Connected as: "),
                                    React.createElement("span", null,
                                        React.createElement("strong", null, `${(_c = (_b = this.props.pageData) === null || _b === void 0 ? void 0 : _b.user) === null || _c === void 0 ? void 0 : _c.name} (${(_e = (_d = this.props.pageData) === null || _d === void 0 ? void 0 : _d.user) === null || _e === void 0 ? void 0 : _e.username})`))))),
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { justify: 'flex-start' },
                            React.createElement(components_1.Button, { isPrimary: true, disabled: this.props.pageData.status, href: "/tokenly/oauth/connect?tokenly_success_url=/wp-admin/admin.php?page=tokenly-connection" }, "Connect to Tokenpass"),
                            React.createElement(components_1.Button, { isPrimary: true, disabled: !this.props.pageData.status, href: "/tokenly/oauth/disconnect?tokenly_success_url=/wp-admin/admin.php?page=tokenly-connection" }, "Disconnect from Tokenpass")))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.AuthServiceInterface),
    __metadata("design:type", Object)
], ConnectionPage.prototype, "authService", void 0);
exports["default"] = ConnectionPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/CreditGroupEditPage.tsx":
/*!**********************************************************!*\
  !*** ./resources/ts/Admin/Pages/CreditGroupEditPage.tsx ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const CreditGroupEditForm_1 = __webpack_require__(/*! ../Components/CreditGroupEditForm */ "./resources/ts/Admin/Components/CreditGroupEditForm.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupEditPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            saving: false,
        };
        this.onSave = this.onSave.bind(this);
        this.onCancel = this.onCancel.bind(this);
    }
    return() {
        window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
    }
    onSave(creditGroup) {
        this.setState({ saving: true });
        let updateParams = Object.assign({}, creditGroup);
        updateParams.uuid = this.props.pageData.credit_group.uuid;
        this.creditGroupRepository.update(updateParams).then((result) => {
            this.setState({ saving: false });
            this.return();
        });
    }
    onCancel() {
        this.return();
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Manage credit group' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-credit-group-index' }, "Back to credit group list")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement("div", null,
                            React.createElement("div", null,
                                React.createElement(CreditGroupEditForm_1.CreditGroupEditForm, { onSave: this.onSave, onCancel: this.onCancel, saving: this.state.saving, creditGroup: this.props.pageData.credit_group }))))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.CreditGroupRepositoryInterface),
    __metadata("design:type", Object)
], CreditGroupEditPage.prototype, "creditGroupRepository", void 0);
exports["default"] = CreditGroupEditPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/CreditGroupIndexPage.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Pages/CreditGroupIndexPage.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const CreditGroupList_1 = __webpack_require__(/*! ../Components/CreditGroupList */ "./resources/ts/Admin/Components/CreditGroupList.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupIndexPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Credit Groups' },
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { justify: "flex-start", style: { width: '100%' } },
                            React.createElement(components_1.Button, { isPrimary: true, href: '/wp-admin/admin.php?page=tokenly-credit-transaction-store' }, "Make transaction"),
                            React.createElement(components_1.Button, { isPrimary: true, href: '/wp-admin/admin.php?page=tokenly-credit-group-store' }, "Register credit group"))))),
            React.createElement(components_1.Panel, { header: "Registered credit groups" },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(CreditGroupList_1.CreditGroupList, { creditGroups: this.props.pageData.credit_groups }))))));
    }
}
exports["default"] = CreditGroupIndexPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/CreditGroupShowPage.tsx":
/*!**********************************************************!*\
  !*** ./resources/ts/Admin/Pages/CreditGroupShowPage.tsx ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const dayjs = __webpack_require__(/*! dayjs */ "./node_modules/dayjs/dayjs.min.js");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupShowPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
    }
    dateFormatted(date) {
        if (date) {
            return dayjs(date).format('MMMM D, YYYY h:mm A');
        }
        return;
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Credit group details' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-credit-group-index' }, "Back to credit group list")),
            React.createElement(components_1.Panel, { header: this.props.pageData.credit_group.name },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { style: { width: '100%', alignItems: 'center' } },
                            React.createElement("div", { style: { flex: 1 } },
                                React.createElement("div", null,
                                    React.createElement("span", null, "Name: "),
                                    React.createElement("strong", null, this.props.pageData.credit_group.name)),
                                React.createElement("div", null,
                                    React.createElement("span", null, "UUID: "),
                                    React.createElement("strong", null, this.props.pageData.credit_group.uuid)),
                                React.createElement("div", null,
                                    React.createElement("span", null, "Active: "),
                                    React.createElement("span", null,
                                        React.createElement("strong", null, this.props.pageData.credit_group.active ? 'Yes' : 'No'))),
                                React.createElement("div", null,
                                    React.createElement("span", null, "App whitelist: "),
                                    React.createElement("span", null,
                                        React.createElement("strong", null, this.props.pageData.credit_group.app_whitelist))),
                                React.createElement("div", null,
                                    React.createElement("span", null, "Created at: "),
                                    React.createElement("span", null,
                                        React.createElement("strong", null, this.dateFormatted(this.props.pageData.credit_group.created_at)))),
                                React.createElement("div", null,
                                    React.createElement("span", null, "Updated at: "),
                                    React.createElement("span", null,
                                        React.createElement("strong", null, this.dateFormatted(this.props.pageData.credit_group.updated_at))))))))),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { justify: "flex-start", style: { width: '100%' } },
                            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, href: `/wp-admin/admin.php?page=tokenly-credit-group-edit&credit_group=${this.props.pageData.credit_group.uuid}` }, "Manage credit group")))))));
    }
}
exports["default"] = CreditGroupShowPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/CreditGroupStorePage.tsx":
/*!***********************************************************!*\
  !*** ./resources/ts/Admin/Pages/CreditGroupStorePage.tsx ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const CreditGroupStoreForm_1 = __webpack_require__(/*! ../Components/CreditGroupStoreForm */ "./resources/ts/Admin/Components/CreditGroupStoreForm.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditGroupStorePage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            storingCreditGroup: false,
            address: null,
        };
        this.onSubmit = this.onSubmit.bind(this);
    }
    return() {
        window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
    }
    onSubmit(creditGroup) {
        this.creditGroupRepository.store(creditGroup).then((result) => {
            this.return();
        });
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Register credit group' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { href: '/wp-admin/admin.php?page=tokenly-credit-group-index' }, "Back to credit group list")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(CreditGroupStoreForm_1.CreditGroupStoreForm, { onSubmit: this.onSubmit, onCancel: this.return, saving: this.state.storingCreditGroup, style: { marginBottom: '12px' } }))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.CreditGroupRepositoryInterface),
    __metadata("design:type", Object)
], CreditGroupStorePage.prototype, "creditGroupRepository", void 0);
exports["default"] = CreditGroupStorePage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/CreditTransactionIndexPage.tsx":
/*!*****************************************************************!*\
  !*** ./resources/ts/Admin/Pages/CreditTransactionIndexPage.tsx ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const CreditTransactionList_1 = __webpack_require__(/*! ../Components/CreditTransactionList */ "./resources/ts/Admin/Components/CreditTransactionList.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditTransactionIndexPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Credit Transactions' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { href: '/wp-admin/admin.php?page=tokenly-credit-group-index' }, "Back to credit group list")),
            React.createElement(components_1.Panel, { header: "Transactions" },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(CreditTransactionList_1.CreditTransactionList, { creditTransactions: this.props.pageData.credit_transactions }))))));
    }
}
exports["default"] = CreditTransactionIndexPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/CreditTransactionStorePage.tsx":
/*!*****************************************************************!*\
  !*** ./resources/ts/Admin/Pages/CreditTransactionStorePage.tsx ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const CreditTransactionStoreForm_1 = __webpack_require__(/*! ../Components/CreditTransactionStoreForm */ "./resources/ts/Admin/Components/CreditTransactionStoreForm.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class CreditTransactionStorePage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            storingCreditTransaction: false,
            address: null,
        };
        this.onSubmit = this.onSubmit.bind(this);
    }
    return() {
        window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
    }
    onSubmit(creditGroup) {
        this.creditGroupRepository.store(creditGroup).then((result) => {
            this.return();
        });
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Make App Credits transaction' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { href: '/wp-admin/admin.php?page=tokenly-credit-group-index' }, "Back to credit group list")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(CreditTransactionStoreForm_1.CreditTransactionStoreForm, { onSubmit: this.onSubmit, onCancel: this.return, saving: this.state.storingCreditTransaction, style: { marginBottom: '12px' }, creditGroups: this.props.pageData.credit_groups }))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.CreditTransactionRepositoryInterface),
    __metadata("design:type", Object)
], CreditTransactionStorePage.prototype, "creditGroupRepository", void 0);
exports["default"] = CreditTransactionStorePage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/DashboardPage.tsx":
/*!****************************************************!*\
  !*** ./resources/ts/Admin/Pages/DashboardPage.tsx ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class DashboardPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            cards: {
                dashboard: {
                    title: 'Main Dashboard',
                    description: 'Tokenpass main dashboard (external).',
                    icon: 'dashboard',
                    url: 'https://tokenpass.tokenly.com/dashboard',
                },
                inventory: {
                    title: 'Inventory',
                    description: 'View the list of currently owned token assets.',
                    icon: 'money',
                    url: '/tokenly/user/me',
                },
                connection: {
                    title: 'Connection',
                    description: 'Connect or disconnect to Tokenpass network.',
                    icon: 'admin-plugins',
                    url: '/wp-admin/admin.php?page=tokenly-connection',
                },
                vendor: {
                    title: 'Vendor',
                    description: 'Manage token promises.',
                    icon: 'share',
                    url: '/wp-admin/admin.php?page=tokenly-vendor',
                },
                credits: {
                    title: 'App Credits',
                    description: 'Manage credit groups and transactions.',
                    icon: 'money-alt',
                    url: '/wp-admin/admin.php?page=tokenly-credit-group-index',
                },
                whitelist: {
                    title: 'Whitelist',
                    description: 'Configure a filter for tokens displayed on the inventory pages.',
                    icon: 'forms',
                    url: '/wp-admin/admin.php?page=tokenly-whitelist',
                },
                meta: {
                    title: 'Token Meta',
                    description: 'Manage additional information for tokens, displayed on the Inventory page.',
                    icon: 'media-default',
                    url: '/wp-admin/edit.php?post_type=tokenly_token_meta',
                },
                settings: {
                    title: 'Settings',
                    description: 'Manage plugin settings.',
                    icon: 'admin-settings',
                    url: '/wp-admin/admin.php?page=tokenly-settings',
                },
            },
            offlineRoutesUser: [
                'connection'
            ],
            offlineRoutesIntegration: [
                'settings',
            ],
            adminRoutes: [
                'credits',
                'vendor',
                'meta',
                'settings',
                'whitelist',
            ],
        };
        this.canView = this.canView.bind(this);
    }
    canView(key) {
        var _a, _b, _c, _d;
        let canView = false;
        if ((_b = (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.integration_can_connect) !== null && _b !== void 0 ? _b : false) {
            if ((_d = (_c = this.props.pageData) === null || _c === void 0 ? void 0 : _c.user_can_connect) !== null && _d !== void 0 ? _d : false) {
                canView = true;
            }
            else if (this.state.offlineRoutesUser.includes(key)) {
                canView = true;
            }
        }
        if (this.state.offlineRoutesIntegration.includes(key)) {
            canView = true;
        }
        if (this.state.adminRoutes.includes(key) && this.props.pageData.is_admin === false) {
            canView = false;
        }
        return canView;
    }
    render() {
        let cards = [];
        Object.keys(this.state.cards).map((key, index) => {
            const cardItem = this.state.cards[key];
            if (this.canView(key)) {
                cards.push(React.createElement(components_1.Card, null,
                    React.createElement(components_1.CardHeader, { style: { display: 'flex', justifyContent: 'flex-start', } },
                        React.createElement(components_1.Dashicon, { icon: cardItem.icon }),
                        React.createElement("h3", null, cardItem.title)),
                    React.createElement(components_1.CardBody, { size: "large" }, cardItem.description),
                    React.createElement(components_1.CardFooter, null,
                        React.createElement(components_1.Button, { isPrimary: true, href: cardItem.url }, "Visit page"))));
            }
        });
        return (React.createElement(Page_1.default, { title: 'Tokenpass Dashboard' },
            React.createElement("div", { className: "dashboard-card-grid" }, cards)));
    }
}
exports["default"] = DashboardPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/Page.tsx":
/*!*******************************************!*\
  !*** ./resources/ts/Admin/Pages/Page.tsx ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const element_1 = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
class Page extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
    }
    render() {
        return (React.createElement(element_1.Fragment, null,
            React.createElement("h2", null, this.props.title),
            this.props.children));
    }
}
exports["default"] = Page;


/***/ }),

/***/ "./resources/ts/Admin/Pages/PostEditPage.tsx":
/*!***************************************************!*\
  !*** ./resources/ts/Admin/Pages/PostEditPage.tsx ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const element_1 = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
class PostEditPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
    }
    render() {
        return (React.createElement(element_1.Fragment, null));
    }
}
exports["default"] = PostEditPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/PromiseEditPage.tsx":
/*!******************************************************!*\
  !*** ./resources/ts/Admin/Pages/PromiseEditPage.tsx ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const PromiseEditForm_1 = __webpack_require__(/*! ../Components/PromiseEditForm */ "./resources/ts/Admin/Components/PromiseEditForm.tsx");
const EventBus_1 = __webpack_require__(/*! ../../EventBus */ "./resources/ts/EventBus.ts");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseEditPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            saving: false,
            deleting: false,
        };
        this.onSave = this.onSave.bind(this);
        this.onDelete = this.onDelete.bind(this);
        this.deletePromise = this.deletePromise.bind(this);
        this.onConfirmModalChoice = this.onConfirmModalChoice.bind(this);
        this.onCancel = this.onCancel.bind(this);
    }
    return() {
        window.location = '/wp-admin/admin.php?page=tokenly-vendor';
    }
    onSave(promise) {
        this.setState({ saving: true });
        this.promiseRepository.update(this.props.pageData.promise.promise_id, promise).then((result) => {
            this.setState({ saving: false });
            this.return();
        });
    }
    onDelete() {
        EventBus_1.default.dispatch('confirmModalShow', {
            key: 'promiseDelete',
            title: 'Deleting promise',
            subtitle: 'Are you sure you want to delete the promise?',
        });
    }
    deletePromise() {
        this.setState({ deleting: true });
        this.promiseRepository.destroy(this.props.pageData.promise.promise_id).then((result) => {
            this.setState({ deleting: false });
            this.return();
        });
    }
    onConfirmModalChoice(payload) {
        switch (payload.key) {
            case 'promiseDelete':
                if (payload.choice == 'accept') {
                    this.deletePromise();
                }
                break;
        }
    }
    componentDidMount() {
        EventBus_1.default.on('confirmModalChoice', this.onConfirmModalChoice);
    }
    componentWillUnmount() {
        EventBus_1.default.remove('confirmModalChoice', this.onConfirmModalChoice);
    }
    onCancel() {
        this.return();
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Manage promise' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-vendor' }, "Back to vendor"),
                React.createElement("div", null,
                    React.createElement("span", null, "Promise ID: "),
                    React.createElement("strong", null, this.props.pageData.promise.promise_id))),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement("div", null,
                            React.createElement(PromiseEditForm_1.PromiseEditForm, { onSave: this.onSave, onDelete: this.onDelete, onCancel: this.onCancel, saving: this.state.saving, deleting: this.state.deleting, promise: this.props.pageData.promise })))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.PromiseRepositoryInterface),
    __metadata("design:type", Object)
], PromiseEditPage.prototype, "promiseRepository", void 0);
exports["default"] = PromiseEditPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/PromiseShowPage.tsx":
/*!******************************************************!*\
  !*** ./resources/ts/Admin/Pages/PromiseShowPage.tsx ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const dayjs = __webpack_require__(/*! dayjs */ "./node_modules/dayjs/dayjs.min.js");
const PromiseSourceInfo_1 = __webpack_require__(/*! ../Components/PromiseSourceInfo */ "./resources/ts/Admin/Components/PromiseSourceInfo.tsx");
const PromiseParticipants_1 = __webpack_require__(/*! ../Components/PromiseParticipants */ "./resources/ts/Admin/Components/PromiseParticipants.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseShowPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
        this.getProperties = this.getProperties.bind(this);
    }
    dateFormatted(date) {
        if (date) {
            return dayjs(date).format('MMMM D, YYYY h:mm A');
        }
        return;
    }
    getProperties() {
        var _a, _b, _c, _d, _e, _f, _g;
        return [
            {
                label: 'Asset',
                value: (_a = this.props.pageData.promise) === null || _a === void 0 ? void 0 : _a.asset,
            },
            {
                label: 'Quantity (Sat)',
                value: (_c = (_b = this.props.pageData.promise) === null || _b === void 0 ? void 0 : _b.quantity) === null || _c === void 0 ? void 0 : _c.value_sat,
            },
            {
                label: 'Ref',
                value: (_d = this.props.pageData.promise) === null || _d === void 0 ? void 0 : _d.ref,
            },
            {
                label: 'Note',
                value: (_e = this.props.pageData.promise) === null || _e === void 0 ? void 0 : _e.note,
            },
            {
                label: 'Created at',
                value: this.dateFormatted((_f = this.props.pageData.promise) === null || _f === void 0 ? void 0 : _f.created_at),
            },
            {
                label: 'Updated at',
                value: this.dateFormatted((_g = this.props.pageData.promise) === null || _g === void 0 ? void 0 : _g.updated_at),
            },
        ];
    }
    render() {
        const properties = this.getProperties();
        const listItems = properties.map((property) => {
            return (React.createElement("div", null,
                React.createElement("span", null,
                    property.label,
                    ": "),
                React.createElement("span", { style: { opacity: property.value ? 1 : 0.6 } },
                    React.createElement("strong", null, property.value ? property.value : 'No data'))));
        });
        return (React.createElement(Page_1.default, { title: 'Promise details' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-vendor' }, "Back to vendor")),
            React.createElement(components_1.Panel, { header: `№ ${this.props.pageData.promise.promise_id}` },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { style: { width: '100%', alignItems: 'center' } },
                            React.createElement("div", { style: { flex: 1 } },
                                React.createElement(PromiseSourceInfo_1.PromiseSourceInfo, { promise: this.props.pageData.promise, sources: this.props.pageData.sources }),
                                React.createElement(PromiseParticipants_1.PromiseParticipants, { promise: this.props.pageData.promise }),
                                listItems))))),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { style: { width: '100%' } },
                            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, href: `/wp-admin/admin.php?page=tokenly-promise-edit&promise=${this.props.pageData.promise.promise_id}` }, "Manage promise")))))));
    }
}
exports["default"] = PromiseShowPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/PromiseStorePage.tsx":
/*!*******************************************************!*\
  !*** ./resources/ts/Admin/Pages/PromiseStorePage.tsx ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const PromiseStoreForm_1 = __webpack_require__(/*! ../Components/PromiseStoreForm */ "./resources/ts/Admin/Components/PromiseStoreForm.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class PromiseStorePage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            promiseData: [],
            isCreatePromiseModalOpen: false,
            storingPromise: false,
        };
        this.onSubmit = this.onSubmit.bind(this);
        this.onCancel = this.onCancel.bind(this);
    }
    return() {
        window.location = '/wp-admin/admin.php?page=tokenly-vendor';
    }
    onSubmit(params) {
        this.promiseRepository.store(params).then(result => {
            this.return();
        });
    }
    onCancel() {
        this.return();
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Create a token promise' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-vendor' }, "Back to vendor")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(PromiseStoreForm_1.PromiseStoreForm, { onSubmit: this.onSubmit, onCancel: this.onCancel, saving: this.state.storingPromise, style: { marginBottom: '12px' }, sources: this.props.pageData.sources }))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.PromiseRepositoryInterface),
    __metadata("design:type", Object)
], PromiseStorePage.prototype, "promiseRepository", void 0);
exports["default"] = PromiseStorePage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/SettingsPage.tsx":
/*!***************************************************!*\
  !*** ./resources/ts/Admin/Pages/SettingsPage.tsx ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const SavePanel_1 = __webpack_require__(/*! ../Components/SavePanel */ "./resources/ts/Admin/Components/SavePanel.tsx");
const IntegrationSettingsForm_1 = __webpack_require__(/*! ../Components/Settings/IntegrationSettingsForm */ "./resources/ts/Admin/Components/Settings/IntegrationSettingsForm.tsx");
const IntegrationSettingsHelp_1 = __webpack_require__(/*! ../Components/Settings/IntegrationSettingsHelp */ "./resources/ts/Admin/Components/Settings/IntegrationSettingsHelp.tsx");
const TcaSettingsForm_1 = __webpack_require__(/*! ../Components/Settings/TcaSettingsForm */ "./resources/ts/Admin/Components/Settings/TcaSettingsForm.tsx");
const OauthSettingsForm_1 = __webpack_require__(/*! ../Components/Settings/OauthSettingsForm */ "./resources/ts/Admin/Components/Settings/OauthSettingsForm.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SettingsPage extends react_1.Component {
    constructor(props) {
        var _a;
        super(props);
        this.state = {
            integrationSettings: {
                client_id: '',
                client_secret: '',
            },
            tcaSettings: {
                post_types: {},
                taxonomies: {},
                filter_menu_items: null,
                filter_post_results: null,
            },
            oauthSettings: {
                use_single_sign_on: null,
                success_url: '',
                allow_no_email: null,
                allow_unconfirmed_email: null,
            },
            savingIntegrationSettings: false,
            savingTcaSettings: false,
            savingOauthSettings: false,
        };
        this.onIntegrationSettingsSave = this.onIntegrationSettingsSave.bind(this);
        this.onIntegrationSettingsChange = this.onIntegrationSettingsChange.bind(this);
        this.onTcaSettingsSave = this.onTcaSettingsSave.bind(this);
        this.onTcaSettingsChange = this.onTcaSettingsChange.bind(this);
        this.onOauthSettingsSave = this.onOauthSettingsSave.bind(this);
        this.onOauthSettingsChange = this.onOauthSettingsChange.bind(this);
        this.state.integrationSettings = Object.assign(this.state.integrationSettings, this.props.pageData.integration_settings);
        this.state.tcaSettings = Object.assign({}, (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.tca_settings);
        this.state.tcaSettings.post_types = Object.assign({}, this.state.tcaSettings.post_types);
        this.state.tcaSettings.taxonomies = Object.assign({}, this.state.tcaSettings.taxonomies);
        this.state.oauthSettings = Object.assign(this.state.oauthSettings, this.props.pageData.oauth_settings);
    }
    setClientId(value) {
        let state = Object.assign({}, this.state);
        state.integrationSettings.client_id = value;
        this.setState(state);
    }
    setClientSecret(value) {
        let state = Object.assign({}, this.state);
        state.integrationSettings.client_secret = value;
        this.setState(state);
    }
    onIntegrationSettingsSave() {
        this.setState({ savingIntegrationSettings: true });
        this.integrationSettingsRepository.update(this.state.integrationSettings).then((result) => {
            this.setState({ savingIntegrationSettings: false });
            window.location.reload();
        }).catch((error) => {
            console.log(error);
        });
    }
    onIntegrationSettingsChange(newSettings) {
        this.setState({ integrationSettings: newSettings });
    }
    onTcaSettingsSave() {
        this.setState({ savingTcaSettings: true });
        this.tcaSettingsRepository.update(this.state.tcaSettings).then((result) => {
            this.setState({ savingTcaSettings: false });
        }).catch((error) => {
            console.log(error);
        });
    }
    onTcaSettingsChange(newSettings) {
        this.setState({ tcaSettings: newSettings });
    }
    onOauthSettingsSave() {
        this.setState({ savingOauthSettings: true });
        this.oauthSettingsRepository.update(this.state.oauthSettings).then((result) => {
            this.setState({ savingOauthSettings: false });
        }).catch((error) => {
            console.log(error);
        });
    }
    onOauthSettingsChange(newSettings) {
        this.setState({ oauthSettings: newSettings });
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g;
        return (React.createElement(Page_1.default, { title: 'Tokenpass Settings' },
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, { title: "Integration" },
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(IntegrationSettingsHelp_1.IntegrationSettingsHelp, { appHomepageUrl: (_b = (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.integration_data) === null || _b === void 0 ? void 0 : _b.app_homepage_url, clientAuthUrl: (_d = (_c = this.props.pageData) === null || _c === void 0 ? void 0 : _c.integration_data) === null || _d === void 0 ? void 0 : _d.client_auth_url })),
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(IntegrationSettingsForm_1.IntegrationSettingsForm, { status: (_g = (_f = (_e = this.props.pageData) === null || _e === void 0 ? void 0 : _e.integration_data) === null || _f === void 0 ? void 0 : _f.status) !== null && _g !== void 0 ? _g : false, settings: this.state.integrationSettings, onChange: this.onIntegrationSettingsChange })),
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(SavePanel_1.SavePanel, { label: "Save Integration settings", saving: this.state.savingIntegrationSettings, onClick: this.onIntegrationSettingsSave })))),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, { title: "Token Controlled Access (TCA)" },
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(TcaSettingsForm_1.TcaSettingsForm, { settings: this.state.tcaSettings, data: this.props.pageData.tca_data, onChange: this.onTcaSettingsChange })),
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(SavePanel_1.SavePanel, { label: "Save TCA settings", saving: this.state.savingTcaSettings, onClick: this.onTcaSettingsSave })))),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, { title: "Authorization (OAuth)" },
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(OauthSettingsForm_1.OauthSettingsForm, { settings: this.state.oauthSettings, onChange: this.onOauthSettingsChange })),
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(SavePanel_1.SavePanel, { label: "Save OAuth settings", saving: this.state.savingOauthSettings, onClick: this.onOauthSettingsSave }))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.IntegrationSettingsRepositoryInterface),
    __metadata("design:type", Object)
], SettingsPage.prototype, "integrationSettingsRepository", void 0);
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.TcaSettingsRepositoryInterface),
    __metadata("design:type", Object)
], SettingsPage.prototype, "tcaSettingsRepository", void 0);
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.OauthSettingsRepositoryInterface),
    __metadata("design:type", Object)
], SettingsPage.prototype, "oauthSettingsRepository", void 0);
exports["default"] = SettingsPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/SourceEditPage.tsx":
/*!*****************************************************!*\
  !*** ./resources/ts/Admin/Pages/SourceEditPage.tsx ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const SourceEditForm_1 = __webpack_require__(/*! ../Components/SourceEditForm */ "./resources/ts/Admin/Components/SourceEditForm.tsx");
const EventBus_1 = __webpack_require__(/*! ../../EventBus */ "./resources/ts/EventBus.ts");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceEditPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            saving: false,
            deleting: false,
        };
        this.onSave = this.onSave.bind(this);
        this.onDelete = this.onDelete.bind(this);
        this.onCancel = this.onCancel.bind(this);
        this.deleteSource = this.deleteSource.bind(this);
        this.onConfirmModalChoice = this.onConfirmModalChoice.bind(this);
    }
    return() {
        window.location = '/wp-admin/admin.php?page=tokenly-source-index';
    }
    onSave(source) {
        this.setState({ saving: true });
        const sourceData = Object.assign({}, source);
        delete sourceData.address;
        this.sourceRepository.update(this.props.pageData.source.address_id, sourceData).then((result) => {
            this.setState({ saving: false });
            this.return();
        });
    }
    onDelete() {
        EventBus_1.default.dispatch('confirmModalShow', {
            key: 'sourceDelete',
            title: 'Deleting source',
            subtitle: 'Are you sure you want to delete the source?',
        });
    }
    onCancel() {
        this.return();
    }
    deleteSource() {
        this.setState({ deleting: true });
        this.sourceRepository.destroy(this.props.pageData.source.address_id).then((result) => {
            this.setState({ deleting: false });
            this.return();
        });
    }
    onConfirmModalChoice(payload) {
        switch (payload.key) {
            case 'sourceDelete':
                if (payload.choice == 'accept') {
                    this.deleteSource();
                }
                break;
        }
    }
    componentDidMount() {
        EventBus_1.default.on('confirmModalChoice', this.onConfirmModalChoice);
    }
    componentWillUnmount() {
        EventBus_1.default.remove('confirmModalChoice', this.onConfirmModalChoice);
    }
    render() {
        var _a, _b;
        const source = Object.assign({}, this.props.pageData.source);
        if ((_a = source === null || source === void 0 ? void 0 : source.assets) === null || _a === void 0 ? void 0 : _a.length) {
            source.assets = source.assets.join(', ');
        }
        return (React.createElement(Page_1.default, { title: 'Manage source' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-source-index' }, "Back to source list")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement("div", null,
                            React.createElement("div", null,
                                React.createElement("span", null, "Source: "),
                                React.createElement("strong", null,
                                    React.createElement("a", { style: { display: 'inline-block', marginBottom: '12px' }, href: `/wp-admin/admin.php?page=tokenly-source-show&source=${source.address_id}` }, (_b = source === null || source === void 0 ? void 0 : source.address) === null || _b === void 0 ? void 0 : _b.label))),
                            React.createElement("div", null,
                                React.createElement(SourceEditForm_1.SourceEditForm, { onSave: this.onSave, onDelete: this.onDelete, onCancel: this.onCancel, saving: this.state.saving, deleting: this.state.deleting, sourceData: source }))))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.SourceRepositoryInterface),
    __metadata("design:type", Object)
], SourceEditPage.prototype, "sourceRepository", void 0);
exports["default"] = SourceEditPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/SourceIndexPage.tsx":
/*!******************************************************!*\
  !*** ./resources/ts/Admin/Pages/SourceIndexPage.tsx ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const SourceList_1 = __webpack_require__(/*! ../Components/SourceList */ "./resources/ts/Admin/Components/SourceList.tsx");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceIndexPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            sourceData: [],
            storingPromise: false,
        };
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Sources' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-vendor' }, "Back to vendor")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { style: { width: '100%' } },
                            React.createElement(components_1.Button, { isPrimary: true, href: '/wp-admin/admin.php?page=tokenly-source-store' }, "Register source"))))),
            React.createElement(components_1.Panel, { header: "Registered sources" },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(SourceList_1.SourceList, { sourceList: this.props.pageData.sources }))))));
    }
}
exports["default"] = SourceIndexPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/SourceShowPage.tsx":
/*!*****************************************************!*\
  !*** ./resources/ts/Admin/Pages/SourceShowPage.tsx ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceShowPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
        this.getAssetNames = this.getAssetNames.bind(this);
    }
    getAssetNames() {
        var _a, _b, _c;
        let balances = (_c = (_b = (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.source) === null || _b === void 0 ? void 0 : _b.address) === null || _c === void 0 ? void 0 : _c.balances;
        if (!balances) {
            return;
        }
        let assets = [];
        Object.keys(balances).map((key, index) => {
            assets.push(balances[key].asset);
        });
        assets = assets.join(', ');
        return assets;
    }
    render() {
        var _a;
        return (React.createElement(Page_1.default, { title: 'Source details' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { style: { display: 'inline-block' }, href: '/wp-admin/admin.php?page=tokenly-vendor' }, "Back to vendor")),
            React.createElement(components_1.Panel, { header: this.props.pageData.source.address.label },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { style: { width: '100%', alignItems: 'center' } },
                            React.createElement("div", { style: { flex: 1 } },
                                React.createElement("div", null,
                                    React.createElement("span", null, "Type: "),
                                    React.createElement("strong", null, this.props.pageData.source.type)),
                                React.createElement("div", null,
                                    React.createElement("span", null, "Address: "),
                                    React.createElement("strong", null, this.props.pageData.source.address_id)),
                                React.createElement("div", null,
                                    React.createElement("span", null, "Assets (whitelisted): "),
                                    React.createElement("strong", null, (_a = this.props.pageData.source.assets) !== null && _a !== void 0 ? _a : 'all'))))))),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { justify: "flex-start", style: { width: '100%' } },
                            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, href: `/wp-admin/admin.php?page=tokenly-source-edit&source=${this.props.pageData.source.address_id}` }, "Manage source"),
                            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, href: `/wp-admin/admin.php?page=tokenly-balances-show&address=${this.props.pageData.source.address_id}` }, "View balances")))))));
    }
}
exports["default"] = SourceShowPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/SourceStorePage.tsx":
/*!******************************************************!*\
  !*** ./resources/ts/Admin/Pages/SourceStorePage.tsx ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const SourceStoreForm_1 = __webpack_require__(/*! ../Components/SourceStoreForm */ "./resources/ts/Admin/Components/SourceStoreForm.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class SourceStorePage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            storingSource: false,
            address: null,
        };
        this.onSubmit = this.onSubmit.bind(this);
        this.onAddressChange = this.onAddressChange.bind(this);
    }
    return() {
        window.location = '/wp-admin/admin.php?page=tokenly-source-index';
    }
    onSubmit(promise) {
        this.sourceRepository.store(promise).then((result) => {
            this.return();
        });
    }
    onAddressChange(address) {
        this.setState({ address: address });
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Register source address' },
            React.createElement("div", { style: { marginBottom: '8px' } },
                React.createElement("a", { href: '/wp-admin/admin.php?page=tokenly-source-index' }, "Back to source address list")),
            React.createElement(components_1.Panel, null,
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(SourceStoreForm_1.SourceStoreForm, { onSubmit: this.onSubmit, onChange: this.onAddressChange, onCancel: this.return, saving: this.state.storingSource, style: { marginBottom: '12px' }, addresses: this.props.pageData.addresses }))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.SourceRepositoryInterface),
    __metadata("design:type", Object)
], SourceStorePage.prototype, "sourceRepository", void 0);
exports["default"] = SourceStorePage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/TaxonomyEditPage.tsx":
/*!*******************************************************!*\
  !*** ./resources/ts/Admin/Pages/TaxonomyEditPage.tsx ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const element_1 = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
class TaxonomyEditPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
        //
        };
    }
    render() {
        return (React.createElement(element_1.Fragment, null));
    }
}
exports["default"] = TaxonomyEditPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/TokenMetaEditPage.tsx":
/*!********************************************************!*\
  !*** ./resources/ts/Admin/Pages/TokenMetaEditPage.tsx ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const AttributeRepeater_1 = __webpack_require__(/*! ../Components/AttributeRepeater */ "./resources/ts/Admin/Components/AttributeRepeater.tsx");
const EventBus_1 = __webpack_require__(/*! ./../../EventBus */ "./resources/ts/EventBus.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
const element_1 = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
class TokenMetaEditPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            storingSource: false,
            meta: {},
            postId: null,
        };
        const urlParams = new URLSearchParams(window.location.search);
        const postId = parseInt(urlParams.get('post'));
        this.state.postId = postId;
        this.state.meta = Object.assign(this.state.meta, this.props.pageData.meta);
        this.onAssetUpdated = this.onExtraUpdated.bind(this);
        this.onExtraUpdated = this.onExtraUpdated.bind(this);
        this.onPostUpdate = this.onPostUpdate.bind(this);
    }
    onAssetUpdated(value) {
    }
    onExtraUpdated(newExtra) {
        let newState = Object.assign({}, this.state);
        newState.meta.extra = Object.assign([], newExtra);
        newState.meta.extra = newState.meta.extra.filter(function (attribute) {
            return attribute != null;
        });
        this.setState(Object.assign({}, newState));
        this.onPostUpdate(newState.meta);
    }
    onPostUpdate(newPostData) {
        EventBus_1.default.dispatch('postDataUpdated', newPostData);
    }
    render() {
        var _a, _b;
        return (React.createElement(element_1.Fragment, null,
            React.createElement(components_1.PanelRow, null,
                React.createElement("div", { style: { width: '100%', marginTop: '12px' } },
                    React.createElement(components_1.TextControl, { value: this.state.meta.asset, label: "Asset", help: "Is used for pairing meta with an asset", onChange: (value) => {
                            const state = Object.assign({}, this.state.meta);
                            state.asset = value;
                            this.setState({ meta: state });
                            this.onPostUpdate(state);
                        }, style: { width: '100%', maxWidth: '500px', marginBottom: '8px' } }),
                    React.createElement(AttributeRepeater_1.AttributeRepeater, { label: "Extra attributes", help: "Additional key-value asset meta attributes. They are displayed in the more info sections.", attributes: (_b = (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.meta) === null || _b === void 0 ? void 0 : _b.extra, onUpdate: this.onExtraUpdated })))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.TokenMetaRepositoryInterface),
    __metadata("design:type", Object)
], TokenMetaEditPage.prototype, "tokenMetaRepository", void 0);
exports["default"] = TokenMetaEditPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/VendorPage.tsx":
/*!*************************************************!*\
  !*** ./resources/ts/Admin/Pages/VendorPage.tsx ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const PromiseList_1 = __webpack_require__(/*! ../Components/PromiseList */ "./resources/ts/Admin/Components/PromiseList.tsx");
const PromiseDetailsModal_1 = __webpack_require__(/*! ../Components/PromiseDetailsModal */ "./resources/ts/Admin/Components/PromiseDetailsModal.tsx");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class VendorPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            promiseData: [],
            isPromiseDetailsModalOpen: false,
            storingPromise: false,
            currentPromise: 0,
        };
        this.onDetails = this.onDetails.bind(this);
        this.onDetailsModalRequestClose = this.onDetailsModalRequestClose.bind(this);
    }
    onDetailsModalRequestClose() {
        this.setState({
            isPromiseDetailsModalOpen: false,
        });
    }
    onDetails(index) {
        this.setState({
            currentPromise: index,
            isPromiseDetailsModalOpen: true,
        });
    }
    render() {
        var _a, _b;
        return (React.createElement(Page_1.default, { title: 'Tokenpass Vendor' },
            this.state.isPromiseDetailsModalOpen &&
                React.createElement(PromiseDetailsModal_1.PromiseDetailsModal, { onRequestClose: this.onDetailsModalRequestClose, promise: this.props.pageData.promises[this.state.currentPromise] }),
            React.createElement(components_1.Panel, { header: "Vendor actions" },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.Flex, { justify: "flex-start" },
                            React.createElement(components_1.Button, { isPrimary: true, isLarge: true, href: '/wp-admin/admin.php?page=tokenly-promise-store', style: { marginRight: '8px' } }, "Create a promise"),
                            React.createElement(components_1.Button, { isSecondary: true, isLarge: true, href: '/wp-admin/admin.php?page=tokenly-source-index' }, "Manage source addresses"))))),
            React.createElement(components_1.Panel, { header: "Current promises" },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null, ((_b = (_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.promises) === null || _b === void 0 ? void 0 : _b.length) > 0
                        ? React.createElement(PromiseList_1.PromiseList, { promises: this.props.pageData.promises, onDetails: this.onDetails, sources: this.props.pageData.sources })
                        : React.createElement("div", { style: { opacity: 0.5 } }, "There are no registered promises"))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.PromiseRepositoryInterface),
    __metadata("design:type", Object)
], VendorPage.prototype, "promiseRepository", void 0);
exports["default"] = VendorPage;


/***/ }),

/***/ "./resources/ts/Admin/Pages/WhitelistPage.tsx":
/*!****************************************************!*\
  !*** ./resources/ts/Admin/Pages/WhitelistPage.tsx ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const Page_1 = __webpack_require__(/*! ./Page */ "./resources/ts/Admin/Pages/Page.tsx");
const Whitelist_1 = __webpack_require__(/*! ../Components/Whitelist */ "./resources/ts/Admin/Components/Whitelist.tsx");
const SavePanel_1 = __webpack_require__(/*! ../Components/SavePanel */ "./resources/ts/Admin/Components/SavePanel.tsx");
const react_1 = __webpack_require__(/*! react */ "react");
const Types_1 = __webpack_require__(/*! ../../Types */ "./resources/ts/Types.ts");
const components_1 = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
class WhitelistPage extends react_1.Component {
    constructor(props) {
        super(props);
        this.state = {
            whitelistData: {
                enabled: false,
                items: [
                    {
                        address: '',
                        index: '',
                    },
                ],
            },
            saving: false,
        };
        this.onSave = this.onSave.bind(this);
        this.onWhitelistChange = this.onWhitelistChange.bind(this);
        this.setUseWhitelist = this.setUseWhitelist.bind(this);
        this.state.whitelistData = Object.assign(this.state.whitelistData, this.props.pageData.whitelist);
    }
    onWhitelistChange(newWhitelist) {
        let newState = Object.assign({}, this.state);
        newState.whitelistData.items = Object.assign([], newWhitelist);
        newState.whitelistData.items = newState.whitelistData.items.filter(function (whitelistItem) {
            return whitelistItem != null;
        });
        this.setState(Object.assign({}, newState));
    }
    setUseWhitelist(value) {
        let newState = Object.assign({}, this.state);
        newState.whitelistData.enabled = value;
        this.setState(newState);
    }
    onSave() {
        this.setState({ saving: true });
        this.whitelistSettingsRepository.update(this.state.whitelistData).then((result) => {
            this.setState({ saving: false });
        }).catch((error) => {
            console.log(error);
        });
    }
    render() {
        return (React.createElement(Page_1.default, { title: 'Token Whitelist' },
            React.createElement(components_1.Panel, { header: "Token Whitelist Settings" },
                React.createElement(components_1.PanelBody, null,
                    React.createElement(components_1.PanelRow, null,
                        React.createElement("p", null, "Whitelist allows to control which assets to display on the Inventory screen.")),
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(components_1.ToggleControl, { label: "Use whitelist", help: this.state.whitelistData.enabled
                                ? 'Whitelist enabled.'
                                : 'Whitelist disabled.', checked: this.state.whitelistData.enabled, onChange: (value) => {
                                this.setUseWhitelist(value);
                            } })),
                    this.state.whitelistData.enabled == true &&
                        React.createElement(components_1.PanelRow, null,
                            React.createElement("div", { style: { marginBottom: '12px' } },
                                React.createElement("h4", null, "Token Whitelist Editor"),
                                React.createElement(Whitelist_1.Whitelist, { onUpdate: this.onWhitelistChange, whitelist: this.state.whitelistData.items }))),
                    React.createElement(components_1.PanelRow, null,
                        React.createElement(SavePanel_1.SavePanel, { saving: this.state.saving, onClick: this.onSave }))))));
    }
}
__decorate([
    (0, inversify_react_1.resolve)(Types_1.TYPES.WhitelistSettingsRepositoryInterface),
    __metadata("design:type", Object)
], WhitelistPage.prototype, "whitelistSettingsRepository", void 0);
exports["default"] = WhitelistPage;


/***/ }),

/***/ "./resources/ts/App.tsx":
/*!******************************!*\
  !*** ./resources/ts/App.tsx ***!
  \******************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const Inversify_config_1 = __webpack_require__(/*! ./Inversify.config */ "./resources/ts/Inversify.config.ts");
__webpack_require__(/*! ../../../../../../../../../resources/scss/Main.scss */ "./resources/scss/Main.scss");
const Types_1 = __webpack_require__(/*! ./Types */ "./resources/ts/Types.ts");
class App {
    constructor() {
        this.container = Inversify_config_1.container;
        this.registerProviders();
    }
    get providers() {
        return [
            Types_1.TYPES.ComponentServiceProviderInterface,
        ];
    }
    registerProviders() {
        this.providers.forEach(provider => {
            const providerInstance = this.container.get(provider);
            providerInstance.register();
        });
    }
}
exports["default"] = App;


/***/ }),

/***/ "./resources/ts/Components/Component.ts":
/*!**********************************************!*\
  !*** ./resources/ts/Components/Component.ts ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.Component = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
let Component = class Component {
    constructor() {
        //
    }
    register(selector) {
        //
    }
};
Component = __decorate([
    (0, inversify_1.injectable)(),
    __metadata("design:paramtypes", [])
], Component);
exports.Component = Component;


/***/ }),

/***/ "./resources/ts/Components/LoginButtonComponent.ts":
/*!*********************************************************!*\
  !*** ./resources/ts/Components/LoginButtonComponent.ts ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.LoginButtonComponent = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
const Component_1 = __webpack_require__(/*! ./Component */ "./resources/ts/Components/Component.ts");
let LoginButtonComponent = class LoginButtonComponent extends Component_1.Component {
    constructor(authService) {
        super();
        this.authService = authService;
    }
    register(selector) {
        this.element.addEventListener('click', () => {
            this.element.classList.add('loading');
        });
    }
};
LoginButtonComponent = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AuthServiceInterface)),
    __metadata("design:paramtypes", [Object])
], LoginButtonComponent);
exports.LoginButtonComponent = LoginButtonComponent;


/***/ }),

/***/ "./resources/ts/Components/TokenItemCardComponent.ts":
/*!***********************************************************!*\
  !*** ./resources/ts/Components/TokenItemCardComponent.ts ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.TokenItemCardComponent = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Component_1 = __webpack_require__(/*! ./Component */ "./resources/ts/Components/Component.ts");
let TokenItemCardComponent = class TokenItemCardComponent extends Component_1.Component {
    constructor() {
        super();
    }
    register(selector) {
        const extraButton = this.element.querySelector('.extra-button');
        if (extraButton) {
            extraButton.addEventListener('click', () => {
                this.element.classList.add('extra-shown');
            });
        }
        const closeButton = this.element.querySelector('.close-button');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                this.element.classList.remove('extra-shown');
            });
        }
    }
};
TokenItemCardComponent = __decorate([
    (0, inversify_1.injectable)(),
    __metadata("design:paramtypes", [])
], TokenItemCardComponent);
exports.TokenItemCardComponent = TokenItemCardComponent;


/***/ }),

/***/ "./resources/ts/EventBus.ts":
/*!**********************************!*\
  !*** ./resources/ts/EventBus.ts ***!
  \**********************************/
/***/ (function(__unused_webpack_module, exports) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const eventBus = {
    on(event, callback) {
        document.addEventListener(event, (e) => callback(e.detail));
    },
    dispatch(event, data) {
        document.dispatchEvent(new CustomEvent(event, { detail: data }));
    },
    remove(event, callback) {
        document.removeEventListener(event, callback);
    },
};
exports["default"] = eventBus;


/***/ }),

/***/ "./resources/ts/Inversify.config.ts":
/*!******************************************!*\
  !*** ./resources/ts/Inversify.config.ts ***!
  \******************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.container = void 0;
__webpack_require__(/*! reflect-metadata */ "./node_modules/reflect-metadata/Reflect.js");
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./Types */ "./resources/ts/Types.ts");
// Implementations
// Implementations - Services
const AuthService_1 = __webpack_require__(/*! ./Services/AuthService */ "./resources/ts/Services/AuthService.ts");
const AdminApiService_1 = __webpack_require__(/*! ./Services/AdminApiService */ "./resources/ts/Services/AdminApiService.ts");
// Implementations - Repositories
const CreditGroupRepository_1 = __webpack_require__(/*! ./Repositories/CreditGroupRepository */ "./resources/ts/Repositories/CreditGroupRepository.ts");
const CreditTransactionRepository_1 = __webpack_require__(/*! ./Repositories/CreditTransactionRepository */ "./resources/ts/Repositories/CreditTransactionRepository.ts");
const PromiseRepository_1 = __webpack_require__(/*! ./Repositories/PromiseRepository */ "./resources/ts/Repositories/PromiseRepository.ts");
const UserRepository_1 = __webpack_require__(/*! ./Repositories/UserRepository */ "./resources/ts/Repositories/UserRepository.ts");
const SourceRepository_1 = __webpack_require__(/*! ./Repositories/SourceRepository */ "./resources/ts/Repositories/SourceRepository.ts");
const TokenMetaRepository_1 = __webpack_require__(/*! ./Repositories/TokenMetaRepository */ "./resources/ts/Repositories/TokenMetaRepository.ts");
// Implementations - Repositories - Settings
const IntegrationSettingsRepository_1 = __webpack_require__(/*! ./Repositories/Settings/IntegrationSettingsRepository */ "./resources/ts/Repositories/Settings/IntegrationSettingsRepository.ts");
const TcaSettingsRepository_1 = __webpack_require__(/*! ./Repositories/Settings/TcaSettingsRepository */ "./resources/ts/Repositories/Settings/TcaSettingsRepository.ts");
const OauthSettingsRepository_1 = __webpack_require__(/*! ./Repositories/Settings/OauthSettingsRepository */ "./resources/ts/Repositories/Settings/OauthSettingsRepository.ts");
const WhitelistSettingsRepository_1 = __webpack_require__(/*! ./Repositories/Settings/WhitelistSettingsRepository */ "./resources/ts/Repositories/Settings/WhitelistSettingsRepository.ts");
// Implementations - Service providers
const ComponentServiceProvider_1 = __webpack_require__(/*! ./Providers/ComponentServiceProvider */ "./resources/ts/Providers/ComponentServiceProvider.ts");
// Implementations - Components
const LoginButtonComponent_1 = __webpack_require__(/*! ./Components/LoginButtonComponent */ "./resources/ts/Components/LoginButtonComponent.ts");
const TokenItemCardComponent_1 = __webpack_require__(/*! ./Components/TokenItemCardComponent */ "./resources/ts/Components/TokenItemCardComponent.ts");
const container = new inversify_1.Container();
exports.container = container;
// Services - Application
container.bind(Types_1.TYPES.AuthServiceInterface).to(AuthService_1.AuthService);
container.bind(Types_1.TYPES.AdminApiServiceInterface).to(AdminApiService_1.AdminApiService);
// Repositories
container.bind(Types_1.TYPES.CreditGroupRepositoryInterface).to(CreditGroupRepository_1.CreditGroupRepository);
container.bind(Types_1.TYPES.CreditTransactionRepositoryInterface).to(CreditTransactionRepository_1.CreditTransactionRepository);
container.bind(Types_1.TYPES.PromiseRepositoryInterface).to(PromiseRepository_1.PromiseRepository);
container.bind(Types_1.TYPES.SourceRepositoryInterface).to(SourceRepository_1.SourceRepository);
container.bind(Types_1.TYPES.TokenMetaRepositoryInterface).to(TokenMetaRepository_1.TokenMetaRepository);
container.bind(Types_1.TYPES.UserRepositoryInterface).to(UserRepository_1.UserRepository);
// Repositories - Settings
container.bind(Types_1.TYPES.WhitelistSettingsRepositoryInterface).to(WhitelistSettingsRepository_1.WhitelistSettingsRepository);
container.bind(Types_1.TYPES.IntegrationSettingsRepositoryInterface).to(IntegrationSettingsRepository_1.IntegrationSettingsRepository);
container.bind(Types_1.TYPES.OauthSettingsRepositoryInterface).to(OauthSettingsRepository_1.OauthSettingsRepository);
container.bind(Types_1.TYPES.TcaSettingsRepositoryInterface).to(TcaSettingsRepository_1.TcaSettingsRepository);
// Components
container.bind(Types_1.TYPES.ComponentServiceProviderInterface).to(ComponentServiceProvider_1.ComponentServiceProvider);
container.bind(Types_1.TYPES.LoginButtonComponentInterface).to(LoginButtonComponent_1.LoginButtonComponent);
container.bind(Types_1.TYPES.TokenItemCardComponentInterface).to(TokenItemCardComponent_1.TokenItemCardComponent);
container.bind('Component').to(LoginButtonComponent_1.LoginButtonComponent).whenTargetNamed('loginButtonComponent');
container.bind('Component').to(TokenItemCardComponent_1.TokenItemCardComponent).whenTargetNamed('tokenItemCardComponent');
container.bind('Factory<Component>')
    .toAutoNamedFactory('Component');


/***/ }),

/***/ "./resources/ts/Layouts/AppLayout.tsx":
/*!********************************************!*\
  !*** ./resources/ts/Layouts/AppLayout.tsx ***!
  \********************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
const React = __webpack_require__(/*! react */ "react");
const react_1 = __webpack_require__(/*! react */ "react");
const ConfirmModal_1 = __webpack_require__(/*! ../Admin/Components/ConfirmModal */ "./resources/ts/Admin/Components/ConfirmModal.tsx");
const TcaRuleEditor_1 = __webpack_require__(/*! ./../Admin/Components/TcaRuleEditor */ "./resources/ts/Admin/Components/TcaRuleEditor.tsx");
const EventBus_1 = __webpack_require__(/*! ../EventBus */ "./resources/ts/EventBus.ts");
const element_1 = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
class AppLayout extends react_1.Component {
    constructor(props) {
        var _a, _b;
        super(props);
        this.state = {
            confirmModalData: null,
            confirmModalShow: false,
            postData: {},
            tcaRules: []
        };
        this.onConfirmModalShow = this.onConfirmModalShow.bind(this);
        this.onConfirmModalRequestClose = this.onConfirmModalRequestClose.bind(this);
        this.onConfirmModalChoice = this.onConfirmModalChoice.bind(this);
        this.onPostDataUpdated = this.onPostDataUpdated.bind(this);
        this.onTcaUpdate = this.onTcaUpdate.bind(this);
        console.log(this.props.pageData);
        this.state.tcaRules = Object.assign({}, (_b = (_a = this.props) === null || _a === void 0 ? void 0 : _a.pageData) === null || _b === void 0 ? void 0 : _b.tca_rules);
        this.state.postData.tca_rules = this.state.tcaRules;
    }
    onConfirmModalRequestClose() {
        this.setState({
            confirmModalData: null,
            confirmModalShow: false,
        });
    }
    onConfirmModalChoice(choice) {
        var _a, _b;
        EventBus_1.default.dispatch('confirmModalChoice', {
            key: (_b = (_a = this.state) === null || _a === void 0 ? void 0 : _a.confirmModalData) === null || _b === void 0 ? void 0 : _b.key,
            choice: choice,
        });
        this.onConfirmModalRequestClose();
    }
    onConfirmModalShow(confirmModalData) {
        this.setState({
            confirmModalData: confirmModalData,
            confirmModalShow: true,
        });
    }
    componentDidMount() {
        EventBus_1.default.on('confirmModalShow', this.onConfirmModalShow);
        EventBus_1.default.on('postDataUpdated', this.onPostDataUpdated);
    }
    componentWillUnmount() {
        EventBus_1.default.remove('confirmModalShow', this.onConfirmModalShow);
    }
    onPostDataUpdated(newData) {
        let state = Object.assign({}, this.state.postData);
        state = Object.assign(state, newData);
        this.setState({ postData: state });
    }
    onTcaUpdate(rules) {
        this.onPostDataUpdated({
            tca_rules: rules,
        });
    }
    render() {
        var _a;
        return (React.createElement(element_1.Fragment, null,
            this.props.children,
            this.state.confirmModalShow == true &&
                React.createElement(ConfirmModal_1.ConfirmModal, { key: this.state.confirmModalData.key, title: this.state.confirmModalData.title, subtitle: this.state.confirmModalData.subtitle, onRequestClose: this.onConfirmModalRequestClose, onChoice: this.onConfirmModalChoice }),
            ((_a = this.props.pageData) === null || _a === void 0 ? void 0 : _a.tca_enabled) == true &&
                React.createElement(TcaRuleEditor_1.default, { rules: this.state.tcaRules, onUpdate: this.onTcaUpdate }),
            React.createElement("input", { type: "hidden", name: "tokenly_data", value: JSON.stringify(this.state.postData) })));
    }
}
exports["default"] = AppLayout;


/***/ }),

/***/ "./resources/ts/Providers/ComponentServiceProvider.ts":
/*!************************************************************!*\
  !*** ./resources/ts/Providers/ComponentServiceProvider.ts ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.ComponentServiceProvider = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const ServiceProvider_1 = __webpack_require__(/*! ./ServiceProvider */ "./resources/ts/Providers/ServiceProvider.ts");
let ComponentServiceProvider = class ComponentServiceProvider extends ServiceProvider_1.ServiceProvider {
    constructor(componentFactory) {
        super();
        this.componentFactory = componentFactory;
    }
    get components() {
        return [
            {
                name: 'loginButtonComponent',
                selector: 'a.tokenpass-login',
            },
            {
                name: 'tokenItemCardComponent',
                selector: '.component-card-token-item',
            }
        ];
    }
    register() {
        this.components.forEach((component) => {
            const elements = document.querySelectorAll(component.selector);
            elements.forEach((element) => {
                const componentInstance = this.componentFactory(component.name);
                componentInstance.element = element;
                componentInstance.register();
            });
        });
    }
};
ComponentServiceProvider = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)("Factory<Component>")),
    __metadata("design:paramtypes", [Function])
], ComponentServiceProvider);
exports.ComponentServiceProvider = ComponentServiceProvider;


/***/ }),

/***/ "./resources/ts/Providers/ServiceProvider.ts":
/*!***************************************************!*\
  !*** ./resources/ts/Providers/ServiceProvider.ts ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.ServiceProvider = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
let ServiceProvider = class ServiceProvider {
    constructor() {
        //
    }
    register() {
        //
    }
};
ServiceProvider = __decorate([
    (0, inversify_1.injectable)(),
    __metadata("design:paramtypes", [])
], ServiceProvider);
exports.ServiceProvider = ServiceProvider;


/***/ }),

/***/ "./resources/ts/Repositories/CreditGroupRepository.ts":
/*!************************************************************!*\
  !*** ./resources/ts/Repositories/CreditGroupRepository.ts ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditGroupRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
let CreditGroupRepository = class CreditGroupRepository {
    constructor(adminApiService) {
        this.adminApiService = adminApiService;
    }
    index() {
        return new Promise((resolve, reject) => {
            this.adminApiService.creditGroupIndex().then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    store(params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.creditGroupStore(params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    update(params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.creditGroupUpdate(params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
CreditGroupRepository = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AdminApiServiceInterface)),
    __metadata("design:paramtypes", [Object])
], CreditGroupRepository);
exports.CreditGroupRepository = CreditGroupRepository;


/***/ }),

/***/ "./resources/ts/Repositories/CreditTransactionRepository.ts":
/*!******************************************************************!*\
  !*** ./resources/ts/Repositories/CreditTransactionRepository.ts ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CreditTransactionRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
let CreditTransactionRepository = class CreditTransactionRepository {
    constructor(adminApiService) {
        this.adminApiService = adminApiService;
    }
    index() {
        return new Promise((resolve, reject) => {
            this.adminApiService.creditTransactionIndex().then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    store(params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.creditTransactionStore(params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
CreditTransactionRepository = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AdminApiServiceInterface)),
    __metadata("design:paramtypes", [Object])
], CreditTransactionRepository);
exports.CreditTransactionRepository = CreditTransactionRepository;


/***/ }),

/***/ "./resources/ts/Repositories/PromiseRepository.ts":
/*!********************************************************!*\
  !*** ./resources/ts/Repositories/PromiseRepository.ts ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.PromiseRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
let PromiseRepository = class PromiseRepository {
    constructor(adminApiService) {
        this.adminApiService = adminApiService;
    }
    index() {
        return new Promise((resolve, reject) => {
            this.adminApiService.promiseIndex().then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    store(params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.promiseStore(params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    update(promiseId, params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.promiseUpdate(promiseId, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    destroy(promiseId) {
        return new Promise((resolve, reject) => {
            this.adminApiService.promiseDestroy(promiseId).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
PromiseRepository = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AdminApiServiceInterface)),
    __metadata("design:paramtypes", [Object])
], PromiseRepository);
exports.PromiseRepository = PromiseRepository;


/***/ }),

/***/ "./resources/ts/Repositories/Settings/IntegrationSettingsRepository.ts":
/*!*****************************************************************************!*\
  !*** ./resources/ts/Repositories/Settings/IntegrationSettingsRepository.ts ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.IntegrationSettingsRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const SettingsRepository_1 = __webpack_require__(/*! ./../SettingsRepository */ "./resources/ts/Repositories/SettingsRepository.ts");
let IntegrationSettingsRepository = class IntegrationSettingsRepository extends SettingsRepository_1.SettingsRepository {
    constructor() {
        super(...arguments);
        this.settingsType = 'integration';
    }
};
IntegrationSettingsRepository = __decorate([
    (0, inversify_1.injectable)()
], IntegrationSettingsRepository);
exports.IntegrationSettingsRepository = IntegrationSettingsRepository;


/***/ }),

/***/ "./resources/ts/Repositories/Settings/OauthSettingsRepository.ts":
/*!***********************************************************************!*\
  !*** ./resources/ts/Repositories/Settings/OauthSettingsRepository.ts ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.OauthSettingsRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const SettingsRepository_1 = __webpack_require__(/*! ./../SettingsRepository */ "./resources/ts/Repositories/SettingsRepository.ts");
let OauthSettingsRepository = class OauthSettingsRepository extends SettingsRepository_1.SettingsRepository {
    constructor() {
        super(...arguments);
        this.settingsType = 'oauth';
    }
};
OauthSettingsRepository = __decorate([
    (0, inversify_1.injectable)()
], OauthSettingsRepository);
exports.OauthSettingsRepository = OauthSettingsRepository;


/***/ }),

/***/ "./resources/ts/Repositories/Settings/TcaSettingsRepository.ts":
/*!*********************************************************************!*\
  !*** ./resources/ts/Repositories/Settings/TcaSettingsRepository.ts ***!
  \*********************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.TcaSettingsRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const SettingsRepository_1 = __webpack_require__(/*! ./../SettingsRepository */ "./resources/ts/Repositories/SettingsRepository.ts");
let TcaSettingsRepository = class TcaSettingsRepository extends SettingsRepository_1.SettingsRepository {
    constructor() {
        super(...arguments);
        this.settingsType = 'tca';
    }
};
TcaSettingsRepository = __decorate([
    (0, inversify_1.injectable)()
], TcaSettingsRepository);
exports.TcaSettingsRepository = TcaSettingsRepository;


/***/ }),

/***/ "./resources/ts/Repositories/Settings/WhitelistSettingsRepository.ts":
/*!***************************************************************************!*\
  !*** ./resources/ts/Repositories/Settings/WhitelistSettingsRepository.ts ***!
  \***************************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.WhitelistSettingsRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const SettingsRepository_1 = __webpack_require__(/*! ./../SettingsRepository */ "./resources/ts/Repositories/SettingsRepository.ts");
let WhitelistSettingsRepository = class WhitelistSettingsRepository extends SettingsRepository_1.SettingsRepository {
    constructor() {
        super(...arguments);
        this.settingsType = 'whitelist';
    }
};
WhitelistSettingsRepository = __decorate([
    (0, inversify_1.injectable)()
], WhitelistSettingsRepository);
exports.WhitelistSettingsRepository = WhitelistSettingsRepository;


/***/ }),

/***/ "./resources/ts/Repositories/SettingsRepository.ts":
/*!*********************************************************!*\
  !*** ./resources/ts/Repositories/SettingsRepository.ts ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.SettingsRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
let SettingsRepository = class SettingsRepository {
    constructor(adminApiService) {
        this.adminApiService = adminApiService;
    }
    show() {
        return new Promise((resolve, reject) => {
            this.adminApiService.settingsShow(this.settingsType).then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    update(params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.settingsUpdate(this.settingsType, params).then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
SettingsRepository = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AdminApiServiceInterface)),
    __metadata("design:paramtypes", [Object])
], SettingsRepository);
exports.SettingsRepository = SettingsRepository;


/***/ }),

/***/ "./resources/ts/Repositories/SourceRepository.ts":
/*!*******************************************************!*\
  !*** ./resources/ts/Repositories/SourceRepository.ts ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.SourceRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
let SourceRepository = class SourceRepository {
    constructor(adminApiService) {
        this.adminApiService = adminApiService;
    }
    index() {
        return new Promise((resolve, reject) => {
            this.adminApiService.sourceIndex().then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    store(params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.sourceStore(params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    update(address, params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.sourceUpdate(address, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    destroy(address) {
        return new Promise((resolve, reject) => {
            this.adminApiService.sourceDestroy(address).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
SourceRepository = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AdminApiServiceInterface)),
    __metadata("design:paramtypes", [Object])
], SourceRepository);
exports.SourceRepository = SourceRepository;


/***/ }),

/***/ "./resources/ts/Repositories/TokenMetaRepository.ts":
/*!**********************************************************!*\
  !*** ./resources/ts/Repositories/TokenMetaRepository.ts ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.TokenMetaRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
let TokenMetaRepository = class TokenMetaRepository {
    constructor(adminApiService) {
        this.adminApiService = adminApiService;
    }
    show(postId) {
        return new Promise((resolve, reject) => {
            this.adminApiService.tokenMetaShow(postId).then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    update(postId, params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.tokenMetaUpdate(postId, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
TokenMetaRepository = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AdminApiServiceInterface)),
    __metadata("design:paramtypes", [Object])
], TokenMetaRepository);
exports.TokenMetaRepository = TokenMetaRepository;


/***/ }),

/***/ "./resources/ts/Repositories/UserRepository.ts":
/*!*****************************************************!*\
  !*** ./resources/ts/Repositories/UserRepository.ts ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.UserRepository = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
const Types_1 = __webpack_require__(/*! ./../Types */ "./resources/ts/Types.ts");
let UserRepository = class UserRepository {
    constructor(adminApiService) {
        this.adminApiService = adminApiService;
    }
    index(params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.userIndex(params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    show(userId, params) {
        return new Promise((resolve, reject) => {
            this.adminApiService.userShow(userId, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
UserRepository = __decorate([
    (0, inversify_1.injectable)(),
    __param(0, (0, inversify_1.inject)(Types_1.TYPES.AdminApiServiceInterface)),
    __metadata("design:paramtypes", [Object])
], UserRepository);
exports.UserRepository = UserRepository;


/***/ }),

/***/ "./resources/ts/Services/AdminApiService.ts":
/*!**************************************************!*\
  !*** ./resources/ts/Services/AdminApiService.ts ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.AdminApiService = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
let AdminApiService = class AdminApiService {
    constructor() {
        this.namespace = '/wp-json/tokenly/v1';
    }
    get headers() {
        return {
            'Content-type': 'application/json; charset=UTF-8',
            'X-WP-Nonce': wpApiSettings.nonce,
        };
    }
    settingsShow(type) {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', `/settings/${type}`).then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    settingsUpdate(type, params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('PUT', `/settings/${type}`, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    creditGroupIndex() {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', '/credit-group').then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    creditGroupStore(params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('POST', '/credit-group', params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    creditGroupUpdate(params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('PUT', '/credit-group/', params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    creditTransactionIndex() {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', '/credit-transaction').then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    creditTransactionStore(params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('POST', '/credit-transaction', params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    sourceIndex() {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', '/source').then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    sourceStore(params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('POST', '/source', params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    sourceUpdate(address, params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('PUT', '/source/' + address, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    sourceDestroy(address) {
        return new Promise((resolve, reject) => {
            this.makeRequest('DELETE', '/source/' + address).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    promiseIndex() {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', '/promise').then((result) => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    promiseStore(params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('POST', '/promise', params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    promiseUpdate(promiseId, params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('PUT', `/promise/${promiseId}`, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    promiseDestroy(promiseId) {
        return new Promise((resolve, reject) => {
            this.makeRequest('DELETE', `/promise/${promiseId}`).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    tokenMetaShow(postId) {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', `/token-meta/${postId}`).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    tokenMetaUpdate(postId, params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('PUT', `/token-meta/${postId}`, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    userIndex(params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', '/user', params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    userShow(userId, params) {
        return new Promise((resolve, reject) => {
            this.makeRequest('GET', `/user/${userId}`, params).then(result => {
                resolve(result);
            }).catch(error => {
                reject(error);
            });
        });
    }
    makeRequest(method = '', route = '', args = {}) {
        return new Promise((resolve, reject) => {
            const params = {
                method: method,
                headers: this.headers,
            };
            const withBody = ['POST', 'PUT', 'UPDATE'];
            let url = `${this.namespace}${route}`;
            if (withBody.includes(method)) {
                params.body = JSON.stringify(args);
            }
            else {
                const queryParams = new URLSearchParams(args);
                url = `${url}? + ${queryParams}`;
            }
            fetch(url, params)
                .then(response => response.json())
                .then((data) => {
                resolve(data);
            })
                .catch(err => reject(err));
        });
    }
};
AdminApiService = __decorate([
    (0, inversify_1.injectable)()
], AdminApiService);
exports.AdminApiService = AdminApiService;


/***/ }),

/***/ "./resources/ts/Services/AuthService.ts":
/*!**********************************************!*\
  !*** ./resources/ts/Services/AuthService.ts ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.AuthService = void 0;
const inversify_1 = __webpack_require__(/*! inversify */ "./node_modules/inversify/es/inversify.js");
let AuthService = class AuthService {
    constructor() {
        this.namespace = '/wp-json/tokenly/v1/';
        //
    }
    get headers() {
        return {
            'Content-type': 'application/json; charset=UTF-8',
            'X-WP-Nonce': wpApiSettings.nonce,
        };
    }
    getStatus() {
        return new Promise((resolve, reject) => {
            const params = {
                method: 'GET',
                headers: this.headers,
            };
            const url = this.namespace + 'authorize';
            fetch(url, params)
                .then(response => response.json())
                .then((data) => {
                resolve(data);
            })
                .catch(err => reject(err));
        });
    }
    connect() {
        return new Promise((resolve, reject) => {
            const params = {
                method: 'POST',
                headers: this.headers,
            };
            const url = this.namespace + 'authorize';
            fetch(url, params)
                .then(response => response.json())
                .then(data => {
                var _a;
                const redirectUrl = (_a = data.url) !== null && _a !== void 0 ? _a : null;
                if (redirectUrl) {
                    window.location = redirectUrl;
                }
            })
                .catch(err => reject(err));
        });
    }
    disconnect() {
        return new Promise((resolve, reject) => {
            const params = {
                method: 'DELETE',
                headers: this.headers,
            };
            const url = this.namespace + 'authorize';
            fetch(url, params)
                .then(response => response.json())
                .then(data => {
                window.location.reload();
            })
                .catch(err => reject(err));
        });
    }
};
AuthService = __decorate([
    (0, inversify_1.injectable)(),
    __metadata("design:paramtypes", [])
], AuthService);
exports.AuthService = AuthService;


/***/ }),

/***/ "./resources/ts/Types.ts":
/*!*******************************!*\
  !*** ./resources/ts/Types.ts ***!
  \*******************************/
/***/ (function(__unused_webpack_module, exports) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.TYPES = void 0;
const TYPES = {
    // Services
    AuthServiceInterface: Symbol.for('AuthServiceInterface'),
    AdminApiServiceInterface: Symbol.for('AdminApiServiceInterface'),
    // Repositories
    PromiseRepositoryInterface: Symbol.for('PromiseRepositoryInterface'),
    CreditGroupRepositoryInterface: Symbol.for('CreditGroupRepositoryInterface'),
    CreditTransactionRepositoryInterface: Symbol.for('CreditTransactionRepositoryInterface'),
    SourceRepositoryInterface: Symbol.for('SourceRepositoryInterface'),
    TokenMetaRepositoryInterface: Symbol.for('TokenMetaRepositoryInterface'),
    UserRepositoryInterface: Symbol.for('UserRepositoryInterface'),
    // Repositories - Settings
    OauthSettingsRepositoryInterface: Symbol.for('OauthSettingsRepositoryInterface'),
    IntegrationSettingsRepositoryInterface: Symbol.for('IntegrationSettingsRepositoryInterface'),
    TcaSettingsRepositoryInterface: Symbol.for('TcaSettingsRepositoryInterface'),
    WhitelistSettingsRepositoryInterface: Symbol.for('WhitelistSettingsRepositoryInterface'),
    // Service providers
    ComponentServiceProviderInterface: Symbol.for('ComponentServiceProviderInterface'),
    // Components
    LoginButtonComponentInterface: Symbol.for('LoginButtonComponentInterface'),
    TokenItemCardComponentInterface: Symbol.for('TokenItemCardComponentInterface'),
};
exports.TYPES = TYPES;


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
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
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
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
/******/ 	/* webpack/runtime/global */
/******/ 	!function() {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
var exports = __webpack_exports__;
/*!********************************!*\
  !*** ./resources/ts/Admin.tsx ***!
  \********************************/

Object.defineProperty(exports, "__esModule", ({ value: true }));
const Inversify_config_1 = __webpack_require__(/*! ./Inversify.config */ "./resources/ts/Inversify.config.ts");
__webpack_require__(/*! ./../scss/Admin.scss */ "./resources/scss/Admin.scss");
const inversify_react_1 = __webpack_require__(/*! inversify-react */ "./node_modules/inversify-react/dist/index.js");
const React = __webpack_require__(/*! react */ "react");
const App_1 = __webpack_require__(/*! ./App */ "./resources/ts/App.tsx");
const AppLayout_1 = __webpack_require__(/*! ./Layouts/AppLayout */ "./resources/ts/Layouts/AppLayout.tsx");
const SettingsPage_1 = __webpack_require__(/*! ./Admin/Pages/SettingsPage */ "./resources/ts/Admin/Pages/SettingsPage.tsx");
const VendorPage_1 = __webpack_require__(/*! ./Admin/Pages/VendorPage */ "./resources/ts/Admin/Pages/VendorPage.tsx");
const BalancesShowPage_1 = __webpack_require__(/*! ./Admin/Pages/BalancesShowPage */ "./resources/ts/Admin/Pages/BalancesShowPage.tsx");
const ConnectionPage_1 = __webpack_require__(/*! ./Admin/Pages/ConnectionPage */ "./resources/ts/Admin/Pages/ConnectionPage.tsx");
const WhitelistPage_1 = __webpack_require__(/*! ./Admin/Pages/WhitelistPage */ "./resources/ts/Admin/Pages/WhitelistPage.tsx");
const PromiseShowPage_1 = __webpack_require__(/*! ./Admin/Pages/PromiseShowPage */ "./resources/ts/Admin/Pages/PromiseShowPage.tsx");
const PromiseStorePage_1 = __webpack_require__(/*! ./Admin/Pages/PromiseStorePage */ "./resources/ts/Admin/Pages/PromiseStorePage.tsx");
const PromiseEditPage_1 = __webpack_require__(/*! ./Admin/Pages/PromiseEditPage */ "./resources/ts/Admin/Pages/PromiseEditPage.tsx");
const CreditGroupIndexPage_1 = __webpack_require__(/*! ./Admin/Pages/CreditGroupIndexPage */ "./resources/ts/Admin/Pages/CreditGroupIndexPage.tsx");
const CreditGroupShowPage_1 = __webpack_require__(/*! ./Admin/Pages/CreditGroupShowPage */ "./resources/ts/Admin/Pages/CreditGroupShowPage.tsx");
const CreditGroupStorePage_1 = __webpack_require__(/*! ./Admin/Pages/CreditGroupStorePage */ "./resources/ts/Admin/Pages/CreditGroupStorePage.tsx");
const CreditGroupEditPage_1 = __webpack_require__(/*! ./Admin/Pages/CreditGroupEditPage */ "./resources/ts/Admin/Pages/CreditGroupEditPage.tsx");
const CreditTransactionIndexPage_1 = __webpack_require__(/*! ./Admin/Pages/CreditTransactionIndexPage */ "./resources/ts/Admin/Pages/CreditTransactionIndexPage.tsx");
const CreditTransactionStorePage_1 = __webpack_require__(/*! ./Admin/Pages/CreditTransactionStorePage */ "./resources/ts/Admin/Pages/CreditTransactionStorePage.tsx");
const SourceIndexPage_1 = __webpack_require__(/*! ./Admin/Pages/SourceIndexPage */ "./resources/ts/Admin/Pages/SourceIndexPage.tsx");
const SourceShowPage_1 = __webpack_require__(/*! ./Admin/Pages/SourceShowPage */ "./resources/ts/Admin/Pages/SourceShowPage.tsx");
const SourceStorePage_1 = __webpack_require__(/*! ./Admin/Pages/SourceStorePage */ "./resources/ts/Admin/Pages/SourceStorePage.tsx");
const SourceEditPage_1 = __webpack_require__(/*! ./Admin/Pages/SourceEditPage */ "./resources/ts/Admin/Pages/SourceEditPage.tsx");
const DashboardPage_1 = __webpack_require__(/*! ./Admin/Pages/DashboardPage */ "./resources/ts/Admin/Pages/DashboardPage.tsx");
const PostEditPage_1 = __webpack_require__(/*! ./Admin/Pages/PostEditPage */ "./resources/ts/Admin/Pages/PostEditPage.tsx");
const TaxonomyEditPage_1 = __webpack_require__(/*! ./Admin/Pages/TaxonomyEditPage */ "./resources/ts/Admin/Pages/TaxonomyEditPage.tsx");
const TokenMetaEditPage_1 = __webpack_require__(/*! ./Admin/Pages/TokenMetaEditPage */ "./resources/ts/Admin/Pages/TokenMetaEditPage.tsx");
const element_1 = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
class AdminApp extends App_1.default {
    constructor() {
        var _a, _b;
        super();
        this.container = Inversify_config_1.container;
        this.tcaEnabled = false;
        this.tcaRules = [];
        this.routePrefix = 'tokenly';
        this.pageElement = document.querySelector('.tokenpass-admin-page');
        if (this.pageElement) {
            const data = window.tokenpassData;
            if (!data) {
                return;
            }
            this.pageData = data === null || data === void 0 ? void 0 : data.props;
            this.view = (_a = this.pageData) === null || _a === void 0 ? void 0 : _a.view;
            const views = this.getViews();
            const ViewComponent = (_b = views[this.view]) !== null && _b !== void 0 ? _b : null;
            if (ViewComponent) {
                this.highlightMenu();
                this.render(ViewComponent);
            }
        }
        this.registerRedirects();
    }
    getViews() {
        let routes = {
            'dashboard': DashboardPage_1.default,
            'balances-show': BalancesShowPage_1.default,
            'settings': SettingsPage_1.default,
            'connection': ConnectionPage_1.default,
            'vendor': VendorPage_1.default,
            'whitelist': WhitelistPage_1.default,
            'promise-show': PromiseShowPage_1.default,
            'promise-store': PromiseStorePage_1.default,
            'promise-edit': PromiseEditPage_1.default,
            'credit-group-index': CreditGroupIndexPage_1.default,
            'credit-group-show': CreditGroupShowPage_1.default,
            'credit-group-store': CreditGroupStorePage_1.default,
            'credit-group-edit': CreditGroupEditPage_1.default,
            'credit-transaction-index': CreditTransactionIndexPage_1.default,
            'credit-transaction-store': CreditTransactionStorePage_1.default,
            'source-index': SourceIndexPage_1.default,
            'source-show': SourceShowPage_1.default,
            'source-store': SourceStorePage_1.default,
            'source-edit': SourceEditPage_1.default,
            'post-edit': PostEditPage_1.default,
            'taxonomy-edit': TaxonomyEditPage_1.default,
            'token-meta-edit': TokenMetaEditPage_1.default,
        };
        return routes;
    }
    render(ViewComponent) {
        if (!this.pageElement) {
            return;
        }
        const pageContainer = document.createElement('div');
        this.pageElement.appendChild(pageContainer);
        (0, element_1.render)(React.createElement(inversify_react_1.Provider, { container: this.container },
            React.createElement(AppLayout_1.default, { pageData: this.pageData },
                React.createElement(ViewComponent, { pageData: this.pageData }))), pageContainer);
    }
    registerRedirects() {
        document.addEventListener('DOMContentLoaded', () => {
            if (window['tokenpassRedirects']) {
                window['tokenpassRedirects'].forEach((redirect) => {
                    const element = document.querySelector(`[href='${redirect.from}']`);
                    if (element) {
                        element.href = redirect.to;
                        element.target = '_blank';
                    }
                });
            }
        });
    }
    highlightMenu() {
        const adminMenu = document.querySelector('#adminmenu #toplevel_page_tokenly');
        if (!adminMenu) {
            return;
        }
        adminMenu.classList.remove('wp-not-current-submenu');
        adminMenu.classList.add('wp-has-current-submenu', 'wp-menu-open');
    }
}
(function () {
    const admin = new AdminApp();
})();

}();
/******/ })()
;
//# sourceMappingURL=Admin.js.map