<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class QueryLogHook {

    private $CI;
    private $db;

    function log_queries() {   
        $CI = & get_instance();
        $times = $CI->db->query_times;
        $dbs    = array();
        $output = NULL;    
        $queries = $CI->db->queries;

        if (count($queries) == 0) {
            $output .= "no queries\n\n";
        } else {
            foreach ($queries as $key=>$query) {
                $output .= $query . "\n\n";
            }
            $took = round(doubleval($times[$key]), 3);
            $output .= "===[took:{$took}]\n\n";
        }

        $CI->load->helper('file');
        if (!write_file(APPPATH  . '/logs/queries_log-' . date('Y-m-d') . '.txt', $output, 'a+')) {
             log_message('debug','Unable to write query the file');
        }
    }
}
//EOC