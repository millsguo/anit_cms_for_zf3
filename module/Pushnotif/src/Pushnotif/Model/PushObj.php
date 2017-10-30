<?php

namespace Pushnotif\Model;

class PushObj {

    /**
     * Type du Push
     * simple ou deep
     * Type string
     */
    public $type = 'simple';

    /**
     * Message du Push
     * Type string
     */
    public $message = '';

    /**
     * Numero du badge
     * Type int
     */
    public $badge = 1;

    /**
     * Son à jouer lors de l'affichage de la notification
     * Type string
     */
    public $sound = 's.aiff';

    /**
     * Type de push profond
     * Type int
     */
    public $deepDestination = 0;

    /**
     * Critères suplementaire pour les push profond
     * Type array
     */
    public $deepCriteres = array(
        0 => '', //Push Simple
        // Push profond : Vacance : Résultat de recherche
        1 => array(
            'EN' => '', //Environnement
            'RG' => '', //Region
            'HT' => '', //accom
            'TL' => '', //dwell
            'EQ' => '', //equip
            'PT' => '', //accueil
        ),
        // Push profond : Vacance : Fiche séjour
        2 => array(
            'stayId' => '', //Code sejour
            'season' => '', //Saison
            'year' => '', //Annee
        ),
        // Push profond : Journal : Actualités rubrique
        3 => array(
            'page' => 1, //Page de la rubrique
            'count' => 20, //Nombre d'article a afficher
            'tag_slug' => '', //Nom de la rubrique
        ),
        // Push profond : Journal : Article
        4 => array(
            'page' => 1, //Page de la rubrique
            'count' => 1, //Nombre d'article a afficher
            'tag_slug' => '', //Nom de la rubrique
            'postid' => '', //Identifiant de la rubrique
        ),
    );

    /**
     * Création du contenu du Message pour Android
     * Sur Android le message contient la liste des devices.
     * return JSon
     */
    public function getAndroidMsg($devicesToken = array()) {
        if (empty($devicesToken)) {
            return true;
            die('Il n`\'y a pas de devices Android enregistré');
        }
        // UPDATE deviceregistration SET device_type = 1

        $fields = array(
            'registration_ids' => $devicesToken,
            'data' => array(
                'aps' => array(
                    'alert' => $this->message
                )
            ),
        );

        if ($this->type == 'deep') {
            $fields['data']['acme'] = array(
                $this->deepDestination,
                $this->deepCriteres[$this->deepDestination]
            );
        }

        return json_encode($fields);
    }

    /**
     * Création du contenu du Message pour iOS
     * return JSon
     */
    public function getiOSMsg() {
        $body = array(
            'aps' => array(
                'badge' => 1,
                'alert' => $this->message,
                'sound' => 's.aiff'
            ),
        );

        if ($this->type == 'deep') {
            $body['acme'] = array(
                $this->deepDestination,
                $this->deepCriteres[$this->deepDestination]
            );
        }

        return json_encode($body);
    }

    /**
     * Hydrate l'objet
     */
    public function hydrate($p) {

        $this->setPushType($p['pushType']);
        $this->setMessage($p['message']);

        if ($p['pushType'] == 'deep') {
            $critieria = array();

            switch ($p['pushDestination']) {

                // Push profond : Vacance : Résultat de recherche
                case 1:
                    $this->deepDestination = 1;
                    //Environnement
                    if(!empty($p['d1Environ'])){
                        $this->deepCriteres[1]['EN'] = implode(',', $p['d1Environ']);
                    }
                    else{
                        $this->deepCriteres[1]['EN'] = "";
                    }
                    //Region
                    if(!empty($p['d1Region'])){
                        $this->deepCriteres[1]['RG'] = implode(',', $p['d1Region']);
                    }
                    else{
                        $this->deepCriteres[1]['RG'] = "";
                    }
                    //accom
                    if(!empty($p['d1Accom'])){
                        $this->deepCriteres[1]['HT'] = implode(',', $p['d1Accom']);
                    }
                    else{
                        $this->deepCriteres[1]['HT'] = "";
                    }
                    //dwell
                    if(!empty($p['d1Taille'])){
                        $this->deepCriteres[1]['TL'] = abs((int) $p['d1Taille']);
                    }
                    else{
                        $this->deepCriteres[1]['TL'] = "";
                    }
                    //equip
                    if(!empty($p['d1Equip'])){
                        $this->deepCriteres[1]['EQ'] = implode(',', $p['d1Equip']);
                    }
                    else{
                        $this->deepCriteres[1]['EQ'] = "";
                    }
                    //accueil
                    if(!empty($p['d1Accueil'])){
                        $this->deepCriteres[1]['PT'] = implode(',', $p['d1Accueil']);
                    }
                    else{
                        $this->deepCriteres[1]['PT'] = "";
                    }
                    break;

                // Push profond : Vacance : Fiche séjour
                case 2:
                    $this->deepDestination = 2;
                    //Annee
                    $this->deepCriteres[2]['year'] = abs((int) $p['d2Annee']);
                    //Saison
                    $this->deepCriteres[2]['season'] = $p['d2Saison'];
                    //Code sejour
                    $this->deepCriteres[2]['stayId'] = $p['d2Identifiant'];
                    break;

                // Push profond : Journal : Actualités rubrique
                case 3:
                    $this->deepDestination = 3;
                    $this->deepCriteres[3]['tag_slug'] = $p['d3Theme'];
                    break;

                // Push profond : Journal : Article
                case 4:
                    $this->deepDestination = 4;
                    $this->deepCriteres[4]['page'] = $p['d4Position']; //Page de la rubrique
                    $this->deepCriteres[4]['tag_slug'] = $p['d4Theme'];
                    break;

                default:
                    die('Destination invalide');
                    break;
            }

            return true;
        }
    }

    /**
     * Specifi le type de Push
     * deep : Push Profond
     * simple : Push simple
     */
    public function setPushType($type = 'simple') {
        switch ($type) {
            case 'simple' :
                $this->type = 'simple';
                return true;
            case 'deep' :
                $this->type = 'deep';
                return true;
        }

        die('Type de push inconnu ' . __FILE__ . ' (' . __LINE__ . ')');
    }

    /**
     * Specifi le Message du Push
     *
     */
    public function setMessage($Msg) {
        if (!empty($Msg)) {
            $this->message = $Msg;
            return true;
        }

        die('Le message du push ne peux pas être vide ' . __FILE__ . ' (' . __LINE__ . ')');
    }

}
