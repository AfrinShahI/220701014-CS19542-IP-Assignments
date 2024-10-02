<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Event Management</title>
        <style>
            .main{
                display: flex;
                justify-content: center;
                gap: 40px;
                margin-top: 250px;
            }
            .btn{
                padding: 20px;
                border-radius: 20px;
                border: none;
                color: white;
            }
            #user-btn{
                background-color: #29a1e1;
            }
            #user-btn:hover{
                background-color: #a07497c8;
            }
            #admin-btn{
                background-color: rgb(79, 193, 96);
            }
            #admin-btn:hover{
                background-color: #a07497c8;
            }

        </style>
        
    </head>
    <body>
        <div class="main">
            <form action="userLogin.php" method="GET">
            <input id="user-btn" class="btn" type="submit" value="USER LOGIN">
            </form>

            <form action="adminLogin.php" method="GET">
                <input id="admin-btn" class="btn" type="submit" value="ADMIN LOGIN">
            </form>
        </div>

    </body>
</html>
