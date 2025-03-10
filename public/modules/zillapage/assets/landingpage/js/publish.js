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
})("undefined" != typeof window ? window : this, function (e, t) {
    "use strict";
    var n = [],
        o = Object.getPrototypeOf,
        i = n.slice,
        r = n.flat
            ? function (e) {
                  return n.flat.call(e);
              }
            : function (e) {
                  return n.concat.apply([], e);
              },
        a = n.push,
        s = n.indexOf,
        l = {},
        c = l.toString,
        u = l.hasOwnProperty,
        d = u.toString,
        f = d.call(Object),
        p = {},
        h = function (e) {
            return "function" == typeof e && "number" != typeof e.nodeType;
        },
        m = function (e) {
            return null != e && e === e.window;
        },
        g = e.document,
        w = { type: !0, src: !0, nonce: !0, noModule: !0 };
    function v(e, t, n) {
        var o,
            i,
            r = (n = n || g).createElement("script");
        if (((r.text = e), t))
            for (o in w)
                (i = t[o] || (t.getAttribute && t.getAttribute(o))) &&
                    r.setAttribute(o, i);
        n.head.appendChild(r).parentNode.removeChild(r);
    }
    function b(e) {
        return null == e
            ? e + ""
            : "object" == typeof e || "function" == typeof e
            ? l[c.call(e)] || "object"
            : typeof e;
    }
    var y = "3.5.1",
        x = function (e, t) {
            return new x.fn.init(e, t);
        };
    function _(e) {
        var t = !!e && "length" in e && e.length,
            n = b(e);
        return (
            !h(e) &&
            !m(e) &&
            ("array" === n ||
                0 === t ||
                ("number" == typeof t && 0 < t && t - 1 in e))
        );
    }
    (x.fn = x.prototype =
        {
            jquery: y,
            constructor: x,
            length: 0,
            toArray: function () {
                return i.call(this);
            },
            get: function (e) {
                return null == e
                    ? i.call(this)
                    : e < 0
                    ? this[e + this.length]
                    : this[e];
            },
            pushStack: function (e) {
                var t = x.merge(this.constructor(), e);
                return (t.prevObject = this), t;
            },
            each: function (e) {
                return x.each(this, e);
            },
            map: function (e) {
                return this.pushStack(
                    x.map(this, function (t, n) {
                        return e.call(t, n, t);
                    })
                );
            },
            slice: function () {
                return this.pushStack(i.apply(this, arguments));
            },
            first: function () {
                return this.eq(0);
            },
            last: function () {
                return this.eq(-1);
            },
            even: function () {
                return this.pushStack(
                    x.grep(this, function (e, t) {
                        return (t + 1) % 2;
                    })
                );
            },
            odd: function () {
                return this.pushStack(
                    x.grep(this, function (e, t) {
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
            push: a,
            sort: n.sort,
            splice: n.splice,
        }),
        (x.extend = x.fn.extend =
            function () {
                var e,
                    t,
                    n,
                    o,
                    i,
                    r,
                    a = arguments[0] || {},
                    s = 1,
                    l = arguments.length,
                    c = !1;
                for (
                    "boolean" == typeof a &&
                        ((c = a), (a = arguments[s] || {}), s++),
                        "object" == typeof a || h(a) || (a = {}),
                        s === l && ((a = this), s--);
                    s < l;
                    s++
                )
                    if (null != (e = arguments[s]))
                        for (t in e)
                            (o = e[t]),
                                "__proto__" !== t &&
                                    a !== o &&
                                    (c &&
                                    o &&
                                    (x.isPlainObject(o) ||
                                        (i = Array.isArray(o)))
                                        ? ((n = a[t]),
                                          (r =
                                              i && !Array.isArray(n)
                                                  ? []
                                                  : i || x.isPlainObject(n)
                                                  ? n
                                                  : {}),
                                          (i = !1),
                                          (a[t] = x.extend(c, r, o)))
                                        : void 0 !== o && (a[t] = o));
                return a;
            }),
        x.extend({
            expando: "jQuery" + (y + Math.random()).replace(/\D/g, ""),
            isReady: !0,
            error: function (e) {
                throw new Error(e);
            },
            noop: function () {},
            isPlainObject: function (e) {
                var t, n;
                return !(
                    !e ||
                    "[object Object]" !== c.call(e) ||
                    ((t = o(e)) &&
                        ("function" !=
                            typeof (n =
                                u.call(t, "constructor") && t.constructor) ||
                            d.call(n) !== f))
                );
            },
            isEmptyObject: function (e) {
                var t;
                for (t in e) return !1;
                return !0;
            },
            globalEval: function (e, t, n) {
                v(e, { nonce: t && t.nonce }, n);
            },
            each: function (e, t) {
                var n,
                    o = 0;
                if (_(e))
                    for (
                        n = e.length;
                        o < n && !1 !== t.call(e[o], o, e[o]);
                        o++
                    );
                else for (o in e) if (!1 === t.call(e[o], o, e[o])) break;
                return e;
            },
            makeArray: function (e, t) {
                var n = t || [];
                return (
                    null != e &&
                        (_(Object(e))
                            ? x.merge(n, "string" == typeof e ? [e] : e)
                            : a.call(n, e)),
                    n
                );
            },
            inArray: function (e, t, n) {
                return null == t ? -1 : s.call(t, e, n);
            },
            merge: function (e, t) {
                for (var n = +t.length, o = 0, i = e.length; o < n; o++)
                    e[i++] = t[o];
                return (e.length = i), e;
            },
            grep: function (e, t, n) {
                for (var o = [], i = 0, r = e.length, a = !n; i < r; i++)
                    !t(e[i], i) !== a && o.push(e[i]);
                return o;
            },
            map: function (e, t, n) {
                var o,
                    i,
                    a = 0,
                    s = [];
                if (_(e))
                    for (o = e.length; a < o; a++)
                        null != (i = t(e[a], a, n)) && s.push(i);
                else for (a in e) null != (i = t(e[a], a, n)) && s.push(i);
                return r(s);
            },
            guid: 1,
            support: p,
        }),
        "function" == typeof Symbol &&
            (x.fn[Symbol.iterator] = n[Symbol.iterator]),
        x.each(
            "Boolean Number String Function Array Date RegExp Object Error Symbol".split(
                " "
            ),
            function (e, t) {
                l["[object " + t + "]"] = t.toLowerCase();
            }
        );
    var k = (function (e) {
        var t,
            n,
            o,
            i,
            r,
            a,
            s,
            l,
            c,
            u,
            d,
            f,
            p,
            h,
            m,
            g,
            w,
            v,
            b,
            y = "sizzle" + 1 * new Date(),
            x = e.document,
            _ = 0,
            k = 0,
            C = le(),
            E = le(),
            T = le(),
            S = le(),
            A = function (e, t) {
                return e === t && (d = !0), 0;
            },
            D = {}.hasOwnProperty,
            N = [],
            j = N.pop,
            O = N.push,
            L = N.push,
            P = N.slice,
            I = function (e, t) {
                for (var n = 0, o = e.length; n < o; n++)
                    if (e[n] === t) return n;
                return -1;
            },
            q =
                "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            H = "[\\x20\\t\\r\\n\\f]",
            B =
                "(?:\\\\[\\da-fA-F]{1,6}" +
                H +
                "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
            M =
                "\\[" +
                H +
                "*(" +
                B +
                ")(?:" +
                H +
                "*([*^$|!~]?=)" +
                H +
                "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" +
                B +
                "))|)" +
                H +
                "*\\]",
            R =
                ":(" +
                B +
                ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" +
                M +
                ")*)|.*)\\)|)",
            F = new RegExp(H + "+", "g"),
            W = new RegExp(
                "^" + H + "+|((?:^|[^\\\\])(?:\\\\.)*)" + H + "+$",
                "g"
            ),
            z = new RegExp("^" + H + "*," + H + "*"),
            U = new RegExp("^" + H + "*([>+~]|" + H + ")" + H + "*"),
            V = new RegExp(H + "|>"),
            $ = new RegExp(R),
            Y = new RegExp("^" + B + "$"),
            Q = {
                ID: new RegExp("^#(" + B + ")"),
                CLASS: new RegExp("^\\.(" + B + ")"),
                TAG: new RegExp("^(" + B + "|[*])"),
                ATTR: new RegExp("^" + M),
                PSEUDO: new RegExp("^" + R),
                CHILD: new RegExp(
                    "^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" +
                        H +
                        "*(even|odd|(([+-]|)(\\d*)n|)" +
                        H +
                        "*(?:([+-]|)" +
                        H +
                        "*(\\d+)|))" +
                        H +
                        "*\\)|)",
                    "i"
                ),
                bool: new RegExp("^(?:" + q + ")$", "i"),
                needsContext: new RegExp(
                    "^" +
                        H +
                        "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" +
                        H +
                        "*((?:-\\d)?\\d*)" +
                        H +
                        "*\\)|)(?=[^-]|$)",
                    "i"
                ),
            },
            X = /HTML$/i,
            K = /^(?:input|select|textarea|button)$/i,
            Z = /^h\d$/i,
            G = /^[^{]+\{\s*\[native \w/,
            J = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            ee = /[+~]/,
            te = new RegExp(
                "\\\\[\\da-fA-F]{1,6}" + H + "?|\\\\([^\\r\\n\\f])",
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
            oe = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
            ie = function (e, t) {
                return t
                    ? "\0" === e
                        ? "�"
                        : e.slice(0, -1) +
                          "\\" +
                          e.charCodeAt(e.length - 1).toString(16) +
                          " "
                    : "\\" + e;
            },
            re = function () {
                f();
            },
            ae = ye(
                function (e) {
                    return (
                        !0 === e.disabled &&
                        "fieldset" === e.nodeName.toLowerCase()
                    );
                },
                { dir: "parentNode", next: "legend" }
            );
        try {
            L.apply((N = P.call(x.childNodes)), x.childNodes),
                N[x.childNodes.length].nodeType;
        } catch (t) {
            L = {
                apply: N.length
                    ? function (e, t) {
                          O.apply(e, P.call(t));
                      }
                    : function (e, t) {
                          for (var n = e.length, o = 0; (e[n++] = t[o++]); );
                          e.length = n - 1;
                      },
            };
        }
        function se(e, t, o, i) {
            var r,
                s,
                c,
                u,
                d,
                h,
                w,
                v = t && t.ownerDocument,
                x = t ? t.nodeType : 9;
            if (
                ((o = o || []),
                "string" != typeof e || !e || (1 !== x && 9 !== x && 11 !== x))
            )
                return o;
            if (!i && (f(t), (t = t || p), m)) {
                if (11 !== x && (d = J.exec(e)))
                    if ((r = d[1])) {
                        if (9 === x) {
                            if (!(c = t.getElementById(r))) return o;
                            if (c.id === r) return o.push(c), o;
                        } else if (
                            v &&
                            (c = v.getElementById(r)) &&
                            b(t, c) &&
                            c.id === r
                        )
                            return o.push(c), o;
                    } else {
                        if (d[2])
                            return L.apply(o, t.getElementsByTagName(e)), o;
                        if (
                            (r = d[3]) &&
                            n.getElementsByClassName &&
                            t.getElementsByClassName
                        )
                            return L.apply(o, t.getElementsByClassName(r)), o;
                    }
                if (
                    n.qsa &&
                    !S[e + " "] &&
                    (!g || !g.test(e)) &&
                    (1 !== x || "object" !== t.nodeName.toLowerCase())
                ) {
                    if (
                        ((w = e), (v = t), 1 === x && (V.test(e) || U.test(e)))
                    ) {
                        for (
                            ((v = (ee.test(e) && we(t.parentNode)) || t) ===
                                t &&
                                n.scope) ||
                                ((u = t.getAttribute("id"))
                                    ? (u = u.replace(oe, ie))
                                    : t.setAttribute("id", (u = y))),
                                s = (h = a(e)).length;
                            s--;

                        )
                            h[s] = (u ? "#" + u : ":scope") + " " + be(h[s]);
                        w = h.join(",");
                    }
                    try {
                        return L.apply(o, v.querySelectorAll(w)), o;
                    } catch (t) {
                        S(e, !0);
                    } finally {
                        u === y && t.removeAttribute("id");
                    }
                }
            }
            return l(e.replace(W, "$1"), t, o, i);
        }
        function le() {
            var e = [];
            return function t(n, i) {
                return (
                    e.push(n + " ") > o.cacheLength && delete t[e.shift()],
                    (t[n + " "] = i)
                );
            };
        }
        function ce(e) {
            return (e[y] = !0), e;
        }
        function ue(e) {
            var t = p.createElement("fieldset");
            try {
                return !!e(t);
            } catch (e) {
                return !1;
            } finally {
                t.parentNode && t.parentNode.removeChild(t), (t = null);
            }
        }
        function de(e, t) {
            for (var n = e.split("|"), i = n.length; i--; )
                o.attrHandle[n[i]] = t;
        }
        function fe(e, t) {
            var n = t && e,
                o =
                    n &&
                    1 === e.nodeType &&
                    1 === t.nodeType &&
                    e.sourceIndex - t.sourceIndex;
            if (o) return o;
            if (n) for (; (n = n.nextSibling); ) if (n === t) return -1;
            return e ? 1 : -1;
        }
        function pe(e) {
            return function (t) {
                return "input" === t.nodeName.toLowerCase() && t.type === e;
            };
        }
        function he(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && t.type === e;
            };
        }
        function me(e) {
            return function (t) {
                return "form" in t
                    ? t.parentNode && !1 === t.disabled
                        ? "label" in t
                            ? "label" in t.parentNode
                                ? t.parentNode.disabled === e
                                : t.disabled === e
                            : t.isDisabled === e ||
                              (t.isDisabled !== !e && ae(t) === e)
                        : t.disabled === e
                    : "label" in t && t.disabled === e;
            };
        }
        function ge(e) {
            return ce(function (t) {
                return (
                    (t = +t),
                    ce(function (n, o) {
                        for (var i, r = e([], n.length, t), a = r.length; a--; )
                            n[(i = r[a])] && (n[i] = !(o[i] = n[i]));
                    })
                );
            });
        }
        function we(e) {
            return e && void 0 !== e.getElementsByTagName && e;
        }
        for (t in ((n = se.support = {}),
        (r = se.isXML =
            function (e) {
                var t = e.namespaceURI,
                    n = (e.ownerDocument || e).documentElement;
                return !X.test(t || (n && n.nodeName) || "HTML");
            }),
        (f = se.setDocument =
            function (e) {
                var t,
                    i,
                    a = e ? e.ownerDocument || e : x;
                return (
                    a != p &&
                        9 === a.nodeType &&
                        a.documentElement &&
                        ((h = (p = a).documentElement),
                        (m = !r(p)),
                        x != p &&
                            (i = p.defaultView) &&
                            i.top !== i &&
                            (i.addEventListener
                                ? i.addEventListener("unload", re, !1)
                                : i.attachEvent &&
                                  i.attachEvent("onunload", re)),
                        (n.scope = ue(function (e) {
                            return (
                                h
                                    .appendChild(e)
                                    .appendChild(p.createElement("div")),
                                void 0 !== e.querySelectorAll &&
                                    !e.querySelectorAll(":scope fieldset div")
                                        .length
                            );
                        })),
                        (n.attributes = ue(function (e) {
                            return (
                                (e.className = "i"),
                                !e.getAttribute("className")
                            );
                        })),
                        (n.getElementsByTagName = ue(function (e) {
                            return (
                                e.appendChild(p.createComment("")),
                                !e.getElementsByTagName("*").length
                            );
                        })),
                        (n.getElementsByClassName = G.test(
                            p.getElementsByClassName
                        )),
                        (n.getById = ue(function (e) {
                            return (
                                (h.appendChild(e).id = y),
                                !p.getElementsByName ||
                                    !p.getElementsByName(y).length
                            );
                        })),
                        n.getById
                            ? ((o.filter.ID = function (e) {
                                  var t = e.replace(te, ne);
                                  return function (e) {
                                      return e.getAttribute("id") === t;
                                  };
                              }),
                              (o.find.ID = function (e, t) {
                                  if (void 0 !== t.getElementById && m) {
                                      var n = t.getElementById(e);
                                      return n ? [n] : [];
                                  }
                              }))
                            : ((o.filter.ID = function (e) {
                                  var t = e.replace(te, ne);
                                  return function (e) {
                                      var n =
                                          void 0 !== e.getAttributeNode &&
                                          e.getAttributeNode("id");
                                      return n && n.value === t;
                                  };
                              }),
                              (o.find.ID = function (e, t) {
                                  if (void 0 !== t.getElementById && m) {
                                      var n,
                                          o,
                                          i,
                                          r = t.getElementById(e);
                                      if (r) {
                                          if (
                                              (n = r.getAttributeNode("id")) &&
                                              n.value === e
                                          )
                                              return [r];
                                          for (
                                              i = t.getElementsByName(e), o = 0;
                                              (r = i[o++]);

                                          )
                                              if (
                                                  (n =
                                                      r.getAttributeNode(
                                                          "id"
                                                      )) &&
                                                  n.value === e
                                              )
                                                  return [r];
                                      }
                                      return [];
                                  }
                              })),
                        (o.find.TAG = n.getElementsByTagName
                            ? function (e, t) {
                                  return void 0 !== t.getElementsByTagName
                                      ? t.getElementsByTagName(e)
                                      : n.qsa
                                      ? t.querySelectorAll(e)
                                      : void 0;
                              }
                            : function (e, t) {
                                  var n,
                                      o = [],
                                      i = 0,
                                      r = t.getElementsByTagName(e);
                                  if ("*" === e) {
                                      for (; (n = r[i++]); )
                                          1 === n.nodeType && o.push(n);
                                      return o;
                                  }
                                  return r;
                              }),
                        (o.find.CLASS =
                            n.getElementsByClassName &&
                            function (e, t) {
                                if (void 0 !== t.getElementsByClassName && m)
                                    return t.getElementsByClassName(e);
                            }),
                        (w = []),
                        (g = []),
                        (n.qsa = G.test(p.querySelectorAll)) &&
                            (ue(function (e) {
                                var t;
                                (h.appendChild(e).innerHTML =
                                    "<a id='" +
                                    y +
                                    "'></a><select id='" +
                                    y +
                                    "-\r\\' msallowcapture=''><option selected=''></option></select>"),
                                    e.querySelectorAll("[msallowcapture^='']")
                                        .length &&
                                        g.push("[*^$]=" + H + "*(?:''|\"\")"),
                                    e.querySelectorAll("[selected]").length ||
                                        g.push(
                                            "\\[" + H + "*(?:value|" + q + ")"
                                        ),
                                    e.querySelectorAll("[id~=" + y + "-]")
                                        .length || g.push("~="),
                                    (t = p.createElement("input")).setAttribute(
                                        "name",
                                        ""
                                    ),
                                    e.appendChild(t),
                                    e.querySelectorAll("[name='']").length ||
                                        g.push(
                                            "\\[" +
                                                H +
                                                "*name" +
                                                H +
                                                "*=" +
                                                H +
                                                "*(?:''|\"\")"
                                        ),
                                    e.querySelectorAll(":checked").length ||
                                        g.push(":checked"),
                                    e.querySelectorAll("a#" + y + "+*")
                                        .length || g.push(".#.+[+~]"),
                                    e.querySelectorAll("\\\f"),
                                    g.push("[\\r\\n\\f]");
                            }),
                            ue(function (e) {
                                e.innerHTML =
                                    "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                                var t = p.createElement("input");
                                t.setAttribute("type", "hidden"),
                                    e.appendChild(t).setAttribute("name", "D"),
                                    e.querySelectorAll("[name=d]").length &&
                                        g.push("name" + H + "*[*^$|!~]?="),
                                    2 !==
                                        e.querySelectorAll(":enabled").length &&
                                        g.push(":enabled", ":disabled"),
                                    (h.appendChild(e).disabled = !0),
                                    2 !==
                                        e.querySelectorAll(":disabled")
                                            .length &&
                                        g.push(":enabled", ":disabled"),
                                    e.querySelectorAll("*,:x"),
                                    g.push(",.*:");
                            })),
                        (n.matchesSelector = G.test(
                            (v =
                                h.matches ||
                                h.webkitMatchesSelector ||
                                h.mozMatchesSelector ||
                                h.oMatchesSelector ||
                                h.msMatchesSelector)
                        )) &&
                            ue(function (e) {
                                (n.disconnectedMatch = v.call(e, "*")),
                                    v.call(e, "[s!='']:x"),
                                    w.push("!=", R);
                            }),
                        (g = g.length && new RegExp(g.join("|"))),
                        (w = w.length && new RegExp(w.join("|"))),
                        (t = G.test(h.compareDocumentPosition)),
                        (b =
                            t || G.test(h.contains)
                                ? function (e, t) {
                                      var n =
                                              9 === e.nodeType
                                                  ? e.documentElement
                                                  : e,
                                          o = t && t.parentNode;
                                      return (
                                          e === o ||
                                          !(
                                              !o ||
                                              1 !== o.nodeType ||
                                              !(n.contains
                                                  ? n.contains(o)
                                                  : e.compareDocumentPosition &&
                                                    16 &
                                                        e.compareDocumentPosition(
                                                            o
                                                        ))
                                          )
                                      );
                                  }
                                : function (e, t) {
                                      if (t)
                                          for (; (t = t.parentNode); )
                                              if (t === e) return !0;
                                      return !1;
                                  }),
                        (A = t
                            ? function (e, t) {
                                  if (e === t) return (d = !0), 0;
                                  var o =
                                      !e.compareDocumentPosition -
                                      !t.compareDocumentPosition;
                                  return (
                                      o ||
                                      (1 &
                                          (o =
                                              (e.ownerDocument || e) ==
                                              (t.ownerDocument || t)
                                                  ? e.compareDocumentPosition(t)
                                                  : 1) ||
                                      (!n.sortDetached &&
                                          t.compareDocumentPosition(e) === o)
                                          ? e == p ||
                                            (e.ownerDocument == x && b(x, e))
                                              ? -1
                                              : t == p ||
                                                (t.ownerDocument == x &&
                                                    b(x, t))
                                              ? 1
                                              : u
                                              ? I(u, e) - I(u, t)
                                              : 0
                                          : 4 & o
                                          ? -1
                                          : 1)
                                  );
                              }
                            : function (e, t) {
                                  if (e === t) return (d = !0), 0;
                                  var n,
                                      o = 0,
                                      i = e.parentNode,
                                      r = t.parentNode,
                                      a = [e],
                                      s = [t];
                                  if (!i || !r)
                                      return e == p
                                          ? -1
                                          : t == p
                                          ? 1
                                          : i
                                          ? -1
                                          : r
                                          ? 1
                                          : u
                                          ? I(u, e) - I(u, t)
                                          : 0;
                                  if (i === r) return fe(e, t);
                                  for (n = e; (n = n.parentNode); )
                                      a.unshift(n);
                                  for (n = t; (n = n.parentNode); )
                                      s.unshift(n);
                                  for (; a[o] === s[o]; ) o++;
                                  return o
                                      ? fe(a[o], s[o])
                                      : a[o] == x
                                      ? -1
                                      : s[o] == x
                                      ? 1
                                      : 0;
                              })),
                    p
                );
            }),
        (se.matches = function (e, t) {
            return se(e, null, null, t);
        }),
        (se.matchesSelector = function (e, t) {
            if (
                (f(e),
                n.matchesSelector &&
                    m &&
                    !S[t + " "] &&
                    (!w || !w.test(t)) &&
                    (!g || !g.test(t)))
            )
                try {
                    var o = v.call(e, t);
                    if (
                        o ||
                        n.disconnectedMatch ||
                        (e.document && 11 !== e.document.nodeType)
                    )
                        return o;
                } catch (e) {
                    S(t, !0);
                }
            return 0 < se(t, p, null, [e]).length;
        }),
        (se.contains = function (e, t) {
            return (e.ownerDocument || e) != p && f(e), b(e, t);
        }),
        (se.attr = function (e, t) {
            (e.ownerDocument || e) != p && f(e);
            var i = o.attrHandle[t.toLowerCase()],
                r =
                    i && D.call(o.attrHandle, t.toLowerCase())
                        ? i(e, t, !m)
                        : void 0;
            return void 0 !== r
                ? r
                : n.attributes || !m
                ? e.getAttribute(t)
                : (r = e.getAttributeNode(t)) && r.specified
                ? r.value
                : null;
        }),
        (se.escape = function (e) {
            return (e + "").replace(oe, ie);
        }),
        (se.error = function (e) {
            throw new Error("Syntax error, unrecognized expression: " + e);
        }),
        (se.uniqueSort = function (e) {
            var t,
                o = [],
                i = 0,
                r = 0;
            if (
                ((d = !n.detectDuplicates),
                (u = !n.sortStable && e.slice(0)),
                e.sort(A),
                d)
            ) {
                for (; (t = e[r++]); ) t === e[r] && (i = o.push(r));
                for (; i--; ) e.splice(o[i], 1);
            }
            return (u = null), e;
        }),
        (i = se.getText =
            function (e) {
                var t,
                    n = "",
                    o = 0,
                    r = e.nodeType;
                if (r) {
                    if (1 === r || 9 === r || 11 === r) {
                        if ("string" == typeof e.textContent)
                            return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += i(e);
                    } else if (3 === r || 4 === r) return e.nodeValue;
                } else for (; (t = e[o++]); ) n += i(t);
                return n;
            }),
        ((o = se.selectors =
            {
                cacheLength: 50,
                createPseudo: ce,
                match: Q,
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
                        return Q.CHILD.test(e[0])
                            ? null
                            : (e[3]
                                  ? (e[2] = e[4] || e[5] || "")
                                  : n &&
                                    $.test(n) &&
                                    (t = a(n, !0)) &&
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
                        var t = C[e + " "];
                        return (
                            t ||
                            ((t = new RegExp(
                                "(^|" + H + ")" + e + "(" + H + "|$)"
                            )) &&
                                C(e, function (e) {
                                    return t.test(
                                        ("string" == typeof e.className &&
                                            e.className) ||
                                            (void 0 !== e.getAttribute &&
                                                e.getAttribute("class")) ||
                                            ""
                                    );
                                }))
                        );
                    },
                    ATTR: function (e, t, n) {
                        return function (o) {
                            var i = se.attr(o, e);
                            return null == i
                                ? "!=" === t
                                : !t ||
                                      ((i += ""),
                                      "=" === t
                                          ? i === n
                                          : "!=" === t
                                          ? i !== n
                                          : "^=" === t
                                          ? n && 0 === i.indexOf(n)
                                          : "*=" === t
                                          ? n && -1 < i.indexOf(n)
                                          : "$=" === t
                                          ? n && i.slice(-n.length) === n
                                          : "~=" === t
                                          ? -1 <
                                            (
                                                " " +
                                                i.replace(F, " ") +
                                                " "
                                            ).indexOf(n)
                                          : "|=" === t &&
                                            (i === n ||
                                                i.slice(0, n.length + 1) ===
                                                    n + "-"));
                        };
                    },
                    CHILD: function (e, t, n, o, i) {
                        var r = "nth" !== e.slice(0, 3),
                            a = "last" !== e.slice(-4),
                            s = "of-type" === t;
                        return 1 === o && 0 === i
                            ? function (e) {
                                  return !!e.parentNode;
                              }
                            : function (t, n, l) {
                                  var c,
                                      u,
                                      d,
                                      f,
                                      p,
                                      h,
                                      m =
                                          r !== a
                                              ? "nextSibling"
                                              : "previousSibling",
                                      g = t.parentNode,
                                      w = s && t.nodeName.toLowerCase(),
                                      v = !l && !s,
                                      b = !1;
                                  if (g) {
                                      if (r) {
                                          for (; m; ) {
                                              for (f = t; (f = f[m]); )
                                                  if (
                                                      s
                                                          ? f.nodeName.toLowerCase() ===
                                                            w
                                                          : 1 === f.nodeType
                                                  )
                                                      return !1;
                                              h = m =
                                                  "only" === e &&
                                                  !h &&
                                                  "nextSibling";
                                          }
                                          return !0;
                                      }
                                      if (
                                          ((h = [
                                              a ? g.firstChild : g.lastChild,
                                          ]),
                                          a && v)
                                      ) {
                                          for (
                                              b =
                                                  (p =
                                                      (c =
                                                          (u =
                                                              (d =
                                                                  (f = g)[y] ||
                                                                  (f[y] = {}))[
                                                                  f.uniqueID
                                                              ] ||
                                                              (d[f.uniqueID] =
                                                                  {}))[e] ||
                                                          [])[0] === _ &&
                                                      c[1]) && c[2],
                                                  f = p && g.childNodes[p];
                                              (f =
                                                  (++p && f && f[m]) ||
                                                  (b = p = 0) ||
                                                  h.pop());

                                          )
                                              if (
                                                  1 === f.nodeType &&
                                                  ++b &&
                                                  f === t
                                              ) {
                                                  u[e] = [_, p, b];
                                                  break;
                                              }
                                      } else if (
                                          (v &&
                                              (b = p =
                                                  (c =
                                                      (u =
                                                          (d =
                                                              (f = t)[y] ||
                                                              (f[y] = {}))[
                                                              f.uniqueID
                                                          ] ||
                                                          (d[f.uniqueID] = {}))[
                                                          e
                                                      ] || [])[0] === _ &&
                                                  c[1]),
                                          !1 === b)
                                      )
                                          for (
                                              ;
                                              (f =
                                                  (++p && f && f[m]) ||
                                                  (b = p = 0) ||
                                                  h.pop()) &&
                                              ((s
                                                  ? f.nodeName.toLowerCase() !==
                                                    w
                                                  : 1 !== f.nodeType) ||
                                                  !++b ||
                                                  (v &&
                                                      ((u =
                                                          (d =
                                                              f[y] ||
                                                              (f[y] = {}))[
                                                              f.uniqueID
                                                          ] ||
                                                          (d[f.uniqueID] = {}))[
                                                          e
                                                      ] = [_, b]),
                                                  f !== t));

                                          );
                                      return (
                                          (b -= i) === o ||
                                          (b % o == 0 && 0 <= b / o)
                                      );
                                  }
                              };
                    },
                    PSEUDO: function (e, t) {
                        var n,
                            i =
                                o.pseudos[e] ||
                                o.setFilters[e.toLowerCase()] ||
                                se.error("unsupported pseudo: " + e);
                        return i[y]
                            ? i(t)
                            : 1 < i.length
                            ? ((n = [e, e, "", t]),
                              o.setFilters.hasOwnProperty(e.toLowerCase())
                                  ? ce(function (e, n) {
                                        for (
                                            var o, r = i(e, t), a = r.length;
                                            a--;

                                        )
                                            e[(o = I(e, r[a]))] = !(n[o] =
                                                r[a]);
                                    })
                                  : function (e) {
                                        return i(e, 0, n);
                                    })
                            : i;
                    },
                },
                pseudos: {
                    not: ce(function (e) {
                        var t = [],
                            n = [],
                            o = s(e.replace(W, "$1"));
                        return o[y]
                            ? ce(function (e, t, n, i) {
                                  for (
                                      var r,
                                          a = o(e, null, i, []),
                                          s = e.length;
                                      s--;

                                  )
                                      (r = a[s]) && (e[s] = !(t[s] = r));
                              })
                            : function (e, i, r) {
                                  return (
                                      (t[0] = e),
                                      o(t, null, r, n),
                                      (t[0] = null),
                                      !n.pop()
                                  );
                              };
                    }),
                    has: ce(function (e) {
                        return function (t) {
                            return 0 < se(e, t).length;
                        };
                    }),
                    contains: ce(function (e) {
                        return (
                            (e = e.replace(te, ne)),
                            function (t) {
                                return -1 < (t.textContent || i(t)).indexOf(e);
                            }
                        );
                    }),
                    lang: ce(function (e) {
                        return (
                            Y.test(e || "") ||
                                se.error("unsupported lang: " + e),
                            (e = e.replace(te, ne).toLowerCase()),
                            function (t) {
                                var n;
                                do {
                                    if (
                                        (n = m
                                            ? t.lang
                                            : t.getAttribute("xml:lang") ||
                                              t.getAttribute("lang"))
                                    )
                                        return (
                                            (n = n.toLowerCase()) === e ||
                                            0 === n.indexOf(e + "-")
                                        );
                                } while (
                                    (t = t.parentNode) &&
                                    1 === t.nodeType
                                );
                                return !1;
                            }
                        );
                    }),
                    target: function (t) {
                        var n = e.location && e.location.hash;
                        return n && n.slice(1) === t.id;
                    },
                    root: function (e) {
                        return e === h;
                    },
                    focus: function (e) {
                        return (
                            e === p.activeElement &&
                            (!p.hasFocus || p.hasFocus()) &&
                            !!(e.type || e.href || ~e.tabIndex)
                        );
                    },
                    enabled: me(!1),
                    disabled: me(!0),
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
                        return !o.pseudos.empty(e);
                    },
                    header: function (e) {
                        return Z.test(e.nodeName);
                    },
                    input: function (e) {
                        return K.test(e.nodeName);
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
                    first: ge(function () {
                        return [0];
                    }),
                    last: ge(function (e, t) {
                        return [t - 1];
                    }),
                    eq: ge(function (e, t, n) {
                        return [n < 0 ? n + t : n];
                    }),
                    even: ge(function (e, t) {
                        for (var n = 0; n < t; n += 2) e.push(n);
                        return e;
                    }),
                    odd: ge(function (e, t) {
                        for (var n = 1; n < t; n += 2) e.push(n);
                        return e;
                    }),
                    lt: ge(function (e, t, n) {
                        for (var o = n < 0 ? n + t : t < n ? t : n; 0 <= --o; )
                            e.push(o);
                        return e;
                    }),
                    gt: ge(function (e, t, n) {
                        for (var o = n < 0 ? n + t : n; ++o < t; ) e.push(o);
                        return e;
                    }),
                },
            }).pseudos.nth = o.pseudos.eq),
        { radio: !0, checkbox: !0, file: !0, password: !0, image: !0 }))
            o.pseudos[t] = pe(t);
        for (t in { submit: !0, reset: !0 }) o.pseudos[t] = he(t);
        function ve() {}
        function be(e) {
            for (var t = 0, n = e.length, o = ""; t < n; t++) o += e[t].value;
            return o;
        }
        function ye(e, t, n) {
            var o = t.dir,
                i = t.next,
                r = i || o,
                a = n && "parentNode" === r,
                s = k++;
            return t.first
                ? function (t, n, i) {
                      for (; (t = t[o]); )
                          if (1 === t.nodeType || a) return e(t, n, i);
                      return !1;
                  }
                : function (t, n, l) {
                      var c,
                          u,
                          d,
                          f = [_, s];
                      if (l) {
                          for (; (t = t[o]); )
                              if ((1 === t.nodeType || a) && e(t, n, l))
                                  return !0;
                      } else
                          for (; (t = t[o]); )
                              if (1 === t.nodeType || a)
                                  if (
                                      ((u =
                                          (d = t[y] || (t[y] = {}))[
                                              t.uniqueID
                                          ] || (d[t.uniqueID] = {})),
                                      i && i === t.nodeName.toLowerCase())
                                  )
                                      t = t[o] || t;
                                  else {
                                      if (
                                          (c = u[r]) &&
                                          c[0] === _ &&
                                          c[1] === s
                                      )
                                          return (f[2] = c[2]);
                                      if (((u[r] = f)[2] = e(t, n, l)))
                                          return !0;
                                  }
                      return !1;
                  };
        }
        function xe(e) {
            return 1 < e.length
                ? function (t, n, o) {
                      for (var i = e.length; i--; )
                          if (!e[i](t, n, o)) return !1;
                      return !0;
                  }
                : e[0];
        }
        function _e(e, t, n, o, i) {
            for (var r, a = [], s = 0, l = e.length, c = null != t; s < l; s++)
                (r = e[s]) &&
                    ((n && !n(r, o, i)) || (a.push(r), c && t.push(s)));
            return a;
        }
        function ke(e, t, n, o, i, r) {
            return (
                o && !o[y] && (o = ke(o)),
                i && !i[y] && (i = ke(i, r)),
                ce(function (r, a, s, l) {
                    var c,
                        u,
                        d,
                        f = [],
                        p = [],
                        h = a.length,
                        m =
                            r ||
                            (function (e, t, n) {
                                for (var o = 0, i = t.length; o < i; o++)
                                    se(e, t[o], n);
                                return n;
                            })(t || "*", s.nodeType ? [s] : s, []),
                        g = !e || (!r && t) ? m : _e(m, f, e, s, l),
                        w = n ? (i || (r ? e : h || o) ? [] : a) : g;
                    if ((n && n(g, w, s, l), o))
                        for (c = _e(w, p), o(c, [], s, l), u = c.length; u--; )
                            (d = c[u]) && (w[p[u]] = !(g[p[u]] = d));
                    if (r) {
                        if (i || e) {
                            if (i) {
                                for (c = [], u = w.length; u--; )
                                    (d = w[u]) && c.push((g[u] = d));
                                i(null, (w = []), c, l);
                            }
                            for (u = w.length; u--; )
                                (d = w[u]) &&
                                    -1 < (c = i ? I(r, d) : f[u]) &&
                                    (r[c] = !(a[c] = d));
                        }
                    } else (w = _e(w === a ? w.splice(h, w.length) : w)), i ? i(null, a, w, l) : L.apply(a, w);
                })
            );
        }
        function Ce(e) {
            for (
                var t,
                    n,
                    i,
                    r = e.length,
                    a = o.relative[e[0].type],
                    s = a || o.relative[" "],
                    l = a ? 1 : 0,
                    u = ye(
                        function (e) {
                            return e === t;
                        },
                        s,
                        !0
                    ),
                    d = ye(
                        function (e) {
                            return -1 < I(t, e);
                        },
                        s,
                        !0
                    ),
                    f = [
                        function (e, n, o) {
                            var i =
                                (!a && (o || n !== c)) ||
                                ((t = n).nodeType ? u(e, n, o) : d(e, n, o));
                            return (t = null), i;
                        },
                    ];
                l < r;
                l++
            )
                if ((n = o.relative[e[l].type])) f = [ye(xe(f), n)];
                else {
                    if (
                        (n = o.filter[e[l].type].apply(null, e[l].matches))[y]
                    ) {
                        for (i = ++l; i < r && !o.relative[e[i].type]; i++);
                        return ke(
                            1 < l && xe(f),
                            1 < l &&
                                be(
                                    e
                                        .slice(0, l - 1)
                                        .concat({
                                            value:
                                                " " === e[l - 2].type
                                                    ? "*"
                                                    : "",
                                        })
                                ).replace(W, "$1"),
                            n,
                            l < i && Ce(e.slice(l, i)),
                            i < r && Ce((e = e.slice(i))),
                            i < r && be(e)
                        );
                    }
                    f.push(n);
                }
            return xe(f);
        }
        return (
            (ve.prototype = o.filters = o.pseudos),
            (o.setFilters = new ve()),
            (a = se.tokenize =
                function (e, t) {
                    var n,
                        i,
                        r,
                        a,
                        s,
                        l,
                        c,
                        u = E[e + " "];
                    if (u) return t ? 0 : u.slice(0);
                    for (s = e, l = [], c = o.preFilter; s; ) {
                        for (a in ((n && !(i = z.exec(s))) ||
                            (i && (s = s.slice(i[0].length) || s),
                            l.push((r = []))),
                        (n = !1),
                        (i = U.exec(s)) &&
                            ((n = i.shift()),
                            r.push({ value: n, type: i[0].replace(W, " ") }),
                            (s = s.slice(n.length))),
                        o.filter))
                            !(i = Q[a].exec(s)) ||
                                (c[a] && !(i = c[a](i))) ||
                                ((n = i.shift()),
                                r.push({ value: n, type: a, matches: i }),
                                (s = s.slice(n.length)));
                        if (!n) break;
                    }
                    return t ? s.length : s ? se.error(e) : E(e, l).slice(0);
                }),
            (s = se.compile =
                function (e, t) {
                    var n,
                        i,
                        r,
                        s,
                        l,
                        u,
                        d = [],
                        h = [],
                        g = T[e + " "];
                    if (!g) {
                        for (t || (t = a(e)), n = t.length; n--; )
                            (g = Ce(t[n]))[y] ? d.push(g) : h.push(g);
                        (g = T(
                            e,
                            ((i = h),
                            (s = 0 < (r = d).length),
                            (l = 0 < i.length),
                            (u = function (e, t, n, a, u) {
                                var d,
                                    h,
                                    g,
                                    w = 0,
                                    v = "0",
                                    b = e && [],
                                    y = [],
                                    x = c,
                                    k = e || (l && o.find.TAG("*", u)),
                                    C = (_ +=
                                        null == x ? 1 : Math.random() || 0.1),
                                    E = k.length;
                                for (
                                    u && (c = t == p || t || u);
                                    v !== E && null != (d = k[v]);
                                    v++
                                ) {
                                    if (l && d) {
                                        for (
                                            h = 0,
                                                t ||
                                                    d.ownerDocument == p ||
                                                    (f(d), (n = !m));
                                            (g = i[h++]);

                                        )
                                            if (g(d, t || p, n)) {
                                                a.push(d);
                                                break;
                                            }
                                        u && (_ = C);
                                    }
                                    s && ((d = !g && d) && w--, e && b.push(d));
                                }
                                if (((w += v), s && v !== w)) {
                                    for (h = 0; (g = r[h++]); ) g(b, y, t, n);
                                    if (e) {
                                        if (0 < w)
                                            for (; v--; )
                                                b[v] ||
                                                    y[v] ||
                                                    (y[v] = j.call(a));
                                        y = _e(y);
                                    }
                                    L.apply(a, y),
                                        u &&
                                            !e &&
                                            0 < y.length &&
                                            1 < w + r.length &&
                                            se.uniqueSort(a);
                                }
                                return u && ((_ = C), (c = x)), b;
                            }),
                            s ? ce(u) : u)
                        )).selector = e;
                    }
                    return g;
                }),
            (l = se.select =
                function (e, t, n, i) {
                    var r,
                        l,
                        c,
                        u,
                        d,
                        f = "function" == typeof e && e,
                        p = !i && a((e = f.selector || e));
                    if (((n = n || []), 1 === p.length)) {
                        if (
                            2 < (l = p[0] = p[0].slice(0)).length &&
                            "ID" === (c = l[0]).type &&
                            9 === t.nodeType &&
                            m &&
                            o.relative[l[1].type]
                        ) {
                            if (
                                !(t = (o.find.ID(
                                    c.matches[0].replace(te, ne),
                                    t
                                ) || [])[0])
                            )
                                return n;
                            f && (t = t.parentNode),
                                (e = e.slice(l.shift().value.length));
                        }
                        for (
                            r = Q.needsContext.test(e) ? 0 : l.length;
                            r-- && ((c = l[r]), !o.relative[(u = c.type)]);

                        )
                            if (
                                (d = o.find[u]) &&
                                (i = d(
                                    c.matches[0].replace(te, ne),
                                    (ee.test(l[0].type) && we(t.parentNode)) ||
                                        t
                                ))
                            ) {
                                if ((l.splice(r, 1), !(e = i.length && be(l))))
                                    return L.apply(n, i), n;
                                break;
                            }
                    }
                    return (
                        (f || s(e, p))(
                            i,
                            t,
                            !m,
                            n,
                            !t || (ee.test(e) && we(t.parentNode)) || t
                        ),
                        n
                    );
                }),
            (n.sortStable = y.split("").sort(A).join("") === y),
            (n.detectDuplicates = !!d),
            f(),
            (n.sortDetached = ue(function (e) {
                return (
                    1 & e.compareDocumentPosition(p.createElement("fieldset"))
                );
            })),
            ue(function (e) {
                return (
                    (e.innerHTML = "<a href='#'></a>"),
                    "#" === e.firstChild.getAttribute("href")
                );
            }) ||
                de("type|href|height|width", function (e, t, n) {
                    if (!n)
                        return e.getAttribute(
                            t,
                            "type" === t.toLowerCase() ? 1 : 2
                        );
                }),
            (n.attributes &&
                ue(function (e) {
                    return (
                        (e.innerHTML = "<input/>"),
                        e.firstChild.setAttribute("value", ""),
                        "" === e.firstChild.getAttribute("value")
                    );
                })) ||
                de("value", function (e, t, n) {
                    if (!n && "input" === e.nodeName.toLowerCase())
                        return e.defaultValue;
                }),
            ue(function (e) {
                return null == e.getAttribute("disabled");
            }) ||
                de(q, function (e, t, n) {
                    var o;
                    if (!n)
                        return !0 === e[t]
                            ? t.toLowerCase()
                            : (o = e.getAttributeNode(t)) && o.specified
                            ? o.value
                            : null;
                }),
            se
        );
    })(e);
    (x.find = k),
        (x.expr = k.selectors),
        (x.expr[":"] = x.expr.pseudos),
        (x.uniqueSort = x.unique = k.uniqueSort),
        (x.text = k.getText),
        (x.isXMLDoc = k.isXML),
        (x.contains = k.contains),
        (x.escapeSelector = k.escape);
    var C = function (e, t, n) {
            for (var o = [], i = void 0 !== n; (e = e[t]) && 9 !== e.nodeType; )
                if (1 === e.nodeType) {
                    if (i && x(e).is(n)) break;
                    o.push(e);
                }
            return o;
        },
        E = function (e, t) {
            for (var n = []; e; e = e.nextSibling)
                1 === e.nodeType && e !== t && n.push(e);
            return n;
        },
        T = x.expr.match.needsContext;
    function S(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase();
    }
    var A = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
    function D(e, t, n) {
        return h(t)
            ? x.grep(e, function (e, o) {
                  return !!t.call(e, o, e) !== n;
              })
            : t.nodeType
            ? x.grep(e, function (e) {
                  return (e === t) !== n;
              })
            : "string" != typeof t
            ? x.grep(e, function (e) {
                  return -1 < s.call(t, e) !== n;
              })
            : x.filter(t, e, n);
    }
    (x.filter = function (e, t, n) {
        var o = t[0];
        return (
            n && (e = ":not(" + e + ")"),
            1 === t.length && 1 === o.nodeType
                ? x.find.matchesSelector(o, e)
                    ? [o]
                    : []
                : x.find.matches(
                      e,
                      x.grep(t, function (e) {
                          return 1 === e.nodeType;
                      })
                  )
        );
    }),
        x.fn.extend({
            find: function (e) {
                var t,
                    n,
                    o = this.length,
                    i = this;
                if ("string" != typeof e)
                    return this.pushStack(
                        x(e).filter(function () {
                            for (t = 0; t < o; t++)
                                if (x.contains(i[t], this)) return !0;
                        })
                    );
                for (n = this.pushStack([]), t = 0; t < o; t++)
                    x.find(e, i[t], n);
                return 1 < o ? x.uniqueSort(n) : n;
            },
            filter: function (e) {
                return this.pushStack(D(this, e || [], !1));
            },
            not: function (e) {
                return this.pushStack(D(this, e || [], !0));
            },
            is: function (e) {
                return !!D(
                    this,
                    "string" == typeof e && T.test(e) ? x(e) : e || [],
                    !1
                ).length;
            },
        });
    var N,
        j = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    ((x.fn.init = function (e, t, n) {
        var o, i;
        if (!e) return this;
        if (((n = n || N), "string" == typeof e)) {
            if (
                !(o =
                    "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length
                        ? [null, e, null]
                        : j.exec(e)) ||
                (!o[1] && t)
            )
                return !t || t.jquery
                    ? (t || n).find(e)
                    : this.constructor(t).find(e);
            if (o[1]) {
                if (
                    ((t = t instanceof x ? t[0] : t),
                    x.merge(
                        this,
                        x.parseHTML(
                            o[1],
                            t && t.nodeType ? t.ownerDocument || t : g,
                            !0
                        )
                    ),
                    A.test(o[1]) && x.isPlainObject(t))
                )
                    for (o in t)
                        h(this[o]) ? this[o](t[o]) : this.attr(o, t[o]);
                return this;
            }
            return (
                (i = g.getElementById(o[2])) &&
                    ((this[0] = i), (this.length = 1)),
                this
            );
        }
        return e.nodeType
            ? ((this[0] = e), (this.length = 1), this)
            : h(e)
            ? void 0 !== n.ready
                ? n.ready(e)
                : e(x)
            : x.makeArray(e, this);
    }).prototype = x.fn),
        (N = x(g));
    var O = /^(?:parents|prev(?:Until|All))/,
        L = { children: !0, contents: !0, next: !0, prev: !0 };
    function P(e, t) {
        for (; (e = e[t]) && 1 !== e.nodeType; );
        return e;
    }
    x.fn.extend({
        has: function (e) {
            var t = x(e, this),
                n = t.length;
            return this.filter(function () {
                for (var e = 0; e < n; e++)
                    if (x.contains(this, t[e])) return !0;
            });
        },
        closest: function (e, t) {
            var n,
                o = 0,
                i = this.length,
                r = [],
                a = "string" != typeof e && x(e);
            if (!T.test(e))
                for (; o < i; o++)
                    for (n = this[o]; n && n !== t; n = n.parentNode)
                        if (
                            n.nodeType < 11 &&
                            (a
                                ? -1 < a.index(n)
                                : 1 === n.nodeType &&
                                  x.find.matchesSelector(n, e))
                        ) {
                            r.push(n);
                            break;
                        }
            return this.pushStack(1 < r.length ? x.uniqueSort(r) : r);
        },
        index: function (e) {
            return e
                ? "string" == typeof e
                    ? s.call(x(e), this[0])
                    : s.call(this, e.jquery ? e[0] : e)
                : this[0] && this[0].parentNode
                ? this.first().prevAll().length
                : -1;
        },
        add: function (e, t) {
            return this.pushStack(x.uniqueSort(x.merge(this.get(), x(e, t))));
        },
        addBack: function (e) {
            return this.add(
                null == e ? this.prevObject : this.prevObject.filter(e)
            );
        },
    }),
        x.each(
            {
                parent: function (e) {
                    var t = e.parentNode;
                    return t && 11 !== t.nodeType ? t : null;
                },
                parents: function (e) {
                    return C(e, "parentNode");
                },
                parentsUntil: function (e, t, n) {
                    return C(e, "parentNode", n);
                },
                next: function (e) {
                    return P(e, "nextSibling");
                },
                prev: function (e) {
                    return P(e, "previousSibling");
                },
                nextAll: function (e) {
                    return C(e, "nextSibling");
                },
                prevAll: function (e) {
                    return C(e, "previousSibling");
                },
                nextUntil: function (e, t, n) {
                    return C(e, "nextSibling", n);
                },
                prevUntil: function (e, t, n) {
                    return C(e, "previousSibling", n);
                },
                siblings: function (e) {
                    return E((e.parentNode || {}).firstChild, e);
                },
                children: function (e) {
                    return E(e.firstChild);
                },
                contents: function (e) {
                    return null != e.contentDocument && o(e.contentDocument)
                        ? e.contentDocument
                        : (S(e, "template") && (e = e.content || e),
                          x.merge([], e.childNodes));
                },
            },
            function (e, t) {
                x.fn[e] = function (n, o) {
                    var i = x.map(this, t, n);
                    return (
                        "Until" !== e.slice(-5) && (o = n),
                        o && "string" == typeof o && (i = x.filter(o, i)),
                        1 < this.length &&
                            (L[e] || x.uniqueSort(i), O.test(e) && i.reverse()),
                        this.pushStack(i)
                    );
                };
            }
        );
    var I = /[^\x20\t\r\n\f]+/g;
    function q(e) {
        return e;
    }
    function H(e) {
        throw e;
    }
    function B(e, t, n, o) {
        var i;
        try {
            e && h((i = e.promise))
                ? i.call(e).done(t).fail(n)
                : e && h((i = e.then))
                ? i.call(e, t, n)
                : t.apply(void 0, [e].slice(o));
        } catch (e) {
            n.apply(void 0, [e]);
        }
    }
    (x.Callbacks = function (e) {
        var t, n;
        e =
            "string" == typeof e
                ? ((t = e),
                  (n = {}),
                  x.each(t.match(I) || [], function (e, t) {
                      n[t] = !0;
                  }),
                  n)
                : x.extend({}, e);
        var o,
            i,
            r,
            a,
            s = [],
            l = [],
            c = -1,
            u = function () {
                for (a = a || e.once, r = o = !0; l.length; c = -1)
                    for (i = l.shift(); ++c < s.length; )
                        !1 === s[c].apply(i[0], i[1]) &&
                            e.stopOnFalse &&
                            ((c = s.length), (i = !1));
                e.memory || (i = !1), (o = !1), a && (s = i ? [] : "");
            },
            d = {
                add: function () {
                    return (
                        s &&
                            (i && !o && ((c = s.length - 1), l.push(i)),
                            (function t(n) {
                                x.each(n, function (n, o) {
                                    h(o)
                                        ? (e.unique && d.has(o)) || s.push(o)
                                        : o &&
                                          o.length &&
                                          "string" !== b(o) &&
                                          t(o);
                                });
                            })(arguments),
                            i && !o && u()),
                        this
                    );
                },
                remove: function () {
                    return (
                        x.each(arguments, function (e, t) {
                            for (var n; -1 < (n = x.inArray(t, s, n)); )
                                s.splice(n, 1), n <= c && c--;
                        }),
                        this
                    );
                },
                has: function (e) {
                    return e ? -1 < x.inArray(e, s) : 0 < s.length;
                },
                empty: function () {
                    return s && (s = []), this;
                },
                disable: function () {
                    return (a = l = []), (s = i = ""), this;
                },
                disabled: function () {
                    return !s;
                },
                lock: function () {
                    return (a = l = []), i || o || (s = i = ""), this;
                },
                locked: function () {
                    return !!a;
                },
                fireWith: function (e, t) {
                    return (
                        a ||
                            ((t = [e, (t = t || []).slice ? t.slice() : t]),
                            l.push(t),
                            o || u()),
                        this
                    );
                },
                fire: function () {
                    return d.fireWith(this, arguments), this;
                },
                fired: function () {
                    return !!r;
                },
            };
        return d;
    }),
        x.extend({
            Deferred: function (t) {
                var n = [
                        [
                            "notify",
                            "progress",
                            x.Callbacks("memory"),
                            x.Callbacks("memory"),
                            2,
                        ],
                        [
                            "resolve",
                            "done",
                            x.Callbacks("once memory"),
                            x.Callbacks("once memory"),
                            0,
                            "resolved",
                        ],
                        [
                            "reject",
                            "fail",
                            x.Callbacks("once memory"),
                            x.Callbacks("once memory"),
                            1,
                            "rejected",
                        ],
                    ],
                    o = "pending",
                    i = {
                        state: function () {
                            return o;
                        },
                        always: function () {
                            return r.done(arguments).fail(arguments), this;
                        },
                        catch: function (e) {
                            return i.then(null, e);
                        },
                        pipe: function () {
                            var e = arguments;
                            return x
                                .Deferred(function (t) {
                                    x.each(n, function (n, o) {
                                        var i = h(e[o[4]]) && e[o[4]];
                                        r[o[1]](function () {
                                            var e =
                                                i && i.apply(this, arguments);
                                            e && h(e.promise)
                                                ? e
                                                      .promise()
                                                      .progress(t.notify)
                                                      .done(t.resolve)
                                                      .fail(t.reject)
                                                : t[o[0] + "With"](
                                                      this,
                                                      i ? [e] : arguments
                                                  );
                                        });
                                    }),
                                        (e = null);
                                })
                                .promise();
                        },
                        then: function (t, o, i) {
                            var r = 0;
                            function a(t, n, o, i) {
                                return function () {
                                    var s = this,
                                        l = arguments,
                                        c = function () {
                                            var e, c;
                                            if (!(t < r)) {
                                                if (
                                                    (e = o.apply(s, l)) ===
                                                    n.promise()
                                                )
                                                    throw new TypeError(
                                                        "Thenable self-resolution"
                                                    );
                                                (c =
                                                    e &&
                                                    ("object" == typeof e ||
                                                        "function" ==
                                                            typeof e) &&
                                                    e.then),
                                                    h(c)
                                                        ? i
                                                            ? c.call(
                                                                  e,
                                                                  a(r, n, q, i),
                                                                  a(r, n, H, i)
                                                              )
                                                            : (r++,
                                                              c.call(
                                                                  e,
                                                                  a(r, n, q, i),
                                                                  a(r, n, H, i),
                                                                  a(
                                                                      r,
                                                                      n,
                                                                      q,
                                                                      n.notifyWith
                                                                  )
                                                              ))
                                                        : (o !== q &&
                                                              ((s = void 0),
                                                              (l = [e])),
                                                          (i || n.resolveWith)(
                                                              s,
                                                              l
                                                          ));
                                            }
                                        },
                                        u = i
                                            ? c
                                            : function () {
                                                  try {
                                                      c();
                                                  } catch (e) {
                                                      x.Deferred
                                                          .exceptionHook &&
                                                          x.Deferred.exceptionHook(
                                                              e,
                                                              u.stackTrace
                                                          ),
                                                          r <= t + 1 &&
                                                              (o !== H &&
                                                                  ((s = void 0),
                                                                  (l = [e])),
                                                              n.rejectWith(
                                                                  s,
                                                                  l
                                                              ));
                                                  }
                                              };
                                    t
                                        ? u()
                                        : (x.Deferred.getStackHook &&
                                              (u.stackTrace =
                                                  x.Deferred.getStackHook()),
                                          e.setTimeout(u));
                                };
                            }
                            return x
                                .Deferred(function (e) {
                                    n[0][3].add(
                                        a(0, e, h(i) ? i : q, e.notifyWith)
                                    ),
                                        n[1][3].add(a(0, e, h(t) ? t : q)),
                                        n[2][3].add(a(0, e, h(o) ? o : H));
                                })
                                .promise();
                        },
                        promise: function (e) {
                            return null != e ? x.extend(e, i) : i;
                        },
                    },
                    r = {};
                return (
                    x.each(n, function (e, t) {
                        var a = t[2],
                            s = t[5];
                        (i[t[1]] = a.add),
                            s &&
                                a.add(
                                    function () {
                                        o = s;
                                    },
                                    n[3 - e][2].disable,
                                    n[3 - e][3].disable,
                                    n[0][2].lock,
                                    n[0][3].lock
                                ),
                            a.add(t[3].fire),
                            (r[t[0]] = function () {
                                return (
                                    r[t[0] + "With"](
                                        this === r ? void 0 : this,
                                        arguments
                                    ),
                                    this
                                );
                            }),
                            (r[t[0] + "With"] = a.fireWith);
                    }),
                    i.promise(r),
                    t && t.call(r, r),
                    r
                );
            },
            when: function (e) {
                var t = arguments.length,
                    n = t,
                    o = Array(n),
                    r = i.call(arguments),
                    a = x.Deferred(),
                    s = function (e) {
                        return function (n) {
                            (o[e] = this),
                                (r[e] =
                                    1 < arguments.length
                                        ? i.call(arguments)
                                        : n),
                                --t || a.resolveWith(o, r);
                        };
                    };
                if (
                    t <= 1 &&
                    (B(e, a.done(s(n)).resolve, a.reject, !t),
                    "pending" === a.state() || h(r[n] && r[n].then))
                )
                    return a.then();
                for (; n--; ) B(r[n], s(n), a.reject);
                return a.promise();
            },
        });
    var M = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    (x.Deferred.exceptionHook = function (t, n) {
        e.console &&
            e.console.warn &&
            t &&
            M.test(t.name) &&
            e.console.warn(
                "jQuery.Deferred exception: " + t.message,
                t.stack,
                n
            );
    }),
        (x.readyException = function (t) {
            e.setTimeout(function () {
                throw t;
            });
        });
    var R = x.Deferred();
    function F() {
        g.removeEventListener("DOMContentLoaded", F),
            e.removeEventListener("load", F),
            x.ready();
    }
    (x.fn.ready = function (e) {
        return (
            R.then(e).catch(function (e) {
                x.readyException(e);
            }),
            this
        );
    }),
        x.extend({
            isReady: !1,
            readyWait: 1,
            ready: function (e) {
                (!0 === e ? --x.readyWait : x.isReady) ||
                    ((x.isReady = !0) !== e && 0 < --x.readyWait) ||
                    R.resolveWith(g, [x]);
            },
        }),
        (x.ready.then = R.then),
        "complete" === g.readyState ||
        ("loading" !== g.readyState && !g.documentElement.doScroll)
            ? e.setTimeout(x.ready)
            : (g.addEventListener("DOMContentLoaded", F),
              e.addEventListener("load", F));
    var W = function (e, t, n, o, i, r, a) {
            var s = 0,
                l = e.length,
                c = null == n;
            if ("object" === b(n))
                for (s in ((i = !0), n)) W(e, t, s, n[s], !0, r, a);
            else if (
                void 0 !== o &&
                ((i = !0),
                h(o) || (a = !0),
                c &&
                    (a
                        ? (t.call(e, o), (t = null))
                        : ((c = t),
                          (t = function (e, t, n) {
                              return c.call(x(e), n);
                          }))),
                t)
            )
                for (; s < l; s++)
                    t(e[s], n, a ? o : o.call(e[s], s, t(e[s], n)));
            return i ? e : c ? t.call(e) : l ? t(e[0], n) : r;
        },
        z = /^-ms-/,
        U = /-([a-z])/g;
    function V(e, t) {
        return t.toUpperCase();
    }
    function $(e) {
        return e.replace(z, "ms-").replace(U, V);
    }
    var Y = function (e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType;
    };
    function Q() {
        this.expando = x.expando + Q.uid++;
    }
    (Q.uid = 1),
        (Q.prototype = {
            cache: function (e) {
                var t = e[this.expando];
                return (
                    t ||
                        ((t = {}),
                        Y(e) &&
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
                var o,
                    i = this.cache(e);
                if ("string" == typeof t) i[$(t)] = n;
                else for (o in t) i[$(o)] = t[o];
                return i;
            },
            get: function (e, t) {
                return void 0 === t
                    ? this.cache(e)
                    : e[this.expando] && e[this.expando][$(t)];
            },
            access: function (e, t, n) {
                return void 0 === t ||
                    (t && "string" == typeof t && void 0 === n)
                    ? this.get(e, t)
                    : (this.set(e, t, n), void 0 !== n ? n : t);
            },
            remove: function (e, t) {
                var n,
                    o = e[this.expando];
                if (void 0 !== o) {
                    if (void 0 !== t) {
                        n = (t = Array.isArray(t)
                            ? t.map($)
                            : (t = $(t)) in o
                            ? [t]
                            : t.match(I) || []).length;
                        for (; n--; ) delete o[t[n]];
                    }
                    (void 0 === t || x.isEmptyObject(o)) &&
                        (e.nodeType
                            ? (e[this.expando] = void 0)
                            : delete e[this.expando]);
                }
            },
            hasData: function (e) {
                var t = e[this.expando];
                return void 0 !== t && !x.isEmptyObject(t);
            },
        });
    var X = new Q(),
        K = new Q(),
        Z = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        G = /[A-Z]/g;
    function J(e, t, n) {
        var o, i;
        if (void 0 === n && 1 === e.nodeType)
            if (
                ((o = "data-" + t.replace(G, "-$&").toLowerCase()),
                "string" == typeof (n = e.getAttribute(o)))
            ) {
                try {
                    n =
                        "true" === (i = n) ||
                        ("false" !== i &&
                            ("null" === i
                                ? null
                                : i === +i + ""
                                ? +i
                                : Z.test(i)
                                ? JSON.parse(i)
                                : i));
                } catch (e) {}
                K.set(e, t, n);
            } else n = void 0;
        return n;
    }
    x.extend({
        hasData: function (e) {
            return K.hasData(e) || X.hasData(e);
        },
        data: function (e, t, n) {
            return K.access(e, t, n);
        },
        removeData: function (e, t) {
            K.remove(e, t);
        },
        _data: function (e, t, n) {
            return X.access(e, t, n);
        },
        _removeData: function (e, t) {
            X.remove(e, t);
        },
    }),
        x.fn.extend({
            data: function (e, t) {
                var n,
                    o,
                    i,
                    r = this[0],
                    a = r && r.attributes;
                if (void 0 === e) {
                    if (
                        this.length &&
                        ((i = K.get(r)),
                        1 === r.nodeType && !X.get(r, "hasDataAttrs"))
                    ) {
                        for (n = a.length; n--; )
                            a[n] &&
                                0 === (o = a[n].name).indexOf("data-") &&
                                ((o = $(o.slice(5))), J(r, o, i[o]));
                        X.set(r, "hasDataAttrs", !0);
                    }
                    return i;
                }
                return "object" == typeof e
                    ? this.each(function () {
                          K.set(this, e);
                      })
                    : W(
                          this,
                          function (t) {
                              var n;
                              if (r && void 0 === t)
                                  return void 0 !== (n = K.get(r, e))
                                      ? n
                                      : void 0 !== (n = J(r, e))
                                      ? n
                                      : void 0;
                              this.each(function () {
                                  K.set(this, e, t);
                              });
                          },
                          null,
                          t,
                          1 < arguments.length,
                          null,
                          !0
                      );
            },
            removeData: function (e) {
                return this.each(function () {
                    K.remove(this, e);
                });
            },
        }),
        x.extend({
            queue: function (e, t, n) {
                var o;
                if (e)
                    return (
                        (t = (t || "fx") + "queue"),
                        (o = X.get(e, t)),
                        n &&
                            (!o || Array.isArray(n)
                                ? (o = X.access(e, t, x.makeArray(n)))
                                : o.push(n)),
                        o || []
                    );
            },
            dequeue: function (e, t) {
                t = t || "fx";
                var n = x.queue(e, t),
                    o = n.length,
                    i = n.shift(),
                    r = x._queueHooks(e, t);
                "inprogress" === i && ((i = n.shift()), o--),
                    i &&
                        ("fx" === t && n.unshift("inprogress"),
                        delete r.stop,
                        i.call(
                            e,
                            function () {
                                x.dequeue(e, t);
                            },
                            r
                        )),
                    !o && r && r.empty.fire();
            },
            _queueHooks: function (e, t) {
                var n = t + "queueHooks";
                return (
                    X.get(e, n) ||
                    X.access(e, n, {
                        empty: x.Callbacks("once memory").add(function () {
                            X.remove(e, [t + "queue", n]);
                        }),
                    })
                );
            },
        }),
        x.fn.extend({
            queue: function (e, t) {
                var n = 2;
                return (
                    "string" != typeof e && ((t = e), (e = "fx"), n--),
                    arguments.length < n
                        ? x.queue(this[0], e)
                        : void 0 === t
                        ? this
                        : this.each(function () {
                              var n = x.queue(this, e, t);
                              x._queueHooks(this, e),
                                  "fx" === e &&
                                      "inprogress" !== n[0] &&
                                      x.dequeue(this, e);
                          })
                );
            },
            dequeue: function (e) {
                return this.each(function () {
                    x.dequeue(this, e);
                });
            },
            clearQueue: function (e) {
                return this.queue(e || "fx", []);
            },
            promise: function (e, t) {
                var n,
                    o = 1,
                    i = x.Deferred(),
                    r = this,
                    a = this.length,
                    s = function () {
                        --o || i.resolveWith(r, [r]);
                    };
                for (
                    "string" != typeof e && ((t = e), (e = void 0)),
                        e = e || "fx";
                    a--;

                )
                    (n = X.get(r[a], e + "queueHooks")) &&
                        n.empty &&
                        (o++, n.empty.add(s));
                return s(), i.promise(t);
            },
        });
    var ee = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        te = new RegExp("^(?:([+-])=|)(" + ee + ")([a-z%]*)$", "i"),
        ne = ["Top", "Right", "Bottom", "Left"],
        oe = g.documentElement,
        ie = function (e) {
            return x.contains(e.ownerDocument, e);
        },
        re = { composed: !0 };
    oe.getRootNode &&
        (ie = function (e) {
            return (
                x.contains(e.ownerDocument, e) ||
                e.getRootNode(re) === e.ownerDocument
            );
        });
    var ae = function (e, t) {
        return (
            "none" === (e = t || e).style.display ||
            ("" === e.style.display && ie(e) && "none" === x.css(e, "display"))
        );
    };
    function se(e, t, n, o) {
        var i,
            r,
            a = 20,
            s = o
                ? function () {
                      return o.cur();
                  }
                : function () {
                      return x.css(e, t, "");
                  },
            l = s(),
            c = (n && n[3]) || (x.cssNumber[t] ? "" : "px"),
            u =
                e.nodeType &&
                (x.cssNumber[t] || ("px" !== c && +l)) &&
                te.exec(x.css(e, t));
        if (u && u[3] !== c) {
            for (l /= 2, c = c || u[3], u = +l || 1; a--; )
                x.style(e, t, u + c),
                    (1 - r) * (1 - (r = s() / l || 0.5)) <= 0 && (a = 0),
                    (u /= r);
            (u *= 2), x.style(e, t, u + c), (n = n || []);
        }
        return (
            n &&
                ((u = +u || +l || 0),
                (i = n[1] ? u + (n[1] + 1) * n[2] : +n[2]),
                o && ((o.unit = c), (o.start = u), (o.end = i))),
            i
        );
    }
    var le = {};
    function ce(e, t) {
        for (var n, o, i, r, a, s, l, c = [], u = 0, d = e.length; u < d; u++)
            (o = e[u]).style &&
                ((n = o.style.display),
                t
                    ? ("none" === n &&
                          ((c[u] = X.get(o, "display") || null),
                          c[u] || (o.style.display = "")),
                      "" === o.style.display &&
                          ae(o) &&
                          (c[u] =
                              ((l = a = r = void 0),
                              (a = (i = o).ownerDocument),
                              (s = i.nodeName),
                              (l = le[s]) ||
                                  ((r = a.body.appendChild(a.createElement(s))),
                                  (l = x.css(r, "display")),
                                  r.parentNode.removeChild(r),
                                  "none" === l && (l = "block"),
                                  (le[s] = l)))))
                    : "none" !== n &&
                      ((c[u] = "none"), X.set(o, "display", n)));
        for (u = 0; u < d; u++) null != c[u] && (e[u].style.display = c[u]);
        return e;
    }
    x.fn.extend({
        show: function () {
            return ce(this, !0);
        },
        hide: function () {
            return ce(this);
        },
        toggle: function (e) {
            return "boolean" == typeof e
                ? e
                    ? this.show()
                    : this.hide()
                : this.each(function () {
                      ae(this) ? x(this).show() : x(this).hide();
                  });
        },
    });
    var ue,
        de,
        fe = /^(?:checkbox|radio)$/i,
        pe = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        he = /^$|^module$|\/(?:java|ecma)script/i;
    (ue = g.createDocumentFragment().appendChild(g.createElement("div"))),
        (de = g.createElement("input")).setAttribute("type", "radio"),
        de.setAttribute("checked", "checked"),
        de.setAttribute("name", "t"),
        ue.appendChild(de),
        (p.checkClone = ue.cloneNode(!0).cloneNode(!0).lastChild.checked),
        (ue.innerHTML = "<textarea>x</textarea>"),
        (p.noCloneChecked = !!ue.cloneNode(!0).lastChild.defaultValue),
        (ue.innerHTML = "<option></option>"),
        (p.option = !!ue.lastChild);
    var me = {
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""],
    };
    function ge(e, t) {
        var n;
        return (
            (n =
                void 0 !== e.getElementsByTagName
                    ? e.getElementsByTagName(t || "*")
                    : void 0 !== e.querySelectorAll
                    ? e.querySelectorAll(t || "*")
                    : []),
            void 0 === t || (t && S(e, t)) ? x.merge([e], n) : n
        );
    }
    function we(e, t) {
        for (var n = 0, o = e.length; n < o; n++)
            X.set(e[n], "globalEval", !t || X.get(t[n], "globalEval"));
    }
    (me.tbody = me.tfoot = me.colgroup = me.caption = me.thead),
        (me.th = me.td),
        p.option ||
            (me.optgroup = me.option =
                [1, "<select multiple='multiple'>", "</select>"]);
    var ve = /<|&#?\w+;/;
    function be(e, t, n, o, i) {
        for (
            var r,
                a,
                s,
                l,
                c,
                u,
                d = t.createDocumentFragment(),
                f = [],
                p = 0,
                h = e.length;
            p < h;
            p++
        )
            if ((r = e[p]) || 0 === r)
                if ("object" === b(r)) x.merge(f, r.nodeType ? [r] : r);
                else if (ve.test(r)) {
                    for (
                        a = a || d.appendChild(t.createElement("div")),
                            s = (pe.exec(r) || ["", ""])[1].toLowerCase(),
                            l = me[s] || me._default,
                            a.innerHTML = l[1] + x.htmlPrefilter(r) + l[2],
                            u = l[0];
                        u--;

                    )
                        a = a.lastChild;
                    x.merge(f, a.childNodes),
                        ((a = d.firstChild).textContent = "");
                } else f.push(t.createTextNode(r));
        for (d.textContent = "", p = 0; (r = f[p++]); )
            if (o && -1 < x.inArray(r, o)) i && i.push(r);
            else if (
                ((c = ie(r)),
                (a = ge(d.appendChild(r), "script")),
                c && we(a),
                n)
            )
                for (u = 0; (r = a[u++]); ) he.test(r.type || "") && n.push(r);
        return d;
    }
    var ye = /^key/,
        xe = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
        _e = /^([^.]*)(?:\.(.+)|)/;
    function ke() {
        return !0;
    }
    function Ce() {
        return !1;
    }
    function Ee(e, t) {
        return (
            (e ===
                (function () {
                    try {
                        return g.activeElement;
                    } catch (e) {}
                })()) ==
            ("focus" === t)
        );
    }
    function Te(e, t, n, o, i, r) {
        var a, s;
        if ("object" == typeof t) {
            for (s in ("string" != typeof n && ((o = o || n), (n = void 0)), t))
                Te(e, s, n, o, t[s], r);
            return e;
        }
        if (
            (null == o && null == i
                ? ((i = n), (o = n = void 0))
                : null == i &&
                  ("string" == typeof n
                      ? ((i = o), (o = void 0))
                      : ((i = o), (o = n), (n = void 0))),
            !1 === i)
        )
            i = Ce;
        else if (!i) return e;
        return (
            1 === r &&
                ((a = i),
                ((i = function (e) {
                    return x().off(e), a.apply(this, arguments);
                }).guid = a.guid || (a.guid = x.guid++))),
            e.each(function () {
                x.event.add(this, t, i, o, n);
            })
        );
    }
    function Se(e, t, n) {
        n
            ? (X.set(e, t, !1),
              x.event.add(e, t, {
                  namespace: !1,
                  handler: function (e) {
                      var o,
                          r,
                          a = X.get(this, t);
                      if (1 & e.isTrigger && this[t]) {
                          if (a.length)
                              (x.event.special[t] || {}).delegateType &&
                                  e.stopPropagation();
                          else if (
                              ((a = i.call(arguments)),
                              X.set(this, t, a),
                              (o = n(this, t)),
                              this[t](),
                              a !== (r = X.get(this, t)) || o
                                  ? X.set(this, t, !1)
                                  : (r = {}),
                              a !== r)
                          )
                              return (
                                  e.stopImmediatePropagation(),
                                  e.preventDefault(),
                                  r.value
                              );
                      } else
                          a.length &&
                              (X.set(this, t, {
                                  value: x.event.trigger(
                                      x.extend(a[0], x.Event.prototype),
                                      a.slice(1),
                                      this
                                  ),
                              }),
                              e.stopImmediatePropagation());
                  },
              }))
            : void 0 === X.get(e, t) && x.event.add(e, t, ke);
    }
    (x.event = {
        global: {},
        add: function (e, t, n, o, i) {
            var r,
                a,
                s,
                l,
                c,
                u,
                d,
                f,
                p,
                h,
                m,
                g = X.get(e);
            if (Y(e))
                for (
                    n.handler && ((n = (r = n).handler), (i = r.selector)),
                        i && x.find.matchesSelector(oe, i),
                        n.guid || (n.guid = x.guid++),
                        (l = g.events) || (l = g.events = Object.create(null)),
                        (a = g.handle) ||
                            (a = g.handle =
                                function (t) {
                                    return void 0 !== x &&
                                        x.event.triggered !== t.type
                                        ? x.event.dispatch.apply(e, arguments)
                                        : void 0;
                                }),
                        c = (t = (t || "").match(I) || [""]).length;
                    c--;

                )
                    (p = m = (s = _e.exec(t[c]) || [])[1]),
                        (h = (s[2] || "").split(".").sort()),
                        p &&
                            ((d = x.event.special[p] || {}),
                            (p = (i ? d.delegateType : d.bindType) || p),
                            (d = x.event.special[p] || {}),
                            (u = x.extend(
                                {
                                    type: p,
                                    origType: m,
                                    data: o,
                                    handler: n,
                                    guid: n.guid,
                                    selector: i,
                                    needsContext:
                                        i && x.expr.match.needsContext.test(i),
                                    namespace: h.join("."),
                                },
                                r
                            )),
                            (f = l[p]) ||
                                (((f = l[p] = []).delegateCount = 0),
                                (d.setup && !1 !== d.setup.call(e, o, h, a)) ||
                                    (e.addEventListener &&
                                        e.addEventListener(p, a))),
                            d.add &&
                                (d.add.call(e, u),
                                u.handler.guid || (u.handler.guid = n.guid)),
                            i ? f.splice(f.delegateCount++, 0, u) : f.push(u),
                            (x.event.global[p] = !0));
        },
        remove: function (e, t, n, o, i) {
            var r,
                a,
                s,
                l,
                c,
                u,
                d,
                f,
                p,
                h,
                m,
                g = X.hasData(e) && X.get(e);
            if (g && (l = g.events)) {
                for (c = (t = (t || "").match(I) || [""]).length; c--; )
                    if (
                        ((p = m = (s = _e.exec(t[c]) || [])[1]),
                        (h = (s[2] || "").split(".").sort()),
                        p)
                    ) {
                        for (
                            d = x.event.special[p] || {},
                                f =
                                    l[
                                        (p =
                                            (o ? d.delegateType : d.bindType) ||
                                            p)
                                    ] || [],
                                s =
                                    s[2] &&
                                    new RegExp(
                                        "(^|\\.)" +
                                            h.join("\\.(?:.*\\.|)") +
                                            "(\\.|$)"
                                    ),
                                a = r = f.length;
                            r--;

                        )
                            (u = f[r]),
                                (!i && m !== u.origType) ||
                                    (n && n.guid !== u.guid) ||
                                    (s && !s.test(u.namespace)) ||
                                    (o &&
                                        o !== u.selector &&
                                        ("**" !== o || !u.selector)) ||
                                    (f.splice(r, 1),
                                    u.selector && f.delegateCount--,
                                    d.remove && d.remove.call(e, u));
                        a &&
                            !f.length &&
                            ((d.teardown &&
                                !1 !== d.teardown.call(e, h, g.handle)) ||
                                x.removeEvent(e, p, g.handle),
                            delete l[p]);
                    } else for (p in l) x.event.remove(e, p + t[c], n, o, !0);
                x.isEmptyObject(l) && X.remove(e, "handle events");
            }
        },
        dispatch: function (e) {
            var t,
                n,
                o,
                i,
                r,
                a,
                s = new Array(arguments.length),
                l = x.event.fix(e),
                c =
                    (X.get(this, "events") || Object.create(null))[l.type] ||
                    [],
                u = x.event.special[l.type] || {};
            for (s[0] = l, t = 1; t < arguments.length; t++)
                s[t] = arguments[t];
            if (
                ((l.delegateTarget = this),
                !u.preDispatch || !1 !== u.preDispatch.call(this, l))
            ) {
                for (
                    a = x.event.handlers.call(this, l, c), t = 0;
                    (i = a[t++]) && !l.isPropagationStopped();

                )
                    for (
                        l.currentTarget = i.elem, n = 0;
                        (r = i.handlers[n++]) &&
                        !l.isImmediatePropagationStopped();

                    )
                        (l.rnamespace &&
                            !1 !== r.namespace &&
                            !l.rnamespace.test(r.namespace)) ||
                            ((l.handleObj = r),
                            (l.data = r.data),
                            void 0 !==
                                (o = (
                                    (x.event.special[r.origType] || {})
                                        .handle || r.handler
                                ).apply(i.elem, s)) &&
                                !1 === (l.result = o) &&
                                (l.preventDefault(), l.stopPropagation()));
                return u.postDispatch && u.postDispatch.call(this, l), l.result;
            }
        },
        handlers: function (e, t) {
            var n,
                o,
                i,
                r,
                a,
                s = [],
                l = t.delegateCount,
                c = e.target;
            if (l && c.nodeType && !("click" === e.type && 1 <= e.button))
                for (; c !== this; c = c.parentNode || this)
                    if (
                        1 === c.nodeType &&
                        ("click" !== e.type || !0 !== c.disabled)
                    ) {
                        for (r = [], a = {}, n = 0; n < l; n++)
                            void 0 === a[(i = (o = t[n]).selector + " ")] &&
                                (a[i] = o.needsContext
                                    ? -1 < x(i, this).index(c)
                                    : x.find(i, this, null, [c]).length),
                                a[i] && r.push(o);
                        r.length && s.push({ elem: c, handlers: r });
                    }
            return (
                (c = this),
                l < t.length && s.push({ elem: c, handlers: t.slice(l) }),
                s
            );
        },
        addProp: function (e, t) {
            Object.defineProperty(x.Event.prototype, e, {
                enumerable: !0,
                configurable: !0,
                get: h(t)
                    ? function () {
                          if (this.originalEvent) return t(this.originalEvent);
                      }
                    : function () {
                          if (this.originalEvent) return this.originalEvent[e];
                      },
                set: function (t) {
                    Object.defineProperty(this, e, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: t,
                    });
                },
            });
        },
        fix: function (e) {
            return e[x.expando] ? e : new x.Event(e);
        },
        special: {
            load: { noBubble: !0 },
            click: {
                setup: function (e) {
                    var t = this || e;
                    return (
                        fe.test(t.type) &&
                            t.click &&
                            S(t, "input") &&
                            Se(t, "click", ke),
                        !1
                    );
                },
                trigger: function (e) {
                    var t = this || e;
                    return (
                        fe.test(t.type) &&
                            t.click &&
                            S(t, "input") &&
                            Se(t, "click"),
                        !0
                    );
                },
                _default: function (e) {
                    var t = e.target;
                    return (
                        (fe.test(t.type) &&
                            t.click &&
                            S(t, "input") &&
                            X.get(t, "click")) ||
                        S(t, "a")
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
        (x.removeEvent = function (e, t, n) {
            e.removeEventListener && e.removeEventListener(t, n);
        }),
        (x.Event = function (e, t) {
            if (!(this instanceof x.Event)) return new x.Event(e, t);
            e && e.type
                ? ((this.originalEvent = e),
                  (this.type = e.type),
                  (this.isDefaultPrevented =
                      e.defaultPrevented ||
                      (void 0 === e.defaultPrevented && !1 === e.returnValue)
                          ? ke
                          : Ce),
                  (this.target =
                      e.target && 3 === e.target.nodeType
                          ? e.target.parentNode
                          : e.target),
                  (this.currentTarget = e.currentTarget),
                  (this.relatedTarget = e.relatedTarget))
                : (this.type = e),
                t && x.extend(this, t),
                (this.timeStamp = (e && e.timeStamp) || Date.now()),
                (this[x.expando] = !0);
        }),
        (x.Event.prototype = {
            constructor: x.Event,
            isDefaultPrevented: Ce,
            isPropagationStopped: Ce,
            isImmediatePropagationStopped: Ce,
            isSimulated: !1,
            preventDefault: function () {
                var e = this.originalEvent;
                (this.isDefaultPrevented = ke),
                    e && !this.isSimulated && e.preventDefault();
            },
            stopPropagation: function () {
                var e = this.originalEvent;
                (this.isPropagationStopped = ke),
                    e && !this.isSimulated && e.stopPropagation();
            },
            stopImmediatePropagation: function () {
                var e = this.originalEvent;
                (this.isImmediatePropagationStopped = ke),
                    e && !this.isSimulated && e.stopImmediatePropagation(),
                    this.stopPropagation();
            },
        }),
        x.each(
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
                which: function (e) {
                    var t = e.button;
                    return null == e.which && ye.test(e.type)
                        ? null != e.charCode
                            ? e.charCode
                            : e.keyCode
                        : !e.which && void 0 !== t && xe.test(e.type)
                        ? 1 & t
                            ? 1
                            : 2 & t
                            ? 3
                            : 4 & t
                            ? 2
                            : 0
                        : e.which;
                },
            },
            x.event.addProp
        ),
        x.each({ focus: "focusin", blur: "focusout" }, function (e, t) {
            x.event.special[e] = {
                setup: function () {
                    return Se(this, e, Ee), !1;
                },
                trigger: function () {
                    return Se(this, e), !0;
                },
                delegateType: t,
            };
        }),
        x.each(
            {
                mouseenter: "mouseover",
                mouseleave: "mouseout",
                pointerenter: "pointerover",
                pointerleave: "pointerout",
            },
            function (e, t) {
                x.event.special[e] = {
                    delegateType: t,
                    bindType: t,
                    handle: function (e) {
                        var n,
                            o = e.relatedTarget,
                            i = e.handleObj;
                        return (
                            (o && (o === this || x.contains(this, o))) ||
                                ((e.type = i.origType),
                                (n = i.handler.apply(this, arguments)),
                                (e.type = t)),
                            n
                        );
                    },
                };
            }
        ),
        x.fn.extend({
            on: function (e, t, n, o) {
                return Te(this, e, t, n, o);
            },
            one: function (e, t, n, o) {
                return Te(this, e, t, n, o, 1);
            },
            off: function (e, t, n) {
                var o, i;
                if (e && e.preventDefault && e.handleObj)
                    return (
                        (o = e.handleObj),
                        x(e.delegateTarget).off(
                            o.namespace
                                ? o.origType + "." + o.namespace
                                : o.origType,
                            o.selector,
                            o.handler
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
                    !1 === n && (n = Ce),
                    this.each(function () {
                        x.event.remove(this, e, n, t);
                    })
                );
            },
        });
    var Ae = /<script|<style|<link/i,
        De = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Ne = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;
    function je(e, t) {
        return (
            (S(e, "table") &&
                S(11 !== t.nodeType ? t : t.firstChild, "tr") &&
                x(e).children("tbody")[0]) ||
            e
        );
    }
    function Oe(e) {
        return (e.type = (null !== e.getAttribute("type")) + "/" + e.type), e;
    }
    function Le(e) {
        return (
            "true/" === (e.type || "").slice(0, 5)
                ? (e.type = e.type.slice(5))
                : e.removeAttribute("type"),
            e
        );
    }
    function Pe(e, t) {
        var n, o, i, r, a, s;
        if (1 === t.nodeType) {
            if (X.hasData(e) && (s = X.get(e).events))
                for (i in (X.remove(t, "handle events"), s))
                    for (n = 0, o = s[i].length; n < o; n++)
                        x.event.add(t, i, s[i][n]);
            K.hasData(e) &&
                ((r = K.access(e)), (a = x.extend({}, r)), K.set(t, a));
        }
    }
    function Ie(e, t, n, o) {
        t = r(t);
        var i,
            a,
            s,
            l,
            c,
            u,
            d = 0,
            f = e.length,
            m = f - 1,
            g = t[0],
            w = h(g);
        if (w || (1 < f && "string" == typeof g && !p.checkClone && De.test(g)))
            return e.each(function (i) {
                var r = e.eq(i);
                w && (t[0] = g.call(this, i, r.html())), Ie(r, t, n, o);
            });
        if (
            f &&
            ((a = (i = be(t, e[0].ownerDocument, !1, e, o)).firstChild),
            1 === i.childNodes.length && (i = a),
            a || o)
        ) {
            for (l = (s = x.map(ge(i, "script"), Oe)).length; d < f; d++)
                (c = i),
                    d !== m &&
                        ((c = x.clone(c, !0, !0)),
                        l && x.merge(s, ge(c, "script"))),
                    n.call(e[d], c, d);
            if (l)
                for (
                    u = s[s.length - 1].ownerDocument, x.map(s, Le), d = 0;
                    d < l;
                    d++
                )
                    (c = s[d]),
                        he.test(c.type || "") &&
                            !X.access(c, "globalEval") &&
                            x.contains(u, c) &&
                            (c.src && "module" !== (c.type || "").toLowerCase()
                                ? x._evalUrl &&
                                  !c.noModule &&
                                  x._evalUrl(
                                      c.src,
                                      {
                                          nonce:
                                              c.nonce ||
                                              c.getAttribute("nonce"),
                                      },
                                      u
                                  )
                                : v(c.textContent.replace(Ne, ""), c, u));
        }
        return e;
    }
    function qe(e, t, n) {
        for (var o, i = t ? x.filter(t, e) : e, r = 0; null != (o = i[r]); r++)
            n || 1 !== o.nodeType || x.cleanData(ge(o)),
                o.parentNode &&
                    (n && ie(o) && we(ge(o, "script")),
                    o.parentNode.removeChild(o));
        return e;
    }
    x.extend({
        htmlPrefilter: function (e) {
            return e;
        },
        clone: function (e, t, n) {
            var o,
                i,
                r,
                a,
                s,
                l,
                c,
                u = e.cloneNode(!0),
                d = ie(e);
            if (
                !(
                    p.noCloneChecked ||
                    (1 !== e.nodeType && 11 !== e.nodeType) ||
                    x.isXMLDoc(e)
                )
            )
                for (a = ge(u), o = 0, i = (r = ge(e)).length; o < i; o++)
                    (s = r[o]),
                        "input" === (c = (l = a[o]).nodeName.toLowerCase()) &&
                        fe.test(s.type)
                            ? (l.checked = s.checked)
                            : ("input" !== c && "textarea" !== c) ||
                              (l.defaultValue = s.defaultValue);
            if (t)
                if (n)
                    for (
                        r = r || ge(e), a = a || ge(u), o = 0, i = r.length;
                        o < i;
                        o++
                    )
                        Pe(r[o], a[o]);
                else Pe(e, u);
            return (
                0 < (a = ge(u, "script")).length &&
                    we(a, !d && ge(e, "script")),
                u
            );
        },
        cleanData: function (e) {
            for (
                var t, n, o, i = x.event.special, r = 0;
                void 0 !== (n = e[r]);
                r++
            )
                if (Y(n)) {
                    if ((t = n[X.expando])) {
                        if (t.events)
                            for (o in t.events)
                                i[o]
                                    ? x.event.remove(n, o)
                                    : x.removeEvent(n, o, t.handle);
                        n[X.expando] = void 0;
                    }
                    n[K.expando] && (n[K.expando] = void 0);
                }
        },
    }),
        x.fn.extend({
            detach: function (e) {
                return qe(this, e, !0);
            },
            remove: function (e) {
                return qe(this, e);
            },
            text: function (e) {
                return W(
                    this,
                    function (e) {
                        return void 0 === e
                            ? x.text(this)
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
                return Ie(this, arguments, function (e) {
                    (1 !== this.nodeType &&
                        11 !== this.nodeType &&
                        9 !== this.nodeType) ||
                        je(this, e).appendChild(e);
                });
            },
            prepend: function () {
                return Ie(this, arguments, function (e) {
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
                return Ie(this, arguments, function (e) {
                    this.parentNode && this.parentNode.insertBefore(e, this);
                });
            },
            after: function () {
                return Ie(this, arguments, function (e) {
                    this.parentNode &&
                        this.parentNode.insertBefore(e, this.nextSibling);
                });
            },
            empty: function () {
                for (var e, t = 0; null != (e = this[t]); t++)
                    1 === e.nodeType &&
                        (x.cleanData(ge(e, !1)), (e.textContent = ""));
                return this;
            },
            clone: function (e, t) {
                return (
                    (e = null != e && e),
                    (t = null == t ? e : t),
                    this.map(function () {
                        return x.clone(this, e, t);
                    })
                );
            },
            html: function (e) {
                return W(
                    this,
                    function (e) {
                        var t = this[0] || {},
                            n = 0,
                            o = this.length;
                        if (void 0 === e && 1 === t.nodeType)
                            return t.innerHTML;
                        if (
                            "string" == typeof e &&
                            !Ae.test(e) &&
                            !me[(pe.exec(e) || ["", ""])[1].toLowerCase()]
                        ) {
                            e = x.htmlPrefilter(e);
                            try {
                                for (; n < o; n++)
                                    1 === (t = this[n] || {}).nodeType &&
                                        (x.cleanData(ge(t, !1)),
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
                var e = [];
                return Ie(
                    this,
                    arguments,
                    function (t) {
                        var n = this.parentNode;
                        x.inArray(this, e) < 0 &&
                            (x.cleanData(ge(this)),
                            n && n.replaceChild(t, this));
                    },
                    e
                );
            },
        }),
        x.each(
            {
                appendTo: "append",
                prependTo: "prepend",
                insertBefore: "before",
                insertAfter: "after",
                replaceAll: "replaceWith",
            },
            function (e, t) {
                x.fn[e] = function (e) {
                    for (
                        var n, o = [], i = x(e), r = i.length - 1, s = 0;
                        s <= r;
                        s++
                    )
                        (n = s === r ? this : this.clone(!0)),
                            x(i[s])[t](n),
                            a.apply(o, n.get());
                    return this.pushStack(o);
                };
            }
        );
    var He = new RegExp("^(" + ee + ")(?!px)[a-z%]+$", "i"),
        Be = function (t) {
            var n = t.ownerDocument.defaultView;
            return (n && n.opener) || (n = e), n.getComputedStyle(t);
        },
        Me = function (e, t, n) {
            var o,
                i,
                r = {};
            for (i in t) (r[i] = e.style[i]), (e.style[i] = t[i]);
            for (i in ((o = n.call(e)), t)) e.style[i] = r[i];
            return o;
        },
        Re = new RegExp(ne.join("|"), "i");
    function Fe(e, t, n) {
        var o,
            i,
            r,
            a,
            s = e.style;
        return (
            (n = n || Be(e)) &&
                ("" !== (a = n.getPropertyValue(t) || n[t]) ||
                    ie(e) ||
                    (a = x.style(e, t)),
                !p.pixelBoxStyles() &&
                    He.test(a) &&
                    Re.test(t) &&
                    ((o = s.width),
                    (i = s.minWidth),
                    (r = s.maxWidth),
                    (s.minWidth = s.maxWidth = s.width = a),
                    (a = n.width),
                    (s.width = o),
                    (s.minWidth = i),
                    (s.maxWidth = r))),
            void 0 !== a ? a + "" : a
        );
    }
    function We(e, t) {
        return {
            get: function () {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get;
            },
        };
    }
    !(function () {
        function t() {
            if (u) {
                (c.style.cssText =
                    "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0"),
                    (u.style.cssText =
                        "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%"),
                    oe.appendChild(c).appendChild(u);
                var t = e.getComputedStyle(u);
                (o = "1%" !== t.top),
                    (l = 12 === n(t.marginLeft)),
                    (u.style.right = "60%"),
                    (a = 36 === n(t.right)),
                    (i = 36 === n(t.width)),
                    (u.style.position = "absolute"),
                    (r = 12 === n(u.offsetWidth / 3)),
                    oe.removeChild(c),
                    (u = null);
            }
        }
        function n(e) {
            return Math.round(parseFloat(e));
        }
        var o,
            i,
            r,
            a,
            s,
            l,
            c = g.createElement("div"),
            u = g.createElement("div");
        u.style &&
            ((u.style.backgroundClip = "content-box"),
            (u.cloneNode(!0).style.backgroundClip = ""),
            (p.clearCloneStyle = "content-box" === u.style.backgroundClip),
            x.extend(p, {
                boxSizingReliable: function () {
                    return t(), i;
                },
                pixelBoxStyles: function () {
                    return t(), a;
                },
                pixelPosition: function () {
                    return t(), o;
                },
                reliableMarginLeft: function () {
                    return t(), l;
                },
                scrollboxSize: function () {
                    return t(), r;
                },
                reliableTrDimensions: function () {
                    var t, n, o, i;
                    return (
                        null == s &&
                            ((t = g.createElement("table")),
                            (n = g.createElement("tr")),
                            (o = g.createElement("div")),
                            (t.style.cssText =
                                "position:absolute;left:-11111px"),
                            (n.style.height = "1px"),
                            (o.style.height = "9px"),
                            oe.appendChild(t).appendChild(n).appendChild(o),
                            (i = e.getComputedStyle(n)),
                            (s = 3 < parseInt(i.height)),
                            oe.removeChild(t)),
                        s
                    );
                },
            }));
    })();
    var ze = ["Webkit", "Moz", "ms"],
        Ue = g.createElement("div").style,
        Ve = {};
    function $e(e) {
        return (
            x.cssProps[e] ||
            Ve[e] ||
            (e in Ue
                ? e
                : (Ve[e] =
                      (function (e) {
                          for (
                              var t = e[0].toUpperCase() + e.slice(1),
                                  n = ze.length;
                              n--;

                          )
                              if ((e = ze[n] + t) in Ue) return e;
                      })(e) || e))
        );
    }
    var Ye = /^(none|table(?!-c[ea]).+)/,
        Qe = /^--/,
        Xe = { position: "absolute", visibility: "hidden", display: "block" },
        Ke = { letterSpacing: "0", fontWeight: "400" };
    function Ze(e, t, n) {
        var o = te.exec(t);
        return o ? Math.max(0, o[2] - (n || 0)) + (o[3] || "px") : t;
    }
    function Ge(e, t, n, o, i, r) {
        var a = "width" === t ? 1 : 0,
            s = 0,
            l = 0;
        if (n === (o ? "border" : "content")) return 0;
        for (; a < 4; a += 2)
            "margin" === n && (l += x.css(e, n + ne[a], !0, i)),
                o
                    ? ("content" === n &&
                          (l -= x.css(e, "padding" + ne[a], !0, i)),
                      "margin" !== n &&
                          (l -= x.css(e, "border" + ne[a] + "Width", !0, i)))
                    : ((l += x.css(e, "padding" + ne[a], !0, i)),
                      "padding" !== n
                          ? (l += x.css(e, "border" + ne[a] + "Width", !0, i))
                          : (s += x.css(e, "border" + ne[a] + "Width", !0, i)));
        return (
            !o &&
                0 <= r &&
                (l +=
                    Math.max(
                        0,
                        Math.ceil(
                            e["offset" + t[0].toUpperCase() + t.slice(1)] -
                                r -
                                l -
                                s -
                                0.5
                        )
                    ) || 0),
            l
        );
    }
    function Je(e, t, n) {
        var o = Be(e),
            i =
                (!p.boxSizingReliable() || n) &&
                "border-box" === x.css(e, "boxSizing", !1, o),
            r = i,
            a = Fe(e, t, o),
            s = "offset" + t[0].toUpperCase() + t.slice(1);
        if (He.test(a)) {
            if (!n) return a;
            a = "auto";
        }
        return (
            ((!p.boxSizingReliable() && i) ||
                (!p.reliableTrDimensions() && S(e, "tr")) ||
                "auto" === a ||
                (!parseFloat(a) && "inline" === x.css(e, "display", !1, o))) &&
                e.getClientRects().length &&
                ((i = "border-box" === x.css(e, "boxSizing", !1, o)),
                (r = s in e) && (a = e[s])),
            (a = parseFloat(a) || 0) +
                Ge(e, t, n || (i ? "border" : "content"), r, o, a) +
                "px"
        );
    }
    function et(e, t, n, o, i) {
        return new et.prototype.init(e, t, n, o, i);
    }
    x.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = Fe(e, "opacity");
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
        style: function (e, t, n, o) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var i,
                    r,
                    a,
                    s = $(t),
                    l = Qe.test(t),
                    c = e.style;
                if (
                    (l || (t = $e(s)),
                    (a = x.cssHooks[t] || x.cssHooks[s]),
                    void 0 === n)
                )
                    return a && "get" in a && void 0 !== (i = a.get(e, !1, o))
                        ? i
                        : c[t];
                "string" == (r = typeof n) &&
                    (i = te.exec(n)) &&
                    i[1] &&
                    ((n = se(e, t, i)), (r = "number")),
                    null != n &&
                        n == n &&
                        ("number" !== r ||
                            l ||
                            (n += (i && i[3]) || (x.cssNumber[s] ? "" : "px")),
                        p.clearCloneStyle ||
                            "" !== n ||
                            0 !== t.indexOf("background") ||
                            (c[t] = "inherit"),
                        (a && "set" in a && void 0 === (n = a.set(e, n, o))) ||
                            (l ? c.setProperty(t, n) : (c[t] = n)));
            }
        },
        css: function (e, t, n, o) {
            var i,
                r,
                a,
                s = $(t);
            return (
                Qe.test(t) || (t = $e(s)),
                (a = x.cssHooks[t] || x.cssHooks[s]) &&
                    "get" in a &&
                    (i = a.get(e, !0, n)),
                void 0 === i && (i = Fe(e, t, o)),
                "normal" === i && t in Ke && (i = Ke[t]),
                "" === n || n
                    ? ((r = parseFloat(i)),
                      !0 === n || isFinite(r) ? r || 0 : i)
                    : i
            );
        },
    }),
        x.each(["height", "width"], function (e, t) {
            x.cssHooks[t] = {
                get: function (e, n, o) {
                    if (n)
                        return !Ye.test(x.css(e, "display")) ||
                            (e.getClientRects().length &&
                                e.getBoundingClientRect().width)
                            ? Je(e, t, o)
                            : Me(e, Xe, function () {
                                  return Je(e, t, o);
                              });
                },
                set: function (e, n, o) {
                    var i,
                        r = Be(e),
                        a = !p.scrollboxSize() && "absolute" === r.position,
                        s =
                            (a || o) &&
                            "border-box" === x.css(e, "boxSizing", !1, r),
                        l = o ? Ge(e, t, o, s, r) : 0;
                    return (
                        s &&
                            a &&
                            (l -= Math.ceil(
                                e["offset" + t[0].toUpperCase() + t.slice(1)] -
                                    parseFloat(r[t]) -
                                    Ge(e, t, "border", !1, r) -
                                    0.5
                            )),
                        l &&
                            (i = te.exec(n)) &&
                            "px" !== (i[3] || "px") &&
                            ((e.style[t] = n), (n = x.css(e, t))),
                        Ze(0, n, l)
                    );
                },
            };
        }),
        (x.cssHooks.marginLeft = We(p.reliableMarginLeft, function (e, t) {
            if (t)
                return (
                    (parseFloat(Fe(e, "marginLeft")) ||
                        e.getBoundingClientRect().left -
                            Me(e, { marginLeft: 0 }, function () {
                                return e.getBoundingClientRect().left;
                            })) + "px"
                );
        })),
        x.each({ margin: "", padding: "", border: "Width" }, function (e, t) {
            (x.cssHooks[e + t] = {
                expand: function (n) {
                    for (
                        var o = 0,
                            i = {},
                            r = "string" == typeof n ? n.split(" ") : [n];
                        o < 4;
                        o++
                    )
                        i[e + ne[o] + t] = r[o] || r[o - 2] || r[0];
                    return i;
                },
            }),
                "margin" !== e && (x.cssHooks[e + t].set = Ze);
        }),
        x.fn.extend({
            css: function (e, t) {
                return W(
                    this,
                    function (e, t, n) {
                        var o,
                            i,
                            r = {},
                            a = 0;
                        if (Array.isArray(t)) {
                            for (o = Be(e), i = t.length; a < i; a++)
                                r[t[a]] = x.css(e, t[a], !1, o);
                            return r;
                        }
                        return void 0 !== n ? x.style(e, t, n) : x.css(e, t);
                    },
                    e,
                    t,
                    1 < arguments.length
                );
            },
        }),
        (((x.Tween = et).prototype = {
            constructor: et,
            init: function (e, t, n, o, i, r) {
                (this.elem = e),
                    (this.prop = n),
                    (this.easing = i || x.easing._default),
                    (this.options = t),
                    (this.start = this.now = this.cur()),
                    (this.end = o),
                    (this.unit = r || (x.cssNumber[n] ? "" : "px"));
            },
            cur: function () {
                var e = et.propHooks[this.prop];
                return e && e.get
                    ? e.get(this)
                    : et.propHooks._default.get(this);
            },
            run: function (e) {
                var t,
                    n = et.propHooks[this.prop];
                return (
                    this.options.duration
                        ? (this.pos = t =
                              x.easing[this.easing](
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
                    n && n.set ? n.set(this) : et.propHooks._default.set(this),
                    this
                );
            },
        }).init.prototype = et.prototype),
        ((et.propHooks = {
            _default: {
                get: function (e) {
                    var t;
                    return 1 !== e.elem.nodeType ||
                        (null != e.elem[e.prop] && null == e.elem.style[e.prop])
                        ? e.elem[e.prop]
                        : (t = x.css(e.elem, e.prop, "")) && "auto" !== t
                        ? t
                        : 0;
                },
                set: function (e) {
                    x.fx.step[e.prop]
                        ? x.fx.step[e.prop](e)
                        : 1 !== e.elem.nodeType ||
                          (!x.cssHooks[e.prop] &&
                              null == e.elem.style[$e(e.prop)])
                        ? (e.elem[e.prop] = e.now)
                        : x.style(e.elem, e.prop, e.now + e.unit);
                },
            },
        }).scrollTop = et.propHooks.scrollLeft =
            {
                set: function (e) {
                    e.elem.nodeType &&
                        e.elem.parentNode &&
                        (e.elem[e.prop] = e.now);
                },
            }),
        (x.easing = {
            linear: function (e) {
                return e;
            },
            swing: function (e) {
                return 0.5 - Math.cos(e * Math.PI) / 2;
            },
            _default: "swing",
        }),
        (x.fx = et.prototype.init),
        (x.fx.step = {});
    var tt,
        nt,
        ot,
        it,
        rt = /^(?:toggle|show|hide)$/,
        at = /queueHooks$/;
    function st() {
        nt &&
            (!1 === g.hidden && e.requestAnimationFrame
                ? e.requestAnimationFrame(st)
                : e.setTimeout(st, x.fx.interval),
            x.fx.tick());
    }
    function lt() {
        return (
            e.setTimeout(function () {
                tt = void 0;
            }),
            (tt = Date.now())
        );
    }
    function ct(e, t) {
        var n,
            o = 0,
            i = { height: e };
        for (t = t ? 1 : 0; o < 4; o += 2 - t)
            i["margin" + (n = ne[o])] = i["padding" + n] = e;
        return t && (i.opacity = i.width = e), i;
    }
    function ut(e, t, n) {
        for (
            var o,
                i = (dt.tweeners[t] || []).concat(dt.tweeners["*"]),
                r = 0,
                a = i.length;
            r < a;
            r++
        )
            if ((o = i[r].call(n, t, e))) return o;
    }
    function dt(e, t, n) {
        var o,
            i,
            r = 0,
            a = dt.prefilters.length,
            s = x.Deferred().always(function () {
                delete l.elem;
            }),
            l = function () {
                if (i) return !1;
                for (
                    var t = tt || lt(),
                        n = Math.max(0, c.startTime + c.duration - t),
                        o = 1 - (n / c.duration || 0),
                        r = 0,
                        a = c.tweens.length;
                    r < a;
                    r++
                )
                    c.tweens[r].run(o);
                return (
                    s.notifyWith(e, [c, o, n]),
                    o < 1 && a
                        ? n
                        : (a || s.notifyWith(e, [c, 1, 0]),
                          s.resolveWith(e, [c]),
                          !1)
                );
            },
            c = s.promise({
                elem: e,
                props: x.extend({}, t),
                opts: x.extend(
                    !0,
                    { specialEasing: {}, easing: x.easing._default },
                    n
                ),
                originalProperties: t,
                originalOptions: n,
                startTime: tt || lt(),
                duration: n.duration,
                tweens: [],
                createTween: function (t, n) {
                    var o = x.Tween(
                        e,
                        c.opts,
                        t,
                        n,
                        c.opts.specialEasing[t] || c.opts.easing
                    );
                    return c.tweens.push(o), o;
                },
                stop: function (t) {
                    var n = 0,
                        o = t ? c.tweens.length : 0;
                    if (i) return this;
                    for (i = !0; n < o; n++) c.tweens[n].run(1);
                    return (
                        t
                            ? (s.notifyWith(e, [c, 1, 0]),
                              s.resolveWith(e, [c, t]))
                            : s.rejectWith(e, [c, t]),
                        this
                    );
                },
            }),
            u = c.props;
        for (
            (function (e, t) {
                var n, o, i, r, a;
                for (n in e)
                    if (
                        ((i = t[(o = $(n))]),
                        (r = e[n]),
                        Array.isArray(r) && ((i = r[1]), (r = e[n] = r[0])),
                        n !== o && ((e[o] = r), delete e[n]),
                        (a = x.cssHooks[o]) && ("expand" in a))
                    )
                        for (n in ((r = a.expand(r)), delete e[o], r))
                            (n in e) || ((e[n] = r[n]), (t[n] = i));
                    else t[o] = i;
            })(u, c.opts.specialEasing);
            r < a;
            r++
        )
            if ((o = dt.prefilters[r].call(c, e, u, c.opts)))
                return (
                    h(o.stop) &&
                        (x._queueHooks(c.elem, c.opts.queue).stop =
                            o.stop.bind(o)),
                    o
                );
        return (
            x.map(u, ut, c),
            h(c.opts.start) && c.opts.start.call(e, c),
            c
                .progress(c.opts.progress)
                .done(c.opts.done, c.opts.complete)
                .fail(c.opts.fail)
                .always(c.opts.always),
            x.fx.timer(x.extend(l, { elem: e, anim: c, queue: c.opts.queue })),
            c
        );
    }
    (x.Animation = x.extend(dt, {
        tweeners: {
            "*": [
                function (e, t) {
                    var n = this.createTween(e, t);
                    return se(n.elem, e, te.exec(t), n), n;
                },
            ],
        },
        tweener: function (e, t) {
            h(e) ? ((t = e), (e = ["*"])) : (e = e.match(I));
            for (var n, o = 0, i = e.length; o < i; o++)
                (n = e[o]),
                    (dt.tweeners[n] = dt.tweeners[n] || []),
                    dt.tweeners[n].unshift(t);
        },
        prefilters: [
            function (e, t, n) {
                var o,
                    i,
                    r,
                    a,
                    s,
                    l,
                    c,
                    u,
                    d = "width" in t || "height" in t,
                    f = this,
                    p = {},
                    h = e.style,
                    m = e.nodeType && ae(e),
                    g = X.get(e, "fxshow");
                for (o in (n.queue ||
                    (null == (a = x._queueHooks(e, "fx")).unqueued &&
                        ((a.unqueued = 0),
                        (s = a.empty.fire),
                        (a.empty.fire = function () {
                            a.unqueued || s();
                        })),
                    a.unqueued++,
                    f.always(function () {
                        f.always(function () {
                            a.unqueued--,
                                x.queue(e, "fx").length || a.empty.fire();
                        });
                    })),
                t))
                    if (((i = t[o]), rt.test(i))) {
                        if (
                            (delete t[o],
                            (r = r || "toggle" === i),
                            i === (m ? "hide" : "show"))
                        ) {
                            if ("show" !== i || !g || void 0 === g[o]) continue;
                            m = !0;
                        }
                        p[o] = (g && g[o]) || x.style(e, o);
                    }
                if ((l = !x.isEmptyObject(t)) || !x.isEmptyObject(p))
                    for (o in (d &&
                        1 === e.nodeType &&
                        ((n.overflow = [h.overflow, h.overflowX, h.overflowY]),
                        null == (c = g && g.display) &&
                            (c = X.get(e, "display")),
                        "none" === (u = x.css(e, "display")) &&
                            (c
                                ? (u = c)
                                : (ce([e], !0),
                                  (c = e.style.display || c),
                                  (u = x.css(e, "display")),
                                  ce([e]))),
                        ("inline" === u ||
                            ("inline-block" === u && null != c)) &&
                            "none" === x.css(e, "float") &&
                            (l ||
                                (f.done(function () {
                                    h.display = c;
                                }),
                                null == c &&
                                    ((u = h.display),
                                    (c = "none" === u ? "" : u))),
                            (h.display = "inline-block"))),
                    n.overflow &&
                        ((h.overflow = "hidden"),
                        f.always(function () {
                            (h.overflow = n.overflow[0]),
                                (h.overflowX = n.overflow[1]),
                                (h.overflowY = n.overflow[2]);
                        })),
                    (l = !1),
                    p))
                        l ||
                            (g
                                ? "hidden" in g && (m = g.hidden)
                                : (g = X.access(e, "fxshow", { display: c })),
                            r && (g.hidden = !m),
                            m && ce([e], !0),
                            f.done(function () {
                                for (o in (m || ce([e]),
                                X.remove(e, "fxshow"),
                                p))
                                    x.style(e, o, p[o]);
                            })),
                            (l = ut(m ? g[o] : 0, o, f)),
                            o in g ||
                                ((g[o] = l.start),
                                m && ((l.end = l.start), (l.start = 0)));
            },
        ],
        prefilter: function (e, t) {
            t ? dt.prefilters.unshift(e) : dt.prefilters.push(e);
        },
    })),
        (x.speed = function (e, t, n) {
            var o =
                e && "object" == typeof e
                    ? x.extend({}, e)
                    : {
                          complete: n || (!n && t) || (h(e) && e),
                          duration: e,
                          easing: (n && t) || (t && !h(t) && t),
                      };
            return (
                x.fx.off
                    ? (o.duration = 0)
                    : "number" != typeof o.duration &&
                      (o.duration in x.fx.speeds
                          ? (o.duration = x.fx.speeds[o.duration])
                          : (o.duration = x.fx.speeds._default)),
                (null != o.queue && !0 !== o.queue) || (o.queue = "fx"),
                (o.old = o.complete),
                (o.complete = function () {
                    h(o.old) && o.old.call(this),
                        o.queue && x.dequeue(this, o.queue);
                }),
                o
            );
        }),
        x.fn.extend({
            fadeTo: function (e, t, n, o) {
                return this.filter(ae)
                    .css("opacity", 0)
                    .show()
                    .end()
                    .animate({ opacity: t }, e, n, o);
            },
            animate: function (e, t, n, o) {
                var i = x.isEmptyObject(e),
                    r = x.speed(t, n, o),
                    a = function () {
                        var t = dt(this, x.extend({}, e), r);
                        (i || X.get(this, "finish")) && t.stop(!0);
                    };
                return (
                    (a.finish = a),
                    i || !1 === r.queue ? this.each(a) : this.queue(r.queue, a)
                );
            },
            stop: function (e, t, n) {
                var o = function (e) {
                    var t = e.stop;
                    delete e.stop, t(n);
                };
                return (
                    "string" != typeof e && ((n = t), (t = e), (e = void 0)),
                    t && this.queue(e || "fx", []),
                    this.each(function () {
                        var t = !0,
                            i = null != e && e + "queueHooks",
                            r = x.timers,
                            a = X.get(this);
                        if (i) a[i] && a[i].stop && o(a[i]);
                        else
                            for (i in a)
                                a[i] && a[i].stop && at.test(i) && o(a[i]);
                        for (i = r.length; i--; )
                            r[i].elem !== this ||
                                (null != e && r[i].queue !== e) ||
                                (r[i].anim.stop(n), (t = !1), r.splice(i, 1));
                        (!t && n) || x.dequeue(this, e);
                    })
                );
            },
            finish: function (e) {
                return (
                    !1 !== e && (e = e || "fx"),
                    this.each(function () {
                        var t,
                            n = X.get(this),
                            o = n[e + "queue"],
                            i = n[e + "queueHooks"],
                            r = x.timers,
                            a = o ? o.length : 0;
                        for (
                            n.finish = !0,
                                x.queue(this, e, []),
                                i && i.stop && i.stop.call(this, !0),
                                t = r.length;
                            t--;

                        )
                            r[t].elem === this &&
                                r[t].queue === e &&
                                (r[t].anim.stop(!0), r.splice(t, 1));
                        for (t = 0; t < a; t++)
                            o[t] && o[t].finish && o[t].finish.call(this);
                        delete n.finish;
                    })
                );
            },
        }),
        x.each(["toggle", "show", "hide"], function (e, t) {
            var n = x.fn[t];
            x.fn[t] = function (e, o, i) {
                return null == e || "boolean" == typeof e
                    ? n.apply(this, arguments)
                    : this.animate(ct(t, !0), e, o, i);
            };
        }),
        x.each(
            {
                slideDown: ct("show"),
                slideUp: ct("hide"),
                slideToggle: ct("toggle"),
                fadeIn: { opacity: "show" },
                fadeOut: { opacity: "hide" },
                fadeToggle: { opacity: "toggle" },
            },
            function (e, t) {
                x.fn[e] = function (e, n, o) {
                    return this.animate(t, e, n, o);
                };
            }
        ),
        (x.timers = []),
        (x.fx.tick = function () {
            var e,
                t = 0,
                n = x.timers;
            for (tt = Date.now(); t < n.length; t++)
                (e = n[t])() || n[t] !== e || n.splice(t--, 1);
            n.length || x.fx.stop(), (tt = void 0);
        }),
        (x.fx.timer = function (e) {
            x.timers.push(e), x.fx.start();
        }),
        (x.fx.interval = 13),
        (x.fx.start = function () {
            nt || ((nt = !0), st());
        }),
        (x.fx.stop = function () {
            nt = null;
        }),
        (x.fx.speeds = { slow: 600, fast: 200, _default: 400 }),
        (x.fn.delay = function (t, n) {
            return (
                (t = (x.fx && x.fx.speeds[t]) || t),
                (n = n || "fx"),
                this.queue(n, function (n, o) {
                    var i = e.setTimeout(n, t);
                    o.stop = function () {
                        e.clearTimeout(i);
                    };
                })
            );
        }),
        (ot = g.createElement("input")),
        (it = g.createElement("select").appendChild(g.createElement("option"))),
        (ot.type = "checkbox"),
        (p.checkOn = "" !== ot.value),
        (p.optSelected = it.selected),
        ((ot = g.createElement("input")).value = "t"),
        (ot.type = "radio"),
        (p.radioValue = "t" === ot.value);
    var ft,
        pt = x.expr.attrHandle;
    x.fn.extend({
        attr: function (e, t) {
            return W(this, x.attr, e, t, 1 < arguments.length);
        },
        removeAttr: function (e) {
            return this.each(function () {
                x.removeAttr(this, e);
            });
        },
    }),
        x.extend({
            attr: function (e, t, n) {
                var o,
                    i,
                    r = e.nodeType;
                if (3 !== r && 8 !== r && 2 !== r)
                    return void 0 === e.getAttribute
                        ? x.prop(e, t, n)
                        : ((1 === r && x.isXMLDoc(e)) ||
                              (i =
                                  x.attrHooks[t.toLowerCase()] ||
                                  (x.expr.match.bool.test(t) ? ft : void 0)),
                          void 0 !== n
                              ? null === n
                                  ? void x.removeAttr(e, t)
                                  : i &&
                                    "set" in i &&
                                    void 0 !== (o = i.set(e, n, t))
                                  ? o
                                  : (e.setAttribute(t, n + ""), n)
                              : i && "get" in i && null !== (o = i.get(e, t))
                              ? o
                              : null == (o = x.find.attr(e, t))
                              ? void 0
                              : o);
            },
            attrHooks: {
                type: {
                    set: function (e, t) {
                        if (!p.radioValue && "radio" === t && S(e, "input")) {
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
                    o = 0,
                    i = t && t.match(I);
                if (i && 1 === e.nodeType)
                    for (; (n = i[o++]); ) e.removeAttribute(n);
            },
        }),
        (ft = {
            set: function (e, t, n) {
                return !1 === t ? x.removeAttr(e, n) : e.setAttribute(n, n), n;
            },
        }),
        x.each(x.expr.match.bool.source.match(/\w+/g), function (e, t) {
            var n = pt[t] || x.find.attr;
            pt[t] = function (e, t, o) {
                var i,
                    r,
                    a = t.toLowerCase();
                return (
                    o ||
                        ((r = pt[a]),
                        (pt[a] = i),
                        (i = null != n(e, t, o) ? a : null),
                        (pt[a] = r)),
                    i
                );
            };
        });
    var ht = /^(?:input|select|textarea|button)$/i,
        mt = /^(?:a|area)$/i;
    function gt(e) {
        return (e.match(I) || []).join(" ");
    }
    function wt(e) {
        return (e.getAttribute && e.getAttribute("class")) || "";
    }
    function vt(e) {
        return Array.isArray(e)
            ? e
            : ("string" == typeof e && e.match(I)) || [];
    }
    x.fn.extend({
        prop: function (e, t) {
            return W(this, x.prop, e, t, 1 < arguments.length);
        },
        removeProp: function (e) {
            return this.each(function () {
                delete this[x.propFix[e] || e];
            });
        },
    }),
        x.extend({
            prop: function (e, t, n) {
                var o,
                    i,
                    r = e.nodeType;
                if (3 !== r && 8 !== r && 2 !== r)
                    return (
                        (1 === r && x.isXMLDoc(e)) ||
                            ((t = x.propFix[t] || t), (i = x.propHooks[t])),
                        void 0 !== n
                            ? i && "set" in i && void 0 !== (o = i.set(e, n, t))
                                ? o
                                : (e[t] = n)
                            : i && "get" in i && null !== (o = i.get(e, t))
                            ? o
                            : e[t]
                    );
            },
            propHooks: {
                tabIndex: {
                    get: function (e) {
                        var t = x.find.attr(e, "tabindex");
                        return t
                            ? parseInt(t, 10)
                            : ht.test(e.nodeName) ||
                              (mt.test(e.nodeName) && e.href)
                            ? 0
                            : -1;
                    },
                },
            },
            propFix: { for: "htmlFor", class: "className" },
        }),
        p.optSelected ||
            (x.propHooks.selected = {
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
        x.each(
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
                x.propFix[this.toLowerCase()] = this;
            }
        ),
        x.fn.extend({
            addClass: function (e) {
                var t,
                    n,
                    o,
                    i,
                    r,
                    a,
                    s,
                    l = 0;
                if (h(e))
                    return this.each(function (t) {
                        x(this).addClass(e.call(this, t, wt(this)));
                    });
                if ((t = vt(e)).length)
                    for (; (n = this[l++]); )
                        if (
                            ((i = wt(n)),
                            (o = 1 === n.nodeType && " " + gt(i) + " "))
                        ) {
                            for (a = 0; (r = t[a++]); )
                                o.indexOf(" " + r + " ") < 0 && (o += r + " ");
                            i !== (s = gt(o)) && n.setAttribute("class", s);
                        }
                return this;
            },
            removeClass: function (e) {
                var t,
                    n,
                    o,
                    i,
                    r,
                    a,
                    s,
                    l = 0;
                if (h(e))
                    return this.each(function (t) {
                        x(this).removeClass(e.call(this, t, wt(this)));
                    });
                if (!arguments.length) return this.attr("class", "");
                if ((t = vt(e)).length)
                    for (; (n = this[l++]); )
                        if (
                            ((i = wt(n)),
                            (o = 1 === n.nodeType && " " + gt(i) + " "))
                        ) {
                            for (a = 0; (r = t[a++]); )
                                for (; -1 < o.indexOf(" " + r + " "); )
                                    o = o.replace(" " + r + " ", " ");
                            i !== (s = gt(o)) && n.setAttribute("class", s);
                        }
                return this;
            },
            toggleClass: function (e, t) {
                var n = typeof e,
                    o = "string" === n || Array.isArray(e);
                return "boolean" == typeof t && o
                    ? t
                        ? this.addClass(e)
                        : this.removeClass(e)
                    : h(e)
                    ? this.each(function (n) {
                          x(this).toggleClass(e.call(this, n, wt(this), t), t);
                      })
                    : this.each(function () {
                          var t, i, r, a;
                          if (o)
                              for (
                                  i = 0, r = x(this), a = vt(e);
                                  (t = a[i++]);

                              )
                                  r.hasClass(t)
                                      ? r.removeClass(t)
                                      : r.addClass(t);
                          else
                              (void 0 !== e && "boolean" !== n) ||
                                  ((t = wt(this)) &&
                                      X.set(this, "__className__", t),
                                  this.setAttribute &&
                                      this.setAttribute(
                                          "class",
                                          t || !1 === e
                                              ? ""
                                              : X.get(this, "__className__") ||
                                                    ""
                                      ));
                      });
            },
            hasClass: function (e) {
                var t,
                    n,
                    o = 0;
                for (t = " " + e + " "; (n = this[o++]); )
                    if (
                        1 === n.nodeType &&
                        -1 < (" " + gt(wt(n)) + " ").indexOf(t)
                    )
                        return !0;
                return !1;
            },
        });
    var bt = /\r/g;
    x.fn.extend({
        val: function (e) {
            var t,
                n,
                o,
                i = this[0];
            return arguments.length
                ? ((o = h(e)),
                  this.each(function (n) {
                      var i;
                      1 === this.nodeType &&
                          (null == (i = o ? e.call(this, n, x(this).val()) : e)
                              ? (i = "")
                              : "number" == typeof i
                              ? (i += "")
                              : Array.isArray(i) &&
                                (i = x.map(i, function (e) {
                                    return null == e ? "" : e + "";
                                })),
                          ((t =
                              x.valHooks[this.type] ||
                              x.valHooks[this.nodeName.toLowerCase()]) &&
                              "set" in t &&
                              void 0 !== t.set(this, i, "value")) ||
                              (this.value = i));
                  }))
                : i
                ? (t =
                      x.valHooks[i.type] ||
                      x.valHooks[i.nodeName.toLowerCase()]) &&
                  "get" in t &&
                  void 0 !== (n = t.get(i, "value"))
                    ? n
                    : "string" == typeof (n = i.value)
                    ? n.replace(bt, "")
                    : null == n
                    ? ""
                    : n
                : void 0;
        },
    }),
        x.extend({
            valHooks: {
                option: {
                    get: function (e) {
                        var t = x.find.attr(e, "value");
                        return null != t ? t : gt(x.text(e));
                    },
                },
                select: {
                    get: function (e) {
                        var t,
                            n,
                            o,
                            i = e.options,
                            r = e.selectedIndex,
                            a = "select-one" === e.type,
                            s = a ? null : [],
                            l = a ? r + 1 : i.length;
                        for (o = r < 0 ? l : a ? r : 0; o < l; o++)
                            if (
                                ((n = i[o]).selected || o === r) &&
                                !n.disabled &&
                                (!n.parentNode.disabled ||
                                    !S(n.parentNode, "optgroup"))
                            ) {
                                if (((t = x(n).val()), a)) return t;
                                s.push(t);
                            }
                        return s;
                    },
                    set: function (e, t) {
                        for (
                            var n,
                                o,
                                i = e.options,
                                r = x.makeArray(t),
                                a = i.length;
                            a--;

                        )
                            ((o = i[a]).selected =
                                -1 < x.inArray(x.valHooks.option.get(o), r)) &&
                                (n = !0);
                        return n || (e.selectedIndex = -1), r;
                    },
                },
            },
        }),
        x.each(["radio", "checkbox"], function () {
            (x.valHooks[this] = {
                set: function (e, t) {
                    if (Array.isArray(t))
                        return (e.checked = -1 < x.inArray(x(e).val(), t));
                },
            }),
                p.checkOn ||
                    (x.valHooks[this].get = function (e) {
                        return null === e.getAttribute("value")
                            ? "on"
                            : e.value;
                    });
        }),
        (p.focusin = "onfocusin" in e);
    var yt = /^(?:focusinfocus|focusoutblur)$/,
        xt = function (e) {
            e.stopPropagation();
        };
    x.extend(x.event, {
        trigger: function (t, n, o, i) {
            var r,
                a,
                s,
                l,
                c,
                d,
                f,
                p,
                w = [o || g],
                v = u.call(t, "type") ? t.type : t,
                b = u.call(t, "namespace") ? t.namespace.split(".") : [];
            if (
                ((a = p = s = o = o || g),
                3 !== o.nodeType &&
                    8 !== o.nodeType &&
                    !yt.test(v + x.event.triggered) &&
                    (-1 < v.indexOf(".") &&
                        ((v = (b = v.split(".")).shift()), b.sort()),
                    (c = v.indexOf(":") < 0 && "on" + v),
                    ((t = t[x.expando]
                        ? t
                        : new x.Event(v, "object" == typeof t && t)).isTrigger =
                        i ? 2 : 3),
                    (t.namespace = b.join(".")),
                    (t.rnamespace = t.namespace
                        ? new RegExp(
                              "(^|\\.)" + b.join("\\.(?:.*\\.|)") + "(\\.|$)"
                          )
                        : null),
                    (t.result = void 0),
                    t.target || (t.target = o),
                    (n = null == n ? [t] : x.makeArray(n, [t])),
                    (f = x.event.special[v] || {}),
                    i || !f.trigger || !1 !== f.trigger.apply(o, n)))
            ) {
                if (!i && !f.noBubble && !m(o)) {
                    for (
                        l = f.delegateType || v,
                            yt.test(l + v) || (a = a.parentNode);
                        a;
                        a = a.parentNode
                    )
                        w.push(a), (s = a);
                    s === (o.ownerDocument || g) &&
                        w.push(s.defaultView || s.parentWindow || e);
                }
                for (r = 0; (a = w[r++]) && !t.isPropagationStopped(); )
                    (p = a),
                        (t.type = 1 < r ? l : f.bindType || v),
                        (d =
                            (X.get(a, "events") || Object.create(null))[
                                t.type
                            ] && X.get(a, "handle")) && d.apply(a, n),
                        (d = c && a[c]) &&
                            d.apply &&
                            Y(a) &&
                            ((t.result = d.apply(a, n)),
                            !1 === t.result && t.preventDefault());
                return (
                    (t.type = v),
                    i ||
                        t.isDefaultPrevented() ||
                        (f._default && !1 !== f._default.apply(w.pop(), n)) ||
                        !Y(o) ||
                        (c &&
                            h(o[v]) &&
                            !m(o) &&
                            ((s = o[c]) && (o[c] = null),
                            (x.event.triggered = v),
                            t.isPropagationStopped() &&
                                p.addEventListener(v, xt),
                            o[v](),
                            t.isPropagationStopped() &&
                                p.removeEventListener(v, xt),
                            (x.event.triggered = void 0),
                            s && (o[c] = s))),
                    t.result
                );
            }
        },
        simulate: function (e, t, n) {
            var o = x.extend(new x.Event(), n, { type: e, isSimulated: !0 });
            x.event.trigger(o, null, t);
        },
    }),
        x.fn.extend({
            trigger: function (e, t) {
                return this.each(function () {
                    x.event.trigger(e, t, this);
                });
            },
            triggerHandler: function (e, t) {
                var n = this[0];
                if (n) return x.event.trigger(e, t, n, !0);
            },
        }),
        p.focusin ||
            x.each({ focus: "focusin", blur: "focusout" }, function (e, t) {
                var n = function (e) {
                    x.event.simulate(t, e.target, x.event.fix(e));
                };
                x.event.special[t] = {
                    setup: function () {
                        var o = this.ownerDocument || this.document || this,
                            i = X.access(o, t);
                        i || o.addEventListener(e, n, !0),
                            X.access(o, t, (i || 0) + 1);
                    },
                    teardown: function () {
                        var o = this.ownerDocument || this.document || this,
                            i = X.access(o, t) - 1;
                        i
                            ? X.access(o, t, i)
                            : (o.removeEventListener(e, n, !0), X.remove(o, t));
                    },
                };
            });
    var _t = e.location,
        kt = { guid: Date.now() },
        Ct = /\?/;
    x.parseXML = function (t) {
        var n;
        if (!t || "string" != typeof t) return null;
        try {
            n = new e.DOMParser().parseFromString(t, "text/xml");
        } catch (t) {
            n = void 0;
        }
        return (
            (n && !n.getElementsByTagName("parsererror").length) ||
                x.error("Invalid XML: " + t),
            n
        );
    };
    var Et = /\[\]$/,
        Tt = /\r?\n/g,
        St = /^(?:submit|button|image|reset|file)$/i,
        At = /^(?:input|select|textarea|keygen)/i;
    function Dt(e, t, n, o) {
        var i;
        if (Array.isArray(t))
            x.each(t, function (t, i) {
                n || Et.test(e)
                    ? o(e, i)
                    : Dt(
                          e +
                              "[" +
                              ("object" == typeof i && null != i ? t : "") +
                              "]",
                          i,
                          n,
                          o
                      );
            });
        else if (n || "object" !== b(t)) o(e, t);
        else for (i in t) Dt(e + "[" + i + "]", t[i], n, o);
    }
    (x.param = function (e, t) {
        var n,
            o = [],
            i = function (e, t) {
                var n = h(t) ? t() : t;
                o[o.length] =
                    encodeURIComponent(e) +
                    "=" +
                    encodeURIComponent(null == n ? "" : n);
            };
        if (null == e) return "";
        if (Array.isArray(e) || (e.jquery && !x.isPlainObject(e)))
            x.each(e, function () {
                i(this.name, this.value);
            });
        else for (n in e) Dt(n, e[n], t, i);
        return o.join("&");
    }),
        x.fn.extend({
            serialize: function () {
                return x.param(this.serializeArray());
            },
            serializeArray: function () {
                return this.map(function () {
                    var e = x.prop(this, "elements");
                    return e ? x.makeArray(e) : this;
                })
                    .filter(function () {
                        var e = this.type;
                        return (
                            this.name &&
                            !x(this).is(":disabled") &&
                            At.test(this.nodeName) &&
                            !St.test(e) &&
                            (this.checked || !fe.test(e))
                        );
                    })
                    .map(function (e, t) {
                        var n = x(this).val();
                        return null == n
                            ? null
                            : Array.isArray(n)
                            ? x.map(n, function (e) {
                                  return {
                                      name: t.name,
                                      value: e.replace(Tt, "\r\n"),
                                  };
                              })
                            : { name: t.name, value: n.replace(Tt, "\r\n") };
                    })
                    .get();
            },
        });
    var Nt = /%20/g,
        jt = /#.*$/,
        Ot = /([?&])_=[^&]*/,
        Lt = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        Pt = /^(?:GET|HEAD)$/,
        It = /^\/\//,
        qt = {},
        Ht = {},
        Bt = "*/".concat("*"),
        Mt = g.createElement("a");
    function Rt(e) {
        return function (t, n) {
            "string" != typeof t && ((n = t), (t = "*"));
            var o,
                i = 0,
                r = t.toLowerCase().match(I) || [];
            if (h(n))
                for (; (o = r[i++]); )
                    "+" === o[0]
                        ? ((o = o.slice(1) || "*"),
                          (e[o] = e[o] || []).unshift(n))
                        : (e[o] = e[o] || []).push(n);
        };
    }
    function Ft(e, t, n, o) {
        var i = {},
            r = e === Ht;
        function a(s) {
            var l;
            return (
                (i[s] = !0),
                x.each(e[s] || [], function (e, s) {
                    var c = s(t, n, o);
                    return "string" != typeof c || r || i[c]
                        ? r
                            ? !(l = c)
                            : void 0
                        : (t.dataTypes.unshift(c), a(c), !1);
                }),
                l
            );
        }
        return a(t.dataTypes[0]) || (!i["*"] && a("*"));
    }
    function Wt(e, t) {
        var n,
            o,
            i = x.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((i[n] ? e : o || (o = {}))[n] = t[n]);
        return o && x.extend(!0, e, o), e;
    }
    (Mt.href = _t.href),
        x.extend({
            active: 0,
            lastModified: {},
            etag: {},
            ajaxSettings: {
                url: _t.href,
                type: "GET",
                isLocal:
                    /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(
                        _t.protocol
                    ),
                global: !0,
                processData: !0,
                async: !0,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                accepts: {
                    "*": Bt,
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
                    "text xml": x.parseXML,
                },
                flatOptions: { url: !0, context: !0 },
            },
            ajaxSetup: function (e, t) {
                return t ? Wt(Wt(e, x.ajaxSettings), t) : Wt(x.ajaxSettings, e);
            },
            ajaxPrefilter: Rt(qt),
            ajaxTransport: Rt(Ht),
            ajax: function (t, n) {
                "object" == typeof t && ((n = t), (t = void 0)), (n = n || {});
                var o,
                    i,
                    r,
                    a,
                    s,
                    l,
                    c,
                    u,
                    d,
                    f,
                    p = x.ajaxSetup({}, n),
                    h = p.context || p,
                    m = p.context && (h.nodeType || h.jquery) ? x(h) : x.event,
                    w = x.Deferred(),
                    v = x.Callbacks("once memory"),
                    b = p.statusCode || {},
                    y = {},
                    _ = {},
                    k = "canceled",
                    C = {
                        readyState: 0,
                        getResponseHeader: function (e) {
                            var t;
                            if (c) {
                                if (!a)
                                    for (a = {}; (t = Lt.exec(r)); )
                                        a[t[1].toLowerCase() + " "] = (
                                            a[t[1].toLowerCase() + " "] || []
                                        ).concat(t[2]);
                                t = a[e.toLowerCase() + " "];
                            }
                            return null == t ? null : t.join(", ");
                        },
                        getAllResponseHeaders: function () {
                            return c ? r : null;
                        },
                        setRequestHeader: function (e, t) {
                            return (
                                null == c &&
                                    ((e = _[e.toLowerCase()] =
                                        _[e.toLowerCase()] || e),
                                    (y[e] = t)),
                                this
                            );
                        },
                        overrideMimeType: function (e) {
                            return null == c && (p.mimeType = e), this;
                        },
                        statusCode: function (e) {
                            var t;
                            if (e)
                                if (c) C.always(e[C.status]);
                                else for (t in e) b[t] = [b[t], e[t]];
                            return this;
                        },
                        abort: function (e) {
                            var t = e || k;
                            return o && o.abort(t), E(0, t), this;
                        },
                    };
                if (
                    (w.promise(C),
                    (p.url = ((t || p.url || _t.href) + "").replace(
                        It,
                        _t.protocol + "//"
                    )),
                    (p.type = n.method || n.type || p.method || p.type),
                    (p.dataTypes = (p.dataType || "*")
                        .toLowerCase()
                        .match(I) || [""]),
                    null == p.crossDomain)
                ) {
                    l = g.createElement("a");
                    try {
                        (l.href = p.url),
                            (l.href = l.href),
                            (p.crossDomain =
                                Mt.protocol + "//" + Mt.host !=
                                l.protocol + "//" + l.host);
                    } catch (t) {
                        p.crossDomain = !0;
                    }
                }
                if (
                    (p.data &&
                        p.processData &&
                        "string" != typeof p.data &&
                        (p.data = x.param(p.data, p.traditional)),
                    Ft(qt, p, n, C),
                    c)
                )
                    return C;
                for (d in ((u = x.event && p.global) &&
                    0 == x.active++ &&
                    x.event.trigger("ajaxStart"),
                (p.type = p.type.toUpperCase()),
                (p.hasContent = !Pt.test(p.type)),
                (i = p.url.replace(jt, "")),
                p.hasContent
                    ? p.data &&
                      p.processData &&
                      0 ===
                          (p.contentType || "").indexOf(
                              "application/x-www-form-urlencoded"
                          ) &&
                      (p.data = p.data.replace(Nt, "+"))
                    : ((f = p.url.slice(i.length)),
                      p.data &&
                          (p.processData || "string" == typeof p.data) &&
                          ((i += (Ct.test(i) ? "&" : "?") + p.data),
                          delete p.data),
                      !1 === p.cache &&
                          ((i = i.replace(Ot, "$1")),
                          (f =
                              (Ct.test(i) ? "&" : "?") + "_=" + kt.guid++ + f)),
                      (p.url = i + f)),
                p.ifModified &&
                    (x.lastModified[i] &&
                        C.setRequestHeader(
                            "If-Modified-Since",
                            x.lastModified[i]
                        ),
                    x.etag[i] &&
                        C.setRequestHeader("If-None-Match", x.etag[i])),
                ((p.data && p.hasContent && !1 !== p.contentType) ||
                    n.contentType) &&
                    C.setRequestHeader("Content-Type", p.contentType),
                C.setRequestHeader(
                    "Accept",
                    p.dataTypes[0] && p.accepts[p.dataTypes[0]]
                        ? p.accepts[p.dataTypes[0]] +
                              ("*" !== p.dataTypes[0]
                                  ? ", " + Bt + "; q=0.01"
                                  : "")
                        : p.accepts["*"]
                ),
                p.headers))
                    C.setRequestHeader(d, p.headers[d]);
                if (p.beforeSend && (!1 === p.beforeSend.call(h, C, p) || c))
                    return C.abort();
                if (
                    ((k = "abort"),
                    v.add(p.complete),
                    C.done(p.success),
                    C.fail(p.error),
                    (o = Ft(Ht, p, n, C)))
                ) {
                    if (
                        ((C.readyState = 1),
                        u && m.trigger("ajaxSend", [C, p]),
                        c)
                    )
                        return C;
                    p.async &&
                        0 < p.timeout &&
                        (s = e.setTimeout(function () {
                            C.abort("timeout");
                        }, p.timeout));
                    try {
                        (c = !1), o.send(y, E);
                    } catch (t) {
                        if (c) throw t;
                        E(-1, t);
                    }
                } else E(-1, "No Transport");
                function E(t, n, a, l) {
                    var d,
                        f,
                        g,
                        y,
                        _,
                        k = n;
                    c ||
                        ((c = !0),
                        s && e.clearTimeout(s),
                        (o = void 0),
                        (r = l || ""),
                        (C.readyState = 0 < t ? 4 : 0),
                        (d = (200 <= t && t < 300) || 304 === t),
                        a &&
                            (y = (function (e, t, n) {
                                for (
                                    var o,
                                        i,
                                        r,
                                        a,
                                        s = e.contents,
                                        l = e.dataTypes;
                                    "*" === l[0];

                                )
                                    l.shift(),
                                        void 0 === o &&
                                            (o =
                                                e.mimeType ||
                                                t.getResponseHeader(
                                                    "Content-Type"
                                                ));
                                if (o)
                                    for (i in s)
                                        if (s[i] && s[i].test(o)) {
                                            l.unshift(i);
                                            break;
                                        }
                                if (l[0] in n) r = l[0];
                                else {
                                    for (i in n) {
                                        if (
                                            !l[0] ||
                                            e.converters[i + " " + l[0]]
                                        ) {
                                            r = i;
                                            break;
                                        }
                                        a || (a = i);
                                    }
                                    r = r || a;
                                }
                                if (r) return r !== l[0] && l.unshift(r), n[r];
                            })(p, C, a)),
                        !d &&
                            -1 < x.inArray("script", p.dataTypes) &&
                            (p.converters["text script"] = function () {}),
                        (y = (function (e, t, n, o) {
                            var i,
                                r,
                                a,
                                s,
                                l,
                                c = {},
                                u = e.dataTypes.slice();
                            if (u[1])
                                for (a in e.converters)
                                    c[a.toLowerCase()] = e.converters[a];
                            for (r = u.shift(); r; )
                                if (
                                    (e.responseFields[r] &&
                                        (n[e.responseFields[r]] = t),
                                    !l &&
                                        o &&
                                        e.dataFilter &&
                                        (t = e.dataFilter(t, e.dataType)),
                                    (l = r),
                                    (r = u.shift()))
                                )
                                    if ("*" === r) r = l;
                                    else if ("*" !== l && l !== r) {
                                        if (
                                            !(a = c[l + " " + r] || c["* " + r])
                                        )
                                            for (i in c)
                                                if (
                                                    (s = i.split(" "))[1] ===
                                                        r &&
                                                    (a =
                                                        c[l + " " + s[0]] ||
                                                        c["* " + s[0]])
                                                ) {
                                                    !0 === a
                                                        ? (a = c[i])
                                                        : !0 !== c[i] &&
                                                          ((r = s[0]),
                                                          u.unshift(s[1]));
                                                    break;
                                                }
                                        if (!0 !== a)
                                            if (a && e.throws) t = a(t);
                                            else
                                                try {
                                                    t = a(t);
                                                } catch (e) {
                                                    return {
                                                        state: "parsererror",
                                                        error: a
                                                            ? e
                                                            : "No conversion from " +
                                                              l +
                                                              " to " +
                                                              r,
                                                    };
                                                }
                                    }
                            return { state: "success", data: t };
                        })(p, y, C, d)),
                        d
                            ? (p.ifModified &&
                                  ((_ = C.getResponseHeader("Last-Modified")) &&
                                      (x.lastModified[i] = _),
                                  (_ = C.getResponseHeader("etag")) &&
                                      (x.etag[i] = _)),
                              204 === t || "HEAD" === p.type
                                  ? (k = "nocontent")
                                  : 304 === t
                                  ? (k = "notmodified")
                                  : ((k = y.state),
                                    (f = y.data),
                                    (d = !(g = y.error))))
                            : ((g = k),
                              (!t && k) || ((k = "error"), t < 0 && (t = 0))),
                        (C.status = t),
                        (C.statusText = (n || k) + ""),
                        d
                            ? w.resolveWith(h, [f, k, C])
                            : w.rejectWith(h, [C, k, g]),
                        C.statusCode(b),
                        (b = void 0),
                        u &&
                            m.trigger(d ? "ajaxSuccess" : "ajaxError", [
                                C,
                                p,
                                d ? f : g,
                            ]),
                        v.fireWith(h, [C, k]),
                        u &&
                            (m.trigger("ajaxComplete", [C, p]),
                            --x.active || x.event.trigger("ajaxStop")));
                }
                return C;
            },
            getJSON: function (e, t, n) {
                return x.get(e, t, n, "json");
            },
            getScript: function (e, t) {
                return x.get(e, void 0, t, "script");
            },
        }),
        x.each(["get", "post"], function (e, t) {
            x[t] = function (e, n, o, i) {
                return (
                    h(n) && ((i = i || o), (o = n), (n = void 0)),
                    x.ajax(
                        x.extend(
                            {
                                url: e,
                                type: t,
                                dataType: i,
                                data: n,
                                success: o,
                            },
                            x.isPlainObject(e) && e
                        )
                    )
                );
            };
        }),
        x.ajaxPrefilter(function (e) {
            var t;
            for (t in e.headers)
                "content-type" === t.toLowerCase() &&
                    (e.contentType = e.headers[t] || "");
        }),
        (x._evalUrl = function (e, t, n) {
            return x.ajax({
                url: e,
                type: "GET",
                dataType: "script",
                cache: !0,
                async: !1,
                global: !1,
                converters: { "text script": function () {} },
                dataFilter: function (e) {
                    x.globalEval(e, t, n);
                },
            });
        }),
        x.fn.extend({
            wrapAll: function (e) {
                var t;
                return (
                    this[0] &&
                        (h(e) && (e = e.call(this[0])),
                        (t = x(e, this[0].ownerDocument).eq(0).clone(!0)),
                        this[0].parentNode && t.insertBefore(this[0]),
                        t
                            .map(function () {
                                for (var e = this; e.firstElementChild; )
                                    e = e.firstElementChild;
                                return e;
                            })
                            .append(this)),
                    this
                );
            },
            wrapInner: function (e) {
                return h(e)
                    ? this.each(function (t) {
                          x(this).wrapInner(e.call(this, t));
                      })
                    : this.each(function () {
                          var t = x(this),
                              n = t.contents();
                          n.length ? n.wrapAll(e) : t.append(e);
                      });
            },
            wrap: function (e) {
                var t = h(e);
                return this.each(function (n) {
                    x(this).wrapAll(t ? e.call(this, n) : e);
                });
            },
            unwrap: function (e) {
                return (
                    this.parent(e)
                        .not("body")
                        .each(function () {
                            x(this).replaceWith(this.childNodes);
                        }),
                    this
                );
            },
        }),
        (x.expr.pseudos.hidden = function (e) {
            return !x.expr.pseudos.visible(e);
        }),
        (x.expr.pseudos.visible = function (e) {
            return !!(
                e.offsetWidth ||
                e.offsetHeight ||
                e.getClientRects().length
            );
        }),
        (x.ajaxSettings.xhr = function () {
            try {
                return new e.XMLHttpRequest();
            } catch (e) {}
        });
    var zt = { 0: 200, 1223: 204 },
        Ut = x.ajaxSettings.xhr();
    (p.cors = !!Ut && "withCredentials" in Ut),
        (p.ajax = Ut = !!Ut),
        x.ajaxTransport(function (t) {
            var n, o;
            if (p.cors || (Ut && !t.crossDomain))
                return {
                    send: function (i, r) {
                        var a,
                            s = t.xhr();
                        if (
                            (s.open(
                                t.type,
                                t.url,
                                t.async,
                                t.username,
                                t.password
                            ),
                            t.xhrFields)
                        )
                            for (a in t.xhrFields) s[a] = t.xhrFields[a];
                        for (a in (t.mimeType &&
                            s.overrideMimeType &&
                            s.overrideMimeType(t.mimeType),
                        t.crossDomain ||
                            i["X-Requested-With"] ||
                            (i["X-Requested-With"] = "XMLHttpRequest"),
                        i))
                            s.setRequestHeader(a, i[a]);
                        (n = function (e) {
                            return function () {
                                n &&
                                    ((n =
                                        o =
                                        s.onload =
                                        s.onerror =
                                        s.onabort =
                                        s.ontimeout =
                                        s.onreadystatechange =
                                            null),
                                    "abort" === e
                                        ? s.abort()
                                        : "error" === e
                                        ? "number" != typeof s.status
                                            ? r(0, "error")
                                            : r(s.status, s.statusText)
                                        : r(
                                              zt[s.status] || s.status,
                                              s.statusText,
                                              "text" !==
                                                  (s.responseType || "text") ||
                                                  "string" !=
                                                      typeof s.responseText
                                                  ? { binary: s.response }
                                                  : { text: s.responseText },
                                              s.getAllResponseHeaders()
                                          ));
                            };
                        }),
                            (s.onload = n()),
                            (o = s.onerror = s.ontimeout = n("error")),
                            void 0 !== s.onabort
                                ? (s.onabort = o)
                                : (s.onreadystatechange = function () {
                                      4 === s.readyState &&
                                          e.setTimeout(function () {
                                              n && o();
                                          });
                                  }),
                            (n = n("abort"));
                        try {
                            s.send((t.hasContent && t.data) || null);
                        } catch (i) {
                            if (n) throw i;
                        }
                    },
                    abort: function () {
                        n && n();
                    },
                };
        }),
        x.ajaxPrefilter(function (e) {
            e.crossDomain && (e.contents.script = !1);
        }),
        x.ajaxSetup({
            accepts: {
                script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript",
            },
            contents: { script: /\b(?:java|ecma)script\b/ },
            converters: {
                "text script": function (e) {
                    return x.globalEval(e), e;
                },
            },
        }),
        x.ajaxPrefilter("script", function (e) {
            void 0 === e.cache && (e.cache = !1),
                e.crossDomain && (e.type = "GET");
        }),
        x.ajaxTransport("script", function (e) {
            var t, n;
            if (e.crossDomain || e.scriptAttrs)
                return {
                    send: function (o, i) {
                        (t = x("<script>")
                            .attr(e.scriptAttrs || {})
                            .prop({ charset: e.scriptCharset, src: e.url })
                            .on(
                                "load error",
                                (n = function (e) {
                                    t.remove(),
                                        (n = null),
                                        e &&
                                            i(
                                                "error" === e.type ? 404 : 200,
                                                e.type
                                            );
                                })
                            )),
                            g.head.appendChild(t[0]);
                    },
                    abort: function () {
                        n && n();
                    },
                };
        });
    var Vt,
        $t = [],
        Yt = /(=)\?(?=&|$)|\?\?/;
    x.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function () {
            var e = $t.pop() || x.expando + "_" + kt.guid++;
            return (this[e] = !0), e;
        },
    }),
        x.ajaxPrefilter("json jsonp", function (t, n, o) {
            var i,
                r,
                a,
                s =
                    !1 !== t.jsonp &&
                    (Yt.test(t.url)
                        ? "url"
                        : "string" == typeof t.data &&
                          0 ===
                              (t.contentType || "").indexOf(
                                  "application/x-www-form-urlencoded"
                              ) &&
                          Yt.test(t.data) &&
                          "data");
            if (s || "jsonp" === t.dataTypes[0])
                return (
                    (i = t.jsonpCallback =
                        h(t.jsonpCallback)
                            ? t.jsonpCallback()
                            : t.jsonpCallback),
                    s
                        ? (t[s] = t[s].replace(Yt, "$1" + i))
                        : !1 !== t.jsonp &&
                          (t.url +=
                              (Ct.test(t.url) ? "&" : "?") + t.jsonp + "=" + i),
                    (t.converters["script json"] = function () {
                        return a || x.error(i + " was not called"), a[0];
                    }),
                    (t.dataTypes[0] = "json"),
                    (r = e[i]),
                    (e[i] = function () {
                        a = arguments;
                    }),
                    o.always(function () {
                        void 0 === r ? x(e).removeProp(i) : (e[i] = r),
                            t[i] &&
                                ((t.jsonpCallback = n.jsonpCallback),
                                $t.push(i)),
                            a && h(r) && r(a[0]),
                            (a = r = void 0);
                    }),
                    "script"
                );
        }),
        (p.createHTMLDocument =
            (((Vt = g.implementation.createHTMLDocument("").body).innerHTML =
                "<form></form><form></form>"),
            2 === Vt.childNodes.length)),
        (x.parseHTML = function (e, t, n) {
            return "string" != typeof e
                ? []
                : ("boolean" == typeof t && ((n = t), (t = !1)),
                  t ||
                      (p.createHTMLDocument
                          ? (((o = (t =
                                g.implementation.createHTMLDocument(
                                    ""
                                )).createElement("base")).href =
                                g.location.href),
                            t.head.appendChild(o))
                          : (t = g)),
                  (r = !n && []),
                  (i = A.exec(e))
                      ? [t.createElement(i[1])]
                      : ((i = be([e], t, r)),
                        r && r.length && x(r).remove(),
                        x.merge([], i.childNodes)));
            var o, i, r;
        }),
        (x.fn.load = function (e, t, n) {
            var o,
                i,
                r,
                a = this,
                s = e.indexOf(" ");
            return (
                -1 < s && ((o = gt(e.slice(s))), (e = e.slice(0, s))),
                h(t)
                    ? ((n = t), (t = void 0))
                    : t && "object" == typeof t && (i = "POST"),
                0 < a.length &&
                    x
                        .ajax({
                            url: e,
                            type: i || "GET",
                            dataType: "html",
                            data: t,
                        })
                        .done(function (e) {
                            (r = arguments),
                                a.html(
                                    o
                                        ? x("<div>")
                                              .append(x.parseHTML(e))
                                              .find(o)
                                        : e
                                );
                        })
                        .always(
                            n &&
                                function (e, t) {
                                    a.each(function () {
                                        n.apply(
                                            this,
                                            r || [e.responseText, t, e]
                                        );
                                    });
                                }
                        ),
                this
            );
        }),
        (x.expr.pseudos.animated = function (e) {
            return x.grep(x.timers, function (t) {
                return e === t.elem;
            }).length;
        }),
        (x.offset = {
            setOffset: function (e, t, n) {
                var o,
                    i,
                    r,
                    a,
                    s,
                    l,
                    c = x.css(e, "position"),
                    u = x(e),
                    d = {};
                "static" === c && (e.style.position = "relative"),
                    (s = u.offset()),
                    (r = x.css(e, "top")),
                    (l = x.css(e, "left")),
                    ("absolute" === c || "fixed" === c) &&
                    -1 < (r + l).indexOf("auto")
                        ? ((a = (o = u.position()).top), (i = o.left))
                        : ((a = parseFloat(r) || 0), (i = parseFloat(l) || 0)),
                    h(t) && (t = t.call(e, n, x.extend({}, s))),
                    null != t.top && (d.top = t.top - s.top + a),
                    null != t.left && (d.left = t.left - s.left + i),
                    "using" in t
                        ? t.using.call(e, d)
                        : ("number" == typeof d.top && (d.top += "px"),
                          "number" == typeof d.left && (d.left += "px"),
                          u.css(d));
            },
        }),
        x.fn.extend({
            offset: function (e) {
                if (arguments.length)
                    return void 0 === e
                        ? this
                        : this.each(function (t) {
                              x.offset.setOffset(this, e, t);
                          });
                var t,
                    n,
                    o = this[0];
                return o
                    ? o.getClientRects().length
                        ? ((t = o.getBoundingClientRect()),
                          (n = o.ownerDocument.defaultView),
                          {
                              top: t.top + n.pageYOffset,
                              left: t.left + n.pageXOffset,
                          })
                        : { top: 0, left: 0 }
                    : void 0;
            },
            position: function () {
                if (this[0]) {
                    var e,
                        t,
                        n,
                        o = this[0],
                        i = { top: 0, left: 0 };
                    if ("fixed" === x.css(o, "position"))
                        t = o.getBoundingClientRect();
                    else {
                        for (
                            t = this.offset(),
                                n = o.ownerDocument,
                                e = o.offsetParent || n.documentElement;
                            e &&
                            (e === n.body || e === n.documentElement) &&
                            "static" === x.css(e, "position");

                        )
                            e = e.parentNode;
                        e &&
                            e !== o &&
                            1 === e.nodeType &&
                            (((i = x(e).offset()).top += x.css(
                                e,
                                "borderTopWidth",
                                !0
                            )),
                            (i.left += x.css(e, "borderLeftWidth", !0)));
                    }
                    return {
                        top: t.top - i.top - x.css(o, "marginTop", !0),
                        left: t.left - i.left - x.css(o, "marginLeft", !0),
                    };
                }
            },
            offsetParent: function () {
                return this.map(function () {
                    for (
                        var e = this.offsetParent;
                        e && "static" === x.css(e, "position");

                    )
                        e = e.offsetParent;
                    return e || oe;
                });
            },
        }),
        x.each(
            { scrollLeft: "pageXOffset", scrollTop: "pageYOffset" },
            function (e, t) {
                var n = "pageYOffset" === t;
                x.fn[e] = function (o) {
                    return W(
                        this,
                        function (e, o, i) {
                            var r;
                            if (
                                (m(e)
                                    ? (r = e)
                                    : 9 === e.nodeType && (r = e.defaultView),
                                void 0 === i)
                            )
                                return r ? r[t] : e[o];
                            r
                                ? r.scrollTo(
                                      n ? r.pageXOffset : i,
                                      n ? i : r.pageYOffset
                                  )
                                : (e[o] = i);
                        },
                        e,
                        o,
                        arguments.length
                    );
                };
            }
        ),
        x.each(["top", "left"], function (e, t) {
            x.cssHooks[t] = We(p.pixelPosition, function (e, n) {
                if (n)
                    return (
                        (n = Fe(e, t)),
                        He.test(n) ? x(e).position()[t] + "px" : n
                    );
            });
        }),
        x.each({ Height: "height", Width: "width" }, function (e, t) {
            x.each(
                { padding: "inner" + e, content: t, "": "outer" + e },
                function (n, o) {
                    x.fn[o] = function (i, r) {
                        var a =
                                arguments.length &&
                                (n || "boolean" != typeof i),
                            s =
                                n ||
                                (!0 === i || !0 === r ? "margin" : "border");
                        return W(
                            this,
                            function (t, n, i) {
                                var r;
                                return m(t)
                                    ? 0 === o.indexOf("outer")
                                        ? t["inner" + e]
                                        : t.document.documentElement[
                                              "client" + e
                                          ]
                                    : 9 === t.nodeType
                                    ? ((r = t.documentElement),
                                      Math.max(
                                          t.body["scroll" + e],
                                          r["scroll" + e],
                                          t.body["offset" + e],
                                          r["offset" + e],
                                          r["client" + e]
                                      ))
                                    : void 0 === i
                                    ? x.css(t, n, s)
                                    : x.style(t, n, i, s);
                            },
                            t,
                            a ? i : void 0,
                            a
                        );
                    };
                }
            );
        }),
        x.each(
            [
                "ajaxStart",
                "ajaxStop",
                "ajaxComplete",
                "ajaxError",
                "ajaxSuccess",
                "ajaxSend",
            ],
            function (e, t) {
                x.fn[t] = function (e) {
                    return this.on(t, e);
                };
            }
        ),
        x.fn.extend({
            bind: function (e, t, n) {
                return this.on(e, null, t, n);
            },
            unbind: function (e, t) {
                return this.off(e, null, t);
            },
            delegate: function (e, t, n, o) {
                return this.on(t, e, n, o);
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
        x.each(
            "blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(
                " "
            ),
            function (e, t) {
                x.fn[t] = function (e, n) {
                    return 0 < arguments.length
                        ? this.on(t, null, e, n)
                        : this.trigger(t);
                };
            }
        );
    var Qt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    (x.proxy = function (e, t) {
        var n, o, r;
        if (("string" == typeof t && ((n = e[t]), (t = e), (e = n)), h(e)))
            return (
                (o = i.call(arguments, 2)),
                ((r = function () {
                    return e.apply(t || this, o.concat(i.call(arguments)));
                }).guid = e.guid =
                    e.guid || x.guid++),
                r
            );
    }),
        (x.holdReady = function (e) {
            e ? x.readyWait++ : x.ready(!0);
        }),
        (x.isArray = Array.isArray),
        (x.parseJSON = JSON.parse),
        (x.nodeName = S),
        (x.isFunction = h),
        (x.isWindow = m),
        (x.camelCase = $),
        (x.type = b),
        (x.now = Date.now),
        (x.isNumeric = function (e) {
            var t = x.type(e);
            return (
                ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
            );
        }),
        (x.trim = function (e) {
            return null == e ? "" : (e + "").replace(Qt, "");
        }),
        "function" == typeof define &&
            define.amd &&
            define("jquery", [], function () {
                return x;
            });
    var Xt = e.jQuery,
        Kt = e.$;
    return (
        (x.noConflict = function (t) {
            return (
                e.$ === x && (e.$ = Kt),
                t && e.jQuery === x && (e.jQuery = Xt),
                x
            );
        }),
        void 0 === t && (e.jQuery = e.$ = x),
        x
    );
}),
    (function (e, t) {
        "object" == typeof exports && "undefined" != typeof module
            ? (module.exports = t())
            : "function" == typeof define && define.amd
            ? define(t)
            : (e.Sweetalert2 = t());
    })(this, function () {
        "use strict";
        function e(t) {
            return (e =
                "function" == typeof Symbol &&
                "symbol" == typeof Symbol.iterator
                    ? function (e) {
                          return typeof e;
                      }
                    : function (e) {
                          return e &&
                              "function" == typeof Symbol &&
                              e.constructor === Symbol &&
                              e !== Symbol.prototype
                              ? "symbol"
                              : typeof e;
                      })(t);
        }
        function t(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
        }
        function n(e, t) {
            for (var n = 0; n < t.length; n++) {
                var o = t[n];
                (o.enumerable = o.enumerable || !1),
                    (o.configurable = !0),
                    "value" in o && (o.writable = !0),
                    Object.defineProperty(e, o.key, o);
            }
        }
        function o(e, t, o) {
            return t && n(e.prototype, t), o && n(e, o), e;
        }
        function i() {
            return (i =
                Object.assign ||
                function (e) {
                    for (var t = 1; t < arguments.length; t++) {
                        var n = arguments[t];
                        for (var o in n)
                            Object.prototype.hasOwnProperty.call(n, o) &&
                                (e[o] = n[o]);
                    }
                    return e;
                }).apply(this, arguments);
        }
        function r(e) {
            return (r = Object.setPrototypeOf
                ? Object.getPrototypeOf
                : function (e) {
                      return e.__proto__ || Object.getPrototypeOf(e);
                  })(e);
        }
        function a(e, t) {
            return (a =
                Object.setPrototypeOf ||
                function (e, t) {
                    return (e.__proto__ = t), e;
                })(e, t);
        }
        function s(e, t, n) {
            return (s = (function () {
                if ("undefined" == typeof Reflect || !Reflect.construct)
                    return !1;
                if (Reflect.construct.sham) return !1;
                if ("function" == typeof Proxy) return !0;
                try {
                    return (
                        Date.prototype.toString.call(
                            Reflect.construct(Date, [], function () {})
                        ),
                        !0
                    );
                } catch (e) {
                    return !1;
                }
            })()
                ? Reflect.construct
                : function (e, t, n) {
                      var o = [null];
                      o.push.apply(o, t);
                      var i = new (Function.bind.apply(e, o))();
                      return n && a(i, n.prototype), i;
                  }).apply(null, arguments);
        }
        function l(e, t, n) {
            return (l =
                "undefined" != typeof Reflect && Reflect.get
                    ? Reflect.get
                    : function (e, t, n) {
                          var o = (function (e, t) {
                              for (
                                  ;
                                  !Object.prototype.hasOwnProperty.call(e, t) &&
                                  null !== (e = r(e));

                              );
                              return e;
                          })(e, t);
                          if (o) {
                              var i = Object.getOwnPropertyDescriptor(o, t);
                              return i.get ? i.get.call(n) : i.value;
                          }
                      })(e, t, n || e);
        }
        function c(e) {
            return Object.keys(e).map(function (t) {
                return e[t];
            });
        }
        function u(e) {
            return Array.prototype.slice.call(e);
        }
        function d(e) {
            console.error("".concat(B, " ").concat(e));
        }
        function f(e, t) {
            !(function (e) {
                -1 === R.indexOf(e) && (R.push(e), M(e));
            })(
                '"'
                    .concat(
                        e,
                        '" is deprecated and will be removed in the next major release. Please use "'
                    )
                    .concat(t, '" instead.')
            );
        }
        function p(e) {
            return e && Promise.resolve(e) === e;
        }
        function h(t) {
            return (
                t instanceof Element ||
                (function (t) {
                    return "object" === e(t) && t.jquery;
                })(t)
            );
        }
        function m(e) {
            var t = {};
            for (var n in e) t[e[n]] = "swal2-" + e[n];
            return t;
        }
        function g() {
            return document.body.querySelector(".".concat(z.container));
        }
        function w(e) {
            var t = g();
            return t ? t.querySelector(e) : null;
        }
        function v(e) {
            return w(".".concat(e));
        }
        function b() {
            return v(z.popup);
        }
        function y() {
            return u(b().querySelectorAll(".".concat(z.icon)));
        }
        function x() {
            var e = y().filter(function (e) {
                return ce(e);
            });
            return e.length ? e[0] : null;
        }
        function _() {
            return v(z.title);
        }
        function k() {
            return v(z.content);
        }
        function C() {
            return v(z.image);
        }
        function E() {
            return v(z["progress-steps"]);
        }
        function T() {
            return v(z["validation-message"]);
        }
        function S() {
            return w(".".concat(z.actions, " .").concat(z.confirm));
        }
        function A() {
            return w(".".concat(z.actions, " .").concat(z.cancel));
        }
        function D() {
            return v(z.actions);
        }
        function N() {
            return v(z.header);
        }
        function j() {
            return v(z.footer);
        }
        function O() {
            return v(z["timer-progress-bar"]);
        }
        function L() {
            return v(z.close);
        }
        function P() {
            var e = u(
                    b().querySelectorAll(
                        '[tabindex]:not([tabindex="-1"]):not([tabindex="0"])'
                    )
                ).sort(function (e, t) {
                    return (
                        (e = parseInt(e.getAttribute("tabindex"))),
                        (t = parseInt(t.getAttribute("tabindex"))) < e
                            ? 1
                            : e < t
                            ? -1
                            : 0
                    );
                }),
                t = u(
                    b().querySelectorAll(
                        '\n  a[href],\n  area[href],\n  input:not([disabled]),\n  select:not([disabled]),\n  textarea:not([disabled]),\n  button:not([disabled]),\n  iframe,\n  object,\n  embed,\n  [tabindex="0"],\n  [contenteditable],\n  audio[controls],\n  video[controls],\n  summary\n'
                    )
                ).filter(function (e) {
                    return "-1" !== e.getAttribute("tabindex");
                });
            return (function (e) {
                for (var t = [], n = 0; n < e.length; n++)
                    -1 === t.indexOf(e[n]) && t.push(e[n]);
                return t;
            })(e.concat(t)).filter(function (e) {
                return ce(e);
            });
        }
        function I() {
            return !V() && !document.body.classList.contains(z["no-backdrop"]);
        }
        function q(e, t) {
            if (!t) return !1;
            for (var n = t.split(/\s+/), o = 0; o < n.length; o++)
                if (!e.classList.contains(n[o])) return !1;
            return !0;
        }
        function H(t, n, o) {
            if (
                ((function (e, t) {
                    u(e.classList).forEach(function (n) {
                        -1 === c(z).indexOf(n) &&
                            -1 === c(U).indexOf(n) &&
                            -1 === c(t.showClass).indexOf(n) &&
                            e.classList.remove(n);
                    });
                })(t, n),
                n.customClass && n.customClass[o])
            ) {
                if (
                    "string" != typeof n.customClass[o] &&
                    !n.customClass[o].forEach
                )
                    return M(
                        "Invalid type of customClass."
                            .concat(
                                o,
                                '! Expected string or iterable object, got "'
                            )
                            .concat(e(n.customClass[o]), '"')
                    );
                ae(t, n.customClass[o]);
            }
        }
        var B = "SweetAlert2:",
            M = function (e) {
                console.warn("".concat(B, " ").concat(e));
            },
            R = [],
            F = function (e) {
                return "function" == typeof e ? e() : e;
            },
            W = Object.freeze({
                cancel: "cancel",
                backdrop: "backdrop",
                close: "close",
                esc: "esc",
                timer: "timer",
            }),
            z = m([
                "container",
                "shown",
                "height-auto",
                "iosfix",
                "popup",
                "modal",
                "no-backdrop",
                "toast",
                "toast-shown",
                "toast-column",
                "show",
                "hide",
                "close",
                "title",
                "header",
                "content",
                "html-container",
                "actions",
                "confirm",
                "cancel",
                "footer",
                "icon",
                "icon-content",
                "image",
                "input",
                "file",
                "range",
                "select",
                "radio",
                "checkbox",
                "label",
                "textarea",
                "inputerror",
                "validation-message",
                "progress-steps",
                "active-progress-step",
                "progress-step",
                "progress-step-line",
                "loading",
                "styled",
                "top",
                "top-start",
                "top-end",
                "top-left",
                "top-right",
                "center",
                "center-start",
                "center-end",
                "center-left",
                "center-right",
                "bottom",
                "bottom-start",
                "bottom-end",
                "bottom-left",
                "bottom-right",
                "grow-row",
                "grow-column",
                "grow-fullscreen",
                "rtl",
                "timer-progress-bar",
                "scrollbar-measure",
                "icon-success",
                "icon-warning",
                "icon-info",
                "icon-question",
                "icon-error",
            ]),
            U = m(["success", "warning", "info", "question", "error"]),
            V = function () {
                return document.body.classList.contains(z["toast-shown"]);
            },
            $ = { previousBodyPadding: null };
        function Y(e, t) {
            if (!t) return null;
            switch (t) {
                case "select":
                case "textarea":
                case "file":
                    return le(e, z[t]);
                case "checkbox":
                    return e.querySelector(".".concat(z.checkbox, " input"));
                case "radio":
                    return (
                        e.querySelector(
                            ".".concat(z.radio, " input:checked")
                        ) ||
                        e.querySelector(
                            ".".concat(z.radio, " input:first-child")
                        )
                    );
                case "range":
                    return e.querySelector(".".concat(z.range, " input"));
                default:
                    return le(e, z.input);
            }
        }
        function Q(e) {
            if ((e.focus(), "file" !== e.type)) {
                var t = e.value;
                (e.value = ""), (e.value = t);
            }
        }
        function X(e, t, n) {
            e &&
                t &&
                ("string" == typeof t && (t = t.split(/\s+/).filter(Boolean)),
                t.forEach(function (t) {
                    e.forEach
                        ? e.forEach(function (e) {
                              n ? e.classList.add(t) : e.classList.remove(t);
                          })
                        : n
                        ? e.classList.add(t)
                        : e.classList.remove(t);
                }));
        }
        function K(e, t, n) {
            n || 0 === parseInt(n)
                ? (e.style[t] = "number" == typeof n ? "".concat(n, "px") : n)
                : e.style.removeProperty(t);
        }
        function Z(e, t) {
            var n = 1 < arguments.length && void 0 !== t ? t : "flex";
            (e.style.opacity = ""), (e.style.display = n);
        }
        function G(e) {
            (e.style.opacity = ""), (e.style.display = "none");
        }
        function J(e, t, n) {
            t ? Z(e, n) : G(e);
        }
        function ee(e) {
            var t = window.getComputedStyle(e),
                n = parseFloat(t.getPropertyValue("animation-duration") || "0"),
                o = parseFloat(
                    t.getPropertyValue("transition-duration") || "0"
                );
            return 0 < n || 0 < o;
        }
        function te(e, t) {
            var n = 1 < arguments.length && void 0 !== t && t,
                o = O();
            ce(o) &&
                (n && ((o.style.transition = "none"), (o.style.width = "100%")),
                setTimeout(function () {
                    (o.style.transition = "width ".concat(e / 1e3, "s linear")),
                        (o.style.width = "0%");
                }, 10));
        }
        function ne() {
            return (
                "undefined" == typeof window || "undefined" == typeof document
            );
        }
        function oe(e) {
            vt.isVisible() &&
                re !== e.target.value &&
                vt.resetValidationMessage(),
                (re = e.target.value);
        }
        function ie(t, n) {
            t instanceof HTMLElement
                ? n.appendChild(t)
                : "object" === e(t)
                ? de(n, t)
                : t && (n.innerHTML = t);
        }
        var re,
            ae = function (e, t) {
                X(e, t, !0);
            },
            se = function (e, t) {
                X(e, t, !1);
            },
            le = function (e, t) {
                for (var n = 0; n < e.childNodes.length; n++)
                    if (q(e.childNodes[n], t)) return e.childNodes[n];
            },
            ce = function (e) {
                return !(
                    !e ||
                    !(
                        e.offsetWidth ||
                        e.offsetHeight ||
                        e.getClientRects().length
                    )
                );
            },
            ue = '\n <div aria-labelledby="'
                .concat(z.title, '" aria-describedby="')
                .concat(z.content, '" class="')
                .concat(z.popup, '" tabindex="-1">\n   <div class="')
                .concat(z.header, '">\n     <ul class="')
                .concat(z["progress-steps"], '"></ul>\n     <div class="')
                .concat(z.icon, " ")
                .concat(U.error, '"></div>\n     <div class="')
                .concat(z.icon, " ")
                .concat(U.question, '"></div>\n     <div class="')
                .concat(z.icon, " ")
                .concat(U.warning, '"></div>\n     <div class="')
                .concat(z.icon, " ")
                .concat(U.info, '"></div>\n     <div class="')
                .concat(z.icon, " ")
                .concat(U.success, '"></div>\n     <img class="')
                .concat(z.image, '" />\n     <h2 class="')
                .concat(z.title, '" id="')
                .concat(z.title, '"></h2>\n     <button type="button" class="')
                .concat(z.close, '"></button>\n   </div>\n   <div class="')
                .concat(z.content, '">\n     <div id="')
                .concat(z.content, '" class="')
                .concat(z["html-container"], '"></div>\n     <input class="')
                .concat(z.input, '" />\n     <input type="file" class="')
                .concat(z.file, '" />\n     <div class="')
                .concat(
                    z.range,
                    '">\n       <input type="range" />\n       <output></output>\n     </div>\n     <select class="'
                )
                .concat(z.select, '"></select>\n     <div class="')
                .concat(z.radio, '"></div>\n     <label for="')
                .concat(z.checkbox, '" class="')
                .concat(
                    z.checkbox,
                    '">\n       <input type="checkbox" />\n       <span class="'
                )
                .concat(
                    z.label,
                    '"></span>\n     </label>\n     <textarea class="'
                )
                .concat(z.textarea, '"></textarea>\n     <div class="')
                .concat(z["validation-message"], '" id="')
                .concat(
                    z["validation-message"],
                    '"></div>\n   </div>\n   <div class="'
                )
                .concat(z.actions, '">\n     <button type="button" class="')
                .concat(
                    z.confirm,
                    '">OK</button>\n     <button type="button" class="'
                )
                .concat(
                    z.cancel,
                    '">Cancel</button>\n   </div>\n   <div class="'
                )
                .concat(z.footer, '"></div>\n   <div class="')
                .concat(z["timer-progress-bar"], '"></div>\n </div>\n')
                .replace(/(^|\n)\s*/g, ""),
            de = function (e, t) {
                if (((e.innerHTML = ""), 0 in t))
                    for (var n = 0; n in t; n++)
                        e.appendChild(t[n].cloneNode(!0));
                else e.appendChild(t.cloneNode(!0));
            },
            fe = (function () {
                if (ne()) return !1;
                var e = document.createElement("div"),
                    t = {
                        WebkitAnimation: "webkitAnimationEnd",
                        OAnimation: "oAnimationEnd oanimationend",
                        animation: "animationend",
                    };
                for (var n in t)
                    if (
                        Object.prototype.hasOwnProperty.call(t, n) &&
                        void 0 !== e.style[n]
                    )
                        return t[n];
                return !1;
            })();
        function pe(e, t, n) {
            J(
                e,
                n[
                    "show".concat(
                        (function (e) {
                            return e.charAt(0).toUpperCase() + e.slice(1);
                        })(t),
                        "Button"
                    )
                ],
                "inline-block"
            ),
                (e.innerHTML = n["".concat(t, "ButtonText")]),
                e.setAttribute(
                    "aria-label",
                    n["".concat(t, "ButtonAriaLabel")]
                ),
                (e.className = z[t]),
                H(e, n, "".concat(t, "Button")),
                ae(e, n["".concat(t, "ButtonClass")]);
        }
        function he(e, t) {
            (e.placeholder && !t.inputPlaceholder) ||
                (e.placeholder = t.inputPlaceholder);
        }
        var me = {
                promise: new WeakMap(),
                innerParams: new WeakMap(),
                domCache: new WeakMap(),
            },
            ge = [
                "input",
                "file",
                "range",
                "select",
                "radio",
                "checkbox",
                "textarea",
            ],
            we = function (e) {
                if (!xe[e.input])
                    return d(
                        'Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "'.concat(
                            e.input,
                            '"'
                        )
                    );
                var t = ye(e.input),
                    n = xe[e.input](t, e);
                Z(n),
                    setTimeout(function () {
                        Q(n);
                    });
            },
            ve = function (e, t) {
                var n = Y(k(), e);
                if (n)
                    for (var o in ((function (e) {
                        for (var t = 0; t < e.attributes.length; t++) {
                            var n = e.attributes[t].name;
                            -1 === ["type", "value", "style"].indexOf(n) &&
                                e.removeAttribute(n);
                        }
                    })(n),
                    t))
                        ("range" === e && "placeholder" === o) ||
                            n.setAttribute(o, t[o]);
            },
            be = function (e) {
                var t = ye(e.input);
                e.customClass && ae(t, e.customClass.input);
            },
            ye = function (e) {
                var t = z[e] ? z[e] : z.input;
                return le(k(), t);
            },
            xe = {};
        function _e() {
            return g().getAttribute("data-queue-step");
        }
        function ke(e, t) {
            !(function (e, t) {
                var n = b();
                K(n, "width", t.width),
                    K(n, "padding", t.padding),
                    t.background && (n.style.background = t.background),
                    Ne(n, t);
            })(0, t),
                (function (e, t) {
                    var n = g();
                    if (n) {
                        !(function (e, t) {
                            "string" == typeof t
                                ? (e.style.background = t)
                                : t ||
                                  ae(
                                      [document.documentElement, document.body],
                                      z["no-backdrop"]
                                  );
                        })(n, t.backdrop),
                            !t.backdrop &&
                                t.allowOutsideClick &&
                                M(
                                    '"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`'
                                ),
                            (function (e, t) {
                                t in z
                                    ? ae(e, z[t])
                                    : (M(
                                          'The "position" parameter is not valid, defaulting to "center"'
                                      ),
                                      ae(e, z.center));
                            })(n, t.position),
                            (function (e, t) {
                                if (t && "string" == typeof t) {
                                    var n = "grow-".concat(t);
                                    n in z && ae(e, z[n]);
                                }
                            })(n, t.grow),
                            H(n, t, "container");
                        var o = document.body.getAttribute(
                            "data-swal2-queue-step"
                        );
                        o &&
                            (n.setAttribute("data-queue-step", o),
                            document.body.removeAttribute(
                                "data-swal2-queue-step"
                            ));
                    }
                })(0, t),
                (function (e, t) {
                    H(N(), t, "header"),
                        (function (e, t) {
                            var n = E();
                            if (
                                !t.progressSteps ||
                                0 === t.progressSteps.length
                            )
                                return G(n);
                            Z(n), (n.innerHTML = "");
                            var o = parseInt(
                                void 0 === t.currentProgressStep
                                    ? _e()
                                    : t.currentProgressStep
                            );
                            o >= t.progressSteps.length &&
                                M(
                                    "Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"
                                ),
                                t.progressSteps.forEach(function (e, i) {
                                    var r = (function (e) {
                                        var t = document.createElement("li");
                                        return (
                                            ae(t, z["progress-step"]),
                                            (t.innerHTML = e),
                                            t
                                        );
                                    })(e);
                                    if (
                                        (n.appendChild(r),
                                        i === o &&
                                            ae(r, z["active-progress-step"]),
                                        i !== t.progressSteps.length - 1)
                                    ) {
                                        var a = (function (e) {
                                            var t =
                                                document.createElement("li");
                                            return (
                                                ae(t, z["progress-step-line"]),
                                                e.progressStepsDistance &&
                                                    (t.style.width =
                                                        e.progressStepsDistance),
                                                t
                                            );
                                        })(e);
                                        n.appendChild(a);
                                    }
                                });
                        })(0, t),
                        (function (e, t) {
                            var n = me.innerParams.get(e);
                            if (n && t.icon === n.icon && x())
                                H(x(), t, "icon");
                            else if ((Ee(), t.icon))
                                if (-1 !== Object.keys(U).indexOf(t.icon)) {
                                    var o = w(
                                        "."
                                            .concat(z.icon, ".")
                                            .concat(U[t.icon])
                                    );
                                    Z(o),
                                        Se(o, t),
                                        Te(),
                                        H(o, t, "icon"),
                                        ae(o, t.showClass.icon);
                                } else
                                    d(
                                        'Unknown icon! Expected "success", "error", "warning", "info" or "question", got "'.concat(
                                            t.icon,
                                            '"'
                                        )
                                    );
                        })(e, t),
                        (function (e, t) {
                            var n = C();
                            if (!t.imageUrl) return G(n);
                            Z(n),
                                n.setAttribute("src", t.imageUrl),
                                n.setAttribute("alt", t.imageAlt),
                                K(n, "width", t.imageWidth),
                                K(n, "height", t.imageHeight),
                                (n.className = z.image),
                                H(n, t, "image");
                        })(0, t),
                        (function (e, t) {
                            var n = _();
                            J(n, t.title || t.titleText),
                                t.title && ie(t.title, n),
                                t.titleText && (n.innerText = t.titleText),
                                H(n, t, "title");
                        })(0, t),
                        (function (e, t) {
                            var n = L();
                            (n.innerHTML = t.closeButtonHtml),
                                H(n, t, "closeButton"),
                                J(n, t.showCloseButton),
                                n.setAttribute(
                                    "aria-label",
                                    t.closeButtonAriaLabel
                                );
                        })(0, t);
                })(e, t),
                (function (e, t) {
                    var n = k().querySelector("#".concat(z.content));
                    t.html
                        ? (ie(t.html, n), Z(n, "block"))
                        : t.text
                        ? ((n.textContent = t.text), Z(n, "block"))
                        : G(n),
                        (function (e, t) {
                            var n = k(),
                                o = me.innerParams.get(e),
                                i = !o || t.input !== o.input;
                            ge.forEach(function (e) {
                                var o = z[e],
                                    r = le(n, o);
                                ve(e, t.inputAttributes),
                                    (r.className = o),
                                    i && G(r);
                            }),
                                t.input && (i && we(t), be(t));
                        })(e, t),
                        H(k(), t, "content");
                })(e, t),
                (function (e, t) {
                    var n = D(),
                        o = S(),
                        i = A();
                    t.showConfirmButton || t.showCancelButton || G(n),
                        H(n, t, "actions"),
                        pe(o, "confirm", t),
                        pe(i, "cancel", t),
                        t.buttonsStyling
                            ? (function (e, t, n) {
                                  ae([e, t], z.styled),
                                      n.confirmButtonColor &&
                                          (e.style.backgroundColor =
                                              n.confirmButtonColor),
                                      n.cancelButtonColor &&
                                          (t.style.backgroundColor =
                                              n.cancelButtonColor);
                                  var o = window
                                      .getComputedStyle(e)
                                      .getPropertyValue("background-color");
                                  (e.style.borderLeftColor = o),
                                      (e.style.borderRightColor = o);
                              })(o, i, t)
                            : (se([o, i], z.styled),
                              (o.style.backgroundColor =
                                  o.style.borderLeftColor =
                                  o.style.borderRightColor =
                                      ""),
                              (i.style.backgroundColor =
                                  i.style.borderLeftColor =
                                  i.style.borderRightColor =
                                      "")),
                        t.reverseButtons && o.parentNode.insertBefore(i, o);
                })(0, t),
                (function (e, t) {
                    var n = j();
                    J(n, t.footer),
                        t.footer && ie(t.footer, n),
                        H(n, t, "footer");
                })(0, t),
                "function" == typeof t.onRender && t.onRender(b());
        }
        function Ce() {
            return S() && S().click();
        }
        (xe.text =
            xe.email =
            xe.password =
            xe.number =
            xe.tel =
            xe.url =
                function (t, n) {
                    return (
                        "string" == typeof n.inputValue ||
                        "number" == typeof n.inputValue
                            ? (t.value = n.inputValue)
                            : p(n.inputValue) ||
                              M(
                                  'Unexpected type of inputValue! Expected "string", "number" or "Promise", got "'.concat(
                                      e(n.inputValue),
                                      '"'
                                  )
                              ),
                        he(t, n),
                        (t.type = n.input),
                        t
                    );
                }),
            (xe.file = function (e, t) {
                return he(e, t), e;
            }),
            (xe.range = function (e, t) {
                var n = e.querySelector("input"),
                    o = e.querySelector("output");
                return (
                    (n.value = t.inputValue),
                    (n.type = t.input),
                    (o.value = t.inputValue),
                    e
                );
            }),
            (xe.select = function (e, t) {
                if (((e.innerHTML = ""), t.inputPlaceholder)) {
                    var n = document.createElement("option");
                    (n.innerHTML = t.inputPlaceholder),
                        (n.value = ""),
                        (n.disabled = !0),
                        (n.selected = !0),
                        e.appendChild(n);
                }
                return e;
            }),
            (xe.radio = function (e) {
                return (e.innerHTML = ""), e;
            }),
            (xe.checkbox = function (e, t) {
                var n = Y(k(), "checkbox");
                return (
                    (n.value = 1),
                    (n.id = z.checkbox),
                    (n.checked = Boolean(t.inputValue)),
                    (e.querySelector("span").innerHTML = t.inputPlaceholder),
                    e
                );
            }),
            (xe.textarea = function (e, t) {
                if (
                    ((e.value = t.inputValue),
                    he(e, t),
                    "MutationObserver" in window)
                ) {
                    var n = parseInt(window.getComputedStyle(b()).width),
                        o =
                            parseInt(window.getComputedStyle(b()).paddingLeft) +
                            parseInt(window.getComputedStyle(b()).paddingRight);
                    new MutationObserver(function () {
                        var t = e.offsetWidth + o;
                        b().style.width = n < t ? "".concat(t, "px") : null;
                    }).observe(e, {
                        attributes: !0,
                        attributeFilter: ["style"],
                    });
                }
                return e;
            });
        var Ee = function () {
                for (var e = y(), t = 0; t < e.length; t++) G(e[t]);
            },
            Te = function () {
                for (
                    var e = b(),
                        t = window
                            .getComputedStyle(e)
                            .getPropertyValue("background-color"),
                        n = e.querySelectorAll(
                            "[class^=swal2-success-circular-line], .swal2-success-fix"
                        ),
                        o = 0;
                    o < n.length;
                    o++
                )
                    n[o].style.backgroundColor = t;
            },
            Se = function (e, t) {
                (e.innerHTML = ""),
                    t.iconHtml
                        ? (e.innerHTML = Ae(t.iconHtml))
                        : "success" === t.icon
                        ? (e.innerHTML =
                              '\n      <div class="swal2-success-circular-line-left"></div>\n      <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n      <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n      <div class="swal2-success-circular-line-right"></div>\n    ')
                        : "error" === t.icon
                        ? (e.innerHTML =
                              '\n      <span class="swal2-x-mark">\n        <span class="swal2-x-mark-line-left"></span>\n        <span class="swal2-x-mark-line-right"></span>\n      </span>\n    ')
                        : (e.innerHTML = Ae(
                              { question: "?", warning: "!", info: "i" }[t.icon]
                          ));
            },
            Ae = function (e) {
                return '<div class="'
                    .concat(z["icon-content"], '">')
                    .concat(e, "</div>");
            },
            De = [],
            Ne = function (e, t) {
                (e.className = ""
                    .concat(z.popup, " ")
                    .concat(ce(e) ? t.showClass.popup : "")),
                    t.toast
                        ? (ae(
                              [document.documentElement, document.body],
                              z["toast-shown"]
                          ),
                          ae(e, z.toast))
                        : ae(e, z.modal),
                    H(e, t, "popup"),
                    "string" == typeof t.customClass && ae(e, t.customClass),
                    t.icon && ae(e, z["icon-".concat(t.icon)]);
            };
        function je() {
            var e = b();
            e || vt.fire(), (e = b());
            var t = D(),
                n = S();
            Z(t),
                Z(n, "inline-block"),
                ae([e, t], z.loading),
                (n.disabled = !0),
                e.setAttribute("data-loading", !0),
                e.setAttribute("aria-busy", !0),
                e.focus();
        }
        function Oe() {
            if (qe.timeout)
                return (
                    (function () {
                        var e = O(),
                            t = parseInt(window.getComputedStyle(e).width);
                        e.style.removeProperty("transition"),
                            (e.style.width = "100%");
                        var n = parseInt(window.getComputedStyle(e).width),
                            o = parseInt((t / n) * 100);
                        e.style.removeProperty("transition"),
                            (e.style.width = "".concat(o, "%"));
                    })(),
                    qe.timeout.stop()
                );
        }
        function Le() {
            if (qe.timeout) {
                var e = qe.timeout.start();
                return te(e), e;
            }
        }
        function Pe(e) {
            return Object.prototype.hasOwnProperty.call(He, e);
        }
        function Ie(e) {
            return Me[e];
        }
        var qe = {},
            He = {
                title: "",
                titleText: "",
                text: "",
                html: "",
                footer: "",
                icon: void 0,
                iconHtml: void 0,
                toast: !1,
                animation: !0,
                showClass: {
                    popup: "swal2-show",
                    backdrop: "swal2-backdrop-show",
                    icon: "swal2-icon-show",
                },
                hideClass: {
                    popup: "swal2-hide",
                    backdrop: "swal2-backdrop-hide",
                    icon: "swal2-icon-hide",
                },
                customClass: void 0,
                target: "body",
                backdrop: !0,
                heightAuto: !0,
                allowOutsideClick: !0,
                allowEscapeKey: !0,
                allowEnterKey: !0,
                stopKeydownPropagation: !0,
                keydownListenerCapture: !1,
                showConfirmButton: !0,
                showCancelButton: !1,
                preConfirm: void 0,
                confirmButtonText: "OK",
                confirmButtonAriaLabel: "",
                confirmButtonColor: void 0,
                cancelButtonText: "Cancel",
                cancelButtonAriaLabel: "",
                cancelButtonColor: void 0,
                buttonsStyling: !0,
                reverseButtons: !1,
                focusConfirm: !0,
                focusCancel: !1,
                showCloseButton: !1,
                closeButtonHtml: "&times;",
                closeButtonAriaLabel: "Close this dialog",
                showLoaderOnConfirm: !1,
                imageUrl: void 0,
                imageWidth: void 0,
                imageHeight: void 0,
                imageAlt: "",
                timer: void 0,
                timerProgressBar: !1,
                width: void 0,
                padding: void 0,
                background: void 0,
                input: void 0,
                inputPlaceholder: "",
                inputValue: "",
                inputOptions: {},
                inputAutoTrim: !0,
                inputAttributes: {},
                inputValidator: void 0,
                validationMessage: void 0,
                grow: !1,
                position: "center",
                progressSteps: [],
                currentProgressStep: void 0,
                progressStepsDistance: void 0,
                onBeforeOpen: void 0,
                onOpen: void 0,
                onRender: void 0,
                onClose: void 0,
                onAfterClose: void 0,
                scrollbarPadding: !0,
            },
            Be = [
                "title",
                "titleText",
                "text",
                "html",
                "icon",
                "customClass",
                "showConfirmButton",
                "showCancelButton",
                "confirmButtonText",
                "confirmButtonAriaLabel",
                "confirmButtonColor",
                "cancelButtonText",
                "cancelButtonAriaLabel",
                "cancelButtonColor",
                "buttonsStyling",
                "reverseButtons",
                "imageUrl",
                "imageWidth",
                "imageHeight",
                "imageAlt",
                "progressSteps",
                "currentProgressStep",
            ],
            Me = { animation: 'showClass" and "hideClass' },
            Re = [
                "allowOutsideClick",
                "allowEnterKey",
                "backdrop",
                "focusConfirm",
                "focusCancel",
                "heightAuto",
                "keydownListenerCapture",
            ],
            Fe = Object.freeze({
                isValidParameter: Pe,
                isUpdatableParameter: function (e) {
                    return -1 !== Be.indexOf(e);
                },
                isDeprecatedParameter: Ie,
                argsToParams: function (t) {
                    var n = {};
                    return (
                        "object" !== e(t[0]) || h(t[0])
                            ? ["title", "html", "icon"].forEach(function (
                                  o,
                                  i
                              ) {
                                  var r = t[i];
                                  "string" == typeof r || h(r)
                                      ? (n[o] = r)
                                      : void 0 !== r &&
                                        d(
                                            "Unexpected type of "
                                                .concat(
                                                    o,
                                                    '! Expected "string" or "Element", got '
                                                )
                                                .concat(e(r))
                                        );
                              })
                            : i(n, t[0]),
                        n
                    );
                },
                isVisible: function () {
                    return ce(b());
                },
                clickConfirm: Ce,
                clickCancel: function () {
                    return A() && A().click();
                },
                getContainer: g,
                getPopup: b,
                getTitle: _,
                getContent: k,
                getHtmlContainer: function () {
                    return v(z["html-container"]);
                },
                getImage: C,
                getIcon: x,
                getIcons: y,
                getCloseButton: L,
                getActions: D,
                getConfirmButton: S,
                getCancelButton: A,
                getHeader: N,
                getFooter: j,
                getFocusableElements: P,
                getValidationMessage: T,
                isLoading: function () {
                    return b().hasAttribute("data-loading");
                },
                fire: function () {
                    for (
                        var e = arguments.length, t = new Array(e), n = 0;
                        n < e;
                        n++
                    )
                        t[n] = arguments[n];
                    return s(this, t);
                },
                mixin: function (e) {
                    return (function (n) {
                        function s() {
                            return (
                                t(this, s),
                                (function (e, t) {
                                    return !t ||
                                        ("object" != typeof t &&
                                            "function" != typeof t)
                                        ? (function (e) {
                                              if (void 0 === e)
                                                  throw new ReferenceError(
                                                      "this hasn't been initialised - super() hasn't been called"
                                                  );
                                              return e;
                                          })(e)
                                        : t;
                                })(this, r(s).apply(this, arguments))
                            );
                        }
                        return (
                            (function (e, t) {
                                if ("function" != typeof t && null !== t)
                                    throw new TypeError(
                                        "Super expression must either be null or a function"
                                    );
                                (e.prototype = Object.create(t && t.prototype, {
                                    constructor: {
                                        value: e,
                                        writable: !0,
                                        configurable: !0,
                                    },
                                })),
                                    t && a(e, t);
                            })(s, n),
                            o(s, [
                                {
                                    key: "_main",
                                    value: function (t) {
                                        return l(
                                            r(s.prototype),
                                            "_main",
                                            this
                                        ).call(this, i({}, e, t));
                                    },
                                },
                            ]),
                            s
                        );
                    })(this);
                },
                queue: function (e) {
                    var t = this;
                    function n(e, t) {
                        (De = []), e(t);
                    }
                    De = e;
                    var o = [];
                    return new Promise(function (e) {
                        !(function i(r, a) {
                            r < De.length
                                ? (document.body.setAttribute(
                                      "data-swal2-queue-step",
                                      r
                                  ),
                                  t.fire(De[r]).then(function (t) {
                                      void 0 !== t.value
                                          ? (o.push(t.value), i(r + 1, a))
                                          : n(e, { dismiss: t.dismiss });
                                  }))
                                : n(e, { value: o });
                        })(0);
                    });
                },
                getQueueStep: _e,
                insertQueueStep: function (e, t) {
                    return t && t < De.length ? De.splice(t, 0, e) : De.push(e);
                },
                deleteQueueStep: function (e) {
                    void 0 !== De[e] && De.splice(e, 1);
                },
                showLoading: je,
                enableLoading: je,
                getTimerLeft: function () {
                    return qe.timeout && qe.timeout.getTimerLeft();
                },
                stopTimer: Oe,
                resumeTimer: Le,
                toggleTimer: function () {
                    var e = qe.timeout;
                    return e && (e.running ? Oe() : Le());
                },
                increaseTimer: function (e) {
                    if (qe.timeout) {
                        var t = qe.timeout.increase(e);
                        return te(t, !0), t;
                    }
                },
                isTimerRunning: function () {
                    return qe.timeout && qe.timeout.isRunning();
                },
            });
        function We() {
            var e = me.innerParams.get(this);
            if (e) {
                var t = me.domCache.get(this);
                e.showConfirmButton ||
                    (G(t.confirmButton), e.showCancelButton || G(t.actions)),
                    se([t.popup, t.actions], z.loading),
                    t.popup.removeAttribute("aria-busy"),
                    t.popup.removeAttribute("data-loading"),
                    (t.confirmButton.disabled = !1),
                    (t.cancelButton.disabled = !1);
            }
        }
        function ze() {
            return !!window.MSInputMethodContext && !!document.documentMode;
        }
        function Ue() {
            var e = g(),
                t = b();
            e.style.removeProperty("align-items"),
                t.offsetTop < 0 && (e.style.alignItems = "flex-start");
        }
        var Ve = { swalPromiseResolve: new WeakMap() };
        function $e(e, t, n, o) {
            n
                ? Ke(e, o)
                : (new Promise(function (e) {
                      var t = window.scrollX,
                          n = window.scrollY;
                      (qe.restoreFocusTimeout = setTimeout(function () {
                          qe.previousActiveElement &&
                          qe.previousActiveElement.focus
                              ? (qe.previousActiveElement.focus(),
                                (qe.previousActiveElement = null))
                              : document.body && document.body.focus(),
                              e();
                      }, 100)),
                          void 0 !== t && void 0 !== n && window.scrollTo(t, n);
                  }).then(function () {
                      return Ke(e, o);
                  }),
                  qe.keydownTarget.removeEventListener(
                      "keydown",
                      qe.keydownHandler,
                      { capture: qe.keydownListenerCapture }
                  ),
                  (qe.keydownHandlerAdded = !1)),
                t.parentNode && t.parentNode.removeChild(t),
                I() &&
                    (null !== $.previousBodyPadding &&
                        ((document.body.style.paddingRight = "".concat(
                            $.previousBodyPadding,
                            "px"
                        )),
                        ($.previousBodyPadding = null)),
                    (function () {
                        if (q(document.body, z.iosfix)) {
                            var e = parseInt(document.body.style.top, 10);
                            se(document.body, z.iosfix),
                                (document.body.style.top = ""),
                                (document.body.scrollTop = -1 * e);
                        }
                    })(),
                    "undefined" != typeof window &&
                        ze() &&
                        window.removeEventListener("resize", Ue),
                    u(document.body.children).forEach(function (e) {
                        e.hasAttribute("data-previous-aria-hidden")
                            ? (e.setAttribute(
                                  "aria-hidden",
                                  e.getAttribute("data-previous-aria-hidden")
                              ),
                              e.removeAttribute("data-previous-aria-hidden"))
                            : e.removeAttribute("aria-hidden");
                    })),
                se(
                    [document.documentElement, document.body],
                    [
                        z.shown,
                        z["height-auto"],
                        z["no-backdrop"],
                        z["toast-shown"],
                        z["toast-column"],
                    ]
                );
        }
        function Ye(e) {
            var t = b();
            if (t) {
                var n = me.innerParams.get(this);
                if (n && !q(t, n.hideClass.popup)) {
                    var o = Ve.swalPromiseResolve.get(this);
                    se(t, n.showClass.popup), ae(t, n.hideClass.popup);
                    var i = g();
                    se(i, n.showClass.backdrop),
                        ae(i, n.hideClass.backdrop),
                        (function (e, t, n) {
                            var o = g(),
                                i = fe && ee(t),
                                r = n.onClose,
                                a = n.onAfterClose;
                            null !== r && "function" == typeof r && r(t),
                                i ? Xe(e, t, o, a) : $e(e, o, V(), a);
                        })(this, t, n),
                        o(e || {});
                }
            }
        }
        function Qe(e) {
            for (var t in e) e[t] = new WeakMap();
        }
        var Xe = function (e, t, n, o) {
                (qe.swalCloseEventFinishedCallback = $e.bind(
                    null,
                    e,
                    n,
                    V(),
                    o
                )),
                    t.addEventListener(fe, function (e) {
                        e.target === t &&
                            (qe.swalCloseEventFinishedCallback(),
                            delete qe.swalCloseEventFinishedCallback);
                    });
            },
            Ke = function (e, t) {
                setTimeout(function () {
                    null !== t && "function" == typeof t && t(),
                        b() ||
                            (function (e) {
                                delete e.params,
                                    delete qe.keydownHandler,
                                    delete qe.keydownTarget,
                                    Qe(me),
                                    Qe(Ve);
                            })(e);
                });
            };
        function Ze(e, t, n) {
            var o = me.domCache.get(e);
            t.forEach(function (e) {
                o[e].disabled = n;
            });
        }
        function Ge(e, t) {
            if (!e) return !1;
            if ("radio" === e.type)
                for (
                    var n = e.parentNode.parentNode.querySelectorAll("input"),
                        o = 0;
                    o < n.length;
                    o++
                )
                    n[o].disabled = t;
            else e.disabled = t;
        }
        var Je = (function () {
                function e(n, o) {
                    t(this, e),
                        (this.callback = n),
                        (this.remaining = o),
                        (this.running = !1),
                        this.start();
                }
                return (
                    o(e, [
                        {
                            key: "start",
                            value: function () {
                                return (
                                    this.running ||
                                        ((this.running = !0),
                                        (this.started = new Date()),
                                        (this.id = setTimeout(
                                            this.callback,
                                            this.remaining
                                        ))),
                                    this.remaining
                                );
                            },
                        },
                        {
                            key: "stop",
                            value: function () {
                                return (
                                    this.running &&
                                        ((this.running = !1),
                                        clearTimeout(this.id),
                                        (this.remaining -=
                                            new Date() - this.started)),
                                    this.remaining
                                );
                            },
                        },
                        {
                            key: "increase",
                            value: function (e) {
                                var t = this.running;
                                return (
                                    t && this.stop(),
                                    (this.remaining += e),
                                    t && this.start(),
                                    this.remaining
                                );
                            },
                        },
                        {
                            key: "getTimerLeft",
                            value: function () {
                                return (
                                    this.running && (this.stop(), this.start()),
                                    this.remaining
                                );
                            },
                        },
                        {
                            key: "isRunning",
                            value: function () {
                                return this.running;
                            },
                        },
                    ]),
                    e
                );
            })(),
            et = {
                email: function (e, t) {
                    return /^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(
                        e
                    )
                        ? Promise.resolve()
                        : Promise.resolve(t || "Invalid email address");
                },
                url: function (e, t) {
                    return /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&\/=]*)$/.test(
                        e
                    )
                        ? Promise.resolve()
                        : Promise.resolve(t || "Invalid URL");
                },
            };
        function tt(e, t) {
            e.removeEventListener(fe, tt), (t.style.overflowY = "auto");
        }
        function nt(e, t) {
            e.closePopup({ value: t });
        }
        function ot(e, t, n) {
            for (var o = P(), i = 0; i < o.length; i++)
                return (
                    (t += n) === o.length
                        ? (t = 0)
                        : -1 === t && (t = o.length - 1),
                    o[t].focus()
                );
            b().focus();
        }
        var it,
            rt = function (t, n) {
                function o(e) {
                    return at[n.input](i, st(e), n);
                }
                var i = k();
                p(n.inputOptions)
                    ? (je(),
                      n.inputOptions.then(function (e) {
                          t.hideLoading(), o(e);
                      }))
                    : "object" === e(n.inputOptions)
                    ? o(n.inputOptions)
                    : d(
                          "Unexpected type of inputOptions! Expected object, Map or Promise, got ".concat(
                              e(n.inputOptions)
                          )
                      );
            },
            at = {
                select: function (e, t, n) {
                    var o = le(e, z.select);
                    t.forEach(function (e) {
                        var t = e[0],
                            i = e[1],
                            r = document.createElement("option");
                        (r.value = t),
                            (r.innerHTML = i),
                            n.inputValue.toString() === t.toString() &&
                                (r.selected = !0),
                            o.appendChild(r);
                    }),
                        o.focus();
                },
                radio: function (e, t, n) {
                    var o = le(e, z.radio);
                    t.forEach(function (e) {
                        var t = e[0],
                            i = e[1],
                            r = document.createElement("input"),
                            a = document.createElement("label");
                        (r.type = "radio"),
                            (r.name = z.radio),
                            (r.value = t),
                            n.inputValue.toString() === t.toString() &&
                                (r.checked = !0);
                        var s = document.createElement("span");
                        (s.innerHTML = i),
                            (s.className = z.label),
                            a.appendChild(r),
                            a.appendChild(s),
                            o.appendChild(a);
                    });
                    var i = o.querySelectorAll("input");
                    i.length && i[0].focus();
                },
            },
            st = function (e) {
                var t = [];
                return (
                    "undefined" != typeof Map && e instanceof Map
                        ? e.forEach(function (e, n) {
                              t.push([n, e]);
                          })
                        : Object.keys(e).forEach(function (n) {
                              t.push([n, e[n]]);
                          }),
                    t
                );
            },
            lt = function (e, t, n) {
                t.showLoaderOnConfirm && je(),
                    t.preConfirm
                        ? (e.resetValidationMessage(),
                          Promise.resolve()
                              .then(function () {
                                  return t.preConfirm(n, t.validationMessage);
                              })
                              .then(function (t) {
                                  ce(T()) || !1 === t
                                      ? e.hideLoading()
                                      : nt(e, void 0 === t ? n : t);
                              }))
                        : nt(e, n);
            },
            ct = [
                "ArrowLeft",
                "ArrowRight",
                "ArrowUp",
                "ArrowDown",
                "Left",
                "Right",
                "Up",
                "Down",
            ],
            ut = ["Escape", "Esc"],
            dt = function (e, t, n) {
                if (
                    !t.isComposing &&
                    t.target &&
                    e.getInput() &&
                    t.target.outerHTML === e.getInput().outerHTML
                ) {
                    if (-1 !== ["textarea", "file"].indexOf(n.input)) return;
                    Ce(), t.preventDefault();
                }
            },
            ft = function (e) {
                for (
                    var t = e.target, n = P(), o = -1, i = 0;
                    i < n.length;
                    i++
                )
                    if (t === n[i]) {
                        o = i;
                        break;
                    }
                e.shiftKey ? ot(0, o, -1) : ot(0, o, 1),
                    e.stopPropagation(),
                    e.preventDefault();
            },
            pt = function () {
                var e = S(),
                    t = A();
                document.activeElement === e && ce(t)
                    ? t.focus()
                    : document.activeElement === t && ce(e) && e.focus();
            },
            ht = function (e, t, n) {
                F(t.allowEscapeKey) && (e.preventDefault(), n(W.esc));
            },
            mt = !1,
            gt = Object.freeze({
                hideLoading: We,
                disableLoading: We,
                getInput: function (e) {
                    var t = me.innerParams.get(e || this),
                        n = me.domCache.get(e || this);
                    return n ? Y(n.content, t.input) : null;
                },
                close: Ye,
                closePopup: Ye,
                closeModal: Ye,
                closeToast: Ye,
                enableButtons: function () {
                    Ze(this, ["confirmButton", "cancelButton"], !1);
                },
                disableButtons: function () {
                    Ze(this, ["confirmButton", "cancelButton"], !0);
                },
                enableInput: function () {
                    return Ge(this.getInput(), !1);
                },
                disableInput: function () {
                    return Ge(this.getInput(), !0);
                },
                showValidationMessage: function (e) {
                    var t = me.domCache.get(this);
                    t.validationMessage.innerHTML = e;
                    var n = window.getComputedStyle(t.popup);
                    (t.validationMessage.style.marginLeft = "-".concat(
                        n.getPropertyValue("padding-left")
                    )),
                        (t.validationMessage.style.marginRight = "-".concat(
                            n.getPropertyValue("padding-right")
                        )),
                        Z(t.validationMessage);
                    var o = this.getInput();
                    o &&
                        (o.setAttribute("aria-invalid", !0),
                        o.setAttribute(
                            "aria-describedBy",
                            z["validation-message"]
                        ),
                        Q(o),
                        ae(o, z.inputerror));
                },
                resetValidationMessage: function () {
                    var e = me.domCache.get(this);
                    e.validationMessage && G(e.validationMessage);
                    var t = this.getInput();
                    t &&
                        (t.removeAttribute("aria-invalid"),
                        t.removeAttribute("aria-describedBy"),
                        se(t, z.inputerror));
                },
                getProgressSteps: function () {
                    return me.domCache.get(this).progressSteps;
                },
                _main: function (e) {
                    !(function (e) {
                        for (var t in e)
                            Pe((i = t)) ||
                                M('Unknown parameter "'.concat(i, '"')),
                                e.toast &&
                                    ((o = t),
                                    -1 !== Re.indexOf(o) &&
                                        M(
                                            'The parameter "'.concat(
                                                o,
                                                '" is incompatible with toasts'
                                            )
                                        )),
                                Ie((n = t)) && f(n, Ie(n));
                        var n, o, i;
                    })(e),
                        b() &&
                            qe.swalCloseEventFinishedCallback &&
                            (qe.swalCloseEventFinishedCallback(),
                            delete qe.swalCloseEventFinishedCallback),
                        qe.deferDisposalTimer &&
                            (clearTimeout(qe.deferDisposalTimer),
                            delete qe.deferDisposalTimer);
                    var t = (function (e) {
                        var t = i({}, He.showClass, e.showClass),
                            n = i({}, He.hideClass, e.hideClass),
                            o = i({}, He, e);
                        return (
                            (o.showClass = t),
                            (o.hideClass = n),
                            !1 === e.animation &&
                                ((o.showClass = {
                                    popup: "",
                                    backdrop:
                                        "swal2-backdrop-show swal2-noanimation",
                                }),
                                (o.hideClass = {})),
                            o
                        );
                    })(e);
                    (function (e) {
                        var t;
                        (t = e).inputValidator ||
                            Object.keys(et).forEach(function (e) {
                                t.input === e && (t.inputValidator = et[e]);
                            }),
                            e.showLoaderOnConfirm &&
                                !e.preConfirm &&
                                M(
                                    "showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://sweetalert2.github.io/#ajax-request"
                                ),
                            (e.animation = F(e.animation)),
                            (function (e) {
                                (e.target &&
                                    ("string" != typeof e.target ||
                                        document.querySelector(e.target)) &&
                                    ("string" == typeof e.target ||
                                        e.target.appendChild)) ||
                                    (M(
                                        'Target parameter is not valid, defaulting to "body"'
                                    ),
                                    (e.target = "body"));
                            })(e),
                            "string" == typeof e.title &&
                                (e.title = e.title.split("\n").join("<br />")),
                            (function (e) {
                                if (
                                    ((function () {
                                        var e = g();
                                        e &&
                                            (e.parentNode.removeChild(e),
                                            se(
                                                [
                                                    document.documentElement,
                                                    document.body,
                                                ],
                                                [
                                                    z["no-backdrop"],
                                                    z["toast-shown"],
                                                    z["has-column"],
                                                ]
                                            ));
                                    })(),
                                    ne())
                                )
                                    d(
                                        "SweetAlert2 requires document to initialize"
                                    );
                                else {
                                    var t = document.createElement("div");
                                    (t.className = z.container),
                                        (t.innerHTML = ue);
                                    var n = (function (e) {
                                        return "string" == typeof e
                                            ? document.querySelector(e)
                                            : e;
                                    })(e.target);
                                    n.appendChild(t),
                                        (function (e) {
                                            var t = b();
                                            t.setAttribute(
                                                "role",
                                                e.toast ? "alert" : "dialog"
                                            ),
                                                t.setAttribute(
                                                    "aria-live",
                                                    e.toast
                                                        ? "polite"
                                                        : "assertive"
                                                ),
                                                e.toast ||
                                                    t.setAttribute(
                                                        "aria-modal",
                                                        "true"
                                                    );
                                        })(e),
                                        (function (e) {
                                            "rtl" ===
                                                window.getComputedStyle(e)
                                                    .direction &&
                                                ae(g(), z.rtl);
                                        })(n),
                                        (function () {
                                            var e = k(),
                                                t = le(e, z.input),
                                                n = le(e, z.file),
                                                o = e.querySelector(
                                                    ".".concat(
                                                        z.range,
                                                        " input"
                                                    )
                                                ),
                                                i = e.querySelector(
                                                    ".".concat(
                                                        z.range,
                                                        " output"
                                                    )
                                                ),
                                                r = le(e, z.select),
                                                a = e.querySelector(
                                                    ".".concat(
                                                        z.checkbox,
                                                        " input"
                                                    )
                                                ),
                                                s = le(e, z.textarea);
                                            (t.oninput = oe),
                                                (n.onchange = oe),
                                                (r.onchange = oe),
                                                (a.onchange = oe),
                                                (s.oninput = oe),
                                                (o.oninput = function (e) {
                                                    oe(e), (i.value = o.value);
                                                }),
                                                (o.onchange = function (e) {
                                                    oe(e),
                                                        (o.nextSibling.value =
                                                            o.value);
                                                });
                                        })();
                                }
                            })(e);
                    })(t),
                        Object.freeze(t),
                        qe.timeout && (qe.timeout.stop(), delete qe.timeout),
                        clearTimeout(qe.restoreFocusTimeout);
                    var n = (function (e) {
                        var t = {
                            popup: b(),
                            container: g(),
                            content: k(),
                            actions: D(),
                            confirmButton: S(),
                            cancelButton: A(),
                            closeButton: L(),
                            validationMessage: T(),
                            progressSteps: E(),
                        };
                        return me.domCache.set(e, t), t;
                    })(this);
                    return (
                        ke(this, t),
                        me.innerParams.set(this, t),
                        (function (e, t, n) {
                            return new Promise(function (o) {
                                var i = function (t) {
                                    e.closePopup({ dismiss: t });
                                };
                                Ve.swalPromiseResolve.set(e, o),
                                    (function (e, t, n) {
                                        var o = O();
                                        G(o),
                                            t.timer &&
                                                ((e.timeout = new Je(
                                                    function () {
                                                        n("timer"),
                                                            delete e.timeout;
                                                    },
                                                    t.timer
                                                )),
                                                t.timerProgressBar &&
                                                    (Z(o),
                                                    setTimeout(function () {
                                                        te(t.timer);
                                                    })));
                                    })(qe, n, i),
                                    (t.confirmButton.onclick = function () {
                                        return (
                                            (o = n),
                                            (t = e).disableButtons(),
                                            void (o.input
                                                ? (function (e, t) {
                                                      var n = (function (e, t) {
                                                          var n = e.getInput();
                                                          if (!n) return null;
                                                          switch (t.input) {
                                                              case "checkbox":
                                                                  return n.checked
                                                                      ? 1
                                                                      : 0;
                                                              case "radio":
                                                                  return (function (
                                                                      e
                                                                  ) {
                                                                      return e.checked
                                                                          ? e.value
                                                                          : null;
                                                                  })(n);
                                                              case "file":
                                                                  return (function (
                                                                      e
                                                                  ) {
                                                                      return e
                                                                          .files
                                                                          .length
                                                                          ? null !==
                                                                            e.getAttribute(
                                                                                "multiple"
                                                                            )
                                                                              ? e.files
                                                                              : e
                                                                                    .files[0]
                                                                          : null;
                                                                  })(n);
                                                              default:
                                                                  return t.inputAutoTrim
                                                                      ? n.value.trim()
                                                                      : n.value;
                                                          }
                                                      })(e, t);
                                                      t.inputValidator
                                                          ? (e.disableInput(),
                                                            Promise.resolve()
                                                                .then(
                                                                    function () {
                                                                        return t.inputValidator(
                                                                            n,
                                                                            t.validationMessage
                                                                        );
                                                                    }
                                                                )
                                                                .then(function (
                                                                    o
                                                                ) {
                                                                    e.enableButtons(),
                                                                        e.enableInput(),
                                                                        o
                                                                            ? e.showValidationMessage(
                                                                                  o
                                                                              )
                                                                            : lt(
                                                                                  e,
                                                                                  t,
                                                                                  n
                                                                              );
                                                                }))
                                                          : e
                                                                .getInput()
                                                                .checkValidity()
                                                          ? lt(e, t, n)
                                                          : (e.enableButtons(),
                                                            e.showValidationMessage(
                                                                t.validationMessage
                                                            ));
                                                  })(t, o)
                                                : lt(t, o, !0))
                                        );
                                        var t, o;
                                    }),
                                    (t.cancelButton.onclick = function () {
                                        return (function (e, t) {
                                            e.disableButtons(), t(W.cancel);
                                        })(e, i);
                                    }),
                                    (t.closeButton.onclick = function () {
                                        return i(W.close);
                                    }),
                                    (function (e, t, n) {
                                        t.toast
                                            ? (function (e, t, n) {
                                                  e.popup.onclick =
                                                      function () {
                                                          t.showConfirmButton ||
                                                              t.showCancelButton ||
                                                              t.showCloseButton ||
                                                              t.input ||
                                                              n(W.close);
                                                      };
                                              })(e, t, n)
                                            : ((function (e) {
                                                  e.popup.onmousedown =
                                                      function () {
                                                          e.container.onmouseup =
                                                              function (t) {
                                                                  (e.container.onmouseup =
                                                                      void 0),
                                                                      t.target ===
                                                                          e.container &&
                                                                          (mt =
                                                                              !0);
                                                              };
                                                      };
                                              })(e),
                                              (function (e) {
                                                  e.container.onmousedown =
                                                      function () {
                                                          e.popup.onmouseup =
                                                              function (t) {
                                                                  (e.popup.onmouseup =
                                                                      void 0),
                                                                      (t.target !==
                                                                          e.popup &&
                                                                          !e.popup.contains(
                                                                              t.target
                                                                          )) ||
                                                                          (mt =
                                                                              !0);
                                                              };
                                                      };
                                              })(e),
                                              (function (e, t, n) {
                                                  e.container.onclick =
                                                      function (o) {
                                                          mt
                                                              ? (mt = !1)
                                                              : o.target ===
                                                                    e.container &&
                                                                F(
                                                                    t.allowOutsideClick
                                                                ) &&
                                                                n(W.backdrop);
                                                      };
                                              })(e, t, n));
                                    })(t, n, i),
                                    (function (e, t, n, o) {
                                        t.keydownTarget &&
                                            t.keydownHandlerAdded &&
                                            (t.keydownTarget.removeEventListener(
                                                "keydown",
                                                t.keydownHandler,
                                                {
                                                    capture:
                                                        t.keydownListenerCapture,
                                                }
                                            ),
                                            (t.keydownHandlerAdded = !1)),
                                            n.toast ||
                                                ((t.keydownHandler = function (
                                                    t
                                                ) {
                                                    return (function (
                                                        e,
                                                        t,
                                                        n,
                                                        o
                                                    ) {
                                                        n.stopKeydownPropagation &&
                                                            t.stopPropagation(),
                                                            "Enter" === t.key
                                                                ? dt(e, t, n)
                                                                : "Tab" ===
                                                                  t.key
                                                                ? ft(t, n)
                                                                : -1 !==
                                                                  ct.indexOf(
                                                                      t.key
                                                                  )
                                                                ? pt()
                                                                : -1 !==
                                                                      ut.indexOf(
                                                                          t.key
                                                                      ) &&
                                                                  ht(t, n, o);
                                                    })(e, t, n, o);
                                                }),
                                                (t.keydownTarget =
                                                    n.keydownListenerCapture
                                                        ? window
                                                        : b()),
                                                (t.keydownListenerCapture =
                                                    n.keydownListenerCapture),
                                                t.keydownTarget.addEventListener(
                                                    "keydown",
                                                    t.keydownHandler,
                                                    {
                                                        capture:
                                                            t.keydownListenerCapture,
                                                    }
                                                ),
                                                (t.keydownHandlerAdded = !0));
                                    })(e, qe, n, i),
                                    n.toast &&
                                    (n.input || n.footer || n.showCloseButton)
                                        ? ae(document.body, z["toast-column"])
                                        : se(document.body, z["toast-column"]),
                                    (function (e, t) {
                                        "select" === t.input ||
                                        "radio" === t.input
                                            ? rt(e, t)
                                            : -1 !==
                                                  [
                                                      "text",
                                                      "email",
                                                      "number",
                                                      "tel",
                                                      "textarea",
                                                  ].indexOf(t.input) &&
                                              p(t.inputValue) &&
                                              (function (e, t) {
                                                  var n = e.getInput();
                                                  G(n),
                                                      t.inputValue
                                                          .then(function (o) {
                                                              (n.value =
                                                                  "number" ===
                                                                  t.input
                                                                      ? parseFloat(
                                                                            o
                                                                        ) || 0
                                                                      : "".concat(
                                                                            o
                                                                        )),
                                                                  Z(n),
                                                                  n.focus(),
                                                                  e.hideLoading();
                                                          })
                                                          .catch(function (t) {
                                                              d(
                                                                  "Error in inputValue promise: ".concat(
                                                                      t
                                                                  )
                                                              ),
                                                                  (n.value =
                                                                      ""),
                                                                  Z(n),
                                                                  n.focus(),
                                                                  e.hideLoading();
                                                          });
                                              })(e, t);
                                    })(e, n),
                                    (function (e) {
                                        var t = g(),
                                            n = b();
                                        "function" == typeof e.onBeforeOpen &&
                                            e.onBeforeOpen(n),
                                            (function (e, t, n) {
                                                ae(e, n.showClass.backdrop),
                                                    Z(t),
                                                    ae(t, n.showClass.popup),
                                                    ae(
                                                        [
                                                            document.documentElement,
                                                            document.body,
                                                        ],
                                                        z.shown
                                                    ),
                                                    n.heightAuto &&
                                                        n.backdrop &&
                                                        !n.toast &&
                                                        ae(
                                                            [
                                                                document.documentElement,
                                                                document.body,
                                                            ],
                                                            z["height-auto"]
                                                        );
                                            })(t, n, e),
                                            (function (e, t) {
                                                fe && ee(t)
                                                    ? ((e.style.overflowY =
                                                          "hidden"),
                                                      t.addEventListener(
                                                          fe,
                                                          function (n) {
                                                              n.target === t &&
                                                                  tt.bind(
                                                                      null,
                                                                      t,
                                                                      e
                                                                  );
                                                          }
                                                      ))
                                                    : (e.style.overflowY =
                                                          "auto");
                                            })(t, n),
                                            I() &&
                                                (function (e, t) {
                                                    !(function () {
                                                        if (
                                                            ((/iPad|iPhone|iPod/.test(
                                                                navigator.userAgent
                                                            ) &&
                                                                !window.MSStream) ||
                                                                ("MacIntel" ===
                                                                    navigator.platform &&
                                                                    1 <
                                                                        navigator.maxTouchPoints)) &&
                                                            !q(
                                                                document.body,
                                                                z.iosfix
                                                            )
                                                        ) {
                                                            var e =
                                                                document.body
                                                                    .scrollTop;
                                                            (document.body.style.top =
                                                                "".concat(
                                                                    -1 * e,
                                                                    "px"
                                                                )),
                                                                ae(
                                                                    document.body,
                                                                    z.iosfix
                                                                ),
                                                                ((n =
                                                                    g()).ontouchstart =
                                                                    function (
                                                                        e
                                                                    ) {
                                                                        t =
                                                                            e.target ===
                                                                                n ||
                                                                            (!(function (
                                                                                e
                                                                            ) {
                                                                                return !!(
                                                                                    e.scrollHeight >
                                                                                    e.clientHeight
                                                                                );
                                                                            })(
                                                                                n
                                                                            ) &&
                                                                                "INPUT" !==
                                                                                    e
                                                                                        .target
                                                                                        .tagName);
                                                                    }),
                                                                (n.ontouchmove =
                                                                    function (
                                                                        e
                                                                    ) {
                                                                        t &&
                                                                            (e.preventDefault(),
                                                                            e.stopPropagation());
                                                                    });
                                                        }
                                                        var t, n;
                                                    })(),
                                                        "undefined" !=
                                                            typeof window &&
                                                            ze() &&
                                                            (Ue(),
                                                            window.addEventListener(
                                                                "resize",
                                                                Ue
                                                            )),
                                                        u(
                                                            document.body
                                                                .children
                                                        ).forEach(function (e) {
                                                            e === g() ||
                                                                (function (
                                                                    e,
                                                                    t
                                                                ) {
                                                                    if (
                                                                        "function" ==
                                                                        typeof e.contains
                                                                    )
                                                                        return e.contains(
                                                                            t
                                                                        );
                                                                })(e, g()) ||
                                                                (e.hasAttribute(
                                                                    "aria-hidden"
                                                                ) &&
                                                                    e.setAttribute(
                                                                        "data-previous-aria-hidden",
                                                                        e.getAttribute(
                                                                            "aria-hidden"
                                                                        )
                                                                    ),
                                                                e.setAttribute(
                                                                    "aria-hidden",
                                                                    "true"
                                                                ));
                                                        }),
                                                        t &&
                                                            null ===
                                                                $.previousBodyPadding &&
                                                            document.body
                                                                .scrollHeight >
                                                                window.innerHeight &&
                                                            (($.previousBodyPadding =
                                                                parseInt(
                                                                    window
                                                                        .getComputedStyle(
                                                                            document.body
                                                                        )
                                                                        .getPropertyValue(
                                                                            "padding-right"
                                                                        )
                                                                )),
                                                            (document.body.style.paddingRight =
                                                                "".concat(
                                                                    $.previousBodyPadding +
                                                                        (function () {
                                                                            var e =
                                                                                document.createElement(
                                                                                    "div"
                                                                                );
                                                                            (e.className =
                                                                                z[
                                                                                    "scrollbar-measure"
                                                                                ]),
                                                                                document.body.appendChild(
                                                                                    e
                                                                                );
                                                                            var t =
                                                                                e.getBoundingClientRect()
                                                                                    .width -
                                                                                e.clientWidth;
                                                                            return (
                                                                                document.body.removeChild(
                                                                                    e
                                                                                ),
                                                                                t
                                                                            );
                                                                        })(),
                                                                    "px"
                                                                ))),
                                                        setTimeout(function () {
                                                            e.scrollTop = 0;
                                                        });
                                                })(t, e.scrollbarPadding),
                                            V() ||
                                                qe.previousActiveElement ||
                                                (qe.previousActiveElement =
                                                    document.activeElement),
                                            "function" == typeof e.onOpen &&
                                                setTimeout(function () {
                                                    return e.onOpen(n);
                                                });
                                    })(n),
                                    (function (e, t) {
                                        t.toast ||
                                            (F(t.allowEnterKey)
                                                ? t.focusCancel &&
                                                  ce(e.cancelButton)
                                                    ? e.cancelButton.focus()
                                                    : t.focusConfirm &&
                                                      ce(e.confirmButton)
                                                    ? e.confirmButton.focus()
                                                    : ot(0, -1, 1)
                                                : document.activeElement &&
                                                  "function" ==
                                                      typeof document
                                                          .activeElement.blur &&
                                                  document.activeElement.blur());
                                    })(t, n),
                                    (t.container.scrollTop = 0);
                            });
                        })(this, n, t)
                    );
                },
                update: function (e) {
                    var t = b(),
                        n = me.innerParams.get(this);
                    if (!t || q(t, n.hideClass.popup))
                        return M(
                            "You're trying to update the closed or closing popup, that won't work. Use the update() method in preConfirm parameter or show a new popup."
                        );
                    var o = {};
                    Object.keys(e).forEach(function (t) {
                        vt.isUpdatableParameter(t)
                            ? (o[t] = e[t])
                            : M(
                                  'Invalid parameter to update: "'.concat(
                                      t,
                                      '". Updatable params are listed here: https://github.com/sweetalert2/sweetalert2/blob/master/src/utils/params.js'
                                  )
                              );
                    });
                    var r = i({}, n, o);
                    ke(this, r),
                        me.innerParams.set(this, r),
                        Object.defineProperties(this, {
                            params: {
                                value: i({}, this.params, e),
                                writable: !1,
                                enumerable: !0,
                            },
                        });
                },
            });
        function wt() {
            if ("undefined" != typeof window) {
                "undefined" == typeof Promise &&
                    d(
                        "This package requires a Promise library, please include a shim to enable it in this browser (See: https://github.com/sweetalert2/sweetalert2/wiki/Migration-from-SweetAlert-to-SweetAlert2#1-ie-support)"
                    ),
                    (it = this);
                for (
                    var e = arguments.length, t = new Array(e), n = 0;
                    n < e;
                    n++
                )
                    t[n] = arguments[n];
                var o = Object.freeze(this.constructor.argsToParams(t));
                Object.defineProperties(this, {
                    params: {
                        value: o,
                        writable: !1,
                        enumerable: !0,
                        configurable: !0,
                    },
                });
                var i = this._main(this.params);
                me.promise.set(this, i);
            }
        }
        (wt.prototype.then = function (e) {
            return me.promise.get(this).then(e);
        }),
            (wt.prototype.finally = function (e) {
                return me.promise.get(this).finally(e);
            }),
            i(wt.prototype, gt),
            i(wt, Fe),
            Object.keys(gt).forEach(function (e) {
                wt[e] = function () {
                    var t;
                    if (it) return (t = it)[e].apply(t, arguments);
                };
            }),
            (wt.DismissReason = W),
            (wt.version = "9.5.3");
        var vt = wt;
        return (vt.default = vt);
    }),
    void 0 !== this &&
        this.Sweetalert2 &&
        (this.swal =
            this.sweetAlert =
            this.Swal =
            this.SweetAlert =
                this.Sweetalert2),
    "undefined" != typeof document &&
        (function (e, t) {
            var n = e.createElement("style");
            if (
                (e.getElementsByTagName("head")[0].appendChild(n), n.styleSheet)
            )
                n.styleSheet.disabled || (n.styleSheet.cssText = t);
            else
                try {
                    n.innerHTML = t;
                } catch (e) {
                    n.innerText = t;
                }
        })(
            document,
            '.swal2-popup.swal2-toast{-webkit-box-orient:horizontal;-webkit-box-direction:normal;flex-direction:row;-webkit-box-align:center;align-items:center;width:auto;padding:.625em;overflow-y:hidden;background:#fff;box-shadow:0 0 .625em #d9d9d9}.swal2-popup.swal2-toast .swal2-header{-webkit-box-orient:horizontal;-webkit-box-direction:normal;flex-direction:row}.swal2-popup.swal2-toast .swal2-title{-webkit-box-flex:1;flex-grow:1;-webkit-box-pack:start;justify-content:flex-start;margin:0 .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{position:static;width:.8em;height:.8em;line-height:.8}.swal2-popup.swal2-toast .swal2-content{-webkit-box-pack:start;justify-content:flex-start;font-size:1em}.swal2-popup.swal2-toast .swal2-icon{width:2em;min-width:2em;height:2em;margin:0}.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{display:-webkit-box;display:flex;-webkit-box-align:center;align-items:center;font-size:1.8em;font-weight:700}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{font-size:.25em}}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{flex-basis:auto!important;width:auto;height:auto;margin:0 .3125em}.swal2-popup.swal2-toast .swal2-styled{margin:0 .3125em;padding:.3125em .625em;font-size:1em}.swal2-popup.swal2-toast .swal2-styled:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;-webkit-transform:rotate(45deg);transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.8em;left:-.5em;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:2em 2em;transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.25em;left:.9375em;-webkit-transform-origin:0 1.5em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-toast-animate-success-line-tip .75s;animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-toast-animate-success-line-long .75s;animation:swal2-toast-animate-success-line-long .75s}.swal2-popup.swal2-toast.swal2-show{-webkit-animation:swal2-toast-show .5s;animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{-webkit-animation:swal2-toast-hide .1s forwards;animation:swal2-toast-hide .1s forwards}.swal2-container{display:-webkit-box;display:flex;position:fixed;z-index:1060;top:0;right:0;bottom:0;left:0;-webkit-box-orient:horizontal;-webkit-box-direction:normal;flex-direction:row;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;padding:.625em;overflow-x:hidden;-webkit-transition:background-color .1s;transition:background-color .1s;-webkit-overflow-scrolling:touch}.swal2-container.swal2-backdrop-show{background:rgba(0,0,0,.4)}.swal2-container.swal2-backdrop-hide{background:0 0!important}.swal2-container.swal2-top{-webkit-box-align:start;align-items:flex-start}.swal2-container.swal2-top-left,.swal2-container.swal2-top-start{-webkit-box-align:start;align-items:flex-start;-webkit-box-pack:start;justify-content:flex-start}.swal2-container.swal2-top-end,.swal2-container.swal2-top-right{-webkit-box-align:start;align-items:flex-start;-webkit-box-pack:end;justify-content:flex-end}.swal2-container.swal2-center{-webkit-box-align:center;align-items:center}.swal2-container.swal2-center-left,.swal2-container.swal2-center-start{-webkit-box-align:center;align-items:center;-webkit-box-pack:start;justify-content:flex-start}.swal2-container.swal2-center-end,.swal2-container.swal2-center-right{-webkit-box-align:center;align-items:center;-webkit-box-pack:end;justify-content:flex-end}.swal2-container.swal2-bottom{-webkit-box-align:end;align-items:flex-end}.swal2-container.swal2-bottom-left,.swal2-container.swal2-bottom-start{-webkit-box-align:end;align-items:flex-end;-webkit-box-pack:start;justify-content:flex-start}.swal2-container.swal2-bottom-end,.swal2-container.swal2-bottom-right{-webkit-box-align:end;align-items:flex-end;-webkit-box-pack:end;justify-content:flex-end}.swal2-container.swal2-bottom-end>:first-child,.swal2-container.swal2-bottom-left>:first-child,.swal2-container.swal2-bottom-right>:first-child,.swal2-container.swal2-bottom-start>:first-child,.swal2-container.swal2-bottom>:first-child{margin-top:auto}.swal2-container.swal2-grow-fullscreen>.swal2-modal{display:-webkit-box!important;display:flex!important;-webkit-box-flex:1;flex:1;align-self:stretch;-webkit-box-pack:center;justify-content:center}.swal2-container.swal2-grow-row>.swal2-modal{display:-webkit-box!important;display:flex!important;-webkit-box-flex:1;flex:1;align-content:center;-webkit-box-pack:center;justify-content:center}.swal2-container.swal2-grow-column{-webkit-box-flex:1;flex:1;-webkit-box-orient:vertical;-webkit-box-direction:normal;flex-direction:column}.swal2-container.swal2-grow-column.swal2-bottom,.swal2-container.swal2-grow-column.swal2-center,.swal2-container.swal2-grow-column.swal2-top{-webkit-box-align:center;align-items:center}.swal2-container.swal2-grow-column.swal2-bottom-left,.swal2-container.swal2-grow-column.swal2-bottom-start,.swal2-container.swal2-grow-column.swal2-center-left,.swal2-container.swal2-grow-column.swal2-center-start,.swal2-container.swal2-grow-column.swal2-top-left,.swal2-container.swal2-grow-column.swal2-top-start{-webkit-box-align:start;align-items:flex-start}.swal2-container.swal2-grow-column.swal2-bottom-end,.swal2-container.swal2-grow-column.swal2-bottom-right,.swal2-container.swal2-grow-column.swal2-center-end,.swal2-container.swal2-grow-column.swal2-center-right,.swal2-container.swal2-grow-column.swal2-top-end,.swal2-container.swal2-grow-column.swal2-top-right{-webkit-box-align:end;align-items:flex-end}.swal2-container.swal2-grow-column>.swal2-modal{display:-webkit-box!important;display:flex!important;-webkit-box-flex:1;flex:1;align-content:center;-webkit-box-pack:center;justify-content:center}.swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal{margin:auto}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-container .swal2-modal{margin:0!important}}.swal2-popup{display:none;position:relative;box-sizing:border-box;-webkit-box-orient:vertical;-webkit-box-direction:normal;flex-direction:column;-webkit-box-pack:center;justify-content:center;width:32em;max-width:100%;padding:1.25em;border:none;border-radius:.3125em;background:#fff;font-family:inherit;font-size:1rem}.swal2-popup:focus{outline:0}.swal2-popup.swal2-loading{overflow-y:hidden}.swal2-header{display:-webkit-box;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;flex-direction:column;-webkit-box-align:center;align-items:center}.swal2-title{position:relative;max-width:100%;margin:0 0 .4em;padding:0;color:#595959;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}.swal2-actions{display:-webkit-box;display:flex;z-index:1;flex-wrap:wrap;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;width:100%;margin:1.25em auto 0}.swal2-actions:not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}.swal2-actions:not(.swal2-loading) .swal2-styled:hover{background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(0,0,0,.1)),to(rgba(0,0,0,.1)));background-image:linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.1))}.swal2-actions:not(.swal2-loading) .swal2-styled:active{background-image:-webkit-gradient(linear,left top,left bottom,from(rgba(0,0,0,.2)),to(rgba(0,0,0,.2)));background-image:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.2))}.swal2-actions.swal2-loading .swal2-styled.swal2-confirm{box-sizing:border-box;width:2.5em;height:2.5em;margin:.46875em;padding:0;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:.25em solid transparent;border-radius:100%;border-color:transparent;background-color:transparent!important;color:transparent;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-actions.swal2-loading .swal2-styled.swal2-cancel{margin-right:30px;margin-left:30px}.swal2-actions.swal2-loading :not(.swal2-styled).swal2-confirm::after{content:"";display:inline-block;width:15px;height:15px;margin-left:5px;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:3px solid #999;border-radius:50%;border-right-color:transparent;box-shadow:1px 1px 1px #fff}.swal2-styled{margin:.3125em;padding:.625em 2em;box-shadow:none;font-weight:500}.swal2-styled:not([disabled]){cursor:pointer}.swal2-styled.swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#3085d6;color:#fff;font-size:1.0625em}.swal2-styled.swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#aaa;color:#fff;font-size:1.0625em}.swal2-styled:focus{outline:0;box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-styled::-moz-focus-inner{border:0}.swal2-footer{-webkit-box-pack:center;justify-content:center;margin:1.25em 0 0;padding:1em 0 0;border-top:1px solid #eee;color:#545454;font-size:1em}.swal2-timer-progress-bar{position:absolute;bottom:0;left:0;width:100%;height:.25em;background:rgba(0,0,0,.2)}.swal2-image{max-width:100%;margin:1.25em auto}.swal2-close{position:absolute;z-index:2;top:0;right:0;-webkit-box-pack:center;justify-content:center;width:1.2em;height:1.2em;padding:0;overflow:hidden;-webkit-transition:color .1s ease-out;transition:color .1s ease-out;border:none;border-radius:0;outline:initial;background:0 0;color:#ccc;font-family:serif;font-size:2.5em;line-height:1.2;cursor:pointer}.swal2-close:hover{-webkit-transform:none;transform:none;background:0 0;color:#f27474}.swal2-close::-moz-focus-inner{border:0}.swal2-content{z-index:1;-webkit-box-pack:center;justify-content:center;margin:0;padding:0;color:#545454;font-size:1.125em;font-weight:400;line-height:normal;text-align:center;word-wrap:break-word}.swal2-checkbox,.swal2-file,.swal2-input,.swal2-radio,.swal2-select,.swal2-textarea{margin:1em auto}.swal2-file,.swal2-input,.swal2-textarea{box-sizing:border-box;width:100%;-webkit-transition:border-color .3s,box-shadow .3s;transition:border-color .3s,box-shadow .3s;border:1px solid #d9d9d9;border-radius:.1875em;background:inherit;box-shadow:inset 0 1px 1px rgba(0,0,0,.06);color:inherit;font-size:1.125em}.swal2-file.swal2-inputerror,.swal2-input.swal2-inputerror,.swal2-textarea.swal2-inputerror{border-color:#f27474!important;box-shadow:0 0 2px #f27474!important}.swal2-file:focus,.swal2-input:focus,.swal2-textarea:focus{border:1px solid #b4dbed;outline:0;box-shadow:0 0 3px #c4e6f5}.swal2-file::-webkit-input-placeholder,.swal2-input::-webkit-input-placeholder,.swal2-textarea::-webkit-input-placeholder{color:#ccc}.swal2-file::-moz-placeholder,.swal2-input::-moz-placeholder,.swal2-textarea::-moz-placeholder{color:#ccc}.swal2-file:-ms-input-placeholder,.swal2-input:-ms-input-placeholder,.swal2-textarea:-ms-input-placeholder{color:#ccc}.swal2-file::-ms-input-placeholder,.swal2-input::-ms-input-placeholder,.swal2-textarea::-ms-input-placeholder{color:#ccc}.swal2-file::placeholder,.swal2-input::placeholder,.swal2-textarea::placeholder{color:#ccc}.swal2-range{margin:1em auto;background:#fff}.swal2-range input{width:80%}.swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}.swal2-range input,.swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}.swal2-input{height:2.625em;padding:0 .75em}.swal2-input[type=number]{max-width:10em}.swal2-file{background:inherit;font-size:1.125em}.swal2-textarea{height:6.75em;padding:.75em}.swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:inherit;color:inherit;font-size:1.125em}.swal2-checkbox,.swal2-radio{-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;background:#fff;color:inherit}.swal2-checkbox label,.swal2-radio label{margin:0 .6em;font-size:1.125em}.swal2-checkbox input,.swal2-radio input{margin:0 .4em}.swal2-validation-message{display:none;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}.swal2-validation-message::before{content:"!";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}.swal2-icon{position:relative;box-sizing:content-box;-webkit-box-pack:center;justify-content:center;width:5em;height:5em;margin:1.25em auto 1.875em;border:.25em solid transparent;border-radius:50%;font-family:inherit;line-height:5em;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-icon .swal2-icon-content{display:-webkit-box;display:flex;-webkit-box-align:center;align-items:center;font-size:3.75em}.swal2-icon.swal2-error{border-color:#f27474;color:#f27474}.swal2-icon.swal2-error .swal2-x-mark{position:relative;-webkit-box-flex:1;flex-grow:1}.swal2-icon.swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;-webkit-transform:rotate(45deg);transform:rotate(45deg)}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.swal2-icon.swal2-error.swal2-icon-show{-webkit-animation:swal2-animate-error-icon .5s;animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark{-webkit-animation:swal2-animate-error-x-mark .5s;animation:swal2-animate-error-x-mark .5s}.swal2-icon.swal2-warning{border-color:#facea8;color:#f8bb86}.swal2-icon.swal2-info{border-color:#9de0f6;color:#3fc3ee}.swal2-icon.swal2-question{border-color:#c9dae1;color:#87adbd}.swal2-icon.swal2-success{border-color:#a5dc86;color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;-webkit-transform:rotate(45deg);transform:rotate(45deg);border-radius:50%}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.4375em;left:-2.0635em;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:3.75em 3.75em;transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.6875em;left:1.875em;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:0 3.75em;transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}.swal2-icon.swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-.25em;left:-.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}.swal2-icon.swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.swal2-icon.swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.875em;width:1.5625em;-webkit-transform:rotate(45deg);transform:rotate(45deg)}.swal2-icon.swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-animate-success-line-tip .75s;animation:swal2-animate-success-line-tip .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-animate-success-line-long .75s;animation:swal2-animate-success-line-long .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right{-webkit-animation:swal2-rotate-success-circular-line 4.25s ease-in;animation:swal2-rotate-success-circular-line 4.25s ease-in}.swal2-progress-steps{-webkit-box-align:center;align-items:center;margin:0 0 1.25em;padding:0;background:inherit;font-weight:600}.swal2-progress-steps li{display:inline-block;position:relative}.swal2-progress-steps .swal2-progress-step{z-index:20;width:2em;height:2em;border-radius:2em;background:#3085d6;color:#fff;line-height:2em;text-align:center}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#3085d6}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}.swal2-progress-steps .swal2-progress-step-line{z-index:10;width:2.5em;height:.4em;margin:0 -1px;background:#3085d6}[class^=swal2]{-webkit-tap-highlight-color:transparent}.swal2-show{-webkit-animation:swal2-show .3s;animation:swal2-show .3s}.swal2-hide{-webkit-animation:swal2-hide .15s forwards;animation:swal2-hide .15s forwards}.swal2-noanimation{-webkit-transition:none;transition:none}.swal2-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.swal2-rtl .swal2-close{right:auto;left:0}.swal2-rtl .swal2-timer-progress-bar{right:0;left:auto}@supports (-ms-accelerator:true){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@-moz-document url-prefix(){.swal2-close:focus{outline:2px solid rgba(50,100,150,.4)}}@-webkit-keyframes swal2-toast-show{0%{-webkit-transform:translateY(-.625em) rotateZ(2deg);transform:translateY(-.625em) rotateZ(2deg)}33%{-webkit-transform:translateY(0) rotateZ(-2deg);transform:translateY(0) rotateZ(-2deg)}66%{-webkit-transform:translateY(.3125em) rotateZ(2deg);transform:translateY(.3125em) rotateZ(2deg)}100%{-webkit-transform:translateY(0) rotateZ(0);transform:translateY(0) rotateZ(0)}}@keyframes swal2-toast-show{0%{-webkit-transform:translateY(-.625em) rotateZ(2deg);transform:translateY(-.625em) rotateZ(2deg)}33%{-webkit-transform:translateY(0) rotateZ(-2deg);transform:translateY(0) rotateZ(-2deg)}66%{-webkit-transform:translateY(.3125em) rotateZ(2deg);transform:translateY(.3125em) rotateZ(2deg)}100%{-webkit-transform:translateY(0) rotateZ(0);transform:translateY(0) rotateZ(0)}}@-webkit-keyframes swal2-toast-hide{100%{-webkit-transform:rotateZ(1deg);transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-hide{100%{-webkit-transform:rotateZ(1deg);transform:rotateZ(1deg);opacity:0}}@-webkit-keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@-webkit-keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@-webkit-keyframes swal2-show{0%{-webkit-transform:scale(.7);transform:scale(.7)}45%{-webkit-transform:scale(1.05);transform:scale(1.05)}80%{-webkit-transform:scale(.95);transform:scale(.95)}100%{-webkit-transform:scale(1);transform:scale(1)}}@keyframes swal2-show{0%{-webkit-transform:scale(.7);transform:scale(.7)}45%{-webkit-transform:scale(1.05);transform:scale(1.05)}80%{-webkit-transform:scale(.95);transform:scale(.95)}100%{-webkit-transform:scale(1);transform:scale(1)}}@-webkit-keyframes swal2-hide{0%{-webkit-transform:scale(1);transform:scale(1);opacity:1}100%{-webkit-transform:scale(.5);transform:scale(.5);opacity:0}}@keyframes swal2-hide{0%{-webkit-transform:scale(1);transform:scale(1);opacity:1}100%{-webkit-transform:scale(.5);transform:scale(.5);opacity:0}}@-webkit-keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.875em;width:1.5625em}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.875em;width:1.5625em}}@-webkit-keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@-webkit-keyframes swal2-rotate-success-circular-line{0%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}5%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}12%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}100%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}}@keyframes swal2-rotate-success-circular-line{0%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}5%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}12%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}100%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}}@-webkit-keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;-webkit-transform:scale(.4);transform:scale(.4);opacity:0}50%{margin-top:1.625em;-webkit-transform:scale(.4);transform:scale(.4);opacity:0}80%{margin-top:-.375em;-webkit-transform:scale(1.15);transform:scale(1.15)}100%{margin-top:0;-webkit-transform:scale(1);transform:scale(1);opacity:1}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;-webkit-transform:scale(.4);transform:scale(.4);opacity:0}50%{margin-top:1.625em;-webkit-transform:scale(.4);transform:scale(.4);opacity:0}80%{margin-top:-.375em;-webkit-transform:scale(1.15);transform:scale(1.15)}100%{margin-top:0;-webkit-transform:scale(1);transform:scale(1);opacity:1}}@-webkit-keyframes swal2-animate-error-icon{0%{-webkit-transform:rotateX(100deg);transform:rotateX(100deg);opacity:0}100%{-webkit-transform:rotateX(0);transform:rotateX(0);opacity:1}}@keyframes swal2-animate-error-icon{0%{-webkit-transform:rotateX(100deg);transform:rotateX(100deg);opacity:0}100%{-webkit-transform:rotateX(0);transform:rotateX(0);opacity:1}}@-webkit-keyframes swal2-rotate-loading{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes swal2-rotate-loading{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto!important}body.swal2-no-backdrop .swal2-container{top:auto;right:auto;bottom:auto;left:auto;max-width:calc(100% - .625em * 2);background-color:transparent!important}body.swal2-no-backdrop .swal2-container>.swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}body.swal2-no-backdrop .swal2-container.swal2-top{top:0;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-top-left,body.swal2-no-backdrop .swal2-container.swal2-top-start{top:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-top-end,body.swal2-no-backdrop .swal2-container.swal2-top-right{top:0;right:0}body.swal2-no-backdrop .swal2-container.swal2-center{top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-left,body.swal2-no-backdrop .swal2-container.swal2-center-start{top:50%;left:0;-webkit-transform:translateY(-50%);transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-end,body.swal2-no-backdrop .swal2-container.swal2-center-right{top:50%;right:0;-webkit-transform:translateY(-50%);transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom{bottom:0;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom-left,body.swal2-no-backdrop .swal2-container.swal2-bottom-start{bottom:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-bottom-end,body.swal2-no-backdrop .swal2-container.swal2-bottom-right{right:0;bottom:0}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll!important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static!important}}body.swal2-toast-shown .swal2-container{background-color:transparent}body.swal2-toast-shown .swal2-container.swal2-top{top:0;right:auto;bottom:auto;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{top:0;right:0;bottom:auto;left:auto}body.swal2-toast-shown .swal2-container.swal2-top-left,body.swal2-toast-shown .swal2-container.swal2-top-start{top:0;right:auto;bottom:auto;left:0}body.swal2-toast-shown .swal2-container.swal2-center-left,body.swal2-toast-shown .swal2-container.swal2-center-start{top:50%;right:auto;bottom:auto;left:0;-webkit-transform:translateY(-50%);transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{top:50%;right:auto;bottom:auto;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{top:50%;right:0;bottom:auto;left:auto;-webkit-transform:translateY(-50%);transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-left,body.swal2-toast-shown .swal2-container.swal2-bottom-start{top:auto;right:auto;bottom:0;left:0}body.swal2-toast-shown .swal2-container.swal2-bottom{top:auto;right:auto;bottom:0;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{top:auto;right:0;bottom:0;left:auto}body.swal2-toast-column .swal2-toast{-webkit-box-orient:vertical;-webkit-box-direction:normal;flex-direction:column;-webkit-box-align:stretch;align-items:stretch}body.swal2-toast-column .swal2-toast .swal2-actions{-webkit-box-flex:1;flex:1;align-self:stretch;height:2.2em;margin-top:.3125em}body.swal2-toast-column .swal2-toast .swal2-loading{-webkit-box-pack:center;justify-content:center}body.swal2-toast-column .swal2-toast .swal2-input{height:2em;margin:.3125em auto;font-size:1em}body.swal2-toast-column .swal2-toast .swal2-validation-message{font-size:1em}'
        ),
    (function (e, t) {
        "object" == typeof exports && "undefined" != typeof module
            ? t(exports, require("jquery"))
            : "function" == typeof define && define.amd
            ? define(["exports", "jquery"], t)
            : t(((e = e || self).bootstrap = {}), e.jQuery);
    })(this, function (e, t) {
        "use strict";
        function n(e, t) {
            for (var n = 0; n < t.length; n++) {
                var o = t[n];
                (o.enumerable = o.enumerable || !1),
                    (o.configurable = !0),
                    "value" in o && (o.writable = !0),
                    Object.defineProperty(e, o.key, o);
            }
        }
        function o(e, t, o) {
            return t && n(e.prototype, t), o && n(e, o), e;
        }
        function i(e, t, n) {
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
        }
        function r(e, t) {
            var n = Object.keys(e);
            if (Object.getOwnPropertySymbols) {
                var o = Object.getOwnPropertySymbols(e);
                t &&
                    (o = o.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                    n.push.apply(n, o);
            }
            return n;
        }
        function a(e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = null != arguments[t] ? arguments[t] : {};
                t % 2
                    ? r(Object(n), !0).forEach(function (t) {
                          i(e, t, n[t]);
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
                              Object.getOwnPropertyDescriptor(n, t)
                          );
                      });
            }
            return e;
        }
        t =
            t && Object.prototype.hasOwnProperty.call(t, "default")
                ? t.default
                : t;
        var s = {
            TRANSITION_END: "bsTransitionEnd",
            getUID: function (e) {
                do {
                    e += ~~(1e6 * Math.random());
                } while (document.getElementById(e));
                return e;
            },
            getSelectorFromElement: function (e) {
                var t = e.getAttribute("data-target");
                if (!t || "#" === t) {
                    var n = e.getAttribute("href");
                    t = n && "#" !== n ? n.trim() : "";
                }
                try {
                    return document.querySelector(t) ? t : null;
                } catch (e) {
                    return null;
                }
            },
            getTransitionDurationFromElement: function (e) {
                if (!e) return 0;
                var n = t(e).css("transition-duration"),
                    o = t(e).css("transition-delay"),
                    i = parseFloat(n),
                    r = parseFloat(o);
                return i || r
                    ? ((n = n.split(",")[0]),
                      (o = o.split(",")[0]),
                      1e3 * (parseFloat(n) + parseFloat(o)))
                    : 0;
            },
            reflow: function (e) {
                return e.offsetHeight;
            },
            triggerTransitionEnd: function (e) {
                t(e).trigger("transitionend");
            },
            supportsTransitionEnd: function () {
                return Boolean("transitionend");
            },
            isElement: function (e) {
                return (e[0] || e).nodeType;
            },
            typeCheckConfig: function (e, t, n) {
                for (var o in n)
                    if (Object.prototype.hasOwnProperty.call(n, o)) {
                        var i = n[o],
                            r = t[o],
                            a =
                                r && s.isElement(r)
                                    ? "element"
                                    : null === (l = r) || void 0 === l
                                    ? "" + l
                                    : {}.toString
                                          .call(l)
                                          .match(/\s([a-z]+)/i)[1]
                                          .toLowerCase();
                        if (!new RegExp(i).test(a))
                            throw new Error(
                                e.toUpperCase() +
                                    ': Option "' +
                                    o +
                                    '" provided type "' +
                                    a +
                                    '" but expected type "' +
                                    i +
                                    '".'
                            );
                    }
                var l;
            },
            findShadowRoot: function (e) {
                if (!document.documentElement.attachShadow) return null;
                if ("function" == typeof e.getRootNode) {
                    var t = e.getRootNode();
                    return t instanceof ShadowRoot ? t : null;
                }
                return e instanceof ShadowRoot
                    ? e
                    : e.parentNode
                    ? s.findShadowRoot(e.parentNode)
                    : null;
            },
            jQueryDetection: function () {
                if (void 0 === t)
                    throw new TypeError(
                        "Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript."
                    );
                var e = t.fn.jquery.split(" ")[0].split(".");
                if (
                    (e[0] < 2 && e[1] < 9) ||
                    (1 === e[0] && 9 === e[1] && e[2] < 1) ||
                    e[0] >= 4
                )
                    throw new Error(
                        "Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0"
                    );
            },
        };
        s.jQueryDetection(),
            (t.fn.emulateTransitionEnd = function (e) {
                var n = this,
                    o = !1;
                return (
                    t(this).one(s.TRANSITION_END, function () {
                        o = !0;
                    }),
                    setTimeout(function () {
                        o || s.triggerTransitionEnd(n);
                    }, e),
                    this
                );
            }),
            (t.event.special[s.TRANSITION_END] = {
                bindType: "transitionend",
                delegateType: "transitionend",
                handle: function (e) {
                    if (t(e.target).is(this))
                        return e.handleObj.handler.apply(this, arguments);
                },
            });
        var l = "alert",
            c = t.fn[l],
            u = (function () {
                function e(e) {
                    this._element = e;
                }
                var n = e.prototype;
                return (
                    (n.close = function (e) {
                        var t = this._element;
                        e && (t = this._getRootElement(e)),
                            this._triggerCloseEvent(t).isDefaultPrevented() ||
                                this._removeElement(t);
                    }),
                    (n.dispose = function () {
                        t.removeData(this._element, "bs.alert"),
                            (this._element = null);
                    }),
                    (n._getRootElement = function (e) {
                        var n = s.getSelectorFromElement(e),
                            o = !1;
                        return (
                            n && (o = document.querySelector(n)),
                            o || (o = t(e).closest(".alert")[0]),
                            o
                        );
                    }),
                    (n._triggerCloseEvent = function (e) {
                        var n = t.Event("close.bs.alert");
                        return t(e).trigger(n), n;
                    }),
                    (n._removeElement = function (e) {
                        var n = this;
                        if ((t(e).removeClass("show"), t(e).hasClass("fade"))) {
                            var o = s.getTransitionDurationFromElement(e);
                            t(e)
                                .one(s.TRANSITION_END, function (t) {
                                    return n._destroyElement(e, t);
                                })
                                .emulateTransitionEnd(o);
                        } else this._destroyElement(e);
                    }),
                    (n._destroyElement = function (e) {
                        t(e).detach().trigger("closed.bs.alert").remove();
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this),
                                i = o.data("bs.alert");
                            i || ((i = new e(this)), o.data("bs.alert", i)),
                                "close" === n && i[n](this);
                        });
                    }),
                    (e._handleDismiss = function (e) {
                        return function (t) {
                            t && t.preventDefault(), e.close(this);
                        };
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                    ]),
                    e
                );
            })();
        t(document).on(
            "click.bs.alert.data-api",
            '[data-dismiss="alert"]',
            u._handleDismiss(new u())
        ),
            (t.fn[l] = u._jQueryInterface),
            (t.fn[l].Constructor = u),
            (t.fn[l].noConflict = function () {
                return (t.fn[l] = c), u._jQueryInterface;
            });
        var d = t.fn.button,
            f = (function () {
                function e(e) {
                    this._element = e;
                }
                var n = e.prototype;
                return (
                    (n.toggle = function () {
                        var e = !0,
                            n = !0,
                            o = t(this._element).closest(
                                '[data-toggle="buttons"]'
                            )[0];
                        if (o) {
                            var i = this._element.querySelector(
                                'input:not([type="hidden"])'
                            );
                            if (i) {
                                if ("radio" === i.type)
                                    if (
                                        i.checked &&
                                        this._element.classList.contains(
                                            "active"
                                        )
                                    )
                                        e = !1;
                                    else {
                                        var r = o.querySelector(".active");
                                        r && t(r).removeClass("active");
                                    }
                                e &&
                                    (("checkbox" !== i.type &&
                                        "radio" !== i.type) ||
                                        (i.checked =
                                            !this._element.classList.contains(
                                                "active"
                                            )),
                                    t(i).trigger("change")),
                                    i.focus(),
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
                            e && t(this._element).toggleClass("active"));
                    }),
                    (n.dispose = function () {
                        t.removeData(this._element, "bs.button"),
                            (this._element = null);
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this).data("bs.button");
                            o ||
                                ((o = new e(this)),
                                t(this).data("bs.button", o)),
                                "toggle" === n && o[n]();
                        });
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                    ]),
                    e
                );
            })();
        t(document)
            .on(
                "click.bs.button.data-api",
                '[data-toggle^="button"]',
                function (e) {
                    var n = e.target,
                        o = n;
                    if (
                        (t(n).hasClass("btn") || (n = t(n).closest(".btn")[0]),
                        !n ||
                            n.hasAttribute("disabled") ||
                            n.classList.contains("disabled"))
                    )
                        e.preventDefault();
                    else {
                        var i = n.querySelector('input:not([type="hidden"])');
                        if (
                            i &&
                            (i.hasAttribute("disabled") ||
                                i.classList.contains("disabled"))
                        )
                            return void e.preventDefault();
                        "LABEL" === o.tagName &&
                            i &&
                            "checkbox" === i.type &&
                            e.preventDefault(),
                            f._jQueryInterface.call(t(n), "toggle");
                    }
                }
            )
            .on(
                "focus.bs.button.data-api blur.bs.button.data-api",
                '[data-toggle^="button"]',
                function (e) {
                    var n = t(e.target).closest(".btn")[0];
                    t(n).toggleClass("focus", /^focus(in)?$/.test(e.type));
                }
            ),
            t(window).on("load.bs.button.data-api", function () {
                for (
                    var e = [].slice.call(
                            document.querySelectorAll(
                                '[data-toggle="buttons"] .btn'
                            )
                        ),
                        t = 0,
                        n = e.length;
                    t < n;
                    t++
                ) {
                    var o = e[t],
                        i = o.querySelector('input:not([type="hidden"])');
                    i.checked || i.hasAttribute("checked")
                        ? o.classList.add("active")
                        : o.classList.remove("active");
                }
                for (
                    var r = 0,
                        a = (e = [].slice.call(
                            document.querySelectorAll('[data-toggle="button"]')
                        )).length;
                    r < a;
                    r++
                ) {
                    var s = e[r];
                    "true" === s.getAttribute("aria-pressed")
                        ? s.classList.add("active")
                        : s.classList.remove("active");
                }
            }),
            (t.fn.button = f._jQueryInterface),
            (t.fn.button.Constructor = f),
            (t.fn.button.noConflict = function () {
                return (t.fn.button = d), f._jQueryInterface;
            });
        var p = "carousel",
            h = t.fn[p],
            m = {
                interval: 5e3,
                keyboard: !0,
                slide: !1,
                pause: "hover",
                wrap: !0,
                touch: !0,
            },
            g = {
                interval: "(number|boolean)",
                keyboard: "boolean",
                slide: "(boolean|string)",
                pause: "(string|boolean)",
                wrap: "boolean",
                touch: "boolean",
            },
            w = { TOUCH: "touch", PEN: "pen" },
            v = (function () {
                function e(e, t) {
                    (this._items = null),
                        (this._interval = null),
                        (this._activeElement = null),
                        (this._isPaused = !1),
                        (this._isSliding = !1),
                        (this.touchTimeout = null),
                        (this.touchStartX = 0),
                        (this.touchDeltaX = 0),
                        (this._config = this._getConfig(t)),
                        (this._element = e),
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
                var n = e.prototype;
                return (
                    (n.next = function () {
                        this._isSliding || this._slide("next");
                    }),
                    (n.nextWhenVisible = function () {
                        !document.hidden &&
                            t(this._element).is(":visible") &&
                            "hidden" !== t(this._element).css("visibility") &&
                            this.next();
                    }),
                    (n.prev = function () {
                        this._isSliding || this._slide("prev");
                    }),
                    (n.pause = function (e) {
                        e || (this._isPaused = !0),
                            this._element.querySelector(
                                ".carousel-item-next, .carousel-item-prev"
                            ) &&
                                (s.triggerTransitionEnd(this._element),
                                this.cycle(!0)),
                            clearInterval(this._interval),
                            (this._interval = null);
                    }),
                    (n.cycle = function (e) {
                        e || (this._isPaused = !1),
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
                    (n.to = function (e) {
                        var n = this;
                        this._activeElement = this._element.querySelector(
                            ".active.carousel-item"
                        );
                        var o = this._getItemIndex(this._activeElement);
                        if (!(e > this._items.length - 1 || e < 0))
                            if (this._isSliding)
                                t(this._element).one(
                                    "slid.bs.carousel",
                                    function () {
                                        return n.to(e);
                                    }
                                );
                            else {
                                if (o === e)
                                    return this.pause(), void this.cycle();
                                var i = e > o ? "next" : "prev";
                                this._slide(i, this._items[e]);
                            }
                    }),
                    (n.dispose = function () {
                        t(this._element).off(".bs.carousel"),
                            t.removeData(this._element, "bs.carousel"),
                            (this._items = null),
                            (this._config = null),
                            (this._element = null),
                            (this._interval = null),
                            (this._isPaused = null),
                            (this._isSliding = null),
                            (this._activeElement = null),
                            (this._indicatorsElement = null);
                    }),
                    (n._getConfig = function (e) {
                        return (
                            (e = a(a({}, m), e)), s.typeCheckConfig(p, e, g), e
                        );
                    }),
                    (n._handleSwipe = function () {
                        var e = Math.abs(this.touchDeltaX);
                        if (!(e <= 40)) {
                            var t = e / this.touchDeltaX;
                            (this.touchDeltaX = 0),
                                t > 0 && this.prev(),
                                t < 0 && this.next();
                        }
                    }),
                    (n._addEventListeners = function () {
                        var e = this;
                        this._config.keyboard &&
                            t(this._element).on(
                                "keydown.bs.carousel",
                                function (t) {
                                    return e._keydown(t);
                                }
                            ),
                            "hover" === this._config.pause &&
                                t(this._element)
                                    .on("mouseenter.bs.carousel", function (t) {
                                        return e.pause(t);
                                    })
                                    .on("mouseleave.bs.carousel", function (t) {
                                        return e.cycle(t);
                                    }),
                            this._config.touch &&
                                this._addTouchEventListeners();
                    }),
                    (n._addTouchEventListeners = function () {
                        var e = this;
                        if (this._touchSupported) {
                            var n = function (t) {
                                    e._pointerEvent &&
                                    w[t.originalEvent.pointerType.toUpperCase()]
                                        ? (e.touchStartX =
                                              t.originalEvent.clientX)
                                        : e._pointerEvent ||
                                          (e.touchStartX =
                                              t.originalEvent.touches[0].clientX);
                                },
                                o = function (t) {
                                    e._pointerEvent &&
                                        w[
                                            t.originalEvent.pointerType.toUpperCase()
                                        ] &&
                                        (e.touchDeltaX =
                                            t.originalEvent.clientX -
                                            e.touchStartX),
                                        e._handleSwipe(),
                                        "hover" === e._config.pause &&
                                            (e.pause(),
                                            e.touchTimeout &&
                                                clearTimeout(e.touchTimeout),
                                            (e.touchTimeout = setTimeout(
                                                function (t) {
                                                    return e.cycle(t);
                                                },
                                                500 + e._config.interval
                                            )));
                                };
                            t(
                                this._element.querySelectorAll(
                                    ".carousel-item img"
                                )
                            ).on("dragstart.bs.carousel", function (e) {
                                return e.preventDefault();
                            }),
                                this._pointerEvent
                                    ? (t(this._element).on(
                                          "pointerdown.bs.carousel",
                                          function (e) {
                                              return n(e);
                                          }
                                      ),
                                      t(this._element).on(
                                          "pointerup.bs.carousel",
                                          function (e) {
                                              return o(e);
                                          }
                                      ),
                                      this._element.classList.add(
                                          "pointer-event"
                                      ))
                                    : (t(this._element).on(
                                          "touchstart.bs.carousel",
                                          function (e) {
                                              return n(e);
                                          }
                                      ),
                                      t(this._element).on(
                                          "touchmove.bs.carousel",
                                          function (t) {
                                              return (function (t) {
                                                  t.originalEvent.touches &&
                                                  t.originalEvent.touches
                                                      .length > 1
                                                      ? (e.touchDeltaX = 0)
                                                      : (e.touchDeltaX =
                                                            t.originalEvent
                                                                .touches[0]
                                                                .clientX -
                                                            e.touchStartX);
                                              })(t);
                                          }
                                      ),
                                      t(this._element).on(
                                          "touchend.bs.carousel",
                                          function (e) {
                                              return o(e);
                                          }
                                      ));
                        }
                    }),
                    (n._keydown = function (e) {
                        if (!/input|textarea/i.test(e.target.tagName))
                            switch (e.which) {
                                case 37:
                                    e.preventDefault(), this.prev();
                                    break;
                                case 39:
                                    e.preventDefault(), this.next();
                            }
                    }),
                    (n._getItemIndex = function (e) {
                        return (
                            (this._items =
                                e && e.parentNode
                                    ? [].slice.call(
                                          e.parentNode.querySelectorAll(
                                              ".carousel-item"
                                          )
                                      )
                                    : []),
                            this._items.indexOf(e)
                        );
                    }),
                    (n._getItemByDirection = function (e, t) {
                        var n = "next" === e,
                            o = "prev" === e,
                            i = this._getItemIndex(t),
                            r = this._items.length - 1;
                        if (
                            ((o && 0 === i) || (n && i === r)) &&
                            !this._config.wrap
                        )
                            return t;
                        var a =
                            (i + ("prev" === e ? -1 : 1)) % this._items.length;
                        return -1 === a
                            ? this._items[this._items.length - 1]
                            : this._items[a];
                    }),
                    (n._triggerSlideEvent = function (e, n) {
                        var o = this._getItemIndex(e),
                            i = this._getItemIndex(
                                this._element.querySelector(
                                    ".active.carousel-item"
                                )
                            ),
                            r = t.Event("slide.bs.carousel", {
                                relatedTarget: e,
                                direction: n,
                                from: i,
                                to: o,
                            });
                        return t(this._element).trigger(r), r;
                    }),
                    (n._setActiveIndicatorElement = function (e) {
                        if (this._indicatorsElement) {
                            var n = [].slice.call(
                                this._indicatorsElement.querySelectorAll(
                                    ".active"
                                )
                            );
                            t(n).removeClass("active");
                            var o =
                                this._indicatorsElement.children[
                                    this._getItemIndex(e)
                                ];
                            o && t(o).addClass("active");
                        }
                    }),
                    (n._slide = function (e, n) {
                        var o,
                            i,
                            r,
                            a = this,
                            l = this._element.querySelector(
                                ".active.carousel-item"
                            ),
                            c = this._getItemIndex(l),
                            u = n || (l && this._getItemByDirection(e, l)),
                            d = this._getItemIndex(u),
                            f = Boolean(this._interval);
                        if (
                            ("next" === e
                                ? ((o = "carousel-item-left"),
                                  (i = "carousel-item-next"),
                                  (r = "left"))
                                : ((o = "carousel-item-right"),
                                  (i = "carousel-item-prev"),
                                  (r = "right")),
                            u && t(u).hasClass("active"))
                        )
                            this._isSliding = !1;
                        else if (
                            !this._triggerSlideEvent(
                                u,
                                r
                            ).isDefaultPrevented() &&
                            l &&
                            u
                        ) {
                            (this._isSliding = !0),
                                f && this.pause(),
                                this._setActiveIndicatorElement(u);
                            var p = t.Event("slid.bs.carousel", {
                                relatedTarget: u,
                                direction: r,
                                from: c,
                                to: d,
                            });
                            if (t(this._element).hasClass("slide")) {
                                t(u).addClass(i),
                                    s.reflow(u),
                                    t(l).addClass(o),
                                    t(u).addClass(o);
                                var h = parseInt(
                                    u.getAttribute("data-interval"),
                                    10
                                );
                                h
                                    ? ((this._config.defaultInterval =
                                          this._config.defaultInterval ||
                                          this._config.interval),
                                      (this._config.interval = h))
                                    : (this._config.interval =
                                          this._config.defaultInterval ||
                                          this._config.interval);
                                var m = s.getTransitionDurationFromElement(l);
                                t(l)
                                    .one(s.TRANSITION_END, function () {
                                        t(u)
                                            .removeClass(o + " " + i)
                                            .addClass("active"),
                                            t(l).removeClass(
                                                "active " + i + " " + o
                                            ),
                                            (a._isSliding = !1),
                                            setTimeout(function () {
                                                return t(a._element).trigger(p);
                                            }, 0);
                                    })
                                    .emulateTransitionEnd(m);
                            } else
                                t(l).removeClass("active"),
                                    t(u).addClass("active"),
                                    (this._isSliding = !1),
                                    t(this._element).trigger(p);
                            f && this.cycle();
                        }
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this).data("bs.carousel"),
                                i = a(a({}, m), t(this).data());
                            "object" == typeof n && (i = a(a({}, i), n));
                            var r = "string" == typeof n ? n : i.slide;
                            if (
                                (o ||
                                    ((o = new e(this, i)),
                                    t(this).data("bs.carousel", o)),
                                "number" == typeof n)
                            )
                                o.to(n);
                            else if ("string" == typeof r) {
                                if (void 0 === o[r])
                                    throw new TypeError(
                                        'No method named "' + r + '"'
                                    );
                                o[r]();
                            } else
                                i.interval && i.ride && (o.pause(), o.cycle());
                        });
                    }),
                    (e._dataApiClickHandler = function (n) {
                        var o = s.getSelectorFromElement(this);
                        if (o) {
                            var i = t(o)[0];
                            if (i && t(i).hasClass("carousel")) {
                                var r = a(a({}, t(i).data()), t(this).data()),
                                    l = this.getAttribute("data-slide-to");
                                l && (r.interval = !1),
                                    e._jQueryInterface.call(t(i), r),
                                    l && t(i).data("bs.carousel").to(l),
                                    n.preventDefault();
                            }
                        }
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                        {
                            key: "Default",
                            get: function () {
                                return m;
                            },
                        },
                    ]),
                    e
                );
            })();
        t(document).on(
            "click.bs.carousel.data-api",
            "[data-slide], [data-slide-to]",
            v._dataApiClickHandler
        ),
            t(window).on("load.bs.carousel.data-api", function () {
                for (
                    var e = [].slice.call(
                            document.querySelectorAll('[data-ride="carousel"]')
                        ),
                        n = 0,
                        o = e.length;
                    n < o;
                    n++
                ) {
                    var i = t(e[n]);
                    v._jQueryInterface.call(i, i.data());
                }
            }),
            (t.fn[p] = v._jQueryInterface),
            (t.fn[p].Constructor = v),
            (t.fn[p].noConflict = function () {
                return (t.fn[p] = h), v._jQueryInterface;
            });
        var b = "collapse",
            y = t.fn[b],
            x = { toggle: !0, parent: "" },
            _ = { toggle: "boolean", parent: "(string|element)" },
            k = (function () {
                function e(e, t) {
                    (this._isTransitioning = !1),
                        (this._element = e),
                        (this._config = this._getConfig(t)),
                        (this._triggerArray = [].slice.call(
                            document.querySelectorAll(
                                '[data-toggle="collapse"][href="#' +
                                    e.id +
                                    '"],[data-toggle="collapse"][data-target="#' +
                                    e.id +
                                    '"]'
                            )
                        ));
                    for (
                        var n = [].slice.call(
                                document.querySelectorAll(
                                    '[data-toggle="collapse"]'
                                )
                            ),
                            o = 0,
                            i = n.length;
                        o < i;
                        o++
                    ) {
                        var r = n[o],
                            a = s.getSelectorFromElement(r),
                            l = [].slice
                                .call(document.querySelectorAll(a))
                                .filter(function (t) {
                                    return t === e;
                                });
                        null !== a &&
                            l.length > 0 &&
                            ((this._selector = a), this._triggerArray.push(r));
                    }
                    (this._parent = this._config.parent
                        ? this._getParent()
                        : null),
                        this._config.parent ||
                            this._addAriaAndCollapsedClass(
                                this._element,
                                this._triggerArray
                            ),
                        this._config.toggle && this.toggle();
                }
                var n = e.prototype;
                return (
                    (n.toggle = function () {
                        t(this._element).hasClass("show")
                            ? this.hide()
                            : this.show();
                    }),
                    (n.show = function () {
                        var n,
                            o,
                            i = this;
                        if (
                            !(
                                this._isTransitioning ||
                                t(this._element).hasClass("show") ||
                                (this._parent &&
                                    0 ===
                                        (n = [].slice
                                            .call(
                                                this._parent.querySelectorAll(
                                                    ".show, .collapsing"
                                                )
                                            )
                                            .filter(function (e) {
                                                return "string" ==
                                                    typeof i._config.parent
                                                    ? e.getAttribute(
                                                          "data-parent"
                                                      ) === i._config.parent
                                                    : e.classList.contains(
                                                          "collapse"
                                                      );
                                            })).length &&
                                    (n = null),
                                n &&
                                    (o = t(n)
                                        .not(this._selector)
                                        .data("bs.collapse")) &&
                                    o._isTransitioning)
                            )
                        ) {
                            var r = t.Event("show.bs.collapse");
                            if (
                                (t(this._element).trigger(r),
                                !r.isDefaultPrevented())
                            ) {
                                n &&
                                    (e._jQueryInterface.call(
                                        t(n).not(this._selector),
                                        "hide"
                                    ),
                                    o || t(n).data("bs.collapse", null));
                                var a = this._getDimension();
                                t(this._element)
                                    .removeClass("collapse")
                                    .addClass("collapsing"),
                                    (this._element.style[a] = 0),
                                    this._triggerArray.length &&
                                        t(this._triggerArray)
                                            .removeClass("collapsed")
                                            .attr("aria-expanded", !0),
                                    this.setTransitioning(!0);
                                var l =
                                        "scroll" +
                                        (a[0].toUpperCase() + a.slice(1)),
                                    c = s.getTransitionDurationFromElement(
                                        this._element
                                    );
                                t(this._element)
                                    .one(s.TRANSITION_END, function () {
                                        t(i._element)
                                            .removeClass("collapsing")
                                            .addClass("collapse show"),
                                            (i._element.style[a] = ""),
                                            i.setTransitioning(!1),
                                            t(i._element).trigger(
                                                "shown.bs.collapse"
                                            );
                                    })
                                    .emulateTransitionEnd(c),
                                    (this._element.style[a] =
                                        this._element[l] + "px");
                            }
                        }
                    }),
                    (n.hide = function () {
                        var e = this;
                        if (
                            !this._isTransitioning &&
                            t(this._element).hasClass("show")
                        ) {
                            var n = t.Event("hide.bs.collapse");
                            if (
                                (t(this._element).trigger(n),
                                !n.isDefaultPrevented())
                            ) {
                                var o = this._getDimension();
                                (this._element.style[o] =
                                    this._element.getBoundingClientRect()[o] +
                                    "px"),
                                    s.reflow(this._element),
                                    t(this._element)
                                        .addClass("collapsing")
                                        .removeClass("collapse show");
                                var i = this._triggerArray.length;
                                if (i > 0)
                                    for (var r = 0; r < i; r++) {
                                        var a = this._triggerArray[r],
                                            l = s.getSelectorFromElement(a);
                                        null !== l &&
                                            (t(
                                                [].slice.call(
                                                    document.querySelectorAll(l)
                                                )
                                            ).hasClass("show") ||
                                                t(a)
                                                    .addClass("collapsed")
                                                    .attr("aria-expanded", !1));
                                    }
                                this.setTransitioning(!0),
                                    (this._element.style[o] = "");
                                var c = s.getTransitionDurationFromElement(
                                    this._element
                                );
                                t(this._element)
                                    .one(s.TRANSITION_END, function () {
                                        e.setTransitioning(!1),
                                            t(e._element)
                                                .removeClass("collapsing")
                                                .addClass("collapse")
                                                .trigger("hidden.bs.collapse");
                                    })
                                    .emulateTransitionEnd(c);
                            }
                        }
                    }),
                    (n.setTransitioning = function (e) {
                        this._isTransitioning = e;
                    }),
                    (n.dispose = function () {
                        t.removeData(this._element, "bs.collapse"),
                            (this._config = null),
                            (this._parent = null),
                            (this._element = null),
                            (this._triggerArray = null),
                            (this._isTransitioning = null);
                    }),
                    (n._getConfig = function (e) {
                        return (
                            ((e = a(a({}, x), e)).toggle = Boolean(e.toggle)),
                            s.typeCheckConfig(b, e, _),
                            e
                        );
                    }),
                    (n._getDimension = function () {
                        return t(this._element).hasClass("width")
                            ? "width"
                            : "height";
                    }),
                    (n._getParent = function () {
                        var n,
                            o = this;
                        s.isElement(this._config.parent)
                            ? ((n = this._config.parent),
                              void 0 !== this._config.parent.jquery &&
                                  (n = this._config.parent[0]))
                            : (n = document.querySelector(this._config.parent));
                        var i =
                                '[data-toggle="collapse"][data-parent="' +
                                this._config.parent +
                                '"]',
                            r = [].slice.call(n.querySelectorAll(i));
                        return (
                            t(r).each(function (t, n) {
                                o._addAriaAndCollapsedClass(
                                    e._getTargetFromElement(n),
                                    [n]
                                );
                            }),
                            n
                        );
                    }),
                    (n._addAriaAndCollapsedClass = function (e, n) {
                        var o = t(e).hasClass("show");
                        n.length &&
                            t(n)
                                .toggleClass("collapsed", !o)
                                .attr("aria-expanded", o);
                    }),
                    (e._getTargetFromElement = function (e) {
                        var t = s.getSelectorFromElement(e);
                        return t ? document.querySelector(t) : null;
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this),
                                i = o.data("bs.collapse"),
                                r = a(
                                    a(a({}, x), o.data()),
                                    "object" == typeof n && n ? n : {}
                                );
                            if (
                                (!i &&
                                    r.toggle &&
                                    "string" == typeof n &&
                                    /show|hide/.test(n) &&
                                    (r.toggle = !1),
                                i ||
                                    ((i = new e(this, r)),
                                    o.data("bs.collapse", i)),
                                "string" == typeof n)
                            ) {
                                if (void 0 === i[n])
                                    throw new TypeError(
                                        'No method named "' + n + '"'
                                    );
                                i[n]();
                            }
                        });
                    }),
                    o(e, null, [
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
                    e
                );
            })();
        t(document).on(
            "click.bs.collapse.data-api",
            '[data-toggle="collapse"]',
            function (e) {
                "A" === e.currentTarget.tagName && e.preventDefault();
                var n = t(this),
                    o = s.getSelectorFromElement(this),
                    i = [].slice.call(document.querySelectorAll(o));
                t(i).each(function () {
                    var e = t(this),
                        o = e.data("bs.collapse") ? "toggle" : n.data();
                    k._jQueryInterface.call(e, o);
                });
            }
        ),
            (t.fn[b] = k._jQueryInterface),
            (t.fn[b].Constructor = k),
            (t.fn[b].noConflict = function () {
                return (t.fn[b] = y), k._jQueryInterface;
            });
        var C =
                "undefined" != typeof window &&
                "undefined" != typeof document &&
                "undefined" != typeof navigator,
            E = (function () {
                for (
                    var e = ["Edge", "Trident", "Firefox"], t = 0;
                    t < e.length;
                    t += 1
                )
                    if (C && navigator.userAgent.indexOf(e[t]) >= 0) return 1;
                return 0;
            })(),
            T =
                C && window.Promise
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
                                  }, E));
                          };
                      };
        function S(e) {
            return e && "[object Function]" === {}.toString.call(e);
        }
        function A(e, t) {
            if (1 !== e.nodeType) return [];
            var n = e.ownerDocument.defaultView.getComputedStyle(e, null);
            return t ? n[t] : n;
        }
        function D(e) {
            return "HTML" === e.nodeName ? e : e.parentNode || e.host;
        }
        function N(e) {
            if (!e) return document.body;
            switch (e.nodeName) {
                case "HTML":
                case "BODY":
                    return e.ownerDocument.body;
                case "#document":
                    return e.body;
            }
            var t = A(e),
                n = t.overflow,
                o = t.overflowX,
                i = t.overflowY;
            return /(auto|scroll|overlay)/.test(n + i + o) ? e : N(D(e));
        }
        function j(e) {
            return e && e.referenceNode ? e.referenceNode : e;
        }
        var O = C && !(!window.MSInputMethodContext || !document.documentMode),
            L = C && /MSIE 10/.test(navigator.userAgent);
        function P(e) {
            return 11 === e ? O : 10 === e ? L : O || L;
        }
        function I(e) {
            if (!e) return document.documentElement;
            for (
                var t = P(10) ? document.body : null,
                    n = e.offsetParent || null;
                n === t && e.nextElementSibling;

            )
                n = (e = e.nextElementSibling).offsetParent;
            var o = n && n.nodeName;
            return o && "BODY" !== o && "HTML" !== o
                ? -1 !== ["TH", "TD", "TABLE"].indexOf(n.nodeName) &&
                  "static" === A(n, "position")
                    ? I(n)
                    : n
                : e
                ? e.ownerDocument.documentElement
                : document.documentElement;
        }
        function q(e) {
            return null !== e.parentNode ? q(e.parentNode) : e;
        }
        function H(e, t) {
            if (!(e && e.nodeType && t && t.nodeType))
                return document.documentElement;
            var n =
                    e.compareDocumentPosition(t) &
                    Node.DOCUMENT_POSITION_FOLLOWING,
                o = n ? e : t,
                i = n ? t : e,
                r = document.createRange();
            r.setStart(o, 0), r.setEnd(i, 0);
            var a,
                s,
                l = r.commonAncestorContainer;
            if ((e !== l && t !== l) || o.contains(i))
                return "BODY" === (s = (a = l).nodeName) ||
                    ("HTML" !== s && I(a.firstElementChild) !== a)
                    ? I(l)
                    : l;
            var c = q(e);
            return c.host ? H(c.host, t) : H(e, q(t).host);
        }
        function B(e) {
            var t =
                    "top" ===
                    (arguments.length > 1 && void 0 !== arguments[1]
                        ? arguments[1]
                        : "top")
                        ? "scrollTop"
                        : "scrollLeft",
                n = e.nodeName;
            if ("BODY" === n || "HTML" === n) {
                var o = e.ownerDocument.documentElement;
                return (e.ownerDocument.scrollingElement || o)[t];
            }
            return e[t];
        }
        function M(e, t) {
            var n = "x" === t ? "Left" : "Top",
                o = "Left" === n ? "Right" : "Bottom";
            return (
                parseFloat(e["border" + n + "Width"], 10) +
                parseFloat(e["border" + o + "Width"], 10)
            );
        }
        function R(e, t, n, o) {
            return Math.max(
                t["offset" + e],
                t["scroll" + e],
                n["client" + e],
                n["offset" + e],
                n["scroll" + e],
                P(10)
                    ? parseInt(n["offset" + e]) +
                          parseInt(
                              o["margin" + ("Height" === e ? "Top" : "Left")]
                          ) +
                          parseInt(
                              o[
                                  "margin" +
                                      ("Height" === e ? "Bottom" : "Right")
                              ]
                          )
                    : 0
            );
        }
        function F(e) {
            var t = e.body,
                n = e.documentElement,
                o = P(10) && getComputedStyle(n);
            return { height: R("Height", t, n, o), width: R("Width", t, n, o) };
        }
        var W = function (e, t) {
                if (!(e instanceof t))
                    throw new TypeError("Cannot call a class as a function");
            },
            z = (function () {
                function e(e, t) {
                    for (var n = 0; n < t.length; n++) {
                        var o = t[n];
                        (o.enumerable = o.enumerable || !1),
                            (o.configurable = !0),
                            "value" in o && (o.writable = !0),
                            Object.defineProperty(e, o.key, o);
                    }
                }
                return function (t, n, o) {
                    return n && e(t.prototype, n), o && e(t, o), t;
                };
            })(),
            U = function (e, t, n) {
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
            },
            V =
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
        function $(e) {
            return V({}, e, {
                right: e.left + e.width,
                bottom: e.top + e.height,
            });
        }
        function Y(e) {
            var t = {};
            try {
                if (P(10)) {
                    t = e.getBoundingClientRect();
                    var n = B(e, "top"),
                        o = B(e, "left");
                    (t.top += n),
                        (t.left += o),
                        (t.bottom += n),
                        (t.right += o);
                } else t = e.getBoundingClientRect();
            } catch (e) {}
            var i = {
                    left: t.left,
                    top: t.top,
                    width: t.right - t.left,
                    height: t.bottom - t.top,
                },
                r = "HTML" === e.nodeName ? F(e.ownerDocument) : {},
                a = r.width || e.clientWidth || i.width,
                s = r.height || e.clientHeight || i.height,
                l = e.offsetWidth - a,
                c = e.offsetHeight - s;
            if (l || c) {
                var u = A(e);
                (l -= M(u, "x")),
                    (c -= M(u, "y")),
                    (i.width -= l),
                    (i.height -= c);
            }
            return $(i);
        }
        function Q(e, t) {
            var n =
                    arguments.length > 2 &&
                    void 0 !== arguments[2] &&
                    arguments[2],
                o = P(10),
                i = "HTML" === t.nodeName,
                r = Y(e),
                a = Y(t),
                s = N(e),
                l = A(t),
                c = parseFloat(l.borderTopWidth, 10),
                u = parseFloat(l.borderLeftWidth, 10);
            n &&
                i &&
                ((a.top = Math.max(a.top, 0)), (a.left = Math.max(a.left, 0)));
            var d = $({
                top: r.top - a.top - c,
                left: r.left - a.left - u,
                width: r.width,
                height: r.height,
            });
            if (((d.marginTop = 0), (d.marginLeft = 0), !o && i)) {
                var f = parseFloat(l.marginTop, 10),
                    p = parseFloat(l.marginLeft, 10);
                (d.top -= c - f),
                    (d.bottom -= c - f),
                    (d.left -= u - p),
                    (d.right -= u - p),
                    (d.marginTop = f),
                    (d.marginLeft = p);
            }
            return (
                (o && !n ? t.contains(s) : t === s && "BODY" !== s.nodeName) &&
                    (d = (function (e, t) {
                        var n =
                                arguments.length > 2 &&
                                void 0 !== arguments[2] &&
                                arguments[2],
                            o = B(t, "top"),
                            i = B(t, "left"),
                            r = n ? -1 : 1;
                        return (
                            (e.top += o * r),
                            (e.bottom += o * r),
                            (e.left += i * r),
                            (e.right += i * r),
                            e
                        );
                    })(d, t)),
                d
            );
        }
        function X(e) {
            if (!e || !e.parentElement || P()) return document.documentElement;
            for (var t = e.parentElement; t && "none" === A(t, "transform"); )
                t = t.parentElement;
            return t || document.documentElement;
        }
        function K(e, t, n, o) {
            var i =
                    arguments.length > 4 &&
                    void 0 !== arguments[4] &&
                    arguments[4],
                r = { top: 0, left: 0 },
                a = i ? X(e) : H(e, j(t));
            if ("viewport" === o)
                r = (function (e) {
                    var t =
                            arguments.length > 1 &&
                            void 0 !== arguments[1] &&
                            arguments[1],
                        n = e.ownerDocument.documentElement,
                        o = Q(e, n),
                        i = Math.max(n.clientWidth, window.innerWidth || 0),
                        r = Math.max(n.clientHeight, window.innerHeight || 0),
                        a = t ? 0 : B(n),
                        s = t ? 0 : B(n, "left");
                    return $({
                        top: a - o.top + o.marginTop,
                        left: s - o.left + o.marginLeft,
                        width: i,
                        height: r,
                    });
                })(a, i);
            else {
                var s = void 0;
                "scrollParent" === o
                    ? "BODY" === (s = N(D(t))).nodeName &&
                      (s = e.ownerDocument.documentElement)
                    : (s =
                          "window" === o ? e.ownerDocument.documentElement : o);
                var l = Q(s, a, i);
                if (
                    "HTML" !== s.nodeName ||
                    (function e(t) {
                        var n = t.nodeName;
                        if ("BODY" === n || "HTML" === n) return !1;
                        if ("fixed" === A(t, "position")) return !0;
                        var o = D(t);
                        return !!o && e(o);
                    })(a)
                )
                    r = l;
                else {
                    var c = F(e.ownerDocument),
                        u = c.height,
                        d = c.width;
                    (r.top += l.top - l.marginTop),
                        (r.bottom = u + l.top),
                        (r.left += l.left - l.marginLeft),
                        (r.right = d + l.left);
                }
            }
            var f = "number" == typeof (n = n || 0);
            return (
                (r.left += f ? n : n.left || 0),
                (r.top += f ? n : n.top || 0),
                (r.right -= f ? n : n.right || 0),
                (r.bottom -= f ? n : n.bottom || 0),
                r
            );
        }
        function Z(e) {
            return e.width * e.height;
        }
        function G(e, t, n, o, i) {
            var r =
                arguments.length > 5 && void 0 !== arguments[5]
                    ? arguments[5]
                    : 0;
            if (-1 === e.indexOf("auto")) return e;
            var a = K(n, o, r, i),
                s = {
                    top: { width: a.width, height: t.top - a.top },
                    right: { width: a.right - t.right, height: a.height },
                    bottom: { width: a.width, height: a.bottom - t.bottom },
                    left: { width: t.left - a.left, height: a.height },
                },
                l = Object.keys(s)
                    .map(function (e) {
                        return V({ key: e }, s[e], { area: Z(s[e]) });
                    })
                    .sort(function (e, t) {
                        return t.area - e.area;
                    }),
                c = l.filter(function (e) {
                    var t = e.width,
                        o = e.height;
                    return t >= n.clientWidth && o >= n.clientHeight;
                }),
                u = c.length > 0 ? c[0].key : l[0].key,
                d = e.split("-")[1];
            return u + (d ? "-" + d : "");
        }
        function J(e, t, n) {
            var o =
                arguments.length > 3 && void 0 !== arguments[3]
                    ? arguments[3]
                    : null;
            return Q(n, o ? X(t) : H(t, j(n)), o);
        }
        function ee(e) {
            var t = e.ownerDocument.defaultView.getComputedStyle(e),
                n =
                    parseFloat(t.marginTop || 0) +
                    parseFloat(t.marginBottom || 0),
                o =
                    parseFloat(t.marginLeft || 0) +
                    parseFloat(t.marginRight || 0);
            return { width: e.offsetWidth + o, height: e.offsetHeight + n };
        }
        function te(e) {
            var t = {
                left: "right",
                right: "left",
                bottom: "top",
                top: "bottom",
            };
            return e.replace(/left|right|bottom|top/g, function (e) {
                return t[e];
            });
        }
        function ne(e, t, n) {
            n = n.split("-")[0];
            var o = ee(e),
                i = { width: o.width, height: o.height },
                r = -1 !== ["right", "left"].indexOf(n),
                a = r ? "top" : "left",
                s = r ? "left" : "top",
                l = r ? "height" : "width",
                c = r ? "width" : "height";
            return (
                (i[a] = t[a] + t[l] / 2 - o[l] / 2),
                (i[s] = n === s ? t[s] - o[c] : t[te(s)]),
                i
            );
        }
        function oe(e, t) {
            return Array.prototype.find ? e.find(t) : e.filter(t)[0];
        }
        function ie(e, t, n) {
            return (
                (void 0 === n
                    ? e
                    : e.slice(
                          0,
                          (function (e, t, n) {
                              if (Array.prototype.findIndex)
                                  return e.findIndex(function (e) {
                                      return e[t] === n;
                                  });
                              var o = oe(e, function (e) {
                                  return e[t] === n;
                              });
                              return e.indexOf(o);
                          })(e, "name", n)
                      )
                ).forEach(function (e) {
                    e.function &&
                        console.warn(
                            "`modifier.function` is deprecated, use `modifier.fn`!"
                        );
                    var n = e.function || e.fn;
                    e.enabled &&
                        S(n) &&
                        ((t.offsets.popper = $(t.offsets.popper)),
                        (t.offsets.reference = $(t.offsets.reference)),
                        (t = n(t, e)));
                }),
                t
            );
        }
        function re(e, t) {
            return e.some(function (e) {
                var n = e.name;
                return e.enabled && n === t;
            });
        }
        function ae(e) {
            for (
                var t = [!1, "ms", "Webkit", "Moz", "O"],
                    n = e.charAt(0).toUpperCase() + e.slice(1),
                    o = 0;
                o < t.length;
                o++
            ) {
                var i = t[o],
                    r = i ? "" + i + n : e;
                if (void 0 !== document.body.style[r]) return r;
            }
            return null;
        }
        function se(e) {
            var t = e.ownerDocument;
            return t ? t.defaultView : window;
        }
        function le(e) {
            return "" !== e && !isNaN(parseFloat(e)) && isFinite(e);
        }
        function ce(e, t) {
            Object.keys(t).forEach(function (n) {
                var o = "";
                -1 !==
                    [
                        "width",
                        "height",
                        "top",
                        "right",
                        "bottom",
                        "left",
                    ].indexOf(n) &&
                    le(t[n]) &&
                    (o = "px"),
                    (e.style[n] = t[n] + o);
            });
        }
        var ue = C && /Firefox/i.test(navigator.userAgent);
        function de(e, t, n) {
            var o = oe(e, function (e) {
                    return e.name === t;
                }),
                i =
                    !!o &&
                    e.some(function (e) {
                        return e.name === n && e.enabled && e.order < o.order;
                    });
            if (!i) {
                var r = "`" + t + "`",
                    a = "`" + n + "`";
                console.warn(
                    a +
                        " modifier is required by " +
                        r +
                        " modifier in order to work, be sure to include it before " +
                        r +
                        "!"
                );
            }
            return i;
        }
        var fe = [
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
            pe = fe.slice(3);
        function he(e) {
            var t =
                    arguments.length > 1 &&
                    void 0 !== arguments[1] &&
                    arguments[1],
                n = pe.indexOf(e),
                o = pe.slice(n + 1).concat(pe.slice(0, n));
            return t ? o.reverse() : o;
        }
        var me = {
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
                                n = t.split("-")[0],
                                o = t.split("-")[1];
                            if (o) {
                                var i = e.offsets,
                                    r = i.reference,
                                    a = i.popper,
                                    s = -1 !== ["bottom", "top"].indexOf(n),
                                    l = s ? "left" : "top",
                                    c = s ? "width" : "height",
                                    u = {
                                        start: U({}, l, r[l]),
                                        end: U({}, l, r[l] + r[c] - a[c]),
                                    };
                                e.offsets.popper = V({}, a, u[o]);
                            }
                            return e;
                        },
                    },
                    offset: {
                        order: 200,
                        enabled: !0,
                        fn: function (e, t) {
                            var n,
                                o = t.offset,
                                i = e.placement,
                                r = e.offsets,
                                a = r.popper,
                                s = r.reference,
                                l = i.split("-")[0];
                            return (
                                (n = le(+o)
                                    ? [+o, 0]
                                    : (function (e, t, n, o) {
                                          var i = [0, 0],
                                              r =
                                                  -1 !==
                                                  ["right", "left"].indexOf(o),
                                              a = e
                                                  .split(/(\+|\-)/)
                                                  .map(function (e) {
                                                      return e.trim();
                                                  }),
                                              s = a.indexOf(
                                                  oe(a, function (e) {
                                                      return (
                                                          -1 !==
                                                          e.search(/,|\s/)
                                                      );
                                                  })
                                              );
                                          a[s] &&
                                              -1 === a[s].indexOf(",") &&
                                              console.warn(
                                                  "Offsets separated by white space(s) are deprecated, use a comma (,) instead."
                                              );
                                          var l = /\s*,\s*|\s+/,
                                              c =
                                                  -1 !== s
                                                      ? [
                                                            a
                                                                .slice(0, s)
                                                                .concat([
                                                                    a[s].split(
                                                                        l
                                                                    )[0],
                                                                ]),
                                                            [
                                                                a[s].split(
                                                                    l
                                                                )[1],
                                                            ].concat(
                                                                a.slice(s + 1)
                                                            ),
                                                        ]
                                                      : [a];
                                          return (
                                              (c = c.map(function (e, o) {
                                                  var i = (1 === o ? !r : r)
                                                          ? "height"
                                                          : "width",
                                                      a = !1;
                                                  return e
                                                      .reduce(function (e, t) {
                                                          return "" ===
                                                              e[e.length - 1] &&
                                                              -1 !==
                                                                  [
                                                                      "+",
                                                                      "-",
                                                                  ].indexOf(t)
                                                              ? ((e[
                                                                    e.length - 1
                                                                ] = t),
                                                                (a = !0),
                                                                e)
                                                              : a
                                                              ? ((e[
                                                                    e.length - 1
                                                                ] += t),
                                                                (a = !1),
                                                                e)
                                                              : e.concat(t);
                                                      }, [])
                                                      .map(function (e) {
                                                          return (function (
                                                              e,
                                                              t,
                                                              n,
                                                              o
                                                          ) {
                                                              var i = e.match(
                                                                      /((?:\-|\+)?\d*\.?\d*)(.*)/
                                                                  ),
                                                                  r = +i[1],
                                                                  a = i[2];
                                                              if (!r) return e;
                                                              if (
                                                                  0 ===
                                                                  a.indexOf("%")
                                                              ) {
                                                                  var s =
                                                                      void 0;
                                                                  switch (a) {
                                                                      case "%p":
                                                                          s = n;
                                                                          break;
                                                                      case "%":
                                                                      case "%r":
                                                                      default:
                                                                          s = o;
                                                                  }
                                                                  return (
                                                                      ($(s)[t] /
                                                                          100) *
                                                                      r
                                                                  );
                                                              }
                                                              return "vh" ===
                                                                  a ||
                                                                  "vw" === a
                                                                  ? (("vh" === a
                                                                        ? Math.max(
                                                                              document
                                                                                  .documentElement
                                                                                  .clientHeight,
                                                                              window.innerHeight ||
                                                                                  0
                                                                          )
                                                                        : Math.max(
                                                                              document
                                                                                  .documentElement
                                                                                  .clientWidth,
                                                                              window.innerWidth ||
                                                                                  0
                                                                          )) /
                                                                        100) *
                                                                        r
                                                                  : r;
                                                          })(e, i, t, n);
                                                      });
                                              })).forEach(function (e, t) {
                                                  e.forEach(function (n, o) {
                                                      le(n) &&
                                                          (i[t] +=
                                                              n *
                                                              ("-" === e[o - 1]
                                                                  ? -1
                                                                  : 1));
                                                  });
                                              }),
                                              i
                                          );
                                      })(o, a, s, l)),
                                "left" === l
                                    ? ((a.top += n[0]), (a.left -= n[1]))
                                    : "right" === l
                                    ? ((a.top += n[0]), (a.left += n[1]))
                                    : "top" === l
                                    ? ((a.left += n[0]), (a.top -= n[1]))
                                    : "bottom" === l &&
                                      ((a.left += n[0]), (a.top += n[1])),
                                (e.popper = a),
                                e
                            );
                        },
                        offset: 0,
                    },
                    preventOverflow: {
                        order: 300,
                        enabled: !0,
                        fn: function (e, t) {
                            var n = t.boundariesElement || I(e.instance.popper);
                            e.instance.reference === n && (n = I(n));
                            var o = ae("transform"),
                                i = e.instance.popper.style,
                                r = i.top,
                                a = i.left,
                                s = i[o];
                            (i.top = ""), (i.left = ""), (i[o] = "");
                            var l = K(
                                e.instance.popper,
                                e.instance.reference,
                                t.padding,
                                n,
                                e.positionFixed
                            );
                            (i.top = r),
                                (i.left = a),
                                (i[o] = s),
                                (t.boundaries = l);
                            var c = t.priority,
                                u = e.offsets.popper,
                                d = {
                                    primary: function (e) {
                                        var n = u[e];
                                        return (
                                            u[e] < l[e] &&
                                                !t.escapeWithReference &&
                                                (n = Math.max(u[e], l[e])),
                                            U({}, e, n)
                                        );
                                    },
                                    secondary: function (e) {
                                        var n = "right" === e ? "left" : "top",
                                            o = u[n];
                                        return (
                                            u[e] > l[e] &&
                                                !t.escapeWithReference &&
                                                (o = Math.min(
                                                    u[n],
                                                    l[e] -
                                                        ("right" === e
                                                            ? u.width
                                                            : u.height)
                                                )),
                                            U({}, n, o)
                                        );
                                    },
                                };
                            return (
                                c.forEach(function (e) {
                                    var t =
                                        -1 !== ["left", "top"].indexOf(e)
                                            ? "primary"
                                            : "secondary";
                                    u = V({}, u, d[t](e));
                                }),
                                (e.offsets.popper = u),
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
                                n = t.popper,
                                o = t.reference,
                                i = e.placement.split("-")[0],
                                r = Math.floor,
                                a = -1 !== ["top", "bottom"].indexOf(i),
                                s = a ? "right" : "bottom",
                                l = a ? "left" : "top",
                                c = a ? "width" : "height";
                            return (
                                n[s] < r(o[l]) &&
                                    (e.offsets.popper[l] = r(o[l]) - n[c]),
                                n[l] > r(o[s]) &&
                                    (e.offsets.popper[l] = r(o[s])),
                                e
                            );
                        },
                    },
                    arrow: {
                        order: 500,
                        enabled: !0,
                        fn: function (e, t) {
                            var n;
                            if (
                                !de(
                                    e.instance.modifiers,
                                    "arrow",
                                    "keepTogether"
                                )
                            )
                                return e;
                            var o = t.element;
                            if ("string" == typeof o) {
                                if (!(o = e.instance.popper.querySelector(o)))
                                    return e;
                            } else if (!e.instance.popper.contains(o))
                                return (
                                    console.warn(
                                        "WARNING: `arrow.element` must be child of its popper element!"
                                    ),
                                    e
                                );
                            var i = e.placement.split("-")[0],
                                r = e.offsets,
                                a = r.popper,
                                s = r.reference,
                                l = -1 !== ["left", "right"].indexOf(i),
                                c = l ? "height" : "width",
                                u = l ? "Top" : "Left",
                                d = u.toLowerCase(),
                                f = l ? "left" : "top",
                                p = l ? "bottom" : "right",
                                h = ee(o)[c];
                            s[p] - h < a[d] &&
                                (e.offsets.popper[d] -= a[d] - (s[p] - h)),
                                s[d] + h > a[p] &&
                                    (e.offsets.popper[d] += s[d] + h - a[p]),
                                (e.offsets.popper = $(e.offsets.popper));
                            var m = s[d] + s[c] / 2 - h / 2,
                                g = A(e.instance.popper),
                                w = parseFloat(g["margin" + u], 10),
                                v = parseFloat(g["border" + u + "Width"], 10),
                                b = m - e.offsets.popper[d] - w - v;
                            return (
                                (b = Math.max(Math.min(a[c] - h, b), 0)),
                                (e.arrowElement = o),
                                (e.offsets.arrow =
                                    (U((n = {}), d, Math.round(b)),
                                    U(n, f, ""),
                                    n)),
                                e
                            );
                        },
                        element: "[x-arrow]",
                    },
                    flip: {
                        order: 600,
                        enabled: !0,
                        fn: function (e, t) {
                            if (re(e.instance.modifiers, "inner")) return e;
                            if (
                                e.flipped &&
                                e.placement === e.originalPlacement
                            )
                                return e;
                            var n = K(
                                    e.instance.popper,
                                    e.instance.reference,
                                    t.padding,
                                    t.boundariesElement,
                                    e.positionFixed
                                ),
                                o = e.placement.split("-")[0],
                                i = te(o),
                                r = e.placement.split("-")[1] || "",
                                a = [];
                            switch (t.behavior) {
                                case "flip":
                                    a = [o, i];
                                    break;
                                case "clockwise":
                                    a = he(o);
                                    break;
                                case "counterclockwise":
                                    a = he(o, !0);
                                    break;
                                default:
                                    a = t.behavior;
                            }
                            return (
                                a.forEach(function (s, l) {
                                    if (o !== s || a.length === l + 1) return e;
                                    (o = e.placement.split("-")[0]),
                                        (i = te(o));
                                    var c = e.offsets.popper,
                                        u = e.offsets.reference,
                                        d = Math.floor,
                                        f =
                                            ("left" === o &&
                                                d(c.right) > d(u.left)) ||
                                            ("right" === o &&
                                                d(c.left) < d(u.right)) ||
                                            ("top" === o &&
                                                d(c.bottom) > d(u.top)) ||
                                            ("bottom" === o &&
                                                d(c.top) < d(u.bottom)),
                                        p = d(c.left) < d(n.left),
                                        h = d(c.right) > d(n.right),
                                        m = d(c.top) < d(n.top),
                                        g = d(c.bottom) > d(n.bottom),
                                        w =
                                            ("left" === o && p) ||
                                            ("right" === o && h) ||
                                            ("top" === o && m) ||
                                            ("bottom" === o && g),
                                        v = -1 !== ["top", "bottom"].indexOf(o),
                                        b =
                                            !!t.flipVariations &&
                                            ((v && "start" === r && p) ||
                                                (v && "end" === r && h) ||
                                                (!v && "start" === r && m) ||
                                                (!v && "end" === r && g)),
                                        y =
                                            !!t.flipVariationsByContent &&
                                            ((v && "start" === r && h) ||
                                                (v && "end" === r && p) ||
                                                (!v && "start" === r && g) ||
                                                (!v && "end" === r && m)),
                                        x = b || y;
                                    (f || w || x) &&
                                        ((e.flipped = !0),
                                        (f || w) && (o = a[l + 1]),
                                        x &&
                                            (r =
                                                "end" === r
                                                    ? "start"
                                                    : "start" === r
                                                    ? "end"
                                                    : r),
                                        (e.placement = o + (r ? "-" + r : "")),
                                        (e.offsets.popper = V(
                                            {},
                                            e.offsets.popper,
                                            ne(
                                                e.instance.popper,
                                                e.offsets.reference,
                                                e.placement
                                            )
                                        )),
                                        (e = ie(
                                            e.instance.modifiers,
                                            e,
                                            "flip"
                                        )));
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
                                n = t.split("-")[0],
                                o = e.offsets,
                                i = o.popper,
                                r = o.reference,
                                a = -1 !== ["left", "right"].indexOf(n),
                                s = -1 === ["top", "left"].indexOf(n);
                            return (
                                (i[a ? "left" : "top"] =
                                    r[n] - (s ? i[a ? "width" : "height"] : 0)),
                                (e.placement = te(t)),
                                (e.offsets.popper = $(i)),
                                e
                            );
                        },
                    },
                    hide: {
                        order: 800,
                        enabled: !0,
                        fn: function (e) {
                            if (
                                !de(
                                    e.instance.modifiers,
                                    "hide",
                                    "preventOverflow"
                                )
                            )
                                return e;
                            var t = e.offsets.reference,
                                n = oe(e.instance.modifiers, function (e) {
                                    return "preventOverflow" === e.name;
                                }).boundaries;
                            if (
                                t.bottom < n.top ||
                                t.left > n.right ||
                                t.top > n.bottom ||
                                t.right < n.left
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
                            var n = t.x,
                                o = t.y,
                                i = e.offsets.popper,
                                r = oe(e.instance.modifiers, function (e) {
                                    return "applyStyle" === e.name;
                                }).gpuAcceleration;
                            void 0 !== r &&
                                console.warn(
                                    "WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!"
                                );
                            var a,
                                s,
                                l = void 0 !== r ? r : t.gpuAcceleration,
                                c = I(e.instance.popper),
                                u = Y(c),
                                d = { position: i.position },
                                f = (function (e, t) {
                                    var n = e.offsets,
                                        o = n.popper,
                                        i = n.reference,
                                        r = Math.round,
                                        a = Math.floor,
                                        s = function (e) {
                                            return e;
                                        },
                                        l = r(i.width),
                                        c = r(o.width),
                                        u =
                                            -1 !==
                                            ["left", "right"].indexOf(
                                                e.placement
                                            ),
                                        d = -1 !== e.placement.indexOf("-"),
                                        f = t
                                            ? u || d || l % 2 == c % 2
                                                ? r
                                                : a
                                            : s,
                                        p = t ? r : s;
                                    return {
                                        left: f(
                                            l % 2 == 1 && c % 2 == 1 && !d && t
                                                ? o.left - 1
                                                : o.left
                                        ),
                                        top: p(o.top),
                                        bottom: p(o.bottom),
                                        right: f(o.right),
                                    };
                                })(e, window.devicePixelRatio < 2 || !ue),
                                p = "bottom" === n ? "top" : "bottom",
                                h = "right" === o ? "left" : "right",
                                m = ae("transform");
                            if (
                                ((s =
                                    "bottom" === p
                                        ? "HTML" === c.nodeName
                                            ? -c.clientHeight + f.bottom
                                            : -u.height + f.bottom
                                        : f.top),
                                (a =
                                    "right" === h
                                        ? "HTML" === c.nodeName
                                            ? -c.clientWidth + f.right
                                            : -u.width + f.right
                                        : f.left),
                                l && m)
                            )
                                (d[m] =
                                    "translate3d(" + a + "px, " + s + "px, 0)"),
                                    (d[p] = 0),
                                    (d[h] = 0),
                                    (d.willChange = "transform");
                            else {
                                var g = "bottom" === p ? -1 : 1,
                                    w = "right" === h ? -1 : 1;
                                (d[p] = s * g),
                                    (d[h] = a * w),
                                    (d.willChange = p + ", " + h);
                            }
                            var v = { "x-placement": e.placement };
                            return (
                                (e.attributes = V({}, v, e.attributes)),
                                (e.styles = V({}, d, e.styles)),
                                (e.arrowStyles = V(
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
                            var t, n;
                            return (
                                ce(e.instance.popper, e.styles),
                                (t = e.instance.popper),
                                (n = e.attributes),
                                Object.keys(n).forEach(function (e) {
                                    !1 !== n[e]
                                        ? t.setAttribute(e, n[e])
                                        : t.removeAttribute(e);
                                }),
                                e.arrowElement &&
                                    Object.keys(e.arrowStyles).length &&
                                    ce(e.arrowElement, e.arrowStyles),
                                e
                            );
                        },
                        onLoad: function (e, t, n, o, i) {
                            var r = J(i, t, e, n.positionFixed),
                                a = G(
                                    n.placement,
                                    r,
                                    t,
                                    e,
                                    n.modifiers.flip.boundariesElement,
                                    n.modifiers.flip.padding
                                );
                            return (
                                t.setAttribute("x-placement", a),
                                ce(t, {
                                    position: n.positionFixed
                                        ? "fixed"
                                        : "absolute",
                                }),
                                n
                            );
                        },
                        gpuAcceleration: void 0,
                    },
                },
            },
            ge = (function () {
                function e(t, n) {
                    var o = this,
                        i =
                            arguments.length > 2 && void 0 !== arguments[2]
                                ? arguments[2]
                                : {};
                    W(this, e),
                        (this.scheduleUpdate = function () {
                            return requestAnimationFrame(o.update);
                        }),
                        (this.update = T(this.update.bind(this))),
                        (this.options = V({}, e.Defaults, i)),
                        (this.state = {
                            isDestroyed: !1,
                            isCreated: !1,
                            scrollParents: [],
                        }),
                        (this.reference = t && t.jquery ? t[0] : t),
                        (this.popper = n && n.jquery ? n[0] : n),
                        (this.options.modifiers = {}),
                        Object.keys(
                            V({}, e.Defaults.modifiers, i.modifiers)
                        ).forEach(function (t) {
                            o.options.modifiers[t] = V(
                                {},
                                e.Defaults.modifiers[t] || {},
                                i.modifiers ? i.modifiers[t] : {}
                            );
                        }),
                        (this.modifiers = Object.keys(this.options.modifiers)
                            .map(function (e) {
                                return V({ name: e }, o.options.modifiers[e]);
                            })
                            .sort(function (e, t) {
                                return e.order - t.order;
                            })),
                        this.modifiers.forEach(function (e) {
                            e.enabled &&
                                S(e.onLoad) &&
                                e.onLoad(
                                    o.reference,
                                    o.popper,
                                    o.options,
                                    e,
                                    o.state
                                );
                        }),
                        this.update();
                    var r = this.options.eventsEnabled;
                    r && this.enableEventListeners(),
                        (this.state.eventsEnabled = r);
                }
                return (
                    z(e, [
                        {
                            key: "update",
                            value: function () {
                                return function () {
                                    if (!this.state.isDestroyed) {
                                        var e = {
                                            instance: this,
                                            styles: {},
                                            arrowStyles: {},
                                            attributes: {},
                                            flipped: !1,
                                            offsets: {},
                                        };
                                        (e.offsets.reference = J(
                                            this.state,
                                            this.popper,
                                            this.reference,
                                            this.options.positionFixed
                                        )),
                                            (e.placement = G(
                                                this.options.placement,
                                                e.offsets.reference,
                                                this.popper,
                                                this.reference,
                                                this.options.modifiers.flip
                                                    .boundariesElement,
                                                this.options.modifiers.flip
                                                    .padding
                                            )),
                                            (e.originalPlacement = e.placement),
                                            (e.positionFixed =
                                                this.options.positionFixed),
                                            (e.offsets.popper = ne(
                                                this.popper,
                                                e.offsets.reference,
                                                e.placement
                                            )),
                                            (e.offsets.popper.position = this
                                                .options.positionFixed
                                                ? "fixed"
                                                : "absolute"),
                                            (e = ie(this.modifiers, e)),
                                            this.state.isCreated
                                                ? this.options.onUpdate(e)
                                                : ((this.state.isCreated = !0),
                                                  this.options.onCreate(e));
                                    }
                                }.call(this);
                            },
                        },
                        {
                            key: "destroy",
                            value: function () {
                                return function () {
                                    return (
                                        (this.state.isDestroyed = !0),
                                        re(this.modifiers, "applyStyle") &&
                                            (this.popper.removeAttribute(
                                                "x-placement"
                                            ),
                                            (this.popper.style.position = ""),
                                            (this.popper.style.top = ""),
                                            (this.popper.style.left = ""),
                                            (this.popper.style.right = ""),
                                            (this.popper.style.bottom = ""),
                                            (this.popper.style.willChange = ""),
                                            (this.popper.style[
                                                ae("transform")
                                            ] = "")),
                                        this.disableEventListeners(),
                                        this.options.removeOnDestroy &&
                                            this.popper.parentNode.removeChild(
                                                this.popper
                                            ),
                                        this
                                    );
                                }.call(this);
                            },
                        },
                        {
                            key: "enableEventListeners",
                            value: function () {
                                return function () {
                                    this.state.eventsEnabled ||
                                        (this.state = (function (e, t, n, o) {
                                            (n.updateBound = o),
                                                se(e).addEventListener(
                                                    "resize",
                                                    n.updateBound,
                                                    { passive: !0 }
                                                );
                                            var i = N(e);
                                            return (
                                                (function e(t, n, o, i) {
                                                    var r =
                                                            "BODY" ===
                                                            t.nodeName,
                                                        a = r
                                                            ? t.ownerDocument
                                                                  .defaultView
                                                            : t;
                                                    a.addEventListener(n, o, {
                                                        passive: !0,
                                                    }),
                                                        r ||
                                                            e(
                                                                N(a.parentNode),
                                                                n,
                                                                o,
                                                                i
                                                            ),
                                                        i.push(a);
                                                })(
                                                    i,
                                                    "scroll",
                                                    n.updateBound,
                                                    n.scrollParents
                                                ),
                                                (n.scrollElement = i),
                                                (n.eventsEnabled = !0),
                                                n
                                            );
                                        })(
                                            this.reference,
                                            this.options,
                                            this.state,
                                            this.scheduleUpdate
                                        ));
                                }.call(this);
                            },
                        },
                        {
                            key: "disableEventListeners",
                            value: function () {
                                return function () {
                                    var e, t;
                                    this.state.eventsEnabled &&
                                        (cancelAnimationFrame(
                                            this.scheduleUpdate
                                        ),
                                        (this.state =
                                            ((e = this.reference),
                                            (t = this.state),
                                            se(e).removeEventListener(
                                                "resize",
                                                t.updateBound
                                            ),
                                            t.scrollParents.forEach(function (
                                                e
                                            ) {
                                                e.removeEventListener(
                                                    "scroll",
                                                    t.updateBound
                                                );
                                            }),
                                            (t.updateBound = null),
                                            (t.scrollParents = []),
                                            (t.scrollElement = null),
                                            (t.eventsEnabled = !1),
                                            t)));
                                }.call(this);
                            },
                        },
                    ]),
                    e
                );
            })();
        (ge.Utils = (
            "undefined" != typeof window ? window : global
        ).PopperUtils),
            (ge.placements = fe),
            (ge.Defaults = me);
        var we = "dropdown",
            ve = t.fn[we],
            be = new RegExp("38|40|27"),
            ye = {
                offset: 0,
                flip: !0,
                boundary: "scrollParent",
                reference: "toggle",
                display: "dynamic",
                popperConfig: null,
            },
            xe = {
                offset: "(number|string|function)",
                flip: "boolean",
                boundary: "(string|element)",
                reference: "(string|element)",
                display: "string",
                popperConfig: "(null|object)",
            },
            _e = (function () {
                function e(e, t) {
                    (this._element = e),
                        (this._popper = null),
                        (this._config = this._getConfig(t)),
                        (this._menu = this._getMenuElement()),
                        (this._inNavbar = this._detectNavbar()),
                        this._addEventListeners();
                }
                var n = e.prototype;
                return (
                    (n.toggle = function () {
                        if (
                            !this._element.disabled &&
                            !t(this._element).hasClass("disabled")
                        ) {
                            var n = t(this._menu).hasClass("show");
                            e._clearMenus(), n || this.show(!0);
                        }
                    }),
                    (n.show = function (n) {
                        if (
                            (void 0 === n && (n = !1),
                            !(
                                this._element.disabled ||
                                t(this._element).hasClass("disabled") ||
                                t(this._menu).hasClass("show")
                            ))
                        ) {
                            var o = { relatedTarget: this._element },
                                i = t.Event("show.bs.dropdown", o),
                                r = e._getParentFromElement(this._element);
                            if ((t(r).trigger(i), !i.isDefaultPrevented())) {
                                if (!this._inNavbar && n) {
                                    if (void 0 === ge)
                                        throw new TypeError(
                                            "Bootstrap's dropdowns require Popper.js (https://popper.js.org/)"
                                        );
                                    var a = this._element;
                                    "parent" === this._config.reference
                                        ? (a = r)
                                        : s.isElement(this._config.reference) &&
                                          ((a = this._config.reference),
                                          void 0 !==
                                              this._config.reference.jquery &&
                                              (a = this._config.reference[0])),
                                        "scrollParent" !==
                                            this._config.boundary &&
                                            t(r).addClass("position-static"),
                                        (this._popper = new ge(
                                            a,
                                            this._menu,
                                            this._getPopperConfig()
                                        ));
                                }
                                "ontouchstart" in document.documentElement &&
                                    0 === t(r).closest(".navbar-nav").length &&
                                    t(document.body)
                                        .children()
                                        .on("mouseover", null, t.noop),
                                    this._element.focus(),
                                    this._element.setAttribute(
                                        "aria-expanded",
                                        !0
                                    ),
                                    t(this._menu).toggleClass("show"),
                                    t(r)
                                        .toggleClass("show")
                                        .trigger(
                                            t.Event("shown.bs.dropdown", o)
                                        );
                            }
                        }
                    }),
                    (n.hide = function () {
                        if (
                            !this._element.disabled &&
                            !t(this._element).hasClass("disabled") &&
                            t(this._menu).hasClass("show")
                        ) {
                            var n = { relatedTarget: this._element },
                                o = t.Event("hide.bs.dropdown", n),
                                i = e._getParentFromElement(this._element);
                            t(i).trigger(o),
                                o.isDefaultPrevented() ||
                                    (this._popper && this._popper.destroy(),
                                    t(this._menu).toggleClass("show"),
                                    t(i)
                                        .toggleClass("show")
                                        .trigger(
                                            t.Event("hidden.bs.dropdown", n)
                                        ));
                        }
                    }),
                    (n.dispose = function () {
                        t.removeData(this._element, "bs.dropdown"),
                            t(this._element).off(".bs.dropdown"),
                            (this._element = null),
                            (this._menu = null),
                            null !== this._popper &&
                                (this._popper.destroy(), (this._popper = null));
                    }),
                    (n.update = function () {
                        (this._inNavbar = this._detectNavbar()),
                            null !== this._popper &&
                                this._popper.scheduleUpdate();
                    }),
                    (n._addEventListeners = function () {
                        var e = this;
                        t(this._element).on("click.bs.dropdown", function (t) {
                            t.preventDefault(), t.stopPropagation(), e.toggle();
                        });
                    }),
                    (n._getConfig = function (e) {
                        return (
                            (e = a(
                                a(
                                    a({}, this.constructor.Default),
                                    t(this._element).data()
                                ),
                                e
                            )),
                            s.typeCheckConfig(
                                we,
                                e,
                                this.constructor.DefaultType
                            ),
                            e
                        );
                    }),
                    (n._getMenuElement = function () {
                        if (!this._menu) {
                            var t = e._getParentFromElement(this._element);
                            t &&
                                (this._menu =
                                    t.querySelector(".dropdown-menu"));
                        }
                        return this._menu;
                    }),
                    (n._getPlacement = function () {
                        var e = t(this._element.parentNode),
                            n = "bottom-start";
                        return (
                            e.hasClass("dropup")
                                ? (n = t(this._menu).hasClass(
                                      "dropdown-menu-right"
                                  )
                                      ? "top-end"
                                      : "top-start")
                                : e.hasClass("dropright")
                                ? (n = "right-start")
                                : e.hasClass("dropleft")
                                ? (n = "left-start")
                                : t(this._menu).hasClass(
                                      "dropdown-menu-right"
                                  ) && (n = "bottom-end"),
                            n
                        );
                    }),
                    (n._detectNavbar = function () {
                        return t(this._element).closest(".navbar").length > 0;
                    }),
                    (n._getOffset = function () {
                        var e = this,
                            t = {};
                        return (
                            "function" == typeof this._config.offset
                                ? (t.fn = function (t) {
                                      return (
                                          (t.offsets = a(
                                              a({}, t.offsets),
                                              e._config.offset(
                                                  t.offsets,
                                                  e._element
                                              ) || {}
                                          )),
                                          t
                                      );
                                  })
                                : (t.offset = this._config.offset),
                            t
                        );
                    }),
                    (n._getPopperConfig = function () {
                        var e = {
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
                                (e.modifiers.applyStyle = { enabled: !1 }),
                            a(a({}, e), this._config.popperConfig)
                        );
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this).data("bs.dropdown");
                            if (
                                (o ||
                                    ((o = new e(
                                        this,
                                        "object" == typeof n ? n : null
                                    )),
                                    t(this).data("bs.dropdown", o)),
                                "string" == typeof n)
                            ) {
                                if (void 0 === o[n])
                                    throw new TypeError(
                                        'No method named "' + n + '"'
                                    );
                                o[n]();
                            }
                        });
                    }),
                    (e._clearMenus = function (n) {
                        if (
                            !n ||
                            (3 !== n.which &&
                                ("keyup" !== n.type || 9 === n.which))
                        )
                            for (
                                var o = [].slice.call(
                                        document.querySelectorAll(
                                            '[data-toggle="dropdown"]'
                                        )
                                    ),
                                    i = 0,
                                    r = o.length;
                                i < r;
                                i++
                            ) {
                                var a = e._getParentFromElement(o[i]),
                                    s = t(o[i]).data("bs.dropdown"),
                                    l = { relatedTarget: o[i] };
                                if (
                                    (n &&
                                        "click" === n.type &&
                                        (l.clickEvent = n),
                                    s)
                                ) {
                                    var c = s._menu;
                                    if (
                                        t(a).hasClass("show") &&
                                        !(
                                            n &&
                                            (("click" === n.type &&
                                                /input|textarea/i.test(
                                                    n.target.tagName
                                                )) ||
                                                ("keyup" === n.type &&
                                                    9 === n.which)) &&
                                            t.contains(a, n.target)
                                        )
                                    ) {
                                        var u = t.Event("hide.bs.dropdown", l);
                                        t(a).trigger(u),
                                            u.isDefaultPrevented() ||
                                                ("ontouchstart" in
                                                    document.documentElement &&
                                                    t(document.body)
                                                        .children()
                                                        .off(
                                                            "mouseover",
                                                            null,
                                                            t.noop
                                                        ),
                                                o[i].setAttribute(
                                                    "aria-expanded",
                                                    "false"
                                                ),
                                                s._popper &&
                                                    s._popper.destroy(),
                                                t(c).removeClass("show"),
                                                t(a)
                                                    .removeClass("show")
                                                    .trigger(
                                                        t.Event(
                                                            "hidden.bs.dropdown",
                                                            l
                                                        )
                                                    ));
                                    }
                                }
                            }
                    }),
                    (e._getParentFromElement = function (e) {
                        var t,
                            n = s.getSelectorFromElement(e);
                        return (
                            n && (t = document.querySelector(n)),
                            t || e.parentNode
                        );
                    }),
                    (e._dataApiKeydownHandler = function (n) {
                        if (
                            !(/input|textarea/i.test(n.target.tagName)
                                ? 32 === n.which ||
                                  (27 !== n.which &&
                                      ((40 !== n.which && 38 !== n.which) ||
                                          t(n.target).closest(".dropdown-menu")
                                              .length))
                                : !be.test(n.which)) &&
                            !this.disabled &&
                            !t(this).hasClass("disabled")
                        ) {
                            var o = e._getParentFromElement(this),
                                i = t(o).hasClass("show");
                            if (i || 27 !== n.which) {
                                if (
                                    (n.preventDefault(),
                                    n.stopPropagation(),
                                    !i ||
                                        (i &&
                                            (27 === n.which || 32 === n.which)))
                                )
                                    return (
                                        27 === n.which &&
                                            t(
                                                o.querySelector(
                                                    '[data-toggle="dropdown"]'
                                                )
                                            ).trigger("focus"),
                                        void t(this).trigger("click")
                                    );
                                var r = [].slice
                                    .call(
                                        o.querySelectorAll(
                                            ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)"
                                        )
                                    )
                                    .filter(function (e) {
                                        return t(e).is(":visible");
                                    });
                                if (0 !== r.length) {
                                    var a = r.indexOf(n.target);
                                    38 === n.which && a > 0 && a--,
                                        40 === n.which &&
                                            a < r.length - 1 &&
                                            a++,
                                        a < 0 && (a = 0),
                                        r[a].focus();
                                }
                            }
                        }
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                        {
                            key: "Default",
                            get: function () {
                                return ye;
                            },
                        },
                        {
                            key: "DefaultType",
                            get: function () {
                                return xe;
                            },
                        },
                    ]),
                    e
                );
            })();
        t(document)
            .on(
                "keydown.bs.dropdown.data-api",
                '[data-toggle="dropdown"]',
                _e._dataApiKeydownHandler
            )
            .on(
                "keydown.bs.dropdown.data-api",
                ".dropdown-menu",
                _e._dataApiKeydownHandler
            )
            .on(
                "click.bs.dropdown.data-api keyup.bs.dropdown.data-api",
                _e._clearMenus
            )
            .on(
                "click.bs.dropdown.data-api",
                '[data-toggle="dropdown"]',
                function (e) {
                    e.preventDefault(),
                        e.stopPropagation(),
                        _e._jQueryInterface.call(t(this), "toggle");
                }
            )
            .on("click.bs.dropdown.data-api", ".dropdown form", function (e) {
                e.stopPropagation();
            }),
            (t.fn[we] = _e._jQueryInterface),
            (t.fn[we].Constructor = _e),
            (t.fn[we].noConflict = function () {
                return (t.fn[we] = ve), _e._jQueryInterface;
            });
        var ke = t.fn.modal,
            Ce = { backdrop: !0, keyboard: !0, focus: !0, show: !0 },
            Ee = {
                backdrop: "(boolean|string)",
                keyboard: "boolean",
                focus: "boolean",
                show: "boolean",
            },
            Te = (function () {
                function e(e, t) {
                    (this._config = this._getConfig(t)),
                        (this._element = e),
                        (this._dialog = e.querySelector(".modal-dialog")),
                        (this._backdrop = null),
                        (this._isShown = !1),
                        (this._isBodyOverflowing = !1),
                        (this._ignoreBackdropClick = !1),
                        (this._isTransitioning = !1),
                        (this._scrollbarWidth = 0);
                }
                var n = e.prototype;
                return (
                    (n.toggle = function (e) {
                        return this._isShown ? this.hide() : this.show(e);
                    }),
                    (n.show = function (e) {
                        var n = this;
                        if (!this._isShown && !this._isTransitioning) {
                            t(this._element).hasClass("fade") &&
                                (this._isTransitioning = !0);
                            var o = t.Event("show.bs.modal", {
                                relatedTarget: e,
                            });
                            t(this._element).trigger(o),
                                this._isShown ||
                                    o.isDefaultPrevented() ||
                                    ((this._isShown = !0),
                                    this._checkScrollbar(),
                                    this._setScrollbar(),
                                    this._adjustDialog(),
                                    this._setEscapeEvent(),
                                    this._setResizeEvent(),
                                    t(this._element).on(
                                        "click.dismiss.bs.modal",
                                        '[data-dismiss="modal"]',
                                        function (e) {
                                            return n.hide(e);
                                        }
                                    ),
                                    t(this._dialog).on(
                                        "mousedown.dismiss.bs.modal",
                                        function () {
                                            t(n._element).one(
                                                "mouseup.dismiss.bs.modal",
                                                function (e) {
                                                    t(e.target).is(
                                                        n._element
                                                    ) &&
                                                        (n._ignoreBackdropClick =
                                                            !0);
                                                }
                                            );
                                        }
                                    ),
                                    this._showBackdrop(function () {
                                        return n._showElement(e);
                                    }));
                        }
                    }),
                    (n.hide = function (e) {
                        var n = this;
                        if (
                            (e && e.preventDefault(),
                            this._isShown && !this._isTransitioning)
                        ) {
                            var o = t.Event("hide.bs.modal");
                            if (
                                (t(this._element).trigger(o),
                                this._isShown && !o.isDefaultPrevented())
                            ) {
                                this._isShown = !1;
                                var i = t(this._element).hasClass("fade");
                                if (
                                    (i && (this._isTransitioning = !0),
                                    this._setEscapeEvent(),
                                    this._setResizeEvent(),
                                    t(document).off("focusin.bs.modal"),
                                    t(this._element).removeClass("show"),
                                    t(this._element).off(
                                        "click.dismiss.bs.modal"
                                    ),
                                    t(this._dialog).off(
                                        "mousedown.dismiss.bs.modal"
                                    ),
                                    i)
                                ) {
                                    var r = s.getTransitionDurationFromElement(
                                        this._element
                                    );
                                    t(this._element)
                                        .one(s.TRANSITION_END, function (e) {
                                            return n._hideModal(e);
                                        })
                                        .emulateTransitionEnd(r);
                                } else this._hideModal();
                            }
                        }
                    }),
                    (n.dispose = function () {
                        [window, this._element, this._dialog].forEach(function (
                            e
                        ) {
                            return t(e).off(".bs.modal");
                        }),
                            t(document).off("focusin.bs.modal"),
                            t.removeData(this._element, "bs.modal"),
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
                    (n._getConfig = function (e) {
                        return (
                            (e = a(a({}, Ce), e)),
                            s.typeCheckConfig("modal", e, Ee),
                            e
                        );
                    }),
                    (n._triggerBackdropTransition = function () {
                        var e = this;
                        if ("static" === this._config.backdrop) {
                            var n = t.Event("hidePrevented.bs.modal");
                            if (
                                (t(this._element).trigger(n),
                                n.defaultPrevented)
                            )
                                return;
                            this._element.classList.add("modal-static");
                            var o = s.getTransitionDurationFromElement(
                                this._element
                            );
                            t(this._element)
                                .one(s.TRANSITION_END, function () {
                                    e._element.classList.remove("modal-static");
                                })
                                .emulateTransitionEnd(o),
                                this._element.focus();
                        } else this.hide();
                    }),
                    (n._showElement = function (e) {
                        var n = this,
                            o = t(this._element).hasClass("fade"),
                            i = this._dialog
                                ? this._dialog.querySelector(".modal-body")
                                : null;
                        (this._element.parentNode &&
                            this._element.parentNode.nodeType ===
                                Node.ELEMENT_NODE) ||
                            document.body.appendChild(this._element),
                            (this._element.style.display = "block"),
                            this._element.removeAttribute("aria-hidden"),
                            this._element.setAttribute("aria-modal", !0),
                            t(this._dialog).hasClass(
                                "modal-dialog-scrollable"
                            ) && i
                                ? (i.scrollTop = 0)
                                : (this._element.scrollTop = 0),
                            o && s.reflow(this._element),
                            t(this._element).addClass("show"),
                            this._config.focus && this._enforceFocus();
                        var r = t.Event("shown.bs.modal", { relatedTarget: e }),
                            a = function () {
                                n._config.focus && n._element.focus(),
                                    (n._isTransitioning = !1),
                                    t(n._element).trigger(r);
                            };
                        if (o) {
                            var l = s.getTransitionDurationFromElement(
                                this._dialog
                            );
                            t(this._dialog)
                                .one(s.TRANSITION_END, a)
                                .emulateTransitionEnd(l);
                        } else a();
                    }),
                    (n._enforceFocus = function () {
                        var e = this;
                        t(document)
                            .off("focusin.bs.modal")
                            .on("focusin.bs.modal", function (n) {
                                document !== n.target &&
                                    e._element !== n.target &&
                                    0 === t(e._element).has(n.target).length &&
                                    e._element.focus();
                            });
                    }),
                    (n._setEscapeEvent = function () {
                        var e = this;
                        this._isShown
                            ? t(this._element).on(
                                  "keydown.dismiss.bs.modal",
                                  function (t) {
                                      e._config.keyboard && 27 === t.which
                                          ? (t.preventDefault(), e.hide())
                                          : e._config.keyboard ||
                                            27 !== t.which ||
                                            e._triggerBackdropTransition();
                                  }
                              )
                            : this._isShown ||
                              t(this._element).off("keydown.dismiss.bs.modal");
                    }),
                    (n._setResizeEvent = function () {
                        var e = this;
                        this._isShown
                            ? t(window).on("resize.bs.modal", function (t) {
                                  return e.handleUpdate(t);
                              })
                            : t(window).off("resize.bs.modal");
                    }),
                    (n._hideModal = function () {
                        var e = this;
                        (this._element.style.display = "none"),
                            this._element.setAttribute("aria-hidden", !0),
                            this._element.removeAttribute("aria-modal"),
                            (this._isTransitioning = !1),
                            this._showBackdrop(function () {
                                t(document.body).removeClass("modal-open"),
                                    e._resetAdjustments(),
                                    e._resetScrollbar(),
                                    t(e._element).trigger("hidden.bs.modal");
                            });
                    }),
                    (n._removeBackdrop = function () {
                        this._backdrop &&
                            (t(this._backdrop).remove(),
                            (this._backdrop = null));
                    }),
                    (n._showBackdrop = function (e) {
                        var n = this,
                            o = t(this._element).hasClass("fade") ? "fade" : "";
                        if (this._isShown && this._config.backdrop) {
                            if (
                                ((this._backdrop =
                                    document.createElement("div")),
                                (this._backdrop.className = "modal-backdrop"),
                                o && this._backdrop.classList.add(o),
                                t(this._backdrop).appendTo(document.body),
                                t(this._element).on(
                                    "click.dismiss.bs.modal",
                                    function (e) {
                                        n._ignoreBackdropClick
                                            ? (n._ignoreBackdropClick = !1)
                                            : e.target === e.currentTarget &&
                                              n._triggerBackdropTransition();
                                    }
                                ),
                                o && s.reflow(this._backdrop),
                                t(this._backdrop).addClass("show"),
                                !e)
                            )
                                return;
                            if (!o) return void e();
                            var i = s.getTransitionDurationFromElement(
                                this._backdrop
                            );
                            t(this._backdrop)
                                .one(s.TRANSITION_END, e)
                                .emulateTransitionEnd(i);
                        } else if (!this._isShown && this._backdrop) {
                            t(this._backdrop).removeClass("show");
                            var r = function () {
                                n._removeBackdrop(), e && e();
                            };
                            if (t(this._element).hasClass("fade")) {
                                var a = s.getTransitionDurationFromElement(
                                    this._backdrop
                                );
                                t(this._backdrop)
                                    .one(s.TRANSITION_END, r)
                                    .emulateTransitionEnd(a);
                            } else r();
                        } else e && e();
                    }),
                    (n._adjustDialog = function () {
                        var e =
                            this._element.scrollHeight >
                            document.documentElement.clientHeight;
                        !this._isBodyOverflowing &&
                            e &&
                            (this._element.style.paddingLeft =
                                this._scrollbarWidth + "px"),
                            this._isBodyOverflowing &&
                                !e &&
                                (this._element.style.paddingRight =
                                    this._scrollbarWidth + "px");
                    }),
                    (n._resetAdjustments = function () {
                        (this._element.style.paddingLeft = ""),
                            (this._element.style.paddingRight = "");
                    }),
                    (n._checkScrollbar = function () {
                        var e = document.body.getBoundingClientRect();
                        (this._isBodyOverflowing =
                            Math.round(e.left + e.right) < window.innerWidth),
                            (this._scrollbarWidth = this._getScrollbarWidth());
                    }),
                    (n._setScrollbar = function () {
                        var e = this;
                        if (this._isBodyOverflowing) {
                            var n = [].slice.call(
                                    document.querySelectorAll(
                                        ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top"
                                    )
                                ),
                                o = [].slice.call(
                                    document.querySelectorAll(".sticky-top")
                                );
                            t(n).each(function (n, o) {
                                var i = o.style.paddingRight,
                                    r = t(o).css("padding-right");
                                t(o)
                                    .data("padding-right", i)
                                    .css(
                                        "padding-right",
                                        parseFloat(r) + e._scrollbarWidth + "px"
                                    );
                            }),
                                t(o).each(function (n, o) {
                                    var i = o.style.marginRight,
                                        r = t(o).css("margin-right");
                                    t(o)
                                        .data("margin-right", i)
                                        .css(
                                            "margin-right",
                                            parseFloat(r) -
                                                e._scrollbarWidth +
                                                "px"
                                        );
                                });
                            var i = document.body.style.paddingRight,
                                r = t(document.body).css("padding-right");
                            t(document.body)
                                .data("padding-right", i)
                                .css(
                                    "padding-right",
                                    parseFloat(r) + this._scrollbarWidth + "px"
                                );
                        }
                        t(document.body).addClass("modal-open");
                    }),
                    (n._resetScrollbar = function () {
                        var e = [].slice.call(
                            document.querySelectorAll(
                                ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top"
                            )
                        );
                        t(e).each(function (e, n) {
                            var o = t(n).data("padding-right");
                            t(n).removeData("padding-right"),
                                (n.style.paddingRight = o || "");
                        });
                        var n = [].slice.call(
                            document.querySelectorAll(".sticky-top")
                        );
                        t(n).each(function (e, n) {
                            var o = t(n).data("margin-right");
                            void 0 !== o &&
                                t(n)
                                    .css("margin-right", o)
                                    .removeData("margin-right");
                        });
                        var o = t(document.body).data("padding-right");
                        t(document.body).removeData("padding-right"),
                            (document.body.style.paddingRight = o || "");
                    }),
                    (n._getScrollbarWidth = function () {
                        var e = document.createElement("div");
                        (e.className = "modal-scrollbar-measure"),
                            document.body.appendChild(e);
                        var t = e.getBoundingClientRect().width - e.clientWidth;
                        return document.body.removeChild(e), t;
                    }),
                    (e._jQueryInterface = function (n, o) {
                        return this.each(function () {
                            var i = t(this).data("bs.modal"),
                                r = a(
                                    a(a({}, Ce), t(this).data()),
                                    "object" == typeof n && n ? n : {}
                                );
                            if (
                                (i ||
                                    ((i = new e(this, r)),
                                    t(this).data("bs.modal", i)),
                                "string" == typeof n)
                            ) {
                                if (void 0 === i[n])
                                    throw new TypeError(
                                        'No method named "' + n + '"'
                                    );
                                i[n](o);
                            } else r.show && i.show(o);
                        });
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                        {
                            key: "Default",
                            get: function () {
                                return Ce;
                            },
                        },
                    ]),
                    e
                );
            })();
        t(document).on(
            "click.bs.modal.data-api",
            '[data-toggle="modal"]',
            function (e) {
                var n,
                    o = this,
                    i = s.getSelectorFromElement(this);
                i && (n = document.querySelector(i));
                var r = t(n).data("bs.modal")
                    ? "toggle"
                    : a(a({}, t(n).data()), t(this).data());
                ("A" !== this.tagName && "AREA" !== this.tagName) ||
                    e.preventDefault();
                var l = t(n).one("show.bs.modal", function (e) {
                    e.isDefaultPrevented() ||
                        l.one("hidden.bs.modal", function () {
                            t(o).is(":visible") && o.focus();
                        });
                });
                Te._jQueryInterface.call(t(n), r, this);
            }
        ),
            (t.fn.modal = Te._jQueryInterface),
            (t.fn.modal.Constructor = Te),
            (t.fn.modal.noConflict = function () {
                return (t.fn.modal = ke), Te._jQueryInterface;
            });
        var Se = [
                "background",
                "cite",
                "href",
                "itemtype",
                "longdesc",
                "poster",
                "src",
                "xlink:href",
            ],
            Ae =
                /^(?:(?:https?|mailto|ftp|tel|file):|[^#&\/:?]*(?:[#\/?]|$))/gi,
            De =
                /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+\/a-z]+=*$/i;
        function Ne(e, t, n) {
            if (0 === e.length) return e;
            if (n && "function" == typeof n) return n(e);
            for (
                var o = new window.DOMParser().parseFromString(e, "text/html"),
                    i = Object.keys(t),
                    r = [].slice.call(o.body.querySelectorAll("*")),
                    a = function (e, n) {
                        var o = r[e],
                            a = o.nodeName.toLowerCase();
                        if (-1 === i.indexOf(o.nodeName.toLowerCase()))
                            return o.parentNode.removeChild(o), "continue";
                        var s = [].slice.call(o.attributes),
                            l = [].concat(t["*"] || [], t[a] || []);
                        s.forEach(function (e) {
                            (function (e, t) {
                                var n = e.nodeName.toLowerCase();
                                if (-1 !== t.indexOf(n))
                                    return (
                                        -1 === Se.indexOf(n) ||
                                        Boolean(
                                            e.nodeValue.match(Ae) ||
                                                e.nodeValue.match(De)
                                        )
                                    );
                                for (
                                    var o = t.filter(function (e) {
                                            return e instanceof RegExp;
                                        }),
                                        i = 0,
                                        r = o.length;
                                    i < r;
                                    i++
                                )
                                    if (n.match(o[i])) return !0;
                                return !1;
                            })(e, l) || o.removeAttribute(e.nodeName);
                        });
                    },
                    s = 0,
                    l = r.length;
                s < l;
                s++
            )
                a(s);
            return o.body.innerHTML;
        }
        var je = "tooltip",
            Oe = t.fn[je],
            Le = new RegExp("(^|\\s)bs-tooltip\\S+", "g"),
            Pe = ["sanitize", "whiteList", "sanitizeFn"],
            Ie = {
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
            qe = {
                AUTO: "auto",
                TOP: "top",
                RIGHT: "right",
                BOTTOM: "bottom",
                LEFT: "left",
            },
            He = {
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
                whiteList: {
                    "*": [
                        "class",
                        "dir",
                        "id",
                        "lang",
                        "role",
                        /^aria-[\w-]*$/i,
                    ],
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
                popperConfig: null,
            },
            Be = {
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
            Me = (function () {
                function e(e, t) {
                    if (void 0 === ge)
                        throw new TypeError(
                            "Bootstrap's tooltips require Popper.js (https://popper.js.org/)"
                        );
                    (this._isEnabled = !0),
                        (this._timeout = 0),
                        (this._hoverState = ""),
                        (this._activeTrigger = {}),
                        (this._popper = null),
                        (this.element = e),
                        (this.config = this._getConfig(t)),
                        (this.tip = null),
                        this._setListeners();
                }
                var n = e.prototype;
                return (
                    (n.enable = function () {
                        this._isEnabled = !0;
                    }),
                    (n.disable = function () {
                        this._isEnabled = !1;
                    }),
                    (n.toggleEnabled = function () {
                        this._isEnabled = !this._isEnabled;
                    }),
                    (n.toggle = function (e) {
                        if (this._isEnabled)
                            if (e) {
                                var n = this.constructor.DATA_KEY,
                                    o = t(e.currentTarget).data(n);
                                o ||
                                    ((o = new this.constructor(
                                        e.currentTarget,
                                        this._getDelegateConfig()
                                    )),
                                    t(e.currentTarget).data(n, o)),
                                    (o._activeTrigger.click =
                                        !o._activeTrigger.click),
                                    o._isWithActiveTrigger()
                                        ? o._enter(null, o)
                                        : o._leave(null, o);
                            } else {
                                if (t(this.getTipElement()).hasClass("show"))
                                    return void this._leave(null, this);
                                this._enter(null, this);
                            }
                    }),
                    (n.dispose = function () {
                        clearTimeout(this._timeout),
                            t.removeData(
                                this.element,
                                this.constructor.DATA_KEY
                            ),
                            t(this.element).off(this.constructor.EVENT_KEY),
                            t(this.element)
                                .closest(".modal")
                                .off("hide.bs.modal", this._hideModalHandler),
                            this.tip && t(this.tip).remove(),
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
                    (n.show = function () {
                        var e = this;
                        if ("none" === t(this.element).css("display"))
                            throw new Error(
                                "Please use show on visible elements"
                            );
                        var n = t.Event(this.constructor.Event.SHOW);
                        if (this.isWithContent() && this._isEnabled) {
                            t(this.element).trigger(n);
                            var o = s.findShadowRoot(this.element),
                                i = t.contains(
                                    null !== o
                                        ? o
                                        : this.element.ownerDocument
                                              .documentElement,
                                    this.element
                                );
                            if (n.isDefaultPrevented() || !i) return;
                            var r = this.getTipElement(),
                                a = s.getUID(this.constructor.NAME);
                            r.setAttribute("id", a),
                                this.element.setAttribute(
                                    "aria-describedby",
                                    a
                                ),
                                this.setContent(),
                                this.config.animation && t(r).addClass("fade");
                            var l =
                                    "function" == typeof this.config.placement
                                        ? this.config.placement.call(
                                              this,
                                              r,
                                              this.element
                                          )
                                        : this.config.placement,
                                c = this._getAttachment(l);
                            this.addAttachmentClass(c);
                            var u = this._getContainer();
                            t(r).data(this.constructor.DATA_KEY, this),
                                t.contains(
                                    this.element.ownerDocument.documentElement,
                                    this.tip
                                ) || t(r).appendTo(u),
                                t(this.element).trigger(
                                    this.constructor.Event.INSERTED
                                ),
                                (this._popper = new ge(
                                    this.element,
                                    r,
                                    this._getPopperConfig(c)
                                )),
                                t(r).addClass("show"),
                                "ontouchstart" in document.documentElement &&
                                    t(document.body)
                                        .children()
                                        .on("mouseover", null, t.noop);
                            var d = function () {
                                e.config.animation && e._fixTransition();
                                var n = e._hoverState;
                                (e._hoverState = null),
                                    t(e.element).trigger(
                                        e.constructor.Event.SHOWN
                                    ),
                                    "out" === n && e._leave(null, e);
                            };
                            if (t(this.tip).hasClass("fade")) {
                                var f = s.getTransitionDurationFromElement(
                                    this.tip
                                );
                                t(this.tip)
                                    .one(s.TRANSITION_END, d)
                                    .emulateTransitionEnd(f);
                            } else d();
                        }
                    }),
                    (n.hide = function (e) {
                        var n = this,
                            o = this.getTipElement(),
                            i = t.Event(this.constructor.Event.HIDE),
                            r = function () {
                                "show" !== n._hoverState &&
                                    o.parentNode &&
                                    o.parentNode.removeChild(o),
                                    n._cleanTipClass(),
                                    n.element.removeAttribute(
                                        "aria-describedby"
                                    ),
                                    t(n.element).trigger(
                                        n.constructor.Event.HIDDEN
                                    ),
                                    null !== n._popper && n._popper.destroy(),
                                    e && e();
                            };
                        if (
                            (t(this.element).trigger(i),
                            !i.isDefaultPrevented())
                        ) {
                            if (
                                (t(o).removeClass("show"),
                                "ontouchstart" in document.documentElement &&
                                    t(document.body)
                                        .children()
                                        .off("mouseover", null, t.noop),
                                (this._activeTrigger.click = !1),
                                (this._activeTrigger.focus = !1),
                                (this._activeTrigger.hover = !1),
                                t(this.tip).hasClass("fade"))
                            ) {
                                var a = s.getTransitionDurationFromElement(o);
                                t(o)
                                    .one(s.TRANSITION_END, r)
                                    .emulateTransitionEnd(a);
                            } else r();
                            this._hoverState = "";
                        }
                    }),
                    (n.update = function () {
                        null !== this._popper && this._popper.scheduleUpdate();
                    }),
                    (n.isWithContent = function () {
                        return Boolean(this.getTitle());
                    }),
                    (n.addAttachmentClass = function (e) {
                        t(this.getTipElement()).addClass("bs-tooltip-" + e);
                    }),
                    (n.getTipElement = function () {
                        return (
                            (this.tip = this.tip || t(this.config.template)[0]),
                            this.tip
                        );
                    }),
                    (n.setContent = function () {
                        var e = this.getTipElement();
                        this.setElementContent(
                            t(e.querySelectorAll(".tooltip-inner")),
                            this.getTitle()
                        ),
                            t(e).removeClass("fade show");
                    }),
                    (n.setElementContent = function (e, n) {
                        "object" != typeof n || (!n.nodeType && !n.jquery)
                            ? this.config.html
                                ? (this.config.sanitize &&
                                      (n = Ne(
                                          n,
                                          this.config.whiteList,
                                          this.config.sanitizeFn
                                      )),
                                  e.html(n))
                                : e.text(n)
                            : this.config.html
                            ? t(n).parent().is(e) || e.empty().append(n)
                            : e.text(t(n).text());
                    }),
                    (n.getTitle = function () {
                        var e = this.element.getAttribute(
                            "data-original-title"
                        );
                        return (
                            e ||
                                (e =
                                    "function" == typeof this.config.title
                                        ? this.config.title.call(this.element)
                                        : this.config.title),
                            e
                        );
                    }),
                    (n._getPopperConfig = function (e) {
                        var t = this;
                        return a(
                            a(
                                {},
                                {
                                    placement: e,
                                    modifiers: {
                                        offset: this._getOffset(),
                                        flip: {
                                            behavior:
                                                this.config.fallbackPlacement,
                                        },
                                        arrow: { element: ".arrow" },
                                        preventOverflow: {
                                            boundariesElement:
                                                this.config.boundary,
                                        },
                                    },
                                    onCreate: function (e) {
                                        e.originalPlacement !== e.placement &&
                                            t._handlePopperPlacementChange(e);
                                    },
                                    onUpdate: function (e) {
                                        return t._handlePopperPlacementChange(
                                            e
                                        );
                                    },
                                }
                            ),
                            this.config.popperConfig
                        );
                    }),
                    (n._getOffset = function () {
                        var e = this,
                            t = {};
                        return (
                            "function" == typeof this.config.offset
                                ? (t.fn = function (t) {
                                      return (
                                          (t.offsets = a(
                                              a({}, t.offsets),
                                              e.config.offset(
                                                  t.offsets,
                                                  e.element
                                              ) || {}
                                          )),
                                          t
                                      );
                                  })
                                : (t.offset = this.config.offset),
                            t
                        );
                    }),
                    (n._getContainer = function () {
                        return !1 === this.config.container
                            ? document.body
                            : s.isElement(this.config.container)
                            ? t(this.config.container)
                            : t(document).find(this.config.container);
                    }),
                    (n._getAttachment = function (e) {
                        return qe[e.toUpperCase()];
                    }),
                    (n._setListeners = function () {
                        var e = this;
                        this.config.trigger.split(" ").forEach(function (n) {
                            if ("click" === n)
                                t(e.element).on(
                                    e.constructor.Event.CLICK,
                                    e.config.selector,
                                    function (t) {
                                        return e.toggle(t);
                                    }
                                );
                            else if ("manual" !== n) {
                                var o =
                                        "hover" === n
                                            ? e.constructor.Event.MOUSEENTER
                                            : e.constructor.Event.FOCUSIN,
                                    i =
                                        "hover" === n
                                            ? e.constructor.Event.MOUSELEAVE
                                            : e.constructor.Event.FOCUSOUT;
                                t(e.element)
                                    .on(o, e.config.selector, function (t) {
                                        return e._enter(t);
                                    })
                                    .on(i, e.config.selector, function (t) {
                                        return e._leave(t);
                                    });
                            }
                        }),
                            (this._hideModalHandler = function () {
                                e.element && e.hide();
                            }),
                            t(this.element)
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
                    (n._fixTitle = function () {
                        var e = typeof this.element.getAttribute(
                            "data-original-title"
                        );
                        (this.element.getAttribute("title") ||
                            "string" !== e) &&
                            (this.element.setAttribute(
                                "data-original-title",
                                this.element.getAttribute("title") || ""
                            ),
                            this.element.setAttribute("title", ""));
                    }),
                    (n._enter = function (e, n) {
                        var o = this.constructor.DATA_KEY;
                        (n = n || t(e.currentTarget).data(o)) ||
                            ((n = new this.constructor(
                                e.currentTarget,
                                this._getDelegateConfig()
                            )),
                            t(e.currentTarget).data(o, n)),
                            e &&
                                (n._activeTrigger[
                                    "focusin" === e.type ? "focus" : "hover"
                                ] = !0),
                            t(n.getTipElement()).hasClass("show") ||
                            "show" === n._hoverState
                                ? (n._hoverState = "show")
                                : (clearTimeout(n._timeout),
                                  (n._hoverState = "show"),
                                  n.config.delay && n.config.delay.show
                                      ? (n._timeout = setTimeout(function () {
                                            "show" === n._hoverState &&
                                                n.show();
                                        }, n.config.delay.show))
                                      : n.show());
                    }),
                    (n._leave = function (e, n) {
                        var o = this.constructor.DATA_KEY;
                        (n = n || t(e.currentTarget).data(o)) ||
                            ((n = new this.constructor(
                                e.currentTarget,
                                this._getDelegateConfig()
                            )),
                            t(e.currentTarget).data(o, n)),
                            e &&
                                (n._activeTrigger[
                                    "focusout" === e.type ? "focus" : "hover"
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
                    (n._isWithActiveTrigger = function () {
                        for (var e in this._activeTrigger)
                            if (this._activeTrigger[e]) return !0;
                        return !1;
                    }),
                    (n._getConfig = function (e) {
                        var n = t(this.element).data();
                        return (
                            Object.keys(n).forEach(function (e) {
                                -1 !== Pe.indexOf(e) && delete n[e];
                            }),
                            "number" ==
                                typeof (e = a(
                                    a(a({}, this.constructor.Default), n),
                                    "object" == typeof e && e ? e : {}
                                )).delay &&
                                (e.delay = { show: e.delay, hide: e.delay }),
                            "number" == typeof e.title &&
                                (e.title = e.title.toString()),
                            "number" == typeof e.content &&
                                (e.content = e.content.toString()),
                            s.typeCheckConfig(
                                je,
                                e,
                                this.constructor.DefaultType
                            ),
                            e.sanitize &&
                                (e.template = Ne(
                                    e.template,
                                    e.whiteList,
                                    e.sanitizeFn
                                )),
                            e
                        );
                    }),
                    (n._getDelegateConfig = function () {
                        var e = {};
                        if (this.config)
                            for (var t in this.config)
                                this.constructor.Default[t] !==
                                    this.config[t] && (e[t] = this.config[t]);
                        return e;
                    }),
                    (n._cleanTipClass = function () {
                        var e = t(this.getTipElement()),
                            n = e.attr("class").match(Le);
                        null !== n && n.length && e.removeClass(n.join(""));
                    }),
                    (n._handlePopperPlacementChange = function (e) {
                        (this.tip = e.instance.popper),
                            this._cleanTipClass(),
                            this.addAttachmentClass(
                                this._getAttachment(e.placement)
                            );
                    }),
                    (n._fixTransition = function () {
                        var e = this.getTipElement(),
                            n = this.config.animation;
                        null === e.getAttribute("x-placement") &&
                            (t(e).removeClass("fade"),
                            (this.config.animation = !1),
                            this.hide(),
                            this.show(),
                            (this.config.animation = n));
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this).data("bs.tooltip"),
                                i = "object" == typeof n && n;
                            if (
                                (o || !/dispose|hide/.test(n)) &&
                                (o ||
                                    ((o = new e(this, i)),
                                    t(this).data("bs.tooltip", o)),
                                "string" == typeof n)
                            ) {
                                if (void 0 === o[n])
                                    throw new TypeError(
                                        'No method named "' + n + '"'
                                    );
                                o[n]();
                            }
                        });
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                        {
                            key: "Default",
                            get: function () {
                                return He;
                            },
                        },
                        {
                            key: "NAME",
                            get: function () {
                                return je;
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
                                return Be;
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
                                return Ie;
                            },
                        },
                    ]),
                    e
                );
            })();
        (t.fn[je] = Me._jQueryInterface),
            (t.fn[je].Constructor = Me),
            (t.fn[je].noConflict = function () {
                return (t.fn[je] = Oe), Me._jQueryInterface;
            });
        var Re = "popover",
            Fe = t.fn[Re],
            We = new RegExp("(^|\\s)bs-popover\\S+", "g"),
            ze = a(
                a({}, Me.Default),
                {},
                {
                    placement: "right",
                    trigger: "click",
                    content: "",
                    template:
                        '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                }
            ),
            Ue = a(
                a({}, Me.DefaultType),
                {},
                { content: "(string|element|function)" }
            ),
            Ve = {
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
            $e = (function (e) {
                var n, i;
                function r() {
                    return e.apply(this, arguments) || this;
                }
                (i = e),
                    ((n = r).prototype = Object.create(i.prototype)),
                    (n.prototype.constructor = n),
                    (n.__proto__ = i);
                var a = r.prototype;
                return (
                    (a.isWithContent = function () {
                        return this.getTitle() || this._getContent();
                    }),
                    (a.addAttachmentClass = function (e) {
                        t(this.getTipElement()).addClass("bs-popover-" + e);
                    }),
                    (a.getTipElement = function () {
                        return (
                            (this.tip = this.tip || t(this.config.template)[0]),
                            this.tip
                        );
                    }),
                    (a.setContent = function () {
                        var e = t(this.getTipElement());
                        this.setElementContent(
                            e.find(".popover-header"),
                            this.getTitle()
                        );
                        var n = this._getContent();
                        "function" == typeof n && (n = n.call(this.element)),
                            this.setElementContent(e.find(".popover-body"), n),
                            e.removeClass("fade show");
                    }),
                    (a._getContent = function () {
                        return (
                            this.element.getAttribute("data-content") ||
                            this.config.content
                        );
                    }),
                    (a._cleanTipClass = function () {
                        var e = t(this.getTipElement()),
                            n = e.attr("class").match(We);
                        null !== n && n.length > 0 && e.removeClass(n.join(""));
                    }),
                    (r._jQueryInterface = function (e) {
                        return this.each(function () {
                            var n = t(this).data("bs.popover"),
                                o = "object" == typeof e ? e : null;
                            if (
                                (n || !/dispose|hide/.test(e)) &&
                                (n ||
                                    ((n = new r(this, o)),
                                    t(this).data("bs.popover", n)),
                                "string" == typeof e)
                            ) {
                                if (void 0 === n[e])
                                    throw new TypeError(
                                        'No method named "' + e + '"'
                                    );
                                n[e]();
                            }
                        });
                    }),
                    o(r, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                        {
                            key: "Default",
                            get: function () {
                                return ze;
                            },
                        },
                        {
                            key: "NAME",
                            get: function () {
                                return Re;
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
                                return Ve;
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
                                return Ue;
                            },
                        },
                    ]),
                    r
                );
            })(Me);
        (t.fn[Re] = $e._jQueryInterface),
            (t.fn[Re].Constructor = $e),
            (t.fn[Re].noConflict = function () {
                return (t.fn[Re] = Fe), $e._jQueryInterface;
            });
        var Ye = "scrollspy",
            Qe = t.fn[Ye],
            Xe = { offset: 10, method: "auto", target: "" },
            Ke = {
                offset: "number",
                method: "string",
                target: "(string|element)",
            },
            Ze = (function () {
                function e(e, n) {
                    var o = this;
                    (this._element = e),
                        (this._scrollElement =
                            "BODY" === e.tagName ? window : e),
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
                        t(this._scrollElement).on(
                            "scroll.bs.scrollspy",
                            function (e) {
                                return o._process(e);
                            }
                        ),
                        this.refresh(),
                        this._process();
                }
                var n = e.prototype;
                return (
                    (n.refresh = function () {
                        var e = this,
                            n =
                                this._scrollElement ===
                                this._scrollElement.window
                                    ? "offset"
                                    : "position",
                            o =
                                "auto" === this._config.method
                                    ? n
                                    : this._config.method,
                            i = "position" === o ? this._getScrollTop() : 0;
                        (this._offsets = []),
                            (this._targets = []),
                            (this._scrollHeight = this._getScrollHeight()),
                            [].slice
                                .call(document.querySelectorAll(this._selector))
                                .map(function (e) {
                                    var n,
                                        r = s.getSelectorFromElement(e);
                                    if (
                                        (r && (n = document.querySelector(r)),
                                        n)
                                    ) {
                                        var a = n.getBoundingClientRect();
                                        if (a.width || a.height)
                                            return [t(n)[o]().top + i, r];
                                    }
                                    return null;
                                })
                                .filter(function (e) {
                                    return e;
                                })
                                .sort(function (e, t) {
                                    return e[0] - t[0];
                                })
                                .forEach(function (t) {
                                    e._offsets.push(t[0]),
                                        e._targets.push(t[1]);
                                });
                    }),
                    (n.dispose = function () {
                        t.removeData(this._element, "bs.scrollspy"),
                            t(this._scrollElement).off(".bs.scrollspy"),
                            (this._element = null),
                            (this._scrollElement = null),
                            (this._config = null),
                            (this._selector = null),
                            (this._offsets = null),
                            (this._targets = null),
                            (this._activeTarget = null),
                            (this._scrollHeight = null);
                    }),
                    (n._getConfig = function (e) {
                        if (
                            "string" !=
                                typeof (e = a(
                                    a({}, Xe),
                                    "object" == typeof e && e ? e : {}
                                )).target &&
                            s.isElement(e.target)
                        ) {
                            var n = t(e.target).attr("id");
                            n ||
                                ((n = s.getUID(Ye)), t(e.target).attr("id", n)),
                                (e.target = "#" + n);
                        }
                        return s.typeCheckConfig(Ye, e, Ke), e;
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
                            : this._scrollElement.getBoundingClientRect()
                                  .height;
                    }),
                    (n._process = function () {
                        var e = this._getScrollTop() + this._config.offset,
                            t = this._getScrollHeight(),
                            n =
                                this._config.offset +
                                t -
                                this._getOffsetHeight();
                        if (
                            (this._scrollHeight !== t && this.refresh(), e >= n)
                        ) {
                            var o = this._targets[this._targets.length - 1];
                            this._activeTarget !== o && this._activate(o);
                        } else {
                            if (
                                this._activeTarget &&
                                e < this._offsets[0] &&
                                this._offsets[0] > 0
                            )
                                return (
                                    (this._activeTarget = null),
                                    void this._clear()
                                );
                            for (var i = this._offsets.length; i--; )
                                this._activeTarget !== this._targets[i] &&
                                    e >= this._offsets[i] &&
                                    (void 0 === this._offsets[i + 1] ||
                                        e < this._offsets[i + 1]) &&
                                    this._activate(this._targets[i]);
                        }
                    }),
                    (n._activate = function (e) {
                        (this._activeTarget = e), this._clear();
                        var n = this._selector.split(",").map(function (t) {
                                return (
                                    t +
                                    '[data-target="' +
                                    e +
                                    '"],' +
                                    t +
                                    '[href="' +
                                    e +
                                    '"]'
                                );
                            }),
                            o = t(
                                [].slice.call(
                                    document.querySelectorAll(n.join(","))
                                )
                            );
                        o.hasClass("dropdown-item")
                            ? (o
                                  .closest(".dropdown")
                                  .find(".dropdown-toggle")
                                  .addClass("active"),
                              o.addClass("active"))
                            : (o.addClass("active"),
                              o
                                  .parents(".nav, .list-group")
                                  .prev(".nav-link, .list-group-item")
                                  .addClass("active"),
                              o
                                  .parents(".nav, .list-group")
                                  .prev(".nav-item")
                                  .children(".nav-link")
                                  .addClass("active")),
                            t(this._scrollElement).trigger(
                                "activate.bs.scrollspy",
                                { relatedTarget: e }
                            );
                    }),
                    (n._clear = function () {
                        [].slice
                            .call(document.querySelectorAll(this._selector))
                            .filter(function (e) {
                                return e.classList.contains("active");
                            })
                            .forEach(function (e) {
                                return e.classList.remove("active");
                            });
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this).data("bs.scrollspy");
                            if (
                                (o ||
                                    ((o = new e(
                                        this,
                                        "object" == typeof n && n
                                    )),
                                    t(this).data("bs.scrollspy", o)),
                                "string" == typeof n)
                            ) {
                                if (void 0 === o[n])
                                    throw new TypeError(
                                        'No method named "' + n + '"'
                                    );
                                o[n]();
                            }
                        });
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                        {
                            key: "Default",
                            get: function () {
                                return Xe;
                            },
                        },
                    ]),
                    e
                );
            })();
        t(window).on("load.bs.scrollspy.data-api", function () {
            for (
                var e = [].slice.call(
                        document.querySelectorAll('[data-spy="scroll"]')
                    ),
                    n = e.length;
                n--;

            ) {
                var o = t(e[n]);
                Ze._jQueryInterface.call(o, o.data());
            }
        }),
            (t.fn[Ye] = Ze._jQueryInterface),
            (t.fn[Ye].Constructor = Ze),
            (t.fn[Ye].noConflict = function () {
                return (t.fn[Ye] = Qe), Ze._jQueryInterface;
            });
        var Ge = t.fn.tab,
            Je = (function () {
                function e(e) {
                    this._element = e;
                }
                var n = e.prototype;
                return (
                    (n.show = function () {
                        var e = this;
                        if (
                            !(
                                (this._element.parentNode &&
                                    this._element.parentNode.nodeType ===
                                        Node.ELEMENT_NODE &&
                                    t(this._element).hasClass("active")) ||
                                t(this._element).hasClass("disabled")
                            )
                        ) {
                            var n,
                                o,
                                i = t(this._element).closest(
                                    ".nav, .list-group"
                                )[0],
                                r = s.getSelectorFromElement(this._element);
                            if (i) {
                                var a =
                                    "UL" === i.nodeName || "OL" === i.nodeName
                                        ? "> li > .active"
                                        : ".active";
                                o = (o = t.makeArray(t(i).find(a)))[
                                    o.length - 1
                                ];
                            }
                            var l = t.Event("hide.bs.tab", {
                                    relatedTarget: this._element,
                                }),
                                c = t.Event("show.bs.tab", {
                                    relatedTarget: o,
                                });
                            if (
                                (o && t(o).trigger(l),
                                t(this._element).trigger(c),
                                !c.isDefaultPrevented() &&
                                    !l.isDefaultPrevented())
                            ) {
                                r && (n = document.querySelector(r)),
                                    this._activate(this._element, i);
                                var u = function () {
                                    var n = t.Event("hidden.bs.tab", {
                                            relatedTarget: e._element,
                                        }),
                                        i = t.Event("shown.bs.tab", {
                                            relatedTarget: o,
                                        });
                                    t(o).trigger(n), t(e._element).trigger(i);
                                };
                                n ? this._activate(n, n.parentNode, u) : u();
                            }
                        }
                    }),
                    (n.dispose = function () {
                        t.removeData(this._element, "bs.tab"),
                            (this._element = null);
                    }),
                    (n._activate = function (e, n, o) {
                        var i = this,
                            r = (
                                !n ||
                                ("UL" !== n.nodeName && "OL" !== n.nodeName)
                                    ? t(n).children(".active")
                                    : t(n).find("> li > .active")
                            )[0],
                            a = o && r && t(r).hasClass("fade"),
                            l = function () {
                                return i._transitionComplete(e, r, o);
                            };
                        if (r && a) {
                            var c = s.getTransitionDurationFromElement(r);
                            t(r)
                                .removeClass("show")
                                .one(s.TRANSITION_END, l)
                                .emulateTransitionEnd(c);
                        } else l();
                    }),
                    (n._transitionComplete = function (e, n, o) {
                        if (n) {
                            t(n).removeClass("active");
                            var i = t(n.parentNode).find(
                                "> .dropdown-menu .active"
                            )[0];
                            i && t(i).removeClass("active"),
                                "tab" === n.getAttribute("role") &&
                                    n.setAttribute("aria-selected", !1);
                        }
                        if (
                            (t(e).addClass("active"),
                            "tab" === e.getAttribute("role") &&
                                e.setAttribute("aria-selected", !0),
                            s.reflow(e),
                            e.classList.contains("fade") &&
                                e.classList.add("show"),
                            e.parentNode &&
                                t(e.parentNode).hasClass("dropdown-menu"))
                        ) {
                            var r = t(e).closest(".dropdown")[0];
                            if (r) {
                                var a = [].slice.call(
                                    r.querySelectorAll(".dropdown-toggle")
                                );
                                t(a).addClass("active");
                            }
                            e.setAttribute("aria-expanded", !0);
                        }
                        o && o();
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this),
                                i = o.data("bs.tab");
                            if (
                                (i || ((i = new e(this)), o.data("bs.tab", i)),
                                "string" == typeof n)
                            ) {
                                if (void 0 === i[n])
                                    throw new TypeError(
                                        'No method named "' + n + '"'
                                    );
                                i[n]();
                            }
                        });
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                    ]),
                    e
                );
            })();
        t(document).on(
            "click.bs.tab.data-api",
            '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',
            function (e) {
                e.preventDefault(), Je._jQueryInterface.call(t(this), "show");
            }
        ),
            (t.fn.tab = Je._jQueryInterface),
            (t.fn.tab.Constructor = Je),
            (t.fn.tab.noConflict = function () {
                return (t.fn.tab = Ge), Je._jQueryInterface;
            });
        var et = t.fn.toast,
            tt = { animation: "boolean", autohide: "boolean", delay: "number" },
            nt = { animation: !0, autohide: !0, delay: 500 },
            ot = (function () {
                function e(e, t) {
                    (this._element = e),
                        (this._config = this._getConfig(t)),
                        (this._timeout = null),
                        this._setListeners();
                }
                var n = e.prototype;
                return (
                    (n.show = function () {
                        var e = this,
                            n = t.Event("show.bs.toast");
                        if (
                            (t(this._element).trigger(n),
                            !n.isDefaultPrevented())
                        ) {
                            this._config.animation &&
                                this._element.classList.add("fade");
                            var o = function () {
                                e._element.classList.remove("showing"),
                                    e._element.classList.add("show"),
                                    t(e._element).trigger("shown.bs.toast"),
                                    e._config.autohide &&
                                        (e._timeout = setTimeout(function () {
                                            e.hide();
                                        }, e._config.delay));
                            };
                            if (
                                (this._element.classList.remove("hide"),
                                s.reflow(this._element),
                                this._element.classList.add("showing"),
                                this._config.animation)
                            ) {
                                var i = s.getTransitionDurationFromElement(
                                    this._element
                                );
                                t(this._element)
                                    .one(s.TRANSITION_END, o)
                                    .emulateTransitionEnd(i);
                            } else o();
                        }
                    }),
                    (n.hide = function () {
                        if (this._element.classList.contains("show")) {
                            var e = t.Event("hide.bs.toast");
                            t(this._element).trigger(e),
                                e.isDefaultPrevented() || this._close();
                        }
                    }),
                    (n.dispose = function () {
                        clearTimeout(this._timeout),
                            (this._timeout = null),
                            this._element.classList.contains("show") &&
                                this._element.classList.remove("show"),
                            t(this._element).off("click.dismiss.bs.toast"),
                            t.removeData(this._element, "bs.toast"),
                            (this._element = null),
                            (this._config = null);
                    }),
                    (n._getConfig = function (e) {
                        return (
                            (e = a(
                                a(a({}, nt), t(this._element).data()),
                                "object" == typeof e && e ? e : {}
                            )),
                            s.typeCheckConfig(
                                "toast",
                                e,
                                this.constructor.DefaultType
                            ),
                            e
                        );
                    }),
                    (n._setListeners = function () {
                        var e = this;
                        t(this._element).on(
                            "click.dismiss.bs.toast",
                            '[data-dismiss="toast"]',
                            function () {
                                return e.hide();
                            }
                        );
                    }),
                    (n._close = function () {
                        var e = this,
                            n = function () {
                                e._element.classList.add("hide"),
                                    t(e._element).trigger("hidden.bs.toast");
                            };
                        if (
                            (this._element.classList.remove("show"),
                            this._config.animation)
                        ) {
                            var o = s.getTransitionDurationFromElement(
                                this._element
                            );
                            t(this._element)
                                .one(s.TRANSITION_END, n)
                                .emulateTransitionEnd(o);
                        } else n();
                    }),
                    (e._jQueryInterface = function (n) {
                        return this.each(function () {
                            var o = t(this),
                                i = o.data("bs.toast");
                            if (
                                (i ||
                                    ((i = new e(
                                        this,
                                        "object" == typeof n && n
                                    )),
                                    o.data("bs.toast", i)),
                                "string" == typeof n)
                            ) {
                                if (void 0 === i[n])
                                    throw new TypeError(
                                        'No method named "' + n + '"'
                                    );
                                i[n](this);
                            }
                        });
                    }),
                    o(e, null, [
                        {
                            key: "VERSION",
                            get: function () {
                                return "4.5.0";
                            },
                        },
                        {
                            key: "DefaultType",
                            get: function () {
                                return tt;
                            },
                        },
                        {
                            key: "Default",
                            get: function () {
                                return nt;
                            },
                        },
                    ]),
                    e
                );
            })();
        (t.fn.toast = ot._jQueryInterface),
            (t.fn.toast.Constructor = ot),
            (t.fn.toast.noConflict = function () {
                return (t.fn.toast = et), ot._jQueryInterface;
            }),
            (e.Alert = u),
            (e.Button = f),
            (e.Carousel = v),
            (e.Collapse = k),
            (e.Dropdown = _e),
            (e.Modal = Te),
            (e.Popover = $e),
            (e.Scrollspy = Ze),
            (e.Tab = Je),
            (e.Toast = ot),
            (e.Tooltip = Me),
            (e.Util = s),
            Object.defineProperty(e, "__esModule", { value: !0 });
    });
