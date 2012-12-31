<?php 

namespace ThingyCore\Models;

use ThingyCore\Debug;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

abstract class Model {
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;
    /**
     * @var Repository
     */
    protected $_repo;
    protected $_tableId = 'm';
    
    public function __construct() {
        $config = Setup::createAnnotationMetadataConfiguration(
            array( THINGY_CORE_DIR . '/Thingy/Models/' ),
            THINGY_DEVEL );
        $this->_em = EntityManager::create($GLOBALS['connections']['default'],
            $config);
        $this->_repo = $this->_em->getRepository( get_class($this) );
    }
    
    public function __call( $method, $args ) {
        if( substr( $method, 0, 6 ) == 'findBy' ) {
            $by = strtolower( substr( $method, 6 ) );
            return $this->_repo->findOneBy( array( $by => $args[0] ) );
        }
    }
    
    public function findByNameAndAncestors( $pieces ) {

        // Work our way up the page heirarchy
        $pieces = array_reverse( $pieces );
        $name = array_shift( $pieces );
        
        // get the partially constructed QueryBuilder
        $qb = $this->selectFrom();
            
        foreach( $pieces as $k => $parent ) {
            $alias = ( $k == 0 )
                ? $this->_tableId
                : $this->_tableId . $k;
            $joinAlias = $this->_tableId . ($k+1);
            $foreign = "$alias.parent";
            $on = "$joinAlias.id = $alias.parent"
                . " AND $joinAlias.name = '$parent'";
            $qb = $qb->innerJoin( $foreign, $joinAlias, 'WITH', $on );
        }
        
        $result = $qb->where( "{$this->_tableId}.name = ?1" )
            ->setParameter( 1, $name )
            ->getQuery()
            ->getResult();
        
        return $result[0];
    }
    
    public function prepare() {
        $data = array();
        foreach( $this->_columns as $v ) {
            if( ! isset( $this->$v ) ) {
                Debug::error( "Attempting to access null property: $v" );
            }
            $data[$v] = $this->$v;
        }
        return $data;
    }
    
    /**
     * Get the partially built QueryBuilder, with SELECT and FROM
     */
    protected function selectFrom() {
        $from = get_class( $this );
        return $qb = $this->_em->createQueryBuilder()
            ->select( $this->_tableId )
            ->from( $from, $this->_tableId );
    }
} 

?>