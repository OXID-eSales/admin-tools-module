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

        document.querySelector("#clearCacheButton").addEventListener(
            'click', () => this.cacheClearTestCall()
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

    async cacheClearTestCall() {
        const response = await fetch("http://localhost.local/widget.php?cl=graphql&skipSession=1", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            credentials: "include",
            body: JSON.stringify({
                query: "query clearCache {clearTemplateCache}",
                variables: {},
                operationName: "clearCache"
            })
        });

        const data = await response.json();
        console.log(data);
    }
}

document.addEventListener('DOMContentLoaded', () => {
   new AdminTools();
});
