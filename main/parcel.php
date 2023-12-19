<?php include_once "../components/header.php"; ?>
<body class="container-fluid h-100">
    <div class=" row h-100">
        <?php include_once "../components/sidebar.php"; ?>
        <div class="col-10 p-3 h-100">
            <div class="row border-bottom p-3">
                <div class="col-10 p-3">
                    <p class="m-0 fs-3 text-secondary">Parcel List</p>
                </div>
                <div class="col-2 p-3">
                    <a href="./add_parcel.php" class="btn btn-primary shadow">Add parcel</a>
                </div>
            </div>
            <!--table-->
            <div class="row p-4 pt-0 overflow-auto h-auto" style="max-height: 75h;">
                <table class="table table-success border border-dark table-striped">
                    <tr class="sticky-top p-3">
                        <th>Slno.</th>
                        <th>Parcel Name</th>
                        <th>Tracking ID</th>
                        <th>Sender name</th>
                        <th>Receiver name</th>
                        <th>Receiver's address</th>
                        <th>Total amount</th>
                    </tr>
                    <!--<tr>
                        <td>1</td>
                        <td>abcd</td>
                        <td><a href="" class="btn btn-primary shadow">view</a></td>
                    </tr>-->
                    <?php
                    //t1 is courier
                    //t2 is sender
                    //t3 is reciever
                    //b is branch address
                    $currentBranch = $_SESSION['branch'];
                    $query = "SELECT t1.p_name, t1.Q_id, b.address AS brAddr, t2.c_name AS sender, t3.c_name AS reciever, t3.c_address, t1.amount
                    FROM `courier` AS t1 
                    JOIN `customer` AS t2 ON t1.sender_id = t2.C_id
                    JOIN `customer` AS t3 ON t1.reciever_id = t3.C_id
                    JOIN `branch` AS b ON b.id = t3.c_address 
                    JOIN `courier_location` AS c ON c.q_id = t1.Q_id
                    WHERE c.b_id = $currentBranch ";
                    $result = mysqli_query($con,$query);
                    $i = 1;
                    while($data = mysqli_fetch_assoc($result)){
                        echo "
                        <tr>
                        <td>".$i."</td>
                        <td>".$data['p_name']."</td>
                        <td>".$data['Q_id']."</td>
                        <td>".$data['sender']."</td>
                        <td>".$data['reciever']."</td>
                        <td>".$data['brAddr']."</td>
                        <td>".$data['amount']."</td>
                        </tr>";
                        $i++;
                    }
                    ?>
                </table>
            </div>
              <!--footer-->
              <?php include_once "../components/footer.php"; ?>
        </div>

        
    </div>
</body>
</html>
<?php 
/*
SELECT t1.p_name, t1.Q_id, t2.c_name AS sender, t3.c_name AS reciever, t3.c_address 
FROM `courier` AS t1 
JOIN `customer` AS t2 ON t1.sender_id = t2.C_id 
JOIN `customer` AS t3 ON t1.reciever_id = t3.C_id
*/
//Uncaught mysqli_sql_exception: Unknown column 'courier.s_id' in 'on clause' in C:\xampp\htdocs\courier_management_system\main\parcel.php:33 Stack trace: #0 C:\xampp\htdocs\courier_management_system\main\parcel.php(33): mysqli_query(Object(mysqli), 'SELECT * FROM `...') #1 {main} thrown in 
//Uncaught mysqli_sql_exception: Unknown column 'sender' in 'field list' in C:\xampp\htdocs\courier_management_system\main\parcel.php:37 Stack trace: #0 C:\xampp\htdocs\courier_management_system\main\parcel.php(37): mysqli_query(Object(mysqli), 'SELECT t1.p_nam...') #1 {main} thrown in 
?>