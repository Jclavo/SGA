/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var select2 = {
    iniciar: function () {
        $(".select2").select2({
            width: '100%'
        });
    },
    asignarValor: function (id, valor) {
        $("#" + id).select2().select2("val", valor);
        $("#" + id).select2({width: '100%'});
    },
    readonly: function (id, valor) {
        $("#" + id).select2("readonly", valor);
    },
    cargar: function (id, data, val, text) {

        $('#' + id).empty();
        $('#' + id).append('<option value="-1")>Seleccione</option>');
        $.each(data, function (index, item) {
            $('#' + id).append('<option value="' + item[val] + '">' + item[text] + '</option>');
        });
    },
    obtenerValor: function (id) {
        var data = $("#" + id).select2('data');
        if (isEmpty(data))
            return null;
        return (data.hasOwnProperty("id")) ? data.id : null;
    },
    obtenerText: function (id) {
        var data = $("#" + id).select2('data');
        if (isEmpty(data))
            return null;
        return (data.hasOwnProperty("text")) ? data.text : null;
    },
    obtenerTextMultiple: function (id) {
        var cadena = "";
        var data = $("#" + id).select2('data');
        if (isEmpty(data))
        {
            return null;
        }
        $.each(data, function (index, item) {

            if (!isEmpty(item.text))
            {
                cadena += item.text + ", ";
            }

        });
        if (!isEmpty(cadena))
        {
            return cadena.slice(0, -2);
        }
        return null;
        //return (data.hasOwnProperty("text")) ? data.text : null;
    },
    asignarValorPredeterminado: function (id) {
        $("#" + id).select2().select2("val",'-1');
        $("#" + id).select2({width: '100%'});
    }
    
};

function isEmpty(value)
{
    if ($.type(value) === 'undefined')
        return true;
    if ($.type(value) === 'null')
        return true;
    if ($.type(value) === 'string' && value.length <= 0)
        return true;
    if ($.type(value) === 'array' && value.length === 0)
        return true;
    if ($.type(value) === 'number' && isNaN(parseInt(value)))
        return true;

    return false;
}

function isEmptyData(data)
{
    if (isEmpty(data))
        return true;
    if ($.type(data) === JSType.ARRAY)
    {
        return data.length === 0;
    }
    else if ($.type(data) === JSType.OBJECT)
    {
        if (!hasPropiertyObject(data, 'rows'))
            return true;

        return isEmpty(data.rows);
    }
    else
    {
        return true;
    }

    return false;
}

function isArray(value)
{
    if (typeof (value) == undefined)
        return false;
    if (value == null)
        return false;

    if (value instanceof Array)
        return true;

    return false;
}

function isBoolean(value)
{
    if ($.type(value) === JSType.UNDEFINED)
        return false;
    if (value === null)
        return false;

    if ($.type(value) === JSType.BOOLEAN)
        return true;

    return false;
}

/*
 * 
 * @param {string} value = valor de la cadena
 * @param {int} tamanho = tamaño, este parametro es opcional
 * @returns {boolean} true si es valido , falso si es invalido
 */
function validarNumero(value, tamanho)
{
    if(tamanho <= 0)
    {
        if(!isEmpty(value) && !isNaN(value))
        {
            return true;
        }
        return false;
    }
    else
    {
        if(!isEmpty(value) && value.length <= tamanho && !isNaN(value))
        {
            return true;
        }
        return false;
    }
}

function validarCadena(value, tamanho)
{
    if(tamanho <= 0)
    {
        if(!isEmpty(value))
        {
            return true;
        }
        return false;
    }
    else
    {
        if(!isEmpty(value) && value.length <= tamanho)
        {
            return true;
        }
        return false;
    }
}


function quitarNULL(valor)
{
    if(valor===null || valor==="null")
    {
        return "";
    }
    return valor;
}

function validarCbo(valor)
{
    if(isEmpty(valor) || valor=="-1")
    {
        return false;
    }
    return true;
}