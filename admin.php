<?php 

class administration
{
	

	public function __construct(){?>
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
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<?php 
	}
	
	
}