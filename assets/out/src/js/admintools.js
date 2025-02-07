/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

export class AdminTools {

    constructor() {
        this.init();
    }

    init() {
        document.querySelector("#admincacheclearbutton").addEventListener(
            'click', () => this.cacheClearCall()
        );
    }

   cacheClearCall() {
        var selector = document.querySelector('#admincacheclearselect');
        var selected = selector.value;
        var controllerUrl = document.querySelector('#controllerUrl').value + selected;

        const xhttp = new XMLHttpRequest();
        xhttp.open('GET', controllerUrl, true);
        xhttp.onload = () => {
           if (xhttp.readyState === xhttp.DONE &&
               (xhttp.status === 0 || (xhttp.status >= 200 && xhttp.status < 400)) ) {

               document.getElementById('admintools_cacheclear_status_fail').style = 'display:none';
               document.getElementById('admintools_cacheclear_status').innerHTML = xhttp.responseText;
           } else {
               document.getElementById('admintools_cacheclear_status_fail').style = 'display:block';
           }

           setTimeout(function(){
               document.getElementById("admintools_cacheclear_status").innerHTML = '';
               document.getElementById('admintools_cacheclear_status_fail').style = 'display:none';
           }, 5000);
        }
        xhttp.send();
   }
}

document.addEventListener('DOMContentLoaded', () => {
   new AdminTools();
});
