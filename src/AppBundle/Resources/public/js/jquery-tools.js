/**
 * Created by dj3 on 14/06/15.
 */

function showSpinner(delay, message) {
    $('.spinner-layout > .spinner-message').html(message);
    $('.spinner-back').fadeIn(delay ? delay : 150);
}
function hideSpinner(delay) {
    $('.spinner-layout > .spinner-message').html('');
    $('.spinner-back').fadeOut(delay ? delay : 150);
}