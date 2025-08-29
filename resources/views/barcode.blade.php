<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dynamic Sortable Categories</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
  <style>
    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
    }

    .sortable-list,
    .nested-list {
      list-style: none;
      padding: 0;
      margin: 0;
      min-height: 20px;
    }

    .nested-list {
      padding-left: 30px;
      margin: 10px 0 0 0;
    }

    .list-item {
      padding: 15px;
      margin: 5px 0;
      background-color: #f3f3f3;
      border: 1px solid #ddd;
      border-radius: 4px;
      transition: background-color 0.2s;
    }

    .list-item:hover {
      background-color: #e9e9e9;
    }

    .nested-list .list-item {
      background-color: #ffffff;
      border: 1px solid #e0e0e0;
    }

    .nested-list .list-item:hover {
      background-color: #f5f5f5;
    }

    .sortable-ghost {
      opacity: 0.4;
    }

    .sortable-chosen {
      background-color: #e0e0e0;
    }

    .item-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .handle {
      cursor: move;
      padding: 0 10px;
      color: #666;
    }

    .drop-zone {
      background-color: rgba(0, 255, 0, 0.1);
      min-height: 30px;
      border: 2px dashed #ccc;
    }

    h2 {
      color: #333;
      margin-bottom: 20px;
    }

    #printArray {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    #printArray:hover {
      background-color: #45a049;
    }

    #arrayOutput {
      margin-top: 20px;
      padding: 20px;
      background-color: #f5f5f5;
      border-radius: 4px;
      overflow-x: auto;
      font-family: monospace;
      white-space: pre-wrap;
      word-wrap: break-word;
    }

    .empty-message {
      color: #666;
      font-style: italic;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Dynamic Categories</h2>
    <div id="category-container"></div>
    <div style="margin-top: 20px;">
      <button id="printArray">Print Current Structure</button>
    </div>
    <pre id="arrayOutput"></pre>
  </div>

  <script>
    const categories = [
      {
        id: 1,
        name: "Category 1",
        children: [{ id: 2, name: "Child Category 1" }]
      },
      {
        id: 3,
        name: "Category 2",
        children: [
          { id: 4, name: "Child Category 2" },
          { id: 5, name: "Child Category 3" }
        ]
      },
      {
        id: 6,
        name: "Category 3",
        children: [{ id: 7, name: "Child Category 4" }]
      }
    ];

    function createCategoryStructure(categories) {
      const mainList = document.createElement("ul");
      mainList.className = "sortable-list";

      categories.forEach(category => {
        const li = document.createElement("li");
        li.className = "list-item";
        li.setAttribute("data-id", category.id);

        const itemContent = document.createElement("div");
        itemContent.className = "item-content";
        itemContent.innerHTML = `
          <span>${category.name}</span>
          <span class="handle">↕</span>
        `;

        li.appendChild(itemContent);

        const nestedList = document.createElement("ul");
        nestedList.className = "nested-list";

        if (category.children && category.children.length > 0) {
          category.children.forEach(child => {
            const childLi = document.createElement("li");
            childLi.className = "list-item";
            childLi.setAttribute("data-id", child.id);

            const childContent = document.createElement("div");
            childContent.className = "item-content";
            childContent.innerHTML = `
              <span>${child.name}</span>
              <span class="handle">↕</span>
            `;

            childLi.appendChild(childContent);
            nestedList.appendChild(childLi);
          });
        }

        li.appendChild(nestedList);
        mainList.appendChild(li);
      });

      return mainList;
    }

    function getUpdatedStructure(element) {
      const items = element.children;
      const structure = [];

      Array.from(items).forEach(item => {
        const id = parseInt(item.getAttribute("data-id"));
        const name = item.querySelector(".item-content span").textContent;
        const nestedList = item.querySelector(".nested-list");

        const categoryItem = {
          id: id,
          name: name,
          children: []
        };

        if (nestedList && nestedList.children.length > 0) {
          const children = Array.from(nestedList.children).map(child => ({
            id: parseInt(child.getAttribute("data-id")),
            name: child.querySelector(".item-content span").textContent
          }));
          categoryItem.children = children;
        }

        structure.push(categoryItem);
      });

      return structure;
    }

    function printArray() {
      const currentStructure = getUpdatedStructure(document.querySelector(".sortable-list"));
      const outputElement = document.getElementById("arrayOutput");
      const prettyJson = JSON.stringify(currentStructure, null, 2);
      outputElement.innerHTML = prettyJson;

      // Log to console only when this function is called
      console.log("Current Structure:", currentStructure);
    }

    function initializeSortable(element) {
      new Sortable(element, {
        animation: 150,
        handle: ".handle",
        ghostClass: "sortable-ghost",
        chosenClass: "sortable-chosen",
        group: "shared",
        onEnd: function(evt) {
          if (evt.to.classList.contains("sortable-list")) {
            const movedItem = evt.item;
            let nestedList = movedItem.querySelector(".nested-list");

            if (!nestedList) {
              nestedList = document.createElement("ul");
              nestedList.className = "nested-list";
              movedItem.appendChild(nestedList);
              initializeSortable(nestedList);
            }
          }

          // Update output but do not log to console
          printArray();
        }
      });
    }

    // Initial render
    window.onload = function () {
      const container = document.getElementById("category-container");
      const categoryStructure = createCategoryStructure(categories);
      container.appendChild(categoryStructure);

      // Initialize main list
      initializeSortable(container.querySelector(".sortable-list"));

      // Initialize all nested lists
      container.querySelectorAll(".nested-list").forEach(list => {
        initializeSortable(list);
      });

      // Add event listener to the print button
      document.getElementById("printArray").addEventListener("click", printArray);

      // Initial print
      printArray();
    };
  </script>
</body>

</html>
