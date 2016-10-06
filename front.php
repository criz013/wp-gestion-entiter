<?php 
/**
 * 
 * @author Christophe Bautista
 *
 */


class front{
	
	public function __construct()
	{
		add_shortcode('liste_entiter', array($this, 'front_html'));
	}
	
	public function front_html()
	{
		global $wpdb;
		$req_entiter = "SELECT * From {$wpdb->prefix}piece";
		$result = $wpdb->get_results($req_entiter);
	
		?>
			<fieldset>
			<legend>Filtres</legend>
			<select id="" ><option value="">Faction</option ></select>
			<select id="" ><option value="">Collection</option ></select>
			<select id="" ><option value="">Type</option ></select>
			<select id="" ><option value="">Keyword</option ></select>
			<select id="" ><option value="">Caracteristique</option ></select>
			<input type="submit" value="Filtrer"/>
			</fieldset>
			
			<table>
				<thead> 
					<tr>
						<th>Nom</th>
						<th>Faction</th>
						<th>Collection</th>
						<th>Type</th>
						<th>Caractéristique</th>
						<th>Keyword</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($result as $piece){ ?>
					<tr>
						<td><?php echo $piece->nom;?></td>
						<td><?php echo $this->liste_faction($piece->id_faction);?></td>
						<td><?php echo $this->liste_collection($piece->id_collection);?></td>
						<td><?php echo $this->liste_type($piece->id_type);?></td>
						<td><?php
						$type = $this->liste_carac($piece->id_piece);
						//print_r($type);
						foreach ($type as $r){
							echo $r.' / '; 
						}
						?></td>
						<td><?php $type = $this->liste_keyword($piece->id_piece);
						//print_r($type);
						foreach ($type as $r){
							echo $r.' / '; 
						}?></td>
						<td><form method="post" action="">
	    				<button type="submit" id="supprimer_entiter" name="supprimer_entiter" onclick="return confirm('Êtes-vous certain de vouloir effacer définitivement cette nouvelle ?')"  value="<?php echo $piece->id_piece;?>">Effacer</button>
	    				<button type="submit" id="modifier_entiter" name="modifier_entiter" value="<?php echo $piece->id_piece;?>">Editer</button>
					</form></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<?php 
			
		}
		
		public function liste_faction($id_faction){
			global $wpdb;
			$result_sql = $wpdb->get_results("SELECT nom FROM {$wpdb->prefix}faction WHERE id_faction ={$id_faction}");
			foreach ($result_sql as $t)
			{
			return $t->nom;
			}
		}
		
		public function liste_collection($id_collection){
			global $wpdb;
			$result_sql = $wpdb->get_results("SELECT nom FROM {$wpdb->prefix}collection WHERE id_collection ={$id_collection}");
			foreach ($result_sql as $t)
			{
				return $t->nom;
			}
		}
		
		public function liste_type($id_type){
			global $wpdb;
			$result_sql = $wpdb->get_results("SELECT nom FROM {$wpdb->prefix}type WHERE id_type ={$id_type}");
			foreach ($result_sql as $t)
			{
				return $t->nom;
			}
		}
		
		public function liste_carac($id_piece)
		{
			global $wpdb;
			$i=0;
			$result_piececarac = $wpdb->get_results("SELECT id_caracteristique, valeur FROM {$wpdb->prefix}piececarac WHERE id_piece ={$id_piece}");
			
			foreach ($result_piececarac as $t)
			{
				$req_carac = $wpdb->get_results("SELECT nom FROM {$wpdb->prefix}caracteristique WHERE id_caracteristique ={$t->id_caracteristique}");
				
				foreach ($req_carac as $s)
				{
					
				 		$resultat[$i] = $s->nom.':'.$t->valeur; 
				 		$i++;
					
				}
				
			}
			return $resultat;
		}
		
		public function liste_keyword($id_piece)
		{
			global $wpdb;
			$i=0;
			$result_piecekey = $wpdb->get_results("SELECT id_keyword, valeur FROM {$wpdb->prefix}piecekeyword WHERE id_piece ={$id_piece}");
		
			foreach ($result_piecekey as $t)
			{
				$req_carac = $wpdb->get_results("SELECT nom FROM {$wpdb->prefix}keyword WHERE id_keyword ={$t->id_keyword}");
		
				foreach ($req_carac as $s)
				{
					$resultat[$i] = $s->nom.':'.$t->valeur;
					$i++;
				}
			}
			return $resultat;
		}
	
}