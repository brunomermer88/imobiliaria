<?php

declare(strict_types=1);

namespace Cadastros\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use Cadastros\Model\Imovel;
use Cadastros\Model\ImovelTable;
use Laminas\Session\Container;

class ImovelController extends AbstractActionController
{
    private $imovelTable;
    
    public function __construct(ImovelTable $imovelTable)
    {
        $this->imovelTable = $imovelTable;
    }
    
    public function indexAction()
    {
        $imoveis = $this->imovelTable->listar();        
        return new ViewModel([
            'imoveis' => $imoveis
        ]);
    }
    
    public function editarAction()
    {
        if ($this->flashMessenger()->hasMessages()){
            $sessionContainer = new Container();
            $imovel = $sessionContainer->imovel;
        } else {
            $matricula = (int) $this->params('matricula');
            $imovel = $this->imovelTable->buscar($matricula);
        }
        
        $messages = $this->flashMessenger()->getMessages();
        $this->flashMessenger()->clearMessages();
        
        return new ViewModel([
            'imovel' => $imovel,
            'messages' => implode(',',$messages)
        ]);
    }
    
    public function gravarAction()
    {
        $imovel = new Imovel($_POST);
        if (!$imovel->valido()){
            $this->flashMessenger()->addMessage('Dados inválidos');
            $sessionContainer = new Container();
            $sessionContainer->imovel = $imovel;
            return $this->redirect()->toRoute('cadastros',[
                'controller' => 'imovel',
                'action'     => 'editar'
            ]);
        }
        
        $this->imovelTable->gravar($imovel);
        
        return $this->redirect()->toRoute('cadastros',[
            'controller' => 'imovel',
            'action'     => 'index'
        ]);
    }
    
    public function apagarAction()
    {
        $matricula = (int) $this->params('matricula');
        $this->imovelTable->apagar($matricula);
        return $this->redirect()->toRoute('cadastros',[
            'controller' => 'imovel',
            'action'     => 'index'
        ]);
    }
    
    
    
    
    
    
    
    
    
}
