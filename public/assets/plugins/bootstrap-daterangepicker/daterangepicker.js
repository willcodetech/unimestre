!(function (t, e) {
  if ("function" == typeof define && define.amd)
      define(["moment", "jquery"], function (a, i) {
          return (t.daterangepicker = e(a, i));
      });
  else if ("object" == typeof module && module.exports) {
      var a = "undefined" != typeof window ? window.jQuery : void 0;
      a || (a = require("jquery")).fn || (a.fn = {}), (module.exports = e(require("moment"), a));
  } else t.daterangepicker = e(t.moment, t.jQuery);
})(this, function (t, e) {
  var a = function (a, i, s) {
      if (
          ((this.parentEl = "body"),
          (this.element = e(a)),
          (this.startDate = t().startOf("day")),
          (this.endDate = t().endOf("day")),
          (this.minDate = !1),
          (this.maxDate = !1),
          (this.dateLimit = !1),
          (this.autoApply = !1),
          (this.singleDatePicker = !1),
          (this.showDropdowns = !1),
          (this.showWeekNumbers = !1),
          (this.showISOWeekNumbers = !1),
          (this.showCustomRangeLabel = !0),
          (this.timePicker = !1),
          (this.timePicker24Hour = !1),
          (this.timePickerIncrement = 1),
          (this.timePickerSeconds = !1),
          (this.linkedCalendars = !0),
          (this.autoUpdateInput = !0),
          (this.alwaysShowCalendars = !1),
          (this.ranges = {}),
          (this.opens = "right"),
          this.element.hasClass("pull-right") && (this.opens = "left"),
          (this.drops = "down"),
          this.element.hasClass("dropup") && (this.drops = "up"),
          (this.buttonClasses = "btn btn-sm"),
          (this.applyClass = "btn-success"),
          (this.cancelClass = "btn-default"),
          (this.locale = {
              direction: "ltr",
              format: t.localeData().longDateFormat("L"),
              separator: " - ",
              applyLabel: "Apply",
              cancelLabel: "Cancel",
              weekLabel: "W",
              customRangeLabel: "Custom Range",
              daysOfWeek: t.weekdaysMin(),
              monthNames: t.monthsShort(),
              firstDay: t.localeData().firstDayOfWeek(),
          }),
          (this.callback = function () {}),
          (this.isShowing = !1),
          (this.leftCalendar = {}),
          (this.rightCalendar = {}),
          ("object" == typeof i && null !== i) || (i = {}),
          "string" == typeof (i = e.extend(this.element.data(), i)).template ||
              i.template instanceof e ||
              (i.template =
                  '<div class="daterangepicker dropdown-menu"><div class="calendar left"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_start" value="" /><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="calendar right"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" /><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="ranges"><div class="range_inputs"><button class="applyBtn" disabled="disabled" type="button"></button> <button class="cancelBtn" type="button"></button></div></div></div>'),
          (this.parentEl = i.parentEl && e(i.parentEl).length ? e(i.parentEl) : e(this.parentEl)),
          (this.container = e(i.template).appendTo(this.parentEl)),
          "object" == typeof i.locale &&
              ("string" == typeof i.locale.direction && (this.locale.direction = i.locale.direction),
              "string" == typeof i.locale.format && (this.locale.format = i.locale.format),
              "string" == typeof i.locale.separator && (this.locale.separator = i.locale.separator),
              "object" == typeof i.locale.daysOfWeek && (this.locale.daysOfWeek = i.locale.daysOfWeek.slice()),
              "object" == typeof i.locale.monthNames && (this.locale.monthNames = i.locale.monthNames.slice()),
              "number" == typeof i.locale.firstDay && (this.locale.firstDay = i.locale.firstDay),
              "string" == typeof i.locale.applyLabel && (this.locale.applyLabel = i.locale.applyLabel),
              "string" == typeof i.locale.cancelLabel && (this.locale.cancelLabel = i.locale.cancelLabel),
              "string" == typeof i.locale.weekLabel && (this.locale.weekLabel = i.locale.weekLabel),
              "string" == typeof i.locale.customRangeLabel))
      ) {
          (f = document.createElement("textarea")).innerHTML = i.locale.customRangeLabel;
          var n = f.value;
          this.locale.customRangeLabel = n;
      }
      if (
          (this.container.addClass(this.locale.direction),
          "string" == typeof i.startDate && (this.startDate = t(i.startDate, this.locale.format)),
          "string" == typeof i.endDate && (this.endDate = t(i.endDate, this.locale.format)),
          "string" == typeof i.minDate && (this.minDate = t(i.minDate, this.locale.format)),
          "string" == typeof i.maxDate && (this.maxDate = t(i.maxDate, this.locale.format)),
          "object" == typeof i.startDate && (this.startDate = t(i.startDate)),
          "object" == typeof i.endDate && (this.endDate = t(i.endDate)),
          "object" == typeof i.minDate && (this.minDate = t(i.minDate)),
          "object" == typeof i.maxDate && (this.maxDate = t(i.maxDate)),
          this.minDate && this.startDate.isBefore(this.minDate) && (this.startDate = this.minDate.clone()),
          this.maxDate && this.endDate.isAfter(this.maxDate) && (this.endDate = this.maxDate.clone()),
          "string" == typeof i.applyClass && (this.applyClass = i.applyClass),
          "string" == typeof i.cancelClass && (this.cancelClass = i.cancelClass),
          "object" == typeof i.dateLimit && (this.dateLimit = i.dateLimit),
          "string" == typeof i.opens && (this.opens = i.opens),
          "string" == typeof i.drops && (this.drops = i.drops),
          "boolean" == typeof i.showWeekNumbers && (this.showWeekNumbers = i.showWeekNumbers),
          "boolean" == typeof i.showISOWeekNumbers && (this.showISOWeekNumbers = i.showISOWeekNumbers),
          "string" == typeof i.buttonClasses && (this.buttonClasses = i.buttonClasses),
          "object" == typeof i.buttonClasses && (this.buttonClasses = i.buttonClasses.join(" ")),
          "boolean" == typeof i.showDropdowns && (this.showDropdowns = i.showDropdowns),
          "boolean" == typeof i.showCustomRangeLabel && (this.showCustomRangeLabel = i.showCustomRangeLabel),
          "boolean" == typeof i.singleDatePicker && ((this.singleDatePicker = i.singleDatePicker), this.singleDatePicker && (this.endDate = this.startDate.clone())),
          "boolean" == typeof i.timePicker && (this.timePicker = i.timePicker),
          "boolean" == typeof i.timePickerSeconds && (this.timePickerSeconds = i.timePickerSeconds),
          "number" == typeof i.timePickerIncrement && (this.timePickerIncrement = i.timePickerIncrement),
          "boolean" == typeof i.timePicker24Hour && (this.timePicker24Hour = i.timePicker24Hour),
          "boolean" == typeof i.autoApply && (this.autoApply = i.autoApply),
          "boolean" == typeof i.autoUpdateInput && (this.autoUpdateInput = i.autoUpdateInput),
          "boolean" == typeof i.linkedCalendars && (this.linkedCalendars = i.linkedCalendars),
          "function" == typeof i.isInvalidDate && (this.isInvalidDate = i.isInvalidDate),
          "function" == typeof i.isCustomDate && (this.isCustomDate = i.isCustomDate),
          "boolean" == typeof i.alwaysShowCalendars && (this.alwaysShowCalendars = i.alwaysShowCalendars),
          0 != this.locale.firstDay)
      )
          for (var r = this.locale.firstDay; r > 0; ) this.locale.daysOfWeek.push(this.locale.daysOfWeek.shift()), r--;
      var o, h, l;
      if (void 0 === i.startDate && void 0 === i.endDate && e(this.element).is("input[type=text]")) {
          var c = e(this.element).val(),
              d = c.split(this.locale.separator);
          (o = h = null),
              2 == d.length ? ((o = t(d[0], this.locale.format)), (h = t(d[1], this.locale.format))) : this.singleDatePicker && "" !== c && ((o = t(c, this.locale.format)), (h = t(c, this.locale.format))),
              null !== o && null !== h && (this.setStartDate(o), this.setEndDate(h));
      }
      if ("object" == typeof i.ranges) {
          for (l in i.ranges) {
              (o = "string" == typeof i.ranges[l][0] ? t(i.ranges[l][0], this.locale.format) : t(i.ranges[l][0])),
                  (h = "string" == typeof i.ranges[l][1] ? t(i.ranges[l][1], this.locale.format) : t(i.ranges[l][1])),
                  this.minDate && o.isBefore(this.minDate) && (o = this.minDate.clone());
              var m = this.maxDate;
              if (
                  (this.dateLimit && m && o.clone().add(this.dateLimit).isAfter(m) && (m = o.clone().add(this.dateLimit)),
                  m && h.isAfter(m) && (h = m.clone()),
                  !((this.minDate && h.isBefore(this.minDate, this.timepicker ? "minute" : "day")) || (m && o.isAfter(m, this.timepicker ? "minute" : "day"))))
              ) {
                  var f;
                  (f = document.createElement("textarea")).innerHTML = l;
                  n = f.value;
                  this.ranges[n] = [o, h];
              }
          }
          var p = "<ul>";
          for (l in this.ranges) p += '<li data-range-key="' + l + '">' + l + "</li>";
          this.showCustomRangeLabel && (p += '<li data-range-key="' + this.locale.customRangeLabel + '">' + this.locale.customRangeLabel + "</li>"), (p += "</ul>"), this.container.find(".ranges").prepend(p);
      }
      "function" == typeof s && (this.callback = s),
          this.timePicker || ((this.startDate = this.startDate.startOf("day")), (this.endDate = this.endDate.endOf("day")), this.container.find(".calendar-time").hide()),
          this.timePicker && this.autoApply && (this.autoApply = !1),
          this.autoApply && "object" != typeof i.ranges ? this.container.find(".ranges").hide() : this.autoApply && this.container.find(".applyBtn, .cancelBtn").addClass("hide"),
          this.singleDatePicker &&
              (this.container.addClass("single"),
              this.container.find(".calendar.left").addClass("single"),
              this.container.find(".calendar.left").show(),
              this.container.find(".calendar.right").hide(),
              this.container.find(".daterangepicker_input input, .daterangepicker_input > i").hide(),
              this.timePicker ? this.container.find(".ranges ul").hide() : this.container.find(".ranges").hide()),
          ((void 0 === i.ranges && !this.singleDatePicker) || this.alwaysShowCalendars) && this.container.addClass("show-calendar"),
          this.container.addClass("opens" + this.opens),
          void 0 !== i.ranges && "right" == this.opens && this.container.find(".ranges").prependTo(this.container.find(".calendar.left").parent()),
          this.container.find(".applyBtn, .cancelBtn").addClass(this.buttonClasses),
          this.applyClass.length && this.container.find(".applyBtn").addClass(this.applyClass),
          this.cancelClass.length && this.container.find(".cancelBtn").addClass(this.cancelClass),
          this.container.find(".applyBtn").html(this.locale.applyLabel),
          this.container.find(".cancelBtn").html(this.locale.cancelLabel),
          this.container
              .find(".calendar")
              .on("click.daterangepicker", ".prev", e.proxy(this.clickPrev, this))
              .on("click.daterangepicker", ".next", e.proxy(this.clickNext, this))
              .on("mousedown.daterangepicker", "td.available", e.proxy(this.clickDate, this))
              .on("mouseenter.daterangepicker", "td.available", e.proxy(this.hoverDate, this))
              .on("mouseleave.daterangepicker", "td.available", e.proxy(this.updateFormInputs, this))
              .on("change.daterangepicker", "select.yearselect", e.proxy(this.monthOrYearChanged, this))
              .on("change.daterangepicker", "select.monthselect", e.proxy(this.monthOrYearChanged, this))
              .on("change.daterangepicker", "select.hourselect,select.minuteselect,select.secondselect,select.ampmselect", e.proxy(this.timeChanged, this))
              .on("click.daterangepicker", ".daterangepicker_input input", e.proxy(this.showCalendars, this))
              .on("focus.daterangepicker", ".daterangepicker_input input", e.proxy(this.formInputsFocused, this))
              .on("blur.daterangepicker", ".daterangepicker_input input", e.proxy(this.formInputsBlurred, this))
              .on("change.daterangepicker", ".daterangepicker_input input", e.proxy(this.formInputsChanged, this)),
          this.container
              .find(".ranges")
              .on("click.daterangepicker", "button.applyBtn", e.proxy(this.clickApply, this))
              .on("click.daterangepicker", "button.cancelBtn", e.proxy(this.clickCancel, this))
              .on("click.daterangepicker", "li", e.proxy(this.clickRange, this))
              .on("mouseenter.daterangepicker", "li", e.proxy(this.hoverRange, this))
              .on("mouseleave.daterangepicker", "li", e.proxy(this.updateFormInputs, this)),
          this.element.is("input") || this.element.is("button")
              ? this.element.on({
                    "click.daterangepicker": e.proxy(this.show, this),
                    "focus.daterangepicker": e.proxy(this.show, this),
                    "keyup.daterangepicker": e.proxy(this.elementChanged, this),
                    "keydown.daterangepicker": e.proxy(this.keydown, this),
                })
              : this.element.on("click.daterangepicker", e.proxy(this.toggle, this)),
          this.element.is("input") && !this.singleDatePicker && this.autoUpdateInput
              ? (this.element.val(this.startDate.format(this.locale.format) + this.locale.separator + this.endDate.format(this.locale.format)), this.element.trigger("change"))
              : this.element.is("input") && this.autoUpdateInput && (this.element.val(this.startDate.format(this.locale.format)), this.element.trigger("change"));
  };
  return (
      (a.prototype = {
          constructor: a,
          setStartDate: function (e) {
              "string" == typeof e && (this.startDate = t(e, this.locale.format)),
                  "object" == typeof e && (this.startDate = t(e)),
                  this.timePicker || (this.startDate = this.startDate.startOf("day")),
                  this.timePicker && this.timePickerIncrement && this.startDate.minute(Math.round(this.startDate.minute() / this.timePickerIncrement) * this.timePickerIncrement),
                  this.minDate &&
                      this.startDate.isBefore(this.minDate) &&
                      ((this.startDate = this.minDate.clone()), this.timePicker && this.timePickerIncrement && this.startDate.minute(Math.round(this.startDate.minute() / this.timePickerIncrement) * this.timePickerIncrement)),
                  this.maxDate &&
                      this.startDate.isAfter(this.maxDate) &&
                      ((this.startDate = this.maxDate.clone()), this.timePicker && this.timePickerIncrement && this.startDate.minute(Math.floor(this.startDate.minute() / this.timePickerIncrement) * this.timePickerIncrement)),
                  this.isShowing || this.updateElement(),
                  this.updateMonthsInView();
          },
          setEndDate: function (e) {
              "string" == typeof e && (this.endDate = t(e, this.locale.format)),
                  "object" == typeof e && (this.endDate = t(e)),
                  this.timePicker || (this.endDate = this.endDate.endOf("day")),
                  this.timePicker && this.timePickerIncrement && this.endDate.minute(Math.round(this.endDate.minute() / this.timePickerIncrement) * this.timePickerIncrement),
                  this.endDate.isBefore(this.startDate) && (this.endDate = this.startDate.clone()),
                  this.maxDate && this.endDate.isAfter(this.maxDate) && (this.endDate = this.maxDate.clone()),
                  this.dateLimit && this.startDate.clone().add(this.dateLimit).isBefore(this.endDate) && (this.endDate = this.startDate.clone().add(this.dateLimit)),
                  (this.previousRightTime = this.endDate.clone()),
                  this.isShowing || this.updateElement(),
                  this.updateMonthsInView();
          },
          isInvalidDate: function () {
              return !1;
          },
          isCustomDate: function () {
              return !1;
          },
          updateView: function () {
              this.timePicker &&
                  (this.renderTimePicker("left"),
                  this.renderTimePicker("right"),
                  this.endDate ? this.container.find(".right .calendar-time select").removeAttr("disabled").removeClass("disabled") : this.container.find(".right .calendar-time select").attr("disabled", "disabled").addClass("disabled")),
                  this.endDate
                      ? (this.container.find('input[name="daterangepicker_end"]').removeClass("active"), this.container.find('input[name="daterangepicker_start"]').addClass("active"))
                      : (this.container.find('input[name="daterangepicker_end"]').addClass("active"), this.container.find('input[name="daterangepicker_start"]').removeClass("active")),
                  this.updateMonthsInView(),
                  this.updateCalendars(),
                  this.updateFormInputs();
          },
          updateMonthsInView: function () {
              if (this.endDate) {
                  if (
                      !this.singleDatePicker &&
                      this.leftCalendar.month &&
                      this.rightCalendar.month &&
                      (this.startDate.format("YYYY-MM") == this.leftCalendar.month.format("YYYY-MM") || this.startDate.format("YYYY-MM") == this.rightCalendar.month.format("YYYY-MM")) &&
                      (this.endDate.format("YYYY-MM") == this.leftCalendar.month.format("YYYY-MM") || this.endDate.format("YYYY-MM") == this.rightCalendar.month.format("YYYY-MM"))
                  )
                      return;
                  (this.leftCalendar.month = this.startDate.clone().date(2)),
                      this.linkedCalendars || (this.endDate.month() == this.startDate.month() && this.endDate.year() == this.startDate.year())
                          ? (this.rightCalendar.month = this.startDate.clone().date(2).add(1, "month"))
                          : (this.rightCalendar.month = this.endDate.clone().date(2));
              } else
                  this.leftCalendar.month.format("YYYY-MM") != this.startDate.format("YYYY-MM") &&
                      this.rightCalendar.month.format("YYYY-MM") != this.startDate.format("YYYY-MM") &&
                      ((this.leftCalendar.month = this.startDate.clone().date(2)), (this.rightCalendar.month = this.startDate.clone().date(2).add(1, "month")));
              this.maxDate &&
                  this.linkedCalendars &&
                  !this.singleDatePicker &&
                  this.rightCalendar.month > this.maxDate &&
                  ((this.rightCalendar.month = this.maxDate.clone().date(2)), (this.leftCalendar.month = this.maxDate.clone().date(2).subtract(1, "month")));
          },
          updateCalendars: function () {
              if (this.timePicker) {
                  var t, e, a, i;
                  if (this.endDate) {
                      if (
                          ((t = parseInt(this.container.find(".left .hourselect").val(), 10)),
                          (e = parseInt(this.container.find(".left .minuteselect").val(), 10)),
                          (a = this.timePickerSeconds ? parseInt(this.container.find(".left .secondselect").val(), 10) : 0),
                          !this.timePicker24Hour)
                      )
                          "PM" === (i = this.container.find(".left .ampmselect").val()) && t < 12 && (t += 12), "AM" === i && 12 === t && (t = 0);
                  } else if (
                      ((t = parseInt(this.container.find(".right .hourselect").val(), 10)),
                      (e = parseInt(this.container.find(".right .minuteselect").val(), 10)),
                      (a = this.timePickerSeconds ? parseInt(this.container.find(".right .secondselect").val(), 10) : 0),
                      !this.timePicker24Hour)
                  )
                      "PM" === (i = this.container.find(".right .ampmselect").val()) && t < 12 && (t += 12), "AM" === i && 12 === t && (t = 0);
                  this.leftCalendar.month.hour(t).minute(e).second(a), this.rightCalendar.month.hour(t).minute(e).second(a);
              }
              this.renderCalendar("left"), this.renderCalendar("right"), this.container.find(".ranges li").removeClass("active"), null != this.endDate && this.calculateChosenLabel();
          },
          renderCalendar: function (a) {
            //console.log("renderizar calendario");
              var i,
                  s = (i = "left" == a ? this.leftCalendar : this.rightCalendar).month.month(),
                  n = i.month.year(),
                  r = i.month.hour(),
                  o = i.month.minute(),
                  h = i.month.second(),
                  l = t([n, s]).daysInMonth(),
                  c = t([n, s, 1]),
                  d = t([n, s, l]),
                  m = t(c).subtract(1, "month").month(),
                  f = t(c).subtract(1, "month").year(),
                  p = t([f, m]).daysInMonth(),
                  u = c.day();
              ((i = []).firstDay = c), (i.lastDay = d);
              for (var g = 0; g < 6; g++) i[g] = [];
              var D = p - u + this.locale.firstDay + 1;
              D > p && (D -= 7), u == this.locale.firstDay && (D = p - 6);
              for (var k = t([f, m, D, 12, o, h]), y = ((g = 0), 0), v = 0; g < 42; g++, y++, k = t(k).add(24, "hour"))
                  g > 0 && y % 7 == 0 && ((y = 0), v++),
                      (i[v][y] = k.clone().hour(r).minute(o).second(h)),
                      k.hour(12),
                      this.minDate && i[v][y].format("YYYY-MM-DD") == this.minDate.format("YYYY-MM-DD") && i[v][y].isBefore(this.minDate) && "left" == a && (i[v][y] = this.minDate.clone()),
                      this.maxDate && i[v][y].format("YYYY-MM-DD") == this.maxDate.format("YYYY-MM-DD") && i[v][y].isAfter(this.maxDate) && "right" == a && (i[v][y] = this.maxDate.clone());
              "left" == a ? (this.leftCalendar.calendar = i) : (this.rightCalendar.calendar = i);
              var b = "left" == a ? this.minDate : this.startDate,
                  C = this.maxDate,
                  w = ("left" == a ? this.startDate : this.endDate, "ltr" == this.locale.direction ? { left: "chevron-left", right: "chevron-right" } : { left: "chevron-right", right: "chevron-left" }),
                  Y = '<table class="table-condensed">';
              (Y += "<thead>"),
                  (Y += "<tr>"),
                  (this.showWeekNumbers || this.showISOWeekNumbers) && (Y += "<th></th>"),
                  (b && !b.isBefore(i.firstDay)) || (this.linkedCalendars && "left" != a) ? (Y += "<th></th>") : (Y += '<th class="prev available"><i class="fa fa-' + w.left + " glyphicon glyphicon-" + w.left + '"></i></th>');
              var P = this.locale.monthNames[i[1][1].month()] + i[1][1].format(" YYYY");
              if (this.showDropdowns) {
                  for (var M = i[1][1].month(), x = i[1][1].year(), I = (C && C.year()) || x + 5, L = (b && b.year()) || x - 50, S = x == L, A = x == I, _ = '<select class="monthselect">', B = 0; B < 12; B++)
                      (!S || B >= b.month()) && (!A || B <= C.month())
                          ? (_ += "<option value='" + B + "'" + (B === M ? " selected='selected'" : "") + ">" + this.locale.monthNames[B] + "</option>")
                          : (_ += "<option value='" + B + "'" + (B === M ? " selected='selected'" : "") + " disabled='disabled'>" + this.locale.monthNames[B] + "</option>");
                  _ += "</select>";
                  for (var E = '<select class="yearselect">', W = L; W <= I; W++) E += '<option value="' + W + '"' + (W === x ? ' selected="selected"' : "") + ">" + W + "</option>";
                  P = _ + (E += "</select>");
              }
              if (
                  ((Y += '<th colspan="5" class="month">' + P + "</th>"),
                  (C && !C.isAfter(i.lastDay)) || (this.linkedCalendars && "right" != a && !this.singleDatePicker)
                      ? (Y += "<th></th>")
                      : (Y += '<th class="next available"><i class="fa fa-' + w.right + " glyphicon glyphicon-" + w.right + '"></i></th>'),
                  (Y += "</tr>"),
                  (Y += "<tr>"),
                  (this.showWeekNumbers || this.showISOWeekNumbers) && (Y += '<th class="week">' + this.locale.weekLabel + "</th>"),
                  e.each(this.locale.daysOfWeek, function (t, e) {
                      Y += "<th>" + e + "</th>";
                  }),
                  (Y += "</tr>"),
                  (Y += "</thead>"),
                  (Y += "<tbody>"),
                  null == this.endDate && this.dateLimit)
              ) {
                  var O = this.startDate.clone().add(this.dateLimit).endOf("day");
                  (C && !O.isBefore(C)) || (C = O);
              }
              for (v = 0; v < 6; v++) {
                  (Y += "<tr>"), this.showWeekNumbers ? (Y += '<td class="week">' + i[v][0].week() + "</td>") : this.showISOWeekNumbers && (Y += '<td class="week">' + i[v][0].isoWeek() + "</td>");
                  for (y = 0; y < 7; y++) {
                      var N = [];
                      i[v][y].isSame(new Date(), "day") && N.push("today"),
                          i[v][y].isoWeekday() > 5 && N.push("weekend"),
                          i[v][y].month() != i[1][1].month() && N.push("off"),
                          this.minDate && i[v][y].isBefore(this.minDate, "day") && N.push("off", "disabled"),
                          C && i[v][y].isAfter(C, "day") && N.push("off", "disabled"),
                          this.isInvalidDate(i[v][y]) && N.push("off", "disabled"),
                          i[v][y].format("YYYY-MM-DD") == this.startDate.format("YYYY-MM-DD") && N.push("active", "start-date"),
                          null != this.endDate && i[v][y].format("YYYY-MM-DD") == this.endDate.format("YYYY-MM-DD") && N.push("active", "end-date"),
                          null != this.endDate && i[v][y] > this.startDate && i[v][y] < this.endDate && N.push("in-range");
                      var R = this.isCustomDate(i[v][y]);
                      !1 !== R && ("string" == typeof R ? N.push(R) : Array.prototype.push.apply(N, R));
                      var j = "",
                          H = !1;
                      for (g = 0; g < N.length; g++) (j += N[g] + " "), "disabled" == N[g] && (H = !0);
                      H || (j += "available"), (Y += '<td class="' + j.replace(/^\s+|\s+$/g, "") + '" data-title="r' + v + "c" + y + '">' + i[v][y].date() + "</td>");
                  }
                  Y += "</tr>";
              }
              (Y += "</tbody>"), (Y += "</table>"), this.container.find(".calendar." + a + " .calendar-table").html(Y);
              var windowHeight = $(window).height(); // altura da janela
              var windowWidth = $(window).width(); // largura da janela
              var calendarHeight = $('.daterangepicker').outerHeight(); // altura do calendário
              var calendarWidth = $('.daterangepicker').outerWidth(); // largura do calendário
          
              // calcula a posição do topo e da esquerda do calendário para centralizá-lo
              var topPosition = (windowHeight - calendarHeight) / 2;
              var leftPosition = (windowWidth - calendarWidth) / 2;
          
              // define a posição do calendário
              $('.daterangepicker').css({
                  'top': topPosition + 'px',
                  'left': leftPosition + 'px'
              });
          },
          renderTimePicker: function (t) {
              if ("right" != t || this.endDate) {
                  var e,
                      a,
                      i,
                      s = this.maxDate;
                  if ((!this.dateLimit || (this.maxDate && !this.startDate.clone().add(this.dateLimit).isAfter(this.maxDate)) || (s = this.startDate.clone().add(this.dateLimit)), "left" == t))
                      (a = this.startDate.clone()), (i = this.minDate);
                  else if ("right" == t) {
                      (a = this.endDate.clone()), (i = this.startDate);
                      var n = this.container.find(".calendar.right .calendar-time div");
                      if (
                          "" != n.html() &&
                          (a.hour(n.find(".hourselect option:selected").val() || a.hour()),
                          a.minute(n.find(".minuteselect option:selected").val() || a.minute()),
                          a.second(n.find(".secondselect option:selected").val() || a.second()),
                          !this.timePicker24Hour)
                      ) {
                          var r = n.find(".ampmselect option:selected").val();
                          "PM" === r && a.hour() < 12 && a.hour(a.hour() + 12), "AM" === r && 12 === a.hour() && a.hour(0);
                      }
                      a.isBefore(this.startDate) && (a = this.startDate.clone()), s && a.isAfter(s) && (a = s.clone());
                  }
                  e = '<select class="hourselect">';
                  for (var o = this.timePicker24Hour ? 0 : 1, h = this.timePicker24Hour ? 23 : 12, l = o; l <= h; l++) {
                      var c = l;
                      this.timePicker24Hour || (c = a.hour() >= 12 ? (12 == l ? 12 : l + 12) : 12 == l ? 0 : l);
                      var d = a.clone().hour(c),
                          m = !1;
                      i && d.minute(59).isBefore(i) && (m = !0),
                          s && d.minute(0).isAfter(s) && (m = !0),
                          c != a.hour() || m
                              ? (e += m ? '<option value="' + l + '" disabled="disabled" class="disabled">' + l + "</option>" : '<option value="' + l + '">' + l + "</option>")
                              : (e += '<option value="' + l + '" selected="selected">' + l + "</option>");
                  }
                  (e += "</select> "), (e += ': <select class="minuteselect">');
                  for (l = 0; l < 60; l += this.timePickerIncrement) {
                      var f = l < 10 ? "0" + l : l;
                      (d = a.clone().minute(l)), (m = !1);
                      i && d.second(59).isBefore(i) && (m = !0),
                          s && d.second(0).isAfter(s) && (m = !0),
                          a.minute() != l || m
                              ? (e += m ? '<option value="' + l + '" disabled="disabled" class="disabled">' + f + "</option>" : '<option value="' + l + '">' + f + "</option>")
                              : (e += '<option value="' + l + '" selected="selected">' + f + "</option>");
                  }
                  if (((e += "</select> "), this.timePickerSeconds)) {
                      e += ': <select class="secondselect">';
                      for (l = 0; l < 60; l++) {
                          (f = l < 10 ? "0" + l : l), (d = a.clone().second(l)), (m = !1);
                          i && d.isBefore(i) && (m = !0),
                              s && d.isAfter(s) && (m = !0),
                              a.second() != l || m
                                  ? (e += m ? '<option value="' + l + '" disabled="disabled" class="disabled">' + f + "</option>" : '<option value="' + l + '">' + f + "</option>")
                                  : (e += '<option value="' + l + '" selected="selected">' + f + "</option>");
                      }
                      e += "</select> ";
                  }
                  if (!this.timePicker24Hour) {
                      e += '<select class="ampmselect">';
                      var p = "",
                          u = "";
                      i && a.clone().hour(12).minute(0).second(0).isBefore(i) && (p = ' disabled="disabled" class="disabled"'),
                          s && a.clone().hour(0).minute(0).second(0).isAfter(s) && (u = ' disabled="disabled" class="disabled"'),
                          a.hour() >= 12
                              ? (e += '<option value="AM"' + p + '>AM</option><option value="PM" selected="selected"' + u + ">PM</option>")
                              : (e += '<option value="AM" selected="selected"' + p + '>AM</option><option value="PM"' + u + ">PM</option>"),
                          (e += "</select>");
                  }
                  this.container.find(".calendar." + t + " .calendar-time div").html(e);
              }
          },
          updateFormInputs: function () {
              this.container.find("input[name=daterangepicker_start]").is(":focus") ||
                  this.container.find("input[name=daterangepicker_end]").is(":focus") ||
                  (this.container.find("input[name=daterangepicker_start]").val(this.startDate.format(this.locale.format)),
                  this.endDate && this.container.find("input[name=daterangepicker_end]").val(this.endDate.format(this.locale.format)),
                  this.singleDatePicker || (this.endDate && (this.startDate.isBefore(this.endDate) || this.startDate.isSame(this.endDate)))
                      ? this.container.find("button.applyBtn").removeAttr("disabled")
                      : this.container.find("button.applyBtn").attr("disabled", "disabled"));
          },
          move: function () {
              var t,
                  a = { top: 0, left: 0 },
                  i = e(window).width();
              this.parentEl.is("body") ||
                  ((a = { top: this.parentEl.offset().top - this.parentEl.scrollTop(), left: this.parentEl.offset().left - this.parentEl.scrollLeft() }), (i = this.parentEl[0].clientWidth + this.parentEl.offset().left)),
                  (t = "up" == this.drops ? this.element.offset().top - this.container.outerHeight() - a.top : this.element.offset().top + this.element.outerHeight() - a.top),
                  this.container["up" == this.drops ? "addClass" : "removeClass"]("dropup"),
                  "left" == this.opens
                      ? (this.container.css({ top: t, right: i - this.element.offset().left - this.element.outerWidth(), left: "auto" }), this.container.offset().left < 0 && this.container.css({ right: "auto", left: 9 }))
                      : "center" == this.opens
                      ? (this.container.css({ top: t, left: this.element.offset().left - a.left + this.element.outerWidth() / 2 - this.container.outerWidth() / 2, right: "auto" }),
                        this.container.offset().left < 0 && this.container.css({ right: "auto", left: 9 }))
                      : (this.container.css({ top: t, left: this.element.offset().left - a.left, right: "auto" }),
                        this.container.offset().left + this.container.outerWidth() > e(window).width() && this.container.css({ left: "auto", right: 0 }));
          },
          show: function (t) {
              this.isShowing ||
                  ((this._outsideClickProxy = e.proxy(function (t) {
                      this.outsideClick(t);
                  }, this)),
                  e(document)
                      .on("mousedown.daterangepicker", this._outsideClickProxy)
                      .on("touchend.daterangepicker", this._outsideClickProxy)
                      .on("click.daterangepicker", "[data-toggle=dropdown]", this._outsideClickProxy)
                      .on("focusin.daterangepicker", this._outsideClickProxy),
                  e(window).on(
                      "resize.daterangepicker",
                      e.proxy(function (t) {
                          this.move(t);
                      }, this)
                  ),
                  (this.oldStartDate = this.startDate.clone()),
                  (this.oldEndDate = this.endDate.clone()),
                  (this.previousRightTime = this.endDate.clone()),
                  this.updateView(),
                  this.container.show(),
                  this.move(),
                  this.element.trigger("show.daterangepicker", this),
                  (this.isShowing = !0));
                  
          },
          hide: function (t) {
              this.isShowing &&
                  (this.endDate || ((this.startDate = this.oldStartDate.clone()), (this.endDate = this.oldEndDate.clone())),
                  (this.startDate.isSame(this.oldStartDate) && this.endDate.isSame(this.oldEndDate)) || this.callback(this.startDate, this.endDate, this.chosenLabel),
                  this.updateElement(),
                  e(document).off(".daterangepicker"),
                  e(window).off(".daterangepicker"),
                  this.container.hide(),
                  this.element.trigger("hide.daterangepicker", this),
                  (this.isShowing = !1));
          },
          toggle: function (t) {
              this.isShowing ? this.hide() : this.show();
          },
          outsideClick: function (t) {
              var a = e(t.target);
              "focusin" == t.type || a.closest(this.element).length || a.closest(this.container).length || a.closest(".calendar-table").length || (this.hide(), this.element.trigger("outsideClick.daterangepicker", this));
          },
          showCalendars: function () {
              this.container.addClass("show-calendar"), this.move(), this.element.trigger("showCalendar.daterangepicker", this);
          },
          hideCalendars: function () {
              this.container.removeClass("show-calendar"), this.element.trigger("hideCalendar.daterangepicker", this);
          },
          hoverRange: function (t) {
              if (!this.container.find("input[name=daterangepicker_start]").is(":focus") && !this.container.find("input[name=daterangepicker_end]").is(":focus")) {
                  var e = t.target.getAttribute("data-range-key");
                  if (e == this.locale.customRangeLabel) this.updateView();
                  else {
                      var a = this.ranges[e];
                      this.container.find("input[name=daterangepicker_start]").val(a[0].format(this.locale.format)), this.container.find("input[name=daterangepicker_end]").val(a[1].format(this.locale.format));
                  }
              }
          },
          clickRange: function (t) {
              var e = t.target.getAttribute("data-range-key");
              if (((this.chosenLabel = e), e == this.locale.customRangeLabel)) this.showCalendars();
              else {
                  var a = this.ranges[e];
                  (this.startDate = a[0]), (this.endDate = a[1]), this.timePicker || (this.startDate.startOf("day"), this.endDate.endOf("day")), this.alwaysShowCalendars || this.hideCalendars(), this.clickApply();
              }
          },
          clickPrev: function (t) {
              e(t.target).parents(".calendar").hasClass("left") ? (this.leftCalendar.month.subtract(1, "month"), this.linkedCalendars && this.rightCalendar.month.subtract(1, "month")) : this.rightCalendar.month.subtract(1, "month"),
                  this.updateCalendars();
          },
          clickNext: function (t) {
              e(t.target).parents(".calendar").hasClass("left") ? this.leftCalendar.month.add(1, "month") : (this.rightCalendar.month.add(1, "month"), this.linkedCalendars && this.leftCalendar.month.add(1, "month")),
                  this.updateCalendars();
          },
          hoverDate: function (t) {
              if (e(t.target).hasClass("available")) {
                  var a = e(t.target).attr("data-title"),
                      i = a.substr(1, 1),
                      s = a.substr(3, 1),
                      n = e(t.target).parents(".calendar").hasClass("left") ? this.leftCalendar.calendar[i][s] : this.rightCalendar.calendar[i][s];
                  this.endDate && !this.container.find("input[name=daterangepicker_start]").is(":focus")
                      ? this.container.find("input[name=daterangepicker_start]").val(n.format(this.locale.format))
                      : this.endDate || this.container.find("input[name=daterangepicker_end]").is(":focus") || this.container.find("input[name=daterangepicker_end]").val(n.format(this.locale.format));
                  var r = this.leftCalendar,
                      o = this.rightCalendar,
                      h = this.startDate;
                  this.endDate ||
                      this.container.find(".calendar tbody td").each(function (t, a) {
                          if (!e(a).hasClass("week")) {
                              var i = e(a).attr("data-title"),
                                  s = i.substr(1, 1),
                                  l = i.substr(3, 1),
                                  c = e(a).parents(".calendar").hasClass("left") ? r.calendar[s][l] : o.calendar[s][l];
                              (c.isAfter(h) && c.isBefore(n)) || c.isSame(n, "day") ? e(a).addClass("in-range") : e(a).removeClass("in-range");
                          }
                      });
              }
          },
          clickDate: function (t) {
              if (e(t.target).hasClass("available")) {
                  var a = e(t.target).attr("data-title"),
                      i = a.substr(1, 1),
                      s = a.substr(3, 1),
                      n = e(t.target).parents(".calendar").hasClass("left") ? this.leftCalendar.calendar[i][s] : this.rightCalendar.calendar[i][s];
                  if (this.endDate || n.isBefore(this.startDate, "day")) {
                      if (this.timePicker) {
                          var r = parseInt(this.container.find(".left .hourselect").val(), 10);
                          if (!this.timePicker24Hour) "PM" === (l = this.container.find(".left .ampmselect").val()) && r < 12 && (r += 12), "AM" === l && 12 === r && (r = 0);
                          var o = parseInt(this.container.find(".left .minuteselect").val(), 10),
                              h = this.timePickerSeconds ? parseInt(this.container.find(".left .secondselect").val(), 10) : 0;
                          n = n.clone().hour(r).minute(o).second(h);
                      }
                      (this.endDate = null), this.setStartDate(n.clone());
                  } else if (!this.endDate && n.isBefore(this.startDate)) this.setEndDate(this.startDate.clone());
                  else {
                      if (this.timePicker) {
                          var l;
                          r = parseInt(this.container.find(".right .hourselect").val(), 10);
                          if (!this.timePicker24Hour) "PM" === (l = this.container.find(".right .ampmselect").val()) && r < 12 && (r += 12), "AM" === l && 12 === r && (r = 0);
                          (o = parseInt(this.container.find(".right .minuteselect").val(), 10)), (h = this.timePickerSeconds ? parseInt(this.container.find(".right .secondselect").val(), 10) : 0);
                          n = n.clone().hour(r).minute(o).second(h);
                      }
                      this.setEndDate(n.clone()), this.autoApply && (this.calculateChosenLabel(), this.clickApply());
                  }
                  this.singleDatePicker && (this.setEndDate(this.startDate), this.timePicker || this.clickApply()), this.updateView(), t.stopPropagation();
              }
          },
          calculateChosenLabel: function () {
              var t = !0,
                  e = 0;
              for (var a in this.ranges) {
                  if (this.timePicker) {
                      if (this.startDate.isSame(this.ranges[a][0]) && this.endDate.isSame(this.ranges[a][1])) {
                          (t = !1),
                              (this.chosenLabel = this.container
                                  .find(".ranges li:eq(" + e + ")")
                                  .addClass("active")
                                  .html());
                          break;
                      }
                  } else if (this.startDate.format("YYYY-MM-DD") == this.ranges[a][0].format("YYYY-MM-DD") && this.endDate.format("YYYY-MM-DD") == this.ranges[a][1].format("YYYY-MM-DD")) {
                      (t = !1),
                          (this.chosenLabel = this.container
                              .find(".ranges li:eq(" + e + ")")
                              .addClass("active")
                              .html());
                      break;
                  }
                  e++;
              }
              t && (this.showCustomRangeLabel ? (this.chosenLabel = this.container.find(".ranges li:last").addClass("active").html()) : (this.chosenLabel = null), this.showCalendars());
          },
          clickApply: function (t) {
              this.hide(), this.element.trigger("apply.daterangepicker", this);
          },
          clickCancel: function (t) {
              (this.startDate = this.oldStartDate), (this.endDate = this.oldEndDate), this.hide(), this.element.trigger("cancel.daterangepicker", this);
          },
          monthOrYearChanged: function (t) {
              var a = e(t.target).closest(".calendar").hasClass("left"),
                  i = a ? "left" : "right",
                  s = this.container.find(".calendar." + i),
                  n = parseInt(s.find(".monthselect").val(), 10),
                  r = s.find(".yearselect").val();
              a || ((r < this.startDate.year() || (r == this.startDate.year() && n < this.startDate.month())) && ((n = this.startDate.month()), (r = this.startDate.year()))),
                  this.minDate && (r < this.minDate.year() || (r == this.minDate.year() && n < this.minDate.month())) && ((n = this.minDate.month()), (r = this.minDate.year())),
                  this.maxDate && (r > this.maxDate.year() || (r == this.maxDate.year() && n > this.maxDate.month())) && ((n = this.maxDate.month()), (r = this.maxDate.year())),
                  a
                      ? (this.leftCalendar.month.month(n).year(r), this.linkedCalendars && (this.rightCalendar.month = this.leftCalendar.month.clone().add(1, "month")))
                      : (this.rightCalendar.month.month(n).year(r), this.linkedCalendars && (this.leftCalendar.month = this.rightCalendar.month.clone().subtract(1, "month"))),
                  this.updateCalendars();
          },
          timeChanged: function (t) {
              var a = e(t.target).closest(".calendar"),
                  i = a.hasClass("left"),
                  s = parseInt(a.find(".hourselect").val(), 10),
                  n = parseInt(a.find(".minuteselect").val(), 10),
                  r = this.timePickerSeconds ? parseInt(a.find(".secondselect").val(), 10) : 0;
              if (!this.timePicker24Hour) {
                  var o = a.find(".ampmselect").val();
                  "PM" === o && s < 12 && (s += 12), "AM" === o && 12 === s && (s = 0);
              }
              if (i) {
                  var h = this.startDate.clone();
                  h.hour(s),
                      h.minute(n),
                      h.second(r),
                      this.setStartDate(h),
                      this.singleDatePicker ? (this.endDate = this.startDate.clone()) : this.endDate && this.endDate.format("YYYY-MM-DD") == h.format("YYYY-MM-DD") && this.endDate.isBefore(h) && this.setEndDate(h.clone());
              } else if (this.endDate) {
                  var l = this.endDate.clone();
                  l.hour(s), l.minute(n), l.second(r), this.setEndDate(l);
              }
              this.updateCalendars(), this.updateFormInputs(), this.renderTimePicker("left"), this.renderTimePicker("right");
          },
          formInputsChanged: function (a) {
              var i = e(a.target).closest(".calendar").hasClass("right"),
                  s = t(this.container.find('input[name="daterangepicker_start"]').val(), this.locale.format),
                  n = t(this.container.find('input[name="daterangepicker_end"]').val(), this.locale.format);
              s.isValid() &&
                  n.isValid() &&
                  (i && n.isBefore(s) && (s = n.clone()),
                  this.setStartDate(s),
                  this.setEndDate(n),
                  i ? this.container.find('input[name="daterangepicker_start"]').val(this.startDate.format(this.locale.format)) : this.container.find('input[name="daterangepicker_end"]').val(this.endDate.format(this.locale.format))),
                  this.updateView();
          },
          formInputsFocused: function (t) {
              this.container.find('input[name="daterangepicker_start"], input[name="daterangepicker_end"]').removeClass("active"),
                  e(t.target).addClass("active"),
                  e(t.target).closest(".calendar").hasClass("right") && ((this.endDate = null), this.setStartDate(this.startDate.clone()), this.updateView());
          },
          formInputsBlurred: function (e) {
              if (!this.endDate) {
                  var a = this.container.find('input[name="daterangepicker_end"]').val(),
                      i = t(a, this.locale.format);
                  i.isValid() && (this.setEndDate(i), this.updateView());
              }
          },
          elementChanged: function () {
              if (this.element.is("input") && this.element.val().length && !(this.element.val().length < this.locale.format.length)) {
                  var e = this.element.val().split(this.locale.separator),
                      a = null,
                      i = null;
                  2 === e.length && ((a = t(e[0], this.locale.format)), (i = t(e[1], this.locale.format))),
                      (this.singleDatePicker || null === a || null === i) && (i = a = t(this.element.val(), this.locale.format)),
                      a.isValid() && i.isValid() && (this.setStartDate(a), this.setEndDate(i), this.updateView());
              }
          },
          keydown: function (t) {
              (9 !== t.keyCode && 13 !== t.keyCode) || this.hide();
          },
          updateElement: function () {
              this.element.is("input") && !this.singleDatePicker && this.autoUpdateInput
                  ? (this.element.val(this.startDate.format(this.locale.format) + this.locale.separator + this.endDate.format(this.locale.format)), this.element.trigger("change"))
                  : this.element.is("input") && this.autoUpdateInput && (this.element.val(this.startDate.format(this.locale.format)), this.element.trigger("change"));
          },
          remove: function () {
              this.container.remove(), this.element.off(".daterangepicker"), this.element.removeData();
          },
      }),
      (e.fn.daterangepicker = function (t, i) {
          return (
              this.each(function () {
                  var s = e(this);
                  s.data("daterangepicker") && s.data("daterangepicker").remove(), s.data("daterangepicker", new a(s, t, i));
              }),
              this
          );
      }),
      a
  );
});
