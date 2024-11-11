<?php
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

// Assuming $userdata is the result of your query and contains the data for the users
if (!empty($userdata)) {
    // Table structure and styling
    echo '<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
        }
    </style>';

    echo '<div class="table-container">'; // Container to make table horizontally scrollable on small screens
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    
    // Display table headers based on the Yes/No settings from the backend
    if ($params->get('display_name', false)) {
        echo '<th>Name</th>';
    }
    if ($params->get('display_username', false)) {
        echo '<th>Username</th>';
    }
    if ($params->get('display_email', false)) {
        echo '<th>Email</th>';
    }
    if ($params->get('display_registration_date', false)) {
        echo '<th>Registration Date</th>';
    }
    if ($params->get('display_last_login', false)) {
        echo '<th>Last Login</th>';
    }
    if ($params->get('display_user_group', false)) {
        echo '<th>User Group</th>';
    }

    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Loop through the userdata array and display each user's data
    foreach ($userdata as $user) {
        echo '<tr>';

        // Display the user data in table rows based on the Yes/No settings
        if ($params->get('display_name', false)) {
            echo '<td>' . $user->name . '</td>';
        }
        if ($params->get('display_username', false)) {
            echo '<td>' . $user->username . '</td>';
        }
        if ($params->get('display_email', false)) {
            echo '<td>' . $user->email . '</td>';
        }
        if ($params->get('display_registration_date', false)) {
            echo '<td>' . JHtml::_('date', $user->registerDate, 'd-m-Y') . '</td>';
        }
        if ($params->get('display_last_login', false)) {
            echo '<td>' . JHtml::_('date', $user->lastvisitDate, 'd-m-Y') . '</td>';
        }
        if ($params->get('display_user_group', false)) {
            echo '<td>' . $user->title . '</td>';
        }

        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>'; // End of table container
} else {
    echo 'No data found.';
}
?>
