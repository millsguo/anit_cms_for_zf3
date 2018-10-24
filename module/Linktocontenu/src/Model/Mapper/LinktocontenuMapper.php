<?php

namespace Linktocontenu\Model\Mapper;

use Linktocontenu\Model\Linktocontenu as LinkedContent;

/**
 * Class LinktocontenuMapper
 * @package Linktocontenu\Model\Mapper
 */
class LinktocontenuMapper
{
    /**
     * @param $data
     * @return LinkedContent
     */
    public function exchangeArray($data) {

        $linkedContent = new LinkedContent();

        if (isset($data['id'])) {
            $linkedContent->setId($data['id']);
        }
        if (isset($data['contenuobj'])) {
            $linkedContent->setContenu($data['contenuobj']);
        }
        if (isset($data['position'])) {
            $linkedContent->setRang($data['position']);
        }
        if (isset($data['title'])) {
            $linkedContent->setTitre($data['title']);
        }
        if (isset($data['subtitle'])) {
            $linkedContent->setSousTitre($data['subtitle']);
        }
        /*
        if (isset($data['page'])){
            $linkedContent->setRubrique($data['page']);
        }
         *
         */
        if (isset($data['section'])) {
            $linkedContent->setSousrubrique($data['section']);
        }
        if (isset($data['html'])) {
            $linkedContent->setContenuHtml($data['html']);
        }
        if (isset($data['image'])) {
            $linkedContent->setImage($data['image']);
        }
        if (isset($data['image2'])) {
            $linkedContent->setImage2($data['image2']);
        }
        if(isset($data['type'])){
            $linkedContent->setType($data['type']);
        }

        if (isset($data['linktopage'])) {
            $linkedContent->setLinktopage($data['linktopage']);
        }
        if (isset($data['linktosection'])) {
            $linkedContent->setLinktosection($data['linktosection']);
        }

        return $linkedContent;
    }
}