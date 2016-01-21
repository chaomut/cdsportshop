<?php

//////////////////////////////////////////////////////
if (isset($_SESSION['member_id'])) {
    $member_id = $_SESSION['member_id'];
    require './php/connect.php';
    $sql = "select * from member where member_id='$member_id'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);
    $member_name = "คุณ " . $array['member_fname'] . " " . $array['member_lname'];
    $show_login = "<div id='logout' class='nav nav-tabs'>
                            <li><a href='mycart_page.php'><span class='glyphicon glyphicon-shopping-cart'></span> Cart <span style=background-color:orange; id='cart_badge'> </span></a></li>
                            <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                                <span class='glyphicon glyphicon-user'></span> Account
                                        <b class='caret'></b></a>
                                        <ul class='dropdown-menu'>
                                            <li>
                                                <div class='navbar-content'>
                                                    <div class='row'>
                                                        <div class='col-sm-4'>
                                                        <br>
                                                            <a href='profile_page.php' class='active'>View Profile</a>
                                                        </div>
                                                        <div class='col-sm-8'>
                                                            <span>{$member_name}</span>
                                                            <p class='text-muted small'>
                                                                {$array['member_email']}</p>
                                                            <div class='divider'>
                                                            </div>
                                                        </div>                                              
                                                    </div>
                                                </div>
                                                <br>
                                                <div class='navbar-footer'>
                                                    <div class='navbar-footer-content'>
                                                        <div class='row'>
                                                            <div class='col-sm-6'>
                                                                <a href='recoverypassword_page.php' class='btn btn-default btn-sm'>Change Passowrd</a>
                                                            </div>
                                                            <div class='col-sm-6'>
                                                                <a href='index.php?destroy=destrdoy' class='btn btn-default btn-sm pull-right'>Sign Out</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                  </div>";
} else {
    $show_login = "<li><a href='login_page.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
}
////////////////////////////////////////////////////////
if (isset($_GET['destroy'])) {
    session_destroy();
    header("Refresh:0;url=index.php");
    exit();
}
////////////////////////////////////////////////////////
?>

