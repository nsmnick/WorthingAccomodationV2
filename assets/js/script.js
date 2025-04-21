import initVue from "./vue/init";
import initMenu from "./main-menu";
import initSliders from "./sliders";
import animationsV2 from "./animationsv2";
import initCookieAccept from "./cookie-accept";
import initAccordions from "./accordion";

function ready(fn) {
  if (document.readyState !== "loading") {
    fn();
  } else {
    document.addEventListener("DOMContentLoaded", fn);
  }
}

// eslint-disable-next-line no-unused-vars
function CopyToClipboard(toCopy) {
  const el = document.createElement(`textarea`);
  el.value = toCopy;
  el.setAttribute(`readonly`, ``);
  el.style.position = `absolute`;
  el.style.left = `-9999px`;
  document.body.appendChild(el);
  el.select();
  document.execCommand(`copy`);
  document.body.removeChild(el);
}

ready(() => {
  initVue();
  initMenu();
  initSliders();
  initCookieAccept();
  animationsV2();
  initAccordions();
});
