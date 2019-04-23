<?php
/**
 * Created by PhpStorm.
 * User: nickscrivani
 * Date: 2019-03-19
 * Time: 21:53
 */

include ('database.php');

if (isset($_POST["from_date"], $_POST["to_date"], $_POST["table"] ));
{

    $table = $_POST["table"] ;
    //error_log("HI IM TABLE NAME" . $table);
    $output = '';
    $query = "SELECT * FROM readings WHERE date between '".$_POST["from_date"]."'AND'".$_POST["to_date"]."'";
    $result = mysqli_query($conn, $query);
    $output .= '<table class="table table-bordered">
                    <tr>
                        <th>' . $table . '</th>
                        <th>Date</th>
                    </tr>';
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result))
        {
            $output .= '
                <tr>
                    <td>'.number_format($row[$table], 2).'</td>
                    <td>' .date('F dS Y , g : i A', strtotime($row["date"])). '</td>
                </tr>
                    ';
        }
    }else{
        $output .= '
            <tr>
                <td colspan="5">No results</td>
            </tr>
            ';
    }
    $output .= '</table>';
    echo $output;
}
?>