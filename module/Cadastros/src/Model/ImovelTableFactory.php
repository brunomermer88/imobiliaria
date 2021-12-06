<?php
namespace Cadastros\Model;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;

class ImovelTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Imovel([]));
        $tableGateway = new TableGateway('imoveis', $adapter, null, $resultSetPrototype);
        $imovelTable = new ImovelTable($tableGateway);
        return $imovelTable;
    }

}

