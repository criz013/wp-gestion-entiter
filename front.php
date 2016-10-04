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
	{?>
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
  			</tr>
		</thead>
 		<tbody>
  			<tr>
    			<td>Row 1: Col 1</td>
    			<td>Row 1: Col 2</td>
  			</tr>
  		</tbody>
</table>

	<?php }
	
}