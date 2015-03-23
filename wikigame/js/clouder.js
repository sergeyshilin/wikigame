var cloud = {

params: {
        colorMin: "#0000FF",
        colorMax: "#FF0000",
        colorBgr: "#FFFFFF",
        interval: 50,
        fontSize: 12,
        fontShift: 4,
        opaque: 0.3
},

init: function() {
    this.makeCloud();
}, // init

makeCloud: function() {
    var w = document.body.clientWidth, h = document.body.clientHeight;
    var clouder = document.getElementById('clouder');
    
    clouder.style.border = "1px solid black";
    clouder.style.width = w * 2 / 3;
    clouder.style.height = h * 2 / 3;
    clouder.style.position = "absolute";
    clouder.style.left = w / 6;
    clouder.style.top = h / 6;
    clouder.style.border = "1px solid black";

    var attrs = {
        container: clouder,
        tags: this.createTags()
    };
    
    for (var i in this.params) {
        attrs[i] = this.params[i];
    } // for
    
    if (this.clouder) {
        this.clouder.kill();
    } // if
    
    this.clouder = new Clouder(attrs);

}, // makeCloud

createTags: function() {
    return [
            {text: "George<br/>Washington", id: "1789-1797", weight: 0.5},
            {text: "John<br/>Adams", id: "1797-1801", weight: 0.5},
            {text: "Thomas<br/>Jefferson", id: "1801-1809", weight: 0.5},
            {text: "James<br/>Madison", id: "1809-1817", weight: 0.5},
            {text: "James<br/>Monroe", id: "1817-1825", weight: 0.5},
            {text: "John<br/>Quincy<br/>Adams", id: "1825-1829", weight: 0.5},
            {text: "Andrew<br/>Jackson", id: "1829-1837", weight: 0},
            {text: "Martin<br/>Van Buren", id: "1837-1841", weight: 0},
            {text: "William<br/>Harrison", id: "1841-1841", weight: 0.5},
            {text: "John<br/>Tyler", id: "1841-1845", weight: 0.5},
            {text: "James<br/>Polk", id: "1845-1849", weight: 0},
            {text: "Zachary<br/>Taylor", id: "1849-1850", weight: 0.5},
            {text: "Millard<br/>Fillmore", id: "1850-1853", weight: 0.5},
            {text: "Franklin<br/>Pierce", id: "1853-1857", weight: 0},
            {text: "James<br/>Buchanan", id: "1857-1861", weight: 0},
            {text: "Abraham<br/>Lincoln", id: "1861-1865", weight: 1},
            {text: "Andrew<br/>Johnson", id: "1865-1869", weight: 0},
            {text: "Ulisses<br/>Grant", id: "1869-1877", weight: 1},
            {text: "Rutherford<br/>Hayes", id: "1877-1881", weight: 1},
            {text: "James<br/>Garfield", id: "1881-1881", weight: 1},
            {text: "Chester<br/>Arthur", id: "1881-1885", weight: 1},
            {text: "Grover<br/>Cleveland", id: "1885-1889, 1893-1897", weight: 0},
            {text: "Benjamin<br/>Harrison", id: "1889-1893", weight: 1},
            {text: "William<br/>McKinley", id: "1897-1901", weight: 1},
            {text: "Theodore<br/>Roosevelt", id: "1901-1909", weight: 1},
            {text: "William<br/>Taft", id: "1909-1913", weight: 1},
            {text: "Woodrow<br/>Wilson", id: "1913-1921", weight: 0},
            {text: "Warren<br/>Harding", id: "1921-1923", weight: 1},
            {text: "Calvin<br/>Coolidge", id: "1923-1929", weight: 1},
            {text: "Herbert<br/>Hoover", id: "1929-1933", weight: 1},
            {text: "Franklin<br/>Roosevelt", id: "1933-1945", weight: 0},
            {text: "Harry<br/>Truman", id: "1945-1953", weight: 0},
            {text: "Dwight<br/>Eisenhower", id: "1953-1961", weight: 1},
            {text: "John<br/>Kennedy", id: "1961-1963", weight: 0},
            {text: "Lyndon<br/>Johnson", id: "1963-1969", weight: 0},
            {text: "Richard<br/>Nixon", id: "1969-1974", weight: 1},
            {text: "Gerald<br/>Ford", id: "1974-1977", weight: 1},
            {text: "Jimmy<br/>Carter", id: "1977-1981", weight: 0},
            {text: "Ronald<br/>Reagan", id: "1981-1989", weight: 1},
            {text: "George<br/>Bush Sr.", id: "1989-1993", weight: 1},
            {text: "Bill<br/>Clinton", id: "1993-2001", weight: 0},
            {text: "George<br/>Bush Jr.", id: "2001-2009", weight: 1},
            {text: "Barack<br/>Obama", id: "2009-...", weight: 0}
    ];
}, // createTags

};