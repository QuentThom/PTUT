<?php

echo '<table style="width:100%">
  <tr>
    <th>Numero facture</th>
    <th>Nom facture</th>
    <th>Etat facture</th>
  </tr>';

 foreach($facture as $factures) {
     echo '
     <tr>
        <td>' . $factures->id . '</td>
        <td>' . $factures->nom . '</td>
        <td>' . $factures->etat . '</td>
        <td>' . $this->Html->link('Supprimer', ['controller' => 'factures', 'action' => 'delete', $factures->id],
             ['class' => 'button', 'title' => 'Validation facture']).
         $this->Html->link('Modifier', ['controller' => 'factures', 'action' => 'modif', $factures->id],
             ['class' => 'button', 'title' => 'Modifier facture']).'</td>        
    </tr>';
 }

echo'</table>';

echo $this->Html->link('Retour',['controller'=>'Adherents','action'=> 'affiche'],['class'=>'button','title'=>'revenir à l\'affiche des adherents']);
