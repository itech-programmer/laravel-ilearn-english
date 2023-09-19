function question_image(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#question-preview').css('background-image', 'url('+e.target.result +')');
            $('#question-preview').hide();
            $('#question-preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#question-image-upload").change(function() {
    question_image(this);
});

$("#answer-1").on("change", ".answer-image", function () {
    $(this)
        .parent(".answer-image-wrapper")
        .attr(
            "data-text",
            $(this)
                .val()
                .replace(/.*(\/|\\)/, "")
        );
});

$("#answer-2").on("change", ".answer-image", function () {
    $(this)
        .parent(".answer-image-wrapper")
        .attr(
            "data-text",
            $(this)
                .val()
                .replace(/.*(\/|\\)/, "")
        );
});

$("#answer-3").on("change", ".answer-image", function () {
    $(this)
        .parent(".answer-image-wrapper")
        .attr(
            "data-text",
            $(this)
                .val()
                .replace(/.*(\/|\\)/, "")
        );
});

$("#answer-4").on("change", ".answer-image", function () {
    $(this)
        .parent(".answer-image-wrapper")
        .attr(
            "data-text",
            $(this)
                .val()
                .replace(/.*(\/|\\)/, "")
        );
});

function upload_image(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#image-preview').css('background-image', 'url('+e.target.result +')');
            $('#image-preview').hide();
            $('#image-preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#image-upload").change(function() {
    upload_image(this);
});
