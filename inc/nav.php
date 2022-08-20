<header>
    <nav>
        <a href=<?php 
                if(isset($_SESSION['auth'])){
                    echo "./home.php";
                } else{
                 echo "./index.php";
                }    
                ?>>
            <h1>TO-DO</h1>
        </a>
        <ul>
                <li><a href=<?php 
                if(isset($_SESSION['auth'])){
                    echo "./home.php";
                } else{
                 echo "./index.php";
                }    
                ?>>Home</a></li>
                <?php if(isset($_SESSION['auth'])) : ?>
                <li><a href="./list.php">List</a></li>
                <li><a href="./profile.php">Profile</a></li>
                <li><a href="./logout.php">Logout</a></li>
                <?php endif?>
                <?php if (!isset($_SESSION['auth'])): ?>
                <li><a href="./login.php">Login</a></li>
                <li><a href="./signup.php">SignUp</a></li>
                <?php endif ?>
        </ul>
    </nav>
</header>