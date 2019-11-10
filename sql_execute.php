<!-- Link CSS -->
<style><?php include_once("style.css") ?></style>

<?php
//Database connection function
function getDBC($ip, $user, $pass, $db){
    $dbc = new MySQLi($ip, $user, $pass, $db);
    return $dbc;
}

//Sticky form function
function issetValues($input, $default){
    if($input != "sql_query"){
        if(isset($_REQUEST[$input])) 
            echo "value=".$_REQUEST[$input];
        else echo "value=$default";
    }else{
       if(isset($_REQUEST['sql_query'])) 
        echo $_REQUEST['sql_query'];
        else echo $default;
    }
}

//Reset function
function reset_form(){
    if(isset($_REQUEST['reset']))
    header("Location: sql_execute.php");
}

//Declare values
    $uname ="root";
    $pword = "";
    $ip_add = "127.0.0.1";
    $dbase = "cis495";
    $query = "";

//Form input validation
if(isset($_GET["submit"])){
        $uname = $_GET["username"];
        $pword = $_GET["password"];
        $ip_add = $_GET["ip_address"];
        $dbase = $_GET["database"];
        $query = $_GET["sql_query"];
    
    $required = 
            array('<span>Error: Missing username.</span><br>' => $uname, 
                '<span>Error: Missing IP Address.</span><br>' => $ip_add, 
                ' <span>Error: You must choose a database</span><br>'=>$dbase,
                ' <span>Error: SQL Query must not be empty</span><br>'=>$query);

    //Output appropriate error for required missing value
    $missing_info = false;
    foreach($required as $error => $value){
        if($value == null || empty($value)){
            $missing_info = true;
            echo $error;    
        }
    }

    //Connect to database is validation is successful
    if(!$missing_info){
        error_reporting(0);
        $dbc = getDBC($ip_add, $uname,$pword, $dbase);
        $result = false;

    //Show appropriate error message for connection/database errors
        if($dbc -> connect_errno)
          echo "<div class=message>Error: connection to database <br>". $dbc->connect_error . "</div>";
        else if($dbc != null){
            $result = $dbc->query($query);
            if(!$result)
                echo "<div class=message>Error: Query execution failed <br>" . $dbc->error . "</div>";
            
            //if query returned no results and is unsuccessful
            else if ($result->num_rows == 0){
                if($dbc->affected_rows == 0)
                echo "<div class=message>Query returned no result" . $dbc->error . "</div>";
            
            //if query is successful but returns no results
                else{
                    echo "<div class='message success'>Connection Successful! <br>
                    Number of rows affected: $dbc->affected_rows</div>";
                }

            } 
            //If connection and database is successfull, output result 
            else {
                echo "<div class='message success'>Connection Successful! <br>
                    Number of rows affected: $result->num_rows</div>";
            
                //close database and connection
                $result->close();
                $dbc->close();
            }
        }
    }
}
            
?>
<!-- HTML -->
<div class=container>
<form action="sql_execute.php" method="GET">
<table cellpadding=5>
   <tr>
        <td class=col1>Username: </td>
        <td class=col2><input type=text name=username size=30 
<?php issetValues('username', $uname)?>></td>
   </tr>
   <tr>
        <td class=col1>Password: </td>
        <td class=col2><input type=text name=password size=30 
        <?php issetValues('password', $pword)?>></td>
   </tr>
   <tr>
        <td class=col1>IP Address: </td>
        <td class=col2><input type=text name=ip_address size=30 
        <?php issetValues('ip_address', $ip_add)?>></td>
   </tr>
   <tr>
        <td class=col1>Database: </td>
        <td class=col2><input type=text name=database size=30 
        <?php issetValues('database', $dbase)?>></td>
   </tr>
   <tr>
        <td class=col1>SQL Query:</td>
        <td class=col2><textarea rows=10 name=sql_query cols=50><?php issetValues('sql_query', $query);?></textarea>
    </td>
   </tr>
   <tr>
       <td  colspan=2 class=btn-row>
           <input type=submit name=submit value="Execute Query">
           <input type=submit name=reset value=Reset <?php reset_form()?>>
        </td>
   </tr>
</table>
</form>
</div>