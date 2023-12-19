<?php include_once "../components/header.php"; 
session_destroy();
session_abort(); ?>
<body class="container-fluid h-100">
    <div class="py-5 ">
        <center>
            <div class="w-50 py-5">
                <form action="" class="border rounded shadow p-4 " method="POST">
                    <center><strong class="p-2 fs-4 text-danger">EMPLOYEE REGISTER</strong></center>
                    <table class="w-75 px-auto">
                        <tr>
                            <td class="p-2">Employee Name</td>
                            <td  class="p-2"><input type="text" name="name" class="p-2 rounded w-100" required></td>
                        </tr>
                        <tr>
                            <td class="p-2">Phone Number</td>
                            <td  class="p-2"><input type="text" minlength="10" maxlength="10" name="phone" class="p-2 rounded w-100" 
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required></td>
                        </tr>
                        <tr>
                            <td class="p-2">Position</td>
                            <td  class="p-2">
                                <select name="position" class="p-2 rounded w-100" id="">
                                    <option selected disabled value="">--chose one--</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Others">Others</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2">Branch</td>
                            <td  class="p-2">
                                <select name="branch" class="p-2 rounded w-100" id="">
                                    <option selected disabled value="">--chose one--</option>
                                    <?php
                                    $result = mysqli_query($con,"SELECT * FROM `branch` ");
                                    while($data = mysqli_fetch_assoc($result)){
                                        echo "<option value=".$data['id'].">".$data['b_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td  class="p-2">Password</td>
                            <td  class="p-2"><input type="password" name="pwd" class="p-2 rounded w-100" required></td>
                        </tr>
                        <tr>
                            <td  class="p-2">
                                <a href="./login.php" class="btn btn-secondary w-100 shadow">Back</a>
                            </td>
                            <td  class="p-2">
                                <input type="submit" value="Sign up" name ="reg" class="btn btn-success shadow w-100">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </center>
    </div>
    <?php include_once "../components/footer.php"; ?>
</body>
</html>

<?php
    if(isset($_POST['reg'])){
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        $branch = $_POST['branch'];
        $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        $query = "insert into employee values (null,$phone,'$name','$hash','$position',$branch) ";
        $response = mysqli_query($con,$query);
        if($response){
            //echo "Generated hash: ".$hash;
            header("location:./login.php");
        }
    }
    //$2y$10$zWDQZJhBYsUppXpcJzkDx.BlbsR076B7fXcLU2M6w1kiEWIjW2JwG

/* 
create table employee (
    id int NOT NULL AUTO_INCREMENT,
    phone bigint,
    name varchar(50)

    pwd varchar(100),
    position varchar(50),
    branch int,
    PRIMARY KEY (id),
    FOREIGN KEY (branch) REFERENCES branch (id),
) 
INSERT INTO `employee`(`id`, `phone`, `name`, `pwd`, `position`, `branch`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')

create table branch (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(50),
    address varchar(125),
    PRIMARY KEY(id)
); 

ALTER TABLE `branch` RENAME COLUMN `name` to `b_name`;

*/

?>