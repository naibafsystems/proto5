/**********************************************************************************
 * Septiembre 15 de 2015
 * Libreria para la validacion de formularios de captura (Encuestas DANE)
 * Requiere de:
 *  - jquery.validate.min.js
 *  - jquery.qtip.js
 **********************************************************************************/

/*var loc = location;
 var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
 var base_url = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));*/

//var base_url = '/dimpe/cnpv/';  //Ruta base para ejecutar AJAX en CodeIgniter
metaCollection = document.getElementsByTagName('meta');

for (i = 0; i < metaCollection.length; i++) {
    nameAttribute = metaCollection[i].name.search(/baseurl/);
    if (nameAttribute != -1) {
        var base_url = metaCollection[i].content;
    }
}

/** Evita ir a la página anterior con tecla backspace, pero deja borrar en inputs
 * @author hhchavezv
 * @since  2016feb25
 */
// $(document).unbind('keydown').bind('keydown', function (event) {
//     var doPrevent = false;
//     if (event.keyCode === 8) {
//         var d = event.srcElement || event.target;
//         if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD' || d.type.toUpperCase() === 'EMAIL')) || d.tagName.toUpperCase() === 'TEXTAREA') {
//             doPrevent = d.readOnly || d.disabled;
//         } else {
//             doPrevent = true;
//         }
//     }

//     if (doPrevent) {
//         event.preventDefault();
//     }
// });

$(document).ready(function() {
    var tk = $('meta[name="csrf_token"]').attr('content');

    $.ajaxSetup({
        headers: {'X-Csrf-Token': tk },
    });
});

//********************************************************************************************
//* 1) Establece el valor máximo de caracteres que pueden ir en una caja de texto.
//********************************************************************************************
$.fn.maxlength = function (expresion) {
    return this.keypress(function (event) {
        if ((event.which == 8) || (event.which == 0))
            return true;
        else if ($(this).val().length < expresion)
            return true;
        else
            return false;
    });
};


//*******************************************************************************************
//* 2) Bloquea el ingreso de caracteres de texto en una caja de texto. Solo permite números
//*******************************************************************************************
$.fn.bloquearTexto = function () {
    return this.keypress(function (event) {
        if ((event.which == 8) || (event.which == 0))
            return true;
        if ((event.which >= 48) && (event.which <= 57))
            return true;
        else
            return false;
    });
};

//******************************************************************************************
//* 3) Bloquea el ingreso de caracteres numericos en una caja de texto. Solo permite letras
//******************************************************************************************
$.fn.bloquearNumeros = function () {
    return this.keypress(function (event) {
        if ((event.which < 48) || (event.which > 57))
            return true;
        else
            return false;
    });
};

//******************************************************************************************
//* 4) Convierte el contenido de una caja de texto todo a mayusculas
//******************************************************************************************
$.fn.convertirMayuscula = function () {
    return this.blur(function (event) {
        $(this).val($(this).val().toUpperCase());
    });
};

//******************************************************************************************
//* 5) Convierte el contenido de una caja de texto todo a minusculas
//******************************************************************************************
$.fn.convertirMinuscula = function () {
    return this.blur(function (event) {
        $(this).val($(this).val().toLowerCase());
    });
};

//******************************************************************************************
//* 6) verificar que el contenido no sean solo espacios
//******************************************************************************************
$.fn.verificaEspacios = function () {
    return this.blur(function (event) {
        var ele = $(this).val();
        //alert ('aqui'+ele);
        var tama = ele.length;
        if ((vacio(ele) == false) && (tama > 0)) {
            alert('Introduzca un cadena de texto.');
            $(this).val('');
        }
    });
};
//******************************************************************************************
//* 7) verificar que el contenido no sean solo espacios
//******************************************************************************************
$.fn.minlength = function (expresion) {
    return this.blur(function (event) {
        var ele = $(this).val();
        var tama = ele.length;
        if ((tama < expresion)) {
            alert('Debe ser m\u00ednimo de ' + expresion + ' digitos');
            $(this).val('');
        }
    });
};

$.fn.convertirTildes = function () {
    return this.blur(function (event) {
        var r=$(this).val().toLowerCase();
        // r = r.replace(new RegExp("\\s", 'g'),"");
        r = r.replace(new RegExp("[àáâãäå]", 'g'),"a");
        r = r.replace(new RegExp("æ", 'g'),"ae");
        r = r.replace(new RegExp("ç", 'g'),"c");
        r = r.replace(new RegExp("[èéêë]", 'g'),"e");
        r = r.replace(new RegExp("[ìíîï]", 'g'),"i");
        r = r.replace(new RegExp("[òóôõö]", 'g'),"o");
        r = r.replace(new RegExp("[ùúûü]", 'g'),"u");
        // r = r.replace(new RegExp("ñ", 'g'),"n");
        r = r.replace(new RegExp("[ýÿ]", 'g'),"y");
        $(this).val(r);
    });
};

/**********************************************************************************************************************
 * Metodos de validacion agregados a JQuery Validator
 * @author Daniel M. Diaz
 * @since  21/09/2015
 *********************************************************************************************************************/

/********************************************************************************************************************
 * Funciones JQUERY adicionales
 * @author Daniel M. Diaz
 * @since  21/09/2015
 ********************************************************************************************************************/

//Funcion JQUERY para generar mensajes 'hint' junto a cajas de texto
//*******************************************************************
$.fn.hint = function (titulo, mensaje) {
    var id = $(this).attr('id');
    $(this).append('&nbsp;<span class="glyphicon glyphicon-info-sign font-help" id="hint' + id + '" alt="' + mensaje + '" data-tooltip="' + mensaje + '"  aria-hidden="true"></span>');

    return $('#hint' + id).qtip({
        content: {
            title: titulo,
            text: mensaje
        },
        position: { my: 'top left' },
        style: { classes: 'qtip-bootstrap qtip-DANE' }
    });
};

//Funcion JQUERY para generar menajes 'hint'. Esta funcion despliega el hint 'ABIERTO' por defecto
//*************************************************************************************************
$.fn.hintOpen = function (titulo, mensaje) {
    var id = $(this).attr('id');
    var tooltip = $('#' + id).qtip({
        prerender: true,
        content: {
            title: titulo,
            text: mensaje
        },
        position: { container: $('#' + id) },
        style: { classes: 'qtip-bootstrap qtipDANE' },
        show: {
            event: 'load',
            ready: true
        },
        hide: function (event, api) {
            $(this).show();
        }
    });
    var api = tooltip.qtip('api');
    api.toggle(true); // Pass event as second parameter!
    api.show(true);
    return tooltip;
};

//Funcion JQUERY para ejecutar una funcion ajax para actualizar comboBox dependientes
//*****************************************************************************************
$.fn.cargarCombo = function (element, element2, url) {
    return this.change(function (event) {
        //$('#' + element).prop('selectedIndex', '-');
        if ($(this).val() != '-') {
            $.ajax ({
                cache: false,
                contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                data: 'opc=' + element + '&id=' + $(this).val(),
                dataType: 'html',
                type: 'POST',
                url: url,
                success: function (html) {
                    if(html.length > 0) {
                        $('#' + element2).html(html);
                    } else {
                        $('#' + element).attr('disabled', true);
                        $('#' + element + ' option[value="-"]').attr('selected', true);
                    }
                },
                error: function (result) {
                    $('#' + element).attr('disabled', true);
                    $('#' + element + ' option[value="-"]').attr('selected', true);
                }
            });
        }
    });
};

//Funcion JQUERY para establecer el valor mÃ¡ximo de caracteres que pueden ir en un textbox.
//*****************************************************************************************
$.fn.largo = function (expresion) {
    return this.keypress(function (event) {
        if ((event.which == 8) || (event.which == 0))
            return true;
        else if ($(this).val().length < expresion)
            return true;
        else
            return false;
    });
};

//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite nÃºmeros.
//**************************************************************************************************
$.fn.bloquearTexto = function () {
    return this.keypress(function (event) {
        if ((event.which == 8) || (event.which == 0) || (event.which == 45))
            return true;
        if ((event.which >= 48) && (event.which <= 57))
            return true;
        else
            return false;
    });
};


//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite nÃºmeros y sin guiones.
//**************************************************************************************************
$.fn.bloquearTextoSinGuiones = function () {
    return this.keypress(function (event) {
        if ((event.which == 8) || (event.which == 0))
            return true;
        if ((event.which >= 48) && (event.which <= 57))
            return true;
        else
            return false;
    });
};

//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite nÃºmeros y sin guiones.
//**************************************************************************************************
$.fn.bloquearTextoespeciales = function () {
    return this.keypress(function (event) {
        //alert ('2='+event.which);
        if ((event.which != 64) && (event.which != 241) && (event.which != 45))
            return true;
        else
            return false;
    });
};


//Funcion JQUERY para bloquear el ingreso de caracteres numericos en un textbox. Solo permite letras.
//****************************************************************************************************
$.fn.bloquearNumeros = function () {
    return this.keypress(function (event) {
        if (((event.which < 48) || (event.which > 57)) && (event.which != 64))
            return true;
        else
            return false;
    });
};

//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite numeros y sin guiones
//**************************************************************************************************
$.fn.soloNumeros = function () {
    return this.keypress(function (event) {
        if ((event.which == 8) || (event.which == 0))
            return true;
        if ((event.which >= 48) && (event.which <= 57))
            return true;
        else
            return false;
    });
};

//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite numeros y sin guiones
//**************************************************************************************************
$.fn.soloAlfanumericos = function () {
    return this.keypress(function (event) {
        if (event.which == 0 || event.which == 8 || event.which == 13)
            return true;
        if ((event.which >= 48) && (event.which <= 57))  //Numeros
            return true;
        if ((event.which >= 65) && (event.which <= 90)) // Mayusculas
            return true;
        if ((event.which >= 97) && (event.which <= 122)) // Minusculas
            return true;
        else
            return false;
    });
};

//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite letras y caracteres especiales
//**************************************************************************************************
$.fn.soloNombre = function () {
    return this.keypress(function (event) {
        if (event.which == 0 || event.which == 8 || event.which == 13 || event.which == 32)
            return true;
        if ((event.which >= 65) && (event.which <= 90))
            return true;
        if ((event.which >= 97) && (event.which <= 122))
            return true;
        if ((event.which >= 192) && (event.which <= 207))
            return true;
        if ((event.which >= 210) && (event.which <= 214))
            return true;
        if ((event.which >= 216) && (event.which <= 220))
            return true;
        if ((event.which >= 224) && (event.which <= 239))
            return true;
        if ((event.which >= 242) && (event.which <= 246))
            return true;
        if ((event.which >= 248) && (event.which <= 252))
            return true;
        if ((event.which == 209) || (event.which == 241)) // enie
            return true;
        /*if ((event.which == 193) || (event.which == 225)) // A con tilde
            return true;
        if ((event.which == 201) || (event.which == 233)) // E con tilde
            return true;
        if ((event.which == 205) || (event.which == 237)) // I con tilde
            return true;
        if ((event.which == 211) || (event.which == 243)) // O con tilde
            return true;
        if ((event.which == 218) || (event.which == 250)) // U con tilde
            return true;*/
        else
            return false;
    });
};

//Funcion JQUERY para convertir el contenido de un textbox todo a mayusculas.
//****************************************************************************
$.fn.Mayusculas = function () {
    return this.blur(function (event) {
        $(this).val($(this).val().toUpperCase());
    });
};

//Funcion JQUERY para convertir el contenido de un textbox todo a minusculas.
//****************************************************************************
$.fn.Minusculas = function () {
    return this.blur(function (event) {
        $(this).val($(this).val().toLowerCase());
    });
};

$.fn.esFechaMayor = function (fecha1, fecha2) {
    return Date.parse(fecha1) <= Date.parse(fecha2);
};

//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite letras y caracteres especiales
//**************************************************************************************************
$.fn.textoDireccion = function () {
    return this.keypress(function (event) {
        if (event.which == 0 || event.which == 8 || event.which == 13 || event.which == 32)
            return true;
        // event.which == 35 // numeral
        if (event.which == 44 || event.which == 45 || event.which == 46) // Simbolos coma guion punto
            return true;
        if ((event.which >= 48) && (event.which <= 57))  //Numeros
            return true;
        if ((event.which >= 65) && (event.which <= 90))
            return true;
        if ((event.which >= 97) && (event.which <= 122))
            return true;
        if ((event.which >= 192) && (event.which <= 207))
            return true;
        if ((event.which >= 210) && (event.which <= 214))
            return true;
        if ((event.which >= 216) && (event.which <= 220))
            return true;
        if ((event.which >= 224) && (event.which <= 239))
            return true;
        if ((event.which >= 242) && (event.which <= 246))
            return true;
        if ((event.which >= 248) && (event.which <= 252))
            return true;
        if ((event.which == 209) || (event.which == 241)) // enie
            return true;
        /*if ((event.which == 193) || (event.which == 225)) // A con tilde
            return true;
        if ((event.which == 201) || (event.which == 233)) // E con tilde
            return true;
        if ((event.which == 205) || (event.which == 237)) // I con tilde
            return true;
        if ((event.which == 211) || (event.which == 243)) // O con tilde
            return true;
        if ((event.which == 218) || (event.which == 250)) // U con tilde
            return true;*/
        else
            return false;
    });
};

//****************************************************************************************************************
//** Agrega metodo de validacion de controles Select en jQuery.Validate
//****************************************************************************************************************
$.validator.addMethod('selectVacio', function (value, element, params) {
    if($('#' + $(element).attr('id') + ' > option').length > 1) {
        if (value === null || value.length == 0 || value == '-') {
            $(this).val('').focus();
            return false;
        }
    }
    return true;
});

//****************************************************************************************************************
//** Agrega metodo de validacion de controles Select en jQuery.Validate
//****************************************************************************************************************
$.validator.addMethod('comboBox', function (value, element, param) {
    var result = false;
    //comentariada hhchavezv 20151030 $("select:disabled").attr("disabled",false); //Habilitar todos los controles select que estÃ©n deshabilitados.
    var string = (param).toString();
    if ($(element).val() == string)
        result = false;
    else
        result = true;
    return result;
}, '');
//****************************************************************************************************************
//** Agrega metodo de validacion de email valido segun expresion regular en jQuery.Validate
//****************************************************************************************************************
$.validator.addMethod('emailValido2', function (value, element, params) {
    var regex = /^[a-zA-Z0-9_\-\.~]{2,}@[a-zA-Z0-9_\-\.~]{2,}\.[a-zA-Z]{2,4}$/;
    if (value.length > 0) {
        if (regex.test(value)) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}, 'ERROR: No es una dirección de correo electrónico válida.');

//****************************************************************************************************************
//** Compara y valida que el valor de una caja de texto contra una expresion completa escrita en jQuery
//****************************************************************************************************************
$.validator.addMethod('expresion', function (value, element, param) {
    var comp = convertirExpresion(param);
    if (comp) {
        return false;
    } else {
        return true;
    }
}, '');


$.validator.addMethod('expresion2', function (value, element, param) {
    var comp = convertirExpresion(param);
    if (comp) {
        return false;
    } else {
        return true;
    }
}, '');

//****************************************************************************************************************
//** Agrega metodo de validacion de contraseña valida en jQuery.Validate
//****************************************************************************************************************
$.validator.addMethod('validarPass', function (value, element, params) {
    //validate the length
    //var regex = /^(?=^.{8,20}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
    //var regex = /^(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,20})$/;
    //var regex = /^(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9\ñ\Ñ\!\@\#\$\%\^\&\*\(\)\-\_\=\+\\|\[\]\{\}\;\:\/\?\.\>\<\]{8,20})$/;
    //var regex = /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,20}$/;
    //var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,20}/;
    var regex = /^(?=^.{8,20}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;

    if (value.match(regex)) {
         return true;
    }



    return false;
}, 'ERROR: La contraseña debe contener al menos: una letra mayúscula, una letra minúscula, un número o carácter especial. con mínimo ocho (8) caracteres.');

/**
 * Funcion para validar estructura correcta de email
 * Acepta un rango de caracteres de 'A-Z' en mayúsculas y minúsculas, rango de digitos del '0-9, y caracteres permitidos en las direcciones de correo ( '_', '-', '.', '~' )
 * Todo esto en un mínimo de 2 y no especifico el máximo '{2,}'. Seguido por un '@', y seguido por el mismo patron de concordancia, para el nombre del dominio.
 * Todo esto seguido por un '.'(punto). Terminado por rango de caracteres de 'A-Z' en mayúsculas y minúsculas, mínimo de 2 y máximo 3 '{2,3}'
 * @author hhchavezv
 * @since  2016ene27
 */

$.validator.addMethod('emailValido', function (value, element) {
    if (/^[a-zA-Z0-9_\-\.~]{2,}@[a-zA-Z0-9_\-\.~]{2,}\.[a-zA-Z]{2,4}$/.test(value)) {
        return true;
    } else {
        return false;
    }
}, '');

$.validator.addMethod('endDate', function (value, element, params) {
    var startDate = formatearFecha($('#' + params[0]).val());
    var endD = formatearFecha($('#' + params[1]).val());
    return Date.parse(startDate) <= Date.parse(endD);
});

$.validator.addMethod('endHour', function (value, element, params) {
    var startHour = $('#' + params[0]).val();
    var endH = $('#' + params[1]).val();
    var temp1 = startHour.split(':');
    var temp2 = endH.split(':');
    var startDate = new Date();
    var endDate = new Date();
    startDate.setHours(temp1[0], temp1[1]);
    endDate.setHours(temp2[0], temp2[1]);
    return Date.parse(startDate) <= Date.parse(endDate);
});

var formatearFecha = function (fecha) {
    var temp = [];
    if (isNaN(fecha) && fecha.indexOf('%2F') > 0) {
        temp = fecha.split('%2F');
        return temp[2] + '-' + temp[1] + '-' + temp[0];
    } else if (isNaN(fecha) && fecha.indexOf('/') > 0) {
        temp = fecha.split('/');
        return temp[2] + '-' + temp[1] + '-' + temp[0];
    } else if (isNaN(fecha) && fecha.indexOf('-') > 0) {
        temp = fecha.split('-');
        return temp[2] + '/' + temp[1] + '/' + temp[0];
    }
};

//2) Evalua una cadena de texto recibida como parametro y retorna un valor de verdadero o falso
function convertirExpresion(cadena) {
    var result = false;
    if ((typeof cadena) == 'string')
        result = (eval(cadena)) ? true : false;
    return result;
}

/**
 * Funcion Especial
 * Redirige al usuario a un modulo para descarga de navegadores cuando se detecta
 * que utiliza Internet Explorer 8 o anteriores
 * @author dmdiazf
 * @since  2015-10-01
 */
function redirectBrowser() {
    var BrowserDetect = {
        init: function () {
            this.browser = this.searchString(this.dataBrowser) || "Other";
            this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
        },
        searchString: function (data) {
            for (var i = 0; i < data.length; i++) {
                var dataString = data[i].string;
                this.versionSearchString = data[i].subString;
                if (dataString.indexOf(data[i].subString) !== -1) {
                    return data[i].identity;
                }
            }
        },
        searchVersion: function (dataString) {
            var index = dataString.indexOf(this.versionSearchString);
            if (index === -1) {
                return;
            }
            var rv = dataString.indexOf("rv:");
            if (this.versionSearchString === "Trident" && rv !== -1) {
                return parseFloat(dataString.substring(rv + 3));
            } else {
                return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
            }
        },
        dataBrowser: [
            {string: navigator.userAgent, subString: "Edge", identity: "MS Edge"},
            {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
            {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
            {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
            {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
            {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
            {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
        ]
    };
    BrowserDetect.init();
    if ((BrowserDetect.browser == 'Explorer') && (BrowserDetect.version < 10)) {
        var url = base_url + "ieredirect";
        $(location).attr("href", url);
    }
}

function vacio(q) {
    //alert ('esta'+q);
    for (i = 0; i < q.length; i++) {
        if (q.charAt(i) != ' ') {
            return true;
        }
    }
    return false;
}

function generateGetURL(path, data) {
    var i = 0;
    var url = base_url + path;
    for (i = 0; i < data.length; i++) {
        if (isNaN(data[i]) && data[i].indexOf('/') > 0) {
            step1 = data[i].replace('/', '-');
            step2 = step1.replace('/', '-');
            data[i] = step2;
        } else if (isNaN(data[i]) && data[i].indexOf('%2F') > 0) {
            step1 = data[i].replace('%2F', '-');
            step2 = step1.replace('%2F', '-');
            data[i] = step2;
        } else if (data[i] == '') {
            data[i] = '-';
        }
        url = url + encodeURIComponent(data[i]) + '/';
    }
    url = url.substring(0, url.length - 1);
    return decodeURIComponent(url);
}

function generarURLserialize(idForm) {
    var cadena = $('#' + idForm).serialize();
    var temp = cadena.split('&');
    //var temp2 = new Array();
    //var data = new Array();
    var temp2 = [];
    var data = [];
    var nombre_campo = '';
    var valor_campo = '';

    for (i = 0; i < temp.length; i++) {
        temp2 = temp[i].split('=');
        if (nombre_campo == temp2[0]) {
            if (valor_campo.length > 0) {
                valor_campo = valor_campo + '|' + temp2[1];
            } else {
                valor_campo = temp2[1];
                temp2 = temp[i - 1].split('=');
                valor_campo = temp2[1] + '|' + valor_campo;
            }
        } else {
            if (valor_campo.length > 0) {
                data.pop();
                data.push(valor_campo);
                nombre_campo = '';
                valor_campo = '';
            }
            if(temp2[1].length == 0) {
                temp2[1] = '-';
            }
            data.push(temp2[1]);
        }
        nombre_campo = temp2[0];
    }
    return data;
}

function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}

function validarHora(valorHora) {
    return (/^(([01][0-9])|(2[0123]))(:[0-5][0-9])(:[0-5][0-9])?$/.test(valorHora)) ? true : false;
}

//Validar del campo de formulario de URL
function validaURL(url) {
    //var regex = /^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i
    var regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regex.test(url);
}

function validarTextoCorreo(texto) {
    // Expresion regular para validar el correo
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    // Se utiliza la funcion test() nativa de JavaScript
    if (regex.test(texto.trim())) {
        return true;
    } else {
        return false;
    }
}

/**
 * Funci&oacuten para validar la edad de la perosna
 * @author oagarzond
 * @since 2017-03-02
 * @param fechaNaci Fecha de nacimiento
 * @param fechaFin  Fecha que se resta a la fecha de nacimiento
 * @return edad la edad calculada
 */
function calculaEdad(fechaNaci, fechaFin) {
    if(fechaNaci.length == 0) {
        return false;
    }
    var tempFechaNaci = fechaNaci.split('-');
    var anio = tempFechaNaci[0];
    var mes = tempFechaNaci[1];
    var dia = tempFechaNaci[2];
    //tomar los valores actuales
    var fecha = new Date();
    var anio2 = fecha.getFullYear();
    var mes2 = fecha.getMonth() + 1;
    var dia2 = fecha.getDate();

    if(fechaFin.length > 0) {
        var tempFecha = fechaFin.split('-');
        anio2 = tempFecha[0];
        mes2 = tempFecha[1];
        dia2 = tempFecha[2];
    }

    // realizar el calculo
    var edad = (anio2 + 1895) - anio;
    if (mes2 < mes)
        edad--;

    if ((mes == mes2) && (dia2 < dia))
        edad--;

    if (edad > 1894)
        edad -= 1895;

    return edad;
}

$(window).on('load', function() {
    if ( $('.divoverlay').length ) {
        $(".divoverlay").remove();
    }
});
