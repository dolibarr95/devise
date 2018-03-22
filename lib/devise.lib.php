<?php
/** 
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 * 	\file		devise/lib/devise.lib.php
 *	\ingroup	devise
 *	\brief		Gestionnaire de menu du module
 */
 
 /**
 *	Affficher une barre onglets de navigation pour l'administration
 *	@return     array		
 */ 
function deviseAdminPrepareHead()
{
	global $langs, $conf;

	$langs->load("devise@devise");

	$h = 0;
	$head = array();

	
	$head[$h][0] = dol_buildpath("/devise/admin/about.php", 1);
	$head[$h][1] = 'A propos';
	$head[$h][2] = 'about';
	$h++;
	
	
	complete_head_from_modules($conf, $langs, $object, $head, $h, 'devise');

	return $head;
}

/**
 *	Affficher une barre onglets de navigation pour utilisateur
 *	@return     array		
 */
function devisePrepareHead()
{
	global $langs, $conf;

	$langs->load("devise@devise");

	$h = 0;
	$head = array();

	$head[$h][0] = dol_buildpath("/devise/devise.php",1);
	$head[$h][1] = "Devise";
	$head[$h][2] = 'devise';
	$h++;
	complete_head_from_modules($conf, $langs, $object, $head, $h, 'devise');

	return $head;
}

