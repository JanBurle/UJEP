  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="UTF-8" />
    <title>JSON in PHP</title>
  </head>

  <body>

    <h1>JSON Exchange with Server</h1>

    <form id="jsonForm">
      <input type="text" id="name" placeholder="Enter name" required />
      <input type="email" id="email" placeholder="Enter email" required />
      <button type="submit">Send JSON</button>
    </form>

    <div id="response"></div>

    <script>
      // let form = document.getElementById('jsonForm');
      let form = document.forms[0];

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let data = {
          name: form.name.value,
          email: form.email.value
        };

        let href = new URL('json-resp.php', window.location.href);

        let response = await fetch(href, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        let result = await response.json();
        let msg = result.message || result.error;

        let div = document.getElementById('response');
        div.innerHTML = `<p>Server says: ${msg}</p>`;
      });
    </script>
  </body>

  </html>
