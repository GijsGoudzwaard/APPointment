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

    $('.earnings h3 span').text(total);
});
