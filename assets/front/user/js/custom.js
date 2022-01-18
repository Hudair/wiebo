
'use strict';
const ul = document.getElementById('language-list');
ul.onclick = function(event) {
    document.getElementById('lang-code').value = event.target.getAttribute('data-value');
    document.getElementById('userLangForms').submit();
};