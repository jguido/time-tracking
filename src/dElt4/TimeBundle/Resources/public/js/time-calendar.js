/**
 * Created by dj3 on 11/06/15.
 */
var projects = null;
jQuery(document).ready(function($){
    $('button[name="btn_save"]').unbind('click').click(function(){
        showSpinner();
        var postData = buildPostData();
        $.ajax({
            url: Routing.generate('path_persist_tracking'),
            type: 'POST',
            dataType : 'json',
            data: postData,
            success : function(code_html, statut){
                hideSpinner();
            },

            error : function(resultat, statut, error){
                alert(error);
                hideSpinner();
            }
        });
    });
    $.get(Routing.generate('path_projects'), function (res) {
        projects = res;
        $('#calendar').fullCalendar({
            header:
            {
                left:   'title',
                center: '',
                right:  'today prev next'
            }
        });
        $('.fc-button-group, .fc button').show();
        initContent();
        var $cell = getCell('2015-06-15');
//                console.log($cell);
//                console.log(getDataDate($cell));
//                console.log(getCell('2015-06-15').parent().parent());
    });

});
function initContent() {
    $('.fc-content-skeleton').find('table>tbody td').each(function(){
        if ($(this).index() === 0 || $(this).index() ===  6) {
            $(this).addClass('weekend-cell');
        }
        var div1 = $('<div class="col-xs-12"><p>AM</p></div>');
        div1.append(buildSelect(projects, 'am'));
        var div2 = $('<div class="col-xs-12"><p>PM</p></div>');
        div2.append(buildSelect(projects, 'pm'));
        var $headCell = getHeadCell($(this).attr('cell-data-date'));
        if ($headCell !== undefined && !$headCell.hasClass('collapsed-cell')) {
            $(this).append(div1);
            $(this).append(div2);
            $(this).attr('cell-data-date', getDataDate($(this)));
            $(this).addClass('fc-day');
            $(this).addClass('fc-day-cell');
        }
    });
    $(".fc-other-month").each(function(){
        $(this).addClass('collapsed-cell');
        getCell($(this).attr('data-date')).addClass('collapsed-cell');
    });
    $('select.select-calendar').select2();
    setCalendarValues();
    $('button.fc-prev-button').unbind('click').click(function(){
        showSpinner();
        $('#calendar').fullCalendar('prev');
        initContent();
    });
    $('button.fc-next-button').unbind('click').click(function(){
        showSpinner();
        $('#calendar').fullCalendar('next');
        initContent();
    });
    $('button.fc-today-button').unbind('click').click(function(){
        showSpinner();
        $('#calendar').fullCalendar('today');
        initContent();
    });
}
function buildSelect(values, type, id) {
    var $select = $('<select class="select-calendar" style="width:90%;margin-bottom: 5px;" data-type="'+type+'"></select>');
    $select.append('<option value=""></option>');
    for(var i in values) {
        var value = values[i];
        if (value.id && value.title) {
            if (value.id === id) {
                var sel = 'SELECTED="SELECTED"';
            } else {
                var sel = '';
            }
            $select.append('<option value="'+ value.id +'" '+ sel +'>'+ value.title +'</option>')
        }
    }

    return $select;
}
function getDataDate($el) {
    var index = $el.index();

    return $el.parent().parent().parent().find('>thead>tr>td:eq('+index+')').attr('data-date');
}
function getHeadCell(date) {
    return $('.fc-day[data-date="'+date+'"]');
}
function getCell(date) {

    return $('.fc-day[cell-data-date="'+date+'"]');
}
function setCalendarValues() {
    var date = $("#calendar").fullCalendar('getDate');
    $.get(Routing.generate('path_events', {'date': date.format('YYYY-MM')}), function(strEvents){
        var events = JSON.parse(strEvents);
        if (events) {
            for(var e in events) {
                var event = events[e];

                var $cell = getCell(event.day);
                $cell.find('select[data-type="'+ event.type +'"]').attr('data-id', event.id);

                $cell.find('select[data-type="'+ event.type +'"]').select2("val", event.project.id)
                if (event.locked == true) {
                    $cell.find('select').disabled();
                }
            }
        }
        hideSpinner();
    });
}

function buildPostData() {
    var date = $("#calendar").fullCalendar('getDate');
    var postData = {
        'month': date.format('YYYY-MM'),
        'days': new Array()
    };
    $('.fc-day-cell').each(function(){
        if (!$(this).hasClass('collapsed-cell')) {
            if ($(this).find('select[data-type="am"]').val()) {
                var row = {
                    'date': $(this).attr('cell-data-date'),
                    'am': {
                        id: $(this).find('select[data-type="am"]').attr('data-id'),
                        project: $(this).find('select[data-type="am"]').val(),
                        date: $(this).attr('cell-data-date')
                    },
                    'pm': {
                        id: $(this).find('select[data-type="pm"]').attr('data-id'),
                        project: $(this).find('select[data-type="pm"]').val(),
                        date: $(this).attr('cell-data-date')
                    }
                };
            }
            postData.days.push(row);
        }
    });

    return postData;
}
function showSpinner(delay, message) {
    $('.spinner-layout > .spinner-message').html(message);
    $('.spinner-back').fadeIn(delay ? delay : 150);
}
function hideSpinner(delay) {
    $('.spinner-layout > .spinner-message').html('');
    $('.spinner-back').fadeOut(delay ? delay : 150);
}