<?PHP
//--------------------------------------------------------------------------------------------------------
function print_tools($type='') {

  if ( $type == 'blank' ) {
    ?>
		<div id='toolscenter'>
    <ul id='tools'>
	    <li><a href='http://www.top-immobilier-particuliers.fr/' target='_blank' title="Aller � l'accueil">www.top-immobilier-particuliers.fr</a>&nbsp;|&nbsp;</li> 
	    <li><a href='http://www.top-immobilier-particuliers.fr/plan-du-site.htm' target='_blank' title='Voir le Plan du site'>Plan du site</a>&nbsp;|&nbsp;</li>
	    <li><a href='http://www.top-immobilier-particuliers.fr/noref/faq.php' target='_blank' title='R�ponses aux questions fr�quemment pos�es'>FAQ</a>&nbsp;|&nbsp;</li>
      <li><a href='http://www.top-immobilier-particuliers.fr/noref/contact-equipe.php?action=print_form' target='_blank' title='Contacter nous' rel="nofollow">Contacter Nous</a>&nbsp;|&nbsp;</li>
	    <li><a href='http://www.top-immobilier-particuliers.fr/noref/loupe.php' target='_blank' title='Augmenter ou diminuer la taille du texte'>+ Loupe -</a>&nbsp;|&nbsp;</li>
	    <li><a href='http://lexique.top-immobilier-particuliers.fr' target='_blank' title='Lexique Immobilier'>Lexique Immobilier</a></li>
    </ul>
	  </div>
	  &nbsp;
    <?PHP
  } else if ( $type == 'tools' ) {
    ?>
		<div id='toolscenter'>
    <ul id='tools'>
	    <li><a href='http://www.top-immobilier-particuliers.fr/' title="Aller � l'accueil">www.top-immobilier-particuliers.fr</a>&nbsp;|&nbsp;</li> 
	    <li><a href='http://www.top-immobilier-particuliers.fr/plan-du-site.htm' title='Voir le Plan du site'>Plan du site</a>&nbsp;|&nbsp;</li>
	    <li><a href='http://www.top-immobilier-particuliers.fr/noref/faq.php' title='R�ponses aux questions fr�quemment pos�es'>FAQ</a>&nbsp;|&nbsp;</li>
      <li><a href='http://www.top-immobilier-particuliers.fr/noref/contact-equipe.php?action=print_form' title='Contacter nous' rel="nofollow">Contacter Nous</a>&nbsp;|&nbsp;</li>
	    <li><a href='http://www.top-immobilier-particuliers.fr/noref/loupe.php' title='Augmenter ou diminuer la taille du texte'>+ Loupe -</a>&nbsp;|&nbsp;</li>
	    <li><a href='http://lexique.top-immobilier-particuliers.fr' title='Lexique Immobilier'>Lexique Immobilier</a></li>
    </ul>
	  </div>
	  &nbsp;
	  <?PHP
	}
} 
?>
