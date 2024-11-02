"use strict";
let httpRequest;
let x = document.getElementById("addons-form-container");
document.getElementById('addon-install-btn').onclick=function(){
    const p = x.closest('.addon-form-hide');
    if(p){
        p.classList.remove('addon-form-hide');
    }
    x.classList.toggle('addon-form-show');
};

document.getElementById('cancel-addform').onclick=function(){
    x.classList.remove('addon-form-show');
};


var close = document.getElementsByClassName("addon-alert-closebtn");
var i;

for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){
            div.style.display = "none";
        }, 600);
    }
}

let triggers = document.querySelectorAll('.addon-modal-trigger');
if (window.XMLHttpRequest) { // Mozilla, Safari, IE7+ ...
    httpRequest = new XMLHttpRequest();
} else if (window.ActiveXObject) { // IE 6 and older
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
}


triggers.forEach((trigger) => {
    trigger.addEventListener('click', function() {
        clearForm();
        addonModalToggle();
        setFormName(this.dataset.name);
        getAddonFormData(this.dataset.url);
    });
});

document.querySelector('.addon-modal-close').addEventListener('click', function() {
    addonModalToggle();
});

function getAddonFormData(url) {
    if (url === '#') {
        return;
    }
    toggleAddonLoading();
    httpRequest.onreadystatechange = handleResponse;
    httpRequest.open('GET', url, true);
    httpRequest.send();
    $(document).on("click", ".addon-remove-modal-close", function () {
         $('.addon-modal-window').addClass('addon-modal-hidden');
    })
}

function addonModalToggle() {
    document.querySelector('.addon-modal-window').classList.toggle('addon-modal-hidden');
}

function handleResponse() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        toggleAddonLoading();
        if (httpRequest.status === 200) {
            let response = JSON.parse(httpRequest.responseText);
            if (response.status) {
                generateForm(response.html);
            }
        } else {
            alert('There was a problem with the request.');
            addonModalToggle();
        }
    }
}

function generateForm(html) {
    var div = document.createElement("div");
    div.innerHTML = html;
    document.querySelector('.modal-form-data .form').appendChild(div);
}

function setFormName(name) {
    document.querySelector('.addon-modal-title').innerHTML = name;
}

function toggleAddonLoading() {
    document.querySelector('.addon-form-loading').classList.toggle('addon-modal-dnone');

}

function clearForm() {
    document.querySelector('.modal-form-data .form').innerHTML = '';
    setFormName('');
}

const insTab= document.getElementById('ins-addon-tab');
const avlTab= document.getElementById('avl-addon-tab');
const insTable= document.getElementById('addons-ins-table-container');
const avlTable= document.getElementById('addons-avl-table-container');

$('.addons-tab').on('click', (event)=>{
    if( event.target===insTab){
        insTab.classList.add('addons-active');
        insTable.classList.add('addons-show');
        insTable.classList.remove('addons-hide');
        avlTab.classList.remove('addons-active');
        avlTable.classList.add('addons-hide');
    }
    else{
        avlTab.classList.add('addons-active');
        avlTable.classList.add('addons-show');
        avlTable.classList.remove('addons-hide');
        insTab.classList.remove('addons-active');
        insTable.classList.add('addons-hide');
    }
})

$('.search-box').on('keyup', function() {
    var input, filter, tr, td, i, txtValue;
    input = $(this).val();
    filter = input.toUpperCase();
    tr = $('table').find("tbody tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].querySelector(".addons-name");
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
})


$(document).on("change", "input[type='file']", function (e) {
    $('.custom-file-name-level').text(this?.files[0]?.name ?? jsLang('Choose file'));
});

// Function to toggle the addons-active class
function toggleActiveClass(tab) {
    [allTab, activeTab, inactiveTab].forEach(function (el) {
      el.classList.remove('addons-active');
    });
  
    tab.classList.add('addons-active');
  }
  
  // Function to show rows based on status
  function showRows(status) {
    tableRows.forEach(function (row) {
      var rowStatus = row.getAttribute('data-status');
      row.style.display = (rowStatus === status || status === 'all') ? '' : 'none';
    });
  }
  
  // Get references to the elements
  var allTab = document.getElementById('ins-addon-tab');
  var activeTab = document.getElementById('active-addon-tab');
  var inactiveTab = document.getElementById('inactive-addon-tab');
  var tableRows = document.querySelectorAll('tr');
  
  // Add click event listeners to each tab
  allTab.addEventListener('click', function () {
    toggleActiveClass(allTab);
    showRows('all');
  });
  
  activeTab.addEventListener('click', function () {
    toggleActiveClass(activeTab);
    showRows('1');
  });
  
  inactiveTab.addEventListener('click', function () {
    toggleActiveClass(inactiveTab);
    showRows('0');
  });  
