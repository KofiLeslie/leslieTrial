function deleteMedia(id) {
    $.ajax({
        type: "DELETE",
        url: "/api/media/delete/" + id,
        data: {},
        headers: { Authorization: "Bearer " + $("#token").val() },
        dataType: "json",
        success: function (res) {
            Swal.fire("success", res.message, "success").then(function (t) {
                if (t.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function (res) {
            Swal.fire("Ooops!", res.responseText, "error");
        },
    });
}

function updateMedia(id) {
    $.ajax({
        type: "PATCH",
        url: "/api/media/update/" + id,
        data: { name: $("#name" + id).val() },
        headers: { Authorization: "Bearer " + $("#token").val() },
        dataType: "json",
        success: function (res) {
            Swal.fire("success", res.message, "success").then(function (t) {
                if (t.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function (res) {
            Swal.fire("Ooops!", res.responseText, "error");
        },
    });
}

function fileUpload() {
    event.preventDefault();
    const form = $("#myform")[0];
    let fd = new FormData(form);
    $.ajax({
        type: "POST",
        url: "/api/media",
        data: fd,
        headers: { Authorization: "Bearer " + $("#token").val() },
        contentType: false,
        processData: false,
        dataType: "json",
        cache: false,
        success: function (res) {
            Swal.fire("success", res.message, "success").then(function (t) {
                if (t.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function (res) {
            var stmt = "";
            try {
                var jsonString = JSON.stringify(res.responseJSON.error);
                var jsonSize = jsonString.length;
                if (jsonSize > 0) {
                    stmt = "<ul>";
                    $.each(res.responseJSON.error, function (key, value) {
                        stmt += "<li>" + key + ": " + value + "</li>";
                    });
                    stmt += "</ul>";
                }
            } catch (error) {

            }
            Swal.fire({
                title: "<strong>Ooops!</strong>",
                icon: "error",
                html: "<h5>" + res.responseJSON.message + "</h5> " + stmt,
            });
        },
    });
}
