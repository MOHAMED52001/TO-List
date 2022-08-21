<?php include('./inc/header.php'); ?>
<?php include('./inc/nav.php'); ?>
<?php include('./core/functions.php'); ?>

<h1 style="color:#41adff; text-align:center">Tasks</h1>
<?php
$per_Tasks = [];
$file = './db/tasks.json';
$old_tasks = getJsonData($file);


foreach ($old_tasks as $key => $value) {
    if ($key == $_SESSION['account']['email']) {
        $per_Tasks = $value;
        break;
    }
}
?>
<table>
    <th>
        <tr>
            <td> Task Name</td>
            <td style="text-align: center;">Description</td>
            <td>Created</td>
            <td></td>
        </tr>
    </th>
    <?php foreach ($per_Tasks as $key => $tasks) :

    ?>
        <tbody>
            <td><?= $tasks['Task Name'] ?></td>
            <td style="text-align: center;"><?= $tasks['Task Description'] ?></td>
            <td><?= $tasks['Time Created'] ?></td>
        <?php
    endforeach; ?>
        </tbody>
</table>

<br>
<section>
    <div class="serv-content">
        <form action="./addtask.php">
            <p>Add A New Task</p>
            <button>Add Task</button>
        </form>
        <form action="./managetasks.php">
            <p>You Can Edit Your Tasks Either Update Or Delete.</p>
            <button>Edit</button>
        </form>
    </div>
</section>