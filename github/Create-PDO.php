<?php
// Include config file
require_once "Config-PDO.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $date_of_birth = $category = $product ="";
$firstname_err = $lastname_err = $date_of_birth_err = $category_err = $product_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate firstname
    $input_firstname = trim($_POST["firstname"]);
    if(empty($input_firstname)){
        $firstname_err = "Please enter a firstname.";
    } elseif(!filter_var($input_firstname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $firstname_err = "Please enter a valid firstname.";
    } else{
        $firstname = $input_firstname;
    }

    // Validate lastname
    $input_lastname = trim($_POST["lastname"]);
    if(empty($input_lastname)){
        $lastname_err = "Please enter a lastname.";
    } elseif(!filter_var($input_lastname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lastname_err = "Please enter a valid lastname.";
    } else{
        $lastname = $input_lastname;
    }

    //Assign date
    $date_of_birth = trim($_POST["date_of_birth"]);

    // Validate category
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        $category_err = "Please enter a category.";
    } elseif(!filter_var($input_category, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $category_err = "Please enter a valid category.";
    } else{
        $category = $input_category;
    }

    // Validate product
    $input_product = trim($_POST["product"]);
    if(empty($input_product)){
        $product_err = "Please enter a product.";
    } elseif(!filter_var($input_product, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $product_err = "Please enter a valid product.";
    } else{
        $product = $input_product;
    }
    
    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err) && empty($date_of_birth_err) && empty($product_err) && empty($category_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO dbleads (firstName, lastname, date_of_birth, category, product) VALUES (firstname, lastname, date_of_birth, category, product)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":firstname", $param_firstname);
            $stmt->bindParam(":lastname", $param_lastname);
            $stmt->bindParam(":date_of_birth", $param_Dob);
            $stmt->bindParam(":category", $param_category);
            $stmt->bindParam(":product", $param_product);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_Dob = $date_of_birth;
            $param_category=$category;
            $param_product=$product;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: Landing-PDO.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        body{
            background-color: #cccccc;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add Customers record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                            <label>firstName</label>
                            <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                            <span class="help-block"><?php echo $firstname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                            <label>lastname</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                            <span class="help-block"><?php echo $lastname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($date_of_birth_err)) ? 'has-error' : ''; ?>">
                            <label>Date of birth</label>
                            <input type="date" name="date_of_birth" class="form-control" value="<?php echo $date_of_birth; ?>">
                            <span class="help-block"><?php echo $date_of_birth_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control" value="<?php echo $category; ?>">
                            <span class="help-block"><?php echo $category_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($product_err)) ? 'has-error' : ''; ?>">
                            <label>product</label>
                            <input type="text" name="product" class="form-control" value="<?php echo $product; ?>">
                            <span class="help-block"><?php echo $product_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="Landing-PDO.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>