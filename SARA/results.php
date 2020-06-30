<?php
    $file = file_get_contents($_FILES["fileupload"]["tmp_name"]);
    $html = "<input type='checkbox' id='selectAll'>
            <label for='selectAll'>Select All</label>";
    $html .= "<select id='Style'>
                <option value = 'JSON'>JSON</option>
                <option value = 'CSV'>CSV</option>
               <option value = 'XML'>XML</option>
             </select>";
    $html .= "<ol>";

            if($_FILES["fileupload"]["type"] == "application/json") {$html .= parseJSON($file);} 
            else if($_FILES["fileupload"]["type"] == "text/csv") {$html .= parseCSV($file);} 
            else if($_FILES["fileupload"]["type"] == "text/xml") {$html .= parseXML($file);} 
            else {echo $_FILES["fileupload"]["type"] . " does not have a valid filetype";}

            $html .= "</ol>";
        
    echo $html; 
    echo "
    <script>
        var allBox = document.getElementById('selectAll');
        allBox.onclick = function() {
            var checkBox = document.getElementsByClassName('resultBox');
            for(var i = 0; i < checkBox.length; ++i) {
                checkBox[i].checked = allBox.checked;
            }
        };
     
    </script>";
    
    function parseJSON($file) {
        $jsonR;
        $results = json_decode($fileContents)->Result;
        for($i = 0; $i < count($results); ++$i) {
            $jsonR .= "<li class='search_result_list_item' id='result" . $i . "'>";
            $jsonR .= $results[$i]->title . "<br><br>";
            $jsonR .=  $results[$i]->url . "<br><br>";
            $jsonR .=   $results[$i]->description . "<input class='resultBox' type='checkbox' id='checkbox" . $i . "'>";
            $jsonR .= "</li>";
        }
        return $jsonR;
    }

    function parseCSV($file) {
        $csvR;
        $csvS = explode('\n', $file);
        for($i = 0; $i < count($csvS); ++$i) {
            $mycsv = str_getcsv($csvS[$i]);
            $csvR .= "<li class='search_result_list_item' id='result" . $i . "'>";
            $csvR .=  $mycsv[0] . "<br><br>";
            $csvR .=  $mycsv[1] . "<br><br>";
            $csvR .=  $mycsv[2] . "<input class='resultBox'  type='checkbox' id='checkbox" . $i . "'>";
            $csvR .= "</li>";
        }
        return $csvR;
    }

    function parseXML($file) {
        $results = simplexml_load_string($file);
        $xmlR;
        for($i = 0; $i < count($results->result); ++$i) {
            $xmlR .= "<li class='search_result_list_item' id='result" . $i . "'>";
            $xmlR .= $results->result[$i]->title . "<br><br>";
            $xmlR .=  $results->result[$i]->url . "<br><br>";
            $xmlR .=  $results->result[$i]->description . "<input class='resultBox' type='checkbox' id='checkbox" . $i . "'>";
            $xmlR .= "</li>";
        }
        return $xmlR;
    }
?>