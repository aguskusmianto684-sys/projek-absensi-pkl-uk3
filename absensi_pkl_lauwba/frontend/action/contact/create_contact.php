<?php
    include '../../../config/connection.php';
    include '../../../config/escapeString.php';
    
    if(isset($_POST['tombol'])){
        $name = escapeString($_POST['name']);
        $email = escapeString($_POST['email']);
        $telepon = escapeString($_POST['telepon']);
        $message = escapeString($_POST['message']);

        $qInsert = "INSERT INTO message (name, email, telepon, message) VALUES('$name', '$email', '$telepon', '$message')";

        if (mysqli_query($connect, $qInsert)) {
        echo "
        <script>alert('Data Berhasil Ditambah');
         window.location.href ='../../index.php#contact ';
        </script>
        ";
        }else{
            echo"
            <script>
            alert('Data Gagal Ditambah : " . mysqli_error($connect) . "';
            window.location.href ='../../index.php#contact ';
            </script>
            ";

    }}
    

    ?>
