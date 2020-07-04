<?php
require "resultpage.html";
// Connect to the SQL database
$dbConnection = new PDO('mysql:host=127.0.0.1;dbname=seniorsem', 'root', '');

$searchPage = "searchpage.html";

// we use $_GET[] to retrieve the search query from the HTML form.
$search = cleanUp($_GET['q']);

// removes any white space around the search term
// this leads to more accurate search results if
// someone were to accidently hit space before searching

$search = ltrim($search, " ");
$search = rtrim($search, " ");

// Stops the entire database from being displayed by
// entering a single space and hitting search.
// If a user were to enter potentially malicous characters (//, <!--, etc.)
// the cleanUp() method would strip them and return an empty string
// we use the empty() method to stop the database from being displayed
// if the search button is pressed without input.
if ($search == " " || empty($search)) {
    echo "That is not a valid term.";
    echo "<a href=$searchPage>Click here to try again.</a>";
} else {
    // returns php object of our search query
    $results = $dbConnection->query("SELECT * FROM `websiteindex` WHERE title LIKE '%$search%'");

    // counts the number of results that appeared
    // this is done so that everytime there is a search result
    // that is not out dated, the count is incremented.

    $numResults = 0;
    echo "Here is what we found for the term '" . $search . "'<br>";
    echo "<a href=$searchPage>Home Page</a>";
    echo "<hr />";

    // for each result that was queried
    // fetchAll(), returns an array of all the rows that
    // our query returned, returns all rows that match
    // the query.
    foreach ($results->fetchAll() as $result) {
        $title        = cleanUp($result["title"]);
        $description  = cleanUp($result["description"]);
        $url          = $result["url"];
        $concertdate1 = extractDate($title);
        $concertdate2 = date("d M Y", strtotime($concertdate1));
        $todayformat1 = date("M d Y");
        $todayformat2 = date("d M Y");

        // Ensures that the dates that will be displayed will take place either
        // today or on a future date.
        if (strtotime($concertdate2) >= strtotime($todayformat2) || strtotime($concertdate1) >= strtotime($todayformat1)) {
            if ($description == "") {
                echo boldSearchTerm($search, $title)."<br />";
								echo "No Description.<br />";
            } else {
                if (stripos($description, $search) == true || stripos($title, $search) == true) {
                    echo boldSearchTerm($search, $title)."<br />";
                    echo boldSearchTerm($search, $description)."<br />";
                }
            }

            // creates a hyperlink of the URL
            $numResults++;
            echo "<a href='" . $url . "' target='_blank'>" . $url . "</a>";
            echo "<hr />";
        }
    }
    echo "Found: ".$numResults." results.";
}

function cleanUp($result)
{
    // cleanUp method to remove any odd cahracters that could crash the program.
    return preg_replace("/[^A-Za-z0-9]+/i", ' ', $result);
}

function extractDate($info)
{
    // extractDate() method to determine the date of the concert,
    // this usese regular expressions to extract the date from the $title or $description strings
    preg_match_all('/(\b\d{1,2}\D{0,3})?\b((Jan)|(Feb)|(Mar)|(Apr)|(May)|(Jun)|(Jul)|(Aug)|(Sep)|(Oct)|(Nov)|(Dec))\D?(\d{1,2}\D?)?\D?((19[7-9]\d|20\d{2})|\d{2})/', $info, $newDate);
    // preg_match_all() returns an array of mathced strings,
    // we must use implode() so that a string version of the
    // element in the array can be used.
    return implode($newDate[0]);
}

function boldSearchTerm($term, $string)
{
    // Simple method to bold the search term in search results.
    return str_ireplace($term, '<b>' . $term . '</b>', $string);
}
?>
