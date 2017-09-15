<?php
// module/Fichiers/src/Fichiers/Model/Fichiers.php:
namespace Fichiers\Model;

class Fichiers{

	protected $id;
	protected $chemin;
	protected $nom;
	protected $type;
	protected $libelle;
        protected $thumbnailPath;
        protected $thumbnail;
        protected $metaData;


        public function __construct(){}
		
	//first hydrator strategy
	public static function fromArray($row) {
            $instance = new self();
            $instance->exchangeArray($row);
	
            return $instance;
	}
	/*
	public static function fromForm($row) {
		$instance = new self();
    	$instance->exchangeForm($row);
		//print_r($instance);
		//exit;
    	return $instance;
	}
	*/
	private function exchangeArray($data){
		
		if(isset($data['fichiers_id'])){
			$this->setId($data['fichiers_id']);
		}
		if(isset($data['fichiers_chemin'])){
			$this->setChemin($data['fichiers_chemin']);  
		}
		if(isset($data['fichiers_nom'])){
			$this->setNom($data['fichiers_nom']);  
		}
		if(isset($data['fichiers_type'])){
			$this->setType($data['fichiers_type']);  
		}
		if(isset($data['fichiers_libelle'])){
			$this->setLibelle($data['fichiers_libelle']);  
		}
                if(isset($data['fichiers_meta'])){
			$this->setMetadata($data['fichiers_meta']);  
		}
                if(isset($data['fichiers_thumbnailpath'])){
			$this->setThumbnailpath($data['fichiers_thumbnailpath']);  
		}
                if(isset($data['fichiers_thumbnail'])){
			$this->setThumbnail($data['fichiers_thumbnail']);  
		}
	}
	
	public function setId($_id){
		$this->id = $_id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setChemin($_chemin){
		$this->chemin = $_chemin;
	}
	
	public function getChemin(){
		return $this->chemin;
	}
	
	public function setNom($_nom){
		$this->nom = $_nom;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function setLibelle($_libelle){
		$this->libelle=$_libelle;
	}
	
	public function getLibelle(){
		return $this->libelle;
	}
        
        public function getMetaData(){
		return $this->metaData;
	}
	
	public function setMetaData($_metaData){
		$this->metaData=$_metaData;
	}
	
	public function getType(){
		return $this->type;
	}
        
        public function setType($_type){
		$this->type=$_type;
	}
        
        public function setThumbnailpath($_thumbnailpath){
		$this->thumbnailPath=$_thumbnailpath;
	}
	
	public function getThumbnailpath(){
		return $this->thumbnailPath;
	}
        
        public function setThumbnail($_thumbnail){
		$this->thumbnail=$_thumbnail;
	}
	
	public function getThumbnail(){
		return $this->thumbnail;
	}
	
	// Add the following method:
	public function getArrayCopy(){
		return get_object_vars($this);
	}
		
}