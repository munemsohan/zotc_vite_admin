(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[3402],{7441:function(e,s,n){(window.__NEXT_P=window.__NEXT_P||[]).push(["/landing-37",function(){return n(7802)}])},8347:function(e,s,n){"use strict";var a=n(5893);n(7294);var i=n(1555),r=n(682),l=n(4051),t=n(6276),d=n.n(t);s.Z=()=>(0,a.jsx)("div",{id:"CustomerReview",className:"CustomerReview",children:(0,a.jsx)("section",{id:"CustomerReviewContent",className:d().CustomerReviewContent,children:(0,a.jsx)(r.Z,{children:(0,a.jsxs)(l.Z,{children:[(0,a.jsx)(i.Z,{lg:12,children:(0,a.jsx)("h2",{children:"আমাদের কাস্টমার রিভিউ"})}),(0,a.jsx)(i.Z,{lg:6,sm:6,children:(0,a.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,a.jsx)("img",{src:"/images/customer-review/customer-review1.png",alt:""})})}),(0,a.jsx)(i.Z,{lg:6,sm:6,children:(0,a.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,a.jsx)("img",{src:"/images/customer-review/customer-review2.png",alt:""})})}),(0,a.jsx)(i.Z,{lg:6,sm:6,children:(0,a.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,a.jsx)("img",{src:"/images/customer-review/customer-review3.png",alt:""})})}),(0,a.jsx)(i.Z,{lg:6,sm:6,children:(0,a.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,a.jsx)("img",{src:"/images/customer-review/customer-review1.png",alt:""})})})]})})})})},5677:function(e,s,n){"use strict";Object.defineProperty(s,"__esModule",{value:!0}),function(e,s){for(var n in s)Object.defineProperty(e,n,{enumerable:!0,get:s[n]})}(s,{noSSR:function(){return l},default:function(){return t}});let a=n(8754),i=(n(7294),a._(n(8976)));function r(e){return{default:(null==e?void 0:e.default)||e}}function l(e,s){return delete s.webpack,delete s.modules,e(s)}function t(e,s){let n=i.default,a={loading:e=>{let{error:s,isLoading:n,pastDelay:a}=e;return null}};e instanceof Promise?a.loader=()=>e:"function"==typeof e?a.loader=e:"object"==typeof e&&(a={...a,...e}),a={...a,...s};let t=a.loader;return(a.loadableGenerated&&(a={...a,...a.loadableGenerated},delete a.loadableGenerated),"boolean"!=typeof a.ssr||a.ssr)?n({...a,loader:()=>null!=t?t().then(r):Promise.resolve(r(()=>null))}):(delete a.webpack,delete a.modules,l(n,a))}("function"==typeof s.default||"object"==typeof s.default&&null!==s.default)&&void 0===s.default.__esModule&&(Object.defineProperty(s.default,"__esModule",{value:!0}),Object.assign(s.default,s),e.exports=s.default)},2254:function(e,s,n){"use strict";Object.defineProperty(s,"__esModule",{value:!0}),Object.defineProperty(s,"LoadableContext",{enumerable:!0,get:function(){return r}});let a=n(8754),i=a._(n(7294)),r=i.default.createContext(null)},8976:function(e,s,n){"use strict";/**
@copyright (c) 2017-present James Kyle <me@thejameskyle.com>
 MIT License
 Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:
 The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE
*/Object.defineProperty(s,"__esModule",{value:!0}),Object.defineProperty(s,"default",{enumerable:!0,get:function(){return _}});let a=n(8754),i=a._(n(7294)),r=n(2254),l=[],t=[],d=!1;function c(e){let s=e(),n={loading:!0,loaded:null,error:null};return n.promise=s.then(e=>(n.loading=!1,n.loaded=e,e)).catch(e=>{throw n.loading=!1,n.error=e,e}),n}class o{promise(){return this._res.promise}retry(){this._clearTimeouts(),this._res=this._loadFn(this._opts.loader),this._state={pastDelay:!1,timedOut:!1};let{_res:e,_opts:s}=this;e.loading&&("number"==typeof s.delay&&(0===s.delay?this._state.pastDelay=!0:this._delay=setTimeout(()=>{this._update({pastDelay:!0})},s.delay)),"number"==typeof s.timeout&&(this._timeout=setTimeout(()=>{this._update({timedOut:!0})},s.timeout))),this._res.promise.then(()=>{this._update({}),this._clearTimeouts()}).catch(e=>{this._update({}),this._clearTimeouts()}),this._update({})}_update(e){this._state={...this._state,error:this._res.error,loaded:this._res.loaded,loading:this._res.loading,...e},this._callbacks.forEach(e=>e())}_clearTimeouts(){clearTimeout(this._delay),clearTimeout(this._timeout)}getCurrentValue(){return this._state}subscribe(e){return this._callbacks.add(e),()=>{this._callbacks.delete(e)}}constructor(e,s){this._loadFn=e,this._opts=s,this._callbacks=new Set,this._delay=null,this._timeout=null,this.retry()}}function h(e){return function(e,s){let n=Object.assign({loader:null,loading:null,delay:200,timeout:null,webpack:null,modules:null},s),a=null;function l(){if(!a){let s=new o(e,n);a={getCurrentValue:s.getCurrentValue.bind(s),subscribe:s.subscribe.bind(s),retry:s.retry.bind(s),promise:s.promise.bind(s)}}return a.promise()}if(!d){let e=n.webpack?n.webpack():n.modules;e&&t.push(s=>{for(let n of e)if(s.includes(n))return l()})}function c(e,s){!function(){l();let e=i.default.useContext(r.LoadableContext);e&&Array.isArray(n.modules)&&n.modules.forEach(s=>{e(s)})}();let t=i.default.useSyncExternalStore(a.subscribe,a.getCurrentValue,a.getCurrentValue);return i.default.useImperativeHandle(s,()=>({retry:a.retry}),[]),i.default.useMemo(()=>{var s;return t.loading||t.error?i.default.createElement(n.loading,{isLoading:t.loading,pastDelay:t.pastDelay,timedOut:t.timedOut,error:t.error,retry:a.retry}):t.loaded?i.default.createElement((s=t.loaded)&&s.default?s.default:s,e):null},[e,t])}return c.preload=()=>l(),c.displayName="LoadableComponent",i.default.forwardRef(c)}(c,e)}function m(e,s){let n=[];for(;e.length;){let a=e.pop();n.push(a(s))}return Promise.all(n).then(()=>{if(e.length)return m(e,s)})}h.preloadAll=()=>new Promise((e,s)=>{m(l).then(e,s)}),h.preloadReady=e=>(void 0===e&&(e=[]),new Promise(s=>{let n=()=>(d=!0,s());m(t,e).then(n,n)})),window.__NEXT_PRELOADREADY=h.preloadReady;let _=h},7802:function(e,s,n){"use strict";n.r(s);var a=n(5893),i=n(1664),r=n.n(i);n(7294);var l=n(1555),t=n(682),d=n(4051),c=n(7785),o=n(8347),h=n(9788),m=n(2309);s.default=()=>(0,a.jsxs)("div",{className:"Landing__37",children:[(0,a.jsx)("section",{className:"Landing__37__Banner",children:(0,a.jsxs)("div",{className:"Landing__37__Banner__Content",children:[(0,a.jsxs)("div",{className:"Landing__37__Menubar",children:[(0,a.jsx)(t.Z,{children:(0,a.jsx)(d.Z,{children:(0,a.jsx)(l.Z,{children:(0,a.jsx)("img",{className:"Landing__37__Banner__logo",src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/logo.png",alt:""})})})}),(0,a.jsx)("div",{className:"Landing__37__Banner__Texth1",children:(0,a.jsx)(t.Z,{children:(0,a.jsx)(d.Z,{children:(0,a.jsx)(l.Z,{children:(0,a.jsx)("h1",{children:"আপনার সৌন্দর্যের জন্য সেরা কম্বো প্যাকেজ একটাই প্রাকৃতিক সমাধান"})})})})})]}),(0,a.jsx)(t.Z,{children:(0,a.jsx)(d.Z,{className:" justify-content-center d-flex",children:(0,a.jsx)(l.Z,{lg:10,children:(0,a.jsxs)("div",{className:"Landing__37__Banner__Text",children:[(0,a.jsx)("h4",{children:"কমপক্ষে ১ বছর ঘরে বসে ব্যবহার করুন"}),(0,a.jsx)("div",{className:"Landing__37__ImgDiv",children:(0,a.jsx)("img",{className:"Landing__37__Banner__ImgMain",src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/banner.png",alt:""})}),(0,a.jsxs)("div",{className:"Landing__37__Banner__PriceDiv",children:[(0,a.jsx)("h5",{children:"এখনি অর্ডার করলে পাচ্ছেন ১১০০ টাকার প্যাকেজ "}),(0,a.jsx)("h6",{children:" অফার প্রাইজঃ মাত্র ১২৫০ টাকা।"}),(0,a.jsx)("div",{className:"Order",children:(0,a.jsxs)(r(),{href:"#placeAnOrder",children:["অর্ডার করতে ক্লিক করুন",(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/cart.png",alt:""})]})})]})]})})})})]})}),(0,a.jsx)("div",{className:"Section__Gaps"}),(0,a.jsx)("section",{children:(0,a.jsxs)(t.Z,{children:[(0,a.jsx)(d.Z,{children:(0,a.jsx)(l.Z,{children:(0,a.jsxs)("div",{className:"Landing__37__Cardh2__div",children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/down-arrow2.png",alt:""}),(0,a.jsx)("h2",{children:"বাংলাদেশে তৈরি একমাত্র আমাদের হাতে তৈরি সাবান"}),(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr.png",alt:""})]})})}),(0,a.jsxs)(d.Z,{children:[(0,a.jsx)(l.Z,{lg:6,children:(0,a.jsxs)("div",{className:"Landing__37__CardMain",children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/brade.png",alt:""}),(0,a.jsx)("h4",{children:"দারুচিনি সাবান বার"}),(0,a.jsx)("div",{className:"Landing__37__Hr"}),(0,a.jsx)("h5",{children:"উপকারিতাঃ"}),(0,a.jsxs)("ul",{children:[(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"ব্রণ ও ব্রণের দাগ দূর করে।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"ডার্ক সার্কেল রিমুভ করে ভুক টাইট করে।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"ত্বকের যে কোন দাগ রিমুভ করে।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"প্রাকৃতিকভাবে চেহারা ফর্সা করে ৫ শেড পর্যন্ত।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"সঠিক পুষ্টি যুগিয়ে ত্বকে ময়শ্চারাইজিং আনে।"})})]})]})}),(0,a.jsx)(l.Z,{lg:6,children:(0,a.jsxs)("div",{className:"Landing__37__CardMain",children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/papaya.png",alt:""}),(0,a.jsx)("h4",{children:"পেঁপে সাদা করার সাবান"}),(0,a.jsx)("div",{className:"Landing__37__Hr"}),(0,a.jsx)("h5",{children:"উপকারিতাঃ"}),(0,a.jsxs)("ul",{children:[(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"ত্বক ফর্সা করে।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"ত্বকের উজ্জলতা বৃদ্ধি করে।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"রোদ্রে পোড়া দাগ দূর করে।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"আগুনে পোড়া দাগ দূর করে।"})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"ব্রনের দাগ দূর করে।"})})]})]})})]}),(0,a.jsx)("div",{className:"Order order_center",children:(0,a.jsxs)(r(),{href:"#placeAnOrder",children:["অর্ডার করতে ক্লিক করুন",(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/cart.png",alt:""})]})})]})}),(0,a.jsx)("div",{className:"Section__Gaps"}),(0,a.jsx)("section",{className:"Landing__37__Video_Sec",children:(0,a.jsx)(t.Z,{children:(0,a.jsx)(d.Z,{children:(0,a.jsxs)(l.Z,{children:[(0,a.jsx)("div",{className:"Landing__37__VideoH2",children:(0,a.jsx)("h4",{children:"ফেস কেয়ার সেট কম্বো সব সমস্যা সমাধানে প্রাকৃতিক সেরা কম্বো প্যাকেজ অম্পর্ক আরো জানুন"})}),(0,a.jsx)("div",{className:"Landing__37__Video",children:(0,a.jsx)(h.Z,{})}),(0,a.jsx)("div",{className:"Order order_center",children:(0,a.jsxs)(r(),{href:"#placeAnOrder",children:["অর্ডার করতে ক্লিক করুন",(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/cart.png",alt:""})]})})]})})})}),(0,a.jsx)("section",{className:"Landing__37__Whybuy_Sec",children:(0,a.jsxs)(t.Z,{children:[(0,a.jsx)(d.Z,{children:(0,a.jsx)(l.Z,{children:(0,a.jsxs)("div",{className:"Landing__37__Cardh2__div",children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/down-arrow2.png",alt:""}),(0,a.jsx)("h2",{children:"আমাদের প্রডাক্ট কেন কিনবেন?"}),(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr.png",alt:""})]})})}),(0,a.jsx)(d.Z,{children:(0,a.jsx)(l.Z,{children:(0,a.jsx)("div",{className:"Landing__37__UlDiv",children:(0,a.jsxs)("ul",{children:[(0,a.jsxs)("li",{children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr2.png",alt:""}),(0,a.jsx)("p",{children:"আকর্ষনীয় প্যাকিং সুবিধা।"})]}),(0,a.jsxs)("li",{children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr2.png",alt:""}),(0,a.jsx)("p",{children:"সাশ্রয়ী মূল্যে বাংলাদেশে হাতে তৈরি কোয়ালিটি প্রোডাক্ট।"})]}),(0,a.jsxs)("li",{children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr2.png",alt:""}),(0,a.jsx)("p",{children:"১০০% কোয়ালিটি এবং ৩ দিনের রিটার্ন গ্যারান্টি। সার্বক্ষনিক কল"})]}),(0,a.jsxs)("li",{children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr2.png",alt:""}),(0,a.jsx)("p",{children:"সারাদেশে ২৪ থেকে ৭২ ঘন্টায় হোম ডেলিভারি।"})]})]})})})}),(0,a.jsx)("div",{className:"Section__Gaps"}),(0,a.jsx)(d.Z,{children:(0,a.jsx)(l.Z,{children:(0,a.jsx)("div",{className:"Landing__37__OffferMain",children:(0,a.jsxs)("div",{className:"Landing__37__Offfer",children:[(0,a.jsx)("h4",{children:"৪০০ গ্রামের রেগুলার মূল্য ১২০০ টাকা।"}),(0,a.jsx)("h5",{children:"অফার মূল্য ৮৯০ টাকা"}),(0,a.jsx)("h6",{children:"(ফ্রি হোম ডেলিভারি!!)"}),(0,a.jsx)("div",{className:"Order order_center",children:(0,a.jsxs)(r(),{href:"#placeAnOrder",children:["অর্ডার করতে ক্লিক করুন",(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/cart.png",alt:""})]})})]})})})})]})}),(0,a.jsx)("section",{children:(0,a.jsx)(t.Z,{children:(0,a.jsx)(d.Z,{children:(0,a.jsxs)(l.Z,{children:[(0,a.jsxs)("div",{className:"Landing__37__Natural",children:[(0,a.jsxs)("div",{className:"Landing__37__Cardh2__div",children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/down-arrow2.png",alt:""}),(0,a.jsx)("h2",{children:"আমাদের এই 100% ন্যাচারাল উপাদানে কিভাবে ব্যবহারঃ"}),(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr.png",alt:""})]}),(0,a.jsx)("div",{className:"Landing__37__Natural__txtDiv",children:(0,a.jsxs)("ul",{children:[(0,a.jsx)("li",{children:(0,a.jsxs)("p",{children:["প্রতিদিন সকালে এবং রাতে রোজ চন্দন কেক দিয়ে আলতো করে হাতের সাহায্যে মুখে ১-২ মিনিট ম্যাসাজ করবেন"," "]})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:"এরপর পানি দিয়ে ভালোভাবে ধুয়ে মুছে নিন যাদের "})}),(0,a.jsx)("li",{children:(0,a.jsxs)("p",{children:["ব্রণ সমস্যা আছে তাঁরা Neroli Essential Oil ড্রপ ২-৩ ফোটা নিয়ে সকালে মৃদু ম্যাসেজ করুন"," "]})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:" ব্রণ খুব বেশি হলে সকাল এবং দুপুর ব্যবহার করুন। "})}),(0,a.jsx)("li",{children:(0,a.jsx)("p",{children:" তারপর রাতে Sensocare ক্রিম ব্যবহার করুন। "})}),(0,a.jsx)("li",{children:(0,a.jsxs)("p",{children:["প্রাকৃতিক হওয়ায় কোন প্রকার পার্শ্ব প্রতিক্রিয়া নেই।"," "]})})]})})]}),(0,a.jsx)("div",{className:"Landing__37__OrderPosition",children:(0,a.jsx)("div",{className:"Order order_center",children:(0,a.jsxs)(r(),{href:"#placeAnOrder",children:["অর্ডার করতে ক্লিক করুন",(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/cart.png",alt:""})]})})}),(0,a.jsxs)("div",{className:"Landing__37__Cardh2__div Landing__37__Cardh2__div2",children:[(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/down-arrow2.png",alt:""}),(0,a.jsx)("h2",{children:"ত্বকের যত্নে যত্ন নিন প্রাকৃতিক উপায়ে।"}),(0,a.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-37/arr.png",alt:""})]})]})})})}),(0,a.jsx)("div",{className:"Section__Gaps"}),(0,a.jsx)(o.Z,{}),(0,a.jsx)("div",{id:"placeAnOrder",children:(0,a.jsx)(c.Z,{})}),(0,a.jsx)(m.Z,{})]})},6276:function(e){e.exports={CustomerReviewContent:"customer-review_CustomerReviewContent__QAt_k",CustomerReviewImg:"customer-review_CustomerReviewImg__1Fuey"}},5152:function(e,s,n){e.exports=n(5677)}},function(e){e.O(0,[5937,1228,9678,3931,9774,2888,179],function(){return e(e.s=7441)}),_N_E=e.O()}]);