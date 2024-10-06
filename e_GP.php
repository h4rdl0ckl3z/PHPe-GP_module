<?php
$base_url = 'http://process3.gprocurement.go.th/EPROCRssFeedWeb/egpannouncerss.xml';

$myData = [];

function e_GP($dept_ids) {
    $anounce_types = ['W0', 'W2', 'B0', 'D0', 'D1', 'D2', 'P0', 'W1', '15'];
    global $myData;

    // Filter out empty department IDs before looping
    $dept_ids = array_filter($dept_ids);

    foreach ($anounce_types as $anounce_type) {
        foreach ($dept_ids as $dept_id) {
            fetchData($dept_id, $anounce_type);
        }
    }

    return json_encode($myData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function fetchData($dept_id, $anounce_type) {
    global $base_url, $myData;

    $url = "{$base_url}?deptId={$dept_id}&anounceType={$anounce_type}";

    try {
        // Use @ to suppress any warnings from file_get_contents
        $xml_content = @file_get_contents($url);
        if (!$xml_content) {
            throw new Exception("Failed to retrieve data from URL: {$url}");
        }

        // Handle XML parsing with error suppression
        $xml = @simplexml_load_string($xml_content, 'SimpleXMLElement', LIBXML_NOERROR);

        if (!$xml) {
            throw new Exception("Failed to parse XML for URL: {$url}");
        }

        foreach ($xml->channel->item as $item) {
            $list_data = [];

            // Use a loop to filter tags and build the list_data array
            foreach ($item as $key => $value) {
                if ($key !== 'description' && $key !== 'guid') {
                    $list_data[$key] = (string) $value;
                }
            }

            // Add announceType and egpid to the list_data
            $list_data['anounceType'] = $anounce_type;
            $list_data['egpid'] = $dept_id;

            $myData[] = $list_data;
        }
    } catch (Exception $e) {
        error_log("Error fetching data for dept_id {$dept_id} and anounce_type {$anounce_type}: " . $e->getMessage());
    }
}
?>