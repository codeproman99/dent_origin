"use strict";

/*eslint-disable*/

var SCHEDULE_CATEGORY = ["milestone", "task"];

function ScheduleInfo() {
    this.id = null;
    this.calendarId = null;

    this.title = null;
    this.isAllday = false;
    this.start = null;
    this.end = null;
    this.category = "";
    this.dueDateClass = "";
    this.state = "free";
    this.raw = {
        phone_number: "",
        dentist_id: "",
        patient_id: ""
    }

    this.color = null;
    this.bgColor = null;
    this.dragBgColor = null;
    this.borderColor = null;
    this.customStyle = "";

    this.isFocused = false;
    this.isPending = false;
    this.isVisible = true;
    this.isReadOnly = false;
}


function generateScheduleFromData(data) {
    var schedule = new ScheduleInfo();

    schedule.id = data.id;
    schedule.calendarId = data.category;
    schedule.title = data.title;
    schedule.start = new Date(data.start);
    schedule.end = new Date(data.end);
    schedule.category = "time";

    schedule.raw.dentist_id = data.dentist_id;
    if (data.category == 'patients') {
        schedule.raw.phone_number = data.phone_number;
        schedule.raw.patient_id = data.patient_id;
    }

    var scheduleColor =
        colors[data.category] ||
        additionalColors[
            chance.integer({
                min: 0,
                max: additionalColors.length - 1
            })
        ];
    schedule.color = "#fff";
    schedule.bgColor = scheduleColor;
    schedule.dragBgColor = scheduleColor;
    schedule.borderColor = scheduleColor;

    if (schedule.category === "milestone") {
        schedule.color = scheduleColor;
        schedule.bgColor = "transparent";
        schedule.dragBgColor = "transparent";
        schedule.borderColor = "transparent";
    }
    schedule.isReadOnly = data.read_only;

    schedule.location = data.location;
    // schedule.category = SCHEDULE_CATEGORY[chance.integer({ min: 0, max: 1 })];

    return schedule;
}

async function generateSchedule(token, renderStart, renderEnd, dentist_id) {

    var { schedules, scheduleTypes } = await getSchedulesAndTypesFromDB( token, new Date(renderStart), new Date(renderEnd), dentist_id );

    return schedules;

    //   console.log(schedules);
    //   generateRandomSchedule(calendar, renderStart, renderEnd);
}

function getSchedulesAndTypesFromDB(token, start, end, dentist_id) {
    var schedules = [];
    var scheduleTypes = new Set();

    return new Promise(res => {

        $.post('/get-schedules', {
            _token: token,
            start: start,
            end: end,
            dentist_id: dentist_id
        }).then( function(response){
            // console.log(response);

            response.forEach(data => {
                schedules.push( generateScheduleFromData(data) );
            });

            res({schedules});

        });

    });
}

function generateTime(schedule, renderStart, renderEnd) {
    var baseDate = new Date(renderStart);
    var singleday = chance.bool({
        likelihood: 70
    });
    var startDate = moment(renderStart.getTime());
    var endDate = moment(renderEnd.getTime());
    var diffDate = endDate.diff(startDate, "days");

    schedule.isAllday = chance.bool({
        likelihood: 30
    });
    if (schedule.isAllday) {
        schedule.category = "allday";
    } else if (chance.bool({
            likelihood: 30
        })) {
        schedule.category = SCHEDULE_CATEGORY[chance.integer({
            min: 0,
            max: 1
        })];
        if (schedule.category === SCHEDULE_CATEGORY[1]) {
            schedule.dueDateClass = "morning";
        }
    } else {
        schedule.category = "time"
    }

    startDate.add(chance.integer({
        min: 0,
        max: diffDate
    }), "days");
    startDate.hours(chance.integer({
        min: 0,
        max: 23
    }));
    startDate.minutes(chance.bool() ? 0 : 30);
    schedule.start = startDate.toDate();

    endDate = moment(startDate);
    if (schedule.isAllday) {
        endDate.add(chance.integer({
            min: 0,
            max: 3
        }), "days");
    }

    schedule.end = endDate
        .add(chance.integer({
            min: 1,
            max: 4
        }), "hour")
        .toDate();
}

