<?php
/** 
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 * 	\file		devise/admin/about.php
 *	\ingroup    devise
 *	\brief      A propos de ce module
 */

/// \cond IGNORER

require '../../../main.inc.php';
global $langs, $user;


// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/devise.lib.php';
require __DIR__ . '/../vendor/autoload.php';

// Translations
$langs->load("devise@devise");


//Contrôle d'accès et statut du module
require_once '../core/modules/moddevise.class.php';	
$bstatus = new moddevise($db);
$const_name = 'MAIN_MODULE_'.strtoupper($bstatus->name);
if ( ( !$user->rights->devise->admin && !$user->admin ) || empty($conf->global->$const_name) ){
	accessforbidden();
}

/*
 * View
 */
$page_name = "A propos du module";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
	. $langs->trans("BackToModuleList") . '</a>';
print_fiche_titre($langs->trans($page_name), $linkback,'title_setup');

// Configuration header
$head = deviseAdminPrepareHead();
dol_fiche_head(
	$head,
	'about',
	$langs->trans("Module670001Name"),
	0,
	'devise@devise'
);



print "
<h2>Id du module</h2>
<p>Ce module fonctione sous l'id ".$bstatus->numero.".";


// Page end
dol_fiche_end();
llxFooter();
/// \endcond
?>