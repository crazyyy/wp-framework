// Avoid `console` errors in browsers that lack a console.
(function() {
  const noop = function() {};
  const methods = [
    'assert',
    'clear',
    'count',
    'debug',
    'dir',
    'dirxml',
    'error',
    'exception',
    'group',
    'groupCollapsed',
    'groupEnd',
    'info',
    'log',
    'markTimeline',
    'profile',
    'profileEnd',
    'table',
    'time',
    'timeEnd',
    'timeline',
    'timelineEnd',
    'timeStamp',
    'trace',
    'warn'
  ];
  const console = window.console || {};

  for (const method of methods) {
    // Only stub undefined methods.
    if (!console[method]) {
      console[method] = noop;
    }
  }
})();

if (typeof jQuery === 'undefined') {
  console.warn("jQuery hasn't loaded");
} else {
  console.log(`jQuery ${jQuery.fn.jquery} has loaded`);
}

// Place any jQuery/helper plugins in here.

document.addEventListener('DOMContentLoaded', function() {
  console.log('Document is ready');
  // Place your code that needs to run after the document has finished loading

});

jQuery(document).ready(function() {
  const $ = jQuery

});


console.log('All Scripts Loaded');
