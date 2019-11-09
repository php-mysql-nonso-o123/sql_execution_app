<style><?php include_once("style.css") ?></style>
<div class=container>
<form>
<table cellpadding=5>
   <tr>
   <td class=col1>Username: </td>
   <td class=col2><input type=text size=30></td>
   </tr>
   <tr>
   <td class=col1>Password: </td>
   <td class=col2><input type=text size=30></td>
   </tr>
   <tr>
   <td class=col1>IP Address: </td>
   <td class=col2><input type=text size=30></td>
   </tr>
   <tr>
   <td class=col1>Database: </td>
   <td class=col2><input type=text size=30></td>
   </tr>
   <tr>
   <td class=col1>SQL Query: </td>
   <td class=col2><textarea rows=10 cols=50></textarea></td>
   </tr>
   <tr>
       <td  colspan=2 class=btn-row>
           <input type=submit value="Execute Query">
           <input type=reset value=Reset></td>
   </tr>
</table>
</form>
</div>