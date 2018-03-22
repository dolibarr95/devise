<?php
/** 
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 * 	\file		devise/class/actions_devise.class.php
 *	\ingroup	devise
 *	\brief		Ensemble de fonctions d'action de base pour le module devise
 *
 */

/**
 *	\class	actionsdevise
 *	\brief	Classe d'action du trigger et rayonnage
 */
class actionsdevise
{
	private $db; //!< To store db handler
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

    /**
     * Constructor
     *
     * @param		DoliDB		$db      Database handler
     */
    public function __construct($db)
    {
        $this->db = $db;
		return 1;
    }


	

	
	
	
	
}