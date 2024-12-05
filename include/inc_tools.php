<?PHP
//--------------------------------------------------------------------------------------------------------
function print_tools($type = '') {

	if ($type == 'blank') {
?>
		<div id='toolscenter'>
			<ul id='tools'>
				<li><a href='http://www.top-immobilier-particulier.fr/' target='_blank' title="Aller à l'accueil">www.top-immobilier-particulier.fr</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/plan-du-site.htm' target='_blank' title='Voir le Plan du site'>Plan du site</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/noref/faq.php' target='_blank' title='Réponses aux questions fréquemment posées'>FAQ</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/noref/contact-equipe.php?action=print_form' target='_blank' title='Contacter nous' rel="nofollow">Contacter Nous</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/noref/loupe.php' target='_blank' title='Augmenter ou diminuer la taille du texte'>+ Loupe -</a>&nbsp;|&nbsp;</li>
				<li><a href='http://lexique.top-immobilier-particulier.fr' target='_blank' title='Lexique Immobilier'>Lexique Immobilier</a></li>
			</ul>
		</div>
		&nbsp;
	<?PHP
	} else if ($type == 'tools') {
	?>
		<div id='toolscenter'>
			<ul id='tools'>
				<li><a href='http://www.top-immobilier-particulier.fr/' title="Aller � l'accueil">www.top-immobilier-particulier.fr</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/plan-du-site.htm' title='Voir le Plan du site'>Plan du site</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/noref/faq.php' title='R�ponses aux questions fréquemment posées'>FAQ</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/noref/contact-equipe.php?action=print_form' title='Contacter nous' rel="nofollow">Contacter Nous</a>&nbsp;|&nbsp;</li>
				<li><a href='http://www.top-immobilier-particulier.fr/noref/loupe.php' title='Augmenter ou diminuer la taille du texte'>+ Loupe -</a>&nbsp;|&nbsp;</li>
				<li><a href='http://lexique.top-immobilier-particulier.fr' title='Lexique Immobilier'>Lexique Immobilier</a></li>
			</ul>
		</div>
		&nbsp;
<?PHP
	}
}
?>