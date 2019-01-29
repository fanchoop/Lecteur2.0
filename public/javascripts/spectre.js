/**
 * Create a waveform with the given array
 * @param {Player} player - Reference to the parent Player object
 * @param {array} dotsList array of INT position to make the waveform
 * @param {int} percentilePlayed - percentile of the current music, if exist. Used to find the position of the bar which match with the position of the music on the spectrum
 */
function createWaveForm(player, dotsList, percentilePlayed) {

    //Set a default parameter which work with IE11
    percentilePlayed = percentilePlayed || -1;

    var spectre = player.domElement.querySelector(".audioplayer .waveform");

    /** Reset the content of the waveform */

    spectre.innerHTML = "";

    var svgns = "http://www.w3.org/2000/svg";

    var primarySVG = document.createElementNS(svgns, "svg");
    var reflectSVG = document.createElementNS(svgns, "svg");
    var SVGRules = document.createElementNS(svgns, "svg");

    var primaryWaveWidth = spectre.clientWidth;
    var primaryWaveHeight = Math.round(spectre.clientHeight * 2 / 3);

    var reflectWaveWidth = primaryWaveWidth;
    var reflectWaveHeight = Math.round(spectre.clientHeight / 3);

    var className = "bar";

    //JSON data
    var data = dotsList;
    var maxSizeBar = Math.max.apply(null, dotsList);

    var nbBars = dotsList.length;
    var x_bar = 0;
    var y_bar = 0;

    var barWidth = 4;
    var barHeight = 0;

    /** Define the css rules */

    //Check if a defs blocks already exist and doesn't recreate this
    if (player.domElement.querySelector('defs.svg-cssRules') == null) {

        var defBlock = document.createElementNS(svgns, "defs");
        PlayerUtils.addClass(defBlock, "svg-cssRules");

        /** Top part */

        //Define one time the linearGradient object then clone it
        var gradientBarUp = document.createElementNS(svgns, "linearGradient");

        gradientBarUp.setAttribute("id", "waveformStyleBarUp");
        gradientBarUp.setAttribute("x1", "0");
        gradientBarUp.setAttribute("y1", "0");
        gradientBarUp.setAttribute("x2", "0");
        gradientBarUp.setAttribute("y2", "100%");
        gradientBarUp.innerHTML = "<stop offset='0%' stop-color='#F0F0F0' />\n" + "<stop offset='100%' stop-color='#646464' />\n";
        defBlock.appendChild(gradientBarUp);

        var gradientBarUpPlayed = gradientBarUp.cloneNode();
        gradientBarUpPlayed.setAttribute("id", "waveformStyleBarUpPlayed");
        gradientBarUpPlayed.innerHTML = "<stop offset='0%' stop-color='#F0F0F0' />\n" + "<stop offset='100%' stop-color='#f95800' />\n";
        defBlock.appendChild(gradientBarUpPlayed);

        var gradientBarUpHoverBack = gradientBarUp.cloneNode();
        gradientBarUpHoverBack.setAttribute("id", "waveformStyleBarUpHoverBack");
        gradientBarUpHoverBack.innerHTML = "<stop offset='0%' stop-color='#F0F0F0' />\n" + "<stop offset='100%' stop-color='#c33900' />\n";
        defBlock.appendChild(gradientBarUpHoverBack);

        var gradientBarUpHoverFront = gradientBarUp.cloneNode();
        gradientBarUpHoverFront.setAttribute("id", "waveformStyleBarUpHoverFront");
        gradientBarUpHoverFront.innerHTML = "<stop offset='0%' stop-color='#F0F0F0' />\n" + "<stop offset='100%' stop-color='#993600' />\n";
        defBlock.appendChild(gradientBarUpHoverFront);

        /** Bottom part */

        var gradientBarDown = gradientBarUp.cloneNode();
        gradientBarDown.setAttribute("id", "waveformStyleBarDown");
        gradientBarDown.innerHTML = "<stop offset='0%' stop-color='#676767' stop-opacity = 0.68 />\n" + "<stop offset='100%' stop-color='#F0F0F0' stop-opacity = 1/>\n";
        defBlock.appendChild(gradientBarDown);

        var gradientBarDownPlayed = gradientBarDown.cloneNode();
        gradientBarDownPlayed.setAttribute("id", "waveformStyleBarDownPlayed");
        gradientBarDownPlayed.innerHTML = "<stop offset='0%' stop-color='#FF5B00' stop-opacity = 0.68 />\n" + "<stop offset='100%' stop-color='#F0F0F0' stop-opacity = 1/>\n";
        defBlock.appendChild(gradientBarDownPlayed);

        var gradientBarDownHoverBack = gradientBarDown.cloneNode();
        gradientBarDownHoverBack.setAttribute("id", "waveformStyleBarDownHoverBack");
        gradientBarDownHoverBack.innerHTML = "<stop offset='0%' stop-color='#C33400' stop-opacity = 0.68 />\n" + "<stop offset='100%' stop-color='#F0F0F0' stop-opacity = 1/>\n";
        defBlock.appendChild(gradientBarDownHoverBack);

        var gradientBarDownHoverFront = gradientBarDown.cloneNode();
        gradientBarDownHoverFront.setAttribute("id", "waveformStyleBarDownHoverFront");
        gradientBarDownHoverFront.innerHTML = "<stop offset='0%' stop-color='#993300' stop-opacity = 0.68 />\n" + "<stop offset='100%' stop-color='#F0F0F0' stop-opacity = 1/>\n";
        defBlock.appendChild(gradientBarDownHoverFront);

        //Add the def block - MUST BE BEFORE the other svg to be used AND in a svg
        SVGRules.appendChild(defBlock);

        SVGRules.setAttribute("width", 0);
        SVGRules.setAttribute("height", 0);


        spectre.appendChild(SVGRules);

    }

    /** Number of bar */

    data = getResponsiveWaveForm(data, primaryWaveWidth, barWidth);

    //Position which represent the current position of the music
    var barPlayedPosition = Math.ceil(nbBars * percentilePlayed);

    /**
     * Create the waveform
     */

    primarySVG.setAttribute("xmlns", svgns);

    //Set the rigth size of the primary waveform
    primarySVG.setAttribute("width", primaryWaveWidth);
    primarySVG.setAttribute("height", primaryWaveHeight);

    PlayerUtils.addClass(primarySVG, "sprectrumContainer");

    reflectSVG.setAttribute("xmlns", svgns);


    //Set the rigth size of the reflect waveform
    reflectSVG.setAttribute("width", reflectWaveWidth);
    reflectSVG.setAttribute("height", reflectWaveHeight);

    PlayerUtils.addClass(reflectSVG, "sprectrumContainer");

    for (var i = 0; i < nbBars; i++) {
        /** Create and add every bar of the primary waveform*/
        var primaryRect = document.createElementNS(svgns, "rect");
        barHeight = getCorrectHeight("primary", data[i]);

        y_bar = primaryWaveHeight - barHeight;

        PlayerUtils.addClass(primaryRect, className + "-up");

        primaryRect.setAttributeNS(null, "data_position", i);

        primaryRect.setAttributeNS(null, "x", x_bar);
        primaryRect.setAttributeNS(null, "y", y_bar);
        primaryRect.setAttributeNS(null, "width", "" + barWidth);
        primaryRect.setAttributeNS(null, "height", "" + barHeight);
        primaryRect.setAttributeNS(null, "rx", "0");
        primarySVG.appendChild(primaryRect);


        /** Create and add every bar of the reflect waveform */

        var reflectRect = document.createElementNS(svgns, "rect");
        barHeight = getCorrectHeight("reflect", data[i]);

        PlayerUtils.addClass(reflectRect, className + "-down");


        reflectRect.setAttributeNS(null, "data_position", i);
        reflectRect.setAttributeNS(null, "x", x_bar);
        reflectRect.setAttributeNS(null, "y", 0);
        reflectRect.setAttributeNS(null, "width", "" + barWidth);
        reflectRect.setAttributeNS(null, "height", "" + barHeight);
        reflectRect.setAttributeNS(null, "rx", "0");

        reflectSVG.appendChild(reflectRect);

        /** Common part */

        //Add the width of a bar to the next position of the bar
        x_bar += barWidth;

        //check if this position have been played or not, and add the "played-flash" class
        if (i <= barPlayedPosition) {
            PlayerUtils.addClass(primaryRect, "played-flash");
            PlayerUtils.addClass(reflectRect, "played-flash");

        }

    }


    //Add to the div the primary waveform
    spectre.appendChild(primarySVG);
    //Add to the div the reflect waveform
    spectre.appendChild(reflectSVG);


    /**
     * Get the height of a bar after a proportionally resize of the waveform's div
     * @param type - primary or reflect, define which algorithm will be used
     * @param value - the height of the bar, wanted to be resize
     * @returns the transformed value or null if the type ins't both "primary" or "reflect"
     */
    function getCorrectHeight(type, value) {
        value = value === 0 ? 1 : value;
        value = (value * spectre.clientHeight) / maxSizeBar;
        if (type === "primary") {
            return value * 2 / 3;
        } else if (type === "reflect") {
            return value / 3;
        } else {
            return null;
        }
    }

    function getResponsiveWaveForm (oTab, waveformWidth, barSize) {
        // oTab; the tab stored in the database
        // waveformWidth; the width of the waveform
        // barSize; Width of a bar increasde by 1 to cover the stroke
        //the tab that contains the value displayed on the screen
        var finalTab = [];
        //number of value in the tab stored in the database
        var oNbBar = oTab.length;
        //the number of bar that are going to be displayed
        var nbBar = parseInt(waveformWidth / barSize);
        nbBars = nbBar;
        //the number of value required to math the number of one new value
        var nbValuePerBar = oNbBar / nbBar;
        //Do a round on the value at 4 number after the point
        nbValuePerBar = parseFloat(nbValuePerBar.toFixed(8));

        //Check if the round don't make the application go over the length of the original Tab and if does
        // reduce the value by 0.0001
        while (nbValuePerBar * nbBar > 400) {
            nbValuePerBar = nbValuePerBar - 0.00000001;
            nbValuePerBar = parseFloat(nbValuePerBar).toFixed(8);
        }

        var intPartVPB = parseInt(nbValuePerBar);
        var restVPB = nbValuePerBar - intPartVPB;
        restVPB = parseFloat(restVPB).toFixed(8);
        var restBisVPB = 0;
        var oTabCursor = 0;
        var iValue = 0;

        //Lighter treatment when the case doesn't need to treat with rests to remain precise
        if (nbValuePerBar >= 1) {
            if (restVPB == 0) {
                for (var i = 0; i < nbBar; i++) {
                    iValue = 0;
                    for (var y = 0; y < nbValuePerBar; y++) {
                        iValue += oTab[oTabCursor];
                        oTabCursor++;
                    }
                    finalTab[i] = iValue / nbValuePerBar;
                }
            //Heavier process processing using the rests
            } else {
                for (var i = 0; i < nbBar; i++) {
                    iValue = 0;
                    if (restBisVPB >= 0) {
                        iValue += oTab[oTabCursor] * parseFloat(restBisVPB).toFixed(8);
                        intPartVPB = parseInt(nbValuePerBar - parseFloat(restBisVPB).toFixed(8));
                        restVPB = (nbValuePerBar - parseFloat(restBisVPB).toFixed(8)) - intPartVPB;
                        restVPB = parseFloat(restVPB).toFixed(8);
                        oTabCursor++;
                    }
                    for (var y = 0; y < intPartVPB; y++) {
                        iValue += oTab[oTabCursor];
                        //Block the incrementation of the cursor when it's the last value (Usefull only if it ends on a round number)
                        if (oTabCursor < 399) {
                            oTabCursor++;
                        }
                    }
                    iValue += oTab[oTabCursor] * parseFloat(restVPB).toFixed(8);
                    restBisVPB = 1 - (parseFloat(restVPB).toFixed(8));

                    iValue = iValue / nbValuePerBar;
                    finalTab[i] = parseFloat(iValue.toFixed(8));
                }
            }
            //When the number of bar required to fill the page if superior to the number of data stored in the database
        } else {
            finalTab = oTab; //The curve is displayed is made with the same data as the one stored in base
        }
        console.log("FinalTab : ");
        console.log(finalTab);
        console.log("Nombre de valeur par barre : ");
        console.log(nbValuePerBar);
        console.log("cursor : " + oTabCursor);
        return finalTab;
    }
}
