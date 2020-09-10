"use strict";

/* eslint-disable require-jsdoc */
/* eslint-env jquery */
/* global moment, tui, chance */
/* global findCalendar, CalendarList, generateSchedule */
/* global _token, current_user, user_role, patient_base_url  */

async function createScheduleService(token, userRole, selfManager, dentist_id, scheduleData){

    var url = "";
    var var_error_add = $("#var_error_add").text();
    var var_warning = $("#var_warning").text();

    if(userRole == 2 && selfManager == false){
        url = "/create-schedule";
        return await $.post(url, {
            _token: token,
            id: scheduleData.id,
            title: scheduleData.title,
            dentist_id: dentist_id,
            phone_number: scheduleData.raw.phone_number,
            start: scheduleData.start.getTime() / 1000,
            end: scheduleData.end.getTime() / 1000
        });
    } else {
        url = "/create-patient";
        var confirm = await $.post('/available-create-patient', {
            _token: token,
            dentist_id: dentist_id,
            start: scheduleData.start.getTime() / 1000,
            end: scheduleData.end.getTime() / 1000
        });

        if(confirm.result == true){
            return  await $.post(url, {
                _token: token,
                id: scheduleData.id,
                title: scheduleData.title,
                dentist_id: dentist_id,
                phone_number: scheduleData.raw.phone_number,
                start: scheduleData.start.getTime()/1000,
                end: scheduleData.end.getTime()/1000
            });
        } else {
            toastr.error(var_error_add, var_warning);
            return { result: false };
        }

    }

}

async function updateScheduleService(token, userRole, selfManager, dentist_id, scheduleData){

    var url = "";
    var var_error_modify = $("#var_error_modify").text();
    var var_warning = $("#var_warning").text();

    if (userRole == 2 && selfManager == false) {
        url = "/update-schedule";
        return await $.post(url, {
            _token: token,
            id: scheduleData.id,
            title: scheduleData.title,
            dentist_id: dentist_id,
            phone_number: scheduleData.raw.phone_number,
            start: scheduleData.start.getTime() / 1000,
            end: scheduleData.end.getTime() / 1000
        });

    } else {
        url = "/update-patient";
        var confirm = await $.post('/available-create-patient', {
            _token: token,
            dentist_id: dentist_id,
            start: scheduleData.start.getTime() / 1000,
            end: scheduleData.end.getTime() / 1000
        });

        if (confirm.result == true) {
            return await $.post(url, {
                _token: token,
                id: scheduleData.id,
                title: scheduleData.title,
                dentist_id: dentist_id,
                phone_number: scheduleData.raw.phone_number,
                start: scheduleData.start.getTime() / 1000,
                end: scheduleData.end.getTime() / 1000
            });
        }else {
            toastr.error(var_error_modify, var_warning);
            return {
                result: false
            };
        }

    }

}

async function deleteScheduleService(token, userRole, selfManager, id){
    var url = "";
    if (userRole == 2 && selfManager == false) {
        url = "/delete-schedule";
    } else {
        url = "/delete-patient";
    }

    return await $.post(url, {
        _token: token,
        id: id,
    });

}

function downloadCsv(token, dentist_id, date){
    window.open('/download-csv?dentist_id='+dentist_id+'&date='+date['date'], '_blank');
}

$(document).ready(function () {

    /**
     * Initialization Page Information
     */
    const _token = $('meta[name="csrf-token"]').attr("content");
    const userRole = $('#user_role').val();
    const dentist_id = $('#dentist_id').val();
    const selfManager = $('#self_manager').val();
    const currentUser = $('#current_user').val();
    const patientBaseURL = $('#patient_base_url').val();

    var current_schedule_id = $('#current_selected_schedule_id');
    var current_calendar_id = $('#current_selected_calendar_id');

    /** Page Variables */
    var cal, resizeThrottled;
    var useCreationPopup = false;
    var useDetailPopup = false;
    var datePicker, selectedCalendar;

    /** Calendar Popup */
    $('.tui-full-calendar-popup').hide();

    $(document).mouseup(function (e) {
        var container = $(".tui-full-calendar-popup");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            resetPopup();
            container.hide();
        }
    });

    $('.tui-full-calendar-popup-close').on('click', function(e){
        $('.tui-full-calendar-popup').hide();
    });

    function resetPopup() {
        $('.tui-full-calendar-schedule-start-date').each(function(){
            this.val('');
        });

        $('.tui-full-calendar-schedule-end-date').each(function(){
            this.val('')
        });

        $('#patient_book_modal #tui-full-calendar-schedule-title').val('');
        $('#patient_book_modal #tui-full-calendar-schedule-phone').val('');

        $('#current_selected_schecule_id').val('');
        $('#current_selected_calendar_id').val('');
        $('.tui-full-calendar-popup').hide();
    }

    /** Popup Events */
    $('.tui-full-calendar-popup-save').on('click', function(e){
        e.preventDefault();
        if(userRole == 2 && selfManager == false) {
            if (current_schedule_id.val() != ''){
                onUpdateSchedule('dentist_schedule_modal', current_schedule_id.val(), current_calendar_id.val());
            }else {
                onNewSchedule('dentist_schedule_modal');
            }
        } else {
            if (current_schedule_id.val() != '') {
                onUpdateSchedule('patient_book_modal', current_schedule_id.val(), current_calendar_id.val())
            }else {
                onNewSchedule('patient_book_modal');
            }
        }
    });

    $('.tui-full-calendar-popup-edit').on('click', function (e) {
        e.preventDefault();
        var current_schedule = cal.getSchedule(current_schedule_id.val(), current_calendar_id.val());

        if (current_schedule.calendarId == 'dentist_ft') {
            $('#detail_modal').hide();
            createDatePicker(current_schedule.start, current_schedule.end, false, 'dentist_schedule_modal');
            modalShow('dentist_schedule_modal');
        } else if (current_schedule.calendarId == 'patients') {
            $('#detail_modal').hide();
            createDatePicker(current_schedule.start, current_schedule.end, false, 'patient_book_modal');
            modalShow('patient_book_modal');
        }

    });

    $('.tui-full-calendar-popup-delete').on('click', function (e) {
        e.preventDefault();
        deleteScheduleService(_token, userRole, selfManager, current_schedule_id.val()).then(function (res) {
             cal.deleteSchedule(current_schedule_id.val(), current_calendar_id.val());
             resetPopup();
        });
    });


    /** Define Calendar */

    cal = new tui.Calendar("#calendar", {
        defaultView: "week",
        useCreationPopup: useCreationPopup,
        useDetailPopup: useDetailPopup,
        calendars: CalendarList,
        usageStatistics: false,
        template: {
            milestone: function (model) {
                return (
                    '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' +
                    model.bgColor +
                    '">' +
                    model.title +
                    "</span>"
                );
            },
            allday: function (schedule) {
                return getTimeTemplate(schedule, true);
            },
            time: function (schedule) {
                return getTimeTemplate(schedule, false);
            }
        }
    });

    /** Calendar Event handlers*/
    cal.on({
        clickMore: function (e) {
            console.log("clickMore", e);
        },
        clickSchedule: function (e) {
            console.log("clickSchedule", e);
            detailModalShow(e);
        },
        clickDayname: function (date) {
            console.log("clickDayname", date);
            // if (userRole == 2 && selfManager == false){
            //     downloadCsv(_token, dentist_id, date);
            // }
        },
        beforeCreateSchedule: function (e) {
            if( userRole == 2 && selfManager == false ){
                createDatePicker(e.start, e.end, false, 'dentist_schedule_modal');
                modalShow('dentist_schedule_modal');
            } else {
                createDatePicker(e.start, e.end, false, 'patient_book_modal');
                modalShow('patient_book_modal');
            }
            // e.guide.clearGuideElement();
        },
        beforeUpdateSchedule: function (e) {
            console.log("beforeUpdateSchedule", e);
            e.schedule.start = e.start;
            e.schedule.end = e.end;
            ( async() => {
                var confirmation = await updateScheduleService(_token, userRole, selfManager, dentist_id, e.schedule);
                if( confirmation.result == true ){
                    cal.updateSchedule(e.schedule.id, e.schedule.calendarId, e.schedule);
                }
                resetPopup();
                $(".tui-full-calendar-popup").hide();
            })();
        },
        beforeDeleteSchedule: function (e) {
            console.log("beforeDeleteSchedule", e);
            cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
            deleteScheduleService(_token, userRole, selfManager, e.schedule.id);
        },
        afterRenderSchedule: function (e) {
            var schedule = e.schedule;
            // var element = cal.getElement(schedule.id, schedule.calendarId);
            // console.log('afterRenderSchedule', element);
        },
        clickTimezonesCollapseBtn: function (timezonesCollapsed) {
            console.log("timezonesCollapsed", timezonesCollapsed);

            if (timezonesCollapsed) {
                cal.setTheme({
                    "week.daygridLeft.width": "77px",
                    "week.timegridLeft.width": "77px"
                });
            } else {
                cal.setTheme({
                    "week.daygridLeft.width": "60px",
                    "week.timegridLeft.width": "60px"
                });
            }

            return true;
        }
    });

    /**
     * Create Date Pickers in popup modal
     * @param {datetime} start
     * @param {datetime} end
     * @param {boolean} isAllDay
     * @param {Element} parentElement
     */
    function createDatePicker(start, end, isAllDay, parentElement){

        var DatePicker = tui.DatePicker;

        var container_start = $('#' + parentElement + ' #tui-full-calendar-startpicker-container');
        var target_start = $('#' + parentElement + ' #tui-full-calendar-schedule-start-date');
        var container_end = $('#' + parentElement + ' #tui-full-calendar-endpicker-container');
        var target_end = $('#' + parentElement + ' #tui-full-calendar-schedule-end-date');

        var start_date = start ? new Date( start ) : new Date();
        var end_date = end ? new Date( end ) : new Date();

        // $('#tui-full-calendar-schedule-start-date').val(draggingDataInfo.start);
        //   var start_time = moment(draggingDataInfo.start.toUTCString());
        //   console.log(moment(draggingDataInfo.start));
        //   console.log(start_time.format('HH:mm'));

        datePicker = DatePicker.createRangePicker({
            startpicker: {
                date: start_date,
                input: target_start,
                container: container_start
            },
            endpicker: {
                date: end_date,
                input: target_end,
                container: container_end
            },
            format: isAllDay ? 'yyyy-MM-dd' : 'yyyy-MM-dd HH:mm',
            timepicker: isAllDay ? null : {
                showMeridiem: false,
                usageStatistics: false
            },
            usageStatistics: false
        });
    }

    /**
     * Popup Modal show by the element ID
     * @param {Element} element
     */
    function modalShow(element){

        // calc pop position
        var parent_width = $('.card-body #right').width();
        var parent_height = $('.card-body #right').height();

        var position_top = parseFloat(parent_height / 2 - 173 / 2);
        var position_left = parseFloat(parent_width / 2 - 474 / 2);

        $('#'+element).attr("style", "top:" + position_top + "px; left:" + position_left + "px");
        // $('#calendar').block();
        $('#'+element).show();

        if (element == 'dentist_schedule_modal'){
            $('#tui-full-calendar-schedule-title').prop("readonly", true);
        } else {
            $('#tui-full-calendar-schedule-title').prop("readonly", false);
        }

        if( current_calendar_id.val() != '' && current_schedule_id.val() != ''){
            var current_schedule = cal.getSchedule(current_schedule_id.val(), current_calendar_id.val());
            if(current_calendar_id.val() == 'patients'){
                $('#patient_book_modal #tui-full-calendar-schedule-title').val(current_schedule.title);
                $('#tui-full-calendar-schedule-phone').val(current_schedule.raw.phone_number);
            }
        }

    }

    function detailModalShow(e){

        var current_schedule = e.schedule;

        // calc pop position
        var parent_width = $('.card-body #right').width();
        var parent_height = $('.card-body #right').height();
        var position_top = parseFloat(parent_height / 2 - 158 / 2);
        var position_left = parseFloat(parent_width / 2 - 301 / 2);
        $('#detail_modal').attr("style", "top:" + position_top + "px; left:" + position_left + "px");

        switch (current_schedule.calendarId) {
            case 'dentist_ft':
                current_schedule_id.val(current_schedule.id);
                current_calendar_id.val(current_schedule.calendarId);

                $('#detail_modal .tui-full-calendar-schedule-title').text(current_schedule.title);
                $('#detail_modal .tui-full-calendar-popup-detail-date').html(getTimeforDetailModal(current_schedule));
                $('#detail_modal .phone').hide();
                $('#detail_modal .tui-full-calendar-calendar-dot').css('background-color', current_schedule.bgColor);
                $('#detail_modal .calendar-type .tui-full-calendar-content').text("Dentist Free Time");
                if(current_schedule.isReadOnly){
                    $('.tui-full-calendar-section-button').hide();
                }else {
                    $('.tui-full-calendar-section-button').show();
                }
                $('#patient-link').hide();
                $('#detail_modal').show();

                break;
            case 'patients':
                current_schedule_id.val(current_schedule.id);
                current_calendar_id.val(current_schedule.calendarId);

                $('#detail_modal .tui-full-calendar-schedule-title').text(current_schedule.title);
                $('#detail_modal .tui-full-calendar-popup-detail-date').html(getTimeforDetailModal(current_schedule));
                $('#detail_modal .phone').show();
                $('#detail_modal .phone .tui-full-calendar-content').text(current_schedule.raw.phone_number);
                $('#detail_modal .tui-full-calendar-calendar-dot').css('background-color', current_schedule.bgColor);
                $('#detail_modal .calendar-type .tui-full-calendar-content').text("Patients");
                if (current_schedule.isReadOnly) {
                    $('.tui-full-calendar-section-button').hide();
                    $('#patient-link').show();
                    $('#patient-link').attr('href', "/patients/" + current_schedule.raw.patient_id);
                } else {
                    $('.tui-full-calendar-section-button').show();
                    $('#patient-link').hide();
                }
                $('#detail_modal').show();

                break;
            default:
                break;
        }

    }

    function getTimeforDetailModal(schedule){
        var start_year = schedule.start.getFullYear(),
            start_month = schedule.start.getMonth(),
            start_date = schedule.start.getDate(),
            start_hour = schedule.start.getHours(),
            start_minute = schedule.start.getMinutes(),
            end_year = schedule.end.getFullYear(),
            end_month = schedule.end.getMonth(),
            end_date = schedule.end.getDate(),
            end_hour = schedule.end.getHours(),
            end_minute = schedule.end.getMinutes();

            // console.log(schedule.start.format('Y.m.d'));

            var date_string = "";
            if(start_year == end_year && start_month == end_month && start_date == end_date) {
                 date_string = start_year + '.' + start_month + '.' + start_date + ' ' + start_hour + ':' + start_minute + ' - ' + end_hour + ':' + end_minute;
            } else {
                date_string = start_year + '.' + start_month + '.' + start_date + ' ' + start_hour + ':' + start_minute + ' - ' + start_year + '.' + start_month + '.' + start_date + ' ' + end_hour + ':' + end_minute;
            }

            return "<span style='font-size: 12px; font-weight: 400; text-align:center; width: 100%; padding-left: 1.5rem;'>" + date_string + "</span>";
    }


    /**
     * Get time template for time and all-day
     * @param {Schedule} schedule - schedule
     * @param {boolean} isAllDay - isAllDay or hasMultiDates
     * @returns {string}
     */
    function getTimeTemplate(schedule, isAllDay) {
        var html = [];
        var start = moment(schedule.start.toUTCString());
        if (!isAllDay) {
            html.push("<strong>" + start.format("HH:mm") + "</strong> ");
        }
        if (schedule.isPrivate) {
            html.push('<span class="calendar-font-icon ic-lock-b"></span>');
            html.push(" Private");
        } else {
            if (schedule.isReadOnly) {
                html.push('<span class="calendar-font-icon ic-readonly-b"></span>');
            } else if (schedule.recurrenceRule) {
                html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
            } else if (schedule.attendees.length) {
                html.push('<span class="calendar-font-icon ic-user-b"></span>');
            } else if (schedule.location) {
                html.push('<span class="calendar-font-icon ic-location-b"></span>');
            }
            html.push(" " + schedule.title);
        }

        return html.join("");
    }

    /**
     * A listener for click the menu
     * @param {Event} e - click event
     */
    function onClickMenu(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var action = getDataAction(target);
        var options = cal.getOptions();
        var viewName = "";

        console.log(target);
        console.log(action);
        switch (action) {
            case "toggle-daily":
                viewName = "day";
                break;
            case "toggle-weekly":
                viewName = "week";
                break;
            case "toggle-monthly":
                options.month.visibleWeeksCount = 0;
                viewName = "month";
                break;
            case "toggle-weeks2":
                options.month.visibleWeeksCount = 2;
                viewName = "month";
                break;
            case "toggle-weeks3":
                options.month.visibleWeeksCount = 3;
                viewName = "month";
                break;
            case "toggle-narrow-weekend":
                options.month.narrowWeekend = !options.month.narrowWeekend;
                options.week.narrowWeekend = !options.week.narrowWeekend;
                viewName = cal.getViewName();

                target.querySelector("input").checked = options.month.narrowWeekend;
                break;
            case "toggle-start-day-1":
                options.month.startDayOfWeek = options.month.startDayOfWeek ? 0 : 1;
                options.week.startDayOfWeek = options.week.startDayOfWeek ? 0 : 1;
                viewName = cal.getViewName();

                target.querySelector("input").checked = options.month.startDayOfWeek;
                break;
            case "toggle-workweek":
                options.month.workweek = !options.month.workweek;
                options.week.workweek = !options.week.workweek;
                viewName = cal.getViewName();

                target.querySelector("input").checked = !options.month.workweek;
                break;
            default:
                break;
        }

        cal.setOptions(options, true);
        cal.changeView(viewName, true);

        setDropdownCalendarType();
        setRenderRangeText();
        setSchedules();
    }

    function onClickNavi(e) {
        var action = getDataAction(e.target);

        switch (action) {
            case "move-prev":
                cal.prev();
                break;
            case "move-next":
                cal.next();
                break;
            case "move-today":
                cal.today();
                break;
            default:
                return;
        }

        setRenderRangeText();
        setSchedules();
    }

    /**
     * Create new Schedule from modal
     */
    function onNewSchedule(parentElement) {

        var title = $('#' + parentElement + ' #tui-full-calendar-schedule-title').val();
        var phone_number = $('#' + parentElement + ' #tui-full-calendar-schedule-phone').val();
        var location = "";
        var isAllDay = false;
        var start = datePicker.getStartDate();
        var end = datePicker.getEndDate();
        var calendar = (userRole == 2 && selfManager == false) ? CalendarList[0]: CalendarList[1];

        if (!title) {
            return;
        }

        var scheduleData = {
            id: String(chance.guid()),
            calendarId: calendar.id,
            title: title,
            location: location,
            isAllDay: false,
            start: start,
            end: end,
            category: "time",
            dueDateClass: "",
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            raw: {
                phone_number: phone_number,
                dentist_id: dentist_id,
            },
            state: "free"
        };

        (async ()=> {
            var confirmation = await createScheduleService(_token, userRole, selfManager, dentist_id, scheduleData);

            if(confirmation.result == true){
                cal.createSchedules([scheduleData]);
            }

            resetPopup();
            $(".tui-full-calendar-popup").hide();

        })();

    }

    function onUpdateSchedule(parentElement, schedule_id, calendar_id){

        var title = $('#' + parentElement + ' #tui-full-calendar-schedule-title').val(),
            phone_number = $('#' + parentElement + ' #tui-full-calendar-schedule-phone').val(),
            location = "",
            isAllDay = false,
            start = datePicker.getStartDate(),
            end = datePicker.getEndDate();

        if (!title) {
            return;
        }

        var origin_schedule = cal.getSchedule(schedule_id, calendar_id);
        var scheduleData = {
            ... origin_schedule,
            id: schedule_id,
            title: title,
            start: start,
            end: end,
            raw: {
                phone_number: phone_number,
                dentist_id: dentist_id
            },
        };

        (async () => {
            var confirmation = await updateScheduleService(_token, userRole, selfManager, dentist_id, scheduleData);

            if (confirmation.result == true) {
                cal.updateSchedule(schedule_id, calendar_id, scheduleData);
            }

            resetPopup();
            $(".tui-full-calendar-popup").hide();

        })();
    }

    function onChangeNewScheduleCalendar(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var calendarId = getDataAction(target);
        changeNewScheduleCalendar(calendarId);
    }

    function changeNewScheduleCalendar(calendarId) {
        var calendarNameElement = document.getElementById("calendarName");
        var calendar = findCalendar(calendarId);
        var html = [];

        html.push(
            '<span class="calendar-bar" style="background-color: ' +
            calendar.bgColor +
            "; border-color:" +
            calendar.borderColor +
            ';"></span>'
        );
        html.push('<span class="calendar-name">' + calendar.name + "</span>");

        calendarNameElement.innerHTML = html.join("");

        selectedCalendar = calendar;
    }

    function createNewSchedule(event) {
        var start = event.start ? new Date(event.start.getTime()) : new Date();
        var end = event.end ?
            new Date(event.end.getTime()) :
            moment()
            .add(1, "hours")
            .toDate();

        if (useCreationPopup) {
            cal.openCreationPopup({
                start: start,
                end: end
            });
        }
    }

    function saveNewSchedule(scheduleData) {
        var calendar =
            scheduleData.calendar || findCalendar(scheduleData.calendarId);
        var schedule = {
            id: String(chance.guid()),
            title: scheduleData.title,
            isAllDay: scheduleData.isAllDay,
            start: scheduleData.start,
            end: scheduleData.end,
            category: scheduleData.isAllDay ? "allday" : "time",
            dueDateClass: "",
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            location: scheduleData.location,
            raw: {
                class: scheduleData.raw["class"]
            },
            state: scheduleData.state
        };
        if (calendar) {
            schedule.calendarId = calendar.id;
            schedule.color = calendar.color;
            schedule.bgColor = calendar.bgColor;
            schedule.borderColor = calendar.borderColor;
        }

        cal.createSchedules([schedule]);

        refreshScheduleVisibility();
    }

    function onChangeCalendars(e) {
        var calendarId = e.target.value;
        var checked = e.target.checked;
        var viewAll = document.querySelector(".lnb-calendars-item input");
        var calendarElements = Array.prototype.slice.call(
            document.querySelectorAll("#calendarList input")
        );
        var allCheckedCalendars = true;

        if (calendarId === "all") {
            allCheckedCalendars = checked;

            calendarElements.forEach(function (input) {
                var span = input.parentNode;
                input.checked = checked;
                span.style.backgroundColor = checked ?
                    span.style.borderColor :
                    "transparent";
            });

            CalendarList.forEach(function (calendar) {
                calendar.checked = checked;
            });
        } else {
            findCalendar(calendarId).checked = checked;

            allCheckedCalendars = calendarElements.every(function (input) {
                return input.checked;
            });

            if (allCheckedCalendars) {
                viewAll.checked = true;
            } else {
                viewAll.checked = false;
            }
        }

        refreshScheduleVisibility();
    }

    function refreshScheduleVisibility() {
        var calendarElements = Array.prototype.slice.call(
            document.querySelectorAll("#calendarList input")
        );

        CalendarList.forEach(function (calendar) {
            cal.toggleSchedules(calendar.id, !calendar.checked, false);
        });

        cal.render(true);

        calendarElements.forEach(function (input) {
            var span = input.nextElementSibling;
            span.style.backgroundColor = input.checked ?
                span.style.borderColor :
                "transparent";
        });
    }

    function setDropdownCalendarType() {
        var calendarTypeName = document.getElementById("calendarTypeName");
        var calendarTypeIcon = document.getElementById("calendarTypeIcon");
        var options = cal.getOptions();
        var type = cal.getViewName();
        var iconClassName;

        var var_cal_daily = $("#var_cal_daily").text();
        var var_cal_weekly = $("#var_cal_weekly").text();
        var var_cal_2weeks= $("#var_cal_2weeks").text();
        var var_cal_3weeks = $("#var_cal_3weeks").text();
        var var_cal_monthly = $("#var_cal_monthly").text();

        if (type === "day") {
            type = var_cal_daily;
            iconClassName = "calendar-icon ic_view_day";
        } else if (type === "week") {
            type = var_cal_weekly;
            iconClassName = "calendar-icon ic_view_week";
        } else if (options.month.visibleWeeksCount === 2) {
            type = var_cal_2weeks;
            iconClassName = "calendar-icon ic_view_week";
        } else if (options.month.visibleWeeksCount === 3) {
            type = var_cal_3weeks;
            iconClassName = "calendar-icon ic_view_week";
        } else {
            type = var_cal_monthly;
            iconClassName = "calendar-icon ic_view_month";
        }

        calendarTypeName.innerHTML = type;
        calendarTypeIcon.className = iconClassName;
    }

    function setRenderRangeText() {
        var renderRange = document.getElementById("renderRange");
        var options = cal.getOptions();
        var viewName = cal.getViewName();
        var html = [];
        if (viewName === "day") {
            html.push(moment(cal.getDate().getTime()).format("YYYY.MM.DD"));
        } else if (
            viewName === "month" &&
            (!options.month.visibleWeeksCount ||
                options.month.visibleWeeksCount > 4)
        ) {
            html.push(moment(cal.getDate().getTime()).format("YYYY.MM"));
        } else {
            html.push(
                moment(cal.getDateRangeStart().getTime()).format("YYYY.MM.DD")
            );
            html.push(" ~ ");
            html.push(moment(cal.getDateRangeEnd().getTime()).format(" MM.DD"));
        }
        renderRange.innerHTML = html.join("");
    }

    async function setSchedules() {
        cal.clear();
        var schedules = await generateSchedule(
            _token,
            cal.getDateRangeStart(),
            cal.getDateRangeEnd(),
            dentist_id
        );
        // console.log("Schedules :", schedules);
        // console.log("CalendarList :", CalendarList);
        cal.createSchedules(schedules);
        console.log(cal);
        refreshScheduleVisibility();
    }

    function setEventListener() {
        $("#menu-navi").on("click", onClickNavi);
        $('.dropdown-menu a[role="menuitem"]').on("click", onClickMenu);
        $("#lnb-calendars").on("change", onChangeCalendars);

        $("#btn-save-schedule").on("click", onNewSchedule);
        $("#btn-new-schedule").on("click", createNewSchedule);

        $("#dropdownMenu-calendars-list").on(
            "click",
            onChangeNewScheduleCalendar
        );

        window.addEventListener("resize", resizeThrottled);
    }

    function getDataAction(target) {
        return target.dataset ?
            target.dataset.action :
            target.getAttribute("data-action");
    }

    $("#calendar").ready(function () {
        resizeThrottled = tui.util.throttle(function () {
            cal.render();
        }, 50);

        window.cal = cal;

        setDropdownCalendarType();
        setRenderRangeText();
        setSchedules();
        setEventListener();
    });


    // set calendars
    (function () {
        var calendarList = document.getElementById("calendarList");
        var html = [];
        CalendarList.forEach(function (calendar) {
            if( !(selfManager == true && calendar.id == 'dentist_ft')){
                html.push(
                    '<div class="lnb-calendars-item"><label>' +
                    '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' +
                    calendar.id +
                    '" checked>' +
                    '<span style="border-color: ' +
                    calendar.borderColor +
                    "; background-color: " +
                    calendar.borderColor +
                    ';"></span>' +
                    "<span>" +
                    calendar.name +
                    "</span>" +
                    "</label></div>"
                );
            }
        });
        calendarList.innerHTML = html.join("\n");
    })();
});
