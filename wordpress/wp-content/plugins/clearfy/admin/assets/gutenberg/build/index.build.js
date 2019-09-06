/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function _typeof(obj) { if (typeof Symbol === \"function\" && typeof Symbol.iterator === \"symbol\") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === \"function\" && obj.constructor === Symbol && obj !== Symbol.prototype ? \"symbol\" : typeof obj; }; } return _typeof(obj); }\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nfunction _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === \"object\" || typeof call === \"function\")) { return call; } return _assertThisInitialized(self); }\n\nfunction _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }\n\nfunction _inherits(subClass, superClass) { if (typeof superClass !== \"function\" && superClass !== null) { throw new TypeError(\"Super expression must either be null or a function\"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }\n\nfunction _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }\n\nfunction _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError(\"this hasn't been initialised - super() hasn't been called\"); } return self; }\n\n/**\r\n * Gutenber autosave control. A simple solution for managing autosaves in gutenberg editor.\r\n * Previously, we simply turned off autosave using hooks, but in the editor,\r\n * you can’t do this in the gutenber.\r\n *\r\n * This widget for Gutenberg editor adds an icon, when clicked, you can select the autosave interval or full disable it.\r\n *\r\n * @author Webcraftic <wordpress.webraftic@gmail.com>\r\n * @copyright (c) 10.12.2018, Webcraftic\r\n * @version 1.0\r\n *\r\n * Credits:\r\n * This is not our development, we found excellent plugin and used these functions in our plugin. It is foolish to reinvent the wheel.\r\n * I hope in the future we will refine it better and add our ideas.\r\n * In the development of the code used by the author plugin: https://wordpress.org/plugins/disable-gutenberg-autosave/\r\n */\nvar NOT_TODAY = 99999;\nvar INTERVAL_OPTIONS = [{\n  label: '10 seconds (default)',\n  value: 10\n}, {\n  label: '30 seconds',\n  value: 30\n}, {\n  label: '1 minute',\n  value: 60\n}, {\n  label: '5 minutes',\n  value: 60 * 5\n}, {\n  label: '10 minutes',\n  value: 60 * 10\n}, {\n  label: '30 minutes',\n  value: 60 * 30\n}, {\n  label: 'Disabled',\n  value: NOT_TODAY\n}];\n\nvar ClearfyGutenbergAutosave =\n/*#__PURE__*/\nfunction (_React$Component) {\n  _inherits(ClearfyGutenbergAutosave, _React$Component);\n\n  function ClearfyGutenbergAutosave(props) {\n    var _this;\n\n    _classCallCheck(this, ClearfyGutenbergAutosave);\n\n    _this = _possibleConstructorReturn(this, _getPrototypeOf(ClearfyGutenbergAutosave).call(this, props));\n    _this.state = {\n      interval: 0,\n      error: false\n    };\n    _this.apiGetInterval = _this.apiGetInterval.bind(_assertThisInitialized(_assertThisInitialized(_this)));\n    _this.apiSetInterval = _this.apiSetInterval.bind(_assertThisInitialized(_assertThisInitialized(_this)));\n    _this.editorUpdateInterval = _this.editorUpdateInterval.bind(_assertThisInitialized(_assertThisInitialized(_this)));\n    return _this;\n  }\n\n  _createClass(ClearfyGutenbergAutosave, [{\n    key: \"apiGetInterval\",\n    value: function apiGetInterval() {\n      var _this2 = this;\n\n      wp.apiFetch({\n        path: '/clearfy-gutenberg-autosave/v1/interval'\n      }).then(function (interval) {\n        _this2.setState({\n          interval: interval,\n          error: false\n        });\n      }, function (error) {\n        _this2.setState({\n          interval: NOT_TODAY,\n          error: error.message\n        });\n      });\n    }\n  }, {\n    key: \"apiSetInterval\",\n    value: function apiSetInterval() {\n      if (this.state.error) {\n        return;\n      }\n\n      wp.apiFetch({\n        path: '/clearfy-gutenberg-autosave/v1/interval?interval=' + parseInt(this.state.interval),\n        method: 'POST'\n      });\n    }\n  }, {\n    key: \"editorUpdateInterval\",\n    value: function editorUpdateInterval() {\n      this.props.updateEditorSettings(Object.assign({}, this.props.editorSettings, {\n        autosaveInterval: parseInt(this.state.interval)\n      }));\n    }\n  }, {\n    key: \"componentDidMount\",\n    value: function componentDidMount() {\n      this.apiGetInterval();\n    }\n  }, {\n    key: \"componentDidUpdate\",\n    value: function componentDidUpdate(prevProps, prevState) {\n      if (!this.state.interval) {\n        return;\n      }\n\n      if (prevState.interval && prevState.inverval !== 0 && prevState.interval !== this.state.interval) {\n        this.apiSetInterval();\n      }\n\n      if (this.props.editorSettings.autosaveInterval && this.props.editorSettings.autosaveInterval !== this.state.interval) {\n        this.editorUpdateInterval();\n      }\n    }\n  }, {\n    key: \"render\",\n    value: function render() {\n      var _this3 = this;\n\n      return React.createElement(React.Fragment, null, React.createElement(wp.editPost.PluginSidebarMoreMenuItem, {\n        target: \"disable-gutenberg-autosave-sidebar\"\n      }, 'Clearfy Gutenberg Autosave'), React.createElement(wp.editPost.PluginSidebar, {\n        name: \"disable-gutenberg-autosave-sidebar\",\n        title: 'Autosave settings'\n      }, React.createElement(wp.components.PanelBody, {\n        className: \"disable-gutenberg-autosave-settings\"\n      }, !this.state.interval && React.createElement(\"p\", null, 'Loading...'), !!this.state.interval && this.state.error && React.createElement(React.Fragment, null, React.createElement(\"h2\", {\n        className: \"disable-gutenberg-autosave-header\"\n      }, 'API error:'), React.createElement(\"p\", {\n        className: \"disable-gutenberg-autosave-error\"\n      }, this.state.error), React.createElement(\"p\", null, 'Autosave is disabled anyway, but you cannot set custom intervals.'), React.createElement(wp.components.Button, {\n        className: \"button button-primary\",\n        onClick: function onClick() {\n          _this3.setState({\n            interval: 0,\n            error: false\n          });\n\n          _this3.apiGetInterval();\n        }\n      }, 'Try again')), !!this.state.interval && !this.state.error && React.createElement(wp.components.RadioControl, {\n        label: 'Autosave interval',\n        options: INTERVAL_OPTIONS,\n        selected: parseInt(this.state.interval),\n        onChange: function onChange(value) {\n          return _this3.setState({\n            interval: parseInt(value)\n          });\n        }\n      }))));\n    }\n  }]);\n\n  return ClearfyGutenbergAutosave;\n}(React.Component);\n\nwp.plugins.registerPlugin('clearfy-gutenberg-autosave', {\n  icon: 'backup',\n  render: wp.compose.compose([wp.data.withSelect(function (select) {\n    return {\n      editorSettings: select('core/editor').getEditorSettings()\n    };\n  }), wp.data.withDispatch(function (dispatch) {\n    return {\n      updateEditorSettings: dispatch('core/editor').updateEditorSettings\n    };\n  })])(ClearfyGutenbergAutosave)\n});\n\n//# sourceURL=webpack:///./src/index.js?");

/***/ })

/******/ });