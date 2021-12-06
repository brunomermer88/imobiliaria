<?php
namespace Cadastros\Model;

use Application\Model\ModelInterface;
use Laminas\Filter\FilterChain;
use Laminas\I18n\Filter\Alpha;
use Laminas\Filter\StringToUpper;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\StringLength;
use Laminas\I18n\Validator\Alpha as AlphaValidator;

class Imovel implements ModelInterface
{
    public $matricula;
    public $descricao;
    public $valor;
    
    public function __construct(array $data){
       $this->exchangeArray($data);
    }
    
    public function exchangeArray(array $data)
    {
        $this->matricula = (int)($data['matricula'] ?? 0);
        $descricao = (string)($data['descricao'] ?? '');
        $this->valor = ($data['valor'] ?? '');
        $filterChain = new FilterChain();
        $filterChain->attach(new StringToUpper());
        $this->descricao = $filterChain->filter(trim($descricao));
    }
    
    public function toArray()
    {
        $attributes = get_object_vars($this);

        // print_r($attributes);

        if ($attributes['matricula'] == 0){
            unset($attributes['matricula']);
        }
        return $attributes;
    }
    
    public function valido(): bool
    {

        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new StringLength(['max' => 200]));
        return $validatorChain->isValid($this->descricao);
    }    
}

