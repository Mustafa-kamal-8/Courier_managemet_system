<?php include_once "../components/header.php"; ?>
<?php
if(isset($_GET['track'])){
    $id= $_GET['track'] ;
    $query="select * from `c_status` where c_id = '$id' order by s_time desc "; 
    $result = mysqli_query($con,$query);
    $data = mysqli_fetch_array($result);
    switch($data['status']){
        case 1: 
            $status= "Accepted by courier";
            break; 
        case 2: 
            $status= "Dispatched";
            break; 
        case 3: 
            $status= "Shipped";
            break; 
        case 4: 
            $status= "Out for Delivery";
            break; 
        case 5: 
            $status= "Delivered";
            break; 
    }
}


if (isset($_POST['go'])){
    $track = $_POST['track'];
    if($_POST['ns']<=4){
        $ns = $_POST['ns'];
        $query = "insert into c_status values(null,($ns+1),'$track',current_timestamp()) ";
        $result = mysqli_query($con,$query);

        //shipped to nearest branch
        if($_POST['ns'] == 2){
            $getBid = mysqli_query($con,"SELECT customer.c_address FROM courier INNER JOIN customer ON courier.reciever_id = customer.C_id WHERE courier.Q_id = '$track' ");
            $brdata = mysqli_fetch_array($getBid);
            $recieverBranch = $brdata['c_address'];
            $locQuery = "UPDATE `courier_location` SET b_id = $recieverBranch WHERE q_id = '$track' ";
            echo $locQuery; 
            mysqli_query($con,$locQuery);
        }

        if ($result){
            echo "<script>alert('Status updated'); </script>";
        }
        else{
            echo "<script>alert('Something is wrong'); </script>";
        }
    }
    else{
        echo "<script>alert('no more'); </script>";
    }
    
}
//Fatal error: Uncaught mysqli_sql_exception: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'order by s_time desc' at line 1 in C:\xampp\htdocs\courier_management_system\main\parcel_manage.php:6 Stack trace: #0 C:\xampp\htdocs\courier_management_system\main\parcel_manage.php(6): mysqli_query(Object(mysqli), 'select * from `...') #1 {main} thrown in C:\xampp\htdocs\courier_management_system\main\parcel_manage.php on line 6
?>

<body class="container-fluid h-100">
    <div class=" row h-100">
        <?php include_once "../components/sidebar.php"; ?>
        <div class="col-10 p-3 h-100">
            <div class="row border-bottom p-3">
                <div class="col-10 p-3">
                    <p class="m-0 fs-3 text-secondary">Parcel Manage</p>
                </div>
            </div>
            <!--table-->
            <div class="row p-4 pt-0 overflow-auto h-75">
                <center>
                <form action="" class="py-5 w-50" method="POST">
                    <div class="p-3 pb-0">
                        <p>Tracking Number</p>
                    </div>
                    <div class="p-3 pt-0">
                        <input type="text" class="p-2" name="track" id="trk" placeholder="tracking id" 
                        value = "<?php 
                        if (isset($_GET['track'])){
                            echo $_GET['track'];
                        }
                        ?>">
                    </div>
                    <div class="p-3">
                        status : <strong id="status"><?php echo $status;?></strong>
                        <input type="hidden" name ="ns" value =  "<?php 
                        if (isset($data['status'])){
                            echo $data['status'];
                        }
                        ?>">
                    </div>
                    <div class="p-3 row">
                        <div class="col p-2">
                            <button type="button" class="btn btn-secondary btn-sm w-100" onClick="btnlink()">Get Status</button>
                        </div>
                        <div class="col p-2">
                            <input type="submit" value="Move Next" class="btn btn-success btn-sm w-100" name="go">
                        </div>
                    </div>
                </form>
                </center>
            </div>
            <!--footer-->
            <?php include_once "../components/footer.php"; ?>
        </div>
    </div>
</body>
<script>
    function btnlink(){
        const trk= document.getElementById('trk').value;
        const slink="./parcel_manage.php?track="+trk;
        console.log(slink);
        window.location.assign(slink);
    }
</script>
</html>


