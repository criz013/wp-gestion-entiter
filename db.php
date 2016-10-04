<?php 
/**
 * 
 * @author Christophe Bautista
 * 
 * La classe db sert à regrouper les principals fonctions lier aux requêtes sql.
 *
 */

class db{
	
	public function __construct()
	{
		include_once plugin_dir_path( __FILE__ ).'/listearmee.php';
		
	}
	
	public function install()
	{
		
		global $wpdb;
		
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}collection(
        id_collection Int NOT NULL AUTO_INCREMENT ,
        nom           Varchar (25) NOT NULL ,
        description   Text ,
        ancre_collection,        Varchar (25) NOT NULL,
        PRIMARY KEY (id_collection )
		)ENGINE=InnoDB;");
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}jeu(
        id_jeu      Int NOT NULL AUTO_INCREMENT ,
        nom         Varchar (25) NOT NULL ,
        description Text NOT NULL ,
        ancre_jeu,  Varchar (25) NOT NULL,
        PRIMARY KEY (id_jeu )
		)ENGINE=InnoDB;");
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}caracteristique(
        id_caracteristique Int NOT NULL AUTO_INCREMENT,
        Nom                Varchar (25) NOT NULL ,
        description        Text ,
        ancre_caracteristique,  Varchar (25) NOT NULL,
        PRIMARY KEY (id_caracteristique )
		)ENGINE=InnoDB;");
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}faction(
        id_faction  Int NOT NULL AUTO_INCREMENT,
        nom         Varchar (25) ,
        description Text NOT NULL ,
        ancre_faction,        Varchar (25) NOT NULL,
        PRIMARY KEY (id_faction )
		)ENGINE=InnoDB;");
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}type(
        id_type     Int NOT NULL AUTO_INCREMENT,
        nom         Varchar (25) NOT NULL ,
        description Text NOT NULL ,
        ancre_type,        Varchar (25) NOT NULL,
        PRIMARY KEY (id_type )
		)ENGINE=InnoDB;");
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}piece(
        id_piece      Int NOT NULL AUTO_INCREMENT,
        nom           Varchar (50) NOT NULL ,
        text,         Text,
        text_ambiance Text,
        image         Text ,
        id_faction    Int ,
        id_type       Int NOT NULL ,
        id_jeu        Int NOT NULL ,
        id_collection Int NOT NULL ,
        PRIMARY KEY (id_piece ),
		CONSTRAINT FK_piece_id_faction FOREIGN KEY (id_faction) REFERENCES {$wpdb->prefix}faction(id_faction) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT FK_piece_id_type FOREIGN KEY (id_type) REFERENCES {$wpdb->prefix}type(id_type) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT FK_piece_id_jeu FOREIGN KEY (id_jeu) REFERENCES {$wpdb->prefix}jeu(id_jeu) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT FK_piece_id_collection FOREIGN KEY (id_collection) REFERENCES {$wpdb->prefix}collection(id_collection) ON DELETE NO ACTION ON UPDATE NO ACTION)
		ENGINE=InnoDB;");
	
		$wpdb->query("CREATE TABLE {$wpdb->prefix}keyword(
        id_keyword  Int NOT NULL AUTO_INCREMENT,
        nom         Varchar (25) NOT NULL ,
        description Text ,
        ancre_keyword,        Varchar (25) NOT NULL,
        PRIMARY KEY (id_keyword )
		)ENGINE=InnoDB;");
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}pieceCarac(
        valeur             Int NOT NULL ,
        id_piece           Int NOT NULL ,
        id_caracteristique Int NOT NULL ,
        PRIMARY KEY (id_piece ,id_caracteristique ),
		CONSTRAINT FK_pieceCarac_id_piece FOREIGN KEY (id_piece) REFERENCES {$wpdb->prefix}piece(id_piece) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT FK_pieceCarac_id_caracteristique FOREIGN KEY (id_caracteristique) REFERENCES {$wpdb->prefix}caracteristique(id_caracteristique) ON DELETE NO ACTION ON UPDATE NO ACTION
		)ENGINE=InnoDB;");
		
		//error_log($wpdb->lastquery);
		
		$wpdb->query("CREATE TABLE {$wpdb->prefix}pieceKeyword(
        valeur     Int NOT NULL ,
        id_piece   Int NOT NULL ,
        id_keyword Int NOT NULL ,
        PRIMARY KEY (id_piece ,id_keyword ),
		CONSTRAINT FK_pieceKeyword_id_piece FOREIGN KEY (id_piece) REFERENCES {$wpdb->prefix}piece(id_piece) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT FK_pieceKeyword_id_keyword FOREIGN KEY (id_keyword) REFERENCES {$wpdb->prefix}keyword(id_keyword) ON DELETE NO ACTION ON UPDATE NO ACTION
		)ENGINE=InnoDB;");
		
	}
	
	public function uninstall()
	{
		global $wpdb;
		
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pieceKeyword;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pieceCarac;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}piece;");		
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jeu;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}caracteristique;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}faction;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}collection;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}type;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}keyword;");
		
	}
	
	public function ajout()
	{
		global $wpdb;
    	
		if (isset($_POST['titre_jeu']) && isset($_POST['description_jeu']))
		{
			if (!empty($_POST['titre_jeu']))
			{
				if (empty(($_POST['description_jeu'])))
					{
						$_POST['description_jeu'] = '';
					}
    				
						$wpdb->insert("{$wpdb->prefix}jeu", array('nom' => $_POST['titre_jeu'], 'description'=>$_POST['description_jeu']));
			}
		}
		
		if (isset($_POST['titre_caracteristique']) && isset($_POST['description_caracteristique']))
		{
			if (!empty($_POST['titre_caracteristique']))
			{
				if (empty(($_POST['description_caracteristique'])))
				{
					$_POST['description_caracteristique'] = '';
				}
		
				$wpdb->insert("{$wpdb->prefix}caracteristique", array('nom' => $_POST['titre_caracteristique'], 'description'=>$_POST['description_caracteristique']));
			}
		}
		
		if (isset($_POST['titre_type']) && isset($_POST['description_type']))
		{
			if (!empty($_POST['titre_type']))
			{
				if (empty(($_POST['description_type'])))
					{
						$_POST['description_type'] = '';
					}
    				
						$wpdb->insert("{$wpdb->prefix}type", array('nom' => $_POST['titre_type'], 'description'=>$_POST['description_type']));
			}
		}
		
		if (isset($_POST['titre_collection']) && isset($_POST['description_collection']))
		{
			if (!empty($_POST['titre_collection']))
			{
				if (empty(($_POST['description_collection'])))
					{
						$_POST['description_collection'] = '';
					}
    				
						$wpdb->insert("{$wpdb->prefix}collection", array('nom' => $_POST['titre_collection'], 'description'=>$_POST['description_collection']));
			}
		}
		
		if (isset($_POST['titre_faction']) && isset($_POST['description_faction']))
		{
			if (!empty($_POST['titre_faction']))
			{
				if (empty(($_POST['description_faction'])))
					{
						$_POST['description_faction'] = '';
					}
    				
						$wpdb->insert("{$wpdb->prefix}faction", array('nom' => $_POST['titre_faction'], 'description'=>$_POST['description_faction']));
			}
		}
		
		if (isset($_POST['titre_mot_clee']) && isset($_POST['description_mot_clee']))
		{
			if (!empty($_POST['titre_mot_clee']))
			{
				if (empty(($_POST['description_mot_clee'])))
				{
					$_POST['description_mot_clee'] = '';
				}
	
				$wpdb->insert("{$wpdb->prefix}keyword", array('nom' => $_POST['titre_mot_clee'], 'description'=>$_POST['description_mot_clee']));
			}
		}
	}
	
	public function supprimer(){
		
		global $wpdb;
		
		if (isset($_POST['supprimer_jeu']))
		{
			if(!empty($_POST['supprimer_jeu']))
			{
				$supJeu= (int)$_POST['supprimer_jeu'];
				$wpdb->delete("{$wpdb->prefix}jeu", array('id_jeu'=>$supJeu));
			}
		}
		
		if (isset($_POST['supprimer_faction']))
		{
			if(!empty($_POST['supprimer_faction']))
			{
				$sup= (int)$_POST['supprimer_faction'];
				$wpdb->delete("{$wpdb->prefix}faction", array('id_faction'=>$sup));
			}
		}
		
	if (isset($_POST['supprimer_collection']))
	{
		if(!empty($_POST['supprimer_collection']))
		{
			$sup= (int)$_POST['supprimer_collection'];
			$wpdb->delete("{$wpdb->prefix}collection", array('id_collection'=>$sup));
		}
	}
	
	if (isset($_POST['supprimer_type']))
	{
		if(!empty($_POST['supprimer_type']))
		{
			$sup= (int)$_POST['supprimer_type'];
			$wpdb->delete("{$wpdb->prefix}type", array('id_type'=>$sup));
		}
	}
	
	if (isset($_POST['supprimer_caracteristique']))
	{
		if(!empty($_POST['supprimer_caracteristique']))
		{
			$sup= (int)$_POST['supprimer_caracteristique'];
			$wpdb->delete("{$wpdb->prefix}caracteristique", array('id_caracteristique'=>$sup));
		}
	}
	
	if (isset($_POST['supprimer_keyword']))
	{
		if(!empty($_POST['supprimer_keyword']))
		{
			$sup= (int)$_POST['supprimer_keyword'];
			$wpdb->delete("{$wpdb->prefix}keyword", array('id_keyword'=>$sup));
		}
	}
	
}
	
	public function ajoutPiece()
	{
		global $wpdb;
		$id_jeu= $wpdb->get_results("SELECT id_jeu FROM {$wpdb->prefix}jeu");
		$carac = $wpdb->get_results("SELECT id_caracteristique, Nom FROM {$wpdb->prefix}caracteristique");
		$keyword = $wpdb->get_results("SELECT Nom FROM {$wpdb->prefix}keyword");
		
		foreach ( $id_jeu as $fivesdraft )
		{
			$id = $fivesdraft->id_jeu;
		}
		$wpdb->insert("{$wpdb->prefix}piece",array('nom'=>$_POST['nom_entite'],'image'=>'','id_faction'=>$_POST['faction_entité'],
													'id_type'=>$_POST['type_entité'],'id_jeu'=>$id,'id_collection'=>$_POST['collection_entité']));	
		$the_last = $wpdb->insert_id;
		
		foreach ($carac as $result_carac)
		{
				$wpdb->insert("{$wpdb->prefix}piececarac",array('valeur'=>$_POST[$result_carac->Nom],'id_piece'=>$the_last,
																'id_caracteristique'=>$result_carac->id_caracteristique));
		}
		
		foreach ($keyword as $result_key)
		{
			
			$wpdb->insert("{$wpdb->prefix}piecekeyword",array('id_piece'=>$the_last,
					'id_keyword'=>$_POST[$result_key->Nom]));
		
		}
	}
}
