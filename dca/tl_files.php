<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   ProperFilenames
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2017 numero2 - Agentur für Internetdienstleistungen
 */


/**
 * Add fields to tl_files
 */
$GLOBALS['TL_DCA']['tl_files']['fields']['name']['save_callback'][] = array('\numero2\ProperFilenames\CheckFilenames','sanitizeFileOrFolderName');