<!doctype html>
<html>

  <head>
    <style>
      html,
      body {
        height: 100%;
      }

      html {
        display: table;
        margin: auto;
      }

      body {
        display: table-cell;
        vertical-align: middle;
      }

      body {
        background-image: url(daniel-robert-MRxD-J9-4ps-unsplash.jpg);
        background-size: cover;
      }

    </style>

    <meta charset="utf-8">
    <title>Search</title>
  </head>

  <body>
    <div style="width: 600px; margin: 10px auto">
      <h1 >
        <center>Texas Concert Search</center>
      </h1>
      <form action="searchaction.php" method="get">
        <input type="text" style="width: 100%; height: 35px; font-size: 18px;" name="q" placeholder="Enter the name of the artist and search..." spellcheck="true" required />
        <br>
        <div style="text-align: center"><input type="submit" style="font-size: 16px; margin-top: 10px; width: 100px;" name="search" value="Search"></div>
      </form>
    </div>
  </body>

</html>
