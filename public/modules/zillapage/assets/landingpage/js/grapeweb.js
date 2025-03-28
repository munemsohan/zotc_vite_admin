/*! grapesjs-preset-webpage - 0.1.39 */
!(function (e, t) {
    "object" == typeof exports && "object" == typeof module
        ? (module.exports = t(require("grapesjs")))
        : "function" == typeof define && define.amd
        ? define(["grapesjs"], t)
        : "object" == typeof exports
        ? (exports["grapesjs-preset-webpage"] = t(require("grapesjs")))
        : (e["grapesjs-preset-webpage"] = t(e.grapesjs));
})("undefined" != typeof self ? self : this, function (e) {
    return (function (e) {
        function t(o) {
            if (n[o]) return n[o].exports;
            var a = (n[o] = { i: o, l: !1, exports: {} });
            return e[o].call(a.exports, a, a.exports, t), (a.l = !0), a.exports;
        }
        var n = {};
        return (
            (t.m = e),
            (t.c = n),
            (t.d = function (e, n, o) {
                t.o(e, n) ||
                    Object.defineProperty(e, n, {
                        configurable: !1,
                        enumerable: !0,
                        get: o,
                    });
            }),
            (t.n = function (e) {
                var n =
                    e && e.__esModule
                        ? function () {
                              return e.default;
                          }
                        : function () {
                              return e;
                          };
                return t.d(n, "a", n), n;
            }),
            (t.o = function (e, t) {
                return Object.prototype.hasOwnProperty.call(e, t);
            }),
            (t.p = ""),
            t((t.s = 1))
        );
    })([
        function (e, t, n) {
            "use strict";
            Object.defineProperty(t, "__esModule", { value: !0 });
            (t.cmdImport = "gjs-open-import-webpage"),
                (t.cmdDeviceDesktop = "set-device-desktop"),
                (t.cmdDeviceTablet = "set-device-tablet"),
                (t.cmdDeviceMobile = "set-device-mobile"),
                (t.cmdClear = "canvas-clear");
        },
        function (e, t, n) {
            "use strict";
            function o(e) {
                return e && e.__esModule ? e : { default: e };
            }
            Object.defineProperty(t, "__esModule", { value: !0 });
            var a = n(2),
                r = o(a),
                i = n(3),
                c = o(i),
                s = n(4),
                l = o(s),
                u = n(6),
                d = o(u),
                p = n(7),
                m = o(p),
                f = n(8),
                b = o(f),
                v = n(9),
                g = o(v);
            t.default = r.default.plugins.add(
                "gjs-preset-webpage",
                function (e) {
                    var t =
                            arguments.length > 1 && void 0 !== arguments[1]
                                ? arguments[1]
                                : {},
                        n = t,
                        o = {
                            blocks: [
                                "column1",
                                "column2",
                                "column3",
                                "column4-8",
                                "link-block",
                                "button-link-block",
                                "icon-block",
                                "quote",
                                "section-basic",
                                "text-basic",
                                "image",
                                "video",
                            ],
                            modalImportTitle: "Import",
                            modalImportButton: "Import",
                            modalImportLabel: "",
                            modalImportContent: "",
                            importViewerOptions: {},
                            textCleanCanvas:
                                "Are you sure to clean the canvas?",
                            showStylesOnChange: 1,
                            textBackground: "Background",
                            textBorderAndShadow: "Border & Shadow",
                            textGeneral: "General",
                            textLayout: "Layout",
                            textTypography: "Typography",
                            textDecorations: "Decorations",
                            textExtra: "Extra",
                            customStyleManager: [],
                            countdownOpts: {},
                            formsOpts: {},
                        };
                    for (var a in o) a in n || (n[a] = o[a]);
                    var r = n.formsOpts;
                    r && (0, c.default)(e, r),
                        (0, d.default)(e, n),
                        (0, m.default)(e, n),
                        (0, l.default)(e, n),
                        (0, b.default)(e, n),
                        (0, g.default)(e, n);
                }
            );
        },
        function (t, n) {
            t.exports = e;
        },
        function (e, t, n) {
            /*! grapesjs-plugin-forms - 2.0.1 */
            !(function (t, n) {
                e.exports = n();
            })(window, function () {
                return (function (e) {
                    function t(o) {
                        if (n[o]) return n[o].exports;
                        var a = (n[o] = { i: o, l: !1, exports: {} });
                        return (
                            e[o].call(a.exports, a, a.exports, t),
                            (a.l = !0),
                            a.exports
                        );
                    }
                    var n = {};
                    return (
                        (t.m = e),
                        (t.c = n),
                        (t.d = function (e, n, o) {
                            t.o(e, n) ||
                                Object.defineProperty(e, n, {
                                    enumerable: !0,
                                    get: o,
                                });
                        }),
                        (t.r = function (e) {
                            "undefined" != typeof Symbol &&
                                Symbol.toStringTag &&
                                Object.defineProperty(e, Symbol.toStringTag, {
                                    value: "Module",
                                }),
                                Object.defineProperty(e, "__esModule", {
                                    value: !0,
                                });
                        }),
                        (t.t = function (e, n) {
                            if ((1 & n && (e = t(e)), 8 & n)) return e;
                            if (
                                4 & n &&
                                "object" == typeof e &&
                                e &&
                                e.__esModule
                            )
                                return e;
                            var o = Object.create(null);
                            if (
                                (t.r(o),
                                Object.defineProperty(o, "default", {
                                    enumerable: !0,
                                    value: e,
                                }),
                                2 & n && "string" != typeof e)
                            )
                                for (var a in e)
                                    t.d(
                                        o,
                                        a,
                                        function (t) {
                                            return e[t];
                                        }.bind(null, a)
                                    );
                            return o;
                        }),
                        (t.n = function (e) {
                            var n =
                                e && e.__esModule
                                    ? function () {
                                          return e.default;
                                      }
                                    : function () {
                                          return e;
                                      };
                            return t.d(n, "a", n), n;
                        }),
                        (t.o = function (e, t) {
                            return Object.prototype.hasOwnProperty.call(e, t);
                        }),
                        (t.p = ""),
                        t((t.s = 1))
                    );
                })([
                    function (e, t) {
                        e.exports = function (e, t, n) {
                            return (
                                t in e
                                    ? Object.defineProperty(e, t, {
                                          value: n,
                                          enumerable: !0,
                                          configurable: !0,
                                          writable: !0,
                                      })
                                    : (e[t] = n),
                                e
                            );
                        };
                    },
                    function (e, t, n) {
                        "use strict";
                        function o(e, t) {
                            var n = Object.keys(e);
                            if (Object.getOwnPropertySymbols) {
                                var o = Object.getOwnPropertySymbols(e);
                                t &&
                                    (o = o.filter(function (t) {
                                        return Object.getOwnPropertyDescriptor(
                                            e,
                                            t
                                        ).enumerable;
                                    })),
                                    n.push.apply(n, o);
                            }
                            return n;
                        }
                        function a(e) {
                            for (var t = 1; t < arguments.length; t++) {
                                var n =
                                    null != arguments[t] ? arguments[t] : {};
                                t % 2
                                    ? o(Object(n), !0).forEach(function (t) {
                                          s()(e, t, n[t]);
                                      })
                                    : Object.getOwnPropertyDescriptors
                                    ? Object.defineProperties(
                                          e,
                                          Object.getOwnPropertyDescriptors(n)
                                      )
                                    : o(Object(n)).forEach(function (t) {
                                          Object.defineProperty(
                                              e,
                                              t,
                                              Object.getOwnPropertyDescriptor(
                                                  n,
                                                  t
                                              )
                                          );
                                      });
                            }
                            return e;
                        }
                        function r(e, t) {
                            var n = Object.keys(e);
                            if (Object.getOwnPropertySymbols) {
                                var o = Object.getOwnPropertySymbols(e);
                                t &&
                                    (o = o.filter(function (t) {
                                        return Object.getOwnPropertyDescriptor(
                                            e,
                                            t
                                        ).enumerable;
                                    })),
                                    n.push.apply(n, o);
                            }
                            return n;
                        }
                        function i(e) {
                            for (var t = 1; t < arguments.length; t++) {
                                var n =
                                    null != arguments[t] ? arguments[t] : {};
                                t % 2
                                    ? r(Object(n), !0).forEach(function (t) {
                                          s()(e, t, n[t]);
                                      })
                                    : Object.getOwnPropertyDescriptors
                                    ? Object.defineProperties(
                                          e,
                                          Object.getOwnPropertyDescriptors(n)
                                      )
                                    : r(Object(n)).forEach(function (t) {
                                          Object.defineProperty(
                                              e,
                                              t,
                                              Object.getOwnPropertyDescriptor(
                                                  n,
                                                  t
                                              )
                                          );
                                      });
                            }
                            return e;
                        }
                        n.r(t);
                        var c = n(0),
                            s = n.n(c),
                            l = "form",
                            u = "input",
                            d = "textarea",
                            p = "select",
                            m = "checkbox",
                            f = "radio",
                            b = "button",
                            v = "label",
                            g = "option",
                            h = function (e) {
                                var t = e.DomComponents,
                                    n = { name: "id" },
                                    o = { name: "for" },
                                    a = { name: "name" },
                                    r = { name: "placeholder" },
                                    i = { name: "value" },
                                    c = { type: "checkbox", name: "required" },
                                    s = { type: "checkbox", name: "checked" };
                                t.addType(l, {
                                    isComponent: function (e) {
                                        return "FORM" == e.tagName;
                                    },
                                    model: {
                                        defaults: {
                                            tagName: "form",
                                            droppable: ":not(form)",
                                            draggable: ":not(form)",
                                            attributes: { method: "get" },
                                            traits: [
                                                {
                                                    type: "select",
                                                    name: "method",
                                                    options: [
                                                        {
                                                            value: "get",
                                                            name: "GET",
                                                        },
                                                        {
                                                            value: "post",
                                                            name: "POST",
                                                        },
                                                    ],
                                                },
                                                { name: "action" },
                                            ],
                                        },
                                    },
                                    view: {
                                        events: {
                                            submit: function (e) {
                                                return e.preventDefault();
                                            },
                                        },
                                    },
                                }),
                                    t.addType(u, {
                                        isComponent: function (e) {
                                            return "INPUT" == e.tagName;
                                        },
                                        model: {
                                            defaults: {
                                                tagName: "input",
                                                draggable: "form, form *",
                                                droppable: !1,
                                                highlightable: !1,
                                                attributes: { type: "text" },
                                                traits: [
                                                    a,
                                                    r,
                                                    {
                                                        type: "select",
                                                        name: "type",
                                                        options: [
                                                            { value: "text" },
                                                            { value: "email" },
                                                            {
                                                                value: "password",
                                                            },
                                                            { value: "number" },
                                                        ],
                                                    },
                                                    c,
                                                ],
                                            },
                                        },
                                        extendFnView: ["updateAttributes"],
                                        view: {
                                            updateAttributes: function () {
                                                this.el.setAttribute(
                                                    "autocomplete",
                                                    "off"
                                                );
                                            },
                                        },
                                    }),
                                    t.addType(d, {
                                        extend: u,
                                        isComponent: function (e) {
                                            return "TEXTAREA" == e.tagName;
                                        },
                                        model: {
                                            defaults: {
                                                tagName: "textarea",
                                                attributes: {},
                                                traits: [a, r, c],
                                            },
                                        },
                                    }),
                                    t.addType(g, {
                                        isComponent: function (e) {
                                            return "OPTION" == e.tagName;
                                        },
                                        model: {
                                            defaults: {
                                                tagName: "option",
                                                layerable: !1,
                                                droppable: !1,
                                                draggable: !1,
                                                highlightable: !1,
                                            },
                                        },
                                    });
                                var h = function (e, t) {
                                    return {
                                        type: g,
                                        components: t,
                                        attributes: { value: e },
                                    };
                                };
                                t.addType(p, {
                                    extend: u,
                                    isComponent: function (e) {
                                        return "SELECT" == e.tagName;
                                    },
                                    model: {
                                        defaults: {
                                            tagName: "select",
                                            components: [
                                                h("opt1", "Option 1"),
                                                h("opt2", "Option 2"),
                                            ],
                                            traits: [
                                                a,
                                                {
                                                    name: "options",
                                                    type: "select-options",
                                                },
                                                c,
                                            ],
                                        },
                                    },
                                    view: {
                                        events: {
                                            mousedown: function (e) {
                                                return e.preventDefault();
                                            },
                                        },
                                    },
                                }),
                                    t.addType(m, {
                                        extend: u,
                                        isComponent: function (e) {
                                            return (
                                                "INPUT" == e.tagName &&
                                                "checkbox" == e.type
                                            );
                                        },
                                        model: {
                                            defaults: {
                                                copyable: !1,
                                                attributes: {
                                                    type: "checkbox",
                                                },
                                                traits: [n, a, i, c, s],
                                            },
                                        },
                                        view: {
                                            events: {
                                                click: function (e) {
                                                    return e.preventDefault();
                                                },
                                            },
                                            init: function () {
                                                this.listenTo(
                                                    this.model,
                                                    "change:attributes:checked",
                                                    this.handleChecked
                                                );
                                            },
                                            handleChecked: function () {
                                                this.el.checked =
                                                    !!this.model.get(
                                                        "attributes"
                                                    ).checked;
                                            },
                                        },
                                    }),
                                    t.addType(f, {
                                        extend: m,
                                        isComponent: function (e) {
                                            return (
                                                "INPUT" == e.tagName &&
                                                "radio" == e.type
                                            );
                                        },
                                        model: {
                                            defaults: {
                                                attributes: { type: "radio" },
                                            },
                                        },
                                    }),
                                    t.addType(b, {
                                        extend: u,
                                        isComponent: function (e) {
                                            return "BUTTON" == e.tagName;
                                        },
                                        model: {
                                            defaults: {
                                                tagName: "button",
                                                attributes: { type: "button" },
                                                text: "Send",
                                                traits: [
                                                    {
                                                        name: "text",
                                                        changeProp: !0,
                                                    },
                                                    {
                                                        type: "select",
                                                        name: "type",
                                                        options: [
                                                            { value: "button" },
                                                            { value: "submit" },
                                                            { value: "reset" },
                                                        ],
                                                    },
                                                ],
                                            },
                                            init: function () {
                                                var e = this.components(),
                                                    t =
                                                        1 === e.length &&
                                                        e.models[0],
                                                    n =
                                                        (t &&
                                                            t.is("textnode") &&
                                                            t.get("content")) ||
                                                        "",
                                                    o = n || this.get("text");
                                                this.set({ text: o }),
                                                    this.on(
                                                        "change:text",
                                                        this.__onTextChange
                                                    ),
                                                    o !== n &&
                                                        this.__onTextChange();
                                            },
                                            __onTextChange: function () {
                                                this.components(
                                                    this.get("text")
                                                );
                                            },
                                        },
                                        view: {
                                            events: {
                                                click: function (e) {
                                                    return e.preventDefault();
                                                },
                                            },
                                        },
                                    }),
                                    t.addType(v, {
                                        extend: "text",
                                        isComponent: function (e) {
                                            return "LABEL" == e.tagName;
                                        },
                                        model: {
                                            defaults: {
                                                tagName: "label",
                                                components: "Label",
                                                traits: [o],
                                            },
                                        },
                                    });
                            },
                            y = function (e) {
                                e.TraitManager.addType("select-options", {
                                    events: { keyup: "onChange" },
                                    onValueChange: function () {
                                        for (
                                            var e = this.model,
                                                t = this.target,
                                                n = e
                                                    .get("value")
                                                    .trim()
                                                    .split("\n"),
                                                o = [],
                                                a = 0;
                                            a < n.length;
                                            a++
                                        ) {
                                            var r = n[a].split("::");
                                            o.push({
                                                type: g,
                                                components: r[1] || r[0],
                                                attributes: { value: r[0] },
                                            });
                                        }
                                        t.components().reset(o),
                                            t.view.render();
                                    },
                                    getInputEl: function () {
                                        if (!this.$input) {
                                            for (
                                                var e = [],
                                                    t =
                                                        this.target.components(),
                                                    n = 0;
                                                n < t.length;
                                                n++
                                            ) {
                                                var o = t.models[n],
                                                    a =
                                                        o.get("attributes")
                                                            .value || "",
                                                    r =
                                                        o.components()
                                                            .models[0],
                                                    i =
                                                        (r &&
                                                            r.get("content")) ||
                                                        "";
                                                e.push(
                                                    "".concat(a, "::").concat(i)
                                                );
                                            }
                                            (this.$input =
                                                document.createElement(
                                                    "textarea"
                                                )),
                                                (this.$input.value =
                                                    e.join("\n"));
                                        }
                                        return this.$input;
                                    },
                                });
                            },
                            w = function (e) {
                                var t =
                                        arguments.length > 1 &&
                                        void 0 !== arguments[1]
                                            ? arguments[1]
                                            : {},
                                    n = t,
                                    o = e.BlockManager,
                                    r = function (e, t) {
                                        n.blocks.indexOf(e) >= 0 &&
                                            o.add(
                                                e,
                                                a(
                                                    a({}, t),
                                                    {},
                                                    {
                                                        category: {
                                                            id: "forms",
                                                            label: "Forms",
                                                        },
                                                    }
                                                )
                                            );
                                    };
                                r(l, {
                                    label: "Form",
                                    media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 5.5c0-.3-.5-.5-1.3-.5H3.4c-.8 0-1.3.2-1.3.5v3c0 .3.5.5 1.3.5h17.4c.8 0 1.3-.2 1.3-.5v-3zM21 8H3V6h18v2zM22 10.5c0-.3-.5-.5-1.3-.5H3.4c-.8 0-1.3.2-1.3.5v3c0 .3.5.5 1.3.5h17.4c.8 0 1.3-.2 1.3-.5v-3zM21 13H3v-2h18v2z"/><rect width="10" height="3" x="2" y="15" rx=".5"/></svg>',
                                    content: {
                                        type: l,
                                        components: [
                                            {
                                                components: [
                                                    {
                                                        type: v,
                                                        components: "Name",
                                                    },
                                                    { type: u },
                                                ],
                                            },
                                            {
                                                components: [
                                                    {
                                                        type: v,
                                                        components: "Email",
                                                    },
                                                    {
                                                        type: u,
                                                        attributes: {
                                                            type: "email",
                                                        },
                                                    },
                                                ],
                                            },
                                            {
                                                components: [
                                                    {
                                                        type: v,
                                                        components: "Gender",
                                                    },
                                                    {
                                                        type: m,
                                                        attributes: {
                                                            value: "M",
                                                        },
                                                    },
                                                    {
                                                        type: v,
                                                        components: "M",
                                                    },
                                                    {
                                                        type: m,
                                                        attributes: {
                                                            value: "F",
                                                        },
                                                    },
                                                    {
                                                        type: v,
                                                        components: "F",
                                                    },
                                                ],
                                            },
                                            {
                                                components: [
                                                    {
                                                        type: v,
                                                        components: "Message",
                                                    },
                                                    { type: d },
                                                ],
                                            },
                                            { components: [{ type: b }] },
                                        ],
                                    },
                                }),
                                    r(u, {
                                        label: "Input",
                                        media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 9c0-.6-.5-1-1.3-1H3.4C2.5 8 2 8.4 2 9v6c0 .6.5 1 1.3 1h17.4c.8 0 1.3-.4 1.3-1V9zm-1 6H3V9h18v6z"/><path d="M4 10h1v4H4z"/></svg>',
                                        content: { type: u },
                                    }),
                                    r(d, {
                                        label: "Textarea",
                                        media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 7.5c0-.9-.5-1.5-1.3-1.5H3.4C2.5 6 2 6.6 2 7.5v9c0 .9.5 1.5 1.3 1.5h17.4c.8 0 1.3-.6 1.3-1.5v-9zM21 17H3V7h18v10z"/><path d="M4 8h1v4H4zM19 7h1v10h-1zM20 8h1v1h-1zM20 15h1v1h-1z"/></svg>',
                                        content: { type: d },
                                    }),
                                    r(p, {
                                        label: "Select",
                                        media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 9c0-.6-.5-1-1.3-1H3.4C2.5 8 2 8.4 2 9v6c0 .6.5 1 1.3 1h17.4c.8 0 1.3-.4 1.3-1V9zm-1 6H3V9h18v6z"/><path d="M18.5 13l1.5-2h-3zM4 11.5h11v1H4z"/></svg>',
                                        content: { type: p },
                                    }),
                                    r(b, {
                                        label: "Button",
                                        media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 9c0-.6-.5-1-1.3-1H3.4C2.5 8 2 8.4 2 9v6c0 .6.5 1 1.3 1h17.4c.8 0 1.3-.4 1.3-1V9zm-1 6H3V9h18v6z"/><path d="M4 11.5h16v1H4z"/></svg>',
                                        content: { type: b },
                                    }),
                                    r(v, {
                                        label: "Label",
                                        media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.9c0-.6-.5-.9-1.3-.9H3.4c-.8 0-1.3.3-1.3.9V17c0 .5.5.9 1.3.9h17.4c.8 0 1.3-.4 1.3-.9V12zM21 17H3v-5h18v5z"/><rect width="14" height="5" x="2" y="5" rx=".5"/><path d="M4 13h1v3H4z"/></svg>',
                                        content: { type: v },
                                    }),
                                    r(m, {
                                        label: "Checkbox",
                                        media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 17l-5-5 1.41-1.42L10 14.17l7.59-7.59L19 8m0-5H5c-1.11 0-2 .89-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5a2 2 0 0 0-2-2z"></path></svg>',
                                        content: { type: m },
                                    }),
                                    r(f, {
                                        label: "Radio",
                                        media: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8m0-18C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2m0 5c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5z"></path></svg>',
                                        content: { type: f },
                                    });
                            };
                        t.default = function (e) {
                            var t =
                                    arguments.length > 1 &&
                                    void 0 !== arguments[1]
                                        ? arguments[1]
                                        : {},
                                n = i(
                                    {
                                        blocks: [
                                            "form",
                                            "input",
                                            "textarea",
                                            "select",
                                            "button",
                                            "label",
                                            "checkbox",
                                            "radio",
                                        ],
                                    },
                                    t
                                );
                            h(e), y(e), w(e, n);
                        };
                    },
                ]);
            });
        },
        function (e, t, n) {
            "use strict";
            Object.defineProperty(t, "__esModule", { value: !0 });
            var o = n(5),
                a = (function (e) {
                    return e && e.__esModule ? e : { default: e };
                })(o),
                r = n(0);
            t.default = function (e, t) {
                var n = e.Commands,
                    o = t.textCleanCanvas;
                n.add(r.cmdImport, (0, a.default)(e, t)),
                    n.add(r.cmdDeviceDesktop, function (e) {
                        return e.setDevice("Desktop");
                    }),
                    n.add(r.cmdDeviceTablet, function (e) {
                        return e.setDevice("Tablet");
                    }),
                    n.add(r.cmdDeviceMobile, function (e) {
                        return e.setDevice("Mobile portrait");
                    }),
                    n.add(r.cmdClear, function (e) {
                        return confirm(o) && e.runCommand("core:canvas-clear");
                    });
            };
        },
        function (e, t, n) {
            "use strict";
            Object.defineProperty(t, "__esModule", { value: !0 });
            var o =
                Object.assign ||
                function (e) {
                    for (var t = 1; t < arguments.length; t++) {
                        var n = arguments[t];
                        for (var o in n)
                            Object.prototype.hasOwnProperty.call(n, o) &&
                                (e[o] = n[o]);
                    }
                    return e;
                };
            t.default = function (e, t) {
                var n = e.getConfig("stylePrefix"),
                    a = e.Modal,
                    r = e.CodeManager.getViewer("CodeMirror").clone(),
                    i = document.createElement("div"),
                    c = t.modalImportLabel,
                    s = t.modalImportContent,
                    l = r.editor,
                    u = document.createElement("button");
                return (
                    (u.type = "button"),
                    (u.innerHTML = t.modalImportButton),
                    (u.className = n + "btn-prim " + n + "btn-import"),
                    (u.onclick = function (t) {
                        e.setComponents(l.getValue().trim()), a.close();
                    }),
                    r.set(
                        o(
                            {
                                codeName: "htmlmixed",
                                theme: "hopscotch",
                                readOnly: 0,
                            },
                            t.importViewerOptions
                        )
                    ),
                    {
                        run: function (e) {
                            var o = this;
                            if (!l) {
                                var d = document.createElement("textarea");
                                if (c) {
                                    var p = document.createElement("div");
                                    (p.className = n + "import-label"),
                                        (p.innerHTML = c),
                                        i.appendChild(p);
                                }
                                i.appendChild(d),
                                    i.appendChild(u),
                                    r.init(d),
                                    (l = r.editor);
                            }
                            a.setTitle(t.modalImportTitle), a.setContent(i);
                            var m = "function" == typeof s ? s(e) : s;
                            r.setContent(m || ""),
                                a
                                    .open()
                                    .getModel()
                                    .once("change:open", function () {
                                        return e.stopCommand(o.id);
                                    }),
                                l.refresh();
                        },
                        stop: function () {
                            a.close();
                        },
                    }
                );
            };
        },
        function (e, t, n) {
            "use strict";
            Object.defineProperty(t, "__esModule", { value: !0 }),
                (t.default = function (e, t) {
                    var n = e.BlockManager,
                        o = function (e) {
                            return t.blocks.indexOf(e) >= 0;
                        };
                    n.remove("form"),
                        n.remove("input"),
                        n.remove("textarea"),
                        n.remove("select"),
                        n.remove("button"),
                        n.remove("label"),
                        n.remove("checkbox"),
                        n.remove("radio"),
                        o("column1") &&
                            n.add("column1", {
                                category: "Basic",
                                label: "1 Column",
                                attributes: { class: "gjs-fonts gjs-f-b1" },
                                content:
                                    '<div class="row lfg-block-row">\n                                <div class="col-md-12 lfg-block-col">\n                                    <h4>1 column</h4>\n                                </div>\n                              </div>',
                            }),
                        o("column2") &&
                            n.add("column2", {
                                category: "Basic",
                                label: "2 Columns",
                                attributes: { class: "gjs-fonts gjs-f-b2" },
                                content:
                                    '<div class="row lfg-block-row">\n                                <div class="col-md-6 lfg-block-col">\n                                    <h4>1 column</h4>\n                                </div>\n                                <div class="col-md-6 lfg-block-col">\n                                    <h4>2 column</h4>\n                                </div>\n                              </div>',
                            }),
                        o("column3") &&
                            n.add("column3", {
                                category: "Basic",
                                label: "3 Columns",
                                attributes: { class: "gjs-fonts gjs-f-b3" },
                                content:
                                    '<div class="row lfg-block-row">\n                                <div class="col-md-4 lfg-block-col">\n                                    <h4>1 column</h4>\n                                </div>\n                                <div class="col-md-4 lfg-block-col">\n                                    <h4>2 column</h4>\n                                </div>\n                                <div class="col-md-4 lfg-block-col">\n                                    <h4>3 column</h4>\n                                </div>\n                              </div>',
                            }),
                        o("column4-8") &&
                            n.add("column4-8", {
                                category: "Basic",
                                label: "2 Columns 4/8",
                                attributes: { class: "gjs-fonts gjs-f-b37" },
                                content:
                                    '<div class="row lfg-block-row">\n                                <div class="col-md-4 lfg-block-col">\n                                    <h4>4 column</h4>\n                                </div>\n                                <div class="col-md-8 lfg-block-col">\n                                    <h4>8 column</h4>\n                                </div>\n                              </div>',
                            }),
                        o("section-basic") &&
                            n.add("section-basic", {
                                category: "Basic",
                                label: "Section",
                                attributes: { class: "fas fa-box" },
                                content:
                                    '<section style="height: 200px"></section>',
                            }),
                        o("text-basic") &&
                            n.add("text-basic", {
                                category: "Basic",
                                label: "Text section",
                                attributes: { class: "fas fa-align-justify" },
                                content:
                                    "<section>\n      <h1>Insert title here</h1>\n      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>\n      </section>",
                            }),
                        o("image") &&
                            n.add("image", {
                                category: "Basic",
                                label: "Image",
                                attributes: { class: "fas fa-image" },
                                content: {
                                    style: { color: "black" },
                                    type: "image",
                                    classes: ["img-fluid"],
                                },
                            }),
                        o("video") &&
                            n.add("video", {
                                category: "Basic",
                                label: "Video",
                                attributes: { class: "fas fa-video" },
                                content: {
                                    type: "video",
                                    provider: "vi",
                                    src: "475378445",
                                    style: { height: "350px", width: "615px" },
                                },
                            }),
                        o("button-link-block") &&
                            n.add("button-link-block", {
                                category: "Basic",
                                label: "Button Link",
                                attributes: {
                                    class: "fas fa-external-link-square-alt",
                                },
                                content: {
                                    type: "link",
                                    classes: ["btn", "btn-primary", "btn-lg"],
                                    content: "Button Link",
                                },
                            }),
                        o("link-block") &&
                            n.add("link-block", {
                                category: "Basic",
                                label: "Link Block",
                                attributes: { class: "fas fa-link" },
                                content: {
                                    type: "link",
                                    content: "Insert your link here",
                                    style: { color: "#3B97E3" },
                                },
                            }),
                        o("icon-block") &&
                            n.add("icon-block", {
                                category: "Basic",
                                label: "Icon",
                                attributes: { class: "fas fa-icons" },
                                content:
                                    '<div class="i-size-6x"> <i class="fas fa-coffee"></i></div>',
                            }),
                        window.exits_ecommerce &&
                            1 == exits_ecommerce &&
                            (n.add("block-paypalbtn", {
                                category: "Basic",
                                label: "PayPal",
                                attributes: { class: "fab fa-paypal fa-lg" },
                                content: { type: "paypal-button" },
                            }),
                            n.add("block-stripebtn", {
                                category: "Basic",
                                label: "Stripe",
                                attributes: { class: "fab fa-stripe fa-lg" },
                                content: { type: "stripe-button" },
                            })),
                        n.add("block-form-default", {
                            category: "Basic",
                            label: "Forms",
                            attributes: { class: "fas fa-align-left" },
                            content:
                                '\n            <div class="block-form-default">\n              <h3>FILL OUT THE FORM</h3>\n              <form class="registration-form">\n                <div class="form-group">\n                  <label class="sr-only" for="name">First name</label>\n                  <input type="text" name="name" required="" placeholder="Enter Your Name..." class="form-control">\n                </div>\n                <div class="form-group">\n                  <label class="sr-only" for="email">Email</label>\n                  <input type="text" name="email" required="" placeholder="Enter Your Email..." class="form-control">\n                </div>\n                <div class="form-group">\n                  <label class="sr-only" for="phone">Service</label>\n                  <select class="form-control" name="service" required="">\n                    <option value="">Select service</option>\n                    <option value="service A">service A</option>\n                    <option value="service B">service B</option>\n                    <option value="service C">service C</option>\n                  </select>\n                </div>\n                <div class="form-group">\n                    <label class="sr-only" for="message">Message</label>\n                    <textarea class="form-control" name="message" placeholder="Enter Your Message..." required="" row="3"></textarea>\n                  </div>\n                <button type="submit" class="btn btn-danger btn-round  btn-lg">Get it Now</button>\n              </form>\n            </div>',
                        }),
                        n.add("block-countdown1", {
                            category: "Basic",
                            label: "Countdown 1",
                            attributes: { class: "fa fa-hourglass" },
                            content: `
                                <section id="countdown" style="text-align: center; padding: 20px; font-family: Arial, sans-serif;">
                                    <div style="width: 100%; padding: 10px 5px;">
                                        <div
                                            style="display: flex; justify-content: center; gap: 5px; flex-wrap: wrap; max-width: 320px; margin: 0 auto;">
                                            <div
                                                style="background: #fff; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 6px 8px; min-width: 65px; text-align: center; border: 1px solid #e0e0e0;">
                                                <span id="days"
                                                    style="display: block; font-size: 1.4rem; font-weight: bold; color: #333;">00</span>
                                                <small style="font-size: 0.8rem; color: #666;">Days</small>
                                            </div>
                                            <div
                                                style="background: #fff; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 6px 8px; min-width: 65px; text-align: center; border: 1px solid #e0e0e0;">
                                                <span id="hours"
                                                    style="display: block; font-size: 1.4rem; font-weight: bold; color: #333;">00</span>
                                                <small style="font-size: 0.8rem; color: #666;">Hours</small>
                                            </div>
                                            <div
                                                style="background: #fff; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 6px 8px; min-width: 65px; text-align: center; border: 1px solid #e0e0e0;">
                                                <span id="minutes"
                                                    style="display: block; font-size: 1.4rem; font-weight: bold; color: #333;">00</span>
                                                <small style="font-size: 0.8rem; color: #666;">Mins</small>
                                            </div>
                                            <div
                                                style="background: #fff; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 6px 8px; min-width: 65px; text-align: center; border: 1px solid #e0e0e0;">
                                                <span id="seconds"
                                                    style="display: block; font-size: 1.4rem; font-weight: bold; color: #333;">00</span>
                                                <small style="font-size: 0.8rem; color: #666;">Secs</small>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            `,
                        }),
                        n.add("block-countdown2", {
                            category: "Basic",
                            label: "Countdown 2",
                            attributes: { class: "fa fa-hourglass" },
                            content: `
                                <section id="countdown" style="text-align: center; padding: 20px;">
                                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
                                        <div style="border: 2px solid black; padding: 10px; text-align: center; min-width: 70px; flex: 1 1 60px; max-width: 100px; margin-bottom: 5px;">
                                            <span id="days" style="font-size: clamp(36px, 6vw, 40px); font-weight: bold;">00</span>
                                            <div style="font-size: clamp(12px, 3vw, 14px);">Days</div>
                                        </div>
                                        <div style="border: 2px solid black; padding: 10px; text-align: center; min-width: 70px; flex: 1 1 60px; max-width: 100px; margin-bottom: 5px;">
                                            <span id="hours" style="font-size: clamp(36px, 6vw, 40px); font-weight: bold;">00</span>
                                            <div style="font-size: clamp(12px, 3vw, 14px);">Hours</div>
                                        </div>
                                        <div style="border: 2px solid black; padding: 10px; text-align: center; min-width: 70px; flex: 1 1 60px; max-width: 100px; margin-bottom: 5px;">
                                            <span id="minutes" style="font-size: clamp(36px, 6vw, 40px); font-weight: bold;">00</span>
                                            <div style="font-size: clamp(12px, 3vw, 14px);">Minutes</div>
                                        </div>
                                        <div style="border: 2px solid black; padding: 10px; text-align: center; min-width: 70px; flex: 1 1 60px; max-width: 100px; margin-bottom: 5px;">
                                            <span id="seconds" style="font-size: clamp(36px, 6vw, 40px); font-weight: bold;">00</span>
                                            <div style="font-size: clamp(12px, 3vw, 14px);">Seconds</div>
                                        </div>
                                    </div>
                                </section>
                            `,
                        }),
                        n.add("block-form-product", {
                            category: "Basic",
                            label: "Products Form",
                            attributes: { class: "fas fa-shopping-cart" },
                            content: `
                                <div class="container">
                                    <div id="placeAnOrder">
                                        <center style="margin-bottom: 30px; border: 1px dotted"><h1><b>Product Order Section Goes Here<b></h1></center>
                                    </div>
                                </div>
                            `,
                        }),
                        o("quote") &&
                            n.add("quote", {
                                label: "Quote",
                                category: "Basic",
                                attributes: { class: "fa fa-quote-left" },
                                content:
                                    '<blockquote class="quote">\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit\n      </blockquote>',
                            });
                });
        },
        function (e, t, n) {
            "use strict";
            Object.defineProperty(t, "__esModule", { value: !0 }),
                (t.default = function (e) {
                    var t =
                            (arguments.length > 1 &&
                                void 0 !== arguments[1] &&
                                arguments[1],
                            e.DomComponents),
                        n = t.getType("default"),
                        o = (n.model, n.view, t.getType("image").model);
                    t.addType("image", {
                        model: {
                            initToolbar: function () {
                                o.prototype.initToolbar.apply(this, arguments);
                                var e = this.get("toolbar");
                                e.some(function (e) {
                                    return "open-assets" === e.command;
                                }) ||
                                    (e.unshift({
                                        command: function (e) {
                                            return e.runCommand("open-assets", {
                                                target: e.getSelected(),
                                            });
                                        },
                                        label: '<i class="fas fa-images"></i>',
                                    }),
                                    this.set("toolbar", e));
                            },
                        },
                    }),
                        e.AssetManager.addType("image", {
                            view: {
                                onRemove: function (e) {
                                    e.stopPropagation();
                                    var t = this.model;
                                    confirm("Are you sure?") &&
                                        t.collection.remove(t);
                                },
                            },
                        });
                    var a = function () {
                        var e = [];
                        if (window.url_get_products) {
                            var t = url_get_products,
                                n = new XMLHttpRequest();
                            n.open("GET", t, !1),
                                n.send(null),
                                200 == n.status && (e = JSON.parse(n.response));
                        }
                        return e;
                    };
                    e.Components.addType("paypal-button", {
                        model: {
                            defaults: {
                                tagName: "button",
                                attributes: {
                                    class: "builder-paypal-button",
                                    type: "button",
                                },
                                productid: "",
                                traits: [
                                    {
                                        type: "select",
                                        name: "productid",
                                        label: "Select a Product",
                                        changeProp: !0,
                                        options: a(),
                                    },
                                ],
                                "script-props": ["productid"],
                            },
                        },
                    }),
                        e.Components.addType("stripe-button", {
                            model: {
                                defaults: {
                                    tagName: "button",
                                    attributes: {
                                        class: "builder-stripe-button",
                                        type: "button",
                                    },
                                    productid: "",
                                    traits: [
                                        {
                                            type: "select",
                                            name: "productid",
                                            label: "Select a Product",
                                            changeProp: !0,
                                            options: a(),
                                        },
                                    ],
                                    "script-props": ["productid"],
                                },
                            },
                        });
                });
        },
        function (e, t, n) {
            "use strict";
            Object.defineProperty(t, "__esModule", { value: !0 });
            var o = n(0);
            t.default = function (e, t) {
                var n = e.Panels,
                    a = e.getConfig(),
                    r = "sw-visibility",
                    i = "open-sm",
                    c = "open-layers",
                    s = "open-blocks",
                    l = "fullscreen",
                    u = "preview";
                (a.showDevices = 0),
                    n.getPanels().reset([
                        { id: "commands", buttons: [{}] },
                        {
                            id: "options",
                            buttons: [
                                {
                                    id: r,
                                    command: r,
                                    context: r,
                                    className: "far fa-square",
                                },
                                {
                                    id: u,
                                    context: u,
                                    command: function (e) {
                                        return e.runCommand(u);
                                    },
                                    className: "fa fa-eye",
                                },
                                {
                                    id: l,
                                    command: l,
                                    context: l,
                                    className: "fas fa-expand",
                                },
                                {
                                    id: "undo",
                                    className: "fa fa-undo",
                                    command: function (e) {
                                        return e.runCommand("core:undo");
                                    },
                                },
                                {
                                    id: "redo",
                                    className: "fas fa-redo",
                                    command: function (e) {
                                        return e.runCommand("core:redo");
                                    },
                                },
                                {
                                    id: o.cmdClear,
                                    className: "fa fa-trash",
                                    command: function (e) {
                                        return e.runCommand(o.cmdClear);
                                    },
                                },
                                {
                                    id: "back-button",
                                    command: function (e) {},
                                    className:
                                        "fa fa-arrow-circle-left btn-builder-new",
                                    attributes: {
                                        title: "Back Home",
                                        id: "back-button",
                                    },
                                },
                                {
                                    id: "save-button",
                                    command: function (e) {},
                                    className: "fa fa-save btn-builder-new",
                                    attributes: {
                                        title: "Save",
                                        id: "save-builder",
                                    },
                                },
                                {
                                    id: "publish-button",
                                    command: function (e) {},
                                    className:
                                        "fa fa fa-rocket btn-builder-new",
                                    attributes: {
                                        title: "View Page",
                                        id: "view_page",
                                    },
                                },
                            ],
                        },
                        {
                            id: "views",
                            buttons: [
                                {
                                    id: i,
                                    command: i,
                                    active: !0,
                                    className: "fas fa-cog",
                                },
                                {
                                    id: "open-tm",
                                    command: "open-tm",
                                    className: "fa fa-cog",
                                },
                                { id: c, command: c, className: "fa fa-bars" },
                                {
                                    id: s,
                                    command: s,
                                    className: "fa fa-th-large",
                                },
                            ],
                        },
                    ]),
                    n
                        .addPanel({ id: "devices-c" })
                        .get("buttons")
                        .add([
                            {
                                id: o.cmdDeviceDesktop,
                                command: o.cmdDeviceDesktop,
                                className: "fa fa-desktop",
                                active: 1,
                            },
                            {
                                id: o.cmdDeviceTablet,
                                command: o.cmdDeviceTablet,
                                className: "fa fa-tablet",
                            },
                            {
                                id: o.cmdDeviceMobile,
                                command: o.cmdDeviceMobile,
                                className: "fa fa-mobile",
                            },
                        ]);
                var d = n.getButton("views", s);
                e.on("load", function () {
                    return d && d.set("active", 1);
                }),
                    t.showStylesOnChange &&
                        e.on("component:selected", function () {
                            var t = n.getButton("views", i),
                                o = n.getButton("views", c);
                            (o && o.get("active")) ||
                                !e.getSelected() ||
                                (t && t.set("active", 1));
                        });
            };
        },
        function (e, t, n) {
            "use strict";
            Object.defineProperty(t, "__esModule", { value: !0 }),
                (t.default = function (e, t) {
                    var n = e.StyleManager,
                        o = t.customStyleManager;
                    n.getSectors().reset(
                        o && o.length
                            ? o
                            : [
                                  {
                                      name: t.textLayout,
                                      open: !1,
                                      buildProps: [
                                          "height",
                                          "width",
                                          "margin",
                                          "padding",
                                      ],
                                  },
                                  {
                                      name: t.textTypography,
                                      open: !1,
                                      buildProps: [
                                          "font-family",
                                          "color",
                                          "font-size",
                                          "font-weight",
                                          "letter-spacing",
                                          "line-height",
                                          "text-align",
                                          "text-shadow",
                                      ],
                                      properties: [
                                          {
                                              property: "text-align",
                                              list: [
                                                  {
                                                      value: "left",
                                                      className:
                                                          "fa fa-align-left",
                                                  },
                                                  {
                                                      value: "center",
                                                      className:
                                                          "fa fa-align-center",
                                                  },
                                                  {
                                                      value: "right",
                                                      className:
                                                          "fa fa-align-right",
                                                  },
                                                  {
                                                      value: "justify",
                                                      className:
                                                          "fa fa-align-justify",
                                                  },
                                              ],
                                          },
                                      ],
                                  },
                                  {
                                      name: t.textBackground,
                                      open: !1,
                                      buildProps: [
                                          "background-color",
                                          "background",
                                      ],
                                  },
                                  {
                                      name: t.textBorderAndShadow,
                                      open: !1,
                                      buildProps: [
                                          "box-shadow",
                                          "border",
                                          "border-radius",
                                      ],
                                  },
                              ]
                    );
                });
        },
    ]);
});
