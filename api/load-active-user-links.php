<?php

require "../controller/config.php";
session_start();
$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_SESSION["uid"])) {
        $uid = $_SESSION["uid"];

        // Check if the user exists in the 'linkrs' table
        $check_uid = DB::query("SELECT id FROM linkrs WHERE id = :uid", array(":uid" => $uid));

        // Check if user is found
        if ($check_uid) {
            // Fetch user-specific links from the 'links' table
            $user_data = DB::query("SELECT link_id, link_title, link_address FROM links WHERE user_id = :uid ORDER BY date_created DESC", array(":uid" => $uid));

            if ($user_data) {
                // Build the HTML for user links
                $links = "";
                foreach ($user_data as $value) {
                    $links .= "
                    <li class='link' id='" . htmlspecialchars($value["link_id"]) . "'>
                        <div id='inner-container'>
                            <span onclick=edit_link('" . htmlspecialchars($value["link_id"]) . "')><img id='editBtn' src='../img/edit-icon.svg'></span>
                            <a href='" . htmlspecialchars($value["link_address"]) . "'><p>" . htmlspecialchars($value["link_title"]) . "</p></a>
                            <span id='deleteBtn' onclick=delete_link('" . htmlspecialchars($value["link_id"]) . "')><img id='editBtn' src='../img/delete-icon.png'></span>
                        </div>
                    </li>
                    ";
                }

                // Respond with status and links HTML
                $response["status"] = true;
                $response["body"] = $links;
            } else {
                $response["status"] = false;
                $response["body"] = "No links found for this user";
            }
        } else {
            $response["status"] = false;
            $response["body"] = "User not found";
        }
    } else {
        $response["status"] = false;
        $response["body"] = "User ID missing in session";
    }
} else {
    $response["status"] = false;
    $response["body"] = "Invalid request method. Expected GET.";
}

// Return the response as JSON
echo json_encode($response);
?>
