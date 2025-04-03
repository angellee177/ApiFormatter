<?php

class APIFormatter {
    private $coreg_url;

    public function __construct($coreg_url) {
        $this->coreg_url = $coreg_url;
    }

    /**
     * Converts the API format string into a JSON object.
     *
     * This function processes the `$coreg_url` string by extracting field names and their corresponding values.
     * If the format includes nested fields (e.g., `data[email]`), they are grouped under a "data" key.
     *
     * Validation is performed to ensure the number of fields matches the number of values.
     * If a mismatch is detected, an error is logged and an error message is returned in JSON format.
     *
     * @return string JSON representation of the parsed API format.
     */
    public function convertAPIFormatToJson() {
        // Split the input into field names and values
        list($fields_list, $values_list) = explode('##', $this->coreg_url);
        $fields_array = explode(';', $fields_list);
        $values_array = explode(';', $values_list);

        // Validation: Check if field count matches value count
        if (count($fields_array) !== count($values_array)) {
            $this->logError("Mismatch between field count and value count in: " . $this->coreg_url);
            return json_encode(["error" => "Invalid API format. Field count does not match value count."]);
        }

        $data = [];
        foreach ($fields_array as $index => $field) {
            if (strpos($field, 'data[') === 0) {
                // Extract key inside 'data[]' and store in nested 'data' array
                $key = str_replace(['data[', ']'], '', $field);
                $data['data'][$key] = $values_array[$index];
            } else {
                $data[$field] = $values_array[$index];
            }
        }

        return json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * Converts a JSON object into a formatted string with field names and values separated by '##',
     * and returns the fields and values as an associative array.
     * 
     * @param string $json_input The JSON-encoded string to be converted.
     * @return array The associative array with combined fields and values or an empty array in case of an error.
     */
    public function convertJsonAPIDataToString($json_input) {
        // Decode the JSON string into an associative array
        $data = json_decode($json_input, true);

        // Check if the JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Log the error if the JSON is invalid
            $this->logError("Invalid JSON input: " . json_last_error_msg());
            return []; // Return an empty array in case of error
        }

        $fields = [];
        $values = [];

        // Iterate through the decoded data and separate fields and values
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Handle nested 'data' array
                foreach ($value as $sub_key => $sub_value) {
                    $fields[] = "data[$sub_key]";
                    $values[] = $sub_value;
                }
            } else {
                $fields[] = $key;
                $values[] = $value;
            }
        }

        // If the field count does not match the value count, log the error and return an empty array
        if (count($fields) !== count($values)) {
            $this->logError("Field count does not match value count in JSON input.");
            return []; // Return an empty array in case of error
        }

        // Combine fields and values into an associative array
        $post_fields_array = array_combine($fields, $values);

        // Format the output as requested
        $fields_string = implode(';', $fields);
        $values_string = implode(';', $values);
        $formatted_string = $fields_string . '##' . $values_string;

        // Optionally, you can return the formatted string if needed
        return $post_fields_array; // or return $formatted_string if you need the string format
    }

    /**
     * Logs error messages to a file.
     *
     * @param string $message The error message to log.
     * @return void
     */
    private function logError($message) {
        // Check if error_log.txt exists, if not, create it
        $log_file = 'error_log.txt';
        $log_message = date('Y-m-d H:i:s') . " - " . $message . PHP_EOL;

        // Append the log message to the file
        file_put_contents($log_file, $log_message, FILE_APPEND);
    }

}
?>
