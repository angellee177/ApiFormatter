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
     * Logs an error message to a file.
     *
     * This function appends the given error message to `error_log.txt`,
     * including a timestamp for easier debugging.
     *
     * @param string $message The error message to log.
     *
     * @return void
     */
    private function logError($message) {
        // Log the error to a file
        file_put_contents('error_log.txt', date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
    }
}
?>
