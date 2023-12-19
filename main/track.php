<?php include_once "../components/header.php"; ?>
<?php

if(isset($_POST['submit'])){
    $track = $_POST['track'];
    $query = "select * from c_status inner join courier on c_status.c_id = courier.Q_id where c_id='$track' order by c_status.s_time desc ";
    $result =mysqli_query($con,$query);
    $data = mysqli_fetch_array($result);

    switch($data['status']){
        case 1: 
            $prog = "6%";
            break;
        case 2:
            $prog = "30%";
            break;
        case 3:
            $prog = "50%";
            break;
        case 4:
            $prog = "70%";
            break;
        case 5:
            $prog = "100%";
            break;
    }
}
?>
<body class="container-fluid h-100">
    <div class=" row h-100">
        <?php 
        if(isset($_SESSION['name'])){
            include_once "../components/sidebar.php";
        }
         ?>
        <div class="col p-3 h-100">
            <div class="row border-bottom p-3">
                <div class="col-10 p-3">
                    <p class="m-0 fs-3 text-secondary">Track parcel</p>
                </div>
                
            
            
            </div>
            <!--table-->
            <div class="row p-4 pt-0 overflow-auto h-75">
                <center>
               <form method = "POST" action="" class="p-2">
                <table>
                    <tr>
                        <td class="p-3">
                            <p>Tracking Number</p>
                        </td>
                        <td class="p-3">
                            <input type="text" class="p-2" name = "track">
                        </td>
                        <td class="p-3">
                            <input type="submit" value="track" class="btn btn-success btn-sm px-3" name = "submit">
                        </td>
                    </tr>
                </table>
               </form>
                <div class="p-3 w-50 border-top border-bottom">
                    <p class="text-start"><strong>Courier name : </strong><?php echo $data['p_name']; ?></p>
                    <p class="text-start"><strong>Last updated time : </strong><?php echo $data['s_time']; ?></p>
                </div>
                

               </center>
               <div class="w-100">

                   

                    <div class="row ">
                        <div class="col text-start ">
                            <p class="fw-bold">Accepted by Courier</p>
                            
                        </div>
                        <div class="col text-center ">
                            <p class="fw-bold">Dispatched</p>
                        
                        </div>
                        <div class="col text-center ">
                            <p class="fw-bold">Shipped</p>
                            
                        </div>
                        <div class="col text-center ">
                            <p class="fw-bold">Out for Delivery</p>
                        
                        </div>
                        <div class="col text-end ">
                            <p class="fw-bold">Delivered</p>
                            
                        </div>
                    </div>
                 
                    
                    <div  class="progress" role="progressbar" aria-label="Info striped example" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped 
                        <?php if($prog=='100%') { echo "bg-success"; } ?>" 
                        style="width: <?php echo $prog; ?>"></div>
                    </div>
                </div>
            </div>
              <!--footer-->
              <?php include_once "../components/footer.php"; ?>
        </div>

        
    </div>
</body>
</html>
