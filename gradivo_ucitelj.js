let toDoList = [];

function addItem() {
    let item = document.getElementById("new-item").value;
    toDoList.push(item);
    document.getElementById("new-item").value = "";
    updateList();
}
function removeItem(index)
{
    toDoList.splice(index, 1);
    updateList();
}

function updateList() {
    let listElement = document.getElementById("gradivo");

    listElement.innerHTML = "";

    for (let i = 0; i < toDoList.length; i++) {
        let listItemElement = document.createElement("li");

        listItemElement.textContent = toDoList[i];

        let removeButton = document.createElement("button");
        removeButton.textContent = "Remove";
        removeButton.addEventListener("click", function () {
            removeItem(i);
        });

        listItemElement.appendChild(removeButton);

        listElement.appendChild(listItemElement);
    }
}

let addButton = document.getElementById("add-button");
addButton.addEventListener("click", addItem);