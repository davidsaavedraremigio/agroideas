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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/AdminLTE/build/scss/AdminLTE.scss":
/*!*****************************************************!*\
  !*** ./resources/AdminLTE/build/scss/AdminLTE.scss ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/js/config-app.js":
/*!************************************!*\
  !*** ./resources/js/config-app.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var root = window.location.host;
  var urlApp = "{{ env('APP_URL') }}";
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  }); //2. Configuramos el buscador en los select

  $('.select2').select2({
    theme: 'bootstrap4'
  }); //3. Configuramos un combo dinamico para el ubigeo

  $('#inputRegion').on('change', function (e) {
    console.log(e);
    var region_id = e.target.value;
    $.get(urlApp + '/ubigeo/provincia/' + region_id, function (data) {
      $("#inputProvincia").prop("disabled", false);
      $("#inputProvincia").empty();
      $("#inputProvincia").append('<option value="" selected="selected">Seleccionar</option>');
      $.each(data, function (index, provinciaObj) {
        $("#inputProvincia").append('<option value="' + provinciaObj.id + '">' + provinciaObj.nombre + '</option>');
      });
    });
  });
  $('#inputProvincia').on('change', function (e) {
    console.log(e);
    var provincia_id = e.target.value;
    $.get(urlApp + '/ubigeo/distrito/' + provincia_id, function (data) {
      // console.log(data);
      $("#inputDistrito").prop("disabled", false);
      $("#inputDistrito").empty();
      $("#inputDistrito").append('<option value="" selected="selected">Seleccionar</option>');
      $.each(data, function (index, distritoObj) {
        $("#inputDistrito").append('<option value="' + distritoObj.id + '">' + distritoObj.nombre + '</option>');
      });
    });
  }); //4.Configuramos un combo dinamico para la caracterizacion

  $('#inputSector').on('change', function (e) {
    console.log(e);
    var sector_id = e.target.value;
    $.get(urlApp + '/tipologia/linea/' + sector_id, function (data) {
      $("#inputLinea").prop("disabled", false);
      $("#inputLinea").empty();
      $("#inputLinea").append('<option value="" selected="selected">Seleccionar</option>');
      $.each(data, function (index, lineaObj) {
        $("#inputLinea").append('<option value="' + lineaObj.id + '">' + lineaObj.descripcion + '</option>');
      });
    });
  });
  $('#inputLinea').on('change', function (e) {
    console.log(e);
    var linea_id = e.target.value;
    $.get(urlApp + '/tipologia/cadena/' + linea_id, function (data) {
      $("#inputCadena").prop("disabled", false);
      $("#inputCadena").empty();
      $("#inputCadena").append('<option value="" selected="selected">Seleccionar</option>');
      $.each(data, function (index, cadenaObj) {
        $("#inputCadena").append('<option value="' + cadenaObj.id + '">' + cadenaObj.descripcion + '</option>');
      });
    });
  });
  $('#inputCadena').on('change', function (e) {
    console.log(e);
    var cadena_id = e.target.value;
    $.get(urlApp + '/tipologia/producto/' + cadena_id, function (data) {
      $("#inputProducto").prop("disabled", false);
      $("#inputProducto").empty();
      $("#inputProducto").append('<option value="" selected="selected">Seleccionar</option>');
      $.each(data, function (index, productoObj) {
        $("#inputProducto").append('<option value="' + productoObj.id + '">' + productoObj.descripcion + '</option>');
      });
    });
  });
});



        $('#modalUpdatePassword').on('show.bs.modal', function (e) {
            var codUsuario= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdatePassword').load(route("usuario.reset", codUsuario));
        });
        $(document).on("click", '#btnUpdatePassword', function (event) {
            event.preventDefault();
            var form = $("#FormUpdatePassword");
            var urlAction = form.attr('action');
            var formData = new FormData(form[0]);
            var dataAll = form.serialize();
            $.ajax({
                url: urlAction,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#Footer_UpdatePassword_Enabled").css("display", "none");
                    $("#Footer_UpdatePassword_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdatePassword_Enabled").css("display", "block");
                    $("#Footer_UpdatePassword_Disabled").css("display", "none");
                    $("#modalUpdatePassword").modal('hide');
                    alertify.success(mensaje);
                },
                error: function (response) {
                    var errors = response.responseJSON;
                    var errorTitle = errors.message;
                    console.error(errorTitle);
                    var errorsHtml = '';
                    $.each(errors['errors'], function (index, value) {
                        errorsHtml += '<ul>';
                        errorsHtml += '<li>' + value + "</li>";
                        errorsHtml += '</ul>';
                    });
                    $("#PasswordAlerts").css("display", "block");
                    $("#PasswordAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdatePassword_Enabled").css("display", "block");
                    $("#Footer_UpdatePassword_Disabled").css("display", "none");
                }
            });
        });        




/***/ }),

/***/ 0:
/*!****************************************************************************************!*\
  !*** multi ./resources/js/config-app.js ./resources/AdminLTE/build/scss/AdminLTE.scss ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/opazos/Sites/agroideas/resources/js/config-app.js */"./resources/js/config-app.js");
module.exports = __webpack_require__(/*! /Users/opazos/Sites/agroideas/resources/AdminLTE/build/scss/AdminLTE.scss */"./resources/AdminLTE/build/scss/AdminLTE.scss");


/***/ })

/******/ });