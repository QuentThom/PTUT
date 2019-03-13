<?php
/**
 * Created by PhpStorm.
 * User: p1701300
 * Date: 19/12/2018
 * Time: 15:08
 */

namespace App\Controller;


class ActivitiesController extends AppController
{

    //ajouter une activité
    public function add()
    {
        $activite = $this->Activities->newEntity();
        if (!empty($this->getRequest()->getData())) {
            $activite = $this->Activities->newEntity($this->getRequest()->getData());
            /*if($activite->jour != null)
                $activite->jour = $this->convertListeString($activite->jour);
            if($activite->typeSeance != null)
                $activite->typeSeance = $this->convertListeTypeSeance($activite->typeSeance);*/
            if ($this->Activities->save($activite)) {
                $this->Flash->success(__('Votre activité a été sauvegardé.'));
                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('Impossible d\'ajouter votre activité.'));
            }
        }
        $this->set(compact('activite'));
    }

    //ajouter une activité exceptionnelle
    public function addExceptionnel()
    {
        $activite = $this->Activities->newEntity();
        if (!empty($this->getRequest()->getData())) {
            $activite = $this->Activities->newEntity($this->getRequest()->getData());
            /* if($activite->typeSeance != null)
                 $activite->typeSeance = $this->convertListeTypeSeance($activite->typeSeance);*/
            if ($this->Activities->save($activite)) {
                $this->Flash->success(__('Votre activité a été sauvegardé.'));
                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('Impossible d\'ajouter votre activité.'));
            }
        }
        $this->set(compact('activite'));
    }

    //convertir la liste jours semaine
    private function convertListeString($var)
    {
        switch ($var) {
            case 0:
                return 'lundi';
            case 1:
                return 'mardi';
            case 2:
                return 'mercredi';
            case 3:
                return 'jeudi';
            case 4:
                return 'vendredi';
            case 5:
                return 'samedi';
            case 6:
                return 'dimanche';
        }
    }

    //conversion liste séance
    private function convertListeTypeSeance($var)
    {
        switch ($var) {
            case 0:
                return 'Forfait';
            case 1:
                return 'Séance';
        }
    }

    //affichage activités
    public function affiche()
    {
        $link = new ActivitiesAdherentsController();
        $activites = $this->Activities->find('all');
        $this->set(compact('activites', 'total', 'link'));
    }

    //modifier des activités
    public function edit($id = null)
    {
        $activite = $this->Activities->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Activities->patchEntity($activite, $this->request->getData());
            if ($activite->jour != null)
                $activite->jour = $this->convertListeString($activite->jour);
            if ($activite->typeSeance != null)
                $activite->typeSeance = $this->convertListeTypeSeance($activite->typeSeance);
            if ($this->Activities->save($activite)) {
                $this->Flash->success('Activitée modifié avec succès !');
                return $this->redirect(['action' => 'affiche']);
            }
            $this->Flash->error('Erreur lors de la mise à jour !');
        }
        $this->set('activiteEdit', $activite);
    }

    //modifier des activités exceptionnelles
    public function editExceptionnel($id = null)
    {
        $activite = $this->Activities->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Activities->patchEntity($activite, $this->request->getData());
            if ($activite->typeSeance != null)
                $activite->typeSeance = $this->convertListeTypeSeance($activite->typeSeance);
            if ($this->Activities->save($activite)) {
                $this->Flash->success('Activitée modifié avec succès !');
                return $this->redirect(['action' => 'affiche']);
            }
            $this->Flash->error('Erreur lors de la mise à jour !');
        }
        $this->set('activiteEdit', $activite);
    }

    //suppression d'une activité
    public function delete($id = null)
    {
        $activite = $this->Activities->get($id);
        if ($this->Activities->delete($activite)) {
            $this->Flash->success("L'activite a été supprimé avec succès !");
            return $this->redirect(['action' => 'affiche']);
        } else {
            $this->Flash->error("Une erreur est survenue lors de la suppression !");
        }
    }


    public function inscrireAdherents($idAct = null, $idAdh = null)
    {
        $adherents = $this->Activities->Adherents->find();
        $activite = $this->Activities->get($idAct);
        $adherent = $this->Activities->Adherents->get($idAdh);
        $this->Activities->Adherents->link($adherent, [$activite]);
        $this->set(compact('activite','adherents'));
    }

    public function viewAdherents($idAct = null)
    {
        $adherents = $this->Activities->Adherents->find();
        $activite = $this->Activities->get($idAct);
        $this->set(compact('activite','adherents'));
    }

    //affichage participation aux activités
    public function afficheParticipation($idAct = null)
    {
        $id = new ActivitiesAdherentsController();
        $link = $id->affiche($idAct);
        $adherents = $this->Activities->Adherents->find();

        $this->set(compact('adherents', 'link'));

    }

}