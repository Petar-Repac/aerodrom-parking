
! function(t, e) {
    "object" == typeof exports && "undefined" != typeof module ? e(exports) : "function" == typeof define && define.amd ? define(["exports"], e) : e((t = "undefined" != typeof globalThis ? globalThis : t || self).easepick = t.easepick || {})
}(this, (function(t) {
    "use strict";
    class e extends Date {
        static parseDateTime(t, i = "YYYY-MM-DD", n = "en-US") {
            if (!t) return new Date((new Date).setHours(0, 0, 0, 0));
            if (t instanceof e) return t.toJSDate();
            if (t instanceof Date) return t;
            if (/^-?\d{10,}$/.test(String(t))) return new Date(Number(t));
            if ("string" == typeof t) {
                const s = [];
                let o = null;
                for (; null != (o = e.regex.exec(i));) "\\" !== o[1] && s.push(o);
                if (s.length) {
                    const i = {
                        year: null,
                        month: null,
                        shortMonth: null,
                        longMonth: null,
                        day: null,
                        hour: 0,
                        minute: 0,
                        second: 0,
                        ampm: null,
                        value: ""
                    };
                    s[0].index > 0 && (i.value += ".*?");
                    for (const [t, o] of Object.entries(s)) {
                        const s = Number(t),
                            {
                                group: a,
                                pattern: r
                            } = e.formatPatterns(o[0], n);
                        i[a] = s + 1, i.value += r, i.value += ".*?"
                    }
                    const o = new RegExp(`^${i.value}$`);
                    if (o.test(t)) {
                        const s = o.exec(t),
                            a = Number(s[i.year]);
                        let r = null;
                        i.month ? r = Number(s[i.month]) - 1 : i.shortMonth ? r = e.shortMonths(n).indexOf(s[i.shortMonth]) : i.longMonth && (r = e.longMonths(n).indexOf(s[i.longMonth]));
                        const c = Number(s[i.day]) || 1,
                            l = Number(s[i.hour]);
                        let h = Number.isNaN(l) ? 0 : l;
                        const d = Number(s[i.minute]),
                            p = Number.isNaN(d) ? 0 : d,
                            u = Number(s[i.second]),
                            g = Number.isNaN(u) ? 0 : u,
                            m = s[i.ampm];
                        return m && "PM" === m && (h += 12, 24 === h && (h = 0)), new Date(a, r, c, h, p, g, 0)
                    }
                }
            }
            return new Date((new Date).setHours(0, 0, 0, 0))
        }
        static regex = /(\\)?(Y{2,4}|M{1,4}|D{1,2}|H{1,2}|h{1,2}|m{1,2}|s{1,2}|A|a)/g;
        static MONTH_JS = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        static shortMonths(t) {
            return e.MONTH_JS.map((e => new Date(2019, e).toLocaleString(t, {
                month: "short"
            })))
        }
        static longMonths(t) {
            return e.MONTH_JS.map((e => new Date(2019, e).toLocaleString(t, {
                month: "long"
            })))
        }
        static formatPatterns(t, i) {
            switch (t) {
                case "YY":
                case "YYYY":
                    return {
                        group: "year", pattern: `(\\d{${t.length}})`
                    };
                case "M":
                    return {
                        group: "month", pattern: "(\\d{1,2})"
                    };
                case "MM":
                    return {
                        group: "month", pattern: "(\\d{2})"
                    };
                case "MMM":
                    return {
                        group: "shortMonth", pattern: `(${e.shortMonths(i).join("|")})`
                    };
                case "MMMM":
                    return {
                        group: "longMonth", pattern: `(${e.longMonths(i).join("|")})`
                    };
                case "D":
                    return {
                        group: "day", pattern: "(\\d{1,2})"
                    };
                case "DD":
                    return {
                        group: "day", pattern: "(\\d{2})"
                    };
                case "h":
                case "H":
                    return {
                        group: "hour", pattern: "(\\d{1,2})"
                    };
                case "hh":
                case "HH":
                    return {
                        group: "hour", pattern: "(\\d{2})"
                    };
                case "m":
                    return {
                        group: "minute", pattern: "(\\d{1,2})"
                    };
                case "mm":
                    return {
                        group: "minute", pattern: "(\\d{2})"
                    };
                case "s":
                    return {
                        group: "second", pattern: "(\\d{1,2})"
                    };
                case "ss":
                    return {
                        group: "second", pattern: "(\\d{2})"
                    };
                case "a":
                case "A":
                    return {
                        group: "ampm", pattern: "(AM|PM|am|pm)"
                    }
            }
        }
        lang;
        constructor(t = null, i = "YYYY-MM-DD", n = "en-US") {
            super(e.parseDateTime(t, i, n)), this.lang = n
        }
        getWeek(t) {
            const e = new Date(this.midnight_ts(this)),
                i = (this.getDay() + (7 - t)) % 7;
            e.setDate(e.getDate() - i);
            const n = e.getTime();
            return e.setMonth(0, 1), e.getDay() !== t && e.setMonth(0, 1 + (4 - e.getDay() + 7) % 7), 1 + Math.ceil((n - e.getTime()) / 6048e5)
        }
        clone() {
            return new e(this)
        }
        toJSDate() {
            return new Date(this)
        }
        inArray(t, e = "[]") {
            return t.some((t => t instanceof Array ? this.isBetween(t[0], t[1], e) : this.isSame(t, "day")))
        }
        isBetween(t, e, i = "()") {
            switch (i) {
                default:
                case "()":
                    return this.midnight_ts(this) > this.midnight_ts(t) && this.midnight_ts(this) < this.midnight_ts(e);
                case "[)":
                    return this.midnight_ts(this) >= this.midnight_ts(t) && this.midnight_ts(this) < this.midnight_ts(e);
                case "(]":
                    return this.midnight_ts(this) > this.midnight_ts(t) && this.midnight_ts(this) <= this.midnight_ts(e);
                case "[]":
                    return this.midnight_ts() >= this.midnight_ts(t) && this.midnight_ts() <= this.midnight_ts(e)
            }
        }
        isBefore(t, e = "days") {
            switch (e) {
                case "day":
                case "days":
                    return new Date(t.getFullYear(), t.getMonth(), t.getDate()).getTime() > new Date(this.getFullYear(), this.getMonth(), this.getDate()).getTime();
                case "month":
                case "months":
                    return new Date(t.getFullYear(), t.getMonth(), 1).getTime() > new Date(this.getFullYear(), this.getMonth(), 1).getTime();
                case "year":
                case "years":
                    return t.getFullYear() > this.getFullYear()
            }
            throw new Error("isBefore: Invalid unit!")
        }
        isSameOrBefore(t, e = "days") {
            switch (e) {
                case "day":
                case "days":
                    return new Date(t.getFullYear(), t.getMonth(), t.getDate()).getTime() >= new Date(this.getFullYear(), this.getMonth(), this.getDate()).getTime();
                case "month":
                case "months":
                    return new Date(t.getFullYear(), t.getMonth(), 1).getTime() >= new Date(this.getFullYear(), this.getMonth(), 1).getTime()
            }
            throw new Error("isSameOrBefore: Invalid unit!")
        }
        isAfter(t, e = "days") {
            switch (e) {
                case "day":
                case "days":
                    return new Date(this.getFullYear(), this.getMonth(), this.getDate()).getTime() > new Date(t.getFullYear(), t.getMonth(), t.getDate()).getTime();
                case "month":
                case "months":
                    return new Date(this.getFullYear(), this.getMonth(), 1).getTime() > new Date(t.getFullYear(), t.getMonth(), 1).getTime();
                case "year":
                case "years":
                    return this.getFullYear() > t.getFullYear()
            }
            throw new Error("isAfter: Invalid unit!")
        }
        isSameOrAfter(t, e = "days") {
            switch (e) {
                case "day":
                case "days":
                    return new Date(this.getFullYear(), this.getMonth(), this.getDate()).getTime() >= new Date(t.getFullYear(), t.getMonth(), t.getDate()).getTime();
                case "month":
                case "months":
                    return new Date(this.getFullYear(), this.getMonth(), 1).getTime() >= new Date(t.getFullYear(), t.getMonth(), 1).getTime()
            }
            throw new Error("isSameOrAfter: Invalid unit!")
        }
        isSame(t, e = "days") {
            switch (e) {
                case "day":
                case "days":
                    return new Date(this.getFullYear(), this.getMonth(), this.getDate()).getTime() === new Date(t.getFullYear(), t.getMonth(), t.getDate()).getTime();
                case "month":
                case "months":
                    return new Date(this.getFullYear(), this.getMonth(), 1).getTime() === new Date(t.getFullYear(), t.getMonth(), 1).getTime()
            }
            throw new Error("isSame: Invalid unit!")
        }
        add(t, e = "days") {
            switch (e) {
                case "day":
                case "days":
                    this.setDate(this.getDate() + t);
                    break;
                case "month":
                case "months":
                    this.setMonth(this.getMonth() + t)
            }
            return this
        }
        subtract(t, e = "days") {
            switch (e) {
                case "day":
                case "days":
                    this.setDate(this.getDate() - t);
                    break;
                case "month":
                case "months":
                    this.setMonth(this.getMonth() - t)
            }
            return this
        }
        diff(t, e = "days") {
            switch (e) {
                default:
                case "day":
                case "days":
                    return Math.round((this.midnight_ts() - this.midnight_ts(t)) / 864e5);
                case "month":
                case "months":
                    let e = 12 * (t.getFullYear() - this.getFullYear());
                    return e -= t.getMonth(), e += this.getMonth(), e
            }
        }
        format(t, i = "en-US") {
            let n = "";
            const s = [];
            let o = null;
            for (; null != (o = e.regex.exec(t));) "\\" !== o[1] && s.push(o);
            if (s.length) {
                s[0].index > 0 && (n += t.substring(0, s[0].index));
                for (const [e, o] of Object.entries(s)) {
                    const a = Number(e);
                    n += this.formatTokens(o[0], i), s[a + 1] && (n += t.substring(o.index + o[0].length, s[a + 1].index)), a === s.length - 1 && (n += t.substring(o.index + o[0].length))
                }
            }
            return n.replace(/\\/g, "")
        }
        midnight_ts(t) {
            return t ? new Date(t.getFullYear(), t.getMonth(), t.getDate(), 0, 0, 0, 0).getTime() : new Date(this.getFullYear(), this.getMonth(), this.getDate(), 0, 0, 0, 0).getTime()
        }
        formatTokens(t, i) {
            switch (t) {
                case "YY":
                    return String(this.getFullYear()).slice(-2);
                case "YYYY":
                    return String(this.getFullYear());
                case "M":
                    return String(this.getMonth() + 1);
                case "MM":
                    return `0${this.getMonth()+1}`.slice(-2);
                case "MMM":
                    return e.shortMonths(i)[this.getMonth()];
                case "MMMM":
                    return e.longMonths(i)[this.getMonth()];
                case "D":
                    return String(this.getDate());
                case "DD":
                    return `0${this.getDate()}`.slice(-2);
                case "H":
                    return String(this.getHours());
                case "HH":
                    return `0${this.getHours()}`.slice(-2);
                case "h":
                    return String(this.getHours() % 12 || 12);
                case "hh":
                    return `0${this.getHours()%12||12}`.slice(-2);
                case "m":
                    return String(this.getMinutes());
                case "mm":
                    return `0${this.getMinutes()}`.slice(-2);
                case "s":
                    return String(this.getSeconds());
                case "ss":
                    return `0${this.getSeconds()}`.slice(-2);
                case "a":
                    return this.getHours() < 12 || 24 === this.getHours() ? "am" : "pm";
                case "A":
                    return this.getHours() < 12 || 24 === this.getHours() ? "AM" : "PM";
                default:
                    return ""
            }
        }
    }
    class i {
        picker;
        constructor(t) {
            this.picker = t
        }
        render(t, i) {
            t || (t = new e), t.setDate(1), t.setHours(0, 0, 0, 0), "function" == typeof this[`get${i}View`] && this[`get${i}View`](t)
        }
        getContainerView(t) {
            this.picker.ui.container.innerHTML = "", this.picker.options.header && this.picker.trigger("render", {
                date: t.clone(),
                view: "Header"
            }), this.picker.trigger("render", {
                date: t.clone(),
                view: "Main"
            }), this.picker.options.autoApply || this.picker.trigger("render", {
                date: t.clone(),
                view: "Footer"
            })
        }
        getHeaderView(t) {
            const e = document.createElement("header");
            this.picker.options.header instanceof HTMLElement && e.appendChild(this.picker.options.header), "string" == typeof this.picker.options.header && (e.innerHTML = this.picker.options.header), this.picker.ui.container.appendChild(e), this.picker.trigger("view", {
                target: e,
                date: t.clone(),
                view: "Header"
            })
        }
        getMainView(t) {
            const e = document.createElement("main");
            this.picker.ui.container.appendChild(e);
            const i = document.createElement("div");
            i.className = `calendars grid-${this.picker.options.grid}`;
            for (let e = 0; e < this.picker.options.calendars; e++) {
                const n = document.createElement("div");
                n.className = "calendar", i.appendChild(n);
                const s = this.getCalendarHeaderView(t.clone());
                n.appendChild(s), this.picker.trigger("view", {
                    date: t.clone(),
                    view: "CalendarHeader",
                    index: e,
                    target: s
                });
                const o = this.getCalendarDayNamesView();
                n.appendChild(o), this.picker.trigger("view", {
                    date: t.clone(),
                    view: "CalendarDayNames",
                    index: e,
                    target: o
                });
                const a = this.getCalendarDaysView(t.clone());
                n.appendChild(a), this.picker.trigger("view", {
                    date: t.clone(),
                    view: "CalendarDays",
                    index: e,
                    target: a
                });
                const r = this.getCalendarFooterView(this.picker.options.lang, t.clone());
                n.appendChild(r), this.picker.trigger("view", {
                    date: t.clone(),
                    view: "CalendarFooter",
                    index: e,
                    target: r
                }), this.picker.trigger("view", {
                    date: t.clone(),
                    view: "CalendarItem",
                    index: e,
                    target: n
                }), t.add(1, "month")
            }
            e.appendChild(i), this.picker.trigger("view", {
                date: t.clone(),
                view: "Calendars",
                target: i
            }), this.picker.trigger("view", {
                date: t.clone(),
                view: "Main",
                target: e
            })
        }
        getFooterView(t) {
            const e = document.createElement("footer"),
                i = document.createElement("div");
            i.className = "footer-buttons";
            const n = document.createElement("button");
            n.className = "cancel-button unit", n.innerHTML = this.picker.options.locale.cancel, i.appendChild(n);
            n.ariaLabel = "cancel button";
            const s = document.createElement("button");
            s.ariaLabel = "apply button";
            s.className = "apply-button unit", s.innerHTML = this.picker.options.locale.apply, s.disabled = !0, i.appendChild(s), e.appendChild(i), this.picker.ui.container.appendChild(e), this.picker.trigger("view", {
                date: t,
                target: e,
                view: "Footer"
            })
        }
        getCalendarHeaderView(t) {
            const e = document.createElement("div");
            e.className = "header";
            const i = document.createElement("div");
            i.className = "month-name", i.innerHTML = `<span>${t.toLocaleString(this.picker.options.lang,{month:"long"})}</span> ${t.format("YYYY")}`, e.appendChild(i);
            const n = document.createElement("button");
            n.className = "previous-button unit", n.innerHTML = this.picker.options.locale.previousMonth, e.appendChild(n);
            n.ariaLabel = "previous button"
            const s = document.createElement("button");
            s.ariaLabel = "next button";
            return s.className = "next-button unit", s.innerHTML = this.picker.options.locale.nextMonth, e.appendChild(s), e
        }
        getCalendarDayNamesView() {
            const t = document.createElement("div");
            t.className = "daynames-row";
            for (let e = 1; e <= 7; e++) {
                const i = 3 + this.picker.options.firstDay + e,
                    n = document.createElement("div");
                n.className = "dayname", n.innerHTML = new Date(1970, 0, i, 12, 0, 0, 0).toLocaleString(this.picker.options.lang, {
                    weekday: "short"
                }), n.title = new Date(1970, 0, i, 12, 0, 0, 0).toLocaleString(this.picker.options.lang, {
                    weekday: "long"
                }), t.appendChild(n), this.picker.trigger("view", {
                    dayIdx: i,
                    view: "CalendarDayName",
                    target: n
                })
            }
            return t
        }
        getCalendarDaysView(t) {
            const e = document.createElement("div");
            e.className = "days-grid";
            const i = this.calcOffsetDays(t, this.picker.options.firstDay),
                n = 32 - new Date(t.getFullYear(), t.getMonth(), 32).getDate();
            for (let t = 0; t < i; t++) {
                const t = document.createElement("div");
                t.className = "offset", e.appendChild(t)
            }
            for (let i = 1; i <= n; i++) {
                t.setDate(i);
                const n = this.getCalendarDayView(t);
                e.appendChild(n), this.picker.trigger("view", {
                    date: t,
                    view: "CalendarDay",
                    target: n
                })
            }
            return e
        }
        getCalendarDayView(t) {
            const i = this.picker.options.date ? new e(this.picker.options.date) : null,
                n = new e,
                s = document.createElement("div");
            return s.className = "day unit", s.innerHTML = t.format("D"), s.dataset.time = String(t.getTime()), t.isSame(n, "day") && s.classList.add("today"), [0, 6].includes(t.getDay()) && s.classList.add("weekend"), this.picker.datePicked.length ? this.picker.datePicked[0].isSame(t, "day") && s.classList.add("selected") : i && t.isSame(i, "day") && s.classList.add("selected"), this.picker.trigger("view", {
                date: t,
                view: "CalendarDay",
                target: s
            }), s
        }
        getCalendarFooterView(t, e) {
            const i = document.createElement("div");
            return i.className = "footer", i
        }
        calcOffsetDays(t, e) {
            let i = t.getDay() - e;
            return i < 0 && (i += 7), i
        }
    }
    class n {
        picker;
        instances = {};
        constructor(t) {
            this.picker = t
        }
        initialize() {
            const t = [];
            this.picker.options.plugins.forEach((e => {
                "function" == typeof e ? t.push(new e) : "string" == typeof e && "undefined" != typeof easepick && Object.prototype.hasOwnProperty.call(easepick, e) ? t.push(new easepick[e]) : console.warn(`easepick: ${e} not found.`)
            })), t.sort(((t, e) => t.priority > e.priority ? -1 : t.priority < e.priority || t.dependencies.length > e.dependencies.length ? 1 : t.dependencies.length < e.dependencies.length ? -1 : 0)), t.forEach((t => {
                t.attach(this.picker), this.instances[t.getName()] = t
            }))
        }
        getInstance(t) {
            return this.instances[t]
        }
        addInstance(t) {
            if (Object.prototype.hasOwnProperty.call(this.instances, t)) console.warn(`easepick: ${t} already added.`);
            else {
                if ("undefined" != typeof easepick && Object.prototype.hasOwnProperty.call(easepick, t)) {
                    const e = new easepick[t];
                    return e.attach(this.picker), this.instances[e.getName()] = e, e
                }
                if ("undefined" !== this.getPluginFn(t)) {
                    const e = new(this.getPluginFn(t));
                    return e.attach(this.picker), this.instances[e.getName()] = e, e
                }
                console.warn(`easepick: ${t} not found.`)
            }
            return null
        }
        removeInstance(t) {
            return t in this.instances && this.instances[t].detach(), delete this.instances[t]
        }
        reloadInstance(t) {
            return this.removeInstance(t), this.addInstance(t)
        }
        getPluginFn(t) {
            return [...this.picker.options.plugins].filter((e => "function" == typeof e && (new e).getName() === t)).shift()
        }
    }
    class s {
        Calendar = new i(this);
        PluginManager = new n(this);
        calendars = [];
        datePicked = [];
        cssLoaded = 0;
        binds = {
            hidePicker: this.hidePicker.bind(this),
            show: this.show.bind(this)
        };
        options = {
            doc: document,
            css: [],
            element: null,
            firstDay: 1,
            grid: 1,
            calendars: 1,
            lang: "sr-Latn-RS",
            date: null,
            format: "YYYY-MM-DD",
            readonly: !0,
            autoApply: !0,
            header: !1,
            inline: !1,
            scrollToDate: !0,
            positionOverride: null,
            locale: {
                nextMonth: '<svg width="11" height="16" xmlns="http://www.w3.org/2000/svg"><path d="M2.748 16L0 13.333 5.333 8 0 2.667 2.748 0l7.919 8z" fill-rule="nonzero"/></svg>',
                previousMonth: '<svg width="11" height="16" xmlns="http://www.w3.org/2000/svg"><path d="M7.919 0l2.748 2.667L5.333 8l5.334 5.333L7.919 16 0 8z" fill-rule="nonzero"/></svg>',
                cancel: "Otkaži",
                apply: "Potvrdi"
            },
            documentClick: this.binds.hidePicker,
            plugins: []
        };
        ui = {
            container: null,
            shadowRoot: null,
            wrapper: null
        };
        version = "1.2.1";
        constructor(t) {
            const e = {
                ...this.options.locale,
                ...t.locale
            };
            this.options = {
                ...this.options,
                ...t
            }, this.options.locale = e, this.handleOptions(), this.ui.wrapper = document.createElement("span"), this.ui.wrapper.style.display = "none", this.ui.wrapper.style.position = "absolute", this.ui.wrapper.style.pointerEvents = "none", this.ui.wrapper.className = "easepick-wrapper", this.ui.wrapper.attachShadow({
                mode: "open"
            }), this.ui.shadowRoot = this.ui.wrapper.shadowRoot, this.ui.container = document.createElement("div"), this.ui.container.className = "container", this.options.zIndex && (this.ui.container.style.zIndex = String(this.options.zIndex)), this.options.inline && (this.ui.wrapper.style.position = "relative", this.ui.container.classList.add("inline")), this.ui.shadowRoot.appendChild(this.ui.container), this.options.element.after(this.ui.wrapper), this.handleCSS(), this.options.element.addEventListener("click", this.binds.show), this.on("view", this.onView.bind(this)), this.on("render", this.onRender.bind(this)), this.PluginManager.initialize(), this.parseValues(), "function" == typeof this.options.setup && this.options.setup(this), this.on("click", this.onClick.bind(this));
            const i = this.options.scrollToDate ? this.getDate() : null;
            this.renderAll(i)
        }
        on(t, e, i = {}) {
            this.ui.container.addEventListener(t, e, i)
        }
        off(t, e, i = {}) {
            this.ui.container.removeEventListener(t, e, i)
        }
        trigger(t, e = {}) {
            return this.ui.container.dispatchEvent(new CustomEvent(t, {
                detail: e
            }))
        }
        destroy() {
            this.options.element.removeEventListener("click", this.binds.show), "function" == typeof this.options.documentClick && document.removeEventListener("click", this.options.documentClick, !0), Object.keys(this.PluginManager.instances).forEach((t => {
                this.PluginManager.removeInstance(t)
            })), this.ui.wrapper.remove()
        }
        onRender(t) {
            const {
                view: e,
                date: i
            } = t.detail;
            this.Calendar.render(i, e)
        }
        onView(t) {
            const {
                view: e,
                target: i
            } = t.detail;
            "Footer" === e && this.datePicked.length && (i.querySelector(".apply-button").disabled = !1)
        }
        onClickHeaderButton(t) {
            this.isCalendarHeaderButton(t) && (t.classList.contains("next-button") ? this.calendars[0].add(1, "month") : this.calendars[0].subtract(1, "month"), this.renderAll(this.calendars[0]))
        }
        onClickCalendarDay(t) {
            if (this.isCalendarDay(t)) {
                const i = new e(t.dataset.time);
                this.options.autoApply ? (this.setDate(i), this.trigger("select", {
                    date: this.getDate()
                }), this.hide()) : (this.datePicked[0] = i, this.trigger("preselect", {
                    date: this.getDate()
                }), this.renderAll())
            }
        }
        onClickApplyButton(t) {
            if (this.isApplyButton(t)) {
                if (this.datePicked[0] instanceof Date) {
                    const t = this.datePicked[0].clone();
                    this.setDate(t)
                }
                this.hide(), this.trigger("select", {
                    date: this.getDate()
                })
            }
        }
        onClickCancelButton(t) {
            this.isCancelButton(t) && this.hide()
        }
        onClick(t) {
            const e = t.target;
            if (e instanceof HTMLElement) {
                const t = e.closest(".unit");
                if (!(t instanceof HTMLElement)) return;
                this.onClickHeaderButton(t), this.onClickCalendarDay(t), this.onClickApplyButton(t), this.onClickCancelButton(t)
            }
        }
        isShown() {
            return this.ui.container.classList.contains("inline") || this.ui.container.classList.contains("show")
        }
        show(t) {
            if (this.isShown()) return;
            const e = t && "target" in t ? t.target : this.options.element,
                {
                    top: i,
                    left: n
                } = this.adjustPosition(e);
            this.ui.container.style.top = `${i}px`, this.ui.container.style.left = `${n}px`, this.ui.container.classList.add("show"), this.trigger("show", {
                target: e
            })
        }
        hide() {
            this.ui.container.classList.remove("show"), this.datePicked.length = 0, this.renderAll(), this.trigger("hide")
        }
        setDate(t) {
            const i = new e(t, this.options.format);
            this.options.date = i.clone(), this.updateValues(), this.calendars.length && this.renderAll()
        }
        getDate() {
            return this.options.date instanceof e ? this.options.date.clone() : null
        }
        parseValues() {
            this.options.date ? this.setDate(this.options.date) : this.options.element instanceof HTMLInputElement && this.options.element.value.length && this.setDate(this.options.element.value), this.options.date instanceof Date || (this.options.date = null)
        }
        updateValues() {
            const t = this.getDate(),
                e = t instanceof Date ? t.format(this.options.format, this.options.lang) : "",
                i = this.options.element;
            i instanceof HTMLInputElement ? i.value = e : i instanceof HTMLElement && (i.innerText = e)
        }
        hidePicker(t) {
            let e = t.target,
                i = null;
            e.shadowRoot && (e = t.composedPath()[0], i = e.getRootNode().host), this.isShown() && i !== this.ui.wrapper && e !== this.options.element && this.hide()
        }
        renderAll(t) {
            this.trigger("render", {
                view: "Container",
                date: (t || this.calendars[0]).clone()
            })
        }
        isCalendarHeaderButton(t) {
            return ["previous-button", "next-button"].some((e => t.classList.contains(e)))
        }
        isCalendarDay(t) {
            return t.classList.contains("day")
        }
        isApplyButton(t) {
            return t.classList.contains("apply-button")
        }
        isCancelButton(t) {
            return t.classList.contains("cancel-button")
        }
        gotoDate(t) {
            const i = new e(t, this.options.format);
            i.setDate(1), this.calendars[0] = i.clone(), this.renderAll()
        }
        clear() {
            this.options.date = null, this.datePicked.length = 0, this.updateValues(), this.renderAll(), this.trigger("clear")
        }
        handleOptions() {
            this.options.element instanceof HTMLElement || (this.options.element = this.options.doc.querySelector(this.options.element)), "function" == typeof this.options.documentClick && document.addEventListener("click", this.options.documentClick, !0), this.options.element instanceof HTMLInputElement && (this.options.element.readOnly = this.options.readonly), this.options.date ? this.calendars[0] = new e(this.options.date, this.options.format) : this.calendars[0] = new e
        }
        handleCSS() {
            if (Array.isArray(this.options.css)) this.options.css.forEach((t => {
                const e = document.createElement("link");
                e.href = t, e.rel = "stylesheet";
                const i = () => {
                    this.cssLoaded++, this.cssLoaded === this.options.css.length && (this.ui.wrapper.style.display = "")
                };
                e.addEventListener("load", i), e.addEventListener("error", i), this.ui.shadowRoot.append(e)
            }));
            else if ("string" == typeof this.options.css) {
                const t = document.createElement("style"),
                    e = document.createTextNode(this.options.css);
                t.appendChild(e), this.ui.shadowRoot.append(t), this.ui.wrapper.style.display = ""
            } else "function" == typeof this.options.css && (this.options.css.call(this, this), this.ui.wrapper.style.display = "")
        }
        // adjustPosition(t) {
        //     const e = t.getBoundingClientRect(),
        //         i = this.ui.wrapper.getBoundingClientRect();
        //     this.ui.container.classList.add("calc");
        //     const n = this.ui.container.getBoundingClientRect();
        //     this.ui.container.classList.remove("calc");
        //     let s = e.bottom - i.bottom,
        //         o = e.left - i.left;
        //     return "undefined" != typeof window && (window.innerHeight < s + n.height && s - n.height >= 0 && (s = e.top - i.top - n.height), window.innerWidth < o + n.width && e.right - n.width >= 0 && (o = e.right - i.right - n.width)), {
        //         left: o,
        //         top: s
        //     }
        // }

        // 2. Then REPLACE the adjustPosition method with this enhanced version:

        adjustPosition(t) {
            const e = t.getBoundingClientRect(),
                i = this.ui.wrapper.getBoundingClientRect();

            this.ui.container.classList.add("calc");
            const n = this.ui.container.getBoundingClientRect();
            this.ui.container.classList.remove("calc");

            // Get viewport dimensions
            const viewportWidth = window.innerWidth || document.documentElement.clientWidth;
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight;

            let s = e.bottom - i.bottom; // default: below input
            let o = e.left - i.left;     // default: align with left edge of input

            // CHECK FOR POSITION OVERRIDE
            if (this.options.positionOverride) {
                const override = this.options.positionOverride.toLowerCase();

                switch (override) {
                    case 'center':
                        // Center relative to input element
                        s = (e.top + e.height / 2) - i.top - (n.height / 2);
                        o = (e.left + e.width / 2) - i.left - (n.width / 2);
                        break;

                    case 'top':
                        // Above input
                        s = e.top - i.top - n.height - 5;
                        o = e.left - i.left;
                        break;

                    case 'bottom':
                        // Below input
                        s = e.bottom - i.bottom + 5;
                        o = e.left - i.left;
                        break;

                    case 'left':
                        // Left of input
                        s = e.top - i.top;
                        o = e.left - i.left - n.width - 5;
                        break;

                    case 'right':
                        // Right of input
                        s = e.top - i.top;
                        o = e.right - i.left + 5;
                        break;

                    case 'top-center':
                        // Above input, centered horizontally
                        s = e.top - i.top - n.height - 5;
                        o = (e.left + e.width / 2) - i.left - (n.width / 2);
                        break;

                    case 'bottom-center':
                        // Below input, centered horizontally
                        s = e.bottom - i.bottom + 5;
                        o = (e.left + e.width / 2) - i.left - (n.width / 2);
                        break;

                    case 'left-center':
                        // Left of input, centered vertically
                        s = (e.top + e.height / 2) - i.top - (n.height / 2);
                        o = e.left - i.left - n.width - 5;
                        break;

                    case 'right-center':
                        // Right of input, centered vertically
                        s = (e.top + e.height / 2) - i.top - (n.height / 2);
                        o = e.right - i.left + 5;
                        break;

                    case 'top-left':
                        // Above input, aligned to left edge
                        s = e.top - i.top - n.height - 5;
                        o = e.left - i.left;
                        break;

                    case 'top-right':
                        // Above input, aligned to right edge
                        s = e.top - i.top - n.height - 5;
                        o = e.right - i.left - n.width;
                        break;

                    case 'bottom-left':
                        // Below input, aligned to left edge
                        s = e.bottom - i.bottom + 5;
                        o = e.left - i.left;
                        break;

                    case 'bottom-right':
                        // Below input, aligned to right edge
                        s = e.bottom - i.bottom + 5;
                        o = e.right - i.left - n.width;
                        break;

                    default:
                        // If invalid override, fall back to auto positioning
                        return this.autoPosition(t, e, i, n, viewportWidth, viewportHeight);
                }

                // Constrain to viewport when using override
                const finalLeft = o + i.left;
                const finalTop = s + i.top;

                if (finalLeft < 10) o = 10 - i.left;
                if (finalLeft + n.width > viewportWidth - 10) o = viewportWidth - 10 - n.width - i.left;
                if (finalTop < 10) s = 10 - i.top;
                if (finalTop + n.height > viewportHeight - 10) s = viewportHeight - 10 - n.height - i.top;

                return { left: o, top: s };
            }

            // If no override, use auto positioning
            return this.autoPosition(t, e, i, n, viewportWidth, viewportHeight);
        }
 

        autoPosition(t, e, i, n, viewportWidth, viewportHeight) {
            // Calculate available space in all directions
            const spaceAbove = e.top;
            const spaceBelow = viewportHeight - e.bottom;
            const spaceLeft = e.left;
            const spaceRight = viewportWidth - e.right;

            let s = e.bottom - i.bottom; // default: below input
            let o = e.left - i.left;     // default: align with left edge of input

            // VERTICAL POSITIONING
            if (spaceBelow < n.height && spaceAbove >= n.height) {
                s = e.top - i.top - n.height;
            }
            else if (spaceBelow < n.height && spaceAbove < n.height) {
                s = (viewportHeight - n.height) / 2 - i.top;
            }

            // HORIZONTAL POSITIONING
            if (spaceRight >= n.width) {
                o = e.left - i.left;
            }
            else if (spaceLeft >= n.width) {
                o = e.right - i.right - n.width;
            }
            else if (e.left + (e.width / 2) - (n.width / 2) >= 0 &&
                e.left + (e.width / 2) + (n.width / 2) <= viewportWidth) {
                o = (e.left + e.width / 2) - i.left - (n.width / 2);
            }
            else {
                o = (viewportWidth - n.width) / 2 - i.left;
            }

            // Constrain to viewport
            const finalLeft = o + i.left;
            const finalTop = s + i.top;

            if (finalLeft < 10) o = 10 - i.left;
            if (finalLeft + n.width > viewportWidth - 10) o = viewportWidth - 10 - n.width - i.left;
            if (finalTop < 10) s = 10 - i.top;
            if (finalTop + n.height > viewportHeight - 10) s = viewportHeight - 10 - n.height - i.top;

            return { left: o, top: s };
        }
    }
    var o = Object.freeze({
        __proto__: null,
        Core: s,
        create: s
    });
    class a {
        picker;
        options;
        priority = 0;
        dependencies = [];
        attach(t) {
            const e = this.getName(),
                i = {
                    ...this.options
                };
            this.options = {
                ...this.options,
                ...t.options[e] || {}
            };
            for (const n of Object.keys(i))
                if (null !== i[n] && "object" == typeof i[n] && Object.keys(i[n]).length && e in t.options && n in t.options[e]) {
                    const s = {
                        ...t.options[e][n]
                    };
                    null !== s && "object" == typeof s && Object.keys(s).length && Object.keys(s).every((t => Object.keys(i[n]).includes(t))) && (this.options[n] = {
                        ...i[n],
                        ...s
                    })
                } if (this.picker = t, this.dependenciesNotFound()) {
                const t = this.dependencies.filter((t => !this.pluginsAsStringArray().includes(t)));
                return void console.warn(`${this.getName()}: required dependencies (${t.join(", ")}).`)
            }
            const n = this.camelCaseToKebab(this.getName());
            this.picker.ui.container.classList.add(n), this.onAttach()
        }
        detach() {
            const t = this.camelCaseToKebab(this.getName());
            this.picker.ui.container.classList.remove(t), "function" == typeof this.onDetach && this.onDetach()
        }
        dependenciesNotFound() {
            return this.dependencies.length && !this.dependencies.every((t => this.pluginsAsStringArray().includes(t)))
        }
        pluginsAsStringArray() {
            return this.picker.options.plugins.map((t => "function" == typeof t ? (new t).getName() : t))
        }
        camelCaseToKebab(t) {
            return t.replace(/([a-zA-Z])(?=[A-Z])/g, "$1-").toLowerCase()
        }
    }
    t.AmpPlugin = class extends a {
        rangePlugin;
        lockPlugin;
        priority = 10;
        binds = {
            onView: this.onView.bind(this),
            onColorScheme: this.onColorScheme.bind(this)
        };
        options = {
            dropdown: {
                months: !1,
                years: !1,
                minYear: 1950,
                maxYear: null
            },
            darkMode: !0,
            locale: {
                resetButton: '<svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>'
            }
        };
        matchMedia;
        getName() {
            return "AmpPlugin"
        }
        onAttach() {
            this.options.darkMode && window && "matchMedia" in window && (this.matchMedia = window.matchMedia("(prefers-color-scheme: dark)"), this.matchMedia.matches && (this.picker.ui.container.dataset.theme = "dark"), this.matchMedia.addEventListener("change", this.binds.onColorScheme)), this.options.weekNumbers && this.picker.ui.container.classList.add("week-numbers"), this.picker.on("view", this.binds.onView)
        }
        onDetach() {
            this.options.darkMode && window && "matchMedia" in window && this.matchMedia.removeEventListener("change", this.binds.onColorScheme), this.picker.ui.container.removeAttribute("data-theme"), this.picker.ui.container.classList.remove("week-numbers"), this.picker.off("view", this.binds.onView)
        }
        onView(t) {
            this.lockPlugin = this.picker.PluginManager.getInstance("LockPlugin"), this.rangePlugin = this.picker.PluginManager.getInstance("RangePlugin"), this.handleDropdown(t), this.handleResetButton(t), this.handleWeekNumbers(t)
        }
        onColorScheme(t) {
            const e = t.matches ? "dark" : "light";
            this.picker.ui.container.dataset.theme = e
        }
        handleDropdown(t) {
            const {
                view: i,
                target: n,
                date: s,
                index: o
            } = t.detail;
            if ("CalendarHeader" === i) {
                const t = n.querySelector(".month-name");
                if (this.options.dropdown.months) {
                    t.childNodes[0].remove();
                    const i = document.createElement("select");
                    i.className = "month-name--select month-name--dropdown";
                    for (let t = 0; t < 12; t += 1) {
                        const n = document.createElement("option"),
                            o = new e(new Date(s.getFullYear(), t, 2, 0, 0, 0)),
                            a = new e(new Date(s.getFullYear(), t, 1, 0, 0, 0));
                        n.value = String(t), n.text = o.toLocaleString(this.picker.options.lang, {
                            month: "long"
                        }), this.lockPlugin && (n.disabled = this.lockPlugin.options.minDate && a.isBefore(new e(this.lockPlugin.options.minDate), "month") || this.lockPlugin.options.maxDate && a.isAfter(new e(this.lockPlugin.options.maxDate), "month")), n.selected = a.getMonth() === s.getMonth(), i.appendChild(n)
                    }
                    i.addEventListener("change", (t => {
                        const e = t.target;
                        this.picker.calendars[0].setDate(1), this.picker.calendars[0].setMonth(Number(e.value)), this.picker.renderAll()
                    })), t.prepend(i)
                }
                if (this.options.dropdown.years) {
                    t.childNodes[1].remove();
                    const i = document.createElement("select");
                    i.className = "month-name--select";
                    const n = this.options.dropdown.minYear,
                        o = this.options.dropdown.maxYear ? this.options.dropdown.maxYear : (new Date).getFullYear();
                    if (s.getFullYear() > o) {
                        const t = document.createElement("option");
                        t.value = String(s.getFullYear()), t.text = String(s.getFullYear()), t.selected = !0, t.disabled = !0, i.appendChild(t)
                    }
                    for (let t = o; t >= n; t -= 1) {
                        const n = document.createElement("option"),
                            o = new e(new Date(t, 0, 1, 0, 0, 0));
                        n.value = String(t), n.text = String(t), this.lockPlugin && (n.disabled = this.lockPlugin.options.minDate && o.isBefore(new e(this.lockPlugin.options.minDate), "year") || this.lockPlugin.options.maxDate && o.isAfter(new e(this.lockPlugin.options.maxDate), "year")), n.selected = s.getFullYear() === t, i.appendChild(n)
                    }
                    if (s.getFullYear() < n) {
                        const t = document.createElement("option");
                        t.value = String(s.getFullYear()), t.text = String(s.getFullYear()), t.selected = !0, t.disabled = !0, i.appendChild(t)
                    }
                    if ("asc" === this.options.dropdown.years) {
                        const t = Array.prototype.slice.call(i.childNodes).reverse();
                        i.innerHTML = "", t.forEach((t => {
                            t.innerHTML = t.value, i.appendChild(t)
                        }))
                    }
                    i.addEventListener("change", (t => {
                        const e = t.target;
                        this.picker.calendars[0].setFullYear(Number(e.value)), this.picker.renderAll()
                    })), t.appendChild(i)
                }
            }
        }
        handleResetButton(t) {
            const {
                view: e,
                target: i
            } = t.detail;
            if ("CalendarHeader" === e && this.options.resetButton) {
                const t = document.createElement("button");
                t.ariaLabel = "reset-button";
                t.className = "reset-button unit", t.innerHTML = this.options.locale.resetButton, t.addEventListener("click", (t => {
                    t.preventDefault();
                    let e = !0;
                    "function" == typeof this.options.resetButton && (e = this.options.resetButton.call(this)), e && this.picker.clear()
                })), i.appendChild(t)
            }
        }
        handleWeekNumbers(t) {
            if (this.options.weekNumbers) {
                const {
                    view: i,
                    target: n
                } = t.detail;
                if ("CalendarDayNames" === i) {
                    const t = document.createElement("div");
                    t.className = "wnum-header", t.innerHTML = "Wk", n.prepend(t)
                }
                "CalendarDays" === i && [...n.children].forEach(((t, i) => {
                    if (0 === i || i % 7 == 0) {
                        let i;
                        if (t.classList.contains("day")) i = new e(t.dataset.time);
                        else {
                            const t = n.querySelector(".day");
                            i = new e(t.dataset.time)
                        }
                        let s = i.getWeek(this.picker.options.firstDay);
                        53 === s && 0 === i.getMonth() && (s = "53/1");
                        const o = document.createElement("div");
                        o.className = "wnum-item", o.innerHTML = String(s), n.insertBefore(o, t)
                    }
                }))
            }
        }
    }, t.DateTime = e, t.KbdPlugin = class extends a {
        docElement = null;
        rangePlugin;
        binds = {
            onView: this.onView.bind(this),
            onKeydown: this.onKeydown.bind(this)
        };
        options = {
            unitIndex: 1,
            dayIndex: 2
        };
        getName() {
            return "KbdPlugin"
        }
        onAttach() {
            const t = this.picker.options.element,
                e = t.getBoundingClientRect();
            if (this.docElement = document.createElement("span"), this.docElement.style.position = "absolute", this.docElement.style.top = `${t.offsetTop}px`, this.docElement.style.left = t.offsetLeft + e.width - 25 + "px", this.docElement.attachShadow({
                mode: "open"
            }), this.options.html) this.docElement.shadowRoot.innerHTML = this.options.html;
            else {
                const t = `\n      <style>\n      button {\n        border: none;\n        background: transparent;\n        font-size: ${window.getComputedStyle(this.picker.options.element).fontSize};\n      }\n      </style>\n\n      <button>&#128197;</button>\n      `;
                this.docElement.shadowRoot.innerHTML = t
            }
            const i = this.docElement.shadowRoot.querySelector("button");
            i && (i.addEventListener("click", (t => {
                t.preventDefault(), this.picker.show({
                    target: this.picker.options.element
                })
            }), {
                capture: !0
            }), i.addEventListener("keydown", (t => {
                "Escape" === t.code && this.picker.hide()
            }), {
                capture: !0
            })), this.picker.options.element.after(this.docElement), this.picker.on("view", this.binds.onView), this.picker.on("keydown", this.binds.onKeydown)
        }
        onDetach() {
            this.docElement && this.docElement.isConnected && this.docElement.remove(), this.picker.off("view", this.binds.onView), this.picker.off("keydown", this.binds.onKeydown)
        }
        onView(t) {
            const {
                view: e,
                target: i
            } = t.detail;
            i && "querySelector" in i && ("CalendarDay" !== e || ["locked", "not-available"].some((t => i.classList.contains(t))) ? [...i.querySelectorAll(".unit:not(.day)")].forEach((t => t.tabIndex = this.options.unitIndex)) : i.tabIndex = this.options.dayIndex)
        }
        onKeydown(t) {
            switch (this.onMouseEnter(t), t.code) {
                case "ArrowUp":
                case "ArrowDown":
                    this.verticalMove(t);
                    break;
                case "ArrowLeft":
                case "ArrowRight":
                    this.horizontalMove(t);
                    break;
                case "Enter":
                case "Space":
                    this.handleEnter(t);
                    break;
                case "Escape":
                    this.picker.hide()
            }
        }
        findAllowableDaySibling(t, e, i) {
            const n = Array.from(t.querySelectorAll(`.day[tabindex="${this.options.dayIndex}"]`)),
                s = n.indexOf(e);
            return n.filter(((t, e) => i(e, s) && t.tabIndex === this.options.dayIndex))[0]
        }
        changeMonth(t) {
            const e = {
                    ArrowLeft: "previous",
                    ArrowRight: "next"
                },
                i = this.picker.ui.container.querySelector(`.${e[t.code]}-button[tabindex="${this.options.unitIndex}"]`);
            i && !i.parentElement.classList.contains(`no-${e[t.code]}-month`) && (i.dispatchEvent(new Event("click", {
                bubbles: !0
            })), setTimeout((() => {
                let e = null;
                switch (t.code) {
                    case "ArrowLeft":
                        const t = this.picker.ui.container.querySelectorAll(`.day[tabindex="${this.options.dayIndex}"]`);
                        e = t[t.length - 1];
                        break;
                    case "ArrowRight":
                        e = this.picker.ui.container.querySelector(`.day[tabindex="${this.options.dayIndex}"]`)
                }
                e && e.focus()
            })))
        }
        verticalMove(t) {
            const e = t.target;
            if (e.classList.contains("day")) {
                t.preventDefault();
                const i = this.findAllowableDaySibling(this.picker.ui.container, e, ((e, i) => e === ("ArrowUp" === t.code ? i - 7 : i + 7)));
                i && i.focus()
            }
        }
        horizontalMove(t) {
            const e = t.target;
            if (e.classList.contains("day")) {
                t.preventDefault();
                const i = this.findAllowableDaySibling(this.picker.ui.container, e, ((e, i) => e === ("ArrowLeft" === t.code ? i - 1 : i + 1)));
                i ? i.focus() : this.changeMonth(t)
            }
        }
        handleEnter(t) {
            const e = t.target;
            e.classList.contains("day") && (t.preventDefault(), e.dispatchEvent(new Event("click", {
                bubbles: !0
            })), setTimeout((() => {
                if (this.rangePlugin = this.picker.PluginManager.getInstance("RangePlugin"), this.rangePlugin || !this.picker.options.autoApply) {
                    const t = this.picker.ui.container.querySelector(".day.selected");
                    t && setTimeout((() => {
                        t.focus()
                    }))
                }
            })))
        }
        onMouseEnter(t) {
            t.target.classList.contains("day") && setTimeout((() => {
                const t = this.picker.ui.shadowRoot.activeElement;
                t && t.dispatchEvent(new Event("mouseenter", {
                    bubbles: !0
                }))
            }))
        }
    }, t.LockPlugin = class extends a {
        priority = 1;
        binds = {
            onView: this.onView.bind(this)
        };
        options = {
            minDate: null,
            maxDate: null,
            minDays: null,
            maxDays: null,
            selectForward: null,
            selectBackward: null,
            presets: !0,
            inseparable: !1,
            filter: null
        };
        getName() {
            return "LockPlugin"
        }
        onAttach() {
            if (this.options.minDate && (this.options.minDate = new e(this.options.minDate, this.picker.options.format, this.picker.options.lang)), this.options.maxDate && (this.options.maxDate = new e(this.options.maxDate, this.picker.options.format, this.picker.options.lang), this.options.maxDate instanceof e && this.picker.options.calendars > 1 && this.picker.calendars[0].isSame(this.options.maxDate, "month"))) {
                const t = this.picker.calendars[0].clone().subtract(1, "month");
                this.picker.gotoDate(t)
            }
            if ((this.options.minDays || this.options.maxDays || this.options.selectForward || this.options.selectBackward) && !this.picker.options.plugins.includes("RangePlugin")) {
                const t = ["minDays", "maxDays", "selectForward", "selectBackward"];
                console.warn(`${this.getName()}: options ${t.join(", ")} required RangePlugin.`)
            }
            this.picker.on("view", this.binds.onView)
        }
        onDetach() {
            this.picker.off("view", this.binds.onView)
        }
        onView(t) {
            const {
                view: i,
                target: n,
                date: s
            } = t.detail;
            if ("CalendarHeader" === i && (this.options.minDate instanceof e && s.isSameOrBefore(this.options.minDate, "month") && n.classList.add("no-previous-month"), this.options.maxDate instanceof e && s.isSameOrAfter(this.options.maxDate, "month") && n.classList.add("no-next-month")), "CalendarDay" === i) {
                const t = this.picker.datePicked.length ? this.picker.datePicked[0] : null;
                if (this.testFilter(s)) return void n.classList.add("locked");
                if (this.options.inseparable) {
                    if (this.options.minDays) {
                        const t = s.clone().subtract(this.options.minDays - 1, "day"),
                            e = s.clone().add(this.options.minDays - 1, "day");
                        let i = !1,
                            o = !1;
                        for (; t.isBefore(s, "day");) {
                            if (this.testFilter(t)) {
                                i = !0;
                                break
                            }
                            t.add(1, "day")
                        }
                        for (; e.isAfter(s, "day");) {
                            if (this.testFilter(e)) {
                                o = !0;
                                break
                            }
                            e.subtract(1, "day")
                        }
                        i && o && n.classList.add("not-available")
                    }
                    this.rangeIsNotAvailable(s, t) && n.classList.add("not-available")
                }
                this.dateIsNotAvailable(s, t) && n.classList.add("not-available")
            }
            if (this.options.presets && "PresetPluginButton" === i) {
                const t = new e(Number(n.dataset.start)),
                    i = new e(Number(n.dataset.end)),
                    s = i.diff(t, "day"),
                    o = this.options.minDays && s < this.options.minDays,
                    a = this.options.maxDays && s > this.options.maxDays;
                (o || a || this.lockMinDate(t) || this.lockMaxDate(t) || this.lockMinDate(i) || this.lockMaxDate(i) || this.rangeIsNotAvailable(t, i)) && n.setAttribute("disabled", "disabled")
            }
        }
        dateIsNotAvailable(t, e) {
            return this.lockMinDate(t) || this.lockMaxDate(t) || this.lockMinDays(t, e) || this.lockMaxDays(t, e) || this.lockSelectForward(t) || this.lockSelectBackward(t)
        }
        rangeIsNotAvailable(t, e) {
            if (!t || !e) return !1;
            const i = (t.isSameOrBefore(e, "day") ? t : e).clone(),
                n = (e.isSameOrAfter(t, "day") ? e : t).clone();
            for (; i.isSameOrBefore(n, "day");) {
                if (this.testFilter(i)) return !0;
                i.add(1, "day")
            }
            return !1
        }
        lockMinDate(t) {
            return this.options.minDate instanceof e && t.isBefore(this.options.minDate, "day")
        }
        lockMaxDate(t) {
            return this.options.maxDate instanceof e && t.isAfter(this.options.maxDate, "day")
        }
        lockMinDays(t, e) {
            if (this.options.minDays && e) {
                const i = e.clone().subtract(this.options.minDays - 1, "day"),
                    n = e.clone().add(this.options.minDays - 1, "day");
                return t.isBetween(i, n)
            }
            return !1
        }
        lockMaxDays(t, e) {
            if (this.options.maxDays && e) {
                const i = e.clone().subtract(this.options.maxDays, "day"),
                    n = e.clone().add(this.options.maxDays, "day");
                return !t.isBetween(i, n)
            }
            return !1
        }
        lockSelectForward(t) {
            if (1 === this.picker.datePicked.length && this.options.selectForward) {
                const e = this.picker.datePicked[0].clone();
                return t.isBefore(e, "day")
            }
            return !1
        }
        lockSelectBackward(t) {
            if (1 === this.picker.datePicked.length && this.options.selectBackward) {
                const e = this.picker.datePicked[0].clone();
                return t.isAfter(e, "day")
            }
            return !1
        }
        testFilter(t) {
            return "function" == typeof this.options.filter && this.options.filter(t, this.picker.datePicked)
        }
    }, t.PresetPlugin = class extends a {
        dependencies = ["RangePlugin"];
        binds = {
            onView: this.onView.bind(this),
            onClick: this.onClick.bind(this)
        };
        options = {
            customLabels: ["Danas", "Juče", "Prošla sedmica", "Prethodnih 30 dana", "Ovaj mesec", "Prošli mesec"],
            customPreset: {},
            position: "left"
        };
        getName() {
            return "PresetPlugin"
        }
        onAttach() {
            if (!Object.keys(this.options.customPreset).length) {
                const t = new e,
                    i = () => {
                        const i = t.clone();
                        i.setDate(1);
                        const n = new Date(t.getFullYear(), t.getMonth() + 1, 0);
                        return [new e(i), new e(n)]
                    },
                    n = () => {
                        const i = t.clone();
                        i.setMonth(i.getMonth() - 1), i.setDate(1);
                        const n = new Date(t.getFullYear(), t.getMonth(), 0);
                        return [new e(i), new e(n)]
                    },
                    s = [
                        [t.clone(), t.clone()],
                        [t.clone().subtract(1, "day"), t.clone().subtract(1, "day")],
                        [t.clone().subtract(6, "day"), t.clone()],
                        [t.clone().subtract(29, "day"), t.clone()], i(), n()
                    ];
                Object.values(this.options.customLabels).forEach(((t, e) => {
                    this.options.customPreset[t] = s[e]
                }))
            }
            this.picker.on("view", this.binds.onView), this.picker.on("click", this.binds.onClick)
        }
        onDetach() {
            this.picker.off("view", this.binds.onView), this.picker.off("click", this.binds.onClick)
        }
        onView(t) {
            const {
                view: e,
                target: i
            } = t.detail;
            if ("Main" === e) {
                const t = document.createElement("div");
                t.className = "preset-plugin-container", Object.keys(this.options.customPreset).forEach((e => {
                    if (Object.prototype.hasOwnProperty.call(this.options.customPreset, e)) {
                        const i = this.options.customPreset[e],
                            n = document.createElement("button");
                        n.ariaLabel = "preset button";
                        n.className = "preset-button unit", n.innerHTML = e, n.dataset.start = i[0].getTime(), n.dataset.end = i[1].getTime(), t.appendChild(n), this.picker.trigger("view", {
                            view: "PresetPluginButton",
                            target: n
                        })
                    }
                })), i.appendChild(t), i.classList.add(`preset-${this.options.position}`), this.picker.trigger("view", {
                    view: "PresetPluginContainer",
                    target: t
                })
            }
        }
        onClick(t) {
            const i = t.target;
            if (i instanceof HTMLElement) {
                const t = i.closest(".unit");
                if (!(t instanceof HTMLElement)) return;
                if (this.isPresetButton(t)) {
                    const i = new e(Number(t.dataset.start)),
                        n = new e(Number(t.dataset.end));
                    this.picker.options.autoApply ? (this.picker.setDateRange(i, n), this.picker.trigger("select", {
                        start: this.picker.getStartDate(),
                        end: this.picker.getEndDate()
                    }), this.picker.hide()) : (this.picker.datePicked = [i, n], this.picker.renderAll())
                }
            }
        }
        isPresetButton(t) {
            return t.classList.contains("preset-button")
        }
    }, t.RangePlugin = class extends a {
        tooltipElement;
        triggerElement;
        binds = {
            setStartDate: this.setStartDate.bind(this),
            setEndDate: this.setEndDate.bind(this),
            setDateRange: this.setDateRange.bind(this),
            getStartDate: this.getStartDate.bind(this),
            getEndDate: this.getEndDate.bind(this),
            onView: this.onView.bind(this),
            onShow: this.onShow.bind(this),
            onMouseEnter: this.onMouseEnter.bind(this),
            onMouseLeave: this.onMouseLeave.bind(this),
            onClickCalendarDay: this.onClickCalendarDay.bind(this),
            onClickApplyButton: this.onClickApplyButton.bind(this),
            parseValues: this.parseValues.bind(this),
            updateValues: this.updateValues.bind(this),
            clear: this.clear.bind(this)
        };
        options = {
            elementEnd: null,
            startDate: null,
            endDate: null,
            repick: !1,
            strict: !0,
            delimiter: " - ",
            tooltip: !0,
            tooltipNumber: t => t,
            locale: {
                zero: "",
                one: "dan",
                two: "dana",
                few: "dana",
                many: "dana",
                other: "dana"
            },
            documentClick: this.hidePicker.bind(this)
        };
        getName() {
            return "RangePlugin"
        }
        onAttach() {
            this.binds._setStartDate = this.picker.setStartDate, this.binds._setEndDate = this.picker.setEndDate, this.binds._setDateRange = this.picker.setDateRange, this.binds._getStartDate = this.picker.getStartDate, this.binds._getEndDate = this.picker.getEndDate, this.binds._parseValues = this.picker.parseValues, this.binds._updateValues = this.picker.updateValues, this.binds._clear = this.picker.clear, this.binds._onClickCalendarDay = this.picker.onClickCalendarDay, this.binds._onClickApplyButton = this.picker.onClickApplyButton, Object.defineProperties(this.picker, {
                setStartDate: {
                    configurable: !0,
                    value: this.binds.setStartDate
                },
                setEndDate: {
                    configurable: !0,
                    value: this.binds.setEndDate
                },
                setDateRange: {
                    configurable: !0,
                    value: this.binds.setDateRange
                },
                getStartDate: {
                    configurable: !0,
                    value: this.binds.getStartDate
                },
                getEndDate: {
                    configurable: !0,
                    value: this.binds.getEndDate
                },
                parseValues: {
                    configurable: !0,
                    value: this.binds.parseValues
                },
                updateValues: {
                    configurable: !0,
                    value: this.binds.updateValues
                },
                clear: {
                    configurable: !0,
                    value: this.binds.clear
                },
                onClickCalendarDay: {
                    configurable: !0,
                    value: this.binds.onClickCalendarDay
                },
                onClickApplyButton: {
                    configurable: !0,
                    value: this.binds.onClickApplyButton
                }
            }), this.options.elementEnd && (this.options.elementEnd instanceof HTMLElement || (this.options.elementEnd = this.picker.options.doc.querySelector(this.options.elementEnd)), this.options.elementEnd instanceof HTMLInputElement && (this.options.elementEnd.readOnly = this.picker.options.readonly), "function" == typeof this.picker.options.documentClick && (document.removeEventListener("click", this.picker.options.documentClick, !0), "function" == typeof this.options.documentClick && document.addEventListener("click", this.options.documentClick, !0)), this.options.elementEnd.addEventListener("click", this.picker.show.bind(this.picker))), this.options.repick = this.options.repick && this.options.elementEnd instanceof HTMLElement, this.picker.options.date = null, this.picker.on("view", this.binds.onView), this.picker.on("show", this.binds.onShow), this.picker.on("mouseenter", this.binds.onMouseEnter, !0), this.picker.on("mouseleave", this.binds.onMouseLeave, !0), this.checkIntlPluralLocales()
        }
        onDetach() {
            Object.defineProperties(this.picker, {
                setStartDate: {
                    configurable: !0,
                    value: this.binds._setStartDate
                },
                setEndDate: {
                    configurable: !0,
                    value: this.binds._setEndDate
                },
                setDateRange: {
                    configurable: !0,
                    value: this.binds._setDateRange
                },
                getStartDate: {
                    configurable: !0,
                    value: this.binds._getStartDate
                },
                getEndDate: {
                    configurable: !0,
                    value: this.binds._getEndDate
                },
                parseValues: {
                    configurable: !0,
                    value: this.binds._parseValues
                },
                updateValues: {
                    configurable: !0,
                    value: this.binds._updateValues
                },
                clear: {
                    configurable: !0,
                    value: this.binds._clear
                },
                onClickCalendarDay: {
                    configurable: !0,
                    value: this.binds._onClickCalendarDay
                },
                onClickApplyButton: {
                    configurable: !0,
                    value: this.binds._onClickApplyButton
                }
            }), this.picker.off("view", this.binds.onView), this.picker.off("show", this.binds.onShow), this.picker.off("mouseenter", this.binds.onMouseEnter, !0), this.picker.off("mouseleave", this.binds.onMouseLeave, !0)
        }
        parseValues() {
            if (this.options.startDate || this.options.endDate) this.options.strict ? this.options.startDate && this.options.endDate ? this.setDateRange(this.options.startDate, this.options.endDate) : (this.options.startDate = null, this.options.endDate = null) : (this.options.startDate && this.setStartDate(this.options.startDate), this.options.endDate && this.setEndDate(this.options.endDate));
            else if (this.options.elementEnd) this.options.strict ? this.picker.options.element instanceof HTMLInputElement && this.picker.options.element.value.length && this.options.elementEnd instanceof HTMLInputElement && this.options.elementEnd.value.length && this.setDateRange(this.picker.options.element.value, this.options.elementEnd.value) : (this.picker.options.element instanceof HTMLInputElement && this.picker.options.element.value.length && this.setStartDate(this.picker.options.element.value), this.options.elementEnd instanceof HTMLInputElement && this.options.elementEnd.value.length && this.setEndDate(this.options.elementEnd.value));
            else if (this.picker.options.element instanceof HTMLInputElement && this.picker.options.element.value.length) {
                const [t, e] = this.picker.options.element.value.split(this.options.delimiter);
                this.options.strict ? t && e && this.setDateRange(t, e) : (t && this.setStartDate(t), e && this.setEndDate(e))
            }
        }
        updateValues() {
            const t = this.picker.options.element,
                e = this.options.elementEnd,
                i = this.picker.getStartDate(),
                n = this.picker.getEndDate(),
                s = i instanceof Date ? i.format(this.picker.options.format, this.picker.options.lang) : "",
                o = n instanceof Date ? n.format(this.picker.options.format, this.picker.options.lang) : "";
            if (e) t instanceof HTMLInputElement ? t.value = s : t instanceof HTMLElement && (t.innerText = s), e instanceof HTMLInputElement ? e.value = o : e instanceof HTMLElement && (e.innerText = o);
            else {
                const e = `${s}${s||o?this.options.delimiter:""}${o}`;
                t instanceof HTMLInputElement ? t.value = e : t instanceof HTMLElement && (t.innerText = e)
            }
        }
        clear() {
            this.options.startDate = null, this.options.endDate = null, this.picker.datePicked.length = 0, this.updateValues(), this.picker.renderAll(), this.picker.trigger("clear")
        }
        onShow(t) {
            const {
                target: e
            } = t.detail;
            this.triggerElement = e, this.picker.options.scrollToDate && this.getStartDate() instanceof Date && this.picker.gotoDate(this.getStartDate()), this.initializeRepick()
        }
        onView(t) {
            const {
                view: i,
                target: n
            } = t.detail;
            if ("Main" === i && (this.tooltipElement = document.createElement("span"), this.tooltipElement.className = "range-plugin-tooltip", n.appendChild(this.tooltipElement)), "CalendarDay" === i) {
                const t = new e(n.dataset.time),
                    i = this.picker.datePicked,
                    s = i.length ? this.picker.datePicked[0] : this.getStartDate(),
                    o = i.length ? this.picker.datePicked[1] : this.getEndDate();
                s && s.isSame(t, "day") && n.classList.add("start"), s && o && (o.isSame(t, "day") && n.classList.add("end"), t.isBetween(s, o) && n.classList.add("in-range"))
            }
            if ("Footer" === i) {
                const t = 1 === this.picker.datePicked.length && !this.options.strict || 2 === this.picker.datePicked.length;
                n.querySelector(".apply-button").disabled = !t
            }
        }
        hidePicker(t) {
            let e = t.target,
                i = null;
            e.shadowRoot && (e = t.composedPath()[0], i = e.getRootNode().host), this.picker.isShown() && i !== this.picker.ui.wrapper && e !== this.picker.options.element && e !== this.options.elementEnd && this.picker.hide()
        }
        setStartDate(t) {
            const i = new e(t, this.picker.options.format);
            this.options.startDate = i ? i.clone() : null, this.updateValues(), this.picker.renderAll()
        }
        setEndDate(t) {
            const i = new e(t, this.picker.options.format);
            this.options.endDate = i ? i.clone() : null, this.updateValues(), this.picker.renderAll()
        }
        setDateRange(t, i) {
            const n = new e(t, this.picker.options.format),
                s = new e(i, this.picker.options.format);
            this.options.startDate = n ? n.clone() : null, this.options.endDate = s ? s.clone() : null, this.updateValues(), this.picker.renderAll()
        }
        getStartDate() {
            return this.options.startDate instanceof Date ? this.options.startDate.clone() : null
        }
        getEndDate() {
            return this.options.endDate instanceof Date ? this.options.endDate.clone() : null
        }
        onMouseEnter(t) {
            const i = t.target;
            if (i instanceof HTMLElement) {
                this.isContainer(i) && this.initializeRepick();
                const t = i.closest(".unit");
                if (!(t instanceof HTMLElement)) return;
                if (this.picker.isCalendarDay(t)) {
                    if (1 !== this.picker.datePicked.length) return;
                    let i = this.picker.datePicked[0].clone(),
                        n = new e(t.dataset.time),
                        s = !1;
                    if (i.isAfter(n, "day")) {
                        const t = i.clone();
                        i = n.clone(), n = t.clone(), s = !0
                    }
                    if ([...this.picker.ui.container.querySelectorAll(".day")].forEach((o => {
                        const a = new e(o.dataset.time),
                            r = this.picker.Calendar.getCalendarDayView(a);
                        a.isBetween(i, n) && r.classList.add("in-range"), a.isSame(this.picker.datePicked[0], "day") && (r.classList.add("start"), r.classList.toggle("flipped", s)), o === t && (r.classList.add("end"), r.classList.toggle("flipped", s)), o.className = r.className
                    })), this.options.tooltip) {
                        const e = this.options.tooltipNumber(n.diff(i, "day") + 1);
                        if (e > 0) {
                            const i = new Intl.PluralRules(this.picker.options.lang).select(e),
                                n = `${e} ${this.options.locale[i]}`;
                            this.showTooltip(t, n)
                        } else this.hideTooltip()
                    }
                }
            }
        }
        onMouseLeave(t) {
            if (this.isContainer(t.target) && this.options.repick) {
                const t = this.getStartDate(),
                    e = this.getEndDate();
                t && e && (this.picker.datePicked.length = 0, this.picker.renderAll())
            }
        }
        onClickCalendarDay(t) {
            if (this.picker.isCalendarDay(t)) {
                2 === this.picker.datePicked.length && (this.picker.datePicked.length = 0);
                const i = new e(t.dataset.time);
                if (this.picker.datePicked[this.picker.datePicked.length] = i, 2 === this.picker.datePicked.length && this.picker.datePicked[0].isAfter(this.picker.datePicked[1])) {
                    const t = this.picker.datePicked[1].clone();
                    this.picker.datePicked[1] = this.picker.datePicked[0].clone(), this.picker.datePicked[0] = t.clone()
                }
                1 !== this.picker.datePicked.length && this.picker.options.autoApply || this.picker.trigger("preselect", {
                    start: this.picker.datePicked[0] instanceof Date ? this.picker.datePicked[0].clone() : null,
                    end: this.picker.datePicked[1] instanceof Date ? this.picker.datePicked[1].clone() : null
                }), 1 === this.picker.datePicked.length && (!this.options.strict && this.picker.options.autoApply && (this.picker.options.element === this.triggerElement && this.setStartDate(this.picker.datePicked[0]), this.options.elementEnd === this.triggerElement && this.setEndDate(this.picker.datePicked[0]), this.picker.trigger("select", {
                    start: this.picker.getStartDate(),
                    end: this.picker.getEndDate()
                })), this.picker.renderAll()), 2 === this.picker.datePicked.length && (this.picker.options.autoApply ? (this.setDateRange(this.picker.datePicked[0], this.picker.datePicked[1]), this.picker.trigger("select", {
                    start: this.picker.getStartDate(),
                    end: this.picker.getEndDate()
                }), this.picker.hide()) : (this.hideTooltip(), this.picker.renderAll()))
            }
        }
        onClickApplyButton(t) {
            this.picker.isApplyButton(t) && (1 !== this.picker.datePicked.length || this.options.strict || (this.picker.options.element === this.triggerElement && (this.options.endDate = null, this.setStartDate(this.picker.datePicked[0])), this.options.elementEnd === this.triggerElement && (this.options.startDate = null, this.setEndDate(this.picker.datePicked[0]))), 2 === this.picker.datePicked.length && this.setDateRange(this.picker.datePicked[0], this.picker.datePicked[1]), this.picker.trigger("select", {
                start: this.picker.getStartDate(),
                end: this.picker.getEndDate()
            }), this.picker.hide())
        }
        showTooltip(t, e) {
            this.tooltipElement.style.visibility = "visible", this.tooltipElement.innerHTML = e;
            const i = this.picker.ui.container.getBoundingClientRect(),
                n = this.tooltipElement.getBoundingClientRect(),
                s = t.getBoundingClientRect();
            let o = s.top,
                a = s.left;
            o -= i.top, a -= i.left, o -= n.height, a -= n.width / 2, a += s.width / 2, this.tooltipElement.style.top = `${o}px`, this.tooltipElement.style.left = `${a}px`
        }
        hideTooltip() {
            this.tooltipElement.style.visibility = "hidden"
        }
        checkIntlPluralLocales() {
            if (!this.options.tooltip) return;
            const t = [...new Set([new Intl.PluralRules(this.picker.options.lang).select(0), new Intl.PluralRules(this.picker.options.lang).select(1), new Intl.PluralRules(this.picker.options.lang).select(2), new Intl.PluralRules(this.picker.options.lang).select(6), new Intl.PluralRules(this.picker.options.lang).select(18)])],
                e = Object.keys(this.options.locale);
            t.every((t => e.includes(t))) || console.warn(`${this.getName()}: provide locales (${t.join(", ")}) for correct tooltip text.`)
        }
        initializeRepick() {
            if (!this.options.repick) return;
            const t = this.getStartDate(),
                e = this.getEndDate();
            e && this.triggerElement === this.picker.options.element && (this.picker.datePicked[0] = e), t && this.triggerElement === this.options.elementEnd && (this.picker.datePicked[0] = t)
        }
        isContainer(t) {
            return t === this.picker.ui.container
        }
    }, t.TimePlugin = class extends a {
        options = {
            native: !1,
            seconds: !1,
            stepHours: 1,
            stepMinutes: 5,
            stepSeconds: 5,
            format12: !1
        };
        rangePlugin;
        timePicked = {
            input: null,
            start: null,
            end: null
        };
        timePrePicked = {
            input: null,
            start: null,
            end: null
        };
        binds = {
            getDate: this.getDate.bind(this),
            getStartDate: this.getStartDate.bind(this),
            getEndDate: this.getEndDate.bind(this),
            onView: this.onView.bind(this),
            onInput: this.onInput.bind(this),
            onChange: this.onChange.bind(this),
            onClick: this.onClick.bind(this),
            setTime: this.setTime.bind(this),
            setStartTime: this.setStartTime.bind(this),
            setEndTime: this.setEndTime.bind(this)
        };
        getName() {
            return "TimePlugin"
        }
        onAttach() {
            this.binds._getDate = this.picker.getDate, this.binds._getStartDate = this.picker.getStartDate, this.binds._getEndDate = this.picker.getEndDate, Object.defineProperties(this.picker, {
                getDate: {
                    configurable: !0,
                    value: this.binds.getDate
                },
                getStartDate: {
                    configurable: !0,
                    value: this.binds.getStartDate
                },
                getEndDate: {
                    configurable: !0,
                    value: this.binds.getEndDate
                },
                setTime: {
                    configurable: !0,
                    value: this.binds.setTime
                },
                setStartTime: {
                    configurable: !0,
                    value: this.binds.setStartTime
                },
                setEndTime: {
                    configurable: !0,
                    value: this.binds.setEndTime
                }
            }), this.rangePlugin = this.picker.PluginManager.getInstance("RangePlugin"), this.parseValues(), this.picker.on("view", this.binds.onView), this.picker.on("input", this.binds.onInput), this.picker.on("change", this.binds.onChange), this.picker.on("click", this.binds.onClick)
        }
        onDetach() {
            delete this.picker.setTime, delete this.picker.setStartTime, delete this.picker.setEndTime, Object.defineProperties(this.picker, {
                getDate: {
                    configurable: !0,
                    value: this.binds._getDate
                },
                getStartDate: {
                    configurable: !0,
                    value: this.binds._getStartDate
                },
                getEndDate: {
                    configurable: !0,
                    value: this.binds._getEndDate
                }
            }), this.picker.off("view", this.binds.onView), this.picker.off("input", this.binds.onInput), this.picker.off("change", this.binds.onChange), this.picker.off("click", this.binds.onClick)
        }
        onView(t) {
            const {
                view: e,
                target: i
            } = t.detail;
            if ("Main" === e) {
                this.rangePlugin = this.picker.PluginManager.getInstance("RangePlugin");
                const t = document.createElement("div");
                if (t.className = "time-plugin-container", this.rangePlugin) {
                    const e = this.getStartInput();
                    t.appendChild(e), this.picker.trigger("view", {
                        view: "TimePluginInput",
                        target: e
                    });
                    const i = this.getEndInput();
                    t.appendChild(i), this.picker.trigger("view", {
                        view: "TimePluginInput",
                        target: i
                    })
                } else {
                    const e = this.getSingleInput();
                    t.appendChild(e), this.picker.trigger("view", {
                        view: "TimePluginInput",
                        target: e
                    })
                }
                i.appendChild(t), this.picker.trigger("view", {
                    view: "TimePluginContainer",
                    target: t
                })
            }
        }
        onInput(t) {
            const i = t.target;
            if (i instanceof HTMLInputElement && i.classList.contains("time-plugin-input")) {
                const t = this.timePicked[i.name] || new e,
                    [n, s] = i.value.split(":");
                t.setHours(Number(n) || 0, Number(s) || 0, 0, 0), this.picker.options.autoApply ? (this.timePicked[i.name] = t, this.picker.updateValues()) : this.timePrePicked[i.name] = t
            }
        }
        onChange(t) {
            const i = t.target;
            if (i instanceof HTMLSelectElement && i.classList.contains("time-plugin-custom-input")) {
                const t = /(\w+)\[(\w+)\]/,
                    [, n, s] = i.name.match(t),
                    o = Number(i.value);
                let a = new e;
                switch (!this.picker.options.autoApply && this.timePrePicked[n] instanceof Date ? a = this.timePrePicked[n].clone() : this.timePicked[n] instanceof Date && (a = this.timePicked[n].clone()), s) {
                    case "HH":
                        if (this.options.format12) {
                            const t = i.closest(".time-plugin-custom-block").querySelector(`select[name="${n}[period]"]`).value,
                                e = this.handleFormat12(t, a, o);
                            a.setHours(e.getHours(), e.getMinutes(), e.getSeconds(), 0)
                        } else a.setHours(o, a.getMinutes(), a.getSeconds(), 0);
                        break;
                    case "mm":
                        a.setHours(a.getHours(), o, a.getSeconds(), 0);
                        break;
                    case "ss":
                        a.setHours(a.getHours(), a.getMinutes(), o, 0);
                        break;
                    case "period":
                        if (this.options.format12) {
                            const t = i.closest(".time-plugin-custom-block").querySelector(`select[name="${n}[HH]"]`).value,
                                e = this.handleFormat12(i.value, a, Number(t));
                            a.setHours(e.getHours(), e.getMinutes(), e.getSeconds(), 0)
                        }
                }
                if (this.picker.options.autoApply) this.timePicked[n] = a, this.picker.updateValues();
                else {
                    this.timePrePicked[n] = a;
                    const t = this.picker.ui.container.querySelector(".apply-button");
                    if (this.rangePlugin) {
                        const e = this.rangePlugin.options,
                            i = this.picker.datePicked,
                            n = e.strict && 2 === i.length || !e.strict && i.length > 0 || !i.length && e.strict && e.startDate instanceof Date && e.endDate instanceof Date || !i.length && !e.strict && (e.startDate instanceof Date || e.endDate instanceof Date);
                        t.disabled = !n
                    } else this.picker.datePicked.length && (t.disabled = !1)
                }
            }
        }
        onClick(t) {
            const e = t.target;
            if (e instanceof HTMLElement) {
                const t = e.closest(".unit");
                if (!(t instanceof HTMLElement)) return;
                this.picker.isApplyButton(t) && (Object.keys(this.timePicked).forEach((t => {
                    this.timePrePicked[t] instanceof Date && (this.timePicked[t] = this.timePrePicked[t].clone())
                })), this.picker.updateValues(), this.timePrePicked = {
                    input: null,
                    start: null,
                    end: null
                }), this.picker.isCancelButton(t) && (this.timePrePicked = {
                    input: null,
                    start: null,
                    end: null
                }, this.picker.renderAll())
            }
        }
        setTime(t) {
            const e = this.handleTimeString(t);
            this.timePicked.input = e.clone(), this.picker.renderAll(), this.picker.updateValues()
        }
        setStartTime(t) {
            const e = this.handleTimeString(t);
            this.timePicked.start = e.clone(), this.picker.renderAll(), this.picker.updateValues()
        }
        setEndTime(t) {
            const e = this.handleTimeString(t);
            this.timePicked.end = e.clone(), this.picker.renderAll(), this.picker.updateValues()
        }
        handleTimeString(t) {
            const i = new e,
                [n, s, o] = t.split(":").map((t => Number(t))),
                a = n && !Number.isNaN(n) ? n : 0,
                r = s && !Number.isNaN(s) ? s : 0,
                c = o && !Number.isNaN(o) ? o : 0;
            return i.setHours(a, r, c, 0), i
        }
        getDate() {
            if (this.picker.options.date instanceof Date) {
                const t = new e(this.picker.options.date, this.picker.options.format);
                if (this.timePicked.input instanceof Date) {
                    const e = this.timePicked.input;
                    t.setHours(e.getHours(), e.getMinutes(), e.getSeconds(), 0)
                }
                return t
            }
            return null
        }
        getStartDate() {
            if (this.rangePlugin.options.startDate instanceof Date) {
                const t = new e(this.rangePlugin.options.startDate, this.picker.options.format);
                if (this.timePicked.start instanceof Date) {
                    const e = this.timePicked.start;
                    t.setHours(e.getHours(), e.getMinutes(), e.getSeconds(), 0)
                }
                return t
            }
            return null
        }
        getEndDate() {
            if (this.rangePlugin.options.endDate instanceof Date) {
                const t = new e(this.rangePlugin.options.endDate, this.picker.options.format);
                if (this.timePicked.end instanceof Date) {
                    const e = this.timePicked.end;
                    t.setHours(e.getHours(), e.getMinutes(), e.getSeconds(), 0)
                }
                return t
            }
            return null
        }
        getSingleInput() {
            return this.options.native ? this.getNativeInput("input") : this.getCustomInput("input")
        }
        getStartInput() {
            return this.options.native ? this.getNativeInput("start") : this.getCustomInput("start")
        }
        getEndInput() {
            return this.options.native ? this.getNativeInput("end") : this.getCustomInput("end")
        }
        getNativeInput(t) {
            const e = document.createElement("input");
            e.type = "time", e.name = t, e.className = "time-plugin-input unit";
            const i = this.timePicked[t];
            if (i) {
                const t = `0${i.getHours()}`.slice(-2),
                    n = `0${i.getMinutes()}`.slice(-2);
                e.value = `${t}:${n}`
            }
            return e
        }
        getCustomInput(t) {
            const e = document.createElement("div");
            e.className = "time-plugin-custom-block";
            const i = document.createElement("select");
            i.className = "time-plugin-custom-input unit", i.name = `${t}[HH]`;
            const n = this.options.format12 ? 1 : 0,
                s = this.options.format12 ? 13 : 24;
            let o = null;
            !this.picker.options.autoApply && this.timePrePicked[t] instanceof Date ? o = this.timePrePicked[t].clone() : this.timePicked[t] instanceof Date && (o = this.timePicked[t].clone());
            for (let t = n; t < s; t += this.options.stepHours) {
                const e = document.createElement("option");
                e.value = String(t), e.text = String(t), o && (this.options.format12 ? (o.getHours() % 12 ? o.getHours() % 12 : 12) === t && (e.selected = !0) : o.getHours() === t && (e.selected = !0)), i.appendChild(e)
            }
            e.appendChild(i);
            const a = document.createElement("select");
            a.className = "time-plugin-custom-input unit", a.name = `${t}[mm]`;
            for (let t = 0; t < 60; t += this.options.stepMinutes) {
                const e = document.createElement("option");
                e.value = `0${String(t)}`.slice(-2), e.text = `0${String(t)}`.slice(-2), o && o.getMinutes() === t && (e.selected = !0), a.appendChild(e)
            }
            if (e.appendChild(a), this.options.seconds) {
                const i = document.createElement("select");
                i.className = "time-plugin-custom-input unit", i.name = `${t}[ss]`;
                const n = 60;
                for (let t = 0; t < n; t += this.options.stepSeconds) {
                    const e = document.createElement("option");
                    e.value = `0${String(t)}`.slice(-2), e.text = `0${String(t)}`.slice(-2), o && o.getSeconds() === t && (e.selected = !0), i.appendChild(e)
                }
                e.appendChild(i)
            }
            if (this.options.format12) {
                const i = document.createElement("select");
                i.className = "time-plugin-custom-input unit", i.name = `${t}[period]`, ["AM", "PM"].forEach((t => {
                    const e = document.createElement("option");
                    e.value = t, e.text = t, o && "PM" === t && o.getHours() >= 12 && (e.selected = !0), i.appendChild(e)
                })), e.appendChild(i)
            }
            return e
        }
        handleFormat12(t, e, i) {
            const n = e.clone();
            switch (t) {
                case "AM":
                    12 === i ? n.setHours(0, n.getMinutes(), n.getSeconds(), 0) : n.setHours(i, n.getMinutes(), n.getSeconds(), 0);
                    break;
                case "PM":
                    12 !== i ? n.setHours(i + 12, n.getMinutes(), n.getSeconds(), 0) : n.setHours(i, n.getMinutes(), n.getSeconds(), 0)
            }
            return n
        }
        parseValues() {
            if (this.rangePlugin) {
                if (this.rangePlugin.options.strict) {
                    if (this.rangePlugin.options.startDate && this.rangePlugin.options.endDate) {
                        const t = new e(this.rangePlugin.options.startDate, this.picker.options.format),
                            i = new e(this.rangePlugin.options.endDate, this.picker.options.format);
                        this.timePicked.start = t.clone(), this.timePicked.end = i.clone()
                    }
                } else {
                    if (this.rangePlugin.options.startDate) {
                        const t = new e(this.rangePlugin.options.startDate, this.picker.options.format);
                        this.timePicked.start = t.clone()
                    }
                    if (this.rangePlugin.options.endDate) {
                        const t = new e(this.rangePlugin.options.endDate, this.picker.options.format);
                        this.timePicked.end = t.clone()
                    }
                }
                if (this.rangePlugin.options.elementEnd)
                    if (this.rangePlugin.options.strict) {
                        if (this.picker.options.element instanceof HTMLInputElement && this.picker.options.element.value.length && this.rangePlugin.options.elementEnd instanceof HTMLInputElement && this.rangePlugin.options.elementEnd.value.length) {
                            const t = new e(this.picker.options.element.value, this.picker.options.format),
                                i = new e(this.rangePlugin.options.elementEnd.value, this.picker.options.format);
                            this.timePicked.start = t.clone(), this.timePicked.end = i.clone()
                        }
                    } else {
                        if (this.picker.options.element instanceof HTMLInputElement && this.picker.options.element.value.length) {
                            const t = new e(this.picker.options.element.value, this.picker.options.format);
                            this.timePicked.start = t.clone()
                        }
                        if (this.rangePlugin.options.elementEnd instanceof HTMLInputElement && this.rangePlugin.options.elementEnd.value.length) {
                            const t = new e(this.rangePlugin.options.elementEnd.value, this.picker.options.format);
                            this.timePicked.start = t.clone()
                        }
                    }
                else if (this.picker.options.element instanceof HTMLInputElement && this.picker.options.element.value.length) {
                    const [t, i] = this.picker.options.element.value.split(this.rangePlugin.options.delimiter);
                    if (this.rangePlugin.options.strict) {
                        if (t && i) {
                            const n = new e(t, this.picker.options.format),
                                s = new e(i, this.picker.options.format);
                            this.timePicked.start = n.clone(), this.timePicked.end = s.clone()
                        }
                    } else {
                        if (t) {
                            const i = new e(t, this.picker.options.format);
                            this.timePicked.start = i.clone()
                        }
                        if (i) {
                            const t = new e(i, this.picker.options.format);
                            this.timePicked.start = t.clone()
                        }
                    }
                }
            } else {
                if (this.picker.options.date) {
                    const t = new e(this.picker.options.date, this.picker.options.format);
                    this.timePicked.input = t.clone()
                }
                if (this.picker.options.element instanceof HTMLInputElement && this.picker.options.element.value.length) {
                    const t = new e(this.picker.options.element.value, this.picker.options.format);
                    this.timePicked.input = t.clone()
                }
            }
        }
    }, t.create = s, t.easepick = o, Object.defineProperty(t, "__esModule", {
        value: !0
    })
}));
export default easepick;
