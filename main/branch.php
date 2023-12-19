<?php include_once "../components/header.php"; ?>
<body class="container-fluid h-100">
    <div class=" row h-100">
        <?php include_once "../components/sidebar.php"; ?>
        <div class="col-10 p-3 h-100">
            <div class="row border-bottom p-3">
                <div class="col-10 p-3">
                    <p class="m-0 fs-3 text-secondary">Branch List</p>
                </div>
        
            </div>
            <!--table-->
            <div class="row p-4 pt-0 overflow-auto h-auto" style="max-height: 75%;">
                <table class="table table-success border border-dark table-striped">
                    <tr class="sticky-top p-3 shadow border-right border-2">
                        <th>
                            Slno.
                        </th>
                        <th>Branch Name</th>
                        <th>Manager Name</th>
                        <th>Address</th> 
                    </tr>
                    <?php

                    $query = "SELECT * FROM `branch` INNER JOIN `employee` ON branch.id = employee.id WHERE employee.position = 'Manager' ";
                    $result = mysqli_query($con,$query);

                    $sl = 1;
                    while($data = mysqli_fetch_assoc($result)){
                        echo "
                    <tr>
                        <td>".$sl."</td>
                        <td>".$data['b_name']."</td>
                        <td>".$data['name']."</td>
                        <td>".$data['address']."</td>
                    </tr>"; 
                    $sl++;                           
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