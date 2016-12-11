$(function () {
	$('[data-toggle="popover"]').popover()
})

$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
