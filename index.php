<html>
    <title>Bobs Burgers</title>
 <head>
     <!-- https://www.geeksforgeeks.org/css-font-border/-->
    <header>Classic Models Vehicle Company</header>


    <ul id='navbar'>
        <li><a href="index.php">Inventory Index</a></li>
        <li><a href="reps.php">Sales Rep Data</a></li>
    </ul>

    <h style="font-size: 38px; font-family: monospace; color: rebeccapurple">
    Inventory Index
    </h>


     <style>
        * {
             text-align: center;
         }

         .table, th, td {
            border: 2px solid black;
            background-color: bisque;
         }

        header {
            font-family: fantasy;
            font-size: 80px;
            border: 3px solid navy;
            color: gold;
            background-color: beige;
            text-shadow: 0 0 3px #FF0000, 0 0 5px #0000FF;
         }

        .navbar, li {
            font-family: sans-serif;
            display: inline;
            padding: 5px;
            font-size: 60px;
            background-color: blanchedalmond;

         }

         .buto {
              background-color: gold;
              border: none;
              color: white;
              padding: 19px 30px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
             border: 2px solid cornflowerblue;
            }
          .butt {
              background-color: cornflowerblue;
              border: none;
              color: white;
              padding: 19px 30px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              border: 2px solid gold;
            }

         .sorters{
             background-color: plum;
              border: none;
              color: white;
              padding: 19px 30px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              border: 2px solid rebeccapurple;

         }

         .mmm{
            font-family: monospace;
            padding: 9px;
            font-size: 28px;
            color: rebeccapurple;

         }

         input {

             height: 125px;
             width: 480px;
             font-family: sans-serif;
             font-size: 34px;
             line-height: 3px;

         }


     </style>

</head>

    <body style="background-color: burlywood;">

    <?php





    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classicmodels";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT productName, quantityInStock, productDescription, productCode, MSRP, productLine FROM products";
    $result = $conn->query($sql);

    if(!$result)  {
        echo 'Trouble connecting to database' ;
    }

    $jsonarray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $jsonarray[] = $row;
        } ;

        $conn->close();


        ?>


    <div>
     <input id="searcher" type="text" id="myInput" onkeyup="filter()" placeholder="Search for Product Line.." title="Type in a name">
    </div>
    <div>
        <!--https://stackoverflow.com/questions/8837191/sort-an-html-list-with-javascript -->
    <button class="sorters" onclick="sortascend()">Sort items from least stock to most stock</button>
    <button class="sorters" onclick="sortdescend()">Sort items from most stock to least stock</button>
    </div>
    <p class="mmm">Configure items filter by quantity in stock</p>
    <p class="mmm">Max</p>
    <button class="butt" onclick="filtermax(50)">less than 50 units</button>
    <button class="butt" onclick="filtermax(100)">less than 100 units </button>
    <button class="butt" onclick="filtermax(500)">less than 500 units </button>
    <button class="butt" onclick="filtermax(1000)">less than 1000 units </button>
    <button class="butt" onclick="filtermax(2500)">less than 2500 units </button>
    <button class="butt" onclick="filtermax(5000)">less than 5000 units </button>
    <button class="butt" onclick="filtermax(10000)">less than 10000 units </button>
    <br>
    <p class="mmm">Min</p>
    <button class="buto" onclick="filtermin(50)">more than 50 units </button>
    <button class="buto" onclick="filtermin(100)">more than 100 units </button>
    <button class="buto" onclick="filtermin(500)">more than 500 units </button>
    <button class="buto" onclick="filtermin(1000)">more than 1000 units </button>
    <button class="buto" onclick="filtermin(2500)">more than 2500 units </button>
    <button class="buto" onclick="filtermin(5000)">more than 5000 units </button>
    <button class="buto" onclick="filtermin(10000)">more than 10000 units </button>



        <table id="defaulttable" width="100%" cellpadding="6" cellspace="8">

        <tr>
            <th>Product Name</th>
            <th>Product Code</th>
            <th>Description</th>
            <th>Quantity in Stock</th>
            <th>Recommeded Retail Price</th>
            <th>Product Line</th>
            </tr>
        <?php
            foreach($jsonarray as $Array) {
                $output =
                "<tr>
                <td>" .$Array['productName']. "
                <td>" .$Array['productCode']. "
                <td>".$Array['productDescription']. "
                <td>" .$Array['quantityInStock']. "
                <td>".$Array['MSRP']. "
                <td>".$Array['productLine']. "
                </tr>";
            echo $output ;
            };

            ?>


        </table>

           <?php
    echo "<script>
    function droplist1() {
      document.getElementById('linelist').classList.toggle('show');
    }

   function filter() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById('myInput');
      filter = input.value.toUpperCase();
      table = document.getElementById('defaulttable');
      tr = table.getElementsByTagName('tr');
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td')[5];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = '';
          } else {
            tr[i].style.display = 'none'
          }
        }
      }
    } ;

    function sortdescend() {
      var table, rows, switching, i, x, y, shouldSwitch;
      table = document.getElementById('defaulttable');
      switching = true;
      while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
          //start by saying there should be no switching:
          shouldSwitch = false;
          x = rows[i].getElementsByTagName('TD')[3];
          y = rows[i + 1].getElementsByTagName('TD')[3];
          if (parseInt(x.innerHTML) < parseInt(y.innerHTML)){
            shouldSwitch = true;
            break;
          }
        }
        if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
        }
      }
    };

    function sortascend() {
      var table, rows, switching, i, x, y, shouldSwitch;
      table = document.getElementById('defaulttable');
      switching = true;

      while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
          shouldSwitch = false;
          x = rows[i].getElementsByTagName('TD')[3];
          y = rows[i + 1].getElementsByTagName('TD')[3];

          if (parseInt(x.innerHTML) > parseInt(y.innerHTML) ) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
        if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
        }
      }
    }

     function filtermin(min) {
      var table, tr, td, i, quantity;
      table = document.getElementById('defaulttable');
      tr = table.getElementsByTagName('tr');
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td')[3];
        if (td) {
          quantity = parseInt(td.textContent);
          if (quantity > min) {
            tr[i].style.display = '';
          } else {
            tr[i].style.display = 'none';
          }
        }
      }
    }
    function filtermax(max) {
      var table, tr, td, i, quantity;
      table = document.getElementById('defaulttable');
      tr = table.getElementsByTagName('tr');
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td')[3];
        if (td) {
          quantity = parseInt(td.textContent);
          if (quantity < max) {
            tr[i].style.display = '';
          } else {
            tr[i].style.display = 'none';
          }
        }
      }
    }


        </script>";
    ?>

    </body>

<footer>
    <p style="text-shadow: 0 0 3px #FF0000, 0 0 5px #0000FF; color: gold; font-family: fantasy; font-size: 24px;">Classic Models Vehicle Company</p>
    <p style="font-size:30px; font-family:monospace; color: dodgerblue">Created by UCD student 16453992</p>

</footer>





</html>
