/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./reactjs/src/components/Dropdown.js":
/*!********************************************!*\
  !*** ./reactjs/src/components/Dropdown.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _assets_scss_PopupMenu_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../assets/scss/PopupMenu.scss */ "./reactjs/src/assets/scss/PopupMenu.scss");
/* harmony import */ var _OutsideClick__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./OutsideClick */ "./reactjs/src/components/OutsideClick.js");



const Dropdown = props => {
  const [status, setStatus] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false); // Default Dropdown Status is false
  const {
    title,
    renderContent,
    className = '',
    labelClassName = '',
    onClickCallback,
    ...rest
  } = props;
  const dropdownRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  (0,_OutsideClick__WEBPACK_IMPORTED_MODULE_2__["default"])(dropdownRef, () => {
    setStatus(false);
  });
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_dropdown ".concat(className),
    ref: dropdownRef,
    onClick: e => {
      setStatus(!status);
      if (onClickCallback) {
        onClickCallback(e);
      }
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_dropdown__label ".concat(labelClassName)
  }, title), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_popup_menu__wrapper wholesalex_dropdown_content__wrapper"
  }, status && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_popup_menu wholesalex_dropdown_content"
  }, renderContent())));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Dropdown);

/***/ }),

/***/ "./reactjs/src/components/Header.js":
/*!******************************************!*\
  !*** ./reactjs/src/components/Header.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _assets_scss_Header_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../assets/scss/Header.scss */ "./reactjs/src/assets/scss/Header.scss");
/* harmony import */ var _Dropdown__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Dropdown */ "./reactjs/src/components/Dropdown.js");



const Header = _ref => {
  var _wholesalex, _wholesalex2;
  let {
    title,
    isFrontend
  } = _ref;
  const [showHelpPopUp, setShowHelpPopUp] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const helpLinks = [{
    'iconClass': 'dashicons-phone',
    'label': 'Get Supports',
    'link': 'https://getwholesalex.com/contact/?utm_source=wholesalex-menu&utm_medium=features_page-support&utm_campaign=wholesalex-DB'
  }, {
    'iconClass': 'dashicons-book',
    'label': 'Getting Started Guide',
    'link': 'https://getwholesalex.com/docs/wholesalex/getting-started/?utm_source=wholesalex-menu&utm_medium=features_page-guide&utm_campaign=wholesalex-DB'
  }, {
    'iconClass': 'dashicons-facebook-alt',
    'label': 'Join Community',
    'link': 'https://www.facebook.com/groups/wholesalexcommunity'
  }, {
    'iconClass': 'dashicons-book',
    'label': 'Feature Request',
    'link': 'https://getwholesalex.com/roadmap/?utm_source=wholesalex-menu&utm_medium=features_page-feature_request&utm_campaign=wholesalex-DB'
  }, {
    'iconClass': 'dashicons-youtube',
    'label': 'Youtube Tutorials',
    'link': 'https://www.youtube.com/@WholesaleX'
  }, {
    'iconClass': 'dashicons-book',
    'label': 'Documentation',
    'link': 'https://getwholesalex.com/documentation/?utm_source=wholesalex-menu&utm_medium=features_page-documentation&utm_campaign=wholesalex-DB'
  }, {
    'iconClass': 'dashicons-edit',
    'label': 'What’s New',
    'link': 'https://getwholesalex.com/roadmap/?utm_source=wholesalex-menu&utm_medium=features_page-what’s_new&utm_campaign=wholesalex-DB'
  }];
  const ref = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const sleep = async ms => {
    return new Promise(resolve => setTimeout(resolve, ms));
  };
  const popupHanlder = e => {
    if (showHelpPopUp) {
      var _ref$current;
      const style = ref === null || ref === void 0 || (_ref$current = ref.current) === null || _ref$current === void 0 ? void 0 : _ref$current.style;
      if (!style) return;
      sleep(200).then(() => {
        style.transition = "all 0.3s";
        style.transform = "translateY(-50%)";
        style.opacity = "0";
        sleep(200).then(() => {
          setShowHelpPopUp(false);
        });
      });
    } else {
      setShowHelpPopUp(true);
    }
  };
  const renderHelpDropdownContent = () => {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("ul", {
      className: "wholesalex_help_popup__links"
    }, helpLinks.map(help => {
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("li", {
        className: "wholesalex_help_popup__list"
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
        className: "dashicons ".concat(help.iconClass, " wholesalex_icon")
      }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("a", {
        href: help.link,
        className: "wholesalex_help_popup__link",
        target: "_blank"
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
        className: "wholesalex_help_popup__link_label"
      }, help.label)));
    }));
  };
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_header_wrapper"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_header"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_header__left"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("img", {
    src: (_wholesalex = wholesalex) === null || _wholesalex === void 0 ? void 0 : _wholesalex.logo_url,
    className: "wholesalex_logo"
  }), !isFrontend && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
    className: "wholesalex_version"
  }, "v".concat(wholesalex.current_version)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
    className: "dashicons dashicons-arrow-right-alt2 wholesalex_right_arrow_icon wholesalex_icon"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
    className: "wholesalex_header__title"
  }, title)), !isFrontend && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_header__right"
  }, !((_wholesalex2 = wholesalex) !== null && _wholesalex2 !== void 0 && _wholesalex2.whitelabel_enabled) && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_Dropdown__WEBPACK_IMPORTED_MODULE_2__["default"], {
    label: "",
    labelClassName: "dashicons dashicons-editor-help wholesalex_header_help_icon wholesalex_icon",
    renderContent: renderHelpDropdownContent
  })))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Header);

/***/ }),

/***/ "./reactjs/src/components/LoadingSpinner.js":
/*!**************************************************!*\
  !*** ./reactjs/src/components/LoadingSpinner.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _assets_scss_LoadingSpinner_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../assets/scss/LoadingSpinner.scss */ "./reactjs/src/assets/scss/LoadingSpinner.scss");


const LoadingSpinner = () => {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_circular_loading__wrapper"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_loading_spinner"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("svg", {
    viewBox: "25 25 50 50",
    className: "move_circular"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("circle", {
    cx: "50",
    cy: "50",
    r: "20",
    fill: "none",
    className: "wholesalex_circular_loading_icon"
  }))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (LoadingSpinner);

/***/ }),

/***/ "./reactjs/src/components/OutsideClick.js":
/*!************************************************!*\
  !*** ./reactjs/src/components/OutsideClick.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

const handleOutsideClick = (ref, callback) => {
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const handleClickOutside = event => {
      if (ref.current && !ref.current.contains(event.target)) {
        callback(event);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, [ref]);
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (handleOutsideClick);

/***/ }),

/***/ "./reactjs/src/components/Toast.js":
/*!*****************************************!*\
  !*** ./reactjs/src/components/Toast.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _assets_scss_Toast_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../assets/scss/Toast.scss */ "./reactjs/src/assets/scss/Toast.scss");
/* harmony import */ var _context_toastContent__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../context/toastContent */ "./reactjs/src/context/toastContent.js");



const Toast = _ref => {
  let {
    position,
    delay,
    type,
    ...rest
  } = _ref;
  const {
    state,
    dispatch
  } = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(_context_toastContent__WEBPACK_IMPORTED_MODULE_2__.ToastContext);
  const [deleteID, setDeleteID] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const sleep = ms => {
    return new Promise(resolve => setTimeout(resolve, ms));
  };
  const deleteMessage = async id => {
    setDeleteID(id);
    await sleep(200);
    dispatch({
      type: 'DELETE_MESSAGE',
      payload: id
    });
  };
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const interval = setInterval(() => {
      if (delay && state.length > 0) {
        deleteMessage(state[0].id);
      }
    }, delay);
    return () => clearInterval(interval);
  }, [state, delay]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (state.length > 3) {
      deleteMessage(state[0].id);
    }
  }, [state]);
  const visibleToasts = state.slice(-3);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_toast"
  }, visibleToasts.length > 0 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_toast_messages"
  }, visibleToasts.map(_message => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    key: "wholesalex_toast_".concat(_message.id),
    className: "wholesalex_toast_message wsx-".concat(_message.type, " ").concat(position, " ").concat(deleteID === _message.id ? 'wholesalex_delete_toast' : '')
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
    className: "dashicons dashicons-smiley"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
    className: "message"
  }, _message.message), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
    className: "dashicons dashicons-no-alt toast_close",
    onClick: e => deleteMessage(_message.id)
  })))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Toast);

/***/ }),

/***/ "./reactjs/src/context/toastContent.js":
/*!*********************************************!*\
  !*** ./reactjs/src/context/toastContent.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ToastContext: () => (/* binding */ ToastContext),
/* harmony export */   ToastContextProvider: () => (/* binding */ ToastContextProvider)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

const ToastContextProvider = props => {
  const [state, dispatch] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useReducer)((state, action) => {
    switch (action.type) {
      case "ADD_MESSAGE":
        return [...state, action.payload];
      case "DELETE_MESSAGE":
        return state.length > 0 && state.filter(message => message.id !== action.payload);
      default:
        return state;
    }
  }, []);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(ToastContext.Provider, {
    value: {
      state,
      dispatch
    }
  }, props.children);
};
const ToastContext = /*#__PURE__*/(0,react__WEBPACK_IMPORTED_MODULE_0__.createContext)();

/***/ }),

/***/ "./reactjs/src/pages/migration_plugin/Migration.js":
/*!*********************************************************!*\
  !*** ./reactjs/src/pages/migration_plugin/Migration.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _assets_scss_Settings_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../assets/scss/Settings.scss */ "./reactjs/src/assets/scss/Settings.scss");
/* harmony import */ var _components_LoadingSpinner__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../components/LoadingSpinner */ "./reactjs/src/components/LoadingSpinner.js");
/* harmony import */ var _context_toastContent__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../context/toastContent */ "./reactjs/src/context/toastContent.js");
/* harmony import */ var _components_Toast__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../components/Toast */ "./reactjs/src/components/Toast.js");





const Migration = () => {
  var _Object$keys, _wholesalex_migration, _wholesalex_migration2;
  const [fields, setFields] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(wholesalex_migration.fields);
  const [activeTab, setActiveTab] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)((_Object$keys = Object.keys(wholesalex_migration.fields)) === null || _Object$keys === void 0 ? void 0 : _Object$keys[0]);
  const {
    dispatch
  } = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(_context_toastContent__WEBPACK_IMPORTED_MODULE_3__.ToastContext);
  const [migrationRunning, setMigrationRunning] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [migrationStatus, setMigrationStatus] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)((_wholesalex_migration = wholesalex_migration) === null || _wholesalex_migration === void 0 ? void 0 : _wholesalex_migration.migration_status);
  const [migrationStats, setMigrationStats] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)((_wholesalex_migration2 = wholesalex_migration) === null || _wholesalex_migration2 === void 0 ? void 0 : _wholesalex_migration2.stats);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    var _Object$keys2, _wholesalex_migration3, _wholesalex_migration4;
    const hash = window.location.hash.slice(1);
    setActiveTab(hash && wholesalex_migration.fields[hash] ? hash : (_Object$keys2 = Object.keys(wholesalex_migration.fields)) === null || _Object$keys2 === void 0 ? void 0 : _Object$keys2[0]);
    setAllowB2BKingMigration((_wholesalex_migration3 = wholesalex_migration) === null || _wholesalex_migration3 === void 0 ? void 0 : _wholesalex_migration3.allow_b2bking_migration);
    setAllowWSMigration((_wholesalex_migration4 = wholesalex_migration) === null || _wholesalex_migration4 === void 0 ? void 0 : _wholesalex_migration4.allow_wholesale_suite_migration);
  }, []);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const handleHashChange = () => {
      var _Object$keys3;
      const hash = window.location.hash.slice(1);
      setActiveTab(hash && wholesalex_migration.fields[hash] ? hash : (_Object$keys3 = Object.keys(wholesalex_migration.fields)) === null || _Object$keys3 === void 0 ? void 0 : _Object$keys3[0]);
    };
    window.addEventListener('hashchange', handleHashChange);
    return () => {
      window.removeEventListener('hashchange', handleHashChange);
    };
  }, [fields]);
  const tabClickHandler = tabID => {
    setActiveTab(tabID);
    window.location.hash = tabID;
  };
  const startB2BKingMigration = () => {
    setMigrationStatus(prev => {
      return {
        ...prev,
        b2bking_migration: 'running'
      };
    });
    let attr = {
      type: 'start_b2bking_migration',
      action: 'migration',
      nonce: wholesalex_migration.nonce
    };
    wp.apiFetch({
      path: '/wholesalex/v1/migration',
      method: 'POST',
      data: attr
    }).then(res => {
      if (res.status) {
        dispatch({
          type: "ADD_MESSAGE",
          payload: {
            id: Date.now().toString(),
            type: 'success',
            message: "Migration Started"
          }
        });
        checkB2BKingMigrationStatus();
      }
    });
  };
  const startWSMigration = () => {
    setMigrationStatus(prev => {
      return {
        ...prev,
        wholesale_suite_migration: 'running'
      };
    });
    let attr = {
      type: 'start_ws_migration',
      action: 'migration',
      nonce: wholesalex_migration.nonce
    };
    wp.apiFetch({
      path: '/wholesalex/v1/migration',
      method: 'POST',
      data: attr
    }).then(res => {
      if (res.status) {
        dispatch({
          type: "ADD_MESSAGE",
          payload: {
            id: Date.now().toString(),
            type: 'success',
            message: "Migration Started"
          }
        });
        checkWSMigrationStatus();
        // setMigrationRunning(true);
        // setMigrationStatus((prevData) => {
        //   return { ...prevData, wholesale_suite_migration: true };
        // });
      }
    });
  };
  const sleep = async ms => {
    return new Promise(resolve => setTimeout(resolve, ms));
  };
  const checkB2BKingMigrationStatus = () => {
    let attr = {
      type: 'b2bking_migration_status',
      action: 'migration',
      nonce: wholesalex_migration.nonce
    };
    wp.apiFetch({
      path: '/wholesalex/v1/migration',
      method: 'POST',
      data: attr
    }).then(res => {
      if (res !== null && res !== void 0 && res.is_migrating) {
        setMigrationStatus(prev => {
          return {
            ...prev,
            b2bking_migration: 'running'
          };
        });
        sleep(5000).then(() => {
          checkB2BKingMigrationStatus();
        });
      } else {
        setMigrationStatus(prev => {
          return {
            ...prev,
            b2bking_migration: false
          };
        });
        setMigrationStats(prevData => {
          return {
            ...prevData,
            'b2bking_migration': res.migration_stats
          };
        });
        setAllowB2BKingMigration(false);
        dispatch({
          type: "ADD_MESSAGE",
          payload: {
            id: Date.now().toString(),
            type: 'success',
            message: 'Migration Successful.'
          }
        });
      }
    });
  };
  const checkWSMigrationStatus = () => {
    let attr = {
      type: 'ws_migration_status',
      action: 'migration',
      nonce: wholesalex_migration.nonce
    };
    wp.apiFetch({
      path: '/wholesalex/v1/migration',
      method: 'POST',
      data: attr
    }).then(res => {
      if (res !== null && res !== void 0 && res.is_migrating) {
        setMigrationStatus(prev => {
          return {
            ...prev,
            wholesale_suite_migration: 'running'
          };
        });
        sleep(5000).then(() => {
          checkWSMigrationStatus();
        });
      } else {
        setMigrationStats(prevData => {
          return {
            ...prevData,
            'wholesale_suite_migration': res.migration_stats
          };
        });
        setMigrationStatus(prev => {
          return {
            ...prev,
            wholesale_suite_migration: false
          };
        });
        setAllowWSMigration(false);
        dispatch({
          type: "ADD_MESSAGE",
          payload: {
            id: Date.now().toString(),
            type: 'success',
            message: 'Migration Successful.'
          }
        });
      }
    });
  };
  const [allowB2BKingMigration, setAllowB2BKingMigration] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(true);
  const [allowWSMigration, setAllowWSMigration] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(true);
  const renderMigrationButton = () => {
    switch (activeTab) {
      case 'b2bking_migration':
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("button", {
          disabled: !allowB2BKingMigration,
          className: "wholesalex-btn wholesalex-migrate-button wholesalex-primary-btn wholesalex-btn-lg",
          onClick: () => startB2BKingMigration()
        }, (migrationStatus === null || migrationStatus === void 0 ? void 0 : migrationStatus.b2bking_migration) == 'running' && 'Migrating..', !(migrationStatus !== null && migrationStatus !== void 0 && migrationStatus.b2bking_migration) && 'Migrate Now', (migrationStatus === null || migrationStatus === void 0 ? void 0 : migrationStatus.b2bking_migration) == 'complete' && 'Migrated');
        break;
      case 'wholesale_suite_migration':
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("button", {
          disabled: !allowWSMigration,
          className: "wholesalex-btn wholesalex-migrate-button wholesalex-primary-btn wholesalex-btn-lg",
          onClick: () => startWSMigration()
        }, (migrationStatus === null || migrationStatus === void 0 ? void 0 : migrationStatus.wholesale_suite_migration) == 'running' && 'Migrating..', !(migrationStatus !== null && migrationStatus !== void 0 && migrationStatus.wholesale_suite_migration) && 'Migrate Now', (migrationStatus === null || migrationStatus === void 0 ? void 0 : migrationStatus.wholesale_suite_migration) == 'complete' && 'Migrated');
        break;
      default:
        break;
    }
  };
  const renderTabData = () => {
    const tabData = fields[activeTab];
    let is_disable = false;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
      className: "wholesalex_settings_tab wholesalex_migration_tab"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
      className: "wholesalex_settings__tab_header"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
      className: "wholesalex_settings__tab_heading"
    }, tabData === null || tabData === void 0 ? void 0 : tabData['label'])), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("ul", {
      className: "wholesalex_settings__tab_content"
    }, migrationStatus[activeTab] == 'running' && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_components_LoadingSpinner__WEBPACK_IMPORTED_MODULE_2__["default"], null), tabData && Object.keys(tabData.attr).map((field, k) => {
      if (tabData.attr[field].status) {
        is_disable = true;
      }
      let _status = (migrationStats === null || migrationStats === void 0 ? void 0 : migrationStats[activeTab][field]) == 100;
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("li", {
        key: "settings_field_content_".concat(k),
        className: "wholesalex_settings__fields"
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
        className: "wholesalex_migration_field"
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
        className: _status ? 'wholesalex_migration_status dashicons dashicons-yes-alt wholesalex_migrated' : 'wholesalex_migration_status dashicons dashicons-yes-alt wholesalex_not_migrated'
      }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
        className: "wholesalex_migration_content"
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
        className: "wholesalex_migration_field__label"
      }, tabData.attr[field].label), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
        className: "wholesalex_migration_desc"
      }, tabData.attr[field].desc))));
    })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
      className: "wholesalex_migration_tab__footer"
    }, renderMigrationButton()));
  };
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_wrapper"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "wholesalex_settings"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("ul", {
    className: "wholesalex_settings_tab_lists"
  }, Object.keys(fields).map((section, k) => fields[section]["attr"] && Object.keys(fields[section]["attr"]).length > 0 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("li", {
    key: k,
    onClick: e => {
      tabClickHandler(section);
    },
    className: "wholesalex_settings_tab_list ".concat(activeTab === section ? "wholesalex_active_tab" : "")
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
    className: "wholesalex_settings_tab__title"
  }, fields[section].label)))), renderTabData()), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_components_Toast__WEBPACK_IMPORTED_MODULE_4__["default"], {
    position: 'top_right',
    delay: 7000
  })));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Migration);

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Header.scss":
/*!**************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Header.scss ***!
  \**************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/sourceMaps.js */ "./node_modules/css-loader/dist/runtime/sourceMaps.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, `.wholesalex_header .wholesalex_popup_menu {
  position: absolute;
  border-radius: 2px;
  box-shadow: 0 2px 4px 0 rgba(108, 108, 255, 0.2);
  background-color: #fff;
  z-index: 999;
  top: unset;
  right: 6px;
  padding: 15px;
  margin-top: 30px;
  min-width: 200px; }
  .wholesalex_header .wholesalex_popup_menu::before {
    content: "";
    content: "\\f142";
    position: absolute;
    right: 0px;
    top: -29px;
    font: normal 42px dashicons;
    color: #fff; }

.wholesalex_help_popup__link_label {
  color: var(--wholesalex-heading-text-color);
  text-decoration: none;
  font-size: 14px;
  line-height: 18px; }
  .wholesalex_help_popup__link_label:hover {
    color: var(--wholesalex-primary-color); }
  .wholesalex_help_popup__link_label:focus {
    outline: none; }

.wholesalex_help_popup__links {
  animation: fadeIn 0.3s ease;
  margin: 0px; }

@keyframes fadeIn {
  from {
    opacity: 0; }
  to {
    opacity: 1; } }

.wholesalex_help_popup__link {
  text-decoration: none;
  line-height: 1.5; }

.wholesalex_help_popup__list {
  display: flex;
  gap: 9px;
  text-align: left;
  margin-bottom: 15px; }
  .wholesalex_help_popup__list:last-child {
    margin-bottom: 0px; }

.wholesalex_help_popup__list .wholesalex_icon {
  font-size: 14px;
  line-height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px 5px 4px;
  background-color: var(--wholesalex-primary-color);
  color: #ffffff;
  border-radius: 50%;
  width: 14px;
  height: 15px; }

@keyframes slide-in {
  0% {
    opacity: 0;
    transform: translateY(-50%); }
  100% {
    opacity: 1;
    transform: translateY(0); } }

.wholesalex_logo {
  max-height: 25px; }

.wholesalex_header_wrapper {
  display: block;
  background-color: white;
  text-align: center; }

.wholesalex_header {
  display: flex;
  margin: 0 auto;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e6e5e5; }

.wholesalex_header__left {
  display: flex;
  align-items: center;
  gap: 15px;
  color: var(--wholesalex-primary-color);
  padding: 14px 0px 14px 44px; }

.wholesalex_version {
  box-sizing: border-box;
  border: 1px solid var(--wholesalex-primary-color);
  font-size: 12px;
  line-height: 1;
  padding: 5px 10px 5px;
  border-radius: 50px;
  align-items: center;
  font-weight: 600; }

.wholesalex_right_arrow_icon {
  font-size: 20px;
  height: 20px;
  margin: 0 5px; }

.wholesalex_header_help_icon {
  font-size: 40px;
  width: 35px;
  line-height: 18px;
  color: var(--wholesalex-heading-text-color);
  cursor: pointer;
  padding: 5px 20px; }

.wholesalex_header__right {
  border-left: 1px solid #e6e5e5;
  padding: 14px 0px 14px 0px;
  position: relative; }

.wholesalex_header__title {
  font-size: 14px;
  font-weight: 600; }

.wholesalex_backend_body.rtl .wholesalex_header__left {
  padding: 14px 44px 14px 44px; }
`, "",{"version":3,"sources":["webpack://./reactjs/src/assets/scss/Header.scss"],"names":[],"mappings":"AAAA;EAEQ,kBAAkB;EAClB,kBAAkB;EAClB,gDAAgD;EAChD,sBAAsB;EACtB,YAAY;EACZ,UAAU;EACV,UAAU;EACV,aAAa;EACb,gBAAgB;EAChB,gBAAgB,EAAA;EAXxB;IAcY,WAAW;IACX,gBAAgB;IAChB,kBAAkB;IAClB,UAAU;IACV,UAAU;IACV,2BAA2B;IAC3B,WAAW,EAAA;;AAMvB;EACI,2CAA2C;EAC3C,qBAAqB;EACrB,eAAe;EACf,iBAAiB,EAAA;EAJrB;IAOQ,sCAAsC,EAAA;EAP9C;IAWQ,aAAa,EAAA;;AAGrB;EACI,2BAA2B;EAC3B,WAAW,EAAA;;AAEf;EACI;IACE,UAAU,EAAA;EAEZ;IACE,UAAU,EAAA,EAAA;;AAGhB;EACI,qBAAqB;EACrB,gBAAgB,EAAA;;AAEpB;EACI,aAAa;EACb,QAAQ;EACR,gBAAgB;EAChB,mBAAmB,EAAA;EAJvB;IAOQ,kBAAkB,EAAA;;AAG1B;EACI,eAAe;EACf,iBAAiB;EACjB,aAAa;EACb,mBAAmB;EACnB,uBAAuB;EACvB,oBAAoB;EACpB,iDAAgD;EAChD,cAAc;EACd,kBAAkB;EAClB,WAAW;EACX,YAAY,EAAA;;AAEhB;EACI;IACE,UAAU;IACV,2BAA2B,EAAA;EAE7B;IACE,UAAU;IACV,wBAAwB,EAAA,EAAA;;AAG9B;EACI,gBAAgB,EAAA;;AAEpB;EACI,cAAc;EACd,uBAAuB;EAEvB,kBAAkB,EAAA;;AAEtB;EACI,aAAa;EACb,cAAc;EACd,8BAA8B;EAC9B,mBAAmB;EACnB,gCAAgC,EAAA;;AAEpC;EACI,aAAa;EACb,mBAAmB;EACnB,SAAS;EACT,sCAAsC;EACtC,2BAA2B,EAAA;;AAI/B;EACI,sBAAsB;EACtB,iDAAiD;EACjD,eAAe;EACf,cAAc;EACd,qBAAqB;EACrB,mBAAmB;EACnB,mBAAmB;EACnB,gBAAgB,EAAA;;AAEpB;EACI,eAAe;EACf,YAAY;EACZ,aAAa,EAAA;;AAEjB;EACI,eAAe;EACf,WAAW;EACX,iBAAiB;EACjB,2CAA2C;EAC3C,eAAe;EACf,iBAAgB,EAAA;;AAEpB;EACI,8BAA8B;EAC9B,0BAA0B;EAC1B,kBAAkB,EAAA;;AAGtB;EACI,eAAe;EACf,gBAAgB,EAAA;;AAGpB;EAEQ,4BAA4B,EAAA","sourcesContent":[".wholesalex_header {\r\n    .wholesalex_popup_menu{\r\n        position: absolute;\r\n        border-radius: 2px;\r\n        box-shadow: 0 2px 4px 0 rgba(108, 108, 255, 0.2);\r\n        background-color: #fff;\r\n        z-index: 999;\r\n        top: unset;\r\n        right: 6px;\r\n        padding: 15px;\r\n        margin-top: 30px;\r\n        min-width: 200px;\r\n        // animation: slide-in 0.3s ease-in-out;\r\n        &::before {\r\n            content: \"\";\r\n            content: \"\\f142\";\r\n            position: absolute;\r\n            right: 0px;\r\n            top: -29px;\r\n            font: normal 42px dashicons;\r\n            color: #fff;\r\n        }\r\n    }\r\n}\r\n\r\n\r\n.wholesalex_help_popup__link_label {\r\n    color: var(--wholesalex-heading-text-color);\r\n    text-decoration: none;\r\n    font-size: 14px;\r\n    line-height: 18px;\r\n\r\n    &:hover {\r\n        color: var(--wholesalex-primary-color);\r\n    }\r\n\r\n    &:focus {\r\n        outline: none;\r\n    }\r\n}\r\n.wholesalex_help_popup__links {\r\n    animation: fadeIn 0.3s ease;\r\n    margin: 0px;\r\n}\r\n@keyframes fadeIn {\r\n    from {\r\n      opacity: 0;\r\n    }\r\n    to {\r\n      opacity: 1;\r\n    }\r\n  }\r\n.wholesalex_help_popup__link {\r\n    text-decoration: none;\r\n    line-height: 1.5;\r\n}\r\n.wholesalex_help_popup__list {\r\n    display: flex;\r\n    gap: 9px;\r\n    text-align: left;\r\n    margin-bottom: 15px;\r\n\r\n    &:last-child{\r\n        margin-bottom: 0px;\r\n    }\r\n}\r\n.wholesalex_help_popup__list .wholesalex_icon{\r\n    font-size: 14px;\r\n    line-height: 18px;\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    padding: 5px 5px 4px;\r\n    background-color:var(--wholesalex-primary-color);\r\n    color: #ffffff;\r\n    border-radius: 50%;\r\n    width: 14px;\r\n    height: 15px;\r\n}\r\n@keyframes slide-in {\r\n    0% {\r\n      opacity: 0;\r\n      transform: translateY(-50%);\r\n    }\r\n    100% {\r\n      opacity: 1;\r\n      transform: translateY(0);\r\n    }\r\n}\r\n.wholesalex_logo {\r\n    max-height: 25px;\r\n}\r\n.wholesalex_header_wrapper {\r\n    display: block;\r\n    background-color: white;\r\n    // max-height: 50px;\r\n    text-align: center;\r\n}\r\n.wholesalex_header {\r\n    display: flex;\r\n    margin: 0 auto;\r\n    justify-content: space-between;\r\n    align-items: center;\r\n    border-bottom: 1px solid #e6e5e5;\r\n}\r\n.wholesalex_header__left {\r\n    display: flex;\r\n    align-items: center;\r\n    gap: 15px;\r\n    color: var(--wholesalex-primary-color);\r\n    padding: 14px 0px 14px 44px;\r\n\r\n}\r\n\r\n.wholesalex_version {\r\n    box-sizing: border-box;\r\n    border: 1px solid var(--wholesalex-primary-color);\r\n    font-size: 12px;\r\n    line-height: 1;\r\n    padding: 5px 10px 5px;\r\n    border-radius: 50px;\r\n    align-items: center;\r\n    font-weight: 600;\r\n}\r\n.wholesalex_right_arrow_icon {\r\n    font-size: 20px;\r\n    height: 20px;\r\n    margin: 0 5px;\r\n}\r\n.wholesalex_header_help_icon {\r\n    font-size: 40px;\r\n    width: 35px;\r\n    line-height: 18px;\r\n    color: var(--wholesalex-heading-text-color);\r\n    cursor: pointer;\r\n    padding:5px 20px;\r\n}\r\n.wholesalex_header__right{\r\n    border-left: 1px solid #e6e5e5;\r\n    padding: 14px 0px 14px 0px;\r\n    position: relative;\r\n\r\n}\r\n.wholesalex_header__title {\r\n    font-size: 14px;\r\n    font-weight: 600;\r\n}\r\n\r\n.wholesalex_backend_body.rtl{  \r\n    .wholesalex_header__left{\r\n        padding: 14px 44px 14px 44px;\r\n    }\r\n}"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/LoadingSpinner.scss":
/*!**********************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/LoadingSpinner.scss ***!
  \**********************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/sourceMaps.js */ "./node_modules/css-loader/dist/runtime/sourceMaps.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, `.wholesalex_circular_loading__wrapper {
  background-color: rgba(255, 255, 255, 0.5);
  bottom: 0;
  left: 0;
  margin: 0;
  position: absolute;
  right: 0;
  top: 0;
  transition: opacity 0.3s;
  z-index: 9999;
  cursor: wait; }

.wholesalex_loading_spinner {
  margin-top: -21px;
  position: absolute;
  text-align: center;
  top: 50%;
  width: 100%; }

.wholesalex_circular_loading_icon {
  stroke-dasharray: 90, 150;
  stroke-dashoffset: 0;
  stroke-width: 2;
  stroke: var(--wholesalex-primary-color);
  stroke-linecap: round;
  animation: wholesalex_circular_loading 1.5s ease-in-out infinite; }

@keyframes wholesalex_circular_loading {
  0% {
    stroke-dasharray: 1, 140;
    stroke-dashoffset: 0; } }

.wholesalex_loading_spinner .move_circular {
  animation: circular_rotate 2s linear infinite;
  height: 42px;
  width: 42px; }

@keyframes circular_rotate {
  100% {
    transform: rotate(1turn); } }
`, "",{"version":3,"sources":["webpack://./reactjs/src/assets/scss/LoadingSpinner.scss"],"names":[],"mappings":"AAAA;EACI,0CAAwC;EACxC,SAAS;EACT,OAAO;EACP,SAAS;EACT,kBAAkB;EAClB,QAAQ;EACR,MAAM;EACN,wBAAwB;EACxB,aAAa;EACb,YAAY,EAAA;;AAEhB;EACI,iBAAiB;EACjB,kBAAkB;EAClB,kBAAkB;EAClB,QAAQ;EACR,WAAW,EAAA;;AAEf;EACI,yBAAyB;EACzB,oBAAoB;EACpB,eAAe;EACf,uCAAuC;EACvC,qBAAqB;EACrB,gEAAgE,EAAA;;AAEpE;EACI;IACI,wBAAwB;IACxB,oBAAoB,EAAA,EAAA;;AAG5B;EACI,6CAA6C;EAC7C,YAAY;EACZ,WAAW,EAAA;;AAEf;EACI;IACI,wBAAwB,EAAA,EAAA","sourcesContent":[".wholesalex_circular_loading__wrapper {\r\n    background-color: hsla(0, 0%, 100%, 0.5);\r\n    bottom: 0;\r\n    left: 0;\r\n    margin: 0;\r\n    position: absolute;\r\n    right: 0;\r\n    top: 0;\r\n    transition: opacity 0.3s;\r\n    z-index: 9999;\r\n    cursor: wait;\r\n}\r\n.wholesalex_loading_spinner {\r\n    margin-top: -21px;\r\n    position: absolute;\r\n    text-align: center;\r\n    top: 50%;\r\n    width: 100%;\r\n}\r\n.wholesalex_circular_loading_icon {\r\n    stroke-dasharray: 90, 150;\r\n    stroke-dashoffset: 0;\r\n    stroke-width: 2;\r\n    stroke: var(--wholesalex-primary-color);\r\n    stroke-linecap: round;\r\n    animation: wholesalex_circular_loading 1.5s ease-in-out infinite;\r\n}\r\n@keyframes wholesalex_circular_loading {\r\n    0% {\r\n        stroke-dasharray: 1, 140;\r\n        stroke-dashoffset: 0;\r\n    }\r\n}\r\n.wholesalex_loading_spinner .move_circular {\r\n    animation: circular_rotate 2s linear infinite;\r\n    height: 42px;\r\n    width: 42px;\r\n}\r\n@keyframes circular_rotate {\r\n    100% {\r\n        transform: rotate(1turn);\r\n    }\r\n}"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/PopupMenu.scss":
/*!*****************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/PopupMenu.scss ***!
  \*****************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/sourceMaps.js */ "./node_modules/css-loader/dist/runtime/sourceMaps.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, `.wholesalex_popup_menu {
  position: absolute;
  border-radius: 4px;
  box-shadow: 0 2px 4px 0 rgba(108, 108, 255, 0.2);
  background-color: #fff;
  z-index: 999;
  top: 12px;
  right: 10px;
  border: solid 1px var(--wholesalex-border-color);
  padding: 0px 15px; }

.wholesalex_row_actions .wholesalex_popup_menu {
  min-width: 150px;
  right: 0;
  padding: 0px 12px; }

.wholesalex_popup_menu__wrapper {
  position: relative; }

.wholesalex_dropdown {
  cursor: pointer; }
`, "",{"version":3,"sources":["webpack://./reactjs/src/assets/scss/PopupMenu.scss"],"names":[],"mappings":"AAAA;EACI,kBAAkB;EAClB,kBAAkB;EAClB,gDAAgD;EAChD,sBAAsB;EACtB,YAAY;EACZ,SAAS;EACT,WAAW;EAGX,gDAAgD;EAChD,iBAAiB,EAAA;;AAErB;EAEQ,gBAAgB;EAChB,QAAQ;EACR,iBAAiB,EAAA;;AAIzB;EACI,kBAAkB,EAAA;;AAEtB;EACI,eAAe,EAAA","sourcesContent":[".wholesalex_popup_menu{\r\n    position: absolute;\r\n    border-radius: 4px;\r\n    box-shadow: 0 2px 4px 0 rgba(108, 108, 255, 0.2);\r\n    background-color: #fff;\r\n    z-index: 999;\r\n    top: 12px;\r\n    right: 10px;\r\n    // padding: 15px;\r\n    // animation: slide-in 0.3s ease-in-out;\r\n    border: solid 1px var(--wholesalex-border-color);\r\n    padding: 0px 15px;\r\n}\r\n.wholesalex_row_actions {\r\n    .wholesalex_popup_menu {\r\n        min-width: 150px;\r\n        right: 0;\r\n        padding: 0px 12px;\r\n    }\r\n}\r\n\r\n.wholesalex_popup_menu__wrapper {\r\n    position: relative;\r\n}\r\n.wholesalex_dropdown {\r\n    cursor: pointer;\r\n}"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Settings.scss":
/*!****************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Settings.scss ***!
  \****************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/sourceMaps.js */ "./node_modules/css-loader/dist/runtime/sourceMaps.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, `.wholesalex-choosebox > .wholesalex-settings-wrap {
  flex-direction: column;
  gap: 20px; }

.wholesalex_settings_tab_lists {
  text-align: left;
  max-width: 270px;
  background-color: rgba(108, 108, 255, 0.05);
  border-radius: 4px;
  margin: 0; }
  .wholesalex_settings_tab_lists li {
    margin: 0; }

.wholesalex_page_wholesalex-settings.rtl .wholesalex_settings_tab_lists {
  text-align: right; }

.wholesalex_page_wholesalex-settings.rtl .wholesalex_settings__fields {
  text-align: right; }

.wholesalex_settings_tab_list {
  padding: 20px 25px;
  border-bottom: 1px solid rgba(108, 108, 255, 0.12);
  cursor: pointer;
  min-width: 270px; }

.wholesalex_settings_tab_lists .wholesalex_active_tab {
  color: var(--wholesalex-primary-color);
  background-color: rgba(108, 108, 255, 0.06); }

.wholesalex_settings_tab__title {
  color: var(--wholesalex-heading-text-color);
  font-size: var(--wholesalex-size-14);
  line-height: var(--wholesalex-size-28);
  font-weight: 500; }

.wholesalex_settings__tab_heading {
  font-size: 20px;
  line-height: 28px;
  color: var(--wholesalex-heading-text-color);
  font-weight: bold; }

.wholesalex_settings__tab_header {
  background-color: white;
  padding: 20px 40px;
  text-align: left;
  border-bottom: 1px solid rgba(108, 108, 255, 0.2);
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-height: 28px; }

.wholesalex_settings_tab {
  box-shadow: 0 1px 2px 0 rgba(108, 108, 255, 0.1);
  background-color: #fff;
  width: 100%; }

.wholesalex_settings {
  display: flex; }

.wholesalex_settings_field_label, .wholesalex_field__label {
  font-size: 14px;
  font-weight: 500;
  line-height: 28px;
  text-align: left;
  color: var(--wholesalex-heading-text-color); }

.wholesalex_settings_field_content {
  font-size: 14px;
  line-height: 28px;
  color: var(--wholesalex-body-text-color); }

.wholesalex_settings__tab_content {
  padding: 30px 50px;
  margin: 0; }

.wholesalex_settings__fields {
  margin-bottom: 45px;
  text-align: left; }
  .wholesalex_settings__fields .wholesalex_switch_field, .wholesalex_settings__fields .wholesalex_input_field, .wholesalex_settings__fields .wholesalex_textarea_field, .wholesalex_settings__fields .wholesalex_select_field, .wholesalex_settings__fields .wholesalex_draglist_field, .wholesalex_settings__fields .wholesalex_shortcode_field {
    display: flex;
    gap: 5%; }
  .wholesalex_settings__fields .wholesalex_switch_field__label, .wholesalex_settings__fields .wholesalex_input_field__label, .wholesalex_settings__fields .wholesalex_textarea_field__label, .wholesalex_settings__fields .wholesalex_select_field__label, .wholesalex_settings__fields .wholesalex_draglist_field__label, .wholesalex_settings__fields .wholesalex_shortcode_field__label {
    width: 30%; }
  .wholesalex_settings__fields .wholesalex_switch_field__content, .wholesalex_settings__fields .wholesalex_input_field__content, .wholesalex_settings__fields .wholesalex_textarea_field__content, .wholesalex_settings__fields .wholesalex_select_field__content, .wholesalex_settings__fields .wholesalex_draglist_field__content {
    width: 60%; }
  .wholesalex_settings__fields .wholesalex_tooltip_icon {
    font-size: 20px;
    line-height: 26px;
    margin-top: 1px;
    color: var(--wholesalex-heading-text-color);
    cursor: pointer; }
  .wholesalex_settings__fields .wholesalex-tooltip-wrapper {
    width: 19px; }

.wholesalex_page_wholesalex-settings select {
  min-width: 250px; }

.wholesalex_field_desc {
  font-size: 14px;
  color: var(--wholesalex-body-text-color); }

.dashicons.wholesalex_not_migrated {
  color: #CDCFD5;
  font-size: 26px;
  width: 26px; }

.dashicons.wholesalex_migrated {
  color: var(--wholesalex-primary-color);
  font-size: 26px;
  width: 26px; }

.wholesalex_migration_field {
  display: flex;
  gap: 15px; }
  .wholesalex_migration_field .wholesalex_migration_field__label {
    font-size: 14px;
    font-weight: 500;
    text-align: left;
    color: var(--wholesalex-heading-text-color); }

.wholesalex_migration_tab__footer {
  border-top: 1px solid var(--wholesalex-border-color);
  padding: 25px;
  text-align: right; }

button.wholesalex-btn.wholesalex-migrate-button[disabled] {
  background-color: #e9e9ea;
  background-image: unset;
  color: #858689;
  cursor: not-allowed; }

.wholesalex_migration__alert {
  background-color: var(--wholesalex-warning-button-color) !important;
  color: white;
  font-size: 14px; }

.wholesalex_toast_message.wholesalex_migrating_notice {
  /* width: 100%; */
  max-width: 50%;
  margin: 0 auto;
  margin-top: 15px; }

.wholesalex_help_message .wholesalex_tooltip_icon {
  font-size: 14px; }

.wholesalex-smart-tags-wrapper {
  display: flex;
  flex-direction: column;
  gap: 5px;
  font-style: italic;
  color: var(--wholesalex-body-text-color); }

.wholesalex_settings_d_ynamic_rule_section_title {
  font-size: large; }

.wholesalex_settings_dynamic_rule_section_fields {
  border: 1px solid var(--wholesalex-border-color);
  padding-left: 15px;
  padding-top: 15px;
  margin-top: 15px; }

.wholesalex_switch_field.wholesalex_settings_field.wsx-plugin-delete-setting {
  border: 2px solid red;
  padding: 5px;
  border-radius: 8px;
  background-color: #ff9b9d; }

.wsx-plugin-delete-setting label.wholesalex_switch_field__desc.wholesalex_field_desc {
  color: #000000; }

textarea {
  width: 100%; }
`, "",{"version":3,"sources":["webpack://./reactjs/src/assets/scss/Settings.scss"],"names":[],"mappings":"AACA;EACI,sBAAsB;EACtB,SAAQ,EAAA;;AAGZ;EACI,gBAAgB;EAChB,gBAAgB;EAChB,2CAAwC;EACxC,kBAAkB;EAClB,SAAS,EAAA;EALb;IAQQ,SAAS,EAAA;;AAGjB;EAEQ,iBAAiB,EAAA;;AAFzB;EAKQ,iBAAiB,EAAA;;AAIzB;EAEI,kBAAiB;EACjB,kDAA+C;EAC/C,eAAe;EACf,gBAAgB,EAAA;;AAEpB;EACI,sCAAsC;EACtC,2CAAwC,EAAA;;AAE5C;EACI,2CAA2C;EAC3C,oCAAoC;EACpC,sCAAsC;EACtC,gBAAgB,EAAA;;AAEpB;EACI,eAAe;EACf,iBAAiB;EACjB,2CAA2C;EAC3C,iBAAiB,EAAA;;AAGrB;EACI,uBAAuB;EACvB,kBAAkB;EAClB,gBAAgB;EAChB,iDAAiD;EACjD,aAAa;EACb,mBAAmB;EACnB,8BAA8B;EAC9B,gBAAgB,EAAA;;AAGpB;EACI,gDAAgD;EAChD,sBAAsB;EACtB,WAAW,EAAA;;AAGf;EACI,aAAa,EAAA;;AAGjB;EACI,eAAe;EACf,gBAAgB;EAChB,iBAAiB;EACjB,gBAAgB;EAChB,2CAA2C,EAAA;;AAE/C;EACI,eAAe;EACf,iBAAiB;EACjB,wCAAwC,EAAA;;AAE5C;EACI,kBAAkB;EAClB,SAAS,EAAA;;AAEb;EACI,mBAAmB;EACnB,gBAAgB,EAAA;EAFpB;IAIQ,aAAa;IACb,OAAO,EAAA;EALf;IAQQ,UAAU,EAAA;EARlB;IAWQ,UAAU,EAAA;EAXlB;IAeQ,eAAe;IACf,iBAAiB;IACjB,eAAe;IACf,2CAA2C;IAC3C,eAAe,EAAA;EAnBvB;IAsBQ,WAAW,EAAA;;AAKnB;EACI,gBAAgB,EAAA;;AAGpB;EACI,eAAe;EACf,wCAAuC,EAAA;;AAE3C;EACI,cAAa;EACb,eAAe;EACf,WAAW,EAAA;;AAEf;EACI,sCAAqC;EACrC,eAAe;EACf,WAAW,EAAA;;AAEf;EACI,aAAa;EACb,SAAQ,EAAA;EAFZ;IAIQ,eAAe;IACf,gBAAgB;IAChB,gBAAgB;IAChB,2CAA2C,EAAA;;AAInD;EACI,oDAAoD;EACpD,aAAa;EACb,iBAAiB,EAAA;;AAGrB;EACI,yBAAyB;EACzB,uBAAuB;EACvB,cAAc;EACd,mBAAmB,EAAA;;AAEvB;EACI,mEAAmE;EACnE,YAAY;EACZ,eAAe,EAAA;;AAEnB;EACI,iBAAA;EACA,cAAc;EACd,cAAc;EACd,gBAAgB,EAAA;;AAEpB;EACI,eAAe,EAAA;;AAEnB;EACI,aAAa;EACb,sBAAsB;EACtB,QAAQ;EACR,kBAAkB;EAClB,wCAAwC,EAAA;;AAG5C;EACI,gBAAgB,EAAA;;AAEpB;EACI,gDAAgD;EAChD,kBAAkB;EAClB,iBAAiB;EACjB,gBAAgB,EAAA;;AAEpB;EACI,qBAAqB;EACrB,YAAY;EACZ,kBAAkB;EAClB,yBAAyB,EAAA;;AAE7B;EAEQ,cAAc,EAAA;;AAItB;EACI,WAAW,EAAA","sourcesContent":["\r\n.wholesalex-choosebox > .wholesalex-settings-wrap {\r\n    flex-direction: column;\r\n    gap:20px;\r\n}\r\n\r\n.wholesalex_settings_tab_lists {\r\n    text-align: left;\r\n    max-width: 270px;\r\n    background-color: rgba(108,108,255,0.05);\r\n    border-radius: 4px;\r\n    margin: 0;\r\n\r\n    li{\r\n        margin: 0;\r\n    }\r\n}\r\n.wholesalex_page_wholesalex-settings.rtl {\r\n    .wholesalex_settings_tab_lists{\r\n        text-align: right;\r\n    }\r\n    .wholesalex_settings__fields{\r\n        text-align: right;\r\n    }\r\n}\r\n\r\n.wholesalex_settings_tab_list{\r\n    // padding: 16px 25px; \r\n    padding:20px 25px;\r\n    border-bottom: 1px solid rgba(108,108,255,0.12);\r\n    cursor: pointer;\r\n    min-width: 270px;\r\n}\r\n.wholesalex_settings_tab_lists .wholesalex_active_tab {\r\n    color: var(--wholesalex-primary-color);\r\n    background-color: rgba(108,108,255,0.06);\r\n}\r\n.wholesalex_settings_tab__title{\r\n    color: var(--wholesalex-heading-text-color);\r\n    font-size: var(--wholesalex-size-14);\r\n    line-height: var(--wholesalex-size-28);\r\n    font-weight: 500;\r\n}\r\n.wholesalex_settings__tab_heading {\r\n    font-size: 20px;\r\n    line-height: 28px;\r\n    color: var(--wholesalex-heading-text-color);\r\n    font-weight: bold;\r\n}\r\n\r\n.wholesalex_settings__tab_header {\r\n    background-color: white;\r\n    padding: 20px 40px;\r\n    text-align: left;\r\n    border-bottom: 1px solid rgba(108, 108, 255, 0.2);\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: space-between;\r\n    max-height: 28px;\r\n}\r\n\r\n.wholesalex_settings_tab {\r\n    box-shadow: 0 1px 2px 0 rgba(108, 108, 255, 0.1);\r\n    background-color: #fff;\r\n    width: 100%;\r\n\r\n}\r\n.wholesalex_settings {\r\n    display: flex;\r\n}\r\n\r\n.wholesalex_settings_field_label,.wholesalex_field__label {\r\n    font-size: 14px;\r\n    font-weight: 500;\r\n    line-height: 28px;\r\n    text-align: left;\r\n    color: var(--wholesalex-heading-text-color);\r\n}\r\n.wholesalex_settings_field_content {\r\n    font-size: 14px;\r\n    line-height: 28px;\r\n    color: var(--wholesalex-body-text-color);\r\n}\r\n.wholesalex_settings__tab_content {\r\n    padding: 30px 50px;\r\n    margin: 0;\r\n}\r\n.wholesalex_settings__fields {\r\n    margin-bottom: 45px;\r\n    text-align: left;\r\n    .wholesalex_switch_field,.wholesalex_input_field,.wholesalex_textarea_field,.wholesalex_select_field,.wholesalex_draglist_field,.wholesalex_shortcode_field {\r\n        display: flex;\r\n        gap: 5%;\r\n    }\r\n    .wholesalex_switch_field__label,.wholesalex_input_field__label,.wholesalex_textarea_field__label,.wholesalex_select_field__label,.wholesalex_draglist_field__label,.wholesalex_shortcode_field__label{\r\n        width: 30%;\r\n    }\r\n    .wholesalex_switch_field__content,.wholesalex_input_field__content,.wholesalex_textarea_field__content,.wholesalex_select_field__content,.wholesalex_draglist_field__content {\r\n        width: 60%;\r\n    }\r\n\r\n    .wholesalex_tooltip_icon {\r\n        font-size: 20px;\r\n        line-height: 26px;\r\n        margin-top: 1px;\r\n        color: var(--wholesalex-heading-text-color);\r\n        cursor: pointer;\r\n    }\r\n    .wholesalex-tooltip-wrapper {\r\n        width: 19px;\r\n    }\r\n}\r\n\r\n\r\n.wholesalex_page_wholesalex-settings select {\r\n    min-width: 250px;\r\n}\r\n\r\n.wholesalex_field_desc{\r\n    font-size: 14px;\r\n    color:var(--wholesalex-body-text-color);\r\n}\r\n.dashicons.wholesalex_not_migrated{\r\n    color:#CDCFD5;\r\n    font-size: 26px;\r\n    width: 26px;\r\n}\r\n.dashicons.wholesalex_migrated{\r\n    color:var(--wholesalex-primary-color);\r\n    font-size: 26px;\r\n    width: 26px;\r\n}\r\n.wholesalex_migration_field {\r\n    display: flex;\r\n    gap:15px;\r\n    .wholesalex_migration_field__label{\r\n        font-size: 14px;\r\n        font-weight: 500;\r\n        text-align: left;\r\n        color: var(--wholesalex-heading-text-color);\r\n    }\r\n}\r\n\r\n.wholesalex_migration_tab__footer {\r\n    border-top: 1px solid var(--wholesalex-border-color);\r\n    padding: 25px;\r\n    text-align: right;\r\n}\r\n\r\nbutton.wholesalex-btn.wholesalex-migrate-button[disabled] {\r\n    background-color: #e9e9ea;\r\n    background-image: unset;\r\n    color: #858689;\r\n    cursor: not-allowed;\r\n}\r\n.wholesalex_migration__alert {\r\n    background-color: var(--wholesalex-warning-button-color) !important;\r\n    color: white;\r\n    font-size: 14px;\r\n}\r\n.wholesalex_toast_message.wholesalex_migrating_notice {\r\n    /* width: 100%; */\r\n    max-width: 50%;\r\n    margin: 0 auto;\r\n    margin-top: 15px;\r\n}\r\n.wholesalex_help_message .wholesalex_tooltip_icon {\r\n    font-size: 14px;\r\n}\r\n.wholesalex-smart-tags-wrapper {\r\n    display: flex;\r\n    flex-direction: column;\r\n    gap: 5px;\r\n    font-style: italic;\r\n    color: var(--wholesalex-body-text-color);\r\n}\r\n\r\n.wholesalex_settings_d_ynamic_rule_section_title {\r\n    font-size: large;\r\n}\r\n.wholesalex_settings_dynamic_rule_section_fields {\r\n    border: 1px solid var(--wholesalex-border-color);\r\n    padding-left: 15px;\r\n    padding-top: 15px;\r\n    margin-top: 15px;\r\n}\r\n.wholesalex_switch_field.wholesalex_settings_field.wsx-plugin-delete-setting {\r\n    border: 2px solid red;\r\n    padding: 5px;\r\n    border-radius: 8px;\r\n    background-color: #ff9b9d;\r\n}\r\n.wsx-plugin-delete-setting{\r\n    label.wholesalex_switch_field__desc.wholesalex_field_desc{\r\n        color: #000000;\r\n    }\r\n\r\n}\r\ntextarea{\r\n    width: 100%;\r\n}"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Toast.scss":
/*!*************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Toast.scss ***!
  \*************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/sourceMaps.js */ "./node_modules/css-loader/dist/runtime/sourceMaps.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_sourceMaps_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, `.wholesalex_toast_messages {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 10px;
  position: fixed;
  right: 0px;
  z-index: 999999;
  top: 85px; }

.wholesalex_toast {
  position: absolute; }

.wholesalex-toaster {
  position: fixed;
  visibility: hidden;
  width: 345px;
  background-color: #fefefe;
  height: 76px;
  border-radius: 4px;
  box-shadow: 0px 0px 4px #9f9f9f;
  display: flex;
  align-items: center; }
  .wholesalex-toaster span {
    display: block; }
  .wholesalex-toaster .itm-center {
    font-size: var(--wholesalex-size-14); }
  .wholesalex-toaster .itm-last {
    padding: 0 15px;
    margin-left: auto;
    height: 100%;
    display: flex;
    align-items: center;
    border-left: 1px solid #f2f2f2; }
    .wholesalex-toaster .itm-last:hover {
      cursor: pointer;
      background-color: #f2f2f2; }
  .wholesalex-toaster.show {
    visibility: visible;
    -webkit-animation: fadeinmessage 0.5s;
    animation: fadeinmessage 0.5s; }

@keyframes fadeinmessage {
  from {
    right: 0;
    opacity: 0; }
  to {
    right: 55px;
    opacity: 1; } }

@keyframes slidefromright {
  from {
    transform: translateX(70px); }
  from {
    transform: translateX(-172px); } }

.wholesalex__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: #7ac142;
  fill: none;
  animation: strokemessage 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards; }

.wholesalex-animation {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  display: block;
  stroke-width: 2;
  margin: 10px;
  stroke: #fff;
  stroke-miterlimit: 10;
  box-shadow: inset 0px 0px 0px #7ac142;
  animation: fillmessage .4s ease-in-out .4s forwards, scalemessage .3s ease-in-out .9s both;
  margin-right: 10px; }

.wholesalex__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: strokemessage 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards; }

.wholesalex__cross {
  stroke: red;
  fill: red; }

@keyframes strokemessage {
  100% {
    stroke-dashoffset: 0; } }

@keyframes scalemessage {
  0%, 100% {
    transform: none; }
  50% {
    transform: scale3d(1.1, 1.1, 1); } }

@keyframes fillmessage {
  100% {
    box-shadow: inset 0px 0px 0px 30px #7ac142; } }

.wholesalex_toast_message {
  padding: 13px 14px 14px 15px;
  border-radius: 4px;
  box-shadow: 0 1px 2px 0 rgba(108, 108, 255, 0.2);
  background-color: #fff;
  display: flex;
  max-width: 380px;
  align-items: center;
  justify-content: center;
  min-width: 15vw; }
  .wholesalex_toast_message.show {
    visibility: visible;
    -webkit-animation: fadeinmessage 0.5s;
    animation: fadeinmessage 0.5s; }
  .wholesalex_toast_message .toast_close {
    color: #091f36;
    font-size: 18px;
    width: 18px;
    height: 19px;
    margin-left: auto;
    cursor: pointer; }
    .wholesalex_toast_message .toast_close:hover {
      color: #690808; }

.wsx-error {
  padding: 13px 14px 14px 15px;
  border-left: 3px solid #d63638;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04); }

span.dashicons.dashicons-smiley {
  font-size: 22px;
  line-height: 28px;
  color: #24be2a;
  width: 22px;
  height: auto;
  margin-right: 10px; }

span.message {
  font-size: 14px;
  line-height: 28px;
  color: #091f36; }

.top_right {
  right: 50px;
  top: 16%;
  animation: toast_slide_from_right 0.7s; }

@keyframes toast_slide_from_right {
  from {
    transform: translateX(100%); }
  to {
    translate: translateX(0); } }

.wholesalex_delete_toast {
  transition: all 0.7s;
  transform: translateX(50%);
  opacity: 0; }
`, "",{"version":3,"sources":["webpack://./reactjs/src/assets/scss/Toast.scss"],"names":[],"mappings":"AAAA;EACI,aAAa;EACb,sBAAsB;EACtB,SAAS;EACT,aAAa;EACb,eAAe;EACf,UAAU;EACV,eAAe;EACf,SAAS,EAAA;;AAEb;EACI,kBAAkB,EAAA;;AAEtB;EACI,eAAe;EACf,kBAAkB;EAElB,YAAY;EACZ,yBAAyB;EACzB,YAAY;EACZ,kBAAkB;EAClB,+BAA+B;EAC/B,aAAa;EACb,mBAAmB,EAAA;EAVvB;IAYQ,cAAc,EAAA;EAZtB;IAeQ,oCAAoC,EAAA;EAf5C;IAkBQ,eAAe;IACf,iBAAiB;IACjB,YAAY;IACZ,aAAa;IACb,mBAAmB;IACnB,8BAA8B,EAAA;IAvBtC;MAyBY,eAAe;MACf,yBAAyB,EAAA;EA1BrC;IA8BQ,mBAAmB;IACnB,qCAAqC;IACrC,6BAA6B,EAAA;;AAGrC;EACI;IAAM,QAAQ;IAAE,UAAU,EAAA;EAC1B;IAAI,WAAW;IAAE,UAAU,EAAA,EAAA;;AAG/B;EACI;IAEK,2BAA2B,EAAA;EAGhC;IAEK,6BAA6B,EAAA,EAAA;;AAKtC;EACI,qBAAqB;EACrB,sBAAsB;EACtB,eAAe;EACf,qBAAqB;EACrB,eAAe;EACf,UAAU;EACV,qEAAqE,EAAA;;AAGzE;EACI,WAAW;EACX,YAAY;EACZ,kBAAkB;EAClB,cAAc;EACd,eAAe;EACf,YAAY;EACZ,YAAY;EACZ,qBAAqB;EACrB,qCAAqC;EACrC,0FAA0F;EAC1F,kBAAkB,EAAA;;AAGtB;EACI,yBAAyB;EACzB,oBAAoB;EACpB,qBAAqB;EACrB,0EAA0E,EAAA;;AAG9E;EACI,WAAW;EACX,SAAS,EAAA;;AAGb;EACI;IACI,oBAAoB,EAAA,EAAA;;AAG5B;EACI;IACI,eAAe,EAAA;EAEnB;IACI,+BAA+B,EAAA,EAAA;;AAGvC;EACI;IACI,0CAA0C,EAAA,EAAA;;AAIlD;EACI,4BAA4B;EAC5B,kBAAkB;EAClB,gDAAgD;EAChD,sBAAsB;EACtB,aAAa;EACb,gBAAgB;EAChB,mBAAmB;EACnB,uBAAuB;EACvB,eAAe,EAAA;EATnB;IAYQ,mBAAmB;IACnB,qCAAqC;IACrC,6BAA6B,EAAA;EAdrC;IAkBQ,cAAc;IACd,eAAe;IACf,WAAW;IACX,YAAY;IACZ,iBAAiB;IACjB,eAAe,EAAA;IAvBvB;MA0BY,cAAc,EAAA;;AAM1B;EACI,4BAA4B;EAC5B,8BAA8B;EAC9B,yCAAqC,EAAA;;AAGzC;EACI,eAAe;EACf,iBAAiB;EACjB,cAAc;EACd,WAAW;EACX,YAAY;EACZ,kBAAkB,EAAA;;AAGtB;EACI,eAAe;EACf,iBAAiB;EACjB,cAAc,EAAA;;AAGlB;EACI,WAAW;EACX,QAAQ;EACR,sCAAsC,EAAA;;AAG1C;EACI;IACE,2BAA2B,EAAA;EAE7B;IACE,wBAAwB,EAAA,EAAA;;AAI5B;EACE,oBAAmB;EACnB,0BAAyB;EACzB,UAAS,EAAA","sourcesContent":[".wholesalex_toast_messages {\r\n    display: flex;\r\n    flex-direction: column;\r\n    gap: 10px;\r\n    padding: 10px;\r\n    position: fixed;\r\n    right: 0px;\r\n    z-index: 999999;\r\n    top: 85px;\r\n}\r\n.wholesalex_toast{\r\n    position: absolute;\r\n}\r\n.wholesalex-toaster{\r\n    position: fixed;\r\n    visibility: hidden;\r\n\r\n    width: 345px;\r\n    background-color: #fefefe;\r\n    height: 76px;\r\n    border-radius: 4px;\r\n    box-shadow: 0px 0px 4px #9f9f9f;\r\n    display: flex;\r\n    align-items: center;\r\n    span{\r\n        display: block;\r\n    }\r\n    .itm-center{\r\n        font-size: var(--wholesalex-size-14);\r\n    }\r\n    .itm-last{\r\n        padding: 0 15px;\r\n        margin-left: auto;\r\n        height: 100%;\r\n        display: flex;\r\n        align-items: center;\r\n        border-left: 1px solid #f2f2f2;;\r\n        &:hover{\r\n            cursor: pointer;\r\n            background-color: #f2f2f2;\r\n        }\r\n    }\r\n    &.show{\r\n        visibility: visible;\r\n        -webkit-animation: fadeinmessage 0.5s;\r\n        animation: fadeinmessage 0.5s;\r\n    }\r\n}\r\n@keyframes fadeinmessage {\r\n    from {right: 0; opacity: 0;}\r\n    to {right: 55px; opacity: 1;}\r\n}\r\n\r\n@keyframes slidefromright {\r\n    from {\r\n\r\n         transform: translateX(70px)\r\n        \r\n        }\r\n    from {\r\n\r\n         transform: translateX(-172px)\r\n        \r\n        }\r\n}\r\n\r\n.wholesalex__circle {\r\n    stroke-dasharray: 166;\r\n    stroke-dashoffset: 166;\r\n    stroke-width: 2;\r\n    stroke-miterlimit: 10;\r\n    stroke: #7ac142;\r\n    fill: none;\r\n    animation: strokemessage 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;\r\n}\r\n\r\n.wholesalex-animation {\r\n    width: 45px;\r\n    height: 45px;\r\n    border-radius: 50%;\r\n    display: block;\r\n    stroke-width: 2;\r\n    margin: 10px;\r\n    stroke: #fff;\r\n    stroke-miterlimit: 10;\r\n    box-shadow: inset 0px 0px 0px #7ac142;\r\n    animation: fillmessage .4s ease-in-out .4s forwards, scalemessage .3s ease-in-out .9s both;\r\n    margin-right: 10px;\r\n}\r\n\r\n.wholesalex__check {\r\n    transform-origin: 50% 50%;\r\n    stroke-dasharray: 48;\r\n    stroke-dashoffset: 48;\r\n    animation: strokemessage 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;\r\n}\r\n\r\n.wholesalex__cross {\r\n    stroke: red;\r\n    fill: red;\r\n}\r\n\r\n@keyframes strokemessage {\r\n    100% {\r\n        stroke-dashoffset: 0;\r\n    }\r\n}\r\n@keyframes scalemessage {\r\n    0%, 100% {\r\n        transform: none;\r\n    }\r\n    50% {\r\n        transform: scale3d(1.1, 1.1, 1);\r\n    }\r\n}\r\n@keyframes fillmessage {\r\n    100% {\r\n        box-shadow: inset 0px 0px 0px 30px #7ac142;\r\n    }\r\n}\r\n\r\n.wholesalex_toast_message {\r\n    padding: 13px 14px 14px 15px;\r\n    border-radius: 4px;\r\n    box-shadow: 0 1px 2px 0 rgba(108, 108, 255, 0.2);\r\n    background-color: #fff;\r\n    display: flex;\r\n    max-width: 380px;\r\n    align-items: center;\r\n    justify-content: center;\r\n    min-width: 15vw;\r\n\r\n    &.show{\r\n        visibility: visible;\r\n        -webkit-animation: fadeinmessage 0.5s;\r\n        animation: fadeinmessage 0.5s;\r\n    }\r\n\r\n    .toast_close {\r\n        color: #091f36;\r\n        font-size: 18px;\r\n        width: 18px;\r\n        height: 19px;\r\n        margin-left: auto;\r\n        cursor: pointer;\r\n\r\n        &:hover{\r\n            color: #690808;\r\n\r\n        }\r\n    }\r\n    \r\n}\r\n.wsx-error{\r\n    padding: 13px 14px 14px 15px;\r\n    border-left: 3px solid #d63638;\r\n    box-shadow: 0 1px 1px rgba(0,0,0,.04);\r\n}\r\n\r\nspan.dashicons.dashicons-smiley {\r\n    font-size: 22px;\r\n    line-height: 28px;\r\n    color: #24be2a;\r\n    width: 22px;\r\n    height: auto;\r\n    margin-right: 10px;\r\n}\r\n\r\nspan.message {\r\n    font-size: 14px;\r\n    line-height: 28px;\r\n    color: #091f36;\r\n}\r\n\r\n.top_right {\r\n    right: 50px;\r\n    top: 16%;\r\n    animation: toast_slide_from_right 0.7s;\r\n}\r\n\r\n@keyframes toast_slide_from_right {\r\n    from {\r\n      transform: translateX(100%);\r\n    }\r\n    to {\r\n      translate: translateX(0);\r\n    }\r\n  }\r\n  \r\n  .wholesalex_delete_toast {\r\n    transition:all 0.7s;\r\n    transform:translateX(50%);\r\n    opacity:0;\r\n  }"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {



/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
module.exports = function (cssWithMappingToString) {
  var list = [];

  // return the list of modules as css string
  list.toString = function toString() {
    return this.map(function (item) {
      var content = "";
      var needLayer = typeof item[5] !== "undefined";
      if (item[4]) {
        content += "@supports (".concat(item[4], ") {");
      }
      if (item[2]) {
        content += "@media ".concat(item[2], " {");
      }
      if (needLayer) {
        content += "@layer".concat(item[5].length > 0 ? " ".concat(item[5]) : "", " {");
      }
      content += cssWithMappingToString(item);
      if (needLayer) {
        content += "}";
      }
      if (item[2]) {
        content += "}";
      }
      if (item[4]) {
        content += "}";
      }
      return content;
    }).join("");
  };

  // import a list of modules into the list
  list.i = function i(modules, media, dedupe, supports, layer) {
    if (typeof modules === "string") {
      modules = [[null, modules, undefined]];
    }
    var alreadyImportedModules = {};
    if (dedupe) {
      for (var k = 0; k < this.length; k++) {
        var id = this[k][0];
        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }
    for (var _k = 0; _k < modules.length; _k++) {
      var item = [].concat(modules[_k]);
      if (dedupe && alreadyImportedModules[item[0]]) {
        continue;
      }
      if (typeof layer !== "undefined") {
        if (typeof item[5] === "undefined") {
          item[5] = layer;
        } else {
          item[1] = "@layer".concat(item[5].length > 0 ? " ".concat(item[5]) : "", " {").concat(item[1], "}");
          item[5] = layer;
        }
      }
      if (media) {
        if (!item[2]) {
          item[2] = media;
        } else {
          item[1] = "@media ".concat(item[2], " {").concat(item[1], "}");
          item[2] = media;
        }
      }
      if (supports) {
        if (!item[4]) {
          item[4] = "".concat(supports);
        } else {
          item[1] = "@supports (".concat(item[4], ") {").concat(item[1], "}");
          item[4] = supports;
        }
      }
      list.push(item);
    }
  };
  return list;
};

/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/sourceMaps.js":
/*!************************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/sourceMaps.js ***!
  \************************************************************/
/***/ ((module) => {



module.exports = function (item) {
  var content = item[1];
  var cssMapping = item[3];
  if (!cssMapping) {
    return content;
  }
  if (typeof btoa === "function") {
    var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(cssMapping))));
    var data = "sourceMappingURL=data:application/json;charset=utf-8;base64,".concat(base64);
    var sourceMapping = "/*# ".concat(data, " */");
    return [content].concat([sourceMapping]).join("\n");
  }
  return [content].join("\n");
};

/***/ }),

/***/ "./reactjs/src/assets/scss/Header.scss":
/*!*********************************************!*\
  !*** ./reactjs/src/assets/scss/Header.scss ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleDomAPI.js */ "./node_modules/style-loader/dist/runtime/styleDomAPI.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertBySelector.js */ "./node_modules/style-loader/dist/runtime/insertBySelector.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js */ "./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertStyleElement.js */ "./node_modules/style-loader/dist/runtime/insertStyleElement.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleTagTransform.js */ "./node_modules/style-loader/dist/runtime/styleTagTransform.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Header_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js!../../../../node_modules/sass-loader/dist/cjs.js!./Header.scss */ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Header.scss");

      
      
      
      
      
      
      
      
      

var options = {};

options.styleTagTransform = (_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default());
options.setAttributes = (_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default());

      options.insert = _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default().bind(null, "head");
    
options.domAPI = (_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default());
options.insertStyleElement = (_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default());

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Header_scss__WEBPACK_IMPORTED_MODULE_6__["default"], options);




       /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Header_scss__WEBPACK_IMPORTED_MODULE_6__["default"] && _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Header_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals ? _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Header_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals : undefined);


/***/ }),

/***/ "./reactjs/src/assets/scss/LoadingSpinner.scss":
/*!*****************************************************!*\
  !*** ./reactjs/src/assets/scss/LoadingSpinner.scss ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleDomAPI.js */ "./node_modules/style-loader/dist/runtime/styleDomAPI.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertBySelector.js */ "./node_modules/style-loader/dist/runtime/insertBySelector.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js */ "./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertStyleElement.js */ "./node_modules/style-loader/dist/runtime/insertStyleElement.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleTagTransform.js */ "./node_modules/style-loader/dist/runtime/styleTagTransform.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_LoadingSpinner_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js!../../../../node_modules/sass-loader/dist/cjs.js!./LoadingSpinner.scss */ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/LoadingSpinner.scss");

      
      
      
      
      
      
      
      
      

var options = {};

options.styleTagTransform = (_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default());
options.setAttributes = (_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default());

      options.insert = _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default().bind(null, "head");
    
options.domAPI = (_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default());
options.insertStyleElement = (_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default());

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_LoadingSpinner_scss__WEBPACK_IMPORTED_MODULE_6__["default"], options);




       /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_LoadingSpinner_scss__WEBPACK_IMPORTED_MODULE_6__["default"] && _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_LoadingSpinner_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals ? _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_LoadingSpinner_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals : undefined);


/***/ }),

/***/ "./reactjs/src/assets/scss/PopupMenu.scss":
/*!************************************************!*\
  !*** ./reactjs/src/assets/scss/PopupMenu.scss ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleDomAPI.js */ "./node_modules/style-loader/dist/runtime/styleDomAPI.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertBySelector.js */ "./node_modules/style-loader/dist/runtime/insertBySelector.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js */ "./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertStyleElement.js */ "./node_modules/style-loader/dist/runtime/insertStyleElement.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleTagTransform.js */ "./node_modules/style-loader/dist/runtime/styleTagTransform.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_PopupMenu_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js!../../../../node_modules/sass-loader/dist/cjs.js!./PopupMenu.scss */ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/PopupMenu.scss");

      
      
      
      
      
      
      
      
      

var options = {};

options.styleTagTransform = (_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default());
options.setAttributes = (_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default());

      options.insert = _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default().bind(null, "head");
    
options.domAPI = (_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default());
options.insertStyleElement = (_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default());

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_PopupMenu_scss__WEBPACK_IMPORTED_MODULE_6__["default"], options);




       /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_PopupMenu_scss__WEBPACK_IMPORTED_MODULE_6__["default"] && _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_PopupMenu_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals ? _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_PopupMenu_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals : undefined);


/***/ }),

/***/ "./reactjs/src/assets/scss/Settings.scss":
/*!***********************************************!*\
  !*** ./reactjs/src/assets/scss/Settings.scss ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleDomAPI.js */ "./node_modules/style-loader/dist/runtime/styleDomAPI.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertBySelector.js */ "./node_modules/style-loader/dist/runtime/insertBySelector.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js */ "./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertStyleElement.js */ "./node_modules/style-loader/dist/runtime/insertStyleElement.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleTagTransform.js */ "./node_modules/style-loader/dist/runtime/styleTagTransform.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Settings_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js!../../../../node_modules/sass-loader/dist/cjs.js!./Settings.scss */ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Settings.scss");

      
      
      
      
      
      
      
      
      

var options = {};

options.styleTagTransform = (_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default());
options.setAttributes = (_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default());

      options.insert = _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default().bind(null, "head");
    
options.domAPI = (_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default());
options.insertStyleElement = (_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default());

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Settings_scss__WEBPACK_IMPORTED_MODULE_6__["default"], options);




       /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Settings_scss__WEBPACK_IMPORTED_MODULE_6__["default"] && _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Settings_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals ? _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Settings_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals : undefined);


/***/ }),

/***/ "./reactjs/src/assets/scss/Toast.scss":
/*!********************************************!*\
  !*** ./reactjs/src/assets/scss/Toast.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleDomAPI.js */ "./node_modules/style-loader/dist/runtime/styleDomAPI.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertBySelector.js */ "./node_modules/style-loader/dist/runtime/insertBySelector.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js */ "./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/insertStyleElement.js */ "./node_modules/style-loader/dist/runtime/insertStyleElement.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/styleTagTransform.js */ "./node_modules/style-loader/dist/runtime/styleTagTransform.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Toast_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js!../../../../node_modules/sass-loader/dist/cjs.js!./Toast.scss */ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./reactjs/src/assets/scss/Toast.scss");

      
      
      
      
      
      
      
      
      

var options = {};

options.styleTagTransform = (_node_modules_style_loader_dist_runtime_styleTagTransform_js__WEBPACK_IMPORTED_MODULE_5___default());
options.setAttributes = (_node_modules_style_loader_dist_runtime_setAttributesWithoutAttributes_js__WEBPACK_IMPORTED_MODULE_3___default());

      options.insert = _node_modules_style_loader_dist_runtime_insertBySelector_js__WEBPACK_IMPORTED_MODULE_2___default().bind(null, "head");
    
options.domAPI = (_node_modules_style_loader_dist_runtime_styleDomAPI_js__WEBPACK_IMPORTED_MODULE_1___default());
options.insertStyleElement = (_node_modules_style_loader_dist_runtime_insertStyleElement_js__WEBPACK_IMPORTED_MODULE_4___default());

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Toast_scss__WEBPACK_IMPORTED_MODULE_6__["default"], options);




       /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Toast_scss__WEBPACK_IMPORTED_MODULE_6__["default"] && _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Toast_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals ? _node_modules_css_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_Toast_scss__WEBPACK_IMPORTED_MODULE_6__["default"].locals : undefined);


/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module) => {



var stylesInDOM = [];
function getIndexByIdentifier(identifier) {
  var result = -1;
  for (var i = 0; i < stylesInDOM.length; i++) {
    if (stylesInDOM[i].identifier === identifier) {
      result = i;
      break;
    }
  }
  return result;
}
function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];
  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var indexByIdentifier = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3],
      supports: item[4],
      layer: item[5]
    };
    if (indexByIdentifier !== -1) {
      stylesInDOM[indexByIdentifier].references++;
      stylesInDOM[indexByIdentifier].updater(obj);
    } else {
      var updater = addElementStyle(obj, options);
      options.byIndex = i;
      stylesInDOM.splice(i, 0, {
        identifier: identifier,
        updater: updater,
        references: 1
      });
    }
    identifiers.push(identifier);
  }
  return identifiers;
}
function addElementStyle(obj, options) {
  var api = options.domAPI(options);
  api.update(obj);
  var updater = function updater(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap && newObj.supports === obj.supports && newObj.layer === obj.layer) {
        return;
      }
      api.update(obj = newObj);
    } else {
      api.remove();
    }
  };
  return updater;
}
module.exports = function (list, options) {
  options = options || {};
  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];
    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDOM[index].references--;
    }
    var newLastIdentifiers = modulesToDom(newList, options);
    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];
      var _index = getIndexByIdentifier(_identifier);
      if (stylesInDOM[_index].references === 0) {
        stylesInDOM[_index].updater();
        stylesInDOM.splice(_index, 1);
      }
    }
    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/insertBySelector.js":
/*!********************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/insertBySelector.js ***!
  \********************************************************************/
/***/ ((module) => {



var memo = {};

/* istanbul ignore next  */
function getTarget(target) {
  if (typeof memo[target] === "undefined") {
    var styleTarget = document.querySelector(target);

    // Special case to return head of iframe instead of iframe itself
    if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
      try {
        // This will throw an exception if access to iframe is blocked
        // due to cross-origin restrictions
        styleTarget = styleTarget.contentDocument.head;
      } catch (e) {
        // istanbul ignore next
        styleTarget = null;
      }
    }
    memo[target] = styleTarget;
  }
  return memo[target];
}

/* istanbul ignore next  */
function insertBySelector(insert, style) {
  var target = getTarget(insert);
  if (!target) {
    throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
  }
  target.appendChild(style);
}
module.exports = insertBySelector;

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/insertStyleElement.js":
/*!**********************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/insertStyleElement.js ***!
  \**********************************************************************/
/***/ ((module) => {



/* istanbul ignore next  */
function insertStyleElement(options) {
  var element = document.createElement("style");
  options.setAttributes(element, options.attributes);
  options.insert(element, options.options);
  return element;
}
module.exports = insertStyleElement;

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js ***!
  \**********************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



/* istanbul ignore next  */
function setAttributesWithoutAttributes(styleElement) {
  var nonce =  true ? __webpack_require__.nc : 0;
  if (nonce) {
    styleElement.setAttribute("nonce", nonce);
  }
}
module.exports = setAttributesWithoutAttributes;

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/styleDomAPI.js":
/*!***************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/styleDomAPI.js ***!
  \***************************************************************/
/***/ ((module) => {



/* istanbul ignore next  */
function apply(styleElement, options, obj) {
  var css = "";
  if (obj.supports) {
    css += "@supports (".concat(obj.supports, ") {");
  }
  if (obj.media) {
    css += "@media ".concat(obj.media, " {");
  }
  var needLayer = typeof obj.layer !== "undefined";
  if (needLayer) {
    css += "@layer".concat(obj.layer.length > 0 ? " ".concat(obj.layer) : "", " {");
  }
  css += obj.css;
  if (needLayer) {
    css += "}";
  }
  if (obj.media) {
    css += "}";
  }
  if (obj.supports) {
    css += "}";
  }
  var sourceMap = obj.sourceMap;
  if (sourceMap && typeof btoa !== "undefined") {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  }

  // For old IE
  /* istanbul ignore if  */
  options.styleTagTransform(css, styleElement, options.options);
}
function removeStyleElement(styleElement) {
  // istanbul ignore if
  if (styleElement.parentNode === null) {
    return false;
  }
  styleElement.parentNode.removeChild(styleElement);
}

/* istanbul ignore next  */
function domAPI(options) {
  if (typeof document === "undefined") {
    return {
      update: function update() {},
      remove: function remove() {}
    };
  }
  var styleElement = options.insertStyleElement(options);
  return {
    update: function update(obj) {
      apply(styleElement, options, obj);
    },
    remove: function remove() {
      removeStyleElement(styleElement);
    }
  };
}
module.exports = domAPI;

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/styleTagTransform.js":
/*!*********************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/styleTagTransform.js ***!
  \*********************************************************************/
/***/ ((module) => {



/* istanbul ignore next  */
function styleTagTransform(css, styleElement) {
  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css;
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild);
    }
    styleElement.appendChild(document.createTextNode(css));
  }
}
module.exports = styleTagTransform;

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = React;

/***/ }),

/***/ "react-dom":
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/***/ ((module) => {

module.exports = ReactDOM;

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
/******/ 			id: moduleId,
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
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	/* webpack/runtime/nonce */
/******/ 	(() => {
/******/ 		__webpack_require__.nc = undefined;
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*****************************************************!*\
  !*** ./reactjs/src/pages/migration_plugin/index.js ***!
  \*****************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_Header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../components/Header */ "./reactjs/src/components/Header.js");
/* harmony import */ var _context_toastContent__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../context/toastContent */ "./reactjs/src/context/toastContent.js");
/* harmony import */ var _Migration__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Migration */ "./reactjs/src/pages/migration_plugin/Migration.js");





document.addEventListener("DOMContentLoaded", function () {
  if (document.body.contains(document.getElementById('wholesalex_tools_root'))) {
    react_dom__WEBPACK_IMPORTED_MODULE_1___default().render( /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().StrictMode), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_context_toastContent__WEBPACK_IMPORTED_MODULE_3__.ToastContextProvider, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_components_Header__WEBPACK_IMPORTED_MODULE_2__["default"], {
      title: 'Tools'
    }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_Migration__WEBPACK_IMPORTED_MODULE_4__["default"], null))), document.getElementById('wholesalex_tools_root'));
  }
});
document.addEventListener("DOMContentLoaded", function () {
  if (document.body.contains(document.getElementById('wholesalex_migration_tools_root'))) {
    react_dom__WEBPACK_IMPORTED_MODULE_1___default().render( /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().StrictMode), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_context_toastContent__WEBPACK_IMPORTED_MODULE_3__.ToastContextProvider, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_components_Header__WEBPACK_IMPORTED_MODULE_2__["default"], {
      title: 'Migration Tools'
    }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_Migration__WEBPACK_IMPORTED_MODULE_4__["default"], null))), document.getElementById('wholesalex_migration_tools_root'));
  }
});
console.log('gggggggggg');
})();

/******/ })()
;
//# sourceMappingURL=whx_migration_tools.js.map