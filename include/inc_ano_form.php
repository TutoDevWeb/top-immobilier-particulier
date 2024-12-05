<?PHP
/****************************************************************************************************/
function print_ano_form($zone) {
if ( ANO_DEBUG ) print_select_ano();
?>
<p>&nbsp;</p>
<form name="ano" method='post' action='<?PHP echo $_SERVER['PHP_SELF']; ?>' onsubmit="return valid_form_ano('<?PHP echo "$zone";?>');" <?PHP if ( DEBUG_ANO_FORM ) echo "onDblClick='fill_ano_form(this);'"; ?> >
  <table class='tab_ext'><tr><td> 
			  <table class='tab_int'>
          <tr> 
            <td width='200' class='label' style='border-right : 1px solid #30C;'>
            <p>
						<?PHP  
            if ( $zone == 'france' ) print_num_dept();
            print_zone_pays($zone);
            ?>
						</p>
            </td>
            <td  width='200' class='label'>
              <?PHP 
              if     ( $zone == 'france'   ) print_zone_ville($zone); 
              elseif ( $zone == 'domtom'   ) print_zone_domtom();
              elseif ( $zone == 'etranger' ) echo '&nbsp;';
              ?>
              </td>
            <td width='3' style='background: url(/images/dotted-30C.gif) repeat-y'></td>
            <td  width='200' class='label'>
              <?PHP
              if     ( $zone == 'france' ) print_zone_ard(); 
              elseif ( $zone == 'domtom' || $zone == 'etranger') print_zone_ville($zone);
              else echo '&nbsp;';
              ?>
            </td>
          </tr>
        </table>
			</td>
      <td width='3' rowspan='2' valign='bottom'><img src='/images/bord-droit.gif' alt='' /></td>
    </tr>
    <tr><td height='3'><div align='right'><img src='/images/bord-bas.gif' alt='' /></div></td></tr>
  </table>
  <table class='tab_ext'><tr><td> 
			  <table class='tab_int'>
          <tr> 
            <td class='label'><p>Type<br/><?PHP print_select_typp($zone); ?></p></td>
            <td width='3' style='background: url(/images/dotted-30C.gif) repeat-y'></td>
            <td class='label'>Pi&egrave;ces<br/> 
						  <select name='nbpi' id='nbpi'>
                <option value='0'  selected='selected'>Choisir&nbsp;&nbsp;</option>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
                <option value='7'>7</option>
                <option value='8'>8</option>
                <option value='9'>9</option>
              </select> </td>
            <td width='3' style='background: url(/images/dotted-30C.gif) repeat-y'></td>
            <td class='label'>Surperficie<br/>
                <input name='surf' type='text' id='surf' onkeyup="is_number('Superficie',this.value);" size='5' maxlength='3'/>
              </td>
            <td width='3' style='background: url(/images/dotted-30C.gif) repeat-y'></td>
            <td class='label'> <?PHP print_prix() ?> <br/> <input name='prix' type='text' id='prix' onkeyup="is_number('Prix',this.value);" size='10' maxlength='7'/> 
            </td>
          </tr>
        </table>
      </td>
      <td width='3' rowspan='2' valign='bottom'><img src='/images/bord-droit.gif' alt='' /></td>
    </tr>
    <tr> 
      <td height='3'><div align='right'><img src='/images/bord-bas.gif' alt='' /></div></td>
    </tr>
  </table>
  <table class='tab_ext'><tr><td> 
			  <table class='tab_int'>
          <tr> 
            <td> 
              <p><strong>Merci de prendre soin de r&eacute;diger votre annonce</strong><br/>
                Utilisez lettres, chiffres, virgules, points. Pas de parenth&egrave;ses. 512 caract&egrave;res maximum.</p>
              <p>
							  <textarea id='blabla' class='textj' name='blabla' cols='60' rows='7' onkeyup='print_nbcar();'></textarea>
              </p>
            </td>
            <td> 
              <p class='label'>Compteur<br/>
                Caract&egrave;res<br/>
                <input name='nbcar' type='text' id='nbcar' size='4' maxlength='4' readonly='readonly' />
              </p>
            </td>
          </tr>
        </table>
      </td>
      <td width='3' rowspan='2' valign='bottom'><img src='/images/bord-droit.gif' alt='' /></td>
    </tr>
    <tr> 
      <td height='3'><div align='right'><img src='/images/bord-bas.gif' alt='' /></div></td>
    </tr>
  </table>
  <table class='tab_ext'><tr><td> 
			  <table class='tab_int'>
          <tr> 
            <td width='165'> 
              <table width='100%' border='0' cellspacing='0' cellpadding='3'>
                <tr> 
                  <td class='label' align='center'>Votre t&eacute;l&eacute;phone 1<br/> <input <?PHP if ( is_modif() ) echo 'class=text_red'; ?> name='tel_ins' id='tel_ins' type='text' onkeyup="is_number('Téléphone',this.value);" size='12' maxlength='10' <?PHP if ( is_modif() ) echo "readonly='readonly'"; ?> /></td>
                </tr>
                <tr> 
                  <td class='text10' align='center'><em>* Ce sera votre identifiant</em></td>
                </tr>
                <tr> 
                  <td height='3' style='background: url(/images/dotted-30C.gif) repeat-x'></td>
                </tr>
                <tr> 
                  <td align='center'><p class='label'>Votre t&eacute;l&eacute;phone 2<br/><input name='tel_bis' id='tel_bis' type='text' size='12' maxlength='10' onkeyup="is_number('Téléphone Optionnel',this.value);" /></p></td>
                </tr>
                <tr> 
                  <td class='text10' align='center'><em>* Optionnel</em></td>
                </tr>
              </table>
            </td>
            <td width='3' style='background: url(/images/dotted-30C.gif) repeat-y'></td>
            <td width='409'>
              <table width='100%' border='0' cellspacing='0' cellpadding='3'>
                <tr> 
                  <td colspan="2" align='center' class='label'>Votre site personnel ou blog<br/>
                    http:// 
                    <input name='wwwblog' id='wwwblog' type='text' maxlength='128'/>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" align='center'><em>* mettez y vos vid&eacute;os de visites virtuelles</em></td>
                </tr>
                <tr> 
                  <td colspan="2"  height='3' style='background: url(/images/dotted-30C.gif) repeat-x'></td>
                </tr>
                <tr> 
                  <td class='label' align='center'>Votre mail<br/>
                    <input <?PHP if ( is_modif() ) echo 'class=text_red'; ?> name='sagmail' id='sagmail' type='text' maxlength='128' <?PHP if ( is_modif() ) echo "readonly='readonly'"; ?> />
                  </td>
                  <td class='label' align='center'>Cocher pour &ecirc;tre contact&eacute; par mail<br/>
                    <input name='ok_email' type='checkbox' value='1' />
                  </td>
                </tr>
                <tr> 
                  <td colspan='2' class='text10' align='center'><em>* Le mail n'appara&icirc;tra pas sur l'annonce</em></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
      <td width='3' rowspan='2' valign='bottom'><img src='/images/bord-droit.gif' alt='' /></td>
    </tr>
    <tr> 
      <td height='3'><div align='right'><img src='/images/bord-bas.gif' alt='' /></div></td>
    </tr>
  </table>
  <?PHP 
  if ( is_modif() ) echo '<div class=text_red><em>Ces champs ne sont pas modifiables !</em></div>'; 
  ?>
  <table class='tab_ext'>
    <tr> 
      <td width='245'><p> 
          <input type='hidden' name='zone' value='<?PHP echo "$zone"; ?>' />
          <input type='hidden' name='action' value='store_session' />
          <input name='condition' id='condition' type='checkbox' value='1' />
          <a href='noref/condition.php' target='_blank' rel='nofollow'>J'ai lu les conditions d'utilisation</a> </p></td>
      <td width='262'>Recopier le code&nbsp;&nbsp; <input name='code_set' id='code_set' type='text' size='5' maxlength='4' readonly='readonly' /> 
        &nbsp;&nbsp;&nbsp;&nbsp; <input name='code_get' id='code_get' type='text' size='5' maxlength='4' /></td>
      <td width='83' align='right'><input class='but_input' type='submit' name='Submit2' value='Enregistrer' /></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td colspan='2'> <p>&nbsp;</p>
        <p><em><strong>* <?PHP echo PRIX_ANNONCE," Euros"?></strong> &nbsp;pour <?PHP echo DUREE_ANNONCE ?> mois en ligne avec 5 photos</em> </p></td>
    </tr>
  </table>
</form>
<?PHP
echo "<script type='text/javascript'>\n";
$_SESSION['code_set'] = code_generator(4);
printf("document.ano.code_set.value='%s';\n",$_SESSION['code_set']);
echo  "</script>\n";
}
//------------------------------------------------------
function deja_annonce() {
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<img src="/images/megaphone-deja-annonce.gif" alt="Il y a déjà une annonce correspondant à ce numéro" />
<p>&nbsp;</p>
<p>&nbsp;</p>
<?PHP 
print_deconnexion();
?>
<p>&nbsp;</p>
<?PHP
}
//------------------------------------------------------
function print_prix() {
  echo "Prix de Vente";
}
//------------------------------------------------------
function print_zone_pays($zone) {

  if ( $zone == 'france' ) {
    echo "<input  type='hidden' name='zone_pays' id='zone_pays' value='France' />";
  }

  if ( $zone == 'domtom' ) {
    echo "Pays<br/><input name='zone_pays' id='zone_pays' type='text' size='15' value='DomTom' readonly='readonly' />";
  }

  if ( $zone == 'etranger'  ) {
    echo "Pays<br/><input name='zone_pays' id='zone_pays' type='text' size='15' maxlength='25' />";
  }

}
//------------------------------------------------------
function print_zone_ville($zone) {

  if ( $zone == 'france' ) {
    echo "Ville<br/>";
    echo "<select name='zone_ville' id='zone_ville' onchange='sa.fill(this.value);'>\n";
    echo "<option value=''>Choisir</option>\n";
    echo "</select>\n";
  }

  if ( $zone == 'domtom' || $zone == 'etranger' ) {
    echo "Ville<br/><input name='zone_ville' id='zone_ville' type='text' size='30' maxlength='40'/>";
  }
}
//------------------------------------------------------
function print_zone_ard() {
    echo "<div id='ard'>\n";
    echo "Arrondissemment<br/>\n";
    echo "<select id='zone_ard' name='zone_ard'>\n";
    echo "<option value=''>Choisir</option>\n";
    echo "</select>\n";
    echo "</div>\n";    
}
//------------------------------------------------------------------------
// 
function print_num_dept() {
?>
Département<br/>
<select name="num_dept" id="num_dept" onchange="sv.fill(this.value);">
<option value=''>Choisir</option>
</select>
<?PHP
}
//------------------------------------------------------------------------
// 
function print_zone_domtom() {
?>
Dom Tom<br/>
<select name="zone_dom" id="zone_dom">
<option value='0'  selected='selected'>Choisir</option>
<option value="Guadeloupe" >Guadeloupe</option>
<option value="Martinique" >Martinique</option>
<option value="Guyane" >Guyane</option>
<option value="La Reunion" >La Reunion</option>
<option value="Saint-Pierre-et-Miquelon" >Saint-Pierre-et-Miquelon</option>
<option value="Mayotte" >Mayotte</option>
<option value="Wallis et Futuna" >Wallis et Futuna</option>
<option value="Polynesie Française" >Polynesie Française</option>
<option value="Nouvelle-Caledonie" >Nouvelle-Caledonie</option>
</select>
<?PHP
}
//------------------------------------------------------------------------
// 
function print_select_typp($zone) {
  if ( $zone == 'paris' || $zone == 'region' ) {
    echo "<select name='typp' id='typp'>\n";
    echo "<option value='0'  selected='selected'>Choisir</option>\n";
    echo "<option value='",VAL_NUM_APPARTEMENT,"'>Appartement</option>\n";
    echo "<option value='",VAL_NUM_MAISON,"'>Maison</option>\n";
    echo "<option value='",VAL_NUM_LOFT,"'>Loft</option>\n";
    echo "</select>\n";
  }
  if ( $zone == 'france' ) {
    echo "<select name='typp' id='typp'>\n";
    echo "<option value='0'  selected='selected'>Choisir</option>\n";
    echo "<option value='",VAL_NUM_APPARTEMENT,"'>Appartement</option>\n";
    echo "<option value='",VAL_NUM_MAISON,"'>Maison</option>\n";
    echo "<option value='",VAL_NUM_LOFT,"'>Loft</option>\n";
    echo "<option value='",VAL_NUM_CHALET,"'>Chalet</option>\n";
    echo "</select>\n";
  }
  if ( $zone == 'domtom' ) {
    echo "<select name='typp' id='typp'>\n";
    echo "<option value='0'  selected='selected'>Choisir</option>\n";
    echo "<option value='",VAL_NUM_APPARTEMENT,"'>Appartement</option>\n";
    echo "<option value='",VAL_NUM_MAISON,"'>Maison</option>\n";
    echo "<option value='",VAL_NUM_LOFT,"'>Loft</option>\n";
    echo "</select>\n";
  }
  if ( $zone == 'etranger' ) {
    echo "<select name='typp' id='typp'>\n";
    echo "<option value='0'  selected='selected'>Choisir</option>\n";
    echo "<option value='",VAL_NUM_APPARTEMENT,"'>Appartement</option>\n";
    echo "<option value='",VAL_NUM_MAISON,"'>Maison</option>\n";
    echo "<option value='",VAL_NUM_LOFT,"'>Loft</option>\n";
    echo "<option value='",VAL_NUM_CHALET,"'>Chalet</option>\n";
    echo "</select>\n";
  }
}
//------------------------------------------------------------------------
//
function print_select_ano() {

$my_ip = "84.102.38.92";
$ip  = $_SERVER['REMOTE_ADDR'];

if ( $my_ip != $ip ) return; 

?>

<script type="text/javaScript">
function affecter_annonce() {

  var zone_test  = document.getElementById("zone_test");

  window.alert("Affectation des Champs : "+zone_test[zone_test.selectedIndex].value);

  var zone_pays  = document.getElementById("zone_pays");
  var zone_dept  = document.getElementById("zone_dept");
  var zone_ard   = document.getElementById("zone_ard");
  var zone_dom   = document.getElementById("zone_dom");
  var zone_ville = document.getElementById("zone_ville");
  var quart      = document.getElementById("quart");
  var typp       = document.getElementById("typp");
  var nbpi       = document.getElementById("nbpi");
  var surf       = document.getElementById("surf");
  var prix       = document.getElementById("prix");
  var blabla     = document.getElementById("blabla");
  var tel_ins   = document.getElementById("tel_ins");
  var tel_bis   = document.getElementById("tel_bis");


  // France
  if ( zone_test.selectedIndex == 3 ) {

    zone_dept.selectedIndex = 6;
    zone_ville.value = "Nice";
    typp.selectedIndex = 2;
    nbpi.selectedIndex = 4;
    surf.value = '100';
    prix.value = '800000';
    blabla.value = "Superbe villa avec vue sur la baie des Anges. Exposition plein Sud. Salon de 45 m² avec chemninée. Proximité commerces, écoles, mer. 3 Chambres avec rangement. Salle de bains et une salle de douche. L'offre est à négocier";

    tel_ins.value = "0492972903";
    tel_bis.value = "0670033003";

  }

  // Dom Tom
  if ( zone_test.selectedIndex == 4 ) {

    zone_dom.selectedIndex = 4;
    zone_ville.value = "St-Pierre";
    quart.value = 'Petite Ile';
    typp.selectedIndex = 2;
    nbpi.selectedIndex = 5;
    surf.value = '220';
    prix.value = '340000';
    blabla.value = "Cause départ. Villa F5, 220 m² avec sous-sol aménagé en F3 de 85 m². Villa F5 comprenant 3 chambres, spacieux, mezzanine 30 m². F3, neuf, cuisine américaine, 2 chambres, 2 salles de bains. Ensemble sur jardin paysager 1.015 m². Vue panoramique. Téléphoner de 7 h à 18 h métropole.";

    tel_ins.value = "0492972904";
    tel_bis.value = "0670033004";

  }

  // Etranger
  if ( zone_test.selectedIndex == 5 ) {

    zone_pays.value = 'Maroc';
    zone_ville.value = "Marrakech";
    quart.value = 'Palmeraie';
    typp.selectedIndex = 6;
    nbpi.selectedIndex = 5;
    surf.value = '350';
    prix.value = '1000000';
    blabla.value = "Un ryad à Marrakech idéal au coeur de la palmeraie. Pour vos vacances ou simplement un week end entre amis. La Palmeraie: A la sortie de la ville, sur la route de Casablanca, juste avant le pont sur l'oued Tensift, une étroite route permet de faire en voiture ou en calèche un circuit de 22 km à travers la palmeraie. Peuplée d'environ cent cinquante mille palmiers.";

    tel_ins.value = "0492972905";
    tel_bis.value = "0670033005";

  }


  var sagmail   = document.getElementById("sagmail");
  var condition = document.getElementById("condition");
  var code_set  = document.getElementById("code_set");
  var code_get  = document.getElementById("code_get");

  sagmail.value = "jl.fondacci@neuf.fr"
  condition.checked = true;
  code_get.value = code_set.value;

}
</script>

<select class='text11' name="zone_test" id="zone_test" onchange="affecter_annonce();">
<option value='0' selected>Choisir la Zone</option>
<option value="1" >France</option>
<option value="2" >Dom Tom</option>
<option value="3" >Etranger</option>
</select>
<?PHP
}
?>
