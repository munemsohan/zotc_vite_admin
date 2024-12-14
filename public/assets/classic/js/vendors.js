/*! jQuery v3.6.0 | (c) OpenJS Foundation and other contributors | jquery.org/license */
!(function (e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports
        ? (module.exports = e.document
              ? t(e, !0)
              : function (e) {
                    if (!e.document)
                        throw new Error(
                            "jQuery requires a window with a document"
                        );
                    return t(e);
                })
        : t(e);
})("undefined" != typeof window ? window : this, function (C, e) {
    "use strict";
    var t = [],
        r = Object.getPrototypeOf,
        s = t.slice,
        g = t.flat
            ? function (e) {
                  return t.flat.call(e);
              }
            : function (e) {
                  return t.concat.apply([], e);
              },
        u = t.push,
        i = t.indexOf,
        n = {},
        o = n.toString,
        v = n.hasOwnProperty,
        a = v.toString,
        l = a.call(Object),
        y = {},
        m = function (e) {
            return (
                "function" == typeof e &&
                "number" != typeof e.nodeType &&
                "function" != typeof e.item
            );
        },
        x = function (e) {
            return null != e && e === e.window;
        },
        E = C.document,
        c = { type: !0, src: !0, nonce: !0, noModule: !0 };
    function b(e, t, n) {
        var r,
            i,
            o = (n = n || E).createElement("script");
        if (((o.text = e), t))
            for (r in c)
                (i = t[r] || (t.getAttribute && t.getAttribute(r))) &&
                    o.setAttribute(r, i);
        n.head.appendChild(o).parentNode.removeChild(o);
    }
    function w(e) {
        return null == e
            ? e + ""
            : "object" == typeof e || "function" == typeof e
            ? n[o.call(e)] || "object"
            : typeof e;
    }
    var f = "3.6.0",
        S = function (e, t) {
            return new S.fn.init(e, t);
        };
    function p(e) {
        var t = !!e && "length" in e && e.length,
            n = w(e);
        return (
            !m(e) &&
            !x(e) &&
            ("array" === n ||
                0 === t ||
                ("number" == typeof t && 0 < t && t - 1 in e))
        );
    }
    (S.fn = S.prototype =
        {
            jquery: f,
            constructor: S,
            length: 0,
            toArray: function () {
                return s.call(this);
            },
            get: function (e) {
                return null == e
                    ? s.call(this)
                    : e < 0
                    ? this[e + this.length]
                    : this[e];
            },
            pushStack: function (e) {
                var t = S.merge(this.constructor(), e);
                return (t.prevObject = this), t;
            },
            each: function (e) {
                return S.each(this, e);
            },
            map: function (n) {
                return this.pushStack(
                    S.map(this, function (e, t) {
                        return n.call(e, t, e);
                    })
                );
            },
            slice: function () {
                return this.pushStack(s.apply(this, arguments));
            },
            first: function () {
                return this.eq(0);
            },
            last: function () {
                return this.eq(-1);
            },
            even: function () {
                return this.pushStack(
                    S.grep(this, function (e, t) {
                        return (t + 1) % 2;
                    })
                );
            },
            odd: function () {
                return this.pushStack(
                    S.grep(this, function (e, t) {
                        return t % 2;
                    })
                );
            },
            eq: function (e) {
                var t = this.length,
                    n = +e + (e < 0 ? t : 0);
                return this.pushStack(0 <= n && n < t ? [this[n]] : []);
            },
            end: function () {
                return this.prevObject || this.constructor();
            },
            push: u,
            sort: t.sort,
            splice: t.splice,
        }),
        (S.extend = S.fn.extend =
            function () {
                var e,
                    t,
                    n,
                    r,
                    i,
                    o,
                    a = arguments[0] || {},
                    s = 1,
                    u = arguments.length,
                    l = !1;
                for (
                    "boolean" == typeof a &&
                        ((l = a), (a = arguments[s] || {}), s++),
                        "object" == typeof a || m(a) || (a = {}),
                        s === u && ((a = this), s--);
                    s < u;
                    s++
                )
                    if (null != (e = arguments[s]))
                        for (t in e)
                            (r = e[t]),
                                "__proto__" !== t &&
                                    a !== r &&
                                    (l &&
                                    r &&
                                    (S.isPlainObject(r) ||
                                        (i = Array.isArray(r)))
                                        ? ((n = a[t]),
                                          (o =
                                              i && !Array.isArray(n)
                                                  ? []
                                                  : i || S.isPlainObject(n)
                                                  ? n
                                                  : {}),
                                          (i = !1),
                                          (a[t] = S.extend(l, o, r)))
                                        : void 0 !== r && (a[t] = r));
                return a;
            }),
        S.extend({
            expando: "jQuery" + (f + Math.random()).replace(/\D/g, ""),
            isReady: !0,
            error: function (e) {
                throw new Error(e);
            },
            noop: function () {},
            isPlainObject: function (e) {
                var t, n;
                return (
                    !(!e || "[object Object]" !== o.call(e)) &&
                    (!(t = r(e)) ||
                        ("function" ==
                            typeof (n =
                                v.call(t, "constructor") && t.constructor) &&
                            a.call(n) === l))
                );
            },
            isEmptyObject: function (e) {
                var t;
                for (t in e) return !1;
                return !0;
            },
            globalEval: function (e, t, n) {
                b(e, { nonce: t && t.nonce }, n);
            },
            each: function (e, t) {
                var n,
                    r = 0;
                if (p(e)) {
                    for (n = e.length; r < n; r++)
                        if (!1 === t.call(e[r], r, e[r])) break;
                } else for (r in e) if (!1 === t.call(e[r], r, e[r])) break;
                return e;
            },
            makeArray: function (e, t) {
                var n = t || [];
                return (
                    null != e &&
                        (p(Object(e))
                            ? S.merge(n, "string" == typeof e ? [e] : e)
                            : u.call(n, e)),
                    n
                );
            },
            inArray: function (e, t, n) {
                return null == t ? -1 : i.call(t, e, n);
            },
            merge: function (e, t) {
                for (var n = +t.length, r = 0, i = e.length; r < n; r++)
                    e[i++] = t[r];
                return (e.length = i), e;
            },
            grep: function (e, t, n) {
                for (var r = [], i = 0, o = e.length, a = !n; i < o; i++)
                    !t(e[i], i) !== a && r.push(e[i]);
                return r;
            },
            map: function (e, t, n) {
                var r,
                    i,
                    o = 0,
                    a = [];
                if (p(e))
                    for (r = e.length; o < r; o++)
                        null != (i = t(e[o], o, n)) && a.push(i);
                else for (o in e) null != (i = t(e[o], o, n)) && a.push(i);
                return g(a);
            },
            guid: 1,
            support: y,
        }),
        "function" == typeof Symbol &&
            (S.fn[Symbol.iterator] = t[Symbol.iterator]),
        S.each(
            "Boolean Number String Function Array Date RegExp Object Error Symbol".split(
                " "
            ),
            function (e, t) {
                n["[object " + t + "]"] = t.toLowerCase();
            }
        );
    var d = (function (n) {
        var e,
            d,
            b,
            o,
            i,
            h,
            f,
            g,
            w,
            u,
            l,
            T,
            C,
            a,
            E,
            v,
            s,
            c,
            y,
            S = "sizzle" + 1 * new Date(),
            p = n.document,
            k = 0,
            r = 0,
            m = ue(),
            x = ue(),
            A = ue(),
            N = ue(),
            j = function (e, t) {
                return e === t && (l = !0), 0;
            },
            D = {}.hasOwnProperty,
            t = [],
            q = t.pop,
            L = t.push,
            H = t.push,
            O = t.slice,
            P = function (e, t) {
                for (var n = 0, r = e.length; n < r; n++)
                    if (e[n] === t) return n;
                return -1;
            },
            R =
                "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            M = "[\\x20\\t\\r\\n\\f]",
            I =
                "(?:\\\\[\\da-fA-F]{1,6}" +
                M +
                "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
            W =
                "\\[" +
                M +
                "*(" +
                I +
                ")(?:" +
                M +
                "*([*^$|!~]?=)" +
                M +
                "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" +
                I +
                "))|)" +
                M +
                "*\\]",
            F =
                ":(" +
                I +
                ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" +
                W +
                ")*)|.*)\\)|)",
            B = new RegExp(M + "+", "g"),
            $ = new RegExp(
                "^" + M + "+|((?:^|[^\\\\])(?:\\\\.)*)" + M + "+$",
                "g"
            ),
            _ = new RegExp("^" + M + "*," + M + "*"),
            z = new RegExp("^" + M + "*([>+~]|" + M + ")" + M + "*"),
            U = new RegExp(M + "|>"),
            X = new RegExp(F),
            V = new RegExp("^" + I + "$"),
            G = {
                ID: new RegExp("^#(" + I + ")"),
                CLASS: new RegExp("^\\.(" + I + ")"),
                TAG: new RegExp("^(" + I + "|[*])"),
                ATTR: new RegExp("^" + W),
                PSEUDO: new RegExp("^" + F),
                CHILD: new RegExp(
                    "^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" +
                        M +
                        "*(even|odd|(([+-]|)(\\d*)n|)" +
                        M +
                        "*(?:([+-]|)" +
                        M +
                        "*(\\d+)|))" +
                        M +
                        "*\\)|)",
                    "i"
                ),
                bool: new RegExp("^(?:" + R + ")$", "i"),
                needsContext: new RegExp(
                    "^" +
                        M +
                        "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" +
                        M +
                        "*((?:-\\d)?\\d*)" +
                        M +
                        "*\\)|)(?=[^-]|$)",
                    "i"
                ),
            },
            Y = /HTML$/i,
            Q = /^(?:input|select|textarea|button)$/i,
            J = /^h\d$/i,
            K = /^[^{]+\{\s*\[native \w/,
            Z = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            ee = /[+~]/,
            te = new RegExp(
                "\\\\[\\da-fA-F]{1,6}" + M + "?|\\\\([^\\r\\n\\f])",
                "g"
            ),
            ne = function (e, t) {
                var n = "0x" + e.slice(1) - 65536;
                return (
                    t ||
                    (n < 0
                        ? String.fromCharCode(n + 65536)
                        : String.fromCharCode(
                              (n >> 10) | 55296,
                              (1023 & n) | 56320
                          ))
                );
            },
            re = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
            ie = function (e, t) {
                return t
                    ? "\0" === e
                        ? "\ufffd"
                        : e.slice(0, -1) +
                          "\\" +
                          e.charCodeAt(e.length - 1).toString(16) +
                          " "
                    : "\\" + e;
            },
            oe = function () {
                T();
            },
            ae = be(
                function (e) {
                    return (
                        !0 === e.disabled &&
                        "fieldset" === e.nodeName.toLowerCase()
                    );
                },
                { dir: "parentNode", next: "legend" }
            );
        try {
            H.apply((t = O.call(p.childNodes)), p.childNodes),
                t[p.childNodes.length].nodeType;
        } catch (e) {
            H = {
                apply: t.length
                    ? function (e, t) {
                          L.apply(e, O.call(t));
                      }
                    : function (e, t) {
                          var n = e.length,
                              r = 0;
                          while ((e[n++] = t[r++]));
                          e.length = n - 1;
                      },
            };
        }
        function se(t, e, n, r) {
            var i,
                o,
                a,
                s,
                u,
                l,
                c,
                f = e && e.ownerDocument,
                p = e ? e.nodeType : 9;
            if (
                ((n = n || []),
                "string" != typeof t || !t || (1 !== p && 9 !== p && 11 !== p))
            )
                return n;
            if (!r && (T(e), (e = e || C), E)) {
                if (11 !== p && (u = Z.exec(t)))
                    if ((i = u[1])) {
                        if (9 === p) {
                            if (!(a = e.getElementById(i))) return n;
                            if (a.id === i) return n.push(a), n;
                        } else if (
                            f &&
                            (a = f.getElementById(i)) &&
                            y(e, a) &&
                            a.id === i
                        )
                            return n.push(a), n;
                    } else {
                        if (u[2])
                            return H.apply(n, e.getElementsByTagName(t)), n;
                        if (
                            (i = u[3]) &&
                            d.getElementsByClassName &&
                            e.getElementsByClassName
                        )
                            return H.apply(n, e.getElementsByClassName(i)), n;
                    }
                if (
                    d.qsa &&
                    !N[t + " "] &&
                    (!v || !v.test(t)) &&
                    (1 !== p || "object" !== e.nodeName.toLowerCase())
                ) {
                    if (
                        ((c = t), (f = e), 1 === p && (U.test(t) || z.test(t)))
                    ) {
                        ((f = (ee.test(t) && ye(e.parentNode)) || e) === e &&
                            d.scope) ||
                            ((s = e.getAttribute("id"))
                                ? (s = s.replace(re, ie))
                                : e.setAttribute("id", (s = S))),
                            (o = (l = h(t)).length);
                        while (o--)
                            l[o] = (s ? "#" + s : ":scope") + " " + xe(l[o]);
                        c = l.join(",");
                    }
                    try {
                        return H.apply(n, f.querySelectorAll(c)), n;
                    } catch (e) {
                        N(t, !0);
                    } finally {
                        s === S && e.removeAttribute("id");
                    }
                }
            }
            return g(t.replace($, "$1"), e, n, r);
        }
        function ue() {
            var r = [];
            return function e(t, n) {
                return (
                    r.push(t + " ") > b.cacheLength && delete e[r.shift()],
                    (e[t + " "] = n)
                );
            };
        }
        function le(e) {
            return (e[S] = !0), e;
        }
        function ce(e) {
            var t = C.createElement("fieldset");
            try {
                return !!e(t);
            } catch (e) {
                return !1;
            } finally {
                t.parentNode && t.parentNode.removeChild(t), (t = null);
            }
        }
        function fe(e, t) {
            var n = e.split("|"),
                r = n.length;
            while (r--) b.attrHandle[n[r]] = t;
        }
        function pe(e, t) {
            var n = t && e,
                r =
                    n &&
                    1 === e.nodeType &&
                    1 === t.nodeType &&
                    e.sourceIndex - t.sourceIndex;
            if (r) return r;
            if (n) while ((n = n.nextSibling)) if (n === t) return -1;
            return e ? 1 : -1;
        }
        function de(t) {
            return function (e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t;
            };
        }
        function he(n) {
            return function (e) {
                var t = e.nodeName.toLowerCase();
                return ("input" === t || "button" === t) && e.type === n;
            };
        }
        function ge(t) {
            return function (e) {
                return "form" in e
                    ? e.parentNode && !1 === e.disabled
                        ? "label" in e
                            ? "label" in e.parentNode
                                ? e.parentNode.disabled === t
                                : e.disabled === t
                            : e.isDisabled === t ||
                              (e.isDisabled !== !t && ae(e) === t)
                        : e.disabled === t
                    : "label" in e && e.disabled === t;
            };
        }
        function ve(a) {
            return le(function (o) {
                return (
                    (o = +o),
                    le(function (e, t) {
                        var n,
                            r = a([], e.length, o),
                            i = r.length;
                        while (i--) e[(n = r[i])] && (e[n] = !(t[n] = e[n]));
                    })
                );
            });
        }
        function ye(e) {
            return e && "undefined" != typeof e.getElementsByTagName && e;
        }
        for (e in ((d = se.support = {}),
        (i = se.isXML =
            function (e) {
                var t = e && e.namespaceURI,
                    n = e && (e.ownerDocument || e).documentElement;
                return !Y.test(t || (n && n.nodeName) || "HTML");
            }),
        (T = se.setDocument =
            function (e) {
                var t,
                    n,
                    r = e ? e.ownerDocument || e : p;
                return (
                    r != C &&
                        9 === r.nodeType &&
                        r.documentElement &&
                        ((a = (C = r).documentElement),
                        (E = !i(C)),
                        p != C &&
                            (n = C.defaultView) &&
                            n.top !== n &&
                            (n.addEventListener
                                ? n.addEventListener("unload", oe, !1)
                                : n.attachEvent &&
                                  n.attachEvent("onunload", oe)),
                        (d.scope = ce(function (e) {
                            return (
                                a
                                    .appendChild(e)
                                    .appendChild(C.createElement("div")),
                                "undefined" != typeof e.querySelectorAll &&
                                    !e.querySelectorAll(":scope fieldset div")
                                        .length
                            );
                        })),
                        (d.attributes = ce(function (e) {
                            return (
                                (e.className = "i"),
                                !e.getAttribute("className")
                            );
                        })),
                        (d.getElementsByTagName = ce(function (e) {
                            return (
                                e.appendChild(C.createComment("")),
                                !e.getElementsByTagName("*").length
                            );
                        })),
                        (d.getElementsByClassName = K.test(
                            C.getElementsByClassName
                        )),
                        (d.getById = ce(function (e) {
                            return (
                                (a.appendChild(e).id = S),
                                !C.getElementsByName ||
                                    !C.getElementsByName(S).length
                            );
                        })),
                        d.getById
                            ? ((b.filter.ID = function (e) {
                                  var t = e.replace(te, ne);
                                  return function (e) {
                                      return e.getAttribute("id") === t;
                                  };
                              }),
                              (b.find.ID = function (e, t) {
                                  if (
                                      "undefined" != typeof t.getElementById &&
                                      E
                                  ) {
                                      var n = t.getElementById(e);
                                      return n ? [n] : [];
                                  }
                              }))
                            : ((b.filter.ID = function (e) {
                                  var n = e.replace(te, ne);
                                  return function (e) {
                                      var t =
                                          "undefined" !=
                                              typeof e.getAttributeNode &&
                                          e.getAttributeNode("id");
                                      return t && t.value === n;
                                  };
                              }),
                              (b.find.ID = function (e, t) {
                                  if (
                                      "undefined" != typeof t.getElementById &&
                                      E
                                  ) {
                                      var n,
                                          r,
                                          i,
                                          o = t.getElementById(e);
                                      if (o) {
                                          if (
                                              (n = o.getAttributeNode("id")) &&
                                              n.value === e
                                          )
                                              return [o];
                                          (i = t.getElementsByName(e)), (r = 0);
                                          while ((o = i[r++]))
                                              if (
                                                  (n =
                                                      o.getAttributeNode(
                                                          "id"
                                                      )) &&
                                                  n.value === e
                                              )
                                                  return [o];
                                      }
                                      return [];
                                  }
                              })),
                        (b.find.TAG = d.getElementsByTagName
                            ? function (e, t) {
                                  return "undefined" !=
                                      typeof t.getElementsByTagName
                                      ? t.getElementsByTagName(e)
                                      : d.qsa
                                      ? t.querySelectorAll(e)
                                      : void 0;
                              }
                            : function (e, t) {
                                  var n,
                                      r = [],
                                      i = 0,
                                      o = t.getElementsByTagName(e);
                                  if ("*" === e) {
                                      while ((n = o[i++]))
                                          1 === n.nodeType && r.push(n);
                                      return r;
                                  }
                                  return o;
                              }),
                        (b.find.CLASS =
                            d.getElementsByClassName &&
                            function (e, t) {
                                if (
                                    "undefined" !=
                                        typeof t.getElementsByClassName &&
                                    E
                                )
                                    return t.getElementsByClassName(e);
                            }),
                        (s = []),
                        (v = []),
                        (d.qsa = K.test(C.querySelectorAll)) &&
                            (ce(function (e) {
                                var t;
                                (a.appendChild(e).innerHTML =
                                    "<a id='" +
                                    S +
                                    "'></a><select id='" +
                                    S +
                                    "-\r\\' msallowcapture=''><option selected=''></option></select>"),
                                    e.querySelectorAll("[msallowcapture^='']")
                                        .length &&
                                        v.push("[*^$]=" + M + "*(?:''|\"\")"),
                                    e.querySelectorAll("[selected]").length ||
                                        v.push(
                                            "\\[" + M + "*(?:value|" + R + ")"
                                        ),
                                    e.querySelectorAll("[id~=" + S + "-]")
                                        .length || v.push("~="),
                                    (t = C.createElement("input")).setAttribute(
                                        "name",
                                        ""
                                    ),
                                    e.appendChild(t),
                                    e.querySelectorAll("[name='']").length ||
                                        v.push(
                                            "\\[" +
                                                M +
                                                "*name" +
                                                M +
                                                "*=" +
                                                M +
                                                "*(?:''|\"\")"
                                        ),
                                    e.querySelectorAll(":checked").length ||
                                        v.push(":checked"),
                                    e.querySelectorAll("a#" + S + "+*")
                                        .length || v.push(".#.+[+~]"),
                                    e.querySelectorAll("\\\f"),
                                    v.push("[\\r\\n\\f]");
                            }),
                            ce(function (e) {
                                e.innerHTML =
                                    "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                                var t = C.createElement("input");
                                t.setAttribute("type", "hidden"),
                                    e.appendChild(t).setAttribute("name", "D"),
                                    e.querySelectorAll("[name=d]").length &&
                                        v.push("name" + M + "*[*^$|!~]?="),
                                    2 !==
                                        e.querySelectorAll(":enabled").length &&
                                        v.push(":enabled", ":disabled"),
                                    (a.appendChild(e).disabled = !0),
                                    2 !==
                                        e.querySelectorAll(":disabled")
                                            .length &&
                                        v.push(":enabled", ":disabled"),
                                    e.querySelectorAll("*,:x"),
                                    v.push(",.*:");
                            })),
                        (d.matchesSelector = K.test(
                            (c =
                                a.matches ||
                                a.webkitMatchesSelector ||
                                a.mozMatchesSelector ||
                                a.oMatchesSelector ||
                                a.msMatchesSelector)
                        )) &&
                            ce(function (e) {
                                (d.disconnectedMatch = c.call(e, "*")),
                                    c.call(e, "[s!='']:x"),
                                    s.push("!=", F);
                            }),
                        (v = v.length && new RegExp(v.join("|"))),
                        (s = s.length && new RegExp(s.join("|"))),
                        (t = K.test(a.compareDocumentPosition)),
                        (y =
                            t || K.test(a.contains)
                                ? function (e, t) {
                                      var n =
                                              9 === e.nodeType
                                                  ? e.documentElement
                                                  : e,
                                          r = t && t.parentNode;
                                      return (
                                          e === r ||
                                          !(
                                              !r ||
                                              1 !== r.nodeType ||
                                              !(n.contains
                                                  ? n.contains(r)
                                                  : e.compareDocumentPosition &&
                                                    16 &
                                                        e.compareDocumentPosition(
                                                            r
                                                        ))
                                          )
                                      );
                                  }
                                : function (e, t) {
                                      if (t)
                                          while ((t = t.parentNode))
                                              if (t === e) return !0;
                                      return !1;
                                  }),
                        (j = t
                            ? function (e, t) {
                                  if (e === t) return (l = !0), 0;
                                  var n =
                                      !e.compareDocumentPosition -
                                      !t.compareDocumentPosition;
                                  return (
                                      n ||
                                      (1 &
                                          (n =
                                              (e.ownerDocument || e) ==
                                              (t.ownerDocument || t)
                                                  ? e.compareDocumentPosition(t)
                                                  : 1) ||
                                      (!d.sortDetached &&
                                          t.compareDocumentPosition(e) === n)
                                          ? e == C ||
                                            (e.ownerDocument == p && y(p, e))
                                              ? -1
                                              : t == C ||
                                                (t.ownerDocument == p &&
                                                    y(p, t))
                                              ? 1
                                              : u
                                              ? P(u, e) - P(u, t)
                                              : 0
                                          : 4 & n
                                          ? -1
                                          : 1)
                                  );
                              }
                            : function (e, t) {
                                  if (e === t) return (l = !0), 0;
                                  var n,
                                      r = 0,
                                      i = e.parentNode,
                                      o = t.parentNode,
                                      a = [e],
                                      s = [t];
                                  if (!i || !o)
                                      return e == C
                                          ? -1
                                          : t == C
                                          ? 1
                                          : i
                                          ? -1
                                          : o
                                          ? 1
                                          : u
                                          ? P(u, e) - P(u, t)
                                          : 0;
                                  if (i === o) return pe(e, t);
                                  n = e;
                                  while ((n = n.parentNode)) a.unshift(n);
                                  n = t;
                                  while ((n = n.parentNode)) s.unshift(n);
                                  while (a[r] === s[r]) r++;
                                  return r
                                      ? pe(a[r], s[r])
                                      : a[r] == p
                                      ? -1
                                      : s[r] == p
                                      ? 1
                                      : 0;
                              })),
                    C
                );
            }),
        (se.matches = function (e, t) {
            return se(e, null, null, t);
        }),
        (se.matchesSelector = function (e, t) {
            if (
                (T(e),
                d.matchesSelector &&
                    E &&
                    !N[t + " "] &&
                    (!s || !s.test(t)) &&
                    (!v || !v.test(t)))
            )
                try {
                    var n = c.call(e, t);
                    if (
                        n ||
                        d.disconnectedMatch ||
                        (e.document && 11 !== e.document.nodeType)
                    )
                        return n;
                } catch (e) {
                    N(t, !0);
                }
            return 0 < se(t, C, null, [e]).length;
        }),
        (se.contains = function (e, t) {
            return (e.ownerDocument || e) != C && T(e), y(e, t);
        }),
        (se.attr = function (e, t) {
            (e.ownerDocument || e) != C && T(e);
            var n = b.attrHandle[t.toLowerCase()],
                r =
                    n && D.call(b.attrHandle, t.toLowerCase())
                        ? n(e, t, !E)
                        : void 0;
            return void 0 !== r
                ? r
                : d.attributes || !E
                ? e.getAttribute(t)
                : (r = e.getAttributeNode(t)) && r.specified
                ? r.value
                : null;
        }),
        (se.escape = function (e) {
            return (e + "").replace(re, ie);
        }),
        (se.error = function (e) {
            throw new Error("Syntax error, unrecognized expression: " + e);
        }),
        (se.uniqueSort = function (e) {
            var t,
                n = [],
                r = 0,
                i = 0;
            if (
                ((l = !d.detectDuplicates),
                (u = !d.sortStable && e.slice(0)),
                e.sort(j),
                l)
            ) {
                while ((t = e[i++])) t === e[i] && (r = n.push(i));
                while (r--) e.splice(n[r], 1);
            }
            return (u = null), e;
        }),
        (o = se.getText =
            function (e) {
                var t,
                    n = "",
                    r = 0,
                    i = e.nodeType;
                if (i) {
                    if (1 === i || 9 === i || 11 === i) {
                        if ("string" == typeof e.textContent)
                            return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += o(e);
                    } else if (3 === i || 4 === i) return e.nodeValue;
                } else while ((t = e[r++])) n += o(t);
                return n;
            }),
        ((b = se.selectors =
            {
                cacheLength: 50,
                createPseudo: le,
                match: G,
                attrHandle: {},
                find: {},
                relative: {
                    ">": { dir: "parentNode", first: !0 },
                    " ": { dir: "parentNode" },
                    "+": { dir: "previousSibling", first: !0 },
                    "~": { dir: "previousSibling" },
                },
                preFilter: {
                    ATTR: function (e) {
                        return (
                            (e[1] = e[1].replace(te, ne)),
                            (e[3] = (e[3] || e[4] || e[5] || "").replace(
                                te,
                                ne
                            )),
                            "~=" === e[2] && (e[3] = " " + e[3] + " "),
                            e.slice(0, 4)
                        );
                    },
                    CHILD: function (e) {
                        return (
                            (e[1] = e[1].toLowerCase()),
                            "nth" === e[1].slice(0, 3)
                                ? (e[3] || se.error(e[0]),
                                  (e[4] = +(e[4]
                                      ? e[5] + (e[6] || 1)
                                      : 2 *
                                        ("even" === e[3] || "odd" === e[3]))),
                                  (e[5] = +(e[7] + e[8] || "odd" === e[3])))
                                : e[3] && se.error(e[0]),
                            e
                        );
                    },
                    PSEUDO: function (e) {
                        var t,
                            n = !e[6] && e[2];
                        return G.CHILD.test(e[0])
                            ? null
                            : (e[3]
                                  ? (e[2] = e[4] || e[5] || "")
                                  : n &&
                                    X.test(n) &&
                                    (t = h(n, !0)) &&
                                    (t =
                                        n.indexOf(")", n.length - t) -
                                        n.length) &&
                                    ((e[0] = e[0].slice(0, t)),
                                    (e[2] = n.slice(0, t))),
                              e.slice(0, 3));
                    },
                },
                filter: {
                    TAG: function (e) {
                        var t = e.replace(te, ne).toLowerCase();
                        return "*" === e
                            ? function () {
                                  return !0;
                              }
                            : function (e) {
                                  return (
                                      e.nodeName &&
                                      e.nodeName.toLowerCase() === t
                                  );
                              };
                    },
                    CLASS: function (e) {
                        var t = m[e + " "];
                        return (
                            t ||
                            ((t = new RegExp(
                                "(^|" + M + ")" + e + "(" + M + "|$)"
                            )) &&
                                m(e, function (e) {
                                    return t.test(
                                        ("string" == typeof e.className &&
                                            e.className) ||
                                            ("undefined" !=
                                                typeof e.getAttribute &&
                                                e.getAttribute("class")) ||
                                            ""
                                    );
                                }))
                        );
                    },
                    ATTR: function (n, r, i) {
                        return function (e) {
                            var t = se.attr(e, n);
                            return null == t
                                ? "!=" === r
                                : !r ||
                                      ((t += ""),
                                      "=" === r
                                          ? t === i
                                          : "!=" === r
                                          ? t !== i
                                          : "^=" === r
                                          ? i && 0 === t.indexOf(i)
                                          : "*=" === r
                                          ? i && -1 < t.indexOf(i)
                                          : "$=" === r
                                          ? i && t.slice(-i.length) === i
                                          : "~=" === r
                                          ? -1 <
                                            (
                                                " " +
                                                t.replace(B, " ") +
                                                " "
                                            ).indexOf(i)
                                          : "|=" === r &&
                                            (t === i ||
                                                t.slice(0, i.length + 1) ===
                                                    i + "-"));
                        };
                    },
                    CHILD: function (h, e, t, g, v) {
                        var y = "nth" !== h.slice(0, 3),
                            m = "last" !== h.slice(-4),
                            x = "of-type" === e;
                        return 1 === g && 0 === v
                            ? function (e) {
                                  return !!e.parentNode;
                              }
                            : function (e, t, n) {
                                  var r,
                                      i,
                                      o,
                                      a,
                                      s,
                                      u,
                                      l =
                                          y !== m
                                              ? "nextSibling"
                                              : "previousSibling",
                                      c = e.parentNode,
                                      f = x && e.nodeName.toLowerCase(),
                                      p = !n && !x,
                                      d = !1;
                                  if (c) {
                                      if (y) {
                                          while (l) {
                                              a = e;
                                              while ((a = a[l]))
                                                  if (
                                                      x
                                                          ? a.nodeName.toLowerCase() ===
                                                            f
                                                          : 1 === a.nodeType
                                                  )
                                                      return !1;
                                              u = l =
                                                  "only" === h &&
                                                  !u &&
                                                  "nextSibling";
                                          }
                                          return !0;
                                      }
                                      if (
                                          ((u = [
                                              m ? c.firstChild : c.lastChild,
                                          ]),
                                          m && p)
                                      ) {
                                          (d =
                                              (s =
                                                  (r =
                                                      (i =
                                                          (o =
                                                              (a = c)[S] ||
                                                              (a[S] = {}))[
                                                              a.uniqueID
                                                          ] ||
                                                          (o[a.uniqueID] = {}))[
                                                          h
                                                      ] || [])[0] === k &&
                                                  r[1]) && r[2]),
                                              (a = s && c.childNodes[s]);
                                          while (
                                              (a =
                                                  (++s && a && a[l]) ||
                                                  (d = s = 0) ||
                                                  u.pop())
                                          )
                                              if (
                                                  1 === a.nodeType &&
                                                  ++d &&
                                                  a === e
                                              ) {
                                                  i[h] = [k, s, d];
                                                  break;
                                              }
                                      } else if (
                                          (p &&
                                              (d = s =
                                                  (r =
                                                      (i =
                                                          (o =
                                                              (a = e)[S] ||
                                                              (a[S] = {}))[
                                                              a.uniqueID
                                                          ] ||
                                                          (o[a.uniqueID] = {}))[
                                                          h
                                                      ] || [])[0] === k &&
                                                  r[1]),
                                          !1 === d)
                                      )
                                          while (
                                              (a =
                                                  (++s && a && a[l]) ||
                                                  (d = s = 0) ||
                                                  u.pop())
                                          )
                                              if (
                                                  (x
                                                      ? a.nodeName.toLowerCase() ===
                                                        f
                                                      : 1 === a.nodeType) &&
                                                  ++d &&
                                                  (p &&
                                                      ((i =
                                                          (o =
                                                              a[S] ||
                                                              (a[S] = {}))[
                                                              a.uniqueID
                                                          ] ||
                                                          (o[a.uniqueID] = {}))[
                                                          h
                                                      ] = [k, d]),
                                                  a === e)
                                              )
                                                  break;
                                      return (
                                          (d -= v) === g ||
                                          (d % g == 0 && 0 <= d / g)
                                      );
                                  }
                              };
                    },
                    PSEUDO: function (e, o) {
                        var t,
                            a =
                                b.pseudos[e] ||
                                b.setFilters[e.toLowerCase()] ||
                                se.error("unsupported pseudo: " + e);
                        return a[S]
                            ? a(o)
                            : 1 < a.length
                            ? ((t = [e, e, "", o]),
                              b.setFilters.hasOwnProperty(e.toLowerCase())
                                  ? le(function (e, t) {
                                        var n,
                                            r = a(e, o),
                                            i = r.length;
                                        while (i--)
                                            e[(n = P(e, r[i]))] = !(t[n] =
                                                r[i]);
                                    })
                                  : function (e) {
                                        return a(e, 0, t);
                                    })
                            : a;
                    },
                },
                pseudos: {
                    not: le(function (e) {
                        var r = [],
                            i = [],
                            s = f(e.replace($, "$1"));
                        return s[S]
                            ? le(function (e, t, n, r) {
                                  var i,
                                      o = s(e, null, r, []),
                                      a = e.length;
                                  while (a--)
                                      (i = o[a]) && (e[a] = !(t[a] = i));
                              })
                            : function (e, t, n) {
                                  return (
                                      (r[0] = e),
                                      s(r, null, n, i),
                                      (r[0] = null),
                                      !i.pop()
                                  );
                              };
                    }),
                    has: le(function (t) {
                        return function (e) {
                            return 0 < se(t, e).length;
                        };
                    }),
                    contains: le(function (t) {
                        return (
                            (t = t.replace(te, ne)),
                            function (e) {
                                return -1 < (e.textContent || o(e)).indexOf(t);
                            }
                        );
                    }),
                    lang: le(function (n) {
                        return (
                            V.test(n || "") ||
                                se.error("unsupported lang: " + n),
                            (n = n.replace(te, ne).toLowerCase()),
                            function (e) {
                                var t;
                                do {
                                    if (
                                        (t = E
                                            ? e.lang
                                            : e.getAttribute("xml:lang") ||
                                              e.getAttribute("lang"))
                                    )
                                        return (
                                            (t = t.toLowerCase()) === n ||
                                            0 === t.indexOf(n + "-")
                                        );
                                } while (
                                    (e = e.parentNode) &&
                                    1 === e.nodeType
                                );
                                return !1;
                            }
                        );
                    }),
                    target: function (e) {
                        var t = n.location && n.location.hash;
                        return t && t.slice(1) === e.id;
                    },
                    root: function (e) {
                        return e === a;
                    },
                    focus: function (e) {
                        return (
                            e === C.activeElement &&
                            (!C.hasFocus || C.hasFocus()) &&
                            !!(e.type || e.href || ~e.tabIndex)
                        );
                    },
                    enabled: ge(!1),
                    disabled: ge(!0),
                    checked: function (e) {
                        var t = e.nodeName.toLowerCase();
                        return (
                            ("input" === t && !!e.checked) ||
                            ("option" === t && !!e.selected)
                        );
                    },
                    selected: function (e) {
                        return (
                            e.parentNode && e.parentNode.selectedIndex,
                            !0 === e.selected
                        );
                    },
                    empty: function (e) {
                        for (e = e.firstChild; e; e = e.nextSibling)
                            if (e.nodeType < 6) return !1;
                        return !0;
                    },
                    parent: function (e) {
                        return !b.pseudos.empty(e);
                    },
                    header: function (e) {
                        return J.test(e.nodeName);
                    },
                    input: function (e) {
                        return Q.test(e.nodeName);
                    },
                    button: function (e) {
                        var t = e.nodeName.toLowerCase();
                        return (
                            ("input" === t && "button" === e.type) ||
                            "button" === t
                        );
                    },
                    text: function (e) {
                        var t;
                        return (
                            "input" === e.nodeName.toLowerCase() &&
                            "text" === e.type &&
                            (null == (t = e.getAttribute("type")) ||
                                "text" === t.toLowerCase())
                        );
                    },
                    first: ve(function () {
                        return [0];
                    }),
                    last: ve(function (e, t) {
                        return [t - 1];
                    }),
                    eq: ve(function (e, t, n) {
                        return [n < 0 ? n + t : n];
                    }),
                    even: ve(function (e, t) {
                        for (var n = 0; n < t; n += 2) e.push(n);
                        return e;
                    }),
                    odd: ve(function (e, t) {
                        for (var n = 1; n < t; n += 2) e.push(n);
                        return e;
                    }),
                    lt: ve(function (e, t, n) {
                        for (var r = n < 0 ? n + t : t < n ? t : n; 0 <= --r; )
                            e.push(r);
                        return e;
                    }),
                    gt: ve(function (e, t, n) {
                        for (var r = n < 0 ? n + t : n; ++r < t; ) e.push(r);
                        return e;
                    }),
                },
            }).pseudos.nth = b.pseudos.eq),
        { radio: !0, checkbox: !0, file: !0, password: !0, image: !0 }))
            b.pseudos[e] = de(e);
        for (e in { submit: !0, reset: !0 }) b.pseudos[e] = he(e);
        function me() {}
        function xe(e) {
            for (var t = 0, n = e.length, r = ""; t < n; t++) r += e[t].value;
            return r;
        }
        function be(s, e, t) {
            var u = e.dir,
                l = e.next,
                c = l || u,
                f = t && "parentNode" === c,
                p = r++;
            return e.first
                ? function (e, t, n) {
                      while ((e = e[u]))
                          if (1 === e.nodeType || f) return s(e, t, n);
                      return !1;
                  }
                : function (e, t, n) {
                      var r,
                          i,
                          o,
                          a = [k, p];
                      if (n) {
                          while ((e = e[u]))
                              if ((1 === e.nodeType || f) && s(e, t, n))
                                  return !0;
                      } else
                          while ((e = e[u]))
                              if (1 === e.nodeType || f)
                                  if (
                                      ((i =
                                          (o = e[S] || (e[S] = {}))[
                                              e.uniqueID
                                          ] || (o[e.uniqueID] = {})),
                                      l && l === e.nodeName.toLowerCase())
                                  )
                                      e = e[u] || e;
                                  else {
                                      if (
                                          (r = i[c]) &&
                                          r[0] === k &&
                                          r[1] === p
                                      )
                                          return (a[2] = r[2]);
                                      if (((i[c] = a)[2] = s(e, t, n)))
                                          return !0;
                                  }
                      return !1;
                  };
        }
        function we(i) {
            return 1 < i.length
                ? function (e, t, n) {
                      var r = i.length;
                      while (r--) if (!i[r](e, t, n)) return !1;
                      return !0;
                  }
                : i[0];
        }
        function Te(e, t, n, r, i) {
            for (var o, a = [], s = 0, u = e.length, l = null != t; s < u; s++)
                (o = e[s]) &&
                    ((n && !n(o, r, i)) || (a.push(o), l && t.push(s)));
            return a;
        }
        function Ce(d, h, g, v, y, e) {
            return (
                v && !v[S] && (v = Ce(v)),
                y && !y[S] && (y = Ce(y, e)),
                le(function (e, t, n, r) {
                    var i,
                        o,
                        a,
                        s = [],
                        u = [],
                        l = t.length,
                        c =
                            e ||
                            (function (e, t, n) {
                                for (var r = 0, i = t.length; r < i; r++)
                                    se(e, t[r], n);
                                return n;
                            })(h || "*", n.nodeType ? [n] : n, []),
                        f = !d || (!e && h) ? c : Te(c, s, d, n, r),
                        p = g ? (y || (e ? d : l || v) ? [] : t) : f;
                    if ((g && g(f, p, n, r), v)) {
                        (i = Te(p, u)), v(i, [], n, r), (o = i.length);
                        while (o--) (a = i[o]) && (p[u[o]] = !(f[u[o]] = a));
                    }
                    if (e) {
                        if (y || d) {
                            if (y) {
                                (i = []), (o = p.length);
                                while (o--) (a = p[o]) && i.push((f[o] = a));
                                y(null, (p = []), i, r);
                            }
                            o = p.length;
                            while (o--)
                                (a = p[o]) &&
                                    -1 < (i = y ? P(e, a) : s[o]) &&
                                    (e[i] = !(t[i] = a));
                        }
                    } else (p = Te(p === t ? p.splice(l, p.length) : p)), y ? y(null, t, p, r) : H.apply(t, p);
                })
            );
        }
        function Ee(e) {
            for (
                var i,
                    t,
                    n,
                    r = e.length,
                    o = b.relative[e[0].type],
                    a = o || b.relative[" "],
                    s = o ? 1 : 0,
                    u = be(
                        function (e) {
                            return e === i;
                        },
                        a,
                        !0
                    ),
                    l = be(
                        function (e) {
                            return -1 < P(i, e);
                        },
                        a,
                        !0
                    ),
                    c = [
                        function (e, t, n) {
                            var r =
                                (!o && (n || t !== w)) ||
                                ((i = t).nodeType ? u(e, t, n) : l(e, t, n));
                            return (i = null), r;
                        },
                    ];
                s < r;
                s++
            )
                if ((t = b.relative[e[s].type])) c = [be(we(c), t)];
                else {
                    if (
                        (t = b.filter[e[s].type].apply(null, e[s].matches))[S]
                    ) {
                        for (n = ++s; n < r; n++)
                            if (b.relative[e[n].type]) break;
                        return Ce(
                            1 < s && we(c),
                            1 < s &&
                                xe(
                                    e.slice(0, s - 1).concat({
                                        value: " " === e[s - 2].type ? "*" : "",
                                    })
                                ).replace($, "$1"),
                            t,
                            s < n && Ee(e.slice(s, n)),
                            n < r && Ee((e = e.slice(n))),
                            n < r && xe(e)
                        );
                    }
                    c.push(t);
                }
            return we(c);
        }
        return (
            (me.prototype = b.filters = b.pseudos),
            (b.setFilters = new me()),
            (h = se.tokenize =
                function (e, t) {
                    var n,
                        r,
                        i,
                        o,
                        a,
                        s,
                        u,
                        l = x[e + " "];
                    if (l) return t ? 0 : l.slice(0);
                    (a = e), (s = []), (u = b.preFilter);
                    while (a) {
                        for (o in ((n && !(r = _.exec(a))) ||
                            (r && (a = a.slice(r[0].length) || a),
                            s.push((i = []))),
                        (n = !1),
                        (r = z.exec(a)) &&
                            ((n = r.shift()),
                            i.push({ value: n, type: r[0].replace($, " ") }),
                            (a = a.slice(n.length))),
                        b.filter))
                            !(r = G[o].exec(a)) ||
                                (u[o] && !(r = u[o](r))) ||
                                ((n = r.shift()),
                                i.push({ value: n, type: o, matches: r }),
                                (a = a.slice(n.length)));
                        if (!n) break;
                    }
                    return t ? a.length : a ? se.error(e) : x(e, s).slice(0);
                }),
            (f = se.compile =
                function (e, t) {
                    var n,
                        v,
                        y,
                        m,
                        x,
                        r,
                        i = [],
                        o = [],
                        a = A[e + " "];
                    if (!a) {
                        t || (t = h(e)), (n = t.length);
                        while (n--) (a = Ee(t[n]))[S] ? i.push(a) : o.push(a);
                        (a = A(
                            e,
                            ((v = o),
                            (m = 0 < (y = i).length),
                            (x = 0 < v.length),
                            (r = function (e, t, n, r, i) {
                                var o,
                                    a,
                                    s,
                                    u = 0,
                                    l = "0",
                                    c = e && [],
                                    f = [],
                                    p = w,
                                    d = e || (x && b.find.TAG("*", i)),
                                    h = (k +=
                                        null == p ? 1 : Math.random() || 0.1),
                                    g = d.length;
                                for (
                                    i && (w = t == C || t || i);
                                    l !== g && null != (o = d[l]);
                                    l++
                                ) {
                                    if (x && o) {
                                        (a = 0),
                                            t ||
                                                o.ownerDocument == C ||
                                                (T(o), (n = !E));
                                        while ((s = v[a++]))
                                            if (s(o, t || C, n)) {
                                                r.push(o);
                                                break;
                                            }
                                        i && (k = h);
                                    }
                                    m && ((o = !s && o) && u--, e && c.push(o));
                                }
                                if (((u += l), m && l !== u)) {
                                    a = 0;
                                    while ((s = y[a++])) s(c, f, t, n);
                                    if (e) {
                                        if (0 < u)
                                            while (l--)
                                                c[l] ||
                                                    f[l] ||
                                                    (f[l] = q.call(r));
                                        f = Te(f);
                                    }
                                    H.apply(r, f),
                                        i &&
                                            !e &&
                                            0 < f.length &&
                                            1 < u + y.length &&
                                            se.uniqueSort(r);
                                }
                                return i && ((k = h), (w = p)), c;
                            }),
                            m ? le(r) : r)
                        )).selector = e;
                    }
                    return a;
                }),
            (g = se.select =
                function (e, t, n, r) {
                    var i,
                        o,
                        a,
                        s,
                        u,
                        l = "function" == typeof e && e,
                        c = !r && h((e = l.selector || e));
                    if (((n = n || []), 1 === c.length)) {
                        if (
                            2 < (o = c[0] = c[0].slice(0)).length &&
                            "ID" === (a = o[0]).type &&
                            9 === t.nodeType &&
                            E &&
                            b.relative[o[1].type]
                        ) {
                            if (
                                !(t = (b.find.ID(
                                    a.matches[0].replace(te, ne),
                                    t
                                ) || [])[0])
                            )
                                return n;
                            l && (t = t.parentNode),
                                (e = e.slice(o.shift().value.length));
                        }
                        i = G.needsContext.test(e) ? 0 : o.length;
                        while (i--) {
                            if (((a = o[i]), b.relative[(s = a.type)])) break;
                            if (
                                (u = b.find[s]) &&
                                (r = u(
                                    a.matches[0].replace(te, ne),
                                    (ee.test(o[0].type) && ye(t.parentNode)) ||
                                        t
                                ))
                            ) {
                                if ((o.splice(i, 1), !(e = r.length && xe(o))))
                                    return H.apply(n, r), n;
                                break;
                            }
                        }
                    }
                    return (
                        (l || f(e, c))(
                            r,
                            t,
                            !E,
                            n,
                            !t || (ee.test(e) && ye(t.parentNode)) || t
                        ),
                        n
                    );
                }),
            (d.sortStable = S.split("").sort(j).join("") === S),
            (d.detectDuplicates = !!l),
            T(),
            (d.sortDetached = ce(function (e) {
                return (
                    1 & e.compareDocumentPosition(C.createElement("fieldset"))
                );
            })),
            ce(function (e) {
                return (
                    (e.innerHTML = "<a href='#'></a>"),
                    "#" === e.firstChild.getAttribute("href")
                );
            }) ||
                fe("type|href|height|width", function (e, t, n) {
                    if (!n)
                        return e.getAttribute(
                            t,
                            "type" === t.toLowerCase() ? 1 : 2
                        );
                }),
            (d.attributes &&
                ce(function (e) {
                    return (
                        (e.innerHTML = "<input/>"),
                        e.firstChild.setAttribute("value", ""),
                        "" === e.firstChild.getAttribute("value")
                    );
                })) ||
                fe("value", function (e, t, n) {
                    if (!n && "input" === e.nodeName.toLowerCase())
                        return e.defaultValue;
                }),
            ce(function (e) {
                return null == e.getAttribute("disabled");
            }) ||
                fe(R, function (e, t, n) {
                    var r;
                    if (!n)
                        return !0 === e[t]
                            ? t.toLowerCase()
                            : (r = e.getAttributeNode(t)) && r.specified
                            ? r.value
                            : null;
                }),
            se
        );
    })(C);
    (S.find = d),
        (S.expr = d.selectors),
        (S.expr[":"] = S.expr.pseudos),
        (S.uniqueSort = S.unique = d.uniqueSort),
        (S.text = d.getText),
        (S.isXMLDoc = d.isXML),
        (S.contains = d.contains),
        (S.escapeSelector = d.escape);
    var h = function (e, t, n) {
            var r = [],
                i = void 0 !== n;
            while ((e = e[t]) && 9 !== e.nodeType)
                if (1 === e.nodeType) {
                    if (i && S(e).is(n)) break;
                    r.push(e);
                }
            return r;
        },
        T = function (e, t) {
            for (var n = []; e; e = e.nextSibling)
                1 === e.nodeType && e !== t && n.push(e);
            return n;
        },
        k = S.expr.match.needsContext;
    function A(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase();
    }
    var N = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
    function j(e, n, r) {
        return m(n)
            ? S.grep(e, function (e, t) {
                  return !!n.call(e, t, e) !== r;
              })
            : n.nodeType
            ? S.grep(e, function (e) {
                  return (e === n) !== r;
              })
            : "string" != typeof n
            ? S.grep(e, function (e) {
                  return -1 < i.call(n, e) !== r;
              })
            : S.filter(n, e, r);
    }
    (S.filter = function (e, t, n) {
        var r = t[0];
        return (
            n && (e = ":not(" + e + ")"),
            1 === t.length && 1 === r.nodeType
                ? S.find.matchesSelector(r, e)
                    ? [r]
                    : []
                : S.find.matches(
                      e,
                      S.grep(t, function (e) {
                          return 1 === e.nodeType;
                      })
                  )
        );
    }),
        S.fn.extend({
            find: function (e) {
                var t,
                    n,
                    r = this.length,
                    i = this;
                if ("string" != typeof e)
                    return this.pushStack(
                        S(e).filter(function () {
                            for (t = 0; t < r; t++)
                                if (S.contains(i[t], this)) return !0;
                        })
                    );
                for (n = this.pushStack([]), t = 0; t < r; t++)
                    S.find(e, i[t], n);
                return 1 < r ? S.uniqueSort(n) : n;
            },
            filter: function (e) {
                return this.pushStack(j(this, e || [], !1));
            },
            not: function (e) {
                return this.pushStack(j(this, e || [], !0));
            },
            is: function (e) {
                return !!j(
                    this,
                    "string" == typeof e && k.test(e) ? S(e) : e || [],
                    !1
                ).length;
            },
        });
    var D,
        q = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    ((S.fn.init = function (e, t, n) {
        var r, i;
        if (!e) return this;
        if (((n = n || D), "string" == typeof e)) {
            if (
                !(r =
                    "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length
                        ? [null, e, null]
                        : q.exec(e)) ||
                (!r[1] && t)
            )
                return !t || t.jquery
                    ? (t || n).find(e)
                    : this.constructor(t).find(e);
            if (r[1]) {
                if (
                    ((t = t instanceof S ? t[0] : t),
                    S.merge(
                        this,
                        S.parseHTML(
                            r[1],
                            t && t.nodeType ? t.ownerDocument || t : E,
                            !0
                        )
                    ),
                    N.test(r[1]) && S.isPlainObject(t))
                )
                    for (r in t)
                        m(this[r]) ? this[r](t[r]) : this.attr(r, t[r]);
                return this;
            }
            return (
                (i = E.getElementById(r[2])) &&
                    ((this[0] = i), (this.length = 1)),
                this
            );
        }
        return e.nodeType
            ? ((this[0] = e), (this.length = 1), this)
            : m(e)
            ? void 0 !== n.ready
                ? n.ready(e)
                : e(S)
            : S.makeArray(e, this);
    }).prototype = S.fn),
        (D = S(E));
    var L = /^(?:parents|prev(?:Until|All))/,
        H = { children: !0, contents: !0, next: !0, prev: !0 };
    function O(e, t) {
        while ((e = e[t]) && 1 !== e.nodeType);
        return e;
    }
    S.fn.extend({
        has: function (e) {
            var t = S(e, this),
                n = t.length;
            return this.filter(function () {
                for (var e = 0; e < n; e++)
                    if (S.contains(this, t[e])) return !0;
            });
        },
        closest: function (e, t) {
            var n,
                r = 0,
                i = this.length,
                o = [],
                a = "string" != typeof e && S(e);
            if (!k.test(e))
                for (; r < i; r++)
                    for (n = this[r]; n && n !== t; n = n.parentNode)
                        if (
                            n.nodeType < 11 &&
                            (a
                                ? -1 < a.index(n)
                                : 1 === n.nodeType &&
                                  S.find.matchesSelector(n, e))
                        ) {
                            o.push(n);
                            break;
                        }
            return this.pushStack(1 < o.length ? S.uniqueSort(o) : o);
        },
        index: function (e) {
            return e
                ? "string" == typeof e
                    ? i.call(S(e), this[0])
                    : i.call(this, e.jquery ? e[0] : e)
                : this[0] && this[0].parentNode
                ? this.first().prevAll().length
                : -1;
        },
        add: function (e, t) {
            return this.pushStack(S.uniqueSort(S.merge(this.get(), S(e, t))));
        },
        addBack: function (e) {
            return this.add(
                null == e ? this.prevObject : this.prevObject.filter(e)
            );
        },
    }),
        S.each(
            {
                parent: function (e) {
                    var t = e.parentNode;
                    return t && 11 !== t.nodeType ? t : null;
                },
                parents: function (e) {
                    return h(e, "parentNode");
                },
                parentsUntil: function (e, t, n) {
                    return h(e, "parentNode", n);
                },
                next: function (e) {
                    return O(e, "nextSibling");
                },
                prev: function (e) {
                    return O(e, "previousSibling");
                },
                nextAll: function (e) {
                    return h(e, "nextSibling");
                },
                prevAll: function (e) {
                    return h(e, "previousSibling");
                },
                nextUntil: function (e, t, n) {
                    return h(e, "nextSibling", n);
                },
                prevUntil: function (e, t, n) {
                    return h(e, "previousSibling", n);
                },
                siblings: function (e) {
                    return T((e.parentNode || {}).firstChild, e);
                },
                children: function (e) {
                    return T(e.firstChild);
                },
                contents: function (e) {
                    return null != e.contentDocument && r(e.contentDocument)
                        ? e.contentDocument
                        : (A(e, "template") && (e = e.content || e),
                          S.merge([], e.childNodes));
                },
            },
            function (r, i) {
                S.fn[r] = function (e, t) {
                    var n = S.map(this, i, e);
                    return (
                        "Until" !== r.slice(-5) && (t = e),
                        t && "string" == typeof t && (n = S.filter(t, n)),
                        1 < this.length &&
                            (H[r] || S.uniqueSort(n), L.test(r) && n.reverse()),
                        this.pushStack(n)
                    );
                };
            }
        );
    var P = /[^\x20\t\r\n\f]+/g;
    function R(e) {
        return e;
    }
    function M(e) {
        throw e;
    }
    function I(e, t, n, r) {
        var i;
        try {
            e && m((i = e.promise))
                ? i.call(e).done(t).fail(n)
                : e && m((i = e.then))
                ? i.call(e, t, n)
                : t.apply(void 0, [e].slice(r));
        } catch (e) {
            n.apply(void 0, [e]);
        }
    }
    (S.Callbacks = function (r) {
        var e, n;
        r =
            "string" == typeof r
                ? ((e = r),
                  (n = {}),
                  S.each(e.match(P) || [], function (e, t) {
                      n[t] = !0;
                  }),
                  n)
                : S.extend({}, r);
        var i,
            t,
            o,
            a,
            s = [],
            u = [],
            l = -1,
            c = function () {
                for (a = a || r.once, o = i = !0; u.length; l = -1) {
                    t = u.shift();
                    while (++l < s.length)
                        !1 === s[l].apply(t[0], t[1]) &&
                            r.stopOnFalse &&
                            ((l = s.length), (t = !1));
                }
                r.memory || (t = !1), (i = !1), a && (s = t ? [] : "");
            },
            f = {
                add: function () {
                    return (
                        s &&
                            (t && !i && ((l = s.length - 1), u.push(t)),
                            (function n(e) {
                                S.each(e, function (e, t) {
                                    m(t)
                                        ? (r.unique && f.has(t)) || s.push(t)
                                        : t &&
                                          t.length &&
                                          "string" !== w(t) &&
                                          n(t);
                                });
                            })(arguments),
                            t && !i && c()),
                        this
                    );
                },
                remove: function () {
                    return (
                        S.each(arguments, function (e, t) {
                            var n;
                            while (-1 < (n = S.inArray(t, s, n)))
                                s.splice(n, 1), n <= l && l--;
                        }),
                        this
                    );
                },
                has: function (e) {
                    return e ? -1 < S.inArray(e, s) : 0 < s.length;
                },
                empty: function () {
                    return s && (s = []), this;
                },
                disable: function () {
                    return (a = u = []), (s = t = ""), this;
                },
                disabled: function () {
                    return !s;
                },
                lock: function () {
                    return (a = u = []), t || i || (s = t = ""), this;
                },
                locked: function () {
                    return !!a;
                },
                fireWith: function (e, t) {
                    return (
                        a ||
                            ((t = [e, (t = t || []).slice ? t.slice() : t]),
                            u.push(t),
                            i || c()),
                        this
                    );
                },
                fire: function () {
                    return f.fireWith(this, arguments), this;
                },
                fired: function () {
                    return !!o;
                },
            };
        return f;
    }),
        S.extend({
            Deferred: function (e) {
                var o = [
                        [
                            "notify",
                            "progress",
                            S.Callbacks("memory"),
                            S.Callbacks("memory"),
                            2,
                        ],
                        [
                            "resolve",
                            "done",
                            S.Callbacks("once memory"),
                            S.Callbacks("once memory"),
                            0,
                            "resolved",
                        ],
                        [
                            "reject",
                            "fail",
                            S.Callbacks("once memory"),
                            S.Callbacks("once memory"),
                            1,
                            "rejected",
                        ],
                    ],
                    i = "pending",
                    a = {
                        state: function () {
                            return i;
                        },
                        always: function () {
                            return s.done(arguments).fail(arguments), this;
                        },
                        catch: function (e) {
                            return a.then(null, e);
                        },
                        pipe: function () {
                            var i = arguments;
                            return S.Deferred(function (r) {
                                S.each(o, function (e, t) {
                                    var n = m(i[t[4]]) && i[t[4]];
                                    s[t[1]](function () {
                                        var e = n && n.apply(this, arguments);
                                        e && m(e.promise)
                                            ? e
                                                  .promise()
                                                  .progress(r.notify)
                                                  .done(r.resolve)
                                                  .fail(r.reject)
                                            : r[t[0] + "With"](
                                                  this,
                                                  n ? [e] : arguments
                                              );
                                    });
                                }),
                                    (i = null);
                            }).promise();
                        },
                        then: function (t, n, r) {
                            var u = 0;
                            function l(i, o, a, s) {
                                return function () {
                                    var n = this,
                                        r = arguments,
                                        e = function () {
                                            var e, t;
                                            if (!(i < u)) {
                                                if (
                                                    (e = a.apply(n, r)) ===
                                                    o.promise()
                                                )
                                                    throw new TypeError(
                                                        "Thenable self-resolution"
                                                    );
                                                (t =
                                                    e &&
                                                    ("object" == typeof e ||
                                                        "function" ==
                                                            typeof e) &&
                                                    e.then),
                                                    m(t)
                                                        ? s
                                                            ? t.call(
                                                                  e,
                                                                  l(u, o, R, s),
                                                                  l(u, o, M, s)
                                                              )
                                                            : (u++,
                                                              t.call(
                                                                  e,
                                                                  l(u, o, R, s),
                                                                  l(u, o, M, s),
                                                                  l(
                                                                      u,
                                                                      o,
                                                                      R,
                                                                      o.notifyWith
                                                                  )
                                                              ))
                                                        : (a !== R &&
                                                              ((n = void 0),
                                                              (r = [e])),
                                                          (s || o.resolveWith)(
                                                              n,
                                                              r
                                                          ));
                                            }
                                        },
                                        t = s
                                            ? e
                                            : function () {
                                                  try {
                                                      e();
                                                  } catch (e) {
                                                      S.Deferred
                                                          .exceptionHook &&
                                                          S.Deferred.exceptionHook(
                                                              e,
                                                              t.stackTrace
                                                          ),
                                                          u <= i + 1 &&
                                                              (a !== M &&
                                                                  ((n = void 0),
                                                                  (r = [e])),
                                                              o.rejectWith(
                                                                  n,
                                                                  r
                                                              ));
                                                  }
                                              };
                                    i
                                        ? t()
                                        : (S.Deferred.getStackHook &&
                                              (t.stackTrace =
                                                  S.Deferred.getStackHook()),
                                          C.setTimeout(t));
                                };
                            }
                            return S.Deferred(function (e) {
                                o[0][3].add(
                                    l(0, e, m(r) ? r : R, e.notifyWith)
                                ),
                                    o[1][3].add(l(0, e, m(t) ? t : R)),
                                    o[2][3].add(l(0, e, m(n) ? n : M));
                            }).promise();
                        },
                        promise: function (e) {
                            return null != e ? S.extend(e, a) : a;
                        },
                    },
                    s = {};
                return (
                    S.each(o, function (e, t) {
                        var n = t[2],
                            r = t[5];
                        (a[t[1]] = n.add),
                            r &&
                                n.add(
                                    function () {
                                        i = r;
                                    },
                                    o[3 - e][2].disable,
                                    o[3 - e][3].disable,
                                    o[0][2].lock,
                                    o[0][3].lock
                                ),
                            n.add(t[3].fire),
                            (s[t[0]] = function () {
                                return (
                                    s[t[0] + "With"](
                                        this === s ? void 0 : this,
                                        arguments
                                    ),
                                    this
                                );
                            }),
                            (s[t[0] + "With"] = n.fireWith);
                    }),
                    a.promise(s),
                    e && e.call(s, s),
                    s
                );
            },
            when: function (e) {
                var n = arguments.length,
                    t = n,
                    r = Array(t),
                    i = s.call(arguments),
                    o = S.Deferred(),
                    a = function (t) {
                        return function (e) {
                            (r[t] = this),
                                (i[t] =
                                    1 < arguments.length
                                        ? s.call(arguments)
                                        : e),
                                --n || o.resolveWith(r, i);
                        };
                    };
                if (
                    n <= 1 &&
                    (I(e, o.done(a(t)).resolve, o.reject, !n),
                    "pending" === o.state() || m(i[t] && i[t].then))
                )
                    return o.then();
                while (t--) I(i[t], a(t), o.reject);
                return o.promise();
            },
        });
    var W = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    (S.Deferred.exceptionHook = function (e, t) {
        C.console &&
            C.console.warn &&
            e &&
            W.test(e.name) &&
            C.console.warn(
                "jQuery.Deferred exception: " + e.message,
                e.stack,
                t
            );
    }),
        (S.readyException = function (e) {
            C.setTimeout(function () {
                throw e;
            });
        });
    var F = S.Deferred();
    function B() {
        E.removeEventListener("DOMContentLoaded", B),
            C.removeEventListener("load", B),
            S.ready();
    }
    (S.fn.ready = function (e) {
        return (
            F.then(e)["catch"](function (e) {
                S.readyException(e);
            }),
            this
        );
    }),
        S.extend({
            isReady: !1,
            readyWait: 1,
            ready: function (e) {
                (!0 === e ? --S.readyWait : S.isReady) ||
                    ((S.isReady = !0) !== e && 0 < --S.readyWait) ||
                    F.resolveWith(E, [S]);
            },
        }),
        (S.ready.then = F.then),
        "complete" === E.readyState ||
        ("loading" !== E.readyState && !E.documentElement.doScroll)
            ? C.setTimeout(S.ready)
            : (E.addEventListener("DOMContentLoaded", B),
              C.addEventListener("load", B));
    var $ = function (e, t, n, r, i, o, a) {
            var s = 0,
                u = e.length,
                l = null == n;
            if ("object" === w(n))
                for (s in ((i = !0), n)) $(e, t, s, n[s], !0, o, a);
            else if (
                void 0 !== r &&
                ((i = !0),
                m(r) || (a = !0),
                l &&
                    (a
                        ? (t.call(e, r), (t = null))
                        : ((l = t),
                          (t = function (e, t, n) {
                              return l.call(S(e), n);
                          }))),
                t)
            )
                for (; s < u; s++)
                    t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
            return i ? e : l ? t.call(e) : u ? t(e[0], n) : o;
        },
        _ = /^-ms-/,
        z = /-([a-z])/g;
    function U(e, t) {
        return t.toUpperCase();
    }
    function X(e) {
        return e.replace(_, "ms-").replace(z, U);
    }
    var V = function (e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType;
    };
    function G() {
        this.expando = S.expando + G.uid++;
    }
    (G.uid = 1),
        (G.prototype = {
            cache: function (e) {
                var t = e[this.expando];
                return (
                    t ||
                        ((t = {}),
                        V(e) &&
                            (e.nodeType
                                ? (e[this.expando] = t)
                                : Object.defineProperty(e, this.expando, {
                                      value: t,
                                      configurable: !0,
                                  }))),
                    t
                );
            },
            set: function (e, t, n) {
                var r,
                    i = this.cache(e);
                if ("string" == typeof t) i[X(t)] = n;
                else for (r in t) i[X(r)] = t[r];
                return i;
            },
            get: function (e, t) {
                return void 0 === t
                    ? this.cache(e)
                    : e[this.expando] && e[this.expando][X(t)];
            },
            access: function (e, t, n) {
                return void 0 === t ||
                    (t && "string" == typeof t && void 0 === n)
                    ? this.get(e, t)
                    : (this.set(e, t, n), void 0 !== n ? n : t);
            },
            remove: function (e, t) {
                var n,
                    r = e[this.expando];
                if (void 0 !== r) {
                    if (void 0 !== t) {
                        n = (t = Array.isArray(t)
                            ? t.map(X)
                            : (t = X(t)) in r
                            ? [t]
                            : t.match(P) || []).length;
                        while (n--) delete r[t[n]];
                    }
                    (void 0 === t || S.isEmptyObject(r)) &&
                        (e.nodeType
                            ? (e[this.expando] = void 0)
                            : delete e[this.expando]);
                }
            },
            hasData: function (e) {
                var t = e[this.expando];
                return void 0 !== t && !S.isEmptyObject(t);
            },
        });
    var Y = new G(),
        Q = new G(),
        J = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        K = /[A-Z]/g;
    function Z(e, t, n) {
        var r, i;
        if (void 0 === n && 1 === e.nodeType)
            if (
                ((r = "data-" + t.replace(K, "-$&").toLowerCase()),
                "string" == typeof (n = e.getAttribute(r)))
            ) {
                try {
                    n =
                        "true" === (i = n) ||
                        ("false" !== i &&
                            ("null" === i
                                ? null
                                : i === +i + ""
                                ? +i
                                : J.test(i)
                                ? JSON.parse(i)
                                : i));
                } catch (e) {}
                Q.set(e, t, n);
            } else n = void 0;
        return n;
    }
    S.extend({
        hasData: function (e) {
            return Q.hasData(e) || Y.hasData(e);
        },
        data: function (e, t, n) {
            return Q.access(e, t, n);
        },
        removeData: function (e, t) {
            Q.remove(e, t);
        },
        _data: function (e, t, n) {
            return Y.access(e, t, n);
        },
        _removeData: function (e, t) {
            Y.remove(e, t);
        },
    }),
        S.fn.extend({
            data: function (n, e) {
                var t,
                    r,
                    i,
                    o = this[0],
                    a = o && o.attributes;
                if (void 0 === n) {
                    if (
                        this.length &&
                        ((i = Q.get(o)),
                        1 === o.nodeType && !Y.get(o, "hasDataAttrs"))
                    ) {
                        t = a.length;
                        while (t--)
                            a[t] &&
                                0 === (r = a[t].name).indexOf("data-") &&
                                ((r = X(r.slice(5))), Z(o, r, i[r]));
                        Y.set(o, "hasDataAttrs", !0);
                    }
                    return i;
                }
                return "object" == typeof n
                    ? this.each(function () {
                          Q.set(this, n);
                      })
                    : $(
                          this,
                          function (e) {
                              var t;
                              if (o && void 0 === e)
                                  return void 0 !== (t = Q.get(o, n))
                                      ? t
                                      : void 0 !== (t = Z(o, n))
                                      ? t
                                      : void 0;
                              this.each(function () {
                                  Q.set(this, n, e);
                              });
                          },
                          null,
                          e,
                          1 < arguments.length,
                          null,
                          !0
                      );
            },
            removeData: function (e) {
                return this.each(function () {
                    Q.remove(this, e);
                });
            },
        }),
        S.extend({
            queue: function (e, t, n) {
                var r;
                if (e)
                    return (
                        (t = (t || "fx") + "queue"),
                        (r = Y.get(e, t)),
                        n &&
                            (!r || Array.isArray(n)
                                ? (r = Y.access(e, t, S.makeArray(n)))
                                : r.push(n)),
                        r || []
                    );
            },
            dequeue: function (e, t) {
                t = t || "fx";
                var n = S.queue(e, t),
                    r = n.length,
                    i = n.shift(),
                    o = S._queueHooks(e, t);
                "inprogress" === i && ((i = n.shift()), r--),
                    i &&
                        ("fx" === t && n.unshift("inprogress"),
                        delete o.stop,
                        i.call(
                            e,
                            function () {
                                S.dequeue(e, t);
                            },
                            o
                        )),
                    !r && o && o.empty.fire();
            },
            _queueHooks: function (e, t) {
                var n = t + "queueHooks";
                return (
                    Y.get(e, n) ||
                    Y.access(e, n, {
                        empty: S.Callbacks("once memory").add(function () {
                            Y.remove(e, [t + "queue", n]);
                        }),
                    })
                );
            },
        }),
        S.fn.extend({
            queue: function (t, n) {
                var e = 2;
                return (
                    "string" != typeof t && ((n = t), (t = "fx"), e--),
                    arguments.length < e
                        ? S.queue(this[0], t)
                        : void 0 === n
                        ? this
                        : this.each(function () {
                              var e = S.queue(this, t, n);
                              S._queueHooks(this, t),
                                  "fx" === t &&
                                      "inprogress" !== e[0] &&
                                      S.dequeue(this, t);
                          })
                );
            },
            dequeue: function (e) {
                return this.each(function () {
                    S.dequeue(this, e);
                });
            },
            clearQueue: function (e) {
                return this.queue(e || "fx", []);
            },
            promise: function (e, t) {
                var n,
                    r = 1,
                    i = S.Deferred(),
                    o = this,
                    a = this.length,
                    s = function () {
                        --r || i.resolveWith(o, [o]);
                    };
                "string" != typeof e && ((t = e), (e = void 0)),
                    (e = e || "fx");
                while (a--)
                    (n = Y.get(o[a], e + "queueHooks")) &&
                        n.empty &&
                        (r++, n.empty.add(s));
                return s(), i.promise(t);
            },
        });
    var ee = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        te = new RegExp("^(?:([+-])=|)(" + ee + ")([a-z%]*)$", "i"),
        ne = ["Top", "Right", "Bottom", "Left"],
        re = E.documentElement,
        ie = function (e) {
            return S.contains(e.ownerDocument, e);
        },
        oe = { composed: !0 };
    re.getRootNode &&
        (ie = function (e) {
            return (
                S.contains(e.ownerDocument, e) ||
                e.getRootNode(oe) === e.ownerDocument
            );
        });
    var ae = function (e, t) {
        return (
            "none" === (e = t || e).style.display ||
            ("" === e.style.display && ie(e) && "none" === S.css(e, "display"))
        );
    };
    function se(e, t, n, r) {
        var i,
            o,
            a = 20,
            s = r
                ? function () {
                      return r.cur();
                  }
                : function () {
                      return S.css(e, t, "");
                  },
            u = s(),
            l = (n && n[3]) || (S.cssNumber[t] ? "" : "px"),
            c =
                e.nodeType &&
                (S.cssNumber[t] || ("px" !== l && +u)) &&
                te.exec(S.css(e, t));
        if (c && c[3] !== l) {
            (u /= 2), (l = l || c[3]), (c = +u || 1);
            while (a--)
                S.style(e, t, c + l),
                    (1 - o) * (1 - (o = s() / u || 0.5)) <= 0 && (a = 0),
                    (c /= o);
            (c *= 2), S.style(e, t, c + l), (n = n || []);
        }
        return (
            n &&
                ((c = +c || +u || 0),
                (i = n[1] ? c + (n[1] + 1) * n[2] : +n[2]),
                r && ((r.unit = l), (r.start = c), (r.end = i))),
            i
        );
    }
    var ue = {};
    function le(e, t) {
        for (var n, r, i, o, a, s, u, l = [], c = 0, f = e.length; c < f; c++)
            (r = e[c]).style &&
                ((n = r.style.display),
                t
                    ? ("none" === n &&
                          ((l[c] = Y.get(r, "display") || null),
                          l[c] || (r.style.display = "")),
                      "" === r.style.display &&
                          ae(r) &&
                          (l[c] =
                              ((u = a = o = void 0),
                              (a = (i = r).ownerDocument),
                              (s = i.nodeName),
                              (u = ue[s]) ||
                                  ((o = a.body.appendChild(a.createElement(s))),
                                  (u = S.css(o, "display")),
                                  o.parentNode.removeChild(o),
                                  "none" === u && (u = "block"),
                                  (ue[s] = u)))))
                    : "none" !== n &&
                      ((l[c] = "none"), Y.set(r, "display", n)));
        for (c = 0; c < f; c++) null != l[c] && (e[c].style.display = l[c]);
        return e;
    }
    S.fn.extend({
        show: function () {
            return le(this, !0);
        },
        hide: function () {
            return le(this);
        },
        toggle: function (e) {
            return "boolean" == typeof e
                ? e
                    ? this.show()
                    : this.hide()
                : this.each(function () {
                      ae(this) ? S(this).show() : S(this).hide();
                  });
        },
    });
    var ce,
        fe,
        pe = /^(?:checkbox|radio)$/i,
        de = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        he = /^$|^module$|\/(?:java|ecma)script/i;
    (ce = E.createDocumentFragment().appendChild(E.createElement("div"))),
        (fe = E.createElement("input")).setAttribute("type", "radio"),
        fe.setAttribute("checked", "checked"),
        fe.setAttribute("name", "t"),
        ce.appendChild(fe),
        (y.checkClone = ce.cloneNode(!0).cloneNode(!0).lastChild.checked),
        (ce.innerHTML = "<textarea>x</textarea>"),
        (y.noCloneChecked = !!ce.cloneNode(!0).lastChild.defaultValue),
        (ce.innerHTML = "<option></option>"),
        (y.option = !!ce.lastChild);
    var ge = {
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""],
    };
    function ve(e, t) {
        var n;
        return (
            (n =
                "undefined" != typeof e.getElementsByTagName
                    ? e.getElementsByTagName(t || "*")
                    : "undefined" != typeof e.querySelectorAll
                    ? e.querySelectorAll(t || "*")
                    : []),
            void 0 === t || (t && A(e, t)) ? S.merge([e], n) : n
        );
    }
    function ye(e, t) {
        for (var n = 0, r = e.length; n < r; n++)
            Y.set(e[n], "globalEval", !t || Y.get(t[n], "globalEval"));
    }
    (ge.tbody = ge.tfoot = ge.colgroup = ge.caption = ge.thead),
        (ge.th = ge.td),
        y.option ||
            (ge.optgroup = ge.option =
                [1, "<select multiple='multiple'>", "</select>"]);
    var me = /<|&#?\w+;/;
    function xe(e, t, n, r, i) {
        for (
            var o,
                a,
                s,
                u,
                l,
                c,
                f = t.createDocumentFragment(),
                p = [],
                d = 0,
                h = e.length;
            d < h;
            d++
        )
            if ((o = e[d]) || 0 === o)
                if ("object" === w(o)) S.merge(p, o.nodeType ? [o] : o);
                else if (me.test(o)) {
                    (a = a || f.appendChild(t.createElement("div"))),
                        (s = (de.exec(o) || ["", ""])[1].toLowerCase()),
                        (u = ge[s] || ge._default),
                        (a.innerHTML = u[1] + S.htmlPrefilter(o) + u[2]),
                        (c = u[0]);
                    while (c--) a = a.lastChild;
                    S.merge(p, a.childNodes),
                        ((a = f.firstChild).textContent = "");
                } else p.push(t.createTextNode(o));
        (f.textContent = ""), (d = 0);
        while ((o = p[d++]))
            if (r && -1 < S.inArray(o, r)) i && i.push(o);
            else if (
                ((l = ie(o)),
                (a = ve(f.appendChild(o), "script")),
                l && ye(a),
                n)
            ) {
                c = 0;
                while ((o = a[c++])) he.test(o.type || "") && n.push(o);
            }
        return f;
    }
    var be = /^([^.]*)(?:\.(.+)|)/;
    function we() {
        return !0;
    }
    function Te() {
        return !1;
    }
    function Ce(e, t) {
        return (
            (e ===
                (function () {
                    try {
                        return E.activeElement;
                    } catch (e) {}
                })()) ==
            ("focus" === t)
        );
    }
    function Ee(e, t, n, r, i, o) {
        var a, s;
        if ("object" == typeof t) {
            for (s in ("string" != typeof n && ((r = r || n), (n = void 0)), t))
                Ee(e, s, n, r, t[s], o);
            return e;
        }
        if (
            (null == r && null == i
                ? ((i = n), (r = n = void 0))
                : null == i &&
                  ("string" == typeof n
                      ? ((i = r), (r = void 0))
                      : ((i = r), (r = n), (n = void 0))),
            !1 === i)
        )
            i = Te;
        else if (!i) return e;
        return (
            1 === o &&
                ((a = i),
                ((i = function (e) {
                    return S().off(e), a.apply(this, arguments);
                }).guid = a.guid || (a.guid = S.guid++))),
            e.each(function () {
                S.event.add(this, t, i, r, n);
            })
        );
    }
    function Se(e, i, o) {
        o
            ? (Y.set(e, i, !1),
              S.event.add(e, i, {
                  namespace: !1,
                  handler: function (e) {
                      var t,
                          n,
                          r = Y.get(this, i);
                      if (1 & e.isTrigger && this[i]) {
                          if (r.length)
                              (S.event.special[i] || {}).delegateType &&
                                  e.stopPropagation();
                          else if (
                              ((r = s.call(arguments)),
                              Y.set(this, i, r),
                              (t = o(this, i)),
                              this[i](),
                              r !== (n = Y.get(this, i)) || t
                                  ? Y.set(this, i, !1)
                                  : (n = {}),
                              r !== n)
                          )
                              return (
                                  e.stopImmediatePropagation(),
                                  e.preventDefault(),
                                  n && n.value
                              );
                      } else
                          r.length &&
                              (Y.set(this, i, {
                                  value: S.event.trigger(
                                      S.extend(r[0], S.Event.prototype),
                                      r.slice(1),
                                      this
                                  ),
                              }),
                              e.stopImmediatePropagation());
                  },
              }))
            : void 0 === Y.get(e, i) && S.event.add(e, i, we);
    }
    (S.event = {
        global: {},
        add: function (t, e, n, r, i) {
            var o,
                a,
                s,
                u,
                l,
                c,
                f,
                p,
                d,
                h,
                g,
                v = Y.get(t);
            if (V(t)) {
                n.handler && ((n = (o = n).handler), (i = o.selector)),
                    i && S.find.matchesSelector(re, i),
                    n.guid || (n.guid = S.guid++),
                    (u = v.events) || (u = v.events = Object.create(null)),
                    (a = v.handle) ||
                        (a = v.handle =
                            function (e) {
                                return "undefined" != typeof S &&
                                    S.event.triggered !== e.type
                                    ? S.event.dispatch.apply(t, arguments)
                                    : void 0;
                            }),
                    (l = (e = (e || "").match(P) || [""]).length);
                while (l--)
                    (d = g = (s = be.exec(e[l]) || [])[1]),
                        (h = (s[2] || "").split(".").sort()),
                        d &&
                            ((f = S.event.special[d] || {}),
                            (d = (i ? f.delegateType : f.bindType) || d),
                            (f = S.event.special[d] || {}),
                            (c = S.extend(
                                {
                                    type: d,
                                    origType: g,
                                    data: r,
                                    handler: n,
                                    guid: n.guid,
                                    selector: i,
                                    needsContext:
                                        i && S.expr.match.needsContext.test(i),
                                    namespace: h.join("."),
                                },
                                o
                            )),
                            (p = u[d]) ||
                                (((p = u[d] = []).delegateCount = 0),
                                (f.setup && !1 !== f.setup.call(t, r, h, a)) ||
                                    (t.addEventListener &&
                                        t.addEventListener(d, a))),
                            f.add &&
                                (f.add.call(t, c),
                                c.handler.guid || (c.handler.guid = n.guid)),
                            i ? p.splice(p.delegateCount++, 0, c) : p.push(c),
                            (S.event.global[d] = !0));
            }
        },
        remove: function (e, t, n, r, i) {
            var o,
                a,
                s,
                u,
                l,
                c,
                f,
                p,
                d,
                h,
                g,
                v = Y.hasData(e) && Y.get(e);
            if (v && (u = v.events)) {
                l = (t = (t || "").match(P) || [""]).length;
                while (l--)
                    if (
                        ((d = g = (s = be.exec(t[l]) || [])[1]),
                        (h = (s[2] || "").split(".").sort()),
                        d)
                    ) {
                        (f = S.event.special[d] || {}),
                            (p =
                                u[
                                    (d = (r ? f.delegateType : f.bindType) || d)
                                ] || []),
                            (s =
                                s[2] &&
                                new RegExp(
                                    "(^|\\.)" +
                                        h.join("\\.(?:.*\\.|)") +
                                        "(\\.|$)"
                                )),
                            (a = o = p.length);
                        while (o--)
                            (c = p[o]),
                                (!i && g !== c.origType) ||
                                    (n && n.guid !== c.guid) ||
                                    (s && !s.test(c.namespace)) ||
                                    (r &&
                                        r !== c.selector &&
                                        ("**" !== r || !c.selector)) ||
                                    (p.splice(o, 1),
                                    c.selector && p.delegateCount--,
                                    f.remove && f.remove.call(e, c));
                        a &&
                            !p.length &&
                            ((f.teardown &&
                                !1 !== f.teardown.call(e, h, v.handle)) ||
                                S.removeEvent(e, d, v.handle),
                            delete u[d]);
                    } else for (d in u) S.event.remove(e, d + t[l], n, r, !0);
                S.isEmptyObject(u) && Y.remove(e, "handle events");
            }
        },
        dispatch: function (e) {
            var t,
                n,
                r,
                i,
                o,
                a,
                s = new Array(arguments.length),
                u = S.event.fix(e),
                l =
                    (Y.get(this, "events") || Object.create(null))[u.type] ||
                    [],
                c = S.event.special[u.type] || {};
            for (s[0] = u, t = 1; t < arguments.length; t++)
                s[t] = arguments[t];
            if (
                ((u.delegateTarget = this),
                !c.preDispatch || !1 !== c.preDispatch.call(this, u))
            ) {
                (a = S.event.handlers.call(this, u, l)), (t = 0);
                while ((i = a[t++]) && !u.isPropagationStopped()) {
                    (u.currentTarget = i.elem), (n = 0);
                    while (
                        (o = i.handlers[n++]) &&
                        !u.isImmediatePropagationStopped()
                    )
                        (u.rnamespace &&
                            !1 !== o.namespace &&
                            !u.rnamespace.test(o.namespace)) ||
                            ((u.handleObj = o),
                            (u.data = o.data),
                            void 0 !==
                                (r = (
                                    (S.event.special[o.origType] || {})
                                        .handle || o.handler
                                ).apply(i.elem, s)) &&
                                !1 === (u.result = r) &&
                                (u.preventDefault(), u.stopPropagation()));
                }
                return c.postDispatch && c.postDispatch.call(this, u), u.result;
            }
        },
        handlers: function (e, t) {
            var n,
                r,
                i,
                o,
                a,
                s = [],
                u = t.delegateCount,
                l = e.target;
            if (u && l.nodeType && !("click" === e.type && 1 <= e.button))
                for (; l !== this; l = l.parentNode || this)
                    if (
                        1 === l.nodeType &&
                        ("click" !== e.type || !0 !== l.disabled)
                    ) {
                        for (o = [], a = {}, n = 0; n < u; n++)
                            void 0 === a[(i = (r = t[n]).selector + " ")] &&
                                (a[i] = r.needsContext
                                    ? -1 < S(i, this).index(l)
                                    : S.find(i, this, null, [l]).length),
                                a[i] && o.push(r);
                        o.length && s.push({ elem: l, handlers: o });
                    }
            return (
                (l = this),
                u < t.length && s.push({ elem: l, handlers: t.slice(u) }),
                s
            );
        },
        addProp: function (t, e) {
            Object.defineProperty(S.Event.prototype, t, {
                enumerable: !0,
                configurable: !0,
                get: m(e)
                    ? function () {
                          if (this.originalEvent) return e(this.originalEvent);
                      }
                    : function () {
                          if (this.originalEvent) return this.originalEvent[t];
                      },
                set: function (e) {
                    Object.defineProperty(this, t, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: e,
                    });
                },
            });
        },
        fix: function (e) {
            return e[S.expando] ? e : new S.Event(e);
        },
        special: {
            load: { noBubble: !0 },
            click: {
                setup: function (e) {
                    var t = this || e;
                    return (
                        pe.test(t.type) &&
                            t.click &&
                            A(t, "input") &&
                            Se(t, "click", we),
                        !1
                    );
                },
                trigger: function (e) {
                    var t = this || e;
                    return (
                        pe.test(t.type) &&
                            t.click &&
                            A(t, "input") &&
                            Se(t, "click"),
                        !0
                    );
                },
                _default: function (e) {
                    var t = e.target;
                    return (
                        (pe.test(t.type) &&
                            t.click &&
                            A(t, "input") &&
                            Y.get(t, "click")) ||
                        A(t, "a")
                    );
                },
            },
            beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result &&
                        e.originalEvent &&
                        (e.originalEvent.returnValue = e.result);
                },
            },
        },
    }),
        (S.removeEvent = function (e, t, n) {
            e.removeEventListener && e.removeEventListener(t, n);
        }),
        (S.Event = function (e, t) {
            if (!(this instanceof S.Event)) return new S.Event(e, t);
            e && e.type
                ? ((this.originalEvent = e),
                  (this.type = e.type),
                  (this.isDefaultPrevented =
                      e.defaultPrevented ||
                      (void 0 === e.defaultPrevented && !1 === e.returnValue)
                          ? we
                          : Te),
                  (this.target =
                      e.target && 3 === e.target.nodeType
                          ? e.target.parentNode
                          : e.target),
                  (this.currentTarget = e.currentTarget),
                  (this.relatedTarget = e.relatedTarget))
                : (this.type = e),
                t && S.extend(this, t),
                (this.timeStamp = (e && e.timeStamp) || Date.now()),
                (this[S.expando] = !0);
        }),
        (S.Event.prototype = {
            constructor: S.Event,
            isDefaultPrevented: Te,
            isPropagationStopped: Te,
            isImmediatePropagationStopped: Te,
            isSimulated: !1,
            preventDefault: function () {
                var e = this.originalEvent;
                (this.isDefaultPrevented = we),
                    e && !this.isSimulated && e.preventDefault();
            },
            stopPropagation: function () {
                var e = this.originalEvent;
                (this.isPropagationStopped = we),
                    e && !this.isSimulated && e.stopPropagation();
            },
            stopImmediatePropagation: function () {
                var e = this.originalEvent;
                (this.isImmediatePropagationStopped = we),
                    e && !this.isSimulated && e.stopImmediatePropagation(),
                    this.stopPropagation();
            },
        }),
        S.each(
            {
                altKey: !0,
                bubbles: !0,
                cancelable: !0,
                changedTouches: !0,
                ctrlKey: !0,
                detail: !0,
                eventPhase: !0,
                metaKey: !0,
                pageX: !0,
                pageY: !0,
                shiftKey: !0,
                view: !0,
                char: !0,
                code: !0,
                charCode: !0,
                key: !0,
                keyCode: !0,
                button: !0,
                buttons: !0,
                clientX: !0,
                clientY: !0,
                offsetX: !0,
                offsetY: !0,
                pointerId: !0,
                pointerType: !0,
                screenX: !0,
                screenY: !0,
                targetTouches: !0,
                toElement: !0,
                touches: !0,
                which: !0,
            },
            S.event.addProp
        ),
        S.each({ focus: "focusin", blur: "focusout" }, function (e, t) {
            S.event.special[e] = {
                setup: function () {
                    return Se(this, e, Ce), !1;
                },
                trigger: function () {
                    return Se(this, e), !0;
                },
                _default: function () {
                    return !0;
                },
                delegateType: t,
            };
        }),
        S.each(
            {
                mouseenter: "mouseover",
                mouseleave: "mouseout",
                pointerenter: "pointerover",
                pointerleave: "pointerout",
            },
            function (e, i) {
                S.event.special[e] = {
                    delegateType: i,
                    bindType: i,
                    handle: function (e) {
                        var t,
                            n = e.relatedTarget,
                            r = e.handleObj;
                        return (
                            (n && (n === this || S.contains(this, n))) ||
                                ((e.type = r.origType),
                                (t = r.handler.apply(this, arguments)),
                                (e.type = i)),
                            t
                        );
                    },
                };
            }
        ),
        S.fn.extend({
            on: function (e, t, n, r) {
                return Ee(this, e, t, n, r);
            },
            one: function (e, t, n, r) {
                return Ee(this, e, t, n, r, 1);
            },
            off: function (e, t, n) {
                var r, i;
                if (e && e.preventDefault && e.handleObj)
                    return (
                        (r = e.handleObj),
                        S(e.delegateTarget).off(
                            r.namespace
                                ? r.origType + "." + r.namespace
                                : r.origType,
                            r.selector,
                            r.handler
                        ),
                        this
                    );
                if ("object" == typeof e) {
                    for (i in e) this.off(i, t, e[i]);
                    return this;
                }
                return (
                    (!1 !== t && "function" != typeof t) ||
                        ((n = t), (t = void 0)),
                    !1 === n && (n = Te),
                    this.each(function () {
                        S.event.remove(this, e, n, t);
                    })
                );
            },
        });
    var ke = /<script|<style|<link/i,
        Ae = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Ne = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;
    function je(e, t) {
        return (
            (A(e, "table") &&
                A(11 !== t.nodeType ? t : t.firstChild, "tr") &&
                S(e).children("tbody")[0]) ||
            e
        );
    }
    function De(e) {
        return (e.type = (null !== e.getAttribute("type")) + "/" + e.type), e;
    }
    function qe(e) {
        return (
            "true/" === (e.type || "").slice(0, 5)
                ? (e.type = e.type.slice(5))
                : e.removeAttribute("type"),
            e
        );
    }
    function Le(e, t) {
        var n, r, i, o, a, s;
        if (1 === t.nodeType) {
            if (Y.hasData(e) && (s = Y.get(e).events))
                for (i in (Y.remove(t, "handle events"), s))
                    for (n = 0, r = s[i].length; n < r; n++)
                        S.event.add(t, i, s[i][n]);
            Q.hasData(e) &&
                ((o = Q.access(e)), (a = S.extend({}, o)), Q.set(t, a));
        }
    }
    function He(n, r, i, o) {
        r = g(r);
        var e,
            t,
            a,
            s,
            u,
            l,
            c = 0,
            f = n.length,
            p = f - 1,
            d = r[0],
            h = m(d);
        if (h || (1 < f && "string" == typeof d && !y.checkClone && Ae.test(d)))
            return n.each(function (e) {
                var t = n.eq(e);
                h && (r[0] = d.call(this, e, t.html())), He(t, r, i, o);
            });
        if (
            f &&
            ((t = (e = xe(r, n[0].ownerDocument, !1, n, o)).firstChild),
            1 === e.childNodes.length && (e = t),
            t || o)
        ) {
            for (s = (a = S.map(ve(e, "script"), De)).length; c < f; c++)
                (u = e),
                    c !== p &&
                        ((u = S.clone(u, !0, !0)),
                        s && S.merge(a, ve(u, "script"))),
                    i.call(n[c], u, c);
            if (s)
                for (
                    l = a[a.length - 1].ownerDocument, S.map(a, qe), c = 0;
                    c < s;
                    c++
                )
                    (u = a[c]),
                        he.test(u.type || "") &&
                            !Y.access(u, "globalEval") &&
                            S.contains(l, u) &&
                            (u.src && "module" !== (u.type || "").toLowerCase()
                                ? S._evalUrl &&
                                  !u.noModule &&
                                  S._evalUrl(
                                      u.src,
                                      {
                                          nonce:
                                              u.nonce ||
                                              u.getAttribute("nonce"),
                                      },
                                      l
                                  )
                                : b(u.textContent.replace(Ne, ""), u, l));
        }
        return n;
    }
    function Oe(e, t, n) {
        for (var r, i = t ? S.filter(t, e) : e, o = 0; null != (r = i[o]); o++)
            n || 1 !== r.nodeType || S.cleanData(ve(r)),
                r.parentNode &&
                    (n && ie(r) && ye(ve(r, "script")),
                    r.parentNode.removeChild(r));
        return e;
    }
    S.extend({
        htmlPrefilter: function (e) {
            return e;
        },
        clone: function (e, t, n) {
            var r,
                i,
                o,
                a,
                s,
                u,
                l,
                c = e.cloneNode(!0),
                f = ie(e);
            if (
                !(
                    y.noCloneChecked ||
                    (1 !== e.nodeType && 11 !== e.nodeType) ||
                    S.isXMLDoc(e)
                )
            )
                for (a = ve(c), r = 0, i = (o = ve(e)).length; r < i; r++)
                    (s = o[r]),
                        (u = a[r]),
                        void 0,
                        "input" === (l = u.nodeName.toLowerCase()) &&
                        pe.test(s.type)
                            ? (u.checked = s.checked)
                            : ("input" !== l && "textarea" !== l) ||
                              (u.defaultValue = s.defaultValue);
            if (t)
                if (n)
                    for (
                        o = o || ve(e), a = a || ve(c), r = 0, i = o.length;
                        r < i;
                        r++
                    )
                        Le(o[r], a[r]);
                else Le(e, c);
            return (
                0 < (a = ve(c, "script")).length &&
                    ye(a, !f && ve(e, "script")),
                c
            );
        },
        cleanData: function (e) {
            for (
                var t, n, r, i = S.event.special, o = 0;
                void 0 !== (n = e[o]);
                o++
            )
                if (V(n)) {
                    if ((t = n[Y.expando])) {
                        if (t.events)
                            for (r in t.events)
                                i[r]
                                    ? S.event.remove(n, r)
                                    : S.removeEvent(n, r, t.handle);
                        n[Y.expando] = void 0;
                    }
                    n[Q.expando] && (n[Q.expando] = void 0);
                }
        },
    }),
        S.fn.extend({
            detach: function (e) {
                return Oe(this, e, !0);
            },
            remove: function (e) {
                return Oe(this, e);
            },
            text: function (e) {
                return $(
                    this,
                    function (e) {
                        return void 0 === e
                            ? S.text(this)
                            : this.empty().each(function () {
                                  (1 !== this.nodeType &&
                                      11 !== this.nodeType &&
                                      9 !== this.nodeType) ||
                                      (this.textContent = e);
                              });
                    },
                    null,
                    e,
                    arguments.length
                );
            },
            append: function () {
                return He(this, arguments, function (e) {
                    (1 !== this.nodeType &&
                        11 !== this.nodeType &&
                        9 !== this.nodeType) ||
                        je(this, e).appendChild(e);
                });
            },
            prepend: function () {
                return He(this, arguments, function (e) {
                    if (
                        1 === this.nodeType ||
                        11 === this.nodeType ||
                        9 === this.nodeType
                    ) {
                        var t = je(this, e);
                        t.insertBefore(e, t.firstChild);
                    }
                });
            },
            before: function () {
                return He(this, arguments, function (e) {
                    this.parentNode && this.parentNode.insertBefore(e, this);
                });
            },
            after: function () {
                return He(this, arguments, function (e) {
                    this.parentNode &&
                        this.parentNode.insertBefore(e, this.nextSibling);
                });
            },
            empty: function () {
                for (var e, t = 0; null != (e = this[t]); t++)
                    1 === e.nodeType &&
                        (S.cleanData(ve(e, !1)), (e.textContent = ""));
                return this;
            },
            clone: function (e, t) {
                return (
                    (e = null != e && e),
                    (t = null == t ? e : t),
                    this.map(function () {
                        return S.clone(this, e, t);
                    })
                );
            },
            html: function (e) {
                return $(
                    this,
                    function (e) {
                        var t = this[0] || {},
                            n = 0,
                            r = this.length;
                        if (void 0 === e && 1 === t.nodeType)
                            return t.innerHTML;
                        if (
                            "string" == typeof e &&
                            !ke.test(e) &&
                            !ge[(de.exec(e) || ["", ""])[1].toLowerCase()]
                        ) {
                            e = S.htmlPrefilter(e);
                            try {
                                for (; n < r; n++)
                                    1 === (t = this[n] || {}).nodeType &&
                                        (S.cleanData(ve(t, !1)),
                                        (t.innerHTML = e));
                                t = 0;
                            } catch (e) {}
                        }
                        t && this.empty().append(e);
                    },
                    null,
                    e,
                    arguments.length
                );
            },
            replaceWith: function () {
                var n = [];
                return He(
                    this,
                    arguments,
                    function (e) {
                        var t = this.parentNode;
                        S.inArray(this, n) < 0 &&
                            (S.cleanData(ve(this)),
                            t && t.replaceChild(e, this));
                    },
                    n
                );
            },
        }),
        S.each(
            {
                appendTo: "append",
                prependTo: "prepend",
                insertBefore: "before",
                insertAfter: "after",
                replaceAll: "replaceWith",
            },
            function (e, a) {
                S.fn[e] = function (e) {
                    for (
                        var t, n = [], r = S(e), i = r.length - 1, o = 0;
                        o <= i;
                        o++
                    )
                        (t = o === i ? this : this.clone(!0)),
                            S(r[o])[a](t),
                            u.apply(n, t.get());
                    return this.pushStack(n);
                };
            }
        );
    var Pe = new RegExp("^(" + ee + ")(?!px)[a-z%]+$", "i"),
        Re = function (e) {
            var t = e.ownerDocument.defaultView;
            return (t && t.opener) || (t = C), t.getComputedStyle(e);
        },
        Me = function (e, t, n) {
            var r,
                i,
                o = {};
            for (i in t) (o[i] = e.style[i]), (e.style[i] = t[i]);
            for (i in ((r = n.call(e)), t)) e.style[i] = o[i];
            return r;
        },
        Ie = new RegExp(ne.join("|"), "i");
    function We(e, t, n) {
        var r,
            i,
            o,
            a,
            s = e.style;
        return (
            (n = n || Re(e)) &&
                ("" !== (a = n.getPropertyValue(t) || n[t]) ||
                    ie(e) ||
                    (a = S.style(e, t)),
                !y.pixelBoxStyles() &&
                    Pe.test(a) &&
                    Ie.test(t) &&
                    ((r = s.width),
                    (i = s.minWidth),
                    (o = s.maxWidth),
                    (s.minWidth = s.maxWidth = s.width = a),
                    (a = n.width),
                    (s.width = r),
                    (s.minWidth = i),
                    (s.maxWidth = o))),
            void 0 !== a ? a + "" : a
        );
    }
    function Fe(e, t) {
        return {
            get: function () {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get;
            },
        };
    }
    !(function () {
        function e() {
            if (l) {
                (u.style.cssText =
                    "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0"),
                    (l.style.cssText =
                        "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%"),
                    re.appendChild(u).appendChild(l);
                var e = C.getComputedStyle(l);
                (n = "1%" !== e.top),
                    (s = 12 === t(e.marginLeft)),
                    (l.style.right = "60%"),
                    (o = 36 === t(e.right)),
                    (r = 36 === t(e.width)),
                    (l.style.position = "absolute"),
                    (i = 12 === t(l.offsetWidth / 3)),
                    re.removeChild(u),
                    (l = null);
            }
        }
        function t(e) {
            return Math.round(parseFloat(e));
        }
        var n,
            r,
            i,
            o,
            a,
            s,
            u = E.createElement("div"),
            l = E.createElement("div");
        l.style &&
            ((l.style.backgroundClip = "content-box"),
            (l.cloneNode(!0).style.backgroundClip = ""),
            (y.clearCloneStyle = "content-box" === l.style.backgroundClip),
            S.extend(y, {
                boxSizingReliable: function () {
                    return e(), r;
                },
                pixelBoxStyles: function () {
                    return e(), o;
                },
                pixelPosition: function () {
                    return e(), n;
                },
                reliableMarginLeft: function () {
                    return e(), s;
                },
                scrollboxSize: function () {
                    return e(), i;
                },
                reliableTrDimensions: function () {
                    var e, t, n, r;
                    return (
                        null == a &&
                            ((e = E.createElement("table")),
                            (t = E.createElement("tr")),
                            (n = E.createElement("div")),
                            (e.style.cssText =
                                "position:absolute;left:-11111px;border-collapse:separate"),
                            (t.style.cssText = "border:1px solid"),
                            (t.style.height = "1px"),
                            (n.style.height = "9px"),
                            (n.style.display = "block"),
                            re.appendChild(e).appendChild(t).appendChild(n),
                            (r = C.getComputedStyle(t)),
                            (a =
                                parseInt(r.height, 10) +
                                    parseInt(r.borderTopWidth, 10) +
                                    parseInt(r.borderBottomWidth, 10) ===
                                t.offsetHeight),
                            re.removeChild(e)),
                        a
                    );
                },
            }));
    })();
    var Be = ["Webkit", "Moz", "ms"],
        $e = E.createElement("div").style,
        _e = {};
    function ze(e) {
        var t = S.cssProps[e] || _e[e];
        return (
            t ||
            (e in $e
                ? e
                : (_e[e] =
                      (function (e) {
                          var t = e[0].toUpperCase() + e.slice(1),
                              n = Be.length;
                          while (n--) if ((e = Be[n] + t) in $e) return e;
                      })(e) || e))
        );
    }
    var Ue = /^(none|table(?!-c[ea]).+)/,
        Xe = /^--/,
        Ve = { position: "absolute", visibility: "hidden", display: "block" },
        Ge = { letterSpacing: "0", fontWeight: "400" };
    function Ye(e, t, n) {
        var r = te.exec(t);
        return r ? Math.max(0, r[2] - (n || 0)) + (r[3] || "px") : t;
    }
    function Qe(e, t, n, r, i, o) {
        var a = "width" === t ? 1 : 0,
            s = 0,
            u = 0;
        if (n === (r ? "border" : "content")) return 0;
        for (; a < 4; a += 2)
            "margin" === n && (u += S.css(e, n + ne[a], !0, i)),
                r
                    ? ("content" === n &&
                          (u -= S.css(e, "padding" + ne[a], !0, i)),
                      "margin" !== n &&
                          (u -= S.css(e, "border" + ne[a] + "Width", !0, i)))
                    : ((u += S.css(e, "padding" + ne[a], !0, i)),
                      "padding" !== n
                          ? (u += S.css(e, "border" + ne[a] + "Width", !0, i))
                          : (s += S.css(e, "border" + ne[a] + "Width", !0, i)));
        return (
            !r &&
                0 <= o &&
                (u +=
                    Math.max(
                        0,
                        Math.ceil(
                            e["offset" + t[0].toUpperCase() + t.slice(1)] -
                                o -
                                u -
                                s -
                                0.5
                        )
                    ) || 0),
            u
        );
    }
    function Je(e, t, n) {
        var r = Re(e),
            i =
                (!y.boxSizingReliable() || n) &&
                "border-box" === S.css(e, "boxSizing", !1, r),
            o = i,
            a = We(e, t, r),
            s = "offset" + t[0].toUpperCase() + t.slice(1);
        if (Pe.test(a)) {
            if (!n) return a;
            a = "auto";
        }
        return (
            ((!y.boxSizingReliable() && i) ||
                (!y.reliableTrDimensions() && A(e, "tr")) ||
                "auto" === a ||
                (!parseFloat(a) && "inline" === S.css(e, "display", !1, r))) &&
                e.getClientRects().length &&
                ((i = "border-box" === S.css(e, "boxSizing", !1, r)),
                (o = s in e) && (a = e[s])),
            (a = parseFloat(a) || 0) +
                Qe(e, t, n || (i ? "border" : "content"), o, r, a) +
                "px"
        );
    }
    function Ke(e, t, n, r, i) {
        return new Ke.prototype.init(e, t, n, r, i);
    }
    S.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = We(e, "opacity");
                        return "" === n ? "1" : n;
                    }
                },
            },
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            gridArea: !0,
            gridColumn: !0,
            gridColumnEnd: !0,
            gridColumnStart: !0,
            gridRow: !0,
            gridRowEnd: !0,
            gridRowStart: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0,
        },
        cssProps: {},
        style: function (e, t, n, r) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var i,
                    o,
                    a,
                    s = X(t),
                    u = Xe.test(t),
                    l = e.style;
                if (
                    (u || (t = ze(s)),
                    (a = S.cssHooks[t] || S.cssHooks[s]),
                    void 0 === n)
                )
                    return a && "get" in a && void 0 !== (i = a.get(e, !1, r))
                        ? i
                        : l[t];
                "string" === (o = typeof n) &&
                    (i = te.exec(n)) &&
                    i[1] &&
                    ((n = se(e, t, i)), (o = "number")),
                    null != n &&
                        n == n &&
                        ("number" !== o ||
                            u ||
                            (n += (i && i[3]) || (S.cssNumber[s] ? "" : "px")),
                        y.clearCloneStyle ||
                            "" !== n ||
                            0 !== t.indexOf("background") ||
                            (l[t] = "inherit"),
                        (a && "set" in a && void 0 === (n = a.set(e, n, r))) ||
                            (u ? l.setProperty(t, n) : (l[t] = n)));
            }
        },
        css: function (e, t, n, r) {
            var i,
                o,
                a,
                s = X(t);
            return (
                Xe.test(t) || (t = ze(s)),
                (a = S.cssHooks[t] || S.cssHooks[s]) &&
                    "get" in a &&
                    (i = a.get(e, !0, n)),
                void 0 === i && (i = We(e, t, r)),
                "normal" === i && t in Ge && (i = Ge[t]),
                "" === n || n
                    ? ((o = parseFloat(i)),
                      !0 === n || isFinite(o) ? o || 0 : i)
                    : i
            );
        },
    }),
        S.each(["height", "width"], function (e, u) {
            S.cssHooks[u] = {
                get: function (e, t, n) {
                    if (t)
                        return !Ue.test(S.css(e, "display")) ||
                            (e.getClientRects().length &&
                                e.getBoundingClientRect().width)
                            ? Je(e, u, n)
                            : Me(e, Ve, function () {
                                  return Je(e, u, n);
                              });
                },
                set: function (e, t, n) {
                    var r,
                        i = Re(e),
                        o = !y.scrollboxSize() && "absolute" === i.position,
                        a =
                            (o || n) &&
                            "border-box" === S.css(e, "boxSizing", !1, i),
                        s = n ? Qe(e, u, n, a, i) : 0;
                    return (
                        a &&
                            o &&
                            (s -= Math.ceil(
                                e["offset" + u[0].toUpperCase() + u.slice(1)] -
                                    parseFloat(i[u]) -
                                    Qe(e, u, "border", !1, i) -
                                    0.5
                            )),
                        s &&
                            (r = te.exec(t)) &&
                            "px" !== (r[3] || "px") &&
                            ((e.style[u] = t), (t = S.css(e, u))),
                        Ye(0, t, s)
                    );
                },
            };
        }),
        (S.cssHooks.marginLeft = Fe(y.reliableMarginLeft, function (e, t) {
            if (t)
                return (
                    (parseFloat(We(e, "marginLeft")) ||
                        e.getBoundingClientRect().left -
                            Me(e, { marginLeft: 0 }, function () {
                                return e.getBoundingClientRect().left;
                            })) + "px"
                );
        })),
        S.each({ margin: "", padding: "", border: "Width" }, function (i, o) {
            (S.cssHooks[i + o] = {
                expand: function (e) {
                    for (
                        var t = 0,
                            n = {},
                            r = "string" == typeof e ? e.split(" ") : [e];
                        t < 4;
                        t++
                    )
                        n[i + ne[t] + o] = r[t] || r[t - 2] || r[0];
                    return n;
                },
            }),
                "margin" !== i && (S.cssHooks[i + o].set = Ye);
        }),
        S.fn.extend({
            css: function (e, t) {
                return $(
                    this,
                    function (e, t, n) {
                        var r,
                            i,
                            o = {},
                            a = 0;
                        if (Array.isArray(t)) {
                            for (r = Re(e), i = t.length; a < i; a++)
                                o[t[a]] = S.css(e, t[a], !1, r);
                            return o;
                        }
                        return void 0 !== n ? S.style(e, t, n) : S.css(e, t);
                    },
                    e,
                    t,
                    1 < arguments.length
                );
            },
        }),
        (((S.Tween = Ke).prototype = {
            constructor: Ke,
            init: function (e, t, n, r, i, o) {
                (this.elem = e),
                    (this.prop = n),
                    (this.easing = i || S.easing._default),
                    (this.options = t),
                    (this.start = this.now = this.cur()),
                    (this.end = r),
                    (this.unit = o || (S.cssNumber[n] ? "" : "px"));
            },
            cur: function () {
                var e = Ke.propHooks[this.prop];
                return e && e.get
                    ? e.get(this)
                    : Ke.propHooks._default.get(this);
            },
            run: function (e) {
                var t,
                    n = Ke.propHooks[this.prop];
                return (
                    this.options.duration
                        ? (this.pos = t =
                              S.easing[this.easing](
                                  e,
                                  this.options.duration * e,
                                  0,
                                  1,
                                  this.options.duration
                              ))
                        : (this.pos = t = e),
                    (this.now = (this.end - this.start) * t + this.start),
                    this.options.step &&
                        this.options.step.call(this.elem, this.now, this),
                    n && n.set ? n.set(this) : Ke.propHooks._default.set(this),
                    this
                );
            },
        }).init.prototype = Ke.prototype),
        ((Ke.propHooks = {
            _default: {
                get: function (e) {
                    var t;
                    return 1 !== e.elem.nodeType ||
                        (null != e.elem[e.prop] && null == e.elem.style[e.prop])
                        ? e.elem[e.prop]
                        : (t = S.css(e.elem, e.prop, "")) && "auto" !== t
                        ? t
                        : 0;
                },
                set: function (e) {
                    S.fx.step[e.prop]
                        ? S.fx.step[e.prop](e)
                        : 1 !== e.elem.nodeType ||
                          (!S.cssHooks[e.prop] &&
                              null == e.elem.style[ze(e.prop)])
                        ? (e.elem[e.prop] = e.now)
                        : S.style(e.elem, e.prop, e.now + e.unit);
                },
            },
        }).scrollTop = Ke.propHooks.scrollLeft =
            {
                set: function (e) {
                    e.elem.nodeType &&
                        e.elem.parentNode &&
                        (e.elem[e.prop] = e.now);
                },
            }),
        (S.easing = {
            linear: function (e) {
                return e;
            },
            swing: function (e) {
                return 0.5 - Math.cos(e * Math.PI) / 2;
            },
            _default: "swing",
        }),
        (S.fx = Ke.prototype.init),
        (S.fx.step = {});
    var Ze,
        et,
        tt,
        nt,
        rt = /^(?:toggle|show|hide)$/,
        it = /queueHooks$/;
    function ot() {
        et &&
            (!1 === E.hidden && C.requestAnimationFrame
                ? C.requestAnimationFrame(ot)
                : C.setTimeout(ot, S.fx.interval),
            S.fx.tick());
    }
    function at() {
        return (
            C.setTimeout(function () {
                Ze = void 0;
            }),
            (Ze = Date.now())
        );
    }
    function st(e, t) {
        var n,
            r = 0,
            i = { height: e };
        for (t = t ? 1 : 0; r < 4; r += 2 - t)
            i["margin" + (n = ne[r])] = i["padding" + n] = e;
        return t && (i.opacity = i.width = e), i;
    }
    function ut(e, t, n) {
        for (
            var r,
                i = (lt.tweeners[t] || []).concat(lt.tweeners["*"]),
                o = 0,
                a = i.length;
            o < a;
            o++
        )
            if ((r = i[o].call(n, t, e))) return r;
    }
    function lt(o, e, t) {
        var n,
            a,
            r = 0,
            i = lt.prefilters.length,
            s = S.Deferred().always(function () {
                delete u.elem;
            }),
            u = function () {
                if (a) return !1;
                for (
                    var e = Ze || at(),
                        t = Math.max(0, l.startTime + l.duration - e),
                        n = 1 - (t / l.duration || 0),
                        r = 0,
                        i = l.tweens.length;
                    r < i;
                    r++
                )
                    l.tweens[r].run(n);
                return (
                    s.notifyWith(o, [l, n, t]),
                    n < 1 && i
                        ? t
                        : (i || s.notifyWith(o, [l, 1, 0]),
                          s.resolveWith(o, [l]),
                          !1)
                );
            },
            l = s.promise({
                elem: o,
                props: S.extend({}, e),
                opts: S.extend(
                    !0,
                    { specialEasing: {}, easing: S.easing._default },
                    t
                ),
                originalProperties: e,
                originalOptions: t,
                startTime: Ze || at(),
                duration: t.duration,
                tweens: [],
                createTween: function (e, t) {
                    var n = S.Tween(
                        o,
                        l.opts,
                        e,
                        t,
                        l.opts.specialEasing[e] || l.opts.easing
                    );
                    return l.tweens.push(n), n;
                },
                stop: function (e) {
                    var t = 0,
                        n = e ? l.tweens.length : 0;
                    if (a) return this;
                    for (a = !0; t < n; t++) l.tweens[t].run(1);
                    return (
                        e
                            ? (s.notifyWith(o, [l, 1, 0]),
                              s.resolveWith(o, [l, e]))
                            : s.rejectWith(o, [l, e]),
                        this
                    );
                },
            }),
            c = l.props;
        for (
            !(function (e, t) {
                var n, r, i, o, a;
                for (n in e)
                    if (
                        ((i = t[(r = X(n))]),
                        (o = e[n]),
                        Array.isArray(o) && ((i = o[1]), (o = e[n] = o[0])),
                        n !== r && ((e[r] = o), delete e[n]),
                        (a = S.cssHooks[r]) && ("expand" in a))
                    )
                        for (n in ((o = a.expand(o)), delete e[r], o))
                            (n in e) || ((e[n] = o[n]), (t[n] = i));
                    else t[r] = i;
            })(c, l.opts.specialEasing);
            r < i;
            r++
        )
            if ((n = lt.prefilters[r].call(l, o, c, l.opts)))
                return (
                    m(n.stop) &&
                        (S._queueHooks(l.elem, l.opts.queue).stop =
                            n.stop.bind(n)),
                    n
                );
        return (
            S.map(c, ut, l),
            m(l.opts.start) && l.opts.start.call(o, l),
            l
                .progress(l.opts.progress)
                .done(l.opts.done, l.opts.complete)
                .fail(l.opts.fail)
                .always(l.opts.always),
            S.fx.timer(S.extend(u, { elem: o, anim: l, queue: l.opts.queue })),
            l
        );
    }
    (S.Animation = S.extend(lt, {
        tweeners: {
            "*": [
                function (e, t) {
                    var n = this.createTween(e, t);
                    return se(n.elem, e, te.exec(t), n), n;
                },
            ],
        },
        tweener: function (e, t) {
            m(e) ? ((t = e), (e = ["*"])) : (e = e.match(P));
            for (var n, r = 0, i = e.length; r < i; r++)
                (n = e[r]),
                    (lt.tweeners[n] = lt.tweeners[n] || []),
                    lt.tweeners[n].unshift(t);
        },
        prefilters: [
            function (e, t, n) {
                var r,
                    i,
                    o,
                    a,
                    s,
                    u,
                    l,
                    c,
                    f = "width" in t || "height" in t,
                    p = this,
                    d = {},
                    h = e.style,
                    g = e.nodeType && ae(e),
                    v = Y.get(e, "fxshow");
                for (r in (n.queue ||
                    (null == (a = S._queueHooks(e, "fx")).unqueued &&
                        ((a.unqueued = 0),
                        (s = a.empty.fire),
                        (a.empty.fire = function () {
                            a.unqueued || s();
                        })),
                    a.unqueued++,
                    p.always(function () {
                        p.always(function () {
                            a.unqueued--,
                                S.queue(e, "fx").length || a.empty.fire();
                        });
                    })),
                t))
                    if (((i = t[r]), rt.test(i))) {
                        if (
                            (delete t[r],
                            (o = o || "toggle" === i),
                            i === (g ? "hide" : "show"))
                        ) {
                            if ("show" !== i || !v || void 0 === v[r]) continue;
                            g = !0;
                        }
                        d[r] = (v && v[r]) || S.style(e, r);
                    }
                if ((u = !S.isEmptyObject(t)) || !S.isEmptyObject(d))
                    for (r in (f &&
                        1 === e.nodeType &&
                        ((n.overflow = [h.overflow, h.overflowX, h.overflowY]),
                        null == (l = v && v.display) &&
                            (l = Y.get(e, "display")),
                        "none" === (c = S.css(e, "display")) &&
                            (l
                                ? (c = l)
                                : (le([e], !0),
                                  (l = e.style.display || l),
                                  (c = S.css(e, "display")),
                                  le([e]))),
                        ("inline" === c ||
                            ("inline-block" === c && null != l)) &&
                            "none" === S.css(e, "float") &&
                            (u ||
                                (p.done(function () {
                                    h.display = l;
                                }),
                                null == l &&
                                    ((c = h.display),
                                    (l = "none" === c ? "" : c))),
                            (h.display = "inline-block"))),
                    n.overflow &&
                        ((h.overflow = "hidden"),
                        p.always(function () {
                            (h.overflow = n.overflow[0]),
                                (h.overflowX = n.overflow[1]),
                                (h.overflowY = n.overflow[2]);
                        })),
                    (u = !1),
                    d))
                        u ||
                            (v
                                ? "hidden" in v && (g = v.hidden)
                                : (v = Y.access(e, "fxshow", { display: l })),
                            o && (v.hidden = !g),
                            g && le([e], !0),
                            p.done(function () {
                                for (r in (g || le([e]),
                                Y.remove(e, "fxshow"),
                                d))
                                    S.style(e, r, d[r]);
                            })),
                            (u = ut(g ? v[r] : 0, r, p)),
                            r in v ||
                                ((v[r] = u.start),
                                g && ((u.end = u.start), (u.start = 0)));
            },
        ],
        prefilter: function (e, t) {
            t ? lt.prefilters.unshift(e) : lt.prefilters.push(e);
        },
    })),
        (S.speed = function (e, t, n) {
            var r =
                e && "object" == typeof e
                    ? S.extend({}, e)
                    : {
                          complete: n || (!n && t) || (m(e) && e),
                          duration: e,
                          easing: (n && t) || (t && !m(t) && t),
                      };
            return (
                S.fx.off
                    ? (r.duration = 0)
                    : "number" != typeof r.duration &&
                      (r.duration in S.fx.speeds
                          ? (r.duration = S.fx.speeds[r.duration])
                          : (r.duration = S.fx.speeds._default)),
                (null != r.queue && !0 !== r.queue) || (r.queue = "fx"),
                (r.old = r.complete),
                (r.complete = function () {
                    m(r.old) && r.old.call(this),
                        r.queue && S.dequeue(this, r.queue);
                }),
                r
            );
        }),
        S.fn.extend({
            fadeTo: function (e, t, n, r) {
                return this.filter(ae)
                    .css("opacity", 0)
                    .show()
                    .end()
                    .animate({ opacity: t }, e, n, r);
            },
            animate: function (t, e, n, r) {
                var i = S.isEmptyObject(t),
                    o = S.speed(e, n, r),
                    a = function () {
                        var e = lt(this, S.extend({}, t), o);
                        (i || Y.get(this, "finish")) && e.stop(!0);
                    };
                return (
                    (a.finish = a),
                    i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
                );
            },
            stop: function (i, e, o) {
                var a = function (e) {
                    var t = e.stop;
                    delete e.stop, t(o);
                };
                return (
                    "string" != typeof i && ((o = e), (e = i), (i = void 0)),
                    e && this.queue(i || "fx", []),
                    this.each(function () {
                        var e = !0,
                            t = null != i && i + "queueHooks",
                            n = S.timers,
                            r = Y.get(this);
                        if (t) r[t] && r[t].stop && a(r[t]);
                        else
                            for (t in r)
                                r[t] && r[t].stop && it.test(t) && a(r[t]);
                        for (t = n.length; t--; )
                            n[t].elem !== this ||
                                (null != i && n[t].queue !== i) ||
                                (n[t].anim.stop(o), (e = !1), n.splice(t, 1));
                        (!e && o) || S.dequeue(this, i);
                    })
                );
            },
            finish: function (a) {
                return (
                    !1 !== a && (a = a || "fx"),
                    this.each(function () {
                        var e,
                            t = Y.get(this),
                            n = t[a + "queue"],
                            r = t[a + "queueHooks"],
                            i = S.timers,
                            o = n ? n.length : 0;
                        for (
                            t.finish = !0,
                                S.queue(this, a, []),
                                r && r.stop && r.stop.call(this, !0),
                                e = i.length;
                            e--;

                        )
                            i[e].elem === this &&
                                i[e].queue === a &&
                                (i[e].anim.stop(!0), i.splice(e, 1));
                        for (e = 0; e < o; e++)
                            n[e] && n[e].finish && n[e].finish.call(this);
                        delete t.finish;
                    })
                );
            },
        }),
        S.each(["toggle", "show", "hide"], function (e, r) {
            var i = S.fn[r];
            S.fn[r] = function (e, t, n) {
                return null == e || "boolean" == typeof e
                    ? i.apply(this, arguments)
                    : this.animate(st(r, !0), e, t, n);
            };
        }),
        S.each(
            {
                slideDown: st("show"),
                slideUp: st("hide"),
                slideToggle: st("toggle"),
                fadeIn: { opacity: "show" },
                fadeOut: { opacity: "hide" },
                fadeToggle: { opacity: "toggle" },
            },
            function (e, r) {
                S.fn[e] = function (e, t, n) {
                    return this.animate(r, e, t, n);
                };
            }
        ),
        (S.timers = []),
        (S.fx.tick = function () {
            var e,
                t = 0,
                n = S.timers;
            for (Ze = Date.now(); t < n.length; t++)
                (e = n[t])() || n[t] !== e || n.splice(t--, 1);
            n.length || S.fx.stop(), (Ze = void 0);
        }),
        (S.fx.timer = function (e) {
            S.timers.push(e), S.fx.start();
        }),
        (S.fx.interval = 13),
        (S.fx.start = function () {
            et || ((et = !0), ot());
        }),
        (S.fx.stop = function () {
            et = null;
        }),
        (S.fx.speeds = { slow: 600, fast: 200, _default: 400 }),
        (S.fn.delay = function (r, e) {
            return (
                (r = (S.fx && S.fx.speeds[r]) || r),
                (e = e || "fx"),
                this.queue(e, function (e, t) {
                    var n = C.setTimeout(e, r);
                    t.stop = function () {
                        C.clearTimeout(n);
                    };
                })
            );
        }),
        (tt = E.createElement("input")),
        (nt = E.createElement("select").appendChild(E.createElement("option"))),
        (tt.type = "checkbox"),
        (y.checkOn = "" !== tt.value),
        (y.optSelected = nt.selected),
        ((tt = E.createElement("input")).value = "t"),
        (tt.type = "radio"),
        (y.radioValue = "t" === tt.value);
    var ct,
        ft = S.expr.attrHandle;
    S.fn.extend({
        attr: function (e, t) {
            return $(this, S.attr, e, t, 1 < arguments.length);
        },
        removeAttr: function (e) {
            return this.each(function () {
                S.removeAttr(this, e);
            });
        },
    }),
        S.extend({
            attr: function (e, t, n) {
                var r,
                    i,
                    o = e.nodeType;
                if (3 !== o && 8 !== o && 2 !== o)
                    return "undefined" == typeof e.getAttribute
                        ? S.prop(e, t, n)
                        : ((1 === o && S.isXMLDoc(e)) ||
                              (i =
                                  S.attrHooks[t.toLowerCase()] ||
                                  (S.expr.match.bool.test(t) ? ct : void 0)),
                          void 0 !== n
                              ? null === n
                                  ? void S.removeAttr(e, t)
                                  : i &&
                                    "set" in i &&
                                    void 0 !== (r = i.set(e, n, t))
                                  ? r
                                  : (e.setAttribute(t, n + ""), n)
                              : i && "get" in i && null !== (r = i.get(e, t))
                              ? r
                              : null == (r = S.find.attr(e, t))
                              ? void 0
                              : r);
            },
            attrHooks: {
                type: {
                    set: function (e, t) {
                        if (!y.radioValue && "radio" === t && A(e, "input")) {
                            var n = e.value;
                            return (
                                e.setAttribute("type", t), n && (e.value = n), t
                            );
                        }
                    },
                },
            },
            removeAttr: function (e, t) {
                var n,
                    r = 0,
                    i = t && t.match(P);
                if (i && 1 === e.nodeType)
                    while ((n = i[r++])) e.removeAttribute(n);
            },
        }),
        (ct = {
            set: function (e, t, n) {
                return !1 === t ? S.removeAttr(e, n) : e.setAttribute(n, n), n;
            },
        }),
        S.each(S.expr.match.bool.source.match(/\w+/g), function (e, t) {
            var a = ft[t] || S.find.attr;
            ft[t] = function (e, t, n) {
                var r,
                    i,
                    o = t.toLowerCase();
                return (
                    n ||
                        ((i = ft[o]),
                        (ft[o] = r),
                        (r = null != a(e, t, n) ? o : null),
                        (ft[o] = i)),
                    r
                );
            };
        });
    var pt = /^(?:input|select|textarea|button)$/i,
        dt = /^(?:a|area)$/i;
    function ht(e) {
        return (e.match(P) || []).join(" ");
    }
    function gt(e) {
        return (e.getAttribute && e.getAttribute("class")) || "";
    }
    function vt(e) {
        return Array.isArray(e)
            ? e
            : ("string" == typeof e && e.match(P)) || [];
    }
    S.fn.extend({
        prop: function (e, t) {
            return $(this, S.prop, e, t, 1 < arguments.length);
        },
        removeProp: function (e) {
            return this.each(function () {
                delete this[S.propFix[e] || e];
            });
        },
    }),
        S.extend({
            prop: function (e, t, n) {
                var r,
                    i,
                    o = e.nodeType;
                if (3 !== o && 8 !== o && 2 !== o)
                    return (
                        (1 === o && S.isXMLDoc(e)) ||
                            ((t = S.propFix[t] || t), (i = S.propHooks[t])),
                        void 0 !== n
                            ? i && "set" in i && void 0 !== (r = i.set(e, n, t))
                                ? r
                                : (e[t] = n)
                            : i && "get" in i && null !== (r = i.get(e, t))
                            ? r
                            : e[t]
                    );
            },
            propHooks: {
                tabIndex: {
                    get: function (e) {
                        var t = S.find.attr(e, "tabindex");
                        return t
                            ? parseInt(t, 10)
                            : pt.test(e.nodeName) ||
                              (dt.test(e.nodeName) && e.href)
                            ? 0
                            : -1;
                    },
                },
            },
            propFix: { for: "htmlFor", class: "className" },
        }),
        y.optSelected ||
            (S.propHooks.selected = {
                get: function (e) {
                    var t = e.parentNode;
                    return (
                        t && t.parentNode && t.parentNode.selectedIndex, null
                    );
                },
                set: function (e) {
                    var t = e.parentNode;
                    t &&
                        (t.selectedIndex,
                        t.parentNode && t.parentNode.selectedIndex);
                },
            }),
        S.each(
            [
                "tabIndex",
                "readOnly",
                "maxLength",
                "cellSpacing",
                "cellPadding",
                "rowSpan",
                "colSpan",
                "useMap",
                "frameBorder",
                "contentEditable",
            ],
            function () {
                S.propFix[this.toLowerCase()] = this;
            }
        ),
        S.fn.extend({
            addClass: function (t) {
                var e,
                    n,
                    r,
                    i,
                    o,
                    a,
                    s,
                    u = 0;
                if (m(t))
                    return this.each(function (e) {
                        S(this).addClass(t.call(this, e, gt(this)));
                    });
                if ((e = vt(t)).length)
                    while ((n = this[u++]))
                        if (
                            ((i = gt(n)),
                            (r = 1 === n.nodeType && " " + ht(i) + " "))
                        ) {
                            a = 0;
                            while ((o = e[a++]))
                                r.indexOf(" " + o + " ") < 0 && (r += o + " ");
                            i !== (s = ht(r)) && n.setAttribute("class", s);
                        }
                return this;
            },
            removeClass: function (t) {
                var e,
                    n,
                    r,
                    i,
                    o,
                    a,
                    s,
                    u = 0;
                if (m(t))
                    return this.each(function (e) {
                        S(this).removeClass(t.call(this, e, gt(this)));
                    });
                if (!arguments.length) return this.attr("class", "");
                if ((e = vt(t)).length)
                    while ((n = this[u++]))
                        if (
                            ((i = gt(n)),
                            (r = 1 === n.nodeType && " " + ht(i) + " "))
                        ) {
                            a = 0;
                            while ((o = e[a++]))
                                while (-1 < r.indexOf(" " + o + " "))
                                    r = r.replace(" " + o + " ", " ");
                            i !== (s = ht(r)) && n.setAttribute("class", s);
                        }
                return this;
            },
            toggleClass: function (i, t) {
                var o = typeof i,
                    a = "string" === o || Array.isArray(i);
                return "boolean" == typeof t && a
                    ? t
                        ? this.addClass(i)
                        : this.removeClass(i)
                    : m(i)
                    ? this.each(function (e) {
                          S(this).toggleClass(i.call(this, e, gt(this), t), t);
                      })
                    : this.each(function () {
                          var e, t, n, r;
                          if (a) {
                              (t = 0), (n = S(this)), (r = vt(i));
                              while ((e = r[t++]))
                                  n.hasClass(e)
                                      ? n.removeClass(e)
                                      : n.addClass(e);
                          } else (void 0 !== i && "boolean" !== o) || ((e = gt(this)) && Y.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", e || !1 === i ? "" : Y.get(this, "__className__") || ""));
                      });
            },
            hasClass: function (e) {
                var t,
                    n,
                    r = 0;
                t = " " + e + " ";
                while ((n = this[r++]))
                    if (
                        1 === n.nodeType &&
                        -1 < (" " + ht(gt(n)) + " ").indexOf(t)
                    )
                        return !0;
                return !1;
            },
        });
    var yt = /\r/g;
    S.fn.extend({
        val: function (n) {
            var r,
                e,
                i,
                t = this[0];
            return arguments.length
                ? ((i = m(n)),
                  this.each(function (e) {
                      var t;
                      1 === this.nodeType &&
                          (null == (t = i ? n.call(this, e, S(this).val()) : n)
                              ? (t = "")
                              : "number" == typeof t
                              ? (t += "")
                              : Array.isArray(t) &&
                                (t = S.map(t, function (e) {
                                    return null == e ? "" : e + "";
                                })),
                          ((r =
                              S.valHooks[this.type] ||
                              S.valHooks[this.nodeName.toLowerCase()]) &&
                              "set" in r &&
                              void 0 !== r.set(this, t, "value")) ||
                              (this.value = t));
                  }))
                : t
                ? (r =
                      S.valHooks[t.type] ||
                      S.valHooks[t.nodeName.toLowerCase()]) &&
                  "get" in r &&
                  void 0 !== (e = r.get(t, "value"))
                    ? e
                    : "string" == typeof (e = t.value)
                    ? e.replace(yt, "")
                    : null == e
                    ? ""
                    : e
                : void 0;
        },
    }),
        S.extend({
            valHooks: {
                option: {
                    get: function (e) {
                        var t = S.find.attr(e, "value");
                        return null != t ? t : ht(S.text(e));
                    },
                },
                select: {
                    get: function (e) {
                        var t,
                            n,
                            r,
                            i = e.options,
                            o = e.selectedIndex,
                            a = "select-one" === e.type,
                            s = a ? null : [],
                            u = a ? o + 1 : i.length;
                        for (r = o < 0 ? u : a ? o : 0; r < u; r++)
                            if (
                                ((n = i[r]).selected || r === o) &&
                                !n.disabled &&
                                (!n.parentNode.disabled ||
                                    !A(n.parentNode, "optgroup"))
                            ) {
                                if (((t = S(n).val()), a)) return t;
                                s.push(t);
                            }
                        return s;
                    },
                    set: function (e, t) {
                        var n,
                            r,
                            i = e.options,
                            o = S.makeArray(t),
                            a = i.length;
                        while (a--)
                            ((r = i[a]).selected =
                                -1 < S.inArray(S.valHooks.option.get(r), o)) &&
                                (n = !0);
                        return n || (e.selectedIndex = -1), o;
                    },
                },
            },
        }),
        S.each(["radio", "checkbox"], function () {
            (S.valHooks[this] = {
                set: function (e, t) {
                    if (Array.isArray(t))
                        return (e.checked = -1 < S.inArray(S(e).val(), t));
                },
            }),
                y.checkOn ||
                    (S.valHooks[this].get = function (e) {
                        return null === e.getAttribute("value")
                            ? "on"
                            : e.value;
                    });
        }),
        (y.focusin = "onfocusin" in C);
    var mt = /^(?:focusinfocus|focusoutblur)$/,
        xt = function (e) {
            e.stopPropagation();
        };
    S.extend(S.event, {
        trigger: function (e, t, n, r) {
            var i,
                o,
                a,
                s,
                u,
                l,
                c,
                f,
                p = [n || E],
                d = v.call(e, "type") ? e.type : e,
                h = v.call(e, "namespace") ? e.namespace.split(".") : [];
            if (
                ((o = f = a = n = n || E),
                3 !== n.nodeType &&
                    8 !== n.nodeType &&
                    !mt.test(d + S.event.triggered) &&
                    (-1 < d.indexOf(".") &&
                        ((d = (h = d.split(".")).shift()), h.sort()),
                    (u = d.indexOf(":") < 0 && "on" + d),
                    ((e = e[S.expando]
                        ? e
                        : new S.Event(d, "object" == typeof e && e)).isTrigger =
                        r ? 2 : 3),
                    (e.namespace = h.join(".")),
                    (e.rnamespace = e.namespace
                        ? new RegExp(
                              "(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"
                          )
                        : null),
                    (e.result = void 0),
                    e.target || (e.target = n),
                    (t = null == t ? [e] : S.makeArray(t, [e])),
                    (c = S.event.special[d] || {}),
                    r || !c.trigger || !1 !== c.trigger.apply(n, t)))
            ) {
                if (!r && !c.noBubble && !x(n)) {
                    for (
                        s = c.delegateType || d,
                            mt.test(s + d) || (o = o.parentNode);
                        o;
                        o = o.parentNode
                    )
                        p.push(o), (a = o);
                    a === (n.ownerDocument || E) &&
                        p.push(a.defaultView || a.parentWindow || C);
                }
                i = 0;
                while ((o = p[i++]) && !e.isPropagationStopped())
                    (f = o),
                        (e.type = 1 < i ? s : c.bindType || d),
                        (l =
                            (Y.get(o, "events") || Object.create(null))[
                                e.type
                            ] && Y.get(o, "handle")) && l.apply(o, t),
                        (l = u && o[u]) &&
                            l.apply &&
                            V(o) &&
                            ((e.result = l.apply(o, t)),
                            !1 === e.result && e.preventDefault());
                return (
                    (e.type = d),
                    r ||
                        e.isDefaultPrevented() ||
                        (c._default && !1 !== c._default.apply(p.pop(), t)) ||
                        !V(n) ||
                        (u &&
                            m(n[d]) &&
                            !x(n) &&
                            ((a = n[u]) && (n[u] = null),
                            (S.event.triggered = d),
                            e.isPropagationStopped() &&
                                f.addEventListener(d, xt),
                            n[d](),
                            e.isPropagationStopped() &&
                                f.removeEventListener(d, xt),
                            (S.event.triggered = void 0),
                            a && (n[u] = a))),
                    e.result
                );
            }
        },
        simulate: function (e, t, n) {
            var r = S.extend(new S.Event(), n, { type: e, isSimulated: !0 });
            S.event.trigger(r, null, t);
        },
    }),
        S.fn.extend({
            trigger: function (e, t) {
                return this.each(function () {
                    S.event.trigger(e, t, this);
                });
            },
            triggerHandler: function (e, t) {
                var n = this[0];
                if (n) return S.event.trigger(e, t, n, !0);
            },
        }),
        y.focusin ||
            S.each({ focus: "focusin", blur: "focusout" }, function (n, r) {
                var i = function (e) {
                    S.event.simulate(r, e.target, S.event.fix(e));
                };
                S.event.special[r] = {
                    setup: function () {
                        var e = this.ownerDocument || this.document || this,
                            t = Y.access(e, r);
                        t || e.addEventListener(n, i, !0),
                            Y.access(e, r, (t || 0) + 1);
                    },
                    teardown: function () {
                        var e = this.ownerDocument || this.document || this,
                            t = Y.access(e, r) - 1;
                        t
                            ? Y.access(e, r, t)
                            : (e.removeEventListener(n, i, !0), Y.remove(e, r));
                    },
                };
            });
    var bt = C.location,
        wt = { guid: Date.now() },
        Tt = /\?/;
    S.parseXML = function (e) {
        var t, n;
        if (!e || "string" != typeof e) return null;
        try {
            t = new C.DOMParser().parseFromString(e, "text/xml");
        } catch (e) {}
        return (
            (n = t && t.getElementsByTagName("parsererror")[0]),
            (t && !n) ||
                S.error(
                    "Invalid XML: " +
                        (n
                            ? S.map(n.childNodes, function (e) {
                                  return e.textContent;
                              }).join("\n")
                            : e)
                ),
            t
        );
    };
    var Ct = /\[\]$/,
        Et = /\r?\n/g,
        St = /^(?:submit|button|image|reset|file)$/i,
        kt = /^(?:input|select|textarea|keygen)/i;
    function At(n, e, r, i) {
        var t;
        if (Array.isArray(e))
            S.each(e, function (e, t) {
                r || Ct.test(n)
                    ? i(n, t)
                    : At(
                          n +
                              "[" +
                              ("object" == typeof t && null != t ? e : "") +
                              "]",
                          t,
                          r,
                          i
                      );
            });
        else if (r || "object" !== w(e)) i(n, e);
        else for (t in e) At(n + "[" + t + "]", e[t], r, i);
    }
    (S.param = function (e, t) {
        var n,
            r = [],
            i = function (e, t) {
                var n = m(t) ? t() : t;
                r[r.length] =
                    encodeURIComponent(e) +
                    "=" +
                    encodeURIComponent(null == n ? "" : n);
            };
        if (null == e) return "";
        if (Array.isArray(e) || (e.jquery && !S.isPlainObject(e)))
            S.each(e, function () {
                i(this.name, this.value);
            });
        else for (n in e) At(n, e[n], t, i);
        return r.join("&");
    }),
        S.fn.extend({
            serialize: function () {
                return S.param(this.serializeArray());
            },
            serializeArray: function () {
                return this.map(function () {
                    var e = S.prop(this, "elements");
                    return e ? S.makeArray(e) : this;
                })
                    .filter(function () {
                        var e = this.type;
                        return (
                            this.name &&
                            !S(this).is(":disabled") &&
                            kt.test(this.nodeName) &&
                            !St.test(e) &&
                            (this.checked || !pe.test(e))
                        );
                    })
                    .map(function (e, t) {
                        var n = S(this).val();
                        return null == n
                            ? null
                            : Array.isArray(n)
                            ? S.map(n, function (e) {
                                  return {
                                      name: t.name,
                                      value: e.replace(Et, "\r\n"),
                                  };
                              })
                            : { name: t.name, value: n.replace(Et, "\r\n") };
                    })
                    .get();
            },
        });
    var Nt = /%20/g,
        jt = /#.*$/,
        Dt = /([?&])_=[^&]*/,
        qt = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        Lt = /^(?:GET|HEAD)$/,
        Ht = /^\/\//,
        Ot = {},
        Pt = {},
        Rt = "*/".concat("*"),
        Mt = E.createElement("a");
    function It(o) {
        return function (e, t) {
            "string" != typeof e && ((t = e), (e = "*"));
            var n,
                r = 0,
                i = e.toLowerCase().match(P) || [];
            if (m(t))
                while ((n = i[r++]))
                    "+" === n[0]
                        ? ((n = n.slice(1) || "*"),
                          (o[n] = o[n] || []).unshift(t))
                        : (o[n] = o[n] || []).push(t);
        };
    }
    function Wt(t, i, o, a) {
        var s = {},
            u = t === Pt;
        function l(e) {
            var r;
            return (
                (s[e] = !0),
                S.each(t[e] || [], function (e, t) {
                    var n = t(i, o, a);
                    return "string" != typeof n || u || s[n]
                        ? u
                            ? !(r = n)
                            : void 0
                        : (i.dataTypes.unshift(n), l(n), !1);
                }),
                r
            );
        }
        return l(i.dataTypes[0]) || (!s["*"] && l("*"));
    }
    function Ft(e, t) {
        var n,
            r,
            i = S.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((i[n] ? e : r || (r = {}))[n] = t[n]);
        return r && S.extend(!0, e, r), e;
    }
    (Mt.href = bt.href),
        S.extend({
            active: 0,
            lastModified: {},
            etag: {},
            ajaxSettings: {
                url: bt.href,
                type: "GET",
                isLocal:
                    /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(
                        bt.protocol
                    ),
                global: !0,
                processData: !0,
                async: !0,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                accepts: {
                    "*": Rt,
                    text: "text/plain",
                    html: "text/html",
                    xml: "application/xml, text/xml",
                    json: "application/json, text/javascript",
                },
                contents: { xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/ },
                responseFields: {
                    xml: "responseXML",
                    text: "responseText",
                    json: "responseJSON",
                },
                converters: {
                    "* text": String,
                    "text html": !0,
                    "text json": JSON.parse,
                    "text xml": S.parseXML,
                },
                flatOptions: { url: !0, context: !0 },
            },
            ajaxSetup: function (e, t) {
                return t ? Ft(Ft(e, S.ajaxSettings), t) : Ft(S.ajaxSettings, e);
            },
            ajaxPrefilter: It(Ot),
            ajaxTransport: It(Pt),
            ajax: function (e, t) {
                "object" == typeof e && ((t = e), (e = void 0)), (t = t || {});
                var c,
                    f,
                    p,
                    n,
                    d,
                    r,
                    h,
                    g,
                    i,
                    o,
                    v = S.ajaxSetup({}, t),
                    y = v.context || v,
                    m = v.context && (y.nodeType || y.jquery) ? S(y) : S.event,
                    x = S.Deferred(),
                    b = S.Callbacks("once memory"),
                    w = v.statusCode || {},
                    a = {},
                    s = {},
                    u = "canceled",
                    T = {
                        readyState: 0,
                        getResponseHeader: function (e) {
                            var t;
                            if (h) {
                                if (!n) {
                                    n = {};
                                    while ((t = qt.exec(p)))
                                        n[t[1].toLowerCase() + " "] = (
                                            n[t[1].toLowerCase() + " "] || []
                                        ).concat(t[2]);
                                }
                                t = n[e.toLowerCase() + " "];
                            }
                            return null == t ? null : t.join(", ");
                        },
                        getAllResponseHeaders: function () {
                            return h ? p : null;
                        },
                        setRequestHeader: function (e, t) {
                            return (
                                null == h &&
                                    ((e = s[e.toLowerCase()] =
                                        s[e.toLowerCase()] || e),
                                    (a[e] = t)),
                                this
                            );
                        },
                        overrideMimeType: function (e) {
                            return null == h && (v.mimeType = e), this;
                        },
                        statusCode: function (e) {
                            var t;
                            if (e)
                                if (h) T.always(e[T.status]);
                                else for (t in e) w[t] = [w[t], e[t]];
                            return this;
                        },
                        abort: function (e) {
                            var t = e || u;
                            return c && c.abort(t), l(0, t), this;
                        },
                    };
                if (
                    (x.promise(T),
                    (v.url = ((e || v.url || bt.href) + "").replace(
                        Ht,
                        bt.protocol + "//"
                    )),
                    (v.type = t.method || t.type || v.method || v.type),
                    (v.dataTypes = (v.dataType || "*")
                        .toLowerCase()
                        .match(P) || [""]),
                    null == v.crossDomain)
                ) {
                    r = E.createElement("a");
                    try {
                        (r.href = v.url),
                            (r.href = r.href),
                            (v.crossDomain =
                                Mt.protocol + "//" + Mt.host !=
                                r.protocol + "//" + r.host);
                    } catch (e) {
                        v.crossDomain = !0;
                    }
                }
                if (
                    (v.data &&
                        v.processData &&
                        "string" != typeof v.data &&
                        (v.data = S.param(v.data, v.traditional)),
                    Wt(Ot, v, t, T),
                    h)
                )
                    return T;
                for (i in ((g = S.event && v.global) &&
                    0 == S.active++ &&
                    S.event.trigger("ajaxStart"),
                (v.type = v.type.toUpperCase()),
                (v.hasContent = !Lt.test(v.type)),
                (f = v.url.replace(jt, "")),
                v.hasContent
                    ? v.data &&
                      v.processData &&
                      0 ===
                          (v.contentType || "").indexOf(
                              "application/x-www-form-urlencoded"
                          ) &&
                      (v.data = v.data.replace(Nt, "+"))
                    : ((o = v.url.slice(f.length)),
                      v.data &&
                          (v.processData || "string" == typeof v.data) &&
                          ((f += (Tt.test(f) ? "&" : "?") + v.data),
                          delete v.data),
                      !1 === v.cache &&
                          ((f = f.replace(Dt, "$1")),
                          (o =
                              (Tt.test(f) ? "&" : "?") + "_=" + wt.guid++ + o)),
                      (v.url = f + o)),
                v.ifModified &&
                    (S.lastModified[f] &&
                        T.setRequestHeader(
                            "If-Modified-Since",
                            S.lastModified[f]
                        ),
                    S.etag[f] &&
                        T.setRequestHeader("If-None-Match", S.etag[f])),
                ((v.data && v.hasContent && !1 !== v.contentType) ||
                    t.contentType) &&
                    T.setRequestHeader("Content-Type", v.contentType),
                T.setRequestHeader(
                    "Accept",
                    v.dataTypes[0] && v.accepts[v.dataTypes[0]]
                        ? v.accepts[v.dataTypes[0]] +
                              ("*" !== v.dataTypes[0]
                                  ? ", " + Rt + "; q=0.01"
                                  : "")
                        : v.accepts["*"]
                ),
                v.headers))
                    T.setRequestHeader(i, v.headers[i]);
                if (v.beforeSend && (!1 === v.beforeSend.call(y, T, v) || h))
                    return T.abort();
                if (
                    ((u = "abort"),
                    b.add(v.complete),
                    T.done(v.success),
                    T.fail(v.error),
                    (c = Wt(Pt, v, t, T)))
                ) {
                    if (
                        ((T.readyState = 1),
                        g && m.trigger("ajaxSend", [T, v]),
                        h)
                    )
                        return T;
                    v.async &&
                        0 < v.timeout &&
                        (d = C.setTimeout(function () {
                            T.abort("timeout");
                        }, v.timeout));
                    try {
                        (h = !1), c.send(a, l);
                    } catch (e) {
                        if (h) throw e;
                        l(-1, e);
                    }
                } else l(-1, "No Transport");
                function l(e, t, n, r) {
                    var i,
                        o,
                        a,
                        s,
                        u,
                        l = t;
                    h ||
                        ((h = !0),
                        d && C.clearTimeout(d),
                        (c = void 0),
                        (p = r || ""),
                        (T.readyState = 0 < e ? 4 : 0),
                        (i = (200 <= e && e < 300) || 304 === e),
                        n &&
                            (s = (function (e, t, n) {
                                var r,
                                    i,
                                    o,
                                    a,
                                    s = e.contents,
                                    u = e.dataTypes;
                                while ("*" === u[0])
                                    u.shift(),
                                        void 0 === r &&
                                            (r =
                                                e.mimeType ||
                                                t.getResponseHeader(
                                                    "Content-Type"
                                                ));
                                if (r)
                                    for (i in s)
                                        if (s[i] && s[i].test(r)) {
                                            u.unshift(i);
                                            break;
                                        }
                                if (u[0] in n) o = u[0];
                                else {
                                    for (i in n) {
                                        if (
                                            !u[0] ||
                                            e.converters[i + " " + u[0]]
                                        ) {
                                            o = i;
                                            break;
                                        }
                                        a || (a = i);
                                    }
                                    o = o || a;
                                }
                                if (o) return o !== u[0] && u.unshift(o), n[o];
                            })(v, T, n)),
                        !i &&
                            -1 < S.inArray("script", v.dataTypes) &&
                            S.inArray("json", v.dataTypes) < 0 &&
                            (v.converters["text script"] = function () {}),
                        (s = (function (e, t, n, r) {
                            var i,
                                o,
                                a,
                                s,
                                u,
                                l = {},
                                c = e.dataTypes.slice();
                            if (c[1])
                                for (a in e.converters)
                                    l[a.toLowerCase()] = e.converters[a];
                            o = c.shift();
                            while (o)
                                if (
                                    (e.responseFields[o] &&
                                        (n[e.responseFields[o]] = t),
                                    !u &&
                                        r &&
                                        e.dataFilter &&
                                        (t = e.dataFilter(t, e.dataType)),
                                    (u = o),
                                    (o = c.shift()))
                                )
                                    if ("*" === o) o = u;
                                    else if ("*" !== u && u !== o) {
                                        if (
                                            !(a = l[u + " " + o] || l["* " + o])
                                        )
                                            for (i in l)
                                                if (
                                                    (s = i.split(" "))[1] ===
                                                        o &&
                                                    (a =
                                                        l[u + " " + s[0]] ||
                                                        l["* " + s[0]])
                                                ) {
                                                    !0 === a
                                                        ? (a = l[i])
                                                        : !0 !== l[i] &&
                                                          ((o = s[0]),
                                                          c.unshift(s[1]));
                                                    break;
                                                }
                                        if (!0 !== a)
                                            if (a && e["throws"]) t = a(t);
                                            else
                                                try {
                                                    t = a(t);
                                                } catch (e) {
                                                    return {
                                                        state: "parsererror",
                                                        error: a
                                                            ? e
                                                            : "No conversion from " +
                                                              u +
                                                              " to " +
                                                              o,
                                                    };
                                                }
                                    }
                            return { state: "success", data: t };
                        })(v, s, T, i)),
                        i
                            ? (v.ifModified &&
                                  ((u = T.getResponseHeader("Last-Modified")) &&
                                      (S.lastModified[f] = u),
                                  (u = T.getResponseHeader("etag")) &&
                                      (S.etag[f] = u)),
                              204 === e || "HEAD" === v.type
                                  ? (l = "nocontent")
                                  : 304 === e
                                  ? (l = "notmodified")
                                  : ((l = s.state),
                                    (o = s.data),
                                    (i = !(a = s.error))))
                            : ((a = l),
                              (!e && l) || ((l = "error"), e < 0 && (e = 0))),
                        (T.status = e),
                        (T.statusText = (t || l) + ""),
                        i
                            ? x.resolveWith(y, [o, l, T])
                            : x.rejectWith(y, [T, l, a]),
                        T.statusCode(w),
                        (w = void 0),
                        g &&
                            m.trigger(i ? "ajaxSuccess" : "ajaxError", [
                                T,
                                v,
                                i ? o : a,
                            ]),
                        b.fireWith(y, [T, l]),
                        g &&
                            (m.trigger("ajaxComplete", [T, v]),
                            --S.active || S.event.trigger("ajaxStop")));
                }
                return T;
            },
            getJSON: function (e, t, n) {
                return S.get(e, t, n, "json");
            },
            getScript: function (e, t) {
                return S.get(e, void 0, t, "script");
            },
        }),
        S.each(["get", "post"], function (e, i) {
            S[i] = function (e, t, n, r) {
                return (
                    m(t) && ((r = r || n), (n = t), (t = void 0)),
                    S.ajax(
                        S.extend(
                            {
                                url: e,
                                type: i,
                                dataType: r,
                                data: t,
                                success: n,
                            },
                            S.isPlainObject(e) && e
                        )
                    )
                );
            };
        }),
        S.ajaxPrefilter(function (e) {
            var t;
            for (t in e.headers)
                "content-type" === t.toLowerCase() &&
                    (e.contentType = e.headers[t] || "");
        }),
        (S._evalUrl = function (e, t, n) {
            return S.ajax({
                url: e,
                type: "GET",
                dataType: "script",
                cache: !0,
                async: !1,
                global: !1,
                converters: { "text script": function () {} },
                dataFilter: function (e) {
                    S.globalEval(e, t, n);
                },
            });
        }),
        S.fn.extend({
            wrapAll: function (e) {
                var t;
                return (
                    this[0] &&
                        (m(e) && (e = e.call(this[0])),
                        (t = S(e, this[0].ownerDocument).eq(0).clone(!0)),
                        this[0].parentNode && t.insertBefore(this[0]),
                        t
                            .map(function () {
                                var e = this;
                                while (e.firstElementChild)
                                    e = e.firstElementChild;
                                return e;
                            })
                            .append(this)),
                    this
                );
            },
            wrapInner: function (n) {
                return m(n)
                    ? this.each(function (e) {
                          S(this).wrapInner(n.call(this, e));
                      })
                    : this.each(function () {
                          var e = S(this),
                              t = e.contents();
                          t.length ? t.wrapAll(n) : e.append(n);
                      });
            },
            wrap: function (t) {
                var n = m(t);
                return this.each(function (e) {
                    S(this).wrapAll(n ? t.call(this, e) : t);
                });
            },
            unwrap: function (e) {
                return (
                    this.parent(e)
                        .not("body")
                        .each(function () {
                            S(this).replaceWith(this.childNodes);
                        }),
                    this
                );
            },
        }),
        (S.expr.pseudos.hidden = function (e) {
            return !S.expr.pseudos.visible(e);
        }),
        (S.expr.pseudos.visible = function (e) {
            return !!(
                e.offsetWidth ||
                e.offsetHeight ||
                e.getClientRects().length
            );
        }),
        (S.ajaxSettings.xhr = function () {
            try {
                return new C.XMLHttpRequest();
            } catch (e) {}
        });
    var Bt = { 0: 200, 1223: 204 },
        $t = S.ajaxSettings.xhr();
    (y.cors = !!$t && "withCredentials" in $t),
        (y.ajax = $t = !!$t),
        S.ajaxTransport(function (i) {
            var o, a;
            if (y.cors || ($t && !i.crossDomain))
                return {
                    send: function (e, t) {
                        var n,
                            r = i.xhr();
                        if (
                            (r.open(
                                i.type,
                                i.url,
                                i.async,
                                i.username,
                                i.password
                            ),
                            i.xhrFields)
                        )
                            for (n in i.xhrFields) r[n] = i.xhrFields[n];
                        for (n in (i.mimeType &&
                            r.overrideMimeType &&
                            r.overrideMimeType(i.mimeType),
                        i.crossDomain ||
                            e["X-Requested-With"] ||
                            (e["X-Requested-With"] = "XMLHttpRequest"),
                        e))
                            r.setRequestHeader(n, e[n]);
                        (o = function (e) {
                            return function () {
                                o &&
                                    ((o =
                                        a =
                                        r.onload =
                                        r.onerror =
                                        r.onabort =
                                        r.ontimeout =
                                        r.onreadystatechange =
                                            null),
                                    "abort" === e
                                        ? r.abort()
                                        : "error" === e
                                        ? "number" != typeof r.status
                                            ? t(0, "error")
                                            : t(r.status, r.statusText)
                                        : t(
                                              Bt[r.status] || r.status,
                                              r.statusText,
                                              "text" !==
                                                  (r.responseType || "text") ||
                                                  "string" !=
                                                      typeof r.responseText
                                                  ? { binary: r.response }
                                                  : { text: r.responseText },
                                              r.getAllResponseHeaders()
                                          ));
                            };
                        }),
                            (r.onload = o()),
                            (a = r.onerror = r.ontimeout = o("error")),
                            void 0 !== r.onabort
                                ? (r.onabort = a)
                                : (r.onreadystatechange = function () {
                                      4 === r.readyState &&
                                          C.setTimeout(function () {
                                              o && a();
                                          });
                                  }),
                            (o = o("abort"));
                        try {
                            r.send((i.hasContent && i.data) || null);
                        } catch (e) {
                            if (o) throw e;
                        }
                    },
                    abort: function () {
                        o && o();
                    },
                };
        }),
        S.ajaxPrefilter(function (e) {
            e.crossDomain && (e.contents.script = !1);
        }),
        S.ajaxSetup({
            accepts: {
                script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript",
            },
            contents: { script: /\b(?:java|ecma)script\b/ },
            converters: {
                "text script": function (e) {
                    return S.globalEval(e), e;
                },
            },
        }),
        S.ajaxPrefilter("script", function (e) {
            void 0 === e.cache && (e.cache = !1),
                e.crossDomain && (e.type = "GET");
        }),
        S.ajaxTransport("script", function (n) {
            var r, i;
            if (n.crossDomain || n.scriptAttrs)
                return {
                    send: function (e, t) {
                        (r = S("<script>")
                            .attr(n.scriptAttrs || {})
                            .prop({ charset: n.scriptCharset, src: n.url })
                            .on(
                                "load error",
                                (i = function (e) {
                                    r.remove(),
                                        (i = null),
                                        e &&
                                            t(
                                                "error" === e.type ? 404 : 200,
                                                e.type
                                            );
                                })
                            )),
                            E.head.appendChild(r[0]);
                    },
                    abort: function () {
                        i && i();
                    },
                };
        });
    var _t,
        zt = [],
        Ut = /(=)\?(?=&|$)|\?\?/;
    S.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function () {
            var e = zt.pop() || S.expando + "_" + wt.guid++;
            return (this[e] = !0), e;
        },
    }),
        S.ajaxPrefilter("json jsonp", function (e, t, n) {
            var r,
                i,
                o,
                a =
                    !1 !== e.jsonp &&
                    (Ut.test(e.url)
                        ? "url"
                        : "string" == typeof e.data &&
                          0 ===
                              (e.contentType || "").indexOf(
                                  "application/x-www-form-urlencoded"
                              ) &&
                          Ut.test(e.data) &&
                          "data");
            if (a || "jsonp" === e.dataTypes[0])
                return (
                    (r = e.jsonpCallback =
                        m(e.jsonpCallback)
                            ? e.jsonpCallback()
                            : e.jsonpCallback),
                    a
                        ? (e[a] = e[a].replace(Ut, "$1" + r))
                        : !1 !== e.jsonp &&
                          (e.url +=
                              (Tt.test(e.url) ? "&" : "?") + e.jsonp + "=" + r),
                    (e.converters["script json"] = function () {
                        return o || S.error(r + " was not called"), o[0];
                    }),
                    (e.dataTypes[0] = "json"),
                    (i = C[r]),
                    (C[r] = function () {
                        o = arguments;
                    }),
                    n.always(function () {
                        void 0 === i ? S(C).removeProp(r) : (C[r] = i),
                            e[r] &&
                                ((e.jsonpCallback = t.jsonpCallback),
                                zt.push(r)),
                            o && m(i) && i(o[0]),
                            (o = i = void 0);
                    }),
                    "script"
                );
        }),
        (y.createHTMLDocument =
            (((_t = E.implementation.createHTMLDocument("").body).innerHTML =
                "<form></form><form></form>"),
            2 === _t.childNodes.length)),
        (S.parseHTML = function (e, t, n) {
            return "string" != typeof e
                ? []
                : ("boolean" == typeof t && ((n = t), (t = !1)),
                  t ||
                      (y.createHTMLDocument
                          ? (((r = (t =
                                E.implementation.createHTMLDocument(
                                    ""
                                )).createElement("base")).href =
                                E.location.href),
                            t.head.appendChild(r))
                          : (t = E)),
                  (o = !n && []),
                  (i = N.exec(e))
                      ? [t.createElement(i[1])]
                      : ((i = xe([e], t, o)),
                        o && o.length && S(o).remove(),
                        S.merge([], i.childNodes)));
            var r, i, o;
        }),
        (S.fn.load = function (e, t, n) {
            var r,
                i,
                o,
                a = this,
                s = e.indexOf(" ");
            return (
                -1 < s && ((r = ht(e.slice(s))), (e = e.slice(0, s))),
                m(t)
                    ? ((n = t), (t = void 0))
                    : t && "object" == typeof t && (i = "POST"),
                0 < a.length &&
                    S.ajax({
                        url: e,
                        type: i || "GET",
                        dataType: "html",
                        data: t,
                    })
                        .done(function (e) {
                            (o = arguments),
                                a.html(
                                    r
                                        ? S("<div>")
                                              .append(S.parseHTML(e))
                                              .find(r)
                                        : e
                                );
                        })
                        .always(
                            n &&
                                function (e, t) {
                                    a.each(function () {
                                        n.apply(
                                            this,
                                            o || [e.responseText, t, e]
                                        );
                                    });
                                }
                        ),
                this
            );
        }),
        (S.expr.pseudos.animated = function (t) {
            return S.grep(S.timers, function (e) {
                return t === e.elem;
            }).length;
        }),
        (S.offset = {
            setOffset: function (e, t, n) {
                var r,
                    i,
                    o,
                    a,
                    s,
                    u,
                    l = S.css(e, "position"),
                    c = S(e),
                    f = {};
                "static" === l && (e.style.position = "relative"),
                    (s = c.offset()),
                    (o = S.css(e, "top")),
                    (u = S.css(e, "left")),
                    ("absolute" === l || "fixed" === l) &&
                    -1 < (o + u).indexOf("auto")
                        ? ((a = (r = c.position()).top), (i = r.left))
                        : ((a = parseFloat(o) || 0), (i = parseFloat(u) || 0)),
                    m(t) && (t = t.call(e, n, S.extend({}, s))),
                    null != t.top && (f.top = t.top - s.top + a),
                    null != t.left && (f.left = t.left - s.left + i),
                    "using" in t ? t.using.call(e, f) : c.css(f);
            },
        }),
        S.fn.extend({
            offset: function (t) {
                if (arguments.length)
                    return void 0 === t
                        ? this
                        : this.each(function (e) {
                              S.offset.setOffset(this, t, e);
                          });
                var e,
                    n,
                    r = this[0];
                return r
                    ? r.getClientRects().length
                        ? ((e = r.getBoundingClientRect()),
                          (n = r.ownerDocument.defaultView),
                          {
                              top: e.top + n.pageYOffset,
                              left: e.left + n.pageXOffset,
                          })
                        : { top: 0, left: 0 }
                    : void 0;
            },
            position: function () {
                if (this[0]) {
                    var e,
                        t,
                        n,
                        r = this[0],
                        i = { top: 0, left: 0 };
                    if ("fixed" === S.css(r, "position"))
                        t = r.getBoundingClientRect();
                    else {
                        (t = this.offset()),
                            (n = r.ownerDocument),
                            (e = r.offsetParent || n.documentElement);
                        while (
                            e &&
                            (e === n.body || e === n.documentElement) &&
                            "static" === S.css(e, "position")
                        )
                            e = e.parentNode;
                        e &&
                            e !== r &&
                            1 === e.nodeType &&
                            (((i = S(e).offset()).top += S.css(
                                e,
                                "borderTopWidth",
                                !0
                            )),
                            (i.left += S.css(e, "borderLeftWidth", !0)));
                    }
                    return {
                        top: t.top - i.top - S.css(r, "marginTop", !0),
                        left: t.left - i.left - S.css(r, "marginLeft", !0),
                    };
                }
            },
            offsetParent: function () {
                return this.map(function () {
                    var e = this.offsetParent;
                    while (e && "static" === S.css(e, "position"))
                        e = e.offsetParent;
                    return e || re;
                });
            },
        }),
        S.each(
            { scrollLeft: "pageXOffset", scrollTop: "pageYOffset" },
            function (t, i) {
                var o = "pageYOffset" === i;
                S.fn[t] = function (e) {
                    return $(
                        this,
                        function (e, t, n) {
                            var r;
                            if (
                                (x(e)
                                    ? (r = e)
                                    : 9 === e.nodeType && (r = e.defaultView),
                                void 0 === n)
                            )
                                return r ? r[i] : e[t];
                            r
                                ? r.scrollTo(
                                      o ? r.pageXOffset : n,
                                      o ? n : r.pageYOffset
                                  )
                                : (e[t] = n);
                        },
                        t,
                        e,
                        arguments.length
                    );
                };
            }
        ),
        S.each(["top", "left"], function (e, n) {
            S.cssHooks[n] = Fe(y.pixelPosition, function (e, t) {
                if (t)
                    return (
                        (t = We(e, n)),
                        Pe.test(t) ? S(e).position()[n] + "px" : t
                    );
            });
        }),
        S.each({ Height: "height", Width: "width" }, function (a, s) {
            S.each(
                { padding: "inner" + a, content: s, "": "outer" + a },
                function (r, o) {
                    S.fn[o] = function (e, t) {
                        var n =
                                arguments.length &&
                                (r || "boolean" != typeof e),
                            i =
                                r ||
                                (!0 === e || !0 === t ? "margin" : "border");
                        return $(
                            this,
                            function (e, t, n) {
                                var r;
                                return x(e)
                                    ? 0 === o.indexOf("outer")
                                        ? e["inner" + a]
                                        : e.document.documentElement[
                                              "client" + a
                                          ]
                                    : 9 === e.nodeType
                                    ? ((r = e.documentElement),
                                      Math.max(
                                          e.body["scroll" + a],
                                          r["scroll" + a],
                                          e.body["offset" + a],
                                          r["offset" + a],
                                          r["client" + a]
                                      ))
                                    : void 0 === n
                                    ? S.css(e, t, i)
                                    : S.style(e, t, n, i);
                            },
                            s,
                            n ? e : void 0,
                            n
                        );
                    };
                }
            );
        }),
        S.each(
            [
                "ajaxStart",
                "ajaxStop",
                "ajaxComplete",
                "ajaxError",
                "ajaxSuccess",
                "ajaxSend",
            ],
            function (e, t) {
                S.fn[t] = function (e) {
                    return this.on(t, e);
                };
            }
        ),
        S.fn.extend({
            bind: function (e, t, n) {
                return this.on(e, null, t, n);
            },
            unbind: function (e, t) {
                return this.off(e, null, t);
            },
            delegate: function (e, t, n, r) {
                return this.on(t, e, n, r);
            },
            undelegate: function (e, t, n) {
                return 1 === arguments.length
                    ? this.off(e, "**")
                    : this.off(t, e || "**", n);
            },
            hover: function (e, t) {
                return this.mouseenter(e).mouseleave(t || e);
            },
        }),
        S.each(
            "blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(
                " "
            ),
            function (e, n) {
                S.fn[n] = function (e, t) {
                    return 0 < arguments.length
                        ? this.on(n, null, e, t)
                        : this.trigger(n);
                };
            }
        );
    var Xt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    (S.proxy = function (e, t) {
        var n, r, i;
        if (("string" == typeof t && ((n = e[t]), (t = e), (e = n)), m(e)))
            return (
                (r = s.call(arguments, 2)),
                ((i = function () {
                    return e.apply(t || this, r.concat(s.call(arguments)));
                }).guid = e.guid =
                    e.guid || S.guid++),
                i
            );
    }),
        (S.holdReady = function (e) {
            e ? S.readyWait++ : S.ready(!0);
        }),
        (S.isArray = Array.isArray),
        (S.parseJSON = JSON.parse),
        (S.nodeName = A),
        (S.isFunction = m),
        (S.isWindow = x),
        (S.camelCase = X),
        (S.type = w),
        (S.now = Date.now),
        (S.isNumeric = function (e) {
            var t = S.type(e);
            return (
                ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
            );
        }),
        (S.trim = function (e) {
            return null == e ? "" : (e + "").replace(Xt, "");
        }),
        "function" == typeof define &&
            define.amd &&
            define("jquery", [], function () {
                return S;
            });
    var Vt = C.jQuery,
        Gt = C.$;
    return (
        (S.noConflict = function (e) {
            return (
                C.$ === S && (C.$ = Gt),
                e && C.jQuery === S && (C.jQuery = Vt),
                S
            );
        }),
        "undefined" == typeof e && (C.jQuery = C.$ = S),
        S
    );
});

/*
 Copyright (C) Federico Zivolo 2019 - popper.js@1.16.0
 Distributed under the MIT License (license terms are at http://opensource.org/licenses/MIT).
 */
(function (e, t) {
    "object" == typeof exports && "undefined" != typeof module
        ? (module.exports = t())
        : "function" == typeof define && define.amd
        ? define(t)
        : (e.Popper = t());
})(this, function () {
    "use strict";
    function e(e) {
        return e && "[object Function]" === {}.toString.call(e);
    }
    function t(e, t) {
        if (1 !== e.nodeType) return [];
        var o = e.ownerDocument.defaultView,
            n = o.getComputedStyle(e, null);
        return t ? n[t] : n;
    }
    function o(e) {
        return "HTML" === e.nodeName ? e : e.parentNode || e.host;
    }
    function n(e) {
        if (!e) return document.body;
        switch (e.nodeName) {
            case "HTML":
            case "BODY":
                return e.ownerDocument.body;
            case "#document":
                return e.body;
        }
        var i = t(e),
            r = i.overflow,
            p = i.overflowX,
            s = i.overflowY;
        return /(auto|scroll|overlay)/.test(r + s + p) ? e : n(o(e));
    }
    function i(e) {
        return e && e.referenceNode ? e.referenceNode : e;
    }
    function r(e) {
        return 11 === e ? re : 10 === e ? pe : re || pe;
    }
    function p(e) {
        if (!e) return document.documentElement;
        for (
            var o = r(10) ? document.body : null, n = e.offsetParent || null;
            n === o && e.nextElementSibling;

        )
            n = (e = e.nextElementSibling).offsetParent;
        var i = n && n.nodeName;
        return i && "BODY" !== i && "HTML" !== i
            ? -1 !== ["TH", "TD", "TABLE"].indexOf(n.nodeName) &&
              "static" === t(n, "position")
                ? p(n)
                : n
            : e
            ? e.ownerDocument.documentElement
            : document.documentElement;
    }
    function s(e) {
        var t = e.nodeName;
        return "BODY" !== t && ("HTML" === t || p(e.firstElementChild) === e);
    }
    function d(e) {
        return null === e.parentNode ? e : d(e.parentNode);
    }
    function a(e, t) {
        if (!e || !e.nodeType || !t || !t.nodeType)
            return document.documentElement;
        var o = e.compareDocumentPosition(t) & Node.DOCUMENT_POSITION_FOLLOWING,
            n = o ? e : t,
            i = o ? t : e,
            r = document.createRange();
        r.setStart(n, 0), r.setEnd(i, 0);
        var l = r.commonAncestorContainer;
        if ((e !== l && t !== l) || n.contains(i)) return s(l) ? l : p(l);
        var f = d(e);
        return f.host ? a(f.host, t) : a(e, d(t).host);
    }
    function l(e) {
        var t =
                1 < arguments.length && void 0 !== arguments[1]
                    ? arguments[1]
                    : "top",
            o = "top" === t ? "scrollTop" : "scrollLeft",
            n = e.nodeName;
        if ("BODY" === n || "HTML" === n) {
            var i = e.ownerDocument.documentElement,
                r = e.ownerDocument.scrollingElement || i;
            return r[o];
        }
        return e[o];
    }
    function f(e, t) {
        var o = 2 < arguments.length && void 0 !== arguments[2] && arguments[2],
            n = l(t, "top"),
            i = l(t, "left"),
            r = o ? -1 : 1;
        return (
            (e.top += n * r),
            (e.bottom += n * r),
            (e.left += i * r),
            (e.right += i * r),
            e
        );
    }
    function m(e, t) {
        var o = "x" === t ? "Left" : "Top",
            n = "Left" == o ? "Right" : "Bottom";
        return (
            parseFloat(e["border" + o + "Width"], 10) +
            parseFloat(e["border" + n + "Width"], 10)
        );
    }
    function h(e, t, o, n) {
        return ee(
            t["offset" + e],
            t["scroll" + e],
            o["client" + e],
            o["offset" + e],
            o["scroll" + e],
            r(10)
                ? parseInt(o["offset" + e]) +
                      parseInt(
                          n["margin" + ("Height" === e ? "Top" : "Left")]
                      ) +
                      parseInt(
                          n["margin" + ("Height" === e ? "Bottom" : "Right")]
                      )
                : 0
        );
    }
    function c(e) {
        var t = e.body,
            o = e.documentElement,
            n = r(10) && getComputedStyle(o);
        return { height: h("Height", t, o, n), width: h("Width", t, o, n) };
    }
    function g(e) {
        return le({}, e, { right: e.left + e.width, bottom: e.top + e.height });
    }
    function u(e) {
        var o = {};
        try {
            if (r(10)) {
                o = e.getBoundingClientRect();
                var n = l(e, "top"),
                    i = l(e, "left");
                (o.top += n), (o.left += i), (o.bottom += n), (o.right += i);
            } else o = e.getBoundingClientRect();
        } catch (t) {}
        var p = {
                left: o.left,
                top: o.top,
                width: o.right - o.left,
                height: o.bottom - o.top,
            },
            s = "HTML" === e.nodeName ? c(e.ownerDocument) : {},
            d = s.width || e.clientWidth || p.width,
            a = s.height || e.clientHeight || p.height,
            f = e.offsetWidth - d,
            h = e.offsetHeight - a;
        if (f || h) {
            var u = t(e);
            (f -= m(u, "x")), (h -= m(u, "y")), (p.width -= f), (p.height -= h);
        }
        return g(p);
    }
    function b(e, o) {
        var i = 2 < arguments.length && void 0 !== arguments[2] && arguments[2],
            p = r(10),
            s = "HTML" === o.nodeName,
            d = u(e),
            a = u(o),
            l = n(e),
            m = t(o),
            h = parseFloat(m.borderTopWidth, 10),
            c = parseFloat(m.borderLeftWidth, 10);
        i && s && ((a.top = ee(a.top, 0)), (a.left = ee(a.left, 0)));
        var b = g({
            top: d.top - a.top - h,
            left: d.left - a.left - c,
            width: d.width,
            height: d.height,
        });
        if (((b.marginTop = 0), (b.marginLeft = 0), !p && s)) {
            var w = parseFloat(m.marginTop, 10),
                y = parseFloat(m.marginLeft, 10);
            (b.top -= h - w),
                (b.bottom -= h - w),
                (b.left -= c - y),
                (b.right -= c - y),
                (b.marginTop = w),
                (b.marginLeft = y);
        }
        return (
            (p && !i ? o.contains(l) : o === l && "BODY" !== l.nodeName) &&
                (b = f(b, o)),
            b
        );
    }
    function w(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] && arguments[1],
            o = e.ownerDocument.documentElement,
            n = b(e, o),
            i = ee(o.clientWidth, window.innerWidth || 0),
            r = ee(o.clientHeight, window.innerHeight || 0),
            p = t ? 0 : l(o),
            s = t ? 0 : l(o, "left"),
            d = {
                top: p - n.top + n.marginTop,
                left: s - n.left + n.marginLeft,
                width: i,
                height: r,
            };
        return g(d);
    }
    function y(e) {
        var n = e.nodeName;
        if ("BODY" === n || "HTML" === n) return !1;
        if ("fixed" === t(e, "position")) return !0;
        var i = o(e);
        return !!i && y(i);
    }
    function E(e) {
        if (!e || !e.parentElement || r()) return document.documentElement;
        for (var o = e.parentElement; o && "none" === t(o, "transform"); )
            o = o.parentElement;
        return o || document.documentElement;
    }
    function v(e, t, r, p) {
        var s = 4 < arguments.length && void 0 !== arguments[4] && arguments[4],
            d = { top: 0, left: 0 },
            l = s ? E(e) : a(e, i(t));
        if ("viewport" === p) d = w(l, s);
        else {
            var f;
            "scrollParent" === p
                ? ((f = n(o(t))),
                  "BODY" === f.nodeName &&
                      (f = e.ownerDocument.documentElement))
                : "window" === p
                ? (f = e.ownerDocument.documentElement)
                : (f = p);
            var m = b(f, l, s);
            if ("HTML" === f.nodeName && !y(l)) {
                var h = c(e.ownerDocument),
                    g = h.height,
                    u = h.width;
                (d.top += m.top - m.marginTop),
                    (d.bottom = g + m.top),
                    (d.left += m.left - m.marginLeft),
                    (d.right = u + m.left);
            } else d = m;
        }
        r = r || 0;
        var v = "number" == typeof r;
        return (
            (d.left += v ? r : r.left || 0),
            (d.top += v ? r : r.top || 0),
            (d.right -= v ? r : r.right || 0),
            (d.bottom -= v ? r : r.bottom || 0),
            d
        );
    }
    function x(e) {
        var t = e.width,
            o = e.height;
        return t * o;
    }
    function O(e, t, o, n, i) {
        var r =
            5 < arguments.length && void 0 !== arguments[5] ? arguments[5] : 0;
        if (-1 === e.indexOf("auto")) return e;
        var p = v(o, n, r, i),
            s = {
                top: { width: p.width, height: t.top - p.top },
                right: { width: p.right - t.right, height: p.height },
                bottom: { width: p.width, height: p.bottom - t.bottom },
                left: { width: t.left - p.left, height: p.height },
            },
            d = Object.keys(s)
                .map(function (e) {
                    return le({ key: e }, s[e], { area: x(s[e]) });
                })
                .sort(function (e, t) {
                    return t.area - e.area;
                }),
            a = d.filter(function (e) {
                var t = e.width,
                    n = e.height;
                return t >= o.clientWidth && n >= o.clientHeight;
            }),
            l = 0 < a.length ? a[0].key : d[0].key,
            f = e.split("-")[1];
        return l + (f ? "-" + f : "");
    }
    function L(e, t, o) {
        var n =
                3 < arguments.length && void 0 !== arguments[3]
                    ? arguments[3]
                    : null,
            r = n ? E(t) : a(t, i(o));
        return b(o, r, n);
    }
    function S(e) {
        var t = e.ownerDocument.defaultView,
            o = t.getComputedStyle(e),
            n = parseFloat(o.marginTop || 0) + parseFloat(o.marginBottom || 0),
            i = parseFloat(o.marginLeft || 0) + parseFloat(o.marginRight || 0),
            r = { width: e.offsetWidth + i, height: e.offsetHeight + n };
        return r;
    }
    function T(e) {
        var t = { left: "right", right: "left", bottom: "top", top: "bottom" };
        return e.replace(/left|right|bottom|top/g, function (e) {
            return t[e];
        });
    }
    function C(e, t, o) {
        o = o.split("-")[0];
        var n = S(e),
            i = { width: n.width, height: n.height },
            r = -1 !== ["right", "left"].indexOf(o),
            p = r ? "top" : "left",
            s = r ? "left" : "top",
            d = r ? "height" : "width",
            a = r ? "width" : "height";
        return (
            (i[p] = t[p] + t[d] / 2 - n[d] / 2),
            (i[s] = o === s ? t[s] - n[a] : t[T(s)]),
            i
        );
    }
    function D(e, t) {
        return Array.prototype.find ? e.find(t) : e.filter(t)[0];
    }
    function N(e, t, o) {
        if (Array.prototype.findIndex)
            return e.findIndex(function (e) {
                return e[t] === o;
            });
        var n = D(e, function (e) {
            return e[t] === o;
        });
        return e.indexOf(n);
    }
    function P(t, o, n) {
        var i = void 0 === n ? t : t.slice(0, N(t, "name", n));
        return (
            i.forEach(function (t) {
                t["function"] &&
                    console.warn(
                        "`modifier.function` is deprecated, use `modifier.fn`!"
                    );
                var n = t["function"] || t.fn;
                t.enabled &&
                    e(n) &&
                    ((o.offsets.popper = g(o.offsets.popper)),
                    (o.offsets.reference = g(o.offsets.reference)),
                    (o = n(o, t)));
            }),
            o
        );
    }
    function k() {
        if (!this.state.isDestroyed) {
            var e = {
                instance: this,
                styles: {},
                arrowStyles: {},
                attributes: {},
                flipped: !1,
                offsets: {},
            };
            (e.offsets.reference = L(
                this.state,
                this.popper,
                this.reference,
                this.options.positionFixed
            )),
                (e.placement = O(
                    this.options.placement,
                    e.offsets.reference,
                    this.popper,
                    this.reference,
                    this.options.modifiers.flip.boundariesElement,
                    this.options.modifiers.flip.padding
                )),
                (e.originalPlacement = e.placement),
                (e.positionFixed = this.options.positionFixed),
                (e.offsets.popper = C(
                    this.popper,
                    e.offsets.reference,
                    e.placement
                )),
                (e.offsets.popper.position = this.options.positionFixed
                    ? "fixed"
                    : "absolute"),
                (e = P(this.modifiers, e)),
                this.state.isCreated
                    ? this.options.onUpdate(e)
                    : ((this.state.isCreated = !0), this.options.onCreate(e));
        }
    }
    function W(e, t) {
        return e.some(function (e) {
            var o = e.name,
                n = e.enabled;
            return n && o === t;
        });
    }
    function B(e) {
        for (
            var t = [!1, "ms", "Webkit", "Moz", "O"],
                o = e.charAt(0).toUpperCase() + e.slice(1),
                n = 0;
            n < t.length;
            n++
        ) {
            var i = t[n],
                r = i ? "" + i + o : e;
            if ("undefined" != typeof document.body.style[r]) return r;
        }
        return null;
    }
    function H() {
        return (
            (this.state.isDestroyed = !0),
            W(this.modifiers, "applyStyle") &&
                (this.popper.removeAttribute("x-placement"),
                (this.popper.style.position = ""),
                (this.popper.style.top = ""),
                (this.popper.style.left = ""),
                (this.popper.style.right = ""),
                (this.popper.style.bottom = ""),
                (this.popper.style.willChange = ""),
                (this.popper.style[B("transform")] = "")),
            this.disableEventListeners(),
            this.options.removeOnDestroy &&
                this.popper.parentNode.removeChild(this.popper),
            this
        );
    }
    function A(e) {
        var t = e.ownerDocument;
        return t ? t.defaultView : window;
    }
    function M(e, t, o, i) {
        var r = "BODY" === e.nodeName,
            p = r ? e.ownerDocument.defaultView : e;
        p.addEventListener(t, o, { passive: !0 }),
            r || M(n(p.parentNode), t, o, i),
            i.push(p);
    }
    function F(e, t, o, i) {
        (o.updateBound = i),
            A(e).addEventListener("resize", o.updateBound, { passive: !0 });
        var r = n(e);
        return (
            M(r, "scroll", o.updateBound, o.scrollParents),
            (o.scrollElement = r),
            (o.eventsEnabled = !0),
            o
        );
    }
    function I() {
        this.state.eventsEnabled ||
            (this.state = F(
                this.reference,
                this.options,
                this.state,
                this.scheduleUpdate
            ));
    }
    function R(e, t) {
        return (
            A(e).removeEventListener("resize", t.updateBound),
            t.scrollParents.forEach(function (e) {
                e.removeEventListener("scroll", t.updateBound);
            }),
            (t.updateBound = null),
            (t.scrollParents = []),
            (t.scrollElement = null),
            (t.eventsEnabled = !1),
            t
        );
    }
    function U() {
        this.state.eventsEnabled &&
            (cancelAnimationFrame(this.scheduleUpdate),
            (this.state = R(this.reference, this.state)));
    }
    function Y(e) {
        return "" !== e && !isNaN(parseFloat(e)) && isFinite(e);
    }
    function V(e, t) {
        Object.keys(t).forEach(function (o) {
            var n = "";
            -1 !==
                ["width", "height", "top", "right", "bottom", "left"].indexOf(
                    o
                ) &&
                Y(t[o]) &&
                (n = "px"),
                (e.style[o] = t[o] + n);
        });
    }
    function j(e, t) {
        Object.keys(t).forEach(function (o) {
            var n = t[o];
            !1 === n ? e.removeAttribute(o) : e.setAttribute(o, t[o]);
        });
    }
    function q(e, t) {
        var o = e.offsets,
            n = o.popper,
            i = o.reference,
            r = $,
            p = function (e) {
                return e;
            },
            s = r(i.width),
            d = r(n.width),
            a = -1 !== ["left", "right"].indexOf(e.placement),
            l = -1 !== e.placement.indexOf("-"),
            f = t ? (a || l || s % 2 == d % 2 ? r : Z) : p,
            m = t ? r : p;
        return {
            left: f(1 == s % 2 && 1 == d % 2 && !l && t ? n.left - 1 : n.left),
            top: m(n.top),
            bottom: m(n.bottom),
            right: f(n.right),
        };
    }
    function K(e, t, o) {
        var n = D(e, function (e) {
                var o = e.name;
                return o === t;
            }),
            i =
                !!n &&
                e.some(function (e) {
                    return e.name === o && e.enabled && e.order < n.order;
                });
        if (!i) {
            var r = "`" + t + "`";
            console.warn(
                "`" +
                    o +
                    "`" +
                    " modifier is required by " +
                    r +
                    " modifier in order to work, be sure to include it before " +
                    r +
                    "!"
            );
        }
        return i;
    }
    function z(e) {
        return "end" === e ? "start" : "start" === e ? "end" : e;
    }
    function G(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] && arguments[1],
            o = he.indexOf(e),
            n = he.slice(o + 1).concat(he.slice(0, o));
        return t ? n.reverse() : n;
    }
    function _(e, t, o, n) {
        var i = e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),
            r = +i[1],
            p = i[2];
        if (!r) return e;
        if (0 === p.indexOf("%")) {
            var s;
            switch (p) {
                case "%p":
                    s = o;
                    break;
                case "%":
                case "%r":
                default:
                    s = n;
            }
            var d = g(s);
            return (d[t] / 100) * r;
        }
        if ("vh" === p || "vw" === p) {
            var a;
            return (
                (a =
                    "vh" === p
                        ? ee(
                              document.documentElement.clientHeight,
                              window.innerHeight || 0
                          )
                        : ee(
                              document.documentElement.clientWidth,
                              window.innerWidth || 0
                          )),
                (a / 100) * r
            );
        }
        return r;
    }
    function X(e, t, o, n) {
        var i = [0, 0],
            r = -1 !== ["right", "left"].indexOf(n),
            p = e.split(/(\+|\-)/).map(function (e) {
                return e.trim();
            }),
            s = p.indexOf(
                D(p, function (e) {
                    return -1 !== e.search(/,|\s/);
                })
            );
        p[s] &&
            -1 === p[s].indexOf(",") &&
            console.warn(
                "Offsets separated by white space(s) are deprecated, use a comma (,) instead."
            );
        var d = /\s*,\s*|\s+/,
            a =
                -1 === s
                    ? [p]
                    : [
                          p.slice(0, s).concat([p[s].split(d)[0]]),
                          [p[s].split(d)[1]].concat(p.slice(s + 1)),
                      ];
        return (
            (a = a.map(function (e, n) {
                var i = (1 === n ? !r : r) ? "height" : "width",
                    p = !1;
                return e
                    .reduce(function (e, t) {
                        return "" === e[e.length - 1] &&
                            -1 !== ["+", "-"].indexOf(t)
                            ? ((e[e.length - 1] = t), (p = !0), e)
                            : p
                            ? ((e[e.length - 1] += t), (p = !1), e)
                            : e.concat(t);
                    }, [])
                    .map(function (e) {
                        return _(e, i, t, o);
                    });
            })),
            a.forEach(function (e, t) {
                e.forEach(function (o, n) {
                    Y(o) && (i[t] += o * ("-" === e[n - 1] ? -1 : 1));
                });
            }),
            i
        );
    }
    function J(e, t) {
        var o,
            n = t.offset,
            i = e.placement,
            r = e.offsets,
            p = r.popper,
            s = r.reference,
            d = i.split("-")[0];
        return (
            (o = Y(+n) ? [+n, 0] : X(n, p, s, d)),
            "left" === d
                ? ((p.top += o[0]), (p.left -= o[1]))
                : "right" === d
                ? ((p.top += o[0]), (p.left += o[1]))
                : "top" === d
                ? ((p.left += o[0]), (p.top -= o[1]))
                : "bottom" === d && ((p.left += o[0]), (p.top += o[1])),
            (e.popper = p),
            e
        );
    }
    var Q = Math.min,
        Z = Math.floor,
        $ = Math.round,
        ee = Math.max,
        te =
            "undefined" != typeof window &&
            "undefined" != typeof document &&
            "undefined" != typeof navigator,
        oe = (function () {
            for (
                var e = ["Edge", "Trident", "Firefox"], t = 0;
                t < e.length;
                t += 1
            )
                if (te && 0 <= navigator.userAgent.indexOf(e[t])) return 1;
            return 0;
        })(),
        ne = te && window.Promise,
        ie = ne
            ? function (e) {
                  var t = !1;
                  return function () {
                      t ||
                          ((t = !0),
                          window.Promise.resolve().then(function () {
                              (t = !1), e();
                          }));
                  };
              }
            : function (e) {
                  var t = !1;
                  return function () {
                      t ||
                          ((t = !0),
                          setTimeout(function () {
                              (t = !1), e();
                          }, oe));
                  };
              },
        re = te && !!(window.MSInputMethodContext && document.documentMode),
        pe = te && /MSIE 10/.test(navigator.userAgent),
        se = function (e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
        },
        de = (function () {
            function e(e, t) {
                for (var o, n = 0; n < t.length; n++)
                    (o = t[n]),
                        (o.enumerable = o.enumerable || !1),
                        (o.configurable = !0),
                        "value" in o && (o.writable = !0),
                        Object.defineProperty(e, o.key, o);
            }
            return function (t, o, n) {
                return o && e(t.prototype, o), n && e(t, n), t;
            };
        })(),
        ae = function (e, t, o) {
            return (
                t in e
                    ? Object.defineProperty(e, t, {
                          value: o,
                          enumerable: !0,
                          configurable: !0,
                          writable: !0,
                      })
                    : (e[t] = o),
                e
            );
        },
        le =
            Object.assign ||
            function (e) {
                for (var t, o = 1; o < arguments.length; o++)
                    for (var n in ((t = arguments[o]), t))
                        Object.prototype.hasOwnProperty.call(t, n) &&
                            (e[n] = t[n]);
                return e;
            },
        fe = te && /Firefox/i.test(navigator.userAgent),
        me = [
            "auto-start",
            "auto",
            "auto-end",
            "top-start",
            "top",
            "top-end",
            "right-start",
            "right",
            "right-end",
            "bottom-end",
            "bottom",
            "bottom-start",
            "left-end",
            "left",
            "left-start",
        ],
        he = me.slice(3),
        ce = {
            FLIP: "flip",
            CLOCKWISE: "clockwise",
            COUNTERCLOCKWISE: "counterclockwise",
        },
        ge = (function () {
            function t(o, n) {
                var i = this,
                    r =
                        2 < arguments.length && void 0 !== arguments[2]
                            ? arguments[2]
                            : {};
                se(this, t),
                    (this.scheduleUpdate = function () {
                        return requestAnimationFrame(i.update);
                    }),
                    (this.update = ie(this.update.bind(this))),
                    (this.options = le({}, t.Defaults, r)),
                    (this.state = {
                        isDestroyed: !1,
                        isCreated: !1,
                        scrollParents: [],
                    }),
                    (this.reference = o && o.jquery ? o[0] : o),
                    (this.popper = n && n.jquery ? n[0] : n),
                    (this.options.modifiers = {}),
                    Object.keys(
                        le({}, t.Defaults.modifiers, r.modifiers)
                    ).forEach(function (e) {
                        i.options.modifiers[e] = le(
                            {},
                            t.Defaults.modifiers[e] || {},
                            r.modifiers ? r.modifiers[e] : {}
                        );
                    }),
                    (this.modifiers = Object.keys(this.options.modifiers)
                        .map(function (e) {
                            return le({ name: e }, i.options.modifiers[e]);
                        })
                        .sort(function (e, t) {
                            return e.order - t.order;
                        })),
                    this.modifiers.forEach(function (t) {
                        t.enabled &&
                            e(t.onLoad) &&
                            t.onLoad(
                                i.reference,
                                i.popper,
                                i.options,
                                t,
                                i.state
                            );
                    }),
                    this.update();
                var p = this.options.eventsEnabled;
                p && this.enableEventListeners(),
                    (this.state.eventsEnabled = p);
            }
            return (
                de(t, [
                    {
                        key: "update",
                        value: function () {
                            return k.call(this);
                        },
                    },
                    {
                        key: "destroy",
                        value: function () {
                            return H.call(this);
                        },
                    },
                    {
                        key: "enableEventListeners",
                        value: function () {
                            return I.call(this);
                        },
                    },
                    {
                        key: "disableEventListeners",
                        value: function () {
                            return U.call(this);
                        },
                    },
                ]),
                t
            );
        })();
    return (
        (ge.Utils = (
            "undefined" == typeof window ? global : window
        ).PopperUtils),
        (ge.placements = me),
        (ge.Defaults = {
            placement: "bottom",
            positionFixed: !1,
            eventsEnabled: !0,
            removeOnDestroy: !1,
            onCreate: function () {},
            onUpdate: function () {},
            modifiers: {
                shift: {
                    order: 100,
                    enabled: !0,
                    fn: function (e) {
                        var t = e.placement,
                            o = t.split("-")[0],
                            n = t.split("-")[1];
                        if (n) {
                            var i = e.offsets,
                                r = i.reference,
                                p = i.popper,
                                s = -1 !== ["bottom", "top"].indexOf(o),
                                d = s ? "left" : "top",
                                a = s ? "width" : "height",
                                l = {
                                    start: ae({}, d, r[d]),
                                    end: ae({}, d, r[d] + r[a] - p[a]),
                                };
                            e.offsets.popper = le({}, p, l[n]);
                        }
                        return e;
                    },
                },
                offset: { order: 200, enabled: !0, fn: J, offset: 0 },
                preventOverflow: {
                    order: 300,
                    enabled: !0,
                    fn: function (e, t) {
                        var o = t.boundariesElement || p(e.instance.popper);
                        e.instance.reference === o && (o = p(o));
                        var n = B("transform"),
                            i = e.instance.popper.style,
                            r = i.top,
                            s = i.left,
                            d = i[n];
                        (i.top = ""), (i.left = ""), (i[n] = "");
                        var a = v(
                            e.instance.popper,
                            e.instance.reference,
                            t.padding,
                            o,
                            e.positionFixed
                        );
                        (i.top = r),
                            (i.left = s),
                            (i[n] = d),
                            (t.boundaries = a);
                        var l = t.priority,
                            f = e.offsets.popper,
                            m = {
                                primary: function (e) {
                                    var o = f[e];
                                    return (
                                        f[e] < a[e] &&
                                            !t.escapeWithReference &&
                                            (o = ee(f[e], a[e])),
                                        ae({}, e, o)
                                    );
                                },
                                secondary: function (e) {
                                    var o = "right" === e ? "left" : "top",
                                        n = f[o];
                                    return (
                                        f[e] > a[e] &&
                                            !t.escapeWithReference &&
                                            (n = Q(
                                                f[o],
                                                a[e] -
                                                    ("right" === e
                                                        ? f.width
                                                        : f.height)
                                            )),
                                        ae({}, o, n)
                                    );
                                },
                            };
                        return (
                            l.forEach(function (e) {
                                var t =
                                    -1 === ["left", "top"].indexOf(e)
                                        ? "secondary"
                                        : "primary";
                                f = le({}, f, m[t](e));
                            }),
                            (e.offsets.popper = f),
                            e
                        );
                    },
                    priority: ["left", "right", "top", "bottom"],
                    padding: 5,
                    boundariesElement: "scrollParent",
                },
                keepTogether: {
                    order: 400,
                    enabled: !0,
                    fn: function (e) {
                        var t = e.offsets,
                            o = t.popper,
                            n = t.reference,
                            i = e.placement.split("-")[0],
                            r = Z,
                            p = -1 !== ["top", "bottom"].indexOf(i),
                            s = p ? "right" : "bottom",
                            d = p ? "left" : "top",
                            a = p ? "width" : "height";
                        return (
                            o[s] < r(n[d]) &&
                                (e.offsets.popper[d] = r(n[d]) - o[a]),
                            o[d] > r(n[s]) && (e.offsets.popper[d] = r(n[s])),
                            e
                        );
                    },
                },
                arrow: {
                    order: 500,
                    enabled: !0,
                    fn: function (e, o) {
                        var n;
                        if (!K(e.instance.modifiers, "arrow", "keepTogether"))
                            return e;
                        var i = o.element;
                        if ("string" == typeof i) {
                            if (((i = e.instance.popper.querySelector(i)), !i))
                                return e;
                        } else if (!e.instance.popper.contains(i))
                            return (
                                console.warn(
                                    "WARNING: `arrow.element` must be child of its popper element!"
                                ),
                                e
                            );
                        var r = e.placement.split("-")[0],
                            p = e.offsets,
                            s = p.popper,
                            d = p.reference,
                            a = -1 !== ["left", "right"].indexOf(r),
                            l = a ? "height" : "width",
                            f = a ? "Top" : "Left",
                            m = f.toLowerCase(),
                            h = a ? "left" : "top",
                            c = a ? "bottom" : "right",
                            u = S(i)[l];
                        d[c] - u < s[m] &&
                            (e.offsets.popper[m] -= s[m] - (d[c] - u)),
                            d[m] + u > s[c] &&
                                (e.offsets.popper[m] += d[m] + u - s[c]),
                            (e.offsets.popper = g(e.offsets.popper));
                        var b = d[m] + d[l] / 2 - u / 2,
                            w = t(e.instance.popper),
                            y = parseFloat(w["margin" + f], 10),
                            E = parseFloat(w["border" + f + "Width"], 10),
                            v = b - e.offsets.popper[m] - y - E;
                        return (
                            (v = ee(Q(s[l] - u, v), 0)),
                            (e.arrowElement = i),
                            (e.offsets.arrow =
                                ((n = {}), ae(n, m, $(v)), ae(n, h, ""), n)),
                            e
                        );
                    },
                    element: "[x-arrow]",
                },
                flip: {
                    order: 600,
                    enabled: !0,
                    fn: function (e, t) {
                        if (W(e.instance.modifiers, "inner")) return e;
                        if (e.flipped && e.placement === e.originalPlacement)
                            return e;
                        var o = v(
                                e.instance.popper,
                                e.instance.reference,
                                t.padding,
                                t.boundariesElement,
                                e.positionFixed
                            ),
                            n = e.placement.split("-")[0],
                            i = T(n),
                            r = e.placement.split("-")[1] || "",
                            p = [];
                        switch (t.behavior) {
                            case ce.FLIP:
                                p = [n, i];
                                break;
                            case ce.CLOCKWISE:
                                p = G(n);
                                break;
                            case ce.COUNTERCLOCKWISE:
                                p = G(n, !0);
                                break;
                            default:
                                p = t.behavior;
                        }
                        return (
                            p.forEach(function (s, d) {
                                if (n !== s || p.length === d + 1) return e;
                                (n = e.placement.split("-")[0]), (i = T(n));
                                var a = e.offsets.popper,
                                    l = e.offsets.reference,
                                    f = Z,
                                    m =
                                        ("left" === n &&
                                            f(a.right) > f(l.left)) ||
                                        ("right" === n &&
                                            f(a.left) < f(l.right)) ||
                                        ("top" === n &&
                                            f(a.bottom) > f(l.top)) ||
                                        ("bottom" === n &&
                                            f(a.top) < f(l.bottom)),
                                    h = f(a.left) < f(o.left),
                                    c = f(a.right) > f(o.right),
                                    g = f(a.top) < f(o.top),
                                    u = f(a.bottom) > f(o.bottom),
                                    b =
                                        ("left" === n && h) ||
                                        ("right" === n && c) ||
                                        ("top" === n && g) ||
                                        ("bottom" === n && u),
                                    w = -1 !== ["top", "bottom"].indexOf(n),
                                    y =
                                        !!t.flipVariations &&
                                        ((w && "start" === r && h) ||
                                            (w && "end" === r && c) ||
                                            (!w && "start" === r && g) ||
                                            (!w && "end" === r && u)),
                                    E =
                                        !!t.flipVariationsByContent &&
                                        ((w && "start" === r && c) ||
                                            (w && "end" === r && h) ||
                                            (!w && "start" === r && u) ||
                                            (!w && "end" === r && g)),
                                    v = y || E;
                                (m || b || v) &&
                                    ((e.flipped = !0),
                                    (m || b) && (n = p[d + 1]),
                                    v && (r = z(r)),
                                    (e.placement = n + (r ? "-" + r : "")),
                                    (e.offsets.popper = le(
                                        {},
                                        e.offsets.popper,
                                        C(
                                            e.instance.popper,
                                            e.offsets.reference,
                                            e.placement
                                        )
                                    )),
                                    (e = P(e.instance.modifiers, e, "flip")));
                            }),
                            e
                        );
                    },
                    behavior: "flip",
                    padding: 5,
                    boundariesElement: "viewport",
                    flipVariations: !1,
                    flipVariationsByContent: !1,
                },
                inner: {
                    order: 700,
                    enabled: !1,
                    fn: function (e) {
                        var t = e.placement,
                            o = t.split("-")[0],
                            n = e.offsets,
                            i = n.popper,
                            r = n.reference,
                            p = -1 !== ["left", "right"].indexOf(o),
                            s = -1 === ["top", "left"].indexOf(o);
                        return (
                            (i[p ? "left" : "top"] =
                                r[o] - (s ? i[p ? "width" : "height"] : 0)),
                            (e.placement = T(t)),
                            (e.offsets.popper = g(i)),
                            e
                        );
                    },
                },
                hide: {
                    order: 800,
                    enabled: !0,
                    fn: function (e) {
                        if (!K(e.instance.modifiers, "hide", "preventOverflow"))
                            return e;
                        var t = e.offsets.reference,
                            o = D(e.instance.modifiers, function (e) {
                                return "preventOverflow" === e.name;
                            }).boundaries;
                        if (
                            t.bottom < o.top ||
                            t.left > o.right ||
                            t.top > o.bottom ||
                            t.right < o.left
                        ) {
                            if (!0 === e.hide) return e;
                            (e.hide = !0),
                                (e.attributes["x-out-of-boundaries"] = "");
                        } else {
                            if (!1 === e.hide) return e;
                            (e.hide = !1),
                                (e.attributes["x-out-of-boundaries"] = !1);
                        }
                        return e;
                    },
                },
                computeStyle: {
                    order: 850,
                    enabled: !0,
                    fn: function (e, t) {
                        var o = t.x,
                            n = t.y,
                            i = e.offsets.popper,
                            r = D(e.instance.modifiers, function (e) {
                                return "applyStyle" === e.name;
                            }).gpuAcceleration;
                        void 0 !== r &&
                            console.warn(
                                "WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!"
                            );
                        var s,
                            d,
                            a = void 0 === r ? t.gpuAcceleration : r,
                            l = p(e.instance.popper),
                            f = u(l),
                            m = { position: i.position },
                            h = q(e, 2 > window.devicePixelRatio || !fe),
                            c = "bottom" === o ? "top" : "bottom",
                            g = "right" === n ? "left" : "right",
                            b = B("transform");
                        if (
                            ((d =
                                "bottom" == c
                                    ? "HTML" === l.nodeName
                                        ? -l.clientHeight + h.bottom
                                        : -f.height + h.bottom
                                    : h.top),
                            (s =
                                "right" == g
                                    ? "HTML" === l.nodeName
                                        ? -l.clientWidth + h.right
                                        : -f.width + h.right
                                    : h.left),
                            a && b)
                        )
                            (m[b] = "translate3d(" + s + "px, " + d + "px, 0)"),
                                (m[c] = 0),
                                (m[g] = 0),
                                (m.willChange = "transform");
                        else {
                            var w = "bottom" == c ? -1 : 1,
                                y = "right" == g ? -1 : 1;
                            (m[c] = d * w),
                                (m[g] = s * y),
                                (m.willChange = c + ", " + g);
                        }
                        var E = { "x-placement": e.placement };
                        return (
                            (e.attributes = le({}, E, e.attributes)),
                            (e.styles = le({}, m, e.styles)),
                            (e.arrowStyles = le(
                                {},
                                e.offsets.arrow,
                                e.arrowStyles
                            )),
                            e
                        );
                    },
                    gpuAcceleration: !0,
                    x: "bottom",
                    y: "right",
                },
                applyStyle: {
                    order: 900,
                    enabled: !0,
                    fn: function (e) {
                        return (
                            V(e.instance.popper, e.styles),
                            j(e.instance.popper, e.attributes),
                            e.arrowElement &&
                                Object.keys(e.arrowStyles).length &&
                                V(e.arrowElement, e.arrowStyles),
                            e
                        );
                    },
                    onLoad: function (e, t, o, n, i) {
                        var r = L(i, t, e, o.positionFixed),
                            p = O(
                                o.placement,
                                r,
                                t,
                                e,
                                o.modifiers.flip.boundariesElement,
                                o.modifiers.flip.padding
                            );
                        return (
                            t.setAttribute("x-placement", p),
                            V(t, {
                                position: o.positionFixed
                                    ? "fixed"
                                    : "absolute",
                            }),
                            o
                        );
                    },
                    gpuAcceleration: void 0,
                },
            },
        }),
        ge
    );
});
//# sourceMappingURL=popper.min.js.map\

/*!
 * Bootstrap v4.5.0 (https://getbootstrap.com/)
 * Copyright 2011-2020 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
!(function (t, e) {
    "object" == typeof exports && "undefined" != typeof module
        ? e(exports, require("jquery"), require("popper.js"))
        : "function" == typeof define && define.amd
        ? define(["exports", "jquery", "popper.js"], e)
        : e(((t = t || self).bootstrap = {}), t.jQuery, t.Popper);
})(this, function (t, e, n) {
    "use strict";
    function i(t, e) {
        for (var n = 0; n < e.length; n++) {
            var i = e[n];
            (i.enumerable = i.enumerable || !1),
                (i.configurable = !0),
                "value" in i && (i.writable = !0),
                Object.defineProperty(t, i.key, i);
        }
    }
    function o(t, e, n) {
        return e && i(t.prototype, e), n && i(t, n), t;
    }
    function s(t, e, n) {
        return (
            e in t
                ? Object.defineProperty(t, e, {
                      value: n,
                      enumerable: !0,
                      configurable: !0,
                      writable: !0,
                  })
                : (t[e] = n),
            t
        );
    }
    function r(t, e) {
        var n = Object.keys(t);
        if (Object.getOwnPropertySymbols) {
            var i = Object.getOwnPropertySymbols(t);
            e &&
                (i = i.filter(function (e) {
                    return Object.getOwnPropertyDescriptor(t, e).enumerable;
                })),
                n.push.apply(n, i);
        }
        return n;
    }
    function a(t) {
        for (var e = 1; e < arguments.length; e++) {
            var n = null != arguments[e] ? arguments[e] : {};
            e % 2
                ? r(Object(n), !0).forEach(function (e) {
                      s(t, e, n[e]);
                  })
                : Object.getOwnPropertyDescriptors
                ? Object.defineProperties(
                      t,
                      Object.getOwnPropertyDescriptors(n)
                  )
                : r(Object(n)).forEach(function (e) {
                      Object.defineProperty(
                          t,
                          e,
                          Object.getOwnPropertyDescriptor(n, e)
                      );
                  });
        }
        return t;
    }
    (e =
        e && Object.prototype.hasOwnProperty.call(e, "default")
            ? e.default
            : e),
        (n =
            n && Object.prototype.hasOwnProperty.call(n, "default")
                ? n.default
                : n);
    function l(t) {
        var n = this,
            i = !1;
        return (
            e(this).one(c.TRANSITION_END, function () {
                i = !0;
            }),
            setTimeout(function () {
                i || c.triggerTransitionEnd(n);
            }, t),
            this
        );
    }
    var c = {
        TRANSITION_END: "bsTransitionEnd",
        getUID: function (t) {
            do {
                t += ~~(1e6 * Math.random());
            } while (document.getElementById(t));
            return t;
        },
        getSelectorFromElement: function (t) {
            var e = t.getAttribute("data-target");
            if (!e || "#" === e) {
                var n = t.getAttribute("href");
                e = n && "#" !== n ? n.trim() : "";
            }
            try {
                return document.querySelector(e) ? e : null;
            } catch (t) {
                return null;
            }
        },
        getTransitionDurationFromElement: function (t) {
            if (!t) return 0;
            var n = e(t).css("transition-duration"),
                i = e(t).css("transition-delay"),
                o = parseFloat(n),
                s = parseFloat(i);
            return o || s
                ? ((n = n.split(",")[0]),
                  (i = i.split(",")[0]),
                  1e3 * (parseFloat(n) + parseFloat(i)))
                : 0;
        },
        reflow: function (t) {
            return t.offsetHeight;
        },
        triggerTransitionEnd: function (t) {
            e(t).trigger("transitionend");
        },
        supportsTransitionEnd: function () {
            return Boolean("transitionend");
        },
        isElement: function (t) {
            return (t[0] || t).nodeType;
        },
        typeCheckConfig: function (t, e, n) {
            for (var i in n)
                if (Object.prototype.hasOwnProperty.call(n, i)) {
                    var o = n[i],
                        s = e[i],
                        r =
                            s && c.isElement(s)
                                ? "element"
                                : null === (a = s) || "undefined" == typeof a
                                ? "" + a
                                : {}.toString
                                      .call(a)
                                      .match(/\s([a-z]+)/i)[1]
                                      .toLowerCase();
                    if (!new RegExp(o).test(r))
                        throw new Error(
                            t.toUpperCase() +
                                ': Option "' +
                                i +
                                '" provided type "' +
                                r +
                                '" but expected type "' +
                                o +
                                '".'
                        );
                }
            var a;
        },
        findShadowRoot: function (t) {
            if (!document.documentElement.attachShadow) return null;
            if ("function" == typeof t.getRootNode) {
                var e = t.getRootNode();
                return e instanceof ShadowRoot ? e : null;
            }
            return t instanceof ShadowRoot
                ? t
                : t.parentNode
                ? c.findShadowRoot(t.parentNode)
                : null;
        },
        jQueryDetection: function () {
            if ("undefined" == typeof e)
                throw new TypeError(
                    "Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript."
                );
            var t = e.fn.jquery.split(" ")[0].split(".");
            if (
                (t[0] < 2 && t[1] < 9) ||
                (1 === t[0] && 9 === t[1] && t[2] < 1) ||
                t[0] >= 4
            )
                throw new Error(
                    "Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0"
                );
        },
    };
    c.jQueryDetection(),
        (e.fn.emulateTransitionEnd = l),
        (e.event.special[c.TRANSITION_END] = {
            bindType: "transitionend",
            delegateType: "transitionend",
            handle: function (t) {
                if (e(t.target).is(this))
                    return t.handleObj.handler.apply(this, arguments);
            },
        });
    var h = "alert",
        u = e.fn[h],
        d = (function () {
            function t(t) {
                this._element = t;
            }
            var n = t.prototype;
            return (
                (n.close = function (t) {
                    var e = this._element;
                    t && (e = this._getRootElement(t)),
                        this._triggerCloseEvent(e).isDefaultPrevented() ||
                            this._removeElement(e);
                }),
                (n.dispose = function () {
                    e.removeData(this._element, "bs.alert"),
                        (this._element = null);
                }),
                (n._getRootElement = function (t) {
                    var n = c.getSelectorFromElement(t),
                        i = !1;
                    return (
                        n && (i = document.querySelector(n)),
                        i || (i = e(t).closest(".alert")[0]),
                        i
                    );
                }),
                (n._triggerCloseEvent = function (t) {
                    var n = e.Event("close.bs.alert");
                    return e(t).trigger(n), n;
                }),
                (n._removeElement = function (t) {
                    var n = this;
                    if ((e(t).removeClass("show"), e(t).hasClass("fade"))) {
                        var i = c.getTransitionDurationFromElement(t);
                        e(t)
                            .one(c.TRANSITION_END, function (e) {
                                return n._destroyElement(t, e);
                            })
                            .emulateTransitionEnd(i);
                    } else this._destroyElement(t);
                }),
                (n._destroyElement = function (t) {
                    e(t).detach().trigger("closed.bs.alert").remove();
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this),
                            o = i.data("bs.alert");
                        o || ((o = new t(this)), i.data("bs.alert", o)),
                            "close" === n && o[n](this);
                    });
                }),
                (t._handleDismiss = function (t) {
                    return function (e) {
                        e && e.preventDefault(), t.close(this);
                    };
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                ]),
                t
            );
        })();
    e(document).on(
        "click.bs.alert.data-api",
        '[data-dismiss="alert"]',
        d._handleDismiss(new d())
    ),
        (e.fn[h] = d._jQueryInterface),
        (e.fn[h].Constructor = d),
        (e.fn[h].noConflict = function () {
            return (e.fn[h] = u), d._jQueryInterface;
        });
    var f = e.fn.button,
        g = (function () {
            function t(t) {
                this._element = t;
            }
            var n = t.prototype;
            return (
                (n.toggle = function () {
                    var t = !0,
                        n = !0,
                        i = e(this._element).closest(
                            '[data-toggle="buttons"]'
                        )[0];
                    if (i) {
                        var o = this._element.querySelector(
                            'input:not([type="hidden"])'
                        );
                        if (o) {
                            if ("radio" === o.type)
                                if (
                                    o.checked &&
                                    this._element.classList.contains("active")
                                )
                                    t = !1;
                                else {
                                    var s = i.querySelector(".active");
                                    s && e(s).removeClass("active");
                                }
                            t &&
                                (("checkbox" !== o.type &&
                                    "radio" !== o.type) ||
                                    (o.checked =
                                        !this._element.classList.contains(
                                            "active"
                                        )),
                                e(o).trigger("change")),
                                o.focus(),
                                (n = !1);
                        }
                    }
                    this._element.hasAttribute("disabled") ||
                        this._element.classList.contains("disabled") ||
                        (n &&
                            this._element.setAttribute(
                                "aria-pressed",
                                !this._element.classList.contains("active")
                            ),
                        t && e(this._element).toggleClass("active"));
                }),
                (n.dispose = function () {
                    e.removeData(this._element, "bs.button"),
                        (this._element = null);
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this).data("bs.button");
                        i || ((i = new t(this)), e(this).data("bs.button", i)),
                            "toggle" === n && i[n]();
                    });
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                ]),
                t
            );
        })();
    e(document)
        .on(
            "click.bs.button.data-api",
            '[data-toggle^="button"]',
            function (t) {
                var n = t.target,
                    i = n;
                if (
                    (e(n).hasClass("btn") || (n = e(n).closest(".btn")[0]),
                    !n ||
                        n.hasAttribute("disabled") ||
                        n.classList.contains("disabled"))
                )
                    t.preventDefault();
                else {
                    var o = n.querySelector('input:not([type="hidden"])');
                    if (
                        o &&
                        (o.hasAttribute("disabled") ||
                            o.classList.contains("disabled"))
                    )
                        return void t.preventDefault();
                    "LABEL" === i.tagName &&
                        o &&
                        "checkbox" === o.type &&
                        t.preventDefault(),
                        g._jQueryInterface.call(e(n), "toggle");
                }
            }
        )
        .on(
            "focus.bs.button.data-api blur.bs.button.data-api",
            '[data-toggle^="button"]',
            function (t) {
                var n = e(t.target).closest(".btn")[0];
                e(n).toggleClass("focus", /^focus(in)?$/.test(t.type));
            }
        ),
        e(window).on("load.bs.button.data-api", function () {
            for (
                var t = [].slice.call(
                        document.querySelectorAll(
                            '[data-toggle="buttons"] .btn'
                        )
                    ),
                    e = 0,
                    n = t.length;
                e < n;
                e++
            ) {
                var i = t[e],
                    o = i.querySelector('input:not([type="hidden"])');
                o.checked || o.hasAttribute("checked")
                    ? i.classList.add("active")
                    : i.classList.remove("active");
            }
            for (
                var s = 0,
                    r = (t = [].slice.call(
                        document.querySelectorAll('[data-toggle="button"]')
                    )).length;
                s < r;
                s++
            ) {
                var a = t[s];
                "true" === a.getAttribute("aria-pressed")
                    ? a.classList.add("active")
                    : a.classList.remove("active");
            }
        }),
        (e.fn.button = g._jQueryInterface),
        (e.fn.button.Constructor = g),
        (e.fn.button.noConflict = function () {
            return (e.fn.button = f), g._jQueryInterface;
        });
    var m = "carousel",
        p = ".bs.carousel",
        _ = e.fn[m],
        v = {
            interval: 5e3,
            keyboard: !0,
            slide: !1,
            pause: "hover",
            wrap: !0,
            touch: !0,
        },
        b = {
            interval: "(number|boolean)",
            keyboard: "boolean",
            slide: "(boolean|string)",
            pause: "(string|boolean)",
            wrap: "boolean",
            touch: "boolean",
        },
        y = { TOUCH: "touch", PEN: "pen" },
        E = (function () {
            function t(t, e) {
                (this._items = null),
                    (this._interval = null),
                    (this._activeElement = null),
                    (this._isPaused = !1),
                    (this._isSliding = !1),
                    (this.touchTimeout = null),
                    (this.touchStartX = 0),
                    (this.touchDeltaX = 0),
                    (this._config = this._getConfig(e)),
                    (this._element = t),
                    (this._indicatorsElement = this._element.querySelector(
                        ".carousel-indicators"
                    )),
                    (this._touchSupported =
                        "ontouchstart" in document.documentElement ||
                        navigator.maxTouchPoints > 0),
                    (this._pointerEvent = Boolean(
                        window.PointerEvent || window.MSPointerEvent
                    )),
                    this._addEventListeners();
            }
            var n = t.prototype;
            return (
                (n.next = function () {
                    this._isSliding || this._slide("next");
                }),
                (n.nextWhenVisible = function () {
                    !document.hidden &&
                        e(this._element).is(":visible") &&
                        "hidden" !== e(this._element).css("visibility") &&
                        this.next();
                }),
                (n.prev = function () {
                    this._isSliding || this._slide("prev");
                }),
                (n.pause = function (t) {
                    t || (this._isPaused = !0),
                        this._element.querySelector(
                            ".carousel-item-next, .carousel-item-prev"
                        ) &&
                            (c.triggerTransitionEnd(this._element),
                            this.cycle(!0)),
                        clearInterval(this._interval),
                        (this._interval = null);
                }),
                (n.cycle = function (t) {
                    t || (this._isPaused = !1),
                        this._interval &&
                            (clearInterval(this._interval),
                            (this._interval = null)),
                        this._config.interval &&
                            !this._isPaused &&
                            (this._interval = setInterval(
                                (document.visibilityState
                                    ? this.nextWhenVisible
                                    : this.next
                                ).bind(this),
                                this._config.interval
                            ));
                }),
                (n.to = function (t) {
                    var n = this;
                    this._activeElement = this._element.querySelector(
                        ".active.carousel-item"
                    );
                    var i = this._getItemIndex(this._activeElement);
                    if (!(t > this._items.length - 1 || t < 0))
                        if (this._isSliding)
                            e(this._element).one(
                                "slid.bs.carousel",
                                function () {
                                    return n.to(t);
                                }
                            );
                        else {
                            if (i === t) return this.pause(), void this.cycle();
                            var o = t > i ? "next" : "prev";
                            this._slide(o, this._items[t]);
                        }
                }),
                (n.dispose = function () {
                    e(this._element).off(p),
                        e.removeData(this._element, "bs.carousel"),
                        (this._items = null),
                        (this._config = null),
                        (this._element = null),
                        (this._interval = null),
                        (this._isPaused = null),
                        (this._isSliding = null),
                        (this._activeElement = null),
                        (this._indicatorsElement = null);
                }),
                (n._getConfig = function (t) {
                    return (t = a(a({}, v), t)), c.typeCheckConfig(m, t, b), t;
                }),
                (n._handleSwipe = function () {
                    var t = Math.abs(this.touchDeltaX);
                    if (!(t <= 40)) {
                        var e = t / this.touchDeltaX;
                        (this.touchDeltaX = 0),
                            e > 0 && this.prev(),
                            e < 0 && this.next();
                    }
                }),
                (n._addEventListeners = function () {
                    var t = this;
                    this._config.keyboard &&
                        e(this._element).on(
                            "keydown.bs.carousel",
                            function (e) {
                                return t._keydown(e);
                            }
                        ),
                        "hover" === this._config.pause &&
                            e(this._element)
                                .on("mouseenter.bs.carousel", function (e) {
                                    return t.pause(e);
                                })
                                .on("mouseleave.bs.carousel", function (e) {
                                    return t.cycle(e);
                                }),
                        this._config.touch && this._addTouchEventListeners();
                }),
                (n._addTouchEventListeners = function () {
                    var t = this;
                    if (this._touchSupported) {
                        var n = function (e) {
                                t._pointerEvent &&
                                y[e.originalEvent.pointerType.toUpperCase()]
                                    ? (t.touchStartX = e.originalEvent.clientX)
                                    : t._pointerEvent ||
                                      (t.touchStartX =
                                          e.originalEvent.touches[0].clientX);
                            },
                            i = function (e) {
                                t._pointerEvent &&
                                    y[
                                        e.originalEvent.pointerType.toUpperCase()
                                    ] &&
                                    (t.touchDeltaX =
                                        e.originalEvent.clientX -
                                        t.touchStartX),
                                    t._handleSwipe(),
                                    "hover" === t._config.pause &&
                                        (t.pause(),
                                        t.touchTimeout &&
                                            clearTimeout(t.touchTimeout),
                                        (t.touchTimeout = setTimeout(function (
                                            e
                                        ) {
                                            return t.cycle(e);
                                        },
                                        500 + t._config.interval)));
                            };
                        e(
                            this._element.querySelectorAll(".carousel-item img")
                        ).on("dragstart.bs.carousel", function (t) {
                            return t.preventDefault();
                        }),
                            this._pointerEvent
                                ? (e(this._element).on(
                                      "pointerdown.bs.carousel",
                                      function (t) {
                                          return n(t);
                                      }
                                  ),
                                  e(this._element).on(
                                      "pointerup.bs.carousel",
                                      function (t) {
                                          return i(t);
                                      }
                                  ),
                                  this._element.classList.add("pointer-event"))
                                : (e(this._element).on(
                                      "touchstart.bs.carousel",
                                      function (t) {
                                          return n(t);
                                      }
                                  ),
                                  e(this._element).on(
                                      "touchmove.bs.carousel",
                                      function (e) {
                                          return (function (e) {
                                              e.originalEvent.touches &&
                                              e.originalEvent.touches.length > 1
                                                  ? (t.touchDeltaX = 0)
                                                  : (t.touchDeltaX =
                                                        e.originalEvent
                                                            .touches[0]
                                                            .clientX -
                                                        t.touchStartX);
                                          })(e);
                                      }
                                  ),
                                  e(this._element).on(
                                      "touchend.bs.carousel",
                                      function (t) {
                                          return i(t);
                                      }
                                  ));
                    }
                }),
                (n._keydown = function (t) {
                    if (!/input|textarea/i.test(t.target.tagName))
                        switch (t.which) {
                            case 37:
                                t.preventDefault(), this.prev();
                                break;
                            case 39:
                                t.preventDefault(), this.next();
                        }
                }),
                (n._getItemIndex = function (t) {
                    return (
                        (this._items =
                            t && t.parentNode
                                ? [].slice.call(
                                      t.parentNode.querySelectorAll(
                                          ".carousel-item"
                                      )
                                  )
                                : []),
                        this._items.indexOf(t)
                    );
                }),
                (n._getItemByDirection = function (t, e) {
                    var n = "next" === t,
                        i = "prev" === t,
                        o = this._getItemIndex(e),
                        s = this._items.length - 1;
                    if (
                        ((i && 0 === o) || (n && o === s)) &&
                        !this._config.wrap
                    )
                        return e;
                    var r = (o + ("prev" === t ? -1 : 1)) % this._items.length;
                    return -1 === r
                        ? this._items[this._items.length - 1]
                        : this._items[r];
                }),
                (n._triggerSlideEvent = function (t, n) {
                    var i = this._getItemIndex(t),
                        o = this._getItemIndex(
                            this._element.querySelector(".active.carousel-item")
                        ),
                        s = e.Event("slide.bs.carousel", {
                            relatedTarget: t,
                            direction: n,
                            from: o,
                            to: i,
                        });
                    return e(this._element).trigger(s), s;
                }),
                (n._setActiveIndicatorElement = function (t) {
                    if (this._indicatorsElement) {
                        var n = [].slice.call(
                            this._indicatorsElement.querySelectorAll(".active")
                        );
                        e(n).removeClass("active");
                        var i =
                            this._indicatorsElement.children[
                                this._getItemIndex(t)
                            ];
                        i && e(i).addClass("active");
                    }
                }),
                (n._slide = function (t, n) {
                    var i,
                        o,
                        s,
                        r = this,
                        a = this._element.querySelector(
                            ".active.carousel-item"
                        ),
                        l = this._getItemIndex(a),
                        h = n || (a && this._getItemByDirection(t, a)),
                        u = this._getItemIndex(h),
                        d = Boolean(this._interval);
                    if (
                        ("next" === t
                            ? ((i = "carousel-item-left"),
                              (o = "carousel-item-next"),
                              (s = "left"))
                            : ((i = "carousel-item-right"),
                              (o = "carousel-item-prev"),
                              (s = "right")),
                        h && e(h).hasClass("active"))
                    )
                        this._isSliding = !1;
                    else if (
                        !this._triggerSlideEvent(h, s).isDefaultPrevented() &&
                        a &&
                        h
                    ) {
                        (this._isSliding = !0),
                            d && this.pause(),
                            this._setActiveIndicatorElement(h);
                        var f = e.Event("slid.bs.carousel", {
                            relatedTarget: h,
                            direction: s,
                            from: l,
                            to: u,
                        });
                        if (e(this._element).hasClass("slide")) {
                            e(h).addClass(o),
                                c.reflow(h),
                                e(a).addClass(i),
                                e(h).addClass(i);
                            var g = parseInt(
                                h.getAttribute("data-interval"),
                                10
                            );
                            g
                                ? ((this._config.defaultInterval =
                                      this._config.defaultInterval ||
                                      this._config.interval),
                                  (this._config.interval = g))
                                : (this._config.interval =
                                      this._config.defaultInterval ||
                                      this._config.interval);
                            var m = c.getTransitionDurationFromElement(a);
                            e(a)
                                .one(c.TRANSITION_END, function () {
                                    e(h)
                                        .removeClass(i + " " + o)
                                        .addClass("active"),
                                        e(a).removeClass(
                                            "active " + o + " " + i
                                        ),
                                        (r._isSliding = !1),
                                        setTimeout(function () {
                                            return e(r._element).trigger(f);
                                        }, 0);
                                })
                                .emulateTransitionEnd(m);
                        } else
                            e(a).removeClass("active"),
                                e(h).addClass("active"),
                                (this._isSliding = !1),
                                e(this._element).trigger(f);
                        d && this.cycle();
                    }
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this).data("bs.carousel"),
                            o = a(a({}, v), e(this).data());
                        "object" == typeof n && (o = a(a({}, o), n));
                        var s = "string" == typeof n ? n : o.slide;
                        if (
                            (i ||
                                ((i = new t(this, o)),
                                e(this).data("bs.carousel", i)),
                            "number" == typeof n)
                        )
                            i.to(n);
                        else if ("string" == typeof s) {
                            if ("undefined" == typeof i[s])
                                throw new TypeError(
                                    'No method named "' + s + '"'
                                );
                            i[s]();
                        } else o.interval && o.ride && (i.pause(), i.cycle());
                    });
                }),
                (t._dataApiClickHandler = function (n) {
                    var i = c.getSelectorFromElement(this);
                    if (i) {
                        var o = e(i)[0];
                        if (o && e(o).hasClass("carousel")) {
                            var s = a(a({}, e(o).data()), e(this).data()),
                                r = this.getAttribute("data-slide-to");
                            r && (s.interval = !1),
                                t._jQueryInterface.call(e(o), s),
                                r && e(o).data("bs.carousel").to(r),
                                n.preventDefault();
                        }
                    }
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return v;
                        },
                    },
                ]),
                t
            );
        })();
    e(document).on(
        "click.bs.carousel.data-api",
        "[data-slide], [data-slide-to]",
        E._dataApiClickHandler
    ),
        e(window).on("load.bs.carousel.data-api", function () {
            for (
                var t = [].slice.call(
                        document.querySelectorAll('[data-ride="carousel"]')
                    ),
                    n = 0,
                    i = t.length;
                n < i;
                n++
            ) {
                var o = e(t[n]);
                E._jQueryInterface.call(o, o.data());
            }
        }),
        (e.fn[m] = E._jQueryInterface),
        (e.fn[m].Constructor = E),
        (e.fn[m].noConflict = function () {
            return (e.fn[m] = _), E._jQueryInterface;
        });
    var w = "collapse",
        T = e.fn[w],
        C = { toggle: !0, parent: "" },
        S = { toggle: "boolean", parent: "(string|element)" },
        D = (function () {
            function t(t, e) {
                (this._isTransitioning = !1),
                    (this._element = t),
                    (this._config = this._getConfig(e)),
                    (this._triggerArray = [].slice.call(
                        document.querySelectorAll(
                            '[data-toggle="collapse"][href="#' +
                                t.id +
                                '"],[data-toggle="collapse"][data-target="#' +
                                t.id +
                                '"]'
                        )
                    ));
                for (
                    var n = [].slice.call(
                            document.querySelectorAll(
                                '[data-toggle="collapse"]'
                            )
                        ),
                        i = 0,
                        o = n.length;
                    i < o;
                    i++
                ) {
                    var s = n[i],
                        r = c.getSelectorFromElement(s),
                        a = [].slice
                            .call(document.querySelectorAll(r))
                            .filter(function (e) {
                                return e === t;
                            });
                    null !== r &&
                        a.length > 0 &&
                        ((this._selector = r), this._triggerArray.push(s));
                }
                (this._parent = this._config.parent ? this._getParent() : null),
                    this._config.parent ||
                        this._addAriaAndCollapsedClass(
                            this._element,
                            this._triggerArray
                        ),
                    this._config.toggle && this.toggle();
            }
            var n = t.prototype;
            return (
                (n.toggle = function () {
                    e(this._element).hasClass("show")
                        ? this.hide()
                        : this.show();
                }),
                (n.show = function () {
                    var n,
                        i,
                        o = this;
                    if (
                        !this._isTransitioning &&
                        !e(this._element).hasClass("show") &&
                        (this._parent &&
                            0 ===
                                (n = [].slice
                                    .call(
                                        this._parent.querySelectorAll(
                                            ".show, .collapsing"
                                        )
                                    )
                                    .filter(function (t) {
                                        return "string" ==
                                            typeof o._config.parent
                                            ? t.getAttribute("data-parent") ===
                                                  o._config.parent
                                            : t.classList.contains("collapse");
                                    })).length &&
                            (n = null),
                        !(
                            n &&
                            (i = e(n)
                                .not(this._selector)
                                .data("bs.collapse")) &&
                            i._isTransitioning
                        ))
                    ) {
                        var s = e.Event("show.bs.collapse");
                        if (
                            (e(this._element).trigger(s),
                            !s.isDefaultPrevented())
                        ) {
                            n &&
                                (t._jQueryInterface.call(
                                    e(n).not(this._selector),
                                    "hide"
                                ),
                                i || e(n).data("bs.collapse", null));
                            var r = this._getDimension();
                            e(this._element)
                                .removeClass("collapse")
                                .addClass("collapsing"),
                                (this._element.style[r] = 0),
                                this._triggerArray.length &&
                                    e(this._triggerArray)
                                        .removeClass("collapsed")
                                        .attr("aria-expanded", !0),
                                this.setTransitioning(!0);
                            var a =
                                    "scroll" +
                                    (r[0].toUpperCase() + r.slice(1)),
                                l = c.getTransitionDurationFromElement(
                                    this._element
                                );
                            e(this._element)
                                .one(c.TRANSITION_END, function () {
                                    e(o._element)
                                        .removeClass("collapsing")
                                        .addClass("collapse show"),
                                        (o._element.style[r] = ""),
                                        o.setTransitioning(!1),
                                        e(o._element).trigger(
                                            "shown.bs.collapse"
                                        );
                                })
                                .emulateTransitionEnd(l),
                                (this._element.style[r] =
                                    this._element[a] + "px");
                        }
                    }
                }),
                (n.hide = function () {
                    var t = this;
                    if (
                        !this._isTransitioning &&
                        e(this._element).hasClass("show")
                    ) {
                        var n = e.Event("hide.bs.collapse");
                        if (
                            (e(this._element).trigger(n),
                            !n.isDefaultPrevented())
                        ) {
                            var i = this._getDimension();
                            (this._element.style[i] =
                                this._element.getBoundingClientRect()[i] +
                                "px"),
                                c.reflow(this._element),
                                e(this._element)
                                    .addClass("collapsing")
                                    .removeClass("collapse show");
                            var o = this._triggerArray.length;
                            if (o > 0)
                                for (var s = 0; s < o; s++) {
                                    var r = this._triggerArray[s],
                                        a = c.getSelectorFromElement(r);
                                    if (null !== a)
                                        e(
                                            [].slice.call(
                                                document.querySelectorAll(a)
                                            )
                                        ).hasClass("show") ||
                                            e(r)
                                                .addClass("collapsed")
                                                .attr("aria-expanded", !1);
                                }
                            this.setTransitioning(!0);
                            this._element.style[i] = "";
                            var l = c.getTransitionDurationFromElement(
                                this._element
                            );
                            e(this._element)
                                .one(c.TRANSITION_END, function () {
                                    t.setTransitioning(!1),
                                        e(t._element)
                                            .removeClass("collapsing")
                                            .addClass("collapse")
                                            .trigger("hidden.bs.collapse");
                                })
                                .emulateTransitionEnd(l);
                        }
                    }
                }),
                (n.setTransitioning = function (t) {
                    this._isTransitioning = t;
                }),
                (n.dispose = function () {
                    e.removeData(this._element, "bs.collapse"),
                        (this._config = null),
                        (this._parent = null),
                        (this._element = null),
                        (this._triggerArray = null),
                        (this._isTransitioning = null);
                }),
                (n._getConfig = function (t) {
                    return (
                        ((t = a(a({}, C), t)).toggle = Boolean(t.toggle)),
                        c.typeCheckConfig(w, t, S),
                        t
                    );
                }),
                (n._getDimension = function () {
                    return e(this._element).hasClass("width")
                        ? "width"
                        : "height";
                }),
                (n._getParent = function () {
                    var n,
                        i = this;
                    c.isElement(this._config.parent)
                        ? ((n = this._config.parent),
                          "undefined" != typeof this._config.parent.jquery &&
                              (n = this._config.parent[0]))
                        : (n = document.querySelector(this._config.parent));
                    var o =
                            '[data-toggle="collapse"][data-parent="' +
                            this._config.parent +
                            '"]',
                        s = [].slice.call(n.querySelectorAll(o));
                    return (
                        e(s).each(function (e, n) {
                            i._addAriaAndCollapsedClass(
                                t._getTargetFromElement(n),
                                [n]
                            );
                        }),
                        n
                    );
                }),
                (n._addAriaAndCollapsedClass = function (t, n) {
                    var i = e(t).hasClass("show");
                    n.length &&
                        e(n)
                            .toggleClass("collapsed", !i)
                            .attr("aria-expanded", i);
                }),
                (t._getTargetFromElement = function (t) {
                    var e = c.getSelectorFromElement(t);
                    return e ? document.querySelector(e) : null;
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this),
                            o = i.data("bs.collapse"),
                            s = a(
                                a(a({}, C), i.data()),
                                "object" == typeof n && n ? n : {}
                            );
                        if (
                            (!o &&
                                s.toggle &&
                                "string" == typeof n &&
                                /show|hide/.test(n) &&
                                (s.toggle = !1),
                            o ||
                                ((o = new t(this, s)),
                                i.data("bs.collapse", o)),
                            "string" == typeof n)
                        ) {
                            if ("undefined" == typeof o[n])
                                throw new TypeError(
                                    'No method named "' + n + '"'
                                );
                            o[n]();
                        }
                    });
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return C;
                        },
                    },
                ]),
                t
            );
        })();
    e(document).on(
        "click.bs.collapse.data-api",
        '[data-toggle="collapse"]',
        function (t) {
            "A" === t.currentTarget.tagName && t.preventDefault();
            var n = e(this),
                i = c.getSelectorFromElement(this),
                o = [].slice.call(document.querySelectorAll(i));
            e(o).each(function () {
                var t = e(this),
                    i = t.data("bs.collapse") ? "toggle" : n.data();
                D._jQueryInterface.call(t, i);
            });
        }
    ),
        (e.fn[w] = D._jQueryInterface),
        (e.fn[w].Constructor = D),
        (e.fn[w].noConflict = function () {
            return (e.fn[w] = T), D._jQueryInterface;
        });
    var k = "dropdown",
        N = e.fn[k],
        A = new RegExp("38|40|27"),
        I = {
            offset: 0,
            flip: !0,
            boundary: "scrollParent",
            reference: "toggle",
            display: "dynamic",
            popperConfig: null,
        },
        O = {
            offset: "(number|string|function)",
            flip: "boolean",
            boundary: "(string|element)",
            reference: "(string|element)",
            display: "string",
            popperConfig: "(null|object)",
        },
        j = (function () {
            function t(t, e) {
                (this._element = t),
                    (this._popper = null),
                    (this._config = this._getConfig(e)),
                    (this._menu = this._getMenuElement()),
                    (this._inNavbar = this._detectNavbar()),
                    this._addEventListeners();
            }
            var i = t.prototype;
            return (
                (i.toggle = function () {
                    if (
                        !this._element.disabled &&
                        !e(this._element).hasClass("disabled")
                    ) {
                        var n = e(this._menu).hasClass("show");
                        t._clearMenus(), n || this.show(!0);
                    }
                }),
                (i.show = function (i) {
                    if (
                        (void 0 === i && (i = !1),
                        !(
                            this._element.disabled ||
                            e(this._element).hasClass("disabled") ||
                            e(this._menu).hasClass("show")
                        ))
                    ) {
                        var o = { relatedTarget: this._element },
                            s = e.Event("show.bs.dropdown", o),
                            r = t._getParentFromElement(this._element);
                        if ((e(r).trigger(s), !s.isDefaultPrevented())) {
                            if (!this._inNavbar && i) {
                                if ("undefined" == typeof n)
                                    throw new TypeError(
                                        "Bootstrap's dropdowns require Popper.js (https://popper.js.org/)"
                                    );
                                var a = this._element;
                                "parent" === this._config.reference
                                    ? (a = r)
                                    : c.isElement(this._config.reference) &&
                                      ((a = this._config.reference),
                                      "undefined" !=
                                          typeof this._config.reference
                                              .jquery &&
                                          (a = this._config.reference[0])),
                                    "scrollParent" !== this._config.boundary &&
                                        e(r).addClass("position-static"),
                                    (this._popper = new n(
                                        a,
                                        this._menu,
                                        this._getPopperConfig()
                                    ));
                            }
                            "ontouchstart" in document.documentElement &&
                                0 === e(r).closest(".navbar-nav").length &&
                                e(document.body)
                                    .children()
                                    .on("mouseover", null, e.noop),
                                this._element.focus(),
                                this._element.setAttribute("aria-expanded", !0),
                                e(this._menu).toggleClass("show"),
                                e(r)
                                    .toggleClass("show")
                                    .trigger(e.Event("shown.bs.dropdown", o));
                        }
                    }
                }),
                (i.hide = function () {
                    if (
                        !this._element.disabled &&
                        !e(this._element).hasClass("disabled") &&
                        e(this._menu).hasClass("show")
                    ) {
                        var n = { relatedTarget: this._element },
                            i = e.Event("hide.bs.dropdown", n),
                            o = t._getParentFromElement(this._element);
                        e(o).trigger(i),
                            i.isDefaultPrevented() ||
                                (this._popper && this._popper.destroy(),
                                e(this._menu).toggleClass("show"),
                                e(o)
                                    .toggleClass("show")
                                    .trigger(e.Event("hidden.bs.dropdown", n)));
                    }
                }),
                (i.dispose = function () {
                    e.removeData(this._element, "bs.dropdown"),
                        e(this._element).off(".bs.dropdown"),
                        (this._element = null),
                        (this._menu = null),
                        null !== this._popper &&
                            (this._popper.destroy(), (this._popper = null));
                }),
                (i.update = function () {
                    (this._inNavbar = this._detectNavbar()),
                        null !== this._popper && this._popper.scheduleUpdate();
                }),
                (i._addEventListeners = function () {
                    var t = this;
                    e(this._element).on("click.bs.dropdown", function (e) {
                        e.preventDefault(), e.stopPropagation(), t.toggle();
                    });
                }),
                (i._getConfig = function (t) {
                    return (
                        (t = a(
                            a(
                                a({}, this.constructor.Default),
                                e(this._element).data()
                            ),
                            t
                        )),
                        c.typeCheckConfig(k, t, this.constructor.DefaultType),
                        t
                    );
                }),
                (i._getMenuElement = function () {
                    if (!this._menu) {
                        var e = t._getParentFromElement(this._element);
                        e && (this._menu = e.querySelector(".dropdown-menu"));
                    }
                    return this._menu;
                }),
                (i._getPlacement = function () {
                    var t = e(this._element.parentNode),
                        n = "bottom-start";
                    return (
                        t.hasClass("dropup")
                            ? (n = e(this._menu).hasClass("dropdown-menu-right")
                                  ? "top-end"
                                  : "top-start")
                            : t.hasClass("dropright")
                            ? (n = "right-start")
                            : t.hasClass("dropleft")
                            ? (n = "left-start")
                            : e(this._menu).hasClass("dropdown-menu-right") &&
                              (n = "bottom-end"),
                        n
                    );
                }),
                (i._detectNavbar = function () {
                    return e(this._element).closest(".navbar").length > 0;
                }),
                (i._getOffset = function () {
                    var t = this,
                        e = {};
                    return (
                        "function" == typeof this._config.offset
                            ? (e.fn = function (e) {
                                  return (
                                      (e.offsets = a(
                                          a({}, e.offsets),
                                          t._config.offset(
                                              e.offsets,
                                              t._element
                                          ) || {}
                                      )),
                                      e
                                  );
                              })
                            : (e.offset = this._config.offset),
                        e
                    );
                }),
                (i._getPopperConfig = function () {
                    var t = {
                        placement: this._getPlacement(),
                        modifiers: {
                            offset: this._getOffset(),
                            flip: { enabled: this._config.flip },
                            preventOverflow: {
                                boundariesElement: this._config.boundary,
                            },
                        },
                    };
                    return (
                        "static" === this._config.display &&
                            (t.modifiers.applyStyle = { enabled: !1 }),
                        a(a({}, t), this._config.popperConfig)
                    );
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this).data("bs.dropdown");
                        if (
                            (i ||
                                ((i = new t(
                                    this,
                                    "object" == typeof n ? n : null
                                )),
                                e(this).data("bs.dropdown", i)),
                            "string" == typeof n)
                        ) {
                            if ("undefined" == typeof i[n])
                                throw new TypeError(
                                    'No method named "' + n + '"'
                                );
                            i[n]();
                        }
                    });
                }),
                (t._clearMenus = function (n) {
                    if (
                        !n ||
                        (3 !== n.which && ("keyup" !== n.type || 9 === n.which))
                    )
                        for (
                            var i = [].slice.call(
                                    document.querySelectorAll(
                                        '[data-toggle="dropdown"]'
                                    )
                                ),
                                o = 0,
                                s = i.length;
                            o < s;
                            o++
                        ) {
                            var r = t._getParentFromElement(i[o]),
                                a = e(i[o]).data("bs.dropdown"),
                                l = { relatedTarget: i[o] };
                            if (
                                (n && "click" === n.type && (l.clickEvent = n),
                                a)
                            ) {
                                var c = a._menu;
                                if (
                                    e(r).hasClass("show") &&
                                    !(
                                        n &&
                                        (("click" === n.type &&
                                            /input|textarea/i.test(
                                                n.target.tagName
                                            )) ||
                                            ("keyup" === n.type &&
                                                9 === n.which)) &&
                                        e.contains(r, n.target)
                                    )
                                ) {
                                    var h = e.Event("hide.bs.dropdown", l);
                                    e(r).trigger(h),
                                        h.isDefaultPrevented() ||
                                            ("ontouchstart" in
                                                document.documentElement &&
                                                e(document.body)
                                                    .children()
                                                    .off(
                                                        "mouseover",
                                                        null,
                                                        e.noop
                                                    ),
                                            i[o].setAttribute(
                                                "aria-expanded",
                                                "false"
                                            ),
                                            a._popper && a._popper.destroy(),
                                            e(c).removeClass("show"),
                                            e(r)
                                                .removeClass("show")
                                                .trigger(
                                                    e.Event(
                                                        "hidden.bs.dropdown",
                                                        l
                                                    )
                                                ));
                                }
                            }
                        }
                }),
                (t._getParentFromElement = function (t) {
                    var e,
                        n = c.getSelectorFromElement(t);
                    return (
                        n && (e = document.querySelector(n)), e || t.parentNode
                    );
                }),
                (t._dataApiKeydownHandler = function (n) {
                    if (
                        !(/input|textarea/i.test(n.target.tagName)
                            ? 32 === n.which ||
                              (27 !== n.which &&
                                  ((40 !== n.which && 38 !== n.which) ||
                                      e(n.target).closest(".dropdown-menu")
                                          .length))
                            : !A.test(n.which)) &&
                        !this.disabled &&
                        !e(this).hasClass("disabled")
                    ) {
                        var i = t._getParentFromElement(this),
                            o = e(i).hasClass("show");
                        if (o || 27 !== n.which) {
                            if (
                                (n.preventDefault(),
                                n.stopPropagation(),
                                !o || (o && (27 === n.which || 32 === n.which)))
                            )
                                return (
                                    27 === n.which &&
                                        e(
                                            i.querySelector(
                                                '[data-toggle="dropdown"]'
                                            )
                                        ).trigger("focus"),
                                    void e(this).trigger("click")
                                );
                            var s = [].slice
                                .call(
                                    i.querySelectorAll(
                                        ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)"
                                    )
                                )
                                .filter(function (t) {
                                    return e(t).is(":visible");
                                });
                            if (0 !== s.length) {
                                var r = s.indexOf(n.target);
                                38 === n.which && r > 0 && r--,
                                    40 === n.which && r < s.length - 1 && r++,
                                    r < 0 && (r = 0),
                                    s[r].focus();
                            }
                        }
                    }
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return I;
                        },
                    },
                    {
                        key: "DefaultType",
                        get: function () {
                            return O;
                        },
                    },
                ]),
                t
            );
        })();
    e(document)
        .on(
            "keydown.bs.dropdown.data-api",
            '[data-toggle="dropdown"]',
            j._dataApiKeydownHandler
        )
        .on(
            "keydown.bs.dropdown.data-api",
            ".dropdown-menu",
            j._dataApiKeydownHandler
        )
        .on(
            "click.bs.dropdown.data-api keyup.bs.dropdown.data-api",
            j._clearMenus
        )
        .on(
            "click.bs.dropdown.data-api",
            '[data-toggle="dropdown"]',
            function (t) {
                t.preventDefault(),
                    t.stopPropagation(),
                    j._jQueryInterface.call(e(this), "toggle");
            }
        )
        .on("click.bs.dropdown.data-api", ".dropdown form", function (t) {
            t.stopPropagation();
        }),
        (e.fn[k] = j._jQueryInterface),
        (e.fn[k].Constructor = j),
        (e.fn[k].noConflict = function () {
            return (e.fn[k] = N), j._jQueryInterface;
        });
    var P = e.fn.modal,
        x = { backdrop: !0, keyboard: !0, focus: !0, show: !0 },
        L = {
            backdrop: "(boolean|string)",
            keyboard: "boolean",
            focus: "boolean",
            show: "boolean",
        },
        R = (function () {
            function t(t, e) {
                (this._config = this._getConfig(e)),
                    (this._element = t),
                    (this._dialog = t.querySelector(".modal-dialog")),
                    (this._backdrop = null),
                    (this._isShown = !1),
                    (this._isBodyOverflowing = !1),
                    (this._ignoreBackdropClick = !1),
                    (this._isTransitioning = !1),
                    (this._scrollbarWidth = 0);
            }
            var n = t.prototype;
            return (
                (n.toggle = function (t) {
                    return this._isShown ? this.hide() : this.show(t);
                }),
                (n.show = function (t) {
                    var n = this;
                    if (!this._isShown && !this._isTransitioning) {
                        e(this._element).hasClass("fade") &&
                            (this._isTransitioning = !0);
                        var i = e.Event("show.bs.modal", { relatedTarget: t });
                        e(this._element).trigger(i),
                            this._isShown ||
                                i.isDefaultPrevented() ||
                                ((this._isShown = !0),
                                this._checkScrollbar(),
                                this._setScrollbar(),
                                this._adjustDialog(),
                                this._setEscapeEvent(),
                                this._setResizeEvent(),
                                e(this._element).on(
                                    "click.dismiss.bs.modal",
                                    '[data-dismiss="modal"]',
                                    function (t) {
                                        return n.hide(t);
                                    }
                                ),
                                e(this._dialog).on(
                                    "mousedown.dismiss.bs.modal",
                                    function () {
                                        e(n._element).one(
                                            "mouseup.dismiss.bs.modal",
                                            function (t) {
                                                e(t.target).is(n._element) &&
                                                    (n._ignoreBackdropClick =
                                                        !0);
                                            }
                                        );
                                    }
                                ),
                                this._showBackdrop(function () {
                                    return n._showElement(t);
                                }));
                    }
                }),
                (n.hide = function (t) {
                    var n = this;
                    if (
                        (t && t.preventDefault(),
                        this._isShown && !this._isTransitioning)
                    ) {
                        var i = e.Event("hide.bs.modal");
                        if (
                            (e(this._element).trigger(i),
                            this._isShown && !i.isDefaultPrevented())
                        ) {
                            this._isShown = !1;
                            var o = e(this._element).hasClass("fade");
                            if (
                                (o && (this._isTransitioning = !0),
                                this._setEscapeEvent(),
                                this._setResizeEvent(),
                                e(document).off("focusin.bs.modal"),
                                e(this._element).removeClass("show"),
                                e(this._element).off("click.dismiss.bs.modal"),
                                e(this._dialog).off(
                                    "mousedown.dismiss.bs.modal"
                                ),
                                o)
                            ) {
                                var s = c.getTransitionDurationFromElement(
                                    this._element
                                );
                                e(this._element)
                                    .one(c.TRANSITION_END, function (t) {
                                        return n._hideModal(t);
                                    })
                                    .emulateTransitionEnd(s);
                            } else this._hideModal();
                        }
                    }
                }),
                (n.dispose = function () {
                    [window, this._element, this._dialog].forEach(function (t) {
                        return e(t).off(".bs.modal");
                    }),
                        e(document).off("focusin.bs.modal"),
                        e.removeData(this._element, "bs.modal"),
                        (this._config = null),
                        (this._element = null),
                        (this._dialog = null),
                        (this._backdrop = null),
                        (this._isShown = null),
                        (this._isBodyOverflowing = null),
                        (this._ignoreBackdropClick = null),
                        (this._isTransitioning = null),
                        (this._scrollbarWidth = null);
                }),
                (n.handleUpdate = function () {
                    this._adjustDialog();
                }),
                (n._getConfig = function (t) {
                    return (
                        (t = a(a({}, x), t)),
                        c.typeCheckConfig("modal", t, L),
                        t
                    );
                }),
                (n._triggerBackdropTransition = function () {
                    var t = this;
                    if ("static" === this._config.backdrop) {
                        var n = e.Event("hidePrevented.bs.modal");
                        if ((e(this._element).trigger(n), n.defaultPrevented))
                            return;
                        this._element.classList.add("modal-static");
                        var i = c.getTransitionDurationFromElement(
                            this._element
                        );
                        e(this._element)
                            .one(c.TRANSITION_END, function () {
                                t._element.classList.remove("modal-static");
                            })
                            .emulateTransitionEnd(i),
                            this._element.focus();
                    } else this.hide();
                }),
                (n._showElement = function (t) {
                    var n = this,
                        i = e(this._element).hasClass("fade"),
                        o = this._dialog
                            ? this._dialog.querySelector(".modal-body")
                            : null;
                    (this._element.parentNode &&
                        this._element.parentNode.nodeType ===
                            Node.ELEMENT_NODE) ||
                        document.body.appendChild(this._element),
                        (this._element.style.display = "block"),
                        this._element.removeAttribute("aria-hidden"),
                        this._element.setAttribute("aria-modal", !0),
                        e(this._dialog).hasClass("modal-dialog-scrollable") && o
                            ? (o.scrollTop = 0)
                            : (this._element.scrollTop = 0),
                        i && c.reflow(this._element),
                        e(this._element).addClass("show"),
                        this._config.focus && this._enforceFocus();
                    var s = e.Event("shown.bs.modal", { relatedTarget: t }),
                        r = function () {
                            n._config.focus && n._element.focus(),
                                (n._isTransitioning = !1),
                                e(n._element).trigger(s);
                        };
                    if (i) {
                        var a = c.getTransitionDurationFromElement(
                            this._dialog
                        );
                        e(this._dialog)
                            .one(c.TRANSITION_END, r)
                            .emulateTransitionEnd(a);
                    } else r();
                }),
                (n._enforceFocus = function () {
                    var t = this;
                    e(document)
                        .off("focusin.bs.modal")
                        .on("focusin.bs.modal", function (n) {
                            document !== n.target &&
                                t._element !== n.target &&
                                0 === e(t._element).has(n.target).length &&
                                t._element.focus();
                        });
                }),
                (n._setEscapeEvent = function () {
                    var t = this;
                    this._isShown
                        ? e(this._element).on(
                              "keydown.dismiss.bs.modal",
                              function (e) {
                                  t._config.keyboard && 27 === e.which
                                      ? (e.preventDefault(), t.hide())
                                      : t._config.keyboard ||
                                        27 !== e.which ||
                                        t._triggerBackdropTransition();
                              }
                          )
                        : this._isShown ||
                          e(this._element).off("keydown.dismiss.bs.modal");
                }),
                (n._setResizeEvent = function () {
                    var t = this;
                    this._isShown
                        ? e(window).on("resize.bs.modal", function (e) {
                              return t.handleUpdate(e);
                          })
                        : e(window).off("resize.bs.modal");
                }),
                (n._hideModal = function () {
                    var t = this;
                    (this._element.style.display = "none"),
                        this._element.setAttribute("aria-hidden", !0),
                        this._element.removeAttribute("aria-modal"),
                        (this._isTransitioning = !1),
                        this._showBackdrop(function () {
                            e(document.body).removeClass("modal-open"),
                                t._resetAdjustments(),
                                t._resetScrollbar(),
                                e(t._element).trigger("hidden.bs.modal");
                        });
                }),
                (n._removeBackdrop = function () {
                    this._backdrop &&
                        (e(this._backdrop).remove(), (this._backdrop = null));
                }),
                (n._showBackdrop = function (t) {
                    var n = this,
                        i = e(this._element).hasClass("fade") ? "fade" : "";
                    if (this._isShown && this._config.backdrop) {
                        if (
                            ((this._backdrop = document.createElement("div")),
                            (this._backdrop.className = "modal-backdrop"),
                            i && this._backdrop.classList.add(i),
                            e(this._backdrop).appendTo(document.body),
                            e(this._element).on(
                                "click.dismiss.bs.modal",
                                function (t) {
                                    n._ignoreBackdropClick
                                        ? (n._ignoreBackdropClick = !1)
                                        : t.target === t.currentTarget &&
                                          n._triggerBackdropTransition();
                                }
                            ),
                            i && c.reflow(this._backdrop),
                            e(this._backdrop).addClass("show"),
                            !t)
                        )
                            return;
                        if (!i) return void t();
                        var o = c.getTransitionDurationFromElement(
                            this._backdrop
                        );
                        e(this._backdrop)
                            .one(c.TRANSITION_END, t)
                            .emulateTransitionEnd(o);
                    } else if (!this._isShown && this._backdrop) {
                        e(this._backdrop).removeClass("show");
                        var s = function () {
                            n._removeBackdrop(), t && t();
                        };
                        if (e(this._element).hasClass("fade")) {
                            var r = c.getTransitionDurationFromElement(
                                this._backdrop
                            );
                            e(this._backdrop)
                                .one(c.TRANSITION_END, s)
                                .emulateTransitionEnd(r);
                        } else s();
                    } else t && t();
                }),
                (n._adjustDialog = function () {
                    var t =
                        this._element.scrollHeight >
                        document.documentElement.clientHeight;
                    !this._isBodyOverflowing &&
                        t &&
                        (this._element.style.paddingLeft =
                            this._scrollbarWidth + "px"),
                        this._isBodyOverflowing &&
                            !t &&
                            (this._element.style.paddingRight =
                                this._scrollbarWidth + "px");
                }),
                (n._resetAdjustments = function () {
                    (this._element.style.paddingLeft = ""),
                        (this._element.style.paddingRight = "");
                }),
                (n._checkScrollbar = function () {
                    var t = document.body.getBoundingClientRect();
                    (this._isBodyOverflowing =
                        Math.round(t.left + t.right) < window.innerWidth),
                        (this._scrollbarWidth = this._getScrollbarWidth());
                }),
                (n._setScrollbar = function () {
                    var t = this;
                    if (this._isBodyOverflowing) {
                        var n = [].slice.call(
                                document.querySelectorAll(
                                    ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top"
                                )
                            ),
                            i = [].slice.call(
                                document.querySelectorAll(".sticky-top")
                            );
                        e(n).each(function (n, i) {
                            var o = i.style.paddingRight,
                                s = e(i).css("padding-right");
                            e(i)
                                .data("padding-right", o)
                                .css(
                                    "padding-right",
                                    parseFloat(s) + t._scrollbarWidth + "px"
                                );
                        }),
                            e(i).each(function (n, i) {
                                var o = i.style.marginRight,
                                    s = e(i).css("margin-right");
                                e(i)
                                    .data("margin-right", o)
                                    .css(
                                        "margin-right",
                                        parseFloat(s) - t._scrollbarWidth + "px"
                                    );
                            });
                        var o = document.body.style.paddingRight,
                            s = e(document.body).css("padding-right");
                        e(document.body)
                            .data("padding-right", o)
                            .css(
                                "padding-right",
                                parseFloat(s) + this._scrollbarWidth + "px"
                            );
                    }
                    e(document.body).addClass("modal-open");
                }),
                (n._resetScrollbar = function () {
                    var t = [].slice.call(
                        document.querySelectorAll(
                            ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top"
                        )
                    );
                    e(t).each(function (t, n) {
                        var i = e(n).data("padding-right");
                        e(n).removeData("padding-right"),
                            (n.style.paddingRight = i || "");
                    });
                    var n = [].slice.call(
                        document.querySelectorAll(".sticky-top")
                    );
                    e(n).each(function (t, n) {
                        var i = e(n).data("margin-right");
                        "undefined" != typeof i &&
                            e(n)
                                .css("margin-right", i)
                                .removeData("margin-right");
                    });
                    var i = e(document.body).data("padding-right");
                    e(document.body).removeData("padding-right"),
                        (document.body.style.paddingRight = i || "");
                }),
                (n._getScrollbarWidth = function () {
                    var t = document.createElement("div");
                    (t.className = "modal-scrollbar-measure"),
                        document.body.appendChild(t);
                    var e = t.getBoundingClientRect().width - t.clientWidth;
                    return document.body.removeChild(t), e;
                }),
                (t._jQueryInterface = function (n, i) {
                    return this.each(function () {
                        var o = e(this).data("bs.modal"),
                            s = a(
                                a(a({}, x), e(this).data()),
                                "object" == typeof n && n ? n : {}
                            );
                        if (
                            (o ||
                                ((o = new t(this, s)),
                                e(this).data("bs.modal", o)),
                            "string" == typeof n)
                        ) {
                            if ("undefined" == typeof o[n])
                                throw new TypeError(
                                    'No method named "' + n + '"'
                                );
                            o[n](i);
                        } else s.show && o.show(i);
                    });
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return x;
                        },
                    },
                ]),
                t
            );
        })();
    e(document).on(
        "click.bs.modal.data-api",
        '[data-toggle="modal"]',
        function (t) {
            var n,
                i = this,
                o = c.getSelectorFromElement(this);
            o && (n = document.querySelector(o));
            var s = e(n).data("bs.modal")
                ? "toggle"
                : a(a({}, e(n).data()), e(this).data());
            ("A" !== this.tagName && "AREA" !== this.tagName) ||
                t.preventDefault();
            var r = e(n).one("show.bs.modal", function (t) {
                t.isDefaultPrevented() ||
                    r.one("hidden.bs.modal", function () {
                        e(i).is(":visible") && i.focus();
                    });
            });
            R._jQueryInterface.call(e(n), s, this);
        }
    ),
        (e.fn.modal = R._jQueryInterface),
        (e.fn.modal.Constructor = R),
        (e.fn.modal.noConflict = function () {
            return (e.fn.modal = P), R._jQueryInterface;
        });
    var q = [
            "background",
            "cite",
            "href",
            "itemtype",
            "longdesc",
            "poster",
            "src",
            "xlink:href",
        ],
        F = {
            "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i],
            a: ["target", "href", "title", "rel"],
            area: [],
            b: [],
            br: [],
            col: [],
            code: [],
            div: [],
            em: [],
            hr: [],
            h1: [],
            h2: [],
            h3: [],
            h4: [],
            h5: [],
            h6: [],
            i: [],
            img: ["src", "srcset", "alt", "title", "width", "height"],
            li: [],
            ol: [],
            p: [],
            pre: [],
            s: [],
            small: [],
            span: [],
            sub: [],
            sup: [],
            strong: [],
            u: [],
            ul: [],
        },
        Q = /^(?:(?:https?|mailto|ftp|tel|file):|[^#&/:?]*(?:[#/?]|$))/gi,
        B =
            /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i;
    function H(t, e, n) {
        if (0 === t.length) return t;
        if (n && "function" == typeof n) return n(t);
        for (
            var i = new window.DOMParser().parseFromString(t, "text/html"),
                o = Object.keys(e),
                s = [].slice.call(i.body.querySelectorAll("*")),
                r = function (t, n) {
                    var i = s[t],
                        r = i.nodeName.toLowerCase();
                    if (-1 === o.indexOf(i.nodeName.toLowerCase()))
                        return i.parentNode.removeChild(i), "continue";
                    var a = [].slice.call(i.attributes),
                        l = [].concat(e["*"] || [], e[r] || []);
                    a.forEach(function (t) {
                        (function (t, e) {
                            var n = t.nodeName.toLowerCase();
                            if (-1 !== e.indexOf(n))
                                return (
                                    -1 === q.indexOf(n) ||
                                    Boolean(
                                        t.nodeValue.match(Q) ||
                                            t.nodeValue.match(B)
                                    )
                                );
                            for (
                                var i = e.filter(function (t) {
                                        return t instanceof RegExp;
                                    }),
                                    o = 0,
                                    s = i.length;
                                o < s;
                                o++
                            )
                                if (n.match(i[o])) return !0;
                            return !1;
                        })(t, l) || i.removeAttribute(t.nodeName);
                    });
                },
                a = 0,
                l = s.length;
            a < l;
            a++
        )
            r(a);
        return i.body.innerHTML;
    }
    var U = "tooltip",
        M = e.fn[U],
        W = new RegExp("(^|\\s)bs-tooltip\\S+", "g"),
        V = ["sanitize", "whiteList", "sanitizeFn"],
        z = {
            animation: "boolean",
            template: "string",
            title: "(string|element|function)",
            trigger: "string",
            delay: "(number|object)",
            html: "boolean",
            selector: "(string|boolean)",
            placement: "(string|function)",
            offset: "(number|string|function)",
            container: "(string|element|boolean)",
            fallbackPlacement: "(string|array)",
            boundary: "(string|element)",
            sanitize: "boolean",
            sanitizeFn: "(null|function)",
            whiteList: "object",
            popperConfig: "(null|object)",
        },
        K = {
            AUTO: "auto",
            TOP: "top",
            RIGHT: "right",
            BOTTOM: "bottom",
            LEFT: "left",
        },
        X = {
            animation: !0,
            template:
                '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !1,
            selector: !1,
            placement: "top",
            offset: 0,
            container: !1,
            fallbackPlacement: "flip",
            boundary: "scrollParent",
            sanitize: !0,
            sanitizeFn: null,
            whiteList: F,
            popperConfig: null,
        },
        Y = {
            HIDE: "hide.bs.tooltip",
            HIDDEN: "hidden.bs.tooltip",
            SHOW: "show.bs.tooltip",
            SHOWN: "shown.bs.tooltip",
            INSERTED: "inserted.bs.tooltip",
            CLICK: "click.bs.tooltip",
            FOCUSIN: "focusin.bs.tooltip",
            FOCUSOUT: "focusout.bs.tooltip",
            MOUSEENTER: "mouseenter.bs.tooltip",
            MOUSELEAVE: "mouseleave.bs.tooltip",
        },
        $ = (function () {
            function t(t, e) {
                if ("undefined" == typeof n)
                    throw new TypeError(
                        "Bootstrap's tooltips require Popper.js (https://popper.js.org/)"
                    );
                (this._isEnabled = !0),
                    (this._timeout = 0),
                    (this._hoverState = ""),
                    (this._activeTrigger = {}),
                    (this._popper = null),
                    (this.element = t),
                    (this.config = this._getConfig(e)),
                    (this.tip = null),
                    this._setListeners();
            }
            var i = t.prototype;
            return (
                (i.enable = function () {
                    this._isEnabled = !0;
                }),
                (i.disable = function () {
                    this._isEnabled = !1;
                }),
                (i.toggleEnabled = function () {
                    this._isEnabled = !this._isEnabled;
                }),
                (i.toggle = function (t) {
                    if (this._isEnabled)
                        if (t) {
                            var n = this.constructor.DATA_KEY,
                                i = e(t.currentTarget).data(n);
                            i ||
                                ((i = new this.constructor(
                                    t.currentTarget,
                                    this._getDelegateConfig()
                                )),
                                e(t.currentTarget).data(n, i)),
                                (i._activeTrigger.click =
                                    !i._activeTrigger.click),
                                i._isWithActiveTrigger()
                                    ? i._enter(null, i)
                                    : i._leave(null, i);
                        } else {
                            if (e(this.getTipElement()).hasClass("show"))
                                return void this._leave(null, this);
                            this._enter(null, this);
                        }
                }),
                (i.dispose = function () {
                    clearTimeout(this._timeout),
                        e.removeData(this.element, this.constructor.DATA_KEY),
                        e(this.element).off(this.constructor.EVENT_KEY),
                        e(this.element)
                            .closest(".modal")
                            .off("hide.bs.modal", this._hideModalHandler),
                        this.tip && e(this.tip).remove(),
                        (this._isEnabled = null),
                        (this._timeout = null),
                        (this._hoverState = null),
                        (this._activeTrigger = null),
                        this._popper && this._popper.destroy(),
                        (this._popper = null),
                        (this.element = null),
                        (this.config = null),
                        (this.tip = null);
                }),
                (i.show = function () {
                    var t = this;
                    if ("none" === e(this.element).css("display"))
                        throw new Error("Please use show on visible elements");
                    var i = e.Event(this.constructor.Event.SHOW);
                    if (this.isWithContent() && this._isEnabled) {
                        e(this.element).trigger(i);
                        var o = c.findShadowRoot(this.element),
                            s = e.contains(
                                null !== o
                                    ? o
                                    : this.element.ownerDocument
                                          .documentElement,
                                this.element
                            );
                        if (i.isDefaultPrevented() || !s) return;
                        var r = this.getTipElement(),
                            a = c.getUID(this.constructor.NAME);
                        r.setAttribute("id", a),
                            this.element.setAttribute("aria-describedby", a),
                            this.setContent(),
                            this.config.animation && e(r).addClass("fade");
                        var l =
                                "function" == typeof this.config.placement
                                    ? this.config.placement.call(
                                          this,
                                          r,
                                          this.element
                                      )
                                    : this.config.placement,
                            h = this._getAttachment(l);
                        this.addAttachmentClass(h);
                        var u = this._getContainer();
                        e(r).data(this.constructor.DATA_KEY, this),
                            e.contains(
                                this.element.ownerDocument.documentElement,
                                this.tip
                            ) || e(r).appendTo(u),
                            e(this.element).trigger(
                                this.constructor.Event.INSERTED
                            ),
                            (this._popper = new n(
                                this.element,
                                r,
                                this._getPopperConfig(h)
                            )),
                            e(r).addClass("show"),
                            "ontouchstart" in document.documentElement &&
                                e(document.body)
                                    .children()
                                    .on("mouseover", null, e.noop);
                        var d = function () {
                            t.config.animation && t._fixTransition();
                            var n = t._hoverState;
                            (t._hoverState = null),
                                e(t.element).trigger(t.constructor.Event.SHOWN),
                                "out" === n && t._leave(null, t);
                        };
                        if (e(this.tip).hasClass("fade")) {
                            var f = c.getTransitionDurationFromElement(
                                this.tip
                            );
                            e(this.tip)
                                .one(c.TRANSITION_END, d)
                                .emulateTransitionEnd(f);
                        } else d();
                    }
                }),
                (i.hide = function (t) {
                    var n = this,
                        i = this.getTipElement(),
                        o = e.Event(this.constructor.Event.HIDE),
                        s = function () {
                            "show" !== n._hoverState &&
                                i.parentNode &&
                                i.parentNode.removeChild(i),
                                n._cleanTipClass(),
                                n.element.removeAttribute("aria-describedby"),
                                e(n.element).trigger(
                                    n.constructor.Event.HIDDEN
                                ),
                                null !== n._popper && n._popper.destroy(),
                                t && t();
                        };
                    if ((e(this.element).trigger(o), !o.isDefaultPrevented())) {
                        if (
                            (e(i).removeClass("show"),
                            "ontouchstart" in document.documentElement &&
                                e(document.body)
                                    .children()
                                    .off("mouseover", null, e.noop),
                            (this._activeTrigger.click = !1),
                            (this._activeTrigger.focus = !1),
                            (this._activeTrigger.hover = !1),
                            e(this.tip).hasClass("fade"))
                        ) {
                            var r = c.getTransitionDurationFromElement(i);
                            e(i)
                                .one(c.TRANSITION_END, s)
                                .emulateTransitionEnd(r);
                        } else s();
                        this._hoverState = "";
                    }
                }),
                (i.update = function () {
                    null !== this._popper && this._popper.scheduleUpdate();
                }),
                (i.isWithContent = function () {
                    return Boolean(this.getTitle());
                }),
                (i.addAttachmentClass = function (t) {
                    e(this.getTipElement()).addClass("bs-tooltip-" + t);
                }),
                (i.getTipElement = function () {
                    return (
                        (this.tip = this.tip || e(this.config.template)[0]),
                        this.tip
                    );
                }),
                (i.setContent = function () {
                    var t = this.getTipElement();
                    this.setElementContent(
                        e(t.querySelectorAll(".tooltip-inner")),
                        this.getTitle()
                    ),
                        e(t).removeClass("fade show");
                }),
                (i.setElementContent = function (t, n) {
                    "object" != typeof n || (!n.nodeType && !n.jquery)
                        ? this.config.html
                            ? (this.config.sanitize &&
                                  (n = H(
                                      n,
                                      this.config.whiteList,
                                      this.config.sanitizeFn
                                  )),
                              t.html(n))
                            : t.text(n)
                        : this.config.html
                        ? e(n).parent().is(t) || t.empty().append(n)
                        : t.text(e(n).text());
                }),
                (i.getTitle = function () {
                    var t = this.element.getAttribute("data-original-title");
                    return (
                        t ||
                            (t =
                                "function" == typeof this.config.title
                                    ? this.config.title.call(this.element)
                                    : this.config.title),
                        t
                    );
                }),
                (i._getPopperConfig = function (t) {
                    var e = this;
                    return a(
                        a(
                            {},
                            {
                                placement: t,
                                modifiers: {
                                    offset: this._getOffset(),
                                    flip: {
                                        behavior: this.config.fallbackPlacement,
                                    },
                                    arrow: { element: ".arrow" },
                                    preventOverflow: {
                                        boundariesElement: this.config.boundary,
                                    },
                                },
                                onCreate: function (t) {
                                    t.originalPlacement !== t.placement &&
                                        e._handlePopperPlacementChange(t);
                                },
                                onUpdate: function (t) {
                                    return e._handlePopperPlacementChange(t);
                                },
                            }
                        ),
                        this.config.popperConfig
                    );
                }),
                (i._getOffset = function () {
                    var t = this,
                        e = {};
                    return (
                        "function" == typeof this.config.offset
                            ? (e.fn = function (e) {
                                  return (
                                      (e.offsets = a(
                                          a({}, e.offsets),
                                          t.config.offset(
                                              e.offsets,
                                              t.element
                                          ) || {}
                                      )),
                                      e
                                  );
                              })
                            : (e.offset = this.config.offset),
                        e
                    );
                }),
                (i._getContainer = function () {
                    return !1 === this.config.container
                        ? document.body
                        : c.isElement(this.config.container)
                        ? e(this.config.container)
                        : e(document).find(this.config.container);
                }),
                (i._getAttachment = function (t) {
                    return K[t.toUpperCase()];
                }),
                (i._setListeners = function () {
                    var t = this;
                    this.config.trigger.split(" ").forEach(function (n) {
                        if ("click" === n)
                            e(t.element).on(
                                t.constructor.Event.CLICK,
                                t.config.selector,
                                function (e) {
                                    return t.toggle(e);
                                }
                            );
                        else if ("manual" !== n) {
                            var i =
                                    "hover" === n
                                        ? t.constructor.Event.MOUSEENTER
                                        : t.constructor.Event.FOCUSIN,
                                o =
                                    "hover" === n
                                        ? t.constructor.Event.MOUSELEAVE
                                        : t.constructor.Event.FOCUSOUT;
                            e(t.element)
                                .on(i, t.config.selector, function (e) {
                                    return t._enter(e);
                                })
                                .on(o, t.config.selector, function (e) {
                                    return t._leave(e);
                                });
                        }
                    }),
                        (this._hideModalHandler = function () {
                            t.element && t.hide();
                        }),
                        e(this.element)
                            .closest(".modal")
                            .on("hide.bs.modal", this._hideModalHandler),
                        this.config.selector
                            ? (this.config = a(
                                  a({}, this.config),
                                  {},
                                  { trigger: "manual", selector: "" }
                              ))
                            : this._fixTitle();
                }),
                (i._fixTitle = function () {
                    var t = typeof this.element.getAttribute(
                        "data-original-title"
                    );
                    (this.element.getAttribute("title") || "string" !== t) &&
                        (this.element.setAttribute(
                            "data-original-title",
                            this.element.getAttribute("title") || ""
                        ),
                        this.element.setAttribute("title", ""));
                }),
                (i._enter = function (t, n) {
                    var i = this.constructor.DATA_KEY;
                    (n = n || e(t.currentTarget).data(i)) ||
                        ((n = new this.constructor(
                            t.currentTarget,
                            this._getDelegateConfig()
                        )),
                        e(t.currentTarget).data(i, n)),
                        t &&
                            (n._activeTrigger[
                                "focusin" === t.type ? "focus" : "hover"
                            ] = !0),
                        e(n.getTipElement()).hasClass("show") ||
                        "show" === n._hoverState
                            ? (n._hoverState = "show")
                            : (clearTimeout(n._timeout),
                              (n._hoverState = "show"),
                              n.config.delay && n.config.delay.show
                                  ? (n._timeout = setTimeout(function () {
                                        "show" === n._hoverState && n.show();
                                    }, n.config.delay.show))
                                  : n.show());
                }),
                (i._leave = function (t, n) {
                    var i = this.constructor.DATA_KEY;
                    (n = n || e(t.currentTarget).data(i)) ||
                        ((n = new this.constructor(
                            t.currentTarget,
                            this._getDelegateConfig()
                        )),
                        e(t.currentTarget).data(i, n)),
                        t &&
                            (n._activeTrigger[
                                "focusout" === t.type ? "focus" : "hover"
                            ] = !1),
                        n._isWithActiveTrigger() ||
                            (clearTimeout(n._timeout),
                            (n._hoverState = "out"),
                            n.config.delay && n.config.delay.hide
                                ? (n._timeout = setTimeout(function () {
                                      "out" === n._hoverState && n.hide();
                                  }, n.config.delay.hide))
                                : n.hide());
                }),
                (i._isWithActiveTrigger = function () {
                    for (var t in this._activeTrigger)
                        if (this._activeTrigger[t]) return !0;
                    return !1;
                }),
                (i._getConfig = function (t) {
                    var n = e(this.element).data();
                    return (
                        Object.keys(n).forEach(function (t) {
                            -1 !== V.indexOf(t) && delete n[t];
                        }),
                        "number" ==
                            typeof (t = a(
                                a(a({}, this.constructor.Default), n),
                                "object" == typeof t && t ? t : {}
                            )).delay &&
                            (t.delay = { show: t.delay, hide: t.delay }),
                        "number" == typeof t.title &&
                            (t.title = t.title.toString()),
                        "number" == typeof t.content &&
                            (t.content = t.content.toString()),
                        c.typeCheckConfig(U, t, this.constructor.DefaultType),
                        t.sanitize &&
                            (t.template = H(
                                t.template,
                                t.whiteList,
                                t.sanitizeFn
                            )),
                        t
                    );
                }),
                (i._getDelegateConfig = function () {
                    var t = {};
                    if (this.config)
                        for (var e in this.config)
                            this.constructor.Default[e] !== this.config[e] &&
                                (t[e] = this.config[e]);
                    return t;
                }),
                (i._cleanTipClass = function () {
                    var t = e(this.getTipElement()),
                        n = t.attr("class").match(W);
                    null !== n && n.length && t.removeClass(n.join(""));
                }),
                (i._handlePopperPlacementChange = function (t) {
                    (this.tip = t.instance.popper),
                        this._cleanTipClass(),
                        this.addAttachmentClass(
                            this._getAttachment(t.placement)
                        );
                }),
                (i._fixTransition = function () {
                    var t = this.getTipElement(),
                        n = this.config.animation;
                    null === t.getAttribute("x-placement") &&
                        (e(t).removeClass("fade"),
                        (this.config.animation = !1),
                        this.hide(),
                        this.show(),
                        (this.config.animation = n));
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this).data("bs.tooltip"),
                            o = "object" == typeof n && n;
                        if (
                            (i || !/dispose|hide/.test(n)) &&
                            (i ||
                                ((i = new t(this, o)),
                                e(this).data("bs.tooltip", i)),
                            "string" == typeof n)
                        ) {
                            if ("undefined" == typeof i[n])
                                throw new TypeError(
                                    'No method named "' + n + '"'
                                );
                            i[n]();
                        }
                    });
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return X;
                        },
                    },
                    {
                        key: "NAME",
                        get: function () {
                            return U;
                        },
                    },
                    {
                        key: "DATA_KEY",
                        get: function () {
                            return "bs.tooltip";
                        },
                    },
                    {
                        key: "Event",
                        get: function () {
                            return Y;
                        },
                    },
                    {
                        key: "EVENT_KEY",
                        get: function () {
                            return ".bs.tooltip";
                        },
                    },
                    {
                        key: "DefaultType",
                        get: function () {
                            return z;
                        },
                    },
                ]),
                t
            );
        })();
    (e.fn[U] = $._jQueryInterface),
        (e.fn[U].Constructor = $),
        (e.fn[U].noConflict = function () {
            return (e.fn[U] = M), $._jQueryInterface;
        });
    var J = "popover",
        G = e.fn[J],
        Z = new RegExp("(^|\\s)bs-popover\\S+", "g"),
        tt = a(
            a({}, $.Default),
            {},
            {
                placement: "right",
                trigger: "click",
                content: "",
                template:
                    '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
            }
        ),
        et = a(
            a({}, $.DefaultType),
            {},
            { content: "(string|element|function)" }
        ),
        nt = {
            HIDE: "hide.bs.popover",
            HIDDEN: "hidden.bs.popover",
            SHOW: "show.bs.popover",
            SHOWN: "shown.bs.popover",
            INSERTED: "inserted.bs.popover",
            CLICK: "click.bs.popover",
            FOCUSIN: "focusin.bs.popover",
            FOCUSOUT: "focusout.bs.popover",
            MOUSEENTER: "mouseenter.bs.popover",
            MOUSELEAVE: "mouseleave.bs.popover",
        },
        it = (function (t) {
            var n, i;
            function s() {
                return t.apply(this, arguments) || this;
            }
            (i = t),
                ((n = s).prototype = Object.create(i.prototype)),
                (n.prototype.constructor = n),
                (n.__proto__ = i);
            var r = s.prototype;
            return (
                (r.isWithContent = function () {
                    return this.getTitle() || this._getContent();
                }),
                (r.addAttachmentClass = function (t) {
                    e(this.getTipElement()).addClass("bs-popover-" + t);
                }),
                (r.getTipElement = function () {
                    return (
                        (this.tip = this.tip || e(this.config.template)[0]),
                        this.tip
                    );
                }),
                (r.setContent = function () {
                    var t = e(this.getTipElement());
                    this.setElementContent(
                        t.find(".popover-header"),
                        this.getTitle()
                    );
                    var n = this._getContent();
                    "function" == typeof n && (n = n.call(this.element)),
                        this.setElementContent(t.find(".popover-body"), n),
                        t.removeClass("fade show");
                }),
                (r._getContent = function () {
                    return (
                        this.element.getAttribute("data-content") ||
                        this.config.content
                    );
                }),
                (r._cleanTipClass = function () {
                    var t = e(this.getTipElement()),
                        n = t.attr("class").match(Z);
                    null !== n && n.length > 0 && t.removeClass(n.join(""));
                }),
                (s._jQueryInterface = function (t) {
                    return this.each(function () {
                        var n = e(this).data("bs.popover"),
                            i = "object" == typeof t ? t : null;
                        if (
                            (n || !/dispose|hide/.test(t)) &&
                            (n ||
                                ((n = new s(this, i)),
                                e(this).data("bs.popover", n)),
                            "string" == typeof t)
                        ) {
                            if ("undefined" == typeof n[t])
                                throw new TypeError(
                                    'No method named "' + t + '"'
                                );
                            n[t]();
                        }
                    });
                }),
                o(s, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return tt;
                        },
                    },
                    {
                        key: "NAME",
                        get: function () {
                            return J;
                        },
                    },
                    {
                        key: "DATA_KEY",
                        get: function () {
                            return "bs.popover";
                        },
                    },
                    {
                        key: "Event",
                        get: function () {
                            return nt;
                        },
                    },
                    {
                        key: "EVENT_KEY",
                        get: function () {
                            return ".bs.popover";
                        },
                    },
                    {
                        key: "DefaultType",
                        get: function () {
                            return et;
                        },
                    },
                ]),
                s
            );
        })($);
    (e.fn[J] = it._jQueryInterface),
        (e.fn[J].Constructor = it),
        (e.fn[J].noConflict = function () {
            return (e.fn[J] = G), it._jQueryInterface;
        });
    var ot = "scrollspy",
        st = e.fn[ot],
        rt = { offset: 10, method: "auto", target: "" },
        at = { offset: "number", method: "string", target: "(string|element)" },
        lt = (function () {
            function t(t, n) {
                var i = this;
                (this._element = t),
                    (this._scrollElement = "BODY" === t.tagName ? window : t),
                    (this._config = this._getConfig(n)),
                    (this._selector =
                        this._config.target +
                        " .nav-link," +
                        this._config.target +
                        " .list-group-item," +
                        this._config.target +
                        " .dropdown-item"),
                    (this._offsets = []),
                    (this._targets = []),
                    (this._activeTarget = null),
                    (this._scrollHeight = 0),
                    e(this._scrollElement).on(
                        "scroll.bs.scrollspy",
                        function (t) {
                            return i._process(t);
                        }
                    ),
                    this.refresh(),
                    this._process();
            }
            var n = t.prototype;
            return (
                (n.refresh = function () {
                    var t = this,
                        n =
                            this._scrollElement === this._scrollElement.window
                                ? "offset"
                                : "position",
                        i =
                            "auto" === this._config.method
                                ? n
                                : this._config.method,
                        o = "position" === i ? this._getScrollTop() : 0;
                    (this._offsets = []),
                        (this._targets = []),
                        (this._scrollHeight = this._getScrollHeight()),
                        [].slice
                            .call(document.querySelectorAll(this._selector))
                            .map(function (t) {
                                var n,
                                    s = c.getSelectorFromElement(t);
                                if ((s && (n = document.querySelector(s)), n)) {
                                    var r = n.getBoundingClientRect();
                                    if (r.width || r.height)
                                        return [e(n)[i]().top + o, s];
                                }
                                return null;
                            })
                            .filter(function (t) {
                                return t;
                            })
                            .sort(function (t, e) {
                                return t[0] - e[0];
                            })
                            .forEach(function (e) {
                                t._offsets.push(e[0]), t._targets.push(e[1]);
                            });
                }),
                (n.dispose = function () {
                    e.removeData(this._element, "bs.scrollspy"),
                        e(this._scrollElement).off(".bs.scrollspy"),
                        (this._element = null),
                        (this._scrollElement = null),
                        (this._config = null),
                        (this._selector = null),
                        (this._offsets = null),
                        (this._targets = null),
                        (this._activeTarget = null),
                        (this._scrollHeight = null);
                }),
                (n._getConfig = function (t) {
                    if (
                        "string" !=
                            typeof (t = a(
                                a({}, rt),
                                "object" == typeof t && t ? t : {}
                            )).target &&
                        c.isElement(t.target)
                    ) {
                        var n = e(t.target).attr("id");
                        n || ((n = c.getUID(ot)), e(t.target).attr("id", n)),
                            (t.target = "#" + n);
                    }
                    return c.typeCheckConfig(ot, t, at), t;
                }),
                (n._getScrollTop = function () {
                    return this._scrollElement === window
                        ? this._scrollElement.pageYOffset
                        : this._scrollElement.scrollTop;
                }),
                (n._getScrollHeight = function () {
                    return (
                        this._scrollElement.scrollHeight ||
                        Math.max(
                            document.body.scrollHeight,
                            document.documentElement.scrollHeight
                        )
                    );
                }),
                (n._getOffsetHeight = function () {
                    return this._scrollElement === window
                        ? window.innerHeight
                        : this._scrollElement.getBoundingClientRect().height;
                }),
                (n._process = function () {
                    var t = this._getScrollTop() + this._config.offset,
                        e = this._getScrollHeight(),
                        n = this._config.offset + e - this._getOffsetHeight();
                    if ((this._scrollHeight !== e && this.refresh(), t >= n)) {
                        var i = this._targets[this._targets.length - 1];
                        this._activeTarget !== i && this._activate(i);
                    } else {
                        if (
                            this._activeTarget &&
                            t < this._offsets[0] &&
                            this._offsets[0] > 0
                        )
                            return (
                                (this._activeTarget = null), void this._clear()
                            );
                        for (var o = this._offsets.length; o--; ) {
                            this._activeTarget !== this._targets[o] &&
                                t >= this._offsets[o] &&
                                ("undefined" == typeof this._offsets[o + 1] ||
                                    t < this._offsets[o + 1]) &&
                                this._activate(this._targets[o]);
                        }
                    }
                }),
                (n._activate = function (t) {
                    (this._activeTarget = t), this._clear();
                    var n = this._selector.split(",").map(function (e) {
                            return (
                                e +
                                '[data-target="' +
                                t +
                                '"],' +
                                e +
                                '[href="' +
                                t +
                                '"]'
                            );
                        }),
                        i = e(
                            [].slice.call(
                                document.querySelectorAll(n.join(","))
                            )
                        );
                    i.hasClass("dropdown-item")
                        ? (i
                              .closest(".dropdown")
                              .find(".dropdown-toggle")
                              .addClass("active"),
                          i.addClass("active"))
                        : (i.addClass("active"),
                          i
                              .parents(".nav, .list-group")
                              .prev(".nav-link, .list-group-item")
                              .addClass("active"),
                          i
                              .parents(".nav, .list-group")
                              .prev(".nav-item")
                              .children(".nav-link")
                              .addClass("active")),
                        e(this._scrollElement).trigger(
                            "activate.bs.scrollspy",
                            { relatedTarget: t }
                        );
                }),
                (n._clear = function () {
                    [].slice
                        .call(document.querySelectorAll(this._selector))
                        .filter(function (t) {
                            return t.classList.contains("active");
                        })
                        .forEach(function (t) {
                            return t.classList.remove("active");
                        });
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this).data("bs.scrollspy");
                        if (
                            (i ||
                                ((i = new t(this, "object" == typeof n && n)),
                                e(this).data("bs.scrollspy", i)),
                            "string" == typeof n)
                        ) {
                            if ("undefined" == typeof i[n])
                                throw new TypeError(
                                    'No method named "' + n + '"'
                                );
                            i[n]();
                        }
                    });
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return rt;
                        },
                    },
                ]),
                t
            );
        })();
    e(window).on("load.bs.scrollspy.data-api", function () {
        for (
            var t = [].slice.call(
                    document.querySelectorAll('[data-spy="scroll"]')
                ),
                n = t.length;
            n--;

        ) {
            var i = e(t[n]);
            lt._jQueryInterface.call(i, i.data());
        }
    }),
        (e.fn[ot] = lt._jQueryInterface),
        (e.fn[ot].Constructor = lt),
        (e.fn[ot].noConflict = function () {
            return (e.fn[ot] = st), lt._jQueryInterface;
        });
    var ct = e.fn.tab,
        ht = (function () {
            function t(t) {
                this._element = t;
            }
            var n = t.prototype;
            return (
                (n.show = function () {
                    var t = this;
                    if (
                        !(
                            (this._element.parentNode &&
                                this._element.parentNode.nodeType ===
                                    Node.ELEMENT_NODE &&
                                e(this._element).hasClass("active")) ||
                            e(this._element).hasClass("disabled")
                        )
                    ) {
                        var n,
                            i,
                            o = e(this._element).closest(
                                ".nav, .list-group"
                            )[0],
                            s = c.getSelectorFromElement(this._element);
                        if (o) {
                            var r =
                                "UL" === o.nodeName || "OL" === o.nodeName
                                    ? "> li > .active"
                                    : ".active";
                            i = (i = e.makeArray(e(o).find(r)))[i.length - 1];
                        }
                        var a = e.Event("hide.bs.tab", {
                                relatedTarget: this._element,
                            }),
                            l = e.Event("show.bs.tab", { relatedTarget: i });
                        if (
                            (i && e(i).trigger(a),
                            e(this._element).trigger(l),
                            !l.isDefaultPrevented() && !a.isDefaultPrevented())
                        ) {
                            s && (n = document.querySelector(s)),
                                this._activate(this._element, o);
                            var h = function () {
                                var n = e.Event("hidden.bs.tab", {
                                        relatedTarget: t._element,
                                    }),
                                    o = e.Event("shown.bs.tab", {
                                        relatedTarget: i,
                                    });
                                e(i).trigger(n), e(t._element).trigger(o);
                            };
                            n ? this._activate(n, n.parentNode, h) : h();
                        }
                    }
                }),
                (n.dispose = function () {
                    e.removeData(this._element, "bs.tab"),
                        (this._element = null);
                }),
                (n._activate = function (t, n, i) {
                    var o = this,
                        s = (
                            !n || ("UL" !== n.nodeName && "OL" !== n.nodeName)
                                ? e(n).children(".active")
                                : e(n).find("> li > .active")
                        )[0],
                        r = i && s && e(s).hasClass("fade"),
                        a = function () {
                            return o._transitionComplete(t, s, i);
                        };
                    if (s && r) {
                        var l = c.getTransitionDurationFromElement(s);
                        e(s)
                            .removeClass("show")
                            .one(c.TRANSITION_END, a)
                            .emulateTransitionEnd(l);
                    } else a();
                }),
                (n._transitionComplete = function (t, n, i) {
                    if (n) {
                        e(n).removeClass("active");
                        var o = e(n.parentNode).find(
                            "> .dropdown-menu .active"
                        )[0];
                        o && e(o).removeClass("active"),
                            "tab" === n.getAttribute("role") &&
                                n.setAttribute("aria-selected", !1);
                    }
                    if (
                        (e(t).addClass("active"),
                        "tab" === t.getAttribute("role") &&
                            t.setAttribute("aria-selected", !0),
                        c.reflow(t),
                        t.classList.contains("fade") && t.classList.add("show"),
                        t.parentNode &&
                            e(t.parentNode).hasClass("dropdown-menu"))
                    ) {
                        var s = e(t).closest(".dropdown")[0];
                        if (s) {
                            var r = [].slice.call(
                                s.querySelectorAll(".dropdown-toggle")
                            );
                            e(r).addClass("active");
                        }
                        t.setAttribute("aria-expanded", !0);
                    }
                    i && i();
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this),
                            o = i.data("bs.tab");
                        if (
                            (o || ((o = new t(this)), i.data("bs.tab", o)),
                            "string" == typeof n)
                        ) {
                            if ("undefined" == typeof o[n])
                                throw new TypeError(
                                    'No method named "' + n + '"'
                                );
                            o[n]();
                        }
                    });
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                ]),
                t
            );
        })();
    e(document).on(
        "click.bs.tab.data-api",
        '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',
        function (t) {
            t.preventDefault(), ht._jQueryInterface.call(e(this), "show");
        }
    ),
        (e.fn.tab = ht._jQueryInterface),
        (e.fn.tab.Constructor = ht),
        (e.fn.tab.noConflict = function () {
            return (e.fn.tab = ct), ht._jQueryInterface;
        });
    var ut = e.fn.toast,
        dt = { animation: "boolean", autohide: "boolean", delay: "number" },
        ft = { animation: !0, autohide: !0, delay: 500 },
        gt = (function () {
            function t(t, e) {
                (this._element = t),
                    (this._config = this._getConfig(e)),
                    (this._timeout = null),
                    this._setListeners();
            }
            var n = t.prototype;
            return (
                (n.show = function () {
                    var t = this,
                        n = e.Event("show.bs.toast");
                    if (
                        (e(this._element).trigger(n), !n.isDefaultPrevented())
                    ) {
                        this._config.animation &&
                            this._element.classList.add("fade");
                        var i = function () {
                            t._element.classList.remove("showing"),
                                t._element.classList.add("show"),
                                e(t._element).trigger("shown.bs.toast"),
                                t._config.autohide &&
                                    (t._timeout = setTimeout(function () {
                                        t.hide();
                                    }, t._config.delay));
                        };
                        if (
                            (this._element.classList.remove("hide"),
                            c.reflow(this._element),
                            this._element.classList.add("showing"),
                            this._config.animation)
                        ) {
                            var o = c.getTransitionDurationFromElement(
                                this._element
                            );
                            e(this._element)
                                .one(c.TRANSITION_END, i)
                                .emulateTransitionEnd(o);
                        } else i();
                    }
                }),
                (n.hide = function () {
                    if (this._element.classList.contains("show")) {
                        var t = e.Event("hide.bs.toast");
                        e(this._element).trigger(t),
                            t.isDefaultPrevented() || this._close();
                    }
                }),
                (n.dispose = function () {
                    clearTimeout(this._timeout),
                        (this._timeout = null),
                        this._element.classList.contains("show") &&
                            this._element.classList.remove("show"),
                        e(this._element).off("click.dismiss.bs.toast"),
                        e.removeData(this._element, "bs.toast"),
                        (this._element = null),
                        (this._config = null);
                }),
                (n._getConfig = function (t) {
                    return (
                        (t = a(
                            a(a({}, ft), e(this._element).data()),
                            "object" == typeof t && t ? t : {}
                        )),
                        c.typeCheckConfig(
                            "toast",
                            t,
                            this.constructor.DefaultType
                        ),
                        t
                    );
                }),
                (n._setListeners = function () {
                    var t = this;
                    e(this._element).on(
                        "click.dismiss.bs.toast",
                        '[data-dismiss="toast"]',
                        function () {
                            return t.hide();
                        }
                    );
                }),
                (n._close = function () {
                    var t = this,
                        n = function () {
                            t._element.classList.add("hide"),
                                e(t._element).trigger("hidden.bs.toast");
                        };
                    if (
                        (this._element.classList.remove("show"),
                        this._config.animation)
                    ) {
                        var i = c.getTransitionDurationFromElement(
                            this._element
                        );
                        e(this._element)
                            .one(c.TRANSITION_END, n)
                            .emulateTransitionEnd(i);
                    } else n();
                }),
                (t._jQueryInterface = function (n) {
                    return this.each(function () {
                        var i = e(this),
                            o = i.data("bs.toast");
                        if (
                            (o ||
                                ((o = new t(this, "object" == typeof n && n)),
                                i.data("bs.toast", o)),
                            "string" == typeof n)
                        ) {
                            if ("undefined" == typeof o[n])
                                throw new TypeError(
                                    'No method named "' + n + '"'
                                );
                            o[n](this);
                        }
                    });
                }),
                o(t, null, [
                    {
                        key: "VERSION",
                        get: function () {
                            return "4.5.0";
                        },
                    },
                    {
                        key: "DefaultType",
                        get: function () {
                            return dt;
                        },
                    },
                    {
                        key: "Default",
                        get: function () {
                            return ft;
                        },
                    },
                ]),
                t
            );
        })();
    (e.fn.toast = gt._jQueryInterface),
        (e.fn.toast.Constructor = gt),
        (e.fn.toast.noConflict = function () {
            return (e.fn.toast = ut), gt._jQueryInterface;
        }),
        (t.Alert = d),
        (t.Button = g),
        (t.Carousel = E),
        (t.Collapse = D),
        (t.Dropdown = j),
        (t.Modal = R),
        (t.Popover = it),
        (t.Scrollspy = lt),
        (t.Tab = ht),
        (t.Toast = gt),
        (t.Tooltip = $),
        (t.Util = c),
        Object.defineProperty(t, "__esModule", { value: !0 });
});
//# sourceMappingURL=bootstrap.min.js.map

//! moment.js
//! version : 2.18.1
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com
!(function (a, b) {
    "object" == typeof exports && "undefined" != typeof module
        ? (module.exports = b())
        : "function" == typeof define && define.amd
        ? define(b)
        : (a.moment = b());
})(this, function () {
    "use strict";
    function a() {
        return sd.apply(null, arguments);
    }
    function b(a) {
        sd = a;
    }
    function c(a) {
        return (
            a instanceof Array ||
            "[object Array]" === Object.prototype.toString.call(a)
        );
    }
    function d(a) {
        return (
            null != a && "[object Object]" === Object.prototype.toString.call(a)
        );
    }
    function e(a) {
        var b;
        for (b in a) return !1;
        return !0;
    }
    function f(a) {
        return void 0 === a;
    }
    function g(a) {
        return (
            "number" == typeof a ||
            "[object Number]" === Object.prototype.toString.call(a)
        );
    }
    function h(a) {
        return (
            a instanceof Date ||
            "[object Date]" === Object.prototype.toString.call(a)
        );
    }
    function i(a, b) {
        var c,
            d = [];
        for (c = 0; c < a.length; ++c) d.push(b(a[c], c));
        return d;
    }
    function j(a, b) {
        return Object.prototype.hasOwnProperty.call(a, b);
    }
    function k(a, b) {
        for (var c in b) j(b, c) && (a[c] = b[c]);
        return (
            j(b, "toString") && (a.toString = b.toString),
            j(b, "valueOf") && (a.valueOf = b.valueOf),
            a
        );
    }
    function l(a, b, c, d) {
        return sb(a, b, c, d, !0).utc();
    }
    function m() {
        return {
            empty: !1,
            unusedTokens: [],
            unusedInput: [],
            overflow: -2,
            charsLeftOver: 0,
            nullInput: !1,
            invalidMonth: null,
            invalidFormat: !1,
            userInvalidated: !1,
            iso: !1,
            parsedDateParts: [],
            meridiem: null,
            rfc2822: !1,
            weekdayMismatch: !1,
        };
    }
    function n(a) {
        return null == a._pf && (a._pf = m()), a._pf;
    }
    function o(a) {
        if (null == a._isValid) {
            var b = n(a),
                c = ud.call(b.parsedDateParts, function (a) {
                    return null != a;
                }),
                d =
                    !isNaN(a._d.getTime()) &&
                    b.overflow < 0 &&
                    !b.empty &&
                    !b.invalidMonth &&
                    !b.invalidWeekday &&
                    !b.nullInput &&
                    !b.invalidFormat &&
                    !b.userInvalidated &&
                    (!b.meridiem || (b.meridiem && c));
            if (
                (a._strict &&
                    (d =
                        d &&
                        0 === b.charsLeftOver &&
                        0 === b.unusedTokens.length &&
                        void 0 === b.bigHour),
                null != Object.isFrozen && Object.isFrozen(a))
            )
                return d;
            a._isValid = d;
        }
        return a._isValid;
    }
    function p(a) {
        var b = l(NaN);
        return null != a ? k(n(b), a) : (n(b).userInvalidated = !0), b;
    }
    function q(a, b) {
        var c, d, e;
        if (
            (f(b._isAMomentObject) || (a._isAMomentObject = b._isAMomentObject),
            f(b._i) || (a._i = b._i),
            f(b._f) || (a._f = b._f),
            f(b._l) || (a._l = b._l),
            f(b._strict) || (a._strict = b._strict),
            f(b._tzm) || (a._tzm = b._tzm),
            f(b._isUTC) || (a._isUTC = b._isUTC),
            f(b._offset) || (a._offset = b._offset),
            f(b._pf) || (a._pf = n(b)),
            f(b._locale) || (a._locale = b._locale),
            vd.length > 0)
        )
            for (c = 0; c < vd.length; c++)
                (d = vd[c]), (e = b[d]), f(e) || (a[d] = e);
        return a;
    }
    function r(b) {
        q(this, b),
            (this._d = new Date(null != b._d ? b._d.getTime() : NaN)),
            this.isValid() || (this._d = new Date(NaN)),
            wd === !1 && ((wd = !0), a.updateOffset(this), (wd = !1));
    }
    function s(a) {
        return a instanceof r || (null != a && null != a._isAMomentObject);
    }
    function t(a) {
        return a < 0 ? Math.ceil(a) || 0 : Math.floor(a);
    }
    function u(a) {
        var b = +a,
            c = 0;
        return 0 !== b && isFinite(b) && (c = t(b)), c;
    }
    function v(a, b, c) {
        var d,
            e = Math.min(a.length, b.length),
            f = Math.abs(a.length - b.length),
            g = 0;
        for (d = 0; d < e; d++)
            ((c && a[d] !== b[d]) || (!c && u(a[d]) !== u(b[d]))) && g++;
        return g + f;
    }
    function w(b) {
        a.suppressDeprecationWarnings === !1 &&
            "undefined" != typeof console &&
            console.warn &&
            console.warn("Deprecation warning: " + b);
    }
    function x(b, c) {
        var d = !0;
        return k(function () {
            if (
                (null != a.deprecationHandler && a.deprecationHandler(null, b),
                d)
            ) {
                for (var e, f = [], g = 0; g < arguments.length; g++) {
                    if (((e = ""), "object" == typeof arguments[g])) {
                        e += "\n[" + g + "] ";
                        for (var h in arguments[0])
                            e += h + ": " + arguments[0][h] + ", ";
                        e = e.slice(0, -2);
                    } else e = arguments[g];
                    f.push(e);
                }
                w(
                    b +
                        "\nArguments: " +
                        Array.prototype.slice.call(f).join("") +
                        "\n" +
                        new Error().stack
                ),
                    (d = !1);
            }
            return c.apply(this, arguments);
        }, c);
    }
    function y(b, c) {
        null != a.deprecationHandler && a.deprecationHandler(b, c),
            xd[b] || (w(c), (xd[b] = !0));
    }
    function z(a) {
        return (
            a instanceof Function ||
            "[object Function]" === Object.prototype.toString.call(a)
        );
    }
    function A(a) {
        var b, c;
        for (c in a) (b = a[c]), z(b) ? (this[c] = b) : (this["_" + c] = b);
        (this._config = a),
            (this._dayOfMonthOrdinalParseLenient = new RegExp(
                (this._dayOfMonthOrdinalParse.source ||
                    this._ordinalParse.source) +
                    "|" +
                    /\d{1,2}/.source
            ));
    }
    function B(a, b) {
        var c,
            e = k({}, a);
        for (c in b)
            j(b, c) &&
                (d(a[c]) && d(b[c])
                    ? ((e[c] = {}), k(e[c], a[c]), k(e[c], b[c]))
                    : null != b[c]
                    ? (e[c] = b[c])
                    : delete e[c]);
        for (c in a) j(a, c) && !j(b, c) && d(a[c]) && (e[c] = k({}, e[c]));
        return e;
    }
    function C(a) {
        null != a && this.set(a);
    }
    function D(a, b, c) {
        var d = this._calendar[a] || this._calendar.sameElse;
        return z(d) ? d.call(b, c) : d;
    }
    function E(a) {
        var b = this._longDateFormat[a],
            c = this._longDateFormat[a.toUpperCase()];
        return b || !c
            ? b
            : ((this._longDateFormat[a] = c.replace(
                  /MMMM|MM|DD|dddd/g,
                  function (a) {
                      return a.slice(1);
                  }
              )),
              this._longDateFormat[a]);
    }
    function F() {
        return this._invalidDate;
    }
    function G(a) {
        return this._ordinal.replace("%d", a);
    }
    function H(a, b, c, d) {
        var e = this._relativeTime[c];
        return z(e) ? e(a, b, c, d) : e.replace(/%d/i, a);
    }
    function I(a, b) {
        var c = this._relativeTime[a > 0 ? "future" : "past"];
        return z(c) ? c(b) : c.replace(/%s/i, b);
    }
    function J(a, b) {
        var c = a.toLowerCase();
        Hd[c] = Hd[c + "s"] = Hd[b] = a;
    }
    function K(a) {
        return "string" == typeof a ? Hd[a] || Hd[a.toLowerCase()] : void 0;
    }
    function L(a) {
        var b,
            c,
            d = {};
        for (c in a) j(a, c) && ((b = K(c)), b && (d[b] = a[c]));
        return d;
    }
    function M(a, b) {
        Id[a] = b;
    }
    function N(a) {
        var b = [];
        for (var c in a) b.push({ unit: c, priority: Id[c] });
        return (
            b.sort(function (a, b) {
                return a.priority - b.priority;
            }),
            b
        );
    }
    function O(b, c) {
        return function (d) {
            return null != d
                ? (Q(this, b, d), a.updateOffset(this, c), this)
                : P(this, b);
        };
    }
    function P(a, b) {
        return a.isValid() ? a._d["get" + (a._isUTC ? "UTC" : "") + b]() : NaN;
    }
    function Q(a, b, c) {
        a.isValid() && a._d["set" + (a._isUTC ? "UTC" : "") + b](c);
    }
    function R(a) {
        return (a = K(a)), z(this[a]) ? this[a]() : this;
    }
    function S(a, b) {
        if ("object" == typeof a) {
            a = L(a);
            for (var c = N(a), d = 0; d < c.length; d++)
                this[c[d].unit](a[c[d].unit]);
        } else if (((a = K(a)), z(this[a]))) return this[a](b);
        return this;
    }
    function T(a, b, c) {
        var d = "" + Math.abs(a),
            e = b - d.length,
            f = a >= 0;
        return (
            (f ? (c ? "+" : "") : "-") +
            Math.pow(10, Math.max(0, e)).toString().substr(1) +
            d
        );
    }
    function U(a, b, c, d) {
        var e = d;
        "string" == typeof d &&
            (e = function () {
                return this[d]();
            }),
            a && (Md[a] = e),
            b &&
                (Md[b[0]] = function () {
                    return T(e.apply(this, arguments), b[1], b[2]);
                }),
            c &&
                (Md[c] = function () {
                    return this.localeData().ordinal(
                        e.apply(this, arguments),
                        a
                    );
                });
    }
    function V(a) {
        return a.match(/\[[\s\S]/)
            ? a.replace(/^\[|\]$/g, "")
            : a.replace(/\\/g, "");
    }
    function W(a) {
        var b,
            c,
            d = a.match(Jd);
        for (b = 0, c = d.length; b < c; b++)
            Md[d[b]] ? (d[b] = Md[d[b]]) : (d[b] = V(d[b]));
        return function (b) {
            var e,
                f = "";
            for (e = 0; e < c; e++) f += z(d[e]) ? d[e].call(b, a) : d[e];
            return f;
        };
    }
    function X(a, b) {
        return a.isValid()
            ? ((b = Y(b, a.localeData())), (Ld[b] = Ld[b] || W(b)), Ld[b](a))
            : a.localeData().invalidDate();
    }
    function Y(a, b) {
        function c(a) {
            return b.longDateFormat(a) || a;
        }
        var d = 5;
        for (Kd.lastIndex = 0; d >= 0 && Kd.test(a); )
            (a = a.replace(Kd, c)), (Kd.lastIndex = 0), (d -= 1);
        return a;
    }
    function Z(a, b, c) {
        ce[a] = z(b)
            ? b
            : function (a, d) {
                  return a && c ? c : b;
              };
    }
    function $(a, b) {
        return j(ce, a) ? ce[a](b._strict, b._locale) : new RegExp(_(a));
    }
    function _(a) {
        return aa(
            a
                .replace("\\", "")
                .replace(
                    /\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g,
                    function (a, b, c, d, e) {
                        return b || c || d || e;
                    }
                )
        );
    }
    function aa(a) {
        return a.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&");
    }
    function ba(a, b) {
        var c,
            d = b;
        for (
            "string" == typeof a && (a = [a]),
                g(b) &&
                    (d = function (a, c) {
                        c[b] = u(a);
                    }),
                c = 0;
            c < a.length;
            c++
        )
            de[a[c]] = d;
    }
    function ca(a, b) {
        ba(a, function (a, c, d, e) {
            (d._w = d._w || {}), b(a, d._w, d, e);
        });
    }
    function da(a, b, c) {
        null != b && j(de, a) && de[a](b, c._a, c, a);
    }
    function ea(a, b) {
        return new Date(Date.UTC(a, b + 1, 0)).getUTCDate();
    }
    function fa(a, b) {
        return a
            ? c(this._months)
                ? this._months[a.month()]
                : this._months[
                      (this._months.isFormat || oe).test(b)
                          ? "format"
                          : "standalone"
                  ][a.month()]
            : c(this._months)
            ? this._months
            : this._months.standalone;
    }
    function ga(a, b) {
        return a
            ? c(this._monthsShort)
                ? this._monthsShort[a.month()]
                : this._monthsShort[oe.test(b) ? "format" : "standalone"][
                      a.month()
                  ]
            : c(this._monthsShort)
            ? this._monthsShort
            : this._monthsShort.standalone;
    }
    function ha(a, b, c) {
        var d,
            e,
            f,
            g = a.toLocaleLowerCase();
        if (!this._monthsParse)
            for (
                this._monthsParse = [],
                    this._longMonthsParse = [],
                    this._shortMonthsParse = [],
                    d = 0;
                d < 12;
                ++d
            )
                (f = l([2e3, d])),
                    (this._shortMonthsParse[d] = this.monthsShort(
                        f,
                        ""
                    ).toLocaleLowerCase()),
                    (this._longMonthsParse[d] = this.months(
                        f,
                        ""
                    ).toLocaleLowerCase());
        return c
            ? "MMM" === b
                ? ((e = ne.call(this._shortMonthsParse, g)),
                  e !== -1 ? e : null)
                : ((e = ne.call(this._longMonthsParse, g)), e !== -1 ? e : null)
            : "MMM" === b
            ? ((e = ne.call(this._shortMonthsParse, g)),
              e !== -1
                  ? e
                  : ((e = ne.call(this._longMonthsParse, g)),
                    e !== -1 ? e : null))
            : ((e = ne.call(this._longMonthsParse, g)),
              e !== -1
                  ? e
                  : ((e = ne.call(this._shortMonthsParse, g)),
                    e !== -1 ? e : null));
    }
    function ia(a, b, c) {
        var d, e, f;
        if (this._monthsParseExact) return ha.call(this, a, b, c);
        for (
            this._monthsParse ||
                ((this._monthsParse = []),
                (this._longMonthsParse = []),
                (this._shortMonthsParse = [])),
                d = 0;
            d < 12;
            d++
        ) {
            if (
                ((e = l([2e3, d])),
                c &&
                    !this._longMonthsParse[d] &&
                    ((this._longMonthsParse[d] = new RegExp(
                        "^" + this.months(e, "").replace(".", "") + "$",
                        "i"
                    )),
                    (this._shortMonthsParse[d] = new RegExp(
                        "^" + this.monthsShort(e, "").replace(".", "") + "$",
                        "i"
                    ))),
                c ||
                    this._monthsParse[d] ||
                    ((f =
                        "^" +
                        this.months(e, "") +
                        "|^" +
                        this.monthsShort(e, "")),
                    (this._monthsParse[d] = new RegExp(
                        f.replace(".", ""),
                        "i"
                    ))),
                c && "MMMM" === b && this._longMonthsParse[d].test(a))
            )
                return d;
            if (c && "MMM" === b && this._shortMonthsParse[d].test(a)) return d;
            if (!c && this._monthsParse[d].test(a)) return d;
        }
    }
    function ja(a, b) {
        var c;
        if (!a.isValid()) return a;
        if ("string" == typeof b)
            if (/^\d+$/.test(b)) b = u(b);
            else if (((b = a.localeData().monthsParse(b)), !g(b))) return a;
        return (
            (c = Math.min(a.date(), ea(a.year(), b))),
            a._d["set" + (a._isUTC ? "UTC" : "") + "Month"](b, c),
            a
        );
    }
    function ka(b) {
        return null != b
            ? (ja(this, b), a.updateOffset(this, !0), this)
            : P(this, "Month");
    }
    function la() {
        return ea(this.year(), this.month());
    }
    function ma(a) {
        return this._monthsParseExact
            ? (j(this, "_monthsRegex") || oa.call(this),
              a ? this._monthsShortStrictRegex : this._monthsShortRegex)
            : (j(this, "_monthsShortRegex") || (this._monthsShortRegex = re),
              this._monthsShortStrictRegex && a
                  ? this._monthsShortStrictRegex
                  : this._monthsShortRegex);
    }
    function na(a) {
        return this._monthsParseExact
            ? (j(this, "_monthsRegex") || oa.call(this),
              a ? this._monthsStrictRegex : this._monthsRegex)
            : (j(this, "_monthsRegex") || (this._monthsRegex = se),
              this._monthsStrictRegex && a
                  ? this._monthsStrictRegex
                  : this._monthsRegex);
    }
    function oa() {
        function a(a, b) {
            return b.length - a.length;
        }
        var b,
            c,
            d = [],
            e = [],
            f = [];
        for (b = 0; b < 12; b++)
            (c = l([2e3, b])),
                d.push(this.monthsShort(c, "")),
                e.push(this.months(c, "")),
                f.push(this.months(c, "")),
                f.push(this.monthsShort(c, ""));
        for (d.sort(a), e.sort(a), f.sort(a), b = 0; b < 12; b++)
            (d[b] = aa(d[b])), (e[b] = aa(e[b]));
        for (b = 0; b < 24; b++) f[b] = aa(f[b]);
        (this._monthsRegex = new RegExp("^(" + f.join("|") + ")", "i")),
            (this._monthsShortRegex = this._monthsRegex),
            (this._monthsStrictRegex = new RegExp(
                "^(" + e.join("|") + ")",
                "i"
            )),
            (this._monthsShortStrictRegex = new RegExp(
                "^(" + d.join("|") + ")",
                "i"
            ));
    }
    function pa(a) {
        return qa(a) ? 366 : 365;
    }
    function qa(a) {
        return (a % 4 === 0 && a % 100 !== 0) || a % 400 === 0;
    }
    function ra() {
        return qa(this.year());
    }
    function sa(a, b, c, d, e, f, g) {
        var h = new Date(a, b, c, d, e, f, g);
        return (
            a < 100 && a >= 0 && isFinite(h.getFullYear()) && h.setFullYear(a),
            h
        );
    }
    function ta(a) {
        var b = new Date(Date.UTC.apply(null, arguments));
        return (
            a < 100 &&
                a >= 0 &&
                isFinite(b.getUTCFullYear()) &&
                b.setUTCFullYear(a),
            b
        );
    }
    function ua(a, b, c) {
        var d = 7 + b - c,
            e = (7 + ta(a, 0, d).getUTCDay() - b) % 7;
        return -e + d - 1;
    }
    function va(a, b, c, d, e) {
        var f,
            g,
            h = (7 + c - d) % 7,
            i = ua(a, d, e),
            j = 1 + 7 * (b - 1) + h + i;
        return (
            j <= 0
                ? ((f = a - 1), (g = pa(f) + j))
                : j > pa(a)
                ? ((f = a + 1), (g = j - pa(a)))
                : ((f = a), (g = j)),
            { year: f, dayOfYear: g }
        );
    }
    function wa(a, b, c) {
        var d,
            e,
            f = ua(a.year(), b, c),
            g = Math.floor((a.dayOfYear() - f - 1) / 7) + 1;
        return (
            g < 1
                ? ((e = a.year() - 1), (d = g + xa(e, b, c)))
                : g > xa(a.year(), b, c)
                ? ((d = g - xa(a.year(), b, c)), (e = a.year() + 1))
                : ((e = a.year()), (d = g)),
            { week: d, year: e }
        );
    }
    function xa(a, b, c) {
        var d = ua(a, b, c),
            e = ua(a + 1, b, c);
        return (pa(a) - d + e) / 7;
    }
    function ya(a) {
        return wa(a, this._week.dow, this._week.doy).week;
    }
    function za() {
        return this._week.dow;
    }
    function Aa() {
        return this._week.doy;
    }
    function Ba(a) {
        var b = this.localeData().week(this);
        return null == a ? b : this.add(7 * (a - b), "d");
    }
    function Ca(a) {
        var b = wa(this, 1, 4).week;
        return null == a ? b : this.add(7 * (a - b), "d");
    }
    function Da(a, b) {
        return "string" != typeof a
            ? a
            : isNaN(a)
            ? ((a = b.weekdaysParse(a)), "number" == typeof a ? a : null)
            : parseInt(a, 10);
    }
    function Ea(a, b) {
        return "string" == typeof a
            ? b.weekdaysParse(a) % 7 || 7
            : isNaN(a)
            ? null
            : a;
    }
    function Fa(a, b) {
        return a
            ? c(this._weekdays)
                ? this._weekdays[a.day()]
                : this._weekdays[
                      this._weekdays.isFormat.test(b) ? "format" : "standalone"
                  ][a.day()]
            : c(this._weekdays)
            ? this._weekdays
            : this._weekdays.standalone;
    }
    function Ga(a) {
        return a ? this._weekdaysShort[a.day()] : this._weekdaysShort;
    }
    function Ha(a) {
        return a ? this._weekdaysMin[a.day()] : this._weekdaysMin;
    }
    function Ia(a, b, c) {
        var d,
            e,
            f,
            g = a.toLocaleLowerCase();
        if (!this._weekdaysParse)
            for (
                this._weekdaysParse = [],
                    this._shortWeekdaysParse = [],
                    this._minWeekdaysParse = [],
                    d = 0;
                d < 7;
                ++d
            )
                (f = l([2e3, 1]).day(d)),
                    (this._minWeekdaysParse[d] = this.weekdaysMin(
                        f,
                        ""
                    ).toLocaleLowerCase()),
                    (this._shortWeekdaysParse[d] = this.weekdaysShort(
                        f,
                        ""
                    ).toLocaleLowerCase()),
                    (this._weekdaysParse[d] = this.weekdays(
                        f,
                        ""
                    ).toLocaleLowerCase());
        return c
            ? "dddd" === b
                ? ((e = ne.call(this._weekdaysParse, g)), e !== -1 ? e : null)
                : "ddd" === b
                ? ((e = ne.call(this._shortWeekdaysParse, g)),
                  e !== -1 ? e : null)
                : ((e = ne.call(this._minWeekdaysParse, g)),
                  e !== -1 ? e : null)
            : "dddd" === b
            ? ((e = ne.call(this._weekdaysParse, g)),
              e !== -1
                  ? e
                  : ((e = ne.call(this._shortWeekdaysParse, g)),
                    e !== -1
                        ? e
                        : ((e = ne.call(this._minWeekdaysParse, g)),
                          e !== -1 ? e : null)))
            : "ddd" === b
            ? ((e = ne.call(this._shortWeekdaysParse, g)),
              e !== -1
                  ? e
                  : ((e = ne.call(this._weekdaysParse, g)),
                    e !== -1
                        ? e
                        : ((e = ne.call(this._minWeekdaysParse, g)),
                          e !== -1 ? e : null)))
            : ((e = ne.call(this._minWeekdaysParse, g)),
              e !== -1
                  ? e
                  : ((e = ne.call(this._weekdaysParse, g)),
                    e !== -1
                        ? e
                        : ((e = ne.call(this._shortWeekdaysParse, g)),
                          e !== -1 ? e : null)));
    }
    function Ja(a, b, c) {
        var d, e, f;
        if (this._weekdaysParseExact) return Ia.call(this, a, b, c);
        for (
            this._weekdaysParse ||
                ((this._weekdaysParse = []),
                (this._minWeekdaysParse = []),
                (this._shortWeekdaysParse = []),
                (this._fullWeekdaysParse = [])),
                d = 0;
            d < 7;
            d++
        ) {
            if (
                ((e = l([2e3, 1]).day(d)),
                c &&
                    !this._fullWeekdaysParse[d] &&
                    ((this._fullWeekdaysParse[d] = new RegExp(
                        "^" + this.weekdays(e, "").replace(".", ".?") + "$",
                        "i"
                    )),
                    (this._shortWeekdaysParse[d] = new RegExp(
                        "^" +
                            this.weekdaysShort(e, "").replace(".", ".?") +
                            "$",
                        "i"
                    )),
                    (this._minWeekdaysParse[d] = new RegExp(
                        "^" + this.weekdaysMin(e, "").replace(".", ".?") + "$",
                        "i"
                    ))),
                this._weekdaysParse[d] ||
                    ((f =
                        "^" +
                        this.weekdays(e, "") +
                        "|^" +
                        this.weekdaysShort(e, "") +
                        "|^" +
                        this.weekdaysMin(e, "")),
                    (this._weekdaysParse[d] = new RegExp(
                        f.replace(".", ""),
                        "i"
                    ))),
                c && "dddd" === b && this._fullWeekdaysParse[d].test(a))
            )
                return d;
            if (c && "ddd" === b && this._shortWeekdaysParse[d].test(a))
                return d;
            if (c && "dd" === b && this._minWeekdaysParse[d].test(a)) return d;
            if (!c && this._weekdaysParse[d].test(a)) return d;
        }
    }
    function Ka(a) {
        if (!this.isValid()) return null != a ? this : NaN;
        var b = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
        return null != a
            ? ((a = Da(a, this.localeData())), this.add(a - b, "d"))
            : b;
    }
    function La(a) {
        if (!this.isValid()) return null != a ? this : NaN;
        var b = (this.day() + 7 - this.localeData()._week.dow) % 7;
        return null == a ? b : this.add(a - b, "d");
    }
    function Ma(a) {
        if (!this.isValid()) return null != a ? this : NaN;
        if (null != a) {
            var b = Ea(a, this.localeData());
            return this.day(this.day() % 7 ? b : b - 7);
        }
        return this.day() || 7;
    }
    function Na(a) {
        return this._weekdaysParseExact
            ? (j(this, "_weekdaysRegex") || Qa.call(this),
              a ? this._weekdaysStrictRegex : this._weekdaysRegex)
            : (j(this, "_weekdaysRegex") || (this._weekdaysRegex = ye),
              this._weekdaysStrictRegex && a
                  ? this._weekdaysStrictRegex
                  : this._weekdaysRegex);
    }
    function Oa(a) {
        return this._weekdaysParseExact
            ? (j(this, "_weekdaysRegex") || Qa.call(this),
              a ? this._weekdaysShortStrictRegex : this._weekdaysShortRegex)
            : (j(this, "_weekdaysShortRegex") ||
                  (this._weekdaysShortRegex = ze),
              this._weekdaysShortStrictRegex && a
                  ? this._weekdaysShortStrictRegex
                  : this._weekdaysShortRegex);
    }
    function Pa(a) {
        return this._weekdaysParseExact
            ? (j(this, "_weekdaysRegex") || Qa.call(this),
              a ? this._weekdaysMinStrictRegex : this._weekdaysMinRegex)
            : (j(this, "_weekdaysMinRegex") || (this._weekdaysMinRegex = Ae),
              this._weekdaysMinStrictRegex && a
                  ? this._weekdaysMinStrictRegex
                  : this._weekdaysMinRegex);
    }
    function Qa() {
        function a(a, b) {
            return b.length - a.length;
        }
        var b,
            c,
            d,
            e,
            f,
            g = [],
            h = [],
            i = [],
            j = [];
        for (b = 0; b < 7; b++)
            (c = l([2e3, 1]).day(b)),
                (d = this.weekdaysMin(c, "")),
                (e = this.weekdaysShort(c, "")),
                (f = this.weekdays(c, "")),
                g.push(d),
                h.push(e),
                i.push(f),
                j.push(d),
                j.push(e),
                j.push(f);
        for (g.sort(a), h.sort(a), i.sort(a), j.sort(a), b = 0; b < 7; b++)
            (h[b] = aa(h[b])), (i[b] = aa(i[b])), (j[b] = aa(j[b]));
        (this._weekdaysRegex = new RegExp("^(" + j.join("|") + ")", "i")),
            (this._weekdaysShortRegex = this._weekdaysRegex),
            (this._weekdaysMinRegex = this._weekdaysRegex),
            (this._weekdaysStrictRegex = new RegExp(
                "^(" + i.join("|") + ")",
                "i"
            )),
            (this._weekdaysShortStrictRegex = new RegExp(
                "^(" + h.join("|") + ")",
                "i"
            )),
            (this._weekdaysMinStrictRegex = new RegExp(
                "^(" + g.join("|") + ")",
                "i"
            ));
    }
    function Ra() {
        return this.hours() % 12 || 12;
    }
    function Sa() {
        return this.hours() || 24;
    }
    function Ta(a, b) {
        U(a, 0, 0, function () {
            return this.localeData().meridiem(this.hours(), this.minutes(), b);
        });
    }
    function Ua(a, b) {
        return b._meridiemParse;
    }
    function Va(a) {
        return "p" === (a + "").toLowerCase().charAt(0);
    }
    function Wa(a, b, c) {
        return a > 11 ? (c ? "pm" : "PM") : c ? "am" : "AM";
    }
    function Xa(a) {
        return a ? a.toLowerCase().replace("_", "-") : a;
    }
    function Ya(a) {
        for (var b, c, d, e, f = 0; f < a.length; ) {
            for (
                e = Xa(a[f]).split("-"),
                    b = e.length,
                    c = Xa(a[f + 1]),
                    c = c ? c.split("-") : null;
                b > 0;

            ) {
                if ((d = Za(e.slice(0, b).join("-")))) return d;
                if (c && c.length >= b && v(e, c, !0) >= b - 1) break;
                b--;
            }
            f++;
        }
        return null;
    }
    function Za(a) {
        var b = null;
        if (!Fe[a] && "undefined" != typeof module && module && module.exports)
            try {
                (b = Be._abbr), require("./locale/" + a), $a(b);
            } catch (a) {}
        return Fe[a];
    }
    function $a(a, b) {
        var c;
        return a && ((c = f(b) ? bb(a) : _a(a, b)), c && (Be = c)), Be._abbr;
    }
    function _a(a, b) {
        if (null !== b) {
            var c = Ee;
            if (((b.abbr = a), null != Fe[a]))
                y(
                    "defineLocaleOverride",
                    "use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale See http://momentjs.com/guides/#/warnings/define-locale/ for more info."
                ),
                    (c = Fe[a]._config);
            else if (null != b.parentLocale) {
                if (null == Fe[b.parentLocale])
                    return (
                        Ge[b.parentLocale] || (Ge[b.parentLocale] = []),
                        Ge[b.parentLocale].push({ name: a, config: b }),
                        null
                    );
                c = Fe[b.parentLocale]._config;
            }
            return (
                (Fe[a] = new C(B(c, b))),
                Ge[a] &&
                    Ge[a].forEach(function (a) {
                        _a(a.name, a.config);
                    }),
                $a(a),
                Fe[a]
            );
        }
        return delete Fe[a], null;
    }
    function ab(a, b) {
        if (null != b) {
            var c,
                d = Ee;
            null != Fe[a] && (d = Fe[a]._config),
                (b = B(d, b)),
                (c = new C(b)),
                (c.parentLocale = Fe[a]),
                (Fe[a] = c),
                $a(a);
        } else null != Fe[a] && (null != Fe[a].parentLocale ? (Fe[a] = Fe[a].parentLocale) : null != Fe[a] && delete Fe[a]);
        return Fe[a];
    }
    function bb(a) {
        var b;
        if ((a && a._locale && a._locale._abbr && (a = a._locale._abbr), !a))
            return Be;
        if (!c(a)) {
            if ((b = Za(a))) return b;
            a = [a];
        }
        return Ya(a);
    }
    function cb() {
        return Ad(Fe);
    }
    function db(a) {
        var b,
            c = a._a;
        return (
            c &&
                n(a).overflow === -2 &&
                ((b =
                    c[fe] < 0 || c[fe] > 11
                        ? fe
                        : c[ge] < 1 || c[ge] > ea(c[ee], c[fe])
                        ? ge
                        : c[he] < 0 ||
                          c[he] > 24 ||
                          (24 === c[he] &&
                              (0 !== c[ie] || 0 !== c[je] || 0 !== c[ke]))
                        ? he
                        : c[ie] < 0 || c[ie] > 59
                        ? ie
                        : c[je] < 0 || c[je] > 59
                        ? je
                        : c[ke] < 0 || c[ke] > 999
                        ? ke
                        : -1),
                n(a)._overflowDayOfYear && (b < ee || b > ge) && (b = ge),
                n(a)._overflowWeeks && b === -1 && (b = le),
                n(a)._overflowWeekday && b === -1 && (b = me),
                (n(a).overflow = b)),
            a
        );
    }
    function eb(a) {
        var b,
            c,
            d,
            e,
            f,
            g,
            h = a._i,
            i = He.exec(h) || Ie.exec(h);
        if (i) {
            for (n(a).iso = !0, b = 0, c = Ke.length; b < c; b++)
                if (Ke[b][1].exec(i[1])) {
                    (e = Ke[b][0]), (d = Ke[b][2] !== !1);
                    break;
                }
            if (null == e) return void (a._isValid = !1);
            if (i[3]) {
                for (b = 0, c = Le.length; b < c; b++)
                    if (Le[b][1].exec(i[3])) {
                        f = (i[2] || " ") + Le[b][0];
                        break;
                    }
                if (null == f) return void (a._isValid = !1);
            }
            if (!d && null != f) return void (a._isValid = !1);
            if (i[4]) {
                if (!Je.exec(i[4])) return void (a._isValid = !1);
                g = "Z";
            }
            (a._f = e + (f || "") + (g || "")), lb(a);
        } else a._isValid = !1;
    }
    function fb(a) {
        var b,
            c,
            d,
            e,
            f,
            g,
            h,
            i,
            j = {
                " GMT": " +0000",
                " EDT": " -0400",
                " EST": " -0500",
                " CDT": " -0500",
                " CST": " -0600",
                " MDT": " -0600",
                " MST": " -0700",
                " PDT": " -0700",
                " PST": " -0800",
            },
            k = "YXWVUTSRQPONZABCDEFGHIKLM";
        if (
            ((b = a._i
                .replace(/\([^\)]*\)|[\n\t]/g, " ")
                .replace(/(\s\s+)/g, " ")
                .replace(/^\s|\s$/g, "")),
            (c = Ne.exec(b)))
        ) {
            if (
                ((d = c[1] ? "ddd" + (5 === c[1].length ? ", " : " ") : ""),
                (e = "D MMM " + (c[2].length > 10 ? "YYYY " : "YY ")),
                (f = "HH:mm" + (c[4] ? ":ss" : "")),
                c[1])
            ) {
                var l = new Date(c[2]),
                    m = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"][
                        l.getDay()
                    ];
                if (c[1].substr(0, 3) !== m)
                    return (n(a).weekdayMismatch = !0), void (a._isValid = !1);
            }
            switch (c[5].length) {
                case 2:
                    0 === i
                        ? (h = " +0000")
                        : ((i = k.indexOf(c[5][1].toUpperCase()) - 12),
                          (h =
                              (i < 0 ? " -" : " +") +
                              ("" + i).replace(/^-?/, "0").match(/..$/)[0] +
                              "00"));
                    break;
                case 4:
                    h = j[c[5]];
                    break;
                default:
                    h = j[" GMT"];
            }
            (c[5] = h),
                (a._i = c.splice(1).join("")),
                (g = " ZZ"),
                (a._f = d + e + f + g),
                lb(a),
                (n(a).rfc2822 = !0);
        } else a._isValid = !1;
    }
    function gb(b) {
        var c = Me.exec(b._i);
        return null !== c
            ? void (b._d = new Date(+c[1]))
            : (eb(b),
              void (
                  b._isValid === !1 &&
                  (delete b._isValid,
                  fb(b),
                  b._isValid === !1 &&
                      (delete b._isValid, a.createFromInputFallback(b)))
              ));
    }
    function hb(a, b, c) {
        return null != a ? a : null != b ? b : c;
    }
    function ib(b) {
        var c = new Date(a.now());
        return b._useUTC
            ? [c.getUTCFullYear(), c.getUTCMonth(), c.getUTCDate()]
            : [c.getFullYear(), c.getMonth(), c.getDate()];
    }
    function jb(a) {
        var b,
            c,
            d,
            e,
            f = [];
        if (!a._d) {
            for (
                d = ib(a),
                    a._w && null == a._a[ge] && null == a._a[fe] && kb(a),
                    null != a._dayOfYear &&
                        ((e = hb(a._a[ee], d[ee])),
                        (a._dayOfYear > pa(e) || 0 === a._dayOfYear) &&
                            (n(a)._overflowDayOfYear = !0),
                        (c = ta(e, 0, a._dayOfYear)),
                        (a._a[fe] = c.getUTCMonth()),
                        (a._a[ge] = c.getUTCDate())),
                    b = 0;
                b < 3 && null == a._a[b];
                ++b
            )
                a._a[b] = f[b] = d[b];
            for (; b < 7; b++)
                a._a[b] = f[b] = null == a._a[b] ? (2 === b ? 1 : 0) : a._a[b];
            24 === a._a[he] &&
                0 === a._a[ie] &&
                0 === a._a[je] &&
                0 === a._a[ke] &&
                ((a._nextDay = !0), (a._a[he] = 0)),
                (a._d = (a._useUTC ? ta : sa).apply(null, f)),
                null != a._tzm &&
                    a._d.setUTCMinutes(a._d.getUTCMinutes() - a._tzm),
                a._nextDay && (a._a[he] = 24);
        }
    }
    function kb(a) {
        var b, c, d, e, f, g, h, i;
        if (((b = a._w), null != b.GG || null != b.W || null != b.E))
            (f = 1),
                (g = 4),
                (c = hb(b.GG, a._a[ee], wa(tb(), 1, 4).year)),
                (d = hb(b.W, 1)),
                (e = hb(b.E, 1)),
                (e < 1 || e > 7) && (i = !0);
        else {
            (f = a._locale._week.dow), (g = a._locale._week.doy);
            var j = wa(tb(), f, g);
            (c = hb(b.gg, a._a[ee], j.year)),
                (d = hb(b.w, j.week)),
                null != b.d
                    ? ((e = b.d), (e < 0 || e > 6) && (i = !0))
                    : null != b.e
                    ? ((e = b.e + f), (b.e < 0 || b.e > 6) && (i = !0))
                    : (e = f);
        }
        d < 1 || d > xa(c, f, g)
            ? (n(a)._overflowWeeks = !0)
            : null != i
            ? (n(a)._overflowWeekday = !0)
            : ((h = va(c, d, e, f, g)),
              (a._a[ee] = h.year),
              (a._dayOfYear = h.dayOfYear));
    }
    function lb(b) {
        if (b._f === a.ISO_8601) return void eb(b);
        if (b._f === a.RFC_2822) return void fb(b);
        (b._a = []), (n(b).empty = !0);
        var c,
            d,
            e,
            f,
            g,
            h = "" + b._i,
            i = h.length,
            j = 0;
        for (e = Y(b._f, b._locale).match(Jd) || [], c = 0; c < e.length; c++)
            (f = e[c]),
                (d = (h.match($(f, b)) || [])[0]),
                d &&
                    ((g = h.substr(0, h.indexOf(d))),
                    g.length > 0 && n(b).unusedInput.push(g),
                    (h = h.slice(h.indexOf(d) + d.length)),
                    (j += d.length)),
                Md[f]
                    ? (d ? (n(b).empty = !1) : n(b).unusedTokens.push(f),
                      da(f, d, b))
                    : b._strict && !d && n(b).unusedTokens.push(f);
        (n(b).charsLeftOver = i - j),
            h.length > 0 && n(b).unusedInput.push(h),
            b._a[he] <= 12 &&
                n(b).bigHour === !0 &&
                b._a[he] > 0 &&
                (n(b).bigHour = void 0),
            (n(b).parsedDateParts = b._a.slice(0)),
            (n(b).meridiem = b._meridiem),
            (b._a[he] = mb(b._locale, b._a[he], b._meridiem)),
            jb(b),
            db(b);
    }
    function mb(a, b, c) {
        var d;
        return null == c
            ? b
            : null != a.meridiemHour
            ? a.meridiemHour(b, c)
            : null != a.isPM
            ? ((d = a.isPM(c)),
              d && b < 12 && (b += 12),
              d || 12 !== b || (b = 0),
              b)
            : b;
    }
    function nb(a) {
        var b, c, d, e, f;
        if (0 === a._f.length)
            return (n(a).invalidFormat = !0), void (a._d = new Date(NaN));
        for (e = 0; e < a._f.length; e++)
            (f = 0),
                (b = q({}, a)),
                null != a._useUTC && (b._useUTC = a._useUTC),
                (b._f = a._f[e]),
                lb(b),
                o(b) &&
                    ((f += n(b).charsLeftOver),
                    (f += 10 * n(b).unusedTokens.length),
                    (n(b).score = f),
                    (null == d || f < d) && ((d = f), (c = b)));
        k(a, c || b);
    }
    function ob(a) {
        if (!a._d) {
            var b = L(a._i);
            (a._a = i(
                [
                    b.year,
                    b.month,
                    b.day || b.date,
                    b.hour,
                    b.minute,
                    b.second,
                    b.millisecond,
                ],
                function (a) {
                    return a && parseInt(a, 10);
                }
            )),
                jb(a);
        }
    }
    function pb(a) {
        var b = new r(db(qb(a)));
        return b._nextDay && (b.add(1, "d"), (b._nextDay = void 0)), b;
    }
    function qb(a) {
        var b = a._i,
            d = a._f;
        return (
            (a._locale = a._locale || bb(a._l)),
            null === b || (void 0 === d && "" === b)
                ? p({ nullInput: !0 })
                : ("string" == typeof b && (a._i = b = a._locale.preparse(b)),
                  s(b)
                      ? new r(db(b))
                      : (h(b) ? (a._d = b) : c(d) ? nb(a) : d ? lb(a) : rb(a),
                        o(a) || (a._d = null),
                        a))
        );
    }
    function rb(b) {
        var e = b._i;
        f(e)
            ? (b._d = new Date(a.now()))
            : h(e)
            ? (b._d = new Date(e.valueOf()))
            : "string" == typeof e
            ? gb(b)
            : c(e)
            ? ((b._a = i(e.slice(0), function (a) {
                  return parseInt(a, 10);
              })),
              jb(b))
            : d(e)
            ? ob(b)
            : g(e)
            ? (b._d = new Date(e))
            : a.createFromInputFallback(b);
    }
    function sb(a, b, f, g, h) {
        var i = {};
        return (
            (f !== !0 && f !== !1) || ((g = f), (f = void 0)),
            ((d(a) && e(a)) || (c(a) && 0 === a.length)) && (a = void 0),
            (i._isAMomentObject = !0),
            (i._useUTC = i._isUTC = h),
            (i._l = f),
            (i._i = a),
            (i._f = b),
            (i._strict = g),
            pb(i)
        );
    }
    function tb(a, b, c, d) {
        return sb(a, b, c, d, !1);
    }
    function ub(a, b) {
        var d, e;
        if ((1 === b.length && c(b[0]) && (b = b[0]), !b.length)) return tb();
        for (d = b[0], e = 1; e < b.length; ++e)
            (b[e].isValid() && !b[e][a](d)) || (d = b[e]);
        return d;
    }
    function vb() {
        var a = [].slice.call(arguments, 0);
        return ub("isBefore", a);
    }
    function wb() {
        var a = [].slice.call(arguments, 0);
        return ub("isAfter", a);
    }
    function xb(a) {
        for (var b in a)
            if (Re.indexOf(b) === -1 || (null != a[b] && isNaN(a[b])))
                return !1;
        for (var c = !1, d = 0; d < Re.length; ++d)
            if (a[Re[d]]) {
                if (c) return !1;
                parseFloat(a[Re[d]]) !== u(a[Re[d]]) && (c = !0);
            }
        return !0;
    }
    function yb() {
        return this._isValid;
    }
    function zb() {
        return Sb(NaN);
    }
    function Ab(a) {
        var b = L(a),
            c = b.year || 0,
            d = b.quarter || 0,
            e = b.month || 0,
            f = b.week || 0,
            g = b.day || 0,
            h = b.hour || 0,
            i = b.minute || 0,
            j = b.second || 0,
            k = b.millisecond || 0;
        (this._isValid = xb(b)),
            (this._milliseconds = +k + 1e3 * j + 6e4 * i + 1e3 * h * 60 * 60),
            (this._days = +g + 7 * f),
            (this._months = +e + 3 * d + 12 * c),
            (this._data = {}),
            (this._locale = bb()),
            this._bubble();
    }
    function Bb(a) {
        return a instanceof Ab;
    }
    function Cb(a) {
        return a < 0 ? Math.round(-1 * a) * -1 : Math.round(a);
    }
    function Db(a, b) {
        U(a, 0, 0, function () {
            var a = this.utcOffset(),
                c = "+";
            return (
                a < 0 && ((a = -a), (c = "-")),
                c + T(~~(a / 60), 2) + b + T(~~a % 60, 2)
            );
        });
    }
    function Eb(a, b) {
        var c = (b || "").match(a);
        if (null === c) return null;
        var d = c[c.length - 1] || [],
            e = (d + "").match(Se) || ["-", 0, 0],
            f = +(60 * e[1]) + u(e[2]);
        return 0 === f ? 0 : "+" === e[0] ? f : -f;
    }
    function Fb(b, c) {
        var d, e;
        return c._isUTC
            ? ((d = c.clone()),
              (e =
                  (s(b) || h(b) ? b.valueOf() : tb(b).valueOf()) - d.valueOf()),
              d._d.setTime(d._d.valueOf() + e),
              a.updateOffset(d, !1),
              d)
            : tb(b).local();
    }
    function Gb(a) {
        return 15 * -Math.round(a._d.getTimezoneOffset() / 15);
    }
    function Hb(b, c, d) {
        var e,
            f = this._offset || 0;
        if (!this.isValid()) return null != b ? this : NaN;
        if (null != b) {
            if ("string" == typeof b) {
                if (((b = Eb(_d, b)), null === b)) return this;
            } else Math.abs(b) < 16 && !d && (b = 60 * b);
            return (
                !this._isUTC && c && (e = Gb(this)),
                (this._offset = b),
                (this._isUTC = !0),
                null != e && this.add(e, "m"),
                f !== b &&
                    (!c || this._changeInProgress
                        ? Xb(this, Sb(b - f, "m"), 1, !1)
                        : this._changeInProgress ||
                          ((this._changeInProgress = !0),
                          a.updateOffset(this, !0),
                          (this._changeInProgress = null))),
                this
            );
        }
        return this._isUTC ? f : Gb(this);
    }
    function Ib(a, b) {
        return null != a
            ? ("string" != typeof a && (a = -a), this.utcOffset(a, b), this)
            : -this.utcOffset();
    }
    function Jb(a) {
        return this.utcOffset(0, a);
    }
    function Kb(a) {
        return (
            this._isUTC &&
                (this.utcOffset(0, a),
                (this._isUTC = !1),
                a && this.subtract(Gb(this), "m")),
            this
        );
    }
    function Lb() {
        if (null != this._tzm) this.utcOffset(this._tzm, !1, !0);
        else if ("string" == typeof this._i) {
            var a = Eb($d, this._i);
            null != a ? this.utcOffset(a) : this.utcOffset(0, !0);
        }
        return this;
    }
    function Mb(a) {
        return (
            !!this.isValid() &&
            ((a = a ? tb(a).utcOffset() : 0), (this.utcOffset() - a) % 60 === 0)
        );
    }
    function Nb() {
        return (
            this.utcOffset() > this.clone().month(0).utcOffset() ||
            this.utcOffset() > this.clone().month(5).utcOffset()
        );
    }
    function Ob() {
        if (!f(this._isDSTShifted)) return this._isDSTShifted;
        var a = {};
        if ((q(a, this), (a = qb(a)), a._a)) {
            var b = a._isUTC ? l(a._a) : tb(a._a);
            this._isDSTShifted = this.isValid() && v(a._a, b.toArray()) > 0;
        } else this._isDSTShifted = !1;
        return this._isDSTShifted;
    }
    function Pb() {
        return !!this.isValid() && !this._isUTC;
    }
    function Qb() {
        return !!this.isValid() && this._isUTC;
    }
    function Rb() {
        return !!this.isValid() && this._isUTC && 0 === this._offset;
    }
    function Sb(a, b) {
        var c,
            d,
            e,
            f = a,
            h = null;
        return (
            Bb(a)
                ? (f = { ms: a._milliseconds, d: a._days, M: a._months })
                : g(a)
                ? ((f = {}), b ? (f[b] = a) : (f.milliseconds = a))
                : (h = Te.exec(a))
                ? ((c = "-" === h[1] ? -1 : 1),
                  (f = {
                      y: 0,
                      d: u(h[ge]) * c,
                      h: u(h[he]) * c,
                      m: u(h[ie]) * c,
                      s: u(h[je]) * c,
                      ms: u(Cb(1e3 * h[ke])) * c,
                  }))
                : (h = Ue.exec(a))
                ? ((c = "-" === h[1] ? -1 : 1),
                  (f = {
                      y: Tb(h[2], c),
                      M: Tb(h[3], c),
                      w: Tb(h[4], c),
                      d: Tb(h[5], c),
                      h: Tb(h[6], c),
                      m: Tb(h[7], c),
                      s: Tb(h[8], c),
                  }))
                : null == f
                ? (f = {})
                : "object" == typeof f &&
                  ("from" in f || "to" in f) &&
                  ((e = Vb(tb(f.from), tb(f.to))),
                  (f = {}),
                  (f.ms = e.milliseconds),
                  (f.M = e.months)),
            (d = new Ab(f)),
            Bb(a) && j(a, "_locale") && (d._locale = a._locale),
            d
        );
    }
    function Tb(a, b) {
        var c = a && parseFloat(a.replace(",", "."));
        return (isNaN(c) ? 0 : c) * b;
    }
    function Ub(a, b) {
        var c = { milliseconds: 0, months: 0 };
        return (
            (c.months = b.month() - a.month() + 12 * (b.year() - a.year())),
            a.clone().add(c.months, "M").isAfter(b) && --c.months,
            (c.milliseconds = +b - +a.clone().add(c.months, "M")),
            c
        );
    }
    function Vb(a, b) {
        var c;
        return a.isValid() && b.isValid()
            ? ((b = Fb(b, a)),
              a.isBefore(b)
                  ? (c = Ub(a, b))
                  : ((c = Ub(b, a)),
                    (c.milliseconds = -c.milliseconds),
                    (c.months = -c.months)),
              c)
            : { milliseconds: 0, months: 0 };
    }
    function Wb(a, b) {
        return function (c, d) {
            var e, f;
            return (
                null === d ||
                    isNaN(+d) ||
                    (y(
                        b,
                        "moment()." +
                            b +
                            "(period, number) is deprecated. Please use moment()." +
                            b +
                            "(number, period). See http://momentjs.com/guides/#/warnings/add-inverted-param/ for more info."
                    ),
                    (f = c),
                    (c = d),
                    (d = f)),
                (c = "string" == typeof c ? +c : c),
                (e = Sb(c, d)),
                Xb(this, e, a),
                this
            );
        };
    }
    function Xb(b, c, d, e) {
        var f = c._milliseconds,
            g = Cb(c._days),
            h = Cb(c._months);
        b.isValid() &&
            ((e = null == e || e),
            f && b._d.setTime(b._d.valueOf() + f * d),
            g && Q(b, "Date", P(b, "Date") + g * d),
            h && ja(b, P(b, "Month") + h * d),
            e && a.updateOffset(b, g || h));
    }
    function Yb(a, b) {
        var c = a.diff(b, "days", !0);
        return c < -6
            ? "sameElse"
            : c < -1
            ? "lastWeek"
            : c < 0
            ? "lastDay"
            : c < 1
            ? "sameDay"
            : c < 2
            ? "nextDay"
            : c < 7
            ? "nextWeek"
            : "sameElse";
    }
    function Zb(b, c) {
        var d = b || tb(),
            e = Fb(d, this).startOf("day"),
            f = a.calendarFormat(this, e) || "sameElse",
            g = c && (z(c[f]) ? c[f].call(this, d) : c[f]);
        return this.format(g || this.localeData().calendar(f, this, tb(d)));
    }
    function $b() {
        return new r(this);
    }
    function _b(a, b) {
        var c = s(a) ? a : tb(a);
        return (
            !(!this.isValid() || !c.isValid()) &&
            ((b = K(f(b) ? "millisecond" : b)),
            "millisecond" === b
                ? this.valueOf() > c.valueOf()
                : c.valueOf() < this.clone().startOf(b).valueOf())
        );
    }
    function ac(a, b) {
        var c = s(a) ? a : tb(a);
        return (
            !(!this.isValid() || !c.isValid()) &&
            ((b = K(f(b) ? "millisecond" : b)),
            "millisecond" === b
                ? this.valueOf() < c.valueOf()
                : this.clone().endOf(b).valueOf() < c.valueOf())
        );
    }
    function bc(a, b, c, d) {
        return (
            (d = d || "()"),
            ("(" === d[0] ? this.isAfter(a, c) : !this.isBefore(a, c)) &&
                (")" === d[1] ? this.isBefore(b, c) : !this.isAfter(b, c))
        );
    }
    function cc(a, b) {
        var c,
            d = s(a) ? a : tb(a);
        return (
            !(!this.isValid() || !d.isValid()) &&
            ((b = K(b || "millisecond")),
            "millisecond" === b
                ? this.valueOf() === d.valueOf()
                : ((c = d.valueOf()),
                  this.clone().startOf(b).valueOf() <= c &&
                      c <= this.clone().endOf(b).valueOf()))
        );
    }
    function dc(a, b) {
        return this.isSame(a, b) || this.isAfter(a, b);
    }
    function ec(a, b) {
        return this.isSame(a, b) || this.isBefore(a, b);
    }
    function fc(a, b, c) {
        var d, e, f, g;
        return this.isValid()
            ? ((d = Fb(a, this)),
              d.isValid()
                  ? ((e = 6e4 * (d.utcOffset() - this.utcOffset())),
                    (b = K(b)),
                    "year" === b || "month" === b || "quarter" === b
                        ? ((g = gc(this, d)),
                          "quarter" === b
                              ? (g /= 3)
                              : "year" === b && (g /= 12))
                        : ((f = this - d),
                          (g =
                              "second" === b
                                  ? f / 1e3
                                  : "minute" === b
                                  ? f / 6e4
                                  : "hour" === b
                                  ? f / 36e5
                                  : "day" === b
                                  ? (f - e) / 864e5
                                  : "week" === b
                                  ? (f - e) / 6048e5
                                  : f)),
                    c ? g : t(g))
                  : NaN)
            : NaN;
    }
    function gc(a, b) {
        var c,
            d,
            e = 12 * (b.year() - a.year()) + (b.month() - a.month()),
            f = a.clone().add(e, "months");
        return (
            b - f < 0
                ? ((c = a.clone().add(e - 1, "months")),
                  (d = (b - f) / (f - c)))
                : ((c = a.clone().add(e + 1, "months")),
                  (d = (b - f) / (c - f))),
            -(e + d) || 0
        );
    }
    function hc() {
        return this.clone()
            .locale("en")
            .format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ");
    }
    function ic() {
        if (!this.isValid()) return null;
        var a = this.clone().utc();
        return a.year() < 0 || a.year() > 9999
            ? X(a, "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]")
            : z(Date.prototype.toISOString)
            ? this.toDate().toISOString()
            : X(a, "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]");
    }
    function jc() {
        if (!this.isValid()) return "moment.invalid(/* " + this._i + " */)";
        var a = "moment",
            b = "";
        this.isLocal() ||
            ((a = 0 === this.utcOffset() ? "moment.utc" : "moment.parseZone"),
            (b = "Z"));
        var c = "[" + a + '("]',
            d = 0 <= this.year() && this.year() <= 9999 ? "YYYY" : "YYYYYY",
            e = "-MM-DD[T]HH:mm:ss.SSS",
            f = b + '[")]';
        return this.format(c + d + e + f);
    }
    function kc(b) {
        b || (b = this.isUtc() ? a.defaultFormatUtc : a.defaultFormat);
        var c = X(this, b);
        return this.localeData().postformat(c);
    }
    function lc(a, b) {
        return this.isValid() && ((s(a) && a.isValid()) || tb(a).isValid())
            ? Sb({ to: this, from: a }).locale(this.locale()).humanize(!b)
            : this.localeData().invalidDate();
    }
    function mc(a) {
        return this.from(tb(), a);
    }
    function nc(a, b) {
        return this.isValid() && ((s(a) && a.isValid()) || tb(a).isValid())
            ? Sb({ from: this, to: a }).locale(this.locale()).humanize(!b)
            : this.localeData().invalidDate();
    }
    function oc(a) {
        return this.to(tb(), a);
    }
    function pc(a) {
        var b;
        return void 0 === a
            ? this._locale._abbr
            : ((b = bb(a)), null != b && (this._locale = b), this);
    }
    function qc() {
        return this._locale;
    }
    function rc(a) {
        switch ((a = K(a))) {
            case "year":
                this.month(0);
            case "quarter":
            case "month":
                this.date(1);
            case "week":
            case "isoWeek":
            case "day":
            case "date":
                this.hours(0);
            case "hour":
                this.minutes(0);
            case "minute":
                this.seconds(0);
            case "second":
                this.milliseconds(0);
        }
        return (
            "week" === a && this.weekday(0),
            "isoWeek" === a && this.isoWeekday(1),
            "quarter" === a && this.month(3 * Math.floor(this.month() / 3)),
            this
        );
    }
    function sc(a) {
        return (
            (a = K(a)),
            void 0 === a || "millisecond" === a
                ? this
                : ("date" === a && (a = "day"),
                  this.startOf(a)
                      .add(1, "isoWeek" === a ? "week" : a)
                      .subtract(1, "ms"))
        );
    }
    function tc() {
        return this._d.valueOf() - 6e4 * (this._offset || 0);
    }
    function uc() {
        return Math.floor(this.valueOf() / 1e3);
    }
    function vc() {
        return new Date(this.valueOf());
    }
    function wc() {
        var a = this;
        return [
            a.year(),
            a.month(),
            a.date(),
            a.hour(),
            a.minute(),
            a.second(),
            a.millisecond(),
        ];
    }
    function xc() {
        var a = this;
        return {
            years: a.year(),
            months: a.month(),
            date: a.date(),
            hours: a.hours(),
            minutes: a.minutes(),
            seconds: a.seconds(),
            milliseconds: a.milliseconds(),
        };
    }
    function yc() {
        return this.isValid() ? this.toISOString() : null;
    }
    function zc() {
        return o(this);
    }
    function Ac() {
        return k({}, n(this));
    }
    function Bc() {
        return n(this).overflow;
    }
    function Cc() {
        return {
            input: this._i,
            format: this._f,
            locale: this._locale,
            isUTC: this._isUTC,
            strict: this._strict,
        };
    }
    function Dc(a, b) {
        U(0, [a, a.length], 0, b);
    }
    function Ec(a) {
        return Ic.call(
            this,
            a,
            this.week(),
            this.weekday(),
            this.localeData()._week.dow,
            this.localeData()._week.doy
        );
    }
    function Fc(a) {
        return Ic.call(this, a, this.isoWeek(), this.isoWeekday(), 1, 4);
    }
    function Gc() {
        return xa(this.year(), 1, 4);
    }
    function Hc() {
        var a = this.localeData()._week;
        return xa(this.year(), a.dow, a.doy);
    }
    function Ic(a, b, c, d, e) {
        var f;
        return null == a
            ? wa(this, d, e).year
            : ((f = xa(a, d, e)),
              b > f && (b = f),
              Jc.call(this, a, b, c, d, e));
    }
    function Jc(a, b, c, d, e) {
        var f = va(a, b, c, d, e),
            g = ta(f.year, 0, f.dayOfYear);
        return (
            this.year(g.getUTCFullYear()),
            this.month(g.getUTCMonth()),
            this.date(g.getUTCDate()),
            this
        );
    }
    function Kc(a) {
        return null == a
            ? Math.ceil((this.month() + 1) / 3)
            : this.month(3 * (a - 1) + (this.month() % 3));
    }
    function Lc(a) {
        var b =
            Math.round(
                (this.clone().startOf("day") - this.clone().startOf("year")) /
                    864e5
            ) + 1;
        return null == a ? b : this.add(a - b, "d");
    }
    function Mc(a, b) {
        b[ke] = u(1e3 * ("0." + a));
    }
    function Nc() {
        return this._isUTC ? "UTC" : "";
    }
    function Oc() {
        return this._isUTC ? "Coordinated Universal Time" : "";
    }
    function Pc(a) {
        return tb(1e3 * a);
    }
    function Qc() {
        return tb.apply(null, arguments).parseZone();
    }
    function Rc(a) {
        return a;
    }
    function Sc(a, b, c, d) {
        var e = bb(),
            f = l().set(d, b);
        return e[c](f, a);
    }
    function Tc(a, b, c) {
        if ((g(a) && ((b = a), (a = void 0)), (a = a || ""), null != b))
            return Sc(a, b, c, "month");
        var d,
            e = [];
        for (d = 0; d < 12; d++) e[d] = Sc(a, d, c, "month");
        return e;
    }
    function Uc(a, b, c, d) {
        "boolean" == typeof a
            ? (g(b) && ((c = b), (b = void 0)), (b = b || ""))
            : ((b = a),
              (c = b),
              (a = !1),
              g(b) && ((c = b), (b = void 0)),
              (b = b || ""));
        var e = bb(),
            f = a ? e._week.dow : 0;
        if (null != c) return Sc(b, (c + f) % 7, d, "day");
        var h,
            i = [];
        for (h = 0; h < 7; h++) i[h] = Sc(b, (h + f) % 7, d, "day");
        return i;
    }
    function Vc(a, b) {
        return Tc(a, b, "months");
    }
    function Wc(a, b) {
        return Tc(a, b, "monthsShort");
    }
    function Xc(a, b, c) {
        return Uc(a, b, c, "weekdays");
    }
    function Yc(a, b, c) {
        return Uc(a, b, c, "weekdaysShort");
    }
    function Zc(a, b, c) {
        return Uc(a, b, c, "weekdaysMin");
    }
    function $c() {
        var a = this._data;
        return (
            (this._milliseconds = df(this._milliseconds)),
            (this._days = df(this._days)),
            (this._months = df(this._months)),
            (a.milliseconds = df(a.milliseconds)),
            (a.seconds = df(a.seconds)),
            (a.minutes = df(a.minutes)),
            (a.hours = df(a.hours)),
            (a.months = df(a.months)),
            (a.years = df(a.years)),
            this
        );
    }
    function _c(a, b, c, d) {
        var e = Sb(b, c);
        return (
            (a._milliseconds += d * e._milliseconds),
            (a._days += d * e._days),
            (a._months += d * e._months),
            a._bubble()
        );
    }
    function ad(a, b) {
        return _c(this, a, b, 1);
    }
    function bd(a, b) {
        return _c(this, a, b, -1);
    }
    function cd(a) {
        return a < 0 ? Math.floor(a) : Math.ceil(a);
    }
    function dd() {
        var a,
            b,
            c,
            d,
            e,
            f = this._milliseconds,
            g = this._days,
            h = this._months,
            i = this._data;
        return (
            (f >= 0 && g >= 0 && h >= 0) ||
                (f <= 0 && g <= 0 && h <= 0) ||
                ((f += 864e5 * cd(fd(h) + g)), (g = 0), (h = 0)),
            (i.milliseconds = f % 1e3),
            (a = t(f / 1e3)),
            (i.seconds = a % 60),
            (b = t(a / 60)),
            (i.minutes = b % 60),
            (c = t(b / 60)),
            (i.hours = c % 24),
            (g += t(c / 24)),
            (e = t(ed(g))),
            (h += e),
            (g -= cd(fd(e))),
            (d = t(h / 12)),
            (h %= 12),
            (i.days = g),
            (i.months = h),
            (i.years = d),
            this
        );
    }
    function ed(a) {
        return (4800 * a) / 146097;
    }
    function fd(a) {
        return (146097 * a) / 4800;
    }
    function gd(a) {
        if (!this.isValid()) return NaN;
        var b,
            c,
            d = this._milliseconds;
        if (((a = K(a)), "month" === a || "year" === a))
            return (
                (b = this._days + d / 864e5),
                (c = this._months + ed(b)),
                "month" === a ? c : c / 12
            );
        switch (((b = this._days + Math.round(fd(this._months))), a)) {
            case "week":
                return b / 7 + d / 6048e5;
            case "day":
                return b + d / 864e5;
            case "hour":
                return 24 * b + d / 36e5;
            case "minute":
                return 1440 * b + d / 6e4;
            case "second":
                return 86400 * b + d / 1e3;
            case "millisecond":
                return Math.floor(864e5 * b) + d;
            default:
                throw new Error("Unknown unit " + a);
        }
    }
    function hd() {
        return this.isValid()
            ? this._milliseconds +
                  864e5 * this._days +
                  (this._months % 12) * 2592e6 +
                  31536e6 * u(this._months / 12)
            : NaN;
    }
    function id(a) {
        return function () {
            return this.as(a);
        };
    }
    function jd(a) {
        return (a = K(a)), this.isValid() ? this[a + "s"]() : NaN;
    }
    function kd(a) {
        return function () {
            return this.isValid() ? this._data[a] : NaN;
        };
    }
    function ld() {
        return t(this.days() / 7);
    }
    function md(a, b, c, d, e) {
        return e.relativeTime(b || 1, !!c, a, d);
    }
    function nd(a, b, c) {
        var d = Sb(a).abs(),
            e = uf(d.as("s")),
            f = uf(d.as("m")),
            g = uf(d.as("h")),
            h = uf(d.as("d")),
            i = uf(d.as("M")),
            j = uf(d.as("y")),
            k = (e <= vf.ss && ["s", e]) ||
                (e < vf.s && ["ss", e]) ||
                (f <= 1 && ["m"]) ||
                (f < vf.m && ["mm", f]) ||
                (g <= 1 && ["h"]) ||
                (g < vf.h && ["hh", g]) ||
                (h <= 1 && ["d"]) ||
                (h < vf.d && ["dd", h]) ||
                (i <= 1 && ["M"]) ||
                (i < vf.M && ["MM", i]) ||
                (j <= 1 && ["y"]) || ["yy", j];
        return (k[2] = b), (k[3] = +a > 0), (k[4] = c), md.apply(null, k);
    }
    function od(a) {
        return void 0 === a ? uf : "function" == typeof a && ((uf = a), !0);
    }
    function pd(a, b) {
        return (
            void 0 !== vf[a] &&
            (void 0 === b
                ? vf[a]
                : ((vf[a] = b), "s" === a && (vf.ss = b - 1), !0))
        );
    }
    function qd(a) {
        if (!this.isValid()) return this.localeData().invalidDate();
        var b = this.localeData(),
            c = nd(this, !a, b);
        return a && (c = b.pastFuture(+this, c)), b.postformat(c);
    }
    function rd() {
        if (!this.isValid()) return this.localeData().invalidDate();
        var a,
            b,
            c,
            d = wf(this._milliseconds) / 1e3,
            e = wf(this._days),
            f = wf(this._months);
        (a = t(d / 60)),
            (b = t(a / 60)),
            (d %= 60),
            (a %= 60),
            (c = t(f / 12)),
            (f %= 12);
        var g = c,
            h = f,
            i = e,
            j = b,
            k = a,
            l = d,
            m = this.asSeconds();
        return m
            ? (m < 0 ? "-" : "") +
                  "P" +
                  (g ? g + "Y" : "") +
                  (h ? h + "M" : "") +
                  (i ? i + "D" : "") +
                  (j || k || l ? "T" : "") +
                  (j ? j + "H" : "") +
                  (k ? k + "M" : "") +
                  (l ? l + "S" : "")
            : "P0D";
    }
    var sd, td;
    td = Array.prototype.some
        ? Array.prototype.some
        : function (a) {
              for (var b = Object(this), c = b.length >>> 0, d = 0; d < c; d++)
                  if (d in b && a.call(this, b[d], d, b)) return !0;
              return !1;
          };
    var ud = td,
        vd = (a.momentProperties = []),
        wd = !1,
        xd = {};
    (a.suppressDeprecationWarnings = !1), (a.deprecationHandler = null);
    var yd;
    yd = Object.keys
        ? Object.keys
        : function (a) {
              var b,
                  c = [];
              for (b in a) j(a, b) && c.push(b);
              return c;
          };
    var zd,
        Ad = yd,
        Bd = {
            sameDay: "[Today at] LT",
            nextDay: "[Tomorrow at] LT",
            nextWeek: "dddd [at] LT",
            lastDay: "[Yesterday at] LT",
            lastWeek: "[Last] dddd [at] LT",
            sameElse: "L",
        },
        Cd = {
            LTS: "h:mm:ss A",
            LT: "h:mm A",
            L: "MM/DD/YYYY",
            LL: "MMMM D, YYYY",
            LLL: "MMMM D, YYYY h:mm A",
            LLLL: "dddd, MMMM D, YYYY h:mm A",
        },
        Dd = "Invalid date",
        Ed = "%d",
        Fd = /\d{1,2}/,
        Gd = {
            future: "in %s",
            past: "%s ago",
            s: "a few seconds",
            ss: "%d seconds",
            m: "a minute",
            mm: "%d minutes",
            h: "an hour",
            hh: "%d hours",
            d: "a day",
            dd: "%d days",
            M: "a month",
            MM: "%d months",
            y: "a year",
            yy: "%d years",
        },
        Hd = {},
        Id = {},
        Jd =
            /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,
        Kd = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,
        Ld = {},
        Md = {},
        Nd = /\d/,
        Od = /\d\d/,
        Pd = /\d{3}/,
        Qd = /\d{4}/,
        Rd = /[+-]?\d{6}/,
        Sd = /\d\d?/,
        Td = /\d\d\d\d?/,
        Ud = /\d\d\d\d\d\d?/,
        Vd = /\d{1,3}/,
        Wd = /\d{1,4}/,
        Xd = /[+-]?\d{1,6}/,
        Yd = /\d+/,
        Zd = /[+-]?\d+/,
        $d = /Z|[+-]\d\d:?\d\d/gi,
        _d = /Z|[+-]\d\d(?::?\d\d)?/gi,
        ae = /[+-]?\d+(\.\d{1,3})?/,
        be =
            /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i,
        ce = {},
        de = {},
        ee = 0,
        fe = 1,
        ge = 2,
        he = 3,
        ie = 4,
        je = 5,
        ke = 6,
        le = 7,
        me = 8;
    zd = Array.prototype.indexOf
        ? Array.prototype.indexOf
        : function (a) {
              var b;
              for (b = 0; b < this.length; ++b) if (this[b] === a) return b;
              return -1;
          };
    var ne = zd;
    U("M", ["MM", 2], "Mo", function () {
        return this.month() + 1;
    }),
        U("MMM", 0, 0, function (a) {
            return this.localeData().monthsShort(this, a);
        }),
        U("MMMM", 0, 0, function (a) {
            return this.localeData().months(this, a);
        }),
        J("month", "M"),
        M("month", 8),
        Z("M", Sd),
        Z("MM", Sd, Od),
        Z("MMM", function (a, b) {
            return b.monthsShortRegex(a);
        }),
        Z("MMMM", function (a, b) {
            return b.monthsRegex(a);
        }),
        ba(["M", "MM"], function (a, b) {
            b[fe] = u(a) - 1;
        }),
        ba(["MMM", "MMMM"], function (a, b, c, d) {
            var e = c._locale.monthsParse(a, d, c._strict);
            null != e ? (b[fe] = e) : (n(c).invalidMonth = a);
        });
    var oe = /D[oD]?(\[[^\[\]]*\]|\s)+MMMM?/,
        pe =
            "January_February_March_April_May_June_July_August_September_October_November_December".split(
                "_"
            ),
        qe = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
        re = be,
        se = be;
    U("Y", 0, 0, function () {
        var a = this.year();
        return a <= 9999 ? "" + a : "+" + a;
    }),
        U(0, ["YY", 2], 0, function () {
            return this.year() % 100;
        }),
        U(0, ["YYYY", 4], 0, "year"),
        U(0, ["YYYYY", 5], 0, "year"),
        U(0, ["YYYYYY", 6, !0], 0, "year"),
        J("year", "y"),
        M("year", 1),
        Z("Y", Zd),
        Z("YY", Sd, Od),
        Z("YYYY", Wd, Qd),
        Z("YYYYY", Xd, Rd),
        Z("YYYYYY", Xd, Rd),
        ba(["YYYYY", "YYYYYY"], ee),
        ba("YYYY", function (b, c) {
            c[ee] = 2 === b.length ? a.parseTwoDigitYear(b) : u(b);
        }),
        ba("YY", function (b, c) {
            c[ee] = a.parseTwoDigitYear(b);
        }),
        ba("Y", function (a, b) {
            b[ee] = parseInt(a, 10);
        }),
        (a.parseTwoDigitYear = function (a) {
            return u(a) + (u(a) > 68 ? 1900 : 2e3);
        });
    var te = O("FullYear", !0);
    U("w", ["ww", 2], "wo", "week"),
        U("W", ["WW", 2], "Wo", "isoWeek"),
        J("week", "w"),
        J("isoWeek", "W"),
        M("week", 5),
        M("isoWeek", 5),
        Z("w", Sd),
        Z("ww", Sd, Od),
        Z("W", Sd),
        Z("WW", Sd, Od),
        ca(["w", "ww", "W", "WW"], function (a, b, c, d) {
            b[d.substr(0, 1)] = u(a);
        });
    var ue = { dow: 0, doy: 6 };
    U("d", 0, "do", "day"),
        U("dd", 0, 0, function (a) {
            return this.localeData().weekdaysMin(this, a);
        }),
        U("ddd", 0, 0, function (a) {
            return this.localeData().weekdaysShort(this, a);
        }),
        U("dddd", 0, 0, function (a) {
            return this.localeData().weekdays(this, a);
        }),
        U("e", 0, 0, "weekday"),
        U("E", 0, 0, "isoWeekday"),
        J("day", "d"),
        J("weekday", "e"),
        J("isoWeekday", "E"),
        M("day", 11),
        M("weekday", 11),
        M("isoWeekday", 11),
        Z("d", Sd),
        Z("e", Sd),
        Z("E", Sd),
        Z("dd", function (a, b) {
            return b.weekdaysMinRegex(a);
        }),
        Z("ddd", function (a, b) {
            return b.weekdaysShortRegex(a);
        }),
        Z("dddd", function (a, b) {
            return b.weekdaysRegex(a);
        }),
        ca(["dd", "ddd", "dddd"], function (a, b, c, d) {
            var e = c._locale.weekdaysParse(a, d, c._strict);
            null != e ? (b.d = e) : (n(c).invalidWeekday = a);
        }),
        ca(["d", "e", "E"], function (a, b, c, d) {
            b[d] = u(a);
        });
    var ve = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split(
            "_"
        ),
        we = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
        xe = "Su_Mo_Tu_We_Th_Fr_Sa".split("_"),
        ye = be,
        ze = be,
        Ae = be;
    U("H", ["HH", 2], 0, "hour"),
        U("h", ["hh", 2], 0, Ra),
        U("k", ["kk", 2], 0, Sa),
        U("hmm", 0, 0, function () {
            return "" + Ra.apply(this) + T(this.minutes(), 2);
        }),
        U("hmmss", 0, 0, function () {
            return (
                "" +
                Ra.apply(this) +
                T(this.minutes(), 2) +
                T(this.seconds(), 2)
            );
        }),
        U("Hmm", 0, 0, function () {
            return "" + this.hours() + T(this.minutes(), 2);
        }),
        U("Hmmss", 0, 0, function () {
            return (
                "" + this.hours() + T(this.minutes(), 2) + T(this.seconds(), 2)
            );
        }),
        Ta("a", !0),
        Ta("A", !1),
        J("hour", "h"),
        M("hour", 13),
        Z("a", Ua),
        Z("A", Ua),
        Z("H", Sd),
        Z("h", Sd),
        Z("k", Sd),
        Z("HH", Sd, Od),
        Z("hh", Sd, Od),
        Z("kk", Sd, Od),
        Z("hmm", Td),
        Z("hmmss", Ud),
        Z("Hmm", Td),
        Z("Hmmss", Ud),
        ba(["H", "HH"], he),
        ba(["k", "kk"], function (a, b, c) {
            var d = u(a);
            b[he] = 24 === d ? 0 : d;
        }),
        ba(["a", "A"], function (a, b, c) {
            (c._isPm = c._locale.isPM(a)), (c._meridiem = a);
        }),
        ba(["h", "hh"], function (a, b, c) {
            (b[he] = u(a)), (n(c).bigHour = !0);
        }),
        ba("hmm", function (a, b, c) {
            var d = a.length - 2;
            (b[he] = u(a.substr(0, d))),
                (b[ie] = u(a.substr(d))),
                (n(c).bigHour = !0);
        }),
        ba("hmmss", function (a, b, c) {
            var d = a.length - 4,
                e = a.length - 2;
            (b[he] = u(a.substr(0, d))),
                (b[ie] = u(a.substr(d, 2))),
                (b[je] = u(a.substr(e))),
                (n(c).bigHour = !0);
        }),
        ba("Hmm", function (a, b, c) {
            var d = a.length - 2;
            (b[he] = u(a.substr(0, d))), (b[ie] = u(a.substr(d)));
        }),
        ba("Hmmss", function (a, b, c) {
            var d = a.length - 4,
                e = a.length - 2;
            (b[he] = u(a.substr(0, d))),
                (b[ie] = u(a.substr(d, 2))),
                (b[je] = u(a.substr(e)));
        });
    var Be,
        Ce = /[ap]\.?m?\.?/i,
        De = O("Hours", !0),
        Ee = {
            calendar: Bd,
            longDateFormat: Cd,
            invalidDate: Dd,
            ordinal: Ed,
            dayOfMonthOrdinalParse: Fd,
            relativeTime: Gd,
            months: pe,
            monthsShort: qe,
            week: ue,
            weekdays: ve,
            weekdaysMin: xe,
            weekdaysShort: we,
            meridiemParse: Ce,
        },
        Fe = {},
        Ge = {},
        He =
            /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
        Ie =
            /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
        Je = /Z|[+-]\d\d(?::?\d\d)?/,
        Ke = [
            ["YYYYYY-MM-DD", /[+-]\d{6}-\d\d-\d\d/],
            ["YYYY-MM-DD", /\d{4}-\d\d-\d\d/],
            ["GGGG-[W]WW-E", /\d{4}-W\d\d-\d/],
            ["GGGG-[W]WW", /\d{4}-W\d\d/, !1],
            ["YYYY-DDD", /\d{4}-\d{3}/],
            ["YYYY-MM", /\d{4}-\d\d/, !1],
            ["YYYYYYMMDD", /[+-]\d{10}/],
            ["YYYYMMDD", /\d{8}/],
            ["GGGG[W]WWE", /\d{4}W\d{3}/],
            ["GGGG[W]WW", /\d{4}W\d{2}/, !1],
            ["YYYYDDD", /\d{7}/],
        ],
        Le = [
            ["HH:mm:ss.SSSS", /\d\d:\d\d:\d\d\.\d+/],
            ["HH:mm:ss,SSSS", /\d\d:\d\d:\d\d,\d+/],
            ["HH:mm:ss", /\d\d:\d\d:\d\d/],
            ["HH:mm", /\d\d:\d\d/],
            ["HHmmss.SSSS", /\d\d\d\d\d\d\.\d+/],
            ["HHmmss,SSSS", /\d\d\d\d\d\d,\d+/],
            ["HHmmss", /\d\d\d\d\d\d/],
            ["HHmm", /\d\d\d\d/],
            ["HH", /\d\d/],
        ],
        Me = /^\/?Date\((\-?\d+)/i,
        Ne =
            /^((?:Mon|Tue|Wed|Thu|Fri|Sat|Sun),?\s)?(\d?\d\s(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(?:\d\d)?\d\d\s)(\d\d:\d\d)(\:\d\d)?(\s(?:UT|GMT|[ECMP][SD]T|[A-IK-Za-ik-z]|[+-]\d{4}))$/;
    (a.createFromInputFallback = x(
        "value provided is not in a recognized RFC2822 or ISO format. moment construction falls back to js Date(), which is not reliable across all browsers and versions. Non RFC2822/ISO date formats are discouraged and will be removed in an upcoming major release. Please refer to http://momentjs.com/guides/#/warnings/js-date/ for more info.",
        function (a) {
            a._d = new Date(a._i + (a._useUTC ? " UTC" : ""));
        }
    )),
        (a.ISO_8601 = function () {}),
        (a.RFC_2822 = function () {});
    var Oe = x(
            "moment().min is deprecated, use moment.max instead. http://momentjs.com/guides/#/warnings/min-max/",
            function () {
                var a = tb.apply(null, arguments);
                return this.isValid() && a.isValid()
                    ? a < this
                        ? this
                        : a
                    : p();
            }
        ),
        Pe = x(
            "moment().max is deprecated, use moment.min instead. http://momentjs.com/guides/#/warnings/min-max/",
            function () {
                var a = tb.apply(null, arguments);
                return this.isValid() && a.isValid()
                    ? a > this
                        ? this
                        : a
                    : p();
            }
        ),
        Qe = function () {
            return Date.now ? Date.now() : +new Date();
        },
        Re = [
            "year",
            "quarter",
            "month",
            "week",
            "day",
            "hour",
            "minute",
            "second",
            "millisecond",
        ];
    Db("Z", ":"),
        Db("ZZ", ""),
        Z("Z", _d),
        Z("ZZ", _d),
        ba(["Z", "ZZ"], function (a, b, c) {
            (c._useUTC = !0), (c._tzm = Eb(_d, a));
        });
    var Se = /([\+\-]|\d\d)/gi;
    a.updateOffset = function () {};
    var Te = /^(\-)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)(\.\d*)?)?$/,
        Ue =
            /^(-)?P(?:(-?[0-9,.]*)Y)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)W)?(?:(-?[0-9,.]*)D)?(?:T(?:(-?[0-9,.]*)H)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)S)?)?$/;
    (Sb.fn = Ab.prototype), (Sb.invalid = zb);
    var Ve = Wb(1, "add"),
        We = Wb(-1, "subtract");
    (a.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ"),
        (a.defaultFormatUtc = "YYYY-MM-DDTHH:mm:ss[Z]");
    var Xe = x(
        "moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.",
        function (a) {
            return void 0 === a ? this.localeData() : this.locale(a);
        }
    );
    U(0, ["gg", 2], 0, function () {
        return this.weekYear() % 100;
    }),
        U(0, ["GG", 2], 0, function () {
            return this.isoWeekYear() % 100;
        }),
        Dc("gggg", "weekYear"),
        Dc("ggggg", "weekYear"),
        Dc("GGGG", "isoWeekYear"),
        Dc("GGGGG", "isoWeekYear"),
        J("weekYear", "gg"),
        J("isoWeekYear", "GG"),
        M("weekYear", 1),
        M("isoWeekYear", 1),
        Z("G", Zd),
        Z("g", Zd),
        Z("GG", Sd, Od),
        Z("gg", Sd, Od),
        Z("GGGG", Wd, Qd),
        Z("gggg", Wd, Qd),
        Z("GGGGG", Xd, Rd),
        Z("ggggg", Xd, Rd),
        ca(["gggg", "ggggg", "GGGG", "GGGGG"], function (a, b, c, d) {
            b[d.substr(0, 2)] = u(a);
        }),
        ca(["gg", "GG"], function (b, c, d, e) {
            c[e] = a.parseTwoDigitYear(b);
        }),
        U("Q", 0, "Qo", "quarter"),
        J("quarter", "Q"),
        M("quarter", 7),
        Z("Q", Nd),
        ba("Q", function (a, b) {
            b[fe] = 3 * (u(a) - 1);
        }),
        U("D", ["DD", 2], "Do", "date"),
        J("date", "D"),
        M("date", 9),
        Z("D", Sd),
        Z("DD", Sd, Od),
        Z("Do", function (a, b) {
            return a
                ? b._dayOfMonthOrdinalParse || b._ordinalParse
                : b._dayOfMonthOrdinalParseLenient;
        }),
        ba(["D", "DD"], ge),
        ba("Do", function (a, b) {
            b[ge] = u(a.match(Sd)[0], 10);
        });
    var Ye = O("Date", !0);
    U("DDD", ["DDDD", 3], "DDDo", "dayOfYear"),
        J("dayOfYear", "DDD"),
        M("dayOfYear", 4),
        Z("DDD", Vd),
        Z("DDDD", Pd),
        ba(["DDD", "DDDD"], function (a, b, c) {
            c._dayOfYear = u(a);
        }),
        U("m", ["mm", 2], 0, "minute"),
        J("minute", "m"),
        M("minute", 14),
        Z("m", Sd),
        Z("mm", Sd, Od),
        ba(["m", "mm"], ie);
    var Ze = O("Minutes", !1);
    U("s", ["ss", 2], 0, "second"),
        J("second", "s"),
        M("second", 15),
        Z("s", Sd),
        Z("ss", Sd, Od),
        ba(["s", "ss"], je);
    var $e = O("Seconds", !1);
    U("S", 0, 0, function () {
        return ~~(this.millisecond() / 100);
    }),
        U(0, ["SS", 2], 0, function () {
            return ~~(this.millisecond() / 10);
        }),
        U(0, ["SSS", 3], 0, "millisecond"),
        U(0, ["SSSS", 4], 0, function () {
            return 10 * this.millisecond();
        }),
        U(0, ["SSSSS", 5], 0, function () {
            return 100 * this.millisecond();
        }),
        U(0, ["SSSSSS", 6], 0, function () {
            return 1e3 * this.millisecond();
        }),
        U(0, ["SSSSSSS", 7], 0, function () {
            return 1e4 * this.millisecond();
        }),
        U(0, ["SSSSSSSS", 8], 0, function () {
            return 1e5 * this.millisecond();
        }),
        U(0, ["SSSSSSSSS", 9], 0, function () {
            return 1e6 * this.millisecond();
        }),
        J("millisecond", "ms"),
        M("millisecond", 16),
        Z("S", Vd, Nd),
        Z("SS", Vd, Od),
        Z("SSS", Vd, Pd);
    var _e;
    for (_e = "SSSS"; _e.length <= 9; _e += "S") Z(_e, Yd);
    for (_e = "S"; _e.length <= 9; _e += "S") ba(_e, Mc);
    var af = O("Milliseconds", !1);
    U("z", 0, 0, "zoneAbbr"), U("zz", 0, 0, "zoneName");
    var bf = r.prototype;
    (bf.add = Ve),
        (bf.calendar = Zb),
        (bf.clone = $b),
        (bf.diff = fc),
        (bf.endOf = sc),
        (bf.format = kc),
        (bf.from = lc),
        (bf.fromNow = mc),
        (bf.to = nc),
        (bf.toNow = oc),
        (bf.get = R),
        (bf.invalidAt = Bc),
        (bf.isAfter = _b),
        (bf.isBefore = ac),
        (bf.isBetween = bc),
        (bf.isSame = cc),
        (bf.isSameOrAfter = dc),
        (bf.isSameOrBefore = ec),
        (bf.isValid = zc),
        (bf.lang = Xe),
        (bf.locale = pc),
        (bf.localeData = qc),
        (bf.max = Pe),
        (bf.min = Oe),
        (bf.parsingFlags = Ac),
        (bf.set = S),
        (bf.startOf = rc),
        (bf.subtract = We),
        (bf.toArray = wc),
        (bf.toObject = xc),
        (bf.toDate = vc),
        (bf.toISOString = ic),
        (bf.inspect = jc),
        (bf.toJSON = yc),
        (bf.toString = hc),
        (bf.unix = uc),
        (bf.valueOf = tc),
        (bf.creationData = Cc),
        (bf.year = te),
        (bf.isLeapYear = ra),
        (bf.weekYear = Ec),
        (bf.isoWeekYear = Fc),
        (bf.quarter = bf.quarters = Kc),
        (bf.month = ka),
        (bf.daysInMonth = la),
        (bf.week = bf.weeks = Ba),
        (bf.isoWeek = bf.isoWeeks = Ca),
        (bf.weeksInYear = Hc),
        (bf.isoWeeksInYear = Gc),
        (bf.date = Ye),
        (bf.day = bf.days = Ka),
        (bf.weekday = La),
        (bf.isoWeekday = Ma),
        (bf.dayOfYear = Lc),
        (bf.hour = bf.hours = De),
        (bf.minute = bf.minutes = Ze),
        (bf.second = bf.seconds = $e),
        (bf.millisecond = bf.milliseconds = af),
        (bf.utcOffset = Hb),
        (bf.utc = Jb),
        (bf.local = Kb),
        (bf.parseZone = Lb),
        (bf.hasAlignedHourOffset = Mb),
        (bf.isDST = Nb),
        (bf.isLocal = Pb),
        (bf.isUtcOffset = Qb),
        (bf.isUtc = Rb),
        (bf.isUTC = Rb),
        (bf.zoneAbbr = Nc),
        (bf.zoneName = Oc),
        (bf.dates = x("dates accessor is deprecated. Use date instead.", Ye)),
        (bf.months = x("months accessor is deprecated. Use month instead", ka)),
        (bf.years = x("years accessor is deprecated. Use year instead", te)),
        (bf.zone = x(
            "moment().zone is deprecated, use moment().utcOffset instead. http://momentjs.com/guides/#/warnings/zone/",
            Ib
        )),
        (bf.isDSTShifted = x(
            "isDSTShifted is deprecated. See http://momentjs.com/guides/#/warnings/dst-shifted/ for more information",
            Ob
        ));
    var cf = C.prototype;
    (cf.calendar = D),
        (cf.longDateFormat = E),
        (cf.invalidDate = F),
        (cf.ordinal = G),
        (cf.preparse = Rc),
        (cf.postformat = Rc),
        (cf.relativeTime = H),
        (cf.pastFuture = I),
        (cf.set = A),
        (cf.months = fa),
        (cf.monthsShort = ga),
        (cf.monthsParse = ia),
        (cf.monthsRegex = na),
        (cf.monthsShortRegex = ma),
        (cf.week = ya),
        (cf.firstDayOfYear = Aa),
        (cf.firstDayOfWeek = za),
        (cf.weekdays = Fa),
        (cf.weekdaysMin = Ha),
        (cf.weekdaysShort = Ga),
        (cf.weekdaysParse = Ja),
        (cf.weekdaysRegex = Na),
        (cf.weekdaysShortRegex = Oa),
        (cf.weekdaysMinRegex = Pa),
        (cf.isPM = Va),
        (cf.meridiem = Wa),
        $a("en", {
            dayOfMonthOrdinalParse: /\d{1,2}(th|st|nd|rd)/,
            ordinal: function (a) {
                var b = a % 10,
                    c =
                        1 === u((a % 100) / 10)
                            ? "th"
                            : 1 === b
                            ? "st"
                            : 2 === b
                            ? "nd"
                            : 3 === b
                            ? "rd"
                            : "th";
                return a + c;
            },
        }),
        (a.lang = x(
            "moment.lang is deprecated. Use moment.locale instead.",
            $a
        )),
        (a.langData = x(
            "moment.langData is deprecated. Use moment.localeData instead.",
            bb
        ));
    var df = Math.abs,
        ef = id("ms"),
        ff = id("s"),
        gf = id("m"),
        hf = id("h"),
        jf = id("d"),
        kf = id("w"),
        lf = id("M"),
        mf = id("y"),
        nf = kd("milliseconds"),
        of = kd("seconds"),
        pf = kd("minutes"),
        qf = kd("hours"),
        rf = kd("days"),
        sf = kd("months"),
        tf = kd("years"),
        uf = Math.round,
        vf = { ss: 44, s: 45, m: 45, h: 22, d: 26, M: 11 },
        wf = Math.abs,
        xf = Ab.prototype;
    return (
        (xf.isValid = yb),
        (xf.abs = $c),
        (xf.add = ad),
        (xf.subtract = bd),
        (xf.as = gd),
        (xf.asMilliseconds = ef),
        (xf.asSeconds = ff),
        (xf.asMinutes = gf),
        (xf.asHours = hf),
        (xf.asDays = jf),
        (xf.asWeeks = kf),
        (xf.asMonths = lf),
        (xf.asYears = mf),
        (xf.valueOf = hd),
        (xf._bubble = dd),
        (xf.get = jd),
        (xf.milliseconds = nf),
        (xf.seconds = of),
        (xf.minutes = pf),
        (xf.hours = qf),
        (xf.days = rf),
        (xf.weeks = ld),
        (xf.months = sf),
        (xf.years = tf),
        (xf.humanize = qd),
        (xf.toISOString = rd),
        (xf.toString = rd),
        (xf.toJSON = rd),
        (xf.locale = pc),
        (xf.localeData = qc),
        (xf.toIsoString = x(
            "toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)",
            rd
        )),
        (xf.lang = Xe),
        U("X", 0, 0, "unix"),
        U("x", 0, 0, "valueOf"),
        Z("x", Zd),
        Z("X", ae),
        ba("X", function (a, b, c) {
            c._d = new Date(1e3 * parseFloat(a, 10));
        }),
        ba("x", function (a, b, c) {
            c._d = new Date(u(a));
        }),
        (a.version = "2.18.1"),
        b(tb),
        (a.fn = bf),
        (a.min = vb),
        (a.max = wb),
        (a.now = Qe),
        (a.utc = l),
        (a.unix = Pc),
        (a.months = Vc),
        (a.isDate = h),
        (a.locale = $a),
        (a.invalid = p),
        (a.duration = Sb),
        (a.isMoment = s),
        (a.weekdays = Xc),
        (a.parseZone = Qc),
        (a.localeData = bb),
        (a.isDuration = Bb),
        (a.monthsShort = Wc),
        (a.weekdaysMin = Zc),
        (a.defineLocale = _a),
        (a.updateLocale = ab),
        (a.locales = cb),
        (a.weekdaysShort = Yc),
        (a.normalizeUnits = K),
        (a.relativeTimeRounding = od),
        (a.relativeTimeThreshold = pd),
        (a.calendarFormat = Yb),
        (a.prototype = bf),
        a
    );
});

/*
Bootstrap Notify
*/
!(function (t) {
    "function" == typeof define && define.amd
        ? define(["jquery"], t)
        : t("object" == typeof exports ? require("jquery") : jQuery);
})(function (t) {
    function s(s) {
        var e = !1;
        return (
            t('[data-notify="container"]').each(function (i, n) {
                var a = t(n),
                    o = a.find('[data-notify="title"]').text().trim(),
                    r = a.find('[data-notify="message"]').html().trim(),
                    l =
                        o ===
                        t("<div>" + s.settings.content.title + "</div>")
                            .html()
                            .trim(),
                    d =
                        r ===
                        t("<div>" + s.settings.content.message + "</div>")
                            .html()
                            .trim(),
                    g = a.hasClass("alert-" + s.settings.type);
                return l && d && g && (e = !0), !e;
            }),
            e
        );
    }
    function e(e, n, a) {
        var o = {
            content: {
                message: "object" == typeof n ? n.message : n,
                title: n.title ? n.title : "",
                icon: n.icon ? n.icon : "",
                url: n.url ? n.url : "#",
                target: n.target ? n.target : "-",
            },
        };
        (a = t.extend(!0, {}, o, a)),
            (this.settings = t.extend(!0, {}, i, a)),
            (this._defaults = i),
            "-" === this.settings.content.target &&
                (this.settings.content.target = this.settings.url_target),
            (this.animations = {
                start: "webkitAnimationStart oanimationstart MSAnimationStart animationstart",
                end: "webkitAnimationEnd oanimationend MSAnimationEnd animationend",
            }),
            "number" == typeof this.settings.offset &&
                (this.settings.offset = {
                    x: this.settings.offset,
                    y: this.settings.offset,
                }),
            (this.settings.allow_duplicates ||
                (!this.settings.allow_duplicates && !s(this))) &&
                this.init();
    }
    var i = {
        element: "body",
        position: null,
        type: "info",
        allow_dismiss: !0,
        allow_duplicates: !0,
        newest_on_top: !1,
        showProgressbar: !1,
        placement: { from: "top", align: "right" },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5e3,
        timer: 1e3,
        url_target: "_blank",
        mouse_over: null,
        animate: { enter: "animated fadeInDown", exit: "animated fadeOutUp" },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: "class",
        template:
            '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>',
    };
    (String.format = function () {
        for (var t = arguments[0], s = 1; s < arguments.length; s++)
            t = t.replace(RegExp("\\{" + (s - 1) + "\\}", "gm"), arguments[s]);
        return t;
    }),
        t.extend(e.prototype, {
            init: function () {
                var t = this;
                this.buildNotify(),
                    this.settings.content.icon && this.setIcon(),
                    "#" != this.settings.content.url && this.styleURL(),
                    this.styleDismiss(),
                    this.placement(),
                    this.bind(),
                    (this.notify = {
                        $ele: this.$ele,
                        update: function (s, e) {
                            var i = {};
                            "string" == typeof s ? (i[s] = e) : (i = s);
                            for (var n in i)
                                switch (n) {
                                    case "type":
                                        this.$ele.removeClass(
                                            "alert-" + t.settings.type
                                        ),
                                            this.$ele
                                                .find(
                                                    '[data-notify="progressbar"] > .progress-bar'
                                                )
                                                .removeClass(
                                                    "progress-bar-" +
                                                        t.settings.type
                                                ),
                                            (t.settings.type = i[n]),
                                            this.$ele
                                                .addClass("alert-" + i[n])
                                                .find(
                                                    '[data-notify="progressbar"] > .progress-bar'
                                                )
                                                .addClass(
                                                    "progress-bar-" + i[n]
                                                );
                                        break;
                                    case "icon":
                                        var a = this.$ele.find(
                                            '[data-notify="icon"]'
                                        );
                                        "class" ===
                                        t.settings.icon_type.toLowerCase()
                                            ? a
                                                  .removeClass(
                                                      t.settings.content.icon
                                                  )
                                                  .addClass(i[n])
                                            : (a.is("img") || a.find("img"),
                                              a.attr("src", i[n]));
                                        break;
                                    case "progress":
                                        var o =
                                            t.settings.delay -
                                            t.settings.delay * (i[n] / 100);
                                        this.$ele.data("notify-delay", o),
                                            this.$ele
                                                .find(
                                                    '[data-notify="progressbar"] > div'
                                                )
                                                .attr("aria-valuenow", i[n])
                                                .css("width", i[n] + "%");
                                        break;
                                    case "url":
                                        this.$ele
                                            .find('[data-notify="url"]')
                                            .attr("href", i[n]);
                                        break;
                                    case "target":
                                        this.$ele
                                            .find('[data-notify="url"]')
                                            .attr("target", i[n]);
                                        break;
                                    default:
                                        this.$ele
                                            .find('[data-notify="' + n + '"]')
                                            .html(i[n]);
                                }
                            var r =
                                this.$ele.outerHeight() +
                                parseInt(t.settings.spacing) +
                                parseInt(t.settings.offset.y);
                            t.reposition(r);
                        },
                        close: function () {
                            t.close();
                        },
                    });
            },
            buildNotify: function () {
                var s = this.settings.content;
                (this.$ele = t(
                    String.format(
                        this.settings.template,
                        this.settings.type,
                        s.title,
                        s.message,
                        s.url,
                        s.target
                    )
                )),
                    this.$ele.attr(
                        "data-notify-position",
                        this.settings.placement.from +
                            "-" +
                            this.settings.placement.align
                    ),
                    this.settings.allow_dismiss ||
                        this.$ele
                            .find('[data-notify="dismiss"]')
                            .css("display", "none"),
                    ((this.settings.delay <= 0 &&
                        !this.settings.showProgressbar) ||
                        !this.settings.showProgressbar) &&
                        this.$ele.find('[data-notify="progressbar"]').remove();
            },
            setIcon: function () {
                "class" === this.settings.icon_type.toLowerCase()
                    ? this.$ele
                          .find('[data-notify="icon"]')
                          .addClass(this.settings.content.icon)
                    : this.$ele.find('[data-notify="icon"]').is("img")
                    ? this.$ele
                          .find('[data-notify="icon"]')
                          .attr("src", this.settings.content.icon)
                    : this.$ele
                          .find('[data-notify="icon"]')
                          .append(
                              '<img src="' +
                                  this.settings.content.icon +
                                  '" alt="Notify Icon" />'
                          );
            },
            styleDismiss: function () {
                this.$ele.find('[data-notify="dismiss"]').css({
                    position: "absolute",
                    right: "10px",
                    top: "5px",
                    zIndex: this.settings.z_index + 2,
                });
            },
            styleURL: function () {
                this.$ele.find('[data-notify="url"]').css({
                    backgroundImage:
                        "url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)",
                    height: "100%",
                    left: 0,
                    position: "absolute",
                    top: 0,
                    width: "100%",
                    zIndex: this.settings.z_index + 1,
                });
            },
            placement: function () {
                var s = this,
                    e = this.settings.offset.y,
                    i = {
                        display: "inline-block",
                        margin: "0px auto",
                        position: this.settings.position
                            ? this.settings.position
                            : "body" === this.settings.element
                            ? "fixed"
                            : "absolute",
                        transition: "all .5s ease-in-out",
                        zIndex: this.settings.z_index,
                    },
                    n = !1,
                    a = this.settings;
                switch (
                    (t(
                        '[data-notify-position="' +
                            this.settings.placement.from +
                            "-" +
                            this.settings.placement.align +
                            '"]:not([data-closing="true"])'
                    ).each(function () {
                        e = Math.max(
                            e,
                            parseInt(t(this).css(a.placement.from)) +
                                parseInt(t(this).outerHeight()) +
                                parseInt(a.spacing)
                        );
                    }),
                    this.settings.newest_on_top === !0 &&
                        (e = this.settings.offset.y),
                    (i[this.settings.placement.from] = e + "px"),
                    this.settings.placement.align)
                ) {
                    case "left":
                    case "right":
                        i[this.settings.placement.align] =
                            this.settings.offset.x + "px";
                        break;
                    case "center":
                        (i.left = 0), (i.right = 0);
                }
                this.$ele.css(i).addClass(this.settings.animate.enter),
                    t.each(
                        Array("webkit-", "moz-", "o-", "ms-", ""),
                        function (t, e) {
                            s.$ele[0].style[e + "AnimationIterationCount"] = 1;
                        }
                    ),
                    t(this.settings.element).append(this.$ele),
                    this.settings.newest_on_top === !0 &&
                        ((e =
                            parseInt(e) +
                            parseInt(this.settings.spacing) +
                            this.$ele.outerHeight()),
                        this.reposition(e)),
                    t.isFunction(s.settings.onShow) &&
                        s.settings.onShow.call(this.$ele),
                    this.$ele
                        .one(this.animations.start, function () {
                            n = !0;
                        })
                        .one(this.animations.end, function () {
                            s.$ele.removeClass(s.settings.animate.enter),
                                t.isFunction(s.settings.onShown) &&
                                    s.settings.onShown.call(this);
                        }),
                    setTimeout(function () {
                        n ||
                            (t.isFunction(s.settings.onShown) &&
                                s.settings.onShown.call(this));
                    }, 600);
            },
            bind: function () {
                var s = this;
                if (
                    (this.$ele
                        .find('[data-notify="dismiss"]')
                        .on("click", function () {
                            s.close();
                        }),
                    this.$ele
                        .mouseover(function () {
                            t(this).data("data-hover", "true");
                        })
                        .mouseout(function () {
                            t(this).data("data-hover", "false");
                        }),
                    this.$ele.data("data-hover", "false"),
                    this.settings.delay > 0)
                ) {
                    s.$ele.data("notify-delay", s.settings.delay);
                    var e = setInterval(function () {
                        var t =
                            parseInt(s.$ele.data("notify-delay")) -
                            s.settings.timer;
                        if (
                            ("false" === s.$ele.data("data-hover") &&
                                "pause" === s.settings.mouse_over) ||
                            "pause" != s.settings.mouse_over
                        ) {
                            var i =
                                ((s.settings.delay - t) / s.settings.delay) *
                                100;
                            s.$ele.data("notify-delay", t),
                                s.$ele
                                    .find('[data-notify="progressbar"] > div')
                                    .attr("aria-valuenow", i)
                                    .css("width", i + "%");
                        }
                        t <= -s.settings.timer && (clearInterval(e), s.close());
                    }, s.settings.timer);
                }
            },
            close: function () {
                var s = this,
                    e = parseInt(this.$ele.css(this.settings.placement.from)),
                    i = !1;
                this.$ele
                    .attr("data-closing", "true")
                    .addClass(this.settings.animate.exit),
                    s.reposition(e),
                    t.isFunction(s.settings.onClose) &&
                        s.settings.onClose.call(this.$ele),
                    this.$ele
                        .one(this.animations.start, function () {
                            i = !0;
                        })
                        .one(this.animations.end, function () {
                            t(this).remove(),
                                t.isFunction(s.settings.onClosed) &&
                                    s.settings.onClosed.call(this);
                        }),
                    setTimeout(function () {
                        i ||
                            (s.$ele.remove(),
                            s.settings.onClosed && s.settings.onClosed(s.$ele));
                    }, 600);
            },
            reposition: function (s) {
                var e = this,
                    i =
                        '[data-notify-position="' +
                        this.settings.placement.from +
                        "-" +
                        this.settings.placement.align +
                        '"]:not([data-closing="true"])',
                    n = this.$ele.nextAll(i);
                this.settings.newest_on_top === !0 &&
                    (n = this.$ele.prevAll(i)),
                    n.each(function () {
                        t(this).css(e.settings.placement.from, s),
                            (s =
                                parseInt(s) +
                                parseInt(e.settings.spacing) +
                                t(this).outerHeight());
                    });
            },
        }),
        (t.notify = function (t, s) {
            var i = new e(this, t, s);
            return i.notify;
        }),
        (t.notifyDefaults = function (s) {
            return (i = t.extend(!0, {}, i, s));
        }),
        (t.notifyClose = function (s) {
            "warning" === s && (s = "danger"),
                "undefined" == typeof s || "all" === s
                    ? t("[data-notify]")
                          .find('[data-notify="dismiss"]')
                          .trigger("click")
                    : "success" === s ||
                      "info" === s ||
                      "warning" === s ||
                      "danger" === s
                    ? t(".alert-" + s + "[data-notify]")
                          .find('[data-notify="dismiss"]')
                          .trigger("click")
                    : s
                    ? t(s + "[data-notify]")
                          .find('[data-notify="dismiss"]')
                          .trigger("click")
                    : t('[data-notify-position="' + s + '"]')
                          .find('[data-notify="dismiss"]')
                          .trigger("click");
        }),
        (t.notifyCloseExcept = function (s) {
            "warning" === s && (s = "danger"),
                "success" === s ||
                "info" === s ||
                "warning" === s ||
                "danger" === s
                    ? t("[data-notify]")
                          .not(".alert-" + s)
                          .find('[data-notify="dismiss"]')
                          .trigger("click")
                    : t("[data-notify]")
                          .not(s)
                          .find('[data-notify="dismiss"]')
                          .trigger("click");
        });
});

/*
   _ _      _       _
___| (_) ___| | __  (_)___
/ __| | |/ __| |/ /  | / __|
\__ \ | | (__|   < _ | \__ \
|___/_|_|\___|_|\_(_)/ |___/
                 |__/

Version: 1.9.0
Author: Ken Wheeler
Website: http://kenwheeler.github.io
  Docs: http://kenwheeler.github.io/slick
  Repo: http://github.com/kenwheeler/slick
Issues: http://github.com/kenwheeler/slick/issues

*/
(function (i) {
    "use strict";
    "function" == typeof define && define.amd
        ? define(["jquery"], i)
        : "undefined" != typeof exports
        ? (module.exports = i(require("jquery")))
        : i(jQuery);
})(function (i) {
    "use strict";
    var e = window.Slick || {};
    (e = (function () {
        function e(e, o) {
            var s,
                n = this;
            (n.defaults = {
                accessibility: !0,
                adaptiveHeight: !1,
                appendArrows: i(e),
                appendDots: i(e),
                arrows: !0,
                asNavFor: null,
                prevArrow:
                    '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                nextArrow:
                    '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                autoplay: !1,
                autoplaySpeed: 3e3,
                centerMode: !1,
                centerPadding: "50px",
                cssEase: "ease",
                customPaging: function (e, t) {
                    return i('<button type="button" />').text(t + 1);
                },
                dots: !1,
                dotsClass: "slick-dots",
                draggable: !0,
                easing: "linear",
                edgeFriction: 0.35,
                fade: !1,
                focusOnSelect: !1,
                focusOnChange: !1,
                infinite: !0,
                initialSlide: 0,
                lazyLoad: "ondemand",
                mobileFirst: !1,
                pauseOnHover: !0,
                pauseOnFocus: !0,
                pauseOnDotsHover: !1,
                respondTo: "window",
                responsive: null,
                rows: 1,
                rtl: !1,
                slide: "",
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: !0,
                swipeToSlide: !1,
                touchMove: !0,
                touchThreshold: 5,
                useCSS: !0,
                useTransform: !0,
                variableWidth: !1,
                vertical: !1,
                verticalSwiping: !1,
                waitForAnimate: !0,
                zIndex: 1e3,
            }),
                (n.initials = {
                    animating: !1,
                    dragging: !1,
                    autoPlayTimer: null,
                    currentDirection: 0,
                    currentLeft: null,
                    currentSlide: 0,
                    direction: 1,
                    $dots: null,
                    listWidth: null,
                    listHeight: null,
                    loadIndex: 0,
                    $nextArrow: null,
                    $prevArrow: null,
                    scrolling: !1,
                    slideCount: null,
                    slideWidth: null,
                    $slideTrack: null,
                    $slides: null,
                    sliding: !1,
                    slideOffset: 0,
                    swipeLeft: null,
                    swiping: !1,
                    $list: null,
                    touchObject: {},
                    transformsEnabled: !1,
                    unslicked: !1,
                }),
                i.extend(n, n.initials),
                (n.activeBreakpoint = null),
                (n.animType = null),
                (n.animProp = null),
                (n.breakpoints = []),
                (n.breakpointSettings = []),
                (n.cssTransitions = !1),
                (n.focussed = !1),
                (n.interrupted = !1),
                (n.hidden = "hidden"),
                (n.paused = !0),
                (n.positionProp = null),
                (n.respondTo = null),
                (n.rowCount = 1),
                (n.shouldClick = !0),
                (n.$slider = i(e)),
                (n.$slidesCache = null),
                (n.transformType = null),
                (n.transitionType = null),
                (n.visibilityChange = "visibilitychange"),
                (n.windowWidth = 0),
                (n.windowTimer = null),
                (s = i(e).data("slick") || {}),
                (n.options = i.extend({}, n.defaults, o, s)),
                (n.currentSlide = n.options.initialSlide),
                (n.originalSettings = n.options),
                "undefined" != typeof document.mozHidden
                    ? ((n.hidden = "mozHidden"),
                      (n.visibilityChange = "mozvisibilitychange"))
                    : "undefined" != typeof document.webkitHidden &&
                      ((n.hidden = "webkitHidden"),
                      (n.visibilityChange = "webkitvisibilitychange")),
                (n.autoPlay = i.proxy(n.autoPlay, n)),
                (n.autoPlayClear = i.proxy(n.autoPlayClear, n)),
                (n.autoPlayIterator = i.proxy(n.autoPlayIterator, n)),
                (n.changeSlide = i.proxy(n.changeSlide, n)),
                (n.clickHandler = i.proxy(n.clickHandler, n)),
                (n.selectHandler = i.proxy(n.selectHandler, n)),
                (n.setPosition = i.proxy(n.setPosition, n)),
                (n.swipeHandler = i.proxy(n.swipeHandler, n)),
                (n.dragHandler = i.proxy(n.dragHandler, n)),
                (n.keyHandler = i.proxy(n.keyHandler, n)),
                (n.instanceUid = t++),
                (n.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/),
                n.registerBreakpoints(),
                n.init(!0);
        }
        var t = 0;
        return e;
    })()),
        (e.prototype.activateADA = function () {
            var i = this;
            i.$slideTrack
                .find(".slick-active")
                .attr({ "aria-hidden": "false" })
                .find("a, input, button, select")
                .attr({ tabindex: "0" });
        }),
        (e.prototype.addSlide = e.prototype.slickAdd =
            function (e, t, o) {
                var s = this;
                if ("boolean" == typeof t) (o = t), (t = null);
                else if (t < 0 || t >= s.slideCount) return !1;
                s.unload(),
                    "number" == typeof t
                        ? 0 === t && 0 === s.$slides.length
                            ? i(e).appendTo(s.$slideTrack)
                            : o
                            ? i(e).insertBefore(s.$slides.eq(t))
                            : i(e).insertAfter(s.$slides.eq(t))
                        : o === !0
                        ? i(e).prependTo(s.$slideTrack)
                        : i(e).appendTo(s.$slideTrack),
                    (s.$slides = s.$slideTrack.children(this.options.slide)),
                    s.$slideTrack.children(this.options.slide).detach(),
                    s.$slideTrack.append(s.$slides),
                    s.$slides.each(function (e, t) {
                        i(t).attr("data-slick-index", e);
                    }),
                    (s.$slidesCache = s.$slides),
                    s.reinit();
            }),
        (e.prototype.animateHeight = function () {
            var i = this;
            if (
                1 === i.options.slidesToShow &&
                i.options.adaptiveHeight === !0 &&
                i.options.vertical === !1
            ) {
                var e = i.$slides.eq(i.currentSlide).outerHeight(!0);
                i.$list.animate({ height: e }, i.options.speed);
            }
        }),
        (e.prototype.animateSlide = function (e, t) {
            var o = {},
                s = this;
            s.animateHeight(),
                s.options.rtl === !0 && s.options.vertical === !1 && (e = -e),
                s.transformsEnabled === !1
                    ? s.options.vertical === !1
                        ? s.$slideTrack.animate(
                              { left: e },
                              s.options.speed,
                              s.options.easing,
                              t
                          )
                        : s.$slideTrack.animate(
                              { top: e },
                              s.options.speed,
                              s.options.easing,
                              t
                          )
                    : s.cssTransitions === !1
                    ? (s.options.rtl === !0 && (s.currentLeft = -s.currentLeft),
                      i({ animStart: s.currentLeft }).animate(
                          { animStart: e },
                          {
                              duration: s.options.speed,
                              easing: s.options.easing,
                              step: function (i) {
                                  (i = Math.ceil(i)),
                                      s.options.vertical === !1
                                          ? ((o[s.animType] =
                                                "translate(" + i + "px, 0px)"),
                                            s.$slideTrack.css(o))
                                          : ((o[s.animType] =
                                                "translate(0px," + i + "px)"),
                                            s.$slideTrack.css(o));
                              },
                              complete: function () {
                                  t && t.call();
                              },
                          }
                      ))
                    : (s.applyTransition(),
                      (e = Math.ceil(e)),
                      s.options.vertical === !1
                          ? (o[s.animType] =
                                "translate3d(" + e + "px, 0px, 0px)")
                          : (o[s.animType] =
                                "translate3d(0px," + e + "px, 0px)"),
                      s.$slideTrack.css(o),
                      t &&
                          setTimeout(function () {
                              s.disableTransition(), t.call();
                          }, s.options.speed));
        }),
        (e.prototype.getNavTarget = function () {
            var e = this,
                t = e.options.asNavFor;
            return t && null !== t && (t = i(t).not(e.$slider)), t;
        }),
        (e.prototype.asNavFor = function (e) {
            var t = this,
                o = t.getNavTarget();
            null !== o &&
                "object" == typeof o &&
                o.each(function () {
                    var t = i(this).slick("getSlick");
                    t.unslicked || t.slideHandler(e, !0);
                });
        }),
        (e.prototype.applyTransition = function (i) {
            var e = this,
                t = {};
            e.options.fade === !1
                ? (t[e.transitionType] =
                      e.transformType +
                      " " +
                      e.options.speed +
                      "ms " +
                      e.options.cssEase)
                : (t[e.transitionType] =
                      "opacity " + e.options.speed + "ms " + e.options.cssEase),
                e.options.fade === !1
                    ? e.$slideTrack.css(t)
                    : e.$slides.eq(i).css(t);
        }),
        (e.prototype.autoPlay = function () {
            var i = this;
            i.autoPlayClear(),
                i.slideCount > i.options.slidesToShow &&
                    (i.autoPlayTimer = setInterval(
                        i.autoPlayIterator,
                        i.options.autoplaySpeed
                    ));
        }),
        (e.prototype.autoPlayClear = function () {
            var i = this;
            i.autoPlayTimer && clearInterval(i.autoPlayTimer);
        }),
        (e.prototype.autoPlayIterator = function () {
            var i = this,
                e = i.currentSlide + i.options.slidesToScroll;
            i.paused ||
                i.interrupted ||
                i.focussed ||
                (i.options.infinite === !1 &&
                    (1 === i.direction &&
                    i.currentSlide + 1 === i.slideCount - 1
                        ? (i.direction = 0)
                        : 0 === i.direction &&
                          ((e = i.currentSlide - i.options.slidesToScroll),
                          i.currentSlide - 1 === 0 && (i.direction = 1))),
                i.slideHandler(e));
        }),
        (e.prototype.buildArrows = function () {
            var e = this;
            e.options.arrows === !0 &&
                ((e.$prevArrow = i(e.options.prevArrow).addClass(
                    "slick-arrow"
                )),
                (e.$nextArrow = i(e.options.nextArrow).addClass("slick-arrow")),
                e.slideCount > e.options.slidesToShow
                    ? (e.$prevArrow
                          .removeClass("slick-hidden")
                          .removeAttr("aria-hidden tabindex"),
                      e.$nextArrow
                          .removeClass("slick-hidden")
                          .removeAttr("aria-hidden tabindex"),
                      e.htmlExpr.test(e.options.prevArrow) &&
                          e.$prevArrow.prependTo(e.options.appendArrows),
                      e.htmlExpr.test(e.options.nextArrow) &&
                          e.$nextArrow.appendTo(e.options.appendArrows),
                      e.options.infinite !== !0 &&
                          e.$prevArrow
                              .addClass("slick-disabled")
                              .attr("aria-disabled", "true"))
                    : e.$prevArrow
                          .add(e.$nextArrow)
                          .addClass("slick-hidden")
                          .attr({ "aria-disabled": "true", tabindex: "-1" }));
        }),
        (e.prototype.buildDots = function () {
            var e,
                t,
                o = this;
            if (
                o.options.dots === !0 &&
                o.slideCount > o.options.slidesToShow
            ) {
                for (
                    o.$slider.addClass("slick-dotted"),
                        t = i("<ul />").addClass(o.options.dotsClass),
                        e = 0;
                    e <= o.getDotCount();
                    e += 1
                )
                    t.append(
                        i("<li />").append(
                            o.options.customPaging.call(this, o, e)
                        )
                    );
                (o.$dots = t.appendTo(o.options.appendDots)),
                    o.$dots.find("li").first().addClass("slick-active");
            }
        }),
        (e.prototype.buildOut = function () {
            var e = this;
            (e.$slides = e.$slider
                .children(e.options.slide + ":not(.slick-cloned)")
                .addClass("slick-slide")),
                (e.slideCount = e.$slides.length),
                e.$slides.each(function (e, t) {
                    i(t)
                        .attr("data-slick-index", e)
                        .data("originalStyling", i(t).attr("style") || "");
                }),
                e.$slider.addClass("slick-slider"),
                (e.$slideTrack =
                    0 === e.slideCount
                        ? i('<div class="slick-track"/>').appendTo(e.$slider)
                        : e.$slides
                              .wrapAll('<div class="slick-track"/>')
                              .parent()),
                (e.$list = e.$slideTrack
                    .wrap('<div class="slick-list"/>')
                    .parent()),
                e.$slideTrack.css("opacity", 0),
                (e.options.centerMode !== !0 &&
                    e.options.swipeToSlide !== !0) ||
                    (e.options.slidesToScroll = 1),
                i("img[data-lazy]", e.$slider)
                    .not("[src]")
                    .addClass("slick-loading"),
                e.setupInfinite(),
                e.buildArrows(),
                e.buildDots(),
                e.updateDots(),
                e.setSlideClasses(
                    "number" == typeof e.currentSlide ? e.currentSlide : 0
                ),
                e.options.draggable === !0 && e.$list.addClass("draggable");
        }),
        (e.prototype.buildRows = function () {
            var i,
                e,
                t,
                o,
                s,
                n,
                r,
                l = this;
            if (
                ((o = document.createDocumentFragment()),
                (n = l.$slider.children()),
                l.options.rows > 0)
            ) {
                for (
                    r = l.options.slidesPerRow * l.options.rows,
                        s = Math.ceil(n.length / r),
                        i = 0;
                    i < s;
                    i++
                ) {
                    var d = document.createElement("div");
                    for (e = 0; e < l.options.rows; e++) {
                        var a = document.createElement("div");
                        for (t = 0; t < l.options.slidesPerRow; t++) {
                            var c = i * r + (e * l.options.slidesPerRow + t);
                            n.get(c) && a.appendChild(n.get(c));
                        }
                        d.appendChild(a);
                    }
                    o.appendChild(d);
                }
                l.$slider.empty().append(o),
                    l.$slider
                        .children()
                        .children()
                        .children()
                        .css({
                            width: 100 / l.options.slidesPerRow + "%",
                            display: "inline-block",
                        });
            }
        }),
        (e.prototype.checkResponsive = function (e, t) {
            var o,
                s,
                n,
                r = this,
                l = !1,
                d = r.$slider.width(),
                a = window.innerWidth || i(window).width();
            if (
                ("window" === r.respondTo
                    ? (n = a)
                    : "slider" === r.respondTo
                    ? (n = d)
                    : "min" === r.respondTo && (n = Math.min(a, d)),
                r.options.responsive &&
                    r.options.responsive.length &&
                    null !== r.options.responsive)
            ) {
                s = null;
                for (o in r.breakpoints)
                    r.breakpoints.hasOwnProperty(o) &&
                        (r.originalSettings.mobileFirst === !1
                            ? n < r.breakpoints[o] && (s = r.breakpoints[o])
                            : n > r.breakpoints[o] && (s = r.breakpoints[o]));
                null !== s
                    ? null !== r.activeBreakpoint
                        ? (s !== r.activeBreakpoint || t) &&
                          ((r.activeBreakpoint = s),
                          "unslick" === r.breakpointSettings[s]
                              ? r.unslick(s)
                              : ((r.options = i.extend(
                                    {},
                                    r.originalSettings,
                                    r.breakpointSettings[s]
                                )),
                                e === !0 &&
                                    (r.currentSlide = r.options.initialSlide),
                                r.refresh(e)),
                          (l = s))
                        : ((r.activeBreakpoint = s),
                          "unslick" === r.breakpointSettings[s]
                              ? r.unslick(s)
                              : ((r.options = i.extend(
                                    {},
                                    r.originalSettings,
                                    r.breakpointSettings[s]
                                )),
                                e === !0 &&
                                    (r.currentSlide = r.options.initialSlide),
                                r.refresh(e)),
                          (l = s))
                    : null !== r.activeBreakpoint &&
                      ((r.activeBreakpoint = null),
                      (r.options = r.originalSettings),
                      e === !0 && (r.currentSlide = r.options.initialSlide),
                      r.refresh(e),
                      (l = s)),
                    e || l === !1 || r.$slider.trigger("breakpoint", [r, l]);
            }
        }),
        (e.prototype.changeSlide = function (e, t) {
            var o,
                s,
                n,
                r = this,
                l = i(e.currentTarget);
            switch (
                (l.is("a") && e.preventDefault(),
                l.is("li") || (l = l.closest("li")),
                (n = r.slideCount % r.options.slidesToScroll !== 0),
                (o = n
                    ? 0
                    : (r.slideCount - r.currentSlide) %
                      r.options.slidesToScroll),
                e.data.message)
            ) {
                case "previous":
                    (s =
                        0 === o
                            ? r.options.slidesToScroll
                            : r.options.slidesToShow - o),
                        r.slideCount > r.options.slidesToShow &&
                            r.slideHandler(r.currentSlide - s, !1, t);
                    break;
                case "next":
                    (s = 0 === o ? r.options.slidesToScroll : o),
                        r.slideCount > r.options.slidesToShow &&
                            r.slideHandler(r.currentSlide + s, !1, t);
                    break;
                case "index":
                    var d =
                        0 === e.data.index
                            ? 0
                            : e.data.index ||
                              l.index() * r.options.slidesToScroll;
                    r.slideHandler(r.checkNavigable(d), !1, t),
                        l.children().trigger("focus");
                    break;
                default:
                    return;
            }
        }),
        (e.prototype.checkNavigable = function (i) {
            var e,
                t,
                o = this;
            if (((e = o.getNavigableIndexes()), (t = 0), i > e[e.length - 1]))
                i = e[e.length - 1];
            else
                for (var s in e) {
                    if (i < e[s]) {
                        i = t;
                        break;
                    }
                    t = e[s];
                }
            return i;
        }),
        (e.prototype.cleanUpEvents = function () {
            var e = this;
            e.options.dots &&
                null !== e.$dots &&
                (i("li", e.$dots)
                    .off("click.slick", e.changeSlide)
                    .off("mouseenter.slick", i.proxy(e.interrupt, e, !0))
                    .off("mouseleave.slick", i.proxy(e.interrupt, e, !1)),
                e.options.accessibility === !0 &&
                    e.$dots.off("keydown.slick", e.keyHandler)),
                e.$slider.off("focus.slick blur.slick"),
                e.options.arrows === !0 &&
                    e.slideCount > e.options.slidesToShow &&
                    (e.$prevArrow &&
                        e.$prevArrow.off("click.slick", e.changeSlide),
                    e.$nextArrow &&
                        e.$nextArrow.off("click.slick", e.changeSlide),
                    e.options.accessibility === !0 &&
                        (e.$prevArrow &&
                            e.$prevArrow.off("keydown.slick", e.keyHandler),
                        e.$nextArrow &&
                            e.$nextArrow.off("keydown.slick", e.keyHandler))),
                e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler),
                e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler),
                e.$list.off("touchend.slick mouseup.slick", e.swipeHandler),
                e.$list.off(
                    "touchcancel.slick mouseleave.slick",
                    e.swipeHandler
                ),
                e.$list.off("click.slick", e.clickHandler),
                i(document).off(e.visibilityChange, e.visibility),
                e.cleanUpSlideEvents(),
                e.options.accessibility === !0 &&
                    e.$list.off("keydown.slick", e.keyHandler),
                e.options.focusOnSelect === !0 &&
                    i(e.$slideTrack)
                        .children()
                        .off("click.slick", e.selectHandler),
                i(window).off(
                    "orientationchange.slick.slick-" + e.instanceUid,
                    e.orientationChange
                ),
                i(window).off("resize.slick.slick-" + e.instanceUid, e.resize),
                i("[draggable!=true]", e.$slideTrack).off(
                    "dragstart",
                    e.preventDefault
                ),
                i(window).off(
                    "load.slick.slick-" + e.instanceUid,
                    e.setPosition
                );
        }),
        (e.prototype.cleanUpSlideEvents = function () {
            var e = this;
            e.$list.off("mouseenter.slick", i.proxy(e.interrupt, e, !0)),
                e.$list.off("mouseleave.slick", i.proxy(e.interrupt, e, !1));
        }),
        (e.prototype.cleanUpRows = function () {
            var i,
                e = this;
            e.options.rows > 0 &&
                ((i = e.$slides.children().children()),
                i.removeAttr("style"),
                e.$slider.empty().append(i));
        }),
        (e.prototype.clickHandler = function (i) {
            var e = this;
            e.shouldClick === !1 &&
                (i.stopImmediatePropagation(),
                i.stopPropagation(),
                i.preventDefault());
        }),
        (e.prototype.destroy = function (e) {
            var t = this;
            t.autoPlayClear(),
                (t.touchObject = {}),
                t.cleanUpEvents(),
                i(".slick-cloned", t.$slider).detach(),
                t.$dots && t.$dots.remove(),
                t.$prevArrow &&
                    t.$prevArrow.length &&
                    (t.$prevArrow
                        .removeClass("slick-disabled slick-arrow slick-hidden")
                        .removeAttr("aria-hidden aria-disabled tabindex")
                        .css("display", ""),
                    t.htmlExpr.test(t.options.prevArrow) &&
                        t.$prevArrow.remove()),
                t.$nextArrow &&
                    t.$nextArrow.length &&
                    (t.$nextArrow
                        .removeClass("slick-disabled slick-arrow slick-hidden")
                        .removeAttr("aria-hidden aria-disabled tabindex")
                        .css("display", ""),
                    t.htmlExpr.test(t.options.nextArrow) &&
                        t.$nextArrow.remove()),
                t.$slides &&
                    (t.$slides
                        .removeClass(
                            "slick-slide slick-active slick-center slick-visible slick-current"
                        )
                        .removeAttr("aria-hidden")
                        .removeAttr("data-slick-index")
                        .each(function () {
                            i(this).attr(
                                "style",
                                i(this).data("originalStyling")
                            );
                        }),
                    t.$slideTrack.children(this.options.slide).detach(),
                    t.$slideTrack.detach(),
                    t.$list.detach(),
                    t.$slider.append(t.$slides)),
                t.cleanUpRows(),
                t.$slider.removeClass("slick-slider"),
                t.$slider.removeClass("slick-initialized"),
                t.$slider.removeClass("slick-dotted"),
                (t.unslicked = !0),
                e || t.$slider.trigger("destroy", [t]);
        }),
        (e.prototype.disableTransition = function (i) {
            var e = this,
                t = {};
            (t[e.transitionType] = ""),
                e.options.fade === !1
                    ? e.$slideTrack.css(t)
                    : e.$slides.eq(i).css(t);
        }),
        (e.prototype.fadeSlide = function (i, e) {
            var t = this;
            t.cssTransitions === !1
                ? (t.$slides.eq(i).css({ zIndex: t.options.zIndex }),
                  t.$slides
                      .eq(i)
                      .animate(
                          { opacity: 1 },
                          t.options.speed,
                          t.options.easing,
                          e
                      ))
                : (t.applyTransition(i),
                  t.$slides.eq(i).css({ opacity: 1, zIndex: t.options.zIndex }),
                  e &&
                      setTimeout(function () {
                          t.disableTransition(i), e.call();
                      }, t.options.speed));
        }),
        (e.prototype.fadeSlideOut = function (i) {
            var e = this;
            e.cssTransitions === !1
                ? e.$slides
                      .eq(i)
                      .animate(
                          { opacity: 0, zIndex: e.options.zIndex - 2 },
                          e.options.speed,
                          e.options.easing
                      )
                : (e.applyTransition(i),
                  e.$slides
                      .eq(i)
                      .css({ opacity: 0, zIndex: e.options.zIndex - 2 }));
        }),
        (e.prototype.filterSlides = e.prototype.slickFilter =
            function (i) {
                var e = this;
                null !== i &&
                    ((e.$slidesCache = e.$slides),
                    e.unload(),
                    e.$slideTrack.children(this.options.slide).detach(),
                    e.$slidesCache.filter(i).appendTo(e.$slideTrack),
                    e.reinit());
            }),
        (e.prototype.focusHandler = function () {
            var e = this;
            e.$slider
                .off("focus.slick blur.slick")
                .on("focus.slick", "*", function (t) {
                    var o = i(this);
                    setTimeout(function () {
                        e.options.pauseOnFocus &&
                            o.is(":focus") &&
                            ((e.focussed = !0), e.autoPlay());
                    }, 0);
                })
                .on("blur.slick", "*", function (t) {
                    i(this);
                    e.options.pauseOnFocus && ((e.focussed = !1), e.autoPlay());
                });
        }),
        (e.prototype.getCurrent = e.prototype.slickCurrentSlide =
            function () {
                var i = this;
                return i.currentSlide;
            }),
        (e.prototype.getDotCount = function () {
            var i = this,
                e = 0,
                t = 0,
                o = 0;
            if (i.options.infinite === !0)
                if (i.slideCount <= i.options.slidesToShow) ++o;
                else
                    for (; e < i.slideCount; )
                        ++o,
                            (e = t + i.options.slidesToScroll),
                            (t +=
                                i.options.slidesToScroll <=
                                i.options.slidesToShow
                                    ? i.options.slidesToScroll
                                    : i.options.slidesToShow);
            else if (i.options.centerMode === !0) o = i.slideCount;
            else if (i.options.asNavFor)
                for (; e < i.slideCount; )
                    ++o,
                        (e = t + i.options.slidesToScroll),
                        (t +=
                            i.options.slidesToScroll <= i.options.slidesToShow
                                ? i.options.slidesToScroll
                                : i.options.slidesToShow);
            else
                o =
                    1 +
                    Math.ceil(
                        (i.slideCount - i.options.slidesToShow) /
                            i.options.slidesToScroll
                    );
            return o - 1;
        }),
        (e.prototype.getLeft = function (i) {
            var e,
                t,
                o,
                s,
                n = this,
                r = 0;
            return (
                (n.slideOffset = 0),
                (t = n.$slides.first().outerHeight(!0)),
                n.options.infinite === !0
                    ? (n.slideCount > n.options.slidesToShow &&
                          ((n.slideOffset =
                              n.slideWidth * n.options.slidesToShow * -1),
                          (s = -1),
                          n.options.vertical === !0 &&
                              n.options.centerMode === !0 &&
                              (2 === n.options.slidesToShow
                                  ? (s = -1.5)
                                  : 1 === n.options.slidesToShow && (s = -2)),
                          (r = t * n.options.slidesToShow * s)),
                      n.slideCount % n.options.slidesToScroll !== 0 &&
                          i + n.options.slidesToScroll > n.slideCount &&
                          n.slideCount > n.options.slidesToShow &&
                          (i > n.slideCount
                              ? ((n.slideOffset =
                                    (n.options.slidesToShow -
                                        (i - n.slideCount)) *
                                    n.slideWidth *
                                    -1),
                                (r =
                                    (n.options.slidesToShow -
                                        (i - n.slideCount)) *
                                    t *
                                    -1))
                              : ((n.slideOffset =
                                    (n.slideCount % n.options.slidesToScroll) *
                                    n.slideWidth *
                                    -1),
                                (r =
                                    (n.slideCount % n.options.slidesToScroll) *
                                    t *
                                    -1))))
                    : i + n.options.slidesToShow > n.slideCount &&
                      ((n.slideOffset =
                          (i + n.options.slidesToShow - n.slideCount) *
                          n.slideWidth),
                      (r = (i + n.options.slidesToShow - n.slideCount) * t)),
                n.slideCount <= n.options.slidesToShow &&
                    ((n.slideOffset = 0), (r = 0)),
                n.options.centerMode === !0 &&
                n.slideCount <= n.options.slidesToShow
                    ? (n.slideOffset =
                          (n.slideWidth * Math.floor(n.options.slidesToShow)) /
                              2 -
                          (n.slideWidth * n.slideCount) / 2)
                    : n.options.centerMode === !0 && n.options.infinite === !0
                    ? (n.slideOffset +=
                          n.slideWidth *
                              Math.floor(n.options.slidesToShow / 2) -
                          n.slideWidth)
                    : n.options.centerMode === !0 &&
                      ((n.slideOffset = 0),
                      (n.slideOffset +=
                          n.slideWidth *
                          Math.floor(n.options.slidesToShow / 2))),
                (e =
                    n.options.vertical === !1
                        ? i * n.slideWidth * -1 + n.slideOffset
                        : i * t * -1 + r),
                n.options.variableWidth === !0 &&
                    ((o =
                        n.slideCount <= n.options.slidesToShow ||
                        n.options.infinite === !1
                            ? n.$slideTrack.children(".slick-slide").eq(i)
                            : n.$slideTrack
                                  .children(".slick-slide")
                                  .eq(i + n.options.slidesToShow)),
                    (e =
                        n.options.rtl === !0
                            ? o[0]
                                ? (n.$slideTrack.width() -
                                      o[0].offsetLeft -
                                      o.width()) *
                                  -1
                                : 0
                            : o[0]
                            ? o[0].offsetLeft * -1
                            : 0),
                    n.options.centerMode === !0 &&
                        ((o =
                            n.slideCount <= n.options.slidesToShow ||
                            n.options.infinite === !1
                                ? n.$slideTrack.children(".slick-slide").eq(i)
                                : n.$slideTrack
                                      .children(".slick-slide")
                                      .eq(i + n.options.slidesToShow + 1)),
                        (e =
                            n.options.rtl === !0
                                ? o[0]
                                    ? (n.$slideTrack.width() -
                                          o[0].offsetLeft -
                                          o.width()) *
                                      -1
                                    : 0
                                : o[0]
                                ? o[0].offsetLeft * -1
                                : 0),
                        (e += (n.$list.width() - o.outerWidth()) / 2))),
                e
            );
        }),
        (e.prototype.getOption = e.prototype.slickGetOption =
            function (i) {
                var e = this;
                return e.options[i];
            }),
        (e.prototype.getNavigableIndexes = function () {
            var i,
                e = this,
                t = 0,
                o = 0,
                s = [];
            for (
                e.options.infinite === !1
                    ? (i = e.slideCount)
                    : ((t = e.options.slidesToScroll * -1),
                      (o = e.options.slidesToScroll * -1),
                      (i = 2 * e.slideCount));
                t < i;

            )
                s.push(t),
                    (t = o + e.options.slidesToScroll),
                    (o +=
                        e.options.slidesToScroll <= e.options.slidesToShow
                            ? e.options.slidesToScroll
                            : e.options.slidesToShow);
            return s;
        }),
        (e.prototype.getSlick = function () {
            return this;
        }),
        (e.prototype.getSlideCount = function () {
            var e,
                t,
                o,
                s,
                n = this;
            return (
                (s =
                    n.options.centerMode === !0
                        ? Math.floor(n.$list.width() / 2)
                        : 0),
                (o = n.swipeLeft * -1 + s),
                n.options.swipeToSlide === !0
                    ? (n.$slideTrack.find(".slick-slide").each(function (e, s) {
                          var r, l, d;
                          if (
                              ((r = i(s).outerWidth()),
                              (l = s.offsetLeft),
                              n.options.centerMode !== !0 && (l += r / 2),
                              (d = l + r),
                              o < d)
                          )
                              return (t = s), !1;
                      }),
                      (e =
                          Math.abs(
                              i(t).attr("data-slick-index") - n.currentSlide
                          ) || 1))
                    : n.options.slidesToScroll
            );
        }),
        (e.prototype.goTo = e.prototype.slickGoTo =
            function (i, e) {
                var t = this;
                t.changeSlide(
                    { data: { message: "index", index: parseInt(i) } },
                    e
                );
            }),
        (e.prototype.init = function (e) {
            var t = this;
            i(t.$slider).hasClass("slick-initialized") ||
                (i(t.$slider).addClass("slick-initialized"),
                t.buildRows(),
                t.buildOut(),
                t.setProps(),
                t.startLoad(),
                t.loadSlider(),
                t.initializeEvents(),
                t.updateArrows(),
                t.updateDots(),
                t.checkResponsive(!0),
                t.focusHandler()),
                e && t.$slider.trigger("init", [t]),
                t.options.accessibility === !0 && t.initADA(),
                t.options.autoplay && ((t.paused = !1), t.autoPlay());
        }),
        (e.prototype.initADA = function () {
            var e = this,
                t = Math.ceil(e.slideCount / e.options.slidesToShow),
                o = e.getNavigableIndexes().filter(function (i) {
                    return i >= 0 && i < e.slideCount;
                });
            e.$slides
                .add(e.$slideTrack.find(".slick-cloned"))
                .attr({ "aria-hidden": "true", tabindex: "-1" })
                .find("a, input, button, select")
                .attr({ tabindex: "-1" }),
                null !== e.$dots &&
                    (e.$slides
                        .not(e.$slideTrack.find(".slick-cloned"))
                        .each(function (t) {
                            var s = o.indexOf(t);
                            if (
                                (i(this).attr({
                                    role: "tabpanel",
                                    id: "slick-slide" + e.instanceUid + t,
                                    tabindex: -1,
                                }),
                                s !== -1)
                            ) {
                                var n =
                                    "slick-slide-control" + e.instanceUid + s;
                                i("#" + n).length &&
                                    i(this).attr({ "aria-describedby": n });
                            }
                        }),
                    e.$dots
                        .attr("role", "tablist")
                        .find("li")
                        .each(function (s) {
                            var n = o[s];
                            i(this).attr({ role: "presentation" }),
                                i(this)
                                    .find("button")
                                    .first()
                                    .attr({
                                        role: "tab",
                                        id:
                                            "slick-slide-control" +
                                            e.instanceUid +
                                            s,
                                        "aria-controls":
                                            "slick-slide" + e.instanceUid + n,
                                        "aria-label": s + 1 + " of " + t,
                                        "aria-selected": null,
                                        tabindex: "-1",
                                    });
                        })
                        .eq(e.currentSlide)
                        .find("button")
                        .attr({ "aria-selected": "true", tabindex: "0" })
                        .end());
            for (
                var s = e.currentSlide, n = s + e.options.slidesToShow;
                s < n;
                s++
            )
                e.options.focusOnChange
                    ? e.$slides.eq(s).attr({ tabindex: "0" })
                    : e.$slides.eq(s).removeAttr("tabindex");
            e.activateADA();
        }),
        (e.prototype.initArrowEvents = function () {
            var i = this;
            i.options.arrows === !0 &&
                i.slideCount > i.options.slidesToShow &&
                (i.$prevArrow
                    .off("click.slick")
                    .on("click.slick", { message: "previous" }, i.changeSlide),
                i.$nextArrow
                    .off("click.slick")
                    .on("click.slick", { message: "next" }, i.changeSlide),
                i.options.accessibility === !0 &&
                    (i.$prevArrow.on("keydown.slick", i.keyHandler),
                    i.$nextArrow.on("keydown.slick", i.keyHandler)));
        }),
        (e.prototype.initDotEvents = function () {
            var e = this;
            e.options.dots === !0 &&
                e.slideCount > e.options.slidesToShow &&
                (i("li", e.$dots).on(
                    "click.slick",
                    { message: "index" },
                    e.changeSlide
                ),
                e.options.accessibility === !0 &&
                    e.$dots.on("keydown.slick", e.keyHandler)),
                e.options.dots === !0 &&
                    e.options.pauseOnDotsHover === !0 &&
                    e.slideCount > e.options.slidesToShow &&
                    i("li", e.$dots)
                        .on("mouseenter.slick", i.proxy(e.interrupt, e, !0))
                        .on("mouseleave.slick", i.proxy(e.interrupt, e, !1));
        }),
        (e.prototype.initSlideEvents = function () {
            var e = this;
            e.options.pauseOnHover &&
                (e.$list.on("mouseenter.slick", i.proxy(e.interrupt, e, !0)),
                e.$list.on("mouseleave.slick", i.proxy(e.interrupt, e, !1)));
        }),
        (e.prototype.initializeEvents = function () {
            var e = this;
            e.initArrowEvents(),
                e.initDotEvents(),
                e.initSlideEvents(),
                e.$list.on(
                    "touchstart.slick mousedown.slick",
                    { action: "start" },
                    e.swipeHandler
                ),
                e.$list.on(
                    "touchmove.slick mousemove.slick",
                    { action: "move" },
                    e.swipeHandler
                ),
                e.$list.on(
                    "touchend.slick mouseup.slick",
                    { action: "end" },
                    e.swipeHandler
                ),
                e.$list.on(
                    "touchcancel.slick mouseleave.slick",
                    { action: "end" },
                    e.swipeHandler
                ),
                e.$list.on("click.slick", e.clickHandler),
                i(document).on(e.visibilityChange, i.proxy(e.visibility, e)),
                e.options.accessibility === !0 &&
                    e.$list.on("keydown.slick", e.keyHandler),
                e.options.focusOnSelect === !0 &&
                    i(e.$slideTrack)
                        .children()
                        .on("click.slick", e.selectHandler),
                i(window).on(
                    "orientationchange.slick.slick-" + e.instanceUid,
                    i.proxy(e.orientationChange, e)
                ),
                i(window).on(
                    "resize.slick.slick-" + e.instanceUid,
                    i.proxy(e.resize, e)
                ),
                i("[draggable!=true]", e.$slideTrack).on(
                    "dragstart",
                    e.preventDefault
                ),
                i(window).on(
                    "load.slick.slick-" + e.instanceUid,
                    e.setPosition
                ),
                i(e.setPosition);
        }),
        (e.prototype.initUI = function () {
            var i = this;
            i.options.arrows === !0 &&
                i.slideCount > i.options.slidesToShow &&
                (i.$prevArrow.show(), i.$nextArrow.show()),
                i.options.dots === !0 &&
                    i.slideCount > i.options.slidesToShow &&
                    i.$dots.show();
        }),
        (e.prototype.keyHandler = function (i) {
            var e = this;
            i.target.tagName.match("TEXTAREA|INPUT|SELECT") ||
                (37 === i.keyCode && e.options.accessibility === !0
                    ? e.changeSlide({
                          data: {
                              message:
                                  e.options.rtl === !0 ? "next" : "previous",
                          },
                      })
                    : 39 === i.keyCode &&
                      e.options.accessibility === !0 &&
                      e.changeSlide({
                          data: {
                              message:
                                  e.options.rtl === !0 ? "previous" : "next",
                          },
                      }));
        }),
        (e.prototype.lazyLoad = function () {
            function e(e) {
                i("img[data-lazy]", e).each(function () {
                    var e = i(this),
                        t = i(this).attr("data-lazy"),
                        o = i(this).attr("data-srcset"),
                        s =
                            i(this).attr("data-sizes") ||
                            r.$slider.attr("data-sizes"),
                        n = document.createElement("img");
                    (n.onload = function () {
                        e.animate({ opacity: 0 }, 100, function () {
                            o && (e.attr("srcset", o), s && e.attr("sizes", s)),
                                e
                                    .attr("src", t)
                                    .animate({ opacity: 1 }, 200, function () {
                                        e.removeAttr(
                                            "data-lazy data-srcset data-sizes"
                                        ).removeClass("slick-loading");
                                    }),
                                r.$slider.trigger("lazyLoaded", [r, e, t]);
                        });
                    }),
                        (n.onerror = function () {
                            e
                                .removeAttr("data-lazy")
                                .removeClass("slick-loading")
                                .addClass("slick-lazyload-error"),
                                r.$slider.trigger("lazyLoadError", [r, e, t]);
                        }),
                        (n.src = t);
                });
            }
            var t,
                o,
                s,
                n,
                r = this;
            if (
                (r.options.centerMode === !0
                    ? r.options.infinite === !0
                        ? ((s =
                              r.currentSlide +
                              (r.options.slidesToShow / 2 + 1)),
                          (n = s + r.options.slidesToShow + 2))
                        : ((s = Math.max(
                              0,
                              r.currentSlide - (r.options.slidesToShow / 2 + 1)
                          )),
                          (n =
                              2 +
                              (r.options.slidesToShow / 2 + 1) +
                              r.currentSlide))
                    : ((s = r.options.infinite
                          ? r.options.slidesToShow + r.currentSlide
                          : r.currentSlide),
                      (n = Math.ceil(s + r.options.slidesToShow)),
                      r.options.fade === !0 &&
                          (s > 0 && s--, n <= r.slideCount && n++)),
                (t = r.$slider.find(".slick-slide").slice(s, n)),
                "anticipated" === r.options.lazyLoad)
            )
                for (
                    var l = s - 1,
                        d = n,
                        a = r.$slider.find(".slick-slide"),
                        c = 0;
                    c < r.options.slidesToScroll;
                    c++
                )
                    l < 0 && (l = r.slideCount - 1),
                        (t = t.add(a.eq(l))),
                        (t = t.add(a.eq(d))),
                        l--,
                        d++;
            e(t),
                r.slideCount <= r.options.slidesToShow
                    ? ((o = r.$slider.find(".slick-slide")), e(o))
                    : r.currentSlide >= r.slideCount - r.options.slidesToShow
                    ? ((o = r.$slider
                          .find(".slick-cloned")
                          .slice(0, r.options.slidesToShow)),
                      e(o))
                    : 0 === r.currentSlide &&
                      ((o = r.$slider
                          .find(".slick-cloned")
                          .slice(r.options.slidesToShow * -1)),
                      e(o));
        }),
        (e.prototype.loadSlider = function () {
            var i = this;
            i.setPosition(),
                i.$slideTrack.css({ opacity: 1 }),
                i.$slider.removeClass("slick-loading"),
                i.initUI(),
                "progressive" === i.options.lazyLoad && i.progressiveLazyLoad();
        }),
        (e.prototype.next = e.prototype.slickNext =
            function () {
                var i = this;
                i.changeSlide({ data: { message: "next" } });
            }),
        (e.prototype.orientationChange = function () {
            var i = this;
            i.checkResponsive(), i.setPosition();
        }),
        (e.prototype.pause = e.prototype.slickPause =
            function () {
                var i = this;
                i.autoPlayClear(), (i.paused = !0);
            }),
        (e.prototype.play = e.prototype.slickPlay =
            function () {
                var i = this;
                i.autoPlay(),
                    (i.options.autoplay = !0),
                    (i.paused = !1),
                    (i.focussed = !1),
                    (i.interrupted = !1);
            }),
        (e.prototype.postSlide = function (e) {
            var t = this;
            if (
                !t.unslicked &&
                (t.$slider.trigger("afterChange", [t, e]),
                (t.animating = !1),
                t.slideCount > t.options.slidesToShow && t.setPosition(),
                (t.swipeLeft = null),
                t.options.autoplay && t.autoPlay(),
                t.options.accessibility === !0 &&
                    (t.initADA(), t.options.focusOnChange))
            ) {
                var o = i(t.$slides.get(t.currentSlide));
                o.attr("tabindex", 0).focus();
            }
        }),
        (e.prototype.prev = e.prototype.slickPrev =
            function () {
                var i = this;
                i.changeSlide({ data: { message: "previous" } });
            }),
        (e.prototype.preventDefault = function (i) {
            i.preventDefault();
        }),
        (e.prototype.progressiveLazyLoad = function (e) {
            e = e || 1;
            var t,
                o,
                s,
                n,
                r,
                l = this,
                d = i("img[data-lazy]", l.$slider);
            d.length
                ? ((t = d.first()),
                  (o = t.attr("data-lazy")),
                  (s = t.attr("data-srcset")),
                  (n = t.attr("data-sizes") || l.$slider.attr("data-sizes")),
                  (r = document.createElement("img")),
                  (r.onload = function () {
                      s && (t.attr("srcset", s), n && t.attr("sizes", n)),
                          t
                              .attr("src", o)
                              .removeAttr("data-lazy data-srcset data-sizes")
                              .removeClass("slick-loading"),
                          l.options.adaptiveHeight === !0 && l.setPosition(),
                          l.$slider.trigger("lazyLoaded", [l, t, o]),
                          l.progressiveLazyLoad();
                  }),
                  (r.onerror = function () {
                      e < 3
                          ? setTimeout(function () {
                                l.progressiveLazyLoad(e + 1);
                            }, 500)
                          : (t
                                .removeAttr("data-lazy")
                                .removeClass("slick-loading")
                                .addClass("slick-lazyload-error"),
                            l.$slider.trigger("lazyLoadError", [l, t, o]),
                            l.progressiveLazyLoad());
                  }),
                  (r.src = o))
                : l.$slider.trigger("allImagesLoaded", [l]);
        }),
        (e.prototype.refresh = function (e) {
            var t,
                o,
                s = this;
            (o = s.slideCount - s.options.slidesToShow),
                !s.options.infinite &&
                    s.currentSlide > o &&
                    (s.currentSlide = o),
                s.slideCount <= s.options.slidesToShow && (s.currentSlide = 0),
                (t = s.currentSlide),
                s.destroy(!0),
                i.extend(s, s.initials, { currentSlide: t }),
                s.init(),
                e ||
                    s.changeSlide({ data: { message: "index", index: t } }, !1);
        }),
        (e.prototype.registerBreakpoints = function () {
            var e,
                t,
                o,
                s = this,
                n = s.options.responsive || null;
            if ("array" === i.type(n) && n.length) {
                s.respondTo = s.options.respondTo || "window";
                for (e in n)
                    if (((o = s.breakpoints.length - 1), n.hasOwnProperty(e))) {
                        for (t = n[e].breakpoint; o >= 0; )
                            s.breakpoints[o] &&
                                s.breakpoints[o] === t &&
                                s.breakpoints.splice(o, 1),
                                o--;
                        s.breakpoints.push(t),
                            (s.breakpointSettings[t] = n[e].settings);
                    }
                s.breakpoints.sort(function (i, e) {
                    return s.options.mobileFirst ? i - e : e - i;
                });
            }
        }),
        (e.prototype.reinit = function () {
            var e = this;
            (e.$slides = e.$slideTrack
                .children(e.options.slide)
                .addClass("slick-slide")),
                (e.slideCount = e.$slides.length),
                e.currentSlide >= e.slideCount &&
                    0 !== e.currentSlide &&
                    (e.currentSlide =
                        e.currentSlide - e.options.slidesToScroll),
                e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0),
                e.registerBreakpoints(),
                e.setProps(),
                e.setupInfinite(),
                e.buildArrows(),
                e.updateArrows(),
                e.initArrowEvents(),
                e.buildDots(),
                e.updateDots(),
                e.initDotEvents(),
                e.cleanUpSlideEvents(),
                e.initSlideEvents(),
                e.checkResponsive(!1, !0),
                e.options.focusOnSelect === !0 &&
                    i(e.$slideTrack)
                        .children()
                        .on("click.slick", e.selectHandler),
                e.setSlideClasses(
                    "number" == typeof e.currentSlide ? e.currentSlide : 0
                ),
                e.setPosition(),
                e.focusHandler(),
                (e.paused = !e.options.autoplay),
                e.autoPlay(),
                e.$slider.trigger("reInit", [e]);
        }),
        (e.prototype.resize = function () {
            var e = this;
            i(window).width() !== e.windowWidth &&
                (clearTimeout(e.windowDelay),
                (e.windowDelay = window.setTimeout(function () {
                    (e.windowWidth = i(window).width()),
                        e.checkResponsive(),
                        e.unslicked || e.setPosition();
                }, 50)));
        }),
        (e.prototype.removeSlide = e.prototype.slickRemove =
            function (i, e, t) {
                var o = this;
                return (
                    "boolean" == typeof i
                        ? ((e = i), (i = e === !0 ? 0 : o.slideCount - 1))
                        : (i = e === !0 ? --i : i),
                    !(o.slideCount < 1 || i < 0 || i > o.slideCount - 1) &&
                        (o.unload(),
                        t === !0
                            ? o.$slideTrack.children().remove()
                            : o.$slideTrack
                                  .children(this.options.slide)
                                  .eq(i)
                                  .remove(),
                        (o.$slides = o.$slideTrack.children(
                            this.options.slide
                        )),
                        o.$slideTrack.children(this.options.slide).detach(),
                        o.$slideTrack.append(o.$slides),
                        (o.$slidesCache = o.$slides),
                        void o.reinit())
                );
            }),
        (e.prototype.setCSS = function (i) {
            var e,
                t,
                o = this,
                s = {};
            o.options.rtl === !0 && (i = -i),
                (e = "left" == o.positionProp ? Math.ceil(i) + "px" : "0px"),
                (t = "top" == o.positionProp ? Math.ceil(i) + "px" : "0px"),
                (s[o.positionProp] = i),
                o.transformsEnabled === !1
                    ? o.$slideTrack.css(s)
                    : ((s = {}),
                      o.cssTransitions === !1
                          ? ((s[o.animType] =
                                "translate(" + e + ", " + t + ")"),
                            o.$slideTrack.css(s))
                          : ((s[o.animType] =
                                "translate3d(" + e + ", " + t + ", 0px)"),
                            o.$slideTrack.css(s)));
        }),
        (e.prototype.setDimensions = function () {
            var i = this;
            i.options.vertical === !1
                ? i.options.centerMode === !0 &&
                  i.$list.css({ padding: "0px " + i.options.centerPadding })
                : (i.$list.height(
                      i.$slides.first().outerHeight(!0) * i.options.slidesToShow
                  ),
                  i.options.centerMode === !0 &&
                      i.$list.css({
                          padding: i.options.centerPadding + " 0px",
                      })),
                (i.listWidth = i.$list.width()),
                (i.listHeight = i.$list.height()),
                i.options.vertical === !1 && i.options.variableWidth === !1
                    ? ((i.slideWidth = Math.ceil(
                          i.listWidth / i.options.slidesToShow
                      )),
                      i.$slideTrack.width(
                          Math.ceil(
                              i.slideWidth *
                                  i.$slideTrack.children(".slick-slide").length
                          )
                      ))
                    : i.options.variableWidth === !0
                    ? i.$slideTrack.width(5e3 * i.slideCount)
                    : ((i.slideWidth = Math.ceil(i.listWidth)),
                      i.$slideTrack.height(
                          Math.ceil(
                              i.$slides.first().outerHeight(!0) *
                                  i.$slideTrack.children(".slick-slide").length
                          )
                      ));
            var e =
                i.$slides.first().outerWidth(!0) - i.$slides.first().width();
            i.options.variableWidth === !1 &&
                i.$slideTrack.children(".slick-slide").width(i.slideWidth - e);
        }),
        (e.prototype.setFade = function () {
            var e,
                t = this;
            t.$slides.each(function (o, s) {
                (e = t.slideWidth * o * -1),
                    t.options.rtl === !0
                        ? i(s).css({
                              position: "relative",
                              right: e,
                              top: 0,
                              zIndex: t.options.zIndex - 2,
                              opacity: 0,
                          })
                        : i(s).css({
                              position: "relative",
                              left: e,
                              top: 0,
                              zIndex: t.options.zIndex - 2,
                              opacity: 0,
                          });
            }),
                t.$slides
                    .eq(t.currentSlide)
                    .css({ zIndex: t.options.zIndex - 1, opacity: 1 });
        }),
        (e.prototype.setHeight = function () {
            var i = this;
            if (
                1 === i.options.slidesToShow &&
                i.options.adaptiveHeight === !0 &&
                i.options.vertical === !1
            ) {
                var e = i.$slides.eq(i.currentSlide).outerHeight(!0);
                i.$list.css("height", e);
            }
        }),
        (e.prototype.setOption = e.prototype.slickSetOption =
            function () {
                var e,
                    t,
                    o,
                    s,
                    n,
                    r = this,
                    l = !1;
                if (
                    ("object" === i.type(arguments[0])
                        ? ((o = arguments[0]),
                          (l = arguments[1]),
                          (n = "multiple"))
                        : "string" === i.type(arguments[0]) &&
                          ((o = arguments[0]),
                          (s = arguments[1]),
                          (l = arguments[2]),
                          "responsive" === arguments[0] &&
                          "array" === i.type(arguments[1])
                              ? (n = "responsive")
                              : "undefined" != typeof arguments[1] &&
                                (n = "single")),
                    "single" === n)
                )
                    r.options[o] = s;
                else if ("multiple" === n)
                    i.each(o, function (i, e) {
                        r.options[i] = e;
                    });
                else if ("responsive" === n)
                    for (t in s)
                        if ("array" !== i.type(r.options.responsive))
                            r.options.responsive = [s[t]];
                        else {
                            for (e = r.options.responsive.length - 1; e >= 0; )
                                r.options.responsive[e].breakpoint ===
                                    s[t].breakpoint &&
                                    r.options.responsive.splice(e, 1),
                                    e--;
                            r.options.responsive.push(s[t]);
                        }
                l && (r.unload(), r.reinit());
            }),
        (e.prototype.setPosition = function () {
            var i = this;
            i.setDimensions(),
                i.setHeight(),
                i.options.fade === !1
                    ? i.setCSS(i.getLeft(i.currentSlide))
                    : i.setFade(),
                i.$slider.trigger("setPosition", [i]);
        }),
        (e.prototype.setProps = function () {
            var i = this,
                e = document.body.style;
            (i.positionProp = i.options.vertical === !0 ? "top" : "left"),
                "top" === i.positionProp
                    ? i.$slider.addClass("slick-vertical")
                    : i.$slider.removeClass("slick-vertical"),
                (void 0 === e.WebkitTransition &&
                    void 0 === e.MozTransition &&
                    void 0 === e.msTransition) ||
                    (i.options.useCSS === !0 && (i.cssTransitions = !0)),
                i.options.fade &&
                    ("number" == typeof i.options.zIndex
                        ? i.options.zIndex < 3 && (i.options.zIndex = 3)
                        : (i.options.zIndex = i.defaults.zIndex)),
                void 0 !== e.OTransform &&
                    ((i.animType = "OTransform"),
                    (i.transformType = "-o-transform"),
                    (i.transitionType = "OTransition"),
                    void 0 === e.perspectiveProperty &&
                        void 0 === e.webkitPerspective &&
                        (i.animType = !1)),
                void 0 !== e.MozTransform &&
                    ((i.animType = "MozTransform"),
                    (i.transformType = "-moz-transform"),
                    (i.transitionType = "MozTransition"),
                    void 0 === e.perspectiveProperty &&
                        void 0 === e.MozPerspective &&
                        (i.animType = !1)),
                void 0 !== e.webkitTransform &&
                    ((i.animType = "webkitTransform"),
                    (i.transformType = "-webkit-transform"),
                    (i.transitionType = "webkitTransition"),
                    void 0 === e.perspectiveProperty &&
                        void 0 === e.webkitPerspective &&
                        (i.animType = !1)),
                void 0 !== e.msTransform &&
                    ((i.animType = "msTransform"),
                    (i.transformType = "-ms-transform"),
                    (i.transitionType = "msTransition"),
                    void 0 === e.msTransform && (i.animType = !1)),
                void 0 !== e.transform &&
                    i.animType !== !1 &&
                    ((i.animType = "transform"),
                    (i.transformType = "transform"),
                    (i.transitionType = "transition")),
                (i.transformsEnabled =
                    i.options.useTransform &&
                    null !== i.animType &&
                    i.animType !== !1);
        }),
        (e.prototype.setSlideClasses = function (i) {
            var e,
                t,
                o,
                s,
                n = this;
            if (
                ((t = n.$slider
                    .find(".slick-slide")
                    .removeClass("slick-active slick-center slick-current")
                    .attr("aria-hidden", "true")),
                n.$slides.eq(i).addClass("slick-current"),
                n.options.centerMode === !0)
            ) {
                var r = n.options.slidesToShow % 2 === 0 ? 1 : 0;
                (e = Math.floor(n.options.slidesToShow / 2)),
                    n.options.infinite === !0 &&
                        (i >= e && i <= n.slideCount - 1 - e
                            ? n.$slides
                                  .slice(i - e + r, i + e + 1)
                                  .addClass("slick-active")
                                  .attr("aria-hidden", "false")
                            : ((o = n.options.slidesToShow + i),
                              t
                                  .slice(o - e + 1 + r, o + e + 2)
                                  .addClass("slick-active")
                                  .attr("aria-hidden", "false")),
                        0 === i
                            ? t
                                  .eq(t.length - 1 - n.options.slidesToShow)
                                  .addClass("slick-center")
                            : i === n.slideCount - 1 &&
                              t
                                  .eq(n.options.slidesToShow)
                                  .addClass("slick-center")),
                    n.$slides.eq(i).addClass("slick-center");
            } else
                i >= 0 && i <= n.slideCount - n.options.slidesToShow
                    ? n.$slides
                          .slice(i, i + n.options.slidesToShow)
                          .addClass("slick-active")
                          .attr("aria-hidden", "false")
                    : t.length <= n.options.slidesToShow
                    ? t.addClass("slick-active").attr("aria-hidden", "false")
                    : ((s = n.slideCount % n.options.slidesToShow),
                      (o =
                          n.options.infinite === !0
                              ? n.options.slidesToShow + i
                              : i),
                      n.options.slidesToShow == n.options.slidesToScroll &&
                      n.slideCount - i < n.options.slidesToShow
                          ? t
                                .slice(o - (n.options.slidesToShow - s), o + s)
                                .addClass("slick-active")
                                .attr("aria-hidden", "false")
                          : t
                                .slice(o, o + n.options.slidesToShow)
                                .addClass("slick-active")
                                .attr("aria-hidden", "false"));
            ("ondemand" !== n.options.lazyLoad &&
                "anticipated" !== n.options.lazyLoad) ||
                n.lazyLoad();
        }),
        (e.prototype.setupInfinite = function () {
            var e,
                t,
                o,
                s = this;
            if (
                (s.options.fade === !0 && (s.options.centerMode = !1),
                s.options.infinite === !0 &&
                    s.options.fade === !1 &&
                    ((t = null), s.slideCount > s.options.slidesToShow))
            ) {
                for (
                    o =
                        s.options.centerMode === !0
                            ? s.options.slidesToShow + 1
                            : s.options.slidesToShow,
                        e = s.slideCount;
                    e > s.slideCount - o;
                    e -= 1
                )
                    (t = e - 1),
                        i(s.$slides[t])
                            .clone(!0)
                            .attr("id", "")
                            .attr("data-slick-index", t - s.slideCount)
                            .prependTo(s.$slideTrack)
                            .addClass("slick-cloned");
                for (e = 0; e < o + s.slideCount; e += 1)
                    (t = e),
                        i(s.$slides[t])
                            .clone(!0)
                            .attr("id", "")
                            .attr("data-slick-index", t + s.slideCount)
                            .appendTo(s.$slideTrack)
                            .addClass("slick-cloned");
                s.$slideTrack
                    .find(".slick-cloned")
                    .find("[id]")
                    .each(function () {
                        i(this).attr("id", "");
                    });
            }
        }),
        (e.prototype.interrupt = function (i) {
            var e = this;
            i || e.autoPlay(), (e.interrupted = i);
        }),
        (e.prototype.selectHandler = function (e) {
            var t = this,
                o = i(e.target).is(".slick-slide")
                    ? i(e.target)
                    : i(e.target).parents(".slick-slide"),
                s = parseInt(o.attr("data-slick-index"));
            return (
                s || (s = 0),
                t.slideCount <= t.options.slidesToShow
                    ? void t.slideHandler(s, !1, !0)
                    : void t.slideHandler(s)
            );
        }),
        (e.prototype.slideHandler = function (i, e, t) {
            var o,
                s,
                n,
                r,
                l,
                d = null,
                a = this;
            if (
                ((e = e || !1),
                !(
                    (a.animating === !0 && a.options.waitForAnimate === !0) ||
                    (a.options.fade === !0 && a.currentSlide === i)
                ))
            )
                return (
                    e === !1 && a.asNavFor(i),
                    (o = i),
                    (d = a.getLeft(o)),
                    (r = a.getLeft(a.currentSlide)),
                    (a.currentLeft = null === a.swipeLeft ? r : a.swipeLeft),
                    a.options.infinite === !1 &&
                    a.options.centerMode === !1 &&
                    (i < 0 || i > a.getDotCount() * a.options.slidesToScroll)
                        ? void (
                              a.options.fade === !1 &&
                              ((o = a.currentSlide),
                              t !== !0 && a.slideCount > a.options.slidesToShow
                                  ? a.animateSlide(r, function () {
                                        a.postSlide(o);
                                    })
                                  : a.postSlide(o))
                          )
                        : a.options.infinite === !1 &&
                          a.options.centerMode === !0 &&
                          (i < 0 || i > a.slideCount - a.options.slidesToScroll)
                        ? void (
                              a.options.fade === !1 &&
                              ((o = a.currentSlide),
                              t !== !0 && a.slideCount > a.options.slidesToShow
                                  ? a.animateSlide(r, function () {
                                        a.postSlide(o);
                                    })
                                  : a.postSlide(o))
                          )
                        : (a.options.autoplay && clearInterval(a.autoPlayTimer),
                          (s =
                              o < 0
                                  ? a.slideCount % a.options.slidesToScroll !==
                                    0
                                      ? a.slideCount -
                                        (a.slideCount %
                                            a.options.slidesToScroll)
                                      : a.slideCount + o
                                  : o >= a.slideCount
                                  ? a.slideCount % a.options.slidesToScroll !==
                                    0
                                      ? 0
                                      : o - a.slideCount
                                  : o),
                          (a.animating = !0),
                          a.$slider.trigger("beforeChange", [
                              a,
                              a.currentSlide,
                              s,
                          ]),
                          (n = a.currentSlide),
                          (a.currentSlide = s),
                          a.setSlideClasses(a.currentSlide),
                          a.options.asNavFor &&
                              ((l = a.getNavTarget()),
                              (l = l.slick("getSlick")),
                              l.slideCount <= l.options.slidesToShow &&
                                  l.setSlideClasses(a.currentSlide)),
                          a.updateDots(),
                          a.updateArrows(),
                          a.options.fade === !0
                              ? (t !== !0
                                    ? (a.fadeSlideOut(n),
                                      a.fadeSlide(s, function () {
                                          a.postSlide(s);
                                      }))
                                    : a.postSlide(s),
                                void a.animateHeight())
                              : void (t !== !0 &&
                                a.slideCount > a.options.slidesToShow
                                    ? a.animateSlide(d, function () {
                                          a.postSlide(s);
                                      })
                                    : a.postSlide(s)))
                );
        }),
        (e.prototype.startLoad = function () {
            var i = this;
            i.options.arrows === !0 &&
                i.slideCount > i.options.slidesToShow &&
                (i.$prevArrow.hide(), i.$nextArrow.hide()),
                i.options.dots === !0 &&
                    i.slideCount > i.options.slidesToShow &&
                    i.$dots.hide(),
                i.$slider.addClass("slick-loading");
        }),
        (e.prototype.swipeDirection = function () {
            var i,
                e,
                t,
                o,
                s = this;
            return (
                (i = s.touchObject.startX - s.touchObject.curX),
                (e = s.touchObject.startY - s.touchObject.curY),
                (t = Math.atan2(e, i)),
                (o = Math.round((180 * t) / Math.PI)),
                o < 0 && (o = 360 - Math.abs(o)),
                o <= 45 && o >= 0
                    ? s.options.rtl === !1
                        ? "left"
                        : "right"
                    : o <= 360 && o >= 315
                    ? s.options.rtl === !1
                        ? "left"
                        : "right"
                    : o >= 135 && o <= 225
                    ? s.options.rtl === !1
                        ? "right"
                        : "left"
                    : s.options.verticalSwiping === !0
                    ? o >= 35 && o <= 135
                        ? "down"
                        : "up"
                    : "vertical"
            );
        }),
        (e.prototype.swipeEnd = function (i) {
            var e,
                t,
                o = this;
            if (((o.dragging = !1), (o.swiping = !1), o.scrolling))
                return (o.scrolling = !1), !1;
            if (
                ((o.interrupted = !1),
                (o.shouldClick = !(o.touchObject.swipeLength > 10)),
                void 0 === o.touchObject.curX)
            )
                return !1;
            if (
                (o.touchObject.edgeHit === !0 &&
                    o.$slider.trigger("edge", [o, o.swipeDirection()]),
                o.touchObject.swipeLength >= o.touchObject.minSwipe)
            ) {
                switch ((t = o.swipeDirection())) {
                    case "left":
                    case "down":
                        (e = o.options.swipeToSlide
                            ? o.checkNavigable(
                                  o.currentSlide + o.getSlideCount()
                              )
                            : o.currentSlide + o.getSlideCount()),
                            (o.currentDirection = 0);
                        break;
                    case "right":
                    case "up":
                        (e = o.options.swipeToSlide
                            ? o.checkNavigable(
                                  o.currentSlide - o.getSlideCount()
                              )
                            : o.currentSlide - o.getSlideCount()),
                            (o.currentDirection = 1);
                }
                "vertical" != t &&
                    (o.slideHandler(e),
                    (o.touchObject = {}),
                    o.$slider.trigger("swipe", [o, t]));
            } else
                o.touchObject.startX !== o.touchObject.curX &&
                    (o.slideHandler(o.currentSlide), (o.touchObject = {}));
        }),
        (e.prototype.swipeHandler = function (i) {
            var e = this;
            if (
                !(
                    e.options.swipe === !1 ||
                    ("ontouchend" in document && e.options.swipe === !1) ||
                    (e.options.draggable === !1 &&
                        i.type.indexOf("mouse") !== -1)
                )
            )
                switch (
                    ((e.touchObject.fingerCount =
                        i.originalEvent && void 0 !== i.originalEvent.touches
                            ? i.originalEvent.touches.length
                            : 1),
                    (e.touchObject.minSwipe =
                        e.listWidth / e.options.touchThreshold),
                    e.options.verticalSwiping === !0 &&
                        (e.touchObject.minSwipe =
                            e.listHeight / e.options.touchThreshold),
                    i.data.action)
                ) {
                    case "start":
                        e.swipeStart(i);
                        break;
                    case "move":
                        e.swipeMove(i);
                        break;
                    case "end":
                        e.swipeEnd(i);
                }
        }),
        (e.prototype.swipeMove = function (i) {
            var e,
                t,
                o,
                s,
                n,
                r,
                l = this;
            return (
                (n =
                    void 0 !== i.originalEvent
                        ? i.originalEvent.touches
                        : null),
                !(!l.dragging || l.scrolling || (n && 1 !== n.length)) &&
                    ((e = l.getLeft(l.currentSlide)),
                    (l.touchObject.curX =
                        void 0 !== n ? n[0].pageX : i.clientX),
                    (l.touchObject.curY =
                        void 0 !== n ? n[0].pageY : i.clientY),
                    (l.touchObject.swipeLength = Math.round(
                        Math.sqrt(
                            Math.pow(
                                l.touchObject.curX - l.touchObject.startX,
                                2
                            )
                        )
                    )),
                    (r = Math.round(
                        Math.sqrt(
                            Math.pow(
                                l.touchObject.curY - l.touchObject.startY,
                                2
                            )
                        )
                    )),
                    !l.options.verticalSwiping && !l.swiping && r > 4
                        ? ((l.scrolling = !0), !1)
                        : (l.options.verticalSwiping === !0 &&
                              (l.touchObject.swipeLength = r),
                          (t = l.swipeDirection()),
                          void 0 !== i.originalEvent &&
                              l.touchObject.swipeLength > 4 &&
                              ((l.swiping = !0), i.preventDefault()),
                          (s =
                              (l.options.rtl === !1 ? 1 : -1) *
                              (l.touchObject.curX > l.touchObject.startX
                                  ? 1
                                  : -1)),
                          l.options.verticalSwiping === !0 &&
                              (s =
                                  l.touchObject.curY > l.touchObject.startY
                                      ? 1
                                      : -1),
                          (o = l.touchObject.swipeLength),
                          (l.touchObject.edgeHit = !1),
                          l.options.infinite === !1 &&
                              ((0 === l.currentSlide && "right" === t) ||
                                  (l.currentSlide >= l.getDotCount() &&
                                      "left" === t)) &&
                              ((o =
                                  l.touchObject.swipeLength *
                                  l.options.edgeFriction),
                              (l.touchObject.edgeHit = !0)),
                          l.options.vertical === !1
                              ? (l.swipeLeft = e + o * s)
                              : (l.swipeLeft =
                                    e +
                                    o * (l.$list.height() / l.listWidth) * s),
                          l.options.verticalSwiping === !0 &&
                              (l.swipeLeft = e + o * s),
                          l.options.fade !== !0 &&
                              l.options.touchMove !== !1 &&
                              (l.animating === !0
                                  ? ((l.swipeLeft = null), !1)
                                  : void l.setCSS(l.swipeLeft))))
            );
        }),
        (e.prototype.swipeStart = function (i) {
            var e,
                t = this;
            return (
                (t.interrupted = !0),
                1 !== t.touchObject.fingerCount ||
                t.slideCount <= t.options.slidesToShow
                    ? ((t.touchObject = {}), !1)
                    : (void 0 !== i.originalEvent &&
                          void 0 !== i.originalEvent.touches &&
                          (e = i.originalEvent.touches[0]),
                      (t.touchObject.startX = t.touchObject.curX =
                          void 0 !== e ? e.pageX : i.clientX),
                      (t.touchObject.startY = t.touchObject.curY =
                          void 0 !== e ? e.pageY : i.clientY),
                      void (t.dragging = !0))
            );
        }),
        (e.prototype.unfilterSlides = e.prototype.slickUnfilter =
            function () {
                var i = this;
                null !== i.$slidesCache &&
                    (i.unload(),
                    i.$slideTrack.children(this.options.slide).detach(),
                    i.$slidesCache.appendTo(i.$slideTrack),
                    i.reinit());
            }),
        (e.prototype.unload = function () {
            var e = this;
            i(".slick-cloned", e.$slider).remove(),
                e.$dots && e.$dots.remove(),
                e.$prevArrow &&
                    e.htmlExpr.test(e.options.prevArrow) &&
                    e.$prevArrow.remove(),
                e.$nextArrow &&
                    e.htmlExpr.test(e.options.nextArrow) &&
                    e.$nextArrow.remove(),
                e.$slides
                    .removeClass(
                        "slick-slide slick-active slick-visible slick-current"
                    )
                    .attr("aria-hidden", "true")
                    .css("width", "");
        }),
        (e.prototype.unslick = function (i) {
            var e = this;
            e.$slider.trigger("unslick", [e, i]), e.destroy();
        }),
        (e.prototype.updateArrows = function () {
            var i,
                e = this;
            (i = Math.floor(e.options.slidesToShow / 2)),
                e.options.arrows === !0 &&
                    e.slideCount > e.options.slidesToShow &&
                    !e.options.infinite &&
                    (e.$prevArrow
                        .removeClass("slick-disabled")
                        .attr("aria-disabled", "false"),
                    e.$nextArrow
                        .removeClass("slick-disabled")
                        .attr("aria-disabled", "false"),
                    0 === e.currentSlide
                        ? (e.$prevArrow
                              .addClass("slick-disabled")
                              .attr("aria-disabled", "true"),
                          e.$nextArrow
                              .removeClass("slick-disabled")
                              .attr("aria-disabled", "false"))
                        : e.currentSlide >=
                              e.slideCount - e.options.slidesToShow &&
                          e.options.centerMode === !1
                        ? (e.$nextArrow
                              .addClass("slick-disabled")
                              .attr("aria-disabled", "true"),
                          e.$prevArrow
                              .removeClass("slick-disabled")
                              .attr("aria-disabled", "false"))
                        : e.currentSlide >= e.slideCount - 1 &&
                          e.options.centerMode === !0 &&
                          (e.$nextArrow
                              .addClass("slick-disabled")
                              .attr("aria-disabled", "true"),
                          e.$prevArrow
                              .removeClass("slick-disabled")
                              .attr("aria-disabled", "false")));
        }),
        (e.prototype.updateDots = function () {
            var i = this;
            null !== i.$dots &&
                (i.$dots.find("li").removeClass("slick-active").end(),
                i.$dots
                    .find("li")
                    .eq(Math.floor(i.currentSlide / i.options.slidesToScroll))
                    .addClass("slick-active"));
        }),
        (e.prototype.visibility = function () {
            var i = this;
            i.options.autoplay &&
                (document[i.hidden]
                    ? (i.interrupted = !0)
                    : (i.interrupted = !1));
        }),
        (i.fn.slick = function () {
            var i,
                t,
                o = this,
                s = arguments[0],
                n = Array.prototype.slice.call(arguments, 1),
                r = o.length;
            for (i = 0; i < r; i++)
                if (
                    ("object" == typeof s || "undefined" == typeof s
                        ? (o[i].slick = new e(o[i], s))
                        : (t = o[i].slick[s].apply(o[i].slick, n)),
                    "undefined" != typeof t)
                )
                    return t;
            return o;
        });
});

/*! lazysizes - v5.2.0 */
!(function (a, b) {
    var c = b(a, a.document, Date);
    (a.lazySizes = c),
        "object" == typeof module && module.exports && (module.exports = c);
})("undefined" != typeof window ? window : {}, function (a, b, c) {
    "use strict";
    var d, e;
    if (
        ((function () {
            var b,
                c = {
                    lazyClass: "lazyload",
                    loadedClass: "lazyloaded",
                    loadingClass: "lazyloading",
                    preloadClass: "lazypreload",
                    errorClass: "lazyerror",
                    autosizesClass: "lazyautosizes",
                    srcAttr: "data-src",
                    srcsetAttr: "data-srcset",
                    sizesAttr: "data-sizes",
                    minSize: 40,
                    customMedia: {},
                    init: !0,
                    expFactor: 1.5,
                    hFac: 0.8,
                    loadMode: 2,
                    loadHidden: !0,
                    ricTimeout: 0,
                    throttleDelay: 125,
                };
            e = a.lazySizesConfig || a.lazysizesConfig || {};
            for (b in c) b in e || (e[b] = c[b]);
        })(),
        !b || !b.getElementsByClassName)
    )
        return { init: function () {}, cfg: e, noSupport: !0 };
    var f = b.documentElement,
        g = a.HTMLPictureElement,
        h = "addEventListener",
        i = "getAttribute",
        j = a[h].bind(a),
        k = a.setTimeout,
        l = a.requestAnimationFrame || k,
        m = a.requestIdleCallback,
        n = /^picture$/i,
        o = ["load", "error", "lazyincluded", "_lazyloaded"],
        p = {},
        q = Array.prototype.forEach,
        r = function (a, b) {
            return (
                p[b] || (p[b] = new RegExp("(\\s|^)" + b + "(\\s|$)")),
                p[b].test(a[i]("class") || "") && p[b]
            );
        },
        s = function (a, b) {
            r(a, b) ||
                a.setAttribute("class", (a[i]("class") || "").trim() + " " + b);
        },
        t = function (a, b) {
            var c;
            (c = r(a, b)) &&
                a.setAttribute("class", (a[i]("class") || "").replace(c, " "));
        },
        u = function (a, b, c) {
            var d = c ? h : "removeEventListener";
            c && u(a, b),
                o.forEach(function (c) {
                    a[d](c, b);
                });
        },
        v = function (a, c, e, f, g) {
            var h = b.createEvent("Event");
            return (
                e || (e = {}),
                (e.instance = d),
                h.initEvent(c, !f, !g),
                (h.detail = e),
                a.dispatchEvent(h),
                h
            );
        },
        w = function (b, c) {
            var d;
            !g && (d = a.picturefill || e.pf)
                ? (c &&
                      c.src &&
                      !b[i]("srcset") &&
                      b.setAttribute("srcset", c.src),
                  d({ reevaluate: !0, elements: [b] }))
                : c && c.src && (b.src = c.src);
        },
        x = function (a, b) {
            return (getComputedStyle(a, null) || {})[b];
        },
        y = function (a, b, c) {
            for (
                c = c || a.offsetWidth;
                c < e.minSize && b && !a._lazysizesWidth;

            )
                (c = b.offsetWidth), (b = b.parentNode);
            return c;
        },
        z = (function () {
            var a,
                c,
                d = [],
                e = [],
                f = d,
                g = function () {
                    var b = f;
                    for (f = d.length ? e : d, a = !0, c = !1; b.length; )
                        b.shift()();
                    a = !1;
                },
                h = function (d, e) {
                    a && !e
                        ? d.apply(this, arguments)
                        : (f.push(d), c || ((c = !0), (b.hidden ? k : l)(g)));
                };
            return (h._lsFlush = g), h;
        })(),
        A = function (a, b) {
            return b
                ? function () {
                      z(a);
                  }
                : function () {
                      var b = this,
                          c = arguments;
                      z(function () {
                          a.apply(b, c);
                      });
                  };
        },
        B = function (a) {
            var b,
                d = 0,
                f = e.throttleDelay,
                g = e.ricTimeout,
                h = function () {
                    (b = !1), (d = c.now()), a();
                },
                i =
                    m && g > 49
                        ? function () {
                              m(h, { timeout: g }),
                                  g !== e.ricTimeout && (g = e.ricTimeout);
                          }
                        : A(function () {
                              k(h);
                          }, !0);
            return function (a) {
                var e;
                (a = !0 === a) && (g = 33),
                    b ||
                        ((b = !0),
                        (e = f - (c.now() - d)),
                        e < 0 && (e = 0),
                        a || e < 9 ? i() : k(i, e));
            };
        },
        C = function (a) {
            var b,
                d,
                e = 99,
                f = function () {
                    (b = null), a();
                },
                g = function () {
                    var a = c.now() - d;
                    a < e ? k(g, e - a) : (m || f)(f);
                };
            return function () {
                (d = c.now()), b || (b = k(g, e));
            };
        },
        D = (function () {
            var g,
                m,
                o,
                p,
                y,
                D,
                F,
                G,
                H,
                I,
                J,
                K,
                L = /^img$/i,
                M = /^iframe$/i,
                N =
                    "onscroll" in a &&
                    !/(gle|ing)bot/.test(navigator.userAgent),
                O = 0,
                P = 0,
                Q = 0,
                R = -1,
                S = function (a) {
                    Q--, (!a || Q < 0 || !a.target) && (Q = 0);
                },
                T = function (a) {
                    return (
                        null == K && (K = "hidden" == x(b.body, "visibility")),
                        K ||
                            !(
                                "hidden" == x(a.parentNode, "visibility") &&
                                "hidden" == x(a, "visibility")
                            )
                    );
                },
                U = function (a, c) {
                    var d,
                        e = a,
                        g = T(a);
                    for (
                        G -= c, J += c, H -= c, I += c;
                        g && (e = e.offsetParent) && e != b.body && e != f;

                    )
                        (g = (x(e, "opacity") || 1) > 0) &&
                            "visible" != x(e, "overflow") &&
                            ((d = e.getBoundingClientRect()),
                            (g =
                                I > d.left &&
                                H < d.right &&
                                J > d.top - 1 &&
                                G < d.bottom + 1));
                    return g;
                },
                V = function () {
                    var a,
                        c,
                        h,
                        j,
                        k,
                        l,
                        n,
                        o,
                        q,
                        r,
                        s,
                        t,
                        u = d.elements;
                    if ((p = e.loadMode) && Q < 8 && (a = u.length)) {
                        for (c = 0, R++; c < a; c++)
                            if (u[c] && !u[c]._lazyRace)
                                if (
                                    !N ||
                                    (d.prematureUnveil &&
                                        d.prematureUnveil(u[c]))
                                )
                                    ba(u[c]);
                                else if (
                                    (((o = u[c][i]("data-expand")) &&
                                        (l = 1 * o)) ||
                                        (l = P),
                                    r ||
                                        ((r =
                                            !e.expand || e.expand < 1
                                                ? f.clientHeight > 500 &&
                                                  f.clientWidth > 500
                                                    ? 500
                                                    : 370
                                                : e.expand),
                                        (d._defEx = r),
                                        (s = r * e.expFactor),
                                        (t = e.hFac),
                                        (K = null),
                                        P < s &&
                                        Q < 1 &&
                                        R > 2 &&
                                        p > 2 &&
                                        !b.hidden
                                            ? ((P = s), (R = 0))
                                            : (P =
                                                  p > 1 && R > 1 && Q < 6
                                                      ? r
                                                      : O)),
                                    q !== l &&
                                        ((D = innerWidth + l * t),
                                        (F = innerHeight + l),
                                        (n = -1 * l),
                                        (q = l)),
                                    (h = u[c].getBoundingClientRect()),
                                    (J = h.bottom) >= n &&
                                        (G = h.top) <= F &&
                                        (I = h.right) >= n * t &&
                                        (H = h.left) <= D &&
                                        (J || I || H || G) &&
                                        (e.loadHidden || T(u[c])) &&
                                        ((m &&
                                            Q < 3 &&
                                            !o &&
                                            (p < 3 || R < 4)) ||
                                            U(u[c], l)))
                                ) {
                                    if ((ba(u[c]), (k = !0), Q > 9)) break;
                                } else
                                    !k &&
                                        m &&
                                        !j &&
                                        Q < 4 &&
                                        R < 4 &&
                                        p > 2 &&
                                        (g[0] || e.preloadAfterLoad) &&
                                        (g[0] ||
                                            (!o &&
                                                (J ||
                                                    I ||
                                                    H ||
                                                    G ||
                                                    "auto" !=
                                                        u[c][i](
                                                            e.sizesAttr
                                                        )))) &&
                                        (j = g[0] || u[c]);
                        j && !k && ba(j);
                    }
                },
                W = B(V),
                X = function (a) {
                    var b = a.target;
                    if (b._lazyCache) return void delete b._lazyCache;
                    S(a),
                        s(b, e.loadedClass),
                        t(b, e.loadingClass),
                        u(b, Z),
                        v(b, "lazyloaded");
                },
                Y = A(X),
                Z = function (a) {
                    Y({ target: a.target });
                },
                $ = function (a, b) {
                    try {
                        a.contentWindow.location.replace(b);
                    } catch (c) {
                        a.src = b;
                    }
                },
                _ = function (a) {
                    var b,
                        c = a[i](e.srcsetAttr);
                    (b = e.customMedia[a[i]("data-media") || a[i]("media")]) &&
                        a.setAttribute("media", b),
                        c && a.setAttribute("srcset", c);
                },
                aa = A(function (a, b, c, d, f) {
                    var g, h, j, l, m, p;
                    (m = v(a, "lazybeforeunveil", b)).defaultPrevented ||
                        (d &&
                            (c
                                ? s(a, e.autosizesClass)
                                : a.setAttribute("sizes", d)),
                        (h = a[i](e.srcsetAttr)),
                        (g = a[i](e.srcAttr)),
                        f &&
                            ((j = a.parentNode),
                            (l = j && n.test(j.nodeName || ""))),
                        (p = b.firesLoad || ("src" in a && (h || g || l))),
                        (m = { target: a }),
                        s(a, e.loadingClass),
                        p && (clearTimeout(o), (o = k(S, 2500)), u(a, Z, !0)),
                        l && q.call(j.getElementsByTagName("source"), _),
                        h
                            ? a.setAttribute("srcset", h)
                            : g &&
                              !l &&
                              (M.test(a.nodeName) ? $(a, g) : (a.src = g)),
                        f && (h || l) && w(a, { src: g })),
                        a._lazyRace && delete a._lazyRace,
                        t(a, e.lazyClass),
                        z(function () {
                            var b = a.complete && a.naturalWidth > 1;
                            (p && !b) ||
                                (b && s(a, "ls-is-cached"),
                                X(m),
                                (a._lazyCache = !0),
                                k(function () {
                                    "_lazyCache" in a && delete a._lazyCache;
                                }, 9)),
                                "lazy" == a.loading && Q--;
                        }, !0);
                }),
                ba = function (a) {
                    if (!a._lazyRace) {
                        var b,
                            c = L.test(a.nodeName),
                            d = c && (a[i](e.sizesAttr) || a[i]("sizes")),
                            f = "auto" == d;
                        ((!f && m) ||
                            !c ||
                            (!a[i]("src") && !a.srcset) ||
                            a.complete ||
                            r(a, e.errorClass) ||
                            !r(a, e.lazyClass)) &&
                            ((b = v(a, "lazyunveilread").detail),
                            f && E.updateElem(a, !0, a.offsetWidth),
                            (a._lazyRace = !0),
                            Q++,
                            aa(a, b, f, d, c));
                    }
                },
                ca = C(function () {
                    (e.loadMode = 3), W();
                }),
                da = function () {
                    3 == e.loadMode && (e.loadMode = 2), ca();
                },
                ea = function () {
                    if (!m) {
                        if (c.now() - y < 999) return void k(ea, 999);
                        (m = !0), (e.loadMode = 3), W(), j("scroll", da, !0);
                    }
                };
            return {
                _: function () {
                    (y = c.now()),
                        (d.elements = b.getElementsByClassName(e.lazyClass)),
                        (g = b.getElementsByClassName(
                            e.lazyClass + " " + e.preloadClass
                        )),
                        j("scroll", W, !0),
                        j("resize", W, !0),
                        j("pageshow", function (a) {
                            if (a.persisted) {
                                var c = b.querySelectorAll(
                                    "." + e.loadingClass
                                );
                                c.length &&
                                    c.forEach &&
                                    l(function () {
                                        c.forEach(function (a) {
                                            a.complete && ba(a);
                                        });
                                    });
                            }
                        }),
                        a.MutationObserver
                            ? new MutationObserver(W).observe(f, {
                                  childList: !0,
                                  subtree: !0,
                                  attributes: !0,
                              })
                            : (f[h]("DOMNodeInserted", W, !0),
                              f[h]("DOMAttrModified", W, !0),
                              setInterval(W, 999)),
                        j("hashchange", W, !0),
                        [
                            "focus",
                            "mouseover",
                            "click",
                            "load",
                            "transitionend",
                            "animationend",
                        ].forEach(function (a) {
                            b[h](a, W, !0);
                        }),
                        /d$|^c/.test(b.readyState)
                            ? ea()
                            : (j("load", ea),
                              b[h]("DOMContentLoaded", W),
                              k(ea, 2e4)),
                        d.elements.length ? (V(), z._lsFlush()) : W();
                },
                checkElems: W,
                unveil: ba,
                _aLSL: da,
            };
        })(),
        E = (function () {
            var a,
                c = A(function (a, b, c, d) {
                    var e, f, g;
                    if (
                        ((a._lazysizesWidth = d),
                        (d += "px"),
                        a.setAttribute("sizes", d),
                        n.test(b.nodeName || ""))
                    )
                        for (
                            e = b.getElementsByTagName("source"),
                                f = 0,
                                g = e.length;
                            f < g;
                            f++
                        )
                            e[f].setAttribute("sizes", d);
                    c.detail.dataAttr || w(a, c.detail);
                }),
                d = function (a, b, d) {
                    var e,
                        f = a.parentNode;
                    f &&
                        ((d = y(a, f, d)),
                        (e = v(a, "lazybeforesizes", {
                            width: d,
                            dataAttr: !!b,
                        })),
                        e.defaultPrevented ||
                            ((d = e.detail.width) &&
                                d !== a._lazysizesWidth &&
                                c(a, f, e, d)));
                },
                f = function () {
                    var b,
                        c = a.length;
                    if (c) for (b = 0; b < c; b++) d(a[b]);
                },
                g = C(f);
            return {
                _: function () {
                    (a = b.getElementsByClassName(e.autosizesClass)),
                        j("resize", g);
                },
                checkElems: g,
                updateElem: d,
            };
        })(),
        F = function () {
            !F.i && b.getElementsByClassName && ((F.i = !0), E._(), D._());
        };
    return (
        k(function () {
            e.init && F();
        }),
        (d = {
            cfg: e,
            autoSizer: E,
            loader: D,
            init: F,
            uP: w,
            aC: s,
            rC: t,
            hC: r,
            fire: v,
            gW: y,
            rAF: z,
        })
    );
});