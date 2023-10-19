<?php
$page_title = "Report Issue";
require "./header.php";

?>

<link rel="stylesheet" href="https://oah-linkapp.000webhostapp.com/style/report.css">
<body>
    <div class="container">
        <div>
            <p id="exit">×</p>
        </div>
        <form method="post" autocomplete="on" enctype="multipart/form-data" id="reportForm">
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="issue">Issue:</label>
                <textarea class="form-control" name="issue" id="issue" cols="30" rows="10" maxlength="600000" required></textarea>
            </div>
            <div>
                <button id="submitBtn" class="btn btn-dark btn-lg" type="submit">Submit</button>
            </div>
            <div id="error-response" style="display: none; margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-danger" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div></div>
            </div>
            <div id="success-response" style="display: none; margin-top: 9px; padding: 6px; font-size: 15px; align-items:center;" class="alert alert-success" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="18" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div></div>
            </div>
        </form>
    </div>
    <footer>
        &copy; Linkapp <?php echo date("Y")?>
    </footer>
</body>
<script src="./js/report-issue.js"></script>