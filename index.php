<?php

// Function to load the todo list from JSON file
function loadFormList($filename) {
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $formList = json_decode($json, true);
        if ($formList === null) {
            $formList = array();
        }
    } else {
        $formList = array();
    }

    return $formList;
}

// Function to save the todo list to JSON file
function saveFormList($filename, $formList) {
    $json = json_encode($formList, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

// Set the filename for the form list JSON file
$filename = 'form_details.json';

// Load the todo list from JSON file
$formList = loadFormList($filename);

// Check if a new task is submitted
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['grade']) && isset($_POST['class'])) {
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['grade']) && !empty($_POST['class'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $grade = $_POST['grade'];
        $class = $_POST['class'];

        // Create a new form array 
        $newList = array(
            'name' => $name,
            'email' => $email,
            'grade' => $grade,
            'class' => $class,
        );

        // Add the new task to the form list
        $formList[] = $newList;

        // Save the updated form list
        saveFormList($filename, $formList);

    }
}

// Remove a form detail from the form array lists
if (isset($_POST['remove'])) {
    $completedIndex = $_POST['remove'];

    // Remove the completed task from the todo list
    if (isset($formList[$completedIndex])) {
        unset($formList[$completedIndex]);

        // Re-index the array
        $formList = array_values($formList);

        // Save the updated todo list
        saveFormList($filename, $formList);
    }
}

// Check if an updated task is submitted
if (isset($_POST['edit_index']) && isset($_POST['updated_name']) && isset($_POST['updated_email']) && isset($_POST['updated_grade']) && isset($_POST['updated_class'])) {
    $editIndex = $_POST['edit_index'];
    $updatedName = $_POST['updated_name'];
    $updatedEmail = $_POST['updated_email'];
    $updatedGrade = $_POST['updated_grade'];
    $updatedClass = $_POST['updated_class'];

    // Update the name, email, grade and class 
    if (isset($formList[$editIndex])) {
        $formList[$editIndex]['name'] = $updatedName;
        $formList[$editIndex]['email'] = $updatedEmail;
        $formList[$editIndex]['grade'] = $updatedGrade;
        $formList[$editIndex]['class'] = $updatedClass;

        // Save the updated todo list
        saveFormList($filename, $formList);
    }
}

/* Numbering the students details
function ListNumber(){
    static $a = 1;
    echo $a;
    $a++;
}
*/

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENTS FORM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body style="background-color: #371777">
    <div class="container">
        <!--Introduction header-->
        <h1 class="text-center my-4 py-4" style="font-family: Tahoma, Verdana, Segoe, sans-serif; color: white">STUDENTS FORM</h1>

        <div class="w-50 m-auto">
            <!-- Using the grid layout style-->
            <form class="row g-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off"> 
                <div class="col-12 mb-3">
                    <label for="title" class="form-label" style="color: white">Full Name:</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Input your full name here" required>
                    
                </div>

                <div class="col-12">
                    <label for="exampleFormControlInput1" class="form-label" style="color: white">Username:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                
                <div class="col-12">
                    <label for="exampleFormControlInput1" class="form-label" style="color: white">Email address:</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Student's username" required aria-label="Student's username" aria-describedby="basic-addon1">
                        <span class="input-group-text">@lexischool.com</span>
                        <!--<input type="hidden">-->
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="customRange1" class="form-label" style="color: white">Your Grade:</label>
                    <select class="form-select" name="grade" id="grade" aria-label="Default select example" required>
                        <option selected>Open this select menu</option>
                        <option value="F">0 - 39</option>
                        <option value="E">40 - 45</option>
                        <option value="D">45 - 50</option>
                        <option value="C">50 - 59</option>
                        <option value="B">60 - 69</option>
                        <option value="A">70 - 79</option>
                        <option value="A+">80 - 100</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="exampleDataList" class="form-label" style="color: white">Name Of Class:</label>
                    <input class="form-control" list="datalistOptions" name="class" id="class" placeholder="Type to search..." required>
                    <datalist id="datalistOptions">
                        <option value="(React) Frontend Class">
                        <option value="PHP Backend Class">
                        <option value="DevOps Class">
                        <option value="Software Engineering Class">
                        <option value="Docker Class">
                    </datalist>
                </div>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" style="margin-top: 30;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                ADD/SUBMIT
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to submit?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary" name="addTask">Yes</button>
                    </div>
                    </div>
                </div>
                </div>
                <!-- replaced above
                    <button type="submit" class="btn btn-success" name="addTask" style="margin-top: 30;">ADD/SUBMIT</button>
                -->

            </form>
            <br>


            <!--Horizontal line demacation-->
            <hr class="bg-dark w-50 m-auto">

            <!-- Table -->
            <!--<div class="w-50 m-auto">-->
            <h1 style="color: white" align="center">Stored Database</h1>
    </div>

    <div class="container-fluid">
        <table class="table table-dark table-hover">
            <thead align="center">
                <tr>
                <th scope="col">R/N</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Grade</th>
                <th scope="col">Class</th>
                <th scope="col">Action</th>
            <!-- Editing Session below -->
                <th scope="col" style="background-color: gray">Name</th>
                <th scope="col" style="background-color: gray">Email</th>
                <th scope="col" style="background-color: gray">Grade</th>
                <th scope="col" style="background-color: gray">Class</th>
                <th scope="col" style="background-color: gray">Action</th>
                </tr>
            </thead>

            <?php if (!empty($formList)) : ?>

            <tbody align="center">
                <?php foreach ($formList as $index => $list) : ?>
                    <tr>
                        <!--<td><php ListNumber()?></td>-->
                        <td>REG<?php include 'reg_num.php'; ?></td>
                        <td><?php echo $list["name"]; ?></td>
                        <td><?php echo $list["email"] . "@lexischool.com"; ?></td>
                        <td><?php echo $list["grade"]; ?></td>
                        <td><?php echo $list["class"]; ?></td>
                        
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="remove" value="<?php echo $index; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>

                        <!-- Update Session -->
                        <form method="POST" action="">
                            <td style="background-color: gray"><input type="text" id="updated_name" name="updated_name" size="4" placeholder="Update Name" required></td>
                            <td style="background-color: gray"><input type="text" id="updated_email" name="updated_email" size="4" placeholder="Update Email" required></td>
                            <td style="background-color: gray">
                                <select class="form-select" id="updated_grade" name="updated_grade" aria-label="Default select example" required>
                                    <option selected>Update Grade</option>
                                    <option value="F">0 - 39</option>
                                    <option value="E">40 - 45</option>
                                    <option value="D">45 - 50</option>
                                    <option value="C">50 - 59</option>
                                    <option value="B">60 - 69</option>
                                    <option value="A">70 - 79</option>
                                    <option value="A+">80 - 100</option>
                                </select>
                            </td>
                            <td style="background-color: gray">
                                <input class="form-control" list="datalistOptions" name="updated_class" id="updated_class" size="4" placeholder="Type to search..." required>
                                <datalist id="datalistOptions">
                                    <option value="(React) Frontend Class">
                                    <option value="PHP Backend Class">
                                    <option value="DevOps Class">
                                    <option value="Software Engineering Class">
                                    <option value="Docker Class">
                                </datalist>
                            </td>

                            <td style="background-color: gray">
                            <input type="hidden" name="edit_index" value="<?php echo $index; ?>">
                            <button type="submit" class="btn btn-info">Update</button>
                            </td>
                        </form>
                        

                    </tr>
                <?php endforeach; ?>
            </tbody>

            <?php else : ?>
                <p style="color: white">No lists found.</p>
            <?php endif; ?>

        </table>
                
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    
</body>
</html>