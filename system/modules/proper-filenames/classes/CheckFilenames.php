<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   ProperFilenames
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2015 numero2 - Agentur für Internetdienstleistungen
 */


/**
 * Namespace
 */
namespace numero2\ProperFilenames;


class CheckFilenames extends \Frontend {


    protected $search = '';


    public function renameFiles( $arrFiles ) {

        if( !$GLOBALS['TL_CONFIG']['checkFilenames'] )
            return null;

        $this->Import( 'Files' );
        $this->Import( 'FilesModel' );

        if( !empty($arrFiles) ) {

            foreach( $arrFiles as $file ) {

                // rename physical file
                $newFile = $this->replaceForbiddenCharacters( $file );
                $this->Files->rename( $file, $newFile );

                // rename file in database
                $objFile = \FilesModel::findByPath($file);
                $objFile->path = $newFile;
                $objFile->hash = md5_file(TL_ROOT . '/' . $newFile);
                $objFile->save();
            }
        }
    }


    protected function replaceForbiddenCharacters( $strFile ) {

        $info = pathinfo( $strFile );

        $newFilename = substr( $info['filename'], 0, 32 );
        $newFilename = standardize( \String::restoreBasicEntities( $newFilename ) );
        $newFilename = $this->replaceUnderscores( $newFilename );

        return $info['dirname'] . '/' . $newFilename . '.' . strtolower( $info['extension'] );
    }


    protected function replaceUnderscores( $strFilename ) {

        $newFilename = str_replace( "__", "_", $strFilename );

        if( $newFilename != $strFilename ) {
            $newFilename = $this->replaceUnderscores( $newFilename );
        }

        return $newFilename;
    }
}