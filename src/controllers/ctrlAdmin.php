<?php
        if (isset($_GET['page'])) {
            if (isset($_GET['id'])) {
                switch($_GET['page']){
                    case $_GET['page'] == 'put':
                        header('Location: admin-add.php?id='+ $_GET['id']);
                        exit();
                        break;
                    default:
                        header('Location: /views/administration.php');
                        exit();    
                }
            }
            else {
                switch($_GET['page']) {
                    case $_GET['page'] == 'add':
                        header('Location: ../views/admin-add.php');
                        exit();
                        break;
                    case $_GET['page'] == 'list':
                        header('Location: ../views/admin-list.php');
                        exit();
                        break;
                    default:
                        header('Location: ../views/administration.php');
                        exit();   
                }
            }
            
        }elseif(isset($_GET['id'])) {
            header('Location: admin');
        }
        include "../views/administration.php";
    ?>