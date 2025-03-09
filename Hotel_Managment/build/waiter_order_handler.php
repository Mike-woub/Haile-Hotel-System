
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
      /* Apply border radius to the entire table */
      table {
          border: 1px solid white;
          border-collapse: separate; /* Ensure border-radius works */
          border-spacing: 0; /* Remove spacing between cells */
          border-radius: 10px;
          overflow: hidden; /* Ensure rounded corners are visible */
          padding: 8px;
          text-align: center;
      }

      /* Apply border radius to table header */
      th {
          border: 1px solid black;
          background-color: white;
          color: black;
          padding: 10px;
      }

      /* Apply border radius to table cells */
      td {
          font-size: 12px;
          padding: 12px;
          border: 1px solid black;
          background-color: white;
          color: black;
          padding: 10px;
      }

      /* Apply border radius to the first and last cells in the first row */
      tr:first-child th:first-child {
          border-top-left-radius: 10px;
      }

      tr:first-child th:last-child {
          border-top-right-radius: 10px;
      }

      /* Apply border radius to the first and last cells in the last row */
      tr:last-child td:first-child {
          border-bottom-left-radius: 10px;
      }

      tr:last-child td:last-child {
          border-bottom-right-radius: 10px;
      }

      caption {
          font-size: 24px;
      }
    </style>
</head>
<body class="dark:text-white dark:bg-slate-600">
    <header class="w-full sticky bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="ml-8 mr-8 flex flex-row justify-center items-center p-4">
            <div class="flex flex-row items-center gap-3">
                <div><img src="../../img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div>
        </section>
    </header>

    <main>
        <h1 class="text-center text-3xl" >Thank you Waiter your Order will Be Processed</h1>
    <a href="waiter.php" class="mt-10 text-cyan-300 hover:text-cyan-200 text-xl" >GO Back?</a>
    </main>
</body>
</html>