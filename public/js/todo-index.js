function ubahTodo(id) {
    $(`#${id} label`).addClass("hidden");
    $("#edit-" + id).addClass("hidden");
    $("#check-" + id).removeClass("hidden");
    $("#input-" + id).removeClass("hidden");
}

function updateTodo(id) {
    $(`#${id} label`).removeClass("hidden");
    $("#edit-" + id).removeClass("hidden");
    $("#check-" + id).addClass("hidden");
    $("#input-" + id).addClass("hidden");
    var inputBaru = $("#input-" + id).val();
    $("#activity-edit-" + id).val(inputBaru);
    $("#update-" + id).submit();
}

function checkedTodo(id) {
    $.ajax({
        url: "/todo/checked/" + id,
        method: "PUT",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            method_field: "PUT",
        },
        success: function (response) {
            if (response.status === 1) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Congratss for your achievement 😇",
                });
            }
        },
    });
}

$(document).ready(function () {
    $(".confirm-button").click(function (event) {
        var form = $(this).closest("form");
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
