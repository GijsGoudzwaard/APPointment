ajax({
    method: 'GET',
    destination: '/api/income',
    loader: false,
}, function(res) {
    var total = 0;
    var data = JSON.parse(res);

    for (var i = 0; i < data.length; i++) {
        total += data[i];
    }

    total = total.toString().replace('.', ',');

    var number = $(".earnings h3 span.number");
    $({someValue: '0'}).animate({someValue: parseInt(total)}, {
        duration: 1000,
        easing:'swing',
        step: function() {
            number.text(Math.round(this.someValue));
        },
        complete:function(){
            number.text(Math.round(this.someValue));
        }
    });

    var total_decimal = total.split(',')[1];
    if (typeof total_decimal != 'undefined') {
        var decimal = $(".earnings h3 span.decimal");

        $({someValue: '0'}).animate({someValue: parseInt(total_decimal)}, {
            duration: 1000,
            easing:'swing',
            step: function() {
                decimal.text(',' + Math.round(this.someValue));
            },
            complete:function(){
                decimal.text(',' + Math.round(this.someValue));
            }
        });
    }
});