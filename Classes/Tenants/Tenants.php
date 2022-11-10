<?php

require_once '../../../../Config/DB.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Tenants
{
    public function __construct() {}

    /**
     * Get tenants
     * @param array $_ids
     * @param array $_cols
     * @param Int $_limit
     * @return false[]
     */
    public function get_tenants(Array $_ids, Array $_cols, Int $_limit): Array {
        global $conn;

        $res = array(
            'tenants' => []
        );

        // Convert ids from array to string
        $query_ids = '';
        if (!empty($_ids)) {
            $ids_str = implode(',', $_ids); // Example: 1,2,3
            $query_ids = " AND id in ($ids_str)";
        }

        // Convert cols from array to string
        $cols_str = '*';
        if (!empty($_cols)) {
            $cols_str = implode(',', $_cols); // Example: 'id','username'
        }

        // Set limit
        $limit = '';
        if ($_limit > 1) {
            $limit = " LIMIT $_limit";
        }

        $query = "SELECT $cols_str FROM tenants WHERE 1 $query_ids $limit";
        $stmt = $conn->prepare($query);
        //echo $conn->error;
        $stmt->execute();
        $result = $stmt->get_result();

        // Rows found
        if ($result->num_rows) {
            $res['tenants'] = $result->fetch_all(MYSQLI_ASSOC);
        }

        return $res;
    }
}
