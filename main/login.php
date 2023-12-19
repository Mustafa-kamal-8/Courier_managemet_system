<?php include_once "../components/header.php"; 
if(isset($_SESSION['error'])){
    echo "
    <script>
        alert('".$_SESSION['error']."');
    </script>
    ";
    $_SESSION['error'] = null;
}?>
<body class="container-fluid h-100">
    <div class="py-5 ">
        <center>
            <div class="w-50 py-5">
                <form action="" class="border rounded shadow p-4 " method="POST">
                    <center><strong class="p-2 fs-4 text-danger">EMPLOYEE LOGIN</strong></center>
                    <table class="w-75 px-auto">
                        <tr>
                            <td class="p-2">Employee ID</td>
                            <td  class="p-2"><input type="text" name="id" class="p-2 rounded w-100" 
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required></td>

                        </tr>
                        <tr>
                            <td  class="p-2">Password</td>
                            <td  class="p-2"><input type="password" name="pwd" class="p-2 rounded w-100" required></td>
                        </tr>
                        <tr>
                            <td  class="p-2">
                                <a href="./home.php" class="btn btn-secondary w-100 shadow">Back</a>
                            </td>
                            <td  class="p-2">
                                <input type="submit" value="login" name="submit" class="btn btn-success shadow w-100">
                            </td>
                        </tr>
                    </table>
                    <div class="p-2">
                        <a class= "fs-5"href="./register.php">sign up here </a>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <?php include_once "../components/footer.php"; ?>
</body>
</html>

<?php
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $query = "SELECT * FROM employee WHERE phone = $id" ;
    if(mysqli_query($con, $query)){
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result); 
        $pwd = $_POST['pwd'];
        //password verification
        //$verify = ;
        //echo $row['password'];
        if (password_verify($pwd, $row['pwd'])) {
            echo "done";
        // $_SESSION['msg'] = 'You have logged in successfully';
            $_SESSION['name'] = $row['name'];
            $_SESSION['branch'] = $row['branch'];
            $_SESSION['pos'] = $row['position'];
            header("Location: parcel.php");
        } else {
        // $_SESSION['msg'] = 'Login Failed'; 
            $_SESSION['error'] = "wrong password";
            header("Location:./login.php");
            echo "failed";
        }
    }else{
        echo " <script>
        alert('user does not exist');
        </script>";
    }
    
}
?>