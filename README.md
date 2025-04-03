# API Formatter Project

## Overview

This project is a PHP utility designed to handle API data format conversions. Specifically, it contains a class called `APIFormatter` which performs the following tasks:

- **Converts an API-specific input format to JSON**: The `convertAPIFormatToJson` method takes an input string (formatted in a custom API format) and converts it into a JSON object, properly handling "data" fields embedded within the API string.
  
- **Converts JSON data to API-specific string format**: The `convertJsonAPIDataToString` method takes a JSON input and converts it back to the API format, suitable for use in requests or for further processing.

- **Error Logging**: Any errors encountered during the conversion process are logged into an `error_log.txt` file for troubleshooting.

### Example Use Case

1. **Input (API format)**:
   ```
   country;id_campaign;email;firstname;surname;gender;BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__
   ```

2. **Output (JSON)**:
   ```json
   {
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
   }
   ```

## How to Run the Tests

### Prerequisites

1. **PHP**: Make sure PHP is installed on your system. You can check if PHP is installed by running:
   ```bash
   php -v
   ```

   If you don't have PHP installed, you can download it from [here](https://www.php.net/downloads.php).

2. **Project Files**: Ensure you have the following files in the same directory:
   - `convert_api.php` - Contains the `APIFormatter` class.
   - `test.php` - The test file that will run the test cases.

### Running the Tests

1. **Navigate to Your Project Directory**:
   Open a terminal and go to the directory where your project files (`convert_api.php`, `test.php`) are located:
   ```bash
   cd /path/to/your/project
   ```

2. **Run the Test Script**:
   Use PHP to run the `test.php` script. This will execute all the test cases defined in the script:
   ```bash
   php test.php
   ```

3. **Check the Output**:
   Once the test is complete, you should see the following in your terminal:
   - A summary of the input for each test case.
   - The output of the `convertAPIFormatToJson` function (the formatted JSON).
   - Any errors encountered will be logged in `error_log.txt`.

4. **Check `error_log.txt`**:
   If there are any errors during the test execution (e.g., mismatched fields and values), they will be logged in the `error_log.txt` file. You can check this file for error details. It will be automatically created in the same directory if it doesn’t exist.

### Example Output:
```bash
========== Test 1 - Standard Format ==========
Input:
country;id_campaign;email;firstname;surname;gender;BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__

Output (JSON):
Array
(
    [country] => au
    [id_campaign] => 1401
    [email] => __email__
    [firstname] => __firstname__
    [surname] => __lastname__
    [gender] => __gender__
    [BirthdateMonth] => __mob__
    [BirthdateYear] => __yob__
    [language] => en
    [subid] => 3474234
    [extrasubid] => __user_id__
)

========== Test 2 - Format with Data Fields ==========
Input:
country;id_campaign;data[email];data[firstname];data[surname];data[gender];BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__

Output (JSON):
Array
(
    [country] => au
    [id_campaign] => 1401
    [data] => Array
        (
            [email] => __email__
            [firstname] => __firstname__
            [surname] => __lastname__
            [gender] => __gender__
        )
    [BirthdateMonth] => __mob__
    [BirthdateYear] => __yob__
    [language] => en
    [subid] => 3474234
    [extrasubid] => __user_id__
)

========== Test 3 - Invalid Format (Mismatch) ==========
Input:
country;id_campaign;email;firstname##au;1401;__email__

Output (JSON):
Array
(
    [error] => Invalid API format. Field count does not match value count.
)
```

### Error Logging
- If any test case encounters an error (e.g., field count mismatch or invalid input), the error will be logged into a file named `error_log.txt`.
- This log will contain the date, time, and details of the error that occurred, allowing for easier debugging.
