<?php
require_once 'convert_api.php';

/**
 * Runs a test case for the APIFormatter class.
 *
 * This function initializes an `APIFormatter` instance with the given input,
 * converts the API format to JSON, and prints the input along with the formatted output.
 *
 * @param string $test_name A descriptive name for the test case.
 * @param string $input The input API format string to be tested.
 *
 * @return void
 */
function runTest($test_name, $input) {
    $formatter = new APIFormatter($input);
    $json_output = $formatter->convertAPIFormatToJson();
    
    echo "========== $test_name ==========\n";
    echo "Input:\n$input\n\n";
    echo "Output:\n";
    print_r(json_decode($json_output, true)); // Decode JSON for better readability
    echo "\n\n";
}


// Test case 1: Standard format
$coreg_url_1 = "country;id_campaign;email;firstname;surname;gender;BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__";
runTest("Test 1 - Standard Format", $coreg_url_1);

// Test case 2: Format with 'data' fields
$coreg_url_2 = "country;id_campaign;data[email];data[firstname];data[surname];data[gender];BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__";
runTest("Test 2 - Format with Data Fields", $coreg_url_2);

// Test case 3: Invalid format (mismatched fields/values)
$coreg_url_3 = "country;id_campaign;email;firstname##au;1401;__email__";
runTest("Test 3 - Invalid Format (Mismatch)", $coreg_url_3);

?>
