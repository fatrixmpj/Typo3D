<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
	$_EXTKEY,
	'pi1/class.tx_automaketemplate_pi1.php',
	'_pi1',
	'',
	1
);