<?php
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$usergrpids = $params->get('title'); // Assuming this is an array of user group IDs

// Check if $usergrpids is not empty before proceeding
if (!empty($usergrpids)) {
    // Get the database object
    $db = JFactory::getDbo();

    // Build the query
    $query = $db->getQuery(true);
    

    $usergrpids = implode(',',array_map('intval',$usergrpids)); // Convert array to comma-separated string of integers

    $query->select($db->quoteName(['user_id']))
          ->from($db->quoteName('#__user_usergroup_map'))
          ->where('group_id IN (' . $usergrpids . ')'); // Use IN with the list of user group IDs

    // Execute the query
    $db->setQuery($query);
    $result = $db->loadObjectList(); // Fetch the result as an array of objects


       // Check if result is not empty
       if (!empty($result)) {
        // Collect all user_ids from the result
        $user_ids = array();
        foreach ($result as $row) {
            $user_ids[] = $row->user_id; // Add user_id to the array
        }

        // Now, use these user_ids to fetch data from another table
        if (!empty($user_ids)) {
            // Convert the user_ids array to a comma-separated string
            $user_ids_str = implode(',', array_map('intval', $user_ids));

      
            $query = $db->getQuery(true);

            //  joins used for accessing grp_id 
            //  flow-:user_id->grp_id->grp_name
            $query->select($db->quoteName([
                'u.id', 
                'u.name', 
                'u.username', 
                'u.email', 
                'u.registerDate', 
                'u.lastvisitDate', 
                'ug.group_id',
                'g.title' 
            ]))
          ->from($db->quoteName('#__users', 'u')) 
          ->innerJoin($db->quoteName('#__user_usergroup_map', 'ug') . ' ON ' . $db->quoteName('u.id') . ' = ' . $db->quoteName('ug.user_id')) 
          ->innerJoin($db->quoteName('#__usergroups', 'g') . ' ON ' . $db->quoteName('ug.group_id') . ' = ' . $db->quoteName('g.id')) // Second join to get the group title
          ->where('u.id IN (' . $user_ids_str . ')');

            // Execute the query
            $db->setQuery($query);

            $userdata = $db->loadObjectList(); // Fetch the result
            // print_r($userdata);die();
        }
    } else {
        echo 'No users found for the given user groups.';
    }

} else {
    echo "No user groups selected.";
}





require JModuleHelper::getLayoutPath('mod_user_list');

?>
