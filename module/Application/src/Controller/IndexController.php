<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\Usuario;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{
    private $dbAdapter;
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function loginAction()
    {
        $usuario = new Usuario($_POST);
        if ($usuario->autenticado($this->dbAdapter)){
            return $this->redirect()->toRoute('cadastros');
        }
        return $this->redirect()->toRoute('home');
    }
    
    public function logoutAction()
    {
        $authenticationService = new AuthenticationService();
        $authenticationService->clearIdentity();
        return $this->redirect()->toRoute('home');        
    }
    
    
    
    
    public function aboutAction()
    {
        $this->layout('cebolinha/outrolayout');
        $viewModel = new ViewModel();
        $viewModel->setTemplate('cebolinha/outraaction');
        return $viewModel;
    }    
}
