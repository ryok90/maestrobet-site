<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * This is the main controller class of the Blog application. The 
 * controller class is used to receive user input,  
 * pass the data to the models and pass the results returned by models to the 
 * view for rendering.
 */
class IndexController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * Recent Posts page containing the recent blog posts.
     */
    public function indexAction() 
    {
        $this->layout('layout/layout-home');
        return new ViewModel();
    }

    public function sobreAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        return new ViewModel();
    }
}
