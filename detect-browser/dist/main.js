/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./js/script.js":
/*!**********************!*\
  !*** ./js/script.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/hooks */ \"./node_modules/@wordpress/hooks/build-module/index.js\");\n\r\n\r\njQuery( function ($) {\r\n\r\n\tlet globalHooks = (0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__.createHooks)();\r\n\tfunction getBrowser() {\r\n\t\tlet result = '';\r\n\t\tif ( ( navigator.userAgent.indexOf( 'Opera' ) || navigator.userAgent.indexOf( 'OPR' ) ) != -1 ) {\r\n\t\t\tresult = 'Opera Browser';\r\n\t\t}\r\n\t\telse if ( navigator.userAgent.indexOf( 'Chrome' ) != -1 ) {\r\n\t\t\tresult = 'Hi Chrome Browser';\r\n\t\t}\r\n\t\telse if ( navigator.userAgent.indexOf( 'Safari' ) != -1 ) {\r\n\t\t\tresult = 'Safari Browser';\r\n\t\t}\r\n\t\telse if ( navigator.userAgent.indexOf( 'Firefox' ) != -1 )  {\r\n\t\t\tresult = 'Firefox Browser';\r\n\t\t}\r\n\t\telse if ( ( navigator.userAgent.indexOf( 'MSIE' ) != -1 ) || ( !! document.documentMode == true ) ) {\r\n\t\t\tresult = 'IE Browser';\r\n\t\t}\r\n\t\telse {\r\n\t\t\tresult = 'unknown Browser';\r\n\t\t}\r\n\t\treturn globalHooks.applyFilters( 'detect_browser', result );\r\n\t}\r\n\r\n\t\r\n\tglobalHooks.addFilter( 'detect_browser', 'myApp', filterGetBrowser );\r\n\tfunction filterGetBrowser() {\r\n\t\treturn navigator.appVersion;\r\n\t}\r\n\r\n\r\n\tconsole.log( getBrowser() );\r\n} );\n\n//# sourceURL=webpack://package/./js/script.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _arrayLikeToArray)\n/* harmony export */ });\nfunction _arrayLikeToArray(arr, len) {\n  if (len == null || len > arr.length) len = arr.length;\n\n  for (var i = 0, arr2 = new Array(len); i < len; i++) {\n    arr2[i] = arr[i];\n  }\n\n  return arr2;\n}\n\n//# sourceURL=webpack://package/./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _arrayWithoutHoles)\n/* harmony export */ });\n/* harmony import */ var _babel_runtime_helpers_esm_arrayLikeToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/arrayLikeToArray */ \"./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js\");\n\nfunction _arrayWithoutHoles(arr) {\n  if (Array.isArray(arr)) return (0,_babel_runtime_helpers_esm_arrayLikeToArray__WEBPACK_IMPORTED_MODULE_0__.default)(arr);\n}\n\n//# sourceURL=webpack://package/./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/classCallCheck.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/classCallCheck.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _classCallCheck)\n/* harmony export */ });\nfunction _classCallCheck(instance, Constructor) {\n  if (!(instance instanceof Constructor)) {\n    throw new TypeError(\"Cannot call a class as a function\");\n  }\n}\n\n//# sourceURL=webpack://package/./node_modules/@babel/runtime/helpers/esm/classCallCheck.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/iterableToArray.js":
/*!********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/iterableToArray.js ***!
  \********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _iterableToArray)\n/* harmony export */ });\nfunction _iterableToArray(iter) {\n  if (typeof Symbol !== \"undefined\" && Symbol.iterator in Object(iter)) return Array.from(iter);\n}\n\n//# sourceURL=webpack://package/./node_modules/@babel/runtime/helpers/esm/iterableToArray.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _nonIterableSpread)\n/* harmony export */ });\nfunction _nonIterableSpread() {\n  throw new TypeError(\"Invalid attempt to spread non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\");\n}\n\n//# sourceURL=webpack://package/./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _toConsumableArray)\n/* harmony export */ });\n/* harmony import */ var _babel_runtime_helpers_esm_arrayWithoutHoles__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/arrayWithoutHoles */ \"./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js\");\n/* harmony import */ var _babel_runtime_helpers_esm_iterableToArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/esm/iterableToArray */ \"./node_modules/@babel/runtime/helpers/esm/iterableToArray.js\");\n/* harmony import */ var _babel_runtime_helpers_esm_unsupportedIterableToArray__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/esm/unsupportedIterableToArray */ \"./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js\");\n/* harmony import */ var _babel_runtime_helpers_esm_nonIterableSpread__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/esm/nonIterableSpread */ \"./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js\");\n\n\n\n\nfunction _toConsumableArray(arr) {\n  return (0,_babel_runtime_helpers_esm_arrayWithoutHoles__WEBPACK_IMPORTED_MODULE_0__.default)(arr) || (0,_babel_runtime_helpers_esm_iterableToArray__WEBPACK_IMPORTED_MODULE_1__.default)(arr) || (0,_babel_runtime_helpers_esm_unsupportedIterableToArray__WEBPACK_IMPORTED_MODULE_2__.default)(arr) || (0,_babel_runtime_helpers_esm_nonIterableSpread__WEBPACK_IMPORTED_MODULE_3__.default)();\n}\n\n//# sourceURL=webpack://package/./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _unsupportedIterableToArray)\n/* harmony export */ });\n/* harmony import */ var _babel_runtime_helpers_esm_arrayLikeToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/arrayLikeToArray */ \"./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js\");\n\nfunction _unsupportedIterableToArray(o, minLen) {\n  if (!o) return;\n  if (typeof o === \"string\") return (0,_babel_runtime_helpers_esm_arrayLikeToArray__WEBPACK_IMPORTED_MODULE_0__.default)(o, minLen);\n  var n = Object.prototype.toString.call(o).slice(8, -1);\n  if (n === \"Object\" && o.constructor) n = o.constructor.name;\n  if (n === \"Map\" || n === \"Set\") return Array.from(o);\n  if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return (0,_babel_runtime_helpers_esm_arrayLikeToArray__WEBPACK_IMPORTED_MODULE_0__.default)(o, minLen);\n}\n\n//# sourceURL=webpack://package/./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createAddHook.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createAddHook.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _validateNamespace_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validateNamespace.js */ \"./node_modules/@wordpress/hooks/build-module/validateNamespace.js\");\n/* harmony import */ var _validateHookName_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./validateHookName.js */ \"./node_modules/@wordpress/hooks/build-module/validateHookName.js\");\n/**\n * Internal dependencies\n */\n\n\n/**\n * @callback AddHook\n *\n * Adds the hook to the appropriate hooks container.\n *\n * @param {string}               hookName  Name of hook to add\n * @param {string}               namespace The unique namespace identifying the callback in the form `vendor/plugin/function`.\n * @param {import('.').Callback} callback  Function to call when the hook is run\n * @param {number}               [priority=10]  Priority of this hook\n */\n\n/**\n * Returns a function which, when invoked, will add a hook.\n *\n * @param  {import('.').Hooks}    hooks Hooks instance.\n * @param  {import('.').StoreKey} storeKey\n *\n * @return {AddHook} Function that adds a new hook.\n */\n\nfunction createAddHook(hooks, storeKey) {\n  return function addHook(hookName, namespace, callback) {\n    var priority = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 10;\n    var hooksStore = hooks[storeKey];\n\n    if (!(0,_validateHookName_js__WEBPACK_IMPORTED_MODULE_1__.default)(hookName)) {\n      return;\n    }\n\n    if (!(0,_validateNamespace_js__WEBPACK_IMPORTED_MODULE_0__.default)(namespace)) {\n      return;\n    }\n\n    if ('function' !== typeof callback) {\n      // eslint-disable-next-line no-console\n      console.error('The hook callback must be a function.');\n      return;\n    } // Validate numeric priority\n\n\n    if ('number' !== typeof priority) {\n      // eslint-disable-next-line no-console\n      console.error('If specified, the hook priority must be a number.');\n      return;\n    }\n\n    var handler = {\n      callback: callback,\n      priority: priority,\n      namespace: namespace\n    };\n\n    if (hooksStore[hookName]) {\n      // Find the correct insert index of the new hook.\n      var handlers = hooksStore[hookName].handlers;\n      /** @type {number} */\n\n      var i;\n\n      for (i = handlers.length; i > 0; i--) {\n        if (priority >= handlers[i - 1].priority) {\n          break;\n        }\n      }\n\n      if (i === handlers.length) {\n        // If append, operate via direct assignment.\n        handlers[i] = handler;\n      } else {\n        // Otherwise, insert before index via splice.\n        handlers.splice(i, 0, handler);\n      } // We may also be currently executing this hook.  If the callback\n      // we're adding would come after the current callback, there's no\n      // problem; otherwise we need to increase the execution index of\n      // any other runs by 1 to account for the added element.\n\n\n      hooksStore.__current.forEach(function (hookInfo) {\n        if (hookInfo.name === hookName && hookInfo.currentIndex >= i) {\n          hookInfo.currentIndex++;\n        }\n      });\n    } else {\n      // This is the first hook of its type.\n      hooksStore[hookName] = {\n        handlers: [handler],\n        runs: 0\n      };\n    }\n\n    if (hookName !== 'hookAdded') {\n      hooks.doAction('hookAdded', hookName, namespace, callback, priority);\n    }\n  };\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createAddHook);\n//# sourceMappingURL=createAddHook.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createAddHook.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createCurrentHook.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createCurrentHook.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/**\n * Returns a function which, when invoked, will return the name of the\n * currently running hook, or `null` if no hook of the given type is currently\n * running.\n *\n * @param  {import('.').Hooks}    hooks Hooks instance.\n * @param  {import('.').StoreKey} storeKey\n *\n * @return {() => string | null} Function that returns the current hook name or null.\n */\nfunction createCurrentHook(hooks, storeKey) {\n  return function currentHook() {\n    var _hooksStore$__current, _hooksStore$__current2;\n\n    var hooksStore = hooks[storeKey];\n    return (_hooksStore$__current = (_hooksStore$__current2 = hooksStore.__current[hooksStore.__current.length - 1]) === null || _hooksStore$__current2 === void 0 ? void 0 : _hooksStore$__current2.name) !== null && _hooksStore$__current !== void 0 ? _hooksStore$__current : null;\n  };\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createCurrentHook);\n//# sourceMappingURL=createCurrentHook.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createCurrentHook.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createDidHook.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createDidHook.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _validateHookName_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validateHookName.js */ \"./node_modules/@wordpress/hooks/build-module/validateHookName.js\");\n/**\n * Internal dependencies\n */\n\n/**\n * @callback DidHook\n *\n * Returns the number of times an action has been fired.\n *\n * @param  {string} hookName The hook name to check.\n *\n * @return {number | undefined} The number of times the hook has run.\n */\n\n/**\n * Returns a function which, when invoked, will return the number of times a\n * hook has been called.\n *\n * @param  {import('.').Hooks}    hooks Hooks instance.\n * @param  {import('.').StoreKey} storeKey\n *\n * @return {DidHook} Function that returns a hook's call count.\n */\n\nfunction createDidHook(hooks, storeKey) {\n  return function didHook(hookName) {\n    var hooksStore = hooks[storeKey];\n\n    if (!(0,_validateHookName_js__WEBPACK_IMPORTED_MODULE_0__.default)(hookName)) {\n      return;\n    }\n\n    return hooksStore[hookName] && hooksStore[hookName].runs ? hooksStore[hookName].runs : 0;\n  };\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createDidHook);\n//# sourceMappingURL=createDidHook.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createDidHook.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createDoingHook.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createDoingHook.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/**\n * @callback DoingHook\n * Returns whether a hook is currently being executed.\n *\n * @param  {string} [hookName] The name of the hook to check for.  If\n *                             omitted, will check for any hook being executed.\n *\n * @return {boolean} Whether the hook is being executed.\n */\n\n/**\n * Returns a function which, when invoked, will return whether a hook is\n * currently being executed.\n *\n * @param  {import('.').Hooks}    hooks Hooks instance.\n * @param  {import('.').StoreKey} storeKey\n *\n * @return {DoingHook} Function that returns whether a hook is currently\n *                     being executed.\n */\nfunction createDoingHook(hooks, storeKey) {\n  return function doingHook(hookName) {\n    var hooksStore = hooks[storeKey]; // If the hookName was not passed, check for any current hook.\n\n    if ('undefined' === typeof hookName) {\n      return 'undefined' !== typeof hooksStore.__current[0];\n    } // Return the __current hook.\n\n\n    return hooksStore.__current[0] ? hookName === hooksStore.__current[0].name : false;\n  };\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createDoingHook);\n//# sourceMappingURL=createDoingHook.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createDoingHook.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createHasHook.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createHasHook.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/**\n * @callback HasHook\n *\n * Returns whether any handlers are attached for the given hookName and optional namespace.\n *\n * @param {string} hookName    The name of the hook to check for.\n * @param {string} [namespace] Optional. The unique namespace identifying the callback\n *                             in the form `vendor/plugin/function`.\n *\n * @return {boolean} Whether there are handlers that are attached to the given hook.\n */\n\n/**\n * Returns a function which, when invoked, will return whether any handlers are\n * attached to a particular hook.\n *\n * @param  {import('.').Hooks}    hooks Hooks instance.\n * @param  {import('.').StoreKey} storeKey\n *\n * @return {HasHook} Function that returns whether any handlers are\n *                   attached to a particular hook and optional namespace.\n */\nfunction createHasHook(hooks, storeKey) {\n  return function hasHook(hookName, namespace) {\n    var hooksStore = hooks[storeKey]; // Use the namespace if provided.\n\n    if ('undefined' !== typeof namespace) {\n      return hookName in hooksStore && hooksStore[hookName].handlers.some(function (hook) {\n        return hook.namespace === namespace;\n      });\n    }\n\n    return hookName in hooksStore;\n  };\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createHasHook);\n//# sourceMappingURL=createHasHook.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createHasHook.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createHooks.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createHooks.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"_Hooks\": () => (/* binding */ _Hooks),\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _babel_runtime_helpers_esm_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/classCallCheck */ \"./node_modules/@babel/runtime/helpers/esm/classCallCheck.js\");\n/* harmony import */ var _createAddHook__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./createAddHook */ \"./node_modules/@wordpress/hooks/build-module/createAddHook.js\");\n/* harmony import */ var _createRemoveHook__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./createRemoveHook */ \"./node_modules/@wordpress/hooks/build-module/createRemoveHook.js\");\n/* harmony import */ var _createHasHook__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./createHasHook */ \"./node_modules/@wordpress/hooks/build-module/createHasHook.js\");\n/* harmony import */ var _createRunHook__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./createRunHook */ \"./node_modules/@wordpress/hooks/build-module/createRunHook.js\");\n/* harmony import */ var _createCurrentHook__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./createCurrentHook */ \"./node_modules/@wordpress/hooks/build-module/createCurrentHook.js\");\n/* harmony import */ var _createDoingHook__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./createDoingHook */ \"./node_modules/@wordpress/hooks/build-module/createDoingHook.js\");\n/* harmony import */ var _createDidHook__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./createDidHook */ \"./node_modules/@wordpress/hooks/build-module/createDidHook.js\");\n\n\n/**\n * Internal dependencies\n */\n\n\n\n\n\n\n\n/**\n * Internal class for constructing hooks. Use `createHooks()` function\n *\n * Note, it is necessary to expose this class to make its type public.\n *\n * @private\n */\n\nvar _Hooks = function _Hooks() {\n  (0,_babel_runtime_helpers_esm_classCallCheck__WEBPACK_IMPORTED_MODULE_0__.default)(this, _Hooks);\n\n  /** @type {import('.').Store} actions */\n  this.actions = Object.create(null);\n  this.actions.__current = [];\n  /** @type {import('.').Store} filters */\n\n  this.filters = Object.create(null);\n  this.filters.__current = [];\n  this.addAction = (0,_createAddHook__WEBPACK_IMPORTED_MODULE_1__.default)(this, 'actions');\n  this.addFilter = (0,_createAddHook__WEBPACK_IMPORTED_MODULE_1__.default)(this, 'filters');\n  this.removeAction = (0,_createRemoveHook__WEBPACK_IMPORTED_MODULE_2__.default)(this, 'actions');\n  this.removeFilter = (0,_createRemoveHook__WEBPACK_IMPORTED_MODULE_2__.default)(this, 'filters');\n  this.hasAction = (0,_createHasHook__WEBPACK_IMPORTED_MODULE_3__.default)(this, 'actions');\n  this.hasFilter = (0,_createHasHook__WEBPACK_IMPORTED_MODULE_3__.default)(this, 'filters');\n  this.removeAllActions = (0,_createRemoveHook__WEBPACK_IMPORTED_MODULE_2__.default)(this, 'actions', true);\n  this.removeAllFilters = (0,_createRemoveHook__WEBPACK_IMPORTED_MODULE_2__.default)(this, 'filters', true);\n  this.doAction = (0,_createRunHook__WEBPACK_IMPORTED_MODULE_4__.default)(this, 'actions');\n  this.applyFilters = (0,_createRunHook__WEBPACK_IMPORTED_MODULE_4__.default)(this, 'filters', true);\n  this.currentAction = (0,_createCurrentHook__WEBPACK_IMPORTED_MODULE_5__.default)(this, 'actions');\n  this.currentFilter = (0,_createCurrentHook__WEBPACK_IMPORTED_MODULE_5__.default)(this, 'filters');\n  this.doingAction = (0,_createDoingHook__WEBPACK_IMPORTED_MODULE_6__.default)(this, 'actions');\n  this.doingFilter = (0,_createDoingHook__WEBPACK_IMPORTED_MODULE_6__.default)(this, 'filters');\n  this.didAction = (0,_createDidHook__WEBPACK_IMPORTED_MODULE_7__.default)(this, 'actions');\n  this.didFilter = (0,_createDidHook__WEBPACK_IMPORTED_MODULE_7__.default)(this, 'filters');\n};\n/** @typedef {_Hooks} Hooks */\n\n/**\n * Returns an instance of the hooks object.\n *\n * @return {Hooks} A Hooks instance.\n */\n\nfunction createHooks() {\n  return new _Hooks();\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createHooks);\n//# sourceMappingURL=createHooks.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createHooks.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createRemoveHook.js":
/*!************************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createRemoveHook.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _validateNamespace_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validateNamespace.js */ \"./node_modules/@wordpress/hooks/build-module/validateNamespace.js\");\n/* harmony import */ var _validateHookName_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./validateHookName.js */ \"./node_modules/@wordpress/hooks/build-module/validateHookName.js\");\n/**\n * Internal dependencies\n */\n\n\n/**\n * @callback RemoveHook\n * Removes the specified callback (or all callbacks) from the hook with a given hookName\n * and namespace.\n *\n * @param {string} hookName  The name of the hook to modify.\n * @param {string} namespace The unique namespace identifying the callback in the\n *                           form `vendor/plugin/function`.\n *\n * @return {number | undefined} The number of callbacks removed.\n */\n\n/**\n * Returns a function which, when invoked, will remove a specified hook or all\n * hooks by the given name.\n *\n * @param  {import('.').Hooks}    hooks Hooks instance.\n * @param  {import('.').StoreKey} storeKey\n * @param  {boolean}              [removeAll=false] Whether to remove all callbacks for a hookName,\n *                                                  without regard to namespace. Used to create\n *                                                  `removeAll*` functions.\n *\n * @return {RemoveHook} Function that removes hooks.\n */\n\nfunction createRemoveHook(hooks, storeKey) {\n  var removeAll = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;\n  return function removeHook(hookName, namespace) {\n    var hooksStore = hooks[storeKey];\n\n    if (!(0,_validateHookName_js__WEBPACK_IMPORTED_MODULE_1__.default)(hookName)) {\n      return;\n    }\n\n    if (!removeAll && !(0,_validateNamespace_js__WEBPACK_IMPORTED_MODULE_0__.default)(namespace)) {\n      return;\n    } // Bail if no hooks exist by this name\n\n\n    if (!hooksStore[hookName]) {\n      return 0;\n    }\n\n    var handlersRemoved = 0;\n\n    if (removeAll) {\n      handlersRemoved = hooksStore[hookName].handlers.length;\n      hooksStore[hookName] = {\n        runs: hooksStore[hookName].runs,\n        handlers: []\n      };\n    } else {\n      // Try to find the specified callback to remove.\n      var handlers = hooksStore[hookName].handlers;\n\n      var _loop = function _loop(i) {\n        if (handlers[i].namespace === namespace) {\n          handlers.splice(i, 1);\n          handlersRemoved++; // This callback may also be part of a hook that is\n          // currently executing.  If the callback we're removing\n          // comes after the current callback, there's no problem;\n          // otherwise we need to decrease the execution index of any\n          // other runs by 1 to account for the removed element.\n\n          hooksStore.__current.forEach(function (hookInfo) {\n            if (hookInfo.name === hookName && hookInfo.currentIndex >= i) {\n              hookInfo.currentIndex--;\n            }\n          });\n        }\n      };\n\n      for (var i = handlers.length - 1; i >= 0; i--) {\n        _loop(i);\n      }\n    }\n\n    if (hookName !== 'hookRemoved') {\n      hooks.doAction('hookRemoved', hookName, namespace);\n    }\n\n    return handlersRemoved;\n  };\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createRemoveHook);\n//# sourceMappingURL=createRemoveHook.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createRemoveHook.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/createRunHook.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/createRunHook.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _babel_runtime_helpers_esm_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/toConsumableArray */ \"./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js\");\n\n\n/**\n * Returns a function which, when invoked, will execute all callbacks\n * registered to a hook of the specified type, optionally returning the final\n * value of the call chain.\n *\n * @param  {import('.').Hooks}    hooks Hooks instance.\n * @param  {import('.').StoreKey} storeKey\n * @param  {boolean}              [returnFirstArg=false] Whether each hook callback is expected to\n *                                                       return its first argument.\n *\n * @return {(hookName:string, ...args: unknown[]) => unknown} Function that runs hook callbacks.\n */\nfunction createRunHook(hooks, storeKey) {\n  var returnFirstArg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;\n  return function runHooks(hookName) {\n    var hooksStore = hooks[storeKey];\n\n    if (!hooksStore[hookName]) {\n      hooksStore[hookName] = {\n        handlers: [],\n        runs: 0\n      };\n    }\n\n    hooksStore[hookName].runs++;\n    var handlers = hooksStore[hookName].handlers; // The following code is stripped from production builds.\n\n    if (true) {\n      // Handle any 'all' hooks registered.\n      if ('hookAdded' !== hookName && hooksStore.all) {\n        handlers.push.apply(handlers, (0,_babel_runtime_helpers_esm_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__.default)(hooksStore.all.handlers));\n      }\n    }\n\n    for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {\n      args[_key - 1] = arguments[_key];\n    }\n\n    if (!handlers || !handlers.length) {\n      return returnFirstArg ? args[0] : undefined;\n    }\n\n    var hookInfo = {\n      name: hookName,\n      currentIndex: 0\n    };\n\n    hooksStore.__current.push(hookInfo);\n\n    while (hookInfo.currentIndex < handlers.length) {\n      var handler = handlers[hookInfo.currentIndex];\n      var result = handler.callback.apply(null, args);\n\n      if (returnFirstArg) {\n        args[0] = result;\n      }\n\n      hookInfo.currentIndex++;\n    }\n\n    hooksStore.__current.pop();\n\n    if (returnFirstArg) {\n      return args[0];\n    }\n  };\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createRunHook);\n//# sourceMappingURL=createRunHook.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/createRunHook.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/index.js":
/*!*************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/index.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"createHooks\": () => (/* reexport safe */ _createHooks__WEBPACK_IMPORTED_MODULE_0__.default),\n/* harmony export */   \"addAction\": () => (/* binding */ addAction),\n/* harmony export */   \"addFilter\": () => (/* binding */ addFilter),\n/* harmony export */   \"removeAction\": () => (/* binding */ removeAction),\n/* harmony export */   \"removeFilter\": () => (/* binding */ removeFilter),\n/* harmony export */   \"hasAction\": () => (/* binding */ hasAction),\n/* harmony export */   \"hasFilter\": () => (/* binding */ hasFilter),\n/* harmony export */   \"removeAllActions\": () => (/* binding */ removeAllActions),\n/* harmony export */   \"removeAllFilters\": () => (/* binding */ removeAllFilters),\n/* harmony export */   \"doAction\": () => (/* binding */ doAction),\n/* harmony export */   \"applyFilters\": () => (/* binding */ applyFilters),\n/* harmony export */   \"currentAction\": () => (/* binding */ currentAction),\n/* harmony export */   \"currentFilter\": () => (/* binding */ currentFilter),\n/* harmony export */   \"doingAction\": () => (/* binding */ doingAction),\n/* harmony export */   \"doingFilter\": () => (/* binding */ doingFilter),\n/* harmony export */   \"didAction\": () => (/* binding */ didAction),\n/* harmony export */   \"didFilter\": () => (/* binding */ didFilter),\n/* harmony export */   \"actions\": () => (/* binding */ actions),\n/* harmony export */   \"filters\": () => (/* binding */ filters)\n/* harmony export */ });\n/* harmony import */ var _createHooks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createHooks */ \"./node_modules/@wordpress/hooks/build-module/createHooks.js\");\n/**\n * Internal dependencies\n */\n\n/** @typedef {(...args: any[])=>any} Callback */\n\n/**\n * @typedef Handler\n * @property {Callback} callback  The callback\n * @property {string}   namespace The namespace\n * @property {number}   priority  The namespace\n */\n\n/**\n * @typedef Hook\n * @property {Handler[]} handlers Array of handlers\n * @property {number}    runs     Run counter\n */\n\n/**\n * @typedef Current\n * @property {string} name         Hook name\n * @property {number} currentIndex The index\n */\n\n/**\n * @typedef {Record<string, Hook> & {__current: Current[]}} Store\n */\n\n/**\n * @typedef {'actions' | 'filters'} StoreKey\n */\n\n/**\n * @typedef {import('./createHooks').Hooks} Hooks\n */\n\nvar _createHooks = (0,_createHooks__WEBPACK_IMPORTED_MODULE_0__.default)(),\n    addAction = _createHooks.addAction,\n    addFilter = _createHooks.addFilter,\n    removeAction = _createHooks.removeAction,\n    removeFilter = _createHooks.removeFilter,\n    hasAction = _createHooks.hasAction,\n    hasFilter = _createHooks.hasFilter,\n    removeAllActions = _createHooks.removeAllActions,\n    removeAllFilters = _createHooks.removeAllFilters,\n    doAction = _createHooks.doAction,\n    applyFilters = _createHooks.applyFilters,\n    currentAction = _createHooks.currentAction,\n    currentFilter = _createHooks.currentFilter,\n    doingAction = _createHooks.doingAction,\n    doingFilter = _createHooks.doingFilter,\n    didAction = _createHooks.didAction,\n    didFilter = _createHooks.didFilter,\n    actions = _createHooks.actions,\n    filters = _createHooks.filters;\n\n\n//# sourceMappingURL=index.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/index.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/validateHookName.js":
/*!************************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/validateHookName.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/**\n * Validate a hookName string.\n *\n * @param  {string} hookName The hook name to validate. Should be a non empty string containing\n *                           only numbers, letters, dashes, periods and underscores. Also,\n *                           the hook name cannot begin with `__`.\n *\n * @return {boolean}            Whether the hook name is valid.\n */\nfunction validateHookName(hookName) {\n  if ('string' !== typeof hookName || '' === hookName) {\n    // eslint-disable-next-line no-console\n    console.error('The hook name must be a non-empty string.');\n    return false;\n  }\n\n  if (/^__/.test(hookName)) {\n    // eslint-disable-next-line no-console\n    console.error('The hook name cannot begin with `__`.');\n    return false;\n  }\n\n  if (!/^[a-zA-Z][a-zA-Z0-9_.-]*$/.test(hookName)) {\n    // eslint-disable-next-line no-console\n    console.error('The hook name can only contain numbers, letters, dashes, periods and underscores.');\n    return false;\n  }\n\n  return true;\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (validateHookName);\n//# sourceMappingURL=validateHookName.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/validateHookName.js?");

/***/ }),

/***/ "./node_modules/@wordpress/hooks/build-module/validateNamespace.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@wordpress/hooks/build-module/validateNamespace.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/**\n * Validate a namespace string.\n *\n * @param  {string} namespace The namespace to validate - should take the form\n *                            `vendor/plugin/function`.\n *\n * @return {boolean}             Whether the namespace is valid.\n */\nfunction validateNamespace(namespace) {\n  if ('string' !== typeof namespace || '' === namespace) {\n    // eslint-disable-next-line no-console\n    console.error('The namespace must be a non-empty string.');\n    return false;\n  }\n\n  if (!/^[a-zA-Z][a-zA-Z0-9_.\\-\\/]*$/.test(namespace)) {\n    // eslint-disable-next-line no-console\n    console.error('The namespace can only contain numbers, letters, dashes, periods, underscores and slashes.');\n    return false;\n  }\n\n  return true;\n}\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (validateNamespace);\n//# sourceMappingURL=validateNamespace.js.map\n\n//# sourceURL=webpack://package/./node_modules/@wordpress/hooks/build-module/validateNamespace.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
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
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	// startup
/******/ 	// Load entry module
/******/ 	__webpack_require__("./js/script.js");
/******/ 	// This entry module used 'exports' so it can't be inlined
/******/ })()
;