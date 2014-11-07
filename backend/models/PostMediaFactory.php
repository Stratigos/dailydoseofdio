<?php
/*******************************************************************
* factory class to facilitate instancing a new Post's media object
********************************************************************/
namespace backend\models;

class PostMediaFactory {
    /**
     * @todo DOCUMENT
     */
    public static function instantiatePostMedia($media_type)
    {
        // TODO - CHECK FIRST THAT CLASS EXISTS
        if($media_type) {
            $classname = 'common\\models\\' . ucfirst($media_type);
            return new $classname;
        }
        return NULL;        
    }
}