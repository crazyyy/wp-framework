"use strict";(globalThis.webpackChunkcomplianz_gdpr=globalThis.webpackChunkcomplianz_gdpr||[]).push([[8432,3404,2572,4056,9056],{13404:(e,t,n)=>{n.r(t),n.d(t,{UseCookieScanData:()=>o});var a=n(30809),l=n(61744);const o=(0,a.Su)(((e,t)=>({initialLoadCompleted:!1,setInitialLoadCompleted:t=>e({initialLoadCompleted:t}),iframeLoaded:!1,loading:!1,nextPage:!1,progress:0,cookies:[],lastLoadedIframe:"",setIframeLoaded:t=>e({iframeLoaded:t}),setLastLoadedIframe:t=>e((e=>({lastLoadedIframe:t}))),setProgress:t=>e({progress:t}),fetchProgress:()=>(e({loading:!0}),l.doAction("get_scan_progress",{}).then((t=>(e({initialLoadCompleted:!0,loading:!1,nextPage:t.next_page,progress:t.progress,cookies:t.cookies}),t))))})))},8432:(e,t,n)=>{n.r(t),n.d(t,{default:()=>p});var a=n(51280),l=n(15832),o=n(93396),r=n(79056),c=n(26552),i=n(25536),s=n(88496),d=n(38912),m=n(14056);const u=e=>{const{getFieldValue:t,showSavedSettingsNotice:n}=(0,i.default)(),{language:l,saving:r,purposesOptions:u,services:p,updateCookie:f,toggleDeleteCookie:_,saveCookie:g}=(0,c.default)(),[b,E]=(0,s.useState)(""),[h,v]=(0,s.useState)(""),[k,y]=(0,s.useState)(""),[z,N]=(0,s.useState)([]);let w="no"!==t("use_cdb_api"),C=!!w&&1==e.sync,O=C;r&&(O=!0);let I=!1;e.slug.length>0&&(I="https://cookiedatabase.org/cookie/"+(e.service?e.service:"unknown-service")+"/"+e.slug),(0,s.useEffect)((()=>{e&&e.cookieFunction&&y(e.cookieFunction)}),[e]);const x=(e,t,n)=>{f(t,n,e)};(0,s.useEffect)((()=>{e&&e.name&&E(e.name)}),[e.name]),(0,s.useEffect)((()=>{if(!e)return;if(e.name===b)return;const t=setTimeout((()=>{f(e.ID,"name",b)}),500);return()=>{clearTimeout(t)}}),[b]),(0,s.useEffect)((()=>{if(!e)return;if(e.cookieFunction===k)return;const t=setTimeout((()=>{f(e.ID,"cookieFunction",k)}),500);return()=>{clearTimeout(t)}}),[k]),(0,s.useEffect)((()=>{e&&e.retention&&v(e.retention)}),[e.retention]),(0,s.useEffect)((()=>{if(!e)return;if(e.retention===h)return;const t=setTimeout((()=>{f(e.ID,"retention",h)}),500);return()=>{clearTimeout(t)}}),[h]),(0,s.useEffect)((()=>{let e=u&&u.hasOwnProperty(l)?u[l]:[];e=e.map((e=>({label:e.label,value:e.label}))),N(e)}),[l,u]);const S=(e,t,n)=>{f(t,n,e)};if(!e)return null;let D=-1!==e.name.indexOf("cmplz_")||C,T=1!=e.deleted?"cmplz-reset-button":"",P=p.map(((e,t)=>({value:e.ID,label:e.name}))),A=!1,L="Marketing";z.forEach((function(e,t){e.value&&-1!==e.value.indexOf("/")&&(A=!0,L=e.value,L=L.substring(0,L.indexOf("/")))}));let M=e.purpose&&-1!==e.purpose.indexOf("/");M&&(L=e.purpose.substring(0,e.purpose.indexOf("/"))),A&&!M&&z.forEach((function(e,t){e.value&&-1!==e.value.indexOf("/")&&(e.value=L,e.label=L,z[t]=e)}));let U=e.purpose;return!A&&M&&(U=L),(0,a.createElement)(a.Fragment,null,(0,a.createElement)("div",{className:"cmplz-details-row cmplz-details-row__checkbox"},(0,a.createElement)(d.default,{id:e.ID+"_cdb_api",disabled:!w,value:C,onChange:t=>S(t,e.ID,"sync"),options:{true:(0,o.__)("Sync cookie with cookiedatabase.org","complianz-gdpr")}})),(0,a.createElement)("div",{className:"cmplz-details-row cmplz-details-row__checkbox"},(0,a.createElement)(d.default,{id:e.ID+"showOnPolicy",disabled:O,value:e.showOnPolicy,onChange:t=>S(t,e.ID,"showOnPolicy"),options:{true:(0,o.__)("Show cookie on Cookie Policy","complianz-gdpr")}})),(0,a.createElement)("div",{className:"cmplz-details-row"},(0,a.createElement)("label",null,(0,o.__)("Name","complianz-gdpr")),(0,a.createElement)("input",{disabled:O,onChange:e=>E(e.target.value),type:"text",placeholder:(0,o.__)("Name","complianz-gdpr"),value:b})),(0,a.createElement)("div",{className:"cmplz-details-row"},(0,a.createElement)("label",null,(0,o.__)("Service","complianz-gdpr")),(0,a.createElement)(m.default,{disabled:O,value:e.serviceID,options:P,onChange:t=>x(t,e.ID,"serviceID")})),(0,a.createElement)("div",{className:"cmplz-details-row"},(0,a.createElement)("label",null,(0,o.__)("Expiration","complianz-gdpr")),(0,a.createElement)("input",{disabled:D,onChange:e=>v(e.target.value),type:"text",placeholder:(0,o.__)("1 year","complianz-gdpr"),value:h})),(0,a.createElement)("div",{className:"cmplz-details-row"},(0,a.createElement)("label",null,(0,o.__)("Cookie function","complianz-gdpr")),(0,a.createElement)("input",{disabled:O,onChange:e=>y(e.target.value),type:"text",placeholder:(0,o.__)("e.g. store user ID","complianz-gdpr"),value:k})),(0,a.createElement)("div",{className:"cmplz-details-row"},(0,a.createElement)("label",null,(0,o.__)("Purpose","complianz-gdpr")),(0,a.createElement)(m.default,{disabled:O,value:U,options:z,onChange:t=>x(t,e.ID,"purpose")})),I&&(0,a.createElement)("div",{className:"cmplz-details-row"},(0,a.createElement)("a",{href:I,target:"_blank",rel:"noopener noreferrer"},(0,o.__)("View cookie on cookiedatabase.org","complianz-gdpr"))),(0,a.createElement)("div",{className:"cmplz-details-row cmplz-details-row__buttons"},(0,a.createElement)("button",{disabled:r,onClick:t=>(async e=>{await g(e),n((0,o.__)("Saved cookie","complianz-gdpr"))})(e.ID),className:"button button-default"},(0,o.__)("Save","complianz-gdpr")),(0,a.createElement)("button",{className:"button button-default "+T,onClick:t=>(async e=>{await _(e)})(e.ID)},1==e.deleted&&(0,o.__)("Restore","complianz-gdpr"),1!=e.deleted&&(0,o.__)("Delete","complianz-gdpr"))))},p=(0,s.memo)((({cookie:e,id:t})=>{let n="";e.deleted?n=" | "+(0,o.__)("Deleted","complianz-gdpr"):e.showOnPolicy?e.isMembersOnly&&(n=" | "+(0,o.__)("Logged in users only, ignored","complianz-gdpr")):n=" | "+(0,o.__)("Admin, ignored","complianz-gdpr");let c=e.name;return(0,a.createElement)(a.Fragment,null,(0,a.createElement)(r.default,{id:t,summary:c,comment:n,icons:(0,a.createElement)(a.Fragment,null,e.complete&&(0,a.createElement)(l.default,{tooltip:(0,o.__)("The data for this cookie is complete","complianz-gdpr"),name:"success",color:"green"}),!e.complete&&(0,a.createElement)(l.default,{tooltip:(0,o.__)("This cookie has missing fields","complianz-gdpr"),name:"times",color:"red"}),e.sync&&e.synced&&(0,a.createElement)(l.default,{name:"rotate",color:"green"}),!e.synced||!e.sync&&(0,a.createElement)(l.default,{tooltip:(0,o.__)("This cookie is not synchronized with cookiedatabase.org.","complianz-gdpr"),name:"rotate-error",color:"red"}),e.showOnPolicy&&(0,a.createElement)(l.default,{tooltip:(0,o.__)("This cookie will be on your Cookie Policy","complianz-gdpr"),name:"file",color:"green"}),!e.showOnPolicy&&(0,a.createElement)(l.default,{tooltip:(0,o.__)("This cookie is not shown on the Cookie Policy","complianz-gdpr"),name:"file-disabled",color:"grey"}),e.old&&(0,a.createElement)(l.default,{tooltip:(0,o.__)("This cookie has not been detected on your site in the last three months","complianz-gdpr"),name:"calendar-error",color:"red"}),!e.old&&(0,a.createElement)(l.default,{tooltip:(0,o.__)("This cookie has recently been detected","complianz-gdpr"),name:"calendar",color:"green"})),details:u(e),style:(()=>{if(e.deleted)return Object.assign({},{backgroundColor:"var(--rsp-red-faded)"})})()}))}))},32572:(e,t,n)=>{n.r(t),n.d(t,{default:()=>m});var a=n(51280),l=n(88496),o=n(61744),r=n(25536),c=n(38924),i=n(87287),s=n(13404),d=n(64224);const m=(0,l.memo)((({type:e="action",style:t="tertiary",label:n,onClick:m,href:u="",target:p="",disabled:f,action:_,field:g,children:b})=>{if(!n&&!b)return null;const E=(g&&g.button_text?g.button_text:n)||b,{fetchFieldsData:h,showSavedSettingsNotice:v}=(0,r.default)(),{setInitialLoadCompleted:k,setProgress:y}=(0,s.UseCookieScanData)(),{setProgressLoaded:z}=(0,d.default)(),{selectedSubMenuItem:N}=(0,c.default)(),[w,C]=(0,l.useState)(!1),O=`button cmplz-button button--${t} button-${e}`,I=async e=>{await o.doAction(g.action,{}).then((e=>{e.success&&(h(N),"reset_settings"===e.id&&(k(!1),y(0),z(!1)),v(e.message))}))},x=g&&g.warn?g.warn:"";return"action"===e?(0,a.createElement)(a.Fragment,null,i.__experimentalConfirmDialog&&(0,a.createElement)(i.__experimentalConfirmDialog,{isOpen:w,onConfirm:async()=>{C(!1),await I()},onCancel:()=>{C(!1)}},x),(0,a.createElement)("button",{className:O,onClick:async t=>{if("action"!==e||!m)return"action"===e&&_?i.__experimentalConfirmDialog?void(g&&g.warn?C(!0):await I()):void await I():void(window.location.href=g.url);m(t)},disabled:f},E)):"link"===e?(0,a.createElement)("a",{className:O,href:u,target:p},E):void 0}))},38912:(e,t,n)=>{n.r(t),n.d(t,{default:()=>I});var a=n(51280),l=n(45072),o=n(40304),r=n(59016),c=n(3608),i=n(84664),s=n(37408),d=n(15920),m=n(76860),u=n(61480);const p="Checkbox",[f,_]=(0,r._)(p),[g,b]=f(p),E=(0,a.forwardRef)(((e,t)=>{const{__scopeCheckbox:n,name:r,checked:s,defaultChecked:d,required:m,disabled:p,value:f="on",onCheckedChange:_,...b}=e,[E,y]=(0,a.useState)(null),z=(0,o.q)(t,(e=>y(e))),N=(0,a.useRef)(!1),w=!E||Boolean(E.closest("form")),[C=!1,O]=(0,i.W)({prop:s,defaultProp:d,onChange:_}),I=(0,a.useRef)(C);return(0,a.useEffect)((()=>{const e=null==E?void 0:E.form;if(e){const t=()=>O(I.current);return e.addEventListener("reset",t),()=>e.removeEventListener("reset",t)}}),[E,O]),(0,a.createElement)(g,{scope:n,state:C,disabled:p},(0,a.createElement)(u.K0.button,(0,l.c)({type:"button",role:"checkbox","aria-checked":v(C)?"mixed":C,"aria-required":m,"data-state":k(C),"data-disabled":p?"":void 0,disabled:p,value:f},b,{ref:z,onKeyDown:(0,c.K)(e.onKeyDown,(e=>{"Enter"===e.key&&e.preventDefault()})),onClick:(0,c.K)(e.onClick,(e=>{O((e=>!!v(e)||!e)),w&&(N.current=e.isPropagationStopped(),N.current||e.stopPropagation())}))})),w&&(0,a.createElement)(h,{control:E,bubbles:!N.current,name:r,value:f,checked:C,required:m,disabled:p,style:{transform:"translateX(-100%)"}}))})),h=e=>{const{control:t,checked:n,bubbles:o=!0,...r}=e,c=(0,a.useRef)(null),i=(0,s.i)(n),m=(0,d.k)(t);return(0,a.useEffect)((()=>{const e=c.current,t=window.HTMLInputElement.prototype,a=Object.getOwnPropertyDescriptor(t,"checked").set;if(i!==n&&a){const t=new Event("click",{bubbles:o});e.indeterminate=v(n),a.call(e,!v(n)&&n),e.dispatchEvent(t)}}),[i,n,o]),(0,a.createElement)("input",(0,l.c)({type:"checkbox","aria-hidden":!0,defaultChecked:!v(n)&&n},r,{tabIndex:-1,ref:c,style:{...e.style,...m,position:"absolute",pointerEvents:"none",opacity:0,margin:0}}))};function v(e){return"indeterminate"===e}function k(e){return v(e)?"indeterminate":e?"checked":"unchecked"}const y=E,z=(0,a.forwardRef)(((e,t)=>{const{__scopeCheckbox:n,forceMount:o,...r}=e,c=b("CheckboxIndicator",n);return(0,a.createElement)(m.s,{present:o||v(c.state)||!0===c.state},(0,a.createElement)(u.K0.span,(0,l.c)({"data-state":k(c.state),"data-disabled":c.disabled?"":void 0},r,{ref:t,style:{pointerEvents:"none",...e.style}})))}));var N=n(93396),w=n(15832),C=n(88496),O=n(32572);const I=(0,C.memo)((({indeterminate:e,label:t,value:n,id:l,onChange:o,required:r,disabled:c,options:i={}})=>{const[s,d]=(0,C.useState)(!1),[m,u]=(0,C.useState)(!1);let p=n;Array.isArray(p)||(p=""===p?[]:[p]),(0,C.useEffect)((()=>{let e=1===Object.keys(i).length&&"true"===Object.keys(i)[0];d(e)}),[]),e&&(n=!0);const f=p;let _=!1;Object.keys(i).length>10&&(_=!0);const g=e=>s?n:f.includes(""+e)||f.includes(parseInt(e)),b=()=>{u(!m)};let E=c&&!Array.isArray(c);return 0===Object.keys(i).length?(0,a.createElement)(a.Fragment,null,(0,N.__)("No options found","complianz-gdpr")):(0,a.createElement)("div",{className:"cmplz-checkbox-group"},Object.entries(i).map((([i,d],u)=>(0,a.createElement)("div",{key:i,className:"cmplz-checkbox-group__item"+(!m&&u>9?" cmplz-hidden":"")},(0,a.createElement)(y,{className:"cmplz-checkbox-group__checkbox",id:l+"_"+i,checked:g(i),"aria-label":t,disabled:E||Array.isArray(c)&&c.includes(i),required:r,onCheckedChange:e=>((e,t)=>{if(s)o(!n);else{const e=f.includes(""+t)||f.includes(parseInt(t))?f.filter((e=>e!==""+t&&e!==parseInt(t))):[...f,t];o(e)}})(0,i)},(0,a.createElement)(z,{className:"cmplz-checkbox-group__indicator"},(0,a.createElement)(w.default,{name:e?"indeterminate":"check",size:14,color:"dark-blue"}))),(0,a.createElement)("label",{className:"cmplz-checkbox-group__label",htmlFor:l+"_"+i},d)))),!m&&_&&(0,a.createElement)(O.default,{onClick:()=>b()},(0,N.__)("Show more","complianz-gdpr")),m&&_&&(0,a.createElement)(O.default,{onClick:()=>b()},(0,N.__)("Show less","complianz-gdpr")))}))},14056:(e,t,n)=>{n.r(t),n.d(t,{default:()=>i});var a=n(51280),l=n(88496),o=n(39992),r=n(15832),c=n(93396);const i=(0,l.memo)((({value:e=!1,onChange:t,required:n,defaultValue:l,disabled:i,options:s={},canBeEmpty:d=!0,label:m})=>{if(Array.isArray(s)){let e={};s.map((t=>{e[t.value]=t.label})),s=e}return d?(""===e||!1===e||0===e)&&(e="0",s={0:(0,c.__)("Select an option","complianz-gdpr"),...s}):e||(e=Object.keys(s)[0]),(0,a.createElement)("div",{className:"cmplz-input-group cmplz-select-group",key:m},(0,a.createElement)(o.Ss,{value:e,defaultValue:l,onValueChange:t,required:n,disabled:i&&!Array.isArray(i)},(0,a.createElement)(o.mf,{className:"cmplz-select-group__trigger"},(0,a.createElement)(o.s3,null),(0,a.createElement)(r.default,{name:"chevron-down"})),(0,a.createElement)(o.kP,{className:"cmplz-select-group__content",position:"popper"},(0,a.createElement)(o.O4,{className:"cmplz-select-group__scroll-button"},(0,a.createElement)(r.default,{name:"chevron-up"})),(0,a.createElement)(o.mm,{className:"cmplz-select-group__viewport"},(0,a.createElement)(o.WM,null,Object.entries(s).map((([e,t])=>(0,a.createElement)(o.iY,{disabled:Array.isArray(i)&&i.includes(e),className:"cmplz-select-group__item",key:e,value:e},(0,a.createElement)(o.CC,null,t)))))),(0,a.createElement)(o.y8,{className:"cmplz-select-group__scroll-button"},(0,a.createElement)(r.default,{name:"chevron-down"})))))}))},79056:(e,t,n)=>{n.r(t),n.d(t,{default:()=>r});var a=n(51280),l=n(15832),o=n(88496);const r=e=>{const[t,n]=(0,o.useState)(!1);return(0,a.createElement)("div",{className:"cmplz-panel__list__item",style:e.style?e.style:{}},(0,a.createElement)("details",{open:t},(0,a.createElement)("summary",{onClick:e=>(e=>{e.preventDefault(),n(!t)})(e)},e.icon&&(0,a.createElement)(l.default,{name:e.icon}),(0,a.createElement)("h5",{className:"cmplz-panel__list__item__title"},e.summary),(0,a.createElement)("div",{className:"cmplz-panel__list__item__comment"},e.comment),(0,a.createElement)("div",{className:"cmplz-panel__list__item__icons"},e.icons),(0,a.createElement)(l.default,{name:"chevron-down",size:18})),(0,a.createElement)("div",{className:"cmplz-panel__list__item__details"},t&&e.details)))}},76860:(e,t,n)=>{n.d(t,{s:()=>c});var a=n(51280),l=n(81034),o=n(40304),r=n(84904);const c=e=>{const{present:t,children:n}=e,c=function(e){const[t,n]=(0,a.useState)(),o=(0,a.useRef)({}),c=(0,a.useRef)(e),s=(0,a.useRef)("none"),d=e?"mounted":"unmounted",[m,u]=function(e,t){return(0,a.useReducer)(((e,n)=>{const a=t[e][n];return null!=a?a:e}),e)}(d,{mounted:{UNMOUNT:"unmounted",ANIMATION_OUT:"unmountSuspended"},unmountSuspended:{MOUNT:"mounted",ANIMATION_END:"unmounted"},unmounted:{MOUNT:"mounted"}});return(0,a.useEffect)((()=>{const e=i(o.current);s.current="mounted"===m?e:"none"}),[m]),(0,r.w)((()=>{const t=o.current,n=c.current;if(n!==e){const a=s.current,l=i(t);e?u("MOUNT"):"none"===l||"none"===(null==t?void 0:t.display)?u("UNMOUNT"):u(n&&a!==l?"ANIMATION_OUT":"UNMOUNT"),c.current=e}}),[e,u]),(0,r.w)((()=>{if(t){const e=e=>{const n=i(o.current).includes(e.animationName);e.target===t&&n&&(0,l.flushSync)((()=>u("ANIMATION_END")))},n=e=>{e.target===t&&(s.current=i(o.current))};return t.addEventListener("animationstart",n),t.addEventListener("animationcancel",e),t.addEventListener("animationend",e),()=>{t.removeEventListener("animationstart",n),t.removeEventListener("animationcancel",e),t.removeEventListener("animationend",e)}}u("ANIMATION_END")}),[t,u]),{isPresent:["mounted","unmountSuspended"].includes(m),ref:(0,a.useCallback)((e=>{e&&(o.current=getComputedStyle(e)),n(e)}),[])}}(t),s="function"==typeof n?n({present:c.isPresent}):a.Children.only(n),d=(0,o.q)(c.ref,s.ref);return"function"==typeof n||c.isPresent?(0,a.cloneElement)(s,{ref:d}):null};function i(e){return(null==e?void 0:e.animationName)||"none"}c.displayName="Presence"}}]);