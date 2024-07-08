



<nav>
    <i class='bx bx-menu toggle-sidebar'></i>
    <form action="#">
        <div class="form-group">
            <h3>Online Appointment</h3>
        </div>
    </form>
    <?php

    if (isset($_SESSION["firstname"], $_SESSION["middleinitial"], $_SESSION["lastname"], $_SESSION["image_url"])) {
        $fullName = $_SESSION["firstname"] . " " . $_SESSION["middleinitial"] . " " . $_SESSION["lastname"];
        $image_url = $_SESSION["image_url"];
        ?>
        <a class='nav-link' href='#'>
            <h10> <?php echo $fullName; ?></h10>
        </a>
        <span class='divider'></span>
        <div class='profile'>
            <img src='<?php echo $image_url; ?>' alt='Profile Image'>
            <ul class='profile-link'>
                <li><a href='../querys/logout.php'><i class='bx bxs-log-out-circle'></i> Logout</a></li>
            </ul>
        </div>
    <?php } ?>
</nav>
