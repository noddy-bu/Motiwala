AOS.init({
    duration: 1200,
}); // popup

function toggle() {
    var blur = document.getElementById("blur");
    blur.classList.toggle("active");
    var popup = document.getElementById("popup");
    popup.classList.toggle("active");
}

$(document).ready(function () {
    function openModal() {
        $("#loginmodal").modal("show");
    }

    // Check if the URL contains '#sign' and open the modal if it does
    if (window.location.hash === "#sign") {
        openModal();
    }
});

// calculator
/*
("use strict");
var amountSlider = document.getElementById("myAmount");
var amountOutput = document.getElementById("inputAmount");
var roiSlider = document.getElementById("myRoi");
var roiOutput = document.getElementById("inputRoi");
var yearSlider = document.getElementById("myYears");
var yearOutput = document.getElementById("inputYears");

amountOutput.innerHTML = amountSlider.value;
roiOutput.innerHTML = roiSlider.value;
yearOutput.innerHTML = yearSlider.value;

amountSlider.oninput = function () {
    amountOutput.innerHTML = this.value;
};
roiSlider.oninput = function () {
    roiOutput.innerHTML = this.value;
};
yearSlider.oninput = function () {
    yearOutput.innerHTML = this.value;
};

function showValAmount(newVal) {
    amountSlider.value = newVal;
    calculateIt();
}
function showValRoi(newVal) {
    roiSlider.value = newVal;
    calculateIt();
}
function showValYears(newVal) {
    yearSlider.value = newVal;
    calculateIt();
}

amountSlider.addEventListener("input", updateValueAmount);
roiSlider.addEventListener("input", updateValueRoi);
yearSlider.addEventListener("input", updateValueYears);

function updateValueAmount(e) {
    amountOutput.value = e.srcElement.value;
    calculateIt();
}
function updateValueRoi(e) {
    roiOutput.value = e.srcElement.value;
    calculateIt();
}
function updateValueYears(e) {
    yearOutput.value = e.srcElement.value;
    calculateIt();
}

var calculatorMode = "sip";
var heading = document.getElementById("heading");
var amountLabel = document.getElementById("amountLabel");

function changeMode(mode) {
    calculatorMode = mode;
    heading.innerHTML =
        mode === "sip" ? "SIP Calculator" : "Lumpsum Calculator";
    amountLabel.innerHTML =
        mode === "sip" ? "Monthly Investment :" : "Total Investment :";
    calculateIt();
}

function calculateIt() {
    var wealthOutput = document.getElementById("yourWealth");
    var A = document.sipForm.realAmount.value;
    var R = document.sipForm.realRoi.value;
    var N = document.sipForm.realYears.value;
    var sip = Math.round(
        ((Math.pow(1 + (Math.pow(1 + R / 100, 1 / 12) - 1), N * 12) - 1) /
            (Math.pow(1 + R / 100, 1 / 12) - 1)) *
            A
    );
    var lumpsum = Math.round(Math.pow(1 + R / 100, N) * A);
    var finalOutput = calculatorMode === "sip" ? sip : lumpsum;
    wealthOutput.innerHTML = "Rs. " + finalOutput; // Print BMI
}
calculateIt();
*/

/*step script*/

const stepButtons = document.querySelectorAll(".step-button");
const progress = document.querySelector("#progress");

Array.from(stepButtons).forEach((button, index) => {
    button.addEventListener("click", () => {
        progress.setAttribute(
            "value",
            (index * 100) / (stepButtons.length - 1)
        ); //there are 3 buttons. 2 spaces.

        stepButtons.forEach((item, secindex) => {
            if (index > secindex) {
                item.classList.add("done");
            }
            if (index < secindex) {
                item.classList.remove("done");
            }
        });
    });
});

/* canvass graph open */

console.log("vvvvvvvvvvvvvvvvvvvv START vvvvvvvvvvvvvvvvvvvv");

var HoverPie = {};
HoverPie.config = {
    canvasPadding: 25,
    hoverScaleX: 1.1,
    hoverScaleY: 1.1,
    labelColor: "#000",
    labelHoverColor: "rgba(255,255,255,1)",
    labelRadiusFactor: 0.66,
    labelFontFamily: "Quicksand",
    labelFontWeight: "bold",
    labelAlign: "center",
    labelFontSize: 18,
    sectorFillColor: "#000",
    sectorStrokeColor: "#000",
    sectorStrokeWidth: 2,
};
HoverPie.make = function ($canvas, data, config) {
    config = $.extend({}, HoverPie.config, config);

    var percent2radians = function (percent) {
        return percent * Math.PI * 2;
    };

    var ctx = $canvas[0].getContext("2d");
    var oX = ctx.canvas.width / 2;
    var oY = ctx.canvas.height / 2;
    var r = Math.min(oX, oY) - config.canvasPadding;
    var stage = new createjs.Stage("myCanvas");
    stage.enableMouseOver(20);

    var cumulativeAngle = 1.5 * Math.PI;

    for (var i = 0; i < data.length; i++) {
        var sector = new createjs.Shape();
        var container = new createjs.Container();
        container.name = container.id;

        // Draw the arc
        var sectorFillColor = data[i].fillColor || config.sectorFillColor;
        var sectorStrokeColor = data[i].strokeColor || config.sectorStrokeColor;
        sector.graphics
            .moveTo(oX, oY)
            .beginFill(sectorFillColor)
            .setStrokeStyle(config.sectorStrokeWidth)
            .beginStroke(sectorStrokeColor);

        var sectorAngle = percent2radians(data[i].percentage);
        sector.graphics.arc(
            oX,
            oY,
            r,
            cumulativeAngle,
            cumulativeAngle + sectorAngle
        );

        sector.graphics.closePath();

        container.addChild(sector);

        // Draw the label
        if (data[i].label) {
            // One for unhovered sectors
            var font =
                config.labelFontWeight +
                " " +
                config.labelFontSize +
                "px " +
                config.labelFontFamily;
            var unhoverLabel = new createjs.Text(
                data[i].label,
                font,
                config.labelColor
            );
            unhoverLabel.textAlign = "center";
            unhoverLabel.textBaseline = "bottom";

            // The label is to be placed such that the center of its baseline
            // is tangent to a circle of radius r*config.labelRadiusFactor
            // and a line drawn along the center of the sector
            var unhoverLabelRadius = r * config.labelRadiusFactor;
            var unhoverLabelAngle = cumulativeAngle + sectorAngle / 2.0;
            unhoverLabel.x =
                oX + unhoverLabelRadius * Math.cos(unhoverLabelAngle);
            unhoverLabel.y =
                oY + unhoverLabelRadius * Math.sin(unhoverLabelAngle);
            unhoverLabel.name = "label";

            // and one for hovered sectors

            container.addChild(unhoverLabel);
        }

        // Draw the description

        // reposition scale origin and draw origin
        container.regX = oX;
        container.regY = oY;
        container.x = oX;
        container.y = oY;

        cumulativeAngle += sectorAngle;
        stage.addChild(container);
        stage.update();
    } // percentages loop

    // This array tracks the currently-hovered pie sectors.
    // if it is empty, there are no sectors hovered.
    var hovers = [];

    var hover = function (ids) {
        //console.log(ids,stage.children);

        // This function is to be called with a list of stage IDs
        // it will revert any currently-hovered elements to their
        // original style, and apply hover style to the new set.

        // any ids in hovers that aren't in ids need to be unhovered
        var toUnhover = [];
        for (var i = 0; i < hovers.length; i++) {
            if (ids.indexOf(hovers[i]) == -1) {
                // didn't find hover[i] in ids, so add to toUnhover
                toUnhover.push(hovers[i]);
            }
        }
        for (var i = 0; i < toUnhover.length; i++) {
            var child = stage.getChildByName(toUnhover[i]);
            child.scaleX = 1;
            child.scaleY = 1;
        }

        // and ids in ids that aren't in hovers need to be hovered
        var toHover = [];
        for (var i = 0; i < ids.length; i++) {
            if (hovers.indexOf(ids[i]) == -1) {
                // didn't find ids[i] in hovers, so add to toHover
                toHover.push(ids[i]);
            }
        }
        for (var i = 0; i < toHover.length; i++) {
            var child = stage.getChildByName(toHover[i]);
            child.scaleX = config.hoverScaleX;
            child.scaleY = config.hoverScaleY;
        }

        hovers = ids;
        stage.update();
    };

    // This binding fires hover() when the mouse hovers over a
    // new set of pie sectors.
    // We can't use an addEventListener on each sector because
    // the hit mask on those shapes is the size of the entire
    // pie, not the individual sector.
    // I have not yet tried using canvas clip(). Maybe that's
    // a better solution? Unsure.
    $canvas.mousemove(function (e) {
        var objs = stage.getObjectsUnderPoint(e.clientX, e.clientY);
        var ids = $.map(objs, function (e) {
            return e.parent.id;
        });

        // call hover() if ids does not match current hovers
        if (ids.length != hovers.length) {
            hover(ids);
            return;
        }
        for (var i = 0; i < hovers.length; i++) {
            if (ids[i] != hovers[i]) {
                hover(ids);
                return;
            }
        }
    });
};

var data = [
    {
        percentage: 0.3,
        fillColor: "#DEB599",
        label: "Discount ₹1,900",
        textColor: "#000",
    },
    {
        percentage: 0.7,
        fillColor: "#FFDEC7",
        label: "Pay ₹20,900",
        textColor: "#000",
    },
];
HoverPie.make($("#myCanvas"), data, {});
