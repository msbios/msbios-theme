<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package MSBios\Theme\Controller
 */
class IndexController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function blogAction()
    {
        return new ViewModel();
    }

    /**
     * @return ViewModel
     */
    public function viewAction()
    {
        return new ViewModel([
            'id' => $this->params()->fromRoute('id'),
            'slug' => $this->params()->fromRoute('slug')
        ]);
    }
}
