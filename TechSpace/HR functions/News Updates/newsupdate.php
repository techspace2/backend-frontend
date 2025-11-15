<?php
include 'connect.php';
session_start();

// INSERT TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $name = mysqli_real_escape_string($conn, $_POST['NName']);
    $desc = mysqli_real_escape_string($conn, $_POST['txtdesc']);
    $date = mysqli_real_escape_string($conn, $_POST['NDate']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO news (NName, NDesc, NDate, HrManagerId) VALUES ('$name', '$desc', '$date', '$id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Record Successfully Added";
    } else {
        $_SESSION['message'] = "Failed to Add Record: " . mysqli_error($conn);
    }

    header("Location: newsupdate.php");
    exit();
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM news WHERE NId = '$taskID'");
    header("Location: newsupdate.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM news WHERE NId = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $name = mysqli_real_escape_string($conn, $_POST['NName']);
    $desc = mysqli_real_escape_string($conn, $_POST['txtdesc']);
    $date = mysqli_real_escape_string($conn, $_POST['NDate']);

    $sql = "UPDATE news SET NName='$name', NDesc='$desc', NDate='$date' WHERE NId='$taskID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Record Successfully Updated";
    } else {
        $_SESSION['message'] = "Failed to Update Record: " . mysqli_error($conn);
    }

    header("Location: newsupdate.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="news update.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="../Worker/01.jpg.png" alt="">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../9-HR/hr.php">Back</a>
                </div>
            </div>

            <div class="back1">
                <div class="info">
                    <label for="">NEWS AT TECHSPACE</label>
                    <h1>LATEST NEWS & UPDATES</h1>
                    <p>"Techspace maintains accurate and efficient payroll records to ensure timely and transparent compensation for all employees. Our payroll system tracks wages, deductions, benefits, and tax compliance, adhering to industry standards and labor laws."</p>
                </div>
            </div>
        </div>

        <div class="container">
            <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;">Add<span style="color: rgb(214, 23, 23);">Latest News</span></h1>

            <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 300px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
                <thead>
                    <tr style="background-color: black; color:white; font-size: 20px;">
                        <th style="text-align: center; padding: 20px;">ID</th>
                        <th style="text-align: center; width: 200px;">Name</th>
                        <th style="text-align: center; width: 300px;">Description</th>
                        <th style="text-align: center; width: 200px;">Date</th>
                        <th style="text-align: center; width: 450px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT * FROM news";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            echo "<tr style='font-size: 20px;'>
                                <td style='text-align: center; padding: 20px;'>{$row['NId']}</td>
                                <td style='text-align: center;'>{$row['NName']}</td>
                                <td style='text-align: center;'>{$row['NDesc']}</td>
                                <td style='text-align: center;'>{$row['NDate']}</td>
                                <td style='text-align: center; padding: 20px; display: flex; justify-content: center; align-items: center; gap: 40px;'>
                                    <a href='newsupdate.php?delete={$row['NId']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; cursor: pointer;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                    <a href='newsupdate.php?edit={$row['NId']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 64px 10px 64px; border-radius: 50px; cursor: pointer;'>Edit</a>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h2 style="font-size: 45px; margin-top: -450px; margin-left: 100px;"><?= isset($edit_task) ? "Edit <span style='color: rgb(214, 23, 23);'>News</span> Info" : "Add <span style='color: rgb(214, 23, 23);'>News</span>"; ?></h2>

        <form method="post">
            <?php if (isset($edit_task)): ?>
                <input type="hidden" name="taskID" value="<?= $edit_task['NId']; ?>">
            <?php endif; ?>

            <div class="main" style="display: flex; flex-direction: column; justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32); width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
                <div class="left" style="display: flex; align-items: center; gap: 62px;">
                    <label style="font-size: 24px; color: rgb(66, 66, 66);">Name</label>
                    <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="NName" value="<?= isset($edit_task) ? $edit_task['NName'] : ''; ?>" required>
                </div>

                <div class="left" style="display: flex; align-items: center; gap: 62px;">
                    <label style="font-size: 24px; color: rgb(66, 66, 66);">Description</label>
                    <textarea name="txtdesc" style="z-index: 1;width:390px; padding-top: 10px;  height: 150px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" placeholder="Enter your message" rows="7" required><?= isset($edit_task) ? $edit_task['NDesc'] : ''; ?></textarea><br><br>
                </div>

                <div class="left" style="display: flex; align-items: center; gap: 70px;">
                    <label style="font-size: 24px; color: rgb(66, 66, 66);">Date</label>
                    <input type="date" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="NDate" value="<?= isset($edit_task) ? $edit_task['NDate'] : ''; ?>" required>
                </div>

                <input type="submit" name="<?= isset($edit_task) ? "update_task" : "btnassign"; ?>" value="<?= isset($edit_task) ? "Update News" : "Add News"; ?>" style="width: 250px; margin-top: 30px; height: 50px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">

                <!-- Success or Error Message -->
                <?php if (isset($_SESSION['message'])): ?>
                    <p style="color: green; font-weight: bold; text-align: center;"><?= $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
            </div>
        </form>

        <!-- JavaScript to Restore Scroll Position -->
        <script>
            function restoreScroll() {
                if (localStorage.getItem('scrollPosition')) {
                    window.scrollTo(0, localStorage.getItem('scrollPosition'));
                    localStorage.removeItem('scrollPosition');
                }
            }
        </script>
</body>
</html>
