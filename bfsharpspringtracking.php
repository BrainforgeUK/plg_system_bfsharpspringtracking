<?php
/**
 * @package    SharpSpring tracking plugin by BrainforgeUK
 * @author    https://www.brainforge.co.uk
 * @copyright  (C) 2020 Jonathan Brain. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;

defined('_JEXEC') or die('Restricted access');

class plgSystemBfsharpspringtracking extends CMSPlugin
{
	public function onAfterRender()
	{
		$app = Factory::getApplication();

		if ($app->isClient('administrator')) {
			return;
		}

		$user = Factory::getUser();
		if ($user->get('isRoot'))
		{
			return;
		}

		$js = '
<script type="text/javascript">
    var _ss = _ss || [];
    _ss.push([\'_setDomain\', \'' . trim($this->params->get('domain')) . '\']);
    _ss.push([\'_setAccount\', \'' . trim($this->params->get('account')) . '\']);
    _ss.push([\'_trackPageView\']);
(function() {
	var ss = document.createElement(\'script\');
	ss.type = \'text/javascript\'; ss.async = true;
	ss.src = \'' . trim($this->params->get('clientssscript')) . '\';
	var scr = document.getElementsByTagName(\'script\')[0];
	scr.parentNode.insertBefore(ss, scr);
})();
</script>
';

		$body = $app->getBody();
		$body = str_replace('</body>', $js . '</body>', $body);
		$app->setBody($body);
	}
}
