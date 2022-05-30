// document.querySelector("#sortprice").onclick = sortByPrice;
var mixer = mixitup('.cards', {
    selectors: {
        target: '.card'
    },
    animation: {
        duration: 300
    }
});



function sortByPrice() {
    let parent = document.querySelector("#cards");
    for (let i = 0; i < parent.children.length - 1; i++) {
        for (let j = 1; j < parent.children.length; j++) {
            if (
                +parent.children[i].getAttribute("data-sort") >
                +parent.children[j].getAttribute("data-sort")
            ) {
                let elem = parent.children[i].cloneNode(true);
                parent.children[j].after(elem);
                parent.children[i].replaceWith(parent.children[j]);
            }
        }
    }
}

