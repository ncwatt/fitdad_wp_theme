window.onscroll = function () { topMenuClasses() };

window.onload = function () { 
    if (document.getElementById("hp-logo") == null) { 
        topMenuLight(); 
    }

    wpfWpColumnsToBsRow();
    wpfWpColumnToBsColumn();
};

var topNavigation = document.getElementById("navbar-top");
var brandLink = document.getElementById("navbar-top-brand-link");

function topMenuLight() {
    // Show the brand link
    brandLink.classList.add("brand-link-show");

    // Make the navigation bar light
    topNavigation.classList.remove("bg-dark");
    topNavigation.classList.remove("navbar-dark");
    topNavigation.classList.add("bg-light");
    topNavigation.classList.add("navbar-light");
}

function topMenuDark() {
    // Hide the brand link
    brandLink.classList.remove("brand-link-show");

    // Make the navigation bar dark
    topNavigation.classList.add("bg-dark");
    topNavigation.classList.add("navbar-dark");
    topNavigation.classList.remove("bg-light");
    topNavigation.classList.remove("navbar-light");
}

function topMenuClasses() {
     
    //var ab = document.getElementById("wpadminbar");
    //console.log("Offset: " + ab.offsetTop + "; Height: " + ab.offsetHeight);
    //console.log("Top:" + ab.scrollTop + "; ScrollY: " + window.scrollY);

    if (document.getElementById("hp-logo") != null) {
        var logo = document.getElementById("hp-logo");
        
        //if (window.pageYOffset > (logo.offsetTop + logo.offsetHeight) - topNavigation.offsetHeight) {
        if (window.scrollY > (logo.offsetTop + logo.offsetHeight) - topNavigation.offsetHeight) {
            topMenuLight();
        }
        else {
            topMenuDark();
        }
    }
}

function wpfWpColumnsToBsRow() {
    var elements = document.getElementsByClassName("bs-columns");

    for (var counter = 0; counter < elements.length; counter++) {
        elements[counter].classList.remove("wp-block-columns");
        elements[counter].classList.add("row");

        // Remove classes that start with "wp-container"
        const classes = elements[counter].className.split(" ").filter(c => !c.startsWith("wp-container"));
        elements[counter].className = classes.join(" ").trim();
    }
}

function wpfWpColumnToBsColumn() {
    var elements = document.getElementsByClassName("bs-column");

    for (var counter = 0; counter < elements.length; counter++) {
        elements[counter].classList.remove("wp-block-column");
        elements[counter].style.removeProperty("flex-basis");

        // Remove classes that start with "wp-container"
        const classes = elements[counter].className.split(" ").filter(c => !c.startsWith("wp-container"));
        elements[counter].className = classes.join(" ").trim();
    }
}

//const prefix = "wp-container";
//const classes = el.className.split(" ").filter(c => !c.startsWith(prefix));
//el.className = classes.join(" ").trim();