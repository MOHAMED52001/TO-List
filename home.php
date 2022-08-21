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
            <td> Task ID </td>
            <td> Task Name</td>
            <td>Description</td>
            <td>Created</td>
            <td></td>
        </tr>
    </th>
    <?php foreach ($per_Tasks as $key => $tasks) :

    ?>
        <tbody>
            
                <td><?= $key ?></td>
                <td><?= $tasks['Task Name'] ?></td>
                <td><?= $tasks['Task Description'] ?></td>
                <td><?= $tasks['Time Created'] ?></td>
                <td><a href="./edit.php?id=<?=$key?>&name=<?=$tasks['Task Name']?>&des=<?=$tasks['Task Description']?>">Edit</a></td>
            <?php

endforeach; ?>
</tbody>
</table>