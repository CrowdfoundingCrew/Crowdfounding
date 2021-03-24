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
            $result = $result . "<div class='row'>
            <div class='col-md-12'>
                <h3>
                    $nomeonlus
                </h3>
                <p>
                    $descrizioneonlus
                </p>
                <p>
                    <a class='btn' href='$paginaonlus'>View details »</a>
                </p>
            </div>
            </div>". 
            "<div class='row'>";
            foreach($row[20] as $progetto){
                $result = $result .
                    "<div class='col-md-4'>
                        <img alt='Bootstrap Image Preview' src='$immagineprogetto'>
                        <div class='progress mt-2'>
                            <div class='progress-bar progress-bar-animated progress-bar-striped bg-$coloreprogetto' style='width: $barprogetto%'>
                        </div>
                        <address><strong>$nomeprogetto</strong><br>$datiprogetto </address>
                        <blockquote class='blockquote'>
                            <p class='mb-0'>$descrizioneprogetto</p>
                        </blockquote>
                    </div>".
                "</div>";
            }
            $result = $result . "</div>";
        }
        //chiudi la connessione
        return $result;
}

?>