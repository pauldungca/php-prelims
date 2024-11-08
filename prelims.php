<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll System</title>
</head>
<body>

<h1>Payroll System</h1>
<hr>

<?php
    if (!isset($_POST['NextButton1']) && !isset($_POST['NextButton2'])) {
?>

    <form name="landingForm" method="post">
        <label for="txtFirstName">First Name:</label>
        <input type="text" name="txtFirstName" id="txtFirstName" autofocus required><br><br>
        <label for="txtLastName">Last Name:</label>
        <input type="text" name="txtLastName" id="txtLastName" required><br><br>
        <label>Sex</label><br>
        <input type="radio" name="radSex" id="radMale" value="Male" checked>
        <label for="radMale">Male</label>
        <input type="radio" name="radSex" id="radFemale" value="Female">
        <label for="radFemale">Female</label><br><br> 
        <label for="designation">Select Designation</label>
        <select name="designation">
            <option value="Crew" selected>Crew</option>
            <option value="Manager">Manager</option>
            <option value="Supervisor">Supervisor</option> 
        </select><br><br>
        <label for="type">Select Type</label>
        <select name="type">
            <option value="Regular" selected>Regular</option>
            <option value="Probationary">Probationary</option>
        </select><br><br>
        <button type="submit" name="NextButton1">Next</button>
    </form>

<?php
    } elseif (isset($_POST['NextButton1']) && !isset($_POST['NextButton2'])) {
        
        $fname = $_POST['txtFirstName'];
        $lname = $_POST['txtLastName'];
        $fullName = $fname . " " . $lname;
        $greet = $_POST['radSex'];
        $designation = $_POST['designation'];
        $type = $_POST['type']; 

        // For greetings
        $m = ($greet == 'Male') ? 'Mr.' : 'Ms.';

        // For Rate
        $rate = match ($designation) {
            'Crew' => 80,
            'Manager' => 200,
            'Supervisor' => 120,
        };
?>

    <form name="secondForm" method="post">
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <input type="hidden" name="rate" value="<?php echo $rate; ?>">
        <input type="hidden" name="m" value="<?php echo $m; ?>">
        <input type="hidden" name="fullName" value="<?php echo $fullName; ?>">
        <label>Hi, <?php echo $m . " " . $fullName ?></label><br>
        <label>Your rate is: ₱ <?php echo $rate ?></label><br><br>
        <label for="hoursWork">Hours of Work: </label>
        <input type="number" name="hoursWork" id="hoursWork" autofocus required min="0"><br><br>
        <label for="cashAdv">Cash Advance: </label>
        <input type="number" name="cashAdv" id="cashAdv" autofocus required min="0" value="0"><br><br>
        <button type="submit" name="NextButton2">Next</button>
    </form>

<?php

    } elseif (isset($_POST['NextButton2'])) {
        $type = $_POST['type'];
        $rate = $_POST['rate'];
        $m = $_POST['m'];
        $fullName = $_POST['fullName'];
        $hoursWork = $_POST['hoursWork'];
        $cashAdv = $_POST['cashAdv'];
        
        if ($type === 'Regular') {  
            $temporary = $hoursWork * $rate;
            $sssDeduction = $temporary * 0.10; 
            $taxDeduction = $temporary * 0.1212; 
            $pagIbigDeduction = 100; 
            $cashAdvDeduction = $cashAdv; 
            $totalDeductions = $sssDeduction + $taxDeduction + $pagIbigDeduction + $cashAdvDeduction;
            $netSalary = $temporary - $totalDeductions;

    ?>
    <form method="post" name="RegularForm">
        <label>Hi, <?php echo $m . " " . $fullName ?></label><br>
        <label>Deductions:</label><br>
        <label>SSS: ₱ <?php echo number_format($sssDeduction, 2) ?></label><br>
        <label>TAX: ₱ <?php echo number_format($taxDeduction, 2) ?></label><br>
        <label>PAG-IBIG: ₱ <?php echo number_format($pagIbigDeduction, 2) ?></label><br>
        <label>Cash-Advance: ₱ <?php echo number_format($cashAdvDeduction, 2) ?></label><br>
        <label>Total Deductions: ₱ <?php echo number_format($totalDeductions, 2) ?></label><br>
        <label>Net Pay: ₱ <?php echo number_format($netSalary, 2) ?></label><br><br>
        <button type="submit" name="reset">Reset</button>
    </form>
            
    <?php
        } elseif ($type === 'Probationary') {
            $temporary = $hoursWork * $rate; 
            $cashAdvDeduction = $cashAdv; 
            $netSalary = $temporary - $cashAdvDeduction;
    ?>

    <form method="post" name="ProbitionaryForm">
        <label>Hi, <?php echo $m . " " . $fullName ?></label><br>
        <label>Cash Advance: ₱ <?php echo $cashAdvDeduction ?></label><br>
        <label>Net Pay: ₱ <?php echo $netSalary ?></label><br>
        <button type="submit" name="reset">Reset</button>
    </form>
                     
<?php
        }
    }
?>







    
</body>
</html>