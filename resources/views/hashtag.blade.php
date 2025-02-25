<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Quill Mention</title>
    <meta name="description" content="Quill Mention Demo" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
    <link href="/iPD/public/css/quill.mention.css" rel="stylesheet" />
    <style>
      body {
        font-size: 16px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
          Helvetica, Arial, sans-serif,"Apple Color Emoji", "Segoe UI Emoji",
          "Segoe UI Symbol";
        max-width: 800px;
        margin: 0 auto;
      }

      .ql-editor {
        border: 1px solid #a3a3a3;
        border-radius: 6px;
      }

      .ql-editor-disabled {
        border-radius: 6px;
        background-color: rgba(124, 0, 0, 0.2);
        transition-duration: 0.5s;
      }

      .ql-editor:focus {
        border: 1px solid #025fae;
      }
    </style>
  </head>

  <body>
    <h1>Quill Mention</h1>
    <p>
      Quill Mention is a module to provide @mentions or #hashtag functionality
      for the Quill rich text editor.
    </p>

    <h2>Simple Demo</h2>
    <!-- Create the editor container -->
    <div id="editor"></div>

    <br />
    <h2>Advanced Demo</h2>
    <p>Asynchronous retrieval, disabled items (i.e. group headers), loading message, programmatic methods</p>
    <div id="editor2"></div>
    <div style="margin-top:5px">
      <button onclick="showMenu()">Show @ Menu</button>
      <button onclick="addMention()">Add Mention Programmatically</button>
    </div>

    <h2>License</h2>
    <p>This project is licensed under the MIT License</p>
    <p><a href="https://github.com/afry/quill-mention">View on GitHub</a></p>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="/iPD/public/js/library/quill.mention.js"></script>
    <!-- Initialize Quill editor -->
    <script>
      const atValues = [
        { id: "515fd775-cb54-41f3-b921-56163871e2cf", value: "Mickey Dooley" },
        {
          id: "3f0b7933-57b8-4d9d-b238-f8af62b2e945",
          value: "Desmond Waterstone"
        },
        { id: "711f68ab-ca20-4011-ab0f-d98c8fac4c05", value: "Jeralee Fryd" },
        { id: "775e05fc-72bc-48a1-9508-5c61674734f1", value: "Eddie Hucquart" },
        { id: "e8701885-105e-4a21-b200-98e559776655", value: "Nathalia Whear" }
      ];

      const hashValues = [
        { id: "0075256a-19c2-4a2d-b549-627000bcc3bc", value: "Accounting" },
        {
          id: "91e8901b-e3bf-4158-8ddf-7f5d9e8cbb7f",
          value: "Product Management"
        },
        { id: "c3373e89-7ab8-4a45-8b69-0b0cc49d89a9", value: "Marketing" },
        { id: "fa22f1d2-16c8-4bea-b869-8acad16e187a", value: "Engineering" },
        { id: "fe681168-f315-42f0-b78b-b1ea787fa1fd", value: "Accounting" }
      ];

      const advancedValues = [
        { id: "1", value: "Manuel Neuer", team: "Bayern Munich" },
        { id: "2", value: "Robert Lewandowski", team: "Bayern Munich" },
        { id: "3", value: "Thomas Muller", team: "Bayern Munich" },
        { id: "4", value: "Roman Burki", team: "Borussia Dortmund" },
        { id: "5", value: "Jadon Sancho", team: "Borussia Dortmund" },
        { id: "6", value: "Marco Reus", team: "Borussia Dortmund" },
        { id: "7", value: "Alexander Nubel", team: "Schalke 04" },
        { id: "8", value: "Bastian Oczipka", team: "Schalke 04" },
        { id: "9", value: "Weston McKennie", team: "Schalke 04" }
      ];

      var quill = new Quill("#editor", {
        placeholder: "Start by typing @ for mentions or # for hashtags...",
        modules: {
          mention: {
            allowedChars: /^[A-Za-z\sÅÄÖåäö]*$/,
            mentionDenotationChars: ["@", "#"],
            source: function(searchTerm, renderList, mentionChar) {
              let values;

              if (mentionChar === "@") {
                values = atValues;
              } else {
                values = hashValues;
              }

              if (searchTerm.length === 0) {
                renderList(values, searchTerm);
              } else {
                const matches = [];
                for (i = 0; i < values.length; i++)
                  if (
                    ~values[i].value
                    .toLowerCase()
                    .indexOf(searchTerm.toLowerCase())
                  )
                    matches.push(values[i]);
                renderList(matches, searchTerm);
              }
            }
          }
        }
      });

      var quill2 = new Quill("#editor2", {
        placeholder: "Start by typing @ for mentions",
        modules: {
          mention: {
            allowedChars: /^[A-Za-z\sÅÄÖåäö]*$/,
            mentionDenotationChars: ["@"],
            positioningStrategy: "fixed",
            renderItem: (data) => {
              if (data.disabled) {
                return `<div style="height:10px;line-height:10px;font-size:10px;background-color:#ccc;margin:0 -20px;padding:4px">${data.value}</div>`;
              }
              return data.value;
            },
            renderLoading: () => {
              return "Loading...";
            },
            source: function(searchTerm, renderList, mentionChar) {
              var matches = [];

              if (searchTerm.length === 0) {
                matches = advancedValues;
              } else {
                for (i = 0; i < advancedValues.length; i++)
                  if (~advancedValues[i].value.toLowerCase().indexOf(searchTerm.toLowerCase()))
                    matches.push(advancedValues[i]);
              }

              //create group header items
              var matchesWithGroupHeaders = [];
              var currentTeam;
              for (i = 0; i < matches.length; i++) {
                var match = matches[i];
                if (currentTeam !== match.team) {
                  matchesWithGroupHeaders.push({
                    id: match.team,
                    value: match.team,
                    disabled: true,
                  });
                  currentTeam = match.team;
                }
                matchesWithGroupHeaders.push(match);
              }
              matches = matchesWithGroupHeaders;

              window.setTimeout(() => {
                renderList(matches, searchTerm);
              }, 1000);
            },
          },
        },
      });

      function showMenu() {
        quill2.getModule("mention").openMenu("@");
      }

      function addMention() {
        quill2.getModule("mention").insertItem(
          {
            denotationChar: "@",
            id: "123abc",
            value: "Hello World",
          },
          true
        );
      }
    </script>
  </body>
</html>
