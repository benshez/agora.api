<?php

namespace Agora\Bundles\Pages\Controller;

use Agora\Modules\Base\Controller\BaseController;
use Agora\Bundles\Pages\Interfaces\IPagesController;

class Controller extends BaseController implements IPagesController
{
	const REFERENCE_OBJECT = 'name';
	const REFERENCE = 'pages';
}
