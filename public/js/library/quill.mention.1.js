var hashTagList = [];

function renderText(text, curText, selectedTag) {
  const words = text.split(/(\s+)/);
  const output = words.map((word) => {
    if (word.includes("#")) {
      //alert(word);
      //var start_word_position = curPostion - curText.length;
      //curPostion = curPostion + selectedTag.length;
      //return selectedTag;
      //return '<span contenteditable="false" class="" data-id="" data-value="">User Name </span>';
      //word = word.replace('#', '');
      //return '<span class="mention"><span contenteditable="true"><span class="ql-mention-denotation-char">#</span>' + word + '</span></span>';
      return '<span style="color:blue;">' + word + '</span>';
    }
    else {
      return word;
    }
  })
  return output.join('');
}

function logHashList() {
  hashTagList = [];
  $('.highlight').each(function() {
    hashTagList.push(this.innerHTML);
  });
  for (var i = 0; i < hashTagList.length; i++) {
    alert(hashTagList[i]);
  }
  if (hashTagList.length == 0) {
    alert('You have not typed any hashtags');
  }
}

// $(function() {

//   var hashtags = false;

//   $(document).on('keyup', '.ql-editor', function(e) {
//     console.log("keyup");
//     var arrow = {
//       hashtag: 51,
//       space: 32
//     };
//     //if (e.keyCode == arrow.hashtag) {
//     var elementAtCursor = rangy.getSelection().anchorNode.parentNode;
//     //alert($(elementAtCursor).text());
//     if ($(elementAtCursor).text().includes("#")) {
//       var replaceText = renderText($(elementAtCursor).text());
//       $(elementAtCursor).replaceWith(replaceText);
//       placeCaretAtEnd(rangy.getSelection().anchorNode);
//     }

//     // }
//     // else if (e.keyCode == arrow.space) {
//     //   placeCaretAtEnd(rangy.getSelection().anchorNode.parentElement);
//     // }
//     // else {
//     //   //placeCaretAtEnd(rangy.getSelection().anchorNode);
//     // }

//     //var input_field = $(this);


//     //alert($(elementAtCursor).text());
//     //var savedSel = rangy.saveSelection();

//     //rangy.restoreSelection(savedSel);
//     //alert($(elementAtCursor).text());
//     // var nodes = $(this)[0].childNodes;
//     // console.log(nodes)
//     // $.each(nodes, function(k, node) {
//     //   console.log(node.nodeType);
//     //   if (node.nodeType == Node.TEXT_NODE) {
//     //     //var words = renderText(node.nodeValue, null, null);
//     //     console.log(node.textContent);
//     //     ////console.log(node.nodeValue)
//     //     //node.caretTo(curPostion);
//     //   }
//     //   else {
//     //     console.log("else========");
//     //     console.log(node.textContent);
//     //     var words = renderText(node.textContent, null, null);
//     //     //var text = node.innerHTML;

//     //     // text = text.replace(/([#]+[_a-zA-Z0-9ぁ-んァ-ン一-龯\(\)\（\）\.\・\-\ー]+)/g, '<span style="color:red;">$1</span>');

//     //     var savedSel = rangy.getSelection().saveCharacterRanges(node);
//     //     //$(this).html(text);
//     //     rangy.getSelection().restoreCharacterRanges(node, savedSel);

//     //     node.innerHTML = words;
//     //   }
//     // })


//   });

// });

// $(function() {

//   // var hashtags = false;

//   $(document).on('keyup', '.ql-editor', function(e) {
//     console.log("keyup");
//     $(this).wrap('<div class="jqueryHashtags"><div class="highlighter"></div></div>').unwrap().before('<div class="highlighter"></div>').wrap('<div class="typehead"></div></div>');
//     $(this).addClass("theSelector");
//     var str = $(this).html();
//     MakeHighlight($(this), str);
//     $(this).parent().prev().on('click', function() {
//       $(this).parent().find(".theSelector").focus();
//     });

//   });
//});

function placeCaretAtEnd(el) {

  if (typeof window.getSelection != "undefined") {
    var range = document.createRange();
    range.setStartAfter(el);
    range.collapse(true);
    var selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);
  }
  // el.focus();
  // if (typeof window.getSelection != "undefined" &&
  //   typeof document.createRange != "undefined") {
  //   var range = document.createRange();
  //   range.selectNodeContents(el);
  //   range.collapse(false);
  //   var sel = window.getSelection();
  //   sel.removeAllRanges();
  //   sel.addRange(range);
  // }
  // else if (typeof document.body.createTextRange != "undefined") {
  //   var textRange = document.body.createTextRange();
  //   textRange.moveToElementText(el);
  //   textRange.collapse(false);
  //   textRange.select();
  // }
}

function MakeHighlight(ele, str) {
  $(ele).parent().parent().find(".highlighter").css({ "width": $(ele).css("width"), "height": $(ele).css("height") });
  if (!str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?#([a-zA-Z0-9]+)/g) && !str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?@([a-zA-Z0-9]+)/g) && !str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?#([\u0600-\u06FF]+)/g) && !str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?@([\u0600-\u06FF]+)/g)) {
    if (!str.match(/#(([_a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))#/g)) { //arabic support, CJK support
      str = str.replace(/#(([_a-zA-Z0-9ぁ-んァ-ン一-龯\(\)\（\）\.\・\-\ー]+)|()|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))/g, '<span class="hashtag">#$1</span>');
    }
    else {
      str = str.replace(/#(([_a-zA-Z0-9ぁ-んァ-ン一-龯\(\)\（\）\.\・\-]+)|()|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))#(([_a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))/g, '<span class="hashtag">#$1</span>');
    }

  }

  $(ele).parent().parent().find(".highlighter").html(str);
}

var quillMention = function(t) {
  "use strict";

  function e(t, e) {
    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
  }

  function n(t, e) {
    for (var n = 0; n < e.length; n++) {
      var i = e[n];
      i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i)
    }
  }

  function i(t, e, i) {
    return e && n(t.prototype, e), i && n(t, i), t
  }

  function o() {
    return (o = Object.assign || function(t) {
      for (var e = 1; e < arguments.length; e++) {
        var n = arguments[e];
        for (var i in n) Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i])
      }
      return t
    }).apply(this, arguments)
  }

  function s(t) {
    return (s = Object.setPrototypeOf ? Object.getPrototypeOf : function(t) {
      return t.__proto__ || Object.getPrototypeOf(t)
    })(t)
  }

  function a(t, e) {
    return (a = Object.setPrototypeOf || function(t, e) {
      return t.__proto__ = e, t
    })(t, e)
  }

  function r(t, e) {
    return !e || "object" != typeof e && "function" != typeof e ? function(t) {
      if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
      return t
    }(t) : e
  }

  function l(t) {
    var e = function() {
      if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
      if (Reflect.construct.sham) return !1;
      if ("function" == typeof Proxy) return !0;
      try {
        return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], (function() {}))), !0
      }
      catch (t) {
        return !1
      }
    }();
    return function() {
      var n, i = s(t);
      if (e) {
        var o = s(this).constructor;
        n = Reflect.construct(i, arguments, o)
      }
      else n = i.apply(this, arguments);
      return r(this, n)
    }
  }

  function h(t, e, n) {
    return (h = "undefined" != typeof Reflect && Reflect.get ? Reflect.get : function(t, e, n) {
      var i = function(t, e) {
        for (; !Object.prototype.hasOwnProperty.call(t, e) && null !== (t = s(t)););
        return t
      }(t, e);
      if (i) {
        var o = Object.getOwnPropertyDescriptor(i, e);
        return o.get ? o.get.call(n) : o.value
      }
    })(t, e, n || t)
  }

  function u(t, e) {
    (null == e || e > t.length) && (e = t.length);
    for (var n = 0, i = new Array(e); n < e; n++) i[n] = t[n];
    return i
  }

  function c(t, e) {
    var n = "undefined" != typeof Symbol && t[Symbol.iterator] || t["@@iterator"];
    if (!n) {
      if (Array.isArray(t) || (n = function(t, e) {
          if (t) {
            if ("string" == typeof t) return u(t, e);
            var n = Object.prototype.toString.call(t).slice(8, -1);
            return "Object" === n && t.constructor && (n = t.constructor.name), "Map" === n || "Set" === n ? Array.from(t) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? u(t, e) : void 0
          }
        }(t)) || e && t && "number" == typeof t.length) {
        n && (t = n);
        var i = 0,
          o = function() {};
        return {
          s: o,
          n: function() {
            return i >= t.length ? {
              done: !0
            } : {
              done: !1,
              value: t[i++]
            }
          },
          e: function(t) {
            throw t
          },
          f: o
        }
      }
      throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
    }
    var s, a = !0,
      r = !1;
    return {
      s: function() {
        n = n.call(t)
      },
      n: function() {
        var t = n.next();
        return a = t.done, t
      },
      e: function(t) {
        r = !0, s = t
      },
      f: function() {
        try {
          a || null == n.return || n.return()
        }
        finally {
          if (r) throw s
        }
      }
    }
  }
  t = t && Object.prototype.hasOwnProperty.call(t, "default") ? t.default : t;
  var d = 9,
    m = 13,
    f = 27,
    p = 38,
    v = 40;

  function g(t, e, n) {
    var i = t;
    return Object.keys(e).forEach((function(t) {
      n.indexOf(t) > -1 ? i.dataset[t] = e[t] : delete i.dataset[t]
    })), i
  }
  var C = function(t) {
    ! function(t, e) {
      if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
      t.prototype = Object.create(e && e.prototype, {
        constructor: {
          value: t,
          writable: !0,
          configurable: !0
        }
      }), e && a(t, e)
    }(r, t);
    var n = l(r);

    function r(t, i) {
      var o;
      return e(this, r), (o = n.call(this, t, i)).clickHandler = null, o
    }
    return i(r, [{
      key: "attach",
      value: function() {
        var t = this;
        h(s(r.prototype), "attach", this).call(this), this.clickHandler = function(e) {
          var n = new Event("mention-clicked", {
            bubbles: !0,
            cancelable: !0
          });
          n.value = o({}, t.domNode.dataset), n.event = e, window.dispatchEvent(n), e.preventDefault()
        }, this.domNode.addEventListener("click", this.clickHandler, !1)
      }
    }, {
      key: "detach",
      value: function() {
        h(s(r.prototype), "detach", this).call(this), this.clickHandler && (this.domNode.removeEventListener("click", this.clickHandler), this.clickHandler = null)
      }
    }], [{
      key: "create",
      value: function(t) {
        var e = h(s(r), "create", this).call(this),
          n = document.createElement("span");
        return n.className = "ql-mention-denotation-char", n.innerHTML = t.denotationChar, e.appendChild(n), e.innerHTML += t.value, r.setDataValues(e, t)
      }
    }, {
      key: "setDataValues",
      value: function(t, e) {
        var n = t;
        return Object.keys(e).forEach((function(t) {
          n.dataset[t] = e[t]
        })), n
      }
    }, {
      key: "value",
      value: function(t) {
        return t.dataset
      }
    }]), r
  }(t.import("blots/embed"));
  C.blotName = "mention", C.tagName = "span", C.className = "mention", t.register(C);
  var y = function() {
    function n(t, i) {
      var s = this;
      e(this, n), this.isOpen = !1, this.itemIndex = 0, this.mentionCharPos = null, this.cursorPos = null, this.values = [], this.suspendMouseEnter = !1, this.existingSourceExecutionToken = null, this.quill = t, this.options = {
        source: null,
        renderItem: function(t) {
          return "".concat(t.value)
        },
        renderLoading: function() {
          return null
        },
        onSelect: function(t, e) {
          e(t)
        },
        mentionDenotationChars: ["@"],
        showDenotationChar: !0,
        allowedChars: /^[a-zA-Z0-9_]*$/,
        minChars: 0,
        maxChars: 31,
        offsetTop: 2,
        offsetLeft: 0,
        isolateCharacter: !1,
        fixMentionsToQuill: !1,
        positioningStrategy: "normal",
        defaultMenuOrientation: "bottom",
        blotName: "mention",
        dataAttributes: ["id", "value", "denotationChar", "link", "target", "disabled"],
        linkTarget: "_blank",
        onOpen: function() {
          return !0
        },
        onClose: function() {
          return !0
        },
        listItemClass: "ql-mention-list-item",
        mentionContainerClass: "ql-mention-list-container",
        mentionListClass: "ql-mention-list",
        spaceAfterInsert: !0,
        selectKeys: [m]
      }, o(this.options, i, {
        dataAttributes: Array.isArray(i.dataAttributes) ? this.options.dataAttributes.concat(i.dataAttributes) : this.options.dataAttributes
      }), this.mentionContainer = document.createElement("div"), this.mentionContainer.className = this.options.mentionContainerClass ? this.options.mentionContainerClass : "", this.mentionContainer.style.cssText = "display: none; position: absolute;", this.mentionContainer.onmousemove = this.onContainerMouseMove.bind(this), this.options.fixMentionsToQuill && (this.mentionContainer.style.width = "auto"), this.mentionList = document.createElement("ul"), this.mentionList.id = "quill-mention-list", t.root.setAttribute("aria-owns", "quill-mention-list"), this.mentionList.className = this.options.mentionListClass ? this.options.mentionListClass : "", this.mentionContainer.appendChild(this.mentionList), t.on("text-change", this.onTextChange.bind(this)), t.on("selection-change", this.onSelectionChange.bind(this)), t.container.addEventListener("paste", (function() {
        setTimeout((function() {
          var e = t.getSelection();
          s.onSelectionChange(e)
        }))
      })), t.keyboard.addBinding({
        key: d
      }, this.selectHandler.bind(this)), t.keyboard.bindings[d].unshift(t.keyboard.bindings[d].pop());
      var a, r = c(this.options.selectKeys);
      try {
        for (r.s(); !(a = r.n()).done;) {
          var l = a.value;
          t.keyboard.addBinding({
            key: l
          }, this.selectHandler.bind(this))
        }
      }
      catch (t) {
        r.e(t)
      }
      finally {
        r.f()
      }
      t.keyboard.bindings[m].unshift(t.keyboard.bindings[m].pop()), t.keyboard.addBinding({
        key: f
      }, this.escapeHandler.bind(this)), t.keyboard.addBinding({
        key: p
      }, this.upHandler.bind(this)), t.keyboard.addBinding({
        key: v
      }, this.downHandler.bind(this))
    }
    return i(n, [{
      key: "selectHandler",
      value: function() {
        return !(this.isOpen && !this.existingSourceExecutionToken) || (this.selectItem(), !1)
      }
    }, {
      key: "escapeHandler",
      value: function() {
        return !this.isOpen || (this.existingSourceExecutionToken && (this.existingSourceExecutionToken.abandoned = !0), this.hideMentionList(), !1)
      }
    }, {
      key: "upHandler",
      value: function() {
        return !(this.isOpen && !this.existingSourceExecutionToken) || (this.prevItem(), !1)
      }
    }, {
      key: "downHandler",
      value: function() {
        return !(this.isOpen && !this.existingSourceExecutionToken) || (this.nextItem(), !1)
      }
    }, {
      key: "showMentionList",
      value: function() {
        "fixed" === this.options.positioningStrategy ? document.body.appendChild(this.mentionContainer) : this.quill.container.appendChild(this.mentionContainer), this.mentionContainer.style.visibility = "hidden", this.mentionContainer.style.display = "", this.mentionContainer.scrollTop = 0, this.setMentionContainerPosition(), this.setIsOpen(!0)
      }
    }, {
      key: "hideMentionList",
      value: function() {
        this.mentionContainer.style.display = "none", this.mentionContainer.remove(), this.setIsOpen(!1), this.quill.root.removeAttribute("aria-activedescendant")
      }
    }, {
      key: "highlightItem",
      value: function() {
        for (var t = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0], e = 0; e < this.mentionList.childNodes.length; e += 1) this.mentionList.childNodes[e].classList.remove("selected");
        if (-1 !== this.itemIndex && "true" !== this.mentionList.childNodes[this.itemIndex].dataset.disabled && (this.mentionList.childNodes[this.itemIndex].classList.add("selected"), this.quill.root.setAttribute("aria-activedescendant", this.mentionList.childNodes[this.itemIndex].id), t)) {
          var n = this.mentionList.childNodes[this.itemIndex].offsetHeight,
            i = this.mentionList.childNodes[this.itemIndex].offsetTop,
            o = this.mentionContainer.scrollTop,
            s = o + this.mentionContainer.offsetHeight;
          i < o ? this.mentionContainer.scrollTop = i : i > s - n && (this.mentionContainer.scrollTop += i - s + n)
        }
      }
    }, {
      key: "getItemData",
      value: function() {
        var t = this.mentionList.childNodes[this.itemIndex].dataset.link,
          e = void 0 !== t,
          n = this.mentionList.childNodes[this.itemIndex].dataset.target;
        return e && (this.mentionList.childNodes[this.itemIndex].dataset.value = '<a href="'.concat(t, '" target=').concat(n || this.options.linkTarget, ">").concat(this.mentionList.childNodes[this.itemIndex].dataset.value)), this.mentionList.childNodes[this.itemIndex].dataset
      }
    }, {
      key: "onContainerMouseMove",
      value: function() {
        this.suspendMouseEnter = !1
      }
    }, {
      key: "selectItem",
      value: function() {
        var t = this;
        if (-1 !== this.itemIndex) {
          var e = this.getItemData();
          e["value"] = e["value"].replace(/#/gi, ''); //replace hashtag as empty char Edited by yadanar
          //alert(JSON.stringify(e));
          e.disabled || (this.options.onSelect(e, (function(e) {
            t.insertItem(e)
          })), this.hideMentionList())
        }
      }
    }, {
      key: "insertItem",
      value: function(e, n) {
        var i, o = e;
        null !== o && (this.options.showDenotationChar || (o.denotationChar = ""), n ? i = this.cursorPos : (i = this.mentionCharPos, this.quill.deleteText(this.mentionCharPos, this.cursorPos - this.mentionCharPos, t.sources.USER)), this.quill.insertEmbed(i, this.options.blotName, o, t.sources.USER), this.options.spaceAfterInsert ? (this.quill.insertText(i + 1, " ", t.sources.USER), this.quill.setSelection(i + 2, t.sources.USER)) : this.quill.setSelection(i + 1, t.sources.USER), this.hideMentionList())
      }
    }, {
      key: "onItemMouseEnter",
      value: function(t) {
        if (!this.suspendMouseEnter) {
          var e = Number(t.target.dataset.index);
          Number.isNaN(e) || e === this.itemIndex || (this.itemIndex = e, this.highlightItem(!1))
        }
      }
    }, {
      key: "onDisabledItemMouseEnter",
      value: function(t) {
        this.suspendMouseEnter || (this.itemIndex = -1, this.highlightItem(!1))
      }
    }, {
      key: "onItemClick",
      value: function(t) {
        0 === t.button && (t.preventDefault(), t.stopImmediatePropagation(), this.itemIndex = t.currentTarget.dataset.index, this.highlightItem(), this.selectItem())
      }
    }, {
      key: "onItemMouseDown",
      value: function(t) {
        t.preventDefault(), t.stopImmediatePropagation()
      }
    }, {
      key: "renderLoading",
      value: function() {
        if (this.options.renderLoading())
          if (this.mentionContainer.getElementsByClassName("ql-mention-loading").length > 0) this.showMentionList();
          else {
            this.mentionList.innerHTML = "";
            var t = document.createElement("div");
            t.className = "ql-mention-loading", t.innerHTML = this.options.renderLoading(), this.mentionContainer.append(t), this.showMentionList()
          }
      }
    }, {
      key: "removeLoading",
      value: function() {
        var t = this.mentionContainer.getElementsByClassName("ql-mention-loading");
        t.length > 0 && t[0].remove()
      }
    }, {
      key: "renderList",
      value: function(t, e, n) {
        if (e && e.length > 0) {
          this.removeLoading(), this.values = e, this.mentionList.innerHTML = "";
          for (var i = -1, o = 0; o < e.length; o += 1) {
            var s = document.createElement("li");
            s.id = "quill-mention-item-" + o, s.className = this.options.listItemClass ? this.options.listItemClass : "", e[o].disabled ? (s.className += " disabled", s.setAttribute("aria-hidden", "true")) : -1 === i && (i = o), s.dataset.index = o, s.innerHTML = this.options.renderItem(e[o], n), e[o].disabled ? s.onmouseenter = this.onDisabledItemMouseEnter.bind(this) : (s.onmouseenter = this.onItemMouseEnter.bind(this), s.onmouseup = this.onItemClick.bind(this), s.onmousedown = this.onItemMouseDown.bind(this)), s.dataset.denotationChar = t, this.mentionList.appendChild(g(s, e[o], this.options.dataAttributes))
          }
          this.itemIndex = i, this.highlightItem(), this.showMentionList()
        }
        else this.hideMentionList()
      }
    }, {
      key: "nextItem",
      value: function() {
        var t, e = 0;
        do {
          e++, t = (this.itemIndex + e) % this.values.length;
          var n = "true" === this.mentionList.childNodes[t].dataset.disabled;
          if (e === this.values.length + 1) {
            t = -1;
            break
          }
        } while (n);
        this.itemIndex = t, this.suspendMouseEnter = !0, this.highlightItem()
      }
    }, {
      key: "prevItem",
      value: function() {
        var t, e = 0;
        do {
          e++, t = (this.itemIndex + this.values.length - e) % this.values.length;
          var n = "true" === this.mentionList.childNodes[t].dataset.disabled;
          if (e === this.values.length + 1) {
            t = -1;
            break
          }
        } while (n);
        this.itemIndex = t, this.suspendMouseEnter = !0, this.highlightItem()
      }
    }, {
      key: "containerBottomIsNotVisible",
      value: function(t, e) {
        return t + this.mentionContainer.offsetHeight + e.top > window.pageYOffset + window.innerHeight
      }
    }, {
      key: "containerRightIsNotVisible",
      value: function(t, e) {
        return !this.options.fixMentionsToQuill && t + this.mentionContainer.offsetWidth + e.left > window.pageXOffset + document.documentElement.clientWidth
      }
    }, {
      key: "setIsOpen",
      value: function(t) {
        this.isOpen !== t && (t ? this.options.onOpen() : this.options.onClose(), this.isOpen = t)
      }
    }, {
      key: "setMentionContainerPosition",
      value: function() {
        "fixed" === this.options.positioningStrategy ? this.setMentionContainerPosition_Fixed() : this.setMentionContainerPosition_Normal()
      }
    }, {
      key: "setMentionContainerPosition_Normal",
      value: function() {
        var t = this,
          e = this.quill.container.getBoundingClientRect(),
          n = this.quill.getBounds(this.mentionCharPos),
          i = this.mentionContainer.offsetHeight,
          o = this.options.offsetTop,
          s = this.options.offsetLeft;
        if (this.options.fixMentionsToQuill) {
          this.mentionContainer.style.right = "".concat(0, "px")
        }
        else s += n.left;
        if (this.containerRightIsNotVisible(s, e)) {
          var a = this.mentionContainer.offsetWidth + this.options.offsetLeft;
          s = e.width - a
        }
        if ("top" === this.options.defaultMenuOrientation) {
          if ((o = this.options.fixMentionsToQuill ? -1 * (i + this.options.offsetTop) : n.top - (i + this.options.offsetTop)) + e.top <= 0) {
            var r = this.options.offsetTop;
            this.options.fixMentionsToQuill ? r += e.height : r += n.bottom, o = r
          }
        }
        else if (this.options.fixMentionsToQuill ? o += e.height : o += n.bottom, this.containerBottomIsNotVisible(o, e)) {
          var l = -1 * this.options.offsetTop;
          this.options.fixMentionsToQuill || (l += n.top), o = l - i
        }
        o >= 0 ? this.options.mentionContainerClass.split(" ").forEach((function(e) {
          t.mentionContainer.classList.add("".concat(e, "-bottom")), t.mentionContainer.classList.remove("".concat(e, "-top"))
        })) : this.options.mentionContainerClass.split(" ").forEach((function(e) {
          t.mentionContainer.classList.add("".concat(e, "-top")), t.mentionContainer.classList.remove("".concat(e, "-bottom"))
        })), this.mentionContainer.style.top = "".concat(o, "px"), this.mentionContainer.style.left = "".concat(s, "px"), this.mentionContainer.style.visibility = "visible"
      }
    }, {
      key: "setMentionContainerPosition_Fixed",
      value: function() {
        var t = this;
        this.mentionContainer.style.position = "fixed", this.mentionContainer.style.height = null;
        var e = this.quill.container.getBoundingClientRect(),
          n = this.quill.getBounds(this.mentionCharPos),
          i = {
            left: e.left + n.left,
            top: e.top + n.top,
            width: 0,
            height: n.height
          },
          o = this.options.fixMentionsToQuill ? e : i,
          s = this.options.offsetTop,
          a = this.options.offsetLeft;
        if (this.options.fixMentionsToQuill) {
          var r = o.right;
          this.mentionContainer.style.right = "".concat(r, "px")
        }
        else(a += o.left) + this.mentionContainer.offsetWidth > document.documentElement.clientWidth && (a -= a + this.mentionContainer.offsetWidth - document.documentElement.clientWidth);
        var l = o.top,
          h = document.documentElement.clientHeight - (o.top + o.height),
          u = this.mentionContainer.offsetHeight <= h,
          c = this.mentionContainer.offsetHeight <= l;
        "bottom" === ("top" === this.options.defaultMenuOrientation && c ? "top" : "bottom" === this.options.defaultMenuOrientation && u || h > l ? "bottom" : "top") ? (s = o.top + o.height, u || (this.mentionContainer.style.height = h - 3 + "px"), this.options.mentionContainerClass.split(" ").forEach((function(e) {
          t.mentionContainer.classList.add("".concat(e, "-bottom")), t.mentionContainer.classList.remove("".concat(e, "-top"))
        }))) : (s = o.top - this.mentionContainer.offsetHeight, c || (this.mentionContainer.style.height = l - 3 + "px", s = 3), this.options.mentionContainerClass.split(" ").forEach((function(e) {
          t.mentionContainer.classList.add("".concat(e, "-top")), t.mentionContainer.classList.remove("".concat(e, "-bottom"))
        }))), this.mentionContainer.style.top = "".concat(s, "px"), this.mentionContainer.style.left = "".concat(a, "px"), this.mentionContainer.style.visibility = "visible"
      }
    }, {
      key: "getTextBeforeCursor",
      value: function() {
        var t = Math.max(0, this.cursorPos - this.options.maxChars);
        return this.quill.getText(t, this.cursorPos - t)
      }
    }, {
      key: "onSomethingChange",
      value: function() {
        var t = this,
          e = this.quill.getSelection();
        if (null != e) {
          this.cursorPos = e.index;
          var n, i = this.getTextBeforeCursor(),
            o = (n = i, this.options.mentionDenotationChars.reduce((function(t, e) {
              var i = n.lastIndexOf(e);
              return i > t.mentionCharIndex ? {
                mentionChar: e,
                mentionCharIndex: i
              } : {
                mentionChar: t.mentionChar,
                mentionCharIndex: t.mentionCharIndex
              }
            }), {
              mentionChar: null,
              mentionCharIndex: -1
            })),
            s = o.mentionChar,
            a = o.mentionCharIndex;
          if (function(t, e, n) {
              return t > -1 && !(n && 0 !== t && !e[t - 1].match(/\s/g))
            }(a, i, this.options.isolateCharacter)) {
            var r = this.cursorPos - (i.length - a);
            this.mentionCharPos = r;
            var l = i.substring(a + s.length);
            if (l.length >= this.options.minChars && function(t, e) {
                return e.test(t)
              }(l, this.getAllowedCharsRegex(s))) {
              this.existingSourceExecutionToken && (this.existingSourceExecutionToken.abandoned = !0), this.renderLoading();
              var h = {
                abandoned: !1
              };
              this.existingSourceExecutionToken = h, this.options.source(l, (function(e, n) {
                h.abandoned || (t.existingSourceExecutionToken = null, t.renderList(s, e, n))
              }), s)
            }
            else this.hideMentionList()
          }
          else this.hideMentionList()
        }
      }
    }, {
      key: "getAllowedCharsRegex",
      value: function(t) {
        return this.options.allowedChars instanceof RegExp ? this.options.allowedChars : this.options.allowedChars(t)
      }
    }, {
      key: "onTextChange",
      value: function(t, e, n) {
        "user" === n && this.onSomethingChange()
      }
    }, {
      key: "onSelectionChange",
      value: function(t) {
        t && 0 === t.length ? this.onSomethingChange() : this.hideMentionList()
      }
    }, {
      key: "openMenu",
      value: function(t) {
        var e = this.quill.getSelection(!0);
        this.quill.insertText(e.index, t), this.quill.blur(), this.quill.focus()
      }
    }]), n
  }();
  return t.register("modules/mention", y), y
}(Quill);
