/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mensajeExito(mensaje)
{
    $.Notification.autoHideNotify('success', 'top right', 'Exito' ,mensaje);
}

function mensajeError(mensaje)
{
    $.Notification.autoHideNotify('error', 'top right', 'Error' ,mensaje);
}

function mensajeInformacion(mensaje)
{
    $.Notification.autoHideNotify('info', 'top right', 'Información' ,mensaje);
}

function mensajeAviso(mensaje)
{
    $.Notification.autoHideNotify('warning', 'top right', 'Aviso' ,mensaje);
}

function mensajeNegro(mensaje)
{
    $.Notification.autoHideNotify('black', 'top right', 'Info' ,mensaje);
}
