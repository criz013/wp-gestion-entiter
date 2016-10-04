<?php
/*
Plugin Name: Collection d'armée
Plugin URI: http://crizsroom.
Description: Ce pluging va vous permettre de créer des collections pour vos jeux de figurines ou de cartes.
Version: 0.1
Author: Christophe Bautista
Author URI: http://crizsroom.fr
License: GPL2
*/

include_once plugin_dir_path( __FILE__ ).'/db.php';
include_once plugin_dir_path( __FILE__ ).'/front.php';

class Liste_armee {
	

	
	public function __construct()
	{
		
		new db();
		new front();
		
		//Installation et suppression de la bdd
		register_activation_hook(__FILE__, array('db', 'install'));
		register_uninstall_hook(__FILE__, array('db', 'uninstall')); 
		
		add_action('admin_menu', array($this,'add_admin_menu'));
		add_action('wp_loaded', array('db', 'ajout'));
		add_action('wp_loaded',array('db', 'supprimer'));
		add_action('wp_loaded',array('db','ajoutPiece'));

	}
	
	/**
	 * @add_admin_menu
	 * Ajout des menus et sous-menu dans le panneau administrateur.
	 */
	
	public function add_admin_menu()
	{
    	add_menu_page('Collection', 'Collection', 'manage_options', 'coll');
    	add_submenu_page('coll', 'Visualiser', 'Visualiser', 'manage_options', 'coll', array($this, 'visualiser_html'));
    	add_submenu_page('coll', 'Configuration', 'Configuration', 'manage_options', 'configurer', array($this, 'configuration_html'));
        add_submenu_page('coll', 'Ajouter une pièce', 'Ajouter une pièce', 'manage_options', 'administration', array($this, 'ajout_html'));	
    }
     
	public function configuration_html()
	{
		echo '<h1>'.get_admin_page_title().'</h1>';?>
		
		<h2>Titre du jeu</h2>
		 <?php
		 	global $wpdb;
		 	$req_jeu="SELECT * FROM {$wpdb->prefix}jeu";
			 $row= $wpdb->get_row($req_jeu);
			 if (!is_null($row)){ echo 'Vous avez déjà un jeu actif.';} else {?>
		<form action='' method="post" >
			 <p>
			 	<label>Titre du jeu:</label> <input id="titre_jeu" name="titre_jeu" type="text" /> </br>
			 	<label>Description:</label></br> 
			 	<textarea id="description_jeu" name="description_jeu"> </textarea></br>
			 	<label>Ancre:</label>
			 	<input id="ancre_jeu" name="ancre_jeu" type="text" /></br>
			  	<input type="submit" value="Ajouter"/>
			 </p>
		</form>
		<?php }?>
		<h2>Ajouter une faction</h2>
		<form method="post" action="">
			 <p>
			 	<label>Nom de la faction</label> <input id="titre_faction" name="titre_faction" type="text" /> </br>
			 	<label>Description:</label></br> 
			 	<textarea id="description_faction" name="description_faction"> </textarea></br>
			 	<label>Ancre:</label>
			 	<input id="ancre_faction" name="ancre_faction"  type="text" /></br>
			 	<input type="submit" value="Ajouter" />
			 </p> 
		</form>
		
		<h2>Ajouter une collection</h2>
		<form method="post" action="">
			 <p>
			 	<label>Nom de la collection:</label> <input id="titre_collection" name="titre_collection" type="text" /> </br>
			 	<label>Description:</label></br> 
			 	<textarea id="description_collection" name="description_collection"> </textarea></br>
			 	<label>Ancre:</label> 
			 	<input id="ancre_collection" name="ancre_collection" type="text"/></br>
			 	<input type="submit" value="Ajouter" />
			 </p>	 
		</form>
		
		<h2>Ajouter un type</h2>
		<form method="post" action="">
			<p>
				<label>Titre:</label> <input id="titre_type" name="titre_type" type="text" /> </br>
				<label>Description:</label></br> 
				<textarea id="description_type" name="description_type"> </textarea></br>
			 	<label>Ancre:</label> 
			 	<input id="ancre_type" name="ancre_type" type="text" /></br>
				<input type="submit" value="Ajouter" />
			</p> 
		</form>
		
		<h2>Ajouter une caracteristique</h2>
		<form method="post" action="">
			 <p> 
			 	<label>Nom:</label> <input id="titre_caracteristique" name="titre_caracteristique" type="text" /> </br>
			 	<label>Description:</label></br> 
			 	<textarea id="description_caracteristique" name="description_caracteristique"> </textarea></br>
			 	<label>Ancre:</label> 
			 	<input id="ancre_caracteristique" name="ancre_caracteristique" type="text" /></br>
			 	<input type="submit" value="Ajouter" />
			 </p> 
		</form>
		
		<h2>Ajouter un mot clée</h2>
		<form method="post" action="">
			 <p>
			 	<label>Nom:</label> <input id="titre_mot_clee" name="titre_mot_clee" type="text" /> </br>
			 	<label>Description:</label></br> 
			 	<textarea id="description_mot_clee" name="description_mot_clee"> </textarea></br> 
			 	<label>Ancre:</label> 
			 	<input id="ancre_keyword" name="ancre_keyword" type="text" /></br>
			 	<input type="submit" value="Ajouter" />
			 </p> 
		</form>
		<?php
	
	}
	
	public function ajout_html()
	{
		global $wpdb;
		echo '<h1>'.get_admin_page_title().'</h1>';
		$req_jeu="SELECT * FROM {$wpdb->prefix}jeu";
		$row= $wpdb->get_row($req_jeu);
		if (is_null($row)){ ?>
		
		<p>Vous n'avez pas configurer le plugin encore.</p>
		<?php }else{
			$aff_jeu = $wpdb->get_results($req_jeu);
			foreach ($aff_jeu as $jeu){ ?>
			
		<form method="post" action="" >
			<p>
			<h2><?php echo $jeu->nom;}?></h2></br>
			Nom: <input id="nom_entite" name="nom_entite" type="text" /></br>
			
			<!-- Faction -->
			<?php 
			$req_faction="SELECT * FROM {$wpdb->prefix}faction";
			$aff_faction = $wpdb->get_results($req_faction);?>
			Faction: <select id="faction_entité" name="faction_entité"><?php foreach ($aff_faction as $faction){ ?><option value="<?php echo $faction->id_faction;?>"><?php echo $faction->nom;?></option><?php }?></select></br>
			
			<!-- Type -->
			<?php $req_type="SELECT * FROM {$wpdb->prefix}type";
			$aff_type = $wpdb->get_results($req_type);?>
			Type:<select id="type_entité" name="type_entité">
			<?php foreach ($aff_type as $type){?>
			<option value="<?php echo $type->id_type;?>"><?php echo $type->nom;?></option><?php }?></select></br>
			
			<!-- Collection -->
			<h3>Collection</h3>
			<?php $req_collection="SELECT * FROM {$wpdb->prefix}collection";
			$aff_collection = $wpdb->get_results($req_collection);?>
			<select id="collection_entité" name="collection_entité">
			<?php foreach ($aff_collection as $collection){?>
			<option value="<?php echo $collection->id_collection;?>" > <?php echo $collection->nom;?> </option><?php }?>
			</select></br>
			
			<!-- Caractéristique -->
			<h3>Caractéristique</h3>
			<?php $req_caracteristique="SELECT * FROM {$wpdb->prefix}caracteristique"; 
			$aff_caracteristique = $wpdb->get_results($req_caracteristique);
				foreach ($aff_caracteristique as $caracteristique){?>
			<label><?php echo $caracteristique->Nom;?></label> <input id="<?php echo $caracteristique->ancre_caracteristique;?>" name="<?php echo $caracteristique->ancre_caracteristique;?>" type="text" />
			</br><?php 
			}?>
			
			<!-- Keyword -->
			<h3>Mot clées</h3>
			<?php $req_keyword="SELECT * FROM {$wpdb->prefix}keyword";
			$aff_keyword = $wpdb->get_results($req_keyword);
			foreach ($aff_keyword as $keyword){?>
			 <input type="checkbox" name="<?php echo $keyword->ancre_keyword;?>" value="<?php echo $keyword->id_keyword;?>" 
			 		id="<?php echo $keyword->ancre_keyword;?>" /> <label ><?php echo $keyword->nom;?></label><?php }?><br />
			 <h3>Capacitées</h3>		
			<textarea id="capacitee_piece" name="capacitee_piece"> </textarea></br>
			<h3>Texte d'ambiance</h3>		
			<textarea id="text-ambiance" name="text-ambiance"> </textarea>
			</p>
		<input type="submit" value="Ajouter l'entité"/>
		</form>

		<?php	}
	}
	
	public function visualiser_html()
	{
		global $wpdb;
		
		echo '<h1>'.get_admin_page_title().'</h1>';
		?>
		<h2>Le jeu</h2>
		<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<?php 
			$req_jeu="SELECT * FROM {$wpdb->prefix}jeu";
			$row= $wpdb->get_row($req_jeu);
			if (is_null($row)){ ?>
			
				</table>
				<p>Il n'y a auncun titre d'enregistré.</p> 
				
			<?php
			 }else{
			$aff_jeu = $wpdb->get_results($req_jeu);?>
			
		<tbody>
		<?php foreach ($aff_jeu as $jeu){ ?>
			<tr>
				<td><?php echo $jeu->nom;?></td>
				<td><?php echo $jeu->description;?></td>
				<td>
				<form method="post" action="">
    				<button type="submit" id="supprimer_jeu" name="supprimer_jeu" onclick="return confirm('Êtes-vous certain de vouloir effacer définitivement cette nouvelle ?')"  value="<?php echo $jeu->id_jeu;?>">Effacer</button>
    				<button type="submit" id="modifier_jeu" name="modifier_jeu" value="<?php echo $jeu->id_jeu;?>">Editer</button>
				</form>
				</td>
			</tr>
			<?php }?>
		</tbody>
		<?php }?>
		</table>
		
		<h2>Les Factions</h2>
		<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<?php 
		
			$req_faction="SELECT * FROM {$wpdb->prefix}faction";
			$row1= $wpdb->get_row($req_faction);
			
			if (is_null($row1)){ ?>
				</table>
				<p>Il n'y a aucune faction d'enregistrée.</p> 
				
			<?php 
			
		 	}else{
		 	
		 	$aff_faction = $wpdb->get_results($req_faction);?>
		<tbody>
		<?php foreach ($aff_faction as $faction){?>
			<tr>
				<td><?php echo $faction->nom;?></td>
				<td><?php echo $faction->description;?></td>
				<td><form method="post" action="">
    				<button type="submit" id="supprimer_faction" name="supprimer_faction" onclick="return confirm('Êtes-vous certain de vouloir effacer définitivement cette nouvelle ?')" value="<?php echo $faction->id_faction;?>">Effacer</button>
    				<button type="submit" id="modifier_faction" name="modifier_faction" value="<?php echo $faction->id_faction;?>">Editer</button>
				</form></td>
			</tr>
			<?php }?>
		</tbody>
		<?php }?>
		</table>
		
		<h2>Les Collections</h2>
		
		<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<?php 
			$req_collection="SELECT * FROM {$wpdb->prefix}collection";
			
			$row2= $wpdb->get_row($req_collection);
			if (is_null($row2)){ ?>
						</table>
						<p>Il n'y a aucune collection d'enregistrée.</p> 
							
						<?php 
						
					 }else{
			$aff_collection = $wpdb->get_results($req_collection);?>
			
		
		<tbody>
		<?php foreach ($aff_collection as $collection){?>
			<tr>
				<td><?php echo $collection->nom;?></td>
				<td><?php echo $collection->description;?></td>
				<td><form method="post" action="">
    				<button type="submit" id="supprimer_collection" name="supprimer_collection" onclick="return confirm('Êtes-vous certain de vouloir effacer définitivement cette nouvelle ?')" value="<?php echo $collection->id_collection;?>">Effacer</button>
    				<button type="submit" id="modifier_collection" name="modifier_collection" value="<?php echo $collection->id_collection;?>">Editer</button>
				</form></td>
			</tr>
			<?php }?>
		</tbody>
		</table>
		<?php }?>
		<h2>Les Types</h2>
		
		<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<?php 
			$req_type="SELECT * FROM {$wpdb->prefix}type";

			$row3= $wpdb->get_row($req_type);
			if (is_null($row3)){ ?>
									</table>
									<p>Il n'y a aucun type d'enregistrée.</p> 
										
									<?php 
									
								 }else{
								 	
			$aff_type = $wpdb->get_results($req_type);?>
			
		
		<tbody>
		<?php foreach ($aff_type as $type){?>
			<tr>
				<td><?php echo $type->nom;?></td>
				<td><?php echo $type->description;?></td>
				<td><form method="post" action="">
    				<button type="submit" id="supprimer_type" name="supprimer_type" onclick="return confirm('Êtes-vous certain de vouloir effacer définitivement cette nouvelle ?')" value="<?php echo $type->id_type;?>">Effacer</button>
    				<button type="submit" id="modifier_type" name="modifier_type" value="<?php echo $type->id_type;?>">Editer</button>
				</form></td>
			</tr>
			<?php }?>
		</tbody>
		</table>
		<?php }?>
		<h2>Les caracteristiques</h2>
		
		<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<?php 
			$req_caracteristique="SELECT * FROM {$wpdb->prefix}caracteristique";
			
			$row4= $wpdb->get_row($req_caracteristique);
			if (is_null($row4)){ ?>
												</table>
												<p>Il n'y a aucune caracteristique d'enregistrée.</p> 
													
												<?php 
												
											 }else{
			$aff_caracteristique = $wpdb->get_results($req_caracteristique);?>
		<tbody>
		<?php foreach ($aff_caracteristique as $caracteristique){?>
			<tr>
				<td><?php echo $caracteristique->Nom;?></td>
				<td><?php echo $caracteristique->description;?></td>
				<td><form method="post" action="">
    				<button type="submit" id="supprimer_caracteristique" name="supprimer_caracteristique" onclick="return confirm('Êtes-vous certain de vouloir effacer définitivement cette nouvelle ?')" value="<?php echo $type->id_caracteristique;?>">Effacer</button>
    				<button type="submit" id="modifier_caracteristique" name="modifier_caracteristique" value="<?php echo $type->id_caracteristique;?>">Editer</button>
				</form></td>
			</tr>
			<?php }?>
		</tbody>
		</table>
		<?php }?>
		<h2>Les mots clée</h2>
		
		<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<?php 
			$req_keyword="SELECT * FROM {$wpdb->prefix}keyword";
			
			$row5= $wpdb->get_row($req_keyword);
			if (is_null($row5)){ ?>
				
				</table><p>Il n'y a aucun mot clée d'enregistré.</p> 
				
				<?php }else{
					
						$aff_keyword = $wpdb->get_results($req_keyword);?>
						
		<tbody>
		<?php foreach ($aff_keyword as $keyword){?>
			<tr>
				<td><?php echo $keyword->nom;?></td>
				<td><?php echo $keyword->description;?></td>
				<td><form method="post" action="">
    				<button type="submit" id="supprimer_keyword" name="supprimer_keyword" onclick="return confirm('Êtes-vous certain de vouloir effacer définitivement cette nouvelle ?')" value="<?php echo $keyword->id_keyword;?>">Effacer</button>
    				<button type="submit" id="modifier_keyword" name="modifier_keyword" value="<?php echo $keyword->id_keyword;?>">Editer</button>
				</form></td>
			</tr>
			<?php }?>
		</tbody>
		</table>
	
		<?php  }
		
	}
}

new Liste_armee();