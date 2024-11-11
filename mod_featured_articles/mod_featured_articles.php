<?php
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

// Get parameters
$numFtArticles = $params->get('No_of_featured_Articles');
$categoryIds = $params->get('categories');
$sortingOrder = $params->get('sorting_order');
$introText = $params->get('intro_text');

// print_r($images);die();
// Proceed if articles are specified
if ($numFtArticles != 0 && !empty($categoryIds)) {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Prepare category IDs
    $categoryIds = implode(',', array_map("intval", $categoryIds));

    // Select required fields
    $query->select($db->quoteName(['id', 'title', 'introtext', 'created','images']))
          ->from($db->quoteName('#__content'))
          ->where('catid IN (' . $categoryIds . ')')
          ->where($db->quoteName('featured') . ' = 1');

    // Apply sorting order
    if ($sortingOrder == 1) {
        $query->order('created DESC');
    } elseif ($sortingOrder == 2) {
        $query->order('created ASC');
    } else {
        $query->order('title ASC');
    }

    // Limit number of articles
    $query->setLimit($numFtArticles);

    // Execute query
    $db->setQuery($query);
    $articles = $db->loadObjectList();
    // echo '<pre>';
    // print_r($articles);
    // echo '</pre>';
    // die();
    
    // echo $articles->title;die();
} else {
    $articles = [];
}

// Load the layout and pass the articles
require JModuleHelper::getLayoutPath('mod_featured_articles');
