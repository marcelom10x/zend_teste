<?php

namespace Categoria\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 * 
 * @ORM\Table(name"category")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Categoria\Entity\CategoryRepository")
 */
class Category {
    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;
    /**
     * Get id
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Get nome
     * 
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * 
     * @param type string
     * 
     * @return Category
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }
}


