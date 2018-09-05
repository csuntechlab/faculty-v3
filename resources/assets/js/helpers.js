// Reads from master-blade data, which reads from .env file.

/// / Faculty Scaffold && Environment
// ===================================//

var faculty = {
    html: $('html'),
    body: $('body')
};

faculty.env = {
    url: faculty.html.data('url'),
    token: faculty.html.data('token'),
    waldoUrl: faculty.html.data('waldo-url')
};
// Like C#
if (!String.format) {
    String.format = function(format) {
        var args = Array.prototype.slice.call(arguments, 1);
        return format.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
                ;
        });
    };
}

/**
 * Copy HTML attributes from sourceElement to destinationELement.
 * @param sourceElement
 * @param destinationElement
 */
function copyAttributes(sourceElement, destinationElement) {
    let attributes = $(sourceElement).prop("attributes");
// loop through <select> attributes and apply them on <div>
    $.each(attributes, function() {
        $(destinationElement).attr(this.name, this.value);
    });
}

/**
 * changes any tag to a span.
 * @param tag - A string or an object that is directly JQuery-able.
 */
function elementToSpan(tag) {
    let span = $('<span>' + $(tag).text() + '</span>');
    copyAttributes(tag, span);
    tag.replaceWith(span);
}