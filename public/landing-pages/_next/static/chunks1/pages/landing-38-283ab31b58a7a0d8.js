(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[5738],{8570:function(e,s,n){(window.__NEXT_P=window.__NEXT_P||[]).push(["/landing-38",function(){return n(4403)}])},8347:function(e,s,n){"use strict";var i=n(5893);n(7294);var a=n(1555),l=n(682),r=n(4051),t=n(6276),d=n.n(t);s.Z=()=>(0,i.jsx)("div",{id:"CustomerReview",className:"CustomerReview",children:(0,i.jsx)("section",{id:"CustomerReviewContent",className:d().CustomerReviewContent,children:(0,i.jsx)(l.Z,{children:(0,i.jsxs)(r.Z,{children:[(0,i.jsx)(a.Z,{lg:12,children:(0,i.jsx)("h2",{children:"আমাদের কাস্টমার রিভিউ"})}),(0,i.jsx)(a.Z,{lg:6,sm:6,children:(0,i.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,i.jsx)("img",{src:"/images/customer-review/customer-review1.png",alt:""})})}),(0,i.jsx)(a.Z,{lg:6,sm:6,children:(0,i.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,i.jsx)("img",{src:"/images/customer-review/customer-review2.png",alt:""})})}),(0,i.jsx)(a.Z,{lg:6,sm:6,children:(0,i.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,i.jsx)("img",{src:"/images/customer-review/customer-review3.png",alt:""})})}),(0,i.jsx)(a.Z,{lg:6,sm:6,children:(0,i.jsx)("div",{id:"CustomerReviewImg",className:d().CustomerReviewImg,children:(0,i.jsx)("img",{src:"/images/customer-review/customer-review1.png",alt:""})})})]})})})})},5677:function(e,s,n){"use strict";Object.defineProperty(s,"__esModule",{value:!0}),function(e,s){for(var n in s)Object.defineProperty(e,n,{enumerable:!0,get:s[n]})}(s,{noSSR:function(){return r},default:function(){return t}});let i=n(8754),a=(n(7294),i._(n(8976)));function l(e){return{default:(null==e?void 0:e.default)||e}}function r(e,s){return delete s.webpack,delete s.modules,e(s)}function t(e,s){let n=a.default,i={loading:e=>{let{error:s,isLoading:n,pastDelay:i}=e;return null}};e instanceof Promise?i.loader=()=>e:"function"==typeof e?i.loader=e:"object"==typeof e&&(i={...i,...e}),i={...i,...s};let t=i.loader;return(i.loadableGenerated&&(i={...i,...i.loadableGenerated},delete i.loadableGenerated),"boolean"!=typeof i.ssr||i.ssr)?n({...i,loader:()=>null!=t?t().then(l):Promise.resolve(l(()=>null))}):(delete i.webpack,delete i.modules,r(n,i))}("function"==typeof s.default||"object"==typeof s.default&&null!==s.default)&&void 0===s.default.__esModule&&(Object.defineProperty(s.default,"__esModule",{value:!0}),Object.assign(s.default,s),e.exports=s.default)},2254:function(e,s,n){"use strict";Object.defineProperty(s,"__esModule",{value:!0}),Object.defineProperty(s,"LoadableContext",{enumerable:!0,get:function(){return l}});let i=n(8754),a=i._(n(7294)),l=a.default.createContext(null)},8976:function(e,s,n){"use strict";/**
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
*/Object.defineProperty(s,"__esModule",{value:!0}),Object.defineProperty(s,"default",{enumerable:!0,get:function(){return _}});let i=n(8754),a=i._(n(7294)),l=n(2254),r=[],t=[],d=!1;function c(e){let s=e(),n={loading:!0,loaded:null,error:null};return n.promise=s.then(e=>(n.loading=!1,n.loaded=e,e)).catch(e=>{throw n.loading=!1,n.error=e,e}),n}class o{promise(){return this._res.promise}retry(){this._clearTimeouts(),this._res=this._loadFn(this._opts.loader),this._state={pastDelay:!1,timedOut:!1};let{_res:e,_opts:s}=this;e.loading&&("number"==typeof s.delay&&(0===s.delay?this._state.pastDelay=!0:this._delay=setTimeout(()=>{this._update({pastDelay:!0})},s.delay)),"number"==typeof s.timeout&&(this._timeout=setTimeout(()=>{this._update({timedOut:!0})},s.timeout))),this._res.promise.then(()=>{this._update({}),this._clearTimeouts()}).catch(e=>{this._update({}),this._clearTimeouts()}),this._update({})}_update(e){this._state={...this._state,error:this._res.error,loaded:this._res.loaded,loading:this._res.loading,...e},this._callbacks.forEach(e=>e())}_clearTimeouts(){clearTimeout(this._delay),clearTimeout(this._timeout)}getCurrentValue(){return this._state}subscribe(e){return this._callbacks.add(e),()=>{this._callbacks.delete(e)}}constructor(e,s){this._loadFn=e,this._opts=s,this._callbacks=new Set,this._delay=null,this._timeout=null,this.retry()}}function h(e){return function(e,s){let n=Object.assign({loader:null,loading:null,delay:200,timeout:null,webpack:null,modules:null},s),i=null;function r(){if(!i){let s=new o(e,n);i={getCurrentValue:s.getCurrentValue.bind(s),subscribe:s.subscribe.bind(s),retry:s.retry.bind(s),promise:s.promise.bind(s)}}return i.promise()}if(!d){let e=n.webpack?n.webpack():n.modules;e&&t.push(s=>{for(let n of e)if(s.includes(n))return r()})}function c(e,s){!function(){r();let e=a.default.useContext(l.LoadableContext);e&&Array.isArray(n.modules)&&n.modules.forEach(s=>{e(s)})}();let t=a.default.useSyncExternalStore(i.subscribe,i.getCurrentValue,i.getCurrentValue);return a.default.useImperativeHandle(s,()=>({retry:i.retry}),[]),a.default.useMemo(()=>{var s;return t.loading||t.error?a.default.createElement(n.loading,{isLoading:t.loading,pastDelay:t.pastDelay,timedOut:t.timedOut,error:t.error,retry:i.retry}):t.loaded?a.default.createElement((s=t.loaded)&&s.default?s.default:s,e):null},[e,t])}return c.preload=()=>r(),c.displayName="LoadableComponent",a.default.forwardRef(c)}(c,e)}function m(e,s){let n=[];for(;e.length;){let i=e.pop();n.push(i(s))}return Promise.all(n).then(()=>{if(e.length)return m(e,s)})}h.preloadAll=()=>new Promise((e,s)=>{m(r).then(e,s)}),h.preloadReady=e=>(void 0===e&&(e=[]),new Promise(s=>{let n=()=>(d=!0,s());m(t,e).then(n,n)})),window.__NEXT_PRELOADREADY=h.preloadReady;let _=h},4403:function(e,s,n){"use strict";n.r(s);var i=n(5893),a=n(1664),l=n.n(a);n(7294);var r=n(1555),t=n(682),d=n(4051),c=n(7785),o=n(8347),h=n(9788),m=n(2309);s.default=()=>(0,i.jsxs)("div",{className:"Landing__38",children:[(0,i.jsx)("section",{className:"Landing__38__Banner",children:(0,i.jsx)("div",{className:"Landing__38__Banner__Content",children:(0,i.jsx)(t.Z,{children:(0,i.jsx)(d.Z,{className:" justify-content-center d-flex",children:(0,i.jsx)(r.Z,{lg:12,children:(0,i.jsxs)("div",{className:"Landing__38__Banner__Text",children:[(0,i.jsx)("img",{className:"Landing__38__logo",src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/logo.png",alt:""}),(0,i.jsxs)("h1",{children:["বেবি জিম র্যাক এবং গেম প্যাড কম্বো বেবি জিম প্লে ম্যাট সঙ্গে 30 টি খেলনা বল আছে এই ",(0,i.jsx)("span",{children:"Kids Toys"})]}),(0,i.jsx)("div",{className:"Landing__38__VidDiv",children:(0,i.jsx)(h.Z,{})})]})})})})})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("section",{children:(0,i.jsx)(t.Z,{children:(0,i.jsx)(d.Z,{children:(0,i.jsx)(r.Z,{children:(0,i.jsxs)("div",{className:"Landing__38__Banner__PriceDiv",children:[(0,i.jsx)("p",{children:"আমাদের 30টি খেলনা বল সহ আকর্ষণীয় রঙের বেবি জিম র্যাক চেয়ার রয়েছে"}),(0,i.jsx)("h5",{children:"অর্ডার বা আরো বিস্তারিত জানতে করতে কল করুন "}),(0,i.jsxs)("div",{className:"Landing__38__Banner__Mobile",children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/call.png",alt:""}),(0,i.jsx)("h6",{children:" মোবাইলঃ +880123456789"})]}),(0,i.jsx)("div",{className:"Order",children:(0,i.jsxs)(l(),{href:"#placeAnOrder",children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/order.png",alt:""}),"এখানে অর্ডার করুন ১১৫০ টাকায়"]})})]})})})})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("section",{className:"Landing__38__CardSec",children:(0,i.jsx)(t.Z,{children:(0,i.jsx)(d.Z,{children:(0,i.jsx)(r.Z,{children:(0,i.jsxs)("div",{className:"Landing__38__Card",children:[(0,i.jsx)("div",{className:"Landing__38__CardH2",children:(0,i.jsx)("h2",{children:"বাচ্চাদের জন্য বেবি জিম র্যাক এবং গেম প্যাড কম্বো কেন দরকার ?"})}),(0,i.jsxs)("div",{className:"Landing__38__Card__text",children:[(0,i.jsxs)("div",{children:[" ","অনেক সময় দেখা যায় আমাদের সোনামনিরা ঘুমাইতে চায় না, এই বেবি বাউঞ্চারের উপর রাখলে আপনার সোনামনি দুলতে দুলতে কান্নাকাটি থামিয়ে আনায়াসে"," "]}),(0,i.jsxs)("div",{children:[" ","এর উপরে সোনামনিকে রেখে নড়াচড়া করলেই নিজে নিজে দুলতে থাকবে, ফলে সে ফুরফুরে মেজাজে থাকবে ঘন্টার পর ঘন্টা।"," "]}),(0,i.jsxs)("div",{children:[" ","এর উপরে সোনামনিকে বসিয়ে মজার ছলে তাকে সহজেই খাওয়াতে পারবেন, গাঁয়ে তেল বা লোশন দিতে পারবেন, হাত-পায়ের নখ কাটতে পারবেন।"]}),(0,i.jsxs)("div",{children:[" ","সোনামনিরা হাত-পা নাড়াচাড়া করতে ভালবাসে, বেবি বাউন্সারে থাকা খেলনা স্পর্শ বা নাড়াচাড়া করতে চায়, এতে তার পেশীকে শক্তিশালী করে।"," "]}),(0,i.jsxs)("div",{children:[" ","বাউন্সারে সোনামনিকে বসালে তার মাথা,ঘাড়,কোমর ও মেরুদন্ড সোজা রাখে, যার ফলে আপনার সোনামনির শারীরিক গঠনে সাহায্যে করবে।"," "]}),(0,i.jsxs)("div",{children:[" ","এখন ঘন ঘন বিদ্যুৎ চলে যায়, তাই এই গরমে সোনামনিকে প্রাকৃতিক আবহাওয়ায় রাখতে পারবেন বাউন্সারে বসিয়ে বারান্দায় বা ঘরের বাহিরে যে কোনো ছায়া জায়গায়।"," "]}),(0,i.jsxs)("div",{children:[" ","অনেক সময় দেখা যায় আমাদের সোনামনিরা ঘুমাইতে চায় না, এই বেবি বাউঞ্চারের উপর রাখলে আপনার সোনামনি দুলতে দুলতে কান্নাকাটি থামিয়ে আনায়াসে"," "]}),(0,i.jsxs)("div",{children:[" ","এর উপরে সোনামনিকে রেখে নড়াচড়া করলেই নিজে নিজে দুলতে থাকবে, ফলে সে ফুরফুরে মেজাজে থাকবে ঘন্টার পর ঘন্টা।"," "]}),(0,i.jsxs)("div",{children:[" ","এর উপরে সোনামনিকে বসিয়ে মজার ছলে তাকে সহজেই খাওয়াতে পারবেন, গাঁয়ে তেল বা লোশন দিতে পারবেন, হাত-পায়ের নখ কাটতে পারবেন।"," "]})]}),(0,i.jsx)("div",{className:"Order Order_center",children:(0,i.jsxs)(l(),{href:"#placeAnOrder",children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/order.png",alt:""}),"এখানে অর্ডার করুন ১১৫০ টাকায়"]})})]})})})})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("section",{children:(0,i.jsx)(t.Z,{children:(0,i.jsx)(d.Z,{children:(0,i.jsx)(r.Z,{children:(0,i.jsxs)("div",{className:"Landing__38__Delivery",children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/nogod.png",alt:""}),(0,i.jsx)("p",{children:"আপনার শিশুকে বিনোদন দেওয়ার এবং তাকে শারীরিক ও মানসিক বিকাশে সাহায্য করবে ফলে আপনার সোনামণি থাকবে পরম যত্নে ও নিরাপদে।"}),(0,i.jsxs)("div",{className:"Landing__38__Delivery_flex",children:[(0,i.jsx)("div",{children:"মরিচা ধরার সুযোগ নেই "}),(0,i.jsx)("div",{children:"কাপড় Mokmol ফেব্রিক্স "}),(0,i.jsx)("div",{children:" উন্নত মানের Lock System"})]})]})})})})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("section",{children:(0,i.jsxs)(t.Z,{children:[(0,i.jsx)(d.Z,{children:(0,i.jsx)(r.Z,{children:(0,i.jsx)("div",{className:"Landing__38__WhyUse",children:(0,i.jsx)("div",{className:"Landing__38__CardH2",children:(0,i.jsx)("h2",{children:"সোনামনির জন্য কেন ব্যাবহার করা উচিত?"})})})})}),(0,i.jsxs)(d.Z,{className:" d-flex align-items-center",children:[(0,i.jsx)(r.Z,{lg:5,children:(0,i.jsx)("div",{className:"Landing__38__WhyUse__Img",children:(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/banner.png",alt:""})})}),(0,i.jsx)(r.Z,{lg:7,children:(0,i.jsx)("div",{className:"Landing__38__WhyUse__Ul",children:(0,i.jsxs)("ul",{children:[(0,i.jsxs)("li",{children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/arr.png",alt:""}),(0,i.jsxs)("p",{children:["বাবু যখন খেতে চায় না। বেবি সুপার চেয়ারে বসিয়ে খাওয়াতে পারবেন।"," "]})]}),(0,i.jsxs)("li",{children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/arr.png",alt:""}),(0,i.jsx)("p",{children:"গোসলের পর তৈল মালিশ করতে পারবেন। রোধ পোহাতে পারবেন। "})]}),(0,i.jsxs)("li",{children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/arr.png",alt:""}),(0,i.jsxs)("p",{children:["বেবি সুপার চেয়ারে বাবুকে রেখে, ঘরের সব কাজ করতে পারবেন।"," "]})]}),(0,i.jsxs)("li",{children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/arr.png",alt:""}),(0,i.jsxs)("p",{children:["রান্না করা, কাপর দোয়া ,ঘর পরিস্কার করা। যাবতিয় সব কাজ করতে পারবেন।"," "]})]}),(0,i.jsxs)("li",{children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/arr.png",alt:""}),(0,i.jsxs)("p",{children:["কাপরটি মকমল ফেব্রিকিস এবং দীর্ঘদিন ব্যাবহার করতে পারবেন।"," "]})]}),(0,i.jsxs)("li",{children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/arr.png",alt:""}),(0,i.jsx)("p",{children:"এটাতে বসিয়ে সেফটি লক দুটি লাগিয়ে দিলে বাচ্চা পরে জাওয়ার সম্ববনা নেই।"})]}),(0,i.jsxs)("li",{className:"Landing__38__WhyUse__Ul_last",children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/arr.png",alt:""}),(0,i.jsx)("p",{children:"বসার স্থানে নেট যুক্ত করা আছে।"})]})]})})})]}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("div",{className:"Order Order_center",children:(0,i.jsxs)(l(),{href:"#placeAnOrder",children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/order.png",alt:""}),"এখানে অর্ডার করুন ১১৫০ টাকায়"]})})]})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("section",{className:"Landing__38__Banner2Sec",children:(0,i.jsx)(t.Z,{children:(0,i.jsx)(d.Z,{className:"d_flex justify-content-center ",children:(0,i.jsx)(r.Z,{lg:10,children:(0,i.jsx)("div",{className:"Landing__38__Banner2",children:(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/banner2.png",alt:""})})})})})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("section",{children:(0,i.jsxs)(t.Z,{children:[(0,i.jsxs)("div",{className:"Landing__38__ImgBox",children:[(0,i.jsx)(d.Z,{children:(0,i.jsx)(r.Z,{children:(0,i.jsx)("div",{className:"Landing__38__CardH2",children:(0,i.jsx)("h2",{children:"কম্বো বেবি জিম প্লে ম্যাটের পণ্যের ছবি গুলা দেখুন"})})})}),(0,i.jsxs)("div",{className:"Landing__38__ImgBox2",children:[(0,i.jsxs)(d.Z,{children:[(0,i.jsx)(r.Z,{lg:6,children:(0,i.jsx)("div",{className:"Landing__38__img2",children:(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/troy1.png",alt:""})})}),(0,i.jsx)(r.Z,{lg:6,children:(0,i.jsx)("div",{className:"Landing__38__img2",children:(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/troy2.png",alt:""})})})]}),(0,i.jsx)(d.Z,{children:(0,i.jsx)(r.Z,{children:(0,i.jsx)("div",{className:"Landing__38__img3",children:(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/troy3.png",alt:""})})})})]})]}),(0,i.jsx)("div",{className:"Order Order_center",children:(0,i.jsxs)(l(),{href:"#placeAnOrder",children:[(0,i.jsx)("img",{src:"https://landing-page-images-1.s3.ap-south-1.amazonaws.com/landing-38/order.png",alt:""}),"এখানে অর্ডার করুন ১১৫০ টাকায়"]})})]})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)("section",{children:(0,i.jsx)(t.Z,{children:(0,i.jsx)(d.Z,{children:(0,i.jsx)(r.Z,{children:(0,i.jsxs)("div",{className:"Landing__38__Quality",children:[(0,i.jsxs)("h4",{children:["অনলাইনে লো কোয়লিটির বেবি জিম র্যাক এবং গেম প্যাড কম্বো যা লোহার তৈরি অনেকদিন ব্যবহার করতে পারবেন"," ",(0,i.jsx)("span",{children:"সোনামনির জন্য নিশ্চিন্তে।"})]}),(0,i.jsx)("h5",{children:"কোন প্রশ্ন বা সাহায্য লাগলে কল করুনঃ +880123456789"})]})})})})}),(0,i.jsx)("div",{className:"Section__Gaps"}),(0,i.jsx)(o.Z,{}),(0,i.jsx)("div",{id:"placeAnOrder",children:(0,i.jsx)(c.Z,{})}),(0,i.jsx)(m.Z,{})]})},6276:function(e){e.exports={CustomerReviewContent:"customer-review_CustomerReviewContent__QAt_k",CustomerReviewImg:"customer-review_CustomerReviewImg__1Fuey"}},5152:function(e,s,n){e.exports=n(5677)}},function(e){e.O(0,[5937,1228,9678,3931,9774,2888,179],function(){return e(e.s=8570)}),_N_E=e.O()}]);