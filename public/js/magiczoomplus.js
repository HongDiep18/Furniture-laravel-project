/*


   Magic Zoom Plus v5.0.1 DEMO
   Copyright 2015 Magic Toolbox
   Buy a license: https://www.magictoolbox.com/magiczoomplus/
   License agreement: https://www.magictoolbox.com/license/


*/
window.MagicZoom = (function() {
    var w, y;
    w = y = (function() {
        var S = {
            version: "v3.3-b3",
            UUID: 0,
            storage: {},
            $uuid: function(V) {
                return (V.$J_UUID || (V.$J_UUID = ++M.UUID))
            },
            getStorage: function(V) {
                return (M.storage[V] || (M.storage[V] = {}))
            },
            $F: function() {},
            $false: function() {
                return false
            },
            $true: function() {
                return true
            },
            stylesId: "mjs-" + Math.floor(Math.random() * new Date().getTime()),
            defined: function(V) {
                return (undefined != V)
            },
            ifndef: function(W, V) {
                return (undefined != W) ? W : V
            },
            exists: function(V) {
                return !!(V)
            },
            jTypeOf: function(V) {
                if (!M.defined(V)) {
                    return false
                }
                if (V.$J_TYPE) {
                    return V.$J_TYPE
                }
                if (!!V.nodeType) {
                    if (1 == V.nodeType) {
                        return "element"
                    }
                    if (3 == V.nodeType) {
                        return "textnode"
                    }
                }
                if (V.length && V.item) {
                    return "collection"
                }
                if (V.length && V.callee) {
                    return "arguments"
                }
                if ((V instanceof window.Object || V instanceof window.Function) && V.constructor === M.Class) {
                    return "class"
                }
                if (V instanceof window.Array) {
                    return "array"
                }
                if (V instanceof window.Function) {
                    return "function"
                }
                if (V instanceof window.String) {
                    return "string"
                }
                if (M.jBrowser.trident) {
                    if (M.defined(V.cancelBubble)) {
                        return "event"
                    }
                } else {
                    if (V === window.event || V.constructor == window.Event || V.constructor == window.MouseEvent || V.constructor == window.UIEvent || V.constructor == window.KeyboardEvent || V.constructor == window.KeyEvent) {
                        return "event"
                    }
                }
                if (V instanceof window.Date) {
                    return "date"
                }
                if (V instanceof window.RegExp) {
                    return "regexp"
                }
                if (V === window) {
                    return "window"
                }
                if (V === document) {
                    return "document"
                }
                return typeof(V)
            },
            extend: function(aa, Z) {
                if (!(aa instanceof window.Array)) {
                    aa = [aa]
                }
                if (!Z) {
                    return aa[0]
                }
                for (var Y = 0, W = aa.length; Y < W; Y++) {
                    if (!M.defined(aa)) {
                        continue
                    }
                    for (var X in Z) {
                        if (!Object.prototype.hasOwnProperty.call(Z, X)) {
                            continue
                        }
                        try {
                            aa[Y][X] = Z[X]
                        } catch (V) {}
                    }
                }
                return aa[0]
            },
            implement: function(Z, Y) {
                if (!(Z instanceof window.Array)) {
                    Z = [Z]
                }
                for (var X = 0, V = Z.length; X < V; X++) {
                    if (!M.defined(Z[X])) {
                        continue
                    }
                    if (!Z[X].prototype) {
                        continue
                    }
                    for (var W in (Y || {})) {
                        if (!Z[X].prototype[W]) {
                            Z[X].prototype[W] = Y[W]
                        }
                    }
                }
                return Z[0]
            },
            nativize: function(X, W) {
                if (!M.defined(X)) {
                    return X
                }
                for (var V in (W || {})) {
                    if (!X[V]) {
                        X[V] = W[V]
                    }
                }
                return X
            },
            $try: function() {
                for (var W = 0, V = arguments.length; W < V; W++) {
                    try {
                        return arguments[W]()
                    } catch (X) {}
                }
                return null
            },
            $A: function(X) {
                if (!M.defined(X)) {
                    return M.$([])
                }
                if (X.toArray) {
                    return M.$(X.toArray())
                }
                if (X.item) {
                    var W = X.length || 0,
                        V = new Array(W);
                    while (W--) {
                        V[W] = X[W]
                    }
                    return M.$(V)
                }
                return M.$(Array.prototype.slice.call(X))
            },
            now: function() {
                return new Date().getTime()
            },
            detach: function(Z) {
                var X;
                switch (M.jTypeOf(Z)) {
                    case "object":
                        X = {};
                        for (var Y in Z) {
                            X[Y] = M.detach(Z[Y])
                        }
                        break;
                    case "array":
                        X = [];
                        for (var W = 0, V = Z.length; W < V; W++) {
                            X[W] = M.detach(Z[W])
                        }
                        break;
                    default:
                        return Z
                }
                return M.$(X)
            },
            $: function(X) {
                var V = true;
                if (!M.defined(X)) {
                    return null
                }
                if (X.$J_EXT) {
                    return X
                }
                switch (M.jTypeOf(X)) {
                    case "array":
                        X = M.nativize(X, M.extend(M.Array, {
                            $J_EXT: M.$F
                        }));
                        X.jEach = X.forEach;
                        return X;
                        break;
                    case "string":
                        var W = document.getElementById(X);
                        if (M.defined(W)) {
                            return M.$(W)
                        }
                        return null;
                        break;
                    case "window":
                    case "document":
                        M.$uuid(X);
                        X = M.extend(X, M.Doc);
                        break;
                    case "element":
                        M.$uuid(X);
                        X = M.extend(X, M.Element);
                        break;
                    case "event":
                        X = M.extend(X, M.Event);
                        break;
                    case "textnode":
                    case "function":
                    case "array":
                    case "date":
                    default:
                        V = false;
                        break
                }
                if (V) {
                    return M.extend(X, {
                        $J_EXT: M.$F
                    })
                } else {
                    return X
                }
            },
            $new: function(V, X, W) {
                return M.$(M.doc.createElement(V)).setProps(X || {}).jSetCss(W || {})
            },
            addCSS: function(W, Y, ac) {
                var Z, X, aa, ab = [],
                    V = -1;
                ac || (ac = M.stylesId);
                Z = M.$(ac) || M.$new("style", {
                    id: ac,
                    type: "text/css"
                }).jAppendTo((document.head || document.body), "top");
                X = Z.sheet || Z.styleSheet;
                if ("string" != M.jTypeOf(Y)) {
                    for (var aa in Y) {
                        ab.push(aa + ":" + Y[aa])
                    }
                    Y = ab.join(";")
                }
                if (X.insertRule) {
                    V = X.insertRule(W + " {" + Y + "}", X.cssRules.length)
                } else {
                    V = X.addRule(W, Y)
                }
                return V
            },
            removeCSS: function(Y, V) {
                var X, W;
                X = M.$(Y);
                if ("element" !== M.jTypeOf(X)) {
                    return
                }
                W = X.sheet || X.styleSheet;
                if (W.deleteRule) {
                    W.deleteRule(V)
                } else {
                    if (W.removeRule) {
                        W.removeRule(V)
                    }
                }
            },
            generateUUID: function() {
                return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(X) {
                    var W = Math.random() * 16 | 0,
                        V = X == "x" ? W : (W & 3 | 8);
                    return V.toString(16)
                }).toUpperCase()
            },
            getAbsoluteURL: (function() {
                var V;
                return function(W) {
                    if (!V) {
                        V = document.createElement("a")
                    }
                    V.setAttribute("href", W);
                    return ("!!" + V.href).replace("!!", "")
                }
            })(),
            getHashCode: function(X) {
                var Y = 0,
                    V = X.length;
                for (var W = 0; W < V; ++W) {
                    Y = 31 * Y + X.charCodeAt(W);
                    Y %= 4294967296
                }
                return Y
            }
        };
        var M = S;
        var N = S.$;
        if (!window.magicJS) {
            window.magicJS = S;
            window.$mjs = S.$
        }
        M.Array = {
            $J_TYPE: "array",
            indexOf: function(Y, Z) {
                var V = this.length;
                for (var W = this.length, X = (Z < 0) ? Math.max(0, W + Z) : Z || 0; X < W; X++) {
                    if (this[X] === Y) {
                        return X
                    }
                }
                return -1
            },
            contains: function(V, W) {
                return this.indexOf(V, W) != -1
            },
            forEach: function(V, Y) {
                for (var X = 0, W = this.length; X < W; X++) {
                    if (X in this) {
                        V.call(Y, this[X], X, this)
                    }
                }
            },
            filter: function(V, aa) {
                var Z = [];
                for (var Y = 0, W = this.length; Y < W; Y++) {
                    if (Y in this) {
                        var X = this[Y];
                        if (V.call(aa, this[Y], Y, this)) {
                            Z.push(X)
                        }
                    }
                }
                return Z
            },
            map: function(V, Z) {
                var Y = [];
                for (var X = 0, W = this.length; X < W; X++) {
                    if (X in this) {
                        Y[X] = V.call(Z, this[X], X, this)
                    }
                }
                return Y
            }
        };
        M.implement(String, {
            $J_TYPE: "string",
            jTrim: function() {
                return this.replace(/^\s+|\s+$/g, "")
            },
            eq: function(V, W) {
                return (W || false) ? (this.toString() === V.toString()) : (this.toLowerCase().toString() === V.toLowerCase().toString())
            },
            jCamelize: function() {
                return this.replace(/-\D/g, function(V) {
                    return V.charAt(1).toUpperCase()
                })
            },
            dashize: function() {
                return this.replace(/[A-Z]/g, function(V) {
                    return ("-" + V.charAt(0).toLowerCase())
                })
            },
            jToInt: function(V) {
                return parseInt(this, V || 10)
            },
            toFloat: function() {
                return parseFloat(this)
            },
            jToBool: function() {
                return !this.replace(/true/i, "").jTrim()
            },
            has: function(W, V) {
                V = V || "";
                return (V + this + V).indexOf(V + W + V) > -1
            }
        });
        S.implement(Function, {
            $J_TYPE: "function",
            jBind: function() {
                var W = M.$A(arguments),
                    V = this,
                    X = W.shift();
                return function() {
                    return V.apply(X || null, W.concat(M.$A(arguments)))
                }
            },
            jBindAsEvent: function() {
                var W = M.$A(arguments),
                    V = this,
                    X = W.shift();
                return function(Y) {
                    return V.apply(X || null, M.$([Y || (M.jBrowser.ieMode ? window.event : null)]).concat(W))
                }
            },
            jDelay: function() {
                var W = M.$A(arguments),
                    V = this,
                    X = W.shift();
                return window.setTimeout(function() {
                    return V.apply(V, W)
                }, X || 0)
            },
            jDefer: function() {
                var W = M.$A(arguments),
                    V = this;
                return function() {
                    return V.jDelay.apply(V, W)
                }
            },
            interval: function() {
                var W = M.$A(arguments),
                    V = this,
                    X = W.shift();
                return window.setInterval(function() {
                    return V.apply(V, W)
                }, X || 0)
            }
        });
        var L = navigator.userAgent.toLowerCase(),
            K = L.match(/(webkit|gecko|trident|presto)\/(\d+\.?\d*)/i),
            P = L.match(/(edge|opr)\/(\d+\.?\d*)/i) || L.match(/(crios|chrome|safari|firefox|opera|opr)\/(\d+\.?\d*)/i),
            R = L.match(/version\/(\d+\.?\d*)/i),
            G = document.documentElement.style;

        function H(W) {
            var V = W.charAt(0).toUpperCase() + W.slice(1);
            return W in G || ("Webkit" + V) in G || ("Moz" + V) in G || ("ms" + V) in G || ("O" + V) in G
        }
        M.jBrowser = {
            features: {
                xpath: !!(document.evaluate),
                air: !!(window.runtime),
                query: !!(document.querySelector),
                fullScreen: !!(document.fullscreenEnabled || document.msFullscreenEnabled || document.exitFullscreen || document.cancelFullScreen || document.webkitexitFullscreen || document.webkitCancelFullScreen || document.mozCancelFullScreen || document.oCancelFullScreen || document.msCancelFullScreen),
                xhr2: !!(window.ProgressEvent) && !!(window.FormData) && (window.XMLHttpRequest && "withCredentials" in new XMLHttpRequest),
                transition: H("transition"),
                transform: H("transform"),
                perspective: H("perspective"),
                animation: H("animation"),
                requestAnimationFrame: false,
                multibackground: false,
                cssFilters: false,
                svg: (function() {
                    return document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1")
                })()
            },
            touchScreen: function() {
                return "ontouchstart" in window || (window.DocumentTouch && document instanceof DocumentTouch)
            }(),
            mobile: L.match(/(android|bb\d+|meego).+|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(jBrowser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/) ? true : false,
            engine: (K && K[1]) ? K[1].toLowerCase() : (window.opera) ? "presto" : !!(window.ActiveXObject) ? "trident" : (undefined !== document.getBoxObjectFor || null != window.mozInnerScreenY) ? "gecko" : (null !== window.WebKitPoint || !navigator.taintEnabled) ? "webkit" : "unknown",
            version: (K && K[2]) ? parseFloat(K[2]) : 0,
            uaName: (P && P[1]) ? P[1].toLowerCase() : "",
            uaVersion: (P && P[2]) ? parseFloat(P[2]) : 0,
            cssPrefix: "",
            cssDomPrefix: "",
            domPrefix: "",
            ieMode: 0,
            platform: L.match(/ip(?:ad|od|hone)/) ? "ios" : (L.match(/(?:webos|android)/) || navigator.platform.match(/mac|win|linux/i) || ["other"])[0].toLowerCase(),
            backCompat: document.compatMode && "backcompat" == document.compatMode.toLowerCase(),
            scrollbarsWidth: 0,
            getDoc: function() {
                return (document.compatMode && "backcompat" == document.compatMode.toLowerCase()) ? document.body : document.documentElement
            },
            requestAnimationFrame: window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || undefined,
            cancelAnimationFrame: window.cancelAnimationFrame || window.mozCancelAnimationFrame || window.mozCancelAnimationFrame || window.oCancelAnimationFrame || window.msCancelAnimationFrame || window.webkitCancelRequestAnimationFrame || undefined,
            ready: false,
            onready: function() {
                if (M.jBrowser.ready) {
                    return
                }
                var Y, X;
                M.jBrowser.ready = true;
                M.body = M.$(document.body);
                M.win = M.$(window);
                try {
                    var W = M.$new("div").jSetCss({
                        width: 100,
                        height: 100,
                        overflow: "scroll",
                        position: "absolute",
                        top: -9999
                    }).jAppendTo(document.body);
                    M.jBrowser.scrollbarsWidth = W.offsetWidth - W.clientWidth;
                    W.jRemove()
                } catch (V) {}
                try {
                    Y = M.$new("div");
                    X = Y.style;
                    X.cssText = "background:url(https://),url(https://),red url(https://)";
                    M.jBrowser.features.multibackground = (/(url\s*\(.*?){3}/).test(X.background);
                    X = null;
                    Y = null
                } catch (V) {}
                if (!M.jBrowser.cssTransformProp) {
                    M.jBrowser.cssTransformProp = M.normalizeCSS("transform").dashize()
                }
                try {
                    Y = M.$new("div");
                    Y.style.cssText = M.normalizeCSS("filter").dashize() + ":blur(2px);";
                    M.jBrowser.features.cssFilters = !!Y.style.length && (!M.jBrowser.ieMode || M.jBrowser.ieMode > 9);
                    Y = null
                } catch (V) {}
                if (!M.jBrowser.features.cssFilters) {
                    M.$(document.documentElement).jAddClass("no-cssfilters-magic")
                }
                M.Doc.jCallEvent.call(M.$(document), "domready")
            }
        };
        (function() {
            var Z = [],
                Y, X, W;

            function V() {
                return !!(arguments.callee.caller)
            }
            switch (M.jBrowser.engine) {
                case "trident":
                    if (!M.jBrowser.version) {
                        M.jBrowser.version = !!(window.XMLHttpRequest) ? 3 : 2
                    }
                    break;
                case "gecko":
                    M.jBrowser.version = (P && P[2]) ? parseFloat(P[2]) : 0;
                    break
            }
            M.jBrowser[M.jBrowser.engine] = true;
            if (P && "crios" === P[1]) {
                M.jBrowser.uaName = "chrome"
            }
            if (!!window.chrome) {
                M.jBrowser.chrome = true
            }
            if (P && "opr" === P[1]) {
                M.jBrowser.uaName = "opera";
                M.jBrowser.opera = true
            }
            if ("safari" === M.jBrowser.uaName && (R && R[1])) {
                M.jBrowser.uaVersion = parseFloat(R[1])
            }
            Y = ({
                gecko: ["-moz-", "Moz", "moz"],
                webkit: ["-webkit-", "Webkit", "webkit"],
                trident: ["-ms-", "ms", "ms"],
                presto: ["-o-", "O", "o"]
            })[M.jBrowser.engine] || ["", "", ""];
            M.jBrowser.cssPrefix = Y[0];
            M.jBrowser.cssDomPrefix = Y[1];
            M.jBrowser.domPrefix = Y[2];
            M.jBrowser.ieMode = (!M.jBrowser.trident) ? undefined : (document.documentMode) ? document.documentMode : function() {
                var aa = 0;
                if (M.jBrowser.backCompat) {
                    return 5
                }
                switch (M.jBrowser.version) {
                    case 2:
                        aa = 6;
                        break;
                    case 3:
                        aa = 7;
                        break
                }
                return aa
            }();
            if (M.jBrowser.mobile) {
                Z.push("mobile-magic")
            }
            if (M.jBrowser.ieMode) {
                M.jBrowser.uaName = "ie";
                M.jBrowser.uaVersion = M.jBrowser.ieMode;
                Z.push("ie" + M.jBrowser.ieMode + "-magic");
                for (X = 11; X > M.jBrowser.ieMode; X--) {
                    Z.push("lt-ie" + X + "-magic")
                }
            }
            if (M.jBrowser.webkit && M.jBrowser.version < 536) {
                M.jBrowser.features.fullScreen = false
            }
            if (M.jBrowser.requestAnimationFrame) {
                M.jBrowser.requestAnimationFrame.call(window, function() {
                    M.jBrowser.features.requestAnimationFrame = true
                })
            }
            if (M.jBrowser.features.svg) {
                Z.push("svg-magic")
            } else {
                Z.push("no-svg-magic")
            }
            W = (document.documentElement.className || "").match(/\S+/g) || [];
            document.documentElement.className = M.$(W).concat(Z).join(" ");
            if (M.jBrowser.ieMode && M.jBrowser.ieMode < 9) {
                document.createElement("figure");
                document.createElement("figcaption")
            }
        })();
        (function() {
            M.jBrowser.fullScreen = {
                capable: M.jBrowser.features.fullScreen,
                enabled: function() {
                    return !!(document.fullscreenElement || document[M.jBrowser.domPrefix + "FullscreenElement"] || document.fullScreen || document.webkitIsFullScreen || document[M.jBrowser.domPrefix + "FullScreen"])
                },
                request: function(V, W) {
                    W || (W = {});
                    if (this.capable) {
                        M.$(document).jAddEvent(this.changeEventName, this.onchange = function(X) {
                            if (this.enabled()) {
                                W.onEnter && W.onEnter()
                            } else {
                                M.$(document).jRemoveEvent(this.changeEventName, this.onchange);
                                W.onExit && W.onExit()
                            }
                        }.jBindAsEvent(this));
                        M.$(document).jAddEvent(this.errorEventName, this.onerror = function(X) {
                            W.fallback && W.fallback();
                            M.$(document).jRemoveEvent(this.errorEventName, this.onerror)
                        }.jBindAsEvent(this));
                        (V[M.jBrowser.domPrefix + "RequestFullscreen"] || V[M.jBrowser.domPrefix + "RequestFullScreen"] || V.requestFullscreen || function() {}).call(V)
                    } else {
                        if (W.fallback) {
                            W.fallback()
                        }
                    }
                },
                cancel: (document.exitFullscreen || document.cancelFullScreen || document[M.jBrowser.domPrefix + "ExitFullscreen"] || document[M.jBrowser.domPrefix + "CancelFullScreen"] || function() {}).jBind(document),
                changeEventName: document.msExitFullscreen ? "MSFullscreenChange" : (document.exitFullscreen ? "" : M.jBrowser.domPrefix) + "fullscreenchange",
                errorEventName: document.msExitFullscreen ? "MSFullscreenError" : (document.exitFullscreen ? "" : M.jBrowser.domPrefix) + "fullscreenerror",
                prefix: M.jBrowser.domPrefix,
                activeElement: null
            }
        })();
        var U = /\S+/g,
            J = /^(border(Top|Bottom|Left|Right)Width)|((padding|margin)(Top|Bottom|Left|Right))$/,
            O = {
                "float": ("undefined" === typeof(G.styleFloat)) ? "cssFloat" : "styleFloat"
            },
            Q = {
                fontWeight: true,
                lineHeight: true,
                opacity: true,
                zIndex: true,
                zoom: true
            },
            I = (window.getComputedStyle) ? function(X, V) {
                var W = window.getComputedStyle(X, null);
                return W ? W.getPropertyValue(V) || W[V] : null
            } : function(Y, W) {
                var X = Y.currentStyle,
                    V = null;
                V = X ? X[W] : null;
                if (null == V && Y.style && Y.style[W]) {
                    V = Y.style[W]
                }
                return V
            };

        function T(X) {
            var V, W;
            W = (M.jBrowser.webkit && "filter" == X) ? false : (X in G);
            if (!W) {
                V = M.jBrowser.cssDomPrefix + X.charAt(0).toUpperCase() + X.slice(1);
                if (V in G) {
                    return V
                }
            }
            return X
        }
        M.normalizeCSS = T;
        M.Element = {
            jHasClass: function(V) {
                return !(V || "").has(" ") && (this.className || "").has(V, " ")
            },
            jAddClass: function(Z) {
                var W = (this.className || "").match(U) || [],
                    Y = (Z || "").match(U) || [],
                    V = Y.length,
                    X = 0;
                for (; X < V; X++) {
                    if (!M.$(W).contains(Y[X])) {
                        W.push(Y[X])
                    }
                }
                this.className = W.join(" ");
                return this
            },
            jRemoveClass: function(aa) {
                var W = (this.className || "").match(U) || [],
                    Z = (aa || "").match(U) || [],
                    V = Z.length,
                    Y = 0,
                    X;
                for (; Y < V; Y++) {
                    if ((X = M.$(W).indexOf(Z[Y])) > -1) {
                        W.splice(X, 1)
                    }
                }
                this.className = aa ? W.join(" ") : "";
                return this
            },
            jToggleClass: function(V) {
                return this.jHasClass(V) ? this.jRemoveClass(V) : this.jAddClass(V)
            },
            jGetCss: function(W) {
                var X = W.jCamelize(),
                    V = null;
                W = O[X] || (O[X] = T(X));
                V = I(this, W);
                if ("auto" === V) {
                    V = null
                }
                if (null !== V) {
                    if ("opacity" == W) {
                        return M.defined(V) ? parseFloat(V) : 1
                    }
                    if (J.test(W)) {
                        V = parseInt(V, 10) ? V : "0px"
                    }
                }
                return V
            },
            jSetCssProp: function(W, V) {
                var Y = W.jCamelize();
                try {
                    if ("opacity" == W) {
                        this.jSetOpacity(V);
                        return this
                    }
                    W = O[Y] || (O[Y] = T(Y));
                    this.style[W] = V + (("number" == M.jTypeOf(V) && !Q[Y]) ? "px" : "")
                } catch (X) {}
                return this
            },
            jSetCss: function(W) {
                for (var V in W) {
                    this.jSetCssProp(V, W[V])
                }
                return this
            },
            jGetStyles: function() {
                var V = {};
                M.$A(arguments).jEach(function(W) {
                    V[W] = this.jGetCss(W)
                }, this);
                return V
            },
            jSetOpacity: function(X, V) {
                var W;
                V = V || false;
                this.style.opacity = X;
                X = parseInt(parseFloat(X) * 100);
                if (V) {
                    if (0 === X) {
                        if ("hidden" != this.style.visibility) {
                            this.style.visibility = "hidden"
                        }
                    } else {
                        if ("visible" != this.style.visibility) {
                            this.style.visibility = "visible"
                        }
                    }
                }
                if (M.jBrowser.ieMode && M.jBrowser.ieMode < 9) {
                    if (!isNaN(X)) {
                        if (!~this.style.filter.indexOf("Alpha")) {
                            this.style.filter += " progid:DXImageTransform.Microsoft.Alpha(Opacity=" + X + ")"
                        } else {
                            this.style.filter = this.style.filter.replace(/Opacity=\d*/i, "Opacity=" + X)
                        }
                    } else {
                        this.style.filter = this.style.filter.replace(/progid:DXImageTransform.Microsoft.Alpha\(Opacity=\d*\)/i, "").jTrim();
                        if ("" === this.style.filter) {
                            this.style.removeAttribute("filter")
                        }
                    }
                }
                return this
            },
            setProps: function(V) {
                for (var W in V) {
                    if ("class" === W) {
                        this.jAddClass("" + V[W])
                    } else {
                        this.setAttribute(W, "" + V[W])
                    }
                }
                return this
            },
            hide: function() {
                return this.jSetCss({
                    display: "none",
                    visibility: "hidden"
                })
            },
            show: function() {
                return this.jSetCss({
                    display: "",
                    visibility: "visible"
                })
            },
            jGetSize: function() {
                return {
                    width: this.offsetWidth,
                    height: this.offsetHeight
                }
            },
            getInnerSize: function(W) {
                var V = this.jGetSize();
                V.width -= (parseFloat(this.jGetCss("border-left-width") || 0) + parseFloat(this.jGetCss("border-right-width") || 0));
                V.height -= (parseFloat(this.jGetCss("border-top-width") || 0) + parseFloat(this.jGetCss("border-bottom-width") || 0));
                if (!W) {
                    V.width -= (parseFloat(this.jGetCss("padding-left") || 0) + parseFloat(this.jGetCss("padding-right") || 0));
                    V.height -= (parseFloat(this.jGetCss("padding-top") || 0) + parseFloat(this.jGetCss("padding-bottom") || 0))
                }
                return V
            },
            jGetScroll: function() {
                return {
                    top: this.scrollTop,
                    left: this.scrollLeft
                }
            },
            jGetFullScroll: function() {
                var V = this,
                    W = {
                        top: 0,
                        left: 0
                    };
                do {
                    W.left += V.scrollLeft || 0;
                    W.top += V.scrollTop || 0;
                    V = V.parentNode
                } while (V);
                return W
            },
            jGetPosition: function() {
                var Z = this,
                    W = 0,
                    Y = 0;
                if (M.defined(document.documentElement.getBoundingClientRect)) {
                    var V = this.getBoundingClientRect(),
                        X = M.$(document).jGetScroll(),
                        aa = M.jBrowser.getDoc();
                    return {
                        top: V.top + X.y - aa.clientTop,
                        left: V.left + X.x - aa.clientLeft
                    }
                }
                do {
                    W += Z.offsetLeft || 0;
                    Y += Z.offsetTop || 0;
                    Z = Z.offsetParent
                } while (Z && !(/^(?:body|html)$/i).test(Z.tagName));
                return {
                    top: Y,
                    left: W
                }
            },
            jGetRect: function() {
                var W = this.jGetPosition();
                var V = this.jGetSize();
                return {
                    top: W.top,
                    bottom: W.top + V.height,
                    left: W.left,
                    right: W.left + V.width
                }
            },
            changeContent: function(W) {
                try {
                    this.innerHTML = W
                } catch (V) {
                    this.innerText = W
                }
                return this
            },
            jRemove: function() {
                return (this.parentNode) ? this.parentNode.removeChild(this) : this
            },
            kill: function() {
                M.$A(this.childNodes).jEach(function(V) {
                    if (3 == V.nodeType || 8 == V.nodeType) {
                        return
                    }
                    M.$(V).kill()
                });
                this.jRemove();
                this.jClearEvents();
                if (this.$J_UUID) {
                    M.storage[this.$J_UUID] = null;
                    delete M.storage[this.$J_UUID]
                }
                return null
            },
            append: function(X, W) {
                W = W || "bottom";
                var V = this.firstChild;
                ("top" == W && V) ? this.insertBefore(X, V): this.appendChild(X);
                return this
            },
            jAppendTo: function(X, W) {
                var V = M.$(X).append(this, W);
                return this
            },
            enclose: function(V) {
                this.append(V.parentNode.replaceChild(this, V));
                return this
            },
            hasChild: function(V) {
                if ("element" !== M.jTypeOf("string" == M.jTypeOf(V) ? V = document.getElementById(V) : V)) {
                    return false
                }
                return (this == V) ? false : (this.contains && !(M.jBrowser.webkit419)) ? (this.contains(V)) : (this.compareDocumentPosition) ? !!(this.compareDocumentPosition(V) & 16) : M.$A(this.byTag(V.tagName)).contains(V)
            }
        };
        M.Element.jGetStyle = M.Element.jGetCss;
        M.Element.jSetStyle = M.Element.jSetCss;
        if (!window.Element) {
            window.Element = M.$F;
            if (M.jBrowser.engine.webkit) {
                window.document.createElement("iframe")
            }
            window.Element.prototype = (M.jBrowser.engine.webkit) ? window["[[DOMElement.prototype]]"] : {}
        }
        M.implement(window.Element, {
            $J_TYPE: "element"
        });
        M.Doc = {
            jGetSize: function() {
                if (M.jBrowser.touchScreen || M.jBrowser.presto925 || M.jBrowser.webkit419) {
                    return {
                        width: window.innerWidth,
                        height: window.innerHeight
                    }
                }
                return {
                    width: M.jBrowser.getDoc().clientWidth,
                    height: M.jBrowser.getDoc().clientHeight
                }
            },
            jGetScroll: function() {
                return {
                    x: window.pageXOffset || M.jBrowser.getDoc().scrollLeft,
                    y: window.pageYOffset || M.jBrowser.getDoc().scrollTop
                }
            },
            jGetFullSize: function() {
                var V = this.jGetSize();
                return {
                    width: Math.max(M.jBrowser.getDoc().scrollWidth, V.width),
                    height: Math.max(M.jBrowser.getDoc().scrollHeight, V.height)
                }
            }
        };
        M.extend(document, {
            $J_TYPE: "document"
        });
        M.extend(window, {
            $J_TYPE: "window"
        });
        M.extend([M.Element, M.Doc], {
            jFetch: function(Y, W) {
                var V = M.getStorage(this.$J_UUID),
                    X = V[Y];
                if (undefined !== W && undefined === X) {
                    X = V[Y] = W
                }
                return (M.defined(X) ? X : null)
            },
            jStore: function(X, W) {
                var V = M.getStorage(this.$J_UUID);
                V[X] = W;
                return this
            },
            jDel: function(W) {
                var V = M.getStorage(this.$J_UUID);
                delete V[W];
                return this
            }
        });
        if (!(window.HTMLElement && window.HTMLElement.prototype && window.HTMLElement.prototype.getElementsByClassName)) {
            M.extend([M.Element, M.Doc], {
                getElementsByClassName: function(V) {
                    return M.$A(this.getElementsByTagName("*")).filter(function(X) {
                        try {
                            return (1 == X.nodeType && X.className.has(V, " "))
                        } catch (W) {}
                    })
                }
            })
        }
        M.extend([M.Element, M.Doc], {
            byClass: function() {
                return this.getElementsByClassName(arguments[0])
            },
            byTag: function() {
                return this.getElementsByTagName(arguments[0])
            }
        });
        if (M.jBrowser.fullScreen.capable && !document.requestFullScreen) {
            M.Element.requestFullScreen = function() {
                M.jBrowser.fullScreen.request(this)
            }
        }
        M.Event = {
            $J_TYPE: "event",
            isQueueStopped: M.$false,
            stop: function() {
                return this.stopDistribution().stopDefaults()
            },
            stopDistribution: function() {
                if (this.stopPropagation) {
                    this.stopPropagation()
                } else {
                    this.cancelBubble = true
                }
                return this
            },
            stopDefaults: function() {
                if (this.preventDefault) {
                    this.preventDefault()
                } else {
                    this.returnValue = false
                }
                return this
            },
            stopQueue: function() {
                this.isQueueStopped = M.$true;
                return this
            },
            getClientXY: function() {
                var W, V;
                W = ((/touch/i).test(this.type)) ? this.changedTouches[0] : this;
                return (!M.defined(W)) ? {
                    x: 0,
                    y: 0
                } : {
                    x: W.clientX,
                    y: W.clientY
                }
            },
            jGetPageXY: function() {
                var W, V;
                W = ((/touch/i).test(this.type)) ? this.changedTouches[0] : this;
                return (!M.defined(W)) ? {
                    x: 0,
                    y: 0
                } : {
                    x: W.pageX || W.clientX + M.jBrowser.getDoc().scrollLeft,
                    y: W.pageY || W.clientY + M.jBrowser.getDoc().scrollTop
                }
            },
            getTarget: function() {
                var V = this.target || this.srcElement;
                while (V && 3 == V.nodeType) {
                    V = V.parentNode
                }
                return V
            },
            getRelated: function() {
                var W = null;
                switch (this.type) {
                    case "mouseover":
                    case "pointerover":
                    case "MSPointerOver":
                        W = this.relatedTarget || this.fromElement;
                        break;
                    case "mouseout":
                    case "pointerout":
                    case "MSPointerOut":
                        W = this.relatedTarget || this.toElement;
                        break;
                    default:
                        return W
                }
                try {
                    while (W && 3 == W.nodeType) {
                        W = W.parentNode
                    }
                } catch (V) {
                    W = null
                }
                return W
            },
            getButton: function() {
                if (!this.which && this.button !== undefined) {
                    return (this.button & 1 ? 1 : (this.button & 2 ? 3 : (this.button & 4 ? 2 : 0)))
                }
                return this.which
            },
            isTouchEvent: function() {
                return (this.pointerType && ("touch" === this.pointerType || this.pointerType === this.MSPOINTER_TYPE_TOUCH)) || (/touch/i).test(this.type)
            },
            isPrimaryTouch: function() {
                return this.pointerType ? (("touch" === this.pointerType || this.MSPOINTER_TYPE_TOUCH === this.pointerType) && this.isPrimary) : 1 === this.changedTouches.length && (this.targetTouches.length ? this.targetTouches[0].identifier == this.changedTouches[0].identifier : true)
            }
        };
        M._event_add_ = "addEventListener";
        M._event_del_ = "removeEventListener";
        M._event_prefix_ = "";
        if (!document.addEventListener) {
            M._event_add_ = "attachEvent";
            M._event_del_ = "detachEvent";
            M._event_prefix_ = "on"
        }
        M.Event.Custom = {
            type: "",
            x: null,
            y: null,
            timeStamp: null,
            button: null,
            target: null,
            relatedTarget: null,
            $J_TYPE: "event.custom",
            isQueueStopped: M.$false,
            events: M.$([]),
            pushToEvents: function(V) {
                var W = V;
                this.events.push(W)
            },
            stop: function() {
                return this.stopDistribution().stopDefaults()
            },
            stopDistribution: function() {
                this.events.jEach(function(W) {
                    try {
                        W.stopDistribution()
                    } catch (V) {}
                });
                return this
            },
            stopDefaults: function() {
                this.events.jEach(function(W) {
                    try {
                        W.stopDefaults()
                    } catch (V) {}
                });
                return this
            },
            stopQueue: function() {
                this.isQueueStopped = M.$true;
                return this
            },
            getClientXY: function() {
                return {
                    x: this.clientX,
                    y: this.clientY
                }
            },
            jGetPageXY: function() {
                return {
                    x: this.x,
                    y: this.y
                }
            },
            getTarget: function() {
                return this.target
            },
            getRelated: function() {
                return this.relatedTarget
            },
            getButton: function() {
                return this.button
            },
            getOriginalTarget: function() {
                return this.events.length > 0 ? this.events[0].getTarget() : undefined
            }
        };
        M.extend([M.Element, M.Doc], {
            jAddEvent: function(X, Z, aa, ad) {
                var ac, V, Y, ab, W;
                if ("string" == M.jTypeOf(X)) {
                    W = X.split(" ");
                    if (W.length > 1) {
                        X = W
                    }
                }
                if (M.jTypeOf(X) == "array") {
                    M.$(X).jEach(this.jAddEvent.jBindAsEvent(this, Z, aa, ad));
                    return this
                }
                if (!X || !Z || M.jTypeOf(X) != "string" || M.jTypeOf(Z) != "function") {
                    return this
                }
                if (X == "domready" && M.jBrowser.ready) {
                    Z.call(this);
                    return this
                }
                aa = parseInt(aa || 50);
                if (!Z.$J_EUID) {
                    Z.$J_EUID = Math.floor(Math.random() * M.now())
                }
                ac = M.Doc.jFetch.call(this, "_EVENTS_", {});
                V = ac[X];
                if (!V) {
                    ac[X] = V = M.$([]);
                    Y = this;
                    if (M.Event.Custom[X]) {
                        M.Event.Custom[X].handler.add.call(this, ad)
                    } else {
                        V.handle = function(ae) {
                            ae = M.extend(ae || window.e, {
                                $J_TYPE: "event"
                            });
                            M.Doc.jCallEvent.call(Y, X, M.$(ae))
                        };
                        this[M._event_add_](M._event_prefix_ + X, V.handle, false)
                    }
                }
                ab = {
                    type: X,
                    fn: Z,
                    priority: aa,
                    euid: Z.$J_EUID
                };
                V.push(ab);
                V.sort(function(af, ae) {
                    return af.priority - ae.priority
                });
                return this
            },
            jRemoveEvent: function(ab) {
                var Z = M.Doc.jFetch.call(this, "_EVENTS_", {}),
                    X, V, W, ac, aa, Y;
                aa = arguments.length > 1 ? arguments[1] : -100;
                if ("string" == M.jTypeOf(ab)) {
                    Y = ab.split(" ");
                    if (Y.length > 1) {
                        ab = Y
                    }
                }
                if (M.jTypeOf(ab) == "array") {
                    M.$(ab).jEach(this.jRemoveEvent.jBindAsEvent(this, aa));
                    return this
                }
                if (!ab || M.jTypeOf(ab) != "string" || !Z || !Z[ab]) {
                    return this
                }
                X = Z[ab] || [];
                for (W = 0; W < X.length; W++) {
                    V = X[W];
                    if (-100 == aa || !!aa && aa.$J_EUID === V.euid) {
                        ac = X.splice(W--, 1)
                    }
                }
                if (0 === X.length) {
                    if (M.Event.Custom[ab]) {
                        M.Event.Custom[ab].handler.jRemove.call(this)
                    } else {
                        this[M._event_del_](M._event_prefix_ + ab, X.handle, false)
                    }
                    delete Z[ab]
                }
                return this
            },
            jCallEvent: function(Z, ab) {
                var Y = M.Doc.jFetch.call(this, "_EVENTS_", {}),
                    X, V, W;
                if (!Z || M.jTypeOf(Z) != "string" || !Y || !Y[Z]) {
                    return this
                }
                try {
                    ab = M.extend(ab || {}, {
                        type: Z
                    })
                } catch (aa) {}
                if (undefined === ab.timeStamp) {
                    ab.timeStamp = M.now()
                }
                X = Y[Z] || [];
                for (W = 0; W < X.length && !(ab.isQueueStopped && ab.isQueueStopped()); W++) {
                    X[W].fn.call(this, ab)
                }
            },
            jRaiseEvent: function(W, V) {
                var Z = ("domready" == W) ? false : true,
                    Y = this,
                    X;
                if (!Z) {
                    M.Doc.jCallEvent.call(this, W);
                    return this
                }
                if (Y === document && document.createEvent && !Y.dispatchEvent) {
                    Y = document.documentElement
                }
                if (document.createEvent) {
                    X = document.createEvent(W);
                    X.initEvent(V, true, true)
                } else {
                    X = document.createEventObject();
                    X.eventType = W
                }
                if (document.createEvent) {
                    Y.dispatchEvent(X)
                } else {
                    Y.fireEvent("on" + V, X)
                }
                return X
            },
            jClearEvents: function() {
                var W = M.Doc.jFetch.call(this, "_EVENTS_");
                if (!W) {
                    return this
                }
                for (var V in W) {
                    M.Doc.jRemoveEvent.call(this, V)
                }
                M.Doc.jDel.call(this, "_EVENTS_");
                return this
            }
        });
        (function(V) {
            if ("complete" === document.readyState) {
                return V.jBrowser.onready.jDelay(1)
            }
            if (V.jBrowser.webkit && V.jBrowser.version < 420) {
                (function() {
                    (V.$(["loaded", "complete"]).contains(document.readyState)) ? V.jBrowser.onready(): arguments.callee.jDelay(50)
                })()
            } else {
                if (V.jBrowser.trident && V.jBrowser.ieMode < 9 && window == top) {
                    (function() {
                        (V.$try(function() {
                            V.jBrowser.getDoc().doScroll("left");
                            return true
                        })) ? V.jBrowser.onready(): arguments.callee.jDelay(50)
                    })()
                } else {
                    V.Doc.jAddEvent.call(V.$(document), "DOMContentLoaded", V.jBrowser.onready);
                    V.Doc.jAddEvent.call(V.$(window), "load", V.jBrowser.onready)
                }
            }
        })(S);
        M.Class = function() {
            var Z = null,
                W = M.$A(arguments);
            if ("class" == M.jTypeOf(W[0])) {
                Z = W.shift()
            }
            var V = function() {
                for (var ac in this) {
                    this[ac] = M.detach(this[ac])
                }
                if (this.constructor.$parent) {
                    this.$parent = {};
                    var ae = this.constructor.$parent;
                    for (var ad in ae) {
                        var ab = ae[ad];
                        switch (M.jTypeOf(ab)) {
                            case "function":
                                this.$parent[ad] = M.Class.wrap(this, ab);
                                break;
                            case "object":
                                this.$parent[ad] = M.detach(ab);
                                break;
                            case "array":
                                this.$parent[ad] = M.detach(ab);
                                break
                        }
                    }
                }
                var aa = (this.init) ? this.init.apply(this, arguments) : this;
                delete this.caller;
                return aa
            };
            if (!V.prototype.init) {
                V.prototype.init = M.$F
            }
            if (Z) {
                var Y = function() {};
                Y.prototype = Z.prototype;
                V.prototype = new Y;
                V.$parent = {};
                for (var X in Z.prototype) {
                    V.$parent[X] = Z.prototype[X]
                }
            } else {
                V.$parent = null
            }
            V.constructor = M.Class;
            V.prototype.constructor = V;
            M.extend(V.prototype, W[0]);
            M.extend(V, {
                $J_TYPE: "class"
            });
            return V
        };
        S.Class.wrap = function(V, W) {
            return function() {
                var Y = this.caller;
                var X = W.apply(V, arguments);
                return X
            }
        };
        M.Event.Custom.btnclick = new M.Class(M.extend(M.Event.Custom, {
            type: "btnclick",
            init: function(X, W) {
                var V = W.jGetPageXY();
                this.x = V.x;
                this.y = V.y;
                this.clientX = W.clientX;
                this.clientY = W.clientY;
                this.timeStamp = W.timeStamp;
                this.button = W.getButton();
                this.target = X;
                this.pushToEvents(W)
            }
        }));
        M.Event.Custom.btnclick.handler = {
            options: {
                threshold: 200,
                button: 1
            },
            add: function(V) {
                this.jStore("event:btnclick:options", M.extend(M.detach(M.Event.Custom.btnclick.handler.options), V || {}));
                this.jAddEvent("mousedown", M.Event.Custom.btnclick.handler.handle, 1);
                this.jAddEvent("mouseup", M.Event.Custom.btnclick.handler.handle, 1);
                this.jAddEvent("click", M.Event.Custom.btnclick.handler.onclick, 1);
                if (M.jBrowser.trident && M.jBrowser.ieMode < 9) {
                    this.jAddEvent("dblclick", M.Event.Custom.btnclick.handler.handle, 1)
                }
            },
            jRemove: function() {
                this.jRemoveEvent("mousedown", M.Event.Custom.btnclick.handler.handle);
                this.jRemoveEvent("mouseup", M.Event.Custom.btnclick.handler.handle);
                this.jRemoveEvent("click", M.Event.Custom.btnclick.handler.onclick);
                if (M.jBrowser.trident && M.jBrowser.ieMode < 9) {
                    this.jRemoveEvent("dblclick", M.Event.Custom.btnclick.handler.handle)
                }
            },
            onclick: function(V) {
                V.stopDefaults()
            },
            handle: function(Y) {
                var X, V, W;
                V = this.jFetch("event:btnclick:options");
                if (Y.type != "dblclick" && Y.getButton() != V.button) {
                    return
                }
                if (this.jFetch("event:btnclick:ignore")) {
                    this.jDel("event:btnclick:ignore");
                    return
                }
                if ("mousedown" == Y.type) {
                    X = new M.Event.Custom.btnclick(this, Y);
                    this.jStore("event:btnclick:btnclickEvent", X)
                } else {
                    if ("mouseup" == Y.type) {
                        X = this.jFetch("event:btnclick:btnclickEvent");
                        if (!X) {
                            return
                        }
                        W = Y.jGetPageXY();
                        this.jDel("event:btnclick:btnclickEvent");
                        X.pushToEvents(Y);
                        if (Y.timeStamp - X.timeStamp <= V.threshold && X.x == W.x && X.y == W.y) {
                            this.jCallEvent("btnclick", X)
                        }
                        document.jCallEvent("mouseup", Y)
                    } else {
                        if (Y.type == "dblclick") {
                            X = new M.Event.Custom.btnclick(this, Y);
                            this.jCallEvent("btnclick", X)
                        }
                    }
                }
            }
        };
        (function(W) {
            var V = W.$;
            W.Event.Custom.mousedrag = new W.Class(W.extend(W.Event.Custom, {
                type: "mousedrag",
                state: "dragstart",
                dragged: false,
                init: function(aa, Z, Y) {
                    var X = Z.jGetPageXY();
                    this.x = X.x;
                    this.y = X.y;
                    this.clientX = Z.clientX;
                    this.clientY = Z.clientY;
                    this.timeStamp = Z.timeStamp;
                    this.button = Z.getButton();
                    this.target = aa;
                    this.pushToEvents(Z);
                    this.state = Y
                }
            }));
            W.Event.Custom.mousedrag.handler = {
                add: function() {
                    var Y = W.Event.Custom.mousedrag.handler.handleMouseMove.jBindAsEvent(this),
                        X = W.Event.Custom.mousedrag.handler.handleMouseUp.jBindAsEvent(this);
                    this.jAddEvent("mousedown", W.Event.Custom.mousedrag.handler.handleMouseDown, 1);
                    this.jAddEvent("mouseup", W.Event.Custom.mousedrag.handler.handleMouseUp, 1);
                    document.jAddEvent("mousemove", Y, 1);
                    document.jAddEvent("mouseup", X, 1);
                    this.jStore("event:mousedrag:listeners:document:move", Y);
                    this.jStore("event:mousedrag:listeners:document:end", X)
                },
                jRemove: function() {
                    this.jRemoveEvent("mousedown", W.Event.Custom.mousedrag.handler.handleMouseDown);
                    this.jRemoveEvent("mouseup", W.Event.Custom.mousedrag.handler.handleMouseUp);
                    V(document).jRemoveEvent("mousemove", this.jFetch("event:mousedrag:listeners:document:move") || W.$F);
                    V(document).jRemoveEvent("mouseup", this.jFetch("event:mousedrag:listeners:document:end") || W.$F);
                    this.jDel("event:mousedrag:listeners:document:move");
                    this.jDel("event:mousedrag:listeners:document:end")
                },
                handleMouseDown: function(Y) {
                    var X;
                    if (1 != Y.getButton()) {
                        return
                    }
                    Y.stopDefaults();
                    X = new W.Event.Custom.mousedrag(this, Y, "dragstart");
                    this.jStore("event:mousedrag:dragstart", X)
                },
                handleMouseUp: function(Y) {
                    var X;
                    X = this.jFetch("event:mousedrag:dragstart");
                    if (!X) {
                        return
                    }
                    Y.stopDefaults();
                    X = new W.Event.Custom.mousedrag(this, Y, "dragend");
                    this.jDel("event:mousedrag:dragstart");
                    this.jCallEvent("mousedrag", X)
                },
                handleMouseMove: function(Y) {
                    var X;
                    X = this.jFetch("event:mousedrag:dragstart");
                    if (!X) {
                        return
                    }
                    Y.stopDefaults();
                    if (!X.dragged) {
                        X.dragged = true;
                        this.jCallEvent("mousedrag", X)
                    }
                    X = new W.Event.Custom.mousedrag(this, Y, "dragmove");
                    this.jCallEvent("mousedrag", X)
                }
            }
        })(S);
        M.Event.Custom.dblbtnclick = new M.Class(M.extend(M.Event.Custom, {
            type: "dblbtnclick",
            timedout: false,
            tm: null,
            init: function(X, W) {
                var V = W.jGetPageXY();
                this.x = V.x;
                this.y = V.y;
                this.clientX = W.clientX;
                this.clientY = W.clientY;
                this.timeStamp = W.timeStamp;
                this.button = W.getButton();
                this.target = X;
                this.pushToEvents(W)
            }
        }));
        M.Event.Custom.dblbtnclick.handler = {
            options: {
                threshold: 200
            },
            add: function(V) {
                this.jStore("event:dblbtnclick:options", M.extend(M.detach(M.Event.Custom.dblbtnclick.handler.options), V || {}));
                this.jAddEvent("btnclick", M.Event.Custom.dblbtnclick.handler.handle, 1)
            },
            jRemove: function() {
                this.jRemoveEvent("btnclick", M.Event.Custom.dblbtnclick.handler.handle)
            },
            handle: function(X) {
                var W, V;
                W = this.jFetch("event:dblbtnclick:event");
                V = this.jFetch("event:dblbtnclick:options");
                if (!W) {
                    W = new M.Event.Custom.dblbtnclick(this, X);
                    W.tm = setTimeout(function() {
                        W.timedout = true;
                        X.isQueueStopped = M.$false;
                        this.jCallEvent("btnclick", X);
                        this.jDel("event:dblbtnclick:event")
                    }.jBind(this), V.threshold + 10);
                    this.jStore("event:dblbtnclick:event", W);
                    X.stopQueue()
                } else {
                    clearTimeout(W.tm);
                    this.jDel("event:dblbtnclick:event");
                    if (!W.timedout) {
                        W.pushToEvents(X);
                        X.stopQueue().stop();
                        this.jCallEvent("dblbtnclick", W)
                    } else {}
                }
            }
        };
        (function(ab) {
            var aa = ab.$;

            function V(ac) {
                return ac.pointerType ? (("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) && ac.isPrimary) : 1 === ac.changedTouches.length && (ac.targetTouches.length ? ac.targetTouches[0].identifier == ac.changedTouches[0].identifier : true)
            }

            function X(ac) {
                if (ac.pointerType) {
                    return ("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) ? ac.pointerId : null
                } else {
                    return ac.changedTouches[0].identifier
                }
            }

            function Y(ac) {
                if (ac.pointerType) {
                    return ("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) ? ac : null
                } else {
                    return ac.changedTouches[0]
                }
            }
            ab.Event.Custom.tap = new ab.Class(ab.extend(ab.Event.Custom, {
                type: "tap",
                id: null,
                init: function(ad, ac) {
                    var ae = Y(ac);
                    this.id = ae.pointerId || ae.identifier;
                    this.x = ae.pageX;
                    this.y = ae.pageY;
                    this.pageX = ae.pageX;
                    this.pageY = ae.pageY;
                    this.clientX = ae.clientX;
                    this.clientY = ae.clientY;
                    this.timeStamp = ac.timeStamp;
                    this.button = 0;
                    this.target = ad;
                    this.pushToEvents(ac)
                }
            }));
            var W = 10,
                Z = 200;
            ab.Event.Custom.tap.handler = {
                add: function(ac) {
                    this.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ab.Event.Custom.tap.handler.onTouchStart, 1);
                    this.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ab.Event.Custom.tap.handler.onTouchEnd, 1);
                    this.jAddEvent("click", ab.Event.Custom.tap.handler.onClick, 1)
                },
                jRemove: function() {
                    this.jRemoveEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ab.Event.Custom.tap.handler.onTouchStart);
                    this.jRemoveEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ab.Event.Custom.tap.handler.onTouchEnd);
                    this.jRemoveEvent("click", ab.Event.Custom.tap.handler.onClick)
                },
                onClick: function(ac) {
                    ac.stopDefaults()
                },
                onTouchStart: function(ac) {
                    if (!V(ac)) {
                        this.jDel("event:tap:event");
                        return
                    }
                    this.jStore("event:tap:event", new ab.Event.Custom.tap(this, ac));
                    this.jStore("event:btnclick:ignore", true)
                },
                onTouchEnd: function(af) {
                    var ad = ab.now(),
                        ae = this.jFetch("event:tap:event"),
                        ac = this.jFetch("event:tap:options");
                    if (!ae || !V(af)) {
                        return
                    }
                    this.jDel("event:tap:event");
                    if (ae.id == X(af) && af.timeStamp - ae.timeStamp <= Z && Math.sqrt(Math.pow(Y(af).pageX - ae.x, 2) + Math.pow(Y(af).pageY - ae.y, 2)) <= W) {
                        this.jDel("event:btnclick:btnclickEvent");
                        af.stop();
                        ae.pushToEvents(af);
                        this.jCallEvent("tap", ae)
                    }
                }
            }
        })(S);
        M.Event.Custom.dbltap = new M.Class(M.extend(M.Event.Custom, {
            type: "dbltap",
            timedout: false,
            tm: null,
            init: function(W, V) {
                this.x = V.x;
                this.y = V.y;
                this.clientX = V.clientX;
                this.clientY = V.clientY;
                this.timeStamp = V.timeStamp;
                this.button = 0;
                this.target = W;
                this.pushToEvents(V)
            }
        }));
        M.Event.Custom.dbltap.handler = {
            options: {
                threshold: 300
            },
            add: function(V) {
                this.jStore("event:dbltap:options", M.extend(M.detach(M.Event.Custom.dbltap.handler.options), V || {}));
                this.jAddEvent("tap", M.Event.Custom.dbltap.handler.handle, 1)
            },
            jRemove: function() {
                this.jRemoveEvent("tap", M.Event.Custom.dbltap.handler.handle)
            },
            handle: function(X) {
                var W, V;
                W = this.jFetch("event:dbltap:event");
                V = this.jFetch("event:dbltap:options");
                if (!W) {
                    W = new M.Event.Custom.dbltap(this, X);
                    W.tm = setTimeout(function() {
                        W.timedout = true;
                        X.isQueueStopped = M.$false;
                        this.jCallEvent("tap", X)
                    }.jBind(this), V.threshold + 10);
                    this.jStore("event:dbltap:event", W);
                    X.stopQueue()
                } else {
                    clearTimeout(W.tm);
                    this.jDel("event:dbltap:event");
                    if (!W.timedout) {
                        W.pushToEvents(X);
                        X.stopQueue().stop();
                        this.jCallEvent("dbltap", W)
                    } else {}
                }
            }
        };
        (function(aa) {
            var Z = aa.$;

            function V(ab) {
                return ab.pointerType ? (("touch" === ab.pointerType || ab.MSPOINTER_TYPE_TOUCH === ab.pointerType) && ab.isPrimary) : 1 === ab.changedTouches.length && (ab.targetTouches.length ? ab.targetTouches[0].identifier == ab.changedTouches[0].identifier : true)
            }

            function X(ab) {
                if (ab.pointerType) {
                    return ("touch" === ab.pointerType || ab.MSPOINTER_TYPE_TOUCH === ab.pointerType) ? ab.pointerId : null
                } else {
                    return ab.changedTouches[0].identifier
                }
            }

            function Y(ab) {
                if (ab.pointerType) {
                    return ("touch" === ab.pointerType || ab.MSPOINTER_TYPE_TOUCH === ab.pointerType) ? ab : null
                } else {
                    return ab.changedTouches[0]
                }
            }
            var W = 10;
            aa.Event.Custom.touchdrag = new aa.Class(aa.extend(aa.Event.Custom, {
                type: "touchdrag",
                state: "dragstart",
                id: null,
                dragged: false,
                init: function(ad, ac, ab) {
                    var ae = Y(ac);
                    this.id = ae.pointerId || ae.identifier;
                    this.clientX = ae.clientX;
                    this.clientY = ae.clientY;
                    this.pageX = ae.pageX;
                    this.pageY = ae.pageY;
                    this.x = ae.pageX;
                    this.y = ae.pageY;
                    this.timeStamp = ac.timeStamp;
                    this.button = 0;
                    this.target = ad;
                    this.pushToEvents(ac);
                    this.state = ab
                }
            }));
            aa.Event.Custom.touchdrag.handler = {
                add: function() {
                    var ac = aa.Event.Custom.touchdrag.handler.onTouchMove.jBind(this),
                        ab = aa.Event.Custom.touchdrag.handler.onTouchEnd.jBind(this);
                    this.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], aa.Event.Custom.touchdrag.handler.onTouchStart, 1);
                    this.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], aa.Event.Custom.touchdrag.handler.onTouchEnd, 1);
                    this.jAddEvent(["touchmove", window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove"], aa.Event.Custom.touchdrag.handler.onTouchMove, 1);
                    this.jStore("event:touchdrag:listeners:document:move", ac);
                    this.jStore("event:touchdrag:listeners:document:end", ab);
                    Z(document).jAddEvent(window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove", ac, 1);
                    Z(document).jAddEvent(window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp", ab, 1)
                },
                jRemove: function() {
                    this.jRemoveEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], aa.Event.Custom.touchdrag.handler.onTouchStart);
                    this.jRemoveEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], aa.Event.Custom.touchdrag.handler.onTouchEnd);
                    this.jRemoveEvent(["touchmove", window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove"], aa.Event.Custom.touchdrag.handler.onTouchMove);
                    Z(document).jRemoveEvent(window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove", this.jFetch("event:touchdrag:listeners:document:move") || aa.$F, 1);
                    Z(document).jRemoveEvent(window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp", this.jFetch("event:touchdrag:listeners:document:end") || aa.$F, 1);
                    this.jDel("event:touchdrag:listeners:document:move");
                    this.jDel("event:touchdrag:listeners:document:end")
                },
                onTouchStart: function(ac) {
                    var ab;
                    if (!V(ac)) {
                        return
                    }
                    ab = new aa.Event.Custom.touchdrag(this, ac, "dragstart");
                    this.jStore("event:touchdrag:dragstart", ab)
                },
                onTouchEnd: function(ac) {
                    var ab;
                    ab = this.jFetch("event:touchdrag:dragstart");
                    if (!ab || !ab.dragged || ab.id != X(ac)) {
                        return
                    }
                    ab = new aa.Event.Custom.touchdrag(this, ac, "dragend");
                    this.jDel("event:touchdrag:dragstart");
                    this.jCallEvent("touchdrag", ab)
                },
                onTouchMove: function(ac) {
                    var ab;
                    ab = this.jFetch("event:touchdrag:dragstart");
                    if (!ab || !V(ac)) {
                        return
                    }
                    if (ab.id != X(ac)) {
                        this.jDel("event:touchdrag:dragstart");
                        return
                    }
                    if (!ab.dragged && Math.sqrt(Math.pow(Y(ac).pageX - ab.x, 2) + Math.pow(Y(ac).pageY - ab.y, 2)) > W) {
                        ab.dragged = true;
                        this.jCallEvent("touchdrag", ab)
                    }
                    if (!ab.dragged) {
                        return
                    }
                    ab = new aa.Event.Custom.touchdrag(this, ac, "dragmove");
                    this.jCallEvent("touchdrag", ab)
                }
            }
        })(S);
        M.Event.Custom.touchpinch = new M.Class(M.extend(M.Event.Custom, {
            type: "touchpinch",
            scale: 1,
            previousScale: 1,
            curScale: 1,
            state: "pinchstart",
            init: function(W, V) {
                this.timeStamp = V.timeStamp;
                this.button = 0;
                this.target = W;
                this.x = V.touches[0].clientX + (V.touches[1].clientX - V.touches[0].clientX) / 2;
                this.y = V.touches[0].clientY + (V.touches[1].clientY - V.touches[0].clientY) / 2;
                this._initialDistance = Math.sqrt(Math.pow(V.touches[0].clientX - V.touches[1].clientX, 2) + Math.pow(V.touches[0].clientY - V.touches[1].clientY, 2));
                this.pushToEvents(V)
            },
            update: function(V) {
                var W;
                this.state = "pinchupdate";
                if (V.changedTouches[0].identifier != this.events[0].touches[0].identifier || V.changedTouches[1].identifier != this.events[0].touches[1].identifier) {
                    return
                }
                W = Math.sqrt(Math.pow(V.changedTouches[0].clientX - V.changedTouches[1].clientX, 2) + Math.pow(V.changedTouches[0].clientY - V.changedTouches[1].clientY, 2));
                this.previousScale = this.scale;
                this.scale = W / this._initialDistance;
                this.curScale = this.scale / this.previousScale;
                this.x = V.changedTouches[0].clientX + (V.changedTouches[1].clientX - V.changedTouches[0].clientX) / 2;
                this.y = V.changedTouches[0].clientY + (V.changedTouches[1].clientY - V.changedTouches[0].clientY) / 2;
                this.pushToEvents(V)
            }
        }));
        M.Event.Custom.touchpinch.handler = {
            add: function() {
                this.jAddEvent("touchstart", M.Event.Custom.touchpinch.handler.handleTouchStart, 1);
                this.jAddEvent("touchend", M.Event.Custom.touchpinch.handler.handleTouchEnd, 1);
                this.jAddEvent("touchmove", M.Event.Custom.touchpinch.handler.handleTouchMove, 1)
            },
            jRemove: function() {
                this.jRemoveEvent("touchstart", M.Event.Custom.touchpinch.handler.handleTouchStart);
                this.jRemoveEvent("touchend", M.Event.Custom.touchpinch.handler.handleTouchEnd);
                this.jRemoveEvent("touchmove", M.Event.Custom.touchpinch.handler.handleTouchMove)
            },
            handleTouchStart: function(W) {
                var V;
                if (W.touches.length != 2) {
                    return
                }
                W.stopDefaults();
                V = new M.Event.Custom.touchpinch(this, W);
                this.jStore("event:touchpinch:event", V)
            },
            handleTouchEnd: function(W) {
                var V;
                V = this.jFetch("event:touchpinch:event");
                if (!V) {
                    return
                }
                W.stopDefaults();
                this.jDel("event:touchpinch:event")
            },
            handleTouchMove: function(W) {
                var V;
                V = this.jFetch("event:touchpinch:event");
                if (!V) {
                    return
                }
                W.stopDefaults();
                V.update(W);
                this.jCallEvent("touchpinch", V)
            }
        };
        (function(aa) {
            var Y = aa.$;
            aa.Event.Custom.mousescroll = new aa.Class(aa.extend(aa.Event.Custom, {
                type: "mousescroll",
                init: function(ag, af, ai, ac, ab, ah, ad) {
                    var ae = af.jGetPageXY();
                    this.x = ae.x;
                    this.y = ae.y;
                    this.timeStamp = af.timeStamp;
                    this.target = ag;
                    this.delta = ai || 0;
                    this.deltaX = ac || 0;
                    this.deltaY = ab || 0;
                    this.deltaZ = ah || 0;
                    this.deltaFactor = ad || 0;
                    this.deltaMode = af.deltaMode || 0;
                    this.isMouse = false;
                    this.pushToEvents(af)
                }
            }));
            var Z, W;

            function V() {
                Z = null
            }

            function X(ab, ac) {
                return (ab > 50) || (1 === ac && !("win" == aa.jBrowser.platform && ab < 1)) || (0 === ab % 12) || (0 == ab % 4.000244140625)
            }
            aa.Event.Custom.mousescroll.handler = {
                eventType: "onwheel" in document || aa.jBrowser.ieMode > 8 ? "wheel" : "mousewheel",
                add: function() {
                    this.jAddEvent(aa.Event.Custom.mousescroll.handler.eventType, aa.Event.Custom.mousescroll.handler.handle, 1)
                },
                jRemove: function() {
                    this.jRemoveEvent(aa.Event.Custom.mousescroll.handler.eventType, aa.Event.Custom.mousescroll.handler.handle, 1)
                },
                handle: function(ag) {
                    var ah = 0,
                        ae = 0,
                        ac = 0,
                        ab = 0,
                        af, ad;
                    if (ag.detail) {
                        ac = ag.detail * -1
                    }
                    if (ag.wheelDelta !== undefined) {
                        ac = ag.wheelDelta
                    }
                    if (ag.wheelDeltaY !== undefined) {
                        ac = ag.wheelDeltaY
                    }
                    if (ag.wheelDeltaX !== undefined) {
                        ae = ag.wheelDeltaX * -1
                    }
                    if (ag.deltaY) {
                        ac = -1 * ag.deltaY
                    }
                    if (ag.deltaX) {
                        ae = ag.deltaX
                    }
                    if (0 === ac && 0 === ae) {
                        return
                    }
                    ah = 0 === ac ? ae : ac;
                    ab = Math.max(Math.abs(ac), Math.abs(ae));
                    if (!Z || ab < Z) {
                        Z = ab
                    }
                    af = ah > 0 ? "floor" : "ceil";
                    ah = Math[af](ah / Z);
                    ae = Math[af](ae / Z);
                    ac = Math[af](ac / Z);
                    if (W) {
                        clearTimeout(W)
                    }
                    W = setTimeout(V, 200);
                    ad = new aa.Event.Custom.mousescroll(this, ag, ah, ae, ac, 0, Z);
                    ad.isMouse = X(Z, ag.deltaMode || 0);
                    this.jCallEvent("mousescroll", ad)
                }
            }
        })(S);
        M.win = M.$(window);
        M.doc = M.$(document);
        return S
    })();
    (function(H) {
        if (!H) {
            throw "MagicJS not found"
        }
        if (H.FX) {
            return
        }
        var G = H.$;
        H.FX = new H.Class({
            init: function(J, I) {
                var K;
                this.el = H.$(J);
                this.options = H.extend(this.options, I);
                this.timer = false;
                this.easeFn = this.cubicBezierAtTime;
                K = H.FX.Transition[this.options.transition] || this.options.transition;
                if ("function" === H.jTypeOf(K)) {
                    this.easeFn = K
                } else {
                    this.cubicBezier = this.parseCubicBezier(K) || this.parseCubicBezier("ease")
                }
                if ("string" == H.jTypeOf(this.options.cycles)) {
                    this.options.cycles = "infinite" === this.options.cycles ? Infinity : parseInt(this.options.cycles) || 1
                }
            },
            options: {
                fps: 60,
                duration: 600,
                transition: "ease",
                cycles: 1,
                direction: "normal",
                onStart: H.$F,
                onComplete: H.$F,
                onBeforeRender: H.$F,
                onAfterRender: H.$F,
                forceAnimation: false,
                roundCss: false
            },
            styles: null,
            cubicBezier: null,
            easeFn: null,
            start: function(K) {
                var I = /\%$/,
                    J;
                this.styles = K;
                this.cycle = 0;
                this.state = 0;
                this.curFrame = 0;
                this.pStyles = {};
                this.alternate = "alternate" === this.options.direction || "alternate-reverse" === this.options.direction;
                this.continuous = "continuous" === this.options.direction || "continuous-reverse" === this.options.direction;
                for (J in this.styles) {
                    I.test(this.styles[J][0]) && (this.pStyles[J] = true);
                    if ("reverse" === this.options.direction || "alternate-reverse" === this.options.direction || "continuous-reverse" === this.options.direction) {
                        this.styles[J].reverse()
                    }
                }
                this.startTime = H.now();
                this.finishTime = this.startTime + this.options.duration;
                this.options.onStart.call();
                if (0 === this.options.duration) {
                    this.render(1);
                    this.options.onComplete.call()
                } else {
                    this.loopBind = this.loop.jBind(this);
                    if (!this.options.forceAnimation && H.jBrowser.features.requestAnimationFrame) {
                        this.timer = H.jBrowser.requestAnimationFrame.call(window, this.loopBind)
                    } else {
                        this.timer = this.loopBind.interval(Math.round(1000 / this.options.fps))
                    }
                }
                return this
            },
            stopAnimation: function() {
                if (this.timer) {
                    if (!this.options.forceAnimation && H.jBrowser.features.requestAnimationFrame && H.jBrowser.cancelAnimationFrame) {
                        H.jBrowser.cancelAnimationFrame.call(window, this.timer)
                    } else {
                        clearInterval(this.timer)
                    }
                    this.timer = false
                }
            },
            stop: function(I) {
                I = H.defined(I) ? I : false;
                this.stopAnimation();
                if (I) {
                    this.render(1);
                    this.options.onComplete.jDelay(10)
                }
                return this
            },
            calc: function(K, J, I) {
                K = parseFloat(K);
                J = parseFloat(J);
                return (J - K) * I + K
            },
            loop: function() {
                var J = H.now(),
                    I = (J - this.startTime) / this.options.duration,
                    K = Math.floor(I);
                if (J >= this.finishTime && K >= this.options.cycles) {
                    this.stopAnimation();
                    this.render(1);
                    this.options.onComplete.jDelay(10);
                    return this
                }
                if (this.alternate && this.cycle < K) {
                    for (var L in this.styles) {
                        this.styles[L].reverse()
                    }
                }
                this.cycle = K;
                if (!this.options.forceAnimation && H.jBrowser.features.requestAnimationFrame) {
                    this.timer = H.jBrowser.requestAnimationFrame.call(window, this.loopBind)
                }
                this.render((this.continuous ? K : 0) + this.easeFn(I % 1))
            },
            render: function(I) {
                var J = {},
                    L = I;
                for (var K in this.styles) {
                    if ("opacity" === K) {
                        J[K] = Math.round(this.calc(this.styles[K][0], this.styles[K][1], I) * 100) / 100
                    } else {
                        J[K] = this.calc(this.styles[K][0], this.styles[K][1], I);
                        this.pStyles[K] && (J[K] += "%")
                    }
                }
                this.options.onBeforeRender(J, this.el);
                this.set(J);
                this.options.onAfterRender(J, this.el)
            },
            set: function(I) {
                return this.el.jSetCss(I)
            },
            parseCubicBezier: function(I) {
                var J, K = null;
                if ("string" !== H.jTypeOf(I)) {
                    return null
                }
                switch (I) {
                    case "linear":
                        K = G([0, 0, 1, 1]);
                        break;
                    case "ease":
                        K = G([0.25, 0.1, 0.25, 1]);
                        break;
                    case "ease-in":
                        K = G([0.42, 0, 1, 1]);
                        break;
                    case "ease-out":
                        K = G([0, 0, 0.58, 1]);
                        break;
                    case "ease-in-out":
                        K = G([0.42, 0, 0.58, 1]);
                        break;
                    case "easeInSine":
                        K = G([0.47, 0, 0.745, 0.715]);
                        break;
                    case "easeOutSine":
                        K = G([0.39, 0.575, 0.565, 1]);
                        break;
                    case "easeInOutSine":
                        K = G([0.445, 0.05, 0.55, 0.95]);
                        break;
                    case "easeInQuad":
                        K = G([0.55, 0.085, 0.68, 0.53]);
                        break;
                    case "easeOutQuad":
                        K = G([0.25, 0.46, 0.45, 0.94]);
                        break;
                    case "easeInOutQuad":
                        K = G([0.455, 0.03, 0.515, 0.955]);
                        break;
                    case "easeInCubic":
                        K = G([0.55, 0.055, 0.675, 0.19]);
                        break;
                    case "easeOutCubic":
                        K = G([0.215, 0.61, 0.355, 1]);
                        break;
                    case "easeInOutCubic":
                        K = G([0.645, 0.045, 0.355, 1]);
                        break;
                    case "easeInQuart":
                        K = G([0.895, 0.03, 0.685, 0.22]);
                        break;
                    case "easeOutQuart":
                        K = G([0.165, 0.84, 0.44, 1]);
                        break;
                    case "easeInOutQuart":
                        K = G([0.77, 0, 0.175, 1]);
                        break;
                    case "easeInQuint":
                        K = G([0.755, 0.05, 0.855, 0.06]);
                        break;
                    case "easeOutQuint":
                        K = G([0.23, 1, 0.32, 1]);
                        break;
                    case "easeInOutQuint":
                        K = G([0.86, 0, 0.07, 1]);
                        break;
                    case "easeInExpo":
                        K = G([0.95, 0.05, 0.795, 0.035]);
                        break;
                    case "easeOutExpo":
                        K = G([0.19, 1, 0.22, 1]);
                        break;
                    case "easeInOutExpo":
                        K = G([1, 0, 0, 1]);
                        break;
                    case "easeInCirc":
                        K = G([0.6, 0.04, 0.98, 0.335]);
                        break;
                    case "easeOutCirc":
                        K = G([0.075, 0.82, 0.165, 1]);
                        break;
                    case "easeInOutCirc":
                        K = G([0.785, 0.135, 0.15, 0.86]);
                        break;
                    case "easeInBack":
                        K = G([0.6, -0.28, 0.735, 0.045]);
                        break;
                    case "easeOutBack":
                        K = G([0.175, 0.885, 0.32, 1.275]);
                        break;
                    case "easeInOutBack":
                        K = G([0.68, -0.55, 0.265, 1.55]);
                        break;
                    default:
                        I = I.replace(/\s/g, "");
                        if (I.match(/^cubic-bezier\((?:-?[0-9\.]{0,}[0-9]{1,},){3}(?:-?[0-9\.]{0,}[0-9]{1,})\)$/)) {
                            K = I.replace(/^cubic-bezier\s*\(|\)$/g, "").split(",");
                            for (J = K.length - 1; J >= 0; J--) {
                                K[J] = parseFloat(K[J])
                            }
                        }
                }
                return G(K)
            },
            cubicBezierAtTime: function(U) {
                var I = 0,
                    T = 0,
                    Q = 0,
                    V = 0,
                    S = 0,
                    O = 0,
                    P = this.options.duration;

                function N(W) {
                    return ((I * W + T) * W + Q) * W
                }

                function M(W) {
                    return ((V * W + S) * W + O) * W
                }

                function K(W) {
                    return (3 * I * W + 2 * T) * W + Q
                }

                function R(W) {
                    return 1 / (200 * W)
                }

                function J(W, X) {
                    return M(L(W, X))
                }

                function L(ad, ae) {
                    var ac, ab, aa, X, W, Z;

                    function Y(af) {
                        if (af >= 0) {
                            return af
                        } else {
                            return 0 - af
                        }
                    }
                    for (aa = ad, Z = 0; Z < 8; Z++) {
                        X = N(aa) - ad;
                        if (Y(X) < ae) {
                            return aa
                        }
                        W = K(aa);
                        if (Y(W) < 0.000001) {
                            break
                        }
                        aa = aa - X / W
                    }
                    ac = 0;
                    ab = 1;
                    aa = ad;
                    if (aa < ac) {
                        return ac
                    }
                    if (aa > ab) {
                        return ab
                    }
                    while (ac < ab) {
                        X = N(aa);
                        if (Y(X - ad) < ae) {
                            return aa
                        }
                        if (ad > X) {
                            ac = aa
                        } else {
                            ab = aa
                        }
                        aa = (ab - ac) * 0.5 + ac
                    }
                    return aa
                }
                Q = 3 * this.cubicBezier[0];
                T = 3 * (this.cubicBezier[2] - this.cubicBezier[0]) - Q;
                I = 1 - Q - T;
                O = 3 * this.cubicBezier[1];
                S = 3 * (this.cubicBezier[3] - this.cubicBezier[1]) - O;
                V = 1 - O - S;
                return J(U, R(P))
            }
        });
        H.FX.Transition = {
            linear: "linear",
            sineIn: "easeInSine",
            sineOut: "easeOutSine",
            expoIn: "easeInExpo",
            expoOut: "easeOutExpo",
            quadIn: "easeInQuad",
            quadOut: "easeOutQuad",
            cubicIn: "easeInCubic",
            cubicOut: "easeOutCubic",
            backIn: "easeInBack",
            backOut: "easeOutBack",
            elasticIn: function(J, I) {
                I = I || [];
                return Math.pow(2, 10 * --J) * Math.cos(20 * J * Math.PI * (I[0] || 1) / 3)
            },
            elasticOut: function(J, I) {
                return 1 - H.FX.Transition.elasticIn(1 - J, I)
            },
            bounceIn: function(K) {
                for (var J = 0, I = 1; 1; J += I, I /= 2) {
                    if (K >= (7 - 4 * J) / 11) {
                        return I * I - Math.pow((11 - 6 * J - 11 * K) / 4, 2)
                    }
                }
            },
            bounceOut: function(I) {
                return 1 - H.FX.Transition.bounceIn(1 - I)
            },
            none: function(I) {
                return 0
            }
        }
    })(w);
    (function(H) {
        if (!H) {
            throw "MagicJS not found"
        }
        if (H.PFX) {
            return
        }
        var G = H.$;
        H.PFX = new H.Class(H.FX, {
            init: function(I, J) {
                this.el_arr = I;
                this.options = H.extend(this.options, J);
                this.timer = false;
                this.$parent.init()
            },
            start: function(M) {
                var I = /\%$/,
                    L, K, J = M.length;
                this.styles_arr = M;
                this.pStyles_arr = new Array(J);
                for (K = 0; K < J; K++) {
                    this.pStyles_arr[K] = {};
                    for (L in M[K]) {
                        I.test(M[K][L][0]) && (this.pStyles_arr[K][L] = true);
                        if ("reverse" === this.options.direction || "alternate-reverse" === this.options.direction || "continuous-reverse" === this.options.direction) {
                            this.styles_arr[K][L].reverse()
                        }
                    }
                }
                this.$parent.start([]);
                return this
            },
            render: function(I) {
                for (var J = 0; J < this.el_arr.length; J++) {
                    this.el = H.$(this.el_arr[J]);
                    this.styles = this.styles_arr[J];
                    this.pStyles = this.pStyles_arr[J];
                    this.$parent.render(I)
                }
            }
        })
    })(w);
    (function(I) {
        if (!I) {
            throw "MagicJS not found"
        }
        var H = I.$;
        var G = window.URL || window.webkitURL || null;
        w.ImageLoader = new I.Class({
            img: null,
            ready: false,
            options: {
                onprogress: I.$F,
                onload: I.$F,
                onabort: I.$F,
                onerror: I.$F,
                oncomplete: I.$F,
                onxhrerror: I.$F,
                xhr: false,
                progressiveLoad: true
            },
            size: null,
            _timer: null,
            loadedBytes: 0,
            _handlers: {
                onprogress: function(J) {
                    if (J.target && (200 === J.target.status || 304 === J.target.status) && J.lengthComputable) {
                        this.options.onprogress.jBind(null, (J.loaded - (this.options.progressiveLoad ? this.loadedBytes : 0)) / J.total).jDelay(1);
                        this.loadedBytes = J.loaded
                    }
                },
                onload: function(J) {
                    if (J) {
                        H(J).stop()
                    }
                    this._unbind();
                    if (this.ready) {
                        return
                    }
                    this.ready = true;
                    this._cleanup();
                    !this.options.xhr && this.options.onprogress.jBind(null, 1).jDelay(1);
                    this.options.onload.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                },
                onabort: function(J) {
                    if (J) {
                        H(J).stop()
                    }
                    this._unbind();
                    this.ready = false;
                    this._cleanup();
                    this.options.onabort.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                },
                onerror: function(J) {
                    if (J) {
                        H(J).stop()
                    }
                    this._unbind();
                    this.ready = false;
                    this._cleanup();
                    this.options.onerror.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                }
            },
            _bind: function() {
                H(["load", "abort", "error"]).jEach(function(J) {
                    this.img.jAddEvent(J, this._handlers["on" + J].jBindAsEvent(this).jDefer(1))
                }, this)
            },
            _unbind: function() {
                if (this._timer) {
                    try {
                        clearTimeout(this._timer)
                    } catch (J) {}
                    this._timer = null
                }
                H(["load", "abort", "error"]).jEach(function(K) {
                    this.img.jRemoveEvent(K)
                }, this)
            },
            _cleanup: function() {
                this.jGetSize();
                if (this.img.jFetch("new")) {
                    var J = this.img.parentNode;
                    this.img.jRemove().jDel("new").jSetCss({
                        position: "static",
                        top: "auto"
                    });
                    J.kill()
                }
            },
            loadBlob: function(K) {
                var L = new XMLHttpRequest(),
                    J;
                H(["abort", "progress"]).jEach(function(M) {
                    L["on" + M] = H(function(N) {
                        this._handlers["on" + M].call(this, N)
                    }).jBind(this)
                }, this);
                L.onerror = H(function() {
                    this.options.onxhrerror.jBind(null, this).jDelay(1);
                    this.options.xhr = false;
                    this._bind();
                    this.img.src = K
                }).jBind(this);
                L.onload = H(function() {
                    if (200 !== L.status && 304 !== L.status) {
                        this._handlers.onerror.call(this);
                        return
                    }
                    J = L.response;
                    this._bind();
                    if (G && !I.jBrowser.trident && !("ios" === I.jBrowser.platform && I.jBrowser.version < 537)) {
                        this.img.setAttribute("src", G.createObjectURL(J))
                    } else {
                        this.img.src = K
                    }
                }).jBind(this);
                L.open("GET", K);
                L.responseType = "blob";
                L.send()
            },
            init: function(K, J) {
                this.options = I.extend(this.options, J);
                this.img = H(K) || I.$new("img", {}, {
                    "max-width": "none",
                    "max-height": "none"
                }).jAppendTo(I.$new("div").jAddClass("magic-temporary-img").jSetCss({
                    position: "absolute",
                    top: -10000,
                    width: 10,
                    height: 10,
                    overflow: "hidden"
                }).jAppendTo(document.body)).jStore("new", true);
                if (I.jBrowser.features.xhr2 && this.options.xhr && "string" == I.jTypeOf(K)) {
                    this.loadBlob(K);
                    return
                }
                var L = function() {
                    if (this.isReady()) {
                        this._handlers.onload.call(this)
                    } else {
                        this._handlers.onerror.call(this)
                    }
                    L = null
                }.jBind(this);
                this._bind();
                if ("string" == I.jTypeOf(K)) {
                    this.img.src = K
                } else {
                    if (I.jBrowser.trident && 5 == I.jBrowser.version && I.jBrowser.ieMode < 9) {
                        this.img.onreadystatechange = function() {
                            if (/loaded|complete/.test(this.img.readyState)) {
                                this.img.onreadystatechange = null;
                                L && L()
                            }
                        }.jBind(this)
                    }
                    this.img.src = K.getAttribute("src")
                }
                this.img && this.img.complete && L && (this._timer = L.jDelay(100))
            },
            destroy: function() {
                this._unbind();
                this._cleanup();
                this.ready = false;
                return this
            },
            isReady: function() {
                var J = this.img;
                return (J.naturalWidth) ? (J.naturalWidth > 0) : (J.readyState) ? ("complete" == J.readyState) : J.width > 0
            },
            jGetSize: function() {
                return this.size || (this.size = {
                    width: this.img.naturalWidth || this.img.width,
                    height: this.img.naturalHeight || this.img.height
                })
            }
        })
    })(w);
    (function(H) {
        if (!H) {
            throw "MagicJS not found";
            return
        }
        if (H.Tooltip) {
            return
        }
        var G = H.$;
        H.Tooltip = function(J, K) {
            var I = this.tooltip = H.$new("div", null, {
                position: "absolute",
                "z-index": 999
            }).jAddClass("MagicToolboxTooltip");
            H.$(J).jAddEvent("mouseover", function() {
                I.jAppendTo(document.body)
            });
            H.$(J).jAddEvent("mouseout", function() {
                I.jRemove()
            });
            H.$(J).jAddEvent("mousemove", function(P) {
                var R = 20,
                    O = H.$(P).jGetPageXY(),
                    N = I.jGetSize(),
                    M = H.$(window).jGetSize(),
                    Q = H.$(window).jGetScroll();

                function L(U, S, T) {
                    return (T < (U - S) / 2) ? T : ((T > (U + S) / 2) ? (T - S) : (U - S) / 2)
                }
                I.jSetCss({
                    left: Q.x + L(M.width, N.width + 2 * R, O.x - Q.x) + R,
                    top: Q.y + L(M.height, N.height + 2 * R, O.y - Q.y) + R
                })
            });
            this.text(K)
        };
        H.Tooltip.prototype.text = function(I) {
            this.tooltip.firstChild && this.tooltip.removeChild(this.tooltip.firstChild);
            this.tooltip.append(document.createTextNode(I))
        }
    })(w);
    (function(H) {
        if (!H) {
            throw "MagicJS not found";
            return
        }
        if (H.MessageBox) {
            return
        }
        var G = H.$;
        H.Message = function(L, K, J, I) {
            this.hideTimer = null;
            this.messageBox = H.$new("span", null, {
                position: "absolute",
                "z-index": 999,
                visibility: "hidden",
                opacity: 0.8
            }).jAddClass(I || "").jAppendTo(J || document.body);
            this.setMessage(L);
            this.show(K)
        };
        H.Message.prototype.show = function(I) {
            this.messageBox.show();
            this.hideTimer = this.hide.jBind(this).jDelay(H.ifndef(I, 5000))
        };
        H.Message.prototype.hide = function(I) {
            clearTimeout(this.hideTimer);
            this.hideTimer = null;
            if (this.messageBox && !this.hideFX) {
                this.hideFX = new w.FX(this.messageBox, {
                    duration: H.ifndef(I, 500),
                    onComplete: function() {
                        this.messageBox.kill();
                        delete this.messageBox;
                        this.hideFX = null
                    }.jBind(this)
                }).start({
                    opacity: [this.messageBox.jGetCss("opacity"), 0]
                })
            }
        };
        H.Message.prototype.setMessage = function(I) {
            this.messageBox.firstChild && this.tooltip.removeChild(this.messageBox.firstChild);
            this.messageBox.append(document.createTextNode(I))
        }
    })(w);
    (function(H) {
        if (!H) {
            throw "MagicJS not found"
        }
        if (H.Options) {
            return
        }
        var K = H.$,
            G = null,
            O = {
                "boolean": 1,
                array: 2,
                number: 3,
                "function": 4,
                string: 100
            },
            I = {
                "boolean": function(R, Q, P) {
                    if ("boolean" != H.jTypeOf(Q)) {
                        if (P || "string" != H.jTypeOf(Q)) {
                            return false
                        } else {
                            if (!/^(true|false)$/.test(Q)) {
                                return false
                            } else {
                                Q = Q.jToBool()
                            }
                        }
                    }
                    if (R.hasOwnProperty("enum") && !K(R["enum"]).contains(Q)) {
                        return false
                    }
                    G = Q;
                    return true
                },
                string: function(R, Q, P) {
                    if ("string" !== H.jTypeOf(Q)) {
                        return false
                    } else {
                        if (R.hasOwnProperty("enum") && !K(R["enum"]).contains(Q)) {
                            return false
                        } else {
                            G = "" + Q;
                            return true
                        }
                    }
                },
                number: function(S, R, Q) {
                    var P = false,
                        U = /%$/,
                        T = (H.jTypeOf(R) == "string" && U.test(R));
                    if (Q && !"number" == typeof R) {
                        return false
                    }
                    R = parseFloat(R);
                    if (isNaN(R)) {
                        return false
                    }
                    if (isNaN(S.minimum)) {
                        S.minimum = Number.NEGATIVE_INFINITY
                    }
                    if (isNaN(S.maximum)) {
                        S.maximum = Number.POSITIVE_INFINITY
                    }
                    if (S.hasOwnProperty("enum") && !K(S["enum"]).contains(R)) {
                        return false
                    }
                    if (S.minimum > R || R > S.maximum) {
                        return false
                    }
                    G = T ? (R + "%") : R;
                    return true
                },
                array: function(S, Q, P) {
                    if ("string" === H.jTypeOf(Q)) {
                        try {
                            Q = window.JSON.parse(Q)
                        } catch (R) {
                            return false
                        }
                    }
                    if (H.jTypeOf(Q) === "array") {
                        G = Q;
                        return true
                    } else {
                        return false
                    }
                },
                "function": function(R, Q, P) {
                    if (H.jTypeOf(Q) === "function") {
                        G = Q;
                        return true
                    } else {
                        return false
                    }
                }
            },
            J = function(U, T, Q) {
                var S;
                S = U.hasOwnProperty("oneOf") ? U.oneOf : [U];
                if ("array" != H.jTypeOf(S)) {
                    return false
                }
                for (var R = 0, P = S.length - 1; R <= P; R++) {
                    if (I[S[R].type](S[R], T, Q)) {
                        return true
                    }
                }
                return false
            },
            M = function(U) {
                var S, R, T, P, Q;
                if (U.hasOwnProperty("oneOf")) {
                    P = U.oneOf.length;
                    for (S = 0; S < P; S++) {
                        for (R = S + 1; R < P; R++) {
                            if (O[U.oneOf[S]["type"]] > O[U.oneOf[R].type]) {
                                Q = U.oneOf[S];
                                U.oneOf[S] = U.oneOf[R];
                                U.oneOf[R] = Q
                            }
                        }
                    }
                }
                return U
            },
            N = function(S) {
                var R;
                R = S.hasOwnProperty("oneOf") ? S.oneOf : [S];
                if ("array" != H.jTypeOf(R)) {
                    return false
                }
                for (var Q = R.length - 1; Q >= 0; Q--) {
                    if (!R[Q].type || !O.hasOwnProperty(R[Q].type)) {
                        return false
                    }
                    if (H.defined(R[Q]["enum"])) {
                        if ("array" !== H.jTypeOf(R[Q]["enum"])) {
                            return false
                        }
                        for (var P = R[Q]["enum"].length - 1; P >= 0; P--) {
                            if (!I[R[Q].type]({
                                    type: R[Q].type
                                }, R[Q]["enum"][P], true)) {
                                return false
                            }
                        }
                    }
                }
                if (S.hasOwnProperty("default") && !J(S, S["default"], true)) {
                    return false
                }
                return true
            },
            L = function(P) {
                this.schema = {};
                this.options = {};
                this.parseSchema(P)
            };
        H.extend(L.prototype, {
            parseSchema: function(R) {
                var Q, P, S;
                for (Q in R) {
                    if (!R.hasOwnProperty(Q)) {
                        continue
                    }
                    P = (Q + "").jTrim().jCamelize();
                    if (!this.schema.hasOwnProperty(P)) {
                        this.schema[P] = M(R[Q]);
                        if (!N(this.schema[P])) {
                            throw "Incorrect definition of the '" + Q + "' parameter in " + R
                        }
                        this.options[P] = undefined
                    }
                }
            },
            set: function(Q, P) {
                Q = (Q + "").jTrim().jCamelize();
                if (H.jTypeOf(P) == "string") {
                    P = P.jTrim()
                }
                if (this.schema.hasOwnProperty(Q)) {
                    G = P;
                    if (J(this.schema[Q], P)) {
                        this.options[Q] = G
                    }
                    G = null
                }
            },
            get: function(P) {
                P = (P + "").jTrim().jCamelize();
                if (this.schema.hasOwnProperty(P)) {
                    return H.defined(this.options[P]) ? this.options[P] : this.schema[P]["default"]
                }
            },
            fromJSON: function(Q) {
                for (var P in Q) {
                    this.set(P, Q[P])
                }
            },
            getJSON: function() {
                var Q = H.extend({}, this.options);
                for (var P in Q) {
                    if (undefined === Q[P] && undefined !== this.schema[P]["default"]) {
                        Q[P] = this.schema[P]["default"]
                    }
                }
                return Q
            },
            fromString: function(P) {
                K(P.split(";")).jEach(K(function(Q) {
                    Q = Q.split(":");
                    this.set(Q.shift().jTrim(), Q.join(":"))
                }).jBind(this))
            },
            exists: function(P) {
                P = (P + "").jTrim().jCamelize();
                return this.schema.hasOwnProperty(P)
            },
            isset: function(P) {
                P = (P + "").jTrim().jCamelize();
                return this.exists(P) && H.defined(this.options[P])
            },
            jRemove: function(P) {
                P = (P + "").jTrim().jCamelize();
                if (this.exists(P)) {
                    delete this.options[P];
                    delete this.schema[P]
                }
            }
        });
        H.Options = L
    }(w));
    (function(K) {
        if (!K) {
            throw "MagicJS not found";
            return
        }
        var J = K.$;
        if (K.SVGImage) {
            return
        }
        var I = "http://www.w3.org/2000/svg",
            H = "http://www.w3.org/1999/xlink";
        var G = function(L) {
            this.filters = {};
            this.originalImage = J(L);
            this.canvas = J(document.createElementNS(I, "svg"));
            this.canvas.setAttribute("width", this.originalImage.naturalWidth || this.originalImage.width);
            this.canvas.setAttribute("height", this.originalImage.naturalHeight || this.originalImage.height);
            this.image = J(document.createElementNS(I, "image"));
            this.image.setAttributeNS(H, "href", this.originalImage.getAttribute("src"));
            this.image.setAttribute("width", "100%");
            this.image.setAttribute("height", "100%");
            this.image.jAppendTo(this.canvas)
        };
        G.prototype.getNode = function() {
            return this.canvas
        };
        G.prototype.blur = function(L) {
            if (Math.round(L) < 1) {
                return
            }
            if (!this.filters.blur) {
                this.filters.blur = J(document.createElementNS(I, "filter"));
                this.filters.blur.setAttribute("id", "filterBlur");
                this.filters.blur.appendChild(J(document.createElementNS(I, "feGaussianBlur")).setProps({
                    "in": "SourceGraphic",
                    stdDeviation: L
                }));
                this.filters.blur.jAppendTo(this.canvas);
                this.image.setAttribute("filter", "url(#filterBlur)")
            } else {
                this.filters.blur.firstChild.setAttribute("stdDeviation", L)
            }
            return this
        };
        K.SVGImage = G
    }(w));
    var r = (function(I) {
        var H = I.$;
        var G = function(K, J) {
            this.settings = {
                cssPrefix: "magic",
                orientation: "horizontal",
                position: "bottom",
                size: {
                    units: "px",
                    width: "auto",
                    height: "auto"
                },
                sides: ["height", "width"]
            };
            this.parent = K;
            this.root = null;
            this.wrapper = null;
            this.context = null;
            this.buttons = {};
            this.items = [];
            this.selectedItem = null;
            this.scrollFX = null;
            this.resizeCallback = null;
            this.settings = I.extend(this.settings, J);
            this.rootCSS = this.settings.cssPrefix + "-thumbs";
            this.itemCSS = this.settings.cssPrefix + "-thumb";
            this.setupContent()
        };
        G.prototype = {
            setupContent: function() {
                this.root = I.$new("div").jAddClass(this.rootCSS).jAddClass(this.rootCSS + "-" + this.settings.orientation).jSetCss({
                    visibility: "hidden"
                });
                this.wrapper = I.$new("div").jAddClass(this.rootCSS + "-wrapper").jAppendTo(this.root);
                this.root.jAppendTo(this.parent);
                H(["prev", "next"]).jEach(function(J) {
                    this.buttons[J] = I.$new("button").jAddClass(this.rootCSS + "-button").jAddClass(this.rootCSS + "-button-" + J).jAppendTo(this.root).jAddEvent("btnclick tap", (function(L, K) {
                        H(L).events[0].stop().stopQueue();
                        H(L).stopDistribution();
                        this.scroll(K)
                    }).jBindAsEvent(this, J))
                }.jBind(this));
                this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled");
                this.context = I.$new("ul").jAddEvent("btnclick tap", function(J) {
                    J.stop()
                })
            },
            addItem: function(K) {
                var J = I.$new("li").jAddClass(this.itemCSS).append(K).jAppendTo(this.context);
                new I.ImageLoader(K, {
                    oncomplete: this.reflow.jBind(this)
                });
                this.items.push(J);
                return J
            },
            selectItem: function(K) {
                var J = this.selectedItem || this.context.byClass(this.itemCSS + "-selected")[0];
                if (J) {
                    H(J).jRemoveClass(this.itemCSS + "-selected")
                }
                this.selectedItem = H(K);
                if (!this.selectedItem) {
                    return
                }
                this.selectedItem.jAddClass(this.itemCSS + "-selected");
                this.scroll(this.selectedItem)
            },
            run: function() {
                if (this.wrapper !== this.context.parentNode) {
                    H(this.context).jAppendTo(this.wrapper);
                    this.initDrag();
                    H(window).jAddEvent("resize", this.resizeCallback = this.reflow.jBind(this));
                    this.run.jBind(this).jDelay(1);
                    return
                }
                var J = this.parent.jGetSize();
                if (J.height > 0 && J.height > J.width) {
                    this.setOrientation("vertical")
                } else {
                    this.setOrientation("horizontal")
                }
                this.reflow();
                this.root.jSetCss({
                    visibility: ""
                })
            },
            stop: function() {
                if (this.resizeCallback) {
                    H(window).jRemoveEvent("resize", this.resizeCallback)
                }
                this.root.kill()
            },
            scroll: function(W, M) {
                var O = {
                        x: 0,
                        y: 0
                    },
                    Z = "vertical" == this.settings.orientation ? "top" : "left",
                    R = "vertical" == this.settings.orientation ? "height" : "width",
                    N = "vertical" == this.settings.orientation ? "y" : "x",
                    V = this.context.parentNode.jGetSize()[R],
                    S = this.context.parentNode.jGetPosition(),
                    L = this.context.jGetSize()[R],
                    U, J, Y, P, K, T, Q, X = [];
                if (this.scrollFX) {
                    this.scrollFX.stop()
                } else {
                    this.context.jSetCss("transition", I.jBrowser.cssTransformProp + String.fromCharCode(32) + "0s")
                }
                if (undefined === M) {
                    M = 600
                }
                U = this.context.jGetPosition();
                if ("string" == I.jTypeOf(W)) {
                    O[N] = ("next" == W) ? Math.max(U[Z] - S[Z] - V, V - L) : Math.min(U[Z] - S[Z] + V, 0)
                } else {
                    if ("element" == I.jTypeOf(W)) {
                        J = W.jGetSize();
                        Y = W.jGetPosition();
                        O[N] = Math.min(0, Math.max(V - L, U[Z] + V / 2 - Y[Z] - J[R] / 2))
                    } else {
                        return
                    }
                }
                if (I.jBrowser.gecko && "android" == I.jBrowser.platform || I.jBrowser.ieMode && I.jBrowser.ieMode < 10) {
                    if ("string" == I.jTypeOf(W) && O[N] == U[Z] - S[Z]) {
                        U[Z] += 0 === U[Z] - S[Z] ? 30 : -30
                    }
                    O["margin-" + Z] = [((L <= V) ? 0 : (U[Z] - S[Z])), O[N]];
                    delete O.x;
                    delete O.y;
                    if (!this.selectorsMoveFX) {
                        this.selectorsMoveFX = new I.PFX([this.context], {
                            duration: 500
                        })
                    }
                    X.push(O);
                    this.selectorsMoveFX.start(X);
                    Q = O["margin-" + Z][1]
                } else {
                    this.context.jSetCss({
                        transition: I.jBrowser.cssTransformProp + String.fromCharCode(32) + M + "ms ease",
                        transform: "translate3d(" + O.x + "px, " + O.y + "px, 0)"
                    });
                    Q = O[N]
                }
                if (Q >= 0) {
                    this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled")
                } else {
                    this.buttons.prev.jRemoveClass(this.rootCSS + "-button-disabled")
                }
                if (Q <= V - L) {
                    this.buttons.next.jAddClass(this.rootCSS + "-button-disabled")
                } else {
                    this.buttons.next.jRemoveClass(this.rootCSS + "-button-disabled")
                }
                Q = null
            },
            initDrag: function() {
                var L, K, M, T, S, V, N, R, Q, U, aa, X, Y, W = {
                        x: 0,
                        y: 0
                    },
                    J, P, O = 300,
                    Z = function(ad) {
                        var ac, ab = 0;
                        for (ac = 1.5; ac <= 90; ac += 1.5) {
                            ab += (ad * Math.cos(ac / Math.PI / 2))
                        }(T < 0) && (ab *= (-1));
                        return ab
                    };
                S = H(function(ab) {
                    W = {
                        x: 0,
                        y: 0
                    };
                    J = "vertical" == this.settings.orientation ? "top" : "left";
                    P = "vertical" == this.settings.orientation ? "height" : "width";
                    L = "vertical" == this.settings.orientation ? "y" : "x";
                    X = this.context.parentNode.jGetSize()[P];
                    aa = this.context.jGetSize()[P];
                    M = X - aa;
                    if (M >= 0) {
                        return
                    }
                    if (ab.state == "dragstart") {
                        if (undefined === Y) {
                            Y = 0
                        }
                        this.context.jSetCssProp("transition", I.jBrowser.cssTransformProp + String.fromCharCode(32) + "0ms");
                        V = ab[L];
                        Q = ab.y;
                        R = ab.x;
                        U = false
                    } else {
                        if ("dragend" == ab.state) {
                            if (U) {
                                return
                            }
                            N = Z(Math.abs(T));
                            Y += N;
                            (Y <= M) && (Y = M);
                            (Y >= 0) && (Y = 0);
                            W[L] = Y;
                            this.context.jSetCssProp("transition", I.jBrowser.cssTransformProp + String.fromCharCode(32) + O + "ms  cubic-bezier(.0, .0, .0, 1)");
                            this.context.jSetCssProp("transform", "translate3d(" + W.x + "px, " + W.y + "px, 0px)");
                            T = 0
                        } else {
                            if (U) {
                                return
                            }
                            if ("horizontal" == this.settings.orientation && Math.abs(ab.x - R) > Math.abs(ab.y - Q) || "vertical" == this.settings.orientation && Math.abs(ab.x - R) < Math.abs(ab.y - Q)) {
                                ab.stop();
                                T = ab[L] - V;
                                Y += T;
                                W[L] = Y;
                                this.context.jSetCssProp("transform", "translate3d(" + W.x + "px, " + W.y + "px, 0px)");
                                if (Y >= 0) {
                                    this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled")
                                } else {
                                    this.buttons.prev.jRemoveClass(this.rootCSS + "-button-disabled")
                                }
                                if (Y <= M) {
                                    this.buttons.next.jAddClass(this.rootCSS + "-button-disabled")
                                } else {
                                    this.buttons.next.jRemoveClass(this.rootCSS + "-button-disabled")
                                }
                            } else {
                                U = true
                            }
                        }
                        V = ab[L]
                    }
                }).jBind(this);
                this.context.jAddEvent("touchdrag", S)
            },
            reflow: function() {
                var M, L, J, K = this.parent.jGetSize();
                if (K.height > 0 && K.height > K.width) {
                    this.setOrientation("vertical")
                } else {
                    this.setOrientation("horizontal")
                }
                M = "vertical" == this.settings.orientation ? "height" : "width";
                L = this.context.jGetSize()[M];
                J = this.root.jGetSize()[M];
                if (L <= J) {
                    this.root.jAddClass("no-buttons");
                    this.context.jSetCssProp("transition", "").jGetSize();
                    this.context.jSetCssProp("transform", "translate3d(0,0,0)");
                    this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled");
                    this.buttons.next.jRemoveClass(this.rootCSS + "-button-disabled")
                } else {
                    this.root.jRemoveClass("no-buttons")
                }
                if (this.selectedItem) {
                    this.scroll(this.selectedItem, 0)
                }
            },
            setOrientation: function(J) {
                if ("vertical" !== J && "horizontal" !== J || J == this.settings.orientation) {
                    return
                }
                this.root.jRemoveClass(this.rootCSS + "-" + this.settings.orientation);
                this.settings.orientation = J;
                this.root.jAddClass(this.rootCSS + "-" + this.settings.orientation);
                this.context.jSetCssProp("transition", "none").jGetSize();
                this.context.jSetCssProp("transform", "").jSetCssProp("margin", "")
            }
        };
        return G
    })(w);
    var h = y.$;
    if (!y.jBrowser.cssTransform) {
        y.jBrowser.cssTransform = y.normalizeCSS("transform").dashize()
    }
    var o = {
        zoomOn: {
            type: "string",
            "enum": ["click", "hover"],
            "default": "hover"
        },
        zoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "preview", "off"],
                "default": "zoom"
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "zoom"
        },
        zoomWidth: {
            oneOf: [{
                type: "string",
                "enum": ["auto"]
            }, {
                type: "number",
                minimum: 1
            }],
            "default": "auto"
        },
        zoomHeight: {
            oneOf: [{
                type: "string",
                "enum": ["auto"]
            }, {
                type: "number",
                minimum: 1
            }],
            "default": "auto"
        },
        zoomPosition: {
            type: "string",
            "default": "right"
        },
        zoomDistance: {
            type: "number",
            minimum: 0,
            "default": 15
        },
        zoomCaption: {
            oneOf: [{
                type: "string",
                "enum": ["bottom", "top", "off"],
                "default": "off"
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "off"
        },
        expand: {
            oneOf: [{
                type: "string",
                "enum": ["window", "fullscreen", "off"]
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "window"
        },
        expandZoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "off"],
                "default": "zoom"
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "zoom"
        },
        expandZoomOn: {
            type: "string",
            "enum": ["click", "always"],
            "default": "click"
        },
        expandCaption: {
            type: "boolean",
            "default": true
        },
        closeOnClickOutside: {
            type: "boolean",
            "default": true
        },
        hint: {
            oneOf: [{
                type: "string",
                "enum": ["once", "always", "off"]
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "once"
        },
        upscale: {
            type: "boolean",
            "default": true
        },
        variableZoom: {
            type: "boolean",
            "default": false
        },
        lazyZoom: {
            type: "boolean",
            "default": false
        },
        autostart: {
            type: "boolean",
            "default": true
        },
        rightClick: {
            type: "boolean",
            "default": false
        },
        transitionEffect: {
            type: "boolean",
            "default": true
        },
        selectorTrigger: {
            type: "string",
            "enum": ["click", "hover"],
            "default": "click"
        },
        cssClass: {
            type: "string"
        },
        textHoverZoomHint: {
            type: "string",
            "default": "Hover to zoom"
        },
        textClickZoomHint: {
            type: "string",
            "default": "Click to zoom"
        },
        textExpandHint: {
            type: "string",
            "default": "Click to expand"
        },
        textBtnClose: {
            type: "string",
            "default": "Close"
        },
        textBtnNext: {
            type: "string",
            "default": "Next"
        },
        textBtnPrev: {
            type: "string",
            "default": "Previous"
        }
    };
    var l = {
        zoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "off"],
                "default": "zoom"
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "zoom"
        },
        expandZoomOn: {
            type: "string",
            "enum": ["click"],
            "default": "click"
        },
        textExpandHint: {
            type: "string",
            "default": "Tap to expand"
        },
        textHoverZoomHint: {
            type: "string",
            "default": "Touch to zoom"
        },
        textClickZoomHint: {
            type: "string",
            "default": "Double tap to zoom"
        }
    };
    var n = "MagicZoom",
        B = "mz",
        b = 20,
        z = ["onZoomReady", "onUpdate", "onZoomIn", "onZoomOut", "onExpandOpen", "onExpandClose"];
    var t, p = {},
        D = h([]),
        F, e = window.devicePixelRatio || 1,
        E, x = true,
        f = y.jBrowser.features.perspective ? "translate3d(" : "translate(",
        A = y.jBrowser.features.perspective ? ",0)" : ")",
        m = null;
    var q = (function() {
        var H, K, J, I, G;
        G = ["2o.f|kh3,fzz~4!!yyy coigmzaablav mac!coigmtaac~b{}!,.a`mbgme3,zfg} lb{|&'5,.zo|ikz3,Qlbo`e,.}zwbk3,maba|4.g`fk|gz5.zkvz#jkma|ozga`4.`a`k5,0Coigm.Taac.^b{}(z|ojk5.z|gob.xk|}ga`2!o0", "#ff0000", 11, "normal", "", "center", "100%"];
        return G
    })();

    function v(I) {
        var H, G;
        H = "";
        for (G = 0; G < I.length; G++) {
            H += String.fromCharCode(14 ^ I.charCodeAt(G))
        }
        return H
    }

    function i(I) {
        var H = [],
            G = null;
        (I && (G = h(I))) && (H = D.filter(function(J) {
            return J.placeholder === G
        }));
        return H.length ? H[0] : null
    }

    function a(I) {
        var H = h(window).jGetSize(),
            G = h(window).jGetScroll();
        I = I || 0;
        return {
            left: I,
            right: H.width - I,
            top: I,
            bottom: H.height - I,
            x: G.x,
            y: G.y
        }
    }

    function c(G) {
        return (G.pointerType && ("touch" === G.pointerType || G.pointerType === G.MSPOINTER_TYPE_TOUCH)) || (/touch/i).test(G.type)
    }

    function g(G) {
        return G.pointerType ? (("touch" === G.pointerType || G.MSPOINTER_TYPE_TOUCH === G.pointerType) && G.isPrimary) : 1 === G.changedTouches.length && (G.targetTouches.length ? G.targetTouches[0].identifier == G.changedTouches[0].identifier : true)
    }

    function s() {
        var I = y.$A(arguments),
            H = I.shift(),
            G = p[H];
        if (G) {
            for (var J = 0; J < G.length; J++) {
                G[J].apply(null, I)
            }
        }
    }

    function C() {
        var J = arguments[0],
            G, I, H = [];
        do {
            I = J.tagName;
            if (/^[A-Za-z]*$/.test(I)) {
                if (G = J.getAttribute("id")) {
                    I += "#" + G
                }
                H.push(I)
            }
            J = J.parentNode
        } while (J && J !== document.documentElement);
        H = H.reverse();
        y.addCSS(H.join(" ") + "> .mz-figure > img", {
            width: "100% !important;"
        }, "mz-runtime-css", true)
    }

    function u() {
        var H = null,
            I = null,
            G = function() {
                window.scrollTo(document.body.scrollLeft, document.body.scrollTop);
                window.dispatchEvent(new Event("resize"))
            };
        I = setInterval(function() {
            var L = window.orientation == 90 || window.orientation == -90,
                K = window.innerHeight,
                J = (L ? screen.availWidth : screen.availHeight) * 0.85;
            if ((H == null || H == false) && ((L && K < J) || (!L && K < J))) {
                H = true;
                G()
            } else {
                if ((H == null || H == true) && ((L && K > J) || (!L && K > J))) {
                    H = false;
                    G()
                }
            }
        }, 250);
        return I
    }

    function d() {
        y.addCSS(".magic-hidden-wrapper, .magic-temporary-img", {
            display: "block !important",
            "min-height": "0 !important",
            "min-width": "0 !important",
            "max-height": "none !important",
            "max-width": "none !important",
            width: "10px !important",
            height: "10px !important",
            position: "absolute !important",
            top: "-10000px !important",
            left: "0 !important",
            overflow: "hidden !important",
            "-webkit-transform": "none !important",
            transform: "none !important",
            "-webkit-transition": "none !important",
            transition: "none !important"
        }, "magiczoom-reset-css");
        y.addCSS(".magic-temporary-img img", {
            display: "inline-block !important",
            border: "0 !important",
            padding: "0 !important",
            "min-height": "0 !important",
            "min-width": "0 !important",
            "max-height": "none !important",
            "max-width": "none !important",
            "-webkit-transform": "none !important",
            transform: "none !important",
            "-webkit-transition": "none !important",
            transition: "none !important"
        }, "magiczoom-reset-css");
        if (y.jBrowser.mobile && "android" == y.jBrowser.platform && !(y.jBrowser.chrome || y.jBrowser.opera)) {
            y.addCSS(".mobile-magic .mz-expand  .mz-expand-bg", {
                display: "none !important"
            }, "magiczoom-reset-css")
        }
    }
    var k = function(J, K, H, I, G) {
        this.small = {
            src: null,
            url: null,
            dppx: 1,
            node: null,
            state: 0,
            size: {
                width: 0,
                height: 0
            },
            loaded: false
        };
        this.zoom = {
            src: null,
            url: null,
            dppx: 1,
            node: null,
            state: 0,
            size: {
                width: 0,
                height: 0
            },
            loaded: false
        };
        if ("object" == y.jTypeOf(J)) {
            this.small = J
        } else {
            if ("string" == y.jTypeOf(J)) {
                this.small.url = y.getAbsoluteURL(J)
            }
        }
        if ("object" == y.jTypeOf(K)) {
            this.zoom = K
        } else {
            if ("string" == y.jTypeOf(K)) {
                this.zoom.url = y.getAbsoluteURL(K)
            }
        }
        this.caption = H;
        this.options = I;
        this.origin = G;
        this.callback = null;
        this.link = null;
        this.node = null
    };
    k.prototype = {
        parseNode: function(I, H, G) {
            var J = I.byTag("img")[0];
            if (G) {
                this.small.node = J
            }
            if (e > 1) {
                this.small.url = I.getAttribute("data-image-2x");
                if (this.small.url) {
                    this.small.dppx = 2
                }
                this.zoom.url = I.getAttribute("data-zoom-image-2x");
                if (this.zoom.url) {
                    this.zoom.dppx = 2
                }
            }
            this.small.src = I.getAttribute("data-image") || I.getAttribute("rev") || (J ? J.getAttribute("src") : null);
            if (this.small.src) {
                this.small.src = y.getAbsoluteURL(this.small.src)
            }
            this.small.url = this.small.url || this.small.src;
            if (this.small.url) {
                this.small.url = y.getAbsoluteURL(this.small.url)
            }
            this.zoom.src = I.getAttribute("data-zoom-image") || I.getAttribute("href");
            if (this.zoom.src) {
                this.zoom.src = y.getAbsoluteURL(this.zoom.src)
            }
            this.zoom.url = this.zoom.url || this.zoom.src;
            if (this.zoom.url) {
                this.zoom.url = y.getAbsoluteURL(this.zoom.url)
            }
            this.caption = I.getAttribute("data-caption") || I.getAttribute("title") || H;
            this.link = I.getAttribute("data-link");
            this.origin = I;
            return this
        },
        loadImg: function(G) {
            var H = null;
            if (arguments.length > 1 && "function" === y.jTypeOf(arguments[1])) {
                H = arguments[1]
            }
            if (0 !== this[G].state) {
                if (this[G].loaded) {
                    this.onload(H)
                }
                return
            }
            this[G].state = 1;
            new y.ImageLoader(this[G].node || this[G].url, {
                oncomplete: h(function(I) {
                    this[G].loaded = true;
                    this[G].state = I.ready ? 2 : -1;
                    if (I.ready) {
                        this[G].size = I.jGetSize();
                        if (!this[G].node) {
                            this[G].node = h(I.img);
                            this[G].node.removeAttribute("style");
                            this[G].size.width /= this[G].dppx;
                            this[G].size.height /= this[G].dppx
                        } else {
                            this[G].node.jSetCss({
                                "max-width": this[G].size.width,
                                "max-height": this[G].size.height
                            });
                            if (this[G].node.currentSrc && this[G].node.currentSrc != this[G].node.src) {
                                this[G].url = this[G].node.currentSrc
                            } else {
                                if (y.getAbsoluteURL(this[G].node.getAttribute("src") || "") != this[G].url) {
                                    this[G].node.setAttribute("src", this[G].url)
                                }
                            }
                        }
                    }
                    this.onload(H)
                }).jBind(this)
            })
        },
        loadSmall: function() {
            this.loadImg("small", arguments[0])
        },
        loadZoom: function() {
            this.loadImg("zoom", arguments[0])
        },
        load: function() {
            this.callback = null;
            if (arguments.length > 0 && "function" === y.jTypeOf(arguments[0])) {
                this.callback = arguments[0]
            }
            this.loadSmall();
            this.loadZoom()
        },
        onload: function(G) {
            if (G) {
                G.call(null, this)
            }
            if (this.callback && this.small.loaded && this.zoom.loaded) {
                this.callback.call(null, this);
                this.callback = null;
                return
            }
        },
        loaded: function() {
            return (this.small.loaded && this.zoom.loaded)
        },
        ready: function() {
            return (2 === this.small.state && 2 === this.zoom.state)
        },
        getURL: function(H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].url
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].url
                } else {
                    return null
                }
            }
        },
        getNode: function(H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].node
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].node
                } else {
                    return null
                }
            }
        },
        jGetSize: function(H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].size
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].size
                } else {
                    return {
                        width: 0,
                        height: 0
                    }
                }
            }
        },
        getRatio: function(H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].dppx
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].dppx
                } else {
                    return 1
                }
            }
        },
        setCurNode: function(G) {
            this.node = this.getNode(G)
        }
    };
    var j = function(H, G) {
        this.options = new y.Options(o);
        this.option = h(function() {
            if (arguments.length > 1) {
                return this.set(arguments[0], arguments[1])
            } else {
                return this.get(arguments[0])
            }
        }).jBind(this.options);
        this.touchOptions = new y.Options(l);
        this.additionalImages = [];
        this.image = null;
        this.primaryImage = null;
        this.placeholder = h(H).jAddEvent("dragstart selectstart click", function(I) {
            I.stop()
        });
        this.id = null;
        this.node = null;
        this.originalImg = null;
        this.originalImgSrc = null;
        this.originalTitle = null;
        this.normalSize = {
            width: 0,
            height: 0
        };
        this.size = {
            width: 0,
            height: 0
        };
        this.zoomSize = {
            width: 0,
            height: 0
        };
        this.zoomSizeOrigin = {
            width: 0,
            height: 0
        };
        this.boundaries = {
            top: 0,
            left: 0,
            bottom: 0,
            right: 0
        };
        this.ready = false;
        this.expanded = false;
        this.activateTimer = null;
        this.resizeTimer = null;
        this.resizeCallback = h(function() {
            if (this.expanded) {
                this.image.node.jSetCss({
                    "max-height": Math.min(this.image.jGetSize("zoom").height, this.expandMaxHeight())
                });
                this.image.node.jSetCss({
                    "max-width": Math.min(this.image.jGetSize("zoom").width, this.expandMaxWidth())
                })
            }
            this.reflowZoom(arguments[0])
        }).jBind(this);
        this.onResize = h(function(I) {
            clearTimeout(this.resizeTimer);
            this.resizeTimer = h(this.resizeCallback).jDelay(10, "scroll" === I.type)
        }).jBindAsEvent(this);
        this.lens = null;
        this.zoomBox = null;
        this.hint = null;
        this.hintMessage = null;
        this.hintRuns = 0;
        this.mobileZoomHint = true;
        this.loadingBox = null;
        this.loadTimer = null;
        this.thumb = null;
        this.expandBox = null;
        this.expandBg = null;
        this.expandCaption = null;
        this.expandStage = null;
        this.expandImageStage = null;
        this.expandFigure = null;
        this.expandControls = null;
        this.expandNav = null;
        this.expandThumbs = null;
        this.expandGallery = [];
        this.buttons = {};
        this.start(G)
    };
    j.prototype = {
        loadOptions: function(G) {
            this.options.fromJSON(window[B + "Options"] || {});
            this.options.fromString(this.placeholder.getAttribute("data-options") || "");
            if (y.jBrowser.mobile) {
                this.options.fromJSON(this.touchOptions.getJSON());
                this.options.fromJSON(window[B + "MobileOptions"] || {});
                this.options.fromString(this.placeholder.getAttribute("data-mobile-options") || "")
            }
            if ("string" == y.jTypeOf(G)) {
                this.options.fromString(G || "")
            } else {
                this.options.fromJSON(G || {})
            }
            if (this.option("cssClass")) {
                this.option("cssClass", this.option("cssClass").replace(",", " "))
            }
            if (false === this.option("zoomCaption")) {
                this.option("zoomCaption", "off")
            }
            if (false === this.option("hint")) {
                this.option("hint", "off")
            }
            switch (this.option("hint")) {
                case "off":
                    this.hintRuns = 0;
                    break;
                case "once":
                    this.hintRuns = 2;
                    break;
                case "always":
                    this.hintRuns = Infinity;
                    break
            }
            if ("off" === this.option("zoomMode")) {
                this.option("zoomMode", false)
            }
            if ("off" === this.option("expand")) {
                this.option("expand", false)
            }
            if ("off" === this.option("expandZoomMode")) {
                this.option("expandZoomMode", false)
            }
            if (E) {
                if ("zoom" == this.option("zoomMode")) {
                    this.option("zoomPosition", "inner")
                }
            }
            if (y.jBrowser.mobile && "zoom" == this.option("zoomMode") && "inner" == this.option("zoomPosition")) {
                if (E && this.option("expand")) {
                    this.option("zoomMode", false)
                } else {
                    this.option("zoomOn", "click")
                }
            }
        },
        start: function(H) {
            var G;
            this.loadOptions(H);
            if (x && !this.option("autostart")) {
                return
            }
            this.id = this.placeholder.getAttribute("id") || "mz-" + Math.floor(Math.random() * y.now());
            this.placeholder.setAttribute("id", this.id);
            this.node = y.$new("figure").jAddClass("mz-figure");
            C(this.placeholder);
            this.originalImg = this.placeholder.querySelector("img");
            this.originalImgSrc = this.originalImg ? this.originalImg.getAttribute("src") : null;
            this.originalTitle = h(this.placeholder).getAttribute("title");
            h(this.placeholder).removeAttribute("title");
            this.primaryImage = new k().parseNode(this.placeholder, this.originalTitle, true);
            this.image = this.primaryImage;
            this.node.enclose(this.image.small.node).jAddClass(this.option("cssClass"));
            if (true !== this.option("rightClick")) {
                this.node.jAddEvent("contextmenu", function(I) {
                    I.stop();
                    return false
                })
            }
            this.node.jAddClass("mz-" + this.option("zoomOn") + "-zoom");
            if (!this.option("expand")) {
                this.node.jAddClass("mz-no-expand")
            }
            this.lens = {
                node: y.$new("div", {
                    "class": "mz-lens"
                }, {
                    top: 0
                }).jAppendTo(this.node),
                image: y.$new("img", {
                    src: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                }, {
                    position: "absolute",
                    top: 0,
                    left: 0
                }),
                width: 0,
                height: 0,
                pos: {
                    x: 0,
                    y: 0
                },
                spos: {
                    x: 0,
                    y: 0
                },
                size: {
                    width: 0,
                    height: 0
                },
                border: {
                    x: 0,
                    y: 0
                },
                dx: 0,
                dy: 0,
                innertouch: false,
                hide: function() {
                    if (y.jBrowser.features.transform) {
                        this.node.jSetCss({
                            transform: "translate(-10000px,-10000px)"
                        })
                    } else {
                        this.node.jSetCss({
                            top: -10000
                        })
                    }
                }
            };
            this.lens.hide();
            this.lens.node.append(this.lens.image);
            this.zoomBox = {
                node: y.$new("div", {
                    "class": "mz-zoom-window"
                }, {
                    top: -100000
                }).jAddClass(this.option("cssClass")).jAppendTo(F),
                image: y.$new("img", {
                    src: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                }, {
                    position: "absolute"
                }),
                aspectRatio: 0,
                width: 0,
                height: 0,
                innerWidth: 0,
                innerHeight: 0,
                size: {
                    width: "auto",
                    wunits: "px",
                    height: "auto",
                    hunits: "px"
                },
                mode: this.option("zoomMode"),
                position: this.option("zoomPosition"),
                custom: false,
                active: false,
                activating: false,
                enabled: false,
                enable: h(function() {
                    this.zoomBox.enabled = false !== arguments[0];
                    this.node[this.zoomBox.enabled ? "jRemoveClass" : "jAddClass"]("mz-no-zoom")
                }).jBind(this),
                hide: h(function() {
                    var I = h(this.node).jFetch("cr");
                    this.zoomBox.node.jRemoveEvent("transitionend");
                    this.zoomBox.node.jSetCss({
                        top: -100000
                    }).jAppendTo(F);
                    this.zoomBox.node.jRemoveClass("mz-deactivating mz-p-" + ("zoom" == this.zoomBox.mode ? this.zoomBox.position : this.zoomBox.mode));
                    if (!this.expanded && I) {
                        I.jRemove()
                    }
                    this.zoomBox.image.removeAttribute("style")
                }).jBind(this),
                setMode: h(function(I) {
                    this.node[false === I ? "jAddClass" : "jRemoveClass"]("mz-no-zoom");
                    this.node["magnifier" == I ? "jAddClass" : "jRemoveClass"]("mz-magnifier-zoom");
                    this.zoomBox.node["magnifier" == I ? "jAddClass" : "jRemoveClass"]("mz-magnifier");
                    this.zoomBox.node["preview" == I ? "jAddClass" : "jRemoveClass"]("mz-preview");
                    if ("zoom" != I) {
                        this.node.jRemoveClass("mz-inner-zoom");
                        this.zoomBox.node.jRemoveClass("mz-inner")
                    }
                    this.zoomBox.mode = I;
                    if (false === I) {
                        this.zoomBox.enable(false)
                    } else {
                        if ("preview" === I) {
                            this.zoomBox.enable(true)
                        }
                    }
                }).jBind(this)
            };
            this.zoomBox.node.append(this.zoomBox.image);
            this.zoomBox.setMode(this.option("zoomMode"));
            this.zoomBox.image.removeAttribute("width");
            this.zoomBox.image.removeAttribute("height");
            if ("undefined" !== typeof(q)) {
                h(this.node).jStore("cr", y.$new(((Math.floor(Math.random() * 101) + 1) % 2) ? "span" : "div").jSetCss({
                    display: "none",
                    overflow: "hidden",
                    visibility: "visible",
                    color: q[1],
                    fontSize: q[2],
                    fontWeight: q[3],
                    fontFamily: "sans-serif",
                    position: "absolute",
                    top: 8,
                    left: 8,
                    margin: "auto",
                    width: "auto",
                    textAlign: "right",
                    "line-height": "2em",
                    zIndex: 2147483647
                }).changeContent(v(q[0])));
                if (h(h(this.node).jFetch("cr")).byTag("a")[0]) {
                    h(h(h(this.node).jFetch("cr")).byTag("a")[0]).jAddEvent("tap btnclick", function(I) {
                        I.stopDistribution();
                        window.open(this.href)
                    })
                }
            }
            if ((G = ("" + this.option("zoomWidth")).match(/^([0-9]+)?(px|%)?$/))) {
                this.zoomBox.size.wunits = G[2] || "px";
                this.zoomBox.size.width = (parseFloat(G[1]) || "auto")
            }
            if ((G = ("" + this.option("zoomHeight")).match(/^([0-9]+)?(px|%)?$/))) {
                this.zoomBox.size.hunits = G[2] || "px";
                this.zoomBox.size.height = (parseFloat(G[1]) || "auto")
            }
            if ("magnifier" == this.zoomBox.mode) {
                this.node.jAddClass("mz-magnifier-zoom");
                this.zoomBox.node.jAddClass("mz-magnifier");
                if ("auto" === this.zoomBox.size.width) {
                    this.zoomBox.size.wunits = "%";
                    this.zoomBox.size.width = 70
                }
                if ("auto" === this.zoomBox.size.height) {
                    this.zoomBox.size.hunits = "%"
                }
            } else {
                if (this.option("zoom-position").match(/^#/)) {
                    if (this.zoomBox.custom = h(this.option("zoom-position").replace(/^#/, ""))) {
                        if (h(this.zoomBox.custom).jGetSize().height > 50) {
                            if ("auto" === this.zoomBox.size.width) {
                                this.zoomBox.size.wunits = "%";
                                this.zoomBox.size.width = 100
                            }
                            if ("auto" === this.zoomBox.size.height) {
                                this.zoomBox.size.hunits = "%";
                                this.zoomBox.size.height = 100
                            }
                        }
                    } else {
                        this.option("zoom-position", "right")
                    }
                }
                if ("preview" == this.zoomBox.mode) {
                    if ("auto" === this.zoomBox.size.width) {
                        this.zoomBox.size.wunits = "px"
                    }
                    if ("auto" === this.zoomBox.size.height) {
                        this.zoomBox.size.hunits = "px"
                    }
                }
                if ("zoom" == this.zoomBox.mode) {
                    if ("auto" === this.zoomBox.size.width || "inner" == this.option("zoom-position")) {
                        this.zoomBox.size.wunits = "%";
                        this.zoomBox.size.width = 100
                    }
                    if ("auto" === this.zoomBox.size.height || "inner" == this.option("zoom-position")) {
                        this.zoomBox.size.hunits = "%";
                        this.zoomBox.size.height = 100
                    }
                }
                if ("inner" == this.option("zoom-position")) {
                    this.node.jAddClass("mz-inner-zoom")
                }
            }
            this.zoomBox.position = this.zoomBox.custom ? "custom" : this.option("zoom-position");
            this.lens.border.x = parseFloat(this.lens.node.jGetCss("border-left-width") || "0");
            this.lens.border.y = parseFloat(this.lens.node.jGetCss("border-top-width") || "0");
            this.image.loadSmall(function() {
                if (2 !== this.image.small.state) {
                    return
                }
                this.image.setCurNode("small");
                this.size = this.image.node.jGetSize();
                this.registerEvents();
                this.ready = true;
                if (true === this.option("lazyZoom")) {
                    this.showHint()
                }
            }.jBind(this));
            if (true !== this.option("lazyZoom") || "always" == this.option("zoomOn")) {
                this.image.load(h(function(I) {
                    this.setupZoom(I, true)
                }).jBind(this));
                this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
            }
            this.setupSelectors()
        },
        stop: function() {
            this.unregisterEvents();
            if (this.zoomBox) {
                this.zoomBox.node.kill()
            }
            if (this.expandThumbs) {
                this.expandThumbs.stop();
                this.expandThumbs = null
            }
            if (this.expandBox) {
                this.expandBox.kill()
            }
            if (this.expanded) {
                h(y.jBrowser.getDoc()).jSetCss({
                    overflow: ""
                })
            }
            h(this.additionalImages).jEach(function(G) {
                h(G.origin).jRemoveClass("mz-thumb-selected").jRemoveClass(this.option("cssClass") || "mz-$dummy-css-class-to-jRemove$")
            }, this);
            if (this.originalImg) {
                this.placeholder.append(this.originalImg);
                if (this.originalImgSrc) {
                    this.originalImg.setAttribute("src", this.originalImgSrc)
                }
            }
            if (this.originalTitle) {
                this.placeholder.setAttribute("title", this.originalTitle)
            }
            if (this.node) {
                this.node.kill()
            }
        },
        setupZoom: function(I, J) {
            var H = this.initEvent,
                G = this.image;
            this.initEvent = null;
            if (2 !== I.zoom.state) {
                this.image = I;
                this.ready = true;
                this.zoomBox.enable(false);
                return
            }
            this.image = I;
            this.image.setCurNode(this.expanded ? "zoom" : "small");
            this.zoomBox.image.src = this.image.getURL("zoom");
            this.zoomBox.node.jRemoveClass("mz-preview");
            this.zoomBox.image.removeAttribute("style");
            this.zoomBox.node.jGetSize();
            setTimeout(h(function() {
                var L = this.zoomBox.image.jGetSize(),
                    K;
                this.zoomSizeOrigin = this.image.jGetSize("zoom");
                if (L.width * L.height > 1 && L.width * L.height < this.zoomSizeOrigin.width * this.zoomSizeOrigin.height) {
                    this.zoomSizeOrigin = L
                }
                this.zoomSize = y.detach(this.zoomSizeOrigin);
                if ("preview" == this.zoomBox.mode) {
                    this.zoomBox.node.jAddClass("mz-preview")
                }
                this.setCaption();
                this.lens.image.src = this.image.node.currentSrc || this.image.node.src;
                this.zoomBox.enable(this.zoomBox.mode && !(this.expanded && "preview" == this.zoomBox.mode));
                this.ready = true;
                this.activateTimer = null;
                this.resizeCallback();
                this.node.jAddClass("mz-ready");
                this.hideLoading();
                if (G !== this.image) {
                    s("onUpdate", this.id, G.origin, this.image.origin);
                    if (this.nextImage) {
                        K = this.nextImage;
                        this.nextImage = null;
                        this.update(K.image, K.onswipe)
                    }
                } else {
                    s("onZoomReady", this.id)
                }
                if (H) {
                    this.node.jCallEvent(H.type, H)
                } else {
                    if (this.expanded && "always" == this.option("expandZoomOn")) {
                        this.activate()
                    } else {
                        if (!!J) {
                            this.showHint()
                        }
                    }
                }
            }).jBind(this), 256)
        },
        setupSelectors: function() {
            var H = this.id,
                G, I;
            I = new RegExp("zoom\\-id(\\s+)?:(\\s+)?" + H + "($|;)");
            if (y.jBrowser.features.query) {
                G = y.$A(document.querySelectorAll('[data-zoom-id="' + this.id + '"]'));
                G = h(G).concat(y.$A(document.querySelectorAll('[rel*="zoom-id"]')).filter(function(J) {
                    return I.test(J.getAttribute("rel") || "")
                }))
            } else {
                G = y.$A(document.getElementsByTagName("A")).filter(function(J) {
                    return H == J.getAttribute("data-zoom-id") || I.test(J.getAttribute("rel") || "")
                })
            }
            h(G).jEach(function(K) {
                var J, L;
                h(K).jAddEvent("click", function(M) {
                    M.stopDefaults()
                });
                J = new k().parseNode(K, this.originalTitle);
                if (this.image.zoom.src.has(J.zoom.src) && this.image.small.src.has(J.small.src)) {
                    h(J.origin).jAddClass("mz-thumb-selected");
                    J = this.image;
                    J.origin = K
                }
                if (!J.link && this.image.link) {
                    J.link = this.image.link
                }
                L = h(function() {
                    this.update(J)
                }).jBind(this);
                h(K).jAddEvent("mousedown", function(M) {
                    if ("stopImmediatePropagation" in M) {
                        M.stopImmediatePropagation()
                    }
                }, 5);
                h(K).jAddEvent("tap " + ("hover" == this.option("selectorTrigger") ? "mouseover mouseout" : "btnclick"), h(function(N, M) {
                    if (this.updateTimer) {
                        clearTimeout(this.updateTimer)
                    }
                    this.updateTimer = false;
                    if ("mouseover" == N.type) {
                        this.updateTimer = h(L).jDelay(M)
                    } else {
                        if ("tap" == N.type || "btnclick" == N.type) {
                            L()
                        }
                    }
                }).jBindAsEvent(this, 60)).jAddClass(this.option("cssClass")).jAddClass("mz-thumb");
                J.loadSmall();
                if (true !== this.option("lazyZoom")) {
                    J.loadZoom()
                }
                this.additionalImages.push(J)
            }, this)
        },
        update: function(G, H) {
            if (!this.ready) {
                this.nextImage = {
                    image: G,
                    onswipe: H
                };
                return
            }
            if (!G || G === this.image) {
                return false
            }
            this.deactivate(null, true);
            this.ready = false;
            this.node.jRemoveClass("mz-ready");
            this.loadTimer = h(this.showLoading).jBind(this).jDelay(400);
            G.load(h(function(O) {
                var I, P, N, K, J, M, L = (y.jBrowser.ieMode < 10) ? "jGetSize" : "getBoundingClientRect";
                this.hideLoading();
                O.setCurNode("small");
                if (!O.node) {
                    this.ready = true;
                    this.node.jAddClass("mz-ready");
                    return
                }
                this.setActiveThumb(O);
                I = this.image.node[L]();
                if (this.expanded) {
                    O.setCurNode("zoom");
                    N = y.$new("div").jAddClass("mz-expand-bg");
                    if (y.jBrowser.features.cssFilters || y.jBrowser.ieMode < 10) {
                        N.append(y.$new("img", {
                            src: O.getURL("zoom")
                        }).jSetCss({
                            opacity: 0
                        }))
                    } else {
                        N.append(new y.SVGImage(O.node).blur(b).getNode().jSetCss({
                            opacity: 0
                        }))
                    }
                    h(N).jSetCss({
                        "z-index": -99
                    }).jAppendTo(this.expandBox)
                }
                if (this.expanded && "zoom" === this.zoomBox.mode && "always" === this.option("expandZoomOn")) {
                    h(O.node).jSetCss({
                        opacity: 0
                    }).jAppendTo(this.node);
                    P = I;
                    J = [O.node, this.image.node];
                    M = [{
                        opacity: [0, 1]
                    }, {
                        opacity: [1, 0]
                    }]
                } else {
                    this.node.jSetCss({
                        height: this.node[L]().height
                    });
                    this.image.node.jSetCss({
                        position: "absolute",
                        top: 0,
                        left: 0,
                        bottom: 0,
                        right: 0,
                        width: "100%",
                        height: "100%",
                        "max-width": "",
                        "max-height": ""
                    });
                    h(O.node).jSetCss({
                        "max-width": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").width, this.expanded ? this.expandMaxWidth() : Infinity),
                        "max-height": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").height, this.expanded ? this.expandMaxHeight() : Infinity),
                        position: "relative",
                        top: 0,
                        left: 0,
                        opacity: 0,
                        transform: ""
                    }).jAppendTo(this.node);
                    P = h(O.node)[L]();
                    if (!H) {
                        h(O.node).jSetCss({
                            "min-width": I.width,
                            height: I.height,
                            "max-width": I.width,
                            "max-height": ""
                        })
                    }
                    this.node.jSetCss({
                        height: "",
                        overflow: ""
                    }).jGetSize();
                    h(O.node).jGetSize();
                    J = [O.node, this.image.node];
                    M = [y.extend({
                        opacity: [0, 1]
                    }, H ? {
                        scale: [0.6, 1]
                    } : {
                        "min-width": [I.width, P.width],
                        "max-width": [I.width, P.width],
                        height: [I.height, P.height]
                    }), {
                        opacity: [1, 0]
                    }]
                }
                if (this.expanded) {
                    if (this.expandBg.firstChild && N.firstChild) {
                        K = h(this.expandBg.firstChild).jGetCss("opacity");
                        J = J.concat([N.firstChild]);
                        M = M.concat([{
                            opacity: [0.0001, K]
                        }])
                    }
                }
                new y.PFX(J, {
                    duration: (H || this.option("transitionEffect")) ? H ? 400 : 350 : 0,
                    transition: H ? "cubic-bezier(0.175, 0.885, 0.320, 1.275)" : (I.width == P.width) ? "linear" : "cubic-bezier(0.25, .1, .1, 1)",
                    onComplete: h(function() {
                        this.image.node.jRemove().removeAttribute("style");
                        h(O.node).jSetCss(this.expanded ? {
                            width: "auto",
                            height: "auto"
                        } : {
                            width: "",
                            height: ""
                        }).jSetCss({
                            "min-width": "",
                            "min-height": "",
                            opacity: "",
                            "max-width": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").width, this.expanded ? this.expandMaxWidth() : Infinity),
                            "max-height": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").height, this.expanded ? this.expandMaxHeight() : Infinity)
                        });
                        if (this.expanded) {
                            this.expandBg.jRemove();
                            this.expandBg = undefined;
                            this.expandBg = N.jSetCssProp("z-index", -100);
                            h(this.expandBg.firstChild).jSetCss({
                                opacity: ""
                            });
                            if (this.expandCaption) {
                                if (O.caption) {
                                    if (O.link) {
                                        this.expandCaption.changeContent("").append(y.$new("a", {
                                            href: O.link
                                        }).jAddEvent("tap btnclick", this.openLink.jBind(this)).changeContent(O.caption))
                                    } else {
                                        this.expandCaption.changeContent(O.caption).jAddClass("mz-show")
                                    }
                                } else {
                                    this.expandCaption.jRemoveClass("mz-show")
                                }
                            }
                        }
                        this.setupZoom(O)
                    }).jBind(this),
                    onBeforeRender: h(function(Q, R) {
                        if (undefined !== Q.scale) {
                            R.jSetCssProp("transform", "scale(" + Q.scale + ")")
                        }
                    })
                }).start(M)
            }).jBind(this))
        },
        setActiveThumb: function(H) {
            var G = false;
            h(this.additionalImages).jEach(function(I) {
                h(I.origin).jRemoveClass("mz-thumb-selected");
                if (I === H) {
                    G = true
                }
            });
            if (G && H.origin) {
                h(H.origin).jAddClass("mz-thumb-selected")
            }
            if (this.expandThumbs) {
                this.expandThumbs.selectItem(H.selector)
            }
        },
        setCaption: function(G) {
            if (this.image.caption && "off" !== this.option("zoomCaption") && "magnifier" !== this.zoomBox.mode) {
                if (!this.zoomBox.caption) {
                    this.zoomBox.caption = y.$new("div", {
                        "class": "mz-caption"
                    }).jAppendTo(this.zoomBox.node.jAddClass("caption-" + this.option("zoomCaption")))
                }
                this.zoomBox.caption.changeContent(this.image.caption)
            }
        },
        showHint: function(G, I) {
            var H;
            if (!this.expanded) {
                if (this.hintRuns <= 0) {
                    return
                }
                this.hintRuns--
            }
            if (undefined === I) {
                if (!this.zoomBox.active && !this.zoomBox.activating) {
                    if (this.option("zoomMode")) {
                        if ("hover" == this.option("zoomOn")) {
                            I = this.option("textHoverZoomHint")
                        } else {
                            if ("click" == this.option("zoomOn")) {
                                I = this.option("textClickZoomHint")
                            }
                        }
                    } else {
                        I = this.option("expand") ? this.option("textExpandHint") : ""
                    }
                } else {
                    I = this.option("expand") ? this.option("textExpandHint") : ""
                }
            }
            if (!I) {
                this.hideHint();
                return
            }
            H = this.node;
            if (!this.hint) {
                this.hint = y.$new("div", {
                    "class": "mz-hint"
                });
                this.hintMessage = y.$new("span", {
                    "class": "mz-hint-message"
                }).append(document.createTextNode(I)).jAppendTo(this.hint);
                h(this.hint).jAppendTo(this.node)
            } else {
                h(this.hintMessage).changeContent(I)
            }
            this.hint.jSetCss({
                "transition-delay": ""
            }).jRemoveClass("mz-hint-hidden");
            if (this.expanded) {
                H = this.expandFigure
            } else {
                if ((this.zoomBox.active || this.zoomBox.activating) && "magnifier" !== this.zoomBox.mode && "inner" == this.zoomBox.position) {
                    H = this.zoomBox.node
                }
            }
            if (true === G) {
                setTimeout(h(function() {
                    this.hint.jAddClass("mz-hint-hidden")
                }).jBind(this), 16)
            }
            this.hint.jAppendTo(H)
        },
        hideHint: function() {
            if (this.hint) {
                this.hint.jSetCss({
                    "transition-delay": "0ms"
                }).jAddClass("mz-hint-hidden")
            }
        },
        showLoading: function() {
            if (!this.loadingBox) {
                this.loadingBox = y.$new("div", {
                    "class": "mz-loading"
                });
                this.node.append(this.loadingBox);
                this.loadingBox.jGetSize()
            }
            this.loadingBox.jAddClass("shown")
        },
        hideLoading: function() {
            clearTimeout(this.loadTimer);
            this.loadTimer = null;
            if (this.loadingBox) {
                h(this.loadingBox).jRemoveClass("shown")
            }
        },
        setSize: function(I, M) {
            var L = y.detach(this.zoomBox.size),
                K = (!this.expanded && this.zoomBox.custom) ? h(this.zoomBox.custom).jGetSize() : {
                    width: 0,
                    height: 0
                },
                H, G, J = this.size,
                N = {
                    x: 0,
                    y: 0
                };
            M = M || this.zoomBox.position;
            this.normalSize = this.image.node.jGetSize();
            this.size = this.image.node.jGetSize();
            this.boundaries = this.image.node.getBoundingClientRect();
            if (!K.height) {
                K = this.size
            }
            if (false === this.option("upscale") || false === this.zoomBox.mode || "preview" === this.zoomBox.mode) {
                I = false
            }
            if ("preview" == this.zoomBox.mode) {
                if ("auto" === L.width) {
                    L.width = this.zoomSizeOrigin.width
                }
                if ("auto" === L.height) {
                    L.height = this.zoomSizeOrigin.height
                }
            }
            if (this.expanded && "magnifier" == this.zoomBox.mode) {
                L.width = 70;
                L.height = "auto"
            }
            if ("magnifier" == this.zoomBox.mode && "auto" === L.height) {
                this.zoomBox.width = parseFloat(L.width / 100) * Math.min(K.width, K.height);
                this.zoomBox.height = this.zoomBox.width
            } else {
                if ("zoom" == this.zoomBox.mode && "inner" == M) {
                    this.size = this.node.jGetSize();
                    K = this.size;
                    this.boundaries = this.node.getBoundingClientRect();
                    this.zoomBox.width = K.width;
                    this.zoomBox.height = K.height
                } else {
                    this.zoomBox.width = ("%" === L.wunits) ? parseFloat(L.width / 100) * K.width : parseInt(L.width);
                    this.zoomBox.height = ("%" === L.hunits) ? parseFloat(L.height / 100) * K.height : parseInt(L.height)
                }
            }
            if ("preview" == this.zoomBox.mode) {
                G = Math.min(Math.min(this.zoomBox.width / this.zoomSizeOrigin.width, this.zoomBox.height / this.zoomSizeOrigin.height), 1);
                this.zoomBox.width = this.zoomSizeOrigin.width * G;
                this.zoomBox.height = this.zoomSizeOrigin.height * G
            }
            this.zoomBox.width = Math.ceil(this.zoomBox.width);
            this.zoomBox.height = Math.ceil(this.zoomBox.height);
            this.zoomBox.aspectRatio = this.zoomBox.width / this.zoomBox.height;
            this.zoomBox.node.jSetCss({
                width: this.zoomBox.width,
                height: this.zoomBox.height
            });
            if (I) {
                K = this.expanded ? this.expandBox.jGetSize() : this.zoomBox.node.jGetSize();
                if (!this.expanded && (this.normalSize.width * this.normalSize.height) / (this.zoomSizeOrigin.width * this.zoomSizeOrigin.height) > 0.8) {
                    this.zoomSize.width = 1.5 * this.zoomSizeOrigin.width;
                    this.zoomSize.height = 1.5 * this.zoomSizeOrigin.height
                } else {
                    this.zoomSize = y.detach(this.zoomSizeOrigin)
                }
            }
            if (!this.zoomBox.active && I && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ((this.normalSize.width * this.normalSize.height) / (this.zoomSize.width * this.zoomSize.height) > 0.8) {
                    this.zoomSize = y.detach(this.zoomSizeOrigin);
                    this.zoomBox.enable(false)
                } else {
                    this.zoomBox.enable(true)
                }
            }
            this.zoomBox.image.jSetCss({
                width: this.zoomSize.width,
                height: this.zoomSize.height
            });
            H = this.zoomBox.node.getInnerSize();
            this.zoomBox.innerWidth = Math.ceil(H.width);
            this.zoomBox.innerHeight = Math.ceil(H.height);
            this.lens.width = Math.ceil(this.zoomBox.innerWidth / (this.zoomSize.width / this.size.width));
            this.lens.height = Math.ceil(this.zoomBox.innerHeight / (this.zoomSize.height / this.size.height));
            this.lens.node.jSetCss({
                width: this.lens.width,
                height: this.lens.height
            });
            this.lens.image.jSetCss(this.size);
            y.extend(this.lens, this.lens.node.jGetSize());
            if (this.zoomBox.active) {
                clearTimeout(this.moveTimer);
                this.moveTimer = null;
                if (this.lens.innertouch) {
                    this.lens.pos.x *= (this.size.width / J.width);
                    this.lens.pos.y *= (this.size.height / J.height);
                    N.x = this.lens.spos.x;
                    N.y = this.lens.spos.y
                } else {
                    N.x = this.boundaries.left + this.lens.width / 2 + (this.lens.pos.x * (this.size.width / J.width));
                    N.y = this.boundaries.top + this.lens.height / 2 + (this.lens.pos.y * (this.size.height / J.height))
                }
                this.animate(null, N)
            }
        },
        reflowZoom: function(K) {
            var N, M, G, L, J, I, H = h(this.node).jFetch("cr");
            G = a(5);
            J = this.zoomBox.position;
            L = this.expanded ? "inner" : this.zoomBox.custom ? "custom" : this.option("zoom-position");
            I = this.expanded && "zoom" == this.zoomBox.mode ? this.expandBox : document.body;
            if (this.expanded) {
                G.y = 0;
                G.x = 0
            }
            if (!K) {
                this.setSize(true, L)
            }
            if (!this.zoomBox.activating && !this.zoomBox.active) {
                return
            }
            N = this.boundaries.top;
            if ("magnifier" !== this.zoomBox.mode) {
                if (K) {
                    this.setSize(false);
                    return
                }
                switch (L) {
                    case "inner":
                    case "custom":
                        N = 0;
                        M = 0;
                        break;
                    case "top":
                        N = this.boundaries.top - this.zoomBox.height - this.option("zoom-distance");
                        if (G.top > N) {
                            N = this.boundaries.bottom + this.option("zoom-distance");
                            L = "bottom"
                        }
                        M = this.boundaries.left;
                        break;
                    case "bottom":
                        N = this.boundaries.bottom + this.option("zoom-distance");
                        if (G.bottom < N + this.zoomBox.height) {
                            N = this.boundaries.top - this.zoomBox.height - this.option("zoom-distance");
                            L = "top"
                        }
                        M = this.boundaries.left;
                        break;
                    case "left":
                        M = this.boundaries.left - this.zoomBox.width - this.option("zoom-distance");
                        if (G.left > M && G.right >= this.boundaries.right + this.option("zoom-distance") + this.zoomBox.width) {
                            M = this.boundaries.right + this.option("zoom-distance");
                            L = "right"
                        }
                        break;
                    case "right":
                    default:
                        M = this.boundaries.right + this.option("zoom-distance");
                        if (G.right < M + this.zoomBox.width && G.left <= this.boundaries.left - this.zoomBox.width - this.option("zoom-distance")) {
                            M = this.boundaries.left - this.zoomBox.width - this.option("zoom-distance");
                            L = "left"
                        }
                        break
                }
                switch (this.option("zoom-position")) {
                    case "top":
                    case "bottom":
                        if (G.top > N || G.bottom < N + this.zoomBox.height) {
                            L = "inner"
                        }
                        break;
                    case "left":
                    case "right":
                        if (G.left > M || G.right < M + this.zoomBox.width) {
                            L = "inner"
                        }
                        break
                }
                this.zoomBox.position = L;
                this.setSize(false);
                if (K) {
                    return
                }
                if ("custom" == L) {
                    I = this.zoomBox.custom;
                    G.y = 0;
                    G.x = 0
                }
                if ("inner" == L) {
                    if ("preview" !== this.zoomBox.mode) {
                        this.zoomBox.node.jAddClass("mz-inner");
                        this.node.jAddClass("mz-inner-zoom")
                    }
                    this.lens.hide();
                    N = this.boundaries.top + G.y;
                    M = this.boundaries.left + G.x;
                    if (!this.expanded && y.jBrowser.ieMode && y.jBrowser.ieMode < 11) {
                        N = 0;
                        M = 0;
                        I = this.node
                    }
                } else {
                    N += G.y;
                    M += G.x;
                    this.node.jRemoveClass("mz-inner-zoom");
                    this.zoomBox.node.jRemoveClass("mz-inner")
                }
                this.zoomBox.node.jSetCss({
                    top: N,
                    left: M
                })
            } else {
                this.setSize(false);
                if (y.jBrowser.ieMode && y.jBrowser.ieMode < 11) {
                    I = this.node
                }
            }
            this.zoomBox.node[this.expanded ? "jAddClass" : "jRemoveClass"]("mz-expanded");
            if (!this.expanded && H) {
                H.jAppendTo("zoom" == this.zoomBox.mode && "inner" == L ? this.zoomBox.node : this.node, ((Math.floor(Math.random() * 101) + 1) % 2) ? "top" : "bottom")
            }
            this.zoomBox.node.jAppendTo(I)
        },
        changeZoomLevel: function(M) {
            var I, G, K, J, L = false,
                H = M.isMouse ? 5 : 3 / 54;
            h(M).stop();
            H = (100 + H * Math.abs(M.deltaY)) / 100;
            if (M.deltaY < 0) {
                H = 1 / H
            }
            if ("magnifier" == this.zoomBox.mode) {
                G = Math.max(100, Math.round(this.zoomBox.width * H));
                G = Math.min(G, this.size.width * 0.9);
                K = G / this.zoomBox.aspectRatio;
                this.zoomBox.width = Math.ceil(G);
                this.zoomBox.height = Math.ceil(K);
                this.zoomBox.node.jSetCss({
                    width: this.zoomBox.width,
                    height: this.zoomBox.height
                });
                I = this.zoomBox.node.getInnerSize();
                this.zoomBox.innerWidth = Math.ceil(I.width);
                this.zoomBox.innerHeight = Math.ceil(I.height);
                L = true
            } else {
                if (!this.expanded && "zoom" == this.zoomBox.mode) {
                    G = Math.max(50, Math.round(this.lens.width * H));
                    G = Math.min(G, this.size.width * 0.9);
                    K = G / this.zoomBox.aspectRatio;
                    this.zoomSize.width = Math.ceil((this.zoomBox.innerWidth / G) * this.size.width);
                    this.zoomSize.height = Math.ceil((this.zoomBox.innerHeight / K) * this.size.height);
                    this.zoomBox.image.jSetCss({
                        width: this.zoomSize.width,
                        height: this.zoomSize.height
                    })
                } else {
                    return
                }
            }
            J = h(window).jGetScroll();
            this.lens.width = Math.ceil(this.zoomBox.innerWidth / (this.zoomSize.width / this.size.width));
            this.lens.height = Math.ceil(this.zoomBox.innerHeight / (this.zoomSize.height / this.size.height));
            this.lens.node.jSetCss({
                width: this.lens.width,
                height: this.lens.height
            });
            y.extend(this.lens, this.lens.node.jGetSize());
            if (this.zoomBox.active) {
                clearTimeout(this.moveTimer);
                this.moveTimer = null;
                if (L) {
                    this.moveTimer = true
                }
                this.animate(null, {
                    x: M.x - J.x,
                    y: M.y - J.y
                });
                if (L) {
                    this.moveTimer = null
                }
            }
        },
        registerActivateEvent: function(I) {
            var H, G = I ? "dbltap btnclick" : "touchstart" + (!y.jBrowser.mobile ? (window.navigator.pointerEnabled ? " pointermove" : window.navigator.msPointerEnabled ? " MSPointerMove" : " mousemove") : ""),
                J = this.node.jFetch("mz:handlers:activate:fn", (!I) ? h(function(K) {
                    H = (y.jBrowser.ieMode < 9) ? y.extend({}, K) : K;
                    if (!this.activateTimer) {
                        clearTimeout(this.activateTimer);
                        this.activateTimer = setTimeout(h(function() {
                            this.activate(H)
                        }).jBind(this), 120)
                    }
                }).jBindAsEvent(this) : h(this.activate).jBindAsEvent(this));
            this.node.jStore("mz:handlers:activate:event", G).jAddEvent(G, J, 10)
        },
        unregisterActivateEvent: function(H) {
            var G = this.node.jFetch("mz:handlers:activate:event"),
                I = this.node.jFetch("mz:handlers:activate:fn");
            this.node.jRemoveEvent(G, I);
            this.node.jDel("mz:handlers:activate:fn")
        },
        registerDeactivateEvent: function(H) {
            var G = H ? "dbltap btnclick" : "touchend" + (!y.jBrowser.mobile ? (window.navigator.pointerEnabled ? " pointerout" : window.navigator.msPointerEnabled ? " MSPointerOut" : " mouseout") : ""),
                I = this.node.jFetch("mz:handlers:deactivate:fn", h(function(J) {
                    if (c(J) && !g(J)) {
                        return
                    }
                    if (this.zoomBox.node !== J.getRelated() && !(("inner" == this.zoomBox.position || "magnifier" == this.zoomBox.mode) && this.zoomBox.node.hasChild(J.getRelated())) && !this.node.hasChild(J.getRelated())) {
                        this.deactivate(J)
                    }
                }).jBindAsEvent(this));
            this.node.jStore("mz:handlers:deactivate:event", G).jAddEvent(G, I, 20)
        },
        unregisterDeactivateEvent: function() {
            var G = this.node.jFetch("mz:handlers:deactivate:event"),
                H = this.node.jFetch("mz:handlers:deactivate:fn");
            this.node.jRemoveEvent(G, H);
            this.node.jDel("mz:handlers:deactivate:fn")
        },
        registerEvents: function() {
            this.moveBind = this.move.jBind(this);
            this.node.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], h(function(G) {
                if (!this.zoomBox.active) {
                    return
                }
                if ("inner" === this.zoomBox.position) {
                    this.lens.spos = G.getClientXY()
                }
            }).jBindAsEvent(this), 10);
            this.node.jAddEvent(["touchmove", window.navigator.pointerEnabled ? "pointermove" : window.navigator.msPointerEnabled ? "MSPointerMove" : "mousemove"], h(this.animate).jBindAsEvent(this));
            if (this.option("zoomMode")) {
                this.registerActivateEvent("click" === this.option("zoomOn"));
                this.registerDeactivateEvent("click" === this.option("zoomOn") && !this.option("expand"))
            }
            this.node.jAddEvent("mousedown", function(G) {
                G.stopDistribution()
            }, 10).jAddEvent("btnclick", h(function(G) {
                this.jRaiseEvent("MouseEvent", "click")
            }).jBind(this.node), 15);
            if (this.option("expand")) {
                this.node.jAddEvent("tap btnclick", h(this.expand).jBindAsEvent(this), 15)
            } else {
                this.node.jAddEvent("tap btnclick", h(this.openLink).jBindAsEvent(this), 15)
            }
            if (this.additionalImages.length > 1) {
                this.swipe()
            }
            if (!y.jBrowser.mobile && this.option("variableZoom")) {
                this.node.jAddEvent("mousescroll", this.changeZoomLevel.jBindAsEvent(this))
            }
            h(window).jAddEvent("resize scroll", this.onResize)
        },
        unregisterEvents: function() {
            if (this.node) {
                this.node.jRemoveEvent("mousescroll")
            }
            h(window).jRemoveEvent("resize scroll", this.onResize);
            h(this.additionalImages).jEach(function(G) {
                h(G.origin).jClearEvents()
            })
        },
        activate: function(M) {
            var N, L, J, K, G, H = 0,
                I = 0;
            if (!this.ready || !this.zoomBox.enabled || this.zoomBox.active || this.zoomBox.activating) {
                if (!this.image.loaded()) {
                    if (M) {
                        this.initEvent = y.extend({}, M);
                        M.stopQueue()
                    }
                    this.image.load(this.setupZoom.jBind(this));
                    if (!this.loadTimer) {
                        this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
                    }
                }
                return
            }
            if (M && "pointermove" == M.type && "touch" == M.pointerType) {
                return
            }
            if (!this.option("zoomMode") && this.option("expand") && !this.expanded) {
                this.zoomBox.active = true;
                return
            }
            this.zoomBox.activating = true;
            if (this.expanded && "zoom" == this.zoomBox.mode) {
                K = this.image.node.jGetRect();
                this.expandStage.jAddClass("mz-zoom-in");
                G = this.expandFigure.jGetRect();
                I = ((K.left + K.right) / 2 - (G.left + G.right) / 2);
                H = ((K.top + K.bottom) / 2 - (G.top + G.bottom) / 2)
            }
            this.zoomBox.image.jRemoveEvent("transitionend");
            this.zoomBox.node.jRemoveClass("mz-deactivating").jRemoveEvent("transitionend");
            this.zoomBox.node.jAddClass("mz-activating");
            this.node.jAddClass("mz-activating");
            this.reflowZoom();
            L = ("zoom" == this.zoomBox.mode) ? this.zoomBox.position : this.zoomBox.mode;
            if (y.jBrowser.features.transition && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ("inner" == L) {
                    J = this.image.node.jGetSize();
                    this.zoomBox.image.jSetCss({
                        transform: "translate3d(0," + H + "px, 0) scale(" + J.width / this.zoomSize.width + ", " + J.height / this.zoomSize.height + ")"
                    }).jGetSize();
                    this.zoomBox.image.jAddEvent("transitionend", h(function() {
                        this.zoomBox.image.jRemoveEvent("transitionend");
                        this.zoomBox.node.jRemoveClass("mz-activating mz-p-" + L);
                        this.zoomBox.activating = false;
                        this.zoomBox.active = true
                    }).jBind(this));
                    this.zoomBox.node.jAddClass("mz-p-" + L).jGetSize();
                    if (y.jBrowser.chrome && ("chrome" === y.jBrowser.uaName || "opera" === y.jBrowser.uaName)) {
                        this.zoomBox.activating = false;
                        this.zoomBox.active = true
                    }
                } else {
                    this.zoomBox.node.jAddEvent("transitionend", h(function() {
                        this.zoomBox.node.jRemoveEvent("transitionend");
                        this.zoomBox.node.jRemoveClass("mz-activating mz-p-" + L)
                    }).jBind(this));
                    this.zoomBox.node.jAddClass("mz-p-" + L).jGetSize();
                    this.zoomBox.node.jRemoveClass("mz-p-" + L);
                    this.zoomBox.activating = false;
                    this.zoomBox.active = true
                }
            } else {
                this.zoomBox.node.jRemoveClass("mz-activating");
                this.zoomBox.activating = false;
                this.zoomBox.active = true
            }
            if (!this.expanded) {
                this.showHint(true)
            }
            if (M) {
                M.stop().stopQueue();
                N = M.getClientXY();
                if ("magnifier" == this.zoomBox.mode && (/tap/i).test(M.type)) {
                    N.y -= this.zoomBox.height / 2 + 10
                }
                if ("inner" == L && ((/tap/i).test(M.type) || c(M))) {
                    this.lens.pos = {
                        x: 0,
                        y: 0
                    };
                    N.x = -(N.x - this.boundaries.left - this.size.width / 2) * (this.zoomSize.width / this.size.width);
                    N.y = -(N.y - this.boundaries.top - this.size.height / 2) * (this.zoomSize.height / this.size.height)
                }
            } else {
                N = {
                    x: this.boundaries.left + (this.boundaries.right - this.boundaries.left) / 2,
                    y: this.boundaries.top + (this.boundaries.bottom - this.boundaries.top) / 2
                }
            }
            this.node.jRemoveClass("mz-activating").jAddClass("mz-active");
            N.x += -I;
            N.y += -H;
            this.lens.spos = {
                x: 0,
                y: 0
            };
            this.lens.dx = 0;
            this.lens.dy = 0;
            this.animate(M, N, true);
            s("onZoomIn", this.id)
        },
        deactivate: function(I, N) {
            var L, J, G, H, K = 0,
                M = 0,
                O = this.zoomBox.active;
            this.initEvent = null;
            if (!this.ready) {
                return
            }
            if (I && "pointerout" == I.type && "touch" == I.pointerType) {
                return
            }
            clearTimeout(this.moveTimer);
            this.moveTimer = null;
            clearTimeout(this.activateTimer);
            this.activateTimer = null;
            this.zoomBox.activating = false;
            this.zoomBox.active = false;
            if (true !== N && !this.expanded) {
                if (O) {
                    this.showHint()
                }
            }
            if (!this.zoomBox.enabled) {
                return
            }
            if (I) {
                I.stop()
            }
            this.zoomBox.image.jRemoveEvent("transitionend");
            this.zoomBox.node.jRemoveClass("mz-activating").jRemoveEvent("transitionend");
            if (this.expanded) {
                H = this.expandFigure.jGetRect();
                if ("always" !== this.option("expandZoomOn")) {
                    this.expandStage.jRemoveClass("mz-zoom-in")
                }
                this.image.node.jSetCss({
                    "max-height": this.expandMaxHeight()
                });
                G = this.image.node.jGetRect();
                M = ((G.left + G.right) / 2 - (H.left + H.right) / 2);
                K = ((G.top + G.bottom) / 2 - (H.top + H.bottom) / 2)
            }
            L = ("zoom" == this.zoomBox.mode) ? this.zoomBox.position : this.zoomBox.mode;
            if (y.jBrowser.features.transition && I && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ("inner" == L) {
                    this.zoomBox.image.jAddEvent("transitionend", h(function() {
                        this.zoomBox.image.jRemoveEvent("transitionend");
                        this.node.jRemoveClass("mz-active");
                        setTimeout(h(function() {
                            this.zoomBox.hide()
                        }).jBind(this), 32)
                    }).jBind(this));
                    J = this.image.node.jGetSize();
                    this.zoomBox.node.jAddClass("mz-deactivating mz-p-" + L).jGetSize();
                    this.zoomBox.image.jSetCss({
                        transform: "translate3d(0," + K + "px,0) scale(" + J.width / this.zoomSize.width + ", " + J.height / this.zoomSize.height + ")"
                    })
                } else {
                    this.zoomBox.node.jAddEvent("transitionend", h(function() {
                        this.zoomBox.hide();
                        this.node.jRemoveClass("mz-active")
                    }).jBind(this));
                    this.zoomBox.node.jGetCss("opacity");
                    this.zoomBox.node.jAddClass("mz-deactivating mz-p-" + L);
                    this.node.jRemoveClass("mz-active")
                }
            } else {
                this.zoomBox.hide();
                this.node.jRemoveClass("mz-active")
            }
            this.lens.dx = 0;
            this.lens.dy = 0;
            this.lens.spos = {
                x: 0,
                y: 0
            };
            this.lens.hide();
            if (O) {
                s("onZoomOut", this.id)
            }
        },
        animate: function(Q, P, O) {
            var I = P,
                K, J, M = 0,
                H, L = 0,
                G, R, N = false;
            if (this.initEvent && !this.image.loaded()) {
                this.initEvent = Q
            }
            if (!this.zoomBox.active && !O) {
                return
            }
            if (Q) {
                h(Q).stopDefaults();
                if (c(Q) && !g(Q)) {
                    return
                }
                N = (/tap/i).test(Q.type) || c(Q);
                this.lens.touchmovement = N;
                if (!I) {
                    I = Q.getClientXY()
                }
            }
            if ("preview" == this.zoomBox.mode) {
                return
            }
            if ("zoom" == this.zoomBox.mode && "inner" === this.zoomBox.position && (Q && N || !Q && this.lens.innertouch)) {
                this.lens.innertouch = true;
                K = this.lens.pos.x + (I.x - this.lens.spos.x);
                J = this.lens.pos.y + (I.y - this.lens.spos.y);
                this.lens.spos = I;
                M = Math.min(0, this.zoomBox.innerWidth - this.zoomSize.width) / 2;
                H = -M;
                L = Math.min(0, this.zoomBox.innerHeight - this.zoomSize.height) / 2;
                G = -L
            } else {
                this.lens.innertouch = false;
                K = I.x - this.boundaries.left;
                J = I.y - this.boundaries.top;
                H = this.size.width - this.lens.width;
                G = this.size.height - this.lens.height;
                K -= this.lens.width / 2;
                J -= this.lens.height / 2
            }
            if ("magnifier" !== this.zoomBox.mode) {
                K = Math.max(M, Math.min(K, H));
                J = Math.max(L, Math.min(J, G))
            }
            this.lens.pos.x = K = Math.round(K);
            this.lens.pos.y = J = Math.round(J);
            if ("zoom" == this.zoomBox.mode && "inner" != this.zoomBox.position) {
                if (y.jBrowser.features.transform) {
                    this.lens.node.jSetCss({
                        transform: "translate(" + this.lens.pos.x + "px," + this.lens.pos.y + "px)"
                    });
                    this.lens.image.jSetCss({
                        transform: "translate(" + -(this.lens.pos.x + this.lens.border.x) + "px, " + -(this.lens.pos.y + this.lens.border.y) + "px)"
                    })
                } else {
                    this.lens.node.jSetCss({
                        top: this.lens.pos.y,
                        left: this.lens.pos.x
                    });
                    this.lens.image.jSetCss({
                        top: -(this.lens.pos.y + this.lens.border.y),
                        left: -(this.lens.pos.x + this.lens.border.x)
                    })
                }
            }
            if ("magnifier" == this.zoomBox.mode) {
                if (this.lens.touchmovement && !(Q && "dbltap" == Q.type)) {
                    I.y -= this.zoomBox.height / 2 + 10
                }
                R = h(window).jGetScroll();
                this.zoomBox.node.jSetCss((y.jBrowser.ieMode && y.jBrowser.ieMode < 11) ? {
                    top: I.y - this.boundaries.top - this.zoomBox.height / 2,
                    left: I.x - this.boundaries.left - this.zoomBox.width / 2
                } : {
                    top: I.y + R.y - this.zoomBox.height / 2,
                    left: I.x + R.x - this.zoomBox.width / 2
                })
            }
            if (!this.moveTimer) {
                this.lens.dx = 0;
                this.lens.dy = 0;
                this.move(1)
            }
        },
        move: function(I) {
            var H, G;
            if (!isFinite(I)) {
                I = this.lens.innertouch ? 0.2 : 0.1
            }
            H = ((this.lens.pos.x - this.lens.dx) * I);
            G = ((this.lens.pos.y - this.lens.dy) * I);
            this.lens.dx += H;
            this.lens.dy += G;
            if (!this.moveTimer || Math.abs(H) > 0.000001 || Math.abs(G) > 0.000001) {
                this.zoomBox.image.jSetCss(y.jBrowser.features.transform ? {
                    transform: f + (this.lens.innertouch ? this.lens.dx : -(this.lens.dx * (this.zoomSize.width / this.size.width) - Math.max(0, this.zoomSize.width - this.zoomBox.innerWidth) / 2)) + "px," + (this.lens.innertouch ? this.lens.dy : -(this.lens.dy * (this.zoomSize.height / this.size.height) - Math.max(0, this.zoomSize.height - this.zoomBox.innerHeight) / 2)) + "px" + A + " scale(1)"
                } : {
                    left: -(this.lens.dx * (this.zoomSize.width / this.size.width) + Math.min(0, this.zoomSize.width - this.zoomBox.innerWidth) / 2),
                    top: -(this.lens.dy * (this.zoomSize.height / this.size.height) + Math.min(0, this.zoomSize.height - this.zoomBox.innerHeight) / 2)
                })
            }
            if ("magnifier" == this.zoomBox.mode) {
                return
            }
            this.moveTimer = setTimeout(this.moveBind, 16)
        },
        swipe: function() {
            var S, I, N = 30,
                K = 201,
                P, Q = "",
                H = {},
                G, M, R = 0,
                T = {
                    transition: y.jBrowser.cssTransform + String.fromCharCode(32) + "300ms cubic-bezier(.18,.35,.58,1)"
                },
                J, O, L = h(function(U) {
                    if (!this.ready || this.zoomBox.active) {
                        return
                    }
                    if (U.state == "dragstart") {
                        clearTimeout(this.activateTimer);
                        this.activateTimer = null;
                        R = 0;
                        H = {
                            x: U.x,
                            y: U.y,
                            ts: U.timeStamp
                        };
                        S = this.size.width;
                        I = S / 2;
                        this.image.node.jRemoveEvent("transitionend");
                        this.image.node.jSetCssProp("transition", "");
                        this.image.node.jSetCssProp("transform", "translate3d(0, 0, 0)");
                        O = null
                    } else {
                        G = (U.x - H.x);
                        M = {
                            x: 0,
                            y: 0,
                            z: 0
                        };
                        if (null === O) {
                            O = (Math.abs(U.x - H.x) < Math.abs(U.y - H.y))
                        }
                        if (O) {
                            return
                        }
                        U.stop();
                        if ("dragend" == U.state) {
                            R = 0;
                            J = null;
                            P = U.timeStamp - H.ts;
                            if (Math.abs(G) > I || (P < K && Math.abs(G) > N)) {
                                if ((Q = (G > 0) ? "backward" : (G <= 0) ? "forward" : "")) {
                                    if (Q == "backward") {
                                        J = this.getPrev();
                                        R += S * 10
                                    } else {
                                        J = this.getNext();
                                        R -= S * 10
                                    }
                                }
                            }
                            M.x = R;
                            M.deg = -90 * (M.x / S);
                            this.image.node.jAddEvent("transitionend", h(function(V) {
                                this.image.node.jRemoveEvent("transitionend");
                                this.image.node.jSetCssProp("transition", "");
                                if (J) {
                                    this.image.node.jSetCss({
                                        transform: "translate3d(" + M.x + "px, 0px, 0px)"
                                    });
                                    this.update(J, true)
                                }
                            }).jBind(this));
                            this.image.node.jSetCss(T);
                            this.image.node.jSetCss({
                                "transition-duration": M.x ? "100ms" : "300ms",
                                opacity: 1 - 0.7 * Math.abs(M.x / S),
                                transform: "translate3d(" + M.x + "px, 0px, 0px)"
                            });
                            G = 0;
                            return
                        }
                        M.x = G;
                        M.z = -50 * Math.abs(M.x / I);
                        M.deg = -60 * (M.x / I);
                        this.image.node.jSetCss({
                            opacity: 1 - 0.7 * Math.abs(M.x / I),
                            transform: "translate3d(" + M.x + "px, 0px, " + M.z + "px)"
                        })
                    }
                }).jBind(this);
            this.node.jAddEvent("touchdrag", L)
        },
        setupExpandGallery: function() {
            var H, G;
            if (this.additionalImages.length) {
                this.expandGallery = this.additionalImages
            } else {
                H = this.placeholder.getAttribute("data-gallery");
                if (H) {
                    if (y.jBrowser.features.query) {
                        G = y.$A(document.querySelectorAll('.MagicZoom[data-gallery="' + H + '"]'))
                    } else {
                        G = y.$A(document.getElementsByTagName("A")).filter(function(I) {
                            return H == I.getAttribute("data-gallery")
                        })
                    }
                    h(G).jEach(function(J) {
                        var I, K;
                        I = i(J);
                        if (I && I.additionalImages.length > 0) {
                            return
                        }
                        if (I) {
                            K = new k(I.image.small.url, I.image.zoom.url, I.image.caption, null, I.image.origin)
                        } else {
                            K = new k().parseNode(J, I ? I.originalTitle : null)
                        }
                        if (this.image.zoom.src.has(K.zoom.src) && this.image.small.src.has(K.small.src)) {
                            K = this.image
                        }
                        this.expandGallery.push(K)
                    }, this);
                    this.primaryImage = this.image
                }
            }
            if (this.expandGallery.length > 1) {
                this.expandStage.jAddClass("with-thumbs");
                this.expandNav = y.$new("div", {
                    "class": "mz-expand-thumbnails"
                }).jAppendTo(this.expandStage);
                this.expandThumbs = new r(this.expandNav);
                h(this.expandGallery).jEach(function(I) {
                    var J = h(function(K) {
                        this.setActiveThumb(I);
                        this.update(I)
                    }).jBind(this);
                    I.selector = this.expandThumbs.addItem(y.$new("img", {
                        src: I.getURL("small")
                    }).jAddEvent("tap btnclick", function(K) {
                        K.stop()
                    }).jAddEvent("tap " + ("hover" == this.option("selectorTrigger") ? "mouseover mouseout" : "btnclick"), h(function(L, K) {
                        if (this.updateTimer) {
                            clearTimeout(this.updateTimer)
                        }
                        this.updateTimer = false;
                        if ("mouseover" == L.type) {
                            this.updateTimer = h(J).jDelay(K)
                        } else {
                            if ("tap" == L.type || "btnclick" == L.type) {
                                J()
                            }
                        }
                    }).jBindAsEvent(this, 60)))
                }, this);
                this.buttons.next.show();
                this.buttons.prev.show()
            } else {
                this.expandStage.jRemoveClass("with-thumbs");
                this.buttons.next.hide();
                this.buttons.prev.hide()
            }
        },
        destroyExpandGallery: function() {
            var G;
            if (this.expandThumbs) {
                this.expandThumbs.stop();
                this.expandThumbs = null
            }
            if (this.expandNav) {
                this.expandNav.jRemove();
                this.expandNav = null
            }
            if (this.expandGallery.length > 1 && !this.additionalImages.length) {
                this.node.jRemoveEvent("touchdrag");
                this.image.node.jRemove().removeAttribute("style");
                this.primaryImage.node.jAppendTo(this.node);
                this.setupZoom(this.primaryImage);
                while (G = this.expandGallery.pop()) {
                    if (G !== this.primaryImage) {
                        if (G.small.node) {
                            G.small.node.kill();
                            G.small.node = null
                        }
                        if (G.zoom.node) {
                            G.zoom.node.kill();
                            G.zoom.node = null
                        }
                        G = null
                    }
                }
            }
            this.expandGallery = []
        },
        close: function() {
            if (!this.ready || !this.expanded) {
                return
            }
            if ("ios" == y.jBrowser.platform && "safari" == y.jBrowser.uaName && 7 == parseInt(y.jBrowser.uaVersion)) {
                clearInterval(m);
                m = null
            }
            h(document).jRemoveEvent("keydown", this.keyboardCallback);
            this.deactivate(null, true);
            this.ready = false;
            if (w.jBrowser.fullScreen.capable && w.jBrowser.fullScreen.enabled()) {
                w.jBrowser.fullScreen.cancel()
            } else {
                if (y.jBrowser.features.transition) {
                    this.node.jRemoveEvent("transitionend").jSetCss({
                        transition: ""
                    });
                    this.node.jAddEvent("transitionend", this.onClose);
                    this.expandBg.jRemoveEvent("transitionend").jSetCss({
                        transition: ""
                    });
                    this.expandBg.jSetCss({
                        transition: "all 0.6s cubic-bezier(0.895, 0.030, 0.685, 0.220) 0.0s"
                    }).jGetSize();
                    this.node.jSetCss({
                        transition: "all .4s cubic-bezier(0.600, -0.280, 0.735, 0.045) 0s"
                    }).jGetSize();
                    if ("always" == this.option("expandZoomOn") && "magnifier" !== this.option("expandZoomMode")) {
                        this.image.node.jSetCss({
                            "max-height": this.image.jGetSize("zoom").height
                        });
                        this.image.node.jSetCss({
                            "max-width": this.image.jGetSize("zoom").width
                        })
                    }
                    this.expandBg.jSetCss({
                        opacity: 0.4
                    });
                    this.node.jSetCss({
                        opacity: 0.01,
                        transform: "scale(0.4)"
                    })
                } else {
                    this.onClose()
                }
            }
        },
        expand: function(J) {
            if (!this.image.loaded() || !this.ready || this.expanded) {
                if (!this.image.loaded()) {
                    if (J) {
                        this.initEvent = y.extend({}, J);
                        J.stopQueue()
                    }
                    this.image.load(this.setupZoom.jBind(this));
                    if (!this.loadTimer) {
                        this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
                    }
                }
                return
            }
            if (J) {
                J.stopQueue()
            }
            var G = h(this.node).jFetch("cr"),
                H = document.createDocumentFragment(),
                I;
            this.hideHint();
            this.hintRuns--;
            this.deactivate(null, true);
            this.unregisterActivateEvent();
            this.unregisterDeactivateEvent();
            this.ready = false;
            if (!this.expandBox) {
                this.expandBox = y.$new("div").jAddClass("mz-expand").jAddClass(this.option("cssClass")).jSetCss({
                    opacity: 0
                });
                this.expandStage = y.$new("div").jAddClass("mz-expand-stage").jAppendTo(this.expandBox);
                this.expandControls = y.$new("div").jAddClass("mz-expand-controls").jAppendTo(this.expandStage);
                h(["prev", "next", "close"]).jEach(function(L) {
                    var K = "mz-button";
                    this.buttons[L] = y.$new("button", {
                        title: this.option("text-btn-" + L)
                    }).jAddClass(K).jAddClass(K + "-" + L);
                    H.appendChild(this.buttons[L]);
                    switch (L) {
                        case "prev":
                            this.buttons[L].jAddEvent("tap btnclick", function(M) {
                                M.stop();
                                this.update(this.getPrev())
                            }.jBindAsEvent(this));
                            break;
                        case "next":
                            this.buttons[L].jAddEvent("tap btnclick", function(M) {
                                M.stop();
                                this.update(this.getNext())
                            }.jBindAsEvent(this));
                            break;
                        case "close":
                            this.buttons[L].jAddEvent("tap btnclick", function(M) {
                                M.stop();
                                this.close()
                            }.jBindAsEvent(this));
                            break
                    }
                }, this);
                this.expandControls.append(H);
                this.expandBox.jAddEvent("mousescroll touchstart dbltap", h(function(K) {
                    h(K).stop()
                }));
                if (this.option("closeOnClickOutside")) {
                    this.expandBox.jAddEvent("tap btnclick", function(K) {
                        if ("always" !== this.option("expandZoomOn") && this.node.hasChild(K.getOriginalTarget())) {
                            return
                        }
                        K.stop();
                        this.close()
                    }.jBindAsEvent(this))
                }
                this.keyboardCallback = h(function(L) {
                    var K = null;
                    if (27 !== L.keyCode && 37 !== L.keyCode && 39 !== L.keyCode) {
                        return
                    }
                    h(L).stop();
                    if (27 === L.keyCode) {
                        this.close()
                    } else {
                        K = (37 === L.keyCode) ? this.getPrev() : this.getNext();
                        if (K) {
                            this.update(K)
                        }
                    }
                }).jBindAsEvent(this);
                this.onExpand = h(function() {
                    var K;
                    this.node.jRemoveEvent("transitionend").jSetCss({
                        transition: "",
                        transform: "translate3d(0,0,0)"
                    });
                    this.expanded = true;
                    this.expandBox.jSetCss({
                        opacity: 1
                    });
                    this.zoomBox.setMode(this.option("expandZoomMode"));
                    this.zoomSize = y.detach(this.zoomSizeOrigin);
                    this.resizeCallback();
                    if (this.expandCaption && this.image.caption) {
                        if (this.image.link) {
                            this.expandCaption.append(y.$new("a", {
                                href: this.image.link
                            }).jAddEvent("tap btnclick", this.openLink.jBind(this)).changeContent(this.image.caption))
                        } else {
                            this.expandCaption.changeContent(this.image.caption)
                        }
                        this.expandCaption.jAddClass("mz-show")
                    }
                    if ("always" !== this.option("expandZoomOn")) {
                        this.registerActivateEvent(true);
                        this.registerDeactivateEvent(true)
                    }
                    this.ready = true;
                    if ("always" === this.option("expandZoomOn")) {
                        this.activate()
                    }
                    if (y.jBrowser.mobile && this.mobileZoomHint && this.zoomBox.enabled) {
                        this.showHint(true, this.option("textClickZoomHint"));
                        this.mobileZoomHint = false
                    }
                    this.expandControls.jRemoveClass("mz-hidden").jAddClass("mz-fade mz-visible");
                    this.expandNav && this.expandNav.jRemoveClass("mz-hidden").jAddClass("mz-fade mz-visible");
                    if (this.expandThumbs) {
                        this.expandThumbs.run();
                        this.setActiveThumb(this.image)
                    }
                    if (G) {
                        G.jAppendTo(this.expandBox, ((Math.floor(Math.random() * 101) + 1) % 2) ? "top" : "bottom")
                    }
                    if (this.expandGallery.length && !this.additionalImages.length) {
                        this.swipe()
                    }
                    h(document).jAddEvent("keydown", this.keyboardCallback);
                    if ("ios" == y.jBrowser.platform && "safari" == y.jBrowser.uaName && 7 == parseInt(y.jBrowser.uaVersion)) {
                        m = u()
                    }
                    s("onExpandOpen", this.id)
                }).jBind(this);
                this.onClose = h(function() {
                    if (this.expanded) {
                        h(document).jRemoveEvent("keydown", this.keyboardCallback);
                        this.deactivate(null, true)
                    }
                    this.node.jRemoveEvent("transitionend");
                    this.destroyExpandGallery();
                    this.expanded = false;
                    this.zoomBox.setMode(this.option("zoomMode"));
                    this.node.replaceChild(this.image.getNode("small"), this.image.node);
                    this.image.setCurNode("small");
                    h(this.image.node).jSetCss({
                        width: "",
                        height: "",
                        "max-width": Math.min(this.image.jGetSize("small").width),
                        "max-height": Math.min(this.image.jGetSize("small").height)
                    });
                    this.node.jSetCss({
                        opacity: "",
                        transition: ""
                    });
                    this.node.jSetCss({
                        transform: "translate3d(0,0,0)"
                    });
                    this.node.jAppendTo(this.placeholder);
                    this.setSize(true);
                    if (this.expandCaption) {
                        this.expandCaption.jRemove();
                        this.expandCaption = null
                    }
                    this.unregisterActivateEvent();
                    this.unregisterDeactivateEvent();
                    if ("always" == this.option("zoomOn")) {
                        this.activate()
                    } else {
                        if (false !== this.option("zoomMode")) {
                            this.registerActivateEvent("click" === this.option("zoomOn"));
                            this.registerDeactivateEvent("click" === this.option("zoomOn") && !this.option("expand"))
                        }
                    }
                    this.showHint();
                    this.expandBg.jRemoveEvent("transitionend");
                    this.expandBox.jRemove();
                    this.expandBg.jRemove();
                    this.expandBg = null;
                    h(y.jBrowser.getDoc()).jSetCss({
                        overflow: ""
                    });
                    this.ready = true;
                    if (y.jBrowser.ieMode < 10) {
                        this.resizeCallback()
                    } else {
                        h(window).jRaiseEvent("UIEvent", "resize")
                    }
                    s("onExpandClose", this.id)
                }).jBind(this);
                this.expandImageStage = y.$new("div", {
                    "class": "mz-image-stage"
                }).jAppendTo(this.expandStage);
                this.expandFigure = y.$new("figure").jAppendTo(this.expandImageStage)
            }
            this.setupExpandGallery();
            I = y.$new("img", {
                src: this.image.getURL("zoom")
            });
            if (y.jBrowser.features.cssFilters || y.jBrowser.ieMode < 10) {
                this.expandBg = y.$new("div").jAddClass("mz-expand-bg").append(I).jAppendTo(this.expandBox)
            } else {
                this.expandBg = y.$new("div").jAddClass("mz-expand-bg").append(new y.SVGImage(I).blur(b).getNode()).jAppendTo(this.expandBox)
            }
            if ("always" === this.option("expandZoomOn")) {
                this.expandStage.jAddClass("mz-always-zoom" + ("zoom" === this.option("expandZoomMode") ? " mz-zoom-in" : "")).jGetSize()
            }
            this.node.replaceChild(this.image.getNode("zoom"), this.image.node);
            this.image.setCurNode("zoom");
            this.expandBox.jAppendTo(document.body);
            h(y.jBrowser.getDoc()).jSetCss({
                overflow: "hidden"
            });
            this.expandMaxWidth = function() {
                var K = this.expandImageStage;
                if (h(this.expandFigure).jGetSize().width > 50) {
                    K = this.expandFigure
                }
                return function() {
                    return Math.round(h(K).getInnerSize().width)
                }
            }.call(this);
            this.expandMaxHeight = function() {
                var K = this.expandImageStage;
                if (h(this.expandFigure).jGetSize().height > 50) {
                    K = this.expandFigure
                }
                return function() {
                    return Math.round(h(K).getInnerSize().height)
                }
            }.call(this);
            this.expandControls.jRemoveClass("mz-fade mz-visible").jAddClass("mz-hidden");
            this.expandNav && this.expandNav.jRemoveClass("mz-fade mz-visible").jAddClass("mz-hidden");
            this.image.node.jSetCss({
                "max-height": Math.min(this.image.jGetSize("zoom").height, "always" == this.option("expandZoomOn") && "magnifier" !== this.option("expandZoomMode") ? Infinity : this.expandMaxHeight())
            });
            this.image.node.jSetCss({
                "max-width": Math.min(this.image.jGetSize("zoom").width, "always" == this.option("expandZoomOn") && "magnifier" !== this.option("expandZoomMode") ? Infinity : this.expandMaxWidth())
            });
            this.expandFigure.append(this.node);
            if (this.option("expandCaption")) {
                this.expandCaption = y.$new("figcaption", {
                    "class": "mz-caption"
                }).jAppendTo(this.expandFigure)
            }
            if ("fullscreen" == this.option("expand")) {
                w.jBrowser.fullScreen.request(this.expandBox, {
                    onEnter: h(function() {
                        this.onExpand()
                    }).jBind(this),
                    onExit: this.onClose,
                    fallback: h(function() {
                        this.expandToWindow()
                    }).jBind(this)
                })
            } else {
                this.expandToWindow()
            }
        },
        expandToWindow: function() {
            this.node.jSetCss({
                transition: ""
            });
            this.node.jSetCss({
                transform: "scale(0.6)"
            }).jGetSize();
            this.node.jSetCss({
                transition: y.jBrowser.cssTransform + " 0.6s cubic-bezier(0.175, 0.885, 0.320, 1.275) 0s"
            });
            if (y.jBrowser.features.transition) {
                this.node.jAddEvent("transitionend", this.onExpand)
            } else {
                this.onExpand.jDelay(16, this)
            }
            this.expandBox.jSetCss({
                opacity: 1
            });
            this.node.jSetCss({
                transform: "scale(1)"
            })
        },
        openLink: function() {
            if (this.image.link) {
                window.open(this.image.link, "_self")
            }
        },
        getNext: function() {
            var G = (this.expanded ? this.expandGallery : this.additionalImages).filter(function(J) {
                    return (-1 !== J.small.state || -1 !== J.zoom.state)
                }),
                H = G.length,
                I = h(G).indexOf(this.image) + 1;
            return (1 >= H) ? null : G[(I >= H) ? 0 : I]
        },
        getPrev: function() {
            var G = (this.expanded ? this.expandGallery : this.additionalImages).filter(function(J) {
                    return (-1 !== J.small.state || -1 !== J.zoom.state)
                }),
                H = G.length,
                I = h(G).indexOf(this.image) - 1;
            return (1 >= H) ? null : G[(I < 0) ? H - 1 : I]
        },
        imageByURL: function(H, I) {
            var G = this.additionalImages.filter(function(J) {
                return ((J.zoom.src.has(H) || J.zoom.url.has(H)) && (J.small.src.has(I) || J.small.url.has(I)))
            }) || [];
            return G[0] || ((I && H && "string" === y.jTypeOf(I) && "string" === y.jTypeOf(H)) ? new k(I, H) : null)
        },
        imageByOrigin: function(H) {
            var G = this.additionalImages.filter(function(I) {
                return (I.origin === H)
            }) || [];
            return G[0]
        },
        imageByIndex: function(G) {
            return this.additionalImages[G]
        }
    };
    t = {
        version: "v5.0.1",
        start: function(J, H) {
            var I = null,
                G = [];
            y.$A((J ? [h(J)] : y.$A(document.byClass("MagicZoom")).concat(y.$A(document.byClass("MagicZoomPlus"))))).jEach((function(K) {
                if (h(K)) {
                    if (!i(K)) {
                        I = new j(K, H);
                        if (x && !I.option("autostart")) {
                            I.stop();
                            I = null
                        } else {
                            D.push(I);
                            G.push(I)
                        }
                    }
                }
            }).jBind(this));
            return J ? G[0] : G
        },
        stop: function(J) {
            var H, I, G;
            if (J) {
                (I = i(J)) && (I = D.splice(D.indexOf(I), 1)) && I[0].stop() && (delete I[0]);
                return
            }
            while (H = D.length) {
                I = D.splice(H - 1, 1);
                I[0].stop();
                delete I[0]
            }
        },
        refresh: function(G) {
            this.stop(G);
            return this.start(G)
        },
        update: function(L, K, J, H) {
            var I = i(L),
                G;
            if (I) {
                G = "element" === y.jTypeOf(K) ? I.imageByOrigin(K) : I.imageByURL(K, J);
                if (G) {
                    I.update(G)
                }
            }
        },
        switchTo: function(J, I) {
            var H = i(J),
                G;
            if (H) {
                switch (y.jTypeOf(I)) {
                    case "element":
                        G = H.imageByOrigin(I);
                        break;
                    case "number":
                        G = H.imageByIndex(I);
                        break;
                    default:
                }
                if (G) {
                    H.update(G)
                }
            }
        },
        prev: function(H) {
            var G;
            (G = i(H)) && G.update(G.getPrev())
        },
        next: function(H) {
            var G;
            (G = i(H)) && G.update(G.getNext())
        },
        zoomIn: function(H) {
            var G;
            (G = i(H)) && G.activate()
        },
        zoomOut: function(H) {
            var G;
            (G = i(H)) && G.deactivate()
        },
        expand: function(H) {
            var G;
            (G = i(H)) && G.expand()
        },
        close: function(H) {
            var G;
            (G = i(H)) && G.close()
        },
        registerCallback: function(G, H) {
            if (!p[G]) {
                p[G] = []
            }
            if ("function" == y.jTypeOf(H)) {
                p[G].push(H)
            }
        },
        running: function(G) {
            return !!i(G)
        }
    };
    h(document).jAddEvent("domready", function() {
        var H = window[B + "Options"] || {};
        d();
        F = y.$new("div", {
            "class": "magic-hidden-wrapper"
        }).jAppendTo(document.body);
        E = (y.jBrowser.mobile && window.matchMedia && window.matchMedia("(max-device-width: 767px), (max-device-height: 767px)").matches);
        if (y.jBrowser.mobile) {
            y.extend(o, l)
        }
        for (var G = 0; G < z.length; G++) {
            if (H[z[G]] && y.$F !== H[z[G]]) {
                t.registerCallback(z[G], H[z[G]])
            }
        }
        t.start();
        x = false
    });
    window.MagicZoomPlus = window.MagicZoomPlus || {};
    return t
})();