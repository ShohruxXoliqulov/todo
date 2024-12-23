<?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM tasks WHERE task ILIKE $1 ORDER BY id DESC";
$result = pg_query_params($conn, $query, array("%$search%"));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ToDo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
<section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div class="card rounded-3">
                    <div class="card-body p-4">

                        <h4 class="text-center my-3 pb-3">To Do List</h4>

                        <form method="POST" action="add_task.php" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                            <div class="col-12">
                                <div data-mdb-input-init class="form-outline">
                                    <input type="text" name="task" id="form1" class="form-control" required/>
                                    <label class="form-label" for="form1">Enter a task here</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <select name="priority" class="form-select" required>
                                    <option value="High">High</option>
                                    <option value="Medium" selected>Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Save</button>
                            </div>
                        </form>

                        <form method="GET" action="index.php" class="mb-4">
                            <input type="text" name="search" placeholder="Search tasks" class="form-control" />
                            <button type="submit" class="btn btn-info mt-2">Search</button>
                        </form>

                        <table class="table mb-4">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Todo item</th>
                                    <th scope="col">Priority</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (pg_num_rows($result) > 0): ?>
                                    <?php $no = 1; while ($row = pg_fetch_assoc($result)): ?>
                                        <tr>
                                            <th scope="row"><?= $no++; ?></th>
                                            <td><?= htmlspecialchars($row['task']); ?></td>
                                            <td><?= htmlspecialchars($row['priority']); ?></td>
                                            <?php
                                            $status = $row['status'];
                                            $badge_color = ($status === 'Finished') ? 'success' : 'warning';
                                            ?>
                                            <td><span class="badge bg-<?= $badge_color; ?>"><?= $status; ?></span>  </td>
                                            <td>
                                                <a href="show_task.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">Show</a>

                                                <form method="POST" action="delete_task.php" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                                <form method="POST" action="update_task.php" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <button type="submit" class="btn btn-success ms-1">Finished</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No tasks found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>