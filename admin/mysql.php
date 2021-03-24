<?php
function Pagination($no_of_records_per_page, $offset){
        return "";
        $total_pages_sql = "SELECT COUNT(*) FROM table";
        $res1= "query1";
        $total_rows = mysqli_fetch_array($res1)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);


        $sql = "SELECT * FROM table LIMIT $offset, $no_of_records_per_page";
        $res_data = "query2";
        $result="";
        while($row = mysqli_fetch_array($res_data)){
            $result = $result."";
        }
        //chiudi la connessione
        return $result;
}
?>