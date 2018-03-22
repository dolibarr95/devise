<?php
/** 
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 * 	\file		devise/devise.php
 *	\ingroup    devise
 *	\brief      Afficher un graphique de devise
 *
 */

/// \cond IGNORER
// Load Dolibarr environment

require '../../main.inc.php';
require_once 'class/devise.class.php';
require_once 'lib/devise.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';



// Translations
$langs->load("devise@devise");
$langs->load("admin");
$langs->load("errors");


//Contrôle d'accès et statut du module
require_once 'core/modules/moddevise.class.php';	
$bstatus = new moddevise($db);
$const_name = 'MAIN_MODULE_'.strtoupper($bstatus->name);
if ( ( !$user->rights->devise->lire && !$user->admin ) || empty($conf->global->$const_name) ){
	accessforbidden();
}


/**
 * Parametres
 */
 

$obj_b = new devise($db);



/// \cond IGNORER
/**
 *	action : action formulaire
 */
$devise = GETPOST('devise','alpha');
$devises = array('CAD','CHF','CNY','GBP','JPY','USD');


if( !in_array($devise, $devises)){
	$devise = 'USD';
}


$historique = GETPOST('historique','int');
$historiques = array(10,20,30,40,50,60,70,80,90,100,200,300);
if( !in_array($historique, $historiques)){
	$historique = 10;
}

/**
 * Affichage
 */


llxHeader('', $langs->trans("Module670001Name"), '');




$head = devisePrepareHead();
dol_fiche_head(
	$head,
	'devise',
	$langs->trans("Module670001Name"),
	0,
	"devise@devise"
);

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
 
 var arr = new Array();//liste des infos( date, taux, html)
			
			
	 for( var i = <?=$historique?> ; i>=0 ; i--){//parcourir l'historique des dates
    (function(index,arr2) {
        setTimeout(function() {
			var avant = new Date((new Date()).valueOf() - 1000*60*60*24*index);//jours*i (index)
						
			annee = avant.getFullYear();
			if(avant.getDate() <10){
			jour = "0" + avant.getDate() ;
			} else{
			jour = avant.getDate();
			}
			
			if(avant.getMonth() + 1<10){//de 0 à 11 + 1 pour l'api fixer
			mois = "0" + (avant.getMonth() + 1);
			} else{
			mois = avant.getMonth() + 1;
			}
			
			if(avant.getMonth() <10){//de 0 à 11 pour date google
			mois2 = "0" + (avant.getMonth() );
			} else{
			mois2 = avant.getMonth() ;
			}
			
		$.getJSON( "https://api.fixer.io/"+annee+"-"+ mois +"-"+ jour+"", function( json ) {
				console.log( "i " + index + " 1 euro valait le  "+annee+"-"+mois+"-"+jour+" : " + json.rates[ '<?=$devise?>' ] +' dollar.');
				arr2[index] = [new Date(annee,mois2,jour, 0, 0),json.rates[ '<?=$devise?>' ],"<p>Valeur au "+jour+"/"+mois+"/"+annee+"<br><b style=\"font-size:15pt;\">"+json.rates[ '<?=$devise?>' ]+"</b></p>"];
				console.log(arr2[index]);
				
					if(index==<?=$historique?>)
					{//fin on lance services Google
						console.log('fin');
						console.log(arr2);
						
						google.charts.load('current', {'packages':['corechart']});
						google.charts.setOnLoadCallback(drawBasic);
					}
				
			},arr2);
			

		}, i * 400);//timer pour fixer
    })(i,arr);
}
 
 
/**
 *	Dessiner le graphique Google
 *	@returns	object	html
 */
 
function drawBasic() {

      var data = new google.visualization.DataTable();
		data.addColumn('date', 'X');//date
		data.addColumn('number', '<?=$devise?>');//taux
		data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});//html

			
		data.addRows(
		arr
		);

      var options = {
        hAxis: {
          title: 'date'
        },
        vAxis: {
          title: 'valeur',
		  format: 'decimal'
        },
		 tooltip: {isHtml: true}
      };

      var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));//LineChart

      chart.draw(data, options);
    }
	
	
	
	
</script>
<?php
$form = new Form($db);
?>
<table class="noborder" width="100%">
	<tr class="liste_titre">
		<td style="text-align:center;" >
			<label for="b_devise"><?='<label for="b_pays">'.$form->textwithpicto('Devise', 'De EUR vers la devise choisie.').'</label>'?></label>
			<select id="b_devise" name="b_devise" onchange="window.location='devise.php?devise=' + this.value+'&historique=<?=$historique?>';">
			<?php
				foreach ($devises as $key => $value){
					$s = '';
					if( $devise == $value ){
							$s = ' selected="selected"';
						}
					print '<option value="'.$value.'"'.$s.'>'.$value.'</option>';
				}
			?>	
			</select>
		</td>
		<td style="text-align:center;" >
			<label for="b_historique"><?='<label for="b_pays">'.$form->textwithpicto('Historique', 'Nombre de jours à afficher à partir d\'aujourd\'hui<br>Plus le nombre est grand plus long sera le pré-chargement.').'</label>'?>
</label>
			<select id="b_historique" name="b_historique" onchange="window.location='devise.php?devise=<?=$devise?>&historique=' + this.value+'';">
			<?php
				foreach ($historiques as $key => $value){
					$s = '';
					if( $historique == $value ){
							$s = ' selected="selected"';
						}
					print '<option value="'.$value.'"'.$s.'>'.$value.'</option>';
				}
			?>	
			</select>
		</td>
	</tr>
</table>

<div id="chart_div" style="width: 100%; height: 800px"><img src="img/icons/wait.gif">chargement en cours</div>
<i>Les données sont mis à jour quotidiennement vers 16 heures, publiées par la Banque Centrale Européenne et transmises via Fixer sans garanties. La BCE ne publie des taux que pour les jours ouvrables.</i>
<?php
dol_fiche_end();

llxFooter();

$db->close();
/// \endcond
?>