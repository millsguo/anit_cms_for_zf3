<?php

namespace Contenu\Model;

use Sousrubrique\Model\Sousrubrique;
use Contenu\Model\IContenu;
use Contenu\Model\Mapper\ContenuMapper as Mapper;

class Contenu implements IContenu{

    protected $id;
    protected $titre;
    protected $soustitre;
    protected $sousrubrique;
    protected $contenuhtml;
    protected $rang;
    protected $image;
    protected $image2;
    protected $type;
   
    public function __construct() {
        
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setTitre($_titre) {
        $this->titre = $_titre;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setSousTitre($_soustitre) {
        $this->soustitre = $_soustitre;
    }

    public function getSousTitre() {
        return $this->soustitre;
    }

    //public function setSousRubrique(SousRubrique $_sousrubrique) {
    public function setSousRubrique(SousRubrique $_sousrubrique) {
        $this->sousrubrique = $_sousrubrique;
    }

    public function getSousRubrique() {
        return $this->sousrubrique;
    }
    
    public function getContenuHtml() {
        return $this->contenuhtml;
    }

    public function setContenuHtml($_contenuhtml) {
        $this->contenuhtml = $_contenuhtml;
    }

    public function getRang() {
        return $this->rang;
    }

    public function setRang($_rang) {
        $this->rang = $_rang;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($_image) {
        $this->image = $_image;
    }
    
    public function getImage2() {
        return $this->image2;
    }

    public function setImage2($_image2) {
        $this->image2 = $_image2;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($_type){
        $this->type = $_type;
    }
    
    public function sortByPosition($collection, $order){
        /*
        usort($collection, array(__CLASS__, "rankComparison"));
        return $collection;
         * */
        
        if ($order !== 'desc' && $order !== 'asc') {
            return false;
        }
        
        usort($collection, function($a, $b) use ($order) {
            //var_dump((int)$a->getRang().' '.(int)$b->getRang());
            
            if($a instanceof IContenu && $b instanceof IContenu){
                
                if($order === "asc"){
                    //Rank below 0 means content is not displayed so it means
                    //in the back office they have to be the last items in a list
                    if((int)$b->getRang() < 0){
                        $b->setRang("987654321098765432109876543210");
                    }
                    elseif((int)$a->getRang() < 0){
                        $a->setRang("987654321098765432109876543210");
                    }
                    
                    //if rank is equal sort by title
                    if ((int)$a->getRang() == (int)$b->getRang()){
                        return (strcmp($a->getTitre(), $b->getTitre())); 
                    }
                    else{
                        return ((int)$a->getRang() < (int)$b->getRang()) ? -1 : 1;
                    }
                }
                elseif($order === "desc"){
                    if ((int)$a->getRang() == (int)$b->getRang()){
                        return (strcmp($b->getTitre(), $a->getTitre())); 
                    }

                    return ((int)$b->getRang() < (int)$a->getRang()) ? -1 : 1;
                }
            }
            else{
                //var_dump($a);
                //var_dump($b);
            }
            
        });
        $count = 0;
        foreach ($collection as $item){
            //Except in this function who will put this value ? set -1 wher
            if(strcmp($collection[$count]->getRang(), "987654321098765432109876543210")==0){
                $collection[$count]->setRang("-1");
            }
            
            $count++;
        }
        
        return $collection;
         
    }
    /*
    private function rankComparison($a, $b){
        //if rank is equal sort by title
        if ($a->getRang() == $b->getRang()){
            return (strcmp($a->getTitre(), $b->getTitre())); 
        }
            
        return ($a->getRang() < $b->getRang()) ? -1 : 1;
       
    }*/
}
