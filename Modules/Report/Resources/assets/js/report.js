"use strict";
  $(document).ready(function() {
    var loader = `<div class="placeholder wave p-0" style="height: 16px">
                <div class="square"></div>
                </div><div class="placeholder wave p-0" style="height: 16px">
                <div class="square"></div>
                </div>`
    $('.date-range').daterangepicker(daterangeConfig(startDate, endDate), cbRange);
    cbRange(startDate, endDate);
      $('input[name="start_date"]').daterangepicker(dateSingleConfig($('input[name="start_date"]').val()));
      $('input[name="end_date"]').daterangepicker(dateSingleConfig($('input[name="end_date"]').val()));

        getReport('CouponReport');
        function getReport(report) {
          var reportName = report.replace(/[A-Z]/g, ' $&').trim(); // Fetch class name from string
          $('.report-title').html(jsLang(reportName));
          $(".filter-data").hide();
          $("#report_name").attr('disabled', 'disabled');
          $('input').val('');
          $("."+ report).show();
          if(report == 'CustomerOrderReport' || report == 'ShippingReport' || report == 'SaleReport') {
            $(".date-picker-field").show();
          }
          if(report == 'ShippingReport' || report == 'SaleReport') {
            $(".order-status-field").show();
          }
          $('#report-module').html('');
          $('.search-btn').attr("disabled", true);
        $.ajax({
          type: 'get',
          dataType: 'html',
          beforeSend:function () {
            $("#report-module").html(loader);
            $('#loader').show();
            $('.search-btn').text(jsLang('Filtering')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`);
       },
          url: SITE_URL + '/reports',
          data: {
              'type': report,
          },
          success: function (data) {
            if(data) {
              let d = JSON.parse(data);
              $('#report-module').append(d.list);
              $('#loader').hide();
              $('.placeholder').hide();
              $('.spinner-border').remove();
              $('.search-btn').text(jsLang('Filter'));
              $('.search-btn').attr("disabled", false);
              $("#report_name").removeAttr('disabled');
            }
          }
        });
      };

      $(document).on('change', "#report_name", function () {
        getReport($(this).val());
    });


      $(document).on('click', '.search-btn', function(event) {
        event.preventDefault()
        $('.search-btn').attr("disabled", true);
        $('#report-module').html('');
        $.ajax({
          type: 'get',
          dataType: 'html',
          beforeSend:function () {
            $("#report-module").html(loader);
            $('#loader').show();
            $('.search-btn').text(jsLang('Filtering')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status"></div>`);
       },
          url: SITE_URL + '/reports',
          data: {
              'type': $('#report_name').val(),
              'from': $('#startfrom').val(),
              'to': $('#endto').val(),
              'couponCode': $('#coupon-code').val(),
              'brandName': $('#brand-name').val(),
              'categoryName': $('#category-name').val(),
              'tagName': $('#tag-name').val(),
              'customerName': $('#customer-name').val(),
              'customerEmail': $('#customer-email').val(),
              'orderStatus': $('#order_status').val(),
              'shippingMethod': $('#shipping_method').val(),
              'vendorName': $('#vendor-name').val(),
              'qtyAbove': $('#qty-above').val(),
              'qtybellow': $('#qty-bellow').val(),
              'stockAvailability': $('#stock_availability').val(),
              'searchProduct': $('#search-keyword').val(),
          },
          success: function (data) {
            if(data) {
              let d = JSON.parse(data);
              $('#report-module').append(d.list);
              $('#loader').hide();
              $('.placeholder').hide();
              $('.spinner-border').remove();
              $('.search-btn').text(jsLang('Filter'));
              $('.search-btn').attr("disabled", false);
            }
          }
        });
      });
  });

