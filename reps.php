<html>

<title>Sales Reps</title>

<head>
    <!-- https://www.geeksforgeeks.org/css-font-border/-->
    <header>Classic Models Vehicle Company</header>

    <ul id='navbar'>
        <li><a href="index.php">Inventory Index</a></li>
        <li><a href="reps.php">Sales Rep Data</a></li>

    </ul>


    <h style="font-size: 38px; font-family: monospace; color: rebeccapurple">
    Sales Representatives Data
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


    $sql1 = "SELECT employees.firstName, employees.lastName, employees.email, employees.employeeNumber, employees.reportsTo, employees.officeCode AND offices.officeCode, offices.city, offices.addressLine1, offices.addressLine2, offices.state, offices.country, offices.postalCode FROM classicmodels.employees LEFT JOIN classicmodels.offices ON employees.officeCode = offices.officeCode WHERE employees.jobTitle = 'Sales Rep'";

    $sql2 = "SELECT firstName, lastName, employeeNumber FROM employees";

    $sql3 = "SELECT salesRepEmployeeNumber, addressLine1, addressLine2, city, state, postalCode, customerName, customerNumber, country, creditLimit FROM customers";

    $sql4 = "SELECT orders.customerNumber,  orders.orderNumber AND orderdetails.orderNumber, orderdetails.quantityOrdered, orderdetails.priceEach, customers.customerNumber, customers.salesRepEmployeeNumber FROM classicmodels.customers RIGHT JOIN classicmodels.orders ON customers.customerNumber = orders.customerNumber RIGHT JOIN classicmodels.orderdetails ON orders.orderNumber = orderdetails.orderNumber";

    $sql5 = "SELECT orderNumber, quantityOrdered, priceEach FROM orderdetails";

    $result1 = $conn->query($sql1);
    if(!$result1)  {
        echo 'Trouble connecting to database';
    }
    $result2 = $conn->query($sql2);
    if(!$result2)  {
        echo 'Trouble connecting to database';
    }
    $result3 = $conn->query($sql3);
    if(!$result3)  {
        echo 'Trouble connecting to database';
    }
    $result4 = $conn->query($sql4);
    if(!$result4)  {
        echo 'Trouble connecting to database';
    }
    $result5 = $conn->query($sql5);
    if(!$result5)  {
        echo 'Trouble connecting to database';
    }

    $jsonarray1 = array();
    while ($row = mysqli_fetch_assoc($result1)) {
        $jsonarray1[] = $row;
    } ;
    $jsonarray2 = array();
    while ($row = mysqli_fetch_assoc($result2)) {
        $jsonarray2[] = $row;
        } ;

    $jsonarray3 = array();
    while ($row = mysqli_fetch_assoc($result3)) {
        $jsonarray3[] = $row;
        } ;
    $jsonarray4 = array();
    while ($row = mysqli_fetch_assoc($result4)) {
        $jsonarray4[] = $row;
        } ;

    $jsonarray5 = array();
    while ($row = mysqli_fetch_assoc($result5)) {
        $jsonarray5[] = $row;
        } ;

        $conn->close();


        ?>

<table id="defaulttable" width="100%" cellpadding="6" cellspace="8">

    <tr>
        <th>Name</th>
        <th>Email Address</th>
        <th>Office Address</th>
        <th>Manager Name</th>
        <th>Customer Info</th>
        <th>Sales Info</th>
        </tr>

  <?php
    // tried the onlcick man different ways and it wouldn't work. can't understand why as I was able to add to the elements using a similar method
    foreach($jsonarray1 as $Array) {
        $output =
        "<tr>
        <td>" .$Array['firstName']." ".$Array['lastName']. "
        <td>" .$Array['email']. "
        <td>".$Array['addressLine2']. ",<br> " .$Array['addressLine1']. ",<br> ".$Array['city']. ",<br> ".$Array['state']. ",<br> ".$Array['country']. ", <br>".$Array['postalCode']. "
        <td>" .$Array['reportsTo']. "
        <td>
        <button>Click for Customer Info</button>
        <p style='display:none;'; id='".$Array['employeeNumber']."'></p>
        <td>
        <button onclick='fun".$Array['employeeNumber']."()'>Click for Sales Info</button>
        <p id='".$Array['employeeNumber']."orders'></p>
        <p id='".$Array['employeeNumber']."sales'></p>
        <p id='".$Array['employeeNumber']."total'></p>
        </tr>

        <script>

        def function fun".$Array['employeeNumber']."() {
          var x = document.getElementById('".$Array['employeeNumber']."');
          if (x.style.display === 'none') {
            x.style.display = 'block';
          } else {
            x.style.display = 'none';
          }
        };


        </script>"
        ;
    echo $output ;
    };

    ?>
    </table>




  <?php
    foreach($jsonarray2 as $Array) {

    echo "<script>
    var table, tr, td, i;
    table = document.getElementById('defaulttable');
    tr = table.getElementsByTagName('tr');

    var table, tr, td, i, j;
    table = document.getElementById('defaulttable');
    tr = table.getElementsByTagName('tr');
        for (j = 0; j < tr.length; j++) {
            td = tr[j].getElementsByTagName('td')[3];
            if (td) {
                var checky =" .$Array['employeeNumber']. " ;
                td.toString();
                if (td.innerHTML == checky ) {
                    td.innerHTML  = '".$Array['firstName']. " ' + '" .$Array['lastName']. "' ;
              }
            }
        } ;


        </script>";
    }


      foreach($jsonarray3 as $Array) {
        $output3 =
        "<script>
        var content = [' ', ' ', 'Name:   ".$Array['customerName']."', ' ', 'Address:  ', '".$Array['addressLine1']."', '".$Array['addressLine2']."', '".$Array['city']."', '".$Array['state']."', '".$Array['country']."', '".$Array['postalCode']."', ' ', 'Credit Limit:  ".$Array['creditLimit']."', '________________________________'] ;
        var items = document.getElementById('".$Array['salesRepEmployeeNumber']."');
        var i;
        for (i = 0; i < content.length; i++) {
            items.appendChild(document.createTextNode(content[i]));
            items.appendChild(document.createElement('br'));
            }

        </script>";
        echo $output3;
        };


  // THE JSONARRAY4 FOREACH FUNCTION WOULD NOT RUN. I WAS ABLE TO FIGURE OUT THAT IT WAS NOT ABLE TO COMPLETE THE GETELEMENTBYID COMMAND DESPITE AS I WAS ABLE TO ALTER THE [EMPLOYEENUMBER]ORDERS ELEMENT WITH TESTERS SO IT SEEMS THAT THIS IS THE ISSUE. I TINKERED WITH IT AND THE QUERY A LOT SO IN THE STATE I LEFT IT PHP WAS NO LONGER RECOGNIZING 'ORDERNAME' IN THE ARRAY. BECAUSE OF THIS FAILING I WASN'T ABLE TO DO THE SALES CALCULATION EITHER

    //foreach($jsonarray4 as $Array) {
     //   $output4 =
       // "<script>
    //    var content = [' ', '".$Array['orderNumber']. "');
    //    var things = document.getElementById('".$Array['salesRepEmployeeNumber']."orders');
      //  var i;
    //    for (i = 0; i < content.length; i++) {
      //      things.appendChild(document.createTextNode(content[i]));
        //    things.appendChild(document.createElement('br'));
          //  }

    //    </script>";
        //echo $output4;
        //};


    ?>





    </body>

<footer>
    <p style="text-shadow: 0 0 3px #FF0000, 0 0 5px #0000FF; color: gold; font-family: fantasy; font-size: 24px;">Classic Models Vehicle Company</p>
    <p style="font-size:30px; font-family:monospace; color: dodgerblue">Created by UCD student 16453992</p>

</footer>






</html>
