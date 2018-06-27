$('#Add').click(function () {
    $.post("feed.php", { action: 'add' }, function (result) {
    });
    $.ajax({
        type: "POST",
        url: "feed.php",
        data: "action=add",
        success: function (msg) {
            alert('Added new post!');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("some error");
        }
    });
});

$('#Delete').click(function () {
    $.post("feed.php", { action: 'delete' }, function (result) {
    });
    $.ajax({
        type: "POST",
        url: "feed.php",
        data: "action=add",
        success: function (msg) {
            alert('Delted all post in wordpress!');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("some error");
        }
    });

});