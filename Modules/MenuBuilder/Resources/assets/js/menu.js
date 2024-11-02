"use strict";
var arraydata = [];
function getmenus1() {
  getmenus();
  updateitem();
  actualizarmenu();
}
function getmenus() {
  arraydata = [];
  $('#spinsavemenu').show();

  var cont = 0;
  $('#menu-to-edit li').each(function(index) {
    var dept = 0;
    for (var i = 0; i < $('#menu-to-edit li').length; i++) {
      var n = $(this)
        .attr('class')
        .indexOf('menu-item-depth-' + i);
      if (n != -1) {
        dept = i;
      }
    }

    var textoiner = $(this)
      .find('.item-edit')
      .text();
    var id = this.id.split('-');
    var textoexplotado = textoiner.split('|');
    var padre = 0;
    if (
      !!textoexplotado[textoexplotado.length - 2] &&
      textoexplotado[textoexplotado.length - 2] != id[2]
    ) {
      padre = textoexplotado[textoexplotado.length - 2];
    }
    arraydata.push({
      depth: dept,
      id: id[2],
      parent: padre,
      sort: cont
    });
    cont++;
  });
}
function addcustommenuToDb()
{
  if ($('#custom-menu-item-name').val() == 'Label Name') {
    swal(jsLang('Please provide the label name to add menu item'), {
      icon: "error",
      buttons: [false, jsLang('Ok')],
  });
  return false;
} else {
  $('#spincustomu').show();
  var url_string = window.location.href; //window.location.href
  var url = new URL(url_string);
  $.ajax({
    data: {
      labelmenu: $('#custom-menu-item-name').val(),
      linkmenu: $('#custom-menu-item-url').val(),
      customName: $(this).attr("data-name"),
      idmenu: url.searchParams.get("menu")
    },

    url: addCustomMenu,
    type: 'POST',
    success: function(response) {
        if (response.status == 'info') {
          swal(response.message, {
              icon: "info",
              buttons: [false, jsLang('Ok')],
          });
        } else {
          swal(jsLang('The menu has been successfully added.'), {
                icon: "success",
                buttons: [false, jsLang('Ok')],
          }).then(function(){
              window.location.reload();
          })
        }
    },
    complete: function() {
      $('#spincustomu').hide();
    }
  });
}
}
function addcustommenu() {
  var selectedMenu = new Array();
  var selectedTitle = new Array();
  var selectedUrl = new Array();
  var selectedPermission = new Array();
  var selectedDefaultValue = new Array();
        var n = jQuery(".menu:checked").length;
        if (n > 0){
            jQuery(".menu:checked").each(function(){
              selectedMenu.push($(this).val());
              selectedTitle.push($(this).attr("data-name"));
              selectedUrl.push($(this).attr("data-url"));
              selectedPermission.push($(this).attr("data-permission"));
              selectedDefaultValue.push($(this).attr("data-delete"));
            });
        }
  if ((jQuery.isEmptyObject(selectedMenu))) {
    swal(jsLang('Please select a menu to add'), {
      icon: "error",
      buttons: [false, jsLang('Ok')],
  });
  return false;
}
  $('#customMenuSpinner').show();
  var url_string = window.location.href; //window.location.href
  var url = new URL(url_string);
  var idMenu = url.searchParams.get("menu");
  var title = selectedTitle;
  var menuIds = selectedMenu;
  $.ajax({
    data: {
      labelmenu: $('#custom-menu-item-name').val(),
      linkmenu: $('#custom-menu-item-url').val(),
      rolemenu: $('#custom-menu-item-role').val(),
      customName: selectedTitle,
      categoryUrl: selectedUrl,
      permissionAttribute: selectedPermission,
      isDeletable: selectedDefaultValue,
      idmenu: idMenu,
      menuIds : menuIds
    },

    url: addCustomMenu,
    type: 'POST',
    success: function(response) {
        if (response.status == 'info') {
          swal(response.message, {
              icon: "info",
              buttons: [false, jsLang('Ok')],
          });
        } else {
          swal(jsLang('The menu has been successfully added.'), {
            icon: "success",
            buttons: [false, jsLang('Ok')],
          }).then(function(){
              window.location.reload();
          })
        }
    },
    complete: function() {
      $('#customMenuSpinner').hide();
    }
  });
}


function updateitem(id = 0) {
  if (id) {
    var label = $('#idlabelmenu_' + id).val();
    var clases = $('#clases_menu_' + id).val();
    var url = $('#url_menu_' + id).val();
    var params = $('#attribute_menu' + id).val();
    var role_id = 0;
    if ($('#role_menu_' + id).length) {
      role_id = $('#role_menu_' + id).val();
    }

    var data = {
      label: label,
      clases: clases,
      url: url,
      role_id: role_id,
      params: params,
      id: id
    };
  } else {
    var arr_data = [];
    $('.menu-item-settings').each(function(k, v) {
      var id = $(this)
        .find('.edit-menu-item-id')
        .val();
      var label = $(this)
        .find('.edit-menu-item-title')
        .val();
      var params = $(this)
        .find('.edit-menu-item-attribute')
        .val();
      var clases = $(this)
        .find('.edit-menu-item-classes')
        .val();
      var url = $(this)
        .find('.edit-menu-item-url')
        .val();
      var icon = $(this)
        .find('.edit-menu-item-icon')
        .val();
      var role = $(this)
        .find('.edit-menu-item-role')
        .val();
      arr_data.push({
        id: id,
        label: label,
        class: clases,
        link: url,
        icon: icon,
        params: params,
        role_id: role
      });
    });

    var data = { arraydata: arr_data };
  }
  $.ajax({
    data: data,
    url: updateItem,
    type: 'POST',
    beforeSend: function(xhr) {
        $('#hwpwrap .spinner .spincustomu2').css('display', 'inline');
    },
    success: function(response) {
        if (response.status == 'info') {
          swal(response.message, {
            icon: "info",
            buttons: [false, jsLang('Ok')],
          });

        } else {
          swal(jsLang('The menu has been successfully updated.'), {
            icon: "success",
            buttons: [false, jsLang('Ok')],
          });
        }
    },
    complete: function() {
        $('#hwpwrap .spinner .spincustomu2').css('display', 'none');
    }
  });
}

function actualizarmenu() {

  var url_string = window.location.href; //window.location.href
  var url = new URL(url_string);
  var idMenu = url.searchParams.get("menu");
  $.ajax({
    dataType: 'json',
    data: {
      arraydata: arraydata,
      menuname: $('#menu-name').val(),
      idmenu: idMenu
    },

    url: generateMenuControl,
    type: 'POST',
    beforeSend: function(xhr) {
      $('.spincustomu2').show();
    },
    success: function(response) {
      if (response.resp == 2) {
        swal(jsLang('The menu has been successfully updated.'), {
          icon: "success",
          buttons: [false, jsLang('Ok')],
      }).then(function(){
        window.location.reload();
    })
      }
    },
    complete: function() {
      $('.spincustomu2').hide();
    }
  });
}

function deleteitem(id) {
  var r = swal({
    title: jsLang('Are you sure?'),
    icon: "warning",
    buttons: [jsLang('Cancel'), jsLang('Ok')],
    dangerMode: true,
}).then((willDelete) => {
  if (willDelete) {
    var url_string = window.location.href; //window.location.href
  var url = new URL(url_string);
  var idMenu = url.searchParams.get("menu");
  $.ajax({
    dataType: 'json',
    data: {
      id: id
    },

    url: deleteItemMenu,
    type: 'POST',
    success: function(response) {
      if (response.status == 'info') {
        swal(response.message, {
            icon: "info",
            buttons: [false, jsLang('Ok')],
        });
      }
      if (response.error == 1) {
        swal(jsLang('The menu has been successfully deleted.'), {
          icon: "success",
          buttons: [false, jsLang('Ok')],
      }).then(function(){
        window.location.reload();
    })
      }
      if (response.error == 2) {
        swal(jsLang('You can not delete this menu'), {
          icon: "error",
          buttons: [false, jsLang('Ok')],
      }).then(function(){
        window.location.reload();
    })
      }
      if (response.error == 3) {
        swal(jsLang('Something went wrong, please try again.'), {
          icon: "error",
          buttons: [false, jsLang('Ok')],
      }).then(function(){
        window.location.reload();
    })
      }
    }
  });
  }
});
}

function deletemenu() {
  var r = swal({
    title: jsLang('Are you sure?'),
    icon: "warning",
    buttons: [jsLang('Cancel'), jsLang('Ok')],
    dangerMode: true,
}).then((willDelete) => {
  if (willDelete) {
    var url_string = window.location.href; //window.location.href
  var url = new URL(url_string);
  var idMenu = url.searchParams.get("menu");
  $.ajax({
    dataType: 'json',

    data: {
      id: idMenu
    },

    url: deleteMenu,
    type: 'POST',
    beforeSend: function(xhr) {
      $('.spincustomu2').show();
    },
    success: function(response) {
      if (response.status == 'info') {
        swal(response.message, {
            icon: "info",
            buttons: [false, jsLang('Ok')],
        });
      } else if (!response.error) {
        swal(jsLang('The menu has been successfully deleted.'), {
          icon: "success",
          buttons: [false, jsLang('Ok')],
      }).then(function(){
        window.location.reload();
    })
      } else if (response.error == 3) {
        swal(jsLang('Something went wrong, please try again.'), {
          icon: "error",
          buttons: [false, jsLang('Ok')],
      });
      }
    },
    complete: function() {
      $('.spincustomu2').hide();
    }
  });
  }
});
}

function createnewmenu() {
  if (!!$('#menu-name').val()) {
    $.ajax({
      dataType: 'json',

      data: {
        menuname: $('#menu-name').val()
      },

      url: createNewMenu,
      type: 'POST',
      success: function(response) {
        window.location = menuwr + '?menu=' + response.resp;
      }
    });
  } else {
    swal(jsLang('Enter name first'), {
      icon: "error",
      buttons: [false, jsLang('Ok')],
  });
    $('#menu-name').focus();
    return false;
  }
}

function insertParam(key, value) {
  key = encodeURI(key);
  value = encodeURI(value);

  var kvp = document.location.search.substr(1).split('&');

  var i = kvp.length;
  var x;
  while (i--) {
    x = kvp[i].split('=');

    if (x[0] == key) {
      x[1] = value;
      kvp[i] = x.join('=');
      break;
    }
  }

  if (i < 0) {
    kvp[kvp.length] = [key, value].join('=');
  }

  //this will reload the page, it's likely better to store this until finished
  document.location.search = kvp.join('&');
}

wpNavMenu.registerChange = function() {
  getmenus();
};

$('.item-edit').click(function() {
    $(this).closest('li').find('.icp-auto').iconpicker({placement: "inline"});
})

$(document).on("click", ".iconpicker-item", function () {
  $('.iconpicker-component').trigger("click");
})

$(document).on("click", ".menu-item-bar", function () {
  $("#edit-" + $(this).attr('id')).trigger("click");

  $("#menu-item-" + $(this).attr('id')).hasClass('menu-item-edit-active') ?
  $(this).closest('div').find('.iconpicker-popover').iconpicker({placement: "inline"}) :
  $(this).closest('div').find('.iconpicker-popover').css("display","none").removeClass("in");
});

