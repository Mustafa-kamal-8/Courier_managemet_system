<?php include_once "../components/header.php"; ?>
<body class="container-fluid px-0 h-100 bg-img">
    <style>
        .bg-img{
            background-image: url("../photos/bg.jpg");
            background-size: cover;
        }
    </style>
    <nav class="navbar navbar-expand-lg bg-light shadow">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Courier Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./track.php">TrackParcel</a>
                </li>
            </ul>
            <div class="px-1">
                <a href="./login.php" class="btn btn-success px-4">Login</a>
            </div>
            </div>
        </div>
    </nav>
    <div class="container" style="height: auto;">
        <div class="my-4 w-25 p-3 bg-white rounded shadow">
            <div class="w-100 bg-white overflow-auto" style="height: 70.7vh;">
                <p class="fw-bold sticky-top bg-white shadow">OUR BRANCHES</p>
                <table class="table">
                    <tr>
                        <th>slno.</th>
                        <th>Branch Name</th>
                        <th>Address</th>
                    </tr>
                    <?php
                    $query = "select * from branch ";
                    $result = mysqli_query($con,$query);
                    $i = 1;
                    while($data = mysqli_fetch_assoc($result)){
                        echo "
                        <tr>
                        <td>".$i."</td>
                        <td>".$data['b_name']."</td>
                        <td>".$data['address']."</td>
                        </tr>";
                        $i++;
                    }
                    
                    ?>
                    
                </table>
            </div>
            
        </div>
    </div>
    <div class="bg-white">
    <?php include_once "../components/footer.php"; ?>
    </div>
</body>
</html>

<?php
?>