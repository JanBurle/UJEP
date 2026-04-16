<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title>JSON in JS</title>
</head>

<body>
  <script>
    // JSON literal
    let obj = {
      "name": "Alice",
      "age": 30,
      "isStudent": false,
      "hobbies": ["reading", "traveling"],
      "address": {
        "street": "123 Main St",
        "city": "Anytown"
      },
      "partner": null
    }

    // Accessing properties
    console.log(obj);
    console.log(obj.name);
    console.log(obj.hobbies[0]);
    console.log(obj.address.city);
    console.log(obj.partner);
  </script>

  <script>
    // conversion of JS object to JSON string
    let jsonString = JSON.stringify(obj);
    console.log(jsonString);
  </script>

  <script>
    // conversion of JSON string to JS object
    let objParsed = JSON.parse(jsonString);
    console.log(objParsed);
  </script>

  <script>
    // conversion of JSON string literal to JS object
    let str = `
    {"name":"Alice",
     "age":30,
     "isStudent":false,
     "hobbies":["reading","traveling"],
     "address":{"street":"123 Main St","city":"Anytown"},
     "partner":null}
    `;
    console.log(JSON.parse(str));
  </script>

  <script>
    // invalid JSON
    let badStr = `
    {"name":"Alice",
     "age":30,
     "isStudent":false,
     "hobbies":["reading","traveling"],
     "address":{"street":"123 Main St","city":"Anytown"},
     partner:null}
    `;

    try {
      console.log(JSON.parse(badStr));
    } catch (e) {
      console.error("Error parsing JSON:", e.message);
    }
  </script>
</body>

</html>
