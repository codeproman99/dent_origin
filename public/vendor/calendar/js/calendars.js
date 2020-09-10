"use strict";

/* eslint-disable require-jsdoc, no-unused-vars */

var CalendarList = [];

function CalendarInfo() {
    this.id = null;
    this.name = null;
    this.checked = true;
    this.color = null;
    this.bgColor = null;
    this.borderColor = null;
}

function addCalendar(calendar) {
    CalendarList.push(calendar);
}

function findCalendar(id) {
    var found;

    CalendarList.forEach(function (calendar) {
        if (calendar.id === id) {
            found = calendar;
        }
    });

    return found;
}

function hexToRGBA(hex) {
    var radix = 16;
    var r = parseInt(hex.slice(1, 3), radix),
        g = parseInt(hex.slice(3, 5), radix),
        b = parseInt(hex.slice(5, 7), radix),
        a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
    var rgba = "rgba(" + r + ", " + g + ", " + b + ", " + a + ")";

    return rgba;
}

var colors = {
    dentist_ft: "#5ed84f",
    patients: "#fdb901",
};

var additionalColors = [
    "#9e5fff",
    "#32cafe",
    "#28afd0",
    "#f44982",
    "#5ed84f",
    "#fc7303",
    "#0063dc",
    "#fdb901"
];

(function () {

    var calendar;

    // TODO: Automate calendar adding, while adding it,
    // if color is not available it will choose from additional colors
    // use this additionalColors[choice.integer({min: 0, max: additionalColors.length - 1})]
    //   calendar = new CalendarInfo();
    //   calendar.id = "notes";
    //   calendar.name = "notes";
    //   calendar.color = "#ffffff";
    //   calendar.bgColor = colors.notes;
    //   calendar.dragBgColor = colors.notes;
    //   calendar.borderColor = colors.notes;
    //   addCalendar(calendar);

    //   calendar = new CalendarInfo();
    //   calendar.id = "labs";
    //   calendar.name = "labs";
    //   calendar.color = "#ffffff";
    //   calendar.bgColor = colors.labs;
    //   calendar.dragBgColor = colors.labs;
    //   calendar.borderColor = colors.labs;
    //   addCalendar(calendar);

    calendar = new CalendarInfo();
    calendar.id = "dentist_ft";
    calendar.name = "Studio Free Time";
    calendar.color = "#ffffff";
    calendar.bgColor = colors.dentist_ft;
    calendar.dragBgColor = colors.dentist_ft;
    calendar.borderColor = colors.dentist_ft;
    addCalendar(calendar);

    calendar = new CalendarInfo();
    calendar.id = "patients";
    calendar.name = "Patients";
    calendar.color = "#ffffff";
    calendar.bgColor = colors.patients;
    calendar.dragBgColor = colors.patients;
    calendar.borderColor = colors.patients;
    addCalendar(calendar);


    /////////////////////////////////////////////////////////////////////////////////////////////////
    //  You can add new calendar categories
    /////////////////////////////////////////////////////////////////////////////////////////////////

    /*
      calendar = new CalendarInfo();
      id += 1;
      calendar.id = String(id);
      calendar.name = 'National Holidays';
      calendar.color = '#ffffff';
      calendar.bgColor = '#28afd0';
      calendar.dragBgColor = '#28afd0';
      calendar.borderColor = '#28afd0';
      addCalendar(calendar);

      calendar = new CalendarInfo();
      id += 1;
      calendar.id = String(id);
      calendar.name = 'Family';
      calendar.color = '#ffffff';
      calendar.bgColor = '#f44982';
      calendar.dragBgColor = '#f44982';
      calendar.borderColor = '#f44982';
      addCalendar(calendar);

      calendar = new CalendarInfo();
      id += 1;
      calendar.id = String(id);
      calendar.name = 'Friend';
      calendar.color = '#ffffff';
      calendar.bgColor = '#5ed84f';
      calendar.dragBgColor = '#5ed84f';
      calendar.borderColor = '#5ed84f';
      addCalendar(calendar);

      calendar = new CalendarInfo();
      id += 1;
      calendar.id = String(id);
      calendar.name = 'Travel';
      calendar.color = '#ffffff';
      calendar.bgColor = '#fc7303';
      calendar.dragBgColor = '#fc7303';
      calendar.borderColor = '#fc7303';
      addCalendar(calendar);

      calendar = new CalendarInfo();
      id += 1;
      calendar.id = String(id);
      calendar.name = 'etc';
      calendar.color = '#ffffff';
      calendar.bgColor = '#0063dc';
      calendar.dragBgColor = '#0063dc';
      calendar.borderColor = '#0063dc';
      addCalendar(calendar);

      calendar = new CalendarInfo();
      id += 1;
      calendar.id = String(id);
      calendar.name = 'Birthdays';
      calendar.color = '#ffffff';
      calendar.bgColor = '#fdb901';
      calendar.dragBgColor = '#fdb901';
      calendar.borderColor = '#fdb901';
      addCalendar(calendar);
      */
})();
