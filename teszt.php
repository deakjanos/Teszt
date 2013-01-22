<?php
global $veznev;
global $kernev;
global $gender;
global $city;
global $op;

echo '<html>';
echo '<head>';
echo '<title>Teszt oldal űrlap kezeléshez</title>';
echo '</head>';
echo '<body>';
  
  $host = 'localhost';
  $user = 'root';
  $password = 'mokuska';

  $veznev = $_GET["vnev"];
  $kernev = $_GET["knev"]; 
  $city = $_GET["varos"];
  $gender = $_GET["nem"];
  $op = $_GET["op"];


  // ----- BESZURAS --------
  if ( isset($op) ) {
    if ( $op == "insert" ) {

      $connect = mysql_connect( $host, $user, $password ) or die ( "Error: Can not connect to server" );
      mysql_select_db( "teszt", $connect ) or die ( "Can not connect to database" );
    	mysql_query("SET NAMES utf8");
	mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
      if ( isset($veznev) && isset($kernev) && isset($city) && isset($gender) ) {
      
        $sql = "INSERT INTO emberek (vezeteknev, keresztnev, varos, nem) VALUES ('" . $veznev ."','". $kernev. "','". $city. "','". $gender . "')";
    
        mysql_query( $sql ) or die ("Hiba a beszúrásnál");
      }
      $sql = "SELECT varosnev FROM varosok";
      $varoslista = mysql_query( $sql );
    
      mysql_close($connect);
    }
  }
  
  // -------  TORLES  --------
  if ( isset($op) ) {
    if ( $op == "del" ) {
      $id = $_GET["id"];
      $table = $_GET["table"];
      
      $connect = mysql_connect( $host, $user, $password ) or die ( "Error: Can not connect to server" );
      mysql_select_db( "teszt", $connect ) or die ( "Can not connect to database" );
    
      $sql = "DELETE FROM ". $table ." WHERE id=" . $id;
      mysql_query( $sql ) or die ("Hiba a törlésnél");
      
      mysql_close($connect);
    }
  }
  
  // ----- MODOSITAS -------
  if ( isset($op) ) { 
    if ( $op == "updateform" ) {   //   ------ URLAP A MODOSITASHOZ ---------
    
      $id = $_GET["id"];
      $table = $_GET["table"];

      $connect = mysql_connect( $host, $user, $password ) or die ( "Error: Can not connect to server" );
      mysql_select_db( "teszt", $connect ) or die ( "Can not connect to database" );
		mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
		mysql_query("SET NAMES utf8");
      $sql = "SELECT varosnev FROM varosok";
      $varoslista = mysql_query( $sql );

      
      mysql_close($connect);
    
      echo '<form action="teszt.php" method="get">';
      echo '<table width=100 >';
      echo '<tr><td>Vezetéknév: </td><td><input type="text" name="vnev" value="'.$veznev.'" /></td></tr>';
      echo '<tr><td>Keresztnév: </td><td><input type="text" name="knev" value="'.$kernev.'" /></td></tr>';
      echo '<tr><td>Férfi </td><td><input type="radio" name="nem" value="Férfi"></td></tr>';
      echo '<tr><td>Nő </td><td><input type="radio" name="nem" value="Nő"></td></tr>';
      echo '<tr><td>Város</td><td><select name="varos" >';
        while ( $v = mysql_fetch_array($varoslista, MYSQL_NUM) ) {
          if ( $city == $v[0] ) {
            echo '<option selected value="' . $v[0] . '">' . $v[0] . '</option>';
          } else {
            echo '<option value="' . $v[0] . '">' . $v[0] . '</option>';
          }
        }
      echo '</select></td></tr>';
      echo '<tr><td><input type="submit" value="Módosít" /></td></tr>';
      echo '</table>';
      echo '<input type="hidden" name="op" value="update" />'; // hidden: ezt nem látja a felhasználó
      echo '<input type="hidden" name="id" value="'. $id .'" />';  
      echo '<input type="hidden" name="table" value="'. $table .'" />';
      echo '</form>';
    } else if ( $op == "update" ) {   // ------- ITT tortenik a modositas  -------
      $id = $_GET["id"];
      $table = $_GET["table"];
      
      $connect = mysql_connect( $host, $user, $password ) or die ( "Error: Can not connect to server" );
      mysql_select_db( "teszt", $connect ) or die ( "Can not connect to database" );
    	mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
		mysql_query("SET NAMES utf8");
      $sql = "UPDATE ". $table ." SET vezeteknev='".$veznev."', keresztnev='".$kernev."', nem='".$gender."', varos='".$city."' WHERE id=" . $id;
      mysql_query( $sql ) or die ("Hiba a módosításnál");
      
      mysql_close($connect);
    }
    
  }
  
// ------------  FORM  ---------------
 
  $connect = mysql_connect( $host, $user, $password ) or die ( "Error: Can not connect to server" );
  mysql_select_db( "teszt", $connect ) or die ( "Can not connect to database" );
 	mysql_query("SET NAMES utf8");
	mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
  $sql = "SELECT varosnev FROM varosok";
  $varoslista = mysql_query( $sql );
  mysql_close($connect);
  if ( $op != "updateform" ) { // --- csak akkor jelenik meg, ha nem az módosításhoz jelenik meg az űrlap
    echo '<form action="teszt.php" method="get">';
    echo '<input type="hidden" name="op" value="insert" />';
    echo '<table width=100 >';
    echo '<tr><td>Vezetéknév: </td><td><input type="text" name="vnev" value="" /></td></tr>';
    echo '<tr><td>Keresztnév: </td><td><input type="text" name="knev" value="" /></td></tr>';
    echo '<tr><td>Férfi </td><td><input type="radio" name="nem" value="Férfi"></td></tr>';
    echo '<tr><td>Nő </td><td><input type="radio" name="nem" value="Nő"></td></tr>';
    echo '<tr><td>Város</td><td><select name="varos" >';
      while ( $v = mysql_fetch_array($varoslista, MYSQL_NUM) ) {
        echo '<option value="' . $v[0] . '">' . $v[0] . '</option>';
      }
    echo '</select></td></tr>';
    echo '<tr><td><input type="submit" value="Beszúr" /></td></tr>';
    echo '</table>';
     
    echo '</form>';
  }
//  ----------  LEKERDEZES   ---------------


  $connect = mysql_connect( $host, $user, $password ) or die ( "Error: Can not connect to server" );
  mysql_select_db( "teszt", $connect ) or die ( "Can not connect to database" );
    mysql_query("SET NAMES utf8");
	mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
  $sql = "SELECT id, vezeteknev, keresztnev, varos, nem FROM emberek";
  $eredmeny = mysql_query( $sql );
  
  echo '<center>';
  echo '<table width="60%" border="1">';
    echo '<tr><td bgcolor="#EEEEEE">Vezetéknév</td><td bgcolor="#EEEEEE">Keresztnév</td><td bgcolor="#EEEEEE">Város</td><td bgcolor="#EEEEEE">Nem</td><td bgcolor="#EEEEEE">Módosít</td><td bgcolor="#EEEEEE">Törlés</td></tr>';
    while ( $rekord = mysql_fetch_array($eredmeny, MYSQL_NUM) ) {
      echo '<tr><td>' . $rekord[1] . '</td><td>' . $rekord[2] . '</td><td>' . $rekord[3] . '</td><td>' . $rekord[4] . '</td>';
      /***** törlés gombhoz egy form kell ****/
      echo '<td>';
      echo '<form action="teszt.php" method="get" >';
      echo '<input type="hidden" name=table value="emberek" /> ';
      echo '<input type="hidden" name=id value="'.$rekord[0].'" /> '; // a rekord id-jét továbbadjuk
      echo '<input type="hidden" name=vnev value="'.$rekord[1].'" /> '; // a vezetéknevet továbbadjuk
      echo '<input type="hidden" name=knev value="'.$rekord[2].'" /> '; // a keresztnevet továbbadjuk
      echo '<input type="hidden" name=varos value="'.$rekord[3].'" /> '; // a várost továbbadjuk
      echo '<input type="hidden" name=nem value="'.$rekord[4].'" /> '; // a nemet továbbadjuk
      echo '<input type="hidden" name=op value="updateform" /> '; // az opció "updateform" lesz
      echo '<input type="submit" value="Módosít" />'; // a Módosít gomb
      echo '</form>';
      echo '</td>';
      echo '<td>';
      echo '<form action="teszt.php" method="get" >';
      echo '<input type="hidden" name="table" value="emberek" /> ';
      echo '<input type="hidden" name="id" value="'.$rekord[0].'" /> '; // a rekord id-jét továbbadjuk
      echo '<input type="hidden" name="op" value="del" /> '; // az opció "updateform" lesz
      echo '<input type="submit" value="Töröl" />'; // a Töröl gomb
      echo '</form>';
      echo '</td>';
      
      echo '</tr>';
    }
  echo '</table>';
  echo '</center>';
  
  mysql_close($connect);


echo '</body>';
echo '</html>';

?>
