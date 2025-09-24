/**
 * Basic structure: TC_Class is the public class that is returned upon being called
 * 
 * So, if you do
 *      var tc = $(".timer").TimeCircles();
 *      
 * tc will contain an instance of the public TimeCircles class. It is important to
 * note that TimeCircles is not chained in the conventional way, check the
 * documentation for more info on how TimeCircles can be chained.
 * 
 * After being called/created, the public TimerCircles class will then- for each element
 * within it's collection, either fetch or create an instance of the private class.
 * Each function called upon the public class will be forwarded to each instance
 * of the private classes within the relevant element collection
 **/
(function($) {

    var useWindow = window;
    
    // From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
    if (!Object.keys) {
        Object.keys = (function() {
            'use strict';
            var hasOwnProperty = Object.prototype.hasOwnProperty,
                    hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
                    dontEnums = [
                        'toString',
                        'toLocaleString',
                        'valueOf',
                        'hasOwnProperty',
                        'isPrototypeOf',
                        'propertyIsEnumerable',
                        'constructor'
                    ],
                    dontEnumsLength = dontEnums.length;

            return function(obj) {
                if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
                    throw new TypeError('Object.keys called on non-object');
                }

                var result = [], prop, i;

                for (prop in obj) {
                    if (hasOwnProperty.call(obj, prop)) {
                        result.push(prop);
                    }
                }

                if (hasDontEnumBug) {
                    for (i = 0; i < dontEnumsLength; i++) {
                        if (hasOwnProperty.call(obj, dontEnums[i])) {
                            result.push(dontEnums[i]);
                        }
                    }
                }
                return result;
            };
        }());
    }
    
    // Used to disable some features on IE8
    var limited_mode = false;
    var tick_duration = 200; // in ms
    
    var debug = (location.hash === "#debug");
    function debug_log(msg) {
        if (debug) {
            console.log(msg);
        }
    }

    var allUnits = ["Days", "Hours", "Minutes", "Seconds"];
    var nextUnits = {
        Seconds: "Minutes",
        Minutes: "Hours",
        Hours: "Days",
        Days: "Years"
    };
    var secondsIn = {
        Seconds: 1,
        Minutes: 60,
        Hours: 3600,
        Days: 86400,
        Months: 2678400,
        Years: 31536000
    };

    /**
     * Converts hex color code into object containing integer values for the r,g,b use
     * This function (hexToRgb) originates from:
     * http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb
     * @param {string} hex color code
     */
    function hexToRgb(hex) {
        // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
            return r + r + g + g + b + b;
        });

        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }
    
    function isCanvasSupported() {
        var elem = document.createElement('canvas');
        return !!(elem.getContext && elem.getContext('2d'));
    }

    /**
     * Function s4() and guid() originate from:
     * http://stackoverflow.com/questio