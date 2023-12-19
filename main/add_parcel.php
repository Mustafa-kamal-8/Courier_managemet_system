<?php include_once "../components/header.php"; ?>
<body class="container-fluid h-100">
    <div class=" row h-100">
        <?php include_once "../components/sidebar.php"; ?>
        <div class="col-10 p-3 h-100">
            <div class="row border-bottom p-3">
                <div class="col-10 p-3">
                    <p class="m-0 fs-3 text-secondary">Add Parcel </p>
                </div>    
            </div>
            <!--table-->
            <div class="row p-4 pt-0 overflow-auto h-75">
                <center>
                <form class="p-3 pb-0 border bordar-dark rounded shadow w-50" action="" method="post"> 
                    <strong class="p-4 fs-4">Parcel information</strong>
                    <hr>
                    <table class="pt-5 mt-5">
                        <tr>
                            <td>
                                Parcel Name
                            </td>
                            <td class="p-2">
                                <input name="p_name" type="text" class="p-1" required>
                            </td>
                        </tr>
                        <!--sender-->
                        <tr>
                            <td>
                                Sender Name
                            </td>
                            <td class="p-2">
                                <input name="s_name" type="text" class="p-1" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Sender's Contact No
                            </td>
                            <td class="p-2">
                                <input name="s_contact" type="text" class="p-1" onkeypress="return event.charCode>=48 && event.charCode<=57">
                            </td>
                        </tr>
                        <!--receiver-->
                        <tr>
                            <td>
                                Reciever name
                            </td>
                            <td class="p-2">
                                <input name="r_name" type="text" class="p-1" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Reciever's address
                            </td>
                            <td class="p-2">
                                <select name="r_address" id="" class="p-1 w-100 bg-white">
                                    <option selected disabled value=""></option>
                                <?php
                                $brn = "SELECT * FROM branch ";
                                $res = mysqli_query($con,$brn);
                                while($bData = mysqli_fetch_assoc($res)){
                                    echo "<option value='".$bData['id']."'>".$bData['b_name'].",".$bData['address']."</option>";
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Reciever contact no.
                            </td>
                            <td class="p-2">
                                <input name="r_contact" type="text" class="p-1" onkeypress="return event.charCode>=48 && event.charCode<=57">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Parcel Weight
                            </td>
                            <td class="p-2">
                                <input name="p_weight" placeholder ="kg"type="text" class="p-1" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                               Parcel Height
                            </td>
                            <td class="p-2">
                                <input name="p_height" placeholder ="inch" type="text" class="p-1">
                            </td>
                        </tr>
                        <tr>
                            <td>
                               Parcel Width
                            </td>
                            <td class="p-2">
                                <input name="p_width" placeholder ="inch" type="text" class="p-1">
                            </td>
                        </tr>
                        <tr class=" bg-white shadow">
                            <td class="p-2">
                                <a href="./parcel.php" class="btn btn-warning shadow">Back</a>
                            </td>
                            <td class="p-2">
                                <input type="submit" name="submit" class="btn btn-primary shadow" value="Place order">
                            </td>
                        </tr>
                    </table>
                </form>
                </center>
            </div>
              <!--footer-->
              <?php include_once "../components/footer.php"; ?>
        </div>

        
    </div>
</body>
</html>

<?php 

//local time
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['submit'])){
    $p_name = $_POST['p_name'];
    $s_name = $_POST['s_name'];
    $s_contact = $_POST['s_contact'];
    $r_name = $_POST['r_name'];
    $r_address = $_POST['r_address'];
    $r_contact = $_POST['r_contact'];
    $p_weight = $_POST['p_weight'];
    $p_height = $_POST['p_height'];
    $p_width = $_POST['p_width'];

    
    //sender part
    $check = "select * from `customer` where c_name = '$s_name' && c_phone = '$s_contact' ";
    $resultS = mysqli_query($con,$check);
    if(mysqli_num_rows($resultS)<1){
        //new customer
        $queryS = "INSERT INTO `customer` VALUES(null,'$s_name',$s_contact,'_') ";
        $res = mysqli_query($con,$queryS);
    }
    //fetch data
    $query = "SELECT * FROM `customer` WHERE c_name = '$s_name' && c_phone = '$s_contact' ";
    $get_sid = mysqli_fetch_assoc(mysqli_query($con,$query));
    $s_id = $get_sid['C_id'];
    //echo "sender : ".$s_id;

    //receiver part
    $check = "select * from `customer` where c_name = '$r_name' && c_phone = '$r_contact' && c_address = '$r_address' ";
    $resultR = mysqli_query($con,$check);
    if(mysqli_num_rows($resultR)<1){
        //new customer
        $queryR = "INSERT INTO `customer` VALUES(null,'$r_name',$r_contact,'$r_address') ";
        $res = mysqli_query($con,$queryR);
    }
    //fetch data
    $query = "SELECT * FROM `customer` where c_name = '$r_name' && c_phone = '$r_contact' && c_address = '$r_address' ";
    $get_rid = mysqli_fetch_assoc(mysqli_query($con,$query));
    $r_id = $get_rid['C_id'];
    //echo "reciver : ".$r_id;

    //final entry for parcel
    if ($p_weight<=5) {
        $amount= 50;
    } elseif ($p_weight<=10) {
        $amount = 100;
    } else {
       $amount = 500;
    }
    
    // $query = "INSERT INTO `` VALUES(null) ";
    $track = generate_code($p_name);
    $inQuery = "INSERT INTO `courier` VALUES ('$track',$s_id,$r_id,'$p_name',$p_weight,$p_height,$p_width,current_timestamp(),$amount)";
    mysqli_query($con,$inQuery);
    $statusNum = 1;
    
    $addQuery = "INSERT INTO `c_status` VALUES (null,$statusNum,'$track',current_timestamp())";
    mysqli_query($con,$addQuery);

    $brID = $_SESSION['branch'];
    $locQuery = "INSERT INTO `courier_location` VALUES(null,$brID,'$track') ";
    mysqli_query($con,$locQuery);
   // echo $addQuery;
}

function generate_code($str){
    return $str[0].date("aYmdhi");
}
//atal error: Uncaught mysqli_sql_exception: Unknown column 'fg' in 'field list' in C:\xampp\htdocs\courier_management_system\main\add_parcel.php:170 Stack trace: #0 C:\xampp\htdocs\courier_management_system\main\add_parcel.php(170): mysqli_query(Object(mysqli), 'INSERT INTO `co...') #1 {main} thrown in C:\xampp\htdocs\courier_management_system\main\add_parcel.php on line 170

/*
CREATE TABLE COURIER (
    Q_id int PRIMARY KEY NOT NULL;
    ...
    sender_id int,
    reciever_id int,
    FOREIGN KEY (sender_id) REFERENCES customer(c_id),
    FOREIGN KEY (reciever_id) REFERENCES customer(c_id)
);

INSERT INTO `courier`(`Q_id`, `sender_id`, `reciever_id`, `p_name`, `weight`, `height`, `widht`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
Fatal error: Uncaught mysqli_sql_exception: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '))' at line 1 in C:\xampp\htdocs\courier_management_system\main\add_parcel.php:162 Stack trace: #0 C:\xampp\htdocs\courier_management_system\main\add_parcel.php(162): mysqli_query(Object(mysqli), 'INSERT INTO `co...') #1 {main} thrown in C:\xampp\htdocs\courier_management_system\main\add_parcel.php on line 162
INSERT INTO `courier` VALUES ('kpm202305310849',20,21,'k',1,1,1,GETDATE()) 
*/

?>

