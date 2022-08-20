<?php include('./inc/header.php'); ?>
<?php include('./inc/nav.php'); ?>
<?php
if(!isset($_SESSION['auth'])){
    $err[] = 'Please Login To Access This Page';
    $_SESSION['error'] = $err;
    header('Location:./login.php');
    die;
}
?>
<h1 style="color:#41adff; text-align:center">ToDo List Guide</h1>

<section id="list-lay">
    <div class="guide-sec">
        <div class="pad-150">
            <h3 class="h3-l">Organize Your Work</h3>
            <p class="p-lead">Become Focused, Organized, And Calm With Todoist 😃✌</p>
            <p class="p-lead"> One Of The Best Task Manager And To-Do List App In The World 😎✨</p>
        </div>
    </div>

    <div id="about">
        <div class="pad-150">
        <h3 class="h3-l">Add Your Tasks</h3>
            <p class="p-lead">Organize Your Life 😃</p>
            <p class="p-lead"> Achieve More Every Day 😎✨</p>
        </div>
    </div>

    <div id="services">
        <div class="pad-150">
        <h3 class="h3-l">What You Can Achieve Using This App</h3>
           <form action="./addtask.php">
                <button>Create</button>
           </form>
        </div>
        </div>
    </div>
</section>






<?php include('./inc/footer.php'); ?>