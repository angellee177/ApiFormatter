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
function runTest($test_name, $input, $function_name = 'convertAPIFormatToJson') {
    $formatter = new APIFormatter($input);
    
    // Check which function to call
    if ($function_name == 'convertAPIFormatToJson') {
        $json_output = $formatter->convertAPIFormatToJson();
        echo "========== $test_name (convertAPIFormatToJson) ==========\n";
        echo "Input:\n$input\n\n";
        echo "Output (JSON):\n";
        print_r(json_decode($json_output, true)); // Decode JSON for better readability
        echo "\n\n";
    } else if ($function_name == 'convertJsonAPIDataToString') {
        $string_output = $formatter->convertJsonAPIDataToString($input);
        echo "========== $test_name (convertJsonAPIDataToString) ==========\n";
        echo "Input (JSON):\n$input\n\n";
        echo "Output (String):\n";
        print_r($string_output); // Display the array or string from the function
        echo "\n\n";
    }
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

// Test case 4: Format with nested key fields
$coreg_url_4 = "country;id_campaign;data[email];data[firstname];data[surname];data[gender];BirthDate[BirthdateMonth];BirthDate[BirthdateYear];language;subid;extrasubid##au;1401;user549@example.com;Emma;Johnson;female;8;2002;de;653156;704485";
runTest("Test 4 - Random string format", $coreg_url_4);

// Test case 5: JSON format input for convertJsonAPIDataToString
$json_input_1 = '{
    "country": "au",
    "id_campaign": 1401,
    "data": {
        "email": "__email__",
        "firstname": "__firstname__",
        "surname": "__lastname__",
        "gender": "__gender__"
    },
    "BirthdateMonth": "__mob__",
    "BirthdateYear": "__yob__",
    "language": "en",
    "subid": 3474234,
    "extrasubid": "__user_id__"
}';
runTest("Test 5 - Convert JSON to String (Format 1)", $json_input_1, 'convertJsonAPIDataToString');

// Test case 6: JSON format input for convertJsonAPIDataToString (no nested 'data' field)
$json_input_2 = '{
    "country": "au",
    "id_campaign": 1401,
    "email": "__email__",
    "firstname": "__firstname__",
    "surname": "__lastname__",
    "gender": "__gender__",
    "BirthdateMonth": "__mob__",
    "BirthdateYear": "__yob__",
    "language": "en",
    "subid": 3474234,
    "extrasubid": "__user_id__"
}';
runTest("Test 6 - Convert JSON to String (Format 2)", $json_input_2, 'convertJsonAPIDataToString');

// Test case 7: Invalid JSON format
$json_input_invalid = '{"country": "au", "id_campaign": 1401,';
runTest("Test 7 - Invalid JSON Format", $json_input_invalid, 'convertJsonAPIDataToString');

// Test case 8: Invalid JSON format
$json_input_invalid_2 = '{
    "country": "au",
    "id_campaign": 1401,
    "data": {
        "email": "__email__",
        "firstname": "__firstname__",
        "surname": "__lastname__",
        "gender": "__gender__"
    },
    "BirthDate": {
    "BirthdateMonth": "__mob__",
    "BirthdateYear": "__yob__"
    },
    "language": "en",
    "subid": 3474234,
    "extrasubid": "__user_id__"
}';
runTest("Test 8 -- Invalid JSON Format", $json_input_invalid_2, 'convertJsonAPIDataToString');
?>
